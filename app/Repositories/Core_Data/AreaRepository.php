<?php

namespace App\Repositories\Core_Data;

use App\Http\Requests\Admin\Core_Data\Area\CreateRequest;
use App\Http\Requests\Admin\Core_Data\Area\EditRequest;
use App\Http\Requests\Admin\Core_Data\Area\StatusEditRequest;
use App\Interfaces\Core_Data\AreaInterface;
use App\Traits\CoreData;
use Illuminate\Http\Request;

class AreaRepository implements AreaInterface
{

    use CoreData;

    public function Get_All_Datas()
    {
        return $this->area->orderby('order', 'asc')->get();
    }

    public function Create_Data(CreateRequest $request)
    {
        $data['status'] = 1;
        $this->area->create(array_merge($request->all(), $data));
    }

    public function Get_One_Data($id)
    {
        return $this->area->find($id);
    }

    public function Update_Data(EditRequest $request, $id)
    {
        $area = $this->Get_One_Data($id);
        $area->update($request->all());
    }

    public function Update_Status_One_Data($id)
    {
        $area = $this->Get_One_Data($id);
        $this->change_status($area);
    }

    public function Get_Many_Data(Request $request)
    {
        return $this->area->wherein('id', $request->change_status)->get();
    }

    public function Update_Status_Datas(StatusEditRequest $request)
    {
        $areas = $this->Get_Many_Data($request);
        $this->change_status($areas);
    }

    public function Get_List_Data()
    {
        return $this->area->select('title', 'id')->status()->orderby('order', 'asc')->get();
    }

    public function Get_List_Areas_Json()
    {
        return $this->area->select('title', 'id')->status()->orderby('order', 'asc')->get();
    }
}
