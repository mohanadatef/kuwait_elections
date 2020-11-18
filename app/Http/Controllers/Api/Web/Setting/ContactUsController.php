<?php

namespace App\Http\Controllers\Api\Web\Setting;

use App\Http\Controllers\Controller;
use App\Http\Resources\Web\Setting\ContactUsResource;
use App\Models\Setting\Contact_Us;
use App\Repositories\ACL\LogRepository;
use Illuminate\Support\Facades\Auth;

class ContactUsController extends Controller
{
    private $logRepository;

    public function __construct(LogRepository $LogRepository)
    {
        $this->logRepository = $LogRepository;
    }
    public function index()
    {
        $data = Contact_Us::find(1);
        $data = array(new ContactUsResource($data));
        if(Auth::user() == true)
        {
            $this->logRepository->Create_Data(''.Auth::user()->id.'', 'عرض', 'عرض اتصل بنا' );
        }
        return response(['status'=>1,'contact_us' => $data], 200);
    }
}

?>