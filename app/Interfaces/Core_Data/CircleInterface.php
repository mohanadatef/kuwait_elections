<?php

namespace App\Interfaces\Core_Data;


use App\Http\Requests\Admin\Core_Data\Circle\CreateRequest;
use App\Http\Requests\Admin\Core_Data\Circle\EditRequest;
use App\Http\Requests\Admin\Core_Data\Circle\StatusEditRequest;
use Illuminate\Http\Request;

interface CircleInterface{

    public function Get_All_Datas();
    public function Create_Data(CreateRequest $request);
    public function Get_One_Data($id);
    public function Update_Data(EditRequest $request, $id);
    public function Update_Status_One_Data($id);
    public function Get_Many_Data(Request $request);
    public function Update_Status_Datas(StatusEditRequest $request);
    public function Get_List_Data();
}