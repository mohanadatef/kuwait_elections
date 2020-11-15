<?php


namespace App\Http\Controllers\Admin\Setting;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Setting\Setting\CreateRequest;
use App\Http\Requests\Admin\Setting\Setting\EditRequest;
use App\Repositories\ACL\LogRepository;
use App\Repositories\Setting\SettingRepository;

use Illuminate\Support\Facades\Auth;

class SettingController extends Controller
{
    private $logRepository;
    private $settingRepository;

    public function __construct(SettingRepository $SettingRepository,LogRepository $LogRepository)
    {
        $this->settingRepository = $SettingRepository;
        $this->logRepository = $LogRepository;
    }

    public function index()
    {
        $datas = $this->settingRepository->Get_All_Data();
        $this->logRepository->Create_Data(''.Auth::user()->id.'','عرض','فتح قائمه الاعدادات فى لوحه التحكم');
        return view('admin.setting.setting.index',compact('datas'));
    }

    public function create()
    {
        $this->logRepository->Create_Data(''.Auth::user()->id.'','عرض','فتح صفحه اضافه بيانات الاعدادات فى لوحه التحكم');
        return view('admin.setting.setting.create');
    }

    public function store(CreateRequest $request)
    {
        $this->settingRepository->Create_Data($request);
        $this->logRepository->Create_Data(''.Auth::user()->id.'','اضافه','اضافه بيانات الاعدادات فى لوحه التحكم');
        return redirect('/admin/setting/index')->with('message', 'اضافه بيانات بنجاح');
    }

    public function edit($id)
    {
        $data = $this->settingRepository->Get_One_Data($id);
        $this->logRepository->Create_Data(''.Auth::user()->id.'','عرض','فتح صفحه تعديل بيانات الاعدادات فى لوحه التحكم');
        return view('admin.setting.setting.edit',compact('data'));
    }

    public function update(EditRequest $request, $id)
    {
        $this->settingRepository->Update_Data($request, $id);
        $this->logRepository->Create_Data(''.Auth::user()->id.'','تعديل','تعديل بيانات الاعدادات فى لوحه التحكم');
        return redirect('/admin/setting/index')->with('message', 'تم تعديل البيانات بنجاح');
    }

}
