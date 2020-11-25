<?php

namespace App\Repositories\Setting;

use App\Http\Requests\Admin\Setting\Notification\CreateRequest;
use App\Http\Requests\Admin\Setting\Notification\StatusEditRequest;
use App\Interfaces\Setting\NotificationInterface;
use App\Models\Setting\Notification;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationRepository implements NotificationInterface
{

    protected $notification;

    public function __construct(Notification $notification)
    {
        $this->notification = $notification;
    }

    public function Get_All_Data()
    {
        return $this->notification->where('user_receive_id',0)->get();
    }

    public function  Create_Data(CreateRequest $request)
    {
        $this->notification->user_send_id=Auth::user()->id;
        $this->notification->user_receive_id=0;
        $this->notification->status=1;
        $this->notification->details=$request->details;
        $this->notification->save();
        define( 'API_ACCESS_KEY', 'AAAADoBl3II:APA91bFK65pRQhptwRAaCPb1RpLkLMAdkwxdqyd5ply8krOxYEF2F73Fvjx3yuWAsDtK1ImbriidAMr1ZfJwdOY5QekTLF9zqhpyRRvczQo6RwpD2rzqIz4wlQiE-rI11XATyH8R99YO');
        $msg = array(
            'message'       => ''.$this->notification->details.'',
            'title'         => 'اشعار',
        );
        $header = [
            'Authorization: Key=' . API_ACCESS_KEY,
            'Content-Type: Application/json'
        ];
        $payload = [
            'to'  => Auth::user()->remember_token,
            'data'        => $msg
        ];
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://fcm.googleapis.com/fcm/send",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode( $payload ),
            CURLOPT_HTTPHEADER => $header
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            dd( "cURL Error #:" . $err);
        } else {
            dd($response);
        }
    }
    public function Update_Status_One_Data($id)
    {
        $notification = $this->notification->find($id);
        if ($notification->status == 1) {
            $notification->status = '0';
        } elseif ($notification->status == 0) {
            $notification->status = '1';
        }
        $notification->update();
    }

    public function Get_Many_Data(Request $request)
    {
        return $this->notification->wherein('id', $request->change_status)->get();
    }

    public function Update_Status_Datas(StatusEditRequest $request)
    {
        $notifications = $this->Get_Many_Data($request);
        foreach ($notifications as $notification) {
            if ($notification->status == 1) {
                $notification->status = '0';
            } elseif ($notification->status == 0) {
                $notification->status = '1';
            }
            $notification->update();
        }
    }

}
