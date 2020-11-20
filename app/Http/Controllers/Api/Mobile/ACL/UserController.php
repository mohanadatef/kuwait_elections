<?php

namespace App\Http\Controllers\Api\Mobile\ACL;

use App\Http\Resources\Mobile\ACL\FriendResource;
use App\Http\Resources\Mobile\ACL\UserResource;
use App\Http\Resources\Mobile\Social_Media\PostResource;
use App\Models\ACL\Friend;
use App\Models\Image;
use App\Models\Social_Media\Post;
use App\Repositories\ACL\LogRepository;
use App\Repositories\ACL\UserRepository;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use JWTAuth;

class UserController extends Controller
{
    private $logRepository;
    private $userRepository;

    public function __construct(LogRepository $LogRepository, UserRepository $UserRepository)
    {
        $this->middleware('auth:api', ['except' => ['store', 'search_user', 'show']]);
        $this->logRepository = $LogRepository;
        $this->userRepository = $UserRepository;
    }

    public function store(Request $request)
    {
        $validate = \Validator::make($request->all(), [
            'email' => 'required|string|email|max:255|unique:users',
            'civil_reference' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'name' => 'required|string|max:255',
            'family' => 'required|string|max:255',
            'circle_id' => 'required|exists:circles,id',
            'area_id' => 'required|exists:areas,id',
            'mobile' => 'required|string|unique:users',
            'gender' => 'required|string',
            'birth_day' => 'required|string',
            'address' => 'required|string',
            'job' => 'required|string',
            'image_user' => 'string',
        ]);
        if ($validate->fails()) {
            return response(['status' => 0, 'data' => ['error' => $validate->errors()], 'message' => 'خطا فى البيانات المدخله'], 422);
        }
        $user = new User();
        $user->status = 1;
        $user->name = $request->name;
        $user->civil_reference = $request->civil_reference;
        $user->family = $request->family;
        $user->mobile = $request->mobile;
        $user->email = $request->email;
        $user->circle_id = $request->circle_id;
        $user->area_id = $request->area_id;
        $user->gender = $request->gender;
        $user->job = $request->job;
        $user->address = $request->address;
        $user->birth_day = $request->birth_day;
        $user->password = Hash::make($request->password);
        $user->save();
        $credentials = $request->only('email', 'password');
        $token = JWTAuth::attempt($credentials);
        $user->remember_token = $token;
        $role[] = 3;
        $user->role()->sync((array)$role);
        $user->save();
        if ($user) {
            $this->logRepository->Create_Data('' . $user->id . '', 'تسجيل', 'تسجيل مستخدم جديد');
            return response(['status' => 1, 'data' => ['user' => new UserResource($user)], 'message' => 'تم التسجيل بنجاح'], 201);
        }
        return response(['status' => 0, 'data' => array(), 'message' => 'خطا فى حفظ البيانات'], 400);
    }

    public function show(Request $request)
    {
        $user = $this->userRepository->Get_One_Data($request->user_id);
        if (!$user) {
            return response(['status' => 0, 'data' => array(), 'message' => 'لا يوجد بيانات بهذا الاسم'], 400);
        }
        if($request->status_auth == 1)
        {
        $this->logRepository->Create_Data('' . Auth::User()->id . '', 'عرض', 'عرض الصفحه الشخصيه');
        }
        $post = Post::where('user_id', $user->id)->where('status', 1)->paginate(25);
        if ($post) {
            $post = PostResource::collection($post);
        }
        else
        {
            $post=array();
        }
        return response([
            'status' => 1,
            'data'=>[
            'user' => new UserResource($user),
            'post' => $post],
            'message'=>'عرض بيانات المستخدم'
        ], 200);
    }

    public function search_user(Request $request)
    {
        if ($request->word != null) {
            $user = User::where('username', 'like', $request->word . '%')
                ->orWhere('username', 'like', '%' . $request->word . '%')
                ->orwhere('email', 'like', $request->word . '%')
                ->orWhere('email', 'like', '%' . $request->word . '%')
                ->orwhere('name', 'like', $request->word . '%')
                ->orWhere('name', 'like', '%' . $request->word . '%')
                ->orwhere('family', 'like', $request->word . '%')
                ->orWhere('family', 'like', '%' . $request->word . '%')
                ->orwhere('mobile', 'like', $request->word . '%')
                ->orWhere('mobile', 'like', '%' . $request->word . '%')
                ->orwhere('job', 'like', $request->word . '%')
                ->orWhere('job', 'like', '%' . $request->word . '%')
                ->orwhere('degree', 'like', $request->word . '%')
                ->orWhere('degree', 'like', '%' . $request->word . '%')
                ->orwhere('address', 'like', $request->word . '%')
                ->orWhere('address', 'like', '%' . $request->word . '%')
                ->where('status', 1)
                ->paginate(25);
            if ($user) {
                if($request->status_auth ==1)
                {
                    $this->logRepository->Create_Data('' . Auth::user()->id . '', 'بحث', 'البحث عن مستخدم');
                }
                return response([
                    'status' => 1,
                    'data'=>[
                    'user' => UserResource::collection($user)
                    ],
                    'message'=>'بيانات المستخدمين'
                ], 200);
            }
            return response(['status' => 1, 'data' => array(),'message'=>'لا يوجد مستخدمين'], 200);
        }
        return response(['status' => 0, 'data' => array(),'message'=>'خطا فى المدخلات'], 400);
    }

    public function update(Request $request)
    {
        $user = $this->userRepository->Get_One_Data($request->user_id);
        if (!$user) {
            return response(['status' => 0, 'data' => array(), 'message' => 'لا يوجد بيانات بهذا الاسم'], 400);
        }
        $validate = \Validator::make($request->all(), [
            'email' => 'required|email|max:255|string|unique:users,email,' . $request->user_id . ',id',
            'civil_reference' => 'required|string|max:255|unique:users,civil_reference'. $request->user_id . ',id',
            'name' => 'required|string|max:255',
            'family' => 'required|string|max:255',
            'gender' => 'required|string',
            'birth_day' => 'required|string',
            'address' => 'string',
            'job' => 'string',
            'mobile' => 'required|string|unique:users,mobile,' . $request->user_id . ',id',
            'degree' => 'string|max:255',
            'about' => 'string|max:255',
        ]);
        if ($validate->fails()) {
            return response(['status' => 0,'data'=>['error'=>$validate->errors()] ,'message' =>'خطا فى المدخلات' ], 422);
        }
            $user->update($request->all());
            $this->logRepository->Create_Data('' . Auth::user()->id . '', 'تعديل', 'تعديل بيانات المستخدم');
            return response(['status' => 1,
                'data'=>[
                'user' => new UserResource($user)],
                'message'=>'تم تحديت بيانات المستخدم بنجاح'
            ], 201);
    }

}