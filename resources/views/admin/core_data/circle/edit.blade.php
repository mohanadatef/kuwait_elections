@extends('includes.admin.master_admin')
@section('title')
   تعديل الدائره
@endsection
@section('content')
    <section class="content-header">
        <h1>
            الدوائر
            <small>تعديل الدائره</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('/admin') }}"><i class="fa fa-dashboard"></i>لوحه التحكم</a></li>
            <li><a href="{{ url('/admin/circle/index') }}"><i class="fa fa-permsissions"></i>الدوائر</a></li>
            <li><a href="{{ url('/admin/circle/edit/'.$data->id) }}"><i class="fa fa-permsission"></i>تعديل الدائره: {{$data->title}} </a></li>
        </ol>
    </section>
    <section class="content">
        <div class="box">
            <div class="box-header">
                <h3>تعديل الدائره: {{$data->title }} </h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <form id="edit" action="{{url('admin/circle/update/'.$data->id)}}" method="POST">
                    {{csrf_field()}}
                    {{method_field('patch')}}
                    <div class="form-group{{ $errors->has('title') ? ' has-error' : "" }}">
                        الاسم : <input type="text" value="{{$data->title}}"
                                         class="form-control" name="title" placeholder="برجاء ادخال الاسم">
                    </div>
                    <div class="form-group{{ $errors->has('order') ? ' has-error' : "" }}">
                        الترتيب : <input type="number" value="{{$data->order}}"
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
    {!! JsValidator::formRequest('App\Http\Requests\Admin\Core_Data\Circle\EditRequest','#edit') !!}
@endsection