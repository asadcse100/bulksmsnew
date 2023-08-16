<?php
namespace App\Http\Utility;
use App\Models\MailConfiguration;
use Illuminate\Support\Facades\Mail;
use App\Models\GeneralSetting;
use App\Models\EmailTemplates;

class SendMail
{
    /**
     * @param $userInfo
     * @param $emailTemplate
     * @param array $code
     * @return void
     */
    public static function MailNotification($userInfo, $emailTemplate, array $code = []): void
    {
        $general = GeneralSetting::first();
    	$mailConfiguration = MailConfiguration::where('id', $general->email_gateway_id)->where('status', 1)->first();

    	if(!$mailConfiguration){
    		return;
    	}

        $emailTemplate = EmailTemplates::where('slug', $emailTemplate)->first();
        $messages = str_replace("{{username}}", @$userInfo->name, $general->email_template);
        $messages = str_replace("{{message}}", @$emailTemplate->body, $messages);

        foreach ($code as $key => $value) {
            $messages = str_replace('{{' . $key . '}}', $value, $messages);
        }

    	if($mailConfiguration->name === "PHP MAIL"){
    		self::sendPHPMail($general->mail_from, $general->site_name, $userInfo->email, $emailTemplate->subject, $messages);
    	}
        elseif($mailConfiguration->name === "SMTP"){
    		self::sendSMTPMail($mailConfiguration->driver_information->from->address, $userInfo->email, $general->site_name, $emailTemplate->subject, $messages);
    	}
        elseif($mailConfiguration->name === "SendGrid Api"){
            self::sendGrid($mailConfiguration->driver_information->from->address, $general->site_name, $userInfo->email, $emailTemplate->subject, $messages, @$mailConfiguration->driver_information->app_key);
        }
    }

    /**
     * @param $emailFrom
     * @param $sitename
     * @param $emailTo
     * @param $subject
     * @param $messages
     * @return string|void
     */
    public static function sendPHPMail($emailFrom, $sitename, $emailTo, $subject, $messages)
    {
        $headers = "From: $sitename <$emailFrom> \r\n";
        $headers .= "Reply-To: $sitename <$emailFrom> \r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=utf-8\r\n";
        try {
            @mail($emailTo, $subject, $messages, $headers);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * @param $emailFrom
     * @param $emailTo
     * @param $fromName
     * @param $subject
     * @param $messages
     * @return string|void
     */
    public static function sendSMTPMail($emailFrom, $emailTo, $fromName, $subject, $messages)
    {
        try{
            Mail::send([], [], function ($message) use ($messages, $emailFrom, $fromName, $emailTo, $subject) {
                        $message->to($emailTo)
                    ->subject($subject)
                    ->from($emailFrom,$fromName)
                    ->setBody($messages, 'text/html','utf-8');
            });
        }catch (\Exception $e){
            return $e->getMessage();
        }
    }

    /**
     * @param $emailFrom
     * @param $fromName
     * @param $emailTo
     * @param $subject
     * @param $messages
     * @param $credentials
     * @return string|void
     */
    public static function sendGrid($emailFrom, $fromName, $emailTo, $subject, $messages, $credentials)
    {
        try{
            $email = new \SendGrid\Mail\Mail();
            $email->setFrom($emailFrom, $fromName);
            $email->setSubject($subject);
            $email->addTo($emailTo);
            $email->addContent("text/html", $messages);
            $sendgrid = new \SendGrid($credentials);
            $sendgrid->send($email);
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }
}
