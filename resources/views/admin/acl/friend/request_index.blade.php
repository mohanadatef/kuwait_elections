@extends('includes.admin.master_admin')
@section('title')
    قائمه طلبات الصداقه
@endsection
@section('head_style')
    @include('includes.admin.header_datatable')
@endsection
@section('content')
    <section class="content-header">
        <h1>
            طلبات الصداقه
            <small>كل طلبات الصداقه</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('/admin') }}"><i class="fa fa-dashboard"></i>لوحه التحكم</a></li>
            <li><a href="{{ url('/admin/friend/request') }}"><i class="fa fa-permissions"></i> قائمه طلبات الصداقه</a></li>
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
                            <th align="center">المرسل</th>
                            <th align="center">المرسل اليه</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($datas as $data)
                            <tr>
                                <td align="center">{{ $data->created_at }}</td>
                                <td align="center">{{ $data->user_send->username }}</td>
                                <td align="center">{{ $data->user_receive->username }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <th align="center">الوقت</th>
                            <th align="center">المرسل</th>
                            <th align="center">المرسل اليه</th>
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