<?php

namespace App\Http\Controllers\Api\Web\Setting;

use App\Http\Controllers\Controller;
use App\Http\Resources\Web\Setting\PrivacyResource;
use App\Models\Setting\Privacy;
use App\Repositories\ACL\LogRepository;
use Illuminate\Support\Facades\Auth;

class PrivacyController extends Controller
{
    private $logRepository;

    public function __construct(LogRepository $LogRepository)
    {
        $this->logRepository = $LogRepository;
    }
    public function index()
    {
        $data = Privacy::find(1);
        $data =array(new PrivacyResource($data));
        if(Auth::user() == true)
        {
            $this->logRepository->Create_Data(''.Auth::user()->id.'', 'عرض', 'عرض عن الشروط و الاحكام' );
        }
        return response(['status'=>1,'privacy'=>$data], 200);
    }
}
?>