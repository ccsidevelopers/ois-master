{{--@extends('layouts.master')--}}

{{--<style>--}}

{{--.table, th, td {--}}
{{--font-size: 90%;--}}
{{--border: 1px solid grey;--}}
{{--text-align: center;--}}
{{--padding: 1px;--}}
{{--}--}}

{{--/*td{*/--}}
{{--/*height: 50px;*/--}}
{{--/*width: 50px;*/--}}
{{--/*}*/--}}

{{--th{--}}
{{--height: 30px;--}}

{{--text-align: center;--}}
{{--}--}}

{{--</style>--}}


{{--@section('content')--}}
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Endorsement Page
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="row">
            <div class= "box-body">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a id="" href="#tab_1-1" data-toggle="tab">New Endorsement</a></li>
                        <li class=""><a id="" href="#tab_2-2" data-toggle="tab">Bulk Endorsement</a></li>
                    </ul>
                    <div class = "tab-content">
                        <div class="tab-pane active" id="tab_1-1">

                            <div class="box-header with-border">
                                <h3 class="box-title">Please fill up this form for endorsement</h3>
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
                                    @if(Auth::user()->name == 'Individual Client')
                                        <div class="col-md-3">
                                            <div class="box box-danger">
                                                <div class="box-header with-border">
                                                    <h3 class="box-title">Type of Request</h3>
                                                </div>
                                                <div class="box-body">
                                                    <div class="form-group">
                                                        <label class="radio-inline" title="Personal Data and Residence Neighborhood Checking">
                                                            <input type="radio" class="flat-red type_req_rad_but" name="type_of_r" id="PDRNrad" value="PDRN">Personal Data and Residence Neighborhood Checking
                                                        </label>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="radio-inline" title="Business Verificaiton Report">
                                                            <input type="radio" class="flat-red type_req_rad_but" name="type_of_r" id="BVRrad" value="BVR">Business Verificaiton Report
                                                        </label>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="radio-inline" title="Employment Verification Report">
                                                            <input type="radio" class="flat-red type_req_rad_but" name="type_of_r" id="EVRrad" value="EVR">Employment Verification Report
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <div class="col-md-2">
                                            <div class="box box-danger">
                                                <div class="box-header with-border">
                                                    <h3 class="box-title">Type of Request</h3>
                                                </div>
                                                <div class="box-body">
                                                    <div class="form-group" data-toggle="tooltip" title="Available forms are PDRN, BVR and EVR only">
                                                        <select class="form-control select2" style="width: 100%;" id="btnSelectForm">
                                                            <option selected></option>
                                                            @foreach($tors as $tor)
                                                                <option value="{{ $tor->type_of_request }}">{{ $tor->type_of_request }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    <div class="col-md-4" id="adjustWidthBvr">
                                        <div class="box box-danger">
                                            <div class="box-header with-border">
                                                <h3 class="box-title">Type of Endorsement</h3>
                                            </div>
                                            <div class="box-body" data-toggle="tooltip" title="You can select for new endorsement instances or for re-visit account">
                                                <div class="form-group">

                                                    <label class="radio-inline">
                                                        <input checked type="radio" class="flat-red" name="optradio1" id='NewEndorsement'>New Endorsement
                                                    </label>

                                                    <label class="radio-inline">
                                                        <input type="radio" class="flat-red" name="optradio1" id="ReVisit">Re-Visit
                                                    </label>

                                                    <label class="radio-inline" id="otherAddressHide">
                                                        <input type="radio" class="flat-red" name="optradio1" id="otherAddress">Other Address
                                                    </label>

                                                    <label class="radio-inline" id="otherBranchHide">
                                                        <input type="radio" class="flat-red" name="optradio1" id="otherBranch">Other Branches
                                                    </label>

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="box box-danger">
                                            <div class="box-header with-border">
                                                <h3 class="box-title">Type of Subject</h3>
                                            </div>
                                            <div class="box-body" data-toggle="tooltip" title="You can select if the endorsement is for main subject or subjects co-borrower/maker">
                                                <div class="form-group">
                                                    <label class="radio-inline">
                                                        <input checked type="radio" class="flat-red" name="radioBtn2" id='tosSubject' value="SUBJECT">Main Borrower
                                                    </label>
                                                    <label class="radio-inline">
                                                        <input type="radio" name="radioBtn2" class="flat-red" id="tosCob" value="COBORROWER">Co-Borrower
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @if(preg_match('/TFS/', Auth::user()->name) || preg_match('/JACCS/', Auth::user()->name) || preg_match('/ACOM/', Auth::user()->name))
                                    <div class="col-md-3">
                                        <div class="box box-danger">
                                            <div class="box-header with-border">
                                                <h3 class="box-title">Internal Information</h3>
                                            </div>
                                            <div class="box-body" data-toggle="tooltip" title="Input Dealer Name and Contract number.">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="col-md-6">
                                                            <label for="">Dealer Name</label>
                                                            <input type="text" class="" id="dealer_name" name="dealer_name">
                                                        </div>

                                                        <div class="col-md-6">
                                                            <label for="">Contract #</label>
                                                            <input type="text" class="" id="contract_number" name="contract_number">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{--@else--}}
                                    {{--<div class="col-md-3" hidden>--}}
                                        {{--<div class="box box-danger">--}}
                                            {{--<div class="box-header with-border">--}}
                                                {{--<h3 class="box-title">Internal Information</h3>--}}
                                                {{--<small style="color: orange">(Optional)</small>--}}
                                            {{--</div>--}}
                                            {{--<div class="box-body" data-toggle="tooltip" title="Input Dealer Name and Contract number. Optional">--}}
                                                {{--<div class="row">--}}
                                                    {{--<div class="col-md-12">--}}
                                                        {{--<div class="col-md-6">--}}
                                                            {{--<label for="">Dealer Name</label>--}}
                                                            {{--<input type="text" class="" id="dealer_name">--}}
                                                        {{--</div>--}}

                                                        {{--<div class="col-md-6">--}}
                                                            {{--<label for="">Contract #</label>--}}
                                                            {{--<input type="text" class="" id="contract_number">--}}
                                                        {{--</div>--}}
                                                    {{--</div>--}}
                                                {{--</div>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                    @endif

                                    <div class="col-md-12">
                                    </div>

                                    <div class="col-md-3" id="nameOfCob" style="display: none;">
                                        <div class="box box-danger">
                                            <div class="box-header with-border">
                                                <h3 class="box-title">Name of the Borrower</h3>
                                            </div>
                                            <div class="box-body">
                                                <div class="form-group">
                                                    <input type="text" class="form-control" data-toggle="tooltip" name="" title="Please input Subject Name" id="txtSubjectName" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col-md-12">

                                        <input type="hidden" id="clientName" value="{{ Auth::user()->name }}">
                                        <input type="hidden" value="{{ csrf_token() }}" id="_token">

                                        <div id="formContent">
                                            {{--FORM CONTENT HERE--}}
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane" id="tab_2-2">
                            <div class = "row">



                                <div class="col-md-2">
                                    <div class = "box box-warning">
                                        <div class = "row" style = "padding-top : 10px;">
                                            <div class = "col-md-12">

                                                <h4 style = "text-align: center;">Download Template</h4>

                                                <div class = "row" style = "padding-top : 25px; padding-bottom : 15px;" >
                                                    <div class = "col-md-2"></div>
                                                    <div class = "col-md-8">
                                                        <button type = "button" id ="downloadBiBulk" class = "btn btn-md btn-block btn-info"><i class = "fa fa-fw fa-download"></i> BULK TEMPLATE</button><span id = "downTemp" hidden></span>
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
                                                <input type="file" id="bulk_endorsement_excel_client">
                                            </div>
                                            <div class = "col-md-3"></div>
                                        </div>

                                        <div class = "row" style = "padding-top : 30px; padding-bottom : 20px;">
                                            <div class = "col-md-4"></div>
                                            <div class = "col-md-4">
                                                <button type = "button" id ="btnTestClientUpload" class = "btn btn-md btn-success"><i class = "fa fa-fw fa-upload"></i> UPLOAD EXCEL</button>
                                            </div>
                                            <div class = "col-md-4"></div>
                                        </div>
                                    </div>
                                </div>



                                {{--<div class ="col-md-2">--}}
                                    {{--<h3>Upload Endorsement</h3><br><small style="color:red;">Note: Excel Only</small>--}}
                                    {{--<input type="file" id="bulk_endorsement_excel_client">--}}
                                {{--</div>--}}
                                {{--<div class ="col-md-8">--}}

                                {{--</div>--}}
                                {{--<div class = "col-md-2">--}}
                                    {{--<h3 style = "text-align: center">Bulk Template</h3>--}}
                                    {{--<button class="btn btn-md btn-block btn-info" id = "downloadBiBulk"><i class="fa fa-fw fa-download" ></i> Download Template</button><span id = "downTemp" hidden></span>--}}
                                {{--</div>--}}
                            </div>

                            {{--<div style="padding-top:30px;">--}}
                                {{--<button id="btnTestClientUpload" class="btn btn-md btn-success pull-left" style="margin-right: 10px;">SHOW DATA</button>--}}
                                {{--<button id="btnTestClientBulk" class="btn btn-md btn-warning pull-right">UPDATE FIELD</button>--}}
                            {{--</div>--}}


                            <div class= "row">
                                <div class = "col-md-12">
                                    <button type = "button" id = "btnTestClientBulk" class="btn btn-md btn-warning pull-right"><i class = "fa fa-fw fa-save"></i> SAVE UPDATED</button>
                                </div>
                            </div>


                            <div class="row" style ="padding-top:40px;" id = "excelInfoHide" hidden>
                                <div class="col-md-12">
                                    <h5 style = "margin-bottom: 15px;">Note : To modify the data from the excel, double click the specific text box to edit.</h5>
                                    <div style = "height: auto; overflow: scroll">
                                        <table class="tableendorse table-hover table-condensed" width="100%" id="testExcelTable">
                                        </table>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div id = "alert_show" hidden class="alert alert-danger alert-dismissible">
                                        {{--<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>--}}
                                        <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                                        <span id = "alert_text"></span>
                                        <br>
                                        Note : *To modify the data from the excel, double click the specific text box to edit.
                                        <br>
                                        *Please remove specific row if double endorsed
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <button class ="btn btn-info btn-md pull-left" id="clearFieldsBulkd">CLEAR FIELDS</button>
                                    <button class ="btn btn-primary btn-md pull-right" id="btnSaveEditBulk">SUBMIT</button>
                                </div>
                            </div>
                            <div class="row" style ="padding-top: 20px;">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

{{--SUCCESS MODAL--}}
<div class="modal modal-success fade" id="modal-sentsuccess">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Success!</h4>
            </div>
            <div class="modal-body">
                <p style="text-align: center">Account Successfully Sent</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-right" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

{{--FILL UP ERROR MODAL--}}
<div class="modal modal-danger fade" id="modal-filluperror">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Error 500!</h4>
            </div>
            <div class="modal-body">
                <p style="text-align: center">Please fill up all necessary field/s</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-right" data-dismiss="modal" id="btnModalCloseFillUpError">Close</button>
            </div>
        </div>
    </div>
</div>

{{--SENDING MODAL--}}
<div class="modal modal-info fade" id="modal-sendingrequest">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Sending...</h4>
            </div>
            <div class="modal-body">
                <p style="text-align: center">Please wait while request is being sent.  <img src="{{ asset('dist/img/loading.gif') }}" style="width: 5%;"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-right" data-dismiss="modal" id="btnModalCloseSending">Close</button>
            </div>
        </div>
    </div>
</div>

{{--ERROR SENDING MODAL--}}
<div class="modal modal-success fade" id="modal-errorsending">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Success!</h4>
            </div>
            <div class="modal-body">
                <p style="text-align: center">Account Successfully Sent. However, email dispatching doesn't work, please check your firewall or internet connection.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-right" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
{{--@endsection--}}

{{--@push('leftsidebar')--}}
{{--@include('client.client-leftsidebar')--}}
{{--@endpush--}}

{{--@push('jscript')--}}
{{--<script src="{{ asset('jscript/client.js?n='.$javs) }}"></script>--}}
{{--@endpush--}}