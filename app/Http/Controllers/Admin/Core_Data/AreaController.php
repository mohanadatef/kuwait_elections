<?php

namespace App\Http\Controllers\Admin\Core_Data;

use App\Http\Requests\Admin\Core_Data\Area\CreateRequest;
use App\Http\Requests\Admin\Core_Data\Area\EditRequest;
use App\Http\Requests\Admin\Core_Data\Area\StatusEditRequest;
use App\Repositories\ACL\LogRepository;
use App\Repositories\Core_Data\AreaRepository;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AreaController extends Controller
{
    private $areaRepository;
    private $logRepository;
    public function __construct(AreaRepository $areaRepository,LogRepository $LogRepository)
    {
        $this->areaRepository = $areaRepository;
        $this->logRepository = $LogRepository;
    }

    public function index()
    {
        $datas = $this->areaRepository->Get_All_Datas();
        $this->logRepository->Create_Data(''.Auth::user()->id.'','عرض','فتح قائمه المناطق فى لوحه التحكم');
        return view('admin.core_data.area.index',compact('datas'));
    }

    public function create()
    {
        $this->logRepository->Create_Data(''.Auth::user()->id.'','عرض','فتح صفحه اضافه منطقه');
        return view('admin.core_data.area.create',compact('country'));
    }

    public function store(CreateRequest $request)
    {
        $this->areaRepository->Create_Data($request);
        $this->logRepository->Create_Data(''.Auth::user()->id.'','اضافه','اضافه منطقه فى لوحده التحكم');
        return redirect('/admin/area/index')->with('message', 'تم اضافه المنطقه بنجاح');
    }

    public function edit($id)
    {
        $data = $this->areaRepository->Get_One_Data($id);
        $this->logRepository->Create_Data(''.Auth::user()->id.'','عرض','فتح صفحه تعديل منطقه فى لوحه التحكم '.$data->name." / ".$data->id);
        return view('admin.core_data.area.edit',compact('data','country','city'));
    }

    public function update(EditRequest $request, $id)
    {
        $this->areaRepository->Update_Data($request, $id);
        $this->logRepository->Create_Data(''.Auth::user()->id.'','تعديل','تعديل منطقه فى لوحه التحكم');
        return redirect('/admin/area/index')->with('message', 'تم تعديل بيانات المنطقه بنجاح');
    }

    public function change_status($id)
    {
        $this->areaRepository->Update_Status_One_Data($id);
        $this->logRepository->Create_Data(''.Auth::user()->id.'','تغير حاله','تغير حاله منطقه فى لوحه التحكم');
        return redirect()->back()->with('message', 'Edit Statues Is Done!');
    }

    public function change_many_status(StatusEditRequest $request)
    {
        $this->areaRepository->Update_Status_Datas($request);
        $this->logRepository->Create_Data(''.Auth::user()->id.'','تغير حاله','تغير حاله المناطق فى لوحده التحكم');
        return redirect()->back()->with('message', 'Edit Statues Is Done!');
    }

    public function Get_List_Areas_Json()
    {
        $area = DB::table("areas")
            ->where("status", "=",1)
            ->pluck("title", "id");
        return response()->json($area);
    }

}
