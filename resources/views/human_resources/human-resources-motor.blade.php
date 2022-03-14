<div class="content-wrapper">
    <section class="content-header">
        <h1>
            MOTORCYCLE
        </h1>
    </section>
    <section class = "content">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a id="motor1" href="#tab_motor1" data-toggle="tab" class = "human_resources_motor_class">Motorcyle Details/List</a></li>
            </ul>
            <div class = "tab-content">
                <div class="tab-pane active" id="tab_motor1">

                    <div class = "row">
                        <div class = "col-md-4">
                            <div class = "box box-info">
                                <center>
                                    <h3 style = "font-family: Georgia,serif;">Add/Update Motor Details</h3>
                                </center>
                                <div class = "row" style = "padding-top : 50px;">
                                    <div class = "col-md-8">
                                        <label for="motor_ci_name">CI Name: </label>
                                        <select id="motor_ci_name" class = "form-control"></select>
                                    </div>
                                    <div class = "col-md-4"></div>
                                </div>
                                <div class = "row" style = "padding-top : 30px;">
                                    <div class = "col-md-5">
                                        <label for="motor_model">Model: <small style = "color: red">*Required field</small></label>
                                        <input type="text" class = "form-control" id = "motor_model">
                                    </div>
                                    <div class = "col-md-2"></div>
                                    <div class = "col-md-5">
                                        <label for="motor_orcr">With ORCR?</label>
                                        <select id="motor_orcr" class = "form-control">
                                            <option value="Yes">Yes</option>
                                            <option value="No">No</option>
                                        </select>
                                    </div>
                                </div>
                                <div class = "row" style = "padding-top : 10px;">
                                    <div class = "col-md-5">
                                        <label for="motor_cc">Cubic Centimeter: </label>
                                        <input type="text" class = "form-control" id = "motor_cc">
                                    </div>
                                    <div class = "col-md-2"></div>
                                    <div class = "col-md-5">
                                        <label for="motor_plate">Plate Number: <small style = "color: red">*Required field</small></label>
                                        <input type="text" class = "form-control" id = "motor_plate">
                                    </div>
                                </div>

                                <div class = "row" style = "padding-top : 10px;">
                                    <div class = "col-md-5">
                                        <label for="motor_renew">Latest Month of Renewal of Registration:</label>
                                        <select id = "motor_renew" class = "form-control">
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
                                        <label for="motor_kmpl">Kilometers per Liter:</label>
                                        <input type="text" class = "form-control" id = "motor_kmpl">
                                    </div>
                                </div>

                                <div class = "row" style = "padding-top : 10px; padding-bottom: 10px;">
                                    <div class = "col-md-5">
                                        <label for="motor_name">Registered Name: <small style = "color: red">*Required field</small></label>
                                        <input type="text" class = "form-control" id = "motor_name">
                                    </div>
                                    <div class = "col-md-2"></div>
                                    <div class = "col-md-5">
                                        <label for="motor_gas">Gas Tank Capacity:</label>
                                        <input type="text" class = "form-control" id = "motor_gas">
                                    </div>
                                </div>
                                <div class = "row" style = "padding-top : 10px; padding-bottom: 10px;">
                                    <div class = "col-md-6">
                                        <label for="">Motorcycle Reference:</label>
                                        <input type="file" id = "motor_file">
                                    </div>
                                </div>
                                <div class = "" style = "margin-top: 20px;">
                                    <button type = "button" id ="btnMotorCancel" class = "btn btn-default btn pull-left">Cancel Update</button>
                                    <button type = "button" id ="btnUpdateMotor" class = "btn btn-warning btn pull-right">Update Motorcycle</button>
                                    <button type = "button" id ="btnMotor" class = "btn btn-success btn pull-right">Add Motorcycle</button>
                                </div>
                            </div>
                        </div>
                        <div class = "col-md-8">
                            <div class = "box box-info">
                                <center>
                                    <h3 style = "font-family: Georgia,serif;">Motor List</h3>
                                </center>
                                <div class = "row" style = "padding-top :50px;">
                                    <div class = "col-md-12">
                                        <div style = "overflow: scroll">
                                            <table id="human-resources-motor-list" class="table-condensed" width="100%">
                                                <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>CI Name</th>
                                                    <th>Model</th>
                                                    <th>Cubic Centimeter</th>
                                                    <th>Month of Latest Renewal of Registration</th>
                                                    <th>Registered Name</th>
                                                    <th>With ORCR</th>
                                                    <th>Plate Number</th>
                                                    <th>Kilometers per Liter</th>
                                                    <th>Gas Tank Capacity</th>
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
    </section>
</div>