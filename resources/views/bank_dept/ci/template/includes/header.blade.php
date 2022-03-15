<header class="main-header">
    <!-- Logo -->
    <a href="#" class="logo navbar-fixed-top">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>CCSI</b></span>
        <!-- logo for regular state and mobile devices -->
        <img src="{{ asset('dist\img\ccsi-logo.png') }}">
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top navbar-fixed-top">
        <!-- Sidebar toggle button-->
        <a href="#" id="SideBarClick" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span id="idnotifci"><span id="notifcount_fund_ci_header"></span></span>
        </a>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">

                @if(Auth::user()->hasRole('Credit Investigator'))
                    <li class="dropdown messages-menu">
                        <a href="#" data-target="#modal_ci_fund" data-toggle="modal">
                            <span id="realtimefund" style="margin-top: 10px; font-size: medium"></span>
                        </a>
                    </li>
                    <li>
                        <a id="location_Check" href="#" >
                            <i class="glyphicon glyphicon-map-marker"></i>
                        </a>
                    </li>
                @endif

                <!-- Messages: style can be found in dropdown.less-->

                {{--<li class="dropdown messages-menu">--}}

                    {{--<a id="message_click" href="#" class="dropdown-toggle" data-toggle="dropdown">--}}
                        {{--<i class="fa fa-envelope-o"></i>--}}
                        {{--<span class="label label-info" id="notif_message_count"></span>--}}
                        {{--<span class="label label-success" id="notif_message"></span>--}}
                    {{--</a>--}}
                    {{--<ul class="dropdown-menu">--}}
                        {{--<li class="header"><span id="message_count_all"></span></li>--}}
                        {{--<li>--}}
                            {{--<!-- inner menu: contains the actual data -->--}}
                            {{--<ul class="menu">--}}
                                {{--<span class="menu" id="message_info_notif"></span>--}}

                                {{--<!-- start message -->--}}

                                {{--<!-- end message -->--}}

                                {{--<!-- start message -->--}}
                                {{--<li>--}}
                                    {{--<a href="#">--}}
                                        {{--<div class="pull-left">--}}
                                            {{--<img src="dist/img/ccsi-icon.ico" class="img-circle" alt="User Image">--}}
                                        {{--</div>--}}
                                        {{--<h4>--}}
                                            {{--Support Team--}}
                                            {{--<small><i class="fa fa-clock-o"></i> 5 mins</small>--}}
                                        {{--</h4>--}}
                                        {{--<p>coming soon.....</p>--}}
                                    {{--</a>--}}
                                {{--</li>--}}
                                {{--<!-- end message -->--}}

                                {{--<!-- start message -->--}}
                                {{--<li>--}}
                                    {{--<a href="#">--}}
                                        {{--<div class="pull-left">--}}
                                            {{--<img src="dist/img/ccsi-icon.ico" class="img-circle" alt="User Image">--}}
                                        {{--</div>--}}
                                        {{--<h4>--}}
                                            {{--Support Team--}}
                                            {{--<small><i class="fa fa-clock-o"></i> 5 mins</small>--}}
                                        {{--</h4>--}}
                                        {{--<p>coming soon.....</p>--}}
                                    {{--</a>--}}
                                {{--</li>--}}
                                {{--<!-- end message -->--}}

                                {{--<!-- start message -->--}}
                                {{--<li>--}}
                                    {{--<a href="#">--}}
                                        {{--<div class="pull-left">--}}
                                            {{--<img src="dist/img/ccsi-icon.ico" class="img-circle" alt="User Image">--}}
                                        {{--</div>--}}
                                        {{--<h4>--}}
                                            {{--Support Team--}}
                                            {{--<small><i class="fa fa-clock-o"></i> 5 mins</small>--}}
                                        {{--</h4>--}}
                                        {{--<p>coming soon.....</p>--}}
                                    {{--</a>--}}
                                {{--</li>--}}
                                {{--<!-- end message -->--}}

                            {{--</ul>--}}
                        {{--</li>--}}
                        {{--<li class="footer"><a href="#">See All Messages</a></li>--}}
                    {{--</ul>--}}
                {{--</li>--}}
                {{--<!-- Notifications: style can be found in dropdown.less -->--}}
                <li class="dropdown notifications-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-bell-o"></i>
                        {{--NOTIFICATION--}}
                        <span class="label label-warning" id="notifcount_notif"></span>
                        {{--END OF NOTIFICATION--}}
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header" id="notifcount_notif_label"></li>
                        <li>
                            <!-- inner menu: contains the actual data -->
                            <ul class="menu">

                                <span class="menu" id="notifcount_notif_info"></span>

                            </ul>
                        </li>
                        <li class="footer"><a id="viewallhref">View all</a></li>
                    </ul>
                </li>
                <!-- Tasks: style can be found in dropdown.less -->
                {{--<li class="dropdown tasks-menu">--}}
                    {{--<a href="#" class="dropdown-toggle" data-toggle="dropdown">--}}
                        {{--<i class="fa fa-flag-o"></i>--}}
                        {{--NOTIFICATION--}}
                        {{--<span class="label label-danger"></span>--}}
                        {{--END OF NOTIFICATION--}}
                    {{--</a>--}}
                    {{--<ul class="dropdown-menu">--}}
                        {{--<li class="header">You have 9 tasks</li>--}}
                        {{--<li>--}}
                            {{--<!-- inner menu: contains the actual data -->--}}
                            {{--<ul class="menu">--}}
                                {{--<li><!-- Task item -->--}}
                                    {{--<a href="#">--}}
                                        {{--<h3>--}}
                                            {{--coming soon...--}}
                                            {{--<small class="pull-right">20%</small>--}}
                                        {{--</h3>--}}
                                        {{--<div class="progress xs">--}}
                                            {{--<div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar"--}}
                                                 {{--aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">--}}
                                                {{--<span class="sr-only">20% Complete</span>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                    {{--</a>--}}
                                {{--</li>--}}
                                {{--<!-- end task item -->--}}
                                {{--<li><!-- Task item -->--}}
                                    {{--<a href="#">--}}
                                        {{--<h3>--}}
                                            {{--coming soon...--}}
                                            {{--<small class="pull-right">40%</small>--}}
                                        {{--</h3>--}}
                                        {{--<div class="progress xs">--}}
                                            {{--<div class="progress-bar progress-bar-green" style="width: 40%" role="progressbar"--}}
                                                 {{--aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">--}}
                                                {{--<span class="sr-only">40% Complete</span>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                    {{--</a>--}}
                                {{--</li>--}}
                                {{--<!-- end task item -->--}}
                                {{--<li><!-- Task item -->--}}
                                    {{--<a href="#">--}}
                                        {{--<h3>--}}
                                            {{--coming soon...--}}
                                            {{--<small class="pull-right">60%</small>--}}
                                        {{--</h3>--}}
                                        {{--<div class="progress xs">--}}
                                            {{--<div class="progress-bar progress-bar-red" style="width: 60%" role="progressbar"--}}
                                                 {{--aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">--}}
                                                {{--<span class="sr-only">60% Complete</span>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                    {{--</a>--}}
                                {{--</li>--}}
                                {{--<!-- end task item -->--}}
                                {{--<li><!-- Task item -->--}}
                                    {{--<a href="#">--}}
                                        {{--<h3>--}}
                                            {{--coming soon...--}}
                                            {{--<small class="pull-right">80%</small>--}}
                                        {{--</h3>--}}
                                        {{--<div class="progress xs">--}}
                                            {{--<div class="progress-bar progress-bar-yellow" style="width: 80%" role="progressbar"--}}
                                                 {{--aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">--}}
                                                {{--<span class="sr-only">80% Complete</span>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                    {{--</a>--}}
                                {{--</li>--}}
                                {{--<!-- end task item -->--}}
                            {{--</ul>--}}
                        {{--</li>--}}
                        {{--<li class="footer">--}}
                            {{--<a href="#">View all tasks</a>--}}
                        {{--</li>--}}
                    {{--</ul>--}}
                {{--</li>--}}
                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="{{ asset(Auth::user()->pix_path)  }}" class="user-image">
                        <span class="hidden-xs">{{ Auth::user()->name }}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <img src="{{asset(Auth::user()->pix_path)  }}" class="img-circle">

                            <p>
                                {{ Auth::user()->name }}
                                <small>{{ Session::get('role') }}</small>
                            </p>
                        </li>
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="#" class="btn btn-default btn-flat">Edit Display Icon</a>
                            </div>
                            <div class="pull-right">
                                <a href="{{ route('logout') }}" class="btn btn-default btn-flat">Sign out</a>
                            </div>
                        </li>
                    </ul>
                </li>
                <!-- Control Sidebar Toggle Button -->
                {{--<li>--}}
                    {{--<a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>--}}
                {{--</li>--}}
            </ul>
        </div>
    </nav>
    <input type="hidden" id="user-id" value="{{ Auth::user()->id }}">
</header>