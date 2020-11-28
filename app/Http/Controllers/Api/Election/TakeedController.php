<?php

namespace App\Http\Controllers\Api\Election;

use App\Http\Resources\Election\TakeedResource;
use App\Http\Resources\Core_Data\CircleResource;
use App\Models\Core_Data\Circle;
use App\Repositories\ACL\LogRepository;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;


class TakeedController extends Controller
{
    private $logRepository;

    public function __construct(LogRepository $LogRepository)
    {
        $this->middleware('auth:api');
        $this->logRepository = $LogRepository;
    }

    public function filter(Request $request)
    {
        $colum_filter1 = array('family_name', 'name', 'first_name', 'second_name', 'third_name', 'forth_name', 'area', 'gender',
            'internal_reference', 'civil_reference', 'birth_day', 'job', 'address', 'registration_status', 'registration_number', 'registration_data');
        $takeed = User::where('circle_id', $request->circle_id)->where($colum_filter1[$request->filter], 'like', $request->word . '%')
            ->orwhere('circle_id', $request->circle_id)->Where($colum_filter1[$request->filter], 'like', '%' . $request->word . '%')
            ->paginate(25);
        if ($takeed) {
            $this->logRepository->Create_Data(Auth::user()->id, 'بحث', 'بحث فى takeed');
            return response(['status' => 1,
                'data' => [
                    'takeed' => TakeedResource::collection($takeed),
                    'paginator' => [
                        'total_count' => $takeed->Total(),
                        'total_pages' => ceil($takeed->Total() / $takeed->PerPage()),
                        'current_page' => $takeed->CurrentPage(),
                        'url_page' => url('api/takeed/filter?circle_id=' . $request->circle_id . '&filter=' . $request->filter . '&word=' . $request->word . '&page='),
                        'limit' => $takeed->PerPage()]],
                'message' => 'البيانات المراد البحث عنها'], 200);
        }
        return response(['status' => 1, 'data' => array(), 'message' => 'لا يوجد بيانات لعرضها'], 200);
    }

    public function index()
    {
        $user = Auth::user()->role;
        foreach ($user as $role) {
            if ($role->id == 1 || $role->id == 2 || $role->id == 5) {

                $circle = Circle::all();

                $colum_filter = array('إسم العائلة', 'الإسم', 'الإسم الأول', 'الإسم الثاني', 'الإسم الثالث', 'الإسم الرابع', 'الجدول (أمة)', 'نوع الجدول',
                    'مرجع الداخلية', 'الرقم المدني', 'سنة الميلاد', 'المهنة', 'العنوان', 'حالة القيد', 'رقم القيد', 'تاريخ القيد');
                $this->logRepository->Create_Data(Auth::user()->id, 'بحث', 'بحث فى takeed');
                $data['circle_id']=CircleResource::collection($circle);
                $data['colum_filter']= $colum_filter;
                return response(['status' => 1, 'data' =>array($data), 'message' => 'قائمه البحث'], 200);
            }
        }
        return response(['status' => 0,'data'=> array() ,'message'=>'لا يمكن الدخول'], 200);
    }
}