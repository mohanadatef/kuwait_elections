<?php

namespace App\Http\Controllers\Api\Core_Data;

use App\Http\Controllers\Controller;
use App\Http\Resources\Core_Data\CircleResource;
use App\Models\Core_Data\Circle;

class CircleController extends Controller
{
    public function index()
    {
        $data = Circle::where('status', 1)->orderby('order','asc')->get();
        return response(['status'=>1,'data'=>['circle'=> CircleResource::collection($data)],'message'=>'قائمه الدوائر'],200);
    }

}

?>