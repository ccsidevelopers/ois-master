@extends('layouts.master')
<style>
    .just-padding {
        padding: 15px;
    }

    .list-group.list-group-root {
        padding: 0;
        overflow: hidden;
    }

    .list-group.list-group-root .list-group {
        margin-bottom: 0;
    }

    .list-group.list-group-root .list-group-item {
        border-radius: 0;
        border-width: 1px 0 0 0;
    }

    .list-group.list-group-root > .list-group-item:first-child {
        border-top-width: 0;
    }

    .list-group.list-group-root > .list-group > .list-group-item {
        padding-left: 30px;
    }

    .list-group.list-group-root > .list-group > .list-group > .list-group-item {
        padding-left: 45px;
    }

    .list-group-item .glyphicon {
        margin-right: 5px;
    }

    /* The switch - the box around the slider */
    .switch {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 34px;
    }

    /* Hide default HTML checkbox */
    .switch input {
        display: none;
    }

    /* The slider */
    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        -webkit-transition: .4s;
        transition: .4s;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 26px;
        width: 26px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        -webkit-transition: .4s;
        transition: .4s;
    }

    input:checked + .slider {
        background-color: #2196F3;
    }

    input:focus + .slider {
        box-shadow: 0 0 1px #2196F3;
    }

    input:checked + .slider:before {
        -webkit-transform: translateX(26px);
        -ms-transform: translateX(26px);
        transform: translateX(26px);
    }

    /* Rounded sliders */
    .slider.round {
        border-radius: 34px;
    }

    .slider.round:before {
        border-radius: 50%;
    }




</style>
<link rel="stylesheet" href="https://cdn.datatables.net/rowreorder/1.2.0/css/rowReorder.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.1.1/css/responsive.dataTables.min.css">
@section('content')

    <div class="content-wrapper">

    </div>

    <div class="modal fade" id="modal-remarks-disapprove">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" style = "text-align: center">Reason for disapproval</h4>
                </div>
                <div class="modal-body">
                    <div class = "row">
                        <div class = "col-md-12">
                            <div class = "box box-warning">
                                <div class = "row" style = "padding-top : 20px; padding-bottom : 10px;">
                                    <div class = "col-md-1"></div>
                                    <div class = "col-md-10">
                                        <label for="">Remarks:</label>
                                        <textarea id="remarksDis" rows="3" class = "form-control" placeholder="Enter remarks....."></textarea>
                                    </div>
                                    <div class = "col-md-1"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button type="button" id = "btnSubmitDis" class="btn btn-primary">Submit</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    
    <div class="modal fade" id="modal-modify-fund">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" style = "text-align: center">Fund Request Review</h4>
                </div>
                <div class="modal-body">
                    <div class = "row" >
                        <div class = "col-md-12">
                            <div class = "box box-danger">
                                <div class = "row" style = "padding-top : 60px; padding-bottom: 20px;">
                                    <div class = "col-md-3"></div>
                                    <div class = "col-md-4">
                                        <label for="" style = "padding-bottom: 10px;">Fund Request Amount:</label>
                                        <input type="number" class = "form-control" id = "newFundReqAmount" disabled>
                                    </div>
                                    <div class = "col-md-4" style = "padding-top : 33px;">
                                        <button class = "btn btn-md btn-primary" id = "openInputFundAmt"><i class="fa fa-fw fa-edit"></i>Modify</button>
                                        <button class = "btn btn-md btn-warning" id = "closeInputFundAmt"><i class="fa fa-fw fa-close" ></i>Cancel</button>
                                    </div>
                                    <div class = "col-md-2"></div>
                                </div>
                                <div class="row" style = "padding-top : 20px; padding-bottom: 20px">
                                    <div class="col-md-2"></div>
                                    <div class="col-md-8">
                                        <label for="">Remarks:</label>
                                        <textarea class = "form-control" id="remarks_to_approve_manage" rows="6" placeholder="Please insert remarks.........."></textarea>
                                    </div>
                                    <div class="col-md-2"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success" id = "appFundReqNow"><i class = "glyphicon glyphicon-ok" ></i> Approve Request</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <div class="modal fade" id="modal-req-rem-1">
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
                            <label for="">Remarks:</label>
                            <textarea id="req_rem_remarks-1" rows = "10" class = "form-control" disabled></textarea>
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

    <div class="modal fade" id="modal-show-supplier-to-approve">
        <div class="modal-dialog" style="width : 90%">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row" style = "padding-top: 10px;">
                        <div class="col-md-3"></div>
                        <div class="col-md-6">
                            <div class="panel panel-info">
                                <div class="panel-heading">
                                    <h4 style = "text-align : center">Supplier General Information</h4>
                                </div>
                                <div class="panel-body">
                                    <div class="form-group">

                                            {{--<div class="col-md-12"></div>--}}

                                        <div class="row" style = "padding-top :5px;">
                                            <div class="col-md-2"></div>
                                            <div class="col-md-6">
                                                <label for="">Category of Selected Suppliers: </label>
                                                <input type="text" class="form-control" id ="categoryToPassView" disabled>
                                            </div>
                                            <div class="col-md-4"></div>
                                        </div>
                                        <div class="row" style = "padding-top :20px;">
                                            <div class="col-md-2"></div>
                                            <div class="col-md-8">
                                                <label for="">Equipments/Description: </label>
                                                <textarea class="form-control" id = "equipmentToBuyView" rows ="2" disabled></textarea>
                                            </div>
                                            <div class="col-md-2"></div>
                                        </div>
                                        <div class="row" style = "padding-top :20px;">
                                            <div class="col-md-2"></div>
                                            <div class="col-md-8">
                                                <label for="">Remarks: </label>
                                                <textarea class="form-control" id = "remarksComparisonView" rows ="4" disabled></textarea>
                                            </div>
                                            <div class="col-md-2"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3"></div>
                    </div>
                    <div class = "row showIfApprover" hidden>
                        <div class="col-md-4">
                            <div class="panel panel-info">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-md-4"></div>
                                        <div class="col-md-4"> <h4 style = "text-align : center">Supplier 1 </h4></div>
                                        <div class="col-md-4" style ="padding-top: 5px;"><button class="btn btn-primary btn-md pull-right selectSups" id="selectSup1">Select</button></div>
                                    </div>
                                </div>
                                <div class="panel-body" id = "selectColorSup1">
                                    <div class="form-group">
                                        <div class="row" style = "padding-top: 30px;">
                                            <div class="col-md-12">
                                                <table class="table-condensed"  style = "overflow-x:auto; border-collapse:collapse; table-layout:fixed ; width : 100%; ">
                                                    <tr value = "1" class = "hoverSup">
                                                        <td style="font-weight:bold; background-color: #d9edf7;" id = "hoverSup1-1">Supplier Name</td>
                                                        <td style = "word-wrap:break-word;" class ="supName-0-1"></td>
                                                    </tr>
                                                    <tr value = "2" class = "hoverSup">
                                                        <td style="font-weight:bold; background-color: #d9edf7;"  id = "hoverSup2-1" >Contact Number</td>
                                                        <td style = "word-wrap:break-word;" class = "conNum-0-2"></td>
                                                    </tr>
                                                    <tr value = "3" class = "hoverSup">
                                                        <td style="font-weight:bold; background-color: #d9edf7;" id = "hoverSup3-1">Address</td>
                                                        <td style = "word-wrap:break-word;" class = "supAddview-0-3"></td>
                                                    </tr>
                                                    <tr value = "4" class = "hoverSup">
                                                        <td style="font-weight:bold; background-color: #d9edf7;" id = "hoverSup4-1">Contact Person</td>
                                                        <td style = "word-wrap:break-word;" class = "conPer-0-4" ></td>
                                                    </tr>
                                                    <tr value = "5" class = "hoverSup">
                                                        <td style="font-weight:bold; background-color: #d9edf7;" id = "hoverSup5-1" >Email Address</td>
                                                        <td style = "word-wrap:break-word;" class = "supEmail-0-5"></td>
                                                    </tr>
                                                    <tr value = "6" class = "hoverSup">
                                                        <td style="font-weight:bold; background-color: #d9edf7;" id = "hoverSup6-1">Email Subject</td>
                                                        <td style = "word-wrap:break-word;" class="emaiSubj-0-6"></td>
                                                    </tr>
                                                    <tr value = "7" class = "hoverSup">
                                                        <td style="font-weight:bold; background-color: #d9edf7;" id = "hoverSup7-1">Date of B.I</td>
                                                        <td style = "word-wrap:break-word;" class="dateBi-0-7"></td>
                                                    </tr>
                                                    <tr value = "8" class = "hoverSup">
                                                        <td style="font-weight:bold; background-color: #d9edf7;" id = "hoverSup8-1">BIR Registered</td>
                                                        <td style = "word-wrap:break-word;" class="birRegistered-0-8"></td>
                                                    </tr>
                                                    <tr value = "9" class = "hoverSup">
                                                        <td style="font-weight:bold; background-color: #d9edf7;" id = "hoverSup9-1">TIN Number</td>
                                                        <td style = "word-wrap:break-word;" class="tinNum-0-9"></td>
                                                    </tr>
                                                    <tr value = "10" class = "hoverSup">
                                                        <td style="font-weight:bold; background-color: #d9edf7;" id = "hoverSup10-1">Type of Request</td>
                                                        <td style = "word-wrap:break-word;" class="torSup-0-10"></td>
                                                    </tr>
                                                    <tr value = "11" class = "hoverSup">
                                                        <td style="font-weight:bold; background-color: #d9edf7;" id = "hoverSup11-1">Categorization</td>
                                                        <td style = "word-wrap:break-word;" class = "categSup-0-11"></td>
                                                    </tr>
                                                    <tr value = "12" class = "hoverSup">
                                                        <td style="font-weight:bold; background-color: #d9edf7;" id = "hoverSup12-1">Description</td>
                                                        <td style = "word-wrap:break-word;" class = "descSup-0-12"></td>
                                                    </tr>
                                                    <tr value = "13" class = "hoverSup">
                                                        <td style="font-weight:bold; background-color: #d9edf7;" id = "hoverSup13-1">Terms of Payment</td>
                                                        <td style = "word-wrap:break-word;" class = "termsPayment-0-13"></td>
                                                    </tr>
                                                    <tr value = "14" class = "hoverSup">
                                                        <td style="font-weight:bold; background-color: #d9edf7;" id = "hoverSup14-1">Proposal Validity</td>
                                                        <td style = "word-wrap:break-word;" class = "proposalVal-0-14"></td>
                                                    </tr>
                                                    <tr value = "17" class = "hoverSup">
                                                        <td style="font-weight:bold; background-color: #d9edf7;" id = "hoverSup17-1">Oher Info (Price / Discount / etc)</td>
                                                        <td style = "word-wrap:break-word;" class = "othersInfo-0-17"></td>
                                                    </tr>
                                                    <tr value = "15" class = "hoverSup">
                                                        <td style="font-weight:bold; background-color: #d9edf7;" id = "hoverSup15-1">Results</td>
                                                        <td style = "word-wrap:break-word;" class = "resultsSup-0-15"></td>
                                                    </tr>
                                                    <tr value = "16" class = "">
                                                        <td style="font-weight:bold; background-color: #d9edf7;" id = "hoverSup16-1">Attachment/s(Downloadable)</td>
                                                        <td style = "word-wrap:break-word;" class = "filesSup-0-16"></td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="panel panel-info">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-md-4"></div>
                                        <div class="col-md-4"> <h4 style = "text-align : center">Supplier 2 </h4></div>
                                        <div class="col-md-4" style ="padding-top: 5px;"><button class="btn btn-primary btn-md pull-right selectSups" id="selectSup2">Select</button></div>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <div class="form-group">
                                        <div class="row" style = "padding-top: 30px;">
                                            <div class="col-md-12">
                                                <table class="table-condensed"  style = "overflow-x:auto; border-collapse:collapse; table-layout:fixed ; width : 100%; ">
                                                    <tr value = "1" class = "hoverSup">
                                                        <td style="font-weight:bold; background-color: #d9edf7;" id = "hoverSup1-2">Supplier Name</td>
                                                        <td style = "word-wrap:break-word;" class = "supName-1-1"></td>
                                                    </tr>
                                                    <tr value = "2" class = "hoverSup">
                                                        <td style="font-weight:bold; background-color: #d9edf7;"  id = "hoverSup2-2">Contact Number</td>
                                                        <td style = "word-wrap:break-word;" class = "conNum-1-2"></td>
                                                    </tr>
                                                    <tr value = "3" class = "hoverSup">
                                                        <td style="font-weight:bold; background-color: #d9edf7;" id = "hoverSup3-2">Address</td>
                                                        <td style = "word-wrap:break-word;" class = "supAddview-1-3"></td>
                                                    </tr>
                                                    <tr value = "4" class = "hoverSup">
                                                        <td style="font-weight:bold; background-color: #d9edf7;" id = "hoverSup4-2">Contact Person</td>
                                                        <td style = "word-wrap:break-word;" class = "conPer-1-4" ></td>
                                                    </tr>
                                                    <tr value = "5" class = "hoverSup">
                                                        <td style="font-weight:bold; background-color: #d9edf7;" id = "hoverSup5-2">Email Address</td>
                                                        <td style = "word-wrap:break-word;" class = "supEmail-1-5"></td>
                                                    </tr>
                                                    <tr value = "6" class = "hoverSup">
                                                        <td style="font-weight:bold; background-color: #d9edf7;" id = "hoverSup6-2">Email Subject</td>
                                                        <td style = "word-wrap:break-word;" class="emaiSubj-1-6"></td>
                                                    </tr>
                                                    <tr value = "7" class = "hoverSup">
                                                        <td style="font-weight:bold; background-color: #d9edf7;" id = "hoverSup7-2">Date of B.I</td>
                                                        <td style = "word-wrap:break-word;" class="dateBi-1-7"></td>
                                                    </tr>
                                                    <tr value = "8" class = "hoverSup">
                                                        <td style="font-weight:bold; background-color: #d9edf7;" id = "hoverSup8-2">BIR Registered</td>
                                                        <td style = "word-wrap:break-word;" class="birRegistered-1-8"></td>
                                                    </tr>
                                                    <tr value = "9" class = "hoverSup">
                                                        <td style="font-weight:bold; background-color: #d9edf7;" id = "hoverSup9-2">TIN Number</td>
                                                        <td style = "word-wrap:break-word;" class="tinNum-1-9"></td>
                                                    </tr>
                                                    <tr value = "10" class = "hoverSup">
                                                        <td style="font-weight:bold; background-color: #d9edf7;" id = "hoverSup10-2">Type of Request</td>
                                                        <td style = "word-wrap:break-word;" class="torSup-1-10"></td>
                                                    </tr>
                                                    <tr value = "11" class = "hoverSup">
                                                        <td style="font-weight:bold; background-color: #d9edf7;" id = "hoverSup11-2">Categorization</td>
                                                        <td style = "word-wrap:break-word;" class = "categSup-1-11"></td>
                                                    </tr>
                                                    <tr value = "12" class = "hoverSup">
                                                        <td style="font-weight:bold; background-color: #d9edf7;" id = "hoverSup12-2">Description</td>
                                                        <td style = "word-wrap:break-word;" class = "descSup-1-12"></td>
                                                    </tr>
                                                    <tr value = "13" class = "hoverSup">
                                                        <td style="font-weight:bold; background-color: #d9edf7;" id = "hoverSup13-2">Terms of Payment</td>
                                                        <td style = "word-wrap:break-word;" class = "termsPayment-1-13"></td>
                                                    </tr>
                                                    <tr value = "14" class = "hoverSup">
                                                        <td style="font-weight:bold; background-color: #d9edf7;" id = "hoverSup14-2">Proposal Validity</td>
                                                        <td style = "word-wrap:break-word;" class = "proposalVal-1-14"></td>
                                                    </tr>
                                                    <tr value = "17" class = "hoverSup">
                                                        <td style="font-weight:bold; background-color: #d9edf7;" id = "hoverSup17-2">Oher Info (Price / Discount / etc)</td>
                                                        <td style = "word-wrap:break-word;" class = "othersInfo-1-17"></td>
                                                    </tr>
                                                    <tr value = "15" class = "hoverSup">
                                                        <td style="font-weight:bold; background-color: #d9edf7;" id = "hoverSup15-2">Results</td>
                                                        <td style = "word-wrap:break-word;" class = "resultsSup-1-15"></td>
                                                    </tr>

                                                    <tr value = "16" class = "">
                                                        <td style="font-weight:bold; background-color: #d9edf7;" id = "hoverSup16-2">Attachment/s(Downloadable)</td>
                                                        <td style = "word-wrap:break-word;" class = "filesSup-1-16"></td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="panel panel-info">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-md-4"></div>
                                        <div class="col-md-4"> <h4 style = "text-align : center">Supplier 3 </h4></div>
                                        <div class="col-md-4" style ="padding-top: 5px;"><button class="btn btn-primary btn-md pull-right selectSups" id="selectSup3">Select</button></div>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <div class="form-group">
                                        <div class="row" style = "padding-top: 30px;">
                                            <div class="col-md-12">
                                                <table class="table-condensed"  style = "overflow-x:auto; border-collapse:collapse; table-layout:fixed ; width : 100%; ">
                                                    <tr value = "1" class = "hoverSup">
                                                        <td style="font-weight:bold; background-color: #d9edf7;" id = "hoverSup1-3">Supplier Name</td>
                                                        <td style = "word-wrap:break-word;" class = "supName-2-1"></td>
                                                    </tr>
                                                    <tr value = "2" class = "hoverSup">
                                                        <td style="font-weight:bold; background-color: #d9edf7;"  id = "hoverSup2-3">Contact Number</td>
                                                        <td style = "word-wrap:break-word;" class = "conNum-2-2"></td>
                                                    </tr>
                                                    <tr value = "3" class = "hoverSup">
                                                        <td style="font-weight:bold; background-color: #d9edf7;" id = "hoverSup3-3">Address</td>
                                                        <td style = "word-wrap:break-word;" class = "supAddview-2-3"></td>
                                                    </tr>
                                                    <tr value = "4" class = "hoverSup">
                                                        <td style="font-weight:bold; background-color: #d9edf7;" id = "hoverSup4-3">Contact Person</td>
                                                        <td style = "word-wrap:break-word;" class = "conPer-2-4" ></td>
                                                    </tr>
                                                    <tr value = "5" class = "hoverSup">
                                                        <td style="font-weight:bold; background-color: #d9edf7;" id = "hoverSup5-3">Email Address</td>
                                                        <td style = "word-wrap:break-word;" id = "supEmail-2-5"></td>
                                                    </tr>
                                                    <tr value = "6" class = "hoverSup">
                                                        <td style="font-weight:bold; background-color: #d9edf7;" id = "hoverSup6-3">Email Subject</td>
                                                        <td style = "word-wrap:break-word;" class="emaiSubj-2-6"></td>
                                                    </tr>
                                                    <tr value = "7" class = "hoverSup">
                                                        <td style="font-weight:bold; background-color: #d9edf7;" id = "hoverSup7-3">Date of B.I</td>
                                                        <td style = "word-wrap:break-word;" class="dateBi-2-7"></td>
                                                    </tr>
                                                    <tr value = "8" class = "hoverSup">
                                                        <td style="font-weight:bold; background-color: #d9edf7;" id = "hoverSup8-3">BIR Registered</td>
                                                        <td style = "word-wrap:break-word;" class="birRegistered-2-8"></td>
                                                    </tr>
                                                    <tr value = "9" class = "hoverSup">
                                                        <td style="font-weight:bold; background-color: #d9edf7;" id = "hoverSup9-3">TIN Number</td>
                                                        <td style = "word-wrap:break-word;" class="tinNum-2-9"></td>
                                                    </tr>
                                                    <tr value = "10" class = "hoverSup">
                                                        <td style="font-weight:bold; background-color: #d9edf7;" id = "hoverSup10-3">Type of Request</td>
                                                        <td style = "word-wrap:break-word;" class="torSup-2-10"></td>
                                                    </tr>
                                                    <tr value = "11" class = "hoverSup">
                                                        <td style="font-weight:bold; background-color: #d9edf7;" id = "hoverSup11-3">Categorization</td>
                                                        <td style = "word-wrap:break-word;" class = "categSup-2-11"></td>
                                                    </tr>
                                                    <tr value = "12" class = "hoverSup">
                                                        <td style="font-weight:bold; background-color: #d9edf7;" id = "hoverSup12-3">Description</td>
                                                        <td style = "word-wrap:break-word;" class = "descSup-2-12"></td>
                                                    </tr>
                                                    <tr value = "13" class = "hoverSup">
                                                        <td style="font-weight:bold; background-color: #d9edf7;" id = "hoverSup13-3">Terms of Payment</td>
                                                        <td style = "word-wrap:break-word;" class = "termsPayment-2-13"></td>
                                                    </tr>
                                                    <tr value = "14" class = "hoverSup">
                                                        <td style="font-weight:bold; background-color: #d9edf7;" id = "hoverSup14-3">Proposal Validity</td>
                                                        <td style = "word-wrap:break-word;" class = "proposalVal-2-14"></td>
                                                    </tr>
                                                    <tr value = "17" class = "hoverSup">
                                                        <td style="font-weight:bold; background-color: #d9edf7;" id = "hoverSup17-3">Oher Info (Price / Discount / etc)</td>
                                                        <td style = "word-wrap:break-word;" class = "othersInfo-2-17"></td>
                                                    </tr>
                                                    <tr value = "15" class = "hoverSup">
                                                        <td style="font-weight:bold; background-color: #d9edf7;" id = "hoverSup15-3">Results</td>
                                                        <td style = "word-wrap:break-word;" class = "resultsSup-2-15"></td>
                                                    </tr>
                                                    <tr value = "16" class = "">
                                                        <td style="font-weight:bold; background-color: #d9edf7;" id = "hoverSup16-3">Attachment/s(Downloadable)</td>
                                                        <td style = "word-wrap:break-word;" class = "filesSup-2-16"></td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class = "row showIfViewer" hidden>
                        <div class="col-md-4">
                            <div class="panel panel-info">
                                <div class="panel-heading" id = "colorMeSup0">
                                    <div class="row">
                                        <div class="col-md-4"></div>
                                        <div class="col-md-4"> <h4 style = "text-align : center">Supplier 1 </h4></div>
                                        <div class="col-md-4"></div>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <div class="form-group">
                                        <div class="row" style = "padding-top: 30px;">
                                            <div class="col-md-12">
                                                <table class="table-condensed"  style = "overflow-x:auto; border-collapse:collapse; table-layout:fixed ; width : 100%; ">
                                                    <tr>
                                                        <td style="font-weight:bold; background-color: #d9edf7;" >Supplier Name</td>
                                                        <td style = "word-wrap:break-word;" class ="supName-0-1"></td>
                                                    </tr>
                                                    <tr >
                                                        <td style="font-weight:bold; background-color: #d9edf7;"  >Contact Number</td>
                                                        <td style = "word-wrap:break-word;" class = "conNum-0-2"></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="font-weight:bold; background-color: #d9edf7;" >Address</td>
                                                        <td style = "word-wrap:break-word;" class = "supAddview-0-3"></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="font-weight:bold; background-color: #d9edf7;" >Contact Person</td>
                                                        <td style = "word-wrap:break-word;" class = "conPer-0-4" ></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="font-weight:bold; background-color: #d9edf7;"  >Email Address</td>
                                                        <td style = "word-wrap:break-word;" class = "supEmail-0-5"></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="font-weight:bold; background-color: #d9edf7;" >Email Subject</td>
                                                        <td style = "word-wrap:break-word;" class="emaiSubj-0-6"></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="font-weight:bold; background-color: #d9edf7;" >Date of B.I</td>
                                                        <td style = "word-wrap:break-word;" class="dateBi-0-7"></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="font-weight:bold; background-color: #d9edf7;" >BIR Registered</td>
                                                        <td style = "word-wrap:break-word;" class="birRegistered-0-8"></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="font-weight:bold; background-color: #d9edf7;" >TIN Number</td>
                                                        <td style = "word-wrap:break-word;" class="tinNum-0-9"></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="font-weight:bold; background-color: #d9edf7;">Type of Request</td>
                                                        <td style = "word-wrap:break-word;" class="torSup-0-10"></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="font-weight:bold; background-color: #d9edf7;" >Categorization</td>
                                                        <td style = "word-wrap:break-word;" class = "categSup-0-11"></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="font-weight:bold; background-color: #d9edf7;" >Description</td>
                                                        <td style = "word-wrap:break-word;" class = "descSup-0-12"></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="font-weight:bold; background-color: #d9edf7;">Terms of Payment</td>
                                                        <td style = "word-wrap:break-word;" class = "termsPayment-0-13"></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="font-weight:bold; background-color: #d9edf7;" id = "hoverSup14-1">Proposal Validity</td>
                                                        <td style = "word-wrap:break-word;" class = "proposalVal-0-14"></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="font-weight:bold; background-color: #d9edf7;" >Other Info (Price / Discount / etc)</td>
                                                        <td style = "word-wrap:break-word;" class = "othersInfo-0-17"></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="font-weight:bold; background-color: #d9edf7;" >Results</td>
                                                        <td style = "word-wrap:break-word;" class = "resultsSup-0-15"></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="font-weight:bold; background-color: #d9edf7;" >Attachment/s(Downloadable)</td>
                                                        <td style = "word-wrap:break-word;" class = "filesSup-0-16"></td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="panel panel-info">
                                <div class="panel-heading" id = "colorMeSup1">
                                    <div class="row">
                                        <div class="col-md-4"></div>
                                        <div class="col-md-4"> <h4 style = "text-align : center">Supplier 2 </h4></div>
                                        <div class="col-md-4"></div>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <div class="form-group">
                                        <div class="row" style = "padding-top: 30px;">
                                            <div class="col-md-12">
                                                <table class="table-condensed"  style = "overflow-x:auto; border-collapse:collapse; table-layout:fixed ; width : 100%; ">
                                                    <tr>
                                                        <td style="font-weight:bold; background-color: #d9edf7;">Supplier Name</td>
                                                        <td style = "word-wrap:break-word;" class = "supName-1-1"></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="font-weight:bold; background-color: #d9edf7;">Contact Number</td>
                                                        <td style = "word-wrap:break-word;" class = "conNum-1-2"></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="font-weight:bold; background-color: #d9edf7;" >Address</td>
                                                        <td style = "word-wrap:break-word;" class = "supAddview-1-3"></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="font-weight:bold; background-color: #d9edf7;" >Contact Person</td>
                                                        <td style = "word-wrap:break-word;" class = "conPer-1-4" ></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="font-weight:bold; background-color: #d9edf7;" >Email Address</td>
                                                        <td style = "word-wrap:break-word;" class = "supEmail-1-5"></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="font-weight:bold; background-color: #d9edf7;">Email Subject</td>
                                                        <td style = "word-wrap:break-word;" class="emaiSubj-1-6"></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="font-weight:bold; background-color: #d9edf7;" >Date of B.I</td>
                                                        <td style = "word-wrap:break-word;" class="dateBi-1-7"></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="font-weight:bold; background-color: #d9edf7;" >BIR Registered</td>
                                                        <td style = "word-wrap:break-word;" class="birRegistered-1-8"></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="font-weight:bold; background-color: #d9edf7;" >TIN Number</td>
                                                        <td style = "word-wrap:break-word;" class="tinNum-1-9"></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="font-weight:bold; background-color: #d9edf7;" >Type of Request</td>
                                                        <td style = "word-wrap:break-word;" class="torSup-1-10"></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="font-weight:bold; background-color: #d9edf7;" >Categorization</td>
                                                        <td style = "word-wrap:break-word;" class = "categSup-1-11"></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="font-weight:bold; background-color: #d9edf7;" >Description</td>
                                                        <td style = "word-wrap:break-word;" class = "descSup-1-12"></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="font-weight:bold; background-color: #d9edf7;" >Terms of Payment</td>
                                                        <td style = "word-wrap:break-word;" class = "termsPayment-1-13"></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="font-weight:bold; background-color: #d9edf7;" >Proposal Validity</td>
                                                        <td style = "word-wrap:break-word;" class = "proposalVal-1-14"></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="font-weight:bold; background-color: #d9edf7;">Oher Info (Price / Discount / etc)</td>
                                                        <td style = "word-wrap:break-word;" class = "othersInfo-1-17"></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="font-weight:bold; background-color: #d9edf7;" >Results</td>
                                                        <td style = "word-wrap:break-word;" class = "resultsSup-1-15"></td>
                                                    </tr>

                                                    <tr>
                                                        <td style="font-weight:bold; background-color: #d9edf7;" >Attachment/s(Downloadable)</td>
                                                        <td style = "word-wrap:break-word;" class = "filesSup-1-16"></td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="panel panel-info">
                                <div class="panel-heading" id = "colorMeSup2">
                                    <div class="row">
                                        <div class="col-md-4"></div>
                                        <div class="col-md-4"> <h4 style = "text-align : center">Supplier 3 </h4></div>
                                        <div class="col-md-4"></div>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <div class="form-group">
                                        <div class="row" style = "padding-top: 30px;">
                                            <div class="col-md-12">
                                                <table class="table-condensed"  style = "overflow-x:auto; border-collapse:collapse; table-layout:fixed ; width : 100%; ">
                                                    <tr>
                                                        <td style="font-weight:bold; background-color: #d9edf7;">Supplier Name</td>
                                                        <td style = "word-wrap:break-word;" class = "supName-2-1"></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="font-weight:bold; background-color: #d9edf7;"  >Contact Number</td>
                                                        <td style = "word-wrap:break-word;" class = "conNum-2-2"></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="font-weight:bold; background-color: #d9edf7;" >Address</td>
                                                        <td style = "word-wrap:break-word;" class = "supAddview-2-3"></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="font-weight:bold; background-color: #d9edf7;" >Contact Person</td>
                                                        <td style = "word-wrap:break-word;" class = "conPer-2-4" ></td>
                                                    </tr>
                                                    <tr >
                                                        <td style="font-weight:bold; background-color: #d9edf7;" >Email Address</td>
                                                        <td style = "word-wrap:break-word;" class = "supEmail-2-5"></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="font-weight:bold; background-color: #d9edf7;">Email Subject</td>
                                                        <td style = "word-wrap:break-word;" class="emaiSubj-2-6"></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="font-weight:bold; background-color: #d9edf7;" >Date of B.I</td>
                                                        <td style = "word-wrap:break-word;" class="dateBi-2-7"></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="font-weight:bold; background-color: #d9edf7;" >BIR Registered</td>
                                                        <td style = "word-wrap:break-word;" class="birRegistered-2-8"></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="font-weight:bold; background-color: #d9edf7;" >TIN Number</td>
                                                        <td style = "word-wrap:break-word;" class="tinNum-2-9"></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="font-weight:bold; background-color: #d9edf7;" >Type of Request</td>
                                                        <td style = "word-wrap:break-word;" class="torSup-2-10"></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="font-weight:bold; background-color: #d9edf7;" >Categorization</td>
                                                        <td style = "word-wrap:break-word;" class = "categSup-2-11"></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="font-weight:bold; background-color: #d9edf7;" >Description</td>
                                                        <td style = "word-wrap:break-word;" class = "descSup-2-12"></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="font-weight:bold; background-color: #d9edf7;">Terms of Payment</td>
                                                        <td style = "word-wrap:break-word;" class = "termsPayment-2-13"></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="font-weight:bold; background-color: #d9edf7;" >Proposal Validity</td>
                                                        <td style = "word-wrap:break-word;" class = "proposalVal-2-14"></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="font-weight:bold; background-color: #d9edf7;">Other Info (Price / Discount / etc)</td>
                                                        <td style = "word-wrap:break-word;" class = "othersInfo-2-17"></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="font-weight:bold; background-color: #d9edf7;">Results</td>
                                                        <td style = "word-wrap:break-word;" class = "resultsSup-2-15"></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="font-weight:bold; background-color: #d9edf7;">Attachment/s(Downloadable)</td>
                                                        <td style = "word-wrap:break-word;" class = "filesSup-2-16"></td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class ="row showIfApprover">
                        <div class="col-md-3"></div>
                        <div class="col-md-6">
                            <div class="panel panel-info">
                                <div class="panel-heading">
                                    <h4 style = "text-align : center">General Remarks</h4>
                                </div>
                                <div class="panel-body">
                                    <div class="form-group">
                                        <div class="row" style = "padding-top : 5px;">
                                            <div class="col-md-12">
                                                <textarea id="genRemarksSuppApprover" class="form-control" rows="5" placeholder="Please insert remarks here........."></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3"></div>
                    </div>
                    <div class ="row showIfViewer">
                        <div class="col-md-3"></div>
                        <div class="col-md-6">
                            <div class="panel panel-info">
                                <div class="panel-heading">
                                    <h4 style = "text-align : center">General Remarks</h4>
                                </div>
                                <div class="panel-body">
                                    <div class="form-group">
                                        <div class="row" style = "padding-top : 5px;">
                                            <div class="col-md-12">
                                                <textarea id="genRemarksSuppApproverView" class="form-control" rows="5" placeholder="Please insert remarks here........." disabled></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <span id = "showBtnToApproveSupplier" class = "pull-right" hidden ><button class="btn btn-info btn-md" id = "btnSendNowApprovalSup">Approve  <span id = "loadingSpanSendApprovalSup" hidden><img src="{{ asset('dist/img/loading.gif') }}" style="width: 7%; margin-left : 10px;"></span></button></span>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    
     <div class="modal fade" id="modal-attendance-general-generation">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <center><h4 class="modal-title" >Generation of Attendance</h4></center>
                </div>
                <div class="modal-body">
                    <div class = "box-body">
                        <div class = "box box-warning">
                            <div class = "row" style = "padding-top : 30px; padding-bottom: 15px;">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Select Date to Generate: <small style="color: red">(Required Field)</small></label>
                                        <input type="date" class="form-control" id="date_to_generate">
                                    </div>
                                </div>
                                <div class = "col-md-6">
                                    <div class="form-group">
                                        <h5 style="text-align: center;">Click "Generate Attendance" Button to Generate All of Employee's Attendance for the specified date except C.I.</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success pull-right" id="generate_attendance_click">Generate Attendance <i class="glyphicon glyphicon-hdd"></i></button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    
    <div class="modal modal-default fade" id="modal_users_attendance_logs">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <div class="view_users" style="text-align: center; color: black">
                                <h4>User Attendance Logs</h4>
                            </div>
                        </div>
                    </div>
                    <div class="modal-body">
                                <span id="attendance_user_logs">
                                </span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


@endsection

@push('leftsidebar')
    @include('management.management-leftsidebar')
@endpush

@push('jscript')
    {{--<script src="{{ asset('jscript/dispatcher-ci-management.js?n='.$javs) }}"></script>--}}
    <script src="{{ asset('jscript/idle/jquery.idle.js?n='.$javs) }}"></script>
    <script src="{{ asset('jscript/detect-user-idle.js?n='.$javs) }}"></script>
    <script src="{{ asset('jscript/endorsement-management.js?n='.$javs) }}"></script>
    <script src="{{ asset('jscript/management.js?n='.$javs) }}"></script>
    <script src="{{ asset('jscript/fund-request-tables-management.js?n='.$javs) }}"></script>
    <script type='text/javascript' src="https://cdnjs.cloudflare.com/ajax/libs/handlebars.js/4.0.11/handlebars.js"></script>
    <script src="https://cdn.datatables.net/rowreorder/1.2.0/js/dataTables.rowReorder.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.1.1/js/dataTables.responsive.min.js"></script>
    <script src="{{ asset('jscript/fund-request-tables-finance.js?n='.$javs) }}"></script>
    <script src="{{ asset('jscript/finance.js?n='.$javs) }}"></script>
    <script src="{{ asset('jscript/cc-bi-report.js?n='.$javs) }}"></script>
    <script src="{{ asset('jscript/bi-download-file-view-info.js?n='.$javs) }}"></script>
@endpush
