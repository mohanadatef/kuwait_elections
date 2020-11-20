<?php

namespace App\Http\Controllers\Api\Mobile\Setting;

use App\Http\Controllers\Controller;
use App\Http\Resources\Mobile\Setting\SettingResource;
use App\Models\Setting\Setting;


class SettingController extends Controller
{
    public function index()
    {
        $data = Setting::find(1);
        return response(['status'=>1,'data'=>['setting' => new SettingResource($data)],'message'=>'اعدادات الشركه'], 200);
    }
}

?>