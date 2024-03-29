<?php

namespace App\Interfaces\Setting;

use App\Http\Requests\Admin\Setting\About_us\CreateRequest;
use App\Http\Requests\Admin\Setting\About_us\EditRequest;

interface AboutUsInterface{

    public function Get_All_Data();
    public function Create_Data(CreateRequest $request);
    public function Get_One_Data($id);
    public function Update_Data(EditRequest $request, $id);
}