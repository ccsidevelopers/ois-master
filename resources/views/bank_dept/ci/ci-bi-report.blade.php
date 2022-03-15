@extends('bank_dept.ci.template.master')


@section('content')

    <script type="text/template" id="qq-bi-rep-manual-trigger">
        <div class="qq-uploader-selector qq-uploader" qq-drop-area-text="Select Files">
            <div class="qq-total-progress-bar-container-selector qq-total-progress-bar-container">
                <div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" class="qq-total-progress-bar-selector qq-progress-bar qq-total-progress-bar"></div>
            </div>
            <div class="qq-upload-drop-area-selector qq-upload-drop-area" qq-hide-dropzone>
                <span class="qq-upload-drop-area-text-selector"></span>
            </div>
            <div class="buttons">
                <div class="qq-upload-button-selector qq-upload-button">
                    <center>Select File/s</center>
                </div>
            </div>

            <button type="button" id="trigger-uploadv3" class="btn btn-xs btn-primary" style="display: none;">
                <i class="icon-upload icon-white"></i> Upload
            </button>

            <span class="qq-drop-processing-selector qq-drop-processing">
                <span>Processing selected files...</span>
                <span class="qq-drop-processing-spinner-selector qq-drop-processing-spinner"></span>
            </span>
            <ul class="qq-upload-list-selector qq-upload-list" aria-live="polite" aria-relevant="additions removals">
                <li>
                    <div class="qq-progress-bar-container-selector">
                        <div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" class="qq-progress-bar-selector qq-progress-bar"></div>
                    </div>
                    <span class="qq-upload-spinner-selector qq-upload-spinner"></span>
                    <img class="qq-thumbnail-selector" qq-max-size="40" qq-server-scale>
                    <span class="qq-upload-file-selector qq-upload-file"></span>
                    {{--<span class="qq-edit-filename-icon-selector qq-edit-filename-icon" aria-label="Edit filename"></span>--}}
                    {{--<input class="qq-edit-filename-selector qq-edit-filename" tabindex="0" type="text">--}}
                    <span class="qq-upload-size-selector qq-upload-size"></span>
                    <button type="button" class="qq-btn qq-upload-cancel-selector qq-upload-cancel">Cancel</button>
                    <button type="button" class="qq-btn qq-upload-retry-selector qq-upload-retry">Retry</button>
                    <button type="button" class="qq-btn qq-upload-delete-selector qq-upload-delete">Delete</button>
                    <span role="status" class="qq-upload-status-text-selector qq-upload-status-text"></span>
                </li>
            </ul>

            <dialog class="qq-alert-dialog-selector">
                <div class="qq-dialog-message-selector"></div>
                <div class="qq-dialog-buttons">
                    <button type="button" class="qq-cancel-button-selector">Close</button>
                </div>
            </dialog>

            <dialog class="qq-confirm-dialog-selector">
                <div class="qq-dialog-message-selector"></div>
                <div class="qq-dialog-buttons">
                    <button type="button" class="qq-cancel-button-selector">No</button>
                    <button type="button" class="qq-ok-button-selector">Yes</button>
                </div>
            </dialog>

            <dialog class="qq-prompt-dialog-selector">
                <div class="qq-dialog-message-selector"></div>
                <input type="text">
                <div class="qq-dialog-buttons">
                    <button type="button" class="qq-cancel-button-selector">Cancel</button>
                    <button type="button" class="qq-ok-button-selector">Ok</button>
                </div>
            </dialog>
        </div>
    </script>

    <div class="content-wrapper">


        <!-- Main content -->
        <section class="content">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    B.I Reports
                    <small>Information</small>
                </h1>
            </section>
            <!-- Default box -->
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">B.I Reports Panel</h3>

                    {{--<div class="box-tools pull-right">--}}
                        {{--<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"--}}
                                {{--title="Collapse">--}}
                            {{--<i class="fa fa-minus"></i></button>--}}
                        {{--<button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">--}}
                            {{--<i class="fa fa-times"></i></button>--}}
                    {{--</div>--}}
                </div>

                <div class="box-body">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <button class="btn btn-block btn-success" data-toggle="modal" data-target="#modal_ci_add_bi_note" id="ci_bi_rep_init">Add B.I Report</button>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">B.I Reports Records</h3>
                                </div>
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <table class="table-condensed table-hover tableendorse bi_report_logs" width="100%" id="bi-report-table" style="text-align: center">
                                                <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>CLIENT NAME</th>
                                                    <th>SUBJECT NAME</th>
                                                    <th>DATE/TIME</th>
                                                    <th>ACTION</th>
                                                </tr>
                                                </thead>
                                                <tfoot>
                                                    <td>ID</td>
                                                    <td>CLIENT NAME</td>
                                                    <td>SUBJECT NAME</td>
                                                    <td>DATE/TIME</td>
                                                    <td>ACTION</td>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>


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
ve.d<script src="https://cdn.datatables.net/rowreorder/1.2.0/js/dataTables.rowReorder.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.1.1/js/dataTables.responsive.min.js"></script>
    <script src="{!!asset('fine-uploader/jquery.fine-uploader.js') !!}"></script>
    <script src="{!!asset('fine-uploader/fine-uploader.js') !!}"></script>
    <script src="{{ asset('jscript/ci.js?n='.$javs) }}"></script>
    <script src="{{ asset('jscript/getLatLong.js?n='.$javs) }}"></script>
    <script src="{{ asset('jscript/idle/jquery.idle.js?n='.$javs) }}"></script>
    <script src="{{ asset('jscript/detect-user-idle.js?n='.$javs) }}"></script>
@endpush