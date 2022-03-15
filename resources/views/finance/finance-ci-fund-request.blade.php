{{--@extends('layouts.master')--}}

{{--<style>--}}

    {{--.wrapper1, .wrapper2 {--}}
        {{--width: 100%;--}}
        {{--overflow-x: scroll;--}}
        {{--overflow-y:hidden;--}}
        {{--white-space: normal;--}}
    {{--}--}}

    {{--.wrapper1 {height: 10%; }--}}
    {{--.wrapper2 {height: 100%; }--}}

    {{--.div1 {--}}
        {{--width:120%;--}}
        {{--height: 10%;--}}
    {{--}--}}

    {{--.div2 {--}}
        {{--width:120%;--}}
        {{--height: 110%;--}}
        {{--overflow: auto;--}}
    {{--}--}}

{{--</style>--}}


{{--@section('content')--}}
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Fund Approval and ATM
                <small>Requests</small>
            </h1>
        </section>
        <!-- Main content -->
        <section class="content">
            <!-- Default box -->
            <div class="box">
                <div class="box-body">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-2">
                                <!-- small box -->
                                <div class="small-box bg-aqua">
                                    <div class="inner">
                                        <h3 id = "showFundReqCount">-</h3>

                                        <p>Total New Requests</p>
                                    </div>
                                    {{--<div class="icon">--}}
                                        {{--<i class="ion ion-bag"></i>--}}
                                    {{--</div>--}}
                                    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <!-- ./col -->
                            <div class="col-md-2">
                                <!-- small box -->
                                <div class="small-box bg-green">
                                    <div class="inner">
                                        <h3 id = "showFundDoneCount">-</h3>

                                        <p>Total Delivered Requests</p>
                                    </div>
                                    {{--<div class="icon">--}}
                                        {{--<i class="ion ion-stats-bars"></i>--}}
                                    {{--</div>--}}
                                    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <!-- ./col -->
                            <div class="col-md-2">
                                <!-- small box -->
                                <div class="small-box bg-yellow">
                                    <div class="inner">
                                        <h3 id = "showFundPendingeCount">-</h3>

                                        <p>Total On-process Requests</p>
                                    </div>
                                    {{--<div class="icon">--}}
                                        {{--<i class="ion ion-person-add"></i>--}}
                                    {{--</div>--}}
                                    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <!-- ./col -->
                            <div class="col-md-2">
                                <!-- small box -->
                                <div class="small-box bg-orange">
                                    <div class="inner">
                                        <h3 id = "showFundHoldCount">-</h3>

                                        <p>Total On-Hold Requests</p>
                                    </div>
                                    {{--<div class="icon">--}}
                                        {{--<i class="ion ion-pie-graph"></i>--}}
                                    {{--</div>--}}
                                    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <!-- small box -->
                                <div class="small-box bg-red">
                                    <div class="inner">
                                        <h3 id = "showFundCancelCount">-</h3>

                                        <p>Total Cancelled Requests</p>
                                    </div>
                                    {{--<div class="icon">--}}
                                    {{--<i class="ion ion-pie-graph"></i>--}}
                                    {{--</div>--}}
                                    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <!-- small box -->
                                <div class="small-box bg-blue">
                                    <div class="inner">
                                        <h3 id = "showFundUnliqNewCount">-</h3>

                                        <p>Total Request from Unliquidated</p>
                                    </div>
                                    {{--<div class="icon">--}}
                                    {{--<i class="ion ion-pie-graph"></i>--}}
                                    {{--</div>--}}
                                    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <!-- ./col -->
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="nav-tabs-custom">
                                    <ul class="nav nav-tabs">
                                        <li class="active"><a href="#tab_1" id="click_tab_approved" data-toggle="tab" class = "finance_ci_fund_class">Approved Requests<span style="margin-left:10px" id="finance_fund_req_notif_approved_doubs" class="pull-right-container"></span></a></li>
                                        <li class=""><a href="#tab_2" id="click_tab_approved" data-toggle="tab" class = "finance_ci_fund_class">For Online Upload</a></li>
                                        <li class=""><a href="#tab_b" id="click_tab_approved" data-toggle="tab" class = "finance_ci_fund_class">Successful Fund Requests</a></li>
                                        <li class=""><a href="#tab_3" id="click_tab_approved" data-toggle="tab" class = "finance_ci_fund_class">ATM/Shell Card - Registration</a></li>
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="tab_1">
                                                    {{--TABLE STARTS HERE--}}
                                            <table id="table_fund_req_approved_finance" class="tableendorse display table-hover table-condensed" style="width:100%">
                                                <thead>
                                                <tr>
                                                    <th>REQUEST ID</th>
                                                    <th>(FOR) CREDIT INVESTIGATOR</th>
                                                    <th>(Dispatcher) REQUESTOR</th>
                                                    <th>(SAO) REQUESTOR</th>
                                                    <th>REQUESTED DATE</th>
                                                    <th>TYPE OF FUND</th>
                                                    <th>AMOUNT</th>
                                                    <th>FOR THESE ACCOUNT/S</th>
                                                    <th>KTPN NO. / CONTROL NO. SENDER NAME</th>
                                                    <th>STATUS</th>
                                                    <th>FINANCE REMARKS</th>
                                                    <th>ACTION</th>
                                                </tr>
                                                </thead>
                                                <tfoot>
                                                <tr>
                                                    <th>REQUEST ID</th>
                                                    <th>(FOR) CREDIT INVESTIGATOR</th>
                                                    <th>(Dispatcher) REQUESTOR</th>
                                                    <th>(SAO) REQUESTOR</th>
                                                    <th>REQUESTED DATE</th>
                                                    <th>TYPE OF FUND</th>
                                                    <th>AMOUNT</th>
                                                    <th>FOR THESE ACCOUNT/S</th>
                                                    <th>KTPN NO. / CONTROL NO. SENDER NAME</th>
                                                    <th>STATUS</th>
                                                    <th>FINANCE REMARKS</th>
                                                    <th>ACTION</th>
                                                </tr>
                                                </tfoot>
                                            </table>
                                                    {{--END OF TABLE--}}
                                        </div>
                                        <div class = "tab-pane" id = "tab_2">
                                            <div class = "row">
                                                <div class = "col-md-12">
                                                    <div class = "box box-danger">
                                                        <div class = "row" style = "padding-top: 30px;">
                                                            <div class = "col-md-2">
                                                                <h4>Filter Details</h4>

                                                                <div class = "row" style = "padding-top : 20px;">
                                                                    <div class = "col-md-12">
                                                                        <label for="">Sort by method:</label>
                                                                        <select  id="btnSortCiApproved" class = "form-control">
                                                                            <option value="-">-</option>
                                                                            <option value="REMITTANCE">REMITTANCE</option>
                                                                            <option value="ATM">ATM</option>
                                                                            {{--<option value="SHELL CARD">SHELL CARD ONLY</option>--}}
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class = "row" style = "padding-top : 20px;" id = "showHideBank">
                                                                    <div class = "col-md-12">
                                                                        <label for="">Sort Bank:</label>
                                                                        <select  id="btnSortCiBank" class = "form-control"></select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class = "col-md-10"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id = "hideshowTable">
                                                <table id="table_fund_for_online_upload" class="tableendorse display table-hover table-condensed" style="width:100%">
                                                    <thead>
                                                    <tr>
                                                        <th>Requested Date</th>
                                                        <th>FCI Name</th>
                                                        <th>ATM/Card</th>
                                                        <th>KTPN No./Control No./Sender Name</th>
                                                        <th>Account Number</th>
                                                        <th>Amount</th>
                                                        <th>Action</th>
                                                    </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                            <div class = "row">
                                                <div class = "col-md-12">
                                                    <button class = "arrayforDoneAll btn btn-md btn-info pull-right" id = "arrayforDoneAll">Done all <span id = "nameToSelectDone"></span></button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="tab_b">
                                            {{--TABLE STARTS HERE--}}
                                            <div class="box">
                                                <div class="box-body">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="box box-danger">
                                                                <div class="box-title">
                                                                    <h4>Date Range Sorting ( Date of Done)</h4>
                                                                </div>
                                                                <div class="box-body">
                                                                    <div class="form-group">
                                                                        <input type="radio" name="dateraaaaaange" value="all" class="fundSucRange" id="fundSucRangemin">
                                                                        <label for="fundSucRangemin">All</label>

                                                                        <input type="radio" name="dateraaaaaange" value="date_range" checked class="fundSucRange" id="fundSucRangemax">
                                                                        <label for="fundSucRangemax">Date Range</label>
                                                                    </div>
                                                                    <div class="form-group" id="fundSucRangeDaterange">
                                                                        <div class="input-group margin date_range_conts_report">
                                                                            <div class="input-group-btn">
                                                                                <button type="button" class="btn btn-default">From</button>
                                                                            </div>
                                                                            <!-- /btn-group -->
                                                                            {{--<input type="text" id="datepicker_report" class="form-control min">--}}
                                                                            <input id="sucFundReq_min" class="form-control" type="date" value="{{ date("Y-m-d") }}">

                                                                            <div class="input-group-btn">
                                                                                <button type="button" class="btn btn-default">To</button>
                                                                            </div>
                                                                            <!-- /btn-group -->
                                                                            <input id="sucFundReq_max" class="form-control" type="date" value="{{ date("Y-m-d") }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <table id="table_success_req_finance" class="tableendorse display table-hover table-condensed" style="width:100%">
                                                                <thead>
                                                                <tr>
                                                                    <th>REQUEST ID</th>
                                                                    <th>(FOR) CREDIT INVESTIGATOR</th>
                                                                    <th>REQUESTED DATE</th>
                                                                    <th>TYPE OF FUND</th>
                                                                    <th>AMOUNT</th>
                                                                    <th>FOR THESE ACCOUNT/S</th>
                                                                    <th>KTPN NO. / CONTROL NO. SENDER NAME</th>
                                                                    <th>STATUS</th>
                                                                    {{--<th>FINANCE REMARKS</th>--}}
                                                                    <th>ACTION</th>
                                                                </tr>
                                                                </thead>
                                                                <tfoot>
                                                                <tr>
                                                                    <th>REQUEST ID</th>
                                                                    <th>(FOR) CREDIT INVESTIGATOR</th>
                                                                    <th>REQUESTED DATE</th>
                                                                    <th>TYPE OF FUND</th>
                                                                    <th>AMOUNT</th>
                                                                    <th>FOR THESE ACCOUNT/S</th>
                                                                    <th>KTPN NO. / CONTROL NO. SENDER NAME</th>
                                                                    <th>STATUS</th>
                                                                    {{--<th>FINANCE REMARKS</th>--}}
                                                                    <th>ACTION</th>
                                                                </tr>
                                                                </tfoot>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            {{--END OF TABLE--}}
                                        </div>
                                        <div class="tab-pane" id="tab_3">
                                            <div class="box-body">
                                                <div class = "col-md-5">
                                                    <div class = "box box-danger">
                                                        <h3 style = "font-family: Georgia,serif; text-align: center">Add ATM/Card Info</h3>
                                                        <div class = "row" style = "padding-bottom : 10px;">
                                                            <div class="col-md-8">
                                                                <label for="selFCIName">FCI Name:</label>
                                                                <select style="width: 100%;" class="select2 form-control" id="selFCIName">
                                                                </select>
                                                            </div>
                                                            <div class = "col-md-2"></div>
                                                            <div class = "col-md-2">
                                                                <label for="">ID no. :</label>
                                                                <input type="text" class = "form-control" id = "ci_id_no_form" disabled>
                                                            </div>
                                                        </div>
                                                        <h4 style = "font-family: Georgia,serif; text-align: center">ATM Details</h4>
                                                        <div class = "row" style = "padding-top: 20px; padding-bottom: 20px;" >
                                                            <div class = "col-md-4"></div>
                                                            <div class = "col-md-4">
                                                                <button class = "btn btn btn-success" id = "add_bank_ci">Add Bank Information<i class = "fa fa-fw fa-plus"></i></button>
                                                            </div>
                                                            <div class = "col-md-2"></div>
                                                            <div class = "col-md-2">
                                                                <span id = "removeAllBank"></span>
                                                            </div>
                                                        </div>
                                                        <span id = "addDetailsBank"></span>
                                                        <div id = "showShell">

                                                        </div>

                                                        <div style = "padding-top : 20px; padding-bottom: 10px;" class = "row">
                                                            <div class = "col-md-12">
                                                                <button type = "button" id = "btnSaveCiAtmRem" class = "btn btn-info pull-right" style = "width: 20%; margin-right : 15px;">Save Details
                                                                    <span id = "loadingCiAtmShell" style = "padding-left : 15px; " hidden><img src= "{{asset('dist/img/loading.gif')}}" style = "width: 12%"></span>
                                                                </button>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class = "col-md-7">
                                                    <div class = "box box-danger">
                                                        <h3 style = "font-family: Georgia,serif; text-align: center">Bank Information for C.I</h3>
                                                        <div class="col-md-12">
                                                            <table id = "finance-ci-bank-table" class="tableendorse display table-hover table-condensed" width="100%">
                                                                <thead>
                                                                <tr>
                                                                    <th>C.I ID</th>
                                                                    <th>C.I Name</th>
                                                                    <th>Bank Name</th>
                                                                    <th>Account Number</th>
                                                                    <th>Gas Limit(Shell Card)</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                                </thead>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                {{--other details--}}

                <script id="details-template-pending-finance" type="text/x-handlebars-template">
                    <div class="label label-info pull-left" style="font-size: 12px">Accounts for this Fund</div>
                    <table style="font-size: 15px;" class="tableendorse table details-table" id="finance_pending_posts-@{{id}}">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>ACCOUNT NAME</th>
                            <th>ADDRESS</th>
                            <th>CITY/MUNICIPALITY</th>
                            <th>PROVINCE</th>
                            <th>TYPE OF REQUEST</th>
                            <th>DATE ENDORSED</th>
                        </tr>
                        </thead>
                    </table>
                </script>

                <script id="details-template-app-finance" type="text/x-handlebars-template">
                    <div class="label label-info pull-left" style="font-size: 12px">Accounts for this Fund</div>
                    <table style="font-size: 15px;" class="tableendorse table details-table" id="finance_app_posts-@{{id}}">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>ACCOUNT NAME</th>
                            <th>ADDRESS</th>
                            <th>CITY/MUNICIPALITY</th>
                            <th>PROVINCE</th>
                            <th>TYPE OF REQUEST</th>
                            <th>DATE ENDORSED</th>
                        </tr>
                        </thead>
                    </table>
                </script>

                <script id="details-template-app-finance-success" type="text/x-handlebars-template">
                    <div class="label label-info pull-left" style="font-size: 12px">Accounts for this Fund</div>
                    <table style="font-size: 15px;" class="tableendorse table details-table" id="finance_app_posts-success-@{{id}}">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>ACCOUNT NAME</th>
                            <th>ADDRESS</th>
                            <th>CITY/MUNICIPALITY</th>
                            <th>PROVINCE</th>
                            <th>TYPE OF REQUEST</th>
                            <th>DATE ENDORSED</th>
                        </tr>
                        </thead>
                    </table>
                </script>

                <script id="details-template-dec-finance" type="text/x-handlebars-template">
                    <div class="label label-info pull-left" style="font-size: 12px">Accounts for this Fund</div>
                    <table style="font-size: 15px;" class="tableendorse table details-table" id="finance_dec_posts-@{{id}}">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>ACCOUNT NAME</th>
                            <th>ADDRESS</th>
                            <th>CITY/MUNICIPALITY</th>
                            <th>PROVINCE</th>
                            <th>TYPE OF REQUEST</th>
                            <th>DATE ENDORSED</th>
                        </tr>
                        </thead>
                    </table>
                </script>


                <!-- /.box-body -->
                <div class="box-footer">
                </div>
                <!-- /.box-footer-->
            </div>
            <!-- /.box -->

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
{{--@endsection--}}






{{--@push('leftsidebar')--}}
    {{--@include('finance.finance-leftsidebar')--}}
{{--@endpush--}}

{{--@push('jscript')--}}
    {{--handlebar--}}
    {{--<script type='text/javascript' src="https://cdnjs.cloudflare.com/ajax/libs/handlebars.js/4.0.11/handlebars.js"></script>--}}
    {{--<script src="{{ asset('jscript/finance.js') }}"></script>--}}
    {{--<script src="{{ asset('jscript/fund-request-tables-finance.js') }}"></script>--}}

    {{--<script>--}}
        {{--$(function(){--}}
            {{--$(".wrapper1").scroll(function(){--}}
                {{--$(".wrapper2").scrollLeft($(".wrapper1").scrollLeft());--}}
            {{--});--}}
            {{--$(".wrapper2").scroll(function(){--}}
                {{--$(".wrapper1").scrollLeft($(".wrapper2").scrollLeft());--}}
            {{--});--}}
        {{--});--}}
    {{--</script>--}}

{{--@endpush--}}
