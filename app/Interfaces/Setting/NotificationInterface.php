<?php

namespace App\Interfaces\Setting;

use App\Http\Requests\Admin\Setting\Notification\CreateRequest;
use App\Http\Requests\Admin\Setting\Notification\StatusEditRequest;
use Illuminate\Http\Request;

interface NotificationInterface{

    public function Get_All_Data();
    public function Create_Data(CreateRequest $request);
    public function Update_Status_One_Data($id);
    public function Get_Many_Data(Request $request);
    public function Update_Status_Datas(StatusEditRequest $request);
}