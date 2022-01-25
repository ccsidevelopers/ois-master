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
            {{--<a href="#cc_tele_dash"  data-toggle="tab" class="cc_tele_side_class">--}}
            {{--<i class="fa fa-dashboard"></i> <span>Dashboard</span>--}}
            {{--</a>--}}
            {{--</li>--}}

            <li class="active">
                <a href="#cc_tele_accounts"  data-toggle="tab" class="cc_tele_side_class">
                    <i class="fa fa-users"></i> <span>Accounts</span>
                </a>
            </li>

            <li class="">
                <a href="#cc_tele_general_search"  data-toggle="tab" class="cc_tele_side_class">
                    <i class="fa fa-search"></i> <span>Search Accounts</span>
                </a>
            </li>

            <li class="header">OTHERS</li>
            @include('layouts.includes.leftsidebarGeneralContent')

            <li id = "docuLoad">
                <a href="#" data-toggle="modal" data-target="#modal-downloadable-file">
                    <i class="fa fa-fw fa-file"></i> <span>Downloadable Forms</span>
                </a>
            </li>

            <li id="cc_contacts_list">
                <a href="#comp_cont_num_table" id="btn_contact_num_tele" data-toggle="modal" data-target="#modal-view-contacts" class="cc_tele_side_class">
                    <i class="glyphicon glyphicon-earphone"></i > <span>Contact Numbers</span>
                </a>
            </li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>

<div class="tab-content">
    <div class="tab-pane" id="cc_tele_dash">
        @include('cc_dept.tele-encoder.cc-tele-encoder-dashboard')
    </div>
    <div class="tab-pane active" id="cc_tele_accounts">
        @include('cc_dept.tele-encoder.cc-tele-encoder-accounts')
    </div>
    <div class="tab-pane" id="cc_tele_general_search">
        @include('cc_dept.tele-encoder.cc-tele-encoder-general-search')
    </div>
</div>