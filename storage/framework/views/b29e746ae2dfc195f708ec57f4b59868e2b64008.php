<style>
    .toLeftTop
    {
        padding-left : 125px;
    }
    .toLeftTop2
    {
        padding-left : 250px;
    }
</style>
<link rel="stylesheet" href="https://cdn.datatables.net/rowreorder/1.2.0/css/rowReorder.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.1.1/css/responsive.dataTables.min.css">

<?php $__env->startSection('content'); ?>




    <div class="content-wrapper">

    </div>

    
    <div class="modal modal-success fade" id="modal-successitem">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Success!</h4>
                </div>
                <div class="modal-body">
                    <p style="text-align: center">Successfully Added Item</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline pull-right" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    
    <div class="modal modal-success fade" id="modal-updateitem">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Success!</h4>
                </div>
                <div class="modal-body">
                    <p style="text-align: center">Successfully Updated Item</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline pull-right" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    
    <div class="modal fade" id="modal-itemProfile">
        <div class="modal-dialog" style = "width: 70%;">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" style = "text-align: center;">Item Profile</h4>
                </div>
                <div class="modal-body">
                    <div class = "row">
                        <div class = "col-md-3"></div>
                        <div class = "col-md-6">
                            <div class = "box box-warning">
                                <div class = "box box-default">
                                    <center><img id = "item_pic" src = "<?php echo e(asset('user_profile_pictures/default3.jpg')); ?>" style = "width: 220px; height: 240px;padding: 20px 0 20px 0;"></center>
                                    <center><h1 id = "insertItemName" style = "font-family: Georgia,serif; padding-bottom : 10px;"></h1></center>
                                </div>
                            </div>
                        </div>
                        <div class = "col-md-3"></div>
                    </div>
                    <div class = "row">
                        <div class = "col-md-6">
                            <div class = "box box-warning">
                                <div class = "box box-default">
                                    <center><h2 style = "font-family: Georgia,serif; padding-bottom : 10px;">Item Information</h2></center>
                                    <div class = "row" style = "padding-top: 10px;">
                                        <div class = "col-md-5">
                                            <label for="">Category:</label>
                                            <input type="text" id = "show_item_categ" class = "form-control" disabled>
                                        </div>
                                        <div class = "col-md-2"></div>
                                        <div class = "col-md-5">
                                            <label for="">Purchase Order No. :</label>
                                            <input type="text" id = "show_item_po" class = "form-control" disabled>
                                        </div>
                                    </div>
                                    <div class = "row" style = "padding-top: 10px;">
                                        <div class = "col-md-5">
                                            <label for="">Date Purchased:</label>
                                            <input type="text" id = "show_item_date" class = "form-control" disabled>
                                        </div>
                                        <div class = "col-md-2"></div>
                                        <div class = "col-md-5" >
                                            <label for="">Warranty Label: </label>
                                            <input type="text" id = "show_item_warranty" class = "form-control" disabled>
                                        </div>
                                        <span id = "down"></span>
                                        <div class = "col-md-1"></div>
                                    </div>
                                    <div class = "row" style = "padding-top: 10px;">
                                        <div class = "col-md-5">
                                            <label for="">Amount:</label>
                                            <input type="text" id = "show_item_amount" class = "form-control" disabled>
                                        </div>
                                        <div class = "col-md-2"></div>
                                        <div class = "col-md-5">
                                            <label for="">Color:</label>
                                            <input type="text" id = "show_item_color" class = "form-control" disabled>
                                        </div>
                                    </div>
                                    <div class ="row" style = "padding-top: 30px;">
                                        <div class = "col-md-5" id = "editPoStyle">
                                            <button type = "button" class="btn btn-info btn-block" id = "btnDownloadPo"><i class = "fa fa-fw fa-download" ></i>Download Purchase Order</button>
                                            <span id = "noPo"></span>
                                        </div>
                                        <div class = "col-md-2"></div>
                                        <div class = "col-md-5">
                                            <button type = "button" id ="dlQuotation" style = "width: 100%" class = "btn btn-warning"><i class = "fa fa-fw fa-download"></i>Download Quotation</button><span id = "downQoutation"></span>
                                            <span id = "noQou"></span>
                                        </div>
                                    </div>
                                    <div class = "row" style = "padding-top: 20px;">
                                        <div class = "col-md-12">
                                            <label for="">Remarks</label>
                                            <textarea  class="form-control" rows = "7" id = "show_item_remarks" disabled></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class = "col-md-6">
                            <div class = "box box-warning">
                                <div class = "box box-default">
                                    <center><h2 style = "font-family: Georgia,serif; padding-bottom : 10px;">Item History</h2></center>
                                    <div class = "row" style = "padding-top: 10px;">
                                        <div class = "col-md-10">
                                            <h4>Current User:</h4>
                                            <input type="text" id = "item_user" class = "form-control" disabled>
                                        </div>
                                    </div>
                                    <div class = "row" style = "padding-top: 20px;">
                                        <div class = "col-md-12">
                                            <table id="admin-staff-item-history" class="table table-bordered table-striped" width="100%" style = "overflow-y:auto;">
                                                <thead>
                                                <tr>
                                                    <th>User</th>
                                                    <th>Activity</th>
                                                    <th>Remarks</th>
                                                    <th>Time and Date</th>
                                                </tr>
                                                </thead>
                                                <tfoot>
                                                <tr>
                                                    <th>User</th>
                                                    <th>Activity</th>
                                                    <th>Remarks</th>
                                                    <th>Time and Date</th>
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
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    


    <div class="modal fade" id="modal-add-supplier">
        <div class="modal-dialog" style = "width: 65%;">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h3 class="modal-title">Suppliers</h3>
                </div>

                <div class="modal-body">

                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li class="active" id = "removeAddSupp"><a id="tabAdd" href="#tab_Add" data-toggle="tab" class = "admin_supplier_class">Add a Supplier</a></li>
                            <li id = "selectTabSupp"><a id="tabInfo" href="#tab_Info" data-toggle="tab" class = "admin_supplier_class"><i class = "fa fa-fw fa-info"></i> Supplier Information</a></li>
                        </ul>

                        <div class="tab-content">


                            <div class="tab-pane active" id="tab_Add">
                                <div id = "removeSupp">
                                    <div class="row">

                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Category:</label>
                                                <br>
                                                <input type="radio" id="existingCategory" name="Category" value = "existingCategory">Existing Category
                                                <input type="radio" id="newCategory" name="Category" value = "newCategory">New Category<br>
                                            </div>
                                        </div>

                                        <div class = "row"  style = "padding-top : 10px;">
                                            <div class = "col-md-6" id = "formCategory"></div>
                                            <div class = "col-md-6"></div>
                                        </div>


                                        <div class="row" style = "padding-top : 20px;">
                                            <div class="col-md-5">
                                                <label>Supplier Name: <small style = "color:red"> *Required field</small></label>
                                                <input type="text" class="form-control" id="suppName" >
                                            </div>
                                            <div class = "col-md-2"></div>
                                            <div class = "col-md-5">
                                                <label>Supplier Since:  <small style = "color:red"> *Required field</small></label>
                                                <input type="date" class="form-control" id="suppDate">
                                            </div>
                                        </div>

                                        <div class="row" style = "padding-top : 10px;">
                                            <div class="col-md-5">
                                                <label>Telephone no.:  <small style = "color:orange"> *Optional</small></label>
                                                <input type="text" class="form-control" id="suppPhone">
                                            </div>
                                            <div class = "col-md-2"></div>
                                            <div class = "col-md-5">
                                                <label>Contact Mobile:   <small style = "color:orange";> *Optional</small></label>
                                                <input type="text" class="form-control" id="suppMobile">
                                            </div>
                                        </div>

                                        <div class="row" style = "padding-top : 10px;">
                                            <div class="col-md-5">
                                                <label>Email Address:  <small style = "color:orange";> *Optional</small></label>
                                                <input type="text" class="form-control" id="suppEmail">
                                            </div>
                                            <div class = "col-md-2"></div>
                                            <div class = "col-md-5">
                                                <label>Contact person: <small style = "color:red"> *Required field</small></label>
                                                <input type="text" class="form-control" id="suppPerson" name="">
                                            </div>
                                        </div>
                                        <div class="row" style = "padding-top : 10px;">
                                            <div class="col-md-12">
                                                <label>Address: <small style = "color:red"> *Required field</small></label>
                                                <textarea class="form-control" row = "3" id="suppAddress"></textarea>
                                            </div>
                                        </div>
                                        <div class = "row" style = "padding-top : 10px; padding-bottom : 20px;">
                                            <div class = "col-md-6">
                                                <label for="">B.I Result: <small style = "color:red"> *Required field</small></label>
                                                <input type="file" id = "supp_bi">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer" id = "footerContent">
                                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary" id ="btnAddSupplier"><i class = "fa fa-fw fa-plus-square"></i> Add Supplier</button>
                                    </div>
                                </div>

                            </div>


                            <div class="tab-pane" id="tab_Info">
                                <div class="box-body">
                                    <div class="col-md-12">
                                        <table id="admin-staff-supplier" class="display table-hover table-condensed" width="100%">
                                            <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Supplier Name</th>
                                                <th>Supplier Since</th>
                                                <th>Contact Phone</th>
                                                <th>Contact Mobile</th>
                                                <th>Email Address</th>
                                                <th>Address</th>
                                                <th>Contact Person</th>
                                                <th>Category</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Close</button>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    
    <div class="modal fade" id="modal-logs">
        <div class="modal-dialog" style = "width : 50%;">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <center><h3 class="modal-title">Logs</h3></center>
                </div>
                <div class="modal-body" >
                    <div class = "box box-info">
                        <div class = "row" style = "padding-top: 50px;">
                            <div class="col-md-12">
                                <table class="table-condensed table-hover" id="admin-staff-logs" width="100%">
                                    <thead>
                                    <tr>
                                        <th>Assigned by</th>
                                        <th>Employee Name</th>
                                        <th>Activity</th>
                                        <th>Remarks</th>
                                        <th>Date and Time</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th>Assigned by</th>
                                        <th>Employee Name</th>
                                        <th>Activity</th>
                                        <th>Remarks</th>
                                        <th>Date and Time</th>
                                    </tr>
                                    </tfoot>
                                </table>
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

    
    <div class="modal fade" id = "modal-ar_assigned">
        <div class="modal-dialog" style = "width : 60%;">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <center><h4 class="modal-title" id = "ar_title" ></h4></center>
                </div>
                <div class="modal-body">
                    <div class = "row">
                        <div class = "col-md-3"></div>
                        <div class = "col-md-6">
                            <div class = "box box-warning">
                                <center><img src="" id = "show_emp_image" class="img-circle" style = "padding-top : 20px;"></center>
                                <span id = "emp_name"></span>
                                <span id = "emp_details"></span>
                            </div>
                        </div>
                        <div class = "col-md-3"></div>
                    </div>
                    <div class = "row">
                        <div class = "col-md-1"></div>
                        <div class = "col-md-10">
                            <div class = "box box-warning">
                                <center><h3 style = "font-family: Georgia,serif; padding-bottom : 10px;">Assigned Item/s</h3></center>
                                <table id="admin-staff-item-ar" class="table table-bordered table-striped" width="100%">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Category</th>
                                        <th>Brand/Model Name</th>
                                        <th>Amount</th>
                                        <th>Color</th>
                                        <th>Remarks</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th>Category</th>
                                        <th>Brand/Model Name</th>
                                        <th>Amount</th>
                                        <th>Color</th>
                                        <th>Remarks</th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <div class = "col-md-1"></div>
                        <div>

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

    
    <div class="modal modal-success fade" id="modal-successrequest">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Success!</h4>
                </div>
                <div class="modal-body">
                    <p style="text-align: center">Successfully Added Request</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline pull-right" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    
    <div class="modal fade" id="modal-item-status-change">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Status Update of <span id = "spectUpdateName"></span></h4>
                </div>
                <div class="modal-body">
                    <div class = "box-body">
                        <div class = "row">
                            <div class = "col-md-12">
                                <label for="" style = "padding-bottom : 10px;">Item Status:</label>
                                <textarea  class="form-control" rows = "2" id = "show_specs_status"></textarea>
                            </div>
                        </div>
                        <div class = "row" style = "padding-top : 15px;">
                            <div class= "col-md-6">
                                <label for="" style = "padding-bottom : 10px;">Clearance/Confirmation Form: <small style = "color:red;">*required</small> </label>
                                <input type="file" id = "clearance_offboarding">
                            </div>
                            <div class = "col-md-6" style = "padding-top: 30px;">
                                <button type = "button" class = "pull-right">Remove</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning" id = "btnUpdateSpecStatus">Save Changes</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    
    <div class="modal modal-warning fade" id="modal-changeitem">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <p style="text-align: center">Please change fields to update!</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline pull-right" data-dismiss="modal" id="btnModalCloseFillUpError">Close</button>
                </div>
            </div>
        </div>
    </div>
    
    <div class="modal modal-success fade" id="modal-fund-edit-success">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <p style="text-align: center">Successfully Updated Fund Request</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline pull-right" data-dismiss="modal" id="btnModalCloseFillUpError">Close</button>
                </div>
            </div>
        </div>
    </div>
    
    <div class="modal fade" id="modal-viewDocu">
        <div class="modal-dialog" id = "editSizeModalAdmin"  style = "width : 50%">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">General Forms</h4>
                </div>
                <div class="modal-body">
                    <div class = "row">
                        <div id = "formUploadAdmin"></div>
                        <div class = "col-md-12" id = "changeFormSizeAdmin">
                            <div class = "box box-danger">
                                <div class = "row">
                                    <h4 style = "font-family: Georgia,serif; text-align: center">List of Uploaded Files</h4>
                                    <div class = "col-md-12">
                                        <div class="nav-tabs-custom">
                                            <ul class="nav nav-tabs">
                                                <li class="active"><a href="#general_forms_tab1" data-toggle="tab" class="generalforms_tab">Active</a></li>
                                                <li class=""><a href="#general_forms_tab2" data-toggle="tab" class="generalforms_tab">Archived</a></li>
                                            </ul>
                                            <div class="tab-content">
                                                    <div class="tab-pane active" id="general_forms_tab1">
                                                        <table id = "human-resources-file-format" class="table-condensed" width="100%">
                                                            <thead>
                                                            <tr>
                                                                <th>ID</th>
                                                                <th>Title</th>
                                                                <th>Description</th>
                                                                <th>Action</th>
                                                            </tr>
                                                            </thead>
                                                        </table>
                                                    </div>

                                                <div class="tab-pane" id="general_forms_tab2">
                                                    <table id = "human-resources-file-format-archived" class="table-condensed" width="100%">
                                                        <thead>
                                                        <tr>
                                                            <th>ID</th>
                                                            <th>Title</th>
                                                            <th>Description</th>
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
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Close</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>


    <div class="modal fade" id="modal-emp-profile-view-req">
        <div class="modal-dialog" style = "width: 60%;">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <center>
                        <h5 class="modal-title"><b>Employee Equipment</b></h5>
                    </center>
                </div>
                <div class="modal-body">
                    <div class = "box-body">
                        <div class="row">
                            <div class="col-md-4">
                            </div>
                            <div class="col-md-4">
                                <div class="box box-info">
                                    <center>
                                        <img id = "emp_show_pic_me_req" style="padding: 10px" class="img-circle" src = "<?php echo e(asset('user_profile_pictures/default3.jpg')); ?>"/>
                                        <p id = "nameStorage_req"></p>
                                        <p id = "positionStorage_req"></p>
                                    </center>
                                </div>
                            </div>
                            <div class="col-md-4">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="box box-info">
                                    <div class="nav-tabs-custom" style = "padding-top: 20px;">
                                        <ul class="nav nav-tabs">
                                            <li  class = "active"><a id="tab3" href="#tab_ViewReq1" data-toggle="tab" class = "human_resources_emp_details_class">Requirements Checklist</a></li>
                                            <li><a id="tab3" href="#tab_ViewReq2" data-toggle="tab" class = "human_resources_emp_details_class">Employee Necessity</a></li>

                                        </ul>
                                        <div class = "tab-content">
                                            <div class="tab-pane active" id="tab_ViewReq1">
                                                <div class = "row" style = "padding-top: 20px;">
                                                    <div class = "col-md-1"></div>
                                                    <div class = "col-md-10">
                                                        <div class = "box box-danger">
                                                            <center><h4 style = "font-family: Georgia,serif;">Accountabilities/Equipments</h4></center>
                                                            <div class = "row" style = "padding-top : 30px; padding-bottom : 10px;">
                                                                <div class = "col-md-1"></div>
                                                                <div class = "col-md-5">
                                                                    <div class = "row" style = "padding-top: 20px;">
                                                                        <div class = "col-md-12">
                                                                            <input type="checkbox" class = "view_checklist icheckbox_minimal-blue" value = "ATM" disabled><b>ATM</b>
                                                                        </div>
                                                                    </div>
                                                                    <div class = "row" style = "padding-top: 20px;">
                                                                        <div class = "col-md-12">
                                                                            <input type="checkbox" class = "view_checklist icheckbox_minimal-blue" value = "ID" disabled><b>ID</b>
                                                                        </div>
                                                                    </div>
                                                                    <div class = "row" style = "padding-top: 20px;">
                                                                        <div class = "col-md-12">
                                                                            <input type="checkbox" class = "view_checklist icheckbox_minimal-blue" value = "GMAIL & PASSWORD/CCSI EMAIL" disabled><b>GMAIL & PASSWORD/CCSI EMAIL</b>
                                                                        </div>
                                                                    </div>
                                                                    <div class = "row" style = "padding-top: 20px;">
                                                                        <div class = "col-md-12">
                                                                            <input type="checkbox" class = "view_checklist icheckbox_minimal-blue" value = "PHONE/IP PHONE" disabled><b>PHONE/IP PHONE</b>
                                                                        </div>
                                                                    </div>
                                                                    <div class = "row" style = "padding-top: 20px;">
                                                                        <div class = "col-md-12">
                                                                            <input type="checkbox" class = "view_checklist icheckbox_minimal-blue" value = "NUMBER" disabled><b>NUMBER</b>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class = "col-md-1"></div>
                                                                <div class = "col-md-5">
                                                                    <div id = "officeChecklistView">
                                                                        <div class = "row" style = "padding-top: 20px;">
                                                                            <div class = "col-md-12">
                                                                                <input type="checkbox" class = "view_checklist icheckbox_minimal-blue" value = "COMPUTER" disabled><b>COMPUTER</b>
                                                                            </div>
                                                                        </div>
                                                                        <div class = "row" style = "padding-top: 20px;">
                                                                            <div class = "col-md-12">
                                                                                <input type="checkbox" class = "view_checklist icheckbox_minimal-blue" value = "FB(IF NEEDED)" disabled><b>FB(IF NEEDED)</b>
                                                                            </div>
                                                                        </div>
                                                                        <div class = "row" style = "padding-top: 20px;">
                                                                            <div class = "col-md-12">
                                                                                <input type="checkbox" class = "view_checklist icheckbox_minimal-blue" value = "BIOMETRICS" disabled><b>BIOMETRICS</b>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div id = "ciChecklistView">
                                                                        <div class = "row" style = "padding-top: 20px;">
                                                                            <div class = "col-md-12">
                                                                                <input type="checkbox" class = "view_checklist icheckbox_minimal-blue" value = "INSURANCE" disabled><b>INSURANCE</b>
                                                                            </div>
                                                                        </div>
                                                                        <div class = "row" style = "padding-top: 20px;">
                                                                            <div class = "col-md-12">
                                                                                <input type="checkbox" class = "view_checklist icheckbox_minimal-blue" value = "SHELLCARD" disabled><b>SHELLCARD</b>
                                                                            </div>
                                                                        </div>
                                                                        <div class = "row" style = "padding-top: 20px;">
                                                                            <div class = "col-md-12">
                                                                                <input type="checkbox" class = "view_checklist icheckbox_minimal-blue" value = "UNIFORM" disabled><b>UNIFORM</b>
                                                                            </div>
                                                                        </div>
                                                                        <div class = "row" style = "padding-top: 20px;">
                                                                            <div class = "col-md-12">
                                                                                <input type="checkbox" class = "view_checklist icheckbox_minimal-blue" value = "AUTHORIZATION" disabled><b>AUTHORIZATION</b>
                                                                            </div>
                                                                        </div>
                                                                        <div class = "row" style = "padding-top: 20px;">
                                                                            <div class = "col-md-12">
                                                                                <input type="checkbox" class = "view_checklist icheckbox_minimal-blue" value = "INTRODUCTION LETTER" disabled><b>INTRODUCTION LETTER</b>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class = "col-md-1"></div>
                                                </div>
                                            </div>

                                            <div class="tab-pane" id="tab_ViewReq2">
                                                <div class = "row" style = "padding-top: 10px;">
                                                    <div class = "col-md-12">
                                                        <div class = "box box-danger">
                                                            <h4 style = "text-align: center; font-weight: bold; font-family: Georgia,serif; padding-top: 15px;">ID, Uniform , Insurance and ATM</h4>
                                                            <div class = "row" style = "padding-top : 20px;">
                                                                <div class = "col-md-5">
                                                                    <h5 style = "font-weight: bold ; ">ID Status:</h5>
                                                                    <h5 id = "emp_id_stat_view_req"></h5>
                                                                </div>
                                                                <div class = "col-md-2"></div>
                                                                <div class = "col-md-5">
                                                                    <h5 style = "font-weight: bold">ID No. : </h5>
                                                                    <h5 id = "emp_id_no_view_req"></h5>
                                                                </div>
                                                            </div>
                                                            <div class = "row">
                                                                <div class = "col-md-5">
                                                                    <h5 style = "font-weight: bold">Uniform: </h5>
                                                                    <h5 id = "emp_uni_view_req"></h5>
                                                                </div>
                                                                <div class = "col-md-2"></div>
                                                                <div class = "col-md-5">
                                                                    <h5 style = "font-weight: bold">Bank Name:</h5>
                                                                    <h5 id  = "emp_bank_name_view_req"></h5>
                                                                </div>
                                                            </div>
                                                            <div class = "row">
                                                                <div class = "col-md-5">
                                                                    <h5 style = "font-weight: bold">FB/Messenger: </h5>
                                                                    <h5 id = "emp_fb_view_req"></h5>
                                                                </div>
                                                                <div class = "col-md-2"></div>
                                                                <div class = "col-md-5">
                                                                    <h5 style = "font-weight: bold">Computer:</h5>
                                                                    <h5 id = "emp_computer_view_req"></h5>
                                                                </div>
                                                            </div>
                                                            <div class = "row">
                                                                <div class = "col-md-5">
                                                                    <h5 style = "font-weight: bold">Health Card Info: </h5>
                                                                    <h5 id = "emp_health_card_view_req"></h5>
                                                                </div>
                                                                <div class = "col-md-2"></div>
                                                                <div class = "col-md-5">
                                                                    <h5 style = "font-weight: bold">Accident Insurance:</h5>
                                                                    <h5 id = "emp_accident_view_req"></h5>
                                                                </div>
                                                            </div>
                                                            <h4 style = "text-align: center; font-weight: bold; font-family: Georgia,serif;">Company Phone</h4>
                                                            <div class = "row" style = "padding-top : 20px;">
                                                                <div class = "col-md-5">
                                                                    <h5 style = "font-weight: bold">Phone Number: </h5>
                                                                    <h5 id = "emp_phone_number_view_req"></h5>
                                                                </div>
                                                                <div class = "col-md-2"></div>
                                                                <div class = "col-md-5">
                                                                    <h5 style = "font-weight: bold">Unit Price:</h5>
                                                                    <h5 id = "emp_unit_price_view_req"></h5>
                                                                </div>
                                                            </div>
                                                            <div class = "row">
                                                                <div class = "col-md-12">
                                                                    <h5 style = "font-weight: bold">Phone Description:</h5>
                                                                    <h5 id ="emp_phone_desc_view_req"></h5>
                                                                </div>
                                                            </div>

                                                            <h4 style = "text-align: center; font-weight: bold; font-family: Georgia,serif;">Gmail/OIMS Access</h4>

                                                            <div class = "row" style = "padding-top : 20px;">
                                                                <div class = "col-md-5">
                                                                    <h5 style = "font-weight: bold">OIMS Username/Email Address:</h5>
                                                                    <h5 id = "emp_oims_view_req"></h5>
                                                                </div>
                                                                <div class = "col-md-2"></div>
                                                                <div class = "col-md-5">
                                                                    <h5 style = "font-weight: bold">Corporate Gmail Address:</h5>
                                                                    <h5 id = "emp_gmail_view_req"></h5>
                                                                </div>
                                                            </div>
                                                            <div class = "row">
                                                                <div class = "col-md-5">
                                                                    <h5 style = "font-weight: bold">Gmail Password:</h5>
                                                                    <h5 id ="emp_gmail_password_req"></h5>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <span id = "down"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" >
                    <button type="button" id = "btnCloseEmp" class="btn btn-warning pull-right" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    
    <div class="modal modal-warning fade" id="modal-change-atm">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Note!</h4>
                </div>
                <div class="modal-body">
                    <p style="text-align: center">Please change atleast 1 field to update!</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline pull-right" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    
    <div class="modal modal-success fade" id="modal-atm">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Success!</h4>
                </div>
                <div class="modal-body">
                    <p style="text-align: center">Successfully Updated Details!</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline pull-right" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-denial-remarks">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <center><h4 class="modal-title" >Information</h4></center>
                </div>
                <div class="modal-body">
                    <div class = "box-body">
                        <div class = "box box-warning">
                            <div class = "row" style = "padding-top : 30px; padding-bottom: 15px;">
                                <div class = "col-md-12">
                                    <label for="">Deniel Remarks</label>
                                    <textarea id = "show_denial_remarks" class = "form-control" rows="5" disabled></textarea>
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

    <div class="modal fade" id="modal-incomplete-remarks">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <center><h4 class="modal-title" >Information</h4></center>
                </div>
                <div class="modal-body">
                    <div class = "box-body">
                        <div class = "box box-warning">
                            <div class = "row" style = "padding-top : 30px; padding-bottom: 15px;">
                                <div class = "col-md-12">
                                    <label for="">Incomplete Remarks: </label>
                                    <textarea id = "show_incom_remarks" class = "form-control" rows="5" disabled></textarea>
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

    <div class="modal fade" id="modal-return-remarks">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <center><h4 class="modal-title" >Information</h4></center>
                </div>
                <div class="modal-body">
                    <div class = "box-body">
                        <div class = "box box-warning">
                            <div class = "row" style = "padding-top : 30px; padding-bottom: 15px;">
                                <div class = "col-md-12">
                                    <label for="">Return Remarks: </label>
                                    <textarea id = "show_return_remarks" class = "form-control" rows="5" disabled></textarea>
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


    <div class="modal fade" id="modal-emp-profile-view">
        <div class="modal-dialog" style = "width: 80%;">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <center>
                        <h5 class="modal-title"><b>Employee Profile</b></h5>
                    </center>
                </div>
                <div class="modal-body">
                    <div class = "box-body">
                        <div class="row">
                            <div class="col-md-4">
                            </div>
                            <div class="col-md-4">
                                <div class="box box-info">
                                    <center>
                                        <img id = "emp_show_pic_me" style="padding: 10px" class="img-circle" src = "<?php echo e(asset('user_profile_pictures/default3.jpg')); ?>"/>
                                        <p id = "nameStorage"></p>
                                        <p id = "positionStorage"></p>
                                    </center>
                                </div>
                            </div>
                            <div class="col-md-4">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="box box-info">
                                    <div class="nav-tabs-custom" style = "padding-top: 20px;">
                                        <ul class="nav nav-tabs">
                                            <li class="active" id = "tabDetails"><a id="tab1" href="#tab_View1" data-toggle="tab" class = "human_resources_emp_details_class">Employee Details</a></li>
                                            <li id = "tabSched"><a id="tab2" href="#tab_View2" data-toggle="tab" class = "human_resources_emp_details_class">Specific Time Schedule</a></li>
                                            <li id = "tabChecklist"><a id="tab3" href="#tab_View3" data-toggle="tab" class = "human_resources_emp_details_class">Requirements Checklist</a></li>
                                            <li id = "tabGenEq"><a id="tab3" href="#tab_View4" data-toggle="tab" class = "human_resources_emp_details_class">Employee Necessity</a></li>

                                        </ul>
                                        <div class = "tab-content">
                                            <div class="tab-pane active" id="tab_View1">
                                                <div class = "row" style = "padding-top : 20px;">
                                                    <div class = "col-md-4">
                                                        <label for="emp_show_branch">Branch:</label>
                                                        <input type="text" id = "emp_show_branch" class = "form-control"  disabled>
                                                    </div>
                                                    <div class = "col-md-4">
                                                        <label for="emp_show_salary">Salary Offer:</label>
                                                        <input type="text" id = "emp_show_salary" class = "form-control" disabled>
                                                    </div>
                                                    <div class = "col-md-4">
                                                        <label for="emp_show_age">Age:</label>
                                                        <input type="text" id = "emp_show_age" class = "form-control" disabled>
                                                    </div>
                                                </div>
                                                <div class = "row" style = "padding-top: 20px;">
                                                    <div class = "col-md-4">
                                                        <label for="emp_show_date_birth">Date of Birth:</label>
                                                        <input type="date" id = "emp_show_date_birth" class = "form-control" disabled>
                                                    </div>
                                                    <div class = "col-md-4">
                                                        <label for="emp_show_religion">Religion:</label>
                                                        <input type="text" id = "emp_show_religion" class = "form-control" disabled>
                                                    </div>
                                                    <div class = "col-md-4">
                                                        <label for="emp_show_marital_status">Marital Status:</label>
                                                        <input type="text" id = "emp_show_marital_status" class = "form-control" disabled>
                                                    </div>
                                                </div>
                                                <div class = "row" style = "padding-top: 20px;">
                                                    <div class = "col-md-4">
                                                        <label for="emp_show_dependents">No. of Dependents</label>
                                                        <input type="text" id = "emp_show_dependents" class = "form-control" disabled>
                                                    </div>
                                                    <div class = "col-md-4">
                                                        <label for="emp_show_mobile">Primary Contact no.: </label>
                                                        <input type="text" id = "emp_show_mobile" class = "form-control" disabled>
                                                    </div>
                                                    <div class = "col-md-4">
                                                        <label for="emp_show_email">Primary Email Address.:</label>
                                                        <input type="text" id = "emp_show_email" class = "form-control" disabled>
                                                    </div>
                                                </div>
                                                <div class = "row" style = "padding-top: 20px;">
                                                    <div class = "col-md-4">
                                                        <label for="">Contract Status:</label>
                                                        <input type="text" id = "emp_show_con_stat" class = "form-control" disabled>
                                                    </div>
                                                    <div class = "col-md-4">
                                                        <label for="">Employment Status:</label>
                                                        <input type="text" id = "emp_show_emp_status" class = "form-control" disabled>
                                                    </div>
                                                    <div class = "col-md-4">
                                                        <label for="">Off-Board Status: <small style = "color: red;">*if applicable</small></label>
                                                        <input type="text" id = "emp_show_outgoing" class = "form-control" disabled>
                                                    </div>
                                                </div>
                                                <div class = "row" style = "padding-top: 20px;">
                                                    <div class = "col-md-4">
                                                        <label for="">Type of Rate:</label>
                                                        <input type="text" id = "emp_show_rate" class = "form-control" disabled>
                                                    </div>
                                                    <div class = "col-md-4">
                                                        <label for="">Mandated No. of Working Days:</label>
                                                        <input type="text" id = "emp_show_days" class = "form-control" disabled>
                                                    </div>
                                                    <div class = "col-md-4">
                                                        <label for="">Remaining Days of Contract:</label>
                                                        <input type="text" id = "emp_show_remaining" class = "form-control" disabled>
                                                    </div>
                                                </div>
                                                <div class = "row" style = "padding-top: 20px;">
                                                    <div class="col-md-4">
                                                        <label for="">Allowances:</label>
                                                        <input type="text" class = "form-control" id = "emp_show_allowances" disabled>
                                                    </div>
                                                    <div class = "col-md-8">
                                                        <label for="">Fixed Time Schedule:</label>
                                                        <input type="text" class = "form-control" id = "emp_show_fixed" disabled>
                                                    </div>
                                                </div>
                                                <div class = "row" style = "padding-top: 20px;">
                                                    <div class="col-md-12">
                                                        <label>Permanent Address:</label>
                                                        <label for="emp_show_permanent"></label><textarea class="form-control" rows = "1" id="emp_show_permanent"  disabled></textarea>
                                                    </div>
                                                </div>
                                                <div class = "row" style = "padding-top: 20px;">
                                                    <div class="col-md-12">
                                                        <label>Present Address:</label>
                                                        <label for="emp_show_present"></label><textarea class="form-control" rows = "1" id="emp_show_present" disabled></textarea>
                                                    </div>
                                                </div>
                                                <div class = "row" style = "padding-top: 20px;" id = "ciShow">
                                                    <div class = "col-md-6">
                                                        <label for="emp_show_area">Area of Assignment : </label>
                                                        <input type="text" id = "emp_show_area" class = "form-control" value = "" disabled>
                                                    </div>
                                                    <div class = "col-md-6">
                                                        <label for="emp_show_philhealth">Motor CC type:</label>
                                                        <input type="text" id = "emp_show_cc" class = "form-control" value = "" disabled>
                                                    </div>
                                                </div>
                                                <div class = "row" style = "padding-top: 20px;">
                                                    <div class = "col-md-6">
                                                        <label for="emp_show_ss">SSS no. : </label>
                                                        <input type="text" id = "emp_show_ss" class = "form-control" value = "" disabled>
                                                    </div>
                                                    <div class = "col-md-6">
                                                        <label for="emp_show_philhealth">Philhealth no. :</label>
                                                        <input type="text" id = "emp_show_philhealth" class = "form-control" value = "" disabled>
                                                    </div>
                                                </div>
                                                <div class = "row" style = "padding-top: 20px;">
                                                    <div class = "col-md-6">
                                                        <label for="emp_show_pagibig">Pagibig no. :</label>
                                                        <input type="text" id = "emp_show_pagibig" class = "form-control" value = "" disabled>
                                                    </div>
                                                    <div class = "col-md-6">
                                                        <label for="emp_show_tin">TIN no.:</label>
                                                        <input type="text" id = "emp_show_tin" class = "form-control " value = "" disabled>
                                                    </div>
                                                </div>
                                                <div class = "row" style="padding-top: 20px; padding-bottom : 20px;">
                                                    <div class = "col-md-3"></div>
                                                    <div class = "col-md-6">
                                                        <button type = "submit" class="btn btn-info btn-block" id = "btnDownloadEmp"><i class = "fa fa-fw fa-arrow-down" ></i>Download Employee File</button>
                                                    </div>
                                                    <div class = "col-md-3"></div>
                                                </div>
                                            </div>
                                            <div class="tab-pane" id="tab_View2">
                                                <div class = "row">
                                                    <div class = "col-md-12">
                                                        <div class = "box box-danger">
                                                            <div class = "row" style = "padding-top : 20px;">
                                                                <div class = "col-md-5">
                                                                    <input type="text" class = "form-control"  value = "Monday" disabled>
                                                                </div>
                                                                <div class = "col-md-3">
                                                                    <input type = "time" id = "view_in1" class = "form-control" disabled>
                                                                </div>
                                                                <div class = "col-md-1">
                                                                    <h5>to</h5>
                                                                </div>
                                                                <div class = "col-md-3">
                                                                    <input type = "time" id = "view_out1" class = "form-control" disabled>
                                                                </div>
                                                            </div>
                                                            <div class = "row" style = "padding-top : 5px;">
                                                                <div class = "col-md-5">
                                                                    <input type="text" class = "form-control"  value = "Tuesday" disabled>
                                                                </div>
                                                                <div class = "col-md-3">
                                                                    <input type = "time" id = "view_in2" class = "form-control" disabled>
                                                                </div>
                                                                <div class = "col-md-1">
                                                                    <h5>to</h5>
                                                                </div>
                                                                <div class = "col-md-3">
                                                                    <input type = "time" id = "view_out2" class = "form-control" disabled>
                                                                </div>
                                                            </div>
                                                            <div class = "row" style = "padding-top : 5px;">
                                                                <div class = "col-md-5">
                                                                    <input type="text" class = "form-control" value = "Wednesday" disabled>
                                                                </div>
                                                                <div class = "col-md-3">
                                                                    <input type = "time" id = "view_in3" class = "form-control" disabled>
                                                                </div>
                                                                <div class = "col-md-1">
                                                                    <h5>to</h5>
                                                                </div>
                                                                <div class = "col-md-3">
                                                                    <input type = "time" id = "view_out3" class = "form-control"disabled>
                                                                </div>
                                                            </div>
                                                            <div class = "row" style = "padding-top : 5px;">
                                                                <div class = "col-md-5">
                                                                    <input type="text" class = "form-control"  value = "Thursday" disabled>
                                                                </div>
                                                                <div class = "col-md-3">
                                                                    <input type = "time" id = "view_in4" class = "form-control" disabled>
                                                                </div>
                                                                <div class = "col-md-1">
                                                                    <h5>to</h5>
                                                                </div>
                                                                <div class = "col-md-3">
                                                                    <input type = "time" id = "view_out4" class = "form-control" disabled>
                                                                </div>
                                                            </div>
                                                            <div class = "row" style = "padding-top : 5px;">
                                                                <div class = "col-md-5">
                                                                    <input type="text" class = "form-control" value = "Friday" disabled>
                                                                </div>
                                                                <div class = "col-md-3">
                                                                    <input type = "time" id = "view_in5" class = "form-control" disabled >
                                                                </div>
                                                                <div class = "col-md-1">
                                                                    <h5>to</h5>
                                                                </div>
                                                                <div class = "col-md-3">
                                                                    <input type = "time" id = "view_out5" class = "form-control" disabled>
                                                                </div>
                                                            </div>
                                                            <div class = "row" style = "padding-top : 5px;">
                                                                <div class = "col-md-5">
                                                                    <input type="text" class = "form-control" value = "Saturday" disabled>
                                                                </div>
                                                                <div class = "col-md-3">
                                                                    <input type = "time" id = "view_in6" class = "form-control" disabled>
                                                                </div>
                                                                <div class = "col-md-1">
                                                                    <h5>to</h5>
                                                                </div>
                                                                <div class = "col-md-3">
                                                                    <input type = "time" id = "view_out6" class = "form-control" disabled>
                                                                </div>
                                                            </div>
                                                            <div class = "row" style = "padding-top : 5px;">
                                                                <div class = "col-md-5">
                                                                    <input type="text" class = "form-control" value = "Sunday" disabled>
                                                                </div>
                                                                <div class = "col-md-3">
                                                                    <input type = "time" id = "view_in7" class = "form-control" disabled>
                                                                </div>
                                                                <div class = "col-md-1">
                                                                    <h5>to</h5>
                                                                </div>
                                                                <div class = "col-md-3">
                                                                    <input type = "time" id = "view_out7" class = "form-control" disabled>
                                                                </div>
                                                            </div>
                                                            <div class = "row" style = "padding-top: 20px;">
                                                                <div class = "col-md-12">
                                                                    <label for="">Remarks:</label>
                                                                    <textarea id="view_sched_remarks" rows="5" class = "form-control" disabled></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane" id="tab_View3">
                                                <div class = "row" style = "padding-top: 20px;">
                                                    <div class = "col-md-1"></div>
                                                    <div class = "col-md-10">
                                                        <div class = "box box-danger">
                                                            <center><h4 style = "font-family: Georgia,serif;">Pre-employment Requirements</h4></center>
                                                            <div class = "row" style = "padding-top : 30px;">
                                                                <div class = "col-md-1"></div>
                                                                <div class = "col-md-5">
                                                                    <input type="checkbox"  class = "view_checklist icheckbox_minimal-blue" value = "SSS" disabled><b>SSS</b>
                                                                </div>
                                                                <div class = "col-md-1"></div>
                                                                <div class = "col-md-5">
                                                                    <input type="checkbox"  class = "view_checklist icheckbox_minimal-blue" value = "X-RAY" disabled><b>X-RAY</b>
                                                                </div>
                                                            </div>
                                                            <div class = "row" style = "padding-top : 20px;">
                                                                <div class = "col-md-1"></div>
                                                                <div class = "col-md-5">
                                                                    <input type="checkbox" class = "view_checklist icheckbox_minimal-blue" value = "PHILHEALTH" disabled><b>PHILHEALTH</b>
                                                                </div>
                                                                <div class = "col-md-1"></div>
                                                                <div class = "col-md-5">
                                                                    <input type="checkbox" class = "view_checklist icheckbox_minimal-blue" value = "NBI CLEARANCE" disabled><b>NBI CLEARANCE</b>
                                                                </div>
                                                            </div>
                                                            <div class = "row" style = "padding-top : 20px;">
                                                                <div class = "col-md-1"></div>
                                                                <div class = "col-md-5">
                                                                    <input type="checkbox" class = "view_checklist icheckbox_minimal-blue" value = "PAGIBIG" disabled><b>PAGIBIG</b>
                                                                </div>
                                                                <div class = "col-md-1"></div>
                                                                <div class = "col-md-5">
                                                                    <input type="checkbox" class = "view_checklist icheckbox_minimal-blue" value = "MAYOR'S PERMIT" disabled><b>MAYOR'S PERMIT</b>
                                                                </div>
                                                            </div>
                                                            <div class = "row" style = "padding-top : 20px;">
                                                                <div class = "col-md-1"></div>
                                                                <div class = "col-md-5">
                                                                    <input type="checkbox" class = "view_checklist icheckbox_minimal-blue" value = "TIN" disabled><b>TIN</b>
                                                                </div>
                                                                <div class = "col-md-1"></div>
                                                                <div class = "col-md-5">
                                                                    <input type="checkbox" class = "view_checklist icheckbox_minimal-blue" value = "POLICE CLEARANCE" disabled><b>POLICE CLEARANCE</b>
                                                                </div>
                                                            </div>
                                                            <div class = "row" style = "padding-top : 20px;">
                                                                <div class = "col-md-1"></div>
                                                                <div class = "col-md-5">
                                                                    <input type="checkbox" class = "view_checklist icheckbox_minimal-blue" value = "MEDICAL HISTORY" disabled><b>MEDICAL HISTORY</b>
                                                                </div>
                                                                <div class = "col-md-1"></div>
                                                                <div class = "col-md-5">
                                                                    <input type="checkbox" class = "view_checklist icheckbox_minimal-blue" value = "BRGY CLEARANCE" disabled><b>BRGY CLEARANCE</b>
                                                                </div>
                                                            </div>
                                                            <div class = "row" style = "padding-top : 20px;">
                                                                <div class = "col-md-1"></div>
                                                                <div class = "col-md-5">
                                                                    <input type="checkbox" class = "view_checklist icheckbox_minimal-blue" value = "DRUG TEST" disabled> <b>DRUG TEST</b>
                                                                </div>
                                                                <div class = "col-md-1"></div>
                                                                <div class = "col-md-5">
                                                                    <input type="checkbox" class = "view_checklist icheckbox_minimal-blue" value = "VOTER'S ID(OPTIONAL)" disabled><b>VOTER'S ID(OPTIONAL)</b>
                                                                </div>
                                                            </div>
                                                            <div class = "row" style = "padding-top : 20px;">
                                                                <div class = "col-md-1"></div>
                                                                <div class = "col-md-5">
                                                                    <input type="checkbox" class = "view_checklist icheckbox_minimal-blue" value = "STOOL" disabled><b>STOOL</b>
                                                                </div>
                                                                <div class = "col-md-1"></div>
                                                                <div class = "col-md-5">
                                                                    <input type="checkbox" class = "view_checklist icheckbox_minimal-blue" value = "PREGNANCY TEST(IF FEMALE)" disabled><b>PREGNANCY TEST(IF FEMALE)</b>
                                                                </div>
                                                            </div>
                                                            <div class = "row" style = "padding-top : 20px; padding-bottom : 10px;">
                                                                <div class = "col-md-1"></div>
                                                                <div class = "col-md-5">
                                                                    <input type="checkbox" class = "view_checklist icheckbox_minimal-blue" value = "URINALYSIS" disabled><b>URINALYSIS</b>
                                                                </div>
                                                                <div class = "col-md-1"></div>
                                                                <div class = "col-md-5">
                                                                    <div id = "ciMotorReqView">
                                                                        <input type="checkbox" class = "view_checklist icheckbox_minimal-blue" value = "MOTOR DETAILS" disabled><b>MOTOR DETAILS</b>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class = "col-md-1"></div>
                                                </div>
                                                <div class = "row">
                                                    <div class = "col-md-1"></div>
                                                    <div class = "col-md-10">
                                                        <div class = "box box-danger">
                                                            <center><h4 style = "font-family: Georgia,serif;">Pre-employment CCSI Docs</h4></center>
                                                            <div class = "row" style = "padding-top : 30px;">
                                                                <div class = "col-md-1"></div>
                                                                <div class = "col-md-5">
                                                                    <input type="checkbox" class = "view_checklist icheckbox_minimal-blue" value = "RESUME" disabled><b>RESUME</b>
                                                                </div>
                                                                <div class = "col-md-1"></div>
                                                                <div class = "col-md-5">
                                                                    <input type="checkbox" class = "view_checklist icheckbox_minimal-blue" value = "CMAP RESULT" disabled><b>CMAP RESULT</b>
                                                                </div>
                                                            </div>
                                                            <div class = "row" style = "padding-top : 20px;">
                                                                <div class = "col-md-1"></div>
                                                                <div class = "col-md-5">
                                                                    <input type="checkbox" class = "view_checklist icheckbox_minimal-blue" value = "APPLICATION FORM" disabled><b>APPLICATION FORM</b>
                                                                </div>
                                                                <div class = "col-md-1"></div>
                                                                <div class = "col-md-5">
                                                                    <input type="checkbox" class = "view_checklist icheckbox_minimal-blue" value = "EVALUATION EXAM" disabled><b>EVALUATION EXAM</b>
                                                                </div>
                                                            </div>
                                                            <div class = "row" style = "padding-top : 20px;">
                                                                <div class = "col-md-1"></div>
                                                                <div class = "col-md-5">
                                                                    <input type="checkbox" class = "view_checklist icheckbox_minimal-blue" value = "PRE-EMPLOYMENT EXAM" disabled><b>PRE-EMPLOYMENT EXAM</b>
                                                                </div>
                                                                <div class = "col-md-1"></div>
                                                                <div class = "col-md-5">
                                                                    <input type="checkbox" class = "view_checklist icheckbox_minimal-blue" value = "EVALUATION" disabled><b>EVALUATION</b>
                                                                </div>
                                                            </div>
                                                            <div class = "row" style = "padding-top : 20px;">
                                                                <div class = "col-md-1"></div>
                                                                <div class = "col-md-5">
                                                                    <input type="checkbox" class = "view_checklist icheckbox_minimal-blue" value = "TRAINING AGREEMENT" disabled><b>TRAINING AGREEMENT</b>
                                                                </div>
                                                                <div class = "col-md-1"></div>
                                                                <div class = "col-md-5">
                                                                    <input type="checkbox" class = "view_checklist icheckbox_minimal-blue" value = "HANDBOOK AND DPA" disabled><b>HANDBOOK AND DPA</b>
                                                                </div>
                                                            </div>
                                                            <div class = "row" style = "padding-top : 20px;">
                                                                <div class = "col-md-1"></div>
                                                                <div class = "col-md-5">
                                                                    <input type="checkbox" class = "view_checklist icheckbox_minimal-blue" value = "HR HEAD REQUEST" disabled><b>HR HEAD REQUEST</b>
                                                                </div>
                                                                <div class = "col-md-6"></div>
                                                            </div>
                                                            <div class = "row" style = "padding-top : 20px;">
                                                                <div class = "col-md-1"></div>
                                                                <div class = "col-md-5">
                                                                    <input type="checkbox" class = "view_checklist icheckbox_minimal-blue" value = "BGC REPORT" disabled><b>BGC REPORT</b>
                                                                </div>
                                                                <div class = "col-md-6"></div>
                                                            </div>
                                                            <div class = "row" style = "padding-top : 20px;">
                                                                <div class = "col-md-1"></div>
                                                                <div class = "col-md-5">
                                                                    <input type="checkbox" class = "view_checklist icheckbox_minimal-blue" value = "PDRN RESIDENTIAL CHECKING" disabled><b>PDRN RESIDENTIAL CHECKING</b>
                                                                </div>
                                                                <div class = "col-md-6"></div>
                                                            </div>
                                                            <div class = "row" style = "padding-top : 20px; padding-bottom : 10px;">
                                                                <div class = "col-md-1"></div>
                                                                <div class = "col-md-5">
                                                                    <input type="checkbox" class = "view_checklist icheckbox_minimal-blue" value = "SSS RESULT" disabled><b>SSS RESULT</b>
                                                                </div>
                                                                <div class = "col-md-6"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class = "col-md-1"></div>
                                                </div>
                                                <div class = "row">
                                                    <div class = "col-md-1"></div>
                                                    <div class = "col-md-10">
                                                        <div class = "box box-danger">
                                                            <center><h4 style = "font-family: Georgia,serif;">Accountabilities/Equipments</h4></center>
                                                            <div class = "row" style = "padding-top : 30px; padding-bottom : 10px;">
                                                                <div class = "col-md-1"></div>
                                                                <div class = "col-md-5">
                                                                    <div class = "row" style = "padding-top: 20px;">
                                                                        <div class = "col-md-12">
                                                                            <input type="checkbox" class = "view_checklist icheckbox_minimal-blue" value = "ATM" disabled><b>ATM</b>
                                                                        </div>
                                                                    </div>
                                                                    <div class = "row" style = "padding-top: 20px;">
                                                                        <div class = "col-md-12">
                                                                            <input type="checkbox" class = "view_checklist icheckbox_minimal-blue" value = "ID" disabled><b>ID</b>
                                                                        </div>
                                                                    </div>
                                                                    <div class = "row" style = "padding-top: 20px;">
                                                                        <div class = "col-md-12">
                                                                            <input type="checkbox" class = "view_checklist icheckbox_minimal-blue" value = "GMAIL & PASSWORD/CCSI EMAIL" disabled><b>GMAIL & PASSWORD/CCSI EMAIL</b>
                                                                        </div>
                                                                    </div>
                                                                    <div class = "row" style = "padding-top: 20px;">
                                                                        <div class = "col-md-12">
                                                                            <input type="checkbox" class = "view_checklist icheckbox_minimal-blue" value = "PHONE/IP PHONE" disabled><b>PHONE/IP PHONE</b>
                                                                        </div>
                                                                    </div>
                                                                    <div class = "row" style = "padding-top: 20px;">
                                                                        <div class = "col-md-12">
                                                                            <input type="checkbox" class = "view_checklist icheckbox_minimal-blue" value = "NUMBER" disabled><b>NUMBER</b>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class = "col-md-1"></div>
                                                                <div class = "col-md-5">
                                                                    <div id = "officeChecklistView">
                                                                        <div class = "row" style = "padding-top: 20px;">
                                                                            <div class = "col-md-12">
                                                                                <input type="checkbox" class = "view_checklist icheckbox_minimal-blue" value = "COMPUTER" disabled><b>COMPUTER</b>
                                                                            </div>
                                                                        </div>
                                                                        <div class = "row" style = "padding-top: 20px;">
                                                                            <div class = "col-md-12">
                                                                                <input type="checkbox" class = "view_checklist icheckbox_minimal-blue" value = "FB(IF NEEDED)" disabled><b>FB(IF NEEDED)</b>
                                                                            </div>
                                                                        </div>
                                                                        <div class = "row" style = "padding-top: 20px;">
                                                                            <div class = "col-md-12">
                                                                                <input type="checkbox" class = "view_checklist icheckbox_minimal-blue" value = "BIOMETRICS" disabled><b>BIOMETRICS</b>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div id = "ciChecklistView">
                                                                        <div class = "row" style = "padding-top: 20px;">
                                                                            <div class = "col-md-12">
                                                                                <input type="checkbox" class = "view_checklist icheckbox_minimal-blue" value = "INSURANCE" disabled><b>INSURANCE</b>
                                                                            </div>
                                                                        </div>
                                                                        <div class = "row" style = "padding-top: 20px;">
                                                                            <div class = "col-md-12">
                                                                                <input type="checkbox" class = "view_checklist icheckbox_minimal-blue" value = "SHELLCARD" disabled><b>SHELLCARD</b>
                                                                            </div>
                                                                        </div>
                                                                        <div class = "row" style = "padding-top: 20px;">
                                                                            <div class = "col-md-12">
                                                                                <input type="checkbox" class = "view_checklist icheckbox_minimal-blue" value = "UNIFORM" disabled><b>UNIFORM</b>
                                                                            </div>
                                                                        </div>
                                                                        <div class = "row" style = "padding-top: 20px;">
                                                                            <div class = "col-md-12">
                                                                                <input type="checkbox" class = "view_checklist icheckbox_minimal-blue" value = "AUTHORIZATION" disabled><b>AUTHORIZATION</b>
                                                                            </div>
                                                                        </div>
                                                                        <div class = "row" style = "padding-top: 20px;">
                                                                            <div class = "col-md-12">
                                                                                <input type="checkbox" class = "view_checklist icheckbox_minimal-blue" value = "INTRODUCTION LETTER" disabled><b>INTRODUCTION LETTER</b>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class = "col-md-1"></div>
                                                </div>
                                            </div>

                                            <div class="tab-pane" id="tab_View4">
                                                <div class = "row" style = "padding-top: 10px;">
                                                    <div class = "col-md-12">
                                                        <div class = "box box-danger">
                                                            <h4 style = "text-align: center; font-weight: bold; font-family: Georgia,serif; padding-top: 15px;">ID, Uniform , Insurance and ATM</h4>
                                                            <div class = "row" style = "padding-top : 20px;">
                                                                <div class = "col-md-5">
                                                                    <h5 style = "font-weight: bold ; ">ID Status:</h5>
                                                                    <h5 id = "emp_id_stat_view"></h5>
                                                                </div>
                                                                <div class = "col-md-2"></div>
                                                                <div class = "col-md-5">
                                                                    <h5 style = "font-weight: bold">ID No. : </h5>
                                                                    <h5 id = "emp_id_no_view"></h5>
                                                                </div>
                                                            </div>
                                                            <div class = "row">
                                                                <div class = "col-md-5">
                                                                    <h5 style = "font-weight: bold">Uniform: </h5>
                                                                    <h5 id = "emp_uni_view"></h5>
                                                                </div>
                                                                <div class = "col-md-2"></div>
                                                                <div class = "col-md-5">
                                                                    <h5 style = "font-weight: bold">Bank Name:</h5>
                                                                    <h5 id  = "emp_bank_name_view"></h5>
                                                                </div>
                                                            </div>
                                                            <div class = "row">
                                                                <div class = "col-md-5">
                                                                    <h5 style = "font-weight: bold">FB/Messenger: </h5>
                                                                    <h5 id = "emp_fb_view_me"></h5>
                                                                </div>
                                                                <div class = "col-md-2"></div>
                                                                <div class = "col-md-5">
                                                                    <h5 style = "font-weight: bold">Computer:</h5>
                                                                    <h5 id = "emp_computer_view_me"></h5>
                                                                </div>
                                                            </div>
                                                            <div class = "row">
                                                                <div class = "col-md-5">
                                                                    <h5 style = "font-weight: bold">Health Card Info: </h5>
                                                                    <h5 id = "emp_health_card_view"></h5>
                                                                </div>
                                                                <div class = "col-md-2"></div>
                                                                <div class = "col-md-5">
                                                                    <h5 style = "font-weight: bold">Accident Insurance:</h5>
                                                                    <h5 id = "emp_accident_view"></h5>
                                                                </div>
                                                            </div>
                                                            <h4 style = "text-align: center; font-weight: bold; font-family: Georgia,serif;">Company Phone</h4>
                                                            <div class = "row" style = "padding-top : 20px;">
                                                                <div class = "col-md-5">
                                                                    <h5 style = "font-weight: bold">Phone Number: </h5>
                                                                    <h5 id = "emp_phone_number_view"></h5>
                                                                </div>
                                                                <div class = "col-md-2"></div>
                                                                <div class = "col-md-5">
                                                                    <h5 style = "font-weight: bold">Unit Price:</h5>
                                                                    <h5 id = "emp_unit_price_view"></h5>
                                                                </div>
                                                            </div>
                                                            <div class = "row">
                                                                <div class = "col-md-12">
                                                                    <h5 style = "font-weight: bold">Phone Description:</h5>
                                                                    <h5 id ="emp_phone_desc_view"></h5>
                                                                </div>
                                                            </div>

                                                            <h4 style = "text-align: center; font-weight: bold; font-family: Georgia,serif;">Gmail/OIMS Access</h4>

                                                            <div class = "row" style = "padding-top : 20px;">
                                                                <div class = "col-md-5">
                                                                    <h5 style = "font-weight: bold">OIMS Username/Email Address:</h5>
                                                                    <h5 id = "emp_oims_view"></h5>
                                                                </div>
                                                                <div class = "col-md-2"></div>
                                                                <div class = "col-md-5">
                                                                    <h5 style = "font-weight: bold">Corporate Gmail Address:</h5>
                                                                    <h5 id = "emp_gmail_view"></h5>
                                                                </div>
                                                            </div>
                                                            <div class = "row">
                                                                <div class = "col-md-12">
                                                                    <h5 style = "font-weight: bold">Gmail Password:</h5>
                                                                    <h5 id ="emp_gmail_password_view_me"></h5>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <span id = "down"></span>
                            </div>

                            <div class="col-md-6">
                                <div class="box box-info">
                                    <div class="nav-tabs-custom" style = "padding-top : 20px;">
                                        <ul class="nav nav-tabs">
                                            <li class="active" id = "tabTest4"><a id="tab4" href="#tab_Show4" data-toggle="tab" class = "human_resources_tab_show_class">Assigned Item/s</a></li>
                                            <li  id = "tabTest1"><a id="tab1" href="#tab_Show1" data-toggle="tab" class = "human_resources_tab_show_class">Work History</a></li>
                                            <li id = "tabTest2"><a id="tab2" href="#tab_Show2" data-toggle="tab" class = "human_resources_tab_show_class">Educational Background</a></li>
                                            <li id = "tabTest3"><a id="tab3" href="#tab_Show3" data-toggle="tab" class = "human_resources_tab_show_class">Character Reference</a></li>

                                        </ul>
                                        <div class = "tab-content">
                                            <div class="tab-pane active" id="tab_Show4">
                                                <div class = "box-body">
                                                    <div class="col-md-12">
                                                        <table class="tableendorse display table-hover table-condensed" id="human-resource-assigned-items-view" width="100%">
                                                            <thead>
                                                            <tr>
                                                                <th>ID</th>
                                                                <th>Category</th>
                                                                <th>Brand/Model Name</th>
                                                                <th>Color</th>
                                                                <th>Remarks</th>
                                                            </tr>
                                                            </thead>
                                                            <tfoot>
                                                            <tr>
                                                                <th>ID</th>
                                                                <th>Category</th>
                                                                <th>Brand/Model Name</th>
                                                                <th>Color</th>
                                                                <th>Remarks</th>
                                                            </tr>
                                                            </tfoot>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane" id="tab_Show1">
                                                <div class = "box-body">
                                                    <div class="col-md-12">
                                                        <table class="tableendorse display table-hover table-condensed" id="human-resources-show-exp" width="100%">
                                                            <thead>
                                                            <tr>
                                                                <th>Name</th>
                                                                <th>Address</th>
                                                                <th>Position</th>
                                                                <th>Start Date</th>
                                                                <th>End Date</th>
                                                                <th>Contact</th>
                                                            </tr>
                                                            </thead>
                                                            <tfoot>
                                                            <tr>
                                                                <th>Name</th>
                                                                <th>Address</th>
                                                                <th>Position</th>
                                                                <th>Start Date</th>
                                                                <th>End Date</th>
                                                                <th>Contact</th>
                                                            </tr>
                                                            </tfoot>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane" id="tab_Show2">
                                                <div class = "box-body">
                                                    <div class="col-md-12">
                                                        <table class="tableendorse display table-hover table-condensed" id="human-resource-show-educ" width="100%">
                                                            <thead>
                                                            <tr>
                                                                <th>Level</th>
                                                                <th>School Name</th>
                                                                <th>School Address</th>
                                                                <th>Year Graduated</th>
                                                                <th>Course</th>
                                                            </tr>
                                                            </thead>
                                                            <tfoot>
                                                            <tr>
                                                                <th>Level</th>
                                                                <th>School Name</th>
                                                                <th>School Address</th>
                                                                <th>Year Graduated</th>
                                                                <th>Course</th>
                                                            </tr>
                                                            </tfoot>
                                                        </table>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="tab-pane" id="tab_Show3">
                                                <div class = "box-body">
                                                    <div class="col-md-12">
                                                        <table id="human-resources-show-ref" class="tableendorse display table-hover table-condensed" width="100%">
                                                            <thead>
                                                            <tr>
                                                                <th>Employee Name</th>
                                                                <th>Position</th>
                                                                <th>Company Name</th>
                                                                <th>Contact Number</th>
                                                            </tr>
                                                            </thead>
                                                            <tfoot>
                                                            <tr>
                                                                <th>Employee Name</th>
                                                                <th>Position</th>
                                                                <th>Company name</th>
                                                                <th>Contact Number</th>
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
                <div class="modal-footer" >
                    <button type="button" id = "btnCloseEmp" class="btn btn-warning pull-right" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-inventory-logs">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <center><h4 class="modal-title" >Item Logs</h4></center>
                </div>
                <div class="modal-body">
                    <span id="invent-logs"></span>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-loading">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box">
                                <div class="box-body">
                                    <div class="col-md-4"></div>
                                    <div class="col-md-4">
                                        <center><h3>LOADING PLEASE WAIT</h3></center>
                                        <img src="dist/img/loading.gif" alt="" width="100%">
                                    </div>
                                    <div class="col-md-4"></div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <div class="modal fade" id="modal-add-item-selection">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    
                </div>
                <div class="modal-body">
                    <div class="panel panel-success">
                        <div class="panel-heading"><center><h4>Add Item</h4></center></div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <select name="" id="item-spec-to-add" class="form-control validation-to-add">
                                            <option value=""><--- SELECT ITEM SPECIFICATION --></option>
                                            <option value="Employee Equipment" name="emp">Employee Equipment</option>
                                            <option value="Branch Asset" name="branch">Branch Asset</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <input type="text" class="form-control validation-to-add" placeholder ="ITEM NAME" id="item-name-to-add">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <button class="btn btn-success" id="add-this-item-to-table"><i class="glyphicon glyphicon-plus"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="panel-heading"><center><h4>Delete Item</h4></center></div>

                        <div class="panel-body">
                            <table class="table-condensed table-hover" id="remove-item-table" width="100%">
                                <thead>
                                    <tr>
                                        <th>Item Name</th>
                                        <th>Item Type</th>
                                        <th>Datetime Added</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    
        
            
                
                    
                        
                            
                                
                                    
                                        
                                
                                
                                    
                                    
                                
                                
                                    
                                    
                                
                                
                                    
                                    
                                
                                
                                    
                                    
                                
                                
                                    
                                    
                                
                                
                                    
                                    
                                
                                
                                    
                                    
                                
                                
                                    
                                    
                                
                            
                            
                                
                                
                                    
                                    
                                    
                                    
                                
                                
                                    
                                    
                                    
                                    
                                            
                                            
                                            
                                    
                                
                                
                            
                        
                    
                    
                        
                            
                                
                                    
                                
                                
                                    
                                
                                
                                    
                                
                                
                                    
                                
                            
                        
                        
                        
                            
                                
                                    
                                    
                                
                                
                                    
                                    
                                
                                
                                    
                                    
                                
                            

                            
                                
                                    
                                    
                                
                            
                        
                    
                    
                        
                            
                                
                                    
                                
                                
                                    
                                
                                
                                    
                                
                                
                                    
                                
                            
                        
                    
                
                
                    
                    
                
            
        
    



    <div class="modal fade" id="modal-ar_form">
        <div class="modal-dialog" style="width: 70%;">
            <div class="modal-content">
                <div class="modal-body">
                            <div class="box">
                                <div class="box-body">

                                    <div class="nav-tabs-custom">
                                        <ul class="nav nav-tabs">

                                            <li class="active"><a href="#ar_tab_receipt" data-toggle="tab">Acknowledgement Receipt</a></li>
                                            <li><a href="#ar_tab_monit" class="ar_tab_monit1" data-toggle="tab">Acknowledgement Monitoring</a></li>

                                        </ul>
                                        <div class="tab-content">

                                            <div class="tab-pane active" id="ar_tab_receipt">
                                                <div class="row">
                                                    <div class="col-md-2"></div>
                                                    <div class="col-md-9">
                                                        <table class="table-condensed centerContent" style = "overflow-x:auto; border-collapse:collapse; table-layout:fixed; width : 100%" id= "tbl_AcknowledgeReceipt">
                                                            <tr>
                                                                <th colspan="4" style = "background-color: darkgrey; color : black; "><h4 style= "font-weight:bold;">ACKNOWLEDGEMENT RECEIPT</h4>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2" style="font-weight:bold;"><span class = "pull-left toLeftTop">Name of employee :<small style = "color:red">(required field)</small></span> </td>
                                                                <td colspan = "2"><input type="text" class = "form-control ar_inputs ar_doble" id="ar_name_emp"></td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2" style="font-weight:bold;"><span class = "pull-left toLeftTop">Office Location-Department-Position :<small style = "color:red">(required field)</small></span> </td>
                                                                <td colspan = "2"><input type="text" class = "form-control ar_inputs ar_doble" id="ar_loc_dept"></td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2" style="font-weight:bold;"><span class = "pull-left toLeftTop">Contact Number and Email Address :<small style = "color:red">(required field)</small></span> </td>
                                                                <td colspan = "2"><input type="text" class = "form-control ar_inputs ar_doble" id="ar_cont_email" disabled></td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2" style="font-weight:bold;"><span class = "pull-left toLeftTop">LBC Branch :<small style = "color:red">(required field)</small></span> </td>
                                                                <td colspan = "2"><input type="text" class = "form-control ar_inputs ar_doble" id="ar_lbc_branch"></td>
                                                            </tr>
                                                        </table>

                                                        <table class="table-condensed centerContent" style = "overflow-x:auto; border-collapse:collapse; table-layout:fixed; width : 100%" id = "brandItemsTable3">
                                                            <tbody id = "addBrandTable2">
                                                            <tr name="0">
                                                                <th colspan="1" style = "background-color: darkgrey; color : black; font-weight:bold;padding-bottom: 15px;">Quantity: <small style = "color:red">(required field)</small></th>
                                                                <th colspan="1" style = "background-color: darkgrey; color : black; font-weight:bold; padding-bottom: 15px;">Brand - Item - Description: <small style = "color:red">(required field)</small></th>
                                                                <th colspan="1" style = "background-color: darkgrey; color : black; font-weight:bold; "> <span style = " padding-top : 10px;">Warranty Period: <small style = "color:red">(required field)</small></span>
                                                                    <span class = "pull-right"><button class = "btn btn-sm btn-success btnToAddBrand2" ><i class = "fa fa-fw fa-plus"></i></button></span></th>
                                                            </tr>
                                                            <tr id = "removeBrand2-0">
                                                                <td colspan="1" ><input type="number" class="form-control ToLoopAcno ar_inputs ar_doble" href="0" name="item_quantity" ></td>
                                                                <td colspan="1" ><textarea class = "form-control ToLoopAcno ar_inputs ar_doble" rows ="2" href="0" name="brand_desc" ></textarea></td>
                                                                <td colspan="1" ><div class="input-group input-group-sm"><input type="text" class="form-control ToLoopAcno ar_inputs ar_doble" href="0" name="warranty_period">
                                                                        <span class="input-group-btn">
                                                <button type="button" class="btn btn-danger btn-sm btnRemoveAr" name = "0">
                                                <i class = "fa fa-fw fa-minus"></i></button></span></div>
                                                                </td>
                                                            </tr>
                                                            </tbody>
                                                        </table>

                                                        <table class="table-condensed" style = "overflow-x:auto; border-collapse:collapse; table-layout:fixed; width : 100% ;">
                                                            <tr>
                                                                <th colspan = "5" style = "padding-left : 10px; padding-right : 20px;">
                                                                    <br>
                                                                    <h5 style = "font-style : italic; text-align: justify; font-size: medium">I hereby acknowledge that I have received the followeing company properly. I agree to keep the property in working condition, and to notify management  should properly malfunction in any way or should
                                                                        the property be lost or stolen. Further, I agree to return this property at the end of my employment. When I no longer need one or more of the items. I will return it/them to immediately to my supervisor</h5>
                                                                    <h5 style = "font-style : italic; text-align: justify; font-size: medium">No employee is allowed to exchange and bargain all company issued equipment without the knowledge or approval of the management. furthermore, all issued equipment, email address, passwords and cell phone number
                                                                        must be available to the company at all times.</h5>
                                                                    <h5 style = "font-style : italic; text-align: justify; font-size: medium">In case of damage/s or loss/es of the said item/s above, the receiver shall be held liable or accountable for the negligence that may occur. Thereof, the receiver immediate written
                                                                        notice to their supervisor/s.</h5>
                                                                    <br>

                                                                    <div class="row" style = "padding-top : 40px">
                                                                        <div class= "col-md-5">
                                                                            <span class="pull-right" style = "width: 210px; border-bottom-style :solid"></span>
                                                                        </div>
                                                                        <div class= "col-md-2"></div>
                                                                        <div class= "col-md-5">
                                                                            <span class="pull-left" style = "width: 210px; border-bottom-style :solid"></span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row" style = "">
                                                                        <div class="col-md-1"></div>
                                                                        <div class="col-md-5">
                                                                            <span class="" style = "text-align: center">Employee Signature</span>
                                                                        </div>
                                                                        <div class="col-md-5">
                                                                            <span class="" style = "text-align: center">Date Received</span>
                                                                        </div>
                                                                    </div>
                                                                </th>
                                                            </tr>
                                                        </table>

                                                        <table class="table-condensed centerContent" style = "overflow-x:auto; border-collapse:collapse; table-layout:fixed; width : 100%; margin-top : 30px;" id= "admin_deptAttach">
                                                            <tr>
                                                                <th colspan="1" style = "background-color: darkgrey; color : black;font-size: larger ">For Administration Department - Attach and secure the following documents: </th>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="1" ><span class="toLeftTop2 pull-left"><input type="checkbox" class="acknowledge_approve ar_checkbox"  id="approve_requisite" name="0"> <b>Approved Requisition</b></span></td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="1" ><span class="toLeftTop2 pull-left"><input type="checkbox" class="acknowledge_approve ar_checkbox" id="approve_suppliercom" name="1"> <b>Approved Supplier(Comparison and Recommendation)</b></span></td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="1" ><span class="toLeftTop2 pull-left"><input type="checkbox" class="acknowledge_approve ar_checkbox" id="approve_purchaseOr" name="2"> <b>Approved Purchase Order with Signed Proposal or Agreement</b> </span></td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="1" ><span class="toLeftTop2 pull-left"><input type="checkbox" class="acknowledge_approve ar_checkbox" id="warrant_cr" name="3"> <b>Warranty Card or Receipts</b> </span></td>
                                                            </tr>
                                                        </table>

                                                        <table class="table-condensed hideThisTable" style = "table-layout:fixed; width : 100%; margin-top : 20px;">
                                                            <tr>
                                                                <td style="border: none ;">
                                                                    <button class="btn btn-success pull-right" id="btnArToPDFSendToEmail">
                                                                        Submit
                                                                    </button>
                                                                    <button class="btn btn-md btn-info pull-left" id="btn_ar_clear">Clear Fields</button>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                    <div class="col-md-2"></div>
                                                </div>
                                            </div>


                                            <div class="tab-pane" id="ar_tab_monit">

                                                <div class = "row" style = "padding-top : 30px;">
                                                    <div class="col-md-3">

                                                        <table class="table-condensed table-hover ar_receipt_monitoring" width="100%" id="ar-monitoring-table">
                                                            <thead>
                                                            <tr>
                                                                <th>ID</th>
                                                                <th>Acknowledgement Receipt</th>
                                                            </tr>
                                                            </thead>
                                                        </table>

                                                    </div>
                                                    <div class="col-md-9">
                                                        <div class="box box-primary">
                                                            <div class="box-header with-border">
                                                                <h3 class="box-title">Acknowledgement Form</h3>
                                                            </div>
                                                            <div class="box-body">
                                                                <div class="row" style="padding-top: 15px;">
                                                                    <div class="col-md-11">
                                                                        
                                                                        <table class="table-condensed centerContent" style = "overflow-x:auto; border-collapse:collapse; table-layout:fixed; width : 100%" id="acknowledge-Infomonit">
                                                                            <tr>
                                                                                <th colspan="4" style = "background-color: darkgrey; color : black; font-size: larger "><h4 style= "font-weight:bold;">ACKNOWLEDGEMENT RECEIPT</h4>
                                                                            </tr>
                                                                            <tr>
                                                                                <td colspan="2" style="font-weight:bold;"><span class = "pull-left toLeftTop">Name of employee :</span> </td>
                                                                                <td colspan = "2"><input type="text" class = "form-control" id="ar_monit_nameEmp" disabled></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td colspan="2" style="font-weight:bold;"><span class = "pull-left toLeftTop">Office Location-Department-Position :</span> </td>
                                                                                <td colspan = "2"><input type="text" class = "form-control" id="ar_monit_ofc_loc_dept" disabled></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td colspan="2" style="font-weight:bold;"><span class = "pull-left toLeftTop">Contact Number and Email Address :</span> </td>
                                                                                <td colspan = "2"><input type="text" class = "form-control" id="ar_monit_cont_email" disabled></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td colspan="2" style="font-weight:bold;"><span class = "pull-left toLeftTop">LBC Branch :</span> </td>
                                                                                <td colspan = "2"><input type="text" class = "form-control" id="ar_monit_lbc" disabled></td>
                                                                            </tr>
                                                                        </table>

                                                                        <table class="table-condensed centerContent" style = "overflow-x:auto; border-collapse:collapse; table-layout:fixed; width : 100%" id="ar_monitoring_brandItems" >
                                                                            <tbody>
                                                                            <tr name="0">
                                                                                <th colspan="1" style = "background-color: darkgrey; color : black; font-weight:bold; padding-bottom: 15px; text-align: center "><span style = "padding-top : 10px">Quantity</span>
                                                                                <th colspan="1" style = "background-color: darkgrey; color : black; font-weight:bold; padding-bottom: 15px; text-align: center "><span style = "padding-top : 10px">Brand - Item - Description</span>
                                                                                <th colspan="1" style = "background-color: darkgrey; color : black; font-weight:bold; padding-bottom: 15px;text-align: center "> <span style = "padding-top : 10px">Warranty Period</span>
                                                                            </tr>
                                                                            </tbody>
                                                                        </table>

                                                                        <table class="table-condensed" style = "overflow-x:auto; border-collapse:collapse; table-layout:fixed; width : 100% ;">
                                                                            <tr>
                                                                                <th colspan = "5" style = "padding-left : 10px; padding-right : 10px;">
                                                                                    <br>
                                                                                    <h5 style = "font-style : italic; text-align: justify;">I hereby acknowledge that I have received the followeing company properly. I agree to keep the property in working condition, and to notify management  should properly malfunction in any way or should
                                                                                        the property be lost or stolen. Further, I agree to return this property at the end of my employment. When I no longer need one or more of the items. I will return it/them to immediately to my supervisor</h5>
                                                                                    <h5 style = "font-style : italic; text-align: justify;">No employee is allowed to exchange and bargain all company issued equipment without the knowledge or approval of the management. furthermore, all issued equipment, email address, passwords and cell phone number
                                                                                        must be available to the company at all times.</h5>
                                                                                    <h5 style = "font-style : italic; text-align: justify;">In case of damage/s or loss/es of the said item/s above, the receiver shall be held liable or accountable for the negligence that may occur. Thereof, the receiver immediate written
                                                                                        notice to their supervisor/s.</h5>
                                                                                    <br>

                                                                                    <div class="row" style = " padding-top : 20px">
                                                                                        <div class= "col-md-5">
                                                                                            <span class="pull-right" style = "width: 200px; border-bottom-style :solid"></span>
                                                                                        </div>
                                                                                        <div class= "col-md-2"></div>
                                                                                        <div class= "col-md-5">
                                                                                            <span class="pull-left" style = "width: 200px; border-bottom-style :solid"></span>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="row" style = "">
                                                                                        <div class="col-md-1"></div>
                                                                                        <div class="col-md-5">
                                                                                            <span class="" style = "text-align: center;">Employee Signature</span>
                                                                                        </div>
                                                                                        <div class="col-md-5">
                                                                                            <span class="" style = "text-align: center">Date Received</span>
                                                                                        </div>
                                                                                    </div>
                                                                                </th>
                                                                            </tr>
                                                                        </table>

                                                                        <table class="table-condensed centerContent" style = "overflow-x:auto; border-collapse:collapse; table-layout:fixed; width : 100%; margin-top : 30px;" id= "acknowledge-checker">
                                                                            <tr>
                                                                                <th colspan="1" style = "background-color: darkgrey; color : black;font-size: larger ">For Administration Department - Attach and secure the following documents: </th>
                                                                            </tr>
                                                                            <tr>
                                                                                <td colspan="1" ><span class="toLeftTop2 pull-left"><input type="checkbox" class="Check_arView" name="0"> <b>Approved Requisition</b></span></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td colspan="1" ><span class="toLeftTop2 pull-left"><input type="checkbox" class="Check_arView" name="1"> <b>Approved Supplier(Comparison and Recommendation)</b></span></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td colspan="1" ><span class="toLeftTop2 pull-left"><input type="checkbox" class="Check_arView" name="2"> <b>Approved Purchase Order with Signed Proposal or Agreement</b> </span></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td colspan="1" ><span class="toLeftTop2 pull-left"><input type="checkbox" class="Check_arView" name="3"> <b>Warranty Card or Receipts</b> </span></td>
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

                                    <div class="overlay" hidden id="overlay_add_ar_send">
                                        <i class="fa fa-circle-o-notch fa-spin"></i>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    



    
        
            
                
                
                
                
                
                
                    
                        
                            
                                
                                    
                                
                                
                                    
                                    
                                
                                
                                    
                                    
                                
                                
                                    
                                    
                                
                                
                                    
                                    
                                
                                
                                    
                                    
                                
                                
                                    
                                    
                                
                                
                                    
                                
                                
                                    
                                    
                                
                                
                                    
                                
                                
                                    
                                
                                
                                    
                                    
                                
                                
                                    
                                    
                                
                                
                                    
                                    
                                
                                
                                    
                                    
                                
                                
                                    
                                    
                                
                                
                                    
                                    
                                
                                
                                    
                                    
                                
                                
                                    
                                    
                                
                                
                                    
                                    
                                
                                
                                    
                                    
                                
                                
                                    
                                    
                                
                            
                            
                                
                                
                            
                            
                                
                                    
                                    
                                    
                                    
                                
                            
                        
                    

                    
                        
                            
                        
                    


                
                
                    
                    
                    
                
            
            
        
        
    

    <div class="modal fade" id="modal_view_denial_requi_rem">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Information</h4>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-md-6">
                            <label for="">Date and Time: </label>
                            <input type="text"  class ="form-control" id = "view_admin_date_rem_requi" disabled>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <label for="">Remarks: </label>
                            <textarea class="form-control" id = "view_admin_denial_remarks" rows ="3" disabled></textarea>f
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

    <div class="modal modal-info fade" id="modal-loading-accredited-supplier">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Sending...</h4>
                </div>
                <div class="modal-body">
                    <p style="text-align: center">Please wait while the submitting the record.  <img src="<?php echo e(asset('dist/img/loading.gif')); ?>" style="width: 5%;"></p>
                    <div class = "row" style = "padding-top : 10px;">
                        <div class = "col-md-2"></div>
                        <div class = "col-md-8">
                            <span id="ulPercentage_acc_supp">--</span>
                            <div id="progressbar_acc_supp" hidden></div>
                        </div>
                        <div class = "col-md-2"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline pull-right" data-dismiss="modal" id="btnModalCloseSending">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal modal-success fade" id="modal-success-accredited">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Success!</h4>
                </div>
                <div class="modal-body">
                    <p style="text-align: center">Successfully Submitted Recordt</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline pull-right" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-approve-requi-capex-opex">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" style = "text-align: center">Approval</h4>
                </div>
                <div class="modal-body">
                    <div class = "row" >
                        <div class="col-md-12">
                            <div class = "box box-primary">
                                <div class = "row" style = "padding-top : 20px;">
                                    <div class="col-md-5">
                                        <label>Type of Request</label>
                                        <select id="torRequi" class="form-control">
                                            <option value="Recurring requests">Recurring requests</option>
                                            <option value="New requests">New requests</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2"></div>
                                    <div class="col-md-5">
                                        <label>Categorization <small style = "color:red">*required field</small></label>
                                        <select id="categRequi" class="form-control">
                                            <option value="-">-</option>
                                            <option value="OPEX">OPEX</option>
                                            <option value="CAPEX">CAPEX</option>
                                        </select>
                                    </div>
                                </div>
                                <div class = "row" style = "padding-top : 10px;" id = "showHideRequiring" hidden>
                                    <div class="col-md-5">
                                        <label for="">Requiring Bills</label>
                                        <select id="requiringBillsRequi" class="form-control">
                                            <option value="Utilities">Utilities</option>
                                            <option value="Office Supplies">Office Supplies</option>
                                            <option value="Maintenance">Maintenance</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                    </div>
                                    <div class="col-md-5">
                                        <span id = "showIfUtil" >
                                            <label for="">Type of Utilities</label>
                                            <select id="typeOfUtilRequi" class="form-control othersRequi">
                                                <option value="Electric Bills">Electric Bills</option>
                                                <option value="Water Bills">Water Bills</option>
                                                <option value="CUSA">CUSA</option>
                                                <option value="Office Supplies">Office Supplies</option>
                                                <option value="Assoc. Dues">Assoc. Dues</option>
                                                <option value="Telecoms/Internet">Telecoms/Internet</option>
                                                <option value="Toiletries">Toiletries</option>
                                                <option value="First Aid Kit">First Aid Kit</option>
                                                <option value="Distilled Water">Distilled Water</option>
                                                <option value="Fire Ext.">Fire Ext.</option>
                                                <option value="Others">Others</option>
                                            </select>
                                        </span>
                                        <span id = "showIfOffice" hidden>
                                            <label for="">Type of Office Supplier</label>
                                            <select id="typeOfOfficeSup" class="form-control othersRequi">
                                                <option value="Ink">Ink</option>
                                                <option value="Toner">Toner</option>
                                                <option value="Riso">Riso</option>
                                                <option value="Drum">Drum</option>
                                                <option value="Bond Paper">Bond Paper</option>
                                                 <option value="Others">Others</option>
                                            </select>
                                        </span>
                                        <span id = "showIfMaintenance" hidden>
                                            <label for="">Type of Maintenance</label>
                                            <select id="typeOfMainten" class="form-control othersRequi">
                                                <option value="Aircon Cleaning">Aircon Cleaning</option>
                                                <option value="Carpet Cleaning">Carpet Cleaning</option>
                                                <option value="Pest Control">Pest Control</option>
                                                <option value="Others">Others</option>
                                            </select>
                                        </span>
                                    </div>
                                </div>
                                <div class = "row" style = "padding-top : 10px;" id = "showHideCapex" hidden>
                                    <div class="col-md-5">
                                        <label for="">Type</label>
                                        <select id="typeOfCapex" class="form-control">
                                            <option value="Equipment">Equipment</option>
                                            <option value="Event">Event</option>
                                            <option value="Event Optional">Event Optional</option>
                                            <option value="Office Space">Office Space</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2"></div>
                                    <div class="col-md-5">
                                         <span id = "showIfEquiqmentCapex" >
                                            <label for="">Type of Equipment</label>
                                            <select id="typeOfEquipCapex" class="form-control othersRequi">
                                                <option value="Computer">Computer</option>
                                                <option value="IP Phone">IP Phone</option>
                                                <option value="Mobile Phone">Pest Control</option>
                                                <option value="Others">Others</option>
                                            </select>
                                        </span>
                                        <span id = "showIfEventCapex" hidden>
                                            <label for="">Type of Event</label>
                                            <select id="typeOfEventCapex" class="form-control othersRequi">
                                                <option value="Summer Outing">Summer Outing</option>
                                                <option value="Anniversary">Anniversary</option>
                                                <option value="Christmas Party">Christmas Party</option>
                                                <option value="Others">Others</option>
                                            </select>
                                        </span>
                                        <span id = "showIfEventOptionalCapex" hidden>
                                            <label for="">Type of Event Optional</label>
                                            <select id="typeOfEventOptionalCapex" class="form-control othersRequi">
                                                <option value="Summer Outing">Summer Outing</option>
                                                <option value="Anniversary">Anniversary</option>
                                                <option value="Christmas Party">Christmas Party</option>
                                                <option value="Others">Others</option>
                                            </select>
                                        </span>
                                    </div>
                                </div>
                                <div class = "row" style = "padding-top : 10px;" id = "showHideOthersRequi" hidden>
                                    <div class ="col-md-5"></div>
                                    <div class ="col-md-2"></div>
                                    <div class ="col-md-5">
                                        <label for="">Please Indicate <small style = "color:red">*required field</small></label>
                                        <input type="text" class = "form-control" id="othersInputRequi">
                                    </div>
                                </div>
                                <div class = "row" style = "padding-top : 10px;" id = "showHideRemarksRequi" >
                                    <div class = "col-md-12">
                                        <label for="">Remarks <small style = "color:orange">*optional field</small></label>
                                        <textarea id="remarksRequi" rows="5" class="form-control" placeholder="Please indicate remarks here......"></textarea>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary pull-right" id = "approveNowRequisition">Submit</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <div class="modal modal-success fade" id="modal-success-po">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Success!</h4>
                </div>
                <div class="modal-body">
                    <p style="text-align: center">Successfully created P.O.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline pull-right" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal_view_approver_rem_requi_new">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Information</h4>
                </div>
                <div class="modal-body">
                    <div class = "row" >
                        <div class="col-md-12">
                            <div class = "box box-primary">
                                <div class="row" style = "padding-top :20px;">
                                    <div class="col-md-1"></div>
                                    <div class="col-md-10">
                                        <label for="">Remarks: </label>
                                        <textarea class="form-control" id = "view_admin_approve_requi_remarks" rows ="3" disabled></textarea>
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

    <div class="modal fade" id="modal_pass_to_manage_supplier">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 style = "text-align : center">Information</h4>
                </div>
                <div class="modal-body">
                    <div class = "row" >
                        <div class="col-md-12">
                            <div class = "box box-primary">

                                <div class="row" style = "padding-top :20px;">
                                    
                                    <div class="col-md-12">
                                        <table class="table-condensed" style = "overflow-x:auto; border-collapse:collapse; table-layout:fixed; width : 100%" id = "tableReviewSupplierToPass">

                                        </table>
                                    </div>
                                    
                                </div>
                                <div class="row" style = "padding-top :20px;">
                                    <div class="col-md-2"></div>
                                    <div class="col-md-6">
                                        <label for="">Category of Selected Suppliers: </label>
                                        <input type="text" class="form-control" id ="categoryToPass" placeholder="Insert category here....">
                                    </div>
                                    <div class="col-md-4"></div>
                                </div>
                                <div class="row" style = "padding-top :20px;">
                                    <div class="col-md-2"></div>
                                    <div class="col-md-8">
                                        <label for="">Equipments/Description: </label>
                                        <textarea class="form-control" id = "equipmentToBuy" rows ="2" placeholder="Insert description here..."></textarea>
                                    </div>
                                    <div class="col-md-2"></div>
                                </div>
                                <div class="row" style = "padding-top :20px;">
                                    <div class="col-md-2"></div>
                                    <div class="col-md-8">
                                        <label for="">Remarks: </label>
                                        <textarea class="form-control" id = "remarksComparison" rows ="4"  placeholder="Insert remarks here..."></textarea>
                                    </div>
                                    <div class="col-md-2"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success pull-right" id = "submitNowComparisan" >Send <span id = "loadingSpanSenRepSupManage" hidden><img src="<?php echo e(asset('dist/img/loading.gif')); ?>" style="width: 7%; margin-left : 10px;"></span></button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <div class="modal fade" id="modal_view_manage_info_app_sup">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 style = "text-align : center">Information</h4>
                </div>
                <div class="modal-body">
                    <div class = "row" >
                        <div class="col-md-12">
                            <div class = "box box-primary">

                                <div class="row" style = "padding-top :20px;">
                                    
                                    <div class="col-md-12">
                                        <table class="table-condensed" style = "overflow-x:auto; border-collapse:collapse; table-layout:fixed; width : 100%" id = "tableReviewSupplierManageView">

                                        </table>
                                    </div>
                                    
                                </div>
                                <div class="row" style = "padding-top :20px;">
                                    <div class="col-md-2"></div>
                                    <div class="col-md-6">
                                        <label for="">Category of Selected Suppliers: </label>
                                        <input type="text" class="form-control toClearViewManage" id ="categoryToView"  disabled>
                                    </div>
                                    <div class="col-md-4"></div>
                                </div>
                                <div class="row" style = "padding-top :20px;">
                                    <div class="col-md-2"></div>
                                    <div class="col-md-8">
                                        <label for="">Equipments/Description: </label>
                                        <textarea class="form-control toClearViewManage" id = "equipmentToBuyView" rows ="2" disabled></textarea>
                                    </div>
                                    <div class="col-md-2"></div>
                                </div>
                                <div class="row" style = "padding-top :20px;">
                                    <div class="col-md-2"></div>
                                    <div class="col-md-8">
                                        <label for="">Admin Remarks: </label>
                                        <textarea class="form-control toClearViewManage" id = "remarksComparisonView" rows ="4" disabled></textarea>
                                    </div>
                                    <div class="col-md-2"></div>
                                </div>
                                <div id="checkApprovedSupShowHide" hidden>
                                    <div class="row" style = "padding-top :20px;" >
                                        <div class="col-md-2"></div>
                                        <div class="col-md-6">
                                            <label for="">Approver name: </label>
                                            <input type="text" class="form-control toClearViewManage" id ="approverNameView"  disabled>
                                        </div>
                                        <div class="col-md-4"></div>
                                    </div>
                                    <div class="row" style = "padding-top :20px;" >
                                        <div class="col-md-2"></div>
                                        <div class="col-md-8">
                                            <label for="">Management Remarks: </label>
                                            <textarea class="form-control toClearViewManage" id = "remarksManageView" rows ="4"   disabled></textarea>
                                        </div>
                                        <div class="col-md-2"></div>
                                    </div>
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

<?php $__env->stopSection(); ?>

<?php $__env->startPush('leftsidebar'); ?>
    <?php echo $__env->make('admin_staff.admin-staff-leftsidebar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('jscript'); ?>
    <link rel="stylesheet" href="https://cdn.datatables.net/rowreorder/1.2.0/css/rowReorder.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/1.0.7/css/responsive.dataTables.min.css">
    <script src="<?php echo e(asset('jscript/admin-data-management.js?n='.$javs)); ?>"></script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>