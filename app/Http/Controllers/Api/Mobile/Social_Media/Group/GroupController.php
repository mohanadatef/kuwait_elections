<?php

namespace App\Http\Controllers\Api\Mobile\Social_Media\Group;

use App\Http\Resources\Mobile\Social_Media\Group\GroupResource;
use App\Models\Social_Media\Group;
use App\Repositories\ACL\LogRepository;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class GroupController extends Controller
{
    private $logRepository;

    public function __construct(LogRepository $LogRepository)
    {
        $this->middleware('auth:api');
        $this->logRepository = $LogRepository;
    }

    public function show_all_group()
    {
        $group = Group::all();
        $this->logRepository->Create_Data('' . Auth::user()->id . '', 'عرض', 'عرض كل الجروب');
        return response(['status'=>1, 'group' => GroupResource::collection($group)], 200);
    }
}
