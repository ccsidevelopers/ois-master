<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Accounts
        </h1>
    </section>
    <section class = "content">
        <div class="row" style = "padding-bottom : 20px;">

            <div class="col-md-4">
                <div class="info-box">
                    <span class="info-box-icon bg-aqua"><i class="fa fa-envelope-o"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">General Endorsements</span>
                        <span class="info-box-number" id = "gen_endorse_count"></span>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="info-box">
                    <span class="info-box-icon bg-yellow"><i class="fa fa-fw fa-spinner"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Pending Accounts</span>
                        <span class="info-box-number" id = "pending_account_count"></span>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="info-box">
                    <span class="info-box-icon bg-green"><i class="fa fa-check-square"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Sent Account/Finish Account</span>
                        <span class="info-box-number" id = "finished_count"></span>
                    </div>
                </div>
            </div>

            {{--<div class="col-md-3">--}}
                {{--<div class="info-box">--}}
                    {{--<span class="info-box-icon bg-orange"><i class="fa fa-fw fa-hand-stop-o"></i></span>--}}
                    {{--<div class="info-box-content">--}}
                        {{--<span class="info-box-text">On-Hold/Cancelled Accounts</span>--}}
                        {{--<span class="info-box-number" id = "hold_cancelled_count">(Not Available)</span>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}

            {{--<div class="col-md-2">--}}
                {{--<div class="info-box">--}}
                    {{--<span class="info-box-icon bg-red"><i class="fa fa-fw fa-refresh"></i></span>--}}

                    {{--<div class="info-box-content">--}}
                        {{--<span class="info-box-text">Returned Accounts</span>--}}
                        {{--<span class="info-box-number" id = "returned_account_count"></span>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
        </div>
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a id="tabA" href="#cc_tele_assigned" data-toggle="tab" class = "cc_tele_accounts_tab">Assigned Accounts</a></li>
                <li class=""><a id="tabB" href="#cc_tele_finished" data-toggle="tab" class = "cc_tele_accounts_tab">Sent Account/Finish Account</a></li>
            </ul>
            <div class = "tab-content">
                <div class="tab-pane active" id="cc_tele_assigned">
                    <div class="row">
                        <div class="col-md-12">
                            <table id="cc_tele_accounts_table" class="tableendorse display table-hover table-condensed" width="100%">
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

                <div class="tab-pane" id="cc_tele_finished">
                    <div class="row">
                        <div class="col-md-12">
                            <table id="cc_tele_finished_accounts" class="tableendorse display table-hover table-condensed" width="100%">
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
        </div>
    </section>
</div>