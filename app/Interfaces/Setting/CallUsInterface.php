<?php

namespace App\Interfaces\Setting;

use App\Http\Requests\Admin\Setting\Contact_Us\CreateRequest;
use App\Http\Requests\Admin\Setting\Contact_Us\EditRequest;

interface CallUsInterface{

    public function Get_All_Unread_Data();
    public function Get_All_Read_Data();
    public function Change_Status($id);
    public function Delete_Data($id);
}