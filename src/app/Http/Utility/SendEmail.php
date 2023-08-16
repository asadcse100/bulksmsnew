<?php
namespace App\Http\Utility;

use App\Models\CampaignContact;
use Illuminate\Support\Facades\Mail;
use App\Models\EmailLog;
use App\Models\User;
use SendGrid\Mail\TypeException;

class SendEmail
{
    /**
     * @param $emailFrom
     * @param $sitename
     * @param $emailTo
     * @param $subject
     * @param $messages
     * @param $emailLog
     * @return void
     */
    public static function sendPHPMail($emailFrom, $sitename, $emailTo, $subject, $messages, $emailLog): void
    {
        $headers = "From: $sitename <$emailFrom> \r\n";
        $headers .= "Reply-To: $sitename <$emailFrom> \r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=utf-8\r\n";
        try {

            if($emailLog->contact_id){
               $status = "Success";
            }

            @mail($emailTo, $subject, $messages, $headers);
            $emailLog->status =  EmailLog::SUCCESS;
        } catch (\Exception $e) {
            $emailLog->status =  EmailLog::FAILED;
            if($emailLog->contact_id){
                $status = "Fail";
            }
            $emailLog->response_gateway  = $e->getMessage();
        }

        if($emailLog->contact_id){
            CampaignContact::where('id',$emailLog->contact_id)->update([
                "status" => $status 
            ]);
        }
        $emailLog->save();
    }

    /**
     * @param $emailFrom
     * @param $fromName
     * @param $emailTo
     * @param $replyTo
     * @param $subject
     * @param $messages
     * @param $emailLog
     * @return void
     */
    public static function sendSMTPMail($emailFrom, $fromName, $emailTo, $replyTo, $subject, $messages, $emailLog): void
    {
        try{
            Mail::send([], [], function ($message) use ($messages, $emailFrom, $fromName, $emailTo, $replyTo, $subject)
            {
                $message->to($emailTo)
                    ->replyTo($replyTo)
                    ->subject($subject)
                    ->from($emailFrom,$fromName)
                    ->setBody($messages, 'text/html','utf-8');
            });
            if($emailLog->contact_id){
                $status = "Success";
             }
            $emailLog->status = EmailLog::SUCCESS;
            $emailLog->save();
        }catch (\Exception $e){
            $emailLog->status = EmailLog::FAILED;
            $emailLog->response_gateway  = $e->getMessage();
            $emailLog->save();
            
            if($emailLog->contact_id){
                $status = "Fail";
            }
            $user = User::find($emailLog->user_id);
            if ($user!='') {
                $user->email_credit += 1;
                $user->save();
            }
        }

        if($emailLog->contact_id){
            CampaignContact::where('id',$emailLog->contact_id)->update([
                "status" => $status 
            ]);
        }
    }

    /**
     * @param $emailFrom
     * @param $fromName
     * @param $emailTo
     * @param $subject
     * @param $messages
     * @param $emailLog
     * @param $credentials
     * @return void
     * @throws TypeException
     */
    public static function sendGrid($emailFrom, $fromName, $emailTo, $subject, $messages, $emailLog, $credentials): void
    {
        $email = new \SendGrid\Mail\Mail();
        $email->setFrom($emailFrom, $fromName);
        $email->addTo($emailTo);
        $email->setSubject($subject);
        $email->addContent("text/html", $messages);
        $sendgrid = new \SendGrid(@$credentials);

        try {
            $response = $sendgrid->send($email);
            if (!in_array($response->statusCode(), ['201','200','202'])) {
                $emailLog->status =  EmailLog::FAILED;
                $emailLog->response_gateway  = "Error";
                $emailLog->save();
                $user = User::find($emailLog->user_id);
                if ($user!='') {
                    $user->email_credit += 1;
                    $user->save();
                }
                if($emailLog->contact_id){
                    $status = "Fail";
                }
            }else{
                if($emailLog->contact_id){
                    $status = "Success";
                 }
                $emailLog->status =  EmailLog::SUCCESS;
                $emailLog->save();
            }
        }catch (\Exception $e) {
            $emailLog->status =  EmailLog::FAILED;
            $emailLog->response_gateway  = $e->getMessage();
            $emailLog->save();
            $user = User::find($emailLog->user_id);
            if($emailLog->contact_id){
                $status = "Fail";
            }
            if ($user!='') {
                $user->email_credit += 1;
                $user->save();
            }

        }

        if($emailLog->contact_id){
            CampaignContact::where('id',$emailLog->contact_id)->update([
                "status" => $status 
            ]);
        }
    }
}
