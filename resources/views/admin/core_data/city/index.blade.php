@extends('includes.admin.master_admin')
@section('title')
    قائمه المدن
@endsection
@section('head_style')
    @include('includes.admin.header_datatable')
@endsection
@section('content')
    <section class="content-header">
        <h1>
            المدن
            <small>كل المدن</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('/admin') }}"><i class="fa fa-dashboard"></i> لوحه التحكم</a></li>
            <li><a href="{{ url('/admin/city/index') }}"><i class="fa fa-citys"></i> المدن</a></li>
        </ol>
    </section>
    <section class="content">
        <form method="get" action="{{ url('/admin/city/change_many_status')}}">
            <div class="box">
                <div class="box-header" align="right">
                    @permission('city-create')
                    <a href="{{  url('/admin/city/create') }}" class="btn btn-primary">اضافه</a>
                    @endpermission
                    @permission('city-many-status')
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
                                    @permission('city-many-status')
                                    <th align="center">#</th>
                                    @endpermission
                                    <th align="center">الاسم</th>
                                    <th align="center">البلد</th>
                                    @permission('city-status')
                                    <th align="center">الحاله</th>
                                    @endpermission
                                    @permission('city-edit')
                                    <th align="center">التحكم</th>
                                    @endpermission
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($datas as $data)
                                    <tr>
                                        <td align="center">
                                                    <input type="checkbox" name="change_status[]" id="{{$data->id}}" value="{{$data->id}}">
                                        </td>
                                        <td align="center">{{ $data->title }}</td>
                                        <td align="center">{{ $data->country->title }}</td>
                                        @permission('city-status')
                                        <td align="center">
                                                @if($data->status ==1)
                                                    <a href="{{ url('Admin'.$data->id)}}"><i
                                                                class="btn btn-danger ace-icon fa fa-close"> غير مفعل</i></a>
                                                @elseif($data->status ==0)
                                                    <a href="{{ url('/admin/city/change_status/'.$data->id)}}"><i
                                                                class="btn btn-primary ace-icon fa fa-check-circle"> مفعل</i></a>
                                                @endif
                                        </td>
                                        @endpermission
                                        @permission('city-edit')
                                        <td align="center">
                                                <a href="{{ url('/admin/city/edit/'.$data->id)}}"><i
                                                            class="btn btn-primary ace-icon fa fa-edit bigger-120  edit"
                                                            data-id=""> تعديل</i></a>
                                        </td>
                                        @endpermission
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    @permission('city-many-status')
                                    <th align="center">#</th>
                                    @endpermission
                                    <th align="center">الاسم</th>
                                    <th align="center">البلد</th>
                                    @permission('city-status')
                                    <th align="center">الحاله</th>
                                    @endpermission
                                    @permission('city-edit')
                                    <th align="center">التحكم</th>
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
    {!! JsValidator::formRequest('App\Http\Requests\Admin\Core_Data\City\StatusEditRequest','#status') !!}
@endsection