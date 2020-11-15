@extends('includes.admin.master_admin')
@section('title')
    تعديل كلمه السر للمستخدم
@endsection
@section('head_style')
@endsection
@section('content')
    <section class="content-header">
        <h1>
            المستخدمين
            <small>تعديل كلمه السر</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('/admin') }}"><i class="fa fa-dashboard"></i> لوحه التحكم</a></li>
            <li><a href="{{ url('/admin/user/index') }}"><i class="fa fa-users"></i>قائمه المستخدمين</a></li>
            <li><a href="{{ url('/admin/user/change_password/'.$data->id) }}"><i class="fa fa-user"></i>تعديل كلمه السر للمستخدم : {{$data->username}}</a></li>
        </ol>
    </section>
    <section class="content">
        <div class="box">
            <div class="box-header">
                <h3>تعديل كلمه السر للمستخدم : {{$data->username}}</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <form id="password" action="{{url('admin/user/change_password/'.$data->id)}}" method="POST">
                    {{csrf_field()}}
                    {{method_field('patch')}}
                    <div class="form-group{{ $errors->has('password') ? ' has-error' : "" }}">
                        كلمه السر : <input type="password" value="{{Request::old('password')}}" class="form-control"
                                          name="password" placeholder="برجاء ادخال كلمه السر">
                    </div>
                    <div class="form-group">
                        تاكيد كلمه السر : <input type="password" value="{{Request::old('password')}}"
                                                       class="form-control" name="password_confirmation"
                                                       placeholder="برجاء تاكيد كلمه السر">
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
    {!! JsValidator::formRequest('App\Http\Requests\Admin\ACL\User\PasswordRequest','#password') !!}
@endsection