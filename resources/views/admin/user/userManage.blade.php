<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard &mdash; Kanten</title>

    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{asset('modules/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('modules/fontawesome/css/all.min.css')}}">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link href='https://fonts.googleapis.com/css?family=Abel' rel='stylesheet' type='text/css'>

    <!-- CSS Libraries -->
    <!-- sweet alert -->
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">



    <!-- Template CSS -->
    <link rel="stylesheet" href="{{asset('css/dashboard/style.css')}}">
    <link rel="stylesheet" href="{{asset('css/dashboard/components.css')}}">
    <!-- Start GA -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-94034622-3"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'UA-94034622-3');

    </script>
    <!-- /END GA -->
</head>

<body>
    <div id="apps">
        <div class="main-wrapper main-wrapper-1">
            <div class="navbar-bg"></div>
            <nav class="navbar navbar-expand-lg main-navbar">
                <form action="{{action('SellerController@search')}}" class="form-inline mr-auto" method="GET">
                    <ul class="navbar-nav mr-3">
                        <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i
                                    class="fas fa-bars"></i></a></li>
                        <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i
                                    class="fas fa-search"></i></a></li>
                    </ul>
                    <div class="search-element">
                        <input class="form-control" type="search" placeholder="Search" aria-label="Search"
                            data-width="250" name="search">
                        <button class="btn" type="submit"><i class="fas fa-search"></i></button>
                        <div class="search-backdrop"></div>
                    </div>
                </form>
                <ul class="navbar-nav navbar-right">
                    <!-- <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown" class="nav-link nav-link-lg message-toggle"><i
                                class="far fa-envelope"></i></a>
                        <div class="dropdown-menu dropdown-list dropdown-menu-right">
                            <div class="dropdown-header">Messages
                                <div class="float-right">
                                    <a href="#">Mark All As Read</a>
                                </div>
                            </div>
                            <div class="dropdown-list-content dropdown-list-message">
                                {{-- Message --}}
                                <a href="#" class="dropdown-item">
                                    <div class="dropdown-item-avatar">
                                        <img alt="image" class="rounded-circle">
                                    </div>
                                    <div class="dropdown-item-desc">
                                        <b>Alfa Zulkarnain</b>
                                        <p>Exercitation ullamco laboris nisi ut aliquip ex ea commodo</p>
                                        <div class="time">Yesterday</div>
                                    </div>
                                </a>
                            </div>
                            <div class="dropdown-footer text-center">
                                <a href="#">View All <i class="fas fa-chevron-right"></i></a>
                            </div>
                        </div>
                    </li> -->
                    <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown"
                            class="nav-link notification-toggle nav-link-lg"><i class="far fa-bell"></i></a>
                        <div class="dropdown-menu dropdown-list dropdown-menu-right">
                            <div class="dropdown-header">Notifications

                            </div>
                            <div class="dropdown-list-content dropdown-list-icons">
                                {{-- Notification (Alert) --}}

                            </div>
                            <div class="dropdown-footer text-center">
                                <a href="#">View All <i class="fas fa-chevron-right"></i></a>
                            </div>
                        </div>
                    </li>
                    <li class="dropdown"><a href="#" data-toggle="dropdown"
                            class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                            <div class="d-sm-none d-lg-inline-block">Hi, {{Auth::user()->name}}</div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            @if(DB::table('user_roles')->select('userType')->where('userId',
                            Auth::user()->id)->first()->userType == 2)
                            <div class="dropdown-title">Owner id {{Auth::user()->id}}</div>
                            @endif
                            <!-- <a href="features-profile.html" class="dropdown-item has-icon">
                                <i class="far fa-user"></i> Profile
                            </a>
                            <a href="features-activities.html" class="dropdown-item has-icon">
                                <i class="fas fa-bolt"></i> Activities
                            </a>
                            <a href="features-settings.html" class="dropdown-item has-icon">
                                <i class="fas fa-cog"></i> Settings
                            </a> -->
                            <a class="dropdown-item fas fa-sign-out-alt has-icon text-danger"
                                href="{{ route('logout') }}" onclick="event.preventDefault();
                                                         document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                </ul>
            </nav>
            <div class="main-sidebar sidebar-style-2">
                <aside id="sidebar-wrapper">
                    <div class="sidebar-brand">
                        <h5 class="sidebar-brand">Kanten</h5>
                    </div>
                    <div class="sidebar-brand sidebar-brand-sm">
                        <img src="{{ url('image/logo.png') }}" alt="logo" width="30"
                            class="shadow-light rounded-circle">
                    </div>
                    <ul class="sidebar-menu">
                        <li class=><a class="nav-link" href="/inventories"><i class="fas fa-home"></i>
                                <span>Dashboard</span></a></li>
                        @if(DB::table('user_roles')->select('userType')->where('userId',
                        Auth::user()->id)->first()->userType == 2)
                        <li class=><a class="nav-link" href="{{ url('chart') }}"><i class="fas fa-chart-line"></i>
                                <span>Pendapatan</span></a></li>
                        @endif
                        @if(DB::table('user_roles')->select('userType')->where('userId',
                        Auth::user()->id)->first()->userType == 1)
                        <li class="dropdown active">
                            <a href="#" class="nav-link has-dropdown"><i class="fas fa-tasks"></i><span>Admin
                                    Manage</span></a>
                            <ul class="dropdown-menu">
                                <li class="active"><a class="nav-link" href="/users">Pelanggan</a></li>
                                <li><a class="nav-link" href="/merchants">Penjual</a></li>
                                <li><a class="nav-link" href="/stores">Warung</a></li>
                            </ul>
                        </li>
                        @endif
                    </ul>
                </aside>
            </div>

            <!-- Main Content -->
            <div class="main-content">
                <section class="section">
                    <div class="row">
                        @if(DB::table('user_roles')->select('userType')->where('userId',
                        Auth::user()->id)->first()->userType == 2)
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <div class="card card-statistic-2">
                                <div class="card-icon shadow-primary bg-primary">
                                    <b class="text-white">Rp</b>
                                </div>
                                <div class="card-wrap">
                                    <div class="card-header">
                                        <h4>Balance</h4>
                                    </div>
                                    <div class="card-body">
                                        @convert(Auth::user()->balance)
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <div class="card card-statistic-2">
                                <div class="card-stats">
                                    <div class="card-stats-title">Order Statistics
                                    </div>
                                    <div class="card-stats-items">
                                        <div class="card-stats-item">
                                            <div class="card-stats-item-count">
                                                {{\App\Transaction::where([['sender','=',Auth::user()->id]])->count()}}
                                            </div>
                                            <div class="card-stats-item-label">Berhasil</div>
                                        </div>
                                        <div class="card-stats-item">
                                            <div class="card-stats-item-count">
                                                {{\App\Transaction::where([['sender','=',Auth::user()->id]])->count()}}
                                            </div>
                                            <div class="card-stats-item-label">Dibatalkan</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-icon shadow-primary bg-primary">
                                    <i class="fas fa-archive"></i>
                                </div>
                                <div class="card-wrap">
                                    <div class="card-header">
                                        <h4>Total Orders</h4>
                                    </div>
                                    <div class="card-body">
                                        {{\App\Transaction::where([['sender','=',Auth::user()->id]])->count()}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        @if(\App\Store::where('sellerId', '=', Auth::user()->id)->first() != null)
                        <a href="{{action('SellerController@create')}}" class="float">
                            <i class="fa fa-plus my-float mt-3" style="font-size:30px;"></i>
                        </a>
                        @endif

                    </div>

                    <div class="row">
                        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                            <div class="card card-statistic-1">
                                <div class="card-icon bg-primary">
                                    <i class="far fa-user"></i>
                                </div>
                                <div class="card-wrap">
                                    <div class="card-header">
                                        <h4>Total Admin</h4>
                                    </div>
                                    <div class="card-body">
                                        {{\App\userRoles::where('userType', '=', '1')->count()}}
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                            <div class="card card-statistic-1">
                                <div class="card-icon bg-success">
                                    <i class="fas fa-user"></i>
                                </div>
                                <div class="card-wrap">
                                    <div class="card-header">
                                        <h4>Total Seller</h4>
                                    </div>
                                    <div class="card-body">
                                        {{\App\userRoles::where('userType', '=', '2')->count()}}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                            <div class="card card-statistic-1">
                                <div class="card-icon bg-success">
                                    <i class="fas fa-user"></i>
                                </div>
                                <div class="card-wrap">
                                    <div class="card-header">
                                        <h4>Total User</h4>
                                    </div>
                                    <div class="card-body">
                                        {{\App\userRoles::where('userType', '=', '3')->count()}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                            <div class="card card-statistic-1">
                                <div class="card-icon bg-success">
                                    <i class="fas fa-user"></i>
                                </div>
                                <div class="card-wrap">
                                    <div class="card-header">
                                        <h4>Total Warung</h4>
                                    </div>
                                    <div class="card-body">
                                        {{\App\Store::count()}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-lg-12">
                            <div class="container">
                                <div class="card card-statistic-2">

                                    <div class="card-wrap">
                                        <div class="card-body mb-5">
                                            <h4>Manage Pelanggan</h4>
                                        </div>
                                        <div class="card">
                                            <div class="container">
                                                <table class="table">
                                                    <thead class="thead-primary">
                                                        <tr>
                                                            <th scope="col">Nama</th>
                                                            <th scope="col">Recognizer</th>
                                                            <th scope="col">Saldo</th>
                                                            <th scope="col">Manage</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($user as $users)
                                                        <tr>
                                                            <td>{{$users->name}}</td>
                                                            <td>{{$users->recognizer}}</td>
                                                            <td>{{$users->balance}}</td>
                                                            <td><a href="{{action('UserController@edit', $users->id)}}"><button
                                                                        class="btn btn-warning float-left mr-3">Edit</button></a>
                                                                <form
                                                                    action="{{action('UserController@destroy', $users->id)}}"
                                                                    method="post">
                                                                    @csrf
                                                                    <input name="_method" type="hidden" value="DELETE">
                                                                    <button class="btn btn-danger"
                                                                        type="submit">Delete</button>
                                                                </form>
                                                            </td>

                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

            </div>
            </section>
        </div>
        <footer class="main-footer">

            <!-- <div class="footer-left">
            Copyright &copy; 2018 <div class="bullet"></div> Design By <a href="https://nauval.in/">Muhamad
                Nauval Azhar</a>
        </div>
        <div class="footer-right"> -->

    </div>
    </footer>
    </div>
    </div>

    <!-- General JS Scripts -->

    <script src="{{asset('modules/jquery.min.js')}}"></script>

    <script src="{{asset('modules/popper.js')}}"></script>
    <script src="{{asset('modules/tooltip.js')}}"></script>
    <script src="{{asset('modules/bootstrap/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('modules/nicescroll/jquery.nicescroll.min.js')}}"></script>
    <script src="{{asset('modules/moment.min.js')}}"></script>
    <script src="{{asset('js/dashboard/stisla.js')}}"></script>

    <!-- JS Libraies -->
    <!-- sweet -->


    <!-- Page Specific JS File -->
    <script src="{{asset('modules/sweetalert/sweetalert.min.js')}}"></script>

    <!-- Template JS File -->
    <script src="{{asset('js/dashboard/scripts.js')}}"></script>
    <script src="{{asset('js/dashboard/custom.js')}}"></script>

    <!-- sweet alert -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
    @include('sweet::alert')


</body>

</html>
