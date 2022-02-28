<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            CI Expenses Monitoring
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
                                    <div class="row">
                                        <div class="col-md-3">
                                            <select id="ci_expense_archi" class="form-control">
                                                <option value="">--Select Archipelago--</option>
                                                <option value="1">LUZON</option>
                                                <option value="2">VISAYAS</option>
                                                <option value="3">MINDANAO</option>
                                            </select>
                                        </div>
                                    </div>
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