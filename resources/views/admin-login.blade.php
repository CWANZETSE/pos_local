
<html class="no-js" lang="en">



<head>
    <base href="../">
    <meta charset="utf-8">
    <meta name="author" content="Softnio">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description"
          content="A powerful and conceptual apps base dashboard template that especially build for developers and programmers.">
    <!-- Fav Icon  -->
    <link rel="shortcut icon" href="./images/favicon.png">
    <!-- Page Title  -->
    <title>EasyPos Admin| Login</title>


    <!-- COMPONENTS -->

    <link href="https://fonts.googleapis.com/css?family=Mada:300,400,500,600,700" rel="stylesheet">
    <!-- Required Fremwork -->
    <link rel="stylesheet" type="text/css" href="{{asset('bower_components/bootstrap/css/bootstrap.min.css')}}">
    <!-- themify-icons line icon -->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/icon/themify-icons/themify-icons.css')}}">
    <!-- ico font -->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/icon/icofont/css/icofont.css')}}">
    <!-- flag icon framework css -->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/pages/flag-icon/flag-icon.min.css')}}">
    <!-- Menu-Search css -->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/pages/menu-search/css/component.css')}}">
    <!-- Syntax highlighter Prism css -->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/pages/prism/prism.css')}}">
    <!-- Style.css -->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/style.css')}}">
    <!--color css-->


    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <link rel="manifest" href="/manifest.json">

</head>

<body class="fix-menu">
<section class="login p-fixed d-flex text-center bg-secondary">
    <!-- Container-fluid starts -->
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <!-- Authentication card start -->
                <div class="login-card card-block auth-body m-auto">
                    <form method="POST" action="{{ route('admin.login.submit') }}">
                        @csrf

                        <div class="text-center">
                            @if($errors->any())
                                @foreach ($errors->all() as $error)
                                    <div class="alert alert-danger alert-icon alert-dismissible">
                                        <em class="icon ni ni-cross-circle"></em> <strong>Failed</strong>! Invalid Credentials
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <div class="auth-box">
                            <div class="row m-b-20 justify-content-center">
                                <a href="{{route('admin.home')}}" class="logo-link nk-sidebar-logo">
                                    <img src="{{ asset('storage/logos/'.\App\Models\GeneralSetting::first()?'storage/logos/'.\App\Models\GeneralSetting::first()->logo:null) }}">
                                </a>
                                <div class="col-md-12">
                                    <h3 class="text-center txt-primary">ADMINISTRATOR</h3>
                                </div>
                            </div>



                            <div class="input-group">
                                <input type="text" placeholder="Username" class="form-control" name="username" required autofocus>
                                <span class="md-line"></span>
                            </div>
                            <div class="input-group">
                                <input class="form-control" type="password" placeholder="Password" name="password" required>
                                <span class="md-line"></span>
                            </div>

                            <div class="row m-t-30">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary btn-md btn-block waves-effect text-center m-b-20">Sign in</button>
                                </div>
                            </div>


                        </div>
                    </form>
                    <!-- end of form -->
                </div>
                <!-- Authentication card end -->
            </div>
            <!-- end of col-sm-12 -->
        </div>
        <!-- end of row -->
    </div>
    <!-- end of container-fluid -->
</section>

</body>



</html>
