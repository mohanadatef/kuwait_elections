@extends('includes.admin.master_admin')
@section('title')
    قائمه تغير كلمه السر
@endsection
@section('head_style')
    @include('includes.admin.header_datatable')
@endsection
@section('content')
    <section class="content-header">
        <h1>
            تغير كلمه السر
            <small>كل تغير كلمه السر</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('/admin') }}"><i class="fa fa-dashboard"></i>لوحه التحكم</a></li>
            <li><a href="{{ url('/admin/forgot_password/index') }}"><i class="fa fa-permissions"></i> قائمه تغير كلمه السر</a></li>
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
                            <th align="center">المستخدم</th>
                            <th align="center">الكود</th>
                            <th align="center">الحاله</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($datas as $data)
                            <tr>
                                <td align="center">{{ $data->created_at }}</td>
                                <td align="center">{{ $data->user->username }}</td>
                                <td align="center">{{ $data->code }}</td>
                                <td align="center"> @if($data->status == 1) تم بنجاح @elseif($data->status == 0) لم ينجح @endif</td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <th align="center">الوقت</th>
                            <th align="center">المستخدم</th>
                            <th align="center">الكود</th>
                            <th align="center">الحاله</th>
                        </tr>
                        </tfoot>
                    </table>
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
@endsection