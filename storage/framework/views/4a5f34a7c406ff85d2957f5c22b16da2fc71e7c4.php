<?php if(Auth::user()->mrf_check=='Granted'): ?>
    
        
            
        
    

    <li>
        <a href="#"  id = "passRequi"  data-toggle="tab">
            <i class="fa fa-file"></i> <span>Requisition Form</span>
        </a>
    </li>

<?php endif; ?>

<?php if(Auth::user()->requi_check=='Granted'): ?>
    <li>
        <a href="#" data-toggle="modal" id = "requi_approval_btn">
            <i class="fa fa-file-text"></i> <span>Requisition/Incident Approval</span>
        </a>
    </li>

    <?php $__env->startPush('jscript'); ?>

        <script src="<?php echo e(asset('jscript/admin_req.js?n='.$javs)); ?>"></script>

    <?php $__env->stopPush(); ?>
<?php endif; ?>

<li>
    <a href="#" data-toggle="modal" data-target="#modal-change-password">
        <i class="glyphicon glyphicon-cog"></i> <span>Change Password</span>
    </a>
</li>

<?php if(Auth::user()->hasRole ('CC Senior Account Officer') || Auth::user()->hasRole ('Senior Account Officer')): ?>
    <li>
        <a id="manpower_request_sidebar_btn" href="#" data-toggle="modal" data-target="#modal-manpower-view">
            <i class="fa fa-users"></i> <span>Manpower Requisition</span>
        </a>
    </li>
<?php endif; ?>



<?php if(!Auth::user()->hasRole ('Credit Investigator')): ?>
<li>
    <a href="#" data-toggle="modal" data-target="#modal-acknowledge-view">
        <i class="fa fa-file-text"></i> <span>Acknowledge Receipt</span>
    </a>
</li>
<?php endif; ?>


    
        
            
        
    


<li>
    <a href="#" id="btnTriggerArea" data-toggle="modal" data-target="#modal-default">
        <i id="SuggestBtn"  class="glyphicon glyphicon-comment"></i> <span>Suggestion Box</span>
    </a>
</li>

<li>
    <a href="#" id="" data-toggle="modal" data-target="#modal-incident-report">
        <i id=""  class="glyphicon glyphicon-book"></i> <span>Incident Report</span>
    </a>
</li>

<?php if(!Auth::user()->hasRole ('Client') && !Auth::user()->hasRole ('Credit Investigator')): ?>
    <li>
        <a style="cursor: pointer" class="attendance_general_modal">
            <i class="glyphicon glyphicon-time"></i> <span>Attendance</span>
        </a>
    </li>
<?php endif; ?>

<?php if(Auth::user()->productivity_sao=='Granted'): ?>
    <li>
        <a href="#sao_productivity_emp" data-toggle="tab" class="a_sao">
            <i class="fa fa-line-chart"></i> <span>Productivity</span>
        </a>
    </li>
<?php endif; ?>

<?php if(!Auth::user()->hasRole('Credit Investigator')): ?>
<li>
    <a href="#" data-toggle="modal" id="show_hide_chat_box_href">
        <i id="show_hide_chat_box_icon"  class="glyphicon glyphicon-plus"></i> <span id="span_chat_box_hide_show">Show Chat Box
            </span>
        <span id="change_chat_notif_side">
            <span id="newmessagetogs_id" data-toggle="tooltip" title="New Messages" class="newmessagetogs badge bg-red pull-right"></span>
        </span>
    </a>
</li>
<?php endif; ?>

<?php if(!Auth::user()->hasRole ('Administrator') || !Auth::user()->hasRole ('Client') || !Auth::user()->hasRole ('B.I Client') ): ?>
    <li class="hideMeFromCI" hidden>
        <a href="#" id="loadMemoGenTable" data-toggle="modal" data-target="#modal-memorandum-gen">
            <i   class="glyphicon glyphicon-alert"></i> <span>Memorandum/Notice</span>
        </a>
    </li>
<?php endif; ?>


















<?php if(!Auth::user()->hasRole ('Management') && !Auth::user()->hasRole('Credit Investigator')): ?>
<li>
    <a href="#general_leave_request_form" data-toggle="tab" class="admin_leave_form management_a_class global_leave_form" id="general_leave_form">
        <i class="fa fa-file"></i> <span>Leave Request Form </span>
    </a>
</li>
<?php endif; ?>

<?php if(!Auth::user()->hasRole ('Management') && !Auth::user()->hasRole('Credit Investigator')): ?>
<li>
    <a href="#general_leave_request_form_new" data-toggle="tab" class="admin_leave_form management_a_class global_leave_form" id="general_leave_form_new_id">
        <i class="fa fa-file"></i> <span>Leave Request Form NEW</span>
    </a>
</li>
<?php endif; ?>

<?php if(!Auth::user()->hasRole ('Management') && !Auth::user()->hasRole('Credit Investigator')): ?>
    <li>
        <a href="#global_NTE_trigger" data-toggle="tab" class="global_NTE_class" id="global_NTE">
            <i class="fa fa-fw fa-bullhorn"></i> NTE
        </a>
    </li>
<?php endif; ?>

<?php if(!Auth::user()->hasRole ('Management') || !Auth::user()->hasRole ('Client') || !Auth::user()->hasRole ('B.I Client')): ?>
    <li>
        <a href="#oims_concern_trigger" data-toggle="modal" data-target="#oims_concern_modal" class="oims_concern_class" id="oims_concern_global">
            <i class="fa fa-fw fa-commenting"></i> OIMS concerns
        </a>
    </li>
<?php endif; ?>

<?php $__env->startSection('global_panel'); ?>
    <div class="tab-pane global" id="general_leave_request_form_new">
        <?php echo $__env->make('layouts.leave_request_form_new', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    </div>

    <div class="tab-pane global" id="global_NTE_trigger">
        <?php echo $__env->make('layouts.NTE', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('extrascript'); ?>
    <script>
        $('.global_leave_form').on('click',function()
        {
            $('li').removeClass('active');
            $('.tab-pane').removeClass('active');
        });

        $('.global_NTE_class').on('click',function()
        {
            $('li').removeClass('active');
            $('.tab-pane').removeClass('active');
        });
    </script>
<?php $__env->stopPush(); ?>
