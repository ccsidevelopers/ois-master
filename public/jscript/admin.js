/**
 * Created by aa on 11/2/2017.
 */
var table;
var toastr;
var tableAccount;
var acctID;
var id = 0;
var spanning = '';
var ctr = 0;
var ii = 0;
var i = 0;
var getnumbers = [];
var contact_id = [];
var ci_name = '';
var ci_email = '';
var ci_branch = '';
var tableuser;
var storeuser = [];
var user_client_level = '';
var name_user_client = '';
var branch_user_client = '';
var grant_user_client = '';
var management_type = '';
var orignal_name_client = '';
var keke = 0;
var tableArchiveUsers;
var tableBlockedUsers;
var user_id_click_for_bi = '';
var bi_what_to = 'add';
var global_bi_id = '';
var ip_address_login_table_data = '';
var user_access_login_table_data = '';
var ip_already = false;
var user_access = false;
var check_if_sitel = '';

var ci_number_table = '';
var ci_table_get_head = [];
// var ci_get_head_ctr = 0;
var user_client_list_bool = false;
var adminEmailReceiver = '';
var adminEmailReceiverBool = false;
var tableAccountBI;

$.ajaxSetup
({
    headers:
        {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
});


function myFunction(event) {

    if ($('#' + event + '').is('[readonly]')) {
        $('#' + event + '').removeAttr('readonly');
    }
    else {
        $('#' + event + '').attr('readonly', true);
    }
}

$(document).ready(function ()
{
    $('#tableManageAccount tfoot th').each(function () {
        var title = $(this).text();
        $(this).html(title+'<br><input type="text" placeholder="Search" style="position: relative; width: 100%">');
    });

    tableAccount = $('#tableManageAccount').DataTable
    ({
        "responsive": false,
        "processing": true,
        "serverSide": true,
        "ajax": "/admin-account-table-list",
        "columns":
            [
                {data: 'id', name: 'id'},
                {data: 'date_endorsed', name: 'date_endorsed'},
                {data: 'time_endorsed', name: 'time_endorsed'},
                {data: 'account_name', name: 'account_name'},
                {data: 'address', name: 'address'},
                {data: 'requestor_name', name: 'requestor_name'},
                {data: 'type_of_request', name: 'type_of_request'},
                {data: 'provinces', name: 'provinces'},
                {data: 'client_name', name: 'client_name'},
                {
                    data: function (data) {
                        if (data.acct_status > 0 || data.handled_by_account_officer !== '') {
                            return '<button class="btn-xs btn-danger" value="' + data.id + '" id="btnDetach" name="btnDetach" style="width: 100%"><i class="fa fa-remove"></i> Reset</button>';
                        }
                        else {
                            return '<button class="btn-xs btn-info btn-block" disabled><i class="fa  fa-file-o"></i> Empty</button>';
                        }

                        // if()

                    },
                    "orderable": false,
                    "searchable": false,
                    "name": 'action',
                    "width": "7%"
                }
            ],
        'order': [[0, 'desc']],
        "pageLength": 10,
        "bSortClasses": false,
        "deferRender": true,
        initComplete: function () {
            var api = this.api();
            // Apply the search
            api.columns().every(function () {
                var that = this;
                $('input', this.footer()).on('keyup change', function () {
                    if (that.search() !== this.value) {
                        that
                            .search(this.value)
                            .draw();
                    }
                });
            });
        }
    });
})


$(document).ready(function ()
{
    $('#tableManageAllBIaccounts tfoot th').each(function () {
        var title = $(this).text();
        $(this).html(title+'<br><input type="text" placeholder="Search" style="position: relative; width: 100%">');
    });

    tableAccountBI = $('#tableManageAllBIaccounts').DataTable
    ({
        "responsive": false,
        "processing": true,
        "serverSide": true,
        "ajax": "/admin-bi-account-list",
        "columns":
            [
                {data: 'endorse_id', name: 'bi_endorsements.id'}, //0
                {data: 'date_time_endorsed', name: 'bi_endorsements.created_at'}, //3
                {data: 'project', name: 'bi_endorsements.project'}, //4
                {data: 'account_name', name: 'bi_endorsements.account_name'}, //5
                {data: 'due', name: 'bi_endorsements.date_time_due'}, //3
                {
                    data : function action(data)
                    {
                        var statHide = '';

                        if(data.status == 1999)
                        {
                            statHide =  '<button class="btn btn-block btn-md btn-warning" >Already hidden</button>'
                        }
                        else
                        {
                            statHide = '<button class="btn btn-block btn-md btn-primary btnEditStat"  id="'+data.endorse_id+'">Hide</button>'
                        }

                        return statHide + '<button class="btn btn-block btn-info btnEditTimeDue" id="'+data.endorse_id+'">Edit Date/Time Due</button>';
                    },
                    name : 'bi_endorsements.id',
                    'orderable' : false,
                    'searchable' : false
                } //13
            ],
        'order': [[0, 'desc']],
        "pageLength": 10,
        "bSortClasses": false,
        "deferRender": true,
        initComplete: function () {
            var api = this.api();
            // Apply the search
            api.columns().every(function () {
                var that = this;
                $('input', this.footer()).on('keyup change', function () {
                    if (that.search() !== this.value) {
                        that
                            .search(this.value)
                            .draw();
                    }
                });
            });
        }
    });

    $('#tableManageAllBIaccounts').on('click', '.btnEditStat', function()
    {
        var id = $(this).attr('id');

        if(confirm('Are you sure to hide this account?'))
        {
            $.ajax
            ({
                type : 'get',
                url : 'admin_bi_hide_acct',
                data :
                    {
                        'id' : id
                    },
                beforeSend : function()
                {
                  $(this).attr('disabled', true);
                },
                success : function()
                {
                    alert('Successfully Updated.');
                    tableAccountBI.ajax.reload(null, false);
                    $(this).attr('disabled', false);
                }

            })
        }

    });

    $('#tableManageAllBIaccounts').on('click', '.btnEditTimeDue', function()
    {
        var id = $(this).attr('id');
        $('.btnSubmitEndorse').attr('name', id);
        $('#modal-loading-direct-endorse').modal('show');
    });

    $('.btnClearFieldsTimeDue').click(function()
    {
       if(confirm('Are you sure to clear fields?'))
       {
           $('#time_to_edit_due').val('');
           $('#date_to_edit_due').val('');
       }
       else
       {

       }
    });

    $('.btnSubmitEndorse').click(function()
    {
        var time = $('#time_to_edit_due').val();
        var date = $('#date_to_edit_due').val();
        var id_to = $(this).attr('name');

        if(confirm('Are you sure to update?'))
        {
            if(time != '' && date != '')
            {
                $.ajax
                ({
                    type : 'get',
                    url : 'admin_edit_bi_time_due',
                    data :
                        {
                            'time' : time,
                            'date' : date,
                            'id' : id_to
                        },
                    beforeSend : function()
                    {
                        $(this).attr('disabled', true);
                    },
                    success : function()
                    {
                        alert('Successfully Updated');
                        $(this).attr('disabled', false);
                        $('#modal-loading-direct-endorse').modal('hide');
                        $('.btnSubmitEndorse').attr('name', '');
                        tableAccountBI.ajax.reload(null, false);

                    }
                })
            }
            else
            {
                alert('Please insert both valid date and time');
            }
        }
        else
        {

        }
    });



});




$(document).ready(function ()
{

    $(window).focus(function ()
    {
        console.log('focus');
        interval = true;
    });

    $('#usertableManage tfoot th').each(function () {
        var title = $(this).text();
        $(this).html(title+'<br><input type="text" placeholder="Search" style="position: relative; width: 100%">');
    });

    $('#table-archive-accounts tfoot th').each(function () {
        var title = $(this).text();
        $(this).html(title+'<br><input type="text" placeholder="Search" style="position: relative; width: 100%">');
    });

    tableuser = $('#usertableManage').DataTable
    ({
        "responsive": true,
        "processing": true,
        "serverSide": true,
        "ajax": "/admin-get-user-manager",
        "columns":
            [
                {data: 'id_of_users', name: 'users.id'},
                {data: 'id_emp', name: 'users.Emp_ID'},
                {
                    data: function actions(data) {

                        return '';

                        // return '<center><img src="' +window.location.origin+'/'+data.picture_path + '" style="width: 15%"></center>';

                    },
                    'name': 'users.pix_path'
                },
                {data: 'users_name', name: 'users.name'},
                {data: 'users_email', name: 'users.email'},
                {
                    data: function actions(data) {

                        return data.pro_id + ' - ' + data.pro_branch;
                    },
                    "name": 'provinces.name'
                },
                {
                    data: function actions(data) {

                        if (data.rol_id == 4) {

                            var add = '';

                            if(data.perm != 'Yes')
                            {
                                add = '<button class="btn btn-success btn-block btn-xs PermissionUpdateTime" id="'+data.id_of_users+'" name = "add">Remove Required Date/Time</button>' +
                                    '<p style="margin-top: 10px;">Date/Time Visit : </p>';
                            }
                            else if(data.perm == 'Yes')
                            {
                                add = '<button class="btn btn-danger btn-block btn-xs PermissionUpdateTime" id="'+data.id_of_users+'" name = "remove">Required Date/Time</button>' +
                                    '<p style="margin-top: 10px;">Date/Time Visit : YES</p>';
                            }


                            return data.rol_id + ' - ' + data.role_name + '<br>' +
                                '<button id="btn_viewContacts" type="button" data-toggle="modal" data-target="#modal-ci-view-contacts" class="btn btn-block btn-primary btn-xs">View Contacts</button>' +
                                add;

                        }
                        else {
                            return data.rol_id + ' - ' + data.role_name;
                        }

                    },
                    'name': 'roles.name'
                },
                {

                    data: function actions(data) {

                        var buttons = '';

                        if (data.archive === "False")
                        {
                            if (data.cert === 'NC')
                            {
                                buttons += '<button type="button" class="btn btn-success btn-block btn-sm ourItem" data-toggle="modal" data-target="#showModal">Edit</button>' +
                                    '<button type="button" id="enablearch" class="btn btn-block btn-warning btn-sm">Archive Mode</button>' +
                                    '<button type="button" id="btnCert" name="' + data.id_of_users + '" class="btn btn-info btn-block btn-sm">Certify</button>'
                            }
                            else
                            {
                                buttons += '<button type="button" class="btn btn-success btn-block btn-sm ourItem" data-toggle="modal" data-target="#showModal">Edit</button>' +
                                    '<button type="button" id="enablearch" class="btn btn-block btn-warning btn-sm">Archive Mode</button>' +
                                    '<button type="button" id="btnDCert" name="' + data.id_of_users + '" class="btn btn-danger btn-block btn-sm">Disable Certified</button>'
                            }
                        }
                        else
                        {
                            buttons += '<center> <button type="button" id="disablearch" class="btn btn-danger btn-sm" data-toggle="modal">Disable Archive Mode</button>'
                        }

                        if(data.client_type == 'BI')
                        {
                            if(data.client_check === 'tat_selector')
                            {
                                buttons += '<button type="button" class="btn btn-warning btn-block btn-sm" data-toggle="modal" name="'+data.id_of_users+'" id="btn_client_perm" data-target="#modal_select_bi_account">BI Client Permission</button>' +
                                    '<button type="button" class="btn btn-danger btn-block btn-sm remove_tat_selector" id="'+data.id_of_users+'">Remove Tat Selector</button>';
                            }
                            else
                            {
                                buttons += '<button type="button" class="btn btn-warning btn-block btn-sm" data-toggle="modal" name="'+data.id_of_users+'" id="btn_client_perm" data-target="#modal_select_bi_account">BI Client Permission</button>' +
                                    '<button type="button" class="btn btn-primary btn-block btn-sm add_tat_selector" id="'+data.id_of_users+'">Add Tat Selector</button>';
                            }

                        }

                        return buttons + '<button class="btn btn-primary btn-block btn-sm edit_accesDB" data-toggle="modal" data-target="#modal-access-control" id="'+data.id_of_users+'">Edit Access</button>';

                    },
                    "name": 'users.archive'
                }
            ],
        'order': [[0, 'asc']],
        "pageLength": 10,
        "bSortClasses": false,
        "deferRender": true,
        "lengthMenu": [[2, 25, 50, -1], ['2 rows', '25 rows', '50 rows', 'Show all']],
        dom: 'Blfrtip',
        buttons:
            [
                {
                    extend: 'excelHtml5',
                    exportOptions:
                        {
                            columns: ':visible'
                        }
                },
                {
                    extend: 'print',
                    exportOptions:
                        {
                            columns: ':visible'
                        },
                    title: 'Billing - Comprehensive Credit Services, Inc.'
                },
                {
                    extend: 'copy',
                    exportOptions:
                        {
                            columns: ':visible'
                        }
                },
                {
                    extend: 'colvis',
                    text: 'Show/Hide Column'
                }

            ],
        initComplete: function()
        {
            var api = this.api();

            // Apply the search
            api.columns().every(function() {
                var that = this;

                $('input', this.header()).on('keyup change', function(e)
                {
                    if($(this).is(':focus'))
                    {
                        if(e.keyCode === 13)
                        {
                            if (that.search() !== this.value) {
                                that
                                    .search(this.value)
                                    .draw();
                            }
                        }
                        else if (e.keyCode === 8)
                        {
                            if (this.value == '') {
                                that
                                    .search(this.value)
                                    .draw();
                            }
                        }
                    }
                });
            });
        }

    });

    tableArchiveUsers = $('#table-archive-accounts').DataTable
    ({
        "responsive": true,
        "processing": true,
        "serverSide": true,
        "ajax": "/admin-table-archive-accounts",
        "columns":
            [
                {data: 'id_of_users', name: 'users.id'},
                {data: 'id_emp', name: 'users.Emp_ID'},
                {
                    data: function actions(data) {

                        return '';

                        // return '<center><img src="' +window.location.origin+'/'+data.picture_path + '" style="width: 15%"></center>';

                    },
                    'name': 'users.pix_path'
                },
                {data: 'users_name', name: 'users.name'},
                {data: 'users_email', name: 'users.email'},
                {
                    data: function actions(data) {

                        return data.pro_id + ' - ' + data.pro_branch;
                    },
                    "name": 'provinces.name'
                },
                {

                    data: function actions(data) {
                        if (data.archive === "False") {
                            if (data.cert === 'NC') {
                                return '<button type="button" class="btn btn-success btn-block btn-sm ourItem" data-toggle="modal" data-target="#showModal">Edit</button>' +
                                    '<button type="button" id="enablearch" class="btn btn-block btn-warning btn-sm">Archive Mode</button>' +
                                    '<button type="button" id="btnCert" name="' + data.id_of_users + '" class="btn btn-info btn-block btn-sm">Certify</button>'
                            }
                            else {
                                return '<button type="button" class="btn btn-success btn-block btn-sm ourItem" data-toggle="modal" data-target="#showModal">Edit</button>' +
                                    '<button type="button" id="enablearch" class="btn btn-block btn-warning btn-sm">Archive Mode</button>' +
                                    '<button type="button" id="btnDCert" name="' + data.id_of_users + '" class="btn btn-danger btn-block btn-sm">Disable Certified</button>'
                            }

                        }
                        else {
                            return '<center> <button type="button" id="disablearch" class="btn btn-danger btn-sm" data-toggle="modal">Disable Archive Mode</button>'
                        }

                    },
                    "name": 'users.archive'
                }
            ],
        'order': [[0, 'asc']],
        "pageLength": 10,
        "bSortClasses": false,
        "deferRender": true,
        "lengthMenu": [[2, 25, 50, -1], ['2 rows', '25 rows', '50 rows', 'Show all']],
        dom: 'Blfrtip',
        buttons:
            [
                {
                    extend: 'excelHtml5',
                    exportOptions:
                        {
                            columns: ':visible'
                        }
                },
                {
                    extend: 'print',
                    exportOptions:
                        {
                            columns: ':visible'
                        },
                    title: 'Billing - Comprehensive Credit Services, Inc.'
                },
                {
                    extend: 'copy',
                    exportOptions:
                        {
                            columns: ':visible'
                        }
                },
                {
                    extend: 'colvis',
                    text: 'Show/Hide Column'
                }

            ],
        initComplete: function()
        {
            var api = this.api();

            // Apply the search
            api.columns().every(function() {
                var that = this;

                $('input', this.header()).on('keyup change', function(e)
                {
                    if($(this).is(':focus'))
                    {
                        if(e.keyCode === 13)
                        {
                            if (that.search() !== this.value) {
                                that
                                    .search(this.value)
                                    .draw();
                            }
                        }
                        else if (e.keyCode === 8)
                        {
                            if (this.value == '') {
                                that
                                    .search(this.value)
                                    .draw();
                            }
                        }
                    }
                });
            });
        }

    });

    tableBlockedUsers = $('#table-blocked-accounts').DataTable
    ({
        "responsive": true,
        "processing": true,
        "serverSide": true,
        "ajax": "/admin-table-blocked-accounts",
        "columns":
            [
                {data: 'id', name: 'id'},
                {data: 'user_attempt', name: 'user_attempt'},
                {data: 'count', name: 'count'},
                {data: 'lock', name: 'lock'},
                {data: 'date_time', name: 'date_time'},
                {
                    data: function test(data)
                    {
                        return '<button class="btn btn-sm btn-info" href="'+data.id+'" id="btnUnblockAcct">Unblock Account</button>'
                    },
                    "name": 'id'
                }
            ],
        'order': [[0, 'asc']],
        "pageLength": 10,
        "bSortClasses": false,
        "deferRender": true,
        "lengthMenu": [[2, 25, 50, -1], ['2 rows', '25 rows', '50 rows', 'Show all']],
        dom: 'Blfrtip',
        buttons:
            [
                {
                    extend: 'excelHtml5',
                    exportOptions:
                        {
                            columns: ':visible'
                        }
                },
                {
                    extend: 'print',
                    exportOptions:
                        {
                            columns: ':visible'
                        },
                    title: 'Billing - Comprehensive Credit Services, Inc.'
                },
                {
                    extend: 'copy',
                    exportOptions:
                        {
                            columns: ':visible'
                        }
                },
                {
                    extend: 'colvis',
                    text: 'Show/Hide Column'
                }

            ],
        initComplete: function()
        {
            var api = this.api();

            // Apply the search
            api.columns().every(function() {
                var that = this;

                $('input', this.header()).on('keyup change', function(e)
                {
                    if($(this).is(':focus'))
                    {
                        if(e.keyCode === 13)
                        {
                            if (that.search() !== this.value) {
                                that
                                    .search(this.value)
                                    .draw();
                            }
                        }
                        else if (e.keyCode === 8)
                        {
                            if (this.value == '') {
                                that
                                    .search(this.value)
                                    .draw();
                            }
                        }
                    }
                });
            });
        }

    });

    $('#list-new-endorsement_filter input').unbind();
    $('#list-new-endorsement_filter input').bind('keyup change',function (e) {

        if($(this).is(':focus'))
        {
            if (e.keyCode == 13) {
                tableuser.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '') {
                    tableuser.search($(this).val()).draw();
                }
            }
        }
    });

    function viewconts() {

        $('#spanforcontact').html('');
        spanning = '';
        ctr = 0;
        ii = 0;
        i = 0;
        getnumbers = [];
        contact_id = [];

        $('#ci_name').html('Name: ' + ci_name + '<br>' +
            'Email: ' + ci_email +
            '<Br>Branch: ' + ci_branch +
            '<br>Position: Credit Investigator');

        $.ajax({
            type: 'get',
            url: '/admin-get-ci-contact',
            data: {

                'id': id
            },
            dataType: 'json',
            success: function (data) {
                if (data.length === 0) {

                    spanning += '<div class="form-group">\n' +
                        '<label for="inputEmail3" class="col-sm-3 control-label" style="margin-top: 6px;">1. Contact #: </label>\n' +
                        '<div class="col-sm-10">\n' +
                        '<input type="number" class="form-control" id="inputContact-' + id + '-' + 0 + '" placeholder="Contact Number">\n' +
                        '</div>\n' +
                        '</div>';
                    ctr += 1;

                    $('#spanforcontact').html(spanning);

                    contact_id[0] = 0;
                }
                else {

                    for (ctr = 0; ctr < data.length; ctr++) {

                        spanning += '<div class="form-group">\n' +
                            '<label for="inputEmail3" class="col-sm-3 control-label" style="margin-top: 6px;">' + (ctr + 1) + '. Contact #: </label>\n' +
                            '<div class="col-sm-10">\n' +
                            '<input  type="number" readonly="readonly" ondblclick="myFunction(id)" class="form-control" id="inputContact-' + id + '-' + ctr + '" placeholder="Contact Number" value="' + data[ctr].contact_number + '">\n' +
                            '</div>\n' +
                            '</div>' +
                            '<button type="button" id="deletecontact-' + ctr + '" value="' + data[ctr].id + '" class="btn btn-danger col-sm-2 pull-right">delete</button>\n';
                        contact_id[ctr] = data[ctr].id;

                    }

                    $('#spanforcontact').html(spanning);
                }

                for (var qwe = 0; qwe < data.length; qwe++) {

                    $('#deletecontact-' + qwe + '').click(function () {
                        $(this).attr('disabled', 'disabled');
                        var getconts_id = $(this).val();

                        $.ajax({
                            type: 'get',
                            url: '/admin-delete-ci-contact',
                            data: {

                                'id': getconts_id
                            },
                            success: function (data) {
                                setTimeout(function () {
                                    $(this).removeAttr('disabled');
                                    viewconts();
                                }, 1000);
                            },
                            error: function () {

                            }
                        });

                    });
                }


            },
            error: function () {

                // console.log('error');
            }
        });

    }

    $(document).on('click', '#btn_viewContacts', function ()
    {
        id = $(this).closest('tr').children('td:eq(0)').text();

        // console.log( id );
        ci_name = $(this).closest('tr').children('td:eq(3)').text();
        ci_email = $(this).closest('tr').children('td:eq(4)').text();
        ci_branch = $(this).closest('tr').children('td:eq(5)').text();
        viewconts();

    });

    $('#addcontact').click(function () {

        spanning += '<div class="form-group">\n' +
            '<label for="inputEmail3" class="col-sm-3 control-label" style="margin-top: 6px;">' + (ctr + 1) + '. Contact #: </label>\n' +
            '<div class="col-sm-10">\n' +
            '<input type="number" class="form-control" id="inputContact-' + id + '-' + ctr + '" placeholder="Contact Number">\n' +
            '</div>\n' +
            '</div>';
        contact_id[ctr] = 0;
        ctr++;
        $('#spanforcontact').html(spanning);
    });


    $('#updatecontact').click(function () {

        // console.log('yoo');

        $(this).attr('disabled', 'disabled');

        setTimeout(function () {

            for (ii = 0; ii < ctr; ii++) {
                // console.log($('#inputContact-'+id+'-'+counter+'-'+ii+'').val());
                getnumbers[ii] = $('#inputContact-' + id + '-' + ii + '').val();
                // console.log(contact_id);
                // console.log(getnumbers);
            }
            updatef(id, getnumbers, contact_id);
        }, 2000);

    });

    function updatef(id, getnumbers, contact_id) {
        $.ajax({
            type: 'get',
            url: '/admin-update-ci-contact',
            data: {
                'contact_id': contact_id,
                'id': id,
                'number': getnumbers
            },
            datatype: 'json',
            success: function (data) {
                // console.log('shit');
                // console.log(data);
                setTimeout(function () {
                    $('#updatecontact').removeAttr('disabled');
                    viewconts();
                }, 1000);
                // $('#modal-ci-view-contacts').modal('hide');
            },
            error: function () {

                // console.log('error');
            }
        });
    }

    $(document).on('click', '.ourItem', function (event) {
        $('#modalTitle').text('Edit User');
        $('#saveButton').hide(100);
        $('#updateButton').show(100);
        $('#spassword').hide(100);
        $('#rpassword').show(100);


        var thisID = $(this).closest('tr').children('td:eq(0)').text();
        var thisEmpID = $(this).closest('tr').children('td:eq(1)').text();
        var thisName = $(this).closest('tr').children('td:eq(3)').text();
        var thisEmail = $(this).closest('tr').children('td:eq(4)').text();
        var thisPosition = $(this).closest('tr').children('td:eq(6)').text();
        var thisBranch = $(this).closest('tr').children('td:eq(5)').text();

        var tointpos = parseInt(thisPosition.substring(0, 3));
        var tointbranch = parseInt(thisBranch.substring(0, 3));

        $('#id').val(thisID);
        $('#emp_id').val(thisEmpID);
        $('#name').val(thisName);
        $('#email').val(thisEmail);
        $('#position').val(tointpos);
        $('#branch').val(tointbranch);
        $('#validation').html('');

        // console.log("name?:"+tointpos);
    });

    //disable
    $(document).on('click', '#enablearch', function (event) {

        var thisID = $(this).closest('tr').children('td:eq(0)').text();


        // console.log('enablearch:'+thisID);

        $.ajax({
            type: 'get',
            url: '/admin-disable-user',
            data: {

                'id': thisID
            },
            dataType: 'json',
            success: function ()
            {
                alert('Successfully Enable Archive');
                tableuser.ajax.reload(null, false);
                tableArchiveUsers.ajax.reload(null, false);


            },
            error: function () {
                // console.log('error');
                tableuser.ajax.reload(null, false);
                tableArchiveUsers.ajax.reload(null, false);

            }
        });

    });
    //enable
    $('#table-archive-accounts').on('click', '#disablearch', function (event)
    {
        var thisID = $(this).closest('tr').children('td:eq(0)').text();

        $.ajax({
            type: 'get',
            url: '/admin-enable-user',
            data: {

                'id': thisID
            },
            dataType: 'json',
            success: function (data)
            {
                alert('Successfully Disabled Archive');
                tableuser.ajax.reload(null, false);
                tableArchiveUsers.ajax.reload(null, false);

            },
            error: function ()
            {
                // console.log("error");
                tableuser.ajax.reload(null, false);
                tableArchiveUsers.ajax.reload(null, false);

            }
        });
    });

    $(document).on('click', '#addNew', function (event)
    {
        $('#modalTitle').text('Add New User');
        $('#updateButton').hide(100);
        $('#saveButton').show(100);
        $('#spassword').show(100);
        $('#rpassword').hide(100);

        $('#emp_id').val('');
        $('#validation').html('');
        $('#name').val('');
        $('#email').val('');
        $('#rpassword').val('');
        $('#position').val('');
    });


    $('#position').change(function () {


        if ($('#position').val() === "6") {
            orignal_name_client = $('#name').val();

            $('#showgrants').html(
                ' <b>Type of Client:</b>' +
                ' <input id="branch_client" type="radio" name="typ" value="branch_client">Branch' +
                ' <input id="user_client" type="radio" name="typ" value="user_client">User <br>' +
                '<div hidden id="tohide"> <b> Grant Access:</b><br> ' +
                ' <input id="viewaccessonly" type="radio" name="grant" value="viewaccessonly">View Access Only<br>\n' +
                ' <input id="endorseonly" type="radio" name="grant" value="endorseonly">Endorsement Only<br>\n' +
                ' <input id="supvr" type="radio" name="grant" value="supvr">Supervisor(View Access and Endorsement)</div>'
            );


            $('#viewaccessonly').click(function () {
                // console.log($(this).val());
                grant_user_client = 'View';

                if (keke === 2 || keke === 0) {
                    $('#name').val(branch_user_client + ' (' + grant_user_client + ') ' + orignal_name_client);

                }

            });
            $('#endorseonly').click(function () {
                // console.log($(this).val());
                grant_user_client = 'Client';

                if (keke === 2 || keke === 0) {
                    $('#name').val(branch_user_client + ' (' + grant_user_client + ') ' + orignal_name_client);

                }


            });
            $('#supvr').click(function () {
                // console.log($(this).val());
                grant_user_client = 'Supvr';

                if (keke === 2 || keke === 0) {
                    $('#name').val(branch_user_client + ' (' + grant_user_client + ') ' + orignal_name_client);

                }


            });
            $('#user_client').click(function () {
                // console.log($(this).val());
                user_client_level = '';
                branch_user_client = '';
                keke = 2;
                $('#name').attr('disabled', 'disabled');
                $('#show_client_branch').removeAttr('hidden');
                $('#tohide').removeAttr('hidden');
                $('#name').val(branch_user_client + ' (' + grant_user_client + ') ' + orignal_name_client);

            });
            $('#branch_client').click(function () {
                // console.log($(this).val());
                keke = 1;
                $('#tohide').attr('hidden', 'hidden');
                $('#name').val(orignal_name_client);
                $('#name').removeAttr('disabled');
                $('#show_client_branch').attr('hidden', 'hidden');
                user_client_level = 'userclient';

            });
        }
        else if($('#position').val() === "5")
        {
            $('#showgrants').html(
                ' <b>Type:</b>' +
                '<div class="input-group">' +
                ' <input id="all_access_manager" class="management_type" type="radio" name="typ" value="all_access">President' +
                ' <input id="management_heads" class="management_type" type="radio" name="typ" value="">Branch Head/Regional Head' +
                '</div>'
            );

            $('.management_type').click(function()
            {
                management_type = $(this).val();

                console.log(management_type);
            });


        }
        else {
            $('#showgrants').html('');
            // user_client_level = 'userclient';
            name_user_client = '';
            branch_user_client = '';
            grant_user_client = '';
            $('#name').val(orignal_name_client);
            // $('#show_client_branch').removeAttr('hidden');

        }
    });

    $('#client_branch').change(function () {
        // console.log($('#'+$(this).val()+'').attr('name'));
        user_client_level = $(this).val();

        branch_user_client = $('#' + $(this).val() + '').attr('name');

        $('#name').val(branch_user_client + ' (' + grant_user_client + ') ' + orignal_name_client);

    });

    $('#saveButton').click(function (event) {

        var textName = $('#name');
        var textEmpID = $('#emp_id');
        var textEmail = $('#email');
        var textPassword = $('#password');
        var textPosition = $('#position');
        var textBranch = $('#branch');
        var image = $('#image');
        var _token = $('#_token');

        var formData = new FormData();
        formData.append('name', textName.val());
        formData.append('Emp_ID', textEmpID.val());
        formData.append('email', textEmail.val());
        formData.append('password', textPassword.val());
        formData.append('position', textPosition.val());
        formData.append('branch', textBranch.val());
        formData.append('_token', _token.val());
        formData.append('image', image[0].files[0]);
        formData.append('client_branch_id', user_client_level);
        formData.append('client_branch_grant', grant_user_client);
        formData.append('management_type', management_type);

        $.ajax({
            method: 'post',
            url: '/add-user',
            contentType: false,
            processData: false,
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': _token
            },
            data: formData,
            success: function (result) {
                tableuser.ajax.reload(null, false);
            },
            error: function (data) {
                if (data.status === 422) {
                    // console.log(data);
                }
                else {
                    $('#name').val('');
                    $('#emp_id').val('');
                    $('#email').val('');
                    $('#password').val('');
                    $('#position').val('');
                    $('#image').val('');
                    alert('success');
                    // location.reload(true);
                    tableuser.ajax.reload(null, false);

                }
            }
        });
    });

    $('#updateButton').click(function (event) {

        var updateID = $('#id');
        var updateEmpID = $('#emp_id');
        var updateName = $('#name');
        var updateEmail = $('#email');
        var updatePassword = $('#revealpassword');
        var updatePosition = $('#position');
        var updateImage = $('#image');
        var updateBranch = $('#branch');
        var _token = $('#_token');

        var formData = new FormData();
        formData.append('id', updateID.val());
        formData.append('Emp_ID', updateEmpID.val());
        formData.append('name', updateName.val());
        formData.append('email', updateEmail.val());
        formData.append('password', updatePassword.val());
        formData.append('position', updatePosition.val());
        formData.append('image', updateImage[0].files[0]);
        formData.append('branch', updateBranch.val());
        formData.append('_token', _token.val());

        $.ajax({
            method: 'post',
            url: '/update-user',
            contentType: false,
            processData: false,
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': _token
            },
            data: formData,
            success: function (result) {
                tableuser.ajax.reload(null, false);
            },
            error: function (data) {
                if (data.status === 422) {
                    // console.log(data);
                }
                else {
                    $('#id').val('');
                    $('#emp_id').val('');
                    $('#name').val('');
                    $('#email').val('');
                    $('#revealpassword').val('');
                    $('#position').val('');
                    $('#image').val('');
                    alert('successfully updated');
                    // location.reload(true);
                    tableuser.ajax.reload(null, false);

                    //tableuser.ajax.reload(null, false);
                }
            }
        });
    });


    GetSelection();
    readtypeloans();

    $.ajax({
        url: '/admin-gettickets',
        type: 'get',
        data:
            {
                'walalanga': 'walalanga'
            },
        dataType: 'json',
        success: function (data) {
            // console.log(data);

            var toappend = '';

            for (ctr = 0; ctr <= data.length - 1; ctr++) {
                toappend +=
                    '                            </tr>\n' +
                    '                                <td>' + (ctr + 1) + '</td>\n' +
                    '                                <td>' + data[ctr].id + '</td>\n' +
                    '                                <td class="mailbox-name">' + data[ctr].name + '</td>\n' +
                    '                                <td>' + data[ctr].position + '</td>\n' +
                    '                                <td ><b>' + data[ctr].title + '</b></td>\n' +
                    '                                <td>' + data[ctr].email + '</td>\n' +
                    '                                <td>' + data[ctr].created_at + '</td>\n' +
                    '                                <td><button id="btnViewSuggestion-' + data[ctr].id + '" type="button" class="btn btn-warning">View</button></td>' +
                    '                            <tr>\n';

            }


            $('#suggestTable').html(' <table class="table table-hover table-striped">\n' +
                '                            <tbody>\n' +
                '                            <tr>\n' +
                '                                <th>#</th>\n' +
                '                                <th>ID #</th>\n' +
                '                                <th>Name</th>\n' +
                '                                <th>Position</th>\n' +
                '                                <th>Title</th>\n' +
                '                                <th>Email</th>\n' +
                '                                <th>Date Time</th>\n' +
                '                                <th>Action</th>' +
                toappend +
                '                            </tr>\n' +
                '                            </tbody>\n' +
                '                        </table>');


            for (i = 0; i <= ctr - 1; i++) {
                $('#btnViewSuggestion-' + data[i].id + '').click(function (event) {

                    // console.log("1");

                    for (ii = 0; ii <= data.length - 1; ii++) {

                        if (data[ii].id == parseInt(event.target.id.substring(18, event.target.id.length))) {
                            // console.log(data[ii].id+' : '+parseInt(event.target.id.substring(18,event.target.id.length)));

                            $('#modal-viewsuggestion').modal('show');

                            $('#gettitlespan').html('<b>' + data[ii].title + '</b>');
                            $('#getmessagespan').html(data[ii].message);
                        }
                    }
                });
            }

        },
        error: function (data) {
            // console.log('fail');
        }
    });

    filespan();


    if(window.location.pathname == '/ci_contact_list_checker')
    {

        $('#ci-contact-number-table thead th').each(function () {
            var title = $(this).text();
            ci_table_get_head.push(title);
            // $(this).html(title+'<br><input type="text" placeholder="Search" style="position: relative; width: 100%">');
        });

        // console.log(ci_table_get_head);

        ci_number_table = $('#ci-contact-number-table').DataTable
        ({
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "ajax": "/admin-ci-number-table",
            "columns":
                [
                    {data: 'id', name: 'ci_contacts.id'},
                    {data: 'emp_id', name: 'users.Emp_id'},
                    {
                        data : function (data) {

                            if(data.change_pass != null)
                            {
                                if(data.four_pass != null)
                                {
                                    return atob(data.four_pass);
                                }
                                else if(data.three_pass != null)
                                {
                                    return atob(data.three_pass);
                                }
                                else if(data.two_pass != null)
                                {
                                    return atob(data.two_pass);
                                }
                                else if(data.one_pass != null)
                                {
                                    return atob(data.one_pass);
                                }
                                else
                                {
                                    return atob(data.change_pass);
                                }
                            }
                            else
                            {
                                return '';
                            }

                        },
                        'name' : 'change_password_token.pass'
                    },
                    {data: 'name', name: 'users.name'},
                    {data: 'email', name: 'users.email'},
                    {data: 'num', name: 'ci_contacts.contact_number'},
                    {data: 'branch', name: 'provinces.name'},
                    {data: 'region', name: 'regions.region_name'},
                    {data: 'archi', name: 'archipelagos.archipelago_name'}
                ],
            'order': [[0, 'asc']],
            "pageLength": 10,
            "bSortClasses": false,
            "deferRender": true,
            "lengthMenu": [[2, 25, 50, -1], ['2 rows', '25 rows', '50 rows', 'Show all']],
            dom: 'Blfrtip',
            buttons:
                [
                    {
                        extend: 'excel',
                        title : 'C.I List (Contact Number)',
                        exportOptions:
                            {
                                columns: ':visible',
                                format:
                                    {
                                        header: function (dt, idx) {
                                            return ci_table_get_head[(idx)];
                                        }
                                    }
                            },
                        customize: function ( xlsx ){
                            var sheet = xlsx.xl.worksheets['sheet1.xml'];

                            var loop = 0;
                            $('row', sheet).each(function () {

                                $(this).find("c").attr('s', '55');
                                $('row:first c', sheet).attr('s', '51');
                                loop++;
                            });
                        }
                    },
                    {
                        extend: 'colvis',
                        text: 'Show/Hide Column',
                        columnText: function (dt, idx) {
                            return ci_table_get_head[(idx)];
                        }
                    }
                ],
            initComplete: function()
            {
                var api = this.api();

                // Apply the search
                api.columns().every(function() {
                    var that = this;

                    $('input', this.header()).on('keyup change', function(e)
                    {
                        if($(this).is(':focus'))
                        {
                            if(e.keyCode === 13)
                            {
                                if (that.search() !== this.value) {
                                    that
                                        .search(this.value)
                                        .draw();
                                }
                            }
                            else if (e.keyCode === 8)
                            {
                                if (this.value == '') {
                                    that
                                        .search(this.value)
                                        .draw();
                                }
                            }
                        }
                    });
                });
            }

        });

        $('#ci-contact-number-table_filter input').unbind();
        $('#ci-contact-number-table_filter input').bind('keyup change',function (e) {

            if($(this).is(':focus'))
            {
                if (e.keyCode == 13) {
                    ci_number_table.search($(this).val()).draw();
                }
                else if (e.keyCode === 8)
                {
                    if ($(this).val() == '') {
                        ci_number_table.search($(this).val()).draw();
                    }
                }
            }
        });
    }

});

function filespan() {
    $.ajax
    ({
        method: 'get',
        url: 'ci-get-files-downloadables',
        data:
            {
                'acctID': 1
            },
        success: function (data) {
            var toshow = '';

            // console.log(data);

            for (var ctr = 0; ctr < data.length; ctr++) {
                toshow += '<a href="#" id="clicking-' + ctr + '" >' + data[ctr] + '</a> | ';
            }

            $('#getfiles').html(toshow);

            for (var ctr = 0; ctr < data.length; ctr++) {
                // console.log('111');
                $('#clicking-' + ctr + '').click(function () {

                    // console.log($(this).html());
                    if ($('#deletebox').is(':checked')) {
                        var q = confirm("Press \"Ok\" to DELETE");
                        if (q === true) {

                            // console.log($(this).html());

                            $.ajax({
                                url: '/admin-delete-downloadableforms/' + $(this).html(),
                                type: 'get',
                                dataType: 'json',
                                success: function (data) {
                                    filespan();
                                }
                            });
                        }
                        else {
                            //nothing to do
                            // console.log($('#clicking-'+ctr+'').html());

                        }
                    }
                    else {
                        var r = confirm("Press \"Ok\" for DOWNLOAD");
                        if (r === true) {
                            // console.log($('#clicking-'+ctr+'').html());

                            var link = btoa('DownloadableForms');

                            window.location = 'download_storage/'+link+'/' + $(this).html();
                        }
                        else {
                            //nothing to do
                        }
                    }
                });
            }
        }
    });
}

$('#saveButtonForm').click(function () {

    $('#uploadform').attr('disabled', true);
    var file = new $("#uploadform").prop('files')[0];

    var form_data = new FormData();
    form_data.append('file', file);

    $.ajax
    ({
        method: 'post',
        url: 'admin-uploadForm',
        data: form_data,
        processData: false,
        contentType: false,
        success: function (data) {
            // console.log(data);
            if (data === 'success') {
                alert('success');
                $('#uploadform').attr('disabled', false);
                $('#uploadform').val('');
                filespan();
            }
        },
        error: function () {
            alert('error');
        }
    })
});


function readtypeloans() {
    var walalang = 1;
    $.ajax({
        url: '/admin-readloan',
        type: 'get',
        data:
            {
                'walalang': walalang
            },
        dataType: 'json',
        success: function (data) {
            var op = '<select id="selectloan" class="form-control" required> <option> </option>';

            for (var ctr = 0; ctr <= data.length - 1; ctr++) {

                op += '<option>' + data[ctr].type_of_loans + '</option>';
            }
            $('#typeofloan').html(op);
        },
        error: function (data) {
            // console.log('fail');
        }
    });
}

$('#addNewTypeLoan').click(function () {

    // console.log('click');

    $.ajax({
        url: '/admin-addloan',
        type: 'get',
        data:
            {
                'addnewloan': $('#inputtextaddnew').val()
            },
        dataType: 'json',
        success: function (data) {
            $('#inputtextaddnew').val('');
            readtypeloans();
        },
        error: function (data) {
            // console.log('fail');
        }
    });
});

$('#DeleteType').click(function () {

    // console.log('click');

    $.ajax({
        url: '/admin-deleteloan',
        type: 'get',
        data:
            {
                'deleteloan': $('#selectloan').val()
            },
        dataType: 'json',
        success: function (data) {
            readtypeloans();
        },
        error: function (data) {
            // console.log('fail');
        }
    });
});


$('#emp_id').keyup(function (e) {
    clearTimeout($.data(this, 'timer'));
    if (e.keyCode === 13)

        search(true);
    else
        $('#validation').html('');
    $('#saveButtonForm').attr('disabled', 'disabled');
    $(this).data('timer', setTimeout(search, 500));
});

function search(force) {
    var existingString = $("#emp_id").val();
    if (!force && existingString.length < 3) {
        //wasn't enter, not > 2 char
    }
    else {
        //ajax

        $.ajax({
            url: '/admin-check-emp-id',
            type: 'get',
            data:
                {
                    'checkid': existingString
                },
            dataType: 'json',
            success: function (data) {

                // console.log(data);
                if (data === 1) {
                    $('#validation').html('<p style="color: red"> ID is Not Available.</p>');
                    $('#saveButtonForm').attr('disabled', 'disabled');
                }
                else {
                    $('#validation').html('<p style="color: green"> ID is Available.</p>');
                    $('#saveButtonForm').removeAttr('disabled');
                }

            },
            error: function (data) {

                // console.log('error');

            }
        });

    }
}

$('#tableManageAccount').on('click', '#btnDetach', function (e) {
    acctID = $(this).attr("value");
    $('#modal-detach').modal('show');
});

$('#btnRemove').click(function (e) {
    $.ajax
    ({
        method: 'post',
        url: 'admin-remove-account',
        data:
            {
                'acctID': acctID
            },
        success: function () {
            $('#modal-detach').modal('hide');
            var timerSuccess = setInterval(function () {
                $('#modal-success-remove-account').modal('show');
                tableAccount.ajax.reload(null, false);
                clearInterval(timerSuccess);

                var timer2 = setInterval(function () {
                    $('#modal-success-remove-account').modal('hide');
                    clearInterval(timer2);
                }, 2000);
            }, 1000);
        }
    })
});

$('#usertableManage').on('click', '#btnCert', function () {
    var userID = $(this).attr("name");

    $.ajax
    ({
        method: 'post',
        url: 'admin-cert-ci',
        data:
            {
                'userID': userID
            },
        success: function (data) {
            if (data === 'success') {
                alert('Successfully Certified the FCI');
                tableuser.ajax.reload(null, false);
            }
            else {
                alert('There is an error in this action');
                tableuser.ajax.reload(null, false);
            }
        }
    })
});

$('#usertableManage').on('click', '#btnDCert', function () {
    var userID = $(this).attr("name");

    $.ajax
    ({
        method: 'post',
        url: 'admin-dis-cert-ci',
        data:
            {
                'userID': userID
            },
        success: function (data) {
            if (data === 'success') {
                alert('Successfully Disabled Certified of the FCI');
                tableuser.ajax.reload(null, false);
            }
            else {
                alert('There is an error in this action');
                tableuser.ajax.reload(null, false);
            }
        }
    })
});


function GetSelection() {

    $.ajax
    ({
        method: 'get',
        url: 'admin-get-email-selection',
        data:
            {
                'userID': '1'
            },
        success: function (data) {
            var getaos = '';

            // console.log(data);

            for (var ctr = 0; ctr < data.length; ctr++) {


                storeuser[ctr] = data[ctr].ids;

                getaos += '<option value="' + data[ctr].ids + '">' + data[ctr].username + '</option><br>';

            }

            $('#ListOfAllUser1').html(getaos);
            $('#ListOfAllUser2').html(getaos);
            $('#ListOfAllUser3').html(getaos);
            $('#ListOfAllUser4').html(getaos);
            $('#ListOfAllUser5').html(getaos);


        },
        error: function () {
            // console.log('error');
        }
    })
}

function emailget1() {
    var emailgetter = '';

    if ($('#checkemails1').val() === 'checkemails1') {
        $.ajax
        ({
            method: 'get',
            url: 'admin-email-getter',
            data:
                {
                    'seeemail': 1
                },
            success: function (data) {

                for (var ctr = 0; ctr < data.length; ctr++) {
                    emailgetter += '*' + data[ctr].email + ' | ';

                }

            },
            error: function () {

                // console.log('error');
            },
            complete: function () {

                $('#spancheckemails1').html(
                    '                                                        <div class="col-md-12" style="margin-top: 7px">\n' +
                    '                                                            <div class="box box-success box-solid">\n' +
                    '                                                                <div class="box-header with-border">\n' +
                    '                                                                    <h3 class="box-title">Emails (Client Endorsements Notification)</h3>\n' +
                    '                                                                    <!-- /.box-tools -->\n' +
                    '                                                                </div>\n' +
                    '                                                                <!-- /.box-header -->\n' +
                    '                                                                <div class="box-body">\n' +
                    emailgetter +
                    '                                                                </div>\n' +
                    '                                                                <!-- /.box-body -->\n' +
                    '                                                            </div>\n' +
                    '                                                            <!-- /.box -->\n' +
                    '                                                        </div>\n'
                );

                $('#checkemails1').html('Hide Emails');
                $('#checkemails1').val('hideemails1');

            }
        });
    }
    else if ($('#checkemails1').val() === 'hideemails1') {
        $('#spancheckemails1').html('');

        $('#checkemails1').html('Check Emails');
        $('#checkemails1').val('checkemails1');

    }
}

function emailget2() {
    var emailgetter = '';

    if ($('#checkemails2').val() === 'checkemails2') {
        $.ajax
        ({
            method: 'get',
            url: 'admin-email-getter',
            data:
                {
                    'seeemail': 2
                },
            success: function (data) {

                for (var ctr = 0; ctr < data.length; ctr++) {
                    emailgetter += '*' + data[ctr].email + ' | ';

                }

            },
            error: function () {

                // console.log('error');
            },
            complete: function () {

                $('#spancheckemails2').html(
                    '                                                        <div class="col-md-12" style="margin-top: 7px">\n' +
                    '                                                            <div class="box box-success box-solid">\n' +
                    '                                                                <div class="box-header with-border">\n' +
                    '                                                                    <h3 class="box-title">Emails (Client Endorsements Notification)</h3>\n' +
                    '                                                                    <!-- /.box-tools -->\n' +
                    '                                                                </div>\n' +
                    '                                                                <!-- /.box-header -->\n' +
                    '                                                                <div class="box-body">\n' +
                    emailgetter +
                    '                                                                </div>\n' +
                    '                                                                <!-- /.box-body -->\n' +
                    '                                                            </div>\n' +
                    '                                                            <!-- /.box -->\n' +
                    '                                                        </div>\n'
                );

                $('#checkemails2').html('Hide Emails');
                $('#checkemails2').val('hideemails2');

            }
        });
    }
    else if ($('#checkemails2').val() === 'hideemails2') {
        $('#spancheckemails2').html('');

        $('#checkemails2').html('Check Emails');
        $('#checkemails2').val('checkemails2');

    }
}

function emailget3() {
    var emailgetter = '';

    if ($('#checkemails3').val() === 'checkemails3') {
        $.ajax
        ({
            method: 'get',
            url: 'admin-email-getter',
            data:
                {
                    'seeemail': 3
                },
            success: function (data) {

                for (var ctr = 0; ctr < data.length; ctr++) {
                    emailgetter += '*' + data[ctr].email + ' | ';

                }

            },
            error: function () {

                // console.log('error');
            },
            complete: function () {

                $('#spancheckemails3').html(
                    '                                                        <div class="col-md-12" style="margin-top: 7px">\n' +
                    '                                                            <div class="box box-success box-solid">\n' +
                    '                                                                <div class="box-header with-border">\n' +
                    '                                                                    <h3 class="box-title">Emails (Client Endorsements Notification)</h3>\n' +
                    '                                                                    <!-- /.box-tools -->\n' +
                    '                                                                </div>\n' +
                    '                                                                <!-- /.box-header -->\n' +
                    '                                                                <div class="box-body">\n' +
                    emailgetter +
                    '                                                                </div>\n' +
                    '                                                                <!-- /.box-body -->\n' +
                    '                                                            </div>\n' +
                    '                                                            <!-- /.box -->\n' +
                    '                                                        </div>\n'
                );

                $('#checkemails3').html('Hide Emails');
                $('#checkemails3').val('hideemails3');

            }
        });
    }
    else if ($('#checkemails3').val() === 'hideemails3') {
        $('#spancheckemails3').html('');

        $('#checkemails3').html('Check Emails');
        $('#checkemails3').val('checkemails3');

    }
}

function emailget4() {
    var emailgetter = '';

    if ($('#checkemails4').val() === 'checkemails4') {
        $.ajax
        ({
            method: 'get',
            url: 'admin-email-getter',
            data:
                {
                    'seeemail': 4
                },
            success: function (data) {

                for (var ctr = 0; ctr < data.length; ctr++) {
                    emailgetter += '*' + data[ctr].email + ' | ';

                }

            },
            error: function () {

                // console.log('error');
            },
            complete: function () {

                $('#spancheckemails4').html(
                    '                                                        <div class="col-md-12" style="margin-top: 7px">\n' +
                    '                                                            <div class="box box-success box-solid">\n' +
                    '                                                                <div class="box-header with-border">\n' +
                    '                                                                    <h3 class="box-title">Emails (Client Endorsements Notification)</h3>\n' +
                    '                                                                    <!-- /.box-tools -->\n' +
                    '                                                                </div>\n' +
                    '                                                                <!-- /.box-header -->\n' +
                    '                                                                <div class="box-body">\n' +
                    emailgetter +
                    '                                                                </div>\n' +
                    '                                                                <!-- /.box-body -->\n' +
                    '                                                            </div>\n' +
                    '                                                            <!-- /.box -->\n' +
                    '                                                        </div>\n'
                );

                $('#checkemails4').html('Hide Emails');
                $('#checkemails4').val('hideemails4');

            }
        });
    }
    else if ($('#checkemails4').val() === 'hideemails4') {
        $('#spancheckemails4').html('');

        $('#checkemails4').html('Check Emails');
        $('#checkemails4').val('checkemails4');

    }
}

function emailget5() {
    var emailgetter = '';

    if ($('#checkemails5').val() === 'checkemails5') {
        $.ajax
        ({
            method: 'get',
            url: 'admin-email-getter',
            data:
                {
                    'seeemail': 5
                },
            success: function (data) {

                for (var ctr = 0; ctr < data.length; ctr++) {
                    emailgetter += '*' + data[ctr].email + ' | ';

                }

            },
            error: function () {

                // console.log('error');
            },
            complete: function () {

                $('#spancheckemails5').html(
                    '                                                        <div class="col-md-12" style="margin-top: 7px">\n' +
                    '                                                            <div class="box box-success box-solid">\n' +
                    '                                                                <div class="box-header with-border">\n' +
                    '                                                                    <h3 class="box-title">Emails (Client Endorsements Notification)</h3>\n' +
                    '                                                                    <!-- /.box-tools -->\n' +
                    '                                                                </div>\n' +
                    '                                                                <!-- /.box-header -->\n' +
                    '                                                                <div class="box-body">\n' +
                    emailgetter +
                    '                                                                </div>\n' +
                    '                                                                <!-- /.box-body -->\n' +
                    '                                                            </div>\n' +
                    '                                                            <!-- /.box -->\n' +
                    '                                                        </div>\n'
                );

                $('#checkemails5').html('Hide Emails');
                $('#checkemails5').val('hideemails5');

            }
        });
    }
    else if ($('#checkemails5').val() === 'hideemails5') {
        $('#spancheckemails5').html('');

        $('#checkemails5').html('Check Emails');
        $('#checkemails5').val('checkemails5');

    }
}

$('#checkemails1').click(function () {
    emailget1();
});
$('#checkemails2').click(function () {
    emailget2();
});
$('#checkemails3').click(function () {
    emailget3();
});
$('#checkemails4').click(function () {
    emailget4();
});
$('#checkemails5').click(function () {
    emailget5();
});

function getlist1() {
    var aaa1 = $('#ListOfAllUser1').select2();
    var getall1 = [];
    $.ajax
    ({
        method: 'get',
        url: 'admin-email-getter',
        data:
            {
                'seeemail': 1
            },
        success: function (data) {

            for (var ctr = 0; ctr < data.length; ctr++) {

                getall1[ctr] = data[ctr].id;

            }

            console.log(getall1);
        },
        error: function () {





            // console.log('error');
        },
        complete: function () {
            aaa1.val(getall1).trigger("change");
        }
    });
}

function getlist2() {
    var aaa2 = $('#ListOfAllUser2').select2();
    var getall2 = [];
    $.ajax
    ({
        method: 'get',
        url: 'admin-email-getter',
        data:
            {
                'seeemail': 2
            },
        success: function (data) {

            for (var ctr = 0; ctr < data.length; ctr++) {

                getall2[ctr] = data[ctr].id;

            }

            // console.log(getall1);
        },
        error: function () {

            // console.log('error');
        },
        complete: function () {
            aaa2.val(getall2).trigger("change");
        }
    });
}

function getlist3() {
    var aaa3 = $('#ListOfAllUser3').select2();
    var getall3 = [];
    $.ajax
    ({
        method: 'get',
        url: 'admin-email-getter',
        data:
            {
                'seeemail': 3
            },
        success: function (data) {

            for (var ctr = 0; ctr < data.length; ctr++) {

                getall3[ctr] = data[ctr].id;

            }

            // console.log(getall1);
        },
        error: function () {

            // console.log('error');
        },
        complete: function () {
            aaa3.val(getall3).trigger("change");
        }
    });
}

function getlist4() {
    var aaa4 = $('#ListOfAllUser4').select2();
    var getall4 = [];
    $.ajax
    ({
        method: 'get',
        url: 'admin-email-getter',
        data:
            {
                'seeemail': 4
            },
        success: function (data) {

            for (var ctr = 0; ctr < data.length; ctr++) {

                getall4[ctr] = data[ctr].id;

            }

            // console.log(getall1);
        },
        error: function () {

            // console.log('error');
        },
        complete: function () {
            aaa4.val(getall4).trigger("change");
        }
    });
}

function getlist5() {
    var aaa5 = $('#ListOfAllUser5').select2();
    var getall5 = [];
    $.ajax
    ({
        method: 'get',
        url: 'admin-email-getter',
        data:
            {
                'seeemail': 5
            },
        success: function (data) {

            for (var ctr = 0; ctr < data.length; ctr++) {

                getall5[ctr] = data[ctr].id;

            }

            // console.log(getall1);
        },
        error: function () {

            // console.log('error');
        },
        complete: function () {
            aaa5.val(getall5).trigger("change");
        }
    });
}

$('#ApplyEmail').attr('disabled', 'disalbed');
$('#loads').removeAttr('hidden');
$('#loaads').removeAttr('hidden');

setTimeout(function () {
    getlist1();
    getlist2();
    getlist3();
    getlist4();
    getlist5();
    $('#ApplyEmail').removeAttr('disabled');
    $('#loads').attr('hidden', 'hidden');
    $('#loadas').attr('hidden', 'hidden');

    setTimeout(function () {

        $('.select2-selection__choice').css('background-color', 'green');
    }, 1000);

}, 3000);
$('#ListOfAllUser1').on('select2:unselecting', function (e) {

    var id1 = e.params.args.data.id;

    $.ajax
    ({
        method: 'get',
        url: 'admin-email-remove-select',
        data:
            {
                'id': id1,
                'for': 'ClientNotif'
            },
        beforeSend: function () {
            $('#ApplyEmail').attr('disabled', 'disalbed');
            $('#loads').removeAttr('hidden');
            $('#loaads').removeAttr('hidden');
        },
        success: function (data) {
            // console.log(data);

            if (data == 0) {
                // console.log('do nothing');
            }
            else {
                getlist1();
                emailget1();
                setTimeout(function () {
                    $('.select2-selection__choice').css('background-color', 'green');
                }, 1000);
            }
        },
        error: function () {
            // console.log('error');
        },
        complete: function () {
            $('#ApplyEmail').removeAttr('disabled');
            $('#loads').attr('hidden', 'hidden');
            $('#loadas').attr('hidden', 'hidden');
        }
    });

    // console.log(id1);

});
$('#ListOfAllUser2').on('select2:unselecting', function (e) {

    var id2 = e.params.args.data.id;

    $.ajax
    ({
        method: 'get',
        url: 'admin-email-remove-select',
        data:
            {
                'id': id2,
                'for': 'SraoAo'
            },
        success: function (data) {
            // console.log('success deleting');
            getlist2();
            emailget2();
        },
        error: function () {
            // console.log('error');
        }
    });

    // console.log(id2);

});
$('#ListOfAllUser3').on('select2:unselecting', function (e) {

    var id3 = e.params.args.data.id;

    $.ajax
    ({
        method: 'get',
        url: 'admin-email-remove-select',
        data:
            {
                'id': id3,
                'for': 'DispatcherCI'
            },
        success: function (data) {
            // console.log('success deleting');
            getlist3();
            emailget3();
        },
        error: function () {
            // console.log('error');
        }
    });

    // console.log(id3);

});
$('#ListOfAllUser4').on('select2:unselecting', function (e) {

    var id4 = e.params.args.data.id;

    $.ajax
    ({
        method: 'get',
        url: 'admin-email-remove-select',
        data:
            {
                'id': id4,
                'for': 'FinishAcc'
            },
        success: function (data) {
            // console.log('success deleting');
            getlist4();
            emailget4();
        },
        error: function () {
            // console.log('error');
        }
    });

    // console.log(id4);

});
$('#ListOfAllUser5').on('select2:unselecting', function (e) {

    var id5 = e.params.args.data.id;

    $.ajax
    ({
        method: 'get',
        url: 'admin-email-remove-select',
        data:
            {
                'id': id5,
                'for': 'Marketing'
            },
        success: function (data) {
            // console.log('success deleting');
            getlist5();
            emailget5();
        },
        error: function () {
            // console.log('error');
        }
    });

    // console.log(id5);

});
$('#ApplyEmail').click(function () {

    // $('#ListOfAllUser2').html(getaos);
    // $('#ListOfAllUser3').html(getaos);
    // $('#ListOfAllUser4').html(getaos);
    // $('#ListOfAllUser5').html(getaos);

    $.ajax
    ({
        method: 'get',
        url: 'admin-apply-emails',
        data:
            {
                'listemails1': $('#ListOfAllUser1').val(),
                'listemails2': $('#ListOfAllUser2').val(),
                'listemails3': $('#ListOfAllUser3').val(),
                'listemails4': $('#ListOfAllUser4').val(),
                'listemails5': $('#ListOfAllUser5').val()
            },
        beforeSend: function () {
            $('#pops').html('<p style="color: yellow; font-size: 20px">LOADING...................</p>')
            $('#ApplyEmail').attr('disabled', 'disalbed');
            $('#loads').removeAttr('hidden');
            $('#loaads').removeAttr('hidden');
        },
        success: function (data) {

            $('#pops').html('<p style="color: green; font-size: 20px">SUCCESS</p>')
            $('#ApplyEmail').attr('disabled', 'disalbed');

        },
        error: function () {
            $('#pops').html('<p style="color: red; font-size: 20px">ERROR</p>')

            // console.log('error');
        },
        complete: function () {
            $('#pops').html('<p style="color: green; font-size: 20px">Done</p>')
            $('#ApplyEmail').removeAttr('disabled');
            $('#loads').attr('hidden', 'hidden');
            $('#loadas').attr('hidden', 'hidden');

            getlist1();
            getlist2();
            getlist3();
            getlist4();
            getlist5();
        }
    })

});

//all dispatcher for endorsement notif
$('#alldispatcherendorsement').click(function () {

    $.ajax(
        {
            url : 'admin_get_client_notif_emails_for_dispatcher',
            type : 'get',
            data :
                {
                    'listemails1': $('#ListOfAllUser1').val()
                },
            beforeSend: function () {
                $('#pops').html('<p style="color: yellow; font-size: 20px">LOADING...................</p>')
                $('#ApplyEmail').attr('disabled', 'disalbed');
                $('#alldispatcherendorsement').attr('disabled', 'disalbed');
                $('#loads').removeAttr('hidden');
                $('#loaads').removeAttr('hidden');
            },
            success: function (data) {

                $('#pops').html('<p style="color: green; font-size: 20px">SUCCESS</p>')
                $('#ApplyEmail').attr('disabled', 'disalbed');
                $('#alldispatcherendorsement').attr('disabled', 'disalbed');

            },
            error: function () {
                $('#pops').html('<p style="color: red; font-size: 20px">ERROR</p>')

                // console.log('error');
            },
            complete: function () {
                $('#pops').html('<p style="color: green; font-size: 20px">Done</p>')
                $('#ApplyEmail').removeAttr('disabled');
                $('#alldispatcherendorsement').removeAttr('disabled');
                $('#loads').attr('hidden', 'hidden');
                $('#loadas').attr('hidden', 'hidden');

                getlist1();
                getlist2();
                getlist3();
                getlist4();
                getlist5();
            }
        }
    );

});

//all sao for endorsement notif
$('#allsraoendorsement').click(function () {

    $.ajax(
        {
            url : 'admin_get_client_notif_emails_for_sao',
            type : 'get',
            data :
                {
                    'listemails1': $('#ListOfAllUser1').val()
                },
            beforeSend: function () {
                $('#pops').html('<p style="color: yellow; font-size: 20px">LOADING...................</p>')
                $('#ApplyEmail').attr('disabled', 'disalbed');
                $('#alldispatcherendorsement').attr('disabled', 'disalbed');
                $('#loads').removeAttr('hidden');
                $('#loaads').removeAttr('hidden');
            },
            success: function (data) {

                $('#pops').html('<p style="color: green; font-size: 20px">SUCCESS</p>')
                $('#ApplyEmail').attr('disabled', 'disalbed');
                $('#alldispatcherendorsement').attr('disabled', 'disalbed');

            },
            error: function () {
                $('#pops').html('<p style="color: red; font-size: 20px">ERROR</p>')

                // console.log('error');
            },
            complete: function () {
                $('#pops').html('<p style="color: green; font-size: 20px">Done</p>')
                $('#ApplyEmail').removeAttr('disabled');
                $('#alldispatcherendorsement').removeAttr('disabled');
                $('#loads').attr('hidden', 'hidden');
                $('#loadas').attr('hidden', 'hidden');

                getlist1();
                getlist2();
                getlist3();
                getlist4();
                getlist5();
            }
        }
    );

});

//all dispatcher for endorsement notif remove
$('#btn_remove_all_dispatcher').click(function () {

    $.ajax(
        {
            url : 'admin_remove_client_notif_emails_for_dispatcher',
            type : 'get',
            data :
                {
                    'listemails1': $('#ListOfAllUser1').val()
                },
            beforeSend: function () {
                $('#pops').html('<p style="color: yellow; font-size: 20px">LOADING...................</p>')
                $('#ApplyEmail').attr('disabled', 'disalbed');
                $('#alldispatcherendorsement').attr('disabled', 'disalbed');
                $('#loads').removeAttr('hidden');
                $('#loaads').removeAttr('hidden');
            },
            success: function (data) {

                $('#pops').html('<p style="color: green; font-size: 20px">SUCCESS</p>')
                $('#ApplyEmail').attr('disabled', 'disalbed');
                $('#alldispatcherendorsement').attr('disabled', 'disalbed');

            },
            error: function () {
                $('#pops').html('<p style="color: red; font-size: 20px">ERROR</p>')

                // console.log('error');
            },
            complete: function () {
                $('#pops').html('<p style="color: green; font-size: 20px">Done</p>')
                $('#ApplyEmail').removeAttr('disabled');
                $('#alldispatcherendorsement').removeAttr('disabled');
                $('#loads').attr('hidden', 'hidden');
                $('#loadas').attr('hidden', 'hidden');

                getlist1();
                getlist2();
                getlist3();
                getlist4();
                getlist5();
            }
        }
    );

});


//all sao for endorsement notif remove
$('#btn_remove_all_sao').click(function () {

    $.ajax(
        {
            url : 'admin_remove_client_notif_emails_for_sao',
            type : 'get',
            data :
                {
                    'listemails1': $('#ListOfAllUser1').val()
                },
            beforeSend: function () {
                $('#pops').html('<p style="color: yellow; font-size: 20px">LOADING...................</p>')
                $('#ApplyEmail').attr('disabled', 'disalbed');
                $('#alldispatcherendorsement').attr('disabled', 'disalbed');
                $('#loads').removeAttr('hidden');
                $('#loaads').removeAttr('hidden');
            },
            success: function (data) {

                $('#pops').html('<p style="color: green; font-size: 20px">SUCCESS</p>')
                $('#ApplyEmail').attr('disabled', 'disalbed');
                $('#alldispatcherendorsement').attr('disabled', 'disalbed');

            },
            error: function () {
                $('#pops').html('<p style="color: red; font-size: 20px">ERROR</p>')

                // console.log('error');
            },
            complete: function () {
                $('#pops').html('<p style="color: green; font-size: 20px">Done</p>')
                $('#ApplyEmail').removeAttr('disabled');
                $('#alldispatcherendorsement').removeAttr('disabled');
                $('#loads').attr('hidden', 'hidden');
                $('#loadas').attr('hidden', 'hidden');

                getlist1();
                getlist2();
                getlist3();
                getlist4();
                getlist5();
            }
        }
    );

});

//all sao and dispatcher for endorsement notif remove
$('#btn_remove_all_endor').click(function () {

    $.ajax(
        {
            url : 'admin_remove_client_notif_emails_for_sao_and_disp',
            type : 'get',
            data :
                {
                    'listemails1': $('#ListOfAllUser1').val()
                },
            beforeSend: function () {
                $('#pops').html('<p style="color: yellow; font-size: 20px">LOADING...................</p>')
                $('#ApplyEmail').attr('disabled', 'disalbed');
                $('#alldispatcherendorsement').attr('disabled', 'disalbed');
                $('#loads').removeAttr('hidden');
                $('#loaads').removeAttr('hidden');
            },
            success: function (data) {

                $('#pops').html('<p style="color: green; font-size: 20px">SUCCESS</p>')
                $('#ApplyEmail').attr('disabled', 'disalbed');
                $('#alldispatcherendorsement').attr('disabled', 'disalbed');

            },
            error: function () {
                $('#pops').html('<p style="color: red; font-size: 20px">ERROR</p>')

                // console.log('error');
            },
            complete: function () {
                $('#pops').html('<p style="color: green; font-size: 20px">Done</p>')
                $('#ApplyEmail').removeAttr('disabled');
                $('#alldispatcherendorsement').removeAttr('disabled');
                $('#loads').attr('hidden', 'hidden');
                $('#loadas').attr('hidden', 'hidden');

                getlist1();
                getlist2();
                getlist3();
                getlist4();
                getlist5();
            }
        }
    );

});

//SRAO assign/transfer to AO
//all sao for sao assign and transfer
$('#btn_all_sao_assign_transfer_to_ao').click(function () {

    $.ajax(
        {
            url : 'admin_get_assign_transfer_for_sao',
            type : 'get',
            data :
                {
                    'listemails2': $('#ListOfAllUser2').val()
                },
            beforeSend: function () {
                $('#pops').html('<p style="color: yellow; font-size: 20px">LOADING...................</p>')
                $('#ApplyEmail').attr('disabled', 'disalbed');
                $('#btn_all_sao_assign_transfer_to_ao').attr('disabled', 'disalbed');
                $('#loads').removeAttr('hidden');
                $('#loaads').removeAttr('hidden');
            },
            success: function (data) {

                $('#pops').html('<p style="color: green; font-size: 20px">SUCCESS</p>')
                $('#ApplyEmail').attr('disabled', 'disalbed');
                $('#btn_all_sao_assign_transfer_to_ao').attr('disabled', 'disalbed');

            },
            error: function () {
                $('#pops').html('<p style="color: red; font-size: 20px">ERROR</p>')

                // console.log('error');
            },
            complete: function () {
                $('#pops').html('<p style="color: green; font-size: 20px">Done</p>')
                $('#ApplyEmail').removeAttr('disabled');
                $('#btn_all_sao_assign_transfer_to_ao').removeAttr('disabled');
                $('#loads').attr('hidden', 'hidden');
                $('#loadas').attr('hidden', 'hidden');

                //              getlist1();
                getlist2();
                // getlist3();
                // getlist4();
                // getlist5();
            }
        }
    );

});

//all ao for sao assign and transfer
$('#btn_all_ao_assign_transfer_to_ao').click(function () {


    $.ajax(
        {
            url : 'admin_get_assign_transfer_for_ao',
            type : 'get',
            data :
                {
                    'listemails2': $('#ListOfAllUser2').val()
                },
            beforeSend: function () {
                $('#pops').html('<p style="color: yellow; font-size: 20px">LOADING...................</p>')
                $('#ApplyEmail').attr('disabled', 'disalbed');
                $('#btn_all_ao_assign_transfer_to_ao').attr('disabled', 'disalbed');
                $('#loads').removeAttr('hidden');
                $('#loaads').removeAttr('hidden');
            },
            success: function (data) {

                $('#pops').html('<p style="color: green; font-size: 20px">SUCCESS</p>')
                $('#ApplyEmail').attr('disabled', 'disalbed');
                $('#btn_all_ao_assign_transfer_to_ao').attr('disabled', 'disalbed');

            },
            error: function () {
                $('#pops').html('<p style="color: red; font-size: 20px">ERROR</p>')

                // console.log('error');
            },
            complete: function () {
                $('#pops').html('<p style="color: green; font-size: 20px">Done</p>')
                $('#ApplyEmail').removeAttr('disabled');
                $('#btn_all_ao_assign_transfer_to_ao').removeAttr('disabled');
                $('#loads').attr('hidden', 'hidden');
                $('#loadas').attr('hidden', 'hidden');

                //              getlist1();
                getlist2();
                // getlist3();
                // getlist4();
                // getlist5();
            }
        }
    );

});

//btn_remove_all_sao_assign_transfer_to_ao
$('#btn_remove_all_sao_assign_transfer_to_ao').click(function () {



});

//btn_remove_all_ao_assign_transfer_to_ao
$('#btn_remove_all_ao_assign_transfer_to_ao').click(function () {



});

//btn_remove_all_assign_transfer
$('#btn_remove_all_assign_transfer').click(function () {

    $.ajax(
        {
            url : 'admin_remove_assign_transfer_all',
            type : 'get',
            data :
                {
                    'listemails2': $('#ListOfAllUser2').val()
                },
            beforeSend: function () {
                $('#pops').html('<p style="color: yellow; font-size: 20px">LOADING...................</p>')
                $('#ApplyEmail').attr('disabled', 'disalbed');
                $('#btn_remove_all_assign_transfer').attr('disabled', 'disalbed');
                $('#loads').removeAttr('hidden');
                $('#loaads').removeAttr('hidden');
            },
            success: function (data) {

                $('#pops').html('<p style="color: green; font-size: 20px">SUCCESS</p>')
                $('#ApplyEmail').attr('disabled', 'disalbed');
                $('#btn_remove_all_assign_transfer').attr('disabled', 'disalbed');

            },
            error: function () {
                $('#pops').html('<p style="color: red; font-size: 20px">ERROR</p>')

                // console.log('error');
            },
            complete: function () {
                $('#pops').html('<p style="color: green; font-size: 20px">Done</p>')
                $('#ApplyEmail').removeAttr('disabled');
                $('#btn_remove_all_assign_transfer').removeAttr('disabled');
                $('#loads').attr('hidden', 'hidden');
                $('#loadas').attr('hidden', 'hidden');

                // getlist1();
                getlist2();
                // getlist3();
                // getlist4();
                // getlist5();
            }
        }
    );

});

//DISPATCHER dispatch/transfer CI
//all dispatcher
$('#btn_all_dispatcher_dispatch_transfer').click(function () {

    $.ajax(
        {
            url : 'admin_get_dispatch_transfer_for_dispatcher',
            type : 'get',
            data :
                {
                    'listemails3': $('#ListOfAllUser3').val()
                },
            beforeSend: function () {
                $('#pops').html('<p style="color: yellow; font-size: 20px">LOADING...................</p>')
                $('#ApplyEmail').attr('disabled', 'disalbed');
                $('#btn_all_dispatcher_dispatch_transfer').attr('disabled', 'disalbed');
                $('#loads').removeAttr('hidden');
                $('#loaads').removeAttr('hidden');
            },
            success: function (data) {

                $('#pops').html('<p style="color: green; font-size: 20px">SUCCESS</p>')
                $('#ApplyEmail').attr('disabled', 'disalbed');
                $('#btn_all_dispatcher_dispatch_transfer').attr('disabled', 'disalbed');

            },
            error: function () {
                $('#pops').html('<p style="color: red; font-size: 20px">ERROR</p>')

                // console.log('error');
            },
            complete: function () {
                $('#pops').html('<p style="color: green; font-size: 20px">Done</p>')
                $('#ApplyEmail').removeAttr('disabled');
                $('#btn_all_dispatcher_dispatch_transfer').removeAttr('disabled');
                $('#loads').attr('hidden', 'hidden');
                $('#loadas').attr('hidden', 'hidden');

                //              getlist1();
                // getlist2();
                getlist3();
                // getlist4();
                // getlist5();
            }
        }
    );

});

//all ci
$('#btn_all_ci_dispatch_transfer').click(function () {

    $.ajax(
        {
            url : 'admin_get_dispatch_transfer_for_ci',
            type : 'get',
            data :
                {
                    'listemails3': $('#ListOfAllUser3').val()
                },
            beforeSend: function () {
                $('#pops').html('<p style="color: yellow; font-size: 20px">LOADING...................</p>')
                $('#ApplyEmail').attr('disabled', 'disalbed');
                $('#btn_all_ci_dispatch_transfer').attr('disabled', 'disalbed');
                $('#loads').removeAttr('hidden');
                $('#loaads').removeAttr('hidden');
            },
            success: function (data) {

                $('#pops').html('<p style="color: green; font-size: 20px">SUCCESS</p>')
                $('#ApplyEmail').attr('disabled', 'disalbed');
                $('#btn_all_ci_dispatch_transfer').attr('disabled', 'disalbed');

            },
            error: function () {
                $('#pops').html('<p style="color: red; font-size: 20px">ERROR</p>')

                // console.log('error');
            },
            complete: function () {
                $('#pops').html('<p style="color: green; font-size: 20px">Done</p>')
                $('#ApplyEmail').removeAttr('disabled');
                $('#btn_all_ci_dispatch_transfer').removeAttr('disabled');
                $('#loads').attr('hidden', 'hidden');
                $('#loadas').attr('hidden', 'hidden');

                //              getlist1();
                // getlist2();
                getlist3();
                // getlist4();
                // getlist5();
            }
        }
    );


});

//remove all
$('#btn_remove_all_dispatch_transfer').click(function () {

    $.ajax(
        {
            url : 'admin_remove_dispatcher_transfer_all',
            type : 'get',
            data :
                {
                    'listemails3': $('#ListOfAllUser3').val()
                },
            beforeSend: function () {
                $('#pops').html('<p style="color: yellow; font-size: 20px">LOADING...................</p>')
                $('#ApplyEmail').attr('disabled', 'disalbed');
                $('#btn_remove_all_dispatch_transfer').attr('disabled', 'disalbed');
                $('#loads').removeAttr('hidden');
                $('#loaads').removeAttr('hidden');
            },
            success: function (data) {

                $('#pops').html('<p style="color: green; font-size: 20px">SUCCESS</p>')
                $('#ApplyEmail').attr('disabled', 'disalbed');
                $('#btn_remove_all_dispatch_transfer').attr('disabled', 'disalbed');

            },
            error: function () {
                $('#pops').html('<p style="color: red; font-size: 20px">ERROR</p>')

                // console.log('error');
            },
            complete: function () {
                $('#pops').html('<p style="color: green; font-size: 20px">Done</p>')
                $('#ApplyEmail').removeAttr('disabled');
                $('#btn_remove_all_dispatch_transfer').removeAttr('disabled');
                $('#loads').attr('hidden', 'hidden');
                $('#loadas').attr('hidden', 'hidden');

                // getlist1();
                // getlist2();
                getlist3();
                // getlist4();
                // getlist5();
            }
        }
    );

});

$('#btnLeftDownWeb').click(function () {
    $('#btnDisWeb').hide();
    $('#btnEnaWeb').hide();

    $.ajax
    ({
        method: 'get',
        url: 'admin-get-web-status',
        success: function (data) {
            // console.log(data);
            if (data == 1) {
                $('#btnDisWeb').show();
            }
            else {
                $('#btnEnaWeb').show();
            }
        }
    });
});


$('#btnDisWeb').click(function () {
    $.ajax
    ({
        method: 'get',
        url: 'admin-down-web',
        data:
            {
                'tag': 'disable'
            },
        success: function (data) {
            alert("Successfully Activated");
            $('#btnDisWeb').hide();
            $('#btnEnaWeb').hide();
        }
    });
});

$('#btnEnaWeb').click(function () {
    $.ajax
    ({
        method: 'get',
        url: 'admin-down-web',
        data:
            {
                'tag': 'enable'
            },
        success: function (data) {
            alert("Successfully Deactivated");
            $('#btnDisWeb').hide();
            $('#btnEnaWeb').hide();
        }
    });
});

$('#table-blocked-accounts').on('click','#btnUnblockAcct', function ()
{
    var blckID = $(this).attr('href');
    $.ajax
    ({
        type: 'post',
        url: 'admin-delete-blocked-acct',
        data:
            {
                'blckID': blckID
            },
        success: function (data)
        {
            alert('Successfully Unblocked!');
            tableBlockedUsers.ajax.reload(null, false);
        }
    })
});
var checking_counter_add_button = 0;
var other_checking_counter_add_button = 0;
$('.btn_add_package').click(function () {

    $('#table_bi_package thead#package_head').append(

        '                                                                                    <tr id="row'+checking_counter_add_button+'">\n' +
        '                                                                                        <th>' +
        '                                                                                               <input type="text" class="get_package_class form-control" name="'+checking_counter_add_button+'" id="package_input-'+checking_counter_add_button+'" placeholder="Enter name of package">\n' +
        '                                                                                            <table class="table-condensed table-hover" id="table_checking-'+checking_counter_add_button+'" width="100%">\n' +
        '                                                                                                <thead id="checking_head-'+checking_counter_add_button+'">\n' +
        '                                                                                                    <tr>\n' +
        '                                                                                                        <th>Check Name</th>\n' +
        '                                                                                                        <th>Information</th>\n' +
        '                                                                                                        <th>Ocular</th>\n' +
        '                                                                                                        <th><button type = "button" id="btn_add_checking-'+checking_counter_add_button+'" name="'+checking_counter_add_button+'" class = "btn-success btn-sm form-control"><i class = "fa fa-fw fa-plus"></i></button></th>\n' +
        '                                                                                                    </tr>\n' +
        '                                                                                                </thead>\n' +
        '                                                                                            </table>\n' +
        '                                                                                        </th>\n' +
        '                                                                                        <th><button type = "button" id="'+checking_counter_add_button+'"  class = "btnRemoveItem btn btn-danger btn-sm form-control"><i class = "fa fa-fw fa-remove"></i></button></th>\n' +
        '                                                                                    </tr>'

    );

    var counter_check = 0;

    $('#btn_add_checking-'+checking_counter_add_button+'').click(function () {

        // console.log('yow nagana ako yow');

        var count = $(this).attr('name');

        $('#table_checking-'+count+' thead#checking_head-'+count+'').append(
            '                                                                                                    <tr id="row_checking'+count+'-'+counter_check+'">\n' +
            '                                                                                                        <th><input type="text" class="get_checking_class-'+count+' form-control" id="checking_input-'+count+'-'+counter_check+'" name="'+count+'-'+counter_check+'" placeholder="Enter name of checking"></th>\n' +
            '                                                                                                        <th><input type="text" class="get_checking_information_class-'+count+' form-control" id="checking_information_input-'+count+'-'+counter_check+'" name="'+count+'-'+counter_check+'" placeholder="Enter the information of check"></th>\n' +
            '                                                                                                        <th><input type="checkbox" class="get_checking_ocular_class-'+count+'" id="checking_ocular_input-'+count+'-'+counter_check+'" name="'+count+'-'+counter_check+'"></th>\n' +
            '                                                                                                        <th><button id="'+count+'-'+counter_check+'" type = "button" class = "btnRemoveItem_checking btn btn-danger btn-sm form-control"><i class = "fa fa-fw fa-remove"></i></button></th>\n' +
            '                                                                                                    </tr> '
        );
        counter_check++;
    });
    checking_counter_add_button++;
});

$('.btn_add_other_checking').click(function () {

    $('#table_bi_other_checking thead#other_checking_head').append(

        '                                                                                    <tr id="row_other_check'+other_checking_counter_add_button+'">\n' +
        '                                                                                           <th><input type="text" class="get_other_checking_class form-control" name="'+other_checking_counter_add_button+'" id="checking_input-'+other_checking_counter_add_button+'" placeholder="Enter name of Checking"></th>\n' +
        '                                                                                           <th><input type="text" class="get_other_checking_information_class form-control" id="checking_information_input-'+other_checking_counter_add_button+'" placeholder="Enter the information of check"></th>\n' +
        '                                                                                           <th><input type="checkbox" class="get_other_checking_ocular_class" id="checking_ocular_input-'+other_checking_counter_add_button+'"></th>\n' +
        '                                                                                        <th><button type = "button" name="'+other_checking_counter_add_button+'" class = "btnRemoveItem_other_check btn btn-danger btn-sm form-control"><i class = "fa fa-fw fa-remove"></i></button></th>\n' +
        '                                                                                    </tr>'

    );

    other_checking_counter_add_button++;
});

$(document).on('click', '.btnRemoveItem', function()
{
    var button_id = $(this).attr("id");
    $('#row'+button_id+'').remove();

});

$(document).on('click', '.upon_endorsementRemove', function()
{
    var button_id = $(this).attr("href");
    uponEndClick = uponEndClick -1;
    $('#row'+button_id+'').remove();

});

$(document).on('click', '.btn_removeEditUpon', function()
{
    var button_id = $(this).attr("id");
    $('#row'+button_id+'').remove();

});

$(document).on('click', '.btn_removeEditDuring', function()
{
    var button_id = $(this).attr("id");
    $('#row1'+button_id+'').remove();

});

$(document).on('click', '.btn_removeEditAfter', function()
{
    var button_id = $(this).attr("id");
    $('#row2'+button_id+'').remove();

});

$(document).on('click', '.during_endorsementRemove', function()
{
    var button_id = $(this).attr("href");
    duringEndClick = duringEndClick -1;
    $('#row'+button_id+'').remove();

});

$(document).on('click', '.after_endorsementRemove', function()
{
    var button_id = $(this).attr("href");
    afterEndClick = afterEndClick -1;
    $('#row'+button_id+'').remove();

});

$(document).on('click', '.btnRemoveItem_checking', function()
{
    var button_id = $(this).attr("id");
    $('#row_checking'+button_id+'').remove();

});

$(document).on('click', '.btnRemoveItem_other_check', function()
{
    var button_id = $(this).attr("name");
    $('#row_other_check'+button_id+'').remove();

});

$('#btn_submit_bi_account').click(function () {
    var i = 0;
    var o = 0;
    var oo = 0;
    var ooo = 0;
    var dual_array = [[]];
    var dual_array_check_info = [[]];
    var dual_array_check_ocular = [[]];

    var other_checking_array = [];
    var other_checking_info_array = [];
    var other_checking_ocular_array = [];

    var account_name = $('#bi_account_name').val();
    var account_location = $('#bi_location').val();


    $('.get_package_class').each(function ()
    {
        console.log(i+'. '+$(this).val());
        var get_count = $(this).attr('name');
        var ii = 1;
        var iii = 1;
        var iiii = 1;

        dual_array[i][0] = $(this).val();
        dual_array_check_info[i][0] = '';
        dual_array_check_ocular[i][0] = '';

        $('.get_checking_class-'+get_count+'').each(function ()
        {
            console.log(i+'-'+ii+'. '+$(this).val());
            dual_array[i][ii] = $(this).val();
            ii++;
        });

        $('.get_checking_information_class-'+get_count+'').each(function ()
        {
            console.log(i+'-'+iii+'. '+$(this).val());
            dual_array_check_info[i][iii] = $(this).val();
            iii++;
        });

        $('.get_checking_ocular_class-'+get_count+'').each(function ()
        {
            if($(this).is(":checked"))
            {
                dual_array_check_ocular[i][iiii] = 'true';
                console.log(i+'-'+iiii+'. '+'true');
            }
            else
            {
                dual_array_check_ocular[i][iiii] = 'false';
                console.log(i+'-'+iiii+'. '+'false');
            }

            iiii++;
        });


        i++;


        dual_array[i] = [];
        dual_array_check_info[i] = [];
        dual_array_check_ocular[i] = [];
    });


    $('.get_other_checking_class').each(function () {

        other_checking_array[o] = $(this).val();
        o++;
    });

    $('.get_other_checking_information_class ').each(function () {

        other_checking_info_array[oo] = $(this).val();
        oo++;
    });

    $('.get_other_checking_ocular_class ').each(function () {

        if($(this).is(":checked"))
        {
            other_checking_ocular_array[ooo] = 'true';
        }
        else
        {
            other_checking_ocular_array[ooo] = 'false';
        }
        ooo++;
    });


    var sliced_dual_array_check = dual_array.slice(0, -1);
    var sliced_dual_array_info = dual_array_check_info.slice(0, -1);
    var sliced_dual_array_ocular = dual_array_check_ocular.slice(0, -1);
    console.log(sliced_dual_array_check);
    console.log(sliced_dual_array_info);
    console.log(sliced_dual_array_ocular);
    console.log('other---------------');
    console.log(other_checking_array);
    console.log(other_checking_info_array);
    console.log(other_checking_ocular_array);


    $.ajax({

        url : 'admin_register_bi_account',
        type : 'post',
        data : {
            'account_name' : account_name,
            'account_location' : account_location,
            'packages_checkings' : sliced_dual_array_check,
            'packages_checkings_info' : sliced_dual_array_info,
            'packages_checkings_ocular' : sliced_dual_array_ocular,
            'other_checking' : other_checking_array,
            'other_checking_info' : other_checking_info_array,
            'other_checking_ocular' : other_checking_ocular_array,
            'what_to_do' : bi_what_to,
            'global_bi_id' : global_bi_id
        },
        success : function (data) {

            if(data == 'same')
            {
                alert('Duplicate name and address.');
            }
            else
            {
                if(data == 'a')
                {
                    alert('success');
                    checking_counter_add_button = 0;
                    $('.btnRemoveItem').each(function () {
                        $(this).click();
                    });
                    $('.btnRemoveItem_other_check').each(function () {
                        $(this).click();
                    });
                    $('#modal_add_bi_account').modal('hide');
                }
                else if (data == 'b')
                {
                    alert('success editing');
                    checking_counter_add_button = 0;
                    $('.btnRemoveItem').each(function () {
                        $(this).click();
                    });
                    $('.btnRemoveItem_other_check').each(function () {
                        $(this).click();
                    });
                    $('#modal_add_bi_account').modal('hide');
                }
            }
            console.log(data);

        },
        error: function () {
            console.log('error');
        }

    });
});

$('#usertableManage').on('click','#btn_client_perm',function () {

    user_id_click_for_bi = $(this).attr('name');
    console.log(user_id_click_for_bi);
});

$('#btn_submit_bi_select').click(function () {


    $.ajax({

        url : 'admin_select_bi_to_user',
        type : 'post',
        data : {
            'user_id' : user_id_click_for_bi,
            'bi_id' : $('#selected_bi').val()
        },
        success : function (data) {
            alert('success');

            $('#modal_select_bi_account').modal('hide');
        },
        error : function () {
            alert('something wrong');
            // $('#modal_select_bi_account').modal('hide');
        }


    })
});

$('#selected_bi').change(function()
{
    $('#bi_name').text('test');
    $('#bi_location').text('try');
})


$('#radio_bi_edit').click(function () {

    console.log('radio button is click');
    bi_what_to = 'edit';
    $('#select_bi_row').show();

    $('#bi_account_name').attr('disabled','disabled');
    $('#bi_location').attr('disabled','disabled');

    $.ajax({

        url : 'admin_edit_get_select_bi_account',
        type : 'get',
        success : function (data) {

            var get_select = '';

            for (var ctr = 0; ctr<data.length; ctr++)
            {
                get_select += '<option value="'+data[ctr].id+'">'+data[ctr].bi_account_name+' : '+data[ctr].account_location+'</option>';
            }

            $('#select_edit_bi_account').html('<select class="form-control" id="select_bi">' +
                get_select+
                '</select>');

            select_bi_func();

        },
        error : function () {
            console.log('error');
        }

    });
});

$('#radio_bi_add').click(function () {

    $('#bi_account_name').removeAttr('disabled');
    $('#bi_location').removeAttr('disabled');


    bi_what_to ='add';

    $('#select_bi_row').hide();
    checking_counter_add_button = 0;
    $('.btnRemoveItem').each(function () {
        $(this).click();
    });
});

function select_bi_func() {

    $('#select_bi').change(function () {

        var bi_id = $(this).val();

        checking_counter_add_button = 0;
        other_checking_counter_add_button = 0;
        $('.btnRemoveItem_other_check').each(function () {
            $(this).click();
        });

        $('.btnRemoveItem').each(function () {
            $(this).click();
        });

        global_bi_id = bi_id;
        $.ajax({

            url : 'admin_select_bi_change',
            type : 'get',
            data : {
                'bi_id' : bi_id
            },
            success : function (data) {
                console.log(data);

                $('#bi_account_name').val(data[1][0].bi_name);
                $('#bi_location').val(data[1][0].location);


                for(var ctr = 0; ctr<data[0].length; ctr++)
                {
                    $('.btn_add_package').click();
                    $('#package_input-'+ctr+'').val(data[0][ctr].package);
                    var ii = 0;
                    for(var i = 0; i<data[1].length; i++)
                    {
                        if(data[0][ctr].id == data[1][i].package_id)
                        {
                            $('#btn_add_checking-'+ctr+'').click();
                            console.log(ctr+'-'+ii+' : '+data[1][i].checking);
                            $('#checking_input-'+ctr+'-'+ii+'').val(data[1][i].checking);
                            $('#checking_information_input-'+ctr+'-'+ii+'').val(data[1][i].information);

                            if(data[1][i].ocular == 'true')
                            {
                                $('#checking_ocular_input-'+ctr+'-'+ii+'').prop('checked',true);
                            }
                            else
                            {
                                $('#checking_ocular_input-'+ctr+'-'+ii+'').prop('checked',false);
                            }
                            // $('#checking_input-'+ctr+'-'+ii+'').attr('name');
                            ii++;
                        }
                    }
                }

                if(data[2] != 'none')
                {
                    for(var ctrr = 0; ctrr<data[2].length; ctrr++)
                    {
                        $('.btn_add_other_checking').click();
                        $('#checking_input-'+ctrr+'').val(data[2][ctrr].other_check);

                        $('#checking_information_input-'+ctrr+'').val(data[2][ctrr].information);

                        if(data[2][ctrr].ocular == 'true')
                        {
                            $('#checking_ocular_input-'+ctrr+'').prop('checked',true);
                        }
                        else
                        {
                            $('#checking_ocular_input-'+ctrr+'').prop('checked',false);
                        }
                    }
                }

            },
            error : function () {
                console.log('error');
            }


        });

    });

}

$('#btn_check_bday_comtract').click(function () {

    var today = new Date();
    var dateToday = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();

    $.ajax({
        url: 'admin_bday_and_contract_validate',
        type: 'get',
        data: {
            'date_updated': dateToday
        },
        success: function(data){
            if(data[0] == 'true')
            {
                check_contracts();
            }
            else
            {
                console.log('Check Client Contract Updated!')
            }
            if(data[1] == 'true')
            {
                check_birthdays();
            }
            else
            {
                console.log('Check Client Birthday Updated!')
            }
        },
        error: function(){
            console.log('Already Updated this day!')
        }
    });


});

function check_birthdays() {

    var id = [];
    var client_name = [];
    var birthdate = [];
    var contact_num = [];
    var email_add = [];
    var client_position = [];
    var gift_type = [];
    var bank_name = [];
    var days_remaining = [];
    var count_them = 0;
    var birthday_data_to_table ='';

    $.ajax({
        url: 'admin_check_bday_notification_email',
        type: 'post',
        success: function (data) {

            for(var ctr = 0; ctr<data.length; ctr++)
            {
                var check_bday_notif ='';

                var countDownDate = new Date(data[ctr].birthdate);

                var monthNames = ["Jan", "Feb", "Mar", "Apr", "May","Jun","Jul", "Aug", "Sep", "Oct", "Nov","Dec"];
                const second = 1000,
                    minute = second * 60,
                    hour = minute * 60,
                    day = hour * 24;
                var countDown = new Date(monthNames[countDownDate.getMonth()]+' '+countDownDate.getDate()+', '+new Date().getFullYear());
                var now = new Date();
                var distance = countDown - now;
                var diffDays1 = Math.floor(distance / (day));

                if ((diffDays1+1) >= 0 && (diffDays1+1) <= 7)
                {
                    console.log('less than 7 days');
                    days_remaining[count_them] = (diffDays1+1);
                    console.log(data[ctr].client_name);
                    client_name[count_them] = data[ctr].client_name;
                    birthdate[count_them] = data[ctr].birthdate;
                    contact_num[count_them] = data[ctr].contact_num;
                    email_add[count_them] = data[ctr].email_add;
                    client_position[count_them] = data[ctr].client_position;
                    gift_type[count_them] = data[ctr].gift_type;
                    bank_name[count_them] = data[ctr].bank_name;
                    id[count_them] = data[ctr].id;
                    count_them++;


                    birthday_data_to_table += '<tr>\n' +
                        '                                <td>'+data[ctr].client_name+'</td>\n' +
                        '                                <td>'+data[ctr].birthdate+'</td>\n' +
                        '                                <td>'+data[ctr].contact_num+'</td>\n' +
                        '                                <td>'+data[ctr].email_add+'</td>\n' +
                        '                                <td>'+data[ctr].client_position+'</td>\n' +
                        '                                <td>'+data[ctr].gift_type+'</td>\n' +
                        '                                <td>'+data[ctr].bank_name+'</td>\n' +
                        '                                <td>'+diffDays1+'</td>\n' +
                        '                            </tr>';

                }
                $('#bday_notif_table').html('<tr>\n' +
                    '                                <th>Client Name</th>\n' +
                    '                                <th>Birthday</th>\n' +
                    '                                <th>Contact Number</th>\n' +
                    '                                <th>Email Address</th>\n' +
                    '                                <th>Client Position</th>\n' +
                    '                                <th>Gift Type</th>\n' +
                    '                                <th>Bank Name</th>\n' +
                    '                                <th>Days Remaining</th>\n' +
                    '                            </tr>' + birthday_data_to_table
                );

            }

            if(count_them > 0)
            {
                $.ajax
                ({

                    url: 'admin_bday_send_email_notif',
                    type: 'get',
                    data: {
                        'id' : id,
                        'client_name' : client_name,
                        'birthdate' : birthdate,
                        'days_remaining' : days_remaining,
                        'contact_num' : contact_num,
                        'email_add' : email_add,
                        'client_position' : client_position,
                        'gift_type' : gift_type,
                        'bank_name' : bank_name,
                        'count_them' : count_them
                    },
                    success: function (data) {

                        console.log(data);

                        // if(data == 'success')
                        // {
                        //     $('#span_check_bday_contract').html('');
                        //
                        //     console.log('dodong is pogi success yow');
                        // }
                    },
                    error: function () {
                        console.log('error something went wrong');
                    }

                });
            }

        },
        error: function () {
            console.log('error email notification')
        }

    });
}

function check_contracts() {

    var id = [];
    var client_name = [];
    var start_date = [];
    var end_date = [];
    var contract_desc = [];
    var contract_remarks = [];
    var days_remaining = [];
    var count_ea = 0;
    var contract_data_to_table = '';
    $.ajax({
        url: 'admin_check_contract_notification_email',
        type: 'post',
        success: function (data)
        {

            for(var ctr = 0; ctr<data.length; ctr++)
            {


                var countDownDate = new Date(data[ctr].end_date);
                var monthNames = ["Jan", "Feb", "Mar", "Apr", "May","Jun","Jul", "Aug", "Sep", "Oct", "Nov","Dec"];
                const second = 1000,
                    minute = second * 60,
                    hour = minute * 60,
                    day = hour * 24;
                var countDown = new Date(monthNames[countDownDate.getMonth()]+' '+countDownDate.getDate()+', '+new Date().getFullYear());
                var now = new Date();
                var distance = countDown - now;
                var diffDays1 = Math.floor(distance / (day));

                if ((diffDays1+1) >= 0 && (diffDays1+1) <= 62)
                {
                    console.log('less than 2 months');
                    days_remaining[count_ea] = (diffDays1+1);
                    console.log(data[ctr].client_name);
                    client_name[count_ea] = data[ctr].client_name;
                    start_date[count_ea] = data[ctr].start_date;
                    end_date[count_ea] = data[ctr].end_date;
                    contract_desc[count_ea] = data[ctr].contract_desc;
                    contract_remarks[count_ea] = data[ctr].contract_remarks;
                    id[count_ea] = data[ctr].id;
                    count_ea++;

                    contract_data_to_table += '<tr>\n' +
                        '                                <th>'+data[ctr].client_name+'</th>\n' +
                        '                                <th>'+data[ctr].start_date+'</th>\n' +
                        '                                <th>'+data[ctr].end_date+'</th>\n' +
                        '                                <th>'+data[ctr].contract_desc+'</th>\n' +
                        '                                <th>'+data[ctr].contract_remarks+'</th>\n' +
                        '                                <th>'+diffDays1+'</th>\n' +
                        '                            </tr>';
                }
                $('#contract_notif_table').html('<tr>\n' +
                    '                                <th>Client Name</th>\n' +
                    '                                <th>Start Date</th>\n' +
                    '                                <th>End Date</th>\n' +
                    '                                <th>Contact Description</th>\n' +
                    '                                <th>Contact Remarks</th>\n' +
                    '                                <th>Days Remaining</th>\n' +
                    '                            </tr>'+ contract_data_to_table
                );
            }



            if(count_ea > 0){


                $.ajax({

                    url: 'admin_contract_send_email_notif',
                    type: 'get',
                    data: {
                        'id' : id,
                        'days_remaining': days_remaining,
                        'client_name' : client_name,
                        'start_date' : start_date,
                        'end_date' : end_date,
                        'contract_desc' : contract_desc,
                        'contract_remarks' : contract_remarks,
                        'count_ea' : count_ea
                    },
                    success: function (data) {

                        console.log(data);

                    },
                    error: function () {
                        console.log('error something went wrong');
                    }

                });
            }
        },
        error: function () {
            console.log('error email notification')
        }

    });

}

$('#bi_selection').change(function()
{
    var testing101 = $(this).find(':selected').attr('id');
    var testing102 = $(this).find(':selected').attr('name');

    $('#bi_loca_check').val(testing101);
    $('#bi_name_check').val(testing102);

});

// var countClickCheck = 0;
// $('#dup_checks').click(function(e)
// {
//     countClickCheck++;
//     e.preventDefault();
//
//     var addCheckClick = '<div class="row">\n' +
//         '   <div class="form-group col-md-12">\n' +
//         '       <input type="text" name="'+countClickCheck+'" class="col-md-10 addChecktxt" placeholder="Add Check">\n' +
//         '       <button class="col-md-2 btn btn-sm btn-danger pull-right" id="removeAdd-'+countClickCheck+'"><i class="glyphicon glyphicon-remove"></i></button>\n' +
//         '   </div>\n' +
//         '</div>';
//
//     $('#testing').append(addCheckClick);
//
//     $('#removeAdd-'+countClickCheck+'').click(function(e)
//     {
//         e.preventDefault();
//         $(this).parent('div').remove();
//     });
// });
//
// $('#addCheckBtn').click(function()
// {
//     var myData = [];
//     var checkNameCheck= '';
//     var ctr = 0;
//     var checkssss = '';
//     var bi_id_selected = $('#bi_selection').val();
//
//     $('.addChecktxt').each( function()
//     {
//         checkNameCheck = $(this).val();
//         var countable = $(this).attr('name');
//
//         myData[ctr] = checkNameCheck;
//         ctr++;
//     });
//     console.log(myData);
//
//     $.ajax
//     ({
//         type: 'post',
//         url: 'admin-get-check-bi',
//         data:
//             {
//                 myData : myData
//             },
//         success: function(data)
//         {
//             console.log('Successfully Added!');
//         }
//     })
// });
//
//
// function func_load_checkingData()
// {
//     $.ajax
//     (
//         {
//             type: 'get',
//             url: 'admin-get-checkings-data',
//             success: function(data)
//             {
//
//             }
//         }
//     );
// }


var uponEndClick = 0;
$('#upon_addToList').click(function(e)
{
    uponEndClick++;
    e.preventDefault();

    var  uponEndTr = '' +
        '<tr id="row'+uponEndClick+'">\n' +
        '    <td><input type="text" class="form-control upon_endorsement" placeholder="Enter name of Attachment/Docs." id="uponEndCheckItem-'+uponEndClick+'" href="'+uponEndClick+'"></td>\n' +
        '    <td colspan="2"><button class="form-control btn btn-sm btn-danger upon_endorsementRemove" id="upon_removeToList-'+uponEndClick+'" href="'+uponEndClick+'"><i class="glyphicon glyphicon-remove"></i></button></td>\n' +
        '</tr>';

    $('#upon_endorsementtbl').append(uponEndTr);
});

$('#btnUponEnd').click(function()
{
    var index = 0;
    var my_array =[];
    var itemToInsert = '';

    $('.upon_endorsement').each(function()
    {
        itemToInsert = $(this).val();

        my_array[index] = itemToInsert;
        index++;
    });
    // console.log(my_array);

    $.ajax
    (
        {
            type: 'post',
            url: 'admin-add-upon-checkings',
            data: {
                my_array : my_array
            },
            success: function(data)
            {
                if(data == 'ok')
                {
                    alert('Check Added');
                }
                else
                {
                    alert('error');
                }
            }
        }
    );
});


var duringEndClick = 0;
$('#during_addToList').click(function(e)
{
    duringEndClick++;
    e.preventDefault();

    var duringEndTr = '' +
        '<tr id="row'+duringEndClick+'">\n' +
        '    <td><input type="text" class="form-control during_endorsement" placeholder="Enter name of Attachment/Docs." id="duringEndCheckItem-'+duringEndClick+'" href="'+duringEndClick+'"></td>\n' +
        '    <td colspan="2"><button class="form-control btn btn-sm btn-danger during_endorsementRemove" id="during_removeToList-'+duringEndClick+'" href="'+duringEndClick+'"><i class="glyphicon glyphicon-remove"></i></button></td>\n' +
        '</tr>';

    $('#during_endorsementtbl').append(duringEndTr);
});

$('#btnDurEnd').click(function()
{
    var index = 0;
    var my_array =[];
    var itemToInsert = '';

    $('.during_endorsement').each(function()
    {
        itemToInsert = $(this).val();

        my_array[index] = itemToInsert;
        index++;
    });

    $.ajax
    (
        {
            type: 'post',
            url: 'admin-add-during-checkings',
            data: {
                my_array : my_array
            },
            success: function(data)
            {
                if(data == 'ok')
                {
                    alert('Check Added');
                }
                else
                {
                    alert('error');
                }
            }
        }
    );
});

var afterEndClick = 0;
$('#after_addToList').click(function(e)
{
    afterEndClick++;
    e.preventDefault();

    var afterEndTr = '' +
        '<tr id="row'+afterEndClick+'">\n' +
        '    <td><input type="text" class="form-control after_endorsement" placeholder="Enter name of Attachment/Docs." id="afterEndCheckItem-'+afterEndClick+'" href="'+afterEndClick+'"></td>\n' +
        '    <td colspan="2"><button class="form-control btn btn-sm btn-danger after_endorsementRemove" id="after_removeToList-'+afterEndClick+'" href="'+afterEndClick+'"><i class="glyphicon glyphicon-remove"></i></button></td>\n' +
        '</tr>';

    $('#after_endorsementtbl').append(afterEndTr);
});

$('#btnAfterEnd').click(function()
{
    var index = 0;
    var my_array =[];
    var itemToInsert = '';

    $('.after_endorsement').each(function()
    {
        itemToInsert = $(this).val();

        my_array[index] = itemToInsert;
        index++ ;
    });

    $.ajax
    (
        {
            type: 'post',
            url: 'admin-add-after-checkings',
            data: {
                my_array : my_array
            },
            success: function(data)
            {
                if(data == 'ok')
                {
                    alert('Check Added');
                }
                else
                {
                    alert('error');
                }
            }
        }
    );
});


getAllChecks();
function getAllChecks()
{
    $.ajax
    (
        {
            type: 'get',
            url: 'admin-get-all-upon-checks',
            success: function(data)
            {
                var tablerows = '';
                for(var i = 0; i < data.length; i++)
                {
                    tablerows += '<tr id="row'+i+'"><td><input type="text" name="" id="'+data[i].id+'" value=" '+data[i].check_name+'" class="upon_endorsement_edit_text form-control"></td>\n' +
                        '<td colspan="1"><button class="form-control btn btn-sm btn-danger btn_removeEditUpon" id="'+i+'"><i class="fa fa-fw fa-remove"></i></button></td></tr>';
                }

                $('#upon_endorsementtbl_edit').html('' +
                    '<table class="table-condensed" id="upon_endorsementtbl_edit" width="100%" style="font-weight: bold;">\n' +
                    '      <tr>\n' +
                    '         <td>Document/ Attachment</td>\n' +
                    '         <td colspan="1">Action</td>\n' +
                    '      </tr>\n' +
                    ''+tablerows+'' +
                    '</table>');
            }
        }
    );

    $.ajax
    (
        {
            type: 'get',
            url: 'admin-get-all-during-checks',
            success: function(data)
            {
                var tablerows = '';
                for(var i = 0; i < data.length; i++)
                {
                    tablerows += '<tr id="row1'+i+'"><td><input type="text" name="" id="'+data[i].id+'" value=" '+data[i].check_name+'" class="during_endorsement_edit_text form-control"></td>\n' +
                        '<td colspan="1"><button class="form-control btn btn-sm btn-danger btn_removeEditDuring" id="'+i+'"><i class="fa fa-fw fa-remove"></i></button></td></tr>';
                }

                $('#during_endorsementtbl_edit').html('' +
                    '<table class="table-condensed" id="during_endorsementtbl_edit" width="100%" style="font-weight: bold;">\n' +
                    '      <tr>\n' +
                    '         <td>Document/ Attachment</td>\n' +
                    '         <td colspan="1">Action</td>\n' +
                    '      </tr>\n' +
                    ''+tablerows+'' +
                    '</table>');
            }
        }
    );

    $.ajax
    (
        {
            type: 'get',
            url: 'admin-get-all-after-checks',
            success: function(data)
            {
                var tablerows = '';
                for(var i = 0; i < data.length; i++)
                {
                    tablerows += '<tr id="row2'+i+'"><td><input type="text" name="" id="'+data[i].id+'" value=" '+data[i].check_name+'" class="after_endorsement_edit_text form-control"></td>\n' +
                        '<td colspan="1"><button class="form-control btn btn-sm btn-danger btn_removeEditAfter" id="'+i+'"><i class="fa fa-fw fa-remove"></i></button></td></tr>';
                }

                $('#after_endorsementtbl_edit').html('' +
                    '<table class="table-condensed" id="after_endorsementtbl_edit" width="100%" style="font-weight: bold;">\n' +
                    '      <tr>\n' +
                    '         <td>Document/ Attachment</td>\n' +
                    '         <td colspan="1">Action</td>\n' +
                    '      </tr>\n' +
                    ''+tablerows+'' +
                    '</table>');
            }
        }
    );

}

$('#btnUponEndEdit').click(function()
{
    var index = 0;
    var edit_array = [];
    var editItem = '';

    $('.upon_endorsement_edit_text ').each(function()
    {
        editItem = $(this).val();

        edit_array[index] = editItem;
        index++;
    });
    // console.log(edit_array);

    $.ajax
    (
        {
            type: 'post',
            url: 'admin-edit-upon-checkings',
            data: {
                edit_array : edit_array
            },
            success: function(data)
            {
                if(data == 'ok')
                {
                    alert('Checking List Successfully Updated!');
                    getAllChecks();
                }
                else if(data == 'error')
                {
                    alert('Please fill all fields!');
                }
            }
        }
    );
});

$('#btnUponEndDuring').click(function()
{
    var index = 0;
    var edit_array = [];
    var editItem = '';

    $('.during_endorsementtbl_edit ').each(function()
    {
        editItem = $(this).val();

        edit_array[index] = editItem;
        index++;
    });
    // console.log(edit_array);

    $.ajax
    (
        {
            type: 'post',
            url: 'admin-edit-during-checkings',
            data: {
                edit_array : edit_array
            },
            success: function(data)
            {
                if(data == 'ok')
                {
                    alert('Checking List Successfully Updated!');
                    getAllChecks();
                }
                else if(data == 'error')
                {
                    alert('Please fill all fields!');
                }
            }
        }
    );
});

$('#btnUponEndAfter').click(function()
{
    var index = 0;
    var edit_array = [];
    var editItem = '';

    $('.after_endorsement_edit_text ').each(function()
    {
        editItem = $(this).val();

        edit_array[index] = editItem;
        index++;
    });
    // console.log(edit_array);

    $.ajax
    (
        {
            type: 'post',
            url: 'admin-edit-after-checkings',
            data: {
                edit_array : edit_array
            },
            success: function(data)
            {
                if(data == 'ok')
                {
                    alert('Checking List Successfully Updated!');
                    getAllChecks();
                }
                else if(data == 'error')
                {
                    alert('Please fill all fields!');
                }
            }
        }
    );
});

$('#moda_click_login_access').on('click',function () {

    console.log('click access');

    if(!ip_already)
    {
        ip_address_login_table();
        ip_already = true;
    }
    else
    {
        ip_address_login_table_data.ajax.reload(null,false)
    }

    if(!user_access)
    {
        user_access_login_table();
        user_access = true;
    }
    else
    {
        user_access_login_table_data.ajax.reload(null,false)
    }



});

function ip_address_login_table() {

    ip_address_login_table_data = $('#ip_address_login_table_data').DataTable
    ({
        "responsive": true,
        "processing": true,
        "serverSide": true,
        "ajax" : 'get_ip_address_data_table',
        "columns":
            [
                {data: 'id', name: 'ip_login_access.id'},
                {data: 'ip', name: 'ip_login_access.ip'},
                {data: 'office_branch', name: 'ip_login_access.office_branch'},
                {data: 'accessibility', name: 'ip_login_access.accessibility'},
                {
                    data : function action(data)
                    {
                        var to_return = '';

                        if(data.accessibility != 'grant')
                        {
                            to_return = '<a class="btn btn-xs btn-success btn-block" name="'+data.id+'" id="grant_ip_address">Grant</a>' +
                                '<a class="btn btn-xs btn-warning btn-block" name="'+data.id+'" id="delete_ip_address">Delete</a>';
                        }
                        else
                        {
                            to_return = '<a class="btn btn-xs btn-danger btn-block" name="'+data.id+'" id="deny_ip_address">Deny</a>'+
                                '<a class="btn btn-xs btn-warning btn-block" name="'+data.id+'" id="delete_ip_address">Delete</a>';
                        }

                        return to_return;
                    },
                    'name' : 'action',
                    'searchable' : false,
                    'orderable' : false
                }
            ],
        "order": [[0, 'desc']],
        "pageLength": -1,
        "lengthMenu": [[2, 10, 25, 50, -1], ['2 rows', '10 rows', '25 rows', '50 rows', 'Show all']],
        "bSortClasses": false,
        "deferRender": true,
        initComplete: function()
        {
            var api = this.api();

            // Apply the search
            api.columns().every(function() {
                var that = this;

                $('input', this.header()).on('keyup change', function(e)
                {
                    if($(this).is(':focus'))
                    {
                        if(e.keyCode === 13)
                        {
                            if (that.search() !== this.value) {
                                that
                                    .search(this.value)
                                    .draw();
                            }
                        }
                        else if (e.keyCode === 8)
                        {
                            if (this.value == '') {
                                that
                                    .search(this.value)
                                    .draw();
                            }
                        }
                    }
                });
            });
        }
    });
}

function user_access_login_table() {

    user_access_login_table_data = $('#user_access_login_table_data').DataTable
    ({
        "responsive": true,
        "processing": true,
        "serverSide": true,
        "ajax" : 'get_user_access_login_data_table',
        "columns":
            [
                {data: 'id', name: 'roles.id'},
                {data: 'name', name: 'roles.name'},
                {data: 'login_access', name: 'roles.login_access'},
                {
                    data : function action(data)
                    {
                        if(data.login_access != 'grant')
                        {
                            return '<a class="btn btn-xs btn-success btn-block" name="'+data.id+'" id="grant_user_access">Grant</a>';
                        }
                        else
                        {
                            return '<a class="btn btn-xs btn-danger btn-block" name="'+data.id+'" id="deny_user_access">Deny</a>';
                        }
                    },
                    'name' : 'action',
                    'searchable' : false,
                    'orderable' : false
                }
            ],
        "order": [[0, 'desc']],
        "pageLength": -1,
        "lengthMenu": [[2, 10, 25, 50, -1], ['2 rows', '10 rows', '25 rows', '50 rows', 'Show all']],
        "bSortClasses": false,
        "deferRender": true,
        initComplete: function()
        {
            var api = this.api();

            // Apply the search
            api.columns().every(function() {
                var that = this;

                $('input', this.header()).on('keyup change', function(e)
                {
                    if($(this).is(':focus'))
                    {
                        if(e.keyCode === 13)
                        {
                            if (that.search() !== this.value) {
                                that
                                    .search(this.value)
                                    .draw();
                            }
                        }
                        else if (e.keyCode === 8)
                        {
                            if (this.value == '') {
                                that
                                    .search(this.value)
                                    .draw();
                            }
                        }
                    }
                });
            });
        }
    });

}

$('#ip_address_login_table_data').on('click','#grant_ip_address',function () {

    var id = $(this).attr('name');//id
    var mode = 'granting';
    ip_address_func(id,mode);
});

$('#ip_address_login_table_data').on('click','#deny_ip_address',function () {

    var id = $(this).attr('name');//id
    var mode = 'denying';
    ip_address_func(id,mode);
});

$('#ip_address_login_table_data').on('click','#delete_ip_address',function () {

    var id = $(this).attr('name');//id
    var mode = 'deleting';
    ip_address_func(id,mode);
});

$('#user_access_login_table_data').on('click','#grant_user_access',function () {

    var id = $(this).attr('name');//id
    var mode = 'granting';
    user_access_func(id,mode);
});

$('#user_access_login_table_data').on('click','#deny_user_access',function () {

    var id = $(this).attr('name');//id
    var mode = 'denying';
    user_access_func(id,mode);
});

function ip_address_func(id,mode) {
    $.ajax({

        url:    'ip_address_access',
        type:   'get',
        data: {
            'id' : id,
            'mode' : mode
        },
        success: function (data) {
            ip_address_login_table_data.ajax.reload(null,false)
        },
        error: function () {
            console.log('error');
        }
    });
}

function user_access_func(id,mode) {
    $.ajax({

        url:    'user_accessibility',
        type:   'get',
        data: {
            'id' : id,
            'mode' : mode
        },
        success: function (data) {
            user_access_login_table_data.ajax.reload(null,false)
        },
        error: function () {
            console.log('error');
        }
    });
}

$('#admin_add_ip_address').click(function () {

    var ip = $('#admin_ip_address_accessibility').val();
    var branch_name = $('#admin_branch_name_accessibility').val();
    var access = $('#admin_select_accessibility').val();

    $.ajax({

        url:    'admin_add_ip_access',
        type:   'get',
        data: {
            'ip' : ip,
            'branch_name' : branch_name,
            'access' : access
        },
        success: function (data) {
            ip_address_login_table_data.ajax.reload(null,false)
        },
        error: function () {
            console.log('error');
        }

    });

    $('#admin_ip_address_accessibility').val('');
    $('#admin_branch_name_accessibility').val('');
});

$('#usertableManage').on('click','.add_tat_selector',function ()
{
    var user_id = $(this).attr('id');
    console.log(user_id);
    check_if_sitel = 'yes';

    $.ajax({
        type: 'get',
        url: 'admin_addOrRemove_tat_selector',
        data: {
            'id' : user_id,
            'check_if_sitel' : check_if_sitel
        },
        success: function(data){
            alert(data);
            tableuser.ajax.reload(null, false);
        }
    });
});

$('#usertableManage').on('click','.remove_tat_selector',function () {

    var user_id = $(this).attr('id');
    console.log(user_id);
    check_if_sitel = 'no';

    $.ajax({
        type: 'get',
        url: 'admin_addOrRemove_tat_selector',
        data: {
            'id' : user_id,
            'check_if_sitel' : check_if_sitel
        },
        success: function(data){
            alert(data);
            tableuser.ajax.reload(null, false);
        }
    });
});

$('#change-view-bi').click(function()
{
    $('#addViewable_bi').hide();
    bi_access_table.draw();

    $.ajax
    ({
        type: 'get',
        url: 'admin_get_bi_view',
        success: function(data)
        {
            console.log(data);

            if(data[0].length > 0)
            {
                var valueToLoop = '<option value="-">-</option>';
                for(var i = 0; i < data[0].length; i++)
                {
                    valueToLoop += '<option value ="'+data[0][i].id+'">'+data[0][i].name+'</option>';
                }
                $('#selectBiNameSpan').html('<select name="" id="selectBiName" class="form-control" style="width: 100%;">' + valueToLoop + '</select>');

            }

            if(data[1].length > 0)
            {
                var valueToLoop2 = '<option value="-">-</option>';
                for(var o = 0; o < data[1].length; o++)
                {
                    valueToLoop2 += '<option value ="'+data[1][o].id+'">'+data[1][o].bi_account_name+' '+data[1][o].account_location+'</option>';
                }
                $('#selectSiteSpan').html('<select name="" id="selectSiteName" class="form-control" style="width: 100%;">' + valueToLoop2 + '</select>');
            }
        },
        complete: function()
        {
            $('#selectBiName').change(function()
            {
                bi_id = $(this).val();
                bi_access_table.draw();
            });

            $('#selectSiteName').change(function()
            {
                bi_acct_id = $(this).val();
                bi_access_table.draw();

                if($('#selectSiteName').find(':selected').val() != '-')
                {
                    $('#addViewable_bi').show();
                }
                else
                {
                    $('#addViewable_bi').hide();
                }
            });
        }
    });
});

var bi_title_search;
var bi_title_search_counts = 0 ;
var bi_access_table;
var bi_id;
var bi_acct_id;
biViewAccessFunc();
$('#addViewable_bi').hide();


function biViewAccessFunc()
{
    $('#bi_change_access_table thead th').each(function () {
        bi_title_search[bi_title_search_counts] = $(this).text();
        bi_title_search_counts++
        var title = $(this).text();
        $(this).html(title+'<br><input type="text" placeholder="Search" style="position: relative; width: 100%;"> ')
    });

    bi_access_table = $('#bi_change_access_table').DataTable
    ({
        "responsive" : true,
        "processing" : true,
        "serverSide" : true,
        // "ajax" : 'admin_bi_change_bi_view_table',
        "ajax":
            {
                url: "admin_bi_change_bi_view_table",
                data: function (d)
                {
                    d.id = bi_id
                }
            },
        "columns":
            [
                // {data: 'name', name: 'users.name'},
                {
                    data: function action(data)
                    {
                        return data.name + ' ' + data.loc;
                    },
                    'name' : 'name',
                    'searchable' : false,
                    'orderable' : false
                },
                {
                    data: function action(data)
                    {
                        if(data.display == 'display')
                        {
                            return '<button class="btn btn-xs btn-primary btn-block" disabled><i class="glyphicon glyphicon-eye-open"></i>View</button>'
                        }
                        else
                        {
                            return '<button class="btn btn-xs btn-warning btn-block btn_change_view_bi" id="'+data.id+'" value="'+data.org_id+'"><i class="glyphicon glyphicon-edit"></i> Change View</button>' +
                                '<button class="btn btn-xs btn-danger btn-block btn_delete_access_bi" id="'+data.id+'" value="'+data.org_id+'"><i class="glyphicon glyphicon-trash"></i> Delete</button>';
                        }
                    },
                    'name' : 'action',
                    'searchable' : false,
                    'orderable' : false
                }
            ],

        "order" :[[0, 'desc']],
        "pageLength" : 10,
        "lengthMenu" : [[2, 10, 25, 50, -1], ['2 rows', '10 rows', '25 rows', '50 rows', 'Show all']],
        "bSortClasses" : false,
        "deferRender" : true,
        initComplete : function ()
        {
            var api = this.api();

            //Apply the search
            api.column().every(function()
            {
                var that = this;

                $('input', this.header()).on('keyup change', function(e)
                {
                    if($(this).is(':focus'))
                    {
                        if(e.keyCode === 13)
                        {
                            if (that.search() !== this.value) {
                                that
                                    .search(this.value)
                                    .draw();
                            }
                        }
                        else if (e.keyCode === 8)
                        {
                            if (this.value == '') {
                                that
                                    .search(this.value)
                                    .draw();
                            }
                        }
                    }
                });
            });
        }

    });

    $('#bi_change_access_table_filter input').unbind();
    $('#bi_change_access_table_filter input').bind('keyup change', function(e)
    {
        if($(this).is(':focus'))
        {
            if (e.keyCode === 13) {
                bi_access_table.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '') {
                    bi_access_table.search($(this).val()).draw();
                }
            }
        }
    });
}

$('#bi_change_access_table').on('click', '.btn_change_view_bi', function()
{
    var id = $(this).attr('id');
    var org_id = $(this).val();

    $.ajax({
        type: 'get',
        url: 'admin_update_bi_default_view',
        data: {
            'id' : id,
            'orig_id' : org_id
        },
        success: function(data)
        {
            alert(data);
            bi_access_table.draw();
        }
    });
});

$('#bi_change_access_table').on('click', '.btn_delete_access_bi', function()
{
    var id = $(this).val();

    $.ajax({
        type: 'get',
        url: 'admin_delete_bi_view',
        data: {
            'id' : id
        },
        success: function(data)
        {
            alert(data);
            bi_access_table.draw();
        }
    });
});

$('#addViewable_bi').click(function()
{
    var user_id = $('#selectBiName').val();
    var bi_accnt_id = $('#selectSiteName').val();

    $.ajax({
        type: 'get',
        url: 'admin_add_viewable_to_bi',
        data: {
            'user_id': user_id,
            'bi_accnt_id' : bi_accnt_id
        },
        success: function(data)
        {
            alert(data);
            bi_access_table.draw();
        }
    });
});

var user_acc_id=

    $(document).on('click', '.edit_accesDB', function()
    {
        user_acc_id = $(this).attr('id');
        $('#client_type').val('');
        $('#client_check').val('');
        $('#authrequest').val('');

        $.ajax({
            type: 'get',
            url: 'admin_get_access_of_user',
            data: {
                'id' : user_acc_id
            },
            success: function(data)
            {
                console.log(data);
                $('#client_type').val(data[0].client_type);
                $('#client_check').val(data[0].client_check);
                $('#authrequest').val(data[0].authrequest);
                $('#login_check').val(data[0].login_check);
            }
        });
    });

$('#submit_access_control').click(function()
{
    $.ajax({
        type: 'get',
        url: 'admin_access_control',
        data: {
            'id' : user_acc_id,
            'client_type': $('#client_type').val(),
            'client_check' : $('#client_check').val(),
            'authrequest' : $('#authrequest').val(),
            'login_check' : $('#login_check').val()
        },
        success: function(data)
        {
            console.log(data);
            alert('Access update success');
            $('#modal-access-control').modal('hide');
        }
    });
});

$('#generate_password').on('click',function () {
    $('#password').val(password_generator(12));
});

function password_generator(length) {
    var result           = '';
    var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    var charactersLength = characters.length;
    for ( var i = 0; i < length; i++ ) {
        result += characters.charAt(Math.floor(Math.random() * charactersLength));
    }
    return result;
}

var teleLevelTableFunc;
teleLevelTable();
function teleLevelTable()
{
    $('#teleLevels thead tr th').each(function()
    {
        $(this).css('background-color', 'black');
        $(this).css('color', 'white');
    });

    teleLevelTableFunc = $('#teleLevels').DataTable
    ({
        "responsive" : true,
        "processing" : true,
        "serverSide" : true,
        "ajax" : 'admin_get_all_tele_level_table',
        "columns":
            [
                {data: 'id', name: 'users.id', width: '5%'},
                {data: 'name', name: 'users.name'},
                {
                    data: function status(data)
                    {
                        if(data.status == null || data.status == '')
                        {
                            return 'Level 1';
                        }
                        else
                        {
                            return 'Level ' + data.status;
                        }
                    },
                    name: 'cc_tele_levels.level'
                },
                {
                    data: function action(data)
                    {
                        if(data.status == null || data.status == 1)
                        {
                            return '<button class="btn btn-xs btn-success tele_level_edit_1 btn-block" id="'+data.id+'">Level Up</button>' +
                                '<button class="btn btn-xs btn-danger tele_level_edit_2 btn-block" id="'+data.id+'" disabled>Level Down</button>';
                        }
                        else if(data.status == 2)
                        {
                            return '<button class="btn btn-xs btn-success tele_level_edit_1 btn-block" id="'+data.id+'" disabled>Level Up</button>' +
                                '<button class="btn btn-xs btn-danger tele_level_edit_2 btn-block" id="'+data.id+'">Level Down</button>';
                        }


                    },
                    name: 'users.id',
                    orderable: false,
                    searchable: false,
                    width: '5%'
                }
            ],
        "pageLength" : 10,
        "lengthMenu" : [[2, 10, 25, 50, -1], ['2 rows', '10 rows', '25 rows', '50 rows', 'Show all']]
    });

    $('#teleLevels_filter input').unbind();
    $('#teleLevels_filter input').bind('keyup change', function(e)
    {
        if($(this).is(':focus'))
        {
            if (e.keyCode === 13) {
                teleLevelTableFunc.search($(this).val()).draw();
            }
            // else if (e.keyCode === 8)
            // {
            //     if ($(this).val() == '') {
            //         teleLevelTableFunc.search($(this).val()).draw();
            //     }
            // }
        }
    });
}

$('#teleLevels').on('click', '.tele_level_edit_1', function()
{
    var id = $(this).attr('id');
    var btn = $(this);

    if(confirm('Are you sure to level up tele?'))
    {
        btn.attr('disabled', true);

        $.ajax({
            type: 'get',
            url: 'admin_levelup_tele',
            data: {
                'id' : id
            },
            success : function(data)
            {
                alert('success!');
            },
            complete : function()
            {
                btn.attr('disabled', false);
                teleLevelTableFunc.draw();
            }
        });
    }
});

$('#teleLevels').on('click', '.tele_level_edit_2', function()
{
    var id = $(this).attr('id');
    var btn = $(this);

    if(confirm('Are you sure to level 1 this tele?'))
    {
        btn.attr('disabled', true);

        $.ajax({
            type: 'get',
            url: 'admin_downlevel_tele',
            data: {
                'id' : id
            },
            success : function(data)
            {
                alert('success!');
            },
            complete : function()
            {
                btn.attr('disabled', false);
                teleLevelTableFunc.draw();
            }
        });
    }
});

var adminReminderTable;

adminReminderTableFunc();
function adminReminderTableFunc()
{
    adminReminderTable = $('#admin-reminder-table').DataTable
    ({
        "responsive" : true,
        "processing" : true,
        "serverSide" : true,
        "ajax" : 'admin_get_reminder_table',
        "columns":
            [
                {data: 'name', name: 'reminder_list.reminder_name'},
                {data: 'day', name: 'reminder_list.day_of_reminder'},
                {data: 'datetime', name: 'reminder_list.created_at'},
                {
                    data: function action(data)
                    {
                        return '<button class="btn btn-primary btn-xs btn-block edit-reminder" id="'+data.id+'">Edit</button>' +
                        '<button class="btn btn-danger btn-xs btn-block remove-reminder" id="'+data.id+'">Remove</button>';
                    },
                    name: 'reminder_list.id'
                }
            ],
        "pageLength" : 10,
        "lengthMenu" : [[10, 25, 50, -1], ['10 rows', '25 rows', '50 rows', 'Show all']],
        initComplete: function () {
            // $('#admin-reminder-table thead tr th').each(function () {
            //     $(this).unbind();
            //     var asset = $(this).text();
            //     if(asset != 'Action')
            //     {
            //         $(this).html(asset + '<br><input type="text" placeholder="Search" style="position: center; width: 100%">');
            //     }
            // });

            // var api = this.api();
            //
            // api.columns().every(function () {
            //     var that = this;
            //
            //     $('input', this.header()).on('keyup change', function (e) {
            //         if ($(this).is(':focus')) {
            //             if (e.keyCode === 13) {
            //                 if (that.search() !== this.value) {
            //                     that
            //                         .search(this.value)
            //                         .draw();
            //                 }
            //             }
            //             else if (e.keyCode === 8) {
            //                 if (this.value == '') {
            //                     that
            //                         .search(this.value)
            //                         .draw();
            //                 }
            //             }
            //         }
            //     });
            // });
        }
    });

    $('#admin-reminder-table_filter input').hide();
    $('#admin-reminder-table_filter label').hide();
}

$('#add-reminder').click(function()
{
    var btn = $(this);
    var rem_name = $('#reminder-name').val();
    var rem_day = $('#reminder-day').val();
    var validationBool = false;

    $('.validateIn').each(function()
    {
        if($(this).val != '')
        {
            validationBool = true;
        }
        else
        {
            alert('Fill-up required fields');
            return false;
        }
    });

    if(validationBool)
    {
        btn.attr('disabled', true);

        $.ajax({
            type: 'get',
            url: 'admin_add_reminder',
            data: {
                'reminder_name' : rem_name,
                'rem_day' : rem_day
            },
            success : function(data)
            {
                // console.log(data);
                alert('Reminder successfully added');
            },
            complete: function ()
            {
                btn.attr('disabled', false);
                adminReminderTable.draw();
                $('#reminder-name').val('');
                $('#reminder-day').val('');
            }
        })
    }
});

$('#admin-reminder-table').on('click', '.remove-reminder' ,function()
{
    var id = $(this).attr('id');
    var btn = $(this);

    if(confirm('Are you sure to remove the reminder?'))
    {
        btn.attr('disabled', true);
        $.ajax({
            type: 'get',
            url: 'admin_edit_or_remove_reminder',
            data: {
                'type' : 'remove',
                'id' : id
            },
            success : function(data)
            {
                console.log(data);
                alert(data);
            },
            complete: function()
            {
                btn.attr('disabled', false);
                adminReminderTable.draw();
            }
        });
    }
});

$('#email-segregation').click(function()
{
    if(!user_client_list_bool)
    {
        if(!adminEmailReceiverBool)
        {
            adminTableEmailReceivers();
        }
        else
        {
            adminEmailReceiver.draw();
        }
        $.ajax({
            type: 'get',
            url: 'admin_get_to_email_user_and_client',
            success: function(data)
            {
                user_client_list_bool = true;
                var what_to_append_user = '<option value="">-</option>';
                var what_to_append_client = '<option value="">-</option>';
                var what_to_append_pos = '<option value="">-</option>';

                if(data[1].length > 0)
                {
                    for(var i = 0; i < data[1].length; i++)
                    {
                        what_to_append_client += '<option value="'+data[1][i].id+'">'+data[1][i].name+'</option>';
                    }

                    $('#email_sinder_client').html(what_to_append_client);
                }

                if(data[0].length > 0)
                {
                    for(var j = 0; j < data[0].length; j++)
                    {
                        what_to_append_user += '<option value="'+data[0][j].id+'"><<b> '+data[0][j].email+' <b> >'+data[0][j].name+'</option>';
                    }

                    $('#email_risiver_user').html(what_to_append_user);
                }

                if(data[2].length > 0)
                {
                    for(var k = 0; k < data[2].length; k++)
                    {
                        what_to_append_pos += '<option value="'+data[2][k].id+'">'+data[2][k].name+'</option>';
                    }

                    $('#email_risiver_positions').html(what_to_append_pos);
                }
            },
            error: function(e)
            {
                user_client_list_bool = false;
                console.log(e);
            }
        })
    }
    else
    {
        console.log('list already loaded');
    }
});

function adminTableEmailReceivers()
{
    adminEmailReceiver = $('#endor_receivers_table').DataTable
    ({
        "responsive" : true,
        "processing" : true,
        "serverSide" : true,
        // "ajax" : 'admin_endorsements_email_receiver_table',
        "ajax":
            {
                url: "admin_endorsements_email_receiver_table",
                data: function (d)
                {
                    d.client_name = $('#email_sinder_client').children(':selected').val();
                }
            },
        "columns":
            [
                {data: 'name', name: 'user.name'},
                {
                    data: function action(data)
                    {
                        return '<button class="btn btn-danger remove_recipient" id="'+btoa(data.id)+'">Remove</button>';
                    },

                    name: 'user.name',
                    'orderable': false
                }
            ],
        "pageLength" : 10,
        "lengthMenu" : [[2, 10, 25, 50, -1], ['2 rows', '10 rows', '25 rows', '50 rows', 'Show all']],
        initComplete: function () {
            $('#endor_receivers_table thead tr th').each(function () {
                $(this).unbind();
                var asset = $(this).text();
                if(asset != 'Action')
                {
                    $(this).html(asset + '<br><input type="text" placeholder="Search" style="position: center; width: 100%">');
                }
            });

            var api = this.api();

            api.columns().every(function () {
                var that = this;

                $('input', this.header()).on('keyup change', function (e) {
                    if ($(this).is(':focus')) {
                        if (e.keyCode === 13) {
                            if (that.search() !== this.value) {
                                that
                                    .search(this.value)
                                    .draw();
                            }
                        }
                        else if (e.keyCode === 8) {
                            if (this.value == '') {
                                that
                                    .search(this.value)
                                    .draw();
                            }
                        }
                    }
                });
            });
        }
    });

    $('#endor_receivers_table_filter input').unbind();
    $('#endor_receivers_table_filter input').bind('keyup change', function(e)
    {
        if($(this).is(':focus'))
        {
            if (e.keyCode === 13) {
                adminEmailReceiver.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                // if ($(this).val() == '') {
                //     adminEmailReceiver.search($(this).val()).draw();
                // }
            }
        }
    });
}

$('#endor_receivers_table').on('click', '.remove_recipient', function()
{
    var id = $(this).attr('id');

    if(confirm('Are you sure to remove this user to the endorsements notification?'))
    {
        $.ajax({
            type: 'get',
            url: 'admin_add_user_to_email_endorsements',
            data: {
                'id' : id
            },
            success: function(data)
            {
                console.log(data);
                if(data == 'success')
                {
                    adminEmailReceiver.draw();
                    alert('User successfully removed to email recipient');
                }
                else {
                    alert('Error');
                }
            },
            error: function(e)
            {
                console.log(e);
            }
        })
    }
    else
    {
        console.log('do nothing');
    }
});

$('#email_sinder_client').change(function()
{
    adminEmailReceiver.draw();
});

$('#add_as_client_recipient').click(function()
{
    var client_nameeeeee = $('#email_sinder_client').children(':selected').val();
    var user_nameeee = $('#email_risiver_user').children(':selected').val();

    if(client_nameeeeee == '')
    {
        alert('Select Client');
    }
    else if(user_nameeee == '')
    {
        alert('Select User/Recipient');
    }
    else
    {
        $.ajax({
            type: 'get',
            url: 'admin_add_recipient_endorsement',
            data: {
                'client_id' : client_nameeeeee,
                'user_id' : user_nameeee
            },
            success: function(data)
            {
                if(data == 'success')
                {
                    alert('User successfully added to the records');
                    adminEmailReceiver.draw();
                }
                else
                {
                    alert('User is already listed to the recipient');
                }
                console.log(data);
            },
            error: function(e)
            {
                console.log(e);
            }
        })
    }
});

$('#email_risiver_positions').change(function()
{
    $('#email_risiver_user > option').each(function()
    {
        $(this).remove();
    });
    var $this = $(this);
    $.ajax({
        type: 'get',
        url: 'admin_get_all_defined_pos',
        data: {
            'pos_id': $this.children('option:selected').val()
        },
        success: function(data)
        {
            if(data.length > 0)
            {
                var what_to_append_user = '<option value="">-</option>';

                for(var k = 0; k < data.length; k++)
                {
                    // $('#email_risiver_user > option').each(function()
                    // {
                    //     if($(this).val() != data[k].id)
                    //     {
                    //         $(this).hide();
                    //     }
                    //     else
                    //     {
                    //         $(this).css('display', 'block');
                    //         console.log(k);
                    //     }
                    // });
                    what_to_append_user += '<option value="'+data[k].id+'">'+data[k].name+'</option>';
                    console.log(data[k].name);
                }

                $('#email_risiver_user').html(what_to_append_user);
            }
            // console.log(data);
        }
    });
});

$('#email-distrib').click(function()
{

    $('#admin_active_clients > option').each(function()
    {
        $(this).remove();
    });

    $('#admin_active_clientsv2 > option').each(function()
    {
        $(this).remove();
    });

    $.ajax({
        type: 'get',
        url:'admin_get_all_active_client',
        success: function(data)
        {
            var to_append = '<option value="">-</option>';
            if(data.length > 0)
            {
                for(var i = 0; i < data.length; i++)
                {
                    to_append += '<option value="'+data[i].id+'">'+data[i].name+'</option>';
                }

                $('#admin_active_clients').append(to_append);
                $('#admin_active_clientsv2').append(to_append);
            }
        }
    });
});

$('#add_dist_client').click(function()
{
    var checkerBool = true;
    var btn = $(this);
    $('.admin_email_dist_valid').each(function()
    {
        if($(this).val() == '')
        {
            checkerBool = false;
            return false;
        }
    });

    if(checkerBool)
    {
        if(confirm('Are you sure to add the client with ' + $('#admin_active_clients_bool option:selected').val() + ' Archipelago?'))
        {
            btn.attr('disabled', true);
            $.ajax({
                type: 'get',
                url: 'admin_add_client_dist_list',
                data: {
                    'branch_id' : $('#admin_active_clients').val(),
                    'app_bool' : $('#admin_active_clients_bool option:selected').val()
                },
                success: function(data)
                {
                    if(data == 'added')
                    {
                        alert('Client Distribution List Succesfully Added!');
                    }
                    else if(data == 'updated')
                    {
                        alert('Client Distribution List Succesfully Updated!');
                    }
                    btn.attr('disabled', false);
                },
                error: function(e)
                {
                    alert('Error occured!');
                    btn.attr('disabled', false);
                }
            });
        }
    }
});

$('#admin_add_email_click_client').click(function()
{
    var btn = $(this);


    if($('#admin_inserted_receiver_email').val() != '')
    {
        if(confirm('Are you sure to add this '+ $('#admin_inserted_receiver_email').val() +' email?'))
        {
            if($('#admin_inserted_receiver_email').is(':valid'))
            {
                btn.attr('disabled', true);
                $.ajax({
                    type: 'get',
                    url: 'admin_add_email_to_distribution_list',
                    data: {
                        'branch_id' : $('#admin_active_clientsv2 option:selected').val(),
                        'user_email': $('#admin_inserted_receiver_email').val(),
                        'archi' : $('#admin_inserted_receiver_archi').val()
                    },
                    success: function(data)
                    {
                        btn.attr('disabled', false);
                        if(data == 'already')
                        {
                            alert('email is already added');
                        }
                        else if(data == 'added')
                        {
                            alert('email successfully added');
                        }
                        // GetDistListOfClient($('#admin_active_clientsv2 option:selected').val())
                        console.log(data);
                    },
                    error: function(e)
                    {
                        alert('Error occured!');
                        btn.attr('disabled', false);
                    }
                });
            }
            else
            {
                alert('E-mail address is not valid');
            }
        }
    }
    else {
        alert('Required Fields');
    }
});

$('#admin_active_clientsv2').change(function()
{
    GetDistListOfClient($('#admin_active_clientsv2 option:selected').val())
});

function GetDistListOfClient(branch_id)
{
    if($('#admin_active_clientsv2').val() != '')
    {
        $('.hide_thisPortion').show();
    }
    else
    {
        $('.hide_thisPortion').hide();
    }

    console.log(branch_id);
    $('#dist_list_admin tr').each(function()
    {
        if($(this).attr('style') == 'background-color: black; color: white;')
        {
            console.log('do nothing');
        }
        else
        {
            $(this).remove();
        }
    });

    $.ajax({
        type: 'get',
        url: 'admin_get_distribution_list_with_emails',
        data: {
            'branch_id' : branch_id,
            // 'archi' :
        },
        success: function(data)
        {
            var to_append = '';


            if(data[0].length > 0)
            {
                for(var i = 0; i < data[0].length; i++)
                {
                    to_append += '<tr>\n' +
                        '<td>'+data[0][i].user_email+'</td>\n' +
                        '<td><button class="btn btn-sm btn-danger delete_email_to_dist_list" id="'+data[0][i].id+'"><i class="glyphicon glyphicon-trash"></i></button></td>\n' +
                        '</tr>';
                }
            }
            else
            {
                to_append = '<tr>\n' +
                    '<td colspan="2">NO RECORDS FOUND</td>\n' +
                    '</tr>';
            }

            $('#dist_list_admin').append(to_append);

            if(data[1][0].applicable_bool == 'true')
            {
                $('.hide_if_false').show();
                $('#this_is_false').hide();
                $('#this_is_true1').show();
                $('#this_is_true2').show();
                $('#this_is_true3').show();
            }
            else if(data[1][0].applicable_bool == 'false')
            {
                $('.hide_if_false').hide();
                $('#this_is_false').show();
                $('#this_is_true1').hide();
                $('#this_is_true2').hide();
                $('#this_is_true3').hide();
            }
        }
    });
}

$('#dist_list_admin, #distrib_luzon, #distrib_vis, distrib_min').on('click', '.delete_email_to_dist_list', function()
{
    var id = $(this).attr('id');

    if(confirm('Are you sure to delete email in the list?'))
    {
        console.log(id);
        $.ajax({
            type: 'get',
            url: 'admin_delete_email_to_dist_list',
            data: {
                'id' : id
            },
            success:function(data)
            {
                alert('email successfully deleted');
                GetDistListOfClient($('#admin_active_clientsv2 option:selected').val())
            }
        });
        // GetDistListOfClient($('#admin_active_clientsv2 option:selected').val())
    }
});

$('.masterLoopDist').each(function()
{
    var id = $(this).attr('id');
    var $tableAppend = $(this);
    $('#' + id + '').on('click', '.distrib_master_btn', function()
    {
        $('#'+ id + ' tr').each(function()
        {
            var $this = $(this);

            if($this.attr('style') != 'background-color: black; color: white;')
            {
                $this.toggle();
            }
        });

        GetListApplicableDist($('#admin_active_clientsv2 option:selected').val(), $tableAppend)
    });
});

function GetListApplicableDist(branch_id, tableAppend)
{
    var to_append = '';

    $.ajax({
        type: 'get',
        url: 'admin_get_distribution_list_with_emails',
        data: {
            'branch_id' : branch_id,
            'archi' : tableAppend.attr('what')
        },
        success: function(data)
        {
            to_append ='';
            tableAppend.children('tr').each(function()
            {
                if($(this).attr('style') != 'background-color: black; color: white;')
                {
                    $(this).remove();
                }
            });

            if(data[0].length > 0)
            {
                for(var i = 0; i < data[0].length; i++)
                {
                    to_append += '<tr>\n' +
                        '<td>'+data[0][i].user_email+'</td>\n' +
                        '<td><button class="btn btn-sm btn-danger delete_email_to_dist_list" id="'+data[0][i].id+'"><i class="glyphicon glyphicon-trash"></i></button></td>\n' +
                        '</tr>';
                }
            }
            else
            {
                to_append = '<tr>\n' +
                    '<td colspan="2">NO RECORDS FOUND</td>\n' +
                    '</tr>';
            }

            tableAppend.append(to_append);
        }
    });
}

$('#usertableManage').on('click', '.PermissionUpdateTime', function()
{
    var id = $(this).attr('id');
    var type = $(this).attr('name');

    if(confirm('Are you sure to '+type+' permission?'))
    {
        $.ajax
        ({
            type : 'get',
            url : 'admin_give_access_ci',
            data :
                {
                    'id' : id,
                    'type' : type
                },
             success : function()
             {
                 alert('Successfully Changed!')
                 tableuser.ajax.reload(null, false);
             }
        })
    }
    else
    {

    }
});


var bi_under_loc_id = '';
var bi_under_loc_site = '';
var bi_loc_table;
var bi_loc_table_arr = [];
var bi_loc_table_count = 0;

biTableUnderLoc();

$('#bi-select-loc').click(function()
{
    $.ajax
    ({
        type: 'get',
        url: 'admin_get_bi_view',
        success: function(data)
        {
            console.log(data);

            if(data[0].length > 0)
            {
                var valueToLoop = '<option value="">-</option>';
                for(var i = 0; i < data[0].length; i++)
                {
                    valueToLoop += '<option value ="'+data[0][i].id+'">'+data[0][i].name+'</option>';
                }
                $('#showAllBiUsers').html('<select name="" id="selctBiToLoc" class="form-control" style="width: 100%;">' + valueToLoop + '</select>');

            }

            if(data[1].length > 0)
            {
                var valueToLoop2 = '<option value="">-</option>';
                for(var o = 0; o < data[1].length; o++)
                {
                    valueToLoop2 += '<option value ="'+data[1][o].id+'">'+data[1][o].bi_account_name+' '+data[1][o].account_location+'</option>';
                }
                $('#showAllBiSites').html('<select name="" id="selectedLocForBI" class="form-control" style="width: 100%;">' + valueToLoop2 + '</select>');
            }
        },
        complete: function()
        {
            $('#showAllBiUsers').change(function()
            {
                bi_under_loc_id = $(this).val();
                bi_loc_table.draw();

                console.log(bi_under_loc_id)


            });

            $('#showAllBiSites').change(function()
            {
                bi_under_loc_site = $(this).val();
                bi_loc_table.draw();

            });
        }
    });
});


$('.btn_add_loc_to_bi').click(function()
{
    if(bi_under_loc_id != '' && bi_under_loc_site != '')
    {
        $.ajax
        ({
            type : 'get',
            url : 'admin_add_loc_to_bi_user',
            data :
                {
                    'id' : bi_under_loc_id,
                    'loc' : bi_under_loc_site
                },
            success : function(data)
            {
                if(data == 'exist')
                {
                    alert('Location already exists');
                }
                else
                {
                    alert('Successfully Added.');
                    bi_loc_table.draw();
                }
            },
            error : function()
            {
                alert('Something went wrong.')
            }

        });
    }
    else
    {
        alert('Please select user and site first');
    }
});

$('#tableLocUnderBI').on('click', '.btn_delete_loc_bi', function()
{
    var id = $(this).attr('id');

    $.ajax
    ({
        type : 'get',
        url : 'admin_delete_loc_under_bi',
        data :
            {
                'id' : id
            },
        success : function ()
        {
            alert('Successfully removed.');
            bi_loc_table.draw();
        },
        error : function ()
        {
            alert('Something went wrong');
        }
    });
});


function biTableUnderLoc()
{
    $('#tableLocUnderBI thead th').each(function () {
        bi_loc_table_arr[bi_loc_table_count] = $(this).text();
        bi_loc_table_count++
        var title = $(this).text();
        $(this).html(title+'<br><input type="text" placeholder="Search" style="position: relative; width: 100%;"> ')
    });

    bi_loc_table = $('#tableLocUnderBI').DataTable
    ({
        "responsive" : true,
        "processing" : true,
        "serverSide" : true,
        // "ajax" : 'admin_bi_change_bi_view_table',
        "ajax":
            {
                url: 'admin_bi_user_loc_table_get',
                data: function (d)
                {
                    d.id = bi_under_loc_id
                }
            },
        "columns":
            [
                // {data: 'name', name: 'users.name'},
                { data : 'id' , name : 'bi_users_under_location.id'},
                { data : 'name' , name : 'bi_account_list.bi_account_name'},
                { data : 'loc' , name : 'bi_account_list.bi_account_location'},
                {
                    data: function action(data)
                    {
                        return '<button class="btn btn-xs btn-danger btn-block btn_delete_loc_bi" id="'+data.id+'" ><i class="glyphicon glyphicon-trash"></i> Delete</button>';
                    },
                    'name' : 'action',
                    'searchable' : false,
                    'orderable' : false
                }
            ],

        "order" :[[0, 'desc']],
        "pageLength" : 10,
        "lengthMenu" : [[2, 10, 25, 50, -1], ['2 rows', '10 rows', '25 rows', '50 rows', 'Show all']],
        "bSortClasses" : false,
        "deferRender" : true,
        initComplete : function ()
        {
            var api = this.api();

            //Apply the search
            api.column().every(function()
            {
                var that = this;

                $('input', this.header()).on('keyup change', function(e)
                {
                    if($(this).is(':focus'))
                    {
                        if(e.keyCode === 13)
                        {
                            if (that.search() !== this.value) {
                                that
                                    .search(this.value)
                                    .draw();
                            }
                        }
                        else if (e.keyCode === 8)
                        {
                            if (this.value == '') {
                                that
                                    .search(this.value)
                                    .draw();
                            }
                        }
                    }
                });
            });
        }

    });

    $('#tableLocUnderBI_filter input').unbind();
    $('#tableLocUnderBI_filter input').bind('keyup change', function(e)
    {
        if($(this).is(':focus'))
        {
            if (e.keyCode === 13) {
                bi_loc_table.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '') {
                    bi_loc_table.search($(this).val()).draw();
                }
            }
        }
    });
}

function getAttendanceInfoGeneral()
{
    $('.general_attendance_logs tr').each(function()
    {
        if($(this).attr('style') != 'background-color: black; color:white;')
        {
            $(this).remove();
        }
    });
    $.ajax({
        type: 'get',
        url: 'gen_attendance_in_out_check',
        data: {
            'date_inputted' : null
        },
        success: function (data)
        {
            var to_append = '';
            // console.log(data);
            if(data[0].length > 0)
            {
                var dateFormater = '';
                var timeFormater = '';
                for(var i = 0; i < data[0].length; i++)
                {
                    dateFormater = new Date(data[0][i].created_at).toDateString();
                    to_append += '<tr>\n' +
                        '<td>'+dateFormater+'</td>\n' +
                        '<td>'+DisplayCurrentTime(data[0][i].time_in)+'</t>\n' +
                        '<td>'+data[0][i].type+'</td>\n' +
                        '</tr>';
                }
            }
            else
            {
                to_append = '<tr>\n' +
                    '<td colspan="3">NO RECORDS FOUND</td>\n' +
                    '</tr>'
            }

            if(data[2] == false)
            {
                $('.attendance_all_click').attr('disabled', true);
            }
            else
            {
                $('.attendance_all_click').attr('disabled', false);
            }

            if(data[1][0].work_start != null && data[1][0].work_end != null || data[1][0].work_start != '' && data[1][0].work_end != '')
            {
                var $timeIN = data[1][0].work_start.split(':');
                var $timeIN2 = data[1][0].work_start.split(':');
                var $timeAmPM = data[1][0].work_start.split(' ');

                var $timeOUT = data[1][0].work_end.split(':');
                var $timeOUT2 = data[1][0].work_end.split(':');
                var $timeAmPMOUT = data[1][0].work_end.split(' ');

                $('.time_in_class_val[name="0"]').val($timeIN[0]);
                $('.time_in_class_val[name="1"]').val($timeIN2[1].split(' ')[0]);
                $('.time_in_class_val[name="2"]').val($timeAmPM[1]);

                $('.time_out_class_val[name="0"]').val($timeOUT[0]);
                $('.time_out_class_val[name="1"]').val($timeOUT2[1].split(' ')[0]);
                $('.time_out_class_val[name="2"]').val($timeAmPMOUT[1]);

                // $('.time_out_class_val[name="0"]').val(data[1][0].work_end.split(':')[0]);
                // $('.time_out_class_val[name="1"]').val(data[1][0].work_end.split(':')[1]);
                // $('.time_out_class_val[name="2"]').val(data[1][0].work_end.split(' ')[1]);

                $('#attendance_work_start').val(data[1][0].work_start);
                $('#attendance_work_end').val(data[1][0].work_end);
            }
            else
            {
                $('.time_in_class_val[name="0"]').val(0);
                $('.time_in_class_val[name="1"]').val(1);
                // $('.time_in_class_val[name="2"]').val($timeAmPM[1]);

                $('.time_out_class_val[name="0"]').val(0);
                $('.time_out_class_val[name="1"]').val(0);
                // $('.time_out_class_val[name="2"]').val($timeAmPMOUT[1]);
            }



            $('.general_attendance_logs').append(to_append);
        }
    });

}

$(document).on('click', '.attendance_general_modal', function()
{
    $('#modal-attendance-general').modal('show');
    $('.attendance_all_click').attr('disabled', true);
    getAttendanceInfoGeneral();
});

$('.attendance_all_click').click(function()
{
    var $type = $(this).attr('what');
    var btn = $(this);

    if($('#attendance_work_start').val() != '' && $('#attendance_work_end').val() != '')
    {
        if(confirm('Are you sure to ' + $type + ' ?'))
        {
            btn.attr('disabled', true);
            $.ajax({
                type: 'get',
                url: 'gen_emp_time_in_and_time_out',
                data: {
                    'type' : $type
                },
                success: function(data)
                {
                    console.log(data);
                    if(data == 'success')
                    {
                        alert($type + ' Captured');
                        getAttendanceInfoGeneral();
                    }
                    else if(data == 'no sched')
                    {
                        alert('Time Failed to Captured Check if the Daily Schedule is already saved then try again.');
                    }
                    btn.attr('disabled', false);
                },
                error: function(e)
                {
                    btn.attr('disabled', false);
                    alert('Error occured contact web dev for assistance. Thank you.');
                }
            });
        }
    }
    else
    {
        alert('Specify your schedule in the fields above. Thank you');
    }
});

$('#save_attendance_schedule').click(function()
{
    var btn = $(this);
    var InChecker = parseInt($('.time_in_class_val[name = "0"]').val());
    var OutChecker = parseInt($('.time_out_class_val[name = "0"]').val());

    if(InChecker != 0 && OutChecker != 0)
    {
        if($('#attendance_work_start').val() != '' && $('#attendance_work_end').val() != '')
        {
            if(confirm('Are you sure to update your daily schedule?'))
            {
                btn.attr('disabled', true);
                $.ajax({
                    type: 'get',
                    url: 'gen_save_daily_work_sched',
                    data:{
                        'work_start' :$('#attendance_work_start').val(),
                        'work_end' :$('#attendance_work_end').val()
                    },
                    success: function(data)
                    {
                        console.log(data);
                        alert('Daily Schedule Updated Successfully');
                        getAttendanceInfoGeneral();
                        btn.attr('disabled', false);
                    },
                    error: function(e)
                    {
                        btn.attr('disabled', false);
                        alert('Error occured contact web dev for assistance. Thank you.');
                    }
                });
            }
        }
        else
        {
            alert('Fill the required fields');
        }
    }
    else
    {
        alert('Invalid Inputted Time');
    }


});

$('.time_in_class_val').change(function()
{
    var timeVal = '';
    var timeVal1 = parseInt($('.time_in_class_val[name = "0"]').val());
    var timeVal2 = parseInt($('.time_in_class_val[name = "1"]').val());
    var timeVal3 = $('.time_in_class_val[name = "2"]').val();

    if(timeVal1 > 0)
    {
        if(timeVal1 <= 9)
        {
            timeVal1 = '0'+timeVal1;
        }
        else if(timeVal1 > 12)
        {
            alert('Invalid Inputted Hour');
            timeVal1 = '08'
        }
    }
    else
    {
        alert('Invalid Inputted Hour');
    }


    if(timeVal2 <= 9)
    {
        timeVal2 = '0'+timeVal2;
    }

    $('.time_in_class_val[name = "0"]').val(timeVal1);
    $('.time_in_class_val[name = "1"]').val(timeVal2);
    $('.time_in_class_val[name = "2"]').val(timeVal3);

    timeVal = timeVal1 + ':' + timeVal2 + ' ' + timeVal3;

    $('#attendance_work_start').val(timeVal);
    // console.log(timeVal);
});

$('.time_out_class_val').change(function()
{
    var timeVal = '';
    var timeVal1 = parseInt($('.time_out_class_val[name = "0"]').val());
    var timeVal2 = parseInt($('.time_out_class_val[name = "1"]').val());
    var timeVal3 = $('.time_out_class_val[name = "2"]').val();

    if(timeVal1 > 0)
    {
        if(timeVal1 <= 9)
        {
            timeVal1 = '0'+timeVal1;
        }
        else if(timeVal1 > 12)
        {
            alert('Invalid Inputted Hour');
            timeVal1 = '08'
        }
    }
    else
    {
        alert('Invalid Inputted Hour');

    }

    if(timeVal2 <= 9)
    {
        timeVal2 = '0'+timeVal2;
    }

    $('.time_out_class_val[name = "0"]').val(timeVal1);
    $('.time_out_class_val[name = "1"]').val(timeVal2);
    $('.time_out_class_val[name = "2"]').val(timeVal3);

    timeVal = timeVal1 + ':' + timeVal2 + ' ' + timeVal3;

    $('#attendance_work_end').val(timeVal);
    // console.log(timeVal);
});

$('.gen_att_tabs').click(function()
{
    var id = $(this).attr('href');
    var check = $(this).attr('loaded');

    if(id == '#gen_att_tab2')
    {
        $('.attendance_all_click').hide();
        // getAttendanceInfoGeneralAll();
    }
    else
    {
        $('.attendance_all_click').show();
    }
    console.log(id);
});

function getAttendanceInfoGeneralAll()
{
    $('.general_attendance_logs_all tr').each(function()
    {
        if($(this).attr('style') != 'background-color: black; color:white;')
        {
            $(this).remove();
        }
    });

    $.ajax({
        type: 'get',
        url: 'gen_attendance_in_out_check',
        data: {
            'date_inputted' : $('#attendance_log_all_input').val()
        },
        success: function (data)
        {
            var to_append = '';
            // console.log(data);
            if(data[0].length > 0)
            {
                var dateFormater = '';
                var timeFormater = '';
                for(var i = 0; i < data[0].length; i++)
                {
                    dateFormater = new Date(data[0][i].created_at).toDateString();
                    to_append += '<tr>\n' +
                        '<td>'+dateFormater+'</td>\n' +
                        '<td>'+DisplayCurrentTime(data[0][i].time_in)+'</t>\n' +
                        '<td>'+data[0][i].type+'</td>\n' +
                        '</tr>';
                }
            }
            else
            {
                to_append = '<tr>\n' +
                    '<td colspan="3">NO RECORDS FOUND</td>\n' +
                    '</tr>'
            }

            $('.general_attendance_logs_all').append(to_append);
        }
    });
}

$('#refresh_atten_logs').click(function()
{
    getAttendanceInfoGeneralAll();
});

function DisplayCurrentTime(testDateTime) {
    var date = new Date(testDateTime);
    var hours = date.getHours() > 12 ? date.getHours() - 12 : date.getHours();
    var am_pm = date.getHours() >= 12 ? "PM" : "AM";
    hours = hours < 10 ? "0" + hours : hours;
    var minutes = date.getMinutes() < 10 ? "0" + date.getMinutes() : date.getMinutes();
    var seconds = date.getSeconds() < 10 ? "0" + date.getSeconds() : date.getSeconds();
    time = hours + ":" + minutes + ":" + seconds + " " + am_pm;

    return time;
}