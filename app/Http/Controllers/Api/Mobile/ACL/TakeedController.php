<?php

namespace App\Http\Controllers\Api\Mobile\ACL;

use App\Http\Resources\Mobile\ACL\TakeedResource;
use App\Http\Resources\Mobile\Core_Data\CircleResource;
use App\Models\ACL\Takeed;
use App\Models\Core_Data\Circle;
use App\Repositories\ACL\LogRepository;
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
        $colum_filter1 = array('family_name','name','first_name','second_name','third_name','forth_name','family_name_one','table_area','table_gender',
            'internal_reference','civil_reference','birth_day','job','address','registration_status','registration_number','registration_data');
        $takeed = Takeed::where('circle', $request->circle)->where($colum_filter1[$request->filter], 'like', $request->word . '%')
            ->orwhere('circle', $request->circle)->Where($colum_filter1[$request->filter], 'like', '%' . $request->word . '%')
            ->paginate(25);
        if ($takeed) {
            $this->logRepository->Create_Data(Auth::user()->id, 'بحث', 'بحث فى takeed عن طريق Api' . Auth::user()->username . " / " . Auth::user()->id);
            return response(['takeed' => TakeedResource::collection($takeed), 'paginator' => [
                'total_count' => $takeed->Total(),
                'total_pages' => ceil($takeed->Total() / $takeed->PerPage()),
                'current_page' => $takeed->CurrentPage(),
                'url_page' => url('api/takeed/filter?circle=' . $request->circle . '&filter=' . $request->filter . '&word=' . $request->word . '&page='),
                'limit' => $takeed->PerPage()]], 200);
        }
        return response(['message' => 'خطا فى تحميل البيانات'], 400);
    }

    public function index()
    {
        $circle = Circle::all();
        $colum_filter = array('إسم العائلة', 'الإسم', 'الإسم الأول','الإسم الثاني','الإسم الثالث','الإسم الرابع','إسم العائلة','الجدول (أمة)','نوع الجدول',
            'مرجع الداخلية','الرقم المدني','سنة الميلاد','المهنة','العنوان','حالة القيد','رقم القيد','تاريخ القيد');
        $this->logRepository->Create_Data(Auth::user()->id, 'بحث', 'بحث فى takeed عن طريق Api' . Auth::user()->username . " / " . Auth::user()->id);
        return response(['circle' => CircleResource::collection($circle), 'colum_filter' => $colum_filter], 200);
    }
}