@extends('includes.admin.master_admin')
@section('title')
    تعديل الاعددات
@endsection
@section('content')
    <section class="content-header">
        <h1>
            الاعدادت
            <small>تعديل الاعدادت</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('/admin') }}"><i class="fa fa-dashboard"></i>لوحه التحكم</a></li>
            <li><a href="{{ url('/admin/setting/index') }}"><i class="fa fa-permsissions"></i>الاعدادت</a></li>
            <li><a href="{{ url('/admin/setting/edit/'.$data->id) }}"><i class="fa fa-permsission"></i>تعديل الاعدادت: {{$data->title }} </a></li>
        </ol>
    </section>
    <section class="content">
        <div class="box">
            <div class="box-header">
                <h3>تعديل الاعدادات: {{$data->title }}</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <form id="edit" action="{{url('admin/setting/update/'.$data->id)}}"
                      enctype="multipart/form-data" method="POST">
                    {{csrf_field()}}
                    {{method_field('patch')}}

                            <div class="form-group{{ $errors->has('title_ar') ? ' has-error' : "" }}">
                                الاسم : <input type="text" id="title" value="{{$data->title}}"
                                                      class="form-control" name="title"
                                                      placeholder="برجاء ادخال الاسم">
                            </div>

                    <div class="form-group{{ $errors->has('facebook') ? ' has-error' : "" }}">
                        الفيس بوك : <input type="text" value="{{$data->facebook}}" class="form-control" name="facebook"
                                          placeholder="برجاء ادخال الفيس بوك">
                    </div>
                    <div class="form-group{{ $errors->has('youtube') ? ' has-error' : "" }}">
                        اليوتيوب : <input type="text" value="{{$data->youtube}}" class="form-control" name="youtube"
                                         placeholder="برجاء ادخال اليوتيوب">
                    </div>
                    <div class="form-group{{ $errors->has('twitter') ? ' has-error' : "" }}">
                        تويتر : <input type="text" value="{{$data->twitter}}" class="form-control" name="twitter"
                                         placeholder="برجاء ادخال تويتر">
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <img src="{{url('public/images/setting').'/'.$data->image}}" style="width:100px;height: 100px">
                            <div class="form-group{{ $errors->has('image') ? ' has-error' : "" }}">
                                <table class="table">
                                    <tr>
                                        <td width="40%" align="right"><label>برجاء تحميل صوره الموقع</label></td>
                                        <td width="30"><input type="file" value="{{Request::old('image')}}"
                                                              name="image"/></td>
                                    </tr>
                                    <tr>
                                        <td width="40%" align="right"></td>
                                        <td width="30"><span class="text-muted">jpg, png, gif</span></td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <img src="{{url('public/images/setting').'/'.$data->logo}}" style="width:100px;height: 100px">
                            <div class="form-group{{ $errors->has('logo') ? ' has-error' : "" }}">
                                <table class="table">
                                    <tr>
                                        <td width="40%" align="right"><label>برجاء ادخال الشعار الموقع</label></td>
                                        <td width="30"><input type="file" value="{{Request::old('logo')}}" name="logo"/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="40%" align="right"></td>
                                        <td width="30"><span class="text-muted">jpg, png, gif</span></td>
                                    </tr>
                                </table>
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
    {!! JsValidator::formRequest('App\Http\Requests\Admin\Setting\Setting\EditRequest','#edit') !!}
@endsection