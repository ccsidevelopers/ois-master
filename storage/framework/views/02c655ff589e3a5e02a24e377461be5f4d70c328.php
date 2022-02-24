



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
                <h3 class="box-title">Audit trails</h3>

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
                        <div style = "overflow:scroll; height:100%">
                          <table id="sao-audit-table-reports" class="tableendorse table-hover table-condensed" width="100%">
                        <thead>
                        <tr>
                            <th>Id</th>
                            <th>Bank</th>
                            <th>Date Endorsed</th>
                            <th>Time Endorsed</th>
                            <th>Time Due</th>
                            <th>Date Due</th>
                            <th>Requestor</th>
                            <th>Account</th>
                            <th>Address</th>
                            <th>City/Municipality</th>
                            <th>Province</th>
                            <th>Archipelago</th>
                            <th>T.O.R</th>
                            <th>Internal Status Field Work</th>
                            <th>Internal Status Office Work</th>
                            <th>Verify Through</th>
                            <th>Dispatcher Name</th>
                            <th>S.A.O Name</th>
                            <th>A.O Name</th>
                            <th>C.I Name</th>
                            <th>Date/Time Dispatched to C.I</th>
                            <th>Date/Time Assigned to A.O</th>
                            <th>Date/Time C.I Reported</th>
                            <th>Date/Time A.O Sent to Client</th>
                            <th>Date/Time C.I Visit</th>
                            <th>External Status</th>
                            <th>Time Dispatcher</th>
                            <th>Time SAO</th>
                            <th>Time CI</th>
                            <th>Time AO</th>
                            <th>Certified</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>Id</th>
                            <th>Bank</th>
                            <th>Date Endorsed</th>
                            <th>Time Endorsed</th>
                            <th>Time Due</th>
                            <th>Date Due</th>
                            <th>Requestor</th>
                            <th>Account</th>
                            <th>Address</th>
                            <th>City/Municipality</th>
                            <th>Province</th>
                            <th>Archipelago</th>
                            <th>T.O.R</th>
                            <th>Internal Status Field Work</th>
                            <th>Internal Status Office Work</th>
                            <th>Verify Through</th>
                            <th>Dispatcher Name</th>
                            <th>S.A.O Name</th>
                            <th>A.O Name</th>
                            <th>C.I Name</th>
                            <th>Date/Time Dispatched to C.I</th>
                            <th>Date/Time Assigned to A.O</th>
                            <th>Date/Time C.I Reported</th>
                            <th>Date/Time A.O Sent to Client</th>
                            <th>Date/Time C.I Visit</th>
                            <th>External Status</th>
                            <th>Time Dispatcher</th>
                            <th>Time SAO</th>
                            <th>Time CI</th>
                            <th>Time AO</th>
                            <th>Certified</th>
                            <th>Action</th>
                        </tr>
                        </tfoot>
                    </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
            
                
            
            <!-- /.box-footer-->
        </div>
        <!-- /.box -->


        <span id="span_download_report"></span>
        <div class="modal modal-default fade" id="modal-ci-note">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Note</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                        <textarea class="form-control" rows="10" id="ciReport" placeholder="Enter ..." disabled>
                        </textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                        <button type="button" id="exportNote" class="btn btn-primary pull-right">Export to Text File</button>
                    </div>
                </div>
            </div>
        </div>

    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->


















