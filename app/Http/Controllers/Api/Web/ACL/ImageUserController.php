<?php

namespace App\Http\Controllers\Api\Web\ACL;

use App\Http\Resources\Web\Image\ProfileImageResource;
use App\Models\Image;
use App\Repositories\ACL\LogRepository;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class ImageUserController extends Controller
{
    private $logRepository;

    public function __construct(LogRepository $LogRepository)
    {
        $this->middleware('auth:api');
        $this->logRepository = $LogRepository;
    }

    public function index()
    {
        $image = Image::where('category', 'profile')->where('category_id', Auth::User()->id)->get();
        $this->logRepository->Create_Data(''.Auth::User()->id.'', 'عرض', 'عرض كل الصور الشخصيه لمستخدم');
        if ($image) {
                $image = ProfileImageResource::collection($image);
        }
        return response(['status'=>1,'image' =>$image], 200);
    }

    public function update(Request $request)
    {
        $validate = \Validator::make($request->all(), [
            'image_profile' => 'image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);
        if ($validate->fails()) {
            return response(['status'=>0,'message' => $validate->errors()], 422);
        }
        $user_image = Image::find($request->image_id);
        if ($user_image) {
            $user_image->status = 0;
            $user_image->save();
            $profile_image = new Image();
            $profile_image->category_id = Auth::User()->id;
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
            $this->logRepository->Create_Data(''.Auth::User()->id.'','تعديل', 'تعديل صور الشخصيه لمستخدم');
            return response(['status'=>1,'image'=>array(new ProfileImageResource($profile_image))], 200);
        }
        return response(['status'=>0], 400);
    }

    public function delete(Request $request)
    {
        $user_image = Image::find($request->image_id);
        if ($user_image) {
            $user_image->delete();
            $profile_image = new Image();
            $profile_image->category_id = Auth::User()->id;
            $profile_image->category = 'profile';
            $profile_image->status = 1;
            $file_image_profile = 'data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/2wCEAAkGBxQHBg0QEBIPEA4QEBEQFRgQDRcQExAaFhUWFiATFRUYHSggGB4lGxgWITEhJSkrLi4uFx8zODMsNygtLisBCgoKDQ0NFQ0NDy0ZFRkrLSs3Ky0tLisrKzctNy0rNystLS0rKysrKy0rLSsrKysrKysrKysrKysrKysrKysrK//AABEIAOEA4QMBIgACEQEDEQH/xAAbAAEAAwEBAQEAAAAAAAAAAAAAAwQFAgYBB//EADQQAQACAAMFBQcCBwEAAAAAAAABAgMEEQUSITFhQVFxgbETIlKRocHRFDQyQnKCkuHxJP/EABYBAQEBAAAAAAAAAAAAAAAAAAABAv/EABYRAQEBAAAAAAAAAAAAAAAAAAABEf/aAAwDAQACEQMRAD8A/TAGkAAAAAAAAAAAAAAAAAAAAAAAAAAAAABAAAAAAAHVKTiW0iJmegOX2I1nSOM9F2mzL25zWv1lo5fLVy9eEce2Z5yauMzC2de8cdKx15/KE9dld9p8qtITVZ07Kj4p/wAUd9l2jlaJ8Y0aoaMHFyl8LnWdO+OMIHpVTNZGuNEzHu2747fGDUxijvFwpwbzW0aT69YcKgAAAAAAAAAAAAAAAAAA3Mjl/YYMfFPGfwx8vTfzFI77Q9ClWACKAAAAAAgzmXjMYWn80cpYUxuzMTzjg9IyNq4W5jxaOVo+sLEqiAqAAAAAAAAAAAAAAAALOz41zlPP0luMPZv7yvn6S3EqwARQAAAAABS2rTeyuvwzE/b7rqttGf8Ax316esAwwGmQAAAAAAAAAAAAAAAFrZ37ynn6S22FkJ0zlPH7S3UqwARQAAAAABibStM5u0azpGmnHlwhtsHPTrnL+P2WCABWQAAAAAAAAAAAAAAAE+SiZzNJiJmItHZybyHJ03MtSI7on5pkrQAgAAAAAAMDNxP6m+sTGtp5xz4t9U2nTeylp7Y0mPmsGKArIAAAAAAAAAAAAAAADc2fffylOnD5LLN2PicL1/uj0/DSZaAAAAAAAAFLa193LafFMR8uK6ydr4m9jVr8MeqwUAFZAAAAAAAAABQAAAAAEmXxpwMWLR/1t5XH/UYMW005xprrowGnsfE4Xr/d9vwlGkAigAAAAAIM3mP02Frprx056MPExJxMSbTzmdWhti/GlfGft+Wa1EAAAAAAAAAAABAAAAAABNlMb2GPW3ZynwlCA9LE6wKWysSb5eYn+WdIXWWgAAAAFbaN5plLadI+YMrOYvtszaezlHhCAGkABAAAAAAAAAAAAAAAAAAGxsmNMtPW0+kLqts+m5k6ddZ+c6rLLQAAAArbRjXJ38p+sLKPMU38C8d9Zj6A88A0yAAAAAAAAAAAAAAAAAAOqV37xEc5nQpSb20iJmejVyGS9jO9b+L0FXaxu1iO6NH0GVAAAAAAefzWH7LMWjrrHhKJt57KfqK6xwtHLr0lj4mHOFbS0TEtRHAAgAAAAAAAAAAAAPsRvTpHGei9l9mzfjf3Y7o5/wChVGtd+2kRMz0X8vsybcbzpHdHP5tHBwK4NdKxEes+aRNMR4WDXBrpWIhICKAAAAAAAAOcTDjErpaImOroBmZjZnbSfKftLPxMOcO2lomJ6vRuMTDjFrpaImOq6jzo0cxszTjSdek/aVC9JpbSYmJ6qOQBAAAAAH2OMg+LeVyNsbjPu1+s+ELeSyG5EWvxt2R2R+ZX01cRYGXrgR7sce+eMz5pQRQAAAAAAAAAAAAAAABHjYNcaulo19Y80gDIzOzpw+Nfej6x+VF6VTzmRjHiZrwv9J8VlTGMOrVmlpieEw5VAABpbKy2vvz4V/LOrG9aIjnM6PRYVPZ4cVjlEaFWOgGVAAAAAAAAAAAAAAAAAAAAAAUdqZffw9+P4q8+sMh6WY1h57Hw/ZY1q90rEqMBUTZX9zh/1R6t8EqwARQAAAAAAAAAAAAAAAAAAAAABibS/eW8vSAWJVUBUf/Z';
            $folderPath=public_path('images/user/profile/');
            $image_parts = explode(";base64,", $file_image_profile);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);
            $file =  $folderPath. time().uniqid().'.'.$image_type;
            file_put_contents($file, $image_base64);
            $profile_image->image = time().uniqid().'.'.$image_type;
            $this->logRepository->Create_Data(''.Auth::User()->id.'', 'مسح', 'مسح صور الشخصيه لمستخدم');
            return response(['status'=>1], 200);
        }
        return response(['status'=>0], 400);
    }

}
