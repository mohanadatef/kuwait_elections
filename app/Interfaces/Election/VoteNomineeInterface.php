<?php

namespace App\Interfaces\Election;

use App\Http\Requests\Admin\Election\Vote_Nominee\CreateRequest;

interface VoteNomineeInterface{

    public function Create_Data(CreateRequest $request,$id);
    public function Get_List_Nominee($id);

}