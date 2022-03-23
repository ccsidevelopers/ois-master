{{--@extends('layouts.master')--}}

{{--<link rel="stylesheet" href="https://cdn.datatables.net/rowreorder/1.2.0/css/rowReorder.dataTables.min.css">--}}
{{--<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.1.1/css/responsive.dataTables.min.css">--}}

{{--<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">--}}
{{--<link rel="stylesheet" href="https://resources/demos/style.css">--}}


{{--@section('content')--}}
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Dashboard
                <small>Control panel</small>
            </h1>

        </section>

        <!-- Main content -->
        <section class="content">
            <!-- Small boxes (Stat box) -->
            <div class="row">

                <div class="col-lg-3 col-xs-6">
                    <div class="info-box">
                        <span class="info-box-icon bg-aqua"><i class="fa fa-envelope-o"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Total Endorsed Accounts</span>
                            <span class="info-box-number">{{ $endorsement }}</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>

                <div class="col-lg-3 col-xs-6">
                    <div class="info-box">
                        <span class="info-box-icon bg-green"><i class="fa fa-check-square"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Total TAT Accounts</span>
                            <span class="info-box-number">{{ $tatAccounts }}</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>

                <div class="col-lg-3 col-xs-6">
                    <div class="info-box">
                        <span class="info-box-icon bg-red"><i class="fa fa-clock-o"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Total Overdue Accounts</span>
                            <span class="info-box-number">{{ $overdueAccount }}</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>

                <div class="col-lg-3 col-xs-6">
                    <div class="info-box">
                        <span class="info-box-icon bg-yellow"><i class="fa fa-star-o"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Due Account {{ $timeStamp->toFormattedDateString() }}</span>
                            <span class="info-box-number">{{ $dueAccount }}</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>

            </div>
            <!-- /.row -->
            <div class="row">

                <!-- Main content -->
                <section class="content">

                    <!-- Default box -->
                    <div class="box">

                        <div class="box-header with-border">
                            <h3 class="box-title">History and Status of Endorsed Account</h3>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                                        title="Collapse">
                                    <i class="fa fa-minus"></i></button>
                                <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                                    <i class="fa fa-times"></i></button>
                            </div>
                        </div>

                        <div class="box-body">

                            <div class="row">
                                <div class="col-md-12">
                                    <!-- Custom Tabs -->
                                    <div class="nav-tabs-custom">
                                        <ul class="nav nav-tabs">
                                            <li class="active"><a href="#tab_1" id="client_tab1" data-toggle="tab">Pending Accounts</a></li>
                                            <li><a href="#tab_2" id="client_tab2" data-toggle="tab">Success Accounts</a></li>
                                            <li><a href="#tab_3" id="client_tab3" data-toggle="tab">Hold Accounts</a></li>
                                            <li><a href="#tab_4" id="client_tab4" data-toggle="tab">Cancelled Accounts</a></li>
                                            <li><a href="#tab_5" id="client_tab5" data-toggle="tab">Revised Accounts</a></li>
                                        </ul>
                                        <div class="tab-content">
                                            <div class="tab-pane active" id="tab_1">



                                                <div class="col-md-5">
                                                    <div class="box box-danger">
                                                        <div class="box-header with-border">
                                                            <h3 class="box-title">Endorsement Range Date</h3>
                                                        </div>
                                                        <div class="box-body" data-toggle="tooltip" title="You can select for the range of date of endorsement that you want to view">
                                                            <div class="form-group">

                                                                <input type="radio" class="viewable" name="viewable1" id="rad_all1" value="All">All
                                                                <input type="radio" class="viewable" name="viewable1" id="rad_daterange1" value="Date Range">Date Range


                                                                <div class="input-group margin date_range_container">
                                                                    <div class="input-group-btn">
                                                                        <button type="button" class="btn btn-default">From</button>
                                                                    </div>
                                                                    <!-- /btn-group -->

                                                                    <input type="text" id="datepicker" class="form-control min">
                                                                    <input hidden id="min" type="date">

                                                                    <div class="input-group-btn">
                                                                        <button type="button" class="btn btn-default">To</button>
                                                                    </div>
                                                                    <!-- /btn-group -->
                                                                    <input type="text" id="datepickermax" class="form-control max">
                                                                    <input hidden id="max" type="date">

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                                <table id="client-history-table" class="tableendorse table-hover table-condensed" width="100%">
                                                    <thead>
                                                    <tr>
                                                        <th>Id</th>
                                                        <th>Account Name</th>
                                                        <th>Date Endorsed</th>
                                                        <th>Time Endorsed</th>
                                                        <th>Address</th>
                                                        <th>City/Municipality</th>
                                                        <th>Provinces</th>
                                                        <th>Type of Request</th>
                                                        <th>Type of Loan</th>
                                                        <th>Dealer Name</th>
                                                        <th>Contract Number</th>
                                                        <th>Requestor</th>
                                                        <th>Remarks</th>
                                                        <th>Entry As</th>
                                                        <th>Status</th>
                                                        {{--<th>Time</th>--}}
                                                        <th>Actions</th>
                                                    </tr>
                                                    </thead>
                                                    <tfoot>
                                                    <tr>
                                                        <th>Id</th>
                                                        <th>Account Name</th>
                                                        <th>Date Endorsed</th>
                                                        <th>Time Endorsed</th>
                                                        <th>Address</th>
                                                        <th>City/Municipality</th>
                                                        <th>Provinces</th>
                                                        <th>Type of Request</th>
                                                        <th>Type of Loan</th>
                                                        <th>Dealer Name</th>
                                                        <th>Contract Number</th>
                                                        <th>Requestor</th>
                                                        <th>Remarks</th>
                                                        <th>Entry As</th>
                                                        <th>Status</th>
                                                        {{--<th>Time</th>--}}
                                                        <th>Actions</th>
                                                    </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                            <!-- /.tab-pane -->
                                            <div class="tab-pane" id="tab_2">
                                                <div class="nav-tabs-custom">
                                                    <ul class="nav nav-tabs">
                                                        {{-- <li class="active"><a href="#new_accounts_tab" class="success_tabs" data-toggle="tab">New Accounts</a></li>
                                                        <li><a href="#read_accounts_tab" class="success_tabs" data-toggle="tab">Read Accounts</a></li> --}}
                                                        <li><a href="#finish_accounts_tab" class="success_tabs" data-toggle="tab"><button class="btn btn-primary">CLICK HERE TO REFRESH ALL ACCOUNTS</button></a></li>
                                                    </ul>
                                                    <div class="tab-content">
                                                        {{-- <div class="tab-pane active" id="new_accounts_tab">

                                                            <div class="col-md-5">
                                                                <div class="box box-danger">
                                                                    <div class="box-header with-border">
                                                                        <h3 class="box-title">Endorsement Range Date</h3>
                                                                    </div>
                                                                    <div class="box-body" data-toggle="tooltip" title="You can select for the range of date of endorsement that you want to view">
                                                                        <div class="form-group">
                                                                            <input type="radio" class="viewable" name="viewable2" id="rad_all2" value="All">All
                                                                            <input type="radio" class="viewable" name="viewable2" id="rad_daterange2" value="Date Range">Date Range

                                                                            <div class="input-group margin date_range_container">
                                                                                <div class="input-group-btn">
                                                                                    <button type="button" class="btn btn-default">From</button>
                                                                                </div>
                                                                                <!-- /btn-group -->
                                                                                <input type="text" id="datepickerminFinish" class="form-control minFinish">
                                                                                <input hidden id="minFinish" type="date">

                                                                                <div class="input-group-btn">
                                                                                    <button type="button" class="btn btn-default">To</button>
                                                                                </div>
                                                                                <!-- /btn-group -->
                                                                                <input type="text" id="datepickermaxFinish" class="form-control maxFinish">
                                                                                <input hidden id="maxFinish" type="date">
                                                                            </div>

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <table id="client-finish-account" class="tableendorse table-hover table-condensed" width="100%">
                                                                <thead>
                                                                <tr>
                                                                    <th>Id</th>
                                                                    <th>Account Name</th>
                                                                    <th>Date Endorsed</th>
                                                                    <th>Time Endorsed</th>
                                                                    <th>Address</th>
                                                                    <th>City/Municipality</th>
                                                                    <th>Provinces</th>
                                                                    <th>Type of Request</th>
                                                                    <th>Type of Loan</th>
                                                                   
                                                                    <th>Requestor</th>
                                                                    <th>Dealer name</th>
                                                                    <th>Contract number</th>
                                                                    <th>Remarks</th>
                                                                    <th>Entry As</th>
                                                                    <th>Status</th>
                                                                    <th>Time</th>
                                                                    <th>Actions</th>
                                                                </tr>
                                                                </thead>
                                                                <tfoot>
                                                                <tr>
                                                                    <th>Id</th>
                                                                    <th>Account Name</th>
                                                                    <th>Date Endorsed</th>
                                                                    <th>Time Endorsed</th>
                                                                    <th>Address</th>
                                                                    <th>City/Municipality</th>
                                                                    <th>Provinces</th>
                                                                    <th>Type of Request</th>
                                                                    <th>Type of Loan</th>
                                                                  
                                                                    <th>Requestor</th>
                                                                    <th>Dealer name</th>
                                                                    <th>Contract number</th>
                                                                    <th>Remarks</th>
                                                                    <th>Entry As</th>
                                                                    <th>Status</th>
                                                                    <th>Time</th>
                                                                    <th>Actions</th>
                                                                </tr>
                                                                </tfoot>
                                                            </table>
                                                        </div> --}}
                                                        {{-- <div class="tab-pane" id="read_accounts_tab">

                                                            <div class="col-md-5">
                                                                <div class="box box-danger">
                                                                    <div class="box-header with-border">
                                                                        <h3 class="box-title">Endorsement Range Date</h3>
                                                                    </div>
                                                                    <div class="box-body" data-toggle="tooltip" title="You can select for the range of date of endorsement that you want to view">
                                                                        <div class="form-group">
                                                                            <input type="radio" class="viewable" name="viewableread" id="rad_allread" value="All">All
                                                                            <input type="radio" class="viewable" name="viewableread" id="rad_daterangeread" value="Date Range">Date Range

                                                                            <div class="input-group margin date_range_container">
                                                                                <div class="input-group-btn">
                                                                                    <button type="button" class="btn btn-default">From</button>
                                                                                </div>
                                                                                <!-- /btn-group -->
                                                                                <input type="text" id="datepickerminFinish-read" class="form-control minFinish">
                                                                                <input hidden id="minFinish-read" type="date">

                                                                                <div class="input-group-btn">
                                                                                    <button type="button" class="btn btn-default">To</button>
                                                                                </div>
                                                                                <!-- /btn-group -->
                                                                                <input type="text" id="datepickermaxFinish-read" class="form-control maxFinish">
                                                                                <input hidden id="maxFinish-read" type="date">
                                                                            </div>

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <table id="client-finish-read" class="tableendorse table-hover table-condensed" width="100%">
                                                                <thead>
                                                                <tr>
                                                                    <th>Id</th>
                                                                    <th>Account Name</th>
                                                                    <th>Date Endorsed</th>
                                                                    <th>Time Endorsed</th>
                                                                    <th>Address</th>
                                                                    <th>City/Municipality</th>
                                                                    <th>Provinces</th>
                                                                    <th>Type of Request</th>
                                                                    <th>Type of Loan</th>
                                                                    <th>Requestor</th>
                                                                    <th>Dealer name</th>
                                                                    <th>Contract number</th>
                                                                    <th>Remarks</th>
                                                                    <th>Entry As</th>
                                                                    <th>Status</th>
                                                                    <th>Time</th>
                                                                    <th>Actions</th>
                                                                </tr>
                                                                </thead>
                                                                <tfoot>
                                                                <tr>
                                                                    <th>Id</th>
                                                                    <th>Account Name</th>
                                                                    <th>Date Endorsed</th>
                                                                    <th>Time Endorsed</th>
                                                                    <th>Address</th>
                                                                    <th>City/Municipality</th>
                                                                    <th>Provinces</th>
                                                                    <th>Type of Request</th>
                                                                    <th>Type of Loan</th>
                                                                    <th>Requestor</th>
                                                                    <th>Dealer name</th>
                                                                    <th>Contract number</th>
                                                                    <th>Remarks</th>
                                                                    <th>Entry As</th>
                                                                    <th>Status</th>
                                                                    <th>Time</th>
                                                                    <th>Actions</th>
                                                                </tr>
                                                                </tfoot>
                                                            </table>

                                                        </div> --}}
                                                        <div class="tab-pane" id="finish_accounts_tab">
                                                            <div class="col-md-5">
                                                                <div class="box box-danger">
                                                                    <div class="box-header with-border">
                                                                        <h3 class="box-title">Endorsement Range Date</h3>
                                                                    </div>
                                                                    <div class="box-body" data-toggle="tooltip" title="You can select for the range of date of endorsement that you want to view">
                                                                        <div class="form-group">
                                                                            <input type="radio" class="viewable" name="viewabledownload" id="rad_alldownload" value="All">All
                                                                            <input type="radio" class="viewable" name="viewabledownload" id="rad_daterangedownload" value="Date Range">Date Range

                                                                            <div class="input-group margin date_range_container">
                                                                                <div class="input-group-btn">
                                                                                    <button type="button" class="btn btn-default">From</button>
                                                                                </div>
                                                                                <!-- /btn-group -->
                                                                                <input type="text" id="datepickerminFinish-download" class="form-control minFinish">
                                                                                <input hidden id="minFinish-download" type="date">

                                                                                <div class="input-group-btn">
                                                                                    <button type="button" class="btn btn-default">To</button>
                                                                                </div>
                                                                                <!-- /btn-group -->
                                                                                <input type="text" id="datepickermaxFinish-download" class="form-control maxFinish">
                                                                                <input hidden id="maxFinish-download" type="date">
                                                                            </div>

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <table id="client-finish-downlaoded" class="tableendorse table-hover table-condensed" width="100%">
                                                                <thead>
                                                                <tr>
                                                                    <th>Id</th>
                                                                    <th>Account Name</th>
                                                                    <th>Date Endorsed</th>
                                                                    <th>Time Endorsed</th>
                                                                    <th>Address</th>
                                                                    <th>City/Municipality</th>
                                                                    <th>Provinces</th>
                                                                    <th>Type of Request</th>
                                                                    <th>Type of Loan</th>
                                                                    <th>Requestor</th>
                                                                    <th>Dealer name</th>
                                                                    <th>Contract number</th>
                                                                    <th>Remarks</th>
                                                                    <th>Entry As</th>
                                                                    <th>Status</th>
                                                                    <th>Time</th>
                                                                    <th>Actions</th>
                                                                    <th>Date Forwarded</th>
                                                                    <th>Time Forwarded</th>
                                                                </tr>
                                                                </thead>
                                                                <tfoot>
                                                                <tr>
                                                                    <th>Id</th>
                                                                    <th>Account Name</th>
                                                                    <th>Date Endorsed</th>
                                                                    <th>Time Endorsed</th>
                                                                    <th>Address</th>
                                                                    <th>City/Municipality</th>
                                                                    <th>Provinces</th>
                                                                    <th>Type of Request</th>
                                                                    <th>Type of Loan</th>
                                                                    <th>Requestor</th>
                                                                    <th>Dealer name</th>
                                                                    <th>Contract number</th>
                                                                    <th>Remarks</th>
                                                                    <th>Entry As</th>
                                                                    <th>Status</th>
                                                                    <th>Time</th>
                                                                    <th>Actions</th>
                                                                    <th>Date Forwarded</th>
                                                                    <th>Time Forwarded</th>
                                                                </tr>
                                                                </tfoot>
                                                            </table>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            {{--TAB HOLD--}}
                                            <div class="tab-pane" id="tab_3">

                                                <div class="col-md-5">
                                                    <div class="box box-danger">
                                                        <div class="box-header with-border">
                                                            <h3 class="box-title">Endorsement Range Date</h3>
                                                        </div>
                                                        <div class="box-body" data-toggle="tooltip" title="You can select for the range of date of endorsement that you want to view">
                                                            <div class="form-group">
                                                                <input type="radio" class="viewable" name="viewable3" id="rad_all3" value="All">All
                                                                <input type="radio" class="viewable" name="viewable3" id="rad_daterange3" value="Date Range">Date Range

                                                                <div class="input-group margin date_range_container">
                                                                    <div class="input-group-btn">
                                                                        <button type="button" class="btn btn-default">From</button>
                                                                    </div>
                                                                    <!-- /btn-group -->

                                                                    <input type="text" id="datepickerminHold" class="form-control minHold">
                                                                    <input hidden id="minHold" type="date">


                                                                    <div class="input-group-btn">
                                                                        <button type="button" class="btn btn-default">To</button>
                                                                    </div>
                                                                    <!-- /btn-group -->
                                                                    <input type="text" id="datepickermaxHold" class="form-control maxHold">
                                                                    <input hidden id="maxHold" type="date">
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <table id="client-hold-account" class="tableendorse table-hover table-condensed" width="100%">
                                                    <thead>
                                                    <tr>
                                                        <th>Id</th>
                                                        <th>Account Name</th>
                                                        <th>Date Endorsed</th>
                                                        <th>Time Endorsed</th>
                                                        <th>Address</th>
                                                        <th>City/Municipality</th>
                                                        <th>Provinces</th>
                                                        <th>Type of Request</th>
                                                        <th>Type of Loan</th>
                                                        <th>Requestor</th>
                                                        <th>Remarks</th>
                                                        <th>Entry As</th>
                                                        <th>Status</th>
                                                        <th>Time</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                    </thead>
                                                    <tfoot>
                                                    <tr>
                                                        <th>Id</th>
                                                        <th>Account Name</th>
                                                        <th>Date Endorsed</th>
                                                        <th>Time Endorsed</th>
                                                        <th>Address</th>
                                                        <th>City/Municipality</th>
                                                        <th>Provinces</th>
                                                        <th>Type of Request</th>
                                                        <th>Type of Loan</th>
                                                        <th>Requestor</th>
                                                        <th>Remarks</th>
                                                        <th>Entry As</th>
                                                        <th>Status</th>
                                                        <th>Time</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                            {{--TAB 4 CANCEL--}}
                                            <div class="tab-pane" id="tab_4">

                                                <div class="col-md-5">
                                                    <div class="box box-danger">
                                                        <div class="box-header with-border">
                                                            <h3 class="box-title">Endorsement Range Date</h3>
                                                        </div>
                                                        <div class="box-body" data-toggle="tooltip" title="You can select for the range of date of endorsement that you want to view">
                                                            <div class="form-group-right">

                                                                <input type="radio" class="viewable" name="viewable4" id="rad_all4" value="All">All
                                                                <input type="radio" class="viewable" name="viewable4" id="rad_daterange4" value="Date Range">Date Range

                                                                <div class="input-group margin date_range_container">
                                                                    <div class="input-group-btn">
                                                                        <button type="button" class="btn btn-default">From</button>
                                                                    </div>
                                                                    <!-- /btn-group -->
                                                                    <input type="text" id="datepickerminCancelled" class="form-control minCancelled">
                                                                    <input hidden id="minCancelled" type="date">

                                                                    <div class="input-group-btn">
                                                                        <button type="button" class="btn btn-default">To</button>
                                                                    </div>
                                                                    <!-- /btn-group -->

                                                                    <input type="text" id="datepickermaxCancelled" class="form-control maxCancelled">
                                                                    <input hidden id="maxCancelled" type="date">

                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <table id="client-cancel-account" class="tableendorse table-hover table-condensed" width="100%">
                                                    <thead>
                                                    <tr>
                                                        <th>Id</th>
                                                        <th>Account Name</th>
                                                        <th>Date Endorsed</th>
                                                        <th>Time Endorsed</th>
                                                        <th>Address</th>
                                                        <th>City/Municipality</th>
                                                        <th>Provinces</th>
                                                        <th>Type of Request</th>
                                                        <th>Type of Loan</th>
                                                        <th>Requestor</th>
                                                        <th>Remarks</th>
                                                        <th>Entry As</th>
                                                        <th>Status</th>
                                                        <th>Time</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                    </thead>
                                                    <tfoot>
                                                    <tr>
                                                        <th>Id</th>
                                                        <th>Account Name</th>
                                                        <th>Date Endorsed</th>
                                                        <th>Time Endorsed</th>
                                                        <th>Address</th>
                                                        <th>City/Municipality</th>
                                                        <th>Provinces</th>
                                                        <th>Type of Request</th>
                                                        <th>Type of Loan</th>
                                                        <th>Requestor</th>
                                                        <th>Remarks</th>
                                                        <th>Entry As</th>
                                                        <th>Status</th>
                                                        <th>Time</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                            {{--TAB 4 REVISION--}}
                                            <div class="tab-pane" id="tab_5">

                                                <div class="col-md-5">
                                                    <div class="box box-danger">
                                                        <div class="box-header with-border">
                                                            <h3 class="box-title">Endorsement Range Date</h3>
                                                        </div>
                                                        <div class="box-body" data-toggle="tooltip" title="You can select for the range of date of endorsement that you want to view">
                                                            <div class="form-group-right">

                                                                <input type="radio" class="viewable" name="viewable5" id="rad_all5" value="All">All
                                                                <input type="radio" class="viewable" name="viewable5" id="rad_daterange5" value="Date Range">Date Range

                                                                <div class="input-group margin date_range_container">
                                                                    <div class="input-group-btn">
                                                                        <button type="button" class="btn btn-default">From</button>
                                                                    </div>
                                                                    <!-- /btn-group -->
                                                                    <input type="text" id="datepickerminRevised" class="form-control minCancelled">
                                                                    <input hidden id="minRevised" type="date">

                                                                    <div class="input-group-btn">
                                                                        <button type="button" class="btn btn-default">To</button>
                                                                    </div>
                                                                    <!-- /btn-group -->

                                                                    <input type="text" id="datepickermaxRevised" class="form-control maxCancelled">
                                                                    <input hidden id="maxRevised" type="date">

                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <table id="client-revised-account" class="tableendorse table-hover table-condensed" width="100%">
                                                    <thead>
                                                    <tr>
                                                        <th>Id</th>
                                                        <th>Account Name</th>
                                                        <th>Date Endorsed</th>
                                                        <th>Time Endorsed</th>
                                                        <th>Address</th>
                                                        <th>City/Municipality</th>
                                                        <th>Provinces</th>
                                                        <th>Type of Request</th>
                                                        <th>Type of Loan</th>
                                                        <th>Requestor</th>
                                                        <th>Remarks</th>
                                                        <th>Entry As</th>
                                                        <th>Status</th>
                                                        <th>Time</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                    </thead>
                                                    <tfoot>
                                                    <tr>
                                                        <th>Id</th>
                                                        <th>Account Name</th>
                                                        <th>Date Endorsed</th>
                                                        <th>Time Endorsed</th>
                                                        <th>Address</th>
                                                        <th>City/Municipality</th>
                                                        <th>Provinces</th>
                                                        <th>Type of Request</th>
                                                        <th>Type of Loan</th>
                                                        <th>Requestor</th>
                                                        <th>Remarks</th>
                                                        <th>Entry As</th>
                                                        <th>Status</th>
                                                        <th>Time</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                        <!-- /.tab-content -->
                                    </div>
                                    <!-- nav-tabs-custom -->
                                </div>
                                <!-- /.col -->
                            </div>
                            <span id="download_report"></span>
                            <span id="download_report_revised"></span>

                        </div>
                        <!-- /.box-body -->
                    {{--<div class="box-footer">--}}
                    {{--Footer--}}
                    {{--</div>--}}
                    <!-- /.box-footer-->
                    </div>
                    <!-- /.box -->
                </section>
            </div>

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->


    {{--NOTE MODAL--}}
    <div class="modal modal-default fade" id="modal-note">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Add Note</h4>
                </div>
                <div class="modal-body">
                    <span id="txtAreaNote"></span>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="btnSaveNote" value="Save Note">Save Note</button>
                    <button type="button" class="btn btn-primary" id="btnUpdateNote" value="Update Note">Update Note</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    {{--END OF NOTE MODAL--}}

    {{--VIEW FULL INFO MODAL--}}
    <div class="modal fade" id="modal-view-info-client">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">ENDORSEMENT</h4>
                </div>
                <div class="modal-body">
                    <span class="badge bg-light-blue-gradient" id="titleEndorsement-client"><h5>ENDORSEMENT INFORMATION</h5></span>
                    {{--INFO START HERE--}}
                    <span id="spanhere-client"></span>
                    {{--END OF INFO--}}
                    <br id="spanhere-client"/>
                    {{--COBORROWER HERE--}}
                    <table border="2" width="100%" id="otherInfoSpan-client"></table>
                    {{--END OF COBORROWER--}}
                    <br id="otherInfoSpan-client"/>
                    {{--EMPLOYER HERE--}}
                    <table border="2" width="100%" id="otherEmployerSpan-client"></table>
                    {{--END OF COBORROWER--}}
                    {{--BUSINESS HERE--}}
                    <table border="2" width="100%" id="otherBusinessSpan-client"></table>
                    {{--END OF BUSINESS--}}
                    <span class="badge bg-light-blue-gradient" id="titleHistory-client"><h5>ENDORSEMENT HISTORY</h5></span>
                    {{--INFO START HERE--}}
                    <div style="overflow:scroll; height:300px;">
                        <table border="2" width="100%" id="history-client"></table>
                    </div>
                    {{--END OF INFO--}}
                    {{--ADD NOTE--}}
                    {{--<span id="txtAreaNote"></span>--}}
                    <div class="form-group">
                        <label>Additional Note:</label>
                        <textarea class="form-control" rows="10" placeholder="Enter ..." id="txtNote"></textarea>
                    </div>
                    {{--END NOTE--}}
                </div>
                <div class="modal-footer">
                    <span id="spanNotes"></span>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    {{--END OF VIEW FULL INFO MODAL--}}

{{--@endsection--}}

{{--@push('leftsidebar')--}}
    {{--@include('client.client-leftsidebar')--}}
{{--@endpush--}}

{{--@push('jscript')--}}

    {{--<script src="https://cdn.datatables.net/buttons/1.5.0/js/dataTables.buttons.min.js"></script>--}}
    {{--<script src="https://cdn.datatables.net/buttons/1.5.0/js/buttons.flash.min.js"></script>--}}
    {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>--}}
    {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>--}}
    {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>--}}

    {{--<script src="https://cdn.datatables.net/buttons/1.5.0/js/buttons.html5.min.js"></script>--}}
    {{--<script src="https://cdn.datatables.net/buttons/1.5.0/js/buttons.print.min.js"></script>--}}
    {{--<script src="{{ asset('jscript/client.js?n='.$javs) }}"></script>--}}
{{--@endpush--}}