{{--@extends('layouts.master')--}}
{{--<style>--}}
    {{--.just-padding {--}}
        {{--padding: 15px;--}}
    {{--}--}}

    {{--.list-group.list-group-root {--}}
        {{--padding: 0;--}}
        {{--overflow: hidden;--}}
    {{--}--}}

    {{--.list-group.list-group-root .list-group {--}}
        {{--margin-bottom: 0;--}}
    {{--}--}}

    {{--.list-group.list-group-root .list-group-item {--}}
        {{--border-radius: 0;--}}
        {{--border-width: 1px 0 0 0;--}}
    {{--}--}}

    {{--.list-group.list-group-root > .list-group-item:first-child {--}}
        {{--border-top-width: 0;--}}
    {{--}--}}

    {{--.list-group.list-group-root > .list-group > .list-group-item {--}}
        {{--padding-left: 30px;--}}
    {{--}--}}

    {{--.list-group.list-group-root > .list-group > .list-group > .list-group-item {--}}
        {{--padding-left: 45px;--}}
    {{--}--}}

    {{--.list-group-item .glyphicon {--}}
        {{--margin-right: 5px;--}}
    {{--}--}}

    {{--/* The switch - the box around the slider */--}}
    {{--.switch {--}}
        {{--position: relative;--}}
        {{--display: inline-block;--}}
        {{--width: 60px;--}}
        {{--height: 34px;--}}
    {{--}--}}

    {{--/* Hide default HTML checkbox */--}}
    {{--.switch input {--}}
        {{--display: none;--}}
    {{--}--}}

    {{--/* The slider */--}}
    {{--.slider {--}}
        {{--position: absolute;--}}
        {{--cursor: pointer;--}}
        {{--top: 0;--}}
        {{--left: 0;--}}
        {{--right: 0;--}}
        {{--bottom: 0;--}}
        {{--background-color: #ccc;--}}
        {{---webkit-transition: .4s;--}}
        {{--transition: .4s;--}}
    {{--}--}}

    {{--.slider:before {--}}
        {{--position: absolute;--}}
        {{--content: "";--}}
        {{--height: 26px;--}}
        {{--width: 26px;--}}
        {{--left: 4px;--}}
        {{--bottom: 4px;--}}
        {{--background-color: white;--}}
        {{---webkit-transition: .4s;--}}
        {{--transition: .4s;--}}
    {{--}--}}

    {{--input:checked + .slider {--}}
        {{--background-color: #2196F3;--}}
    {{--}--}}

    {{--input:focus + .slider {--}}
        {{--box-shadow: 0 0 1px #2196F3;--}}
    {{--}--}}

    {{--input:checked + .slider:before {--}}
        {{---webkit-transform: translateX(26px);--}}
        {{---ms-transform: translateX(26px);--}}
        {{--transform: translateX(26px);--}}
    {{--}--}}

    {{--/* Rounded sliders */--}}
    {{--.slider.round {--}}
        {{--border-radius: 34px;--}}
    {{--}--}}

    {{--.slider.round:before {--}}
        {{--border-radius: 50%;--}}
    {{--}--}}



{{--</style>--}}

{{--@section('content')--}}
    <!-- Content Wrapper. Contains page content -->


    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                List of All Endorsement Accounts
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">

            <!-- Default box -->
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title"></h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                                title="Collapse">
                            <i class="fa fa-minus"></i></button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                            <i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="panel-body">

                        <div class="row">
                            <div class="col-md-12">
                                <!-- Custom Tabs -->
                                <div class="nav-tabs-custom">
                                    <ul class="nav nav-tabs">
                                        <li class="active"><a href="#tab_1" data-toggle="tab">C.I Tracker</a></li>
                                        <li><a href="#tab_2" id="id_chart" data-toggle="tab">Chart</a></li>
                                        <li><a href="#tab_3" data-toggle="tab">Polls</a></li>
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="tab_1">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <select class="form-control select2" style="width: 100%;" id="ciCountAccount">
                                                            @foreach($credit_investigators as $credit_investigator)
                                                                <option value="{{ $credit_investigator->id }} {{ old('ciID') }}">{{ $credit_investigator->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <button class="btn btn-sm btn-info" id="btnDisplayAccount">Generate</button>
                                            </div>
                                            {{--DISPLAY REPORT--}}
                                            <div class="row">
                                                <div id="ciResultCount">

                                                </div>
                                            </div>
                                            {{--END--}}
                                        </div>
                                        <!-- /.tab-pane -->
                                        <div class="tab-pane" id="tab_2">

                                           <div class="box box-danger">
                                                <div class="box-header with-border">
                                                    <h3 class="box-title">Line Chart for All Receive Endorsements</h3>
                                                    <div class="box-tools pull-right">
                                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                                                    </div>
                                                </div>
                                                    <div class="box-body">
                                                        <span id="selectYear"></span>
                                                        <center>
                                                            <div class="ct-chart" id="lineChart"></div>
                                                        </center>
                                                    </div>
                                                <div class="box-header with-border">
                                                    <h3 class="box-title">Pie Chart for Performance of endorsements</h3>
                                                        <div class="box-tools pull-right">
                                                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                                            </button>
                                                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                                                        </div>
                                                </div>
                                                <center>
                                                    <div class="box-body">
                                                        <div class="ct-chart-pie ct-chart" id="pieChart"></div>
                                                    </div>
                                                </center>
                                                <!-- /.box-body -->
                                           </div>
                                        </div>
                                            <!-- /.box -->
                                        <!-- /.tab-pane -->
                                        <div class="tab-pane" id="tab_3">
                                            {{--TAB CONTENT #3--}}

                                            <div id="row_polls" class="row">
                                                <div class="col-md-12">
                                                    <div class="box box-primary">
                                                        <div class="box-header with-border">
                                                            <h3 class="box-title">Poll Manager</h3>
                                                            <div class="box-tools pull-right">
                                                            </div>
                                                        </div>
                                                        <!-- /.box-body -->
                                                        <div class="just-padding">
                                                            <div class="list-group list-group-root well">
                                                                <div class="input-group">
                                                                    <div class="input-group-btn">
                                                                        <button id="Addquest" type="button"
                                                                                class="btn btn-info">Add Question
                                                                        </button>
                                                                    </div>
                                                                    <!-- /btn-group -->
                                                                    <input id="txtAddQuest" type="text" class="form-control">
                                                                </div>
                                                                <br>

                                                                <span id="poll_span">
                                                                 </span>


                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- /.box -->
                                                </div>
                                            </div>
                                        </div>

                                        <!-- /.tab-pane -->
                                    </div>
                                    <!-- /.tab-content -->
                                </div>
                                <!-- nav-tabs-custom -->
                            </div>
                            <!-- /.col -->
                        </div>

                    </div>
                </div>

                <!-- /.box-body -->
                <div class="box-footer">
                    Footer
                </div>
                <!-- /.box-footer-->
            </div>
            <!-- /.box -->

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
{{--@endsection--}}

{{--@push('leftsidebar')--}}
    {{--@include('management.management-leftsidebar')--}}
{{--@endpush--}}

{{--@push('jscript')--}}
    {{--<script src="{{ asset('jscript/dispatcher-ci-management.js') }}"></script>--}}
    {{--<script src="{{ asset('jscript/idle/jquery.idle.js') }}"></script>--}}
    {{--<script src="{{ asset('jscript/detect-user-idle.js') }}"></script>--}}
    {{--<script src="{{ asset('jscript/management.js') }}"></script>--}}
{{--@endpush--}}