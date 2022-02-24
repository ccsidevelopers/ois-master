<div class="content-wrapper">
    <section class="content-header">
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <h3>Leave Request Form</h3>
            </div>
        </div>
    </section>
    <!-- Main content -->
    <div class="content">
        <div class="row">
            <div class="col-md-6 col-sm-7">
                <div class="box box-default box-solid" style="box-shadow:1px 6px 10px 3px #d2d6de;">
                    
                    
                    
                    <div class="box-header with-border">
                        <i class="fa fa-fw fa-edit"></i>
                        <h3 class="box-title text-capitalize">leave form</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>

                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <div class="form-group text-capitalize margin" style="padding-bottom:2%">
                                    <label for="reason_leave" class="">reason of leave<small class="text-red margin">(required)</small></label>
                                    <textarea class="form-control leave_holder" name="" id="leave_reason" cols="30" rows="10" placeholder="reason for your leave" style="resize: none;"></textarea>
                                </div>
                                <div class="form-group text-capitalize margin" style="padding-bottom:2%">
                                    <label for="leave_type">leave type:<small class="text-red margin">(required)</small></label>
                                    <select name="" id="leave_type_per" class="form-control leave_type_picker leave_holder opt_holder" style="cursor:pointer;">
                                        <option value="">--</option>
                                        <option value="Sick Leave">Sick Leave</option>
                                        <option value="Vacation Leave">Vacation Leave</option>
                                        <option value="Maternity Leave">Maternity Leave</option>
                                        <option value="Paternity Leave">Paternity Leave</option>
                                        <option value="Bereavement Leave">Bereavement Leave</option>
                                        <option value="Casual Leave">Casual Leave</option>
                                        <option value="Solo Parent Leave">Solo Parent Leave</option>
                                        <option value="Emergency Leave">Emergency Leave</option>
                                    </select>
                                </div>
                                <div class="form-group text-capitalize margin">
                                    <div class="col-md-5 col-sm-5 col-xs-12 no-padding">
                                        <label for="start_date">start date<small class="text-red margin">(required)</small></label>
                                        <input type="date" class="form-control leave_holder date_holder" id="your_leave_start">
                                    </div>
                                    <div class="col-md-5 col-sm-5 col-xs-12 no-padding pull-right">
                                        <label for="start_date">end date<small class="text-red margin">(required)</small></label>
                                        <input type="date" class="form-control leave_holder date_holder" id="your_leave_end">
                                    </div>
                                </div>
                                <div class="form-group" id="option_others_leave" hidden >
                                    <input type="text" class="form-control opt_others_leave opt_holder" id="opt_others_leave" required placeholder="Please Specify">
                                </div>

                                <div class="form-group">
                                    <div class="upload_append" id="upload_append_id">
                                        <div class="col-md-9 col-sm-9 no-padding">
                                            <label for="leave_file_upload" class="btn btn-success text-capitalize text-muted pull-left file_upload_btn" style="border: 1px solid #00a65a;border-radius: 4px;box-shadow: -3px 7px 4px 2px #ddd; margin:5% 0 0 2%;"><i class="fa fa-fw fa-plus"></i> attachments</label>
                                            <input type="file" class="leave_holder" id="leave_file_upload" style="display:none;">
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="box-footer text-uppercase">
                        <button type="button" id="leave_send_form" class="btn btn-primary text-uppercase pull-right margin" style="box-shadow: 1px 8px 4px #ddd;">submit <i class="fa fa-fw fa-caret-right"></i> </button>
                    </div>
                </div>
            </div>

            <div class="col-md-5 col-sm-5">
                <div class="box box-default box-solid" style="box-shadow:1px 6px 10px 3px #d2d6de;">
                    
                        
                    
                    <div class="box-header with-border">
                        <i class="fa fa-fw fa-database"></i>
                        <h3 class="box-title text-capitalize">your leave request information</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="box-body">
                        <table class="table table-bordered table-hover">
                            <tbody>
                            <tr style="background-color:#f1f1f1;">
                                <th class="text-uppercase text-left" style="padding-left:7%">type of leave</th>
                                <th class="text-uppercase" style="width: 25%;">taken</th>
                                <th class="text-uppercase" style="width: 25%;">remaining</th>
                            </tr>
                            <tr>
                                <td><h5 class="text-left" style="padding-left:10%" >Additional Leave<medium class="text-red margin">(5)</medium></h5></td>
                                <td><input type="text" class="form-control xamp text-right" id="additional_leave_taken" name="add_leave_me" disabled></td>
                                <td><input type="text" class="form-control xamp text-right" id="additional_leave_remaining" name="add_leave_me" disabled></td>
                            </tr>
                            <tr>
                                <td><h5 class="text-left" style="padding-left:10%" >Service Incentive Leave<medium class="text-red margin">(5)</medium></h5></td>
                                <td><input type="text" class="form-control total_add_leave text-right" id="service_incentive_taken" name="service_leave_me" disabled></td>
                                <td><input type="text" class="form-control total_add_leave text-right" id="service_incentive_remaining" name="service_leave_me" disabled></td>
                            </tr>
                            <tr>
                                <td><h5 class="text-left" style="padding-left:10%">Maternity Leave<medium class="text-red margin">(105)</medium></h5></td>
                                <td><input type="text" class="form-control consumed_service_leave text-right" id="maternity_leave_taken" name="consume_leave_me" disabled></td>
                                <td><input type="text" class="form-control consumed_service_leave text-right" id="maternity_leave_remaining" name="consume_leave_me" disabled></td>
                            </tr>
                            <tr>
                                <td><h5 class="text-left" style="padding-left:10%">Paternity Leave<medium class="text-red margin">(7)</medium></h5></td>
                                <td><input type="text" class="form-control total_leave2 text-right" id="paternity_leave_taken" disabled></td>
                                <td><input type="text" class="form-control total_leave2 text-right" id="paternity_leave_remaining" disabled></td>
                            </tr>
                            <tr>
                                <td><h5 class="text-left" style="padding-left:10%">Solo Parent Leave<medium class="text-red margin">(7)</medium></h5></td>
                                <td><input type="text" class="form-control total_leave2 text-right" id="solo_parent_leave_taken" disabled></td>
                                <td><input type="text" class="form-control total_leave2 text-right" id="solo_parent_leave_remaining" disabled></td>
                            </tr>
                            <tr>
                                <td><h5 class="text-left" style="padding-left:10%">Emergency Parent Leave<medium class="text-red margin">(7)</medium></h5></td>
                                <td><input type="text" class="form-control total_leave2 text-right" id="other_leave_taken" disabled></td>
                                <td><input type="text" class="form-control total_leave2 text-right" id="other_leave_remaining" disabled></td>
                            </tr>
                            </tbody>
                        </table>

                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12 col-sm-12">
                <div class="box box-default box-solid" style="box-shadow:1px 6px 10px 3px #d2d6de;">
                    
                    
                    
                    <div class="box-header with-border">
                        <i class="fa fa-fw fa-desktop"></i>
                        <h3 class="box-title text-capitalize">current leave request information</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <table class="table table-bordered table-hover table_emp_leave_stats" id="table_emp_leave_status">
                                    <thead>
                                    <tr class="table-primary text-uppercase">
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Days Payable</th>
                                        <th>Days Filed</th>
                                        <th>Reason</th>
                                        <th>Leave Type</th>
                                        <th style="width:7%;">Status</th>
                                        <th style="width:12%;">Action</th>
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