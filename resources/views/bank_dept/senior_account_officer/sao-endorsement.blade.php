<div class="content-wrapper">
    <section class="content-header">
        <h1>
            List of All Endorsement Accounts
        </h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title"></h3>

            </div>
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