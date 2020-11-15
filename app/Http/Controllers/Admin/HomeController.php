<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\ACL\LogRepository;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    private $logRepository;
    public function __construct(LogRepository $LogRepository)
    {
        $this->middleware('auth');
        $this->middleware('admin');
        $this->logRepository = $LogRepository;
    }

    public function index()
    {
        $this->logRepository->Create_Data(''.Auth::user()->id.'','عرض','فتح الصفحه الرئيسيه لوحه التحكم');
            return view('admin.admin');
    }
}

?>