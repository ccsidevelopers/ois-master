<div class="content-wrapper">
    <section class="content-header">
        <h1>
            EMPLOYEES
        </h1>
    </section>
    <section class = "content">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a id="tabA" href="#tab_mainEmp1" data-toggle="tab" class = "human_resources_employee_class">Add Employee Profile</a></li>
                <li><a id="tabB" href="#tab_mainEmp2" data-toggle="tab" class = "human_resources_employee_class">Employment</a></li>
            </ul>
            <div class = "tab-content">
                <div class="tab-pane active" id="tab_mainEmp1">
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li class="active"><a id="tab1" href="#tab_Info1" data-toggle="tab" class = "human_resources_tab_info_class">Personal Information</a></li>
                            <li><a id="tab2" href="#tab_Info2" data-toggle="tab" class = "human_resources_tab_info_class">Work History</a></li>
                            <li><a id="tab3" href="#tab_Info3" data-toggle="tab" class = "human_resources_tab_info_class">Educational Background</a></li>
                            <li><a id="tab4" href="#tab_Info4" data-toggle="tab" class = "human_resources_tab_info_class">Character Reference</a></li>
                        </ul>
                        <div class = "tab-content">
                            <div class="tab-pane active" id="tab_Info1">
                                <div class="body">
                                    <div class="row">
                                        <div class = "col-xs-1">
                                            <input type="radio" name="profile" id = "optionProfile1" checked="checked"><b>Add Profile</b>
                                        </div>
                                        <div class = "col-xs-1">
                                        </div>
                                        <div class = "col-xs-1">
                                            <input type="radio" name="profile"  id = "optionProfile2" ><b>Update Profile</b>
                                        </div>
                                    </div>
                                    <div class="row" style = "padding-top : 20px;">
                                        <div class = "col-md-6">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <span hidden id = "profileEdit">
                                                    <label>Employee Name:</label>
                                                        <select class="form-control select2" style="width: 100%;" id="expSelectedIdProf" name = "expSelectedNameProf">
                                                        </select>
                                                  </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="box box-info">
                                                <div class = "row">
                                                    <center>
                                                        <h3 style = "font-family: Georgia,serif;">Employee Personal Information</h3>
                                                    </center>
                                                </div>
                                                <div class = "row">
                                                    <div class="col-md-4">
                                                        <label>First Name<small style = "color:red;">*Required field</small></label>
                                                        <label for="emp_first_name"></label><input type="text" class="form-control" id="emp_first_name">
                                                    </div>
                                                    <div class = "col-md-4"></div>
                                                    <div class="col-md-4">
                                                        <label>Age:<small style = "color:red;">*Required field</small></label>
                                                        <label for="emp_age"></label><input type="text" class="form-control" id="emp_age">
                                                    </div>
                                                </div>
                                                <div class = "row">
                                                    <div class="col-md-4">
                                                        <label>Middle Name<small style = "color:red;">*Required field</small></label>
                                                        <label for="emp_mid_name"></label><input type="text" class="form-control" id="emp_mid_name">
                                                    </div>
                                                    <div class = "col-md-4"></div>
                                                    <div class="col-md-4">
                                                        <label>Gender</label>
                                                        <label for="emp_gender"></label><select class="form-control" id="emp_gender">
                                                            <option value = "MALE">Male</option>
                                                            <option value = "FEMALE">Female</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class = "row">
                                                    <div class="col-md-4">
                                                        <label>Last Name<small style = "color:red;">*Required field</small></label>
                                                        <label for="emp_last_name"></label><input type="text" class="form-control" id="emp_last_name">
                                                    </div>
                                                    <div class = "col-md-4"></div>
                                                    <div class="col-md-4">
                                                    </div>
                                                </div>
                                                <div class = "row">
                                                    <div class="col-md-12">
                                                        <label>Present Address:<small style = "color:red;">*Required field</small></label>
                                                        <textarea class="form-control" rows = "2" id="emp_present_address" placeholder = "Present Address"></textarea>
                                                    </div>
                                                </div>
                                                {{--<div class = "row">--}}
                                                    {{--<div class="col-md-12" >--}}
                                                        {{--<label>Permanent Address: <small id = "check_show"><input type = "checkbox" id = "present_is_permanent">Check if same with present address</small></label>--}}
                                                        {{--<p id = "disablePermanent"> <textarea class="form-control" rows = "2" id="emp_permanent_address" placeholder = "Permanent Address"></textarea></p>--}}
                                                    {{--</div>--}}
                                                {{--</div>--}}
                                                <div class = "row">
                                                    <div class="col-md-4">
                                                        <label>Date of Birth:<small style = "color:red;">*Required field</small></label>
                                                        <label for="emp_birth_date"></label><input type="date" class="form-control" id="emp_birth_date">
                                                    </div>
                                                    <div class = "col-md-4"></div>
                                                    <div class="col-md-4">
                                                        <label>Primary Contact Number<small style = "color:red;">*Required field</small></label>
                                                        <label for="emp_contact_number"></label><input type="text" class="form-control" id="emp_contact_number">
                                                    </div>
                                                </div>
                                                <div class = "row">
                                                    <div class="col-md-4">
                                                        <label >Marital Status:</label>
                                                        <label for="emp_marital_status"></label><select class="form-control" id="emp_marital_status">
                                                            <option value = "SINGLE">Single</option>
                                                            <option value = "MARRIED">Married</option>
                                                            <option value="SEPARATED">Separated</option>
                                                            <option value = "WIDOWED">Widowed</option>
                                                        </select>
                                                    </div>
                                                    <div class = "col-md-4"></div>
                                                    <div class="col-md-4">
                                                        <label>Primary Email Address<small style = "color:red;">*Required field</small></label>
                                                        <label for="emp_email_add"></label><input type="text" class="form-control" id="emp_email_add">
                                                    </div>
                                                </div>
                                                <div class = "row">
                                                    <div class="col-md-4">
                                                        <label>Religion</label>
                                                        <label for="emp_religion"></label><input type="text" class="form-control" id="emp_religion">
                                                    </div>
                                                    <div class = "col-md-4"></div>
                                                    <div class="col-md-4">
                                                        <label>Dependents<small style = "color:red;">*leave if None</small></label>
                                                        <label for="emp_dependents"></label><input type="text" class="form-control" id="emp_dependents">
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="box box-info">
                                                <div class="row">
                                                    <div class="col-md-2"></div>
                                                    <div class="col-md-8">
                                                        <div class = "row">
                                                            <center>
                                                                <h3 style = "font-family: Georgia,serif;">Profile Image</h3>
                                                            </center>
                                                        </div>
                                                        <div class = "row">
                                                            <center>
                                                                <form id="form1" runat="server">
                                                                    <img id = "emp_profile_pic_display" style = "width: 65% ; height: 65%; border:5px solid #000;" src = "{{asset('user_profile_pictures/default3.jpg')}}" />
                                                                </form>
                                                            </center>
                                                        </div>
                                                        <div class = "row">
                                                            <br>
                                                            <input type='file' id="emp_profile_pic" />
                                                            <button id = "cancelImg" class="pull-right" style="margin-bottom: 10px">Cancel</button>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2"></div>
                                                </div>
                                            </div>
                                            <div class="box box-info">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class = "row">
                                                            <center>
                                                                <h3 style = "font-family: Georgia,serif;">Employee Schedule</h3>
                                                            </center>
                                                        </div>
                                                        <div class = "row" style = "padding-top: 10px;">
                                                            <div class = "col-md-8">
                                                                <label for="">Fixed Time Schedule:</label>
                                                                <input type="text" id = "emp_fixed_sched" class = "form-control">
                                                            </div>
                                                        </div>
                                                        <div class  = "row" style = "padding-top: 10px;">
                                                            <div class = "col-md-5">
                                                                <label for="">Specific Time Schedule:</label>
                                                            </div>
                                                        </div>
                                                        <div class = "row" style = "padding-top : 5px;">
                                                            <div class = "col-md-5">
                                                                <input type="text" class = "form-control" id = "monSched" value = "Monday" disabled>
                                                            </div>
                                                            <div class = "col-md-3">
                                                                <input type = "time" id = "emp_in1" class = "form-control" value = "" >
                                                            </div>
                                                            <div class = "col-md-1">
                                                                <h5>to</h5>
                                                            </div>
                                                            <div class = "col-md-3">
                                                                <input type = "time" id = "emp_out1" class = "form-control" value = "">
                                                            </div>
                                                        </div>
                                                        <div class = "row" style = "padding-top : 5px;">
                                                            <div class = "col-md-5">
                                                                <input type="text" class = "form-control" id = "tuesdaySched" value = "Tuesday" disabled>
                                                            </div>
                                                            <div class = "col-md-3">
                                                                <input type = "time" id = "emp_in2" class = "form-control" value = "" >
                                                            </div>
                                                            <div class = "col-md-1">
                                                                <h5>to</h5>
                                                            </div>
                                                            <div class = "col-md-3">
                                                                <input type = "time" id = "emp_out2" class = "form-control" value = "">
                                                            </div>
                                                        </div>
                                                        <div class = "row" style = "padding-top : 5px;">
                                                            <div class = "col-md-5">
                                                                <input type="text" class = "form-control" id = "wedSched" value = "Wednesday" disabled>
                                                            </div>
                                                            <div class = "col-md-3">
                                                                <input type = "time" id = "emp_in3" class = "form-control" value = "" >
                                                            </div>
                                                            <div class = "col-md-1">
                                                                <h5>to</h5>
                                                            </div>
                                                            <div class = "col-md-3">
                                                                <input type = "time" id = "emp_out3" class = "form-control" value = "">
                                                            </div>
                                                        </div>
                                                        <div class = "row" style = "padding-top : 5px;">
                                                            <div class = "col-md-5">
                                                                <input type="text" class = "form-control" id = "thursSched" value = "Thursday" disabled>
                                                            </div>
                                                            <div class = "col-md-3">
                                                                <input type = "time" id = "emp_in4" class = "form-control" value = "" >
                                                            </div>
                                                            <div class = "col-md-1">
                                                                <h5>to</h5>
                                                            </div>
                                                            <div class = "col-md-3">
                                                                <input type = "time" id = "emp_out4" class = "form-control" value = "">
                                                            </div>
                                                        </div>
                                                        <div class = "row" style = "padding-top : 5px;">
                                                            <div class = "col-md-5">
                                                                <input type="text" class = "form-control" id = "friSched" value = "Friday" disabled>
                                                            </div>
                                                            <div class = "col-md-3">
                                                                <input type = "time" id = "emp_in5" class = "form-control" value = "" >
                                                            </div>
                                                            <div class = "col-md-1">
                                                                <h5>to</h5>
                                                            </div>
                                                            <div class = "col-md-3">
                                                                <input type = "time" id = "emp_out5" class = "form-control" value = "">
                                                            </div>
                                                        </div>
                                                        <div class = "row" style = "padding-top : 5px;">
                                                            <div class = "col-md-5">
                                                                <input type="text" class = "form-control" id = "satSched" value = "Saturday" disabled>
                                                            </div>
                                                            <div class = "col-md-3">
                                                                <input type = "time" id = "emp_in6" class = "form-control" value = "" >
                                                            </div>
                                                            <div class = "col-md-1">
                                                                <h5>to</h5>
                                                            </div>
                                                            <div class = "col-md-3">
                                                                <input type = "time" id = "emp_out6" class = "form-control" value = "">
                                                            </div>
                                                        </div>
                                                        <div class = "row" style = "padding-top : 5px;">
                                                            <div class = "col-md-5">
                                                                <input type="text" class = "form-control" id = "sunSched" value = "Sunday" disabled>
                                                            </div>
                                                            <div class = "col-md-3">
                                                                <input type = "time" id = "emp_in7" class = "form-control" value = "" >
                                                            </div>
                                                            <div class = "col-md-1">
                                                                <h5>to</h5>
                                                            </div>
                                                            <div class = "col-md-3">
                                                                <input type = "time" id = "emp_out7" class = "form-control" value = "">
                                                            </div>
                                                        </div>
                                                        <div class = "row" style = "padding-top: 10px;">
                                                            <div class = "col-md-5">
                                                                <label for="">Working Days:</label>
                                                                <select id = "noDays" class = "form-control">
                                                                    <option value="5 Working Days">5 Working Days</option>
                                                                    <option value="6 Working Days">6 Working Days</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class = "row" style = "padding-top: 10px;">
                                                            <div class = "col-md-12">
                                                                <label for="">Remarks:</label>
                                                                <textarea id="emp_sched_remarks" rows="5" class = "form-control"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" >
                                        <div class="col-md-8">
                                            <div class="box box-info" style = "margin-top : -540px;">
                                                <div class = "row" >
                                                    <center>
                                                        <h3 style = "font-family: Georgia,serif;">Employment Details</h3>
                                                    </center>
                                                </div>
                                                <input type="hidden" id="idProvince">
                                                <input type="hidden" id="idMunicipality">
                                                <div class = "row">
                                                    <div class = "col-md-4">
                                                        <label>Branch</label>
                                                        <label for="emp_branch"></label><select class="form-control" id="emp_branch">
                                                        </select>
                                                    </div>
                                                    <div class = "col-md-4">
                                                        <label for="req_submit" id = "update201">Employee 201 File: <small style = "color:red">*please upload zip file</small></label>
                                                        <input type="file" id = "req_submit">
                                                    </div>
                                                    <div class = "col-md-4">
                                                        <label>Date Hired:<small style = "color:red;">*Required field</small></label>
                                                        <label for="emp_date_hired"></label><input type="date" class="form-control" id="emp_date_hired">
                                                    </div>
                                                </div>
                                                <div class = "row">
                                                    <div class="col-md-4">
                                                        <label>Position:<small style = "color:red;" id = "supportingDocu">*Required field</small></label>
                                                        <select class="form-control" id="emp_position"></select>
                                                    </div>
                                                    <div class = "col-md-4"></div>
                                                    <div class = "col-md-4">
                                                        <label>Status:<small style = "color:red;">*Required field</small></label>
                                                        <select id = "emp_state" class = "form-control">
                                                            <option value="Applicant">Applicant</option>
                                                            <option value="Trainee">Trainee</option>
                                                            <option value="On-Board">On-Board</option>
                                                            <option value= "Active Employee">Active Employee</option>
                                                            <option value="Inactive Employee">Inactive Employee</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class = "row" id = "ciInfo">
                                                    <div class = "col-md-4">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <label>Point of Origin:<small style = "color:red;">*Required field</small></label>
                                                                <input type="text" class="form-control" id="ciMuni" name="ciMuni" placeholder = "City/Municipality">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class = "col-md-4">
                                                        <div class="col-md-12">
                                                            <label>Area of Assignment:<small style = "color:red;">*Required field</small></label><span id="loadingProv"></span>
                                                            <input type="text" class="form-control" id="ciProv" name="ciProv" placeholder="Provinces" disabled>
                                                        </div>
                                                    </div>
                                                    <div class = "col-md-4">
                                                        <label>Motorcycle CC type:<small style = "color:red;">*Required field</small></label>
                                                        <select id="ccType" class = "form-control">
                                                            <option value=""></option>
                                                            <option value="Commuter">Commuter</option>
                                                            <option value="Motorized">Motorized</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class = "row" style = "padding-bottom: 20px;">
                                                    <div class = "col-md-4">
                                                    </div>
                                                    <div class = "col-md-4"></div>
                                                    <div class = "col-md-4">

                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="box box-info">
                                                <div class="row">
                                                    <center>
                                                        <h3 style = "font-family: Georgia,serif;">Benefits</h3>
                                                    </center>
                                                </div>
                                                <div class="row" >
                                                    <div class="col-md-6">
                                                        <label>SSS No.: <small style="color: red;">*Required field</small></label>
                                                        <label for="emp_sss"></label><input type="text" class="form-control" id="emp_sss" required>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label>Pagibig No.: <small style="color: red;">*Required field</small></label>
                                                        <label for="emp_pagibig"></label><input type="text" class="form-control" id="emp_pagibig" required>
                                                    </div>
                                                </div>
                                                <div class="row" style = "padding-bottom: 20px;">
                                                    <div class="col-md-6">
                                                        <label>Philhealth No.: <small style="color: red;">*Required field</small></label>
                                                        <label for="emp_philhealth"></label><input type="text" class="form-control" id="emp_philhealth" required>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label>TIN No.: <small style="color: red;">*Required field</small></label>
                                                        <label for="emp_tin"></label><input type="text" class="form-control" id="emp_tin" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class = "col-md-8" style = "margin-top : -480px;">
                                            <div class = "box box-info" id = "officeBasedReq">
                                                <center><h3 style = "font-family: Georgia,serif;" id = "reqName">201 File Checklist</h3></center>
                                                <div class = "row" style = "padding-top: 20px;">
                                                    <div class = "col-md-6">
                                                        <div class = "box box-danger">
                                                            <center><h4 style = "font-family: Georgia,serif;">Pre-employment Requirements</h4></center>
                                                            <div class = "row" style = "padding-top : 30px;">
                                                                <div class = "col-md-1"></div>
                                                                <div class = "col-md-5">
                                                                    <input type="checkbox"  class = "emp_checklist icheckbox_minimal-blue" value = "SSS" required><b>SSS</b>
                                                                </div>
                                                                <div class = "col-md-1"></div>
                                                                <div class = "col-md-5">
                                                                    <input type="checkbox"  class = "emp_checklist icheckbox_minimal-blue" value = "X-RAY" required><b>X-Ray</b>
                                                                </div>
                                                            </div>
                                                            <div class = "row" style = "padding-top : 20px;">
                                                                <div class = "col-md-1"></div>
                                                                <div class = "col-md-5">
                                                                    <input type="checkbox" class = "emp_checklist icheckbox_minimal-blue" value = "PHILHEALTH" required><b>Philhealth</b>
                                                                </div>
                                                                <div class = "col-md-1"></div>
                                                                <div class = "col-md-5">
                                                                    <input type="checkbox" class = "emp_checklist icheckbox_minimal-blue" value = "NBI CLEARANCE" required><b>NBI Clearance</b>
                                                                </div>
                                                            </div>
                                                            <div class = "row" style = "padding-top : 20px;">
                                                                <div class = "col-md-1"></div>
                                                                <div class = "col-md-5">
                                                                    <input type="checkbox" class = "emp_checklist icheckbox_minimal-blue" value = "PAGIBIG" required><b>PAG-IBIG</b>
                                                                </div>
                                                                <div class = "col-md-1"></div>
                                                                <div class = "col-md-5">
                                                                    <input type="checkbox" class = "emp_checklist icheckbox_minimal-blue" value = "MAYOR'S PERMIT" required><b>Mayor's Permit</b>
                                                                </div>
                                                            </div>
                                                            <div class = "row" style = "padding-top : 20px;">
                                                                <div class = "col-md-1"></div>
                                                                <div class = "col-md-5">
                                                                    <input type="checkbox" class = "emp_checklist icheckbox_minimal-blue" value = "TIN" required><b>TIN</b>
                                                                </div>
                                                                <div class = "col-md-1"></div>
                                                                <div class = "col-md-5">
                                                                    <input type="checkbox" class = "emp_checklist icheckbox_minimal-blue" value = "POLICE CLEARANCE" required><b>Police Clearance</b>
                                                                </div>
                                                            </div>
                                                            <div class = "row" style = "padding-top : 20px;">
                                                                <div class = "col-md-1"></div>
                                                                <div class = "col-md-5">
                                                                    <input type="checkbox" class = "emp_checklist icheckbox_minimal-blue" value = "MEDICAL HISTORY" required><b>Medical History</b>
                                                                </div>
                                                                <div class = "col-md-1"></div>
                                                                <div class = "col-md-5">
                                                                    <input type="checkbox" class = "emp_checklist icheckbox_minimal-blue" value = "BRGY CLEARANCE" required><b>Brgy. Clearance</b>
                                                                </div>
                                                            </div>
                                                            <div class = "row" style = "padding-top : 20px;">
                                                                <div class = "col-md-1"></div>
                                                                <div class = "col-md-5">
                                                                    <input type="checkbox" class = "emp_checklist icheckbox_minimal-blue" value = "DRUG TEST" required><b>Drug Test</b>
                                                                </div>
                                                                <div class = "col-md-1"></div>
                                                                <div class = "col-md-5">
                                                                    <input type="checkbox" class = "emp_checklist icheckbox_minimal-blue" value = "VOTER'S ID(OPTIONAL)"><b>Voter's ID(Optional)</b>
                                                                </div>
                                                            </div>
                                                            <div class = "row" style = "padding-top : 20px;">
                                                                <div class = "col-md-1"></div>
                                                                <div class = "col-md-5">
                                                                    <input type="checkbox" class = "emp_checklist icheckbox_minimal-blue" value = "STOOL" required><b>Stool</b>
                                                                </div>
                                                                <div class = "col-md-1"></div>
                                                                <div class = "col-md-5">
                                                                    <input type="checkbox" class = "emp_checklist icheckbox_minimal-blue" value = "PREGNANCY TEST(IF FEMALE)"><b>Pregnancy Test(If Female)</b>
                                                                </div>
                                                            </div>
                                                            <div class = "row" style = "padding-top : 20px; padding-bottom : 10px;">
                                                                <div class = "col-md-1"></div>
                                                                <div class = "col-md-5">
                                                                    <input type="checkbox" class = "emp_checklist icheckbox_minimal-blue" value = "URINALYSIS" required><b>Urinalysis</b>
                                                                </div>
                                                                <div class = "col-md-1"></div>
                                                                <div class = "col-md-5">
                                                                    <div id = "ciMotorReq">
                                                                        <input type="checkbox" class = "emp_checklist icheckbox_minimal-blue" value = "MOTOR DETAILS"><b>Motor Details</b>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class = "col-md-6">
                                                        <div class = "box box-danger">
                                                            <center><h4 style = "font-family: Georgia,serif;">Pre-employment CCSI Docs</h4></center>
                                                            <div class = "row" style = "padding-top : 30px;">
                                                                <div class = "col-md-1"></div>
                                                                <div class = "col-md-5">
                                                                    <input type="checkbox" class = "emp_checklist icheckbox_minimal-blue" value = "RESUME" required><b>Resume</b>
                                                                </div>
                                                                <div class = "col-md-1"></div>
                                                                <div class = "col-md-5">
                                                                    <input type="checkbox" class = "emp_checklist icheckbox_minimal-blue" value = "CMAP RESULT" required><b>CMAP Result</b>
                                                                </div>
                                                            </div>
                                                            <div class = "row" style = "padding-top : 20px;">
                                                                <div class = "col-md-1"></div>
                                                                <div class = "col-md-5">
                                                                    <input type="checkbox" class = "emp_checklist icheckbox_minimal-blue" value = "APPLICATION FORM" required><b>Application Form</b>
                                                                </div>
                                                                <div class = "col-md-1"></div>
                                                                <div class = "col-md-5">
                                                                    <input type="checkbox" class = "emp_checklist icheckbox_minimal-blue" value = "EVALUATION EXAM" required><b>Evaluation Exam</b>
                                                                </div>
                                                            </div>
                                                            <div class = "row" style = "padding-top : 20px;">
                                                                <div class = "col-md-1"></div>
                                                                <div class = "col-md-5">
                                                                    <input type="checkbox" class = "emp_checklist icheckbox_minimal-blue" value = "PRE-EMPLOYMENT EXAM" required><b>Pre-Employment Exam</b>
                                                                </div>
                                                                <div class = "col-md-1"></div>
                                                                <div class = "col-md-5">
                                                                    <input type="checkbox" class = "emp_checklist icheckbox_minimal-blue" value = "EVALUATION" required><b>Evaluation</b>
                                                                </div>
                                                            </div>
                                                            <div class = "row" style = "padding-top : 20px;">
                                                                <div class = "col-md-1"></div>
                                                                <div class = "col-md-5">
                                                                    <input type="checkbox" class = "emp_checklist icheckbox_minimal-blue" value = "TRAINING AGREEMENT" required><b>Training Agreement</b>
                                                                </div>
                                                                <div class = "col-md-1"></div>
                                                                <div class = "col-md-5">
                                                                    <input type="checkbox" class = "emp_checklist icheckbox_minimal-blue" value = "HANDBOOK AND DPA" required><b>Handbook and DPA</b>
                                                                </div>
                                                            </div>
                                                            <div class = "row" style = "padding-top : 20px;">
                                                                <div class = "col-md-1"></div>
                                                                <div class = "col-md-5">
                                                                    <input type="checkbox" class = "emp_checklist icheckbox_minimal-blue" value = "HR HEAD REQUEST" required><b>HR Head Request</b>
                                                                </div>
                                                                <div class = "col-md-6"></div>
                                                            </div>
                                                            <div class = "row" style = "padding-top : 20px;">
                                                                <div class = "col-md-1"></div>
                                                                <div class = "col-md-5">
                                                                    <input type="checkbox" class = "emp_checklist icheckbox_minimal-blue" value = "BGC REPORT" required><b>BGC Report</b>
                                                                </div>
                                                                <div class = "col-md-6"></div>
                                                            </div>
                                                            <div class = "row" style = "padding-top : 20px;">
                                                                <div class = "col-md-1"></div>
                                                                <div class = "col-md-5">
                                                                    <input type="checkbox" class = "emp_checklist icheckbox_minimal-blue" value = "PDRN RESIDENTIAL CHECKING" required><b>PDRN Residential Checking</b>
                                                                </div>
                                                                <div class = "col-md-6"></div>
                                                            </div>
                                                            <div class = "row" style = "padding-top : 20px; padding-bottom : 10px;">
                                                                <div class = "col-md-1"></div>
                                                                <div class = "col-md-5">
                                                                    <input type="checkbox" class = "emp_checklist icheckbox_minimal-blue" value = "SSS RESULT" required><b>SSS Result</b>
                                                                </div>
                                                                <div class = "col-md-6"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class = "row">
                                                    <div class = "col-md-2"></div>
                                                    <div class = "col-md-8">
                                                        <div class = "box box-danger">
                                                            <center><h4 style = "font-family: Georgia,serif;">Accountabilities/Equipments</h4></center>
                                                            <div class = "row" style = "padding-top : 30px; padding-bottom : 10px;">
                                                                <div class = "col-md-1"></div>
                                                                <div class = "col-md-5">
                                                                    <div class = "row" style = "padding-top: 20px;">
                                                                        <div class = "col-md-12">
                                                                            <input type="checkbox" class = "emp_checklist icheckbox_minimal-blue" value = "ATM" required><b>ATM</b>
                                                                        </div>
                                                                    </div>
                                                                    <div class = "row" style = "padding-top: 20px;">
                                                                        <div class = "col-md-12">
                                                                            <input type="checkbox" class = "emp_checklist icheckbox_minimal-blue" value = "ID" required><b>ID</b>
                                                                        </div>
                                                                    </div>
                                                                    <div class = "row" style = "padding-top: 20px;">
                                                                        <div class = "col-md-12">
                                                                            <input type="checkbox" class = "emp_checklist icheckbox_minimal-blue" value = "GMAIL & PASSWORD/CCSI EMAIL" required><b>Gmail & Password/CCSI Email</b>
                                                                        </div>
                                                                    </div>
                                                                    <div class = "row" style = "padding-top: 20px;">
                                                                        <div class = "col-md-12">
                                                                            <input type="checkbox" class = "emp_checklist icheckbox_minimal-blue" value = "PHONE/IP PHONE" required><b>Phone/IP Phone</b>
                                                                        </div>
                                                                    </div>
                                                                    <div class = "row" style = "padding-top: 20px;">
                                                                        <div class = "col-md-12">
                                                                            <input type="checkbox" class = "emp_checklist icheckbox_minimal-blue" value = "NUMBER" required><b>Number</b>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class = "col-md-2"></div>
                                                                <div class = "col-md-4">
                                                                    <div id = "officeChecklist">
                                                                        <div class = "row" style = "padding-top: 20px;">
                                                                            <div class = "col-md-12">
                                                                                <input type="checkbox" class = "emp_checklist icheckbox_minimal-blue" value = "COMPUTER" required><b>Computer</b>
                                                                            </div>
                                                                        </div>
                                                                        <div class = "row" style = "padding-top: 20px;">
                                                                            <div class = "col-md-12">
                                                                                <input type="checkbox" class = "emp_checklist icheckbox_minimal-blue" value = "FB(IF NEEDED)"><b>FB(IF NEEDED)</b>
                                                                            </div>
                                                                        </div>
                                                                        <div class = "row" style = "padding-top: 20px;">
                                                                            <div class = "col-md-12">
                                                                                <input type="checkbox" class = "emp_checklist icheckbox_minimal-blue" value = "BIOMETRICS" required><b>Biometrics</b>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div id = "ciChecklist">
                                                                        <div class = "row" style = "padding-top: 20px;">
                                                                            <div class = "col-md-12">
                                                                                <input type="checkbox" class = "emp_checklist icheckbox_minimal-blue" value = "INSURANCE" required><b>Insurance</b>
                                                                            </div>
                                                                        </div>
                                                                        <div class = "row" style = "padding-top: 20px;">
                                                                            <div class = "col-md-12">
                                                                                <input type="checkbox" class = "emp_checklist icheckbox_minimal-blue" value = "SHELLCARD"><b>Shellcard</b>
                                                                            </div>
                                                                        </div>
                                                                        <div class = "row" style = "padding-top: 20px;">
                                                                            <div class = "col-md-12">
                                                                                <input type="checkbox" class = "emp_checklist icheckbox_minimal-blue" value = "UNIFORM" required><b>Uniform</b>
                                                                            </div>
                                                                        </div>
                                                                        <div class = "row" style = "padding-top: 20px;">
                                                                            <div class = "col-md-12">
                                                                                <input type="checkbox" class = "emp_checklist icheckbox_minimal-blue" value = "AUTHORIZATION" required><b>Autorization</b>
                                                                            </div>
                                                                        </div>
                                                                        <div class = "row" style = "padding-top: 20px;">
                                                                            <div class = "col-md-12">
                                                                                <input type="checkbox" class = "emp_checklist icheckbox_minimal-blue" value = "INTRODUCTION LETTER" required><b>Introduction Letter</b>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class = "col-md-2"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="box box-info" >
                                                <div class = "row">
                                                    <center>
                                                        <h3 style = "font-family: Georgia,serif;">Compensation</h3>
                                                    </center>
                                                </div>
                                                <div class = "row">
                                                    <div class="col-md-4">
                                                        <label>Salary Offer:<small style = "color:red;">*Required field</small></label>
                                                        <label for="emp_salary"></label><input type = "text" class="form-control" id="emp_salary">
                                                    </div>
                                                    <div class = "col-md-4"></div>
                                                    <div class="col-md-4">
                                                        <label>Minimum Wage on Location</label>
                                                        <input type = "text" class="form-control" id="empWage">
                                                    </div>
                                                </div>
                                                <div class = "row" style = "padding-bottom: 20px;">
                                                    <div class = "col-md-4">
                                                        <label for="">Rate:</label>
                                                        <select id = "empRate" class = "form-control">
                                                            <option value="Daily">Daily</option>
                                                            <option value="Monthly">Monthly</option>
                                                        </select>
                                                    </div>
                                                    <div class = "col-md-4"></div>
                                                    <div class = "col-md-4">
                                                        <span id = "allowanceRemove">
                                                            <label for="">Allowances: <small style = "color : red;">*if applicable</small></label>
                                                            <input type="text" id = "emp_allowances" class = "form-control">
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="pull-right" id = "submitDiv" style="margin-right: 10px;">
                                            <button type = "button" id ="submitProfile" class = "btn btn-success btn-lg pull-right">Create Profile</button>
                                            <button type = "button" id ="update_Profile" class = "btn btn-info btn-lg pull-right">Update Profile</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab_Info2">
                                <div class = "row">
                                    <div class = "box-body">
                                        <button type="button" class="btn btn-block btn-default btn-lg" id = "add_work_experience"><span class = "glyphicon glyphicon-plus" ></span>Add a work experience </button>
                                    </div>
                                    <div class="box-body">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Employee Name:</label>
                                                    <select class="form-control select2" style="width: 100%;" id="expSelectedId1" name = "expSelectedName1">
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <form id = "itemExp">
                                        <div id = "add_work_details">
                                            <div class="col-md-12">
                                                <table class="table table-bordered table-hover dataTable" id="tblExp" width="100%">
                                                    <thead>
                                                    <tr>
                                                        <th>Company Name</th>
                                                        <th>Company Address</th>
                                                        <th>Position</th>
                                                        <th>Start Date</th>
                                                        <th>End Date</th>
                                                        <th>Contact Number</th>
                                                        <th>Action</th>
                                                    </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                        <div id = "submitDiv">
                                            <button type = "button" id ="submitExperience" style = "margin-top : 50px; margin-right: 20px;" class = "btn btn-success pull-right"><i class = "fa fa-fw fa-plus"></i>Submit Experience</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab_Info3">
                                <div class = "row">
                                    <div class = "box-body">
                                        <button type="button" class="btn btn-block btn-default btn-lg" id = "add_education_record"><span class = "glyphicon glyphicon-plus" ></span>Add Education</button>
                                    </div>
                                    <div class="box-body">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Employee Name:</label>
                                                    <select class="form-control select2" style="width: 100%;" id="expSelectedId2" name = "expSelectedName2">
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <form id = "itemEduc">
                                        <div id = "add_education_tab">
                                            <div class="col-md-12">
                                                <table class="table table-bordered table-hover dataTable" id="tblEduc" width="100%">
                                                    <thead>
                                                    <tr>
                                                        <th>Level</th>
                                                        <th>School Name</th>
                                                        <th>School Address</th>
                                                        <th>Year Graduated</th>
                                                        <th>Course<small style = "color:red">(if applicable)</small></th>
                                                        <th>Action</th>
                                                    </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                            <div id = "submitDivEduc">
                                                <button type = "button" id ="submitEducation" style = "margin-top : 50px; margin-right: 20px;" class = "btn btn-success pull-right"><i class = "fa fa-fw fa-plus"></i>Submit Education</button>
                                            </div>
                                        </div>

                                    </form>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab_Info4">
                                <div class = "row">
                                    <div class = "box-body">
                                        <button type="button" class="btn btn-block btn-default btn-lg" id = "add_reference"><span class = "glyphicon glyphicon-plus" ></span>Add Character Reference</button>
                                    </div>
                                    <div class="box-body">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Employee Name:</label>
                                                    <select class="form-control select2" style="width: 100%;" id="expSelectedId3" name = "expSelectedName3">
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <form id = "itemRef">
                                        <div id = "add_ref">
                                            <div class="col-md-12">
                                                <table class="table table-bordered table-hover dataTable" id="tblRef" width="100%">
                                                    <thead>
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>Position</th>
                                                        <th>Company Name</th>
                                                        <th>Contact Number</th>
                                                        <th>Action</th>
                                                    </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                        <div id = "submitDivRef">
                                            <button type = "submit" id ="submitReference" style = "margin-top : 50px; margin-right: 20px;" class = "btn btn-success pull-right"><i class = "fa fa-fw fa-plus"></i>Submit Character</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="tab_mainEmp2">
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li class="active"><a id="tabstatus1" href="#tab_stat1" data-toggle="tab" class = "human_resources_status_class">Employee Status</a></li>
                            <li><a id="tabstatus4" href="#tab_stat4" data-toggle="tab" class = "human_resources_status_class">List of Position Changes</a></li>
                        </ul>
                        <div class = "tab-content">
                            <div class="tab-pane active" id="tab_stat1">
                                <div class="box-body">
                                    <div class="body">
                                        <div class="col-md-4">
                                            <div class="box box-info">
                                                <div class = "row">
                                                    <center>
                                                        <h3 style = "font-family: Georgia,serif;">Contract Status</h3>
                                                    </center>
                                                </div>
                                                <div class = "row" style = "padding-top : 10px;">
                                                    <div class="col-md-8">
                                                        <div class="form-group">
                                                            <label>Employee Name:</label>
                                                            <select class="form-control select2" style="width: 100%;" id="empStatusId" name = "empStatusId">
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class = "col-md-4"></div>
                                                </div>
                                                <div class = "row"  style = "padding-top : 10px;" >
                                                    <div class = "col-md-6">
                                                        <label>Position:</label>
                                                        <input type = "text" id = "pos_status" class = "form-control" value = "" disabled>
                                                    </div>
                                                </div>
                                                <div class = "row"  style = "padding-top : 10px;">
                                                    <div class = "col-md-6">
                                                        <label>Date Hired:</label>
                                                        <input type = "date" id = "hired_status" class = "form-control" value = "" disabled>
                                                    </div>
                                                </div>
                                                <div class = "row"  style = "padding-top : 10px;">
                                                    <div class = "col-md-6">
                                                        <label for="start_date">Contract Duration: </label>
                                                        <input type = "date" id = "start_date" class = "form-control" value = "" disabled>
                                                    </div>
                                                    <div class = "col-md-1">
                                                        <center>
                                                            <h4 style="margin-top:30px;">to</h4>
                                                        </center>
                                                    </div>
                                                    <div class = "col-md-5">
                                                        <input style="margin-top:25px;" type = "date" id = "end_date" class = "form-control" value = "">
                                                        <span id ="statusRed" style = "color: red">
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class = "row"  style = "padding-top : 10px;">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Status:</label>
                                                            <label for="contract_status"></label><select class="form-control" style="width: 100%;" id="contract_status">
                                                                <option value = "Probationary">Probationary</option>
                                                                <option value = "Regular">Regular</option>
                                                                <option value = "Off-Boarding">Off-Boarding</option>
                                                                <option value = "Part Time">Part Time</option>
                                                                <option value = "Fixed Term">Fixed Term</option>
                                                                <option value = "Project Based">Project Based</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class = "row" id = "outDiv" style = "padding-top : 10px;">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Off-Boarding Status:</label>
                                                            <label for="out_status"></label><select class="form-control" style="width: 100%;" id="out_status">
                                                                <option value = "Resigned">Resigned</option>
                                                                <option value = "AWOL">AWOL</option>
                                                                <option value = "End of Contract">End of Contract</option>
                                                                <option value= "Termination">Termination</option>
                                                                <option value= "Redundancy">Redundancy</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class = "row" style = "padding-top : 10px; padding-bottom : 10px;">
                                                    <div class = "col-md-6">
                                                        <label for="">Contract Document: <small style = "color:red;">*required field</small></label>
                                                        <input type="file" id = "contract_file">
                                                    </div>
                                                </div>
                                                <div class = "row" >
                                                    <div class = "col-md-6"   id = "showContractLaman">

                                                    </div>
                                                </div>
                                                <div class = "" style = "margin-top : 20px;">
                                                    <button type = "button" id ="update_status" style = "margin-right: 20px;"  class = "btn btn-success pull-right">Update Status</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="box box-info">
                                                <h3 style = "font-family: Georgia,serif; text-align: center; padding-bottom : 20px;">Employees</h3>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <table id = "human-resources-contract-status" class="tableendorse display table-hover table-condensed" width="100%">
                                                            <thead>
                                                            <tr>
                                                                <th>ID</th>
                                                                <th>Employee Name</th>
                                                                <th>Position</th>
                                                                <th>Branch</th>
                                                                <th>Contract Status</th>
                                                                <th>Off-Boarding Status</th>
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
                            <div class="tab-pane" id="tab_stat4">
                                <div class = "box-body">
                                    <h3 style = "font-family: Georgia,serif; text-align: center; padding-bottom : 20px;">Change of Position Monitoring</h3>
                                        <div class = "row">
                                            <div class = "col-md-12">
                                                <table id = "human-resources-show-promotion" class="tableendorse display table-hover table-condensed" width="100%">
                                                    <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Employee Name</th>
                                                        <th>Branch</th>
                                                        <th>Change of Position Type</th>
                                                        <th>Transition of Position</th>
                                                        <th>Transition of Allowances</th>
                                                        <th>Supporting Document/Remarks</th>
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
    </section>
</div>
