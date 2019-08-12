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


    <style>
        .float {
            position: fixed;
            width: 60px;
            height: 60px;
            bottom: 40px;
            right: 40px;
            background-color: #0C9;
            color: #FFF;
            border-radius: 50px;
            text-align: center;
            z-index: 9999;
            box-shadow: 2px 2px 3px #999;
        }

        .float2 {
            position: fixed;
            width: 60px;
            height: 60px;
            bottom: 40px;
            right: 40px;
            top: 400px;
            background-color: #0C9;
            color: #FFF;
            border-radius: 50px;
            text-align: center;
            z-index: 9999;
            box-shadow: 2px 2px 3px #999;
        }


    </style>
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
                                @foreach ($notification as $notif)
                                <div href="#" class="dropdown-item">
                                    <div class="dropdown-item-icon bg-info text-white">
                                        <i class="fas fa-bell"></i>
                                    </div>
                                    <div class="dropdown-item-desc">
                                        {{$notif->name}} Telah Memesan lewat Handphone
                                        <br>
                                        Total = Rp. @convert($notif->balanceUsed)
                                        <div class="time"></div>
                                    </div>
                                </div>
                                @endforeach
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
                        <li class=active><a class="nav-link" href="/inventories"><i class="fas fa-home"></i>
                                <span>Dashboard</span></a></li>
                        @if(DB::table('user_roles')->select('userType')->where('userId',
                        Auth::user()->id)->first()->userType == 2)
                        <li class=><a class="nav-link" href="{{ url('chart') }}"><i class="fas fa-chart-line"></i>
                                <span>Pendapatan</span></a></li>
                        @endif
                        @if(DB::table('user_roles')->select('userType')->where('userId',
                        Auth::user()->id)->first()->userType == 1)
                        <li class="dropdown">
                            <a href="#" class="nav-link has-dropdown"><i class="fas fa-tasks"></i><span>Admin Manage</span></a>
                            <ul class="dropdown-menu">
                                <li><a class="nav-link" href="/users">Pelanggan</a></li>
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
                                        @convert(DB::table('seller_accounts')->select('balance')->where('sellerId',Auth::user()->id)->first()->balance)
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
                                                {{\App\Transaction::where([['recepient','=',Auth::user()->id]])->count()}}
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
                                        {{\App\Transaction::where([['recepient','=',Auth::user()->id]])->count()}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        @if(\App\Store::where('sellerId', '=', Auth::user()->id)->first() != null)
                        <a href="{{action('SellerController@create')}}" class="float">
                            <i class="fa fa-plus my-float mt-3" style="font-size:30px;"></i>
                        </a>
                        <a href="{{action('SellerController@create')}}" class="float">
                            <i class="fa fa-plus my-float mt-3" style="font-size:30px;"></i>
                        </a>
                        @endif

                    </div>


                    @switch(DB::table('user_roles')->select('userType')->where('userId',
                    Auth::user()->id)->first()->userType)
                    @case('1')
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
                        <div class="col-md-6 col-lg-6">

                            <form method="POST" action="{{action('AdminController@topUp')}}">
                                @csrf
                                @method('PATCH')
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Quick Top Up</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <div class="input-group mb-2">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text"><i class="fas fa-credit-card"></i>
                                                    </div>
                                                </div>
                                                <input type="text" class="form-control" id="inlineFormInputGroup"
                                                    name="cardId" placeholder="User Card ID" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Rp.</span>
                                                </div>
                                                <input type="number" class="form-control" name="balance"
                                                    aria-label="Amount (to the nearest dollar)" required>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Top Up</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- register card -->
                        <div class="col-md-6 col-lg-6">
                            <form method="POST" action="{{action('AdminController@create_card')}}">
                                @csrf
                                @method('PATCH')
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Register Kartu</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <div class="input-group mb-2">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text"><i class="far fa-user"></i></div>
                                                </div>
                                                <input type="text" class="form-control" id="inlineFormInputGroup"
                                                    name="recognizer" placeholder="NISN" required>
                                            </div>
                                            <div class="input-group mb-2">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text"><i class="fas fa-credit-card"></i>
                                                    </div>
                                                </div>
                                                <input type="text" class="form-control" id="inlineFormInputGroup"
                                                    name="cardId" placeholder="User Card ID" required>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Register</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-lg-6">
                            <form method="POST" action="{{action('AdminController@create_store')}}"
                                enctype="multipart/form-data">

                                @csrf
                                @method('PATCH')
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Register Warung</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <div class="input-group mb-2">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text"><i class="far fa-user"></i></div>
                                                </div>
                                                <input type="text" class="form-control" id="inlineFormInputGroup"
                                                    name="ownerId" placeholder="Owner ID" required>
                                            </div>
                                            <div class="input-group mb-2">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text"><i class="fas fa-home"></i></div>
                                                </div>
                                                <input type="text" class="form-control" id="inlineFormInputGroup"
                                                    name="shopName" placeholder="Nama Warung" required>
                                            </div>
                                            <div class="input-group mb-2">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text"><i class="fas fa-pencil-alt"></i>
                                                    </div>
                                                </div>
                                                <input type="text" class="form-control" id="inlineFormInputGroup"
                                                    name="shopDescription" placeholder="Deskripsi Warung" required>
                                            </div>
                                            <div class="input-group mb-2">
                                                <div class="input-group-prepend ">
                                                    <!-- <div class="input-group-text"><i class="fas fa-image "></i></div> -->
                                                    <div id="image-preview" class="image-preview">
                                                        <label for="image-upload" id="image-label">Upload Gambar</label>
                                                        <input type="file" name="image" id="image-upload" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Register</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    @break
                    @case('2')
                    @if(\App\Store::where('sellerId', '=', Auth::user()->id)->first() != null)
                    @foreach($inventories as $key => $inventorie)
                    @csrf
                    <label class="imagecheck mb-4">
                        <input name="validasi" type="checkbox" value="1" class="imagecheck-input"
                            data-id="{{ $inventorie->id }}" />
                        <figure class="imagecheck-figure mr-4" style="width: 18rem">
                            <div class="card float-left mr-5" style="width: 18rem;">
                                <img src="{{ url('image/item/'.$inventorie->image) }}" class="card-img-top" alt=""
                                    width="100%" height="180px"">
                            <div class=" card-body">
                                <h5 class="card-title">{{$inventorie->name}}
                                    @if($inventorie->inventoriesType == 1)
                                    (@convert(DB::table('inventories_stocks')->select('stock')->where('inventoriesId',$inventorie->id)->first()->stock))
                                    @else
                                    (unlimited)
                                    @endif
                                </h5>
                                <p class="card-text">Rp. @convert($inventorie->price)</p>
                            </div>
                            <ul class="list-group list-group-flush">

                                <li class="list-group-item">
                                    Jumlah beli <input id="edtQty{{ $key }}" type="number" name="stock" class="ml-2"
                                        data-id="{{ $inventorie->id }}" min="1">
                                </li>
                            </ul>
                            <ul class="list-group list-group-flush">
                            </ul>
                            <div class="card-body">
                                <a href="{{action('SellerController@edit', $inventorie->id)}}"
                                    class="btn btn-warning float-left mr-2">Edit</a>
                                <form action="{{action('SellerController@destroy', $inventorie->id)}}" method="post">
                                    @csrf
                                    <input name="_method" type="hidden" value="DELETE">
                                    <button class="btn btn-danger float-left" type="submit">Delete</button>
                                </form>
                                <a href="{{action('SellerController@show', $inventorie->id)}}"
                                    class="btn btn-primary float-right mr-2">Buy</a>
                            </div>
            </div>

            </figure>
            </label>

            @endforeach

        </div>
        <button id="btnSubmit" class="btn btn-success float-left float2" type="submit">
            <i class="fa fas fa-cart-plus my-float mr-3" style="font-size:35px;"></i>
        </button>
        
        @else
        <div class="alert alert-warning" role="alert">
            Anda belum Mempunyai Warung
        </div>
        @endif


    </div>




    @break
    @case('3')

    @break
    @default

    @endswitch
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

    <script>
        let csrf_token = $('meta[name="csrf-token"]').attr('content')
        let totalInventorie = {{count($inventories)}}


        let carts = new Array()

        for (let i = 0; i < totalInventorie; i++) {
            $('#edtQty' + i).keypress(function (e) {
                let key = e.which
                if (key == 13) {
                    let invId = $(this).data('id')
                    let invQty = $(this).val()
                    insertToCart(invId, invQty)
                }
            })
        }

        function insertToCart(invId, invQty) {
            carts.push({
                inv_id: invId,
                inv_qty: invQty
            })
            console.log(carts)
        }

        $('#btnSubmit').on('click', function () {
            pushToServer()
        })

        function pushToServer() {
            $.ajax({
                url: "{{ route('save.cart') }}",
                type: 'POST',
                headers: {
                    '_token': csrf_token
                },
                data: {
                    'carts': carts
                },
                success: function (response) {
                    window.location.href = "{{url('/cart')}}" + "/" + response.orderId
                }
            })
        }

    </script>
</body>

</html>
