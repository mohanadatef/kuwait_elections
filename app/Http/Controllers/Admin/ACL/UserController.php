<?php

namespace App\Http\Controllers\Admin\ACL;

use App\Http\Requests\Admin\ACl\User\PasswordRequest;
use App\Http\Requests\Admin\ACl\User\CreateRequest;
use App\Http\Requests\Admin\ACl\User\EditRequest;
use App\Http\Requests\Admin\ACl\User\StatusEditRequest;
use App\Traits\CoreDataa;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    use CoreDataa;

    public function index()
    {
        $datas = $this->userRepository->Get_All_Datas();
        $this->logRepository->Create_Data('' . Auth::user()->id . '', 'عرض', 'فتح قائمه المستخدمين على لوحه التحكم');
        return view('admin.acl.user.index', compact('datas'));
    }

    public function create()
    {
        $role = $this->roleRepository->Get_List_Data();
        $circle = $this->circleRepository->Get_List_Data();
        $area = $this->areaRepository->Get_List_Data();
        $this->logRepository->Create_Data('' . Auth::user()->id . '', 'عرض', 'فتح صفحه اضافه مستخدم على لوحه التحكم');
        return view('admin.acl.user.create', compact('role', 'circle', 'area'));
    }

    public function store(CreateRequest $request)
    {
        $this->userRepository->Create_Data($request);
        $this->logRepository->Create_Data('' . Auth::user()->id . '', 'تسجيل', 'تم اضافه مستخدم جديد على لوحه التحكم');
        return redirect('/admin/user/index')->with('message', 'تم التسجيل  المستخدم بنجاح');
    }

    public function edit($id)
    {
        $data = $this->userRepository->Get_One_Data($id);
        $role = $this->roleRepository->Get_List_Data();
        $circle = $this->circleRepository->Get_List_Data();
        $role_user = $this->userRepository->Get_Role_For_Data($data->id);
        $area = $this->areaRepository->Get_List_Data();
        $this->logRepository->Create_Data('' . Auth::user()->id . '', 'عرض', 'فتح صفحه المستخدم للتعديل على لوحه التحكم' . $data->username . " / " . $data->id);
        return view('admin.acl.user.edit', compact('data', 'role', 'role_user', 'area', 'circle'));

    }

    public function update(EditRequest $request, $id)
    {
        $this->userRepository->Update_Data($request, $id);
        $this->logRepository->Create_Data('' . Auth::user()->id . '', 'تعديل', 'على لوحه التحكمتم التعديل بيانات المستخدم على لوحه التحكم');
        return redirect('/admin/user/index')->with('message', 'تم التعديل بنجاح');
    }

    public function password($id)
    {
        $data = $this->userRepository->Get_One_Data($id);
        $this->logRepository->Create_Data('' . Auth::user()->id . '', 'عرض', 'عرض صفحه الكلمه السر لتعديل للمستخدم على لوحه التحكم' . $data->username . " / " . $data->id);
        return view('admin.acl.user.password', compact('data'));
    }

    public function change_password(PasswordRequest $request, $id)
    {
        $this->userRepository->Update_Password_Data($request, $id);
        $this->logRepository->Create_Data('' . Auth::user()->id . '', 'تعديل كلمه السر', 'تم تعديل كلمه السر للمستخدم على لوحه التحكم');
        return redirect('/admin/user/index')->with('message', 'تم تعديل كلمه السر للمستخدم بنجاح');
    }

    public function change_status($id)
    {
        $this->userRepository->Update_Status_One_Data($id);
        $this->logRepository->Create_Data('' . Auth::user()->id . '', 'تغير الحاله', 'تغير حاله المستخدم فى لوحه التحكم');
        return redirect()->back()->with('message', 'تم تغير حاله المستخدم بنجاح');
    }

    public function change_many_status(StatusEditRequest $request)
    {
        $this->userRepository->Update_Status_Datas($request);
        $this->logRepository->Create_Data('' . Auth::user()->id . '', 'تغير حاله', 'تغير حاله اكثر من مستخدم فى لوحه التحكم');
        return redirect()->back()->with('message', 'تم تغير الحاله للمستخدمين بنجاح');
    }

    public function upgrad_user($id)
    {
        $this->userRepository->Upgrad($id);
        $this->logRepository->Create_Data('' . Auth::user()->id . '', 'تغير نوع المستخدم', 'تغير نوع  مستخدم فى لوحه التحكم');
        return redirect()->back()->with('message', 'تم تغير نوع للمستخدم بنجاح');
    }

    public function Get_List_Nominee_Circle(Request $request)
    {
        $data = $this->userRepository->Get_List_Nominee_Circle($request->circle_id);
        return response()->json($data);
    }
}
