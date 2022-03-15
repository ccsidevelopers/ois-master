<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Comprehensive Credit Services Inc.</title>
    <meta name="csrf-token" content="{{ csrf_token() }}" id="_token">
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ asset('bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('bower_components/font-awesome/css/font-awesome.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ asset('bower_components/Ionicons/css/ionicons.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/AdminLTE.min.css') }}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset('plugins/iCheck/square/blue.css') }}">

<!-- HTML5 Shim and Respond.js IE8 sup{{ asset('') }}port of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    {{--header icon--}}
    <link rel="icon" href="../dist/img/ccsi-icon.ico">
    {{--PUSHER--}}
    <script src="https://js.pusher.com/4.1/pusher.min.js"></script>
</head>
<body class="hold-transition login-page">
<div class="login-box">

    <div class="login-box-body">
        <div class="login-logo">
            <img src="{{asset('dist/gif/ccsiLoading.gif')}}" alt="" width="100%" token="{{$token}}" id="token_holder">
            <center>
                <h4>Please wait</h4>
            </center>
        </div>

        <div class="box" id="infos">
            <div class="box-body">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    <form action="paypal-gateway?t={{$random}}" hidden method="post">
                        <input type="text" hidden value="{{$token}}" name="access_token">
                        <input type="submit" id="token_button">
                        <input type="hidden" name="_token" value="{{ Session::token() }}">
                    </form>

                </div>
                <div class="col-md-2"></div>
            </div>
        </div>
    </div>
</div>


<center><script type="text/javascript"> //<![CDATA[
        var tlJsHost = ((window.location.protocol == "https:") ? "https://secure.trust-provider.com/" : "http://www.trustlogo.com/");
        document.write(unescape("%3Cscript src='" + tlJsHost + "trustlogo/javascript/trustlogo.js' type='text/javascript'%3E%3C/script%3E"));
        //]]></script>
    <script language="JavaScript" type="text/javascript">
        TrustLogo("https://sectigo.com/images/seals/sectigo_trust_seal_sm_2x.png", "SECDV", "none");
    </script>
</center>

<!-- jQuery 3 -->
<script src="{{ asset('bower_components/jquery/dist/jquery.min.js') }}"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{ asset('bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('jscript/paypal-payment.js?n='.$javs) }}"></script>
</body>
</html>
