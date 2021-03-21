<?php

namespace App\Http\Controllers\Admin\ACL;

use App\Http\Requests\Admin\ACl\Permission\CreateRequest;
use App\Http\Requests\Admin\ACl\Permission\EditRequest;y;
use App\Traits\CoreDataa;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class PermissionController extends Controller
{
   use CoreDataa;

    public function index()
    {
        $datas = $this->permissionRepository->Get_All_Datas();
        $this->logRepository->Create_Data(''.Auth::user()->id.'','عرض','فتح قائمه الاذنات فى لوحه التحكم');
        return view('admin.acl.permission.index',compact('datas'));
    }

    public function create()
    {
        $this->logRepository->Create_Data(''.Auth::user()->id.'','عرض','فتح صفحه اضافه اذن فى لوحه التحكم');
        return view('admin.acl.permission.create');
    }

    public function store(CreateRequest $request)
    {
        $this->permissionRepository->Create_Data($request);
        $this->logRepository->Create_Data(''.Auth::user()->id.'','تسجيل','اضافه اذن فى صفحه على لوحه التحكم');
        return redirect('/admin/permission/index')->with('message', 'تم اضافه الاذن بنجاح');
    }

    public function edit($id)
    {
        $data = $this->permissionRepository->Get_One_Data($id);
        $this->logRepository->Create_Data(''.Auth::user()->id.'','عرض','فتح صفحه الاذن للتعديل على لوحه التحكم '.$data->name." / ".$data->id);
        return view('admin.acl.permission.edit',compact('data'));
    }

    public function update(EditRequest $request, $id)
    {
        $this->permissionRepository->Update_Data($request, $id);
        $this->logRepository->Create_Data(''.Auth::user()->id.'','تعديل','تم تعديل الاذن فى لوحه التحكم');
        return redirect('/admin/permission/index')->with('message', 'تم تعديل بنجاح');
    }
}
