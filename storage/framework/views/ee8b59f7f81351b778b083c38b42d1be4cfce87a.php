<aside class="main-sidebar affix">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
   <?php echo $__env->make('layouts.includes.leftsidebarName', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search...">
                <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">MAIN NAVIGATION</li>

            
                
                    
                
            

            <li class="active">
                <a href="#admin-staff-monitoring_tab_new"  data-toggle="tab" class="admin_staff_a_class">
                    <i class="fa fa-fw fa-list"></i> <span>Monitoring (NEW)</span>
                </a>
            </li>

            
                
                    
                
            

            
                
                    
                
            



            <?php echo $__env->make('layouts.includes.adminStaffLeftSidebar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

            <li class="">
                <a href="#admin-staff-equipment-gen"  data-toggle="tab" class="admin_staff_a_class">
                    <i class="fa fa-fw fa-file-pdf-o"></i> <span>Requisition General Monitoring</span>
                </a>
            </li>




            <li class="" id = "removeViewFund">
                <a href="#admin-staff-fund_tab"  data-toggle="tab" class="admin_staff_a_class">
                    <i class="fa fa-fw fa-bank"></i> <span>Monitoring of Fund Request</span>
                </a>
            </li>

            <li class="" id="utilities_expenses_request_admin">
                <a href="#utilities_expenses_request_tab"  data-toggle="tab" class="utilities_expenses_request_admin_class">
                    <i class="fa fa-fw fa-paypal"></i> <span>Utilities Expense Request</span>
                </a>
            </li>

            <li class="">
                <a href="#admin-staff-emp-status-tab"  data-toggle="tab" class="admin_staff_a_class">
                    <i class="fa fa-fw fa-group"></i> <span> Employee Information</span>
                </a>
            </li>

            <li class="" id = "removeViewQr">
                <a href="#admin-staff-generate-qr-code"  data-toggle="tab" class="admin_staff_a_class">
                    <i class="fa fa-fw fa-qrcode"></i> <span> Generate QR Code</span>
                </a>
            </li>

            <li class="" id="">
                <a href="#manpower_admin"  data-toggle="tab" class="admin_staff_a_class" id="manpower_admin_monitoring">
                    <i class="fa fa-thumbs-up"></i> <span> Manpower Monitoring</span>
                </a>
            </li>

            <li class="" id="">
                <a href="#powerman_admin"  data-toggle="tab" class="admin_staff_a_class" id="powerman_admin_monitoring">
                    <i class="fa fa-map"></i> <span> Powerman Monitoring</span>
                </a>
            </li>
            <li class="" id="">
                <a href="#student_admin" data-toggle="tab" class="admin_staff_a_class" id="student_admin_information">
                    <i class="fa fa-map"></i><span>Student Information</span>
                </a>
            </li>



            
                
                    
                
            

            <li>
                <a href="#" data-toggle="modal" data-target="#modal-logs" id ="item_logs">
                 <i class = "fa fa-fw fa-tasks"></i>   <span>Logs</span>
                </a>
            </li>
            <li class="header">OTHERS</li>
            
                
                    
                
            
            
                
                    
                
            

            
                
                    
                
            

            <li id = "docuLoad">
                <a href="#" data-toggle="modal" data-target="#modal-viewDocu">
                    <i class="fa fa-fw fa-file"></i> <span>General Forms</span>
                </a>
            </li>

            <li>
                <a href="" data-toggle="modal" data-target="#modal-add-item-selection">
                    <i class="glyphicon glyphicon-folder-open"></i> <span>Add Item (Inventory)</span>
                </a>
            </li>
            <li>
                <a href="" data-toggle="modal" data-target="#modal-ar_form">
                    <i class="fa fa-file-text"></i> <span>Send A.R</span>
                </a>
            </li>



            <?php echo $__env->make('layouts.includes.leftsidebarGeneralContent', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>

<div class="tab-content">
    <div class="tab-pane" id="admin-staff-monitoring_tab">
        <?php echo $__env->make('admin_staff.admin-staff-general-monitoring', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    </div>

    <div class="tab-pane active" id="admin-staff-monitoring_tab_new">
        <?php echo $__env->make('admin_staff.admin-staff-general-monitoring-new', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    </div>
    <div class="tab-pane" id="admin-staff-profile_tab">
        <?php echo $__env->make('admin_staff.admin-staff-profile', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    </div>

    <div class="tab-pane" id="admin-staff-request_tab">
        <?php echo $__env->make('admin_staff.admin-staff-request', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    </div>

    <div class="tab-pane" id="admin-staff-requisition-approval-tab">
        <?php echo $__env->make('admin_staff.admin-staff-equipment-request', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    </div>

    <div class="tab-pane" id="admin-staff-equipment-processing-tab">
        <?php echo $__env->make('admin_staff.admin-staff-equipment-process', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    </div>

    <div class="tab-pane" id="admin-staff-equipment-gen">
        <?php echo $__env->make('admin_staff.admin-staff-requi-general-mon', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    </div>



    <div class="tab-pane" id="admin-staff-fund_tab">
        <?php echo $__env->make('admin_staff.admin-staff-monitoring-fund', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    </div>

    <div class="tab-pane" id="utilities_expenses_request_tab">
        <?php echo $__env->make('admin_staff.utilities_expenses_request_admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    </div>

    <div class="tab-pane" id="admin-staff-emp-status-tab">
        <?php echo $__env->make('admin_staff.admin-staff-employee-monitor', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    </div>

    <div class="tab-pane" id="admin-staff-generate-qr-code">
        <?php echo $__env->make('admin_staff.admin-staff-generate-qr', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    </div>

    <div class="tab-pane" id="manpower_admin">
        <?php echo $__env->make('admin_staff.manpower-admin-endorse-request', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    </div>

    <div class="tab-pane" id="admin-staff-accredit-supplier">
        <?php echo $__env->make('admin_staff.admin-staff-accredited-supplier', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    </div>

    <div class="tab-pane" id="admin-staff-inventory_tab">
        <?php echo $__env->make('admin_staff.admin-staff-inventory', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    </div>

    <div class="tab-pane" id="admin-staff-incident-report-tab">
        <?php echo $__env->make('admin_staff.admin-staff-incident-report-moni', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    </div>

    <div class="tab-pane" id="powerman_admin">
        <?php echo $__env->make('admin_staff.powerman-testing', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    </div>

    <div class="tab-pane" id="student_admin">
        <?php echo $__env->make('admin_staff.student-information', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    </div>
    

    <?php echo $__env->yieldContent('global_panel'); ?>

</div>