<?php

namespace App\Interfaces\ACL;

interface LogInterface{
    public function Get_All_Datas();
    public function Get_All_Datas_User($id);
    public function Create_Data($user,$action,$description);

}