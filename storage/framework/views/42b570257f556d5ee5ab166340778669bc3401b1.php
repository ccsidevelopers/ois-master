<div class="content-wrapper">
    <section class="content-header">
        <h3>Student admin</h3>
    </section>


    
    <section class="content">
        <div class="row">
            <div class="col-md-3">
            <div class="box box-default">
                    <div class="box-header with-border">
                        <h3 class="box-title">Student data</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse">
                                <i class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label for="student_input_name">Name</label>
                                    <input type="text" class="form-control" id="student_input_name" placeholder="Input name...">
                                </div>
                                <div class="form-group">
                                    <label for="student_input_age">Age</label>
                                    <input type="number" class="form-control" id="student_input_age" placeholder="Input age...">
                                </div>
                                <div class="form-group">
                                    <label for="student_input_gender">Gender</label>
                                    <select name="Gender" id="student_input_gender">
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>
                                <div class="box-footer">
                                    <div class="btn-holder pull-right">
                                        <button class="btn btn-primary push-right" id="student_submit_btn">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="box box-default">
                    <div class="box-header with-border">
                        <h3 class="box-title">Student information</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse">
                                <i class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="box-body">
                        <table class="table table-bordered table-hover" id="student_information_table">
                            <thead>
                            <tr>
                                <th>Id</th>
                                <th>Name</th>
                                <th>Age</th>
                                <th>Gender</th>
                                <th>Created at</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Student Modal View -->
        <div class="modal fade in" id="student_edit_modal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        <h4 class="modal-title text-uppercase">
                            <i class="glyphicon glyphicon-pencil margin"></i>
                            Edit data
                        </h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                            <div class="form-group">
                                    <label for="student_input_name">Name</label>
                                    <input type="text" class="form-control" id="student_modal_input_name" placeholder="Input name...">
                                </div>
                                <div class="form-group">
                                    <label for="student_input_age">Age</label>
                                    <input type="number" class="form-control" id="student_modal_input_age" placeholder="Input age...">
                                </div>
                                <div class="form-group">
                                    <label for="student_input_gender">Gender</label>
                                    <input type="text" class="form-control" id="student_modal_input_gender" placeholder="Input gender...">
                                </div>
                                <div class="box-footer">
                                    <button type="button" class="pull-left btn btn-primary btn-flat" data-dismiss="modal" aria-label="Close">Delete</button>
                                    <button type="button" class="pull-left btn btn-primary btn-flat" data-dismiss="modal" aria-label="Close">Save Changes</button>
                                    <button type="button" class="pull-right btn btn-primary btn-flat" data-dismiss="modal" aria-label="Close">Ok</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

