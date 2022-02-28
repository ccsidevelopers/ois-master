{{--@extends('layouts.master')--}}

{{--<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs/jszip-2.5.0/pdfmake-0.1.18/dt-1.10.12/af-2.1.2/b-1.2.2/b-colvis-1.2.2/b-flash-1.2.2/b-html5-1.2.2/b-print-1.2.2/cr-1.3.2/fc-3.2.2/fh-3.1.2/kt-2.1.3/r-2.1.0/rr-1.1.2/sc-1.4.2/se-1.2.0/datatables.min.css"/>--}}

{{--<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.1/css/buttons.dataTables.min.css">--}}
{{--<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">--}}
{{--<link href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/themes/south-street/jquery-ui.min.css" rel="stylesheet" type="text/css" />--}}
{{--<link href="https://cdn.datatables.net/plug-ins/725b2a2115b/integration/jqueryui/dataTables.jqueryui.css" rel="stylesheet" type="text/css" />--}}


{{--@section('content')--}}

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Billing
            <small>Accounts</small>
        </h1>

    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="box">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="nav-tabs-custom">
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#tab_report" id="fa_expenses_tab" data-toggle="tab" class = "fa_billing_class">Bank Billing Report</a></li>
                                <li class=""><a href="#tab_report_cc" data-toggle="tab" class = "fa_billing_class">B.I Billing Report</a></li>
                                <li class="" id = "click_billing_info"><a href="#tab_bil_rep" id="fa_expenses_tab" data-toggle="tab" class = "fa_billing_class">Billing Information</a></li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab_report">
                                    <div class="box">
                                        <div class="box-body">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="box box-info">
                                                        <div class="box-header with-border">
                                                            <div class="box-title">
                                                                Bank Selection
                                                            </div>
                                                        </div>
                                                        <div class="box-body">
                                                            <div class="box-body">
                                                                <div class="form-group">
                                                                    <label>Select:</label>
                                                                    <select id="select_bank_billing" class="form-control select2" style="width: 100%;">
                                                                        <option value="-">-</option>
                                                                        @foreach($banks_billing as $bank)
                                                                            <option value="{{ $bank->id }} {{ old('ciID') }}">{{ $bank->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>

                                                                <div class="form-group">
                                                                    <input type="radio" class="viewable" name="view_accounts" id="rad_all_accounts" value="All">All
                                                                    <input type="radio" class="viewable" name="view_accounts" id="rad_all_accounts" value="Date Range">Date Range

                                                                    <div class="input-group margin date_range_conts" style="display: none">
                                                                        <div class="input-group-btn">
                                                                            <button type="button" class="btn btn-default">From</button>
                                                                        </div>
                                                                        <!-- /btn-group -->
                                                                        <input type="text" id="datepickermin" class="datepicks form-control min" readonly>
                                                                        <input hidden id="min" type="date">

                                                                        <div class="input-group-btn">
                                                                            <button type="button" class="btn btn-default">To</button>
                                                                        </div>
                                                                        <!-- /btn-group -->
                                                                        <input type="text" id="datepickermax" class="datepicks form-control max" readonly>
                                                                        <input hidden id="max" type="date">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="box box-info">
                                                        <div class="box-header">
                                                            <h3 class="box-title">Billing Reports (Page length maximum of 100 items.)</h3>
                                                        </div>
                                                        <div class="box-body">
                                                            <div style = " height : 100%; overflow: scroll">
                                                                {{--<button class="form-group" id="btn_export">Export to Excel</button>--}}
                                                                <table id="billing-table-rate" class="tableendorse table-hover table-condensed" width="100%">
                                                                    <thead>
                                                                    <tr>
                                                                        <th>ID</th>
                                                                        <th>DATE ENDORSED</th>
                                                                        <th>TIME ENDORSED</th>
                                                                        <th>DATE DUE</th>
                                                                        <th>TIME DUE</th>
                                                                        <th>ACCOUNT NAME</th>
                                                                        <th>ADDRESS</th>
                                                                        <th>CITY/MUNICIPALITY</th>
                                                                        <th>PROVINCE</th>
                                                                        <th>TYPE OF REQUEST</th>
                                                                        <th>BANK NAME</th>
                                                                        <th>STATUS</th>
                                                                        <th>PICTURE STATUS</th>
                                                                        <th>RATE</th>
                                                                        <th>ENTRY AS</th>
                                                                        <th>DATE SENT</th>
                                                                        <th>TIME SENT</th>
                                                                        <th>BILLING STATUS</th>
                                                                        <th>APPLIED RULE</th>
                                                                    </tr>
                                                                    </thead>
                                                                    {{--<tfoot>--}}
                                                                    {{--<tr>--}}
                                                                    {{--<th>ID</th>--}}
                                                                    {{--<th>DATE ENDORSED</th>--}}
                                                                    {{--<th>TIME ENDORSED</th>--}}
                                                                    {{--<th>DATE DUE</th>--}}
                                                                    {{--<th>TIME DUE</th>--}}
                                                                    {{--<th>ACCOUNT NAME</th>--}}
                                                                    {{--<th>ADDRESS</th>--}}
                                                                    {{--<th>CITY/MUNICIPALITY</th>--}}
                                                                    {{--<th>PROVINCE</th>--}}
                                                                    {{--<th>TYPE OF REQUEST</th>--}}
                                                                    {{--<th>BANK NAME</th>--}}
                                                                    {{--<th>STATUS</th>--}}
                                                                    {{--<th>PICTURE STATUS</th>--}}
                                                                    {{--<th>RATE</th>--}}
                                                                    {{--<th>ENTRY AS</th>--}}
                                                                    {{--<th>DATE SENT</th>--}}
                                                                    {{--<th>TIME SENT</th>--}}
                                                                    {{--<th>BILLING STATUS</th>--}}
                                                                    {{--<th>APPLIED RULE</th>--}}
                                                                    {{--</tr>--}}
                                                                    {{--</tfoot>--}}
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.box-body -->
                                        <div class="box-footer">
                                            Footer
                                        </div>
                                        <!-- /.box-footer-->
                                    </div>
                                </div>



                                <div class="tab-pane" id="tab_report_cc">
                                    <div class="box">
                                        <div class="box-body">
                                            <div class="nav-tabs-custom">
                                                <ul class="nav nav-tabs">
                                                    <li class="active"><a href="#bi_rate_rep1" data-toggle="tab" class="cc_billing_report_tabs">Call Center</a></li>
                                                    <li><a href="#bi_rate_rep2" data-toggle="tab" class="cc_billing_report_tabs">B.I Bank</a></li>
                                                </ul>
                                                <div class="tab-content">
                                                    <div class="tab-pane active" id="bi_rate_rep1">
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <div class="box box-info">
                                                                    <div class="box-header with-border">
                                                                        <div class="box-title">
                                                                            Select Client
                                                                        </div>
                                                                    </div>
                                                                    <div class="box-body">
                                                                        <div class="form-group">
                                                                            <label for="">Client Name:</label>
                                                                            <select name="" id="select_cc_client" style="width: 100%" class="select2">
                                                                                <option value="">-</option>
                                                                                @foreach($bi_client as $chunk_)
                                                                                    <option value="{{$chunk_->bi_account_id}}" name="{{$chunk_->client_check}}">{{$chunk_->site_name}}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <button class="btn btn-warning btn-block" id="add-manually-acc" data-toggle="modal" data-target="#modal-add-account-manually"><i class="glyphicon glyphicon-plus"></i> ADD ACCOUNT MANUALLY</button>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <table class="table-hover table-condensed" width="100%" id="cc_invoice_list_table">
                                                                                <thead>
                                                                                <tr>
                                                                                    <th>ID</th>
                                                                                    <th>ACCOUNT NAME</th>
                                                                                    <th>ADDRESS</th>
                                                                                    <th>AMOUNT</th>
                                                                                    <th>ACTION</th>
                                                                                </tr>
                                                                                </thead>
                                                                                <tbody>

                                                                                </tbody>
                                                                                <tfoot>
                                                                                <tr>
                                                                                    <td colspan="3" style="background-color: black; color:white">TOTAL</td>
                                                                                    <td colspan="2"><i id="cc_billing_total" style="font-weight: bold"></i></td>
                                                                                </tr>
                                                                                </tfoot>
                                                                            </table>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <button class="btn btn-success form-control" id="cc_generate_invoice"><i class="glyphicon glyphicon-tasks"></i> Create Paypal Invoice</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <div class="box">
                                                                    <div class="box-body">
                                                                        <div class="row">
                                                                            <div class="form-group col-md-6">
                                                                                <input type="radio" id="cc_billing_all" name="cc_billing_radio" class="cc_billing_date_range_func">
                                                                                <label for="cc_billing_all">All</label>
                                                                                <input type="radio" id="cc_billing_dateRange" name="cc_billing_radio" checked class="cc_billing_date_range_func">
                                                                                <label for="cc_billing_dateRange">Date Range</label>
                                                                                <div class="input-group margin" style="" id="cc_billing_picker_holder">
                                                                                    <div class="input-group-btn">
                                                                                        <label for="cc_billing_date_range_min" class="btn btn-default">From</label>
                                                                                    </div>
                                                                                    <input id="cc_billing_date_range_min" type="date" class="form-control cc_date_picker_class" value="<?php echo date('Y-m-d'); ?>">
                                                                                    <div class="input-group-btn">
                                                                                        <label for="cc_billing_date_range_max" class="btn btn-default">To</label>
                                                                                    </div>
                                                                                    <input id="cc_billing_date_range_max" type="date" class="form-control cc_date_picker_class" value="<?php echo date('Y-m-d'); ?>">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <table class="table-hover table-condensed" width="100%" id="cc_billing_report_table">
                                                                                <thead>
                                                                                <tr>
                                                                                    <th>ACTION</th>
                                                                                    <th>ID</th>
                                                                                    <th>DATE/TIME ENDORSE</th>
                                                                                    <th>ACCOUNT NAME</th>
                                                                                    <th>ADDRESS</th>
                                                                                    <th>CITY/MUNICIPALITY</th>
                                                                                    <th>PROVINCE</th>
                                                                                    <th>STATUS</th>
                                                                                    <th>DATE/TIME SENT</th>
                                                                                </tr>
                                                                                </thead>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- /.tab-pane -->
                                                    <div class="tab-pane" id="bi_rate_rep2">
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <div class="box box-info">
                                                                    <div class="box-header with-border">
                                                                        <div class="box-title">
                                                                            Select Client
                                                                        </div>
                                                                    </div>
                                                                    <div class="box-body">
                                                                        <div class="form-group">
                                                                            <label for="">Client Name:</label>
                                                                            <select name="" id="select_cc_bank_client" style="width: 100%" class="select2">
                                                                                <option value="">-</option>
                                                                                @foreach($bi_client_bank as $chunk__)
                                                                                    <option value="{{$chunk__->bi_account_id}}" name="{{$chunk__->client_check}}">{{$chunk__->site_name}}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <button class="btn btn-warning btn-block" id="add-manually-acc-cc-bank" data-toggle="modal" data-target="#modal-add-account-manually-bank"><i class="glyphicon glyphicon-plus"></i> ADD ACCOUNT MANUALLY</button>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <table class="table-hover table-condensed" width="100%" id="cc_bank_invoice_list_table">
                                                                                <thead>
                                                                                <tr>
                                                                                    <th>ID</th>
                                                                                    <th>ACCOUNT NAME</th>
                                                                                    <th>TYPE OF REQUEST</th>
                                                                                    <th>AMOUNT</th>
                                                                                    <th>ACTION</th>
                                                                                </tr>
                                                                                </thead>
                                                                                <tbody>

                                                                                </tbody>
                                                                                <tfoot>
                                                                                <tr>
                                                                                    <td colspan="3" style="background-color: black; color:white">TOTAL</td>
                                                                                    <td colspan="2"><i id="cc_bank_billing_total" style="font-weight: bold"></i></td>
                                                                                </tr>
                                                                                </tfoot>
                                                                            </table>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <button class="btn btn-success form-control" id="cc_bank_generate_invoice">Create Paypal Invoice</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <div class="box">
                                                                    <div class="box-body">
                                                                        <div class="row">
                                                                            <div class="form-group col-md-6">
                                                                                <input type="radio" id="cc_bank_billing_all" name="cc_bank_billing_radio" class="cc_bank_billing_date_range_func">
                                                                                <label for="cc_bank_billing_all">All</label>
                                                                                <input type="radio" id="cc_bank_billing_dateRange" name="cc_bank_billing_radio" checked class="cc_bank_billing_date_range_func">
                                                                                <label for="cc_bank_billing_dateRange">Date Range</label>
                                                                                <div class="input-group margin" style="" id="cc_bank_billing_picker_holder">
                                                                                    <div class="input-group-btn">
                                                                                        <label for="cc_bank_billing_date_range_min" class="btn btn-default">From</label>
                                                                                    </div>
                                                                                    <input id="cc_bank_billing_date_range_min" type="date" class="form-control cc_bank_date_picker_class" value="<?php echo date('Y-m-d'); ?>">
                                                                                    <div class="input-group-btn">
                                                                                        <label for="cc_bank_billing_date_range_max" class="btn btn-default">To</label>
                                                                                    </div>
                                                                                    <input id="cc_bank_billing_date_range_max" type="date" class="form-control cc_bank_date_picker_class" value="<?php echo date('Y-m-d'); ?>">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <table class="table-hover table-condensed" width="100%" id="cc_bank_billing_report_table">
                                                                                <thead>
                                                                                <tr>
                                                                                    <th>ACTION</th>
                                                                                    <th>ID</th>
                                                                                    <th>DATE/TIME ENDORSE</th>
                                                                                    <th>ACCOUNT NAME</th>
                                                                                    <th>TYPE OF REQUEST</th>
                                                                                    <th>STATUS</th>
                                                                                    <th>DATE/TIME SENT</th>
                                                                                </tr>
                                                                                </thead>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- /.tab-pane -->
                                                </div>
                                                <!-- /.tab-content -->
                                            </div>
                                        </div>
                                        <!-- /.box-body -->
                                        <div class="box-footer">

                                        </div>
                                        <!-- /.box-footer-->
                                    </div>
                                </div>




                                <div class="tab-pane" id="tab_bil_rep">
                                    <h4 class="box-title" style = "padding-bottom: 20px;">Billing Information</h4>
                                    <table id="billing-manage" class="tableendorse table-hover table-condensed" width="100%">
                                        <thead>
                                        <tr>
                                            <th>Municipalities</th>
                                            <th>Provinces</th>
                                            <th>Bank Name</th>
                                            <th>Rate</th>
                                        </tr>
                                        </thead>
                                        <tfoot>
                                        <tr>
                                            <th>Municipalities</th>
                                            <th>Provinces</th>
                                            <th>Bank Name</th>
                                            <th>Rate</th>
                                        </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="modal fade" id="modal-add-account-manually">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Encode Account to Add</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">Account Name: <small style="color:red">(Required field)</small></label>
                                    <input type="text" class="form-control" id="manualAccntName">
                                </div>
                                <div class="form-group">
                                    <label>ACCOUNT ADDRESS: <small style="color:red">(Required field)</small></label>
                                    <textarea id="manualAccntAdd" class="form-control" rows="10"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-success" id="addAccntManually">Add Account</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modal-add-account-manually-bank">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Encode Account to Add</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">Account Name: <small style="color:red">(Required field)</small></label>
                                    <input type="text" class="form-control" id="manualAccntNameBank">
                                </div>
                                <div class="form-group">
                                    <label for="">Type of Request: <small style="color:red">(Required field)</small></label>
                                    <select type="text" class="form-control" id="manualAccntTorBank">
                                        <option value="-"></option>
                                        <option value="PDRN">PDRN</option>
                                        <option value="BVR">BVR</option>
                                        <option value="EVR">EVR</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-success" id="addAccntManuallyBank">Add Account</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
