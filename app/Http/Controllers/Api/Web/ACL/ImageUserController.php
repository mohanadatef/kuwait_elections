<?php

namespace App\Http\Controllers\Api\Web\ACL;

use App\Http\Resources\Web\Image\ProfileImageResource;
use App\Models\Image;
use App\Repositories\ACL\LogRepository;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class ImageUserController extends Controller
{
    private $logRepository;

    public function __construct(LogRepository $LogRepository)
    {
        $this->middleware('auth:api', ['except' => ['index']]);
        $this->logRepository = $LogRepository;
    }

    public function index(Request $request)
    {
        $user = User::find($request->user_id);
        if (!$user) {
            return response(['status' => 0, 'data' => array(), 'message' => 'خطا فى تحميل البيانات المستخدم'], 400);
        }
        $image = Image::where('category', 'profile')->where('category_id', $user->id)->get();
        if ($request->status_auth == 1) {

            $this->logRepository->Create_Data(''.Auth::user()->id.'', 'عرض', 'عرض كل الصور الشخصيه لمستخدم');
        }
        if ($image) {
            return response(['status'=>1,'image' =>ProfileImageResource::collection($image)], 200);
        }
        return response(['status'=>1,'data'=>array()], 200);
    }

    public function update(Request $request)
    {
        $user = User::find($request->user_id);
        if (!$user) {
            return response(['status' => 0, 'data' => array(), 'message' => 'خطا فى تحميل البيانات المستخدم'], 400);
        }
        $validate = \Validator::make($request->all(), [
            'image_profile' => 'image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);
        if ($validate->fails()) {
            return response(['status'=>0,'error' => $validate->errors(), 'message' => 'خطا فى ادخال البيانات'], 422);
        }
        $user_image = Image::find($request->image_id);
        if ($user_image) {
            $user_image->status = 0;
            $user_image->save();
            $profile_image = new Image();
            $profile_image->category_id = $user->id;
            $profile_image->category = 'profile';
            $profile_image->status = 1;
            $folderPath=public_path('images/user/profile/');
            $image_parts = explode(";base64,", $request->image_profile);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);
            $file =  $folderPath. time().uniqid().'.'.$image_type;
            file_put_contents($file, $image_base64);
            $profile_image->image = time().uniqid().'.'.$image_type;
            $profile_image->save();
            $this->logRepository->Create_Data(''.$user->id.'','تعديل', 'تعديل صور الشخصيه لمستخدم');
            return response(['status'=>1,'image'=>new ProfileImageResource($profile_image), 'message' => 'تم تغير الصوره الشخصيه'], 200);
        }
        return response(['status'=>0,'data'=>array(), 'message' => 'خطا فى ادخال رقم الصوره الشخصيه'], 400);
    }

    public function delete(Request $request)
    {
        $user = User::find($request->user_id);
        if (!$user) {
            return response(['status' => 0, 'data' => array(), 'message' => 'خطا فى تحميل البيانات المستخدم'], 400);
        }
        $user_image = Image::find($request->image_id);
        if ($user_image) {
            $user_image->delete();
            $this->logRepository->Create_Data(''.$user->id.'', 'مسح', 'مسح صور الشخصيه لمستخدم');
            return response(['status'=>1,'data'=>array(), 'message' => 'تم مسح الصوره الشخصيه بنجاح'], 200);
        }
        return response(['status'=>0,'data'=>array(), 'message' => 'خطا فى ادخال رقم الصوره الشخصيه'], 400);
    }
}
