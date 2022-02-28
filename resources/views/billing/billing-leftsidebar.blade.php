<aside class="main-sidebar affix">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
    @include('layouts.includes.leftsidebarName')
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

            <li class="">
                <a href="#billing_dashboard_tab" data-toggle="tab" class="billing_a_class">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                </a>
            </li>

            <li class="active">
                <a href="#billing_manage_tab" data-toggle="tab" class="billing_a_class">
                    <i class="fa fa-bar-chart"></i> <span>Billing Report</span>
                </a>
            </li>

            <li class="">
                <a href="#billing_rate_tab" data-toggle="tab" class="billing_a_class">
                    <i class="fa fa-cogs"></i> <span>Billing Information</span>
                </a>
            </li>

            <li class="header">OTHERS</li>
            @include('layouts.includes.leftsidebarGeneralContent')
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>

<div class="tab-content">
    <div class="tab-pane" id="billing_dashboard_tab">
        @include('billing.billing-dashboard')
    </div>
    <div class="tab-pane active" id="billing_manage_tab">
        @include('billing.billing-rate')
    </div>
    <div class="tab-pane" id="billing_rate_tab">
        @include('billing.billing-manage')
    </div>
</div>