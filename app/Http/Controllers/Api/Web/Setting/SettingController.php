<?php

namespace App\Http\Controllers\Api\Web\Setting;

use App\Http\Controllers\Controller;
use App\Http\Resources\Web\Setting\SettingResource;
use App\Models\Setting\Setting;
use App\Repositories\ACL\LogRepository;
use Illuminate\Support\Facades\Auth;


class SettingController extends Controller
{
    private $logRepository;

    public function __construct(LogRepository $LogRepository)
    {
        $this->logRepository = $LogRepository;
    }
    public function index()
    {
        $datas = Setting::find(1);
        if(Auth::user() == true)
        {
            $this->logRepository->Create_Data(''.Auth::user()->id.'', 'عرض', 'عرض الاعدادات  Api' );
        }
        return response([
            'data' => array(new SettingResource($datas)),
        ], 200);

    }


}

?>