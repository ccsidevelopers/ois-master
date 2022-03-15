{{--@extends('layouts.master')--}}

{{--@section('content')--}}

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                New Client Prospect
            </h1>

        </section>

        <!-- Main content -->
        <section class="content">

            <!-- Default box -->
            <div class="box">
                <div class="box-header with-border">

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
                                    <h3 class="box-title">Add New Client Prospect</h3>
                                </div>
                                <div class="box-header with-border">
                                    <div class="box-body">
                                        <form enctype="multipart/form-data">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="txtClientNamePros">Client Name:</label>
                                                        <input type="text" class="form-control" id="txtClientNamePros">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-5">
                                                    <div class="form-group">
                                                        <label for="clientDateInquiry">Date of Inquiry:</label>
                                                        <input type="date" class="form-control" id="clientDateInquiry">
                                                    </div>
                                                </div>
                                                <div class="col-md-7">
                                                    <div class="form-group">
                                                        <label for="fileContract">Choose zip file:</label>
                                                        <input type="file" class="btn btn-block btn-default" id="clientFile" accept=".zip">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="txtContactPerson">Contact Person:</label>
                                                        <input type="text" class="form-control" id="txtContactPerson">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="txtContactPosition">Contact Position:</label>
                                                        <input type="text" class="form-control" id="txtContactPosition">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="txtContactNumber">Contact Number:</label>
                                                        <input type="text" class="form-control" id="txtContactNumber">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="txtContactEmail">Contact Email:</label>
                                                        <input type="email" class="form-control" id="txtContactEmail">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="txtReqCheck">Requirements Checklist:</label>
                                                        <textarea id="txtReqCheck" rows="5" class="form-control"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="txtComAdd">Complete Address:</label>
                                                        <textarea id="txtComAdd" rows="5" class="form-control" placeholder="Address Here..."></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <button class="btn btn-flat btn-block bg-olive pull-right" id="btnSaveProsClient">Save</button>
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
                                    <h3 class="box-title">Client Table</h3>
                                </div>
                                <div class="box-header with-border">
                                    <div class="box-body">
                                        <table id="marketing-table-prospect-client" class="tableendorse table-hover table-condensed" width="100%">
                                            <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Client Name</th>
                                                <th>Date Inquiry</th>
                                                <th>Address</th>
                                                <th>Contact Person</th>
                                                <th>Position</th>
                                                <th>Contact #</th>
                                                <th>Contact Email</th>
                                                <th>Requirements Checklist</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tfoot>
                                            <tr>
                                                <th>Id</th>
                                                <th>Client Name</th>
                                                <th>Date Inquiry</th>
                                                <th>Address</th>
                                                <th>Contact Person</th>
                                                <th>Position</th>
                                                <th>Contact #</th>
                                                <th>Contact Email</th>
                                                <th>Requirements Checklist</th>
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