<?php

namespace App\Http\Controllers\Api\Mobile\Setting;

use App\Http\Controllers\Controller;
use App\Models\Setting\Call_Us;
use App\Repositories\ACL\LogRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CallUsController extends Controller
{
    private $logRepository;

    public function __construct(LogRepository $LogRepository)
    {
        $this->logRepository = $LogRepository;
    }
    public function store(Request $request)
    {
        $validate = \Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'message' => 'required|string',
            'mobile' => 'required|string',
        ]);
        if ($validate->fails()) {
            return response(['status' => 0,'message' => $validate->errors()], 422);
        }
        $call_us = new Call_Us();
        $call_us->create($request->all());
        if(Auth::user() == true)
        {
            $this->logRepository->Create_Data(''.Auth::user()->id.'', 'ارسال', 'اتواصل مع الدعم الفني' );
        }
        return response(['status' => 1], 200);
    }
}

?>