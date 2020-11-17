<?php

namespace App\Http\Controllers\Api\Web\ACL;

use App\Http\Resources\Web\ACL\NomineeResource;
use App\Models\ACL\Election;
use App\Repositories\ACL\LogRepository;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NomineeController extends Controller
{
    private $logRepository;

    public function __construct(LogRepository $LogRepository)
    {
        $this->middleware('auth:api');
        $this->logRepository = $LogRepository;
    }

    public function show()
    {
        $election = Election::where('user_id', Auth::user()->id)->where('status', 1)->first();
        $this->logRepository->Create_Data('' . Auth::user()->id . '', 'عرض', 'عرض المرشح الموصى بيه');
        $user_role = DB::table("role_user")->where('role_id', 4)->pluck("user_id", "id");
        if ($election) {
            $nominee = User::find($election->nominee_id);
            if ($nominee) {
                $nominee = array(new NomineeResource($nominee));
            }
            if (count($user_role) != 0) {
                $nominees = DB::table("users")->wherein('id', $user_role)->where('circle_id', Auth::user()->circle_id)->pluck('id', 'id');
                $nominees = User::wherein('id', $nominees)->get();
                if (count($nominees) != 0) {
                    $nominee_list = array(NomineeResource::collection($nominees));
                }
            }
            return response(['status' => 1, 'status_election' => 1,
                'nominee' => $nominee,
                'nominee_list' => $nominee_list], 400);
        }
        if (count($user_role) != 0) {
            $nominee = DB::table("users")->wherein('id', $user_role)->where('circle_id', Auth::user()->circle_id)->pluck('id', 'id');
            if (count($nominee) != 0) {
                $nominee = array_rand($nominee->toArray(), 1);
                $nominee = User::find($nominee);
                return response([
                    'status' => 1,
                    'status_election' => 0,
                    'nominee' => array(new NomineeResource($nominee)),
                ], 201);
            }
        }
        return response(['status' => 1, 'status_election' => 0, 'nominee' => ''], 400);
    }

    public function election(Request $request)
    {
        $user = User::find(Auth::user()->id);
        $this->logRepository->Create_Data('' . Auth::user()->id . '', 'انتخاب', 'انتخاب المرشح');
        if ($request->status_election == 0) {
            $user_role = DB::table("role_user")->where('role_id', 4)->pluck("user_id", "id");
            $check = Election::where('user_id', $user->id)->where('nominee_id', $request->nominee_id)->where('status', 0)->first();
            if (!$check) {
                $election = new Election();
                $election->user_id = $user->id;
                $election->nominee_id = $request->nominee_id;
                $election->status = 0;
                $election->save();
                $election_f = DB::table("elections")->where('user_id', $user->id)->where('status', 0)->pluck('nominee_id', 'id');
                if ($user_role) {
                    if (count($election_f) != 0) {
                        $nominee = DB::table("users")->wherein('id', $user_role)->whereNotIn('id', $election_f)->where('circle_id', $user->circle_id)->pluck('id', 'id');
                        if (count($nominee) != 0) {
                            $nominee = array_rand($nominee->toArray(), 1);
                            $nominee = User::find($nominee);
                            return response(['status' => 1, 'status_election' => 0, 'nominee' => array(new NomineeResource($nominee))], 201);
                        } else {
                            $elections = Election::where('user_id', $request->user_id)->where('status', 0)->get();
                            foreach ($elections as $election) {
                                $election->delete();
                            }
                        }
                    }
                    $nominee = DB::table("users")->wherein('id', $user_role)->where('circle_id', $user->circle_id)->pluck('id', 'id');
                    if (count($nominee) != 0) {
                        $nominee = array_rand($nominee->toArray(), 1);
                        $nominee = User::find($nominee);
                        return response(['status' => 1, 'status_election' => 0, 'nominee' => array(new NomineeResource($nominee))], 201);
                    }
                }
                return response(['status' => 1, 'status_election' => 0, 'nominee' => ''], 200);
            }
            return response(['status' => 0, 'status_election' => 0, 'nominee' => ''], 400);
        } elseif ($request->status_election == 1) {
            $user_role = DB::table("role_user")->where('role_id', 4)->pluck("user_id", "id");
            if (count($user_role) != 0) {
                $nominees = DB::table("users")->wherein('id', $user_role)->where('circle_id', Auth::user()->circle_id)->pluck('id', 'id');
                $nominees = User::wherein('id', $nominees)->get();
                if (count($nominees) != 0) {
                    $nominees = array(NomineeResource::collection($nominees));
                }
            }
            $check = Election::where('user_id', Auth::user()->id)->where('status', 1)->first();
            if (!$check) {
                $check = Election::where('user_id', Auth::user()->id)->where('status', 0)->get();
                foreach ($check as $checks) {
                    $checks->delete();
                }
                $election = new Election();
                $election->user_id = Auth::user()->id;
                $election->nominee_id = $request->nominee_id;
                $election->status = 1;
                $election->save();
                $nominee = User::find($election->nominee_id);
                $nominee=array(new NomineeResource($nominee));
                return response(['status' => 1, 'status_election' => 1,
                    'nominee' => $nominee,
                    'nominee_list' => $nominees], 200);
            }
            $nominee = User::find($check->nominee_id);
            $nominee=array(new NomineeResource($nominee));
            if ($nominee) {
                return response(['status' => 1, 'status_election' => 1,
                    'nominee' => $nominee,
                    'nominee_list' => $nominees], 200);
            }
            return response(['status' => 0, 'status_election' => 1,
                'nominee' => $nominee,
                'nominee_list' => $nominees], 400);
        }
    }

    public function show_list(Request $request)
    {
        $nominee = User::find($request->nominee_id);
        $this->logRepository->Create_Data('' . Auth::user()->id . '', 'عرض', 'عرض قائمه المرشح');
        $user_role = DB::table("role_user")->where('role_id', 4)->pluck("user_id", "id");
        if (count($user_role) != 0) {
            $nominees = DB::table("users")->wherein('id', $user_role)->where('circle_id', Auth::user()->circle_id)->pluck('id', 'id');
            $nominees = User::wherein('id', $nominees)->get();
            if (count($nominees) != 0) {
                $nominees=array(NomineeResource::collection($nominees));
            }
        }
        if ($nominee) {
            $nominee = array(new NomineeResource($nominee));
        }
        return response(['status' => 1, 'nominee' => $nominee,
            'nominee_list' => $nominees], 400);
    }
}
