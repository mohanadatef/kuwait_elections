<?php

namespace App\Repositories\ACL;

use App\Interfaces\ACL\ForgotPasswordInterface;
use App\Models\ACL\Forgot_Password;


class ForgotPasswordRepository implements ForgotPasswordInterface
{

    protected $forgotpassword;

    public function __construct(Forgot_Password $forgotpassword)
    {
        $this->forgotpassword = $forgotpassword;
    }

    public function Get_All_Data($id)
    {
        return $this->forgotpassword->where('user_id', $id)->get();
    }

}
