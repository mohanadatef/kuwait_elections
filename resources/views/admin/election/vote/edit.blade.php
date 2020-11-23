@extends('includes.admin.master_admin')
@section('title')
    تعديل الاستبيان
@endsection
@section('content')
    <section class="content-header">
        <h1>
            الاستبيان
            <small>تعديل الاستبيان</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('/admin') }}"><i class="fa fa-dashboard"></i> لوحه التحكم</a></li>
            <li><a href="{{ url('/admin/vote/index') }}"><i class="fa fa-votes"></i>قائمه الاستبيان</a></li>
            <li><a href="{{ url('/admin/vote/edit/'.$data->id) }}"><i class="fa fa-vote"></i>تعديل الاستبيان : {{$data->title}}</a></li>
        </ol>
    </section>
    <section class="content">
        <div class="box">
            <div class="box-header">
                <h3>تعديل الاستبيان  : {{$data->title}}</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <form id="edit" action="{{url('admin/vote/update/'.$data->id)}}" method="POST">
                    {{csrf_field()}}
                    {{method_field('patch')}}
                    <div class="form-group{{ $errors->has('title') ? ' has-error' : "" }}">
                        الاسم  : <input type="text" value="{{$data->title}}" class="form-control"
                                            name="title"
                                            placeholder="برجاء ادخال الاسم ">
                    </div>
                    <div class="form-group{{ $errors->has('circle_id') ? ' has-error' : "" }}">
                        اختار الدائرة :
                        <select id="circle" class="form-control" disabled="" data-placeholder="برجاء اختار الدائرة" name="circle_id">

                                <option value="{{$data->circle->id}}" > {{$data->circle->title}}</option>

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
    {!! JsValidator::formRequest('App\Http\Requests\Admin\Election\Vote\EditRequest','#edit') !!}
@endsection