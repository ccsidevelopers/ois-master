@extends('layouts.master')
<link href="{{ asset('fine-uploader/fine-uploader-new.css') }}" rel="stylesheet" type="text/css">

{{--AUDIT REPORT/ DISCREPANCY FORM --}}
<script type="text/template" id="qq-audit-discrepancy-form-fine">
    <div class="qq-uploader-selector qq-uploader" qq-drop-area-text="Drop files here">
        <div class="qq-total-progress-bar-container-selector qq-total-progress-bar-container">
            <div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" class="qq-total-progress-bar-selector qq-progress-bar qq-total-progress-bar"></div>
        </div>
        <div class="qq-upload-drop-area-selector qq-upload-drop-area" qq-hide-dropzone>
            <span class="qq-upload-drop-area-text-selector"></span>
        </div>
        <div class="buttons">
            <div class="qq-upload-button-selector qq-upload-button">
                <center>Select Attachment/s</center>
            </div>
        </div>

        <button type="button" id="trigger-upload-discrepancy-form" class="btn btn-xs btn-primary" style="display: none;">
            {{--<button type="button" id="trigger-upload" class="btn btn-xs btn-primary">--}}
            <i class="icon-upload icon-white"></i> Upload
        </button>

        <span class="qq-drop-processing-selector qq-drop-processing">
                <span>Processing dropped files...</span>
                <span class="qq-drop-processing-spinner-selector qq-drop-processing-spinner"></span>
            </span>
        <ul class="qq-upload-list-selector qq-upload-list" aria-live="polite" aria-relevant="additions removals">
            <li>
                <div class="qq-progress-bar-container-selector">
                    <div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" class="qq-progress-bar-selector qq-progress-bar"></div>
                </div>
                <span class="qq-upload-spinner-selector qq-upload-spinner"></span>
                <img class="qq-thumbnail-selector" qq-max-size="40" qq-server-scale>
                <span class="qq-upload-file-selector qq-upload-file"></span>
                <span class="qq-edit-filename-icon-selector qq-edit-filename-icon" aria-label="Edit filename"></span>
                <input class="qq-edit-filename-selector qq-edit-filename" tabindex="0" type="text">
                <span class="qq-upload-size-selector qq-upload-size"></span>
                <button type="button" class="qq-btn qq-upload-cancel-selector qq-upload-cancel">Cancel</button>
                <button type="button" class="qq-btn qq-upload-retry-selector qq-upload-retry">Retry</button>
                <button type="button" class="qq-btn qq-upload-delete-selector qq-upload-delete">Delete</button>
                <span role="status" class="qq-upload-status-text-selector qq-upload-status-text"></span>
            </li>
        </ul>

        <dialog class="qq-alert-dialog-selector">
            <div class="qq-dialog-message-selector"></div>
            <div class="qq-dialog-buttons">
                <button type="button" class="qq-cancel-button-selector">Close</button>
            </div>
        </dialog>

        <dialog class="qq-confirm-dialog-selector">
            <div class="qq-dialog-message-selector"></div>
            <div class="qq-dialog-buttons">
                <button type="button" class="qq-cancel-button-selector">No</button>
                <button type="button" class="qq-ok-button-selector">Yes</button>
            </div>
        </dialog>

        <dialog class="qq-prompt-dialog-selector">
            <div class="qq-dialog-message-selector"></div>
            <input type="text">
            <div class="qq-dialog-buttons">
                <button type="button" class="qq-cancel-button-selector">Cancel</button>
                <button type="button" class="qq-ok-button-selector">Ok</button>
            </div>
        </dialog>
    </div>
</script>

{{--AUDIT CI REPORT CHECKING--}}

<style>
    @media print
    {
        body
        {
            visibility: hidden;
        }
        .printThis
        {
            visibility: visible;
            margin-top : -130px;
        }
        .hideThis
        {
            display : none
        }
        .tab6-printThis
        {
            /*margin-top: -320px;*/
            visibility: visible;
            margin-top : -130px;
        }


    }
</style>

@section('content')

    <div class="content-wrapper">

        <div class="modal fade" id="modal-emp-audit">
            <div class="modal-dialog" style = "width: 85%">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" style = "text-align: center; font-weight:bold;">Account Information</h4>
                    </div>
                    <div class="modal-body">
                        <div class = "row">
                            <div class = "col-md-12">
                                <div class = "box box-warning">
                                    <div class = "row">
                                        <div class = "col-md-4">
                                            <h4 style = "text-align: center ; padding-top : 20px; font-weight:bold;" >ACCOUNT DETAILS</h4>
                                            <table class="table-condensed"  style = "overflow-x:auto; border-collapse:collapse; table-layout:fixed ; width : 100%; ">
                                                <tr>
                                                    <td style="font-weight:bold; background-color: silver;">ID</td>
                                                    <td style = "word-wrap:break-word;" id = "account_show_id"></td>
                                                </tr>
                                                <tr>
                                                    <td style="font-weight:bold; background-color: silver">BANK</td>
                                                    <td style = "word-wrap:break-word;" id = "account_show_bank"></td>
                                                </tr>
                                                <tr>
                                                    <td style="font-weight:bold; background-color: silver">Date Endorsed</td>
                                                    <td style = "word-wrap:break-word;" id = "account_show_date_endorsed"></td>
                                                </tr>
                                                <tr>
                                                    <td style="font-weight:bold; background-color: silver">Time Endorsed</td>
                                                    <td style = "word-wrap:break-word;" id = "account_show_time_endorsed"></td>
                                                </tr>
                                                <tr>
                                                    <td style="font-weight:bold; background-color: silver">Date Due</td>
                                                    <td style = "word-wrap:break-word;" id = "account_show_date_due"></td>
                                                </tr>
                                                <tr>
                                                    <td style="font-weight:bold; background-color: silver">Time Due</td>
                                                    <td style = "word-wrap:break-word;" id = "account_show_time_due"></td>
                                                </tr>
                                                <tr>
                                                    <td style="font-weight:bold; background-color: silver">Field Verifier(C.I) Due</td>
                                                    <td style = "word-wrap:break-word;" id = "account_show_ci_due"></td>
                                                </tr>
                                                <tr>
                                                    <td style="font-weight:bold; background-color: silver">Requestor</td>
                                                    <td style = "word-wrap:break-word;" id = "account_show_requestor"></td>
                                                </tr>
                                                <tr>
                                                    <td style="font-weight:bold; background-color: silver">Account</td>
                                                    <td style = "word-wrap:break-word;" id = "account_show_account_name"></td>
                                                </tr>
                                                <tr>
                                                    <td style="font-weight:bold; background-color: silver">Business/Employer</td>
                                                    <td style = "word-wrap:break-word;" id = "account_show_business_employer"></td>
                                                </tr>
                                                <tr>
                                                    <td style="font-weight:bold; background-color: silver">Address</td>
                                                    <td style = "word-wrap:break-word;" id = "account_show_address"></td>
                                                </tr>
                                                <tr>
                                                    <td style="font-weight:bold; background-color: silver">City/Municipality</td>
                                                    <td style = "word-wrap:break-word;" id = "account_show_city_muni"></td>
                                                </tr>
                                                <tr>
                                                    <td style="font-weight:bold; background-color: silver">Province</td>
                                                    <td style = "word-wrap:break-word;" id = "account_show_province"></td>
                                                </tr>
                                                <tr>
                                                    <td style="font-weight:bold; background-color: silver">T.O.R</td>
                                                    <td style = "word-wrap:break-word;" id = "account_show_tor"></td>
                                                </tr>
                                                <tr>
                                                    <td style="font-weight:bold; background-color: silver">Verify Through</td>
                                                    <td style = "word-wrap:break-word;" id = "account_show_verify"></td>
                                                </tr>
                                            </table>

                                            <h4 style = "text-align: center ; padding-top : 23px; font-weight:bold;" >EMPLOYEES</h4>
                                            <table class="table-condensed"  style = "overflow-x:auto; border-collapse:collapse; table-layout:fixed ; width : 100%; padding-top: 30px " >
                                                <tr>
                                                    <td style="font-weight:bold; background-color: silver;">DISPATCHER NAME</td>
                                                    <td style = "word-wrap:break-word;" id = "account_show_dispatcher_name"></td>
                                                </tr>
                                                <tr>
                                                    <td style="font-weight:bold; background-color: silver">S.A.O NAME</td>
                                                    <td style = "word-wrap:break-word;" id = "account_show_sao_name"></td>
                                                </tr>
                                                <tr>
                                                    <td style="font-weight:bold; background-color: silver">A.O NAME</td>
                                                    <td style = "word-wrap:break-word;" id = "account_show_ao_name"></td>
                                                </tr>
                                                <tr>
                                                    <td style="font-weight:bold; background-color: silver">C.I NAME</td>
                                                    <td style = "word-wrap:break-word;" id = "account_show_ci_name"></td>
                                                </tr>
                                                <tr>
                                                    <td style="font-weight:bold; background-color: silver">CERTIFIED</td>
                                                    <td style = "word-wrap:break-word;" id = "account_show_certified"></td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class = "col-md-4">
                                            <h4 style = "text-align: center ; padding-top : 20px; font-weight:bold;" >TIMESTAMPS</h4>
                                            <table class="table-condensed"  style = "overflow-x:auto; border-collapse:collapse; table-layout:fixed ; width : 100%; padding-top: 30px " >
                                                <tr>
                                                    <td style="font-weight:bold; background-color: silver;">DATE/TIME DISPATCHED TO CI</td>
                                                    <td style = "word-wrap:break-word;" id = "account_show_date_time_dispatched_ci"></td>
                                                </tr>
                                                <tr>
                                                    <td style="font-weight:bold; background-color: silver">DATE/TIME ASSIGNED TO A.O</td>
                                                    <td style = "word-wrap:break-word;" id = "account_show_date_time_assigned_ao"></td>
                                                </tr>
                                                <tr>
                                                    <td style="font-weight:bold; background-color: silver">DATE/TIME C.I VISIT</td>
                                                    <td style = "word-wrap:break-word;" id = "account_show_date_time_ci_visit"></td>
                                                </tr>
                                                <tr>
                                                    <td style="font-weight:bold; background-color: silver">DATE/TIME C.I REPORTED</td>
                                                    <td style = "word-wrap:break-word;" id = "account_show_date_time_ci_reported"></td>
                                                </tr>
                                                <tr>
                                                    <td style="font-weight:bold; background-color: silver">DATE/TIME A.O SENT TO CLIENT</td>
                                                    <td style = "word-wrap:break-word;" id = "account_show_ao_date_to_client"></td>
                                                </tr>
                                                <tr>
                                                    <td style="font-weight:bold; background-color: silver">EXTERNAL STATUS</td>
                                                    <td style = "word-wrap:break-word;" id = "account_show_external_status"></td>
                                                </tr>
                                            </table>

                                            <h4 style = "text-align: center ; font-weight:bold;" >STATUS</h4>
                                            <table class="table-condensed" id = "audit-tat-ci-table"  style = "overflow-x:auto; border-collapse:collapse; table-layout:fixed ; width : 100%; padding-top: 30px " >
                                                <tr>
                                                    <td style="font-weight:bold; background-color: silver;">INTERNAL STATUS FIELD WORK</td>
                                                    <td style = "word-wrap:break-word;" id = "account_show_internal_stat_field"></td>
                                                </tr>
                                                <tr>
                                                    <td style="font-weight:bold; background-color: silver">INTERNAL STATUS OFFICE WORK</td>
                                                    <td style = "word-wrap:break-word;" id = "account_show_internal_stat_office"></td>
                                                </tr>
                                            </table>

                                            <h4 style = "text-align: center ; padding-top : 5px; font-weight:bold;" >EXPENSE REPORT</h4>
                                            <table class="table-condensed"  style = "overflow-x:auto; border-collapse:collapse; table-layout:fixed ; width : 100%; padding-top: 30px " >
                                                <tr>
                                                    <td><button class=" btn btn-xs btn-warning" id="receipts_logs"><i class="fa fa-fw fa-eye"></i> VIEW RECEIPTS</button></td>

                                                </tr>
                                            </table>
                                            <h4 style = "text-align: center ; padding-top : 5px; font-weight:bold;" >CREATE AUDIT REPORT</h4>
                                            <table class="table-condensed"  style = "overflow-x:auto; border-collapse:collapse; table-layout:fixed ; width : 100%; padding-top: 30px " >
                                                <tr>
                                                    <td style="font-weight:bold; background-color: silver;">INCENTIVES</td>
                                                    <td style = "word-wrap:break-word;"><input type="number" class = "form-control" id = "account_incentives"></td>
                                                </tr>
                                                <tr>
                                                    <td style="font-weight:bold; background-color: silver">DEDUCTION</td>
                                                    <td style = "word-wrap:break-word;"><input type="number" class = "form-control" id = "account_deduction"></td>
                                                </tr>
                                            </table>
                                            <button type="button" class="btn btn-info pull-right" id = "btnSaveIncentDed" style = "margin-top : 20px;">Save changes</button>
                                        </div>
                                        <div class = "col-md-4">
                                            <h4 style = "text-align: center ; padding-top : 20px; font-weight:bold;" >HANDLING TIME</h4>
                                            <table class="table-condensed"  style = "overflow-x:auto; border-collapse:collapse; table-layout:fixed ; width : 100%; padding-top: 30px " >
                                                <tr>
                                                    <td style="font-weight:bold; background-color: silver;">TIME DISPATCHED</td>
                                                    <td style = "word-wrap:break-word;" id = "account_show_dispatched_handling"></td>

                                                </tr>
                                                <tr>
                                                    <td style="font-weight:bold; background-color: silver">TIME SAO</td>
                                                    <td style = "word-wrap:break-word;" id  = "account_show_sao_handling"></td>
                                                </tr>
                                                <tr>
                                                    <td style="font-weight:bold; background-color: silver">TIME CI</td>
                                                    <td style = "word-wrap:break-word;" id = "account_show_ci_handling"></td>
                                                </tr>
                                                <tr>
                                                    <td style="font-weight:bold; background-color: silver">TIME AO</td>
                                                    <td style = "word-wrap:break-word;" id = "account_show_ao_handling"></td>
                                                </tr>
                                            </table>

                                            <h4 style = "text-align: center ; padding-top : 55px; font-weight:bold;" >CAUSES OF DELAY</h4>
                                            <textarea name="" id=""  rows="19" class = "form-control" disabled>Test Cause of Delay</textarea>

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

        <div class="modal fade" id="modal-ci-dl-report">
            <div class="modal-dialog" style = "width : 40%">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h3 class="modal-title" style = "text-align: center;">DOWNLOADABLE FILES FOR ACCOUNT : <span id = "acct_name_dl_ci"></span></h3>
                    </div>
                    <div class="modal-body">
                        <div class = "row" >
                            <div class = "col-md-12">
                                <div class = "box box-danger">
                                    <h3 style = "text-align: center; padding-bottom : 30px;" > </h3>
                                    <table class = "table-condensed" id = "audit-show-ci-files"  style = "overflow-x:auto; border-collapse:collapse; table-layout:fixed ; width : 100%;">
                                        <span id = "downCiDl"></span>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
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
                                                        <h3 style = "text-align: left">General Liquidation Remarks:</h3>
                                                        <textarea id= "insertCILiqRemarks" class = "form-control" disabled></textarea>
                                                    </div>
                                                    <div class = "col-md-2"></div>
                                                </div>
                                                <div class="row" style="padding-bottom: 20px;">
                                                    <div class="col-md-12">
                                                        <span id="tryOnly"></span>
                                                    </div>
                                                </div>
                                                <div class="row cancelMod" hidden>
                                                    <div class="col-md-12">
                                                        <div class="col-md-2"></div>
                                                        <div class="col-md-8">
                                                            <label for="">Remarks: </label>
                                                            <textarea name="" id="liquidation_rem_audit" rows="3" class="form-control" style="resize: none; margin-bottom: 15px;" placeholder="Remarks here..."></textarea>
                                                        </div>
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
                    <span id="removeHehe"></span>
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



    {{--FLOYD NEW july 30--}}


    <div class="modal fade" id="modal-show-all-log">
        <div class="modal-dialog" style = "width : 75%">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" style = "text-align: center;">Audit Log for Review</h4>
                </div>
                <div class="modal-body">
                    <div id = "showAuditDescForm" hidden>
                        <div class = "row" style = "padding-top: 20px">
                            <div class = "col-md-6">
                                <div class = "box box-primary">
                                    <h3 style = "text-align: center">Account Information</h3><br>

                                    <div class = "row" style = "padding-top : 10px;">
                                        <div class = "col-md-5">
                                            <label for="">Endorsement ID:</label>
                                            <p id = "showEndoIdf">Test</p>
                                        </div>
                                        <div class = "col-md-2"></div>
                                        <div class = "col-md-5">
                                            <label for="">Client Name:</label>
                                            <p id = "showClientArf">Test</p>
                                        </div>
                                    </div>
                                    <div class = "row" style = "padding-top : 10px;">
                                        <div class = "col-md-5">
                                            <label for="">Borrower's name/Company:</label>
                                            <p id = "showSubjNameArf">Test</p>
                                        </div>
                                        <div class = "col-md-2"></div>
                                        <div class = "col-md-5">
                                            <label for="">Type of Request:</label>
                                            <p id = "showTORArf">Test</p>
                                        </div>
                                    </div>
                                    <div class = "row" style = "padding-top : 10px;">
                                        <div class = "col-md-5">
                                            <label for="">Business/Employer name:    <small style = "color: orange">*if applicable</small> :</label>
                                            <p id = "showBusnameArf">Test</p>
                                        </div>
                                        <div class = "col-md-2"></div>
                                        <div class = "col-md-5">
                                            <label for="">Endorsement date:</label>
                                            <p id = "showEndoDateArf">Test</p>
                                        </div>
                                    </div>
                                    <div class = "row" style = "padding-top : 10px;">
                                        <div class = "col-md-5">
                                            <label for="">Address:</label>
                                            <p id = "showAddArf">Test</p>
                                        </div>
                                        <div class = "col-md-2"></div>
                                        <div class = "col-md-5">
                                            <label for="">Submission date:</label>
                                            <p id = "showSubArf">Test</p>
                                        </div>
                                    </div>
                                    <div class = "row" style = "padding-top : 10px;">
                                        <div class = "col-md-5">
                                            <label for="">Special Instructions from the Client:</label>
                                            <p id = "showSpecInsArf">Test</p>
                                        </div>
                                        <div class = "col-md-2"></div>
                                        <div class = "col-md-5">
                                            <label for=""> Internal TAT com:</label>
                                            <p id = "showInternalTatArf">Test</p>
                                        </div>
                                    </div>
                                    <div class = "row" style = "padding-top : 10px;">
                                        <div class = "col-md-5">
                                            <label for="">Type of Checking:</label>
                                            <p id = "showToCArf">Test</p>
                                        </div>
                                        <div class = "col-md-2"></div>
                                        <div class = "col-md-5">
                                            <label for=""> External TAT com:</label>
                                            <p id = "showExtTatArf">Test</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class = "col-md-6">
                                <div class = "box box-primary">
                                    <h3 style = "text-align: center">Background Information</h3><br>

                                    <div class = "row" style = "padding-top : 10px;">
                                        <div class = "col-md-5">
                                            <label for="">Employee ID:</label>
                                            <p id = "showempIDArf">Test</p>
                                        </div>
                                        <div class = "col-md-2"></div>
                                        <div class = "col-md-5">
                                            <label for="">Date Hired:</label>
                                            <p id = "showDateHiredArf">Test</p>
                                        </div>
                                    </div>
                                    <div class = "row" style = "padding-top : 10px;">
                                        <div class = "col-md-5">
                                            <label for="">Employee Name: </label>
                                            <p id = "showEmpNameArf">Test</p>
                                        </div>
                                        <div class = "col-md-2"></div>
                                        <div class = "col-md-5">
                                            <label for="">Department:</label>
                                            <p id = "showDeptArf">Test</p>
                                        </div>
                                    </div>
                                    <div class = "row" style = "padding-top : 10px;">
                                        <div class = "col-md-5">
                                            <label for="">Job Title: </label>
                                            <p id = "showJobTitleArf">Test</p>
                                        </div>
                                        <div class = "col-md-7"></div>
                                    </div>

                                    <div class = "box box-primary">
                                        <h3 style = "text-align: center">Results</h3><br>
                                        <div class = "row">
                                            <div class = "col-md-12">
                                                <label for="">Findings: </label>
                                                <p id = "showFindingsArf">Test</p>
                                            </div>
                                        </div>

                                        <div class = "row" style = "padding-top : 10px;">
                                            <div class = "col-md-12">
                                                <label for="">Investigation Taken: </label>
                                                <p id = "showInvestArf">Test</p>
                                            </div>
                                            <div class = "col-md-7"></div>
                                        </div>
                                        <div class = "row" style = "padding-top : 10px;">
                                            <div class = "col-md-12">
                                                <label for="">Validation Results: </label>
                                                <p id = "showValidResArf">Test</p>
                                            </div>
                                        </div>
                                        <div class = "row" style = "padding-top : 10px;">
                                            <div class = "col-md-12">
                                                <label for="">Statements: </label>
                                                <p id = "showStatementsArf">Test</p>
                                            </div>
                                        </div>
                                        <div class = "row" style = "padding-top : 10px;">
                                            <div class = "col-md-12">
                                                <label for="">Observations: </label>
                                                <p id = "showObserveArf">Test</p>
                                            </div>
                                        </div>
                                        <div class = "row" style = "padding-top : 10px;">
                                            <div class = "col-md-12">
                                                <label for="">Recommendations: </label>
                                                <p id = "showRecomArf">Test</p>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div id = "showPhoneFieldForm" hidden>
                        <div class = "row" style = "padding-top: 20px">
                            <div class = "col-md-6">
                                <div class = "box box-primary">
                                    <h3 style = "text-align: center">Account Information</h3><br>

                                    <div class = "row" style = "padding-top : 10px;">
                                        <div class = "col-md-5">
                                            <label for="">Endorsement ID:</label>
                                            <p id = "showEndoPf">Test</p>
                                        </div>
                                        <div class = "col-md-2"></div>
                                        <div class = "col-md-5">
                                            <label for="">Auditor:</label>
                                            <p id = "showAuditorPf">Test</p>
                                        </div>
                                    </div>
                                    <div class = "row" style = "padding-top : 10px;">
                                        <div class = "col-md-5">
                                            <label for="">Borrower's Name/Company:</label>
                                            <p id = "showSubjPf">Test</p>
                                        </div>
                                        <div class = "col-md-2"></div>
                                        <div class = "col-md-5">
                                            <label for="">Client Name:</label>
                                            <p id = "showClientNamePf">Test</p>
                                        </div>
                                    </div>
                                    <div class = "row" style = "padding-top : 10px;">
                                        <div class = "col-md-5">
                                            <label for="">Business/Employer name<small style = "color: orange">*if applicable</small> :</label>
                                            <p id = "showBusinamePf">Test</p>
                                        </div>
                                        <div class = "col-md-2"></div>
                                        <div class = "col-md-5">
                                            <label for="">Type of Request:</label>
                                            <p id = "showTorPf">Test</p>
                                        </div>
                                    </div>
                                    <div class = "row" style = "padding-top : 10px;">
                                        <div class = "col-md-5">
                                            <label for="">Address:</label>
                                            <p id = "showAddressPf">Test</p>
                                        </div>
                                        <div class = "col-md-2"></div>
                                        <div class = "col-md-5">
                                            <label for="">Endorsement date:</label>
                                            <p id = "showEndoDatePf">Test</p>
                                        </div>
                                    </div>
                                    <div class = "row" style = "padding-top : 10px;">
                                        <div class = "col-md-5">
                                            <label for="">Type of Checking:</label>
                                            <p id = "showTOCpF">Test</p>
                                        </div>
                                        <div class = "col-md-2"></div>
                                        <div class = "col-md-5">
                                            <label for="">Date visited by CI:</label>
                                            <p id = "showDateVisitPf">Test</p>
                                        </div>
                                    </div>
                                    <div class = "row" style = "padding-top : 10px;">
                                        <div class = "col-md-5">
                                            <label for="">Findings:</label>
                                            <p id = "showFindingsPf">Test</p>
                                        </div>
                                        <div class = "col-md-2"></div>
                                        <div class = "col-md-5">
                                            <label for="">Done Thru:</label>
                                            <p id = "showDoneThruPf">Test</p>
                                        </div>
                                    </div>
                                    <div class = "row" style = "padding-top : 10px;">
                                        <div class = "col-md-12">
                                            <label for="">Special Instructions from the Client:</label>
                                            <p id = "showSpecialPf">Test</p>
                                        </div>
                                    </div>
                                </div>
                                <div class = "box box-primary">
                                    <h3 style = "text-align: center">Informant Validation</h3><br>

                                    <div class = "row">
                                        <div class = "col-md-6">
                                            <p>1. Informant Name - <b id = "inf_name_0"></b> <button class = "toggleOnOff" name = "1" style = "background:none ; border:none; "><i style = "color :green" class = "fa fa-fw fa-chevron-circle-down"></i></button></p>
                                            <div id = "showInformant-1" hidden>
                                                <div class = "row">
                                                    <div class = "col-md-1"></div>
                                                    <div class = "col-md-11">
                                                        <p>Relationship - <b id = "relationship_view_0"></b></p>
                                                    </div>
                                                </div>
                                                <div class = "row">
                                                    <div class = "col-md-1"></div>
                                                    <div class = "col-md-11">
                                                        <p>Address - <b id = "address_view_0"></b></p>
                                                    </div>
                                                </div>
                                                <div class = "row">
                                                    <div class = "col-md-1"></div>
                                                    <div class = "col-md-11">
                                                        <p>Existence - <b id = "exist_view_0"></b></p>
                                                    </div>
                                                </div>
                                                <div class = "row">
                                                    <div class = "col-md-1"></div>
                                                    <div class = "col-md-11">
                                                        <p>Remarks - <b id = "rem_view_0"></b></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class = "col-md-6">
                                            <p>4. Informant Name - <b id = "inf_name_3"></b> <button class = "toggleOnOff" name = "4" style = "background:none ; border:none; "><i style = "color :green" class = "fa fa-fw fa-chevron-circle-down"></i></button></p>
                                            <div id = "showInformant-4" hidden>
                                                <div class = "row">
                                                    <div class = "col-md-1"></div>
                                                    <div class = "col-md-11">
                                                        <p>Relationship - <b id = "relationship_view_3"></b></p>
                                                    </div>
                                                </div>
                                                <div class = "row">
                                                    <div class = "col-md-1"></div>
                                                    <div class = "col-md-11">
                                                        <p>Address - <b id = "address_view_3"></b></p>
                                                    </div>
                                                </div>
                                                <div class = "row">
                                                    <div class = "col-md-1"></div>
                                                    <div class = "col-md-11">
                                                        <p>Existence - <b id = "exist_view_3"></b></p>
                                                    </div>
                                                </div>
                                                <div class = "row">
                                                    <div class = "col-md-1"></div>
                                                    <div class = "col-md-11">
                                                        <p>Remarks - <b id = "rem_view_3"></b></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class = "row">
                                        <div class = "col-md-6">
                                            <p>2. Informant Name - <b id = "inf_name_1"></b> <button class = "toggleOnOff" name = "2" style = "background:none ; border:none; "><i style = "color :green" class = "fa fa-fw fa-chevron-circle-down"></i></button></p>
                                            <div id = "showInformant-2" hidden>
                                                <div class = "row">
                                                    <div class = "col-md-1"></div>
                                                    <div class = "col-md-11">
                                                        <p>Relationship - <b id = "relationship_view_1"></b></p>
                                                    </div>
                                                </div>
                                                <div class = "row">
                                                    <div class = "col-md-1"></div>
                                                    <div class = "col-md-11">
                                                        <p>Address - <b id = "address_view_1"></b></p>
                                                    </div>
                                                </div>
                                                <div class = "row">
                                                    <div class = "col-md-1"></div>
                                                    <div class = "col-md-11">
                                                        <p>Existence - <b id = "exist_view_1"></b></p>
                                                    </div>
                                                </div>
                                                <div class = "row">
                                                    <div class = "col-md-1"></div>
                                                    <div class = "col-md-11">
                                                        <p>Remarks - <b id = "rem_view_1"></b></p>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class = "col-md-6">
                                            <p>5. Informant Name - <b id = "inf_name_4"></b> <button class = "toggleOnOff" name = "5" style = "background:none ; border:none; "><i style = "color :green" class = "fa fa-fw fa-chevron-circle-down"></i></button></p>
                                            <div id = "showInformant-5" hidden>
                                                <div class = "row">
                                                    <div class = "col-md-1"></div>
                                                    <div class = "col-md-11">
                                                        <p>Relationship - <b id = "relationship_view_4"></b></p>
                                                    </div>
                                                </div>
                                                <div class = "row">
                                                    <div class = "col-md-1"></div>
                                                    <div class = "col-md-11">
                                                        <p>Address - <b id = "address_view_4"></b></p>
                                                    </div>
                                                </div>
                                                <div class = "row">
                                                    <div class = "col-md-1"></div>
                                                    <div class = "col-md-11">
                                                        <p>Existence - <b id = "exist_view_4"></b></p>
                                                    </div>
                                                </div>
                                                <div class = "row">
                                                    <div class = "col-md-1"></div>
                                                    <div class = "col-md-11">
                                                        <p>Remarks - <b id = "rem_view_4"></b></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class = "row">
                                        <div class = "col-md-6">
                                            <p>3. Informant Name - <b id = "inf_name_2"></b> <button class = "toggleOnOff" name = "3" style = "background:none ; border:none;"><i style = "color :green" class = "fa fa-fw fa-chevron-circle-down"></i></button></p>
                                            <div id = "showInformant-3" hidden>
                                                <div class = "row">
                                                    <div class = "col-md-1"></div>
                                                    <div class = "col-md-11">
                                                        <p>Relationship - <b id = "relationship_view_2"></b></p>
                                                    </div>
                                                </div>
                                                <div class = "row">
                                                    <div class = "col-md-1"></div>
                                                    <div class = "col-md-11">
                                                        <p>Address - <b id = "address_view_2"></b></p>
                                                    </div>
                                                </div>
                                                <div class = "row">
                                                    <div class = "col-md-1"></div>
                                                    <div class = "col-md-11">
                                                        <p>Existence - <b id = "exist_view_2"></b></p>
                                                    </div>
                                                </div>
                                                <div class = "row">
                                                    <div class = "col-md-1"></div>
                                                    <div class = "col-md-11">
                                                        <p>Remarks - <b id = "rem_view_2"></b></p>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                {{--new--}}
                                <div class = "box box-primary">
                                    <h3 style = "text-align: center">New Informant Gathered </h3><br>

                                    <div class = "row">
                                        <div class = "col-md-6">
                                            <p>1. Informant Name - <b id = "new_info_name_view_0"></b> <button class = "toggleOnOff" name = "6" style = "background:none ; border:none; "><i style = "color :green" class = "fa fa-fw fa-chevron-circle-down"></i></button></p>
                                            <div id = "showInformant-6" hidden>
                                                <div class = "row">
                                                    <div class = "col-md-1"></div>
                                                    <div class = "col-md-11">
                                                        <p>Relationship - <b id = "new_relationship_0"></b></p>
                                                    </div>
                                                </div>
                                                <div class = "row">
                                                    <div class = "col-md-1"></div>
                                                    <div class = "col-md-11">
                                                        <p>Address - <b id = "new_address_view_0"></b></p>
                                                    </div>
                                                </div>
                                                <div class = "row">
                                                    <div class = "col-md-1"></div>
                                                    <div class = "col-md-11">
                                                        <p>Remarks - <b id = "new_remarks_view_0"></b></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class = "col-md-6">
                                            <p>3. Informant Name - <b id = "new_info_name_view_2"></b> <button class = "toggleOnOff" name = "8" style = "background:none ; border:none; "><i style = "color :green" class = "fa fa-fw fa-chevron-circle-down"></i></button></p>
                                            <div id = "showInformant-8" hidden>
                                                <div class = "row">
                                                    <div class = "col-md-1"></div>
                                                    <div class = "col-md-11">
                                                        <p>Relationship - <b id = "new_relationship_2"></b></p>
                                                    </div>
                                                </div>
                                                <div class = "row">
                                                    <div class = "col-md-1"></div>
                                                    <div class = "col-md-11">
                                                        <p>Address - <b id = "new_address_view_2"></b></p>
                                                    </div>
                                                </div>
                                                <div class = "row">
                                                    <div class = "col-md-1"></div>
                                                    <div class = "col-md-11">
                                                        <p>Remarks - <b id = "new_remarks_view_2"></b></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class = "row">
                                        <div class = "col-md-6">
                                            <p>2. Informant Name - <b id = "new_info_name_view_1"></b> <button class = "toggleOnOff" name = "7" style = "background:none ; border:none; "><i style = "color :green" class = "fa fa-fw fa-chevron-circle-down"></i></button></p>
                                            <div id = "showInformant-7" hidden>
                                                <div class = "row">
                                                    <div class = "col-md-1"></div>
                                                    <div class = "col-md-11">
                                                        <p>Relationship - <b id = "new_relationship_1"></b></p>
                                                    </div>
                                                </div>
                                                <div class = "row">
                                                    <div class = "col-md-1"></div>
                                                    <div class = "col-md-11">
                                                        <p>Address - <b id = "new_address_view_1"></b></p>
                                                    </div>
                                                </div>
                                                <div class = "row">
                                                    <div class = "col-md-1"></div>
                                                    <div class = "col-md-11">
                                                        <p>Remarks - <b id = "new_remarks_view_1"></b></p>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class = "col-md-6">

                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class = "col-md-6">
                                <div class = "box box-primary">
                                    <h3 style = "text-align: center">Background Information</h3><br>

                                    <div class = "row" style = "padding-top : 10px;">
                                        <div class = "col-md-5">
                                            <label for="">Employee ID:</label>
                                            <p id = "showempIDAPf"></p>
                                        </div>
                                        <div class = "col-md-2"></div>
                                        <div class = "col-md-5">
                                            <label for="">Date Hired:</label>
                                            <p id = "showDateHiredPf"></p>
                                        </div>
                                    </div>
                                    <div class = "row" style = "padding-top : 10px;">
                                        <div class = "col-md-5">
                                            <label for="">Employee Name: </label>
                                            <p id = "showEmpNamePf"></p>
                                        </div>
                                        <div class = "col-md-2"></div>
                                        <div class = "col-md-5">
                                            <label for="">Department:</label>
                                            <p id = "showDeptPf"></p>
                                        </div>
                                    </div>
                                    <div class = "row" style = "padding-top : 10px;">
                                        <div class = "col-md-5">
                                            <label for="">Job Title: </label>
                                            <p id = "showJobTitlePF"></p>
                                        </div>
                                        <div class = "col-md-7"></div>
                                    </div>
                                </div>
                                <div class = "box box-primary">
                                    <h3 style = "text-align: center">Compliance Checklist</h3><br>

                                    <div class = "row" style = "padding-top : 10px;">
                                        <div class = "col-md-12">
                                            <p>1. Did our personnel come in motorcycle? - <b class = "ans_comp"></b></p>
                                            <p>2. Did our personnel offer assistance for your transaction? - <b class = "ans_comp"></b> </p>
                                            <p>3. Did our personnel present an Introduction Letter?  - <b class = "ans_comp"></b> </p>
                                            <p>4. Did our personnel presented his ID card?  - <b class = "ans_comp"></b></p>
                                            <p>5. Did the personnel give any contact information (telephone/mobile/email) of our company or his? - <b class = "ans_comp"></b></p>
                                            <p>6. How did our personnel introduce his self? - <b class = "ans_comp"></b></p>
                                            <p>7. Was our personnel in uniform? - <b class = "ans_comp"></b></p>
                                            <p>8. Was our personnel respectful? - <b class = "ans_comp"></b></p>
                                            <p>9. Was there any request by the personnel (coffe/water/etc) or favor asked during the interview? - <b class = "ans_comp"></b></p>
                                        </div>
                                    </div>
                                </div>
                                <div class = "box box-primary">
                                    <h3 style = "text-align: center">Summary Report</h3><br>

                                    <div class = "row" style = "padding-top : 10px;">
                                        <div class = "col-md-12">
                                            <h4 id = "summary_rep_pf"> </h4>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>

                    <div id = "showCssForm" hidden>
                        <div class = "row" style = "padding-top: 20px">
                            <div class = "col-md-6">
                                <div class = "box box-primary">
                                    <h3 style = "text-align: center">Account Information</h3><br>

                                    <div class = "row" style = "padding-top : 10px;">
                                        <div class = "col-md-6">
                                            <label for="">Endorsement Id</label>
                                            <p id = "showIDcssf"></p>
                                        </div>
                                        <div class = "col-md-6">
                                            <label for="">Bank</label>
                                            <p id = "showBankcssf"></p>
                                        </div>
                                    </div>
                                    <div class = "row" style = "padding-top : 10px;">
                                        <div class = "col-md-6">
                                            <label for="">Account name:</label>
                                            <p id = "showAcctNamecssf"></p>
                                        </div>
                                        <div class = "col-md-6">
                                            <label for="">Endorsement Date:</label>
                                            <p id = "showEndorseDateCssf"></p>
                                        </div>
                                    </div>
                                </div>

                                <div class = "box box-primary">
                                    <h3 style = "text-align: center">Report Checklist</h3><br>

                                    <div class =  "row">
                                        <div class = "col-md-4"></div>
                                        <div class = "col-md-3" >
                                            <h4 style = "text-align: center">Grade %</h4>
                                        </div>
                                        <div class = "col-md-5">
                                            <h4 style = "text-align: center">Grade Remarks</h4>
                                        </div>
                                    </div>
                                    <div class = "row" style = "padding-top : 10px;">
                                        <div class = "col-md-4">
                                            <p>Completeness(5%)</p>
                                        </div>
                                        <div class = "col-md-3">
                                            <p id = "showGrade1" style = "text-align: center"></p>
                                        </div>
                                        <div class = "col-md-5">
                                            <p id = "showGradeRemarks1"></p>
                                        </div>
                                    </div>
                                    <div class = "row" style = "padding-top : 10px;">
                                        <div class = "col-md-4">
                                            <p>GPS Attachment(5%)</p>
                                        </div>
                                        <div class = "col-md-3">
                                            <p id = "showGrade2" style = "text-align: center"></p>
                                        </div>
                                        <div class = "col-md-5">
                                            <p id = "showGradeRemarks2"></p>
                                        </div>
                                    </div>
                                    <div class = "row" style = "padding-top : 10px;">
                                        <div class = "col-md-4">
                                            <p>Informants Validity(15%)</p>
                                        </div>
                                        <div class = "col-md-3">
                                            <p id = "showGrade3" style = "text-align: center"></p>
                                        </div>
                                        <div class = "col-md-5">
                                            <p id = "showGradeRemarks3"></p>
                                        </div>
                                    </div>
                                    <div class = "row" style = "padding-top : 10px;">
                                        <div class = "col-md-4">
                                            <p>Encoding Accuracy(5%)</p>
                                        </div>
                                        <div class = "col-md-3">
                                            <p id = "showGrade4" style = "text-align: center"></p>
                                        </div>
                                        <div class = "col-md-5">
                                            <p id = "showGradeRemarks4"></p>
                                        </div>
                                    </div>
                                    <div class = "row" style = "padding-top : 10px;">
                                        <div class = "col-md-4">
                                            <p>Selfie/Uniform/ID(5%)</p>
                                        </div>
                                        <div class = "col-md-3">
                                            <p id = "showGrade5" style = "text-align: center"></p>
                                        </div>
                                        <div class = "col-md-5">
                                            <p id = "showGradeRemarks5"></p>
                                        </div>
                                    </div>
                                    <div class = "row" style = "padding-top : 10px;">
                                        <div class = "col-md-4">
                                            <p>TAT Compliance(60%)</p>
                                        </div>
                                        <div class = "col-md-3">
                                            <p id = "showGrade6" style = "text-align: center"></p>
                                        </div>
                                        <div class = "col-md-5">
                                            <p id = "showGradeRemarks6"></p>
                                        </div>
                                    </div>
                                    <div class = "row" style = "padding-top : 10px;">
                                        <div class = "col-md-4">
                                            <p>Attached Documents(5%)</p>
                                        </div>
                                        <div class = "col-md-3">
                                            <p id = "showGrade7" style = "text-align: center"></p>
                                        </div>
                                        <div class = "col-md-5">
                                            <p id = "showGradeRemarks7"></p>
                                        </div>
                                    </div>
                                    <div class = "row" style = "padding-top : 15px;">
                                        <div class = "col-md-4"></div>
                                        <div class = "col-md-3">
                                            <h4 style = "text-align: center">Total Grade : <b id  = "showTotalGrade"> </b></h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class = "col-md-6">
                                <div class = "box box-primary">
                                    <h3 style = "text-align: center">Background Information</h3><br>

                                    <div class = "row" style = "padding-top : 10px;">
                                        <div class = "col-md-6">
                                            <label for="">Employee ID:</label>
                                            <p id = "showEmpIDCssf"></p>
                                        </div>
                                        <div class = "col-md-6">
                                            <label for="">Date Hired:</label>
                                            <p id = "showEmpHiredDateCssf"></p>
                                        </div>
                                    </div>
                                    <div class = "row" style = "padding-top : 10px;">
                                        <div class = "col-md-6">
                                            <label for="">Employee Name:</label>
                                            <p id = "showEmpNameCssf"></p>
                                        </div>
                                        <div class = "col-md-6">
                                            <label for="">Job Title:</label>
                                            <p id = "showEmpJobCssf"></p>
                                        </div>

                                    </div>
                                    <div class = "row" style = "padding-top : 10px;">
                                        <div class = "col-md-6">
                                            <label for="">Area:</label>
                                            <p id = "showAreaCssf"></p>
                                        </div>
                                        <div class = "col-md-6">
                                            <label for="">Regional Branch Head:</label>
                                            <p id = "showRegBranchCssf"></p>
                                        </div>
                                    </div>
                                    <div class = "row" style = "padding-top : 10px;">
                                        <div class = "col-md-6">
                                            <label for="">Branch:</label>
                                            <p id = "showBranchCssf"></p>
                                        </div>
                                        <div class = "col-md-6">
                                            <label for="">Senior Account Officer:</label>
                                            <p id = "showSaoCssf"></p>
                                        </div>
                                    </div>
                                    <div class = "row" style = "padding-top : 10px;">
                                        <div class = "col-md-6">
                                            <label for="">CI Supervisor:</label>
                                            <p id = "showCiSupCssf"></p>
                                        </div>
                                    </div>
                                </div>
                                <div class = "box box-primary">
                                    <h3 style = "text-align: center">Summary Report</h3><br>

                                    <div class = "row" style = "padding-top : 10px;">
                                        <div class = "col-md-12">
                                            <p id = "showSummaryCssf">Test</p>
                                        </div>
                                    </div>
                                </div>
                                <div class = "box box-primary">
                                    <h3 style = "text-align: center">Cause of Delay</h3><br>

                                    <div class = "row" style = "padding-top : 10px;">
                                        <div class = "col-md-12">
                                            <p id = "showCoDCssf">Test</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                        <a class="btn btn-success" href = "#" target="_blank" id = "showPdfPrintLogs"><i class="glyphicon glyphicon-open-file"></i>View/Print Report</a>
                        <span id = "showToConfirm" hidden>
                            <button class="btn btn-warning" id = "returnAudit"><i class="fa fa-fw fa-reply"></i> Return</button>
                            <button class="btn btn-primary" id = "approveAudit"><i class = "glyphicon glyphicon-ok"></i> Approve</button>
                        </span>
                        <span id = "showAlready" hidden>
                             <button type="button" class="btn btn-primary" disabled>Already Reviewed</button>
                        </span>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    </div>

    <div class="modal fade" id="modal-audit-return-logs">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" style = "text-align: center">Reason for Returning</h4>
                </div>
                <div class="modal-body">
                    <div class = "row" style = "padding-top: 20px;">
                        <div class = "col-md-12">
                            <label for="">Remarks:</label>
                            <textarea id="audit_remarks_log" rows = "5" class = "form-control"></textarea>
                        </div>
                    </div>
                    <div class = "row" style = "padding-top: 20px;" id = "showRemRetAudit" hidden>
                        <div class = "col-md-6">
                            <label for="">Date/Time of Return:</label>
                            <input type="text" class = "form-control" id = "show_date_return" disabled>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-warning" id = "return_now_log_au">Return now</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    {{--new floyd--}}
    <div class="modal modal-warning fade" id="modal-loading-arf-files">
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
                            <h5>Please wait while bulk request is being sent...... <img src="{{asset('dist/img/loading.gif')}}" style = "width : 3%" id="loadingGIFArf"></h5>
                        </div>
                        <div class ="col-md-2"></div>
                    </div>
                    <div class = "row">
                        <div class="col-md-2"></div>
                        <div class = "col-md-8">
                            <span id="ulPercentage_ArfFile">--</span>
                            <div id="progressbar_ArfFile" hidden></div>
                        </div>
                        <div class="col-md-2"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <div class="modal modal-success fade" id="modal-success-arf-send">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <p style = "text-align:  center"> Log Success!</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline pull-right" data-dismiss="modal">Close</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>


    <div class="modal fade" id="modal-ask-save-update">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" style = "text-align: center">Confirmation</h4>
                </div>
                <div class="modal-body">
                    <div class = "row">
                        <div class = "col-md-12">
                            <div class="box box-primary">
                                <div class ="row" style = "padding-top : 20px;">
                                    <div class = "col-md-12">
                                        <h4 style = "text-align: center">Do you want to save a new log or update current log?</h4>
                                    </div>
                                </div>
                                <div class ="row" style = "padding-top : 10px; padding-bottom : 10px;">
                                    <div class = "col-md-3"></div>
                                    <div class = "col-md-3">
                                        <button class ="btn btn-md btn-primary" id ="btnArfSaveNew"><i class = "fa fa-fw fa-save"></i> SAVE NEW</button>
                                    </div>
                                    <div class = "col-md-3">
                                        <button class ="btn btn-md btn-warning" id = "btnArfUpdateLog"><i class="fa fa-fw fa-edit"></i> UPDATE CURRENT</button>
                                    </div>
                                    <div class = "col-md-3"></div>
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


    <div class="modal fade" id="modal-ci-note">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" style = "text-align: center">C.I Note</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box bo-danger">
                                <div class="box-body">
                                    <textarea name="" id="view_note" rows="10    " class="form-control" disabled style="resize: none; overflow-y: auto" placeholder="NO CI NOTE"></textarea>
                                </div>
                                <div class="box-body">
                                    <button type="button" class="btn btn-primary pull-right" id="exportReport">Export Note</button>
                                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                                </div>
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

    <div class="modal fade" id="modal-view-fund-req-rems">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" style = "text-align: center">Approver Remarks</h4>
                </div>
                <div class="modal-body">
                    <div class = "row">
                        <div class = "col-md-12">
                            <label for="">Remarks:</label>
                            <textarea id="req-rem-fund-req-rem" rows = "5" class = "form-control" disabled></textarea>
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



@endsection

@push('leftsidebar')
    @include('audit.audit-leftsidebar')
@endpush

@push('jscript')
    <script src="https://cdn.datatables.net/buttons/1.5.0/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.0/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.0/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.0/js/buttons.print.min.js"></script>
    <script src="{!!asset('fine-uploader/jquery.fine-uploader.js') !!}"></script>
    <script src="{!!asset('fine-uploader/fine-uploader.js') !!}"></script>
    <script src="{{ asset('jscript/audit.js?n='.$javs) }}"></script>
    <script src="{{ asset('jscript/fund-request-tables-audit.js?n='.$javs) }}"></script>
    <script src="{{ asset('jscript/bi-download-file-view-info.js?n='.$javs) }}"></script>
@endpush
