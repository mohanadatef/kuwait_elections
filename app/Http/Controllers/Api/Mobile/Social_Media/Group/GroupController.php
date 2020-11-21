<?php

namespace App\Http\Controllers\Api\Mobile\Social_Media\Group;

use App\Http\Resources\Mobile\Social_Media\Group\GroupResource;
use App\Models\Social_Media\Group;
use App\Repositories\ACL\LogRepository;
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
        $this->logRepository->Create_Data('' . $request->user_id . '', 'عرض', 'عرض كل الجروب');
        }
        return response(['status'=>1,'data'=>['group' => GroupResource::collection($group)] ,'message'=>'قائمه الجروبات'], 200);
    }
}
