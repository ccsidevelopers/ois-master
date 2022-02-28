<div class = "content-wrapper">
    <!-- Content Header (Page header) -->
    <section class = "content-header">
        <h1>
            Accredited Suppliers
        </h1>
    </section>

    <!-- Main content -->
    <section class = "content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-body">
                        <div class = "row">
                            <div class = "col-md-4">
                                <div class="box" style="height: 700px; overflow: auto">
                                    <div class="box-body">
                                        <div class="panel panel-info">
                                            <div class="panel-heading">
                                                <h4>Encoding of Supplier</h4>
                                            </div>
                                            <div class="panel-body">
                                                <div class="form-group">
                                                    <div class="row" >
                                                        <div class="col-md-12">
                                                            <label>Encoding of Supplier:</label>
                                                            <br>
                                                            <select id="encodingTypeSup" class="form-control">
                                                                <option value="New">New</option>
                                                                <option value="Existing">Existing</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="row" style = "padding-top : 10px">
                                                        <div class="col-md-12">
                                                            <label>Category Type:</label>
                                                            <br>
                                                            <input type="radio" id="existingCategory" name="Category" value = "existingCategory" class = "categoryChooseclass" >Existing Category
                                                            <input type="radio" id="newCategory" name="Category" value = "newCategory" class = "categoryChooseclass">New Category<br>
                                                        </div>
                                                    </div>

                                                    {{--<div class = "row"  style = "padding-top : 10px;">--}}
                                                        {{--<div class = "col-md-12" id = "formCategory"></div>--}}
                                                    {{--</div>--}}

                                                    <div class = "row"  style = "padding-top : 10px;" id = "showSelectCateg" hidden>
                                                        <div class = "col-md-12">
                                                            <label>Select Category:</label>

                                                            <select id = "selectedCategory" class = "form-control toDisSelect">

                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class = "row"  style = "padding-top : 10px;" id = "showInputCateg" hidden>
                                                        <div class = "col-md-12">
                                                            <label>Add a category: <small style = "color : red">(Required field)</small></label>
                                                            <input type="text" class="form-control toClearSup" id = "newInputCategory"> <span id="categoryValidation"></span>
                                                        </div>

                                                    </div>

                                                    <div class = "row" style = "padding-top : 10px;">
                                                        <div class="col-md-12">
                                                            <label for="">Supplier Name: </label>
                                                            <input type="text" class = "form-control toClearSup" id = "accred_supp_name">
                                                        </div>
                                                    </div>

                                                    <div class = "row" style = "padding-top : 10px;">
                                                        <div class="col-md-12">
                                                            <label for="">Contact Number: </label>
                                                            <input type="text" class = "form-control toClearSup" id = "accred_supp_con_num">
                                                        </div>
                                                    </div>

                                                    <div class = "row" style = "padding-top : 10px;">
                                                        <div class="col-md-12">
                                                            <label for="">Address: </label>
                                                            <textarea class = "form-control toClearSup" id="accred_supp_address" rows="2"  placeholder="Insert address here......" ></textarea>
                                                        </div>
                                                    </div>

                                                    <div class = "row" style = "padding-top : 10px;">
                                                        <div class="col-md-12">
                                                            <label for="">Contact Person: </label>
                                                            <input type="text" class = "form-control toClearSup" id = "accred_sup_contact_person">
                                                        </div>
                                                    </div>

                                                    <div class = "row" style = "padding-top : 10px;">
                                                        <div class="col-md-12">
                                                            <label for="">Email Address: </label>
                                                            <input type="text" class = "form-control toClearSup" id = "accred_sup_email">
                                                        </div>
                                                    </div>

                                                    <div class = "row" style = "padding-top : 10px;">
                                                        <div class="col-md-12">
                                                            <label for="">Email Subject: </label>
                                                            <textarea class = "form-control toClearSup" id="accred_sup_email_subj" rows="2"  placeholder="Insert email subject here......" ></textarea>
                                                        </div>
                                                    </div>

                                                    <div class = "row" style = "padding-top : 10px;">
                                                        <div class="col-md-12">
                                                            <label for="">Date of B.I: </label>
                                                            <input type="date" class = "form-control toClearSup" id = "accred_sup_date_bi">
                                                        </div>
                                                    </div>

                                                    <div class = "row" style = "padding-top : 10px;">
                                                        <div class="col-md-12">
                                                            <label for="">BIR Registered: </label>
                                                            <input type="text" class = "form-control toClearSup" id  = "accred_sup_bir">
                                                        </div>
                                                    </div>

                                                    <div class = "row" style = "padding-top : 10px;">
                                                        <div class="col-md-12">
                                                            <label for="">TIN Number: </label>
                                                            <input type="text" class = "form-control toClearSup" id = "accred_sup_tin">
                                                        </div>
                                                    </div>

                                                    <div class = "row" style = "padding-top : 10px;">
                                                        <div class="col-md-12">
                                                            <label for="">Type of Request: </label>
                                                            <select class= "form-control toDisSelect" id = "accred_sup_tor">
                                                                <option value="Recurring">Recurring</option>
                                                                <option value="New Item">New Item</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class = "row" style = "padding-top : 10px;">
                                                        <div class="col-md-12">
                                                            <label for="">Categorization: </label>
                                                            <select class= "form-control toDisSelect" id = "accred_sup_categorization">
                                                                <option value="OPEX">OPEX</option>
                                                                <option value="CAPEX">CAPEX</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class = "row" style = "padding-top : 10px;">
                                                        <div class="col-md-12">
                                                            <label for="">Description: </label>
                                                            <textarea class = "form-control toClearSup" id="accred_sup_descrip" rows="3"  placeholder="Insert description here......" ></textarea>
                                                        </div>
                                                    </div>

                                                    <div class = "row" style = "padding-top : 10px;">
                                                        <div class="col-md-12">
                                                            <label for="">Terms of Payment: </label><button class="btn btn-success btn-xs" style = "margin-left : 10px;" id = "multipTermsSup"><i class="fa fa-fw fa-plus"></i></button>
                                                            <span id = ""></span>
                                                        </div>
                                                    </div>

                                                    <div id = "termPaymentsupSpan">

                                                    </div>

                                                    <div class = "row" style = "padding-top : 10px;">
                                                        <div class="col-md-12">
                                                            <label for="">Oher Info (Price / Discount / etc): </label>
                                                            <textarea class = "form-control toClearSup" id="accred_sup_discounts" rows="4"  placeholder="Insert content here......"></textarea>
                                                        </div>
                                                    </div>

                                                    <div class = "row" style = "padding-top : 10px;">
                                                        <div class="col-md-12">
                                                            <label for="">Proposal Validity: </label>
                                                            <textarea class = "form-control toClearSup" id="accred_sup_proposal" rows="2"  placeholder="Insert content here......"></textarea>
                                                        </div>
                                                    </div>

                                                    <div class = "row" style = "padding-top : 10px;">
                                                        <div class="col-md-12">
                                                            <label for="">Results: </label>
                                                            <textarea class = "form-control toClearSup" id="accred_sup_results" rows="3" placeholder="Insert results here......"></textarea>
                                                        </div>
                                                    </div>

                                                    <div class = "row" style = "padding-top : 10px;" id="addAttachmentSupHolder">
                                                        <div class="col-md-12">
                                                            <label for="">Add Attachment/s: </label><button class="btn btn-success btn-xs" style = "margin-left : 10px;" id = "addAttachAccred"><i class="fa fa-fw fa-plus"></i></button>
                                                        </div>
                                                    </div>


                                                    <div id = "storageOfFileSup">

                                                    </div>

                                                    <div class = "row" style = "padding-top : 10px; padding-bottom : 10px;" hidden id="accredited_sup_file_table_holder">
                                                        <div class="col-md-12">
                                                            <h4 style = "font-weight: bold"><center>List of File/s: </center></h4>
                                                            <table class="table-condensed table-hover" width="100%" id="accredited_sup_file_table">
                                                            </table>
                                                        </div>
                                                    </div>

                                                    {{--<div class = "row" style = "padding-top : 10px;">--}}
                                                        {{--<div class="col-md-12">--}}
                                                            {{--<button class="pull-right btn btn-md btn-primary" id = "saveAccreditedSupplier">Submit</button>--}}
                                                            {{--<button class="pull-right btn btn-md btn-warning" id = "editAccreditedSupplier" style="margin-right: 1%; display: none">Edit</button>--}}
                                                        {{--</div>--}}
                                                    {{--</div>--}}
                                                    <div class="panel-footer">
                                                        <div class = "row" style = "">
                                                            <div class="col-md-12">
                                                                <button class="pull-left btn btn-md btn-info" id = "clearFieldsAccredSupp">Clear Fields</button>
                                                                <span id = "hideSubmitIfNotEdit"><button class="pull-right btn btn-md btn-primary" id = "saveAccreditedSupplier">Submit</button></span>
                                                                <button class="pull-right btn btn-md btn-warning" id = "editAccreditedSupplier" style="margin-right: 1%; display: none">Edit</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class = "col-md-8">
                                <div class = "nav-tabs-custom">
                                    <ul class = "nav nav-tabs">
                                        <li class = "active"><a href="#tabSup_1" data-toggle="tab" class = "admin_staff_accred_approval">List of Accredited Suppliers</a></li>
                                        <li><a href="#tabSup_2" data-toggle="tab" class = "admin_staff_accred_approval">For Approval/Comparison</a></li>
                                    </ul>
                                    <div class = "tab-content">
                                        <div class = "tab-pane active" id = "tabSup_1">
                                            <div class = "nav-tabs-custom">
                                                <ul class = "nav nav-tabs">
                                                    <li class = "active"><a href="#tabStatSup_1" data-toggle="tab" class = "admin_staff_approved_denied_class">Approved Supplier</a></li>
                                                    <li><a href="#tabStatSup_2" data-toggle="tab" class = "admin_staff_approved_denied_class"> Denied Supplier</a></li>
                                                </ul>
                                                <div class = "tab-content">
                                                    <div class = "tab-pane active" id = "tabStatSup_1">
                                                        <div class = "row" style = "padding-top: 30px">
                                                            <div class = "col-md-12">
                                                                <div style = "overflow-x: auto">
                                                                    <table class= "table-condensed" width="100%" id = "admin-staff-acc-sup-table">
                                                                        <thead>
                                                                        <tr>
                                                                            <th>ID</th>
                                                                            <th>Date and Time Submitted</th>
                                                                            <th>Category</th>
                                                                            <th>Supplier Name</th>
                                                                            <th>Contact Person</th>
                                                                            <th>Action</th>
                                                                        </tr>
                                                                        </thead>
                                                                        <tfoot>
                                                                        <tr>
                                                                            <th>ID</th>
                                                                            <th>Date and Time Submitted</th>
                                                                            <th>Category</th>
                                                                            <th>Supplier Name</th>
                                                                            <th>Contact Person</th>
                                                                            <th>Action</th>
                                                                        </tr>
                                                                        </tfoot>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class = "tab-pane" id = "tabStatSup_2">
                                                        <div class = "row" style = "padding-top: 30px">
                                                            <div class = "col-md-12">
                                                                <div style = "overflow-x: auto">
                                                                    <table class= "table-condensed" width="100%" id = "admin-staff-acc-sup-table-denied">
                                                                        <thead>
                                                                        <tr>
                                                                            <th>ID</th>
                                                                            <th>Date and Time Submitted</th>
                                                                            <th>Category</th>
                                                                            <th>Supplier Name</th>
                                                                            <th>Contact Person</th>
                                                                            <th>Action</th>
                                                                        </tr>
                                                                        </thead>
                                                                        <tfoot>
                                                                        <tr>
                                                                            <th>ID</th>
                                                                            <th>Date and Time Submitted</th>
                                                                            <th>Category</th>
                                                                            <th>Supplier Name</th>
                                                                            <th>Contact Person</th>
                                                                            <th>Action</th>
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
                                        <div class = "tab-pane" id = "tabSup_2">
                                            <div class = "nav-tabs-custom">
                                                <ul class = "nav nav-tabs">
                                                    <li class = "active"><a href="#tabAppr_Sup_1" data-toggle="tab" class = "admin_staff_request_sup_class">Supplier for Approval</a></li>
                                                    <li><a href="#tabAppr_Sup_2" data-toggle="tab" class = "admin_staff_request_sup_class"> Monitoring of Approval</a></li>
                                                </ul>
                                                <div class = "tab-content">
                                                    <div class = "tab-pane active" id = "tabAppr_Sup_1">
                                                        <div class = "row" style = "padding-top: 30px">
                                                            <div class = "col-md-12">
                                                                <div style = "overflow-x: auto">
                                                                    <table class= "table-condensed" width="100%" id = "admin-staff-acc-for-comparison">
                                                                        <thead>
                                                                        <tr>
                                                                            <th>Selection</th>
                                                                            <th>ID</th>
                                                                            <th>Date and Time Submitted</th>
                                                                            <th>Category</th>
                                                                            <th>Supplier Name</th>
                                                                            <th>Contact Person</th>
                                                                            <th>Action</th>
                                                                        </tr>
                                                                        </thead>
                                                                        <tfoot>
                                                                        <tr>
                                                                            <th>Selection</th>
                                                                            <th>ID</th>
                                                                            <th>Date and Time Submitted</th>
                                                                            <th>Category</th>
                                                                            <th>Supplier Name</th>
                                                                            <th>Contact Person</th>
                                                                            <th>Action</th>
                                                                        </tr>
                                                                        </tfoot>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row" style = "padding-top : 20px;">
                                                            <div class = "col-md-12">
                                                                <span id = "showSubmitComparison" class="pull-right" hidden><button class="btn btn-primary" id="openModalTOCompareAccred">Submit</button></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class = "tab-pane" id = "tabAppr_Sup_2">
                                                        <div class = "row" style = "padding-top: 30px">
                                                            <div class = "col-md-12">
                                                                <div style = "overflow-x: auto">
                                                                    <table class= "table-condensed" width="100%" id = "admin-staff-acc-for-approval">
                                                                        <thead>
                                                                        <tr>
                                                                            <th>ID</th>
                                                                            <th>Date/Time Requested</th>
                                                                            <th>Submitted by</th>
                                                                            <th>Encoded Category</th>
                                                                            <th>Equipment/Supply</th>
                                                                            <th>Supplier Remarks</th>
                                                                            <th>Action</th>
                                                                        </tr>
                                                                        </thead>
                                                                        <tfoot>
                                                                        <tr>
                                                                            <th>ID</th>
                                                                            <th>Date/Time Requested</th>
                                                                            <th>Submitted by</th>
                                                                            <th>Encoded Category</th>
                                                                            <th>Equipment/Supply</th>
                                                                            <th>Supplier Remarks</th>
                                                                            <th>Action</th>
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
                                <!-- /.box -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
