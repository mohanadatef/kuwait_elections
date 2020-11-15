<?php

namespace App\Http\Controllers\Api\Social_Media\Group;

use App\Http\Resources\Social_Media\Group\GroupResource;
use App\Models\Image;
use App\Models\Social_Media\Group;
use App\Models\Social_Media\Group_User;
use App\Repositories\ACL\LogRepository;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GroupController extends Controller
{
    private $logRepository;

    public function __construct(LogRepository $LogRepository)
    {
        $this->middleware('auth:api');
        $this->logRepository = $LogRepository;
    }

    public function store(Request $request)
    {
        $validate = \Validator::make($request->all(), [
            'title' => 'required|string|max:255|unique:groups',
            'about' => 'required|string|max:255',
        ]);
        if ($validate->fails()) {
            return response(['message' => $validate->errors()], 422);
        }
        $group = new Group();
        $group->title=$request->title;
        $group->about=$request->about;
        $group->save();
        $group_member = new Group_User();
        $group_member->group_id=$group->id;
        $group_member->user_id=Auth::User()->id;
        $group_member->status=1;
        $group_member->category='owner';
        $group_member->save();
        $image_group = new Image();
        $image_group->category_id = $group->id;
        $image_group->category = 'profile_group';
        $image_group->status = 1;
        $image_group->image = 'profile_user.jpg';
        $image_group->save();
        $this->logRepository->Create_Data(''.Auth::user()->id.'', 'انشاء', 'انشاء جروب جديد عن طريق Api' . Auth::user()->username . " / " . Auth::user()->id);
        return response([
            'message' => 'تم انشاء مجموعه بنجاح',
        ], 201);
    }

    public function update(Request $request)
    {
        $validate = \Validator::make($request->all(), [
            'title' => 'required|string|max:255|unique:groups',
            'about' => 'required|string|max:255',
        ]);
        if ($validate->fails()) {
            return response(['message' => $validate->errors()], 422);
        }
        $group = Group::find($request->group_id);
        $group->title=$request->title;
        $group->about=$request->about;
        $group->save();
        $this->logRepository->Create_Data(''.Auth::user()->id.'', 'تعديل', 'تعديل فى جروب عن طريق Api' . Auth::user()->username . " / " . Auth::user()->id);

        return response([
            'message' => 'تم تعديل المجموعه بنجاح',
        ], 201);
    }

    public function delete(Request $request)
    {
        $group = Group::find($request->group_id);
       if($group)
       {
           $group_members = Group_User::where('group_id',$group->id)->get();
           foreach ($group_members as $group_member)
           {
               $group_member->delete();
           }
       }
        $this->logRepository->Create_Data(''.Auth::user()->id.'', 'مسح', 'مسح جروب عن طريق Api' . Auth::user()->username . " / " . Auth::user()->id);

        $group->delete();
        return response([
            'message' => 'تم مسح المجموعه بنجاح',
        ], 201);
    }

    public function show_all_group(Request $request)
    {
        $user = User::find($request->user_id);
        if($user)
        {
        $member = DB::table('group_users')->where('user_id',$request->user_id)->pluck('id','id');
        $group = Group::wherein('id',$member)->get();
            $this->logRepository->Create_Data(''.Auth::user()->id.'', 'عرض', 'عرض كل الجروب عن طريق Api' . Auth::user()->username . " / " . Auth::user()->id);
            return response([
                'data' => GroupResource::collection($group)
            ], 200);
        }
        return response([
            'message' => 'خطا فى تحميل البيانات',
        ], 400);
    }
}
