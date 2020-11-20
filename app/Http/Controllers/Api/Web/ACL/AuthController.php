<?php

namespace App\Http\Controllers\Api\Web\ACL;

use App\Http\Resources\Web\ACL\UserResource;
use App\Repositories\ACL\LogRepository;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use JWTAuth;

class AuthController extends Controller
{
    private $logRepository;

    public function __construct(LogRepository $LogRepository)
    {
        $this->middleware('auth:api', ['except' => ['login']]);
        $this->logRepository = $LogRepository;
    }

    public function login(Request $request)
    {
        $user=User::where('civil_reference', $request->email)->orwhere('email', $request->email)->first();
        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                if ($user->status == 1) {
                    $credentials = ['civil_reference'=>$user->civil_reference, 'password'=>$request->password];
                    $token = JWTAuth::attempt($credentials);
                    $user->remember_token = $token;
                    $user->update();
                    $this->logRepository->Create_Data('' . Auth::user()->id . '', 'الدخول', 'تم تسجبل الدخول');
                    return response(['status' => 1, 'user' => array(new UserResource($user))], 200);
                }
                return response(['status' => 0, 'message' => 'برجاء الاتصال بخدمه العملاء'], 401);
            }
            return response(['status' => 0, 'message' => 'كلمه السر خطا'], 401);
        }
        return response(['status' => 0, 'message' => 'الايميل خطا'], 401);
    }

    public function me()
    {
        return response()->json($this->guard()->user());
    }

    public function logout()
    {
        $this->logRepository->Create_Data('' . Auth::user()->id . '', 'الخروج', 'تم تسجيل الخروج');
        $this->guard()->logout();
        return response()->json(['status' => 1, 'message' => 'تم تسجيل الخروج بنجاح']);
    }

    public function refresh()
    {
        return $this->respondWithToken($this->guard()->refresh());
    }

    protected function respondWithToken($token)
    {
        $token = array(
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL());
        return $token;
    }

    public function guard()
    {
        return Auth::guard();
    }
}