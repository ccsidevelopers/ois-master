{{--@extends('layouts.master')--}}

{{--@section('content')--}}

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Audit Report
            <small>Accounts</small>
        </h1>

    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Finance Report</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                            title="Collapse">
                        <i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                        <i class="fa fa-times"></i></button>
                </div>
            </div>
            {{--<div class="box-body">--}}
                {{--<div class = "col-md-5">--}}
                    {{--<div class = "box box-danger">--}}
                        {{--<h3 style = "font-family: Georgia,serif; text-align: center">Add ATM/Card Info</h3>--}}
                        {{--<div class = "row" style = "padding-bottom : 10px;">--}}
                            {{--<div class="col-md-8">--}}
                                {{--<label for="selFCIName">FCI Name:</label>--}}
                                {{--<select style="width: 100%;" class="select2 form-control" id="selFCIName">--}}
                                {{--</select>--}}
                            {{--</div>--}}
                            {{--<div class = "col-md-2"></div>--}}
                            {{--<div class = "col-md-2">--}}
                                {{--<label for="">ID no. :</label>--}}
                                {{--<input type="text" class = "form-control" id = "ci_id_no_form" disabled>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<h4 style = "font-family: Georgia,serif; text-align: center">ATM Details</h4>--}}
                        {{--<div class = "row" style = "padding-top: 20px; padding-bottom: 20px;" >--}}
                            {{--<div class = "col-md-4"></div>--}}
                            {{--<div class = "col-md-4">--}}
                                {{--<button class = "btn btn btn-success" id = "add_bank_ci">Add Bank Information<i class = "fa fa-fw fa-plus"></i></button>--}}
                            {{--</div>--}}
                            {{--<div class = "col-md-2"></div>--}}
                            {{--<div class = "col-md-2">--}}
                                {{--<span id = "removeAllBank"></span>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<span id = "addDetailsBank"></span>--}}
                        {{--<div id = "showShell">--}}

                        {{--</div>--}}

                        {{--<div style = "margin-top : 20px;">--}}
                            {{--<button type = "button" id = "btnSaveCiAtmRem" class = "btn btn-info pull-right">Save Details</button>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div class = "col-md-7">--}}
                    {{--<div class = "box box-danger">--}}
                        {{--<h3 style = "font-family: Georgia,serif; text-align: center">Bank Information for C.I</h3>--}}
                        {{--<div class="col-md-12">--}}
                            {{--<table id = "finance-ci-bank-table" class="tableendorse display table-hover table-condensed" width="100%">--}}
                                {{--<thead>--}}
                                {{--<tr>--}}
                                    {{--<th>C.I ID</th>--}}
                                    {{--<th>C.I Name</th>--}}
                                    {{--<th>Bank Name</th>--}}
                                    {{--<th>Account Number</th>--}}
                                    {{--<th>Gas Limit(Shell Card)</th>--}}
                                    {{--<th>Action</th>--}}
                                {{--</tr>--}}
                                {{--</thead>--}}
                            {{--</table>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}

        </div>
        <!-- /.box -->


    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

{{--UPDATE ATM INFO--}}
<div class="modal modal-default fade" id="modal-finance-update-atm-info">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Update ATM Info</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="selFCINameUpd">FCI Name:</label>
                            <select class="form-control select2" id="selFCINameUpd" style="width: 100%" disabled>
                                @foreach($ciLists as $ciList)
                                    <option value="{{ $ciList->id }}">{{ $ciList->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="txtBankNameUpd">Bank Name:</label>
                            <input type="text" class="form-control" id="txtBankNameUpd" disabled>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="form-group">
                            <label id="label_txtAcctNumUpd" for="txtAcctNumUpd">Account Number:</label>
                            <input type="text" class="form-control" id="txtAcctNumUpd" disabled>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
                <button type="button" id="btnUpdAtmInfos" class="btn btn-primary pull-right" data-dismiss="modal">Update</button>
                <button type="button" id="btnEditAtmInfos" class="btn btn-primary pull-right">Edit</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
{{--END OF UPDATE ATM INFO--}}

{{--@endsection--}}

{{--@push('leftsidebar')--}}
{{--@include('finance.finance-leftsidebar')--}}
{{--@endpush--}}

{{--@push('jscript')--}}
{{--<script src="https://cdn.datatables.net/buttons/1.5.0/js/dataTables.buttons.min.js"></script>--}}
{{--<script src="https://cdn.datatables.net/buttons/1.5.0/js/buttons.flash.min.js"></script>--}}
{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>--}}
{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>--}}
{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>--}}

{{--<script src="https://cdn.datatables.net/buttons/1.5.0/js/buttons.html5.min.js"></script>--}}
{{--<script src="https://cdn.datatables.net/buttons/1.5.0/js/buttons.print.min.js"></script>--}}

{{--<script src="{{ asset('jscript/finance.js') }}"></script>--}}
{{--@endpush--}}