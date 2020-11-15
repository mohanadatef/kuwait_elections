@extends('includes.admin.master_admin')
@section('title')
    اضافه مدينه
@endsection
@section('content')
    <section class="content-header">
        <h1>
            المدن
            <small>اضافه مدينه</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('/admin') }}"><i class="fa fa-dashboard"></i>لوحه التحكم</a></li>
            <li><a href="{{ url('/admin/city/index') }}"><i class="fa fa-permsissions"></i>المدن</a></li>
            <li><a href="{{ url('/admin/city/create') }}"><i class="fa fa-permsission"></i>اضافه مدينه</a>
            </li>
        </ol>
    </section>
    <section class="content">
        <div class="box">
            <div class="box-header">
                <h3>اضافه مدينه</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <form id='create' action="{{url('admin/city/store')}}" method="POST">
                    {{csrf_field()}}
                    <div class="form-group{{ $errors->has('title') ? ' has-error' : "" }}">
                        الاسم : <input type="text" value="{{Request::old('title')}}"
                                         class="form-control" name="title" placeholder="برجاء ادخال الاسم">
                    </div>
                    <div class="form-group{{ $errors->has('country_id') ? ' has-error' : "" }}">
                        اختار البلد :
                        <select id="country"  class="form-control"  name="country_id">
                            <option value="0" selected>اختار البلد</option>
                            @foreach($country as  $mycountry)
                                <option value="{{$mycountry->id}}"> {{$mycountry->title}}</option>
                            @endforeach
                        </select>
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
    {!! JsValidator::formRequest('App\Http\Requests\Admin\Core_Data\City\CreateRequest','#create') !!}
@endsection