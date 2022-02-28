@extends('layouts.master')
<style>
    #map_wrapper {
        height: 80%;
    }

    #map_canvas {
        width: 100%;
        height: 93%;
    }
</style>
@section('content')
    <div class="content-wrapper">

    </div>

    <div class="modal fade" id="modal-downloadable-file">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" style = "text-align: center;">Downloadable Template</h4>
                </div>
                <div class="modal-body">
                    <div class = "row" style = "padding-top : 15px;">
                        <div class = "col-md-12">
                            <div class = "box box-danger">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-12">
                                            testing lang
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <div class="modal fade" id="otherInfo">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">ENDORSEMENT</h4>
                </div>
                <div class="modal-body">
                    <span class="badge bg-light-blue-gradient"><h5>Endorsement Information</h5></span>

                    {{--PDRN ADDRESS HERE--}}
                    <table border="2" style="white-space: normal; font-size: 10px" width="100%" id="otherPersonalSpan1"></table>
                    {{--END OF PDRN ADDRESS--}}

                    {{--COBORROWER HERE--}}
                    <table border="2" style="white-space: normal; font-size: 10px" width="100%" id="otherInfoSpan1"></table>
                    {{--END OF COBORROWER--}}

                    {{--EMPLOYER HERE--}}
                    <table border="2" style="white-space: normal; font-size: 10px" width="100%" id="otherEmployerSpan1"></table>
                    {{--END OF COBORROWER--}}

                    {{--BUSINESS HERE--}}
                    <table border="2" style="white-space: normal; font-size: 10px" width="100%" id="otherBusinessSpan1"></table>
                    {{--END OF BUSINESS--}}

                    <div class="row">
                        {{--CLIENT REMARKS--}}
                        <div class="form-group col-xs-12">
                            <label>Remarks:</label>
                            <textarea id="viewRemarks" class="form-control" rows="3" disabled></textarea>
                        </div>
                        {{--END OF CLIENT REMARKS--}}
                    </div>
                    <div class="row">
                        {{--CLIENT NOTES--}}
                        <div class="form-group col-xs-12" id="divNotes">
                            <label>Notes:</label>
                            <textarea id="viewNotes" class="form-control" rows="3" disabled></textarea>
                        </div>
                        {{--END OF CLIENT NOTES--}}
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-req-rem">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" style = "text-align: center">Requestor Remarks</h4>
                </div>
                <div class="modal-body">
                    <div class = "row" style = "padding-top: 20px;">
                        <div class = "col-md-12">
                            <b>Name:</b> <p id="dispatcher_req_name"></p>
                        </div>
                    </div>
                    <div class = "row">
                        <div class = "col-md-12">
                            <label for="">Remarks:</label>
                            <textarea id="req_rem_remarks" rows = "10" class = "form-control" disabled></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Close</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <div class="modal fade" id="modal-view-ci-liq-img">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Attached C.I Report for Liquidation</h4>
                </div>
                <div class="modal-body">
                    <div class = "row">
                        <div class = "col-md-12">
                            <div class = "row">
                                <div class = "col-md-12">
                                        <span id = "insertCiImgLiq">
                                        </span>
                                    <div class = "row">
                                        <div class = "col-md-12">
                                            <div class = "box box-warning">
                                                <div class = "row" style = "padding-bottom : 20px;">
                                                    <div class = "col-md-2"></div>
                                                    <div class = "col-md-8" >
                                                        <div class="form-group">
                                                            <h3 style = "text-align: left">General Liquidation Remarks:</h3>
                                                            <textarea id= "insertCILiqRemarks" class = "form-control" disabled></textarea>
                                                        </div>
                                                        <div class="form-group col-md-4 hidemuna">
                                                            <label for="">Fund Requested</label>
                                                            <input type="text" class="form-control" id="ci_req_amount" disabled>
                                                            <input type="hidden" class="form-control" id="ci_req_amount_check">
                                                        </div>
                                                        {{--<div class="form-group col-md-4 show_modify hidemuna">--}}
                                                            {{--<label for="" style="color: white;">button</label>--}}
                                                            {{--<button class="btn btn-primary btn-block" id="show_modify">Modify</button>--}}
                                                        {{--</div>--}}
                                                        {{--<div class="form-group col-md-4 clicked_modify" hidden>--}}
                                                            {{--<label for="" style="color: white;">button</label>--}}
                                                            {{--<button class="btn btn-warning btn-block" id="hide_modify">Cancel</button>--}}
                                                        {{--</div>--}}
                                                        <div class="form-group col-md-12 clicked_modify" hidden>
                                                            <label for="">Remarks: </label>
                                                            <textarea id= "finance_ci_liq_remssss" class = "form-control" placeholder="Remarks here ..."></textarea>
                                                        </div>
                                                    </div>
                                                    <div class = "col-md-2"></div>
                                                </div>
                                                <div class="row" style="padding-bottom: 20px;" hidden>
                                                    <div class="col-md-12">
                                                        <div class="col-md-2"></div>
                                                        <div class="col-md-8">
                                                            <b>Status: </b><span id="reviewer_span"></span><br>
                                                            <b>Changes made: </b><span id="reviewer_changes"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row" style="padding-bottom: 20px;">
                                                    <div class="col-md-12">
                                                        <div class="col-md-2"></div>
                                                        <div class="col-md-8">
                                                            <b>Last Updated: </b><span id="liq_date_rev"></span><br>

                                                        </div>
                                                        <div class="col-md-2"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{--</div>--}}
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success pull-right clicked_modify" hidden id="financeExpenseEdit">Submit</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>


    <div class="modal fade" id="modal-view-audit-review-rem">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Account Review Summary</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <span id="view_remarksSpan"></span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

@endsection

@push('leftsidebar')
    @include('ci_supervisor.ci-supervisor-leftsidebar')
@endpush

@push('jscript')
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/1.0.7/css/responsive.dataTables.min.css">
    <script src="https://cdn.datatables.net/responsive/2.2.1/js/dataTables.responsive.min.js"></script>
    <script src="{{ asset('jscript/ci-supervisor.js?n='.$javs) }}"></script>
    <script src="{{ asset('jscript/maps.js?n='.$javs) }}"></script>
    <script src="{{ asset('jscript/endorsement-management.js?n='.$javs) }}"></script>
    <script src="{{ asset('jscript/cc-bi-report.js?n='.$javs) }}"></script>
@endpush