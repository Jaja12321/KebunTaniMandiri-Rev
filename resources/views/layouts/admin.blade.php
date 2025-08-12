<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Laravel SB Admin 2">
    <meta name="author" content="Alejandro RH">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('img/favicon.png') }}" rel="icon" type="image/png">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    @stack('css')
</head>
<body id="page-top">
<div id="wrapper">
  <ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar"
    style="background: linear-gradient(to bottom right, #1cc88a, #17a2b8); font-family: 'Poppins', sans-serif; min-height: 100vh;">

        <style>
        .sidebar-brand {
            padding-top: 24px;
            padding-bottom: 0px;
            text-align: center;
        }

        .logo-container {
            width: 150px;
            height: auto;
            margin: 0 auto 0px;
        }

        .logo-img {
            width: 100%;
            height: auto;
            object-fit: contain;
        }

        .sidebar-brand-text {
            font-size: 1.1rem;
            font-weight: 700;
            color: #ffffff;
            line-height: 1.3;
            margin-top: 6px;
        }

        .sidebar-divider {
            border-top: 1px solid rgba(255, 255, 255, 0.25);
            margin: 12px 20px;
        }

        .sidebar-heading {
            font-size: 0.75rem;
            letter-spacing: 1px;
            padding: 0 16px;
            color: rgba(255, 255, 255, 0.75);
            font-weight: 600;
            text-transform: uppercase;
            margin-top: 10px;
            margin-bottom: 4px;
        }

         .sidebar .nav-link {
    width: 70px;
    padding: 0px 0;            /* hilangkan padding samping */
    justify-content: left;   /* posisikan isi ke tengah */
    font-size: 0.75rem;
    gap: 0;
    flex-direction: column;    /* ikon di atas teks jika diperlukan */
    text-align: left;

        }

        .sidebar .nav-link i {
            min-width: 18px;
            font-size: 0.9rem;
            text-align: left;
        }

        .sidebar .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.12);
            color: #ffffff;
        }

        .sidebar .nav-link.active {
            background-color: rgba(255, 255, 255, 0.18);
            color: #ffffff;
            font-weight: 600;
        }


        #sidebarToggle {
            width: 32px;
            height: 32px;
            background-color: rgba(255, 255, 255, 0.2);
            color: white;
            font-size: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 16px auto;
            border-radius: 50%;
            border: none;
        }

        /* Collapse behavior */
        .sidebar.toggled {
            width: 80px !important;
        }

        .sidebar.toggled .logo-container,
        .sidebar.toggled .sidebar-brand-text,
        .sidebar.toggled .sidebar-heading,
        .sidebar.toggled .nav-link span {
            display: none;
        }

        .sidebar.toggled .nav-link {
            justify-content: center;
            padding: 10px 0;
        }
    </style>

    <!-- LOGO + BRAND -->
    <div class="sidebar-brand">
        <div class="logo-container">
            <img src="{{ asset('img/logoktm.png') }}" alt="Logo KTM" class="logo-img">
        </div>
        
    <!-- Spacer biar tidak nabrak -->
    <div style="height: 10px;"></div>

    <!-- DASHBOARD -->
    <li class="nav-item {{ Nav::isRoute('home') }}">
        <a class="nav-link {{ Nav::isRoute('home') ? 'active' : '' }}" href="{{ route('home') }}">
            <i class="fas fa-fw fa-home"></i>
            Dashboard
        </a>
    </li>

    <hr class="sidebar-divider">

    <!-- FITUR -->
    <div class="sidebar-heading">Menu</div>
    <li class="nav-item {{ Nav::isRoute('fitur.index') }}">
        <a class="nav-link {{ Nav::isRoute('fitur.index') ? 'active' : '' }}" href="{{ route('fitur.index') }}">
            <i class="fas fa-th-large"></i>
            Fitur
        </a>
    </li>

    <hr class="sidebar-divider">

    <!-- SETTINGS -->
    <div class="sidebar-heading">Settings</div>
    <li class="nav-item {{ Nav::isRoute('profile') }}">
        <a class="nav-link {{ Nav::isRoute('profile') ? 'active' : '' }}" href="{{ route('profile') }}">
            <i class="fas fa-fw fa-user"></i>
            Profile
        </a>
    </li>

    <li class="nav-item">
        <a href="#" class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="fas fa-sign-out-alt"></i>
            Logout
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
    </li>

    <hr class="sidebar-divider d-none d-md-block">

    <!-- TOGGLE -->
    
</ul>


    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>
     {{-- 🔷 Tambahkan Judul Halaman di Tengah --}}
    <div class="ms-3">
        <h4 class="text-gray-800 m-0 fw-bold">
            @yield('page-title', 'Dashboard')
        </h4>
    </div>

    <ul class="navbar-nav ml-auto">
        {{-- ...isi topbar kanan tetap --}}
    </ul>
   <ul class="navbar-nav ml-auto"> 
        <li class="nav-item dropdown no-arrow" style="margin-top: 20px;">
            <span class="badge badge-info p-2" style="font-size: 12px;">
                <i class="fas fa-calendar-day mr-1"></i>
                <strong>{{ \Carbon\Carbon::now()->format('l, j F Y') }}</strong>
            </span>
        </li>
        </li>
        <div class="topbar-divider d-none d-sm-block"></div>
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                @auth
                    <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ Auth::user()->name }}</span>
                @else
                    <span class="mr-2 d-none d-lg-inline text-gray-600 small">Guest</span>
                @endauth
            </a>
        </li>


    </ul>

</nav>
            <div class="container-fluid">
                @stack('notif')
                @yield('main-content')

            </div>
        </div>
        <footer class="sticky-footer bg-white">
            <div class="container my-auto">
                <div class="copyright text-center my-auto">
                </div>
            </div>
        </footer>
    </div>
</div>
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('Ready to Leave?') }}</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
            <div class="modal-footer">
                <button class="btn btn-link" type="button" data-dismiss="modal">{{ __('Cancel') }}</button>
                <a class="btn btn-danger" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{ __('Logout') }}</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>
<script src="{{ asset('js/sb-admin-2.min.js') }}"></script>
@stack('js')
<script>
const date = new Date();
const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
const currentDate = date.toLocaleDateString('id-ID', options); 
document.getElementById('currentDate').textContent = currentDate; 
</script>
<script>
function filterMenu() {
    let searchQuery = document.getElementById("topbarSearch").value.toLowerCase();
    let menuItems = document.getElementById("accordionSidebar").getElementsByTagName("li");

    for (let i = 0; i < menuItems.length; i++) {
        let menuItem = menuItems[i];
        let menuText = menuItem.textContent || menuItem.innerText;

        if (menuText.toLowerCase().indexOf(searchQuery) > -1) {
            menuItem.style.display = ""; 
        } else {
            menuItem.style.display = "none"; 
        }
    }
    <!-- Include Bootstrap 4 CSS -->
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

<!-- Include Bootstrap 4 JS (for tooltips) -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    });
</script>

</script>
</body>
</html>
