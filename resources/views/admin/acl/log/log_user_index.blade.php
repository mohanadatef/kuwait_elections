@extends('includes.admin.master_admin')
@section('title')
    قائمه السجل
@endsection
@section('head_style')
    @include('includes.admin.header_datatable')
@endsection
@section('content')
    <section class="content-header">
        <h1>
            السجل
            <small>قائمه السجل للمستخدم الواحد</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('/admin') }}"><i class="fa fa-dashboard"></i> لوحه التحكم</a></li>
            <li><a href="{{ url('/admin/log/user/index') }}"><i class="fa fa-users"></i>قائمه السجل للمستخدم الواحد</a></li>
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
                        <th align="center">تاريخ / الوقت</th>
                        <th align="center">نوع الفعل</th>
                        <th align="center">وصف</th>
                        <th align="center">اسم المستخدم</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($datas as $data)
                        <tr>
                            <td align="center">{{$data->created_at }}</td>
                            <td align="center">{{ $data->action }}</td>
                            <td align="center">{{ $data->description }}</td>
                            <td align="center">{{ $data->user->username }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        <th align="center">تاريخ / الوقت</th>
                        <th align="center">نوع الفعل</th>
                        <th align="center">وصف</th>
                        <th align="center">اسم المستخدم</th>
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