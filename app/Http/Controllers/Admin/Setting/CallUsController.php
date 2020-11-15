<?php

namespace App\Http\Controllers\Admin\Setting;

use App\Repositories\ACL\LogRepository;
use App\Repositories\Setting\CallUsRepository;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class CallUsController extends Controller
{
    private $callusRepository;
    private $logRepository;

    public function __construct(CallUsRepository $CallUsRepository,LogRepository $LogRepository)
    {
        $this->callusRepository = $CallUsRepository;
        $this->logRepository = $LogRepository;
    }

    public function unread()
    {
        $datas = $this->callusRepository->Get_All_Unread_Data();
        $this->logRepository->Create_Data(''.Auth::user()->id.'','عرض','فتحه قائمه اتصل بنا غير مقروءه فى لوحه التحكم');
        return view('admin.setting.call_us.unread',compact('datas'));
    }

    public function read()
    {
        $datas = $this->callusRepository->Get_All_Read_Data();
        $this->logRepository->Create_Data(''.Auth::user()->id.'','عرض','فتحه قائمه اتصل بنا المقروءه فى لوحه التحكم');
        return view('admin.setting.call_us.read',compact('datas'));
    }

    public function change_status($id)
    {
       $this->callusRepository->Change_Status($id);
       $this->logRepository->Create_Data(''.Auth::user()->id.'','تغير حاله','تغير حاله اتصل بنا فى لوحه التحكم');
        return redirect()->back()->with('message', 'تم تغير الحاله بنجاح');
    }

    public function delete($id)
    {
        $this->callusRepository->Delete_Data($id);
        $this->logRepository->Create_Data(''.Auth::user()->id.'','مسح','مسح من قائمه اتصل بنا فى لوحه التحكم');
        return redirect()->back()->with('message', 'تم مسح بنجاح');
    }

}
