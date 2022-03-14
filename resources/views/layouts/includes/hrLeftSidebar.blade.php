@if(Auth::user()->authrequest=='C-Monit')

    {{--<li class="active">--}}
        {{--<a href="#ci_supervisor_accounts"  data-toggle="tab" class="ci_supervisor_class">--}}
            {{--<i class="fa fa-users"></i> <span>CI Accounts Monitoring</span>--}}
        {{--</a>--}}
    {{--</li>--}}

    <li class="active">
        <a href="#man_track_tab" data-toggle="tab" class="management_a_class">
            <i class="fa fa-send"></i> <span>Account Tracker</span>
        </a>
    </li>

    <li class="header">OTHERS</li>
    @include('layouts.includes.leftsidebarGeneralContent')
    <li>
        <a href="#" data-toggle="modal" data-target="#modal-attendance-general-generation" class="generate_attendance_general_modal">
            <i class="glyphicon glyphicon-calendar"></i> <span>Office Based Attendance</span>
        </a>
    </li>
    <li>
        <a href="#" id="btnTriggerCIdirectory" data-toggle="modal" data-target="#modal-ci-direct">
            <i id="SuggestBtn"  class="glyphicon glyphicon-book"></i> <span>CI Attendance</span>
        </a>
    </li>


@endif

@if(Auth::user()->authrequest!='C-Monit')

    <li class="active">
        <a href="#human_resources_dashboard"  data-toggle="tab" class="human_resources_leftside_class">
            <i class="fa fa-fw fa-user-secret"></i> <span>Profile</span>
        </a>
    </li>
    <li class="">
        <a href="#human_resources_employee"  data-toggle="tab" class="human_resources_leftside_class">
            <i class="fa fa-fw fa-users"></i> <span>Employees</span>
        </a>
    </li>
    <li class="">
        <a href="#human_resources_motor"  data-toggle="tab" class="human_resources_leftside_class">
            <i class="fa fa-fw fa-motorcycle"></i> <span>Motor Monitoring for CI</span>
        </a>
    </li>
    <li class="">
        <a href="#human_resources_equip"  data-toggle="tab" class="human_resources_leftside_class">
            <i class="fa fa-fw fa-send"></i> <span>Equipments(Not Available)</span>
        </a>
    </li>
    <li>
        <a href="#" data-toggle="modal" data-target="#modal-logs" id ="profile_logs">
            <i class = "fa fa-fw fa-list-alt"></i><span>Logs</span>
        </a>
    </li>
    <li class="">
        <a href="#human_resources_issuance"  data-toggle="tab" class="human_resources_leftside_class">
            <i class="fa fa-fw fa-send"></i> <span>Issuance</span>
        </a>
    </li>

    <li class="header">OTHERS</li>
    @include('layouts.includes.leftsidebarGeneralContent')
    <li id = "docuLoad">
        <a href="#" data-toggle="modal" data-target="#modal-viewDocu">
            <i class="fa fa-fw fa-file"></i> <span>General Forms</span>
        </a>
    </li>
    <li>
        <a href="#" data-toggle="modal" data-target="#modal-generate-201">
            <i class="fa fa-fw fa-cloud-download"></i> <span>Generate 201 File</span>
        </a>
    </li>
    <li>
        <a href="#" id="btnTriggerCIdirectory" data-toggle="modal" data-target="#modal-ci-direct">
            <i id="SuggestBtn"  class="glyphicon glyphicon-book"></i> <span>CI Directory</span>
        </a>
    </li>
@endif

