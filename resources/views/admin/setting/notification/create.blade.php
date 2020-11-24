@extends('includes.admin.master_admin')
@section('title')
    اضافه الاشعارات
@endsection
@section('content')
    <section class="content-header">
        <h1>
            الاشعارات
            <small>اضافه الاشعارات</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('/admin') }}"><i class="fa fa-dashboard"></i>لوحه التحكم</a></li>
            <li><a href="{{ url('/admin/notification/index') }}"><i class="fa fa-permsissions"></i>الاشعارات</a></li>
            <li><a href="{{ url('/admin/notification/create') }}"><i class="fa fa-permsission"></i>اضافه الاشعارات</a></li>
        </ol>
    </section>
    <section class="content">
        <div class="box">
            <div class="box-header">
                <h3>اضافه الاشعارات</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <form id='create' action="{{url('admin/notification/store')}}" enctype="multipart/form-data"
                      method="POST">
                    {{csrf_field()}}

                    <div class="form-group{{ $errors->has('details') ? ' has-error' : "" }}">
                        الوصف : <textarea type="text" class="form-control" placeholder="برجاء ادخال الوصف"
                                                name="details">{{Request::old('details')}}</textarea>
                    </div>
                    <div align="center">
                        <input type="submit" class="btn btn-primary" value="اضافه">
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
@section('script_style')
    {!! JsValidator::formRequest('App\Http\Requests\Admin\Setting\Notification\CreateRequest','#create') !!}
@endsection