@extends('includes.admin.master_admin')
@section('title')
    قائمه الاذن
@endsection
@section('head_style')
    @include('includes.admin.header_datatable')
@endsection
@section('content')
    <section class="content-header">
        <h1>
            الاذن
            <small>كل الاذنات</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('/admin') }}"><i class="fa fa-dashboard"></i>لوحه التحكم</a></li>
            <li><a href="{{ url('/admin/permission/index') }}"><i class="fa fa-permissions"></i> قائمه الاذن</a></li>
        </ol>
    </section>
    <section class="content">
        <div class="box">
            <div class="box-header" align="right">
                @permission('permission-create')
                <a href="{{  url('/admin/permission/create') }}" class="btn btn-primary">اضافه</a>
                @endpermission
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                @if(count($datas) > 0)
                    <div align="center" class="col-md-12 table-responsive">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th align="center">الاسم</th>
                            <th align="center">اسم العرض</th>
                            <th align="center">وصف</th>
                            <th align="center">تحكم</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($datas as $data)
                            <tr>
                                <td align="center">{{ $data->name }}</td>
                                <td align="center">{{ $data->display_name }}</td>
                                <td align="center">{!! $data->description !!}</td>
                                <td align="center">
                                    @permission('permission-edit')
                                    <a href="{{ url('/admin/permission/edit/'.$data->id)}}"><i
                                                class="btn btn-sm btn-primary ace-icon fa fa-edit bigger-120  edit"
                                                data-id=""> تعديل</i></a>
                                    @endpermission
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <th align="center">الاسم</th>
                            <th align="center">اسم العرض</th>
                            <th align="center">وصف</th>
                            <th align="center">تحكم</th>
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