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
                <a href="#cc_sao_accounts"  data-toggle="tab" class="cc_sao_side_class">
                    <i class="fa fa-users"></i> <span>CC SRAO Panel - Accounts</span>
                </a>
            </li>
            <li>
                <a href="#cc_sao_general_mon"  data-toggle="tab" class="cc_sao_side_class">
                    <i class="fa fa-table"></i> <span>General Monitoring - Accounts</span>
                </a>
            </li>
            <li>
                <a href="#cc_sao_general_search"  data-toggle="tab" class="cc_sao_side_class">
                    <i class="fa fa-search"></i> <span>Search Accounts</span>
                </a>
            </li>
            <li class="class_bi_reports">
                <a href="#cc_sao_bi_reports"  data-toggle="tab" class="cc_sao_side_class">
                    <i class="glyphicon glyphicon-briefcase"></i> <span>B.I Reports</span>
                </a>
            </li>
            <li class="header">OTHERS</li>
            <?php echo $__env->make('layouts.includes.leftsidebarGeneralContent', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

            <li id="cc_tele_direct">
                <a href="teleLevels" id="" data-toggle="modal" data-target="#modal-view-tele-direct" class="cc_sao_side_class">
                    <i class="glyphicon glyphicon-send"></i > <span>Televerifiers Direct Sending</span>
                </a>
            </li>
            <li id="cc_contacts_list">
                <a href="#comp_cont_num_table" id="btn_contact_num_tele" data-toggle="modal" data-target="#modal-view-contacts-grant" class="cc_sao_side_class">
                    <i class="glyphicon glyphicon-earphone"></i > <span>Contact Numbers</span>
                </a>
            </li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>

<div class="tab-content">

    <div class="tab-pane active" id="cc_sao_accounts">
        <?php echo $__env->make('cc_dept.sao.cc-sao-accounts', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    </div>
    <div class="tab-pane" id="cc_sao_dash">
        <?php echo $__env->make('cc_dept.sao.cc-sao-dashboard', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    </div>
    <div class="tab-pane" id="cc_sao_general_mon">
        <?php echo $__env->make('cc_dept.sao.cc-sao-gen-monitoring', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    </div>
    <div class="tab-pane" id="cc_sao_general_search">
        <?php echo $__env->make('cc_dept.sao.cc-sao-general-search', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    </div>
    <div class="tab-pane" id="cc_sao_bi_reports">
        <?php echo $__env->make('cc_dept.sao.cc-sao-bi-reports', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    </div>

    <?php if(Auth::user()->productivity_sao=='Granted'): ?>
        <div class="tab-pane" id="sao_productivity_emp">
            <?php echo $__env->make('bank_dept.senior_account_officer.sao-productivity', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        </div>
    <?php endif; ?>

    <?php echo $__env->yieldContent('global_panel'); ?>
</div>