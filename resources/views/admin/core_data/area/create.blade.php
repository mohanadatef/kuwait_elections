@extends('includes.admin.master_admin')
@section('title')
    اضافه منطقه
@endsection
@section('content')
    <section class="content-header">
        <h1>
            Area
            <small>Create Area</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('/admin') }}"><i class="fa fa-dashboard"></i>لوحه التحكم</a></li>
            <li><a href="{{ url('/admin/area/index') }}"><i class="fa fa-permsissions"></i>منطقه</a></li>
            <li><a href="{{ url('/admin/area/create') }}"><i class="fa fa-permsission"></i>اضافه منطقه</a>
            </li>
        </ol>
    </section>
    <section class="content">
        <div class="box">
            <div class="box-header">
                <h3>اضافه منطقه</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <form id='create' action="{{url('admin/area/store')}}" method="POST">
                    {{csrf_field()}}
                    <div class="form-group{{ $errors->has('title') ? ' has-error' : "" }}">
                        الاسم : <input type="text" value="{{Request::old('title')}}"
                                       class="form-control" name="title" placeholder="برجاء ادخال منطقه">
                    </div>
                    <div class="form-group{{ $errors->has('country_id') ? ' has-error' : "" }}">
                        اختار البلد :
                        <select id="country" class="form-control " name="country_id">
                            <option value="0" selected>اختار البلد</option>
                            @foreach($country as  $mycountry)
                                <option value="{{$mycountry->id}}"> {{$mycountry->title}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group{{ $errors->has('city_id') ? ' has-error' : "" }}">
                        اختار البلد : <select id="city" class="form-control " name="city_id">
                            <option value="0" selected>اختار المدينه</option>
                        </select>
                    </div>
                    <div class="form-group{{ $errors->has('order') ? ' has-error' : "" }}">
                        الترتيب : <input type="number" value="{{Request::old('order')}}"
                                       class="form-control" name="order" placeholder="برجاء ادخال الترتيب">
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
    <script type="text/javascript">
        $('#country').change(function () {
            var countryID = $(this).val();
            if (countryID) {
                $.ajax({
                    type: "GET",
                    url: "{{url('Get_List_Cities_For_Country_Json')}}?country_id=" + countryID,
                    success: function (res) {
                        if (res) {
                            $("#city").empty();
                            $("#city").append('<option>اختار المدينه</option>');
                            $.each(res, function (key, value) {
                                $("#city").append('<option value="' + key + '">' + value + '</option>');
                            });
                        } else {
                            $("#city").empty();
                        }
                    }
                });
            } else {
                $("#city").empty();
            }
        });
    </script>
    {!! JsValidator::formRequest('App\Http\Requests\Admin\Core_Data\Area\CreateRequest','#create') !!}
@endsection
