<?php

namespace App\Interfaces\Social_Media;


use App\Http\Requests\Admin\Social_Media\Commit\StatusEditRequest;
use Illuminate\Http\Request;


interface CommitInterface{

    public function Get_All_Datas();
    public function Get_All_Datas_Post($id);
    public function Update_Status_One_Data($id);
    public function Get_One_Data($id);
    public function Get_Many_Data(Request $request);
    public function Update_Status_Datas(StatusEditRequest $request);
}