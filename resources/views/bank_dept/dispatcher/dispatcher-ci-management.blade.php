{{--@extends('layouts.master')--}}

{{--@section('content')--}}
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            List of All Endorsement Accounts
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title"></h3>

                {{--<div class="box-tools pull-right">--}}
                {{--<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"--}}
                {{--title="Collapse">--}}
                {{--<i class="fa fa-minus"></i></button>--}}
                {{--<button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">--}}
                {{--<i class="fa fa-times"></i></button>--}}
                {{--</div>--}}
            </div>
            <div class="box-body">
                <div class="panel-body">

                    <div class="row">
                        <div class="col-md-12">
                            <!-- Custom Tabs -->
                            <div class="nav-tabs-custom">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a href="#tab_1" data-toggle="tab">Transfer Accounts</a></li>
                                    <li><a href="#tab_2" data-toggle="tab">C.I Tracker</a></li>
                                    <li><a href="#tab_3" data-toggle="tab">Tab 3</a></li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="tab_1">

                                        {{--<input type="button" class="btn btn-sm btn-danger" value="GENERATE" id="generate">--}}
                                        <div class="row" style="padding-top :15px;">
                                            <div class="col-md-2">
                                                <select id="showWhoDisp" class="form-control" >
                                                    <option value="Show all">Show all dispatched</option>
                                                    <option value="Show only me">Show my dispatched</option>
                                                </select>
                                            </div>
                                            <div class="col-md-10">
                                                <input type="radio" name = "toShowDisp" id ="optionAllShow" checked> All
                                                <input type="radio" name = "toShowDisp" id ="optionDateRange"> Date Range
                                            </div>
                                        </div>
                                        <div class="row" style="padding-top : 20px;" id="showhideDateRangeDispHis" hidden>
                                            <div class="col-md-4">
                                                <div class="row">
                                                    <div class="col-md-5">
                                                        <input type="date" class="form-control dateDisHistoryClass" id = "date1Disp">
                                                    </div>
                                                    <div class="col-md-1"><i class="glyphicon glyphicon-arrow-right"></i></div>
                                                    <div class="col-md-5">
                                                        <input type="date" class="form-control dateDisHistoryClass" id = "date2Disp">
                                                    </div>
                                                    <div class="col-md-1"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-8"></div>

                                        </div>


                                        <div class = "row" style="padding-top : 20px;">
                                            <div class = "col-md-12">
                                                <div style="overflow-x: scroll ">
                                                    <table id="endorsement-table-transfer" class="tableendorse table-hover table-condensed" width="100%">
                                                        <thead>
                                                        <tr>
                                                            <th>Id</th>
                                                            <th>Date Endorsed</th>
                                                            <th>Time Endorsed</th>
                                                            <th>Date Due</th>
                                                            <th>Time Due</th>
                                                            <th>Entry As</th>
                                                            <th>Account Name</th>
                                                            <th>Address</th>
                                                            <th>Type Of Request</th>
                                                            <th>Bank Name</th>
                                                            <th>CI</th>
                                                            <th>City/Municipality</th>
                                                            <th>Province</th>
                                                            <th>Region</th>
                                                            <th>Archipelago</th>
                                                            <th>Action</th>
                                                        </tr>
                                                        </thead>
                                                        <tfoot>
                                                        <tr>
                                                            <th>Id</th>
                                                            <th>Date Endorsed</th>
                                                            <th>Time Endorsed</th>
                                                            <th>Date Due</th>
                                                            <th>Time Due</th>
                                                            <th>Entry As</th>
                                                            <th>Account Name</th>
                                                            <th>Address</th>
                                                            <th>Type Of Request</th>
                                                            <th>Bank Name</th>
                                                            <th>CI</th>
                                                            <th>City/Municipality</th>
                                                            <th>Province</th>
                                                            <th>Region</th>
                                                            <th>Archipelago</th>
                                                            <th>Action</th>
                                                        </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.tab-pane -->
                                    <div class="tab-pane" id="tab_2">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <select class="form-control select2" style="width: 100%;" id="ciCountAccount">
                                                        @foreach($credit_investigators as $credit_investigator)
                                                            <option value="{{ $credit_investigator->id }} {{ old('ciID') }}">{{ $credit_investigator->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <button class="btn btn-sm btn-info" id="btnDisplayAccount">Generate</button>
                                        </div>
                                        <div class="row">
                                            <div id="ciResultCount">

                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.tab-pane -->
                                    <div class="tab-pane" id="tab_3">

                                        <div class="row">
                                            <div class="form-group col-xs-4">
                                                <div class="input-group date">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-calendar"></i>
                                                    </div>
                                                    <input type="text" class="form-control" id="datepickers" name="datepickers" data-inputmask="'alias': 'yyyy-mm-dd'" data-mask value="{{$dateNow->format('Y/m/d')}}">
                                                </div>
                                                <!-- /.input group -->
                                            </div>
                                            <div class="form-group col-xs-4">
                                                <button class="btn btn-info btn-default" id="btnGenerateReport" name="btnGenerateReport">Generate</button>
                                            </div>
                                        </div>

                                        <table id="resultData" class="table table-bordered display" width="100%">
                                            <thead>
                                            <tr>
                                                <th>Account Name</th>
                                                <th>Address</th>
                                            </tr>
                                            </thead>
                                        </table>

                                    </div>
                                    <!-- /.tab-pane -->
                                </div>
                                <!-- /.tab-content -->
                            </div>
                            <!-- nav-tabs-custom -->
                        </div>
                        <!-- /.col -->
                    </div>

                </div>
            </div>

            <!-- /.box-body -->
            <div class="box-footer">
            </div>
            <!-- /.box-footer-->
        </div>
        <!-- /.box -->

    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->


{{--TRANSFER MODAL--}}
<div class="modal fade" id="transfer-modal">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Transfer Account to C.I</h4>

                <input type="hidden" id="ciID">
                <input type="hidden" id="ciName">
                <input type="hidden" id="acctID">
                <input type="hidden" id="acctName">

                <div class="row">
                    <div class="col-md-10">
                        <div class="form-group">
                            <select class="form-control select2" style="width: 100%;" id="ciIDTransfer">
                                <option value="0">--PLEASE SELECT C.I--</option>
                                @foreach($credit_investigators as $credit_investigator)
                                    <option value="{{ $credit_investigator->id }} {{ old('ciID') }}">{{ $credit_investigator->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <input type="button" id="btnTransfer" class="btn btn-sm btn-primary pull-right" value="Transfer">
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
{{--END OF TRANSFER MODAL--}}

{{--UPDATE SUCCESS MODAL--}}
<div class="modal modal-success fade" id="modal-successTransfer">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Success!</h4>
            </div>
            <div class="modal-body">
                <p style="text-align: center">Account Successfully Transferred!</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-right" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
{{--END--}}

{{--DETACH ACCOUNT MODAL--}}
<div class="modal modal-danger fade" id="modal-detach">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Hold Endorsement</h4>
            </div>
            <div class="modal-body">
                <center><p>WARNING: Removing this endorsement account from Credit Investigator will affect also
                        all attach personnel and all finish information of the account. Are you sure you want to remove this endorsement to C.I?</p></center>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-outline" id="btnRemove">Remove</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
{{--END OF DETACH ACCOUNT MODAL--}}

{{--SUCCESS DETACH ACCOUNT MODAL--}}
<div class="modal modal-success fade" id="modal-success-remove-account">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Success!</h4>
            </div>
            <div class="modal-body">
                <center><p style="text-align: center">Account Successfully Remove from Credit Investigator</p></center>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-right" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
{{--END OF SUCCESS DETACH ACCOUNT MODAL--}}

{{--VIEW FULL INFO MODAL--}}
<div class="modal fade" id="otherInfo">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">ENDORSEMENT</h4>
            </div>
            <div class="modal-body">
                <span class="badge bg-light-blue-gradient"><h5>Endorsement Other Information</h5></span>
                {{--COBORROWER HERE--}}
                <table border="2" width="100%" id="otherInfoSpan"></table>
                {{--END OF COBORROWER--}}

                {{--EMPLOYER HERE--}}
                <table border="2" width="100%" id="otherEmployerSpan"></table>
                {{--END OF COBORROWER--}}

                {{--BUSINESS HERE--}}
                <table border="2" width="100%" id="otherBusinessSpan"></table>
                {{--END OF BUSINESS--}}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
{{--END OF VIEW FULL INFO MODAL--}}

{{--UPDATE DATE DUE MODAL--}}
<div class="modal fade" id="dispatch_modal_trans">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Update Time due Account to C.I</h4>

                <div class="row">
                    <div class="form-group col-xs-6">
                        <label>Date Due:</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" class="form-control" id="DateDue_update" data-date-format='yyyy-mm-dd'>
                        </div>
                    </div>

                    <div class="bootstrap-timepicker">
                        <div class="form-group col-xs-6">
                            <label>Time Due:</label>
                            <div class="input-group">
                                <input type="text" id="TimeDue_update" class="form-control timepicker" value="{{ $time }}">
                                <div class="input-group-addon">
                                    <i class="fa fa-clock-o"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <input type="button" id="btnDispatch_update" class="btn btn-sm btn-primary pull-right" value="Update">
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
{{--END OF UPDATE DATE DUE--}}


{{--@endsection--}}

{{--@push('leftsidebar')--}}
{{--@include('bank_dept.dispatcher.dispatcher-leftsidebar')--}}
{{--@endpush--}}

{{--@push('jscript')--}}

{{--<script src="https://cdn.datatables.net/buttons/1.5.0/js/dataTables.buttons.min.js"></script>--}}
{{--<script src="https://cdn.datatables.net/buttons/1.5.0/js/buttons.flash.min.js"></script>--}}
{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>--}}
{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>--}}
{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>--}}
{{--<script src="https://cdn.datatables.net/buttons/1.5.0/js/buttons.html5.min.js"></script>--}}
{{--<script src="https://cdn.datatables.net/buttons/1.5.0/js/buttons.print.min.js"></script>--}}


{{--<link rel="stylesheet" href="https://cdn.datatables.net/responsive/1.0.7/css/responsive.dataTables.min.css">--}}
{{--<script src="https://cdn.datatables.net/responsive/2.1.1/js/dataTables.responsive.min.js"></script>--}}

{{--<script src="{{ asset('jscript/dispatcher.js') }}"></script>--}}
{{--<script src="{{ asset('jscript/dispatcher-ci-management.js') }}"></script>--}}
{{--<script src="{{ asset('jscript/idle/jquery.idle.js') }}"></script>--}}
{{--<script src="{{ asset('jscript/detect-user-idle.js') }}"></script>--}}
{{--@endpush--}}