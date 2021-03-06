@extends('layouts.master')
<style>
    @media screen {
        #printSection
        {
            display: none;
        }
    }

    @media print
    {
        body *
        {
            visibility:hidden;
        }
        #printSection, #printSection * {
            visibility:visible;
        }
        #printSection
        {
            position:absolute;
            left:0;
            top:0;
        }
        .rowHide {
            display: none !important;
        }
    }

</style>


@section('content')

    <div class="content-wrapper" id="nameHolderMainPage" name="{{ Auth::user()->email . '_' . Auth::user()->id  }}">

        <div class="modal fade" id="modal-upload-attach-file">
            <div class="modal-dialog" style = "width : 30%;">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" style = "text-align: center;">REPORT TO SAO/AO</h4>
                    </div>
                    <div class="modal-body">
                        <div class= "row">
                            <div class = "col-md-12">
                                <div class = "box box-danger">
                                    <div class = "row" style = "padding-top: 20px;">
                                        <div class = "col-md-6">
                                            <label for="">File to be uploaded: <small style = "color : red;">*please add zip file for multiple files</small></label>
                                            <input type="file" id = "tele-upload-attach">
                                        </div>
                                        <div class= "col-md-1"></div>
                                        <div class = "col-md-5">
                                            <label for="">Verify Status: </label>
                                            <select class = "form-control" id = "tele-acc-stat">
                                                <option value="-">-</option>
                                                <option class = "ccOps" value="Complete">Complete</option>
                                                <option class = "ccOps"  value="Incomplete">Incomplete</option>
                                                <option class = "bankOps" value="Contacted">Contacted</option>
                                                <option class = "bankOps" value="Uncontacted">Uncontacted</option>
                                                <option class = "bankOps" value="Verified">Verified</option>
                                                <option class = "bankOps" value="Unverified">Unverified</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class = "row" style = "padding-top: 20px; padding-bottom : 20px;" hidden id = "contactedSelect">
                                        <div class = "col-md-6">
                                            <label for="">Contacted Details: </label>
                                            <select class = "form-control" id = "contacted-details">
                                                <option value="-">-</option>
                                                <option value="Refused to be interviewed">Refused to be interviewed</option>
                                                <option value="Verified applying">Verified applying</option>
                                                <option value="Cancelled application since already approved by other bank">Cancelled application since already approved by other bank</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class = "row" style = "padding-top: 20px; padding-bottom : 20px;" hidden id = "uncontactedSelect">
                                        <div class = "col-md-6">
                                            <label for="">Uncontacted Details: </label>
                                            <select class = "form-control" id = "un-contacted-details">
                                                <option value="-">-</option>
                                                <option value="Contact number keeps on ringing">Contact number keeps on ringing</option>
                                                <option value="Contact number was cannot be reach">Contact number was cannot be reach</option>
                                                <option value="Contact number was unattended">Contact number was unattended</option>
                                                <option value="Contact number was on fast busy tone">Contact  number was on fast busy tone</option>
                                                <option value="Contact number cannot be completed when dialed">Contact number cannot be completed when dialed</option>
                                                <option value="Contact number is not in service">Contact number is not in service</option>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class = "row" style = "padding-top: 20px; padding-bottom : 20px;" hidden id = "verified_acomSelect">
                                        <div class = "col-md-6">
                                            <label for="">Verified Details: </label>
                                            <select class = "form-control" id = "verified-acom-details">
                                                <option value="-">-</option>
                                                <option value="Verified">Verified</option>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class = "row" style = "padding-top: 20px; padding-bottom : 20px;" hidden id = "unverified_acomSelect">
                                        <div class = "col-md-6">
                                            <label for="">Verified Details: </label>
                                            <select class = "form-control" id = "unverified-acom-details">
                                                <option value="-">-</option>
                                                <option value="Unverified">Unverified</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class = "row" style = "padding-top: 20px; padding-bottom : 20px;">
                                        <div class= "col-md-12">
                                            <label for="">Remarks:</label>
                                            <textarea id= "tele-acc-remarks-upload" class = "form-control" rows="4"></textarea>
                                        </div>
                                        <div class="col-md-12">
                                            <span id="ulPercentage_tele" hidden>--</span>
                                            <div id="progressbar_tele" hidden></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id = "btnSendtoSao">Send Report to SAO</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>


        <div class="modal fade" id="modal-downloadable-file">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" style = "text-align: center;">Report Templates</h4>
                    </div>
                    <div class="modal-body">
                        <div class = "row">
                            <div class = "col-md-12">
                                <div class = "box box-danger">
                                    <div class = "row">
                                        <div class = "col-md-1"></div>
                                        <div class = "col-md-10">
                                            <div class = "row" style = "padding-top: 20px;">
                                                <table class = "tableendorse display table-hover table-condensed" width="100%" >
                                                    <tr>
                                                        <th style = "font-weight: bold; background-color: lightcyan;">DOWNLOADABLE FILES</th>
                                                    </tr>
                                                    <tr>
                                                        <td><button type = "button" class = "btn btn-info form-control"><i class = "fa fa-fw fa-download"></i>REPORT TEMPLATE 1</button></td>
                                                    </tr>
                                                    <tr>
                                                        <td><button type = "button" class = "btn btn-info form-control"><i class = "fa fa-fw fa-download"></i>REPORT TEMPLATE 2</button></td>
                                                    </tr>
                                                    <tr>
                                                        <td><button type = "button" class = "btn btn-info form-control"><i class = "fa fa-fw fa-download"></i>REPORT TEMPLATE 3</button></td>
                                                    </tr>
                                                    <tr>
                                                        <td><button type = "button" class = "btn btn-info form-control"><i class = "fa fa-fw fa-download"></i>REPORT TEMPLATE 4</button></td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                        <div class = "col-md-1"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Close</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>


        <div class="modal fade" id="modal-view-reasonToTele">
            <div class="modal-dialog" style = "width : 30%;">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" style = "text-align: center;">Reason of Delay</h4>
                    </div>
                    <div class="modal-body">
                        <div class = "row" style = "padding-top : 15px;">
                            <div class = "col-md-12">
                                <div class = "box box-danger">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-12" style="padding-top: 20px; font-size: 1em;">
                                                <center><span id="reasonOfDelay"></span></center>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>

        <div class="modal fade" id="modal-view-encode-data" tabindex="-1">
            <div class="modal-dialog" style="width: 90%">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" style = "text-align: center;">Data Encoding</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-3">
                                    <div class="box box-danger">
                                        <table class="table-hover table-condensed" style="margin-top: 15px; margin-bottom: 15px;" width="100%" border="0" >
                                            <tr style="background-color: black; color: white;">
                                                <th>TYPE OF CHECK</th>
                                            </tr>
                                            <tr id="checkrow1" hidden class="hiddenThing">
                                                <td><input type="checkbox" id="check1" class="check4BI icheckbox_minimal-blue"><label for="check1" id="check1-label" class="check-label-class">Pre-Employment Background Check</label></td>
                                            </tr>
                                            <tr id="checkrow2" hidden class="hiddenThing">
                                                <td><input type="checkbox" id="check2" class="check4BI icheckbox_minimal-blue"><label for="check2" id="check2-label" class="check-label-class">Academic History</label></td>
                                            </tr>
                                            <tr id="checkrow3" hidden class="hiddenThing">
                                                <td><input type="checkbox" id="check3" class="check4BI icheckbox_minimal-blue"><label for="check3" id="check3-label" class="check-label-class">Employment Check (for all listed employer in the last 10 year)</label></td>
                                            </tr>
                                            <tr id="checkrow4" hidden class="hiddenThing">
                                                <td><input type="checkbox" id="check4" class="check4BI icheckbox_minimal-blue"><label for="check4" id="check4-label" class="check-label-class">Address Check - with occular inspection all addresses for the last 10 years</label></td>
                                            </tr>
                                            <tr id="checkrow6" hidden class="hiddenThing">
                                                <td><input type="checkbox" id="check6" class="check4BI icheckbox_minimal-blue"><label for="check6" id="check6-label" class="check-label-class">Background Investigation Report</label></td>
                                            </tr>
                                            <tr id="checkrow7" hidden class="hiddenThing">
                                                <td><input type="checkbox" id="check7" class="check4BI icheckbox_minimal-blue"><label for="check7" id="check7-label" class="check-label-class">Criminal Records Check</label></td>
                                            </tr>
                                            <tr id="checkrow8" hidden class="hiddenThing">
                                                <td><input type="checkbox" id="check8" class="check4BI icheckbox_minimal-blue"><label for="check8" id="check8-label" class="check-label-class">CMAP Check</label></td>
                                            </tr>
                                            <tr id="checkrow5" hidden class="hiddenThing">
                                                <td><input type="checkbox" id="check5" class="check4BI icheckbox_minimal-blue"><label for="check5" id="check5-label" class="check-label-class">Character Reference</label></td>
                                            </tr>
                                        </table>

                                        {{--<span id="reports_logs_cc"></span>--}}
                                        <div style="overflow-y: scroll; height: 300px;" id="splitterTest">
                                            <table class="table-hover table-condensed" width="100%" border="0" id="reports_logs_cc">
                                                <tr style="background-color: black; color: white;">
                                                    <th>REPORT LOGS</th>
                                                </tr>
                                            </table>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-9" id="printThis" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                    <div class="box box-info">
                                        <table class="table-hover table-condensed col-md-12" style="margin-top: 15px; font-weight: bold" width="100%" id="tablecheckheader">
                                            <tr>
                                                <td colspan="1">CONTACT NUMBER:</td>
                                                <td colspan="11"><input type="number" class="form-control" id="acc_contact_number" maxlength="11"></td>
                                            </tr>
                                            <tr>
                                                <td colspan="1">DATE OF BIRTH:</td>
                                                <td colspan="11"><input type="date" class="form-control" id="acc_dob" disabled=""></td>
                                            </tr>
                                            <tr>
                                                <td colspan="1">ADDRESS:</td>
                                                <td colspan="11"><input type="text" class="form-control" id="acc_address" disabled=""></td>
                                            </tr>
                                            <tr>
                                                <td colspan="1">SSS NUMBER:</td>
                                                <td colspan="11"><input type="text" class="form-control" id="acc_ss_number"></td>
                                            </tr>
                                        </table>


                                        <table class="table-hover table-condensed col-md-12 toShowThis pre-employmentTable" style="margin-top: 15px; font-weight: bold;" width="100%" id="tableCheck1" hidden>
                                            <tr>
                                                <td colspan="12" style="background-color: black; color: white;" class="table1hide">
                                                    <input type="checkbox" checked="" class="pull-left checkboxChecker" value="" style="display: block;">
                                                    PRE-EMPLOYEMENT BACKGROUND CHECK
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="12">
                                                    REPORT SUMMARY
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="1" class="labelinputted"><input type="checkbox" checked="" class="pull-left checkboxChecker" value="" style="display: block;">ACADEMIC</td>
                                                <td colspan="11" class="datainputted"><textarea name="txtArea" id="acc_academic" cols="9" rows="5" class="form-control datainputtedinput" style="resize: none" placeholder="Please indicate..."></textarea></td>
                                            </tr>
                                            <tr>
                                                <td colspan="1" class="labelinputted"><input type="checkbox" checked="" class="pull-left checkboxChecker" value="" style="display: block;">EMPLOYMENTS</td>
                                                <td colspan="11" class="datainputted"><textarea name="txtArea" id="acc_employements" cols="9" rows="5" class="form-control datainputtedinput" style="resize: none" placeholder="Please indicate..."></textarea></td>
                                            </tr>
                                            <tr>
                                                <td colspan="1" class="labelinputted"><input type="checkbox" checked="" class="pull-left checkboxChecker" value="" style="display: block;">SOCIAL SECURITY INFORMATION</td>
                                                <td colspan="11" class="datainputted"><input type="text" name="inputType" id="acc_sss_info_pre_employment" placeholder=". . ." class="form-control datainputtedinput"></td>
                                            </tr>
                                        </table>


                                        <table class="table-hover table-condensed col-md-12 toShowThis academicTable" style="margin-top: 15px; font-weight: bold;" width="100%" id="tableCheck2" hidden>
                                            <tr class="dontloop">
                                                <td colspan="12" style="background-color: black; color: white;" class="table2hide">
                                                    <input type="checkbox" checked="" class="pull-left checkboxChecker" value="" style="display: block;">
                                                    ACADEMIC HISTORY
                                                </td>
                                            </tr>
                                            <tr class="dontloop">
                                                <td colspan="3"><input type="checkbox" checked="" class="pull-left checkboxChecker" value="" style="display: block;">Details</td>
                                                <td colspan="3">Subject Declared</td>
                                                <td colspan="3">Verified Information</td>
                                                <td colspan="3">CCSI Remarks</td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" class="labelonly"><input type="checkbox" checked="" class="pull-left checkboxChecker" value="" style="display: block;">School</td>
                                                <td colspan="3" class="inputteddata"><input type="text" placeholder="Please indicate..." class="form-control" id="acc_declared_school"></td>
                                                <td colspan="3" class="inputteddata"><input type="text" placeholder="Please indicate..." class="form-control" id="acc_declared_school_verified_info"></td>
                                                <td colspan="3" class="inputteddata"><input type="text" placeholder="Please indicate..." class="form-control" id="acc_declared_school_remarks"></td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" class="labelonly"><input type="checkbox" checked="" class="pull-left checkboxChecker" value="" style="display: block;">Degree Conferred</td>
                                                <td colspan="3" class="inputteddata"><input type="text" placeholder="Please indicate..." class="form-control" id="acc_declared_degree"></td>
                                                <td colspan="3" class="inputteddata"><input type="text" placeholder="Please indicate..." class="form-control" id="acc_declared_degree_verified_info"></td>
                                                <td colspan="3" class="inputteddata"><input type="text" placeholder="Please indicate..." class="form-control" id="acc_declared_degree_remarks"></td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" class="labelonly"><input type="checkbox" checked="" class="pull-left checkboxChecker" value="" style="display: block;">Year Graduated</td>
                                                <td colspan="3" class="inputteddata"><input type="text" placeholder="Please indicate..." class="form-control" id="acc_declared_yrgraduate"></td>
                                                <td colspan="3" class="inputteddata"><input type="text" placeholder="Please indicate..." class="form-control" id="acc_declared_yrgraduate_verified_info"></td>
                                                <td colspan="3" class="inputteddata"><input type="text" placeholder="Please indicate..." class="form-control" id="acc_declared_yrgraduate_remarks"></td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" class="labelonly"><input type="checkbox" checked="" class="pull-left checkboxChecker" value="" style="display: block;">Other comments</td>
                                                <td colspan="9" class="inputteddata"><input type="text" placeholder="Please indicate..." class="form-control" id="acc_academic_other_comments"></td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" class="labelonly"><input type="checkbox" checked="" class="pull-left checkboxChecker" value="" style="display: block;">Contact Name/Position/Number</td>
                                                <td colspan="9" class="inputteddata"><input type="text" placeholder="Please indicate..." class="form-control" id="acc_academic_contact_person"></td>
                                            </tr>
                                        </table>


                                        <table class="table-hover table-condensed col-md-12 toShowThis empHis_0" style="margin-top: 15px; font-weight: bold;" width="100%" id="tableCheck3" hidden>
                                            <tr class="row0delete dontloop table3hide">
                                                <td colspan="12" style="background-color: black; color: white;">
                                                    <input type="checkbox" checked="" class="pull-left checkboxChecker" value="" style="display: block;">
                                                    <p class="">EMPLOYMENT HISTORY</p>
                                                </td>
                                            </tr>
                                            <tr class="row0delete dontloop table3hide">
                                                <td colspan="12">
                                                    <input type="checkbox" checked="" class="pull-left checkboxChecker" value="" style="display: block;">
                                                    EMPLOYMENT (from most recent)
                                                </td>
                                            </tr>
                                            <tr class="row0 dontloop">
                                                <td colspan="3"><input type="checkbox" checked="" class="pull-left checkboxChecker" value="" style="display: block;">Details</td>
                                                <td colspan="3">Subject Declared</td>
                                                <td colspan="3">Verified Information</td>
                                                <td colspan="3">CCSI Remarks</td>
                                            </tr>
                                            <tr class="row0">
                                                <td colspan="3" class="labelonly"><input type="checkbox" checked="" class="pull-left checkboxChecker" value="" style="display: block;">Employer</td>
                                                <td colspan="3" class="inputteddata_0"><input type="text" placeholder="Please indicate..." class="form-control"></td>
                                                <td colspan="3" class="inputteddata_0"><input type="text" placeholder="Please indicate..." class="form-control"></td>
                                                <td colspan="3" class="inputteddata_0"><input type="text" placeholder="Please indicate..." class="form-control"></td>
                                            </tr>
                                            <tr class="row0">
                                                <td colspan="3" class="labelonly"><input type="checkbox" checked="" class="pull-left checkboxChecker" value="" style="display: block;">Address</td>
                                                <td colspan="3" class="inputteddata_0"><input type="text" placeholder="Please indicate..." class="form-control"></td>
                                                <td colspan="3" class="inputteddata_0"><input type="text" placeholder="Please indicate..." class="form-control"></td>
                                                <td colspan="3" class="inputteddata_0"><input type="text" placeholder="Please indicate..." class="form-control"></td>
                                            </tr>
                                            <tr class="row0">
                                                <td colspan="3" class="labelonly"><input type="checkbox" checked="" class="pull-left checkboxChecker" value="" style="display: block;">Industry</td>
                                                <td colspan="3" class="inputteddata_0"><input type="text" placeholder="Please indicate..." class="form-control"></td>
                                                <td colspan="3" class="inputteddata_0"><input type="text" placeholder="Please indicate..." class="form-control"></td>
                                                <td colspan="3" class="inputteddata_0"><input type="text" placeholder="Please indicate..." class="form-control"></td>
                                            </tr>
                                            <tr class="row0">
                                                <td colspan="3" class="labelonly"><input type="checkbox" checked="" class="pull-left checkboxChecker" value="" style="display: block;">Job Title Reported</td>
                                                <td colspan="3" class="inputteddata_0"><input type="text" placeholder="Please indicate..." class="form-control"></td>
                                                <td colspan="3" class="inputteddata_0"><input type="text" placeholder="Please indicate..." class="form-control"></td>
                                                <td colspan="3" class="inputteddata_0"><input type="text" placeholder="Please indicate..." class="form-control"></td>
                                            </tr>
                                            <tr class="row0">
                                                <td colspan="3" class="labelonly"><input type="checkbox" checked="" class="pull-left checkboxChecker" value="" style="display: block;">Dates of Service Reported</td>
                                                <td colspan="3" class="inputteddata_0"><input type="text" placeholder="Please indicate..." class="form-control"></td>
                                                <td colspan="3" class="inputteddata_0"><input type="text" placeholder="Please indicate..." class="form-control"></td>
                                                <td colspan="3" class="inputteddata_0"><input type="text" placeholder="Please indicate..." class="form-control"></td>
                                            </tr>
                                            <tr class="row0">
                                                <td colspan="3" class="labelonly"><input type="checkbox" checked="" class="pull-left checkboxChecker" value="" style="display: block;">Employee Status</td>
                                                <td colspan="3" class="inputteddata_0"><input type="text" placeholder="Please indicate..." class="form-control"></td>
                                                <td colspan="3" class="inputteddata_0"><input type="text" placeholder="Please indicate..." class="form-control"></td>
                                                <td colspan="3" class="inputteddata_0"><input type="text" placeholder="Please indicate..." class="form-control"></td>
                                            </tr>
                                            <tr class="row0">
                                                <td colspan="3" class="labelonly"><input type="checkbox" checked="" class="pull-left checkboxChecker" value="" style="display: block;">Reason for Departure</td>
                                                <td colspan="3" class="inputteddata_0"><input type="text" placeholder="Please indicate..." class="form-control"></td>
                                                <td colspan="3" class="inputteddata_0"><input type="text" placeholder="Please indicate..." class="form-control"></td>
                                                <td colspan="3" class="inputteddata_0"><input type="text" placeholder="Please indicate..." class="form-control"></td>
                                            </tr>
                                            <tr class="row0">
                                                <td colspan="3" class="labelonly"><input type="checkbox" checked="" class="pull-left checkboxChecker" value="" style="display: block;">Eligible for Rehire</td>
                                                <td colspan="3" class="inputteddata_0"><input type="text" placeholder="Please indicate..." class="form-control"></td>
                                                <td colspan="3" class="inputteddata_0"><input type="text" placeholder="Please indicate..." class="form-control"></td>
                                                <td colspan="3" class="inputteddata_0"><input type="text" placeholder="Please indicate..." class="form-control"></td>
                                            </tr>
                                            <tr class="row0">
                                                <td colspan="3" class="labelonly"><input type="checkbox" checked="" class="pull-left checkboxChecker" value="" style="display: block;">Clearance</td>
                                                <td colspan="3" class="inputteddata_0"><input type="text" placeholder="Please indicate..." class="form-control"></td>
                                                <td colspan="3" class="inputteddata_0"><input type="text" placeholder="Please indicate..." class="form-control"></td>
                                                <td colspan="3" class="inputteddata_0"><input type="text" placeholder="Please indicate..." class="form-control"></td>
                                            </tr>
                                            <tr class="row0">
                                                <td colspan="3" class="labelonly"><input type="checkbox" checked="" class="pull-left checkboxChecker" value="" style="display: block;">Other comments</td>
                                                <td colspan="9" class="inputteddata_0"><input type="text" placeholder="Please indicate..." class="form-control"></td>
                                            </tr>
                                            <tr class="row0">
                                                <td colspan="3" class="labelonly"><input type="checkbox" checked="" class="pull-left checkboxChecker" value="" style="display: block;">Contact Name/Position/Number</td>
                                                <td colspan="9" class="inputteddata_0"><input type="text" placeholder="Please indicate..." class="form-control"></td>
                                            </tr>
                                            <tr class="row0delete dontloop table3hide rowHide">
                                                <td colspan="12"><button class="btn btn-success form-control" id="addEmployment"><span class="glyphicon glyphicon-plus"></span></button></td>
                                            </tr>
                                        </table>

                                        <span id="emplohistSpan"></span>

                                        <table class="table-hover table-condensed col-md-12 toShowThis residentialTable" style="margin-top: 15px; font-weight: bold;" width="100%" id="tableCheck4" hidden>
                                            <tr class="dontloop">
                                                <td colspan="12" style="background-color: black; color: white;" class="table4hide">
                                                    <input type="checkbox" checked="" class="pull-left checkboxChecker" value="" style="display: block;">
                                                    RESIDENTIAL HISTORY
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="12" class="dataLabel"><input type="checkbox" checked="" class="pull-left checkboxChecker" value="" style="display: block;">CURRENT ADDRESS</td>
                                            </tr>
                                            <tr>
                                                <td colspan="12" class="dataInputt"><input type="checkbox" checked="" class="pull-left checkboxChecker" value="" style="display: block;"><input type="text" class="form-control" id="acc_residence_current_address"></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" class="dataLabel"><input type="checkbox" checked="" class="pull-left checkboxChecker" value="" style="display: block;">Remarks</td>
                                                <td colspan="10" class="dataInputt"><input type="text" placeholder="Please indicate..." class="form-control" id="acc_residence_remarks"></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" class="dataLabel"><input type="checkbox" checked="" class="pull-left checkboxChecker" value="" style="display: block;">Contact name/Position/Number</td>
                                                <td colspan="10" class="dataInputt"><input type="text" placeholder="Please indicate..." class="form-control" id="acc_residence_contactPerson"></td>
                                            </tr>
                                            <tr class="dontloop">
                                                <td colspan="12"></td>
                                            </tr>
                                            <tr>
                                                <td colspan="12" style="background-color: black; color: white;" class="table5hide">
                                                    <input type="checkbox" checked="" class="pull-left checkboxChecker" value="" style="display: block;">
                                                    Residence Check
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" class="dataLabel"><input type="checkbox" checked="" class="pull-left checkboxChecker" value="" style="display: block;">Residence Check Remarks</td>
                                                <td colspan="10" class="dataInputt"><textarea name="textArea" id="acc_residence_check_remarks1" rows="3" style="resize: none;" class="form-control" placeholder="Please indicate ..."></textarea></td>
                                            </tr>
                                        </table>


                                        <table class="table-hover table-condensed col-md-12 toShowThis bi_reportTable" style="margin-top: 15px; font-weight: bold;" width="100%" id="tableCheck6" hidden>
                                            <tr class="dontloop">
                                                <td colspan="12" style="background-color: black; color: white;" class="table6hide">
                                                    <input type="checkbox" checked="" class="pull-left checkboxChecker" value="" style="display: block;">
                                                    CASE DETAILS
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" class="biLabel"><input type="checkbox" checked="" class="pull-left checkboxChecker" value="" style="display: block;">ACCOUNT</td>
                                                <td colspan="3" class="bi_data"><input type="text" class="form-control" id="bi_account_report"></td>
                                                <td colspan="3" rowspan="4" class="biLabel">REFERENCE CODE</td>
                                                <td colspan="3" rowspan="4" class="bi_data_textarea"><textarea rows="9" id="bi_account_reference_code" placeholder="..." class="form-control" style="resize: none;"></textarea></td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" class="biLebel"><input type="checkbox" checked="" class="pull-left checkboxChecker" value="" style="display: block;">DATE REQUESTED</td>
                                                <td colspan="3" class="bi_data"><input type="text" class="form-control" id="bi_account_dateReq"></td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" class="biLebel"><input type="checkbox" checked="" class="pull-left checkboxChecker" value="" style="display: block;">DATE DUE</td>
                                                <td colspan="3" class="bi_data"><input type="text" class="form-control" id="bi_account_dateDue"></td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" class="biLabel"><input type="checkbox" checked="" class="pull-left checkboxChecker" value="" style="display: block;">DATE CLOSED</td>
                                                <td colspan="3" class="bi_data"><input type="text" class="form-control" id="bi_account_dateClosed"></td>
                                            </tr>
                                            <tr class="dontloop">
                                                <td colspan="12" style="background-color: black; height: 20px;"></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" class="biLabel"><input type="checkbox" checked="" class="pull-left checkboxChecker" value="" style="display: block;">CANDIDATE NAME</td>
                                                <td colspan="10" class="bi_data"><input type="text" class="form-control" id="bi_account_candidateName"></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" class="biLabel"><input type="checkbox" checked="" class="pull-left checkboxChecker" value="" style="display: block;">DATE OF BIRTH</td>
                                                <td colspan="10" class="bi_data"><input type="text" class="form-control" id="bi_account_candidateDOB"></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" class="biLabel"><input type="checkbox" checked="" class="pull-left checkboxChecker" value="" style="display: block;">CURRENT ADDRESS</td>
                                                <td colspan="10" class="bi_data"><input type="text" class="form-control" id="bi_account_candidate_add"></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" class="biLabel"><input type="checkbox" checked="" class="pull-left checkboxChecker" value="" style="display: block;">CONTACT NUMBER</td>
                                                <td colspan="10" class="bi_data"><input type="text" class="form-control" id="bi_account_candidate_contact_num"></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" class="biLabel"><input type="checkbox" checked="" class="pull-left checkboxChecker" value="" style="display: block;">E-MAIL ADDRESS</td>
                                                <td colspan="10" class="bi_data"><input type="email" class="form-control" id="bi_account_candidate_email"></td>
                                            </tr>
                                        </table>


                                        <table class="table-hover table-condensed col-md-12 toShowThis id_crim_table" style="margin-top: 15px; font-weight: bold;" width="100%" id="tableCheck7" hidden>
                                            <tr class="dontloop">
                                                <td colspan="12" style="background-color: black; color: white;" class="table7hide">
                                                    <input type="checkbox" checked="" class="pull-left checkboxChecker" value="" style="display: block;">
                                                    IDENTITY & CRIMINAL RECORD VERIFICATION
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" class="labelonly"><input type="checkbox" checked="" class="pull-left checkboxChecker" value="" style="display: block;">IDENTITY CHECK</td>
                                                <td colspan="10" class="inputteddata"><input type="text" class="form-control" id="acc_check"></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" class="labelonly"><input type="checkbox" checked="" class="pull-left checkboxChecker" value="" style="display: block;">CRIMINAL CHECK</td>
                                                <td colspan="10" class="inputteddata"><input type="text" class="form-control" id="acc_crim_check"></td>
                                            </tr>
                                        </table>


                                        <table class="table-hover table-condensed col-md-12 toShowThis cmapTable" style="margin-top: 15px; font-weight: bold;" width="100%" id="tableCheck8" hidden>
                                            <tr class="dontloop">
                                                <td colspan="12" style="background-color: black; color: white;" class="table8hide">
                                                    <input type="checkbox" checked="" class="pull-left checkboxChecker" value="" style="display: block;">
                                                    FINANCIAL AND COURT CASE RECORDS VERIFICATION (CMAP)
                                                </td>
                                            </tr>
                                            <tr class="dontloop">
                                                <td colspan="6"><input type="checkbox" checked="" class="pull-left checkboxChecker" value="" style="display: block;">CATEGORY OF CHECKS</td>
                                                <td colspan="6">VERIFICATION DETAILS / REMARKS</td>
                                            </tr>
                                            <tr>
                                                <td colspan="6" class="labelonly"><input type="checkbox" checked="" class="pull-left checkboxChecker" value="" style="display: block;">COURT CASES</td>
                                                <td colspan="6" class="inputteddata"><input type="text" class="form-control" id="accnt_court_cases"></td>
                                            </tr>
                                            <tr>
                                                <td colspan="6" class="labelonly"><input type="checkbox" checked="" class="pull-left checkboxChecker" value="" style="display: block;">ACCOUNTS REFFERED TO LAWYERS</td>
                                                <td colspan="6" class="inputteddata"><input type="text" class="form-control" id="accnt_reffered_lawyers"></td>
                                            </tr>
                                            <tr>
                                                <td colspan="6" class="labelonly"><input type="checkbox" checked="" class="pull-left checkboxChecker" value="" style="display: block;">RETURNED CHEQUES</td>
                                                <td colspan="6" class="inputteddata"><input type="text" class="form-control" id="accnt_ret_cheques"></td>
                                            </tr>
                                            <tr>
                                                <td colspan="6" class="labelonly"><input type="checkbox" checked="" class="pull-left checkboxChecker" value="" style="display: block;">TELECOMS DATA</td>
                                                <td colspan="6" class="inputteddata"><input type="text" class="form-control" id="accnt_telcom_data"></td>
                                            </tr>
                                            <tr class="dontloop">
                                                <td colspan="12" style="background-color: black; color: white;">
                                                    <input type="checkbox" checked="" class="pull-left checkboxChecker" value="" style="display: block;">
                                                    VENDOR INFORMATION / REMARKS
                                                </td>
                                            </tr>
                                            <tr class="dontloop">
                                                <td colspan="4"><input type="checkbox" checked="" class="pull-left checkboxChecker" value="" style="display: block;">DETAILS</td>
                                                <td colspan="2">CASE FOUND? (YES / NO)</td>
                                                <td colspan="6">VERIFICATION DETAILS / REMARKS</td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" class="labelonly"><input type="checkbox" checked="" class="pull-left checkboxChecker" value="" style="display: block;">IDENTITY & CRIMINAL CHECK</td>
                                                {{--<td colspan="2"><input type="text" class="form-control"></td>--}}
                                                <td colspan="2" class="inputteddata" what="select">
                                                    <select name="" id="accnt_id_crim_check_yes_no" class="form-control">
                                                        <option value="-">-</option>
                                                        <option value="Yes">YES</option>
                                                        <option value="No">NO</option>
                                                    </select>
                                                </td>
                                                <td colspan="6" class="inputteddata"><input type="text" class="form-control" id="accnt_id_crim_check_yes_no_rem"></td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" class="labelonly"><input type="checkbox" checked="" class="pull-left checkboxChecker" value="" style="display: block;">CREDIT / FINANCIAL CHECK</td>
                                                <td colspan="2" class="inputteddata" what="select">
                                                    <select name="" class="form-control" id="accnt_credit_fin_check">
                                                        <option value="-">-</option>
                                                        <option value="Yes">YES</option>
                                                        <option value="No">NO</option>
                                                    </select>
                                                </td>
                                                <td colspan="6" class="inputteddata"><input type="text" class="form-control" id="accnt_credit_fin_check_rem"></td>
                                            </tr>
                                        </table>


                                        <table class="table-hover table-condensed toShowThis charRefTable_0" style="margin-top: 15px; font-weight: bold;" width="100%" id="tableCheck5" hidden>
                                            <tr class="dontloop">
                                                <td colspan="12" style="background-color: black; color: white;" class="table9hide">
                                                    <input type="checkbox" checked class="pull-left checkboxChecker">
                                                    CHARACTER REFERENCE 1
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" class="labelonly"><input type="checkbox" checked class="pull-left checkboxChecker"> Name of Reference:</td>
                                                <td colspan="10" class="charRefData_0"><input type="text" class="form-control charRefData_0"></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" class="labelonly"><input type="checkbox" checked class="pull-left checkboxChecker"> Contact Number:</td>
                                                <td colspan="10" class="charRefData_0"><input type="text" class="form-control charRefData_0"></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" class="labelonly"><input type="checkbox" checked class="pull-left checkboxChecker">Position:</td>
                                                <td colspan="10" class="charRefData_0"><input type="text" class="form-control charRefData_0"></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" class="labelonly"><input type="checkbox" checked class="pull-left checkboxChecker">Company:</td>
                                                <td colspan="10" class="charRefData_0"><input type="text" class="form-control charRefData_0"></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" class="labelonly"><input type="checkbox" checked class="pull-left checkboxChecker">Business Address:</td>
                                                <td colspan="10" class="charRefData_0"><input type="text" class="form-control charRefData_0"></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" class="labelonly"><input type="checkbox" checked class="pull-left checkboxChecker">Remarks:</td>
                                                <td colspan="10" class="charRefData_0"><input type="text" class="form-control charRefData_0"></td>
                                            </tr>
                                            <tr class="dontloop rowHide">
                                                <td colspan="12"><button class="btn btn-success form-control" id="addCharRef"><span class="glyphicon glyphicon-plus"></span></button></td>
                                            </tr>
                                        </table>
                                        <span id="forspantablee"></span>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-md btn-success pull-right" id="submit_encoded_data" style="margin-left: 15px;">Submit</button>
                        <button type="button" class="btn btn-md btn-primary pull-right" id="btnTelePrint">Print</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>

        <div class="modal fade" id="modal-view-bank-encoding" tabindex="-1" >
            <div class="modal-dialog" style="width: 80%">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h3 class="modal-title" style = "text-align : center;">Account Verification</h3>
                    </div>
                    <div class="modal-body">
                        <div class="nav-tabs-custom">
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#tab_cc_bank_1"  id = "clicktToRetrieve" data-toggle="tab" class = "cc_encode_tab">Encode Data</a></li>
                                <li ><a href="#tab_cc_bank_2" data-toggle="tab" class = "cc_encode_tab">Saved Encoded</a></li>
                            </ul>
                            <div class = "tab-content">
                                <div class="tab-pane active" id="tab_cc_bank_1"><div class = "row" id = "printThisBank" aria-hidden="true" >
                                        <div class = "col-md-12" id = "toNewWindowPrint">
                                            <div class = "row">
                                                <div class = "col-md-12">
                                                    <table class="table-condensed printThisBank " style = "overflow-x:auto; border-collapse:collapse; table-layout:fixed; width : 100%;" id = "mainTableCcBankEncode">

                                                        <tr>
                                                            <td colspan="4">
                                                                <table class = "table-condensed " style = "width : 100%; table-layout:fixed ">
                                                                    <tr>
                                                                        <td colspan="4" style = "background-color: black; color : white;">DEALER INFORMATION
                                                                            <button type="button" class = "btn btn-default btn-md pull-right minimizeCom"  tabIndex="-1">
                                                                                <i class="fa fa-fw fa-minus"></i>
                                                                            </button>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="2" style="font-weight:bold; ">Dealer Name: </td>
                                                                        <td colspan="2"><input type="text" class = "form-control save_dataa" id = "dealerName"></td>
                                                                    </tr>

                                                                </table>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td colspan="4">
                                                                <table class = "table-condensed " style = "width : 100%; table-layout:fixed ">
                                                                    <tr>
                                                                        <td colspan="4" style = "background-color: black; color : white;">LOAN INFORMATION
                                                                            <button type="button" class = "btn btn-default btn-md pull-right minimizeCom"  tabIndex="-1">
                                                                                <i class="fa fa-fw fa-minus"></i>
                                                                            </button>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="2" style="font-weight:bold; ">Confirmed Applying Unit/ Downpayment / Mos Unit: </td>
                                                                        <td colspan="2"><input type="text" class = "form-control save_dataa" id = "confirmedUnitForLoanCB"></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="2" style="font-weight:bold;">Purpose of Loan:</td>
                                                                        <td colspan="2"><input type="text" class = "form-control save_dataa" id = "firstTimeCB" ></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="2" style="font-weight:bold;">EXISTING LOAN:</td>
                                                                        <td colspan="2"><input type="text" class = "form-control save_dataa" id = "dpForLoanCB"></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="2" style="font-weight:bold;">1ST TIME LOAN:</td>
                                                                        <td colspan="2"><input type="text" class = "form-control save_dataa" id = "loanTermCB" ></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="2" style="font-weight:bold;">Additional Remarks: </td>
                                                                        <td colspan="2"><textarea id="loanInfoRem" class = "form-control save_dataa" placeholder="Insert Remarks here......"></textarea></td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td colspan="4">
                                                                <table class = "table-condensed " style = "width : 100%; table-layout:fixed ">
                                                                    <tr>
                                                                        <td colspan="4" style = "background-color: black; color : white;">BORROWER INFORMATION
                                                                            <button type="button" class = "btn btn-default btn-md pull-right minimizeCom"  tabIndex="-1">
                                                                                <i class="fa fa-fw fa-minus"></i>
                                                                            </button>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="2" style="font-weight:bold;">Subject's Name:</td>
                                                                        <td colspan="2"><input type="text" class = "form-control save_dataa" id = "borLastName"></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="2" style="font-weight:bold;">Birthdate:</td>
                                                                        <td colspan="2"><input type="date" class = "form-control save_dataa" id = "borBday"></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="2" style="font-weight:bold;">Place of Birth:</td>
                                                                        <td colspan="2"><input type="text" class = "form-control save_dataa" id = "borPofBirth"></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="2" style="font-weight:bold;">Mother's Maiden Name:</td>
                                                                        <td colspan="2"><input type="text" class = "form-control save_dataa" id = "borMaidenName"></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="2" style="font-weight:bold;">Civil Status:</td>
                                                                        <td colspan="2">
                                                                            <select id="borCivilStat" class = "form-control save_dataa rowHide notToPrintSelect">
                                                                                <option value="-">-</option>
                                                                                <option value="Single">Single</option>
                                                                                <option value="Single with Live in Partner">Single with Live in Partner</option>
                                                                                <option value="Single with Common Law">Single with Common Law</option>
                                                                                <option value="Married">Married</option>
                                                                                <option value="Married but not Legally Separated">Married but not Legally Separated</option>
                                                                                <option value="Legally Separated">Legally Separated</option>
                                                                                <option value="Widow">Widow</option>
                                                                            </select>
                                                                        </td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td colspan="2" style="font-weight:bold;">KYC: TIN#:</td>
                                                                        <td colspan="2"><input type="text" class = "form-control save_dataa" id = "borKYCTIN"></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="2" style="font-weight:bold;">KYC: SSS#:</td>
                                                                        <td colspan="2"><input type="text" class = "form-control save_dataa" id = "borKYCSSS"></td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>


                                                        <tr>
                                                            <td colspan="4">
                                                                <table class = "table-condensed " style = "width : 100%; table-layout:fixed ">
                                                                    <tr>
                                                                        <td colspan="4" style = "background-color: black; color : white;">CO-BORROWER'S INFORMATION
                                                                            <button type="button" class = "btn btn-default btn-md pull-right minimizeCom"  tabIndex="-1">
                                                                                <i class="fa fa-fw fa-minus"></i>
                                                                            </button>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="2" style="font-weight:bold;">Subject's Name:</td>
                                                                        <td colspan="2"><input type="text" class = "form-control save_dataa" id = "cobLastName"></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="2" style="font-weight:bold;">Birthdate:</td>
                                                                        <td colspan="2"><input type="date" class = "form-control save_dataa" id = "cobBday"></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="2" style="font-weight:bold;">Place of Birth:</td>
                                                                        <td colspan="2"><input type="text" class = "form-control save_dataa" id = "cobPofBirth"></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="2" style="font-weight:bold;">Mother's Maiden Name:</td>
                                                                        <td colspan="2"><input type="text" class = "form-control save_dataa" id = "cobMaidenName"></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="2" style="font-weight:bold;">Civil Status:</td>
                                                                        <td colspan="2">
                                                                            <select id="cobCivilStat" class = "form-control save_dataa rowHide notToPrintSelect">
                                                                                <option value="-">-</option>
                                                                                <option value="Single">Single</option>
                                                                                <option value="Single with Live in Partner">Single with Live in Partner</option>
                                                                                <option value="Single with Common Law">Single with Common Law</option>
                                                                                <option value="Married">Married</option>
                                                                                <option value="Married but not Legally Separated">Married but not Legally Separated</option>
                                                                                <option value="Legally Separated">Legally Separated</option>
                                                                                <option value="Widow">Widow</option>
                                                                            </select>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="2" style="font-weight:bold;">KYC: TIN#:</td>
                                                                        <td colspan="2"><input type="text" class = "form-control save_dataa" id = "cobKYCTIN"></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="2" style="font-weight:bold;">KYC: SSS#:</td>
                                                                        <td colspan="2"><input type="text" class = "form-control save_dataa" id = "cobKYCSSS"></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="2" style="font-weight:bold;">Length of Marriage:</td>
                                                                        <td colspan="2"><input type="text" class = "form-control save_dataa" id = "coblengthmar"></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="2" style="font-weight:bold;">Dependent/s:</td>
                                                                        <td colspan="2"><input type="text" class = "form-control save_dataa" id = "cobdependents"></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="2" style="font-weight:bold;">Relationship of subject to Co-maker:</td>
                                                                        <td colspan="2"><input type="text" class = "form-control save_dataa" id = "borrelToCob"></td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td colspan="4">
                                                                <table class = "table-condensed " style = "width : 100%; table-layout:fixed ">
                                                                    <tbody>
                                                                    <tr>
                                                                        <td colspan="4" style = "background-color: black; color : white;">BORROWER'S PRESENT ADDRESS
                                                                            <button type="button" class = "btn btn-default btn-md pull-right minimizeCom" style = "margin-left : 10px"  tabIndex="-1">
                                                                                <i class="fa fa-fw fa-minus"></i></button>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="2" style="font-weight:bold;">Complete Address:</td>
                                                                        <td colspan="2" ><textarea class = "form-control save_dataa addressBor borPresentAdd hidePdf sameAsBorAddress"  id = "borPresentAdd" placeholder="Insert Adress here....."  ></textarea>
                                                                            {{--<p class = "showPdf save_dataa sameAsBorAddress addressBor"  id = "inputborPresent" name = "hideMe" hidden></p>--}}
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="2" style="font-weight:bold;">Length of Stay:</td>
                                                                        <td colspan="2"><input type="text" class = "form-control save_dataa addressBor sameAsBorAddress" id = "borPresentLength"></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="2" style="font-weight:bold;">House Ownership:</td>
                                                                        <td colspan="2"><input type="text" class = "form-control save_dataa addressBor sameAsBorAddress" id = "borPresentOwnership"></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="2" style="font-weight:bold;">Additional Remarks: </td>
                                                                        <td colspan="2"><textarea id="BorPresentAddRem" class = "form-control save_dataa" placeholder="Insert Remarks here......"></textarea></td>
                                                                    </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>


                                                        <tr>
                                                            <td colspan="4">
                                                                <table class = "table-condensed " style = "width : 100%; table-layout:fixed ">
                                                                    <tbody>
                                                                    <tr>
                                                                        <td colspan="4" style = "background-color: black; color : white;">BORROWER'S SOURCE OF INCOME (EMPLOYMENT)
                                                                            <button type="button" class = "btn btn-default btn-md pull-right minimizeCom" style = "margin-left : 10px"  tabIndex="-1">
                                                                                <i class="fa fa-fw fa-minus"></i></button>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="2" style="font-weight:bold;">Employers Name:</td>
                                                                        <td colspan="2" ><textarea class = "form-control save_dataa borSoi hidePdf"  id = "borEvrName" placeholder="Insert Name here....."  ></textarea>
                                                                            <p class = "showPdf save_dataa borSoi"  id = "inputborEvrName" name = "hideMe" hidden></p>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="2" style="font-weight:bold;">Address:</td>
                                                                        <td colspan="2"><input type="text" class = "form-control save_dataa borSoi " id = "borEvrAddress"></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="2" style="font-weight:bold;">Length of Service:</td>
                                                                        <td colspan="2"><input type="text" class = "form-control save_dataa borSoi" id = "borEvrTenure"></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="2" style="font-weight:bold;">Position:</td>
                                                                        <td colspan="2"><input type="text" class = "form-control save_dataa borSoi" id = "borEvrPosStaffs"></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="2" style="font-weight:bold;">Gross Monthly Income: </td>
                                                                        <td colspan="2"><textarea id="borEvrIncome" class = "form-control borSoi save_dataa" placeholder="Insert Income here......"></textarea>
                                                                            <p class = "showPdf save_dataa borSoi"  id = "inputborIncome" name = "hideMe" hidden></p>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="2" style="font-weight:bold;">Remarks:</td>
                                                                        <td colspan="2"> <textarea id="borEvrRem" class = "form-control borSoi save_dataa" placeholder="Insert Remarks here......"></textarea>
                                                                    </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td colspan="4">
                                                                <table class = "table-condensed " style = "width : 100%; table-layout:fixed ">
                                                                    <tbody>
                                                                    <tr >
                                                                        <td colspan="4" style = "background-color: black; color : white;">BORROWER'S SOURCE OF INCOME (BUSINESS)
                                                                            <button type="button" class = "btn btn-default btn-md pull-right minimizeCom" style = "margin-left : 10px"  tabIndex="-1">
                                                                                <i class="fa fa-fw fa-minus"></i></button>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="2" style="font-weight:bold;">Business Name:</td>
                                                                        <td colspan="2" ><textarea class = "form-control save_dataa borSoi hidePdf"  id = "borSoiName" placeholder="Insert Name here....."  ></textarea>
                                                                            <p class = "showPdf save_dataa borSoi"  id = "inputborBusiName" name = "hideMe" hidden></p>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="2" style="font-weight:bold;">Address:</td>
                                                                        <td colspan="2"><input type="text" class = "form-control save_dataa borSoi " id = "borSoiAddress"></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="2" style="font-weight:bold;">Length of Operation:</td>
                                                                        <td colspan="2"><input type="text" class = "form-control save_dataa borSoi" id = "borSoiTenure"></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="2" style="font-weight:bold;">Position:</td>
                                                                        <td colspan="2"><input type="text" class = "form-control save_dataa borSoi" id = "borSoiPos"></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="2" style="font-weight:bold;">Staffs:</td>
                                                                        <td colspan="2"><input type="text" class = "form-control save_dataa borSoi" id = "borSoiPosStaffs"></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="2" style="font-weight:bold;">Gross Monthly Income: </td>
                                                                        <td colspan="2"><textarea id="borSoiIncome" class = "form-control borSoi save_dataa" placeholder="Insert Income here......"></textarea>
                                                                            <p class = "showPdf save_dataa borSoi"  id = "inputborIncome" name = "hideMe" hidden></p>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="2" style="font-weight:bold;">Remarks:</td>
                                                                        <td colspan="2"> <textarea id="borSoiRemarks" class = "form-control borSoi save_dataa" placeholder="Insert Remarks here......"></textarea>
                                                                    </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td colspan="4">
                                                                <table class = "table-condensed " style = "width : 100%; table-layout:fixed ">
                                                                    <tbody>
                                                                    <tr>
                                                                        <td colspan="4" style = "background-color: black; color : white;">CO-BORROWER'S SOURCE OF INCOME
                                                                            <button type="button" class = "btn btn-default btn-md pull-right minimizeCom" style = "margin-left : 10px"  tabIndex="-1">
                                                                                <i class="fa fa-fw fa-minus"></i></button>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="2" style="font-weight:bold;">Business Name / Employers Name:</td>
                                                                        <td colspan="2" ><textarea class = "form-control save_dataa cborSoi hidePdf"  id = "cborSoiName" placeholder="Insert Name here....."  ></textarea>
                                                                            <p class = "showPdf save_dataa cborSoi"  id = "inputcborBusiName" name = "hideMe" hidden></p>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="2" style="font-weight:bold;">Address:</td>
                                                                        <td colspan="2"><input type="text" class = "form-control save_dataa cborSoi " id = "cborSoiAddress"></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="2" style="font-weight:bold;">Length of Tenure/Length of Operation:</td>
                                                                        <td colspan="2"><input type="text" class = "form-control save_dataa cborSoi" id = "cborSoiTenure"></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="2" style="font-weight:bold;">Position/Staffs:</td>
                                                                        <td colspan="2"><input type="text" class = "form-control save_dataa cborSoi" id = "cborSoiPosStaffs"></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="2" style="font-weight:bold;">Gross Monthly Income: </td>
                                                                        <td colspan="2"><textarea id="cborSoiIncome" class = "form-control cborSoi save_dataa" placeholder="Insert Income here......"></textarea>
                                                                            <p class = "showPdf save_dataa cborSoi"  id = "inputcborIncome" name = "hideMe" hidden></p>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="2" style="font-weight:bold;">Remarks:</td>
                                                                        <td colspan="2"> <textarea id="cBorIncomeRemarks" class = "form-control borSoi save_dataa" placeholder="Insert Remarks here......"></textarea>
                                                                    </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="4">
                                                                <table class = "table-condensed " style = "width : 100%; table-layout:fixed ;">
                                                                    <tr>
                                                                        <td colspan="4" style = "background-color: black; color : white;">BORROWER'S BANK INFORMATION
                                                                            {{--<span class = "pull-right rowHide"><button type="button" class = "btn btn-block btn-success btn-md" id = "addBankInfo" tabIndex="-1"><i class="glyphicon glyphicon-plus"  tabIndex="-1" ></i></button></span>--}}
                                                                            <button type="button" class = "btn btn-default btn-md pull-right minimizeCom"  tabIndex="-1">
                                                                                <i class="fa fa-fw fa-minus"></i></button>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="2" style="font-weight:bold;">Bank Name / Bank Name:</td>
                                                                        <td colspan="2">
                                                                            <textarea id="BankName" class = "form-control save_dataa" placeholder="Insert bank info here......"></textarea>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>

                                                        <tr id="checkPrintCob" >
                                                            <td colspan="4" id="tdToFillCobs" hidden>
                                                            </td>
                                                        </tr>

                                                        <tr class="rowHide hideCobRow">
                                                            <td colspan="4"><button class="btn btn-block btn-success"  id="btnAddCobFinal" tabindex="-1"><i class="glyphicon glyphicon-plus"></i> Add Coborrower Information</button></td>
                                                        </tr>

                                                        <tr>
                                                            <td colspan="4">
                                                                <table class = "table-condensed " style = "width : 100%; table-layout:fixed ;">
                                                                    <tr>
                                                                        <td colspan="4" style = "background-color: black; color : white;">BARANGAY CHECKING
                                                                            {{--<span class = "pull-right rowHide"><button type="button" class = "btn btn-block btn-success btn-md" id = "addBankInfo" tabIndex="-1"><i class="glyphicon glyphicon-plus"  tabIndex="-1" ></i></button></span>--}}
                                                                            <button type="button" class = "btn btn-default btn-md pull-right minimizeCom"  tabIndex="-1">
                                                                                <i class="fa fa-fw fa-minus"></i></button>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="2" style="font-weight:bold;">Remarks:</td>
                                                                        <td colspan="2">
                                                                            <textarea id="remarksBarangay" class = "form-control borSoi save_dataa" placeholder="Insert Remarks here......">
                                                                            </textarea>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>



                                                        <tr>
                                                            <td colspan="4">
                                                                <table class = "table-condensed " style = "width : 100%; table-layout:fixed ">
                                                                    <tr>
                                                                        <td colspan="4" style = "background-color: black; color : white;">VALIDATION
                                                                            <button type="button" class = "btn btn-default btn-md pull-right minimizeCom"  tabIndex="-1">
                                                                                <i class="fa fa-fw fa-minus"></i></button>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="2" style="font-weight:bold;">Informant:</td>
                                                                        <td colspan="2"><input type="text" class = "form-control save_dataa" id = "informantCB"></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="2" style="font-weight:bold;">Contacted Thru:</td>
                                                                        <td colspan="2"><input type="text" class = "form-control save_dataa" id = "contactedThruCB"></td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="4">
                                                                <table class = "table-condensed to-loop" style = "width : 100%; table-layout:fixed ">
                                                                    <tr>
                                                                        <td colspan="4" style = "background-color: black; color : white;">DONE BY
                                                                            <button type="button" class = "btn btn-default btn-md pull-right minimizeCom"  tabIndex="-1">
                                                                                <i class="fa fa-fw fa-minus"></i></button>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="1" ><input type="text" class = "form-control save_dataa" id = "doneByName" name = "dont" disabled></td>
                                                                        <td colspan="1"><input type="text" class = "form-control save_dataa" id = "doneByCompany" name = "dont" disabled></td>
                                                                        <td colspan="1"><input type="text" class = "form-control save_dataa" id = "doneByDate" ></td>
                                                                        <td colspan="1"><input type="text" class = "form-control save_dataa" id = "doneByTime" ></td>
                                                                    </tr>

                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane" id="tab_cc_bank_2">
                                    <div class = "row">
                                        <div class="col-md-2"></div>
                                        <div class="col-md-8">
                                            <div class="row">
                                                <div class ="col-md-12">
                                                    <div class = "box box-danger">
                                                        <h3 style = "text-align: center; margin-top : 15px;">Encoded Data List</h3>
                                                        <table id = "cc-bank-encoded-list" class="display table-hover table-condensed" width=100%>
                                                            <thead>
                                                            <tr>
                                                                <th>ID</th>
                                                                <th>Saved Encoded Name</th>
                                                                <th>Date and Time Encoded</th>
                                                                <th>Status</th>
                                                            </tr>
                                                            </thead>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2"></div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="row">
                            <div class="col-md-12">
                                <button type="button" class="btn btn-default pull-left" id = "testPrintBank" >Print</button><span hidden id = "dlPdf"></span>
                                <button type="button" class="btn btn-danger pull-right" style="" id = "clear_cc_bank_fields" >Clear Fields</button>
                                <button type="button" class="btn btn-success" id = "sendCCbankTele">Save changes</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>



        <div class="modal fade" id="modal-loading-cc-bank">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <center><h5>LOADING PLEASE WAIT...</h5></center>
                            </div>
                        </div>
                        <div class = "row">
                            <div class="col-md-3"></div>
                            <div class = "col-md-6">
                                <center>
                                    <img src="{{asset('dist/img/loading.gif')}}" width="60%;" id="loadingGIF">
                                </center>
                            </div>
                            <div class="col-med-3"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>

        <div class="modal fade" id="modal-edit-contacts">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <h4 class="modal-title" style = "text-align: center;">Update / Edit Contact Details</h4>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="box box-primary">
                                    <div class="box-body">
                                        <div class="col-md-2"></div>
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label for="">Company/Institution Name :</label>
                                                <input type="text" class="form-control update_contact_text">
                                            </div>
                                            <div class="form-group">
                                                <label for="">Address :</label>
                                                <input type="text" class="form-control update_contact_text">
                                            </div>
                                            <div class="form-group">
                                                <label for="">Contact Number :</label>
                                                <input type="text" class="form-control update_contact_text">
                                            </div>
                                            <div class="form-group">
                                                <label for="">Contact Person :</label>
                                                <input type="text" class="form-control update_contact_text">
                                            </div>
                                            <div class="btn-group-vertical pull-right">
                                                <button class="btn btn-success btn-sm pull-right" style="margin-bottom:10px;" id="edit_contactButton">Edit Contact</button>
                                                <button class="btn btn-danger btn-sm pull-right" data-dismiss="modal" id="change_modal_contact">Cancel</button>
                                            </div>
                                        </div>
                                        <div class="col-md-2"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>


        <div class="modal fade" id="modal-view-contacts">
            <div class="modal-dialog" style="width: 80%;">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        {{--<h3 class="modal-title" style = "text-align: center;">Contact Numbers</h3>--}}
                        <div class="nav-tabs-custom">
                            <ul class="nav nav-tabs">
                                <li class="active">
                                    <a href="#yellow_page_tab" data-toggle="tab">Yellow Pages</a>
                                </li>
                                <li class="">
                                    <a href="#ignore_list_tab" data-toggle="tab">Add Contact</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="yellow_page_tab">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="box box-warning">
                                                <h3 class="box-title" style="">Contact Numbers</h3>
                                                <div class="box-body">
                                                    <table class="table-condensed table-hover" width="100%" id="comp_cont_num_table">
                                                        <thead>
                                                        <tr>
                                                            <th>Company/ Institution</th>
                                                            <th>Address/Barangay</th>
                                                            <th>Contact Details</th>
                                                            <th>Contact Person</th>
                                                            <th>Date/Time Updated</th>
                                                            <th>Action</th>
                                                        </tr>
                                                        </thead>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="ignore_list_tab">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="box box-danger">
                                                <div class="box-body">
                                                    <div class="form-group">
                                                        <label for="">Company/Institution Name :</label>
                                                        <input type="text" class="form-control comp_cont">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="">Address :</label>
                                                        <input type="text" class="form-control comp_cont">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="">Contact Number :</label>
                                                        <input type="text" class="form-control comp_cont">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="">Contact Person :</label>
                                                        <input type="text" class="form-control comp_cont">
                                                    </div>
                                                    <div class="form-group">
                                                        <button class="btn btn-success btn-md pull-right" id="add_comp_contact">Add Contact</button>
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
        </div>
        <!-- /.modal-content -->

        <div class="modal fade" id="modal-tfs-encoding">
            <div class="modal-dialog modal-lg" style="">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <center>
                            <h3>
                                Account Verification
                            </h3>
                        </center>
                    </div>
                    <div class="modal-body">
                        <div class="nav-tabs-custom">
                            <ul class="nav nav-tabs">
                                <li class="active">
                                    <a href="#tfs_tab1" data-toggle="tab">Encode Data</a>
                                </li>
                                <li class="">
                                    <a href="#tfs_tab2" data-toggle="tab">Saved Data</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="tfs_tab1">
                                    <div class="row" style="margin-bottom: 15px;">
                                        <div class="col-md-12">
                                            <table class="table-hover table-condensed" width="100%" id="cc_bank_encode_tbl">
                                                <tr style="background-color: black; color: white;">
                                                    <td colspan="12">
                                                        DEALER INFORMATION
                                                        <button class="pull-right btn btn-default btn-sm"><i class="fa fa-fw fa-minus"></i></button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6">DEALER NAME:</td>
                                                    <td colspan="6"><input type="text" class="form-control"></td>
                                                </tr>



                                                <tr style="background-color: black; color: white;">
                                                    <td colspan="12" class="get_dataaa" indexer="LOAN INFORMATION">
                                                        LOAN INFORMATION
                                                        <button class="pull-right btn btn-default btn-sm" indexer="LOAN INFORMATION"><i class="fa fa-fw fa-minus"></i></button>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6">APPLYING UNIT:</td>
                                                    <td colspan="6"><input type="text" class="form-control get_dataaa" indexer="LOAN INFORMATION"></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6">DOWNPAYMENT:</td>
                                                    <td colspan="6"><input type="text" class="form-control get_dataaa" indexer="LOAN INFORMATION"></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6">LOAN TERM:</td>
                                                    <td colspan="6"><input type="text" class="form-control get_dataaa" indexer="LOAN INFORMATION"></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6">ADDITIONAL REMARKS:</td>
                                                    <td colspan="6"><input type="text" class="form-control get_dataaa" indexer="LOAN INFORMATION"></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6">TYPE OF USE:</td>
                                                    <td colspan="6"><input type="text" class="form-control get_dataaa" indexer="LOAN INFORMATION"></td>
                                                </tr>


                                                <tr style="background-color: black; color: white;">
                                                    <td colspan="12" class="get_dataaa" indexer="EXISTING LOAN">
                                                        EXISTING LOAN
                                                        <button class="pull-right btn btn-default btn-sm" indexer="EXISTING LOAN"><i class="fa fa-fw fa-minus"></i></button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6">BANK NAME:</td>
                                                    <td colspan="6"><input type="text" class="form-control get_dataaa" indexer="EXISTING LOAN"></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6">TYPE OF LOAN:</td>
                                                    <td colspan="6"><input type="text" class="form-control get_dataaa" indexer="EXISTING LOAN"></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6">TERM:</td>
                                                    <td colspan="6"><input type="text" class="form-control get_dataaa" indexer="EXISTING LOAN"></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6">MONTHLY INSTALLMENT PAYMENT:</td>
                                                    <td colspan="6"><input type="text" class="form-control get_dataaa" indexer="EXISTING LOAN"></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="12"><button class="btn btn-block btn-sm btn-success"><i class="glyphicon glyphicon-plus"></i></button></td>
                                                </tr>

                                                 {{--BORROWER's INFORMATION--}}

                                                <tr style="background-color: black; color: white;">
                                                    <td colspan="12" class="get_dataaa" indexer="BORROWER'S INFORMATION">
                                                        BORROWER'S INFORMATION
                                                        <button class="pull-right btn btn-default btn-sm" indexer="BORROWER'S INFORMATION"><i class="fa fa-fw fa-minus"></i></button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6">COMPLETE NAME:</td>
                                                    <td colspan="6"><input type="text" class="form-control get_dataaa" indexer="BORROWER'S INFORMATION"></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6">BIRHDATE:</td>
                                                    <td colspan="6"><input type="date" class="form-control get_dataaa" indexer="BORROWER'S INFORMATION"></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6">BIRTH PLACE:</td>
                                                    <td colspan="6"><input type="text" class="form-control get_dataaa" indexer="BORROWER'S INFORMATION"></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6">CIVIL STATUS:</td>
                                                    <td colspan="6">
                                                        <select id="" class="form-control get_dataaa" indexer="BORROWER'S INFORMATION">
                                                            <option value="">-</option>
                                                            <option value="Single">Single</option>
                                                            <option value="Single with Live in Partner">Single with Live in Partner</option>
                                                            <option value="Single with Common Law">Single with Common Law</option>
                                                            <option value="Married">Married</option>
                                                            <option value="Married but not Legally Separated">Married but not Legally Separated</option>
                                                            <option value="Legally Separated">Legally Separated</option>
                                                            <option value="Widow">Widow</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6">MOTHER'S MAIDEN NAME:</td>
                                                    <td colspan="6"><input type="text" class="form-control get_dataaa" indexer="BORROWER'S INFORMATION"></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6">KYC: TIN #:</td>
                                                    <td colspan="6"><input type="text" class="form-control get_dataaa" indexer="BORROWER'S INFORMATION"></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6">KYC: SSS #:</td>
                                                    <td colspan="6"><input type="text" class="form-control get_dataaa" indexer="BORROWER'S INFORMATION"></td>
                                                </tr>

                                                {{--CO-BORROWER's INFORMATION--}}

                                                <tr style="background-color: black; color: white;">
                                                    <td colspan="12" class="get_dataaa" indexer="CO-BORROWER'S INFORMATION">
                                                        CO-BORROWER'S INFORMATION
                                                        <button class="pull-right btn btn-default btn-sm" indexer="CO-BORROWER'S INFORMATION"><i class="fa fa-fw fa-minus"></i></button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6">COMPLETE NAME:</td>
                                                    <td colspan="6"><input type="text" class="form-control get_dataaa" indexer="CO-BORROWER'S INFORMATION"></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6">BIRHDATE:</td>
                                                    <td colspan="6"><input type="date" class="form-control get_dataaa" indexer="CO-BORROWER'S INFORMATION"></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6">BIRTH PLACE:</td>
                                                    <td colspan="6"><input type="text" class="form-control get_dataaa" indexer="CO-BORROWER'S INFORMATION"></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6">CIVIL STATUS:</td>
                                                    <td colspan="6">
                                                        <select id="" class="form-control get_dataaa" indexer="CO-BORROWER'S INFORMATION">
                                                            <option value="">-</option>
                                                            <option value="Single">Single</option>
                                                            <option value="Single with Live in Partner">Single with Live in Partner</option>
                                                            <option value="Single with Common Law">Single with Common Law</option>
                                                            <option value="Married">Married</option>
                                                            <option value="Married but not Legally Separated">Married but not Legally Separated</option>
                                                            <option value="Legally Separated">Legally Separated</option>
                                                            <option value="Widow">Widow</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6">MOTHER'S MAIDEN NAME:</td>
                                                    <td colspan="6"><input type="text" class="form-control get_dataaa" indexer="CO-BORROWER'S INFORMATION"></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6">KYC: TIN #:</td>
                                                    <td colspan="6"><input type="text" class="form-control get_dataaa" indexer="CO-BORROWER'S INFORMATION"></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6">KYC: SSS #:</td>
                                                    <td colspan="6"><input type="text" class="form-control get_dataaa" indexer="CO-BORROWER'S INFORMATION"></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6">DEPENDENTS:</td>
                                                    <td colspan="6"><input type="text" class="form-control get_dataaa" indexer="CO-BORROWER'S INFORMATION"></td>
                                                </tr>

                                                {{--BORROWER'S PRESENT ADDRESS--}}

                                                <tr style="background-color: black; color: white;">
                                                    <td colspan="12" class=" get_dataaa" indexer="BORROWER'S PRESENT ADDRESS">
                                                        BORROWER'S PRESENT ADDRESS
                                                        <button class="pull-right btn btn-default btn-sm" indexer="BORROWER'S PRESENT ADDRESS"><i class="fa fa-fw fa-minus"></i></button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6">COMPLETE PRESENT ADDRESS:</td>
                                                    <td colspan="6"><textarea name="" id="" rows="3" style="resize: none" class="form-control get_dataaa" indexer="BORROWER'S PRESENT ADDRESS"></textarea></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6">LENGTH OF STAY:</td>
                                                    <td colspan="6"><input type="text" class="form-control get_dataaa" indexer="BORROWER'S PRESENT ADDRESS"></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6">REGISTERED OWNER:</td>
                                                    <td colspan="6"><input type="text" class="form-control get_dataaa" indexer="BORROWER'S PRESENT ADDRESS"></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6">PROOF OF BILLING:</td>
                                                    <td colspan="6"><input type="text" class="form-control get_dataaa" indexer="BORROWER'S PRESENT ADDRESS"></td>
                                                </tr>

                                                {{--BORROWER'S PERMANENT ADDRESS--}}

                                                <tr style="background-color: black; color: white;">
                                                    <td colspan="12" class="get_dataaa" indexer="BORROWER'S PERMANENT ADDRESS">
                                                        BORROWER'S PERMANENT ADDRESS
                                                        <button class="pull-right btn btn-default btn-sm" indexer="BORROWER'S PERMANENT ADDRESS"><i class="fa fa-fw fa-minus"></i></button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6">COMPLETE PERMANENT ADDRESS:</td>
                                                    <td colspan="6"><textarea name="" id="" rows="3" style="resize: none" class="form-control get_dataaa" indexer="BORROWER'S PERMANENT ADDRESS"></textarea></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6">LENGTH OF STAY:</td>
                                                    <td colspan="6"><input type="text" class="form-control get_dataaa" indexer="BORROWER'S PERMANENT ADDRESS"></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6">REGISTERED OWNER:</td>
                                                    <td colspan="6"><input type="text" class="form-control get_dataaa" indexer="BORROWER'S PERMANENT ADDRESS"></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6">PROOF OF BILLING:</td>
                                                    <td colspan="6"><input type="text" class="form-control get_dataaa" indexer="BORROWER'S PERMANENT ADDRESS"></td>
                                                </tr>


                                                {{--BORROWER'S SOI--}}

                                                <tr style="background-color: black; color: white;">
                                                    <td colspan="12" class="get_dataaa" indexer="BORROWER'S SOURCE OF INCOME">
                                                        BORROWER'S SOURCE OF INCOME
                                                        <button class="pull-right btn btn-default btn-sm" indexer="BORROWER'S SOURCE OF INCOME"><i class="fa fa-fw fa-minus"></i></button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6">EMPLOYER NAME:</td>
                                                    <td colspan="6"><input type="text" class="form-control get_dataaa" indexer="BORROWER'S SOURCE OF INCOME"></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6">TENURE:</td>
                                                    <td colspan="6"><input type="text" class="form-control get_dataaa" indexer="BORROWER'S SOURCE OF INCOME"></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6">POSITION/RANK:</td>
                                                    <td colspan="6"><input type="text" class="form-control get_dataaa" indexer="BORROWER'S SOURCE OF INCOME"></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6">MONTHLY SALARY:</td>
                                                    <td colspan="6"><input type="text" class="form-control get_dataaa" indexer="BORROWER'S SOURCE OF INCOME"></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6">REMARKS:</td>
                                                    <td colspan="6"><input type="text" class="form-control get_dataaa" indexer="BORROWER'S SOURCE OF INCOME"></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group pull-right">
                                                <button class="btn btn-danger">CLEAR FIELDS</button>
                                                <button class="btn btn-warning">SAVE</button>
                                                <button class="btn btn-primary" id="submit_generate_word">SUBMIT</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="tfs_tab2">
                                    2
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>



@endsection

@push('leftsidebar')
    @include('cc_dept.tele-encoder.cc-tele-encoder-leftsidebar')
@endpush

@push('jscript')
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/1.0.7/css/responsive.dataTables.min.css">
    <script src="https://cdn.datatables.net/responsive/2.1.1/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/rowreorder/1.2.0/js/dataTables.rowReorder.min.js"></script>
    <script src="{{ asset('jscript/cc-tele-encoder.js?n='.$javs) }}"></script>
    <script src="{{ asset('jscript/bi-download-file-view-info.js?n='.$javs) }}"></script>
@endpush