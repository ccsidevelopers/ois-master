<div class = "content-wrapper">
    <!-- Content Header (Page header) -->
    <section class = "content-header">
        <h1>
            General Monitoring
        </h1>
    </section>

    <!-- Main content -->
    <section class = "content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-4">
                                    <div class="box">
                                        <div class="box-body">
                                            <div class="panel panel-info">
                                                <div class="panel-heading">
                                                    <h4>Item Information</h4>
                                                </div>
                                                <div class="panel-body">
                                                    <div class="form-group">
                                                        <label for="">Item Category :</label> <span id="item-cat" class="clearThis"></span>
                                                        <br><label for="">Employee ID :</label> <span id="emp-id" class="clearThis"></span>
                                                        <br><label for="">Employee Position :</label> <span id="emp-position" class="clearThis"></span>
                                                        <br><label for="">Employee Full Name :</label> <span id="emp-name" class="clearThis"></span>
                                                        <br><label for="">Brand :</label> <span id="item-brand" class="clearThis"></span>
                                                        <br><label for="">Branch :</label> <span id="eq-branch" class="clearThis"></span>
                                                        <br><label for="">Equipment Price :</label><span id="eq-price" class="clearThis"></span>
                                                        <br><label for="">Equipment Description :</label> <span id="eq-desc" class="clearThis"></span>
                                                        <br><label for="">Invoice Number:</label> <span id="eq-invoice" class="clearThis"></span>
                                                        <br><label for="">Current Status :</label> <span id="eq-cond" class="clearThis"></span>
                                                        <br><label for="">Item Status :</label> <span id="eq-status" class="clearThis"></span>
                                                        <br><label for="">Latest Photos :</label>
                                                        <div id="latest_pic" style="text-align: center; border: solid 1px" class="clearThis"></div>
                                                        <div class="form-group">
                                                            <label for="">Remarks :</label>
                                                            <textarea name="" id="eq-rem" rows="5" class="form-control clearThis" placeholder="Remarks ..." style="resize : none;" disabled></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div id="update_item_div" class="box-body" hidden>
                                            <div class="panel panel-info">
                                                <div class="panel-heading">
                                                        <h4>Update Item Status</h4>
                                                </div>
                                                <div class="panel-body">
                                                    <div class="form-group">
                                                        <label for="item-staus">Status : <small style="color: red">(Required field)</small></label>
                                                        <select name="" id="item-status" class="form-control updateVali">
                                                            <option value="">--- SELECT STATUS ---</option>
                                                            <option value="Good Condition">Good Condition</option>
                                                            <option value="With Defect">With Defect</option>
                                                            <option value="Defective">Defective</option>
                                                            <option value="Disposal">Disposal</option>
                                                            <option value="Missing">Missing</option>
                                                        </select>
                                                    </div>

                                                    <div class="col-md-3"></div>
                                                    <div class="col-md-6">
                                                        <div class="form-group" id="dispose_attachment" hidden >

                                                            <input type="file" class="disposeFilesTobeUploadBulk" multiple>
                                                            <button class="button_disposeadd btn btn-primary"><i class="glyphicon glyphicon-plus"></i></button>

                                                        </div>
                                                    </div>
                                                    <div class="col-md-3"></div>

                                                    <div class="form-group">
                                                        <label for="">Remarks<small style="color: red">(Required field)</small></label>
                                                        <textarea name="" id="update-item-remarks" rows="5" class="form-control updateVali" style="resize: none;" placeholder="Remarks Here..."></textarea>
                                                    </div>
                                                    <div class="form-group">
                                                        <button class="btn btn-success pull-right" id="item_update_status">Submit</button>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div id="item-overlay" class="overlay" hidden>
                                            <i class="fa fa-refresh fa-spin"></i>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-8">
                                    <div class="box">
                                        <div class="box-body">
                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <h4>Nationwide Assets Monitoring</h4>
                                                </div>
                                                <div class="box-body">
                                                    <form>
                                                        <label class="radio-inline">
                                                            <input type="radio" class="category_assets_class" name="catType" checked value="">All
                                                        </label>
                                                        <label class="radio-inline">
                                                            <input type="radio" class="category_assets_class" name="catType" value="Employee Equipment">Employee Equipments
                                                        </label>
                                                        <label class="radio-inline">
                                                            <input type="radio" class="category_assets_class" name="catType"  value="Branch Asset">Branch Assets
                                                        </label>
                                                    </form>
                                                </div>

                                                <div class="box-body">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="">Branch:</label>
                                                                <select name="" id="eq_mon_branch" class="form-control">
                                                                    <option value="">All</option>
                                                                    @foreach($archipelagos as $archi)
                                                                        <option value="{{ $archi->id}}">{{ $archi->archipelago_name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="">Item:</label>
                                                                <select name="" id="eq_mon_item" class="form-control">
                                                                    <option value="">All</option>
                                                                    @foreach($item_selection as $items)
                                                                        <option value="{{ $items->item_type}}" name="{{$items->type}}">{{ $items->item_type }}</option>
                                                                    @endforeach
                                                                    <option value="Others" name="Others">Others</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="nav-tabs-custom">
                                                    <ul class="nav nav-tabs">
                                                        <li class="active"><a href="#inventory_tab1" data-toggle="tab" class="nationwideInventTab">Equipment Monitoring</a></li>
                                                        <li><a href="#inventory_tab2" data-toggle="tab" class="nationwideInventTab">Quantity Monitoring</a></li>
                                                        <li><a href="#inventory_tab3" data-toggle="tab" class="nationwideInventTab">Availability and Condition Monitoring</a></li>
                                                    </ul>
                                                    <div class="tab-content">

                                                        <div class="tab-pane active" id="inventory_tab1">
                                                            <div class="panel-body">
                                                                <table class="table-condensed table-hover display tableendorse" width="100%" id="admin-staff-assets-table">
                                                                    <thead>
                                                                    <tr>
                                                                        <th>ID</th>
                                                                        <th>BARCODE</th>
                                                                        <th>EQUIPMENT DETAILS</th>
                                                                        <th>EQUIPMENT SPECIFICATION</th>
                                                                        <th>EQUIPMENT PRICE</th>
                                                                        <th>STATUS</th>
                                                                        <th>DATE TIME ADDED</th>
                                                                        <th>ACTION</th>
                                                                    </tr>
                                                                    </thead>
                                                                </table>
                                                            </div>
                                                        </div>

                                                        <div class="tab-pane" id="inventory_tab2">
                                                            <div class="panel-body">
                                                                <table class="table-condensed table-hover display tableendorse" width="100%" id="admin-staff-quantity-table">
                                                                    <thead>
                                                                    <tr>
                                                                        <th>ITEM</th>
                                                                        <th>BRANCH</th>
                                                                        <th>QUANTITY</th>
                                                                    </tr>
                                                                    </thead>
                                                                </table>
                                                            </div>
                                                        </div>

                                                        <div class="tab-pane" id="inventory_tab3">
                                                            <div class="panel-body">
                                                                <div class="row">
                                                                    <div class="col-md-3">
                                                                        <div class="form-group">
                                                                            <label for="">Availability Status:</label>
                                                                            <select name="" id="inventory-availability" class="form-control">
                                                                                <option value="">All</option>
                                                                                <option value="Issued">Issued</option>
                                                                                <option value="Return">Return</option>
                                                                                <option value="Vacant">Vacant</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <div class="form-group">
                                                                            <label for="">Current Status:</label>
                                                                            <select name="" id="inventory-current-status" class="form-control">
                                                                                <option value="">All</option>
                                                                                <option value="Good Condition">Good Condition</option>
                                                                                <option value="With Defect">With Defect</option>
                                                                                <option value="Defective">Defective</option>
                                                                                <option value="Disposal">Disposal</option>
                                                                                <option value="Missing">Missing</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="">Position:</label>
                                                                            <select name="" id="inventory-employee-pos" class="select2" style="width: 100%">
                                                                                <option value="">All</option>
                                                                                @foreach($position as $pos)
                                                                                    <option value="{{ $pos->id}}">{{ $pos->position_name }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <table class="table-condensed table-hover display tableendorse" width="100%" id="admin-staff-availability-table">
                                                                    <thead>
                                                                    <tr>
                                                                        <th>BARCODE</th>
                                                                        <th>AVAIL STATUS</th>
                                                                        <th>CURRENT STATUS</th>
                                                                        <th>BRANCH</th>
                                                                        <th>ACTION</th>
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
                </div>
            </div>
        </div>

    </section>
</div>
