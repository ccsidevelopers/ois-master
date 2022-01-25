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
                {{--<a href="#admin-staff-monitoring_tab"  data-toggle="tab" class="admin_staff_a_class">--}}
                    {{--<i class="fa fa-fw fa-list"></i> <span>Monitoring (OLD)</span>--}}
                {{--</a>--}}
            {{--</li>--}}

            <li class="active">
                <a href="#admin-staff-monitoring_tab_new"  data-toggle="tab" class="admin_staff_a_class">
                    <i class="fa fa-fw fa-list"></i> <span>Monitoring (NEW)</span>
                </a>
            </li>

            {{--<li class="" id = "removeViewProfile">--}}
                {{--<a href="#admin-staff-profile_tab"  data-toggle="tab" class="admin_staff_a_class">--}}
                    {{--<i class="fa fa-fw fa-briefcase"></i> <span>Item Profile</span>--}}
                {{--</a>--}}
            {{--</li>--}}

            {{--<li class="" id = "removeViewRequest">--}}
                {{--<a href="#admin-staff-request_tab"  data-toggle="tab" class="admin_staff_a_class">--}}
                    {{--<i class="fa fa-paper-plane-o"></i> <span>Request(Not Available)</span>--}}
                {{--</a>--}}
            {{--</li>--}}



            @include('layouts.includes.adminStaffLeftSidebar')

            <li class="">
                <a href="#admin-staff-equipment-gen"  data-toggle="tab" class="admin_staff_a_class">
                    <i class="fa fa-fw fa-file-pdf-o"></i> <span>Requisition General Monitoring</span>
                </a>
            </li>




            <li class="" id = "removeViewFund">
                <a href="#admin-staff-fund_tab"  data-toggle="tab" class="admin_staff_a_class">
                    <i class="fa fa-fw fa-bank"></i> <span>Monitoring of Fund Request</span>
                </a>
            </li>

            <li class="">
                <a href="#admin-staff-emp-status-tab"  data-toggle="tab" class="admin_staff_a_class">
                    <i class="fa fa-fw fa-group"></i> <span> Employee Information</span>
                </a>
            </li>

            <li class="" id = "removeViewQr">
                <a href="#admin-staff-generate-qr-code"  data-toggle="tab" class="admin_staff_a_class">
                    <i class="fa fa-fw fa-qrcode"></i> <span> Generate QR Code</span>
                </a>
            </li>



            {{--<li class="">--}}
                {{--<a href="#admin-staff-inventory_tab"  data-toggle="tab" class="admin_staff_a_class">--}}
                    {{--<i class="fa fa-cubes"></i> <span>Inventory</span>--}}
                {{--</a>--}}
            {{--</li>--}}

            <li>
                <a href="#" data-toggle="modal" data-target="#modal-logs" id ="item_logs">
                 <i class = "fa fa-fw fa-tasks"></i>   <span>Logs</span>
                </a>
            </li>
            <li class="header">OTHERS</li>



            {{--<li>--}}
                {{--<a href="#" id="btnTriggerArea" data-toggle="modal" data-target="#modal-default">--}}
                    {{--<i id="SuggestBtn"  class="glyphicon glyphicon-comment"></i> <span>Suggestion Box/Report</span>--}}
                {{--</a>--}}
            {{--</li>--}}
            {{--<li>--}}
                {{--<a href="#" data-toggle="modal" data-target="#modal-change-password">--}}
                    {{--<i class="glyphicon glyphicon-cog"></i> <span>Change Password</span>--}}
                {{--</a>--}}
            {{--</li>--}}

            {{--<li id = "removeViewSupp">--}}
                {{--<a href="#" data-toggle="modal" data-target="#modal-add-supplier" id ="supplierOptions">--}}
                    {{--<i class="fa fa-fw fa-plus-square"></i> <span>Supplier</span>--}}
                {{--</a>--}}
            {{--</li>--}}

            <li id = "docuLoad">
                <a href="#" data-toggle="modal" data-target="#modal-viewDocu">
                    <i class="fa fa-fw fa-file"></i> <span>General Forms</span>
                </a>
            </li>

            <li>
                <a href="" data-toggle="modal" data-target="#modal-add-item-selection">
                    <i class="glyphicon glyphicon-folder-open"></i> <span>Add Item (Inventory)</span>
                </a>
            </li>

            {{--<li>--}}
                {{--<a href="" data-toggle="modal" data-target="#modal-po_form">--}}
                    {{--<i class="fa fa-file-pdf-o"></i> <span>Purchase Order Form</span>--}}
                {{--</a>--}}
            {{--</li>--}}

            <li>
                <a href="" data-toggle="modal" data-target="#modal-ar_form">
                    <i class="fa fa-file-text"></i> <span>Send A.R</span>
                </a>
            </li>

            @include('layouts.includes.leftsidebarGeneralContent')
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>

<div class="tab-content">
    <div class="tab-pane" id="admin-staff-monitoring_tab">
        @include('admin_staff.admin-staff-general-monitoring')
    </div>

    <div class="tab-pane active" id="admin-staff-monitoring_tab_new">
        @include('admin_staff.admin-staff-general-monitoring-new')
    </div>

    <div class="tab-pane" id="admin-staff-profile_tab">
        @include('admin_staff.admin-staff-profile')
    </div>

    <div class="tab-pane" id="admin-staff-request_tab">
        @include('admin_staff.admin-staff-request')
    </div>

    <div class="tab-pane" id="admin-staff-requisition-approval-tab">
        @include('admin_staff.admin-staff-equipment-request')
    </div>
{{--//--}}
    <div class="tab-pane" id="admin-staff-equipment-processing-tab">
        @include('admin_staff.admin-staff-equipment-process')
    </div>

    <div class="tab-pane" id="admin-staff-equipment-gen">
        @include('admin_staff.admin-staff-requi-general-mon')
    </div>
{{--//--}}


    <div class="tab-pane" id="admin-staff-fund_tab">
        @include('admin_staff.admin-staff-monitoring-fund')
    </div>

    <div class="tab-pane" id="admin-staff-emp-status-tab">
        @include('admin_staff.admin-staff-employee-monitor')
    </div>

    <div class="tab-pane" id="admin-staff-generate-qr-code">
        @include('admin_staff.admin-staff-generate-qr')
    </div>

    <div class="tab-pane" id="admin-staff-accredit-supplier">
        @include('admin_staff.admin-staff-accredited-supplier')
    </div>



    <div class="tab-pane" id="admin-staff-inventory_tab">
        @include('admin_staff.admin-staff-inventory')
    </div>

    <div class="tab-pane" id="admin-staff-incident-report-tab">
        @include('admin_staff.admin-staff-incident-report-moni')
    </div>

</div>