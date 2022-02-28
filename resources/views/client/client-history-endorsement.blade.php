{{--@extends('layouts.master')--}}



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

            <!-- Default box -->
            <div class="box">

                <div class="box-header with-border">
                    <h3 class="box-title">History and Status of Endorsed Account</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                                title="Collapse">
                            <i class="fa fa-minus"></i></button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                            <i class="fa fa-times"></i></button>
                    </div>
                </div>

                <div class="box-body">

                    <table id="client-history-table" class="tableendorse display table-hover table-condensed" width="100%">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Account Name</th>
                                <th>Date Endorsed</th>
                                <th>Time Endorsed</th>
                                <th>Address</th>
                                <th>City/Municipality</th>
                                <th>Provinces</th>
                                <th>Type of Request</th>
                                <th>Remarks</th>
                                <th>Entry As</th>
                                <th>Status</th>
                                <th>Time</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Id</th>
                                <th>Account Name</th>
                                <th>Date Endorsed</th>
                                <th>Time Endorsed</th>
                                <th>Address</th>
                                <th>City/Municipality</th>
                                <th>Provinces</th>
                                <th>Type of Request</th>
                                <th>Remarks</th>
                                <th>Entry As</th>
                                <th>Status</th>
                                <th>Time</th>
                                <th>Actions</th>
                            </tr>
                        </tfoot>
                    </table>


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
    <div class="modal modal-default fade" id="modal-note">
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
                    <button type="button" class="btn btn-primary" id="btnSaveNote" value="Save Note">Save Note</button>
                    <button type="button" class="btn btn-primary" id="btnUpdateNote" value="Update Note">Update Note</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    {{--END OF NOTE MODAL--}}
{{--@endsection--}}

{{--@push('leftsidebar')--}}
    {{--@include('client.client-leftsidebar')--}}
{{--@endpush--}}

{{--@push('jscript')--}}
    {{--<script src="{{ asset('jscript/client.js?n='.$javs) }}"></script>--}}
{{--@endpush--}}