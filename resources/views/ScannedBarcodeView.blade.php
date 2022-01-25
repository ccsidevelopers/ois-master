<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="csrf-token" content="{{ csrf_token() }}" id="_token">
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>

    <title>Comprehensive Credit Services Inc.</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link href="{{ asset('fine-uploader/fine-uploader-new.css') }}" rel="stylesheet" type="text/css">

    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ asset('bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('bower_components/font-awesome/css/font-awesome.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ asset('bower_components/Ionicons/css/ionicons.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/AdminLTE.min.css') }}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset('plugins/iCheck/square/blue.css') }}">

<!-- HTML5 Shim and Respond.js IE8 sup{{ asset('') }}port of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    {{--header icon--}}
    <link rel="icon" href="dist/img/ccsi-icon.ico">
    <script type="text/template" id="qq-template-manual-trigger">
        <div class="qq-uploader-selector qq-uploader" qq-drop-area-text="Drop files here">
            <div class="qq-total-progress-bar-container-selector qq-total-progress-bar-container">
                <div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" class="qq-total-progress-bar-selector qq-progress-bar qq-total-progress-bar"></div>
            </div>
            <div class="qq-upload-drop-area-selector qq-upload-drop-area" qq-hide-dropzone>
                <span class="qq-upload-drop-area-text-selector"></span>
            </div>
            <div class="buttons">
                <div class="qq-upload-button-selector qq-upload-button">
                    <center>Select Photo/s</center>
                </div>
            </div>

            <button type="button" id="trigger-upload" class="btn btn-xs btn-primary" style="display: none;">
                {{--<button type="button" id="trigger-upload" class="btn btn-xs btn-primary">--}}
                <i class="icon-upload icon-white"></i> Upload
            </button>

            <span class="qq-drop-processing-selector qq-drop-processing">
                <span>Processing dropped files...</span>
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
                    <span class="qq-edit-filename-icon-selector qq-edit-filename-icon" aria-label="Edit filename"></span>
                    <input class="qq-edit-filename-selector qq-edit-filename" tabindex="0" type="text">
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

</head>
<body>
<div class="box">
    <div class="col-md-12">

        @if(isset($existing))
        <div class="box-title info_viw">
            <h3>Equipment Information</h3>
        </div>
        <div class="box-body info_viw">
        @if($existing[0]->type == 'Employee Equipment')
            <label for="">Item Category: </label> <small>{{$existing[0]->type}}</small><br>
            <label for="">Employee ID: </label> <small>{{$existing[0]->employee_id}}</small><br>
            <label for="">Brand: </label> <small>{{$existing[0]->item_brand}}</small><br>
            <label for="">Branch: </label> <small>{{$existing[0]->emp_branch}}</small><br>
            <label for="">Equipment Price: </label> <small>{{$existing[0]->item_price}}</small><br>
            <label for="">Equipment Description: </label> <small>{{$existing[0]->item_description}}</small><br>
            <label for="">Current Status : </label> <small>{{$existing[0]->current_status}}</small><br>
            <label for="">Remarks : </label> <small>{{$existing[0]->remarks}}</small><br>
            <label for="">Last taken Image : </label> <small></small><br>
            <input type="hidden" value="{{$existing[0]->id}}" id="id_holder">
            <div id="latest_pic" style="text-align: center;" value="{{$existing[0]->id}}">
            </div>

        @else
            <label for="">Item Category: </label> <small>{{$existing[0]->type}}</small><br>
            <label for="">Brand: </label> <small>{{$existing[0]->item_brand}}</small><br>
            <label for="">Branch: </label> <small>{{$existing[0]->branch}}</small><br>
            <label for="">Equipment Price: </label> <small>{{$existing[0]->item_price}}</small><br>
            <label for="">Equipment Description: </label> <small>{{$existing[0]->item_description}}</small><br>
            <label for="">Current Status : </label> <small>{{$existing[0]->current_status}}</small><br>
            <label for="">Remarks : </label> <small>{{$existing[0]->remarks}}</small><br>
            <label for="">Last taken Image : </label> <small></small><br>
            <input type="hidden" value="{{$existing[0]->id}}" id="id_holder">
            <div id="latest_pic" style="text-align: center;" value="{{$existing[0]->id}}">
            </div><br>
        @endif
            <button class="btn btn-primary btn-md btn-block" id="update_inventory">Update <i class="glyphicon glyphicon-pencil"></i></button>
            @if($existing[0]->type == 'Employee Equipment')
            <button class="btn btn-info btn-md btn-block view_history" value="{{base64_encode($existing[0]->id)}}" data-toggle="modal" data-target="#modal-history">View Recent Users <i class="glyphicon glyphicon-film"></i></button>
            @endif
        </div>
        <div class="box-title full_view_info" hidden>
            <h3>Equipment Information</h3>
        </div>
        <div class="box-body full_view_info" hidden>
                <div class="form-group">
                    <label for="">Barcode:</label>
                    <input type="text" value="{{ $barcode }}" name="{{base64_encode(gzdeflate($barcode))}}" class="form-control" disabled readonly id="barcode">
                </div>
                <div class="box box-primary">
                    <div class="box-title">
                        <h4>Item Type :</h4>
                    </div>
                    <div class="box-body">
                        <label for="select-type">Select Category :</label>
                        <input type="text" class="form-control" disabled value="{{$existing[0]->type}}" id="cat">
                    </div>
                    <div class="box-header with-border"></div>

                    <!-- FOR EMPLOYEE INVENTORY -->

                    @if($existing[0]->type == 'Employee Equipment')
                    <div class="box-body" id="employee_contents">
                        <div class="box-title">
                            <h4 style="font-weight: bold">Employee Equipment Details</h4>
                        </div>
                        <div class="form-group">
                            <label for="item-emp-id">Employee ID <small style="color: red;">(Require field)<br> (Example Input: 20XX-XXXX)</small></label>
                            <div class="input-group">
                                <input type="text" class="form-control req_field" id="item-emp-id" value="{{$existing[0]->employee_id}}" disabled>
                                <span class="input-group-btn">
                                <button class="btn btn-primary" type="button" id="button-edit-emp-id">Edit</button>
                            </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="item-emp-branch">Employee Position <small style="color: red;">(Required field)</small></label>
                            <select name="" id="item-emp-position" class="form-control empInput select2" disabled>
                                <option value="{{$existing[0]->position_id}}">{{$existing[0]->position}}</option>
                                <option value="">--- SELECT POSITION ---</option>
                                @foreach($positions as $position)
                                    @if($position->id != $existing[0]->position_id)
                                    <option value="{{ $position->id}}">{{ $position->position_name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="item-emp-branch">Employee Branch</label>
                            <input type="text" id="item-branch" class="form-control" value="{{$existing[0]->emp_branch}}" name="{{$existing[0]->emp_branch_id}}" disabled>
                        </div>
                        <div class="form-group">
                            <label for="select-item-type-emp">Select Item Name/Type :</label>
                            <input type="text" class="form-control" value="{{$existing[0]->item_details_type}}" disabled>
                        </div>
                        <div class="form-group">
                            <label for="item-emp-brand">Brand</label>
                            <input type="text" class="form-control" value="{{$existing[0]->item_brand}}" disabled>
                        </div>
                        <div class="form-group">
                            <label for="item-emp-branch">Status : <small style="color: red;">(Required field)</small></label>
                            <select name="" id="update-item-status" class="form-control req_field">
                                <option value="">----SELECT STATUS----</option>
                                <option value="Issued">Issued</option>
                                <option value="Vacant">Vacant</option>
                                <option value="Return">Return</option>
                            </select>
                        </div>
                        <div class="form-group" id="status_condition">
                            <label for="">Condition : <small style="color: red;">(Required field)</small></label>
                            <select id="update-item-condition" class="form-control req_field" placeholder="Remarks here">
                                <option value="">---ITEM CONDITON---</option>
                                <option value="Good Condition">Good Condition</option>
                                <option value="With Defect">With Defect</option>
                                <option value="Defective">Defective</option>
                                <option value="Missing">Missing</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Remarks : <small style="color: red;">(Required field)</small></label>
                            <textarea id="update-item-remarks" class="form-control req_field" placeholder="Remarks here" rows="5" style="resize: none;"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="">Attach Picture/s : <small style="color: red;">(Required field)</small></label>
                            <div id="fine-uploader-manual-trigger"></div>
                        </div>
                    </div>
                    <div class="box-header with-border"></div>
                    <div class="button-to-submit">
                        <button class="btn btn-primary btn-md btn-block" id="update_item" value="{{base64_encode($existing[0]->id)}}">Update <i class="glyphicon glyphicon-pencil"></i></button>
                        <button class="btn btn-info btn-md btn-block view_history" value="{{base64_encode($existing[0]->id)}}" data-toggle="modal" data-target="#modal-history">View Item History <i class="glyphicon glyphicon-film"></i></button>
                        <button class="btn btn-danger btn-md btn-block" id="btn_back" onclick="window.location.reload()">Back <i class="glyphicon glyphicon-arrow-left"></i></button>
                    </div>



                    <!-- FOR OFFICE INVENTORY -->

                    @else
                    <div class="box-body" id="office_contents">
                        <div class="box-title">
                            <h4 style="font-weight: bold">Office Equipment Details</h4>
                        </div>
                        <div class="form-group">
                            <label for="item-emp-branch">Branch</label>
                            <input type="text" id="item-branch" class="form-control" value="{{$existing[0]->branch}}" name="{{$existing[0]->branch_id}}" disabled>
                        </div>
                        <div class="form-group">
                            <label for="select-item-off-type">Select Item Name/Type :</label>
                            <input type="text" class="form-control" value="{{$existing[0]->item_details_type}}" disabled>
                        </div>
                        <div class="form-group">
                            <label for="item-emp-brand">Brand</label>
                            <input type="text" class="form-control" value="{{$existing[0]->item_brand}}" disabled>
                        </div>
                        <div class="form-group" id="status_condition">
                            <label for="">Condition : <small style="color: red;">(Required field)</small></label>
                            <select id="update-item-condition" class="form-control req_field" placeholder="Remarks here">
                                <option value="">---ITEM CONDITON---</option>
                                <option value="Good Condition">Good Condition</option>
                                <option value="With Defect">With Defect</option>
                                <option value="Defective">Defective</option>
                                <option value="Missing">Missing</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Remarks : <small style="color: red;">(Required field)</small></label>
                            <textarea id="update-item-remarks" class="form-control req_field" placeholder="Remarks here" rows="5" style="resize: none;"></textarea>
                        </div>
                        <div class="form-group">
                            <div id="fine-uploader-manual-trigger"></div>
                        </div>
                        {{--<div class="form-group">--}}
                            {{--<label for="item-emp-price">Equipment Price</label>--}}
                            {{--<input type="text" class="form-control" value="{{$existing[0]->item_price}}" disabled>--}}
                        {{--</div>--}}
                        {{--<div class="form-group">--}}
                            {{--<label for="item-emp-desc">Description</label>--}}
                            {{--<textarea rows="5" class="form-control empInput" style="resize: none" placeholder="Equipment Description" disabled>{{$existing[0]->item_description}}</textarea>--}}
                        {{--</div>--}}
                    </div>
                    <div class="box-header with-border"></div>
                    <div class="button-to-submit">
                        <button class="btn btn-primary btn-md btn-block" id="update_item" value="{{base64_encode($existing[0]->id)}}">Update <i class="glyphicon glyphicon-pencil"></i></button>
                        <button class="btn btn-danger btn-md btn-block" id="btn_back" onclick="window.location.reload()">Back <i class="glyphicon glyphicon-arrow-left"></i></button>
                        {{--<button class="btn btn-info btn-md btn-block view_history" value="{{$existing[0]->id}}" data-toggle="modal" data-target="#modal-history">View Item History <i class="glyphicon glyphicon-film"></i></button>--}}
                    </div>
                    @endif

                    {{--<div class="box-body button-to-submit" >--}}
                        {{--<div class="form-group">--}}
                            {{--<div id="fine-uploader-manual-trigger"></div>--}}
                        {{--</div>--}}
                    {{--</div>--}}

                </div>
            </div>
        @else

        <div class="box-title">
            <h3>Encode Data</h3>
        </div>
        <div class="box-body">
                <div class="form-group">
                    <label for="">Barcode:</label>
                    <input type="text" value="{{ $barcode }}" name="{{base64_encode(gzdeflate($barcode))}}" class="form-control" disabled readonly id="barcode">
                </div>
                <div class="box box-primary">
                    <div class="box-title">
                        <h4>Item Type :</h4>
                    </div>
                    <div class="box-body">
                        <label for="select-type">Select Category :</label>
                        <select name="" id="select-type" class="form-control">
                            <option value="">-</option>
                            <option value="emp">Employee Equipment</option>
                            <option value="branch">Branch Asset</option>
                        </select>
                    </div>
                    <div class="box-header with-border"></div>

                    <!-- FOR EMPLOYEE INVENTORY -->

                    <div class="box-body" id="employee_contents" hidden>
                        <div class="box-title">
                            <h4 style="font-weight: bold">Employee Equipment Details</h4>
                        </div>
                        <div class="form-group">
                            <label for="item-emp-id">Employee ID <small style="color: red;">(Require field)<br> NOTE: Format should be 20XX-XXXX</small></label>
                            <input type="text" id="item-emp-id" class="form-control empInput" placeholder="Input Employee ID">
                        </div>
                        <div class="form-group">
                            <label for="item-emp-branch">Employee Position <small style="color: red;">(Required field)</small></label>
                            <select name="" id="item-emp-position" class="form-control empInput">
                                <option value=""><--- SELECT POSITION ---></option>
                                @foreach($positions as $position)
                                    <option value="{{ $position->id}}">{{ $position->position_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="item-emp-branch">Employee Branch <small style="color: red;">(Required field)</small></label>
                            <select name="" id="item-emp-branch" class="form-control empInput">
                                <option value=""><--- SELECT BRANCH ---></option>
                                @foreach($branches as $branch)
                                    <option value="{{ $branch->id}}">{{ $branch->archipelago_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group" hidden>
                            <label for="item-emp-loc">Employee Location :</label>
                            <select name="" id="item-emp-loc" class="form-control">
                                <option value=""><--- SELECT PROVINCE ---></option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="select-item-type-emp">Select Item Name/Type: <small style="color: red;">(Require field)</small></label>
                            <select name="" id="select-item-type-emp" class="form-control empInput">
                                <option value=""><--- SELECT ITEM TYPE ---></option>
                                @foreach($item_selection as $items)
                                    <option value="{{ $items->item_type}}" name="{{ $items->type }}">{{ $items->item_type }}</option>
                                @endforeach
                                <option value="Others" name="Others">Others</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="item-emp-brand">Brand <small style="color: red;">(Required field)</small></label>
                            <input type="text" class="form-control empInput" placeholder="Equipment Brand" id="item-emp-brand">
                        </div>
                        <div class="form-group">
                            <label for="item-emp-price">Equipment Price <small style="color: red;">(Required field)</small></label>
                            <input type="text" class="form-control empInput" id="item-emp-price">
                        </div>
                        <div class="form-group">
                            <label for="item-emp-desc">Description <small style="color: red;">(Required field)</small></label>
                            <textarea id="item-emp-desc" rows="5" class="form-control empInput" style="resize: none" placeholder="Equipment Description"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="item-desc">Invoice Number <small style="color: red;">(Required field)</small></label>
                            <input type="text" id="item-emp-invoice" class="form-control empInput" placeholder="Invoice Number">
                        </div>
                        <div class="form-group">
                            <label for="item-emp-war">Warranty <small style="color: red;">(Required field)</small></label>
                            <textarea id="item-emp-war" rows="5" class="form-control empInput" style="resize: none" placeholder="Equipment Warranty"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="emp-branch">Status : <small style="color: red;">(Required field)</small></label>
                            <select name="" id="emp-item-status" class="form-control empInput req_field">
                                <option value="">----SELECT STATUS----</option>
                                <option value="Issued">Issued</option>
                                <option value="Vacant">Vacant</option>
                                <option value="Return">Return</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Condition : <small style="color: red;">(Required field)</small></label>
                            <select id="emp-item-condition" class="form-control req_field" placeholder="Remarks here">
                                <option value="">---ITEM CONDITON---</option>
                                <option value="Good Condition">Good Condition</option>
                                <option value="With Defect">With Defect</option>
                                <option value="Defective">Defective</option>
                                <option value="Missing">Missing</option>
                            </select>
                        </div>
                    </div>

                    <!-- FOR OFFICE INVENTORY -->

                    <div class="box-body" id="office_contents" hidden>
                        <div class="box-title">
                            <h4 style="font-weight: bold">Office Equipment Details</h4>
                        </div>
                        <div class="form-group">
                            <label for="item-branch">Branch <small style="color: red;">(Required field)</small></label>
                            <select name="" id="item-branch" class="form-control branchInput">
                                <option value=""><---- SELECT BRANCH ----></option>
                                @foreach($branches as $branchi)
                                    <option value="{{ $branchi->id}}">{{ $branchi->archipelago_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="select-item-off-type">Select Item Name/Type :</label>
                            <select name="" id="select-item-off-type" class="form-control branchInput">
                                <option value="">-</option>
                                @foreach($item_selection as $items)
                                    <option value="{{ $items->item_type}}" name="{{ $items->type }}">{{ $items->item_type }}</option>
                                @endforeach
                                <option value="Others" name="Others">Others</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="item-brand">Brand <small style="color: red;">(Required field)</small></label>
                            <input type="text" id="item-brand" class="form-control branchInput" placeholder="Equipment Brand">
                        </div>
                        <div class="form-group">
                            <label for="item-price">Equipment/Item Price <small style="color: red;">(Required field)</small></label>
                            <input type="text" class="form-control branchInput" id="item-price" placeholder="PHP">
                        </div>
                        <div class="form-group">
                            <label for="item-desc">Description <small style="color: red;">(Required field)</small></label>
                            <textarea id="item-desc" rows="5" class="form-control branchInput" style="resize: none" placeholder="Equipment Description"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="item-desc">Invoice Number <small style="color: red;">(Required field)</small></label>
                            <input type="text" id="item-invoice" class="form-control branchInput" placeholder="Invoice Number">
                        </div>
                        <div class="form-group">
                            <label for="item-war">Warranty <small style="color: red;">(Required field)</small></label>
                            <textarea id="item-war" rows="5" class="form-control branchInput" style="resize: none" placeholder="Equipment Warranty"></textarea>
                        </div>
                        <div class="form-group" id="status_condition">
                            <label for="">Condition : <small style="color: red;">(Required field)</small></label>
                            <select id="update-item-condition" class="form-control branchInput req_field" placeholder="Remarks here">
                                <option value="">---ITEM CONDITON---</option>
                                <option value="Good Condition">Good Condition</option>
                                <option value="With Defect">With Defect</option>
                                <option value="Defective">Defective</option>
                                <option value="Missing">Missing</option>
                            </select>
                        </div>
                    </div>

                    <div class="box-header with-border"></div>
                    <div class="box-body button-to-submit" hidden>
                        <div class="form-group">
                            <label for="">Attach Picture/s : <small style="color: red;">(Required field)</small></label>
                            <div id="fine-uploader-manual-trigger"></div>
                        </div>
                    </div>

                    <div class="button-to-submit" hidden>
                        <button class="btn btn-success btn-md btn-block" id="submit_item">Submit <i class="glyphicon glyphicon-ok"></i></button>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>



<div class="modal fade" id="modal-submit-to-login">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="box">
                            <div class="box-body">
                                <div class="login-box-body">
                                    <center><p class="login-box-msg">Login your account to complete the encoding process</p></center>
                                    <div class="form-group has-feedback">
                                        <input type="email" class="form-control validate" placeholder="Email" id="encode_email" name="email" required>
                                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                                    </div>
                                    <div class="form-group has-feedback">
                                        <input type="password" class="form-control validate" placeholder="Password" name="password" id="encode_pass" required>
                                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-xs-12">
                                            @if(isset($existing))
                                            <button type="submit" class="btn btn-primary btn-block btn-flat" id="update_item_encode">Sign In</button>
                                            @else
                                            <button type="submit" class="btn btn-primary btn-block btn-flat" name="encode_item" id="complete_encode">Sign In</button>
                                            @endif
                                            <button class="btn btn-default btn-md btn-block" data-dismiss="modal">Close</button>
                                            <center><small style="color: red; font-weight: bold" hidden id="error">Error logging in please check email and password and try again</small></center>
                                            <center><small style="color: red; font-weight: bold" hidden id="Autherror">Account role is not match please use an admin staff account</small></center>
                                        </div>
                                        <!-- /.col -->
                                        {{--<input type="hidden" name="_token" value="{{ Session::token() }}">--}}
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

    <div class="modal modal-warning fade" id="wait-loading">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    {{--<button type="button" class="close" data-dismiss="modal" aria-label="Close">--}}
                    {{--<span aria-hidden="true">&times;</span></button>--}}
                    <center>. . .Loading Please Wait. . .</center>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <center><img src="dist/img/loading.gif" alt="" width="15%"></center>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.modal-content -->
            <div class="modal-footer">
                {{--<button class="btn btn-default">Close</button>--}}
            </div>
        </div>
        <!-- /.modal-dialog -->
    </div>

    <div class="modal modal-success fade" id="wait-success">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                    <center>. . .Sucess. . .</center>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                {{--<center><img src="dist/img/loading.gif" alt="" width="15%"></center>--}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.modal-content -->
            <div class="modal-footer">
                {{--<button class="btn btn-default">Close</button>--}}
            </div>
        </div>
        <!-- /.modal-dialog -->
    </div>

    <div class="modal fade" id="modal-history">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                    <center>
                        <h4>USER HISTORY</h4>
                    </center>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box box-danger">
                                <div class="box-body">
                                    <div class="row" id="user_history_table_span">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.modal-content -->
            <div class="modal-footer">
                {{--<button class="btn btn-default">Close</button>--}}
            </div>
        </div>
        <!-- /.modal-dialog -->
    </div>

<div class="modal fade" id="modal-view-pic">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <center>
                        <img src="" alt="" id="view-pic-click" width="300px" height="300px">
                    </center>
                </div>
            </div>
            <!-- /.modal-content -->
            <div class="modal-footer">
                {{--<button class="btn btn-default">Close</button>--}}
            </div>
        </div>
        <!-- /.modal-dialog -->
    </div>


<script src="{{ asset('bower_components/jquery/dist/jquery.min.js') }}"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<script src="https://code.jquery.com/jquery-1.9.1.js"></script>
<script src="https://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<script src="{!!asset('fine-uploader/jquery.fine-uploader.js') !!}"></script>
<script src="{!!asset('fine-uploader/fine-uploader.js') !!}"></script>
<script src="{{ asset('jscript/admin-barcode-scan.js') }}"></script>

<script src="{{ asset('bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('plugins/iCheck/icheck.min.js') }}"></script>

</body>
</html>
