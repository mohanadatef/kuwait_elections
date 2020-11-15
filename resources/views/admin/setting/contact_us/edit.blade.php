@extends('includes.admin.master_admin')
@section('title')
   تعديل اتصل بنا
@endsection
@section('content')
    <section class="content-header">
        <h1>
            اتصل بنا
            <small>تعديل اتصل بنا</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('/admin') }}"><i class="fa fa-dashboard"></i>لوحه التحكم</a></li>
            <li><a href="{{ url('/admin/contact_us/index') }}"><i class="fa fa-permsissions"></i>اتصل بنا</a></li>
            <li><a href="{{ url('/admin/contact_us/edit/'.$data->id) }}"><i class="fa fa-permsission"></i>تعديل اتصل بنا: {{$data->title}} </a></li>
        </ol>
    </section>
    <section class="content">
        <div class="box">
            <div class="box-header">
                <h3>تعديل اتصل بنا: {{$data->title }} </h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <form id="edit" action="{{url('admin/contact_us/update/'.$data->id)}}" method="POST">
                    {{csrf_field()}}
                    {{method_field('patch')}}
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group{{ $errors->has('email') ? ' has-error' : "" }}">
                                البريد الالكتروني : <input type="email" class="form-control" name="email" value="{{$data->email}}"
                                               placeholder="برجاء ادخال البريد الالكتروني">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group{{ $errors->has('phone') ? ' has-error' : "" }}">
                                الهاتف : <input type="text" value="{{$data->phone}}"
                                               class="form-control" name="phone" placeholder="برجاء ادخال الهاتف">
                            </div>
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('address') ? ' has-error' : "" }}">
                        العنوان : <input type="text" value="{{$data->address}}"
                                         class="form-control" name="address" placeholder="برجاء ادخال العنوان">
                    </div>


                    <div class="form-group{{ $errors->has('time_work') ? ' has-error' : "" }}">
                        اوقات العمل : <input type="text" value="{{$data->time_work}}"
                                           class="form-control" name="time_work" placeholder="برجاء ادخال اوقات العمل">
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group{{ $errors->has('latitude') ? ' has-error' : "" }}">
                                خط العرض : <input type="text" value="{{$data->latitude}}"
                                                  class="form-control" name="latitude" placeholder="برجاء ادخال خط العرض">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group{{ $errors->has('longitude') ? ' has-error' : "" }}">
                                خط الطول : <input type="text" value="{{$data->longitude}}"
                                                   class="form-control" name="longitude"
                                                   placeholder="برجاء ادخال خط الطول">
                            </div>
                        </div>
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
    {!! JsValidator::formRequest('App\Http\Requests\Admin\Setting\Contact_Us\EditRequest','#edit') !!}
@endsection