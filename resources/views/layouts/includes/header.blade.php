<header class="main-header">
    <!-- Logo -->
    <a href="#" class="logo navbar-fixed-top" style="background: #222d32;">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><img src="{{ asset('dist\img\ccsi-favicon-transparent.png') }}"> </span>
        <!-- logo for regular state and mobile devices -->
        <img src="{{ asset('dist\img\ccsi-favicon-transparent.png') }}"><span class="text-uppercase margin">ccsi</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top navbar-fixed-top">
        <!-- Sidebar toggle button-->
        <a href="#" id="SideBarClick" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span id="idnotifci"></span>
        </a>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
            @if(Auth::user()->name != 'Individual Client')
                <!-- Messages: style can be found in dropdown.less-->
                <li class="dropdown messages-menu" id = "dropdownBiNotif">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-envelope-o"></i>
                        {{--NOTIFICATION--}}
                        <span class="label label-success" id="notifcount_message"></span>
                        {{--END OF NOTIFICATION--}}
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header" id = "count_all_message">You have 0 messages</li>
                        <li>
                            <!-- inner menu: contains the actual data -->
                            <ul class="menu" id = "messages_bi">

                                <!-- start message -->

                            </ul>
                        </li>
                        <li class="footer"><a href="#">See All Messages</a></li>
                    </ul>
                </li>
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
            <!-- User Account: style can be found in dropdown.less -->
            @endif
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="{{ asset(Auth::user()->pix_path)  }}" class="user-image afterUpload">
                        <span class="hidden-xs">{{ Auth::user()->name }}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <img src="{{asset(Auth::user()->pix_path)  }}" class="img-circle afterUpload">

                            <p>
                                {{ Auth::user()->name }}
                                <small>{{ Session::get('role') }}</small>
                            </p>
                        </li>
                        <li class="user-footer">
                            <div class="pull-left">
                                @if(Auth::user()->name != 'Individual Client')
                                <a href="#" class="change_dp btn btn-default btn-flat" data-toggle="modal" data-target="">Edit Display Icon</a>
                                @endif
                            </div>
                            <div class="pull-right">
                                <a href="{{ route('logout') }}" class="btn btn-default btn-flat">Sign out</a>
                            </div>
                        </li>
                    </ul>
                </li>
                <!-- Control Sidebar Toggle Button -->
                <li>
                    <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                </li>
            </ul>
        </div>

    </nav>
    <input type="hidden" id="user-id" value="{{ Auth::user()->id }}">
</header>