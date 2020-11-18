<?php

namespace App\Http\Controllers\Api\Web\Social_Media;


use App\Http\Resources\Web\Social_Media\LikeResource;
use App\Http\Resources\Web\Social_Media\PostResource;
use App\Models\Image;
use App\Models\Social_Media\Commit;
use App\Models\Social_Media\Like;
use App\Models\Social_Media\Post;
use App\Repositories\ACL\LogRepository;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


class CommitController extends Controller
{
    private $logRepository;

    public function __construct(LogRepository $LogRepository)
    {
        $this->middleware('auth:api');
        $this->logRepository = $LogRepository;
    }

    public function store(Request $request)
    {
        if ($request->image_commit) {
            $validate = \Validator::make($request->all(), [
                'details' => 'required|string|max:255',
                'post_id' => 'required|exists:posts,id',
                'image_commit' => 'image|mimes:jpg,jpeg,png|max:2048',
            ]);
        } else {
            $validate = \Validator::make($request->all(), [
                'post_id' => 'required|exists:posts,id',
                'details' => 'required|string|max:255',
            ]);
        }
        if ($validate->fails()) {
            return response(['status' => 0, 'message' => $validate->errors()], 422);
        }
        $commit = new Commit();
        $commit->details = $request->details;
        $commit->status = 1;
        $commit->post_id = $request->post_id;
        $commit->user_id = Auth::user()->id;
        if ($request->commit_id) {
            $commit->commit_id = $request->commit_id;
        }
        $commit->save();
        if ($request->image_commit) {
            $commit_image_save = new Image();
            $commit_image_save->category_id = $request->id;
            $commit_image_save->category = 'commit';
            $commit_image_save->status = 1;
            $folderPath = public_path('images/commit/');
            $image_parts = explode(";base64,", $request->image_commit);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);
            $file = $folderPath . time() . uniqid() . '.' . $image_type;
            file_put_contents($file, $image_base64);
            $commit_image_save->image_commit = time() . uniqid() . '.' . $image_type;
            $commit_image_save->save();
        }
        $post = Post::with(['commit_post' => function ($query) {
            $query->where('status', 1);
        }], ['like' => function ($query) {
            $query->where('category', 'post')->orderby('created_at', 'asc');
        }])->where('id', $request->post_id)->where('status', 1)->first();
        $this->logRepository->Create_Data('' . Auth::user()->id . '', 'تسجيل', 'تسجيل تعليق جديد فى منشور');
        if ($post) {
            return response(['status' => 1, 'post' => array(new PostResource($post))], 201);
        }
        return response(['status' => 0], 400);
    }

    public function update(Request $request)
    {
        $commit = Commit::find($request->commit_id);
        if ($commit) {
            if ($request->image_commit) {
                $validate = \Validator::make($request->all(), [
                    'details' => 'required|string|max:255',
                    'post_id' => 'required|exists:posts,id',
                    'image_commit' => 'image|mimes:jpg,jpeg,png|max:2048',
                ]);
            } else {
                $validate = \Validator::make($request->all(), [
                    'post_id' => 'required|exists:posts,id',
                    'details' => 'required|string|max:255',
                ]);
            }
            if ($validate->fails()) {
                return response(['status' => 0, 'message' => $validate->errors()], 422);
            }
            $commit->details = $request->details;
            $commit->save();
            if ($request->image_commit) {
                $image_check = Image::where('category', 'commit')->where('category_id', $commit->id)->where('status', 1)->first();
                $image_check->delete();
                $commit_image_save = new Image();
                $commit_image_save->category_id = $commit->id;
                $commit_image_save->category = 'commit';
                $commit_image_save->status = 1;
                $folderPath = public_path('images/commit/');
                $image_parts = explode(";base64,", $request->image_commit);
                $image_type_aux = explode("image/", $image_parts[0]);
                $image_type = $image_type_aux[1];
                $image_base64 = base64_decode($image_parts[1]);
                $file = $folderPath . time() . uniqid() . '.' . $image_type;
                file_put_contents($file, $image_base64);
                $commit_image_save->image_commit = time() . uniqid() . '.' . $image_type;
                $commit_image_save->save();
            }
            $post = Post::with(['commit_post' => function ($query) {
                $query->where('status', 1);
            }], ['like' => function ($query) {
                $query->where('category', 'post');
            }])->where('id', $request->post_id)->where('status', 1)->first();
            if ($post) {
                $this->logRepository->Create_Data('' . Auth::user()->id . '', 'تعديل', 'تعديل تعليق منشور');
                return response(['status' => 1, 'post' => array(new PostResource($post))], 201);
            }
        }
        return response(['status' => 0], 400);
    }

    public function delete(Request $request)
    {
        $commit = Commit::find($request->commit_id);
        if ($commit) {
            $likes = Like::where('category', 'commit')->where('category_id', $commit->id)->get();
            if ($likes) {
                foreach ($likes as $like) {
                    $like->delete();
                }
            }
            $commit_commits = Commit::where('commit_id', $commit->id)->get();
            foreach ($commit_commits as $commit_commit) {
                $likes = Like::where('category', 'commit')->where('category_id', $commit_commit->id)->get();
                if ($likes) {
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
            $this->logRepository->Create_Data('' . Auth::user()->id . '', 'مسح', 'مسح تعليق');
            return response(['status' => 1], 201);
        }
        return response(['status' => 0], 400);
    }

    public function like(Request $request)
    {
        $commit = Commit::find($request->id);
        if ($commit) {
            $like = Like::where('category', 'commit')->where('category_id', $request->commit_id)->where('user_id', Auth::User()->id)->first();
            if ($like == null) {
                $like = new Like();
                $like->category_id = $commit->id;
                $like->category = 'commit';
                $like->user_id = Auth::User()->id;
                $like->save();
                $data = Like::with('user')->where('category', 'commit')->where('category_id', $commit->id)->get();
                $this->logRepository->Create_Data('' . Auth::user()->id . '', 'اعجاب', 'تسجيل اعجاب منشور للمستخدم');
            } else {
                $like->delete();
                $data = Like::with('user')->where('category', 'commit')->where('category_id', $commit->id)->get();
                $this->logRepository->Create_Data('' . Auth::user()->id . '', 'مسح', 'مسح اعجاب منشور للمستخدم');
            }
            return response(['status' => 1, 'like' => array(new LikeResource($data)), 'count' => count($data)], 200);
        }
        return response(['status' => 0], 200);
    }
}
