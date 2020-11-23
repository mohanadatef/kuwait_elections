<?php

namespace App\Repositories\Setting;


use App\Http\Requests\Admin\Setting\Setting\CreateRequest;
use App\Http\Requests\Admin\Setting\Setting\EditRequest;
use App\Http\Resources\Setting\SettingResource;
use App\Interfaces\Setting\SettingInterface;
use App\Models\Setting\Setting;

class SettingRepository implements SettingInterface
{

    protected $setting;

    public function __construct(Setting $setting)
    {
        $this->setting = $setting;
    }

    public function Get_All_Data()
    {
        return $this->setting->all();
    }

    public function Create_Data(CreateRequest $request)
    {
        $imageName = $request->image->getClientOriginalname().'-'.time() .'.'.Request()->image->getClientOriginalExtension();
        Request()->image->move(public_path('images/setting'), $imageName);
        $data['image'] = $imageName;
        $logoName = $request->logo->getClientOriginalname().'-'.time().'-logo.'.Request()->logo->getClientOriginalExtension();
        Request()->logo->move(public_path('images/setting'), $logoName);
        $data['logo'] = $logoName;
        $this->setting->create(array_merge($request->all(),$data));
    }

    public function Get_One_Data($id)
    {
        return $this->setting->find($id);
    }

    public function Update_Data(EditRequest $request, $id)
    {
        $data[]=0;
        $setting = $this->Get_One_Data($id);
        if ($request->image != null) {
            $imageName = $request->image->getClientOriginalname().'-'.time().'.'.Request()->image->getClientOriginalExtension();
            Request()->image->move(public_path('images/setting'), $imageName);
            $data['image'] = $imageName;
        }
        if ($request->logo != null) {
            $logoName = $request->logo->getClientOriginalname().'-'.time().'-logo.'.Request()->logo->getClientOriginalExtension();
            Request()->logo->move(public_path('images/setting'), $logoName);
            $data['logo'] = $logoName;
        }
        if($data != null)
        {
            $setting->update(array_merge($request->all(),$data));
        }
        else
        {
            $setting->update($request->all());
        }
    }

    public function Get_all_In_Response()
    {
       return new SettingResource($this->setting->first());
    }
}
