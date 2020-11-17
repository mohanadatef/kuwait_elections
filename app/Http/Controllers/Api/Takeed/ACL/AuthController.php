<?php

namespace App\Http\Controllers\Api\Takeed\ACL;

use App\Http\Resources\Takeed\ACL\UserResource;
use App\Models\ACL\Role_user;
use App\Repositories\ACL\LogRepository;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use JWTAuth;

class AuthController extends Controller
{
    private $logRepository;

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct(LogRepository $LogRepository)
    {
        $this->middleware('auth:api', ['except' => ['login']]);
        $this->logRepository = $LogRepository;
    }

    /**
     * Get a JWT token via given credentials.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $user = User::where('email', $request->email)->first();
        if ($user) {
            if ($token = JWTAuth::attempt($credentials)) {
                if ($user->status == 1) {
                    $role = Role_user::where('user_id', $user->id)->where('role_id', 1)
                        ->orwhere('user_id', $user->id)->where('role_id', 2)
                        ->orwhere('user_id', $user->id)->where('role_id', 5)->get();
                    if (count($role) != 0) {
                        if ($token = JWTAuth::attempt($credentials)) {
                            $user = User::find(auth::user()->id);
                            $user->remember_token = $token;
                            $user->update();
                            $this->logRepository->Create_Data(''.Auth::user()->id.'', 'تجسل الدخول', 'تسجيل الدخول');
                            return response(['status' => 1,'token' => $token,'user' => new UserResource($user)],200);
                        }
                    }
                }
            }
        }
        return response()->json(['status' => 0], 401);
    }

    public function me()
    {

        return response()->json($this->guard()->user());
    }

    public function logout()
    {
        $this->logRepository->Create_Data(''.Auth::user()->id.'', 'تسجيل الخروج', 'تم تسجيل الخروج');
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