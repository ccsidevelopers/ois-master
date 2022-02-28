<!DOCTYPE html>
<html>
@if(Auth::user()->hasRole('Client') || Auth::user()->hasRole('B.I Client'))
<script src="https://www.paypal.com/sdk/js?client-id=AVvuz58FjbPNluU99dUpaSv9iWTABGvm2DMz1zxJEE__tvpiC-mjIBqkZT6FgGnpQ9z6WWMJUSp_7wlz&currency=PHP&disable-funding=card"></script> <!--live account -->
{{--<script src="https://www.paypal.com/sdk/js?client-id=Adu3Y1eQSzRe0kn_HJvLZn7Rs6XZGl4Xumm3N7aQD64tMovwVRFcFXTL54zZfZPknh-j443QLu1acx6D&currency=PHP&disable-funding=card"></script>  <!--sandbox account -->--}}
@endif    
    
@include('layouts.includes.headerplugins')
<body class="hold-transition skin-red sidebar-mini">
{{--<div class="preload"><img src="http://i.imgur.com/KUJoe.gif">--}}
{{--</div>--}}
{{--<div id="overlay">--}}
{{--<div id="progstat"></div>--}}
{{--<div id="progress"></div>--}}
{{--</div>--}}
<div class="se-pre-con"></div>

<div class="wrapper">

    <span hidden id="download_bi_files_123123123123"></span>

    {{--FOR SUGGESTION ONLY--}}
    <div class="modalsuggestion" id="modalsuggestion">
        <div class="modal fade" id="modal-default">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"></h4><small>Since the system is still on beta, expect the bugs and unnecessary things you may encounter during the process of the accounts. You can write your suggestion/concern and report here. Thank you!.</small>
                    </div>
                    <div class="modal-body">

                        <div class="box">
                            <div class="box-header">
                                <h3 class="box-title">
                                    <div class="form-group ">
                                        <label for="TitleSuggestion">Title:</label>
                                        <input type="text" class="form-control col-xs-12" id="TitleSuggestion" placeholder="Title here.">
                                    </div>
                                </h3>
                                <!-- tools box -->
                                <div class="pull-right box-tools">
                                    <button type="button" class="btn btn-default btn-sm" data-widget="collapse" data-toggle="tooltip"
                                            title="Collapse">
                                        <i class="fa fa-minus"></i></button>
                                    <button type="button" class="btn btn-default btn-sm" data-widget="remove" data-toggle="tooltip"
                                            title="Remove">
                                        <i class="fa fa-times"></i></button>
                                </div>
                                <!-- /. tools -->
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body pad">
                                <form>
                                             <textarea class="textarea" id="textareasuggestion" placeholder="Place your suggestions or reports here"
                                                       style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                                    <span id="textareaspan"></span>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="closesuggestion" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                        <button id="SuggestionSubmit" type="button" class="btn btn-primary">Submit</button>
                    </div>

                </div>
                <!-- /.modal-content -->
                <br>
                <div class="col-md-12">
                    <span id="getpolls">
                    </span>
                </div>
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->

    </div>

    <div class="modalsuggestionqqqq" id="modalsuggestionqqqqq">
        <div class="modal fade" id="modal-ci-direct">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h3 class="modal-title">Credit Investigator Directory</h3>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            @if(!Auth::user()->hasRole('Account Officer'))
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="ciIDinfo">Please select credit investigator:</label>
                                    <select class="select2" style="width: 100%;" id="ciIDinfo"></select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <button id="ci_directory_btn_view" class="btn btn-sm btn-info btn-block" style="margin-top: 23.5px">view</button>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <label>Generate C.I Attendance</label>
                                <div class="form-group">
                                    <input type="radio" class="attendance_date_range" name="attendance_range" value="Today" checked title="Will Generate the attendance of all C.I of current date">
                                    <label for="">Default</label>
                                    <input type="radio" class="attendance_date_range" name="attendance_range" value="Range">
                                    <label for="">Date Range</label>
                                    {{--<a class="btn btn-success btn-sm pull-right" id="generate_attendance_allCi" target="_blank" href="generate-excel-attendace-ci?start={{date("Y-m-d")}}&end={{date("Y-m-d")}}">Generate Attendance</a>--}}
                                    <a class="btn btn-success btn-sm pull-right" id="generate_attendance_allCi">Generate Attendance</a>
                                </div>
                                <div class="form-group" id="attendance_date_rangePicker_holder" hidden>
                                    <div class="input-group">
                                        <div class="input-group-btn">
                                            <button type="button" class="btn btn-default">From</button>
                                        </div>
                                        <!-- /btn-group -->
                                        <input type="text" id="attendanceStart" class="datepicks form-control attendanceReqF">
                                        <input hidden="" id="attendanceStart" type="date">

                                        <div class="input-group-btn">
                                            <button type="button" class="btn btn-default">To</button>
                                        </div>
                                        <!-- /btn-group -->
                                        <input type="text" id="attendanceEnd" class="datepicks form-control attendanceReqF">
                                        <input hidden="" id="attendanceEnd" type="date">
                                    </div>
                                </div>
                            </div>
                            @else
                            <div class="col-md-10">
                                <div class="form-group">
                                    <label for="ciIDinfo">Please select credit investigator:</label>
                                    <select class="select2" style="width: 100%;" id="ciIDinfo"></select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <button id="ci_directory_btn_view" class="btn btn-sm btn-info btn-block" style="margin-top: 23.5px">view</button>
                                </div>
                            </div>
                            @endif
                        </div>
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <span id="span_ci_directory_main"></span>
                                <span id="span_ci_directory_other"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <center>
                                    <a id="locationviewer" target="_blank" hidden class="btn btn-info">View Location on Google Map</a>
                                    <a id="login_trail" hidden class="btn btn-warning">View Login Trail</a>
                                </center>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 form-group">
                                {{--<div id="show_login_trail"  style="overflow-y: auto; height: 30%">--}}
                                <div id="show_login_trail" >
                                    <table id="table_login_trail" class = "table-condensed" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Lat | Long</th>
                                                <th>Type</th>
                                                <th>User IP Address</th>
                                                <th>User Agent</th>
                                                <th>Login Time</th>
                                            </tr>
                                        </thead>
                                        {{--<tbody id="table_login_trail_body">--}}
                                        {{--</tbody>--}}
                                    </table>
                                </div>
                            </div>
                        </div>



                        <div class="modal-footer">
                            <button type="button" id="closesuggestion" class="btn btn-default pull-right" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->
        </div>
    </div>
    {{--END OF SUGGESTION--}}


    <div class="modal fade" id="modal-change-dp">
        <div class="modal-dialog" style="width: 30%;">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" style = "text-align: center">Change Display Icon/Image</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="box box-danger">
                                    <div class="col-md-6" style="margin-top: 15px; border:1px solid black; margin-bottom: 15px;">
                                        <center><img src="{{asset(Auth::user()->pix_path)}}" alt="" id="show_dp_uploaded" style="margin-top: 1px; max-width: 218px; max-height: 265px;" class="show_dp_uploaded"></center>
                                    </div>
                                    <div class="col-md-6" style="margin-top: 20%;">
                                        <input type="file" id="change_dp_image">
                                    </div>
                                    <div class="">
                                        <div class="col-md-2" style="margin-top: 8%; margin-left:1%; border:1px solid black">
                                            <center><img src="{{asset(Auth::user()->pix_path)}}" alt="" id="show_dp_uploaded" style="margin-top: 1px; max-width: 100%; max-height: 100%;" class="show_dp_uploaded"></center>
                                        </div>
                                        <div class="col-md-2" style="margin-top: 8%;">
                                            <center><img src="{{asset(Auth::user()->pix_path)}}" alt="" id="" style="margin-top: 1px; max-width: 100%; max-height: 100%; border:1px solid black;" class="show_dp_uploaded img-circle"></center>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box box-danger">

                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success pull-right" id="change_dp_save" style="width: 100px;">Save</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    
   <div class="modal fade" id="modal-attendance-general" data-backdrop="static">
        @if(Auth::user()->hasRole('Management') || Auth::user()->hasRole('Senior Account Officer') || Auth::user()->hasRole('CC Senior Account Officer'))
            <div class="modal-dialog modal-xl" style="width: 60%">
                @else
                    <div class="modal-dialog modal-xl" style="width:60%">
                        @endif
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" style = "text-align: center">Attendance</h4>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="nav-tabs-custom">
                                            <ul class="nav nav-tabs">
                                                <li class="active"><a href="#gen_att_tab1" data-toggle="tab" class="gen_att_tabs">Attendance</a></li>
                                                <li><a href="#gen_att_tab2" data-toggle="tab" class="gen_att_tabs" loaded="false">Attendance Record</a></li>


                                                @if(Auth::user()->hasRole('Management') || Auth::user()->hasRole('Human Resources') || Auth::user()->hasRole('CC Senior Account Officer'))
                                                    <li><a href="#gen_att_tab3" data-toggle="tab" class="gen_att_tabs gen_att_tabs1" loaded="false">Update Employee Daily
                                                            Schedule</a></li>
                                                @endif
                                            </ul>

                                            <div class="tab-content">
                                                <div class="tab-pane active" id="gen_att_tab1">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <center>
                                                                <h4>DATE TODAY: <b>{{\Carbon\Carbon::now('Asia/Manila')->toFormattedDateString()}}</b></h4>
                                                            </center>
                                                        </div>
                                                        @if(Auth::user()->hasRole('Management') || Auth::user()->hasRole('Senior Account Officer') || Auth::user()->hasRole('CC Senior Account Officer') || Auth::user()->hasRole('Quality Analyst'))
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="col-md-2">

                                                                    </div>
                                                                    <div class="col-md-8">
                                                                        <div class="form-group">
                                                                            <div class="row">
                                                                                <div class="col-md-12">
                                                                                    <small class="pull-left"><b style="color:red">NOTE:</b> <br><b>*Please indicate your work
                                                                                            schedule below and save it. (1 time only).<br>*Your Time in and Time out are auto generated upon clicking the button for time in and time out.</b></small>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <div class="row">
                                                                                <label>Schedule/Shift start at:<small style="color: red">(Required Field)</small></label>

                                                                                <div class="col-md-12">
                                                                                    <div class="col-md-4">
                                                                                        <label for="">HOUR</label>
                                                                                        <input type="number" class="form-control time_in_class_val" max="12" min="01"
                                                                                               style="text-align: center;" name="0" placeholder="00">
                                                                                    </div>
                                                                                    <div class="col-md-4">
                                                                                        <label for="">MINUTE</label>
                                                                                        <input type="number" class="form-control time_in_class_val" max="59" min="00"
                                                                                               style="text-align: center;" name="1" placeholder="00" value="00">
                                                                                    </div>
                                                                                    <div class="col-md-4">
                                                                                        <label for="">AM/PM</label>
                                                                                        <select id="" style="text-align: center;" class="form-control time_in_class_val" name="2">
                                                                                            <option value="AM">AM</option>
                                                                                            <option value="PM">PM</option>
                                                                                        </select>
                                                                                    </div>
                                                                                    <input type="text" class="form-control" readonly id="attendance_work_start" style="display:
none;">
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="form-group">
                                                                            <div class="row">
                                                                                <label>Schedule/Shift ends at:<small style="color: red">(Required Field)</small></label>

                                                                                <div class="col-md-12">
                                                                                    <div class="col-md-4">
                                                                                        <label for="">HOUR</label>
                                                                                        <input type="number" class="form-control time_out_class_val" max="12" min="01"
                                                                                               style="text-align: center;" maxlength="2" name="0" placeholder="00">
                                                                                    </div>
                                                                                    <div class="col-md-4">
                                                                                        <label for="">MINUTE</label>
                                                                                        <input type="number" class="form-control time_out_class_val" max="59" min="00"
                                                                                               style="text-align: center;" maxlength="2" name="1" placeholder="00" value="00">
                                                                                    </div>
                                                                                    <div class="col-md-4">
                                                                                        <label for="">AM/PM</label>
                                                                                        <select id="" style="text-align: center;" class="form-control time_out_class_val"
                                                                                                name="2">
                                                                                            <option value="PM">PM</option>
                                                                                            <option value="AM">AM</option>
                                                                                        </select>
                                                                                    </div>
                                                                                    <input type="text" class="form-control" readonly id="attendance_work_end" style="display:
none;">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <button class="pull-right btn-sm btn btn-success" id="save_attendance_schedule">Save</button>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-2">

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif

                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <table class="table-condensed table-hover general_attendance_logs" width="100%" style="margin-top: 15px;">
                                                                <tr style="background-color: black; color:white;">
                                                                    <th>DATE</th>
                                                                    <th>TIME</th>
                                                                    <th>LABEL</th>
                                                                </tr>
                                                                <tr>
                                                                    <th>DATE</th>
                                                                    <th>TIME</th>
                                                                    <th>LABEL</th>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="tab-pane" id="gen_att_tab2">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <label for="">Please select date to see your previous records: <small style="color: red">(Required Filed)
                                                                </small></label>
                                                            <div class="input-group margin">
                                                                <input type="date" class="form-control" id="attendance_log_all_input">
                                                                <span class="input-group-btn">
                                                        <button class="btn btn-success btn-flat" id="refresh_atten_logs">View</button>
                                                    </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <table class="table-condensed table-hover general_attendance_logs_all" width="100%" style="margin-top: 15px;">
                                                                <tr style="background-color: black; color:white;">
                                                                    <th>DATE</th>
                                                                    <th>TIME</th>
                                                                    <th>LABEL</th>
                                                                </tr>
                                                                <tr>
                                                                    <th>DATE</th>
                                                                    <th>TIME</th>
                                                                    <th>LABEL</th>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>

                                                @if(Auth::user()->hasRole('Management') || Auth::user()->hasRole('Human Resources') || Auth::user()->hasRole('CC Senior Account Officer'))
                                                    <div class="tab-pane" id="gen_att_tab3">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="box">
                                                                    <div class="box-body">
                                                                        <div class="row">
                                                                            <div class="col-md-4">
                                                                                <div class="form-group margin">
                                                                                    <select name="" class="form-control filter_archipelagos_watchu" id="filter_archipelagos_id"
                                                                                            style="width:100%; cursor:pointer;">
                                                                                        <option value="">All</option>
                                                                                        <option value="1">LUZON</option>
                                                                                        <option value="2">VISAYAS</option>
                                                                                        <option value="3">MINDANAO</option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="row">
                                                                            <div class="col-md-12">
                                                                                <table width="100%" class="table table-bordered table-hover table-striped dataTable table_user_archipelago"
                                                                                       id="table_user_archipelago" role="grid">
                                                                                    <thead>
                                                                                    <tr>
                                                                                        <th>Employee Name</th>
                                                                                        <th>Position</th>
                                                                                        <th>Schedule</th>
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
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button class="btn btn-default pull-left btn-sm" data-dismiss="modal">Close</button>
                                <button what="BREAKTIME-OUT" class="btn btn-danger pull-right btn-sm attendance_all_click hide_me_attendance_btn">Breaktime-OUT</button>
                                <button what="BREAKTIME-IN" class="btn btn-success pull-right btn-sm attendance_all_click hide_me_attendance_btn">Breaktime-IN</button>
                                <button what="TIME-OUT" class="btn btn-danger pull-right btn-sm attendance_all_click hide_me_attendance_btn">Time-OUT</button>
                                <button what="TIME-IN" class="btn btn-success pull-right btn-sm attendance_all_click hide_me_attendance_btn" id="work_status_hrgrr">Time-IN</button>
                            </div>

                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
            </div>
    
    <div class="modal modal-default fade" id="modal-memorandum-gen">
        <div class="modal-dialog" style="width: 80%">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="panel panel-danger">
                        <div class="panel-heading">
                            <h4 style="text-align : center">Memorandum/Announcements</h4>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="box box-solid">
                                        <div class="box-header with-border">
                                            <h3 class="box-title">Monitoring</h3>

                                            <div class="box-tools">
                                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="box-body no-padding">
                                            <ul class="nav nav-pills nav-stacked">
                                                <li><a href="#" class="gen_memo_left_class" id="refreshGenIssuanceTab"><i class="fa fa-envelope-o"></i> Memorandum and Announcements</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <div id="showSentIssuanceGen" >
                                        <div class="box box-primary">
                                            <div class="box-header with-border">
                                                <h3 class="box-title">List of Memorandum/Announcement</h3>
                                                <!-- /.box-tools -->
                                            </div>
                                            <!-- /.box-header -->
                                            <div class="box-body">
                                                <div class="mailbox-controls">
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-default btn-md" id="btnRefreshTableIssuance"><i class="fa fa-refresh"></i></button>
                                                    </div>
                                                    <!-- /.btn-group -->

                                                    <!-- /.pull-right -->
                                                </div>

                                                <div class="row" style="padding-top: 15px;">
                                                    <div class="col-md-12">
                                                        <table class="table-striped table-condensed" id="gen_sent_issuance_mail"  width="100%">
                                                            <thead>
                                                            <tr>
                                                                <th>Date and Time Sent</th>
                                                                <th>Sender</th>
                                                                <th>Recepient</th>
                                                                <th>Subject</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            <tr>
                                                                <th>Date and Time Sent</th>
                                                                <th>Sender</th>
                                                                <th>Recepient</th>
                                                                <th>Subject</th>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>

                                            </div>
                                            <!-- /.box-body -->
                                        </div>
                                    </div>
                                    <div id="showMessageGenIssuance" hidden>
                                        <div class="box box-primary">
                                            <div class="box-header with-border">
                                                <h3 class="box-title">Read Message</h3>
                                            </div>
                                            <div class="box-body no-padding">
                                                <div class="mailbox-read-info">
                                                    <h3 id="placeSubGenIssuance">Message Subject Is Placed Here</h3>
                                                    <h5 >From: <span id="placeSenderGenIssuance"></span></h5>

                                                </div>
                                                <div class="mailbox-read-message" id="placeMessageGenIssuance">

                                                </div>
                                                <!-- /.mailbox-read-message -->
                                            </div>
                                            <!-- /.box-body -->
                                            <div class="box-footer">
                                                <ul class="mailbox-attachments clearfix" id="loopAllFilesPlaceIssuance">

                                                </ul>
                                            </div>
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
        </div>
</div>

    <div class="modal modal-default fade" id="modal-acknowledge-view">
        <div class="modal-dialog" style="width: 80%">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="panel panel-danger">
                        <div class="panel-heading">
                            <h4 style="text-align : center">Acknowledgement</h4>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="box box-solid">
                                        <div class="box-header with-border">
                                        </div>
                                        <div class="box-body no-padding">
                                            <ul class="nav nav-pills nav-stacked" id="tbl_acnoo" style="overflow-y: scroll; max-height: 600px; padding-bottom: 3%;">
                                                <li id="acno_header"><a href="#" class="Acno_ref">Acknowledgement Records<i class="fa fa-refresh" style="float: right;"></i></a></li>
                                                <label>Search:</label>
                                                <input type="search" class="form-control" placeholder="Search for the date and Time" id="Ar_searchViewqwe"><br>
                                            </ul>
                                        </div>
                                        <div class="box-body no-padding">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <div class="box box-primary">
                                        <div class="box-header with-border">
                                            <h3 class="box-title">Acknowledgement Form</h3>
                                        </div>
                                        <div class="box-body">
                                            <div class="row" style="padding-top: 15px;">
                                                <div class="col-md-11">
                                                    {{----Insert Form HERE----}}
                                                    <table class="table-condensed centerContent" style = "overflow-x:auto; border-collapse:collapse; table-layout:fixed; width : 100%" id="acknowledge-Infomonit">
                                                        <tr>
                                                            <th colspan="4" style = "background-color: darkgrey; color : black; "><h4 style= "font-weight:bold;">ACKNOWLEDGEMENT RECEIPT</h4>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2" style="font-weight:bold;"><span class = "pull-left toLeftTop">Name of employee :</span> </td>
                                                            <td colspan = "2"><input type="text" class = "form-control" id="ar_name_view" disabled></td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2" style="font-weight:bold;"><span class = "pull-left toLeftTop">Office Location-Department-Position :</span> </td>
                                                            <td colspan = "2"><input type="text" class = "form-control" id="ar_loc_dept_view" disabled></td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2" style="font-weight:bold;"><span class = "pull-left toLeftTop">Contact Number and Email Address :</span> </td>
                                                            <td colspan = "2"><input type="text" class = "form-control" id="ar_cont_email_view" disabled></td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2" style="font-weight:bold;"><span class = "pull-left toLeftTop">LBC Branch :</span> </td>
                                                            <td colspan = "2"><input type="text" class = "form-control" id="ar_lbc_branch_view" disabled></td>
                                                        </tr>
                                                    </table>


                                                    <table class="table-condensed centerContent" style = "overflow-x:auto; border-collapse:collapse; table-layout:fixed; width : 100%" id="acknowledge-lister" >
                                                        <tbody>
                                                        <tr name="0">
                                                            <th colspan="1" style = "background-color: darkgrey; color : black; font-weight:bold; padding-bottom: 15px; text-align: center"><span style = "padding-top : 10px;">Quantity</span>
                                                            <th colspan="1" style = "background-color: darkgrey; color : black; font-weight:bold; padding-bottom: 15px; text-align: center"><span style = "padding-top : 10px;">Brand - Item - Description</span>
                                                            <th colspan="1" style = "background-color: darkgrey; color : black; font-weight:bold; padding-bottom: 15px;text-align: center "> <span style = "padding-top : 10px;">Warranty Period</span>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                    <table class="table-condensed" style = "overflow-x:auto; border-collapse:collapse; table-layout:fixed; width : 100% ;">
                                                        <tr>
                                                            <th colspan = "5" style = "padding-left : 10px; padding-right : 10px;">
                                                                <br>
                                                                <h5 style = "font-style : italic; text-align: justify;">I hereby acknowledge that I have received the followeing company properly. I agree to keep the property in working condition, and to notify management  should properly malfunction in any way or should
                                                                    the property be lost or stolen. Further, I agree to return this property at the end of my employment. When I no longer need one or more of the items. I will return it/them to immediately to my supervisor</h5>
                                                                <h5 style = "font-style : italic; text-align: justify;">No employee is allowed to exchange and bargain all company issued equipment without the knowledge or approval of the management. furthermore, all issued equipment, email address, passwords and cell phone number
                                                                    must be available to the company at all times.</h5>
                                                                <h5 style = "font-style : italic; text-align: justify;">In case of damage/s or loss/es of the said item/s above, the receiver shall be held liable or accountable for the negligence that may occur. Thereof, the receiver immediate written
                                                                    notice to their supervisor/s.</h5>
                                                                <br>

                                                                <div class="row" style = " padding-top : 20px">
                                                                    <div class= "col-md-5">
                                                                        <span class="pull-right" style = "width: 210px; border-bottom-style :solid"></span>
                                                                    </div>
                                                                    <div class= "col-md-2"></div>
                                                                    <div class= "col-md-5">
                                                                        <span class="pull-left" style = "width: 205px; border-bottom-style :solid"></span>
                                                                    </div>
                                                                </div>
                                                                <div class="row" style = "">
                                                                    <div class="col-md-1"></div>
                                                                    <div class="col-md-5">
                                                                        <span class="" style = "text-align: center;">Employee Signature</span>
                                                                    </div>
                                                                    <div class="col-md-5">
                                                                        <span class="" style = "text-align: center">Date Received</span>
                                                                    </div>
                                                                </div>
                                                            </th>
                                                        </tr>
                                                    </table>
                                                    <table class="table-condensed centerContent" id="acknowledge-checker" style = "overflow-x:auto; border-collapse:collapse; table-layout:fixed; width : 100%; margin-top : 30px;>
                                                        <tr>
                                                            <th colspan="1" ><th  style = "background-color: darkgrey; color : black; ">For Administration Department - Attach and secure the following documents: </th>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="1"><span class="toLeftTop2 pull-left" style="padding-left: 250px"><input type="checkbox" class="Check_arView" name="0"> <b>Approved Requisition</b></span></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="1" ><span class="toLeftTop2 pull-left" style="padding-left: 250px"><input type="checkbox" class="Check_arView" name="1"> <b>Approved Supplier(Comparison and Recommendation)</b></span></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="1" ><span class="toLeftTop2 pull-left" style="padding-left: 250px"><input type="checkbox" class="Check_arView" name="2"> <b>Approved Purchase Order with Signed Proposal or Agreement</b> </span></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="1" ><span class="toLeftTop2 pull-left" style="padding-left: 250px"><input type="checkbox" class="Check_arView"  name="3"> <b>Warranty Card or Receipts</b> </span></td>
                                                    </tr>
                                                    </table>

                                                    <table class="table-condensed hideThisTable" hidden style = "table-layout:fixed; width : 100%; margin-top : 20px;" id="Ar_btnTable">
                                                        <tr>
                                                            <td style="border: none ;">
                                                                <button class="btn btn-success pull-right" value="Acknowledge" id="btnArToAcknowledge">
                                                                    Acknowledge
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
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
            </div>
        </div>
    </div>

     {{--oims concern--}}
            <div class="modal fade" id="oims_concern_modal" >
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-blue">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                            <h4 class="modal-title text-uppercase"><i class="fa fa-edit margin"></i> contact us</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                   <h3 class="">We're here to help</h3>
                                    <div class="col-md-5 col-sm-5" style="background: #eee; margin:5% 4% 0;padding:5%;border-radius:4px;box-shadow:-4px 7px 4px #ddd;">
                                        <div class="floating-icon" style="font-size: 40px; text-align: center; margin-top: -29%;">
                                            <div style="width: 80px; height: 80px; margin: 0 auto; background: #dd4b39; border-radius: 40px; position: relative;box-shadow:-4px 7px 4px #ddd;">
                                                <i class="fa fa-fw fa-google-plus" style="position: absolute;top: 20px;left: 22%;color:white;"></i>
                                            </div>
                                        </div>
                                        <h3 class="text-capitalize">contact us</h3>
                                        <p style="font-size: 16px; border-left: 3px solid #dd4b39; padding: 7px;"> we're available Monday - Friday<br>8:00 am to 5:00 pm</p>
                                        <a href="https://forms.gle/MATkDEsu2SzSQbwQ8" target="_blank" class="btn btn-danger text-capitalize" id="" style="font-size: 16px; margin-top: 8px;box-shadow:1px 8px 4px #ddd;"> send now</a>
                                    </div>

                                    <!--<div class="col-md-5 col-sm-5" style="background: #eee; margin:5% 3% 5%;padding:5%;border-radius:4px;box-shadow:-4px 7px 4px #ddd;">-->
                                    <!--    <div class="floating-icon" style="font-size: 40px; text-align: center; margin-top: -29%;">-->
                                    <!--        <div style="width: 80px; height: 80px; margin: 0 auto; background: #00a65a; border-radius: 40px; position: relative;box-shadow:-4px 7px 4px #ddd;">-->
                                    <!--            <i class="fa fa-fw fa-stethoscope" style="position: absolute;top: 20px;left: 22%;color:white;"></i>-->
                                    <!--        </div>-->
                                    <!--    </div>-->
                                    <!--    <h3 class="text-capitalize">submit now</h3>-->
                                    <!--    <p style="font-size: 16px; border-left: 3px solid #00a65a; padding: 7px;"> fill up this form for health monitoring<br>(daily health symptoms)</p>-->
                                    <!--    <a href="https://docs.google.com/forms/d/e/1FAIpQLSeDMpVx_mfOegKcEOr4Fkbf_2j6fIkDg4ewdOxWFpy0Srkfwg/viewform" target="_blank" class="btn btn-success text-capitalize" id="" style="font-size: 16px; margin-top: 8px;box-shadow:1px 8px 4px #ddd;"> Fill-up now</a>-->
                                    <!--</div>-->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


    @include('modal.compilation-modal')

    @include('layouts.includes.header')

    @stack('leftsidebar')

    @yield('content')

    @include('layouts.includes.footer')
    @include('layouts.includes.rightsidebar')

</div>
@include('layouts.includes.footerplugins')
@stack('jscript')
<script src="{{ asset('jscript/general.js?n='.$javs) }}"></script>
<script>
    $.fn.dataTable.ext.errMode = 'none';
</script>
</body>
</html>