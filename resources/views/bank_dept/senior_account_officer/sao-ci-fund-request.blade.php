{{--@extends('layouts.master')--}}
{{--@extends('layouts.master')--}}

{{--@section('content')--}}
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                C.I Fund Request
            </h1>

        </section>
        <!-- Main content -->
        <section class="content">
            <!-- Default box -->
            <div class="box">
                {{--<div class="box-header with-border">--}}
                    {{--<div class="box-tools pull-right">--}}
                        {{--<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"--}}
                                {{--title="Collapse">--}}
                            {{--<i class="fa fa-minus"></i></button>--}}
                        {{--<button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">--}}
                            {{--<i class="fa fa-times"></i></button>--}}
                    {{--</div>--}}
                {{--</div>--}}
                <div class="box-body">

                    {{--<h3 class="box-title">C.I Fund Requests</h3>--}}

                    <div class="panel-body">

                        <div class="row">
                            <div class="col-md-12">
                                <!-- Custom Tabs -->
                                <div class="nav-tabs-custom">
                                    <ul class="nav nav-tabs">
                                        <li class="active"><a href="#tab_1_fund" data-toggle="tab" class = "ci_req_status_class">Pending Requests</a></li>
                                        <li><a href="#tab_2_fund" data-toggle="tab" class = "ci_req_status_class">Approved Requests</a></li>
                                        <li><a href="#tab_3_fund" data-toggle="tab" class = "ci_req_status_class">Disapproved Requests</a></li>
                                    </ul>

                                    <div class="tab-content">

                                        <div class="tab-pane active" id="tab_1_fund">
                                            <table id="table_fund_req" class="tableendorse table-condensed table-hover" width="100%">
                                                <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>REQUEST ID</th>
                                                    <th>REQUEST BY (DISPATCHER)</th>
                                                    <th>(FOR) CREDIT INVESTIGATOR</th>
                                                    <th>TYPE OF FUND</th>
                                                    <th>AMOUNT</th>
                                                    <th>FOR THESE ACCOUNT/S</th>
                                                    <th>DISPATCHER REMARKS</th>
                                                    {{--<th>SAO REMARKS</th>--}}
                                                    <th>ACTION</th>

                                                </tr>
                                                </thead>
                                                <tfoot>
                                                <tr>
                                                    <th></th>
                                                    <th>REQUEST ID</th>
                                                    <th>REQUEST BY (DISPATCHER)</th>
                                                    <th>(FOR) CREDIT INVESTIGATOR</th>
                                                    <th>TYPE OF FUND</th>
                                                    <th>AMOUNT</th>
                                                    <th>FOR THESE ACCOUNT/S</th>
                                                    <th>DISPATCHER REMARKS</th>
                                                    {{--<th>SAO REMARKS</th>--}}
                                                    <th>ACTION</th>

                                                </tr>
                                                </tfoot>
                                            </table>

                                        </div>

                                        <!-- /.tab-pane -->
                                        <div class="tab-pane" id="tab_2_fund">
                                            {{--TABLE STARTS HERE--}}
                                            <table id="table_fund_req_approved" class="tableendorse display table-hover table-condensed" width="100%">
                                                <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>REQUEST ID</th>
                                                    <th>REQUEST BY (DISPATCHER)</th>
                                                    <th>(FOR) CREDIT INVESTIGATOR</th>
                                                    <th>TYPE OF FUND</th>
                                                    <th>AMOUNT</th>
                                                    <th>FOR THESE ACCOUNT/S</th>
                                                    <th>DISPATCHER REMARKS</th>
                                                    {{--<th>SAO REMARKS</th>--}}
                                                    <th>STATUS</th>

                                                </tr>
                                                </thead>
                                                <tfoot>
                                                <tr>
                                                    <th></th>
                                                    <th>REQUEST ID</th>
                                                    <th>REQUEST BY (DISPATCHER)</th>
                                                    <th>(FOR) CREDIT INVESTIGATOR</th>
                                                    <th>TYPE OF FUND</th>
                                                    <th>AMOUNT</th>
                                                    <th>FOR THESE ACCOUNT/S</th>
                                                    <th>DISPATCHER REMARKS</th>
                                                    {{--<th>SAO REMARKS</th>--}}
                                                    <th>STATUS</th>

                                                </tr>
                                                </tfoot>
                                            </table>
                                            {{--END OF TABLE--}}

                                        </div>
                                        <!-- /.tab-pane -->
                                        <div class="tab-pane" id="tab_3_fund">
                                            {{--TAB CONTENT #3--}}
                                            <table id="table_fund_req_declined" class="tableendorse table-hover table-condensed" width="100%">
                                                <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>REQUEST ID</th>
                                                    <th>REQUEST BY (DISPATCHER)</th>
                                                    <th>(FOR) CREDIT INVESTIGATOR</th>
                                                    <th>TYPE OF FUND</th>
                                                    <th>AMOUNT</th>
                                                    <th>FOR THESE ACCOUNT/S</th>
                                                    <th>DISPATCHER REMARKS</th>
                                                    <th>DISAPPROVAL REMARKS</th>
                                                    <th>STATUS</th>

                                                </tr>
                                                </thead>
                                                <tfoot>
                                                <tr>
                                                    <th></th>
                                                    <th>REQUEST ID</th>
                                                    <th>REQUEST BY (DISPATCHER)</th>
                                                    <th>(FOR) CREDIT INVESTIGATOR</th>
                                                    <th>TYPE OF FUND</th>
                                                    <th>AMOUNT</th>
                                                    <th>FOR THESE ACCOUNT/S</th>
                                                    <th>DISPATCHER REMARKS</th>
                                                    <th>DISAPPROVAL REMARKS</th>
                                                    <th>STATUS</th>
                                                </tr>
                                                </tfoot>
                                            </table>
                                            <!-- /.tab-pane -->
                                        </div>
                                        <!-- /.tab-content -->
                                    </div>
                                    <!-- nav-tabs-custom -->
                                </div>
                                <!-- /.col -->
                            </div>
                        </div>
                    </div>
                </div>


                {{--other details--}}

                <script id="details-template-pending-sao" type="text/x-handlebars-template">
                    <div class="label label-info pull-left" style="font-size: 12px">Accounts for this Fund</div>
                    <table style="font-size: 15px;" class="tableendorse table details-table" id="sao_pending_posts-@{{id}}">
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

                <script id="details-template-app-sao" type="text/x-handlebars-template">
                    <div class="label label-info pull-left" style="font-size: 12px">Accounts for this Fund</div>
                    <table style="font-size: 15px;" class="tableendorse table details-table" id="sao_app_posts-@{{id}}">
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

                <script id="details-template-dec-sao" type="text/x-handlebars-template">
                    <div class="label label-info pull-left" style="font-size: 12px">Accounts for this Fund</div>
                    <table style="font-size: 15px;" class="tableendorse table details-table" id="sao_dec_posts-@{{id}}">
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

                {{--<!-- /.box-body -->--}}
                {{--<div class="box-footer">--}}
                    {{--Footer--}}
                {{--</div>--}}
                <!-- /.box-footer-->
            </div>
            <!-- /.box -->

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
{{--@endsection--}}

{{--@push('leftsidebar')--}}
    {{--@include('bank_dept.senior_account_officer.sao-leftsidebar')--}}
{{--@endpush--}}

{{--@push('jscript')--}}
    {{--handlebar--}}
    {{--<script type='text/javascript' src="https://cdnjs.cloudflare.com/ajax/libs/handlebars.js/4.0.11/handlebars.js"></script>--}}
    {{--<script src="{{ asset('jscript/sraccountofficer.js') }}"></script>--}}
    {{--<script src="{{ asset('jscript/fund-request-tables-sao.js') }}"></script>--}}
{{--@endpush--}}