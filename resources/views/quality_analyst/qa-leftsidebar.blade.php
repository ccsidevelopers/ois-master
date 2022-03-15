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
                <a href="#qa_dashboard"  data-toggle="tab" class="qa_leftside_class">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                </a>
            </li>
            @if(Auth::user()->authrequest == 'All Access')
                <li class="">
                    <a href="#qa_accnt_tracker"  data-toggle="tab" class="qa_leftside_class">
                        <i class="fa fa-send"></i> <span>Bank C.I Account Tracker</span>
                    </a>
                </li>
                <li class="">
                    <a href="#qa_bi_accnt_tracker"  data-toggle="tab" class="qa_leftside_class">
                        <i class="fa fa-send"></i> <span>TELE Account Tracker</span>
                    </a>
                </li>
            @elseif(Auth::user()->authrequest == 'Bank Only')
                <li class="">
                    <a href="#qa_accnt_tracker"  data-toggle="tab" class="qa_leftside_class">
                        <i class="fa fa-send"></i> <span>Bank C.I Account Tracker</span>
                    </a>
                </li>
            @elseif(Auth::user()->authrequest == 'CC Only')
                <li class="">
                    <a href="#qa_bi_accnt_tracker"  data-toggle="tab" class="qa_leftside_class">
                        <i class="fa fa-send"></i> <span>TELE Account Tracker</span>
                    </a>
                </li>
            @endif
            <li class="header">OTHERS</li>
            @include('layouts.includes.leftsidebarGeneralContent')
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>

<div class="tab-content">

    <div class="tab-pane active" id="qa_dashboard">
        @include('quality_analyst.qa-dashboard')
    </div>

    @if(Auth::user()->authrequest == 'All Access')
        <div class="tab-pane" id="qa_accnt_tracker">
            @include('quality_analyst.qa-bank-tracker')
        </div>
        <div class="tab-pane" id="qa_bi_accnt_tracker">
            @include('quality_analyst.qa-bi-accnt-tracker')
        </div>
    @elseif(Auth::user()->authrequest == 'Bank Only')
        <div class="tab-pane" id="qa_accnt_tracker">
            @include('quality_analyst.qa-bank-tracker')
        </div>
    @elseif(Auth::user()->authrequest == 'CC Only')
        <div class="tab-pane" id="qa_bi_accnt_tracker">
            @include('quality_analyst.qa-bi-accnt-tracker')
        </div>
    @endif
</div>