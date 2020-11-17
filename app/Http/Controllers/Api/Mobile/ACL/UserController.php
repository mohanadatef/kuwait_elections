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
        $this->middleware('auth:api', ['except' => ['store']]);
        $this->logRepository = $LogRepository;
        $this->userRepository = $UserRepository;
    }

    public function store(Request $request)
    {
        $validate = \Validator::make($request->all(), [
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
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
            return response(['status' => 0, 'message' => $validate->errors()], 422);
        }
        $user = new User();
        $user->status = 1;
        $user->username = $request->username;
        $user->name = $request->name;
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
        $image_user = new Image();
        $image_user->category_id = $user->id;
        $image_user->category = 'profile';
        $image_user->status = 1;
        if ($request->image_user) {
            $folderPath = public_path('images/user/profile/');
            $image_parts = explode(";base64,", $request->image_user);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);
            $file = $folderPath . time() . uniqid() . '.' . $image_type;
            file_put_contents($file, $image_base64);
            $image_user->image = time() . uniqid() . '.' . $image_type;
        } else {
            $file_image_profile = 'data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/2wCEAAkGBxQHBg0QEBIPEA4QEBEQFRgQDRcQExAaFhUWFiATFRUYHSggGB4lGxgWITEhJSkrLi4uFx8zODMsNygtLisBCgoKDQ0NFQ0NDy0ZFRkrLSs3Ky0tLisrKzctNy0rNystLS0rKysrKy0rLSsrKysrKysrKysrKysrKysrKysrK//AABEIAOEA4QMBIgACEQEDEQH/xAAbAAEAAwEBAQEAAAAAAAAAAAAAAwQFAgYBB//EADQQAQACAAMFBQcCBwEAAAAAAAABAgMEEQUSITFhQVFxgbETIlKRocHRFDQyQnKCkuHxJP/EABYBAQEBAAAAAAAAAAAAAAAAAAABAv/EABYRAQEBAAAAAAAAAAAAAAAAAAABEf/aAAwDAQACEQMRAD8A/TAGkAAAAAAAAAAAAAAAAAAAAAAAAAAAAABAAAAAAAHVKTiW0iJmegOX2I1nSOM9F2mzL25zWv1lo5fLVy9eEce2Z5yauMzC2de8cdKx15/KE9dld9p8qtITVZ07Kj4p/wAUd9l2jlaJ8Y0aoaMHFyl8LnWdO+OMIHpVTNZGuNEzHu2747fGDUxijvFwpwbzW0aT69YcKgAAAAAAAAAAAAAAAAAA3Mjl/YYMfFPGfwx8vTfzFI77Q9ClWACKAAAAAAgzmXjMYWn80cpYUxuzMTzjg9IyNq4W5jxaOVo+sLEqiAqAAAAAAAAAAAAAAAALOz41zlPP0luMPZv7yvn6S3EqwARQAAAAABS2rTeyuvwzE/b7rqttGf8Ax316esAwwGmQAAAAAAAAAAAAAAAFrZ37ynn6S22FkJ0zlPH7S3UqwARQAAAAABibStM5u0azpGmnHlwhtsHPTrnL+P2WCABWQAAAAAAAAAAAAAAAE+SiZzNJiJmItHZybyHJ03MtSI7on5pkrQAgAAAAAAMDNxP6m+sTGtp5xz4t9U2nTeylp7Y0mPmsGKArIAAAAAAAAAAAAAAADc2fffylOnD5LLN2PicL1/uj0/DSZaAAAAAAAAFLa193LafFMR8uK6ydr4m9jVr8MeqwUAFZAAAAAAAAABQAAAAAEmXxpwMWLR/1t5XH/UYMW005xprrowGnsfE4Xr/d9vwlGkAigAAAAAIM3mP02Frprx056MPExJxMSbTzmdWhti/GlfGft+Wa1EAAAAAAAAAAABAAAAAABNlMb2GPW3ZynwlCA9LE6wKWysSb5eYn+WdIXWWgAAAAFbaN5plLadI+YMrOYvtszaezlHhCAGkABAAAAAAAAAAAAAAAAAAGxsmNMtPW0+kLqts+m5k6ddZ+c6rLLQAAAArbRjXJ38p+sLKPMU38C8d9Zj6A88A0yAAAAAAAAAAAAAAAAAAOqV37xEc5nQpSb20iJmejVyGS9jO9b+L0FXaxu1iO6NH0GVAAAAAAefzWH7LMWjrrHhKJt57KfqK6xwtHLr0lj4mHOFbS0TEtRHAAgAAAAAAAAAAAAPsRvTpHGei9l9mzfjf3Y7o5/wChVGtd+2kRMz0X8vsybcbzpHdHP5tHBwK4NdKxEes+aRNMR4WDXBrpWIhICKAAAAAAAAOcTDjErpaImOroBmZjZnbSfKftLPxMOcO2lomJ6vRuMTDjFrpaImOq6jzo0cxszTjSdek/aVC9JpbSYmJ6qOQBAAAAAH2OMg+LeVyNsbjPu1+s+ELeSyG5EWvxt2R2R+ZX01cRYGXrgR7sce+eMz5pQRQAAAAAAAAAAAAAAABHjYNcaulo19Y80gDIzOzpw+Nfej6x+VF6VTzmRjHiZrwv9J8VlTGMOrVmlpieEw5VAABpbKy2vvz4V/LOrG9aIjnM6PRYVPZ4cVjlEaFWOgGVAAAAAAAAAAAAAAAAAAAAAAUdqZffw9+P4q8+sMh6WY1h57Hw/ZY1q90rEqMBUTZX9zh/1R6t8EqwARQAAAAAAAAAAAAAAAAAAAAABibS/eW8vSAWJVUBUf/Z';
            $folderPath = public_path('images/user/profile/');
            $image_parts = explode(";base64,", $file_image_profile);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);
            $file = $folderPath . time() . uniqid() . '.' . $image_type;
            file_put_contents($file, $image_base64);
            $image_user->image = time() . uniqid() . '.' . $image_type;
        }
        $image_user->save();
        if ($user) {
            $this->logRepository->Create_Data('' . $user->id . '', 'تسجيل', 'تسجيل مستخدم جديد');
            return response([
                'status' => 1,
                'user' => array(new UserResource($user)),
            ], 201);
        }
        return response(['status' => 0, 'user' => ''], 400);
    }

    public function show(Request $request)
    {
        $user = $this->userRepository->Get_One_Data($request->id);
        if ($user) {
            $this->logRepository->Create_Data('' . Auth::User()->id . '', 'عرض', 'عرض الصفحه الشخصيه');
            if ($user->id == Auth::User()->id) {
                $post = Post::where('user_id', Auth::User()->id)->where('status', 1)->get();
                if ($post) {
                    $post = PostResource::collection($post);
                }
                return response([
                    'status' => 1,
                    'user' => array(new UserResource($user)),
                    'post' => $post,
                ], 200);
            } else {
                $friend = Friend::where('user_send_id', Auth::User()->id)
                    ->where('user_receive_id', $user->id)->where('status', 1)
                    ->orwhere('user_receive_id', Auth::User()->id)
                    ->where('user_send_id', $user->id)->where('status', 1)->first();
                $post = Post::where('user_id', $user->id)->where('status', 1)->get();
                if ($post) {
                    $post = PostResource::collection($post);
                }
                if ($friend) {
                    $friend = array(new FriendResource($friend));
                    $status_friend = 1;
                }
                if (count($friend) == 0) {
                    $status_friend = 0;
                } elseif ($friend->user_send_id == Auth::user()->id) {
                    $status_friend = 2;
                } elseif ($friend->user_send_id == Auth::user()->id) {
                    $status_friend = 3;
                }
                return response([
                    'status' => 1,
                    'status_friend' => $status_friend,
                    'friend' => $friend,
                    'message' => 'يمكن قبول او رفض الطلب',
                    'post' => $post,
                ], 200);
            }
        }
        return response(['status' => 0, 'message' => 'لا يوجد بيانات بهذا الاسم'], 400);
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
            if ($user) {
                if (Auth::user() == true) {
                    $this->logRepository->Create_Data('' . Auth::user()->id . '', 'بحث', 'البحث عن مستخدم');
                }
                return response([
                    'status' => 1,
                    'user' => UserResource::collection($user)
                ], 200);
            }
        }
        return response(['status' => 0, 'user' => ''], 400);
    }

    public function update(Request $request)
    {
        $validate = \Validator::make($request->all(), [
            'username' => 'required|max:255|string|unique:users,username,' . Auth::user()->id . ',id',
            'email' => 'required|email|max:255|string|unique:users,email,' . Auth::user()->id . ',id',
            'name' => 'required|string|max:255',
            'family' => 'required|string|max:255',
            'gender' => 'required|string',
            'birth_day' => 'required|string',
            'address' => 'required|string',
            'job' => 'required|string',
            'mobile' => 'required|string|unique:users,mobile,' . Auth::user()->id . ',id',
            'degree' => 'string|max:255',
            'about' => 'string|max:255',
        ]);
        if ($validate->fails()) {
            return response(['status' => 0, 'message' => $validate->errors()], 422);
        }
        $user = $this->userRepository->Get_One_Data(Auth::user()->id);
        if ($user) {
            $user->update($request->all());
            $this->logRepository->Create_Data('' . Auth::user()->id . '', 'تعديل', 'تعديل بيانات المستخدم');
            return response(['status' => 1,
                'user' => array(new UserResource($user)),
            ], 201);
        }
        return response(['status' => 0,
            'user' => ''
        ], 400);
    }

}
