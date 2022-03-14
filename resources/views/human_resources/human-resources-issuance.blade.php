<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Issuance
            <small>Announcements</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active" id="whatIsActiveIssuance">Sent</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-3">
                <a class="btn btn-primary btn-block margin-bottom btnUtilityIssuance" name ="sent">Compose</a>

                <div class="box box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">Monitoring</h3>

                        <div class="box-tools">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="box-body no-padding">
                        <ul class="nav nav-pills nav-stacked">
                            <li><a href="#sent_issuance_tab" class="issuance_left_class"><i class="fa fa-envelope-o"></i> Sent Issuance</a></li>
                        </ul>
                    </div>
                </div>

            </div>
            <!-- /.col -->
            <div class="col-md-9">
                <div id="showSentIssuance" >
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Sent Issuance</h3>
                            <!-- /.box-tools -->
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="mailbox-controls">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default btn-md" id="sentTrashbtn"><i class="fa fa-trash-o"></i></button>
                                    <button type="button" class="btn btn-default btn-md" id="refreshSentIssuanceTable"><i class="fa fa-refresh"></i></button>
                                </div>
                                <!-- /.btn-group -->

                                <!-- /.pull-right -->
                            </div>

                            <div class="row" style="padding-top: 15px;">
                                <div class="col-md-12">
                                    <table class="table-striped table-hover table-condensed" id="table_sent_issuance_mail"  width="100%">
                                        <thead>
                                        <tr>
                                            <th>Date and Time Sent</th>
                                            <th>Sender</th>
                                            <th>Recepient</th>
                                            <th>Subject</th>
                                            <th>View</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <th>Date and Time Sent</th>
                                            <th>Sender</th>
                                            <th>Recepient</th>
                                            <th>Subject</th>
                                            <th>View</th>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                        <!-- /.box-body -->
                    </div>
                </div>
                <div id="showComposeIssuance" hidden>
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Compose Issuance</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body" style="padding-top: 10px">
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="">To:</label>
                                    <select name="" id="selectWhereSendEmpIssuance" class="form-control">
                                        <option value="-">--Please select---</option>
                                        <option value="All Employees">All Employees</option>
                                        <option value="CI Department">CI Department</option>
                                        <option value="Human Resources">Human Resources</option>
                                        <option value="Admin">Admin</option>
                                        <option value="Finance">Finance</option>
                                        <option value="Marketing">Marketing</option>
                                        <option value="Audit">Audit</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row" style="padding-top: 10px">
                                <div class="col-md-6">
                                    <label for="">Subject:</label>
                                    <input class="form-control" id="subjIssuance" placeholder="Insert subject here.......">
                                </div>
                            </div>
                            <div class="row" style="padding-top: 10px" >
                                <div class="col-md-12">
                                    <label for="">Message/Content:</label>
                                    <textarea class="textarea" id="IssuanceMessageToPass" placeholder="Insert content here......"  style="overflow-y :auto ;width: 100%; height: 400px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="">Add Attachments
                                        <button class="btn btn-success btn-xs" id="btnAddAttachmentsIssuance"><i class="fa fa-plus"></i></button></label>
                                </div>
                            </div>
                            <div class="row" id="fillUpAdditionalFilesIssuance" style="padding-top : 20px;">

                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <div class="pull-right">
                                <button type="submit" class="btn btn-primary" id="submitIssuance"><i class="fa fa-envelope-o"></i> Send</button>
                            </div>
                            <button class="btn btn-default" id="clearFieldsIssuance"><i class="fa fa-times"></i> Clear Fields</button>
                        </div>
                        <!-- /.box-footer -->
                    </div>
                </div>


            </div>

        </div>
    </section>
</div>