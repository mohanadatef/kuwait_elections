<?php

namespace App\Http\Controllers\Admin\Core_Data;

use App\Http\Requests\Admin\Core_Data\Circle\CreateRequest;
use App\Http\Requests\Admin\Core_Data\Circle\EditRequest;
use App\Http\Requests\Admin\Core_Data\Circle\StatusEditRequest;
use App\Repositories\ACL\LogRepository;
use App\Repositories\Core_Data\CircleRepository;
use App\Traits\CoreData;
use App\Traits\CoreDataa;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class CircleController extends Controller
{
    use CoreDataa;
    public function index()
    {
        $datas = $this->circleRepository->Get_All_Datas();
        $this->logRepository->Create_Data(''.Auth::user()->id.'','عرض','فتح قائمه الدوائر فى لوحه التحكم');
        return view('admin.core_data.circle.index',compact('datas'));
    }

    public function create()
    {
        $this->logRepository->Create_Data(''.Auth::user()->id.'','عرض','فتح صفحه اضافه بلد فى لوحه التحكم');
        return view('admin.core_data.circle.create');
    }

    public function store(CreateRequest $request)
    {
        $this->circleRepository->Create_Data($request);
        $this->logRepository->Create_Data(''.Auth::user()->id.'','اضافه','اضافه بيانات الدائرة فى لوحه التحكم');
        return redirect('/admin/circle/index')->with('message', 'اضافه بيانات الدائرة بنجاح');
    }

    public function edit($id)
    {
        $data = $this->circleRepository->Get_One_Data($id);
        $this->logRepository->Create_Data(''.Auth::user()->id.'','عرض','فتح صفحه تعديل الدائرة فى لوحه التحكم '.$data->title." / ".$data->id);
        return view('admin.core_data.circle.edit',compact('data'));
    }

    public function update(EditRequest $request, $id)
    {
        $this->circleRepository->Update_Data($request, $id);
        $this->logRepository->Create_Data(''.Auth::user()->id.'','تعديل','تعديل بيانات الدائرة فى لوحه التحكم');
        return redirect('/admin/circle/index')->with('message', 'تعديل بيانات الدائرة بنجاح');
    }

    public function change_status($id)
    {
        $this->circleRepository->Update_Status_One_Data($id);
        $this->logRepository->Create_Data(''.Auth::user()->id.'','تغير حاله','تغير حاله الدائرة فى لوحه التحكم');
        return redirect()->back()->with('message', 'تغير حاله الدائرة بنجاح');
    }

    public function change_many_status(StatusEditRequest $request)
    {
        $this->circleRepository->Update_Status_Datas($request);
        $this->logRepository->Create_Data(''.Auth::user()->id.'','تغير حاله','تغير حاله الدوائر فى لوحه التحكم');
        return redirect()->back()->with('message', 'تم تغير حاله الدوائر بنجاح');
    }
}
