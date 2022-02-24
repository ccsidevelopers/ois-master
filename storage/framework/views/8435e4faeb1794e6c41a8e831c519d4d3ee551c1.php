<!DOCTYPE html>
<html>
<link href="<?php echo e(asset('fine-uploader/fine-uploader-new.css')); ?>" rel="stylesheet" type="text/css">

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

<script type="text/template" id="qq-bi-rep-manual-trigger">
    <div class="qq-uploader-selector qq-uploader" qq-drop-area-text="Select Files">
        <div class="qq-total-progress-bar-container-selector qq-total-progress-bar-container">
            <div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" class="qq-total-progress-bar-selector qq-progress-bar qq-total-progress-bar"></div>
        </div>
        <div class="qq-upload-drop-area-selector qq-upload-drop-area" qq-hide-dropzone>
            <span class="qq-upload-drop-area-text-selector"></span>
        </div>
        <div class="buttons">
            <div class="qq-upload-button-selector qq-upload-button">
                <center>Select File/s</center>
            </div>
        </div>

        <button type="button" id="trigger-uploadv3" class="btn btn-xs btn-primary" style="display: none;">
            <i class="icon-upload icon-white"></i> Upload
        </button>

        <span class="qq-drop-processing-selector qq-drop-processing">
                <span>Processing selected files...</span>
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


<script type="text/template" id="qq-attendance-template-manual-trigger">
    <div class="qq-uploader-selector qq-uploader" qq-drop-area-text="Select Files">
        <div class="qq-total-progress-bar-container-selector qq-total-progress-bar-container">
            <div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" class="qq-total-progress-bar-selector qq-progress-bar qq-total-progress-bar"></div>
        </div>
        <div class="qq-upload-drop-area-selector qq-upload-drop-area" qq-hide-dropzone>
            <span class="qq-upload-drop-area-text-selector"></span>
        </div>
        <div class="buttons">
            <div class="qq-upload-button-selector qq-upload-button">
                <center>Select Photo</center>
            </div>
        </div>

        <button type="button" id="trigger-uploadv2" class="btn btn-xs btn-primary" style="display: none;">
            <i class="icon-upload icon-white"></i> Upload
        </button>

        <span class="qq-drop-processing-selector qq-drop-processing">
                <span>Processing selected files...</span>
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

<script type="text/template" id="qq-incident-template-manual-trigger">
    <div class="qq-uploader-selector qq-uploader" qq-drop-area-text="Select Files">
        <div class="qq-total-progress-bar-container-selector qq-total-progress-bar-container">
            <div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" class="qq-total-progress-bar-selector qq-progress-bar qq-total-progress-bar"></div>
        </div>
        <div class="qq-upload-drop-area-selector qq-upload-drop-area" qq-hide-dropzone>
            <span class="qq-upload-drop-area-text-selector"></span>
        </div>
        <div class="buttons">
            <div class="qq-upload-button-selector qq-upload-button">
                <center>Select Photo</center>
            </div>
        </div>

        <button type="button" id="trigger-uploadv2" class="btn btn-xs btn-primary" style="display: none;">
            <i class="icon-upload icon-white"></i> Upload
        </button>

        <span class="qq-drop-processing-selector qq-drop-processing">
                <span>Processing selected files...</span>
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



<?php echo $__env->make('bank_dept.ci.template.includes.headerplugins', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<body class="hold-transition skin-red sidebar-mini">

    
    

<div class="se-pre-con"></div>

<div class="wrapper">

    
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
                        <div style="overflow:scroll; height: 40%">
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
    


    
    <div class="modal fade" id="modal-daily-expenses">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h5 class="modal-title">Daily Expenses Report</h5>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                          <h4 class="pull-left">Date Now: <span id="daily_date_expenses"></span></h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <center><h5>Finish Account:</h5></center>
                            <table id="table_exp_finish" class="tableendorse table-hover table-condensed" width="100%">
                                <thead>
                                <tr>
                                    <th>Request Type:</th>
                                    <th>Account Name:</th>
                                    <th>Address:</th>
                                </tr>
                                </thead>
                                <tbody id="table_exp_finish_body">
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <center><h5>Declaring of Expenses:</h5></center>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <small><label for="expense_label">Label:<small style = "color: red">*Required field</small></label></small>
                            <input type="text" id="expense_label" class="form-control" required="required">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <small><label for="expense_amount">Amount:</label></small>
                            <input type="number" id="expense_amount" class="form-control"  name="test_name[]" required="required">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <small><label for="expense_select_type">From:</label></small>
                            <select id="expense_select_type" class="form-control" required="required">
                                <option value="Fund">
                                   Requested Fund
                                </option>
                                <option value="Personal">
                                    Personal - For Reimbursement
                                </option>
                                <option value="Revolving">
                                    Revolving Fund
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <small><label for="expense_select_receipt">With O.R:</label></small>
                            <select id="expense_select_receipt" class="form-control" required="required">
                                <option value="Without">
                                    Without
                                </option>
                                <option value="With">
                                    With
                                </option>
                            </select>
                        </div>
                    </div>
                    <span id="row_attachment_receipt_span">

                    </span>
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <small><label for="ci_fund_exp_remarks">Remarks:</label></small>
                            <textarea id="ci_fund_exp_remarks" class="form-control" ></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            Total Expenses: <span id="total_expense_span"></span><br>
                            Total Reimbursements: <span id="total_Reimbursement_span"></span>
                        </div>
                        <div class="col-md-6">
                            <button type="button" id="btn_add_declare_exp" class="btn btn-success btn-sm pull-right">Add</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <center><h5>Declared Expenses:</h5></center>
                            <div style="overflow-x:auto;">
                                <table id="" class="tableendorse table-hover table-condensed" width="100%">
                                    <thead>
                                    <tr>
                                        <th>Label:</th>
                                        <th>Amount:</th>
                                        <th>From:</th>
                                        <th>With O.R:</th>
                                        <th>Remarks:</th>
                                        <th>Action:</th>
                                    </tr>
                                    </thead>
                                    <tbody id="table_exp_declared_body">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <span id="ulPercentage_bi_expenses" hidden></span>
                            <div id="progressbar_bi_expenses" hidden></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info btn-sm pull-left" data-dismiss="modal">Close</button>
                    <button type="button" id="btn_expenses_submit" class="btn btn-success btn-sm pull-right">Submit</button>
                </div>
            </div>
        </div>
    </div>
    


    
    <div class="modalsuggestion" id="modalsuggestion">
        <div class="modal fade" id="modal-default">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"></h4><small>Since the system is still on beta, expect the bugs and unnecessary things you may encounter during the process of the accounts. You can write your suggestion/concern and report here. Thank you!.</small>
                    </div>
                    <div class="modal-body">
                        <div class="box">
                            <div class="box-header">
                                <h3 class="box-title">
                                    <div class="form-group ">
                                        <label for="TitleSuggestion">Title:</label>
                                        <input type="text" class="form-control col-xs-12" id="TitleSuggestion" placeholder="Title here.">
                                    </div>
                                </h3>
                                <!-- tools box -->
                                <div class="pull-right box-tools">
                                    <button type="button" class="btn btn-default btn-sm" data-widget="collapse" data-toggle="tooltip"
                                            title="Collapse">
                                        <i class="fa fa-minus"></i></button>
                                    <button type="button" class="btn btn-default btn-sm" data-widget="remove" data-toggle="tooltip"
                                            title="Remove">
                                        <i class="fa fa-times"></i></button>
                                </div>
                                <!-- /. tools -->
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body pad">
                                <form>
                                             <textarea class="textarea" id="textareasuggestion" placeholder="Place your suggestions or reports here"
                                                       style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                                    <span id="textareaspan"></span>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="closesuggestion" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                        <button id="SuggestionSubmit" type="button" class="btn btn-primary">Submit</button>
                    </div>

                </div>
                <!-- /.modal-content -->
                <br>
                <div class="col-md-12">
                    <span id="getpolls">
                    </span>
                </div>
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->

    </div>

    <div class="modalsuggestionqqqq" id="modalsuggestionqqqqq">
        <div class="modal fade" id="modal-ci-direct">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h3 class="modal-title">Credit Investigator Directory</h3>
                    </div>
                    <div class="modal-body">

                        <div class="row">
                            <div class="col-md-10">
                                <div class="form-group">
                                    <label for="ciIDinfo">Please select credit investigator:</label>
                                    <select class="select2" style="width: 100%;" id="ciIDinfo"></select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <button id="ci_directory_btn_view" class="btn btn-sm btn-info btn-block" style="margin-top: 23.5px">view</button>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <span id="span_ci_directory_main"></span>
                                <span id="span_ci_directory_other"></span>
                                <br><center><button id="locationviewer" hidden class="btn-info">View Location</button></center>
                            </div>
                        </div>



                        <div class="modal-footer">
                            <button type="button" id="closesuggestion" class="btn btn-default pull-right" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->
        </div>
    </div>
    

    
    <div class="modal modal-default fade" id="modal-change-password">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Change Password</h4>
                </div>
                <div class="modal-body">
                    <label>Current Password:</label>
                    <input type="password" class="form-control" id="txtCurrentPass" required>
                    <label>New Password:</label>
                    <input type="password" class="form-control" id="txtNewPass" required>
                    <label>Repeat New Password:</label>
                    <input type="password" class="form-control" id="txtVerifyPass" required>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button type="button" id="btnNewPassword" class="btn btn-primary pull-right">Save Changes</button>
                </div>
            </div>
        </div>
    </div>

    

    <div class="modal modal-default fade" id="modal-acknowledge-view">
        <div class="modal-dialog" style="width: 80%">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="panel panel-danger">
                        <div class="panel-heading">
                            <h4 style="text-align : center">Acknowledgement</h4>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="box box-solid">
                                        <div class="box-header with-border">
                                        </div>
                                        <div class="box-body no-padding">
                                            <ul class="nav nav-pills nav-stacked" id="tbl_acnoo">
                                                <li id="acno_header"><a href="#" class="Acno_ref">Acknowledgement Announcements<i class="fa fa-refresh" style="float: right;"></i></a></li>
                                            </ul>
                                        </div>
                                        <div class="box-body no-padding">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <div class="box box-primary">
                                        <div class="box-header with-border">
                                            <h3 class="box-title">Acknowledgement Form</h3>
                                        </div>
                                        <div class="box-body">
                                            <div class="row" style="padding-top: 14px;">
                                                <div class="col-md-12">
                                                    
                                                    <table class="table-condensed centerContent" style = "overflow-x:auto; border-collapse:collapse; table-layout:fixed; width : 100%" id="acknowledge-Infomonit">
                                                        <tr>
                                                            <th colspan="4" style = "background-color: darkgrey; color : black; "><h4 style= "font-weight:bold; text-align: center">ACKNOWLEDGEMENT RECEIPT</h4>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2" style="font-weight:bold; padding-left: 100px"><span class = "toLeftTop">Name of employee :</span> </td>
                                                            <td colspan = "2"><input type="text" class = "form-control" id="ar_name_view" disabled></td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2" style="font-weight:bold; padding-left: 100px"><span class = "toLeftTop">Office Location-Department-Position :</span> </td>
                                                            <td colspan = "2"><input type="text" class = "form-control" id="ar_loc_dept_view" disabled></td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2" style="font-weight:bold; padding-left: 100px"><span class = "toLeftTop">Contact Number and Email Address :</span> </td>
                                                            <td colspan = "2"><input type="text" class = "form-control" id="ar_cont_email_view" disabled></td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2" style="font-weight:bold; padding-left: 100px"><span class = "toLeftTop">LBC Branch :</span> </td>
                                                            <td colspan = "2"><input type="text" class = "form-control" id="ar_lbc_branch_view" disabled></td>
                                                        </tr>
                                                    </table>


                                                    <table class="table-condensed centerContent" style = "overflow-x:auto; border-collapse:collapse; table-layout:fixed; width : 100%" id="acknowledge-lister" >
                                                        <tbody>
                                                        <tr name="0">
                                                            <th colspan="1" style = "background-color: darkgrey; color : black; font-weight:bold; padding-bottom: 15px; text-align: center"><span style = "padding-top : 10px;">Quantity</span>
                                                            <th colspan="1" style = "background-color: darkgrey; color : black; font-weight:bold; padding-bottom: 15px; text-align: center"><span style = "padding-top : 10px;">Brand - Item - Description</span>
                                                            <th colspan="1" style = "background-color: darkgrey; color : black; font-weight:bold; padding-bottom: 15px;text-align: center "> <span style = "padding-top : 10px;">Warranty Period</span>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                    <table class="table-condensed" style = "overflow-x:auto; border-collapse:collapse; table-layout:fixed; width : 100% ;">
                                                        <tr>
                                                            <th colspan = "5" style = "padding-left : 10px; padding-right : 10px;">
                                                                <br>
                                                                <h5 style = "font-style : italic; text-align: justify;">I hereby acknowledge that I have received the followeing company properly. I agree to keep the property in working condition, and to notify management  should properly malfunction in any way or should
                                                                    the property be lost or stolen. Further, I agree to return this property at the end of my employment. When I no longer need one or more of the items. I will return it/them to immediately to my supervisor</h5>
                                                                <h5 style = "font-style : italic; text-align: justify;">No employee is allowed to exchange and bargain all company issued equipment without the knowledge or approval of the management. furthermore, all issued equipment, email address, passwords and cell phone number
                                                                    must be available to the company at all times.</h5>
                                                                <h5 style = "font-style : italic; text-align: justify;">In case of damage/s or loss/es of the said item/s above, the receiver shall be held liable or accountable for the negligence that may occur. Thereof, the receiver immediate written
                                                                    notice to their supervisor/s.</h5>
                                                                <br>

                                                                <div class="row" style = " padding-top : 20px">
                                                                    <div class= "col-md-5">
                                                                        <span class="pull-right" style = "width: 210px; border-bottom-style :solid"></span>
                                                                    </div>
                                                                    <div class= "col-md-2"></div>
                                                                    <div class= "col-md-5">
                                                                        <span class="pull-left" style = "width: 205px; border-bottom-style :solid"></span>
                                                                    </div>
                                                                </div>
                                                                <div class="row" style = "">
                                                                    <div class="col-md-1"></div>
                                                                    <div class="col-md-5">
                                                                        <span class="pull-right" style = "width: 240px">Employee Signature</span>
                                                                    </div>
                                                                    <div class="col-md-5">
                                                                        <span class="pull-right" style = "width: 205px">Date Received</span>
                                                                    </div>
                                                                </div>
                                                            </th>
                                                        </tr>
                                                    </table>

                                                    <table class="table-condensed centerContent" style = "overflow-x:auto; border-collapse:collapse; table-layout:fixed; width : 100%; margin-top : 30px;" id= "acknowledge-checker">
                                                        <tr>
                                                            <th colspan="1" style = "background-color: darkgrey; color : black;font-size: larger ">For Administration Department - Attach and secure the following documents: </th>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="1" ><span class="toLeftTop2 pull-left"><input type="checkbox" class="Check_arView" name="0"> <b>Approved Requisition</b></span></td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="1" ><span class="toLeftTop2 pull-left"><input type="checkbox" class="Check_arView" name="1"> <b>Approved Supplier(Comparison and Recommendation)</b></span></td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="1" ><span class="toLeftTop2 pull-left"><input type="checkbox" class="Check_arView" name="2"> <b>Approved Purchase Order with Signed Proposal or Agreement</b> </span></td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="1" ><span class="toLeftTop2 pull-left"><input type="checkbox" class="Check_arView" name="3"> <b>Warranty Card or Receipts</b> </span></td>
                                                        </tr>
                                                    </table>

                                                    <table class="table-condensed hideThisTable" hidden style = "table-layout:fixed; width : 100%; margin-top : 20px;" id="Ar_btnTable">
                                                        <tr>
                                                            <td style="border: none ;">
                                                                <button class="btn btn-success pull-right" value="Acknowledge" id="btnArToAcknowledge">
                                                                    Acknowledge
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="overlay" hidden id="overlay_add_ar_send">
                                            <i class="fa fa-circle-o-notch fa-spin"></i>
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
            </div>
        </div>
    </div>

    
    <div class="modal modal-danger fade" id="modal-change-password-not-match">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Change Password</h4>
                </div>
                <div class="modal-body">
                    <center>New Password Not Match!</center>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    
    <div class="modal modal-danger fade" id="modal-change-password-empty">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Change Password</h4>
                </div>
                <div class="modal-body">
                    <center>Please Fill Up All Necessary Fields!</center>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    
    <div class="modal modal-warning fade" id="modal-update-location">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    
                        
                    <h4 class="modal-title">Updating your location</h4>
                </div>
                <div class="modal-body">
                    <center> <p id="update_text">Please wait.. <img width="10%" src="<?php echo e(asset('dist/img/loading.gif')); ?>"> </p></center>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-upload-selfie-daily" data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" style = "text-align: center">Attendance</h4>
                </div>
                <div class="modal-body">
                    <div class= "row">
                        <div class = "col-md-12">
                            <div id="attendance-fine"></div>
                            <div class = "box box-danger" hidden>
                                <div class = "row" style = "padding-top : 30px; padding-bottom : 10px;">
                                    <div class = "col-md-3"></div>
                                    <div class = "col-md-6">
                                        <label style = "padding-bottom : 10px;">Upload a photo:</label>
                                        <input type="file" id = "ci_selfie_daily">
                                    </div>
                                    <div class = "col-md-3">
                                    </div>
                                </div>
                                <div class = "row" style = "padding-top : 20px;">
                                    <div class = "col-md-3"></div>
                                    <div class = "col-md-6">
                                        <span id="ulPercentage_self">--</span>
                                        <div id="progressbar_self" hidden></div>
                                    </div>
                                    <div class = "col-md-3"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id = "submitPhotoAttendance">Submit</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <div class="modal modal-default fade" id="modal_ci_add_bi_note">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h5 class="modal-title">Add B.I Report</h5>
                </div>
                <div class="modal-body">
                    <div class="box">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="">Client Name<small style="color: red">(Required field)</small></label>
                                        <input type="text" id="insert_bi_name" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="">Subject Name<small style="color: red">(Required field)</small></label>
                                        <input type="text" id="insert_bi_subj_name" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="">Report Remarks<small style="color: red">(Required field)</small></label>
                                        <textarea class="form-control" id="insert_bi_note" rows="10" style="resize: none;" placeholder="..."></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div id="bi-rep-fine"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="overlay" hidden id="overlay_add_note_bi">
                            <i class="fa fa-refresh fa-spin"></i>
                        </div>
                    </div>


                </div>
                <div class="modal-footer">
                    <button class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button class="btn btn-success pull-right" id="add_bi_note_btn">Submit</button>
                </div>
            </div>
        </div>
    </div>



    <div class="modal modal-default fade" id="modal_ci_update_bi_note">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h5 class="modal-title">Update B.I Report</h5>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">Client Name<small style="color: red">(Required field)</small></label>
                                <input type="text" id="update_bi_name" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">Subject Name<small style="color: red">(Required field)</small></label>
                                <input type="text" id="update_bi_subj_name" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">Report Remarks<small style="color: red">(Required field)</small></label>
                                <textarea class="form-control" id="update_bi_note" rows="10" style="resize: none;" placeholder="..."></textarea>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <div id="bi-rep-fine-edit"></div>
                            </div>
                        </div>
                        <div class="row">
                                <div class="box-body">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <center><button  id="btnViews_uploadstoks" type="button" class="btn btn-info btnviews_ups" style="margin-bottom: 5px; margin-top: 5px; margin-left: 10px; margin-right: 10px">View Uploaded File</button></center>
                                        </div>
                                        <table class="table-condensed table-hover tableendorse bi_dl_logs" width="100%" id="bi-dl-table" hidden style="text-align: center">
                                            <thead>
                                            <tr class="head_and_shoulder">
                                                <th>Preview</th>
                                                <th>FileName</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <thead>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button class="btn btn-warning pull-right" id="update_bi_note_btn">Update</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal modal-default fade" id="modal_bi_note_logs">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h5 class="modal-title"><center>B.I Reports Logs</center></h5>
                </div>
                <div class="modal-body">
                                <span id="for_bi_logs_table">
                                </span>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal modal-default fade" id="modal_reimburse_request">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            Please Declare Your Reimbursement
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                <label for="">Amount:</label>
                                <input type="number" class="form-control reim_info" placeholder="0" min="0" what="amount">
                            </div>

                            <div class="form-group">
                                <label for="">Remarks/Reason:</label>
                                <textarea name="" id="" rows="4" class="form-control reim_info" style="resize: none;" placeholder="Indicate remarks/reason here ..." what="remarks"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button class="btn btn-success pull-right" id="reim_info_btn">Send Request</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal modal-default fade" id="modal-incident-report">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="panel panel-danger">
                        <div class="panel-heading">
                            <h4 style="text-align : center">Incident Damage/Stolen Report</h4>
                        </div>
                        <div class="panel-body">
                            <div class="row" style="padding-top : 20px;">
                                <div class="col-md-12">
                                    <label for="">Information:</label>
                                    <textarea class="form-control" id="incident_rep_rem"  rows="15" placeholder="Insert report here........"></textarea>
                                </div>
                            </div>
                            <div class="row" style="padding-top : 20px;">
                                <div class="col-md-12">
                                    <label for="">Attachments:</label>
                                </div>
                            </div>
                            <div id="incident-fine">
                            </div>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
                    <button type="button" id="btn_send_incident" class="btn btn-primary pull-right">Send Report</button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal modal-default fade" id="modal-memorandum-gen-ci">
        <div class="modal-dialog" style="width: 100%">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="panel panel-danger">
                        <div class="panel-heading">
                            <h4 style="text-align : center">Memorandum/Announcements</h4>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="box box-solid">
                                        <div class="box-header with-border">
                                            <h3 class="box-title">Monitoring</h3>

                                            <div class="box-tools">
                                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="box-body no-padding">
                                            <ul class="nav nav-pills nav-stacked">
                                                <li><a href="#" class="gen_memo_left_class" id="refreshGenIssuanceTabCI"><i class="fa fa-envelope-o"></i> Memorandum and Announcements</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <div id="showSentIssuanceGenCI" >
                                        <div class="box box-primary">
                                            <div class="box-header with-border">
                                                <h3 class="box-title">List of Memorandum/Announcement</h3>
                                                <!-- /.box-tools -->
                                            </div>
                                            <!-- /.box-header -->
                                            <div class="box-body">
                                                <div class="mailbox-controls">
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-default btn-md" id="btnRefreshTableIssuanceCI"><i class="fa fa-refresh"></i></button>
                                                    </div>
                                                    <!-- /.btn-group -->

                                                    <!-- /.pull-right -->
                                                </div>

                                                <div class="row" style="padding-top: 15px;">
                                                    <div class="col-md-12">
                                                        <table class="table-striped table-condensed" id="gen_sent_issuance_mail_ci"  width="100%">
                                                            <thead>
                                                            <tr>
                                                                <th>Date and Time Sent</th>
                                                                <th>Sender</th>
                                                                <th>Recepient</th>
                                                                <th>Subject</th>
                                                                <th>View</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            <tr>
                                                                <th>Date and Time Sent</th>
                                                                <th>Sender</th>
                                                                <th>Recepient</th>
                                                                <th>Subject</th>
                                                                <th>View</th>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>

                                            </div>
                                            <!-- /.box-body -->
                                        </div>
                                    </div>
                                    <div id="showMessageGenIssuanceCI" hidden>
                                        <div class="box box-primary">
                                            <div class="box-header with-border">
                                                <h3 class="box-title">Read Message</h3>
                                            </div>
                                            <div class="box-body no-padding">
                                                <div class="mailbox-read-info">
                                                    <h3 id="placeSubGenIssuanceCI">Message Subject Is Placed Here</h3>
                                                    <h5 >From: <span id="placeSenderGenIssuanceCI"></span></h5>

                                                </div>
                                                <div class="mailbox-read-message" id="placeMessageGenIssuanceCI">

                                                </div>
                                                <!-- /.mailbox-read-message -->
                                            </div>
                                            <!-- /.box-body -->
                                            <div class="box-footer">
                                                <ul class="mailbox-attachments clearfix" id="loopAllFilesPlaceIssuanceCI">

                                                </ul>
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
                </div>
            </div>
        </div>
    </div>




    
    <?php echo $__env->make('bank_dept.ci.template.includes.header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <?php echo $__env->yieldPushContent('leftsidebar'); ?>

    <?php echo $__env->yieldContent('content'); ?>

    <?php echo $__env->make('bank_dept.ci.template.includes.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->make('bank_dept.ci.template.includes.rightsidebar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

</div>
<?php echo $__env->make('bank_dept.ci.template.includes.footerplugins', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<script>
    $(window).load(function() {
        // Animate loader off screen
        $(".se-pre-con").fadeOut("slow");
    });
    $.fn.dataTable.ext.errMode = 'none';
</script>
<script src="<?php echo e(asset('jscript/general.js?n='.$javs)); ?>"></script>



<?php echo $__env->yieldPushContent('jscript'); ?>
</body>
</html>
