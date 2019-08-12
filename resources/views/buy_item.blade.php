<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Dashboard &mdash; Wallet</title>

    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{asset('modules/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('modules/fontawesome/css/all.min.css')}}">

    <!-- CSS Libraries -->

    <!-- sweet alert -->
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{asset('css/dashboard/style.css')}}">
    <link rel="stylesheet" href="{{asset('css/dashboard/components.css')}}">
    <!-- Start GA -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-94034622-3"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-94034622-3');
</script>
    <!-- /END GA -->
</head>

<body>
    <center>
        <div class="col-md-6 col-lg-6">
            <form method="POST" action="{{action('SellerController@buy')}}" enctype="multipart/form-data" class="mt-5">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h4>Buy Item Warung</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fas fa-drumstick-bite"></i></div>
                                </div>
                                <input type="number" class="form-control" id="inlineFormInputGroup" name="invQty" placeholder="Jumlah barang yang ingin dibeli" required>
                            </div>
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="far fa-credit-card"></i></div>
                                </div>
                                <input type="number" class="form-control" id="inlineFormInputGroup" name="fromUserId" placeholder="Scan kartu" required>
                            </div>
                            <div class="input-group mb-2">
                                
                                <input type="hidden" class="form-control" id="inlineFormInputGroup" name="toUserId" value="{{Auth::user()->id}}" required>
                                <input type="hidden" class="form-control" id="inlineFormInputGroup" name="transactionType" value="3" required>
                                <input type="hidden" class="form-control" id="inlineFormInputGroup" name="invId" value="{{$seller->id}}" required>
                                <input type="hidden" class="form-control" id="inlineFormInputGroup" name="status" value="1" required>
                                <input type="hidden" class="form-control" id="inlineFormInputGroup" name="price" value="{{$seller->price}}" required>
                            </div>
                            <div class="input-group mb-2">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Buy</button>
                    </div>
                </div>
            </form>
        </div>
    </center>

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

    <!-- Page Specific JS File -->
    

    <!-- Template JS File -->
    <script src="{{asset('js/dashboard/scripts.js')}}"></script>
    <script src="{{asset('js/dashboard/custom.js')}}"></script>
    <!-- sweet alert -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
    @include('sweet::alert')
</body>

</html>
