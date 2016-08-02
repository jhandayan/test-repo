<!DOCTYPE html>
<html lang="en">
<head>
    <title>Fox River Robo @yield('title')</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ asset('css/font-awesome-4.5.0/css/font-awesome.min.css')  }}">
    <link rel="stylesheet" href="{{ asset('css/app.css')  }}">
    <link rel="stylesheet" href="{{ asset('css/normalize.css')  }}">
    <link rel="stylesheet" href="{{ asset('css/main.css')  }}">
    <link rel="stylesheet" media="screen" href="{{ asset('admin/css/bootstrap-theme.min.css') }}">

    <!-- Bootstrap Admin Theme -->
    <link rel="stylesheet" media="screen" href="{{ asset('admin/css/bootstrap-admin-theme.css') }}">
    @yield('styles')
    <script src="{{ asset('js/lib/modernizr-2.6.2.min.js') }}"></script>
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script type="text/javascript" src="{{ asset('admin/js/html5shiv.js') }}"></script>
    <script type="text/javascript" src="{{ asset('admin/js/respond.min.js') }}"></script>
    <![endif]-->
</head>
<body class="bootstrap-admin-with-small-navbar">
<div class="container">
    <div class="row">
        <div class="col-md-12">
            @yield('content')
        </div>

    </div>
</div>


{{--    <script src="{{ asset('js/lib/jquery-1.9.1.min.js') }}"></script>--}}
<script src="{{ asset('js/lib/jquery-1.10.2.min.js') }}"></script>
<script src="{{ asset('js/lib/jquery-ui.1.10.3.min.js') }}"></script>

<script src="{{ asset('js/all.js') }}"></script>
<script type="text/javascript" src="{{ asset('admin/js/twitter-bootstrap-hover-dropdown.min.js') }}"></script>
@yield('scripts')
</body>