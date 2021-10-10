<!DOCTYPE html>
<html lang="en">


<!-- Mirrored from myrathemes.com/lunoz/layouts/horizontal/auth-login.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 22 Feb 2021 21:55:28 GMT -->

<head>
    <meta charset="utf-8" />
    <title>POS Cashier</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="MyraStudio" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">

    <!-- App css -->
    <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/css/theme.min.css')}}" rel="stylesheet" type="text/css" />

</head>

<body class="bg-primary">

    <div>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="d-flex align-items-center min-vh-100">
                        <div class="w-100 d-block my-5">
                            <div class="row justify-content-center">
                                <div class="col-md-8 col-lg-5">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="text-center mb-4 mt-3">
                                                <a href="#">
                                                    <span><img src="{{ asset('storage/logos/'.\App\Models\GeneralSetting::first()?'storage/logos/'.\App\Models\GeneralSetting::first()->logo:null) }}"></span>
                                                </a>
                                            </div>
                                            @if($errors->any())
                                            <div class="alert alert-danger text-center">
                                                <p>Invalid username or password</p>
                                            </div>
                                            @endif
                                            <div class="text-center mb-4 mt-3">
                                                <h5>CASHIER</h5>
                                            </div>
                                            <form method="POST" action="{{ route('cashier.login.submit') }}">
                                                @csrf
                                                <div class="form-group">
                                                    <label for="emailaddress">Username</label>
                                                    <input class="form-control" type="text" id="username" name="username" required autofocus>
                                                </div>
                                                <div class="form-group">
                                                    <label for="password">Password</label>
                                                    <input class="form-control" type="password" required="" name="password" placeholder="" required>
                                                </div>

                                                <div class="mb-3 text-center">
                                                    <button class="btn btn-primary btn-block" type="submit"> Sign In </button>
                                                </div>
                                            </form>
                                        </div>
                                        <!-- end card-body -->
                                    </div>
                                    <!-- end card -->


                                </div>
                                <!-- end col -->
                            </div>
                            <!-- end row -->
                        </div> <!-- end .w-100 -->
                    </div> <!-- end .d-flex -->
                </div> <!-- end col-->
            </div> <!-- end row -->
        </div>
        <!-- end container -->
    </div>
    <!-- end page -->

</body>


<!-- Mirrored from myrathemes.com/lunoz/layouts/horizontal/auth-login.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 22 Feb 2021 21:55:29 GMT -->

</html>