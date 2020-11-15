@extends('includes.admin.master_admin')
@section('title')
    اضافه الدائرة
@endsection
@section('content')
    <section class="content-header">
        <h1>
            الدوائر
            <small>اضافه الدائرة</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('/admin') }}"><i class="fa fa-dashboard"></i>لوحه التحكم</a></li>
            <li><a href="{{ url('/admin/circle/index') }}"><i class="fa fa-permsissions"></i>بلاد</a></li>
            <li><a href="{{ url('/admin/circle/create') }}"><i class="fa fa-permsission"></i>اضافه الدائرة</a>
            </li>
        </ol>
    </section>
    <section class="content">
        <div class="box">
            <div class="box-header">
                <h3>اضافه الدائرة</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <form id='create' action="{{url('admin/circle/store')}}" method="POST">
                    {{csrf_field()}}
                    <div class="form-group{{ $errors->has('title') ? ' has-error' : "" }}">
                        الاسم : <input type="text" value="{{Request::old('title')}}"
                                         class="form-control" name="title" placeholder="برجاء ادخال الاسم">
                    </div>
                    <div class="form-group{{ $errors->has('order') ? ' has-error' : "" }}">
                        الترتيب : <input type="number" value="{{Request::old('order')}}"
                                         class="form-control" name="order" placeholder="برجاء ادخال الترتيب">
                    </div>
                    <div align="center">
                        <input type="submit" class="btn btn-primary" value="Create">
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
@section('script_style')
    {!! JsValidator::formRequest('App\Http\Requests\Admin\Core_Data\Circle\CreateRequest','#create') !!}
@endsection