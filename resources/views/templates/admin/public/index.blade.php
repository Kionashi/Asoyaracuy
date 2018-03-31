<!DOCTYPE html>
<html>
<head>
    @include('templates.admin.master.head')
</head>
<body class="hold-transition login-page">
    
    <div class="login-box">
        <div class="login-logo" style="width: 360px;">
            <a href="{{ route('admin') }}"><img style="width: 100%;" src="{!! asset('admin/images/logo.png') !!}"></a>
        </div>
        @yield('content')
    </div>
    
    @include('templates.admin.master.script')
    @yield('custom_script')
</body>
</html>