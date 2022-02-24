<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Comprehensive Credit Services Inc.</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    
    

    
    

    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="<?php echo e(asset('bower_components/bootstrap/dist/css/bootstrap.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('bower_components/font-awesome/css/font-awesome.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('bower_components/Ionicons/css/ionicons.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('dist/css/AdminLTE.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('dist/css/skins/_all-skins.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('bower_components/morris.js/morris.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('bower_components/jvectormap/jquery-jvectormap.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('bower_components/bootstrap-daterangepicker/daterangepicker.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('plugins/pace/pace.min.css')); ?>">

    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

    <!-- DataTables -->
    
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.1/css/buttons.dataTables.min.css">
    
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/select/1.2.5/css/select.dataTables.min.css">


    
    <link rel="stylesheet" href="<?php echo e(asset('plugins/Emoji-Picker-jQuery-Emoji-Plugin/css/style.css')); ?>">



    
    <link rel="stylesheet" href="<?php echo e(asset('plugins/timepicker/bootstrap-timepicker.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('bower_components/bootstrap-daterangepicker/daterangepicker.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('bower_components/select2/dist/css/select2.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('plugins/iCheck/all.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('bower_components/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css')); ?>">

    
    <link rel="icon" href="dist/img/ccsi-icon.ico">

    
    
    

    
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>" id="_token">

    
    <link href="<?php echo e(asset('plugins/DropZoneJs/min/dropzone.min.css')); ?>" rel="stylesheet" type="text/css">

    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    
    <link href="<?php echo e(asset('bower_components/chartist/chartist.min.css')); ?>" rel="stylesheet" type="text/css">
    <link href="<?php echo e(asset('bower_components/chartist/chartist-plugin-legend.css')); ?>" rel="stylesheet" type="text/css">
    <link href="<?php echo e(asset('bower_components/chartist/scss/chartist.scss')); ?>" rel="stylesheet" type="text/scss">
    <link href="<?php echo e(asset('bower_components/chartist/scss/settings/_chartist.scss')); ?>" rel="stylesheet" type="text/scss">

    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.css"/>

    
    <link href="<?php echo e(asset('plugins/bootstrap-tagsinput-latest/src/bootstrap-tagsinput.css')); ?>" rel="stylesheet" type="text/css">
    
    <link href="<?php echo e(asset('plugins/jquery-smartwizard-master/dist/css/smart_wizard_arrows.css')); ?>" rel="stylesheet" type="text/css">

    <style>


        /*leftsidebar{*/
            /*margin-right: 100px;*/
        /*}*/

        /*.content {display:none;}*/
        /*.preload { width:100px;*/
            /*height: 100px;*/
            /*position: fixed;*/
            /*top: 50%;*/
            /*left: 50%;}*/


        /*#overlay{*/
            /*position:fixed;*/
            /*z-index:99999;*/
            /*top:0;*/
            /*left:0;*/
            /*bottom:0;*/
            /*right:0;*/
            /*background:rgba(0,0,0,0.9);*/
            /*transition: 1s 0.4s;*/
        /*}*/
        /*#progress{*/
            /*height:1px;*/
            /*background:#fff;*/
            /*position:absolute;*/
            /*width:0;*/
            /*top:50%;*/
        /*}*/
        /*#progstat{*/
            /*font-size:0.7em;*/
            /*letter-spacing: 3px;*/
            /*position:absolute;*/
            /*top:50%;*/
            /*margin-top:-40px;*/
            /*width:100%;*/
            /*text-align:center;*/
            /*color:#fff;*/
        /*}*/

        .no-js #loader { display: none;  }
        .js #loader { display: block; position: absolute; left: 100px; top: 0; }
        .se-pre-con {
            position: fixed;
            left: 0px;
            top: 0px;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background: url(dist/gif/ccsiLoading.gif) center no-repeat #fff;
        }


        html{

            zoom: 80%;

            /*margin-right: -21%;*/

            /*-webkit-transform:scale(0.8);*/
            /*-moz-transform:scale(0.8);*/
            /*-ms-transform:scale(0.8);*/
            /*transform:scale(0.8);*/
            /*-ms-transform-origin:0 0;*/
            /*-webkit-transform-origin:0 0;*/
            /*-moz-transform-origin:0 0;*/
            /*transform-origin:0 0;*/
        }


        /*.content-wrapper{font-size:1.2vw;}*/

        .tableendorse, th, td
        {
            font-size: 90%;
            border: 1px solid grey;
            text-align: center;
            padding: 1px;
        }

        /*td{*/
        /*height: 50px;*/
        /*width: 50px;*/
        /*}*/

        th
        {
            height: 30px;
            text-align: center;
        }


        td.details-control {
            background: url('https://www.datatables.net/examples/resources/details_open.png') no-repeat center center;
            cursor: pointer;
        }

        tr.shown td.details-control {
            background: url('https://www.datatables.net/examples/resources/details_close.png') no-repeat center center;
        }

        td.details-control-accounts {
            background: url(dist/img/show_account.png) no-repeat center center;
            cursor: pointer;
        }

        tr.shown td.details-control-accounts {
            background: url(dist/img/hide_account.png) no-repeat center center;
        }

        /*.affix {*/
            /*position: fixed;*/
        /*}*/

        .ct-label {
            font-size: 12px;
            color: #000000;
        }

        #client-history-table, #client-finish-account, #client-hold-account, #client-cancel-account,
        #ao-new-endorsement, #audit-table-reports, #billing-table-rate, #billing-manage, #ci-table, #ci-table-finish,
        #endorsement-table, #endorsement-table, #list-new-endorsement, #finance-table-reports, #audit-table, #marketing-manage,
        #endorsement-tablee, #aolist-table, #tableholdcancel
        {
            text-transform: uppercase;
        }


        [class^='select2']
        {
            border-radius: 0px !important;
        }

        .content-header{
            margin-top: 30px;
        }


        [contenteditable=true]:empty:before {
            content: attr(placeholder);
            display: block; /* For Firefox */
        }

        .emotion { margin: auto }

        div[contenteditable=true] {
            border: 1px dashed #AAA;
            width: 290px;
            padding: 5px;
        }

        pre {
            background: #EEE;
            padding: 5px;
            width: 290px;
        }

        .emotion {
            position: relative;
            display: flex
        }

        .emotion-Icon {
            position: relative;
            right: 20px;
            top: 5px;
            cursor: pointer;
        }

        .ShowImotion { display: flex !important; }

        .emotion-area {
            position: absolute;
            box-shadow: 1px 1px 1px 1px #333;
            bottom: 130%;
            display: none;
            right: 0;
            width: 300px;
            flex-wrap: wrap;
            overflow-y: scroll;
            height: 150px;
        }

        .top {
            top: 130%;
            bottom: auto
        }

        .emotion-area img {
            margin: 4px;
            cursor: pointer;
        }



    </style>




</head>