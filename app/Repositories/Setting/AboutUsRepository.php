<?php

namespace App\Repositories\Setting;



use App\Http\Requests\Admin\Setting\About_us\CreateRequest;
use App\Http\Requests\Admin\Setting\About_us\EditRequest;
use App\Interfaces\Setting\AboutUsInterface;
use App\Models\Setting\About_Us;

class AboutUsRepository implements AboutUsInterface
{

    protected $about_us;

    public function __construct(About_Us $about_us)
    {
        $this->about_us = $about_us;
    }

    public function Get_All_Data()
    {
        return $this->about_us->all();
    }

    public function  Create_Data(CreateRequest $request)
    {
        $imageName = $request->image->getClientOriginalname().'-'.time() .'.'.Request()->image->getClientOriginalExtension();
        Request()->image->move(public_path('images/about_us'), $imageName);
        $data['image'] = $imageName;
        $this->about_us->create(array_merge($request->all(),$data));
    }

    public function Get_One_Data($id)
    {
        return $this->about_us->find($id);
    }

    public function Update_Data(EditRequest $request, $id)
    {
        $data[]=0;
        $about_us = $this->Get_One_Data($id);
        if ($request->image != null) {
            $imageName = $request->image->getClientOriginalname().'-'.time().'.'.Request()->image->getClientOriginalExtension();
            Request()->image->move(public_path('images/about_us'), $imageName);
            $data['image'] = $imageName;
        }
        if($data != null)
        {
            $about_us->update(array_merge($request->all(),$data));
        }
        else
        {
            $about_us->update($request->all());
        }
    }
}
