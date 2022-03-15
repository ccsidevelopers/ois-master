{{--@extends('layouts.master')--}}

{{--@section('content')--}}

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Marketing Management
            <small>Clients</small>
        </h1>

    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Rates</h3>
            </div>
            <div class="box-body">

                <div class="row">
                    <div class="col-md-12">
                        <!-- Custom Tabs -->
                        <div class="nav-tabs-custom">
                            <ul class="nav nav-tabs">
                                <li class="active"><a id="tab1" href="#tab_z" data-toggle="tab" class = "marketing-manage_a_class">Add Rate</a></li>
                                <li><a id="tab2" href="#tab_x" data-toggle="tab" class = "marketing-manage_a_class">Standard Rate</a></li>
                            </ul>

                            <div class="tab-content">

                                <div class="tab-pane active" id="tab_z">
                                    <div class="row">
                                        <input type="hidden" id="idProvince">
                                        <input type="hidden" id="idMunicipality">

                                        <div class="col-md-3">
                                            <div class="box box-warning">
                                                <div class="box-header with-border">
                                                    <h3 class="box-title">Add Rate</h3>
                                                </div>
                                                <div class="box-body">

                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label>Choose Type of Adding Rate</label>
                                                                <select class="form-control select1" style="width: 100%;" id="rateMuniProv">
                                                                    <option>---</option>
                                                                    <option value="muni">Municipality</option>
                                                                    <option value="prov">Province</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <span id="spanMuni">

                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label>City/Municipality</label>
                                                                        <input type="text" class="form-control" id="marketingMuni" name="marketingMuni">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label>Province</label><span id="loadingProv"></span>
                                                                        <input type="text" class="form-control" id="marketingProv" name="marketingProv" disabled>
                                                                    </div>
                                                                </div>
                                                            </div>


                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label>Bank Name</label>
                                                                        <select class="form-control select2" style="width: 100%;" id="bankID">
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
                                                                        <label>Rate</label>
                                                                        <input type="number" class="form-control" id="txtBankRate" name="txtBankRate">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </span>

                                                    <span id="spanProv">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label>Province</label>
                                                                        <select class="form-control select2" style="width: 100%;" id="provID">
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
                                                                        <select class="form-control select2" style="width: 100%;" id="bankBulkID">
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
                                                                        <label>Rate</label>
                                                                        <input type="number" class="form-control" id="txtBulkRate" name="txtBulkRate">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </span>

                                                </div>

                                                <div class="box-footer">
                                                    <button class="btn btn-sm btn-primary pull-right change-id" id="btnSubmitRate" name="btnSubmitRate">Submit</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="box box-primary">
                                                <div class="box-header with-border">
                                                    <h3 class="box-title">Table Rate List</h3>
                                                </div>
                                                <!-- /.box-header -->
                                                <!-- form start -->
                                                <div class="box-body">
                                                    <table id="marketing-manage" class="tableendorse table-condensed table-hover" width="100%">
                                                        <thead>
                                                        <tr>
                                                            <th>id</th>
                                                            <th>Municipalities</th>
                                                            <th>Provinces</th>
                                                            <th>Bank Name</th>
                                                            <th>Rate</th>
                                                            <th>Action</th>
                                                        </tr>
                                                        </thead>
                                                        <tfoot>
                                                        <tr>
                                                            <th>id</th>
                                                            <th>Municipalities</th>
                                                            <th>Provinces</th>
                                                            <th>Bank Name</th>
                                                            <th>Rate</th>
                                                            <th>Action</th>
                                                        </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                                <!-- /.box-body -->
                                                <div class="box-footer">
                                                    {{--<button type="submit" class="btn btn-primary">Submit</button>--}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane" id="tab_x">
                                    <div class="row">

                                        <input type="hidden" id="idProvince2">
                                        <input type="hidden" id="idMunicipality2">

                                        <div class="col-md-3">
                                            <div class="box box-warning">
                                                <div class="box-header with-border">
                                                    <h3 class="box-title">Add Rate</h3>
                                                </div>
                                                <div class="box-body">

                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label>Choose Type of Submitting Rate</label>
                                                                <select class="form-control select1" style="width: 100%;" id="rateMuniProv2">
                                                                    <option>---</option>
                                                                    <option value="muni2">Municipality</option>
                                                                    <option value="prov2">Province</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <span id="spanMuni2">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label>City/Municipality</label>
                                                                        <input type="text" class="form-control" id="marketingMuni2" name="marketingMuni2">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label>Province</label><span id="loadingProv"></span>
                                                                        <input type="text" class="form-control" id="marketingProv2" name="marketingProv2" disabled>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label>Rate</label>
                                                                        <input type="number" class="form-control" id="txtBankRate2" name="txtBankRate2">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label>12% VAT</label>
                                                                        <input type="number" class="form-control" id="txtVATmuni2" name="txtVATmuni2" disabled>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label>Total Rate</label>
                                                                        <input type="number" class="form-control" id="txtMuniTotalRate2" name="txtMuniTotalRate2" disabled>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label>TAT (must be converted to hours)</label>
                                                                        <input type="number" class="form-control" id="txtAgreedTATmuni2" name="txtAgreedTATmuni2">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <button class="btn btn-sm btn-primary pull-right change-id" id="btnSubmitStandardRate" name="btnSubmitStandardRate">Submit</button>
                                                        </span>

                                                    <span id="spanProv2">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label>Province</label>
                                                                        <select class="form-control select2" style="width: 100%;" id="provID2">
                                                                            @foreach($provinces as $province)
                                                                                <option value="{{ $province->id }} {{ old('provID2') }}">{{ $province->name }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label>Rate</label>
                                                                        <input type="number" class="form-control" id="txtBulkRate2" name="txtBulkRate2">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label>12% VAT</label>
                                                                        <input type="number" class="form-control" id="txtVATprov2" name="txtVATprov2" disabled>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label>Total Rate</label>
                                                                        <input type="number" class="form-control" id="txtProvTotalRate2" name="txtProvTotalRate2" disabled>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label>TAT (must be converted to hours)</label>
                                                                        <input type="number" class="form-control" id="txtAgreedTATprov2" name="txtAgreedTATprov2">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                         <button class="btn btn-sm btn-primary pull-right change-id" id="btnStandardBulkRate" name="btnStandardBulkRate">Submit</button>
                                                        </span>

                                                </div>

                                                <div class="box-footer" id = "btnNone">
                                                    <button class="btn btn-sm btn-primary pull-right change-id" id="btnSubmitNone" name="btnSubmitNone">Submit</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="box box-primary">
                                                <div class="box-header with-border">
                                                    <h3 class="box-title">Table Rate List</h3>
                                                </div>
                                                <!-- /.box-header -->
                                                <!-- form start -->
                                                <div class="box-body">
                                                    <table id="marketing-table-manage-rate" class="tableendorse table-condensed table-hover" width="100%">
                                                        <thead>
                                                        <tr>
                                                            <th>id</th>
                                                            <th>Municipalities</th>
                                                            <th>Provinces</th>
                                                            <th>Rate</th>
                                                            <th>12% VAT</th>
                                                            <th>TAT</th>
                                                            <th>Total Rate</th>
                                                            <th>Action</th>
                                                        </tr>
                                                        </thead>
                                                        <tfoot>
                                                        <tr>
                                                            <th>id</th>
                                                            <th>Municipalities</th>
                                                            <th>Provinces</th>
                                                            <th>Rate</th>
                                                            <th>12% VAT</th>
                                                            <th>TAT</th>
                                                            <th>Total Rate</th>
                                                            <th>Action</th>
                                                        </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                                <!-- /.box-body -->
                                                <div class="box-footer">
                                                    {{--<button type="submit" class="btn btn-primary">Submit</button>--}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- /.box-body -->
            <div class="box-footer">

                {{--UPDATE RATE MODAL--}}
                <div class="modal modal-default fade" id="modal-updaterate">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Error 500!</h4>
                            </div>
                            <div class="modal-body">
                                <p style="text-align: center">UPDATE RATE</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline pull-right" data-dismiss="modal" id="btnModalCloseFillUpError">Close</button>
                            </div>
                        </div>
                    </div>
                </div>

                {{--FILL UP ERROR MODAL--}}
                <div class="modal modal-danger fade" id="modal-filluperror">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Error 500!</h4>
                            </div>
                            <div class="modal-body">
                                <p style="text-align: center">Please fill up all necessary field/s</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline pull-right" data-dismiss="modal" id="btnModalCloseFillUpError">Close</button>
                            </div>
                        </div>
                    </div>
                </div>

                {{--FILL UP ERROR MODAL--}}
                <div class="modal modal-danger fade" id="modal-duplicate">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Error 502!</h4>
                            </div>
                            <div class="modal-body">
                                <p style="text-align: center">Duplicated details!!</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline pull-right" data-dismiss="modal" id="btnModalCloseFillUpError">Close</button>
                            </div>
                        </div>
                    </div>
                </div>

                {{--SENDING MODAL--}}
                <div class="modal modal-info fade" id="modal-sendingrequest">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Sending...</h4>
                            </div>
                            <div class="modal-body">
                                <p style="text-align: center">Please wait while request is being sent.  <img src="{{ asset('dist/img/loading.gif') }}" style="width: 5%;"></p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline pull-right" data-dismiss="modal" id="btnModalCloseSending">Close</button>
                            </div>
                        </div>
                    </div>
                </div>

                {{--SUCCESS MODAL--}}
                <div class="modal modal-success fade" id="modal-sentsuccess">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Success!</h4>
                            </div>
                            <div class="modal-body">
                                <p style="text-align: center">Successfully Added Rate</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline pull-right" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>

                {{--FILL UP ERROR MODAL--}}
                <div class="modal modal-danger fade" id="modal-existing">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Error 500!</h4>
                            </div>
                            <div class="modal-body">
                                <p style="text-align: center">Bank Rate is already existing, please refer to table beside and search for update</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline pull-right" data-dismiss="modal" id="btnModalCloseFillUpError">Close</button>
                            </div>
                        </div>
                    </div>
                </div>


                {{--EDIT MODAL--}}
                <div class="modal fade" id="modal-rateedit">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title"><span id = "NameRecord"></span></h4>
                            </div>
                            <div class="modal-body">
                               <span id="spanMuni3">


                                   <div class="row">
                                       <div class="col-md-12">
                                           <div class="form-group">
                                               <label>Rate</label>
                                               <input type="number" class="form-control" id="editBankRate" name="txtBankRate2">
                                           </div>
                                       </div>
                                   </div>

                                   <div class="row">
                                       <div class="col-md-6">
                                           <div class="form-group">
                                               <label>12% VAT</label>
                                               <input type="number" class="form-control" id="editVAT" name="txtVATmuni2" disabled>
                                           </div>
                                       </div>
                                       <div class="col-md-6">
                                           <div class="form-group">
                                               <label>Total Rate</label>
                                               <input type="number" class="form-control" id="editTotalRate" name="editTotalRate" disabled>
                                           </div>
                                       </div>
                                   </div>

                                   <div class="row">
                                       <div class="col-md-12">
                                           <div class="form-group">
                                               <label>TAT (must be converted to hours)</label>
                                               <input type="number" class="form-control" id="editTAT" name="editTAT">
                                           </div>
                                       </div>

                                   </div>
                               </span>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                                <button type="button" id = "btnUpdateStandard" class="btn btn-primary">Save changes</button>
                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>



                {{--UPDATE SUCCESS MODAL--}}
                <div class="modal modal-success fade" id="modal-update">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Success!</h4>
                            </div>
                            <div class="modal-body">
                                <p style="text-align: center">Successfully Updated</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline pull-right" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>

                {{--DELETE SENDING MODAL--}}

                <div class="modal modal-info fade" id="modal-requestDelete">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Deleting...</h4>
                            </div>
                            <div class="modal-body">
                                <p style="text-align: center">Please wait request is being sent.  <img src="{{ asset('dist/img/loading.gif') }}" style="width: 5%;"></p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline pull-right" data-dismiss="modal" id="btnModalCloseSending">Close</button>
                            </div>
                        </div>
                    </div>
                </div>



                {{--DELETE SUCCESS MODAL--}}
                <div class="modal modal-danger fade" id="modal-delete">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title"></h4>
                            </div>
                            <div class="modal-body">
                                <p style="text-align: center">Successfully Deleted</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline pull-right" data-dismiss="modal" id="btnModalCloseFillUpError">Close</button>
                            </div>
                        </div>
                    </div>
                </div>


                {{--STANDARD RATE EXISTING--}}
                <div class="modal modal-danger fade" id="modal-existingStandard">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Error 500!</h4>
                            </div>
                            <div class="modal-body">
                                <p style="text-align: center">The selected municipality has a record that exists. Please update individual rate on the table.</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline pull-right" data-dismiss="modal" id="btnModalCloseFillUpError">Close</button>
                            </div>
                        </div>
                    </div>
                </div>

                {{--Add Rate existing MODAL--}}
                <div class="modal modal-danger fade" id="modal-existing">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Error 500!</h4>
                            </div>
                            <div class="modal-body">
                                <p style="text-align: center">Bank Rate is already existing, please refer to table beside and search for update</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline pull-right" data-dismiss="modal" id="btnModalCloseFillUpError">Close</button>
                            </div>
                        </div>
                    </div>
                </div>




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

{{--<script src="https://cdn.datatables.net/buttons/1.5.0/js/dataTables.buttons.min.js"></script>--}}
{{--<script src="https://cdn.datatables.net/buttons/1.5.0/js/buttons.flash.min.js"></script>--}}
{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>--}}
{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>--}}
{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>--}}

{{--<script src="https://cdn.datatables.net/buttons/1.5.0/js/buttons.html5.min.js"></script>--}}
{{--<script src="https://cdn.datatables.net/buttons/1.5.0/js/buttons.print.min.js"></script>--}}
{{--<script src="{{ asset('jscript/marketing.js') }}"></script>--}}
{{--@endpush--}}