<div class = "content-wrapper">
    <!-- Content Header (Page header) -->
    <section class = "content-header">
        <h1>
            Admin Requisition
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

                        <div class = "row" style = "padding-top : 20px;">
                            <div class = "col-md-12">
                                <table class="table-condensed" style = "overflow-x:auto; border-collapse:collapse; table-layout:fixed; width : 100%" id = "tablePOFormFill">
                                    <tr>
                                        <th colspan="4" style = "background-color: darkgrey; color : black; "><h4 style= "font-weight:bold;">PURCHASE ORDER FORM</h4>
                                            <h5><b>P.O No. : </b><input type="text" id = "poNumberFin" class = "clearPOFieldsFin" disabled></h5></th>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="font-weight:bold;">
                                            <div class ="row">
                                                <div class = "col-md-3">
                                                </div>
                                                <div class = "col-md-9">
                                                    <span class = "pull-left">
                                                        P.O Date:
                                                    </span>
                                                </div>
                                            </div>
                                        </td>
                                        <td colspan = "2"><input type="date" class = "form-control clearPOFieldsFin" id="poDateFin" disabled></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="font-weight:bold;">
                                            <div class ="row">
                                                <div class = "col-md-3">
                                                </div>
                                                <div class = "col-md-9">
                                                    <span class = "pull-left">
                                                        Recommended Supplier/Vendor's Name:
                                                    </span>
                                                </div>
                                            </div>
                                        </td>
                                        <td colspan = "2"><input id="selectSupForPOFin" class="form-control clearPOFieldsFin" disabled></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="font-weight:bold;">
                                            <div class ="row">
                                                <div class = "col-md-3">
                                                </div>
                                                <div class = "col-md-9">
                                                    <span class = "pull-left">
                                                       Contact Person:
                                                    </span>
                                                </div>
                                            </div>
                                        </td>
                                        <td colspan = "2"><input type="text" class = "form-control clearPOFieldsFin" id = "contactPersonPOFin" disabled></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="font-weight:bold;">
                                            <div class ="row">
                                                <div class = "col-md-3">
                                                </div>
                                                <div class = "col-md-9">
                                                    <span class = "pull-left">
                                                       Address:
                                                    </span>
                                                </div>
                                            </div>
                                        </td>
                                        <td colspan = "2"><textarea class ="form-control clearPOFieldsFin" id = "addressInfoPOFin" rows="2" disabled></textarea></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="font-weight:bold;">
                                            <div class ="row">
                                                <div class = "col-md-3">
                                                </div>
                                                <div class = "col-md-9">
                                                    <span class = "pull-left">
                                                       Contact number and Email address:
                                                    </span>
                                                </div>
                                            </div>
                                        </td>
                                        <td colspan = "2"><input type="text" class = "form-control clearPOFieldsFin" id = "contactInfoPOFin" disabled></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="font-weight:bold;">
                                            <div class ="row">
                                                <div class = "col-md-3">
                                                </div>
                                                <div class = "col-md-9">
                                                    <span class = "pull-left">
                                                       Date of Accreditation:
                                                    </span>
                                                </div>
                                            </div>
                                        </td>
                                        <td colspan = "2"><input type="date" class = "form-control clearPOFieldsFin" id = "dateAccredPOFibn" disabled></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="font-weight:bold;">
                                            <div class ="row">
                                                <div class = "col-md-3">
                                                </div>
                                                <div class = "col-md-9">
                                                    <span class = "pull-left">
                                                       Terms of payment:
                                                    </span>
                                                </div>
                                            </div>
                                        </td>
                                        <td colspan = "2"><input id="termsSupForPOFin" class="form-control clearPOFieldsFin" disabled></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="font-weight:bold;">
                                            <div class ="row">
                                                <div class = "col-md-3">
                                                </div>
                                                <div class = "col-md-9">
                                                    <span class = "pull-left">
                                                       Date of Delivery:
                                                    </span>
                                                </div>
                                            </div>
                                        </td>
                                        <td colspan = "2"><input type="date" class = "form-control clearPOFieldsFin" id = "dateDeliverPOFin" disabled></td>
                                    </tr>
                                </table>
                                <table class="table-condensed" style = "overflow-x:auto; border-collapse:collapse; table-layout:fixed; width : 100%" id = "brandItemsTable2">
                                    <tbody id = "addBrandTablePOFin">
                                    <tr>
                                        <th colspan="1" style = "background-color: darkgrey; color : black; font-weight:bold;">Brand - Item - Description</th>
                                        <th colspan="1" style = "background-color: darkgrey; color : black; font-weight:bold;">Quantity</th>
                                        <th colspan="1" style = "background-color: darkgrey; color : black; font-weight:bold; ">Unit Price</th>
                                        <th colspan="1" style = "background-color: darkgrey; color : black; font-weight:bold;"><span style = " padding-top : 10px;">Total Amount</span></th>
                                    </tr>
                                    {{--<tr id = "removeBrand1-0">--}}
                                        {{--<td colspan="1"><textarea class = "form-control loopPoItems" rows ="2"></textarea></td>--}}
                                        {{--<td colspan="1"><input type="number" class="form-control loopPoItems" ></td>--}}
                                        {{--<td colspan="1"><input type="number" class="form-control loopPoItems"></td>--}}
                                        {{--<td colspan="1"><div class="input-group input-group-sm"><input type="number" class="form-control loopPoItems" >--}}
                                                {{--<span class="input-group-btn">--}}
                                            {{--<button type="button" class="btn btn-danger btn-sm btnRemoveRow" name = "0">--}}
                                            {{--<i class = "fa fa-fw fa-minus"></i></button></span></div>--}}
                                        {{--</td>--}}
                                    {{--</tr>--}}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class = "row">
                            <div class = "col-md-6">
                                <table class="table-condensed" style = "overflow-x:auto; border-collapse:collapse; table-layout:fixed; width : 100%; margin-top : 60px;" id = "additionalNotesTablePOFin">
                                    <tr>
                                        <th colspan="1" style = "background-color: darkgrey; color : black; ">Additional Notes</th>
                                    </tr>
                                </table>
                            </div>
                            {{--<div class = "col-md-1"></div>--}}
                            <div class = "col-md-6" style = "padding-left : 0">
                                <table class="table-condensed" style = "overflow-x:auto; border-collapse:collapse; table-layout:fixed; width : 100%; margin-top : 20px;" >
                                    <tr>
                                        <th colspan="1" style = "background-color: darkgrey; color : black; ">Total Amount : </th>
                                        <td colspan = "1"><input type="number" class = "form-control clearPOFieldsFin" id ="totalAmtPOFin" disabled></td>
                                    </tr>
                                    <tr>
                                        <th colspan="1" style = "background-color: darkgrey; color : black; ">12% VAT : </th>
                                        <td colspan = "1"><input type="number" class = "form-control clearPOFieldsFin" id ="twelveVatPOFin" disabled></td>
                                    </tr>
                                    <tr>
                                        <th colspan="1" style = "background-color: darkgrey; color : black; ">Grand Total : </th>
                                        <td colspan = "1"><input type="number" class = "form-control clearPOFieldsFin" id = "grandTotalPOFin" disabled></td>
                                    </tr>
                                </table>

                                <table class="table-condensed" style = "overflow-x:auto; border-collapse:collapse; table-layout:fixed; width : 100%; margin-top : 23px;" >
                                    <tr>
                                        <th colspan="1" style = "background-color: darkgrey; color : black; ">Prepared By : </th>
                                        <td colspan = "1"> <input type="text" class = "form-control clearPOFieldsFin" id = "preparedByPOFin" disabled></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class = "row" style = "padding-top : 30px;">
                            <div class = "col-md-12">
                                <table class="table-condensed" style = "overflow-x:auto; border-collapse:collapse; table-layout:fixed; width : 100%">
                                    <tr>
                                        <th colspan="1" style = "background-color: darkgrey; color : black; ">For Administration Department - Attach and secure the following documents: </th>
                                    </tr>
                                    <tr>
                                        <td colspan="1" ><span class="toLeftTop2 pull-left"><input type="checkbox" checked> <b>Attach the approved requisition and agreement/proposal</b></span></td>
                                    </tr>
                                    <tr>
                                        <td colspan="1" ><span class="toLeftTop2 pull-left"><input type="checkbox" checked> <b>Check items in Purchase Order versus Delivery Receipt</b></span></td>
                                    </tr>
                                    <tr>
                                        <td colspan="1" ><span class="toLeftTop2 pull-left"><input type="checkbox" checked> <b>Attach the Delivery Receipt from Supplier</b> </span></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class = "row" style = "padding-top : 20px;">
                            <div class = "col-md-12">
                                <button class ="btn btn-md btn-info pull-left" id = "clearFieldsPOFin">Clear Fields</button>
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
                            <h4 style = "text-align : center">Processing Equipments Monitoring</h4>
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                <div class = "nav-tabs-custom">
                                    <ul class = "nav nav-tabs">
                                        <li class = "active"><a href="#tabFinProc_1" data-toggle="tab" class = "finance_admin_req_info_class">For Processing</a></li>
                                        <li><a href="#tabFinProc_2" data-toggle="tab" class = "finance_admin_req_info_class">Monitoring</a></li>
                                    </ul>
                                    <div class = "tab-content">
                                        <div class = "tab-pane active" id = "tabFinProc_1">
                                            <div class = "row" style = "padding-top : 30px;">
                                                <div class="col-md-12">
                                                    <table class="table-condensed" id = "finance_eq_process_pending" width="100%">
                                                        <thead>
                                                        <tr>
                                                            <th>ID</th>
                                                            <th>Requestor Name</th>
                                                            <th>Date of Request</th>
                                                            <th>Type of Request</th>
                                                            <th>Categorization</th>
                                                            <th>Scope</th>
                                                            <th>Type</th>
                                                            <th>Action</th>
                                                            <th>Others</th>
                                                        </tr>
                                                        </thead>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class = "tab-pane" id = "tabFinProc_2">
                                            <div class = "row" style = "padding-top : 30px;">
                                                <div class="col-md-12">
                                                    <table class="table-condensed" id = "finance_eq_process_done" width="100%">
                                                        <thead>
                                                        <tr>
                                                            <th>ID</th>
                                                            <th>Requestor Name</th>
                                                            <th>Date of Request</th>
                                                            <th>Type of Request</th>
                                                            <th>Categorization</th>
                                                            <th>Scope</th>
                                                            <th>Type</th>
                                                            <th>Action</th>
                                                            <th>Others</th>
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
                </div>
            </div>
        </div>
    </section>
</div>
