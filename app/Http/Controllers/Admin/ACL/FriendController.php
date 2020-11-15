<?php

namespace App\Http\Controllers\Admin\ACL;

use App\Repositories\ACL\FriendRepository;
use App\Repositories\ACL\LogRepository;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class FriendController extends Controller
{
    private $logRepository;
    private $friendRepository;
    public function __construct(LogRepository $LogRepository,FriendRepository $friendRepository)
    {
        $this->logRepository = $LogRepository;
        $this->friendRepository = $friendRepository;
    }

    public function request_index()
    {
        $datas = $this->friendRepository->Get_All_Request_Data();
        $this->logRepository->Create_Data(''.Auth::user()->id.'','عرض','فتح قائمه طلبات الصداقه على لوحه التحكم');
        return view('admin.acl.friend.request_index',compact('datas'));
    }

    public function friend_index()
    {
        $datas = $this->friendRepository->Get_All_Friend_Data();
        $this->logRepository->Create_Data(''.Auth::user()->id.'','عرض','فتح قائمه الصداقه على لوحه التحكم');
        return view('admin.acl.friend.friend_index',compact('datas'));
    }
}
