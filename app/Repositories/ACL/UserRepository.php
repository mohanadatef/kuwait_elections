<?php

namespace App\Repositories\ACL;


use App\Http\Requests\Admin\ACl\User\PasswordRequest;
use App\Http\Requests\Admin\ACl\User\CreateRequest;
use App\Http\Requests\Admin\ACl\User\EditRequest;
use App\Http\Requests\Admin\ACl\User\StatusEditRequest;
use App\Interfaces\ACL\UserInterface;
use App\Models\ACL\Role_user;
use App\Models\Image;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class UserRepository implements UserInterface
{

    protected $user;
    protected $role_user;

    public function __construct(User $user, Role_user $role_user)
    {
        $this->user = $user;
        $this->role_user = $role_user;
    }

    public function Get_All_Datas()
    {
        return $this->user->with('circle')->select('id', 'circle_id', 'name', 'civil_reference')->orderBy('id', 'DESC')->paginate(100);
    }

    public function Create_Data(CreateRequest $request)
    {
        $data['status'] = 1;
        $data['status_login'] = 0;
        $data['password'] = Hash::make($request->password);
        $this->user->create(array_merge($request->all(), $data))->role()->sync((array)$request->role_id);
        $user = $this->user->where('civil_reference', $request->civil_reference)->first();
        $profile_image = new Image();
        $profile_image->category_id = $user->id;
        $profile_image->category = 'profile';
        $profile_image->status = 1;
        $imageName = $request->image->getClientOriginalname() . '-' . time() . '.' . Request()->image->getClientOriginalExtension();
        Request()->image->move(public_path('images/user/profile'), $imageName);
        $profile_image->image = $imageName;
        $profile_image->save();
    }

    public function Get_One_Data($id)
    {
        return $this->user->find($id);
    }

    public function Update_Data(EditRequest $request, $id)
    {
        $user = $this->Get_One_Data($id);
        $user->role()->sync((array)$request->role_id);
        $user->update($request->all());
        if ($request->image) {
            $profile_image = new Image();
            $profile_image->category_id = $user->id;
            $profile_image->category = 'profile';
            $profile_image->status = 1;
            $imageName = $request->image->getClientOriginalname() . '-' . time() . '.' . Request()->image->getClientOriginalExtension();
            Request()->image->move(public_path('images/user/profile'), $imageName);
            $profile_image->image = $imageName;
            $profile_image->save();
        }
    }

    public function Update_Password_Data(PasswordRequest $request, $id)
    {
        $user = $this->Get_One_Data($id);
        $user->password = Hash::make($request->password);
        $user->update();
    }

    public function Update_Status_One_Data($id)
    {
        $user = $this->Get_One_Data($id);
        if ($user->status == 1) {
            $user->status = '0';
        } elseif ($user->status == 0) {
            $user->status = '1';
        }
        $user->update();
    }

    public function Get_Many_Data(Request $request)
    {
        return $this->user->wherein('id', $request->change_status)->get();
    }

    public function Update_Status_Datas(StatusEditRequest $request)
    {
        $users = $this->Get_Many_Data($request);
        foreach ($users as $user) {
            if ($user->status == 1) {
                $user->status = '0';
            } elseif ($user->status == 0) {
                $user->status = '1';
            }
            $user->update();
        }
    }

    public function Get_Role_For_Data($id)
    {
        return $this->role_user->where('user_id', $id)->get();
    }

    public function Upgrad($id)
    {
        $user = Role_user::where('user_id', $id)->first();
        if ($user->role_id == 3) {
            $user->role_id = 4;
        } elseif ($user->role_id == 4) {
            $user->role_id = 3;
        }
        $user->update();
    }

    public function Get_List_Nominee_Circle($id)
    {
        return DB::table('users')
            ->join('role_user', 'role_user.user_id', '=', 'users.id')
            ->where('role_user.role_id', '=',4)
            ->where('users.circle_id', $id)
            ->where('users.status', 1)
            ->select('users.id','users.name')
            ->pluck('users.name','users.id');
    }
}
