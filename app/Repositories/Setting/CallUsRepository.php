<?php

namespace App\Repositories\Setting;



use App\Http\Requests\Admin\Setting\Call_Us\CreateRequest;
use App\Http\Requests\Admin\Setting\Call_Us\EditRequest;
use App\Interfaces\Setting\CallUsInterface;
use App\Models\Setting\Call_Us;

class CallUsRepository implements CallUsInterface
{

    protected $call_us;

    public function __construct(Call_Us $call_us)
    {
        $this->call_us = $call_us;
    }

    public function Get_All_Unread_Data()
    {
        return $this->call_us->where('status',0)->get();
    }

    public function Get_All_Read_Data()
    {
        return $this->call_us->where('status',1)->get();
    }

    public function Change_Status($id)
    {
        $call_us = $this->call_us->find($id);
        if($call_us->status == 0)
        {
            $call_us->status = 1;
            $call_us->save();
        }
        else
        {
            $call_us->status = 0;
            $call_us->save();
        }
    }

    public function Delete_Data($id)
    {
        $call_us = $this->call_us->find($id);
        $call_us->delete();
    }
}
