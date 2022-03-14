@if(Auth::user()->authrequest=='C-Monit')

    {{--<div class="tab-pane active" id="ci_supervisor_accounts">--}}
        {{--@include('ci_supervisor.ci-supervisor-accounts')--}}
    {{--</div>--}}

    <div class="tab-pane active" id="man_track_tab">
        @include('management.managementtracker')
    </div>

    @push('jscript')
        <script src="{{ asset('jscript/endorsement-management.js?n='.$javs) }}"></script>
    @endpush
@endif

@if(Auth::user()->authrequest!='C-Monit')

    <div class="tab-pane active" id="human_resources_dashboard">
        @include('human_resources.human-resources-dashboard')
    </div>
    <div class = "tab-pane" id = "human_resources_employee">
        @include('human_resources.human-resources-employee')
    </div>
    <div class = "tab-pane" id = "human_resources_motor">
        @include('human_resources.human-resources-motor')
    </div>

    <div class = "tab-pane" id = "human_resources_equip">
        @include('human_resources.human-resources-equipments')
    </div>
    <div class = "tab-pane" id = "human_resources_issuance">
        @include('human_resources.human-resources-issuance')
    </div>

@endif

@if(Auth::user()->productivity_sao=='Granted')
    <div class="tab-pane" id="sao_productivity_emp">
        @include('bank_dept.senior_account_officer.sao-productivity')
    </div>
@endif