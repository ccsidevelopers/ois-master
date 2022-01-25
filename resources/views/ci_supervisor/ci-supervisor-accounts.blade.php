<div class="content-wrapper">
    <section class="content-header">
        <h1>
            CI Accounts Monitoring
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="box">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-2">
                                <div class="box box-danger">
                                    <div class="box-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="selectedCIArchipelago">Select C.I Archipelago</label>
                                                    <select id="selectedCIArchipelago" class="form-control">
                                                        <option value="">---</option>
                                                        <option value="LUZON">LUZON</option>
                                                        <option value="VISAYAS">VISAYAS</option>
                                                        <option value="MINDANAO">MINDANAO</option>
                                                    </select>
                                                </div>
                                                <div class="form-group" hidden id="ciListSelection">
                                                    <label for="selectedCIselect">Select C.I</label>
                                                    <select id="selectedCIselect" class="select2 form-control" style="width: 100%;"></select>
                                                </div>


                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-10">
                                <div class="box box-danger">
                                    <div class="box-body">
                                        <div class="col-md-12" id="hide_when_no_ci" hidden>
                                            <div class="col-md-12">
                                                <div class="row" id="date_range_for_hided">
                                                    <div class="col-md-6">
                                                        <div class="box box-primary">
                                                            <div class="box-header with-border">
                                                                <h3 class="box-title">Date Range Sorting</h3>
                                                            </div>
                                                            <div class="box-body">
                                                                <div class="form-group">
                                                                    <input type="radio" class="viewable_report1" name="viewable_report1" id="rad_all_report" value="All">All
                                                                    <input type="radio" class="viewable_report1" name="viewable_report1" id="rad_daterange_report" value="Date Range">Date Range

                                                                    <div class="input-group margin date_range_conts_report">
                                                                        <div class="input-group-btn">
                                                                            <button type="button" class="btn btn-default">From</button>
                                                                        </div>
                                                                        <!-- /btn-group -->
                                                                        <input type="text" id="datepicker_report1" class="form-control min">
                                                                        <input hidden="" id="min_report1" type="date">

                                                                        <div class="input-group-btn">
                                                                            <button type="button" class="btn btn-default">To</button>
                                                                        </div>
                                                                        <!-- /btn-group -->
                                                                        <input type="text" id="datepickermax_report1" class="form-control max">
                                                                        <input hidden="" id="max_report1" type="date">
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="nav-tabs-custom">
                                                    <ul class="nav nav-tabs">
                                                        <li class="active">
                                                            <a href="#unangtab" class="ciAccountsMon" data-toggle="tab" aria-expanded="true">Pending</a>
                                                        </li>

                                                        <li>
                                                            <a href="#pangalawangtab" class="ciAccountsMon" data-toggle="tab" aria-expanded="false">Finished</a>
                                                        </li>

                                                        <li>
                                                            <a href="#pangatlongtab" class="ciAccountsMon" data-toggle="tab" aria-expanded="false">Realtime Fund of C.I</a>
                                                        </li>
                                                    </ul>
                                                    <div class="tab-content">
                                                       <div class="tab-pane active" id="unangtab">
                                                            <table class="table-hover table-condensed dataTable dtr-inline" id="ciPendingAccounts">
                                                                <thead>
                                                                <tr>
                                                                    <td>ID</td>
                                                                    <td>ACCOUNT NAME</td>
                                                                    <td>DATE/TIME DUE</td>
                                                                    <td>BANK NAME</td>
                                                                    <td>TYPE OF REQUEST</td>
                                                                    <td>TYPE OF SUBJECT</td>
                                                                    <td>VERIFY THROUGH</td>
                                                                    <td>BANK REMARKS</td>
                                                                    <td>ENTRY AS</td>
                                                                    <td>COBORROWER/ADDRESSES</td>
                                                                </tr>
                                                                </thead>
                                                            </table>
                                                        </div>

                                                        <div class="tab-pane" id="pangalawangtab">
                                                            <table class="table-hover table-condensed dataTable dtr-inline" id="ciFinishedAccounts">
                                                                <thead>
                                                                <tr>
                                                                    <td>ID</td>
                                                                    <td>ACCOUNT NAME</td>
                                                                    <td>INTERNAL STATUS</td>
                                                                    <td>BANK NAME</td>
                                                                    <td>TYPE OF REQUEST</td>
                                                                    <td>TYPE OF SUBJECT</td>
                                                                    <td>VERIFY THROUGH</td>
                                                                    <td>BANK REMARKS</td>
                                                                    <td>ENTRY AS</td>
                                                                    <td>COBORROWER/ADDRESSES</td>
                                                                </tr>
                                                                </thead>
                                                            </table>
                                                        </div>

                                                        <div class="tab-pane" id="pangatlongtab">
                                                            <table class="table-hover table-condensed dataTable dtr-inline" id="realtimeFundtable">

                                                            </table>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="table-overlay" class="overlay" hidden>
                                        <i class="fa fa-refresh fa-spin"></i>
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
