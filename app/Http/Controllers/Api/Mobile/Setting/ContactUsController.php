<?php

namespace App\Http\Controllers\Api\Mobile\Setting;

use App\Http\Controllers\Controller;
use App\Http\Resources\Mobile\Setting\ContactUsResource;
use App\Models\Setting\Contact_Us;

class ContactUsController extends Controller
{
    public function index()
    {
        $data = Contact_Us::find(1);
        return response(['status'=>1,'data'=>['contact_us' => new ContactUsResource($data)],'message'=>'بيانات تواصل مع الشركه'], 200);
    }
}
?>