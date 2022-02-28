@extends('layouts.master')

@section('content')

    <div class="content-wrapper">

    </div>

    <div class="modal modal-normal fade" id="modal-cc-sao-assign">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Assign Account</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <select class="select2 form-control" style="width: 100%" id="assign_tele_encoder">
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <i id="loadingAssign"></i>
                    <a class="btn btn-md btn-info pull-right" id = "btn_assign_to_tele">Assign</a>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-cc-sao-upload-update">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" style = "text-align: center;"><b>Upload/Update</b></h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class = "col-md-12">
                            <div class = "box box-danger">
                                <div class = "row">
                                    <div class = "col-md-6">
                                        <label for="">File to be uploaded:</label>
                                        <input type="file" id = "file_sao_to_tele"><br><br>
                                    </div>
                                    <div class = "col-md-6">
                                        <label for="">Remarks:</label>
                                        <textarea id = "rem_sao_to_tele" rows="3" class = "form-control" style="resize: none;"></textarea>
                                    </div>
                                </div>
                                <div class = "row" style = "padding-top : 20px">
                                    <div class = "col-md-3"></div>
                                    <div class = "col-md-6">
                                        <h4 class="hidethis">Note: Please click the button below to download current file.</h4>
                                    </div>
                                    <div class = "col-md-3"></div>
                                </div>
                                <div class="row" style = "padding-top : 20px;">
                                    <div class = "col-md-4"></div>
                                    <div class = "col-md-4">
                                        <button class="btn btn-success download_sao_file"></button><span id="downReport"></span>
                                    </div>
                                    <div class = "col-md-4"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-md btn-info pull-right" id="btnUpdateSaoToTele">Update</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-cc-sao-send-report">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Send Report</h4>
                </div>
                <div class="modal-body">
                    <div class = "row">
                        <div class = "col-md-1"></div>
                        <div class = "col-md-10">
                            <div class = "box box-warning">
                                <div class = "row" style = "padding-top : 20px;">
                                    <div class = "col-md-7">
                                        <label for="" style = "padding-bottom : 5px;">Attach file : </label>
                                        <input type="file" id = "cc_sao_send_file_report">
                                        <span id="ulPercentage_sao">--</span>
                                        <div id="progressbar_sao" hidden></div>
                                    </div>
                                </div>
                                <div class = "row" style = "padding-top : 10px">
                                    <div class = "col-md-12">
                                        <label for="">Remarks: </label>
                                        <textarea   rows="6" class = "form-control" id = "cc_sao_report_remarks"></textarea>
                                    </div>
                                </div>
                                <div class = "row" style = "padding-top : 10px">
                                    <div class = "col-md-8">
                                        <label for="">Status: </label>
                                        <select class = "form-control" id = "cc_sao_report_status">
                                            <option class = "ccOps" value="Complete">Complete</option>
                                            <option class = "ccOps" value="Partial">Partial</option>
                                            <option class = "bankOps" value="Contacted">Contacted</option>
                                            <option class = "bankOps" value="Uncontacted">Uncontacted</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class = "col-md-1"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <i id="loadingSend"></i>
                    <button type="button" class="btn btn-primary" id = "cc_sao_send_report">Send Report</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>



    <div class="modal fade" id="modal-cc-view-report">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" style = "text-align: center">Endorsement Remarks</h4>
                </div>
                <div class="modal-body">
                    <div class = "row">
                        <div class = "col-md-1"></div>
                        <div class = "col-md-10">
                            <div class = "box box-warning">
                                <div class = "row" style = "padding-top : 20px">
                                    <div class = "col-md-12">
                                        <label for="">Report Remarks:</label>
                                        <textarea rows="6" class = "form-control" id = "cc_sao_view_report_remarks" disabled></textarea>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class = "col-md-1"></div>
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

    <div class="modal fade" id="modal-type-tat">
        <div class="modal-dialog modal-md" >
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">SET DATE & TIME DUE:</h4>
                </div>
                <div class="modal-body">
                    <div class = "row">
                        <div class = "col-md-12">
                            <div class = "box box-danger">
                                <div class = "row" style = "padding-top: 30px;">
                                    <div class = "col-md-12">
                                        <div class="form-group" id="cc_bank_tat">
                                            <label for="">Type of TAT:</label><br>
                                            <p style="color: red;" class="small"><strong>*Required field</strong></p>
                                            <select id="type_tat_acc" class = "form-control" required>
                                                <option value="-">-</option>
                                                <option value="Regular">Regular</option>
                                                <option value="Regular 7">Regular 7 Days</option>
                                                <option value="Regular 5">Regular 5 Days</option>
                                                <option value="Interim Report 3">Interim Report 3 days</option>
                                                <option value="Special B.I 1">Special B.I 1 day</option>
                                                <option value="Expedite">Expedite</option>
                                                <option value="Custom">Custom</option>
                                            </select>
                                            {{--</div>--}}
                                            {{--<div class = "col-md-7"></div>--}}
                                        </div>

                                        <div class="row" style="">
                                            <div class="col-md-12">
                                                <div class="form-group" id="for_bank_time">
                                                    <div class="bootstrap-timepicker">
                                                        <label>Time Due:</label>
                                                        <p style="color: red;" class="small"><strong>*Required field</strong></p>
                                                        <div class="input-group">
                                                            <input type="text" id="tat_time_due" class="form-control timepicker">
                                                            <div class="input-group-addon">
                                                                <i class="fa fa-clock-o"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class = "row" style = "">
                                            <div class = "col-md-12">
                                                <label for="">Date Due:</label><br>
                                                <p style="color: red;" class="small"><strong>*Required field</strong></p>
                                                <div class = "input-group date">
                                                    <input type="text" name="datepicktry" class="form-control" id = "tat_date_due" required><span class = "input-group-addon"><i class="fa fa-calendar"></i></span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="form-group col-md-12 api_endorsement" id="api_endorsement">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-12 api_endorsement_alacarte" id="api_endorsement_alacarte">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
                <div class="modal-footer">
                    <i id="loadingAck"></i>
                    <button type="button" class="btn btn-success" id="btnTypeofTATProceed">Proceed</button><br>
                </div>
                <!-- /.modal-content -->
            </div>
        </div>
        <!-- /.modal-dialog -->
    </div>

    <div class="modal fade" id="modal-type-tat-with">
        <div class="modal-dialog modal-md" >
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">SET DATE & TIME DUE:</h4>
                </div>
                <div class="modal-body">
                    <div class = "row">
                        <div class = "col-md-12">
                            <div class = "box box-danger">
                                <div class = "row" style = "padding-top: 30px;">
                                    <div class = "col-md-5">
                                        <label for="">Type of TAT:</label><br>
                                        <p style="color: red;" class="small"><strong>*Required field</strong></p>
                                        <input type="text" disabled id="type_tat_acc_with" class="form-control">
                                        {{--<select id="type_tat_acc_with" class = "form-control" disabled>--}}
                                        {{--<option value="-">-</option>--}}
                                        {{--<option value="Regular">Regular</option>--}}
                                        {{--<option value="Expidite">Expidite</option>--}}
                                        {{--<option value="Custom">Custom</option>--}}
                                        {{--</select>--}}
                                    </div>
                                    <div class = "col-md-7"></div>
                                </div>
                                <div class = "row" style = "padding-top : 20px; padding-bottom: 20px;">
                                    <div class = "col-md-5">
                                        <label for="">Date Due:</label><br>
                                        <p style="color: red;" class="small"><strong>*Required field</strong></p>
                                        <div class = "input-group date">
                                            <input type="text" class="form-control" id = "tat_date_due_with" disabled><span class = "input-group-addon"><i class="fa fa-calendar"></i></span>
                                        </div>
                                    </div>
                                    <div class = "col-md-2"></div>
                                    <div class = "col-md-5">
                                        <div class="bootstrap-timepicker">
                                            <label>Time Due:</label>
                                            <div class="input-group">
                                                <input type="text" id="tat_time_due_with" class="form-control timepicker" readonly disabled>
                                                <div class="input-group-addon">
                                                    <i class="fa fa-clock-o"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success" id="btnTypeofTATProceedwith">Proceed</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    {{--Transfer--}}

    <div class="modal fade" id="modal-transfer-tele">
        <div class="modal-dialog" style = "width : 50%;">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" style = "text-align: center;">Transfer Account</h4>
                </div>
                <div class="modal-body">
                    <div class = "row" style = "padding-top : 15px;">
                        <div class = "col-md-12">
                            <div class = "box box-danger">
                                <div class = "row" style = "padding-top : 30px;  padding-bottom : 20px;">
                                    <div class = "col-md-1"></div>
                                    <div class = "col-md-4">
                                        <label for="">Current Assigned:</label>
                                        <input type="text" class = "form-control" ID = "sao-acct-tele-assigned" disabled>
                                    </div>
                                    <div class = "col-md-2"></div>
                                    <div class = "col-md-4">
                                        <label for="">Transfer Account to:</label>
                                        <select class = "form-control select2" style = "width: 100%;" id = "tele-list-assign-acct">

                                        </select>
                                    </div>
                                    <div class = "col-md-1"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <i id="lodadingAssignTele"></i>
                    <button type="button" class="btn btn-primary" id = "btnTransferAccttoTele">Transfer Account</button>
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>


    <div class="modal fade" id="modal-return-account">
        <div class="modal-dialog" style = "width : 50%;">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" style = "text-align: center;">Return Account</h4>
                </div>
                <div class="modal-body">
                    <div class = "row" style = "padding-top : 15px;">
                        <div class = "col-md-12">
                            <div class = "box box-danger">
                                <div class="form-group">
                                    <center><label>Select Lacking Documents/Attachments</label>
                                        <table class="table-condensed table-hover" width="60%" id="tblCheckings">
                                        </table>
                                        <div class="form-group" style="margin-top:10px;">
                                            <textarea rows="5" class="form-control remarksText" placeholder="Please indicate...." style="resize: none; width: 60%; display: none;"></textarea>
                                        </div>
                                    </center>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id = "btnReturnAccount">Return Account</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <div class="modal fade" id="modal-view-reasonDelay">
        <div class="modal-dialog" style = "width : 30%;">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" style = "text-align: center;">Reason of Incomplete</h4>
                </div>
                <div class="modal-body">
                    <div class = "row" style = "padding-top : 15px;">
                        <div class = "col-md-12">
                            <div class = "box box-danger">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-12" style="padding-top: 20px; font-size: 1.3em;">
                                            <center><span id="reasonOfDelay"></span></center>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>


    <div class="modal fade" id="modal-view-reasonToTele">
        <div class="modal-dialog" style = "width : 30%;">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" style = "text-align: center;">Reason of Delay</h4>
                </div>
                <div class="modal-body">
                    <div class = "row" style = "padding-top : 15px;">
                        <div class = "col-md-12">
                            <div class = "box box-danger">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-12" style="padding-top: 20px; font-size: 1em;">
                                            <center><textarea name="" placeholder="Please indicate....." id="reasonToTele" cols="15" rows="10" style="width: 100%; resize: none;"></textarea></center>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger" id = "btnReturnAccountToTele">Return Account</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <div class="modal fade" id="modal-loading">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <center><h5>LOADING PLEASE WAIT...</h5></center>
                        </div>
                    </div>
                    <div class = "row">
                        <div class="col-md-3"></div>
                        <div class = "col-md-6">
                            <center>
                                <img src="{{asset('dist/img/loading.gif')}}" width="60%;" id="loadingGIF">
                            </center>
                        </div>
                        <div class="col-med-3"></div>
                    </div>
                </div>
                <div class="modal-footer">
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <div class="modal fade" id="require_docs_modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" style = "text-align: center;">Notify for a Required Documents</h4>
                </div>
                <div class="modal-body">
                    <div class = "row">
                        <div class = "col-md-12">
                            <div class = "box box-danger">
                                <div class="form-group">
                                    <small style="color: red;">Note: Please specify the required documents</small>
                                    <div class="row">
                                        <div class="col-md-12" style="padding-top: 20px; font-size: 1.3em;">
                                            <textarea name="" rows="5" class="form-control" style="resize: none;" placeholder="Indecate remarks here..." id="requireed_docs_rem"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success pull-right" id="notifyBiClient">Submit</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <div class="modal fade" id="modal-view-contacts-grant">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box box-primary">
                                <div class="box-body">
                                    <table class="table-condensed table-hover" width="100%" id="contact_grant_table">
                                        <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Date/Time Added</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <div class="modal fade" id="modal-view-reason-cancellation">
        <div class="modal-dialog" style = "width : 30%;">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" style = "text-align: center;">Reason of Cancellation</h4>
                </div>
                <div class="modal-body">
                    <div class = "row" style = "padding-top : 15px;">
                        <div class = "col-md-12">
                            <div class = "box box-danger">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-12" style="padding-top: 20px; font-size: 1em;">
                                            <center><textarea name="" placeholder="Please indicate....." id="reasonofCancel" cols="15" rows="10" style="width: 100%; resize: none;" disabled></textarea></center>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>


@endsection

@push('leftsidebar')
    @include('cc_dept.sao.cc-sao-leftsidebar')
@endpush

@push('jscript')
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/1.0.7/css/responsive.dataTables.min.css">
    <script src="https://cdn.datatables.net/responsive/2.1.1/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/rowreorder/1.2.0/js/dataTables.rowReorder.min.js"></script>
    <script src="{{ asset('jscript/cc-sao.js?n='.$javs) }}"></script>
    <script src="{{ asset('jscript/cc-bi-report.js?n='.$javs) }}"></script>
    <script src="{{ asset('jscript/bi-download-file-view-info.js?n='.$javs) }}"></script>
@endpush