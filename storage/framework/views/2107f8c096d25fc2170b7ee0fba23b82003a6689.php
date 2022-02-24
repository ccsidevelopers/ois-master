
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

            <li class="class_sao">
                <a href="#sao_dashboard_tab" class="a_sao" data-toggle="tab">
                    <i class="fa fa-dashboard"></i> <span>Map</span>
                </a>
            </li>

            <li class="class_sao active">
                <a id="process_a" href="#sao_process_tab" class="a_sao" data-toggle="tab">
                    <i class="fa fa-users"></i> SRAO Panel - Accounts</a>
            </li>

            <li class="class_sao">
                <a id="sao_audit_a" href="#sao_audit_tab" class="a_sao" data-toggle="tab">
                    <i class="fa fa-bar-chart"></i> Account Monitoring (Audit)</a>
            </li>

            <li class="class_sao">
                <a id="fund_a" href="#sao_fund_tab" class="a_sao" data-toggle="tab">
                    <i class="fa fa-money"></i> <span>CI Fund Pending</span>
                    <span id="srao_fund_req_notif"  class="pull-right-container"></span>
                </a>
            </li>

            <li class="class_sao">
                <a id="unliq_a" href="#sao_unliq_tab" data-toggle="tab" class="a_sao">
                    <i class="fa fa-suitcase"></i> <span> CI Fund Request</span>
                </a>
            </li>

            <li class="class_sao">
                <a href="#sao_fa_monitoring_tab" id = "clickFAToAccess" data-toggle="tab" class="a_sao">
                    <i class="fa fa-table"></i> <span>C.I expenses monitoring</span>
                </a>
            </li>



            <li class="class_sao">
                <a id="search_a" href="#sao_search_tab" data-toggle="tab" class="a_sao">
                    <i class="fa fa-search"></i> <span>Search Account</span>
                </a>
            </li>

            <li class="header">OTHERS</li>
            <li>
                <a href="#" id="btnTriggerCIdirectory" data-toggle="modal" data-target="#modal-ci-direct">
                    <i id="SuggestBtn" class="glyphicon glyphicon-book"></i> <span>CI Directory</span>
                </a>
            </li>
            <?php echo $__env->make('layouts.includes.leftsidebarGeneralContent', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

        </ul>
    </section>
    <!-- /.sidebar -->
</aside>

    <div class="tab-content">
        <div class="tab-pane" id="sao_fund_tab">
            <?php echo $__env->make('bank_dept.senior_account_officer.sao-ci-fund-request', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        </div>

        <div class="tab-pane active" id="sao_process_tab">
            <?php echo $__env->make('bank_dept.senior_account_officer.sao-assign-account', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        </div>
        <div class="tab-pane" id="sao_audit_tab">
            <?php echo $__env->make('bank_dept.senior_account_officer.sao-audit-panel', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        </div>
        <div class="tab-pane" id="sao_unliq_tab">
            <?php echo $__env->make('bank_dept.senior_account_officer.sao-unliq-hold-fund', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        </div>
        <div class="tab-pane" id="sao_fa_monitoring_tab">
            <?php echo $__env->make('bank_dept.senior_account_officer.sao-fa-monitoring', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        </div>
        <?php if(Auth::user()->productivity_sao=='Granted'): ?>
            <div class="tab-pane" id="sao_productivity_emp">
                <?php echo $__env->make('bank_dept.senior_account_officer.sao-productivity', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            </div>
        <?php endif; ?>
        <div class="tab-pane" id="sao_search_tab">
            <?php echo $__env->make('bank_dept.senior_account_officer.sao-endorsement', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        </div>
        <div class="tab-pane" id="sao_dashboard_tab">
            <?php echo $__env->make('bank_dept.senior_account_officer.sao-dashboard', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        </div>
        <?php echo $__env->yieldContent('global_panel'); ?>
    </div>

