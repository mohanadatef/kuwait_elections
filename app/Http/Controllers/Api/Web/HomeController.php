<?php

namespace App\Http\Controllers\Api\Web;

use App\Http\Resources\Web\ACL\NomineeResource;
use App\Http\Resources\Web\ACL\UserResource;
use App\Http\Resources\Web\Social_Media\PostResource;
use App\Models\Social_Media\Post;
use App\Repositories\ACL\LogRepository;
use App\Repositories\ACL\UserRepository;
use App\User;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    private $logRepository;
    private $userRepository;

    public function __construct(LogRepository $LogRepository, UserRepository $UserRepository)
    {
        $this->middleware('auth:api');
        $this->logRepository = $LogRepository;
        $this->userRepository = $UserRepository;
    }

    public function index()
    {
        if (Auth::check()) {
            $user = $this->userRepository->Get_One_Data(Auth::user()->id);
            if ($user != null) {
                $this->logRepository->Create_Data(Auth::user()->id, 'عرض', 'عرض ببيانات الصفحه الرئيسيه');
                $friend_s = DB::table('friends')->where('user_send_id', Auth::User()->id)->where('status', 1)->pluck('user_receive_id', 'id');
                $friend_r = DB::table('friends')->where('user_receive_id', Auth::User()->id)->where('status', 1)->pluck('user_send_id', 'id');
                $friend = array_merge($friend_s->toArray(), $friend_r->toArray());
                $post = Post::with(['commit_post' => function ($query) {
                    $query->where('status', 1);
                }], ['like' => function ($query) {
                    $query->where('category', 'post');
                }])->wherein('user_id', $friend)->orwhere('user_id', Auth::user()->id)->where('status', 1)->orderby('created_at', 'DESC')->get();
                $user_role = DB::table("role_user")->where('role_id', 4)->pluck("user_id", "id");
                if (count($user_role) != 0) {
                    $nominee = User::with('image')->wherein('id', $user_role)->where('circle_id', Auth::user()->circle_id)->inRandomOrder()->first();
                    if ($nominee) {
                        return response(['status' => 1, 'post' => PostResource::collection($post),
                            'user' => array(new UserResource($user)), 'nominee' => array(new NomineeResource($nominee))], 200);
                    }
                }
                return response(['status' => 1, 'post' => PostResource::collection($post), 'user' => array(new UserResource($user)), 'nominee' => ''], 200);
            }
            return response(['status' => 0], 400);
        }
        $user_role = DB::table("role_user")->where('role_id', 4)->pluck("user_id", "id");
        if (count($user_role) != 0) {
                $nominee = User::with('image')->wherein('id', $user_role)->inRandomOrder()->first();
            if ($nominee) {
                $post = Post::with(['commit_post' => function ($query) {
                    $query->where('status', 1);
                }], ['like' => function ($query) {
                    $query->where('category', 'post');
                }])->wherein('user_id', $user_role)->where('status', 1)->orderby('created_at', 'DESC')->get();
                if($post)
                {
                    return response(['status' => 1, 'post' => PostResource::collection($post), 'nominee' => array(new NomineeResource($nominee))], 200);
                }
                return response(['status' => 1, 'post' => '', 'nominee' => array(new NomineeResource($nominee))], 200);
            }
        }
        return response(['status' => 1, 'post' => '', 'nominee' => ''], 200);
    }
}
