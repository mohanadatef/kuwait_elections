<?php

namespace App\Http\Controllers\Api\Web\ACL;

use App\Http\Resources\Web\ACL\FriendResource;
use App\Http\Resources\Web\ACL\UserResource;
use App\Models\ACL\Friend;
use App\Repositories\ACL\LogRepository;
use App\Repositories\ACL\UserRepository;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class FriendController extends Controller
{
    private $logRepository;
    private $userRepository;

    public function __construct(LogRepository $LogRepository, UserRepository $UserRepository)
    {
        $this->middleware('auth:api');
        $this->logRepository = $LogRepository;
        $this->userRepository = $UserRepository;
    }

    public function send_friend(Request $request)
    {
        $user = User::find($request->user_id);
        if ($user) {
            $friend = new Friend();
            $friend->user_send_id = Auth::User()->id;
            $friend->user_receive_id = $request->user_id;
            $friend->status = 0;
            $friend->save();
            $this->logRepository->Create_Data('' . Auth::User()->id . '', 'ارسال', 'ارسال طلب صداقه');
            return response(['status' => 1, 'request_friend_number' => $friend->id], 200);
        }
        return response(['status' => 0], 400);
    }

    public function accept_friend(Request $request)
    {
        $friend = Friend::find($request->request_friend_number);
        if ($friend) {
            $friend->status = 1;
            $friend->update();
            $this->logRepository->Create_Data('' . Auth::User()->id . '', 'قبول', 'قبول طلب صداقه');
            return response(['status' => 1, 'message' => 'تم قبول طلب صداقه'], 200);
        }
        return response(['status' => 0, 'message' => 'خطا فى تحميل البيانات'], 400);
    }

    public function delete_friend(Request $request)
    {
        $friend = Friend::find($request->request_friend_number);
        if ($friend) {
            $friend->delete();
            $this->logRepository->Create_Data('' . Auth::User()->id . '', 'مسح', 'مسح  الصداقه');
            return response(['status' => 1], 200);
        }
        return response(['status' => 0], 400);
    }

    public function all_friend()
    {
        $friend = Friend::where('user_send_id', Auth::User()->id)->where('status', 1)
      ->orwhere('user_receive_id', Auth::User()->id)->where('status', 1)
            ->get();
        $this->logRepository->Create_Data('' . Auth::User()->id . '', 'عرض', 'عرض الاصدقاء');
        if ($friend) {
                $friend = FriendResource::collection($friend);
        }
        return response(['status' => 1, 'friend' => $friend], 200);
    }

    public function all_request_friend()
    {
        $request_friend = Friend::where('user_receive_id', Auth::User()->id)->where('status', 0)->get();
        $this->logRepository->Create_Data('' . Auth::User()->id . '', 'عرض', 'عرض طلبات صداقه');
        if ($request_friend) {
               $request_friend = FriendResource::collection($request_friend);
        }
        return response(['status' => 1, 'request_friend' => $request_friend], 200);
    }
}
