{{--@extends('layouts.master')--}}

{{--@section('content')--}}

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Marketing Report
                <small>Reports</small>
            </h1>

        </section>

        <!-- Main content -->
        <section class="content">

            <!-- Default box -->
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Title</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                                title="Collapse">
                            <i class="fa fa-minus"></i></button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                            <i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body">

                    <table id="billing-table-rate" class="tableendorse table-hover table-condensed" width="100%">
                        <thead>
                        <tr>
                            <th>Id</th>
                            <th>Date Endorsed</th>
                            <th>Time Endorsed</th>
                            <th>Account Name</th>
                            <th>Address</th>
                            <th>City/Municipality</th>
                            <th>Province</th>
                            <th>TOR</th>
                            <th>Status</th>
                            <th>Picture Status</th>
                            <th>Date Sent</th>
                            <th>Time Sent</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>Id</th>
                            <th>Date Endorsed</th>
                            <th>Time Endorsed</th>
                            <th>Account Name</th>
                            <th>Address</th>
                            <th>City/Municipality</th>
                            <th>Province</th>
                            <th>TOR</th>
                            <th>Status</th>
                            <th>Picture Status</th>
                            <th>Date Sent</th>
                            <th>Time Sent</th>
                        </tr>
                        </tfoot>
                    </table>

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
    {{--@include('marketing.marketing-leftsidebar')--}}
{{--@endpush--}}

{{--@push('jscript')--}}
    {{--<script src="{{ asset('jscript/marketing.js') }}"></script>--}}
{{--@endpush--}}