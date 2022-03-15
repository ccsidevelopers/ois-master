<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Incident Damage/Stolen Report <small>Monitoring</small>
        </h1>
    </section>
    <section class = "content">
        <div class="row" style="padding-top : 30px;">
            <div class="col-md-5">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h4 style = "text-align : center">Incident Report Information</h4>
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <div class="row" style="padding-top : 20px">
                                <div class="col-md-1"></div>
                                <div class="col-md-10">
                                    <h4>Report:</h4>
                                    <textarea class="form-control" id="incident_rep_rem_admin" rows="15" disabled></textarea>
                                </div>
                                <div class="col-md-1"></div>
                            </div>
                            <div class="row" style="padding-top : 20px">
                                <div class="col-md-1"></div>
                                <div class="col-md-10">
                                    <h4>Uploaded images:</h4>
                                    <div class="box box-default">
                                        <div class="row" id="loopIncidentImagesAdmin" style="padding-top : 15px"> </div>
                                    </div>
                                </div>
                                <div class="col-md-1"></div>
                            </div>
                            <div class="row" style="padding-top : 20px"   >
                                <div class="col-md-1"></div>
                                <div class="col-md-10">
                                    <h4>Approver Remarks:</h4>
                                    <textarea class="form-control" id="incident_rep_approver_remarks_admin" rows="3"  disabled></textarea>
                                </div>
                                <div class="col-md-1"></div>
                            </div>
                            <div class="row" style="padding-top : 20px" id="hideShowApproverRemarksAdmin"  hidden>
                                <div class="col-md-1"></div>
                                <div class="col-md-10">
                                    <h4>Admin Remarks:</h4>
                                    <textarea class="form-control" id="incident_rep_admin_remarks_admin" rows="3"  disabled></textarea>
                                </div>
                                <div class="col-md-1"></div>
                            </div>

                            <div class="row" id="divHideShowIncidentButtonsAdmin" style="padding-top: 20px" hidden>
                                <div class="col-md-12">
                                    <button class="btn btn-md btn-success pull-right btn2ndApprovalIncident" stat="approve" style="margin-left : 10px;">Approve</button>
                                    <button class="btn btn-md btn-danger pull-right btn2ndApprovalIncident" stat="reject" >Reject</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-7">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h4 style = "text-align : center">List of Incident Reports</h4>
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <div class = "nav-tabs-custom">
                                <ul class = "nav nav-tabs">
                                    <li class = "active"><a href="#incident_view_admin_1" data-toggle="tab" class = "incident_admin_status_class">Pending</a></li>
                                    <li><a href="#incident_view_admin_2" data-toggle="tab" class = "incident_admin_status_class">Reviewed</a></li>
                                </ul>
                                <div class = "tab-content">
                                    <div class = "tab-pane active" id = "incident_view_admin_1">
                                        <table class="table-hover table-condensed" style="width: 100%" id="incident-rep-table-admin-pending">
                                            <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Date and time submitted</th>
                                                <th>Reported by</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                        </table>
                                    </div>

                                    <div class = "tab-pane" id = "incident_view_admin_2">
                                        <table class="table-hover table-condensed" style="width: 100%" id="incident-rep-table-admin-reviewed">
                                            <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Date and time submitted</th>
                                                <th>Reported by</th>
                                                <th>Action</th>
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
    </section>
</div>