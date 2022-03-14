<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{asset(Auth::user()->pix_path)}}" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{{ Auth::user()->name }}</p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
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

            <li class="{{ $page == "admindashboard" ? "active" : "" }}">
                <a href="{{ route('admin-dashboard') }}">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                </a>
            </li>

            <li class="{{ $page == "usermanagement" ? "active" : "" }}">
                <a href="{{ route('admin-user-management') }}">
                    <i class="fa fa-dashboard"></i> <span>User Management</span>
                </a>
            </li>

            <li class="{{ $page == "formmanagement" ? "active" : "" }}">
                <a href="{{ route('admin-form-management') }}">
                    <i class="fa fa-dashboard"></i> <span>Form Management</span>
                </a>
            </li>

            <li class="{{ $page == "accountmanagement" ? "active" : "" }}">
                <a href="{{ route('admin-account-management') }}">
                    <i class="fa fa-dashboard"></i> <span>Account Management</span>
                </a>
            </li>

            <li class="{{ $page == "datamanagement" ? "active" : "" }}">
                <a href="{{ route('admin-data-management') }}">
                    <i class="fa fa-dashboard"></i> <span>Data Management</span>
                </a>
            </li>

            <li class="{{ $page == "ci_contacts" ? "active" : "" }}">
                <a href="{{ route('ci_contact_list_checker') }}">
                    <i class="fa fa-dashboard"></i> <span>C.I Contact Number</span>
                </a>
            </li>
            
            <li class="{{ $page == "filemanager" ? "active" : "" }}">
                <a href="{{ route('file-manager') }}" id="file_manage">
                    <i class="fa fa-files-o"></i> <span>File Manager</span>
                </a>
            </li>

            <li class="header">LABELS</li>
            <li>
                <a style="cursor: pointer" class="attendance_general_modal">
                    <i class="glyphicon glyphicon-time"></i> <span>Attendance</span>
                </a>
            </li>
            <li><a href="#" data-toggle="modal" data-target="#modal-disable-web" id="btnLeftDownWeb"><i class="fa fa-circle-o text-red"></i> <span>Maintenance</span></a></li>

            <li><a href="#" data-toggle="modal" data-target="#modal-check-bday-contract" id=""><i class="fa fa-circle-o text-green"></i> <span>Check Birthday/Contract</span></a></li>

            <li><a href="#" data-toggle="modal" data-target="#modal-login-accessibility" id="moda_click_login_access"><i class="fa fa-circle-o text-blue"></i> <span>Login Accessibility</span></a></li>

        </ul>
    </section>
    <!-- /.sidebar -->
</aside>

