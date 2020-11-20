<?php

namespace App\Http\Controllers\Api\Mobile\Setting;

use App\Http\Controllers\Controller;
use App\Models\Setting\Call_Us;
use Illuminate\Http\Request;

class CallUsController extends Controller
{
    public function store(Request $request)
    {
        $validate = \Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'message' => 'required|string',
            'mobile' => 'required|string',
        ]);
        if ($validate->fails()) {
            return response(['status' => 0,'data'=>['error'=>$validate->errors()],'message' =>'خطا فى المدخلات' ], 422);
        }
        $call_us = new Call_Us();
        $call_us->create($request->all());
        return response(['status' => 1,'data'=>array(),'message'=>'تم تسجيل الطلب بنجاح'], 200);
    }
}

?>