<?php

namespace App\Http\Controllers\Takeed\ACL;

use App\Http\Resources\Takeed\ACL\UserResource;
use App\Repositories\ACL\LogRepository;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
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
            $credentials = ['civil_reference'=>$user->civil_reference, 'password'=>$request->password];
            if ($token = JWTAuth::attempt($credentials)) {
                if ($user->status == 1) {
                    foreach ($user->role as $role) {
                        if ($role->id == 1 ||$role->id == 2||$role->id == 5) {
                            if(!$user->remember_token) {
                                $user->remember_token = $token;
                                $user->update();
                            }
                            $this->logRepository->Create_Data('' . Auth::user()->id . '', 'تجسل الدخول', 'تسجيل الدخول');
                            return response(['status' => 1, 'token' => $token, 'user' => new UserResource($user)], 200);
                        }
                    }
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
        $this->logRepository->Create_Data('' . Auth::user()->id . '', 'تسجيل الخروج', 'تم تسجيل الخروج');
        $this->guard()->logout();
        return response()->json(['status' => 1]);
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
            'expires_in' => auth('api')->factory()->getTTL() * 60 * 24);
        return $token;
    }

    public function guard()
    {
        return Auth::guard();
    }
}