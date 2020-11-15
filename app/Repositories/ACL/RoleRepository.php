<?php

namespace App\Repositories\ACL;

use App\Http\Requests\Admin\ACl\Role\CreateRequest;
use App\Http\Requests\Admin\ACl\Role\EditRequest;
use App\Interfaces\ACL\RoleInterface;
use App\Models\ACL\Permission_role;
use App\Models\ACL\Role;
use Illuminate\Support\Facades\Auth;


class RoleRepository implements RoleInterface
{

    protected $role;
    protected $permission_role;

    public function __construct(Role $role,Permission_role $permission_role)
    {
        $this->role = $role;
        $this->permission_role = $permission_role;
    }

    public function Get_All_Datas()
    {
            return $this->role->all();
    }

    public function Create_Data(CreateRequest $request)
    {
        $this->role->permission()->sync((array)$request->input('permission_id'));
        $this->role->create($request->all());
    }

    public function Get_One_Data($id)
    {
        return $this->role->find($id);
    }

    public function Update_Data(EditRequest $request, $id)
    {
       $role = $this->Get_One_Data($id);
        $role->update($request->all());
        $role->permission()->sync((array)$request->input('permission'));
        $role->update();
    }

    public function Get_List_Data()
    {

        if(Auth::user()->role()->first()->name == 'Develper')
        {
            return $this->role->select('display_name', 'id')->get();
        }
        else
        {
            return $this->role->select('display_name', 'id')->where('id','!=',1)->get();
        }
    }

    public function Get_Permission_For_Data($id)
    {
        return $this->permission_role->where('role_id',$id)->get();
    }
}
