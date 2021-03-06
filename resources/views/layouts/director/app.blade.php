<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TVKU | {{ $title }}</title>

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">

    <link rel="stylesheet" href="{{ asset('vendors/fontawesome/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/iconly/bold.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/simple-datatables/style.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/perfect-scrollbar/perfect-scrollbar.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/bootstrap-icons/bootstrap-icons.css') }}">

    <link rel="stylesheet" href="{{ asset('css/app-mazer.css') }}">

    <link rel="shortcut icon" href="{{ asset('img/tvku_favicon.png') }}" type="image/x-icon">
</head>

<body>
    <div id="app">
        <div id="sidebar" class="active">
            <div class="sidebar-wrapper active">
                <div class="sidebar-header py-0" style="height: 10%;">
                    <div class="d-flex justify-content-between" style="position: relative;">
                        <div class="logo"></div>
                        <div class="logo center text-center mt-4" style="position: absolute;">
                            <a href="#"><img src="{{ asset('img/tvku_logo_ori.png') }}" alt="TVKU Logo" style="width: 50%; height: 75%;"></a>
                        </div>
                        <div class="toggler">
                            <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                        </div>
                    </div>
                </div>
                <div class="sidebar-menu">
                    <ul class="menu">
                        <li class="sidebar-title">Menu</li>

                        <li class="sidebar-item {{ ($active === "index") ? 'active' : '' }}">
                            <a href="{{ route('director-index') }}" class='sidebar-link'>
                                <i class="bi bi-person-badge-fill"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        
                        <li class="sidebar-item has-sub {{ ($active === "assignment") ? 'active' : '' }}">
                            <a href="{{ route('director-show-assignments') }}" class='sidebar-link'>
                                <i class="bi bi-stack"></i>
                                <span>Penugasan</span>
                            </a>
                            <ul class="submenu">
                                <li class="submenu-item">
                                    <a href="{{ route('director-show-assignments-filtered',['approval'=>'responded']) }}">Sudah Direspon</a>
                                </li>
                                <li class="submenu-item">
                                    <a href="{{ route('director-show-assignments-filtered',['approval'=>'unresponded']) }}">Belum Direspon</a>
                                </li>
                            </ul>
                        </li>

                        {{-- <li class="sidebar-item has-sub {{ ($active === "assignment") ? 'active' : '' }}">
                            <a href="#" class='sidebar-link'>
                                <i class="bi bi-stack"></i>
                                <span>Penugasan</span>
                            </a>
                            <ul class="submenu">
                                <li class="submenu-item">
                                    <a href="{{ route('employee-show-assignments') }}">Daftar Penugasan</a>
                                </li>
                                <li class="submenu-item">
                                    <a href="{{ route('employee-pre-create-assignment') }}">Buat Penugasan</a>
                                </li>
                            </ul>
                        </li> --}}

                    </ul>
                </div>
                <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
            </div>
        </div>
        <div id="main">
            @yield('content')
            <footer>
                <div class="footer clearfix mb-0 text-muted">
                    <div class="float-end">
                        <p>2021 &copy; nathfred</p>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="{{ asset('vendors/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>

    <script src="{{ asset('vendors/fontawesome/all.min.js') }}"></script>

    <script src="{{ asset('vendors/apexcharts/apexcharts.js') }}"></script>
    <script src="{{ asset('js/pages/dashboard.js') }}"></script>

    <script src="{{ asset('vendors/sweetalert2/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('js/sweetalert2.js') }}"></script>

    {{-- SweetAlert2 New : CDN (V11) --}}
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="sweetalert2.all.min.js"></script>

    <script src="{{ asset('js/main.js') }}"></script>
</body>

</html>