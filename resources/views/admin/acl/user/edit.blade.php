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
                    <div class="form-group{{ $errors->has('civil_reference') ? ' has-error' : "" }}">
                        اسم المستخدم : <input type="text" class="form-control" name="civil_reference" value="{{$data->civil_reference}}"
                                           placeholder="برجاء ادخال اسم المستخدم">
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
                    <div class="form-group{{ $errors->has('country_id') ? ' has-error' : "" }}">
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