<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\Election\NomineeResource;
use App\Http\Resources\ACL\UserResource;
use App\Http\Resources\Social_Media\PostResource;
use App\Models\Social_Media\Post;
use App\Repositories\ACL\LogRepository;
use App\Repositories\ACL\UserRepository;
use App\Repositories\Setting\SettingRepository;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    private $logRepository;
    private $userRepository;
    private $settingRepository;

    public function __construct(LogRepository $LogRepository, UserRepository $UserRepository, SettingRepository $SettingRepository)
    {
        $this->logRepository = $LogRepository;
        $this->userRepository = $UserRepository;

        $this->settingRepository = $SettingRepository;
    }

    public function index(Request $request)
    {
        $nominee = array();
        if ($request->status_auth == 1) {
            $user = $this->userRepository->Get_One_Data($request->user_id);
            if (!$user) {
                return response(['status' => 0, 'data' => array(), 'message' => 'لا يوجد بيانات بهذا الاسم'], 400);
            }
            $this->logRepository->Create_Data($user->id, 'عرض', 'عرض ببيانات الصفحه الرئيسيه');
            $friend_s = DB::table('friends')->where('user_send_id', $user->id)->where('status', 1)->pluck('user_receive_id', 'id');
            $friend_r = DB::table('friends')->where('user_receive_id', $user->id)->where('status', 1)->pluck('user_send_id', 'id');
            $friend = array_merge($friend_s->toArray(), $friend_r->toArray());
            $post = Post::with('commit_post', 'like', 'image')
                ->wherein('user_id', $friend)
                ->orwhere('user_id', $user->id)
                ->where('status', 1)->orderby('created_at', 'DESC')->paginate(25);
            $nominee = DB::table('users')
                ->join('role_user', 'role_user.user_id', '=', 'users.id')
                ->where('role_user.role_id',  4)
                ->where('users.circle_id',  $user->circle_id)
                ->where('users.status', 1)
                ->select('users.id', 'users.name')
                ->inRandomOrder()->first();
            if ($nominee) {
                $nominee = User::with(['profile_image' => function ($query) {
                    $query->where('category', 'profile')->where('status', 1);
                }])->find($nominee->id);
                $nominee = new NomineeResource($nominee);
            }
            return response(['status' => 1, 'data' => ['count_post' => count($post), 'post' => PostResource::collection($post), 'user' => new UserResource($user), 'nominee' => $nominee, 'setting' => $this->settingRepository->Get_all_In_Response()], 'message' => 'الصفحه الرئيسيه'], 200);
        }
        $nominee = DB::table('users')
            ->join('role_user', 'role_user.user_id', '=', 'users.id')
            ->where('role_user.role_id',  4)
            ->where('users.status', 1)
            ->select('users.id', 'users.name')
            ->inRandomOrder()->first();
        if ($nominee) {
            $nominee = User::with(['profile_image' => function ($query) {
                $query->where('category', 'profile');
            }])->find($nominee->id);
            $nominee = new NomineeResource($nominee);
        }
        $post = Post::with('commit_post', 'like', 'image')->where('status', 1)->orderby('created_at', 'DESC')->paginate(25);
        return response(['status' => 1, 'data' => ['count_post' => count($post), 'post' => PostResource::collection($post), 'nominee' => $nominee, 'setting' => $this->settingRepository->Get_all_In_Response()], 'message' => 'الصفحه الرئيسيه'], 200);
    }
}

