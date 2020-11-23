<?php

namespace App\Interfaces\Election;

use App\Http\Requests\Admin\Election\Vote\CreateRequest;
use App\Http\Requests\Admin\Election\Vote\EditRequest;
use App\Http\Requests\Admin\Election\Vote\StatusEditRequest;
use Illuminate\Http\Request;

interface VoteInterface{

    public function Get_All_Datas();
    public function Create_Data(CreateRequest $request);
    public function Get_One_Data($id);
    public function Update_Data(EditRequest $request, $id);
    public function Update_Status_One_Data($id);
    public function Get_Many_Data(Request $request);
    public function Update_Status_Datas(StatusEditRequest $request);
}