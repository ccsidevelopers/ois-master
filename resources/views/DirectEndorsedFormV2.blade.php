<!DOCTYPE html>
<html>
<style>
    /*@media screen {*/
        /*#printSection {*/
            /*display: none;*/
        /*}*/
    /*}*/

    /*@media print {*/
        /*body **/
        /*{*/
            /*visibility:hidden;*/
        /*}*/
        /*#printSection, #printSection * {*/
            /*visibility:visible;*/
        /*}*/
        /*#printSection*/
        /*{*/
            /*position:absolute;*/
            /*left:0;*/
            /*top:0;*/
        /*}*/
        /*@page*/
        /*{*/
            /*margin: 80px;*/
        /*}*/
    /*}*/
</style>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}" id="_token">
    <title>Comprehensive Credit Services Inc.</title>

    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ asset('bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('bower_components/font-awesome/css/font-awesome.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ asset('bower_components/Ionicons/css/ionicons.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/AdminLTE.min.css') }}">

<!-- HTML5 Shim and Respond.js IE8 sup{{ asset('') }}port of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    {{--header icon--}}
    <link rel="icon" href="dist/img/ccsi-icon.ico">
</head>
<body>
<div class="row">
    <div class="col-md-1"></div>
    <div class="col-md-10">
        <div class="box">
            <div class="panel panel-default" id="printThis">
                <div class="panel-body">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="box box-primary">
                                    <div class="box-body">

                                        <span id="cancidates_details"   >
                                            <div class="box-title">
                                                <h4 STYLE="font-weight: bold"><center><u>BACKGROUND INVESTIGATION FORM</u></center></h4>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <p><u>Please fill all information in <b>PRINTED</b>. If item is not applicable put "N/A"</u></p>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <p style="border: solid 1px; padding: 5px;"><b>CANDIDATE'S DETAILS</b></p>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <label for="">Applicant's Name:</label>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label for="">Surname: <small style="color: red;">* Required field</small></label>
                                                        <input type="text" id="accnt_surname" class="form-control required_fields" placeholder="Surname">
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label for="">Given Name: <small style="color: red;">* Required field</small></label>
                                                        <input type="text" id="accnt_fname" class="form-control required_fields" placeholder="Given Name">
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label for="">Complete Middle Name: <small style="color: orange;">* Optional field</small></label>
                                                        <input type="text" id="accnt_mname" class="form-control" placeholder="Complete Middle Name">
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label for="">Suffix: <small style="color: orange;">* Optional field</small></label>
                                                        <input type="text" id="accnt_suffix" class="form-control" placeholder="Suffix ( Jr / Sr / III , etc.)">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label for="">Civil Status:<small style="color: red;">* Required field</small></label>
                                                        <select name="" id="accnt_civil_status" class="form-control if_married">
                                                            <option value="-">-</option>
                                                            <option value="Single">Single</option>
                                                            <option value="Married">Married</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label for="">Gender:<small style="color: red;">* Required field</small></label>
                                                        <select name="" id="accnt_gender" class="form-control if_married">
                                                            <option value="-">-</option>
                                                            <option value="Male">Male</option>
                                                            <option value="Female">Female</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="">Birth Date : (mm/dd/yyyy)<small style="color: red;">* Required field</small></label>
                                                        <input type="date" id="accnt_bdate" class="form-control">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label for="">Age: <small style="color: orange;">* Auto Generated</small></label>
                                                        <input type="number" id ="accnt_age" class="form-control" disabled>
                                                    </div>
                                                </div>
                                            </div>

                                            <span id="if_married" hidden>
                                                <div class="box-header with-border" style="margin-top: -15px;"></div>

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <label for="" style="padding-bottom: 15px;">Maiden Name:</label>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label for="">Surname: <small style="color: red;">* Required field</small></label>
                                                        <input type="text" id="accnt_maiden_lname" class="form-control" placeholder="Surname">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="">Given Name: <small style="color: red;">* Required field</small></label>
                                                        <input type="text" id="accnt_maiden_fname" class="form-control" placeholder="Given Name">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="">Complete Middle Name: <small style="color: red;">* Required field</small></label>
                                                        <input type="text" id="accnt_maiden_mname" class="form-control" placeholder="Complete Middle Name">
                                                    </div>
                                                </div>
                                            </span>

                                            <div class="box-header with-border" style="margin-top: 20px;"></div>

                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label for="">Contact Number:<small style="color: orange;">* Optional field</small></label>
                                                        <input type="text" id="accnt_contact_number" class="form-control" placeholder="09XXXXXXXXX / (046) - XXX - XXXX">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="">Email Address:<small style="color: orange;">* Optional field</small></label>
                                                        <input type="email" id="accnt_email_address" class="form-control" placeholder="email@email.com">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label for="">SSS Number:<small style="color: orange;">* Optional field</small></label>
                                                        <input type="text" id="sss_num" class="form-control" placeholder="">
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label for="">PhilHealth Number:<small style="color: orange;">* Optional field</small></label>
                                                        <input type="text" id="philhealth_num" class="form-control" placeholder="">
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label for="">Pag-ibig Number:<small style="color: orange;">* Optional field</small></label>
                                                        <input type="text" id="pag_ibig_num" class="form-control" placeholder="">
                                                    </div>
                                                    <div class="col-md-3">
                                                        <small style="font-weight: bold">Tax Identification Number:<small style="color: orange;">* Optional field</small></small>
                                                        <input type="text" id="tin_num" class="form-control" placeholder="">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="box-header with-border" style="margin-bottom: 20px"></div>

                                            <div class="form-group">
                                                <label for="">Current Address:</label>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label for="">Unit #, Bldg/Street, Subd/Brgy.: <small style="color: red;">* Required field</small></label>
                                                        <textarea name="" id="accnt_current_address" rows="4" class="form-control required_fields" style="resize: none"></textarea>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="">City/Municipality: <small style="color: red">* Required field</small></label>
                                                        <input type="text" class="form-control required_fields" id="accnt_current_orig_muni">
                                                        <input type="hidden" id="accnt_current_orig_muni_id" class="form-control">
                                                        <label for="">Province: <small style="color: orange">* Auto Generated</small></label>
                                                        <input type="text" class="form-control" disabled id="accnt_current_muni">
                                                        <input type="hidden" id="accnt_current_muni_id" class="form-control">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="box-header with-border" style="margin-bottom: 20px"></div>

                                            <div class="form-group">
                                                <label for="">Permanent Address:</label>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label for="">Unit #, Bldg/Street, Subd/Brgy.: <small style="color: red;">* Required field</small></label>
                                                        <textarea name="" id="accnt_perm_add" rows="4" class="form-control required_fields" style="resize: none"></textarea>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="">City/Municipality: <small style="color: red">* Required field</small></label>
                                                        <input type="text" class="form-control required_fields" id="accnt_perm_orig_muni">
                                                        <input type="hidden" id="accnt_perm_orig_muni_id">
                                                        <label for="">Province: <small style="color: orange">* Auto Generated</small></label>
                                                        <input type="text" class="form-control" disabled id="accnt_perm_muni">
                                                        <input type="hidden" id="accnt_perm_muni_id">
                                                    </div>
                                                </div>
                                            </div>
                                        </span>

                                        <span id="emergency_contact" >
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <p style="border: solid 1px; padding: 5px;"><b>EMERGENCY CONTACT PERSON</b></p>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="">Name of Reference: <small style="color: red">* Required field</small></label>
                                                    <input type="text" class="form-control emergency_contact_input_0 required_fields">
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="">Relationship: <small style="color: red">* Required field</small></label>
                                                    <input type="text" class="form-control emergency_contact_input_0 required_fields">
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="">Contact Number: <small style="color: red">* Required field</small></label>
                                                    <input type="text" class="form-control emergency_contact_input_0 required_fields">
                                                </div>
                                                <div class="col-md-12">
                                                    <center>
                                                        <button class="btn btn-sm btn-success add_emergency_contact" title="Click to add" style="margin: 7px;"><i class="glyphicon glyphicon-plus"></i></button>
                                                    </center>
                                                </div>
                                            </div>
                                            <span id="additional_emergency_contact"></span>
                                        </span>

                                        <span id="character_reference" >
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <p style="border: solid 1px; padding: 5px;"><b>PROFESSIONAL CHARACTER REFERENCE</b></p>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="">Name of Reference: <small style="color: red">* Required field</small></label>
                                                    <input type="text" class="form-control charactec_ref_input_0 required_fields">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="">Relationship: <small style="color: red">* Required field</small></label>
                                                    <input type="text" class="form-control charactec_ref_input_0 required_fields">
                                                </div>

                                                <div class="col-md-6">
                                                    <label for="">Company and Position: <small style="color: red">* Required field</small></label>
                                                    <input type="text" class="form-control charactec_ref_input_0 required_fields">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="">Contact Details: <small style="color: red">* Required field</small></label>
                                                    <input type="text" class="form-control charactec_ref_input_0 required_fields">
                                                </div>
                                                <div class="col-md-12">
                                                    <center>
                                                        <button class="btn btn-sm btn-success" id="add_character_reference" style="margin: 7px;" title="Click to add"><i class="glyphicon glyphicon-plus"></i></button>
                                                    </center>
                                                </div>
                                            </div>

                                            <span id="additional_char_ref">
                                            </span>
                                        </span>

                                        <span id="employment_history" >
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <p style="border: solid 1px; padding: 5px;"><b>EMPLOYMENT HISTORY DETAILS</b></p>
                                                </div>
                                                <div class="col-md-12">
                                                    <label for="">NAME OF ORGANIZATION: <small style="color: red">* Required field</small></label>
                                                    <input type="text" class="form-control emp_input_0" required_fields>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="">Unit #, Bldg/Street, Subd/Brgy.: <small style="color: red;">* Required field</small></label>
                                                    <textarea name="" id="" rows="4" class="form-control emp_input_0 required_fields" style="resize: none"></textarea>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="">City/Municipality: <small style="color: red">* Required field</small></label>
                                                    <input type="text" id="employment_mun_0" class="form-control emp_input_0 required_fields">
                                                    <input type="hidden" id="employment_mun_id_0" class="form-control">
                                                    <label for="">Province: <small style="color: orange">* Auto Generated</small></label>
                                                    <input type="text" id="employment_prov_0" class="form-control emp_input_0" disabled>
                                                    <input type="hidden" id="employment_prov_id_0">
                                                </div>
                                                <div class="col-md-12">
                                                </div>

                                                <div class="col-md-4">
                                                    <label for="">Position (Upon hiring): <small style="color: red">* Required field</small></label>
                                                    <input type="date" class="form-control emp_input_0 required_fields">
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="">Position (Upon leaving): <small style="color: red">* Required field</small></label>
                                                    <input type="date" class="form-control emp_input_0 required_fields">
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="">Nature of Employment: <small style="color: red">* Required field</small></label>
                                                    <select name="" id="" class="form-control emp_input_0 required_fields">
                                                        <option value="-">-</option>
                                                        <option value="Full-Time">Full-Time</option>
                                                        <option value="Part-Time">Part-Time</option>
                                                        <option value="Self-Employed">Self-Employed</option>
                                                        <option value="Internship">Internship</option>
                                                    </select>
                                                </div>

                                                <div class="col-md-5">
                                                    <label for="">Immediate Supervisor: <small style="color: red">* Required field</small></label>
                                                    <input type="text" class="form-control emp_input_0 required_fields">
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="">Contact Number: <small style="color: red">* Required field</small></label>
                                                    <input type="text" class="form-control emp_input_0 required_fields">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <label for="">Reason for Leaving: <small style="color: red">* Required field</small></label>
                                                    <textarea name="" id="" rows="4" class="form-control emp_input_0 required_fields" style="resize: none;"></textarea>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="">Recuiter Remarks (R/O): <small style="color: red">* Required field</small></label>
                                                    <textarea name="" id="" rows="4" class="form-control emp_input_0 required_fields" style="resize: none;"></textarea>
                                                </div>
                                                <div class="col-md-12">
                                                    <center>
                                                        <button class="btn btn-sm btn-success" id="add_emp_hist" style="margin: 7px;"><i class="glyphicon glyphicon-plus"></i></button>
                                                    </center>
                                                </div>
                                            </div>

                                            <span id="additional_emp_hist"></span>
                                        </span>

                                        <span id="accnt_attachment">
                                            <div class="row form-group" style="">
                                                <div class="col-md-12">
                                                    <p style="border: solid 1px; padding: 5px;"><b>ATTACHMENTS </b><small style="color: red">(Required atleast 1 attachment)</small></p>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <label for="">Attachment 1 (TOR)</label>
                                                    <input type="file" class="fileSizeCheck" id="attach1">
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <label for="">Attachment 2(Application Form)</label>
                                                    <input type="file" class="fileSizeCheck" id="attach2">
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <label for="">Attachment 3(COE)</label>
                                                    <input type="file" class="fileSizeCheck" id="attach3">
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <label for="">Attachment 4(Others)</label>
                                                    <input type="file" class="fileSizeCheck" id="attach4">
                                                </div>
                                             </div>
                                        </span>

                                        {{--<span id="address_check" >--}}
                                             {{--<div class="row">--}}
                                                {{--<div class="col-md-12">--}}
                                                    {{--<p style="border: solid 1px; padding: 5px;"><b>ADDRESS CHECK</b></p>--}}
                                                {{--</div>--}}
                                                {{--<div class="col-md-12">--}}
                                                    {{--<center><p>Please provide a sketch of your current address</p>--}}
                                                    {{--<label for="skectch_cur_add" class="btn btn-primary btn-md" id="skectch_cur_add_label" style="margin-bottom:15px;">Click to upload sketch</label>--}}
                                                    {{--<input type="file" id="skectch_cur_add" style="display: none">--}}
                                                    {{--</center>--}}
                                                {{--</div>--}}
                                             {{--</div>--}}
                                        {{--</span>--}}



                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                    {{--<button class="btn btn-info" id="print_endor">Print</button>--}}
                    <button class="btn btn-success" id="submit_endorsement">Submit</button>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-1"></div>
</div>


    <div class="modal modal-warning fade" id="modal_loading">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Please wait..</h4>
                </div>
                <div class="modal-body">
                    <p style="text-align: center">We are processing your request. <img src="{{ asset('dist/img/loading.gif') }}" style="width: 5%;"></p>

                    <span id="ulPercentage_attachment"></span>
                    <div id="progressbar_attachment" hidden></div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline pull-right" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal modal-success fade" id="modal_success">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Success!</h4>
                </div>
                <div class="modal-body">
                    <p style="text-align: center">Successfully Submitted!</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline pull-right" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal modal-danger fade" id="modal_error">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Oops something went wrong!</h4>
                </div>
                <div class="modal-body">
                    <p style="text-align: center">Can't process your endorsement, Please contact the system administrator. Thank you.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline pull-right" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal modal-danger fade" id="modal_inc">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Required Field.</h4>
                </div>
                <div class="modal-body">
                    <p style="text-align: center">Please Complete All Required Field.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline pull-right" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


</body>
<!-- jQuery 3 -->
<script src="{{ asset('bower_components/jquery/dist/jquery.min.js') }}"></script>
<!-- Bootstrap 3.3.7 -->
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
{{--<script src="{{ asset('jscript/bi.js') }}"></script>--}}
<script src="{{ asset('jscript/directEndorse2.js') }}"></script>
<script src="{{ asset('bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
</html>
