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

            <li class="active">
                <a href="#marketing_dashboard_tab" data-toggle="tab" class="marketing_a_class">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                </a>
            </li>

            <li class="">
                <a href="#marketing_report_tab" data-toggle="tab" class="marketing_a_class">
                    <i class="fa fa-bar-chart"></i> <span>Marketing Report</span>
                </a>
            </li>

            <li class=" ">
                <a href="#marketing_management_tab" data-toggle="tab" class="marketing_a_class">
                    <i class="fa fa-cogs"></i> <span>Marketing Mgmt. (BANK)</span>
                </a>
            </li>

            <li class=" ">
                <a href="#marketing_management_tab_bi" data-toggle="tab" class="marketing_a_class">
                    <i class="fa fa-cogs"></i> <span>Marketing Mgmt. (B . I)</span>
                </a>
            </li>

            <li class=" ">
                <a href="#modal-all-marketing-logs" data-toggle="modal" id="all_marketing_logs" class="marketing_a_class" style="cursor: pointer;: " data-target="#modal-all-marketing-logs">
                    <i class="glyphicon glyphicon-list-alt"></i> <span>Marketing Over all Logs</span>
                </a>
            </li>

            <li class=" ">
                <a href="#marketing_contract_tab" data-toggle="tab" class="marketing_a_class">
                    <i class="fa fa-balance-scale"></i> <span>Contract</span>
                </a>
            </li>

            <li class=" ">
                <a href="#marketing_client_bday_tab" data-toggle="tab" class="marketing_a_class">
                    <i class="fa fa-calendar"></i> <span>Client Birthday</span>
                </a>
            </li>

            <li class=" ">
                <a href="#marketing_new_client_tab" data-toggle="tab" class="marketing_a_class">
                    <i class="fa fa-user-secret"></i> <span>New Client</span>
                </a>
            </li>

            <li class=" ">
                <a href="#marketing_tat_management" data-toggle="tab" class="marketing_a_class">
                    <i class="fa fa-calendar-times-o"></i> <span>TAT Management</span>
                </a>
            </li>
            <li class="header">OTHERS</li>
            @include('layouts.includes.leftsidebarGeneralContent')
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>

<div class="tab-content">
    <div class="tab-pane active" id="marketing_dashboard_tab">
        @include('marketing.marketing-dashboard')
    </div>
    <div class="tab-pane" id="marketing_report_tab">
        @include('marketing.marketing-report')
    </div>
    <div class="tab-pane" id="marketing_management_tab">
        @include('marketing.marketing-manage')
    </div>
    <div class="tab-pane" id="marketing_management_tab_bi">
        @include('marketing.marketing-manage-bi')
    </div>
    <div class="tab-pane" id="marketing_contract_tab">
        @include('marketing.marketing-contract')
    </div>
    <div class="tab-pane" id="marketing_client_bday_tab">
        @include('marketing.marketing-bday')
    </div>
    <div class="tab-pane" id="marketing_new_client_tab">
        @include('marketing.marketing-new-client')
    </div>
    <div class="tab-pane" id="marketing_tat_management">
        @include('marketing.marketing-tat-management')
    </div>
</div>