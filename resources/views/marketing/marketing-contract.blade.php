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
                    <h3 class="box-title">Contract Module</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                                title="Collapse">
                            <i class="fa fa-minus"></i></button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                            <i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="box box-danger">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Add Contract</h3>
                                </div>
                                <div class="box-header with-border">
                                    <div class="box-body">
                                        <form enctype="multipart/form-data" id="uploadFileContract">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="txtContract">Client Name:</label>
                                                        <input type="text" class="form-control" id="txtClientName" placeholder="Client Name Here..">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="dateStartCont:">Start Date:</label>
                                                        <input type="date" class="form-control" id="dateStartCont" value="{{ $dateNow->format('Y-m-d') }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="dateEndCont:">End Date:</label>
                                                        <input type="date" class="form-control" id="dateEndCont" value="{{ $dateNow->addMonth()->format('Y-m-d') }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="fileContract">Choose PDF Contract File (it must be .zip File):</label>
                                                        <input type="file" id="fileContract" accept=".zip">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="txtContDesc">Contract Description:</label>
                                                        <textarea id="txtContDesc" class="form-control" placeholder="Contract Description Here..."></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="txtContRemarks">Remarks:</label>
                                                        <textarea id="txtContRemarks" class="form-control" placeholder="Contract Remarks Here..."></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <button class="btn btn-flat btn-block bg-olive pull-right" id="btnSaveCont">Save</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="box box-danger">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Table Contract</h3>
                                </div>
                                <div class="box-header with-border">
                                    <div class="box-body">
                                        <table id="marketing-table-contracts" class="tableendorse table-hover table-condensed" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>Id</th>
                                                    <th>Client Name</th>
                                                    <th>Contract Start</th>
                                                    <th>End of Contract</th>
                                                    <th>Description</th>
                                                    <th>Remarks</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th>Id</th>
                                                    <th>Client Name</th>
                                                    <th>Contract Start</th>
                                                    <th>End of Contract</th>
                                                    <th>Description</th>
                                                    <th>Remarks</th>
                                                    <th>Action</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
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
    {{--@include('marketing.marketing-leftsidebar')--}}
{{--@endpush--}}

{{--@push('jscript')--}}
    {{--<script src="{{ asset('jscript/marketing.js') }}"></script>--}}
{{--@endpush--}}