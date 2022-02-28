{{--@extends('layouts.master')--}}

{{--@section('content')--}}

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Marketing Management
            <small>B.I</small>
        </h1>

    </section>

    <!-- Main content -->
    <section class="content">

        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Rates</h3>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="nav-tabs-custom">
                                    <ul class="nav nav-tabs">
                                        <li class="active">
                                            <a href="#bi_rates_tab1" class="bi_rates_tabs" data-toggle="tab">Add Rate</a>
                                        </li>
                                        <li class="">
                                            <a href="#bi_rates_tab2" class="bi_rates_tabs" data-toggle="tab">Add Rate (Per Municipality Ocular)</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content">
                                        {{--tab 1--}}

                                        <div class="tab-pane active" id="bi_rates_tab1">

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="panel panel-default">
                                                        <div class="panel-body">
                                                            <div class="nav-tabs-custom">
                                                                <ul class="nav nav-tabs">
                                                                    <li class="active">
                                                                        <a href="#add_to_package" class="bi_rates_tab" data-toggle="tab" data-expand="true">Package</a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="#add_to_alacarte" class="bi_rates_tab" data-toggle="tab" data-expand="false">Alacarte</a>
                                                                    </li>
                                                                </ul>
                                                                <div class="tab-content">

                                                                    <div class="tab-pane active" id="add_to_package">
                                                                        <div class="row">
                                                                            <div class="col-md-3">
                                                                                <div class="box box-warning">
                                                                                    <div class="box-header with border">
                                                                                        <h3 class="box-title">Add Rate (Package)</h3>
                                                                                    </div>
                                                                                    <div class="box-body">
                                                                                        <div class="form-group">
                                                                                            <label>Choose a Client :</label>
                                                                                            <select name="" id="bi_rates_client_name" class="form-control select2" style="width: 100%;">
                                                                                                <option value="-">-</option>
                                                                                            </select>
                                                                                            <span id="bi_rates_packagename_span">
                                                                                        <label>Choose a Package :</label>
                                                                                        <select name="" id="bi_rates_packagename" class="form-control select2" style="width: 100%;" disabled>
                                                                                            <option value="-">-</option>
                                                                                        </select>
                                                                                    </span>

                                                                                            <span id="bi_addrate_amount_span">
                                                                                        <label>Insert amount :</label>
                                                                                        <input type="number" id="bi_addrate_amount" class="form-control" disabled title="Choose package">
                                                                                        <button id="add_bi_rate" class="btn btn-sm btn-success pull-right" style="margin-top: 15px;">SUBMIT <i class="glyphicon glyphicon-ok"></i></button>
                                                                                    </span>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-md-9">
                                                                                <div class="row">
                                                                                    <div class="col-md-12">
                                                                                        <div class="box box-primary">
                                                                                            <div class="box-header with border">
                                                                                                <h3 class="box-title">Table Rate List</h3>
                                                                                            </div>
                                                                                            <div class="box-body">
                                                                                                <table class="table-condensed table-hover" width="100%" id="bi_rate_table">
                                                                                                    <thead>
                                                                                                    <tr>
                                                                                                        <th>ID</th>
                                                                                                        <th>PACKAGE</th>
                                                                                                        <th>CLIENT NAME</th>
                                                                                                        <th>RATE</th>
                                                                                                        <th>DATE/TIME CREATED</th>
                                                                                                        <th>ACTION</th>
                                                                                                    </tr>
                                                                                                    </thead>
                                                                                                </table>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>


                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="tab-pane" id="add_to_alacarte">
                                                                        <div class="row">
                                                                            <div class="col-md-3">
                                                                                <div class="box box-warning">
                                                                                    <div class="box-header with border">
                                                                                        <h3 class="box-title">Add Rate (Alacarte)</h3>
                                                                                    </div>
                                                                                    <div class="box-body">
                                                                                        <div class="form-group">
                                                                                            <label>Choose a Client :</label>
                                                                                            <select name="" id="bi_rates_client_name_alacarte" class="form-control select2 validateSelectInput" style="width: 100%;">
                                                                                                <option value="-">-</option>
                                                                                            </select>
                                                                                            <span id="bi_rates_packagename_span">
                                                                                        <label>Choose a Checking :</label>
                                                                                        <select name="" id="bi_rates_packagename_alacarte" class="form-control select2 validateSelectInput" style="width: 100%;" disabled>
                                                                                            <option value="-">-</option>
                                                                                        </select>
                                                                                        <label>Ocular Checking :</label>
                                                                                        <select name="" id="bi_rates_ocular_alacarte" class="form-control select2 validateSelectInput" style="width: 100%;" disabled>
                                                                                            <option value="-">-</option>
                                                                                            <option value="false">NON-OCULAR</option>
                                                                                            <option value="true">WITH OCULAR</option>
                                                                                        </select>
                                                                                    </span>

                                                                                            <span id="bi_addrate_amount_span">
                                                                                        <label>Insert amount :</label>
                                                                                        <input type="number" id="bi_addrate_amount_alacarte" class="form-control" disabled title="Choose package">
                                                                                        <button id="add_bi_rate_alacarte" class="btn btn-sm btn-success pull-right" style="margin-top: 15px;">SUBMIT <i class="glyphicon glyphicon-ok"></i></button>
                                                                                    </span>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-md-9">
                                                                                <div class="row">
                                                                                    <div class="col-md-12">
                                                                                        <div class="box box-primary">
                                                                                            <div class="box-header with border">
                                                                                                <h3 class="box-title">Table Rate List</h3>
                                                                                            </div>
                                                                                            <div class="box-body">
                                                                                                <table class="table-condensed table-hover" width="100%" id="bi_rate_table_alacarte">
                                                                                                    <thead>
                                                                                                    <tr>
                                                                                                        <th>ID</th>
                                                                                                        <th>CHECKING</th>
                                                                                                        <th>CLIENT NAME</th>
                                                                                                        <th>OCULAR</th>
                                                                                                        <th>RATE</th>
                                                                                                        <th>DATE/TIME CREATED</th>
                                                                                                        <th>ACTION</th>
                                                                                                    </tr>
                                                                                                    </thead>
                                                                                                </table>
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
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{--tab 2--}}

                                        <div class="tab-pane" id="bi_rates_tab2">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="panel panel-default">
                                                        <div class="panel-body">
                                                            <div class="row">
                                                                <div class="col-md-3">
                                                                    <div class="box box-warning">
                                                                        <div class="box-header with border">
                                                                            <h3 class="box-title">Add Rate Per Area</h3>
                                                                        </div>
                                                                        <div class="box-body">
                                                                            <label>Choose a Client :</label>
                                                                            <select name="" id="bi_rates_client_name_tab2" class="form-control select2" style="width: 100%;">
                                                                                <option value="-">-</option>
                                                                            </select>

                                                                            <span id="bi_rates_mun_prov_span" style="margin-top: 15px;">
                                                                <label for="bi_rates_mun_prov">Choose Type of Adding Rate :</label>
                                                                <select name="" id="bi_rates_mun_prov" class="form-control">
                                                                    <option value="-">-</option>
                                                                    <option value="Municipality">Municipality</option>
                                                                    <option value="Province">Province</option>
                                                                </select>
                                                            </span>

                                                                            <span id="show_bi_tab2_muni" hidden>
                                                                <label for="bi_rates_muni">Type Municipalilty :</label>
                                                                <input type="text" class="form-control" id="bi_rates_muni">
                                                                <input type="hidden" value="" id="bi_rates_origMun_id">
                                                                <label for="bi_rates_origMun">Province :</label>
                                                                <input type="text" class="form-control" disabled value="" id="bi_rates_origMun">
                                                                <input type="hidden" value="" id="bi_rates_muni_id">
                                                            </span>

                                                                            <span id="show_bi_tab2_prov" hidden>
                                                                <label for="bi_rates_muni">Type Province :</label>
                                                                <select type="text" class="form-control select2" id="bi_rates_prov" style="width: 100%">
                                                                    <option value="-">-</option>
                                                                </select>
                                                            </span>

                                                                            <span id="bi_addrate_amount_tab2_span" hidden style="margin-top: 15px;">
                                                                <label>Insert amount :</label>
                                                                <input type="number" id="bi_addrate_amount_tab2" class="form-control">
                                                                <button id="add_bi_rate_tab_2" class="btn btn-md btn-success pull-right" style="margin-top: 15px;">SUBMIT <i class="glyphicon glyphicon-ok"></i></button>
                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-9">
                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                            <div class="box box-primary">
                                                                                <div class="box-header with border">
                                                                                    <h3 class="box-title">Table Rate List</h3>
                                                                                </div>
                                                                                <div class="box-body">
                                                                                    <table class="table-condensed table-hover" width="100%" id="bi_rate_per_area_table">
                                                                                        <thead>
                                                                                        <tr>
                                                                                            <th>ID</th>
                                                                                            <th>MUNICIPALITIES</th>
                                                                                            <th>PROVINCES</th>
                                                                                            <th>CLIENT NAME</th>
                                                                                            <th>RATE</th>
                                                                                            <th>DATE/TIME CREATED</th>
                                                                                            <th>ACTION</th>
                                                                                        </tr>
                                                                                        </thead>
                                                                                    </table>
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
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

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