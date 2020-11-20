<?php

namespace App\Http\Controllers\Api\Mobile\Core_Data;

use App\Http\Controllers\Controller;
use App\Http\Resources\Mobile\Core_Data\AreaResource;
use App\Models\Core_Data\Area;


class AreaController extends Controller
{
    public function index()
    {
        $data = Area::where('status', 1)->orderby('order', 'asc')->get();
        return response(['status'=>1,'data'=>['area' => AreaResource::collection($data)],'message'=>'قائمه المناطق'], 200);
    }
}

?>