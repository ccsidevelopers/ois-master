{{--@extends('layouts.master')--}}

{{--@section('content')--}}
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <section class="content-header">
        <h1>
            Dispatch Accounts
        </h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row" style = "padding-bottom : 20px;">
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3>{{ $endorsement }}</h3>

                        <p>New Endorsement Account</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3>99<sup style="font-size: 20px">%</sup></h3>

                        <p>Successful TAT Account</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h3>{{ $overdueAccount }}</h3>

                        <p>Overdue Account</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-red">
                    <div class="inner">
                        <h3>{{ $dueAccount }}</h3>

                        <p>Due Account as of {{ $timeStamp->toFormattedDateString() }}</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
        </div>

        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Endorsement Account</h3>
                {{--<div class="box-tools pull-right">--}}
                {{--<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">--}}
                {{--<i class="fa fa-minus"></i>--}}
                {{--</button>--}}
                {{--<button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">--}}
                {{--<i class="fa fa-times"></i>--}}
                {{--</button>--}}
                {{--</div>--}}
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="">Select Archiepelago:</label>
                            <select id="select_dispt_arch">
                                <option value="">ALL</option>
                                <option value="1">LUZON</option>
                                <option value="2">VISAYAS</option>
                                <option value="3">MINDANAO</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div style="overflow-x: scroll ">
                    <table id="endorsement-table" class="table-condensed display table-hover tableendorse" width="100%">
                        <thead>
                        <tr>
                            <th>Id</th>
                            <th>Date Endorsed</th>
                            <th>Time Endorsed</th>
                            <th>Date Due</th>
                            <th>Time Due</th>
                            <th>Entry As</th>
                            <th>Account Name</th>
                            <th>Type of Request</th>
                            <th>Type of Loan</th>
                            <th>Bank Name</th>
                            <th>Bank Remarks</th>
                            <th>Requestor Name</th>
                            <th>City/Municipality</th>
                            <th>Province</th>
                            <th>Region</th>
                            <th>Archipelago</th>
                            <th>Actions</th>
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
                            <th>Type of Request</th>
                            <th>Type of Loan</th>
                            <th>Bank Name</th>
                            <th>Bank Remarks</th>
                            <th>Requestor Name</th>
                            <th>City/Municipality</th>
                            <th>Province</th>
                            <th>Region</th>
                            <th>Archipelago</th>
                            <th>Actions</th>
                        </tr>
                        </tfoot>
                    </table>
                </div>


                <input type="hidden" id="accountID">
                <input type="hidden" id="accountName">

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

{{--DISPATCH MODAL--}}
<div class="modal fade" id="dispatch_modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Dispatch Account to C.I</h4>

            </div>
            <div class="modal-body">
                <div class="box box-danger">
                    <div class="box-body">
                        <div class="row">
                            <div class="form-group col-xs-12">

                                SAMPLE
                                <div class="col-md-6">
                                    <div class="box box-solid">
                                        <div class="box-header with-border">
                                            <i class="fa fa-info"></i>

                                            <h3 class="box-title">Subjects Information</h3>
                                        </div>
                                        <!-- /.box-header -->
                                        <div class="box-body">
                                            <dl class="dl-horizontal">
                                                <span id="accountInformation"></span>
                                            </dl>
                                        </div>
                                        <!-- /.box-body -->
                                    </div>
                                    <!-- /.box -->
                                </div>

                                <div class="col-md-6">
                                    <div class="box box-solid">
                                        <div class="box-header with-border">
                                            <i class="fa fa-info"></i>
                                            <h3 class="box-title">Co-Maker Information</h3>
                                        </div>
                                        <!-- /.box-header -->
                                        <div class="box-body">
                                            <dl class="dl-horizontal">
                                                <span id="subjComaker"></span>
                                            </dl>
                                        </div>
                                        <!-- /.box-body -->
                                    </div>
                                    <!-- /.box -->
                                </div>
                                END SAMPLE

                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-xs-12">

                                SAMPLE
                                <div class="col-md-12">
                                    <div class="box box-solid">
                                        <div class="box-header with-border">
                                            <i class="fa fa-info"></i>

                                            <h3 class="box-title">Employer / Business Information</h3>
                                        </div>
                                        <!-- /.box-header -->
                                        <div class="box-body">
                                            <dl class="dl-horizontal">
                                                <span id="evrInfo"></span>
                                                <span id="bvrInfo"></span>
                                            </dl>
                                        </div>
                                        <!-- /.box-body -->
                                    </div>
                                    <!-- /.box -->
                                </div>
                                END SAMPLE

                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12" id="additional_note_from_client" hidden>
                                <div class="form-group col-xs-12">
                                    <label for="">ADDITIONAL NOTE FROM CLIENT:</label>
                                    <textarea name="" id="dispatch_additional_client_note" rows="5" class="form-control" disabled></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-xs-3">
                                <label>Date Due:</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" class="form-control datepicker" id="DateDue" data-date-format='yyyy-mm-dd'>
                                </div>
                            </div>

                            <div class="bootstrap-timepicker">
                                <div class="form-group col-xs-3">
                                    <label>Time Due:</label>
                                    <div class="input-group">
                                        <input type="text" id="TimeDue" class="form-control timepicker">
                                        <div class="input-group-addon">
                                            <i class="fa fa-clock-o"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>FCIs Name:</label>
                                    <select class="form-control select2" style="width: 100%;" id="ciID_dispatch">
                                        <option value="0">--PLEASE SELECT C.I--</option>
                                        @foreach($credit_investigators as $credit_investigator)
                                            <option value="{{ $credit_investigator->id }} {{ old('ciID') }}">{{ strtoupper($credit_investigator->name) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Actions:</label>
                                    <input type="button" id="btnDispatch" class="btn btn-xs btn-primary pull-right form-control" value="Dispatch">
                                </div>
                            </div>



                        </div>
                    </div>
                    <div id="toOverlayDisp">

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
{{--END OF DISPATCH MODAL--}}

{{--CANCEL MODAL--}}
<div class="modal modal-danger fade" id="modal-cancel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Cancellation of Endorsement</h4>
            </div>
            <div class="modal-body">
                <center><p>Are you sure you want to cancel this endorsement?</p></center>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-outline" id="btnCancel">Cancel Endorsement</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
{{--END OF CANCEL MODAL--}}

{{--HOLD MODAL--}}
<div class="modal modal-warning fade" id="modal-hold">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Hold Endorsement</h4>
            </div>
            <div class="modal-body">
                <center><p>Are you sure you want to hold this endorsement?</p></center>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-outline" id="btnHold">Hold Endorsement</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
{{--END OF HOLD MODAL--}}

{{--UNCANCEL MODAL--}}
<div class="modal modal-danger fade" id="modal-uncancel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Cancellation of Endorsement</h4>
            </div>
            <div class="modal-body">
                <center><p>Are you sure you want to uncancel this endorsement?</p></center>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-outline" id="btnUncancel">Uncancel Endorsement</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
{{--END OF UNCANCEL MODAL--}}

{{--UNHOLD MODAL--}}
<div class="modal modal-warning fade" id="modal-unhold">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Hold Endorsement</h4>
            </div>
            <div class="modal-body">
                <center><p>Are you sure you want to Unhold this endorsement?</p></center>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-outline" id="btnUnhold">Unhold Endorsement</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
{{--END OF UNHOLD MODAL--}}

{{--SUCCESS CANCEL/HOLD MODAL--}}
<div class="modal modal-success fade" id="modal-success-change-status">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Success!</h4>
            </div>
            <div class="modal-body">
                <p style="text-align: center">Account Successfully Change Status</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-right" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
{{--END OF SUCCESS CANCEL/HOLD MODAL--}}

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
                {{--PDRN ADDRESS HERE--}}
                <table border="2" width="100%" id="otherPersonalSpan"></table>
                {{--END OF PDRN ADDRESS--}}

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

{{ csrf_field() }}
<!-- /.content-wrapper -->


{{--@endsection--}}

{{--@push('leftsidebar')--}}
{{--@include('bank_dept.dispatcher.dispatcher-leftsidebar')--}}
{{--@endpush--}}

{{--@push('jscript')--}}
{{--BUTTONS TO EXPORT DATATABLES--}}
{{--<script src="https://cdn.datatables.net/buttons/1.4.0/js/dataTables.buttons.min.js"></script>--}}
{{--<script src="https://cdn.datatables.net/buttons/1.4.0/js/buttons.flash.min.js"></script>--}}
{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>--}}
{{--<script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/pdfmake.min.js"></script>--}}
{{--<script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/vfs_fonts.js"></script>--}}
{{--<script src="https://cdn.datatables.net/buttons/1.4.0/js/buttons.html5.min.js"></script>--}}
{{--<script src="https://cdn.datatables.net/buttons/1.4.0/js/buttons.print.min.js"></script>--}}

{{--MOBILE RESPONSIVE DEPENDENCIES--}}
{{--<link rel="stylesheet" href="https://cdn.datatables.net/rowreorder/1.2.0/css/rowReorder.dataTables.min.css">--}}
{{--<script src="https://cdn.datatables.net/rowreorder/1.2.0/js/dataTables.rowReorder.min.js"></script>--}}
{{--<link rel="stylesheet" href="https://cdn.datatables.net/responsive/1.0.7/css/responsive.dataTables.min.css">--}}
{{--<script src="https://cdn.datatables.net/responsive/2.1.1/js/dataTables.responsive.min.js"></script>--}}


{{--<script src="{{ asset('jscript/dispatcher.js') }}"></script>--}}
{{--@endpush--}}