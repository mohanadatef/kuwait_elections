<?php

namespace App\Http\Controllers\Api\Social_Media\Group;

use App\Http\Resources\Social_Media\PostResource;
use App\Models\Image;
use App\Models\Social_Media\Group;
use App\Models\Social_Media\Group_User;
use App\Models\Social_Media\Post;
use App\Repositories\ACL\LogRepository;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class GroupPostController extends Controller
{
    private $logRepository;

    public function __construct(LogRepository $LogRepository)
    {
        $this->middleware('auth:api');
        $this->logRepository = $LogRepository;
    }

    public function store(Request $request)
    {
        $user = User::find($request->user_id);
        if (!$user) {
            return response(['status' => 0, 'data' => array(), 'message' => 'خطا فى تحميل البيانات المستخدم'], 400);
        }
        if ($user->status == 0) {
            return response(['status' => 0, 'data' => array(), 'message' => 'برجاء الاتصال بخدمه العملاء'], 400);
        }
        if($user->id == Auth::user()->id)
        {
        if ($request->image_post) {
            $validate = \Validator::make($request->all(), [
                'details' => 'required|string|max:255',
                'group_id' => 'required|string|exits:groups',
                'image_post' => 'image|mimes:jpg,jpeg,png,gi|max:2048',
            ]);
        } else {
            $validate = \Validator::make($request->all(), [
                'details' => 'required|string|max:255',
                'group_id' => 'required|string|exits:groups',
            ]);
        }
        if ($validate->fails()) {
            return response(['status'=>0,'data'=>array(),'message' => $validate->errors()], 422);
        }
        $post = new Post();
        $post->details = $request->details;
        $post->status = 1;
        $post->group_id = $request->group_id;
        $post->user_id = Auth::user()->id;
        $post->save();
        if ($request->image_post) {
            $post_image_save = new Image();
            $post_image_save->category_id = $post->id;
            $post_image_save->category = 'post';
            $post_image_save->status = 1;
            $folderPath = public_path('images/post/');
            $image_parts = explode(";base64,", $request->image_post);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);
            $file = $folderPath . time() . uniqid() . '.' . $image_type;
            file_put_contents($file, $image_base64);
            $post_image_save->image = time() . uniqid() . '.' . $image_type;
            $post_image_save->save();
        }
        if ($post) {
            $this->logRepository->Create_Data('' . Auth::user()->id . '', 'تسجيل', 'تسجيل منشور جديد فى المجموعه');
            return response(['status'=>1,'data'=>['post' => new PostResource($post)],'message'=>'تم تسجيل المنشور بنجاح'], 201);
        }
        return response(['status'=>0,'data'=>array(),'message'=>'خطا فى المدخلات'], 400);
        }
        return response(['status' => 0, 'data' => array(), 'message' => 'لا يمكن اتمام الطلب'], 400);
    }

    public function show_all_post_group(Request $request)
    {
        $group = Group::find($request->group_id);
        if (!$group) {
            return response(['status' => 0, 'data' => array(), 'message' => 'خطا فى تحميل البيانات الجروب'], 400);
        }
        $user = User::find($request->user_id);
        if (!$user) {
            return response(['status' => 0, 'data' => array(), 'message' => 'خطا فى تحميل البيانات المستخدم'], 400);
        }
        if ($user->status == 0) {
            return response(['status' => 0, 'data' => array(), 'message' => 'برجاء الاتصال بخدمه العملاء'], 400);
        }
        $member=Group_User::where('group_id',$group->id)->where('user_id',$user->زid)->first();
        if($member)
        {
        if($user->id == Auth::user()->id)
        {
        $post = Post::with(['commit_post' => function ($query) {
            $query->where('status', 1);
        }], ['like' => function ($query) {
            $query->where('category', 'post');
        }])->where('group_id', $request->group_id)
            ->where('status', 1)->orderby('created_at', 'DESC')->paginate(25);
        if ($post) {
            $this->logRepository->Create_Data('' . Auth::user()->id . '', 'عرض', 'عرض كل المنشورات المجموعه');
            return response(['status'=>1,'data'=>['post' => PostResource::collection($post)],'message'=>'قائمه المنشورات'], 200);
        }
        return response(['status'=>0,'data'=>array(),'message'=>'خطا فى تحميل البيانات'], 400);
        }
        return response(['status' => 0, 'data' => array(), 'message' => 'لا يمكن اتمام الطلب'], 400);
        }
        return response(['status' => 1, 'data' => array(), 'message' => 'غير مشترك فى الجروب'], 400);
    }
}
