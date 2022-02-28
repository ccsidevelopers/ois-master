<div class="content-wrapper">
    <section class="content-header">
        <h1>
           Productivity
        </h1>
    </section>
    <section class = "content">
        <div class="row" id="showAccessForDepartment" hidden>
            <div class = "col-md-4">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h4 style = "text-align : center">Department</h4>
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <div class="row" style="padding-top : 20px;">
                                <div class="col-md-1"></div>
                                <div class="col-md-10">
                                    <label for="">Select Department: </label>
                                    <select id="departmentSelectProd" class="form-control">
                                        <option value="-">-</option>
                                        <option value="Bank">Bank</option>
                                        <option value="Tele-Verifier">Tele-Verifier</option>
                                    </select>
                                </div>
                                <div class="col-md-1"></div>
                            </div>
                            <div class="row" id="selectInternalCC" style="padding-top : 20px;" hidden>
                                <div class="col-md-1"></div>
                                <div class="col-md-10">
                                    <label for="">Internal Department: </label>
                                    <select id="internalCCSelect" class="form-control">
                                        <option value="-">-</option>
                                        <option value="Call Center">Call Center</option>
                                        <option value="Tele-TFS">Tele-TFS</option>
                                    </select>
                                </div>
                                <div class="col-md-1"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row" id="showForBankProduc" hidden>
            <div class = "col-md-4">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h4 style = "text-align : center">Employee Info</h4>
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <div class="row" style="padding-top : 20px;">
                                <div class="col-md-1"></div>
                                <div class="col-md-10">
                                    <label for="">Employee Position:</label>
                                    <select id="positionProductivity" class="form-control">
                                        <option value="-">-</option>
                                        <option value="Account Officer">Account Officer</option>
                                        <option value="Field Verifier">Field Verifier</option>
                                    </select>
                                </div>
                                <div class="col-md-1"></div>
                            </div>
                            <div class="row" style="padding-top : 20px;" id="showCIListProd" hidden>
                                <div class="col-md-1"></div>
                                <div class="col-md-10">
                                    <label for="">Employee Name:</label>
                                    <select id="ciProductivityNames" class = "form-control select2" style = "width : 100%;">
                                        <option value="-">-</option>
                                    </select>
                                </div>
                                <div class="col-md-1"></div>
                            </div>
                            <div class="row" style="padding-top : 20px;" id="showAOListProd" hidden>
                                <div class="col-md-1"></div>
                                <div class="col-md-10">
                                    <label for="">Employee Name:</label>
                                    <select id="aoProductivityNames" class = "form-control select2" style = "width : 100%;">
                                        <option value="-">-</option>
                                    </select>
                                </div>
                                <div class="col-md-1"></div>
                            </div>
                            <div class="row" style="padding-top : 20px;" id="showTimeStampProd" hidden>
                                <div class="col-md-1"></div>
                                <div class="col-md-10">
                                    <label for="">Sort by:</label>
                                    <select id="sortByProd" class="form-control">
                                        <option value="Day">Day</option>
                                        <option value="Week">Week</option>
                                        <option value="Month">Month</option>
                                        <option value="Year">Year</option>
                                    </select>
                                </div>
                                <div class="col-md-1"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class = "col-md-8" id="showHideProductivityTable" hidden>
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h4 style = "text-align : center">Productivity Information</h4>
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <div class="row" style="padding-top : 20px;">
                                <div class="col-md-12">
                                    <table id="sao_productivity_table" class="tableendorse table-hover table-condensed" width="100%" style="font-size: 13px;">
                                        <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>No. of Dispatched</th>
                                            <th>No. of Pending</th>
                                            <th>Within TAT</th>
                                            <th>Out of TAT</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tfoot>
                                        <tr>
                                            <th>Date</th>
                                            <th>No. of Dispatched</th>
                                            <th>No. of Pending</th>
                                            <th>Within TAT</th>
                                            <th>Out of TAT</th>
                                            <th>Action</th>
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

        <div class="row" id="showFoCCProduc" hidden>
            <input type="text" id="currentAccess" hidden>
            <div class = "col-md-4">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h4 style = "text-align : center">Employee Info</h4>
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <div class="row" style="padding-top : 20px;" id="showForCCBank" hidden>
                                <div class="col-md-1"></div>
                                <div class="col-md-10">
                                    <label for="">Employee Name:</label>
                                    <select id="ccteleList" class = "form-control select2" style = "width : 100%;">
                                        <option value="-">-</option>
                                    </select>
                                </div>
                                <div class="col-md-1"></div>
                            </div>
                            <div class="row" style="padding-top : 20px;" id="showForTeleTFS" hidden>
                                <div class="col-md-1"></div>
                                <div class="col-md-10">
                                    <label for="">Employee Name:</label>
                                    <select id="teleTFSList" class = "form-control select2" style = "width : 100%;">
                                        <option value="-">-</option>
                                    </select>
                                </div>
                                <div class="col-md-1"></div>
                            </div>
                            <div class="row" style="padding-top : 20px;" id="showTimeStampProdCC" hidden>
                                <div class="col-md-1"></div>
                                <div class="col-md-10">
                                    <label for="">Sort by:</label>
                                    <select id="sortByProdCC" class="form-control">
                                        <option value="Day">Day</option>
                                        <option value="Week">Week</option>
                                        <option value="Month">Month</option>
                                        <option value="Year">Year</option>
                                    </select>
                                </div>
                                <div class="col-md-1"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class = "col-md-8" id="showHideProductivityCC" hidden>
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h4 style = "text-align : center">Productivity Information</h4>
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <div class="row" style="padding-top : 20px;">
                                <div class="col-md-12">
                                    <table id="cc_productivity_table" class="tableendorse table-hover table-condensed" width="100%" style="font-size: 13px;">
                                        <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>No. of Dispatched</th>
                                            <th>No. of Pending</th>
                                            <th>Within TAT</th>
                                            <th>Out of TAT</th>
                                            <th>
                                                <div class="row ccBankStat" hidden>
                                                    Contacted
                                                </div>

                                                <div class=" row ccStat" hidden>
                                                    Complete
                                                </div>
                                            <th>
                                                <div class="row ccBankStat" hidden>
                                                    Uncontacted
                                                </div>

                                                <div class="row ccStat" hidden>
                                                    Partial
                                                </div>
                                            </th>
                                            <th>Call Duration</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tfoot>
                                        <tr>
                                            <th>Date</th>
                                            <th>No. of Dispatched</th>
                                            <th>No. of Pending</th>
                                            <th>Within TAT</th>
                                            <th>Out of TAT</th>
                                            <th>
                                                <div class="row ccBankStat" hidden>
                                                    Contacted
                                                </div>

                                                <div class=" row ccStat" hidden>
                                                    Complete
                                                </div>
                                            <th>
                                                <div class="row ccBankStat" hidden>
                                                    Uncontacted
                                                </div>

                                                <div class="row ccStat" hidden>
                                                    Partial
                                                </div>
                                            </th>
                                            <th>Call Duration</th>
                                            <th>Action</th>
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

    </section>
</div>