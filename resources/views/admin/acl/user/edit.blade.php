@extends('includes.admin.master_admin')
@section('title')
    تعديل المستخدم
@endsection
@section('head_style')
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="{{url('public/css/admin/multi-select.css')}}">
    <style>
        .ms-container {
            width: 25%;
        }
        li.ms-elem-selectable, .ms-selected {
            padding: 5px !important;
        }
        .ms-list {
            height: 150px !important;
        }
    </style>
@endsection
@section('content')
    <section class="content-header">
        <h1>
            المستخدمين
            <small>تعديل المستخدم</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('/admin') }}"><i class="fa fa-dashboard"></i> لوحه التحكم</a></li>
            <li><a href="{{ url('/admin/user/index') }}"><i class="fa fa-users"></i>قائمه المستخدم</a></li>
            <li><a href="{{ url('/admin/user/edit/'.$data->id) }}"><i class="fa fa-user"></i>تعديل المستخدم : {{$data->username}}</a></li>
        </ol>
    </section>
    <section class="content">
        <div class="box">
            <div class="box-header">
                <h3>تعديل المستخدم  : {{$data->username}}</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <form id="edit" action="{{url('admin/user/update/'.$data->id)}}" method="POST" enctype="multipart/form-data">
                    {{csrf_field()}}
                    {{method_field('patch')}}
                    <div class="form-group{{ $errors->has('name') ? ' has-error' : "" }}">
                        الاسم كامل : <input type="text" value="{{$data->name}}" class="form-control"
                                            name="name"
                                            placeholder="برجاء ادخال الاسم كامل">
                    </div>
                    <div class="form-group{{ $errors->has('first_name') ? ' has-error' : "" }}">
                        الاسم الاول : <input type="text" value="{{$data->first_name}}" class="form-control"
                                             name="first_name"
                                             placeholder="برجاء ادخال الاول">
                    </div>
                    <div class="form-group{{ $errors->has('second_name') ? ' has-error' : "" }}">
                        اسم الثاني : <input type="text" value="{{$data->second_name}}" class="form-control"
                                            name="second_name"
                                            placeholder="برجاء ادخال اسم الثاني">
                    </div>
                    <div class="form-group{{ $errors->has('third_name') ? ' has-error' : "" }}">
                        الاسم الثالث : <input type="text" value="{{$data->third_name}}" class="form-control"
                                              name="third_name"
                                              placeholder="برجاء ادخال الثالث">
                    </div>
                    <div class="form-group{{ $errors->has('forth_name') ? ' has-error' : "" }}">
                        اسم الرابع : <input type="text" value="{{$data->forth_name}}" class="form-control"
                                            name="forth_name"
                                            placeholder="برجاء ادخال اسم الرابع">
                    </div>
                    <div class="form-group{{ $errors->has('internal_reference') ? ' has-error' : "" }}">
                        المرجع الداخلي : <input type="text" value="{{$data->internal_reference}}" class="form-control"
                                                name="internal_reference"
                                                placeholder="برجاء ادخال المرجع الداخلي">
                    </div>
                    <div class="form-group{{ $errors->has('civil_reference') ? ' has-error' : "" }}">
                        المرجع المدني : <input type="text" value="{{$data->civil_reference}}" class="form-control"
                                               name="civil_reference"
                                               placeholder="برجاء ادخال المرجع المدني">
                    </div>
                    <div class="form-group{{ $errors->has('job') ? ' has-error' : "" }}">
                        مهنة : <input type="text" value="{{$data->job}}" class="form-control"
                                      name="job"
                                      placeholder="برجاء ادخال مهنة">
                    </div>
                    <div class="form-group{{ $errors->has('address') ? ' has-error' : "" }}">
                        عنوان : <input type="text" value="{{$data->address}}" class="form-control"
                                       name="address"
                                       placeholder="برجاء ادخال عنوان">
                    </div>
                    <div class="form-group{{ $errors->has('registration_status') ? ' has-error' : "" }}">
                        حالة التسجيل : <input type="text" value="{{$data->registration_status}}" class="form-control"
                                              name="registration_status"
                                              placeholder="برجاء ادخال حالة التسجيل">
                    </div>
                    <div class="form-group{{ $errors->has('registration_number') ? ' has-error' : "" }}">
                        رقم التسجيل : <input type="text" value="{{$data->registration_number}}" class="form-control"
                                             name="registration_number"
                                             placeholder="برجاء ادخال رقم التسجيل">
                    </div>
                    <div class="form-group{{ $errors->has('email') ? ' has-error' : "" }}">
                        البريد الإلكتروني : <input type="email" value="{{$data->email}}" class="form-control"
                                                   name="email"
                                                   placeholder="برجاء ادخال البريد الإلكتروني">
                    </div>
                    <div class="form-group{{ $errors->has('mobile') ? ' has-error' : "" }}">
                        التليفون المحمول : <input type="text" value="{{$data->mobile}}" class="form-control"
                                                  name="mobile"
                                                  placeholder="برجاء ادخال التليفون المحمول">
                    </div>
                    <div class="form-group{{ $errors->has('about') ? ' has-error' : "" }}">
                        الحمله الانتخابيه : <input type="text" value="{{$data->about}}" class="form-control"
                                                   name="about"
                                                   placeholder="برجاء ادخال الحمله الانتخابيه">
                    </div>
                    <div class="form-group{{ $errors->has('image') ? ' has-error' : "" }}">
                        <table class="table">
                            <tr>
                                <td width="40%" align="right"><label>برجاء تحميل صوره</label></td>
                                <td width="30"><input type="file" value="{{Request::old('image')}}" name="image"/></td>
                            </tr>
                            <tr>
                                <td width="40%" align="right"></td>
                                <td width="30"><span class="text-muted">jpg, png, gif</span></td>
                            </tr>
                        </table>
                    </div>
                    <div class="form-group{{ $errors->has('circle_id') ? ' has-error' : "" }}">
                        اختار الدائرة :
                        <select id="circle" class="form-control" data-placeholder="برجاء اختار الدائرة" name="circle_id">
                            <option value="0" selected>اختار الدائرة</option>
                            @foreach($circle as  $mycircle)
                                <option value="{{$mycircle->id}}" @if($mycircle->id == $data->circle_id)selected @endif > {{$mycircle->title}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group{{ $errors->has('area_id') ? ' has-error' : "" }}">
                        اختار المنطقه : <select id="area" class="form-control" data-placeholder=" برجاء اختار المنطقه " name="area_id">
                            @foreach($area as  $myarea)
                                <option value="{{$myarea->id}}" @if($myarea->id == $data->area_id)selected @endif > {{$myarea->title}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group{{ $errors->has('role_id') ? ' has-error' : "" }}">
                        اختار نوع المستخدم :
                        <select id="role" multiple='multiple' class="form-control"  name="role_id[]">
                            @foreach($role as  $myrole)
                                <option value="{{$myrole->id}}"
                                        @foreach($role_user as  $myrole_user) @if($myrole_user->role_id ==$myrole->id)){
                                        selected } @else{ }@endif @endforeach > {{$myrole->display_name}}</option>
                            @endforeach
                        </select>
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
    <script src="{{url('public/js/admin/jquery.multi-select.js')}}"></script>
    <script type="text/javascript">
        $('#role').multiSelect();
    </script>
    {!! JsValidator::formRequest('App\Http\Requests\Admin\ACL\User\EditRequest','#edit') !!}
@endsection