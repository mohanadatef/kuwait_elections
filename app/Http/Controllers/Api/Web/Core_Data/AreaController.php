<?php

namespace App\Http\Controllers\Api\Web\Core_Data;

use App\Http\Controllers\Controller;
use App\Http\Resources\Web\Core_Data\AreaResource;
use App\Models\Core_Data\Area;
use App\Repositories\ACL\LogRepository;
use Illuminate\Support\Facades\Auth;


class AreaController extends Controller
{
    private $logRepository;

    public function __construct(LogRepository $LogRepository)
    {
        $this->logRepository = $LogRepository;
    }

    public function index()
    {
        $data = Area::where('status', '=', 1)->orderby('order', 'asc')->get();
        if (Auth::user() == true) {
            $this->logRepository->Create_Data(''.Auth::user()->id . '', 'عرض', 'عرض قائمه المناطق');
        }
        return response(['status'=>1,'area' => AreaResource::collection($data)], 200);
    }
}

?>