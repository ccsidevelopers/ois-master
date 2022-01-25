@extends('layouts.master')

@section('content')

    <div class="content-wrapper">

    </div>

    <div class="modal fade" id="modal-bi-view-report">
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
                                        <textarea rows="6" class = "form-control" id = "bi_client_view_report_remarks" disabled></textarea>
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


    {{--Request pending--}}
    <div class="modal modal-info fade" id="modal-loading-bulk-endorse">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Sending...</h4>
                </div>
                <div class="modal-body">
                    <p style="text-align: center">Please wait while the endorsements are being submitted.  <img src="{{ asset('dist/img/loading.gif') }}" style="width: 5%;"></p>
                    <div class = "row" style = "padding-top : 10px;">
                        <div class = "col-md-2"></div>
                        <div class = "col-md-8">
                            <span id="ulPercentage_Bulk">--</span>
                            <div id="progressbar_Bulk" hidden></div>
                        </div>
                        <div class = "col-md-2"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline pull-right" data-dismiss="modal" id="btnModalCloseSending">Close</button>
                </div>
            </div>
        </div>
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
                                            <textarea rows="5" class="form-control remarksText" placeholder="Please indicate...." style="resize: none; width: 60%;" hidden></textarea>
                                        </div>
                                    </center>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <span id="ulPercentage_bi_return" hidden>--</span>
                            <div id="progressbar_bi_return" hidden></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id = "btnReturnAccount">Return Account</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>



    <div class="modal fade" id="modal-view-reasonDelay">
        <div class="modal-dialog" style = "width : 40%;">
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

    <div class="modal modal-danger fade" id="modal-double-endorse">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Double Endorsement</h4>
                </div>
                <div class="modal-body">
                    <p style = "padding-top: 20px; text-align: center">The endorsed subject has existing name and birthdate.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline pull-right" data-dismiss="modal">Close</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <div class="modal fade" id="modal-bi-cancel-request">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Request for Cancellation</h4>
                </div>
                <div class="modal-body">
                    <div class="box-body">
                        <label for="">Please indicate reason of account Cancellation</label>
                        <textarea name="" id="bi_client_cancel_req_reason" rows="5" class="form-control" style="resize: none"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success pull-right" id="request_cancel_submit">Submit Request</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <div class="modal modal-success fade" id="modal-success-send-bulk">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <p style = "text-align:  center"> Successfully Endorsed Accounts!</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline pull-right" data-dismiss="modal">Close</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>


    <div class="modal fade" id="modal-package-excel">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" style = "text-align: center;">Package of Endorsement</h4>
                </div>
                <div class="modal-body">
                    <div class = "row" style = "padding-top : 15px;">
                        <div class = "col-md-12">
                            <div class = "box box-warning">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class = "box-header with-border">
                                                <div class = "box-title">Select Package :</div>
                                            </div>
                                            <div class = "form-group" style = "padding-top: 20px;">
                                                <span class = "multiplePackagesLoop"></span>
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
                    <button type="button" class="btn btn-success pull-right" id = "applyChangesPackages">Apply Changes</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <div class="modal fade" id="modal-checkings-excel">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" style = "text-align: center;">Checkings of Endorsement</h4>
                </div>
                <div class="modal-body">
                    <div class = "row" style = "padding-top : 15px;">
                        <div class = "col-md-12">
                            <div class = "box box-warning">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class = "box-header with-border">
                                                <div class = "box-title">Select Checkings :</div>
                                            </div>
                                            <div class = "form-group" style = "padding-top: 20px;">
                                                <span class = "multipleCheckingsLoop"></span>
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
                    <button type="button" class="btn btn-success pull-right" id = "applyChangesCheckings" >Apply Changes</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <div class="modal fade" id="modal-edit-endorsement-details">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    {{--<h4 class="modal-title" style = "text-align: center;">Endorsement Details</h4>--}}
                </div>
                <div class="modal-body">
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <center>
                                <h4>Endorsement Details</h4>
                            </center>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="box">
                                        <div class="box-header">
                                            <h3 class="box-title">Internal Information</h3>
                                            <button class="btn btn-info pull-right" title="Click to Edit Endorsement Details" id="editClickedBi">Edit Details</button>
                                        </div>
                                        <div class="box-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label for="">Contract #:<small style="color: red">(Required field)</small></label>
                                                    <input type="text" class="form-control data_roll_test" identifier="contract_num" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="">Dealer #:<small style="color: red">(Required field)</small></label>
                                                    <input type="text" class="form-control data_roll_test" identifier="dealer_num" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="box">
                                        <div class="box-header">
                                            <h3 class="box-title">Account Name</h3>
                                        </div>
                                        <div class="box-body">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label for="">Last Name:<small style="color: red">(Required field)</small></label>
                                                    <input type="text" class="form-control data_roll_test" identifier="l_name" required>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label for="">First Name:<small style="color: red">(Required field)</small></label>
                                                    <input type="text" class="form-control data_roll_test" identifier="f_name" required>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label for="">Middle Name:<small style="color: orange">(Optional field)</small></label>
                                                    <input type="text" class="form-control data_roll_test" identifier="m_name">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label for="">Remarks:<small style="color: orange">(Optional field)</small></label>
                                                    <textarea class="form-control data_roll_test" id="" rows="5" style="resize: none" identifier="client_remarks_bank" required></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="box">
                                        <div class="box-header">
                                            <h3 class="box-title">Attachments</h3> <b><small style="color: red;">(Required atleast 1 attachment)</small></b>
                                            <a id="editAttachExpand" class="btn btn-default pull-right" title="Click to expand"><i class="glyphicon glyphicon-resize-full pull-right"></i></a>
                                        </div>
                                        <div class="box-body" id="edit_attachment_bbody" style="align-items: center" hidden>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label for="">Attachment 1 (Application Form)</label>
                                                    <input type="file" class="data_roll_test_files" identifier="attach_1">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="">Attachment 2(Supporting Document)</label>
                                                    <input type="file" class="data_roll_test_files" identifier="attach_2">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label for="">Attachment 3(Supporting Document)</label>
                                                    <input type="file" class="data_roll_test_files" identifier="attach_3">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="">Attachment 4(Supporting Document)</label>
                                                    <input type="file" class="data_roll_test_files" identifier="attach_4">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-success pull-right" id="EditEndorsement">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
                {{--<div class="modal-footer">--}}
                {{--</div>--}}
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <div class="modal modal-danger fade" id="modal-edit-endorsement-details-warning">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" style = "text-align: center;">Endorsement Exceeded the 5 minute cancellation rule</h4>
                </div>
                <div class="modal-body">

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
    @include('bi_client_tfs.bi-client-leftsidebar')
@endpush

@push('jscript')
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/1.0.7/css/responsive.dataTables.min.css">
    <script src="https://cdn.datatables.net/responsive/2.1.1/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/rowreorder/1.2.0/js/dataTables.rowReorder.min.js"></script>
    <script src="{{ asset('jscript/bi-tfs.js?n='.$javs) }}"></script>
    <script src="{{ asset('jscript/bi-download-file-view-info.js?n='.$javs) }}"></script>
@endpush