@extends('layouts.master')

<style>
    #map_wrapper {
        height: 80%;
    }

    #map_canvas {
        width: 100%;
        height: 93%;
    }

    #table-ci-process-accounts_paginate .pagination .paginate_button a{

        font-size: 10px;
        margin-left: -10px;
        margin-right: -10px;
        margin-bottom: -10px;

    }
    #table-ci-process-accounts_paginate .pagination{
        margin-left: -70px;
    }

    #table-ci-process-accounts_info{
        display:none;
    }

    /*.datepicker {*/
    /*position: relative !important;*/
    /*top: -290px !important;*/
    /*left: 0 !important;*/
    /*}*/


</style>

@section('content')

    <div class="content-wrapper">

    </div>

    {{--FUND REQUEST MODAL--}}
    <div class="modal modal-warning fade" id="modal-fund-request-sending">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Please Wait...</h4>
                </div>
                <div class="modal-body">
                    <p style="text-align: center">Request is being process.  <img src="{{ asset('dist/img/loading.gif') }}" style="width: 5%;"></p>
                </div>
                <div class="modal-footer">
                    {{--<button type="button" class="btn btn-outline pull-right" data-dismiss="modal">Close</button>--}}
                </div>
            </div>
        </div>
    </div>
    {{--END--}}

    {{--FUND REQUEST MODAL CANCELLING--}}
    <div class="modal modal-warning fade" id="modal-fund-request-cancelling">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Please Wait...</h4>
                </div>
                <div class="modal-body">
                    <p style="text-align: center">Cancelling the request.  <img src="{{ asset('dist/img/loading.gif') }}" style="width: 5%;"></p>
                </div>
                <div class="modal-footer">
                    {{--<button type="button" class="btn btn-outline pull-right" data-dismiss="modal">Close</button>--}}
                </div>
            </div>
        </div>
    </div>
    {{--END--}}

    {{--FUND REQUEST SUCCESS MODAL--}}
    <div class="modal modal-success fade" id="modal-fund-request-success">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Success.</h4>
                </div>
                <div class="modal-body">
                    <p style="text-align: center">Fund request success.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline pull-right" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    {{--END--}}

    {{--FUND REQUEST SUCCESS-CANCEL MODAL--}}
    <div class="modal modal-success fade" id="modal-fund-request-cancel-success">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Cancel Success.</h4>
                </div>
                <div class="modal-body">
                    <p style="text-align: center">Fund request cancelled.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline pull-right" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    {{--END--}}

    {{--FUND REQUEST FAIL MODAL--}}
    <div class="modal modal-danger fade" id="modal-fund-request-fail">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Failed</h4>
                </div>
                <div class="modal-body">
                    <p style="text-align: center">Requesting fund failed. Please refresh the page and retry.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline pull-right" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    {{--END--}}

    <div class="modal modal-danger fade" id="modal-fund-request-limit">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Warning!</h4>
                </div>
                <div class="modal-body">
                    <p style="text-align: center">The fund requested exceeds the gas limit. Please re-enter amount.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline pull-right" data-dismiss="modal">Close</button>

                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <div class="modal modal-danger fade" id="modal-fund-request-limit-2">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Warning!</h4>
                </div>
                <div class="modal-body">
                    <p style="text-align: center">Pending fund requests already meet the gas limit. Cannot request at the moment.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline pull-right" data-dismiss="modal">Close</button>

                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <div class="modal modal-danger fade" id="modal-fund-request-limit-3">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Warning!</h4>
                </div>
                <div class="modal-body">
                    <p style="text-align: center">Gas limit for Shell Card already exceeded.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline pull-right" data-dismiss="modal">Close</button>

                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <div class="modal fade" id="modal-sms">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Send SMS to C.I</h4>
                </div>
                <div class="modal-body">
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li class="active">
                                <a href="#send_messageTab1" data-toggle="tab" class="send_message_tabs">Send Message</a>
                            </li>

                            <li class="">
                                <a href="#send_messageTab2" data-toggle="tab" class="send_message_tabs">Message Logs</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="send_messageTab1">
                                <div class="box">
                                    <div class="col-md-12">
                                        <div class="box-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="">CI Name : <small style="color: red">(Required field)</small></label>
                                                        <select name="" id="ci_to_text" class="select2 saving_class" style="width: 100%;">
                                                            <option value="">-</option>
                                                            @foreach($credit_investigators as $credit_investigator)
                                                                <option value="{{ $credit_investigator->id }} {{ old('ciID') }}">{{ strtoupper($credit_investigator->name) }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="">CI Contact Number : <small style="color: red">(Required field)</small></label>
                                                        <div class="input-group input-group-md">
                                                            <input type="number" class="form-control inputValidataionText saving_class" id="ci_num_to_text" disabled>
                                                            <span class="input-group-btn">
                                                                <button class="btn btn-primary btn-flat btn-md" id="edit_ci_num_val" title="Click to edit the number" style="margin: 3px; padding: 8px;"><i class="glyphicon glyphicon-pencil"></i></button>
                                                                <button class="btn btn-success btn-flat btn-md" id="edit_ci_num_save" title="Click to save the number" style="margin: 3px; padding: 8px;"><i class="glyphicon glyphicon-ok"></i></button>
                                                                <button class="btn btn-danger btn-flat btn-md" title="Click to cancel edit" id="edit_ci_num_cancel" style="margin: 3px; padding: 8px;"><i class="glyphicon glyphicon-remove"></i></button>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <label for="">Message : <small style="color: red">(Required field)</small></label>
                                                        <textarea name="" id="dispatcher_mess_to_ci" rows="5" class="form-control inputValidataionText" style="resize: none" placeholder="Type message here . . ."></textarea>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <label for="">Character Count :</label><span id="charCount">0</span><br>
                                                        <label for="">Credit Count :</label><span id="creditCount">0</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <button type="button" class="btn btn-success pull-right" id="send_message_to_ci" title="Send Message">Send Message <i class="glyphicon glyphicon-send"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane" id="send_messageTab2">
                                <table class="table-condensed table-hover display" width="100%" id="dispatcher_sms_logs">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>CREDIT COUNT</th>
                                        <th>Sender</th>
                                        <th>Receiver (C.I Name)</th>
                                        <th>Message</th>
                                        <th>Date/Time Occured</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    {{--<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>--}}
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>


    <div class="modal modal-warning fade" id="modal-sending-message-loading">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Please Wait...</h4>
                </div>
                <div class="modal-body">
                    <p style="text-align: center">Sending Message.  <img src="{{ asset('dist/img/loading.gif') }}" style="width: 5%;"></p>
                </div>
                <div class="modal-footer">
                    {{--<button type="button" class="btn btn-outline pull-right" data-dismiss="modal">Close</button>--}}
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-show-approved-info">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" style = "text-align: center">Approval Information</h4>
                </div>
                <div class="modal-body">
                    <div class = "box box-danger">
                    <div class = "row" style = "padding-top: 20px;">
                        <div class = "col-md-6">
                            <label for="">Approver name:</label>
                            <p id = "approver_name_fr"></p>
                        </div>
                        <div class = "col-md-6">
                            <label for="">Approved Date and Time:</label>
                            <p id = "approver_date_fr"></p>
                        </div>
                    </div>
                    <div class = "row" style = "padding-top: 20px;">
                        <div class = "col-md-6">
                            <label for="">Upload Date and Time:</label>
                            <p id = "upload_date_fr"></p>
                        </div>
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

    <div class="modal fade" id="modal-view-ci-liq-img">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Attached C.I Report for Liquidation</h4>
                </div>
                <div class="modal-body">
                    <div class = "row">
                        <div class = "col-md-12">
                            <div class = "row">
                                <div class = "col-md-12">
                                        <span id = "insertCiImgLiq">
                                        </span>
                                    <div class = "row">
                                        <div class = "col-md-12">
                                            <div class = "box box-warning">
                                                <div class = "row" style = "padding-bottom : 20px;">
                                                    <div class = "col-md-2"></div>
                                                    <div class = "col-md-8" >
                                                        <div class="form-group">
                                                            <h3 style = "text-align: left">General Liquidation Remarks:</h3>
                                                            <textarea id= "insertCILiqRemarks" class = "form-control" disabled></textarea>
                                                        </div>
                                                        <div class="form-group col-md-4 hidemuna">
                                                            <label for="">Fund Requested</label>
                                                            <input type="text" class="form-control" id="ci_req_amount" disabled>
                                                            <input type="hidden" class="form-control" id="ci_req_amount_check">
                                                        </div>
                                                        {{--<div class="form-group col-md-4 show_modify hidemuna">--}}
                                                            {{--<label for="" style="color: white;">button</label>--}}
                                                            {{--<button class="btn btn-primary btn-block" id="show_modify">Modify</button>--}}
                                                        {{--</div>--}}
                                                        {{--<div class="form-group col-md-4 clicked_modify" hidden>--}}
                                                            {{--<label for="" style="color: white;">button</label>--}}
                                                            {{--<button class="btn btn-warning btn-block" id="hide_modify">Cancel</button>--}}
                                                        {{--</div>--}}
                                                        <div class="form-group col-md-12 clicked_modify" hidden>
                                                            <label for="">Remarks: </label>
                                                            <textarea id= "finance_ci_liq_remssss" class = "form-control" placeholder="Remarks here ..."></textarea>
                                                        </div>
                                                    </div>
                                                    <div class = "col-md-2"></div>
                                                </div>
                                                <div class="row" style="padding-bottom: 20px;" hidden>
                                                    <div class="col-md-12">
                                                        <div class="col-md-2"></div>
                                                        <div class="col-md-8">
                                                            <b>Status: </b><span id="reviewer_span"></span><br>
                                                            <b>Changes made: </b><span id="reviewer_changes"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row" style="padding-bottom: 20px;">
                                                    <div class="col-md-12">
                                                        <div class="col-md-2"></div>
                                                        <div class="col-md-8">
                                                            <b>Last Updated: </b><span id="liq_date_rev"></span><br>

                                                        </div>
                                                        <div class="col-md-2"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{--</div>--}}
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success pull-right clicked_modify" hidden id="financeExpenseEdit">Submit</button>
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

    <div class="modal fade" id="modal-view-audit-review-rem">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Account Review Summary</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <span id="view_remarksSpan"></span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>



@endsection

@push('leftsidebar')
@include('bank_dept.dispatcher.dispatcher-leftsidebar')
@endpush

@push('jscript')
    <script type='text/javascript' src="https://cdnjs.cloudflare.com/ajax/libs/handlebars.js/4.0.11/handlebars.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/1.0.7/css/responsive.dataTables.min.css">
    <script src="https://cdn.datatables.net/responsive/2.1.1/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/rowreorder/1.2.0/js/dataTables.rowReorder.min.js"></script>
    <script src="{{ asset('jscript/dispatcher.js?n='.$javs) }}"></script>
    <script src="{{ asset('jscript/endorsement.js?n='.$javs) }}"></script>
    <script src="{{ asset('jscript/maps.js?n='.$javs) }}"></script>
    <script src="{{ asset('jscript/dispatcher-ci-management.js?n='.$javs) }}"></script>
    <script src="{{ asset('jscript/fund-request-tables-dispatcher.js?n='.$javs) }}"></script>
    <script src="{{ asset('jscript/fund-request-tables-finance.js?n='.$javs) }}"></script>
    <script src="{{ asset('jscript/finance.js?n='.$javs) }}"></script>
@endpush