@extends('includes.admin.master_admin')
@section('title')
    تعديل عن الشركه
@endsection
@section('content')
    <section class="content-header">
        <h1>
            عن الشركه
            <small>تعديل عن الشركه</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('/admin') }}"><i class="fa fa-dashboard"></i>لوحه التحكم</a></li>
            <li><a href="{{ url('/admin/about_us/index') }}"><i class="fa fa-permsissions"></i>عن الشركه</a></li>
            <li><a href="{{ url('/admin/about_us/edit/'.$data->id) }}"><i class="fa fa-permsission"></i>تعديل عن الشركه: {{$data->title }} </a></li>
        </ol>
    </section>
    <section class="content">
        <div class="box">
            <div class="box-header">
                <h3>تعديل عن الشركه: {{$data->title }} </h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <form id="edit" action="{{url('admin/about_us/update/'.$data->id)}}"
                      enctype="multipart/form-data" method="POST">
                    {{csrf_field()}}
                    {{method_field('patch')}}

                            <div class="form-group{{ $errors->has('title') ? ' has-error' : "" }}">
                                العنوان : <input type="text" id="title_en" value="{{$data->title}}"
                                                       class="form-control" name="title"
                                                       placeholder="برجاء ادخال العنوان">
                            </div>

                            <div class="form-group{{ $errors->has('description') ? ' has-error' : "" }}">
                                الوصف : <textarea type="text" id="description" class="form-control"
                                                                name="description"
                                                                placeholder="برجاء ادخال الوصف">{{$data->description}}</textarea>
                            </div>
                    <div align="center">
                        <img src="{{url('public/images/about_us').'/'.$data->image}}"
                             style="width: 100px;height: 100px">
                        <div class="form-group{{ $errors->has('image') ? ' has-error' : "" }}">
                            <table class="table">
                                <tr>
                                    <td width="40%" align="right"><label>برجاء تحميل الصوره</label></td>
                                    <td width="30"><input type="file" value="{{Request::old('image')}}" name="image"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="40%" align="right"></td>
                                    <td width="30"><span class="text-muted">jpg, png, gif</span></td>
                                </tr>
                            </table>
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
    <script>
        CKEDITOR.replace('description');
    </script>
    <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
    <script>
        tinymce.init({
            selector: 'textarea',
            height: 200,
            theme: 'modern',
            plugins: [
                'advlist autolink lists link image charmap print preview hr anchor pagebreak',
                'searchreplace wordcount visualblocks visualchars code fullscreen',
                'insertdatetime media nonbreaking save table contextmenu directionality',
                'emoticons template paste textcolor colorpicker textpattern imagetools codesample toc'
            ],
            toolbar1: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
            toolbar2: 'print preview media | forecolor backcolor emoticons | codesample styleselect fontselect fontsizeselect',
            image_advtab: true,
            templates: [
                {title: 'Test template 1', content: 'Test 1'},
                {title: 'Test template 2', content: 'Test 2'}
            ],
            content_css: [
                '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
                '//www.tinymce.com/css/codepen.min.css'
            ]
        });
    </script>
    @yield('script_description_language')
    {!! JsValidator::formRequest('App\Http\Requests\Admin\Setting\About_Us\EditRequest','#edit') !!}
@endsection