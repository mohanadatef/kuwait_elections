<?php

namespace App\Repositories\Setting;

use App\Http\Requests\Admin\Setting\Notification\CreateRequest;
use App\Http\Requests\Admin\Setting\Notification\StatusEditRequest;
use App\Interfaces\Setting\NotificationInterface;
use App\Models\Setting\Notification;
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
