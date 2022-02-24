<div class="content-wrapper">
    <section class="content-header">
       <h3>Manpower Endorse Request</h3>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-4 col-sm-4">
                <div class="box box-default box-solid" style="box-shadow:1px 6px 10px 3px #d2d6de;">
                    <div class="box-header with-border">
                        <h3 class="box-title">List of Request</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <table class="table table-bordered table-hover dataTable"  id="manpower_endorse_request_table">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Reason for vacancy</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-sm-10">
                    <div class="row">
                        <div class="box box-default box-solid">
                            <div class="overlay" id="manpower_loading">
                                <i class="fa fa-refresh fa-spin"></i>
                            </div>
                            <div class="box-header with-border">
                                <h3 class="box-title">Action Buttons</h3>
                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-12 col-sm-12">
                                        <div class="col-md-6">
                                            <button what="manpower_acknowledge" class=" btn btn-block btn-info manpower_action_btns" id="manpower_acknowledge_btn"><i class="fa fa-thumbs-up"></i> Done</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8 col-sm-7">
                <div class="box box-default box-solid" style="box-shadow:1px 6px 10px 3px #d2d6de;">
                    <div class="overlay" id="manpower_loading">
                        <i class="fa fa-refresh fa-spin"></i>
                    </div>
                    <div class="box-header with-border">
                        <h3 class="box-title">Manpower Request Info Table</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <table class="table-condensed" style="width:100%;" id="table_manpower_request">
                                    <tr>
                                        <th colspan="8" style ="background:#000000e0;color:#fff" class="text-uppercase"><h4>MANPOWER REQUISITION FORM</h4></th>
                                    </tr>
                                    <tr>
                                        <td colspan="4">
                                            <div class="row">
                                                <div class = "col-md-9 col-sm-9">
                                                    <span class = "pull-left font-big">Date of Request:</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td colspan="4">
                                            <input type="date"class="form-control toClear manpower_management_toclear font-big" id="manpower_dateofrequest" disabled value="<?php echo e(date('Y-m-d')); ?>">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4">
                                            <div class="row">
                                                <div class="col-md-9 col-sm-9">
                                                    <span class="pull-left font-big"> Requested by:</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td colspan = "4">
                                            <input type="text" class ="form-control manpower_management_toclear font-big" id="manpower_requestedby" disabled >
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4">
                                            <div class ="row">
                                                <div class = "col-md-9 col-sm-9">
                                                    <span class="pull-left font-big"> Office Location-Department-Position:</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td colspan="4">
                                            <input type="text" class ="form-control toClear manpower_management_toclear font-big" id="manpower_office_loc" disabled="">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4">
                                            <div class ="row">
                                                <div class = "col-md-9 col-sm-9">
                                                    <span class="pull-left font-big text-capitalize text-red"> due date:</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <input type="date" class ="form-control toClear manpower_management_toclear font-big text-red" id="manpower_duedate" disabled value="<?php echo e(date('Y-m-d')); ?>">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th colspan="8" style = "background:#000000e0; color : #fff;" class="text-uppercase"><h4>reason for vacancy</h4></th>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <div class="row">
                                                <div class="col-md-9 col-sm-9">
                                                <span class="pull-left">
                                                    <input type="checkbox" disabled class="manpower_checkbox_grp_1 manpower_management_toclear" id="manpower_awol" value="AWOL" name="AWOL">
                                                    <label style="text-align: center" for="manpower_awol" class="font-big">AWOL</label>
                                                </span>
                                                </div>
                                            </div>
                                        </td>
                                        <td colspan="6" rowspan="9">
                                            <textarea class="form-control manpower_management_toclear font-big" id="reason_vacancy_text_area" rows="16" style="resize:none;" placeholder="REMARKS" disabled></textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <div class="row">
                                                <div class="col-md-9 col-sm-9">
                                                <span class="pull-left">
                                                    <input type="checkbox" disabled class="manpower_checkbox_grp_1 manpower_management_toclear" id="manpower_endo" value="End of contract" name="End of contract">
                                                    <label style="text-align: center" for="manpower_endo" class="font-big">End of contract</label>
                                                </span>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <div class="row">
                                                <div class="col-md-9 col-sm-9">
                                                <span class="pull-left">
                                                    <input type="checkbox" disabled class="manpower_checkbox_grp_1 manpower_management_toclear" id="manpower_resignation" name="Resignation" value="Resignation">
                                                    <label style="text-align: center" for="manpower_resignation" class="font-big">Resignation</label>
                                                </span>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <div class="row">
                                                <div class="col-md-9 col-sm-9">
                                                <span class="pull-left">
                                                    <input type="checkbox" disabled class="manpower_checkbox_grp_1 manpower_management_toclear" name="Termination" id="manpower_termination" value="Termination">
                                                    <label style="text-align: center" for="manpower_termination" class="font-big">Termination</label>
                                                </span>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <div class="row">
                                                <div class="col-md-9 col-sm-9">
                                                <span class="pull-left">
                                                    <input type="checkbox" disabled class="manpower_checkbox_grp_1 manpower_management_toclear" name="Retrenchment" id="manpower_retrenchment" value="Retrenchment">
                                                    <label style="text-align: center" for="manpower_retrenchment" class="font-big">Retrenchment</label>
                                                </span>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <div class="row">
                                                <div class="col-md-9 col-sm-9">
                                                <span class="pull-left">
                                                    <input type="checkbox" disabled class="manpower_checkbox_grp_1 manpower_management_toclear" name="Redundancy" id="manpower_redundancy" value="Redundancy">
                                                    <label style="text-align: center" for="manpower_redundancy" class="font-big">Redundancy</label>
                                                </span>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <div class="row">
                                                <div class="col-md-9 col-sm-9">
                                                <span class="pull-left">
                                                    <input type="checkbox" disabled class="manpower_checkbox_grp_1 manpower_management_toclear" name="Promotion" id="manpower_promotion" value="Promotion">
                                                    <label style="text-align: center" for="manpower_promotion" class="font-big">Promotion</label>
                                                </span>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <div class="row">
                                                <div class="col-md-9 col-sm-9">
                                                <span class="pull-left">
                                                    <input type="checkbox" disabled  class="manpower_checkbox_grp_1 manpower_management_toclear" name="New" id="manpower_new" value="New">
                                                    <label style="text-align: center" for="manpower_new" class="font-big">New</label>
                                                </span>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <div class="row">
                                                <div class="col-md-9">
                                                    <span class="pull-left">
                                                        <input type="checkbox" disabled class="manpower_checkbox_grp_1 manpower_management_toclear" name="Change of assignment" id="manpower_assignment" value="Change of assignment">
                                                        <label style="text-align: center" for="manpower_assignment" class="font-big">Change of assignment</label>
                                                    </span>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th colspan="8" style = "background:#000000e0; color : #fff;" class="text-uppercase"><h4>job details</h4></th>
                                    </tr>
                                    <tr>
                                        <td colspan="3">
                                            <div class="row">
                                                <div class="col-md-9 col-sm-9">
                                                <span class="pull-left font-big">Location-Department-Position
                                                </span>
                                                </div>
                                            </div>
                                        </td>
                                        <td colspan="5">
                                            <input type="text" class="form-control manpower_management_toclear font-big" id="manpower_location_dept_pos" disabled>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">
                                            <div class="row">
                                                <div class="col-md-9 col-sm-9">
                                                <span class="pull-left font-big">No. of candidate/s
                                                </span>
                                                </div>
                                            </div>
                                        </td>
                                        <td colspan="5">
                                            <input type="number" class="form-control manpower_management_toclear font-big" id="manpower_no_candidate" disabled>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">
                                            <div class="row">
                                                <div class="col-md-9 col-sm-9">
                                                <span class="pull-left font-big">Qualification required/desired
                                                </span>
                                                </div>
                                            </div>
                                        </td>
                                        <td colspan="5">
                                            <input type="text" class="form-control manpower_management_toclear font-big" id="manpower_quali_required_desired" disabled="">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">
                                            <div class="row">
                                                <div class="col-md-9 col-sm-9">
                                                <span class="pull-left font-big">Job offer/salary
                                                </span>
                                                </div>
                                            </div>
                                        </td>
                                        <td colspan="5">
                                            <input type="number" class="form-control manpower_management_toclear font-big" id="job_offer_salary" disabled>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th colspan="8" style = "background:#000000e0; color : #fff;" class="text-uppercase"><h4>equipment request</h4></th>
                                    </tr>
                                    <tr>
                                        <th colspan="4" style = "background-color:#a9a9a98a; color:black;"><h6>Field Based</h6></th>
                                        <th colspan="4" style = "background-color:#a9a9a98a; color:black;"><h6>Office Based</h6></th>
                                    </tr>
                                    <tr>
                                        <td colspan="4">
                                            <div class="row">
                                                <div class="col-md-9 col-sm-9">
                                                <span class="pull-left">
                                                    <input type="checkbox" disabled name="0" class="manpower_checkbox_grp_2 manpower_management_toclear" id="manpower_equip_request_atm_1">
                                                    <label style="text-align: left;" for="manpower_equip_request_atm_1" class="font-big">ATM</label>
                                                </span>
                                                </div>
                                            </div>
                                        </td>
                                        <td colspan="4">
                                            <div class="row">
                                                <div class="col-md-9 col-sm-9">
                                                <span class="pull-left">
                                                    <input type="checkbox" name="1" disabled class="manpower_checkbox_grp_2 manpower_management_toclear" id="manpower_equip_request_atm_2">
                                                    <label style="text-align: left" for="manpower_equip_request_atm_2" class="font-big">ATM</label>
                                                </span>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4">
                                            <div class="row">
                                                <div class="col-md-9 col-sm-9">
                                                <span class="pull-left">
                                                    <input type="checkbox" disabled name="2" class="manpower_checkbox_grp_2 manpower_management_toclear" id="manpower_gas_card">
                                                    <label style="text-align: left" for="manpower_gas_card" class="font-big">Gas Card</label>
                                                </span>
                                                </div>
                                            </div>
                                        </td>
                                        <td colspan="4">
                                            <div class="row">
                                                <div class="col-md-9 col-sm-9">
                                                <span class="pull-left">
                                                    <input type="checkbox" disabled name="3" class="manpower_checkbox_grp_2 manpower_management_toclear" id="manpower_biometric">
                                                    <label style="text-align: left" for="manpower_biometric" class="font-big">Biometric</label>
                                                </span>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4">
                                            <div class="row">
                                                <div class="col-md-9 col-sm-9">
                                                <span class="pull-left">
                                                    <input type="checkbox" disabled name="4" class="manpower_checkbox_grp_2 manpower_management_toclear" id="manpower_insurance">
                                                    <label style="text-align: left" for="manpower_insurance" class="font-big">Insurance</label>
                                                </span>
                                                </div>
                                            </div>
                                        </td>
                                        <td colspan="4">
                                            <div class="row">
                                                <div class="col-md-9 col-sm-9">
                                                <span class="pull-left">
                                                    <input type="checkbox" disabled name="5" class="manpower_checkbox_grp_2 manpower_management_toclear" id="manpower_computer">
                                                    <label style="text-align: left" for="manpower_computer" class="font-big">Computer</label>
                                                </span>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4">
                                            <div class="row">
                                                <div class="col-md-9 col-sm-9">
                                                <span class="pull-left">
                                                    <input type="checkbox" name="6" disabled class="manpower_checkbox_grp_2 manpower_management_toclear" id="manpower_uniform">
                                                    <label style="text-align: left" for="manpower_uniform" class="font-big">Uniform</label>
                                                </span>
                                                </div>
                                            </div>
                                        </td>
                                        <td colspan="4">
                                            <div class="row">
                                                <div class="col-md-9 col-sm-9">
                                                <span class="pull-left">
                                                    <input type="checkbox" name="7" disabled class="manpower_checkbox_grp_2 manpower_management_toclear" id="manpower_phone">
                                                    <label style="text-align: left" for="manpower_phone" class="font-big">Phone</label>
                                                </span>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4">
                                            <div class="row">
                                                <div class="col-md-9 col-sm-9">
                                                <span class="pull-left">
                                                    <input type="checkbox" name="8" disabled class="manpower_checkbox_grp_2 manpower_management_toclear" id="manpower_id_with_ccsi">
                                                    <label style="text-align: left" for="manpower_id_with_ccsi" class="font-big">ID with CCSI disclaimer</label>
                                                </span>
                                                </div>
                                            </div>
                                        </td>
                                        <td colspan="4">
                                            <div class="row">
                                                <div class="col-md-9 col-sm-9">
                                                <span class="pull-left">
                                                    <input type="checkbox" name="9" disabled class="manpower_checkbox_grp_2 manpower_management_toclear" id="manpower_ccsi_id">
                                                    <label style="text-align: left" for="manpower_ccsi_id" class="font-big">CCSI ID</label>
                                                </span>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4">
                                            <div class="row">
                                                <div class="col-md-9 col-sm-9">
                                                <span class="pull-left">
                                                    <input type="checkbox" name="10" disabled class="manpower_checkbox_grp_2 manpower_management_toclear" id="manpower_client">
                                                    <label style="text-align: left" for="manpower_client" class="font-big">Client authorization </label>
                                                </span>
                                                </div>
                                            </div>
                                        </td>
                                        <td colspan="4">
                                            <div class="row">
                                                <div class="col-md-9 col-sm-9">
                                                <span class="pull-left">
                                                    <input type="checkbox" name="11" disabled class="manpower_checkbox_grp_2 manpower_management_toclear" id="manpower_ccsi_email">
                                                    <label style="text-align: left" for="manpower_ccsi_email" class="font-big">CCSI Email</label>
                                                </span>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4">
                                            <div class="row">
                                                <div class="col-md-9 col-sm-9">
                                                <span class="pull-left">
                                                    <input type="checkbox" name="12" disabled class="manpower_checkbox_grp_2 manpower_management_toclear" id="manpower_phone_sim">
                                                    <label style="text-align: left" for="manpower_phone_sim" class="font-big">Phone and Sim Card</label>
                                                </span>
                                                </div>
                                            </div>
                                        </td>
                                        <td colspan="4">
                                            <div class="row">
                                                <div class="col-md-9 col-sm-9">
                                                <span class="pull-left">
                                                    <input type="checkbox"  name="13" disabled class="manpower_checkbox_grp_2 manpower_management_toclear" id="manpower_gmail_accnt">
                                                    <label style="text-align: left" for="manpower_gmail_accnt" class="font-big">Gmail Account</label>
                                                </span>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4">
                                            <div class="row">
                                                <div class="col-md-9 col-sm-9">
                                                <span class="pull-left">
                                                    <input type="checkbox" name="14" disabled class="manpower_checkbox_grp_2 manpower_management_toclear" id="manpower_ccsi_email_1">
                                                    <label style="text-align: left" for="manpower_ccsi_email_1" class="font-big">CCSI Email</label>
                                                </span>
                                                </div>
                                            </div>
                                        </td>
                                        <td colspan="4">
                                            <div class="row">
                                                <div class="col-md-9 col-sm-9">
                                                <span class="pull-left">
                                                    <input type="checkbox" name="15" disabled class="manpower_checkbox_grp_2 manpower_management_toclear" id="manpower_oims">
                                                    <label style="text-align: left" for="manpower_oims" class="font-big">OIMS</label>
                                                </span>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4">
                                            <div class="row">
                                                <div class="col-md-9 col-sm-9">
                                                <span class="pull-left">
                                                    <input type="checkbox" name="16" disabled class="manpower_checkbox_grp_2 manpower_management_toclear" id="manpower_gmail_accnt_1">
                                                    <label style="text-align: left" for="manpower_gmail_accnt_1" class="font-big">Gmail Account</label>
                                                </span>
                                                </div>
                                            </div>
                                        </td>
                                        <td colspan="4" rowspan="3">
                                            <div class="row">
                                                <div class="col-md-9 col-sm-9">
                                                <span class="pull-left">
                                                    <input type="checkbox" name="17" disabled class="manpower_checkbox_grp_2 manpower_management_toclear" id="manpower_other_1" what="#others_input_1">
                                                    <label style="text-align: left" for="manpower_other_1" class="font-big">Other: (Please specify)</label>
                                                </span>
                                                </div>
                                            </div>
                                            <input type="text" disabled class="form-control input_text_others manpower_management_toclear font-big" id="others_input_1" placeholder="type here..." disabled>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4">
                                            <div class="row">
                                                <div class="col-md-9 col-sm-9">
                                                <span class="pull-left">
                                                    <input type="checkbox" name="18" disabled class="manpower_checkbox_grp_2 manpower_management_toclear" id="manpower_oims_1">
                                                    <label style="text-align: left" for="manpower_oims_1" class="font-big">OIMS</label>
                                                </span>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4">
                                            <div class="row">
                                                <div class="col-md-9 col-sm-9">
                                                <span class="pull-left">
                                                    <input type="checkbox" name="19" disabled class="manpower_checkbox_grp_2 manpower_management_toclear" id="manpower_other_2" what="#others_input_2">
                                                    <label style="text-align: left" for="manpower_other_2" class="font-big">Other: (Please specify)</label>
                                                </span>
                                                </div>
                                            </div>
                                            <input type="text" disabled class="form-control input_text_others manpower_management_toclear font-big" id="others_input_2" placeholder="type here..." disabled>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>