@extends('includes.admin.master_admin')
@section('title')
    اضافه الاستبيان
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
            قائمه الاستبيان
            <small>اضافه الاستبيان</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('/admin') }}"><i class="fa fa-dashboard"></i> لوحه التحكم</a></li>
            <li><a href="{{ url('/admin/vote/index') }}"><i class="fa fa-votes"></i>قائمه الاستبيان</a></li>
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
                    <div class="form-group{{ $errors->has('role_id') ? ' has-error' : "" }}">
                        اختار المرشحين :
                        <select id="nominee" multiple='multiple' class="form-control"  name="nominee_id[]">
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
        $('#circle').change(function () {
            var circleID = $(this).val();
            if (circleID) {
                $.ajax({
                    type: "GET",
                    url: "{{url('admin/get-nominee-list')}}?circle_id=" + circleID,
                    success: function (res) {
                        if (res) {
                            $("#nominee").empty();
                            $.each(res, function (key, value) {
                                    $("#nominee").append('<option value="' + key + '" >' + value + '</option>');
                            });
                        } else {
                            $("#nominee").empty();
                        }
                    }
                });
            } else {
                $("#nominee").empty();
            }
        });
    </script>

    <script type="text/javascript">
        $('#nominee').multiSelect();
    </script>
    {!! JsValidator::formRequest('App\Http\Requests\Admin\Election\Vote\CreateRequest','#create') !!}
@endsection