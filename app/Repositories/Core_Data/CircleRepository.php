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

    protected $country;

    public function __construct(Circle $country)
    {
        $this->country = $country;
    }

    public function Get_All_Datas()
    {
        return $this->country->orderby('order','asc')->get();
    }

    public function Create_Data(CreateRequest $request)
    {
        $data['status'] = 1;
        $this->country->create(array_merge($request->all(),$data));
    }

    public function Get_One_Data($id)
    {
        return $this->country->find($id);
    }

    public function Update_Data(EditRequest $request, $id)
    {
       $country = $this->Get_One_Data($id);
        $country->update($request->all());
    }

    public function Update_Status_One_Data($id)
    {
        $country = $this->Get_One_Data($id);
        if ($country->status == 1) {
            $country->status = '0';
        } elseif ($country->status == 0) {
            $country->status = '1';
        }
        $country->update();
    }

    public function Get_Many_Data(Request $request)
    {
      return  $this->country->wherein('id',$request->change_status)->get();
    }

    public function Update_Status_Datas(StatusEditRequest $request)
    {
        $countrys = $this->Get_Many_Data($request);
        foreach($countrys as $country)
        {
            if ($country->status == 1) {
                $country->status = '0';
            } elseif ($country->status == 0) {
                $country->status = '1';
            }
            $country->update();
        }
    }

    public function Get_List_Data()
    {
            return $this->country->select('title','id')->where('status',1)->orderby('order','asc')->get();
    }
}
