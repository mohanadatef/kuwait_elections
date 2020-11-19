@extends('includes.admin.master_admin')
@section('title')
    قائمه المستخدم
@endsection
@section('head_style')
    @include('includes.admin.header_datatable')
@endsection
@section('content')
    <section class="content-header">
        <h1>
            المستخدمين
            <small>كل المستخدمين</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('/admin') }}"><i class="fa fa-dashboard"></i> لوحه التحكم</a></li>
            <li><a href="{{ url('/admin/user/index') }}"><i class="fa fa-users"></i>قائمه المستخدمين</a></li>
        </ol>
    </section>
    <section class="content">
        <form method="get" action="{{ url('/admin/user/change_many_status')}}">
        <div class="box">
            <div class="box-header" align="right">
                @permission('user-create')
                <a href="{{  url('/admin/user/create') }}" class="btn btn-primary">اضافه</a>
                @endpermission
                @permission('user-many-status')
                <input type="submit" value="تغير حاله" class="btn btn-primary">
                @endpermission
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                @if(count($datas) > 0)
                    <div align="center" class="col-md-12 table-responsive">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        @permission('user-many-status')
                        <th align="center">#</th>
                        @endpermission
                        <th align="center">اسم المستخدم</th>
                        <th align="center">نوع المستخدم</th>
                        <th align="center">الرقم المدنى</th>
                        <th align="center">الدائرة</th>
                        @permission('user-status')
                        <th align="center">الحاله</th>
                        @endpermission
                        @permission('log-user-index')
                        <th align="center">عرض السجل</th>
                        @endpermission
                        <th align="center">التحكم</th>
                        @permission('user-password')
                        <th align="center">تعديل كلمه السر</th>
                        @endpermission
                        @permission('forgot-password')
                        <th align="center">سجل تعديل كلمه السر</th>
                        @endpermission
                        @permission('user-upgrad')
                        <th align="center">تغير نوع المستخدم</th>
                        @endpermission
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($datas as $data)
                        <tr>
                            @permission('user-many-status')
                            <td align="center">
                                        <input type="checkbox" name="change_status[]"
                                               id="{{$data->id}}" value="{{$data->id}}">

                            </td>
                            @endpermission
                            <td align="center">{{ $data->name }}</td>
                            <td align="center">
                                @foreach($data->role as $user_role)
                                    [{{ $user_role->name }}],
                                @endforeach
                            </td>
                            <td align="center">{{ $data->civil_reference }}</td>
                            <td align="center">{{ $data->circle->title }}</td>
                            @permission('user-status')
                            <td align="center">
                                    @if($data->status ==1)
                                        <a href="{{ url('/admin/user/change_status/'.$data->id)}}"><i
                                                    class="btn btn-danger ace-icon fa fa-close"> غير مفعل</i></a>
                                    @elseif($data->status ==0)
                                        <a href="{{ url('/admin/user/change_status/'.$data->id)}}"><i
                                                    class="btn btn-primary ace-icon fa fa-check-circle"> مفعل</i></a>
                                    @endif
                            </td>
                            @endpermission
                            @permission('log-user-index')
                            <td align="center">
                                        <a href="{{ url('/admin/log/user/index/'.$data->id)}}"><i
                                                    class="btn btn-primary ace-icon fa fa-check-circle"> السجل</i></a>
                            </td>
                            @endpermission
                            @permission('user-edit')
                            <td align="center">
                                    <a href="{{ url('/admin/user/edit/'.$data->id)}}"><i
                                                class="btn btn-primary ace-icon fa fa-edit bigger-120  edit"
                                                data-id=""> تعديل</i></a>

                            </td>
                            @endpermission
                            @permission('user-password')
                            <td>
                                    <a href="{{url('admin/user/change_password/'.$data->id)}}"
                                       class="btn btn-success"> تغير كلمه السر</a>
                            </td>
                            @endpermission
                            @permission('forgot-password')
                            <td>
                                <a href="{{url('admin/forgot_password/index/'.$data->id)}}"
                                   class="btn btn-success"> سجل تعديل كلمه السر</a>
                            </td>
                            @endpermission
                            @permission('user-upgrad')
                            <td>
                                <a href="{{url('admin/user/upgrad/'.$data->id)}}"
                                   class="btn btn-success">تغير نوع المستخدم</a>
                            </td>
                            @endpermission
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        @permission('user-many-status')
                        <th align="center">#</th>
                        @endpermission
                        <th align="center">اسم المستخدم</th>
                        <th align="center">نوع المستخدم</th>
                        <th align="center">الرقم المدنى</th>
                        <th align="center">الدائرة</th>
                        @permission('user-status')
                        <th align="center">الحاله</th>
                        @endpermission
                        @permission('log-user-index')
                        <th align="center">عرض السجل</th>
                        @endpermission
                        <th align="center">التحكم</th>
                        @permission('user-password')
                        <th align="center">تعديل كلمه السر</th>
                        @endpermission
                        @permission('forgot-password')
                        <th align="center">سجل تعديل كلمه السر</th>
                        @endpermission
                        @permission('user-upgrad')
                        <th align="center">تغير نوع المستخدم</th>
                        @endpermission
                    </tr>
                    </tfoot>
                </table>
                    </div>
                @else
                    <div align="center">لا يوجد بيانات لعرضها</div>
                @endif
            </div>
            <!-- /.box-body -->
        </div>
        </form>
    </section>
@endsection
@section('script_style')
    @include('includes.admin.scripts_datatable')
    {!! JsValidator::formRequest('App\Http\Requests\Admin\ACL\User\StatusEditRequest','#status') !!}
@endsection