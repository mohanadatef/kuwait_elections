<?php

namespace App\Repositories\ACL;

use App\Interfaces\ACL\LogInterface;
use App\Traits\CoreData;

class LogRepository implements LogInterface
{
    use CoreData;

    public function Get_All_Datas()
    {
        return $this->log->orderby('created_at','DESC')->get();
    }

    public function Create_Data($user,$action,$description)
    {
        $this->log->action = $action ;
        $this->log->user_id = $user ;
        $this->log->description = $description ;
        $this->log->save();
    }
    public function Get_All_Datas_User($id)
    {
        return $this->log->where('user_id',$id)->orderby('created_at','DESC')->get();
    }

}
