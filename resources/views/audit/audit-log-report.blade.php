<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Audit Log Report <small>Control Panel</small>
        </h1>
    </section>
    <section class = "content">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs print" >
                <li class="active"><a id="tabA" href="#tab_log1" data-toggle="tab" class = "audit_forms_tab_class">AUDIT FORMS</a></li>
                <li><a id="tabB" href="#tab_log2" data-toggle="tab" class = "audit_forms_tab_class">REPORT MONITORING</a></li>
            </ul>
            <div class = "tab-content">
                <div class="tab-pane active" id="tab_log1">
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs print"  >
                            <li class="active"><a id="tabForms1" href="#tab_form1" data-toggle="tab" class = "audit_all_form_class">AUDIT REPORT/DISCREPANCY FORM</a></li>
                            <li><a id="tabForms2" href="#tab_form2" data-toggle="tab" class = "audit_all_form_class">FIELD/PHONE CHECKING REPORT</a></li>
                            {{--<li><a id="tabForms3" href="#tab_form3" data-toggle="tab" class = "audit_all_form_class">PHONE CHECKING REPORT</a></li>--}}
                            {{--<li><a id="tabForms4" href="#tab_form4" data-toggle="tab" class = "audit_all_form_class">DISCREPANCY FORM</a></li>--}}
                            <li><a id="tabForms5" href="#tab_form5" data-toggle="tab" class = "audit_all_form_class">EXPENSE VALIDATION FORM (Coming soon..)</a></li>
                            <li><a id="tabForms6" href="#tab_form6" data-toggle="tab" class = "audit_all_form_class">CI REPORT CHECKING FORM</a></li>
                        </ul>
                        <div class = "tab-content">


                            {{--AUDIT REPORT   --}}

                            {{--floyd bago--}}
                            <div class="tab-pane active" id="tab_form1">
                                <div class = "box-body">
                                    <div class = "row">
                                        <div class = "col-md-3">
                                            <div class="box box-danger hideThis" >
                                                <div class="col-md-12" style="padding-top: 10px;">
                                                    <label>Audit Logs <br>
                                                        <small style="color:red; cursor: help;">*NOTE: Click a log to retrieve the data.</small></label>
                                                    <span class="audits_log_table">
                                                        <table style="table-layout: auto;word-wrap: break-word; width: 100%;" class="table-hover">
                                                            <tr style="background-color: black; color: white;">
                                                                <th>Activity Logs</th>
                                                            </tr>
                                                            <tr>
                                                                <td>No records found</td>
                                                            </tr>
                                                        </table>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class = "col-md-9">
                                            <div class = "box box-danger" >
                                                <div class = "row" style = "padding-top : 30px;">
                                                    <div class = "col-md-12">
                                                        <div class = "row hideThis" style = "padding-top :10px; padding-bottom : 20px;" >
                                                            <div class = "col-md-3">
                                                                <input type="radio" name = "selectTypeFormRadioArf" id = "optionAudit" checked="checked" class="log_checker"> <b>Audit Report Form</b>
                                                            </div>
                                                            <div class = "col-md-3">
                                                                <input type="radio" name = "selectTypeFormRadioArf" id = "optionDesc" class="log_checker"> <b>Discrepancy Form</b>
                                                            </div>
                                                            <div class = "col-md-3"></div>
                                                            <div class = "col-md-3">
                                                                <button class = "btn btn-info btn-lg pull-right" id = "newFormArf">CREATE NEW</button>
                                                            </div>
                                                        </div>
                                                        <table class="table-condensed printThis" style = "overflow-x:auto; border-collapse:collapse; table-layout:fixed; width : 100%;">
                                                            <tr>
                                                                <th colspan="5" style = "background-color: black; color : white;">ACCOUNT INFORMATION</th>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="3" style="font-weight:bold;">OIMS ID NUMBER</td>
                                                                <td colspan = "2"></td>
                                                            </tr>
                                                            <tr>
                                                                <td style="font-weight:bold;">
                                                                    Type in OIMS Number
                                                                </td>
                                                                <td>
                                                                    <span class = "hideThis"><button type = "button" class = "btn btn-block btn-warning print" style = "font-weight:bold;" id = "search_oims_bank_id">SEARCH</button></span>
                                                                </td>
                                                                <td>
                                                                    {{--<span class="ui-widget">--}}
                                                                    <input type="text" id = "autoComId" name = "autoComId" class = "form-control" placeholder = "Enter OIMS number">
                                                                    {{--</span>--}}
                                                                </td>
                                                                <td>
                                                                    <span class = "hideThis"><button type = "button" class = "btn btn-block btn-primary print" style = "font-weight:bold;" id = "audit_report_form_messenger">MESSENGER</button></span>
                                                                </td>
                                                                <td>

                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="3" style="font-weight:bold;">BORROWER'S NAME AND COMPANY</td>
                                                                <td style="font-weight:bold;">CLIENT</td>
                                                                <td>
                                                                    <input type="text" class = "messenger_type form-control" id="client_name" disabled>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="3">
                                                                    <input  type="text" class = "messenger_type form-control" id="full_name_company" placeholder = "Full Name/Company Name" disabled>
                                                                </td>
                                                                <td style="font-weight:bold;">REQUEST: </td>
                                                                <td>
                                                                    <input type="text" class = " messenger_type form-control" id="type_of_request" disabled>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="3" style="font-weight:bold;">BUSINESS NAME</td>
                                                                <td style="font-weight:bold;">ENDORSEMENT DATE: </td>
                                                                <td>
                                                                    <input type="text" class = "messenger_type date_change form-control" id="endorsement_date" disabled>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="3">
                                                                    <input type="text" class= "messenger_type form-control" id="business_name" placeholder="Business Name" disabled>
                                                                </td>
                                                                <td style="font-weight:bold;">SUBMISSION DATE:</td>
                                                                <td>
                                                                    <input type="text" class = "messenger_type date_change form-control" id="submission_date" disabled>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="3" style="font-weight:bold;">ADDRESS:</td>
                                                                <td style="font-weight:bold;">INTERNAL TAT COM:</td>
                                                                <td>
                                                                    <input type="text" class = "messenger_type form-control" id="internal_tat" disabled>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="3">
                                                                    <input type="text" class= " messenger_type form-control" id="full_address" placeholder="Address" disabled>
                                                                </td>
                                                                <td style="font-weight:bold;">EXTERNAL TAT COM:</td>
                                                                <td>
                                                                    <input type="text" class = "messenger_type form-control" id="external_tat" disabled>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="3" style = "text-decoration: underline; font-weight:bold; background-color: skyblue;">SPECIAL INSTRUCTIONS FROM THE CLIENT</td>
                                                                <td colspan="2" style = "text-decoration: underline; font-weight:bold; background-color: skyblue;">TYPE OF CHECKING</td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="3">
                                                                    <input type="text" class= "messenger_type form-control" id="special_instruction" placeholder="Special Instructions" disabled>
                                                                </td>
                                                                <td colspan="2">
                                                                    <input type="text" class= "messenger_type form-control" id="type_of_checking" placeholder="Type of Checking" disabled>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th colspan="5" style = "background-color: black; color : white;">BACKGROUND INFORMATION</th>
                                                            </tr>
                                                            <tr>
                                                                <td style="font-weight:bold;">EMPLOYEE: </td>
                                                                <td>
                                                                    <input type="text" class="form-control" placeholder="Last Name" id = "last_name_arf">
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control" placeholder="First Name" id = "f_name_arf">
                                                                </td>
                                                                <td>
                                                                    <input type="text" class = "form-control" placeholder="Emp ID" id = "emp_id_arf">
                                                                </td>
                                                                <td>
                                                                    <span class = "hideThis"><button type = "button" class = "btn btn-block btn-warning " style = "font-weight:bold;" id = "">SEARCH</button></span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style="font-weight:bold;">DEPARTMENT: </td>
                                                                <td colspan="4">
                                                                    <input type="text" class = "form-control" id = "dept_arf">
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style="font-weight:bold;">JOB TITLE: </td>
                                                                <td colspan="4">
                                                                    <input type="text" class = "form-control" id = "job_title_arf" >
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style="font-weight:bold;">DATE HIRED: </td>
                                                                <td colspan="4">
                                                                    <input type="date" class = " form-control" id = "date_hired_arf">
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style="font-weight:bold;">FINDINGS: </td>
                                                                <td colspan="4">
                                                                    <textarea rows="2" style="overflow: auto; resize: none;" class = "form-control" id = "findings_arf"></textarea>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style="font-weight:bold;">INVESTIGATION TAKEN: </td>
                                                                <td colspan="4">
                                                                    <textarea rows="2" style="overflow: auto; resize: none;" class = "form-control" id = "investigation_arf"></textarea>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style="font-weight:bold;">VALIDATION RESULTS: </td>
                                                                <td colspan="4">
                                                                    <textarea rows="2" style="overflow: auto; resize: none;" class = "form-control" id = "valid_res_arf"></textarea>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style="font-weight:bold;">STATEMENTS: </td>
                                                                <td colspan="4">
                                                                    <textarea rows="2" style="overflow: auto; resize: none;" class = "form-control" id = "statements_arf"></textarea>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style="font-weight:bold;">OBSERVATIONS: </td>
                                                                <td colspan="4">
                                                                    <textarea rows="2" style="overflow: auto; resize: none;" class = "form-control" id = "obs_arf"></textarea>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style="font-weight:bold;">RECOMMENDATIONS: </td>
                                                                <td colspan="4">
                                                                    <textarea rows="2" style="overflow: auto; resize: none;" class = "form-control" id = "recom_arf"></textarea>
                                                                </td>
                                                            </tr>
                                                            <tr class = "hideThis">
                                                                <td colspan="5" height="80px">
                                                                </td>
                                                            </tr>

                                                            <tr class = "hideThis">
                                                                <td>

                                                                </td>
                                                                <td>
                                                                    {{--<button class="btn btn-block btn-primary btn-lg" id="clickToFileArf"><span id = "toUploadStatArf">Upload Attachment</span></button><input type="file" id="upload_arf" style = "display: none">--}}
                                                                    <button class="btn btn-block btn-primary btn-lg show_uploader" id="show_uploader_discrep">Upload Attachment</button>
                                                                    <button class="btn btn-block btn-danger btn-lg" id="hide_uploader_discrep" style="display: none;">Close Uploader</button>
                                                                </td>
                                                                <td>
                                                                    <a class="btn btn-block btn-success btn-lg" id = "viewAttachSavedArf" > View Attachment</a>
                                                                </td>
                                                                <td>
                                                                    <button class="btn btn-block btn-primary btn-lg" id = "dlAttachmentCiReport">Download Attachment</button><span id = "downSpanAuditForm" hidden></span>
                                                                </td>
                                                                <td>

                                                                </td>
                                                            </tr>

                                                            <tr class = "hideThis" id="thisisUploadedDiscrep" hidden>
                                                                <td colspan="1" class="hideThis">

                                                                </td>
                                                                <td colspan="3" class="hideThis">
                                                                    <div id="uploaded_holder"></div>
                                                                </td>
                                                                <td colspan="1" class="hideThis">

                                                                </td>
                                                            </tr>
                                                            
                                                            <tr class = "hideThis" id="thisisUploaderDiscrep" hidden>
                                                                <td colspan="1" class="hideThis">

                                                                </td>
                                                                <td colspan="3" class="hideThis">
                                                                    <div id="qq-audit-discrepancy-form-fine-holder"></div>
                                                                </td>
                                                                <td colspan="1" class="hideThis">

                                                                </td>
                                                            </tr>
                                                            
                                                            <tr class = "hideThis">
                                                                <td colspan="5" height="80px">
                                                                </td>
                                                            </tr>
                                                            <tr class = "hideThis">
                                                                <td>
                                                                    <button class="btn btn-block btn-primary btn-lg" id = "audit_form_print">PRINT</button>
                                                                </td>
                                                                <td>
                                                                    <button class="btn btn-block btn-info btn-lg" id = "btn_save_arf">SAVE</button>
                                                                </td>
                                                                <td>
                                                                    <button class="btn btn-block btn-warning btn-lg" id = "btn_edit_arf_details" disabled>EDIT</button>
                                                                </td>
                                                                <td>
                                                                    <button class="btn btn-block btn-danger btn-lg" id = "btn_delete_arf">DELETE</button>
                                                                </td>
                                                                <td>
                                                                    <button class="btn btn-block btn-success btn-lg" id = "btn_send_arf" name = "without">SUBMIT</button>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{--CSSF CHECKING--}}

                            <div class="tab-pane" id="tab_form2">
                                <div class="box-body">
                                    <div class="row">
                                        <div class = "col-md-3">
                                            <div class="box box-danger hideThis">
                                                <div class="col-md-12" style="padding-top: 10px;">
                                                    <label>Audit Logs <br>
                                                        <small style="color:red; cursor: help;">*NOTE: Click a log to retrieve the data.</small></label>
                                                    <span class="audits_log_table">
                                                        <table style="table-layout: auto;word-wrap: break-word; width: 100%;" class="table-hover">
                                                            <tr style="background-color: black; color: white;">
                                                                <th>Activity Logs</th>
                                                            </tr>
                                                            <tr>
                                                                <td>No records found</td>
                                                            </tr>
                                                        </table>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="box box-danger">
                                                <div class="row" style="padding-top:30px;">
                                                    <div class="col-md-12">
                                                        <div class = "row hideThis" style = "padding-top :10px; padding-bottom : 20px;" >
                                                            <div class = "col-md-3">
                                                                <input type="radio" name = "selectTypeFormPhoneField" id = "optionField" checked="checked" class="log_checker2"> <b>Field Checking Form</b>
                                                            </div>
                                                            <div class = "col-md-3">
                                                                <input type="radio" name = "selectTypeFormPhoneField" id = "optionPhone" class="log_checker2"> <b>Phone Checking Form</b>
                                                            </div>
                                                            <div class = "col-md-3"></div>
                                                            <div class = "col-md-3">
                                                                <button class = "btn btn-info btn-lg pull-right" id = "newFormPf">CREATE NEW</button>
                                                            </div>
                                                        </div>
                                                        <table class="table-condensed printThis" style = "overflow-x:auto; border-collapse:collapse; table-layout:fixed; width : 100%; font-weight: bold;">
                                                            <tr>
                                                                <th colspan="5" style = "background-color: black; color : white;">ACCOUNT INFORMATION</th>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="3" style="font-weight:bold;">
                                                                    OIMS ID NUMBER
                                                                </td>
                                                                <td colspan = "1">
                                                                    AUDIT LOGGED:
                                                                </td>
                                                                <td colspan = "1">
                                                                    <input type="text" class="form-control" id = "log_time_ph_field"  disabled>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="1">
                                                                    <span class = "hideThis"><button type = "button" class = "btn btn-block btn-warning print" style = "font-weight:bold;" id = "search_oims_bank_field_phone">SEARCH</button></span>
                                                                </td>
                                                                <td colspan="1">
                                                                    <input type="text" class = "form-control" id = "oimsIdPhoneField" placeholder = "Enter OIMS number">
                                                                </td>
                                                                <td colspan="1">
                                                                    <span class = "hideThis"><button type = "button" class = "btn btn-block btn-primary" style = "font-weight:bold;" id = "removeValandDis">MESSENGER</button></span>
                                                                </td>
                                                                <td colspan="1">
                                                                    AUDITOR
                                                                </td>
                                                                <td colspan="1">
                                                                    <input type="text" class="form-control" id ="name_auditor_phone_field"   disabled>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="3">
                                                                    BORROWER’s NAME and COMPANY:
                                                                </td>
                                                                <td colspan="1">
                                                                    FINDINGS
                                                                </td>
                                                                <td colspan="1">
                                                                    <select class="form-control" id = "remCompliance">
                                                                        <option>---</option>
                                                                        <option>COMPLIANCE</option>
                                                                        <option>SEE REMARKS</option>
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="3">
                                                                    <input type="text" id = "fieldPhoneComNameSubj" placeholder="Full Name/Company Name" class="form-control" disabled>
                                                                </td>
                                                                <td colspan="1">
                                                                    DONE THRU
                                                                </td>
                                                                <td colspan="1">
                                                                    <input type="text" id = "doneThruPhoneField" class="form-control" placeholder="Enter if FIELD or CONTACT NUMBER">
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="3">
                                                                    BUSINESS NAME:
                                                                </td>
                                                                <td colspan="1">
                                                                    CLIENT
                                                                </td>
                                                                <td colspan="1">
                                                                    <input type="text" class="form-control" id = "client_name_phone_field" disabled>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="3">
                                                                    <input type="text" class="form-control" disabled placeholder="Business name" id ="busName_ph_field">
                                                                </td>
                                                                <td colspan="1">
                                                                    REQUEST
                                                                </td>
                                                                <td colspan="1">
                                                                    <input type="text" id = "tor_field_phone" class="form-control" disabled>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="3">
                                                                    ADDRESS:
                                                                </td>
                                                                <td colspan="1">
                                                                    ENDORSEMENT DATE :
                                                                </td>
                                                                <td colspan="1">
                                                                    <input type="text" id = "date_endorsed_phone_field" class="form-control" disabled>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="3">
                                                                    <input type="text" class="form-control" id = "address_phone_field" disabled>
                                                                </td>
                                                                <td colspan="1">
                                                                    DATE VISITED BY CI:
                                                                </td>
                                                                <td colspan="1">
                                                                    <input type="text" id = "ci_visit_ph_field" class="form-control" disabled>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="3" style="background-color: skyblue;">
                                                                    <u>SPECIAL INSTRUCTIONS FROM THE CLIENT:</u>
                                                                </td>
                                                                <td colspan="2" style="background-color: skyblue;">
                                                                    <u>TYPE OF CHECKING:</u>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="3">
                                                                    <input type="text" id = "spec_ins_phone_field" class="form-control" disabled>
                                                                </td>
                                                                <td colspan="2">
                                                                    <input type="text" id = "toc_phone_field" class="form-control" disabled>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="5" style="background-color: black; color: white;">
                                                                    BACKGROUND
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="1">
                                                                    EMPLOYEE:
                                                                </td>
                                                                <td>
                                                                    <input type="text" id = "emp_last_name" class="form-control" placeholder="Last name">
                                                                </td>
                                                                <td>
                                                                    <input type="text" id = "emp_first_name" class="form-control" placeholder="First name">
                                                                </td>
                                                                <td>
                                                                    <input type="text" id = "emp_id" placeholder="Emp ID" class="form-control">
                                                                </td>
                                                                <td>
                                                                    <span class = "hideThis"><button type = "button" class = "btn btn-block btn-warning" style = "font-weight:bold;" >SEARCH</button></span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="1">
                                                                    DEPARTMENT:
                                                                </td>
                                                                <td colspan="4">
                                                                    <input type="text" id = "emp_dept_ph_field" class="form-control">
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="1">
                                                                    JOB TITLE:
                                                                </td>
                                                                <td colspan="4">
                                                                    <input type="text" id="title_job_phone_field" class="form-control" >
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="1">
                                                                    DATE HIRED:
                                                                </td>
                                                                <td colspan="4">
                                                                    <input type="date" id = "date_hired_ph_field" class="form-control" >
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="5" style="background-color: black; color: white;">
                                                                    COMPLIANCE CHECKLIST
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="3">
                                                                    1. Was our personnel in uniform?
                                                                </td>
                                                                <td colspan="2">
                                                                    <select class="form-control ans_compliance" >
                                                                        <option>---</option>
                                                                        <option value="YES">YES</option>
                                                                        <option value="NO">NO</option>
                                                                        <option value="UNCERTAIN">UNCERTAIN</option>
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="3">
                                                                    2. Did our personnel presented his ID card?
                                                                </td>
                                                                <td colspan="2">
                                                                    <select class="form-control ans_compliance" >
                                                                        <option>---</option>
                                                                        <option value="YES">YES</option>
                                                                        <option value="NO">NO</option>
                                                                        <option value="UNCERTAIN">UNCERTAIN</option>
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="3">
                                                                    3. Did our personnel come in motorcycle?
                                                                </td>
                                                                <td colspan="2">
                                                                    <select class="form-control ans_compliance">
                                                                        <option>---</option>
                                                                        <option value="YES">YES</option>
                                                                        <option value="NO">NO</option>
                                                                        <option value="UNCERTAIN">UNCERTAIN</option>
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="3">
                                                                    4. Was our personnel respectful?
                                                                </td>
                                                                <td colspan="2">
                                                                    <select class="form-control ans_compliance">
                                                                        <option>---</option>
                                                                        <option value="YES">YES</option>
                                                                        <option value="NO">NO</option>
                                                                        <option value="UNCERTAIN">UNCERTAIN</option>
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="3">
                                                                    5. Was there any request by the personnel (coffe/water/etc) or favor asked during the interview?
                                                                </td>
                                                                <td colspan="2">
                                                                    <select class="form-control ans_compliance">
                                                                        <option>---</option>
                                                                        <option value="YES">YES</option>
                                                                        <option value="NO">NO</option>
                                                                        <option value="UNCERTAIN">UNCERTAIN</option>
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="3">
                                                                    6. Did the personnel give any contact information (telephone/mobile/email) of our company or his?
                                                                </td>
                                                                <td colspan="2">
                                                                    <select class="form-control ans_compliance">
                                                                        <option>---</option>
                                                                        <option value="YES">YES</option>
                                                                        <option value="NO">NO</option>
                                                                        <option value="UNCERTAIN">UNCERTAIN</option>
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="3">
                                                                    7. Did our personnel present an Introduction Letter?
                                                                </td>
                                                                <td colspan="2">
                                                                    <select class="form-control ans_compliance">
                                                                        <option>---</option>
                                                                        <option value="YES">YES</option>
                                                                        <option value="NO">NO</option>
                                                                        <option value="UNCERTAIN">UNCERTAIN</option>
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="3">
                                                                    8. Did our personnel offer assistance for your transaction? (Specify offered assistance)
                                                                </td>
                                                                <td colspan="2">
                                                                    <select class="form-control ans_compliance">
                                                                        <option>---</option>
                                                                        <option value="YES">YES</option>
                                                                        <option value="NO">NO</option>
                                                                        <option value="UNCERTAIN">UNCERTAIN</option>
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="3">
                                                                    9. How did our personnel introduce his self?
                                                                </td>
                                                                <td colspan="2">
                                                                    <input type="text" class="form-control ans_compliance">
                                                                    {{--<select class="form-control ans_compliance">--}}
                                                                        {{--<option>---</option>--}}
                                                                        {{--<option value="YES">YES</option>--}}
                                                                        {{--<option value="NO">NO</option>--}}
                                                                        {{--<option value="UNCERTAIN">UNCERTAIN</option>--}}
                                                                    {{--</select>--}}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="5" style="background-color: black; color: white;">
                                                                    INFORMANT VALIDATION
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="1">
                                                                    INFORMANTS' NAMES
                                                                </td>
                                                                <td colspan="1">
                                                                    RELATION TO SUBJECT
                                                                </td>
                                                                <td colspan="1">
                                                                    ADDRESS
                                                                </td>
                                                                <td colspan="1">
                                                                    EXISTENCE
                                                                </td>
                                                                <td colspan="1">
                                                                    REMARKS
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <input type="text" placeholder="1." class="form-control inform_valid_0 informant_clear" id = "informant_name_0">
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control inform_valid_0 informant_clear" id = "relation_0">
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control inform_valid_0 informant_clear" id = "address_0" >
                                                                </td>
                                                                <td>
                                                                    <select class="form-control inform_valid_0 informant_clear_select" id = "existence_0">
                                                                        <option>---</option>
                                                                        <option value="NEGATIVE">NEGATIVE</option>
                                                                        <option value="POSITIVE">POSITIVE</option>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control inform_valid_0 informant_clear" id = "remarks_0" >
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <input type="text" placeholder="2." class="form-control inform_valid_1 informant_clear" id = "informant_name_1">
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control inform_valid_1 informant_clear" id = "relation_1">
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control inform_valid_1 informant_clear" id = "address_1">
                                                                </td>
                                                                <td>
                                                                    <select class="form-control inform_valid_1 informant_clear_select" id = "existence_1">
                                                                        <option>---</option>
                                                                        <option value="NEGATIVE">NEGATIVE</option>
                                                                        <option value="POSITIVE">POSITIVE</option>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control inform_valid_1 informant_clear" id = "remarks_1" >
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <input type="text" placeholder="3." class="form-control inform_valid_2 informant_clear" id = "informant_name_2">
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control inform_valid_2 informant_clear" id = "relation_2">
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control inform_valid_2 informant_clear" id = "address_2">
                                                                </td>
                                                                <td>
                                                                    <select class="form-control inform_valid_2 informant_clear_select" id = "existence_2">
                                                                        <option>---</option>
                                                                        <option value="NEGATIVE">NEGATIVE</option>
                                                                        <option value="POSITIVE">POSITIVE</option>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control inform_valid_2 informant_clear" id = "remarks_2">
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <input type="text" placeholder="4." class="form-control inform_valid_3 informant_clear" id = "informant_name_3" >
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control inform_valid_3 informant_clear" id = "relation_3">
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control inform_valid_3 informant_clear"  id = "address_3">
                                                                </td>
                                                                <td>
                                                                    <select class="form-control inform_valid_3 informant_clear_select"  id = "existence_3">
                                                                        <option>---</option>
                                                                        <option value="NEGATIVE">NEGATIVE</option>
                                                                        <option value="POSITIVE">POSITIVE</option>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control inform_valid_3 informant_clear" id = "remarks_3">
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <input type="text" placeholder="5." class="form-control inform_valid_4 informant_clear" id = "informant_name_4">
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control inform_valid_4 informant_clear" id = "relation_4">
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control inform_valid_4 informant_clear" id = "address_4">
                                                                </td>
                                                                <td>
                                                                    <select class="form-control inform_valid_4 informant_clear_select" id = "existence_4">
                                                                        <option>---</option>
                                                                        <option value="NEGATIVE">NEGATIVE</option>
                                                                        <option value="POSITIVE">POSITIVE</option>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control inform_valid_4 informant_clear" id = "remarks_4">
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="5" style="background-color: black; color: white;">
                                                                    NEW INFORMANT GATHERED
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="1">
                                                                    INFORMANTS' NAMES
                                                                </td>
                                                                <td colspan="1">
                                                                    RELATION TO SUBJECT
                                                                </td>
                                                                <td colspan="2">
                                                                    ADDRESS
                                                                </td>
                                                                <td colspan="1">
                                                                    REMARKS
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="1">
                                                                    <input type="text" placeholder="1." class="form-control new_informant_0 informant_clear" id = "new_inf_name_0">
                                                                </td>
                                                                <td colspan="1">
                                                                    <input type="text" class="form-control new_informant_0 informant_clear" id = "new_relation_0">
                                                                </td>
                                                                <td colspan="2">
                                                                    <input type="text" class="form-control new_informant_0 informant_clear" id = "new_add_0">
                                                                </td>
                                                                <td colspan="1">
                                                                    <input type="text" class="form-control new_informant_0 informant_clear" id = "new_rem_0">
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="1">
                                                                    <input type="text" placeholder="2." class="form-control new_informant_1 informant_clear" id = "new_inf_name_1">
                                                                </td>
                                                                <td colspan="1">
                                                                    <input type="text" class="form-control new_informant_1 informant_clear" id = "new_relation_1">
                                                                </td>
                                                                <td colspan="2">
                                                                    <input type="text" class="form-control new_informant_1 informant_clear" id = "new_add_1">
                                                                </td>
                                                                <td colspan="1">
                                                                    <input type="text" class="form-control new_informant_1 informant_clear" id = "new_rem_1">
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="1">
                                                                    <input type="text" placeholder="3." class="form-control new_informant_2 informant_clear"  id = "new_inf_name_2">
                                                                </td>
                                                                <td colspan="1">
                                                                    <input type="text" class="form-control new_informant_2 informant_clear" id = "new_relation_2">
                                                                </td>
                                                                <td colspan="2">
                                                                    <input type="text" class="form-control new_informant_2 informant_clear" id = "new_add_2">
                                                                </td>
                                                                <td colspan="1">
                                                                    <input type="text" class="form-control new_informant_2 informant_clear" id = "new_rem_2">
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="5" style="background-color: black; color: white;">
                                                                    SUMMARY REPORT
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="5">
                                                                    <textarea style="height: 100px; resize: none; overflow: auto;" placeholder="Enter.." class="form-control" id = "summarty_report_field_phone"></textarea>
                                                                </td>
                                                            </tr>
                                                            <tr class = "hideThis">
                                                                <td colspan="1">

                                                                </td>
                                                                <td colspan="1">
                                                                    <button class="btn btn-block btn-primary btn-lg" id = "clickToFilePf">Upload Attachment</button>
                                                                    <button class="btn btn-block btn-danger btn-lg" id = "clickToFilePf-cancel" style="display: none">Close Uploader</button>
                                                                </td>
                                                                <td colspan="1">
                                                                    <a class="btn btn-block btn-success btn-lg" id = "viewAttachmentPhoneField" > View Attachment</a>
                                                                </td>
                                                                <td colspan="1">
                                                                    <button class="btn btn-block btn-primary btn-lg" id = "btn_download_ci_rep_pf">Download Attachment</button><span id = "dwnSpanPhoneFiled" hidden></span>
                                                                </td>
                                                                <td colspan="1">

                                                                </td>
                                                            </tr>

                                                            <tr class = "hideThis" id="FieldUploadedAttachments" hidden>
                                                                <td colspan="1">

                                                                </td>
                                                                <td colspan="3">
                                                                    <div id="fieldUploadedHolder"></div>
                                                                </td>
                                                                <td colspan="1">

                                                                </td>
                                                            </tr>

                                                            <tr class = "hideThis" id="FieldUploader" hidden>
                                                                <td colspan="1">

                                                                </td>
                                                                <td colspan="3">
                                                                    <div id="fieldUploaderDiv"></div>
                                                                </td>
                                                                <td colspan="1">

                                                                </td>
                                                            </tr>
                                                            <tr class = "hideThis">
                                                                <td colspan="5" style="height: 80px;">

                                                                </td>
                                                            </tr>
                                                            <tr class = "hideThis">
                                                                <td><button class="btn btn-block btn-primary btn-lg" id = "btn_print_phone_field" >PRINT</button></td>
                                                                <td><button class="btn btn-block btn-info btn-lg" id = "btn_save_phone_field">SAVE</button></td>
                                                                <td><button class="btn btn-block btn-warning btn-lg" id = "btn_edit_phone_field" disabled>EDIT</button></td>
                                                                <td><button class="btn btn-block btn-danger btn-lg" id = "btn_clear_phone_field">DELETE</button></td>
                                                                <td><button class="btn btn-block btn-success btn-lg" id = "btn_submit_phone_field" name = "without">SUBMIT</button></td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{--PHONE CHECKING REPORT--}}


                            {{--<div class="tab-pane" id="tab_form3">--}}


                            {{--<div class="box-body">--}}
                            {{--<div class = "row">--}}
                            {{--<div class = "col-md-3"></div>--}}
                            {{--<div class = "col-md-3"></div>--}}
                            {{--</div>--}}
                            {{--<div class="row">--}}
                            {{--<div class="col-md-1"></div>--}}
                            {{--<div class="col-md-10">--}}
                            {{--<div class="box box-danger">--}}
                            {{--<div class="row" style="padding-top:30px;">--}}
                            {{--<div class="col-md-12">--}}
                            {{--<div class="form-control" style="border:0;"><center>PHONE REPORT CHECKING</center></div>--}}
                            {{--<br>--}}
                            {{--<table class="table-condensed" style = "overflow-x:auto; border-collapse:collapse; table-layout:fixed; width : 100%; font-weight: bold;">--}}
                            {{--<tr>--}}
                            {{--<th colspan="5" style = "background-color: black; color : white;">ACCOUNT INFORMATION</th>--}}
                            {{--</tr>--}}
                            {{--<tr>--}}
                            {{--<td colspan="3" style="font-weight:bold;">--}}
                            {{--OIMS ID NUMBER--}}
                            {{--</td>--}}
                            {{--<td colspan = "1">--}}
                            {{--AUDIT LOGGED:--}}
                            {{--</td>--}}
                            {{--<td colspan = "1">--}}
                            {{--<input type="text" class="form-control"  placeholder = "(System Generated after submission)" disabled>--}}
                            {{--</td>--}}
                            {{--</tr>--}}
                            {{--<tr>--}}
                            {{--<td colspan="1">--}}
                            {{--Type of OIMS Number:--}}
                            {{--</td>--}}
                            {{--<td colspan="1" style="background-color: yellow">--}}
                            {{--SEARECH--}}
                            {{--</td>--}}
                            {{--<td colspan="1" >--}}
                            {{--<button type = "button" class = "btn btn-block btn-primary" style = "font-weight:bold;">MESSENGER</button>--}}
                            {{--</td>--}}
                            {{--<td colspan="1">--}}
                            {{--AUDITOR--}}
                            {{--</td>--}}
                            {{--<td colspan="1">--}}
                            {{--<input type="text" class="form-control"  placeholder = "(System Generated after submission)" disabled>--}}
                            {{--</td>--}}
                            {{--</tr>--}}
                            {{--<tr>--}}
                            {{--<td colspan="3">--}}
                            {{--BORROWER’s NAME and COMPANY:--}}
                            {{--</td>--}}
                            {{--<td colspan="1">--}}
                            {{--FINDINGS--}}
                            {{--</td>--}}
                            {{--<td colspan="1">--}}
                            {{--<select class="form-control">--}}
                            {{--<option>---</option>--}}
                            {{--<option>COMPLIANCE</option>--}}
                            {{--<option>SEE REMARKS</option>--}}
                            {{--</select>--}}
                            {{--</td>--}}
                            {{--</tr>--}}
                            {{--<tr>--}}
                            {{--<td colspan="1">--}}
                            {{--<input type="text" placeholder="LAST NAME" class="form-control" disabled>--}}
                            {{--</td>--}}
                            {{--<td colspan="1">--}}
                            {{--<input type="text" placeholder="FIRST NAME" class="form-control" disabled>--}}
                            {{--</td>--}}
                            {{--<td colspan="1">--}}
                            {{--<input type="text" placeholder="MIDDLE NAME" class="form-control" disabled>--}}
                            {{--</td>--}}
                            {{--<td colspan="1">--}}
                            {{--DONE THRU--}}
                            {{--</td>--}}
                            {{--<td colspan="1">--}}
                            {{--<input type="text" class="form-control" placeholder="Enter if FIELD or CONTACT NUMBER">--}}
                            {{--</td>--}}
                            {{--</tr>--}}
                            {{--<tr>--}}
                            {{--<td colspan="3">--}}
                            {{--BUSINESS NAME:--}}
                            {{--</td>--}}
                            {{--<td colspan="1">--}}
                            {{--CLIENT--}}
                            {{--</td>--}}
                            {{--<td colspan="1">--}}
                            {{--<input type="text" class="form-control" disabled>--}}
                            {{--</td>--}}
                            {{--</tr>--}}
                            {{--<tr>--}}
                            {{--<td colspan="3">--}}
                            {{--<input type="text" class="form-control" disabled placeholder="COMPANY NAME">--}}
                            {{--</td>--}}
                            {{--<td colspan="1">--}}
                            {{--REQUEST--}}
                            {{--</td>--}}
                            {{--<td colspan="1">--}}
                            {{--<input type="text" class="form-control" disabled>--}}
                            {{--</td>--}}
                            {{--</tr>--}}
                            {{--<tr>--}}
                            {{--<td colspan="3">--}}
                            {{--ADDRESS:--}}
                            {{--</td>--}}
                            {{--<td colspan="1">--}}
                            {{--ENDORSEMENT DATE :--}}
                            {{--</td>--}}
                            {{--<td colspan="1">--}}
                            {{--<input type="text" class="form-control" disabled>--}}
                            {{--</td>--}}
                            {{--</tr>--}}
                            {{--<tr>--}}
                            {{--<td colspan="3">--}}
                            {{--<input type="text" class="form-control" disabled>--}}
                            {{--</td>--}}
                            {{--<td colspan="1">--}}
                            {{--DATE VISITED BY CI:--}}
                            {{--</td>--}}
                            {{--<td colspan="1">--}}
                            {{--<input type="text" class="form-control" disabled>--}}
                            {{--</td>--}}
                            {{--</tr>--}}
                            {{--<tr>--}}
                            {{--<td colspan="3" style="background-color: skyblue;">--}}
                            {{--<u>SPECIAL INSTRUCTIONS FROM THE CLIENT:</u>--}}
                            {{--</td>--}}
                            {{--<td colspan="2" style="background-color: skyblue;">--}}
                            {{--<u>TYPE OF CHECKING:</u>--}}
                            {{--</td>--}}
                            {{--</tr>--}}
                            {{--<tr>--}}
                            {{--<td colspan="3">--}}
                            {{--<input type="text" class="form-control" disabled>--}}
                            {{--</td>--}}
                            {{--<td colspan="2">--}}
                            {{--<input type="text" class="form-control" disabled>--}}
                            {{--</td>--}}
                            {{--</tr>--}}
                            {{--<tr>--}}
                            {{--<td colspan="5" style="background-color: black; color: white;">--}}
                            {{--BACKGROUND--}}
                            {{--</td>--}}
                            {{--</tr>--}}
                            {{--<tr>--}}
                            {{--<td colspan="1">--}}
                            {{--EMPLOYEE:--}}
                            {{--</td>--}}
                            {{--<td colspan="2">--}}
                            {{--<input type="text" class="form-control" disabled placeholder="Last name, First name, Middle name">--}}
                            {{--</td>--}}
                            {{--<td>--}}
                            {{--<input type="text" placeholder="Emp ID" class="form-control">--}}
                            {{--</td>--}}
                            {{--<td style="background-color: yellow;">--}}
                            {{--SEARCH--}}
                            {{--</td>--}}
                            {{--</tr>--}}
                            {{--<tr>--}}
                            {{--<td colspan="1">--}}
                            {{--DEPARTMENT:--}}
                            {{--</td>--}}
                            {{--<td colspan="4">--}}
                            {{--<input type="text" class="form-control" disabled>--}}
                            {{--</td>--}}
                            {{--</tr>--}}
                            {{--<tr>--}}
                            {{--<td colspan="1">--}}
                            {{--JOB TITLE:--}}
                            {{--</td>--}}
                            {{--<td colspan="4">--}}
                            {{--<input type="text" class="form-control" disabled>--}}
                            {{--</td>--}}
                            {{--</tr>--}}
                            {{--<tr>--}}
                            {{--<td colspan="1">--}}
                            {{--DATE HIRED:--}}
                            {{--</td>--}}
                            {{--<td colspan="4">--}}
                            {{--<input type="text" class="form-control" disabled>--}}
                            {{--</td>--}}
                            {{--</tr>--}}
                            {{--<tr>--}}
                            {{--<td colspan="5" style="background-color: black; color: white;">--}}
                            {{--COMPLIANCE CHECKLIST--}}
                            {{--</td>--}}
                            {{--</tr>--}}
                            {{--<tr>--}}
                            {{--<td colspan="3">--}}
                            {{--1. Was our personnel in uniform?--}}
                            {{--</td>--}}
                            {{--<td colspan="2">--}}
                            {{--<select class="form-control">--}}
                            {{--<option>---</option>--}}
                            {{--<option value="cssf_opt_yes">YES</option>--}}
                            {{--<option value="cssf_opt_no">NO</option>--}}
                            {{--<option value="cssf_opt_uncertain">UNCERTAIN</option>--}}
                            {{--</select>--}}
                            {{--</td>--}}
                            {{--</tr>--}}
                            {{--<tr>--}}
                            {{--<td colspan="3">--}}
                            {{--2. Did our personnel presented his ID card?--}}
                            {{--</td>--}}
                            {{--<td colspan="2">--}}
                            {{--<select class="form-control">--}}
                            {{--<option>---</option>--}}
                            {{--<option value="cssf_opt_yes">YES</option>--}}
                            {{--<option value="cssf_opt_no">NO</option>--}}
                            {{--<option value="cssf_opt_uncertain">UNCERTAIN</option>--}}
                            {{--</select>--}}
                            {{--</td>--}}
                            {{--</tr>--}}
                            {{--<tr>--}}
                            {{--<td colspan="3">--}}
                            {{--3. Did our personnel come in motorcycle?--}}
                            {{--</td>--}}
                            {{--<td colspan="2">--}}
                            {{--<select class="form-control">--}}
                            {{--<option>---</option>--}}
                            {{--<option value="cssf_opt_yes">YES</option>--}}
                            {{--<option value="cssf_opt_no">NO</option>--}}
                            {{--<option value="cssf_opt_uncertain">UNCERTAIN</option>--}}
                            {{--</select>--}}
                            {{--</td>--}}
                            {{--</tr>--}}
                            {{--<tr>--}}
                            {{--<td colspan="3">--}}
                            {{--4. Was our personnel respectful?--}}
                            {{--</td>--}}
                            {{--<td colspan="2">--}}
                            {{--<select class="form-control">--}}
                            {{--<option>---</option>--}}
                            {{--<option value="cssf_opt_yes">YES</option>--}}
                            {{--<option value="cssf_opt_no">NO</option>--}}
                            {{--<option value="cssf_opt_uncertain">UNCERTAIN</option>--}}
                            {{--</select>--}}
                            {{--</td>--}}
                            {{--</tr>--}}
                            {{--<tr>--}}
                            {{--<td colspan="3">--}}
                            {{--5. Was there any request by the personnel (coffe/water/etc) or favor asked during the interview?--}}
                            {{--</td>--}}
                            {{--<td colspan="2">--}}
                            {{--<select class="form-control">--}}
                            {{--<option>---</option>--}}
                            {{--<option value="cssf_opt_yes">YES</option>--}}
                            {{--<option value="cssf_opt_no">NO</option>--}}
                            {{--<option value="cssf_opt_uncertain">UNCERTAIN</option>--}}
                            {{--</select>--}}
                            {{--</td>--}}
                            {{--</tr>--}}
                            {{--<tr>--}}
                            {{--<td colspan="3">--}}
                            {{--6. Did the personnel give any contact information (telephone/mobile/email) of our company or his?--}}
                            {{--</td>--}}
                            {{--<td colspan="2">--}}
                            {{--<select class="form-control">--}}
                            {{--<option>---</option>--}}
                            {{--<option value="cssf_opt_yes">YES</option>--}}
                            {{--<option value="cssf_opt_no">NO</option>--}}
                            {{--<option value="cssf_opt_uncertain">UNCERTAIN</option>--}}
                            {{--</select>--}}
                            {{--</td>--}}
                            {{--</tr>--}}
                            {{--<tr>--}}
                            {{--<td colspan="3">--}}
                            {{--7. Did our personnel present an Introduction Letter?--}}
                            {{--</td>--}}
                            {{--<td colspan="2">--}}
                            {{--<select class="form-control">--}}
                            {{--<option>---</option>--}}
                            {{--<option value="cssf_opt_yes">YES</option>--}}
                            {{--<option value="cssf_opt_no">NO</option>--}}
                            {{--<option value="cssf_opt_uncertain">UNCERTAIN</option>--}}
                            {{--</select>--}}
                            {{--</td>--}}
                            {{--</tr>--}}
                            {{--<tr>--}}
                            {{--<td colspan="3">--}}
                            {{--8. Did our personnel offer assistance for your transaction? (Specify offered assistance)--}}
                            {{--</td>--}}
                            {{--<td colspan="2">--}}
                            {{--<select class="form-control">--}}
                            {{--<option>---</option>--}}
                            {{--<option value="cssf_opt_yes">YES</option>--}}
                            {{--<option value="cssf_opt_no">NO</option>--}}
                            {{--<option value="cssf_opt_uncertain">UNCERTAIN</option>--}}
                            {{--</select>--}}
                            {{--</td>--}}
                            {{--</tr>--}}
                            {{--<tr>--}}
                            {{--<td colspan="3">--}}
                            {{--9. How did our personnel introduce his self?--}}
                            {{--</td>--}}
                            {{--<td colspan="2">--}}
                            {{--<select class="form-control">--}}
                            {{--<option>---</option>--}}
                            {{--<option value="cssf_opt_yes">YES</option>--}}
                            {{--<option value="cssf_opt_no">NO</option>--}}
                            {{--<option value="cssf_opt_uncertain">UNCERTAIN</option>--}}
                            {{--</select>--}}
                            {{--</td>--}}
                            {{--</tr>--}}
                            {{--<tr>--}}
                            {{--<td colspan="5" style="background-color: black; color: white;">--}}
                            {{--INFORMANT VALIDATION--}}
                            {{--</td>--}}
                            {{--</tr>--}}
                            {{--<tr>--}}
                            {{--<td colspan="1">--}}
                            {{--INFORMANTS' NAMES--}}
                            {{--</td>--}}
                            {{--<td colspan="1">--}}
                            {{--RELATION TO SUBJECT--}}
                            {{--</td>--}}
                            {{--<td colspan="1">--}}
                            {{--ADDRESS--}}
                            {{--</td>--}}
                            {{--<td colspan="1">--}}
                            {{--EXISTENCE--}}
                            {{--</td>--}}
                            {{--<td colspan="1">--}}
                            {{--REMARKS--}}
                            {{--</td>--}}
                            {{--</tr>--}}
                            {{--<tr>--}}
                            {{--<td>--}}
                            {{--<input type="text" placeholder="1." class="form-control">--}}
                            {{--</td>--}}
                            {{--<td>--}}
                            {{--<input type="text" class="form-control">--}}
                            {{--</td>--}}
                            {{--<td>--}}
                            {{--<input type="text" class="form-control">--}}
                            {{--</td>--}}
                            {{--<td>--}}
                            {{--<select class="form-control">--}}
                            {{--<option>---</option>--}}
                            {{--<option value="cssf_opt_negative">NEGATIVE</option>--}}
                            {{--<option value="cssf_opt_positive">POSITIVE</option>--}}
                            {{--</select>--}}
                            {{--</td>--}}
                            {{--<td>--}}
                            {{--<input type="text" class="form-control">--}}
                            {{--</td>--}}
                            {{--</tr>--}}
                            {{--<tr>--}}
                            {{--<td>--}}
                            {{--<input type="text" placeholder="2." class="form-control">--}}
                            {{--</td>--}}
                            {{--<td>--}}
                            {{--<input type="text" class="form-control">--}}
                            {{--</td>--}}
                            {{--<td>--}}
                            {{--<input type="text" class="form-control">--}}
                            {{--</td>--}}
                            {{--<td>--}}
                            {{--<select class="form-control">--}}
                            {{--<option>---</option>--}}
                            {{--<option value="cssf_opt_negative">NEGATIVE</option>--}}
                            {{--<option value="cssf_opt_positive">POSITIVE</option>--}}
                            {{--</select>--}}
                            {{--</td>--}}
                            {{--<td>--}}
                            {{--<input type="text" class="form-control">--}}
                            {{--</td>--}}
                            {{--</tr>--}}
                            {{--<tr>--}}
                            {{--<td>--}}
                            {{--<input type="text" placeholder="3." class="form-control">--}}
                            {{--</td>--}}
                            {{--<td>--}}
                            {{--<input type="text" class="form-control">--}}
                            {{--</td>--}}
                            {{--<td>--}}
                            {{--<input type="text" class="form-control">--}}
                            {{--</td>--}}
                            {{--<td>--}}
                            {{--<select class="form-control">--}}
                            {{--<option>---</option>--}}
                            {{--<option value="cssf_opt_negative">NEGATIVE</option>--}}
                            {{--<option value="cssf_opt_positive">POSITIVE</option>--}}
                            {{--</select>--}}
                            {{--</td>--}}
                            {{--<td>--}}
                            {{--<input type="text" class="form-control">--}}
                            {{--</td>--}}
                            {{--</tr>--}}
                            {{--<tr>--}}
                            {{--<td>--}}
                            {{--<input type="text" placeholder="4." class="form-control">--}}
                            {{--</td>--}}
                            {{--<td>--}}
                            {{--<input type="text" class="form-control">--}}
                            {{--</td>--}}
                            {{--<td>--}}
                            {{--<input type="text" class="form-control">--}}
                            {{--</td>--}}
                            {{--<td>--}}
                            {{--<select class="form-control">--}}
                            {{--<option>---</option>--}}
                            {{--<option value="cssf_opt_negative">NEGATIVE</option>--}}
                            {{--<option value="cssf_opt_positive">POSITIVE</option>--}}
                            {{--</select>--}}
                            {{--</td>--}}
                            {{--<td>--}}
                            {{--<input type="text" class="form-control">--}}
                            {{--</td>--}}
                            {{--</tr>--}}
                            {{--<tr>--}}
                            {{--<td>--}}
                            {{--<input type="text" placeholder="5." class="form-control">--}}
                            {{--</td>--}}
                            {{--<td>--}}
                            {{--<input type="text" class="form-control">--}}
                            {{--</td>--}}
                            {{--<td>--}}
                            {{--<input type="text" class="form-control">--}}
                            {{--</td>--}}
                            {{--<td>--}}
                            {{--<select class="form-control">--}}
                            {{--<option>---</option>--}}
                            {{--<option value="cssf_opt_negative">NEGATIVE</option>--}}
                            {{--<option value="cssf_opt_positive">POSITIVE</option>--}}
                            {{--</select>--}}
                            {{--</td>--}}
                            {{--<td>--}}
                            {{--<input type="text" class="form-control">--}}
                            {{--</td>--}}

                            {{--</tr>--}}
                            {{--<tr>--}}
                            {{--<td colspan="5" style="background-color: black; color: white;">--}}
                            {{--NEW INFORMANT GATHERED--}}
                            {{--</td>--}}
                            {{--</tr>--}}
                            {{--<tr>--}}
                            {{--<td colspan="1">--}}
                            {{--INFORMANTS' NAMES--}}
                            {{--</td>--}}
                            {{--<td colspan="1">--}}
                            {{--RELATION TO SUBJECT--}}
                            {{--</td>--}}
                            {{--<td colspan="2">--}}
                            {{--ADDRESS--}}
                            {{--</td>--}}
                            {{--<td colspan="1">--}}
                            {{--REMAARKS--}}
                            {{--</td>--}}
                            {{--</tr>--}}
                            {{--<tr>--}}
                            {{--<td colspan="1">--}}
                            {{--<input type="text" placeholder="1." class="form-control">--}}
                            {{--</td>--}}
                            {{--<td colspan="1">--}}
                            {{--<input type="text" class="form-control">--}}
                            {{--</td>--}}
                            {{--<td colspan="2">--}}
                            {{--<input type="text" class="form-control">--}}
                            {{--</td>--}}
                            {{--<td colspan="1">--}}
                            {{--<input type="text" class="form-control">--}}
                            {{--</td>--}}
                            {{--</tr>--}}
                            {{--<tr>--}}
                            {{--<td colspan="1">--}}
                            {{--<input type="text" placeholder="2." class="form-control">--}}
                            {{--</td>--}}
                            {{--<td colspan="1">--}}
                            {{--<input type="text" class="form-control">--}}
                            {{--</td>--}}
                            {{--<td colspan="2">--}}
                            {{--<input type="text" class="form-control">--}}
                            {{--</td>--}}
                            {{--<td colspan="1">--}}
                            {{--<input type="text" class="form-control">--}}
                            {{--</td>--}}
                            {{--</tr>--}}
                            {{--<tr>--}}
                            {{--<td colspan="1">--}}
                            {{--<input type="text" placeholder="3." class="form-control">--}}
                            {{--</td>--}}
                            {{--<td colspan="1">--}}
                            {{--<input type="text" class="form-control">--}}
                            {{--</td>--}}
                            {{--<td colspan="2">--}}
                            {{--<input type="text" class="form-control">--}}
                            {{--</td>--}}
                            {{--<td colspan="1">--}}
                            {{--<input type="text" class="form-control">--}}
                            {{--</td>--}}
                            {{--</tr>--}}
                            {{--<tr>--}}
                            {{--<td colspan="5" style="background-color: black; color: white;">--}}
                            {{--SUMMARY REPORT--}}
                            {{--</td>--}}
                            {{--</tr>--}}
                            {{--<tr>--}}
                            {{--<td colspan="5">--}}
                            {{--<textarea style="height: 100px; resize: none; overflow: auto;" placeholder="Enter.." class="form-control"></textarea>--}}
                            {{--</td>--}}
                            {{--</tr>--}}
                            {{--<tr>--}}
                            {{--<td colspan="1">--}}

                            {{--</td>--}}
                            {{--<td colspan="1">--}}
                            {{--<input type="button" class="btn btn-block btn-primary btn-lg" value="Upload Attachment">--}}
                            {{--</td>--}}
                            {{--<td colspan="1">--}}

                            {{--</td>--}}
                            {{--<td colspan="1">--}}
                            {{--<input type="button" class="btn btn-block btn-primary btn-lg" value="Download Attachment">--}}
                            {{--</td>--}}
                            {{--<td colspan="1">--}}

                            {{--</td>--}}
                            {{--</tr>--}}
                            {{--<tr>--}}
                            {{--<td colspan="5" style="height: 80px;">--}}

                            {{--</td>--}}
                            {{--</tr>--}}
                            {{--<tr>--}}
                            {{--<td><input type="button" class="btn btn-block btn-primary btn-lg" value="PRINT"></td>--}}
                            {{--<td><input type="button" class="btn btn-block btn-info btn-lg" value="SAVE"></td>--}}
                            {{--<td><input type="button" class="btn btn-block btn-warning btn-lg" value="EDIT"></td>--}}
                            {{--<td><input type="button" class="btn btn-block btn-danger btn-lg" value="DELETE"></td>--}}
                            {{--<td><input type="button" class="btn btn-block btn-success btn-lg" value="SUBMIT"></td>--}}
                            {{--</tr>--}}
                            {{--</table>--}}
                            {{--</div>--}}
                            {{--</div>--}}
                            {{--</div>--}}
                            {{--</div>--}}
                            {{--</div>--}}
                            {{--</div>--}}
                            {{--</div>--}}



                            {{--DISCREPANCY FORM--}}

                            {{--<div class="tab-pane" id="tab_form4">--}}


                            {{--<div class="box-body">--}}
                            {{--<div class="row">--}}
                            {{--<div class="col-md-3"></div>--}}
                            {{--<div class="col-md-3"></div>--}}
                            {{--</div>--}}
                            {{--<div class="row">--}}
                            {{--<div class="col-md-1"></div>--}}
                            {{--<div class="col-md-10">--}}
                            {{--<div class="box box-danger">--}}
                            {{--<div class="row" style="padding-top:30px;">--}}
                            {{--<div class="col-md-12">--}}
                            {{--<table class="table-condensed" style = "overflow-x:auto; border-collapse:collapse; table-layout:fixed; width : 100%; font-weight: bold;">--}}
                            {{--<tr>--}}
                            {{--<th colspan="10" style="background-color:black; color:white;">--}}
                            {{--ACCOUNT INFORMATION--}}
                            {{--</th>--}}
                            {{--<tr>--}}
                            {{--<td colspan="6">--}}
                            {{--OIMS ID NUMBER:--}}
                            {{--</td>--}}
                            {{--<td colspan="4">--}}

                            {{--</td>--}}
                            {{--</tr>--}}
                            {{--<tr>--}}
                            {{--<td colspan="2">--}}
                            {{--Type in OIMS ID number--}}
                            {{--</td>--}}
                            {{--<td colspan="2" style="background-color: yellow">--}}
                            {{--SEARCH--}}
                            {{--</td>--}}
                            {{--<td colspan="2">--}}
                            {{--<input type="text" class="form-control">--}}
                            {{--</td>--}}
                            {{--<td colspan="2">--}}
                            {{--<button type = "button" class = "btn btn-block btn-primary" style = "font-weight:bold;">MESSENGER</button>--}}
                            {{--</td>--}}
                            {{--<td colspan="2">--}}
                            {{--<input type="text" class="form-control">--}}
                            {{--</td>--}}
                            {{--</tr>--}}
                            {{--<tr>--}}
                            {{--<td colspan="6">BORROWER’s NAME and COMPANY:</td>--}}
                            {{--<td colspan="2">CLIENT</td>--}}
                            {{--<td colspan="2"><input type="text" class="form-control" disabled></td>--}}
                            {{--</tr>--}}
                            {{--<tr>--}}
                            {{--<td colspan="2"><input type="text" class="form-control" placeholder="LAST NAME"></td>--}}
                            {{--<td colspan="2"><input type="text" class="form-control" placeholder="FIRST NAME"></td>--}}
                            {{--<td colspan="2"><input type="text" class="form-control" placeholder="MIDDLE NAME"></td>--}}
                            {{--<td colspan="2">REQUEST</td>--}}
                            {{--<td colspan="2"><input type="text" class="form-control" disabled></td>--}}
                            {{--</tr>--}}
                            {{--<tr>--}}
                            {{--<td colspan="6">BUSINESS NAME</td>--}}
                            {{--<td colspan="2">ENDORSEMENT DATE:</td>--}}
                            {{--<td colspan="2"><input type="text" class="form-control" disabled></td>--}}
                            {{--</tr>--}}
                            {{--<tr>--}}
                            {{--<td colspan="6">--}}
                            {{--<input type="text" class="form-control">--}}
                            {{--</td>--}}
                            {{--<td colspan="2">--}}
                            {{--SUBMISSION DATE:--}}
                            {{--</td>--}}
                            {{--<td colspan="2">--}}
                            {{--<input type="text" class="form-control" disabled>--}}
                            {{--</td>--}}
                            {{--</tr>--}}
                            {{--<tr>--}}
                            {{--<td colspan="6">--}}
                            {{--ADDRESS:--}}
                            {{--</td>--}}
                            {{--<td colspan="2">--}}
                            {{--INTERNAL TAT COM:--}}
                            {{--</td>--}}
                            {{--<td colspan="2">--}}
                            {{--<input type="text" class="form-control" disabled>--}}
                            {{--</td>--}}
                            {{--</tr>--}}
                            {{--<tr>--}}
                            {{--<td colspan="6">--}}
                            {{--<input type="text" class="form-control">--}}
                            {{--</td>--}}
                            {{--<td colspan="2">--}}
                            {{--EXTERNAL TAT COM:--}}
                            {{--</td>--}}
                            {{--<td colspan="2">--}}
                            {{--<input type="text" class="form-control" disabled>--}}
                            {{--</td>--}}
                            {{--</tr>--}}
                            {{--<tr>--}}
                            {{--<td colspan="6" style="background-color: skyblue;">--}}
                            {{--<u>SPECIAL INSTRUCTIONS FROM THE CLIENT:</u>--}}
                            {{--</td>--}}
                            {{--<td colspan="4" style="background-color: skyblue;">--}}
                            {{--<u>TYPE OF CHECKING</u>--}}
                            {{--</td>--}}
                            {{--</tr>--}}
                            {{--<tr>--}}
                            {{--<td colspan="6">--}}
                            {{--<input type="text" class="form-control" disabled>--}}
                            {{--</td>--}}
                            {{--<td colspan="4">--}}
                            {{--<input type="text" class="form-control" disabled placeholder="(autogenerate wether : DISCREET or REGULAR, RUSH or REGULAR PROCESS)">--}}
                            {{--</td>--}}
                            {{--</tr>--}}
                            {{--<tr>--}}
                            {{--<td colspan="10" style="background-color: black; color:white;">--}}
                            {{--BACKGROUND--}}
                            {{--</td>--}}
                            {{--</tr>--}}
                            {{--<tr>--}}
                            {{--<td colspan="2">--}}
                            {{--EMPLOYEE:--}}
                            {{--</td>--}}
                            {{--<td colspan="3">--}}
                            {{--<input type="text" class="form-control" disabled placeholder="(Last Name, First Name (autogenerated)">--}}
                            {{--</td>--}}
                            {{--<td colspan="2" style="background-color: yellow;">--}}
                            {{--(Type in EMP ID)--}}
                            {{--</td>--}}
                            {{--<td colspan="3">--}}
                            {{--<input type="text" class="form-control" placeholder="SEARCH">--}}
                            {{--</td>--}}
                            {{--</tr>--}}
                            {{--<tr>--}}
                            {{--<td colspan="2">--}}
                            {{--DEPARTMENT:--}}
                            {{--</td>--}}
                            {{--<td colspan="8">--}}
                            {{--<input type="text" class="form-control" disabled>--}}
                            {{--</td>--}}
                            {{--</tr>--}}
                            {{--<tr>--}}
                            {{--<td colspan="2">--}}
                            {{--JOB TITLE:--}}
                            {{--</td>--}}
                            {{--<td colspan="8">--}}
                            {{--<input type="text" class="form-control" disabled>--}}
                            {{--</td>--}}
                            {{--</tr>--}}
                            {{--<tr>--}}
                            {{--<td colspan="2">--}}
                            {{--DATE HIRED:--}}
                            {{--</td>--}}
                            {{--<td colspan="8">--}}
                            {{--<input type="text" class="form-control" disabled>--}}
                            {{--</td>--}}
                            {{--</tr>--}}
                            {{--<tr>--}}
                            {{--<td colspan="2">--}}
                            {{--FINDINGS:--}}
                            {{--</td>--}}
                            {{--<td colspan="8">--}}
                            {{--<input type="text" class="form-control">--}}
                            {{--</td>--}}
                            {{--</tr>--}}
                            {{--<tr>--}}
                            {{--<td colspan="2">--}}
                            {{--INVESTIGATION TAKEN:--}}
                            {{--</td>--}}
                            {{--<td colspan="8">--}}
                            {{--<input type="text" class="form-control">--}}
                            {{--</td>--}}
                            {{--</tr>--}}
                            {{--<tr>--}}
                            {{--<td colspan="2">--}}
                            {{--VALIDATION RESULTS:--}}
                            {{--</td>--}}
                            {{--<td colspan="8">--}}
                            {{--<input type="text" class="form-control">--}}
                            {{--</td>--}}
                            {{--</tr>--}}
                            {{--<tr>--}}
                            {{--<td colspan="2">--}}
                            {{--STATEMENTS:--}}
                            {{--</td>--}}
                            {{--<td colspan="8">--}}
                            {{--<input type="text" class="form-control">--}}
                            {{--</td>--}}
                            {{--</tr>--}}
                            {{--<tr>--}}
                            {{--<td colspan="2">--}}
                            {{--OBSERVATIONS:--}}
                            {{--</td>--}}
                            {{--<td colspan="8">--}}
                            {{--<input type="text" class="form-control">--}}
                            {{--</td>--}}
                            {{--</tr>--}}
                            {{--<tr>--}}
                            {{--<td colspan="2">--}}
                            {{--RECOMMENDATIONS:--}}
                            {{--</td>--}}
                            {{--<td colspan="8">--}}
                            {{--<input type="text" class="form-control">--}}
                            {{--</td>--}}
                            {{--</tr>--}}
                            {{--<tr>--}}
                            {{--<td colspan="10" style="height: 80px;">--}}
                            {{--</td>--}}
                            {{--</tr>--}}
                            {{--<tr>--}}
                            {{--<td colspan="2">--}}

                            {{--</td>--}}
                            {{--<td colspan="2">--}}
                            {{--<input type="button" class="btn btn-block btn-primary btn-lg" value="Upload Attachment">--}}
                            {{--</td>--}}
                            {{--<td colspan="2">--}}

                            {{--</td>--}}
                            {{--<td colspan="2">--}}
                            {{--<input type="button" class="btn btn-block btn-primary btn-lg" value="Download Attachment">--}}
                            {{--</td>--}}
                            {{--<td colspan="2">--}}

                            {{--</td>--}}
                            {{--</tr>--}}
                            {{--<tr>--}}
                            {{--<td colspan="10" style="height: 80px;">--}}
                            {{--</td>--}}
                            {{--</tr>--}}
                            {{--<tr>--}}
                            {{--<td colspan="2">--}}
                            {{--<input type="button" class="btn btn-block btn-primary btn-lg" value="PRINT">--}}
                            {{--</td>--}}
                            {{--<td colspan="2">--}}
                            {{--<input type="button" class="btn btn-block btn-info btn-lg" value="SAVE">--}}
                            {{--</td>--}}
                            {{--<td colspan="2">--}}
                            {{--<input type="button" class="btn btn-block btn-warning btn-lg" value="EDIT">--}}
                            {{--</td>--}}
                            {{--<td colspan="2">--}}
                            {{--<input type="button" class="btn btn-block btn-danger btn-lg" value="DELETE">--}}
                            {{--</td>--}}
                            {{--<td colspan="2">--}}
                            {{--<input type="button" class="btn btn-block btn-success btn-lg" value="SUBMIT">--}}
                            {{--</td>--}}
                            {{--</tr>--}}
                            {{--</tr>--}}
                            {{--</table>--}}
                            {{--</div>--}}
                            {{--</div>--}}
                            {{--</div>--}}
                            {{--</div>--}}
                            {{--</div>--}}
                            {{--</div>--}}
                            {{--</div>--}}


                            {{--EXPENSE VALIDATION--}}

                            <div class="tab-pane" id="tab_form5">


                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-md-3"></div>
                                        <div class="col-md-3"></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-1"></div>
                                        <div class="col-md-10">
                                            <div class="box box-danger">
                                                <div class="row" style="padding-top:30px;">
                                                    <div class="col-md-12">
                                                        <table class="table-condensed" style = "overflow-x:auto; border-collapse:collapse; table-layout:fixed; width : 100%; font-weight: bold;">
                                                            <tr>
                                                                <th colspan="10" style="background-color: black; color:white;">
                                                                    BACKGROUND
                                                                </th>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2">
                                                                    EMPLOYEE:
                                                                </td>
                                                                <td colspan="3">
                                                                    <input type="text" class="form-control" disabled placeholder="(Last Name, First Name) (autogenerated once EMP ID is encoded)">
                                                                </td>
                                                                <td colspan="2">
                                                                    AUDITOR:
                                                                </td>
                                                                <td colspan="2">
                                                                    <input type="text" class="form-control" disabled>
                                                                </td>
                                                                <td colspan="1">

                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2">
                                                                    DEPARTMENT:
                                                                </td>
                                                                <td colspan="3">
                                                                    <input type="text" class="form-control" disabled>
                                                                </td>
                                                                <td colspan="2">
                                                                    AUDIT LOGGED:
                                                                </td>
                                                                <td colspan="2">
                                                                    <input type="text" class="form-control" disabled>
                                                                </td>
                                                                <td colspan="1">

                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2">
                                                                    JOB TITLE:
                                                                </td>
                                                                <td colspan="3">
                                                                    <input type="text" class="form-control" disabled>
                                                                </td>
                                                                <td colspan="2">
                                                                    TRAVEL TIME:
                                                                </td>
                                                                <td colspan="2">
                                                                    <input type="text" class="form-control">
                                                                </td>
                                                                <td colspan="1">

                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2">
                                                                    DATE HIRED:
                                                                </td>
                                                                <td colspan="3">
                                                                    <input type="text" class="form-control" disabled>
                                                                </td>
                                                                <td colspan="2">
                                                                    TOTAL DISTANCE:
                                                                </td>
                                                                <td colspan="2">
                                                                    <input type="text" class="form-control">
                                                                </td>
                                                                <td colspan="1">

                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2">
                                                                    RESIDENCE ADDRESS:
                                                                </td>
                                                                <td colspan="3">
                                                                    <input type="text" class="form-control" disabled>
                                                                </td>
                                                                <td colspan="2">
                                                                    FINDINGS:
                                                                </td>
                                                                <td colspan="2">
                                                                    <input type="text" class="form-control">
                                                                </td>
                                                                <td colspan="1">

                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2">
                                                                    HIRED AS:
                                                                </td>
                                                                <td colspan="3">
                                                                    <input type="text" class="form-control" disabled>
                                                                </td>
                                                                <td colspan="2">
                                                                    DONE THROUGH:
                                                                </td>
                                                                <td colspan="2">
                                                                    <input type="text" class="form-control">
                                                                </td>
                                                                <td colspan="1">

                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="10" style="background-color: black; color: white;">
                                                                    SEARCH ACCOUNT
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2">
                                                                    <input type="text" class="form-control" placeholder="SEARCH">
                                                                </td>
                                                                <td colspan="2" style="background-color: yellow;">
                                                                    SEARCH
                                                                </td>
                                                                <td colspan="6">

                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2">
                                                                    ID Number
                                                                </td>
                                                                <td colspan="2">
                                                                    ACCOUNT NAME
                                                                </td>
                                                                <td colspan="3">
                                                                    ADDRESS
                                                                </td>
                                                                <td colspan="1">
                                                                    REQUEST
                                                                </td>
                                                                <td colspan="1">
                                                                    DATE VISITED
                                                                </td>
                                                                <td colspan="1">
                                                                    ACTION
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2">
                                                                    <input type="text" class="form-control">
                                                                </td>
                                                                <td colspan="2">
                                                                    <input type="text" class="form-control">
                                                                </td>
                                                                <td colspan="3">
                                                                    <input type="text" class="form-control">
                                                                </td>
                                                                <td colspan="1">
                                                                    <input type="text" class="form-control">
                                                                </td>
                                                                <td colspan="1">
                                                                    <input type="text" class="form-control">
                                                                </td>
                                                                <td colspan="1">
                                                                    <input type="button" class="btn btn-block btn-primary btn-lg" value="Add">
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="10" style="background-color: black; color: white;">
                                                                    VALIDATION CHECKLIST
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="1">
                                                                    ID NUMBER
                                                                </td>
                                                                <td colspan="1">
                                                                    ACCOUNT NAME
                                                                </td>
                                                                <td colspan="2">
                                                                    ADDRESS
                                                                </td>
                                                                <td colspan="1">
                                                                    REQUEST
                                                                </td>
                                                                <td colspan="1">
                                                                    DATE VISITED
                                                                </td>
                                                                <td colspan="1">
                                                                    REQUESTED AMOUNT
                                                                </td>
                                                                <td colspan="1">
                                                                    TRANSPORTATION
                                                                </td>
                                                                <td colspan="2">
                                                                    ITINERARY REQUESTED
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="1">
                                                                    <input type="text" class="form-control">
                                                                </td>
                                                                <td colspan="1">
                                                                    <input type="text" class="form-control">
                                                                </td>
                                                                <td colspan="2">
                                                                    <input type="text" class="form-control">
                                                                </td>
                                                                <td colspan="1">
                                                                    <input type="text" class="form-control">
                                                                </td>
                                                                <td colspan="1">
                                                                    <input type="text" class="form-control">
                                                                </td>
                                                                <td colspan="1">
                                                                    <input type="text" class="form-control">
                                                                </td>
                                                                <td colspan="1">
                                                                    <input type="text" class="form-control">
                                                                </td>
                                                                <td colspan="2" rowspan="3">
                                                                    <textarea rows="7" class="form-control" style="resize: none; overflow: auto;" placeholder="Enter..."></textarea>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="8" style="background-color: black; color: white;">
                                                                    SUMMARY REPORT
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="8">
                                                                    <textarea style="resize: none;" rows="3" class="form-control" placeholder="SUMMARY REPORT..."></textarea>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="10" style="height: 80px;">
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2">
                                                                    {{--<button class="btn btn-block btn-success btn-lg" > View Attachment</button>--}}
                                                                </td>
                                                                <td colspan="2">
                                                                    <input type="button" class="btn btn-block btn-primary btn-lg" value="Upload Attachment">
                                                                </td>
                                                                <td colspan="2">

                                                                </td>
                                                                <td colspan="2">
                                                                    <input type="button" class="btn btn-block btn-primary btn-lg" value="Download Attachment">
                                                                </td>
                                                                <td colspan="2">

                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="10" style="height: 80px;">
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2">
                                                                    <input type="button" class="btn btn-block btn-primary btn-lg" value="PRINT">
                                                                </td>
                                                                <td colspan="2">
                                                                    <input type="button" class="btn btn-block btn-info btn-lg" value="SAVE">
                                                                </td>
                                                                <td colspan="2">
                                                                    <input type="button" class="btn btn-block btn-warning btn-lg" value="EDIT">
                                                                </td>
                                                                <td colspan="2">
                                                                    <input type="button" class="btn btn-block btn-danger btn-lg" value="DELETE">
                                                                </td>
                                                                <td colspan="2">
                                                                    <input type="button" class="btn btn-block btn-success btn-lg" value="SUBMIT">
                                                                </td>
                                                            </tr>

                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            {{--CREDIT REPORT GRADING--}}

                            <div class="tab-pane" id="tab_form6">

                                <div class = "box-body">
                                    <div class = "row">
                                        <div class = "col-md-3">
                                            <div class="box box-danger hideThis">
                                                <div class="col-md-12" style="padding-top: 10px;">
                                                    <label>Audit Logs <br>
                                                        <small style="color:red; cursor: help;">*NOTE: Click a log to retrieve the data.</small></label>
                                                    <span class="audits_log_table">
                                                        <table style="table-layout: auto;word-wrap: break-word; width: 100%;" class="table-hover">
                                                            <tr style="background-color: black; color: white;">
                                                                <th>Activity Logs</th>
                                                            </tr>
                                                            <tr>
                                                                <td>No records found</td>
                                                            </tr>
                                                        </table>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class = "col-md-9">
                                            <div class = "box box-danger">
                                                <div class = "row hideThis" style = "padding-top : 40px" >
                                                    <div class="col-md-12">
                                                        <button class = "btn btn-lg btn-info pull-right" id = "newFormCssf">CREATE NEW</button>
                                                    </div>
                                                </div>
                                                <div class = "row" style = "padding-top : 20px;">
                                                    <div class = "col-md-12">
                                                        <table class="table-condensed tab6-printThis"  style = "overflow-x:auto; border-collapse:collapse; table-layout:fixed; width : 100%;">
                                                            {{--<tr>--}}
                                                            {{--<th colspan="5" >ACCOUNT INFORMATION</th>--}}
                                                            {{--</tr>--}}
                                                            <tr>
                                                                <th colspan="2" style = "background-color: black; color : white;" class="hidir">BACKGROUND</th>
                                                                <th colspan="3"  style = "background-color: black; color : white;" class="hidir">REPORT CHECKLIST</th>
                                                            </tr>
                                                            <tr>
                                                                <td style="font-weight:bold;">EMPLOYEE ID</td>
                                                                <td style = "word-wrap:break-word;">
                                                                    <input type="text" class="form-control" id="ci_employee_id">
                                                                </td>
                                                                <td style="font-weight:bold;">COMPLETENESS (5%)</td>
                                                                <td>
                                                                    <select id= "ci_grade_completeness" class = "form-control" required>
                                                                        <option value="0">-</option>
                                                                        <option value="5" name = "COMPLETE" >COMPLETE - 5%</option>
                                                                        <option value="4" name = "SATISFACTORY" >SATISFACTORY - 4% </option>
                                                                        <option value="3" name = "NEEDS IMPROVEMENT">NEEDS IMPROVEMENT - 3%</option>
                                                                        <option value="0" name = "POOR">POOR - 0%</option>
                                                                    </select>
                                                                </td>
                                                                <td style = "word-wrap:break-word;">
                                                                    <input type="text" class = "form-control" placeholder="Input Grade Remarks....." id="ci_grade_completeness_rem">
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style="font-weight:bold;">EMPLOYEE LAST NAME</td>
                                                                <td style = "word-wrap:break-word;">
                                                                    <input type="text" class = "form-control" id="employee_last_name">
                                                                </td>
                                                                <td style="font-weight:bold;">GPS ATTACHMENT (5%)</td>
                                                                <td>
                                                                    <select id= "ci_grade_gps" class = "form-control" required>
                                                                        <option value="0">-</option>
                                                                        <option value="5" name = "VALID" >VALID - 5%</option>
                                                                        <option value="0" name = "INVALID" >INVALID - 0%</option>
                                                                    </select>
                                                                </td>
                                                                <td style = "word-wrap:break-word;">
                                                                    <input type="text" class = "form-control" placeholder="Input Grade Remarks....." id="ci_grade_gps_rem">
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style="font-weight:bold;">EMPLOYEE FIRST NAME</td>
                                                                <td style = "word-wrap:break-word;">
                                                                    <input type="text" class = "form-control" id="employee_first_name">
                                                                </td>
                                                                <td style="font-weight:bold;">INFORMANTS VALIDITY (15%)</td>
                                                                <td>
                                                                    <select id= "ci_grade_informantsValidity" class = "form-control" required>
                                                                        <option value="0">-</option>
                                                                        <option value="15" name = "VALID" >VALID - 15%</option>
                                                                        <option value="10" name = "INCOMPLETE" >INCOMPLETE - 10%</option>
                                                                        <option value="0" name = "NEEDS IMPROVEMENT">POOR - 0%</option>
                                                                    </select>
                                                                </td>
                                                                <td style = "word-wrap:break-word;">
                                                                    <input type="text" class = "form-control" placeholder="Input Grade Remarks....." id="ci_grade_informantsValidity_rem">
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style="font-weight:bold;">JOB TITLE</td>
                                                                <td style = "word-wrap:break-word;">
                                                                    <input type="text" class = "form-control" id="employee_job_title_cssf">
                                                                </td>
                                                                <td style="font-weight:bold;">ENCODING ACCURACY (5%)</td>
                                                                <td>
                                                                    <select id= "ci_grade_encodingAccu" class = "form-control" required>
                                                                        <option value="0">-</option>
                                                                        <option value="5" name = "NO ERROR FOUND" >NO ERROR FOUND - 5%</option>
                                                                        <option value="4" name = "1-2 NON MAJOR ERROR" >1-2 NON MAJOR ERROR - 4% </option>
                                                                        <option value="3" name = "3-4 NON MAJOR ERROR">3-4 NON MAJOR ERROR - 3%</option>
                                                                        <option value="2" name = "5-6 NON MAJOR ERROR">5-6 NON MAJOR ERROR - 2%</option>
                                                                        <option value="1" name = "7-8 NON MAJOR ERROR ">7-8 NON MAJOR ERROR - 1%</option>
                                                                        <option value="0" name = "9 AND UP MAJOR ERROR">9 AND UP MAJOR ERROR - 0%</option>
                                                                    </select>
                                                                </td>
                                                                <td style = "word-wrap:break-word;">
                                                                    <input type="text" class = "form-control" placeholder="Input Grade Remarks....." id="ci_grade_encodingAccu_rem">
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style="font-weight:bold;">DATE HIRED</td>
                                                                <td style = "word-wrap:break-word;">
                                                                    <input type="date" class = "form-control" id="ci_date_hired">
                                                                </td>

                                                                <td style="font-weight:bold;">SELFIE/UNIFORM/ID (5%)</td>
                                                                <td>
                                                                    <select id= "ci_grade_selfie" class = "form-control" required>
                                                                        <option value="0">-</option>
                                                                        <option value="5" name = "COMPLETE" >COMPLETE  - 5%</option>
                                                                        <option value="4" name = "1 INCOMPLETE" >1 INCOMPLETE - 4%</option>
                                                                        <option value="3" name = "2 INCOMPLETE">2 INCOMPLETE - 3%</option>
                                                                        <option value="2" name = "3 INCOMPLETE">3 INCOMPLETE - 2%</option>
                                                                        <option value="0" name = "3 INCOMPLETE">4 INCOMPLETE - 0%</option>
                                                                    </select>
                                                                </td>
                                                                <td style = "word-wrap:break-word;">
                                                                    <input type="text" class = "form-control" placeholder="Input Grade Remarks....." id="ci_grade_selfie_rem">
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style="font-weight:bold;">AREA</td>
                                                                <td style = "word-wrap:break-word;">
                                                                    <input type="text" class = "form-control" id="ci_area">
                                                                </td>

                                                                <td style="font-weight:bold;">TAT COMPLIANCE (60%)</td>
                                                                <td>
                                                                    <select id= "ci_grade_tatCompliance" class = "form-control" required>
                                                                        <option value="-">-</option>
                                                                        <option value="60" name = "ON TAT" >ON TAT - 60%</option>
                                                                        <option value="0" name = "BREACHED" >BREACHED - 0%</option>
                                                                    </select>
                                                                </td>
                                                                <td style = "word-wrap:break-word;">
                                                                    <input type="text" class = "form-control" placeholder="Input Grade Remarks....." id="ci_grade_tatCompliance_rem">
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style="font-weight:bold;">BRANCH HEAD</td>
                                                                <td style = "word-wrap:break-word;">
                                                                    <input type="text" class = "form-control" id="ci_branch_head">
                                                                </td>

                                                                <td style="font-weight:bold;">ATTACHED DOCUMENTS (5%)</td>
                                                                <td>
                                                                    <select id= "ci_grade_attachedDocs" class = "form-control" required>
                                                                        <option value="0">-</option>
                                                                        <option value="5" name = "COMPLETE" >COMPLETE - 5%</option>
                                                                        <option value="3" name = "1 INCOMPLETE" >1 INCOMPLETE - 3%</option>
                                                                        <option value="1" name = "2 INCOMPLETE" >2 INCOMPLETE - 1%</option>
                                                                        <option value="0" name = "3 INCOMPLETE" >3 INCOMPLETE - 0%</option>
                                                                    </select>
                                                                </td>
                                                                <td style = "word-wrap:break-word;">
                                                                    <input type="text" class = "form-control" placeholder="Input Grade Remarks....." id="ci_grade_attachedDocs_rem">
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style="font-weight:bold;">REGIONAL BRANCH HEAD</td>
                                                                <td style = "word-wrap:break-word;">
                                                                    <input type="text" class = "form-control" id="ci_reg_branch_head">
                                                                </td>
                                                                <td style="font-weight:bold;">TOTAL SCORE</td>
                                                                <td>
                                                                    <input type="text" id="ci_grade_total" class = "form-control" disabled style="text-align: center; font-weight: bold; font-size:2.5em;" value="0%">
                                                                </td>
                                                                <td></td>
                                                            </tr>
                                                            <tr>
                                                                <td style="font-weight:bold;">SENIOR ACCOUNT OFFICER</td>
                                                                <td style = "word-wrap:break-word;">
                                                                    <input type="text" class = "form-control" id="ci_sao">
                                                                </td>
                                                                <td rowspan = "2" colspan = "3">

                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style="font-weight:bold;">CI SUPERVISOR</td>
                                                                <td style = "word-wrap:break-word;">
                                                                    <input type="text" class = "form-control" id="ci_sup">
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2" style = "background-color: black; color : white;" class="hidir">ACCOUNT DETAILS</td>
                                                                <td colspan="3"  style = "background-color: black; color : white;" class="hidir">SUMMARY REPORT</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="font-weight:bold;">OIMS ID</td>
                                                                <td style = " word-wrap:break-word;">
                                                                    <input type="text" class = "form-control ui-autocomplete-input" style = "background-color: yellow;" id="ci_account_oims_id" autocomplete="off">
                                                                </td>
                                                                <td colspan="3" rowspan="4">
                                                                    <textarea rows = "8" class = "form-control" id="ci_account_summary" placeholder="Indicate here..." ></textarea>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td><span class = "hideThis"><button type = "button" class = "btn btn-block btn-primary" style = "font-weight:bold;" id="ci_messenger_account">MESSENGER</button></span></td>
                                                                <td style = "word-wrap:break-word;">
                                                                    <input type="text" id="account_messenger_id" class="form-control" disabled>
                                                                </td>
                                                                {{--<td colspan="3" rowspan="3">--}}
                                                                {{--<textarea rows = "6" class = "form-control" disabled> </textarea>--}}
                                                                {{--</td>--}}
                                                            </tr>
                                                            <tr>
                                                                <td style="font-weight:bold;">BANK</td>
                                                                <td style = "word-wrap:break-word;">
                                                                    <input type="text" class = "form-control" id="account_bank_name" disabled>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style="font-weight:bold;">ENDORSEMENT DATE</td>
                                                                <td style = "word-wrap:break-word;">
                                                                    <input type="date" class = "form-control" id="account_date_endorse" disabled>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style="font-weight:bold;">ACCOUNT NAME</td>
                                                                <td style = "word-wrap:break-word;">
                                                                    <input type="text" class = "form-control" id="account_name" disabled>
                                                                </td>
                                                                <td colspan="3"  style = "background-color: black; color : white;" class="hidir">CAUSE OF DELAY</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="font-weight:bold;">DATE VISITED</td>
                                                                <td style = "word-wrap:break-word;">
                                                                    <input type="date" class = "form-control" id="ci_date_visited" disabled>
                                                                </td>
                                                                <td colspan="3" rowspan="4">
                                                                    <textarea rows = "8" class = "form-control" disabled id="cause_of_delay_rem" style="resize: none;" placeholder="Indicate here..."></textarea>
                                                                </td>

                                                            </tr>
                                                            <tr>
                                                                <td style="font-weight:bold;">TYPE OF REQUEST</td>
                                                                <td style = "word-wrap:break-word;">
                                                                    <input type="text" class = "form-control" id="account_tor" disabled>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style="font-weight:bold;">HANDLING TYPE</td>
                                                                <td style = "word-wrap:break-word;">
                                                                    <input type="text" class = "form-control" id="accnt_handling_type" disabled>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style="font-weight:bold;">SOURCE</td>
                                                                <td style = "word-wrap:break-word;">
                                                                    <input type="text" class = "form-control" id="accnt_source" disabled>
                                                                </td>
                                                            </tr>
                                                            <tr class="hideThis">
                                                                <td colspan="5" height="80px">
                                                                </td>
                                                            </tr>
                                                            <tr class="hideThis">
                                                                <td>

                                                                </td>
                                                                <td>
                                                                    <label for="tab6_upload" id="tab_6_upload_label" class="btn btn-block btn-primary btn-lg">Upload Attachment</label>
                                                                    <label id="tab_6_upload_label_cancel" class="btn btn-block btn-danger btn-lg" style="display: none;">Close uploader</label>
                                                                </td>
                                                                <td>
                                                                    <a class="btn btn-block btn-success btn-lg" id = "viewAttachmentCssf" > View Attachment</a>
                                                                </td>
                                                                <td>
                                                                    <input type="button" class="btn btn-block btn-primary btn-lg hideThis" value="Download Attachment" id = "dwn_attachment_ci_endorse_ccsf"><span id = "dwnCssf" hidden></span>
                                                                </td>
                                                                <td>

                                                                </td>
                                                            </tr>



                                                            <tr class = "hideThis" id="thisisUploadedCIRep" hidden>
                                                                <td colspan="1" class="hideThis">

                                                                </td>
                                                                <td colspan="3" class="hideThis">
                                                                    <div id="uploaded_holder_ci_rep"></div>
                                                                </td>
                                                                <td colspan="1" class="hideThis">

                                                                </td>
                                                            </tr>

                                                                <tr class = "hideThis" id="thisisUploaderCIRep" hidden>
                                                                <td colspan="1" class="hideThis">

                                                                </td>
                                                                <td colspan="3" class="hideThis">
                                                                    <div id="qq-audit-ciRep-form-fine-holder"></div>
                                                                </td>
                                                                <td colspan="1" class="hideThis">

                                                                </td>
                                                            </tr>



                                                            <tr class="hideThis">
                                                                <td colspan="5" height="80px">
                                                                </td>
                                                            </tr>
                                                            <tr class="hideThis">
                                                                <td>
                                                                    <button class="btn btn-block btn-primary btn-lg hideThis" id="tab6Print">PRINT</button>
                                                                </td>
                                                                <td>
                                                                    <button class="btn btn-block btn-info btn-lg hideThis" id = "btn_save_cssf">SAVE</button>
                                                                </td>
                                                                <td>
                                                                    <button class="btn btn-block btn-warning btn-lg hideThis" id="editTab6">EDIT</button>
                                                                </td>
                                                                <td>
                                                                    <button class="btn btn-block btn-danger btn-lg hideThis" id="clearFieldsTab6">DELETE</button>
                                                                </td>
                                                                <td>
                                                                    <button class="btn btn-block btn-success btn-lg hideThis" id="submitCiReportChecking" name = "without">SUBMIT</button>
                                                                </td>
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
                    </div>
                </div>
                <div class="tab-pane " id="tab_log2">
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs print" >
                            <li class="active"><a href="#tab_submitted" data-toggle="tab" class = "audit_forms_submit_save_class">SUBMITTED</a></li>
                            <li><a href="#tab_partial" data-toggle="tab" class = "audit_forms_submit_save_class">PARTIAL</a></li>
                        </ul>
                        <div class = "tab-content">
                            <div class="tab-pane active" id="tab_submitted">
                                <div class="box box-info">
                                    <div class="box-body">
                                        <div class="row">
                                            <div class="col-md-1"></div>
                                            <div class="col-md-10">
                                                <table class="table-condensed table-hover" width="100%" id="general_audit_logs_table">
                                                    <thead>
                                                    <tr>
                                                        <th>Log ID</th>
                                                        <th>Date / Time</th>
                                                        <th>Activity</th>
                                                        <th>Employee Name</th>
                                                        <th>Employee Name2</th>
                                                        <th>Employee Name3</th>
                                                        <th>Employee Name4</th>
                                                        <th>Employee Name5</th>
                                                        <th>Status</th>
                                                    </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane " id="tab_partial">
                                <div class="box box-info">
                                    <div class="box-body">
                                        <div class="row">
                                            <div class="col-md-1"></div>
                                            <div class="col-md-10">
                                                <table class="table-condensed table-hover" width="100%" id="partial_audit_logs_table">
                                                    <thead>
                                                    <tr>
                                                        <th>Log ID</th>
                                                        <th>Date / Time</th>
                                                        <th>Activity</th>
                                                        <th>Employee Name</th>
                                                        <th>Employee Name2</th>
                                                        <th>Employee Name3</th>
                                                        <th>Employee Name4</th>
                                                        <th>Employee Name5</th>
                                                        <th>Status</th>
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
        </div>
    </section>
</div>


{{--<div class = "box box-info">--}}
{{--<div class = "row">--}}
{{--<div class = "col-md-3"></div>--}}
{{--<div class = "col-md-6">--}}
{{--<h4 style = "text-align : center">CREDIT INVESTIGATOR REPORT CHECKING SHEET </h4>--}}
{{--</div>--}}
{{--<div class = "col-md-3"></div>--}}
{{--</div>--}}
{{--<div class = "row" style = "padding-top : 40px;">--}}
{{--<div class = "col-md-4">--}}
{{--<label for="">Employee ID:</label>--}}
{{--<input type="text" class = "form-control" id = "emp_id_audit">--}}
{{--</div>--}}
{{--<div class = "col-md-4">--}}
{{--<label for="">Account Details: </label>--}}
{{--<select id="account_details_audit" class = "form-control">--}}
{{--<option value="Toyota">Toyota</option>--}}
{{--<option value="Test1">Test1</option>--}}
{{--<option value="Test2">Test2</option>--}}
{{--</select>--}}
{{--</div>--}}
{{--<div class = "col-md-4">--}}
{{--<label for="">Report Checklist: </label>--}}
{{--<input type="text" class = "form-control" id = "report_checklist_audit">--}}
{{--</div>--}}
{{--</div>--}}
{{--<div class = "row" style = "padding-top : 30px;">--}}
{{--<div class = "col-md-4">--}}
{{--<label for="">Last Name: </label>--}}
{{--<input type="text" class = "form-control" id = "emp_last_name">--}}
{{--</div>--}}
{{--<div class = "col-md-4">--}}
{{--<label for="">Endorsement Date:</label>--}}
{{--<input type="date" class = "form-control" id = "endo_date_audit">--}}
{{--</div>--}}
{{--<div class = "col-md-4">--}}
{{--<label for=""> Completeness: </label>--}}
{{--<select id="completeness_audit" class ="form-control">--}}
{{--<option value="Needs Improvement">Complete</option>--}}
{{--<option value="Incomplete">Incomplete</option>--}}
{{--</select>--}}
{{--</div>--}}
{{--</div>--}}
{{--<div class = "row" style = "padding-top : 30px;">--}}
{{--<div class = "col-md-4">--}}
{{--<label for="">First Name:</label>--}}
{{--<input type="text" class = "form-control" id = "first_name_audit">--}}
{{--</div>--}}
{{--<div class = "col-md-4">--}}
{{--<label for="">Account Name: </label>--}}
{{--<input type="text" class = "form-control" id = "acoount_name_audit">--}}
{{--</div>--}}
{{--<div class = "col-md-4">--}}
{{--<label for="">GPS Compliance: </label>--}}
{{--<select id="gps_comp_audit" class = "form-control">--}}
{{--<option value="Poor Coverage">Poor Coverage</option>--}}
{{--<option value="Good Coverage">Good Coverage</option>--}}
{{--<option value="test2">test</option>--}}
{{--</select>--}}
{{--</div>--}}
{{--</div>--}}
{{--<div class = "row" style = "padding-top : 30px;">--}}
{{--<div class = "col-md-4">--}}
{{--<label for="">Date Hired:</label>--}}
{{--<input type="date" class = "form-control" id = "emp_date_hired">--}}
{{--</div>--}}
{{--<div class = "col-md-4">--}}
{{--<label for="">Visit Date:</label>--}}
{{--<input type="date" class = "form-control" id = "visit_date_audit">--}}
{{--</div>--}}
{{--<div class = "col-md-4">--}}
{{--<label for="">Informants Validity:</label>--}}
{{--<select id="informants_validity_audit" class = "form-control">--}}
{{--<option value="Incomplete/Invalid">Incomplete/Invalid</option>--}}
{{--<option value="Complete/Valid">Complete/Valid</option>--}}
{{--</select>--}}
{{--</div>--}}
{{--</div>--}}
{{--<div class ="row" style = "padding-top: 30px;">--}}
{{--<div class = "col-md-4">--}}
{{--<label for="">Area: </label>--}}
{{--<input type="text" class = "form-control" id = "area_audit">--}}
{{--<input type="text" hidden id = "idProvince">--}}
{{--<input type="text" hidden id = "idMunicipality">--}}
{{--</div>--}}
{{--<div class = "col-md-4">--}}
{{--<label for="">Request: </label>--}}
{{--<select id="request_type_audit" class ="form-control">--}}
{{--<option value="Residence">Residence</option>--}}
{{--<option value="test1">test1</option>--}}
{{--<option value="test2">test2</option>--}}
{{--</select>--}}
{{--</div>--}}
{{--<div class = "col-md-4">--}}
{{--<label for="">Encoding Accuracy: </label>--}}
{{--<select id="encode_acc_audit" class = "form-control">--}}
{{--<option value="Satisfactory">Satisfactory</option>--}}
{{--<option value="test1">test1</option>--}}
{{--<option value="test2">test2</option>--}}
{{--</select>--}}
{{--</div>--}}
{{--</div>--}}
{{--<div class = "row" style = "padding-top : 30px;">--}}
{{--<div class = "col-md-4">--}}
{{--<label for="">Auditor: </label>--}}
{{--<select id="auditor_name_audit" class = "form-control">--}}
{{--<option value="Jerry">Jerryl</option>--}}
{{--<option value="name1">name1</option>--}}
{{--<option value="name2">name2</option>--}}
{{--</select>--}}
{{--</div>--}}
{{--<div class = "col-md-4">--}}
{{--<label for="">Handling Type:</label>--}}
{{--<select id="handling_type_audit" class = "form-control">--}}
{{--<option value="Rush/Expedite">Rush/Expedite</option>--}}
{{--<option value="type1">type1</option>--}}
{{--<option value="type2">type2</option>--}}
{{--</select>--}}
{{--</div>--}}
{{--<div class = "col-md-4">--}}
{{--<label for="">Selfie/ Uniform / ID</label>--}}
{{--<select id="selfie_uni_id" class ="form-control">--}}
{{--<option value="Complete">Complete</option>--}}
{{--<option value="Incomplete">Incomplete</option>--}}
{{--<option value="test1">test1</option>--}}
{{--</select>--}}
{{--</div>--}}
{{--</div>--}}
{{--<div class = "row" style = "padding-top: 30px;">--}}
{{--<div class = "col-md-4">--}}
{{--<label for="">Branch Head:</label>--}}
{{--<select id="branch_head" class = "form-control">--}}
{{--<option value="name1">name1</option>--}}
{{--<option value="name2">name2</option>--}}
{{--<option value="name3">name3</option>--}}
{{--</select>--}}
{{--</div>--}}
{{--<div class = "col-md-4">--}}
{{--<label for="">Source: </label>--}}
{{--<select id="source_audit" class = "form-control">--}}

{{--<option value="OIMS">OIMS</option>--}}
{{--<option value="source1">source1</option>--}}
{{--<option value="source2">source2</option>--}}
{{--</select>--}}
{{--</div>--}}
{{--<div class = "col-md-4">--}}
{{--<label for="">TAT Compliance: </label>--}}
{{--<select id="tat_comp_audit" class = "form-control">--}}
{{--<option value="Breached">Breached</option>--}}
{{--<option value="tat1">tat1</option>--}}
{{--<option value="tat2">tat2</option>--}}
{{--</select>--}}
{{--</div>--}}
{{--</div>--}}
{{--<div class = "row" style = "padding-top : 30px;">--}}
{{--<div class = "col-md-4">--}}
{{--<label for="">Regional Branch Head</label>--}}
{{--<select id="region_head" class = "form-control">--}}
{{--<option value="Julius Esguerra">Julius Esguerra</option>--}}
{{--<option value="name1">name1</option>--}}
{{--<option value="name2">name2</option>--}}
{{--</select>--}}
{{--</div>--}}
{{--<div class = "col-md-4">--}}
{{--<label for="">OIMS ID:</label>--}}
{{--<input type="text" id = "oims_id_audit" class = "form-control">--}}
{{--</div>--}}
{{--<div class = "col-md-4">--}}
{{--<label for="">Attachment: </label>--}}
{{--<input type="file" id = "audit_log_attachment">--}}
{{--</div>--}}
{{--</div>--}}
{{--<div class = "row" style = "padding-top : 30px;">--}}
{{--<div class = "col-md-4">--}}
{{--<label for="">Senior Account Officer:</label>--}}
{{--<select id="srao_audit_log" class ="form-control">--}}
{{--<option value="Not Applicable">Not Applicable</option>--}}
{{--<option value="name1">name1</option>--}}
{{--<option value="name2">name2</option>--}}
{{--</select>--}}
{{--</div>--}}
{{--<div class = "col-md-6">--}}
{{--<label for="">Remarks:</label>--}}
{{--<textarea id="remarks_audit_log" rows="4" placeholder="Insert remarks here...." class = "form-control"></textarea>--}}
{{--</div>--}}
{{--</div>--}}
{{--<div style = "margin-top: 15px;">--}}
{{--<button type = "button" id ="submitAuditLogRep" class = "btn btn-success btn-lg pull-right">SUBMIT</button>--}}
{{--</div>--}}
{{--</div>--}}