<?php

namespace App\Http\Controllers\Admin\ACL;

use App\Http\Requests\Admin\ACl\Role\CreateRequest;
use App\Http\Requests\Admin\ACl\Role\EditRequest;
use App\Traits\CoreDataa;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    use CoreDataa;

    public function index()
    {
        $datas = $this->roleRepository->Get_All_Datas();
        $this->logRepository->Create_Data(''.Auth::user()->id.'','عرض','فتح قائمه انواع المستخدمين فى لوحه التحكم');
        return view('admin.acl.role.index',compact('datas'));
    }

    public function create()
    {
        $permission = $this->permissionRepository->Get_List_Data();
        $this->logRepository->Create_Data(''.Auth::user()->id.'','عرض','فتح صفحه اضافه نوع مستخدم على لوحه التحكم');
        return view('admin.acl.role.create',compact('permission'));
    }

    public function store(CreateRequest $request)
    {
        $this->roleRepository->Create_Data($request);
        $this->logRepository->Create_Data(''.Auth::user()->id.'','تسجيل','تم حفظ نوع مستخدم فى لوحه التحكم');
        return redirect('/admin/role/index')->with('message', 'تم اضافه نوع المستخدم بنجاح');
    }

    public function edit($id)
    {
        $data = $this->roleRepository->Get_One_Data($id);
        $permission = $this->permissionRepository->Get_List_Data();
        $permission_role = $this->roleRepository->Get_Permission_For_Data($data->id);
        $this->logRepository->Create_Data(''.Auth::user()->id.'','عرض','فتح نوع المستخدم للتعديل على لوحه التحكم '.$data->name." / ".$data->id);
        return view('admin.acl.role.edit',compact('data','permission','permission_role'));
    }

    public function update(EditRequest $request, $id)
    {
        $this->roleRepository->Update_Data($request, $id);
        $this->logRepository->Create_Data(''.Auth::user()->id.'','تعديل','تم تعديل نوع المستخدم على لوحه التحكم');
        return redirect('/admin/role/index')->with('message', 'تم تعديل توع المستخدم بنجاح');
    }
}
