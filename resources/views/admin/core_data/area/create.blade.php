@extends('includes.admin.master_admin')
@section('title')
    اضافه منطقه
@endsection
@section('content')
    <section class="content-header">
        <h1>
            Area
            <small>Create Area</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('/admin') }}"><i class="fa fa-dashboard"></i>لوحه التحكم</a></li>
            <li><a href="{{ url('/admin/area/index') }}"><i class="fa fa-permsissions"></i>منطقه</a></li>
            <li><a href="{{ url('/admin/area/create') }}"><i class="fa fa-permsission"></i>اضافه منطقه</a>
            </li>
        </ol>
    </section>
    <section class="content">
        <div class="box">
            <div class="box-header">
                <h3>اضافه منطقه</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <form id='create' action="{{url('admin/area/store')}}" method="POST">
                    {{csrf_field()}}
                    <div class="form-group{{ $errors->has('title') ? ' has-error' : "" }}">
                        الاسم : <input type="text" value="{{Request::old('title')}}"
                                       class="form-control" name="title" placeholder="برجاء ادخال منطقه">
                    </div>
                    <div class="form-group{{ $errors->has('order') ? ' has-error' : "" }}">
                        الترتيب : <input type="number" value="{{Request::old('order')}}"
                                       class="form-control" name="order" placeholder="برجاء ادخال الترتيب">
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
    {!! JsValidator::formRequest('App\Http\Requests\Admin\Core_Data\Area\CreateRequest','#create') !!}
@endsection
