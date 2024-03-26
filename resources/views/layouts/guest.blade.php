<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="{{ asset('css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/icheck-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}">
    <link rel="icon" href="images/cmu_press_logo.png" type="image/png">
    <style>
    body {
        background-color: #FFFFFF;
    }
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
                <img src="{{ asset('images/cmu_press_logo.png')}}" alt="Logo" style="width: 200px; height: auto;">
            </div>
            <a href="/" style="font-weight: bold; color: #00491e; text-decoration: none; font-size: 30px;">University
                Press</a>
        </div>
        <div class="card">
            @yield('content')
        </div>
    </div>
    @vite('resources/js/app.js')
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/adminlte.min.js') }}" defer></script>
</body>

</html>