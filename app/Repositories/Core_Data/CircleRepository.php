<?php

namespace App\Repositories\Core_Data;

use App\Http\Requests\Admin\Core_Data\Circle\CreateRequest;
use App\Http\Requests\Admin\Core_Data\Circle\EditRequest;
use App\Http\Requests\Admin\Core_Data\Circle\StatusEditRequest;
use App\Interfaces\Core_Data\CircleInterface;
use App\Models\Core_Data\Circle;
use Illuminate\Http\Request;


class CircleRepository implements CircleInterface
{

    protected $circle;

    public function __construct(Circle $circle)
    {
        $this->circle = $circle;
    }

    public function Get_All_Datas()
    {
        return $this->circle->orderby('order','asc')->get();
    }

    public function Create_Data(CreateRequest $request)
    {
        $data['status'] = 1;
        $this->circle->create(array_merge($request->all(),$data));
    }

    public function Get_One_Data($id)
    {
        return $this->circle->find($id);
    }

    public function Update_Data(EditRequest $request, $id)
    {
       $circle = $this->Get_One_Data($id);
        $circle->update($request->all());
    }

    public function Update_Status_One_Data($id)
    {
        $circle = $this->Get_One_Data($id);
        if ($circle->status == 1) {
            $circle->status = '0';
        } elseif ($circle->status == 0) {
            $circle->status = '1';
        }
        $circle->update();
    }

    public function Get_Many_Data(Request $request)
    {
      return  $this->circle->wherein('id',$request->change_status)->get();
    }

    public function Update_Status_Datas(StatusEditRequest $request)
    {
        $circles = $this->Get_Many_Data($request);
        foreach($circles as $circle)
        {
            if ($circle->status == 1) {
                $circle->status = '0';
            } elseif ($circle->status == 0) {
                $circle->status = '1';
            }
            $circle->update();
        }
    }

    public function Get_List_Data()
    {
            return $this->circle->select('title','id')->where('status',1)->orderby('order','asc')->get();
    }
}
