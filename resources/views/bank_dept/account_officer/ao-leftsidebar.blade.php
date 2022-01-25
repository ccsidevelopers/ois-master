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
                <a href="#ao_dashboard_tab" data-toggle="tab" class="ao_a_class">
                    <i class="fa fa-dashboard"></i> <span>Map</span>
                </a>
            </li>

            <li class="active">
                <a href="#ao_process_tab" data-toggle="tab" class="ao_a_class">
                    <i class="fa fa-circle-o"></i> Process Account</a>
            </li>

            <li class=>
                <a href="#ao_search_tab" data-toggle="tab" class="ao_a_class">
                    <i class="fa fa-search"></i> <span>Search Account</span>
                </a>
            </li>

            <li class="header">OTHERS</li>
            {{--<li hidden>--}}
                {{--<a href="#" id="" data-toggle="modal" data-target="#modal-view-recipient">--}}
                    {{--<i id="SuggestBtn"  class="fa fa-arrow-right"></i> <span>Email Recipients List</span>--}}
                {{--</a>--}}
            {{--</li>--}}
            <li>
                <a href="#" id="btnTriggerCIdirectory" data-toggle="modal" data-target="#modal-ci-direct">
                    <i id="SuggestBtn"  class="glyphicon glyphicon-book"></i> <span>CI Directory</span>
                </a>
            </li>
            @include('layouts.includes.leftsidebarGeneralContent')
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>

<div class="tab-content">
    <div class="tab-pane" id="ao_dashboard_tab">
        @include('bank_dept.account_officer.ao-dashboard')
    </div>
    <div class="tab-pane active" id="ao_process_tab">
        @include('bank_dept.account_officer.ao-account-process')
    </div>
    <div class="tab-pane" id="ao_search_tab">
        @include('bank_dept.account_officer.ao-endorsement')
    </div>

    @if(Auth::user()->productivity_sao=='Granted')
        <div class="tab-pane" id="sao_productivity_emp">
            @include('bank_dept.senior_account_officer.sao-productivity')
        </div>
    @endif
</div>

{{--RECIPIENT MODAL--}}
<div class="modal fade" id="modal-view-recipient">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Recipient List</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="box box-info">
                            <div class="box-header with-border">
                                <h3 class="box-title">Create/Modify Recipients</h3>
                            </div>
                            {{--//body--}}
                            <div class="form-group">
                                <label for="name_list">List Name:</label>
                                <input type="text" class="form-control" id="name_list" placeholder="list name here">
                            </div>
                            <label>Email Address:</label>
                            <div class="input-group input-group-md">
                                <input id="recip_emails" type="text" class="form-control">
                                <div class="input-group-btn">
                                    <button type="button" style="margin-top: 0.4px" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-expanded="false">To or Cc?
                                        <span class="fa fa-caret-down"></span></button>
                                    <ul class="dropdown-menu">
                                        <li><a href="javascript:void(0)" id="click_to">To:</a></li>
                                        <li><a href="javascript:void(0)" id="click_cc">Cc:</a></li>
                                    </ul>
                                </div>
                                <!-- /btn-group -->
                            </div>
                            <br>
                            <label>To:</label>
                            <select id="ao_list_emails_to" class="select2 select2-hidden-accessible " multiple="" style="width: 100%;" tabindex="-1" aria-hidden="true">

                            </select>
                            <label>Cc:</label>
                            <select id="ao_list_emails_cc" class="select2 select2-hidden-accessible " multiple="" style="width: 100%;" tabindex="-1" aria-hidden="true">

                            </select>
                        </div>
                        <button type="button" class="btn btn-success pull-right" id="btn_recip_save">Save</button>
                        <button type="button" class="btn btn-info pull-right" disabled id="btn_recip_update">Update</button>
                        <button type="button" class="btn btn-info pull-left" id="btn_recip_clear">Clear</button>
                    </div>

                    <div class="col-md-6">
                        <div class="box box-success">
                            <div class="box-header with-border">
                                <h3 class="box-title">Existing Lists</h3>
                            </div>
                            NOTE: Click "View" to update or view your list.
                            {{--//body--}}
                            <table id="recip_table" class="table-hover table-condensed" width="100%">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Action</th>

                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger pull-right" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
{{--END OF RECIPIENT MODAL--}}