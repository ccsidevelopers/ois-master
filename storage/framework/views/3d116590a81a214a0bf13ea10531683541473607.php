<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Unliquidated,On-hold and Emergency Fund
            <small>Assigning</small>
        </h1>

    </section>

    <!-- Main content -->
    <section class="content">
        <div class = "row">
            <div class = "col-md-4">
                <div class="box">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class = "box box-danger">
                                    <div class="box-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label for="selectedCIFund">Select C.I</label>
                                                <select id="ci_selected_fund" class = "form-control select2" style = "width : 100%;">
                                                </select>
                                            </div>
                                        </div>
                                        <section id = "showAmountAssignCi">
                                            <div class="row" style = "padding-top : 30px;">
                                                <div class="col-md-6">
                                                    <label for="">Amount to Assign: </label>
                                                    <input type="number" class="form-control" id = "amtToAssignCi" value = 0>
                                                </div>
                                            </div>
                                            <div class ="row" style = "padding-top : 30px;">
                                                <div class="col-md-6">
                                                    <label for="">Fund Source:</label>
                                                    <select id="fundSourceHoldUnliq" class = "form-control"></select>
                                                </div>
                                            </div>
                                            <div class = "row" style = "padding-top : 30px;" id = "showSaoRemUnliq">
                                                <div class="col-md-12">
                                                    <label for="">Remarks</label>
                                                    <textarea id="saoRemText" class = "form-control" rows = "2" placeholder="Insert Remarks...."></textarea>
                                                </div>
                                            </div>
                                            <div class = "row" style = "padding-top : 30px;" id = "showtableFundHold">
                                                <div class = "col-md-12">
                                                    <h4 style = "text-align: center; margin-bottom : 20px;">On-hold Request/s</h4>
                                                    <div style = "overflow:scroll; margin-top: 10px">
                                                        <table id="table_sao_unliq_fund_req" class="tableendorse table-hover table-condensed" width="100%" style="font-size: 13px;">
                                                            <thead>
                                                            <tr>
                                                                <th>REQUEST DATE</th>
                                                                <th>AMOUNT</th>
                                                                <th>ACTION</th>
                                                            </tr>
                                                            </thead>
                                                        </table>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="row" style = "padding-top : 30px;">
                                                <div class="col-md-12">
                                                    <label for="">SELECTED ACCOUNT/S</label>
                                                    <table class="table-hover table-condensed tableendorse display" width="100%" style="margin-bottom: 15px;" id="sao_fund_selected_accnt">
                                                        <tr>
                                                            <th>ID</th>
                                                            <th>ACCOUNT INFORMATION</th>
                                                            <th>ACTION</th>
                                                        </tr>
                                                    </table>
                                                    <button class = "btn btn-flat btn-block btn-success" id = "submitAmtforCiUnliqHold" ><i class = "glyphicon glyphicon-cloud-upload" ></i> Assign fund to C.I</button>
                                                    <button type="button" class = "btn btn-flat btn-block bg-orange pull-right" id = "btnEmergencyFundCi"><i class = "fa fa-fw fa-paper-plane-o"></i> Send Request</button>
                                                </div>
                                            </div>
                                        </section>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class = "col-md-8" id = "showHiddenCiUnliqInfo">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab_0_fund_sao" data-toggle="tab" class = "fund_unliq_tab">Available C.I</a></li>
                        <li><a href="#tab_1_fund_sao" data-toggle="tab" class = "fund_unliq_tab">General Fund Monitoring</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_0_fund_sao">
                            <div class="row">
                                <div class = "col-md-6">
                                    <h2><b>F.C.I Name:</b></h2>
                                    <h5><b id = "checkShellCI"></b></h5>
                                    <br>
                                    <h3 id = "ciNameUnliqHold"></h3>
                                    <br>
                                    <h4>Unliquidated Fund : ₱ <span id = "unliqFundCi"></span></h4>
                                    <br>
                                    <h4>On-Hold Fund : ₱ <span id = "holdFundCi"></span> </h4>
                                </div>
                            </div>
                            <div class = "row" style = "padding-top : 20px">
                                <div class = "col-md-12">
                                    <div class = "box box-success">
                                        <h4 style = "margin-bottom : 20px;">Pending Accounts w/o Fund Requests</h4>
                                        <div style = "overflow:scroll; margin-top: 10px">
                                            <div>
                                                <table id="table-sao-ci-hold-unliq" class="tableendorse table-hover table-condensed" width="100%" style="font-size: 13px;">
                                                    <thead>
                                                    <tr>
                                                        <th>ACTION</th>
                                                        <th>ID</th>
                                                        <th>ACCOUNT NAME</th>
                                                        <th>ADDRESS</th>
                                                        <th>TYPE OF SUBJECT</th>
                                                        <th>CITY/MUNICIPALITY</th>
                                                        <th>PROVINCE</th>
                                                        <th>TYPE OF REQUEST</th>
                                                        <th>DATE ENDORSED</th>
                                                    </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab_1_fund_sao">
                            <div class = "row">
                                <div class="col-md-12">
                                    <div class="box box-danger">
                                        <div class="box-body">
                                            <h4 style = "text-align: center;">Fund Activity Tracker</h4>
                                            <table id = "fund-request-sao-override-table" class="display table-hover table-condensed" width=100%>
                                                <thead>
                                                <tr>
                                                    <th>SAO Name</th>
                                                    <th>Request/Override Date and Time</th>
                                                    <th>Upload Date and Time</th>
                                                    <th>C.I Name</th>
                                                    <th>Type of Fund Assigned</th>
                                                    <th>Requested Amount</th>
                                                    <th>Approved Amount</th>
                                                    <th>Status
                                                    <th>Remarks</th>
                                                </tr>
                                                </thead>
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
        <div class="row">
            <div class="col-md-12">
                <!-- Custom Tabs -->
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#ciFundReq1" data-toggle="tab">Pending Fund Request</a></li>
                        <li><a href="#ciFundReq2" data-toggle="tab">Success Fund Request</a></li>
                        <li><a href="#ciFundReq3" data-toggle="tab">Disapproved Fund Request</a></li>
                        <li><a href="#ciFundReq4" data-toggle="tab">Cancelled Fund Request</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="ciFundReq1">
                            <table id="table-advance-fund-request" class="tableendorse table-hover table-condensed" width="100%">
                                <thead>
                                <tr>
                                    <th></th>
                                    <th>Id</th>
                                    <th>FCI Name</th>
                                    <th>SAO Name</th>
                                    <th>Type of Fund</th>
                                    <th>Requested Amount</th>
                                    <th>For These Account/s</th>
                                    <th>Requested Date</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th></th>
                                    <th>Id</th>
                                    <th>FCI Name</th>
                                    <th>SAO Name</th>
                                    <th>Type of Fund</th>
                                    <th>Requested Amount</th>
                                    <th>For These Account/s</th>
                                    <th>Requested Date</th>
                                    <th>Action</th>
                                </tr>
                                </tfoot>
                            </table>

                        </div>
                        <div class="tab-pane" id="ciFundReq2">
                            <table id="table-advance-fund-success" class="tableendorse table-hover table-condensed" width="100%">
                                <thead>
                                <tr>
                                    <th></th>
                                    <th>Id</th>
                                    <th>FCI Name</th>
                                    <th>SAO Name</th>
                                    <th>Type of Fund</th>
                                    <th>Requested Amount</th>
                                    <th>For These Account/s</th>
                                    <th>Requested Date</th>
                                    <th>Status</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th></th>
                                    <th>Id</th>
                                    <th>FCI Name</th>
                                    <th>SAO Name</th>
                                    <th>Type of Fund</th>
                                    <th>Requested Amount</th>
                                    <th>For These Account/s</th>
                                    <th>Requested Date</th>
                                    <th>Status</th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="tab-pane" id="ciFundReq3">
                            <table id="table-advance-fund-disapproved" class="tableendorse table-hover table-condensed" width="100%">
                                <thead>
                                <tr>
                                    <th></th>
                                    <th>Id</th>
                                    <th>FCI Name</th>
                                    <th>SAO Name</th>
                                    <th>Type of Fund</th>
                                    <th>Requested Amount</th>
                                    <th>For These Account/s</th>
                                    <th>Requested Date</th>
                                    <th>Status</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th></th>
                                    <th>Id</th>
                                    <th>FCI Name</th>
                                    <th>SAO Name</th>
                                    <th>Type of Fund</th>
                                    <th>Requested Amount</th>
                                    <th>For These Account/s</th>
                                    <th>Requested Date</th>
                                    <th>Status</th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="tab-pane" id="ciFundReq4">
                            <table id="table-advance-fund-cancelled" class="tableendorse table-hover table-condensed" width="100%">
                                <thead>
                                <tr>
                                    <th></th>
                                    <th>Id</th>
                                    <th>FCI Name</th>
                                    <th>SAO Name</th>
                                    <th>Type of Fund</th>
                                    <th>Requested Amount</th>
                                    <th>For These Account/s</th>
                                    <th>Requested Date</th>
                                    <th>Status</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th></th>
                                    <th>Id</th>
                                    <th>FCI Name</th>
                                    <th>SAO Name</th>
                                    <th>Type of Fund</th>
                                    <th>Requested Amount</th>
                                    <th>For These Account/s</th>
                                    <th>Requested Date</th>
                                    <th>Status</th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        
        <script id="details-template" type="text/x-handlebars-template">
            <div class="label label-info pull-left" style="font-size: 12px">Accounts for this Fund</div>
            <table style="font-size: 15px;" class="tableendorse table details-table" id="posts-{{id}}">
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


        <script id="details-template-success" type="text/x-handlebars-template">
            <div class="label label-info pull-left" style="font-size: 12px">Accounts for this Fund</div>
            <table style="font-size: 15px;" class="tableendorse table details-table" id="success_posts-{{id}}">
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

        <script id="details-template-disapproved" type="text/x-handlebars-template">
            <div class="label label-info pull-left" style="font-size: 12px">Accounts for this Fund</div>
            <table style="font-size: 15px;" class="tableendorse table details-table" id="disapproved_posts-{{id}}">
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

        <script id="details-template-cancel" type="text/x-handlebars-template">
            <div class="label label-info pull-left" style="font-size: 12px">Accounts for this Fund</div>
            <table style="font-size: 15px;" class="tableendorse table details-table" id="cancel_posts-{{id}}">
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

    </section>
</div>
