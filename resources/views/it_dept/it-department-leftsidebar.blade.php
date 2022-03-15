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
                <a href="#it_dept_dashboard"  data-toggle="tab" class="it_dept_leftside_class">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                </a>
            </li>
            <li class="active" id="show_head_it" >
                <a href="#it_dept_monitoring"  data-toggle="tab" class="it_dept_leftside_class">
                    <i class="fa fa-fw fa-table"></i> <span>Checklist Monitoring</span>
                </a>
            </li>
            <li class="" id="">
                <a href="#it_dept_checklist"  data-toggle="tab" class="it_dept_leftside_class">
                    <i class="fa fa-list-alt"></i> <span>Checklist</span>
                </a>
            </li>

            <li class="header">OTHERS</li>
            @include('layouts.includes.leftsidebarGeneralContent')

            <li id="archiveHideShow" hidden>
                <a href="#" id="" data-toggle="modal" data-target="#modal-it-archived">
                    <i id=""  class="fa fa-fw fa-users"></i> <span>CI Archiving</span>
                </a>
            </li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>

<div class="tab-content">

    <div class="tab-pane " id="it_dept_dashboard">
        @include('it_dept.it-department-dashboard')
    </div>
    <div class="tab-pane active" id="it_dept_monitoring">
        @include('it_dept.it-department-monitoring ')
    </div>
    <div class="tab-pane" id="it_dept_checklist">
        @include('it_dept.it-department-checklist')
    </div>
</div>