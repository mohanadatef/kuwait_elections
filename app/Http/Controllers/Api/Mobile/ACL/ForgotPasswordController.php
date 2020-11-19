<?php

namespace App\Http\Controllers\Api\Mobile\ACL;

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
           $this->logRepository->Create_Data($user->id, 'تغير كلمه السر', 'محاوله التاكد من وجود ايميل' );
           if($user->status == 0)
           {
               return response(['status'=>0,'data'=>array(),'message' => 'برجاء الاتصال بالدعم الفني'], 200);
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
           return response(['status'=>1,'data'=>['code'=>$forgot_password->code],'message' => 'تم ارسال الكود على الايميل'], 200);
       }
       return response(['status'=>0,'data'=>array(),'message' => 'لا يوجد بيانات'], 400);
   }

   public function validate_code(Request $request)
   {
       $user = User::where('email',$request->email)->first();
       if($user)
       {
           $this->logRepository->Create_Data($user->id, 'تغير كلمه السر', 'تاكيد كود التغير كلمه السر' );
           if($user->status == 0)
           {
               return response(['status'=>0,'data'=>array(),'message' => 'برجاء الاتصال بالدعم الفني'], 200);
           }
           $forgot_password =  Forgot_Password::where('code',$request->code)->where('status',0)->where('user_id',$user->id)->first();
           if($forgot_password)
           {
           $forgot_password->status =1;
           $forgot_password->update();
           return response(['status' => 1], 201);
           }
           return response(['status' => 0], 400);
       }
       return response(['status'=>0,'data'=>array(),'message' => 'لا يوجد بيانات'], 400);
   }

   public function change_password(Request $request)
   {
       $user = User::where('email',$request->email)->first();
       if($user)
       {
           $this->logRepository->Create_Data($user->id, 'تغير كلمه السر', 'تغير كلمه السر');
           if($user->status == 0)
           {
               return response(['status'=>1,'data'=>array(),'message' => 'برجاء الاتصال بالدعم الفني'], 200);
           }
           $validate = \Validator::make($request->all(), [
               'password' => 'required|string|min:6|confirmed',
           ]);
           if ($validate->fails()) {
               return response(['status'=>0,'data'=>['error'=>$validate->errors()],'message' => 'خطا فى ادخال البيانات'], 422);
           }
           $user->password=Hash::make($request->password);
           $user->update();
           return response(['status'=>1,'data'=>array(),'message' => 'تم تغير كلمه السر'], 201);
       }
       return response(['status'=>0,'data'=>array(),'message' => 'لا يوجد بيانات'], 400);
   }
}
