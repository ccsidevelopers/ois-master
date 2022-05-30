var table_accounts;
var title_accounts = [];
var title_accounts_counts = 0;
var table_acknowledge;
var title_acknowledge = [];
var title_acknowledge_counts = 0;
var table_return;
var title_returns = [];
var title_return_counts = 0;
var endorseID;
var table_finished;
var title_finished_h = [];
var title_finished_counts = 0;
var activeAcc = 'tab_a';
var cc_sao_new = true;
var cc_sao_ack = false;
var cc_sao_assigned = false;
var cc_sao_success = false;
var cc_sao_ret = false;
var cc_sao_fin = false;
var cc_sao_cancel = false;
var cc_sao_hold = false;

var countSendFinished = false;
var assignTeleId;
var accAckId;
var title_tele = [];
var table_tele_success;
var title_tele_counts = 0;
var account_id_ack;
var returnStat = false;

var table_general_search;
var title_general_search = [];
var title_general_search_counts = 0;

var activeSide = 'cc_sao_dash';
var sao_side_dash = false;
var sao_side_acct = true;
var sao_side_search = false;
var sao_gen_mon = false;

var table_assigned;
var title_assigned = [];
var title_assigned_counts = 0;

var table_cancel;
var title_cancel = [];
var title_cancel_counts = 0;

var table_hold;
var title_hold = [];
var title_hold_counts = 0;

var originalTeleEncoder;
var transferAssigned;
var transferName;
var checkAssigned = false;

var globalIDReturn;
var returnToTeleID;
var statusForReturn;

var clientTypeAuth;

var title_general_mon = [];
var general_mon_count = 0;
var table_general_mon;

$.ajaxSetup
({
    headers:
        {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
});


function refTables()
{
    if(cc_sao_new == true)
    {
        table_accounts.ajax.reload(null, false);
    }
    if(cc_sao_ack == true)
    {
        table_acknowledge.ajax.reload(null, false);
    }
    if(cc_sao_ret == true)
    {
        table_return.ajax.reload(null, false);
    }
    if(cc_sao_fin == true)
    {
        table_finished .ajax.reload(null, false);
    }
    if(cc_sao_assigned == true)
    {
        table_assigned.ajax.reload(null, false);
    }
    if(cc_sao_success == true)
    {
        table_tele_success.ajax.reload(null, false);
    }
    if(cc_sao_cancel == true)
    {
        table_cancel.ajax.reload(null, false);
    }
    // if(cc_sao_hold == true)
    // {
    //     table_hold.ajax.reload(null, false);
    // }
}

$.ajax
({
    type : 'get',
    url : 'cc-sao-get-client-type',
    success : function (data)
    {
        if(data == 'cc_bank')
        {
            clientTypeAuth = 'bank';
        }
        else
        {
            clientTypeAuth = 'cc';
        }

        get_accounts_table();

        $('.cc_sao_class_tab').click(function ()
        {
            var gethref = $(this).attr('href');
            console.log(gethref);
            if (gethref == '#tab_a') {

                if ($('' + gethref + '').hasClass('active')) {
                    console.log('do nothing');
                    activeAcc = 'tab_a';
                }
                else if (cc_sao_new) {
                    console.log('already loaded');
                    activeAcc = 'tab_a';
                }
                else if (cc_sao_new == false) {
                    cc_sao_new = true;
                    activeAcc = 'tab_a';
                }
            }
            else if (gethref == '#tab_b') {
                if ($('' + gethref + '').hasClass('active')) {
                    console.log('do nothing');
                    activeAcc = 'tab_b';
                }
                else if (cc_sao_ack) {
                    console.log('already loaded');
                    activeAcc = 'tab_b';

                }
                else if (cc_sao_ack == false) {
                    cc_sao_ack = true;
                    activeAcc = 'tab_b';
                    get_acknowledge_table();
                }
            }
            else if (gethref == '#tab_c') {
                if ($('' + gethref + '').hasClass('active')) {
                    console.log('do nothing');
                    activeAcc = 'tab_c';
                }
                else if (cc_sao_assigned)
                {
                    if(checkAssigned == true)
                    {
                        table_assigned.ajax.reload(null, false);
                        checkAssigned = false;
                    }
                    console.log('already loaded');
                    activeAcc = 'tab_c';

                }
                else if (cc_sao_assigned == false) {
                    cc_sao_assigned = true;
                    activeAcc = 'tab_c';
                    get_assigned_table();
                }
            }
            else if (gethref == '#tab_d') {
                if ($('' + gethref + '').hasClass('active')) {
                    console.log('do nothing');
                    activeAcc = 'tab_d';
                }
                else if (cc_sao_success) {
                    console.log('already loaded');
                    activeAcc = 'tab_d';

                }
                else if (cc_sao_success == false) {
                    cc_sao_success = true;
                    activeAcc = 'tab_c';
                    teleSuccess();
                }
            }
            else if (gethref == '#tab_e') {
                if ($('' + gethref + '').hasClass('active')) {
                    console.log('do nothing');
                    activeAcc = 'tab_e';
                }
                else if (cc_sao_ret) {
                    if(returnStat == true)
                    {
                        table_return.ajax.reload(null, false);
                        returnStat = false;
                    }
                    else
                    {
                        console.log('already loaded');
                    }
                    activeAcc = 'tab_e';
                }
                else if (cc_sao_ret == false) {
                    cc_sao_ret = true;
                    activeAcc = 'tab_e';
                    get_return_table();
                }
            }
            else if (gethref == '#tab_f') {
                if ($('' + gethref + '').hasClass('active')) {
                    console.log('do nothing');
                    activeAcc = 'tab_f';
                }
                else if (cc_sao_fin) {
                    if(countSendFinished == true)
                    {
                        table_finished.ajax.reload(null, false);
                        countSendFinished = false;
                    }
                    console.log('already loaded');
                    activeAcc = 'tab_f';

                }
                else if (cc_sao_fin == false) {
                    cc_sao_fin = true;
                    activeAcc = 'tab_f';
                    cc_table_finished()
                }
            }
            else if (gethref == '#tab_g') {
                if ($('' + gethref + '').hasClass('active')) {
                    console.log('do nothing');
                    activeAcc = 'tab_g';
                }
                else if (cc_sao_cancel) {
                    if(counterCancel == true)
                    {
                        table_cancel.ajax.reload(null , false);
                        counterCancel = false;
                    }
                    else
                    {
                        console.log('already loaded');
                    }
                    activeAcc = 'tab_g';

                }
                else if (cc_sao_cancel == false) {
                    cc_sao_cancel = true;
                    activeAcc = 'tab_g';
                    getCancel();
                }
            }
            else if (gethref == '#tab_h') {
                if ($('' + gethref + '').hasClass('active')) {
                    console.log('do nothing');
                    activeAcc = 'tab_h';
                }
                else if (cc_sao_hold) {
                    if(counterHold == true)
                    {
                        table_hold.ajax.reload(null, false);
                        counterHold = false;
                    }
                    else
                    {
                        console.log('already loaded');
                    }
                    activeAcc = 'tab_h';
                }
                else if (cc_sao_hold == false) {
                    cc_sao_hold = true;
                    activeAcc = 'tab_h';
                    getHold();
                }
            }
        });

        $('.cc_sao_side_class').click(function ()
        {
            var gethref = $(this).attr('href');
            console.log(gethref);
            if (gethref == '#cc_sao_dash') {

                if ($('' + gethref + '').hasClass('active')) {
                    console.log('do nothing');
                    activeSide = 'cc_sao_dash';
                }
                else if (sao_side_dash) {
                    console.log('already loaded');
                    activeSide = 'cc_sao_dash';
                }
                else if (sao_side_dash == false) {
                    sao_side_dash = true;
                    activeSide = 'cc_sao_dash';
                }
            }
            else if (gethref == '#cc_sao_accounts') {
                if ($('' + gethref + '').hasClass('active')) {
                    console.log('do nothing');
                    activeSide = 'cc_sao_accounts';
                }
                else if (sao_side_acct) {
                    console.log('already loaded');
                    activeSide = 'cc_sao_accounts';
                }
                else if (sao_side_acct == false) {
                    sao_side_acct = true;
                    activeSide = 'cc_sao_accounts';
                }
            }
            else if (gethref == '#cc_sao_general_search')
            {
                if ($('' + gethref + '').hasClass('active')) {
                    console.log('do nothing');
                    activeSide = 'cc_sao_general_search';
                }
                else if (sao_side_search) {
                    console.log('already loaded');
                    activeSide = 'cc_sao_general_search';
                }
                else if (sao_side_search == false) {
                    sao_side_search = true;
                    activeSide = 'cc_sao_general_search';
                    getGeneralsearch();
                }
            }
            else if (gethref == '#cc_sao_general_mon')
            {
                if ($('' + gethref + '').hasClass('active')) {
                    console.log('do nothing');
                    activeSide = 'cc_sao_general_mon';
                }
                else if (sao_gen_mon) {
                    console.log('already loaded');
                    activeSide = 'cc_sao_general_mon';
                }
                else if (sao_gen_mon == false) {
                    sao_gen_mon = true;
                    activeSide = 'cc_sao_general_mon';
                    get_general_mon_table()
                }
            }
        });

        $('#cc_sao_success_table').on('click', '.btn_send_report_mod', function()
        {
            endorseID = $(this).attr('id');
            $('#modal-cc-sao-send-report').modal({backdrop:'static'});

            if(clientTypeAuth == 'bank')
            {
                $('.ccOps').remove();
            }
            else if(clientTypeAuth == 'cc')
            {
                $('.bankOps').remove();
            }

        });
    }
});

function get_accounts_table()
{
    $('#cc_sao_accounts_table thead th').each(function() {
        title_accounts[title_accounts_counts] = $(this).text();
        title_accounts_counts++;
        var title = $(this).text();
        $(this).html(title+'<br><input type="text" placeholder="Search" style="position: relative; width: 100%">');
    });

    table_accounts = $('#cc_sao_accounts_table').DataTable
    ({
        "responsive": true,
        "processing": true,
        "serverSide": true,
        "ajax" : 'cc_sao_get_table_accounts',
        // "ajax":
        //     {
        //         url: "/client-get-finish-account",
        //         data: function (d)
        //         {
        //             d.min_date_endorsed = $('#minFinish').val();
        //             d.max_date_endorsed = $('#maxFinish').val();
        //         }
        //     },
        dom: 'Blfrtip',
        buttons:
            [
                {
                    extend: 'excel',
                    exportOptions:
                        {
                            columns: ':visible',
                            format:
                                {
                                    header:  function (dt, idx, title)
                                    {
                                        return title_accounts[(idx)];
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
                    columnText: function (dt, idx, title)
                    {
                        return title_accounts[(idx)];
                    }
                }
            ],
        "columns":
            [
                {data: 'endorse_id', name: 'bi_endorsements.id'},
                {data: 'site', name: 'bi_endorsements.bi_account_name'},
                {data: 'tor', name: 'bi_endorsements.type_of_endorsement_bank'},
                {
                    data : function d_t(data)
                    {
                        var date_time = data.date_time_endorsed;

                        var split = date_time.split(' ');

                        var time = split[1].split(':');

                        var final = time[0] + ':' + time[1];

                        return split[0] + ' ' +final;
                    },
                    name : 'bi_endorsements.created_at'
                },
                {data: 'project', name: 'bi_endorsements.project'},
                {data: 'account_name', name: 'bi_endorsements.account_name'},
                {data: 'package', name: 'bi_endorsements.package'},
                {data: 'check', name: 'bi_endorsements.id', 'searchable' : false, 'orderable' : false},
                {data: 'poc', name: 'bi_endorsements.endorser_poc'},
                {data: 'attachments', name: 'bi_endorsements.attach_1'},
                {
                    data : function action(data) {

                        if(data.status == 0)
                        {
                            return '<a class="btn btn-xs btn-danger btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-envelope"></i> New Endorsement</a>';
                        }
                        else if (data.status == 21)
                        {
                            return '<a class="btn btn-xs btn-danger btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-envelope"></i> Returned Endorsement</a>';
                        }
                    },
                    'name' : 'bi_endorsements.status',
                    'searchable' : false,
                    'orderable' : false

                },
                {
                    data : function action(data) {

                        var act1 = '';

                        if(data.tat_type == '')
                        {
                            act1 = '<a class="btn_acknowledge btn btn-xs btn-warning btn-block" name="'+data.t_o_e+'" data-toggle="modal" id="'+data.endorse_id+'" data-target="" what="'+data.tor+'"><i class="glyphicon glyphicon-ok"></i> Acknowledge - Complete</a>';
                        }
                        else
                        {
                            act1 = '<a class="btn_acknowledge btn btn-xs btn-warning btn-block" name="'+data.tat_type+'" data-toggle="modal" id="'+data.endorse_id+'" data-target="" what="'+data.tor+'"><i class="glyphicon glyphicon-ok"></i> Acknowledge - Complete</a>';
                        }

                        var act = act1 +
                            // '<a class="btn_hold btn btn-xs bg-orange btn-block" data-toggle="modal" id="'+data.endorse_id+'" data-target="" ><i class="glyphicon glyphicon-minus-sign"></i> Hold Account</a>' +
                            '<a class="btn_cancel btn btn-xs bg-navy btn-block" data-toggle="modal" id="'+data.endorse_id+'" data-target="" name="new"><i class="glyphicon glyphicon-warning-sign"></i> Cancel Account</a>' +
                            '<a class="btn_return btn btn-xs btn-danger btn-block" data-toggle="modal" id="'+data.endorse_id+'" data-target="" name="'+data.status+'"><i class="glyphicon glyphicon-repeat"></i> Return - Incomplete</a>' +
                            '<a class="btn_required_docs btn btn-xs btn-warning btn-block" data-toggle="modal" id="'+data.endorse_id+'" name="'+data.status+'"><i class="glyphicon glyphicon-folder-open"></i> Required Documents</a>' +
                            '<a id="'+data.endorse_id+'" class="btn_view_information_bi btn btn-xs btn-info btn-block" data-toggle="modal" data-target="" ><i class="glyphicon glyphicon-film"></i> View Information</a>';

                        return act;
                    },
                    'name' : 'bi_endorsements.attach_1',
                    'searchable' : false,
                    'orderable' : false
                }
            ],
        // "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull)
        // {
        //     if ( aData.endorsement_status_external == "TAT" )
        //     {
        //         $('td', nRow).css('background-color', '#66ff66');
        //     }
        //     else if(aData.endorsement_status_external == "OVERDUE")
        //     {
        //         $('td', nRow).css('background-color', '#ff9980');
        //     }
        // },
        "order": [[0, 'desc']],
        "pageLength": 10,
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

    $('#cc_sao_accounts_table_filter input').unbind();
    $('#cc_sao_accounts_table_filter input').bind('keyup change',function (e) {

        if($(this).is(':focus'))
        {
            if (e.keyCode == 13) {
                table_accounts.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '') {
                    table_accounts.search($(this).val()).draw();
                }
            }
        }
    });

    if(clientTypeAuth == 'bank')
    {
        table_accounts.column(2).visible(true);
        table_accounts.column(1).visible(false);
        table_accounts.column(6).visible(false);
        table_accounts.column(7).visible(false);
    }
    else if(clientTypeAuth == 'cc')
    {
        table_accounts.column(2).visible(false);
        table_accounts.column(1).visible(true);
        table_accounts.column(6).visible(true);
        table_accounts.column(7).visible(true);
    }


}

function get_acknowledge_table()
{
    $('#cc_sao_acknowledge_table thead th').each(function()
    {
        title_acknowledge[title_acknowledge_counts] = $(this).text();
        title_acknowledge_counts++;
        var title = $(this).text();
        $(this).html(title+'<br><input type="text" placeholder="Search" style="position: relative; width: 100%">');
    });

    table_acknowledge = $('#cc_sao_acknowledge_table').DataTable
    ({
        "responsive": true,
        "processing": true,
        "serverSide": true,
        "ajax" : 'cc_sao_get_table_acknowledge',
        // "ajax":
        //     {
        //         url: "/client-get-finish-account",
        //         data: function (d)
        //         {
        //             d.min_date_endorsed = $('#minFinish').val();
        //             d.max_date_endorsed = $('#maxFinish').val();
        //         }
        //     },
        dom: 'Blfrtip',
        buttons:
            [
                {
                    extend: 'excel',
                    exportOptions:
                        {
                            columns: ':visible',
                            format:
                                {
                                    header:  function (dt, idx, title)
                                    {
                                        return title_acknowledge[(idx)];
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
                    columnText: function (dt, idx, title)
                    {
                        return title_acknowledge[(idx)];
                    }
                }
            ],
        "columns":
            [
                {data: 'endorse_id', name: 'bi_endorsements.id'},
                {data: 'site', name: 'bi_endorsements.bi_account_name'},
                {data: 'bank', name: 'bi_endorsements.type_of_endorsement_bank'},
                {
                    data : function d_t(data)
                    {
                        var date_time = data.date_time_endorsed;

                        var split = date_time.split(' ');

                        var time = split[1].split(':');

                        var final = time[0] + ':' + time[1];

                        return split[0] + ' ' +final;
                    },
                    name : 'bi_endorsements.created_at'
                },
                {data: 'project', name: 'bi_endorsements.project'},
                {data: 'account_name', name: 'bi_endorsements.account_name'},
                {data: 'package', name: 'bi_endorsements.package'},
                {data: 'check', name: 'bi_endorsements.id', 'searchable' : false, 'orderable' : false},
                {data: 'poc', name: 'bi_endorsements.endorser_poc'},
                {data: 'attachments', name: 'bi_endorsements.attach_1'},
                {data: 'stat', name: 'stat', 'searchable' : false, 'orderable' : false},
                {
                    data : function action(data)
                    {

                        var assignStat;

                        if(data.status != 2)
                        {
                            assignStat = '<a class="btn_acknowledge_assign btn btn-xs btn-warning btn-block" data-toggle="modal" id="'+data.endorse_id+'" data-target="" ><i class="glyphicon glyphicon-user"></i> Assign</a>';
                        }
                        else
                        {
                            assignStat = '<a class="btn btn-xs btn-warning btn-block" disabled><i class="glyphicon glyphicon-user"></i> Ongoing Verification</a>';
                        }

                        var assignStat1;

                        var act = assignStat + '<a  id="'+data.endorse_id+'" class="btn_view_information_bi btn btn-xs btn-info btn-block" data-toggle="modal" data-target="" ><i class="glyphicon glyphicon-film"></i> View Information</a>';

                        return act;
                    },
                    'name' : 'bi_endorsements.status',
                    'searchable' : false,
                    'orderable' : false
                }
            ],
        "order": [[0, 'desc']],
        "pageLength": 10,
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

    $('#cc_sao_acknowledge_table_filter input').unbind();
    $('#cc_sao_acknowledge_table_filter input').bind('keyup change',function (e) {

        if($(this).is(':focus'))
        {
            if (e.keyCode == 13) {
                table_acknowledge.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '') {
                    table_acknowledge.search($(this).val()).draw();
                }
            }
        }
    });

    if(clientTypeAuth == 'bank')
    {
        table_acknowledge.column(2).visible(true);
        table_acknowledge.column(1).visible(false);
        table_acknowledge.column(6).visible(false);
        table_acknowledge.column(7).visible(false);
    }
    else if(clientTypeAuth == 'cc')
    {
        table_acknowledge.column(2).visible(false);
        table_acknowledge.column(1).visible(true);
        table_acknowledge.column(6).visible(true);
        table_acknowledge.column(7).visible(true);
    }
}
function get_return_table()
{

    $('#cc_sao_return_table thead th').each(function() {
        title_returns[title_return_counts] = $(this).text();
        title_return_counts++;
        var title = $(this).text();
        $(this).html(title+'<br><input type="text" placeholder="Search" style="position: relative; width: 100%">');
    });

    table_return = $('#cc_sao_return_table').DataTable
    ({
        "responsive": true,
        "processing": true,
        "serverSide": true,
        "ajax" : 'cc_sao_get_table_return',
        // "ajax":
        //     {
        //         url: "/client-get-finish-account",
        //         data: function (d)
        //         {
        //             d.min_date_endorsed = $('#minFinish').val();
        //             d.max_date_endorsed = $('#maxFinish').val();
        //         }
        //     },
        dom: 'Blfrtip',
        buttons:
            [
                {
                    extend: 'excel',
                    exportOptions:
                        {
                            columns: ':visible',
                            format:
                                {
                                    header:  function (dt, idx, title)
                                    {
                                        return title_returns[(idx)];
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
                    columnText: function (dt, idx, title)
                    {
                        return title_returns[(idx)];
                    }
                }
            ],
        "columns":
            [
                {data: 'endorse_id', name: 'bi_endorsements.id'},
                {data: 'site', name: 'bi_endorsements.bi_account_name'},
                {data: 'bank', name: 'bi_endorsements.type_of_endorsement_bank'},
                {
                    data : function d_t(data)
                    {
                        var date_time = data.date_time_endorsed;

                        var split = date_time.split(' ');

                        var time = split[1].split(':');

                        var final = time[0] + ':' + time[1];

                        return split[0] + ' ' +final;
                    },
                    name : 'bi_endorsements.created_at'
                },
                {data: 'project', name: 'bi_endorsements.project'},
                {data: 'account_name', name: 'bi_endorsements.account_name'},
                {data: 'package', name: 'bi_endorsements.package'},
                {data: 'check', name: 'bi_endorsements.id', 'searchable' : false, 'orderable' : false},
                {data: 'poc', name: 'bi_endorsements.endorser_poc'},
                {data: 'attachments', name: 'bi_endorsements.attach_1'},
                {
                    data : function action(data) {

                        if(data.status == 0)
                        {
                            return '<a class="btn btn-xs btn-danger btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-envelope"></i> New Endorsement</a>';
                        }
                        else
                        {
                            if(data.status == 20)
                            {
                                return '<a class="btn btn-xs btn-danger btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-repeat"></i> Returned Upon Endorsement</a>';
                            }
                            else if(data.status == 22)
                            {
                                return '<a class="btn btn-xs btn-warning btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-repeat"></i> Returned During Endorsement</a>';
                            }
                            else if(data.status == 23)
                            {
                                return '<a class="btn btn-xs btn-warning btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-repeat"></i> Returned After Endorsement</a>';
                            }
                        }
                    },
                    'name' : 'bi_endorsements.status',
                    'searchable' : false,
                    'orderable' : false
                },
                {
                    data : function action(data) {
                        var act = '<a class="btn_return_cancel btn btn-xs btn-warning btn-block" data-toggle="modal" id="'+data.endorse_id+'" data-target=""><i class="glyphicon glyphicon-remove"></i> Cancel</a>' +
                            '<a  id="'+data.endorse_id+'" class="btn_view_information_bi btn btn-xs btn-info btn-block" data-toggle="modal" data-target="" ><i class="glyphicon glyphicon-film"></i> View Information</a>';

                        return act;
                    },
                    'name' : 'bi_endorsements.status',
                    'searchable' : false,
                    'orderable' : false
                }
            ],
        // "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull)
        // {
        //     if ( aData.endorsement_status_external == "TAT" )
        //     {
        //         $('td', nRow).css('background-color', '#66ff66');
        //     }
        //     else if(aData.endorsement_status_external == "OVERDUE")
        //     {
        //         $('td', nRow).css('background-color', '#ff9980');
        //     }
        // },
        "order": [[0, 'desc']],
        "pageLength": 10,
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

    $('#cc_sao_return_table_filter input').unbind();
    $('#cc_sao_return_table_filter input').bind('keyup change',function (e) {

        if($(this).is(':focus'))
        {
            if (e.keyCode == 13) {
                table_return.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '') {
                    table_return.search($(this).val()).draw();
                }
            }
        }
    });

    if(clientTypeAuth == 'bank')
    {
        table_return.column(2).visible(true);
        table_return.column(1).visible(false);
        table_return.column(6).visible(false);
        table_return.column(7).visible(false);
    }
    else if(clientTypeAuth == 'cc')
    {
        table_return.column(2).visible(false);
        table_return.column(1).visible(true);
        table_return.column(6).visible(true);
        table_return.column(7).visible(true);
    }

}
function cc_table_finished()
{
    $('#cc_sao_finished_table thead th').each(function() {
        title_finished_h[title_finished_counts] = $(this).text();
        title_finished_counts++;
        var title = $(this).text();
        $(this).html(title+'<br><input type="text" placeholder="Search" style="position: relative; width: 100%">');
    });

    table_finished = $('#cc_sao_finished_table').DataTable
    ({
        "responsive": true,
        "processing": true,
        "serverSide": true,
        "ajax" : 'cc-sao-table-finished',
        // "ajax":
        //     {
        //         url: "/client-get-finish-account",
        //         data: function (d)
        //         {
        //             d.min_date_endorsed = $('#minFinish').val();
        //             d.max_date_endorsed = $('#maxFinish').val();
        //         }
        //     },
        dom: 'Blfrtip',
        buttons:
            [
                {
                    extend: 'excel',
                    exportOptions:
                        {
                            columns: ':visible',
                            format:
                                {
                                    header:  function (dt, idx, title)
                                    {
                                        return title_finished_h[(idx)];
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
                    columnText: function (dt, idx, title)
                    {
                        return title_finished_h[(idx)];
                    }
                }
            ],
        "columns":
            [
                {data: 'endorse_id', name: 'bi_endorsements.id'},
                {data: 'site', name: 'bi_endorsements.bi_account_name'},
                {data: 'bank', name: 'bi_endorsements.type_of_endorsement_bank'},
                {
                    data : function d_t(data)
                    {
                        var date_time = data.date_time_endorsed;

                        var split = date_time.split(' ');

                        var time = split[1].split(':');

                        var final = time[0] + ':' + time[1];

                        return split[0] + ' ' +final;
                    },
                    name : 'bi_endorsements.created_at'
                },
                {data: 'project', name: 'bi_endorsements.project'},
                {data: 'account_name', name: 'bi_endorsements.account_name'},
                {data: 'package', name: 'bi_endorsements.package'},
                {data: 'check', name: 'bi_endorsements.id', 'searchable' : false, 'orderable' : false},
                {data: 'poc', name: 'bi_endorsements.endorser_poc'},
                {data: 'attachments', name: 'bi_endorsements.attach_1'},
                {data: 'status' , name : 'bi_endorsements.status'},
                {
                    data: function contact_details(data)
                    {
                        if(data.tele_stat == 'Contacted')
                        {
                            console.log(data.tele_stat);

                            if(data.contact_details == null || data.contact_details == '')
                            {
                                return 'N/A';
                            }
                            else if(data.contact_details == 'Refused to be interviewed')
                            {
                                return '<p style="font-style: italic">'+data.contact_details+'</p>';
                            }
                            else if(data.contact_details == 'Verified applying')
                            {
                                return '<p style="font-style: italic">'+data.contact_details+'</p>';
                            }
                            else
                            {
                                return '<p style="font-style: italic">'+data.contact_details+'</p>';
                            }
                        }
                        else if(data.tele_stat == 'Uncontacted')
                        {

                            if(data.contact_details == null || data.contact_details == '')
                            {
                                return 'N/A';
                            }
                            else
                            {
                                return '<p style="font-style: italic">'+data.contact_details+'</p>';
                            }
                        }
                        else if(data.tele_stat == 'Verified')
                        {

                            if(data.contact_details == null || data.contact_details == '')
                            {
                                return 'N/A';
                            }
                            else
                            {
                                return '<p style="font-style: italic">'+data.contact_details+'</p>';
                            }
                        }
                        else if(data.tele_stat == 'Unverified')
                        {

                            if(data.contact_details == null || data.contact_details == '')
                            {
                                return 'N/A';
                            }
                            else
                            {
                                return '<p style="font-style: italic">'+data.contact_details+'</p>';
                            }
                        }
                        else
                        {
                            return 'N/A';
                        }
                    },
                    'name': 'bi_endorsements.verify_tele_status_details',
                    'orderable' : false
                },
                {
                    data : function action(data)
                    {
                        var act = '<a class="btn_down_report btn btn-xs btn-success btn-block" id="'+data.endorse_id+'"><i class="fa fa-fw fa-download"></i> Download Report File</a>' +
                            '<a  id="'+data.endorse_id+'" class="btn_view_report_remarks btn btn-xs btn-warning btn-block"><i class="fa fa-fw fa-eye"></i>View Remarks</a>' +
                            '<a  id="'+data.endorse_id+'" class="btn_return_during_tele btn btn-xs btn-danger btn-block" name="'+data.status1+'" data-toggle="modal" data-target=""><i class="glyphicon glyphicon-repeat"></i> Return to Tele</a>'+
                            '<a  id="'+data.endorse_id+'" class="btn_view_information_bi btn btn-xs btn-info btn-block" data-toggle="modal" data-target="" ><i class="glyphicon glyphicon-film"></i> View Information</a>' +
                            '<span id = "downReport"></span>';

                        return act;
                    },
                    'name' : 'bi_endorsements.status',
                    'searchable' : false,
                    'orderable' : false
                }
            ],
        "order": [[0, 'desc']],
        "pageLength": 10,
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

    $('#cc_sao_finished_table_filter input').unbind();
    $('#cc_sao_finished_table_filter input').bind('keyup change',function (e) {

        if($(this).is(':focus'))
        {
            if (e.keyCode == 13) {
                table_finished.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '') {
                    table_finished.search($(this).val()).draw();
                }
            }
        }
    });

    if(clientTypeAuth == 'bank')
    {
        table_finished.column(2).visible(true);
        table_finished.column(1).visible(false);
        table_finished.column(6).visible(false);
        table_finished.column(7).visible(false);
        table_finished.column(11).visible(true);
    }
    else if(clientTypeAuth == 'cc')
    {
        table_finished.column(2).visible(false);
        table_finished.column(1).visible(true);
        table_finished.column(6).visible(true);
        table_finished.column(7).visible(true);
        table_finished.column(11).visible(false);
    }
}

$('.remarksText').hide();

$('#cc_sao_accounts_table').on('click','.btn_return',function ()
{

    $(this).attr("disabled", true);

    $('.test1').attr('checked', false);
    $('.othersCheck').attr('checked', false);
    globalIDReturn = $(this).attr('id');
    statusForReturn = $(this).attr("name");

    $.ajax
    ({
        url: 'cc-sao-return-check-data-upon',
        type: 'post',
        data: {
            'status': statusForReturn
        },
        success: function(data)
        {
            $('#tblCheckings').html(data);

            $('.btn_return').attr("disabled", false);

        },
        complete: function()
        {
            $('.othersCheck').click(function()
            {
                if ($('.othersCheck').is(':checked'))
                {
                    $('.remarksText').show();
                }
                else
                {
                    $('.remarksText').hide();
                }
            });
        }
    });

    $('#modal-return-account').modal('show');
});

$('#cc_sao_success_table').on('click','.btn_return_during',function ()
{
    $('.test1').attr('checked', false);
    $('.othersCheck').attr('checked', false);
    globalIDReturn = $(this).attr('id');
    statusForReturn = $(this).attr("name");
    $('.remarksText').hide();

    $.ajax
    ({
        url: 'cc-sao-return-check-data-upon',
        type: 'post',
        data: {
            'status': statusForReturn
        },
        success: function(data)
        {
            $('#tblCheckings').html(data);

        },
        complete: function()
        {
            $('.othersCheck').click(function()
            {
                if ($('.othersCheck').is(':checked'))
                {
                    $('.remarksText').show();
                }
                else
                {
                    $('.remarksText').hide();
                }
            });
        }
    });

    $('#modal-return-account').modal('show');
});

$('#cc_sao_success_table').on('click','.btn_return_during_tele',function ()
{
    returnToTeleID = $(this).attr("id");

    $('#modal-view-reasonToTele').modal({backdrop:'static'});
    $('#reasonToTele').val('');

});


$('#cc_sao_finished_table').on('click','.btn_return_during_tele',function ()
{
    returnToTeleID = $(this).attr("id");

    $('#modal-view-reasonToTele').modal("show");
    $('#reasonToTele').val('');

});

$('#btnReturnAccountToTele').click(function()
{

    $(this).attr("disabled", true);

    var conditionReturn;
    conditionReturn = confirm("Are you sure you want to return the account to Tele?");

    if(conditionReturn == true)
    {
        $.ajax
        (
            {
                type: 'get',
                url: 'cc-sao-return-to-tele',
                data: {
                    'id': returnToTeleID,
                    'remarks': $('#reasonToTele').val()
                },
                success: function()
                {
                    alert('Success Returning Account to Tele');
                    $('#btnReturnAccountToTele').attr("disabled", false);
                },
                complete: function()
                {
                    $('#modal-view-reasonToTele').modal("hide");
                    refTables();
                }
            }
        );
    }
    else
    {
        $('#btnReturnAccountToTele').attr("disabled", false);
    }
});


var defaultSelectedDate;
var api_endorsement_bool = false;


$('#cc_sao_accounts_table').on('click','.btn_acknowledge',function ()
{
    account_id_ack = $(this).attr('id');
    // $('#api_endorsement').html('');
    var withOrwithout = $(this).attr('name');
    $('#btnTypeofTATProceed').attr('what', $(this).attr('what'));
    $('#modal-type-tat').modal({backdrop: 'static'});
    var date = new Date();
    $('#for_bank_time').hide();

    if(withOrwithout != '-')
    {
        $('#type_tat_acc').val('');
        $('#tat_date_due').val('');
        $('#type_tat_acc').attr('disabled', true);

        $.ajax(
            {
                type : 'get',
                url : 'cc-sao-check-if-sitel',
                data: {
                    'id' : account_id_ack,
                    'tat_type' : withOrwithout
                },
                success: function(data)
                {
                    // console.log(data);
                    var final_date = data[1].date.split(' ');

                    defaultSelectedDate = final_date[0];

                    if(data[0] == '-')
                    {
                        $('#type_tat_acc').val(data[0]).attr('disabled', false);
                    }
                    else
                    {
                        $('#type_tat_acc').val(data[0]).attr('disabled', true);
                    }

                    if(data[2] != '')
                    {
                        $('#for_bank_time').show();
                        $('#cc_bank_tat').hide();
                    }
                    else
                    {
                        $('#for_bank_time').hide();
                        $('#cc_bank_tat').show();
                    }

                    if(data[3] == 'through api')
                    {
                        // console.log('through api');

                        api_endorsement_bool = true;
                        var optionsss = '';
                        var checkissss = '';

                        $.ajax({
                            type: 'get',
                            url: 'cc_sao_get_bi_checkings',
                            data: {
                                'id' : account_id_ack
                            },
                            success: function(data2)
                            {
                                // console.log(data2);

                                var checking_name = [];
                                var checking_id = [];
                                $.each(data2[1], function(i, data_chunks){
                                    if($.inArray(data_chunks.chck_name, checking_name) === -1) checking_name.push(data_chunks.chck_name),checking_id.push(data_chunks.pck_id);
                                });

                                // console.log([checking_name, checking_id]);

                                for(var ctr = 0; ctr < checking_name.length; ctr++)
                                {
                                    checkissss += '<div class="form-group">\n' +
                                        '                                                    <label for="check-'+ctr+'" title="'+checking_name[ctr]+'">\n' +
                                        '                                                        <input type="checkbox" id="check-'+ctr+'" class="checkAck" name="'+checking_id[ctr]+'" value="'+checking_name[ctr]+'"> '+checking_name[ctr]+'\n' +
                                        '                                                    </label>\n' +
                                        '                                                </div>';
                                }
                                for(var i = 0; i < data2[0].length; i++)
                                {
                                    optionsss += '<option value="'+data2[0][i].id+'">'+data2[0][i].pck_name+'</option>';
                                }

                                $('#api_endorsement').html('<br><label for="">Client Remarks: </label><textarea class="form-control" rows="5" style="resize: none;" value="'+data2[0][0].rem+'" disabled>'+data2[0][0].rem+'</textarea>' +
                                    '<br>\n' +
                                    '                                                <label for="">Select Package :</label><br>\n' +
                                    '                                                <small style="color: red; font-weight: bold">*Required field</small>\n' +
                                    '                                                <select class="form-control" id="bi_checkings">\n' +
                                    '                                                    <option value="-">-</option>' +
                                    '                                                    '+optionsss+'\n' +
                                    '                                                </select>');

                                $('#api_endorsement_alacarte').html('<label for="">Select Other Checkings/Alacarte :</label><br><p style="color: red;" class="small"><strong>*Required field</strong></p>' +checkissss+ '');
                            }
                        });
                    }
                    else
                    {
                        $('#api_endorsement').html('');
                        $('#api_endorsement_alacarte').html('');
                    }

                    $('#tat_date_due').val(final_date[0]);
                    
                    $('#tat_time_due').val(data[4]);
                }
            }
        );
    }
    else if(withOrwithout == '-')
    {
        $('#type_tat_acc').attr('disabled', false);
        $('#type_tat_acc').val('-');
        $('#tat_date_due').val('----/--/--');
        $('#modal-type-tat').modal('show');
    }
    else
    {
        $('#type_tat_acc').attr('disabled', false);
        $('#type_tat_acc').val('-');
        $('#tat_date_due').val('----/--/--');
        $('#modal-type-tat').modal('show');
    }
});

$('#modal-type-tat').on('change', '#bi_checkings', function()
{
    var val = $(this).val();

    $('.checkAck').each(function()
    {
        $(this).attr('checked', false);
        $(this).removeAttr('what');
    });

    setTimeout(function()
    {
        $.ajax({
            type: 'get',
            url: 'cc_sao_get_selected_packages_checkings',
            data: {
                'id' : val
            },
            success : function(data)
            {
                // console.log(data);

                $('.checkAck').each(function()
                {
                    var checkThisBool = false;

                    for(var i = 0; i < data[0].length; i++)
                    {
                        if($(this).val() == data[0][i].chk_name)
                        {
                            checkThisBool = true;
                            i = data.length + 1;
                        }
                    }

                    if(checkThisBool)
                    {
                        $(this).prop('checked', true);
                        $(this).attr('what', 'package');
                    }
                    else
                    {
                        $(this).prop('checked', false);
                        $(this).attr('what', 'alacarte');
                    }
                });
            }
        });
    }, 100);
});

$('#cc_sao_return_table').on('click','.btn_return_cancel',function ()
{
    var btn = $(this);
    var id = $(this).attr('id');

    var remarks = prompt("Your Remarks:",'-');
    if (remarks == null || remarks == "")
    {

    }
    else
    {
        btn.attr('disabled', true);
        $.ajax({

            url : 'cc_sao_cancel_account',
            type : 'get',
            data : {
                'id' : id,
                'remarks' : remarks
            },
            success : function (data) {
                if(data == 'ok')
                {
                    alert('Success!');
                    table_accounts.ajax.reload(null, false);
                    table_return.ajax.reload(null, false);
                    getDash();
                }
                else
                {
                    alert('Already cancelled by someone. Please see logs.');
                    table_accounts.ajax.reload(null, false);
                    table_return.ajax.reload(null, false);
                }

                $('.btn_return_cancel').attr("disabled", false);
                btn.attr('disabled', false);
            },
            error : function () {
                console.log('error');
            }
        });
    }

});

$('#cc_sao_acknowledge_table').on('click','.btn_acknowledge_assign',function () {

    accAckId = $(this).attr('id');
    var i;
    var names;

    $.ajax
    ({
        type: 'get',
        url: 'cc-sao-get-tele',
        success: function (data)
        {
            console.log(data);

            for(i = 0; i < data.length; i++)
            {
                names += '<option value = "'+ data[i][0] +'">'+ data[i][1] +'  (Assigned Account/s : '+data[i][2]+ ')</option>'
            }

            $('#assign_tele_encoder').html('<option value = "-">-</option>' + names);
        }
    });

    $('#modal-cc-sao-assign').modal({backdrop: 'static'});
});

$('#assign_tele_encoder').change(function()
{
    var id_assign = $(this).find(':selected').val();

    if(id_assign != '-' || id_assign != null)
    {
        assignTeleId = id_assign;
    }
    else
    {
        assignTeleId = null;
    }
});

$('#btn_assign_to_tele').click(function()
{
    var btn = $('#btn_assign_to_tele');
    btn.attr('disabled', true);
    var testinglang = 'dist/img/loading.gif';

    if(assignTeleId == null)
    {
        alert('Please select a Tele-encoder!');
        $('#btn_assign_to_tele').attr("disabled", false);
    }
    else
    {
        $('#loadingAssign').html('<img src="'+testinglang+'" alt="" width="3%">');

        $.ajax
        ({
            type : 'get',
            url : 'cc-sao-assign-tele',
            data :
                {
                    'acc_id' : accAckId,
                    'tele_id' : assignTeleId
                },
            success : function(data)
            {
                if(data == 'ok')
                {
                    alert('Success!');
                }
                else if(data == 'already')
                {
                    alert('Account already assigned to Televerifier');
                }
                else if(data == 'invalid')
                {
                    alert('Account assigning to Tele Failed. Refresh the table and try again');
                }
                $('#modal-cc-sao-assign').modal('hide');
            },
            complete: function(){
                btn.attr('disabled', false);
                $('#loadingAssign').html('');
                refTables();
            }
        });
    }
});



$('#cc_sao_send_report').click(function()
{
    var testinglang = 'dist/img/loading.gif';

    $(this).attr("disabled", true);
    var reportFile = $('#cc_sao_send_file_report').prop('files')[0];
    var reportRemarks = $('#cc_sao_report_remarks').val();
    var reportStat = $('#cc_sao_report_status').val();
    console.log(endorseID);

    var formData = new FormData();
    formData.append('reportFile', reportFile);
    formData.append('reportRemarks', reportRemarks);
    formData.append('reportStat', reportStat);
    formData.append('endorseID', endorseID);

    if(reportFile != null)
    {
        $('#loadingSend').html('<img src="'+testinglang+'" alt="" width="3%">');

        $.ajax
        ({
            xhr: function()
            {
                var xhr = new window.XMLHttpRequest();
                //Upload progress
                xhr.upload.addEventListener("progress", function(evt)
                {
                    if (evt.lengthComputable) {
                        var percentComplete = evt.loaded / evt.total;
                        //Do something with upload progress
                        $('#ulPercentage_sao').html('');
                        // $('#ulPercentage').append(percentComplete*100);
                        $('#ulPercentage_sao').append(Math.floor(percentComplete*100));
                        $('#progressbar_sao').show();
                        $('#progressbar_sao').progressbar
                        (
                            {
                                value: percentComplete * 100
                            }
                        )
                    }
                }, false);
                //Download progress
                xhr.addEventListener("progress", function(evt)
                {
                    if (evt.lengthComputable) {
                        var percentComplete = evt.loaded / evt.total;
                        //Do something with download progress
                        console.log(percentComplete);
                    }
                }, false);
                return xhr;
            },
            type: 'post',
            url: 'cc-sao-send-report',
            contentType: false,
            processData: false,
            async: true,
            data: formData,
            beforeSend: function()
            {
                $('#modal-loading').show();
            },
            success : function(data)
            {
                if(data == 'ok')
                {
                    alert('Successfully Sent Report!');
                    $('#ulPercentage_sao').html('--');
                    $('#progressbar_sao').progressbar('option', 'value', 0);
                    $('#progressbar_sao').hide();
                    $('#cc_sao_report_remarks').val('');
                    $('#cc_sao_send_file_report').val('');
                    $('#modal-cc-sao-send-report').modal('hide');
                    getDash();
                }
                else
                {
                    alert('Account already finished!');
                    $('#ulPercentage_sao').html('--');
                    $('#progressbar_sao').progressbar('option', 'value', 0);
                    $('#progressbar_sao').hide();
                    $('#cc_sao_report_remarks').val('');
                    $('#cc_sao_send_file_report').val('');
                    $('#modal-cc-sao-send-report').modal('hide');
                }
                $('#cc_sao_send_report').attr("disabled", false);
            },
            complete: function()
            {
                $('#modal-loading').hide();
                $('#loadingSend').html('');
                refTables();
            }
        });


    }
    else
    {
        alert('Please input report file.');
        $('#cc_sao_send_report').attr("disabled", false);
    }

});

$('#cc_sao_finished_table').on('click', '.btn_view_report_remarks', function()
{
    $(this).attr("disabled", true);
    var id = $(this).attr('id');
    $.ajax
    ({
        type : 'get',
        url : 'cc-sao-view-remarks',
        data:
            {
                'id' : id
            },
        success : function(data)
        {
            $('#cc_sao_view_report_remarks').val(data);
            $('#modal-cc-view-report').modal('show');
            $('.btn_view_report_remarks').attr("disabled", false);
        },
        error: function()
        {
            $('.btn_view_report_remarks').attr("disabled", false);
        }
    });
});
$('#cc_sao_finished_table').on('click', '.btn_down_report', function()
{
    var id = $(this).attr('id');

    var id_encode = btoa(id);
    var q = '<form action="/cc-sao-dl-report" target="_blank" method="get">'+
        '<div class="input-group">'+
        '<input type="text" hidden value="'+id_encode+'" name="id">'+
        '<button type="submit" hidden id="button_rep_download" >'+
        '</button>'+
        '</span>'+
        '</div>'+
        '</form>';

    $('#downReport').html(q);
    $('#button_rep_download').click();
    $('#downReport').hide();
});



var tat_stat;
$('#type_tat_acc').change(function()
{
    tat_stat = $(this).find(':selected').val();

    var numberOfDaysToAdd;
    var dd;
    var mm;
    var yyyy;
    var today = new Date();
    var minutes = today.getMinutes();
    var hours = today.getHours();
    var seconds = today.getSeconds();
    if(minutes < 10)
    {
        minutes = '0'+minutes;
    }

    var test1 = hours-12+':'+minutes+' PM';
    var test2 = hours+':'+ minutes + ' AM';

    var test11 = hours+':'+minutes+''+':'+seconds;




    if(tat_stat == 'Regular 7' || tat_stat == 'Regular')
    {
        numberOfDaysToAdd = 7;
        today.setDate(today.getDate() + numberOfDaysToAdd);
        dd = today.getDate();
        mm = today.getMonth()+1; //January is 0!
        yyyy = today.getFullYear();

        if(dd<10) {
            dd = '0'+dd
        }

        if(mm<10) {
            mm = '0'+mm
        }

        today = yyyy + '-' + mm + '-' + dd;


        if(hours >= 10)
        {
            if(hours > 12)
            {
                $('#tat_time_due').val('0'+test1);
            }
            else
            {
                $('#tat_time_due').val(test2);
            }
        }

        $('#tat_date_due').val(today);

    }
    else if(tat_stat == 'Regular 5')
    {
        numberOfDaysToAdd = 5;
        today.setDate(today.getDate() + numberOfDaysToAdd);
        dd = today.getDate();
        mm = today.getMonth()+1; //January is 0!
        yyyy = today.getFullYear();

        if(dd<10) {
            dd = '0'+dd
        }

        if(mm<10) {
            mm = '0'+mm
        }

        today = yyyy + '-' + mm + '-' + dd;


        if(hours >= 10)
        {
            if(hours > 12)
            {
                $('#tat_time_due').val('0'+test1);
            }
            else
            {
                $('#tat_time_due').val(test2);
            }
        }

        $('#tat_date_due').val(today);

    }
    else if(tat_stat == 'Expedite')
    {
        numberOfDaysToAdd = 3;
        today.setDate(today.getDate() + numberOfDaysToAdd);
        dd = today.getDate();
        mm = today.getMonth()+1; //January is 0!
        yyyy = today.getFullYear();

        if(dd<10) {
            dd = '0'+dd
        }

        if(mm<10) {
            mm = '0'+mm
        }

        today = yyyy + '-' + mm + '-' + dd;

        if(hours >= 10)
        {
            if(hours > 12)
            {
                $('#tat_time_due').val('0'+test1);
            }
            else
            {
                $('#tat_time_due').val(test2);
            }
        }

        $('#tat_date_due').val(today);

    }
    else if(tat_stat == 'Custom')
    {
        $('#tat_date_due').val('');
        $('#tat_time_due').val('');
    }
    else
    {
        $('#tat_date_due').val('');
        $('#tat_time_due').val('');
    }
});

$('#btnTypeofTATProceed').click(function()
{
    var what_to_sub = '';
    var btn = $(this);
    time_due = $('#tat_time_due').val();
    TATType = $('#type_tat_acc').val();
    date_due =$('#tat_date_due').val();

    var ctr =0;

    if($(this).attr('what') == '')
    {
        what_to_sub = 'cc';

        // FOR INPUT VALIDATION IF NULL
        if(date_due != '----/--/--')
        {
            ctr = ctr + 1
        }

        if(date_due == '')
        {
            ctr = ctr - 1;
        }

        if(TATType != '')
        {
            ctr = ctr + 1;
        }

        if(TATType == '-')
        {
            ctr = ctr - 1;
        }

        if(ctr == 2)
        {
            btn.attr("disabled", true);
            acknowledgewithandwithout(btn, what_to_sub, time_due);
            if(api_endorsement_bool)
            {
                var ack_package = $('#bi_checkings').children('option:selected').text();
                var check_array = [];
                var check_ctr = 0;

                if(ack_package == '-')
                {
                    alert('Add checkings/Select package to proceed');
                }
                else
                {
                    $('.checkAck').each(function()
                    {
                        check_array[check_ctr] = [];

                        if($(this).is(':checked'))
                        {
                            check_array[check_ctr][0] = $(this).val();
                            check_array[check_ctr][1] = $(this).attr('what');
                            check_ctr++;
                        }
                    });


                    $.ajax({
                        type: 'get',
                        url: 'cc_sao_add_checking_packages_api_endo',
                        data:{
                            'id' : account_id_ack,
                            'check_array' : check_array,
                            'package' : ack_package
                        },
                        success : function(data)
                        {
                            if(data == 'ok')
                            {
                                alert('Account successfully acknowledge and added checks/package');
                                table_acknowledge.draw();
                            }
                        }
                    })
                }
            }
        }
        else
        {
            alert('Please fillup the required fields');
            $('#btnTypeofTATProceed').attr("disabled", false);
        }
    }
    else
    {
        what_to_sub = 'cc_bank';

        if($('#tat_date_due').val() != '')
        {
            btn.attr("disabled", true);
            acknowledgewithandwithout(btn, what_to_sub, time_due);
        }
        else
        {
            alert('Please fillup the required fields');
            $('#btnTypeofTATProceed').attr("disabled", false);
        }
    }

    $('#loadingAck').html('');

    // console.log('Endorsemnt ID is ' + account_id_ack); //GLOBAL ID

    ctr =0;
});

function acknowledgewithandwithout(btn, typeee, time_due_b)
{
    var testinglang = 'dist/img/loading.gif';

    $('#loadingAck').html('<img src="'+testinglang+'" alt="" width="3%">');

    $.ajax
    ({

        type: 'get',
        url: 'cc_sao_acknowledge_account',
        // url: 'cc-sao-proceed-acknowledge',
        data:
            {
                'stats': 1,
                'id': account_id_ack,
                'time_due': '23:59:59',
                'date_due': date_due,
                'type_tat': TATType,
                'type' : typeee,
                'time_due_bank' : time_due_b
            },
        success: function(data)
        {
           if(data == 'ok')
            {
                alert('Account Successfully Acknowledge');
            }
            else if(data == 'okay')
            {
                alert('Account Successfully Acknowledge and Automatically Assigned to Tele');
            }
            else if(data == 'already')
            {
                alert('Account Already Acknowledged');
            }
        },
        complete: function(){
            $('#loadingAck').html('');
            $('#modal-type-tat').modal('hide');
            refTables();
            btn.attr("disabled", false);
        },
        error: function()
        {
            if(cc_sao_ack == true)
            {
                table_acknowledge.ajax.reload(null, false);
            }
        }
    });
}

function teleSuccess()
{
    $('#cc_sao_success_table thead th').each(function() {
        title_tele[title_tele_counts] = $(this).text();
        title_tele_counts++;
        var title = $(this).text();
        $(this).html(title+'<br><input type="text" placeholder="Search" style="position: relative; width: 100%">');
    });

    table_tele_success = $('#cc_sao_success_table').DataTable
    ({
        "responsive": true,
        "processing": true,
        "serverSide": true,
        "ajax" : 'cc-sao-tele-success-accounts',
        // "ajax":
        //     {
        //         url: "/client-get-finish-account",
        //         data: function (d)
        //         {
        //             d.min_date_endorsed = $('#minFinish').val();
        //             d.max_date_endorsed = $('#maxFinish').val();
        //         }
        //     },
        dom: 'Blfrtip',
        buttons:
            [
                {
                    extend: 'excel',
                    exportOptions:
                        {
                            columns: ':visible',
                            format:
                                {
                                    header:  function (dt, idx, title)
                                    {
                                        return title_tele[(idx)];
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
                    columnText: function (dt, idx, title)
                    {
                        return title_tele[(idx)];
                    }
                }
            ],
        "columns":
            [
                {data: 'endorse_id', name: 'bi_endorsements.id'},
                {data: 'site', name: 'bi_endorsements.bi_account_name'},
                {data: 'bank', name: 'bi_endorsements.type_of_endorsement_bank'},
                {
                    data : function d_t(data)
                    {
                        var date_time = data.date_time_endorsed;

                        var split = date_time.split(' ');

                        var time = split[1].split(':');

                        var final = time[0] + ':' + time[1];

                        return split[0] + ' ' +final;
                    },
                    name : 'bi_endorsements.created_at'
                },
                {data: 'project', name: 'bi_endorsements.project'},
                {data: 'account_name', name: 'bi_endorsements.account_name'},
                {data: 'poc', name: 'bi_endorsements.endorser_poc'},
                {data: 'due', name: 'due', 'searchable' : false, 'orderable' : false},
                {
                    data : function action(data)
                    {
                        if(data.type_user == 'cc_bank')
                        {
                            if(data.status == 3)
                            {
                                if(data.tele_stat == 'Contacted')
                                {
                                    return '<a class="btn btn-xs btn-success btn-block" data-toggle="modal" data-target="" disabled><i class="fa fa-fw fa-check-circle-o"></i> '+data.tele_stat+'</a>';
                                }
                                else
                                {
                                    return '<a class="btn btn-xs btn-warning btn-block" data-toggle="modal" data-target="" disabled><i class="fa fa-fw fa-hand-paper-o"></i> '+data.tele_stat+'</a>';
                                }
                            }
                            else if(data.status == 24)
                            {
                                if(data.tele_stat == 'Contacted')
                                {
                                    return '<a class="btn btn-xs btn-success btn-block" data-toggle="modal" data-target="" disabled><i class="fa fa-fw fa-check-circle-o"></i> '+data.tele_stat+'</a>';
                                }
                                else
                                {
                                    return '<a class="btn btn-xs btn-warning btn-block" data-toggle="modal" data-target="" disabled><i class="fa fa-fw fa-hand-paper-o"></i> '+data.tele_stat+'</a>';
                                }
                            }
                        }
                        else
                        {
                            if(data.status == 3)
                            {
                                if(data.tele_stat == 'Complete')
                                {
                                    return '<a class="btn btn-xs btn-success btn-block" data-toggle="modal" data-target="" disabled><i class="fa fa-fw fa-check-circle-o"></i> Complete</a>';
                                }
                                else
                                {
                                    return '<a class="btn btn-xs btn-warning btn-block" data-toggle="modal" data-target="" disabled><i class="fa fa-fw fa-hand-paper-o"></i> Incomplete</a>';
                                }
                            }
                            else if(data.status == 24)
                            {
                                if(data.tele_stat == 'Complete')
                                {
                                    return '<a class="btn btn-xs btn-success btn-block" data-toggle="modal" data-target="" disabled><i class="fa fa-fw fa-check-circle-o"></i> Complete</a>';

                                }
                                else
                                {
                                    return '<a class="btn btn-xs btn-warning btn-block" data-toggle="modal" data-target="" disabled><i class="fa fa-fw fa-hand-paper-o"></i> Incomplete</a>';

                                }
                            }
                        }


                    },
                    'name' : 'bi_endorsements.status',
                    'searchable' : false,
                    'orderable' : false
                },
                {
                    data: function contact_details(data)
                    {
                        if(data.tele_stat == 'Contacted')
                        {
                            console.log(data.tele_stat);

                            if(data.contact_details == null || data.contact_details == '')
                            {
                                return 'N/A';
                            }
                            else if(data.contact_details == 'Refused to be interviewed')
                            {
                                return '<p style="font-style: italic">'+data.contact_details+'</p>';
                            }
                            else if(data.contact_details == 'Verified applying')
                            {
                                return '<p style="font-style: italic">'+data.contact_details+'</p>';
                            }
                            else
                            {
                                return '<p style="font-style: italic">'+data.contact_details+'</p>';
                            }
                        }
                        else if(data.tele_stat == 'Uncontacted')
                        {

                            if(data.contact_details == null || data.contact_details == '')
                            {
                                return 'N/A';
                            }
                            else
                            {
                                return '<p style="font-style: italic">'+data.contact_details+'</p>';
                            }
                        }
                        else if(data.tele_stat == 'Verified')
                        {

                            if(data.contact_details == null || data.contact_details == '')
                            {
                                return 'N/A';
                            }
                            else
                            {
                                return '<p style="font-style: italic">'+data.contact_details+'</p>';
                            }
                        }
                        else if(data.tele_stat == 'Unverified')
                        {

                            if(data.contact_details == null || data.contact_details == '')
                            {
                                return 'N/A';
                            }
                            else
                            {
                                return '<p style="font-style: italic">'+data.contact_details+'</p>';
                            }
                        }
                        else
                        {
                            return 'N/A';
                        }
                    },
                    'name': 'bi_endorsements.verify_tele_status_details',
                    'orderable' : false
                },
                {
                    data : function action(data) {

                        if(data.status == 24)
                        {
                            if(data.type_user == 'cc_bank')
                            {
                                if(data.tele_stat == "Contacted")
                                {
                                    var act = '<a id="'+data.endorse_id+'" class="btn_send_report_mod btn btn-xs btn-primary btn-block"><i class="fa fa-fw fa-send"></i> Update Report</a>'+
                                        '<button  id="'+data.endorse_id+'" class="btnDlTeleEncoderRep btn btn-xs btn-danger btn-block" data-toggle="modal"><i class="fa fa-fw fa-download"></i> Download Tele-Encoder Report</button>' +
                                        '<a  id="'+data.endorse_id+'" class="btn_return_during_tele btn btn-xs btn-danger btn-block" name="'+data.status+'" data-toggle="modal" data-target="" ><i class="glyphicon glyphicon-repeat"></i> Return to Tele</a>'+
                                        '<a  id="'+data.endorse_id+'" class="btn_viewReason btn btn-xs btn-warning btn-block" name="'+data.endorse_id+'" data-toggle="modal" data-target="" ><i class="glyphicon glyphicon-eye-open"></i> View Reason</a>'+
                                        '<a id="'+data.endorse_id+'" class="btn_view_information_bi btn btn-xs btn-info btn-block" data-toggle="modal" data-target="" ><i class="glyphicon glyphicon-film"></i> View Information</a>' +
                                        '<span id = "dlEnc"></span>';
                                }
                                else if(data.tele_stat == "Uncontacted")
                                {
                                    var if_has_path = '';
                                    if(data.path == '')
                                    {
                                        if_has_path = '<button  id="'+data.endorse_id+'" class="btn btn-xs btn-info btn-block" data-toggle="modal"><i class="fa fa-fw fa-download"></i> No uploaded file</button>';
                                    }
                                    else
                                    {
                                        if_has_path = '<button  id="'+data.endorse_id+'" class="btnDlTeleEncoderRep btn btn-xs btn-danger btn-block" data-toggle="modal"><i class="fa fa-fw fa-download"></i> Download Tele-Encoder Report</button>';
                                    }

                                    var act = '<a id="'+data.endorse_id+'" class="btn_send_report_mod btn btn-xs btn-primary btn-block"><i class="fa fa-fw fa-send"></i> Update Report</a>'+
                                        if_has_path+
                                        '<a  id="'+data.endorse_id+'" class="btn_return_during_tele btn btn-xs btn-danger btn-block" name="'+data.status+'" data-toggle="modal" data-target="" ><i class="glyphicon glyphicon-repeat"></i> Return to Tele</a>'+
                                        '<a  id="'+data.endorse_id+'" class="btn_viewReason btn btn-xs btn-warning btn-block" name="'+data.endorse_id+'" data-toggle="modal" data-target="" ><i class="glyphicon glyphicon-eye-open"></i> View Reason</a>'+
                                        '<a id="'+data.endorse_id+'" class="btn_view_information_bi btn btn-xs btn-info btn-block" data-toggle="modal" data-target="" ><i class="glyphicon glyphicon-film"></i> View Information</a>' +
                                        '<span id = "dlEnc"></span>';
                                }
                            }
                            else
                            {
                                if(data.tele_stat == "Complete")
                                {
                                    var act = '<a id="'+data.endorse_id+'" class="btn_send_report_mod btn btn-xs btn-primary btn-block"><i class="fa fa-fw fa-send"></i> Update Report</a>'+
                                        '<button  id="'+data.endorse_id+'" class="btnDlTeleEncoderRep btn btn-xs btn-danger btn-block" data-toggle="modal"><i class="fa fa-fw fa-download"></i> Download Tele-Encoder Report</button>' +
                                        '<a  id="'+data.endorse_id+'" class="btn_return_during_tele btn btn-xs btn-danger btn-block" name="'+data.status+'" data-toggle="modal" data-target="" ><i class="glyphicon glyphicon-repeat"></i> Return to Tele</a>'+
                                        '<a  id="'+data.endorse_id+'" class="btn_viewReason btn btn-xs btn-warning btn-block" name="'+data.endorse_id+'" data-toggle="modal" data-target="" ><i class="glyphicon glyphicon-eye-open"></i> View Reason</a>'+
                                        '<a id="'+data.endorse_id+'" class="btn_view_information_bi btn btn-xs btn-info btn-block" data-toggle="modal" data-target="" ><i class="glyphicon glyphicon-film"></i> View Information</a>' +
                                        '<span id = "dlEnc"></span>';
                                }
                                else if(data.tele_stat == "Incomplete")
                                {
                                    var if_has_path = '';
                                    if(data.path == '')
                                    {
                                        if_has_path = '<button  id="'+data.endorse_id+'" class="btn btn-xs btn-info btn-block" data-toggle="modal"><i class="fa fa-fw fa-download"></i> No uploaded file</button>';
                                    }
                                    else
                                    {
                                        if_has_path = '<button  id="'+data.endorse_id+'" class="btnDlTeleEncoderRep btn btn-xs btn-danger btn-block" data-toggle="modal"><i class="fa fa-fw fa-download"></i> Download Tele-Encoder Report</button>';
                                    }

                                    var act = '<a id="'+data.endorse_id+'" class="btn_send_report_mod btn btn-xs btn-primary btn-block"><i class="fa fa-fw fa-send"></i> Update Report</a>'+
                                        if_has_path+
                                        '<a  id="'+data.endorse_id+'" class="btn_return_during_tele btn btn-xs btn-danger btn-block" name="'+data.status+'" data-toggle="modal" data-target="" ><i class="glyphicon glyphicon-repeat"></i> Return to Tele</a>'+
                                        '<a  id="'+data.endorse_id+'" class="btn_viewReason btn btn-xs btn-warning btn-block" name="'+data.endorse_id+'" data-toggle="modal" data-target="" ><i class="glyphicon glyphicon-eye-open"></i> View Reason</a>'+
                                        '<a id="'+data.endorse_id+'" class="btn_view_information_bi btn btn-xs btn-info btn-block" data-toggle="modal" data-target="" ><i class="glyphicon glyphicon-film"></i> View Information</a>' +
                                        '<span id = "dlEnc"></span>';
                                }
                            }

                        }
                        else
                        {

                            if(data.type_user == 'cc_bank')
                            {
                                if(data.tele_stat == "Contacted")
                                {
                                    var act = '<a id="'+data.endorse_id+'" class="btn_send_report_mod btn btn-xs btn-success btn-block"><i class="fa fa-fw fa-send"></i> Send Report</a>'+
                                        '<button  id="'+data.endorse_id+'" class="btnDlTeleEncoderRep btn btn-xs btn-danger btn-block" data-toggle="modal"><i class="fa fa-fw fa-download"></i> Download Tele-Encoder Report</button>' +
                                        '<a  id="'+data.endorse_id+'" class="btn_return_during_tele btn btn-xs btn-danger btn-block" name="'+data.status+'" data-toggle="modal" data-target="" ><i class="glyphicon glyphicon-repeat"></i> Return to Tele</a>'+
                                        '<a id="'+data.endorse_id+'" class="btn_view_information_bi btn btn-xs btn-info btn-block" data-toggle="modal" data-target="" ><i class="glyphicon glyphicon-film"></i> View Information</a>' +
                                        '<span id = "dlEnc"></span>';
                                }
                                else if(data.tele_stat == "Uncontacted")
                                {

                                    var if_has_path = '';
                                    if(data.path == '')
                                    {
                                        if_has_path = '<button  id="'+data.endorse_id+'" class="btn btn-xs btn-info btn-block" data-toggle="modal"><i class="fa fa-fw fa-download"></i> No uploaded file</button>'
                                    }
                                    else
                                    {
                                        if_has_path = '<button  id="'+data.endorse_id+'" class="btnDlTeleEncoderRep btn btn-xs btn-danger btn-block" data-toggle="modal"><i class="fa fa-fw fa-download"></i> Download Tele-Encoder Report</button>';
                                    }

                                    var act = '<a id="'+data.endorse_id+'" class="btn_send_report_mod btn btn-xs btn-success btn-block"><i class="fa fa-fw fa-send"></i> Send Report</a>'+
                                        if_has_path+
                                        '<a  id="'+data.endorse_id+'" class="btn_return_during btn btn-xs btn-danger btn-block" name="'+data.status+'" data-toggle="modal" data-target="" ><i class="glyphicon glyphicon-repeat"></i> Return to Client</a>'+
                                        '<a  id="'+data.endorse_id+'" class="btn_return_during_tele btn btn-xs btn-danger btn-block" name="'+data.status+'" data-toggle="modal" data-target="" ><i class="glyphicon glyphicon-repeat"></i> Return to Tele</a>'+
                                        '<a  id="'+data.endorse_id+'" class="btn_viewReason btn btn-xs btn-warning btn-block" name="'+data.endorse_id+'" data-toggle="modal" data-target="" ><i class="glyphicon glyphicon-eye-open"></i> View Reason</a>'+
                                        '<a id="'+data.endorse_id+'" class="btn_view_information_bi btn btn-xs btn-info btn-block" data-toggle="modal" data-target="" ><i class="glyphicon glyphicon-film"></i> View Information</a>' +
                                        '<span id = "dlEnc"></span>';
                                }
                            }
                            else
                            {
                                if(data.tele_stat == "Complete")
                                {
                                    var act = '<a id="'+data.endorse_id+'" class="btn_send_report_mod btn btn-xs btn-success btn-block"><i class="fa fa-fw fa-send"></i> Send Report</a>'+
                                        '<button  id="'+data.endorse_id+'" class="btnDlTeleEncoderRep btn btn-xs btn-danger btn-block" data-toggle="modal"><i class="fa fa-fw fa-download"></i> Download Tele-Encoder Report</button>' +
                                        '<a  id="'+data.endorse_id+'" class="btn_return_during_tele btn btn-xs btn-danger btn-block" name="'+data.status+'" data-toggle="modal" data-target="" ><i class="glyphicon glyphicon-repeat"></i> Return to Tele</a>'+
                                        '<a id="'+data.endorse_id+'" class="btn_view_information_bi btn btn-xs btn-info btn-block" data-toggle="modal" data-target="" ><i class="glyphicon glyphicon-film"></i> View Information</a>' +
                                        '<span id = "dlEnc"></span>';
                                }
                                else if(data.tele_stat == "Incomplete")
                                {

                                    var if_has_path = '';
                                    if(data.path == '')
                                    {
                                        if_has_path = '<button  id="'+data.endorse_id+'" class="btn btn-xs btn-info btn-block" data-toggle="modal"><i class="fa fa-fw fa-download"></i> No uploaded file</button>'
                                    }
                                    else
                                    {
                                        if_has_path = '<button  id="'+data.endorse_id+'" class="btnDlTeleEncoderRep btn btn-xs btn-danger btn-block" data-toggle="modal"><i class="fa fa-fw fa-download"></i> Download Tele-Encoder Report</button>';
                                    }

                                    var act = '<a id="'+data.endorse_id+'" class="btn_send_report_mod btn btn-xs btn-success btn-block"><i class="fa fa-fw fa-send"></i> Send Report</a>'+
                                        if_has_path+
                                        '<a  id="'+data.endorse_id+'" class="btn_return_during btn btn-xs btn-danger btn-block" name="'+data.status+'" data-toggle="modal" data-target="" ><i class="glyphicon glyphicon-repeat"></i> Return to Client</a>'+
                                        '<a  id="'+data.endorse_id+'" class="btn_return_during_tele btn btn-xs btn-danger btn-block" name="'+data.status+'" data-toggle="modal" data-target="" ><i class="glyphicon glyphicon-repeat"></i> Return to Tele</a>'+
                                        '<a  id="'+data.endorse_id+'" class="btn_viewReason btn btn-xs btn-warning btn-block" name="'+data.endorse_id+'" data-toggle="modal" data-target="" ><i class="glyphicon glyphicon-eye-open"></i> View Reason</a>'+
                                        '<a id="'+data.endorse_id+'" class="btn_view_information_bi btn btn-xs btn-info btn-block" data-toggle="modal" data-target="" ><i class="glyphicon glyphicon-film"></i> View Information</a>' +
                                        '<span id = "dlEnc"></span>';
                                }
                            }

                        }

                        return act;
                    },
                    'name' : 'action',
                    'searchable' : false,
                    'orderable' : false
                }
            ],
        "order": [[0, 'desc']],
        "pageLength": 10,
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

    $('#cc_sao_success_table_filter input').unbind();
    $('#cc_sao_success_table_filter input').bind('keyup change',function (e) {

        if($(this).is(':focus'))
        {
            if (e.keyCode == 13) {
                table_tele_success.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '') {
                    table_tele_success.search($(this).val()).draw();
                }
            }
        }
    });

    if(clientTypeAuth == 'bank')
    {
        table_tele_success.column(1).visible(false);
        table_tele_success.column(2).visible(true);
        table_tele_success.column(9).visible(true);
    }
    else if(clientTypeAuth == 'cc')
    {
        table_tele_success.column(1).visible(true);
        table_tele_success.column(2).visible(false);
        table_tele_success.column(9).visible(false);
    }

}

$('#cc_sao_success_table').on('click', '.btnDlTeleEncoderRep', function()
{
    accAckId = $(this).attr('id');
    console.log(accAckId);
    var id_encode = btoa(accAckId);
    var q = '<form action="/cc-sao-tele-dl-report" target="_blank" method="get">'+
        '<div class="input-group">'+
        '<input type="text" hidden value="'+id_encode+'" name="id">'+
        '<button type="submit" hidden id="button_sao_tele_download" >'+
        '</button>'+
        '</span>'+
        '</div>'+
        '</form>';

    $('#dlEnc').html(q);
    $('#button_sao_tele_download').click();
    $('#dlEnc').hide();
});

$('#cc_sao_success_table').on('click', '.btn_viewReason', function()
{
    var get_endorseID = $(this).attr("name");
    $('#modal-view-reasonDelay').modal("show");

    $.ajax
    (
        {
            type: 'get',
            url: 'cc-sao-get-reason-of-delay',
            data: {
                'id' : get_endorseID
            },
            success: function(data)
            {
                $('#reasonOfDelay').html(data[0].remarks);
            }
        }
    );
});

// $('#cc_sao_acknowledge_table').on('click', '.btn_upload_sao_to_tele', function()
// {
//     accAckId = $(this).attr('id');
//     var showDl = $(this).attr('value');
//     var dl = btoa($(this).attr('name'));
//
//     var id_encode = btoa(accAckId);
//
//     if(showDl == 'true')
//     {
//         $('.download_sao_file').show();
//         $('.hidethis').show();
//         $('.download_sao_file').text('Download');
//
//         $('.download_sao_file').click(function()
//         {
//             // var id_encode = btoa(accAckId);
//             var q = '<form action="/cc-sao-dl-ack" target="_blank" method="get">'+
//                 '<div class="input-group">'+
//                 '<input type="text" hidden value="'+id_encode+'" name="id">'+
//                 '<input type="text" hidden value="'+dl+'" name="dl">'+
//                 '<button type="submit" hidden id="button_rep_download" >'+
//                 '</button>'+
//                 '</span>'+
//                 '</div>'+
//                 '</form>';
//
//             $('#downReport').html(q);
//             $('#button_rep_download').click();
//             $('#downReport').hide();
//         });
//     }
//     else
//     {
//         $('.download_sao_file').hide();
//         $('.hidethis').hide();
//
//     }
//
// });

$('#btnUpdateSaoToTele').click(function()
{
    $('#btnUpdateSaoToTele').attr("disabled", true);

    var id_encode= btoa(accAckId);

    var fileToSend = $('#file_sao_to_tele').prop('files')[0];
    var remarks = $('#rem_sao_to_tele').val();

    var formData = new FormData();
    formData.append('file', fileToSend);
    formData.append('remarks', remarks);
    formData.append('id', id_encode);

    if(fileToSend != null)
    {
        if(confirm('Are you sure to update file?'))
        {
            $.ajax
            ({
                type : 'post',
                url : 'cc-sao-file-to-tele',
                contentType: false,
                processData: false,
                async : true,
                data: formData,
                success : function()
                {
                    alert('Successfully Updated!');
                    $('#rem_sao_to_tele').val('');
                    $('#file_sao_to_tele').val('');
                    $('#modal-cc-sao-upload-update').modal('hide');
                    table_assigned.ajax.reload(null,false);
                    $('#btnUpdateSaoToTele').attr("disabled", false);
                }
            });

        }
        else
        {
            $('#btnUpdateSaoToTele').attr("disabled", false);
        }
    }
    else
    {
        alert('Please select file!');
        $('#btnUpdateSaoToTele').attr("disabled", false);
    }
});

todiy();
function todiy()
{
    $('#tat_date_due').datepicker({
        startDate: new Date(),
        format: 'yyyy-mm-dd',
        daysOfWeekDisabled: [0,6]
    });
}

function getGeneralsearch()
{
    var now = new Date();
    var dd = now.getDate();
    var mm = now.getMonth()+1; //January is 0!
    var yyyy = now.getFullYear();
    var today = yyyy + '-' + mm + '-' + dd;
    var minutes = now.getMinutes();
    var hours = now.getHours();
    var seconds = now.getSeconds();
    var timenow = hours+':'+minutes+':'+seconds;
    var test = today + ' ' + timenow;

    $('#cc_sao_generaltbl thead th').each(function ()
    {
        title_general_search[title_general_search_counts] = $(this).text();
        title_general_search_counts++
        var title = $(this).text();
        $(this).html(title+'<br><input type="text" placeholder="Search" style="position: relative; width: 100%;"> ')
    });

    table_general_search = $('#cc_sao_generaltbl').DataTable
    ({
        "responsive" : true,
        "processing" : true,
        "serverSide" : true,
        // "ajax" : 'cc-sao-generaltbl-search',
        "ajax":
        {
            url: "cc-sao-generaltbl-search",
            data: function (d)
            {
                d.min_date_endorsed = $('#gen_search_min').val();
                d.max_date_endorsed = $('#gen_search_max').val();
                d.search_methodd = $('input[name="gen_search_rad"]:checked').val();
            }
        },
        dom: 'Blfrtip',
        buttons:
            [
                // {
                //     extend: 'excel',
                //     exportOptions:
                //         {
                //             columns: 'visible',
                //             format:
                //                 {
                //                     header: function (dt, idx, title)
                //                     {
                //                         return title_general_search[(idx)];
                //                     }
                //                 }
                //         },
                //     customize: function (xlsx)
                //     {
                //         var sheet = xlsx.xl.worksheets['sheet1.xml'];
                //
                //         var loop = 0;
                //         $('row', sheet).each(function ()
                //         {
                //             $(this).find("c").attr('s', '55');
                //             $('row:first c', sheet).attr('s', '51');
                //             loop++;
                //         });
                //     }
                // },
                'excel',
                {
                    extend: 'colvis',
                    text: 'Show/Hide Column',
                    columnText: function (dt, idx,title)
                    {
                        return title_general_search[(idx)];
                    }
                }
            ],
        "columns":
            [
                {data: 'endorse_id', name: 'bi_endorsements.id'},
                {data: 'site',name: 'bi_endorsements.bi_account_name'},
                {data: 'tor', name: 'bi_endorsements.type_of_endorsement_bank'},
                {
                    data : function d_t(data)
                    {
                        var date_time = data.date_time_endorsed;

                        var split = date_time.split(' ');

                        var time = split[1].split(':');

                        var final = time[0] + ':' + time[1];

                        return split[0] + ' ' +final;
                    },
                    name : 'bi_endorsements.created_at'
                },
                {data: 'project', name: 'bi_endorsements.project'},
                {data: 'account_name', name: 'bi_endorsements.account_name'},
                {data: 'package', name: 'bi_endorsements.package'},
                {data: 'check', name: 'bi_endorsements.id', 'searchable' : false, 'orderable' : false},
                {data: 'poc', name: 'bi_endorsements.endorser_poc'},
                {data: 'due', name: 'bi_endorsements.id'},
                // {
                //     data: function action(data)
                //     {
                //         var countDownDate = new Date(data.date_time_due1);
                //         var now = new Date();
                //         var distance = countDownDate - now;
                //
                //         if(data.cancel_status == 'Cancelled')
                //         {
                //                 return '<a class="btn btn-xs btn-warning btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-repeat"></i> Cancelled Account</a>';
                //         }
                //         else if(data.cancel_status == 'Pending')
                //         {
                //             return '<a class="btn btn-xs btn-warning btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-repeat"></i> Pending Cancellation</a>';
                //         }
                //         else
                //         {
                //             if(data.status == 0)
                //             {
                //                 return '<a class="btn btn-xs btn-danger btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-envelope"></i> New Endorsement</a>';
                //             }
                //             else if (data.status == 20)
                //             {
                //                 return '<a class="btn btn-xs btn-danger btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-repeat"></i> Returned Upon Endorsement</a>';
                //             }
                //             else if(data.status == 22)
                //             {
                //                 return '<a class="btn btn-xs btn-danger btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-repeat"></i> Returned During Endorsement</a>';
                //             }
                //             else if(data.status == 23)
                //             {
                //                 return '<a class="btn btn-xs btn-danger btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-repeat"></i> Returned After Endorsement</a>';
                //             }
                //             else if(data.status == 24)
                //             {
                //                 return '<a class="btn btn-xs btn-danger btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-repeat"></i> Returned After Endorsement</a>';
                //             }
                //             else if(data.status == 25)
                //             {
                //                 return '<a class="btn btn-xs btn-danger btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-repeat"></i> Returned After Endorsement</a>';
                //             }
                //             else if (data.status == 21)
                //             {
                //                 return '<a class="btn btn-xs btn-danger btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-envelope"></i> Returned Enodrsement</a>';
                //             }
                //             else if (data.status == 5)
                //             {
                //                 return '<a class="btn btn-xs btn-warning btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-repeat"></i> On-Hold Account</a>';
                //             }
                //             else if (data.status == 4)
                //             {
                //                 return '<a class="btn btn-xs btn-warning btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-repeat"></i> Cancelled Account</a>';
                //             }
                //             else if (data.status == 1)
                //             {
                //                 if(distance > 1)
                //                 {
                //                     return '<a class="btn btn-xs btn-info btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-thumbs-up"></i> Acknowledged</a>'+
                //                         '<a class="btn btn-xs btn-warning btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-wrench"></i> Ongoing </a>';
                //
                //                 }
                //                 else
                //                 {
                //                     return '<a class="btn btn-xs btn-info btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-thumbs-up"></i> Acknowledged</a>'+
                //                         '<a class="btn btn-xs btn-danger btn-block" data-toggle="modal" data-target="" disabled><i class="glyphicon glyphicon-time"></i> Late </a>';
                //                 }
                //             }
                //             else if (data.status == 10)
                //             {
                //                 if(data.type_user == 'cc_bank')
                //                 {
                //                     if(data.status_report == 'Contacted')
                //                     {
                //                         return '<a class="btn btn-xs btn-info btn-block" disabled><i class="fa fa-fw fa-check-square"></i> '+data.status_report+'</a>';
                //                     }
                //                     else
                //                     {
                //                         return '<a class="btn btn-xs btn-warning btn-block" disabled><i class="fa fa-fw fa-spinner"></i> ' + data.status_report + '</a>';
                //                     }
                //                 }
                //                 else
                //                 {
                //                     if(data.status_report == 'Complete')
                //                     {
                //                         return '<a class="btn btn-xs btn-success btn-block" data-toggle="modal" data-target="" disabled><i class="fa fa-fw fa-check-square"></i> Finished</a>' +
                //                             '<a class="btn btn-xs btn-info btn-block" disabled><i class="fa fa-fw fa-check-square"></i> '+data.status_report+'</a>';
                //                     }
                //                     else {
                //                         return '<a class="btn btn-xs btn-success btn-block" data-toggle="modal" data-target="" disabled><i class="fa fa-fw fa-check-square"></i> Finished</a>' +
                //                             '<a class="btn btn-xs btn-warning btn-block" disabled><i class="fa fa-fw fa-spinner"></i> ' + data.status_report + '</a>';
                //                     }
                //                 }
                //
                //
                //             }
                //             else if(data.status == 2)
                //             {
                //                 return '<a class="btn btn-xs btn-success btn-block" data-toggle="modal" data-target="" disabled><i class="fa fa-fw fa-mail-forward"></i>Assigned</a>';
                //             }
                //             else if(data.status == 3)
                //             {
                //                 return '<a class="btn btn-xs btn-danger btn-block" data-toggle="modal" data-target="" disabled><i class="fa fa-fw fa-check"></i>Successful Verification</a>';
                //             }
                //         }
                //     },
                //     'name' : 'bi_endorsements.status',
                //     'searchable' : false,
                //     'orderable' : false
                // },
                {
                    data: function contact_details(data)
                    {
                        if(data.tele_stat == 'Contacted')
                        {
                            if(data.contact_details == 'Refused to be interviewed')
                            {
                                return '<p style="font-style: italic">'+data.contact_details+'</p>';
                            }
                            else if(data.contact_details == 'Verified applying')
                            {
                                return '<p style="font-style: italic">'+data.contact_details+'</p>';
                            }
                            else
                            {
                                return '<p style="font-style: italic">'+data.contact_details+'</p>';
                            }
                        }
                        else
                        {
                            return 'N/A';
                        }
                    },
                    'name': 'bi_endorsements.verify_tele_status_details',
                    'orderable' : false
                },
                {
                    data: function(data)
                    {
                        return '<a id="'+data.endorse_id+'" class="btn_view_information_bi btn btn-xs btn-info btn-block" data-toggle="modal" data-target="" ><i class="glyphicon glyphicon-film"></i> View Information</a>';
                    },
                    'name' : 'bi_endorsements.status',
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

    $('#cc_sao_generaltbl_filter input').unbind();
    $('#cc_sao_generaltbl_filter input').bind('keyup change', function(e)
    {
        if($(this).is(':focus'))
        {
            if (e.keyCode == 13) {
                table_general_search.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '') {
                    table_general_search.search($(this).val()).draw();
                }
            }
        }
    });

    if(clientTypeAuth == 'bank')
    {
        table_general_search.column(2).visible(true);
        table_general_search.column(1).visible(false);
        table_general_search.column(6).visible(false);
        table_general_search.column(7).visible(false);
        table_general_search.column(10).visible(true);
    }
    else if(clientTypeAuth == 'cc')
    {
        table_general_search.column(2).visible(false);
        table_general_search.column(1).visible(true);
        table_general_search.column(6).visible(true);
        table_general_search.column(7).visible(true);
        table_general_search.column(10).visible(false);
    }
}



getDash();
function getDash()
{
    $.ajax
    ({
        type : 'get',
        url : 'cc-sao-get-dash',
        success : function(data)
        {
            console.log(data);
            $('#gen_endorse_count').html(data[0]);
            $('#finished_count').html(data[1]);
            $('#pending_account_count').html(data[2]);
            $('#returned_account_count').html(data[3]);
            $('#hold_cancelled_count').html(data[4]);
        }
    });
}

function get_assigned_table()
{
    $('#cc_sao_assigned_table thead th').each(function()
    {
        title_assigned[title_assigned_counts] = $(this).text();
        title_assigned_counts++;
        var title = $(this).text();
        $(this).html(title+'<br><input type="text" placeholder="Search" style="position: relative; width: 100%">');
    });

    table_assigned = $('#cc_sao_assigned_table').DataTable
    ({
        "responsive": true,
        "processing": true,
        "serverSide": true,
        "ajax" : 'cc-sao-get-assigned-table',

        dom: 'Blfrtip',
        buttons:
            [
                {
                    extend: 'excel',
                    exportOptions:
                        {
                            columns: ':visible',
                            format:
                                {
                                    header:  function (dt, idx, title)
                                    {
                                        return title_assigned[(idx)];
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
                    columnText: function (dt, idx, title)
                    {
                        return title_assigned[(idx)];
                    }
                }
            ],
        "columns":
            [
                {data: 'endorse_id', name: 'bi_endorsements.id'},
                {data: 'site', name: 'bi_endorsements.bi_account_name'},
                {data: 'bank', name: 'bi_endorsements.type_of_endorsement_bank'},
                {
                    data : function d_t(data)
                    {
                        var date_time = data.date_time_endorsed;

                        var split = date_time.split(' ');

                        var time = split[1].split(':');

                        var final = time[0] + ':' + time[1];

                        return split[0] + ' ' +final;
                    },
                    name : 'bi_endorsements.created_at'
                },
                {data: 'project', name: 'bi_endorsements.project'},
                {data: 'account_name', name: 'bi_endorsements.account_name'},
                {data: 'package', name: 'bi_endorsements.package'},
                {data: 'check', name: 'bi_endorsements.id', 'searchable' : false, 'orderable' : false},
                {data: 'poc', name: 'bi_endorsements.endorser_poc'},
                {data: 'attachments', name: 'bi_endorsements.attach_1'},
                {data: 'due', name: 'due', 'searchable' : false, 'orderable' : false},
                {
                    data : function action(data)
                    {
                        var assignStat1;

                        if(data.sao_to_tele_file_path1 == '')
                        {
                            assignStat1 = '<a id="'+data.endorse_id+'" class="btn_upload_sao_to_tele btn btn-xs btn-success btn-block" data-toggle="modal" data-target="#modal-cc-sao-upload-update" name="'+data.sao_to_tele_file_path1+'" value="false"><i class="glyphicon glyphicon-upload"></i>Update File</a>';
                        }
                        else
                        {
                            assignStat1 = '<a id="'+data.endorse_id+'" class="btn_upload_sao_to_tele btn btn-xs btn-primary btn-block" data-toggle="modal" data-target="#modal-cc-sao-upload-update" name="'+data.sao_to_tele_file_path1+'" value="true"><i class="glyphicon glyphicon-upload"></i>Updated File</a>';
                        }

                        var act =
                            '<a id="'+data.endorse_id+'" class="btn_tele_encode_transfer btn btn-xs btn-danger btn-block" data-toggle="modal" data-target="#modal-transfer-tele" data-backdrop="static"><i class="fa fa-exchange"></i> Tele-Encoder Transfer</a>'
                            + assignStat1 +
                            '<a class="btn_cancel btn btn-xs btn-warning btn-block" data-toggle="modal" id="'+data.endorse_id+'" data-target="" name="new" href="cancel this account"><i class="glyphicon glyphicon-remove"></i> Cancel Account</a>' +
                            '<a  id="'+data.endorse_id+'" class="btn_view_information_bi btn btn-xs btn-info btn-block" data-toggle="modal" data-target="" ><i class="glyphicon glyphicon-film"></i> View Information</a>';

                        return act;
                    },
                    'name' : 'bi_endorsements.status',
                    'searchable' : false,
                    'orderable' : false
                }
            ],
        "order": [[0, 'desc']],
        "pageLength": 10,
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

    $('#cc_sao_assigned_table_filter input').unbind();
    $('#cc_sao_assigned_table_filter input').bind('keyup change',function (e) {

        if($(this).is(':focus'))
        {
            if (e.keyCode == 13) {
                table_assigned.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '') {
                    table_assigned.search($(this).val()).draw();
                }
            }
        }
    });

    if(clientTypeAuth == 'bank')
    {
        table_assigned.column(2).visible(true);
        table_assigned.column(1).visible(false);
        table_assigned.column(6).visible(false);
        table_assigned.column(7).visible(false);
    }
    else if(clientTypeAuth == 'cc')
    {
        table_assigned.column(2).visible(false);
        table_accounts.column(1).visible(true);
        table_accounts.column(6).visible(true);
        table_accounts.column(7).visible(true);
    }
}

$('#cc_sao_assigned_table').on('click', '.btn_upload_sao_to_tele', function() {
    accAckId = $(this).attr('id');
    var showDl = $(this).attr('value');
    var dl = btoa($(this).attr('name'));
    var id_encode = btoa(accAckId);

    if (showDl == 'true') {
        $('.download_sao_file').show();
        $('.hidethis').show();
        $('.download_sao_file').text($(this).attr('name'));

        $('.download_sao_file').click(function () {
            var q = '<form action="/cc-sao-dl-ack" target="_blank" method="get">' +
                '<div class="input-group">' +
                '<input type="text" hidden value="' + id_encode + '" name="id">' +
                '<input type="text" hidden value="' + dl + '" name="dl">' +
                '<button type="submit" hidden id="button_rep_download" >' +
                '</button>' +
                '</span>' +
                '</div>' +
                '</form>';

            $('#downReport').html(q);
            $('#button_rep_download').click();
            $('#downReport').hide();
        });
    }
    else
    {
        $('.download_sao_file').hide();
        $('.hidethis').hide();
    }
});

$('#cc_sao_assigned_table').on('click', '.btn_tele_encode_transfer', function()
{
    accAckId = $(this).attr('id');
    var teleList;
    var ctr;

    $.ajax
    ({
        type : 'get',
        url : 'cc-sao-get-assigned-to-acct',
        data :
            {
                'id' : accAckId
            },
        success : function(data)
        {
            console.log(data);
            originalTeleEncoder = data[0][0].id;
            transferAssigned = data[0][0].id;
            transferName = data[0][0].name;

            $('#sao-acct-tele-assigned').val(data[0][0].name);

            for(ctr = 0; ctr < data[1].length; ctr++)
            {
                teleList += '<option value = "'+ data[1][ctr][0] +'" name = "'+ data[1][ctr][1] +'">'+ data[1][ctr][1] +' (Assigned Account/s : '+data[1][ctr][2]+' )</option>';
            }

            $('#tele-list-assign-acct').html('<option value = "-">-</option>' + teleList);
            $('#tele-list-assign-acct').val(data[0][0].id);

            $('.btn_tele_encode_transfer').attr("disabled", false);
        }
    });
});
$('#tele-list-assign-acct').change(function()
{
    transferAssigned = $(this).find(':selected').val();
    transferName = $(this).find(':selected').attr('name');
});

$('#btnTransferAccttoTele').click(function()
{
    var testinglang = 'dist/img/loading.gif';

    var btn = $(this);
    if(transferAssigned != '-')
    {
        if(confirm('Are you sure to tranfer the account to ' + transferName + '?'))
        {
            $('#lodadingAssignTele').html('<img src="'+testinglang+'" alt="" width="3%">');

            if(transferAssigned != originalTeleEncoder)
            {
                btn.attr('disabled', true);
                $.ajax
                ({
                    type : 'get',
                    url : 'cc-sao-transfer-to-tele',
                    data :
                        {
                            'id' : accAckId,
                            'newAssigned' : transferAssigned
                        },
                    success : function()
                    {
                        alert('Successfully Transferred Account!');
                        btn.attr('disabled', false);
                        $('#modal-transfer-tele').modal('hide');
                        $('#btnTransferAccttoTele').attr("disabled", false);
                    },
                    complete: function(){
                       refTables();
                        $('#lodadingAssignTele').html('');
                    }
                })
            }
            else
            {
                alert('Please select different Tele Encoder to Transfer!');
                $('#btnTransferAccttoTele').attr("disabled", false);
            }

        }
        else {
            $('#btnTransferAccttoTele').attr("disabled", false);
        }
    }
    else
    {
        alert('Please select a Tele-Encoder to Transfer!');
        $('#btnTransferAccttoTele').attr("disabled", false);
    }
});


function getCancel()
{
    $('#cc_sao_cancel_table thead th').each(function () {
        title_cancel[title_cancel_counts] = $(this).text();
        title_cancel_counts++
        var title = $(this).text();
        $(this).html(title+'<br><input type="text" placeholder="Search" style="position: relative; width: 100%;"> ')
    });

    table_cancel = $('#cc_sao_cancel_table').DataTable
    ({
        "responsive" : true,
        "processing" : true,
        "serverSide" : true,
        "ajax" : 'cc-sao-cancel-table',

        dom: 'Blfrtip',
        buttons:
            [
                {
                    extend: 'excel',
                    exportOptions:
                        {
                            columns: 'visible',
                            format:
                                {
                                    header: function (dt, idx, title)
                                    {
                                        return title_cancel_search[(idx)];
                                    }
                                }
                        },
                    customize: function (xlsx)
                    {
                        var sheet = xlsx.xl.worksheets['sheet1.xml'];

                        var loop = 0;
                        $('row', sheet).each(function ()
                        {
                            $(this).find("c").attr('s', '55');
                            $('row:first c', sheet).attr('s', '51');
                            loop++;
                        });
                    }
                },
                {
                    extend: 'colvis',
                    text: 'Show/Hide Column',
                    columnText: function (dt, idx,title)
                    {
                        return title_cancel[(idx)];
                    }
                }
            ],
        "columns":
            [
                {data: 'endorse_id', name: 'bi_endorsements.id'},
                {data: 'site',name: 'bi_endorsements.bi_account_name'},
                {data: 'bank', name: 'bi_endorsements.type_of_endorsement_bank'},
                {
                    data : function d_t(data)
                    {
                        var date_time = data.date_time_endorsed;

                        var split = date_time.split(' ');

                        var time = split[1].split(':');

                        var final = time[0] + ':' + time[1];

                        return split[0] + ' ' +final;
                    },
                    name : 'bi_endorsements.created_at'
                },
                {data: 'project', name: 'bi_endorsements.project'},
                {data: 'account_name', name: 'bi_endorsements.account_name'},
                {data: 'package', name: 'bi_endorsements.package'},
                {data: 'check', name: 'bi_endorsements.id', 'searchable' : false, 'orderable' : false},
                {data: 'poc', name: 'bi_endorsements.endorser_poc'},
                {
                    data: function action(data)
                    {
                        return '<a id="'+data.endorse_id+'" class="btn_view_removeCancel btn btn-xs btn-warning btn-block" data-toggle="modal" data-target="" ><i class="glyphicon glyphicon-remove"></i> Uncancel</a>'+
                            // '<a  id="'+data.endorse_id+'" class="btn_viewReason btn btn-xs btn-warning btn-block" name="'+data.endorse_id+'" data-toggle="modal" data-target="" ><i class="glyphicon glyphicon-eye-open"></i> View Reason</a>'+
                            '<a id="'+data.endorse_id+'" class="btn_view_information_bi btn btn-xs btn-info btn-block" data-toggle="modal" data-target="" ><i class="glyphicon glyphicon-film"></i> View Information</a>';
                    },
                    'name' : 'bi_endorsements.status',
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

    $('#cc_sao_cancel_table_filter input').unbind();
    $('#cc_sao_cancel_table_filter input').bind('keyup change', function(e)
    {
        if($(this).is(':focus'))
        {
            if (e.keyCode == 13) {
                table_cancel.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '') {
                    table_cancel.search($(this).val()).draw();
                }
            }
        }
    });

    if(clientTypeAuth == 'bank')
    {
        table_cancel.column(2).visible(true);
        table_cancel.column(1).visible(false);
        table_cancel.column(6).visible(false);
        table_cancel.column(7).visible(false);
    }
    else if(clientTypeAuth == 'cc')
    {
        table_cancel.column(2).visible(false);
        table_cancel.column(1).visible(true);
        table_cancel.column(6).visible(true);
        table_cancel.column(7).visible(true);
    }
}

function getHold()
{
    $('#cc_sao_pending_cancel_table thead th').each(function () {
        title_hold[title_hold_counts] = $(this).text();
        title_hold_counts++
        var title = $(this).text();
        $(this).html(title+'<br><input type="text" placeholder="Search" style="position: relative; width: 100%;"> ')
    });

    table_hold = $('#cc_sao_pending_cancel_table').DataTable
    ({
        "responsive" : true,
        "processing" : true,
        "serverSide" : true,
        "ajax" : 'cc-sao-pending-cancel-table',

        dom: 'Blfrtip',
        buttons:
            [
                {
                    extend: 'excel',
                    exportOptions:
                        {
                            columns: 'visible',
                            format:
                                {
                                    header: function (dt, idx, title)
                                    {
                                        return title_hold_search[(idx)];
                                    }
                                }
                        },
                    customize: function (xlsx)
                    {
                        var sheet = xlsx.xl.worksheets['sheet1.xml'];

                        var loop = 0;
                        $('row', sheet).each(function ()
                        {
                            $(this).find("c").attr('s', '55');
                            $('row:first c', sheet).attr('s', '51');
                            loop++;
                        });
                    }
                },
                {
                    extend: 'colvis',
                    text: 'Show/Hide Column',
                    columnText: function (dt, idx,title)
                    {
                        return title_hold[(idx)];
                    }
                }
            ],
        "columns":
            [
                {data: 'endorse_id', name: 'bi_endorsements.id'},
                {data: 'site',name: 'bi_endorsements.bi_account_name'},
                {data: 'bank', name: 'bi_endorsements.type_of_endorsement_bank'},
                {
                    data : function d_t(data)
                    {
                        var date_time = data.date_time_endorsed;

                        var split = date_time.split(' ');

                        var time = split[1].split(':');

                        var final = time[0] + ':' + time[1];

                        return split[0] + ' ' +final;
                    },
                    name : 'bi_endorsements.created_at'
                },
                {data: 'project', name: 'bi_endorsements.project'},
                {data: 'account_name', name: 'bi_endorsements.account_name'},
                {data: 'package', name: 'bi_endorsements.package'},
                {data: 'check', name: 'bi_endorsements.id', 'searchable' : false, 'orderable' : false},
                {data: 'poc', name: 'bi_endorsements.endorser_poc'},
                {
                    data: function action(data)
                    {
                        var whatButton = '';

                        if(data.cancel_status == 'Pending Cancel')
                        {
                            whatButton = '<a id="'+data.endorse_id+'" class="btn_cancel btn btn-xs btn-danger btn-block" data-toggle="modal" data-target="" name="pending" href="cancel this account"><i class="glyphicon glyphicon-remove"></i> Cancel</a>';
                        }
                        else
                        {
                            whatButton = '<a id="'+data.endorse_id+'" class="btn_cancel btn btn-xs btn-danger btn-block" data-toggle="modal" data-target="" name="revoke" href="uncancel this account"><i class="glyphicon glyphicon-remove"></i> Uncancel</a>';
                        }

                        return whatButton +
                            '<a id="'+data.endorse_id+'" class="btn_cancel btn btn-xs btn-primary btn-block" data-toggle="modal" data-target="" name="deny" href="deny request of this account"><i class="glyphicon glyphicon-thumbs-down"></i> Deny Request</a>' +
                            '<a id="'+data.endorse_id+'" class="btn_view_reason btn btn-xs btn-warning btn-block" data-toggle="modal" data-target="#modal-view-reason-cancellation" name="'+data.cancel_rem+'"><i class="glyphicon glyphicon-eye-open"></i> View Reason</a>'+
                            '<a id="'+data.endorse_id+'" class="btn_view_information_bi btn btn-xs btn-info btn-block" data-toggle="modal" data-target="" ><i class="glyphicon glyphicon-film"></i> View Information</a>';
                    },
                    'name' : 'bi_endorsements.status',
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

            if(clientTypeAuth == 'bank')
            {
                table_hold.column(2).visible(true);
                table_hold.column(1).visible(false);
                table_hold.column(6).visible(false);
                table_hold.column(7).visible(false);
            }
            else if(clientTypeAuth == 'cc')
            {
                table_hold.column(2).visible(false);
                table_hold.column(1).visible(true);
                table_hold.column(6).visible(true);
                table_hold.column(7).visible(true);
            }
        }

    });

    $('#cc_sao_pending_cancel_table_filter input').unbind();
    $('#cc_sao_pending_cancel_table_filter input').bind('keyup change', function(e)
    {
        if($(this).is(':focus'))
        {
            if (e.keyCode == 13) {
                table_hold.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '') {
                    table_hold.search($(this).val()).draw();
                }
            }
        }
    });
}

var counterCancel = false;
$('#cc_sao_accounts_table, #cc_sao_pending_cancel_table').on('click','.btn_cancel',function ()
{
    var btn = $(this);
    btn.attr("disabled", true);
    account_id_ack = $(this).attr('id');
    var whatisthis = $(this).attr('name');

    var trytest = prompt("Are you sure want to cancel this account?", "-");

    CancelFunction(btn, account_id_ack, whatisthis, trytest);
});

$('#cc_sao_assigned_table').on('click','.btn_cancel',function ()
{
    var btn = $(this);
    btn.attr("disabled", true);
    account_id_ack = $(this).attr('id');
    var whatisthis = $(this).attr('name');

    var trytest = prompt("Are you sure want to "+ $(this).attr('href') + " ?", "-");

    CancelFunction(btn, account_id_ack, whatisthis, trytest);
});

function CancelFunction(btn, account_id_ack, whatisthis, trytest)
{
    if(trytest != null)
    {
        $.ajax
        ({
            type: 'get',
            url: 'cc-sao-cancel-new-account',
            data: {
                'id' : account_id_ack,
                'remarks' : trytest,
                'what' : whatisthis
            },
            success: function(data)
            {
                if(data == 'ok')
                {
                    if(whatisthis == 'pending' || whatisthis == 'new')
                    {
                        alert("Account Successfully Cancelled!");
                    }
                    else
                    {
                        alert('Successfully Denied Request')
                    }
                    counterCancel = true;
                }
                else
                {
                    alert('Account Already Cancelled');
                    btn.attr("disabled", false);
                }

                if(whatisthis == 'pending' || whatisthis == 'revoke' || whatisthis == 'deny')
                {
                    table_hold.draw();
                }
                else
                {
                    table_accounts.ajax.reload(null, false);
                    table_assigned.ajax.reload(null, false);
                }
            }
        })
    }
    else
    {
        btn.attr("disabled", false);
    }
}
var counterHold = false;

$('#cc_sao_accounts_table').on('click','.btn_hold',function () {

    var btn = $(this);
    btn.attr("disabled", true);
    account_id_ack = $(this).attr('id');

    var trytest = confirm("Are you sure want to hold this account?");

    if(trytest == true)
    {
        $.ajax
        ({
            type: 'get',
            url: 'cc-sao-hold-new-account',
            data: {
                'id' : account_id_ack
            },
            success: function(data)
            {
                if(data == 'ok')
                {
                    table_accounts.ajax.reload(null, false);
                    alert('Account Successfully on-hold');
                    counterHold = true;
                }
                else
                {
                    table_accounts.ajax.reload(null, false);
                    alert('Account Already on-hold');
                }
                btn.attr("disabled", false);
            }
        })
    }
    else
    {
        console.log('do nothing');
        btn.attr("disabled", false);
    }
});


$('#btnReturnAccount').click( function(e)
{
    var btn = $(this);
    btn.attr("disabled", true);

    var ctr = 0;

    var chicking = '';
    var myData = [];
    var remtoSend ='';

    $('.test1').each(function()
    {
        if($(this).is(':checked'))
        {
            chicking = $(this).val();
            myData[ctr] = chicking;
            remtoSend += '* ' + chicking + '<br>';
            ctr++;
        }
    });

    $.ajax
    (
        {
            url: 'cc-sao-get-return-checklist-return-upon',
            type: 'post',
            data: {
                'id': globalIDReturn,
                'remarks': remtoSend + '*' + $('.remarksText').val()
            },
            beforeSend: function()
            {
                $('#modal-loading').modal('show');
            },
            success: function(data)
            {
                console.log(data);

                btn.attr("disabled", false);

            },
            complete: function()
            {
                $('#modal-return-account').modal('hide');
                refTables();
                $('.test1').attr("checked", false);
                $('#othersCheck').attr("checked", false);
                $('.remarksText').val('');
                $('.remarksText').css('display', 'none');
                btn.attr("disabled", false);
                $('#modal-loading').modal('hide');
            }
        }
    );
});

$('#cc_sao_cancel_table').on('click','.btn_view_removeCancel',function ()
{
    var btn = $(this);
    btn.attr("disabled", true);

    var cancelID = $(this).attr("id");

    var cancelConfirm = confirm('Are you sure you want to Uncancel the account?');

    if(cancelConfirm == true)
    {
        $.ajax
        (
            {
                type: 'get',
                url: 'cc-sao-uncancel-account',
                data:{
                    'id': cancelID
                },
                success: function(data)
                {
                    if(data == 'ok')
                    {
                        alert('Account Successfully Uncancelled!');
                    }
                    else if(data == 'already')
                    {
                        alert('Account Already Uncancelled Please see logs.');
                    }

                    btn.attr("disabled", false);
                },
                complete: function()
                {
                    table_cancel.draw();
                    table_hold.draw();
                }
            }
        );
    }
    else
    {
        console.log('do nothing');
        btn.attr("disabled", false);
    }
});

var required_id = '';
$('#cc_sao_accounts_table').on('click', '.btn_required_docs', function()
{
    required_id = $(this).attr('id');
    $('#require_docs_modal').modal('show');
    $('#requireed_docs_rem').val('');
});

$('#notifyBiClient').click(function()
{
    var btn = $(this);
    if($('#requireed_docs_rem').val() != '')
    {
        btn.attr('disabled', true);

        $.ajax({
            type: 'get',
            url: 'notify_required_docs',
            data:{
                'id': required_id,
                'remarks': $('#requireed_docs_rem').val()
            },
            success: function(data)
            {
                console.log(data);
                alert(data);
                $('#require_docs_modal').modal('hide');
            },
            complete: function()
            {
                btn.attr('disabled', false);
                $('#requireed_docs_rem').val('');
            }
        });
    }
    else
    {
        alert('Please indicate remarks');
    }
});


var table_contact_numbers_grant;
getContactNumbers();

function getContactNumbers()
{

    console.log('run');
    $('#contact_grant_table thead tr th').each(function()
    {
        $(this).css('background-color', 'black');
        $(this).css('color', 'white');
    });

    table_contact_numbers_grant = $('#contact_grant_table').DataTable
    ({
        "responsive" : true,
        "processing" : true,
        "serverSide" : true,
        "ajax" : 'get_tele_grant_table',
        "columns":
            [
                {data: 'name', name: 'users.name'},
                {
                    data: function created_at(data)
                    {
                        if(data.created_at != null)
                        {
                            return data.created_at;
                        }
                        else
                        {
                            return 'N/A';
                        }
                    },
                    searchable: false,
                    orderable: false,
                    name: 'tele_contacts_grant.created_at'
                },
                // {data: 'created_at', name: 'tele_contacts_grant.created_at', searchable: false, orderable: false},
                {
                    data:function action(data)
                    {
                        if(data.access != null)
                        {
                            if(data.access == 'Grant')
                            {
                                return '<button class="btn btn-danger btn-sm btn-block account_grant" id="'+btoa(data.id)+'" type="grant">Deny</button>';
                            }
                            else if(data.access == 'Deny')
                            {
                                return '<button class="btn btn-success btn-sm btn-block account_grant" id="'+btoa(data.id)+'" type="deny">Grant</button>';
                            }
                        }
                        else
                        {
                            return '<button class="btn btn-success btn-sm btn-block account_grant" id="'+btoa(data.id)+'" type="grant">Grant</button>';
                        }
                    },
                    'name' : 'tele_contacts_grant.id',
                    searchable : false,
                    orderable : false
                }
            ],
        "order" :[[0, 'desc']],
        "pageLength" : 10,
        "lengthMenu" : [[2, 10, 25, 50, -1], ['2 rows', '10 rows', '25 rows', '50 rows', 'Show all']]
    });

    $('#contact_grant_table_filter input').unbind();
    $('#contact_grant_table_filter input').bind('keyup change', function(e)
    {
        if($(this).is(':focus'))
        {
            if (e.keyCode === 13) {
                table_contact_numbers_grant.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '') {
                    table_contact_numbers_grant.search($(this).val()).draw();
                }
            }
        }
    });
}

$('#contact_grant_table').on('click', '.account_grant', function()
{
    var id = atob($(this).attr('id'));
    var btn = $(this);

    // console.log([id, $(this).attr('type')]);

    if(confirm('Are you sure to grant/deny the user?'))
    {
        btn.attr('disabled', true);

        $.ajax({
            type :'get',
            url: 'cc_sao_granting_tele',
            data: {
                'id' : id,
                'type' : btn.attr('type')
            },
            success: function(data)
            {
                console.log(data);
                btn.attr('disabled', false);
                table_contact_numbers_grant.draw();
            }
        });
    }
    else
    {
        btn.attr('disabled', false);
    }
});

function get_general_mon_table()
{
    $('#cc_sao_gen_mon_table thead th').each(function()
    {
        title_general_mon[general_mon_count] = $(this).text();
        general_mon_count++;
        var title = $(this).text();
        $(this).html(title+'<br><input type="text" placeholder="Search" style="position: relative; width: 100%">');
    });

    table_general_mon = $('#cc_sao_gen_mon_table').DataTable
    ({
        "responsive": true,
        "processing": true,
        "serverSide": true,
        "ajax":
            {
                url: "cc-sao-get-general-mon-table",
                data: function (d)
                {

                    d.min_date_endorsed = $('#gen_mon_min').val();
                    d.max_date_endorsed = $('#gen_mon_max').val();
                }
            },
        dom: 'Blfrtip',
        buttons:
            [

                {
                    extend: 'excel',
                    exportOptions:
                        {
                            columns: ':visible',
                            format:
                                {
                                    header:  function (dt, idx, title)
                                    {
                                        return title_general_mon[(idx)];
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
                }
                // {
                //     extend: 'colvis',
                //     text: 'Show/Hide Column',
                //     columnText: function (dt, idx, title)
                //     {
                //         return title_general[(idx)];
                //     }
                // }
            ],
        "columns":
            [
                {data: 'endorse_id', name: 'bi_endorsements.id'}, //0
                {data: 'site', name: 'bi_endorsements.bi_account_name'}, //1
                {data: 'tor', name: 'bi_endorsements.type_of_endorsement_bank'}, //2
                // {data: 'date_time_endorsed', name: 'bi_endorsements.created_at'}, //3
                {
                    data : function d_t(data)
                    {
                        var date_time = data.date_time_endorsed;

                        var split = date_time.split(' ');

                        var time = split[1].split(':');

                        var final = time[0] + ':' + time[1];

                        return split[0] + ' ' +final;
                    },
                    name : 'bi_endorsements.created_at'
                }, //3
                {data: 'project', name: 'bi_endorsements.project'}, //4
                {data: 'account_name', name: 'bi_endorsements.account_name'}, //5
                {data: 'package', name: 'bi_endorsements.package'}, //6
                {data: 'check', name: 'bi_endorsements.id', 'searchable' : false, 'orderable' : false}, //7
                {data: 'assigned_tele', name: 'bi_endorsements.id', 'searchable' : false, 'orderable' : false}, //8
                {data: 'poc', name: 'bi_endorsements.endorser_poc'}, //9
                {data: 'attachments', name: 'bi_endorsements.attach_1'}, //10
                {data: 'due', name: 'bi_endorsements.date_time_due'},//11
                {
                    data: function contact_details(data)
                    {
                        if(data.tele_stat == 'Contacted')
                        {
                            console.log(data.tele_stat);

                            if(data.contact_details == null || data.contact_details == '')
                            {
                                return 'N/A';
                            }
                            else if(data.contact_details == 'Refused to be interviewed')
                            {
                                return '<p style="font-style: italic">'+data.contact_details+'</p>';
                            }
                            else if(data.contact_details == 'Verified applying')
                            {
                                return '<p style="font-style: italic">'+data.contact_details+'</p>';
                            }
                            else
                            {
                                return '<p style="font-style: italic">'+data.contact_details+'</p>';
                            }
                        }
                        else if(data.tele_stat == 'Uncontacted')
                        {

                            if(data.contact_details == null || data.contact_details == '')
                            {
                                return 'N/A';
                            }
                            else
                            {
                                return '<p style="font-style: italic">'+data.contact_details+'</p>';
                            }
                        }
                        else
                        {
                            return 'N/A';
                        }
                    },
                    'name': 'bi_endorsements.verify_tele_status_details',
                    'orderable' : false
                }, //12
                {
                    data : function action(data) {
                        return '<a id="'+data.endorse_id+'" class="btn_view_information_bi btn btn-xs btn-info btn-block" data-toggle="modal" data-target="" ><i class="glyphicon glyphicon-film"></i> View Information</a>';
                    },
                    'name' : 'action',
                    'searchable' : false,
                    'orderable' : false
                } //13
            ],

        "order": [[0, 'desc']],
        "pageLength": 10,
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

    $('#cc_sao_gen_mon_table_filter input').unbind();
    $('#cc_sao_gen_mon_table_filter input').bind('keyup change',function (e) {

        if($(this).is(':focus'))
        {
            if (e.keyCode == 13) {
                table_general_mon.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '') {
                    table_general_mon.search($(this).val()).draw();
                }
            }
        }
    });

    if(clientTypeAuth == 'bank')
    {
        table_general_mon.column(2).visible(true);
        table_general_mon.column(1).visible(false);
        table_general_mon.column(6).visible(false);
        table_general_mon.column(7).visible(false);
        table_general_mon.column(12).visible(true);
    }
    else if(clientTypeAuth == 'cc')
    {
        table_general_mon.column(2).visible(false);
        table_general_mon.column(1).visible(true);
        table_general_mon.column(6).visible(true);
        table_general_mon.column(7).visible(true);
        table_general_mon.column(12).visible(false);
    }
}

$('#cc_sao_pending_cancel_table').on('click', '.btn_view_reason ', function()
{
    $('#reasonofCancel').val($(this).attr('name'));
});

$('.gen_mon_date_range_click').click(function()
{
    var date = new Date();
    var day = date.getDate();
    var month = (date.getMonth() + 1);
    if(day <= 9)
    {
        day = '0'+day;
    }

    if(month <= 9)
    {
        month = '0'+month;
    }

    var newdate = date.getFullYear() + '-' + month + '-' + day;

    if($(this).val() === 'all')
    {
        $('#gen_mon_date_pick_holder').hide();
        $('#gen_mon_max').val('6000-01-01');
        $('#gen_mon_min').val('2015-01-01');
    }
    else
    {
        $('#gen_mon_date_pick_holder').show();
        $('#gen_mon_min').val(newdate);
        $('#gen_mon_max').val(newdate);
    }

    table_general_mon.draw();
});

$('.gen_mon_date_range_dates').change(function()
{
    table_general_mon.draw();
});

$('.gen_search_date_range_click').click(function()
{
    if($(this).val() != 'all')
    {
        $('#gen_search_date_pick_holder').show();
    }
    else
    {
        $('#gen_search_date_pick_holder').hide();
    }

    table_general_search.draw();
});

$('.gen_search_date_range_dates').change(function()
{
    table_general_search.draw();
});