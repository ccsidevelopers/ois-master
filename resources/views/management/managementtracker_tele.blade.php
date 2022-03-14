{{--@extends('layouts.master')--}}

{{--@section('content')--}}
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" id="management_tables">
        <!-- Content Header (Page header) -->
        <section class="content-header">

        </section>
        <span id="span_download_report"></span>
        <!-- Main content -->
        <section class="content">
            <!-- Default box -->
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">TELE Account Tracker</h3>
                    {{--<div class="box-tools pull-right">--}}
                        {{--<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"--}}
                                {{--title="Collapse">--}}
                            {{--<i class="fa fa-minus"></i></button>--}}
                        {{--<button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">--}}
                            {{--<i class="fa fa-times"></i></button>--}}
                    {{--</div>--}}
                </div>
                <div class="box-body">
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#cc_gen_tab1" data-toggle="tab" class="cc_accnt_tracker">Tele C.I</a></li>
                            <li><a href="#cc_gen_tab2" data-toggle="tab" class="cc_accnt_tracker">Tele CC</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="cc_gen_tab1">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="box box-danger">
                                            <div class="box-header with-border">
                                            </div>
                                            <div class="box-body">
                                                <div class="form-group">
                                                    <input type="radio" name="gen_mon_rad" id="gen_mon_all" class="gen_mon_date_range_click" value="all">
                                                    <label for="gen_mon_all">All</label>
                                                    <input type="radio" name="gen_mon_rad" id="gen_mon_date_range" checked class="gen_mon_date_range_click" value="date_range">
                                                    <label for="gen_mon_date_range">Date Range</label>
                                                </div>
                                                <div class="form-group" id="gen_mon_date_pick_holder">
                                                    <div class="input-group margin" style="" id="">
                                                        <div class="input-group-btn">
                                                            <label for="" class="btn btn-default">From</label>
                                                        </div>
                                                        <input id="gen_mon_min" type="date" class="form-control gen_mon_date_range_dates" value="<?php echo date('Y-m-d');?>">
                                                        <div class="input-group-btn">
                                                            <label for="" class="btn btn-default">To</label>
                                                        </div>
                                                        <input id="gen_mon_max" type="date" class="form-control gen_mon_date_range_dates" value="<?php echo date('Y-m-d');?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <table id="management_tele_ci_gen_mon_table" class="tableendorse display table-hover table-condensed" width="100%">
                                            <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>TYPE OF REQUEST</th>
                                                <th>DATE ENDORSED</th>
                                                <th>TIME ENDORSED</th>
                                                <th>PROJECT/ACCOUNT</th>
                                                <th>ACCOUNT NAME</th>
                                                <th>ASSIGNED TELEVERIFIER</th>
                                                <th>REQUESTOR/POC</th>
                                                <th>ATTACHMENTS</th>
                                                <th>STATUS</th>
                                                <th>STATUS DETAILS</th>
                                                <th>ACTION</th>
                                            </tr>
                                            </thead>
                                            <tfoot>
                                            <tr>
                                                <th>ID</th>
                                                <th>TYPE OF REQUEST</th>
                                                <th>DATE ENDORSED</th>
                                                <th>TIME ENDORSED</th>
                                                <th>PROJECT/ACCOUNT</th>
                                                <th>ACCOUNT NAME</th>
                                                <th>ASSIGNED TELEVERIFIER</th>
                                                <th>REQUESTOR/POC</th>
                                                <th>ATTACHMENTS</th>
                                                <th>STATUS</th>
                                                <th>STATUS DETAILS</th>
                                                <th>ACTION</th>
                                            </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- /.tab-pane -->
                            <div class="tab-pane" id="cc_gen_tab2">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="box box-danger">
                                            <div class="box-header with-border">
                                            </div>
                                            <div class="box-body">
                                                <div class="form-group">
                                                    <input type="radio" name="gen_mon_rad_cc" id="gen_mon_all_cc" class="gen_mon_date_range_click_cc" value="all">
                                                    <label for="gen_mon_all_cc">All</label>
                                                    <input type="radio" name="gen_mon_rad_cc" id="gen_mon_date_range_cc" checked class="gen_mon_date_range_click_cc" value="date_range">
                                                    <label for="gen_mon_date_range_cc">Date Range</label>
                                                </div>
                                                <div class="form-group" id="gen_mon_date_pick_holder_cc">
                                                    <div class="input-group margin" style="" id="">
                                                        <div class="input-group-btn">
                                                            <label for="" class="btn btn-default">From</label>
                                                        </div>
                                                        <input id="gen_mon_min_cc" type="date" class="form-control gen_mon_date_range_dates_cc" value="<?php echo date('Y-m-d');?>">
                                                        <div class="input-group-btn">
                                                            <label for="" class="btn btn-default">To</label>
                                                        </div>
                                                        <input id="gen_mon_max_cc" type="date" class="form-control gen_mon_date_range_dates_cc" value="<?php echo date('Y-m-d');?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <table id="management_tele_ci_gen_mon_table_cc" class="tableendorse display table-hover table-condensed" width="100%">
                                            <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>SITE</th>
                                                <th>DATE ENDORSED</th>
                                                <th>TIME ENDORSED</th>
                                                <th>PROJECT/ACCOUNT</th>
                                                <th>ACCOUNT NAME</th>
                                                <th>PACKAGE</th>
                                                <th>ASSIGNED TELEVERIFIER</th>
                                                <th>REQUESTOR/POC</th>
                                                <th>ATTACHMENTS</th>
                                                <th>STATUS</th>
                                                <th>ACTION</th>
                                            </tr>
                                            </thead>
                                            <tfoot>
                                            <tr>
                                                <th>ID</th>
                                                <th>SITE</th>
                                                <th>DATE ENDORSED</th>
                                                <th>TIME ENDORSED</th>
                                                <th>PROJECT/ACCOUNT</th>
                                                <th>ACCOUNT NAME</th>
                                                <th>PACKAGE</th>
                                                <th>ASSIGNED TELEVERIFIER</th>
                                                <th>REQUESTOR/POC</th>
                                                <th>ATTACHMENTS</th>
                                                <th>STATUS</th>
                                                <th>ACTION</th>
                                            </tr>
                                            </tfoot>
                                        </table>
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
            <!-- /.box -->

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->


{{--@endsection--}}

{{--@push('leftsidebar')--}}
    {{--@include('management.management-leftsidebar')--}}
{{--@endpush--}}

{{--@push('jscript')--}}
    {{--<script src="{{ asset('jscript/endorsement.js') }}"></script>--}}
{{--@endpush--}}