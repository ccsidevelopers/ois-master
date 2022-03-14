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
                {{--<div class="box-header with-border">--}}
                    {{--<h3 class="box-title"></h3>--}}

                    {{--<div class="box-tools pull-right">--}}
                        {{--<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"--}}
                                {{--title="Collapse">--}}
                            {{--<i class="fa fa-minus"></i></button>--}}
                        {{--<button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">--}}
                            {{--<i class="fa fa-times"></i></button>--}}
                    {{--</div>--}}
                {{--</div>--}}
                <div class="box-body">
                    <div class="panel-body">

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
                                <th>Province</th>
                                <th>Client</th>
                                <th>AO Name</th>
                                <th>CI Name</th>
                                <th>Dispatcher Name</th>
                                <th>Entry As</th>
                                <th>Status</th>
                                <th>Note</th>
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
                                <th>Province</th>
                                <th>Client</th>
                                <th>AO Name</th>
                                <th>CI Name</th>
                                <th>Dispatcher Name</th>
                                <th>Entry As</th>
                                <th>Status</th>
                                <th>Note</th>
                            </tr>
                            </tfoot>
                        </table>


                    </div>
                </div>

                <!-- /.box-body -->
                {{--<div class="box-footer">--}}
                    {{--Footer--}}
                {{--</div>--}}
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
    {{--@include('bank_dept.dispatcher.dispatcher-leftsidebar')--}}
{{--@endpush--}}

{{--@push('jscript')--}}

    {{--<link rel="stylesheet" href="https://cdn.datatables.net/responsive/1.0.7/css/responsive.dataTables.min.css">--}}
    {{--<script src="https://cdn.datatables.net/responsive/2.1.1/js/dataTables.responsive.min.js"></script>--}}

{{--<link rel="stylesheet" href="https://cdn.datatables.net/rowreorder/1.2.0/css/rowReorder.dataTables.min.css">--}}
{{--<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.1.1/css/responsive.dataTables.min.css">--}}
{{--<script src="https://cdn.datatables.net/rowreorder/1.2.0/js/dataTables.rowReorder.min.js"></script>--}}
{{--<script src="https://cdn.datatables.net/responsive/2.1.1/js/dataTables.responsive.min.js"></script>--}}
{{--<script src="{{ asset('jscript/endorsement.js') }}"></script>--}}
{{--<script src="{{ asset('jscript/dispatcher-ci-management.js') }}"></script>--}}
{{--<script src="{{ asset('jscript/dispatcher.js') }}"></script>--}}

{{--@endpush--}}