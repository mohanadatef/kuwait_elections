<?php

namespace App\Http\Controllers\Api\Core_Data;

use App\Http\Controllers\Controller;
use App\Http\Resources\Core_Data\CircleResource;
use App\Models\Core_Data\Circle;
use App\Repositories\ACL\LogRepository;
use Illuminate\Support\Facades\Auth;

class CircleController extends Controller
{
    private $logRepository;

    public function __construct(LogRepository $LogRepository)
    {
        $this->logRepository = $LogRepository;
    }
    public function index()
    {
        $data = Circle::where('status', '=', 1)->orderby('order','asc')->get();
        if(Auth::user() == true)
        {
            $this->logRepository->Create_Data(''.Auth::user()->id.'', 'عرض', 'عرض قائمه الدوائر  Api' );
        }
        return response(['data'=> CircleResource::collection($data),'status'=>200]);
    }

}

?>