<?php

namespace App\Http\Controllers\Api\Mobile\ACL;

use App\Http\Resources\Mobile\ACL\LogResource;
use App\Repositories\ACL\LogRepository;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class LogController extends Controller
{
    private $logRepository;

    public function __construct(LogRepository $LogRepository)
    {
        $this->middleware('auth:api');
        $this->logRepository = $LogRepository;
    }

    public function index()
    {
        $log = $this->logRepository->Get_All_Datas_User(Auth::User()->id);
        $this->logRepository->Create_Data(''.Auth::User()->id.'', 'عرض', 'عرض سجل النشاطات');
        if ($log != null) {
            $log =  LogResource::collection($log);
        }
        return response(['status'=>1,'log' => $log], 400);
    }
}
