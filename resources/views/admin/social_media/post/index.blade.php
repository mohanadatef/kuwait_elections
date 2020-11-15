@extends('includes.admin.master_admin')
@section('title')
    قائمه المنشورات
@endsection
@section('head_style')
    @include('includes.admin.header_datatable')
@endsection
@section('content')
    <section class="content-header">
        <h1>
            المنشورات
            <small>كل المنشورات</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('/admin') }}"><i class="fa fa-dashboard"></i> لوحه التحكم</a></li>
            <li><a href="{{ url('/admin/post/index') }}"><i class="fa fa-users"></i>قائمه المنشورات</a></li>
        </ol>
    </section>
    <section class="content">
        <form method="get" id="status" action="{{ url('/admin/post/change_many_status')}}">
        <div class="box">
            <div class="box-header" align="right">
                @permission('post-many-status')
                <input type="submit" value="تغير الحاله" class="btn btn-primary">
                @endpermission
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                @if(count($datas) > 0)
                    <div align="center" class="col-md-12 table-responsive">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        @permission('post-many-status')
                        <th align="center">#</th>
                        @endpermission
                        <th align="center">تاريخ / الوقت</th>
                        <th align="center">المنشور</th>
                        <th align="center">الحاله</th>
                        <th align="center">اسم المستخدم</th>
                        <th align="center">اعجاب</th>
                        <th align="center">تعليق</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($datas as $data)
                        <tr>
                            @permission('post-many-status')
                            <td align="center">
                                <input type="checkbox" name="change_status[]" id="{{$data->id}}" value="{{$data->id}}">
                            </td>
                            @endpermission
                            <td align="center">{{$data->created_at }}</td>
                            <td align="center">{{ $data->details }}</td>

                            @permission('post-status')
                            <td align="center">
                                @if($data->status ==1)
                                    <a href="{{ url('/admin/post/change_status/'.$data->id)}}"><i
                                                class="btn btn-danger ace-icon fa fa-close"> غير مفعل</i></a>
                                @elseif($data->status ==0)
                                    <a href="{{ url('/admin/post/change_status/'.$data->id)}}"><i
                                                class="btn btn-primary ace-icon fa fa-check-circle"> مفعل</i></a>
                                @endif
                            </td>
                            @endpermission
                            <td align="center">{{ $data->user->username }}</td>
                            <td align="center">{{ count($data->like) }} <br> @if(count($data->like)> 0) @permission('like-index') <a href="{{ url('/admin/like/index/'.$data->id.'/post')}}"><i
                                            class="btn btn-primary"> عرض الاعجابات</i></a> @endpermission @endif</td>
                            <td align="center">{{ count($data->commit_post) }} <br> @if(count($data->commit_post)> 0) @permission('commit-post-index') <a href="{{ url('/admin/commit/post/index/'.$data->id)}}"><i
                                            class="btn btn-primary"> عرض التعليقات</i></a> @endpermission @endif </td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        @permission('post-many-status')
                        <th align="center">#</th>
                        @endpermission
                        <th align="center">تاريخ / الوقت</th>
                        <th align="center">المنشور</th>
                        @permission('post-status')
                        <th align="center">الحاله</th>
                        @endpermission
                        <th align="center">اسم المستخدم</th>
                        <th align="center">اعجاب</th>
                        <th align="center">تعليق</th>
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
    {!! JsValidator::formRequest('App\Http\Requests\Admin\Social_Media\Post\StatusEditRequest','#status') !!}
@endsection