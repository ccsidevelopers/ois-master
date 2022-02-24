<?php if(Auth::user()->authrequest=='C-Monit'): ?>

    
        
    

    <div class="tab-pane active" id="man_track_tab">
        <?php echo $__env->make('management.managementtracker', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    </div>

    <?php $__env->startPush('jscript'); ?>
        <script src="<?php echo e(asset('jscript/endorsement-management.js?n='.$javs)); ?>"></script>
    <?php $__env->stopPush(); ?>
<?php endif; ?>

<?php if(Auth::user()->authrequest!='C-Monit'): ?>

    <div class="tab-pane active" id="human_resources_dashboard">
        <?php echo $__env->make('human_resources.human-resources-dashboard', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    </div>
    <div class = "tab-pane" id = "human_resources_employee">
        <?php echo $__env->make('human_resources.human-resources-employee', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    </div>
    <div class = "tab-pane" id = "human_resources_motor">
        <?php echo $__env->make('human_resources.human-resources-motor', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    </div>

    <div class = "tab-pane" id = "human_resources_equip">
        <?php echo $__env->make('human_resources.human-resources-equipments', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    </div>
    <div class = "tab-pane" id = "human_resources_issuance">
        <?php echo $__env->make('human_resources.human-resources-issuance', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    </div>

<?php endif; ?>

<?php if(Auth::user()->productivity_sao=='Granted'): ?>
    <div class="tab-pane" id="sao_productivity_emp">
        <?php echo $__env->make('bank_dept.senior_account_officer.sao-productivity', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    </div>
<?php endif; ?>