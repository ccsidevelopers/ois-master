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
    
       <div class="modal fade" id="modal_view_additional_direct" tabindex="-1" role="dialog" aria-labelledby="modal_view_additional_directTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: lightblue">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" style = "text-align: center;">Additional Files</h4>
                </div>
                <div class="modal-body">
                    <div class="row" style="padding-top : 20px">
                        <div class="col-md-12">
                            <table  class="display table-hover table-condensed" width="100%" id="divAddFileList">
                                <thead>
                                <tr style="background-color: lightcyan">
                                    <th>File Name</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody id="tableAddFileBody"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    
    <div class="modal fade" id="modal-bi-paynow">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" style = "text-align: center;">Click The Button to Pay Directly to Paypal</h4>
                </div>
                <div class="modal-body">
                    <div class = "row" style = "padding-top : 15px;">
                        <div class="col-md-2"></div>
                        <div class = "col-md-8">
                            <table class="table-condensed table-hover" width="100%" style="margin-bottom: 15px;" id="client_account_view_holder">
                                <thead>
                                <tr>
                                    <th colspan="4">BILLING NUMBER: <b><i id="client_billing_num"></i></b></th>
                                </tr>
                                <tr>
                                    <th colspan="4">BILLING PERIOD: <b><i id="client_billing_period"></i></b></th>
                                </tr>
                                <tr>
                                    <th>NAME</th>
                                    <th>ADDRESS</th>
                                    <th>AMOUNT DUE</th>
                                    <th>SENT VIA</th>
                                </tr>
                                </thead>
                                <tbody>

                                </tbody>
                                <tfoot>
                                <tr>
                                    <td colspan="2"><b>TOTAL</b></td>
                                    <td colspan="2"><b><i id="client_billing_total"></i></b></td>
                                </tr>
                                </tfoot>
                            </table>
                            <div id="payment-holder-div"></div>
                        </div>
                        <div class="col-md-2"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    {{--<button type="button" class="btn btn-success pull-right" id = "applyChangesCheckings" >Apply Changes</button>--}}
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    
     <div class="modal modal-warning fade" id="modal-send-email-loading-applicant">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Sending...</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class ="col-md-2"></div>
                        <div class="col-md-8">
                            <h5>Please wait while sending the email notification...... <img src="{{asset('dist/img/loading.gif')}}" style = "width : 3%" ></h5>
                        </div>
                        <div class ="col-md-2"></div>
                    </div>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <div class="modal modal-success fade" id="modal-send-email-success-applicant">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <p style = "text-align:  center"> Successfully Sent!</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline pull-right" data-dismiss="modal">Close</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    
    


@endsection

@push('leftsidebar')
    @include('bi_client.bi-client-leftsidebar')
@endpush

@push('jscript')
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/1.0.7/css/responsive.dataTables.min.css">
    <script src="https://cdn.datatables.net/responsive/2.1.1/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/rowreorder/1.2.0/js/dataTables.rowReorder.min.js"></script>
    <script src="{{ asset('jscript/bi.js?n='.$javs) }}"></script>
    <script src="{{ asset('jscript/bi-billing.js?n='.$javs) }}"></script>
    <script src="{{ asset('jscript/bi-download-file-view-info.js?n='.$javs) }}"></script>
@endpush