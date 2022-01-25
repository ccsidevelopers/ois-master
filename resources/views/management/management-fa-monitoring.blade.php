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
                                        <div class="col-md-5">
                                            <div class="box box-danger">
                                                <div class="box-header with-border">
                                                    <h3 class="box-title">Date Range Sorting</h3>
                                                </div>
                                                <div class="box-body">
                                                    <div class="form-group">
                                                        <input type="radio" class="ci_expense_range" name="ci_expense_range" value="All">All
                                                        <input type="radio" class="ci_expense_range" name="ci_expense_range" value="Date Range" checked>Date Range
                                                        <select id="ci_expense_archi" class="pull-right">
                                                            <option value="">--Select Archipelago--</option>
                                                            <option value="1">LUZON</option>
                                                            <option value="2">VISAYAS</option>
                                                            <option value="3">MINDANAO</option>
                                                        </select>
                                                        <div class="input-group margin date_range_ci_exp">
                                                            <div class="input-group-btn">
                                                                <button type="button" class="btn btn-default">From</button>
                                                            </div>
                                                            <!-- /btn-group -->
                                                            <input type="text" id="ci_expense_range_start1" class="form-control">
                                                            <input hidden id="ci_expense_range_start" type="text">

                                                            <div class="input-group-btn">
                                                                <button type="button" class="btn btn-default">To</button>
                                                            </div>
                                                            <!-- /btn-group -->
                                                            <input type="text" id="ci_expense_range_end1" class="form-control">
                                                            <input type="text" hidden id="ci_expense_range_end">
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
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