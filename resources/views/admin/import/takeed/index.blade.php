@extends('includes.admin.master_admin')
@section('title')
    قائمه الناخبين
@endsection
@section('head_style')
    @include('includes.admin.header_datatable')
@endsection
@section('content')
    <section class="content-header">
        <h1>
            الناخبين
            <small>كل الناخبين</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('/admin') }}"><i class="fa fa-dashboard"></i> لوحه التحكم</a></li>
            <li><a href="{{ url('/admin/takeed/index') }}"><i class="fa fa-areas"></i> قائمه الناخبين</a></li>
        </ol>
    </section>
    <section class="content">
            <div class="box">
                <div class="box-header" align="right">
                    @permission('takeed-form-import')
                    <a href="{{  url('/admin/takeed/import/form') }}" class="btn btn-primary">رفع</a>
                    @endpermission
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    @if(count($datas) > 0)
                        <div align="center" class="col-md-12 table-responsive">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th align="center">#</th>
                                    <th align="center">إسم العائلة</th>
                                    <th align="center">الإسم</th>
                                    <th align="center">الإسم الأول</th>
                                    <th align="center">الإسم الثاني</th>
                                    <th align="center">الإسم الثالث</th>
                                    <th align="center">الإسم الرابع</th>
                                    <th align="center">الجدول (أمة)</th>
                                    <th align="center">نوع الجدول</th>
                                    <th align="center">مرجع الداخلية</th>
                                    <th align="center">الرقم المدني</th>
                                    <th align="center">سنة الميلاد</th>
                                    <th align="center">المهنة</th>
                                    <th align="center">العنوان</th>
                                    <th align="center">حالة القيد</th>
                                    <th align="center">رقم القيد</th>
                                    <th align="center">تاريخ القيد</th>
                                    <th align="center">الدائرة</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($datas as $data)
                                    <tr>
                                        <td align="center">{{ $data->id }}</td>
                                        <td align="center">{{ $data->family_name }}</td>
                                        <td align="center">{{ $data->name }}</td>
                                        <td align="center">{{ $data->first_name }}</td>
                                        <td align="center">{{ $data->second_name }}</td>
                                        <td align="center">{{ $data->third_name }}</td>
                                        <td align="center">{{ $data->forth_name }}</td>
                                        <td align="center">{{ $data->area->title }}</td>
                                        @if($data->gender == 1)
                                        <td align="center"> رجل</td>
                                        @else
                                            <td align="center"> انثى</td>
                                        @endif
                                        <td align="center">{{ $data->internal_reference }}</td>
                                        <td align="center">{{ $data->civil_reference }}</td>
                                        <td align="center">{{ $data->birth_day }}</td>
                                        <td align="center">{{ $data->job }}</td>
                                        <td align="center">{{ $data->address }}</td>
                                        <td align="center">{{ $data->registration_status }}</td>
                                        <td align="center">{{ $data->registration_number }}</td>
                                        <td align="center">{{ $data->registration_data }}</td>
                                        <td align="center">{{ $data->circle->title }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th align="center">#</th>
                                    <th align="center">إسم العائلة</th>
                                    <th align="center">الإسم</th>
                                    <th align="center">الإسم الأول</th>
                                    <th align="center">الإسم الثاني</th>
                                    <th align="center">الإسم الثالث</th>
                                    <th align="center">الإسم الرابع</th>
                                    <th align="center">الجدول (أمة)</th>
                                    <th align="center">نوع الجدول</th>
                                    <th align="center">مرجع الداخلية</th>
                                    <th align="center">الرقم المدني</th>
                                    <th align="center">سنة الميلاد</th>
                                    <th align="center">المهنة</th>
                                    <th align="center">العنوان</th>
                                    <th align="center">حالة القيد</th>
                                    <th align="center">رقم القيد</th>
                                    <th align="center">تاريخ القيد</th>
                                    <th align="center">الدائرة</th>
                                </tr>
                                </tfoot>
                            </table>
                            {{ $datas->links() }}
                        </div>
                    @else
                        <div align="center">لا يوجد بيانات للعرض</div>
                    @endif
                </div>
                <!-- /.box-body -->
            </div>
    </section>
@endsection
@section('script_style')
    @include('includes.admin.scripts_datatable')
    {!! JsValidator::formRequest('App\Http\Requests\Admin\Core_Data\Area\StatusEditRequest','#status') !!}
@endsection