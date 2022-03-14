<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Comprehensive Credit Services Inc.</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <link rel="stylesheet" href="{{ asset('bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/Ionicons/css/ionicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/css/AdminLTE.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/css/skins/_all-skins.min.css') }}">
    {{--<link rel="stylesheet" href="{{ asset('bower_components/morris.js/morris.css') }}">--}}
    <link rel="stylesheet" href="{{ asset('bower_components/jvectormap/jquery-jvectormap.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/bootstrap-daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}">
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.4.0/css/buttons.dataTables.min.css">

    {{--DATE TIME PICKER--}}
    <link rel="stylesheet" href="{{ asset('plugins/timepicker/bootstrap-timepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/bootstrap-daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.css')}}">
    <link rel="stylesheet" href="{{ asset('plugins/iCheck/all.css')}}">
    <link rel="stylesheet" href="{{ asset('bower_components/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css')}}">

    {{--ICON FOR TABS--}}
    <link rel="icon" href="dist/img/ccsi-icon.ico">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>


        /*.content-wrapper{*/

            /*margin-right: -21%;*/

            /*-webkit-transform:scale(0.8);*/
            /*-moz-transform:scale(0.8);*/
            /*-ms-transform:scale(0.8);*/
            /*transform:scale(0.8);*/
            /*-ms-transform-origin:0 0;*/
            /*-webkit-transform-origin:0 0;*/
            /*-moz-transform-origin:0 0;*/
            /*transform-origin:0 0;*/
        /*}*/


        .tableendorse, th, td {
            font-size: 90%;
            border: 1px solid grey;
            text-align: center;
            padding: 1px;
        }

        /*td{*/
        /*height: 50px;*/
        /*width: 50px;*/
        /*}*/

        th{
            height: 30px;

            text-align: center;
        }

        #tableManageAccount, #usertableManage
        {
            text-transform: uppercase;
        }

    </style>
</head>