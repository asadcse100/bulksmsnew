<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MailConfiguration;
use App\Models\GeneralSetting;
use App\Http\Utility\SendMail;
use Carbon\Carbon;
use App\Models\EmailTemplates;
use Illuminate\Validation\ValidationException;

class MailConfigurationController extends Controller
{
    public function index()
    {
        $title = "Mail Configuration";
        $mails = MailConfiguration::latest()->get();
        return view('admin.mail.index', compact('title', 'mails'));
    }

    public function edit($id)
    {
        $title = "Mail updated";
        $mail = MailConfiguration::findOrFail($id);
        return view('admin.mail.edit', compact('title', 'mail'));
    }

    /**
     * @throws ValidationException
     */
    public function mailUpdate(Request $request, $id)
    {
        $this->validate($request, [
            'driver'   => "required_if:name,==,smtp",
            'host'     => "required_if:name,==,smtp",
            'smtp_port'     => "required_if:name,==,smtp",
            'encryption'=> "required_if:name,==,smtp",
            'username' => "required_if:name,==,smtp",
            'password' => "required_if:name,==,smtp",
            'from_address' => "required_if:name,==,smtp",
            'from_name' => "required_if:name,==,smtp",
        ]);

        $mail = MailConfiguration::findOrFail($id);

        if($mail->name === "SMTP"){
            $general = GeneralSetting::first();
            $general->mail_from = $request->input('username');
            $general->save();

            $mail->driver_information = [
                'driver'   => $request->input('driver'),
                'host'     => $request->input('host'),
                'smtp_port'=> $request->input('smtp_port'),
                'from'     => [
                    'address'=> $request->input('from_address'),
                    'name'   => $request->input('from_name'),
                ],
                'encryption'=> $request->input('encryption'),
                'username'  => $request->input('username'),
                'password'  => $request->input('password'),
            ];
        }elseif($mail->name == "SendGrid Api"){
            $mail->driver_information = [
                'app_key'=> $request->input('app_key'),
                'from'   => [
                    'address' => $request->input('from_address'),
                    'name' => $request->input('from_name')
                ],
            ];
        }
        $mail->save();

        $notify[] = ['success',  ucfirst($mail->name).' mail method has been updated'];
        return back()->withNotify($notify);
    }

    /**
     * @throws ValidationException
     */
    public function sendMailMethod(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|exists:mails,id'
        ]);

        $mail = MailConfiguration::findOrFail($request->input('id'));
        $general = GeneralSetting::first();
        $general->email_gateway_id = $mail->id;
        $general->save();

        $notify[] = ['success', 'Email method has been updated'];
        return back()->withNotify($notify);
    }


    public function globalTemplate()
    {
        $title = "Global template";
        return view('admin.mail.global_template', compact('title'));
    }

    /**
     * @throws ValidationException
     */
    public function globalTemplateUpdate(Request $request)
    {
        $this->validate($request,[
            'mail_from' => 'required|email',
            'body' => 'required',
        ]);

        $general = GeneralSetting::first();
        $general->mail_from = $request->input('mail_from');
        $general->email_template = $request->input('body');
        $general->save();

        $notify[] = ['success', 'Global email template has been updated'];
        return back()->withNotify($notify);

    }

    public function mailTester(Request $request,$id)
    {
        $general = GeneralSetting::first();
        $mailConfiguration = MailConfiguration::where('id', $id)->first();

        if(!$mailConfiguration){
            return back();
        }

        $response = "";
        $emailTemplate = EmailTemplates::where('slug', 'TEST_MAIL')->first();
        $messages = str_replace("{{name}}", @$general->site_name, $emailTemplate->body);
        $messages = str_replace("{{time}}", @Carbon::now(), $messages);

        if($mailConfiguration->name === "PHP MAIL"){
            $response = SendMail::sendPHPMail($general->mail_from, $general->site_name, $request->input('email'), $emailTemplate->subject, $messages);
        }
        elseif($mailConfiguration->name === "SMTP"){
            $response = SendMail::sendSMTPMail($mailConfiguration->driver_information->from->address, $request->input('email'), $general->site_name, $emailTemplate->subject, $messages);
        }
        elseif($mailConfiguration->name === "SendGrid Api"){
            $response = SendMail::sendGrid($mailConfiguration->driver_information->from->address, $general->site_name, $request->input('email'), $emailTemplate->subject, $messages, @$mailConfiguration->driver_information->app_key);
        }
        if ($response==null) {
            $notify[] = ['success', "Successfully sent mail, please check your inbox or spam"];
        }else{
            $notify[] = ['error', "Mail Configuration Error, Please check your mail configuration properly"];
        }

        return back()->withNotify($notify);
    }
}
