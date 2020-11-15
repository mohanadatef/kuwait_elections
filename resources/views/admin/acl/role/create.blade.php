@extends('includes.admin.master_admin')
@section('title')
    اضافه نوع المستخدم
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
            نوع المستخدم
            <small>اضافه نوع المستخدم</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('/admin') }}"><i class="fa fa-dashboard"></i> لوحه التحكم</a></li>
            <li><a href="{{ url('/admin/role/index') }}"><i class="fa fa-roles"></i>قائمه نوع المستخدم</a></li>
            <li><a href="{{ url('Admin') }}"><i class="fa fa-role"></i>اضافه نوع المستخدم</a></li>
        </ol>
    </section>
    <section class="content">
        <div class="box">
            <div class="box-header">
                <h3>اضافه نوع المستخدم</h3>
            </div>
            <div class="box-body">
                <form id='create' action="{{url('admin/role/store')}}"  method="POST">
                    {{csrf_field()}}
                    <div class="form-group{{ $errors->has('name') ? ' has-error' : "" }}">
                        الاسم : <input type="text" value="{{Request::old('name')}}" class="form-control" name="name"
                                      placeholder="برجاء ادخال الاسم">
                    </div>
                    <div class="form-group{{ $errors->has('display_name') ? ' has-error' : "" }}">
                        اسم العرض : <input type="text" value="{{Request::old('display_name')}}" class="form-control"
                                              name="display_name" placeholder="برجاء ادخال اسم العرض">
                    </div>
                    <div class="form-group{{ $errors->has('description') ? ' has-error' : "" }}">
                        الوصف : <textarea type="text"  class="form-control" placeholder="برجاء ادخال الوصف" name="description">{{Request::old('description')}}</textarea>
                    </div>
                    <div class="form-group{{ $errors->has('permission_id') ? ' has-error' : "" }}">
                         اختيار الاذنات :
                        <select id="permission" multiple='multiple' class="form-control"  name="permission[]">
                            @foreach($permission as  $mypermission)
                                <option value="{{$mypermission->id}}"> {{$mypermission->display_name}}</option>
                            @endforeach
                        </select>
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
    <script src="{{url('public/js/admin/jquery.multi-select.js')}}"></script>
    <script type="text/javascript">
        $('#permission').multiSelect();
    </script>
    {!! JsValidator::formRequest('App\Http\Requests\Admin\ACL\Role\CreateRequest','#create') !!}
@endsection