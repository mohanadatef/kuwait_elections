<?php

namespace App\Repositories\ACL;

use App\Http\Requests\Admin\ACl\Permission\CreateRequest;
use App\Http\Requests\Admin\ACl\Permission\EditRequest;
use App\Interfaces\ACL\PermissionInterface;
use App\Models\ACL\Permission;
use Illuminate\Support\Facades\Auth;


class PermissionRepository implements PermissionInterface
{

    protected $permission;
    protected $permission_permission;

    public function __construct(Permission $permission)
    {
        $this->permission = $permission;
    }

    public function Get_All_Datas()
    {
        if(Auth::user()->role()->first()->name == 'Develper')
        {
            return $this->permission->all();
        }
        else
        {
            return $this->permission->wherein('id','!=',[20,21,22,23,24,25])->get();
        }
    }

    public function Create_Data(CreateRequest $request)
    {
        $this->permission->create($request->all());
    }

    public function Get_One_Data($id)
    {
        return $this->permission->find($id);
    }

    public function Update_Data(EditRequest $request, $id)
    {
       $permission = $this->Get_One_Data($id);
        $permission->update($request->all());
    }


    public function Get_List_Data()
    {
       if(Auth::user()->role()->first()->name == 'Develper')
        {
            return $this->permission->select('display_name', 'id')->get();
        }
        else
        {
            return $this->permission->select('display_name', 'id')->wherein('id','!=',[20,21,22,23,24,25])->get();
        }
    }

}
