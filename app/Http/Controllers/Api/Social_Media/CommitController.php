<?php

namespace App\Http\Controllers\Api\Social_Media;


use App\Http\Resources\Social_Media\LikeResource;
use App\Http\Resources\Social_Media\PostResource;
use App\Models\Image;
use App\Models\Setting\Notification;
use App\Models\Social_Media\Commit;
use App\Models\Social_Media\Like;
use App\Models\Social_Media\Post;
use App\Repositories\ACL\LogRepository;
use App\User;
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
        $user = User::find($request->user_id);
        if (!$user) {
            return response(['status' => 0, 'data' => array(), 'message' => 'خطا فى تحميل البيانات المستخدم'], 400);
        }
        if ($user->status == 0) {
            return response(['status' => 0, 'data' => array(), 'message' => 'برجاء الاتصال بخدمه العملاء'], 400);
        }
        $post = Post::find($request->post_id);
        if (!$post) {
            return response(['status' => 0, 'data' => array(), 'message' => 'خطا فى تحميل البيانات المنشور'], 400);
        }
        if ($user->id == Auth::user()->id) {
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
                return response(['status' => 0, 'data' => array(), 'message' => $validate->errors()], 422);
            }
            $commit = new Commit();
            $commit->details = $request->details;
            $commit->status = 1;
            $commit->post_id = $post->id;
            $commit->user_id = $user->id;
            if ($request->commit_id) {
                $commit->commit_id = $request->commit_id;
            }
            $commit->save();
            if ($request->image_commit) {
                $commit_image_save = new Image();
                $commit_image_save->category_id = $commit->id;
                $commit_image_save->category = 'commit';
                $commit_image_save->status = 1;
                $folderPath = public_path('images/commit/');
                $image_type = 'png';
                $image_base64 = base64_decode($request->image_commit);
                $imageName = time() . uniqid() . '.' . $image_type;
                $file = $folderPath . $imageName;
                file_put_contents($file, $image_base64);
                $commit_image_save->image_commit = $imageName;
                $commit_image_save->save();
            }
            if($post->user_id != $commit->user_id) {
                $notification = new Notification();
                $notification->user_send_id = $commit->user_id;
                $notification->user_receive_id = $post->user_id;
                $notification->status = 1;
                $notification->details = $user->first_name . " " . $user->second_name . 'قام بعمل تعليق على المنشور';
                $notification->save();
            }
            $post = Post::with('commit_post', 'like', 'image')->find($request->post_id);
            $this->logRepository->Create_Data('' . Auth::user()->id . '', 'تسجيل', 'تسجيل تعليق جديد فى منشور');
            if ($post) {
                return response(['status' => 1, 'data' => ['post' => new PostResource($post)], 'message' => 'تم تسجيل التعليق بنجاح'], 201);
            }
            return response(['status' => 1, 'data' => array(), 'message' => 'خطا فى الحفظ التعليق'], 400);
        }
        return response(['status' => 0, 'data' => array(), 'message' => 'لا يمكن اتمام الطلب'], 400);
    }

    public function update(Request $request)
    {
        $commit = Commit::with('image', 'post', 'user', 'like', 'commit_commit')->find($request->commit_id);
        if (!$commit) {
            return response(['status' => 0, 'data' => array(), 'message' => 'خطا فى تحميل البيانات التعليق'], 400);
        }
        if ($commit->user_id == Auth::user()->id && Auth::user()->status == 1) {
            if ($request->image_commit) {
                $validate = \Validator::make($request->all(), [
                    'details' => 'required|string|max:255',
                    'image_commit' => 'string',
                ]);
            } else {
                $validate = \Validator::make($request->all(), [
                    'details' => 'required|string|max:255',
                ]);
            }
            if ($validate->fails()) {
                return response(['status' => 0, 'data' => array(), 'message' => $validate->errors()], 422);
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
                $image_type = 'png';
                $image_base64 = base64_decode($request->image_commit);
                $imageName = time() . uniqid() . '.' . $image_type;
                $file = $folderPath . $imageName;
                file_put_contents($file, $image_base64);
                $commit_image_save->image_commit = $imageName;
                $commit_image_save->save();
            }
            $post = Post::with('commit_post', 'like', 'image')->find($commit->post_id);
            if ($post) {
                $this->logRepository->Create_Data('' . Auth::user()->id . '', 'تعديل', 'تعديل تعليق منشور');
                return response(['status' => 1, 'data' => ['post' => new PostResource($post)], 'message' => 'تم تعديل التعليق بنجاح'], 201);
            }
            return response(['status' => 0, 'data' => array(), 'message' => 'خطا فى تعديل التعليق'], 400);
        }
        return response(['status' => 0, 'data' => array(), 'message' => 'لا يمكن اتمام الطلب'], 400);
    }

    public function delete(Request $request)
    {
        $commit = Commit::with('image', 'post', 'user', 'like', 'commit_commit')->find($request->commit_id);
        if (!$commit) {
            return response(['status' => 0, 'data' => array(), 'message' => 'خطا فى تحميل البيانات التعليق'], 400);
        }
        if ($commit->user_id == Auth::user()->id&& Auth::user()->status == 1) {
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
            return response(['status' => 1, 'data' => array(), 'message' => 'تم مسح التعليق بنجاح'], 200);
        }
        return response(['status' => 0, 'data' => array(), 'message' => 'لا يمكن اتمام الطلب'], 400);
    }

    public function like(Request $request)
    {
        $user = User::find($request->user_id);
        if (!$user) {
            return response(['status' => 0, 'data' => array(), 'message' => 'خطا فى تحميل البيانات المستخدم'], 400);
        }
        if ($user->status == 0) {
            return response(['status' => 0, 'data' => array(), 'message' => 'برجاء الاتصال بخدمه العملاء'], 400);
        }
        $commit = Commit::with('image', 'post', 'user', 'like', 'commit_commit')->find($request->commit_id);
        if (!$commit) {
            return response(['status' => 0, 'data' => array(), 'message' => 'خطا فى تحميل البيانات التعليق'], 400);
        }
        if ($user->id == Auth::user()->id) {
            $like = Like::where('category', 'commit')->where('category_id', $request->commit_id)->where('user_id', $user->id)->count();
            if ($like == 0) {
                $like = new Like();
                $like->category_id = $commit->id;
                $like->category = 'commit';
                $like->user_id = $user->id;
                $like->save();
                if($user->id != $commit->user_id)
                {
                $notification=new Notification();
                $notification->user_send_id=$user->id;
                $notification->user_receive_id=$commit->user_id;
                $notification->status=1;
                $notification->details=$user->first_name ." ".$user->second_name . ' قام بعمل اعجاب على التعليق' ;
                $notification->save();
                }
                $message = 'تم تسجيل الاعجاب بنجاح';
                $data = Like::with('user')->where('category', 'commit')->where('category_id', $commit->id)->get();
                $this->logRepository->Create_Data('' . Auth::user()->id . '', 'اعجاب', 'تسجيل اعجاب منشور للمستخدم');
            } else {
                Like::where('category', 'commit')->where('category_id', $request->commit_id)->where('user_id', $user->id)->delete();
                $message = 'تم مسح الاعجاب بنجاح';
                $data = Like::with('user')->where('category', 'commit')->where('category_id', $commit->id)->get();
                $this->logRepository->Create_Data('' . Auth::user()->id . '', 'مسح', 'مسح اعجاب منشور للمستخدم');
            }
            return response(['status' => 1, 'data' => ['like' => LikeResource::collection($data), 'count' => count($data)], 'message' => $message], 200);
        }
        return response(['status' => 0, 'data' => array(), 'message' => 'لا يمكن اتمام الطلب'], 400);
    }
}
