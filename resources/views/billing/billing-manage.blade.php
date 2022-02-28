{{--@extends('layouts.master')--}}

{{--@section('content')--}}

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Billing Information
                <small>Accounts</small>
            </h1>

        </section>

        <!-- Main content -->
        <section class="content">

            <!-- Default box -->
            <div class="box">
                <div class="box-body">
                    <table id="billing-manage" class="tableendorse table-hover table-condensed" width="100%">
                        <thead>
                            <tr>
                                <th>Municipalities</th>
                                <th>Provinces</th>
                                <th>Bank Name</th>
                                <th>Rate</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Municipalities</th>
                                <th>Provinces</th>
                                <th>Bank Name</th>
                                <th>Rate</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <!-- /.box -->

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

{{--@endsection--}}

{{--@push('leftsidebar')--}}
    {{--@include('billing.billing-leftsidebar')--}}
{{--@endpush--}}

{{--@push('jscript')--}}

    {{--<script src="{{ asset('jscript/billing.js') }}"></script>--}}
{{--@endpush--}}