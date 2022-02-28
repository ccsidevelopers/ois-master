@extends('bank_dept.ci.template.master')

{{--<link href="{{ asset('plugins/DropZoneJs/min/dropzone.min.css') }}" rel="stylesheet" type="text/css">--}}
{{--<script src="{!!asset('plugins/DropZoneJs/min/dropzone.min.js') !!}"></script>--}}

<link href="{{ asset('fine-uploader/fine-uploader-new.css') }}" rel="stylesheet" type="text/css">

<style>
    #trigger-upload {
        color: white;
        background-color: #00ABC7;
        font-size: 14px;
        padding: 7px 20px;
        background-image: none;
    }

    #fine-uploader-manual-trigger .qq-upload-button {
        margin-right: 15px;
    }

    #fine-uploader-manual-trigger .buttons {
        width: 36%;
    }

    #fine-uploader-manual-trigger .qq-uploader .qq-total-progress-bar-container {
        width: 60%;
    }
    .glyphicon-paperclip {
        font-size: 20px;
    }
    .glyphicon-ok {
        font-size: 20px;
    }
    .glyphicon-download-alt {
        font-size: 20px;
    }
    .fa-money {
        font-size: 60px;
    }
</style>


<script type="text/template" id="qq-template-manual-trigger">
    <div class="qq-uploader-selector qq-uploader" qq-drop-area-text="Drop files here">
        <div class="qq-total-progress-bar-container-selector qq-total-progress-bar-container">
            <div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" class="qq-total-progress-bar-selector qq-progress-bar qq-total-progress-bar"></div>
        </div>
        <div class="qq-upload-drop-area-selector qq-upload-drop-area" qq-hide-dropzone>
            <span class="qq-upload-drop-area-text-selector"></span>
        </div>
        <div class="buttons">
            <div class="qq-upload-button-selector qq-upload-button">
                <div>Select files</div>
            </div>
        </div>

        <button type="button" id="trigger-upload" class="btn btn-xs btn-primary">
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

@section('content')
    <div class="content-wrapper">

        <!-- Main content -->
        <section class="content">

            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    Endorsements
                    <small>Accounts</small>
                </h1>
            </section>
            <!-- Default box -->
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Assigned Accounts</h3>

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
                                    <li><a href="#tab_1" id="tab1" data-toggle="tab"> <span class="glyphicon glyphicon-paperclip"></span> <span id="tab1_pending"></span></a></li>
                                    <li><a href="#tab_2" id="tab2" data-toggle="tab"> <span class="glyphicon glyphicon-ok"></span> <span id="tab2_finish"></span></a></li>
                                    <li><a href="#tab_3" id="tab3" data-toggle="tab"> <span class="glyphicon glyphicon-download-alt"></span> <span id="tab3_download"></span></a></li>
                                    {{--<li><a href="#tab_3" id="tab4" data-toggle="tab"> <span class="fa fa-money"></span> <span id=""></span></a></li>--}}
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="tab_1">
                                        <table id="ci-table" class="tableendorse table-hover table-condensed" width="100%">
                                            <thead>
                                            <tr>
                                                <th>Id:</th>
                                                <th>Account Name:</th>
                                                <th>Date/Time Due:</th>
                                                <th>Bank Name:</th>
                                                <th>Type of Request:</th>
                                                {{--<th>Type of Loan:</th>--}}
                                                <th>Type of Subject:</th>
                                                <th>Verify Through:</th>
                                                <th>Bank Remarks:</th>
                                                <th>Entry As:</th>
                                                <th>Coborrower/Addresses:</th>
                                                <th>Encode/Attachments:</th>
                                                <th>Reports:</th>
                                                <th>Time Dispatched: </th>
                                            </tr>
                                            </thead>
                                        </table>
                                        <input type="button" class="btn btn-sm btn-info" value="Refresh Pending Account" id="btnRefreshTable">
                                    </div>
                                    <!-- /.tab-pane -->
                                    <div class="tab-pane" id="tab_2">

                                        <table id="ci-table-finish" class="tableendorse table-hover table-condensed" width="100%">
                                            <thead>
                                            <tr>
                                                <th>Id:</th>
                                                <th>Account Name:</th>
                                                <th>Internal Status:</th>
                                                <th>Bank Name:</th>
                                                <th>Type of Request:</th>
                                                {{--<th>Type of Loan:</th>--}}
                                                <th>Type of Subject:</th>
                                                <th>Verify Through:</th>
                                                <th>Bank Remarks:</th>
                                                <th>Entry As:</th>
                                                <th>Coborrower/Addresses:</th>
                                                <th>Attachments:</th>
                                                <th>Reports:</th>
                                                {{--<th>Expenses:</th>--}}
                                                <th>Time Dispatched: </th>
                                            </tr>
                                            </thead>
                                        </table>
                                        <input type="button" class="btn btn-sm btn-info" value="Refresh Finish Account" id="btnRefreshTable2">
                                    </div>
                                    <!-- /.tab-pane -->
                                    <div class="tab-pane" id="tab_3">
                                        <div style="overflow:scroll; height:400px;">
                                            <span id="getfiles"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->

                {{--MODAL ATTACHMENT--}}
                <div class="modal fade" id="acctReport" data-backdrop="static" data-keyboard="false">
                    <div class="modal-dialog">
                        <div class="modal-content" id="modal_body_content_acctreport">
                            <div class="modal-header">
                                <button type="button" class="close" aria-label="Close" id="ButtonExitModal">
                                    <span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="modalTitle">Attach Report</h4>
                            </div>
                            <div class="modal-body" id="modal_body_enoding">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="box box-solid">
                                            <div class="box-header with-border">
                                                <i class="fa fa-info"></i>
                                                <h3 class="box-title">Endorsement Information</h3>
                                                <div class="box-tools pull-right">
                                                {{--<button type="button" class="btn btn-sm" data-target="#box_body_endorsement_info" data-toggle="collapse"> <i class="fa fa-minus"></i></button>--}}
                                                </div>
                                            </div>

                                            <div class="box-body" id="box_body_endorsement_info" >
                                                <div class="row">
                                                    {{--PDRN ADDRESS HERE--}}
                                                    <table border="2" style="white-space: normal; font-size: 10px" width="100%" id="otherPersonalSpan"></table>
                                                    {{--END OF PDRN ADDRESS--}}
                                                    {{--COBORROWER HERE--}}
                                                    <table border="2" style="white-space: normal; font-size: 10px" width="100%" id="otherInfoSpan"></table>
                                                    {{--END OF COBORROWER--}}
                                                    {{--EMPLOYER HERE--}}
                                                    <table border="2" style="white-space: normal; font-size: 10px" width="100%" id="otherEmployerSpan"></table>
                                                    {{--END OF COBORROWER--}}
                                                    {{--BUSINESS HERE--}}
                                                    <table border="2" style="white-space: normal; font-size: 10px" width="100%" id="otherBusinessSpan"></table>
                                                    {{--END OF BUSINESS--}}
                                                    {{--BANK INFO--}}
                                                    <table border="2" style="white-space: normal; font-size: 10px" width="100%" id="otherBankInfo"></table>
                                                    {{--END OF BANK INFO--}}
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="box box-solid">
                                            <div class="box-header with-border">
                                                <i class="fa fa-info"></i>
                                                <h3 class="box-title" >Update Date/Time Visit <i id="update_date_time_icon" class="fa fa-exclamation-circle" style="color: orange"></i></h3>
                                                <div class="box-tools pull-right">
                                                    <button type="button" class="btn btn-sm btn_en_hide_upper" val="hide" name="update_d_t"><i class="fa fa-plus"></i></button>
                                                </div>
                                            </div>
                                            <div class="box-body" hidden id="box_body_update_date_time_visit">
                                                <div class="row">
                                                    <div class="form-group col-xs-6">
                                                        <label>Date Visit:</label>
                                                        <div class="input-group">
                                                            <div class="input-group-addon">
                                                                <i class="fa fa-calendar"></i>
                                                            </div>
                                                            <input type="date" class="form-control" id="DateVisit" name="DateVisit">
                                                        </div>
                                                    </div>

                                                    <div class="bootstrap-timepicker">
                                                        <div class="form-group col-xs-6">
                                                            <label>Time Visit:</label>
                                                            <div class="input-group">
                                                                <input type="time" id="TimeVisit" name="TimeVisit" class="form-control" >
                                                                <div class="input-group-addon">
                                                                    <i class="fa fa-clock-o"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group col-xs-12">
                                                        <center><h4>Press "Update Date/Time Visit" to update time of visit.</h4></center>
                                                        <input type="button" class="btn btn-block btn-warning" id="updateVisit" value="Update Date/Time Visit">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <center><span id="successUpdateVisit"></span></center>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="box box-solid">
                                            <div class="box-header with-border">
                                                <i class="fa fa-info"></i>
                                                <h3 class="box-title">Report Encode (Optional) <i id="encode_icon" class="fa fa-exclamation-circle" style="color: orange"></i></h3>
                                                <div class="box-tools pull-right">
                                                    <button type="button" class="btn btn-sm btn_en_hide_upper" val="hide" name="encode"><i class="fa fa-plus"></i></button>
                                                </div>
                                            </div>
                                            <div class="box-body" hidden id="box_body_encode">
                                                <div class="row">
                                                    <div class="col-md-12 form-group">
                                                        <button type="button" name="load_auto_save" id="btn_load_auto_save_data" class="btn btn-solid btn-info btn-sm form-control btn_encode_save">Load (Session) Data</button>
                                                    </div>
                                                    <div class="col-md-12 form-group">
                                                        <label for="select_encode_template">Select Template: </label>
                                                        <select class="form-control" id="select_encode_template"></select>
                                                    </div>
                                                    <div class="col-md-12 form-group">
                                                    <table id="endorse_encode_account" style="word-wrap: break-word; table-layout: fixed; width: 100%;" class="table-hover">
                                                        <tbody>
                                                        </tbody>
                                                    </table>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <label></label>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <button type="button" name="save_only" hidden id="btn_save_encode_temp" class="btn btn-solid btn-info btn-sm form-control btn_encode_save">Save (only) Encoded Data</button>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <button type="button" name="save_final" hidden id="btn_final_save_encode_temp" class="btn btn-solid btn-success btn-sm form-control btn_encode_save">Save Final Data</button>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <button type="button" name="download_instead" hidden id="btn_download_instead" class="btn btn-solid btn-warning btn-sm form-control btn_encode_save">Through Download-Upload</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="overlay_load" hidden class="overlay">
                                                <i class="fa fa-refresh fa-spin"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="box box-solid">
                                            <div class="box-header with-border">
                                                <i class="fa fa-info"></i>
                                                <h3 class="box-title">Report Attachments <i id="attachments_icon" class="fa fa-exclamation-circle" style="color: orange"></i></h3>
                                                <div class="box-tools pull-right">
                                                    <button type="button" class="btn btn-sm btn_en_hide_upper" val="hide" name="attach"><i class="fa fa-plus"></i></button>
                                                </div>
                                            </div>
                                            <div class="box-body" hidden id="box_body_attachement">
                                                <div class="row">
                                                    <center><span id="ProgBar"></span></center>
                                                    <div id="fine-uploader-manual-trigger"></div>
                                                    {{--<form role="form" enctype="multipart/form-data" id="image-upload"  input="files" class="dropzone">--}}

                                                    {{--<input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">--}}
                                                    {{--<input type="hidden" id="acctID" name="acctID">--}}
                                                    {{--<input type="hidden" id="acctName" name="acctName">--}}
                                                    {{--<input type="hidden" id="id" name="id">--}}

                                                    {{--<br/>--}}

                                                    {{--</form>--}}

                                                    <span id="progressUpload"></span>
                                                    {{--LIST FILE HERE--}}
                                                    <span id="spanhere"></span>
                                                    {{--END OF LIST FILE--}}

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <div id="message"></div>
                                <button type="button" class="btn btn-default btn-sm btn-solid pull-right" data-dismiss="modal" id="btnModalCloseAttachment">Close</button>
                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
                {{--END OF MODAL ATTACHMENT--}}

                {{--REPORT MODAL--}}
                <div class="modal modal-default fade" id="modal-ci-report">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Note</h4>
                            </div>
                            <div class="modal-body">
                                <span id="txtAreaNote"></span>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary" id="btnSaveReport" value="Send Report">Save Note</button>
                                <button type="button" class="btn btn-primary" id="btnUpdateReport" value="Update Report">Update Note</button>
                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
                {{--END OF REPORT MODAL--}}

                {{--VIEW FULL INFO MODAL--}}
                <div class="modal fade" id="otherInfo">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">ENDORSEMENT</h4>
                            </div>
                            <div class="modal-body">
                                <span class="badge bg-light-blue-gradient"><h5>Endorsement Information</h5></span>
                                {{--PDRN ADDRESS HERE--}}
                                <table border="2" style="white-space: normal; font-size: 10px" width="100%" id="otherPersonalSpan1"></table>
                                {{--END OF PDRN ADDRESS--}}

                                {{--COBORROWER HERE--}}
                                <table border="2" style="white-space: normal; font-size: 10px" width="100%" id="otherInfoSpan1"></table>
                                {{--END OF COBORROWER--}}

                                {{--EMPLOYER HERE--}}
                                <table border="2" style="white-space: normal; font-size: 10px" width="100%" id="otherEmployerSpan1"></table>
                                {{--END OF COBORROWER--}}

                                {{--BUSINESS HERE--}}
                                <table border="2" style="white-space: normal; font-size: 10px" width="100%" id="otherBusinessSpan1"></table>
                                {{--END OF BUSINESS--}}

                                <div class="row">
                                    {{--CLIENT REMARKS--}}
                                    <div class="form-group col-xs-12">
                                        <label>Remarks:</label>
                                        <textarea id="viewRemarks" class="form-control" rows="3" disabled></textarea>
                                    </div>
                                    {{--END OF CLIENT REMARKS--}}
                                </div>
                                <div class="row">
                                    {{--CLIENT NOTES--}}
                                    <div class="form-group col-xs-12" id="divNotes">
                                        <label>Notes:</label>
                                        <textarea id="viewNotes" class="form-control" rows="3" disabled></textarea>
                                    </div>
                                    {{--END OF CLIENT NOTES--}}
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
                {{--END OF VIEW FULL INFO MODAL--}}

                {{--SUCCESS MODAL--}}
                <div class="modal modal-success fade" id="modal-successUpload">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Success!</h4>
                            </div>
                            <div class="modal-body">
                                <p style="text-align: center">Report Successfully Uploaded</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline pull-right" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
                {{--END--}}

                {{--ERROR SENDING MODAL--}}
                <div class="modal modal-danger fade" id="modal-errorUpload">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Error 500!</h4>
                            </div>
                            <div class="modal-body">
                                <p style="text-align: center">Error upload file, please check your internet connection or must be attached 1 or more file!</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline pull-right" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
                {{--END--}}

                {{--ERROR EMPTY FILE MODAL--}}
                <div class="modal modal-danger fade" id="modal-errorEmptyUpload">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Error 300!</h4>
                            </div>
                            <div class="modal-body">
                                <p style="text-align: center">Error upload file, no attach file or report.!</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline pull-right" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
                {{--END--}}

                {{--SENDING MODAL--}}
                <div class="modal modal-info fade" id="modal-uploadingFile">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Sending...</h4>
                            </div>
                            <div class="modal-body">
                                <p style="text-align: center">Uploading Report...  <img src="{{ asset('dist/img/loading.gif') }}" style="width: 5%;"></p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline pull-right" data-dismiss="modal" id="btnModalCloseSendingBuss">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
                {{--END--}}

                {{--EXPENSES MODAL--}}
                <div class="modal modal-default fade" id="modal_expenses">
                    <div class="modal-dialog">
                        <form enctype="multipart/form-data" id="upload_form">
                            <div class="row">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title">EXPENSES</h4>
                                    </div>
                                    <div class="modal-body">
                                        <center><p>Please indicate your expenses on this account.</p></center>
                                        <span id="tableExpensesSpan"></span>
                                        <div class="row" style="width: 100%">
                                            <button type="button" class="btn btn-default pull-right" id="btn_asso" style="margin: 10px">Associate With:(SHOW)</button>
                                        </div>
                                        <span id="span_for_asso" hidden>
                                           <b>These are Co-borrowers only</b> <select id="list_of_accounts_asso" class="select2 select2-hidden-accessible " multiple="" data-placeholder="Select Accounts" style="width: 100%;" tabindex="-1" aria-hidden="true"></select>
                                            <b>NOTE: Click "Confirm" if you done including co-borrower to associate with the subject. But if you want to remove certain co-borrower just click the "X" from the name.</b>
                                           <button type="button" id="Btn_asso_confirm" style="margin-top: 10px; margin-bottom: 20px" class="btn btn-primary btn-block pull-right">Confirm</button>
                                        </span>

                                        <div id="div_for_note_exp" class="row" style="width: 100%">
                                            <center>
                                                <b>Note:</b>
                                            </center>
                                            <textarea style="width:80%; margin-left: 13%; height: 20%" id="CiExpNote"></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
                                        <button type="button" id="BtnAddExpenses" class="btn btn-primary pull-right">Add Expenses</button>
                                    </div>
                                </div>
                                <!-- /.modal-content -->
                            </div>
                        </form>
                    </div>
                    <!-- /.modal-dialog -->
                </div>
                {{--END OF EXPENSES MODAL--}}

                {{--C.I FUND MODAL--}}
                {{--<div class="modal modal-default fade" id="modal_ci_fund">--}}
                    {{--<div class="modal-dialog">--}}
                        {{--<div class="modal-content">--}}
                            {{--<div class="modal-header">--}}
                                {{--<button type="button" class="close" data-dismiss="modal" aria-label="Close">--}}
                                    {{--<span aria-hidden="true">&times;</span></button>--}}
                                {{--<h5 class="modal-title">C.I Fund logs</h5>--}}
                            {{--</div>--}}
                            {{--<div class="modal-body">--}}
                                {{--<p>--}}
                                {{--<center>--}}
                                    {{--<div style="overflow:scroll; height: 40%">--}}
                                        {{--<span id="ci_fund_logs_table"></span>--}}
                                    {{--</div>--}}
                                {{--</center>--}}
                                {{--</p>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<!-- /.modal-content -->--}}
                    {{--</div>--}}
                    {{--<!-- /.modal-dialog -->--}}
                {{--</div>--}}
                {{--END C.I FUND MODAL--}}



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
    {{--MOBILE RESPONSIVE DEPENDENCIES--}}
    {{--<link rel="stylesheet" href="http://demo.itsolutionstuff.com/plugin/bootstrap-3.min.css">--}}
    {{--<link href="{{ asset('plugins/DropZoneJs/min/dropzone.min.css') }}" rel="stylesheet" type="text/css">--}}
    {{--<script src="{!!asset('plugins/DropZoneJs/min/dropzone.min.js') !!}"></script>--}}

    {{--<script src="http://demo.itsolutionstuff.com/plugin/jquery.js"></script>--}}
    {{--<link rel="stylesheet" href="http://demo.itsolutionstuff.com/plugin/bootstrap-3.min.css">--}}

    {{--<script type="text/javascript">--}}

    <script>

        $('#btn_asso').click(function () {

            if($('#span_for_asso').attr('hidden') == 'hidden')
            {
                $('#span_for_asso').removeAttr('hidden');
                $('#btn_asso').html('Associate With:(HIDE)');
            }
            else
            {
                $('#span_for_asso').attr('hidden','hidden');
                $('#btn_asso').html('Associate With:(SHOW)');
            }


        });

        $('#list_of_accounts_asso').change(function () {
            setTimeout(function () {
                $('.select2-selection__choice').css('color','black');
//                console.log('change');
            },1000);
        });

    </script>


    {{--</script>--}}

    {{--<link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.0.1/min/dropzone.min.css" rel="stylesheet">--}}
    {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.2.0/min/dropzone.min.js"></script>--}}
    <script src="{!!asset('fine-uploader/jquery.fine-uploader.js') !!}"></script>
    <script src="{!!asset('fine-uploader/fine-uploader.js') !!}"></script>

    <link rel="stylesheet" href="https://cdn.datatables.net/rowreorder/1.2.0/css/rowReorder.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.1.1/css/responsive.dataTables.min.css">
    <script src="https://cdn.datatables.net/rowreorder/1.2.0/js/dataTables.rowReorder.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.1.1/js/dataTables.responsive.min.js"></script>
    <script src="{{ asset('jscript/ci.js?n='.$javs) }}"></script>
    <script src="{{ asset('jscript/getLatLong.js?n='.$javs) }}"></script>
    <script src="{{ asset('jscript/idle/jquery.idle.js?n='.$javs) }}"></script>
    <script src="{{ asset('jscript/detect-user-idle.js?n='.$javs) }}"></script>
@endpush