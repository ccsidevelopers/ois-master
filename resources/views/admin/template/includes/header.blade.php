<header class="main-header">
    <!-- Logo -->
       <a href="{{ route('general-dashboard') }}" class="logo" style="background: #222d32;">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><img src="{{ asset('dist\img\ccsi-favicon-transparent.png') }}"></span>
        <!-- logo for regular state and mobile devices -->
        <img src="{{ asset('dist\img\ccsi-favicon-transparent.png') }}"><span class="text-uppercase margin">ccsi</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top" style="margin-top: -20px">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <li class="dropdown messages-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="glyphicon glyphicon-link"></i>
                        <span class="label label-success">10</span>
                    </a>
                    <ul class="dropdown-menu" style="background-color: white">
                        {{--START--}}
                        <li class="dropdown-submenu">
                            <a class="test" href="#">Alorica Applications<span class="caret"></span></a>
                            <ul class="dropdown-menu pull-right">
                                <li><a href="https://ccsi-oims.net/alorica-admin/applications" target="_blank">Alorica Admin</a></li>
                                <li><a href="https://ccsi-oims.net/alorica-abb/applications" target="_blank">Alorica ABB </a></li>
                                <li><a href="https://ccsi-oims.net/alorica-cubao/applications" target="_blank">Alorica Cubao </a></li>
                                <li><a href="https://ccsi-oims.net/alorica-alabang/applications" target="_blank">Alorica Alabang</a></li>
                                <li><a href="https://ccsi-oims.net/alorica-centris/applications" target="_blank">Alorica Centris</a></li>
                                <li><a href="https://ccsi-oims.net/alorica-makati/applications" target="_blank">Alorica Makati</a></li>
                                <li><a href="https://ccsi-oims.net/alorica-davao/applications" target="_blank">Alorica Davao</a></li>
                                <li><a href="https://ccsi-oims.net/alorica-fort/applications" target="_blank">Alorica Fort</a></li>
                                <li><a href="https://ccsi-oims.net/alorica-ilocos/applications" target="_blank">Alorica Ilocos</a></li>
                            </ul>
                        </li>
                        {{--END--}}

                        <li class="dropdown-submenu">
                            <a class="test" href="#">Teleperformance Applications<span class="caret"></span></a>
                            <ul class="dropdown-menu pull-right">
                                <li><a href="https://ccsi-oims.net/teleperformance-test/applications" target="_blank">teleperformance Test</a></li>
                                <li><a href="https://ccsi-oims.net/teleperformance-cebu/applications" target="_blank">Teleperformance Cebu</a></li>
                            </ul>
                        </li>

                        <li class="dropdown-submenu">
                            <a class="test" href="#">Sitel Applications<span class="caret"></span></a>
                            <ul class="dropdown-menu pull-right">
                                <li><a href="https://ccsi-oims.net/sitel-test/applications" target="_blank">Sitel Test</a></li>
                                <li><a href="https://ccsi-oims.net/sitel/applications" target="_blank">Sitel</a></li>
                            </ul>
                        </li>

                        <li class="dropdown-submenu">
                            <a class="test" href="#">Qualfon Applications<span class="caret"></span></a>
                            <ul class="dropdown-menu pull-right">
                                <li><a href="https://ccsi-oims.net/qualfon-test/applications" target="_blank">Qualfon Test</a></li>
                                <li><a href="https://ccsi-oims.net/qualfon-manila/applications" target="_blank">Qualfon Manila</a></li>
                                <li><a href="https://ccsi-oims.net/qualfon-dumaguete/applications" target="_blank">Qualfon Dumaguete</a></li>
                                <li><a href="https://ccsi-oims.net/qualfon-corporate/applications" target="_blank">Qualfon Corporate</a></li>
                            </ul>
                        </li>

                        <li class="dropdown-submenu">
                            <a class="test" href="#">CCSI Applications<span class="caret"></span></a>
                            <ul class="dropdown-menu pull-right">
                                <li><a href="https://ccsi-oims.net/ccsi-test/applications" target="_blank">CCSI Test</a></li>
                            </ul>
                        </li>

                        <li class="dropdown-submenu">
                            <a class="test" href="#">TDCX Applications<span class="caret"></span></a>
                            <ul class="dropdown-menu pull-right">
                                <li><a href="https://ccsi-oims.net/tdcx-test/applications" target="_blank">TDCX Test</a></li>
                                <li><a href="https://ccsi-oims.net/tdcx-ortigas/applications" target="_blank">TDCX Ortigas</a></li>
                                <li><a href="https://ccsi-oims.net/tdcx-iloilo/applications" target="_blank">TDCX Iloilo</a></li>
                            </ul>
                        </li>

                        <li class="dropdown-submenu">
                            <a class="test" href="#">Concentrix Applications<span class="caret"></span></a>
                            <ul class="dropdown-menu pull-right">
                                <li><a href="https://ccsi-oims.net/concentrix-test/applications" target="_blank">Concentrix Test</a></li>
                            </ul>
                        </li>

                        <li class="dropdown-submenu">
                            <a class="test" href="#">Ubiquity Applications<span class="caret"></span></a>
                            <ul class="dropdown-menu pull-right">
                                <li><a href="https://ccsi-oims.net/ubiquity/applications" target="_blank">Ubiquity</a></li>
                            </ul>
                        </li>

                        <li class="dropdown-submenu">
                            <a class="test" href="#">PC Applications<span class="caret"></span></a>
                            <ul class="dropdown-menu pull-right">
                                <li><a href="https://ccsi-oims.net/personal-collection/applications" target="_blank">Personal Collection</a></li>
                            </ul>
                        </li>

                        <li class="dropdown-submenu">
                            <a class="test" href="#">Ambica Applications<span class="caret"></span></a>
                            <ul class="dropdown-menu pull-right">
                                <li><a href="https://ccsi-oims.net/ambica/applications" target="_blank">Ambica</a></li>
                            </ul>
                        </li>

                    </ul>
                </li>
                <!-- Messages: style can be found in dropdown.less-->
                <li class="dropdown messages-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-envelope-o"></i>
                        <span class="label label-success">4</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header">You have 4 messages</li>
                        <li>
                            <!-- inner menu: contains the actual data -->
                            <ul class="menu">
                                <li><!-- start message -->
                                    <a href="#">
                                        <div class="pull-left">
                                            <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                                        </div>
                                        <h4>
                                            Support Team
                                            <small><i class="fa fa-clock-o"></i> 5 mins</small>
                                        </h4>
                                        <p>Why not buy a new awesome theme?</p>
                                    </a>
                                </li>
                                <!-- end message -->
                                <li>
                                    <a href="#">
                                        <div class="pull-left">
                                            <img src="dist/img/user3-128x128.jpg" class="img-circle" alt="User Image">
                                        </div>
                                        <h4>
                                            AdminLTE Design Team
                                            <small><i class="fa fa-clock-o"></i> 2 hours</small>
                                        </h4>
                                        <p>Why not buy a new awesome theme?</p>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <div class="pull-left">
                                            <img src="dist/img/user4-128x128.jpg" class="img-circle" alt="User Image">
                                        </div>
                                        <h4>
                                            Developers
                                            <small><i class="fa fa-clock-o"></i> Today</small>
                                        </h4>
                                        <p>Why not buy a new awesome theme?</p>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <div class="pull-left">
                                            <img src="dist/img/user3-128x128.jpg" class="img-circle" alt="User Image">
                                        </div>
                                        <h4>
                                            Sales Department
                                            <small><i class="fa fa-clock-o"></i> Yesterday</small>
                                        </h4>
                                        <p>Why not buy a new awesome theme?</p>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <div class="pull-left">
                                            <img src="dist/img/user4-128x128.jpg" class="img-circle" alt="User Image">
                                        </div>
                                        <h4>
                                            Reviewers
                                            <small><i class="fa fa-clock-o"></i> 2 days</small>
                                        </h4>
                                        <p>Why not buy a new awesome theme?</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="footer"><a href="#">See All Messages</a></li>
                    </ul>
                </li>
                <!-- Notifications: style can be found in dropdown.less -->
                <li class="dropdown notifications-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-bell-o"></i>
                        <span class="label label-warning">10</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header">You have 10 notifications</li>
                        <li>
                            <!-- inner menu: contains the actual data -->
                            <ul class="menu">
                                <li>
                                    <a href="#">
                                        <i class="fa fa-users text-aqua"></i> 5 new members joined today
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-warning text-yellow"></i> Very long description here that may not fit into the
                                        page and may cause design problems
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-users text-red"></i> 5 new members joined
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-shopping-cart text-green"></i> 25 sales made
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-user text-red"></i> You changed your username
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="footer"><a href="#">View all</a></li>
                    </ul>
                </li>
                <!-- Tasks: style can be found in dropdown.less -->
                <li class="dropdown tasks-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-flag-o"></i>
                        <span class="label label-danger">9</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header">You have 9 tasks</li>
                        <li>
                            <!-- inner menu: contains the actual data -->
                            <ul class="menu">
                                <li><!-- Task item -->
                                    <a href="#">
                                        <h3>
                                            Design some buttons
                                            <small class="pull-right">20%</small>
                                        </h3>
                                        <div class="progress xs">
                                            <div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar"
                                                 aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                <span class="sr-only">20% Complete</span>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <!-- end task item -->
                                <li><!-- Task item -->
                                    <a href="#">
                                        <h3>
                                            Create a nice theme
                                            <small class="pull-right">40%</small>
                                        </h3>
                                        <div class="progress xs">
                                            <div class="progress-bar progress-bar-green" style="width: 40%" role="progressbar"
                                                 aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                <span class="sr-only">40% Complete</span>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <!-- end task item -->
                                <li><!-- Task item -->
                                    <a href="#">
                                        <h3>
                                            Some task I need to do
                                            <small class="pull-right">60%</small>
                                        </h3>
                                        <div class="progress xs">
                                            <div class="progress-bar progress-bar-red" style="width: 60%" role="progressbar"
                                                 aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                <span class="sr-only">60% Complete</span>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <!-- end task item -->
                                <li><!-- Task item -->
                                    <a href="#">
                                        <h3>
                                            Make beautiful transitions
                                            <small class="pull-right">80%</small>
                                        </h3>
                                        <div class="progress xs">
                                            <div class="progress-bar progress-bar-yellow" style="width: 80%" role="progressbar"
                                                 aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                <span class="sr-only">80% Complete</span>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <!-- end task item -->
                            </ul>
                        </li>
                        <li class="footer">
                            <a href="#">View all tasks</a>
                        </li>
                    </ul>
                </li>
                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="{{ asset(Auth::user()->pix_path) }}" class="user-image" alt="User Image">
                        <span class="hidden-xs">{{ Auth::user()->name }}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <img src="{{ asset(Auth::user()->pix_path)  }}" class="img-circle" alt="User Image">

                            <p>
                                {{ Auth::user()->name }}
                                <small>{{ Session::get('role') }}</small>
                            </p>
                        </li>
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="#" class="btn btn-default btn-flat">Profile</a>
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
</header>

<script>
    $(document).ready(function(){
        $('.dropdown-submenu a.test').on("click", function(e){
            $(this).next('').toggle();
            e.stopPropagation();
            e.preventDefault();
        });
    });
</script>

