<?php

namespace App\Http\Controllers\Api\Takeed\ACL;

use App\Http\Resources\Takeed\ACL\TakeedResource;
use App\Http\Resources\Takeed\Core_Data\CircleResource;
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
        $colum_filter1 = array('family_name','name','first_name','second_name','third_name','forth_name','area_id','gender',
            'internal_reference','civil_reference','birth_day','job','address','registration_status','registration_number','registration_data');
        $takeed = User::where('circle', $request->circle)->where($colum_filter1[$request->filter], 'like', $request->word . '%')
            ->orwhere('circle', $request->circle)->Where($colum_filter1[$request->filter], 'like', '%' . $request->word . '%')
            ->select('family_name','name','first_name','second_name','third_name','forth_name','area_id','gender',
                'internal_reference','civil_reference','birth_day','job','address','registration_status','registration_number','registration_data'
            ,'circle_id')
            ->paginate(25);
        if ($takeed) {
            $this->logRepository->Create_Data(''.Auth::user()->id.'', 'بحث', 'بحث فى takeed');
            return response(['status' => 1,
                'takeed' => TakeedResource::collection($takeed), 'paginator' => [
                'total_count' => $takeed->Total(),
                'total_pages' => ceil($takeed->Total() / $takeed->PerPage()),
                'current_page' => $takeed->CurrentPage(),
                'url_page' => url('api/takeed/filter?circle=' . $request->circle . '&filter=' . $request->filter . '&word=' . $request->word . '&page='),
                'limit' => $takeed->PerPage()]], 200);
        }
        return response(['status' => 0], 400);
    }

    public function index()
    {
        $circle = Circle::all();
        $colum_filter = array('إسم العائلة', 'الإسم', 'الإسم الأول','الإسم الثاني','الإسم الثالث','الإسم الرابع','الجدول (أمة)','نوع الجدول',
            'مرجع الداخلية','الرقم المدني','سنة الميلاد','المهنة','العنوان','حالة القيد','رقم القيد','تاريخ القيد');
        $this->logRepository->Create_Data(''.Auth::user()->id.'', 'بحث', 'بحث فى takeed');
        return response(['status' => 1,'circle' => CircleResource::collection($circle), 'colum_filter' => $colum_filter], 200);
    }
}