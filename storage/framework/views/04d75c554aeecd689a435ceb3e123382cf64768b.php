<div class="content-wrapper">
    <section class="content-header">
        <h1>
            EMPLOYEES
        </h1>
    </section>
    <section class = "content">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_main1" data-toggle="tab" class = "admin_staff_employee_class">Employee General Monitoring</a></li>
                <li><a href="#tab_main2" data-toggle="tab" class = "admin_staff_employee_class">Employment Needs</a></li>
            </ul>
            <div class = "tab-content">
                <div class="tab-pane active" id="tab_main1">

                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#tab_mainEmp1" data-toggle="tab" class = "admin_staff_employee_option">On-Process</a></li>
                            <li><a href="#tab_mainEmp2" data-toggle="tab" class = "admin_staff_employee_option">Onboard</a></li>
                        </ul>
                        <div class = "tab-content">
                            <div class="tab-pane active" id="tab_mainEmp1">
                                <h3 style = "text-align: center">On-Process Employee/Applicant</h3>
                                <div class = "row">
                                    <div class="col-md-12">
                                        <table id="admin-staff-employee-list-view" class="tableendorse display table-hover table-condensed" width=100%>
                                            <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Employee Name</th>
                                                <th>Position</th>
                                                <th>Branch</th>
                                                <th>Date of Birth</th>
                                                <th>Gender</th>
                                                <th>Marital Status</th>
                                                <th>Contract Status</th>
                                                <th>Employment Status</th>
                                                <th>Date Hired</th>
                                                <th>End of Contract</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab_mainEmp2">
                                <h3 style = "text-align: center">Onboard Employee/Applicant</h3>
                                <div class = "row">
                                    <div class="col-md-12">
                                        <table id="admin-staff-employee-list-view-approved" class="tableendorse display table-hover table-condensed" width=100%>
                                            <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Employee Name</th>
                                                <th>Position</th>
                                                <th>Branch</th>
                                                <th>Date of Birth</th>
                                                <th>Gender</th>
                                                <th>Marital Status</th>
                                                <th>Contract Status</th>
                                                <th>Employment Status</th>
                                                <th>Date Hired</th>
                                                <th>End of Contract</th>
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

                <div class="tab-pane" id="tab_main2">
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#tab_stat1" data-toggle="tab" class = "admin_staff_status_class">ID, Uniform , Insurance and ATM</a></li>
                        </ul>
                        <div class = "tab-content">
                            <div class = "tab-pane active" id = "tab_stat1">
                                <div class = "box-body">
                                    <div class = "row">
                                        <div class = "col-md-4">
                                            <div class = "box box-info">
                                                <h3 style = "font-family: Georgia,serif; text-align: center;">Details</h3>
                                                <div class = "row" style = "padding-top : 20px;">
                                                    <div class="col-md-8">
                                                        <label>Employee Name:</label>
                                                        <select class="form-control select2" style="width: 100%;" id="empAtmId" name = "empAtmId">
                                                        </select>
                                                    </div>
                                                    <div class = "col-md-4"></div>
                                                </div>
                                                <div class = "row" style = "padding-top : 20px;">
                                                    <div class = "col-md-5">
                                                        <label for="">ID:</label>
                                                        <select id = "emp_id_card" class = "form-control">
                                                            <option value="With ID">With ID</option>
                                                            <option value="Without ID">Without ID</option>
                                                        </select>
                                                    </div>
                                                    <div class = "col-md-2"></div>
                                                    <div class = "col-md-5">
                                                        <label for="">ID no:</label>
                                                        <input type="text" id = "emp_id_no" class = "form-control">
                                                    </div>
                                                </div>
                                                <div class = "row" style = "padding-top: 20px; ">
                                                    <div class = "col-md-5">
                                                        <label for="">Uniform:</label>
                                                        <input type="text" id = "emp_uniform" class = "form-control">
                                                    </div>
                                                    <div class = "col-md-2"></div>
                                                    <div class = "col-md-5">
                                                        <label for="">Bank:</label>
                                                        <select id = "emp_bank" class = "form-control">
                                                            <option value="None">None</option>
                                                            <option value="Metrobank">Metrobank</option>
                                                            <option value="UnionBank">UnionBank</option>
                                                            <option value="Robinsons Bank">Robinsons Bank</option>
                                                            <option value="East West Bank">East West Bank</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class = "row" style = "padding-top : 20px;">
                                                    <div class = "col-md-5">
                                                        <label for="">Facebook/Messenger: </label>
                                                        <input type="text" class = "form-control" id = "fb_emp">
                                                    </div>
                                                    <div class = "col-md-2"></div>
                                                    <div class = "col-md-5">
                                                        <label for="">Computer:</label>
                                                        <input type="text" id = "computer_emp" class = "form-control">
                                                    </div>
                                                </div>
                                                <h4 style = "font-family: Georgia,serif; text-align: center; padding-top : 20px;">Company Phone</h4>
                                                <div class = "row" style = "padding-bottom: 20px;">
                                                    <div class = "col-md-5">
                                                        <label for="">Phone number: </label>
                                                        <input type="text" class = "form-control" id = "emp_phone_number">
                                                    </div>
                                                    <div class = "col-md-2"></div>
                                                    <div class = "col-md-5">
                                                        <label for="">Unit Price:</label>
                                                        <input type="number" class = "form-control" id = "emp_phone_price">
                                                    </div>
                                                </div>
                                                <div class = "row" style = "padding-bottom: 20px;">
                                                    <div class = "col-md-12">
                                                        <label for="">Phone Description:</label>
                                                        <textarea class = "form-control" id = "emp_phone_desc" rows = "3" placeholder="Enter phone description....."></textarea>
                                                    </div>
                                                    <div class = "col-md-2"></div>
                                                </div>
                                                <h4 style = "font-family: Georgia,serif; text-align: center; padding-top : 10px;">OIMS and Gmail Access</h4>
                                                <div class = "row" style = "padding-top : 30px; ">
                                                    <div class = "col-md-5">
                                                        <label for="">Corporate Gmail Address:</label>
                                                        <input type="text" id = "gmail_emp" class = "form-control">
                                                    </div>
                                                    <div class = "col-md-2"></div>
                                                    <div class = "col-md-5">
                                                        <label for="">OIMS username/email address:</label>
                                                        <input type="text" id = "oims_emp" class = "form-control">
                                                    </div>
                                                </div>
                                                <div class = "row" style = "padding-top : 10px; padding-bottom : 20px;">
                                                    <div class = "col-md-5">
                                                        <label for="">Gmail Password:</label>
                                                        <input type="text" id = "gmail_pass" class = "form-control">
                                                    </div>
                                                    <div class = "col-md-2"></div>
                                                    <div class = "col-md-5">
                                                    </div>
                                                </div>

                                                <h4 style = "font-family: Georgia,serif; text-align: center;">Insurance</h4>
                                                <div class = "row" style = "padding-bottom: 20px;">
                                                    <div class = "col-md-5">
                                                        <label for="emp_health_card">Health Card:</label>
                                                        <input type="text" class = "form-control" id = "emp_health_card">
                                                    </div>
                                                    <div class = "col-md-2"></div>
                                                    <div class = "col-md-5">
                                                        <label for="">Accident Insurance:</label>
                                                        <select id = "emp_accident" class = "form-control">
                                                            <option value="Insured">Insured</option>
                                                            <option value="Not Insured">Not Insured</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class = "pull-right" style = "padding-top: 20px;">
                                                    <button type = "button" id ="btnAtm" class = "btn btn-success btn pull-right">Update Details</button>
                                                </div>

                                            </div>
                                        </div>
                                        <div class = "col-md-8">
                                            <div class = "box box-info">
                                                <h3 style = "font-family: Georgia,serif; text-align: center; padding-bottom : 20px;">Requested Items for Employees</h3>
                                                <div class="col-md-12">
                                                    <table id="admin-staff-atm-uni" class="tableendorse display table-hover table-condensed" width="100%">
                                                        <thead>
                                                        <tr>
                                                            <th>ID</th>
                                                            <th>Employee Name</th>
                                                            <th>Branch</th>
                                                            <th>Position</th>
                                                            <th>View</th>
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
        </div>
    </section>
</div>