
<!-- Content Wrapper. Contains page content -->
<div class = "content-wrapper">
    <!-- Content Header (Page header) -->
    <section class = "content-header">
        <h1>
           Profile
        </h1>
    </section>

    <!-- Main content -->
    <section class = "content">
        <div class = "nav-tabs-custom">
            <ul class = "nav nav-tabs">
                
                
                <li class="active"><a id = "tab4" href="#tab_eq4" data-toggle="tab" class = "admin_staff_eq_class">A.R Profile</a></li>
            </ul>
            <div class = "tab-content">
                <div class = "tab-pane" id = "tab_eq2">
                    <div class = "row">
                        <center>
                            <h3 class = "box-title" style = "font-family: Georgia,serif;">Item Details</h3>
                        </center>
                    </div>
                    <div class = "row" style = "padding-top: 30px;">
                        <div class = "col-md-5" id = "addItemSize">
                            <div class="box box-info" style = "padding-top: 30px;">
                                <div class = "row">
                                    <center>
                                        <h3 style = "font-family: Georgia,serif;">Item Image</h3>
                                    </center>
                                </div>
                                <div class = "row">
                                    <center>
                                        <form id="form1">
                                            <img id = "item_profile_pic_display"  style = "width: 30%; height: 30%; border:5px solid #000; " src = "<?php echo e(asset('item_pic/items.jpg')); ?>" />
                                        </form>
                                    </center>
                                </div>
                                <div class = "row" style = "padding-top: 10px;">
                                    <div class = "col-md-3"></div>
                                    <div class = "col-md-3">
                                        <input type='file' id="item_profile_pic" />
                                    </div>
                                    <div class = "col-md-3">
                                        <button id = "cancelImg" class="pull-right" style="margin-bottom: 10px">Cancel</button>
                                    </div>
                                    <div class = "col-md-3"></div>
                                </div>
                                <div class = "row">
                                    <div class = "col-md-7">
                                        <label for="">Type of Equipment:</label>
                                        <input type="text" id = "item_type" class = "form-control">
                                    </div>
                                    <div class = "col-md-5"></div>
                                </div>
                                <div class = "row" style = "padding-top: 10px;">
                                    <div class = "col-md-7">
                                        <label for="">Brand/Model Name: <small style = "color : red">*required field</small></label>
                                        <input type="text" id = "item_model" class = "form-control">
                                    </div>
                                    <div class = "col-md-5"></div>
                                </div>
                                <div class = "row">
                                    <div class = "col-md-7" style = "padding-top: 10px;">
                                        <label for="">Date Purchased:</label>
                                        <input type="date" id = "item_date" class = "form-control">
                                    </div>
                                    <div class = "col-md-5"></div>
                                </div>
                                <div class = "row">
                                    <div class = "col-md-7" style = "padding-top: 10px;">
                                        <label for="">Purchase Order No.:</label>
                                        <input type="text" id = "item_purchase_no" class = "form-control">
                                        <span id = "check_purchase"></span>
                                    </div>
                                    <div class = "col-md-5"></div>
                                </div>
                                <div class = "row">
                                    <div class = "col-md-4" style = "padding-top: 10px;">
                                        <label for="">Purchase Order Document</label>
                                        <input type='file' id="item_po_file" />
                                    </div>
                                    <div class = "col-md-3" style= "padding-top: 33px;">
                                        <button type="button" class="pull-right" id = "cancelPoDocument">Remove Selected</button>
                                    </div>
                                    <div class = "col-md-5">

                                    </div>
                                </div>
                                <div class ="row">
                                    <div class = "col-md-7" style = "padding-top: 10px;">
                                        <label for="">Amount: <small style = "color : red">*required field</small></label>
                                        <input type="text" id = "item_amount" class = "form-control">
                                    </div>
                                    <div class = "col-md-5"></div>
                                </div>
                                <div class = "row">
                                    <div class = "col-md-7" style = "padding-top: 10px;">
                                        <label for="">Color:</label>
                                        <input type="text" id = "item_color" class = "form-control">
                                    </div>
                                    <div class = "col-md-5"></div>
                                </div>
                                <div class = "row" id = "hideSpecStat">
                                    <div class = "col-md-12" style = "padding-top: 10px;">
                                        <label for="">Item Status:</label>
                                        <textarea  class="form-control" rows = "2" id = "item_specs_status">All specs are working properly. Ready to deploy.</textarea>
                                    </div>
                                </div>
                                <div class = "row">
                                    <div class = "col-md-7">
                                        <label for="">Warranty Label: </label>
                                        <input type="text" id = "item_warranty" class = "form-control">
                                    </div>
                                </div>
                                <div class = "row" style = "padding-top : 10px;">
                                    <div class = "col-md-4">
                                        <label for="" id = "replaceQuot">Quotation:</label>
                                        <input type="file" id = "item_quotation">

                                    </div>
                                    <div class = "col-md-3" style= "padding-top: 20px;">
                                        <button type = "button" id ="cancelQuot" class = "pull-right">Remove Selected</button>
                                    </div>
                                    <div class = "col-md-5"></div>
                                </div>
                                <div class = "row" style = "padding-top: 20px; padding-bottom : 20px;">
                                    <div class = "col-md-12">
                                        <label for="">Remarks: <small style = "color:red">*Note: please specify specification of the item</small></label>
                                        <textarea  class="form-control" rows = "7" id = "item_remarks" ></textarea>
                                    </div>
                                </div>
                                <div class = "" style = "margin-top : 20px;">
                                    <button type = "button" id ="submitItem" class = "btn btn-success pull-right">Create Item Profile</button>
                                    <button type = "button" id ="UpdateItem" class = "btn btn-warning pull-right">Update Item Profile</button>
                                    <button type = "button" id ="cancelUpdate" class = "btn btn-default pull-left">Cancel Update</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7" id = "addResize2">
                            <div class="box box-info">
                                <div id = "tableEditItem" style = "padding-top : 100px;">
                                    <table id = "admin-staff-edit-item-table" class="tableendorse display table-hover table-condensed" width="100%">
                                        <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Date of Purchased</th>
                                            <th>Category</th>
                                            <th>Brand/ Model Name</th>
                                            <th>Amount</th>
                                            <th>Color</th>
                                            <th>P.O Number</th>
                                            <th>Remarks</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tfoot>
                                        <tr>
                                            <th>ID</th>
                                            <th>Date of Purchased</th>
                                            <th>Category</th>
                                            <th>Brand/ Model Name</th>
                                            <th>Amount</th>
                                            <th>Color</th>
                                            <th>P.O Number</th>
                                            <th>Remarks</th>
                                            <th>Action</th>
                                        </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class = "col-md-1"></div>
                </div>
                <div class = "tab-pane" id = "tab_eq3">
                    <div class = "row">
                        <div class = "col-md-5">
                            <div class = "box-header with-border">
                                <center><h2 class = "box-title" style = "text-align: center; font-family: Georgia,serif;">Available Item/Equipment List</h2></center>
                            </div>
                            <div class = "box box-info">
                                <div class = "box box-default"  style = "padding-top: 60px;">
                                    <table id = "admin_staff_assign_item" class="tableendorse display table-hover table-condensed" width="100%">
                                        <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Category</th>
                                            <th>Brand/ Model Name</th>
                                            <th>Status</th>
                                        </tr>
                                        </thead>
                                        <tfoot>
                                        <tr>
                                            <th>ID</th>
                                            <th>Category</th>
                                            <th>Brand/ Model Name</th>
                                            <th>Status</th>
                                        </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class = "col-md-7">
                            <div class = "box-header with-border">
                                <center><h2 class = "box-title" style = "text-align: center; font-family: Georgia,serif;">Employee Item List</h2></center>
                            </div>
                            <div class = "box box-info">
                                <div class = "box box-default" style = "padding-top: 10px;">
                                    <div class="box-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Select Employee Name:</label>
                                                    <select class="form-control select2" style="width: 100%;" id="assignItemSelected" name = "assignItemSelected">
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div id="ar_hidden" hidden class="form-group">
                                                    <label>Select AR(Description):</label>
                                                    <select class="form-control select2" style="width: 100%;" id="ar_selected" name = "ar_selected">
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6"></div>
                                            <div class="col-md-6" id="ar_dd" hidden>
                                                <div class="box box-solid">
                                                    <div class="box-header with-border">
                                                        <h3 class="box-title">AR Information</h3>
                                                    </div>
                                                    <!-- /.box-header -->
                                                    <div class="box-body">
                                                        <dl class="dl-horizontal">
                                                            <dt>Remarks</dt>
                                                            <dd id="dd_ar_remarks"></dd>
                                                            <dt>Date Time of Upload</dt>
                                                            <dd id="dd_ar_date_time"></dd>
                                                            <dt>PDF</dt>
                                                            <dd> <a id="dd_a_href" target="_blank"><button type="button">click here to view</button></a></dd>
                                                        </dl>
                                                    </div>
                                                    <!-- /.box-body -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <label style="margin-left: 5px">List of items/Equipments:   </label>
                                    <table id="admin-staff-employee-list" class="tableendorse table table-bordered table-striped" width="100%" style = "overflow: auto; white-space: nowrap;">
                                        <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Category</th>
                                            <th>Brand/Model Name</th>
                                            <th>Color</th>
                                            <th>Remarks</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class = "tab-pane active" id = "tab_eq4">
                    <div class = "row">
                        <div class = "box-header">
                            <center><h2 class = "box-title" style = "text-align: center; font-family: Georgia,serif;">Acknowledgement Receipt</h2></center>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-4 form-group" id = "removeAR">
                                    <div class="box box-info">
                                        <div class="box box-default" style="padding: 10px">
                                            <div class="row">
                                                <div class="col-md-12 form-group">
                                                <label>Select Employee Name: <small style="color:red">*Required</small></label>
                                                <select class="form-control select2" style="width: 100%;" id="ar_employee_list" name = "ar_employee_list">
                                                </select>
                                            </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 form-group">
                                                    <label for="ar_description">Description <small style="color:red">*Required</small></label>
                                                    <input type="text" id="ar_description" class="form-control">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-8 form-group">
                                                    <label for="">Acknowledgement Receipt Document <small style="color:red">*Required<br>*note : only .pdf can be uploaded here.</small></label>
                                                    <input class="form-control" type="file" id="emp_ar_file" accept="application/pdf">
                                                </div>
                                                <div class="col-md-4"></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-8 form-group">
                                                    <label for="">Remarks/Note: <small style="color:orange">*Optional</small></label>
                                                    <textarea class="form-control" rows="7" id="ar_remarks"></textarea>
                                                </div>
                                                <div class="col-md-4"></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <button type="button" class="btn btn-success pull-right" id="btn_upload_ar">Upload</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-8 form-group" id = "arTableView">
                                    <div class="box box-info">
                                        <div class="box box-default" style="padding: 10px">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <table id = "admin-staff-ar-table" class="tableendorse display table-hover table-condensed" width="100%">
                                                        <thead>
                                                        <tr>
                                                            <th>ID</th>
                                                            <th>Employee First Name</th>
                                                            <th>Employee Middle Name</th>
                                                            <th>Employee Last Name</th>
                                                            <th>Description</th>
                                                            <th>Remarks</th>
                                                            <th>Date Time Created</th>
                                                            <th>Action</th>
                                                        </tr>
                                                        </thead>
                                                        <tfoot>
                                                        <tr>
                                                            <th>ID</th>
                                                            <th>Employee First Name</th>
                                                            <th>Employee Middle Name</th>
                                                            <th>Employee Last Name</th>
                                                            <th>Description</th>
                                                            <th>Remarks</th>
                                                            <th>Date Time Created</th>
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
            </div>
        </div>
    </section>
</div>