<?php

namespace App\Http\Controllers\Api\Setting;

use App\Http\Controllers\Controller;
use App\Http\Resources\Setting\PrivacyResource;
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
        $datas = Privacy::find(1);
        if(Auth::user() == true)
        {
            $this->logRepository->Create_Data(''.Auth::user()->id.'', 'عرض', 'عرض عن الشروط و الاحكام  Api' );
        }
            return response([
                'data' =>array(new PrivacyResource($datas))
            ], 200);

    }
}
?>