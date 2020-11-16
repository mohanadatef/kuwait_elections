<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    @if($setting != null)
        <title>{{$setting->title}} | تسجيل الدخول</title>
    @else
        <title>CMS | Log in</title>
    @endif
    @if($setting != null)
        <link rel="icon" type="image/png" href="{{asset('public/images/setting/'.$setting->image)}}"/>
@endif
<!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{asset('public/AdminLTE/bower_components/bootstrap/dist/css/bootstrap.min.css')}}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('public/AdminLTE/bower_components/font-awesome/css/font-awesome.min.css')}}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{asset('public/AdminLTE/bower_components/Ionicons/css/ionicons.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('public/AdminLTE/dist/css/AdminLTE.min.css')}}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{asset('public/AdminLTE/plugins/iCheck/square/blue.css')}}">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
        @if($setting != null)
            <img  src="{{asset('public/images/setting/'.$setting->image)}}" style="width:100px;height: 100px"/>
            <b>{{$setting->title}}</b>
        @else
            <b>CMS</b>
        @endif
    </div>

    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">برجاء تسجيل الدخول</p>
        @include('includes.admin.error')
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group has-feedback">
                <input type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                       placeholder="البريد المستخدم"
                       id="email" name="email" value="{{ old('email') }}" required autofocus>
                @if ($errors->has('email'))
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                @endif

                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>

            <div class="form-group has-feedback">
                <input type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                       placeholder="كلمه السر" name="password" required>
                @if ($errors->has('password'))
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                @endif
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="row">
                {{-- <div class="col-xs-8">
                     <div class="checkbox icheck">
                       --}}{{--  <label>
                             <input type="checkbox"> Remember Me
                         </label>--}}{{--
                     </div>
                 </div>--}}
                <div class="col-xs-4">
                </div>
                <!-- /.col -->
                <div class="col-xs-4">
                    <button type="submit"  class="btn btn-primary btn-block btn-flat">تسجيل الدخول</button>
                </div>
                <div class="col-xs-4">
                </div>
                <!-- /.col -->
            </div>
        </form>

        {{-- <div class="social-auth-links text-center">
             <p>- OR -</p>
             <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign in using
                 Facebook</a>
             <a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Sign in using
                 Google+</a>
         </div>
         <!-- /.social-auth-links -->

         <a href="#">I forgot my password</a><br>
         <a href="register.html" class="text-center">Register a new membership</a>--}}

    </div>
    <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 3 -->
<script src="{{asset('public/AdminLTE/bower_components/jquery/dist/jquery.min.js')}}"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{asset('public/AdminLTE/bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
<!-- iCheck -->
<script src="{{asset('public/AdminLTE/plugins/iCheck/icheck.min.js')}}"></script>
<script>
    $(function () {
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' /* optional */
        });
    });
</script>
</body>
</html>
