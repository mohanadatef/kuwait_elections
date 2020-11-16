<?php

namespace App\Http\Controllers\Api\ACL;

use App\Http\Resources\ACL\NomineeResource;
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
        $this->logRepository->Create_Data(Auth::user()->id, 'تسجيل مستخدم جديد', 'تسجيل مستخدم جديد عن طريق Api' . Auth::user()->username . " / " . Auth::user()->id);
        $election = Election::where('user_id', Auth::user()->id)->first();
        if ($election) {
            $nominee = User::find($election->nominee_id);
            if ($nominee) {
                return response(['status' => 1,
                    'election_status' => 1,
                    'nominee' => array(new NomineeResource($nominee),
                    )], 201);
            }
            return response(['status' => 0], 400);
        }
        $user_role = DB::table("role_user")->where('role_id', 4)->pluck("user_id", "id");
        if (count($user_role) != 0) {
            $nominee = DB::table("users")->wherein('id', $user_role)->where('circle_id', Auth::user()->circle_id)->pluck('id', 'id');
            if (count($nominee) != 0) {
                $nominee = array_rand($nominee->toArray(), 1);
                $nominee = User::find($nominee);
                return response([
                    'status' => 1,
                    'election_status' => 0,
                    'nominee' => array(new NomineeResource($nominee)),
                ], 201);
            }
            return response(['status' => 0], 400);
        }
        return response(['status' => 0], 400);
    }

    public function election(Request $request)
    {
        $user = User::find($request->user_id);
        if ($request->status_election == 0) {
            $check = Election::where('user_id', $request->user_id)->where('nominee_id', $request->nominee_id)->where('status', 0)->first();
            if (!$check) {
                $election = new Election();
                $election->user_id = $request->user_id;
                $election->nominee_id = $request->nominee_id;
                $election->status = 0;
                $election->save();
                $election_f = DB::table("elections")->where('user_id', $request->user_id)->where('status', 0)->pluck('nominee_id', 'id');
                $user_role = DB::table("role_user")->where('role_id', 4)->pluck("user_id", "id");
                if ($user_role) {
                    if (count($election_f) != 0) {
                        $nominee = DB::table("users")->wherein('id', $user_role)->whereNotIn('id', $election_f)->where('circle_id', $user->circle_id)->pluck('id', 'id');
                        if (count($nominee) != 0) {
                            $nominee = array_rand($nominee->toArray(), 1);
                            $nominee = User::find($nominee);
                            return response(['status' => 1, 'nominee' => array(new NomineeResource($nominee))], 201);
                        } else {
                            $elections = Election::where('user_id', $request->user_id)->where('status', 0)->get();
                            foreach ($elections as $election) {
                                $election->delete();
                            }
                            $user_role = DB::table("role_user")->where('role_id', 4)->pluck("user_id", "id");
                            if ($user_role) {
                                $nominee = DB::table("users")->wherein('id', $user_role)->where('circle_id', $user->circle_id)->pluck('id', 'id');
                                if (count($nominee) != 0) {
                                    $nominee = array_rand($nominee->toArray(), 1);
                                    $nominee = User::find($nominee);
                                    return response(['status' => 1, 'nominee' => array(new NomineeResource($nominee))], 201);
                                }
                            }
                        }
                    }
                    $nominee = DB::table("users")->wherein('id', $user_role)->where('circle_id', $user->circle_id)->pluck('id', 'id');
                    if (count($nominee) != 0) {
                        $nominee = array_rand($nominee->toArray(), 1);
                        $nominee = User::find($nominee);
                        return response(['status' => 1, 'nominee' => array(new NomineeResource($nominee))], 201);
                    }
                }
                return response(['status' => 1, 'message' => 'لا يوجد مرشحين'], 200);
            }
            return response(['status' => 0, 'message' => 'برجاء اعاده ارسال رقم المرشح صحيح'], 400);
        } elseif ($request->status_election == 1) {
            $election = new Election();
            $election->user_id = $request->user_id;
            $election->nominee_id = $request->nominee_id;
            $election->status = 1;
            $election->save();
            return response(['status' => 1, 'message' => 'تم التصويت بنجاح'], 200);
        }
        return response(['status' => 0], 400);
    }


    public function show_list(Request $request)
    {
        $nominee = User::find($request->nominee_id);
        if($nominee)
        {
            $user_role = DB::table("role_user")->where('role_id', 4)->pluck("user_id", "id");
            if (count($user_role) != 0) {
                $nominees = DB::table("users")->wherein('id', $user_role)->where('circle_id', Auth::user()->circle_id)->pluck('id', 'id');
                $nominees=User::wherein('id',$nominees)->get();
                if (count($nominees) != 0) {
                    return response([
                        'status' => 1,
                        'nominee' => array(new NomineeResource($nominee)),
                        'nominee_list' => array( NomineeResource::collection($nominees)),
                    ], 201);
                }
                return response(['status' => 0], 400);
            }
            return response(['status' => 0], 400);
        }
        return response(['status' => 0], 400);
    }
}
