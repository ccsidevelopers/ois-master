<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            B.I Reports
            <small>Information</small>
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">B.I Reports Panel</h3>

                
                    
                            
                        
                    
                        
                
            </div>

            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-2">

                        </div>
                        <div class="col-md-8">
                            <table class="table-condensed table-hover bi_report_logs" width="100%" id="bi-report-table">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>CI NAME</th>
                                    <th>DPO ENCODER</th>
                                    <th>CLIENT NAME</th>
                                    <th>SUBJECT NAME</th>
                                    <th>DATE/TIME DUE</th>
                                    <th>DATE/TIME</th>
                                    <th>ACTION</th>
                                </tr>
                                </thead>
                                <tfoot>
                                    <td>ID</td>
                                    <td>CI NAME</td>
                                    <td>DPO ENCODER</td>
                                    <td>CLIENT NAME</td>
                                    <td>SUBJECT NAME</td>
                                    <td>DATE/TIME DUE</td>
                                    <td>DATE/TIME</td>
                                    <td>ACTION</td>
                                </tfoot>
                            </table>
                        </div>
                        <div class="col-md-2">

                        </div>
                    </div>
                </div>
            </div>


            <div class="modal modal-default fade" id="modal_ci_add_bi_note">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span></button>
                            <h5 class="modal-title">Add B.I Report</h5>
                        </div>
                        <div class="modal-body">
                            <textarea class="form-control" id="insert_bi_note" rows="10" style="resize: none;" placeholder="..."></textarea>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                            <button class="btn btn-success pull-right" id="add_bi_note_btn">Submit</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal modal-default fade" id="modal_ci_update_bi_note">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span></button>
                            <h5 class="modal-title">View B.I Report</h5>
                        </div>
                        <div class="modal-body">
                            <textarea class="form-control" id="update_bi_note" rows="10" style="resize: none;" placeholder="..." readonly></textarea>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-sm btn-default pull-left" data-dismiss="modal">Close</button>
                            <a class="btn btn-sm btn-success pull-right" id="download_ci_bi" target="_blank"><i class="glyphicon glyphicon-download-alt"></i>Download Attachment/s</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal modal-default fade" id="modal_bi_note_logs">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span></button>
                            <h5 class="modal-title"><center>B.I Reports Logs</center></h5>
                        </div>
                        <div class="modal-body">
                                <span id="for_bi_logs_table">
                                </span>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-default pull-left" data-dismiss="modal">Close</button>
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