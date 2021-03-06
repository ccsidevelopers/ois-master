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

            @if(Auth::user()->name != 'Individual Client')

            <li id="dashroute" hidden class="">
                <a href="#client_dash_tab_href" class="client_a" data-toggle="tab" id="client_dasboard_tab">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                </a>
            </li>

            <li id="dashendorse" hidden class="active">
                <a href="#client_endo_tab_href" class="client_a" data-toggle="tab" id="client_endo_tab">
                    <i class="fa fa-send"></i> <span>Endorse Account</span>
                </a>
            </li>

            <li class="header">OTHERS</li>
            <li>
                <a href="#" data-toggle="modal" data-target="#modal-change-password">
                    <i class="glyphicon glyphicon-cog"></i> <span>Change Password</span>
                </a>
            </li>

            @else

                <li id="dashendorse" hidden class="active">
                    <a href="#client_endo_tab_href" class="client_a" data-toggle="tab" id="client_endo_tab">
                        <i class="fa fa-send"></i> <span>Endorse Account</span>
                    </a>
                </li>

            @endif

        </ul>
    </section>
    <!-- /.sidebar -->
</aside>

<div class="tab-content">
    <div class="tab-pane" id="client_dash_tab_href">
        @include('client.client-dashboard')
    </div>
    <div class="tab-pane active" id="client_endo_tab_href">
        @include('client.client-endorse-account')
    </div>
</div>