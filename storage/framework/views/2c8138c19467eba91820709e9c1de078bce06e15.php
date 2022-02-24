


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Account Panel
            </h1>

        </section>

        <!-- Main content -->
        <section class="content">
            
            <div class="modal modal-default fade" id="modal-view-report">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Note</h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                        <textarea class="form-control" rows="10" id="acctReport" placeholder="Enter ..." disabled>
                        </textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                            <button type="button" id="exportReport" class="btn btn-primary pull-right">Export to Text File</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            
            <div class="row" style = "padding-bottom : 20px;">
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-aqua">
                        <div class="inner">
                            <h3><?php echo e($endorsement); ?></h3>

                            <p>New Endorsement Account</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-green">
                        <div class="inner">
                            <h3>99<sup style="font-size: 20px">%</sup></h3>

                            <p>Successfull TAT Account</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-yellow">
                        <div class="inner">
                            <h3><?php echo e($overdueAccount); ?></h3>

                            <p>Overdue Account</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-red">
                        <div class="inner">
                            <h3><?php echo e($dueAccount); ?></h3>

                            <p>Due Account as of <?php echo e($timeStamp->toFormattedDateString()); ?></p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-pie-graph"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
            </div>
            <!-- Default box -->
            <div class="box">
                
                    

                    
                        
                                
                            
                        
                            
                    
                
                <div class="box-body">
                    <div class="panel-body">

                        <div class="row">
                            <div class="col-md-12">
                                <!-- Custom Tabs -->
                                <div class="nav-tabs-custom">
                                    <ul class="nav nav-tabs">
                                        <li class="active"><a id="tab1" href="#tab_1" data-toggle="tab">Assign Accounts</a></li>
                                        <li><a id="tab2" href="#tab_2" data-toggle="tab">Transfer Accounts</a></li>
                                        <li><a id="tab3" href="#tab_3" data-toggle="tab">Manage Accounts</a></li>
                                        <li><a id="tab4" href="#tab_4" data-toggle="tab">Revise Accounts</a></li>
                                        <li><a id="tab5" href="#tab_5" data-toggle="tab">CI Account Reports</a></li>
                                    </ul>

                                    <div class="tab-content">
                                        <!-- /.tab-pane -->
                                        <div class="tab-pane active" id="tab_1">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="box box-danger">
                                                        <div class="box-header with-border">
                                                        </div>
                                                        <div class="box-body">
                                                            <div class="form-group">
                                                                <input type="radio" name="sao_assign_rad" id="sao_assign_rad_all" class="sao_assign_rad_click" value="all" title="Default of 30 Days filtered">
                                                                <label for="sao_assign_rad_all" title="Default of 30 Days filtered">All</label>
                                                                <input type="radio" name="sao_assign_rad" id="sao_assign_rad_date_range" checked="" class="sao_assign_rad_click" value="date_range">
                                                                <label for="sao_assign_rad_date_range">Date Range</label>
                                                            </div>
                                                            <div class="form-group" id="sao_assign_rad_holder">
                                                                <div class="input-group margin">
                                                                    <div class="input-group-btn">
                                                                        <label for="" class="btn btn-default">From</label>
                                                                    </div>
                                                                    <input id="sao_assign_min" type="date" class="form-control sao_assign_date_range" value="<?php echo e(date('Y-m-d')); ?>">
                                                                    <div class="input-group-btn">
                                                                        <label for="" class="btn btn-default">To</label>
                                                                    </div>
                                                                    <input id="sao_assign_max" type="date" class="form-control sao_assign_date_range" value="<?php echo e(date('Y-m-d', strtotime('-30 days'))); ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <table id="endorsement-tablee" class="tableendorse display table-hover table-condensed" width="100%">
                                                <thead>
                                                <tr>
                                                    <th>Id</th>
                                                    <th>Date Endorsed</th>
                                                    <th>Time Endorsed</th>
                                                    <th>Date Due</th>
                                                    <th>Time Due</th>
                                                    <th>Account Name</th>
                                                    <th>Type of Request</th>
                                                    <th>Type of Loan</th>
                                                    <th>Bank Name</th>
                                                    <th>Entry As</th>
                                                    <th>City/Municipality</th>
                                                    <th>Province</th>
                                                    <th>Region</th>
                                                    <th>Archipelago</th>
                                                    <th>Assigned AO</th>
                                                    <th>Requestor Name</th>
                                                    <th>Actions</th>
                                                </tr>
                                                </thead>
                                                <tfoot>
                                                <tr>
                                                    <th>Id</th>
                                                    <th>Date Endorsed</th>
                                                    <th>Time Endorsed</th>
                                                    <th>Date Due</th>
                                                    <th>Time Due</th>
                                                    <th>Account Name</th>
                                                    <th>Type of Request</th>
                                                    <th>Type of Loan</th>
                                                    <th>Bank Name</th>
                                                    <th>Entry As</th>
                                                    <th>City/Municipality</th>
                                                    <th>Province</th>
                                                    <th>Region</th>
                                                    <th>Archipelago</th>
                                                    <th>Assigned AO</th>
                                                    <th>Requestor Name</th>
                                                    <th>Actions</th>
                                                </tr>
                                                </tfoot>
                                            </table>

                                        </div>
                                        <!-- /.tab-pane -->
                                        <div class="tab-pane" id="tab_2">
                                            <div class="row" >
                                                <div class="col-md-4">
                                                    <div class="box box-danger">
                                                        <div class="box-header with-border">
                                                        </div>
                                                        <div class="box-body">
                                                            <div class="form-group">
                                                                <input type="radio" name="sao_assign_rad_transfer" id="sao_assign_rad_all_transfer" class="sao_assign_rad_click_transfer" value="all" title="Default of 30 Days filtered">
                                                                <label for="sao_assign_rad_all_transfer" title="Default of 30 Days filtered">All</label>
                                                                <input type="radio" name="sao_assign_rad_transfer" id="sao_assign_rad_date_range_transfer" checked="" class="sao_assign_rad_click_transfer" value="date_range">
                                                                <label for="sao_assign_rad_date_range_transfer">Date Range</label>
                                                            </div>
                                                            <div class="form-group" id="sao_assign_rad_holder_transfer">
                                                                <div class="input-group margin">
                                                                    <div class="input-group-btn">
                                                                        <label for="" class="btn btn-default">From</label>
                                                                    </div>
                                                                    <input id="sao_assign_min" type="date" class="form-control sao_assign_date_range" value="<?php echo e(date('Y-m-d')); ?>">
                                                                    <div class="input-group-btn">
                                                                        <label for="" class="btn btn-default">To</label>
                                                                    </div>
                                                                    <input id="sao_assign_max" type="date" class="form-control sao_assign_date_range" value="<?php echo e(date('Y-m-d', strtotime('-30 days'))); ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <table id="aolist-table" class="tableendorse display table-hover table-condensed" width="100%">
                                                <thead>
                                                <tr>
                                                    <th>Id</th>
                                                    <th>Date Endorsed</th>
                                                    <th>Time Endorsed</th>
                                                    <th>Date Due</th>
                                                    <th>Time Due</th>
                                                    <th>Account Name</th>
                                                    <th>Type of Request</th>
                                                    <th>Type of Loan</th>
                                                    <th>AO ID</th>
                                                    <th>Account Officer</th>
                                                    <th>Bank Name</th>
                                                    <th>Entry As</th>
                                                    <th>AO Email</th>
                                                    <th>City/Municipality</th>
                                                    <th>Province</th>
                                                    <th>Region</th>
                                                    <th>Archipelago</th>
                                                    <th>Status</th>
                                                </tr>
                                                </thead>
                                                <tfoot>
                                                <tr>
                                                    <th>Id</th>
                                                    <th>Date Endorsed</th>
                                                    <th>Time Endorsed</th>
                                                    <th>Date Due</th>
                                                    <th>Time Due</th>
                                                    <th>Account Name</th>
                                                    <th>Type of Request</th>
                                                    <th>Type of Loan</th>
                                                    <th>AO ID</th>
                                                    <th>Account Officer</th>
                                                    <th>Bank Name</th>
                                                    <th>Entry As</th>
                                                    <th>AO Email</th>
                                                    <th>City/Municipality</th>
                                                    <th>Province</th>
                                                    <th>Region</th>
                                                    <th>Archipelago</th>
                                                    <th>Status</th>
                                                </tr>
                                                </tfoot>
                                            </table>


                                            

                                        </div>
                                        <!-- /.tab-pane -->
                                        <div class="tab-pane" id="tab_3">
                                            

                                            <table id="tableholdcancel" class="tableendorse table-hover table-condensed" width="100%">
                                                <thead>
                                                <tr>
                                                    <th>Id</th>
                                                    <th>Date Endorsed</th>
                                                    <th>Time Endorsed</th>
                                                    <th>Date Due</th>
                                                    <th>Time Due</th>
                                                    <th>Entry As</th>
                                                    <th>Account Name</th>
                                                    <th>Address</th>
                                                    <th>Type of Request</th>
                                                    <th>Bank name</th>
                                                    <th>Type of Loan</th>
                                                    <th>Province</th>
                                                    <th>Requestor Name</th>
                                                    <th>Actions</th>
                                                </tr>
                                                </thead>
                                                <tfoot>
                                                <tr>
                                                    <th>Id</th>
                                                    <th>Date Endorsed</th>
                                                    <th>Time Endorsed</th>
                                                    <th>Date Due</th>
                                                    <th>Time Due</th>
                                                    <th>Entry As</th>
                                                    <th>Account Name</th>
                                                    <th>Address</th>
                                                    <th>Type of Request</th>
                                                    <th>Bank name</th>
                                                    <th>Type of Loan</th>
                                                    <th>Province</th>
                                                    <th>Requestor Name</th>
                                                    <th>Actions</th>
                                                </tr>
                                                </tfoot>
                                            </table>

                                            <!-- /.tab-pane -->
                                            <input type="hidden" id="accountID">
                                            <input type="hidden" id="accountName">
                                        </div>
                                        <!-- /.tab-pane -->
                                        <div class="tab-pane" id="tab_4">
                                            
                                            <table id="aolist-table-revision" class="tableendorse display table-hover table-condensed" width="100%">
                                                <thead>
                                                <tr>
                                                    <th>Id</th>
                                                    <th>Date Endorsed</th>
                                                    <th>Time Endorsed</th>
                                                    <th>Date Due</th>
                                                    <th>Time Due</th>
                                                    <th>Account Name</th>
                                                    <th>Type of Request</th>
                                                    <th>Type of Loan</th>
                                                    <th>Account Officer</th>
                                                    <th>Bank Name</th>
                                                    <th>Entry As</th>
                                                    <th>AO Email</th>
                                                    <th>City/Municipality</th>
                                                    <th>Province</th>
                                                    <th>Region</th>
                                                    <th>Archipelago</th>
                                                    <th>Status</th>
                                                </tr>
                                                </thead>
                                                <tfoot>
                                                <tr>
                                                    <th>Id</th>
                                                    <th>Date Endorsed</th>
                                                    <th>Time Endorsed</th>
                                                    <th>Date Due</th>
                                                    <th>Time Due</th>
                                                    <th>Account Name</th>
                                                    <th>Type of Request</th>
                                                    <th>Type of Loan</th>
                                                    <th>Account Officer</th>
                                                    <th>Bank Name</th>
                                                    <th>Entry As</th>
                                                    <th>AO Email</th>
                                                    <th>City/Municipality</th>
                                                    <th>Province</th>
                                                    <th>Region</th>
                                                    <th>Archipelago</th>
                                                    <th>Status</th>
                                                </tr>
                                                </tfoot>
                                            </table>
                                            
                                        </div>
                                        <!-- /.tab-pane -->
                                        <div class="tab-pane" id="tab_5">
                                            
                                            <div class="row">
                                                <div class="col-md-5">
                                                <div class="box box-danger">
                                                    <div class="box-header with-border">
                                                        <h3 class="box-title">Date Range Sorting</h3>
                                                    </div>
                                                    <div class="box-body">
                                                        <div class="form-group">

                                                            <input type="radio" class="viewable" name="viewable_pends" id="rad_all_sao" value="All">All(-10 Days Date From now)
                                                            <input type="radio" class="viewable" name="viewable_pends" id="rad_daterange_sao" value="Date Range">Date Range

                                                            <div class="date_range_conts pull-right">
                                                                Search Option:
                                                                <select id="select_search_option_sao">
                                                                    <option value="sao_sort_date_endorsed">Date Endorsed</option>
                                                                    <option value="sao_sort_date_dispatched">Date Dispatched</option>
                                                                    <option value="sao_sort_date_ci_visit">Date C.I Visit</option>
                                                                    <option value="sao_sort_date_report_submit">Date Report Submitted</option>
                                                                </select>
                                                            </div>

                                                            <div class="input-group margin date_range_conts">
                                                                <div class="input-group-btn">
                                                                    <button type="button" class="btn btn-default">From</button>
                                                                </div>
                                                                <!-- /btn-group -->
                                                                <input type="text" id="datepicker_sao" class="form-control min">
                                                                <input hidden id="min_sao" type="date">

                                                                <div class="input-group-btn">
                                                                    <button type="button" class="btn btn-default">To</button>
                                                                </div>
                                                                <!-- /btn-group -->
                                                                <input type="text" id="datepickermax_sao" class="form-control max">
                                                                <input hidden id="max_sao" type="date">
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div style = "overflow:scroll; height:100%">
                                                      <table id="sao_table_ci_account_reports" class="tableendorse display table-hover table-condensed" width="100%">
                                                        <thead>
                                                        <tr>
                                                            <th>ID</th>
                                                            <th>ACCOUNT NAME</th>
                                                            <th>DATE ENDORSED</th>
                                                            <th>TIME ENDORSED</th>
                                                            <th>ADDRESS</th>
                                                            <th>CITY/MUNICIPALITY</th>
                                                            <th>PROVINCE</th>
                                                            <th>DATE DUE</th>
                                                            <th>TIME DUE</th>
                                                            <th>BANK</th>
                                                            <th>T.O.R</th>
                                                            <th>DISPATCHER NAME</th>
                                                            <th>C.I NAME</th>
                                                            <th>DATE/TIME DISPATCHED</th>
                                                            <th>DATE/TIME C.I VISIT</th>
                                                            <th>DATE/TIME SUBMIT REPORT</th>
                                                            <th>TIME DISPATCHER</th>
                                                            <th>TIME C.I</th>
                                                            <th>C.I LEVEL</th>
                                                            <th>STATUS/ACTION</th>
                                                        </tr>
                                                        </thead>
                                                        <tfoot>
                                                        <tr>
                                                            <th>ID</th>
                                                            <th>ACCOUNT NAME</th>
                                                            <th>DATE ENDORSED</th>
                                                            <th>TIME ENDORSED</th>
                                                            <th>ADDRESS</th>
                                                            <th>CITY/MUNICIPALITY</th>
                                                            <th>PROVINCE</th>
                                                            <th>DATE DUE</th>
                                                            <th>TIME DUE</th>
                                                            <th>BANK</th>
                                                            <th>T.O.R</th>
                                                            <th>DISPATCHER NAME</th>
                                                            <th>C.I NAME</th>
                                                            <th>DATE/TIME DISPATCHED</th>
                                                            <th>DATE/TIME C.I VISIT</th>
                                                            <th>DATE/TIME SUBMIT REPORT</th>
                                                            <th>TIME DISPATCHER</th>
                                                            <th>TIME C.I</th>
                                                            <th>C.I LEVEL</th>
                                                            <th>STATUS/ACTION</th>
                                                        </tr>
                                                        </tfoot>
                                                    </table>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                        </div>
                                        <!-- /.tab-content -->
                                    </div>

                                    <!-- nav-tabs-custom -->
                                </div>
                                <!-- /.col -->
                            </div>
                            <span id="down_form_revision"></span>
                            <span id="down_form_ci_report"></span>
                        </div>
                    </div>

                    <!-- /.box-body -->
                    
                        
                    
                    <!-- /.box-footer-->

                    <!-- /.box -->
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    
    <div class="modal fade" id="dispatch_modal">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="box box-default">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Dispatch Account to Account Officer</h4>

                        <input type="hidden" id="accountID">
                        <input type="hidden" id="acctName">
                        <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-12">
                                    <div class="box box-solid">
                                        <div class="box-header with-border">
                                            <i class="fa fa-info"></i>
                                            <h3 class="box-title">Endorsement Information</h3>
                                        </div>
                                        <div class="box-body">
                                            <ul>
                                                <li class="id"></li>
                                                <li class="dateTime"></li>
                                                <li class="accountName"></li>
                                                <li class="type_of_loan"></li>
                                                <li class="coborName"></li>
                                                <li class="typeOfRequest"></li>
                                                <li class="province"></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12" id="additional_note_from_client" hidden>
                                <div class="form-group col-xs-12">
                                    <label for="">ADDITIONAL NOTE FROM CLIENT:</label>
                                    <textarea name="" id="sao_additional_client_note" rows="5" class="form-control" disabled></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-10">
                                <div class="form-group">



                                    

                                    <select class="form-control select2" style="width: 100%;" id="aoID"></select>

                                    
                                    
                                    


                                    
                                    
                                    

                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <input type="button" id="btnAssigns" class="btn btn-sm btn-primary pull-right" data-dismiss="modal" value="Assign">
                                </div>
                            </div>
                        </div>
                        <div id="toOverlayDispSao">
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    

    
    <div class="modal fade" id="transfer-modal">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Transfer Account</h4>

                    <input type="hidden" id="aoID">
                    <input type="hidden" id="acctID">

                    <div class="row">
                        <div class="col-md-10">
                            <div class="form-group">
                                

                                <select class="form-control select2" style="width: 100%;" id="aoIDTransfer"></select>

                                

                                

                                

                                

                                
                                
                                
                                
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <input type="button" id="btnTransferr" class="btn btn-sm btn-primary pull-right" value="Transfer">
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    

    
    <div class="modal fade" id="modal-sao-view-info">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">ENDORSEMENT</h4>
                </div>
                <div class="modal-body">
                    <span class="badge bg-light-blue-gradient"><h5>ENDORSEMENT INFORMATION</h5></span>
                    
                    <span id="spanhereView"></span>
                    
                    <br id="spanhereView"/>
                    
                    <table border="2" width="100%" id="otherInfoSpanView"></table>
                    
                    <br id="otherInfoSpanView"/>
                    
                    <table border="2" width="100%" id="otherEmployerSpanView"></table>
                    
                    
                    <table border="2" width="100%" id="otherBusinessSpanView"></table>
                    
                    <span class="badge bg-light-blue-gradient"><h5>ENDORSEMENT HISTORY</h5></span>
                    
                    <table border="2" width="100%" id="historyView"></table>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    

    
    <div class="modal fade" id="modal-sao-update-info">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Update Endorsement Account</h4>
                </div>
                <form action="#" method="get">
                    <input type="hidden" name="_tokens" value="<?php echo e(csrf_token()); ?>">
                    <input type="hidden" id="acctID">
                    <input type="hidden" id="accountName">
                    <div class="modal-body">
                        <div class="box-body">
                            <span id="getUpdatedInfo"></span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="btnSaoUpdateSubmit">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    

    
    <div class="modal modal-success fade" id="modal-successTransferr">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Success!</h4>
                </div>
                <div class="modal-body">
                    <p style="text-align: center">Account Successfully Transferred!</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline pull-right" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    

    
    <div class="modal fade" id="otherInfo">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">ENDORSEMENT</h4>
                </div>
                <div class="modal-body">
                    <span class="badge bg-light-blue-gradient"><h5>Endorsement Other Information</h5></span>
                    
                    <table border="2" width="100%" id="otherInfoSpanV3"></table>
                    

                    
                    <table border="2" width="100%" id="otherEmployerSpanV3"></table>
                    

                    
                    <table border="2" width="100%" id="otherBusinessSpanV3"></table>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    

    
    <div class="modal modal-success fade" id="modal-successTransfer">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Success!</h4>
                </div>
                <div class="modal-body">
                    <p style="text-align: center">Account Successfully Transferred!</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline pull-right" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    

    
    <div class="modal modal-danger fade" id="modal-cancel">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Cancellation of Endorsement</h4>
                </div>
                <div class="modal-body">
                    <center><p>Are you sure you want to cancel this endorsement?</p></center>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-outline" id="btnCancel">Cancel Endorsement</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    

    
    <div class="modal modal-warning fade" id="modal-hold">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Hold Endorsement</h4>
                </div>
                <div class="modal-body">
                    <center><p>Are you sure you want to hold this endorsement?</p></center>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-outline" id="btnHold">Hold Endorsement</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    

    
    <div class="modal modal-danger fade" id="modal-uncancel">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Cancellation of Endorsement</h4>
                </div>
                <div class="modal-body">
                    <center><p>Are you sure you want to uncancel this endorsement?</p></center>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-outline" id="btnUncancel">Uncancel Endorsement</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    

    
    <div class="modal modal-warning fade" id="modal-unhold">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Hold Endorsement</h4>
                </div>
                <div class="modal-body">
                    <center><p>Are you sure you want to Unhold this endorsement?</p></center>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-outline" id="btnUnhold">Unhold Endorsement</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    

    
    <div class="modal modal-success fade" id="modal-success-change-status">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Success!</h4>
                </div>
                <div class="modal-body">
                    <p style="text-align: center">Account Successfully Change Status</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline pull-right" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    





    




    
    


    

