<?php $__env->startSection('content'); ?>

    <div class="content-wrapper">

    </div>

    <div class="modal fade" id="modal-emp-profile-view">
        <div class="modal-dialog" style = "width: 80%;">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <center>
                        <h5 class="modal-title"><b>Employee Profile</b></h5>
                    </center>
                </div>
                <div class="modal-body">
                    <div class = "box-body">
                        <div class="row">
                            <div class="col-md-4">
                            </div>
                            <div class="col-md-4">
                                <div class="box box-info">
                                    <center>
                                        <img id = "emp_show_pic_me" style="padding: 10px" class="img-circle" src = "<?php echo e(asset('user_profile_pictures/default3.jpg')); ?>"/>
                                        <p id = "nameStorage"></p>
                                        <p id = "positionStorage"></p>
                                    </center>
                                </div>
                            </div>
                            <div class="col-md-4">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="box box-info">
                                    <div class="nav-tabs-custom" style = "padding-top: 20px;">
                                            <ul class="nav nav-tabs">
                                                <li class="active" id = "tabDetails"><a id="tab1" href="#tab_View1" data-toggle="tab" class = "human_resources_emp_details_class">Employee Details</a></li>
                                                <li id = "tabSched"><a id="tab2" href="#tab_View2" data-toggle="tab" class = "human_resources_emp_details_class">Specific Time Schedule</a></li>
                                                <li id = "tabChecklist"><a id="tab3" href="#tab_View3" data-toggle="tab" class = "human_resources_emp_details_class">Requirements Checklist</a></li>
                                                <li id = "tabGenEq"><a id="tab3" href="#tab_View4" data-toggle="tab" class = "human_resources_emp_details_class">Employee Necessity</a></li>

                                            </ul>
                                            <div class = "tab-content">
                                                <div class="tab-pane active" id="tab_View1">
                                                    <div class = "row" style = "padding-top : 20px;">
                                                        <div class = "col-md-4">
                                                            <label for="emp_show_branch">Branch:</label>
                                                            <input type="text" id = "emp_show_branch" class = "form-control"  disabled>
                                                        </div>
                                                        <div class = "col-md-4">
                                                            <label for="emp_show_salary">Salary Offer:</label>
                                                            <input type="text" id = "emp_show_salary" class = "form-control" disabled>
                                                        </div>
                                                        <div class = "col-md-4">
                                                            <label for="emp_show_age">Age:</label>
                                                            <input type="text" id = "emp_show_age" class = "form-control" disabled>
                                                        </div>
                                                    </div>
                                                    <div class = "row" style = "padding-top: 20px;">
                                                        <div class = "col-md-4">
                                                            <label for="emp_show_date_birth">Date of Birth:</label>
                                                            <input type="date" id = "emp_show_date_birth" class = "form-control" disabled>
                                                        </div>
                                                        <div class = "col-md-4">
                                                            <label for="emp_show_religion">Religion:</label>
                                                            <input type="text" id = "emp_show_religion" class = "form-control" disabled>
                                                        </div>
                                                        <div class = "col-md-4">
                                                            <label for="emp_show_marital_status">Marital Status:</label>
                                                            <input type="text" id = "emp_show_marital_status" class = "form-control" disabled>
                                                        </div>
                                                    </div>
                                                    <div class = "row" style = "padding-top: 20px;">
                                                        <div class = "col-md-4">
                                                            <label for="emp_show_dependents">No. of Dependents</label>
                                                            <input type="text" id = "emp_show_dependents" class = "form-control" disabled>
                                                        </div>
                                                        <div class = "col-md-4">
                                                            <label for="emp_show_mobile">Primary Contact no.: </label>
                                                            <input type="text" id = "emp_show_mobile" class = "form-control" disabled>
                                                        </div>
                                                        <div class = "col-md-4">
                                                            <label for="emp_show_email">Primary Email Address.:</label>
                                                            <input type="text" id = "emp_show_email" class = "form-control" disabled>
                                                        </div>
                                                    </div>
                                                    <div class = "row" style = "padding-top: 20px;">
                                                        <div class = "col-md-4">
                                                            <label for="">Contract Status:</label>
                                                            <input type="text" id = "emp_show_con_stat" class = "form-control" disabled>
                                                        </div>
                                                        <div class = "col-md-4">
                                                            <label for="">Employment Status:</label>
                                                            <input type="text" id = "emp_show_emp_status" class = "form-control" disabled>
                                                        </div>
                                                        <div class = "col-md-4">
                                                            <label for="">Off-Board Status: <small style = "color: red;">*if applicable</small></label>
                                                            <input type="text" id = "emp_show_outgoing" class = "form-control" disabled>
                                                        </div>
                                                    </div>
                                                    <div class = "row" style = "padding-top: 20px;">
                                                        <div class = "col-md-4">
                                                            <label for="">Type of Rate:</label>
                                                            <input type="text" id = "emp_show_rate" class = "form-control" disabled>
                                                        </div>
                                                        <div class = "col-md-4">
                                                            <label for="">Mandated No. of Working Days:</label>
                                                            <input type="text" id = "emp_show_days" class = "form-control" disabled>
                                                        </div>
                                                        <div class = "col-md-4">
                                                            <label for="">Remaining Days of Contract:</label>
                                                            <input type="text" id = "emp_show_remaining" class = "form-control" disabled>
                                                        </div>
                                                    </div>
                                                    <div class = "row" style = "padding-top: 20px;">
                                                        <div class="col-md-4">
                                                            <label for="">Allowances:</label>
                                                            <input type="text" class = "form-control" id = "emp_show_allowances" disabled>
                                                        </div>
                                                        <div class = "col-md-8">
                                                            <label for="">Fixed Time Schedule:</label>
                                                            <input type="text" class = "form-control" id = "emp_show_fixed" disabled>
                                                        </div>
                                                    </div>
                                                    <div class = "row" style = "padding-top: 20px;">
                                                        <div class="col-md-12">
                                                            <label>Permanent Address:</label>
                                                            <label for="emp_show_permanent"></label><textarea class="form-control" rows = "1" id="emp_show_permanent"  disabled></textarea>
                                                        </div>
                                                    </div>
                                                    <div class = "row" style = "padding-top: 20px;">
                                                        <div class="col-md-12">
                                                            <label>Present Address:</label>
                                                            <label for="emp_show_present"></label><textarea class="form-control" rows = "1" id="emp_show_present" disabled></textarea>
                                                        </div>
                                                    </div>
                                                    <div class = "row" style = "padding-top: 20px;" id = "ciShow">
                                                        <div class = "col-md-6">
                                                            <label for="emp_show_area">Point of Origin : </label>
                                                            <input type="text" id = "emp_show_area" class = "form-control" value = "" disabled>
                                                        </div>
                                                        <div class = "col-md-6">
                                                            <label for="emp_show_philhealth">Motor CC type:</label>
                                                            <input type="text" id = "emp_show_cc" class = "form-control" value = "" disabled>
                                                        </div>
                                                    </div>
                                                    <div class = "row" style = "padding-top: 20px;">
                                                        <div class = "col-md-6">
                                                            <label for="emp_show_ss">SSS no. : </label>
                                                            <input type="text" id = "emp_show_ss" class = "form-control" value = "" disabled>
                                                        </div>
                                                        <div class = "col-md-6">
                                                            <label for="emp_show_philhealth">Philhealth no. :</label>
                                                            <input type="text" id = "emp_show_philhealth" class = "form-control" value = "" disabled>
                                                        </div>
                                                    </div>
                                                    <div class = "row" style = "padding-top: 20px;">
                                                        <div class = "col-md-6">
                                                            <label for="emp_show_pagibig">Pagibig no. :</label>
                                                            <input type="text" id = "emp_show_pagibig" class = "form-control" value = "" disabled>
                                                        </div>
                                                        <div class = "col-md-6">
                                                            <label for="emp_show_tin">TIN no.:</label>
                                                            <input type="text" id = "emp_show_tin" class = "form-control " value = "" disabled>
                                                        </div>
                                                    </div>
                                                    <div class = "row" style="padding-top: 20px; padding-bottom : 20px;">
                                                        <div class = "col-md-3"></div>
                                                        <div class = "col-md-6">
                                                            <button type = "submit" class="btn btn-info btn-block" id = "btnDownloadEmp"><i class = "fa fa-fw fa-arrow-down" ></i>Download Employee File</button>
                                                        </div>
                                                        <div class = "col-md-3"></div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane" id="tab_View2">
                                                    <div class = "row">
                                                        <div class = "col-md-12">
                                                            <div class = "box box-danger">
                                                                <div class = "row" style = "padding-top : 20px;">
                                                                    <div class = "col-md-5">
                                                                        <input type="text" class = "form-control"  value = "Monday" disabled>
                                                                    </div>
                                                                    <div class = "col-md-3">
                                                                        <input type = "time" id = "view_in1" class = "form-control" disabled>
                                                                    </div>
                                                                    <div class = "col-md-1">
                                                                        <h5>to</h5>
                                                                    </div>
                                                                    <div class = "col-md-3">
                                                                        <input type = "time" id = "view_out1" class = "form-control" disabled>
                                                                    </div>
                                                                </div>
                                                                <div class = "row" style = "padding-top : 5px;">
                                                                    <div class = "col-md-5">
                                                                        <input type="text" class = "form-control"  value = "Tuesday" disabled>
                                                                    </div>
                                                                    <div class = "col-md-3">
                                                                        <input type = "time" id = "view_in2" class = "form-control" disabled>
                                                                    </div>
                                                                    <div class = "col-md-1">
                                                                        <h5>to</h5>
                                                                    </div>
                                                                    <div class = "col-md-3">
                                                                        <input type = "time" id = "view_out2" class = "form-control" disabled>
                                                                    </div>
                                                                </div>
                                                                <div class = "row" style = "padding-top : 5px;">
                                                                    <div class = "col-md-5">
                                                                        <input type="text" class = "form-control" value = "Wednesday" disabled>
                                                                    </div>
                                                                    <div class = "col-md-3">
                                                                        <input type = "time" id = "view_in3" class = "form-control" disabled>
                                                                    </div>
                                                                    <div class = "col-md-1">
                                                                        <h5>to</h5>
                                                                    </div>
                                                                    <div class = "col-md-3">
                                                                        <input type = "time" id = "view_out3" class = "form-control"disabled>
                                                                    </div>
                                                                </div>
                                                                <div class = "row" style = "padding-top : 5px;">
                                                                    <div class = "col-md-5">
                                                                        <input type="text" class = "form-control"  value = "Thursday" disabled>
                                                                    </div>
                                                                    <div class = "col-md-3">
                                                                        <input type = "time" id = "view_in4" class = "form-control" disabled>
                                                                    </div>
                                                                    <div class = "col-md-1">
                                                                        <h5>to</h5>
                                                                    </div>
                                                                    <div class = "col-md-3">
                                                                        <input type = "time" id = "view_out4" class = "form-control" disabled>
                                                                    </div>
                                                                </div>
                                                                <div class = "row" style = "padding-top : 5px;">
                                                                    <div class = "col-md-5">
                                                                        <input type="text" class = "form-control" value = "Friday" disabled>
                                                                    </div>
                                                                    <div class = "col-md-3">
                                                                        <input type = "time" id = "view_in5" class = "form-control" disabled >
                                                                    </div>
                                                                    <div class = "col-md-1">
                                                                        <h5>to</h5>
                                                                    </div>
                                                                    <div class = "col-md-3">
                                                                        <input type = "time" id = "view_out5" class = "form-control" disabled>
                                                                    </div>
                                                                </div>
                                                                <div class = "row" style = "padding-top : 5px;">
                                                                    <div class = "col-md-5">
                                                                        <input type="text" class = "form-control" value = "Saturday" disabled>
                                                                    </div>
                                                                    <div class = "col-md-3">
                                                                        <input type = "time" id = "view_in6" class = "form-control" disabled>
                                                                    </div>
                                                                    <div class = "col-md-1">
                                                                        <h5>to</h5>
                                                                    </div>
                                                                    <div class = "col-md-3">
                                                                        <input type = "time" id = "view_out6" class = "form-control" disabled>
                                                                    </div>
                                                                </div>
                                                                <div class = "row" style = "padding-top : 5px;">
                                                                    <div class = "col-md-5">
                                                                        <input type="text" class = "form-control" value = "Sunday" disabled>
                                                                    </div>
                                                                    <div class = "col-md-3">
                                                                        <input type = "time" id = "view_in7" class = "form-control" disabled>
                                                                    </div>
                                                                    <div class = "col-md-1">
                                                                        <h5>to</h5>
                                                                    </div>
                                                                    <div class = "col-md-3">
                                                                        <input type = "time" id = "view_out7" class = "form-control" disabled>
                                                                    </div>
                                                                </div>
                                                                <div class = "row" style = "padding-top: 20px;">
                                                                    <div class = "col-md-12">
                                                                        <label for="">Remarks:</label>
                                                                        <textarea id="view_sched_remarks" rows="5" class = "form-control" disabled></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane" id="tab_View3">
                                                    <div class = "row" style = "padding-top: 20px;">
                                                        <div class = "col-md-1"></div>
                                                        <div class = "col-md-10">
                                                            <div class = "box box-danger">
                                                                <center><h4 style = "font-family: Georgia,serif;">Pre-employment Requirements</h4></center>
                                                                <div class = "row" style = "padding-top : 30px;">
                                                                    <div class = "col-md-1"></div>
                                                                    <div class = "col-md-5">
                                                                        <input type="checkbox"  class = "view_checklist icheckbox_minimal-blue" value = "SSS" disabled><b>SSS</b>
                                                                    </div>
                                                                    <div class = "col-md-1"></div>
                                                                    <div class = "col-md-5">
                                                                        <input type="checkbox"  class = "view_checklist icheckbox_minimal-blue" value = "X-RAY" disabled><b>X-RAY</b>
                                                                    </div>
                                                                </div>
                                                                <div class = "row" style = "padding-top : 20px;">
                                                                    <div class = "col-md-1"></div>
                                                                    <div class = "col-md-5">
                                                                        <input type="checkbox" class = "view_checklist icheckbox_minimal-blue" value = "PHILHEALTH" disabled><b>PHILHEALTH</b>
                                                                    </div>
                                                                    <div class = "col-md-1"></div>
                                                                    <div class = "col-md-5">
                                                                        <input type="checkbox" class = "view_checklist icheckbox_minimal-blue" value = "NBI CLEARANCE" disabled><b>NBI CLEARANCE</b>
                                                                    </div>
                                                                </div>
                                                                <div class = "row" style = "padding-top : 20px;">
                                                                    <div class = "col-md-1"></div>
                                                                    <div class = "col-md-5">
                                                                        <input type="checkbox" class = "view_checklist icheckbox_minimal-blue" value = "PAGIBIG" disabled><b>PAGIBIG</b>
                                                                    </div>
                                                                    <div class = "col-md-1"></div>
                                                                    <div class = "col-md-5">
                                                                        <input type="checkbox" class = "view_checklist icheckbox_minimal-blue" value = "MAYOR'S PERMIT" disabled><b>MAYOR'S PERMIT</b>
                                                                    </div>
                                                                </div>
                                                                <div class = "row" style = "padding-top : 20px;">
                                                                    <div class = "col-md-1"></div>
                                                                    <div class = "col-md-5">
                                                                        <input type="checkbox" class = "view_checklist icheckbox_minimal-blue" value = "TIN" disabled><b>TIN</b>
                                                                    </div>
                                                                    <div class = "col-md-1"></div>
                                                                    <div class = "col-md-5">
                                                                        <input type="checkbox" class = "view_checklist icheckbox_minimal-blue" value = "POLICE CLEARANCE" disabled><b>POLICE CLEARANCE</b>
                                                                    </div>
                                                                </div>
                                                                <div class = "row" style = "padding-top : 20px;">
                                                                    <div class = "col-md-1"></div>
                                                                    <div class = "col-md-5">
                                                                        <input type="checkbox" class = "view_checklist icheckbox_minimal-blue" value = "MEDICAL HISTORY" disabled><b>MEDICAL HISTORY</b>
                                                                    </div>
                                                                    <div class = "col-md-1"></div>
                                                                    <div class = "col-md-5">
                                                                        <input type="checkbox" class = "view_checklist icheckbox_minimal-blue" value = "BRGY CLEARANCE" disabled><b>BRGY CLEARANCE</b>
                                                                    </div>
                                                                </div>
                                                                <div class = "row" style = "padding-top : 20px;">
                                                                    <div class = "col-md-1"></div>
                                                                    <div class = "col-md-5">
                                                                        <input type="checkbox" class = "view_checklist icheckbox_minimal-blue" value = "DRUG TEST" disabled> <b>DRUG TEST</b>
                                                                    </div>
                                                                    <div class = "col-md-1"></div>
                                                                    <div class = "col-md-5">
                                                                        <input type="checkbox" class = "view_checklist icheckbox_minimal-blue" value = "VOTER'S ID(OPTIONAL)" disabled><b>VOTER'S ID(OPTIONAL)</b>
                                                                    </div>
                                                                </div>
                                                                <div class = "row" style = "padding-top : 20px;">
                                                                    <div class = "col-md-1"></div>
                                                                    <div class = "col-md-5">
                                                                        <input type="checkbox" class = "view_checklist icheckbox_minimal-blue" value = "STOOL" disabled><b>STOOL</b>
                                                                    </div>
                                                                    <div class = "col-md-1"></div>
                                                                    <div class = "col-md-5">
                                                                        <input type="checkbox" class = "view_checklist icheckbox_minimal-blue" value = "PREGNANCY TEST(IF FEMALE)" disabled><b>PREGNANCY TEST(IF FEMALE)</b>
                                                                    </div>
                                                                </div>
                                                                <div class = "row" style = "padding-top : 20px; padding-bottom : 10px;">
                                                                    <div class = "col-md-1"></div>
                                                                    <div class = "col-md-5">
                                                                        <input type="checkbox" class = "view_checklist icheckbox_minimal-blue" value = "URINALYSIS" disabled><b>URINALYSIS</b>
                                                                    </div>
                                                                    <div class = "col-md-1"></div>
                                                                    <div class = "col-md-5">
                                                                        <div id = "ciMotorReqView">
                                                                            <input type="checkbox" class = "view_checklist icheckbox_minimal-blue" value = "MOTOR DETAILS" disabled><b>MOTOR DETAILS</b>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class = "col-md-1"></div>
                                                    </div>
                                                    <div class = "row">
                                                        <div class = "col-md-1"></div>
                                                        <div class = "col-md-10">
                                                            <div class = "box box-danger">
                                                                <center><h4 style = "font-family: Georgia,serif;">Pre-employment CCSI Docs</h4></center>
                                                                <div class = "row" style = "padding-top : 30px;">
                                                                    <div class = "col-md-1"></div>
                                                                    <div class = "col-md-5">
                                                                        <input type="checkbox" class = "view_checklist icheckbox_minimal-blue" value = "RESUME" disabled><b>RESUME</b>
                                                                    </div>
                                                                    <div class = "col-md-1"></div>
                                                                    <div class = "col-md-5">
                                                                        <input type="checkbox" class = "view_checklist icheckbox_minimal-blue" value = "CMAP RESULT" disabled><b>CMAP RESULT</b>
                                                                    </div>
                                                                </div>
                                                                <div class = "row" style = "padding-top : 20px;">
                                                                    <div class = "col-md-1"></div>
                                                                    <div class = "col-md-5">
                                                                        <input type="checkbox" class = "view_checklist icheckbox_minimal-blue" value = "APPLICATION FORM" disabled><b>APPLICATION FORM</b>
                                                                    </div>
                                                                    <div class = "col-md-1"></div>
                                                                    <div class = "col-md-5">
                                                                        <input type="checkbox" class = "view_checklist icheckbox_minimal-blue" value = "EVALUATION EXAM" disabled><b>EVALUATION EXAM</b>
                                                                    </div>
                                                                </div>
                                                                <div class = "row" style = "padding-top : 20px;">
                                                                    <div class = "col-md-1"></div>
                                                                    <div class = "col-md-5">
                                                                        <input type="checkbox" class = "view_checklist icheckbox_minimal-blue" value = "PRE-EMPLOYMENT EXAM" disabled><b>PRE-EMPLOYMENT EXAM</b>
                                                                    </div>
                                                                    <div class = "col-md-1"></div>
                                                                    <div class = "col-md-5">
                                                                        <input type="checkbox" class = "view_checklist icheckbox_minimal-blue" value = "EVALUATION" disabled><b>EVALUATION</b>
                                                                    </div>
                                                                </div>
                                                                <div class = "row" style = "padding-top : 20px;">
                                                                    <div class = "col-md-1"></div>
                                                                    <div class = "col-md-5">
                                                                        <input type="checkbox" class = "view_checklist icheckbox_minimal-blue" value = "TRAINING AGREEMENT" disabled><b>TRAINING AGREEMENT</b>
                                                                    </div>
                                                                    <div class = "col-md-1"></div>
                                                                    <div class = "col-md-5">
                                                                        <input type="checkbox" class = "view_checklist icheckbox_minimal-blue" value = "HANDBOOK AND DPA" disabled><b>HANDBOOK AND DPA</b>
                                                                    </div>
                                                                </div>
                                                                <div class = "row" style = "padding-top : 20px;">
                                                                    <div class = "col-md-1"></div>
                                                                    <div class = "col-md-5">
                                                                        <input type="checkbox" class = "view_checklist icheckbox_minimal-blue" value = "HR HEAD REQUEST" disabled><b>HR HEAD REQUEST</b>
                                                                    </div>
                                                                    <div class = "col-md-6"></div>
                                                                </div>
                                                                <div class = "row" style = "padding-top : 20px;">
                                                                    <div class = "col-md-1"></div>
                                                                    <div class = "col-md-5">
                                                                        <input type="checkbox" class = "view_checklist icheckbox_minimal-blue" value = "BGC REPORT" disabled><b>BGC REPORT</b>
                                                                    </div>
                                                                    <div class = "col-md-6"></div>
                                                                </div>
                                                                <div class = "row" style = "padding-top : 20px;">
                                                                    <div class = "col-md-1"></div>
                                                                    <div class = "col-md-5">
                                                                        <input type="checkbox" class = "view_checklist icheckbox_minimal-blue" value = "PDRN RESIDENTIAL CHECKING" disabled><b>PDRN RESIDENTIAL CHECKING</b>
                                                                    </div>
                                                                    <div class = "col-md-6"></div>
                                                                </div>
                                                                <div class = "row" style = "padding-top : 20px; padding-bottom : 10px;">
                                                                    <div class = "col-md-1"></div>
                                                                    <div class = "col-md-5">
                                                                        <input type="checkbox" class = "view_checklist icheckbox_minimal-blue" value = "SSS RESULT" disabled><b>SSS RESULT</b>
                                                                    </div>
                                                                    <div class = "col-md-6"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class = "col-md-1"></div>
                                                    </div>
                                                    <div class = "row">
                                                        <div class = "col-md-1"></div>
                                                        <div class = "col-md-10">
                                                            <div class = "box box-danger">
                                                                <center><h4 style = "font-family: Georgia,serif;">Accountabilities/Equipments</h4></center>
                                                                <div class = "row" style = "padding-top : 30px; padding-bottom : 10px;">
                                                                    <div class = "col-md-1"></div>
                                                                    <div class = "col-md-5">
                                                                        <div class = "row" style = "padding-top: 20px;">
                                                                            <div class = "col-md-12">
                                                                                <input type="checkbox" class = "view_checklist icheckbox_minimal-blue" value = "ATM" disabled><b>ATM</b>
                                                                            </div>
                                                                        </div>
                                                                        <div class = "row" style = "padding-top: 20px;">
                                                                            <div class = "col-md-12">
                                                                                <input type="checkbox" class = "view_checklist icheckbox_minimal-blue" value = "ID" disabled><b>ID</b>
                                                                            </div>
                                                                        </div>
                                                                        <div class = "row" style = "padding-top: 20px;">
                                                                            <div class = "col-md-12">
                                                                                <input type="checkbox" class = "view_checklist icheckbox_minimal-blue" value = "GMAIL & PASSWORD/CCSI EMAIL" disabled><b>GMAIL & PASSWORD/CCSI EMAIL</b>
                                                                            </div>
                                                                        </div>
                                                                        <div class = "row" style = "padding-top: 20px;">
                                                                            <div class = "col-md-12">
                                                                                <input type="checkbox" class = "view_checklist icheckbox_minimal-blue" value = "PHONE/IP PHONE" disabled><b>PHONE/IP PHONE</b>
                                                                            </div>
                                                                        </div>
                                                                        <div class = "row" style = "padding-top: 20px;">
                                                                            <div class = "col-md-12">
                                                                                <input type="checkbox" class = "view_checklist icheckbox_minimal-blue" value = "NUMBER" disabled><b>NUMBER</b>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class = "col-md-1"></div>
                                                                    <div class = "col-md-5">
                                                                        <div id = "officeChecklistView">
                                                                            <div class = "row" style = "padding-top: 20px;">
                                                                                <div class = "col-md-12">
                                                                                    <input type="checkbox" class = "view_checklist icheckbox_minimal-blue" value = "COMPUTER" disabled><b>COMPUTER</b>
                                                                                </div>
                                                                            </div>
                                                                            <div class = "row" style = "padding-top: 20px;">
                                                                                <div class = "col-md-12">
                                                                                    <input type="checkbox" class = "view_checklist icheckbox_minimal-blue" value = "FB(IF NEEDED)" disabled><b>FB(IF NEEDED)</b>
                                                                                </div>
                                                                            </div>
                                                                            <div class = "row" style = "padding-top: 20px;">
                                                                                <div class = "col-md-12">
                                                                                    <input type="checkbox" class = "view_checklist icheckbox_minimal-blue" value = "BIOMETRICS" disabled><b>BIOMETRICS</b>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div id = "ciChecklistView">
                                                                            <div class = "row" style = "padding-top: 20px;">
                                                                                <div class = "col-md-12">
                                                                                    <input type="checkbox" class = "view_checklist icheckbox_minimal-blue" value = "INSURANCE" disabled><b>INSURANCE</b>
                                                                                </div>
                                                                            </div>
                                                                            <div class = "row" style = "padding-top: 20px;">
                                                                                <div class = "col-md-12">
                                                                                    <input type="checkbox" class = "view_checklist icheckbox_minimal-blue" value = "SHELLCARD" disabled><b>SHELLCARD</b>
                                                                                </div>
                                                                            </div>
                                                                            <div class = "row" style = "padding-top: 20px;">
                                                                                <div class = "col-md-12">
                                                                                    <input type="checkbox" class = "view_checklist icheckbox_minimal-blue" value = "UNIFORM" disabled><b>UNIFORM</b>
                                                                                </div>
                                                                            </div>
                                                                            <div class = "row" style = "padding-top: 20px;">
                                                                                <div class = "col-md-12">
                                                                                    <input type="checkbox" class = "view_checklist icheckbox_minimal-blue" value = "AUTHORIZATION" disabled><b>AUTHORIZATION</b>
                                                                                </div>
                                                                            </div>
                                                                            <div class = "row" style = "padding-top: 20px;">
                                                                                <div class = "col-md-12">
                                                                                    <input type="checkbox" class = "view_checklist icheckbox_minimal-blue" value = "INTRODUCTION LETTER" disabled><b>INTRODUCTION LETTER</b>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class = "col-md-1"></div>
                                                    </div>
                                                </div>

                                                <div class="tab-pane" id="tab_View4">
                                                    <div class = "row" style = "padding-top: 10px;">
                                                        <div class = "col-md-12">
                                                            <div class = "box box-danger">
                                                                <h4 style = "text-align: center; font-weight: bold; font-family: Georgia,serif; padding-top: 15px;">ID, Uniform , Insurance and ATM</h4>
                                                                <div class = "row" style = "padding-top : 20px;">
                                                                    <div class = "col-md-5">
                                                                        <h5 style = "font-weight: bold ; ">ID Status:</h5>
                                                                        <h5 id = "emp_id_stat_view"></h5>
                                                                    </div>
                                                                    <div class = "col-md-2"></div>
                                                                    <div class = "col-md-5">
                                                                        <h5 style = "font-weight: bold">ID No. : </h5>
                                                                        <h5 id = "emp_id_no_view"></h5>
                                                                    </div>
                                                                </div>
                                                                <div class = "row">
                                                                    <div class = "col-md-5">
                                                                        <h5 style = "font-weight: bold">Uniform: </h5>
                                                                        <h5 id = "emp_uni_view"></h5>
                                                                    </div>
                                                                    <div class = "col-md-2"></div>
                                                                    <div class = "col-md-5">
                                                                        <h5 style = "font-weight: bold">Bank Name:</h5>
                                                                        <h5 id  = "emp_bank_name_view"></h5>
                                                                    </div>
                                                                </div>
                                                                <div class = "row">
                                                                    <div class = "col-md-5">
                                                                        <h5 style = "font-weight: bold">FB/Messenger: </h5>
                                                                        <h5 id = "emp_fb_view"></h5>
                                                                    </div>
                                                                    <div class = "col-md-2"></div>
                                                                    <div class = "col-md-5">
                                                                        <h5 style = "font-weight: bold">Computer:</h5>
                                                                        <h5 id = "emp_computer_view"></h5>
                                                                    </div>
                                                                </div>
                                                                <div class = "row">
                                                                    <div class = "col-md-5">
                                                                        <h5 style = "font-weight: bold">Health Card Info: </h5>
                                                                        <h5 id = "emp_health_card_view"></h5>
                                                                    </div>
                                                                    <div class = "col-md-2"></div>
                                                                    <div class = "col-md-5">
                                                                        <h5 style = "font-weight: bold">Accident Insurance:</h5>
                                                                        <h5 id = "emp_accident_view"></h5>
                                                                    </div>
                                                                </div>
                                                                <h4 style = "text-align: center; font-weight: bold; font-family: Georgia,serif;">Company Phone</h4>
                                                                <div class = "row" style = "padding-top : 20px;">
                                                                    <div class = "col-md-5">
                                                                        <h5 style = "font-weight: bold">Phone Number: </h5>
                                                                        <h5 id = "emp_phone_number_view"></h5>
                                                                    </div>
                                                                    <div class = "col-md-2"></div>
                                                                    <div class = "col-md-5">
                                                                        <h5 style = "font-weight: bold">Unit Price:</h5>
                                                                        <h5 id = "emp_unit_price_view"></h5>
                                                                    </div>
                                                                </div>
                                                                <div class = "row">
                                                                    <div class = "col-md-12">
                                                                        <h5 style = "font-weight: bold">Phone Description:</h5>
                                                                        <h5 id ="emp_phone_desc_view"></h5>
                                                                    </div>
                                                                </div>

                                                                <h4 style = "text-align: center; font-weight: bold; font-family: Georgia,serif;">Gmail/OIMS Access</h4>

                                                                <div class = "row" style = "padding-top : 20px;">
                                                                    <div class = "col-md-5">
                                                                        <h5 style = "font-weight: bold">OIMS Username/Email Address:</h5>
                                                                        <h5 id = "emp_oims_view"></h5>
                                                                    </div>
                                                                    <div class = "col-md-2"></div>
                                                                    <div class = "col-md-5">
                                                                        <h5 style = "font-weight: bold">Corporate Gmail Address:</h5>
                                                                        <h5 id = "emp_gmail_view"></h5>
                                                                    </div>
                                                                </div>
                                                                <div class = "row">
                                                                    <div class = "col-md-12">
                                                                        <h5 style = "font-weight: bold">Gmail Password:</h5>
                                                                        <h5 id ="emp_gmail_password_view"></h5>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                </div>
                                <span id = "down"></span>
                            </div>

                            <div class="col-md-6">
                                <div class="box box-info">
                                    <div class="nav-tabs-custom" style = "padding-top : 20px;">
                                            <ul class="nav nav-tabs">
                                                <li class="active" id = "tabTest4"><a id="tab4" href="#tab_Show4" data-toggle="tab" class = "human_resources_tab_show_class">Assigned Item/s</a></li>
                                                <li  id = "tabTest1"><a id="tab1" href="#tab_Show1" data-toggle="tab" class = "human_resources_tab_show_class">Work History</a></li>
                                                <li id = "tabTest2"><a id="tab2" href="#tab_Show2" data-toggle="tab" class = "human_resources_tab_show_class">Educational Background</a></li>
                                                <li id = "tabTest3"><a id="tab3" href="#tab_Show3" data-toggle="tab" class = "human_resources_tab_show_class">Character Reference</a></li>

                                            </ul>
                                            <div class = "tab-content">
                                                <div class="tab-pane active" id="tab_Show4">
                                                    <div class = "box-body">
                                                        <div class="col-md-12">
                                                            <table class="tableendorse display table-hover table-condensed" id="human-resource-assigned-items" width="100%">
                                                                <thead>
                                                                <tr>
                                                                    <th>ID</th>
                                                                    <th>Category</th>
                                                                    <th>Brand/Model Name</th>
                                                                    <th>Color</th>
                                                                    <th>Remarks</th>
                                                                </tr>
                                                                </thead>
                                                                <tfoot>
                                                                <tr>
                                                                    <th>ID</th>
                                                                    <th>Category</th>
                                                                    <th>Brand/Model Name</th>
                                                                    <th>Color</th>
                                                                    <th>Remarks</th>
                                                                </tr>
                                                                </tfoot>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane" id="tab_Show1">
                                                    <div class = "box-body">
                                                        <div class="col-md-12">
                                                            <table class="tableendorse display table-hover table-condensed" id="human-resources-show-exp" width="100%">
                                                                <thead>
                                                                <tr>
                                                                    <th>Name</th>
                                                                    <th>Address</th>
                                                                    <th>Position</th>
                                                                    <th>Start Date</th>
                                                                    <th>End Date</th>
                                                                    <th>Contact</th>
                                                                </tr>
                                                                </thead>
                                                                <tfoot>
                                                                <tr>
                                                                    <th>Name</th>
                                                                    <th>Address</th>
                                                                    <th>Position</th>
                                                                    <th>Start Date</th>
                                                                    <th>End Date</th>
                                                                    <th>Contact</th>
                                                                </tr>
                                                                </tfoot>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane" id="tab_Show2">
                                                    <div class = "box-body">
                                                        <div class="col-md-12">
                                                            <table class="tableendorse display table-hover table-condensed" id="human-resource-show-educ" width="100%">
                                                                <thead>
                                                                <tr>
                                                                    <th>Level</th>
                                                                    <th>School Name</th>
                                                                    <th>School Address</th>
                                                                    <th>Year Graduated</th>
                                                                    <th>Course</th>
                                                                </tr>
                                                                </thead>
                                                                <tfoot>
                                                                <tr>
                                                                    <th>Level</th>
                                                                    <th>School Name</th>
                                                                    <th>School Address</th>
                                                                    <th>Year Graduated</th>
                                                                    <th>Course</th>
                                                                </tr>
                                                                </tfoot>
                                                            </table>
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="tab-pane" id="tab_Show3">
                                                    <div class = "box-body">
                                                        <div class="col-md-12">
                                                            <table id="human-resources-show-ref" class="tableendorse display table-hover table-condensed" width="100%">
                                                                <thead>
                                                                <tr>
                                                                    <th>Employee Name</th>
                                                                    <th>Position</th>
                                                                    <th>Company Name</th>
                                                                    <th>Contact Number</th>
                                                                </tr>
                                                                </thead>
                                                                <tfoot>
                                                                <tr>
                                                                    <th>Employee Name</th>
                                                                    <th>Position</th>
                                                                    <th>Company name</th>
                                                                    <th>Contact Number</th>
                                                                </tr>
                                                                </tfoot>
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
                </div>
                <div class="modal-footer" >
                    <button type="button" id = "btnCloseEmp" class="btn btn-warning pull-right" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    
    <div class="modal modal-danger fade" id="modal-delete">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <p style="text-align: center">Successfully Deleted</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline pull-right" data-dismiss="modal" id="btnModalCloseFillUpError">Close</button>
                </div>
            </div>
        </div>
    </div>

    
    <div class="modal modal-danger fade" id="modal-invalidtype">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <p style="text-align: center">Invalid Type!</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline pull-right" data-dismiss="modal" id="btnModalCloseFillUpError">Close</button>
                </div>
            </div>
        </div>
    </div>
    

    <div class="modal modal-info fade" id="modal-requestDelete">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Deleting...</h4>
                </div>
                <div class="modal-body">
                    <p style="text-align: center">Please wait request is being sent.  <img src="<?php echo e(asset('dist/img/loading.gif')); ?>" style="width: 5%;"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline pull-right" data-dismiss="modal" id="btnModalCloseSending">Close</button>
                </div>
            </div>
        </div>
    </div>

    
    <div class="modal modal-success fade" id="modal-sentsuccessexp">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Success!</h4>
                </div>
                <div class="modal-body">
                    <p style="text-align: center">Successfully Added Experience</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline pull-right" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    
    <div class="modal modal-success fade" id="modal-sentsuccesseduc">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Success!</h4>
                </div>
                <div class="modal-body">
                    <p style="text-align: center">Successfully Added Education</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline pull-right" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    
    <div class="modal modal-success fade" id="modal-sentsuccessref">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Success!</h4>
                </div>
                <div class="modal-body">
                    <p style="text-align: center">Successfully Added Character Reference</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline pull-right" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    
    <div class="modal modal-danger fade" id="modal-existingprofile">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Error 500!</h4>
                </div>
                <div class="modal-body">
                    <p style="text-align: center">Profile Exists!</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline pull-right" data-dismiss="modal" id="btnModalCloseFillUpError">Close</button>
                </div>
            </div>
        </div>
    </div>

    
    <div class="modal modal-success fade" id="modal-sentsuccessprofile">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Success!</h4>
                </div>
                <div class="modal-body">
                    <p style="text-align: center">Successfully Added Profile</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline pull-right" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    
    <div class="modal modal-success fade" id="modal-updatesuccessprofile">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Success!</h4>
                </div>
                <div class="modal-body">
                    <p style="text-align: center">Successfully Updated Profile</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline pull-right" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    
    <div class="modal modal-success fade" id="modal-updatecontract">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Success!</h4>
                </div>
                <div class="modal-body">
                    <p style="text-align: center">Successfully Updated!</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline pull-right" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    
    <div class="modal fade" id="modal-logs">
        <div class="modal-dialog" style = "width : 50%;">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <center><h3 class="modal-title">Logs</h3></center>
                </div>
                <div class="modal-body" >
                    <div class = "box box-info">
                        <div class = "row" style = "padding-top: 50px;">
                            <div class="col-md-12">
                                <table id="human_resources_general_logs" class="tableendorse display table-hover table-condensed" width="100%">
                                    <thead>
                                    <tr>
                                        <th>Assigned by</th>
                                        <th>Employee Name</th>
                                        <th>Activity</th>
                                        <th>Date and Time</th>
                                    </tr>
                                    </thead>
                                </table>
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

    
    <div class="modal modal-warning fade" id="modal-changestat">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <p style="text-align: center">Please change fields to update!</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline pull-right" data-dismiss="modal" id="btnModalCloseFillUpError">Close</button>
                </div>
            </div>
        </div>
    </div>

    
    <div class="modal modal-success fade" id="modal-motoradd">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Success!</h4>
                </div>
                <div class="modal-body">
                    <p style="text-align: center">Successfully Added Motorcycle!</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline pull-right" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    
    <div class="modal modal-success fade" id="modal-atm">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Success!</h4>
                </div>
                <div class="modal-body">
                    <p style="text-align: center">Successfully Updated Details!</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline pull-right" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    
    <div class="modal modal-warning fade" id="modal-change-atm">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Note!</h4>
                </div>
                <div class="modal-body">
                    <p style="text-align: center">Please change atleast 1 field to update!</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline pull-right" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    
    <div class="modal fade" id="modal-pos">
        <div class="modal-dialog" style = "width : 55%;">
            <div class="modal-content">
                <div class="modal-header">
                    <center><h4 class="modal-title" style = "font-family: Georgia,serif;">POSITION CHANGE</h4></center>
                </div>
                <div class="modal-body">
                    <input type="hidden" id = "pos_from">
                    <input type="hidden" id = "pos_to">
                    <div class = "row" >
                        <div class = "col-md-1"></div>
                        <div class = "col-md-10">
                            <center><h3 id = "nameBox" style = "font-family: Georgia,serif;"></h3></center>
                            <div class = "box box-warning">
                                <div class = "row" style = "padding-top : 20px;">
                                    <div class = "col-md-5">
                                        <label for="">Position:</label>
                                        <input type="text" id = "pos_change" class ="form-control" disabled>
                                    </div>
                                    <div class = "col-md-2"></div>
                                    <div class = "col-md-5">
                                        <label for="">Type of Change:</label>
                                        <select id= "type_change" class = "form-control">
                                            <option value="">--SELECT--</option>
                                            <option value="PROMOTION">PROMOTION</option>
                                            <option value="DEMOTION">DEMOTION</option>
                                            <option value="CORRECTION">CORRECTION</option>
                                        </select>
                                    </div>
                                </div>
                                <div class = "row" style = "padding-top : 20px; padding-bottom: 20px;">
                                    <div class = "col-md-5">
                                        <label for="">Supporting Document: </label>
                                        <input type="file" id = "pos_file">
                                    </div>
                                    <div class = "col-md-2"></div>
                                    <div class = "col-md-5">
                                        <label for="">Change allowance:</label>
                                        <input type="text" id = "allowance_change" class = "form-control">
                                    </div>
                                </div>
                                <div class = "row" style = "padding-top : 20px; padding-bottom: 20px;">
                                    <div class = "col-md-12">
                                        <label for="">Remarks: </label>
                                        <textarea id="posChangeRemarks" rows="3" class="form-control"></textarea>
                                    </div>
                                </div>
                                <div class = "row">
                                    <div class = "col-md-6">
                                        <label style = "color : red;">*Note : If you choose to cancel, the current changed position will be reverted to the previous position.</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class = "col-md-1"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id = "btnChangePos">Save changes</button>
                    <button type="button" class="btn btn-default pull-left" id = "btnBackPos">Cancel</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    
    <div class="modal modal-success fade" id="modal-motorUpdate">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Success!</h4>
                </div>
                <div class="modal-body">
                    <p style="text-align: center">Successfully Updated Motorcycle!</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline pull-right" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="modal-viewDocu">
        <div class="modal-dialog" id = "editSizeModal"  style = "width : 50%">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">General Forms</h4>
                </div>
                <div class="modal-body">
                    <div class = "row">
                        <div id = "formUpload"></div>
                        <div class = "col-md-12" id = "changeFormSize">
                            <div class = "box box-danger">
                                <div class = "row">
                                    <center>
                                        <h4 style = "font-family: Georgia,serif;">List of Uploaded Files</h4>
                                    </center>
                                    <div class = "col-md-12">
                                        <div style = "overflow: scroll; padding-top: 20px;">
                                            <table id = "human-resources-file-format" class="table-condensed" width="100%">
                                                <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Title</th>
                                                    <th>Description</th>
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
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Close</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    
    <div class="modal fade" id="modal-partial-show">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <center><h4 class="modal-title" >Info</h4></center>
                </div>
                <div class="modal-body">
                    <div class = "box-body">
                        <div class = "box box-warning">
                            <div class = "row" style = "padding-top : 30px; padding-bottom: 15px;">
                                <div class = "col-md-12">
                                    <label for="">Partial Remarks(Need to Complete for Approval):</label>
                                    <textarea id = "show_partial" class = "form-control" rows="5" disabled></textarea>
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

    <div class="modal fade" id="modal-partial-update">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <center><h4 class="modal-title" >Info</h4></center>
                </div>
                <div class="modal-body">
                    <div class = "box-body">
                        <div class = "box box-warning">
                            <div class = "row" style = "padding-top : 30px; padding-bottom: 15px;">
                                <div class = "col-md-12">
                                    <label for="">Partial Remarks(Need to Complete for Approval):</label>
                                    <textarea id = "emp_partial" class = "form-control" rows="5" placeholder= "Enter employee's incomplete requirements and information"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button type="button" id = "btnPartialUpdate" class="btn btn-primary">Update</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    

    <div class="modal fade" id="modal-generate-201">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" style = "text-align: center; font-family: Georgia,serif;">Download 201 File</h4>
                </div>
                <div class="modal-body">
                    <div class = "row">
                        <div class = "col-md-1"></div>
                        <div class = "col-md-10">
                            <div class = "box box-info">
                                <h3 style = "text-align: center; font-family: Georgia,serif; padding-top : 10px;">Generate and Download</h3>
                                <div class = "row" style = "padding-top: 20px; padding-bottom : 20px;">
                                    <div class = "col-md-4"></div>
                                    <div class = "col-md-6">
                                        <button type = "button" id = "btndl201Excel" class= "btn btn-success"> <i class = "fa fa-fw fa-download"></i> Download Now</button><span id = "downExcel"></span>
                                    </div>
                                    <div class = "col-md-2"></div>
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

    <div class="modal modal-warning fade" id="modal-sendingrequest_hr">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Sending...</h4>
                </div>
                <div class="modal-body">

                    <div class = "row" style = "padding-top : 20px;">
                        <div class = "col-md-2"></div>
                        <div class = "col-md-8">
                            <span id="ulPercentage_new_emp" hidden>--</span>
                            <div id="progressbar_new_emp" hidden></div>
                        </div>
                        <div class = "col-md-2"></div>
                    </div>

                    <div class = "row" style = "padding-top : 20px;">
                        <div class = "col-md-12">
                            <h5 style="text-align: center">Please wait while request is being sent.  <img src="<?php echo e(asset('dist/img/loading.gif')); ?>" style="width: 5%;"></h5>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline pull-right" data-dismiss="modal" >Close</button>
                </div>
            </div>
        </div>
    </div>

    
    <div class="modal fade" id="modal-denial-remarks">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <center><h4 class="modal-title" >Information</h4></center>
                </div>
                <div class="modal-body">
                    <div class = "box-body">
                        <div class = "box box-warning">
                            <div class = "row" style = "padding-top : 30px; padding-bottom: 15px;">
                                <div class = "col-md-12">
                                    <label for="">Rejection Remarks</label>
                                    <textarea id = "show_denial_remarks" class = "form-control" rows="5" disabled></textarea>
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

    <div class="modal fade" id="modal-submit-type-pre-approve">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <center><h4 class="modal-title">Confirmation</h4></center>
                </div>
                <div class="modal-body">
                    <div class = "box-body">
                        <div class = "row" style = "padding-top : 10px;">
                            <div class = "col-md-6">
                                <button class = "btnSubmittoHead btn btn-block btn-md btn-primary">Submit as Complete</button>
                            </div>
                            <div class = "col-md-6">
                                <button class = "btnSubmittoHead btn btn-block btn-md btn-warning">Submit as Partial</button>
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

    <div class="modal fade" id="modal-incomplete-remarks">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <center><h4 class="modal-title" >Information</h4></center>
                </div>
                <div class="modal-body">
                    <div class = "box-body">
                        <div class = "box box-warning">
                            <div class = "row" style = "padding-top : 30px; padding-bottom: 15px;">
                                <div class = "col-md-12">
                                    <label for="">Incomplete Remarks: </label>
                                    <textarea id = "show_incom_remarks" class = "form-control" rows="5" disabled></textarea>
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

    <div class="modal fade" id="modal-return-remarks">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <center><h4 class="modal-title" >Information</h4></center>
                </div>
                <div class="modal-body">
                    <div class = "box-body">
                        <div class = "box box-warning">
                            <div class = "row" style = "padding-top : 30px; padding-bottom: 15px;">
                                <div class = "col-md-12">
                                    <label for="">Return Remarks: </label>
                                    <textarea id = "show_return_remarks" class = "form-control" rows="5" disabled></textarea>
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

    <div class="modal fade" id="modal-reject-remarks">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <center><h4 class="modal-title" >Information</h4></center>
                </div>
                <div class="modal-body">
                    <div class = "box-body">
                        <div class = "box box-warning">
                            <div class = "row" style = "padding-top : 30px; padding-bottom: 15px;">
                                <div class = "col-md-12">
                                    <label for="">Rejection Remarks: </label>
                                    <textarea id = "show_reject_remarks" class = "form-control" rows="5" disabled></textarea>
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

    <div class="modal fade" id="modal-promotion-remarks">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <center><h4 class="modal-title" >Information</h4></center>
                </div>
                <div class="modal-body">
                    <div class = "box-body">
                        <div class = "box box-warning">
                            <div class = "row" style = "padding-top : 30px; padding-bottom: 15px;">
                                <div class = "col-md-12">
                                    <label for="">Promotion Remarks: </label>
                                    <textarea id = "show_promotion_remarks" class = "form-control" rows="5" disabled></textarea>
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
    
 <div class="modal fade" id="modal-attendance-general-generation">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <center><h4 class="modal-title" >Generation of Attendance</h4></center>
                </div>
                <div class="modal-body">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#all_employee_tab" data-toggle="tab" class="generate_tabs">ALL employee</a></li>
                        <li><a href="#specific_employee_tab" data-toggle="tab" class="generate_tabs">Specific employee</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class = "active tab-pane" id="all_employee_tab" style = "padding-top : 30px; padding-bottom: 15px;"><!--tab1-->
                            <div class = "box box-warning">
                                <div class = "box-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="">Select Date to Generate: <small style="color: red">(Required Field)</small></label>
                                            <input type="date" class="form-control" id="date_to_generate">
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
                        <div class="tab-pane" id="specific_employee_tab" style="padding-top : 30px; padding-bottom: 15px;"><!--tab2-->
                          <div class="box box-warning">
                              <div class="box-body">
                                  <div class="row">
                                      <div class="col-md-12">
                                          <div class="form-group">
                                              <select name="" class="select2" id="specific_date_generate" style="width:100%">
                                                  <option value="">-</option>
                                                  <?php $__currentLoopData = $get_employee_id; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $chunkdata): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                      <option value="<?php echo e($chunkdata->emp_id); ?>"><?php echo e($chunkdata->emp_name); ?></option>
                                                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                              </select>
                                          </div>
                                      </div>
                                  </div>
                                  <div class="row">
                                      <div class="col-md-6" style="padding:0px;">
                                          <div class="input-group margin">
                                              <div class="input-group-btn">
                                                  <button type="button" class="btn btn-default">From</button>
                                              </div>
                                              <!-- /btn-group -->
                                              <input type="date" id="from_date_picker" class="form-control" style="cursor:pointer;">
                                          </div>
                                      </div>
                                      <div class="col-md-6" style="padding:0px;">
                                          <div class="input-group margin">
                                              <div class="input-group-btn">
                                                  <label for=""> <small style="color: red">(Required Field)</small></label>
                                                  <button type="button" class="btn btn-default">To</button>
                                              </div>
                                              <!-- /btn-group -->
                                              <input type="date" id="to_date_picker" class="form-control" style="cursor:pointer;">
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                        </div><!--tab2-->
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

                    
                    <table border="2" style="white-space: normal; font-size: 10px" width="100%" id="otherPersonalSpan1"></table>
                    

                    
                    <table border="2" style="white-space: normal; font-size: 10px" width="100%" id="otherInfoSpan1"></table>
                    

                    
                    <table border="2" style="white-space: normal; font-size: 10px" width="100%" id="otherEmployerSpan1"></table>
                    

                    
                    <table border="2" style="white-space: normal; font-size: 10px" width="100%" id="otherBusinessSpan1"></table>
                    

                    <div class="row">
                        
                        <div class="form-group col-xs-12">
                            <label>Remarks:</label>
                            <textarea id="viewRemarks" class="form-control" rows="3" disabled></textarea>
                        </div>
                        
                    </div>
                    <div class="row">
                        
                        <div class="form-group col-xs-12" id="divNotes">
                            <label>Notes:</label>
                            <textarea id="viewNotes" class="form-control" rows="3" disabled></textarea>
                        </div>
                        
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    
        <div class="modal fade" id="modal-hr-send-now-issuance">
        <div class="modal-dialog" >
            <div class="modal-content">
                <div class="modal-header" style="background-color: #d9edf7">
                    <h4 class="modal-title" >Information</h4>
                </div>
                <div class="modal-body">
                    <p style = "text-align: center; padding-top : 20px; font-size: large">Please wait while sending issuance......
                        <span style = "padding-right : 5px;" ><img src= "<?php echo e(asset('dist/img/loading.gif')); ?>" style = "width: 7%"></span>
                    </p>

                    <div class = "row" style = "padding-top : 15px;">
                        <div class = "col-md-2"></div>
                        <div class = "col-md-8">
                            <span id="ulPercentage_issuance"></span>
                            <div id="progressbar_issuance" hidden></div>
                        </div>
                        <div class = "col-md-2"></div>
                    </div>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <div class="modal modal-success fade" id="modal-success-send-issuance">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4>Information</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <h4 style="text-align : center">Successfully sent the issuance!</h4>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline pull-right" data-dismiss="modal">Close</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <div class="modal fade" id="modal-show-issuance-info">
        <div class="modal-dialog" style="width: 60%;">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #d9edf7">
                    <h4 style="text-align : center; font-weight: bold" id="subjStorage"></h4>
                </div>
                <div class="modal-body">
                    <div class="row" style="padding-top : 15px">
                        <div class="col-md-12">
                            <div class="box box-info">
                                <div class="mailbox-read-message" id="messageVIew">

                                </div>
                                <div class="box-footer">
                                    <ul class="mailbox-attachments clearfix" id="loopFilesIssuance">
                                    </ul>
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


<?php $__env->stopSection(); ?>

<?php $__env->startPush('leftsidebar'); ?>
    <?php echo $__env->make('human_resources.human-resources-leftsidebar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('jscript'); ?>
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/1.0.7/css/responsive.dataTables.min.css">
    <script src="https://cdn.datatables.net/responsive/2.1.1/js/dataTables.responsive.min.js"></script>
    <script src="<?php echo e(asset('jscript/human-resources.js?n='.$javs)); ?>"></script>
    <script src="<?php echo e(asset('bower_components/jquery-slimscroll/jquery.slimscroll.min.js')); ?>"></script>
    <script src="<?php echo e(asset('bower_components/fastclick/lib/fastclick.js')); ?>"></script>
    <script src="<?php echo e(asset('plugins/iCheck/icheck.min.js')); ?>"></script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>