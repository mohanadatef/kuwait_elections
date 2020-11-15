@extends('includes.admin.master_admin')
@section('title')
     قائمه اتصل بنا غير المقرؤه
@endsection
@section('head_style')
    @include('includes.admin.header_datatable')
@endsection
@section('content')
    <section class="content-header">
        <h1>
             اتصل بنا غير المقرؤه
            <small>كل اتصل بنا غير المقرؤه</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('/admin') }}"><i class="fa fa-dashboard"></i>لوحه التحكم</a></li>
            <li><a href="{{ url('/admin/call_us/unread') }}"><i class="fa fa-permissions"></i>اتصل بنا غير المقرؤه</a></li>
        </ol>
    </section>
    <section class="content">
            <div class="box">
                <div class="box-header" align="right">
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    @if(count($datas) > 0)
                        <div align="center" class="col-md-12 table-responsive">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th align="center">الوقت</th>
                                    <th align="center">الاسم</th>
                                    <th align="center">البريد الالكنروني</th>
                                    <th align="center">الهاتف</th>
                                    <th align="center">الرساله</th>
                                    @permission('call-us-change-status')
                                    <th align="center">الحاله</th>
                                    @endpermission
                                    <th align="center">التحكم</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($datas as $data)
                                    <tr>
                                        <td align="center">{{ $data->created_at }}</td>
                                        <td align="center">{{ $data->name }}</td>
                                        <td align="center">{{ $data->email }}</td>
                                        <td align="center">{{ $data->mobile }}</td>
                                        <td align="center">{{ $data->message }}</td>
                                        @permission('call-us-change-status')
                                        <td align="center">
                                            <a href="{{ url('/admin/call_us/change_status/'.$data->id)}}"><i class="btn btn-sm btn-primary ace-icon fa fa-edit bigger-120  edit" data-id=""> مقرؤء</i></a>
                                        </td>
                                            @endpermission
                                        <td align="center">
                                            @permission('call-us-delete')
                                            <a href="{{ url('/admin/call_us/delete/'.$data->id)}}"><i class="btn btn-sm btn-danger ace-icon fa fa-delete bigger-120  delete" data-id="">مسح</i></a>
                                            @endpermission
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th align="center">الوقت</th>
                                    <th align="center">الاسم</th>
                                    <th align="center">البريد الالكنروني</th>
                                    <th align="center">الهاتف</th>
                                    <th align="center">الرساله</th>
                                    @permission('call-us-change-status')
                                    <th align="center">الحاله</th>
                                    @endpermission
                                    <th align="center">التحكم</th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    @else
                        <div align="center">لا يوجد بنات لعرضها</div>
                    @endif
                </div>
                <!-- /.box-body -->
            </div>
    </section>
@endsection
@section('script_style')
    @include('includes.admin.scripts_datatable')
@endsection