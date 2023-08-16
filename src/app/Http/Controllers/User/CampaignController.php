<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\CampaignContact;
use App\Models\CampaignSchedule;
use App\Models\Contact;
use App\Models\CreditLog;
use App\Models\EmailContact;
use App\Models\EmailCreditLog;
use App\Models\EmailGroup;
use App\Models\EmailLog;
use App\Models\GeneralSetting;
use App\Models\Group;
use App\Models\Subscription;
use App\Models\Template;
use App\Models\WhatsappCreditLog;
use App\Rules\MessageFileValidationRule;
use App\Service\FileProcessService;
use Illuminate\Http\Request;

class CampaignController extends Controller
{
        /**
     * get all Campaign
     */
    public function index()
    {
        $chanel = null;
        if(request()->routeIs('user.campaign.sms')){
            $chanel = 'Sms';
        }
        elseif(request()->routeIs('user.campaign.email')){
            $chanel = 'Email';
        }
        else{
            $chanel = 'Whatsapp';
        }
        
    
        $campaigns = Campaign::where('user_id',auth()->user()->id)->with('contacts')->where("chanel",$chanel)->paginate(paginateNumber());

        return view('user.campaign.index',[
            'campaigns' =>  $campaigns ,
            'title' =>  $chanel.translate(' Campaign') ,
            'chanel' =>  $chanel ,
        ]);

    }


    /**
     * get all contacts by campaign id
     * @param $id
     */
    public function contactDelete(Request $request)
    {
       $campaignContact = CampaignContact::where('id',$request->id)->first();
       if($campaignContact){
         $campaignContact->delete();
       }

       $notify[] = ['success', translate('Contact Deleted From Campaigns')];
       return back()->withNotify($notify);
       
    }

    /**
     * create a specific campaign
     * @return void
     */
    public function create($chanel)
    {
        $templates = [];
        if($chanel == 'email'){
            $groups = EmailGroup::where('user_id',auth()->user()->id)->get();
        }
        else{
            $templates = Template::where('user_id',auth()->user()->id)->get();
            $groups = Group::where('user_id',auth()->user()->id)->get();
        }
    
        return view('user.campaign.create',[
            'title' =>   ucfirst($chanel).translate(' Campaign Create') ,
            'chanel' =>  ucfirst($chanel) ,
            'groups' =>  $groups,
            'templates' =>  $templates,
        ]);
    }

    /**
     * store a specific campaign
     *
     * @return void
     */
    public function store(Request $request)
    {
        $attachableData = self::processRelationalData($request);
        if(count($attachableData['contacts']) == 0){
            $notify[] = ['error', translate('Select Some Audience!! Then Try Again ')];
            return back()->withNotify($notify);
        }
        
        $rule =null;
        $message  = null;
        if($request->hasFile('document')){
            $message = 'document';
            $rule = ['required', new MessageFileValidationRule('document')];
        } else if($request->hasFile('audio')){
            $message = 'audio';
            $rule = ['required', new MessageFileValidationRule('audio')];
        } else if($request->hasFile('image')){
            $message = 'image';
            $rule = ['required', new MessageFileValidationRule('image')];
        } else if($request->hasFile('video')){
            $message = 'video';
            $rule = ['required', new MessageFileValidationRule('video')];
        }

        $rules = [
            "message" => "required",
            'name'=>'required|unique:campaigns,name',
            'chanel' => 'required|in:Email,Sms,Whatsapp',
            'schedule_date' => 'required|date',
            'repeat_number' => 'required|numeric',
            'subject' => 'required_if:chanel,Email',
            'smsType' => 'required_if:chanel,Sms',
            'repeat_format' => 'required|in:year,month,day',
        ];
        if( $rule && $message){
            $rules [$message] = $rule;
            $rules ['message'] = [];
        }


        $totalContacts = array_unique($attachableData['contacts']);
        $user = auth()->user();
        $subscription = Subscription::where('user_id',$user->id)->where('status','1')->get();

        if(count($subscription) == 0){
            $notify[] = ['error', 'Your Subscription Is Expired! Buy A New Plan'];
            return back()->withNotify($notify);
        }
        $general = GeneralSetting::first();

        if($request->chanel == 'Email'){
            if(count( $totalContacts) > $user->email_credit){
                $notify[] = ['error', 'You do not have a sufficient email credit for send mail'];
                return back()->withNotify($notify);
            }
          
        }
        if($request->chanel == 'Sms'){

            $wordLenght = $request->smsType == "plain" ? $general->sms_word_text_count : $general->sms_word_unicode_count;
    
            $messages = str_split($request->message,$wordLenght);
            $totalMessage = count($messages);
    
            $totalNumber = count($totalContacts);
            $totalCredit = $totalNumber * $totalMessage;
    
            if($totalCredit > $user->credit){
                $notify[] = ['error', 'You do not have a sufficient credit for send message'];
                return back()->withNotify($notify);
            }
    
        }
        if($request->chanel == 'Whatsapp'){
            $wordLenght = $general->whatsapp_word_count;

            $messages = str_split($request->message,$wordLenght);
            $totalMessage = count($messages);
            $totalNumber = count($totalContacts);
            $totalCredit = $totalNumber * $totalMessage;

            if($totalCredit > $user->whatsapp_credit){
                $notify[] = ['error', 'You do not have a sufficient credit for send message'];
                return back()->withNotify($notify);
            }
    
        }

        if($request->file){
            $extension = strtolower($request->file->getClientOriginalExtension());
            if(!in_array($extension, ['csv','xlsx'])){
                $notify[] = ['error', 'Invalid file extension'];
                return back()->withNotify($notify);
            }
        }


        $request->validate($rules);
        $postData = $this->whatsappFile($request);
        $campaign = new Campaign();
        $campaign->user_id = auth()->user()->id;
        $campaign->name = $request->name;
        $campaign->chanel = $request->chanel;
        $campaign->body = $request->message;
        $campaign->subject = $request->subject;
        $campaign->sms_type = $request->smsType;
        $campaign->from_name = $request->from_name;
        $campaign->post_data = json_encode($postData);
        $campaign->reply_to_email = $request->reply_to_email;
        $campaign->status = 'Active';
        $campaign->schedule_time =  $request->schedule_date;
        $campaign->save();
        if($request->repeat_number){
           $this->createCampaignSchedule($request,$campaign->id);
        }
        $attachableData = self::insertContacts( $attachableData ,$campaign);

        $notify[] = ['success', translate('Campaign Created Successfully')];
        return back()->withNotify($notify);
    }

    public  function insertContacts($attachableData,$campaign){

        $contactNewArray = array_unique($attachableData['contacts']);
        $groupName = $attachableData['contact_with_name'];
        $data = [];
        foreach($contactNewArray as $key => $value) {
            $content = $campaign->body;
            if(array_key_exists($value,$groupName)){
                $content  = str_replace('{{name}}', $groupName ? $groupName[$value]:$value, $content);
            }
            $arr = array(
                'campaign_id'  =>$campaign->id,
                'contact'  => $value,
                'message'  =>  $content,
            );
            array_push($data, $arr);

        }
        $campaignContact = CampaignContact::insert($data);
    }

    public  function createCampaignSchedule($request,$campaignId){
        $campaignSchedule = new CampaignSchedule();
        $campaignSchedule->campaign_id = $campaignId;
        $campaignSchedule->repeat_number = $request->repeat_number;
        $campaignSchedule->repeat_format = $request->repeat_format;
        $campaignSchedule->save();
    }


    public static function processRelationalData($request)
    {
  
        $groupName = []; $contacts = [];
        if( $request->group){
            if($request->chanel == 'Email'){
                $group = EmailContact::where('user_id',auth()->user()->id)->whereIn('email_group_id', $request->group)->pluck('email')->toArray();
                $groupName = EmailContact::where('user_id',auth()->user()->id)->whereIn('email_group_id', $request->group)->pluck('name','email')->toArray();
                array_push($contacts, $group);
            }
            else{
    
                $group = Contact::where('user_id',auth()->user()->id)->whereIn('group_id', $request->group)->pluck('contact_no')->toArray();
                $groupName = Contact::where('user_id',auth()->user()->id)->whereIn('group_id', $request->group)->pluck('name','contact_no')->toArray();
                array_push($contacts, $group);
            }
        }
      
        if($request->has('file')){
            $service = new FileProcessService();
            $extension = strtolower($request->file->getClientOriginalExtension());
            if(!in_array($extension, ['csv','xlsx'])){
                $notify[] = ['error', 'Invalid file extension'];
                return back()->withNotify($notify);
            }
            if($extension == "csv"){
                $response =  $service->processCsv($request->file);
           
                array_push($contacts,array_keys($response[0]));
                if($request->chanel == 'Email'){
                    $groupName = array_merge($groupName, $response[0]);
                }
                else{
                    $groupName = $groupName +  $response[0];
                }
            
            };

            if($extension == "xlsx"){
                $response =  $service->processExel($request->file);
                array_push($contacts,array_keys($response[0]));
                if($request->chanel == 'Email'){
                    $groupName = array_merge($groupName, $response[0]);
                }
                else{
                    $groupName = $groupName +  $response[0];
                }
            }
        }
        $contactNewArray = [];
        foreach($contacts as $childArray){
            foreach($childArray as $value){
                $contactNewArray[] = $value;
            }
        }
        return [
            "contacts" => $contactNewArray,
            "contact_with_name" => $groupName,
        ];
    }



    /**
     *  get a specific Campaign template json
     * @param $id
     *
     */
    public function search(Request $request)
    {
        $request->validate([
            "chanel" => 'required',
        ]);
        $search = $request->search;
        $chanel = $request->chanel;
        $searchStatus = null;
        $campaigns =  Campaign::where('user_id',auth()->user()->id)->where('chanel',$request->chanel);
        if( $search){
            $campaigns = $campaigns->where('name',"like","%".$search."%");
        }
 
        if($request->status){
            $searchStatus = $request->status;
            $campaigns = $campaigns->where('status',$searchStatus ) ;
        }
        $campaigns = $campaigns->paginate(paginateNumber());
        return view('user.campaign.index',[
            'campaigns' =>  $campaigns ,
            'title' =>  $chanel.translate(' Campaign Search') ,
            'chanel' =>  $chanel ,
            'search' =>  $search ,
            'searchStatus' =>  $searchStatus ,
        ]);
    }


    /**
     *  edit a specific Campaign
     * @param $id
     *
     */
    public function edit($id)
    {
        $campaign = Campaign::where('user_id',auth()->user()->id)->with("schedule")->with('contacts')->where('id',$id)->first();

        $templates = [];
        if($campaign->chanel == 'Email'){
            $groups = EmailGroup::where('user_id',auth()->user()->id)->get();
        }
        else{
            $templates = Template::where('user_id',auth()->user()->id)->get();
            $groups = Group::where('user_id',auth()->user()->id)->get();
        }
        return view('user.campaign.edit',[
            'title' => 'Update Campaign' ,
            'campaign' => $campaign ,
            'chanel' => $campaign->chanel ,
            'groups' => $groups ,
            'templates' => $templates ,
      ]);
    }


    /**
     *  Preview a Specific Campaign
     * @param $id
     *
     */
    public function contacts($id)
    {
        $title = 'Campaign Contact List';
        $campaign = Campaign::with('contacts')->where('id',$id)->first();
        $contacts = CampaignContact::where('campaign_id',$id)->paginate(paginateNumber());
        return view('user.campaign.show',[
              'title' => $title ,
              'contacts' => $contacts,
              'campaign' => $campaign 
        ]);
    }
   
    
    /**
     *  update a specific sms gatway
     *
     * @return void
     */
    public function update(Request $request)
    {
        $attachableData = self::processRelationalData($request);

        $rule = null;
        $message  = null;
        if($request->hasFile('document')){
            $message = 'document';
            $rule = ['required', new MessageFileValidationRule('document')];
        } else if($request->hasFile('audio')){
            $message = 'audio';
            $rule = ['required', new MessageFileValidationRule('audio')];
        } else if($request->hasFile('image')){
            $message = 'image';
            $rule = ['required', new MessageFileValidationRule('image')];
        } else if($request->hasFile('video')){
            $message = 'video';
            $rule = ['required', new MessageFileValidationRule('video')];
        }

        $rules = [
            'id'=>'required',
            'message'=>'required',
            'name'=>'required|unique:campaigns,name,'.$request->id,
            'chanel' => 'required|in:Email,Sms,Whatsapp',
            'schedule_date' => 'required|date',
            'repeat_number' => 'required|numeric',
            'subject' => 'required_if:chanel,Email',
            'smsType' => 'required_if:chanel,Sms',
            'repeat_format' => 'required|in:year,month,day',
        ];

        if( $rule && $message){
            $rules [$message] = $rule;
            $rules ['message'] = [];
        }

        $totalContacts = array_unique($attachableData['contacts']) ;
   
        $user = auth()->user();
        $subscription = Subscription::where('user_id',$user->id)->where('status','1')->get();

        if(count($subscription) == 0){
            $notify[] = ['error', 'Your Subscription Is Expired! Buy A New Plan'];
            return back()->withNotify($notify);
        }
        $general = GeneralSetting::first();
        $campaign = Campaign::with(["schedule",'contacts'])->where('user_id',auth()->user()->id)->where('id',$request->id)->first();

        if($request->chanel == 'Email'){
            
            if(count($totalContacts) > $user->email_credit){
                $notify[] = ['error', 'You do not have a sufficient email credit for send mail'];
                return back()->withNotify($notify);
            }
          
        }
        if($request->chanel == 'Sms'){

            $wordLenght = $request->smsType == "plain" ? $general->sms_word_text_count : $general->sms_word_unicode_count;
            $messages = str_split($request->message,$wordLenght);
            $totalMessage = count($messages);
            $totalNumber = count($totalContacts) !=0 ? count($totalContacts) : $campaign->contacts->count() ;
            $totalCredit = $totalNumber * $totalMessage;
    
            if($totalCredit > $user->credit){
                $notify[] = ['error', 'You do not have a sufficient credit for send message'];
                return back()->withNotify($notify);
            }
    
        }
        if($request->chanel == 'Whatsapp'){
            $wordLenght = $general->whatsapp_word_count;

            $messages = str_split($request->message,$wordLenght);
            $totalMessage = count($messages);
            $totalNumber = count($totalContacts) !=0 ? count($totalContacts) : $campaign->contacts->count();
            $totalCredit = $totalNumber * $totalMessage;
            if($totalCredit > $user->whatsapp_credit){
                $notify[] = ['error', 'You do not have a sufficient credit for send message'];
                return back()->withNotify($notify);
            }
    
        }

        if($request->file){
            $extension = strtolower($request->file->getClientOriginalExtension());
            if(!in_array($extension, ['csv','xlsx'])){
                $notify[] = ['error', 'Invalid file extension'];
                return back()->withNotify($notify);
            }
        }
       

        $request->validate($rules);

        $postData = $this->whatsappFile($request);

        $campaign->name = $request->name;
        $campaign->chanel = $request->chanel;
        $campaign->body = $request->message;
        $campaign->subject = $request->subject;
        $campaign->sms_type = $request->smsType;
        $campaign->status = $request->status;
        $campaign->from_name = $request->from_name;
        $campaign->post_data = json_encode($postData);
        $campaign->reply_to_email = $request->reply_to_email;
        $campaign->schedule_time =  $request->schedule_date;
        $campaign->save();
        if($request->repeat_number){
            CampaignSchedule::where('campaign_id',$campaign->id)->delete();
           $this->createCampaignSchedule($request,$campaign->id);
        }
        if(count($attachableData['contacts']) > 0){
            CampaignContact::where('campaign_id',$campaign->id)->delete();
            $attachableData = self::insertContacts( $attachableData ,$campaign);
        }


        $notify[] = ['success', translate('Campaign Updated Successfully')];
        return back()->withNotify($notify);

    }

    public function whatsappFile($request){

        $postData = [];
        if($request->hasFile('document')){
            $file = $request->file('document');
            $fileName = uniqid().time().'.'.$file->getClientOriginalExtension();
            $path = filePath()['whatsapp']['path_document'];
            if(!file_exists($path)){
                mkdir($path, 0755, true);
            }
            try {
                move_uploaded_file($file->getRealPath(), $path.'/'.$fileName);
            } catch (\Exception $e) {

            }
            $postData['type'] = 'document';
            $postData['url_file'] = $path.'/'.$fileName;
            $postData['name'] = $fileName;
        }
        if($request->hasFile('audio')){
            $file = $request->file('audio');
            $fileName = uniqid().time().'.'.$file->getClientOriginalExtension();
            $path = filePath()['whatsapp']['path_audio'];
            if(!file_exists($path)){
                mkdir($path, 0755, true);
            }
            try {
                move_uploaded_file($file->getRealPath(), $path.'/'.$fileName);
            } catch (\Exception $e) {

            }
            $postData['type'] = 'audio';
            $postData['url_file'] = $path.'/'.$fileName;
            $postData['name'] = $fileName;
        }
        if($request->hasFile('image')){
            $file = $request->file('image');
            $fileName = uniqid().time().'.'.$file->getClientOriginalExtension();
            $path = filePath()['whatsapp']['path_image'];
            if(!file_exists($path)){
                mkdir($path, 0755, true);
            }
            try {
                move_uploaded_file($file->getRealPath(), $path.'/'.$fileName);
            } catch (\Exception $e) {

            }
            $postData['type'] = 'image';
            $postData['url_file'] = $path.'/'.$fileName;
            $postData['name'] = $fileName;
        }
        if($request->hasFile('video')){
            $file = $request->file('video');
            $fileName = uniqid().time().'.'.$file->getClientOriginalExtension();
            $path = filePath()['whatsapp']['path_video'];
            if(!file_exists($path)){
                mkdir($path, 0755, true);
            }
            try {
                move_uploaded_file($file->getRealPath(), $path.'/'.$fileName);
            } catch (\Exception $e) {

            }
            $postData['type'] = 'video';
            $postData['url_file'] = $path.'/'.$fileName;
            $postData['name'] = $fileName;
        }
        
        return  $postData;
    }


    /**
     * destory a specific camapign
     *
     * @param $id
     */

    public function delete(Request $request){
        
        $campaign = Campaign::with('contacts')->where('user_id',auth()->user()->id)->where('id',$request->id)->first();
        if($campaign){
            CampaignContact::where('campaign_id',$campaign->id)->delete();
            CampaignSchedule::where('campaign_id',$campaign->id)->delete();
            $campaign->delete();
        }
        $notify[] = ['success', translate('Campaign Deleted')];
        return back()->withNotify($notify);
    }

}
