@extends('includes.admin.master_admin')
@section('title')
    تعديل الاذن
@endsection
@section('content')
    <section class="content-header">
        <h1>
            الاذن
            <small>تعديل الاذن</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('/admin') }}"><i class="fa fa-dashboard"></i> لوحه التحكم</a></li>
            <li><a href="{{ url('/admin/permission/index') }}"><i class="fa fa-permissions"></i> قائمه الاذن</a></li>
            <li><a href="{{ url('/admin/permission/edit/'.$data->id) }}"><i class="fa fa-permission"></i>تعديل الاذن : {{$data->name}}</a></li>
        </ol>
    </section>
    <section class="content">
        <div class="box">
            <div class="box-header">
                <h3>تعديل الاسم : {{$data->name}}</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <form id="edit" action="{{url('admin/permission/update/'.$data->id)}}" method="POST">
                    {{csrf_field()}}
                    {{method_field('patch')}}
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group{{ $errors->has('name') ? ' has-error' : "" }}">
                                الاسم : <input type="text" disabled value="{{$data->name}}" class="form-control"
                                              name="name" placeholder="برجاء ادخال الاسم">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group{{ $errors->has('display_name') ? ' has-error' : "" }}">
                                اسم العرض : <input type="text" value="{{$data->display_name}}" class="form-control"
                                                      name="display_name" placeholder="برجاء ادخال اسم العرض">
                            </div>
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('description') ? ' has-error' : "" }}">
                        الوصف : <textarea type="text" id="description" class="form-control" name="description"
                                                placeholder="برجاء ادخال الوصف">{{$data->description}}</textarea>
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
    {!! JsValidator::formRequest('App\Http\Requests\Admin\ACL\Permission\EditRequest','#edit') !!}
@endsection