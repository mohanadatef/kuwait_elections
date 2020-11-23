<?php

namespace App\Interfaces\ACL;

use App\Http\Requests\Admin\ACl\User\PasswordRequest;
use App\Http\Requests\Admin\ACl\User\CreateRequest;
use App\Http\Requests\Admin\ACl\User\EditRequest;
use App\Http\Requests\Admin\ACl\User\StatusEditRequest;
use Illuminate\Http\Request;

interface UserInterface{

    public function Get_All_Datas();
    public function Create_Data(CreateRequest $request);
    public function Get_One_Data($id);
    public function Update_Data(EditRequest $request, $id);
    public function Update_Password_Data(PasswordRequest $request, $id);
    public function Update_Status_One_Data($id);
    public function Get_Many_Data(Request $request);
    public function Update_Status_Datas(StatusEditRequest $request);
    public function Get_Role_For_Data($id);
    public function Upgrad($id);
    public function Get_List_Nominee_Circle($id);

}