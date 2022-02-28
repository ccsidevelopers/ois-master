<!-- Content Wrapper. Contains page content -->
<div class = "content-wrapper">
    <!-- Content Header (Page header) -->
    <section class = "content-header">
        <h1>
           Fund Monitoring - Admin
        </h1>
    </section>

    <!-- Main content -->
    <section class = "content">
        <div class = "nav-tabs-custom">
            <ul class = "nav nav-tabs">
                <li class = "active"><a id="tabFund1" href="#tab_fund1" data-toggle="tab" class = "admin_staff_fund_class">Fund Requests</a></li>
            </ul>
            <div class = "tab-content">
                <div class = "tab-pane active" id = "tab_fund1">
                    <center><h3 style = "font-family: Georgia,serif;">Fund Request</h3></center>
                    <div class = "row" style = "padding-top : 30px;">
                        <div class = "col-md-4">
                            <div class="box box-info" >
                                <center><h3 style = "font-family: Georgia,serif;">Add/Update Request</h3></center>
                                <div class = "row" style = "padding-top : 20px;">
                                    <div class = "col-md-5">
                                        <label for="">Month:</label>
                                        <select id= "fund_month" class = "form-control">
                                            <option value="January">January</option>
                                            <option value="February">February</option>
                                            <option value="March">March</option>
                                            <option value="April">April</option>
                                            <option value="May">May</option>
                                            <option value="June">June</option>
                                            <option value="July">July</option>
                                            <option value="August">August</option>
                                            <option value="September">September</option>
                                            <option value="October">October</option>
                                            <option value="November">November</option>
                                            <option value="December">December</option>
                                        </select>
                                    </div>
                                    <div class = "col-md-2"></div>
                                    <div class = "col-md-5">
                                        <label for="">Branch:</label>
                                        <select id = "fund_branch" class = "form-control">
                                        </select>
                                    </div>
                                </div>
                                <div class = "row" style = "padding-top : 20px;">
                                    <div class = "col-md-5">
                                        <label for="">Requested Amount: <small style = "color: red;">*Required field</small></label>
                                        <input type="text" id = "fund_amount" class = "form-control">
                                    </div>
                                    <div class = "col-md-2"></div>
                                    <div class = "col-md-5">
                                        <label for="">Purpose: <small style = "color: red;">*Required field</small></label>
                                        <input type="text" id = "fund_particular" class = "form-control">
                                    </div>
                                </div>
                                <div class = "row" style = "padding-top : 20px;">
                                    <div class = "col-md-5">
                                        <label for="">Account Number: <small style = "color: red;">*Required field</small></label>
                                        <input type="text" id = "fund_number" class = "form-control">
                                    </div>
                                    <div class = "col-md-2"></div>
                                    <div class = "col-md-5">
                                        <label for="">Statement Date:</label>
                                        <input type="date" id = "fund_date_statement" class = "form-control">
                                    </div>
                                </div>
                                <div class = "row" style = "padding-top : 20px;">
                                    <div class = "col-md-5">
                                        <label for="">Due Date:</label>
                                        <input type="date" id = "fund_date_due" class = "form-control">
                                    </div>
                                    <div class = "col-md-2"></div>
                                    <div class = "col-md-5">
                                        <label for="">Date Requested:</label>
                                        <input type="date" id = "fund_date_requested" class = "form-control">
                                    </div>
                                </div>
                                <div class = "row" style = "padding-top : 20px; padding-bottom: 10px;">
                                    <div class = "col-md-5">
                                        <label for="">Requested and Processed by: <small style = "color: red;">*Required field</small></label>
                                        <input type="text" id = "fund_requestor" class = "form-control">
                                    </div>
                                    <div class = "col-md-7"></div>
                                </div>
                                <div class = "" style = "margin-top : 20px;">
                                    <button type="button" class="btn btn-default pull-left" id = "btnCancelFund">Cancel Update</button>
                                    <button type="button" class="btn btn-warning pull-right" id = "btnUpdateFund">Update Changes</button>
                                    <button type = "button" id ="btnSubmitFund" class = "btn btn-success pull-right">Add Request</button>
                                </div>
                            </div>
                        </div>
                        <div class = "col-md-8">
                            <div class = "box box-info">
                                <center><h3 class = "box-title" style = "font-family: Georgia,serif;">Request List</h3></center>
                                <table id = "admin-staff-fund-monitor" class="tableendorse display table-hover table-condensed" width="100%">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Month</th>
                                        <th>Branch</th>
                                        <th>Amount</th>
                                        <th>Purpose</th>
                                        <th>Account Number</th>
                                        <th>Statement Date</th>
                                        <th>Due Date</th>
                                        <th>Date Requested</th>
                                        <th>Requested and Processed By</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                </table>
                                <div class = "row">
                                    <div class = "col-md-4">
                                        <label for="">Total Fund Requests:</label>
                                        <input type="text" id = "show_total_req" class = "form-control" disabled>
                                    </div>
                                    <div class = "col-md-8"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>