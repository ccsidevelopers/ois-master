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

            <?php echo $__env->make('layouts.includes.hrLeftSidebar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

        </ul>
    </section>
    <!-- /.sidebar -->
</aside>

<div class="tab-content">

    <?php echo $__env->make('layouts.includes.hrActiveTabs', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

</div>