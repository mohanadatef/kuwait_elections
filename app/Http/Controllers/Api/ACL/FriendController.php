<?php

namespace App\Http\Controllers\Api\ACL;

use App\Http\Resources\ACL\FriendResource;
use App\Models\ACL\Friend;
use App\Repositories\ACL\LogRepository;
use App\Repositories\ACL\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;


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
        $user_send = $this->userRepository->Get_One_Data($request->user_send_id);
        if (!$user_send) {
            return response(['status' => 0, 'data' => array(), 'message' => 'رقم المستخدم المرسل خطاء'], 400);
        }
        $user_receive = $this->userRepository->Get_One_Data($request->user_receive_id);
        if (!$user_receive) {
            return response(['status' => 0, 'data' => array(), 'message' => 'رقم المستخدم المرسل اليه خطاء'], 400);
        }
        if ($user_send->id == Auth::User()->id) {
            if ($user_send->status == 0) {
                return response(['status' => 0, 'data' => array(), 'message' => 'برجاء الاتصال بخدمه العملاء'], 400);
            }
            $friend = Friend::where('user_send_id', $user_send->id)->where('user_receive_id', $user_receive->id)
                ->orwhere('user_receive_id', $user_send->id)->where('user_send_id', $user_receive->id)->first();
            if (!$friend) {
                $friend = new Friend();
                $friend->user_send_id = $user_send->id;
                $friend->user_receive_id = $user_receive->id;
                $friend->status = 0;
                $friend->save();
                $this->logRepository->Create_Data('' . $user_send->id . '', 'ارسال', 'ارسال طلب صداقه');
                return response(['status' => 1, 'data' => ['request_friend_number' => $friend->id], 'message' => 'تم ارسال طلب الصداقه'], 200);
            }
            return response(['status' => 0, 'data' => array(), 'message' => 'يوجد صداقه مسبقا'], 400);
        }
        return response(['status' => 0, 'data' => array(), 'message' => 'لا يمكن اتمام الطلب'], 400);
    }

    public function accept_friend(Request $request)
    {
        $user = $this->userRepository->Get_One_Data($request->user_id);
        if (!$user) {
            return response(['status' => 0, 'data' => array(), 'message' => 'خطا فى تحميل البيانات المستخدم'], 400);
        }
        $friend = Friend::find($request->request_friend_number);
        if ($friend) {
            if ($user->id == Auth::user()->id && $friend->user_receive_id == Auth::user()->id) {
                $friend->status = 1;
                $friend->update();
                $this->logRepository->Create_Data('' . $user->id . '', 'قبول', 'قبول طلب صداقه');
                return response(['status' => 1, 'data' => array(), 'message' => 'تم قبول طلب صداقه'], 200);
            }
            return response(['status' => 0, 'data' => array(), 'message' => 'لا يمكن اتمام الطلب'], 400);
        }
        return response(['status' => 0, 'data' => array(), 'message' => 'خطا فى تحميل البيانات طلب الصداقه'], 400);

    }

    public function delete_friend(Request $request)
    {
        $user = $this->userRepository->Get_One_Data($request->user_id);
        if (!$user) {
            return response(['status' => 0, 'data' => array(), 'message' => 'خطا فى تحميل البيانات المستخدم'], 400);
        }
        if ($user->status == 0) {
            return response(['status' => 0, 'data' => array(), 'message' => 'برجاء الاتصال بخدمه العملاء'], 400);
        }
        $friend = Friend::find($request->request_friend_number);
        if ($friend) {
            if ($user->id == Auth::user()->id && ($friend->user_send_id == Auth::user()->id || $friend->user_receive_id == Auth::user()->id)) {
                $friend->delete();
                $this->logRepository->Create_Data('' . $user->id . '', 'مسح', 'مسح  الصداقه');
                return response(['status' => 1, 'data' => array(), 'message' => 'تم الغاء الصداقه'], 200);
            }
            return response(['status' => 0, 'data' => array(), 'message' => 'لا يمكن اتمام الطلب'], 400);
        }
        return response(['status' => 0, 'data' => array(), 'message' => 'خطا فى تحميل البيانات'], 400);

    }

    public function all_friend(Request $request)
    {
        $user = $this->userRepository->Get_One_Data($request->user_id);
        if (!$user) {
            return response(['status' => 0, 'data' => array(), 'message' => 'خطا فى تحميل البيانات المستخدم'], 400);
        }
        if ($user->status == 0) {
            return response(['status' => 0, 'data' => array(), 'message' => 'برجاء الاتصال بخدمه العملاء'], 400);
        }
        $friend = Friend::where('user_send_id', $user->id)->where('status', 1)
            ->orwhere('user_receive_id', $user->id)->where('status', 1)
            ->get();
        if ($request->status_auth == 1) {
            $this->logRepository->Create_Data('' . $user->id . '', 'عرض', 'عرض الاصدقاء');
        }
        if ($friend) {
            return response(['status' => 1,
                'data' => ['friend' => FriendResource::collection($friend)],
                'message' => 'جميع الاصدقاء'], 200);
        }
        return response(['status' => 1, 'data' => ['friend' => array()], 'message' => 'لا يوجد بيانات لعرضها'], 200);

    }

    public function all_request_friend(Request $request)
    {
        $user = $this->userRepository->Get_One_Data($request->user_id);
        if (!$user) {
            return response(['status' => 0, 'data' => array(), 'message' => 'خطا فى تحميل البيانات المستخدم'], 400);
        }
        if ($user->status == 0) {
            return response(['status' => 0, 'data' => array(), 'message' => 'برجاء الاتصال بخدمه العملاء'], 400);
        }
        $request_friend = Friend::where('user_receive_id', $user->id)->where('status', 0)->get();
        if ($request->status_auth == 1) {
            $this->logRepository->Create_Data('' . $user->id . '', 'عرض', 'عرض طلبات صداقه');
        }
        if ($request_friend) {
            return response(['status' => 1,
                'data' => ['request_friend' => FriendResource::collection($request_friend)],
                'message' => 'كل طلبات الصداقه'], 200);
        }
        return response(['status' => 1,
            'data' => array(),
            'message' => 'كل طلبات الصداقه'], 200);
    }
}
