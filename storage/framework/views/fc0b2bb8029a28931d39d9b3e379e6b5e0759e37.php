<?php if(Auth::user()->admin_access_1=='Granted'): ?>
    <li class="">
        <a href="#admin-staff-requisition-approval-tab"  data-toggle="tab" class="admin_staff_a_class">
            <i class="fa fa-send"></i> <span>Equipment Requests</span>
        </a>
    </li>
<?php endif; ?>

<?php if(Auth::user()->admin_access_2=='Granted'): ?>
    <li class="">
        <a href="#admin-staff-equipment-processing-tab"  data-toggle="tab" class="admin_staff_a_class">
            <i class="fa fa-spinner"></i> <span>Equipment Processing</span>
        </a>
    </li>
<?php endif; ?>

<?php if(Auth::user()->admin_access_3=='Granted'): ?>

    <li class="" id = "removeSupplier">
        <a href="#admin-staff-accredit-supplier"  data-toggle="tab" class="admin_staff_a_class">
            <i class="fa fa-fw fa-table"></i> <span> Accredited Suppliers </span>
        </a>
    </li>
<?php endif; ?>

<?php if(Auth::user()->admin_access_4=='Granted'): ?>

    <li class="" id = "">
        <a href="#admin-staff-incident-report-tab"  data-toggle="tab" class="admin_staff_a_class">
            <i class="fa fa-fw fa-table"></i> <span> Incident Report/s</span>
        </a>
    </li>
<?php endif; ?>