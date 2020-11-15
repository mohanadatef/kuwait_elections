<?php

namespace App\Interfaces\ACL;

use App\Http\Requests\Admin\ACl\Permission\CreateRequest;
use App\Http\Requests\Admin\ACl\Permission\EditRequest;

interface PermissionInterface{

    public function Get_All_Datas();
    public function Create_Data(CreateRequest $request);
    public function Get_One_Data($id);
    public function Update_Data(EditRequest $request, $id);
    public function Get_List_Data();
}