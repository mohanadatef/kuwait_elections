@extends('includes.admin.master_admin')
@section('title')
    قائمه اتصل بنا
@endsection
@section('head_style')
    @include('includes.admin.header_datatable')
@endsection
@section('content')
    <section class="content-header">
        <h1>
            اتصل بنا
            <small>كل اتصل بنا</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('/admin') }}"><i class="fa fa-dashboard"></i>لوحه التحكم</a></li>
            <li><a href="{{ url('/admin/contact_us/index') }}"><i class="fa fa-permissions"></i>اتصل بنا</a></li>
        </ol>
    </section>
    <section class="content">
            <div class="box">
                <div class="box-header" align="right">
                    @permission('contact-us-create')
                    @if($datas->count() == 0)
                        <a href="{{  url('/admin/contact_us/create') }}" class="btn btn-primary">اضافه</a>
                    @endif
                    @endpermission
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    @if(count($datas) > 0)
                        <div align="center" class="col-md-12 table-responsive">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th align="center">البريد الالكتروني</th>
                                    <th align="center">عنوان</th>
                                    <th align="center">اوقات العمل</th>
                                    <th align="center">الهاتف </th>
                                    <th align="center">التحكم</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($datas as $data)
                                    <tr>
                                        <td align="center">{{ $data->email }}</td>
                                        <td align="center">{{ $data->address }}</td>
                                        <td align="center">{{ $data->time_work }}</td>
                                        <td align="center">{{ $data->phone }}</td>
                                        <td align="center">
                                            @permission('contact-us-edit')
                                            <a href="{{ url('/admin/contact_us/edit/'.$data->id)}}"><i class="btn btn-sm btn-primary ace-icon fa fa-edit bigger-120  edit" data-id=""> تعديل</i></a>
                                            @endpermission

                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th align="center">البريد الالكتروني</th>
                                    <th align="center">عنوان</th>
                                    <th align="center">اوقات العمل</th>
                                    <th align="center">الهاتف </th>
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