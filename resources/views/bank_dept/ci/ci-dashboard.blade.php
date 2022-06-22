@extends('bank_dept.ci.template.master')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <!-- Main content -->
        <section class="content">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    Dashboard
                    <small>Control panel</small>
                </h1>

            </section>
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-aqua">
                        <div class="inner">
                            <h3>{{ $endorsement }}</h3>

                            <p>New Endorsement Account</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-green">
                        <div class="inner">
                            <h3>0<sup style="font-size: 20px">%</sup></h3>

                            <p>Successful TAT Account</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-yellow">
                        <div class="inner">
                            <h3>{{ $overdueAccount }}</h3>

                            <p>Overdue Account</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-red">
                        <div class="inner">
                            <h3>{{ $dueAccount }}</h3>

                            <p>Due Account as of {{ $timeStamp->toFormattedDateString() }}</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-pie-graph"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
            </div>
            <!-- /.row -->

            <center><span id="TextInfoLoc">...</span></center>

            <center><p style="font-size: 20px; margin-bottom: -20px"><b><i>Note: Please make sure to update your location always.</i></b></p><br><br></center>

            <center><button id="BtnUpdateLoc" type="button" class="btn btn-flat" style=" box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2), 0 6px 20px 0 rgba(0,0,0,0.19);
    border: none;
    padding: 20px;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
border-radius: 12px;">
                    <p style="font-size: 20px; margin-bottom: -20px"><b>Click here to update Location</b></p>
                    <br><img src="{{asset("dist/img/updatelocation.png")}}" style="width: 40%">
                </button>
            </center>

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection

@push('leftsidebar')
    @include('bank_dept.ci.ci-leftsidebar')
@endpush

@push('jscript')
    <script src="{{ asset('jscript/getLatLong.js?n='.$javs) }}"></script>
    <script src="{{ asset('jscript/idle/jquery.idle.js?n='.$javs) }}"></script>
    <script src="{{ asset('jscript/detect-user-idle.js?n='.$javs) }}"></script>
    <script src="{{ asset('jscript/ci.js?n='.$javs) }}"></script>
@endpush