<?php

namespace App\Http\Controllers\Api\Social_Media\Group;

use App\Http\Resources\ACL\UserResource;
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

    public function join(Request $request)
    {
        $user = User::find($request->user_id);
        if (!$user) {
            return response(['status' => 0, 'data' => array(), 'message' => 'خطا فى تحميل البيانات المستخدم'], 400);
        }
        if ($user->status == 0) {
            return response(['status' => 0, 'data' => array(), 'message' => 'برجاء الاتصال بخدمه العملاء'], 400);
        }
        $group = Group::find($request->group_id);
        if (!$group) {
            return response(['status' => 0, 'data' => array(), 'message' => 'خطا فى تحميل البيانات الجروب'], 400);
        }
        if ($user->id == Auth::user()->id) {


            $group_member = Group_User::where('group_id', $group->id)->where('user_id', $user->id)->first();
            if (!$group_member) {
                $group_member = new Group_User();
                $group_member->group_id = $group->id;
                $group_member->user_id = $user->id;
                $group_member->save();
                $this->logRepository->Create_Data('' . Auth::user()->id . '', 'انضمام', 'ارسال دعوه للدخول المجموعه');
                return response(['status' => 1, 'data' => array(), 'message' => 'تم الانضمام لجروب بنجاح'], 200);
            }
            return response(['status' => 0, 'data' => array(), 'message' => 'مشترك مسبقا'], 400);
        }
        return response(['status' => 0, 'data' => array(), 'message' => 'لا يمكن اتمام الطلب'], 400);
    }

    public function leave(Request $request)
    {
        $user = User::find($request->user_id);
        if (!$user) {
            return response(['status' => 0, 'data' => array(), 'message' => 'خطا فى تحميل البيانات المستخدم'], 400);
        }
        if ($user->status == 0) {
            return response(['status' => 0, 'data' => array(), 'message' => 'برجاء الاتصال بخدمه العملاء'], 400);
        }
        $group = Group::find($request->group_id);
        if (!$group) {
            return response(['status' => 0, 'data' => array(), 'message' => 'خطا فى تحميل البيانات الجروب'], 400);
        }
        if ($user->id == Auth::user()->id) {
            $group_member = Group_User::where('group_id', $group->id)->where('user_id', $user->id)->first();
            if ($group_member) {
                $group_member->delete();
                $this->logRepository->Create_Data('' . Auth::user()->id . '', 'مغادره', 'مغادره المجموعه');
                return response(['status' => 1, 'data' => array(), 'message' => 'تم مغاده الجروب'], 200);
            }
            return response(['status' => 1, 'data' => array(), 'message' => 'غير مشترك فى الجروب'], 400);
        }
        return response(['status' => 0, 'data' => array(), 'message' => 'لا يمكن اتمام الطلب'], 400);
    }

    public function all_member(Request $request)
    {
        $user = User::find($request->user_id);
        if (!$user) {
            return response(['status' => 0, 'data' => array(), 'message' => 'خطا فى تحميل البيانات المستخدم'], 400);
        }
        if ($user->status == 0) {
            return response(['status' => 0, 'data' => array(), 'message' => 'برجاء الاتصال بخدمه العملاء'], 400);
        }
        $group = Group::find($request->group_id);
        if (!$group) {
            return response(['status' => 0, 'data' => array(), 'message' => 'خطا فى تحميل البيانات الجروب'], 400);
        }
        if ($user->id == Auth::user()->id) {
            $group_member = DB::table('group_users')->where('group_id', $group->id)->pluck('user_id', 'user_id');
            $member = User::where('status', 1)->wherein('id', $group_member)->get();
            if ($member) {
                $member = UserResource::collection($member);
            } else {
                $member = array();
            }
            return response(['status' => 1, 'data' => ['count_member'=>count($member),'member'=>$member], 'message' => 'الاعضاء المشتركين'], 400);
        }
        return response(['status' => 0, 'data' => array(), 'message' => 'لا يمكن اتمام الطلب'], 400);
    }
}
