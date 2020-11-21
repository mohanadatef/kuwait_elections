<?php

namespace App\Http\Controllers\Api\Web\ACL;

use App\Http\Resources\Web\ACL\NomineeResource;
use App\Models\Election\Election;
use App\Repositories\ACL\LogRepository;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class NomineeController extends Controller
{
    private $logRepository;

    public function __construct(LogRepository $LogRepository)
    {
        $this->middleware('auth:api', ['except' => ['show_list']]);
        $this->logRepository = $LogRepository;
    }

    public function show(Request $request)
    {
        $user = User::find($request->user_id);
        if (!$user) {
            return response(['status' => 0, 'data' => array(), 'message' => 'خطا فى تحميل البيانات المستخدم'], 400);
        }
        $nominee = array();
        $nominee_list = array();
        $election = Election::where('user_id', $user->id)->where('status', 1)->first();
        $this->logRepository->Create_Data('' . $user->id . '', 'عرض', 'عرض المرشح الموصى بيه');
        $user_role = DB::table("role_user")->where('role_id', 4)->pluck("user_id", "id");
        if ($election) {
            $nominee = User::find($election->nominee_id);
            if ($nominee) {
                $nominee = new NomineeResource($nominee);
            }
            if (count($user_role) != 0) {
                $nominees = DB::table("users")->wherein('id', $user_role)->where('circle_id', $user->circle_id)->pluck('id', 'id');
                $nominees = User::wherein('id', $nominees)->get();
                if (count($nominees) != 0) {
                    $nominee_list = NomineeResource::collection($nominees);
                }
            }
            return response(['status' => 1,

                    'status_election' => 1,
                    'nominee' => $nominee,
                    'nominee_list' => $nominee_list, 'message' => 'تم الانتخاب مسبق'], 200);
        }
        if (count($user_role) != 0) {
            $nominee = User::with('image')->wherein('id', $user_role)->where('circle_id', $user->circle_id)->inRandomOrder()->first();
            if ($nominee) {
                $nominee = new NomineeResource($nominee);
            }
        }
        return response(['status' => 1, 'status_election' => 0,
            'nominee' => $nominee, 'message' => 'برجاء انتخاب مرشح'], 200);
    }

    public function election(Request $request)
    {
        $user = User::find($request->user_id);
        if (!$user) {
            return response(['status' => 0, 'data' => array(), 'message' => 'خطا فى تحميل البيانات المستخدم'], 400);
        }
        $this->logRepository->Create_Data('' . $user->id . '', 'انتخاب', 'انتخاب المرشح');
        if ($request->status_election == 0) {
            $check = Election::where('user_id', $user->id)->where('nominee_id', $request->nominee_id)->where('status', 0)->first();
            if (!$check) {
                $election = new Election();
                $election->user_id = $user->id;
                $election->nominee_id = $request->nominee_id;
                $election->status = 0;
                $election->save();
            }
            $election_f = DB::table("elections")->where('user_id', $user->id)->where('status', 0)->pluck('nominee_id', 'id');
            $user_role = DB::table("role_user")->where('role_id', 4)->pluck("user_id", "id");
            if ($user_role) {
                if (count($election_f) != 0) {
                    $nominee = DB::table("users")->wherein('id', $user_role)->whereNotIn('id', $election_f)->where('circle_id', $user->circle_id)->inRandomOrder()->first();
                    if ($nominee) {
                        return response(['status' => 1,
                            'data' => ['status_election' => 0, 'nominee' => new NomineeResource($nominee)], 'message' => 'برجاء انتخاب مرشح'], 201);
                    } else {
                        $elections = Election::where('user_id', $user->id)->where('status', 0)->get();
                        foreach ($elections as $election) {
                            $election->delete();
                        }
                    }
                }
                $nominee = DB::table("users")->wherein('id', $user_role)->where('circle_id', $user->circle_id)->inRandomOrder()->first();
                if ($nominee) {
                    return response(['status' => 1,
                        'data' => ['status_election' => 0, 'nominee' => new NomineeResource($nominee)], 'message' => 'برجاء انتخاب مرشح'], 201);
                }
            }
            return response(['status' => 1, 'data' => ['status_election' => 0, 'nominee' => array()], 'message' => 'لا يوجد مرشح لانتخاب'], 201);
        } elseif ($request->status_election == 1) {
            $nominees = array();
            $user_role = DB::table("role_user")->where('role_id', 4)->pluck("user_id", "id");
            if (count($user_role) != 0) {
                $nominees = DB::table("users")->wherein('id', $user_role)->where('circle_id', $user->circle_id)->get();
                if ($nominees) {
                    $nominees = NomineeResource::collection($nominees);
                }
            }
            $check = Election::where('user_id', $user->id)->where('status', 1)->first();
            if (!$check) {
                $check = Election::where('user_id', $user->id)->where('status', 0)->get();
                foreach ($check as $checks) {
                    $checks->delete();
                }
                $election = new Election();
                $election->user_id = $user->id;
                $election->nominee_id = $request->nominee_id;
                $election->status = 1;
                $election->save();
                $nominee = User::find($election->nominee_id);
                $nominee = new NomineeResource($nominee);
                return response(['status' => 1,
                    'data' => [
                        'status_election' => 1,
                        'nominee' => $nominee,
                        'nominee_list' => $nominees],
                    'message' => 'تم انتخاب المرشح بنجاح'
                ], 200);
            }
            $nominee = User::find($check->nominee_id);
            $nominee = new NomineeResource($nominee);
            if ($nominee) {
                return response(['status' => 1,
                    'data' => [
                        'status_election' => 1,
                        'nominee' => $nominee,
                        'nominee_list' => $nominees],
                    'message' => 'عرض بيانات المرشح الخاص بك'
                ], 200);
            }
            $nominee = array();
            return response(['status' => 0,
                'data' => [
                    'status_election' => 1,
                    'nominee' => $nominee,
                    'nominee_list' => $nominees], 'message' => 'خطا فى تحميل البيانات'], 400);
        }
    }

    public function show_list(Request $request)
    {
        $nominees=array();
        if ($request->status_auth == 1) {
            $user = User::find($request->user_id);
            if (!$user) {
                return response(['status' => 0, 'data' => array(), 'message' => 'خطا فى تحميل البيانات المستخدم'], 400);
            }
            $this->logRepository->Create_Data('' . $user->id . '', 'عرض', 'عرض قائمه المرشح');
        }
        $nominee = User::find($request->nominee_id);
        if ($nominee) {
            $nominee = array(new NomineeResource($nominee));
        } else {
            $nominee = array();
        }
        $user_role = DB::table("role_user")->where('role_id', 4)->pluck("user_id", "id");
        if (count($user_role) != 0) {
            if ($request->status_auth == 1) {
                $nominees = DB::table("users")->wherein('id', $user_role)->where('circle_id', $user->circle_id)->get();
            } else {
                $nominees = DB::table("users")->wherein('id', $user_role)->get();
            }
        }
        if ($nominees) {
            $nominees = NomineeResource::collection($nominees);
        } else {
            $nominees = array();
        }

        return response(['status' => 1, 'data' => ['nominee' => $nominee, 'nominee_list' => $nominees], 'message' => 'قائمه المرشحين'], 200);
    }
}
