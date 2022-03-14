{{--@extends('layouts.master')--}}

{{--@section('content')--}}

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">

        </section>

        <!-- Main content -->
        <section class="content">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Fund Audit Trailing</h3>
                </div>

                <div class="box-body">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="nav-tabs-custom">
                                    <ul class="nav nav-tabs">
                                        <li class="active">
                                            <a href="#tab1" id="clicktab1" data-toggle="tab">Fund Requests Logs
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#tab2" id="clicktab2" data-toggle="tab">C.I Expenses Logs</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="tab1">
                                            <table id="fund-audit-table" class="table-condensed table-hover" width="100%">
                                                <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Fund ID</th>
                                                    <th>Name</th>
                                                    <th>Position</th>
                                                    <th>Branch</th>
                                                    <th>Activities</th>
                                                    <th>Date Occurred</th>
                                                    <th>Time Occurred</th>
                                                </tr>
                                                </thead>
                                                <tfoot>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Fund ID</th>
                                                    <th>Name</th>
                                                    <th>Position</th>
                                                    <th>Branch</th>
                                                    <th>Activities</th>
                                                    <th>Date Occurred</th>
                                                    <th>Time Occurred</th>
                                                </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                        <div class="tab-pane" id="tab2">
                                            <table id="ci-expense-table" class="display table-hover table-condensed" width="100%">
                                                <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>C.I Name</th>
                                                    <th>Endorsement ID</th>
                                                    <th>Account Name</th>
                                                    <th>Declared Expenses<br> (label/amount/type)</th>
                                                    <th>Total Amount</th>
                                                    <th>Shell Card</th>
                                                    <th>Date Time</th>
                                                    <th>C.I Note</th>
                                                    <th>Action</th>
                                                </tr>
                                                </thead>
                                                <tfoot>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>C.I Names</th>
                                                    <th>Endorsement ID</th>
                                                    <th>Account Name</th>
                                                    <th>Declared Expenses</th>
                                                    <th>Total Amount</th>
                                                    <th>Shell Card</th>
                                                    <th>Date Time</th>
                                                    <th>C.I Note</th>
                                                    <th>Action</th>
                                                </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

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
            </div>
            {{--END OF VIEW FUND LOGS INFO MODAL--}}

        </section>
        <!-- /.content -->
    </div>

    <!-- /.content-wrapper -->

{{--@endsection--}}

{{--@push('leftsidebar')--}}
    {{--@include('management.management-leftsidebar')--}}
{{--@endpush--}}

{{--@push('jscript')--}}
    {{--<script src="{{ asset('jscript/management.js') }}"></script>--}}
{{--@endpush--}}