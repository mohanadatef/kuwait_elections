<?php

namespace App\Http\Controllers\Admin\ACL;

use App\Repositories\ACL\ForgotPasswordRepository;
use App\Repositories\ACL\LogRepository;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class ForgotPasswordController extends Controller
{
    private $logRepository;
    private $forgotpasswordRepository;
    public function __construct(LogRepository $LogRepository,ForgotPasswordRepository $forgotpasswordRepository)
    {
        $this->logRepository = $LogRepository;
        $this->forgotpasswordRepository = $forgotpasswordRepository;
    }

    public function index($id)
    {
        $datas = $this->forgotpasswordRepository->Get_All_Data($id);
        $this->logRepository->Create_Data(''.Auth::user()->id.'','عرض','فتح قائمه سجل تغير كلمه السر على لوحه التحكم');
        return view('admin.acl.forgot_password.index',compact('datas'));
    }

}
