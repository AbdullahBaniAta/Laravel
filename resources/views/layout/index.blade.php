<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="apple-touch-icon" sizes="76x76" href="./assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="./assets/img/favicon.png">

    <title>
        @yield('title')
    </title>


    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />

    <!-- Nucleo Icons -->
    <link href="{{ asset('css/nucleo-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/nucleo-svg.css') }}" rel="stylesheet" />

    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>

    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">

    <!-- CSS Files -->


    <link id="pagestyle" href="{{ asset('css/material-dashboard.css?v=3.1.0') }}" rel="stylesheet" />


    <!-- Nepcha Analytics (nepcha.com) -->
    <!-- Nepcha is a easy-to-use web analytics. No cookies and fully compliant with GDPR, CCPA and PECR. -->
    <script defer data-site="YOUR_DOMAIN_HERE" src="https://api.nepcha.com/js/nepcha-analytics.js"></script>


</head>


<body class="g-sidenav-show  bg-gray-100">


    <aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3   bg-gradient-dark" id="sidenav-main">

        <div class="sidenav-header">
            <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
            <a class="navbar-brand m-0" href=" https://demos.creative-tim.com/material-dashboard/pages/dashboard " target="_blank">
                <img src="{{ asset('storage/images/logo-ct.webp') }}" class="navbar-brand-img h-100" alt="main_logo">
                <span class="ms-1 font-weight-bold text-white">Report Dashboard</span>
            </a>
        </div>


        <hr class="horizontal light mt-0 mb-2">

        <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
            <ul class="navbar-nav">


                <li class="nav-item mt-3">
                    <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">Reports</h6>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white " href="./dashboard.html">
                        <span class="nav-link-text ms-1">POS Statements </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white " href="./dashboard.html">
                        <span class="nav-link-text ms-1">POS Statements </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white " href="./dashboard.html">
                        <span class="nav-link-text ms-1">POS Statements </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white " href="./dashboard.html">
                        <span class="nav-link-text ms-1">POS Statements </span>
                    </a>
                </li>

                <li class="nav-item mt-3">
                    <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">Account pages</h6>
                </li>

                <!-- <li class="nav-item">
                    <a class="nav-link text-white " href="./profile.html">

                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">person</i>
                        </div>

                        <span class="nav-link-text ms-1">Profile</span>
                    </a>
                </li> -->


                


                <li class="nav-item"><a class="nav-link text-white" href="{{ route('logout') }}" onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">

                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">logout</i>
                    </div>

                    <span class="nav-link-text ms-1">Sign Out</span>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST">
                    @csrf
                </form>
                </li>


            </ul>
        </div>
    </aside>

    <main class="main-content border-radius-lg ">
        <!-- Navbar -->



        <!-- End Navbar -->


        <div class="container-fluid py-4">




        </div>


    </main>


    
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <!--   Core JS Files   -->
    <script src="{{ asset('js/core/popper.min.js') }}"></script>
    <script src="{{ asset('/js/core/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/plugins/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('js/plugins/smooth-scrollbar.min.js') }}"></script>
    <script>
        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
            var options = {
                damping: '0.5'
            }
            Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }
    </script>

    <!-- Github buttons -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>


    <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="{{ asset('js/material-dashboard.min.js?v=3.1.0') }}"></script>
</body>

</html>