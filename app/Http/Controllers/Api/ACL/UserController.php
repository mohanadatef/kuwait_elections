<?php

namespace App\Http\Controllers\Api\ACL;

use App\Http\Resources\ACL\NomineeResource;
use App\Http\Resources\ACL\UserResource;
use App\Http\Resources\Social_Media\PostResource;
use App\Models\ACL\Friend;
use App\Models\Image;
use App\Models\Social_Media\Post;
use App\Repositories\ACL\LogRepository;
use App\Repositories\ACL\UserRepository;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use JWTAuth;

class UserController extends Controller
{
    private $logRepository;
    private $userRepository;

    public function __construct(LogRepository $LogRepository, UserRepository $UserRepository)
    {
        $this->middleware('auth:api', ['except' => ['store']]);
        $this->logRepository = $LogRepository;
        $this->userRepository = $UserRepository;
    }

    public function store(Request $request)
    {
        $validate = \Validator::make($request->all(), [
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'first_name' => 'required|string|max:255',
            'second_name' => 'required|string|max:255',
            'civil_reference' => 'required|string|max:255',
            'family_name' => 'required|string|max:255',
            'circle' => 'required|exists:circles,id',
            'area' => 'required|exists:areas,id',
            'mobile' => 'required|string|unique:users',
            'gender' => 'required|string',
            'birth_day' => 'required|string',
            'address' => 'required|string',
            'job' => 'required|string',
            'image_user' => 'string',
        ]);
        if ($validate->fails()) {
            return response(['message' => $validate->errors()], 422);
        }
        $user = new User();
        $user->status = 1;
        $user->family_name = $request->family_name;
        $user->mobile = $request->mobile;
        $user->name = $request->first_name .' '. $request->second_name;
        $user->email = $request->email;
        $user->circle_id = $request->circle;
        $user->area_id = $request->area;
        $user->gender = $request->gender;
        $user->job = $request->job;
        $user->civil_reference = $request->civil_reference;
        $user->status_login = 1;
        $user->status = 1;
        $user->first_name = $request->first_name;
        $user->second_name = $request->second_name;
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
        $image_user = new Image();
        $image_user->category_id = $user->id;
        $image_user->category = 'profile';
        $image_user->status = 1;
        if ($request->image_user) {
            $folderPath=public_path('images/user/profile/');
            $image_parts = explode(";base64,", $request->image_user);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);
            $file =  $folderPath. time().uniqid().'.'.$image_type;
            file_put_contents($file, $image_base64);
            $image_user->image = time().uniqid().'.'.$image_type;
        } else {
            $image_user->image = 'profile_user.jpg';
        }
        $image_user->save();
        if ($user) {
            $this->logRepository->Create_Data($user->id, 'تسجيل مستخدم جديد', 'تسجيل مستخدم جديد عن طريق Api' . $user->username . " / " . $user->id);
            $user_role = DB::table("role_user")->where('role_id', 4)->pluck("user_id", "id");
            if (count($user_role) != 0) {
                $nominee = DB::table("users")->wherein('id', $user_role)->where('circle_id', $user->circle_id)->pluck('id', 'id');
                if (count($nominee) != 0) {
                    $nominee = array_rand($nominee->toArray(), 1);
                    $nominee = User::find($nominee);
                    return response([
                        'status' => 1,
                        'message' => 'تم تسجيل المستخدم بنجاح',
                        'data' => array(new UserResource($user)),
                        'nominee' => array(new NomineeResource($nominee)),
                    ], 201);
                }
                return response(['status' => 1,
                    'message' => 'تم تسجيل المستخدم بنجاح',
                    'data' => array(new UserResource($user)),
                    'nominee' => []], 200);
            }
            return response(['status' => 1,
                'message' => 'تم تسجيل المستخدم بنجاح',
                'data' => array(new UserResource($user)),
                'nominee' => []], 200);
        }
        return response(['message' => 'خطا فى حفظ العميل الجديد'], 400);
    }

    public function show(Request $request)
    {
        $user = $this->userRepository->Get_One_Data($request->id);
        if ($user) {
            /* if($user->id == Auth::User()->id)
             {
                 $post = Post::where('user_id',Auth::User()->id)->get();
                 $this->logRepository->Create_Data(Auth::User()->id, 'عرض', 'عرض ببيانات  Api' . $user->username . " / " . $request->id);
                     return response([
                         'user' => array(new UserResource($user)),
                         'post' =>  PostResource::collection($post),
                     ], 200);
             }
             else
             {
                 $friend_send = Friend::where('user_send_id', Auth::User()->id)->where('user_receive_id', $user->id)->where('status',1)->first();
                 $friend_receive = Friend::where('user_receive_id', Auth::User()->id)->where('user_send_id', $user->id)->where('status',1)->first();
                 if($friend_send || $friend_receive )
                 {
                     $post = Post::where('user_id',$user->id)->get();
                     $this->logRepository->Create_Data(Auth::User()->id, 'عرض', 'عرض ببيانات  Api' . $user->username . " / " . $request->id);
                     return response([
                         'user' => array(new UserResource($user)),
                         'post' =>  PostResource::collection($post),
                     ], 200);
                 }
                 else
                 {
                     return response([
                         'user' => array(new UserResource($user)),
                         'message' => 'يمكن ارسال الطلب'
                     ], 200);
                 }
             }*/
            $post = Post::where('user_id', $request->id)->get();
            $this->logRepository->Create_Data(Auth::User()->id, 'عرض', 'عرض ببيانات  Api' . $user->username . " / " . $request->id);
            return response([
                'user' => array(new UserResource($user)),
                'post' => PostResource::collection($post),
            ], 200);
        } else {
            return response(['message' => 'لا يوجد بيانات بهذا الاسم'], 400);
        }
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
                ->get();
            if ($user != null) {
                if (Auth::user() == true) {
                    $this->logRepository->Create_Data('' . Auth::user()->id . '', 'بحث', 'البحث عن مستخدم  Api');
                }
                return response([
                    'data' => UserResource::collection($user)
                ], 200);
            } else {
                return response(['message' => 'لا يوجد بيانات بهذا الاسم'], 400);
            }
        }
    }

    public function update(Request $request)
    {
        $validate = \Validator::make($request->all(), [
            'username' => 'required|max:255|string|unique:users,username,' . $request->user_id . ',id',
            'email' => 'required|email|max:255|string|unique:users,email,' . $request->user_id . ',id',
            'name' => 'required|string|max:255',
            'family' => 'required|string|max:255',
            'gender' => 'required|string',
            'birth_day' => 'required|string',
            'address' => 'required|string',
            'job' => 'required|string',
            'mobile' => 'required|string|unique:users,mobile,' . $request->user_id . ',id',
            'degree' => 'string|max:255',
            'about' => 'string|max:255',
        ]);
        if ($validate->fails()) {
            return response(['message' => $validate->errors()], 422);
        }
        $user = $this->userRepository->Get_One_Data($request->user_id);
        if ($user) {
            $user->update($request->all());
            $this->logRepository->Create_Data($request->user_id, 'تعديل بيانات المستخدم', 'تعديل بيانات المستخدم عن طريق Api');
            return response([
                'message' => 'تم تعديل بيانات المستخدم بنجاح',
                'data' => array(new UserResource($user)),
            ], 201);
        }
        return response([
            'message' => 'خطا فى تحميل البيانات'
        ], 400);
    }

}
