<?php

namespace App\Http\Controllers\Admin\ACL;

use App\Traits\CoreDataa;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;


class LogController extends Controller
{
    use CoreDataa;

    public function index()
    {
        $datas = $this->logRepository->Get_All_Datas();
        $this->logRepository->Create_Data(''.Auth::user()->id.'','عرض','فتح صفحه السجل فى لوحه التحكم');
        return view('admin.acl.log.index', compact('datas'));
    }

    public function store($user,$action,$description)
    {
        $this->logRepository->Create_Data($user,$action,$description);
    }

    public function user_index($id)
    {
        $datas = $this->logRepository->Get_All_Datas_User($id);
        $this->logRepository->Create_Data(''.Auth::user()->id.'','عرض','فتح صفحه السجل لمستخدم فى لوحه التحكم');
        return view('admin.acl.log.index', compact('datas'));
    }
}
