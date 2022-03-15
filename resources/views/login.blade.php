<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Comprehensive Credit Services Inc.</title>
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
    <link rel="icon" href="dist/img/ccsi-icon.ico">
    {{--PUSHER--}}
    <script src="https://js.pusher.com/4.1/pusher.min.js"></script>
</head>
<body class="hold-transition login-page">
<div class="login-box">

    <!-- /.login-logo here -->
    <div class="login-box-body">
        <div class="login-logo">
            <img src="{{ asset('dist\img\title.gif') }}" width="100%">
        </div>
        <p class="login-box-msg">Sign in to start your session</p>
        @include('errors.loginerror')
        <form action="{{ route('auth-login') }}" method="post" id="login-form">
            <div class="form-group has-feedback">
                <input type="email" class="form-control" placeholder="Email" id="email" name="email" required>
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <div class="input-group" id="show_hide_password">
                    <input type="password" class="form-control" placeholder="Password" name="password" required>
                    <div class="input-group-addon">
                        <a href=""><i class="fa fa-eye-slash" aria-hidden="true" title="Click to show password"></i></a>
                    </div>
                </div>
                {{--<input type="password" class="form-control" placeholder="Password" name="password" required>--}}
                {{--<span class="glyphicon glyphicon-lock form-control-feedback"></span>--}}
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
                </div>
            </div>
            {{----}}
            {{--<div class="row">--}}
                {{--<div class="col-xs-12">--}}
                    {{--<small><a href="" id="individual_client_href" data-toggle="modal" class="pull-right" hidden><u>For Invidual Client Request Click here!</u></a></small>--}}
                {{--</div>--}}
                {{--<!-- /.col -->--}}
            {{--</div>--}}
            {{--<div class="row">--}}
                {{--<div class="col-xs-12">--}}
                    {{--<small><a href="/view-transaction" class="pull-right" hidden><u>View your tracking ID here!</u></a></small>--}}
                {{--</div>--}}
                {{--<!-- /.col -->--}}
            {{--</div>--}}
            {{----}}
            <input type="hidden" name="_token" value="{{ Session::token() }}">

        </form>
    </div>
    <!-- /.login-box-body -->
</div>

{{--CLICK HERE MODAL--}}
{{--<div class="modal fade" id="modal-click-here">--}}
    {{--<div class="modal-dialog modal-large">--}}
        {{--<div class="modal-content">--}}
            {{--<div class="modal-header">--}}
                {{--<button type="button" class="close" data-dismiss="modal" aria-label="Close">--}}
                    {{--<span aria-hidden="true">&times;</span></button>--}}
                {{--<h4 class="modal-title">Agreement</h4>--}}
            {{--</div>--}}
            {{--<div class="modal-body">--}}


                {{--<div class="row">--}}
                    {{--<div class="col-md-12">--}}
                        {{--<small><center><input type="checkbox" id="check_agreement"> <label for="check_agreement" style="font-weight: 400">I Agree to this agreement.</label></center></small>--}}
                    {{--</div>--}}
                {{--</div>--}}

                {{--<form onsubmit="return submit_form()" action="{{ route('auth-login') }}" method="post" id="login-form">--}}
                    {{--<div class="form-group has-feedback">--}}
                        {{--<input style="display: none" hidden type="text" class="form-control" placeholder="Email" id="email" name="email" value="y8xLyUzOyUzNK3FITi7O1EvOzwUA">--}}
                    {{--</div>--}}
                    {{--<div class="form-group has-feedback">--}}
                        {{--<input style="display: none" hidden type="password" class="form-control" placeholder="Password" name="password" value="y8xLyUzOyUzNKwEA">--}}
                    {{--</div>--}}
                    {{--<div class="form-group has-feedback">--}}
                        {{--<input style="display: none" hidden type="password" class="form-control" placeholder="Password_2" name="password_2" value="secret_indi">--}}
                    {{--</div>--}}
                    {{--<input type="hidden" name="_token" value="{{ Session::token() }}">--}}
                    {{--<div class="modal-footer">--}}
                    {{--<div class="row">--}}
                        {{--<div class="col-md-12">--}}
                            {{--<button type="submit" class="btn btn-sm btn-primary btn-flat pull-right">Confirm</button>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--</div>--}}
                {{--</form>--}}


            {{--</div>--}}

        {{--</div>--}}
    {{--</div>--}}
{{--</div>--}}
{{--END OF CLICK HERE MODAL--}}


<!-- /.login-box -->

<!-- jQuery 3 -->
<script src="{{ asset('bower_components/jquery/dist/jquery.min.js') }}"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{ asset('bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<!-- iCheck -->
<script src="{{ asset('plugins/iCheck/icheck.min.js') }}"></script>
{{--audit trailing--}}
<script src="{{ asset('jscript/audittrailing.js') }}"></script>
<center><script type="text/javascript"> //<![CDATA[
        var tlJsHost = ((window.location.protocol == "https:") ? "https://secure.trust-provider.com/" : "http://www.trustlogo.com/");
        document.write(unescape("%3Cscript src='" + tlJsHost + "trustlogo/javascript/trustlogo.js' type='text/javascript'%3E%3C/script%3E"));
        //]]></script>
    <script language="JavaScript" type="text/javascript">
        TrustLogo("https://sectigo.com/images/seals/sectigo_trust_seal_sm_2x.png", "SECDV", "none");
    </script></center>

</body>
</html>

<script type="text/javascript">
    $(document).ready(function() {
        $("#show_hide_password a").on('click', function(event) {
            event.preventDefault();
            if($('#show_hide_password input').attr("type") == "text"){
                $('#show_hide_password input').attr('type', 'password');
                $('#show_hide_password i').addClass( "fa-eye-slash" );
                $('#show_hide_password i').removeClass( "fa-eye" );
                $('#show_hide_password i').attr( "title", 'Click to show password');
            }else if($('#show_hide_password input').attr("type") == "password"){
                $('#show_hide_password input').attr('type', 'text');
                $('#show_hide_password i').removeClass( "fa-eye-slash" );
                $('#show_hide_password i').addClass( "fa-eye" );
                $('#show_hide_password i').attr( "title", 'Click to hide password');
            }
        });
    });
</script>
