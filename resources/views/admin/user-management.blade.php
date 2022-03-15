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
            <div class="row">
                <div class="col-md-12">
                    <!-- Custom Tabs -->
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li class="active"><a id="tab1" href="#tab_1" data-toggle="tab">List of Active</a></li>
                            <li><a id="tab2" href="#tab_2" data-toggle="tab">List of Archive</a></li>
                            <li><a id="tab3" href="#tab_3" data-toggle="tab">List of Blocked</a></li>
                        </ul>

                        <div class="tab-content">
                            <div class="tab-pane active" id="tab_1">
                                <!-- Default box -->
                                <div class="box">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">User Management Panel</h3>
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
                                                <div class="box-header with-border">
                                                    <h3 class="box-title">List of Users</h3>
                                                    <button type="submit" class="btn btn-primary pull-right" data-toggle="modal" data-target="#showModal" id="addNew" style="margin-bottom: 5px">Add New User <i class="fa fa-user-plus"></i></button>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <button type="submit" class="btn btn-primary pull-right" data-toggle="modal" data-target="#modal_add_bi_account" id="" style="margin-bottom: 5px">Add/Edit B.I Account <i class="fa fa-plus"></i></button>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <button type="submit" class="btn btn-primary pull-right" data-toggle="modal" data-target="#bi-change-view" id="change-view-bi" style="margin-bottom: 5px">Edit B.I Client View <i class="glyphicon glyphicon-pencil"></i></button>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <button type="submit" class="btn btn-primary pull-right" data-toggle="modal" data-target="#modal-tele-level" id="change-view-bi" style="margin-bottom: 5px">Edit Tele Level <i class=""></i></button>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <button type="submit" class="btn btn-primary pull-right" data-toggle="modal" data-target="#modal-email-receiver" id="email-segregation" style="margin-bottom: 5px">Add / Remove Email Receiver<i class=""></i></button>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <button type="submit" class="btn btn-primary pull-right" data-toggle="modal" data-target="#modal-email-distrib-list" id="email-distrib">Distribution List<i class=""></i></button>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row" style="padding-top: 5px">
                                                        <div class="col-md-12">
                                                            <button type="submit" class="btn btn-primary pull-right" data-toggle="modal" data-target="#modal-show-location-users-bi" id="bi-select-loc">User Locations<i class=""></i></button>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="modal fade" id="showModal">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span></button>
                                                                <h4 class="modal-title" id="modalTitle"></h4>
                                                            </div>

                                                            <div class="modal-body">
                                                                <div class="box-body">
                                                                    <form role="form" enctype="multipart/form-data" id="regForm" method="post">
                                                                        <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
                                                                        <div class="box-body">
                                                                            <input type="hidden" id="id">
                                                                            <div class="form-group">
                                                                                <label for="emp_id">Employee ID</label>
                                                                                <input type="text" class="form-control" id="emp_id" placeholder="Enter ID">
                                                                                <span id="validation"></span>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="name">Name</label>
                                                                                <input type="text" class="form-control" id="name" placeholder="Enter Name">
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="email">Email address</label>
                                                                                <input type="email" class="form-control" id="email" placeholder="Enter Email">
                                                                            </div>
                                                                            <div class="form-group" id="spassword">
                                                                                <label for="password">Password</label><button type="button" style="margin-left: 5px; margin-bottom: 5px" class="btn btn-sm btn-info" id="generate_password">Generate Password</button>
                                                                                <input type="text" class="form-control" id="password" placeholder="Password">
                                                                            </div>
                                                                            <div class="form-group" id="rpassword">
                                                                                <label for="password">Password</label>
                                                                                <input type="text" class="form-control" id="revealpassword" placeholder="Password">
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label>Position</label>
                                                                                <select class="form-control" id="position" required>
                                                                                    @foreach($roles as $role)
                                                                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                                                                    @endforeach
                                                                                </select>
                                                                                <span id="showgrants"></span>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <span id="show_client_branch" hidden>
                                                                                    <label>Client Branch</label>
                                                                                    <select id="client_branch" class="form-control">
                                                                                        @foreach($client_branches as $client_branch)
                                                                                            <option id="{{ $client_branch->id }}" name="{{ $client_branch->name }}" value="{{ $client_branch->id }}">{{ $client_branch->name }}</option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                </span>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label>Branch</label>
                                                                                <select class="form-control" id="branch" required>
                                                                                    @foreach($provinces as $province)
                                                                                        <option value="{{ $province->id }}">{{ $province->name }}</option>
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="exampleInputFile">File input</label>
                                                                                <input type="file" name="image" id="image">
                                                                            </div>
                                                                        </div>
                                                                        <!-- /.box-body -->
                                                                        <div class="box-footer">
                                                                            <button type="button" class="btn btn-primary pull-right" id="saveButton">Submit</button>
                                                                            <button type="button" data-dismiss="modal" class="btn btn-primary pull-right" id="updateButton">Update</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>

                                                        </div>
                                                        <!-- /.modal-content -->
                                                    </div>
                                                    <!-- /.modal-dialog -->
                                                </div>

                                                <div class="modal fade" id="modal_add_bi_account">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span></button>
                                                                <h4 class="modal-title">Add/Edit B.I Accoount</h4>
                                                            </div>

                                                            <div class="modal-body">
                                                                <div class="box-body">
                                                                    <div class="nav-tabs-custom">
                                                                        <ul class="nav nav-tabs">
                                                                            <li class="active">
                                                                                <a href="#tabtab1" data-toggle="tab" aria-expanded="true">Packages</a>
                                                                            </li>
                                                                            <li>
                                                                                <a href="#tabtab2" data-toggle="tab" aria-expanded="false" id="btn_checking">Checking</a>
                                                                            </li>
                                                                        </ul>
                                                                        <div class="tab-content">


                                                                            {{--TAAAAAAAAAAAAAABBBBBBBBBBBBB1--}}

                                                                            <div class="tab-pane active" id="tabtab1">

                                                                                <div class="col-md-12 form-group">
                                                                                    <input checked type = "radio" class="pull" name="bi_account" id="radio_bi_add">Add
                                                                                    <input type = "radio" name="bi_account" id="radio_bi_edit">Edit
                                                                                </div>
                                                                                <div class="row" id="select_bi_row" hidden>
                                                                                    <div class="col-md-12 form-group">
                                                                    <span id="select_edit_bi_account">
                                                                    </span>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row">
                                                                                    <div class="col-md-12 form-group">
                                                                                        <label for="bi_account_name">Account/Site Name</label>
                                                                                        <input type="text" class="form-control" id="bi_account_name" placeholder="Enter Account/Site Name">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row">
                                                                                    <div class="col-md-12 form-group">
                                                                                        <label for="bi_location">Location</label>
                                                                                        <input type="text" class="form-control" id="bi_location" placeholder="Enter Location">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row">
                                                                                    <div class="col-md-12 form-group">
                                                                                        <label for="">Packages</label>
                                                                                        <form id = "">
                                                                                            <table class="table-condensed table-hover" id="table_bi_package" width="100%">
                                                                                                <thead id="package_head">
                                                                                                <tr>
                                                                                                    <th>Package Name</th>
                                                                                                    <th><button type = "button" class = " btn_add_package btn btn-success btn-sm form-control"><i class = "fa fa-fw fa-plus"></i></button></th>
                                                                                                </tr>
                                                                                                </thead>
                                                                                            </table>
                                                                                        </form>
                                                                                        {{--<input type="text" class="form-control" id="bi_localtion" placeholder="Enter Location">--}}
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row">
                                                                                    <div class="col-md-12 form-group">
                                                                                        <label for="">Other Checking</label>
                                                                                        <form id = "">
                                                                                            <table class="table-condensed table-hover" id="table_bi_other_checking" width="100%">
                                                                                                <thead id="other_checking_head">
                                                                                                <tr>
                                                                                                    <th>Other Checking Name</th>
                                                                                                    <th>Information</th>
                                                                                                    <th>Ocular</th>
                                                                                                    <th><button type = "button" class = " btn_add_other_checking btn btn-success btn-sm form-control"><i class = "fa fa-fw fa-plus"></i></button></th>
                                                                                                </tr>
                                                                                                </thead>
                                                                                            </table>
                                                                                        </form>
                                                                                        {{--<input type="text" class="form-control" id="bi_localtion" placeholder="Enter Location">--}}
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row">
                                                                                    <div class="col-md-12 form-group">
                                                                                        <button type = "button" id="btn_submit_bi_account" class = "btn btn-info btn-sm pull-right">Submit</button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            {{--TAAAAAAAAAAABBBBBBBBBBBBBBB2--}}

                                                                            <div class="tab-pane" id="tabtab2">
                                                                                <div class="box-body">
                                                                                    <div class="nav-tabs-custom">
                                                                                        <ul class="nav nav-tabs">
                                                                                            <li class="active"><a href="#AddChecksItem" data-toggle="tab" aria-expanded="true">Add</a></li>
                                                                                            <li class=""><a href="#EditChecksItem" data-toggle="tab" aria-expanded="false">Edit</a></li>
                                                                                        </ul>
                                                                                        <div class="tab-content">
                                                                                            <div class="tab-pane active" id="AddChecksItem">
                                                                                                <div class="nav-tabs-custom">
                                                                                                    <ul class="nav nav-tabs">
                                                                                                        <li class="active"><a href="#taber1" data-toggle="tab" aria-expanded="true">Upon Endorsement</a></li>
                                                                                                        <li class=""><a href="#taber2" data-toggle="tab" aria-expanded="false">During Endorsement</a></li>
                                                                                                        <li class=""><a href="#taber3" data-toggle="tab" aria-expanded="false">After Endorsement</a></li>
                                                                                                    </ul>
                                                                                                    <div class="tab-content">
                                                                                                        <div class="tab-pane active" id="taber1">
                                                                                                            <table class="table-condensed" id="upon_endorsementtbl" width="100%" style="font-weight: bold;">
                                                                                                                <tr>
                                                                                                                    <td>Document/ Attachment</td>
                                                                                                                    <td colspan="1">Action</td>
                                                                                                                    <td colspan="1"><button class="form-control btn btn-sm btn-success" id="upon_addToList"><i class="fa fa-fw fa-plus"></i></button></td>
                                                                                                                </tr>
                                                                                                            </table>
                                                                                                            <button id="btnUponEnd" style="margin-top: 20px;" class="btn btn-sm btn-success pull-right">Submit</button>
                                                                                                        </div>

                                                                                                        <div class="tab-pane" id="taber2">
                                                                                                            <table class="table-condensed" id="during_endorsementtbl" width="100%" style="font-weight: bold;">
                                                                                                                <tr>
                                                                                                                    <td>Document/ Attachment</td>
                                                                                                                    <td colspan="1">Action</td>
                                                                                                                    <td colspan="1"><button class="form-control btn btn-sm btn-success" id="during_addToList"><i class="fa fa-fw fa-plus"></i></button></td>
                                                                                                                </tr>
                                                                                                            </table>
                                                                                                            <button id="btnDurEnd" style="margin-top: 20px;" class="btn btn-sm btn-success pull-right">Submit</button>
                                                                                                        </div>

                                                                                                        <div class="tab-pane" id="taber3">
                                                                                                            <table class="table-condensed" id="after_endorsementtbl" width="100%" style="font-weight: bold;">
                                                                                                                <tr>
                                                                                                                    <td>Document/ Attachment</td>
                                                                                                                    <td colspan="1">Action</td>
                                                                                                                    <td colspan="1"><button class="form-control btn btn-sm btn-success" id="after_addToList"><i class="fa fa-fw fa-plus"></i></button></td>
                                                                                                                </tr>
                                                                                                            </table>
                                                                                                            <button id="btnAfterEnd" style="margin-top: 20px;" class="btn btn-sm btn-success pull-right">Submit</button>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>

                                                                                            <div class="tab-pane" id="EditChecksItem">
                                                                                                <div class="nav-tabs-custom">
                                                                                                    <ul class="nav nav-tabs">
                                                                                                        <li class="active"><a href="#taber11" data-toggle="tab" aria-expanded="true">Upon Endorsement</a></li>
                                                                                                        <li class=""><a href="#taber22" data-toggle="tab" aria-expanded="false">During Endorsement</a></li>
                                                                                                        <li class=""><a href="#taber33" data-toggle="tab" aria-expanded="false">After Endorsement</a></li>
                                                                                                    </ul>
                                                                                                    <div class="tab-content">
                                                                                                        <div class="tab-pane active" id="taber11">
                                                                                                            <table class="table-condensed" id="upon_endorsementtbl_edit" width="100%" style="font-weight: bold;">
                                                                                                                <tr>
                                                                                                                    <td>Document/ Attachment</td>
                                                                                                                    <td colspan="1">Action</td>
                                                                                                                </tr>
                                                                                                            </table>
                                                                                                            <button id="btnUponEndEdit" style="margin-top: 20px;" class="btn btn-sm btn-success pull-right">Submit</button>
                                                                                                        </div>

                                                                                                        <div class="tab-pane" id="taber22">
                                                                                                            <table class="table-condensed" id="during_endorsementtbl_edit" width="100%" style="font-weight: bold;">
                                                                                                                <tr>
                                                                                                                    <td>Document/ Attachment</td>
                                                                                                                    <td colspan="1">Action</td>
                                                                                                                </tr>
                                                                                                            </table>
                                                                                                            <button id="btnUponEndDuring" style="margin-top: 20px;" class="btn btn-sm btn-success pull-right">Submit</button>
                                                                                                        </div>

                                                                                                        <div class="tab-pane" id="taber33">
                                                                                                            <table class="table-condensed" id="after_endorsementtbl_edit" width="100%" style="font-weight: bold;">
                                                                                                                <tr>
                                                                                                                    <td>Document/ Attachment</td>
                                                                                                                    <td colspan="1">Action</td>
                                                                                                                </tr>
                                                                                                            </table>
                                                                                                            <button id="btnUponEndAfter" style="margin-top: 20px;" class="btn btn-sm btn-success pull-right">Submit</button>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>

                                                                                        </div>
                                                                                    </div>

                                                                                    <div hidden>
                                                                                        {{--<center><label>Add Checkings</label></center>--}}
                                                                                        {{--<span id="addCheckings"></span>--}}
                                                                                        {{--<br>--}}
                                                                                        {{--<select class="form-control" name="bi_selection" id="bi_selection">--}}
                                                                                        {{--<option value="">--</option>--}}
                                                                                        {{--</select>--}}
                                                                                        {{--<label>Site Name</label>--}}
                                                                                        {{--<input type="text" id="bi_name_check" class="form-control">--}}
                                                                                        {{--<label>Location</label>--}}
                                                                                        {{--<input type="text" id="bi_loca_check" class="form-control">--}}
                                                                                        {{--<center><label style="padding-top:20px;">Checkings</label></center><br>--}}
                                                                                        {{--<div class="col-md-4"></div>--}}
                                                                                        {{--<div class="col-md-4"><button class="btn btn-block btn-success btn-sm form-control" id="dup_checks"><i class="glyphicon glyphicon-plus"></i></button></div>--}}
                                                                                        {{--<br><br>--}}
                                                                                        {{--<div id="testing" style="margin-bottom: 5px; margin-top:5px;">--}}

                                                                                        {{--</div>--}}
                                                                                        {{--</div>--}}
                                                                                        {{--<button class="btn btn-block btn-info" id="addCheckBtn" style="margin-top: 15px;">Submit</button>--}}
                                                                                    </div>

                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- /.modal-content -->
                                                    </div>
                                                    <!-- /.modal-dialog -->
                                                </div>

                                                <div class="modal fade" id="modal_select_bi_account">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span></button>
                                                                <h4 class="modal-title">Select B.I Accoount</h4>
                                                            </div>

                                                            <div class="modal-body">
                                                                <div class="box-body">
                                                                    <div class="row">
                                                                        <div class="col-md-12 form-group">
                                                                            <select class="form-control" id="selected_bi">
                                                                                @foreach($bi_clients as $bi_client)
                                                                                    <option value="{{ $bi_client->id }}">{{ $bi_client->bi_account_name.' '.$bi_client->account_location }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                            <button type="button" class="btn btn-primary pull-right" id="btn_submit_bi_select">Submit</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- /.modal-content -->
                                                    </div>
                                                    <!-- /.modal-dialog -->
                                                </div>

                                                <div class="box-body" id="userList">
                                                    <table id="usertableManage" class="tableendorse table-hover table-condensed" width="100%">
                                                        <thead>
                                                        <tr>
                                                            <th style="text-align: center">#</th>
                                                            <th style="text-align: center">Employee ID</th>
                                                            <th style="text-align: center">Picture</th>
                                                            <th style="text-align: center">Name</th>
                                                            <th style="text-align: center">Email</th>
                                                            <th style="text-align: center">Branch</th>
                                                            <th style="text-align: center">Position #</th>
                                                            <th style="text-align: center">Action</th>
                                                        </tr>
                                                        </thead>
                                                        <tfoot>
                                                        <tr>
                                                            <th style="text-align: center">#</th>
                                                            <th style="text-align: center">Employee ID</th>
                                                            <th style="text-align: center">Picture</th>
                                                            <th style="text-align: center">Name</th>
                                                            <th style="text-align: center">Email</th>
                                                            <th style="text-align: center">Branch</th>
                                                            <th style="text-align: center">Position #</th>
                                                            <th style="text-align: center">Action</th>
                                                        </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modalviewcontacts" id="modalviewcontacts">
                                        <div class="modal fade" id="modal-ci-view-contacts">
                                            <div class="modal-dialog modal-md">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span></button>
                                                        <h3 class="modal-title">Contact Number - CI</h3>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="box-body">
                                                            <span id="ci_name"></span>
                                                            <span id="spanforcontact"></span>


                                                            <div class="form-group">
                                                                <button type="button" id="addcontact" class="btn btn-primary pull-left" style="margin-top: 15px; margin-left: 15px">Add Number</button>
                                                            </div>
                                                        </div>

                                                        <div class="modal-footer">
                                                            <button type="button" id="updatecontact" class="btn btn-success pull-right" >Update</button>
                                                        </div>
                                                    </div>
                                                    <!-- /.modal-content -->
                                                </div>
                                                <!-- /.modal-dialog -->
                                            </div>
                                            <!-- /.modal -->
                                        </div>
                                    </div>

                                    <div class="modal fade" id="modal-tele-level">
                                        <div class="modal-dialog" style="width: 50%">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span></button>
                                                    <h3 class="modal-title">Edit Tele Level</h3>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="col-md-12">
                                                        <div class="panel panel-default">
                                                            <div class="panel-body">
                                                                <table class="table-condensed table-hover tableendorse display" width="100%" id="teleLevels">
                                                                    <thead>
                                                                    <tr>
                                                                        <th>USER ID</th>
                                                                        <th>TELE NAME</th>
                                                                        <th>STATUS</th>
                                                                        <th>ACTION</th>
                                                                    </tr>
                                                                    </thead>
                                                                </table>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn btn-default" data-dismiss="modal">Close</button>
                                                </div>
                                                <!-- /.modal-content -->
                                            </div>
                                            <!-- /.modal-dialog -->
                                        </div>
                                        <!-- /.modal -->
                                    </div>


                                    <!-- /.box-body -->
                                    <div class="box-footer">
                                        Footer
                                    </div>
                                    <!-- /.box-footer-->
                                </div>
                                <!-- /.box -->
                            </div>
                            <div class="tab-pane" id="tab_2">
                                <table id="table-archive-accounts" class="tableendorse table-hover table-condensed" width="100%">
                                    <thead>
                                    <tr>
                                        <th style="text-align: center">#</th>
                                        <th style="text-align: center">Employee ID</th>
                                        <th style="text-align: center">Picture</th>
                                        <th style="text-align: center">Name</th>
                                        <th style="text-align: center">Email</th>
                                        <th style="text-align: center">Branch</th>
                                        <th style="text-align: center">Action</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th style="text-align: center">#</th>
                                        <th style="text-align: center">Employee ID</th>
                                        <th style="text-align: center">Picture</th>
                                        <th style="text-align: center">Name</th>
                                        <th style="text-align: center">Email</th>
                                        <th style="text-align: center">Branch</th>
                                        <th style="text-align: center">Action</th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <div class="tab-pane" id="tab_3">
                                <table id="table-blocked-accounts" class="tableendorse table-hover table-condensed" width="100%">
                                    <thead>
                                    <tr>
                                        <th style="text-align: center">ID</th>
                                        <th style="text-align: center">Employee ID</th>
                                        <th style="text-align: center">Number of Attempt</th>
                                        <th style="text-align: center">Boolean Lock</th>
                                        <th style="text-align: center">Date/Time Occurred</th>
                                        <th style="text-align: center">Action</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th style="text-align: center">ID</th>
                                        <th style="text-align: center">Employee ID</th>
                                        <th style="text-align: center">Number of Attempt</th>
                                        <th style="text-align: center">Boolean Lock</th>
                                        <th style="text-align: center">Date/Time Occurred</th>
                                        <th style="text-align: center">Action</th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    {{ csrf_field() }}

@endsection

@push('jscript')

    <script src="https://cdn.datatables.net/buttons/1.5.0/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.0/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>

    <script src="https://cdn.datatables.net/buttons/1.5.0/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.0/js/buttons.print.min.js"></script>
    <script src="{{ asset('jscript/admin.js') }}"></script>

@endpush
