<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ asset(Auth::user()->pix_path)  }}" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{{ Auth::user()->name }}</p>
                <i class="fa fa-circle text-danger"></i> Online
            </div>
        </div>
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

            <li class="{{ $page == "main" ? "active" : "" }}">
                <a href="{{ route('general-dashboard') }}">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                </a>
            </li>

            <li class="{{ $page == "accountmonitoring" ? "active" : "" }}">
                <a href="{{ route('account-monitoring') }}">
                    <i class="fa fa-envelope"></i> <span>Endorsement Account</span>
                </a>
            </li>


            <li class="treeview {{ $page == "dispatch" ? "active" : "" }} {{ $page == "ci-management" ? "active" : "" }}">
                <a href="#">
                    <i class="fa fa-users"></i> <span>Dispatcher Panel</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ $page == "dispatch" ? "active" : "" }}">
                        <a href="{{ route('dispatch') }}"><i class="fa fa-exchange"></i> Dispatch Account</a>
                    </li>
                    <li class="{{ $page == "ci-management" ? "active" : "" }}">
                        <a href="{{ route('ci-management') }}"><i class="fa fa-motorcycle"></i> C.I Management</a>
                    </li>
                </ul>
            </li>

            <li class="treeview {{ $page == "accountofficer" ? "active" : "" }}">
                <a href="#">
                    <i class="fa fa-dashboard"></i> <span>Account Officer Panel</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ $page == "accountofficer" ? "active" : "" }}">
                        <a href="{{ route('account-officer') }}"><i class="fa fa-circle-o"></i> Process Account</a>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-circle-o"></i> List of Account</a>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-circle-o"></i> Report</a>
                    </li>
                </ul>
            </li>

            <li class="header">LABELS</li>
            <li><a href="#"><i class="fa fa-circle-o text-red"></i> <span>Important</span></a></li>
            <li><a href="#"><i class="fa fa-circle-o text-yellow"></i> <span>Warning</span></a></li>
            <li><a href="#"><i class="fa fa-circle-o text-aqua"></i> <span>Information</span></a></li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>

