<?php

namespace App\Http\Controllers\Api\Setting;

use App\Http\Controllers\Controller;
use App\Http\Resources\Setting\PrivacyResource;
use App\Models\Setting\Privacy;

class PrivacyController extends Controller
{
    public function index()
    {
        return response(['status'=>1,'data'=>['privacy' => new PrivacyResource(Privacy::find(1))],'message'=>'سياسه الشركه'], 200);
    }
}
?>