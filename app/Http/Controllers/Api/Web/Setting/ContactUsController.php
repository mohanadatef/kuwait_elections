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
        $datas = Contact_Us::find(1);
        if(Auth::user() == true)
        {
            $this->logRepository->Create_Data(''.Auth::user()->id.'', 'عرض', 'عرض اتصل بنا  Api' );
        }
        return response([
            'data' => array(new ContactUsResource($datas)),
        ], 200);

    }


}

?>