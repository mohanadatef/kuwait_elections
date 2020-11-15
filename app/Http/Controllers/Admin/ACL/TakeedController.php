<?php

namespace App\Http\Controllers\Admin\ACL;

use App\Imports\TakeedImport;
use App\Models\ACL\Takeed;
use App\Repositories\ACL\LogRepository;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class TakeedController extends Controller
{
    private $logRepository;
    public function __construct(LogRepository $LogRepository)
    {
        $this->logRepository = $LogRepository;
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function index()
    {
        $this->logRepository->Create_Data(''.Auth::user()->id.'','عرض','فتح قائمه الناخبين على لوحه التحكم');
        $datas  = Takeed::paginate(200);
        return view('admin.import.takeed.index',compact('datas'));
    }

    public function form()
    {
        $this->logRepository->Create_Data(''.Auth::user()->id.'','عرض','فتح قائمه الرفع الناخبين على لوحه التحكم');
        return view('admin.import.takeed.form');
    }

    public function import(Request $request)
    {
        ini_set('max_execution_time', 12000);
        ini_set('post_max_size', 120000);
        ini_set('upload_max_filesize', 10000);
        Excel::import(new TakeedImport(), request()->file('file'));
        $this->logRepository->Create_Data(''.Auth::user()->id.'','رفع','رفع الناخبين على لوحه التحكم');
        return redirect('/admin/takeed/index')->with('message', 'تم الاضافه بنجاح');
    }

}
