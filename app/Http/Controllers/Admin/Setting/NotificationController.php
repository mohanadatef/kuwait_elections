<?php

namespace App\Http\Controllers\Admin\Setting;

use App\Http\Requests\Admin\Setting\Notification\CreateRequest;
use App\Repositories\ACL\LogRepository;
use App\Repositories\Setting\NotificationRepository;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Admin\Setting\Notification\StatusEditRequest;

class NotificationController extends Controller
{
    private $notificationRepository;
    private $logRepository;

    public function __construct(NotificationRepository $NotificationRepository,LogRepository $LogRepository)
    {
        $this->notificationRepository = $NotificationRepository;
        $this->logRepository = $LogRepository;
    }

    public function index()
    {
        $datas = $this->notificationRepository->Get_All_Data();
        $this->logRepository->Create_Data(''.Auth::user()->id.'','عرض','فتح صفحه قائمه الاشعارات');
        return view('admin.setting.notification.index', compact('datas'));
    }

    public function create()
    {
        $this->logRepository->Create_Data(''.Auth::user()->id.'','عرض','فتح صفحه اضافه الاشعارات');
        return view('admin.setting.notification.create');
    }

    public function store(CreateRequest $request)
    {
        $this->notificationRepository->Create_Data($request);
        $this->logRepository->Create_Data(''.Auth::user()->id.'','اضافه','اضافه بيانات الاشعارات');
        return redirect('/admin/notification/index')->with('message', 'تم اضافه البيانات بنجاح');
    }

    public function change_status($id)
    {
        $this->notificationRepository->Update_Status_One_Data($id);
        $this->logRepository->Create_Data(''.Auth::user()->id.'','تغير الحاله','تغير حاله الاشعارات فى لوحه التحكم');
        return redirect()->back()->with('message', 'تم تغير حاله المستخدم بنجاح');
    }

    public function change_many_status(StatusEditRequest $request)
    {
        $this->notificationRepository->Update_Status_Datas($request);
        $this->logRepository->Create_Data(''.Auth::user()->id.'','تغير حاله','تغير حاله اكثر من الاشعارات فى لوحه التحكم');
        return redirect()->back()->with('message', 'تم تغير الحاله للمستخدمين بنجاح');
    }

}
