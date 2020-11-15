<?php

namespace App\Http\Controllers\Admin\Setting;

use App\Http\Requests\Admin\Setting\Contact_Us\CreateRequest;
use App\Http\Requests\Admin\Setting\Contact_Us\EditRequest;
use App\Repositories\ACL\LogRepository;
use App\Repositories\Setting\ContactUsRepository;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class ContactUsController extends Controller
{
    private $contactusRepository;
    private $logRepository;

    public function __construct(ContactUsRepository $contactUsRepository,LogRepository $LogRepository)
    {
        $this->contactusRepository = $contactUsRepository;
        $this->logRepository = $LogRepository;
    }

    public function index()
    {
        $datas = $this->contactusRepository->Get_All_Data();
        $this->logRepository->Create_Data(''.Auth::user()->id.'','عرض','فتحه قائمه اتصل بنا فى لوحه التحكم');
        return view('admin.setting.contact_us.index',compact('datas'));
    }

    public function create()
    {
        $this->logRepository->Create_Data(''.Auth::user()->id.'','عرض','فتح صفحه اضافه اتصل بنا فى لوحه التحكم');
        return view('admin.setting.contact_us.create');
    }

    public function store(CreateRequest $request)
    {
        $this->contactusRepository->Create_Data($request);
        $this->logRepository->Create_Data(''.Auth::user()->id.'','اضافه','اضافه بيانات اتصل بنا فى لوحه التحكم');
        return redirect('/admin/contact_us/index')->with('message', 'اضافه بيانات بنجاح');
    }

    public function edit($id)
    {
        $data = $this->contactusRepository->Get_One_Data($id);
        $this->logRepository->Create_Data(''.Auth::user()->id.'','عرض','فتح صفحه تعديل بيانات اتصل بنا فى لوحه التحكم');
        return view('admin.setting.contact_us.edit',compact('data'));
    }

    public function update(EditRequest $request, $id)
    {

        $this->contactusRepository->Update_Data($request, $id);
        $this->logRepository->Create_Data(''.Auth::user()->id.'','تعديل','تعديل بيانات اتصل بنا فى لوحه التحكم');
        return redirect('/admin/contact_us/index')->with('message', 'تم تعديل البيانات بنجاح');
    }

}
