<!DOCTYPE html>
<html>
    @include('layouts.includes.headerplugins')

    <link rel="stylesheet" href="https://cdn.datatables.net/rowreorder/1.2.0/css/rowReorder.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.1.1/css/responsive.dataTables.min.css">



    <body class="skin-red layout-top-nav">
        <header class="main-header">
            <nav class="navbar navbar-static-top">
                <div class="container-fluid">
                    <div class="logo">
                        <img src="{{ asset('dist\img\ccsi-logo.png') }}">
                    </div>

                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                            <i class="fa fa-bars"></i>
                        </button>
                    </div>

                    <div class="collapse navbar-collapse" id="navbar-collapse">
                        <ul class="nav navbar-nav navbar-right">
                            <li><a href="#" id="seeOnlineAppModal">See Online Application</a></li>
                            {{--<li><a href="" data-toggle="modal" data-target="#modal-contact-us">Contact Us</a></li>--}}
                        </ul>
                    </div>
                    <!-- /.navbar-collapse -->
                </div>
                <!-- /.container-fluid -->
            </nav>
        </header>

        <div class="box">
            <div class="col-md-12">
                <div class="box-body">
                    <div class="panel panel-success">
                        <div class="panel-heading" style="text-align: center">
                            <h4>
                                <label for="">PERSONAL HISTORY STATEMENT</label>
                            </h4>
                        </div>
                        <div class="panel-body">
                            <div id="smartwizard" style="padding-left : 5%; padding-right: 5%">
                                <ul class="nav">
                                    <li>
                                        <a class="nav-link" href="#step-1">
                                            I. PERSONAL DETAILS
                                        </a>
                                    </li>
                                    <li>
                                        <a class="nav-link" href="#step-2">
                                            II. WORK EXPERIENCE
                                        </a>
                                    </li>
                                    <li>
                                        <a class="nav-link" href="#step-3">
                                            III. AFFILIATIONS/ CONNECTIONS
                                        </a>
                                    </li>
                                    {{--<li>--}}
                                        {{--<a class="nav-link" href="#step-4">--}}
                                            {{--IV. OPTIONAL(OTHERS)--}}
                                        {{--</a>--}}
                                    {{--</li>--}}
                                    <li>
                                        <a class="nav-link" href="#step-5">
                                            IV. ATTACHMENTS/DOCUMENTS
                                        </a>
                                    </li>
                                </ul>

                               <div class="tab-content changeTabContent" style="height : 100%; ">
                                    <div id="step-1" class="tab-pane" role="tabpanel">
                                        <div class="row" style="padding-top : 40px;">
                                            <div class="col-md-2"></div>
                                            <div class="col-md-8">
                                                <div class="box box-primary">
                                                    <div class="box-header with-border">
                                                        <div class = "box-title">Personal Details</div>
                                                    </div>
                                                    <div class="box-body">
                                                        <p style="color : red " id="redToShowNecessary" class="hideRedwarnings" hidden>*Please fill up necessary fields</p>
                                                        <p style="color : red" id="redToShowSSS" class="hideRedwarnings" hidden>*Please enter valid SSS number</p>
                                                        <p style="color : red" id="redToShowEmail" class="hideRedwarnings" hidden>*Please enter valid email address</p>
                                                        <div class = "row" style="padding-top: 20px;">
                                                            <div class = "form-group col-md-3">
                                                                <label>Last Name:</label><small style="color: red;"> (Required Field)</small>
                                                                <input type="text"
                                                                       class = "form-control save_this_data required_personal toRed" what="personal_details" id = "acct_last" name = "acct_last">
                                                            </div>
                                                            <div class = "form-group col-md-3">
                                                                <label>First Name:</label><small style="color: red;"> (Required Field)</small>
                                                                <input type="text"
                                                                       class = "form-control save_this_data required_personal toRed" what="personal_details" id = "acct_first" name = "acct_first">
                                                            </div>
                                                            <div class = "form-group col-md-3">
                                                                <label>Middle Name:</label><small style="color: red;"> (Required Field)</small>
                                                                <input type="text"
                                                                       class = "form-control save_this_data required_personal toRed" what="personal_details " id = "acct_middle" name = "acct_middle">
                                                            </div>
                                                            <div class = "form-group col-md-3">
                                                                <label>Suffix Name:</label><small style="color: orange;"> (Optional Field)</small>
                                                                <input type="text"
                                                                       class = "form-control save_this_data" what="personal_details" id = "acct_suffix" name = "acct_suffix">
                                                            </div>
                                                        </div>

                                                        <div class = "row">
                                                            <div class="form-group col-md-3">
                                                                <label>Birthdate:</label><small style="color: red;"> (Required Field)</small>
                                                                <input type="date" class = "form-control save_this_data required_personal toRed" what="personal_details" id="acct_birthdate_full" name="acct_birthdate_full">
                                                            </div>
                                                            <div class="form-group col-md-3">
                                                                <label>Age:</label><small style="color: red;"> (Required Field)</small>
                                                                <input type="number" class = "form-control save_this_data required_personal toRed" what="personal_details" id="acct_age" name="acct_age" disabled>
                                                            </div>
                                                            <div class = "form-group col-md-3">
                                                                <label>Gender:</label><small style="color: red;"> (Required Field)</small>
                                                                <select class="acct_gender form-control save_this_data required_personal toRed toDash" what="personal_details"  id="acct_gender" name="acct_gender">
                                                                    <option value =
                                                                            "-">-</option>
                                                                    <option value =
                                                                            "Male">Male</option>
                                                                    <option value =
                                                                            "Female">Female</option>
                                                                </select>
                                                            </div>
                                                            <div class = "form-group col-md-3">
                                                                <label>Marital Status:</label><small style="color: orange;"> (Optional Field)</small>
                                                                <select class="acct_marital_status form-control save_this_data toDash" what="personal_details" name="acct_marital_status" id="acct_marital_status">
                                                                    <option value ="-">-</option>
                                                                    <option value ="Single">Single</option>
                                                                    <option value ="Married">Married</option>
                                                                    <option value ="Widowed">Widowed</option>
                                                                    <option value ="Divorced">Divorced</option>
                                                                    <option value ="Separated">Separated</option>
                                                                </select>
                                                            </div>

                                                        </div>

                                                        <div hidden id="if_married_check">
                                                            <div class="row" style="padding-top : 10px; padding-bottom : 10px;">
                                                                <div class="form-group col-md-4">
                                                                    <label>Maiden Last Name:</label><small style="color: orange;"> (Optional Field)</small>
                                                                    <input type="text" class = "form-control save_this_data" what="personal_details" id = "acct_maiden_last_name" name = "acct_maiden_last_name">
                                                                </div>
                                                                <div class="form-group col-md-4">
                                                                    <label>Maiden First Name:</label><small style="color: orange;"> (Optional Field)</small>
                                                                    <input type="text" class = "form-control save_this_data" what="personal_details" id = "acct_maiden_first_name" name = "acct_maiden_first_name">
                                                                </div>
                                                                <div class="form-group col-md-4">
                                                                    <label>Maiden Middle Name:</label><small style="color: orange;"> (Optional Field)</small>
                                                                    <input type="text" class = "form-control save_this_data" what="personal_details" id = "acct_maiden_middle_name" name = "acct_maiden_middle_name">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class = "row">
                                                            <div class = "form-group col-md-3">
                                                                <label>SSS no: <small style="color : red;">*Required: 10-digit</small></label>
                                                                <input type="number" class="form-control save_this_data toRed" what="personal_details" id="acct_sss" name="acct_sss" >
                                                            </div>
                                                            <div class="form-group col-md-3">
                                                                <label>Tel/CP no.</label>
                                                                <input type="number" class="form-control save_this_data" what="personal_details" id="acct_tel_cp" name="acct_tel_cp">
                                                            </div>

                                                            <div class = "form-group col-md-3">
                                                                <label>Email:</label><small style="color: red;"> (Required Field)</small>
                                                                <input type="text" class = "form-control save_this_pesonal_email required_personal toRed" what="personal_details" id = "personal_email" name = "personal_email">
                                                            </div>


                                                        </div>
                                                        <div class = "row">

                                                        </div>


                                                        <div class="box-header with-border" style="padding : 0; margin-top : 20px;">
                                                            <b>Present Address</b>
                                                        </div>
                                                        <div class ="row">
                                                            <input class="save_this_data form-control required_personal" type="hidden" id="acct_present_address_provID" what="personal_details"  name="acct_present_address_provID" muniVal = "acct_present_muni">
                                                            <input class="save_this_data  form-control required_personal" type="hidden" id="acct_present_address_muniID" what="personal_details" name="acct_present_address_muniID" muniVal = "acct_present_province">
                                                            <div class="form-group col-md-5">
                                                                <label>Unit #, Bldg/Street, Subd/Brgy.</label><small style="color: red;"> (Required Field)</small>
                                                                <input type="text" class="form-control save_this_data required_personal toRed" placeholder="" id="acct_present_address" what="personal_details" name="present_address">
                                                            </div>
                                                            <div class="form-group col-md-3" data-toggle="tooltip" title="Please select city/municipality suggestion list appear below the textbox, this will be auto generate the province">

                                                                <label>City/Municipality</label><small style="color: red;"> (Required Field)</small>
                                                                <input type="text" class="form-control ui-autocomplete-input cityMuniProvClass toRed" placeholder="" id="acct_present_muni" name="municipality" autocomplete="off">
                                                            </div>
                                                            <div class="form-group col-md-4"><label>Province</label><small style="color: red;"> (Auto Generated)</small><span id="loading_present_Prov"></span>
                                                                <input type="text" class="form-control cityMuniProvClass toRed" placeholder="" id="acct_present_province" name="province" disabled="">
                                                            </div>
                                                        </div>

                                                        <input type="checkbox" id="bi_check_same_address" value="same_address">
                                                        <strong>
                                                            Check if "PermanentAddress" same as "Present Address"
                                                        </strong>

                                                        <div class="box-header with-border" style="padding : 0; margin-top : 20px;">
                                                            <b>Permanent Address</b>
                                                        </div>

                                                        <div class ="row">
                                                            <input class="save_this_data form-control required_personal" type="hidden" id="acct_perma_address_provID" what="personal_details" name="acct_perma_address_provID" muniVal = "acct_perma_muni">
                                                            <input class="save_this_data form_control required_personal" type="hidden" id="acct_perma_address_muniID" what="personal_details" name="acct_perma_address_muniID" muniVal = "acct_perma_province">
                                                            <div class="form-group col-md-5">
                                                                <label>Unit #, Bldg/Street, Subd/Brgy.</label><small style="color: red;"> (Required Field)</small>
                                                                <input type="text" class="form-control toDisable save_this_data required_personal toEnableAdd toRed" placeholder="" id="acct_perma_address" name="perma_address">
                                                            </div>
                                                            <div class="form-group col-md-3" data-toggle="tooltip" title="Please select city/municipality suggestion list appear below the textbox, this will be auto generate the province">
                                                                <label>City/Municipality</label><small style="color: red;"> (Reuired Field)</small>
                                                                <input type="text" class="form-control ui-autocomplete-input toDisable cityMuniProvClass toEnableAdd toRed" placeholder="" id="acct_perma_muni" name="municipality" autocomplete="off"></div>
                                                            <div class="form-group col-md-4">
                                                                <label>Province</label><small style="color: red;"> (Auto Generated)</small><span id="loading_permanent_Prov"></span>
                                                                <input type="text" class="form-control toClear cityMuniProvClass toRed" placeholder="" id="acct_perma_province" name="province" disabled="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            {{--<div class="col-md-2">--}}
                                                {{--<div class="box box-primary">--}}
                                                    {{--<div class = "row" style="padding-top : 40px">--}}
                                                        {{--<div class="col-md-1"></div>--}}
                                                        {{--<div class="col-md-10">--}}
                                                            {{--<form id="form1" runat="server">--}}
                                                                {{--<img id = "uploadedImgView" style = "width: 100% ; height: 100%; border:5px solid #000;" src = "{{asset('user_profile_pictures/default3.jpg')}}" />--}}
                                                            {{--</form>--}}
                                                        {{--</div>--}}
                                                        {{--<div class="col-md-1"></div>--}}
                                                    {{--</div>--}}
                                                    {{--<div class = "row" style="padding-top : 20px;">--}}
                                                        {{--<div class="col-md-12">--}}
                                                            {{--<input type='file' id="cancelImgUploaded" /><button id = "cancelImg" class="pull-right" style="margin-bottom: 10px">Cancel</button>--}}
                                                        {{--</div>--}}
                                                    {{--</div>--}}
                                                {{--</div>--}}
                                            {{--</div>--}}
                                            <div class="col-md-2"></div>
                                        </div>
                                        <div class="row" style="padding-top : 40px;" id="divMaritalHistoryShow" hidden>
                                            <div class="col-md-2"></div>
                                            <div class="col-md-8">
                                                <div class="box box-primary">
                                                    <div class="box-header with-border">
                                                        <div class = "box-title">Marital History</div>
                                                    </div>
                                                    <div class="box-body">
                                                        <div class = "row" style="padding-top : 20px">
                                                            <div class = "form-group col-md-8">
                                                                <label for="">Name of Spouse:</label>
                                                                <input type="text" class="form-control save_this_data clearMaritalInputs" what="marital_history" id="acct_spouse_name" name="acct_spouse_name" >
                                                            </div>
                                                            <div class = "form-group col-md-4">
                                                                <label for="">Telephone/ Mobile No.:</label>
                                                                <input type="number" class="form-control save_this_data clearMaritalInputs" what="marital_history" id="acct_spouse_present_tel_cp"  name="acct_spouse_present_tel_cp">
                                                            </div>
                                                        </div>
                                                        {{--<div class = "row" style="padding-top : 10px;">--}}
                                                            {{--<div class = "form-group col-md-12">--}}
                                                                {{--<h4>Children: <button class="btn btn-xs btn-success" id="btnAddAcctChildren"><i class="fa fa-plus"></i></button></h4>--}}
                                                                {{--<table class="display table-hover responsive"  style="width : 100%" id="childrenDatatable">--}}
                                                                    {{--<thead>--}}
                                                                    {{--<tr>--}}
                                                                        {{--<th>Name</th>--}}
                                                                        {{--<th>Date of Birth</th>--}}
                                                                        {{--<th>Place of Birth</th>--}}
                                                                        {{--<th></th>--}}
                                                                    {{--</tr>--}}
                                                                    {{--</thead>--}}
                                                                    {{--<tbody id = "acct_table_children" class="tableClearAll">--}}
                                                                    {{--</tbody>--}}
                                                                {{--</table>--}}
                                                            {{--</div>--}}
                                                        {{--</div>--}}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2"></div>
                                        </div>
                                        <div class="row" style="padding-top : 40px;" hidden>
                                            <div class="col-md-2"></div>
                                            <div class="col-md-8">
                                                <div class="box box-primary">
                                                    <div class="box-header with-border">
                                                        <div class = "box-title">Family History and Information</div>
                                                    </div>
                                                    <div class="box-body">
                                                        <div class = "row" style="padding-top : 20px;">
                                                            <div class = "form-group col-md-4">
                                                                <label for="">Father's Full Name:</label>
                                                                <input type="text" class="form-control save_this_data" what="family_history" id="acct_father_full" name="acct_father_full">
                                                            </div>
                                                            <div class = "form-group col-md-2">
                                                                <label for="">Age:</label>
                                                                <input type="number" class="form-control save_this_data" what="family_history" id="acct_father_age" name="acct_father_age">
                                                            </div>
                                                            <div class = "form-group col-md-4">
                                                                <label for="">Occupation:</label>
                                                                <input type="text" class="form-control save_this_data" what="family_history" id="acct_father_occupation" name="acct_father_occupation">
                                                            </div>
                                                            <div class = "form-group col-md-2">
                                                                <label for="">Telephone/ Mobile No.:</label>
                                                                <input type="number" class="form-control save_this_data" what="family_history" id="acct_father_tel" name="acct_father_tel">
                                                            </div>

                                                        </div>
                                                        <div class = "row">
                                                            <div class = "form-group col-md-4">
                                                                <label for="">Mother's Full Name:</label>
                                                                <input type="text" class="form-control save_this_data" what="family_history" id="acct_mother_full" name="acct_mother_full">
                                                            </div>
                                                            <div class = "form-group col-md-2">
                                                                <label for="">Age:</label>
                                                                <input type="number" class="form-control save_this_data" what="family_history" id="acct_mother_age"  name="acct_mother_age">
                                                            </div>
                                                            <div class = "form-group col-md-4">
                                                                <label for="">Occupation:</label>
                                                                <input type="text" class="form-control save_this_data" what="family_history" id="acct_mother_occupation" name="acct_mother_occupation">
                                                            </div>
                                                            <div class = "form-group col-md-2">
                                                                <label for="">Telephone/ Mobile No.:</label>
                                                                <input type="number" class="form-control save_this_data" what="family_history" id="acct_mother_tel" name="acct_mother_tel">
                                                            </div>
                                                        </div>

                                                        {{--<div class = "row" style="padding-top : 20px;">--}}
                                                            {{--<div class = "form-group col-md-12">--}}
                                                                {{--<h4>Siblings: <button class="btn btn-xs btn-success" id="btnAddSiblings"><i class="fa fa-plus"></i></button></h4>--}}
                                                                    {{--<table class="display table-hover responsive"  style="width : 100%" id="siblingsnDatatable">--}}
                                                                        {{--<thead>--}}
                                                                        {{--<tr>--}}
                                                                            {{--<th>Name</th>--}}
                                                                            {{--<th>Age</th>--}}
                                                                            {{--<th>Address</th>--}}
                                                                            {{--<th>Occupation</th>--}}
                                                                            {{--<th></th>--}}
                                                                        {{--</tr>--}}
                                                                        {{--</thead>--}}
                                                                        {{--<tbody id="acct_table_siblings" class="tableClearAll">--}}
                                                                        {{--</tbody>--}}
                                                                    {{--</table>--}}
                                                            {{--</div>--}}
                                                        {{--</div>--}}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2"></div>
                                        </div>
                                        <div class="row" style="padding-top : 40px;">
                                            <div class="col-md-2"></div>
                                            <div class="col-md-8">
                                                <div class="box box-primary">
                                                    <div class="box-header with-border">
                                                        <div class = "box-title">Educational Background</div>
                                                    </div>
                                                    <div class="box-body">
                                                        <div class = "row">
                                                            <div class = "form-group col-md-3">
                                                                <label for="">Secondary (Name of School):</label>
                                                                <textarea class="form-control save_this_data" rows="2" id="acct_secondary_name" what="educ_background" name="acct_secondary_name"></textarea>
                                                            </div>
                                                            <div class = "form-group col-md-3">
                                                                <label for="">Location:</label>
                                                                <textarea class="form-control save_this_data" rows="2" id="acct_secondary_loc" what="educ_background" name="acct_secondary_loc"></textarea>
                                                            </div>
                                                            <div class = "form-group col-md-3">
                                                                <label for="">Inclusive Dates of Attendance:</label>
                                                                <input type="text" class="form-control save_this_data" id="acct_secondary_inclusive" what="educ_background" name="acct_secondary_inclusive">
                                                            </div>
                                                            <div class = "form-group col-md-3">
                                                                <label for="">Year Graduated/Degree:</label>
                                                                <input type="text" class="form-control save_this_data" id="acct_secondary_year" what="educ_background" name="acct_secondary_year">
                                                            </div>
                                                        </div>
                                                        <div class = "row">
                                                            <div class = "form-group col-md-3">
                                                                <label for="">College (Name of School):</label>
                                                                <textarea class="form-control save_this_data" rows="2" id="acct_college" what="educ_background"  name="acct_college"></textarea>
                                                            </div>
                                                            <div class = "form-group col-md-3">
                                                                <label for="">Location:</label>
                                                                <textarea class="form-control save_this_data" rows="2" id="acct_college_loc" what="educ_background" name="acct_college_loc"></textarea>
                                                            </div>
                                                            <div class = "form-group col-md-3">
                                                                <label for="">Inclusive Dates of Attendance:</label>
                                                                <input type="text" class="form-control save_this_data" id="acct_college_inclusive" what="educ_background" name="acct_college_inclusive">
                                                            </div>
                                                            <div class = "form-group col-md-3">
                                                                <label for="">Year Graduated/Degree:</label>
                                                                <input type="text" class="form-control save_this_data"  id="acct_college_year" what="educ_background" name="acct_college_year">
                                                            </div>
                                                        </div>
                                                        <div class = "row" style="padding-top : 10px;">
                                                            <div class = "form-group col-md-12">
                                                                <label for="">Other Schools Attended, Dates of Attendance, and Certificate / Degree Earned:</label>
                                                                <textarea class="form-control save_this_data" rows="2" id="acct_other_schools" what="educ_background" name="acct_other_schools"></textarea>
                                                            </div>
                                                        </div>
                                                        <div class = "row" >
                                                            <div class = "form-group col-md-12">
                                                                <label for="">Civil Service Eligibility, if any, and other similar qualification/s required.
                                                                    State rating & Professional Regulations Commision License No. if applicable:</label>
                                                                <textarea class="form-control save_this_data" rows="2" id="acct_civil_service" what="educ_background" name="acct_civil_service"></textarea>
                                                            </div>
                                                        </div>


                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2"></div>
                                        </div>
                                        <div class="row" style="padding-top : 20px;">
                                            <div class="col-md-2"></div>
                                            <div class="col-md-8">
                                                <div class="box box-primary">
                                                    <div class="box-header with-border">
                                                        <div class = "box-title">Places of Residence since Birth</div>
                                                    </div>
                                                    <div class="box-body">
                                                        <div class = "row" style="padding-top : 20px;">
                                                            <div class = "form-group col-md-12">
                                                                <h4>List down residences: <button class="btn btn-xs btn-success" id="btnAddResidences"><i class="fa fa-plus"></i></button></h4>
                                                                <table class="display table-hover responsive"  style="width : 100%" id="residencesDatatable">
                                                                    <thead>
                                                                    <tr>
                                                                        <th>Inclusive Dates</th>
                                                                        <th>Complete Address</th>
                                                                        <th></th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody id="acct_table_residences" class="tableClearAll">
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2"></div>
                                        </div>
                                        <div class="row" style="padding-top : 20px">
                                            <div class="col-md-12">
                                                <button class="btn btn-primary btn-md pull-right btnnextTab" style="margin-left : 10px">Next <i class="glyphicon glyphicon-triangle-right"></i> </button>
                                                <button class="btn btn-default btn-md pull-right btnpreviousTab" disabled><i class="glyphicon glyphicon-triangle-left"></i> Previous</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="step-2" class="tab-pane" role="tabpanel">
                                        <div class="row" style="padding-top : 40px;">
                                            <div class="col-md-1"></div>
                                            <div class="col-md-10">
                                                <div class="box box-primary">
                                                    <div class="box-header with-border">
                                                        <div class = "box-title">Work Experience</div>
                                                    </div>
                                                    <div class="box-body">
                                                        <div class = "row" style="padding-top : 20px;">
                                                            <div class = "form-group col-md-12" style="overflow-x : auto">
                                                                <h4>List down changes in position/designation for the last 10 years to present: <button class="btn btn-xs btn-success" id="btnAddWorkExp"><i class="fa fa-plus"></i></button></h4>
                                                                    <table  class="display table-hover responsive"  style="width : 100%" id="workExpDatatable">
                                                                        <thead>
                                                                        <tr>
                                                                            <th>Date Started</th>
                                                                            <th>Date Ended</th>
                                                                            <th></th>
                                                                            <th>Employer Name</th>
                                                                            <th>Position</th>
                                                                            <th>Employee No. <small style="color : orange">(optional)</small></th>
                                                                            <th>Employer Address </th>
                                                                            <th>Employer Contact No</th>
                                                                            <th>Name of Supervisor</th>
                                                                            <th>Contact number of Supervisor</th>
                                                                            <th>Reason for Leaving</th>
                                                                            <th></th>
                                                                        </tr>
                                                                        </thead>
                                                                        <tbody id="acct_table_work_exp" class="tableClearAll">
                                                                        </tbody>
                                                                    </table>
                                                            </div>
                                                        </div>
                                                        <div class = "row" style="padding-top : 20px;">
                                                            <div class = "form-group col-md-12">
                                                                <label for="">Have you ever been dismissed or forced to resign from a position?
                                                                    <input type="text" class="save_this_data" id="acct_dismissed" what="work_experience" name="acct_dismissed"> If yes, explain:</label>

                                                                <textarea class="form-control save_this_data" rows="2" id="acct_dismissed_reason" what="work_experience" name="acct_dismissed_reason"></textarea>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-1    "></div>
                                        </div>
                                        <div class="row" style="padding-top : 20px">
                                            <div class="col-md-12" >
                                                <button class="btn btn-primary btn-md pull-right btnnextTab" style="margin-left : 10px">Next <i class="glyphicon glyphicon-triangle-right"></i> </button>
                                                <button class="btn btn-default btn-md pull-right btnpreviousTab" disabled><i class="glyphicon glyphicon-triangle-left"></i> Previous</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="step-3" class="tab-pane" role="tabpanel">
                                        <div class="row" style="padding-top : 40px;">
                                            <div class="col-md-1"></div>
                                            <div class="col-md-10">
                                                <div class="box box-primary">
                                                    <div class="box-header with-border">
                                                        <div class = "box-title">Professional Reference </div>
                                                    </div>
                                                    <div class="box-body">
                                                        <div class = "row" style="padding-top : 20px;">
                                                            <div class = "form-group col-md-12">
                                                                <h4>Professional References: <small style="color : red"> Required(3)</small> <button class="btn btn-xs btn-success" id="btnAddCharacter"><i class="fa fa-plus"></i></button></h4>
                                                                <table class="display table-hover responsive"  style="width : 100%" id="characDatatable">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Name</th>
                                                                            <th>Position Employment</th>
                                                                            <th>Company Address</th>
                                                                            <th>Email Address <small style="color : orange">(optional)</small></th>
                                                                            <th>Telephone No./Mobile No.</th>
                                                                            <th></th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody id="acct_table_character" class="tableClearAll">
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-1"></div>
                                        </div>
                                        <div class="row" style="padding-top : 20px;">
                                            <div class="col-md-1"></div>
                                            <div class="col-md-10">
                                                <div class="box box-primary">
                                                    <div class="box-header with-border">
                                                        <div class = "box-title">Membership in Civic/Religious Organization</div>
                                                    </div>
                                                    <div class="box-body">
                                                        <div class = "row" style="padding-top : 20px;">
                                                            <div class = "form-group col-md-12">
                                                                <h4>List down organizations: <button class="btn btn-xs btn-success" id="btnAddOrg"><i class="fa fa-plus"></i></button></h4>
                                                                <table class="display table-hover responsive"  style="width : 100%" id="orgsDatatable">
                                                                    <thead>
                                                                    <tr>
                                                                        <th>Name of Organization</th>
                                                                        <th>Date of Membership</th>
                                                                        <th>Position</th>
                                                                        <th></th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody id="acct_table_org" class="tableClearAll">
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-1"></div>
                                        </div>
                                        <div class="row" style="padding-top : 20px;">
                                            <div class="col-md-1"></div>
                                            <div class="col-md-10">
                                                <div class="box box-primary">
                                                    <div class="box-header with-border">
                                                        <div class = "box-title">Trainings Attended</div>
                                                    </div>
                                                    <div class="box-body">
                                                        <div class = "row" style="padding-top : 20px;">
                                                            <div class = "form-group col-md-12">
                                                                <h4>List down trainings: <button class="btn btn-xs btn-success" id="btnAddTraining"><i class="fa fa-plus"></i></button></h4>
                                                                <table class="display table-hover responsive"  style="width : 100%" id="trainingsDatatables" >
                                                                    <thead>
                                                                    <tr>
                                                                        <th>Nature/Title</th>
                                                                        <th>Conducted by</th>
                                                                        <th>Year - Taken</th>
                                                                        <th></th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody id="acct_training_table" class="tableClearAll">
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-1"></div>
                                        </div>
                                        <div class="row" style="padding-top : 20px">
                                            <div class="col-md-12">
                                                <button class="btn btn-primary btn-md pull-right btnnextTab" style="margin-left : 10px">Next <i class="glyphicon glyphicon-triangle-right"></i> </button>
                                                <button class="btn btn-default btn-md pull-right btnpreviousTab" disabled><i class="glyphicon glyphicon-triangle-left"></i> Previous</button>
                                            </div>
                                        </div>
                                    </div>
                                    {{--<div id="step-4" class="tab-pane" role="tabpanel">--}}
                                        {{--<div class="row" style="padding-top : 20px;">--}}
                                            {{--<div class="col-md-1"></div>--}}
                                            {{--<div class="col-md-10">--}}
                                                {{--<div class="box box-primary">--}}
                                                    {{--<div class="box-header with-border">--}}
                                                        {{--<div class = "box-title">Credit References</div>--}}
                                                    {{--</div>--}}
                                                    {{--<div class="box-body">--}}
                                                        {{--<div class = "row" style="padding-top : 20px;">--}}
                                                            {{--<div class = "form-group col-md-12">--}}
                                                                {{--<h4>List of Credit Card/s: <button class="btn btn-xs btn-success" id="btnAddCredit"><i class="fa fa-plus"></i></button></h4>--}}
                                                                {{--<table class="display table-hover responsive"  style="width : 100%" id="credsDatatables" >--}}
                                                                    {{--<thead>--}}
                                                                    {{--<tr>--}}
                                                                        {{--<th>Credit Card</th>--}}
                                                                        {{--<th>Number</th>--}}
                                                                        {{--<th>Credit Limit/Status</th>--}}
                                                                        {{--<th>Expiry Date</th>--}}
                                                                        {{--<th></th>--}}
                                                                    {{--</tr>--}}
                                                                    {{--</thead>--}}
                                                                    {{--<tbody id="acct_credit_table" class="tableClearAll">--}}
                                                                    {{--</tbody>--}}
                                                                {{--</table>--}}
                                                            {{--</div>--}}
                                                        {{--</div>--}}
                                                    {{--</div>--}}
                                                {{--</div>--}}
                                            {{--</div>--}}
                                            {{--<div class="col-md-1"></div>--}}
                                        {{--</div>--}}
                                        {{--<div class="row" style="padding-top : 20px">--}}
                                            {{--<div class="col-md-12">--}}
                                                {{--<button class="btn btn-primary btn-md pull-right btnnextTab" style="margin-left : 10px">Next <i class="glyphicon glyphicon-triangle-right"></i> </button>--}}
                                                {{--<button class="btn btn-default btn-md pull-right btnpreviousTab" disabled><i class="glyphicon glyphicon-triangle-left"></i> Previous</button>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                    <div id="step-5" class="tab-pane" role="tabpanel">
                                        <div class="row" style="padding-top : 20px;">
                                            <div class="col-md-2"></div>
                                            <div class="col-md-8">
                                                <div class="box box-primary">
                                                    <div class="box-header with-border">
                                                        <div class = "box-title">Attachment/s<small style="color: orange;"> (Optional Field)</small></div>
                                                    </div>
                                                    <div class="box-body">
                                                        <div class = "row" >
                                                            <div class="col-md-12">
                                                                <div class="row" style="padding-top : 20px">
                                                                    <div class="form-group col-md-6">
                                                                        <label>Attachment 1(TOR)</label>
                                                                        <input class="acct_attached_file" type="file" id="attach1">
                                                                    </div>
                                                                    <div class="form-group col-md-6"><label>Attachment 2(Government ID)</label>
                                                                        <input class="acct_attached_file" type="file" id="attach2">
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="form-group col-md-6">
                                                                        <label>Attachment 3(COE)</label>
                                                                        <input class="acct_attached_file" type="file" id="attach3">
                                                                    </div>
                                                                    <div class="form-group col-md-6">
                                                                        <label>Attachment 4(Others)</label>
                                                                        <input class="acct_attached_file" type="file" id="attach4">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row" style="padding-top : 20px;">
                                            <div class="col-md-2"></div>
                                            <div class="col-md-8">
                                                <div class="box box-primary">
                                                    <div class="box-header with-border">
                                                        <div class = "box-title">Additional Attachment/s<small style="color: orange;"> (Optional Field)</small></div>
                                                    </div>
                                                    <div class="box-body">
                                                        <div class = "row" >
                                                            <div class="col-md-12">
                                                                <a class="btn btn-app" id="clicktoAddAdditionalAttach">
                                                                    <i class="fa fa-plus"></i> Add
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <div class="row" style="padding-top : 20px" id="divToFillAdditionalAttach">

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2"></div>
                                        </div>



                                        <div class="row" style="padding-top : 20px">
                                            <div class="col-md-12">
                                                <button class="btn btn-primary btn-md pull-right btnnextTab" style="margin-left : 10px">Next <i class="glyphicon glyphicon-triangle-right"></i> </button>
                                                <button class="btn btn-default btn-md pull-right btnpreviousTab" disabled><i class="glyphicon glyphicon-triangle-left"></i> Previous</button>
                                            </div>
                                        </div>
                                        <div class="row" style="padding-top : 40px">
                                            <div class="col-md-12">
                                                <button class="btn btn-success btn-md pull-right submitDataInfo" ><i class="fa fa-fw fa-eye"></i> Review Application</button>
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

        <div class="modal fade" id="modal-contact-us">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h3 class="modal-title" style = "text-align: left">Contact Us</h3>
                    </div>
                    <div class="modal-body">

                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-8">
                                    <div class="panel panel-default">
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label for="">Name <small style="color:red">(Required)</small></label>
                                                    <input type="text" class="form-control">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label for="">E-mail address <small style="color:red">(Required)</small></label>
                                                    <input type="text" class="form-control">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label for="">Subject</label>
                                                    <input type="text" class="form-control">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label for="">Message</label>
                                                    <textarea name="" id="" rows="5" class="form-control" style="resize: none"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel-footer" style="text-align: right">
                                            <button class="btn btn-success">Submit</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="box box-danger">
                                        <div class="box-title" style="text-align: center">
                                            <h3 class="box-title">Wanna Talk?</h3>
                                            <h4 class="box-title">Drop by and say hi...</h4>
                                        </div>
                                        <div class="bod-body" style="padding-top: 10px">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label for="">Manila Office:</label>
                                                    <p>Unit 2503 & 2504 25/F Summit One Tower, 530 Shaw Blvd,
                                                        Mandaluyong City, Philippines
                                                        HR/Admin: 781-3265  Finance:  239-5462</p>
                                                </div>
                                                <div class="col-md-12">
                                                    <label for="">Cebu Office:</label>
                                                    <p>Unit 7, Dolores Place, Acacia St.,
                                                        Brgy. Kamputhaw, Cebu City
                                                        (032) 266-0835 / (032) 412-0182</p>
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
            </div>
            <!-- /.modal-dialog -->
        </div>

        <div class="modal fade" id="modal-see-online-transaction">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <center><h4>Tracking/Application Information</h4></center>
                            </div>
                            <div class="panel-body" style="padding-top : 20px; "\>
                                <br>
                                <div class="row showThisFalseBoolTrack"  hidden>
                                    <div class="col-md-2"></div>
                                    <div class="col-md-8">
                                        <label for="">Tracking No.:</label>
                                        <input type="text" class="form-control" id="trackIdInfo" placeholder="Copy and paste the tracking number here......">
                                    </div>
                                    <div class="col-md-2"></div>
                                </div>

                                <div class="row showThisTrueBoolTrack" hidden>
                                    <div class="col-md-2"></div>
                                    <div class="col-md-8">
                                        <label for="">Status:</label> <span id="direct_status_view" style="font-weight: bold" class="classViewTransac"></span><br>
                                        <label for="">Applicant Name:</label> <span id="direct_name"  class="classViewTransac"></span><br>
                                        <label for="">Address:</label> <span id="direct_address"  class="classViewTransac"></span><br>
                                        <label for="">Municipality :</label> <span id="direct_muni"  class="classViewTransac"></span><br>
                                        <label for="">Province:</label> <span id="direct_province"  class="classViewTransac"></span><br>
                                        <label for="">Transaction ID:</label> <span id="tr_id_view" style="font-weight: bold"  class="classViewTransac"></span>
                                    </div>
                                    <div class="col-md-2"></div>
                                </div>
                                <div class="row" id="upload_files" hidden>
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="">Attachment 1</label>
                                                        <input type="file" class="ff_file" name="1">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="">Attachment 2</label>
                                                        <input type="file" class="ff_file" name="2">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="">Attachment 3</label>
                                                        <input type="file" class="ff_file" name="3">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="">Attachment 4</label>
                                                        <input type="file" class="ff_file" name="4">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-2"></div>
                                                <div class="col-md-8">
                                                    <button class="btn btn-flat btn-success btn-block" id="ff_upload">Upload File/s</button>
                                                </div>
                                                <div class="col-md-2"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>
                            <div class="panel-footer">
                                <div class="row">
                                    <div class="col-md-12">
                                 <span class="pull-right showThisTrueBoolTrack" hidden>
                                    <button class="btn btn-info" id="btnsearchNewTrack">Back</button>
                                </span>
                                        <span class="pull-right showThisFalseBoolTrack" hidden>
                                    <button class="btn btn-success" id="btnSearchTrackNow"><i class="fa fa-fw fa-send"></i>Search</button>
                                </span>
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


        <div class="modal fade" id="modal-loading-direct-endorse">
            <div class="modal-dialog" >
                <div class="modal-content">
                    <div class="modal-header" style="background-color: #d9edf7">
                        <h4 class="modal-title" >Information</h4>
                    </div>
                    <div class="modal-body">
                        <p style = "text-align: center; padding-top : 20px; font-size: large">Please wait while sending application
                            <span style = "padding-right : 5px;" ><img src= "{{asset('dist/img/loading.gif')}}" style = "width: 7%"></span>
                        </p>

                        <div class = "row" style = "padding-top : 15px;">
                            <div class = "col-md-2"></div>
                            <div class = "col-md-8">
                                <span id="ulPercentage_direct_en"></span>
                                <div id="progressbar_direct_en" hidden></div>
                            </div>
                            <div class = "col-md-2"></div>
                        </div>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>


        <div class="modal modal-success fade" id="modal-success-direct">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 style="text-align : center">Successfully Submitted Application</h3>
                    </div>
                    <div class="modal-body">

                        <div class="row" style="padding-top: 10px">
                            <div class="col-md-12">
                                <h4 style="text-align : center">TRACKING/APPLICATION NO:  <span id="trackDirectId"></span></h4>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-outline pull-right" id="btnCloseModalClear">Close</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>

        <div class="modal fade" id="modal-review-endorse-direct">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: #d9edf7">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h4 style="text-align: center" >Confirmation of details</h4>
                    </div>
                    <div class="modal-body" style=" height: 790px; overflow: scroll; padding : 5px;">

                        {{--<div class="row" style="padding-top: 20px;">--}}
                            {{--<div class="col-md-12">--}}
                                {{--<div class="box box-primary">--}}
                                    {{--<div class="box-header with-border">--}}
                                        {{--<h4 style="text-align: center">Personal Details</h4>--}}
                                    {{--</div>--}}
                                    {{--<div class="box-body">--}}
                                        {{--<div class = "row" style="padding-top: 20px;">--}}
                                            {{--<div class="col-md-4"></div>--}}
                                            {{--<div class="col-md-4">--}}
                                                {{--<form id="form2" runat="server">--}}
                                                    {{--<img id = "uploadedImgModalView" style = "width: 100% ; height: 100%; border:5px solid #000;" src = "{{asset('user_profile_pictures/default3.jpg')}}" />--}}
                                                {{--</form>--}}
                                            {{--</div>--}}
                                            {{--<div class="col-md-1"></div>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        <div class="row" style="padding-top : 20px;">
                            <div class="col-md-12">
                                <div class="box box-primary">
                                    <div class="box-body">
                                        <div class = "row" style="padding-top: 20px;">
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class = "col-md-12">
                                                        <label>Email Address:</label>
                                                        <p id="personal_email_view"></p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class = "col-md-12">
                                                        <label>Last Name:</label>
                                                        <p id="lastnameView"></p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class = "col-md-12">
                                                        <label>First Name:</label>
                                                        <p id="firstameView"></p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class = "col-md-12">
                                                        <label>Middle Name:</label>
                                                        <p id="midnameView"></p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class = "col-md-12">
                                                        <label>Suffix Name:</label>
                                                        <p id="suffixnameView"></p>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class = "col-md-12">
                                                        <label>Birthdate:</label>
                                                        <p id="birthdateView"></p>

                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class = "col-md-12">
                                                        <label>Age:</label>
                                                        <p id="ageView"></p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class = "col-md-12">
                                                        <label>Gender:</label>
                                                        <p id="genderView"></p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class = "col-md-12">
                                                        <label>Marital Status:</label>
                                                        <p id="maritalStatView"></p>
                                                    </div>
                                                </div>
                                                <div class="row showIdMarriedFemale" hidden>
                                                    <div class = "col-md-12">
                                                        <label>Maiden Last Name:</label>
                                                        <p id="maidenLastnameView"></p>
                                                    </div>
                                                </div>
                                                <div class="row showIdMarriedFemale" hidden>
                                                    <div class = "col-md-12">
                                                        <label>Maiden First Name:</label>
                                                        <p id="maidenFirstnameView"></p>
                                                    </div>
                                                </div>
                                                <div class="row showIdMarriedFemale" hidden>
                                                    <div class = "col-md-12">
                                                        <label>Maiden Middle Name:</label>
                                                        <p id="maidenMidnameView"></p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class = "col-md-12">
                                                        <label>Tel/CP no.:</label>
                                                        <p id="telCpView"></p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class = "col-md-12">
                                                        <label>SSS no:</label>
                                                        <p id="sssView"></p>
                                                    </div>
                                                </div>

                                                <div class="row">

                                                    <div class="box-header with-border">
                                                        <div class = "box-title">Present Adress</div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class = "col-md-12">
                                                        <label>Unit #, Bldg/Street, Subd/Brgy.:</label>
                                                        <p id="presentAddressView"></p>

                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class = "col-md-12">
                                                        <label>City/Municipality:</label>
                                                        <p id="presentCityView"></p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class = "col-md-12">
                                                        <label>Province:</label>
                                                        <p id="presentProvinceView"></p>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="box-header with-border">
                                                        <div class = "box-title">Permanent Address</div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class = "col-md-12">
                                                        <label>Unit #, Bldg/Street, Subd/Brgy.:</label>
                                                        <p id="permaAddressView"></p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class = "col-md-12">
                                                        <label>City/Municipality:</label>
                                                        <p id="permaCityView"></p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class = "col-md-12">
                                                        <label>Province:</label>
                                                        <p id="permaProvinceView"></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row showIfMarried" style="padding-top : 20px" hidden>
                            <div class="col-md-12">
                                <div class="box box-primary">
                                    <div class="box-header with-border">
                                        <h4 style="text-align: center">Marital History</h4>
                                    </div>
                                    <div class="box-body">
                                        <div class="row">
                                            <div class = "col-md-12">
                                                <label>Name of Spouse:</label>
                                                <p id="spouseNameView"></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class = "col-md-12">
                                                <label>Telephone/ Mobile No.:</label>
                                                <p id="spouseContactView"></p>
                                            </div>
                                        </div>

                                        {{--<div class = "row" style="padding-top : 10px;">--}}
                                            {{--<div class = "col-md-12">--}}
                                                {{--<h4>Children:</h4>--}}
                                                {{--<table class="display table-hover responsive"  style="width : 100%" id="chidrenTableView">--}}
                                                    {{--<thead>--}}
                                                    {{--<tr>--}}
                                                        {{--<th>Name</th>--}}
                                                        {{--<th>Date of Birth</th>--}}
                                                        {{--<th>Place of Birth</th>--}}
                                                    {{--</tr>--}}
                                                    {{--</thead>--}}
                                                {{--</table>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                    </div>


                                </div>
                            </div>
                        </div>
                        {{--<div class="row" style="padding-top : 20px;">--}}
                            {{--<div class="col-md-12">--}}
                                {{--<div class="box box-primary">--}}
                                    {{--<div class="box-header with-border">--}}
                                        {{--<h4  style="text-align: center">Family History and Information</h4>--}}
                                    {{--</div>--}}
                                    {{--<div class="box-body">--}}
                                        {{--<div class="row">--}}
                                            {{--<div class = "col-md-12">--}}
                                                {{--<label>Father's Full Name:</label>--}}
                                                {{--<p id="FatherFullView"></p>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                        {{--<div class="row">--}}
                                            {{--<div class = "col-md-12">--}}
                                                {{--<label>Father's Age:</label>--}}
                                                {{--<p id="FatherAgeView"></p>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                        {{--<div class="row">--}}
                                            {{--<div class = "col-md-12">--}}
                                                {{--<label>Father's Occupation:</label>--}}
                                                {{--<p id="FatherOccupation"></p>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                        {{--<div class="row">--}}
                                            {{--<div class = "col-md-12">--}}
                                                {{--<label>Father's Tel/CP no.:</label>--}}
                                                {{--<p id="FatherCPView"></p>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}

                                        {{--<div class="row">--}}
                                            {{--<div class = "col-md-12">--}}
                                                {{--<label>Mother's Full Name:</label>--}}
                                                {{--<p id="MotherFullView"></p>--}}

                                            {{--</div>--}}
                                        {{--</div>--}}
                                        {{--<div class="row">--}}
                                            {{--<div class = "col-md-12">--}}
                                                {{--<label>Mother's Age:</label>--}}
                                                {{--<p id="MotherAgelView"></p>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                        {{--<div class="row">--}}
                                            {{--<div class = "col-md-12">--}}
                                                {{--<label>Mother's Occupation:</label>--}}
                                                {{--<p id="MotherOccupation"></p>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                        {{--<div class="row">--}}
                                            {{--<div class = "col-md-12">--}}
                                                {{--<label>Mother's Tel/CP no.:</label>--}}
                                                {{--<p id="MotherCPView"></p>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}

                                        {{--<div class = "row" style="padding-top : 20px;">--}}
                                            {{--<div class = "col-md-12">--}}
                                                {{--<h4>Siblings: </h4>--}}
                                                {{--<table class="display table-hover responsive"  style="width : 100%" id="sibsTableView">--}}
                                                    {{--<thead>--}}
                                                    {{--<tr>--}}
                                                        {{--<th>Name</th>--}}
                                                        {{--<th>Age</th>--}}
                                                        {{--<th>Address</th>--}}
                                                        {{--<th>Occupation</th>--}}
                                                    {{--</tr>--}}
                                                    {{--</thead>--}}
                                                {{--</table>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        <div class="row" style="padding-top : 20px">
                            <div class="col-md-12">
                                <div class="box box-primary">
                                    <div class="box-header with-border">
                                        <h4  style="text-align: center">Educational Background</h4>
                                    </div>
                                    <div class="box-body">
                                        <div class="row">
                                            <div class="box-header with-border">
                                                <div class = "box-title">Secondary</div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class = "col-md-12">
                                                <label>Secondary (Name of School):</label>
                                                <p id="secondaryNameView"></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class = "col-md-12">
                                                <label>Location:</label>
                                                <p id="secondartLocationView"></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class = "col-md-12">
                                                <label>Inclusive Dates of Attendance:</label>
                                                <p id="secondaryInclusiveView"></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class = "col-md-12">
                                                <label>Year Graduated/Degree:</label>
                                                <p id="secondaryYearGradView"></p>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="box-header with-border">
                                                <div class = "box-title">Tertiary</div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class = "col-md-12">
                                                <label>College (Name of School):</label>
                                                <p id="collegeNameView"></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class = "col-md-12">
                                                <label>Location:</label>
                                                <p id="collegeLocationView"></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class = "col-md-12">
                                                <label>Inclusive Dates of Attendance:</label>
                                                <p id="collegeInclusiveView"></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class = "col-md-12">
                                                <label>Year Graduated/Degree:</label>
                                                <p id="collegeYearGradView"></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class = "col-md-12">
                                                <label>Other Schools Attended, Dates of Attendance, and Cerificate / Degree Earned:</label>
                                                <p id="otherSchoolsView"></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class = "col-md-12">
                                                <label>Civil Service Eligibility, if any, and other similar qualification/s required.
                                                    State rating & Professional Regulations Commision License No. if applicable:</label>

                                                <p id="civilServiceView"></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="padding-top : 20px" >
                            <div class="col-md-12">
                                <div class="box box-primary">
                                    <div class="box-header with-border">
                                        <h4 style="text-align : center;">Places of Residence since Birth</h4>
                                    </div>
                                    <div class="box-body">
                                        <div class = "row" style="padding-top : 20px;">
                                            <div class = "form-group col-md-12">
                                                <h4>Residence/s:</h4>
                                                    <table class="display table-hover responsive"  style="width : 100%" id="residenceTableView">
                                                        <thead>
                                                        <tr>
                                                            <th>Inclusive Dates</th>
                                                            <th>Complete Address</th>
                                                        </tr>
                                                        </thead>
                                                    </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="padding-top : 20px">
                            <div class="col-md-12">
                                <div class="box box-primary">
                                    <div class="box-header with-border">
                                        <h4 style="text-align : center">Work Experience</h4>
                                    </div>
                                    <div class="box-body">
                                        <div class = "row">
                                            <div class = "col-md-12">
                                                <h4>List of position/designation for the last 10 years to present:</h4>

                                                    <table class="display table-hover responsive"  style="width : 100%" id="workTableView">
                                                        <thead>
                                                        <tr>
                                                            <th>Date Started</th>
                                                            <th>Date Ended</th>
                                                            <th>Present/-</th>
                                                            <th>Employer Name</th>
                                                            <th>Designation</th>
                                                            <th>Employee No.</th>
                                                            <th>Employer Address </th>
                                                            <th>Employer Contact No</th>
                                                            <th>Name of Supervisor</th>
                                                            <th>Contact number of Supervisor</th>
                                                            <th >Reason for Leaving</th>
                                                        </tr>
                                                        </thead>
                                                    </table>

                                            </div>
                                        </div>
                                        <div class = "row">
                                            <div class = "col-md-12">
                                                <label for="">Have you ever been dismissed or forced to resign from a position?
                                                    If yes, explain:</label>

                                                <p><span id="forceResignView"></span>. <span id="forceResignReasonView"></span></p>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="padding-top : 20px;">
                            <div class="col-md-12">
                                <div class="box box-primary">
                                    <div class="box-header with-border">
                                        <div class = "box-title">Professional Reference </div>
                                    </div>
                                    <div class="box-body">
                                        <div class = "row" style="padding-top : 20px;">
                                            <div class = "form-group col-md-12">
                                                <h4>Professional References:</h4>
                                                    <table class="display table-hover responsive"  style="width : 100%" id="charTableView">
                                                        <thead>
                                                        <tr>
                                                            <th >Name</th>
                                                            <th >Position Employment</th>
                                                            <th>Company Address</th>
                                                            <th>Email Address <small style="color : orange">(optional)</small></th>
                                                            <th>Telephone No./Mobile No.</th>
                                                        </tr>
                                                        </thead>
                                                    </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="padding-top : 20px;">
                            <div class="col-md-12">
                                <div class="box box-primary">
                                    <div class="box-header with-border">
                                        <div class = "box-title">Membership in Civic/Religious Organization</div>
                                    </div>
                                    <div class="box-body">
                                        <div class = "row" style="padding-top : 20px;">
                                            <div class = "form-group col-md-12">
                                                <h4>List of organizations: </h4>
                                                    <table class="display table-hover responsive"  style="width : 100%" id="orgTableView">
                                                        <thead>
                                                        <tr>
                                                            <th>Name of Organization</th>
                                                            <th>Date of Membership</th>
                                                            <th>Position</th>
                                                        </tr>
                                                        </thead>
                                                    </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="padding-top : 20px;">
                            <div class="col-md-12">
                                <div class="box box-primary">
                                    <div class="box-header with-border">
                                        <div class = "box-title">Trainings Attended</div>
                                    </div>
                                    <div class="box-body">
                                        <div class = "row" style="padding-top : 20px;">
                                            <div class = "form-group col-md-12">
                                                <h4>List of trainings:</h4>
                                                    <table class="display table-hover responsive"  style="width : 100%" id="trainTableView">
                                                        <thead>
                                                        <tr>
                                                            <th>Nature/Title</th>
                                                            <th>Conducted by</th>
                                                            <th>Year - Taken</th>
                                                        </tr>
                                                        </thead>
                                                    </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{--<div class="row" style="padding-top : 20px;">--}}
                            {{--<div class="col-md-12">--}}
                                {{--<div class="box box-primary">--}}
                                    {{--<div class="box-header with-border">--}}
                                        {{--<div class = "box-title">Credit References</div>--}}
                                    {{--</div>--}}
                                    {{--<div class="box-body">--}}
                                        {{--<div class = "row" style="padding-top : 20px;">--}}
                                            {{--<div class = "form-group col-md-12">--}}
                                                {{--<h4>List of Credit Card/s:</h4>--}}
                                                    {{--<table class="display table-hover responsive"  style="width : 100%" id="credsTableView">--}}
                                                        {{--<thead>--}}
                                                        {{--<tr>--}}
                                                            {{--<th>Credit Card</th>--}}
                                                            {{--<th>Number</th>--}}
                                                            {{--<th>Credit Limit/Status</th>--}}
                                                            {{--<th>Expiry Date</th>--}}
                                                        {{--</tr>--}}
                                                        {{--</thead>--}}
                                                    {{--</table>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        <div class="row" style="padding-top : 20px;">
                            <div class="col-md-12">
                                <div class="box box-primary">
                                    <div class="box-header with-border">
                                        <div class = "box-title">Please select location to send your application</div>
                                    </div>
                                    <div class="box-body">
                                        <div class = "row" style="padding-top : 20px;">
                                            <div class = "form-group col-md-8">
                                                <label for="">Select location <small style="color : red">(*Required Field)</small></label>
                                                <select class="form-control toDash" id="locationToSendApply">

                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-success btn-md pull-right submitAllConfirmed"><i class="glyphicon glyphicon-send"></i> Submit Application</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>

        @if(Auth::user()->id == '1248')
        <div class="modal fade" id="modal-click-here" data-backdrop="static">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title"><center>QUALFON TEST Agreement</center></h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="box box-danger">
                                        <div class="box-body">
                                            <div class="row">
                                                <h4><center>
                                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec tellus libero, convallis eu scelerisque sit amet, fermentum et magna. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Nullam sollicitudin, odio in fermentum volutpat, quam dui sodales leo, vel varius nulla felis quis nibh. Ut sem tellus, tristique dignissim arcu ac, tristique lacinia ex. Pellentesque libero elit, ultricies non mattis eget, faucibus nec sapien. Integer dignissim congue consequat. Suspendisse malesuada dui ut ipsum pretium, in molestie tellus venenatis. Nullam nec orci id augue suscipit tincidunt quis nec augue. Fusce ultricies vestibulum ipsum vitae semper. Aliquam et orci posuere, ullamcorper nibh pretium, feugiat ante. Duis dolor felis, eleifend vel eleifend ac, tincidunt id odio. Integer malesuada mauris id lorem dictum molestie. Mauris purus magna, scelerisque sed sem id, scelerisque hendrerit sapien. Sed posuere dapibus nulla eu vulputate. Proin eget sem in felis venenatis laoreet id sit amet leo. Mauris vel dui commodo diam aliquam mattis at eget tellus.

                                                        Cras vel mattis nisi. In hac habitasse platea dictumst. Vestibulum nec lorem non lorem varius posuere. Nulla in pretium ipsum. Integer ut viverra enim. Mauris aliquet molestie felis. Phasellus accumsan tincidunt massa, a fermentum lectus hendrerit vitae. Duis finibus libero dui, at molestie lacus porttitor et. Sed dui mi, pellentesque sed diam sed, sodales hendrerit dui. In hac habitasse platea dictumst.

                                                        Phasellus tincidunt nulla non bibendum sollicitudin. Donec id varius ante. Nunc in arcu ut lacus volutpat mollis. Donec eget ultricies nisi, non tempor ligula. Praesent consequat diam a neque volutpat, ut tincidunt mi cursus. Praesent gravida diam nec ullamcorper lobortis. Fusce pharetra dolor massa. Morbi nunc nisi, finibus eget gravida quis, pretium sed felis. Nam efficitur, libero non consectetur condimentum, odio ipsum iaculis nibh, ac maximus turpis leo eu eros.

                                                        Donec eget lacus pellentesque, ultrices eros sit amet, viverra leo. Donec sed tortor at tellus pretium ornare eu ac sem. Vestibulum iaculis, ligula et ultricies gravida, libero augue porta nibh, in hendrerit odio tortor ut nunc. Mauris justo neque, maximus non ligula et, volutpat tristique enim. Ut eu gravida tortor, ac lobortis quam. Phasellus ornare eget metus scelerisque ornare. Morbi nec elementum lacus, ut lobortis orci.

                                                        Cras tempor consequat placerat. Phasellus lobortis aliquam porttitor. Sed tristique sem sem, eu venenatis enim consequat eu. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam vel eros ex. Curabitur et feugiat est, eu tincidunt purus. Vivamus viverra blandit suscipit. Suspendisse sit amet auctor lorem. Ut ac malesuada tellus. Proin nulla dolor, malesuada nec massa quis, ullamcorper vestibulum lorem. Duis commodo mauris nec posuere venenatis.</center>
                                                </h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <small><center><input type="checkbox" id="check_agreement"> <label for="check_agreement" style="font-weight: 400">I agree to the terms and conditions.</label></center></small>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-success" disabled id="btn-agree">Continue</button>
                        </div>
                    </div>
                </div>
            </div>
        @elseif(Auth::user()->id == '1204')
        <div class="modal fade" id="modal-click-here" data-backdrop="static">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title"><center>  <img src="{{ asset('dist/img/sitel_logo.png')}}" style="width: 25%; height: 25%"> </center></h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12"  style="overflow: auto; height: 800px">
                                    <div class="box box-danger">
                                        <div class="box-body">
                                            <div class="row">
                                                <p>

                                                <center>
                                                    <h2>DATA PROTECTION NOTICE</h2>
                                                </center>
                                                <h3><b>I.	INTRODUCTION</b></h3>
                                                <h4>
                                                    Sitel Philippines Corporation (“Sitel”), an affiliate of the Sitel group of companies (the “Sitel Group”), located at [insert address] has prepared this Data Protection Notice (the “Notice”) to outline its practices regarding the collection, use, storage, transfer and other processing of individually identifiable information about you (“Individual Personal Data”)  and sensitive personal information (“Sensitive Personal Data”) during the course of the recruiting process and while you perform duties on behalf of Sitel (whether directly or through a third party vendor), as well as after you cease performing duties for Sitel.  Sitel also may provide you additional notices from time to time, related to data protection or privacy, such as a computer use terms, etc.
                                                </h4>

                                                <h3><b>II.	DATA COLLECTION AND PURPOSES OF USE</b></h3>
                                                <h4>
                                                    Good employment practices and the effective running of our business require Sitel to collect, use, store, transfer and otherwise process certain Individual Personal Data and Sensitive Personal Data. Individual Personal Data and Sensitive Personal Data will be referred to collectively as “Personal Data”.
                                                </h4>

                                                <h3><b>A.	Individual Personal Data Collection</b></h3>

                                                <h4>
                                                    Sitel collects Individual Personal Data that is directly relevant to its business, required to meet its legal obligations, or otherwise permissible to collect under local laws. In particular, Sitel may collect the following categories of Individual Personal Data:
                                                </h4>

                                                <h4>
                                                    (1) Personal and family information, as applicable, and including but not limited to: name (s); contact information, information related to birth, citizenship, government issued identification cards/numbers, financial and banking information and dependents.
                                                    <br>
                                                    (2) Work related information, as applicable, and including but not limited to: results of recruiting and job-related assessments, job related information relating to your position and the organization, benefits, compensation and other pay related information, attendance, work performance, performance assessments, personal development plans, disciplinary records, training, background related information, information systems and electronic data from company systems, video and audio record/monitor, and contact information.
                                                </h4>

                                                <h3><b>B.	Sensitive Personal Data </b></h3>

                                                <h4>
                                                    Sitel may collect and process certain special or other significant categories of Sensitive Personal Data about you such as health condition (including drug screening and pre-screening) and union membership for purposes of complying with government reporting requirements and other legal obligations of Sitel and the Sitel Group, as applicable.  Sensitive Personal Data will be used for the purposes described in this Notice and processed, disclosed, and transferred in the same manner as described in this Notice.
                                                </h4>

                                                <h3><b>C.	Personal Data Use and Processing </b></h3>

                                                <h4>
                                                    Sitel may use the Personal Data listed above for specific purposes, as applicable, and including but not limited to:
                                                    <br><br>
                                                    (1) Administering and managing your potential relationship with Sitel; (2) general administration; (3) human resources information systems and application support and development; (4) information technology and information security support (including firewall monitoring, anti-spam and virus protection); (5) management of internal business operations (including monitoring compliance with Sitel policies and procedures); (6) preparation, management, and use of an internal business telephone/e-mail directory; (7) payroll and compensation administration and processing (including compensation decisions); (8) tracking financial and compensation metrics; (9) compensation management; (10) budgeting; (11) benefits and insurance administration and management; (12) fostering career planning and growth; (13) complying with applicable government reporting and other local law requirements  and other legal obligations; (14) defending, preparing for, participating in and responding to potential legal claims, investigations and regulatory inquiries (all as allowed by applicable law); (15) disciplinary actions/investigations (as allowed by applicable law); (16) training, advice and counseling purposes; (17) performance and productivity reviews/assessments and general performance management; (18) facilitation of improved recruiting activities, talent management and succession planning; and (19) authentication/identification (e.g., intranet); (20) client reporting.
                                                </h4>

                                                <h3><b>III.	MONITOR, VIDEO, SURVEILLANCE AND RECORD</b></h3>

                                                <h4>
                                                    Sitel reserves the right to monitor, video, conduct surveillance and record in any way it deems fit the workplace premises, including workstations, desks, cubicles and other locations within the company premises and at home (as applicable) that are used to conduct the Company’s business (“Monitoring Activities”).
                                                </h4>
                                                <h4>
                                                    There shall have no expectation of privacy in the workplace and particularly in relation to the areas covered by the Monitoring Activities.
                                                </h4>
                                                <h4>
                                                    The surveillance video of the Monitoring Activities can be viewed and stored by the Company and its clients.
                                                </h4>
                                                <h4>
                                                    Sitel may use, process, analyze and transfer information gathered during the Monitoring Activities, which includes my personal information, whether in real time or after recording, for the purpose of managing the business operations, business needs, client needs and human resource needs of the Company.
                                                </h4>
                                                <h4>
                                                    Sitel may share my personal information gathered from the Monitoring Activities within the Company, other Company affiliates, government authorities, service providers contracted by the Company to provide certain human resource support activities, and to Company clients.
                                                </h4>

                                                <h3><b>IV.	DISCLOSURES OF PERSONAL DATA AND INTERNATIONAL TRANSFER</b></h3>

                                                <h4>
                                                    Sitel may transfer the Personal Data to any of the affiliates of the Sitel Group and/or its parent company, as well as third parties acting on their behalf or under its assignment, which may derive in international transfer of Personal Data, since such affiliates or third parties may be located in the EU, USA and Canada, India and/or the Philippine (and such other countries as I may be notified from time to time in writing).
                                                </h4>
                                                <h4>
                                                    The disclosure of Personal Data or international transfer will be carried out as part of normal business operations, which includes but is not limited to human resources and payroll-related tasks (e.g., banks, insurance companies and other employee benefit providers). Sitel may also disclose Personal Data to third party service providers in connection with information technology support (e.g., software maintenance and data hosting) and human resources support (e.g., benefits and human capital management consulting), and for background checking purposes.
                                                </h4>
                                                <h4>
                                                    For purposes of these disclosures and/or international transfer of Personal Data, Sitel (i) exercises appropriate due diligence in the selection of such third party service providers, and (ii) requires via appropriate contractual measures that such third party service providers maintain adequate technical and organizational security measures to safeguard the Personal Data, and process the Personal Data only as instructed by Sitel and for no other purposes.
                                                </h4>
                                                <h4>
                                                    Sitel may also disclose Personal Data to governmental agencies and regulators (e.g., tax authorities), social organizations (e.g., the social security institute), human resources benefits providers (e.g., health insurers), external advisors (e.g., lawyers, accountants, and auditors), courts and other tribunals, and government authorities, to the extent required or permitted by applicable legal obligations.
                                                </h4>

                                                <h3><b>V.	DATA SECURITY AND DATA INTEGRITY</b></h3>

                                                <h4>
                                                    Sitel takes its obligations to protect my information seriously and will take reasonable steps to protect my information. For such purposes, Sitel maintains appropriate technical and organizational measures to protect against unauthorized or unlawful processing of Personal Data and/or against accidental loss, alteration, disclosure or access, or accidental or unlawful destruction of or damage to Personal Data.
                                                </h4>


                                                <h3><b>VI.	ACCESS TO PERSONAL DATA </b></h3>

                                                <h4>
                                                    You have the right to access, review, update, correct and request the deletion of your own Personal Data, as applicable according with the applicable laws and regulations.  Also, you are responsible for informing Sitel if there are any changes or inaccuracies to your Personal Data.  You should transmit any requests for access or updates to, or corrections or deletions of your own Personal Data to Sitel as specified below in Section VI.
                                                </h4>

                                                <h3><b>VII.	DATA STORAGE </b></h3>

                                                <h4>
                                                    The data will be stored in Sitel owned and third party systems and access to it is encryption protected.
                                                </h4>

                                                <h3><b>VIII.	DATA RETENTION </b></h3>

                                                <h4>
                                                    Personal information shall be retained for as long as it legally needed or as long Sitel has a legitimate need to retain it.
                                                </h4>

                                                <h3><b>IX.	DISPOSAL </b></h3>

                                                <h4>
                                                    When personal data is no longer required or needed for business purposes, it shall be disposed or discarded in a secured manner that would prevent further processing, unauthorized access, or disclosure to any other party or the public, or prejudice the interest of the Sitel’s data subjects.
                                                </h4>

                                                <h3><b>X.	QUESTIONS ABOUT PROCESSING OF PERSONAL DATA </b></h3>

                                                <h4>
                                                    If you have any questions about this Notice or wish to (i) access, review, correct or request the deletion of your Personal Data or learn more about who has access to such information, (ii) make any other type of request, or (iii) report a concern related to Personal Data, you should your local Human Resources Manager.
                                                </h4>

                                                <h3><b>XI.	CHANGES TO THIS NOTICE </b></h3>

                                                <h4>
                                                    Should Sitel substantially modify the manner in which it collects or uses Personal Data, the type of Personal Data it collects or any other aspect of this Notice, it will notify you as soon as possible by reissuing a revised Notice, available through your Human Resources Manager and will be sent through email.
                                                </h4>

                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <h4><b>ACKNOWLEDGEMENT AND EXPRESS CONSENT TO THE NOTICE</b></h4>
                                    <h4>
                                        I have read this Notice and I understand its contents and acknowledge the application of its terms, including those regarding the collection, processing and use of my Personal Data, including Sensitive Personal Data, by Sitel, and the international transfer of my Personal Data to jurisdictions where data protection laws may not provide an equivalent level of protection.
                                    </h4>
                                    <center><input type="checkbox" id="check_agreement"> <label for="check_agreement" style="font-weight: 400"> <h4>I agree to the terms and conditions.</h4> </label></center>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-success" disabled id="btn-agree">Continue</button>
                        </div>
                    </div>
                </div>
        </div>
        @else
        <div class="modal fade" id="modal-click-here" data-backdrop="static">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title"><center>Agreement</center></h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="box box-danger">
                                        <div class="box-body">
                                            <div class="row">
                                                <h4><center>
                                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec tellus libero, convallis eu scelerisque sit amet, fermentum et magna. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Nullam sollicitudin, odio in fermentum volutpat, quam dui sodales leo, vel varius nulla felis quis nibh. Ut sem tellus, tristique dignissim arcu ac, tristique lacinia ex. Pellentesque libero elit, ultricies non mattis eget, faucibus nec sapien. Integer dignissim congue consequat. Suspendisse malesuada dui ut ipsum pretium, in molestie tellus venenatis. Nullam nec orci id augue suscipit tincidunt quis nec augue. Fusce ultricies vestibulum ipsum vitae semper. Aliquam et orci posuere, ullamcorper nibh pretium, feugiat ante. Duis dolor felis, eleifend vel eleifend ac, tincidunt id odio. Integer malesuada mauris id lorem dictum molestie. Mauris purus magna, scelerisque sed sem id, scelerisque hendrerit sapien. Sed posuere dapibus nulla eu vulputate. Proin eget sem in felis venenatis laoreet id sit amet leo. Mauris vel dui commodo diam aliquam mattis at eget tellus.

                                                        Cras vel mattis nisi. In hac habitasse platea dictumst. Vestibulum nec lorem non lorem varius posuere. Nulla in pretium ipsum. Integer ut viverra enim. Mauris aliquet molestie felis. Phasellus accumsan tincidunt massa, a fermentum lectus hendrerit vitae. Duis finibus libero dui, at molestie lacus porttitor et. Sed dui mi, pellentesque sed diam sed, sodales hendrerit dui. In hac habitasse platea dictumst.

                                                        Phasellus tincidunt nulla non bibendum sollicitudin. Donec id varius ante. Nunc in arcu ut lacus volutpat mollis. Donec eget ultricies nisi, non tempor ligula. Praesent consequat diam a neque volutpat, ut tincidunt mi cursus. Praesent gravida diam nec ullamcorper lobortis. Fusce pharetra dolor massa. Morbi nunc nisi, finibus eget gravida quis, pretium sed felis. Nam efficitur, libero non consectetur condimentum, odio ipsum iaculis nibh, ac maximus turpis leo eu eros.

                                                        Donec eget lacus pellentesque, ultrices eros sit amet, viverra leo. Donec sed tortor at tellus pretium ornare eu ac sem. Vestibulum iaculis, ligula et ultricies gravida, libero augue porta nibh, in hendrerit odio tortor ut nunc. Mauris justo neque, maximus non ligula et, volutpat tristique enim. Ut eu gravida tortor, ac lobortis quam. Phasellus ornare eget metus scelerisque ornare. Morbi nec elementum lacus, ut lobortis orci.

                                                        Cras tempor consequat placerat. Phasellus lobortis aliquam porttitor. Sed tristique sem sem, eu venenatis enim consequat eu. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam vel eros ex. Curabitur et feugiat est, eu tincidunt purus. Vivamus viverra blandit suscipit. Suspendisse sit amet auctor lorem. Ut ac malesuada tellus. Proin nulla dolor, malesuada nec massa quis, ullamcorper vestibulum lorem. Duis commodo mauris nec posuere venenatis.</center>
                                                </h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <small><center><input type="checkbox" id="check_agreement"> <label for="check_agreement" style="font-weight: 400">I agree to the terms and conditions.</label></center></small>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-success" disabled id="btn-agree">Continue</button>
                        </div>
                    </div>
                </div>
            </div>
        @endif

    </body>

    <footer>
        <script src="https://code.jquery.com/jquery-1.9.1.js"></script>
        <script src="https://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
        <script src="{{ asset('bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('plugins/jquery-smartwizard-master/dist/js/jquery.smartWizard.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('jscript/direct-encode-applicant.js?'.$javs) }}"></script>
        <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
        <script src="{{ asset('bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
        <script src="https://cdn.datatables.net/responsive/2.2.1/js/dataTables.responsive.min.js"></script>
        <script src="https://cdn.datatables.net/select/1.2.5/js/dataTables.select.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.colVis.min.js"></script>
        <script src="https://cdn.datatables.net/rowreorder/1.2.0/js/dataTables.rowReorder.min.js"></script>

    </footer>

</html>





