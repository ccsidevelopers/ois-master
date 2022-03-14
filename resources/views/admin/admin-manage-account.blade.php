@extends('admin.template.master')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                <small>Account Management Panel</small>
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">

            <!-- Default box -->
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">User Management Panel</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                                title="Collapse">
                            <i class="fa fa-minus"></i></button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                            <i class="fa fa-times"></i></button>
                    </div>
                </div>

                <div class="box-body">
                    <div class="box-body col-md-12">
                        <div class="nav-tabs-custom">
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#tab_acc_admin_1"  data-toggle="tab" >Bank</a></li>
                                <li class=""><a href="#tab_acc_admin_2"  data-toggle="tab" >B.I</a></li>
                            </ul>
                        </div>
                        <div class = "tab-content">
                            <div class="tab-pane active" id="tab_acc_admin_1">
                                <div class="box box-danger">
                                    <div class="row" style="padding-top : 20px;">
                                        <div class="col-md-12">
                                            <table id="tableManageAccount" width="100%" class="table table-bordered table-striped">
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
                                                    <th>Province</th>
                                                    <th>Client</th>
                                                    <th>Action</th>
                                                </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab_acc_admin_2">
                                <div class="box box-danger">
                                    <div class="row" style="padding-top : 20px;">
                                        <div class="col-md-12">
                                            <table id="tableManageAllBIaccounts" class="tableendorse display table-hover table-condensed" width="100%">
                                                <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>DATE/TIME ENDORSED</th>
                                                    <th>PROJECT/ACCOUNT</th>
                                                    <th>ACCOUNT NAME</th>
                                                    <th>DATE/TIME DUE</th>
                                                    <th>ACTION</th>
                                                </tr>
                                                </thead>
                                                <tfoot>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>DATE/TIME ENDORSED</th>
                                                    <th>PROJECT/ACCOUNT</th>
                                                    <th>ACCOUNT NAME</th>
                                                    <th>DATE/TIME DUE</th>
                                                    <th>ACTION</th>
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
        </section>
        <!-- /.content -->
    </div>



    {{--DETACH ACCOUNT MODAL--}}
    <div class="modal modal-danger fade" id="modal-detach">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Hold Endorsement</h4>
                </div>
                <div class="modal-body">
                    <center><p>WARNING: Removing this endorsement account from Credit Investigator will affect also
                            all attach personnel and all finish information of the account. Are you sure you want to remove this endorsement to C.I?</p></center>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-outline" id="btnRemove">Remove</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    {{--END OF DETACH ACCOUNT MODAL--}}

    {{--SUCCESS DETACH ACCOUNT MODAL--}}
    <div class="modal modal-success fade" id="modal-success-remove-account">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Success!</h4>
                </div>
                <div class="modal-body">
                    <center><p style="text-align: center">Account Successfully Remove from Credit Investigator</p></center>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline pull-right" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    {{--END OF SUCCESS DETACH ACCOUNT MODAL--}}

    <div class="modal fade" id="modal-loading-direct-endorse">
        <div class="modal-dialog modal-sm" >
            <div class="modal-content">
                <div class="modal-header" style="background-color: #d9edf7">
                    <h4 class="modal-title" >Edit/Change Date Time Due</h4>
                </div>
                <div class="modal-body">
                    <div class="row" style="padding-top : 20px">
                        <div class="col-md-2"></div>
                        <div class="col-md-8">
                            <label>Time Due:</label>
                            <input type="time" id="time_to_edit_due" class="form-control">
                        </div>
                        <div class="col-md-2"></div>
                    </div>
                    <div class="row" style="padding-top : 10px">
                        <div class="col-md-2"></div>
                        <div class="col-md-8">
                            <label>Date Due:</label>
                            <input type="date" id="date_to_edit_due" class="form-control">
                        </div>
                        <div class="col-md-2"></div>
                    </div>


                </div>
                <div class="modal-footer">
                    <button class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button class="btn btn-success pull-right btnSubmitEndorse" >Submit</button>
                    <button class="btn btn-info pull-right btnClearFieldsTimeDue" >Clear Fields</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
    <!-- /.modal-dialog -->
    </div>

    <!-- /.content-wrapper -->
@endsection

@push('jscript')
    <script src="{{ asset('jscript/admin.js') }}"></script>
@endpush