<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>University Press</title>
    <link rel="stylesheet" href="admin/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="admin/assets/favicon.ico" />
    <!-- Font Awesome icons (free version)-->
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <!-- Google fonts-->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700" rel="stylesheet" type="text/css" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="admin/css/styles.css" rel="stylesheet" />
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


<body id="page-top">
    <!-- Navigation-->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav">
        <div class="container">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive"
                aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                Menu
                <i class="fas fa-bars ms-1"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav text-uppercase ms-auto py-4 py-lg-0">
                    <li class="nav-item"><a class="nav-link" href="#services">About Us</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">login</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Masthead-->
    <header class="masthead">
        <div class="container">
            <div class="masthead-subheading">Welcome To</div>
            <div class="masthead-heading text-uppercase">University Press</div>
            <a class="btn btn-primary btn-xl text-uppercase" href="#services">Tell Me More</a>
            <br><br><br>
            <div class="card-body">
                <div class="row mx-auto justify-content-center">
                    <div class="form-group col-2 text-center">
                        <select class="form-control select2" style="width: 100%;">
                            <option disabled selected value="">Select IM</option>
                            <option>Alabama</option>
                            <option>Alaska</option>
                            <option>California</option>
                            <option>Delaware</option>
                            <option>Tennessee</option>
                            <option>Texas</option>
                            <option>Washington</option>
                        </select>
                    </div>

                    <div class="form-group col-2 text-center">
                        <select class="form-control select2" style="width: 100%;">
                            <option disabled selected value="">Select Batch</option>
                            <option>Alabama</option>
                            <option>Alaska</option>
                            <option>California</option>
                            <option>Delaware</option>
                            <option>Tennessee</option>
                            <option>Texas</option>
                            <option>Washington</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </header>




    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="admin/js/scripts.js"></script>
    <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
    <!-- * *                               SB Forms JS                               * *-->
    <!-- * * Activate your form at https://startbootstrap.com/solution/contact-forms * *-->
    <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * -->
    <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
</body>

</html>