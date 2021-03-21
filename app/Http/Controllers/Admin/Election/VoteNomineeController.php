<?php

namespace App\Http\Controllers\Admin\Election;

use App\Http\Requests\Admin\Election\Vote_Nominee\CreateRequest;
use App\Repositories\ACL\LogRepository;
use App\Repositories\ACL\UserRepository;
use App\Repositories\Election\VoteNomineeRepository;
use App\Repositories\Election\VoteRepository;
use App\Traits\CoreDataa;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class VoteNomineeController extends Controller
{
    use CoreDataa;

    public function create($id)
    {
        $data = $this->voteRepository->Get_One_Data($id);
        $list_nominee = $this->votenomineeRepository->Get_List_Nominee($data->id);
        $nominee = $this->userRepository->Get_List_Nominee_Circle($data->circle_id);
        $this->logRepository->Create_Data(''.Auth::user()->id.'','عرض','فتح صفحه اضافه مرشح الى الاستبيان');
        return view('admin.election.vote_nominee.create',compact('data','nominee','list_nominee'));
    }

    public function store(CreateRequest $request,$id)
    {
        $this->votenomineeRepository->Create_Data($request,$id);
        $this->logRepository->Create_Data(''.Auth::user()->id.'','تسجيل','تم اضافه مرشح الى الاستبيان جديد ');
        return redirect('/admin/vote/index')->with('message', 'تم التسجيل  الاستبيان بنجاح');
    }

}
