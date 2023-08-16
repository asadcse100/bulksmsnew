<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BeeTemplate;
use Illuminate\Http\Request;
use App\Models\EmailTemplates;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class EmailTemplateController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        $title = "Manage mail template";
        $emailTemplates = EmailTemplates::whereNull('user_id')->whereNull('provider')->latest()->paginate(paginateNumber());
      
        return view('admin.email_template.index', compact('title', 'emailTemplates'));
    }

    /**
     * @param $id
     * @return View
     */
    public function edit($id): View
    {
        $title = "Mail template update";
        $emailTemplate = EmailTemplates::findOrFail($id);

        return view('admin.email_template.edit', compact('title', 'emailTemplate'));
    }

    /**
     * @throws ValidationException
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'subject' => 'required|max:255',
            'status'  => 'required|in:1,2',
            'body' => 'required'
        ]);
        $emailTemplate = EmailTemplates::findOrFail($id);
        $emailTemplate->subject = $request->input('subject');
        $emailTemplate->status = $request->input('status');
        $emailTemplate->body = $request->input('body');
        $emailTemplate->save();
        $notify[] = ['success', 'Email template has been updated'];
        return back()->withNotify($notify);
    }

    public function statusUpdate(Request $request){

        EmailTemplates::where('id',$request->id)->update([
            'status' => $request->status
        ]);
        $notify[] = ['success', 'Status Updated Successfully'];
        return back()->withNotify($notify);
    }



    /**
     * custom build template method 
     */
     public function templates(Request $request){
        
        $title = "Admin Mail template";

        if($request->ajax()){
    
            return response()->json([
                'view' => view('admin.email_template.data',['templates'=> EmailTemplates::whereNull('user_id')->whereNotNull('provider')->get()]
                )->render()
            ],'200' );
        }
        $emailTemplates = EmailTemplates::whereNull('user_id')->whereNotNull('provider')->latest()->paginate(paginateNumber());
        return view('admin.email_template.templates', compact('title', 'emailTemplates'));
     }


    /**
     * custom build template method 
     */
    public function userTemplates(){
        $title = "User Mail template";
        $emailTemplates = EmailTemplates::whereNotNull('user_id')->whereNotNull('provider')->latest()->paginate(paginateNumber());
        return view('admin.email_template.templates', compact('title', 'emailTemplates'));
    }

    /**
     * create a template
     */

     public function create(){
        $title = "Mail template Create";
        $beeTemplates = BeeTemplate::all();
        return view('admin.email_template.create', compact('title','beeTemplates'));
     }


     /**
      * stroe a mail templates
      */
     public function store(Request $request){

        $request->validate([
            'name' => 'required|unique:email_templates,name',
            'template_html'=>'required_if:provider,1',
            'bee_template_json'=>'required_if:provider,1',
            'body'=>'required_if:provider,2',
            "provider" => "required",
        ]);

        $body = request()->provider ==  2 ? request()->body : request()->template_html;
        $template_json = request()->provider ==  2 ? null : request()->bee_template_json;

        $template =  new EmailTemplates();
        $template->name = $request->name;
        $template->body = $body;
        $template->provider = request()->provider;
        $template->template_json = $template_json;
        $template->save();
        $notify[] = ['success', translate('Email template has been Created')];
        return back()->withNotify($notify);
     }


     /**
      * edit template
      *
      * @param Request $request
      * @return void
      */

      public function editTemplate($id){
            $title = "Mail template Edit";
            $beeTemplates = BeeTemplate::all();
            $template = EmailTemplates::where('id',$id)->first();

            return view('admin.email_template.edit_template', compact('title','beeTemplates','template'));
      }

     /**
      * update  a mail templates
      *
      * @param Request $request
      * @return void
      */
     public function updateTemplates(Request $request){

        $request->validate([
            'name' => 'required|unique:email_templates,name,'.request()->id,
            'template_html'=>'required_if:provider,1',
            'bee_template_json'=>'required_if:provider,1',
            'body'=>'required_if:provider,2',
            "provider" => "required",
        ]);
        $body = $request->body;
        $bee_template_json = null;
        if($request->provider == 1){
           $body = $request->template_html;
           $bee_template_json = $request->bee_template_json;
        }

        $template = EmailTemplates::where('id',$request->id)->first();

        $template->body = $body;
        $template->template_json = $bee_template_json;
        $template->status = $request->status;
        $template->save();

        $notify[] = ['success', translate('Email template has been Updated')];
        return back()->withNotify($notify);
     }


    /**
     * get pre-designed template by id
     *
     */
    public function templateJson($id){
     
        return json_decode(BeeTemplate::find($id))->template;
    }

    /**
     * get template json  by id
     *
     */
    public function templateJsonEdit($id){

 
        return json_decode( EmailTemplates::where('id',$id)->first()->template_json);
    }

    public function delete(Request $request){
        EmailTemplates::where('id',$request->id)->delete();
        $notify[] = ['success', translate('Email template has been Updated')];
        return back()->withNotify($notify);
    }
}
