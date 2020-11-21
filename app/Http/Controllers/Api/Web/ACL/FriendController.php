<?php

namespace App\Http\Controllers\Api\Web\ACL;

use App\Http\Resources\Web\ACL\FriendResource;
use App\Models\ACL\Friend;
use App\Repositories\ACL\LogRepository;
use App\Repositories\ACL\UserRepository;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;


class FriendController extends Controller
{
    private $logRepository;
    private $userRepository;

    public function __construct(LogRepository $LogRepository, UserRepository $UserRepository)
    {
        $this->middleware('auth:api', ['except' => ['all_friend', 'all_request_friend']]);
        $this->logRepository = $LogRepository;
        $this->userRepository = $UserRepository;
    }

    public function send_friend(Request $request)
    {
        $user_send = User::find($request->user_send_id);
        if (!$user_send) {
            return response(['status' => 0, 'data' => array(), 'message' => 'رقم المستخدم المرسل خطاء'], 400);
        }
        $user_receive = User::find($request->user_receive_id);
        if (!$user_receive) {
            return response(['status' => 0, 'data' => array(), 'message' => 'رقم المستخدم المرسل اليه خطاء'], 400);
        }
        $friend = new Friend();
        $friend->user_send_id = $user_send->id;
        $friend->user_receive_id = $user_receive->id;
        $friend->status = 0;
        $friend->save();
        $this->logRepository->Create_Data('' . $user_send->id . '', 'ارسال', 'ارسال طلب صداقه');
        return response(['status' => 1, 'request_friend_number' => $friend->id, 'message' => 'تم ارسال طلب الصداقه'], 200);
    }

    public function accept_friend(Request $request)
    {
        $user = User::find($request->user_id);
        if (!$user) {
            return response(['status' => 0, 'data' => array(), 'message' => 'خطا فى تحميل البيانات المستخدم'], 400);
        }
        $friend = Friend::find($request->request_friend_number);
        if ($friend) {
            $friend->status = 1;
            $friend->update();
            $this->logRepository->Create_Data('' . $user->id . '', 'قبول', 'قبول طلب صداقه');
            return response(['status' => 1, 'data' => array(), 'message' => 'تم قبول طلب صداقه'], 200);
        }
        return response(['status' => 0, 'data' => array(), 'message' => 'خطا فى تحميل البيانات طلب الصداقه'], 400);

    }

    public function delete_friend(Request $request)
    {
        $user = User::find($request->user_id);
        if (!$user) {
            return response(['status' => 0, 'data' => array(), 'message' => 'خطا فى تحميل البيانات المستخدم'], 400);
        }
        $friend = Friend::find($request->request_friend_number);
        if ($friend) {
            $friend->delete();
            $this->logRepository->Create_Data('' . $user->id . '', 'مسح', 'مسح  الصداقه');
            return response(['status' => 1, 'data' => array(), 'message' => 'تم الغاء الصداقه'], 200);
        }
        return response(['status' => 0, 'data' => array(), 'message' => 'خطا فى تحميل البيانات'], 400);

    }

    public function all_friend(Request $request)
    {
        $user = User::find($request->user_id);
        if (!$user) {
            return response(['status' => 0, 'data' => array(), 'message' => 'خطا فى تحميل البيانات المستخدم'], 400);
        }
        $friend = Friend::where('user_send_id', $user->id)->where('status', 1)
            ->orwhere('user_receive_id', $user->id)->where('status', 1)
            ->get();
        if ($request->status_auth == 1) {
            $this->logRepository->Create_Data('' . $user->id . '', 'عرض', 'عرض الاصدقاء');
        }
        if ($friend) {
            return response(['status' => 1,
               'friend' => FriendResource::collection($friend),
                'message' => 'جميع الاصدقاء'], 200);
        }
        return response(['status' => 1, 'friend' => array(), 'message' => 'لا يوجد بيانات لعرضها'], 200);

    }

    public function all_request_friend(Request $request)
    {
        $user = User::find($request->user_id);
        if (!$user) {
            return response(['status' => 0, 'data' => array(), 'message' => 'خطا فى تحميل البيانات المستخدم'], 400);
        }
        $request_friend = Friend::where('user_receive_id', $user->id)->where('status', 0)->get();
        if ($request->status_auth == 1) {
            $this->logRepository->Create_Data('' . $user->id . '', 'عرض', 'عرض طلبات صداقه');
        }
        if ($request_friend) {
            return response(['status' => 1,
               'request_friend' => FriendResource::collection($request_friend),
                'message' => 'كل طلبات الصداقه'], 200);
        }
        return response(['status' => 1,
            'data' => array(),
            'message' => 'كل طلبات الصداقه'], 200);
    }
}
