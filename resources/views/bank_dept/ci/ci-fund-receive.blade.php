@extends('bank_dept.ci.template.master')


@section('content')
    <div class="content-wrapper">


        <!-- Main content -->
        <section class="content">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    Fund Receive
                    <small>Information</small>
                </h1>
            </section>
            <!-- Default box -->
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Fund Information</h3>

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
                                    <li class="active"><a href="#tab_1_pending" id="tab1_pending" data-toggle="tab" onclick="$(this).text('Pending Funds')"> Pending Funds</a></li>
                                    <li><a href="#tab_2_receives" id="tab2_receives" data-toggle="tab"> Received Funds <span id="ci_fund_notif_receive" class="pull-right"><span id="notifcount_fund_ci_tab"></span></span></a></li>
                                    <li><a href="#tab_3_done" id="tab2_done" data-toggle="tab"> Liquidated Funds</a></li>
                                    {{--<li><a href="#tab_3" id="tab4" data-toggle="tab"> <span class="fa fa-money"></span> <span id=""></span></a></li>--}}
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="tab_1_pending">
                                        <table id="table-fund-receive" class="tableendorse table-hover table-condensed" width="100%">
                                            <thead>
                                            <tr>
                                                <th>ID:</th>
                                                <th>TYPE:</th>
                                                <th>DATE/TIME OF SEND:</th>
                                                <th>AMOUNT:</th>
                                                <th>BANK: ACCOUNT NUMBER(For ATM):</th>
                                                <th>REMITTANCE:</th>
                                                <th>REMARKS:</th>
                                                <th>FUND ID:</th>
                                                <th>FOR THESE ACCOUNTS:</th>
                                            </tr>
                                            </thead>
                                        </table>
                                        <input type="button" class="btn btn-sm btn-info" value="Refresh Pending Fund" id="btnRefreshFundRcvTable">
                                    </div>
                                    <!-- /.tab-pane -->
                                    <div class="tab-pane" id="tab_2_receives">
                                        <table id="table-fund-receive-accept" class="tableendorse table-hover table-condensed" width="100%">
                                            <thead>
                                            <tr>
                                                <th>ID:</th>
                                                <th>TYPE:</th>
                                                <th>DATE/TIME OF SEND:</th>
                                                <th>BANK: ACCOUNT NUMBER(For ATM):</th>
                                                <th>REMITTANCE:</th>
                                                <th>DATE/TIME OF RECEIVE:</th>
                                                <th>RECEIVED AMOUNT:</th>
                                                <th>LIQUIDATED AMOUNT</th>
                                                <th>UNLIQUIDATED AMOUNT</th>
                                                <th>FINANCE REMARKS:</th>
                                                <th>FOR THESE ACCOUNTS:</th>
                                            </tr>
                                            </thead>
                                        </table>
                                        <input type="button" class="btn btn-sm btn-info" value="Refresh Received Fund" id="btnRefreshFundAcceptTable">
                                    </div>

                                    <div class="tab-pane" id="tab_3_done">
                                        <table id="table-fund-liq-done" class="tableendorse table-hover table-condensed" width="100%">
                                            <thead>
                                            <tr>
                                                <th>ID:</th>
                                                <th>TYPE:</th>
                                                <th>DATE/TIME OF SEND:</th>
                                                <th>BANK: ACCOUNT NUMBER(For ATM):</th>
                                                <th>REMITTANCE:</th>
                                                <th>DATE/TIME OF RECEIVE:</th>
                                                <th>RECEIVED AMOUNT:</th>
                                                <th>LIQUIDATED AMOUNT</th>
                                                <th>UNLIQUIDATED AMOUNT</th>
                                                <th>FINANCE REMARKS:</th>
                                                <th>FOR THESE ACCOUNTS:</th>
                                            </tr>
                                            </thead>
                                        </table>
                                        <input type="button" class="btn btn-sm btn-info" value="Refresh Liquidated Fund" id="btnRefreshLiqDoneTable">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                {{--END--}}

                {{--C.I FUND MODAL--}}
                <div class="modal modal-default fade" id="modal_ci_fund">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span></button>
                                <h5 class="modal-title">C.I Fund logs</h5>
                            </div>
                            <div class="modal-body">
                                <p>
                                <center>
                                    <div style="overflow:scroll; height: 300px">
                                        <span id="ci_fund_logs_table"></span>
                                    </div>
                                </center>
                                </p>
                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
                {{--END C.I FUND MODAL--}}


                {{--C.I FUND MODAL--}}
                <div class="modal modal-default fade" id="modal_ci_endorsements_fund">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" style = "text-align: center">Accounts for Fund Request</h4>
                            </div>
                            <div class="modal-body">
                                <div class = "row">
                                    <div class = "col-md-12">
                                        <div class = "box box-danger">
                                            <div class = "row">
                                                <div class = "col-md-4">
                                                    <h4 style = "text-align: left;">Total Accounts :  <span id = "noAccsFund"></span></h4>
                                                </div>
                                                <div class = "col-md-8"></div>
                                            </div>
                                            <div class = "row">
                                                <div class = "col-md-4">
                                                    <h4 style = "text-align: left;">Fund Amount Available:  <span id = "FundAmtReq"></span></h4>
                                                </div>
                                                <div class = "col-md-8"></div>
                                            </div>
                                            <div class = "row" style = "padding-top : 5px;">
                                                <div class = "col-md-1"></div>
                                                <div class = "col-md-10">
                                                    <span id="ci_fund_covered">

                                                    </span>
                                                    <div class = "row" style = "padding-top : 20px;">
                                                        <div class = "col-md-2"></div>
                                                        <div class = "col-md-8">
                                                            <span id = "liqRemSpan"></span>
                                                        </div>
                                                        <div class = "col-md-2"></div>
                                                    </div>
                                                </div>
                                                <div class = "col-md-1"></div>
                                            </div>
                                            <div class = "row" style = "padding-top: 20px;">
                                                <div class = "col-md-5"></div>
                                                <div class = "col-md-3">
                                                    <h4 id = "nameDecorLiq">Declared Amount :</h4>
                                                </div>
                                                <div class = "col-md-3"><input type = "text" class = "form-control" id = "declaredAmtShow" disabled ></div>
                                            </div>
                                            <div class = "row" style = "padding-top : 20px;">
                                                <div class = "col-md-3"></div>
                                                <div class = "col-md-6">
                                                    <span id="ulPercentage_fund">--</span>
                                                    <div id="progressbar_fund" hidden></div>
                                                </div>
                                                <div class = "col-md-3"></div>
                                            </div>
                                            <div class = "row" style = "padding-top : 20px; padding-bottom : 20px;">
                                                <div class = "col-md-5"></div>
                                                <div class = "col-md-3">
                                                    </span><button type = "button" class = "btn btn-success" id = "liquidateNowFund"></button>
                                                </div>
                                                <div class = "col-md-4"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
            {{--END C.I FUND MODAL--}}

                <div class="modal modal-default fade" id="modal_ci_endorsements_fund_pending">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" style = "text-align: center">Pending Accounts for Fund Request</h4>
                            </div>
                            <div class="modal-body">
                                <div class = "row">
                                    <div class = "col-md-12">
                                        <div class = "box box-danger">
                                            <div class = "row">
                                                <div class = "col-md-4"></div>
                                                <div class = "col-md-4">
                                                    <h4 style = "padding-bottom : 20px; text-align: center;">Total Accounts :  <span id = "noAccsFund2"></span></h4>
                                                </div>
                                                <div class = "col-md-4"></div>
                                            </div>
                                            <div class = "row" style = "padding-top : 20px;">
                                                <div class = "col-md-12">
                                                    <span id="ci_fund_covered_2"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>

                <div class="modal fade" id="modal-req-rem">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" style = "text-align: center">Requestor Remarks</h4>
                            </div>
                            <div class="modal-body">
                                <div class = "row" style = "padding-top: 20px;">
                                    <div class = "col-md-12">
                                        <b>Name:</b> <p id="dispatcher_req_name"></p>
                                    </div>
                                </div>
                                <div class = "row">
                                    <div class = "col-md-12">
                                        <label for="">Remarks:</label>
                                        <textarea id="req_rem_remarks" rows = "10" class = "form-control" disabled></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>

                <div class="modal fade" id="modal-req-rem-manage">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" style = "text-align: center">Management Approver Remarks</h4>
                            </div>
                            <div class="modal-body">
                                <div class = "row" style = "padding-top: 20px;">
                                    <div class = "col-md-12">
                                        <b>Name:</b> <p id="manage_req_name"></p>
                                    </div>
                                </div>
                                <div class = "row">
                                    <div class = "col-md-12">
                                        <label for="">Remarks:</label>
                                        <textarea id="req_rem_remarks_manage" rows = "10" class = "form-control" disabled></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
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
@endsection

@push('leftsidebar')
    @include('bank_dept.ci.ci-leftsidebar')
@endpush

@push('jscript')

    <link rel="stylesheet" href="https://cdn.datatables.net/rowreorder/1.2.0/css/rowReorder.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.1.1/css/responsive.dataTables.min.css">
    <script src="https://cdn.datatables.net/rowreorder/1.2.0/js/dataTables.rowReorder.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.1.1/js/dataTables.responsive.min.js"></script>
    <script src="{!!asset('fine-uploader/jquery.fine-uploader.js') !!}"></script>
    <script src="{!!asset('fine-uploader/fine-uploader.js') !!}"></script>
    <script src="{{ asset('jscript/ci.js?n='.$javs) }}"></script>
    <script src="{{ asset('jscript/getLatLong.js?n='.$javs) }}"></script>
    <script src="{{ asset('jscript/idle/jquery.idle.js?n='.$javs) }}"></script>
    <script src="{{ asset('jscript/detect-user-idle.js?n='.$javs) }}"></script>

@endpush