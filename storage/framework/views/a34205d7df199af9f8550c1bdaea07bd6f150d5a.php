<!DOCTYPE html>
<html>
<?php echo $__env->make('admin.template.includes.headerplugins', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<body class="hold-transition skin-blue sidebar-mini">



<div class="modal modal-default fade" id="modal-disable-web">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Maintenance</h4>
            </div>
            <div class="modal-body">
                <p><center>Are you sure you want to change status of OIMS?</center></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
                <button type="button" id="btnDisWeb" class="btn btn-primary pull-right" data-dismiss="modal">Activate Web App</button>
                <button type="button" id="btnEnaWeb" class="btn btn-primary pull-right" data-dismiss="modal">Deactivate Web App</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>



<div class="modal modal-default fade" id="modal-check-bday-contract">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Notification for Bday/Contract - Marketing</h4>
            </div>
            <div class="modal-body">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#marketing_notif_tab" data-toggle="tab">Send Notification</a></li>
                        <li><a href="#finance_notif_tab" data-toggle="tab">Reminders</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="marketing_notif_tab">
                            <span id="modal-check-bday-contract_text"><center>Press the button to check</center></span>
                            <div id="bday_notif_table_content">
                                <p><center>Client Birthday</center></p>
                                <table class="table-condensed" id="bday_notif_table" width="100%">

                                </table>
                            </div>
                            <br>
                            <div class="contract_notif_table_content">
                                <p><center>Client Contract</center></p>
                                <table class="table-condensed" id="contract_notif_table" width="100%">

                                </table>
                            </div>
                        </div>

                        <div class="tab-pane" id="finance_notif_tab">
                            <div class="panel panel-success">
                                <div class="panel-heading">Add, Viewing and Removing Reminders</div>
                                <div class="panel-body">
                                    <div class="col-md-5">
                                        <label for="">Reminder Name</label>
                                        <input type="text" class="form-control validateIn" id="reminder-name">
                                    </div>
                                    <div class="col-md-5">
                                        <label for="">Day every month to notif</label>
                                        <input type="number" class="form-control validateIn" id="reminder-day">
                                    </div>
                                    <div class="col-md-2">
                                        <button class="btn btn-success" title="Click to add reminder" style="margin-top: 20px;margin-right: 8px" id="add-reminder"><i class="glyphicon glyphicon-plus"></i></button>
                                    </div>
                                </div>
                                <div class="panel-heading">Reminder List/Table</div>
                                <div class="panel-body">
                                    <table class="table-condense table-hover tableendorse display" width="100%" id="admin-reminder-table">
                                        <thead>
                                            <tr>
                                                <th>Reminder Name</th>
                                                <th>Reminder Day of Month</th>
                                                <th>Date Added</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">close</button>
                <button type="button" id="btn_check_bday_comtract" class="btn btn-primary pull-right">Check</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal modal-default fade" id="modal-login-accessibility">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Login Accessibility</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="nav-tabs-custom">
                            <ul class="nav nav-tabs">
                                <li class="active">
                                    <a data-toggle="tab" href="#tab_ip" >IP Address Access</a>
                                </li>
                                <li class="">
                                    <a data-toggle="tab" href="#tab_user_access" >User Login Access</a>
                                </li>
                            </ul>
                            <div class = "tab-content">
                                <div class="tab-pane active" id="tab_ip">
                                    <div class="box-body">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <label>
                                                            IP Address:
                                                        </label>
                                                        <input type="text" class="form-control" placeholder="" id="admin_ip_address_accessibility">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <label>
                                                            Branch Name:
                                                        </label>
                                                        <input type="text" class="form-control" placeholder="" id="admin_branch_name_accessibility">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <label>
                                                            Accessibility:
                                                        </label>
                                                        <select class="form-control form-group" id="admin_select_accessibility">
                                                            <option value="grant">grant</option>
                                                            <option value="deny">deny</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <button type="button" id="admin_add_ip_address" class="btn btn-primary pull-right form-group">Add</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-10">
                                                <table id="ip_address_login_table_data" class="tableendorse table-hover table-condensed" width="100%">
                                                    <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>IP Address</th>
                                                        <th>Branch Name</th>
                                                        <th>Login Accessibility</th>
                                                        <th>Action</th>
                                                    </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="tab_user_access">
                                    <div class="box-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <table id="user_access_login_table_data" class="tableendorse table-hover table-condensed" width="100%">
                                                    <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Role</th>
                                                        <th>Login Accessibility</th>
                                                        <th>Action</th>
                                                    </tr>
                                                    </thead>
                                                </table>
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
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal modal-default fade" id="bi-change-view">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Change B.I View Access</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="box box-body">
                        <div class="col-md-12">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="selectBiNameSpan">Select B.I Client:</label>
                                    <span id="selectBiNameSpan"></span>
                                    <label for="selectSite">Select Site:</label>
                                    <span id="selectSiteSpan"></span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <button class="btn btn-success btn-sm form-control" style="margin-top: 50px;" id="addViewable_bi"><i class="glyphicon glyphicon-plus"></i></button>
                            </div>
                            <div class="col-md-12" style="margin-top: 15px;">
                                <table class="table-condensed table-hover" width="100%" id="bi_change_access_table">
                                    <thead>
                                    <tr>
                                        <td>Site Name</td>
                                        <td>Action</td>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <td>Site Name</td>
                                        <td>Action</td>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                
                    
                        
                        
                    
                    
                        
                        
                        
                            
                                
                                    
                                        
                                            
                                            
                                                
                                            
                                            
                                            
                                        
                                    
                                
                            
                        
                    
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">close</button>
            </div>
        </div>
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal modal-default fade" id="modal-access-control">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Access Control</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-body box-primary">
                            <div class="col-md-12">
                                <label for="">Legends:</label>
                                <div class="form-group">
                                    <div class="col-md-3">
                                        <center>
                                            BI
                                        </center>
                                    </div>
                                    <div class="col-md-3">
                                        <center>
                                            client_branch <br>
                                            cc_bank <br>
                                            tat_selector <br>
                                            all_access
                                        </center>
                                    </div>
                                    <div class="col-md-3">
                                        <center>
                                            View <br>
                                            Senior <br>
                                            sao_audit <br>
                                            Granted
                                        </center>
                                    </div>
                                    <div class="col-md-3">
                                        <center>
                                            TFS <br>
                                        </center>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-body box-danger">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <small>Note: <b style="color: red">client_type</b></small>
                                    <input type="text" class="form-control" id="client_type">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <small>Note: <b style="color: red">client_check</b></small>
                                    <input type="text" class="form-control" id="client_check">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <small>Note: <b style="color: red">authrequest</b></small>
                                    <input type="text" class="form-control" id="authrequest">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <small>Note: <b style="color: red">authrequest</b></small>
                                    <input type="text" class="form-control" id="login_check">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-default pull-left" data-dismiss="modal">close</button>
                <button type="button" class="btn btn-sm btn-success pull-right" id="submit_access_control">Submit</button>
            </div>
        </div>
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modal-attendance-general">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" style = "text-align: center">Attendance</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="nav-tabs-custom">
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#gen_att_tab1" data-toggle="tab" class="gen_att_tabs">Attendance</a></li>
                                <li><a href="#gen_att_tab2" data-toggle="tab" class="gen_att_tabs" loaded="false">Attendance Record</a></li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="gen_att_tab1">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <center>
                                                <h4>DATE TODAY: <b><?php echo e(\Carbon\Carbon::now('Asia/Manila')->toFormattedDateString()); ?></b></h4>
                                            </center>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="col-md-2">

                                                </div>
                                                <div class="col-md-8">
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <small class="pull-left"><b style="color:red">NOTE:</b> <br><b>*Please indicate your work schedule below and save it. (1 time only).<br>*Your Time in and Time out are auto generated upon clicking the button for time in and time out.</b></small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <label>Schedule/Shift start at:<small style="color: red">(Required Field)</small></label>

                                                            <div class="col-md-12">
                                                                <div class="col-md-4">
                                                                    <label for="">HOUR</label>
                                                                    <input type="number" class="form-control time_in_class_val" max="12" min="01" style="text-align: center;" name="0" placeholder="00">
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label for="">MINUTE</label>
                                                                    <input type="number" class="form-control time_in_class_val" max="59" min="00" style="text-align: center;" name="1" placeholder="00" value="00">
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label for="">AM/PM</label>
                                                                    <select id="" style="text-align: center;" class="form-control time_in_class_val" name="2">
                                                                        <option value="AM">AM</option>
                                                                        <option value="PM">PM</option>
                                                                    </select>
                                                                </div>
                                                                <input type="text" class="form-control" readonly id="attendance_work_start" style="display: none;">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <div class="row">
                                                            <label>Schedule/Shift ends at:<small style="color: red">(Required Field)</small></label>

                                                            <div class="col-md-12">
                                                                <div class="col-md-4">
                                                                    <label for="">HOUR</label>
                                                                    <input type="number" class="form-control time_out_class_val" max="12" min="01" style="text-align: center;" maxlength="2" name="0" placeholder="00">
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label for="">MINUTE</label>
                                                                    <input type="number" class="form-control time_out_class_val" max="59" min="00" style="text-align: center;" maxlength="2" name="1" placeholder="00" value="00">
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label for="">AM/PM</label>
                                                                    <select id="" style="text-align: center;" class="form-control time_out_class_val" name="2">
                                                                        <option value="PM">PM</option>
                                                                        <option value="AM">AM</option>
                                                                    </select>
                                                                </div>
                                                                <input type="text" class="form-control" readonly id="attendance_work_end" style="display: none;">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <button class="pull-right btn-sm btn btn-success" id="save_attendance_schedule">Save</button>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <table class="table-condensed table-hover general_attendance_logs" width="100%" style="margin-top: 15px;">
                                                <tr style="background-color: black; color:white;">
                                                    <th>DATE</th>
                                                    <th>TIME</th>
                                                    <th>LABEL</th>
                                                </tr>
                                                <tr>
                                                    <th>DATE</th>
                                                    <th>TIME</th>
                                                    <th>LABEL</th>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="gen_att_tab2">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label for="">Please select date to see your previous records: <small style="color: red">(Required Filed)</small></label>
                                            <div class="input-group margin">
                                                <input type="date" class="form-control" id="attendance_log_all_input">
                                                <span class="input-group-btn">
                                                        <button class="btn btn-success btn-flat" id="refresh_atten_logs">View</button>
                                                    </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <table class="table-condensed table-hover general_attendance_logs_all" width="100%" style="margin-top: 15px;">
                                                <tr style="background-color: black; color:white;">
                                                    <th>DATE</th>
                                                    <th>TIME</th>
                                                    <th>LABEL</th>
                                                </tr>
                                                <tr>
                                                    <th>DATE</th>
                                                    <th>TIME</th>
                                                    <th>LABEL</th>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-default pull-left btn-sm" data-dismiss="modal">Close</button>
                <button what="BREAKTIME-OUT" class="btn btn-danger pull-right btn-sm attendance_all_click">Breaktime-OUT</button>
                <button what="BREAKTIME-IN" class="btn btn-success pull-right btn-sm attendance_all_click">Breaktime-IN</button>
                <button what="TIME-OUT" class="btn btn-danger pull-right btn-sm attendance_all_click">Time-OUT</button>
                <button what="TIME-IN" class="btn btn-success pull-right btn-sm attendance_all_click" >Time-IN</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>




<div class="wrapper">
    <?php echo $__env->make('modal.compilation-modal', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <?php echo $__env->make('admin.template.includes.header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->make('admin.template.includes.leftsidebar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <?php echo $__env->yieldContent('content'); ?>

    <?php echo $__env->make('admin.template.includes.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->make('admin.template.includes.rightsidebar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

</div>
<?php echo $__env->make('admin.template.includes.footerplugins', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php echo $__env->yieldPushContent('jscript'); ?>
</body>
</html>
