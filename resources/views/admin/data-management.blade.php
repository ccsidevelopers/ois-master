@extends('admin.template.master')
<style>
    textarea {
        overflow-y: scroll;
        height: 70%;
        width: 50%;
        resize: none;

    }
</style>

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                ADMIN ACCESS
                <small>ISKARAMUSHKARAMUSHKANADOAPANTANGO</small>
            </h1>
        </section>
        <!-- Main content -->
        <section class="content">
            <!-- Default box -->
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Data Management Panel</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                                title="Collapse">
                            <i class="fa fa-minus"></i></button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                            <i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="box-body col-md-12">
                        <div class="box box-danger">
                            <h3>- -Data Manupulation- -</h3>
                            <div class="box-header with-border">
                                {{--content--}}
                                {{--<button type="button" id="btn_deleteall" class="btn btn-danger" style="margin-top: 10px">(For test Only) Delete all Endorsements in Database</button>--}}

                                <button type="button" class="btn btn-success" id="btnBackUpFile" style="margin-top: 10px; margin-left: 5px">Back-up File</button>

                            </div>

                        </div>

                        <center><h3>- -Audit Trail Monitoring- -</h3></center>
                        <center><textarea readonly id="monitoring"></textarea></center>

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
    {{ csrf_field() }}

@endsection

@push('jscript')

    <script src="{{ asset('jscript/admin-data-management.js') }}"></script>

@endpush