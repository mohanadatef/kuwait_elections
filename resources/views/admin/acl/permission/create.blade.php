@extends('includes.admin.master_admin')
@section('title')
    اضافه اذن
@endsection
@section('content')
    <section class="content-header">
        <h1>
            اذن
            <small>اضافه اذن</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('/admin') }}"><i class="fa fa-dashboard"></i>لوحه التحكم</a></li>
            <li><a href="{{ url('/admin/permsission/index') }}"><i class="fa fa-permsissions"></i>قائمه الاذن</a></li>
            <li><a href="{{ url('/admin/permsission/create') }}"><i class="fa fa-permsission"></i>اضافه اذن</a>
            </li>
        </ol>
    </section>
    <section class="content">
        <div class="box">
            <div class="box-header">
                <h3>اضافه اذن</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <form id="create" action="{{url('admin/permission/store')}}" method="POST">
                    {{csrf_field()}}
                    <div class="form-group{{ $errors->has('name') ? ' has-error' : "" }}">
                        الاسم : <input type="text" value="{{Request::old('name')}}" class="form-control" name="name"
                                      placeholder="ادخل اسم الاذن">
                    </div>
                    <div class="form-group{{ $errors->has('display_name') ? ' has-error' : "" }}">
                        اسم العرض : <input type="text" value="{{Request::old('display_name')}}" class="form-control"
                                              name="display_name" placeholder="برجاء ادخال اسم العرض">
                    </div>
                    <div class="form-group{{ $errors->has('description') ? ' has-error' : "" }}">
                        الوصف : <textarea type="text" class="form-control" placeholder="برجاء ادخل الوصف"
                                                name="description">{{Request::old('description')}}</textarea>
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
    {!! JsValidator::formRequest('App\Http\Requests\Admin\ACL\Permission\CreateRequest','#create') !!}
@endsection