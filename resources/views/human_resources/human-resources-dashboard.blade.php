<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Dashboard
            <small>Control panel</small>
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3 id = "empCount"></h3>

                        <p>No. of Employees</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3 id = "empRegular"></h3>

                        <p>No. of Regular Employees</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h3 id = "empProbi"></h3>

                        <p>No. of Probationary Employees</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-red">
                    <div class="inner">
                        <h3 id = "empRes"></h3>

                        <p>No. of Off-Boarding Employees</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
        </div>
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active" id = "tabEmpGen1"><a id="tabEmpList1" href="#tab_a" data-toggle="tab" class = "human_resources_employee_a_class">General Employee List</a></li>
                    <li class="" id = "tabEmpGen2"><a id="tabEmpList2" href="#tab_b" data-toggle="tab" class = "human_resources_employee_a_class">Present Employees(Active)</a></li>
                    <li class="" id = "tabEmpGen3"><a id="tabEmpList3" href="#tab_c" data-toggle="tab" class = "human_resources_employee_a_class">Past Employees(Inactive)</a></li>
                    <li class="" id = "tabEmpGen4"><a id="tabEmpList4" href="#tab_d" data-toggle="tab" class = "human_resources_employee_a_class">Requested for Approval(Employees)</a></li>
                    <li class="" id = "tabEmpGen5"><a id="tabEmpList5" href="#tab_e" data-toggle="tab" class = "human_resources_employee_a_class">Requested for Approval(Employees)</a></li>
                    <li class="" id = "tabEmpGen6"><a id="tabEmpList6" href="#tab_f" data-toggle="tab" class = "human_resources_employee_a_class">Requested for Approval(Employees)</a></li>
                        <li class="" id = "tabEmpGen7"><a id="tabEmpList7" href="#tab_g" data-toggle="tab" class = "human_resources_employee_a_class">Overall Applicant/Employee Monitoring</a></li>
                </ul>
                <div class = "tab-content">
                    <div class="tab-pane active" id="tab_a">
                        <div class="box-body">
                            <div class = "col-md-4">
                                <div class = "box box-danger" style = "padding-bottom : 10px; padding-top: 10px;">
                                    <center>
                                        <h4 style = "font-family: Georgia,serif;">Sort by Contract Expiration</h4>
                                    </center>
                                    <div class = "row">
                                        <div class = "col-md-4">
                                            <input type="radio" name = "due_contract" class = "due_contract_all" checked = "checked">All
                                        </div>
                                        <div class = "col-md-4">
                                            <input type="radio" name = "due_contract" class = "due_contract_60">less than 60 days(<small>Yellow</small>)
                                        </div>
                                        <div class = "col-md-4">
                                            <input type="radio" name = "due_contract" class = "due_contract_30">less than 30 days(<small>Red</small>)
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <table id="human-resources-employee-list" class="tableendorse display table-hover table-condensed" width="100%">
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
                    <div class="tab-pane" id="tab_b">
                        <div class="box-body">
                            <div class = "col-md-4">
                                <div class = "box box-danger" style = "padding-bottom : 10px; padding-top: 10px;">
                                    <center>
                                        <h4 style = "font-family: Georgia,serif;">Sort by Contract Expiration</h4>
                                    </center>
                                    <div class = "row">
                                        <div class = "col-md-4">
                                            <input type="radio" name = "due_contract_present" class = "due_contract_all" checked = "checked">All
                                        </div>
                                        <div class = "col-md-4">
                                            <input type="radio" name = "due_contract_present" class = "due_contract_60">less than 60 days(<small>Yellow</small>)
                                        </div>
                                        <div class = "col-md-4">
                                            <input type="radio" name = "due_contract_present" class = "due_contract_30">less than 30 days(<small>Red</small>)
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <table id="human-resources-present-employees" class="tableendorse display table-hover table-condensed" width="100%">
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
                    <div class="tab-pane" id="tab_c">
                        <div class="box-body">
                            <div class="col-md-12">
                                <table id="human-resources-past-employees" class="tableendorse display table-hover table-condensed" width="100%">
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
                    <div class="tab-pane" id="tab_d">
                        <div class = "box-body">
                            <div class="col-md-12">
                                <table id="human-resources-pending-employees" class="tableendorse display table-hover table-condensed" width="100%">
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
                    <div class="tab-pane" id="tab_e">
                        <div class = "box-body">
                            <div class="col-md-12">
                                <table id="human-resources-pending-employees_rec" class="tableendorse display table-hover table-condensed" width="100%">
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
                    <div class="tab-pane" id="tab_f">
                        <div class = "box-body">
                            <div class="col-md-12">
                                <table id="human-resources-pending-employees_rey" class="tableendorse display table-hover table-condensed" width="100%">
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
                    <div class="tab-pane" id="tab_g">
                        <div class = "box-body">
                            <div class="col-md-12">
                                <table id="human-resources-overall-monitoring" class="tableendorse display table-hover table-condensed" width="100%">
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
    </section>
</div>