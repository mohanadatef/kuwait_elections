<?php

namespace App\Http\Controllers\Admin\Social_Media;

use App\Http\Requests\Admin\Social_Media\Group\CreateRequest;
use App\Http\Requests\Admin\Social_Media\Group\EditRequest;
use App\Repositories\ACL\LogRepository;
use App\Repositories\Social_Media\GroupRepository;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class GroupController extends Controller
{
    private $groupRepository;
    private $logRepository;
    public function __construct(GroupRepository $groupRepository,LogRepository $LogRepository)
    {
        $this->groupRepository = $groupRepository;
        $this->logRepository = $LogRepository;
    }

    public function index()
    {
        $datas = $this->groupRepository->Get_All_Datas();
        $this->logRepository->Create_Data(''.Auth::user()->id.'','عرض','فتح قائمه الجروب');
        return view('admin.social_media.group.index',compact('datas'));
    }

    public function create()
    {
        $this->logRepository->Create_Data(''.Auth::user()->id.'','عرض','فتح صفحه اضافه جروب');
        return view('admin.social_media.group.create');
    }

    public function store(CreateRequest $request)
    {
        $this->groupRepository->Create_Data($request);
        $this->logRepository->Create_Data(''.Auth::user()->id.'','تسجيل','تم اضافه جروب جديد');
        return redirect('/admin/group/index')->with('message', 'تم التسجيل  الجروب بنجاح');
    }

    public function edit($id)
    {
        $data = $this->groupRepository->Get_One_Data($id);
        $this->logRepository->Create_Data(''.Auth::user()->id.'','عرض','فتح صفحه الجروب للتعديل');
        return view('admin.social_media.group.edit',compact('data'));

    }

    public function update(EditRequest $request, $id)
    {
        $this->groupRepository->Update_Data($request, $id);
        $this->logRepository->Create_Data(''.Auth::user()->id.'','تعديل','تم التعديل بيانات الجروب');
        return redirect('/admin/group/index')->with('message', 'تم التعديل بنجاح');
    }
}
