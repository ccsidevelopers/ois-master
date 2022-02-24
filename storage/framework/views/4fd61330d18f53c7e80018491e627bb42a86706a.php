<div class = "content-wrapper">
    <!-- Content Header (Page header) -->
    <section class = "content-header">
        <h1>
            Equipment Processing
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
                        <div id = "showToCreatePO">
                            <div class = "row" style = "padding-top : 20px;">
                            <div class = "col-md-12">
                                <table class="table-condensed" style = "overflow-x:auto; border-collapse:collapse; table-layout:fixed; width : 100%" id = "tablePOFormFill">
                                    <tr>
                                        <th colspan="4" style = "background-color: darkgrey; color : black; "><h4 style= "font-weight:bold;">PURCHASE ORDER FORM</h4>
                                            <h5><b>P.O No. : </b><input type="text" id = "poNumber" class = "clearPOFields"></h5></th>
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
                                        <td colspan = "2"><input type="date" class = "form-control" id="poDate"></td>
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
                                        <td colspan = "2"><select id="selectSupForPO" class="form-control"></select></td>
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
                                        <td colspan = "2"><input type="text" class = "form-control toClearPO" id = "contactPersonPO" disabled></td>
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
                                        <td colspan = "2"><textarea class ="form-control toClearPO" id = "addressInfoPO" rows="2" disabled></textarea></td>
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
                                        <td colspan = "2"><input type="text" class = "form-control toClearPO" id = "contactInfoPO" disabled></td>
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
                                        <td colspan = "2"><input type="date" class = "form-control toClearPO" id = "dateAccredPO" disabled></td>
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
                                        <td colspan = "2"><select id="termsSupForPO" class="form-control" disabled></select></td>
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
                                        <td colspan = "2"><input type="date" class = "form-control clearPOFields" id = "dateDeliverPO"></td>
                                    </tr>
                                </table>
                                <table class="table-condensed" style = "overflow-x:auto; border-collapse:collapse; table-layout:fixed; width : 100%" id = "brandItemsTable2">
                                    <tbody id = "addBrandTablePO">
                                    <tr>
                                        <th colspan="1" style = "background-color: darkgrey; color : black; font-weight:bold;padding-bottom: 15px;">Brand - Item - Description</th>
                                        <th colspan="1" style = "background-color: darkgrey; color : black; font-weight:bold;padding-bottom: 15px;">Quantity</th>
                                        <th colspan="1" style = "background-color: darkgrey; color : black; font-weight:bold;  padding-bottom: 15px;">Unit Price</th>
                                        <th colspan="1" style = "background-color: darkgrey; color : black; font-weight:bold;"><span style = " padding-top : 10px;">Total Amount</span><span class = "pull-right"><button class = "btn btn-sm btn-success btnToAddBrand"  ><i class = "fa fa-fw fa-plus"></i></button></span></th>
                                    </tr>
                                    <tr id = "removeBrand1-0">
                                        <td colspan="1"><textarea class = "form-control loopPoItems" rows ="2"></textarea></td>
                                        <td colspan="1"><input type="number" class="form-control loopPoItems" ></td>
                                        <td colspan="1"><input type="number" class="form-control loopPoItems"></td>
                                        <td colspan="1"><div class="input-group input-group-sm"><input type="number" class="form-control loopPoItems" >
                                                <span class="input-group-btn">
                                            <button type="button" class="btn btn-danger btn-sm btnRemoveRow" name = "0">
                                            <i class = "fa fa-fw fa-minus"></i></button></span></div>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                            <div class = "row">
                            <div class = "col-md-6">
                                <table class="table-condensed" style = "overflow-x:auto; border-collapse:collapse; table-layout:fixed; width : 100%; margin-top : 60px;" id = "additionalNotesTablePO">
                                    <tr>
                                        <th colspan="1" style = "background-color: darkgrey; color : black; ">Additional Notes <button class = "btn btn-xs btn-success btnAdditionalNotesPO" style = "margin-left : 2%"><i class = "fa fa-fw fa-plus"></i></button></th>
                                    </tr>
                                    <tr>
                                        <td colspan="1" ><textarea class = "form-control addNotesPO" rows ="2"></textarea></td>
                                    </tr>
                                </table>
                            </div>
                            
                            <div class = "col-md-6" style = "padding-left : 0">
                                <table class="table-condensed" style = "overflow-x:auto; border-collapse:collapse; table-layout:fixed; width : 100%; margin-top : 20px;" >
                                    <tr>
                                        <th colspan="1" style = "background-color: darkgrey; color : black; ">Total Amount : </th>
                                        <td colspan = "1"><input type="number" class = "form-control clearPOFields" id ="totalAmtPO"></td>
                                    </tr>
                                    <tr>
                                        <th colspan="1" style = "background-color: darkgrey; color : black; ">12% VAT : </th>
                                        <td colspan = "1"><input type="number" class = "form-control clearPOFields" id ="twelveVatPO"></td>
                                    </tr>
                                    <tr>
                                        <th colspan="1" style = "background-color: darkgrey; color : black; ">Grand Total : </th>
                                        <td colspan = "1"><input type="number" class = "form-control clearPOFields" id = "grandTotalPO"></td>
                                    </tr>
                                </table>

                                <table class="table-condensed" style = "overflow-x:auto; border-collapse:collapse; table-layout:fixed; width : 100%; margin-top : 23px;" >
                                    <tr>
                                        <th colspan="1" style = "background-color: darkgrey; color : black; ">Prepared By : </th>
                                        <td colspan = "1"> <input type="text" class = "form-control" id = "preparedByPO" disabled></td>
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
                                    <button class ="btn btn-md btn-info pull-left" id = "clearFieldsPO">Clear Fields</button>
                                    <span id = "showHideSubmitPO" hidden><button class ="btn btn-md btn-primary pull-right" id = "submitPORequi" name = ''>Submit</button></span>
                                </div>
                            </div>
                        </div>

                        <div id = "showToViewPO" hidden>
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
                                        <li class = "active"><a href="#tabProc_1" data-toggle="tab" class = "admin_staff_eq_proc_class">P.O Processing</a></li>
                                        <li><a href="#tabProc_2" data-toggle="tab" class = "admin_staff_eq_proc_class">Processing/Uploaded</a></li>
                                        <li><a href="#tabProc_3" data-toggle="tab" class = "admin_staff_eq_proc_class">Finished Process</a></li>
                                    </ul>
                                    <div class = "tab-content">
                                        <div class = "tab-pane active" id = "tabProc_1">
                                            <div class = "row" style = "padding-top : 30px;">
                                                <div class="col-md-12">
                                                    <table class="table-condensed" id = "admin_staff_eq_process" width="100%">
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
                                        <div class = "tab-pane" id = "tabProc_2">
                                            <div class = "row" style = "padding-top : 30px;">
                                                <div class="col-md-12">
                                                    <table class="table-condensed" id = "admin_staff_eq_process_finance" width="100%">
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
                                        <div class = "tab-pane" id = "tabProc_3">
                                            <div class = "row" style = "padding-top : 30px;">
                                                <div class="col-md-12">
                                                    <table class="table-condensed" id = "admin_staff_eq_process_done" width="100%">
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