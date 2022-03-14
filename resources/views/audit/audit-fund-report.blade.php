{{--@extends('layouts.master')--}}

{{--@section('content')--}}

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Fund Report
            <small>Fund Requests</small>
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Fund Audit trails</h3>

                {{--<div class="box-tools pull-right">--}}
                {{--<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"--}}
                {{--title="Collapse">--}}
                {{--<i class="fa fa-minus"></i></button>--}}
                {{--<button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">--}}
                {{--<i class="fa fa-times"></i></button>--}}
                {{--</div>--}}
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-5">
                        <div class="box box-danger">
                            <div class="box-header with-border">
                                <h3 class="box-title">Date Range Sorting</h3>
                            </div>
                            <div class="box-body">
                                <div class="form-group">

                                    <input type="radio" class="viewable" name="viewable_pends" id="rad_all_pends" value="All">All
                                    <input type="radio" class="viewable" name="viewable_pends" id="rad_daterange_pends" value="Date Range">Date Range

                                    <div class="date_range_conts pull-right">
                                        Search Option:
                                        <select id="select_search_option">
                                            <option value="dispatcher_request">Dispatcher Request Date</option>
                                            <option value="sao_approved_date">SAO Approved Date</option>
                                            <option value="finance_approved_date">Finance Approved Date</option>
                                            <option value="finance_sent_date">Finance Sent Date</option>
                                            <option value="finance_confirm_date">Finance Confirm Date</option>
                                        </select>
                                    </div>

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
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div style = "overflow:scroll; height:100%;">
                            <table id="fund-audit-table-reports" class="display table-hover table-condensed" width="100%">
                                <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Fund Requested By</th><!-- IBAHIN SA QUERY KAPAG EMERGENCY OR NORMAL REQ -->
                                    <th>To FCI</th>
                                    <th>Accounts Covered for this Fund Request</th>
                                    <th>Number of Accounts</th>
                                    <th>Remarks of Requestor</th>
                                    <th>Date/time of Request</th> <!-- IBAHIN SA QUERY KAPAG EMERGENCY OR NORMAL REQ -->
                                    <th>Type Of Fund Request</th>
                                    <th>Request Amount</th>
                                    <th>Approver Name</th>
                                    <th>Remarks of Approver</th>
                                    <th>Date/time of Approved</th>
                                    <th>Approved Amount</th>
                                    <th>Uploaded by Finance</th>
                                    <th>Type Fund</th> <!-- ATM / REMITTANCE -->
                                    <th>Amount Sent</th>
                                    <th>Remittance Info</th>
                                    <th>Bank</th>
                                    <th>Date/Time of Send</th>
                                    <th>Status</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th>Id</th>
                                    <th>Fund Requested By</th>
                                    <th>To FCI</th>
                                    <th>Accounts Covered for this Fund Request</th>
                                    <th>Number of Accounts</th>
                                    <th>Remarks of Requestor</th>
                                    <th>Date/time of Request</th> <!-- IBAHIN SA QUERY KAPAG EMERGENCY OR NORMAL REQ -->
                                    <th>Type Of Fund Request</th>
                                    <th>Request Amount</th>
                                    <th>Approver Name</th>
                                    <th>Remarks of Approver</th>
                                    <th>Date/time of Approved</th>
                                    <th>Approved Amount</th>
                                    <th>Uploaded by Finance</th>
                                    <th>Type Fund</th> <!-- ATM / REMITTANCE -->
                                    <th>Amount Sent</th>
                                    <th>Remittance Info</th>
                                    <th>Bank</th>
                                    <th>Date/Time of Send</th>
                                    <th>Status</th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
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

{{--VIEW FUND LOGS INFO MODAL--}}
<div class="modal fade" id="modal-view-fund-logs">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">FUND REQUEST LOGS</h4>
            </div>
            <div class="modal-body">
                {{--<span class="badge bg-light-blue-gradient"><h5>ENDORSEMENT INFORMATION</h5></span>--}}
                {{--INFO START HERE--}}
                <div style="overflow:scroll; height:300px;">
                    <table border="2" width="100%" id="history_fund"></table>
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