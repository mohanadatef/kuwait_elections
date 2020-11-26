<?php

namespace App\Interfaces\Social_Media;


use App\Http\Requests\Admin\Social_Media\Group\CreateRequest;
use App\Http\Requests\Admin\Social_Media\Group\EditRequest;


interface GroupInterface
{

    public function Get_All_Datas();

    public function Create_Data(CreateRequest $request);

    public function Get_One_Data($id);

    public function Update_Data(EditRequest $request, $id);
}