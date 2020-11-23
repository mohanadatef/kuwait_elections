<?php

namespace App\Http\Controllers\Api\Setting;

use App\Http\Controllers\Controller;
use App\Repositories\Setting\SettingRepository;


class SettingController extends Controller
{
    private $settingRepository;

    public function __construct(SettingRepository $SettingRepository)
    {
        $this->settingRepository = $SettingRepository;
    }
    public function index()
    {
        return response(['status'=>1,'data'=>['setting' => $this->settingRepository->Get_all_In_Response()],'message'=>'اعدادات الشركه'], 200);
    }
}

?>