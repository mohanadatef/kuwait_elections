<?php

namespace App\Http\Controllers\Api\Mobile\Social_Media\Group;

use App\Http\Resources\Mobile\ACL\UserResource;
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
        $group = Group::find($request->group_id);
        if ($group) {
            $user = User::find($request->user_id);
            if ($user) {
                $group_member = new Group_User();
                $group_member->group_id = $group->id;
                $group_member->user_id = $user->id;
                $group_member->save();
                $this->logRepository->Create_Data('' . Auth::user()->id . '', 'ارسال دعوه', 'ارسال دعوه للدخول المجموعه عن طريق Api' . Auth::user()->username . " / " . Auth::user()->id);
                return response(['stauts'=>1,'message' => 'تم الانضمام لجروب'], 200);
            }
        }
        return response(['stauts'=>0,'message' => 'خطا فى نحميل البيانات'], 400);
    }

    public function leave(Request $request)
    {
        $group = Group::find($request->group_id);
        if ($group) {
            $user = User::find($request->user_id);
            if ($user) {
                $group_member = Group_User::where('group_id', $group->id)->where('user_id', $user->id)->first();
                if ($group_member) {
                    $group_member->delete();
                    $this->logRepository->Create_Data('' . Auth::user()->id . '', 'مغادره', 'مغادره المجموعه عن طريق Api' . Auth::user()->username . " / " . Auth::user()->id);
                    return response(['stauts'=>1,'message' => 'تم ترك الجروب'], 200);
                }
            }
        }
        return response(['stauts'=>0,'message' => 'خطا فى نحميل البيانات'], 400);
    }
}
