<aside class="main-sidebar affix">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
    @include('bank_dept.ci.template.includes.leftsidebarName')
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

            <li class="{{ $page == "ci-endorse" ? "active" : "" }}">
                <a href="{{ route('ci-endorse') }}">
                    <i class="fa fa-dashboard"></i> <span>Endorsed Account</span>
                </a>
            </li>

            <li class="{{ $page == "ci-fund-receive" ? "active" : "" }}">
                <a href="{{ route('ci-fund-receive') }}">
                    <i class="fa fa-money"></i>
                    <span>Receive Fund</span>
                    <span id="idnotifcisidebar"><span id="notifcount_fund_ci_leftsidebar"></span></span>
                </a>
            </li>

            <li class="{{ $page == "ci-bi-report" ? "active" : "" }}">
                <a href="{{ route('ci-bi-report') }}">
                    <i class="glyphicon glyphicon-search"></i>
                    <span>B.I Reports</span>
                </a>
            </li>

            {{--<li class="{{ $page == "ci-expense-report" ? "active" : "" }}">--}}
                {{--<a href="{{ route('ci-expense-report') }}">--}}
                    {{--<i class="fa fa-file-text"></i>--}}
                    {{--<span>Expense Report</span>--}}
                    {{--<span id="idnotifcisidebar"><span id="notifcount_fund_ci_leftsidebar"></span></span>--}}
                {{--</a>--}}
            {{--</li>--}}

            <li class="header">OTHERS</li>
            @include('layouts.includes.leftsidebarGeneralContent')
            {{--<li>--}}
                {{--<a href="#" data-toggle="modal" data-target="#modal-daily-expenses" id="left_daily_expenses">--}}
                    {{--<i id="show_hide_chat_box_icon"  class="fa fa-edit"></i> <span id="span_chat_box_hide_show">Daily Expenses</span>--}}
                {{--</a>--}}
            {{--</li>--}}

            <li class = "showLogIn">
                <a href="#" data-toggle="modal" data-target="#modal-upload-selfie-daily">
                    <i class="fa fa-clock-o">
                    </i> Daily Attendance</a>
            </li>
        </ul>

    </section>
    <!-- /.sidebar -->
</aside>