<?php

namespace App\Http\Controllers\Api\Web\Social_Media;


use App\Http\Resources\Web\Social_Media\LikeResource;
use App\Http\Resources\Web\Social_Media\PostResource;
use App\Models\Image;
use App\Models\Social_Media\Commit;
use App\Models\Social_Media\Like;
use App\Models\Social_Media\Post;
use App\Repositories\ACL\LogRepository;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
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
                'image_post' => 'image|mimes:jpg,jpeg,png,gi|max:2048',
            ]);
        } else {
            $validate = \Validator::make($request->all(), [
                'details' => 'required|string|max:255',
            ]);
        }
        if ($validate->fails()) {
            return response(['status' => 0, 'message' => $validate->errors()], 422);
        }
        $post = new Post();
        $post->details = $request->details;
        $post->status = 1;
        $post->user_id = Auth::user()->id;
        $post->save();
        if ($request->image_post) {
            $post_image = new Image();
            $post_image->category = 'post';
            $post_image->status = 1;
            $post_image->category_id = $post->id;
            $folderPath = public_path('images/post/');
            $image_parts = explode(";base64,", $request->image_post);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);
            $file = $folderPath . time() . uniqid() . '.' . $image_type;
            file_put_contents($file, $image_base64);
            $post_image->image = time() . uniqid() . '.' . $image_type;
            $post_image->save();
        }
        if ($post) {
            $this->logRepository->Create_Data('' . Auth::user()->id . '', 'تسجيل', 'تسجيل منشور جديد عن طريق');
            return response(['status' => 1, 'post' => array(new PostResource($post))], 201);
        }
        return response(['status' => 0, 'post' => $post], 400);
    }

    public function show_all_post_user(Request $request)
    {
        $user = User::where('id', $request->user_id)->where('status', 1)->first();
        if ($user) {
            $post = Post::with(['commit_post' => function ($query) {
                $query->where('status', 1);
            }], ['like' => function ($query) {
                $query->where('category', 'post');
            }])->where('user_id', $request->user_id)->where('status', 1)->orderby('created_at', 'DESC')->get();
            $this->logRepository->Create_Data('' . Auth::user()->id . '', 'عرض', 'عرض كل المنشورات للمستخدم');
            if ($post != null) {
                $post = PostResource::collection($post);
            }
            return response(['status' => 1, 'post' => $post], 200);
        }
        return response(['status' => 0], 400);
    }

    public function show(Request $request)
    {
        $post = Post::with(['commit_post' => function ($query) {
            $query->where('status', 1);
        }], ['like' => function ($query) {
            $query->where('category', 'post');
        }])->where('id', $request->post_id)->where('status', 1)->first();
        $this->logRepository->Create_Data('' . Auth::user()->id . '', 'عرض', 'عرض  منشور للمستخدم');
        if ($post != null) {
            if ($post->status == 1) {
                return response(['status' => 1, 'post' => array(new PostResource($post))], 200);
            }
        }
        return response(['status' => 0], 400);
    }

    public function update(Request $request)
    {
        $post = Post::find($request->post_id);
        if ($post != null) {
            if ($request->image_post) {
                $validate = \Validator::make($request->all(), [
                    'details' => 'required|string|max:255',
                    'image_post' => 'image|mimes:jpg,jpeg,png,gi|max:2048',
                ]);
            } else {
                $validate = \Validator::make($request->all(), [
                    'details' => 'required|string|max:255',
                ]);
            }
            if ($validate->fails()) {
                return response(['status' => 0, 'message' => $validate->errors()], 422);
            }
            $post->details = $request->details;
            $post->update();
            if ($request->image_post) {
                $image_check = Image::where('category', 'post')->where('category_id', $post->id)->where('status', 1)->first();
                $image_check->delete();
                $post_image = new Image();
                $post_image->category = 'post';
                $post_image->status = 1;
                $post_image->category_id = $post->id;
                $folderPath = public_path('images/post/');
                $image_parts = explode(";base64,", $request->image_post);
                $image_type_aux = explode("image/", $image_parts[0]);
                $image_type = $image_type_aux[1];
                $image_base64 = base64_decode($image_parts[1]);
                $file = $folderPath . time() . uniqid() . '.' . $image_type;
                file_put_contents($file, $image_base64);
                $post_image->image = time() . uniqid() . '.' . $image_type;
                $post_image->save();
            }
            $this->logRepository->Create_Data('' . Auth::user()->id . '', 'تعديل', 'تعديل  منشور للمستخدم');
            return response(['status' => 1, 'post' => array(new PostResource($post))], 201);
        }
        return response(['status' => 0], 400);
    }

    public function delete(Request $request)
    {
        $post = Post::find($request->post_id);
        $commits = Commit::where('post_id', $post->id)->get();
        if ($commits) {
            foreach ($commits as $commit) {
                $likes = Like::where('category', 'commit')->where('category_id', $commit->id)->get();
                if (count($likes) > 0) {
                    foreach ($likes as $like) {
                        $like->delete();
                    }
                }
                $commit_commits = Commit::where('commit_id', $commit->id)->get();
                foreach ($commit_commits as $commit_commit) {
                    $likes = Like::where('category', 'commit')->where('category_id', $commit->id)->get();
                    if (count($likes) > 0) {
                        foreach ($likes as $like) {
                            $like->delete();
                        }
                    }
                    $image_commit = Image::where('category', 'commit')->where('category_id', $commit_commit->id)->get();
                    if ($image_commit) {
                        foreach ($image_commit as $image_commits) {
                            $image_commits->delete();
                        }
                    }
                    $commit_commit->delete();
                }
                $image_commit = Image::where('category', 'commit')->where('category_id', $commit->id)->get();
                if ($image_commit) {
                    foreach ($image_commit as $image_commits) {
                        $image_commits->delete();
                    }
                }
                $commit->delete();
            }
        }
        $likes = Like::where('category', 'post')->where('category_id', $post->id)->get();
        if ($likes) {
            foreach ($likes as $like) {
                $like->delete();
            }
        }
        $postss = Post::where('post_id', $post->id)->get();
        if ($postss) {
            foreach ($postss as $posts) {
                $commits = Commit::where('post_id', $posts->id)->get();
                if ($commits) {
                    foreach ($commits as $commit) {
                        $likes = Like::where('category', 'commit')->where('category_id', $commit->id)->get();
                        if (count($likes) > 0) {
                            foreach ($likes as $like) {
                                $like->delete();
                            }
                        }
                        $commit_commits = Commit::where('category', 'commit')->where('category_id', $commit->id)->get();
                        foreach ($commit_commits as $commit_commit) {
                            $likes = Like::where('category', 'commit')->where('category_id', $commit_commit->id)->get();
                            if (count($likes) > 0) {
                                foreach ($likes as $like) {
                                    $like->delete();
                                }
                            }
                            $image_commit = Image::where('category', 'commit')->where('category_id', $commit_commit->id)->get();
                            if ($image_commit) {
                                foreach ($image_commit as $image_commits) {
                                    $image_commits->delete();
                                }
                            }
                            $commit_commit->delete();
                        }
                        $image_commit = Image::where('category', 'commit')->where('category_id', $commit->id)->get();
                        if ($image_commit) {
                            foreach ($image_commit as $image_commits) {
                                $image_commits->delete();
                            }
                        }
                        $commit->delete();
                    }
                }
                $likes = Like::where('category', 'post')->where('category_id', $posts->id)->get();
                if ($likes) {
                    foreach ($likes as $like) {
                        $like->delete();
                    }
                }
                $image_post = Image::where('category', 'post')->where('category_id', $posts->id)->get();
                if ($image_post) {
                    foreach ($image_post as $image_posts) {
                        $image_posts->delete();
                    }
                }
                $posts->delete();
            }
        }
        $image_post = Image::where('category', 'post')->where('category_id', $post->id)->get();
        if ($image_post) {
            foreach ($image_post as $image_posts) {
                $image_posts->delete();
            }
        }
        $this->logRepository->Create_Data('' . Auth::user()->id . '', 'مسح', 'مسح  منشور للمستخدم');
        $post->delete();
        return response(['status' => 1], 200);
    }

    public function like(Request $request)
    {
        $post = Post::find($request->post_id);
        if ($post) {
            $like = Like::where('category', 'post')->where('category_id', $request->id)->where('user_id', Auth::User()->id)->first();
            if ($like == null) {
                $like = new Like();
                $like->category_id = $post->id;
                $like->category = 'post';
                $like->user_id = Auth::User()->id;
                $like->save();
                $data = Like::with('user')->where('category', 'post')->where('category_id', $request->id)->get();
                $this->logRepository->Create_Data('' . Auth::user()->id . '', 'اعجاب', 'تسجيل اعجاب منشور للمستخدم');
            } else {
                $like->delete();
                $data = Like::with('user')->where('category', 'post')->where('category_id', $post->id)->get();
                $this->logRepository->Create_Data('' . Auth::user()->id . '', 'مسح الاعجاب', 'مسح اعجاب منشور للمستخدم');
            }
            return response(['status' => 1, 'like' => array(new LikeResource($data)), 'count' => count($data)], 200);
        }
        return response(['status' => 0], 400);
    }

    public function share(Request $request)
    {
        $posts = Post::find($request->post_id);
        if ($posts) {
            $post = new Post();
            $post->details = $posts->details;
            $post->status = 1;
            $post->user_id = Auth::user()->id;
            $post->post_id = $posts->id;
            $post->save();
            $this->logRepository->Create_Data('' . Auth::user()->id . '', 'مشاركه', 'مشاركه منشور');
            return response(['status' => 1, 'post' => array(new PostResource($post))], 201);
        }
        return response(['status' => 0], 400);
    }
}