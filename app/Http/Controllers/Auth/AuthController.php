<?php

namespace App\Http\Controllers\Auth;

use App\Http\Resources\ACL\UserResource;
use App\Models\ACL\Role_user;
use App\Repositories\ACL\LogRepository;
use App\User;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
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
                    if ($request->type == 'web') {
                        $role = Role_user::where('user_id', $user->id)->where('role_id', 1)
                            ->orwhere('user_id', $user->id)->where('role_id', 2)
                            ->orwhere('user_id', $user->id)->where('role_id', 3)
                            ->orwhere('user_id', $user->id)->where('role_id', 4)->get();
                        if (count($role) != 0) {
                            if ($token = JWTAuth::attempt($credentials)) {
                                $user = User::find(auth::user()->id);
                                $user->remember_token = $token;
                                $user->update();
                                $this->logRepository->Create_Data('' . Auth::user()->id . '', 'تجسل الدخول', 'تسجب الدخول على web عن طريق Api');
                                $token = $this->respondWithToken($token);
                                return response([
                                    'status' => 1,
                                    'message' => ' web تم تسجيل بنجاح',
                                    'token' => array($token),
                                    'user' => array(new UserResource($user))
                                ], 200);
                            }
                        }
                        return response()->json(['status' => 0,
                            'message' => ' web ليس ليك اذن للدخول'], 401);
                    } elseif ($request->type == 'mobile') {
                        $role = Role_user::where('user_id', $user->id)->where('role_id', 1)
                            ->orwhere('user_id', $user->id)->where('role_id', 2)
                            ->orwhere('user_id', $user->id)->where('role_id', 3)
                            ->orwhere('user_id', $user->id)->where('role_id', 4)->get();
                        if (count($role) != 0) {
                            if ($token = JWTAuth::attempt($credentials)) {
                                $user = User::find(auth::user()->id);
                                $user->remember_token = $token;
                                $user->update();
                                $this->logRepository->Create_Data('' . Auth::user()->id . '', 'تجسل الدخول', 'تسجب الدخول على mobile عن طريق Api');
                                $token = $this->respondWithToken($token);
                                return response([
                                    'status' => 1,
                                    'message' => ' mobile تم تسجيل بنجاح',
                                    'token' => array($token),
                                    'user' => array(new UserResource($user))
                                ], 200);
                            }
                        }
                        return response()->json(['status' => 0,
                            'message' => ' mobile ليس ليك اذن للدخول'], 401);
                    } elseif ($request->type == 'takeed') {
                        $role = Role_user::where('user_id', $user->id)->where('role_id', 1)
                            ->orwhere('user_id', $user->id)->where('role_id', 2)
                            ->orwhere('user_id', $user->id)->where('role_id', 5)->get();
                        if (count($role) != 0) {
                            if ($token = JWTAuth::attempt($credentials)) {
                                $user = User::find(auth::user()->id);
                                $user->remember_token = $token;
                                $user->update();
                                $this->logRepository->Create_Data('' . Auth::user()->id . '', 'تجسل الدخول', 'تسجب الدخول على takeed عن طريق Api');
                                return response([
                                    'status' => 1,
                                    'message' => ' takeed تم تسجيل بنجاح',
                                    'token' => $token,
                                    'user' =>new UserResource($user)
                                ], 200);
                            }
                        }
                        return response()->json(['status' => 0,
                            'message' => 'ليس ليك اذن للدخول takeed'], 401);
                    }
                    return response()->json(['status' => 0,
                        'message' => 'خطا فى تحميل البيانات'], 401);
                }
                return response()->json(['status' => 0,
                    'message' => 'اتصل بخدمه العملاء'], 401);
            }
            return response()->json(['status' => 0,
                'message' => 'كلمه السر خطا'], 401);
        }
        return response()->json(['status' => 0,
            'message' => 'الايميل خطا'], 401);
    }

    /**
     * Get the authenticated User
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {

        return response()->json($this->guard()->user());
    }

    /**
     * Log the user out (Invalidate the token)
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        $this->logRepository->Create_Data('' . Auth::user()->id . '', 'تسجيل الخروج', 'تم تسجيل الخروج عم طريق Api');
        $this->guard()->logout();
        return response()->json(['status' => 1, 'message' => 'تم تسجيل الخروج بنجاح']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken($this->guard()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        $token = array(
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60 * 24);
        return $token;
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\Guard
     */
    public function guard()
    {
        return Auth::guard();
    }
}