<?php

namespace App\Http\Controllers\Api\Social_Media\Group;

use App\Http\Resources\Social_Media\PostResource;
use App\Models\Image;
use App\Models\Social_Media\Post;
use App\Repositories\ACL\LogRepository;
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
        $validate = \Validator::make($request->all(), [
            'details' => 'required|string|max:255',
            'group' => 'required|string|exits:groups',
            'image_post'=>'image|mimes:jpg,jpeg,png|max:2048',
        ]);
        if ($validate->fails()) {
            return response(['message' => $validate->errors()], 422);
        }
        $post = new Post();
        $post->details = $request->details;
        $post->status = 1;
        $post->group_id = $request->group;
        $post->user_id = Auth::user()->id;
        $post->save();
        if($request->image_post)
        {
            foreach ($request->image_post as $image_post)
            {
            $imageName = $image_post->getClientOriginalname().'-'.time() .'.'.$image_post->getClientOriginalExtension();
            $image_post->move(public_path('images/post'), $imageName);
            $post_image_save = new Image();
            $post_image_save->category_id = $post->id;
            $post_image_save->category = 'post';
            $post_image_save->status = 1;
            $post_image_save->image = $imageName;
            $post_image_save->save();
            }
        }
        if ($post) {
            $this->logRepository->Create_Data('' . Auth::user()->id . '', 'تسجيل منشور جديد', 'تسجيل منشور جديد فى المجموعه عن طريق Api' . Auth::user()->username . " / " . Auth::user()->id);
            return response([
                'message' => 'تم تسجيل المنشور بنجاح',
                'data' => array(new PostResource($post))
            ], 201);
        }
        return response(['message' => 'خطا فى حفظ المنشور الجديد'], 400);
    }

    public function show_all_post_group(Request $request)
    {
        $post = Post::with(['commit_post' => function ($query) {
            $query->where('status', 1);
        }],['like' => function ($query) {
            $query->where('category', 'post');
        }])->where('group_id', $request->group)->where('status', 1)->orderby('created_at','DESC')->get();
        if ($post) {
            $this->logRepository->Create_Data('' . Auth::user()->id . '', 'عرض', 'عرض كل المنشورات المجموعه عن طريق Api' . Auth::user()->username . " / " . Auth::user()->id);
            return response(['data' =>  PostResource::collection($post)
            ], 200);
        }
        return response(['message' => 'خطا فى تحضير البيانات'], 400);
    }
}
