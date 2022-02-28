{{--@extends('layouts.master')--}}
{{--@section('content')--}}

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
           Request Panel
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Request Advance Table</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                            title="Collapse">
                        <i class="fa fa-minus"></i></button>
                </div>
            </div>

            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a id="tab1" href="#tab_a" data-toggle="tab" class = "admin_staff_request_a_class">Ongoing Requests</a></li>
                    <li><a id="tab2" href="#tab_b" data-toggle="tab" class = "admin_staff_request_a_class">Submitted Requests</a></li>
                    <li><a id="tab3" href="#tab_c" data-toggle="tab" class = "admin_staff_request_a_class">On-hold Requests</a></li>
                    <li><a id="tab4" href="#tab_d" data-toggle="tab" class = "admin_staff_request_a_class">Cancelled Requests</a></li>
                </ul>
                <div class="tab-content">

                    <div class="tab-pane active" id="tab_a">
                        <div class="box-body">
                            <div class="col-md-12">
                                <table id="admin-staff-table-reports" class="display table-hover table-condensed" width="100%">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Date and Time</th>
                                        <th>Department</th>
                                        <th>Branch</th>
                                        <th>Requested By</th>
                                        <th>Received By</th>
                                        <th>Item name</th>
                                        <th>Item Description</th>
                                        <th>Item Purpose</th>
                                        <th>Quantity</th>
                                        <th>Supplier</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th>Date and Time</th>
                                        <th>Department</th>
                                        <th>Branch</th>
                                        <th>Requested By </th>
                                        <th>Received By</th>
                                        <th>Item name</th>
                                        <th>Item Description</th>
                                        <th>Item Purpose</th>
                                        <th>Quantity</th>
                                        <th>Supplier</th>
                                        <th>Action</th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>


                    <div class="tab-pane" id="tab_b">
                        <div class="box-body">
                            <div class="col-md-12">
                                <table id="admin-staff-table-submitted" class="display table-hover table-condensed" width="100%">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Date and Time</th>
                                        <th>Department</th>
                                        <th>Branch</th>
                                        <th>Requested By</th>
                                        <th>Received By</th>
                                        <th>Item name</th>
                                        <th>Item Description</th>
                                        <th>Item Purpose</th>
                                        <th>Quantity</th>
                                        <th>Supplier</th>
                                        <th>Status</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th>Date and Time</th>
                                        <th>Department</th>
                                        <th>Branch</th>
                                        <th>Requested By </th>
                                        <th>Received By</th>
                                        <th>Item name</th>
                                        <th>Item Description</th>
                                        <th>Item Purpose</th>
                                        <th>Quantity</th>
                                        <th>Supplier</th>
                                        <th>Status</th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>


                    <div class="tab-pane" id="tab_c">
                        <div class="box-body">
                            <div class="col-md-12">
                                <table id="admin-staff-table-hold" class="display table-hover table-condensed" width="100%">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Date and Time</th>
                                        <th>Department</th>
                                        <th>Branch</th>
                                        <th>Requested By</th>
                                        <th>Received By</th>
                                        <th>Item name</th>
                                        <th>Item Description</th>
                                        <th>Item Purpose</th>
                                        <th>Quantity</th>
                                        <th>Supplier</th>
                                        <th>Status</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th>Date and Time</th>
                                        <th>Department</th>
                                        <th>Branch</th>
                                        <th>Requested By </th>
                                        <th>Received By</th>
                                        <th>Item name</th>
                                        <th>Item Description</th>
                                        <th>Item Purpose</th>
                                        <th>Quantity</th>
                                        <th>Supplier</th>
                                        <th>Status</th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>


                    <div class="tab-pane" id="tab_d">
                        <div class="box-body">
                            <div class="col-md-12">
                                <table id="admin-staff-table-cancel" class="display table-hover table-condensed" width="100%">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Date and Time</th>
                                        <th>Department</th>
                                        <th>Branch</th>
                                        <th>Requested By</th>
                                        <th>Received By</th>
                                        <th>Item name</th>
                                        <th>Item Description</th>
                                        <th>Item Purpose</th>
                                        <th>Quantity</th>
                                        <th>Supplier</th>
                                        <th>Status</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th>Date and Time</th>
                                        <th>Department</th>
                                        <th>Branch</th>
                                        <th>Requested By </th>
                                        <th>Received By</th>
                                        <th>Item name</th>
                                        <th>Item Description</th>
                                        <th>Item Purpose</th>
                                        <th>Quantity</th>
                                        <th>Supplier</th>
                                        <th>Status</th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>




                </div>
            <div class="box-footer">
                <center> Comprehensive Credit Services Inc.</center>
            </div>



                {{--SUCCESS MODAL--}}
                <div class="modal modal-success fade" id="modal-submitsuccess">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Success!</h4>
                            </div>
                            <div class="modal-body">
                                <p style="text-align: center">Successfully Submitted!</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline pull-right" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>

                {{--HOLD MODAL--}}
                <div class="modal modal-warning fade" id="modal-hold">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Notice!</h4>
                            </div>
                            <div class="modal-body">
                                <p style="text-align: center">Request status is On-Hold!</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline pull-right" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>




                {{--CANCEL MODAL--}}

                <div class="modal modal-danger fade" id="modal-cancel">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Notice!</h4>
                            </div>
                            <div class="modal-body">
                                <p style="text-align: center">Request Cancelled!</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline pull-right" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>


        </div>
        </div>
    </section>
</div>

<!-- /.content-wrapper -->

{{--@endsection--}}

{{--@push('leftsidebar')--}}

{{--@push('leftsidebar')--}}

{{--@include('admin_staff.admin-staff-leftsidebar')--}}

{{--@endpush--}}

{{--@push('jscript')--}}
{{--<script src="{{ asset('jscript/admin-data-management.js') }}"></script>--}}
{{--@endpush--}}
