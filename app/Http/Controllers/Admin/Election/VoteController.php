<?php

namespace App\Http\Controllers\Admin\Election;

use App\Http\Requests\Admin\Election\Vote\CreateRequest;
use App\Http\Requests\Admin\Election\Vote\EditRequest;
use App\Http\Requests\Admin\Election\Vote\StatusEditRequest;
use App\Repositories\ACL\LogRepository;
use App\Repositories\ACL\UserRepository;
use App\Repositories\Election\VoteRepository;
use App\Repositories\Core_Data\CircleRepository;
use App\Traits\CoreDataa;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class VoteController extends Controller
{
    use CoreDataa;

    public function index()
    {
        $datas = $this->voteRepository->Get_All_Datas();
        $this->logRepository->Create_Data(''.Auth::user()->id.'','عرض','فتح قائمه الاستبيان');
        return view('admin.election.vote.index',compact('datas'));
    }

    public function create()
    {
        $circle = $this->circleRepository->Get_List_Data();
        $this->logRepository->Create_Data(''.Auth::user()->id.'','عرض','فتح صفحه اضافه الاستبيان');
        return view('admin.election.vote.create',compact('circle'));
    }

    public function store(CreateRequest $request)
    {
        $this->voteRepository->Create_Data($request);
        $this->logRepository->Create_Data(''.Auth::user()->id.'','تسجيل','تم اضافه الاستبيان جديد ');
        return redirect('/admin/vote/index')->with('message', 'تم التسجيل  الاستبيان بنجاح');
    }

    public function edit($id)
    {
        $data = $this->voteRepository->Get_One_Data($id);
        $nominee = $this->userRepository->Get_List_Nominee_Circle($data->circle_id);
        $this->logRepository->Create_Data(''.Auth::user()->id.'','عرض','فتح صفحه الاستبيان للتعديل');
        return view('admin.election.vote.edit',compact('data','nominee'));

    }

    public function update(EditRequest $request, $id)
    {
        $this->voteRepository->Update_Data($request, $id);
        $this->logRepository->Create_Data(''.Auth::user()->id.'','تعديل','تعديل بيانات الاستبيان');
        return redirect('/admin/vote/index')->with('message', 'تم التعديل بنجاح');
    }


    public function change_status($id)
    {
        $this->voteRepository->Update_Status_One_Data($id);
        $this->logRepository->Create_Data(''.Auth::user()->id.'','تغير الحاله','تغير حاله الاستبيان');
        return redirect()->back()->with('message', 'تم تغير حاله الاستبيان بنجاح');
    }

    public function change_many_status(StatusEditRequest $request)
    {
        $this->voteRepository->Update_Status_Datas($request);
        $this->logRepository->Create_Data(''.Auth::user()->id.'','تغير حاله','تغير حاله اكثر من الاستبيان');
        return redirect()->back()->with('message', 'تم تغير الحاله الاستبيان بنجاح');
    }
}
