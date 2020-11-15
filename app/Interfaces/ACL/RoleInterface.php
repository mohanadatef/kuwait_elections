<?php

namespace App\Interfaces\ACL;

use App\Http\Requests\Admin\ACl\Role\CreateRequest;
use App\Http\Requests\Admin\ACl\Role\EditRequest;

interface RoleInterface{

    public function Get_All_Datas();
    public function Create_Data(CreateRequest $request);
    public function Get_One_Data($id);
    public function Update_Data(EditRequest $request, $id);
    public function Get_List_Data();
    public function Get_Permission_For_Data($id);
}