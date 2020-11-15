<?php

namespace App\Http\Controllers\Admin\Setting;

use App\Http\Requests\Admin\Setting\About_us\CreateRequest;
use App\Http\Requests\Admin\Setting\About_us\EditRequest;
use App\Repositories\ACL\LogRepository;
use App\Repositories\Setting\AboutUsRepository;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class AboutUsController extends Controller
{
    private $aboutusRepository;
    private $logRepository;

    public function __construct(AboutUsRepository $AboutUsRepository,LogRepository $LogRepository)
    {
        $this->aboutusRepository = $AboutUsRepository;
        $this->logRepository = $LogRepository;
    }

    public function index()
    {
        $datas = $this->aboutusRepository->Get_All_Data();
        $this->logRepository->Create_Data(''.Auth::user()->id.'','عرض','فتح صفحه قائمه عن الشركه فى لوحه التحكم');
        return view('admin.setting.about_us.index', compact('datas'));
    }

    public function create()
    {
        $this->logRepository->Create_Data(''.Auth::user()->id.'','عرض','فتح صفحه اضافه عن الشركه فى لوحه التحكم');
        return view('admin.setting.about_us.create');
    }

    public function store(CreateRequest $request)
    {
        $this->aboutusRepository->Create_Data($request);
        $this->logRepository->Create_Data(''.Auth::user()->id.'','اضافه','اضافه بيانات عن الشركه فى لوحه التحكم');
        return redirect('/admin/about_us/index')->with('message', 'تم اضافه البيانات بنجاح');
    }

    public function edit($id)
    {
        $data = $this->aboutusRepository->Get_One_Data($id);
        $this->logRepository->Create_Data(''.Auth::user()->id.'','عرض','فتح صفحه تعديل عن الشركه فى لوحه التحكم');
        return view('admin.setting.about_us.edit', compact('data'));
    }

    public function update(EditRequest $request, $id)
    {
        $this->aboutusRepository->Update_Data($request, $id);
        $this->logRepository->Create_Data(''.Auth::user()->id.'','تعديل','تعديل بيانات عن الشركه فى لوحه التحكم');
        return redirect('/admin/about_us/index')->with('message', 'تم تعديل البيانات بنجاح');
    }
}
