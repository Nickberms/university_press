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
        <a href="#home" class="logo">
            <!-- <img src="{{ asset('images/yellow.png')}}" alt=""> -->
            <span>Central Mindanao University</span>
        </a>



        <nav class="navbar">
            <div id="close" class="fas fa-times"></div>
            <a href="#about_us" class="nav_item">About Us</a>
            <a href="{{ route('login') }}" class="nav_item">Login</a>
        </nav>

        <div id="menu" class="fas fa-bars"></div>


    </header>

    <!-- Header Section ends -->

    <section class="home" id="home">
        <div id="content">
            <h1 class="title">University <span>Press</span> </h1>
            <p class="description">"CMU Press: Igniting curiosity, shaping perspectives, enriching minds."</p>
            <br><br>
            <a href="#about_us" class="btn">About Us</a>
        </div>

        <div id="image">
            <img src="{{ asset('images/cmu_press.png')}}" alt="" data-speed="-3" class="move">
        </div>
    </section>

    <section class="about_us" id="about_us">
        <div id="image">
            <img src="{{ asset('images/cmu_press.png')}}" alt="" data-speed="-3" class="move">
        </div>
        <div id="content">
            <h1 class="title">About <span>Us</span> </h1>
            <p class="description">The University Press was first established as the Instructional Materials Development
                Center (IMDC) from 2007 until 2015, then as CMU Press from 2015 to 2023 until it eventually
                metamorphosed into what it is today. </p>
            <p class="description">With the approval of the Tatak CMU Manual on 2023 based on Resolution No. 147, s.
                2023, it is now known as the University Press. The IMDC used to be governed by the Instructional
                Materials Development Board (IMDB), followed by the CMU Press Board, and now the University Press Board
                (UPB).</p>
            <p class="description">With the primary intent to be a development arm of the University to enrich its
                academic programs by having quality and excellent learning materials, research publications, and other
                creative works, the UPB is chaired by the University President and supervised by the Vice-President for
                Research, Development and Extension (VPRDE) as Vice Chairperson for Technical Operations.</p>
            <p class="description">On July 31, 2020, considering the income derived from the production and distribution
                of learning materials, the University Press is partly supervised by the VPRGMO for its financial
                operations as Vice Chairperson through BOR Resolution No.63, s. 2020 (Appendix A). University Press’
                funds are under Cluster 6 or the Business Related Funds.
                The UPB is composed of twelve (12) members chaired by the University President, vice-chaired by the
                VPRDE, Vice President for Academic Affairs (VPAA), and Vice President for Resource Generation and
                Management (VPRGMO), Director of the Office of the Financial Management Services (OFMS), Executive
                Director (ED) of the University Press, four (4) members, and two (2) Ex-Officio members. Further, the UP
                ED serves as the concurrent secretary of the UPB.
            </p>
            <p class="description">The University Press uses its income to fund and facilitate its development programs
                and activities, such as trainings, seminars, and workshops for the faculty, staff, and students. It has
                expanded its operations to cater to other intellectual projects within and outside the University, such
                as forging partnerships with other Higher Education Institutions (HEIs) that aim to capacitate their
                learning materials development.</p>
            <p class="description">The University Press shall be the official publishing center of the University. Its
                creation is a timely representation of the state of maturity of CMU. It recognizes that indeed
                instructional strategies, research, extension, and other intellectual outputs, be coordinated by a
                centralized system.</p>
            <p class="description">To sustain academic excellence, the University Press shall oversee the development,
                such as preparation, evaluation, production, and distribution of books, instructional materials (IMs),
                and other creative works by the faculty, students, and other stakeholders. It shall publish and
                disseminate these materials within the University, other HEIs, and to interested agencies. It envisions
                becoming a leading academic publisher in the country and the Association of Southeast Asian Nations
                (ASEAN) region.</p>


        </div>
    </section>




    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>

    <script src="{{ asset('js/landing_page.js') }}"></script>
</body>

</html>