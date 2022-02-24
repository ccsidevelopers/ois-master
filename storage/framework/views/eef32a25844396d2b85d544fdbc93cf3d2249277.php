<div class="content-wrapper">
    <section class="content-header">
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <h3>Notice to Explain</h3>
            </div>
        </div>
    </section>
    <!-- Main content -->
    <div class="content">
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="box box-default box-solid" style="box-shadow:1px 6px 10px 3px #d2d6de;">
                    
                    
                    
                    <div class="box-header with-border">
                        <i class="fa fa-fw fa-users"></i>
                        <h3 class="box-title text-capitalize">Employee's Details</h3>
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
                                        <li class="active"><a href=""></a> </li>
                                        <li class=""><a href=""></a> </li>
                                    </ul>
                                </div>
                                <table class="table table-bordered" id="nte_users_table">
                                    <thead class="text-uppercase">
                                    <tr>
                                        <th>id</th>
                                        <th>employee id</th>
                                        <th>user name</th>
                                        <th>email</th>
                                        <th>position</th>
                                        <th style="width:10%">actions</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="modal fade" id="nte_reasaon_modal" >
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-blue">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        <h4 class="modal-title text-uppercase"><i class="fa mouse-pointer margin"></i>add NTE reason</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label for="nte_reason_text" class=" margin text-bold">NTE Reason <small class="text-red">(Required)</small> </label>
                                    <textarea id="nte_reason_text" class="form-control" name="" cols="30" rows="7" style="resize: none;font-size:16px;"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer margin">
                        <button class="btn btn-danger text-capitalize pull-left" data-dismiss="modal" style="box-shadow:1px 8px 4px #ddd;"><i class="fa fa-fw fa-close"></i> cancel</button>
                        <button class="btn btn-success text-uppercase pull-right" id="send_nte" style="box-shadow:1px 8px 4px #ddd;"><i class="fa fa-fw fa-paper-plane"></i> send</button>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>