<!DOCTYPE html>
<html lang="en">
<head>
    <title>Test @yield('title')</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ asset('css/font-awesome-4.5.0/css/font-awesome.min.css')  }}">
    <link rel="stylesheet" href="{{ asset('css/app.css')  }}">
    <link rel="stylesheet" href="{{ asset('css/normalize.css')  }}">
    <link rel="stylesheet" href="{{ asset('css/main.css')  }}">
    @yield('styles')
    <script src="{{ asset('js/lib/modernizr-2.6.2.min.js') }}"></script>
</head>
<body>
    <nav class="navbar navbar-default navbar-static-top">
    <div class="container">
        <div class="navbar-header">

            <!-- Collapsed Hamburger -->
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <!-- Branding Image -->
            <a class="navbar-brand" href="{{ url('/') }}">
                Logo
            </a>
        </div>

        <div class="collapse navbar-collapse" id="app-navbar-collapse">
            <!-- Left Side Of Navbar -->
            <ul class="nav navbar-nav">
                <li><a href="{{ url('/') }}">Home</a></li>
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="nav navbar-nav navbar-right">
                <!-- Authentication Links -->
                @include(config('laravel-menu.views.bootstrap-items'), array('items' => $FrontMenu->roots()))
            </ul>
        </div>
    </div>
</nav>
    @yield('content')
{{--    <script src="{{ asset('js/lib/jquery-1.9.1.min.js') }}"></script>--}}
    <script src="{{ asset('js/lib/jquery-1.10.2.min.js') }}"></script>
    <script src="{{ asset('js/lib/jquery-ui.1.10.3.min.js') }}"></script>

    <script src="{{ asset('js/all.js') }}"></script>
    @yield('scripts')
</body>