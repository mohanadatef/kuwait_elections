<?php

namespace App\Interfaces\Core_Data;


use App\Http\Requests\Admin\Core_Data\Area\CreateRequest;
use App\Http\Requests\Admin\Core_Data\Area\EditRequest;
use App\Http\Requests\Admin\Core_Data\Area\StatusEditRequest;
use Illuminate\Http\Request;

interface AreaInterface{

    public function Get_All_Datas();
    public function Create_Data(CreateRequest $request);
    public function Get_One_Data($id);
    public function Update_Data(EditRequest $request, $id);
    public function Update_Status_One_Data($id);
    public function Get_Many_Data(Request $request);
    public function Update_Status_Datas(StatusEditRequest $request);
    public function Get_List_Areas_Json();
    public function Get_List_Data();
}