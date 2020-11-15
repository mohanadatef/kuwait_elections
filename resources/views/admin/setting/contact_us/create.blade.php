@extends('includes.admin.master_admin')
@section('title')
    اضافه اتصل بنا
@endsection
@section('content')
    <section class="content-header">
        <h1>
            اصتل بنا
            <small>اضافه اتصل بنا</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('/admin') }}"><i class="fa fa-dashboard"></i>لوحه التحكم</a></li>
            <li><a href="{{ url('/admin/contact_us/index') }}"><i class="fa fa-permsissions"></i>اتصل بنا</a></li>
            <li><a href="{{ url('/admin/contact_us/create') }}"><i class="fa fa-permsission"></i>اضافه اتصل بنا</a>
            </li>
        </ol>
    </section>
    <section class="content">
        <div class="box">
            <div class="box-header">
                <h3>Create Contact US</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <form id='create' action="{{url('admin/contact_us/store')}}" method="POST">
                    {{csrf_field()}}
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group{{ $errors->has('email') ? ' has-error' : "" }}">
                                البريد الالكتروني : <input type="email" value="{{Request::old('email')}}" class="form-control"
                                               name="email" placeholder="برجاء ادخال البريد الالكتروني">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group{{ $errors->has('phone') ? ' has-error' : "" }}">
                                الهاتف : <input type="text" value="{{Request::old('phone')}}"
                                               class="form-control" name="phone" placeholder="برجاء ادخال الهاتف">
                            </div>
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('address') ? ' has-error' : "" }}">
                        العنوان : <input type="text" value="{{Request::old('address')}}"
                                         class="form-control" name="address" placeholder="برجاء ادخال العنوان">
                    </div>

                    <div class="form-group{{ $errors->has('time_work') ? ' has-error' : "" }}">
                        اوقات العمل : <input type="text" value="{{Request::old('time_work')}}"
                                           class="form-control" name="time_work" placeholder="برجاء ادخال اوقات العمل">
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group{{ $errors->has('latitude') ? ' has-error' : "" }}">
                                خط العرض : <input type="text" value="{{Request::old('latitude')}}"
                                                  class="form-control" name="latitude" placeholder="برجاء ادخال خط العرض">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group{{ $errors->has('longitude') ? ' has-error' : "" }}">
                                خط الطول : <input type="text" value="{{Request::old('longitude')}}"
                                                   class="form-control" name="longitude"
                                                   placeholder="برجاء ادخال خط الطول">
                            </div>
                        </div>
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
    {!! JsValidator::formRequest('App\Http\Requests\Admin\Setting\Contact_Us\CreateRequest','#create') !!}
@endsection