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
        <a href="#ci_supervisor_dash"  data-toggle="tab" class="ci_supervisor_class">
    <i class="fa fa-dashboard"></i> <span>Dashboard</span>
    </a>
    </li>

    <li class="active">
        <a href="#ci_supervisor_accounts"  data-toggle="tab" class="ci_supervisor_class">
            <i class="fa fa-users"></i> <span>CI Accounts Monitoring</span>
        </a>
    </li>
    {{--<li class="">--}}
        {{--<a href="#ci_supervisor_fund_req"  data-toggle="tab" class="ci_supervisor_class">--}}
            {{--<i class="glyphicon glyphicon-share"></i> <span>CI Fund Request</span>--}}
        {{--</a>--}}
    {{--</li>--}}
    <li class="">
        <a href="#ci_supervisor_realtime_fund"  data-toggle="tab" class="ci_supervisor_class">
            <i class="glyphicon glyphicon-rub"></i> <span>Realtime CI Funds</span>
        </a>
    </li>
    <li class="">
        <a href="#ci_supervisor_search_accounts"  data-toggle="tab" class="ci_supervisor_class">
            <i class="glyphicon glyphicon-search"></i> <span>Account Tracker</span>
        </a>
    </li>

    <li class="class_bi_reports">
        <a href="#ci_supervisor_bi_reports"  data-toggle="tab" class="">
            <i class="glyphicon glyphicon-briefcase"></i> <span>B.I Reports</span>
        </a>
    </li>

    <li class="">
        <a href="#ci_sup_fa_monitoring_tab" id="clickFAToAccess" data-toggle="tab" class="ci_supervisor_class">
            <i class="fa fa-table"></i> <span>C.I expenses monitoring</span>
        </a>
    </li>

    {{--<li class="">--}}
        {{--<a href="#cc_tele_general_search"  data-toggle="tab" class="cc_tele_side_class">--}}
            {{--<i class="fa fa-search"></i> <span>Search Accounts</span>--}}
        {{--</a>--}}
    {{--</li>--}}

    <li class="header">OTHERS</li>
    <li>
        <a href="#" id="btnTriggerCIdirectory" data-toggle="modal" data-target="#modal-ci-direct">
            <i id="SuggestBtn" class="glyphicon glyphicon-book"></i> <span>CI Directory</span>
        </a>
    </li>
    @include('layouts.includes.leftsidebarGeneralContent')
    <li id = "docuLoad">
        <a href="#" data-toggle="modal" data-target="#modal-downloadable-file">
            <i class="fa fa-fw fa-file"></i> <span>Downloadable Template</span>
        </a>
    </li>
</ul>
</section>
<!-- /.sidebar -->
</aside>

<div class="tab-content">
    <div class="tab-pane" id="ci_supervisor_dash">
        @include('ci_supervisor.ci-supervisor-dashboard')
    </div>
    <div class="tab-pane active" id="ci_supervisor_accounts">
        @include('ci_supervisor.ci-supervisor-accounts')
    </div>
    <div class="tab-pane" id="ci_supervisor_fund_req">
        @include('ci_supervisor.ci-supervisor-fund-request')
    </div>
    <div class="tab-pane" id="ci_supervisor_realtime_fund">
        @include('ci_supervisor.ci-supervisor-realtime-fund')
    </div>
    <div class="tab-pane" id="ci_supervisor_search_accounts">
        @include('ci_supervisor.ci-supervisor-accounttracker')
    </div>
    <div class="tab-pane" id="ci_supervisor_bi_reports">
        @include('ci_supervisor.ci-supervisor-bi-reports')
    </div>
    <div class="tab-pane" id="ci_sup_fa_monitoring_tab">
        @include('ci_supervisor.ci-supervisor-fa-monitoring')
    </div>
    @if(Auth::user()->productivity_sao=='Granted')
        <div class="tab-pane" id="sao_productivity_emp">
            @include('bank_dept.senior_account_officer.sao-productivity')
        </div>
    @endif
</div>