<?php

namespace App\Http\Controllers;

use App\Http\Utility\SendMail;
use App\Service\SmsService;
use App\Models\AndroidApi;
use App\Models\AndroidApiSimInfo;
use App\Models\SMSlog;
use App\Models\Subscription;
use App\Models\GeneralSetting;
use App\Models\EmailLog;
use Carbon\Carbon;
use App\Jobs\ProcessEmail;
use App\Jobs\ProcessWhatsapp;
use App\Models\Campaign;
use App\Models\CampaignContact;
use App\Models\CreditLog;
use App\Models\EmailCreditLog;
use App\Models\Import;
use App\Models\MailConfiguration;
use App\Models\SmsGateway;
use App\Models\User;
use App\Models\WhatsappCreditLog;
use App\Models\WhatsappDevice;
use App\Models\WhatsappLog;
use Illuminate\Support\Arr;
class CronController extends Controller
{

    public $smsService ;
    public function __construct(SmsService $smsService)
    {
        $this->smsService = $smsService;
    }

    public function run()
    {
        $setting = GeneralSetting::first();

        $this->unlinkImportFile();
        $this->getewayCheck();
        $this->androidApiSim();

        $this->subscription();
        if(Carbon::parse($setting->schedule_at)->addMinute(30) < Carbon::now()){
            $setting->schedule_at = Carbon::now();
        }
        $setting->cron_job_run = Carbon::now();
        $setting->save();
        $this->campaignSchedule();
        $this->emailSchedule();
        $this->smsSchedule();
    }


    public function campaignSchedule(){

        $campaigns = Campaign::with(['contacts','schedule'])
            ->where('status','Active')
            ->orWhere('status','Completed')
            ->get();

        $onCampaigns = Campaign::where('status','Ongoing')->get();
        foreach($onCampaigns as $campaign){
            $contacts = CampaignContact::where('campaign_id',$campaign->id)->where('status','Processing')->count();
            if( $contacts == 0){
                $campaign->status = 'Completed';
                $campaign->save();
            }
        }

        $this->processCampaign($campaigns);

    }

    public function processCampaign($campaigns){

        foreach($campaigns as $campaign){
            $expiredTime = $campaign->schedule_time;
            $now = Carbon::now()->toDateTimeString();

            if ($now >= $expiredTime &&  $campaign->status != 'Ongoing') {
                if($campaign->status =='Completed' && !$campaign->schedule){
                    continue;
                }
                if($campaign->chanel == 'Email'){
                    $this->processEmailCampaign($campaign);
                }
                elseif($campaign->chanel == 'Sms'){
                    $this->processSmsCampaign($campaign);
                }
                else{
                    $this->processWhatsappCampaign($campaign);
                }
                $campaign->last_corn_run = Carbon::now();
                $campaign->status = 'Ongoing';
                $campaign->save();
            }

            if($campaign->schedule){
                $days = self::getRepeatDay($campaign->schedule);
                $rescheduleDate = Carbon::now()->addDays($days);
                $campaign->schedule_status = 'Later';
                $campaign->schedule_time =  $rescheduleDate ;
                $campaign->save();
            }
        }
    }


    public function processWhatsappCampaign($campaign){

        $contacts = CampaignContact::where('campaign_id',$campaign->id)->get();
        $general = GeneralSetting::first();

        $wordLenght = $general->whatsapp_word_count;

        $flag = 1;
        $whatsappGateway = WhatsappDevice::whereNull("user_id")->where('status', 'connected')->pluck('delay_time','id')->toArray();
        if($campaign->user_id){
            $user = User::where('id',$campaign->user_id)->first();
            if($user){
                $whatsappGateway = WhatsappDevice::where('user_id', $user->id)->where('status', 'connected')->pluck('delay_time','id')->toArray();
                $messages = str_split($campaign->message,$wordLenght);
                $totalMessage = count($messages);
                $totalNumber = count($contacts);
                $totalCredit = $totalNumber * $totalMessage;
                if($totalCredit > $user->whatsapp_credit){
                    $flag = 0;
                    $campaign->status = 'Active';
                    $campaign->save();
                    $mailCode = [
                        'type' => $campaign->chanel,
                        'name' => $campaign->name,
                        'credit_balance' => $user->whatsapp_credit,
                    ];
                    SendMail::MailNotification($user,'INSUFFICIENT_CREDIT',$mailCode);
                }
                else{
                    $user->whatsapp_credit -=  $totalCredit;
                    $user->save();
                    $creditInfo = new  WhatsappCreditLog();
                    $creditInfo->user_id = $user->id;
                    $creditInfo->type = "-";
                    $creditInfo->credit = $totalCredit;
                    $creditInfo->trx_number = trxNumber();
                    $creditInfo->post_credit =  $user->whatsapp_credit;
                    $creditInfo->details = $totalCredit." credits were cut for " .$totalNumber . " number send message";
                    $creditInfo->save();
                }
            }
        }

        if(count($whatsappGateway) == 0){
            $flag = 0;
        }

        if($flag == 1){
            $setWhatsAppGateway =  $whatsappGateway;
            $i = 1; $addSecond = 10;$gateWayid = null;
            $postData = [];
            if(count(json_decode($campaign->post_data,true))){
                $postData = json_decode($campaign->post_data,true);
            }
            foreach($contacts  as $contact){

                if(filter_var($contact->contact, FILTER_SANITIZE_NUMBER_INT)){

                    foreach ($setWhatsAppGateway as $key => $appGateway){
                        $addSecond = $appGateway * $i;
                        $gateWayid = $key;
                        unset($setWhatsAppGateway[$key]);
                        if(empty($setWhatsAppGateway)){
                            $setWhatsAppGateway =  $whatsappGateway;
                            $i++;
                        }
                        break;
                    }
                    $log = new WhatsappLog();
                    $log->user_id = $campaign->user_id;

                    if(count($whatsappGateway) > 0){
                        $log->whatsapp_id =  $gateWayid;
                    }
                    $log->to = $contact->message;
                    $log->contact_id = $contact->id;
                    $log->campaign_id = $campaign->id;
                    $log->initiated_time = Carbon::now() ;

                    $log->message = preg_replace('/[^0-9]/', '', trim(str_replace('+', '', $contact->contact)));
                    $log->word_length  = $wordLenght;
                    $log->status = 1;
                    $log->schedule_status = 1;
                    $log->save();

                    dispatch(new ProcessWhatsapp($log->message,  $log->to , $log->id, $postData));

                }
            }
        }


    }


    public function processEmailCampaign($campaign){

        $contacts = CampaignContact::where('campaign_id',$campaign->id)->get();
        $general = GeneralSetting::first();
        $emailMethod = MailConfiguration::where('id',$general->email_gateway_id)->first();
        $flag = 1;
        if($campaign->user_id){
            $user = User::where('id',$campaign->user_id)->first();
            if($user){
                if(count($contacts) > $user->email_credit ){
                    $campaign->status = 'Active';
                    $campaign->save();
                    $flag = 0;
                    $mailCode = [
                        'type' => $campaign->chanel,
                        'name' => $campaign->name,
                        'credit_balance' => $user->email_credit,
                    ];
                    SendMail::MailNotification($user,'INSUFFICIENT_CREDIT',$mailCode);
                }
                else{
                    $user->email_credit -= count($contacts);
                    $user->save();

                    $emailCredit = new EmailCreditLog();
                    $emailCredit->user_id = $user->id;
                    $emailCredit->type = "-";
                    $emailCredit->credit = count($contacts);
                    $emailCredit->trx_number = trxNumber();
                    $emailCredit->post_credit =  $user->email_credit;
                    $emailCredit->details = count($contacts)." credits were cut for send email";
                    $emailCredit->save();
                }
            }
        }

        if($flag == 1){
            foreach($contacts  as $contact){
                $emailLog = new EmailLog();
                $emailLog->user_id = $campaign->user_id;
                $emailLog->contact_id = $contact->id;
                $emailLog->sender_id = $emailMethod->id;
                $emailLog->from_name = $campaign->from_name;
                $emailLog->reply_to_email = $campaign->reply_to_email;
                $emailLog->to = $contact->contact;
                $emailLog->message = $contact->message;
                $emailLog->subject = $campaign->subject;
                $emailLog->status = 2;
                $emailLog->schedule_status = 2;
                $emailLog->initiated_time = Carbon::now();
                $emailLog->save();
                $contact->status = "Processing";
                $contact->save();
            }
        }

    }


    public function processSmsCampaign($campaign){

        $contacts = CampaignContact::where('campaign_id',$campaign->id)->get();
        $flag = 1;
        $general = GeneralSetting::first();
        $wordLenght = $campaign->sms_type == "plain" ? $general->sms_word_text_count : $general->sms_word_unicode_count;
        $smsGateway = SmsGateway::where('id', $general->sms_gateway_id)->first();
        if($campaign->user_id){
            $user = User::where('id',$campaign->user_id)->first();
            if($user){
                $messages = str_split($campaign->message,$wordLenght);
                $totalMessage = count($messages);

                $totalNumber = count($contacts);
                $totalCredit = $totalNumber * $totalMessage;

                if($totalCredit > $user->credit){
                    $campaign->status = 'Active';
                    $campaign->save();
                    $flag = 0;
                    $mailCode = [
                        'type' => $campaign->chanel,
                        'name' => $campaign->name,
                        'credit_balance' => $user->credit,
                    ];
                    SendMail::MailNotification($user,'INSUFFICIENT_CREDIT',$mailCode);
                }
                else{
                    $user->credit -=  $totalCredit;
                    $user->save();
                    $creditInfo = new CreditLog();
                    $creditInfo->user_id = $user->id;
                    $creditInfo->credit_type = "-";
                    $creditInfo->credit = $totalCredit;
                    $creditInfo->trx_number = trxNumber();
                    $creditInfo->post_credit =  $user->credit;
                    $creditInfo->details = $totalCredit." credits were cut for " .$totalNumber . " number send message";
                    $creditInfo->save();
                }

                $smsGatewayId = Arr::get((array)$user->gateways_credentials, 'sms.default_gateway_id', 1);
                $smsGateway = SmsGateway::where('id', $smsGatewayId)->first();
            }
        }
        if(!$smsGateway ){
            $flag = 0;
        }

        if($flag == 1){
            foreach($contacts  as $contact){
                if(filter_var($contact->contact, FILTER_SANITIZE_NUMBER_INT)){
                    $log = new SMSlog();

                    $log->campaign_id = $campaign->id;
                    $log->contact_id = $contact->id;
                    if($campaign->user_id){
                        $user = User::where('id',$campaign->user_id)->first();
                        if($user->sms_gateway == 1){
                            $log->api_gateway_id = $smsGateway->id;
                        }
                    }
                    else{
                        if($general->sms_gateway == 1){
                            $log->api_gateway_id = $smsGateway->id;
                        }
                    }

                    $log->sms_type = $campaign->sms_type == "plain" ? 1 : 2;
                    $log->user_id = $campaign->user_id;
                    $log->word_length = $wordLenght;
                    $log->to = preg_replace('/[^0-9]/', '', trim(str_replace('+', '', $contact->contact)));
                    $log->initiated_time =  Carbon::now() ;

                    $log->message = $contact->message;
                    $log->status = 2;
                    $log->schedule_status = 2;
                    $log->save();
                    $contact->status = "Processing";
                    $contact->save();

                }

            }
        }

    }


    public static function getRepeatDay($schedule){
        if($schedule->repeat_format == 'day'){
            return $schedule->repeat_number;
        }
        if($schedule->repeat_format == 'month'){
            return days_in_month(date('m'),date('Y')) * $schedule->repeat_number;
        }
        if($schedule->repeat_format == 'year'){
            return days_in_year() * $schedule->repeat_number;
        }
    }





    protected function androidApiSim(){
        $smslogs = SMSlog::whereNull('api_gateway_id')->whereNull('android_gateway_sim_id')->where('status', 1)->get();
        foreach ($smslogs as $key => $smslog) {
            $androidSimInfos = [];
            $androidApis = [];

            if($smslog->user_id){
                $androidApis = AndroidApi::where('status', 1)->where('user_id', $smslog->user_id)->pluck('id')->toArray();
                $androidSimInfos = AndroidApiSimInfo::whereIn('android_gateway_id', $androidApis)->where('status', 1)->pluck('id')->toArray();
            }

            if(is_null($smslog->user_id)){
                $androidApis = AndroidApi::where('status', 1)->whereNotNull('admin_id')->pluck('id')->toArray();
                $androidSimInfos = AndroidApiSimInfo::whereIn('android_gateway_id', $androidApis)->where('status', 1)->pluck('id')->toArray();
            }

            if(!empty($androidSimInfos)){
                $smslog->android_gateway_sim_id = $androidSimInfos[array_rand($androidSimInfos,1)];
                $smslog->save();
            }
        }

    }

    public function unlinkImportFile(){
        $imports = Import::where('status',1)->get();
        foreach($imports  as $import){
            if(unlink(('assets/file/import/'.$import->path))){
                $import->delete();
            }
        }
    }

    protected function getewayCheck(){
        $smslogs = SMSlog::whereNotNull('android_gateway_sim_id')->where('status', 1)->get();
        foreach ($smslogs as $key => $smslog) {
            if (isset($smslog->androidGateway)) {
                if($smslog->androidGateway->status == 2){
                    $smslog->android_gateway_sim_id = null;
                    $smslog->save();
                }
            }
        }
    }


    protected function subscription()
    {
        $subscriptions = Subscription::where('status',1)->get();
        foreach($subscriptions as $subscription){
            $expiredTime = $subscription->expired_date;
            $now = Carbon::now()->toDateTimeString();
            if($now > $expiredTime){
                $subscription->status = 2;
                $subscription->save();
            }
        }
    }

    protected function smsSchedule()
    {
        $smslogs = SMSlog::where('status', 2)->where('schedule_status', 2)->get();
        $general = GeneralSetting::first();

        foreach($smslogs as $smslog){
            $expiredTime = $smslog->initiated_time;
            $now = Carbon::now()->toDateTimeString();
            if($now > $expiredTime){
                if($general->sms_gateway == 1){
                    $this->smsService->sendSmsByOwnGateway($smslog);
                }else{
                    $smslog->status = 1;
                    $smslog->api_gateway_id = null;
                    $smslog->android_gateway_sim_id = null;
                }
                $smslog->save();
            }
        }

        $pendingsmslogs = SMSlog::where('status', 1)->get();

        foreach($pendingsmslogs as $pendingsms){
            if($general->sms_gateway == 1){
                $this->smsService->sendSmsByOwnGateway($pendingsms);
            }else{
                $pendingsms->status = 1;
                $pendingsms->api_gateway_id = null;
            }
            $pendingsms->save();
        }
    }

    protected function emailSchedule()
    {
        $emailLogs = EmailLog::where('status', 2)->where('schedule_status', 2)->get();
        foreach($emailLogs as $emailLog){
            $expiredTime = $emailLog->initiated_time;
            $now = Carbon::now()->toDateTimeString();
            if($now > $expiredTime){
                ProcessEmail::dispatch($emailLog->id);
            }
        }
    }

}
