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
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    private $logRepository;

    public function __construct(LogRepository $LogRepository)
    {
        $this->middleware('auth:api', ['except' => ['show', 'show_all_post_user']]);
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
        if ($request->image_post) {
            $validate = \Validator::make($request->all(), [
                'details' => 'required|string|max:255',
                'image_post' => 'string',
            ]);
        } else {
            $validate = \Validator::make($request->all(), [
                'details' => 'required|string|max:255',
            ]);
        }
        if ($validate->fails()) {
            return response(['status' => 0, 'data' => array(), 'message' => $validate->errors()], 422);
        }
        if ($user->id == Auth::user()->id) {
            $post = new Post();
            $post->details = $request->details;
            $post->status = 1;
            $post->user_id = $user->id;
            $post->save();
            if ($request->image_post) {
                $post_image = new Image();
                $post_image->category = 'post';
                $post_image->status = 1;
                $post_image->category_id = $post->id;
                $folderPath = public_path('images/post/');
                $image_type = 'png';
                $image_base64 = base64_decode($request->image_post);
                $imageName = time() . uniqid() . '.' . $image_type;
                $file = $folderPath . $imageName;
                file_put_contents($file, $image_base64);
                $post_image->image = $imageName;
                $post_image->save();
            }
            $post = Post::with('image', 'like', 'commit_post')->find($post->id);
            if ($post) {
                $this->logRepository->Create_Data('' . Auth::user()->id . '', 'تسجيل', 'تسجيل منشور جديد عن طريق');
                return response(['status' => 1, 'data' => ['post' => new PostResource($post)], 'message' => 'تم حفظ المنشور بنجاح'], 201);
            }
            return response(['status' => 0, 'data' => array(), 'message' => 'خطا فى الحفظ المنشور'], 400);
        }
        return response(['status' => 0, 'data' => array(), 'message' => 'لا يمكن اتمام الطلب'], 400);
    }

    public function show_all_post_user(Request $request)
    {
        $user = User::find($request->user_id);
        if (!$user) {
            return response(['status' => 0, 'data' => array(), 'message' => 'خطا فى تحميل البيانات المنشور'], 400);
        }
        if ($user->status == 0) {
            return response(['status' => 0, 'data' => array(), 'message' => 'برجاء الاتصال بخدمه العملاء'], 400);
        }
        $post = Post::with('commit_post', 'like', 'image')->where('user_id', $request->user_id)->where('status', 1)->orderby('created_at', 'DESC')->paginate(25);
        if ($request->status_auth == 1) {
            $this->logRepository->Create_Data('' . $user->id . '', 'عرض', 'عرض كل المنشورات للمستخدم');
        }
        if ($post) {
            return response(['status' => 1, 'data' => ['count_post' => count($post), 'post' => PostResource::collection($post)], 'message' => 'منشورات الخاصه بالمستخدم'], 200);
        }
        return response(['status' => 1, 'data' => array(), 'message' => 'لا يوجد منشورات الخاصه بالمستخدم'], 200);
    }

    public function show(Request $request)
    {
        if ($request->status_auth == 1) {
            $user = User::find($request->user_id);
            if (!$user) {
                return response(['status' => 0, 'data' => array(), 'message' => 'خطا فى تحميل البيانات المنشور'], 400);
            }
            if ($user->status == 0) {
                return response(['status' => 0, 'data' => array(), 'message' => 'برجاء الاتصال بخدمه العملاء'], 400);
            }
        }
        $post = Post::with('image', 'like', 'commit_post')->find($request->post_id);
        if (!$post) {
            return response(['status' => 0, 'data' => array(), 'message' => 'خطا فى تحميل البيانات المنشور'], 400);
        }
        if ($request->status_auth == 1) {
            $this->logRepository->Create_Data('' . $user->id . '', 'عرض', 'عرض  منشور للمستخدم');
        }
        if ($post) {
            return response(['status' => 1, 'data' => ['post' => new PostResource($post)], 'message' => 'عرض المنشور'], 200);
        }
        return response(['status' => 0, 'data' => array(), 'message' => 'خطا فى تحميل بيانات المنشور'], 400);
    }

    public function update(Request $request)
    {
        $post = Post::with('image', 'like', 'commit_post')->find($request->post_id);
        if (!$post) {
            return response(['status' => 0, 'data' => array(), 'message' => 'خطا فى تحميل البيانات المنشور'], 400);
        }
        if ($post->user_id == Auth::user()->id && Auth::user()->status==1) {
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
                return response(['status' => 0, 'data' => array(), 'message' => $validate->errors()], 422);
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
                $image_type = 'png';
                $image_base64 = base64_decode($request->image_post);
                $imageName = time() . uniqid() . '.' . $image_type;
                $file = $folderPath . $imageName;
                file_put_contents($file, $image_base64);
                $post_image->image = $imageName;
                $post_image->save();
            }
            $this->logRepository->Create_Data('' . Auth::user()->id . '', 'تعديل', 'تعديل  منشور للمستخدم');
            return response(['status' => 1, 'data' => ['post' => new PostResource($post)], 'message' => 'تم تعديل المنشور بنجاح'], 201);
        }
        return response(['status' => 0, 'data' => array(), 'message' => 'لا يمكن اتمام الطلب'], 400);
    }

    public function delete(Request $request)
    {
        $post = Post::with('image', 'like', 'commit_post')->find($request->post_id);
        if (!$post) {
            return response(['status' => 0, 'data' => array(), 'message' => 'خطا فى تحميل البيانات المنشور'], 400);
        }
        if ($post->user_id == Auth::user()->id&&Auth::user()->status==1) {
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
            return response(['status' => 1, 'data' => array(), 'message' => 'تم مسح المنشور بنجاح'], 200);
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
        $post = Post::find($request->post_id);
        if (!$post) {
            return response(['status' => 0, 'data' => array(), 'message' => 'خطا فى تحميل البيانات المنشور'], 400);
        }
        if ($user->id == Auth::user()->id) {
            $like = Like::where('category', 'post')->where('category_id', $post->id)->where('user_id', $user->id)->count();
            if ($like ==0) {
                $like = new Like();
                $like->category_id = $post->id;
                $like->category = 'post';
                $like->user_id = $user->id;
                $like->save();
                if($post->user_id != $user->id) {
                    $notification = new Notification();
                    $notification->user_send_id = $user->id;
                    $notification->user_receive_id = $post->user_id;
                    $notification->status = 1;
                    $notification->details = $user->first_name . " " . $user->second_name . ' قام بعمل اعجاب على المنشور';
                    $notification->save();
                    $post_user=User::find($post->user_id);
                    $firebaseToken = $post_user->remember_token;
                    $SERVER_API_KEY = 'AIzaSyAfsVDrqkA-jPspWmlO2aWxY8B0wG_FXmY';
                    $data = [
                        "registration_ids" => $firebaseToken,
                        "notification" => [
                            "title" => 'اعجاب على المنشور',
                            "body" => $notification->details,
                        ]
                    ];
                    $dataString = json_encode($data);
                    $headers = [
                        'Authorization: key=' . $SERVER_API_KEY,
                        'Content-Type: application/json',
                    ];
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
                    $response = curl_exec($ch);
                }
                $data = Like::where('category', 'post')->where('category_id', $post->id)->get();
                $message = 'تم تسجيل الاعجاب بنجاح';
                $this->logRepository->Create_Data('' . Auth::user()->id . '', 'اعجاب', 'تسجيل اعجاب منشور للمستخدم');
            } else {
                Like::where('category', 'post')->where('category_id', $post->id)->where('user_id', $user->id)->delete();
                $message = 'تم مسح الاعجاب بنجاح';
                $data = Like::where('category', 'post')->where('category_id', $post->id)->get();
                $this->logRepository->Create_Data('' . Auth::user()->id . '', 'مسح الاعجاب', 'مسح اعجاب منشور للمستخدم');
            }
            return response(['status' => 1, 'data' => ['like' => LikeResource::collection($data), 'count' => count($data)], 'message' => $message], 200);
        }
        return response(['status' => 0, 'data' => array(), 'message' => 'لا يمكن اتمام الطلب'], 400);
    }

    public function share(Request $request)
    {
        $user = User::find($request->user_id);
        if (!$user) {
            return response(['status' => 0, 'data' => array(), 'message' => 'خطا فى تحميل البيانات المستخدم'], 400);
        }
        $post = Post::with('image', 'like', 'commit_post')->find($request->post_id);
        if (!$post) {
            return response(['status' => 0, 'data' => array(), 'message' => 'خطا فى تحميل البيانات المنشور'], 400);
        }
        if ($user->id == Auth::user()->id) {
            $posts = Post::find($request->post_id);
            if ($posts) {
                $post = new Post();
                $post->details = $posts->details;
                $post->status = 1;
                $post->user_id = $user->id;
                $post->post_id = $posts->id;
                $post->save();
                if($post->user_id != $user->id) {
                    $notification = new Notification();
                    $notification->user_send_id = $user->id;
                    $notification->user_receive_id = $post->user_id;
                    $notification->status = 1;
                    $notification->details = $user->first_name . " " . $user->second_name . ' قام بعمل مشاركه على المنشور';
                    $notification->save();
                }
                $this->logRepository->Create_Data('' . Auth::user()->id . '', 'مشاركه', 'مشاركه منشور');
                return response(['status' => 1, 'data' => ['post' => new PostResource($post)], 'message' => 'تم مشاكره المنشور بنجاح'], 201);
            }
            return response(['status' => 0, 'data' => array(), 'message' => 'خطا فى مشاركه المنشور'], 400);
        }
        return response(['status' => 0, 'data' => array(), 'message' => 'لا يمكن اتمام الطلب'], 400);
    }
}
