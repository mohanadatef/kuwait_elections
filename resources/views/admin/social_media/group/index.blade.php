@extends('includes.admin.master_admin')
@section('title')
   قائمه الجروب
@endsection
@section('head_style')
    @include('includes.admin.header_datatable')
@endsection
@section('content')
    <section class="content-header">
        <h1>
         الجروب
            <small>كل الجروب</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('/admin') }}"><i class="fa fa-dashboard"></i>لوحه التحكم</a></li>
            <li><a href="{{ url('/admin/group/index') }}"><i class="fa fa-permissions"></i>الجروب</a></li>
        </ol>
    </section>
    <section class="content">
            <div class="box">
                <div class="box-header" align="right">
                    @permission('group-create')
                    <a href="{{  url('/admin/group/create') }}" class="btn btn-primary">اضافه</a>
                    @endpermission
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    @if(count($datas) > 0)
                        <div align="center" class="col-md-12 table-responsive">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th align="center">العنوان</th>
                                    <th align="center">الوصف</th>
                                    <th align="center">تحكم</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($datas as $data)
                                    <tr>
                                        <td align="center">{{ $data->title }}</td>
                                        <td align="center">{!!   $data->about !!}</td>
                                        <td align="center">
                                            @permission('group-edit')
                                            <a href="{{ url('/admin/group/edit/'.$data->id)}}"><i class="btn btn-sm btn-primary ace-icon fa fa-edit bigger-120  edit" data-id=""> تعديل</i></a>
                                            @endpermission
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th align="center">العنوان</th>
                                    <th align="center">الوصف</th>
                                    <th align="center">تحكم</th>
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