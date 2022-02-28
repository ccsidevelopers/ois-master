@extends('bank_dept.ci.template.master')


@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->


        <!-- Main content -->
        <section class="content">
            <section class="content-header">
                <h1>
                    Daily Expense Report
                    <small>Report</small>
                </h1>
            </section>
            <!-- Default box -->
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Daily Declared Expenses Report</h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">

                            <table id="table-expenses-report" class="tableendorse table-hover table-condensed" width="100%">
                                <thead>
                                <tr>
                                    <th>ID:</th>
                                    <th>DATE:</th>
                                    <th>LABELS:</th>
                                    <th>AMOUNT:</th>
                                    <th>FROM:</th>
                                    <th>TOTAL AMOUNT:</th>
                                    <th>O.R:</th>
                                    <th>REMARKS:</th>
                                    <th>ACCOUNT INFO:</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
                {{--END--}}
            <!-- /.box-body -->
                <div class="box-footer">

                </div>
                <!-- /.box-footer-->
            </div>
            <!-- /.box -->

        </section>
        <!-- /.content -->
    </div>
@endsection

@push('leftsidebar')
    @include('bank_dept.ci.ci-leftsidebar')
@endpush

@push('jscript')

    <link rel="stylesheet" href="https://cdn.datatables.net/rowreorder/1.2.0/css/rowReorder.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.1.1/css/responsive.dataTables.min.css">
    <script src="https://cdn.datatables.net/rowreorder/1.2.0/js/dataTables.rowReorder.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.1.1/js/dataTables.responsive.min.js"></script>
    <script src="{{ asset('jscript/ci.js?n='.$javs) }}"></script>
    <script src="{{ asset('jscript/getLatLong.js?n='.$javs) }}"></script>
    <script src="{{ asset('jscript/idle/jquery.idle.js?n='.$javs) }}"></script>
    <script src="{{ asset('jscript/detect-user-idle.js?n='.$javs) }}"></script>

@endpush