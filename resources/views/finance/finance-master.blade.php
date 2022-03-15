@extends('layouts.master')

<style>

    .wrapper1, .wrapper2 {
        width: 100%;
        overflow-x: scroll;
        overflow-y:hidden;
        white-space: normal;
    }

    .wrapper1 {height: 10%; }
    .wrapper2 {height: 100%; }

    .div1 {
        width:120%;
        height: 10%;
    }

    .div2 {
        width:120%;
        height: 110%;
        overflow: auto;
    }

    .toLeftTop2
    {
        padding-left : 250px;
    }

</style>
<link href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/themes/south-street/jquery-ui.min.css" rel="stylesheet" type="text/css" />
<link href="https://cdn.datatables.net/plug-ins/725b2a2115b/integration/jqueryui/dataTables.jqueryui.css" rel="stylesheet" type="text/css" />
<link href="https://netdna.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" type="text/css" />



@section('content')

    <div class="content-wrapper">

    </div>

    {{--SEND REMITTANCE TO C.I MODAL--}}
    <div class="modal modal-default fade" id="modal_sent_remiitance">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Remittance Information</h4>
                </div>
                <div class="modal-body">

                    <div class="box-body">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Branch Name:</label>
                            <select id="Branch_name_remit_id" class="form-control" style="width: 100%">
                                <option id="no selection" value="Select Branch" style="color: grey">(Select Branch)</option>
                                <option id="cebuana" value="cebuana">Cebuana</option>
                                <option id="M Lhuillier" value="M Lhuillier">M Lhuillier</option>
                                <option id="Western Union Sulit" value="Western Union Sulit">Western Union Sulit</option>
                                <option id="LBC" value="LBC">LBC</option>
                                <option id="Palawan" value="Palawan">Palawan</option>
                                <option id="TrueMoney" value="TrueMoney">TrueMoney</option>
                                <option id="RD Pawnshop" value="RD Pawnshop">RD Pawnshop</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Receiver:</label>
                            <input type="text" class="form-control" id="Receiver_remit_id" placeholder="Name of receiver">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Remittance Code:</label>
                            <input type="text" class="form-control" id="Remit_code_id" placeholder="Remittance Code">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Amount:</label>
                            <input type="number" class="form-control" id="Amount_remit_id" placeholder="Amount">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Sender:</label>
                            <input type="text" class="form-control" id="Sender_remit_id" placeholder="Name of sender">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Remarks:</label>
                            <textarea class="form-control" id="Remarks_remit_id" style="height: 100px" placeholder="Remarks"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
                    <button type="button" id="sendRemit" class="btn btn-primary pull-right" data-dismiss="modal">Send Remittance</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    {{--END SEND REMITTANCE TO C.I MODAL--}}

    <div class="modal modal-default fade" id="modal-finance-update-atm-info">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Update ATM Info</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="selFCINameUpd">FCI Name:</label>
                                <select class="form-control select2" id="selFCINameUpd" style="width: 100%" disabled>
                                    @foreach($ciLists as $ciList)
                                        <option value="{{ $ciList->id }}">{{ $ciList->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="txtBankNameUpd">Bank Name:</label>
                                <input type="text" class="form-control" id="txtBankNameUpd" disabled>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="form-group">
                                <label id="label_txtAcctNumUpd" for="txtAcctNumUpd">Account Number:</label>
                                <input type="text" class="form-control" id="txtAcctNumUpd" disabled>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
                    <button type="button" id="btnUpdAtmInfos" class="btn btn-primary pull-right" data-dismiss="modal">Update</button>
                    <button type="button" id="btnEditAtmInfos" class="btn btn-primary pull-right">Edit</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <span id="download_expense_file" hidden></span>


    {{--modal edit req--}}
    <div class="modal fade" id="modal-edit-approved-req">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" style = "text-align: center;">Re-Approve Request</h4>
                </div>
                <div class="modal-body">
                    <div class = "row">
                        <div class = "col-md-12">
                            <div class = "box box-info">
                                <div class = "row" style = "padding-top : 30px; padding-bottom : 20px;">
                                    <div class = "col-md-3"></div>
                                    <div class = "col-md-6">
                                        <label for=""><h4>Requested Amount:</h4></label>

                                        <div class = "row" style = "padding-top: 20px;">
                                            <div class = "col-md-3">
                                                <input type="text" class = "form-control" value = " ₱ " disabled>
                                            </div>
                                            <div class = "col-md-9">
                                                <input type="text" class = "form-control" id = "request_re_id" disabled>
                                            </div>
                                        </div>

                                        <div class = "row" style = "padding-top : 15px;">
                                            <div class = "col-md-12">
                                                <input type="checkbox" id = "checkSameAmount" checked> <strong>Same amount as the current request</strong>
                                            </div>
                                        </div>
                                    </div>
                                    <div class = "col-md-3"></div>
                                </div>
                                <div class = "row" style = "padding-top : 20px;">
                                    <div class = "col-md-12">
                                        <label for="">Incident Remarks</label>
                                        <textarea id= "app_incident_rem" class = "form-control" rows = "7" placeholder="Insert Remarks..."></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <span id = "loadingSendReqUli" style = "padding-right : 5px;" hidden><img src= "{{asset('dist/img/loading.gif')}}" style = "width: 3%"></span>
                    <button type="button" class="btn btn-primary" id = "btnSubmitReRequest">Submit</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    {{--Incident Modal--}}
    <div class="modal fade" id="modal-incident-approved-req">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Approved Request Incident</h4>
                </div>
                <div class="modal-body">
                    <div class = "row">
                        <div class = "col-md-12">
                            <div class = "box box-danger">

                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button type="button" id = "btnSubmitIncidentRep" class="btn btn-primary">Submit Incident Report</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <div class="modal fade" id="modal-incident-approved-view">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Incident Remarks for Request</h4>
                </div>
                <div class="modal-body">
                    <div class = "row">
                        <div class = "col-md-12">
                            <div class = "box box-danger">
                                <div class = "row" style = "padding-top : 20px;">
                                    <div class = "col-md-12">
                                        <label for="">Incident Remarks</label>
                                        <textarea id= "app_incident_rem_view" class = "form-control" rows = "7" disabled></textarea>
                                    </div>
                                </div>
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
                                                        <div class="form-group col-md-4 show_modify hidemuna">
                                                            <label for="" style="color: white;">button</label>
                                                            <button class="btn btn-primary btn-block" id="show_modify">Modify</button>
                                                        </div>
                                                        <div class="form-group col-md-4 clicked_modify" hidden>
                                                            <label for="" style="color: white;">button</label>
                                                            <button class="btn btn-warning btn-block" id="hide_modify">Cancel</button>
                                                        </div>
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
                        <div class="col-md-3"></div>
                    </div>
                </div>
                <div class="modal-footer">
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    {{--loading done all--}}
    <div class="modal modal-info fade" id="modal-loading-done-all">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Sending information</h4>
                </div>
                <div class="modal-body">
                    <p style = "text-align: center; padding-top : 20px;">Please wait while sending notification/s ( <span id = "currentSendLoop"></span> / <span id = "totalSend"></span> )
                        <span style = "padding-right : 5px;" ><img src= "{{asset('dist/img/loading.gif')}}" style = "width: 7%"></span>
                    </p>

                    <div class = "row" style = "padding-top : 15px;">
                        <div class = "col-md-2"></div>
                        <div class = "col-md-8">
                            <p> Sending SMS and Email Notification to <span id = "ci_name_done"></span> (CI) </p>
                            <p> Sending Email Notification to <span id = "sao_name_done"></span> (SAO)</p>
                            <p id = "showDis" hidden> Sending Email Notification to <span id = "dispatcher_name_done"></span> (Dispatcher)</p>
                            <p id = "showMag" hidden> Sending Email Notification to <span id = "management_list_done"></span> (Management)</p>
                        </div>
                        <div class = "col-md-2"></div>
                    </div>
                </div>

            </div>
            <!-- /.modal-content -->
        </div>

        <!-- /.modal-dialog -->
    </div>

    <div class="modal modal-info fade" id="modal-loading-done-only">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Sending information</h4>
                </div>
                <div class="modal-body">
                    <p style = "text-align: center; padding-top : 20px;">Please wait while sending notifications.......
                        <span style = "padding-right : 5px;" ><img src= "{{asset('dist/img/loading.gif')}}" style = "width: 7%"></span>
                    </p>
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

    <div class="modal fade" id="modal-loading-sms-sending">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <center><h5>SENDING SMS PLEASE WAIT...</h5></center>
                        </div>
                    </div>
                    <div class = "row">
                        <div class="col-md-3"></div>
                        <div class = "col-md-6">
                            <center>
                                <img src="{{asset('dist/img/loading.gif')}}" width="60%;" id="">
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

    <div class="modal fade" id="modal-admin-requi-instructions">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" style = "text-align: center">Additional Information</h4>
                </div>
                <div class="modal-body">
                    <div class = "row" style = "padding-top: 20px;">
                        <div class = "col-md-1"></div>
                        <div class = "col-md-10">
                            <label for="">Remarks/Instructions:</label>
                            <textarea id="addInstructFin" rows="4" class="form-control" placeholder="Insert remarks here.........."></textarea>
                        </div>
                        <div class = "col-md-1"></div>
                    </div>
                    <div class = "row" style = "padding-top: 20px;">
                        <div class = "col-md-1"></div>
                        <div class = "col-md-10">
                            <label for="">Attachment/s:</label> <button class="btn btn-success btn-xs btnAddAttachInstruction" style="margin-left : 1%"><i class = "fa fa-fw fa-plus"></i></button>
                        </div>
                        <div class = "col-md-1"></div>
                    </div>

                    <div id="storageInstruct">

                    </div>

                    <div class = "row" style = "padding-top : 10px;">
                        <div class = "col-md-2"></div>
                        <div class = "col-md-8">
                            <span id="ulPercentage_requi_fin"></span>
                            <div id="progressbar_requi_fin" hidden></div>
                        </div>
                        <div class = "col-md-2"></div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary pull-right" id = "btnSummitFinRequi">Submit</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>




@endsection

@push('leftsidebar')
    @include('finance.finance-leftsidebar')
@endpush

@push('jscript')
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/1.0.7/css/responsive.dataTables.min.css">
    <script src="https://cdn.datatables.net/responsive/2.1.1/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.0/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.0/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.0/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.0/js/buttons.print.min.js"></script>

    {{--excel export--}}
    {{--<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>--}}
    <script src="https://cdn.rawgit.com/rainabba/jquery-table2excel/1.1.0/dist/jquery.table2excel.min.js"></script>
    {{--end--}}
    <!--<script src="{{ asset('jscript/general.js?n='.$javs) }}"></script>-->
    <script src="{{ asset('jscript/finance.js?n='.$javs) }}"></script>
    {{--<script src="https://cdn.rawgit.com/ashl1/datatables-rowsgroup/fbd569b8768155c7a9a625k68e66a64115887d7d0/dataTables.rowsGroup.js"></script>--}}
    <script type='text/javascript' src="https://cdnjs.cloudflare.com/ajax/libs/handlebars.js/4.0.11/handlebars.js"></script>
    {{--<script src="{{ asset('jscript/finance.js') }}"></script>--}}
    <script src="{{ asset('jscript/fund-request-tables-finance.js?n='.$javs) }}"></script>

    <script>
        $(function(){
            $(".wrapper1").scroll(function(){
                $(".wrapper2").scrollLeft($(".wrapper1").scrollLeft());
            });
            $(".wrapper2").scroll(function(){
                $(".wrapper1").scrollLeft($(".wrapper2").scrollLeft());
            });
        });
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/jquery-ui.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.ui-contextmenu/1.7.0/jquery.ui-contextmenu.min.js"></script>

@endpush
