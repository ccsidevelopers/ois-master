<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Background Investigation Endorsement
        </h1>
    </section>

    <section class="content">

        <div class="row">
            <div class= "box-body">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a id="tabSample" href="#tab_a" data-toggle="tab"
                                              class = "human_resources_employee_a_class">New Endorsement</a></li>
                    </ul>
                    <div class = "tab-content">
                        <div class="nav-tabs-custom">
                            @if (Auth::user()->authrequest  == 'direct_enc')
                                <ul class="nav nav-tabs">
                                    <li class="active"><a href="#tab_tab_1" id="encode_endosement_tab" data-toggle="tab" class = "client_bi_endorsement_class">EncodeEndorsement</a></li>
                                    <li class=""><a href="#tab_tab_2" id="upload_endorsement_tab" data-toggle="tab" class = "client_bi_endorsement_class">Upload Endorsement(Bulk Endorsement)</a></li>
                                    <li class=""><a href="#tab_tab_3" id="upload_endorsement_tab" data-toggle="tab" class = "client_bi_endorsement_class">PendingApplicants BI Form</a></li>
                                </ul>
                            @else
                                <ul class="nav nav-tabs">
                                    <li class="active"><a href="#tab_tab_1" id="encode_endosement_tab" data-toggle="tab" class = "client_bi_endorsement_class">Encode Endorsement</a></li>
                                    <li class=""><a href="#tab_tab_2" id="upload_endorsement_tab" data-toggle="tab" class = "client_bi_endorsement_class">Upload Endorsement(Bulk Endorsement)</a></li>
                                </ul>
                            @endif
                            <div class = "tab-content">
                                <div class="tab-pane active" id="tab_tab_1">
                                    <span id="cc_span_bi" hidden>
                                        <input type="text" id="bi_account" hidden>
                                        <div class="row">
                                            <div class="col-md-9">
                                                <div class="row">
                                                    {{--@if (Auth::user()->client_check  == 'tat_selector' && $account_name_test == 'Sitel Manila')--}}
                                                    {{--<div class="col-md-3">--}}
                                                        {{--<div class="box box-danger">--}}
                                                            {{--<div class="box-header with-border">--}}
                                                                {{--<div class = "box-title">Select Site</div><small style="color: red;"> (Required Field)</small>--}}
                                                            {{--</div>--}}
                                                            {{--<div class="box-body">--}}
                                                                {{--<div class="form-group">--}}
                                                                    {{--<div class="row">--}}
                                                                        {{--<div class ="col-md-12">--}}
                                                                            {{--<select name="" id="" class="form-control">--}}
                                                                                {{--<option value="">-</option>--}}
                                                                                {{--<option value="Eton">Eton</option>--}}
                                                                                {{--<option value="Pioneer">Pioneer</option>--}}
                                                                                {{--<option value="OJV">OJV</option>--}}
                                                                                {{--<option value="Technopoint">Technopoint</option>--}}
                                                                            {{--</select>--}}
                                                                        {{--</div>--}}
                                                                    {{--</div>--}}
                                                                {{--</div>--}}
                                                            {{--</div>--}}
                                                        {{--</div>--}}
                                                    {{--</div>--}}
                                                    {{--<div class="col-md-3">--}}
                                                        {{--<div class="box box-danger">--}}
                                                            {{--<div class="box-header with-border">--}}
                                                                {{--<div class = "box-title">Account/Project</div><small style="color: orange;"> (Optional Field)</small>--}}
                                                            {{--</div>--}}
                                                            {{--<div class="box-body">--}}
                                                                {{--<div class="form-group">--}}
                                                                    {{--<div class="row">--}}
                                                                        {{--<div class ="col-md-12">--}}
                                                                            {{--<input type="text" class = "form-control" id = "project_name">--}}
                                                                        {{--</div>--}}
                                                                    {{--</div>--}}
                                                                {{--</div>--}}
                                                            {{--</div>--}}
                                                        {{--</div>--}}
                                                    {{--</div>--}}
                                                    {{--@else--}}
                                                    <div class="col-md-4">
                                                        <div class="box box-danger">
                                                            <div class="box-header with-border">
                                                                <div class = "box-title">Account/Project</div><small style="color: orange;"> (Optional Field)</small>
                                                            </div>
                                                            <div class="box-body">
                                                                <div class="form-group">
                                                                    <div class="row">
                                                                        <div class ="col-md-12">
                                                                            <input type="text" class = "form-control" id = "project_name">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    {{--@endif--}}
                                                    @if (Auth::user()->client_check  == 'tat_selector')
                                                    <div class="col-md-2" hidden>
                                                        <div class="box box-danger">
                                                            <div class="box-header with-border">
                                                                <div class = "box-title">LOB</div><small style="color: orange;"> (Optional Field)</small>
                                                            </div>
                                                            <div class="box-body">
                                                                <div class="form-group">
                                                                    <div class="row">
                                                                        <div class ="col-md-12">
                                                                            <select class="form-control" id="bi_account_lob">
                                                                                <option value =
                                                                                        "-">-</option>
                                                                                <option value =
                                                                                        "Yes">Yes</option>
                                                                                <option value =
                                                                                        "No">No</option>
                                                                                <option value =
                                                                                        "N/A">N/A</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-5">
                                                        <div class="box box-danger">
                                                            <div class="box-header with-border">
                                                                <div class = "box-title">Select Package</div><small style="color: red;"> (Required Field)</small>
                                                            </div>
                                                            <div class="box-body">
                                                                <div class="form-group">
                                                                    <div class="row">
                                                                        <div class ="col-md-12">
                                                                            <span id="bi_package"></span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                        <div class="col-md-3">
                                                        <div class="box box-danger">
                                                            <div class="box-header with-border">
                                                                <div class = "box-title">TAT Selection</div><small style="color: red;"> (Required Field)</small>
                                                            </div>
                                                            <div class="box-body">
                                                                <div class="form-group">
                                                                    <div class="row">
                                                                        <div class ="col-md-12">
                                                                            <select class="form-control" id="bi_account_tat">
                                                                                <option value =
                                                                                        "-">-</option>
                                                                                <option value =
                                                                                        "Regular 7">Regular = 7 days</option>
                                                                                <option value =
                                                                                        "Regular 5">Regular = 5 days</option>
                                                                                <option value =
                                                                                        "Expedite">Expedite = 3 days</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @else
                                                        <div class="col-md-2">
                                                        <div class="box box-danger">
                                                            <div class="box-header with-border">
                                                                <div class = "box-title">LOB</div><small style="color: orange;"> (Optional Field)</small>
                                                            </div>
                                                            <div class="box-body">
                                                                <div class="form-group">
                                                                    <div class="row">
                                                                        <div class ="col-md-12">
                                                                            <select class="form-control" id="bi_account_lob">
                                                                                <option value =
                                                                                        "-">-</option>
                                                                                <option value =
                                                                                        "Yes">Yes</option>
                                                                                <option value =
                                                                                        "No">No</option>
                                                                                <option value =
                                                                                        "N/A">N/A</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                        <div class="col-md-6">
                                                        <div class="box box-danger">
                                                            <div class="box-header with-border">
                                                                <div class = "box-title">Select Package</div><small style="color: red;"> (Required Field)</small>
                                                            </div>
                                                            <div class="box-body">
                                                                <div class="form-group">
                                                                    <div class="row">
                                                                        <div class ="col-md-12">
                                                                            <span id="bi_package"></span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endif
                                                    <div class="col-md-12">
                                                        <div class="box box-danger">
                                                            <div class="box-header with-border">
                                                                <div class = "box-title">Personal Information</div>
                                                            </div>
                                                            <div class="box-body">
                                                                <div class="form-group">
                                                                    <div class = "row">
                                                                        <div class = "form-group col-md-6">
                                                                            <label>Last Name:</label><small style="color: red;"> (Required Field)</small>
                                                                            <input type="text"
                                                                                   class = "form-control" id = "acct_last">
                                                                        </div>
                                                                        <div class = "form-group col-md-2">
                                                                            <label>Suffix Name:</label><small style="color: orange;"> (Optional Field)</small>
                                                                            <input type="text"
                                                                                   class = "form-control" id = "acct_suffix">
                                                                        </div>
                                                                        <div class="form-group col-md-2">
                                                                            <label>Birth Day:</label><small style="color: red;"> (Required field)</small>
                                                                            <select class="form-control" id="acct_birthdate_day">
                                                                                <option value ="-">-</option>
                                                                                <option value ="01">01</option>
                                                                                <option value ="02">02</option>
                                                                                <option value ="03">03</option>
                                                                                <option value ="04">04</option>
                                                                                <option value ="05">05</option>
                                                                                <option value ="06">06</option>
                                                                                <option value ="07">07</option>
                                                                                <option value ="08">08</option>
                                                                                <option value ="09">09</option>
                                                                                <option value ="10">10</option>
                                                                                <option value ="11">11</option>
                                                                                <option value ="12">12</option>
                                                                                <option value ="13">13</option>
                                                                                <option value ="14">14</option>
                                                                                <option value ="15">15</option>
                                                                                <option value ="16">16</option>
                                                                                <option value ="17">17</option>
                                                                                <option value ="18">18</option>
                                                                                <option value ="19">19</option>
                                                                                <option value ="20">20</option>
                                                                                <option value ="21">21</option>
                                                                                <option value ="22">22</option>
                                                                                <option value ="23">23</option>
                                                                                <option value ="24">24</option>
                                                                                <option value ="25">25</option>
                                                                                <option value ="26">26</option>
                                                                                <option value ="27">27</option>
                                                                                <option value ="28">28</option>
                                                                                <option value ="29">29</option>
                                                                                <option value ="30">30</option>
                                                                                <option value ="31">31</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="form-group col-md-2">
                                                                            <label>Age:</label><small style="color: red;"> (Required Field/Auto)</small>
                                                                            <input type="number"
                                                                                   disabled class="form-control" id="acct_birthdate_age">
                                                                        </div>
                                                                    </div>
                                                                    <div class = "row">
                                                                        <div class = "form-group col-md-6">
                                                                            <label>First Name:</label><small style="color: red;"> (Required Field)</small>
                                                                            <input type="text"
                                                                                   class = "form-control" id = "acct_first">
                                                                        </div>
                                                                        <div class = "form-group col-md-2">
                                                                            <label>Gender:</label><small style="color: orange;"> (Optional Field)</small>
                                                                            <select
                                                                                    class="acct_gender form-control" name="" id="acct_gender">
                                                                                <option value =
                                                                                        "-">-</option>
                                                                                <option value =
                                                                                        "Male">Male</option>
                                                                                <option value =
                                                                                        "Female">Female</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="form-group col-md-2">
                                                                            <label>Birth Month:</label><small style="color: red;"> (Required field)</small>
                                                                            <select
                                                                                    class="form-control" id="acct_birthdate_month">
                                                                                <option value ="-">-</option>
                                                                                <option value ="01">January</option>
                                                                                <option value ="02">February</option>
                                                                                <option value ="03">March</option>
                                                                                <option value ="04">April</option>
                                                                                <option value ="05">May</option>
                                                                                <option value ="06">June</option>
                                                                                <option value ="07">July</option>
                                                                                <option value ="08">August</option>
                                                                                <option value ="09">September</option>
                                                                                <option value ="10">October</option>
                                                                                <option value ="11">November</option>
                                                                                <option value ="12">December</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="form-group col-md-2">
                                                                            <label>Citizenship:</label><small style="color: orange;"> (Optional Field)</small>
                                                                            <input type="text"
                                                                                   class="form-control" id="acct_citizenship">
                                                                        </div>
                                                                    </div>
                                                                    <div class = "row">
                                                                        <div class = "form-group col-md-6">
                                                                            <label>Middle Name:</label><small style="color: orange;"> (Optional Field)</small>
                                                                            <input type="text"
                                                                                   class = "form-control" id = "acct_middle">
                                                                        </div>
                                                                        <div class = "form-group col-md-2">
                                                                            <label>Marital Status:</label><small style="color: orange;"> (Optional Field)</small>
                                                                            <select class="acct_marital_status form-control" name="" id="acct_marital_status">
                                                                                <option value ="-">-</option>
                                                                                <option value ="Single">Single</option>
                                                                                <option value ="Married">Married</option>
                                                                                <option value ="Widowed">Widowed</option>
                                                                                <option value ="Divorced">Divorced</option>
                                                                                <option value ="Separated">Separated</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="form-group col-md-2">
                                                                            <label>Birth Year:</label><small style="color: red;"> (Required field)</small>
                                                                            <select
                                                                                    class="form-control" id="acct_birthdate_year">
                                                                            </select>
                                                                        </div>
                                                                        {{--<div class="form-
group col-md-2">--}}
                                                                        {{--
<label>Nationality:</label>--}}
                                                                        {{--<input type="text"
class="form-control" id="acct_nationality">--}}
                                                                        {{--</div>--}}
                                                                    </div>
                                                                    <div hidden
                                                                         id="if_married_check" class="box">
                                                                        <div class="box-header with-border">IF MARRIED - Maiden Information: (This Row will only show if "Married" isselected)</div>
                                                                        <div class="box-body">
                                                                            <div class="row">
                                                                                <div class="form-group col-md-4">
                                                                                    <label>Maiden Last Name:</label><small style="color: orange;"> (Optional Field)</small>
                                                                                    <input type="text" class = "form-control" id = "acct_maiden_last_name">
                                                                                </div>
                                                                                <div class="form-group col-md-4">
                                                                                    <label>Maiden First Name:</label><small style="color: orange;"> (Optional Field)</small>
                                                                                    <input type="text" class = "form-control" id = "acct_maiden_first_name">
                                                                                </div>
                                                                                <div class="form-group col-md-4">
                                                                                    <label>Maiden Middle Name:</label><small style="color: orange;"> (Optional Field)</small>
                                                                                    <input
                                                                                            type="text" class = "form-control" id = "acct_maiden_middle_name">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="box box-danger">
                                                                        <div class="box-header with-border">
                                                                            <div class = "box-title" style = "font-weight: bold">Address/es</div>
                                                                        </div>
                                                                        <div class="box">
                                                                            <div class="box-header with-border">
                                                                                <b>Present Address</b>
                                                                            </div>
                                                                            <div class="box-body">
                                                                                <div>
                                                                                    <div class ="row">
                                                                                        <input type="hidden" id="bi_present_idProvince">
                                                                                        <input type="hidden" id="bi_present_idMunicipality">
                                                                                        <div class="form-group col-xs-4">
                                                                                            @if(Auth::user()->authrequest != '')
                                                                                            <label>Unit #, Bldg/Street, Subd/Brgy.</label><small style="color: orange;"> (Optional Field)</small>
                                                                                            @else
                                                                                            <label>Unit #, Bldg/Street, Subd/Brgy.</label><small style="color: red;"> (Required Field)</small>
                                                                                            @endif
                                                                                            <input type="text" class="form-control" placeholder="" id="bi_present_address" name="address">
                                                                                        </div>
                                                                                        <div class="form-group col-xs-4" data-toggle="tooltip" title="Please select city/municipality suggestion list appear below the textbox, this will be auto generate the province">
                                                                                            @if(Auth::user()->authrequest != '')
                                                                                                <label>City/Municipality</label><small style="color: orange;"> (Optional Field)</small>
                                                                                            @else
                                                                                                <label>City/Municipality</label><small style="color: red;"> (Required Field)</small>
                                                                                            @endif
                                                                                            <input type="text" class="form-control ui-autocomplete-input" placeholder="" id="bi_present_municipality" name="municipality" autocomplete="off">
                                                                                        </div>
                                                                                        <div class="form-group col-xs-4"><label>Province</label><small style="color: red;"> (Auto Generated)</small><span id="loading_present_Prov"></span>
                                                                                            <input type="text" class="form-control" placeholder="" id="bi_present_province" name="province" disabled="">
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <input type="checkbox"
                                                                               id="bi_check_same_address" value="same_address">
                                                                        <strong>
                                                                            Check if "PermanentAddress" same as "Present Address"
                                                                        </strong>

                                                                        <div class="box"
                                                                             style="margin-top: 20px">
                                                                            <div class="box-header with-border">
                                                                                <b>Permanent Address</b>
                                                                            </div>
                                                                            <div class="box-body">
                                                                                <div>
                                                                                    <div class =
                                                                                         "row">
                                                                                        <input type="hidden" id="bi_permanent_idProvince">
                                                                                        <input type="hidden" id="bi_permanent_idMunicipality">
                                                                                        <div class="form-group col-xs-4">
                                                                                            <label>Unit #, Bldg/Street, Subd/Brgy.</label><small style="color: red;"> (Required Field)</small>
                                                                                            <input type="text" class="form-control" placeholder="" id="bi_permanent_address" name="address">
                                                                                        </div>
                                                                                        <div class="form-group col-xs-4" data-toggle="tooltip" title="Please select city/municipality suggestion list appear below the textbox, this will be auto generate the province">
                                                                                            <label>City/Municipality</label><small style="color: red;"> (Required Field)</small>
                                                                                            <input type="text" class="form-control ui-autocomplete-input" placeholder="" id="bi_permanent_municipality" name="municipality" autocomplete="off"></div>
                                                                                        <div class="form-group col-xs-4">
                                                                                            <label>Province</label><small style="color: red;"> (Auto Generated)</small><span id="loading_permanent_Prov"></span>
                                                                                            <input type="text" class="form-control" placeholder="" id="bi_permanent_province" name="province" disabled="">
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div id =
                                                                             "addAdditionalAddressBi">
                                                                        </div>
                                                                        <div class = "row">
                                                                            <div class = "col-md-12">
                                                                                <button class ="btn btn-flat btn-block bg-gray pull-right" id = "AddNewAddressBiClient"><i class = "glyphicon glyphicon-plus"></i> Add Address</button>
                                                                            </div>
                                                                            <div id="remove_div"
                                                                                 class="col-md-12" hidden>
                                                                                <button class="btn btn-flat btn-block bg-gray pull-right" id="RemoveAddressBiClient"><i class="glyphicon glyphicon-minus"></i> Remove Address</button>
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="box box-danger">
                                                            <div class="box-header with-border">
                                                                <div class = "box-title">Attachments</div><small style="color: red;"> (Required atleast 1 attachment)</small>
                                                            </div>
                                                            <div class="box-body">
                                                                <div class="row">
                                                                    <div class="form-group col-md-6">
                                                                        <label>Attachment 1(TOR)</label>
                                                                        <input class="bi_attached_file" type="file" id="attach1">

                                                                    </div>
                                                                    <div class="form-group col-md-6"><label>Attachment 2(Application Form)</label>
                                                                        <input class="bi_attached_file" type="file" id="attach2">

                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="form-group col-md-6">
                                                                        <label>Attachment 3(COE)</label>
                                                                        <input
                                                                                class="bi_attached_file" type="file" id="attach3">

                                                                    </div>
                                                                    <div class="form-group col-md-6">
                                                                        <label>Attachment 4(Others)</label>
                                                                        <input
                                                                                class="bi_attached_file" type="file" id="attach4">

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="box box-danger">
                                                            <div class="box-header with-border">
                                                                <div class = "box-title">Select Check</div><small style="color: red;"> (Required Field)</small>
                                                            </div>
                                                            <div class="box-body">
                                                                <div class="form-group"  style="overflow-y: scroll; height: 800px; word-wrap: break-word;">
                                                                <span
                                                                        id="span_check_box_for_checkings">
                                                                </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-12">
                                                <div class="box box-danger">
                                                    <div class="box-header with-border">
                                                        <div class = "box-title">Endorsed By(Recruiter/BI POC)</div>
                                                    </div>
                                                    <div class="box-body">
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="form-group col-md-12">
                                                                    <label>Name of Endorser:</label><small style="color: red;"> (Required Field)</small>
                                                                    <input type="text" class =
                                                                    "form-control" id = "acct_endorsedby">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </span>
                                    <span id="cc_span_pnb" hidden>
                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="box box-danger">
                                                    <div class="box-header with-border">
                                                        <h3 class="box-title">Type of Request</h3>
                                                    </div>
                                                    <div class="box-body">
                                                        <div class="" data-toggle="tooltip"
                                                             title="Available forms are PDRN, BVR and EVR only">
                                                            <select class="select2"
                                                                    style="width: 100%;" id="btnSelectForm">
                                                                <option selected></option>
                                                                <option value="PDRN">PDRN</option>
                                                                <option value="BVR">BVR</option>
                                                                <option value="EVR">EVR</option>
                                                                <option value="Full C.I">Full C.I</option>
                                                                <!--@foreach($tors as $tor)-->
                                                                <!--    <option value="{{ $tor->type_of_request }}">{{ $tor->type_of_request }}</option>-->
                                                                <!--@endforeach-->
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4" id="adjustWidthBvr">
                                                <div class="box box-danger">
                                                    <div class="box-header with-border">
                                                        <h3 class="box-title">Type of Endorsement</h3>
                                                    </div>
                                                    <div class="box-body" data-toggle="tooltip"
                                                         title="You can select for new endorsement instances or for re-visit account">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label class="radio-inline">
                                                                    <input checked type="radio"
                                                                           class="form-group flat-red type_of_endo_main" name="optradio1" id='NewEndorsement' value="New Endorsement">New Endorsement
                                                                </label>
                                                            </div>
                                                               <div class="col-md-6">
                                                                <label class="radio-inline">
                                                                    <input type="radio"
                                                                           class="flat-red type_of_endo_main" name="optradio1" id="ReVisit" value="Re-call">Re-call
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-5" id="">
                                                <div class="box box-danger">
                                                    <div class="box-header with-border">
                                                        <h3 class="box-title">Internal Information</h3>
                                                    </div>
                                                    <div class="box-body" data-toggle="tooltip"
                                                         title="Input Party # and Contract #. Optional">
                                                        <div class="row">
                                                            <div class="col-md-4" hidden>
                                                                <label for="">Dealer name/Party#:<small style="color: orange">(Optional field)</small></label>
                                                                <input type="text" class=""
                                                                       id="party_num">
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label for="">Contract #:<small style="color: red">(Required field)</small></label>
                                                                <input type="text" class="" id="contract_num">
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label for="">Dealer #:<small style="color: red">(Required field)</small></label>
                                                                <input type="text" class="" id="dealer_num">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <span id="type_of_request_selection_bi">
                                        </span>
                                    </span>
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <button type="button" id="btn_bi_submit_endorsement" class="btn btn-success btn-lg pull-right">Submit</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="tab_tab_2">
                                    <div class = "row" style = "padding-top : 20px; ">
                                        <div class="col-md-2">
                                            <div class = "box box-warning">
                                                <div class = "row" style = "padding-top : 10px;">
                                                    <div class = "col-md-12">

                                                        <h4 style = "text-align: center;">Download Template</h4>

                                                        <div class = "row" style = "padding-top : 25px; padding-bottom : 15px;" >
                                                            <div class = "col-md-2"></div>
                                                            <div class = "col-md-8">
                                                                <button type = "button" id ="BtnDlBulkTemp" class = "btn btn-md btn-block btn-info"><i class = "fa fa-fw fa-download"></i> BULK TEMPLATE</button><span id = downTemp4></span>
                                                            </div>
                                                            <div class = "col-md-2"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class = "col-md-3">
                                            <div class = "box box-warning">
                                                <div class = "row" style = "padding-top : 10px;">
                                                    <div class = "col-md-12">
                                                        <h4 style = "text-align: center;">Upload Endorsement<br> <small style = "color:red; margin-top : 15px">Note: Excel Only</small>
                                                        </h4>
                                                    </div>
                                                </div>
                                                <div class = "row" style = "padding-top : 15px;">
                                                    <div class = "col-md-3"></div>
                                                    <div class = "col-md-6">
                                                        <input type="file" id="bulk_endorsement_excel">
                                                    </div>
                                                    <div class = "col-md-3"></div>
                                                </div>

                                                <div class = "row" style = "padding-top : 30px; padding-bottom : 20px;">
                                                    <div class = "col-md-4"></div>
                                                    <div class = "col-md-4">
                                                        <button type = "button" id ="BtnuploadExcelBiBulk" class = "btn btn-md btn-success"><i class = "fa fa-fw fa-upload"></i> UPLOAD EXCEL</button>
                                                    </div>
                                                    <div class = "col-md-4"></div>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-md-7">
                                            {{--<div class = "box box-warning">--}}

                                            <div class="box box-warning collapsed-box">
                                                <div class="box-header with-border">
                                                    <h4 style = "text-align: center">Packages and Checkings(All) </h4>

                                                    <div class="box-tools pull-right">
                                                        <button type="button" class="btn btn-box-tool" data-widget="collapse" id = "closeOpenPackCheck"><i class="fa fa-plus"></i>
                                                        </button>
                                                    </div>
                                                </div>

                                                <div class="box-body">
                                                    <div class = "row" style = "padding-top :20px;">
                                                        <div class = "col-md-5">
                                                            <div class = "box">
                                                                <div class = "box-header with-border">
                                                                    <div class = "box-title">Select Package :</div>
                                                                </div>
                                                                <div class = "form-group" style= "padding-top: 20px;">
                                                                    <span id =
                                                                          "packagesForBulk"></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class = "col-md-1"></div>
                                                        <div class = "col-md-6">
                                                            <div class = "box">
                                                                <div class = "box-header with-border">
                                                                    <div class = "box-title">Select Check :</div>
                                                                </div>
                                                                <div class = "form-group" style= "padding-top: 20px;">
                                                                    <span id =
                                                                          "checkingForBulk"></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class = "row" style = "padding-top : 30px; padding-bottom : 20px;">
                                                        <div class = "col-md-4">
                                                        </div>
                                                        <div class = "col-md-4">
                                                            <button type = "button" id ="applyToAllBulk" class = "btn btn-md btn-block btn-primary "><i class = "fa fa-fw fa-location-arrow"></i> APPLY TO ALL ENDORSEMENTS</button>
                                                        </div>
                                                        <div class = "col-md-4"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class= "row">
                                        <div class = "col-md-12">
                                            <button type = "button" id = "BtnSaveEdit" class="btn btn-md btn-warning pull-right"><i class = "fa fa-fw fa-save"></i> SAVE UPDATED</button>
                                        </div>
                                    </div>

                                    <div class = "row" style = "padding-top : 20px;" id ="showHideExcelTable" hidden>
                                        <div class = "col-md-12" >
                                            <h5 style = "margin-bottom: 15px;">Note : To modify the data from the excel, double click the specific text box to edit.</h5>
                                            <div style = " height : 100%; overflow-x: auto">
                                                <table class="tableendorse table-hover table-condensed" width="100%" id="testExcelTable">
                                                </table>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div id = "alert_show" hidden class="alert alert-danger alert-dismissible">
                                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                                <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                                                <span id = "alert_text"></span>
                                                <br>
                                                Note : To modify the data from the excel, double click the specific text box to edit.
                                            </div>
                                        </div>
                                    </div>
                                    <div class = "row" style = "padding-top: 10px;">
                                        <div class = "coml-md-12">
                                            <button type = "button" class = "btn btn-md btn-primary pull-left" id = "BtnClearBulk">CLEAR FIELDS</button>
                                            <button type = "button" class = "btn btn-md btn-info pull-right" id = "BtnBulkEndorseSubmitExcel">ENDORSE</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="tab_tab_3">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="box box-danger">
                                                <div class="box-body">
                                                    <table class="table-condense table-hover"
                                                           width="100%" id="applicant_encoded_table">
                                                        <thead>
                                                        <tr>
                                                            <td>ID</td>
                                                            <td>DATE/TIME ENCODE</td>
                                                            <td>ACCOUNT NAME</td>
                                                            <td>ATTACHMENTS</td>
                                                            <td>STATUS</td>
                                                            <td>ACTION</td>
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
            </div>
        </div>

        {{--MODAL--}}

        <div class="modal modal-success fade" id="modal_success">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Success!</h4>
                    </div>
                    <div class="modal-body">
                        <p style="text-align: center">Successfully endorsed. Thank you!</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline pull-right" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
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

        <div class="modal modal-danger fade" id="modal_error">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Oops something went wrong!</h4>
                    </div>
                    <div class="modal-body">
                        <p style="text-align: center">Can't process your endorsement, Pleasecontact the system administrator. Thank you.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline pull-right" data-
                                dismiss="modal">Close</button>
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
                        <button type="button" class="btn btn-outline pull-right" data-
                                dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>


        <div class="modal fade" id="modal-acknowledge-encoded">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Acknowledge Account</h4>
                    </div>
                    <div class="modal-body">
                        <div class="box box-danger">
                            <div class="col-md-12">
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="">Account/Project : <small style="color: orange">(Optional field)</small></label>
                                                <input type="text" class="form-control textToClear" id="accnt_project_name">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="">Name of Endorser: <small style="color: red">(Required field)</small></label>
                                                <input type="text" class="form-control textToClear" id="endorser_name">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">Select Package <small
                                                            style="color: red">(Required field)</small></label>
                                                <span id="bi_package_pending"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">LOB <small style="color: orange">(Optional field)</small></label>
                                                <select name="" id="accnt_lob" class="form-control">
                                                    <option value="-">-</option>
                                                    <option value="Yes">Yes</option>
                                                    <option value="No">No</option>
                                                    <option value="N/A">N/A</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="box-header with-border" style=""></div>

                                    <div class="form-group" style="margin-top: 15px;">
                                        <label for="">Select Check <small style="color: red">(Required field)</small></label>
                                        <span id="span_check_box_for_checkings2"></span>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success pull-right" id="ack_encoded">Submit</button>
                        <button type="button" class="btn btn-default pull-left" Requestor Information
                    </div>
                </div>
            </div>
        </div>

    </section>
</div>