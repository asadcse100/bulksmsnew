<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\WhatsappDevice;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Client\ConnectionException;
class WhatsappDeviceController extends Controller
{
    /**
     * create form show
     */
    public function create()
    {
        $title = "WhatsApp Device";

        try {
            $response = Http::get(env('WP_SERVER_URL'));
        } catch (ConnectionException) { 
            return view('user.whatsapp_device.error', [
                'title' => $title,
                'message' => "Failed to establish a connection with the WhatsApp node server. Please reach out to your service provider for further assistance.",
            ]);
        }

        $whatsapps = WhatsappDevice::where('user_id', auth()->user()->id)->orderBy('id', 'desc')->get();

        foreach ($whatsapps as $key => $value) {
            try {
                $findWhatsappsession = Http::get(env('WP_SERVER_URL') . '/sessions/status/' . $value->name);
                $wpu = WhatsappDevice::where('id', $value->id)->first();
                if ($findWhatsappsession->status() == 200) {
                    $wpu->status = 'connected';
                } else {
                    $wpu->status = 'disconnected';
                }
                $wpu->save();
            } catch (Exception $e) {
                // Handle the exception
            }
        }

        $whatsapps = WhatsappDevice::where('user_id', auth()->user()->id)->orderBy('id', 'desc')->paginate(paginateNumber());
        return view('user.whatsapp_device.create', [
            'title' => $title,
            'whatsapps' => $whatsapps,
        ]);
    }

    /**
     * whatsapp store method
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:wa_device,name',
            'number' => 'required|numeric|unique:wa_device,number',
            'delay_time' => 'required',
        ]);

        $whatsapp = new WhatsappDevice();
        $whatsapp->user_id = auth()->user()->id;
        $whatsapp->name = randomNumber()."_".$request->name;
        $whatsapp->number = $request->number;
        $whatsapp->delay_time = $request->delay_time;
        $whatsapp->status = 'initiate';
        $whatsapp->save();
        $notify[] = ['success', 'Whatsapp Device successfully added'];
        return back()->withNotify($notify);
    }

    /**
     * whatsapp edit form
     * @param $id
     * @return Application|Factory|View
     */
    public function edit($id)
    {
        $tilte = "WhatsApp Device Edit";
        $whatsapps = WhatsappDevice::where('user_id', auth()->user()->id)->orderBy('id','desc');
        foreach ($whatsapps as $key => $value) {
            try {
                $findWhatsappsession = Http::withoutVerifying()->get(config('requirements.core.wa_key_get').'/sessions/find/'.$value->name);
                $findWhatsappsession = json_decode($findWhatsappsession);
                $wpu = WhatsappDevice::where('id', $value->id)->first();
                if ($findWhatsappsession->message == "Session found.") {
                    $wpu->status = 'connected';
                }else{
                    $wpu->status = 'disconnected';
                }
                $wpu->save();
            } catch (Exception $e) {

            }
        }
        $whatsapps = WhatsappDevice::where('user_id', auth()->user()->id)->orderBy('id', 'desc')->paginate(paginateNumber());
        $whatsapp = WhatsappDevice::where('id', $id)->where('user_id', auth()->user()->id)->first();
        return view('user.whatsapp_device.edit', [
            'title' => $tilte,
            'whatsapp' => $whatsapp,
            'whatsapps' => $whatsapps,
        ]);
    }

    /**
     * whatsapp update method
     * @param Request $request
     * @return mixed
     */
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:wa_device,name,'.$request->id,
            'number' => 'required|numeric|unique:wa_device,number,'.$request->id,
            'multidevice' => 'required|in:YES,NO',
            'delay_time' => 'required',
            'status' => 'required|in:initiate,connected,disconnected',
        ]);

        $whatsapp = WhatsappDevice::where('id', $request->id)->where('user_id', auth()->user()->id)->first();
        $whatsapp->user_id = auth()->user()->id;
        if ($whatsapp->status!='connected') {
            $whatsapp->name = $request->name;
        }
        $whatsapp->number = $request->number;
        $whatsapp->description = $request->description;
        $whatsapp->status = $request->status;
        $whatsapp->multidevice = $request->multidevice;
        $whatsapp->delay_time = $request->delay_time;
        $whatsapp->update();
        $notify[] = ['success', 'WhatsApp Device successfully Updated'];
        return back()->withNotify($notify);
    }

    /**
     * whatsapp delete method
     *
     * @param Request $request
     */
    public function delete(Request $request)
    {
        $whatsapp = WhatsappDevice::where('id', $request->id)->where('user_id', auth()->user()->id)->first();
        $whatsapp->delete();
        try {
            $response = Http::delete(env('WP_SERVER_URL').'/sessions/delete/'.$whatsapp->name);
            if ($response->status() == 200) {
                $notify[] = ['success', 'WhatsApp device has been successfully deleted, and the associated sessions have been cleared from the node.'];
            }else{
                $notify[] = ['success', 'WhatsApp device has been successfully deleted.'];
            }
        } catch (\Exception $e) {
            $notify[] = ['error', 'Oops! Something went wrong. The Node server is not running.'];
            return back()->withNotify($notify);
        } 
        return back()->withNotify($notify);
    }

    /**
     * whatsapp device status update method
     * @param Request $request
     * @return false|string
     */
    public function statusUpdate(Request $request)
    {
        $whatsapp = WhatsappDevice::where('id', $request->id)->where('user_id', auth()->user()->id)->first();

        if ($request->status=='connected') {
            try {
                $findWhatsappsession = Http::get(env('WP_SERVER_URL').'/sessions/status/'.$whatsapp->name);
                if ($findWhatsappsession->status()==200) {
                    $whatsapp->status = 'connected';
                    $message = "Successfully whatsapp sessions reconnect";
                }else{
                    $response = Http::delete(env('WP_SERVER_URL').'/sessions/delete/'.$whatsapp->name);
                    $whatsapp->status = 'disconnected';
                    $message = "Successfully whatsapp sessions disconnected";
                }
                $whatsapp->update();
            } catch (\Exception $e) {

            }
        }elseif ($request->status=='disconnected') {
            try {
                $response = Http::delete(env('WP_SERVER_URL').'/sessions/delete/'.$whatsapp->name);
                if ($response->status() == 200) { 
                    $whatsapp->status = 'disconnected';
                    $message =  'Whatsapp Device successfully Deleted';
                }else{
                    $message =  'Opps! Something went wrong, try again';
                }
                $whatsapp->update();
            } catch (Exception $e) {

            }
        }else{
            try {
                $response = Http::delete(env('WP_SERVER_URL').'/sessions/delete/'.$whatsapp->name);
                if ($response->status() == 200) { 
                    $whatsapp->status = 'disconnected';
                    $message = 'Whatsapp Device successfully Deleted';
                }else{
                    $message ='Opps! Something went wrong, try again';
                } 
                $whatsapp->update();
            } catch (\Exception $e) {

            }
            $whatsapp->status = $request->status;
            $whatsapp->update();
        }

        return json_encode([
            'success' => $message
        ]);
    }

    /**
     * whatsapp qr quote scan method
     * @param Request $request
     * @return false|string
     */
        public function getWaqr(Request $request)
    {
        $whatsapp = WhatsappDevice::where('id', $request->id)->where('user_id', auth()->user()->id)->first();
        $islegacy = $whatsapp->multidevice === "YES" ? false : true;
        $data = array();
        $currentUrl = $request->root();
        $parsedUrl = parse_url($currentUrl);
        $domain = $parsedUrl['host'];

        $response = Http::post(env('WP_SERVER_URL').'/sessions/create', [
            'id' => $whatsapp->name,
            'isLegacy' => $islegacy,
            'domain' => $domain
        ]);
        $responseBody = json_decode($response->body());
        if ($response->status() === 200) {
            $data['status'] = $response->status();
            $data['qr'] = $responseBody->data->qr;
            $data['message'] = $responseBody->message;
        } else {
            $msg = $response->status() === 500 ? "Invalid Software License" : "Trying to create a new Session";
            $data['status'] = $response->status();
            $data['qr'] = '';
            $data['message'] = $msg;
        } 

        $response = [
            'response' => $whatsapp,
            'data' => $data
        ];

        return json_encode($response);
    }


    public function getDeviceStatus(Request $request)
    {
        $device_id = $request->id;

        $whatsapp = WhatsappDevice::where('id', $device_id)->where('user_id', auth()->user()->id)->first();
        $data = array(); 
        try {
            $checkConnection = Http::get(env('WP_SERVER_URL').'/sessions/status/'.$whatsapp->name);
            if ($whatsapp->status === "connected" || $checkConnection->status() === 200) {
                $whatsapp->status = 'connected';
                $res = json_decode($checkConnection->body());
                if (isset($res->data->wpInfo)) {
                    $wpNumber = str_replace('@s.whatsapp.net', '', $res->data->wpInfo->id);
                    $wpNumber = explode(':', $wpNumber);
                    $wpNumber = $wpNumber[0] ?? $whatsapp->number;

                    $whatsapp->number = $wpNumber;
                }
                $whatsapp->save();
                
                $data['status']  = 301;
                $data['qr']      = asset('assets/dashboard/image/done.gif');
                $data['message'] = 'Successfully connected WhatsApp device'; 
            }
        } catch (RequestException $e) {
            $data['status'] = $e->getCode();
            $data['qr'] = '';
            $data['message'] = $e->getMessage();
        } catch (\Exception $e) {
            $data['status'] = 500;
            $data['qr'] = '';
            $data['message'] = $e->getMessage();
        }

        $response = [
            'response' => $whatsapp,
            'data' => $data
        ];

        return json_encode($response);
    }
}
