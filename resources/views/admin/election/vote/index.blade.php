@extends('includes.admin.master_admin')
@section('title')
    قائمه الاستبيان
@endsection
@section('head_style')
    @include('includes.admin.header_datatable')
@endsection
@section('content')
    <section class="content-header">
        <h1>
            الاستبيانين
            <small>كل الاستبيانين</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('/admin') }}"><i class="fa fa-dashboard"></i> لوحه التحكم</a></li>
            <li><a href="{{ url('/admin/vote/index') }}"><i class="fa fa-votes"></i>قائمه الاستبيانين</a></li>
        </ol>
    </section>
    <section class="content">
        <form method="get" action="{{ url('/admin/vote/change_many_status')}}">
        <div class="box">
            <div class="box-header" align="right">
                @permission('vote-create')
                <a href="{{  url('/admin/vote/create') }}" class="btn btn-primary">اضافه</a>
                @endpermission
                @permission('vote-many-status')
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
                        @permission('vote-many-status')
                        <th align="center">#</th>
                        @endpermission
                        <th align="center">اسم الاستبيان</th>
                        <th align="center">الدائرة</th>
                        @permission('vote-status')
                        <th align="center">الحاله</th>
                        @endpermission
                        <th align="center">التحكم</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($datas as $data)
                        <tr>
                            @permission('vote-many-status')
                            <td align="center">
                                        <input type="checkbox" name="change_status[]"
                                               id="{{$data->id}}" value="{{$data->id}}">

                            </td>
                            @endpermission
                            <td align="center">{{ $data->title }}</td>
                            <td align="center">{{ $data->circle->title }}</td>
                            @permission('vote-status')
                            <td align="center">
                                    @if($data->status ==1)
                                        <a href="{{ url('/admin/vote/change_status/'.$data->id)}}"><i
                                                    class="btn btn-danger ace-icon fa fa-close"> غير مفعل</i></a>
                                    @elseif($data->status ==0)
                                        <a href="{{ url('/admin/vote/change_status/'.$data->id)}}"><i
                                                    class="btn btn-primary ace-icon fa fa-check-circle"> مفعل</i></a>
                                    @endif
                            </td>
                            @endpermission
                            @permission('vote-edit')
                            <td align="center">
                                    <a href="{{ url('/admin/vote/edit/'.$data->id)}}"><i
                                                class="btn btn-primary ace-icon fa fa-edit bigger-120  edit"
                                                data-id=""> تعديل</i></a>

                            </td>
                            @endpermission
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        @permission('vote-many-status')
                        <th align="center">#</th>
                        @endpermission
                        <th align="center">اسم الاستبيان</th>
                        <th align="center">الدائرة</th>
                        @permission('vote-status')
                        <th align="center">الحاله</th>
                        @endpermission
                        <th align="center">التحكم</th>
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
    {!! JsValidator::formRequest('App\Http\Requests\Admin\Election\Vote\StatusEditRequest','#status') !!}
@endsection