<div class="content-wrapper">
    <section class="content-header">
       <h3>Utilities Expense Request</h3>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-4 col-sm-4">
                <div class="box box-primary box-solid" style="box-shadow:1px 6px 10px 3px #d2d6de;">
                    <div class="overlay" id="utilities_loading">
                        <i class="fa fa-refresh fa-spin"></i>
                    </div>
                    <div class="box-header with-border text-center">
                        <h3 class="box-title">Add Expenses</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <div class="form-group margin clearfix">
                                    <div class="col-md-12 col-sm-12 no-padding clearfix">
                                        <label class="pull-left margin" for="category">Category<small class="text-red">(Required)</small></label>
                                        <div class="radio pull-right">
                                            <label class="pull-right margin" for="existing_id">
                                                <input class="fund_util_radio add_expenses_required" type="radio" name="category" id="existing_id" value="existing_id" checked title="Existing Category"> Existing
                                            </label>
                                            <label class="pull-right margin" for="new_id">
                                                <input class="fund_util_radio add_expenses_required" type="radio" name="category" id="new_id" value="new_id" title="New Category"> NEW
                                            </label>
                                        </div>
                                        <select class="form-control select2 expenses_class expense_category" name="" id="existing_cat_id_holder" style="width: 100%">
                                            <option value="">---SELECT CATEGORY---</option>
                                            <?php $__currentLoopData = $expenses_category; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $chunk_category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($chunk_category->id); ?>"><?php echo e($chunk_category->category_name); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group margin">
                                    <input type="text" id="new_cat_id_holder" class="form-control expenses_class expense_category" placeholder="New Category" style="display: none">
                                </div>
                                <div class="form-group">
                                    <div class="col-md-5 col-sm-11 no-padding margin pull-left">
                                        <label class="margin" for="month">Statement date<small class="text-red">(Required)</small></label>
                                        <input type="date" class="form-control expenses_class add_expenses_required" id="expenses_statement_date">
                                    </div>
                                    <div class="col-md-5 col-sm-11 no-padding margin pull-right">
                                        <label class="margin" for="month">Due date<small class="text-red">(Required)</small></label>
                                        <input type="date" class="form-control expenses_class add_expenses_required" id="expenses_due_date">
                                    </div>
                                </div>
                                <div class="form-group margin">
                                    <label for="branch" class="margin">Branch<small class="text-red">(Required)</small></label>
                                    <select class="form-control expenses_class add_expenses_required" name="branch" id="expenses_branches">
                                        <option value="">--Select your Branch--</option>
                                        <option value="Cavite">Cavite</option>
                                        <option value="Manila">Manila</option>
                                        <option value="Cebu">Cebu</option>
                                        <option value="Davao">Davao</option>
                                    </select>
                                </div>
                                <div class="form-group margin">
                                    <label class="margin" for="month">Account #<small class="text-grey">(Optional)</small></label>
                                    <div class="input-group">
                                        <input type="number" class="form-control expenses_class" id="expenses_account_number" placeholder="#######">
                                        <span class="input-group-addon"><i class="fa fa-fw fa-slack"></i></span>
                                    </div>
                                </div>
                                <div class="form-group margin">
                                    <label class="margin" for="month">Amount #<small class="text-red">(Required)</small></label>
                                    <div class="input-group">
                                        <input type="number" class="form-control expenses_class add_expenses_required" id="expenses_amount" placeholder="₱">
                                        <span class="input-group-addon text-bold">.00</span>
                                    </div>
                                </div>
                                <div class="form-group clearfix" style="margin:9% 2%;position: relative;">

                                    <div class="upload_append pull-left col-md-9 col-sm-9 no-padding" id="upload_append_id">
                                        <label class="btn btn-lg text-muted pull-left file_upload_btn" id="expenses_input_files_label_default" for="expenses_input_files_id" style="border: 1px solid darkgrey;border-radius: 4px;box-shadow: 1px 8px 4px #eee; font-size: 14px;"><i class="fa fa-paperclip"> File upload</i></label>
                                        
                                        <input type="file" class="expenses_class expenses_files_upload no-border add_expenses_required" name="#expenses_input_files_label_default" id="expenses_input_files_id" style="display: none;">
                                        <span class="btn btn-xs margin text-muted file_upload_add_more text-green" style="border:1px solid #00a65a;box-shadow: 1px 7px 4px #00a65a26; width:25%;"> Add new <i class="text-green fa fa-fw fa-plus-square"></i></span>
                                    </div>
                                    <button type="submit" id="expenses_submit" class="btn btn-primary text-uppercase pull-right expenses_class" style="box-shadow: 1px 8px 4px #ddd;position:absolute;bottom:0;right:0;">Submit <i class="fa fa-fw fa-caret-right"></i> </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8 col-sm-7">
                <div class="box box-default box-solid" style="box-shadow:1px 6px 10px 3px #d2d6de;">
                    <div class="overlay" id="utilities_loading">
                        <i class="fa fa-refresh fa-spin"></i>
                    </div>
                    <div class="box-header with-border">
                        <h3 class="box-title text-uppercase">Request List</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <div class="nav-tabs-custom">
                                    <ul class="nav nav-tabs">
                                        <li class="active">
                                            <a href="#utilities_general_tab" data-toggle="tab"><i class="fa fa-fw fa-list-alt text-purple"></i> General</a>
                                        </li>

                                        <li class="">
                                            <a href="#utilities_approved_tab" data-toggle="tab" id="fund_util_approved_table"><i class="fa fa-fw fa-calendar-check-o text-green"></i> Approved</a>
                                        </li>
                                    </ul>

                                    <div class="tab-content">
                                        <div class="row">
                                            <div class="cold-md-6 col-sm-3 text-yellow" style="margin:3% 0 4%;">
                                                <span class="text-uppercase text-bold" style=""><i class="glyphicon glyphicon-list" style="margin: 0 4% 8% 0;"></i>choose categrory :</span>
                                                <select class="form-control select2 expenses_class expense_category" name="" id="fund_util_category" style="width: 100%">
                                                    <option value="">--- ALL CATEGORY ---</option>
                                                    <?php $__currentLoopData = $expenses_category; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $chunk_category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($chunk_category->id); ?>"><?php echo e($chunk_category->category_name); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="tab-pane active" id="utilities_general_tab">
                                            <table class="table table-bordered table-hover" id="fund_utility_table_general">
                                                <thead>
                                                <tr>
                                                    <th class="text-uppercase">ID</th>
                                                    <th class="text-uppercase">Category</th>
                                                    <th class="text-uppercase">Account number</th>
                                                    <th class="text-uppercase">Amount</th>
                                                    <th class="text-uppercase">Statement & due date</th>
                                                    
                                                    <th class="text-uppercase">branch</th>
                                                    <th class="text-uppercase">Status</th>
                                                    <th class="text-uppercase">Action</th>
                                                </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                        </div>

                                        <div class="tab-pane" id="utilities_approved_tab">
                                            <table class="table table-bordered table-hover" id="fund_utility_table_approved">
                                                <thead>
                                                <tr>
                                                    <th class="text-uppercase">ID</th>
                                                    <th class="text-uppercase">Category</th>
                                                    <th class="text-uppercase">Account number</th>
                                                    <th class="text-uppercase">Amount</th>
                                                    <th class="text-uppercase">Statement & due date</th>
                                                    <th class="text-uppercase">branch</th>
                                                    <th class="text-uppercase">Status</th>
                                                    <th class="text-uppercase">Action</th>
                                                    
                                                </tr>
                                                </thead>
                                                <tbody></tbody>
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

<div class="modal fade" id="fund_util_update_data_modal">
            <div class="modal-dialog modal-lg" style="width:70%">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span></button>
                        <h4 class="modal-title text-uppercase"><i class="glyphicon glyphicon-pencil margin"></i> update data</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 col-sm-12" style="margin:0.5% 0;">
                                <div class="form-group">
                                    <div class="col-md-5 col-sm-11 no-padding margin pull-left">
                                        <label class="margin" for="month">Statement date<small class="text-red">(Required)</small></label>
                                        <input type="date" class="form-control expenses_class input_required_fund_util" id="expenses_statement_date_edit">
                                    </div>
                                    <div class="col-md-5 col-sm-11 no-padding margin pull-right">
                                        <label class="margin" for="month">Due date<small class="text-red">(Required)</small></label>
                                        <input type="date" class="form-control expenses_class input_required_fund_util" id="expenses_due_date_edit">
                                    </div>
                                </div>
                                <div class="form-group margin">
                                    <label for="branch" class="margin">Branch<small class="text-red">(Required)</small></label>
                                    <select class="form-control expenses_class input_required_fund_util" name="branch" id="expenses_branches_edit">
                                        <option value="">--Select your Branch--</option>
                                        <option value="Cavite">Cavite</option>
                                        <option value="Manila">Manila</option>
                                        <option value="Cebu">Cebu</option>
                                        <option value="Davao">Davao</option>
                                    </select>
                                </div>
                                <div class="form-group margin">
                                    <label class="margin" for="month">Account #<small class="text-grey">(Optional)</small></label>
                                    <div class="input-group">
                                        <input type="number" class="form-control expenses_class" id="expenses_account_number_edit" placeholder="#######">
                                        <span class="input-group-addon"><i class="fa fa-fw fa-slack"></i></span>
                                    </div>
                                </div>
                                <div class="form-group margin">
                                    <label class="margin" for="month">Amount #<small class="text-red">(Required)</small></label>
                                    <div class="input-group">
                                        <input type="number" class="form-control expenses_class input_required_fund_util" id="expenses_amount_edit" placeholder="₱">
                                        <span class="input-group-addon text-bold">.00</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading text-center">
                                        <h4>Attachments</h4>
                                        <span class="text-maroon" style="letter-spacing: 1px;">( Click to see attachments )</span>
                                    </div>
                                    <div class="panel-body">
                                        <div class="form-group" id="upload_file_append">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer margin" id="fund_util_update_actions" style="padding-bottom:5%">
                        <button class="btn btn-danger text-capitalize pull-left" id="fund_util_cancel" data-dismiss="modal" style="box-shadow:1px 8px 4px #ddd;"><i class="fa fa-close"></i> cancel changes</button>
                        <button class="btn btn-success text-capitalize pull-right fund_util_update_btn" id="fund_util_update" style="box-shadow:1px 8px 4px #ddd;"><i class="fa fa-check"></i> update changes</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="fund_util_activity_logs">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-blue">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        <h4 class="modal-title text-uppercase"><i class="glyphicon glyphicon-list-alt margin"></i> activity logs</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 no-padding">
                                <div class="form-group">
                                    <div class="col-md-12 col-sm-12">
                                        <table class="table table-striped" id="fund_utilities_logs">
                                            <thead class="text-center bg-navy">
                                            <tr name="title_head">
                                                <th class="text-capitalize">user</th>
                                                <th class="text-capitalize">activity</th>
                                                <th class="text-capitalize">date/time</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer margin">
                        <button class="btn btn-xs btn-success text-uppercase" data-dismiss="modal"><i class="fa fa-eye-slash margin"></i><span class="" style="margin-right:10px;">okay</span></button>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>