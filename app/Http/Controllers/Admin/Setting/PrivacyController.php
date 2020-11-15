<?php

namespace App\Http\Controllers\Admin\Setting;

use App\Http\Requests\Admin\Setting\Privacy\CreateRequest;
use App\Http\Requests\Admin\Setting\Privacy\EditRequest;
use App\Repositories\ACL\LogRepository;
use App\Repositories\Setting\PrivacyRepository;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class PrivacyController extends Controller
{
    private $privacyRepository;
    private $logRepository;

    public function __construct(PrivacyRepository $PrivacyRepository,LogRepository $LogRepository)
    {
        $this->privacyRepository = $PrivacyRepository;
        $this->logRepository = $LogRepository;
    }

    public function index()
    {
        $datas = $this->privacyRepository->Get_All_Data();
        $this->logRepository->Create_Data(''.Auth::user()->id.'','عرض','فتح صفحه قائمه الشروط و الاحكام فى لوحه التحكم');
        return view('admin.setting.privacy.index', compact('datas'));
    }

    public function create()
    {
        $this->logRepository->Create_Data(''.Auth::user()->id.'','عرض','فتح صفحه اضافه الشروط و الاحكام فى لوحه التحكم');
        return view('admin.setting.privacy.create');
    }

    public function store(CreateRequest $request)
    {
        $this->privacyRepository->Create_Data($request);
        $this->logRepository->Create_Data(''.Auth::user()->id.'','اضافه','اضافه بيانات الشروط و الاحكام فى لوحه التحكم');
        return redirect('/admin/privacy/index')->with('message', 'تم اضافه البيانات بنجاح');
    }

    public function edit($id)
    {
        $data = $this->privacyRepository->Get_One_Data($id);
        $this->logRepository->Create_Data(''.Auth::user()->id.'','عرض','فتح صفحه تعديل الشروط و الاحكام فى لوحه التحكم');
        return view('admin.setting.privacy.edit', compact('data'));
    }

    public function update(EditRequest $request, $id)
    {
        $this->privacyRepository->Update_Data($request, $id);
        $this->logRepository->Create_Data(''.Auth::user()->id.'','تعديل','تعديل بيانات الشروط و الاحكام فى لوحه التحكم');
        return redirect('/admin/privacy/index')->with('message', 'تم تعديل البيانات بنجاح');
    }
}
