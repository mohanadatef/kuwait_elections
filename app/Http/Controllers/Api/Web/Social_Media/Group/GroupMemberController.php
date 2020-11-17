<?php

namespace App\Http\Controllers\Api\Web\Social_Media\Group;

use App\Http\Resources\Web\ACL\UserResource;
use App\Models\Social_Media\Group;
use App\Models\Social_Media\Group_User;
use App\Repositories\ACL\LogRepository;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GroupMemberController extends Controller
{
    private $logRepository;

    public function __construct(LogRepository $LogRepository)
    {
        $this->middleware('auth:api');
        $this->logRepository = $LogRepository;
    }

    public function search(Request $request)
    {
        $user = DB::table('users')->where('username', 'like', $request->word . '%')
            ->orWhere('username', 'like', '%' . $request->word . '%')
            ->orwhere('email', 'like', $request->word . '%')
            ->orWhere('email', 'like', '%' . $request->word . '%')
            ->orwhere('first_name', 'like', $request->word . '%')
            ->orWhere('first_name', 'like', '%' . $request->word . '%')
            ->orwhere('last_name', 'like', $request->word . '%')
            ->orWhere('last_name', 'like', '%' . $request->word . '%')
            ->where('status',1)
            ->pluck('id','id');
        $friend_send = DB::table('friends')->wherein('user_send_id', $user)->where('user_receive_id', Auth::user()->id)->where('status', 1)->pluck('user_send_id','id');
        $friend_receive = DB::table('friends')->wherein('user_receive_id', $user)->where('user_send_id', Auth::user()->id)->where('status', 1)->pluck('user_receive_id','id');
        $friend = array_merge($friend_send->toArray(),$friend_receive->toArray());
        $user = User::wherein('id',$friend)->where('status', 1)->get();
        if($user)
        {
            $this->logRepository->Create_Data(''.Auth::User()->id.'', 'بحث', 'بحث عن الاصدقاء للاضافتهم فى جروب  Api' . Auth::User()->username );
            return response(['data'=>UserResource::collection($user)], 200);
        }
        else
        {
            $this->logRepository->Create_Data(''.Auth::User()->id.'', 'بحث', 'بحث عن الاصدقاء للاضافتهم فى جروب  Api' . Auth::User()->username );
            return response(['message' => 'لا يوجد بيانات'], 200);
        }
    }

    public function join(Request $request)
    {
        $group = Group::find($request->group_id);
        if($group)
        {
            $user = User::find($request->user_id);
            if($user)
            {
                $group_member=Group_User::where('group_id',$group->id)->where('user_id',$user->id)->where('status',1)->first();
                if(!$group_member)
                {
                    $group_member=new Group_User();
                    $group_member->group_id=$group->id;
                    $group_member->user_id=$user->id;
                    $group_member->status=0;
                    $group_member->save();
                    $this->logRepository->Create_Data('' . Auth::user()->id . '', 'ارسال دعوه', 'ارسال دعوه للدخول المجموعه عن طريق Api' . Auth::user()->username . " / " . Auth::user()->id);
                    return response(['message' => 'تم ارسال دعوه لجروب'], 200);
                }
                return response(['message' => 'موجود مسبقا فى الجروب'], 200);
            }
        }
        return response(['message' => 'خطا فى نحميل البيانات'], 400);
    }

    public function cansel(Request $request)
    {
        $group = Group::find($request->group_id);
        if($group)
        {
            $user = User::find($request->user_id);
            if($user)
            {
                $group_member=Group_User::where('group_id',$group->id)->where('user_id',$user->id)->where('status',0)->first();
              if($group_member)
              {
                  $group_member->delete();
                  $this->logRepository->Create_Data('' . Auth::user()->id . '', 'مسح دعوه', 'مسح  العضو المجموعه عن طريق Api' . Auth::user()->username . " / " . Auth::user()->id);
                  return response(['message' => 'تم مسح الدعوه'], 200);
              }
            }
        }
        return response(['message' => 'خطا فى نحميل البيانات'], 400);
    }

    public function accept(Request $request)
    {
        $group = Group::find($request->group_id);
        if($group)
        {
            $user = User::find($request->user_id);
            if($user)
            {
                $group_member=Group_User::where('group_id',$group->id)->where('user_id',$user->id)->where('status',0)->first();
                if($group_member)
                {
                    $group_member->status=1;
                    $group_member->save();
                    $this->logRepository->Create_Data('' . Auth::user()->id . '', 'قبول دعوه', 'قبول دعوه للدخول المجموعه عن طريق Api' . Auth::user()->username . " / " . Auth::user()->id);

                    return response(['message' => 'تم قبول الانضمام'], 200);
                }
            }
        }
        return response(['message' => 'خطا فى نحميل البيانات'], 400);
    }

    public function upgrade(Request $request)
    {
        $group = Group::find($request->group_id);
        if($group)
        {
            $user = User::find($request->user_id);
            if($user)
            {
                $group_member=Group_User::where('group_id',$group->id)->where('user_id',$user->id)->where('status',0)->first();
                if($group_member)
                {
                    if($group_member->category == "member")
                    {
                        $group_member->category="admin";
                        $group_member->save();
                        $this->logRepository->Create_Data('' . Auth::user()->id . '', 'ترقيه', 'ترقيه العضو الى ادمن عن طريق Api' . Auth::user()->username . " / " . Auth::user()->id);

                        return response(['message' => 'تم ترقيه الى ادمن'], 200);
                    }
                    elseif($group_member->category == "admin")
                    {
                        $group_member->category="member";
                        $group_member->save();
                        $this->logRepository->Create_Data('' . Auth::user()->id . '', 'ترقيه', 'ترقيه الادمن الى العضو عن طريق Api' . Auth::user()->username . " / " . Auth::user()->id);

                        return response(['message' => 'تم ترقيه الى عضو'], 200);
                    }
                }
            }
        }
        return response(['message' => 'خطا فى نحميل البيانات'], 400);
    }

    public function leave(Request $request)
    {
        $group = Group::find($request->group_id);
        if($group)
        {
            $user = User::find($request->user_id);
            if($user)
            {
                $group_member=Group_User::where('group_id',$group->id)->where('user_id',$user->id)->where('status',1)->first();
                if($group_member)
                {
                    $group_member->delete();
                    $this->logRepository->Create_Data('' . Auth::user()->id . '', 'مغادره', 'مغادره المجموعه عن طريق Api' . Auth::user()->username . " / " . Auth::user()->id);

                    return response(['message' => 'تم نرك الجروب'], 200);
                }
            }
        }
        return response(['message' => 'خطا فى نحميل البيانات'], 400);
    }
}
