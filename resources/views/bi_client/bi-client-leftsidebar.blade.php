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

            <li class="active">
                <a href="#bi_client_endorse"  data-toggle="tab" class="bi_client_side_class">
                    <i class=""></i> <span>ENDORSEMENTS</span>
                </a>
            </li>
            <li class="">
                <a href="#bi_client_dash"  data-toggle="tab" class="bi_client_side_class">
                    <i class=""></i> <span>DASHBOARD</span>
                </a>
            </li>
            <li class="">
                <a href="#bi_client_billing"  data-toggle="tab" class="bi_client_side_class">
                    <i class=""></i> <span>BILLING INFORMATION</span>
                </a>
            </li>
            <li class="header">OTHERS</li>
            <li>
                <a href="#" data-toggle="modal" data-target="#modal-change-password">
                    <i class="glyphicon glyphicon-cog"></i> <span>Change Password</span>
                </a>
            </li>
            <li>
                <a href="#" id="btnTriggerArea" data-toggle="modal" data-target="#modal-default">
                    <i id="SuggestBtn"  class="glyphicon glyphicon-comment"></i> <span>Suggestion Box</span>
                </a>
            </li>
            {{--@include('layouts.includes.leftsidebarGeneralContent')--}}
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>

<div class="tab-content">

    <div class="tab-pane active" id="bi_client_endorse">
        @include('bi_client.bi-client-endorsement')

    </div>
    <div class = "tab-pane" id = "bi_client_dash">
        @include('bi_client.bi-client-dashboard')
    </div>
    <div class = "tab-pane" id = "bi_client_billing">
        @include('bi_client.bi-client-billing')
    </div>

</div>