<?php

namespace App\Http\Controllers\Admin\Social_Media;


use App\Http\Requests\Admin\Social_Media\Commit\StatusEditRequest;
use App\Repositories\ACL\LogRepository;
use App\Repositories\Social_Media\CommitRepository;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class CommitController extends Controller
{
    private $commitRepository;
    private $logRepository;
    public function __construct(CommitRepository $commitRepository,LogRepository $LogRepository)
    {
        $this->commitRepository = $commitRepository;
        $this->logRepository = $LogRepository;
    }

    public function index()
    {
        $datas = $this->commitRepository->Get_All_Datas();
        $this->logRepository->Create_Data(''.Auth::user()->id.'','عرض','فتح قائمه التعليقات فى لوحه التحكم');
        return view('admin.social_media.commit.index',compact('datas'));
    }

    public function Post_index($id)
    {
        $datas = $this->commitRepository->Get_All_Datas_Post($id);
        $this->logRepository->Create_Data(''.Auth::user()->id.'','عرض','فتح قائمه التعليقات فى لوحه التحكم');
        return view('admin.social_media.commit.index',compact('datas'));
    }

    public function change_status($id)
    {
        $this->commitRepository->Update_Status_One_Data($id);
        $this->logRepository->Create_Data(''.Auth::user()->id.'','تغير حاله','تغير حاله التعليق فى لوحه التحكم');
        return redirect()->back()->with('message', 'تغير حاله التعليق بنجاح');
    }

    public function change_many_status(StatusEditRequest $request)
    {
        $this->commitRepository->Update_Status_Datas($request);
        $this->logRepository->Create_Data(''.Auth::user()->id.'','تغير حاله','تغير حاله التعليقات فى لوحه التحكم');
        return redirect()->back()->with('message', 'تم تغير حاله التعليقات بنجاح');
    }
    
}
