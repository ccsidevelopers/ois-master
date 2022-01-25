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

            {{--<li class="">--}}
            {{--<a href="#cc_ao_dash"  data-toggle="tab" class="cc_ao_side_class">--}}
            {{--<i class="fa fa-dashboard"></i> <span>Dashboard</span>--}}
            {{--</a>--}}
            {{--</li>--}}

            <li class="active">
                <a href="#cc_ao_accounts"  data-toggle="tab" class="cc_ao_side_class">
                    <i class="fa fa-users"></i> <span>CC AO Panel - Accounts</span>
                </a>
            </li>
            <li>
                <a href="#cc_ao_general_mon"  data-toggle="tab" class="cc_ao_side_class">
                    <i class="fa fa-table"></i> <span>General Monitoring - Accounts</span>
                </a>
            </li>
            <li>
                <a href="#cc_ao_general_search"  data-toggle="tab" class="cc_ao_side_class">
                    <i class="fa fa-search"></i><span>Search Accounts</span>
                </a>
            </li>
            <li class="class_bi_reports">
                <a href="#cc_ao_bi_reports"  data-toggle="tab" class="cc_sao_side_class">
                    <i class="glyphicon glyphicon-briefcase"></i> <span>B.I Reports</span>
                </a>
            </li>
            <li class="header">OTHERS</li>
            @include('layouts.includes.leftsidebarGeneralContent')

            <li id="cc_contacts_list">
                <a href="#comp_cont_num_table" id="btn_contact_num_tele" data-toggle="modal" data-target="#modal-view-contacts-grant" class="cc_ao_side_class">
                    <i class="glyphicon glyphicon-earphone"></i > <span>Contact Numbers</span>
                </a>
            </li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>

<div class="tab-content">

    <div class="tab-pane active" id="cc_ao_accounts">
        @include('cc_dept.ao.cc-ao-accounts')
    </div>
    <div class="tab-pane" id="cc_ao_general_mon">
        @include('cc_dept.ao.cc-ao-gen-monitoring')
    </div>
    <div class="tab-pane" id="cc_ao_dash">
        @include('cc_dept.ao.cc-ao-dashboard')
    </div>
    <div class="tab-pane" id="cc_ao_general_search">
        @include('cc_dept.ao.cc-ao-general-search')
    </div>
    <div class="tab-pane" id="cc_ao_bi_reports">
        @include('cc_dept.ao.cc-ao-bi-reports')
    </div>
    @if(Auth::user()->productivity_sao=='Granted')
        <div class="tab-pane" id="sao_productivity_emp">
            @include('bank_dept.senior_account_officer.sao-productivity')
        </div>
    @endif
</div>