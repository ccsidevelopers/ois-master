{{--@extends('layouts.master')--}}

{{--@section('content')--}}
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" id="management_tables">
        <!-- Content Header (Page header) -->
        <section class="content-header">

        </section>
        <span id="span_download_report"></span>
        <!-- Main content -->
        <section class="content">
            {{--REPORT MODAL--}}
            <div class="modal modal-default fade" id="modal-view-report-manage">
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
            <!-- Default box -->
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Account Tracker</h3>
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
                        <div class="col-md-5">
                            <div class="box box-danger">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Date Range Sorting</h3>
                                </div>
                                <div class="box-body">
                                    <div class="form-group">

                                        <input type="radio" class="viewable_report" name="viewable_report" id="rad_all_report" value="All">All
                                        <input type="radio" class="viewable_report" name="viewable_report" id="rad_daterange_report" value="Date Range">Date Range

                                        <div class="input-group margin date_range_conts_report">
                                            <div class="input-group-btn">
                                                <button type="button" class="btn btn-default">From</button>
                                            </div>
                                            <!-- /btn-group -->
                                            <input type="text" id="datepicker_report" class="form-control min">
                                            <input hidden id="min_report" type="date">

                                            <div class="input-group-btn">
                                                <button type="button" class="btn btn-default">To</button>
                                            </div>
                                            <!-- /btn-group -->
                                            <input type="text" id="datepickermax_report" class="form-control max">
                                            <input hidden id="max_report" type="date">
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div style="overflow-y: scroll;">
                                <table id="list-new-endorsement" class="tableendorse table-condensed table-hover" width="100%">
                                    <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Date Endorsed</th>
                                        <th>Time Endorsed</th>
                                        <th>Account</th>
                                        <th>Address</th>
                                        <th>Requestor</th>
                                        <th>TOR</th>
                                        <th>Municipality</th>
                                        <th>Province</th>
                                        <th>Archipelago</th>
                                        <th>Client</th>
                                        <th>AO Name</th>
                                        <th>CI Name</th>
                                        <th>Dispatcher Name</th>
                                        <th>Entry As</th>
                                        <th>Status</th>
                                        <th>Date Updated</th>
                                        <th>Time Updated</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th>Id</th>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Account
                                        <th>Address</th>
                                        <th>Requestor</th>
                                        <th>TOR</th>
                                        <th>Municipality</th>
                                        <th>Province</th>
                                        <th>Archipelago</th>
                                        <th>Client</th>
                                        <th>AO Name</th>
                                        <th>CI Name</th>
                                        <th>Dispatcher Name</th>
                                        <th>Entry As</th>
                                        <th>Status</th>
                                        <th>Date Updated</th>
                                        <th>Time Updated</th>
                                        <th>Action</th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    Footer
                </div>
                <!-- /.box-footer-->
            </div>
            <!-- /.box -->

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    {{--NOTE MODAL--}}
    <div class="modal modal-default fade" id="modal-dispatcher-view-note">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Add Note</h4>
                </div>
                <div class="modal-body">



                    <span id="txtAreaNote"></span>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    {{--END OF NOTE MODAL--}}

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
                    <table border="2" width="100%" id="history"></table>
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
    {{--@include('management.management-leftsidebar')--}}
{{--@endpush--}}

{{--@push('jscript')--}}
    {{--<script src="{{ asset('jscript/endorsement.js') }}"></script>--}}
{{--@endpush--}}