<?php

namespace App\Http\Controllers\Api\Mobile\Social_Media\Group;

use App\Http\Resources\Mobile\Social_Media\PostResource;
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
            return response(['message' => $validate->errors()], 422);
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
        $this->logRepository->Create_Data('' . Auth::user()->id . '', 'تسجيل', 'تسجيل منشور جديد فى المجموعه');
        if ($post) {
            return response(['status'=>1,'post' => array(new PostResource($post))], 201);
        }
        return response(['status'=>0], 400);
    }

    public function show_all_post_group(Request $request)
    {
        $post = Post::with(['commit_post' => function ($query) {
            $query->where('status', 1);
        }], ['like' => function ($query) {
            $query->where('category', 'post');
        }])->where('group_id', $request->group_id)->where('status', 1)->orderby('created_at', 'DESC')->get();
        if ($post) {
            $this->logRepository->Create_Data('' . Auth::user()->id . '', 'عرض', 'عرض كل المنشورات المجموعه');
            return response(['status'=>1,'post' => PostResource::collection($post)], 200);
        }
        return response(['status'=>0], 400);
    }
}
