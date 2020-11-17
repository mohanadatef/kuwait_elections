<?php

namespace App\Http\Controllers\Api\Web\ACL;

use App\Models\ACL\Forgot_Password;
use App\Repositories\ACL\LogRepository;
use App\Repositories\ACL\UserRepository;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    private $logRepository;
    private $userRepository;

    public function __construct(LogRepository $LogRepository, UserRepository $UserRepository)
    {
        $this->logRepository = $LogRepository;
        $this->userRepository = $UserRepository;
    }

   public function check(Request $request)
   {
       $user = User::where('email',$request->email)->first();
       if($user)
       {
           $this->logRepository->Create_Data(''.$user->id.'', 'كلمه السر', 'محاوله تغير كلمه السر');
           if($user->status == 0)
           {
               return response(['status'=>0,'message' => 'برجاء الاتصال بالدعم الفني'], 400);
           }
           $forgot_password = Forgot_Password::where('user_id',$user->id)->where('status',0)->first();
           if(!$forgot_password)
           {
               $forgot_password = new Forgot_Password();
               $forgot_password->status = 0;
               $forgot_password->user_id = $user->id;
               $forgot_password->code = Str::random(5);
               $forgot_password->save();
           }
           return response(['status'=>1,'message' => 'تم ارسال الكود على الايميل','code'=>$forgot_password->code], 200);
       }
       return response(['status'=>0,'message' => 'لا يوجد بيانات بهذا الايميل'], 400);
   }

   public function validate_code(Request $request)
   {
       $user = User::where('email',$request->email)->first();
       if($user)
       {
           $this->logRepository->Create_Data(''.$user->id.'', 'كلمه السر', 'تاكيد كود التغير كلمه السر');
           if($user->status == 0)
           {
               return response(['status'=>0,'message' => 'برجاء الاتصال بالدعم الفني'], 400);
           }
           $forgot_password =  Forgot_Password::where('code',$request->code)->where('status',0)->where('user_id',$user->id)->first();
           if($forgot_password)
           {
           $forgot_password->status =1;
           $forgot_password->update();
           return response(['status' => 1,'message'=>'كود تغير كلمه السر صحيح'], 201);
           }
           return response(['status' => 0,'message'=>'كود تغير كلمه السر غير صحيح'], 400);
       }
       return response(['status'=>0,'message' => 'لا يوجد بيانات بهذا الايميل'], 400);
   }

   public function change_password(Request $request)
   {
       $user = User::where('email',$request->email)->first();
       if($user)
       {
           $this->logRepository->Create_Data(''.$user->id.'', 'كلمه السر', 'تغير كلمه السر');
           if($user->status == 0)
           {
               return response(['status' => 0,'message' => 'برجاء الاتصال بالدعم الفني'], 400);
           }
           $validate = \Validator::make($request->all(), [
               'password' => 'required|string|min:6|confirmed',
           ]);
           if ($validate->fails()) {
               return response(['status'=>0,'message' => $validate->errors()], 422);
           }
           $user->password=Hash::make($request->password);
           $user->update();
           return response(['status'=>1,'message' => 'تم تغير كلمه السر'], 201);
       }
       return response(['status'=>0,'message' => 'لا يوجد بيانات بهذا الايميل'], 400);
   }
}
