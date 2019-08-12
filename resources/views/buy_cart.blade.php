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
    <center>
        <div class="col-md-6 col-lg-6">
            <form method="POST" action="{{action('BuyController@buyCart')}}" enctype="multipart/form-data" class="mt-5">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h4>Buy Item Warung</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            @foreach($cart as $c)
                            <div class="card border-primary mb-3" style="max-width: 18rem;">
                                <div class="card-body text-primary">
                                    <h5 class="card-title">{{$c->inventoriesId}}</h5>
                                    <p class="card-text">{{$c->inventoriesQty}}x</p>
                                    <p>{{$c->balanceUsed}}</p>
                                </div>
                            </div>
                            @endforeach
                            <p>Total pembeliannya adalah {{$total[0]->total}}</p>
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="far fa-credit-card"></i></div>
                                </div>
                                <input type="number" class="form-control" id="inlineFormInputGroup" name="fromUserId"
                                    placeholder="Scan kartu" required autofocus>
                            </div>
                            <input type="hidden" class="form-control" id="inlineFormInputGroup" name="toUserId"
                                value="{{Auth::user()->id}}" required>
                            <input type="hidden" class="form-control" id="inlineFormInputGroup" name="transactionType"
                                value="3" required>
                            <input type="hidden" class="form-control" id="inlineFormInputGroup" name="status" value="1"
                                required>
                            <input type="hidden" class="form-control" id="inlineFormInputGroup" name="price"
                                value="{{$total[0]->total}}" required>
                            
                        </div>
                        <button type="submit" class="btn btn-primary">Buy</button>
                        <br>
                        <br>
                        <button onclick="onClick()" class="btn btn-warning">Print Invoice</button>
                    </div>
                </div>
            </form>
        </div>
    </center>
    <footer class="main-footer">
        <div class="footer-left">
            Copyright &copy; 2018 <div class="bullet"></div> Design By <a href="https://nauval.in/">Muhamad
                Nauval Azhar</a>
        </div>
        <div class="footer-right">

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

    <!-- Page Specific JS File -->
    <script src="https://cdn.jsdelivr.net/npm/recta/dist/recta.js"></script>
    <script type="text/javascript">
        var printer = new Recta('6718430268', '1811')

        function onClick() {
            printer.open().then(function () {
                printer.align('center')
                    .text('***  SMK TARUNA BHAKTI  ***')
                    .text('  KANTEN  ')
                    .text('---------------------------')
                printer.align('left')
                @foreach($dataReceipt as $d).text(
                    "{{$d->qty}}x - {{$d->makanan}} = Rp.{{$d->total}}") @endforeach
                    .align('right')
                    .text('Jumlah: Rp.{{$total[0]->total}}')
                    .align('center')
                    .text('---------------------------')
                    .text('{{$dataReceipt[0]->date}}')
                    .cut()
                    .print()
            })
        }

    </script>
    <!-- Template JS File -->
    <script src="{{asset('js/dashboard/scripts.js')}}"></script>
    <script src="{{asset('js/dashboard/custom.js')}}"></script>
    <!-- sweet alert -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
    @include('sweet::alert')
</body>

</html>
