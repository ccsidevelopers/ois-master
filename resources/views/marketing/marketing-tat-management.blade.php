{{--@extends('layouts.master')--}}

{{--@section('content')--}}

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            TAT Management
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
                        <div class="row">
                            <div class="col-md-12">
                                <div class="box box-warning">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">Manage Panel</h3>
                                    </div>
                                    <div class="box-body">


                                        <input type="hidden" id="idProvince_tat">
                                        <input type="hidden" id="idMunicipality_tat">

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Choose Location</label>
                                                    <select class="form-control select1" style="width: 100%;" id="rateMuniProv_tat">
                                                        <option>---</option>
                                                        <option value="muni_tat">Municipality</option>
                                                        <option value="prov_tat">Province</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <span id="spanMuni_tat">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>City/Municipality</label>
                                                        <input type="text" class="form-control" id="marketingMuni_tat" name="marketingMuni_tat">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>Province</label><span id="loadingProv_tat"></span>
                                                        <input type="text" class="form-control" id="marketingProv_tat" name="marketingProv_tat" disabled>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>Bank Name / Client Name</label>
                                                        <select class="form-control select2" style="width: 100%;" id="bankID_tat">
                                                            @foreach($banks_users as $banks_user)
                                                                <option value="{{ $banks_user->id }} {{ old('ciID') }}">{{ $banks_user->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label for="fw_tat_muni">FIELD WORK TAT - INTERNAL TAT (Hours):</label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <input type="number" class="form-control" id="fw_tat_muni" name="fw_tat_muni">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label for="obw_tat_muni">OFFICE BASED WORK TAT - INTERNAL TAT (Hours):</label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <input type="number" class="form-control" id="obw_tat_muni" name="obw_tat_muni">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12">
                                                      <label for="agreed_tat_muni">AGREED TAT - EXTERNAL TAT (Hours):</label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <input type="number" class="form-control" id="agreed_tat_muni" name="agreed_tat_muni">
                                                    </div>
                                                </div>
                                            </div>
                                        </span>

                                        <span id="spanProv_tat">

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>Province</label>
                                                        <select class="form-control select2" style="width: 100%;" id="provID_tat">
                                                            @foreach($provinces as $province)
                                                                <option value="{{ $province->id }} {{ old('provID') }}">{{ $province->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>Bank Name</label>
                                                        <select class="form-control select2" style="width: 100%;" id="bankBulkID_tat">
                                                            @foreach($banks as $bank)
                                                                <option value="{{ $bank->id }} {{ old('ciID') }}">{{ $bank->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>FIELD WORK TAT - INTERNAL TAT (Hours):</label>
                                                        <input type="number" class="form-control" id="fw_tat" name="fw_tat">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>OFFICE BASED WORK TAT - INTERNAL TAT (Hours):</label>
                                                        <input type="number" class="form-control" id="obw_tat" name="obw_tat">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>AGREED TAT - EXTERNAL TAT (Hours):</label>
                                                        <input type="number" class="form-control" id="agreed_tat" name="agreed_tat">
                                                    </div>
                                                </div>
                                            </div>
                                        </span>

                                    </div>
                                    <div class="box-footer">
                                        <button class="btn btn-sm btn-primary pull-right change-id" id="btn_save_tat_info" name="btn_save_tat_info">Save</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="box box-warning">
                                    <div class="box-header with-border">
                                        <h4 class="box-title">Holidays</h4>
                                    </div>
                                    <div class="box-body">
                                        <div class="form-group">
                                            <label for="holiday_title">Holiday Title:</label>
                                            <input type="text" class="form-control" id="holiday_title" placeholder="Holiday Title">
                                        </div>
                                        <div class="form-group">
                                            <label for="holiday_description">Description:</label>
                                            <textarea class="form-control" id="holiday_description" rows="5" placeholder="Holiday Description"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <input type="radio" class="holiday_type_repeat_class flat-red" name="holiday_type_repeat" value="false" checked>One Time
                                            <input type="radio" class="holiday_type_repeat_class flat-red" name="holiday_type_repeat" value="true">Yearly
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label for="holiday_startdate">Start Date:</label>
                                                    <input type="date" class="form-control" id="holiday_startdate">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="holiday_enddate">End Date:</label>
                                                    <input type="date" class="form-control" id="holiday_enddate">
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <button type="button" id="btn_save_holiday" class="btn btn-primary pull-right" >A D D</button>

                                        <!-- the events -->
                                        {{--<div id="external-events">--}}
                                            {{--<div class="external-event bg-green">Regular Holiday</div>--}}
                                            {{--<div class="external-event bg-yellow">Special Non-Working Holiday</div>--}}
                                            {{--<div class="external-event bg-aqua">Declared Holiday</div>--}}
                                        {{--</div>--}}
                                    </div>
                                    <!-- /.box-body -->
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        Holiday Calendar
                                    </div>
                                    <div class="panel-body">
                                        {{--{!! $calendar->calendar() !!}--}}
                                        <div id="calendar_tat"></div>
                                        <br>
                                        <label for="updateAccountsfrom">Update From: </label>
                                        <input type="date" class="form-control" id="updateAccountsfrom"">
                                        <label for="updateAccounts">NOTE: This "UPDATE ACCOUNTS" button will adjust only for those accounts that have greater than or equal "date endorsed" to the indicated date from "Update from", accordingly to newly updated holiday date. The rest will be the same. This will only affect those accounts that are still in the process.</label>
                                        <button type="button" id="updateAccounts" class="btn btn-warning btn-block">UPDATE ACCOUNTS</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="box box-danger">
                            <div class="box-header with-border">
                                <h3 class="box-title">Table TAT Information</h3>
                                <br>
                                <br>
                                <p><b>NOTE:</b></p>
                                <div class="col-md-2">
                                    <p>1 day = 24hrs</p>
                                    <p>2 days = 48hrs</p>
                                    <p>3 days = 72hrs</p>
                                    <p>4 days = 96hrs</p>
                                    <p>5 days = 120hrs</p>
                                </div>
                                <div class="col-md-2">
                                    <p>6 days = 144hrs</p>
                                    <p>7 days = 168hrs</p>
                                    <p>8 days = 192hrs</p>
                                    <p>9 days = 216hrs</p>
                                    <p>10 days = 240hrs</p>
                                </div>
                                <div class="col-md-2">
                                    <p>11 days = 264hrs</p>
                                    <p>12 days = 288hrs</p>
                                    <p>13 days = 312hrs</p>
                                    <p>14 days = 336hrs</p>
                                    <p>15 days = 360hrs</p>
                                </div>
                                <div class="col-md-2">
                                    <p>16 days = 384hrs</p>
                                    <p>17 days = 408hrs</p>
                                    <p>18 days = 432hrs</p>
                                    <p>19 days = 456hrs</p>
                                    <p>20 days = 480hrs</p>
                                </div>
                                <div class="col-md-2">
                                    <p>21 days = 504hrs</p>
                                    <p>22 days = 528hrs</p>
                                    <p>23 days = 552hrs</p>
                                    <p>24 days = 576hrs</p>
                                    <p>25 days = 600hrs</p>
                                </div>
                                <div class="col-md-2">
                                    <p>26 days = 624hrs</p>
                                    <p>27 days = 648hrs</p>
                                    <p>28 days = 672hrs</p>
                                    <p>29 days = 696hrs</p>
                                    <p>30 days = 720hrs</p>
                                </div>
                            </div>
                            <div class="box-header with-border">
                                <div class="box-body">
                                    <table id="marketing-table-tat-manage" class="tableendorse table-hover table-condensed" width="100%">
                                        <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Municipalities</th>
                                            <th>Provinces</th>
                                            <th>Bank Name</th>
                                            <th>FIELD WORK INTERNAL TAT(Hours)</th>
                                            <th>OFFICE BASED WORK INTERNAL TAT(Hours)</th>
                                            <th>AGREED TAT(Hours)</th>
                                            <th>DATE MODIFIED</th>
                                            <th>TIME MODIFIED</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tfoot>
                                        <tr>
                                            <th>ID</th>
                                            <th>Municipalities</th>
                                            <th>Provinces</th>
                                            <th>Bank Name</th>
                                            <th>FIELD WORK INTERNAL TAT(Hours)</th>
                                            <th>OFFICE BASED WORK INTERNAL TAT(Hours)</th>
                                            <th>AGREED TAT(Hours)</th>
                                            <th>DATE MODIFIED</th>
                                            <th>TIME MODIFIED</th>
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