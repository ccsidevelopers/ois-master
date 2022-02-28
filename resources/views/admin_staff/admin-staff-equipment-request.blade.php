<div class = "content-wrapper">
    <!-- Content Header (Page header) -->
    <section class = "content-header">
        <h1>
            Supplies/Equipment/Furniture Requests
        </h1>
    </section>

    <!-- Main content -->
    <section class = "content">
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
                                        <td colspan = "2"><input type="date" class = "form-control toClear" id = "dateOfRequestAdmin_view" disabled></td>
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
                                        <td colspan = "2"><input type="text" class = "form-control toClear" id = "requestedRequi_view" disabled></td>
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
                                                    <input type="text" class = "form-control toClear" id = "requestedRequiFor_view" disabled>
                                                </div>
                                                <div class= "col-md-4">
                                                    <input type="text" class = "form-control toClear" id = "requestedRequiForID_view" disabled>
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
                                        <td colspan = "2"><input type="text" class = "form-control toClear" id = "officeLocRequi_view" disabled></td>
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
                                        <td colspan = "2"><input type="date" class = "form-control toClear" id = "dateNeededRequi_view" disabled></td>
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
                                        <td colspan = "2"><input type="text" class = "form-control toClear" id = "approvedByRequi_view" disabled></td>
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
                                        <td colspan = "2"><input type="date" class = "form-control toClear" id = "approvalDateRequi_view" disabled></td>
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
                                                        <input type="radio" name = "typeReqRequi" id = "clickNew"  disabled> New Request
                                                    </span>
                                                </div>
                                            </div>
                                        </td>
                                        <td colspan="2" rowspan="2"><textarea class="form-control toClear" id = "req_reason_remarks_view" rows="2" disabled></textarea></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="font-weight:bold;">
                                            <div class ="row">
                                                <div class = "col-md-3">
                                                </div>
                                                <div class = "col-md-9">
                                                    <span class = "pull-left">
                                                        <input type="radio" name = "typeReqRequi"  id = "clickReplacement" disabled> Replacement
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
                                                        <input type="checkbox" value = "Office Supplies" class = "requiListview" disabled> Office Supplies
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
                                                           <input type="checkbox" value = "Shredder" class = "requiListview" disabled> Shredder
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
                                                           <input type="checkbox" value = "Uniform" class = "requiListview" disabled> Uniform
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
                                                        <input type="checkbox" value ="Fire Extinguisher" class = "requiListview" disabled> Fire Extinguisher
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
                                                         <input type="checkbox" value = "Load" class = "requiListview" disabled> Load
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
                                                          <input type="checkbox" value = "Chair" class = "requiListview" disabled> Chair
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
                                                       <input type="checkbox" value = "Computer" class ="requiListview" disabled> Computer
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
                                                       <input type="checkbox" value = "Filing Cabinet" class = "requiListview" disabled> Filing Cabinet
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
                                                        <input type="checkbox" value = "Printer" class = "requiListview" disabled> Printer
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
                                                       <input type="checkbox" value = "Table" class = "requiListview"  disabled> Table
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
                                                      <input type="checkbox" value = "IP Phone" class = "requiListview" disabled> IP Phone
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
                                                       <input type="checkbox" value = "Shelves" class = "requiListview" disabled> Shelves
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
                                                      <input type="checkbox" value = "Mobile Phone" class = "requiListview" disabled> Mobile Phone
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
                                                     <input type="checkbox" value = "Accesories" class = "requiListview" disabled> Accesories
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
                                                      <input type="checkbox" value = "Projector" class = "requiListview" disabled> Projector
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
                                                        <input type="checkbox" value = "Others (Please Specify)" class = "requiListview" disabled> Others (Please Specify):
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
                                                      <input type="checkbox" value = "Photocopier" class = "requiListview" disabled> Photocopier
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
                                                        <input type="checkbox" value="namecheckother1" class = "requiListview" disabled>
                                                        <input type="text" id = "otherCheck-0_view" class = "toClear" disabled>
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
                                                       <input type="checkbox" value = "ID Maker" class = "requiListview" disabled> ID Maker
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
                                                        <input type="checkbox" class ="requiListview" value = "namecheckother2"  disabled>
                                                        <input type="text"  id = "otherCheck-1_view" class = "toClear" disabled>
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
                                                       <input type="checkbox" class = "requiListview" disabled> Scanner
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
                                                       <input type="checkbox" class = "requiListview" value = "namecheckother3" disabled>
                                                    <input type="text"  id = "otherCheck-2_view" class = "toClear" disabled>
                                                    </span>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                                <table class="table-condensed" style = "overflow-x:auto; border-collapse:collapse; table-layout:fixed; width : 100%" >
                                    <tbody id = "appBrandview">
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
                                        <td colspan="1" style = "background-color: darkgrey; color : black; font-weight:bold;"><span><input type="text" class = "form-control toClear" id = "totalAmountRequi_view" disabled></span></td>
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
                                <span class= "pull-left" ><button type="button" class="btn btn-default" id = "clearFields">Clear Fields</button></span>
                                <span id="showApprovedReject" hidden>  <span class= "pull-right" ><button type="button" class="btn btn-success" id = "approveRequestReq">Approve Request</button></span>
                                <span class= "pull-right" style = "padding-right : 10px;" ><button type="button" class="btn btn-danger" id = "rejectRequestReq">Deny Request</button></span></span>

                            </div>
                        </div>
                        <div class = "row" style = "padding-top : 20px">
                            <div class="col-md-12">

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
                                <h4 style = "text-align : center">Monitoring</h4>

                            </div>
                            <div class="panel-body">
                                <div class="form-group">
                                    <div class = "nav-tabs-custom">
                                        <ul class = "nav nav-tabs">
                                            <li class = "active" ><a href="#tabRequi_1" data-toggle="tab" class = "admin_staff_requi_monit_class">Pending Requests</a></li>
                                            <li><a href="#tabRequi_2" data-toggle="tab" class = "admin_staff_requi_monit_class">Approved Requests</a></li>
                                            <li><a href="#tabRequi_3" data-toggle="tab" class = "admin_staff_requi_monit_class">Denied Requests</a></li>
                                        </ul>
                                        <div class = "tab-content">
                                            <div class = "tab-pane active" id = "tabRequi_1">
                                                <div class = "row">
                                                    <div class="col-md-12">
                                                        <table class="table-condensed" id = "admin_staff_requisition_monit" width="100%">
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
                                            <div class = "tab-pane" id = "tabRequi_2">
                                                <div class = "row">
                                                    <div class="col-md-12">
                                                        <table class="table-condensed" id = "admin_staff_requisition_monit_approved" width="100%">
                                                            <thead>
                                                            <tr>
                                                                <th>ID</th>
                                                                <th>Sent by</th>
                                                                <th>Date of Request</th>
                                                                <th>Requested by</th>
                                                                <th>Office Location-Department-Position</th>
                                                                <th>Approved by</th>
                                                                <th>Approval Date</th>
                                                                <th>Admin Approver</th>
                                                                <th>Action</th>
                                                            </tr>
                                                            </thead>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class = "tab-pane" id = "tabRequi_3">
                                                <div class = "row">
                                                    <div class="col-md-12">
                                                        <table class="table-condensed" id = "admin_staff_requisition_monit_denied" width="100%">
                                                            <thead>
                                                            <tr>
                                                                <th>ID</th>
                                                                <th>Sent by</th>
                                                                <th>Date of Request</th>
                                                                <th>Requested by</th>
                                                                <th>Office Location-Department-Position</th>
                                                                <th>Approved by</th>
                                                                <th>Approval Date</th>
                                                                <th>Admin Approver</th>
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
    </section>
</div>