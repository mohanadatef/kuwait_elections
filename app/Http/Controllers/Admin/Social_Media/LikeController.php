<?php

namespace App\Http\Controllers\Admin\Social_Media;


use App\Http\Requests\Admin\Social_Media\Commit\StatusEditRequest;
use App\Repositories\ACL\LogRepository;
use App\Repositories\Social_Media\LikeRepository;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{

    private $logRepository;
    private $likeRepository;
    public function __construct(LogRepository $LogRepository,LikeRepository $LikeRepository)
    {

        $this->logRepository = $LogRepository;
        $this->likeRepository = $LikeRepository;
    }
    public function index()
    {
        $datas = $this->likeRepository->Get_All_Datas();
        $this->logRepository->Create_Data(''.Auth::user()->id.'','عرض','فتح قائمه اعجابات  فى لوحه التحكم');
        return view('admin.social_media.like.like_index',compact('datas'));
    }
    public function Like_index($id,$category)
    {
        $datas = $this->likeRepository->Get_All_Datas_Like($id,$category);
        $this->logRepository->Create_Data(''.Auth::user()->id.'','عرض','فتح قائمه اعجابات  فى لوحه التحكم');
        return view('admin.social_media.like.like_index',compact('datas'));
    }

}
