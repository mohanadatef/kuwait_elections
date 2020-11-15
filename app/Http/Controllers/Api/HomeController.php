<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\ACL\NomineeResource;
use App\Http\Resources\Social_Media\PostResource;
use App\Models\Social_Media\Post;
use App\Repositories\ACL\LogRepository;
use App\Repositories\ACL\UserRepository;
use App\User;
use Illuminate\Http\Request;
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

    public function index(Request $request)
    {
        $user = $this->userRepository->Get_One_Data($request->id);
        if ($user != null) {
            $this->logRepository->Create_Data($request->id, 'عرض', 'عرض ببيانات الصفحه الرئيسيه Api' . $user->username );
            $post = Post::with(['commit_post' => function ($query) {
                $query->where('status', 1);
            }],['like' => function ($query) {
                $query->where('category', 'post');
            }])->where('user_id', $request->id)->where('status', 1)->orderby('created_at','DESC')->get();
            $user_role = DB::table("role_user")->where('role_id', 4)->pluck("user_id", "id");
            $user = DB::table("users")->wherein('id',$user_role)->where('circle_id',Auth::user()->circle_id)->pluck('id','id');
            $user = array_rand($user->toArray(), 1);
            $user = User::find($user);
                return response(['data' =>  PostResource::collection($post),
                    'nominee' => array(new NomineeResource($user)),
                ], 200);
        } else {
            return response(['message' => 'لا يوجد بيانات بهذا الاسم'], 400);
        }
    }
}
