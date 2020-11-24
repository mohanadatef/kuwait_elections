<?php

namespace App\Http\Controllers\Api\Setting;

use App\Http\Controllers\Controller;
use App\Http\Resources\Setting\ContactUsResource;
use App\Models\Setting\Contact_Us;

class ContactUsController extends Controller
{
    public function index()
    {
        return response(['status'=>1,'data'=>['contact_us' => new ContactUsResource(Contact_Us::find(1))],'message'=>'بيانات تواصل مع الشركه'], 200);
    }
}
?>