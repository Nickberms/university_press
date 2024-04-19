<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>University Press</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="icon" href="images/cmu_press_logo.png" type="image/png">
    <style>
    @import url('https://fonts.googleapis.com/css2?family=Nunito:wght@200;300;400;600;700&display=swap');
    * {
        font-family: 'Roboto', sans-serif;
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        text-decoration: none;
        transition: .2s linear;
    }
    section {
        padding: 2rem 18%;
    }
    .header {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1rem 9%;
        z-index: 1;
        background: #FFFFFF;
        box-shadow: 0px 2px 4px rgba(0, 73, 30);
    }
    .header .logo span {
        margin-left: 0.5rem;
        font-weight: bold;
        display: inline-block;
        vertical-align: middle;
        color: #00491E;
        font-size: 1.5rem;
    }
    .header .navbar #Close {
        display: none;
        position: absolute;
        top: 4rem;
        right: 2rem;
        cursor: pointer;
        font-size: 3rem;
        color: #000000;
    }
    .header .navbar a {
        font-size: 1.3rem;
        margin-right: 2rem;
        color: #00491E;
    }
    .header .navbar a:hover {
        color: #FFC600;
    }
    .header #Menu {
        display: none;
        cursor: pointer;
        font-size: 2.5rem;
        color: #000000;
    }
    .home {
        display: flex;
        margin-top: 1rem;
        flex-wrap: wrap;
        gap: 1.5rem;
        min-height: 100vh;
        align-items: center;
        justify-content: center;
        background: #E9ECEF;
    }
    .home .content {
        flex: 1 1 40rem;
        padding-top: 6.5rem;
    }
    .home #content .title {
        font-size: 4rem;
        color: #00491E;
        padding-top: 3rem;
    }
    .home #content .title span {
        color: #919F02;
    }
    .home #content .description {
        font-size: 1.5rem;
        font-weight: lighter;
        color: #00491E;
    }
    .home #content .btn {
        margin-top: 3rem;
        display: inline-block;
        padding: .9rem 3rem;
        font-size: 1.5rem;
        color: #FFFFFF;
        background: #02681E;
        cursor: pointer;
    }
    .home .image {
        flex: 1 1 40rem;
    }
    .about_us {
        display: flex;
        flex-wrap: wrap;
        min-height: 100vh;
        align-items: center;
        justify-content: center;
        background: #FFFFFF;
    }
    .about_us #content .title {
        font-size: 3rem;
        color: #00491E;
    }
    .about_us #content .title span {
        color: #919F02;
    }
    .about_us #content .description {
        font-size: 1rem;
        font-weight: 500;
        line-height: 1.8;
        padding: 0.5rem 0;
        color: #00491E;
        text-align: justify;
        letter-spacing: -0.5px;
    }
    .aims {
        display: flex;
        flex-wrap: wrap;
        min-height: 70vh;
        align-items: center;
        justify-content: center;
        background: #E9ECEF;
    }
    .aims #content .title {
        font-size: 3rem;
        color: #00491E;
    }
    .aims #content .title span {
        color: #919F02;
    }
    .aims #content .description {
        font-size: 1rem;
        font-weight: 500;
        line-height: 1.8;
        padding: 0.5rem 0;
        color: #00491E;
        text-align: justify;
        letter-spacing: -0.5px;
    }
    @media (max-width:991px) {
        html {
            font-size: 55%;
        }
        .header {
            padding: 2rem;
        }
        section {
            padding: 2rem;
        }
    }
    @media (max-width:768px) {
        .header .navbar {
            position: fixed;
            top: 0;
            right: -105%;
            width: 30rem;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(50px);
            transform: .5s;
            height: 100%;
            display: flex;
            flex-flow: column;
            justify-content: center;
            z-index: 1200;
        }
        .header .navbar.active {
            right: 0;
        }
        .header .navbar #Close {
            display: block;
        }
        .header .navbar a {
            display: block;
            margin: 1rem 0;
            text-align: center;
            font-size: 3rem;
        }
        .header #Menu {
            display: inline-block;
        }
        .home .content {
            padding-top: 9.5rem;
        }
        .home .content .title {
            font-size: 4rem;
        }
        .home .image .img {
            width: 368px;
        }
    }
    @media (max-width:450px) {
        html {
            font-size: 50%;
        }
    }
    </style>
</head>

<body>
    <header class="header">
        <a href="#Home" class="logo">
            <span>Central Mindanao University</span>
        </a>
        <nav class="navbar">
            <div class="fas fa-times" id="Close"></div>
            <a href="#AboutUs" class="nav_item">About Us</a>
            <a href="#Aims" class="nav_item">Aims</a>
            <a href="{{ route('login') }}" class="nav_item">Login</a>
        </nav>
        <div class="fas fa-bars" id="Menu"></div>
    </header>
    <section class="home" id="Home">
        <div id="content">
            <h1 class="title">UNIVERSITY <span>PRESS</span></h1>
            <p class="description">The Official Inventory Management System of the University Press Office</p>
            <a href="{{ route('login') }}" class="btn">Login</a>
        </div>
        <img src="{{ asset('images/cmu_press_logo.png')}}" data-speed="-3" class="move">
    </section>
    <section class="about_us" id="#AboutUs">
        <div id="content">
            <h1 class="title">ABOUT <span>US</span></h1>
            <p class="description">The University Press was first established as the Instructional Materials Development
                Center (IMDC) from 2007 until 2015, then as CMU Press from 2015 to 2023, until it eventually
                metamorphosed into what it is today.
            </p>
            <p class="description">With the approval of the Tatak CMU Manual in 2023 based on Resolution No. 147, s.
                2023, it is now known as the University Press. The IMDC used to be governed by the Instructional
                Materials Development Board (IMDB), followed by the CMU Press Board, and now the University Press Board
                (UPB).
            </p>
            <p class="description">With the primary intent to be a development arm of the University to enrich its
                academic programs by providing quality and excellent learning materials, research publications, and
                other creative works, the UPB is chaired by the University President and supervised by the Vice
                President for Research, Development, and Extension (VPRDE) as Vice Chairperson for Technical Operations.
            </p>
            <p class="description">On July 31, 2020, considering the income derived from the production and distribution
                of learning materials, the University Press was partly supervised by the VPRGMO for its financial
                operations as Vice Chairperson through BOR Resolution No. 63, s. 2020 (Appendix A). University Press’
                funds are under Cluster 6, or the Business Related Funds. The UPB is composed of twelve (12) members
                chaired by the University President, vice chaired by the VPRDE, Vice President for Academic Affairs
                (VPAA), Vice President for Resource Generation and Management (VPRGMO), Director of the Office of
                Financial Management Services (OFMS), Executive Director (ED) of the University Press, four (4) members,
                and two (2) Ex-Officio members. Furthermore, the UP ED serves as the concurrent secretary of the UPB.
            </p>
            <p class="description">The University Press uses its income to fund and facilitate its development programs
                and activities, such as trainings, seminars, and workshops for the faculty, staff, and students. It has
                expanded its operations to cater to other intellectual projects within and outside the University, such
                as forging partnerships with other Higher Education Institutions (HEIs) aiming to enhance their learning
                materials' development.
            </p>
            <p class="description">The University Press shall be the official publishing center of the University. Its
                creation is a timely representation of the state of maturity of CMU. It recognizes that instructional
                strategies, research, extension, and other intellectual outputs can indeed be coordinated by a
                centralized system.
            </p>
            <p class="description"> To sustain academic excellence, the University Press shall oversee the development,
                preparation, evaluation, production, and distribution of books, instructional materials (IMs), and other
                creative works by the faculty, students, and other stakeholders. It shall publish and disseminate these
                materials within the University, other HEIs, and to interested agencies. It envisions becoming a leading
                academic publisher in the country and the Association of Southeast Asian Nations (ASEAN) region.
            </p>
        </div>
    </section>
    <section class="aims" id="Aims">
        <div id="content">
            <h1 class="title">PRESS <span>AIMS</span></h1>
            <p class="description">The University Press supports the Central Mindanao University's academic mission by
                publishing quality instructional materials, research, extension, and other intellectual outputs of the
                faculty, students, and other stakeholders. It aims to attain the following objectives:
            </p>
            <p class="description">
                1. To facilitate development programs and activities within and outside of the University, such as
                trainings, seminars, and workshops for the faculty, staff, and students; <br>
                2. To publish peer-reviewed materials like books, lecture notes, learning guides, laboratory manuals,
                workbooks, modules, monographs, proceedings, compendia, journals, magazines, literary folios, and other
                creative works; <br>
                3. To partner with HEIs and other institutions recognized for their best publication practices; <br>
                4. To operate in a manner that sustains its growth and productivity; and <br>
                5. To help cultivate a culture of professional and creative excellence as a model for other HEIs.
            </p>
        </div>
    </section>
    <script>
    let navbar = document.querySelector('.header .navbar');
    document.querySelector('#Menu').onclick = () => {
        navbar.classList.add('active');
    };
    document.querySelector('#Close').onclick = () => {
        navbar.classList.remove('active');
    };
    document.addEventListener('mousemove', move);
    function move(e) {
        this.querySelectorAll('.move').forEach(layer => {
            const speed = layer.getAttribute('data-speed');
            const x = (window.innerWidth - e.pageX * speed) / 120;
            const y = (window.innerHeight - e.pageY * speed) / 120;
            layer.style.transform = `translateX(${x}px) translateY(${y}px)`;
        });
    }
    document.addEventListener("DOMContentLoaded", function() {
        const homeLink = document.querySelector('.logo[href="#Home"]');
        homeLink.addEventListener('click', function(event) {
            event.preventDefault();
            const homeSection = document.querySelector('.home');
            homeSection.scrollIntoView({
                behavior: 'smooth'
            });
        });
    });
    document.addEventListener("DOMContentLoaded", function() {
        const aboutUsLink = document.querySelector('.nav_item[href="#AboutUs"]');
        aboutUsLink.addEventListener('click', function(event) {
            event.preventDefault();
            const aboutUsSection = document.querySelector('.about_us');
            aboutUsSection.scrollIntoView({
                behavior: 'smooth'
            });
        });
    });
    document.addEventListener("DOMContentLoaded", function() {
        const aimsLink = document.querySelector('.nav_item[href="#Aims"]');
        aimsLink.addEventListener('click', function(event) {
            event.preventDefault();
            const aimsSection = document.querySelector('.aims');
            aimsSection.scrollIntoView({
                behavior: 'smooth'
            });
        });
    });
    document.addEventListener("DOMContentLoaded", function() {
        const aboutUsLink = document.querySelector('.btn[href="#AboutUs"]');
        aboutUsLink.addEventListener('click', function(event) {
            event.preventDefault();
            const aboutUsSection = document.querySelector('.about_us');
            aboutUsSection.scrollIntoView({
                behavior: 'smooth'
            });
        });
    });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
</body>

</html>