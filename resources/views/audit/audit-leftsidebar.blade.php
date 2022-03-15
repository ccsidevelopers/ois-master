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

            <li class="hideToSao">
                <a href="#audit_dashboard_tab" data-toggle="tab" class="audit_a_class">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                </a>
            </li>

            <li class="hideToSao">
                <a href="#audit_log_report_tab" data-toggle="tab" class="audit_a_class">
                    <i class="fa fa-file-text"></i> <span>Audit Forms</span>
                </a>
            </li>

            <li class="" id = "showToAuditHead" hidden>
                <a href="#audit_reports_monitoring" data-toggle="tab" class="audit_a_class">
                    <i class="fa fa-fw fa-table"></i> <span>Audit Reports Monitoring</span>
                </a>
            </li>


            @if(Auth::user()->client_check == 'All Access')
                <li class="active ">
                    <a href="#audit_report_tab" data-toggle="tab" class="audit_a_class">
                        <i class="fa fa-bar-chart"></i> <span>Credit Investigation Report</span>
                    </a>
                </li>

                <li class="">
                    <a href="#audit_cc_rep" data-toggle="tab" class="audit_a_class">
                        <i class="fa fa-bar-chart"></i> <span>Tele Encoder Report</span>
                    </a>
                </li>
            @else
                <li class="active ">
                    <a href="#audit_report_tab" data-toggle="tab" class="audit_a_class">
                        <i class="fa fa-bar-chart"></i> <span>Credit Investigation Report</span>
                    </a>
                </li>
            @endif

            <li class="hideToSao">
                <a href="#audit_fund_tab" data-toggle="tab" class="audit_a_class">
                    <i class="fa fa-bar-chart"></i> <span>Fund Request Report</span>
                </a>
            </li>

            <li class="hideToSao">
                <a href="#audit_expense_tab" data-toggle="tab" class="audit_a_class">
                    <i class="fa fa-bar-chart"></i> <span>C.I Expenses Report</span>
                </a>
            </li>

            <li class="header">OTHERS</li>
            <li>
                <a href="#" id="btnTriggerCIdirectory" data-toggle="modal" data-target="#modal-ci-direct">
                    <i id="SuggestBtn"  class="glyphicon glyphicon-book"></i> <span>CI Directory</span>
                </a>
            </li>
            @include('layouts.includes.leftsidebarGeneralContent')
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>

<div class="tab-content">
    <div class="tab-pane" id="audit_dashboard_tab">
        @include('audit.audit-dashboard')
    </div>
    <div class="tab-pane" id="audit_log_report_tab">
        @include('audit.audit-log-report')
    </div>

    @if(Auth::user()->client_check == 'All Access')
        <div class="tab-pane active" id="audit_report_tab">
            @include('audit.audit-report')
        </div>
        <div class="tab-pane" id="audit_cc_rep">
            @include('audit.audit-cc-report')
        </div>
    @else
        <div class="tab-pane active" id="audit_report_tab">
            @include('audit.audit-report')
        </div>
    @endif
    <div class="tab-pane" id="audit_fund_tab">
        @include('audit.audit-fund-report')
    </div>
    <div class="tab-pane" id="audit_reports_monitoring">
        @include('audit.audit-reports-monitoring')
    </div>
    <div class="tab-pane" id="audit_expense_tab">
        @include('audit.audit-ci-expense-report')
    </div>
</div>