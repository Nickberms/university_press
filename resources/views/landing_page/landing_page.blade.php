<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>University Press</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <link rel="stylesheet" href="{{ asset('css/landing_page.css') }}">

</head>

<body>

    <!-- Header Section Starts -->
    <header class="header">
        <a href="#" class="logo">
            <img src="{{ asset('images/yellow.png')}}" alt="">
            <span>Central Mindanao University</span>
        </a>



        <nav class="navbar">
            <div id="close" class="fas fa-times"></div>
            <a href="{{ route('login') }}" class="nav_item">Login</a>
        </nav>

        <div id="menu" class="fas fa-bars"></div>


    </header>

    <!-- Header Section ends -->

    <section class="home">
        <div id="content">
            <h1 class="title">University <span>Press</span> </h1>
            <p class="description">"CMU Press: Igniting curiosity, shaping perspectives, enriching minds."</p>
            <br><br>
            <a href="#" class="btn">About Us</a>
        </div>

        <div id="image">
            <img src="{{ asset('images/cmu_press.png')}}" alt="" data-speed="-3" class="move">
        </div>

    </section>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>

    <script src="{{ asset('js/landing_page.js') }}"></script>
</body>

</html>