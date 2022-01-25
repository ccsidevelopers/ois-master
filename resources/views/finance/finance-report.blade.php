{{--@extends('layouts.master')--}}

{{--@section('content')--}}

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Finance Report
                <small>Auditing</small>
            </h1>

        </section>

        <!-- Main content -->
        <section class="content">

            <!-- Default box -->
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Finance Report</h3>
                </div>
                <div class="box-body">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="nav-tabs-custom">
                                    <ul class="nav nav-tabs">
                                        <li class="active"><a href="#tab_1_report" id="" data-toggle="tab">C.I Expenses Report</a></li>
                                        <li class=""><a href="#tab_2_report" id="" data-toggle="tab">Tab 2</a></li>
                                        <li class=""><a href="#tab_3_report" id="" data-toggle="tab">Tab 3</a></li>
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="tab_1_report">
                                            <table id="table-finance-expenses-report" class="tableendorse table-hover table-condensed" width="100%">
                                                <thead>
                                                <tr>
                                                    <th>ID:</th>
                                                    <th>C.I NAME:</th>
                                                    <th>DATE:</th>
                                                    <th>LABELS:</th>
                                                    <th>AMOUNT:</th>
                                                    <th>FROM:</th>
                                                    <th>TOTAL AMOUNT:</th>
                                                    <th>O.R:</th>
                                                    <th>REMARKS:</th>
                                                    <th>ACCOUNT INFO:</th>
                                                    <th>ACTION:</th>
                                                </tr>
                                                </thead>
                                            </table>
                                        </div>
                                        <div class="tab-pane" id="tab_2_report">
                                            tab 2
                                        </div>
                                        <div class="tab-pane" id="tab_3_report">
                                            tab 3
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

{{--@endsection--}}

{{--@push('leftsidebar')--}}
    {{--@include('finance.finance-leftsidebar')--}}
{{--@endpush--}}

{{--@push('jscript')--}}
    {{--<script src="https://cdn.datatables.net/buttons/1.5.0/js/dataTables.buttons.min.js"></script>--}}
    {{--<script src="https://cdn.datatables.net/buttons/1.5.0/js/buttons.flash.min.js"></script>--}}
    {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>--}}
    {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>--}}
    {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>--}}

    {{--<script src="https://cdn.datatables.net/buttons/1.5.0/js/buttons.html5.min.js"></script>--}}
    {{--<script src="https://cdn.datatables.net/buttons/1.5.0/js/buttons.print.min.js"></script>--}}

    {{--<script src="{{ asset('jscript/finance.js') }}"></script>--}}
{{--@endpush--}}