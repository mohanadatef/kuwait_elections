<?php

namespace App\Http\Controllers\Api\Mobile\Setting;

use App\Http\Controllers\Controller;
use App\Http\Resources\Mobile\Setting\PrivacyResource;
use App\Models\Setting\Privacy;

class PrivacyController extends Controller
{
    public function index()
    {
        $data = Privacy::find(1);
        return response(['status'=>1,'data'=>['privacy' => new PrivacyResource($data)],'message'=>'سياسه الشركه'], 200);
    }
}
?>