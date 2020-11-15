@extends('includes.admin.master_admin')
@section('title')
    تعديل منطقه
@endsection
@section('content')
    <section class="content-header">
        <h1>
            المناطق
            <small>تعديل منطقه</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('/admin') }}"><i class="fa fa-dashboard"></i>لوحه التحكم</a></li>
            <li><a href="{{ url('/admin/area/index') }}"><i class="fa fa-permsissions"></i>المناطق</a></li>
            <li><a href="{{ url('/admin/area/edit/'.$data->id) }}"><i class="fa fa-permsission"></i>تعديل منطقه: {{$data->title}} </a></li>
        </ol>
    </section>
    <section class="content">
        <div class="box">
            <div class="box-header">
                <h3>تعديل منطقه: {{$data->title }} </h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <form id="edit" action="{{url('admin/area/update/'.$data->id)}}" method="POST">
                    {{csrf_field()}}
                    {{method_field('patch')}}
                    <div class="form-group{{ $errors->has('title') ? ' has-error' : "" }}">
                        الاسم : <input type="text" value="{{$data->title}}"
                                         class="form-control" name="title" placeholder="برجاء ادخال الاسم">
                    </div>
                    <div class="form-group{{ $errors->has('order') ? ' has-error' : "" }}">
                        الترتيب : <input type="text" value="{{$data->order}}"
                                         class="form-control" name="order" placeholder="برجاء ادخال الترتيب">
                    </div>
                    <div align="center">
                        <input type="submit" class="btn btn-primary" value="تعديل">
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
@section('script_style')
    {!! JsValidator::formRequest('App\Http\Requests\Admin\Core_Data\Area\EditRequest','#edit') !!}
@endsection