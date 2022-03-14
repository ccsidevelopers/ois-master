{{--@extends('layouts.master')--}}


{{--@section('content')--}}
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            MAP
            <small>Control panel</small>
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->

        <!-- /.row -->
        {{--MAP--}}
        <div class="box box-primary">
            <div class="box-header with-border">
                <center><h3 class="box-title">CCSI Mapping of Credit Investigators</h3></center>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <table class="table table-bordered">
                    <tbody>
                    <button id="btn_refresh"  class="pull-right btn btn-md btn-primary" type="button" name="btn_refresh" style="margin-bottom: 10px;">REFRESH</button>
                    <p class="pull-right" style="margin-top: 6px">Click "Refresh" to update the map. &nbsp</p>
                    <span id="mapcentertext"></span>

                    <div id="map_wrapper">
                        <div id="map_canvas" class="mapping"></div>
                    </div>

                    </tbody>
                </table>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
{{--@endsection--}}

{{--@push('leftsidebar')--}}
{{--@include('bank_dept.senior_account_officer.sao-leftsidebar')--}}
{{--@endpush--}}

{{--@push('jscript')--}}
{{--<script src="{{ asset('jscript/maps.js') }}"></script>--}}
{{--<script src="{{ asset('jscript/sraccountofficer.js') }}"></script>--}}
{{--@endpush--}}