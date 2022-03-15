@extends('admin.template.master')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                <small>File Manager Panel</small>
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">

            <!-- Default box -->
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Company File Manager</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                                title="Collapse">
                            <i class="fa fa-minus"></i></button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                            <i class="fa fa-times"></i></button>
                    </div>
                </div>

                <div class="box-body">
                    <button class="btn btn-danger" id="bulk_bank_end_delete">Bank Bulk Delete</button>
                    <button class="btn btn-danger" id="bulk_bi_end_delete">BI Bulk Delete</button>
                    <div class="box-body col-md-12">
                        <div class="nav-tabs-custom">
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#file_users_manage" data-toggle="tab" id="users_info_tab"><i class="fa fa-user"></i> OIMS Users</a></li>
                                <li class=""><a href="#file_bank_manage" data-toggle="tab" id="bank_info_tab"><i class="fa fa-money"></i> Bank Info</a></li>
                                <li class=""><a href="#file_bi_manage"  data-toggle="tab" id="bi_info_tab"><i class="fa fa-building"></i> B.I Info</a></li>
                            </ul>
                        </div>
                        <div class = "tab-content">
                            <div class="tab-pane active" id="file_users_manage">
                                <div class="box box-danger">
                                    <div class="row" style="padding-top : 20px;">
                                        <div class="col-md-12">
                                            <table id="tableUsersAccountManage" width="100%" class="table table-bordered table-striped">
                                                <thead>
                                                <tr id="header_user">
                                                    <th>#</th>
                                                    <th>Emp_id</th>
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <th>Branch</th>
                                                    <th>Position</th>
                                                    <th>Action</th>
                                                </tr>
                                                </thead>
                                                <tfoot>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Emp_id</th>
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <th>Branch</th>
                                                    <th>Position</th>
                                                    <th>Action</th>
                                                </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="file_bank_manage">
                                <div class="box box-danger">
                                    <div class="row" style="padding-top : 20px;">
                                        <div class="col-md-12">
                                            <table id="tableBankAccountManage" width="100%" class="table table-bordered table-striped">
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
                                                    <th>Files</th>
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
                                                    <th>Files</th>
                                                    <th>Action</th>
                                                </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="file_bi_manage">
                                <div class="box box-danger">
                                    <div class="row" style="padding-top : 20px;">
                                        <div class="col-md-12">
                                            <table id="tableBIAccountManage" class="tableendorse display table-hover table-condensed" width="100%">
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
                            {{--End of Line--}}
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>


    {{--DELETE OIMS USERS ACCOUNT MODAL--}}
    {{--<div class="modal modal-danger fade" id="modal-delete-users-manage">--}}
        {{--<div class="modal-dialog">--}}
            {{--<div class="modal-content">--}}
                {{--<div class="modal-header">--}}
                    {{--<button type="button" class="close" data-dismiss="modal" aria-label="Close">--}}
                        {{--<span aria-hidden="true">&times;</span></button>--}}
                    {{--<h4 class="modal-title">Delete OIMS USER ACCOUNT</h4>--}}
                {{--</div>--}}
                {{--<div class="modal-body">--}}
                    {{--<center><p>WARNING: Removing this users account from users table will affect also--}}
                            {{--all attach personnel and all finish information of the account. Are you sure you want to delete this users to table?</p></center>--}}
                {{--</div>--}}
                {{--<div class="modal-footer">--}}
                    {{--<button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>--}}
                    {{--<button type="button" class="btn btn-outline" id="btnDeleteUsersAccount_manage">Delete</button>--}}
                {{--</div>--}}
            {{--</div>--}}
            {{--<!-- /.modal-content -->--}}
        {{--</div>--}}
        {{--<!-- /.modal-dialog -->--}}
    {{--</div>--}}
    {{--END DELETE OIMS USER ACCOUNT MODAL--}}

    {{--SUCCESS OIMS USER ACCOUNT MODAL--}}
    <div class="modal modal-danger fade" id="modal-delete-users-success">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">SUCCESS</h4>
                </div>
                <div class="modal-body">
                    <center><p>Users Account Successfully remove from Table</p></center>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    {{--END SUCCESS DELETE OIMS USER ACCOUNT MODAL--}}

    {{--DELETE BANK ENDORSEMENTS ACCOUNT MODAL--}}
    {{--<div class="modal modal-danger fade" id="modal-delete-bank-manage">--}}
        {{--<div class="modal-dialog">--}}
            {{--<div class="modal-content">--}}
                {{--<div class="modal-header">--}}
                    {{--<button type="button" class="close" data-dismiss="modal" aria-label="Close">--}}
                        {{--<span aria-hidden="true">&times;</span></button>--}}
                    {{--<h4 class="modal-title">Delete Bank Endorsement</h4>--}}
                {{--</div>--}}
                {{--<div class="modal-body">--}}
                    {{--<center><p>WARNING: Removing this endorsement account from Endorsements table will affect also--}}
                            {{--all attach personnel and all finish information of the account. Are you sure you want to delete this endorsement to table?</p></center>--}}
                {{--</div>--}}
                {{--<div class="modal-footer">--}}
                    {{--<button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>--}}
                    {{--<button type="button" class="btn btn-outline" id="btnDeleteBankEndorse_manage">Delete</button>--}}
                {{--</div>--}}
            {{--</div>--}}
            {{--<!-- /.modal-content -->--}}
        {{--</div>--}}
        {{--<!-- /.modal-dialog -->--}}
    {{--</div>--}}
    {{--END DELETE BANK ENDORSEMENTS ACCOUNT MODAL--}}

    {{--SUCCESS BANK ENDORSEMENTS ACCOUNT MODAL--}}
    <div class="modal modal-danger fade" id="modal-delete-bank-success">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">SUCCESS</h4>
                </div>
                <div class="modal-body">
                    <center><p>Bank Endorsements Successfully remove from Table</p></center>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    {{--END SUCCESS DELETE BANK ENDORSEMENTS ACCOUNT MODAL--}}

    {{--DELETE BI ENDORSEMENTS ACCOUNT MODAL--}}
    <div class="modal modal-danger fade" id="modal-delete-bi-manage">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Delete BI Account Endorsement</h4>
                </div>
                <div class="modal-body">
                    <center><p style="text-align: center">WARNING: Removing this endorsement account from bi_endorsements table will affect also
                            all attach personnel and all finish information of the account. Are you sure you want to delete this endorsement to table?</p></center>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline pull-right" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- /.content-wrapper -->
    {{--END OF DELETE BI ACCOUNT MODAL--}}

    {{--SUCCESS BI ENDORSEMENTS ACCOUNT MODAL--}}
    <div class="modal modal-success fade" id="modal-delete-bi-success">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">SUCCESS</h4>
                </div>
                <div class="modal-body">
                    <center><p>BI Endorsements Successfully remove from Table</p></center>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline pull-left" data-dismiss="modadl">Close</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    {{--END SUCCESS DELETE BI ENDORSEMENTS ACCOUNT MODAL--}}

@endsection

@push('jscript')
    <script src="{{ asset('jscript/admin.js') }}"></script>
@endpush