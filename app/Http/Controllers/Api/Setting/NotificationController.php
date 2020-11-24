<?php

namespace App\Http\Controllers\Api\Setting;

use App\Http\Controllers\Controller;
use App\Http\Resources\Setting\AboutUsResource;
use App\Http\Resources\Election\NomineeResource;
use App\Http\Resources\Setting\NotificationResource;
use App\Models\Setting\About_Us;
use App\Models\Setting\Notification;
use App\Repositories\ACL\LogRepository;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NotificationController extends Controller
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
        if ($user->id == Auth::user()->id) {
            $notification = Notification::where('user_receive_id', $user->id)->where('status',1)->orwhere('user_receive_id', '0')->where('status',1)->get();
            $this->logRepository->Create_Data('' . Auth::user()->id . '', 'عرض', 'عرض قائمه الاشعارات');
            return response(['status' => 1, 'data' => [
                'count_notification' => count($notification),
                'notification' => NotificationResource::collection($notification)],
                'message' => 'بيانات صفحه عن الشركه'], 200);
        }
        return response(['status' => 0, 'data' => array(), 'message' => 'لا يمكن اتمام الطلب'], 400);
    }
}

?>