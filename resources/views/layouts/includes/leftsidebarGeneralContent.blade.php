@if(Auth::user()->mrf_check=='Granted')
    {{--<li>--}}
        {{--<a href="#" data-toggle="modal" data-target="#modal-request-panel" id="btnReqPanelItem">--}}
            {{--<i class="glyphicon glyphicon-share"></i> <span>Request Panel</span>--}}
        {{--</a>--}}
    {{--</li>--}}

    <li>
        <a href="#"  id = "passRequi"  data-toggle="tab">
            <i class="fa fa-file"></i> <span>Requisition Form</span>
        </a>
    </li>

@endif

@if(Auth::user()->requi_check=='Granted')
    <li>
        <a href="#" data-toggle="modal" id = "requi_approval_btn">
            <i class="fa fa-file-text"></i> <span>Requisition/Incident Approval</span>
        </a>
    </li>

    @push('jscript')

        <script src="{{ asset('jscript/admin_req.js?n='.$javs) }}"></script>

    @endpush
@endif

<li>
    <a href="#" data-toggle="modal" data-target="#modal-change-password">
        <i class="glyphicon glyphicon-cog"></i> <span>Change Password</span>
    </a>
</li>

@if(!Auth::user()->hasRole ('Credit Investigator'))
<li>
    <a href="#" data-toggle="modal" data-target="#modal-acknowledge-view">
        <i class="fa fa-file-text"></i> <span>Acknowledge Receipt</span>
    </a>
</li>
@endif


<li>
    <a href="#" id="btnTriggerArea" data-toggle="modal" data-target="#modal-default">
        <i id="SuggestBtn"  class="glyphicon glyphicon-comment"></i> <span>Suggestion Box</span>
    </a>
</li>

<li>
    <a href="#" id="" data-toggle="modal" data-target="#modal-incident-report">
        <i id=""  class="glyphicon glyphicon-book"></i> <span>Incident Report</span>
    </a>
</li>




@if(!Auth::user()->hasRole ('Client') && !Auth::user()->hasRole ('Credit Investigator'))
    <li>
        <a style="cursor: pointer" class="attendance_general_modal">
            <i class="glyphicon glyphicon-time"></i> <span>Attendance</span>
        </a>
    </li>
@endif

@if(Auth::user()->productivity_sao=='Granted')
    <li>
        <a href="#sao_productivity_emp" data-toggle="tab" class="a_sao">
            <i class="fa fa-line-chart"></i> <span>Productivity</span>
        </a>
    </li>
@endif

@if(!Auth::user()->hasRole('Credit Investigator'))
<li>
    <a href="#" data-toggle="modal" id="show_hide_chat_box_href">
        <i id="show_hide_chat_box_icon"  class="glyphicon glyphicon-plus"></i> <span id="span_chat_box_hide_show">Show Chat Box
            </span>
        <span id="change_chat_notif_side">
            <span id="newmessagetogs_id" data-toggle="tooltip" title="New Messages" class="newmessagetogs badge bg-red pull-right"></span>
        </span>
    </a>
</li>
@endif

@if(!Auth::user()->hasRole ('Administrator') || !Auth::user()->hasRole ('Client') || !Auth::user()->hasRole ('B.I Client') )
    <li class="hideMeFromCI" hidden>
        <a href="#" id="loadMemoGenTable" data-toggle="modal" data-target="#modal-memorandum-gen">
            <i   class="glyphicon glyphicon-alert"></i> <span>Memorandum/Notice</span>
        </a>
    </li>
@endif

@if(!Auth::user()->hasRole ('Management') || !Auth::user()->hasRole ('Client') || !Auth::user()->hasRole ('B.I Client'))
    <li>
        <a href="#oims_concern_trigger" data-toggle="modal" data-target="#oims_concern_modal" class="oims_concern_class" id="oims_concern_global">
            <i class="fa fa-fw fa-commenting"></i> OIMS concerns
        </a>
    </li>
@endif



