<?php

namespace App\Http\Controllers\Api\Mobile\Setting;

use App\Http\Controllers\Controller;
use App\Http\Resources\Mobile\Setting\AboutUsResource;
use App\Http\Resources\Mobile\ACL\NomineeResource;
use App\Models\Setting\About_Us;
use App\Repositories\ACL\LogRepository;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AboutUsController extends Controller
{
    private $logRepository;

    public function __construct(LogRepository $LogRepository)
    {
        $this->logRepository = $LogRepository;
    }

    public function index()
    {
        $data = About_Us::find(1);
        $data = array(new AboutUsResource($data));
        $user_role = DB::table("role_user")->where('role_id', 4)->pluck("user_id", "id");
        $nominee = User::wherein('id',$user_role)->where('status', 1)->get();
        $nominee=NomineeResource::collection($nominee);
        if(Auth::user() == true)
        {
            $this->logRepository->Create_Data(''.Auth::user()->id.'', 'عرض', 'عرض عن الشركه' );
        }
        return response(['status'=>1,'about_us' =>$data,'nominee'=>$nominee], 200);
    }
}
?>