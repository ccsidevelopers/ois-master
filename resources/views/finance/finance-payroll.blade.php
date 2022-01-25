<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Payroll
        </h1>

    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="box">
            <div class="box-body">
                <div class="box box-danger">
                </div>
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#payrollTab_1" data-toggle="tab">Attendance</a></li>
                        <li class=""><a href="#payrollTab_2" data-toggle="tab">Example tab 2</a></li>
                        <li class=""><a href="#payrollTab_3" data-toggle="tab">Example tab 3</a></li>
                        <li class=""><a href="#payrollTab_4" data-toggle="tab">Example tab 4</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="payrollTab_1">
                            <div class="cold-md-3">
                                <label for="fileDTR"><small style="color: red">Please upload an Excel File.</small></label>
                                <input type="file" id="fileDTR">
                            </div>
                            <div class="row" style="margin-top: 15px;">
                                <div class="col-md-2">
                                    <button class="btn btn-success" id="btnViewAtt"> View <i class="glyphicon glyphicon-eye-open"></i></button>
                                </div>
                            </div>
                            <div class="row" style="margin-top: 15px;">
                                <div class="col-md-12">
                                    <span id ="testExcelTable"></span>
                                </div>
                            </div>
                        </div>


                        <div class="tab-pane " id="payrollTab_2"></div>



                        <div class="tab-pane " id="payrollTab_3"></div>



                        <div class="tab-pane " id="payrollTab_4"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>