<?php

namespace App\Http\Controllers\Api\Mobile\Social_Media\Group;

use App\Models\Social_Media\Group;
use App\Models\Social_Media\Group_User;
use App\Repositories\ACL\LogRepository;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

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
        $group = Group::find($request->group_id);
        if (!$group) {
            $group_member = new Group_User();
            $group_member->group_id = $group->id;
            $group_member->user_id = $user->id;
            $group_member->save();
            $this->logRepository->Create_Data('' . Auth::user()->id . '', 'انضمام', 'ارسال دعوه للدخول المجموعه');
            return response(['stauts' => 1, 'data' => array(), 'message' => 'تم الانضمام لجروب بنجاح'], 200);
        }
        return response(['stauts' => 0, 'data' => array(), 'message' => 'خطا فى بيانات الجروب'], 400);
    }

    public function leave(Request $request)
    {
        $user = User::find($request->user_id);
        if (!$user) {
            return response(['status' => 0, 'data' => array(), 'message' => 'خطا فى تحميل البيانات المستخدم'], 400);
        }
        $group = Group::find($request->group_id);
        if (!$group) {
            return response(['status' => 0, 'data' => array(), 'message' => 'خطا فى تحميل البيانات الجروب'], 400);
        }
        $group_member = Group_User::where('group_id', $group->id)->where('user_id', $user->id)->first();
        if ($group_member) {
            $group_member->delete();
            $this->logRepository->Create_Data('' . Auth::user()->id . '', 'مغادره', 'مغادره المجموعه');
            return response(['stauts' => 1,'data' => array(), 'message' => 'تم مغاده الجروب'], 200);
        }
        return response(['stauts' => 1,'data' => array(), 'message' => 'غير مشترك فى الجروب'], 400);
    }
}
