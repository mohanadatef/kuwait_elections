<!DOCTYPE html>
<html>
<head>
    @include('includes.admin.head')
    @yield('head_style')
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
    @include('includes.admin.header')
    @include('includes.admin.main-sidebar')
    <div class="content-wrapper">
        @include('includes.admin.error')
        @yield('content')
    </div>
    @include('includes.admin.footer')
    @include('includes.admin.setting_header')
    {{-- <div class="control-sidebar-bg"></div>--}}
</div>
@include('includes.admin.script')

@yield('script_style')
</body>
</html>
