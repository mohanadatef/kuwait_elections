<?php

namespace App\Http\Controllers\Api\Setting;

use App\Http\Controllers\Controller;
use App\Http\Resources\Setting\AboutUsResource;
use App\Http\Resources\Election\NomineeResource;
use App\Models\Setting\About_Us;
use App\User;
use Illuminate\Support\Facades\DB;

class AboutUsController extends Controller
{
    public function index()
    {
        $nominee = DB::table('users')
            ->join('role_user', 'role_user.user_id', '=', 'users.id')
            ->where('role_user.role_id', 4)
            ->where('users.status', 1)
            ->pluck('users.id','users.id');
        $nominee = User::wherein('id',$nominee)->get();
        if($nominee)
        {
        $nominee=NomineeResource::collection($nominee);
        }
        else
        {
        $nominee=array();
        }
        return response(['status'=>1, 'data'=>[
            'about_us' =>new AboutUsResource(About_Us::find(1))
            ,'nominee'=>$nominee],
            'message'=>'بيانات صفحه عن الشركه'], 200);
    }
}
?>