<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            C.I Fund Request
        </h1>

    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="box">
            <div class="box-body">

                <div class="panel-body">

                    <div class="row">
                        <div class="col-md-12">
                            <!-- Custom Tabs -->
                            <div class="nav-tabs-custom">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a href="#tab_1_fund" data-toggle="tab" class = "ci_fund_tab">Pending Requests</a></li>
                                    <li><a href="#tab_2_fund" data-toggle="tab" class = "ci_fund_tab">Approved Requests</a></li>
                                    <li><a href="#tab_3_fund" data-toggle="tab" class = "ci_fund_tab">Disapproved Requests</a></li>
                                </ul>

                                <div class="tab-content">

                                    <div class="tab-pane active" id="tab_1_fund">
                                        <table id="table_fund_req" class="tableendorse table-condensed table-hover" width="100%">
                                            <thead>
                                            <tr>

                                                <th>REQUEST ID</th>
                                                <th>SHOW ACCOUNTS</th>
                                                <th>REQUEST DATE AND TIME</th>
                                                <th>REQUESTOR</th>

                                                <th>(FOR) CREDIT INVESTIGATOR</th>
                                                <th>TYPE OF FUND</th>
                                                <th>AMOUNT</th>
                                                <th>FOR THESE ACCOUNT/S</th>
                                                <th>STATUS</th>
                                            </tr>
                                            </thead>
                                            <tfoot>
                                            <tr>

                                                <th>REQUEST ID</th>
                                                <th>SHOW ACCOUNTS</th>
                                                <th>REQUEST DATE AND TIME</th>
                                                <th>REQUESTOR</th>
                                                <th>(FOR) CREDIT INVESTIGATOR</th>
                                                <th>TYPE OF FUND</th>
                                                <th>AMOUNT</th>
                                                <th>FOR THESE ACCOUNT/S</th>
                                                <th>STATUS</th>
                                            </tr>
                                            </tfoot>
                                        </table>
                                    </div>

                                    <!-- /.tab-pane -->
                                    <div class="tab-pane" id="tab_2_fund">
                                        {{--TABLE STARTS HERE--}}
                                        <table id="table_fund_req_approved" class="tableendorse display table-hover table-condensed" width="100%">
                                            <thead>
                                            <tr>

                                                <th>REQUEST ID</th>
                                                <th>SHOW ACCOUNTS</th>
                                                <th>REQUEST DATE AND TIME</th>
                                                <th>REQUESTOR</th>
                                                <th>(FOR) CREDIT INVESTIGATOR</th>
                                                <th>TYPE OF FUND</th>
                                                <th>AMOUNT</th>
                                                <th>FOR THESE ACCOUNT/S</th>
                                                <th>STATUS</th>
                                            </tr>
                                            </thead>
                                            <tfoot>
                                            <tr>

                                                <th>REQUEST ID</th>
                                                <th>SHOW ACCOUNTS</th>
                                                <th>REQUEST DATE AND TIME</th>
                                                <th>REQUESTOR</th>
                                                <th>(FOR) CREDIT INVESTIGATOR</th>
                                                <th>TYPE OF FUND</th>
                                                <th>AMOUNT</th>
                                                <th>FOR THESE ACCOUNT/S</th>
                                                <th>STATUS</th>
                                            </tr>
                                            </tfoot>
                                        </table>
                                        {{--END OF TABLE--}}

                                    </div>
                                    <!-- /.tab-pane -->
                                    <div class="tab-pane" id="tab_3_fund">
                                        {{--TAB CONTENT #3--}}
                                        <table id="table_fund_req_declined" class="tableendorse table-hover table-condensed" width="100%">
                                            <thead>
                                            <tr>

                                                <th>REQUEST ID</th>
                                                <th>SHOW ACCOUNTS</th>
                                                <th>REQUEST DATE AND TIME</th>
                                                <th>REQUESTOR</th>
                                                <th>(FOR) CREDIT INVESTIGATOR</th>
                                                <th>TYPE OF FUND</th>
                                                <th>AMOUNT</th>
                                                <th>FOR THESE ACCOUNT/S</th>
                                                <th>STATUS</th>
                                            </tr>
                                            </thead>
                                            <tfoot>
                                            <tr>

                                                <th>REQUEST ID</th>
                                                <th>SHOW ACCOUNTS</th>
                                                <th>REQUEST DATE AND TIME</th>
                                                <th>REQUESTOR</th>
                                                <th>(FOR) CREDIT INVESTIGATOR</th>
                                                <th>TYPE OF FUND</th>
                                                <th>AMOUNT</th>
                                                <th>FOR THESE ACCOUNT/S</th>
                                                <th>STATUS</th>
                                            </tr>
                                            </tfoot>
                                        </table>
                                        <!-- /.tab-pane -->
                                    </div>
                                    <!-- /.tab-content -->
                                </div>
                                <!-- nav-tabs-custom -->
                            </div>
                            <!-- /.col -->
                        </div>
                    </div>
                </div>
            </div>


            {{--other details--}}

            <script id="details-template-pending-sao" type="text/x-handlebars-template">
                <div class="label label-info pull-left" style="font-size: 12px">Accounts for this Fund</div>
                <table style="font-size: 15px;" class="tableendorse table details-table" id="sao_pending_posts-@{{id}}">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>ACCOUNT NAME</th>
                        <th>ADDRESS</th>
                        <th>CITY/MUNICIPALITY</th>
                        <th>PROVINCE</th>
                        <th>TYPE OF REQUEST</th>
                        <th>DATE ENDORSED</th>
                    </tr>
                    </thead>
                </table>
            </script>

            <script id="details-template-app-sao" type="text/x-handlebars-template">
                <div class="label label-info pull-left" style="font-size: 12px">Accounts for this Fund</div>
                <table style="font-size: 15px;" class="tableendorse table details-table" id="sao_app_posts-@{{id}}">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>ACCOUNT NAME</th>
                        <th>ADDRESS</th>
                        <th>CITY/MUNICIPALITY</th>
                        <th>PROVINCE</th>
                        <th>TYPE OF REQUEST</th>
                        <th>DATE ENDORSED</th>
                    </tr>
                    </thead>
                </table>
            </script>

            <script id="details-template-dec-sao" type="text/x-handlebars-template">
                <div class="label label-info pull-left" style="font-size: 12px">Accounts for this Fund</div>
                <table style="font-size: 15px;" class="tableendorse table details-table" id="sao_dec_posts-@{{id}}">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>ACCOUNT NAME</th>
                        <th>ADDRESS</th>
                        <th>CITY/MUNICIPALITY</th>
                        <th>PROVINCE</th>
                        <th>TYPE OF REQUEST</th>
                        <th>DATE ENDORSED</th>
                    </tr>
                    </thead>
                </table>
            </script>
        </div>
        <!-- /.box -->

    </section>
    <!-- /.content -->
</div>