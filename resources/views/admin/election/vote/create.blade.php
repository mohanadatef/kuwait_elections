@extends('includes.admin.master_admin')
@section('title')
    اضافه الاستبيان
@endsection
@section('content')
    <section class="content-header">
        <h1>
            قائمه الالاستبيان
            <small>اضافه الالاستبيان</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('/admin') }}"><i class="fa fa-dashboard"></i> لوحه التحكم</a></li>
            <li><a href="{{ url('/admin/vote/index') }}"><i class="fa fa-votes"></i>قائمه الالاستبيان</a></li>
            <li><a href="{{ url('/admin/vote/create') }}"><i class="fa fa-vote"></i>اضافه الاستبيان</a></li>
        </ol>
    </section>
    <section class="content">
        <div class="box">
            <div class="box-header">
                <h3>اضافه الاستبيان</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <form id="create" action="{{url('admin/vote/store')}}" method="POST">
                    {{csrf_field()}}
                    <div class="form-group{{ $errors->has('title') ? ' has-error' : "" }}">
                        الاسم : <input type="text" value="{{Request::old('title')}}" class="form-control"
                                             name="title"
                                             placeholder="برجاء ادخال الاسم ">
                    </div>
                    <div class="form-group{{ $errors->has('circle_id') ? ' has-error' : "" }}">
                        اختار الدائرة :
                        <select id="circle" class="form-control" data-placeholder="برجاء اختيار الدائرة" name="circle_id">
                            <option value="0" selected>اختار الدائرة</option>
                            @foreach($circle as  $mycircle)
                                <option value="{{$mycircle->id}}"> {{$mycircle->title}}</option>
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
    {!! JsValidator::formRequest('App\Http\Requests\Admin\Election\Vote\CreateRequest','#create') !!}
@endsection