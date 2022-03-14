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

            <li class="disp_li_class">
                <a href="#disp_dashboard_tab" data-toggle="tab" class="disp_a_class">
                    <i class="fa fa-dashboard">
                    </i> <span>Map</span>
                </a>
            </li>

            <li class="disp_li_class active">
                <a href="#disp_account_tab" data-toggle="tab" class="disp_a_class">
                    <i class="fa fa-exchange">
                    </i> Dispatch Account</a>
            </li>
            <li class="disp_li_class">
                <a href="#disp_history_tab" data-toggle="tab" class="disp_a_class">
                    <i class="fa fa-motorcycle">
                    </i> Dispatch History</a>
            </li>

            <li class="disp_li_class">
                <a href="#disp_fund_tab" data-toggle="tab" id="disp_fund_id_if" class="disp_a_class">
                    <i class="fa fa-credit-card">
                    </i> <span>Fund Request</span>
                </a>
            </li>

            <li class="disp_li_class">
                <a href="#disp_fa_monitoring_tab" id = "clickFAToAccess" data-toggle="tab" class="disp_a_class">
                    <i class="fa fa-money"></i> <span>C.I expenses monitoring</span>
                </a>
            </li>

            <li class="disp_li_class">
                <a href="#disp_search_tab" data-toggle="tab" class="disp_a_class">
                    <i class="fa fa-search">
                    </i> <span>Search Account</span>
                </a>
            </li>

            <li class="header">OTHERS</li>
            <li>
                <a href="#" id="btnTriggerCIdirectory" data-toggle="modal" data-target="#modal-ci-direct">
                    <i id="SuggestBtn"  class="glyphicon glyphicon-book"></i> <span>CI Directory</span>
                </a>
            </li>

            <li>
                <a href="#" id="triggreDirectText" data-toggle="modal" data-target="#modal-sms">
                    <i class="glyphicon glyphicon-send"></i> <span>Send SMS</span>
                </a>
            </li>
            @include('layouts.includes.leftsidebarGeneralContent')

        </ul>
    </section>
    <!-- /.sidebar -->
</aside>

    <div class="tab-content">
        <div class="tab-pane" id="disp_dashboard_tab">
            @include('bank_dept.dispatcher.dispatcher-dashboard')
        </div>
        <div class="tab-pane active" id="disp_account_tab">
            @include('bank_dept.dispatcher.dispatcher-dispatch-account')
        </div>
        <div class="tab-pane" id="disp_history_tab">
            @include('bank_dept.dispatcher.dispatcher-ci-management')
        </div>
        <div class="tab-pane" id="disp_fund_tab">
            @include('bank_dept.dispatcher.dispatcher-fund-request')
        </div>
        <div class="tab-pane" id="disp_fa_monitoring_tab">
            @include('bank_dept.dispatcher.dispatcher-fa-monitoring')
        </div>
        <div class="tab-pane" id="disp_search_tab">
            @include('bank_dept.dispatcher.dispatcher-endorsement')
        </div>
        @if(Auth::user()->productivity_sao=='Granted')
            <div class="tab-pane" id="sao_productivity_emp">
                @include('bank_dept.senior_account_officer.sao-productivity')
            </div>
        @endif
    </div>