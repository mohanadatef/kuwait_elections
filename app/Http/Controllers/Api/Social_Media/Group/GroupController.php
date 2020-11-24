<?php

namespace App\Http\Controllers\Api\Social_Media\Group;

use App\Http\Resources\Social_Media\Group\GroupResource;
use App\Models\Social_Media\Group;
use App\Repositories\ACL\LogRepository;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class GroupController extends Controller
{
    private $logRepository;

    public function __construct(LogRepository $LogRepository)
    {
        $this->logRepository = $LogRepository;
    }

    public function show_all_group(Request $request)
    {

        $group = Group::with('image')->get();
        if($request->status_auth ==1)
        {
            $user = User::find($request->user_id);
            if (!$user) {
                return response(['status' => 0, 'data' => array(), 'message' => 'خطا فى تحميل البيانات المستخدم'], 400);
            }
            if ($user->status == 0) {
                return response(['status' => 0, 'data' => array(), 'message' => 'برجاء الاتصال بخدمه العملاء'], 400);
            }
        $this->logRepository->Create_Data('' . $request->user_id . '', 'عرض', 'عرض كل الجروب');
        }
        return response(['status'=>1,'data'=>['group' => GroupResource::collection($group)] ,'message'=>'قائمه الجروبات'], 200);
    }
}
