<div class="content-wrapper">
    <section class="content-header">
        <h1>
            General Monitoring
            <small>Control panel</small>
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="box">
            <div class="box-body">
                <div class="panel-body">
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li class="active" ><a href="#tab_a" data-toggle="tab" class = "human_resources_employee_a_class">Account List</a></li>
                        </ul>

                        <div class = "tab-content">
                            <div class="tab-pane active" id="tab_a">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="box box-danger">
                                            <div class="box-header with-border">
                                            </div>
                                            <div class="box-body">
                                                <div class="form-group">
                                                    <input type="radio" name="gen_mon_rad" id="gen_mon_all" class="gen_mon_date_range_click" value="all">
                                                    <label for="gen_mon_all">All</label>
                                                    <input type="radio" name="gen_mon_rad" id="gen_mon_date_range" checked class="gen_mon_date_range_click" value="date_range">
                                                    <label for="gen_mon_date_range">Date Range</label>
                                                </div>
                                                <div class="form-group" id="gen_mon_date_pick_holder">
                                                    <div class="input-group margin" style="" id="">
                                                        <div class="input-group-btn">
                                                            <label for="" class="btn btn-default">From</label>
                                                        </div>
                                                        <input id="gen_mon_min" type="date" class="form-control gen_mon_date_range_dates" value="<?php echo date('Y-m-d');?>">
                                                        <div class="input-group-btn">
                                                            <label for="" class="btn btn-default">To</label>
                                                        </div>
                                                        <input id="gen_mon_max" type="date" class="form-control gen_mon_date_range_dates" value="<?php echo date('Y-m-d');?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class = "row">
                                    <div class = "col-md-12">
                                        <table id="cc_sao_gen_mon_table" class="tableendorse display table-hover table-condensed" width="100%">
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
                                                <th>ASSIGNED TELEVERIFIER</th>
                                                <th>REQUESTOR/POC</th>
                                                <th>ATTACHMENTS</th>
                                                <th>STATUS</th>
                                                <th>STATUS DETAILS</th>
                                                <th>STATUS OF ACCOUNT</th>
                                                <th>DATE TIME SENT TO CLIENT</th>
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
                                                <th>ASSIGNED TELEVERIFIER</th>
                                                <th>REQUESTOR/POC</th>
                                                <th>ATTACHMENTS</th>
                                                <th>STATUS</th>
                                                <th>STATUS DETAILS</th>
                                                <th>STATUS OF ACCOUNT</th>
                                                <th>DATE AND TIME SENT TO CLIENT</th>
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
    </section>
</div>