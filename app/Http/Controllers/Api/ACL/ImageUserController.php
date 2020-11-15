<?php

namespace App\Http\Controllers\Api\ACL;

use App\Http\Resources\Image\ProfileImageResource;
use App\Models\Image;
use App\Repositories\ACL\LogRepository;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ImageUserController extends Controller
{
    private $logRepository;

    public function __construct(LogRepository $LogRepository)
    {
        $this->middleware('auth:api');
        $this->logRepository = $LogRepository;
    }

    public function index(Request $request)
    {
        $image = Image::where('category', 'profile')->where('category_id', $request->id)->get();
        $this->logRepository->Create_Data($request->id, 'عرض', 'عرض كل الصور الشخصيه لمستخدم عن طريق Api');
        if ($image) {
            return response(['message' => 'جميع الصور الشخصيه',
                'data' => ProfileImageResource::collection($image)], 200);
        }
        return response([
            'message' => 'خطا فى تحميل البيانات'
        ], 400);
    }

    public function store(Request $request)
    {
        $validate = \Validator::make($request->all(), [
            'image_profile' => 'image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);
        if ($validate->fails()) {
            return response(['message' => $validate->errors()], 422);
        }
        $imageName = $request->image_profile->getClientOriginalname() . '-' . time() . '.' . Request()->image_profile->getClientOriginalExtension();
        Request()->image_profile->move(public_path('images/user/profile'), $imageName);
        $profile_image = new Image();
        $profile_image->category_id = $request->id;
        $profile_image->category = 'profile';
        $profile_image->status = 1;
        $profile_image->image = $imageName;
        $profile_image->save();
        $this->logRepository->Create_Data($request->id, 'اضافه', 'اضافه صور الشخصيه لمستخدم عن طريق Api');
        if ($profile_image) {
            return response(['message' => 'تم اضاقه الصور الشخصيه'], 200);
        }
        return response([
            'message' => 'خطا فى تحميل البيانات'
        ], 400);
    }


    public function update(Request $request)
    {

        $validate = \Validator::make($request->all(), [
            'image_profile' => 'image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);
        if ($validate->fails()) {
            return response(['message' => $validate->errors()], 422);
        }
        $user_image = Image::find($request->image_id);
        if ($user_image) {
            $user_image->status = 0;
            $user_image->save();
            $imageName = $request->image_profile->getClientOriginalname() . '-' . time() . '.' . Request()->image_profile->getClientOriginalExtension();
            Request()->image_profile->move(public_path('images/user/profile'), $imageName);
            $profile_image = new Image();
            $profile_image->category_id = $request->id;
            $profile_image->category = 'profile';
            $profile_image->status = 1;
            $profile_image->image = $imageName;
            $profile_image->save();
            $this->logRepository->Create_Data($request->id, 'تعديل', 'تعديل صور الشخصيه لمستخدم عن طريق Api');
            return response(['message' => 'تم نعديل الصور الشخصيه'], 200);
        }
        return response([
            'message' => 'خطا فى تحميل البيانات'
        ], 400);
    }

    public function delete(Request $request)
    {
        $user_image = Image::find($request->image_profile);
        if ($user_image) {
            $user_image->delete();
            $this->logRepository->Create_Data($request->id, 'مسح', 'مسح صور الشخصيه لمستخدم عن طريق Api');
            return response(['message' => 'تم مسح الصور الشخصيه'], 200);
        }
        return response([
            'message' => 'خطا فى تحميل البيانات'
        ], 400);
    }

}
