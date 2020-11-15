<?php

namespace App\Http\Controllers\Admin\Social_Media;


use App\Http\Requests\Admin\Social_Media\Post\StatusEditRequest;
use App\Repositories\ACL\LogRepository;
use App\Repositories\Social_Media\PostRepository;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    private $postRepository;
    private $logRepository;
    public function __construct(PostRepository $postRepository,LogRepository $LogRepository)
    {
        $this->postRepository = $postRepository;
        $this->logRepository = $LogRepository;
    }

    public function index()
    {
        $datas = $this->postRepository->Get_All_Datas();
        $this->logRepository->Create_Data(''.Auth::user()->id.'','عرض','فتح قائمه المنشورات فى لوحه التحكم');
        return view('admin.social_media.post.index',compact('datas'));
    }

    public function change_status($id)
    {
        $this->postRepository->Update_Status_One_Data($id);
        $this->logRepository->Create_Data(''.Auth::user()->id.'','تغير حاله','تغير حاله المنشور فى لوحه التحكم');
        return redirect()->back()->with('message', 'تغير حاله المنشور بنجاح');
    }

    public function change_many_status(StatusEditRequest $request)
    {
        $this->postRepository->Update_Status_Datas($request);
        $this->logRepository->Create_Data(''.Auth::user()->id.'','تغير حاله','تغير حاله المنشورات فى لوحه التحكم');
        return redirect()->back()->with('message', 'تم تغير حاله المنشورات بنجاح');
    }


}
