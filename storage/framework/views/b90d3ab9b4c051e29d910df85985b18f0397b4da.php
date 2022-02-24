<style>
    #map_wrapper {
        height: 80%;
    }

    #map_canvas {
        width: 100%;
        height: 93%;
    }

    /*#overlay_load   {*/
        /*position:fixed;*/
        /*z-index:99999;*/
        /*top:0;*/
        /*left:0;*/
        /*bottom:0;*/
        /*right:0;*/
        /*background:rgba(0,0,0,0.9);*/
        /*transition: 1s 0.4s;*/
    /*}*/
    /*#progress_load{*/
        /*height:1px;*/
        /*background:#fff;*/
        /*position:absolute;*/
        /*width:0;*/
        /*top:50%;*/
    /*}*/
    /*#progstat_load{*/
        /*font-size:0.7em;*/
        /*letter-spacing: 3px;*/
        /*position:absolute;*/
        /*top:50%;*/
        /*margin-top:-40px;*/
        /*width:100%;*/
        /*text-align:center;*/
        /*color:#fff;*/
    /*}*/

</style>

<?php $__env->startSection('content'); ?>


<div class="content-wrapper">
    <!-- Content Header (Page header) -->

    <!-- Main content -->

    <!-- /.content -->
</div>


<div class="modal fade" id="modal-view-fund-req-hold">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" style = "text-align: center">Fund Request Information</h4>
            </div>
            <div class="modal-body">
                <div class = "row">
                    <div class = "col-md-12">
                        <div class = "box box-info">
                            <div class = "row" style = "padding-top : 20px;">
                                <div class = "col-md-1"></div>
                                <div class = "col-md-10">
                                    <table class="table-condensed"  style = "overflow-x:auto; border-collapse:collapse; table-layout:fixed ; width : 100%; ">
                                        <tr>
                                            <td style="font-weight:bold; background-color: silver;">ID</td>
                                            <td style = "word-wrap:break-word;" id = "fund_id_hold"></td>
                                        </tr>
                                        <tr>
                                            <td style="font-weight:bold; background-color: silver;">Request Date and Time</td>
                                            <td style = "word-wrap:break-word;" id = "fund_request_date_hold"></td>
                                        </tr>
                                        <tr>
                                            <td style="font-weight:bold; background-color: silver;">Delivery Date and Time</td>
                                            <td style = "word-wrap:break-word;" id = "fund_delivery_date_hold"></td>
                                        </tr>
                                        <tr>
                                            <td style="font-weight:bold; background-color: silver;">Holding Date and Time</td>
                                            <td style = "word-wrap:break-word;" id = "fund_hold_date_hold"></td>
                                        </tr>
                                        <tr>
                                            <td style="font-weight:bold; background-color: silver;">Fund Amount</td>
                                            <td style = "word-wrap:break-word;" id = "fund_amount_hold"></td>
                                        </tr>
                                        <tr>
                                            <td style="font-weight:bold; background-color: silver;">Account/s</td>
                                            <td style = "word-wrap:break-word;" id = "fund_account_hold"></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class = "col-md-1"></div>
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


<div class="modal fade" id="modal-remarks-disapprove">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" style = "text-align: center">Reason for disapproval</h4>
            </div>
            <div class="modal-body">
                <div class = "row">
                    <div class = "col-md-12">
                        <div class = "box box-warning">
                            <div class = "row" style = "padding-top : 20px; padding-bottom : 10px;">
                                <div class = "col-md-1"></div>
                                <div class = "col-md-10">
                                    <label for="">Remarks:</label>
                                    <textarea id="remarksDis" rows="3" class = "form-control" placeholder="Enter remarks....."></textarea>
                                </div>
                                <div class = "col-md-1"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <button type="button" id = "btnSubmitDis" class="btn btn-primary">Submit</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


<div class="modal fade" id="modal-modify-fund">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" style = "text-align: center">Fund Request Review</h4>
            </div>
            <div class="modal-body">
                <div class = "row" >
                    <div class = "col-md-12">
                        <div class = "box box-danger">
                            <div class = "row" style = "padding-top : 40px; padding-bottom: 20px;">
                                <div class = "col-md-3"></div>
                                <div class = "col-md-4">
                                    <label for="" style = "padding-bottom: 10px;">Fund Request Amount:</label>
                                    <input type="number" class = "form-control" id = "newFundReqAmount" disabled>
                                </div>
                                <div class = "col-md-4" style = "padding-top : 33px;">
                                    <button class = "btn btn-md btn-primary" id = "openInputFundAmt"><i class="fa fa-fw fa-edit"></i>Modify</button>
                                    <button class = "btn btn-md btn-warning" id = "closeInputFundAmt"><i class="fa fa-fw fa-close" ></i>Cancel</button>
                                </div>
                                <div class = "col-md-2"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success" id = "appFundReqNow"><i class = "glyphicon glyphicon-ok" ></i> Approve Request</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal modal-info fade" id="modal-loading-to-manage">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Sending information</h4>
            </div>
            <div class="modal-body">
                <p style = "text-align: center; padding-top : 20px;">Please wait while sending notifications.......
                    <span style = "padding-right : 5px;" ><img src= "<?php echo e(asset('dist/img/loading.gif')); ?>" style = "width: 7%"></span>
                </p>
            </div>

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modal-req-rem-manage-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" style = "text-align: center">Management Approver Remarks</h4>
            </div>
            <div class="modal-body">
                <div class = "row" style = "padding-top: 20px;">
                    <div class = "col-md-12">
                        <label for="">Remarks:</label>
                        <textarea id="req_rem_remarks_manage-1" rows = "10" class = "form-control" disabled></textarea>
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

<div class="modal fade" id="modal-view-ci-liq-img">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Attached C.I Report for Liquidation</h4>
            </div>
            <div class="modal-body">
                <div class = "row">
                    <div class = "col-md-12">
                        <div class = "row">
                            <div class = "col-md-12">
                                        <span id = "insertCiImgLiq">
                                        </span>
                                <div class = "row">
                                    <div class = "col-md-12">
                                        <div class = "box box-warning">
                                            <div class = "row" style = "padding-bottom : 20px;">
                                                <div class = "col-md-2"></div>
                                                <div class = "col-md-8" >
                                                    <div class="form-group">
                                                        <h3 style = "text-align: left">General Liquidation Remarks:</h3>
                                                        <textarea id= "insertCILiqRemarks" class = "form-control" disabled></textarea>
                                                    </div>
                                                    <div class="form-group col-md-4 hidemuna">
                                                        <label for="">Fund Requested</label>
                                                        <input type="text" class="form-control" id="ci_req_amount" disabled>
                                                        <input type="hidden" class="form-control" id="ci_req_amount_check">
                                                    </div>
                                                    
                                                        
                                                        
                                                    
                                                    
                                                        
                                                        
                                                    
                                                    
                                                        
                                                        
                                                    
                                                </div>
                                                <div class = "col-md-2"></div>
                                            </div>
                                            <div class="row" style="padding-bottom: 20px;" hidden>
                                                <div class="col-md-12">
                                                    <div class="col-md-2"></div>
                                                    <div class="col-md-8">
                                                        <b>Status: </b><span id="reviewer_span"></span><br>
                                                        <b>Changes made: </b><span id="reviewer_changes"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row" style="padding-bottom: 20px;">
                                                <div class="col-md-12">
                                                    <div class="col-md-2"></div>
                                                    <div class="col-md-8">
                                                        <b>Last Updated: </b><span id="liq_date_rev"></span><br>

                                                    </div>
                                                    <div class="col-md-2"></div>
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
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modal-req-rem">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" style = "text-align: center">Requestor Remarks</h4>
            </div>
            <div class="modal-body">
                <div class = "row" style = "padding-top: 20px;">
                    <div class = "col-md-12">
                        <b>Name:</b> <p id="dispatcher_req_name"></p>
                    </div>
                </div>
                <div class = "row">
                    <div class = "col-md-12">
                        <label for="">Remarks:</label>
                        <textarea id="req_rem_remarks" rows = "10" class = "form-control" disabled></textarea>
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

<div class="modal fade" id="modal-req-rem-manage">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" style = "text-align: center">Management Approver Remarks</h4>
            </div>
            <div class="modal-body">
                <div class = "row" style = "padding-top: 20px;">
                    <div class = "col-md-12">
                        <b>Name:</b> <p id="manage_req_name"></p>
                    </div>
                </div>
                <div class = "row">
                    <div class = "col-md-12">
                        <label for="">Remarks:</label>
                        <textarea id="req_rem_remarks_manage" rows = "10" class = "form-control" disabled></textarea>
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

<div class="modal modal-default fade" id="modal_additional_fund_request">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Addional Fund Request</h4>
            </div>
            <div class="modal-body">
                <center><p><b>FUND REQUEST INFORMATION</b><br>
                        <span id="span_info_add_request"></span>
                    </p></center>

                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="txtFundAmount">Fund Request Amount: <small id="txtFundAmount_add_label" hidden style="color: red;">(NOTE: AMOUNT IS OPTIONAL)</small> </label>
                                <input type="number" class="form-control" id="txtFundAmount_add" value="0">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="txtFundRemarks_add">Fund Remarks:</label>
                                <textarea id="txtFundRemarks_add" class="form-control" placeholder="Remarks Here..."></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
                <button type="button" id="btn_add_req" class="btn btn-primary pull-right">Send Request</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modal-view-audit-review-rem">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Account Review Summary</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <span id="view_remarksSpan"></span>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>




<!-- /.content-wrapper -->
<?php $__env->stopSection(); ?>

<?php $__env->startPush('leftsidebar'); ?>
    <?php echo $__env->make('bank_dept.senior_account_officer.sao-leftsidebar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('jscript'); ?>
    

    <script>

//        (function(){
//            function id(v){return document.getElementById(v); }
//            function loadbar() {
//                var ovrl = id("overlay_load"),
//                    prog = id("progress_load"),
//                    stat = id("progstat_load"),
//                    img = document.images,
//                    c = 0;
//                tot = img.length;
//
//                function imgLoaded(){
//                    c += 1;
//                    var perc = ((100/tot*c) << 0) +"%";
//                    prog.style.width = perc;
//                    stat.innerHTML = "Loading "+ perc;
//                    if(c===tot) return doneLoading();
//                }
//                function doneLoading(){
//                    ovrl.style.opacity = 0;
//                    setTimeout(function(){
//                        ovrl.style.display = "none";
//                    }, 1200);
//                }
//                for(var i=0; i<tot; i++) {
//                    var tImg     = new Image();
//                    tImg.onload  = imgLoaded;
//                    tImg.onerror = imgLoaded;
//                    tImg.src     = img[i].src;
//                }
//            }
//            document.addEventListener('DOMContentLoaded', loadbar, false);
//        }());



        $('.a_sao').click(function () {
            $('.class_sao').each(function () {
                $(this).removeClass('active');
            })
        });

    </script>

    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/1.0.7/css/responsive.dataTables.min.css">
    <script src="https://cdn.datatables.net/responsive/2.1.1/js/dataTables.responsive.min.js"></script>
    <script src="<?php echo e(asset('jscript/endorsement.js?n='.$javs)); ?>"></script>
    <script type='text/javascript' src="https://cdnjs.cloudflare.com/ajax/libs/handlebars.js/4.0.11/handlebars.js"></script>
    <script src="<?php echo e(asset('jscript/maps.js?n='.$javs)); ?>"></script>
    <script src="<?php echo e(asset('jscript/sraccountofficer.js?n='.$javs)); ?>"></script>
    <script src="<?php echo e(asset('jscript/fund-request-tables-sao.js?n='.$javs)); ?>"></script>
    <script src="<?php echo e(asset('jscript/fund-request-tables-finance.js?n='.$javs)); ?>"></script>
    <script src="<?php echo e(asset('jscript/finance.js?n='.$javs)); ?>"></script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>