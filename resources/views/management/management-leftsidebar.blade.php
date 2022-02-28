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

            @if(Auth::user()->client_check == 'all_access')
            <li class="">
                <a href="#man_dashboard_tab" data-toggle="tab" class="management_a_class">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                </a>
            </li>

                <li class="active">
                    <a href="#man_track_tab" data-toggle="tab" class="management_a_class">
                        <i class="fa fa-send"></i> <span>BANK C.I Account Tracker</span>
                    </a>
                </li>

                <li class="">
                    <a href="#man_tele_track_tab" data-toggle="tab" class="management_a_class">
                        <i class="fa fa-send"></i> <span>TELE Account Tracker</span>
                    </a>
                </li>

            <li class="">
                <a href="#man_audit_tab" data-toggle="tab" class="management_a_class">
                    <i class="fa fa-user-secret"></i> <span>Audit Trailing</span>
                </a>
            </li>

            <li class="">
                <a href="#man_fund_tab" data-toggle="tab" class="management_a_class">
                    <i class="fa fa-user-secret"></i> <span>Fund Audit Trailing</span>
                </a>
            </li>

            <li class="">
                <a href="#man_report_tab" data-toggle="tab" class="management_a_class">
                    <i class="fa fa-newspaper-o"></i> <span>Report</span>
                </a>
            </li>

            <li class="">
                <a href="#man_ci_fund_req_tab" data-toggle="tab" class="management_a_class">
                    <i class="fa fa-money"></i> <span>C.I Fund Request</span>
                </a>
            </li>

            <li>
                <a href="#man_fa_monitoring_tab" id = "clickFAToAccess" data-toggle="tab" class="management_a_class">
                    <i class="fa fa-table"></i> <span>C.I expenses monitoring</span>
                </a>
            </li>
            <li>
                <a href="#man_accred_sup" data-toggle="tab" class="management_a_class">
                    <i class="fa fa-columns"></i> <span>Supplier Approval</span>
                </a>
            </li>
            @else
            <li class="">
                <a href="#man_dashboard_tab" data-toggle="tab" class="management_a_class">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                </a>
            </li>

            <li class="active">
                <a href="#man_track_tab" data-toggle="tab" class="management_a_class">
                    <i class="fa fa-send"></i> <span>Account Tracker</span>
                </a>
            </li>

            <li class="">
                <a href="#man_ci_fund_req_tab" data-toggle="tab" class="management_a_class">
                    <i class="fa fa-money"></i> <span>C.I Fund Request</span>
                </a>
            </li>

            <li>
                <a href="#man_fa_monitoring_tab" id = "clickFAToAccess" data-toggle="tab" class="management_a_class">
                    <i class="fa fa-table"></i> <span>C.I expenses monitoring</span>
                </a>
            </li>



            @endif

            <li class="">
                <a href="#man_ci_rep_tab" data-toggle="tab" class="class_bi_reports">
                    <i class="glyphicon glyphicon-briefcase"></i> <span>B.I Reports</span>
                </a>
            </li>



            <li class="header">OTHERS</li>
            <li>
                <a href="#" id="btnTriggerCIdirectory" data-toggle="modal" data-target="#modal-ci-direct">
                    <i id="SuggestBtn"  class="glyphicon glyphicon-book"></i> <span>CI Directory</span>
                </a>
            </li>
            @include('layouts.includes.leftsidebarGeneralContent')
            <li>
                <a href="#" data-toggle="modal" data-target="#modal-attendance-general-generation" class="generate_attendance_general_modal">
                    <i class="glyphicon glyphicon-calendar"></i> <span>Generate Attendance</span>
                </a>
            </li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>

<div class="tab-content">
    <div class="tab-pane" id="man_dashboard_tab">
        @include('management.managementmain')
    </div>
    <div class="tab-pane active" id="man_track_tab">
        @include('management.managementtracker')
    </div>
    <div class="tab-pane" id="man_tele_track_tab">
        @include('management.managementtracker_tele')
    </div>
    <div class="tab-pane" id="man_audit_tab">
        @include('management.managementaudit')
    </div>
    <div class="tab-pane" id="man_fund_tab">
        @include('management.managementfundaudit')
    </div>
    <div class="tab-pane" id="man_report_tab">
        @include('management.management-report')
    </div>
    <div class="tab-pane" id="man_ci_fund_req_tab">
        @include('management.management-ci-fund-request')
    </div>
    <div class="tab-pane" id="man_fa_monitoring_tab">
        @include('management.management-fa-monitoring')
    </div>
    <div class="tab-pane" id="man_accred_sup">
        @include('management.management-supplier-approval')
    </div>
    @if(Auth::user()->productivity_sao=='Granted')
        <div class="tab-pane" id="sao_productivity_emp">
            @include('bank_dept.senior_account_officer.sao-productivity')
        </div>
    @endif
    <div class="tab-pane" id="man_ci_rep_tab">
        @include('management.management-bi-reports')
    </div>
</div>