<?php

namespace App\Http\Controllers\Api\Social_Media\Group;

use App\Http\Resources\Image\GroupImageResource;
use App\Http\Resources\Social_Media\Group\GroupResource;
use App\Http\Resources\Social_Media\PostResource;
use App\Models\Image;
use App\Models\Social_Media\Group;
use App\Models\Social_Media\Post;
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
        $this->middleware('auth:api', ['except' => ['show_all_group']]);
        $this->logRepository = $LogRepository;
    }

    public function show_all_group(Request $request)
    {

        $group = Group::with('image')->get();
        if($request->status_auth ==1)
        {
            $user = User::find($request->user_id);
            if (!$user) {
                return response(['status' => 0, 'data' => array(), 'message' => 'خطا فى تحميل البيانات المستخدم'], 400);
            }
            if ($user->status == 0) {
                return response(['status' => 0, 'data' => array(), 'message' => 'برجاء الاتصال بخدمه العملاء'], 400);
            }
        $this->logRepository->Create_Data('' . $request->user_id . '', 'عرض', 'عرض كل الجروب');
            $group_member=DB::table('group_users')->where('user_id',$user->id)->pluck('group_id','group_id');
            $post = Post::with('commit_post', 'like', 'image')->where('status', 1)
                ->wherein('group_id', $group_member)->orderby('created_at', 'DESC')->paginate(25);
            return response(['status'=>1,'data'=>['group' => GroupResource::collection($group),'count_post' => count($post),
                'post' => PostResource::collection($post)] ,'message'=>'قائمه الجروبات'], 200);
        }
        $post = Post::with('commit_post', 'like', 'image')->where('status', 1)
            ->where('group_id', '!=',0)->orderby('created_at', 'DESC')->paginate(25);
        return response(['status'=>1,'data'=>['group' => GroupResource::collection($group),'count_post' => count($post),
            'post' => PostResource::collection($post)] ,'message'=>'قائمه الجروبات'], 200);
    }

    public function all_image_group(Request $request)
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
            $image=Image::where('category','group')->where('category_id',$group->id)->get();
            if($image)
            {
                $image=GroupImageResource::collection($image);
            }
            else
            {
                $image=array();
            }
            return response(['status' => 1, 'data' => ['count_image'=>count($image),'image_group'=>$image], 'message' => 'جميع الصور'], 400);
        }
        return response(['status' => 0, 'data' => array(), 'message' => 'لا يمكن اتمام الطلب'], 400);
    }
}
