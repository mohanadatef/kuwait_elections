<?php

namespace App\Http\Controllers\Api\ACL;

use App\Http\Resources\ACL\LogResource;
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

    public function index(Request $request)
    {
        $log = $this->logRepository->Get_All_Datas_User($request->id);
        if ($log != null) {
            $this->logRepository->Create_Data($request->id, 'عرض', 'عرض سجل  Api');
            return response([
                'data' =>  LogResource::collection($log),
            ], 200);
        }
        return response(['message' => 'خطا فى تحضير البيانات'], 400);
    }

}
