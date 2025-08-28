<?php
// Mencegah error '...on null' setelah migrate:fresh.
$setting = App\Models\Setting::find(1) ?? (object)['name' => 'CAFFEE_IN', 'images' => 'default.png'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Welcome to {{ $setting->name }}</title>
    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
    <link rel="icon" href="../assets/img/icon.ico" type="image/x-icon"/>

    <!-- Fonts and icons -->
    <script src="{{ asset('assets/js/plugin/webfont/webfont.min.js') }}"></script>
    <script>
        WebFont.load({
            google: {"families":["Lato:300,400,700,900"]},
            custom: {"families":["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"], urls: [ '/assets/css/fonts.min.css' ]},
            active: function() {
                sessionStorage.fonts = true;
            }
        });
    </script>

    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/atlantis2.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}">
</head>
<body>
    <div class="wrapper @auth horizontal-layout-2 @endauth">
        
        <div class="main-header" data-background-color="light-blue2">
            <div class="nav-top">
                <div class="container d-flex flex-row">
                    @auth
                    <button class="navbar-toggler sidenav-toggler ml-auto" type="button" data-toggle="collapse" data-target="collapse" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon">
                            <i class="icon-menu"></i>
                        </span>
                    </button>
                    <button class="topbar-toggler more"><i class="icon-options-vertical"></i></button>
                    @endauth
                    
                    <a href="/" class="logo d-flex align-items-center">
                        <h2 class="text-white">{{ $setting->name }}</h2>
                    </a>

                    <nav class="navbar navbar-header navbar-expand-lg p-0">
                        <div class="container-fluid p-0">
                            <ul class="navbar-nav topbar-nav ml-md-auto align-items-center">
                                @auth
                                <li class="nav-item dropdown hidden-caret">
                                    <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#" aria-expanded="false">
                                        <div class="avatar-sm">
                                            <img src="{{ $setting->images ? asset('assets/img/setting/'.$setting->images) : asset('assets/img/default-avatar.png') }}" alt="..." class="avatar-img rounded-circle">
                                        </div>
                                    </a>
                                    <ul class="dropdown-menu dropdown-user animated fadeIn">
                                        <div class="dropdown-user-scroll scrollbar-outer">
                                            <li>
                                                <div class="user-box">
                                                    <div class="avatar-lg">
                                                        <img src="{{ $setting->images ? asset('assets/img/setting/'.$setting->images) : asset('assets/img/default-avatar.png') }}" alt="image profile" class="avatar-img rounded">
                                                    </div>
                                                    <div class="u-text">
                                                        <h4>{{ Auth::user()->name }}</h4>
                                                        <p class="text-muted">{{ Auth::user()->email }}</p>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                    @csrf
                                                </form>
                                            </li>
                                        </div>
                                    </ul>
                                </li>
                                @endauth

                                @guest
                                    {{-- PERBAIKAN: Hanya tampilkan tombol Login/Register jika BUKAN halaman menu pelanggan --}}
                                    @if (!request()->is('menu/meja/*'))
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('login') }}">Login</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('register') }}">Register</a>
                                        </li>
                                    @endif
                                @endguest
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>

            @auth
            <div class="nav-bottom">
                <div class="container">
                    <h3 class="title-menu d-flex d-lg-none"> 
                        Menu 
                        <div class="close-menu"> <i class="flaticon-cross"></i></div>
                    </h3>
                    <ul class="nav page-navigation page-navigation-info bg-white">
                        
                        <li class="nav-item {{ request()->is('/') || request()->is('home') ? 'active' : '' }}">
                            <a class="nav-link" href="/">
                                <i class="link-icon icon-screen-desktop"></i>
                                <span class="menu-title">Dashboard</span>
                            </a>
                        </li>
                        
                        @if(in_array(Auth::user()->role, ['admin', 'kasir']))
                        <li class="nav-item {{ request()->is('order*') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('order.index') }}">
                                <i class="link-icon icon-basket-loaded"></i>
                                <span class="menu-title">Penjualan</span>
                            </a>
                        </li>
                        @endif

                        @if(in_array(Auth::user()->role, ['admin', 'kitchen']))
                        <li class="nav-item {{ request()->is('kitchen*') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('kitchen.index') }}">
                                <i class="link-icon icon-fire"></i>
                                <span class="menu-title">Dapur</span>
                            </a>
                        </li>
                        @endif

                        @if(Auth::user()->role == 'admin')
                        <li class="nav-item submenu {{ request()->is('category*') || request()->is('product*') || request()->is('tax*') || request()->is('tables*') || request()->is('card*') ? 'active' : '' }}">
                            <a class="nav-link" href="#">
                                <i class="link-icon icon-grid"></i>
                                <span class="menu-title">Master data</span>
                            </a>
                            <div class="navbar-dropdown animated fadeIn">
                                <ul>
                                    <li><a href="{{ route('category.index') }}">Kategori</a></li>
                                    <li><a href="{{ route('product.index') }}">Produk</a></li>
                                    <li><a href="{{ route('tax.index') }}">Pajak</a></li>
                                    <li><a href="{{ route('tables.index') }}">Meja</a></li>
                                    <li><a href="{{ route('card.index') }}">Metode Pembayaran</a></li>
                                    <li><a href="{{ route('users.index') }}">Kelola Karyawan</a></li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item {{ request()->is('report*') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('report.index') }}">
                                <i class="link-icon icon-docs"></i>
                                <span class="menu-title">Laporan</span>
                            </a>
                        </li>
                        <li class="nav-item {{ request()->is('setting*') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('setting.index') }}">
                                <i class="link-icon icon-settings"></i>
                                <span class="menu-title">Pengaturan</span>
                            </a>
                        </li>
                        @endif
                    </ul>
                </div>
            </div>
            @endauth
        </div>

        <div class="main-panel">
            @yield('content')
        </div>

        <footer class="footer">
            <div class="container">
                <div class="copyright ml-auto">
                    {{ date('Y') }}, copyright by {{ $setting->name }}
                </div>                  
            </div>
        </footer>
    </div>

    <!--   Core JS Files   -->
    <script src="{{ asset('assets/js/core/jquery.3.2.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugin/moment/moment.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugin/chart.js/chart.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugin/chart-circle/circles.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugin/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugin/bootstrap-toggle/bootstrap-toggle.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugin/jqvmap/jquery.vmap.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugin/jqvmap/maps/jquery.vmap.world.js') }}"></script>
    <script src="{{ asset('assets/js/plugin/gmaps/gmaps.js') }}"></script>
    <script src="{{ asset('assets/js/plugin/dropzone/dropzone.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugin/fullcalendar/fullcalendar.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugin/datepicker/bootstrap-datetimepicker.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugin/bootstrap-tagsinput/bootstrap-tagsinput.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugin/bootstrap-wizard/bootstrapwizard.js') }}"></script>
    <script src="{{ asset('assets/js/plugin/jquery.validate/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugin/summernote/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugin/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugin/sweetalert/sweetalert.min.js') }}"></script>
    <script src="{{ asset('assets/js/atlantis2.min.js') }}"></script>

    @stack('scripts')
    @include('sweet::alert')
    <script>
        $(document).ready(function() {
            $('#basic-datatables').DataTable({
                "scrollX": true
            });

            $('#select2').select2({
                theme: "bootstrap"
            });
            $('#datepicker').datetimepicker({
                format: 'DD/MM/YYYY',
            });
        });
    </script>
</body>
</html>
