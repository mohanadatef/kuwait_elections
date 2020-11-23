<?php

namespace App\Http\Controllers\Api\Setting;

use App\Http\Controllers\Controller;
use App\Http\Resources\Mobile\Setting\AboutUsResource;
use App\Http\Resources\Mobile\Election\NomineeResource;
use App\Models\Setting\About_Us;
use App\User;
use Illuminate\Support\Facades\DB;

class AboutUsController extends Controller
{
    public function index()
    {
        $data = About_Us::find(1);
        $user_role = DB::table("role_user")->where('role_id', 4)->pluck("user_id", "id");
        $nominee = User::wherein('id',$user_role)->where('status', 1)->get();
        if($nominee)
        {
        $nominee=NomineeResource::collection($nominee);
        }
        else
        {
        $nominee=array();
        }
        return response(['status'=>1, 'data'=>[
            'about_us' =>new AboutUsResource($data)
            ,'nominee'=>$nominee],
            'message'=>'بيانات صفحه عن الشركه'], 200);
    }
}
?>