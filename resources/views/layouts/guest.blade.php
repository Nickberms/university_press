<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('css/fontawesome.min.css') }}">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ asset('css/icheck-bootstrap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}">

    <style>
    body {
        /* Set background color to white */
        background-color: #FFFFFF;
    }

    /* Additional styles for your content */
    /* For example: */
    .custom-btn-color {
        background-color: #00491e;
        border-color: #00491e;
    }

    .custom-btn-color:hover {
        background-color: #ffc600;
        border-color: #ffc600;
    }
    </style>
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <div>
                <img src="{{ asset('images/cmu_press.png')}}" alt="Logo" style="width: 200px; height: auto;">
            </div>
            <a href="/" style="font-weight: bold; color: #00491e; text-decoration: none; font-size: 30px;">
                {{ config('app.name', 'Laravel') }}
            </a>
        </div>
        <!-- /.login-logo -->
        <div class="card">
            @yield('content')
        </div>
    </div>
    <!-- /.login-box -->

    @vite('resources/js/app.js')
    <!-- Bootstrap 4 -->
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('js/adminlte.min.js') }}" defer></script>
</body>

</html>