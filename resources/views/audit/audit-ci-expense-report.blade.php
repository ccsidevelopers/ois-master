{{--@extends('layouts.master')--}}

{{--@section('content')--}}

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Expenses Report
                <small>Accounts</small>
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">

            <!-- Default box -->
            <div class="box">

                <div class="box-header with-border">
                    <h3 class="box-title">Expense Audit trails</h3>

                    <table id="table-finance-expenses-report" class="tableendorse table-hover table-condensed" width="100%">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>CREDIT INVESTIGATOR NAME</th>
                            <th>DATE</th>
                            <th>FUND REQUEST AMOUNT</th>
                            <th>TOTAL LIQUIDATED AMOUNT</th>
                            <th>TOTAL UNLIQUIDATED AMOUNT</th>
                            <th>UPLOADER REMARKS</th>
                            <th>AUDIT REMARKS</th>
                            <th>ACTION</th>
                            <th>DISPATCHER DATE</th>
                            <th>SAO DATE</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>CREDIT INVESTIGATOR NAME</th>
                            <th>DATE</th>
                            <th>FUND REQUEST AMOUNT</th>
                            <th>TOTAL LIQUIDATED AMOUNT</th>
                            <th>TOTAL UNLIQUIDATED AMOUNT</th>
                            <th>UPLOADER REMARKS</th>
                            <th>AUDIT REMARKS</th>
                            <th>ACTION</th>
                            <th>DISPATCHER DATE</th>
                            <th>SAO DATE</th>
                        </tr>
                        </tfoot>
                    </table>

                    {{--<h3 class="box-title">Audit trails</h3>--}}

                    {{--<div class="box-tools pull-right">--}}
                        {{--<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"--}}
                                {{--title="Collapse">--}}
                            {{--<i class="fa fa-minus"></i></button>--}}
                        {{--<button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">--}}
                            {{--<i class="fa fa-times"></i></button>--}}
                </div>
                {{--</div>--}}

                {{--<div class="box-body">--}}
                    {{--<div class="row">--}}
                        {{--<div class="col-md-4">--}}
                            {{--<div class="box box-danger">--}}
                                {{--<div class="box-header with-border">--}}
                                    {{--<h3 class="box-title">Sort Option</h3>--}}
                                {{--</div>--}}

                                {{--<div class="box-body">--}}
                                    {{--<div class="form-group">--}}
                                        {{--<input type="radio" id="radio_sort_name" name="sort" class="table_expense_sort minimal-red" checked>Sort By C.I name--}}
                                        {{--<input type="radio" id="radio_sort_provinces" name="sort" class="table_expense_sort minimal-red">Sort By Provinces--}}
                                    {{--</div>--}}
                                {{--</div>--}}

                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="row">--}}
                        {{--<div class="col-md-12">--}}
                            {{--<div style = "overflow:scroll; height:100%">--}}
                                {{--<div id="div_expenses_nosort">--}}
                                    {{--<table id="ci-expense-table-reports" class="display table-hover table-condensed" width="100%">--}}
                                        {{--<thead>--}}
                                        {{--<tr>--}}
                                            {{--<th>ID</th>--}}
                                            {{--<th>C.I Name</th>--}}
                                            {{--<th>Endorsement ID</th>--}}
                                            {{--<th>Account Name</th>--}}
                                            {{--<th>Declared Expenses<br> (label/amount/type)</th>--}}
                                            {{--<th>Total Amount</th>--}}
                                            {{--<th>Shell Card</th>--}}
                                            {{--<th>Date Time</th>--}}
                                            {{--<th>C.I Note</th>--}}
                                            {{--<th>Action</th>--}}
                                        {{--</tr>--}}
                                        {{--</thead>--}}
                                        {{--<tfoot>--}}
                                        {{--<tr>--}}
                                            {{--<th>ID</th>--}}
                                            {{--<th>C.I Names</th>--}}
                                            {{--<th>Endorsement ID</th>--}}
                                            {{--<th>Account Name</th>--}}
                                            {{--<th>Declared Expenses</th>--}}
                                            {{--<th>Total Amount</th>--}}
                                            {{--<th>Shell Card</th>--}}
                                            {{--<th>Date Time</th>--}}
                                            {{--<th>C.I Note</th>--}}
                                            {{--<th>Action</th>--}}
                                        {{--</tr>--}}
                                        {{--</tfoot>--}}
                                    {{--</table>--}}
                                {{--</div>--}}
                                {{--<div id="div_expenses_sort" hidden>--}}
                                    {{--<table id="ci-expense-table-reports-sort" class="display table-hover table-condensed" width="100%">--}}
                                        {{--<thead>--}}
                                        {{--<tr>--}}
                                            {{--<th>ID</th>--}}
                                            {{--<th>Provinces</th>--}}
                                            {{--<th>City Municipality</th>--}}
                                            {{--<th>C.I Name</th>--}}
                                            {{--<th>Endorsement ID</th>--}}
                                            {{--<th>Account Name</th>--}}
                                            {{--<th>Declared Expenses<br> (label/amount/type)</th>--}}
                                            {{--<th>Total Amount</th>--}}
                                            {{--<th>Shell Card</th>--}}
                                            {{--<th>Date Time</th>--}}
                                            {{--<th>C.I Note</th>--}}
                                            {{--<th>Action</th>--}}
                                        {{--</tr>--}}
                                        {{--</thead>--}}
                                        {{--<tfoot>--}}
                                        {{--<tr>--}}
                                            {{--<th>ID</th>--}}
                                            {{--<th>Provinces</th>--}}
                                            {{--<th>City Municipality</th>--}}
                                            {{--<th>C.I Names</th>--}}
                                            {{--<th>Endorsement ID</th>--}}
                                            {{--<th>Account Name</th>--}}
                                            {{--<th>Declared Expenses</th>--}}
                                            {{--<th>Total Amount</th>--}}
                                            {{--<th>Shell Card</th>--}}
                                            {{--<th>Date Time</th>--}}
                                            {{--<th>C.I Note</th>--}}
                                            {{--<th>Action</th>--}}
                                        {{--</tr>--}}
                                        {{--</tfoot>--}}
                                    {{--</table>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
                <!-- /.box-body -->
                <div class="box-footer">
                    {{--Footer--}}
                </div>
                <!-- /.box-footer-->
            <!-- /.box -->

            </div>
        <!-- /.content -->
        </section>
    <!-- /.content-wrapper -->

    {{--VIEW FUND LOGS INFO MODAL--}}
    <div class="modal fade" id="modal-view-expenses-logs">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">EXPENSES LOGS</h4>
                </div>
                <div class="modal-body">
                    {{--<span class="badge bg-light-blue-gradient"><h5>ENDORSEMENT INFORMATION</h5></span>--}}
                    {{--INFO START HERE--}}
                    <div style="overflow:scroll; height:300px;">
                        <table border="2" width="100%" id="history_expenses"></table>
                    </div>
                    {{--END OF INFO--}}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div></div>
    {{--END OF VIEW FUND LOGS INFO MODAL--}}


{{--@endsection--}}

{{--@push('leftsidebar')--}}
    {{--@include('audit.audit-leftsidebar')--}}
{{--@endpush--}}

{{--@push('jscript')--}}
    {{--<script src="https://cdn.datatables.net/buttons/1.5.0/js/dataTables.buttons.min.js"></script>--}}
    {{--<script src="https://cdn.datatables.net/buttons/1.5.0/js/buttons.flash.min.js"></script>--}}
    {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>--}}
    {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>--}}
    {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>--}}

    {{--<script src="https://cdn.datatables.net/buttons/1.5.0/js/buttons.html5.min.js"></script>--}}
    {{--<script src="https://cdn.datatables.net/buttons/1.5.0/js/buttons.print.min.js"></script>--}}

    {{--<script src="{{ asset('jscript/audit.js') }}"></script>--}}
{{--@endpush--}}