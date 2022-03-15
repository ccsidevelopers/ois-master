<aside class="main-sidebar">
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

            {{--<li class="">--}}
                {{--<a href="#finance_dashboard_tab" data-toggle="tab" class="finance_a_class">--}}
                    {{--<i class="fa fa-dashboard"></i> <span>Dashboard</span>--}}
                {{--</a>--}}
            {{--</li>--}}

            {{--<li class="active">--}}
                {{--<a href="#finance_report_tab" data-toggle="tab" class="finance_a_class">--}}
                    {{--<i class="fa fa-bar-chart"></i><span>Finance Report</span>--}}
                {{--</a>--}}
            {{--</li>--}}

            <li id="hideUploadertoAccess">
                <a href="#ci_fund_tab" id = "clickUploadertoAccess" data-toggle="tab" class="finance_a_class">
                    <i class="fa fa-fw fa-get-pocket"> </i><span>Uploader</span>
                    <span id="finance_fund_req_notif" class="pull-right-container"></span>
                </a>
            </li>

            <li id="hideFaAccess">
                <a href="#fa_monitoring_tab" id = "clickFAToAccess" data-toggle="tab" class="finance_a_class">
                    <i class="fa fa-fw fa-money"></i> <span>FA - Expenses Monitoring</span>
                </a>
            </li>

            {{--<li class="">--}}
                {{--<a href="#finance_atm_tab" data-toggle="tab" class="finance_a_class">--}}
                    {{--<i class="fa fa-credit-card"></i><span>ATM/Card Management</span>--}}
                {{--</a>--}}
            {{--</li>--}}

            <li id="hideBillingAccess">
                <a href="#billing_manage_tab" id = "clickBillingToAccess" data-toggle="tab" class="finance_a_class">
                    <i class="fa fa-bar-chart"></i> <span>Billing</span>
                </a>
            </li>

            <li class="hideOtherAccess">
                <a href="#finance_acc_payable" data-toggle="tab" class="finance_a_class">
                    <i class="fa fa-fw fa-bank"></i> <span>AP - Accounts Payable</span>
                </a>
            </li>

            <li class="hideOtherAccess">
                <a href="#finance_payroll" data-toggle="tab" class="finance_a_class">
                    <i class="fa fa-fw fa-group"></i> <span>Payroll</span>
                </a>
            </li>

            <li class="hidePOAccess">
                <a href="#finance_admin_requi" data-toggle="tab" class="finance_a_class">
                    <i class="fa fa-fw fa-file-pdf-o"></i> <span>Admin Requisition</span>
                </a>
            </li>

            <li class="header">OTHERS</li>
            @include('layouts.includes.leftsidebarGeneralContent')
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>

<div class="tab-content">
    <div class="tab-pane" id="finance_dashboard_tab">
        @include('finance.finance-dashboard')
    </div>
    {{--<div class="tab-pane active" id="finance_report_tab">--}}
        {{--@include('finance.finance-report')--}}
    {{--</div>--}}
    <div class="tab-pane" id="ci_fund_tab">
        @include('finance.finance-ci-fund-request')
    </div>
    <div class="tab-pane" id="fa_monitoring_tab">
        @include('finance.finance-expenses-monitoring')
    </div>
    {{--<div class="tab-pane" id="finance_atm_tab">--}}
        {{--@include('finance.finance-ci-atm-management')--}}
    {{--</div>--}}
    <div class="tab-pane" id="billing_manage_tab">
        @include('finance.finance-billing-rate')
    </div>
    <div class="tab-pane" id="finance_acc_payable">
        @include('finance.finance-accounts-payable')
    </div>
    <div class="tab-pane" id="finance_payroll">
        @include('finance.finance-payroll')
    </div>
    <div class="tab-pane" id="finance_admin_requi">
        @include('finance.finance-admin-requi')
    </div>


</div>