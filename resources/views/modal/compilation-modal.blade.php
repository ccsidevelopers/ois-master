<style>
    .toLeftTop
    {
        padding-left : 125px;
    }

    .ui-autocomplete {
        z-index: 2150000000;
    }
</style>



{{--VIEW FULL INFO MODAL--}}
<div class="modal fade" id="modal-view-info">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">ENDORSEMENT</h4>
            </div>
            <div class="modal-body">
                <span class="badge bg-light-blue-gradient"><h5>ENDORSEMENT INFORMATION</h5></span>
                {{--INFO START HERE--}}
                <span id="spanhere"></span>
                {{--END OF INFO--}}
                <br id="spanhere"/>
                {{--COBORROWER HERE--}}
                <table border="2" width="100%" id="otherInfoSpan"></table>
                {{--END OF COBORROWER--}}
                <br id="otherInfoSpan"/>
                {{--EMPLOYER HERE--}}
                <table border="2" width="100%" id="otherEmployerSpan"></table>
                {{--END OF COBORROWER--}}
                {{--BUSINESS HERE--}}
                <table border="2" width="100%" id="otherBusinessSpan"></table>
                {{--END OF BUSINESS--}}
                <span class="badge bg-light-blue-gradient"><h5>ENDORSEMENT HISTORY</h5></span>
                {{--INFO START HERE--}}
                <div style="overflow:scroll; height:300px;">
                    <table border="2" width="100%" id="history"></table>
                </div>
                {{--END OF INFO--}}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
{{--END OF VIEW FULL INFO MODAL--}}


{{--CHANGE PASS MODAL--}}
<div class="modal modal-default fade" id="modal-change-password">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Change Password</h4>
            </div>
            <div class="modal-body">
                <label>Current Password:</label>
                <input type="password" class="form-control" id="txtCurrentPass" required>
                <label>New Password:</label>
                <input type="password" class="form-control" id="txtNewPass" required>
                <label>Repeat New Password:</label>
                <input type="password" class="form-control" id="txtVerifyPass" required>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <button type="button" id="btnNewPassword" class="btn btn-primary pull-right">Save Changes</button>
            </div>
        </div>
    </div>
</div>

{{--ERROR PASS NOT MATCH MODAL--}}
<div class="modal modal-danger fade" id="modal-change-password-not-match">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Change Password</h4>
            </div>
            <div class="modal-body">
                <center>New Password Not Match!</center>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

{{--ERROR PASS EMPTY--}}
<div class="modal modal-danger fade" id="modal-change-password-empty">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Change Password</h4>
            </div>
            <div class="modal-body">
                <center>Please Fill Up All Necessary Fields!</center>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

{{--DOWN MODAL--}}
<div class="modal modal-default fade" id="modal-disable-web">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Maintenance</h4>
            </div>
            <div class="modal-body">
                <p><center>Are you sure you want to change status of OIMS?</center></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
                <button type="button" id="btnDisWeb" class="btn btn-primary pull-right" data-dismiss="modal">Activate Web App</button>
                <button type="button" id="btnEnaWeb" class="btn btn-primary pull-right" data-dismiss="modal">Deactivate Web App</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
{{--END OF DOWN MODAL--}}

{{--LOAD SESSION MODAL--}}
<div class="modal modal-default fade" id="modal-load-session">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Previous Data</h4>
            </div>
            <div class="modal-body">
                <p><center>Do you want to load previous inputted data on the common fields?</center></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
                <button type="button" id="btnNewSession" class="btn btn-primary pull-right" data-dismiss="modal">New Endorsement</button>
                <button type="button" id="btnYesSession" class="btn btn-primary pull-right" data-dismiss="modal">Yes</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
{{--END OF LOAD SESSION MODAL--}}

{{--UPDATE CONTRACT--}}
<div class="modal modal-default fade" id="modal-marketing-update-info">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Update Contract</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="txtContract">Client Name:</label>
                            <input type="text" class="form-control" id="txtClientNameUpdate" placeholder="Client Name Here..">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="dateStartCont:">Start Date:</label>
                            <input type="date" class="form-control" id="dateStartContUpdate">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="dateEndCont:">End Date:</label>
                            <input type="date" class="form-control" id="dateEndContUpdate">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="fileContract">Choose PDF Contract File (it must be .zip File):</label>
                            <input type="file" id="fileContractUpdate" accept=".zip">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="txtContDesc">Contract Description:</label>
                            <textarea id="txtContDescUpdate" class="form-control" placeholder="Contract Description Here..."></textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="txtContRemarks">Remarks:</label>
                            <textarea id="txtContRemarksUpdate" class="form-control" placeholder="Contract Remarks Here..."></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
                <button type="button" id="btnContractUpdate" class="btn btn-primary pull-right" data-dismiss="modal">Update</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
{{--END OF UPDATE CONTRACT--}}

{{--SEND VIEW REMITTANCE TO C.I MODAL--}}
<div class="modal modal-default fade" id="modal_view_remiitance">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Remittance Information</h4>
            </div>
            <div class="modal-body">
                <div class="box-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Branch Name:</label>
                        <select id="view_Branch_name_remit_id" class="form-control" style="width: 100%">
                            <option id="no selection" value="Select Branch" style="color: grey">(Select Branch)</option>
                            <option id="cebuana" value="cebuana">Cebuana</option>
                            <option id="M Lhuillier" value="M Lhuillier">M Lhuillier</option>
                            <option id="Western Union Sulit" value="Western Union Sulit">Western Union Sulit</option>
                            <option id="LBC" value="LBC">LBC</option>
                            <option id="Palawan" value="Palawan">Palawan</option>
                            <option id="TrueMoney" value="TrueMoney">TrueMoney</option>
                            <option id="RD Pawnshop" value="RD Pawnshop">RD Pawnshop</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Receiver:</label>
                        <input type="text" class="form-control" id="view_Receiver_remit_id" placeholder="Name of receiver">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Remittance Code:</label>
                        <input type="text" class="form-control" id="view_Remit_code_id" placeholder="Remittance Code">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Amount:</label>
                        <input type="number" class="form-control" id="view_Amount_remit_id" placeholder="Amount">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Sender:</label>
                        <input type="text" class="form-control" id="view_Sender_remit_id" placeholder="Name of sender">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Remarks:</label>
                        <textarea class="form-control" id="view_Remarks_remit_id" style="height: 100px" placeholder="Remarks"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
                <button type="button" id="UpdateRemittance" class="btn btn-primary pull-right">UPDATE</button>
                <button type="button" id="EditRemittance" class="btn btn-primary pull-right" >EDIT</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>Note:
{{--END VIEW SEND REMITTANCE TO C.I MODAL--}}

{{--UPDATE CLIENT BDAY--}}
<div class="modal modal-default fade" id="modal-marketing-update-client-bday">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Update Client's Info</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="txtContract">Client Name:</label>
                            <input type="text" class="form-control" id="txtClientNameUpd" placeholder="Client Name Here..">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="txtEmployerNameUpd">Employer Name:</label>
                            <input type="text" class="form-control" id="txtEmployerNameUpd">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="clientBday">Birth Date:</label>
                            <input type="date" class="form-control" id="clientBdayUpd">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="txtClientContactNo">Contact No/s.:</label>
                            <input type="text" class="form-control" id="txtClientContactNoUpd">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="clientEmail">Client Email:</label>
                            <input type="email" class="form-control" id="clientEmailUpd">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="clientPos">Client Position:</label>
                            <input type="text" class="form-control" id="clientPosUpd">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="clientGiftType">Gift Type:</label>
                            <select class="form-control select1" id="clientGiftTypeUpd">
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="C">C</option>
                                <option value="D">D</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
                <button type="button" id="btnUpdateClientBdayInfo" class="btn btn-primary pull-right" data-dismiss="modal">Update</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
{{--END OF CLIENT BDAY--}}

{{--UPDATE PROSPECT CLIENT--}}
<div class="modal modal-default fade" id="modal-marketing-update-pros-client">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Update Client's Info</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="txtClientNamePros">Client Name:</label>
                            <input type="text" class="form-control" id="txtClientNameProsUpd">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="clientDateInquiry">Date of Inquiry:</label>
                            <input type="date" class="form-control" id="clientDateInquiryUpd">
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="form-group">
                            <label for="clientFileUpd">Choose zip file:</label>
                            <input type="file" class="btn btn-block btn-default" id="clientFileUpd" accept=".zip">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="txtContactPerson">Contact Person:</label>
                            <input type="text" class="form-control" id="txtContactPersonUpd">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="txtContactPosition">Contact Position:</label>
                            <input type="text" class="form-control" id="txtContactPositionUpd">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="txtContactNumber">Contact Number:</label>
                            <input type="text" class="form-control" id="txtContactNumberUpd">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="txtContactEmail">Contact Email:</label>
                            <input type="email" class="form-control" id="txtContactEmailUpd">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="txtReqCheck">Requirements Checklist:</label>
                            <textarea id="txtReqCheckUpd" rows="5" class="form-control"></textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="txtComAdd">Complete Address:</label>
                            <textarea id="txtComAddUpd" rows="5" class="form-control" placeholder="Address Here..."></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
                <button type="button" id="btnUpdateProspectClient" class="btn btn-primary pull-right" data-dismiss="modal">Update</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
{{--END OF PROSPECT CLIENT--}}

{{--UPLOAD REVISION--}}
<div class="modal modal-default fade" id="modal-upload-revision">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title">Revision Report</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="fileRevision">Choose Revision Report File (it must be .zip File):</label>
                            <input type="file" id="fileRevision" accept=".zip">
                            <span id="ulPercentageRevision"></span>
                            <div id="progressbarRevision"></div>
                            <br>
                            <br>
                            <button type="button" id="btn_download_revised" class="btn-block btn-success btn-s pull-left">Dowload Revision</button>

                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
                <button type="button" id="btn_send_revision" class="btn btn-primary pull-right">Send Revision</button>
            </div>
        </div>
    </div>
</div>
{{--END OF UPLOAD REVISION--}}

{{--REQUESTING FOR ITEM--}}
<div class="modal fade" id="modal-request-panel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <div class="col-md-3"><h4 class="modal-title">Request Panel</h4></div>
            </div>
            <form id="frmArrItem">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box box-danger">
                                <div class="box-header with-border">
                                    <h3 class="box-title"></h3>
                                </div>
                                <div class="box-body">
                                    <div class="col-md-6">
                                        <label>Department</label>
                                        <span id="ccsiDept"></span>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Branch</label>
                                        <span id="ccsiBranch"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box box-danger">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Item List</h3>
                                </div>
                                <div class="box-body">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="txtReqBy">Request By:</label>
                                            <input type="text" class="form-control" id="txtReqBy" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="txtItemReceiver">Item Receiver:</label>
                                            <input type="text" class="form-control" id="txtItemReceiver">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box box-danger">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Item List</h3>
                                </div>
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <button class="btn btn-success btn-sm pull-right" id="btnAddItem">Add Item</button><br/><br/>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <table class="table-condensed table-hover" id="tblItemList" width="100%">
                                                <thead>
                                                <tr>
                                                    <th>Item Name</th>
                                                    <th>Item Description</th>
                                                    <th>Item Purpose</th>
                                                    <th>Quantity</th>
                                                    <th>Action</th>
                                                </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.box-body -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info pull-right" id="btnSendReq">Send</button>
                    <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{--END OF REQUESTING FOR ITEM--}}

{{--NOTE MODAL--}}
<div class="modal modal-default fade" id="modal-dispatcher-view-notee">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Client Note</h4>
            </div>
            <div class="modal-body">



                <span id="txtAreaNote"></span>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
{{--END OF NOTE MODAL--}}

{{--EDIT TAT MODAL--}}
<div class="modal modal-default fade" id="modal_edit_tat_management">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Edit TAT</h4>
            </div>
            <div class="modal-body">

                <span id="get_tat_edit_span">
                </span>

                <div class="row">
                    <div class="col-md-12">
                        <label for="fw_tat_edit">FIELD WORK TAT - INTERNAL TAT (Hours):</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <input type="number" class="form-control" id="fw_tat_edit" name="fw_tat_edit">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <label for="obw_tat_edit">OFFICE BASED WORK TAT - INTERNAL TAT (Hours):</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <input type="number" class="form-control" id="obw_tat_edit" name="obw_tat_edit">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <label for="agreed_tat_edit">AGREED TAT - EXTERNAL TAT (Hours):</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <input type="number" class="form-control" id="agreed_tat_edit" name="agreed_tat_edit">
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" id="tat_click_to_close" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-info pull-right" id="tat_update_btn" >Update</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
{{--END OF EDIT TAT MODAL--}}

{{--VIEW INFORMATION CALENDAR TAT--}}
<div class="modal modal-default fade" id="modal_view_info_calendar">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Calendar Information</h4>
            </div>
            <div class="modal-body">
                <div class="box-body">
                    <div class="form-group">
                        <label for="cal_title">Title:</label>
                        <input type="text" class="form-control" disabled id="cal_title">
                    </div>
                    <div class="form-group">
                        <label for="cal_description">Description:</label>
                        <textarea class="form-control" style="height: 100px" disabled id="cal_description"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="cal_start_start">Start Date:</label>
                        <span id="cal_date_start"></span><br>
                        <label for="cal_start_end">End Date:</label>
                        <span id="cal_date_end"></span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
                <button type="button" id="cal_btn_edit" class="btn btn-warning pull-right">Edit</button>
                <button type="button" id="cal_btn_delete" class="btn btn-danger pull-right">Delete</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
{{--END VIEW INFORMATION CALENDAR TAT---}}




{{--END OF ADD SUPPLIER MODAL--}}


{{--SENDING MODAL--}}
<div class="modal modal-info fade" id="modal-sendingrequest">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Sending...</h4>
            </div>
            <div class="modal-body">
                <p style="text-align: center">Please wait while request is being sent.  <img src="{{ asset('dist/img/loading.gif') }}" style="width: 5%;"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-right" data-dismiss="modal" id="btnModalCloseSending">Close</button>
            </div>
        </div>
    </div>
</div>

{{--SUCCESS MODAL--}}
<div class="modal modal-success fade" id="modal-senadmintsuccess">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Success!</h4>
            </div>
            <div class="modal-body">
                <p style="text-align: center">Successfully Added Supplier</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-right" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


{{--Category success--}}
<div class="modal modal-success fade" id="modal-sentcategorysuccess">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Success!</h4>
            </div>
            <div class="modal-body">
                <p style="text-align: center">Successfully Added Supplier and Category</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-right" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

{{--FILL UP ERROR MODAL--}}
<div class="modal modal-danger fade" id="modal-filluperror">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Error 500!</h4>
            </div>
            <div class="modal-body">
                <p style="text-align: center">Please fill up all necessary field/s</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-right" data-dismiss="modal" id="btnModalCloseFillUpError">Close</button>
            </div>
        </div>
    </div>
</div>
{{--EXISTING NAME--}}
<div class="modal modal-danger fade" id="modal-existing">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Error 500!</h4>
            </div>
            <div class="modal-body">
                <p style="text-align: center">Supplier Already exist!</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-right" data-dismiss="modal" id="btnModalCloseFillUpError">Close</button>
            </div>
        </div>
    </div>
</div>

{{--CATEGORY EXIST--}}

<div class="modal modal-danger fade" id="modal-categoryexist">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Error 500!</h4>
            </div>
            <div class="modal-body">
                <p style="text-align: center">Selected category exists, please select Existing Category option</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-right" data-dismiss="modal" id="btnModalCloseFillUpError">Close</button>
            </div>
        </div>
    </div>
</div>


{{--ACCOUNT UPDATE MODAL--}}
<div class="modal modal-warning fade" id="modal-updating-accounts">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Updating...</h4>
            </div>
            <div class="modal-body">
                <p style="text-align: center">Please wait while the accounts are being update.  <img src="{{ asset('dist/img/loading.gif') }}" style="width: 5%;"></p>
            </div>
            <div class="modal-footer">
                {{--<button type="button" class="btn btn-outline pull-right" data-dismiss="modal" id="btnModalCloseSending">Close</button>--}}
            </div>
        </div>
    </div>
</div>

{{--ACCOUNT SUCCESS MODAL--}}
<div class="modal modal-success fade" id="modal-success-accounts">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Updating Account</h4>
            </div>
            <div class="modal-body">
                <p style="text-align: center">Updating accounts successful.</p>
            </div>
            <div class="modal-footer">
                {{--<button type="button" class="btn btn-outline pull-right" data-dismiss="modal" id="btnModalCloseSending">Close</button>--}}
            </div>
        </div>
    </div>
</div>

{{--ACCOUNT FAILE MODAL--}}
<div class="modal modal-danger fade" id="modal-fail-accounts">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Updating Account</h4>
            </div>
            <div class="modal-body">
                <p style="text-align: center">Updating accounts failed. </p>
            </div>
            <div class="modal-footer">
                {{--<button type="button" class="btn btn-outline pull-right" data-dismiss="modal" id="btnModalCloseSending">Close</button>--}}
            </div>
        </div>
    </div>
</div>

{{--VIEW ACCOUNT INFO B.I MODAL--}}
<div class="modal modal-normal fade" id="modal-view-info-bi-universal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Account</h3>
            </div>
            <div class="modal-body">

                <div id="row_1_unversal" class="row">
                    <div class="col-md-12 form-group">
                        <span class="badge bg-light-blue-gradient"><h5>ACCOUNT INFORMATION</h5></span>
                        <span id="view_info_details"></span>
                    </div>
                </div>

                <div id="row_2_unversal" class="row">
                    <div class="col-md-12 form-group">
                        <span id="view_info_details"></span>
                    </div>
                </div>

                <div id="row_3_unversal" class="row">
                    <div class="col-md-12">
                        <span class="badge bg-light-blue-gradient"><h5>ACCOUNT LOGS</h5></span>
                    </div>
                </div>

                <div id="row_4_unversal" class="row">
                    <div class="col-md-12 form-group">
                        <table width="100%" id="view_info_account_logs"></table>
                    </div>
                </div>
                
                <div id="row_direct_logs" class="row" hidden>
                    <div class="col-md-12">
                        <span class="badge bg-light-blue-gradient"><h5>DIRECT APPLICATION LOGS</h5></span>
                    </div>
                    <div class="col-md-12 form-group">
                        <table width="100%" id="view_direct_logs"></table>
                    </div>
                </div>                

                <div id="row_5_unversal" class="row"  hidden>
                    <div class="col-md-12" style="padding-top : 15px;">
                        <div class="box box-default collapsed-box">
                            <div class="box-header with-border" style="margin:0">
                                <span class="badge bg-light-blue-gradient" ><h5>APPLICANT'S INFORMATION</h5></span>

                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                                    </button>
                                </div>
                                <!-- /.box-tools -->
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body" style="display: none;">
                                <div class="row" style="padding-top : 20px;" id="show_hide_authorization_letter" hidden>
                                    <div class="col-md-12">
                                        <div class="box box-primary">
                                            <div class="box-header with-border">
                                                <h4 style="text-align: center">Authorization Letter</h4>
                                            </div>
                                            <div class="box-body">
                                                <div class = "row" style="padding-top: 20px;">
                                                    <div class="col-md-4"></div>
                                                    <div class="col-md-4">
                                                       <a href="" class="btn btn-md btn-primary btn-block btnDLALViewInfoNow" target="_blank"><i class="fa fa-download"></i> Download Authorization PDF</a>
                                                    </div>
                                                    <div class="col-md-4"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="padding-top : 20px;">
                                    <div class="col-md-12">
                                        <div class="box box-primary">
                                            <div class="box-header with-border">
                                                <h4 style="text-align: center">Personal Details</h4>
                                            </div>
                                            <div class="box-body">
                                                <div class = "row" style="padding-top: 20px;">
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class = "col-md-12">
                                                                <label>Email Address:</label>
                                                                <p id="personal_email_view"></p>
                                                            </div>
                                                            <div class = "col-md-12">
                                                                <label>Last Name:</label>
                                                                <p id="lastnameView"></p>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class = "col-md-12">
                                                                <label>First Name:</label>
                                                                <p id="firstameView"></p>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class = "col-md-12">
                                                                <label>Middle Name:</label>
                                                                <p id="midnameView"></p>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class = "col-md-12">
                                                                <label>Suffix Name:</label>
                                                                <p id="suffixnameView"></p>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class = "col-md-12">
                                                                <label>Birthdate:</label>
                                                                <p id="birthdateView"></p>

                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class = "col-md-12">
                                                                <label>Age:</label>
                                                                <p id="ageView"></p>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class = "col-md-12">
                                                                <label>Gender:</label>
                                                                <p id="genderView"></p>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class = "col-md-12">
                                                                <label>Marital Status:</label>
                                                                <p id="maritalStatView"></p>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class = "col-md-12">
                                                                <label>Maiden Last Name:</label>
                                                                <p id="maidenLastnameView"></p>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class = "col-md-12">
                                                                <label>Maiden First Name:</label>
                                                                <p id="maidenFirstnameView"></p>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class = "col-md-12">
                                                                <label>Maiden Middle Name:</label>
                                                                <p id="maidenMidnameView"></p>
                                                            </div>
                                                        </div>


                                                        <div class="row">
                                                            <div class = "col-md-12">
                                                                <label>Tel/CP no.:</label>
                                                                <p id="telCpView"></p>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class = "col-md-12">
                                                                <label>SSS no:</label>
                                                                <p id="sssView"></p>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="row showBenefits" hidden>
                                                            <div class = "col-md-12">
                                                                <label>TIN no:</label>
                                                                <p id="tinView"></p>
                                                            </div>
                                                        </div>

                                                        <div class="row showBenefits" hidden>
                                                            <div class = "col-md-12">
                                                                <label>Philhealth no:</label>
                                                                <p id="philhealthView"></p>
                                                            </div>
                                                        </div>

                                                        <div class="row showBenefits" hidden>
                                                            <div class = "col-md-12">
                                                                <label>Pagibig no:</label>
                                                                <p id="pagibigView"></p>
                                                            </div>
                                                        </div>

                                                        <div class="row">

                                                            <div class="box-header with-border">
                                                                <div class = "box-title">Present Adress</div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class = "col-md-12">
                                                                <label>Unit #, Bldg/Street, Subd/Brgy.:</label>
                                                                <p id="presentAddressView"></p>

                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class = "col-md-12">
                                                                <label>City/Municipality:</label>
                                                                <p id="presentCityView"></p>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class = "col-md-12">
                                                                <label>Province:</label>
                                                                <p id="presentProvinceView"></p>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="box-header with-border">
                                                                <div class = "box-title">Permanent Address</div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class = "col-md-12">
                                                                <label>Unit #, Bldg/Street, Subd/Brgy.:</label>
                                                                <p id="permaAddressView"></p>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class = "col-md-12">
                                                                <label>City/Municipality:</label>
                                                                <p id="permaCityView"></p>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class = "col-md-12">
                                                                <label>Province:</label>
                                                                <p id="permaProvinceView"></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="padding-top : 20px">
                                    <div class="col-md-12">
                                        <div class="box box-primary">
                                            <div class="box-header with-border">
                                                <h4 style="text-align: center">Marital History</h4>
                                            </div>
                                            <div class="box-body">
                                                <div class="row">
                                                    <div class = "col-md-12">
                                                        <label>Name of Spouse:</label>
                                                        <p id="spouseNameView"></p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class = "col-md-12">
                                                        <label>Telephone/ Mobile No.:</label>
                                                        <p id="spouseContactView"></p>
                                                    </div>
                                                </div>

                                                {{--<div class = "row" style="padding-top : 10px;">--}}
                                                    {{--<div class = "col-md-12">--}}
                                                        {{--<h4>Children:</h4>--}}

                                                        {{--<div style = " height : 100%; overflow-x: auto">--}}
                                                            {{--<table class="tableendorse table-hover table-condensed"   style = "overflow-x:auto; border-collapse:collapse; table-layout:fixed ; width : 150%; ">--}}
                                                                {{--<thead>--}}
                                                                {{--<tr>--}}
                                                                    {{--<th>Name</th>--}}
                                                                    {{--<th>Date of Birth</th>--}}
                                                                    {{--<th>Place of Birth</th>--}}
                                                                {{--</tr>--}}
                                                                {{--</thead>--}}
                                                                {{--<tbody id = "acct_table_children_view">--}}
                                                                {{--</tbody>--}}
                                                            {{--</table>--}}
                                                        {{--</div>--}}
                                                    {{--</div>--}}
                                                {{--</div>--}}
                                            </div>


                                        </div>
                                    </div>
                                </div>
                                <!--<div class="row" style="padding-top : 20px;">-->
                                <!--    <div class="col-md-12">-->
                                <!--        <div class="box box-primary">-->
                                <!--            <div class="box-header with-border">-->
                                <!--                <h4  style="text-align: center">Family History and Information</h4>-->
                                <!--            </div>-->
                                <!--            <div class="box-body">-->
                                <!--                <div class="row">-->
                                <!--                    <div class = "col-md-12">-->
                                <!--                        <label>Father's Full Name:</label>-->
                                <!--                        <p id="FatherFullView"></p>-->
                                <!--                    </div>-->
                                <!--                </div>-->
                                <!--                <div class="row">-->
                                <!--                    <div class = "col-md-12">-->
                                <!--                        <label>Father's Age:</label>-->
                                <!--                        <p id="FatherAgeView"></p>-->
                                <!--                    </div>-->
                                <!--                </div>-->
                                <!--                <div class="row">-->
                                <!--                    <div class = "col-md-12">-->
                                <!--                        <label>Father's Tel/CP no.:</label>-->
                                <!--                        <p id="FatherCPView"></p>-->
                                <!--                    </div>-->
                                <!--                </div>-->

                                <!--                <div class="row">-->
                                <!--                    <div class = "col-md-12">-->
                                <!--                        <label>Mother's Full Name:</label>-->
                                <!--                        <p id="MotherFullView"></p>-->

                                <!--                    </div>-->
                                <!--                </div>-->
                                <!--                <div class="row">-->
                                <!--                    <div class = "col-md-12">-->
                                <!--                        <label>Mother's Age:</label>-->
                                <!--                        <p id="MotherAgelView"></p>-->
                                <!--                    </div>-->
                                <!--                </div>-->
                                <!--                <div class="row">-->
                                <!--                    <div class = "col-md-12">-->
                                <!--                        <label>Mother's Tel/CP no.:</label>-->
                                <!--                        <p id="MotherCPView"></p>-->
                                <!--                    </div>-->
                                <!--                </div>-->

                                <!--                {{--<div class = "row" style="padding-top : 20px;">--}}-->
                                <!--                    {{--<div class = "col-md-12">--}}-->
                                <!--                        {{--<h4>Siblings: </h4>--}}-->

                                <!--                        {{--<div style = " height : 100%; overflow-x: auto">--}}-->
                                <!--                            {{--<table class="tableendorse table-hover table-condensed" id = ""  style = "overflow-x:auto; border-collapse:collapse; table-layout:fixed ; width : 150%; ">--}}-->
                                <!--                                {{--<thead>--}}-->
                                <!--                                {{--<tr>--}}-->
                                <!--                                    {{--<th colspan="1">Name</th>--}}-->
                                <!--                                    {{--<th colspan="1">Age</th>--}}-->
                                <!--                                    {{--<th colspan="2">Address</th>--}}-->
                                <!--                                    {{--<th colspan="1">Occupation</th>--}}-->
                                <!--                                {{--</tr>--}}-->
                                <!--                                {{--</thead>--}}-->
                                <!--                                {{--<tbody id="acct_table_siblings_view">--}}-->
                                <!--                                {{--</tbody>--}}-->
                                <!--                            {{--</table>--}}-->
                                <!--                        {{--</div>--}}-->

                                <!--                    {{--</div>--}}-->
                                <!--                {{--</div>--}}-->
                                <!--            </div>-->
                                <!--        </div>-->
                                <!--    </div>-->
                                <!--</div>-->
                                <div class="row" style="padding-top : 20px">
                                    <div class="col-md-12">
                                        <div class="box box-primary">
                                            <div class="box-header with-border">
                                                <h4  style="text-align: center">Educational Background</h4>
                                            </div>
                                            <div class="box-body">
                                                <div class="row">
                                                    <div class="box-header with-border">
                                                        <div class = "box-title">Secondary</div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class = "col-md-12">
                                                        <label>Secondary (Name of School):</label>
                                                        <p id="secondaryNameView"></p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class = "col-md-12">
                                                        <label>Location:</label>
                                                        <p id="secondartLocationView"></p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class = "col-md-12">
                                                        <label>Inclusive Dates of Attendance:</label>
                                                        <p id="secondaryInclusiveView"></p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class = "col-md-12">
                                                        <label>Year Graduated/Degree:</label>
                                                        <p id="secondaryYearGradView"></p>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="box-header with-border">
                                                        <div class = "box-title">Tertiary</div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class = "col-md-12">
                                                        <label>College (Name of School):</label>
                                                        <p id="collegeNameView"></p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class = "col-md-12">
                                                        <label>Location:</label>
                                                        <p id="collegeLocationView"></p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class = "col-md-12">
                                                        <label>Course Taken:</label>
                                                        <p id="collegeCourseTaken"></p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class = "col-md-12">
                                                        <label>Inclusive Dates of Attendance:</label>
                                                        <p id="collegeInclusiveView"></p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class = "col-md-12">
                                                        <label>Year Graduated/Stopped:</label>
                                                        <p id="collegeYearGradView"></p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class = "col-md-12">
                                                        <label>College Remarks:</label>
                                                        <p id="collegeGradorStopped"></p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class = "col-md-12">
                                                        <label>Other Schools Attended, Dates of Attendance, and Cerificate / Degree Earned:</label>
                                                        <p id="otherSchoolsView"></p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class = "col-md-12">
                                                        <label>Civil Service Eligibility, if any, and other similar qualification/s required.
                                                            State rating & Professional Regulations Commision License No. if applicable:</label>

                                                        <p id="civilServiceView"></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="padding-top : 20px" >
                                    <div class="col-md-12">
                                        <div class="box box-primary">
                                            <div class="box-header with-border">
                                                <h4 style="text-align : center;">Places of Residence since Birth</h4>
                                            </div>
                                            <div class="box-body">
                                                <div class = "row" style="padding-top : 20px;">
                                                    <div class = "form-group col-md-12">
                                                        <h4>Residence/s:</h4>

                                                        <div style = " height : 100%; overflow-x: auto">
                                                            <table class="tableendorse table-hover table-condensed" id = ""  style = "overflow-x:auto; border-collapse:collapse; table-layout:fixed ; width : 150%; ">
                                                                <thead>
                                                                <tr>
                                                                    <th colspan="1">Inclusive Dates</th>
                                                                    <th colspan="2">Complete Address</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody id="acct_table_residences_view">

                                                                </tbody>
                                                            </table>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="padding-top : 20px">
                                    <div class="col-md-12">
                                        <div class="box box-primary">
                                            <div class="box-header with-border">
                                                <h4 style="text-align : center">Work Experience</h4>
                                            </div>
                                            <div class="box-body">
                                                <div class = "row">
                                                    <div class = "col-md-12">
                                                        <h4>List of position/designation for the last 10 years to present:</h4>

                                                        <div style = " height : 100%; overflow-x: auto">
                                                            <table class="table-hover table-condensed" id = ""  style = "overflow-x:auto; border-collapse:collapse; table-layout:fixed ; width : 200%; ">
                                                                <thead>
                                                                <tr>
                                                                    <th colspan="1">Date Started</th>
                                                                    <th colspan="1">Date Ended</th>
                                                                    <th colspan="1">Present/-</th>
                                                                    <th colspan="1">Company/Employer Name</th>
                                                                    <th colspan="1">Designation</th>
                                                                    <th colspan="1">Employee No.</th>
                                                                    <th colspan="2">Company/Employer Address </th>
                                                                    <th colspan="1">Company/Employer Contact No</th>
                                                                    <th colspan="1">Name of Supervisor</th>
                                                                    <th colspan="1">Contact number of Supervisor</th>
                                                                    <th colspan="2">Reason for Leaving</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody id="acct_table_work_exp_view">
                                                                </tbody>
                                                            </table>
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class = "row">
                                                    <div class = "col-md-12">
                                                        <label for="">Have you ever been dismissed or forced to resign from a position?
                                                            If yes, explain:</label>

                                                        <p><span id="forceResignView"></span>. <span id="forceResignReasonView"></span></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="padding-top : 20px;">
                                    <div class="col-md-12">
                                        <div class="box box-primary">
                                            <div class="box-header with-border">
                                                <div class = "box-title">Professional References</div>
                                            </div>
                                            <div class="box-body">
                                                <div class = "row" style="padding-top : 20px;">
                                                    <div class = "form-group col-md-12">
                                                        <h4>Professional References:</h4>

                                                        <div style = " height : 100%; overflow-x: auto">
                                                            <table class="table-hover table-condensed" id = ""  style = "overflow-x:auto; border-collapse:collapse; table-layout:fixed ; width : 200%; ">
                                                                <thead>
                                                                <tr>
                                                                    <th colspan="1">Name</th>
                                                                    <th colspan="1">Position Employment</th>
                                                                    <th colspan="2">Company Address</th>
                                                                    <th colspan="1">Email Address <small style="color : orange">(optional)</small></th>
                                                                    <th colspan="1">Telephone No./Mobile No.</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody id="acct_table_character_view">
                                                                </tbody>
                                                            </table>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="padding-top : 20px;">
                                    <div class="col-md-12">
                                        <div class="box box-primary">
                                            <div class="box-header with-border">
                                                <div class = "box-title">Membership in Civic/Religious Organization</div>
                                            </div>
                                            <div class="box-body">
                                                <div class = "row" style="padding-top : 20px;">
                                                    <div class = "form-group col-md-12">
                                                        <h4>List of organizations: </h4>

                                                        <div style = " height : 100%; overflow-x: auto">
                                                            <table class="table-hover table-condensed" id = ""  style = "overflow-x:auto; border-collapse:collapse; table-layout:fixed ; width : 150%; ">
                                                                <thead>
                                                                <tr>
                                                                    <th>Name of Organization</th>
                                                                    <th>Date of Membership</th>
                                                                    <th>Position</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody id="acct_table_org_view">
                                                                </tbody>
                                                            </table>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="padding-top : 20px;">
                                    <div class="col-md-12">
                                        <div class="box box-primary">
                                            <div class="box-header with-border">
                                                <div class = "box-title">Trainings Attended</div>
                                            </div>
                                            <div class="box-body">
                                                <div class = "row" style="padding-top : 20px;">
                                                    <div class = "form-group col-md-12">
                                                        <h4>List of trainings:</h4>

                                                        <div style = " height : 100%; overflow-x: auto">
                                                            <table class="tableendorse table-hover table-condensed" id = ""  style = "overflow-x:auto; border-collapse:collapse; table-layout:fixed ; width : 150%; ">
                                                                <thead>
                                                                <tr>
                                                                    <th>Nature/Title</th>
                                                                    <th>Conducted by</th>
                                                                    <th>Year - Taken</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody id="acct_training_table_view">
                                                                </tbody>
                                                            </table>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{--<div class="row" style="padding-top : 20px;">--}}
                                    {{--<div class="col-md-12">--}}
                                        {{--<div class="box box-primary">--}}
                                            {{--<div class="box-header with-border">--}}
                                                {{--<div class = "box-title">Credit References</div>--}}
                                            {{--</div>--}}
                                            {{--<div class="box-body">--}}
                                                {{--<div class = "row" style="padding-top : 20px;">--}}
                                                    {{--<div class = "form-group col-md-12">--}}
                                                        {{--<h4>List of Credit Card/s:</h4>--}}

                                                        {{--<div style = " height : 100%; overflow-x: auto">--}}
                                                            {{--<table class="tableendorse table-hover table-condensed" id = ""  style = "overflow-x:auto; border-collapse:collapse; table-layout:fixed ; width : 150%; ">--}}
                                                                {{--<thead>--}}
                                                                {{--<tr>--}}
                                                                    {{--<th>Credit Card</th>--}}
                                                                    {{--<th>Number</th>--}}
                                                                    {{--<th>Credit Limit/Status</th>--}}
                                                                    {{--<th>Expiry Date</th>--}}
                                                                {{--</tr>--}}
                                                                {{--</thead>--}}
                                                                {{--<tbody id="acct_credit_table_view">--}}
                                                                {{--</tbody>--}}
                                                            {{--</table>--}}
                                                        {{--</div>--}}

                                                    {{--</div>--}}
                                                {{--</div>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            </div>
                            <!-- /.box-body -->
                        </div>
                        <!-- /.box -->
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                {{--<button type="button" class="btn btn-outline pull-right" data-dismiss="modal" id="btnModalCloseSending">Close</button>--}}
            </div>
        </div>
    </div>
</div>

<div class="modal modal-warning fade" id="modal-loading-ajax-pace">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                {{--<button type="button" class="close" data-dismiss="modal" aria-label="Close">--}}
                {{--<span aria-hidden="true">&times;</span></button>--}}
                <center><h5 class="modal-title">PLEASE WAIT</h5></center>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 form-group">
                        <center><img width="5%" src="{{asset('/dist/img/loading.gif')}}"></center>
                        <center>fetching data..</center>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="modal-email-receiver">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class = "row">
                    <div class = "col-md-12">
                        <div class="panel panel-success">
                            <div class="panel-heading"><center>
                                    <h4>Add / Remove Client Emails Receiver</h4>
                                </center></div>
                            <div class="panel-body">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">Select Client</label>
                                                <select name="" id="email_sinder_client" class="select2" style="width: 100%">
                                                    <option value="">-</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Select User to Position</label>
                                                <select name="" id="email_risiver_positions" class="select2" style="width: 100%">
                                                    <option value="">-</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Select User to Receive</label>
                                                <select name="" id="email_risiver_user" class="select2" style="width: 100%">
                                                    <option value="">-</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <button class="btn btn-success" id="add_as_client_recipient" style="margin: 20%">Add as Recipient</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <table class="table-condensed table-hover" width="100%" id="endor_receivers_table">
                                            <thead>
                                            <tr>
                                                <th>Email Receiver Name</th>
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
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modal-requisition_form" >
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            {{--<div class="modal-header">--}}
            {{--<button type="button" class="close" data-dismiss="modal" aria-label="Close">--}}
            {{--<span aria-hidden="true">&times;</span></button>--}}
            {{--<h4 style = "text-align : center"><b>SUPPLIES/EQUIPMENT/FURNITURE <br> REQUISITION FORM</b></h4>--}}
            {{--</div>--}}
            <div class="modal-body">
                <div class = "row" style = "padding-top : 30px;">
                    <div class = "col-md-12">
                        <table class="table-condensed" style = "overflow-x:auto; border-collapse:collapse; table-layout:fixed; width : 100%" id = "tableRequisitionAdmin">
                            <tr>
                                <th colspan="4" style = "background-color: darkgrey; color : black; "><h4 style= "font-weight:bold;">SUPPLIES/EQUIPMENT/FURNITURE <br> REQUISITION FORM</h4></th>
                            </tr>
                            <tr>

                                <td colspan="2" style="font-weight:bold;">
                                    <div class ="row">
                                        <div class = "col-md-3">
                                        </div>
                                        <div class = "col-md-9">
                                            <span class = "pull-left">  Date of Request:</span>
                                        </div>
                                    </div>
                                </td>
                                <td colspan = "2"><input type="date" class = "form-control toClear" id = "dateOfRequestAdmin"></td>
                            </tr>
                            <tr>
                                <td colspan="2" style="font-weight:bold;">
                                    <div class ="row">
                                        <div class = "col-md-3">
                                        </div>
                                        <div class = "col-md-9">
                                            <span class = "pull-left"> Requested by:</span>
                                        </div>
                                    </div>
                                </td>
                                <td colspan = "2"><input type="text" class = "form-control " id = "requestedRequi" disabled></td>
                            </tr>
                            <tr>
                                <td colspan="2" style="font-weight:bold;">
                                    <div class ="row">
                                        <div class = "col-md-3">
                                        </div>
                                        <div class = "col-md-9">
                                            <span class = "pull-left"> Requested for:</span>
                                        </div>
                                    </div>
                                </td>
                                <td colspan = "2">
                                    <div class = "row">
                                        <div class= "col-md-8">
                                            <input type="text" class = "form-control toClear" id = "requestedRequiFor">
                                        </div>
                                        <div class= "col-md-4">
                                            <input type="text" class = "form-control toClear" id = "requestedRequiForID" placeholder="Emp ID">
                                        </div>
                                    </div></td>
                            </tr>
                            <tr>
                                <td colspan="2" style="font-weight:bold;">
                                    <div class ="row">
                                        <div class = "col-md-3">
                                        </div>
                                        <div class = "col-md-9">
                                            <span class = "pull-left"> Office Location-Department-Position:</span>
                                        </div>
                                    </div>
                                </td>
                                <td colspan = "2"><input type="text" class = "form-control toClear" id = "officeLocRequi"></td>
                            </tr>
                            <tr>
                                <td colspan="2" style="font-weight:bold;">
                                    <div class ="row">
                                        <div class = "col-md-3">
                                        </div>
                                        <div class = "col-md-9">
                                            <span class = "pull-left"> Date needed:</span>
                                        </div>
                                    </div>
                                </td>
                                <td colspan = "2"><input type="date" class = "form-control toClear" id = "dateNeededRequi"></td>
                            </tr>
                            <tr>
                                <td colspan="2" style="font-weight:bold;">
                                    <div class ="row">
                                        <div class = "col-md-3">
                                        </div>
                                        <div class = "col-md-9">
                                            <span class = "pull-left"> Approved by:</span>
                                        </div>
                                    </div>
                                </td>
                                <td colspan = "2"><input type="text" class = "form-control toClear" id = "approvedByRequi"></td>
                            </tr>
                            <tr>
                                <td colspan="2" style="font-weight:bold;">
                                    <div class ="row">
                                        <div class = "col-md-3">
                                        </div>
                                        <div class = "col-md-9">
                                            <span class = "pull-left"> Approval Date:</span>
                                        </div>
                                    </div>
                                </td>
                                <td colspan = "2"><input type="date" class = "form-control toClear" id = "approvalDateRequi"></td>
                            </tr>
                            <tr>
                                <td colspan="4" style = "background-color: darkgrey; color : black; font-weight:bold;"> Reason for request and requirement</td>
                            </tr>
                            <tr>
                                <td colspan="2" style="font-weight:bold;">
                                    <div class ="row">
                                        <div class = "col-md-3">
                                        </div>
                                        <div class = "col-md-9">
                                            <span class = "pull-left"> <input type="radio" name = "typeReqRequi" id = "newReq" class = "toDisable" checked> New Request</span>
                                        </div>
                                    </div>
                                </td>
                                <td colspan="2" rowspan="2"><textarea class="form-control toClear" id = "req_reason_remarks" rows="2"></textarea></td>
                            </tr>
                            <tr>
                                <td colspan="2" style="font-weight:bold;">
                                    <div class ="row">
                                        <div class = "col-md-3">
                                        </div>
                                        <div class = "col-md-9">
                                            <span class = "pull-left"> <input type="radio" name = "typeReqRequi" id = "replaceRequi" class = "toDisable"> Replacement</span>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4" style = "background-color: darkgrey; color : black; font-weight:bold; ">Supplies/Equipment/Furniture</td>
                            </tr>
                            <tr>
                                <td colspan="2" style="font-weight:bold;">
                                    <div class ="row">
                                        <div class = "col-md-3">
                                        </div>
                                        <div class = "col-md-9">
                                            <span class = "pull-left"> <input type="checkbox" value = "Office Supplies" class = "requiList"> Office Supplies</span>
                                        </div>
                                    </div>
                                </td>
                                <td colspan="2" style="font-weight:bold;">
                                    <div class ="row">
                                        <div class = "col-md-3">
                                        </div>
                                        <div class = "col-md-9">
                                            <span class = "pull-left"> <input type="checkbox" value = "Shredder" class = "requiList" > Shredder</span>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" style="font-weight:bold;">
                                    <div class ="row">
                                        <div class = "col-md-3">
                                        </div>
                                        <div class = "col-md-9">
                                            <span class = "pull-left"> <input type="checkbox" value = "Uniform" class = "requiList" > Uniform</span>
                                        </div>
                                    </div>
                                </td>
                                <td colspan="2" style="font-weight:bold;">
                                    <div class ="row">
                                        <div class = "col-md-3">
                                        </div>
                                        <div class = "col-md-9">
                                            <span class = "pull-left"> <input type="checkbox" value ="Fire Extinguisher" class = "requiList" > Fire Extinguisher</span>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" style="font-weight:bold;">
                                    <div class ="row">
                                        <div class = "col-md-3">
                                        </div>
                                        <div class = "col-md-9">
                                            <span class = "pull-left"> <input type="checkbox" value = "Load" class = "requiList"> Load</span>
                                        </div>
                                    </div>
                                </td>
                                <td colspan="2" style="font-weight:bold;">
                                    <div class ="row">
                                        <div class = "col-md-3">
                                        </div>
                                        <div class = "col-md-9">
                                            <span class = "pull-left"> <input type="checkbox" value = "Chair" class = "requiList" > Chair</span>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" style="font-weight:bold;">
                                    <div class ="row">
                                        <div class = "col-md-3">
                                        </div>
                                        <div class = "col-md-9">
                                            <span class = "pull-left"> <input type="checkbox" value = "Computer" class ="requiList" > Computer</span>
                                        </div>
                                    </div>
                                </td>
                                <td colspan="2" style="font-weight:bold;">
                                    <div class ="row">
                                        <div class = "col-md-3">
                                        </div>
                                        <div class = "col-md-9">
                                            <span class = "pull-left"> <input type="checkbox" value = "Filing Cabinet" class = "requiList" > Filing Cabinet</span>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" style="font-weight:bold;">
                                    <div class ="row">
                                        <div class = "col-md-3">
                                        </div>
                                        <div class = "col-md-9">
                                            <span class = "pull-left"> <input type="checkbox" value = "Printer" class = "requiList" > Printer</span>
                                        </div>
                                    </div>
                                </td>
                                <td colspan="2" style="font-weight:bold;">
                                    <div class ="row">
                                        <div class = "col-md-3">
                                        </div>
                                        <div class = "col-md-9">
                                            <span class = "pull-left"> <input type="checkbox" value = "Table" class = "requiList"  > Table</span>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" style="font-weight:bold;">
                                    <div class ="row">
                                        <div class = "col-md-3">
                                        </div>
                                        <div class = "col-md-9">
                                            <span class = "pull-left"><input type="checkbox" value = "IP Phone" class = "requiList" > IP Phone</span>
                                        </div>
                                    </div>
                                </td>
                                <td colspan="2" style="font-weight:bold;">
                                    <div class ="row">
                                        <div class = "col-md-3">
                                        </div>
                                        <div class = "col-md-9">
                                            <span class = "pull-left"><input type="checkbox" value = "Shelves" class = "requiList" > Shelves</span>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" style="font-weight:bold;">
                                    <div class ="row">
                                        <div class = "col-md-3">
                                        </div>
                                        <div class = "col-md-9">
                                            <span class = "pull-left"><input type="checkbox" value = "Mobile Phone" class = "requiList" > Mobile Phone</span>
                                        </div>
                                    </div>
                                </td>
                                <td colspan="2" style="font-weight:bold;">
                                    <div class ="row">
                                        <div class = "col-md-3">
                                        </div>
                                        <div class = "col-md-9">
                                            <span class = "pull-left"><input type="checkbox" value = "Accesories" class = "requiList" > Accesories</span>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" style="font-weight:bold;">
                                    <div class ="row">
                                        <div class = "col-md-3">
                                        </div>
                                        <div class = "col-md-9">
                                            <span class = "pull-left"><input type="checkbox" value = "Projector" class = "requiList" > Projector</span>
                                        </div>
                                    </div>
                                </td>
                                <td colspan="2" style="font-weight:bold;">
                                    <div class ="row">
                                        <div class = "col-md-3">
                                        </div>
                                        <div class = "col-md-9">
                                            <span class = "pull-left"><input type="checkbox" value = "Others (Please Specify)" class = "requiList"> Others (Please Specify):</span>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" style="font-weight:bold;">
                                    <div class ="row">
                                        <div class = "col-md-3">
                                        </div>
                                        <div class = "col-md-9">
                                            <span class = "pull-left"><input type="checkbox" value = "Photocopier" class = "requiList" > Photocopier</span>
                                        </div>
                                    </div>
                                </td>
                                <td colspan="2" style="font-weight:bold;">
                                    <div class ="row">
                                        <div class = "col-md-3">
                                        </div>
                                        <div class = "col-md-9">
                                            <span class = "pull-left"><input type="checkbox" value="namecheckother1" class = "requiList"> <input type="text" id = "otherCheck-0" class = "toDisable toClear"></span>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" style="font-weight:bold;">
                                    <div class ="row">
                                        <div class = "col-md-3">
                                        </div>
                                        <div class = "col-md-9">
                                            <span class = "pull-left"><input type="checkbox" value = "ID Maker" class = "requiList" > ID Maker</span>
                                        </div>
                                    </div>
                                </td>
                                <td colspan="2" style="font-weight:bold;">
                                    <div class ="row">
                                        <div class = "col-md-3">
                                        </div>
                                        <div class = "col-md-9">
                                            <span class = "pull-left"><input type="checkbox" class ="requiList" value = "namecheckother2"  > <input type="text"  id = "otherCheck-1" class = "toDisable toClear"></span>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" style="font-weight:bold;">
                                    <div class ="row">
                                        <div class = "col-md-3">
                                        </div>
                                        <div class = "col-md-9">
                                            <span class = "pull-left"><input type="checkbox" class = "requiList" > Scanner</span>
                                        </div>
                                    </div>
                                </td>
                                <td colspan="2" style="font-weight:bold;">
                                    <div class ="row">
                                        <div class = "col-md-3">
                                        </div>
                                        <div class = "col-md-9">
                                            <span class = "pull-left"><input type="checkbox" class = "requiList" value = "namecheckother3" > <input type="text"  id = "otherCheck-2" class = "toDisable toClear" ></span>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </table>
                        <table class="table-condensed" style = "overflow-x:auto; border-collapse:collapse; table-layout:fixed; width : 100%" id = "brandItemsTable">
                            <tbody id = "appBrand">

                            </tbody>
                        </table>
                        <table class="table-condensed" style = "overflow-x:auto; border-collapse:collapse; table-layout:fixed; width : 100%">
                            <tr>
                                <td colspan="1" style = "background-color: darkgrey; color : black; font-weight:bold;"></td>
                                <td colspan="1" style = "background-color: darkgrey; color : black; font-weight:bold;"></td>
                                <td colspan="1" style = "background-color: darkgrey; color : black; font-weight:bold;">Grand Total</td>
                                <td colspan="1" style = "background-color: darkgrey; color : black; font-weight:bold;"><span><input type="text" class = "form-control toClear" id = "totalAmountRequi" disabled></span></td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class = "row" style = "padding-top : 20px">
                    <div class = "col-md-12">
                        <h5 style = "text-align : center"><b>Note: </b> <text style = "font-style: italic">All requisitions require approval from Department Head. A purchase order will not be issued until all applicable approvals have been applied.</text></h5>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <span id = "showHideSendRequestRequi" hidden><button type="button" class="btn btn-primary pull-right" id = "sendRequisitionToAdmin">Send Request <span id = "loadingSpanSendReq" hidden><img src="{{ asset('dist/img/loading.gif') }}" style="width: 7%; margin-left : 10px;"></span></button></span>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modal_requisition_approval" >
    <div class="modal-dialog" style = "width: 90%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 style = "text-align : center"><b>REQUISITION APPROVAL</b></h4>
            </div>
            <div class="modal-body">
                <div class = "row">
                    <div class="col-md-6">
                        <div class="box box-default">
                            <div class="box-header with-border">
                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                    </button>
                                </div>
                                <!-- /.box-tools -->
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                                <div class = "row" style = "padding-top : 30px;">
                                    <div class = "col-md-12">
                                        <table class="table-condensed" style = "overflow-x:auto; border-collapse:collapse; table-layout:fixed; width : 100%" >
                                            <tr>
                                                <th colspan="4" style = "background-color: darkgrey; color : black; "><h4 style= "font-weight:bold;">SUPPLIES/EQUIPMENT/FURNITURE <br> REQUISITION FORM</h4></th>
                                            </tr>
                                            <tr>
                                                <td colspan="2" style="font-weight:bold;">
                                                    <div class ="row">
                                                        <div class = "col-md-3">
                                                        </div>
                                                        <div class = "col-md-9">
                                                            <span class = "pull-left">  Date of Request:</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td colspan = "2"><input type="date" class = "form-control toClear_app" id = "dateOfRequestAdmin_app" disabled></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" style="font-weight:bold;">
                                                    <div class ="row">
                                                        <div class = "col-md-3">
                                                        </div>
                                                        <div class = "col-md-9">
                                                            <span class = "pull-left">   Requested by:</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td colspan = "2"><input type="text" class = "form-control toClear_app" id = "requestedRequi_app" disabled></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" style="font-weight:bold;">
                                                    <div class ="row">
                                                        <div class = "col-md-3">
                                                        </div>
                                                        <div class = "col-md-9">
                                                            <span class = "pull-left">  Requested for:</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td colspan = "2">
                                                    <div class = "row">
                                                        <div class= "col-md-8">
                                                            <input type="text" class = "form-control toClear_app" id = "requestedRequiFor_app" disabled>
                                                        </div>
                                                        <div class= "col-md-4">
                                                            <input type="text" class = "form-control toClear_app" id = "requestedRequiForID_app" disabled>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" style="font-weight:bold;">
                                                    <div class ="row">
                                                        <div class = "col-md-3">
                                                        </div>
                                                        <div class = "col-md-9">
                                                    <span class = "pull-left">
                                                        Office Location-Department-Position:
                                                    </span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td colspan = "2"><input type="text" class = "form-control toClear_app" id = "officeLocRequi_app" disabled></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" style="font-weight:bold;">
                                                    <div class ="row">
                                                        <div class = "col-md-3">
                                                        </div>
                                                        <div class = "col-md-9">
                                                    <span class = "pull-left">
                                                        Date needed:
                                                    </span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td colspan = "2"><input type="date" class = "form-control toClear_app" id = "dateNeededRequi_app" disabled></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" style="font-weight:bold;">
                                                    <div class ="row">
                                                        <div class = "col-md-3">
                                                        </div>
                                                        <div class = "col-md-9">
                                                    <span class = "pull-left">
                                                      Approved by:
                                                    </span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td colspan = "2"><input type="text" class = "form-control toClear_app" id = "approvedByRequi_app" disabled></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" style="font-weight:bold;">
                                                    <div class ="row">
                                                        <div class = "col-md-3">
                                                        </div>
                                                        <div class = "col-md-9">
                                                    <span class = "pull-left">
                                                    Approval Date:
                                                    </span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td colspan = "2"><input type="date" class = "form-control toClear_app" id = "approvalDateRequi_app" disabled></td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" style = "background-color: darkgrey; color : black; font-weight:bold;"> Reason for request and requirement</td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" style="font-weight:bold;">
                                                    <div class ="row">
                                                        <div class = "col-md-3">
                                                        </div>
                                                        <div class = "col-md-9">
                                                    <span class = "pull-left">
                                                        <input type="radio" name = "typeReqRequi_app" id = "clickNew_app"  disabled> New Request
                                                    </span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td colspan="2" rowspan="2"><textarea class="form-control toClear_app" id = "req_reason_remarks_app" rows="2" disabled></textarea></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" style="font-weight:bold;">
                                                    <div class ="row">
                                                        <div class = "col-md-3">
                                                        </div>
                                                        <div class = "col-md-9">
                                                    <span class = "pull-left">
                                                        <input type="radio" name = "typeReqRequi_app"  id = "clickReplacement_app" disabled> Replacement
                                                    </span>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" style = "background-color: darkgrey; color : black; font-weight:bold; ">Supplies/Equipment/Furniture</td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" style="font-weight:bold;">
                                                    <div class ="row">
                                                        <div class = "col-md-3">
                                                        </div>
                                                        <div class = "col-md-9">
                                                    <span class = "pull-left">
                                                        <input type="checkbox" value = "Office Supplies" class = "requiListview_app" disabled> Office Supplies
                                                    </span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td colspan="2" style="font-weight:bold;">
                                                    <div class ="row">
                                                        <div class = "col-md-3">
                                                        </div>
                                                        <div class = "col-md-9">
                                                    <span class = "pull-left">
                                                           <input type="checkbox" value = "Shredder" class = "requiListview_app" disabled> Shredder
                                                    </span>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" style="font-weight:bold;">
                                                    <div class ="row">
                                                        <div class = "col-md-3">
                                                        </div>
                                                        <div class = "col-md-9">
                                                    <span class = "pull-left">
                                                           <input type="checkbox" value = "Uniform" class = "requiListview_app" disabled> Uniform
                                                    </span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td colspan="2" style="font-weight:bold;">
                                                    <div class ="row">
                                                        <div class = "col-md-3">
                                                        </div>
                                                        <div class = "col-md-9">
                                                    <span class = "pull-left">
                                                        <input type="checkbox" value ="Fire Extinguisher" class = "requiListview_app" disabled> Fire Extinguisher
                                                    </span>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" style="font-weight:bold;">
                                                    <div class ="row">
                                                        <div class = "col-md-3">
                                                        </div>
                                                        <div class = "col-md-9">
                                                    <span class = "pull-left">
                                                         <input type="checkbox" value = "Load" class = "requiListview_app" disabled> Load
                                                    </span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td colspan="2" style="font-weight:bold;">
                                                    <div class ="row">
                                                        <div class = "col-md-3">
                                                        </div>
                                                        <div class = "col-md-9">
                                                    <span class = "pull-left">
                                                          <input type="checkbox" value = "Chair" class = "requiListview_app" disabled> Chair
                                                    </span>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" style="font-weight:bold;">
                                                    <div class ="row">
                                                        <div class = "col-md-3">
                                                        </div>
                                                        <div class = "col-md-9">
                                                    <span class = "pull-left">
                                                       <input type="checkbox" value = "Computer" class ="requiListview_app" disabled> Computer
                                                    </span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td colspan="2" style="font-weight:bold;">
                                                    <div class ="row">
                                                        <div class = "col-md-3">
                                                        </div>
                                                        <div class = "col-md-9">
                                                    <span class = "pull-left">
                                                       <input type="checkbox" value = "Filing Cabinet" class = "requiListview_app" disabled> Filing Cabinet
                                                    </span>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" style="font-weight:bold;">
                                                    <div class ="row">
                                                        <div class = "col-md-3">
                                                        </div>
                                                        <div class = "col-md-9">
                                                    <span class = "pull-left">
                                                        <input type="checkbox" value = "Printer" class = "requiListview_app" disabled> Printer
                                                    </span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td colspan="2" style="font-weight:bold;">
                                                    <div class ="row">
                                                        <div class = "col-md-3">
                                                        </div>
                                                        <div class = "col-md-9">
                                                    <span class = "pull-left">
                                                       <input type="checkbox" value = "Table" class = "requiListview_app"  disabled> Table
                                                    </span>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" style="font-weight:bold;">
                                                    <div class ="row">
                                                        <div class = "col-md-3">
                                                        </div>
                                                        <div class = "col-md-9">
                                                    <span class = "pull-left">
                                                      <input type="checkbox" value = "IP Phone" class = "requiListview_app" disabled> IP Phone
                                                    </span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td colspan="2" style="font-weight:bold;">
                                                    <div class ="row">
                                                        <div class = "col-md-3">
                                                        </div>
                                                        <div class = "col-md-9">
                                                    <span class = "pull-left">
                                                       <input type="checkbox" value = "Shelves" class = "requiListview_app" disabled> Shelves
                                                    </span>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" style="font-weight:bold;">
                                                    <div class ="row">
                                                        <div class = "col-md-3">
                                                        </div>
                                                        <div class = "col-md-9">
                                                    <span class = "pull-left">
                                                      <input type="checkbox" value = "Mobile Phone" class = "requiListview_app" disabled> Mobile Phone
                                                    </span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td colspan="2" style="font-weight:bold;">
                                                    <div class ="row">
                                                        <div class = "col-md-3">
                                                        </div>
                                                        <div class = "col-md-9">
                                                    <span class = "pull-left">
                                                     <input type="checkbox" value = "Accesories" class = "requiListview_app" disabled> Accesories
                                                    </span>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" style="font-weight:bold;">
                                                    <div class ="row">
                                                        <div class = "col-md-3">
                                                        </div>
                                                        <div class = "col-md-9">
                                                    <span class = "pull-left">
                                                      <input type="checkbox" value = "Projector" class = "requiListview_app" disabled> Projector
                                                    </span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td colspan="2" style="font-weight:bold;">
                                                    <div class ="row">
                                                        <div class = "col-md-3">
                                                        </div>
                                                        <div class = "col-md-9">
                                                    <span class = "pull-left">
                                                        <input type="checkbox" value = "Others (Please Specify)" class = "requiListview_app" disabled> Others (Please Specify):
                                                    </span>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" style="font-weight:bold;">
                                                    <div class ="row">
                                                        <div class = "col-md-3">
                                                        </div>
                                                        <div class = "col-md-9">
                                                    <span class = "pull-left">
                                                      <input type="checkbox" value = "Photocopier" class = "requiListview_app" disabled> Photocopier
                                                    </span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td colspan="2" style="font-weight:bold;">
                                                    <div class ="row">
                                                        <div class = "col-md-3">
                                                        </div>
                                                        <div class = "col-md-9">
                                                    <span class = "pull-left">
                                                        <input type="checkbox" value="namecheckother1" class = "requiListview_app" disabled>
                                                        <input type="text" id = "otherCheck-0_view_app" class = "toClear_app" disabled>
                                                    </span>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" style="font-weight:bold;">
                                                    <div class ="row">
                                                        <div class = "col-md-3">
                                                        </div>
                                                        <div class = "col-md-9">
                                                    <span class = "pull-left">
                                                       <input type="checkbox" value = "ID Maker" class = "requiListview_app" disabled> ID Maker
                                                    </span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td colspan="2" style="font-weight:bold;">
                                                    <div class ="row">
                                                        <div class = "col-md-3">
                                                        </div>
                                                        <div class = "col-md-9">
                                                    <span class = "pull-left">
                                                        <input type="checkbox" class ="requiListview_app" value = "namecheckother2"  disabled>
                                                        <input type="text"  id = "otherCheck-1_view_app" class = "toClear_app" disabled>
                                                    </span>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" style="font-weight:bold;">
                                                    <div class ="row">
                                                        <div class = "col-md-3">
                                                        </div>
                                                        <div class = "col-md-9">
                                                    <span class = "pull-left">
                                                       <input type="checkbox" class = "requiListview_app" disabled> Scanner
                                                    </span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td colspan="2" style="font-weight:bold;">
                                                    <div class ="row">
                                                        <div class = "col-md-3">
                                                        </div>
                                                        <div class = "col-md-9">
                                                    <span class = "pull-left">
                                                       <input type="checkbox" class = "requiListview_app" value = "namecheckother3" disabled>
                                                    <input type="text"  id = "otherCheck-2_view_app" class = "toClear_app" disabled>
                                                    </span>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                        <table class="table-condensed" style = "overflow-x:auto; border-collapse:collapse; table-layout:fixed; width : 100%" >
                                            <tbody id = "appBrandview_app">
                                            <tr>
                                                <th colspan="1" style = "background-color: darkgrey; color : black; font-weight:bold; ">Brand - Item - Description</th>
                                                <th colspan="1" style = "background-color: darkgrey; color : black; font-weight:bold; ">Quantity</th>
                                                <th colspan="1" style = "background-color: darkgrey; color : black; font-weight:bold; ">Unit Price</th>
                                                <th colspan="1" style = "background-color: darkgrey; color : black; font-weight:bold;">Total Amount</th>
                                            </tr>
                                            </tbody>
                                        </table>
                                        <table class="table-condensed" style = "overflow-x:auto; border-collapse:collapse; table-layout:fixed; width : 100%">
                                            <tr>
                                                <td colspan="1" style = "background-color: darkgrey; color : black; font-weight:bold;"></td>
                                                <td colspan="1" style = "background-color: darkgrey; color : black; font-weight:bold;"></td>
                                                <td colspan="1" style = "background-color: darkgrey; color : black; font-weight:bold;">Grand Total</td>
                                                <td colspan="1" style = "background-color: darkgrey; color : black; font-weight:bold;"><span><input type="text" class = "form-control toClear_app" id = "totalAmountRequi_app" disabled></span></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <div class = "row" style = "padding-top : 20px">
                                    <div class = "col-md-12">
                                        <h5 style = "text-align : center"><b>Note: </b> <text style = "font-style: italic">All requisitions require approval from Department Head. A purchase order will not be issued until all applicable approvals have been applied.</text></h5>
                                    </div>
                                </div>
                                <div class = "row" style = "padding-top : 20px" id = "" >
                                    <div class = "col-md-12">
                                        <span class= "pull-left" ><button type="button" class="btn btn-default" id = "clearFieldsRequiApp">Clear Fields</button></span>
                                        <span id = "showApprovedReject_app" hidden><span class= "pull-right" ><button type="button" class="btn btn-success" id = "approveRequestReq_app">Approve Request <span id = "loadingSpanSendReqAppr1" hidden><img src="{{ asset('dist/img/loading.gif') }}" style="width: 7%; margin-left : 10px;"></span></button></span>
                                        <span class= "pull-right" style = "padding-right : 10px;" ><button type="button" class="btn btn-danger" id = "rejectRequestReq_app">Deny Request <span id = "loadingSpanSendReqAppr2" hidden><img src="{{ asset('dist/img/loading.gif') }}" style="width: 7%; margin-left : 10px;"></span></button></span></span>

                                    </div>
                                </div>


                            </div>
                        </div>

                    </div>
                    <div class = "col-md-6">
                        <div class="box box-default">
                            <!-- /.box-header -->
                            <div class="panel panel-info">
                                <div class="panel-heading">
                                    <h4 style = "text-align : center">Approval and Monitoring</h4>

                                </div>
                                <div class="panel-body">
                                    <div class="form-group">
                                        <div class = "nav-tabs-custom">
                                            <ul class = "nav nav-tabs">
                                                <li class = "active"><a href="#tabRequi_1_app" data-toggle="tab" class = "admin_staff_requi_monit_class_app">Pending Requests</a></li>
                                                <li><a href="#tabRequi_2_app" data-toggle="tab" class = "admin_staff_requi_monit_class_app">Approved Requests</a></li>
                                                <li><a href="#tabRequi_3_app" data-toggle="tab" class = "admin_staff_requi_monit_class_app">Denied Requests</a></li>
                                            </ul>
                                            <div class = "tab-content">
                                                <div class = "tab-pane active" id = "tabRequi_1_app">
                                                    <div class = "row">
                                                        <div class="col-md-12">
                                                            <table class="table-condensed" id = "gen_req_mon_pending_app" width="100%">
                                                                <thead>
                                                                <tr>
                                                                    <th>ID</th>
                                                                    <th>Sent by</th>
                                                                    <th>Date of Request</th>
                                                                    <th>Requested by</th>
                                                                    <th>Office Location-Department-Position</th>
                                                                    <th>Approved by</th>
                                                                    <th>Approval Date</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                                </thead>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class = "tab-pane" id = "tabRequi_2_app">
                                                    <div class = "row">
                                                        <div class="col-md-12">
                                                            <table class="table-condensed" id = "gen_req_mon_approved_app" width="100%">
                                                                <thead>
                                                                <tr>
                                                                    <th>ID</th>
                                                                    <th>Sent by</th>
                                                                    <th>Date of Request</th>
                                                                    <th>Requested by</th>
                                                                    <th>Office Location-Department-Position</th>
                                                                    <th>Approved by</th>
                                                                    <th>Approval Date</th>
                                                                    <th>Management Approver</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                                </thead>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class = "tab-pane" id = "tabRequi_3_app">
                                                    <div class = "row">
                                                        <div class="col-md-12">
                                                            <table class="table-condensed" id = "gen_req_mon_denied" width="100%">
                                                                <thead>
                                                                <tr>
                                                                    <th>ID</th>
                                                                    <th>Sent by</th>
                                                                    <th>Date of Request</th>
                                                                    <th>Requested by</th>
                                                                    <th>Office Location-Department-Position</th>
                                                                    <th>Approved by</th>
                                                                    <th>Approval Date</th>
                                                                    <th>Management Approver</th>
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

                            <!-- /.box-body -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-view-rem-attach-requi-finance">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" style = "text-align: center">Information</h4>
            </div>
            <div class="modal-body">
                <div class = "row" >
                    <div class="col-md-12">
                        <div class = "box box-primary">
                            <div class = "row" style = "padding-top : 20px;">
                                <div class = "col-md-1"></div>
                                <div class = "col-md-10">
                                    <label for="">Remarks/Instructions:</label>
                                    <textarea id="addInstructFinView" rows="4" class="form-control" disabled></textarea>
                                </div>
                                <div class = "col-md-1"></div>
                            </div>
                            <div class = "row" style = "padding-top : 10px; padding-bottom : 10px;">
                                <div class = "col-md-1"></div>
                                <div class="col-md-10">
                                    <h5 style = "font-weight: bold; text-align : center">List of File/s: </h5>
                                    <table class="table-condensed table-hover" width="100%" id="po_fin_requi_files_table">
                                    </table>
                                </div>
                                <div class = "col-md-1"></div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modal_view_approver_rem_requi_done">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Information</h4>
            </div>
            <div class="modal-body">
                <div class = "row">
                    <div class="col-md-12">
                        <div class = "box box-primary">
                            <div class="row" style = "padding-top : 20px;" >
                                <div class="col-md-1"></div>
                                <div class="col-md-10">
                                    <label for="">Remarks: </label>
                                    <textarea class="form-control" id = "view_admin_approve_requi_done_remarks" rows ="3" disabled></textarea>
                                </div>
                                <div class="col-md-1"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal modal-default fade" id="modal-prod-accts-emp">
    <div class="modal-dialog" style="width: 60%" >
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">??</span></button>
                <h4 style="text-align: center">Accounts</h4>
            </div>
            <div class="modal-body">
                <div class="box box-primary">
                    <input type="text" id="sortByToTable" hidden>
                    <input type="text" id="userToLookTable" hidden>
                    <input type="text" id="dateToLookTable" hidden>
                    <input type="text" id="posToLookTable" hidden>
                    <div class="row" style="padding-top : 20px">
                        <div class="col-md-12">
                            <table id="accounts_under_emp_productivity" class="tableendorse table-hover table-condensed" width="100%" style="font-size: 13px;">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Date Endorsed</th>
                                    <th>Time Endorsed</th>
                                    <th>Account</th>
                                    <th>Address</th>
                                    <th>Requestor</th>
                                    <th>TOR</th>
                                    <th>Province</th>
                                    <th>Client</th>
                                    <th>Entry as</th>
                                    <th>Status</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>Date Endorsed</th>
                                    <th>Time Endorsed</th>
                                    <th>Account</th>
                                    <th>Address</th>
                                    <th>Requestor</th>
                                    <th>TOR</th>
                                    <th>Province</th>
                                    <th>Client</th>
                                    <th>Entry as</th>
                                    <th>Status</th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn pull-right" data-dismiss="modal">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal modal-default fade" id="modal-prod-accts-emp-cc">
    <div class="modal-dialog" style="width: 60%" >
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">??</span></button>
                <h4 style="text-align: center">Accounts</h4>
            </div>
            <div class="modal-body">
                <div class="box box-primary">
                    <input type="text" id="sortByToTableCC" hidden>
                    <input type="text" id="userToLookTableCC" hidden>
                    <input type="text" id="dateToLookTableCC" hidden>
                    <input type="text" id="posToLookTableCC" hidden>
                    <div class="row" style="padding-top : 20px">
                        <div class="col-md-12">
                            <table id="accounts_under_emp_productivity_cc" class="tableendorse table-hover table-condensed" width="100%" style="font-size: 13px;">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Type of Request</th>
                                    <th>Date/Time Endorsed</th>
                                    <th>Project</th>
                                    <th>Account Name</th>
                                    <th>Requestor/POC</th>
                                    <th>Status</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th >Type of Request</th>
                                    <th>Date/Time Endorsed</th>
                                    <th>Project</th>
                                    <th>Account Name</th>
                                    <th>Requestor/POC</th>
                                    <th>Status</th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn pull-right" data-dismiss="modal">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modal-email-distrib-list">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Information</h4>
            </div>
            <div class="modal-body">
                <div class = "row">
                    <div class="col-md-12">
                        <div class="nav-tabs-custom">
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#tab_1_distri_list" data-toggle="tab">Tab 1</a></li>
                                <li><a href="#tab_2_distri_list" data-toggle="tab">Tab 2</a></li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab_1_distri_list">
                                    <h4 class="box-title">
                                        Choose Existing Bank
                                    </h4>
                                    <div class="box box-info">
                                        <div class="box-body">
                                            <div class="row">
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <label for="">Client Name</label>
                                                        <select id="admin_active_clients" class="select2 admin_email_dist_valid" style="width: 100%">
                                                            <option value="">-</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <label for="">Applicable (Archipelago)</label>
                                                        <select id="admin_active_clients_bool" class="select2 admin_email_dist_valid" style="width: 100%">
                                                            <option value="">-</option>
                                                            <option value="true">Yes</option>
                                                            <option value="false">No</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <button type="button" class="btn btn-success pull-right" style="margin-top: 15px;" id="add_dist_client">Apply</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane" id="tab_2_distri_list">
                                    <div class="box box-info">
                                        <div class="box-body">
                                            <div class="row">
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <label for="">Client Name</label>
                                                        <select id="admin_active_clientsv2" class="select2" style="width: 100%">
                                                            <option value="">-</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row hide_thisPortion" style="display: none;">
                                                <div class="form-group" id="this_is_false" style="display: none;">
                                                    <div class="col-md-12">
                                                        <table class="table-condensed table-hover" width="100%" style="margin-top: 15px;" id="dist_list_admin">
                                                            <tr style="background-color: black; color: white;">
                                                                <th>EMAIL</th>
                                                                <th>ACTION</th>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2">NO RECORDS FOUND</td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>

                                                <div class="form-group" id="this_is_true1" style="display: none;">
                                                    <div class="col-md-12">
                                                        <table class="table-condensed table-hover masterLoopDist" identifier="1" width="100%" style="margin-top: 15px;" what="LUZON" id="distrib_luzon">
                                                            <thead>
                                                            <tr style="background-color: black; color: white;">
                                                                <th colspan="2">LUZON <button class="pull-right btn-default distrib_master_btn" identifier="distrib_luzon"><i class="glyphicon glyphicon-eye-open"></i></button></th>
                                                            </tr>
                                                            </thead>
                                                            <thead><tr style="background-color: black; color: white;">
                                                                <th>EMAIL</th>
                                                                <th>ACTION</th>
                                                            </tr></thead>
                                                        </table>
                                                    </div>
                                                </div>

                                                <div class="form-group" id="this_is_true2" style="display: none;">
                                                    <div class="col-md-12">
                                                        <table class="table-condensed table-hover masterLoopDist" identifier="2" width="100%" style="margin-top: 15px;" what="VISAYAS" id="distrib_vis">
                                                            <thead>
                                                            <tr style="background-color: black; color: white;">
                                                                <th colspan="2">VISAYAS <button class="pull-right btn-default distrib_master_btn" identifier="distrib_vis"><i class="glyphicon glyphicon-eye-open"></i></button></th>
                                                            </tr>
                                                            </thead>
                                                            <thead><tr style="background-color: black; color: white;">
                                                                <th>EMAIL</th>
                                                                <th>ACTION</th>
                                                            </tr></thead>
                                                        </table>
                                                    </div>
                                                </div>

                                                <div class="form-group" id="this_is_true3" style="display: none;">
                                                    <div class="col-md-12">
                                                        <table class="table-condensed table-hover masterLoopDist" identifier="3" width="100%" style="margin-top: 15px;" what="MINDANAO" id="distrib_min">
                                                            <thead>
                                                            <tr style="background-color: black; color: white;">
                                                                <th colspan="2">MINDANAO <button class="pull-right btn-default distrib_master_btn" identifier="distrib_min"><i class="glyphicon glyphicon-eye-open"></i></button></th>
                                                            </tr>
                                                            </thead>
                                                            <thead><tr style="background-color: black; color: white;">
                                                                <th>EMAIL</th>
                                                                <th>ACTION</th>
                                                            </tr></thead>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row hide_thisPortion" style="display: none;">
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <table class="table-condensed table-hover" width="100%" style="margin-top: 15px">
                                                            <tr style="background-color: black; color: white;">
                                                                <th>ADD EMAIL</th>
                                                                <th class="hide_if_false">ARCHIPELAGO</th>
                                                                <th>ACTION</th>
                                                            </tr>
                                                            <tr>
                                                                <td><input type="email" id="admin_inserted_receiver_email" class="form-control" placeholder="Type Email Here..."></td>
                                                                <td class="hide_if_false">
                                                                    <select id="admin_inserted_receiver_archi" style="width: 100%;" class="form-control">
                                                                        <option value="">-</option>
                                                                        <option value="LUZON">LUZON</option>
                                                                        <option value="VISAYAS">VISAYAS</option>
                                                                        <option value="MINDANAO">MINDANAO</option>
                                                                    </select>
                                                                </td>
                                                                <td><button class="btn btn-success" id="admin_add_email_click_client"><i class="glyphicon glyphicon-plus"></i></button></td>
                                                            </tr>
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
            </div>
            {{--<div class="modal-footer">--}}
            {{----}}
            {{--</div>--}}
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modal-show-location-users-bi" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-5">
                        <label for="">Select a user:</label>
                        <select class="form-control" id="showAllBiUsers"></select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5">
                        <label for="">Select Site Location:</label>
                        <select class="form-control" id="showAllBiSites"></select>
                    </div>
                    <div class="col-md-1">
                        <button class="btn btn-sm btn_add_loc_to_bi btn-success" hidden><i class="fa fa-plus"></i></button>
                    </div>
                </div>

                <div class="row" style="padding-top : 20px;">
                    <div class="col-md-12">
                        <table class="table-hover table-condensed display" style="width : 100%" id="tableLocUnderBI">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Site Name</th>
                                <th>Site Location</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>