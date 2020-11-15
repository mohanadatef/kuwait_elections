<?php

namespace App\Repositories\Setting;

use App\Http\Requests\Admin\Setting\Privacy\CreateRequest;
use App\Http\Requests\Admin\Setting\Privacy\EditRequest;
use App\Interfaces\Setting\PrivacyInterface;
use App\Models\Setting\Privacy;

class PrivacyRepository implements PrivacyInterface
{

    protected $Privacy;

    public function __construct(Privacy $Privacy)
    {
        $this->Privacy = $Privacy;
    }

    public function Get_All_Data()
    {
        return $this->Privacy->all();
    }

    public function  Create_Data(CreateRequest $request)
    {
        $this->Privacy->create($request->all());
    }

    public function Get_One_Data($id)
    {
        return $this->Privacy->find($id);
    }

    public function Update_Data(EditRequest $request, $id)
    {
        $Privacy = $this->Get_One_Data($id);
        $Privacy->update($request->all());
    }
}
