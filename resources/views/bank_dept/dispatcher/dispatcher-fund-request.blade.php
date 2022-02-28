{{--@extends('layouts.master')--}}
{{--<style>--}}

    {{--#table-ci-process-accounts_paginate .pagination .paginate_button a{--}}

        {{--font-size: 10px;--}}
        {{--margin-left: -10px;--}}
        {{--margin-right: -10px;--}}
        {{--margin-bottom: -10px;--}}

    {{--}--}}
    {{--#table-ci-process-accounts_paginate .pagination{--}}
        {{--margin-left: -70px;--}}
    {{--}--}}

    {{--#table-ci-process-accounts_info{--}}
        {{--display:none;--}}
    {{--}--}}

    {{--/*.datepicker {*/--}}
        {{--/*position: relative !important;*/--}}
        {{--/*top: -290px !important;*/--}}
        {{--/*left: 0 !important;*/--}}
    {{--/*}*/--}}


{{--</style>--}}
{{--@section('content')--}}

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Fund Request
                <small>Dispatcher's</small>
            </h1>


        <!-- Main content -->
        <section class="content">

            <!-- Default box -->
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Fund Request Panel</h3>

                    {{--<div class="box-tools pull-right">--}}
                        {{--<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"--}}
                                {{--title="Collapse">--}}
                            {{--<i class="fa fa-minus"></i></button>--}}
                        {{--<button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">--}}
                            {{--<i class="fa fa-times"></i></button>--}}
                    {{--</div>--}}
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="box box-danger">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Add Fund Request</h3>
                                </div>
                                <div class="box-header with-border">
                                    <div class="box-body">
                                        <form enctype="multipart/form-data" id="sendFundRequest">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="selFciName:">FCI Name:</label>
                                                        <select class="select2 form-control" id="selFciName" style="width: 100%;">
                                                            <option value="---">---PLEASE SELECT C.I---</option>
                                                            @foreach($fcis as $fci)
                                                                <option value="{{ $fci->id }}">{{ $fci->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            {{--<div class="row">--}}
                                                {{--<div class="col-md-12">--}}
                                                    {{--<div class="form-group">--}}
                                                        {{--<label style="margin-top: 10px" for="selSaoName:">SAO Name:</label>--}}
                                                        {{--<select class="select2 form-control" id="selSaoName" style="width: 100%;">--}}
                                                            {{--@foreach($saos as $sao)--}}
                                                                {{--<option value="{{ $sao->id }}">{{ $sao->name }}</option>--}}
                                                            {{--@endforeach--}}
                                                        {{--</select>--}}
                                                    {{--</div>--}}
                                                {{--</div>--}}
                                            {{--</div>--}}
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">

                                                        {{--<input id="normal_req" type="radio" name="type" checked value="Normal Request"><b>Normal Request</b>--}}
                                                        {{--<span id = "checkifShellCi"><input id="shell_req" type="radio" name="type" value="Shell Card"><b>Shell Card</b></span> --}}
                                                        <label for="txtFundAmount">Fund Request Amount: <small id="txtFundAmount_label" hidden style="color: red;">(NOTE: AMOUNT IS OPTIONAL)</small> </label>
                                                        <input type="number" class="form-control" id="txtFundAmount" value="0">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="txtFundRemarks">Fund Remarks:</label>
                                                        <textarea id="txtFundRemarks" class="form-control" placeholder="Remarks Here..."></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="">Selected Account/s:</label>
                                                        <table id="table_selected_account_new_list" class="tableendorse table-hover table-condensed" width="100%" style="font-size: 13px;">
                                                            <thead>
                                                            <tr>
                                                                <th>ID</th>
                                                                <th>ACCOUNT INFORMATION</th>
                                                                <th>ACTION</th>
                                                            </tr>
                                                            <tbody>
                                                            </tbody>
                                                            </thead>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <input type="button" class="btn btn-flat btn-block bg-olive pull-right" id="btnReqFund" value="Send Request">
                                                    <button type="button" class = "btn btn-flat btn-block bg-gray pull-right" id = "btnCantShell" disabled>Fund Request not available</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <span id="ci-endorsements-table-span"></span><br>
                            <b><span id="span_count"></span></b>
                            <input type="button" hidden class="btn btn-flat" id="btn_select_all" value="Select All">
                        </div>
                        <div class="col-md-4">
                            <div class="row" style="margin-top: 20px;">
                                <div class="col-md-12 pull-right">
                                    <div class="box box-danger">
                                        <div class="box-header with-border">
                                            <h3 class="box-title">Date Endorsed Sorting</h3>
                                        </div>
                                        <div class="box-body">
                                            <div class="form-group">
                                                <input type="radio" class="viewable" name="viewable_pends" id="rad_all_pends" value="All">Default (All accounts less than 30days)
                                                <input type="radio" class="viewable" name="viewable_pends" id="rad_daterange_pends" value="Date Range">Date Range

                                                {{--<div class="date_range_conts pull-right">--}}
                                                {{--Search Option:--}}
                                                {{--<select id="select_search_option">--}}
                                                {{--<option value="dispatcher_request">Dispatcher Request Date</option>--}}
                                                {{--<option value="sao_approved_date">SAO Approved Date</option>--}}
                                                {{--<option value="finance_approved_date">Finance Approved Date</option>--}}
                                                {{--<option value="finance_sent_date">Finance Sent Date</option>--}}
                                                {{--<option value="finance_confirm_date">Finance Confirm Date</option>--}}
                                                {{--</select>--}}
                                                {{--</div>--}}

                                                <div class="input-group margin date_range_conts">
                                                    <div class="input-group-btn">
                                                        <button type="button" class="btn btn-default">From</button>
                                                    </div>
                                                    <!-- /btn-group -->
                                                    <input type="text" id="datepickermin" class="datepicks form-control min">
                                                    <input hidden id="min" type="date">

                                                    <div class="input-group-btn">
                                                        <button type="button" class="btn btn-default">To</button>
                                                    </div>
                                                    <!-- /btn-group -->
                                                    <input type="text" id="datepickermax" class="datepicks form-control max">
                                                    <input hidden id="max" type="date">
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div style = "overflow:scroll; margin-top: 10px">
                                <div>
                                    <table id="table-ci-process-accounts" class="tableendorse table-hover table-condensed" width="100%" style="font-size: 13px;">
                                        <thead>
                                        <tr>
                                            <th>ACTION</th>
                                            <th>ID</th>
                                            <th>ACCOUNT NAME</th>
                                            <th>ADDRESS</th>
                                            <th>TYPE OF SUBJECT</th>
                                            <th>CITY/MUNICIPALITY</th>
                                            <th>PROVINCE</th>
                                            <th>TYPE OF REQUEST</th>
                                            <th>DATE ENDORSED</th>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <!-- Custom Tabs -->
                            <div class="nav-tabs-custom">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a href="#tab_0_fund" data-toggle="tab">General Fund Request</a></li>
                                    <li><a href="#tab_1_fund" data-toggle="tab">Pending Fund Request</a></li>
                                    <li><a href="#tab_2_fund" data-toggle="tab">Success Fund Request</a></li>
                                    <li><a href="#tab_3_fund" data-toggle="tab">Disapproved Fund Request</a></li>
                                    <li><a href="#tab_4_fund" data-toggle="tab">Cancelled Fund Request</a></li>
                                    <li><a href="#tab_5_fund" data-toggle="tab">Fund Checker</a></li>
                                    <li><a href="#tab_6_fund" data-toggle="tab">Historical Archive</a></li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="tab_0_fund">
                                        <table id = "fund-request-general-dispatcher-table" class="display table-hover table-condensed" width=100%>
                                            <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Request Date and Time</th>
                                                <th>C.I Name</th>
                                                <th>Requested Amount</th>
                                                <th>Approved Amount by SAO/Management</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tfoot>
                                            <tr>
                                                <th>ID</th>
                                                <th>Request Date and Time</th>
                                                <th>C.I Name</th>
                                                <th>Requested Amount</th>
                                                <th>Approved Amount by SAO/Management</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                    <div class="tab-pane" id="tab_1_fund">
                                        <table id="table-advance-fund-request" class="tableendorse table-hover table-condensed" width="100%">
                                            <thead>
                                            <tr>
                                                <th></th>
                                                <th>Id</th>
                                                <th>FCI Name</th>
                                                <th>SAO Name</th>
                                                <th>Type of Fund</th>
                                                <th>Requested Amount</th>
                                                <th>For These Account/s</th>
                                                <th>Requested Date</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tfoot>
                                            <tr>
                                                <th></th>
                                                <th>Id</th>
                                                <th>FCI Name</th>
                                                <th>SAO Name</th>
                                                <th>Type of Fund</th>
                                                <th>Requested Amount</th>
                                                <th>For These Account/s</th>
                                                <th>Requested Date</th>
                                                <th>Action</th>
                                            </tr>
                                            </tfoot>
                                        </table>

                                    </div>
                                    <div class="tab-pane" id="tab_2_fund">
                                        <table id="table-advance-fund-success" class="tableendorse table-hover table-condensed" width="100%">
                                            <thead>
                                            <tr>
                                                <th></th>
                                                <th>Id</th>
                                                <th>FCI Name</th>
                                                <th>SAO Name</th>
                                                <th>Type of Fund</th>
                                                <th>Requested Amount</th>
                                                <th>For These Account/s</th>
                                                <th>Requested Date</th>
                                                <th>Status</th>
                                            </tr>
                                            </thead>
                                            <tfoot>
                                            <tr>
                                                <th></th>
                                                <th>Id</th>
                                                <th>FCI Name</th>
                                                <th>SAO Name</th>
                                                <th>Type of Fund</th>
                                                <th>Requested Amount</th>
                                                <th>For These Account/s</th>
                                                <th>Requested Date</th>
                                                <th>Status</th>
                                            </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                    <div class="tab-pane" id="tab_3_fund">
                                        <table id="table-advance-fund-disapproved" class="tableendorse table-hover table-condensed" width="100%">
                                            <thead>
                                            <tr>
                                                <th></th>
                                                <th>Id</th>
                                                <th>FCI Name</th>
                                                <th>SAO Name</th>
                                                <th>Type of Fund</th>
                                                <th>Requested Amount</th>
                                                <th>For These Account/s</th>
                                                <th>Requested Date</th>
                                                <th>Status</th>
                                            </tr>
                                            </thead>
                                            <tfoot>
                                            <tr>
                                                <th></th>
                                                <th>Id</th>
                                                <th>FCI Name</th>
                                                <th>SAO Name</th>
                                                <th>Type of Fund</th>
                                                <th>Requested Amount</th>
                                                <th>For These Account/s</th>
                                                <th>Requested Date</th>
                                                <th>Status</th>
                                            </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                    <div class="tab-pane" id="tab_4_fund">
                                        <table id="table-advance-fund-cancelled" class="tableendorse table-hover table-condensed" width="100%">
                                            <thead>
                                            <tr>
                                                <th></th>
                                                <th>Id</th>
                                                <th>FCI Name</th>
                                                <th>SAO Name</th>
                                                <th>Type of Fund</th>
                                                <th>Requested Amount</th>
                                                <th>For These Account/s</th>
                                                <th>Requested Date</th>
                                                <th>Status</th>
                                            </tr>
                                            </thead>
                                            <tfoot>
                                            <tr>
                                                <th></th>
                                                <th>Id</th>
                                                <th>FCI Name</th>
                                                <th>SAO Name</th>
                                                <th>Type of Fund</th>
                                                <th>Requested Amount</th>
                                                <th>For These Account/s</th>
                                                <th>Requested Date</th>
                                                <th>Status</th>
                                            </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                    <div class="tab-pane" id="tab_5_fund">
                                        <table id="table-advance-fund-checker" class="tableendorse table-hover table-condensed" width="100%">
                                            <thead>
                                            <tr>
                                                <th>FCI Name</th>
                                                <th>Fund</th>
                                            </tr>
                                            </thead>
                                            <tfoot>
                                            <tr>
                                                <th>FCI Name</th>
                                                <th>Fund</th>
                                            </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                    <div class="tab-pane" data-toggle="tab" id="tab_6_fund">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="">Select Municipality:</label>
                                                    <select name="" id="historical_muni_id" class="select2" style="width: 100%">
                                                        <option value="">------</option>
                                                        @foreach($all_muni as $chunk_muni)
                                                            <option value="{{$chunk_muni->id}}">{{$chunk_muni->muni_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <table id="table-disp-historical-archive" class="tableendorse table-hover table-condensed" width="100%">
                                            <thead>
                                            <tr>
                                                <th></th>
                                                <th>Id</th>
                                                <th>FCI Name</th>
                                                <th>Address</th>
                                                <th>Requested Amount</th>
                                                <th>Requested Date</th>
                                            </tr>
                                            </thead>
                                            <tfoot>
                                            <tr>
                                                <th></th>
                                                <th>Id</th>
                                                <th>FCI Name</th>
                                                <th>Address</th>
                                                <th>Requested Amount</th>
                                                <th>Requested Date</th>
                                            </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{--other details--}}
                    <script id="details-template" type="text/x-handlebars-template">
                            <div class="label label-info pull-left" style="font-size: 12px">Accounts for this Fund</div>
                            <table style="font-size: 15px;" class="tableendorse table details-table" id="posts-@{{id}}">
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


                    <script id="details-template-success" type="text/x-handlebars-template">
                        <div class="label label-info pull-left" style="font-size: 12px">Accounts for this Fund</div>
                        <table style="font-size: 15px;" class="tableendorse table details-table" id="success_posts-@{{id}}">
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

                    <script id="details-template-disapproved" type="text/x-handlebars-template">
                        <div class="label label-info pull-left" style="font-size: 12px">Accounts for this Fund</div>
                        <table style="font-size: 15px;" class="tableendorse table details-table" id="disapproved_posts-@{{id}}">
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

                    <script id="details-template-cancel" type="text/x-handlebars-template">
                        <div class="label label-info pull-left" style="font-size: 12px">Accounts for this Fund</div>
                        <table style="font-size: 15px;" class="tableendorse table details-table" id="cancel_posts-@{{id}}">
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

                </div>
                <!-- /.box-body -->
                {{--<div class="box-footer">--}}
                    {{--Footer--}}
                {{--</div>--}}
                <!-- /.box-footer-->
            </div>
            <!-- /.box -->
        </section>
        </section>
    </div>
        <!-- /.content -->
    <!-- /.content-wrapper -->

    {{--ADDITIONAL REQUEST MODAL--}}
    <div class="modal modal-default fade" id="modal_additional_fund_request">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Addional Fund Request</h4>
                </div>
                <div class="modal-body">
                    <center><p><b>FUND REQUEST INFORMATION</b><br>
                            <span id="span_info_add_request"></span>
                        </p></center>

                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="txtFundAmount">Fund Request Amount: <small id="txtFundAmount_add_label" hidden style="color: red;">(NOTE: AMOUNT IS OPTIONAL)</small> </label>
                                    <input type="number" class="form-control" id="txtFundAmount_add" value="0">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="txtFundRemarks_add">Fund Remarks:</label>
                                    <textarea id="txtFundRemarks_add" class="form-control" placeholder="Remarks Here..."></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
                    <button type="button" id="btn_add_req" class="btn btn-primary pull-right">Send Request</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    {{--ADDITIONAL REQUEST MODAL end--}}
{{--@endsection--}}

{{--@push('leftsidebar')--}}
    {{--@include('bank_dept.dispatcher.dispatcher-leftsidebar')--}}
{{--@endpush--}}

{{--@push('jscript')--}}


    {{--<link rel="stylesheet" href="https://cdn.datatables.net/rowreorder/1.2.0/css/rowReorder.dataTables.min.css">--}}
    {{--<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.1.1/css/responsive.dataTables.min.css">--}}
    {{--<script src="https://cdn.datatables.net/rowreorder/1.2.0/js/dataTables.rowReorder.min.js"></script>--}}
    {{--<script src="{{ asset('jscript/endorsement.js') }}"></script>--}}

    {{--handlebar--}}
    {{--<script type='text/javascript' src="https://cdnjs.cloudflare.com/ajax/libs/handlebars.js/4.0.11/handlebars.js"></script>--}}
    {{--<script src="{{ asset('jscript/dispatcher.js') }}"></script>--}}
    {{--<script src="{{ asset('jscript/fund-request-tables-dispatcher.js') }}"></script>--}}

{{--@endpush--}}
