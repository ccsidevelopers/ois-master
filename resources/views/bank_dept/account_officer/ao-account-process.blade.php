{{--@extends('layouts.master')--}}


{{--@section('content')--}}
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">
            <h1>Assigned Accounts</h1>
            <!-- Default box -->
            <div class="box">
                <div class="row" style = "padding-bottom : 20px;">
                    <div class="col-lg-3 col-xs-6">
                        <!-- small box -->
                        <div class="small-box bg-aqua">
                            <div class="inner">
                                <h3>{{ $endorsement }}</h3>

                                <p>New Endorsement Account</p>
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
                                <h3>99<sup style="font-size: 20px">%</sup></h3>

                                <p>Successful TAT Account</p>
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
                                <h3>{{ $overdueAccount }}</h3>

                                <p>Overdue Account</p>
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
                                <h3>{{ $dueAccount }}</h3>

                                <p>Due Account as of {{ $timeStamp->toFormattedDateString() }}</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-pie-graph"></i>
                            </div>
                            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                </div>

                <div class="box-header with-border">
                    <h3 class="box-title">Assigned Accounts</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                                title="Collapse">
                            <i class="fa fa-minus"></i></button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                            <i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body">

                    <div class="row">
                        <div class="col-md-12">
                            <!-- Custom Tabs -->
                            <div class="nav-tabs-custom">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a href="#tab_1" data-toggle="tab" id="clicktab1">Pending Accounts</a></li>
                                    <li><a href="#tab_2" data-toggle="tab" id="clicktab2">Finish Accounts</a></li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="tab_1">

                                        <div class="col-md-5">
                                            <div class="box box-danger">
                                                <div class="box-header with-border">
                                                    <h3 class="box-title">Endorsement Range Date</h3>
                                                </div>
                                                <div class="box-body">
                                                    <div class="form-group">

                                                        <input type="radio" class="viewable" name="viewable_pends" id="rad_all_pends" value="All">All
                                                        <input type="radio" class="viewable" name="viewable_pends" id="rad_daterange_pends" value="Date Range">Date Range

                                                        <div class="input-group margin date_range_conts">
                                                            <div class="input-group-btn">
                                                                <button type="button" class="btn btn-default">From</button>
                                                            </div>
                                                            <!-- /btn-group -->
                                                            <input type="text" id="datepicker" class="form-control min">
                                                            <input hidden id="min" type="date">

                                                            <div class="input-group-btn">
                                                                <button type="button" class="btn btn-default">To</button>
                                                            </div>
                                                            <!-- /btn-group -->
                                                            <input type="text" id="datepickermax" class="form-control max">
                                                            <input hidden id="max" type="date">
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <table id="ao-new-endorsement" class="tableendorse table-hover table-condensed" width="100%">
                                            <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Date Endorsed</th>
                                                <th>Time Endorsed</th>
                                                {{--<th>Date Due</th>--}}
                                                {{--<th>Time Due</th>--}}
                                                <th>Date/Time Due</th>
                                                <th>Account Name</th>
                                                <th>Address</th>
                                                <th>Municipalities</th>
                                                <th>Province</th>
                                                <th>Type of Request</th>
                                                <th>Bank Remarks</th>
                                                <th>Requestor Name</th>
                                                <th>Entry As</th>
                                                <th>Actions</th>
                                            </tr>
                                            </thead>
                                            <tfoot>
                                            <tr>
                                                <th>Id</th>
                                                <th>Date Endorsed</th>
                                                <th>Time Endorsed</th>
                                                {{--<th>Date Due</th>--}}
                                                {{--<th>Time Due</th>--}}
                                                <th>Date/Time Due</th>
                                                <th>Account Name</th>
                                                <th>Address</th>
                                                <th>Municipalities</th>
                                                <th>Province</th>
                                                <th>Type of Request</th>
                                                <th>Bank Remarks</th>
                                                <th>Requestor Name</th>
                                                <th>Entry As</th>
                                                <th>Actions</th>
                                            </tr>
                                            </tfoot>
                                        </table>

                                    </div>
                                    <!-- /.tab-pane -->
                                    <div class="tab-pane" id="tab_2">

                                        <div class="col-md-5">
                                            <div class="box box-danger">
                                                <div class="box-header with-border">
                                                    <h3 class="box-title">Endorsement Range Date</h3>
                                                </div>
                                                <div class="box-body" data-toggle="tooltip" title="You can select for the range of date of endorsement that you want to view">
                                                    <div class="form-group">

                                                        <input type="radio" class="viewable" name="viewable_fin" id="rad_all_fin" value="All">All
                                                        <input type="radio" class="viewable" name="viewable_fin" id="rad_daterange_fin" value="Date Range">Date Range

                                                        <div class="input-group margin date_range_conts">
                                                            <div class="input-group-btn">
                                                                <button type="button" class="btn btn-default">From</button>
                                                            </div>
                                                            <!-- /btn-group -->
                                                            <input type="text" id="datepickerminFinish" class="form-control minFinish">
                                                            <input hidden id="minFinish" type="date">

                                                            <div class="input-group-btn">
                                                                <button type="button" class="btn btn-default">To</button>
                                                            </div>
                                                            <!-- /btn-group -->
                                                            <input type="text" id="datepickermaxFinish" class="form-control maxFinish">
                                                            <input hidden id="maxFinish" type="date">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <table id="ao-finish-endorsement" class="tableendorse table-hover table-condensed" width="100%">
                                            <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Date Endorsed</th>
                                                <th>Time Endorsed</th>
                                                {{--<th>Date Due</th>--}}
                                                {{--<th>Time Due</th>--}}
                                                <th>Internal Status</th>
                                                <th>Account Name</th>
                                                <th>Type of Request</th>
                                                <th>Municipalities</th>
                                                <th>Province</th>
                                                <th>Bank Remarks</th>
                                                <th>Requestor Name</th>
                                                <th>Entry As</th>
                                                <th>Actions</th>
                                            </tr>
                                            </thead>
                                            <tfoot>
                                            <tr>
                                                <th>Id</th>
                                                <th>Date Endorsed</th>
                                                <th>Time Endorsed</th>
                                                {{--<th>Date Due</th>--}}
                                                {{--<th>Time Due</th>--}}
                                                <th>Internal Status</th>
                                                <th>Account Name</th>
                                                <th>Type of Request</th>
                                                <th>Municipalities</th>
                                                <th>Province</th>
                                                <th>Bank Remarks</th>
                                                <th>Requestor Name</th>
                                                <th>Entry As</th>
                                                <th>Actions</th>
                                            </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <span id="down_form"></span>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    {{--FOOTER--}}
                </div>
                <!-- /.box-footer-->
            </div>
            <!-- /.box -->

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    {{--REPORT MODAL--}}
    <div class="modal modal-default fade" id="modal-view-report">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Note</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <textarea class="form-control" rows="10" id="acctReport" placeholder="Enter ..." disabled>
                        </textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button type="button" id="exportReport" class="btn btn-primary pull-right">Export to Text File</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    {{--END OF REPORT MODAL--}}

    {{--UPDATE MODAL--}}
    <!--<div class="modal fade" id="modal-update-info">-->
    <!--    <div class="modal-dialog modal-lg">-->
    <!--        <div class="modal-content">-->
    <!--            <div class="modal-header">-->
    <!--                <button type="button" class="close" data-dismiss="modal" aria-label="Close">-->
    <!--                    <span aria-hidden="true">&times;</span></button>-->
    <!--                <h4 class="modal-title">Update Endorsement Account</h4>-->
    <!--            </div>-->
    <!--        {{--<form action="#" method="get">--}}-->
    <!--            <div class="modal-body">-->
    <!--                <div class="box box-solid">-->
    <!--                    <div class="box-body">-->
    <!--                        <input type="hidden" name="_tokens" value="{{ csrf_token() }}">-->
    <!--                        <input type="hidden" id="accountName">-->
    <!--                        {{--EMAIL--}}-->
    <!--                        <div id="div_email" class="row">-->
    <!--                            <div class="box box-danger">-->
    <!--                                <div class="box-header with-border">-->
    <!--                                    <h3 class="box-title">EMAIL NOTIFICATION INFORMATION</h3>-->
    <!--                                </div>-->
    <!--                                <div class="box-body">-->
    <!--                                    <div class="row">-->
    <!--                                        <div class="col-md-12">-->
    <!--                                            <form enctype="multipart/form-data" id="upload_form">-->
    <!--                                                <div class="row">-->
    <!--                                                    <div id="upsform" class="form-group col-xs-12">-->
    <!--                                                        <div class="row">-->
    <!--                                                            <div class="col-md-12">-->
    <!--                                                                <div class="row">-->
    <!--                                                                    <div class="col-md-12 form-group">-->
    <!--                                                                        <label for="">Subject:</label>-->
    <!--                                                                        <input type="text" class="form-control" id="ao_email_report_subj">-->
    <!--                                                                    </div>-->
    <!--                                                                </div>-->
    <!--                                                                <div class="row">-->
    <!--                                                                    <div class="col-md-12">-->
    <!--                                                                        <small style="color: red">NOTE: Hit "ENTER" for next email and make sure the email format is correct. Example: "example@ccsi.com" </small>-->
    <!--                                                                    </div>-->
    <!--                                                                </div>-->
    <!--                                                                <div class="row">-->
    <!--                                                                    <div class="col-md-12 form-group">-->
    <!--                                                                        <label for="">TO:</label>-->
    <!--                                                                        <input type="text" class="form-control tags_input" id="ao_email_report_to" data-role="tagsinput">-->
    <!--                                                                    </div>-->
    <!--                                                                </div>-->
    <!--                                                                <div class="row">-->
    <!--                                                                    <div class="col-md-12 form-group">-->
    <!--                                                                        <label for="">CC:</label>-->
    <!--                                                                        <input type="text" class="form-control tags_input" id="ao_email_report_cc" data-role="tagsinput">-->
    <!--                                                                    </div>-->
    <!--                                                                </div>-->
    <!--                                                            </div>-->

    <!--                                                        </div>-->
    <!--                                                        <div class="row">-->
    <!--                                                            <div class="form-group col-xs-12">-->
    <!--                                                                <label>Remarks:</label>-->
    <!--                                                                <textarea class="form-control" id="txtRemarks" rows="5" placeholder="Enter Remarks ..."></textarea>-->
    <!--                                                            </div>-->
    <!--                                                        </div>-->
    <!--                                                        <div class="row">-->
    <!--                                                            <div class="col-md-12">-->
    <!--                                                                <label for="fileFinisReport">Choose Report File</label>-->
    <!--                                                                <large style="color: red">NOTE: Make sure the file is in .zip file format.</large>-->
    <!--                                                            </div>-->
    <!--                                                            <div class="col-md-12">-->
    <!--                                                                <div class="btn btn-default btn-file">-->
    <!--                                                                    <i class="fa fa-paperclip"></i> <span id="attach_file_name_report">Click Here to browse</span>-->
    <!--                                                                    <input type="file" id="fileFinisReport" name="fileFinisReport" accept=".zip">-->
    <!--                                                                    <span id="ulPercentage"></span>-->
    <!--                                                                    <div id="progressbar"></div>-->
    <!--                                                                </div>-->
    <!--                                                            </div>-->
    <!--                                                        </div>-->
    <!--                                                    </div>-->
    <!--                                                </div>-->
    <!--                                            </form>-->
    <!--                                        </div>-->
    <!--                                    </div>-->
    <!--                                </div>-->
    <!--                            </div>-->
    <!--                            <span id="auto_matic_attach_span"></span>-->
    <!--                        </div>-->
    <!--                        {{--OTHER INFORMATION--}}-->
    <!--                        <div id="view_other_info_updating" class="row">-->
    <!--                            <div class="box box-danger">-->
    <!--                                <div class="box-header with-border">-->
    <!--                                    <h3 class="box-title">OTHER INFORMATION</h3>-->
    <!--                                </div>-->
    <!--                                <div class="box-body">-->
    <!--                                    <div class="row">-->
    <!--                                        <div class="form-group col-xs-6">-->
    <!--                                            <label>Picture Status:</label>-->
    <!--                                            <select class="form-control select1" id="txtPictureStatus" style="width: 100%;">-->
    <!--                                                <option selected="selected">With</option>-->
    <!--                                                <option>Without</option>-->
    <!--                                            </select>-->
    <!--                                        </div>-->
    <!--                                        <div class="form-group col-xs-6">-->
    <!--                                            <label>Type of Sending Report:</label>-->
    <!--                                            <select class="form-control select1" id="txtTOSR" style="width: 100%;">-->
    <!--                                                <option selected="selected">Template</option>-->
    <!--                                                <option>Dictate</option>-->
    <!--                                            </select>-->
    <!--                                        </div>-->
    <!--                                        {{--<div class="form-group col-xs-4">--}}-->
    <!--                                        {{--<label>Account Status (Internal):</label>--}}-->
    <!--                                        {{--<select class="form-control select1" id="txtInternalStatus" style="width: 100%;">--}}-->
    <!--                                        {{--<option selected="selected">TAT</option>--}}-->
    <!--                                        {{--<option>Overdue</option>--}}-->
    <!--                                        {{--</select>--}}-->
    <!--                                        {{--</div>--}}-->
    <!--                                    </div>-->
    <!--                                    <div class="row">-->
    <!--                                        <div class="form-group col-xs-9">-->
    <!--                                            <label>Declared Address:</label>-->
    <!--                                            <input type="text" id="txtAddVer" class="form-control" disabled>-->
    <!--                                        </div>-->
    <!--                                        <div class="form-group col-xs-3">-->
    <!--                                            <label>Verification:</label>-->
    <!--                                            <select class="form-control select1" id="selectAddVer" style="width: 100%;">-->
    <!--                                                <option selected="selected" value="1">Verified Address</option>-->
    <!--                                                <option value="2">Address Not Verified</option>-->
    <!--                                            </select>-->
    <!--                                        </div>-->
    <!--                                    </div>-->
    <!--                                </div>-->
    <!--                            </div>-->
    <!--                        </div>-->
    <!--                        {{--END--}}-->
    <!--                    </div>-->
    <!--                    <div class="box-footer">-->
    <!--                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>-->
    <!--                        <button type="button" class="btn btn-primary pull-right" id="btnUpdateInfo">Send</button>-->
    <!--                    </div>-->
    <!--                    <div id="overlay_load" hidden class="overlay">-->
    <!--                        <i class="fa fa-refresh fa-spin"></i>-->
    <!--                    </div>-->
    <!--                </div>-->
    <!--            </div>-->

    <!--            {{--</form>--}}-->

    <!--        </div>-->
    <!--    </div>-->
    <!--</div>-->
    {{--END UPDATE MODAL--}}
    
     <div class="modal fade" id="modal-update-info">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Update Endorsement Account</h4>
                </div>
            {{--<form action="#" method="get">--}}
                <div class="modal-body">
                    <div class="box box-solid">
                        <div class="box-body">
                            <input type="hidden" name="_tokens" value="{{ csrf_token() }}">
                            <input type="hidden" id="accountName">
                            {{--EMAIL--}}
                            <div id="div_email" class="row">
                                <div class="box box-danger">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">EMAIL NOTIFICATION INFORMATION</h3>
                                    </div>
                                    <div class="box-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <form enctype="multipart/form-data" id="upload_form">
                                                    <div class="row">
                                                        <div id="upsform" class="form-group col-xs-12">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="row">
                                                                        <div class="col-md-12 form-group">
                                                                            <label for="">Subject:</label>
                                                                            <input type="text" class="form-control" id="ao_email_report_subj">
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                            <small style="color: red">NOTE: Hit "ENTER" for next email and make sure the email format is correct. Example: "example@ccsi.com" </small>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row" style="padding-top: 20px;" id="hideShowArchitoEmail" hidden>
                                                                        <div class="col-md-4 form-group">
                                                                            <label for="">Choose Distribution List:</label>
                                                                            <select id="archiClientTOEmail">

                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-md-12 form-group">
                                                                            <label for="">TO:</label>
                                                                            <input type="text" class="form-control tags_input" id="ao_email_report_to" data-role="tagsinput" >
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-md-12 form-group">
                                                                            <label for="">CC:</label>
                                                                            <input type="text" class="form-control tags_input" id="ao_email_report_cc" data-role="tagsinput">
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                            <div class="row">
                                                                <div class="form-group col-xs-12">
                                                                    <label>Remarks:</label>
                                                                    <textarea class="form-control" id="txtRemarks" rows="5" placeholder="Enter Remarks ..."></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <label for="fileFinisReport">Choose Report File</label>
                                                                    <large style="color: red">NOTE: Make sure the file is in .zip file format.</large>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="btn btn-default btn-file">
                                                                        <i class="fa fa-paperclip"></i> <span id="attach_file_name_report">Click Here to browse</span>
                                                                        <input type="file" id="fileFinisReport" name="fileFinisReport" accept=".zip">
                                                                        <span id="ulPercentage"></span>
                                                                        <div id="progressbar"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <span id="auto_matic_attach_span"></span>
                            </div>
                            {{--OTHER INFORMATION--}}
                            <div id="view_other_info_updating" class="row">
                                <div class="box box-danger">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">OTHER INFORMATION</h3>
                                    </div>
                                    <div class="box-body">
                                        <div class="row">
                                            <div class="form-group col-xs-6">
                                                <label>Picture Status:</label>
                                                <select class="form-control select1" id="txtPictureStatus" style="width: 100%;">
                                                    <option selected="selected">With</option>
                                                    <option>Without</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-xs-6">
                                                <label>Type of Sending Report:</label>
                                                <select class="form-control select1" id="txtTOSR" style="width: 100%;">
                                                    <option selected="selected">Template</option>
                                                    <option>Dictate</option>
                                                </select>
                                            </div>
                                            {{--<div class="form-group col-xs-4">--}}
                                            {{--<label>Account Status (Internal):</label>--}}
                                            {{--<select class="form-control select1" id="txtInternalStatus" style="width: 100%;">--}}
                                            {{--<option selected="selected">TAT</option>--}}
                                            {{--<option>Overdue</option>--}}
                                            {{--</select>--}}
                                            {{--</div>--}}
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-xs-9">
                                                <label>Declared Address:</label>
                                                <input type="text" id="txtAddVer" class="form-control" disabled>
                                            </div>
                                            <div class="form-group col-xs-3">
                                                <label>Verification:</label>
                                                <select class="form-control select1" id="selectAddVer" style="width: 100%;">
                                                    <option selected="selected" value="1">Verified Address</option>
                                                    <option value="2">Address Not Verified</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{--END--}}
                        </div>
                        <div class="box-footer">
                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary pull-right" id="btnUpdateInfo">Send</button>
                        </div>
                        <div id="overlay_load" hidden class="overlay">
                            <i class="fa fa-refresh fa-spin"></i>
                        </div>
                    </div>
                </div>

                {{--</form>--}}

            </div>
        </div>
    </div>

    {{--UPDATE SUCCESS MODAL--}}
    <div class="modal modal-success fade" id="modal-successUpdate">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Success!</h4>
                </div>
                <div class="modal-body">
                    <p style="text-align: center">Report Successfully Updated!</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline pull-right" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    {{--END--}}

    {{--SENDING EMAIL MODAL--}}
    <div class="modal modal-warning fade" id="modal-sendnig-email-from-ao-to-client">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Please Wait, we are processing your request.</h4>
                </div>
                <div class="modal-body">
                    <p style="text-align: center">Sending Email.  <img src="{{ asset('dist/img/loading.gif') }}" style="width: 5%;"></p>
                </div>
                <div class="modal-footer">
                    {{--<button type="button" class="btn btn-outline pull-right" data-dismiss="modal">Close</button>--}}
                </div>
            </div>
        </div>
    </div>
    {{--END--}}

    {{--SUCCESS email send MODAL--}}
    <div class="modal modal-success fade" id="modal-success-email-sent">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Email Sent!</h4>
                </div>
                <div class="modal-body">
                    <p style="text-align: center">Report Successfully Sent Via Email!</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline pull-right" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    {{--END--}}

    {{--FAILED email send MODAL--}}
    <div class="modal modal-warning fade" id="modal-failed-email-sent">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Email Sending Not Available</h4>
                </div>
                <div class="modal-body">
                    <p style="text-align: center">Report Failed to Sent Via Email.<br>This Feature is still not available.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline pull-right" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    {{--END--}}


    {{--VIEW FULL INFO MODAL--}}
    <div class="modal fade" id="modal-view-info">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">ENDORSEMENT</h4>
                </div>
                <div class="modal-body">
                    <span class="badge bg-light-blue-gradient"><h5>ENDORSEMENT INFORMATION</h5></span>
                    {{--INFO START HERE--}}
                    <span id="spanhere"></span>
                    {{--END OF INFO--}}
                    <br id="spanhere"/>
                    {{--COBORROWER HERE--}}
                    <table border="2" width="100%" id="otherInfoSpan"></table>
                    {{--END OF COBORROWER--}}
                    <br id="otherInfoSpan"/>
                    {{--EMPLOYER HERE--}}
                    <table border="2" width="100%" id="otherEmployerSpan"></table>
                    {{--END OF COBORROWER--}}
                    {{--BUSINESS HERE--}}
                    <table border="2" width="100%" id="otherBusinessSpan"></table>
                    {{--END OF BUSINESS--}}
                    <span class="badge bg-light-blue-gradient"><h5>ENDORSEMENT HISTORY</h5></span>
                    {{--INFO START HERE--}}
                    <div style="overflow:scroll; height:300px;">
                        <table border="2" width="100%" id="history"></table>
                    </div>
                    {{--END OF INFO--}}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    {{--END OF VIEW FULL INFO MODAL--}}

{{--@endsection--}}

{{--@push('leftsidebar')--}}
    {{--@include('bank_dept.account_officer.ao-leftsidebar')--}}
{{--@endpush--}}

{{--@push('jscript')--}}
    {{--<link rel="stylesheet" href="https://cdn.datatables.net/responsive/1.0.7/css/responsive.dataTables.min.css">--}}

    {{--<script src="{{ asset('jscript/ao.js') }}"></script>--}}
{{--@endpush--}}