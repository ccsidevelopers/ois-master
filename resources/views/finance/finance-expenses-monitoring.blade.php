    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                FA Expenses Monitoring
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
                                <div class="nav-tabs-custom">
                                    <ul class="nav nav-tabs">
                                        {{--<li class="active"><a href="#tab_online" id="fa_expenses_tab" data-toggle="tab" class = "fa_monitoring_class">For Online Upload</a></li>--}}
                                        <li class="active"><a href="#tab_expenses" id="fa_expenses_tab" data-toggle="tab" class = "fa_monitoring_class">C.I Liquidation Report</a></li>
                                    </ul>
                                    <div class="tab-content">
                                        {{--<div class="tab-pane active" id="tab_online">--}}
                                            {{--<div class = "row">--}}
                                                {{--<div class = "col-md-12">--}}
                                                    {{--<div class = "box box-danger">--}}
                                                        {{--<div class = "row" style = "padding-top: 30px;">--}}
                                                            {{--<div class = "col-md-2">--}}
                                                                {{--<h4>Filter Details</h4>--}}

                                                                {{--<div class = "row" style = "padding-top : 20px;">--}}
                                                                    {{--<div class = "col-md-12">--}}
                                                                        {{--<label for="">Sort by method:</label>--}}
                                                                        {{--<select  id="btnSortCiApproved" class = "form-control">--}}
                                                                            {{--<option value="-">-</option>--}}
                                                                            {{--<option value="REMITTANCE">REMITTANCE</option>--}}
                                                                            {{--<option value="ATM">ATM</option>--}}
                                                                            {{--<option value="SHELL CARD">SHELL CARD ONLY</option>--}}
                                                                        {{--</select>--}}
                                                                    {{--</div>--}}
                                                                {{--</div>--}}
                                                                {{--<div class = "row" style = "padding-top : 20px;" id = "showHideBank">--}}
                                                                    {{--<div class = "col-md-12">--}}
                                                                        {{--<label for="">Sort Bank:</label>--}}
                                                                        {{--<select  id="btnSortCiBank" class = "form-control">--}}

                                                                        {{--</select>--}}
                                                                    {{--</div>--}}
                                                                {{--</div>--}}
                                                            {{--</div>--}}
                                                            {{--<div class = "col-md-10"></div>--}}
                                                        {{--</div>--}}
                                                    {{--</div>--}}
                                                {{--</div>--}}
                                            {{--</div>--}}
                                            {{--<div id = "hideshowTable">--}}
                                                {{--<table id="table_fund_for_online_upload" class="tableendorse display table-hover table-condensed" style="width:100%">--}}
                                                    {{--<thead>--}}
                                                    {{--<tr>--}}
                                                        {{--<th>Requested Date</th>--}}
                                                        {{--<th>FCI Name</th>--}}
                                                        {{--<th>ATM/Card</th>--}}
                                                        {{--<th>KTPN No./Control No./Sender Name</th>--}}
                                                        {{--<th>Account Number</th>--}}
                                                        {{--<th>Amount</th>--}}
                                                    {{--</tr>--}}
                                                    {{--</thead>--}}
                                                {{--</table>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                        {{--<div class = "tab-pane active" id = "tab_expenses">--}}
                                            {{--<table id="table-finance-expenses-report" class="tableendorse table-hover table-condensed" width="100%">--}}
                                                {{--<thead>--}}
                                                {{--<tr>--}}
                                                    {{--<th>ID:</th>--}}
                                                    {{--<th>C.I NAME:</th>--}}
                                                    {{--<th>DATE:</th>--}}
                                                    {{--<th>LABELS:</th>--}}
                                                    {{--<th>AMOUNT:</th>--}}
                                                    {{--<th>FROM:</th>--}}
                                                    {{--<th>TOTAL AMOUNT:</th>--}}
                                                    {{--<th>O.R:</th>--}}
                                                    {{--<th>REMARKS:</th>--}}
                                                    {{--<th>ACCOUNT INFO:</th>--}}
                                                    {{--<th>ACTION:</th>--}}
                                                {{--</tr>--}}
                                                {{--</thead>--}}
                                            {{--</table>--}}
                                        {{--</div>--}}
                                        <div class = "row" style = "padding-top : 25px;">
                                            <div class = "col-md-12">
                                                <div class = "tab-pane active" id = "tab_expenses">
                                                    <table id="table-finance-expenses-report" class="tableendorse table-hover table-condensed" width="100%">
                                                        <thead>
                                                        <tr>
                                                            <th>ID</th>
                                                            <th>ARCHIPELAGO</th>
                                                            <th>ADDRESS/S</th>
                                                            <th>CREDIT INVESTIGATOR NAME</th>
                                                            <th>DATE</th>
                                                            <th>FUND REQUEST AMOUNT</th>
                                                            <th>TOTAL LIQUIDATED AMOUNT</th>
                                                            <th>TOTAL UNLIQUIDATED AMOUNT</th>
                                                            <th>UPLOADER REMARKS</th>
                                                            <th>AUDIT REMARKS</th>
                                                            <th>ACTION</th>
                                                            <th>DISPATCHER DATE</th>
                                                            <th>SAO DATE</th>
                                                        </tr>
                                                        </thead>
                                                        <tfoot>
                                                        <tr>
                                                            <th>ID</th>
                                                            <th>ARCHIPELAGO</th>
                                                            <th>ADDRESS/S</th>
                                                            <th>CREDIT INVESTIGATOR NAME</th>
                                                            <th>DATE</th>
                                                            <th>FUND REQUEST AMOUNT</th>
                                                            <th>TOTAL LIQUIDATED AMOUNT</th>
                                                            <th>TOTAL UNLIQUIDATED AMOUNT</th>
                                                            <th>UPLOADER REMARKS</th>
                                                            <th>AUDIT REMARKS</th>
                                                            <th>ACTION</th>
                                                            <th>DISPATCHER DATE</th>
                                                            <th>SAO DATE</th>
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
    </div>