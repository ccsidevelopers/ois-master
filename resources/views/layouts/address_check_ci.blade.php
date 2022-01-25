<html>
<head>
    <script src="{{ asset('bower_components/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('bower_components/jquery-ui/jquery-ui.min.js') }}"></script>

    <title>OIMS Location checker</title>
</head>
<body>
<div class="content-wrapper">
    Checking your location.....

    <span id="lat" value="{{$lat}}"></span>
    <span id="long" value="{{$long}}"></span>
    <span id="ci_id" value="{{$ci_id}}"></span>

</div>
<script src="{{ asset('jscript/address_check_ci.js') }}"></script>
</body>
</html>