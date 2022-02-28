{{--@extends('layouts.master')--}}

{{--@section('content')--}}

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Client Birthday Panel
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
                                    <h3 class="box-title">Add Client Birthday</h3>
                                </div>
                                <div class="box-header with-border">
                                    <div class="box-body">
                                        <form enctype="multipart/form-data" id="uploadFileContract_bday">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="txtContract">Client Name:</label>
                                                        <input type="text" class="form-control" id="txtClientName_bday" placeholder="Client Name Here..">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="txtEmployerName">Employer Name:</label>
                                                        <input type="text" class="form-control" id="txtEmployerName">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="clientBday">Birth Date:</label>
                                                        <input type="date" class="form-control" id="clientBday">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="txtClientContactNo">Contact No/s.:</label>
                                                        <input type="text" class="form-control" id="txtClientContactNo">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="clientEmail">Client Email:</label>
                                                        <input type="email" class="form-control" id="clientEmail">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="clientPos">Client Position:</label>
                                                        <input type="text" class="form-control" id="clientPos">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="clientGiftType">Gift Type:</label>
                                                        <select class="form-control select1" id="clientGiftType">
                                                            <option value="A">A</option>
                                                            <option value="B">B</option>
                                                            <option value="C">C</option>
                                                            <option value="D">D</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <button class="btn btn-flat btn-block bg-olive pull-right" id="btnSaveClientBday">Save</button>
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
                                        <table id="marketing-table-clientbday" class="tableendorse table-hover table-condensed" width="100%">
                                            <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Client Name</th>
                                                <th>Birthdate</th>
                                                <th>Contact No.</th>
                                                <th>Email</th>
                                                <th>Position</th>
                                                <th>Gift Type</th>
                                                <th>Employer Name</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tfoot>
                                            <tr>
                                                <th>Id</th>
                                                <th>Client Name</th>
                                                <th>Birthdate</th>
                                                <th>Contact No.</th>
                                                <th>Email</th>
                                                <th>Position</th>
                                                <th>Gift Type</th>
                                                <th>Employer Name</th>
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