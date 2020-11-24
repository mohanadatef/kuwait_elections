@extends('includes.admin.master_admin')
@section('title')
   قائمه الاشعارات
@endsection
@section('head_style')
    @include('includes.admin.header_datatable')
@endsection
@section('content')
    <section class="content-header">
        <h1>
         الاشعارات
            <small>كل الاشعارات</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('/admin') }}"><i class="fa fa-dashboard"></i>لوحه التحكم</a></li>
            <li><a href="{{ url('/admin/notification/index') }}"><i class="fa fa-permissions"></i>الاشعارات</a></li>
        </ol>
    </section>
    <section class="content">
            <div class="box">
                <div class="box-header" align="right">
                    @permission('notification-create')
                    <a href="{{  url('/admin/notification/create') }}" class="btn btn-primary">اضافه</a>
                    @endpermission
                    @permission('notification-many-status')
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
                                    @permission('notification-many-status')
                                    <th align="center">#</th>
                                    @endpermission
                                    <th align="center">العنوان</th>
                                    @permission('notification-status')
                                    <th align="center">الحاله</th>
                                    @endpermission
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($datas as $data)
                                    <tr>
                                        @permission('notification-many-status')
                                        <td align="center">
                                            <input type="checkbox" name="change_status[]"
                                                   id="{{$data->id}}" value="{{$data->id}}">

                                        </td>
                                        @endpermission
                                        <td align="center">{{ $data->details }}</td>
                                        @permission('notification-status')
                                        <td align="center">
                                            @if($data->status ==1)
                                                <a href="{{ url('/admin/notification/change_status/'.$data->id)}}"><i
                                                            class="btn btn-danger ace-icon fa fa-close"> غير مفعل</i></a>
                                            @elseif($data->status ==0)
                                                <a href="{{ url('/admin/notification/change_status/'.$data->id)}}"><i
                                                            class="btn btn-primary ace-icon fa fa-check-circle"> مفعل</i></a>
                                            @endif
                                        </td>
                                        @endpermission
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    @permission('notification-many-status')
                                    <th align="center">#</th>
                                    @endpermission
                                    <th align="center">العنوان</th>
                                    @permission('notification-status')
                                    <th align="center">الحاله</th>
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
    </section>
@endsection
@section('script_style')
    @include('includes.admin.scripts_datatable')
@endsection