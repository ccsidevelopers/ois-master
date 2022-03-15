@extends('layouts.master')

@section('content')

    <div class="content-wrapper">

    </div>

    <div class="modal fade" id="modal-view-it-checlist">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" style = "text-align: center">Information</h4>
                </div>
                <div class="modal-body">
                    <div class="box box-primary">
                        <div class="row" style="padding-top : 20px;">
                            <div class="col-md-12">
                                <div id="showManilaView" hidden>
                                    <table class="table-hover table-condensed" id = "" width="100%"  style = "overflow-x:auto; border-collapse:collapse; table-layout:fixed ; width : 100%; ">
                                        <thead>
                                        <tr>
                                            <th>SERVER/INTERNET/DEVICES</th>
                                            <th>STATUS</th>
                                            <th>REMARKS</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <b>ISP - NOW Corp.</b>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <b>30mbps</b>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <b>Eastern Telecoms</b>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <b>12mbps</b>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="showDetailsManila-0" chk="0"></td>
                                            <td class="showDetailsManila-0" chk="1"></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <b>FORTINET - Firewall</b>
                                            </td>
                                            <td class="showDetailsManila-1" chk="0"></td>
                                            <td class="showDetailsManila-1" chk="1"></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <b>Synology Mapdrive</b>
                                            </td>
                                            <td class="showDetailsManila-2" chk="0"></td>
                                            <td class="showDetailsManila-2" chk="1"></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <b>PABX, GSM and IP phones</b>
                                            </td>
                                            <td class="showDetailsManila-3" chk="0"></td>
                                            <td class="showDetailsManila-3" chk="1"></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <b>CMAP device</b>
                                            </td>
                                            <td class="showDetailsManila-4" chk="0"></td>
                                            <td class="showDetailsManila-4" chk="1"></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <b>CCTV DVR 25th floor</b>
                                            </td>
                                            <td class="showDetailsManila-5" chk="0"></td>
                                            <td class="showDetailsManila-5" chk="1"></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <b>CCTV IP cam 9th floor</b>
                                            </td>
                                            <td class="showDetailsManila-6" chk="0"></td>
                                            <td class="showDetailsManila-6" chk="1"></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <b>Switch Port</b>
                                            </td>
                                            <td class="showDetailsManila-7" chk="0"></td>
                                            <td class="showDetailsManila-7" chk="1"></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <b>WIFI devices 25th and 9th floor</b>
                                            </td>
                                            <td class="showDetailsManila-8" chk="0"></td>
                                            <td class="showDetailsManila-8" chk="1"></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <b>Connection on all PC workstation</b>
                                            </td>
                                            <td class="showDetailsManila-9" chk="0"></td>
                                            <td class="showDetailsManila-9" chk="1"></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <b>Biometrics 25th floor</b>
                                            </td>
                                            <td class="showDetailsManila-10" chk="0"></td>
                                            <td class="showDetailsManila-10" chk="1"></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <b>Biometrics 9th floor</b>
                                            </td>
                                            <td class="showDetailsManila-11" chk="0"></td>
                                            <td class="showDetailsManila-11" chk="1"></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <b>Magnetic Doorlock</b>
                                            </td>
                                            <td class="showDetailsManila-12" chk="0"></td>
                                            <td class="showDetailsManila-12" chk="1"></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <b>All Printers</b>
                                            </td>
                                            <td class="showDetailsManila-13" chk="0"></td>
                                            <td class="showDetailsManila-13" chk="1"></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <b>OIMS test</b>
                                            </td>
                                            <td class="showDetailsManila-14" chk="0"></td>
                                            <td class="showDetailsManila-14" chk="1"></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div id="showCaviteView" hidden>
                                    <table class="table-hover table-condensed" id = ""  style = "overflow-x:auto; border-collapse:collapse; table-layout:fixed ; width : 100%; ">
                                        <thead>
                                        <tr>
                                            <th>SERVER/INTERNET/DEVICES</th>
                                            <th>STATUS</th>
                                            <th>REMARKS</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <b>ISP - PLDT</b>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <b>200mbps</b>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <b>PRODATA</b>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <b>10mbps</b>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <b>PLDT Wifi</b>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <b>12mbps</b>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="showDetailsCavite-0" chk="0"></td>
                                            <td class="showDetailsCavite-0" chk="1"></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <b>FORTINET - Firewall</b>
                                            </td>
                                            <td class="showDetailsCavite-1" chk="0"></td>
                                            <td class="showDetailsCavite-1" chk="1"></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <b>Synology Mapdrive</b>
                                            </td>
                                            <td class="showDetailsCavite-2" chk="0"></td>
                                            <td class="showDetailsCavite-2" chk="1"></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <b>PABX, GSM and IP phones</b>
                                            </td>
                                            <td class="showDetailsCavite-3" chk="0"></td>
                                            <td class="showDetailsCavite-3" chk="1"></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <b>Switch Port</b>
                                            </td>
                                            <td class="showDetailsCavite-4" chk="0"></td>
                                            <td class="showDetailsCavite-4" chk="1"></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <b>CCTV DVR</b>
                                            </td>
                                            <td class="showDetailsCavite-5" chk="0"></td>
                                            <td class="showDetailsCavite-5" chk="1"></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <b>CCTV IP CAM</b>
                                            </td>
                                            <td class="showDetailsCavite-6" chk="0"></td>
                                            <td class="showDetailsCavite-6" chk="1"></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <b>WIFI devices</b>
                                            </td>
                                            <td class="showDetailsCavite-7" chk="0"></td>
                                            <td class="showDetailsCavite-7" chk="1"></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <b>Connection on all PC workstation</b>
                                            </td>
                                            <td class="showDetailsCavite-8" chk="0"></td>
                                            <td class="showDetailsCavite-8" chk="1"></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <b>Biometrics</b>
                                            </td>
                                            <td class="showDetailsCavite-9" chk="0"></td>
                                            <td class="showDetailsCavite-9" chk="1"></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <b>Magnetic Doorlock</b>
                                            </td>
                                            <td class="showDetailsCavite-10" chk="0"></td>
                                            <td class="showDetailsCavite-10" chk="1"></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <b>All Printers</b>
                                            </td>
                                            <td class="showDetailsCavite-11" chk="0"></td>
                                            <td class="showDetailsCavite-11" chk="1"></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <b>OIMS test</b>
                                            </td>
                                            <td class="showDetailsCavite-12" chk="0"></td>
                                            <td class="showDetailsCavite-12" chk="1"></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div id="showCebuView" hidden>
                                    <table class="table-hover table-condensed" id = "" style = "overflow-x:auto; border-collapse:collapse; table-layout:fixed ; width : 100%; ">
                                        <thead>
                                        <tr>
                                            <th>SERVER/INTERNET/DEVICES</th>
                                            <th>STATUS</th>
                                            <th>REMARKS</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <b>ISP - PLDT</b>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <b>200mbps</b>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <b>SKYBIZ</b>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <b>50mbps</b>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="showDetailsCebu-0" chk="0"></td>
                                            <td class="showDetailsCebu-0" chk="1"></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <b>FORTINET - Firewall</b>
                                            </td>
                                            <td class="showDetailsCebu-1" chk="0"></td>
                                            <td class="showDetailsCebu-1" chk="1"></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <b>Synology Mapdrive</b>
                                            </td>
                                            <td class="showDetailsCebu-2" chk="0"></td>
                                            <td class="showDetailsCebu-2" chk="1"></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <b>PABX, GSM and IP phones</b>
                                            </td>
                                            <td class="showDetailsCebu-3" chk="0"></td>
                                            <td class="showDetailsCebu-3" chk="1"></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <b>CCTV DVR</b>
                                            </td>
                                            <td class="showDetailsCebu-4" chk="0"></td>
                                            <td class="showDetailsCebu-4" chk="1"></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <b>CCTV IP CAM</b>
                                            </td>
                                            <td class="showDetailsCebu-5" chk="0"></td>
                                            <td class="showDetailsCebu-5" chk="1"></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <b>Switch Port</b>
                                            </td>
                                            <td class="showDetailsCebu-6" chk="0"></td>
                                            <td class="showDetailsCebu-6" chk="1"></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <b>WIFI devices</b>
                                            </td>
                                            <td class="showDetailsCebu-7" chk="0"></td>
                                            <td class="showDetailsCebu-7" chk="1"></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <b>Connection on all PC workstation</b>
                                            </td>
                                            <td class="showDetailsCebu-8" chk="0"></td>
                                            <td class="showDetailsCebu-8" chk="1"></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <b>Biometrics</b>
                                            </td>
                                            <td class="showDetailsCebu-9" chk="0"></td>
                                            <td class="showDetailsCebu-9" chk="1"></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <b>Magnetic Doorlock</b>
                                            </td>
                                            <td class="showDetailsCebu-10" chk="0"></td>
                                            <td class="showDetailsCebu-10" chk="1"></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <b>All Printers</b>
                                            </td>
                                            <td class="showDetailsCebu-11" chk="0"></td>
                                            <td class="showDetailsCebu-11" chk="1"></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <b>OIMS test</b>
                                            </td>
                                            <td class="showDetailsCebu-12" chk="0"></td>
                                            <td class="showDetailsCebu-12" chk="1"></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div id="showDavaoView" hidden>
                                    <table class="tableendorse table-hover table-condensed" id = ""  style = "overflow-x:auto; border-collapse:collapse; table-layout:fixed ; width : 100%; ">
                                        <thead>
                                        <tr>
                                            <th>SERVER/INTERNET/DEVICES</th>
                                            <th>STATUS</th>
                                            <th>REMARKS</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <b>ISP - SKY</b>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <b>40mbps</b>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <b>PLDT FIBER</b>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <b>50mbps</b>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <b>GLOBE</b>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <b>10mbps</b>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="showDetailsDavao-0" chk="0"></td>
                                            <td class="showDetailsDavao-0" chk="1"></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <b>FORTINET - Firewall</b>
                                            </td>
                                            <td class="showDetailsDavao-1" chk="0"></td>
                                            <td class="showDetailsDavao-1" chk="1"></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <b>Synology Mapdrive</b>
                                            </td>
                                            <td class="showDetailsDavao-2" chk="0"></td>
                                            <td class="showDetailsDavao-2" chk="1"></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <b>CCTV IP CAM</b>
                                            </td>
                                            <td class="showDetailsDavao-3" chk="0"></td>
                                            <td class="showDetailsDavao-3" chk="1"></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <b>Switch Port</b>
                                            </td>
                                            <td class="showDetailsDavao-4" chk="0"></td>
                                            <td class="showDetailsDavao-4" chk="1"></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <b>WIFI devices</b>
                                            </td>
                                            <td class="showDetailsDavao-5" chk="0"></td>
                                            <td class="showDetailsDavao-5" chk="1"></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <b>Connection on all PC workstation</b>
                                            </td>
                                            <td class="showDetailsDavao-6" chk="0"></td>
                                            <td class="showDetailsDavao-6" chk="1"></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <b>Biometrics</b>
                                            </td>
                                            <td class="showDetailsDavao-7" chk="0"></td>
                                            <td class="showDetailsDavao-7" chk="1"></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <b>Magnetic Doorlock</b>
                                            </td>
                                            <td class="showDetailsDavao-8" chk="0"></td>
                                            <td class="showDetailsDavao-8" chk="1"></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <b>All Printers</b>
                                            </td>
                                            <td class="showDetailsDavao-9" chk="0"></td>
                                            <td class="showDetailsDavao-9" chk="1"></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <b>OIMS test</b>
                                            </td>
                                            <td class="showDetailsDavao-10" chk="0"></td>
                                            <td class="showDetailsDavao-10" chk="1"></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="padding-top : 20px;">
                            <div class="col-md-1"></div>
                            <div class="col-md-10">
                                <label for="remarks_for_checklist">Remarks/Note:</label>
                                <textarea class="form-control" rows="3" id="remarks_for_checklist" placeholder="Insert remarks/note here..........."></textarea>
                            </div>
                            <div class="col-md-1"></div>
                        </div>
                        <div class="row" style="padding-top : 20px;" id="show_rev_time_checklist" hidden>
                            <div class="col-md-1"></div>
                            <div class="col-md-3">
                                <label for="">Date/Time Reviewed:</label>
                                <input type="text" class="form-control" id="date_time_rev_checklist" disabled>
                            </div>
                            <div class="col-md-8"></div>


                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <span id = "checkIfPendingCheck" hidden><button type="button" class="btn btn-success pull-right" data-dismiss="modal" id="btnSubmitNoteChecklist">Submit</button></span>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    
    
     <div class="modal fade" id="modal-it-archived">
        <div class="modal-dialog" style="width: 50%">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h4 style = "text-align : center">CI User List</h4>
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                <div class="row" style="padding-top : 20px;">
                                    <div class="col-md-12">
                                        <table class="table-hover table-condensed" width="100%" id = "it-dept-ci-archive-table">
                                            <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Employee ID</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Branch</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                        </table>
                                    </div>

                                </div>
                            </div>
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


@endsection

@push('leftsidebar')
    @include('it_dept.it-department-leftsidebar')
@endpush

@push('jscript')
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/1.0.7/css/responsive.dataTables.min.css">
    <script src="https://cdn.datatables.net/responsive/2.1.1/js/dataTables.responsive.min.js"></script>
    <script src="{{ asset('jscript/it-dept.js?n='.$javs) }}"></script>
@endpush
