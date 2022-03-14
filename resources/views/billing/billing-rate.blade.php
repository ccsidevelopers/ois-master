{{--@extends('layouts.master')--}}

{{--<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs/jszip-2.5.0/pdfmake-0.1.18/dt-1.10.12/af-2.1.2/b-1.2.2/b-colvis-1.2.2/b-flash-1.2.2/b-html5-1.2.2/b-print-1.2.2/cr-1.3.2/fc-3.2.2/fh-3.1.2/kt-2.1.3/r-2.1.0/rr-1.1.2/sc-1.4.2/se-1.2.0/datatables.min.css"/>--}}

{{--<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.1/css/buttons.dataTables.min.css">--}}
{{--<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">--}}
{{--<link href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/themes/south-street/jquery-ui.min.css" rel="stylesheet" type="text/css" />--}}
{{--<link href="https://cdn.datatables.net/plug-ins/725b2a2115b/integration/jqueryui/dataTables.jqueryui.css" rel="stylesheet" type="text/css" />--}}


{{--@section('content')--}}

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Billing Report
                <small>Accounts</small>
            </h1>

        </section>

        <!-- Main content -->
        <section class="content">

            <!-- Default box -->
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Billing Reports (Page length maximum of 100 items.)</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                                title="Collapse">
                            <i class="fa fa-minus"></i></button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                            <i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <div style = "overflow:scroll; height : 100%">
                        <table id="billing-table-rate" class="tableendorse table-hover table-condensed" width="100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>DATE ENDORSED</th>
                                    <th>TIME ENDORSED</th>
                                    <th>DATE DUE</th>
                                    <th>TIME DUE</th>
                                    <th>ACCOUNT NAME</th>
                                    <th>ADDRESS</th>
                                    <th>CITY/MUNICIPALITY</th>
                                    <th>PROVINCE</th>
                                    <th>TYPE OF REQUEST</th>
                                    <th>BANK NAME</th>
                                    <th>STATUS</th>
                                    <th>PICTURE STATUS</th>
                                    <th>RATE</th>
                                    <th>ENTRY AS</th>
                                    <th>DATE SENT</th>
                                    <th>TIME SENT</th>
                                    <th>BILLING STATUS</th>
                                    <th>APPLIED RULE</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>DATE ENDORSED</th>
                                    <th>TIME ENDORSED</th>
                                    <th>DATE DUE</th>
                                    <th>TIME DUE</th>
                                    <th>ACCOUNT NAME</th>
                                    <th>ADDRESS</th>
                                    <th>CITY/MUNICIPALITY</th>
                                    <th>PROVINCE</th>
                                    <th>TYPE OF REQUEST</th>
                                    <th>BANK NAME</th>
                                    <th>STATUS</th>
                                    <th>PICTURE STATUS</th>
                                    <th>RATE</th>
                                    <th>ENTRY AS</th>
                                    <th>DATE SENT</th>
                                    <th>TIME SENT</th>
                                    <th>BILLING STATUS</th>
                                    <th>APPLIED RULE</th>
                                </tr>
                            </tfoot>
                        </table>
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
    {{--@include('billing.billing-leftsidebar')--}}
{{--@endpush--}}

{{--@push('jscript')--}}
    {{--<script type="text/javascript" src="https://cdn.datatables.net/v/bs/jszip-2.5.0/pdfmake-0.1.18/dt-1.10.12/af-2.1.2/b-1.2.2/b-colvis-1.2.2/b-flash-1.2.2/b-html5-1.2.2/b-print-1.2.2/cr-1.3.2/fc-3.2.2/fh-3.1.2/kt-2.1.3/r-2.1.0/rr-1.1.2/sc-1.4.2/se-1.2.0/datatables.min.js"></script>--}}

    {{--<script src="https://cdn.datatables.net/buttons/1.5.0/js/dataTables.buttons.min.js"></script>--}}
    {{--<script src="https://cdn.datatables.net/buttons/1.5.0/js/buttons.flash.min.js"></script>--}}
    {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>--}}
    {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>--}}
    {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>--}}

    {{--<script src="https://cdn.datatables.net/buttons/1.5.0/js/buttons.html5.min.js"></script>--}}
    {{--<script src="https://cdn.datatables.net/buttons/1.5.0/js/buttons.print.min.js"></script>--}}


    {{--<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/jquery-ui.min.js"></script>--}}
    {{--<script src="https://cdn.jsdelivr.net/jquery.ui-contextmenu/1.7.0/jquery.ui-contextmenu.min.js"></script>--}}


    {{--<script src="{{ asset('jscript/billing.js') }}"></script>--}}
{{--@endpush--}}