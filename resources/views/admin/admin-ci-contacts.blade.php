@extends('admin.template.master')


@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                C.I Contacts
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <!-- Custom Tabs -->
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li class="active"><a id="tab1" href="#tab_1" data-toggle="tab">List of ALL C.I</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab_1">
                                <!-- Default box -->
                                <div class="box">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">C.I Numbers</h3>
                                    </div>

                                    <div class="box-body">
                                        <div class = "row">
                                            <div class="col-md-12">
                                                <table id="ci-contact-number-table" class="tableendorse display table-hover table-condensed" width=100%>
                                                    <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Emp ID</th>
                                                        <th>PASS CHANGED?</th>
                                                        <th>C.I Name</th>
                                                        <th>Email</th>
                                                        <th>C.I Number</th>
                                                        <th>Branch</th>
                                                        <th>Region</th>
                                                        <th>Archipelago</th>
                                                    </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.box-body -->
                                </div>
                                <!-- /.box -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

@endsection

@push('jscript')

    <script src="https://cdn.datatables.net/buttons/1.5.0/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.0/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>

    <script src="https://cdn.datatables.net/buttons/1.5.0/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.0/js/buttons.print.min.js"></script>
    <script src="{{ asset('jscript/admin.js') }}"></script>

@endpush
