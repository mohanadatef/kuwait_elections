<?php

namespace App\Http\Controllers\Admin\Election;

use App\Http\Requests\Admin\Election\Vote_Nominee\CreateRequest;
use App\Repositories\ACL\LogRepository;
use App\Repositories\ACL\UserRepository;
use App\Repositories\Election\VoteNomineeRepository;
use App\Repositories\Election\VoteRepository;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class VoteNomineeController extends Controller
{
    private $userRepository;
    private $voteRepository;
    private $votenomineeRepository;
    private $logRepository;
    public function __construct(VoteRepository $voteRepository,VoteNomineeRepository $votenomineeRepository,UserRepository $userRepository,LogRepository $LogRepository)
    {
        $this->userRepository = $userRepository;
        $this->voteRepository = $voteRepository;
        $this->votenomineeRepository = $votenomineeRepository;
        $this->logRepository = $LogRepository;
    }

    public function create($id)
    {
        $data = $this->voteRepository->Get_One_Data($id);
        $nominee = $this->userRepository->Get_List_Nominee_Circle($data->circle_id);
        $this->logRepository->Create_Data(''.Auth::user()->id.'','عرض','فتح صفحه اضافه مرشح الى الاستبيان');
        return view('admin.election.vote.create',compact('data','nominee'));
    }

    public function store(CreateRequest $request)
    {
        $this->votenomineeRepository->Create_Data($request);
        $this->logRepository->Create_Data(''.Auth::user()->id.'','تسجيل','تم اضافه مرشح الى الاستبيان جديد ');
        return redirect('/admin/vote/index')->with('message', 'تم التسجيل  الاستبيان بنجاح');
    }

}
