<?php

namespace App\Repositories\Setting;



use App\Http\Requests\Admin\Setting\Contact_Us\CreateRequest;
use App\Http\Requests\Admin\Setting\Contact_Us\EditRequest;
use App\Interfaces\Setting\ContactUsInterface;
use App\Models\Setting\Contact_Us;

class ContactUsRepository implements ContactUsInterface
{

    protected $contact_us;

    public function __construct(Contact_Us $contact_us)
    {
        $this->contact_us = $contact_us;
    }

    public function Get_All_Data()
    {
        return $this->contact_us->all();
    }

    public function Create_Data(CreateRequest $request)
    {
        $this->contact_us->create($request->all());
    }

    public function Get_One_Data($id)
    {
        return $this->contact_us->find($id);
    }

    public function Update_Data(EditRequest $request, $id)
    {
        $contact_us = $this->Get_One_Data($id);
            $contact_us->update($request->all());
    }
}
