@extends('layouts.master')

<style>
    #calendar_tat .fc-content {
        cursor: pointer;
    }
    #calendar_tat .fc-time{
        display : none;
    }
</style>

@section('content')

    <div class="content-wrapper">

        <div class="modal fade" id="modal-update-bi-rate">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <center>
                        <h4 class="modal-title">UPDATE RATE</h4>
                        </center>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="box box-body">
                                    <div class="col-md-12">
                                        <div class="col-md-3"></div>
                                        <div class="col-md-4">
                                            <label for="editted_amount">Amount :</label>
                                            <input type="number" class="form-control" id="editted_amount">
                                        </div>
                                        <div class="col-md-4" style="padding-top:25px;">
                                            <button class="btn btn-md btn-warning" style="margin-right: 10px;" id="edit_rate_bi"><i class="glyphicon glyphicon-pencil"></i> Edit</button>
                                            <button class="btn btn-md btn-primary" hidden id="cancel_bi_rate_edit"><i class="glyphicon glyphicon-remove"></i> Cancel</button>
                                        </div>
                                        <div class="col-md-2">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-md btn-default pull-left" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-md btn-success pull-right" id="btn_rate_edit" hidden>Submit</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modal-update-bi-logs">
            <div class="modal-dialog">
                <div class="modal-content">
                    {{--<div class="modal-header">--}}
                        {{--<center>--}}
                            {{--<h4 class="modal-title">LOGS</h4>--}}
                        {{--</center>--}}
                    {{--</div>--}}
                    <div class="modal-body">
                        <div class="row">
                            <div class="box box-body">
                                <div class="col-md-12">
                                    <span id="marketing_logs_table_span"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modal-all-marketing-logs">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        {{--<center>--}}
                            {{--<h4 class="modal-title">LOGS</h4>--}}
                        {{--</center>--}}
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="box box-body">
                                <div class="col-md-12">
                                    <table class="table-condensed table-hover" width="100%" id="marketing_logsTable">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>NAME</th>
                                                <th>ACTIVITY/LOGS</th>
                                                <th>DATE/TIME</th>
                                                <th>TYPE</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{--<div class="modal-footer">--}}
                        {{--<button class="btn btn-default" data-dismiss="modal">Close</button>--}}
                    {{--</div>--}}
                </div>
            </div>
        </div>

        <div class="modal modal-warning fade" id="modal-loading">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span></button>
                        <h4 class="modal-title">Loading</h4>
                    </div>
                    <div class="modal-body">
                        <p>Please wait…</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>

        <div class="modal modal-success fade" id="modal-success-loading">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">
                        <p>Success…</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>



    </div>

@endsection

@push('leftsidebar')
    @include('marketing.marketing-leftsidebar')
@endpush

@push('jscript')

    <script src="{{ asset('jscript/marketing.js?n='.$javs) }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.js"></script>
    {!! $calendar->script() !!}
    <script src="https://cdn.datatables.net/buttons/1.5.0/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.0/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>

    <script src="https://cdn.datatables.net/buttons/1.5.0/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.0/js/buttons.print.min.js"></script>

@endpush