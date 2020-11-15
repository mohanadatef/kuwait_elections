<?php

namespace App\Http\Controllers\Api\Setting;

use App\Http\Controllers\Controller;
use App\Http\Resources\Setting\AboutUsResource;
use App\Http\Resources\ACL\NomineeResource;
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
        $datas = About_Us::find(1);
        $user_role = DB::table("role_user")->where('role_id', 4)->pluck("user_id", "id");
        $user = User::with(['image' => function ($query) {
            $user_role = DB::table("role_user")->where('role_id', 4)->pluck("user_id", "id");
            $query->wherein('category_id',$user_role)->where('status', 1)->where('category','profile');
        }])->wherein('id',$user_role)->where('status', 1)->get();
        if(Auth::user() == true)
        {
            $this->logRepository->Create_Data(''.Auth::user()->id.'', 'عرض', 'عرض عن الشركه  Api' );
        }
        if(count($user) != 0)
        {
            return response([
                'status'=>1,
                'data' =>array(new AboutUsResource($datas)),
                'nominee' => NomineeResource::collection($user),
            ], 200);
        }
        return response([
            'status'=>0,
            'data' =>array(new AboutUsResource($datas)),
        ], 200);
    }
}
?>