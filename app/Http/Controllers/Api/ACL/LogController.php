<?php

namespace App\Http\Controllers\Api\ACL;

use App\Http\Resources\ACL\LogResource;
use App\Repositories\ACL\LogRepository;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

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
        $user = User::find($request->user_id);
        if (!$user) {
            return response(['status' => 0, 'data' => array(), 'message' => 'خطا فى تحميل البيانات المستخدم'], 400);
        }
        if ($user->status == 0) {
            return response(['status' => 0, 'data' => array(), 'message' => 'برجاء الاتصال بخدمه العملاء'], 400);
        }
        if($user->id == Auth::user()->id)
        {
        $log = $this->logRepository->Get_All_Datas_User($user->id);
        $this->logRepository->Create_Data(''.$user->id.'', 'عرض', 'عرض سجل النشاطات');
        if ($log) {
            return response(['status'=>1,'data'=>['log' => LogResource::collection($log)],'message'=>'سجل نشاطات المستخدم'], 200);
        }
        return response(['status'=>1,'data'=>array(),'message'=>'لا يوجد نشاطات لعرضها'], 200);
        }
        return response(['status' => 0, 'data' => array(), 'message' => 'لا يمكن اتمام الطلب'], 400);
    }
}
