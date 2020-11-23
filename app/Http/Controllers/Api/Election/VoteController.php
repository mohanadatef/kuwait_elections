<?php

namespace App\Http\Controllers\Api\Election;

use App\Http\Resources\Election\NomineeResource;
use App\Http\Resources\Election\VoteResource;
use App\Models\Election\Election;
use App\Models\Election\Vote;
use App\Models\Election\Vote_Nominee;
use App\Models\Election\Vote_User;
use App\Repositories\ACL\LogRepository;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class VoteController extends Controller
{
    private $logRepository;

    public function __construct(LogRepository $LogRepository)
    {
        $this->middleware('auth:api', ['except' => ['show']]);
        $this->logRepository = $LogRepository;
    }

    public function show(Request $request)
    {
        if ($request->status_auth == 1) {
            $user = User::find($request->user_id);
            if (!$user) {
                return response(['status' => 0, 'data' => array(), 'message' => 'خطا فى تحميل البيانات المستخدم'], 400);
            }
            $vote=Vote::where('circle_id',$user->circle_id)->where('status',1)->get();
            $this->logRepository->Create_Data('' . $user->id . '', 'عرض', 'عرض قائمه الاستبيان');
            if($vote)
            {
                return response(['status' => 1, 'data' => ['vote'=>VoteResource::collection($vote)], 'message' => 'قائمه الاستبيان'], 200);
            }
            return response(['status' => 1, 'data' => array(), 'message' => 'لا يوجد استبيان لعرضه'], 400);
        }
        $vote=Vote::where('status',1)->get();
        if($vote)
        {
            return response(['status' => 1, 'data' => ['vote'=>VoteResource::collection($vote)], 'message' => 'قائمه الاستبيان'], 200);
        }
        return response(['status' => 1, 'data' => array(), 'message' => 'لا يوجد استبيان لعرضه'], 200);
    }

    public function vote(Request $request)
    {
        $user = User::find($request->user_id);
        if (!$user) {
            return response(['status' => 0, 'data' => array(), 'message' => 'خطا فى تحميل البيانات المستخدم'], 400);
        }
        $vote = Vote::find($request->vote_id);
        if (!$vote) {
            return response(['status' => 0, 'data' => array(), 'message' => 'خطا فى تحميل البيانات الاستبيان'], 400);
        }
        $nominee = User::find($request->nominee_id);
        if (!$nominee) {
            return response(['status' => 0, 'data' => array(), 'message' => 'خطا فى تحميل البيانات المرشح'], 400);
        }
        $vote_election = new Vote_User();
        $vote_election->vote_id=$request->vote_id;
        $vote_election->user_id=$request->user_id;
        $vote_election->nominee_id=$request->nominee_id;
        $vote_election->save();
        $vote_count =Vote_Nominee::where('vote_id',$request->vote)->where('nominee_id',$request->nominee_id)->first();
        $vote_count->nominee_count=$vote_count->nominee_count+1;
        $vote_count->updated();
        $vote=Vote::where('vote_id',$request->vote_id)->get();
        return response(['status' => 1, 'data' => ['vote'=>new VoteResource($vote)], 'message' => 'تم التصويت بنجاح'], 200);
    }
}
