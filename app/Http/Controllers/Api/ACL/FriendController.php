<?php

namespace App\Http\Controllers\Api\ACL;

use App\Http\Resources\ACL\UserResource;
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

    public function check_friend(Request $request)
    {
        $user = User::find($request->user);
        if ($user) {
            $friend_send = Friend::where('user_send_id', Auth::User()->id)->where('user_receive_id', $request->user)->first();
            $friend_receive = Friend::where('user_receive_id', Auth::User()->id)->where('user_send_id', $request->user)->first();
            if ($friend_send) {
                if ($friend_send->status == 0) {
                    return response(['message' => 'بمكن الغاء الطلب', 'request_number' => $friend_send->id], 200);
                } else {
                    return response(['message' => 'يمكن الغاء الصداقه', 'request_number' => $friend_send->id], 200);
                }
            }
            if ($friend_receive) {
                if ($friend_receive->status == 0) {
                    return response(['message' => 'بمكن قبول الطلب', 'request_number' => $friend_receive->id], 200);
                } else {
                    return response(['message' => 'يمكن الغاء الصداقه', 'request_number' => $friend_receive->id], 200);
                }
            }
            if (Auth::User()->id != $user->id) {
                return response(['message' => 'يمكن ارسال الطلب'], 200);
            }
        }
        return response(['message' => 'خطا فى تحميل البيانات'], 400);
    }

    public function send_friend(Request $request)
    {
        $user = User::find($request->user);
        if ($user) {
            $frind = new Friend();
            $frind->user_send_id = Auth::User()->id;
            $frind->user_receive_id = $request->user;
            $frind->save();
            $this->logRepository->Create_Data(''.Auth::User()->id.'', 'ارسال', 'ارسال طلب صداقه  Api' . Auth::User()->username );
            return response(['message' => 'تم ارسال طلب','request_number' => $frind->id], 200);
        }
        return response(['message' => 'خطا فى تحميل البيانات'], 400);
    }

    public function accept_friend(Request $request)
    {
        $user = User::find($request->user);
        if ($user) {
            $frind = Friend::find($request->request_number);
            $frind->status = 1;
            $frind->update();
            $this->logRepository->Create_Data(''.Auth::User()->id.'', 'قبول', 'قبول طلب صداقه  Api' . Auth::User()->username );
            return response(['message' => 'تم قبول طلب','request_number' => $frind->id], 200);
        }
        return response(['message' => 'خطا فى تحميل البيانات'], 400);
    }

    public function delete_friend(Request $request)
    {
        $user = User::find($request->user);
        if ($user) {
            $frind = Friend::find($request->request_number);
            $frind->delete();
            $this->logRepository->Create_Data(''.Auth::User()->id.'', 'مسح', 'مسح  صداقه  Api' . Auth::User()->username );
            return response(['message' => 'تم مسح الصداقه'], 200);
        }
        return response(['message' => 'خطا فى تحميل البيانات'], 400);
    }

    public function all_friend(Request $request)
    {
        $user = User::find($request->user);
        if ($user) {
        $friend_send = DB::table('friends')->where('user_send_id', $request->user)->where('status', 1)->pluck('user_receive_id','id');
        $friend_receive = DB::table('friends')->where('user_receive_id', $request->user)->where('status', 1)->pluck('user_send_id','id');
        $friend = array_merge($friend_send->toArray(),$friend_receive->toArray());
        $user = User::wherein('id',$friend)->get();
        if($user)
        {
            $this->logRepository->Create_Data(''.Auth::User()->id.'', 'عرض', 'عرض الاصدقاء  Api' . Auth::User()->username );
            return response(['message' => 'جميع الاصدقاء','data'=>UserResource::collection($user)], 200);
        }
        else
        {
            $this->logRepository->Create_Data(''.Auth::User()->id.'', 'عرض', 'عرض الاصدقاء  Api' . Auth::User()->username );
            return response(['message' => 'لا يوجد اصدقاء'], 200);
        }
        }
        return response(['message' => 'خطا فى تحميل البيانات'], 400);
    }

    public function all_request_friend(Request $request)
    {
        $user = User::find($request->user);
        if ($user) {
            $friend_send = DB::table('friends')->where('user_send_id', $request->user)->where('status', 0)->pluck('user_receive_id','id');
            $friend_receive = DB::table('friends')->where('user_receive_id', $request->user)->where('status', 0)->pluck('user_send_id','id');
            $friend = array_merge($friend_send->toArray(),$friend_receive->toArray());
            $user = User::wherein('id',$friend)->get();
            if($user)
            {
                $this->logRepository->Create_Data(''.Auth::User()->id.'', 'عرض', 'عرض طلبات صداقه  Api' . Auth::User()->username );
                return response(['message' => 'جميع طلبات الصداقه','data'=>UserResource::collection($user)], 200);
            }
            else
            {
                $this->logRepository->Create_Data(''.Auth::User()->id.'', 'عرض', 'عرض طلبات صداقه  Api' . Auth::User()->username );
                return response(['message' => 'لا يوجد طلبات صداقه'], 200);
            }
        }
        return response(['message' => 'خطا فى تحميل البيانات'], 400);
    }
}
