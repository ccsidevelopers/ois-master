<div class="content-wrapper">
    <section class="content-header">
        <h1>
            CC Senior Account Officer - Accounts
        </h1>
    </section>

    <section class="content">
        <div class="row" style = "padding-bottom : 20px;">

            <div class="col-md-3">
                <div class="info-box">
                    <span class="info-box-icon bg-aqua"><i class="fa fa-envelope-o"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">General Endorsements</span>
                        <span class="info-box-number" id = "gen_endorse_count"></span>
                    </div>
                </div>
            </div>

            <div class="col-md-2">
                <div class="info-box">
                    <span class="info-box-icon bg-yellow"><i class="fa fa-fw fa-spinner"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Pending Accounts</span>
                        <span class="info-box-number" id = "pending_account_count"></span>
                    </div>
                </div>
            </div>

            <div class="col-md-2">
                <div class="info-box">
                    <span class="info-box-icon bg-green"><i class="fa fa-check-square"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Finished Accounts</span>
                        <span class="info-box-number" id = "finished_count"></span>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="info-box">
                    <span class="info-box-icon bg-orange"><i class="fa fa-fw fa-hand-stop-o"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">On-Hold/Cancelled Accounts</span>
                        <span class="info-box-number" id = "hold_cancelled_count">(Not Available)</span>
                    </div>
                </div>
            </div>

            <div class="col-md-2">
                <div class="info-box">
                    <span class="info-box-icon bg-red"><i class="fa fa-fw fa-refresh"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Returned Accounts</span>
                        <span class="info-box-number" id = "returned_account_count"></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="box">
            <div class="box-body">
                <div class="panel-body">
                    <div class="row">
                        <div class= "box-body">
                            <div class="nav-tabs-custom">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a id="tabSample" href="#tab_a" data-toggle="tab" class = "cc_sao_class_tab">New Accounts</a></li>
                                    <li class=""><a id="tabSample" href="#tab_b" data-toggle="tab" class = "cc_sao_class_tab">Acknowledged/Assignation Accounts</a></li>
                                    <li class=""><a id="tabSample" href="#tab_c" data-toggle="tab" class = "cc_sao_class_tab">Update/Transfer Accounts</a></li>
                                    <li class=""><a id="tabSample" href="#tab_d" data-toggle="tab" class = "cc_sao_class_tab">Success Accounts(Complete/Incomplete)</a></li>
                                    <li class=""><a id="tabSample" href="#tab_e" data-toggle="tab" class = "cc_sao_class_tab">Returned Accounts</a></li>
                                    <li class=""><a id="tabSample" href="#tab_f" data-toggle="tab" class = "cc_sao_class_tab">Finished Accounts</a></li>
                                    <li class=""><a id="tabSample" href="#tab_g" data-toggle="tab" class = "cc_sao_class_tab">Cancelled Accounts</a></li>
                                </ul>
                                <div class = "tab-content">
                                    <div class="tab-pane active" id="tab_a">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <table id="cc_sao_accounts_table" class="tableendorse display table-hover table-condensed" width="100%">
                                                    <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>SITE</th>
                                                        <th>TYPE OF REQUEST</th>
                                                        <th>DATE/TIME ENDORSED</th>
                                                        <th>PROJECT/ACCOUNT</th>
                                                        <th>ACCOUNT NAME</th>
                                                        <th>PACKAGE</th>
                                                        <th>TYPES OF CHECK</th>
                                                        <th>REQUESTOR/POC</th>
                                                        <th>ATTACHMENTS</th>
                                                        <th>STATUS</th>
                                                        <th>ACTION</th>
                                                    </tr>
                                                    </thead>
                                                    <tfoot>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>SITE</th>
                                                        <th>TYPE OF REQUEST</th>
                                                        <th>DATE/TIME ENDORSED</th>
                                                        <th>PROJECT/ACCOUNT</th>
                                                        <th>ACCOUNT NAME</th>
                                                        <th>PACKAGE</th>
                                                        <th>TYPES OF CHECK</th>
                                                        <th>REQUESTOR/POC</th>
                                                        <th>ATTACHMENTS</th>
                                                        <th>STATUS</th>
                                                        <th>ACTION</th>
                                                    </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="tab_b">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <table id="cc_sao_acknowledge_table" class="tableendorse display table-hover table-condensed" width="100%">
                                                    <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>SITE</th>
                                                        <th>TYPE OF REQUEST</th>
                                                        <th>DATE/TIME ENDORSED</th>
                                                        <th>PROJECT/ACCOUNT</th>
                                                        <th>ACCOUNT NAME</th>
                                                        <th>PACKAGE</th>
                                                        <th>TYPES OF CHECK</th>
                                                        <th>REQUESTOR/POC</th>
                                                        <th>ATTACHMENTS</th>
                                                        <th>STATUS</th>
                                                        <th>ACTION</th>
                                                    </tr>
                                                    </thead>
                                                    <tfoot>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>SITE</th>
                                                        <th>TYPE OF REQUEST</th>
                                                        <th>DATE/TIME ENDORSED</th>
                                                        <th>PROJECT/ACCOUNT</th>
                                                        <th>ACCOUNT NAME</th>
                                                        <th>PACKAGE</th>
                                                        <th>TYPES OF CHECK</th>
                                                        <th>REQUESTOR/POC</th>
                                                        <th>ATTACHMENTS</th>
                                                        <th>STATUS</th>
                                                        <th>ACTION</th>
                                                    </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane " id="tab_c">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <!--chano-->
                                                <table id="cc_sao_assigned_table" class="tableendorse display table-hover table-condensed" width="100%">
                                                    <thead>
                                                    <tr class="text-uppercase">
                                                        <th>ID</th>
                                                        <th>SITE</th>
                                                        <th>TYPE OF REQUEST</th>
                                                        <th class="bg-danger">date/time endorsed</th>
                                                        <th class="bg-success">updated date/time endorsed</th>
                                                        <th>PROJECT/ACCOUNT</th>
                                                        <th>ACCOUNT NAME</th>
                                                        <th>PACKAGE</th>
                                                        <th>TYPES OF CHECK</th>
                                                        <th>REQUESTOR/POC</th>
                                                        <th>ATTACHMENTS</th>
                                                        <th>STATUS</th>
                                                        <th>ACTION</th>
                                                    </tr>
                                                    </thead>
                                                    <tfoot>
                                                    <tr class="text-uppercase">
                                                        <th>ID</th>
                                                        <th>SITE</th>
                                                        <th>TYPE OF REQUEST</th>
                                                        <th class="bg-danger">date/time endorsed</th>
                                                        <th class="bg-success">updated date/time endorsed</th>
                                                        <th>PROJECT/ACCOUNT</th>
                                                        <th>ACCOUNT NAME</th>
                                                        <th>PACKAGE</th>
                                                        <th>TYPES OF CHECK</th>
                                                        <th>REQUESTOR/POC</th>
                                                        <th>ATTACHMENTS</th>
                                                        <th>STATUS</th>
                                                        <th>ACTION</th>
                                                    </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane " id="tab_d">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <table id="cc_sao_success_table" class="tableendorse display table-hover table-condensed" width="100%">
                                                    <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>SITE</th>
                                                        <th>TYPE OF REQUEST</th>
                                                        <th>DATE/TIME ENDORSED</th>
                                                        <th>PROJECT/ACCOUNT</th>
                                                        <th>ACCOUNT NAME</th>
                                                        <th>REQUESTOR/POC</th>
                                                        <th>STATUS</th>
                                                        <th>VERIFY STATUS</th>
                                                        <th>VERIFY STATUS DETAILS</th>
                                                        <th>ACTION</th>
                                                    </tr>
                                                    </thead>
                                                    <tfoot>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>SITE</th>
                                                        <th>TYPE OF REQUEST</th>
                                                        <th>DATE/TIME ENDORSED</th>
                                                        <th>PROJECT/ACCOUNT</th>
                                                        <th>ACCOUNT NAME</th>
                                                        <th>REQUESTOR/POC</th>
                                                        <th>STATUS</th>
                                                        <th>VERIFY STATUS</th>
                                                        <th>VERIFY STATUS DETAILS</th>
                                                        <th>ACTION</th>
                                                    </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane " id="tab_e">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <table id="cc_sao_return_table" class="tableendorse display table-hover table-condensed" width="100%">
                                                    <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>SITE</th>
                                                        <th>TYPE OF REQUEST</th>
                                                        <th>DATE/TIME ENDORSED</th>
                                                        <th>PROJECT/ACCOUNT</th>
                                                        <th>ACCOUNT NAME</th>
                                                        <th>PACKAGE</th>
                                                        <th>TYPES OF CHECK</th>
                                                        <th>REQUESTOR/POC</th>
                                                        <th>ATTACHMENTS</th>
                                                        <th>STATUS</th>
                                                        <th>ACTION</th>
                                                    </tr>
                                                    </thead>
                                                    <tfoot>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>SITE</th>
                                                        <th>TYPE OF REQUEST</th>
                                                        <th>DATE/TIME ENDORSED</th>
                                                        <th>PROJECT/ACCOUNT</th>
                                                        <th>ACCOUNT NAME</th>
                                                        <th>PACKAGE</th>
                                                        <th>TYPES OF CHECK</th>
                                                        <th>REQUESTOR/POC</th>
                                                        <th>ATTACHMENTS</th>
                                                        <th>STATUS</th>
                                                        <th>ACTION</th>
                                                    </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="tab_f">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <table id="cc_sao_finished_table" class="tableendorse display table-hover table-condensed" width="100%">
                                                    <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>SITE</th>
                                                        <th>TYPE OF REQUEST</th>
                                                        <th>DATE/TIME ENDORSED</th>
                                                        <th>PROJECT/ACCOUNT</th>
                                                        <th>ACCOUNT NAME</th>
                                                        <th>PACKAGE</th>
                                                        <th>TYPES OF CHECK</th>
                                                        <th>REQUESTOR/POC</th>
                                                        <th>ATTACHMENTS</th>
                                                        <th>STATUS</th>
                                                        <th>VERIFY STATUS DETAILS</th>
                                                        <th>ACTION</th>
                                                    </tr>
                                                    </thead>
                                                    <tfoot>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>SITE</th>
                                                        <th>TYPE OF REQUEST</th>
                                                        <th>DATE/TIME ENDORSED</th>
                                                        <th>PROJECT/ACCOUNT</th>
                                                        <th>ACCOUNT NAME</th>
                                                        <th>PACKAGE</th>
                                                        <th>TYPES OF CHECK</th>
                                                        <th>REQUESTOR/POC</th>
                                                        <th>ATTACHMENTS</th>
                                                        <th>STATUS</th>
                                                        <th>VERIFY STATUS DETAILS</th>
                                                        <th>ACTION</th>
                                                    </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="tab_g">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <table id="cc_sao_cancel_table" class="tableendorse display table-hover table-condensed" width="100%">
                                                    <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>SITE</th>
                                                        <th>TYPE OF REQUEST</th>
                                                        <th>DATE/TIME ENDORSED</th>
                                                        <th>PROJECT/ACCOUNT</th>
                                                        <th>ACCOUNT NAME</th>
                                                        <th>PACKAGE</th>
                                                        <th>TYPES OF CHECK</th>
                                                        <th>REQUESTOR/POC</th>
                                                        <th>ACTION</th>
                                                    </tr>
                                                    </thead>
                                                    <tfoot>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>SITE</th>
                                                        <th>TYPE OF REQUEST</th>
                                                        <th>DATE/TIME ENDORSED</th>
                                                        <th>PROJECT/ACCOUNT</th>
                                                        <th>ACCOUNT NAME</th>
                                                        <th>PACKAGE</th>
                                                        <th>TYPES OF CHECK</th>
                                                        <th>REQUESTOR/POC</th>
                                                        <th>ACTION</th>
                                                    </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="tab_h">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <table id="cc_sao_pending_cancel_table" class="tableendorse display table-hover table-condensed" width="100%">
                                                    <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>SITE</th>
                                                        <th>TYPE OF REQUEST</th>
                                                        <th>DATE/TIME ENDORSED</th>
                                                        <th>PROJECT/ACCOUNT</th>
                                                        <th>ACCOUNT NAME</th>
                                                        <th>PACKAGE</th>
                                                        <th>TYPES OF CHECK</th>
                                                        <th>REQUESTOR/POC</th>
                                                        <th>ACTION</th>
                                                    </tr>
                                                    </thead>
                                                    <tfoot>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>SITE</th>
                                                        <th>TYPE OF REQUEST</th>
                                                        <th>DATE/TIME ENDORSED</th>
                                                        <th>PROJECT/ACCOUNT</th>
                                                        <th>ACCOUNT NAME</th>
                                                        <th>PACKAGE</th>
                                                        <th>TYPES OF CHECK</th>
                                                        <th>REQUESTOR/POC</th>
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
            </div>
        </div>
    </section>
    <div class="modal fade" id="update_due_date_modal" style="display: none">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <button type="button" class="close" data-dismiss="modal" aria-label="close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title text-uppercase">
                        <i class="glyphicon glyphicon-pencil margin"></i>
                        Update date/time endorsed
                    </h2>
                </div>
                <div class="modal-body" style="font-size: 18px;">
                    <label for="">Date/Time Endorsed</label>
                    <input id="current_due_date" type="datetime-local">
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger pull-left" data-dismiss="modal">
                        <i class="fa fa-close"></i>
                        Close
                    </button>
                    <button class="btn btn-success pull-right update_new_due_date_modal_btn">
                        <i class="fa fa-check"></i>
                        Update
                    </button>
                </div>
            </div>
        </div>
    </div>
    


<!-- <div class="modal fade" id="update_due_date_logs_modal" style="display: none">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title text-uppercase">
                    <i class="glyphicon glyphicon-pencil margin"></i>
                    Updated date/time endorsed logs
                </h2>
            </div>
            <div class="modal-body" style="font-size: 18px;">
                <table class="table table-bordered table-hover" id="due_date_modal_logs_table">
                    <thead>
                    <tr>
                        <th class=""><i class="fa fa-fw fa-user"></i>User</th>
                        <th class=""><i class="fa fa-fw fa-pencil-square-o"></i>Activities</th>
                        <th class=""><i class="fa fa-fw fa-calendar"></i>Date</th>
                    </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger pull-left" data-dismiss="modal">
                    <i class="fa fa-close"></i>
                    Close
                </button>
            </div>
        </div>
    </div>
</div> -->