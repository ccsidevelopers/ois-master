<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Dashboard
            <small>Control panel</small>
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">

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
                        <span class="info-box-number" id = "hold_cancelled_count"></span>
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

        <div class="row">
            <!-- Main content -->
            <section class="content">
                <!-- Default box -->
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">History and Status of Endorsed Account</h3>
                    </div>

                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li class="active"><a  id = "tabGeneralMon" href="#tab_aa" data-toggle="tab" class = "bi-client-dash-class">General Endorsement (Monitoring)</a></li>
                            <li class=""><a id="tabSample" href="#tab_b" data-toggle="tab" class = "bi-client-dash-class">Pending Accounts</a></li>
                            <li class=""><a id="tabSample" href="#tab_c" data-toggle="tab" class = "bi-client-dash-class"><span id = "notifFinished"><i class = "fa fa-fw fa-check" style = "color: green;"></i></span>Finished Accounts</a></li>
                            <li class=""><a id="tabSample" href="#tab_d" data-toggle="tab" class = "bi-client-dash-class"><span id = "notifReturned"><i class = "fa fa-fw fa-exclamation" style = "color: orange;"></i></span>Incomplete Attachments</a></li>
                            <li class=""><a id="tabSample" href="#tab_e" data-toggle="tab" class = "bi-client-dash-class">Cancelled Accounts</a></li>
                            {{--<li class=""><a id="tabSample" href="#tab_f" data-toggle="tab" class = "bi-client-dash-class">Hold Accounts</a></li>--}}
                        </ul>
                        <div class = "tab-content">
                            <div class="tab-pane active" id="tab_aa">
                                <div class="box-body">
                                    <div class="box-title">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="box box-danger">
                                                    <div class="box-header with-border">
                                                    </div>
                                                    <div class="box-body">
                                                        <div class="form-group">
                                                            <input type="radio" name="general_client_rad" id="gen_client_all_search" class="client_date_range_click-gen" value="all">
                                                            <label for="gen_client_all_search">All</label>
                                                            <input type="radio" name="general_client_rad" id="gen_client_date_range_search" checked="" class="client_date_range_click-gen" value="date_range">
                                                            <label for="gen_client_date_range_search">Date Range</label>
                                                        </div>
                                                        <div class="form-group" id="gen_client_date_pick_holder">
                                                            <div class="input-group margin" style="" id="">
                                                                <div class="input-group-btn">
                                                                    <label for="" class="btn btn-default">From</label>
                                                                </div>
                                                                <input id="gen_client_min" type="date" class="form-control gen_client_date_range_dates" value="{{date('Y-m-d')}}">
                                                                <div class="input-group-btn">
                                                                    <label for="" class="btn btn-default">To</label>
                                                                </div>
                                                                <input id="gen_client_max" type="date" class="form-control gen_client_date_range_dates" value="{{date('Y-m-d')}}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <table id="bi_client_general_table" class="tableendorse table-hover table-condensed" width="100%">
                                                <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Party #</th>
                                                    <th>Contract #</th>
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
                                                    <th>VERIFY STATUS</th>
                                                    <th>ACTION</th>
                                                </tr>
                                                </thead>
                                                <tfoot>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Party #</th>
                                                    <th>Contract #</th>
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
                                                    <th>VERIFY STATUS</th>
                                                    <th>ACTION</th>
                                                </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane " id="tab_b">
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <table id="bi_client_pending_table" class="tableendorse table-hover table-condensed" width="100%">
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
                            </div>
                            <div class="tab-pane " id="tab_c">
                                <div class="box-body">
                                    <div class="box-title">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="box box-danger">
                                                    <div class="box-header with-border">
                                                    </div>
                                                    <div class="box-body">
                                                        <div class="form-group">
                                                            <input type="radio" name="finished_client_rad" id="fin_client_all_search" class="client_date_range_click" value="all">
                                                            <label for="gen_mon_all_search">All</label>
                                                            <input type="radio" name="finished_client_rad" id="fin_client_date_range_search" checked="" class="client_date_range_click" value="date_range">
                                                            <label for="gen_mon_date_range_search">Date Range</label>
                                                        </div>
                                                        <div class="form-group" id="fin_client_date_pick_holder">
                                                            <div class="input-group margin" style="" id="">
                                                                <div class="input-group-btn">
                                                                    <label for="" class="btn btn-default">From</label>
                                                                </div>
                                                                <input id="fin_client_min" type="date" class="form-control fin_client_date_range_dates" value="{{date('Y-m-d')}}">
                                                                <div class="input-group-btn">
                                                                    <label for="" class="btn btn-default">To</label>
                                                                </div>
                                                                <input id="fin_client_max" type="date" class="form-control fin_client_date_range_dates" value="{{date('Y-m-d')}}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <table id="bi_client_finished_table" class="tableendorse table-hover table-condensed" width="100%">
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
                                                    <th>TURN AROUND TIME</th>
                                                    <th>VERIFY STATUS</th>
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
                                                    <th>TURN AROUND TIME</th>
                                                    <th>VERIFY STATUS</th>
                                                    <th>ACTION</th>
                                                </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                    <div class = "row" style = "padding-top : 20px;" id = "hideShowDlReports" hidden>
                                        <div class = "col-md-12">
                                            <button class = "btn btn-sm btn-success pull-right" id = "downNowMultiRep"><i class = "fa fa-fw fa-download"></i> Download <span id = "dlCountFinished"></span> Report Files </button><span id = "dlNowMulti" hidden></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab_d">
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <table id="bi_client_return_table" class="tableendorse table-hover table-condensed" width="100%">
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
                            </div>
                            <div class="tab-pane" id="tab_e">
                                <div class="row">
                                    <div class="col-md-12">
                                        <table id="bi_client_cancel_table" class="tableendorse display table-hover table-condensed" width="100%">
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
                            <div class="tab-pane" id="tab_f">
                                <div class="row">
                                    <div class="col-md-12">
                                        <table id="bi_client_hold_table" class="tableendorse display table-hover table-condensed" width="100%">
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
            </section>
        </div>
    </section>
</div>