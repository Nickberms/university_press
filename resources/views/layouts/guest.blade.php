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
        /* Set the background image using the asset helper */
        background-image: url('{{ asset('admin/image/R.jpg') }}');
        /* Ensure the image covers the entire viewport */
        background-size: cover;
        /* Center the background image */
        background-position: center;
        /* Fix the background image */
        background-attachment: fixed;
        /* Add a fallback background color in case the image is not available */
        background-color: #f1f1f1;
    }

    /* Additional styles for your content */
    /* For example: */
    .content {
        padding: 20px;
        color: #333;
    }
    </style>
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <a href="/"
                style="font-weight: bold; color: white; text-decoration: none; font-size: 24px;">{{ config('app.name', 'Laravel') }}</a>
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