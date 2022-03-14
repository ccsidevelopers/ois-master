    @extends('admin.template.master')


@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Blank page
                <small>it all starts here</small>
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">

            <!-- Default box -->
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Form Template Management Panel</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                                title="Collapse">
                            <i class="fa fa-minus"></i></button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                            <i class="fa fa-times"></i></button>
                    </div>
                </div>

                <div class="box-body">
                    <div class="box-body col-md-6">
                        <div class="box box-danger">
                            <div class="box-header with-border">
                                <h3 class="box-title">Type of Loan</h3>
                            </div>
                            <div class="form-group">
                                <div class="input-group" style="margin: 10px">
                                    <div class="input-group-btn">
                                        <button type="button" class="btn btn-primary" id="addNewTypeLoan">Add new Type of Loan</button>
                                    </div>
                                    <!-- /btn-group -->
                                    <input type="text" class="form-control" id="inputtextaddnew">
                                </div>
                                <div class="form-group">
                                    <span id="typeofloan"></span>
                                    <button type="button" class="btn btn-danger pull-right" id="DeleteType" style="margin-top: 10px;">Delete</button>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="box-body col-md-6">
                        <div class="box box-danger">
                            <div class="box-header with-border">
                                <h3 class="box-title">Add New Forms</h3>
                            </div>


                            <div class="row">
                                <div class="col-sm-6">
                                    <h4>List of forms:</h4>
                                </div>

                                <input id="deletebox" type="checkbox" name="delete" value="delete"> SELECT TO DELETE
                            </div>

                            <span id="getfiles"></span>


                            <div class="box-body">
                                <form role="form" enctype="multipart/form-data" id="regForm" method="post">
                                    <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
                                    <div class="box-body">

                                        <form method="POST" enctype="multipart/form-data">
                                            <input id="uploadform" type="file" name="file" />
                                            <button type="button" class="btn btn-primary pull-right" id="saveButtonForm">Upload Form</button>

                                        </form>
                                    </div>

                                    <!-- /.box-body -->
                                    <div class="box-footer">
                                        <div class="row">

                                        </div>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>


                    <div class="box-body col-md-12">
                        <div class="box box-danger">
                            <div class="box-header with-border">
                                <h3 class="box-title">Email System (CC)</h3>
                            </div>


                            <div class="box-body">
                                {{--<form role="form" enctype="multipart/form-data" id="regForm" method="post">--}}
                                {{--<input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">--}}
                                <div class="box-body">

                                    <div class="form-group">

                                        <div id="list1" class="form-group">
                                            <label>Client Endorsements Notification</label>
                                            <div class="row">
                                                <div class="col-md-6">

                                                    <select id="ListOfAllUser1" class="select2 select2-hidden-accessible " multiple="" data-placeholder="Select a Email" style="width: 100%;" tabindex="-1" aria-hidden="true"></select>


                                                    <span id="spancheckemails1"></span>

                                                </div>
                                                <button id="checkemails1" type="button" value="checkemails1" class="btn btn-sm " style="margin-right: 20px">Check Emails</button>

                                                <div class="btn-group">
                                                    <button id="alldispatcherendorsement" type="button" class="btn btn-sm btn-primary ">All Dispatcher</button>

                                                    <button id="allsraoendorsement" type="button" class="btn btn-sm btn-primary">All SRAO</button>
                                                    <button type="button" id="btn_remove_all_dispatcher" class="btn btn-sm btn-danger">All Dispatcher</button>
                                                    <button type="button" id="btn_remove_all_sao" class="btn btn-sm btn-danger">All SRAO</button>
                                                    <button type="button" id="btn_remove_all_endor" class="btn btn-sm btn-danger">Remove all(SAO/Dispatcher)</button>

                                                </div>


                                            </div>

                                        </div>

                                        <div class="form-group">
                                            <label>SRAO assign/transfer to AO</label>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <select id="ListOfAllUser2" class="select2 select2-hidden-accessible" multiple="" data-placeholder="Select a Email" style="width: 100%;" tabindex="-1" aria-hidden="true"></select>

                                                    <span id="spancheckemails2"></span>


                                                </div>
                                                <button id="checkemails2" type="button" value="checkemails2" class="btn btn-sm " style="margin-right: 20px">Check Emails</button>

                                                <div class="btn-group">
                                                    <button id="btn_all_sao_assign_transfer_to_ao" type="button" class="btn btn-sm btn-primary ">All SRAO</button>

                                                    <button id="btn_all_ao_assign_transfer_to_ao" type="button" class="btn btn-sm btn-primary">All AO</button>

                                                    <button id="btn_remove_all_sao_assign_transfer_to_ao" type="button" class="btn btn-sm btn-danger">All SRAO</button>

                                                    <button id="btn_remove_all_ao_assign_transfer_to_ao" type="button" class="btn btn-sm btn-danger">All AO</button>

                                                    <button type="button" id="btn_remove_all_assign_transfer" class="btn btn-sm btn-danger">Remove all</button>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>DISPATCHER dispatch/transfer CI </label>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <select id="ListOfAllUser3" class="select2 select2-hidden-accessible" multiple="" data-placeholder="Select a Email" style="width: 100%;" tabindex="-1" aria-hidden="true"></select>

                                                    <span id="spancheckemails3"></span>


                                                </div>
                                                <button id="checkemails3" type="button" value="checkemails3" class="btn btn-sm " style="margin-right: 20px">Check Emails</button>

                                                <div class="btn-group">
                                                    <button type="button" id="btn_all_dispatcher_dispatch_transfer" class="btn btn-sm btn-primary ">All Dispatcher</button>

                                                    <button type="button" id="btn_all_ci_dispatch_transfer" class="btn btn-sm btn-primary">All CI</button>

                                                    <button type="button" id="btn_remove_all_dispatch_transfer" class="btn btn-sm btn-danger">Remove all</button>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Finish Accounts(Success and Overdue)</label>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <select id="ListOfAllUser4" class="select2 select2-hidden-accessible" multiple="" data-placeholder="Select a Email" style="width: 100%;" tabindex="-1" aria-hidden="true"></select>

                                                    <span id="spancheckemails4"></span>


                                                </div>
                                                <button id="checkemails4" type="button" value="checkemails4" class="btn btn-sm " style="margin-right: 20px">Check Emails</button>

                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-sm btn-primary ">All</button>

                                                    <button type="button" class="btn btn-sm btn-primary">Admins Only(Management)</button>

                                                    <button type="button" class="btn btn-sm btn-danger">Remove all</button>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Marketing</label>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <select id="ListOfAllUser5" class="select2 select2-hidden-accessible" multiple="" data-placeholder="Select a Email" style="width: 100%;" tabindex="-1" aria-hidden="true"></select>

                                                    <span id="spancheckemails5"></span>

                                                </div>
                                                <button id="checkemails5" type="button" value="checkemails5" class="btn btn-sm " style="margin-right: 20px">Check Emails</button>

                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-sm btn-primary ">Managements</button>

                                                    <button type="button" class="btn btn-sm btn-danger">Remove all</button>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.box-body -->
                                    <div class="box-footer">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <span id="pops"></span>
                                            </div>
                                            <button type="button" class="btn btn-primary pull-right" id="ApplyEmail">Apply</button>
                                        </div>
                                    </div>
                                </div>
                                </form>
                            </div>

                            <div id="loads" class="overlay" hidden>
                                <i id="loaads" class="fa fa-refresh fa-spin" hidden></i>
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
    {{ csrf_field() }}

@endsection

@push('jscript')

    <script src="{{ asset('jscript/admin.js') }}"></script>

@endpush