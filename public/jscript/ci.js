/**
 * Created by aa on 9/7/2017.
 */
var table;
var tableFinishAccount;
var toastr;
var attachclick = false;
var accountID;
var status = 0;
var acctID;
var expcount = 0;
var getExpID = '';
var checkifupdate = [];
var tableFundReceiveAccept;
var tableExpensesReport = '';
var kung_may_shell = '';
var storeuser = [];
var name_of_ci = '';
var tableFundReceiveLiquidation;
var table_fund_id;
var statusLiq;
var declareData;
var imageContainerFund;
var imgContainerId;
var imgCountArray;

var dataLengthforFiles;
var tableFundReceive;
var tableFundDoneLiq;
var bi_rep_array = [];
var bi_rep_array_edit = [];
var permissionUpdateTime = false;
var checkAccountUpdateTimeVisit = false;
var checkAcctPendingFinish = false;
var tableGenIssuanceCI;



$.ajaxSetup
({
    headers:
        {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});


$('#spanhere').html('<center><button id="btnviewuploadedfile" type="button" class="btn btn-info" style="margin-bottom: 5px; margin-top: 5px; margin-left: 10px; margin-right: 10px">View Uploaded File</button></center>');
// console.log('span tirggeer!');
// $('#spanhere').html('sdfsdfsdfsdfsdfsfsdf');
$('#btnviewuploadedfile').click(function () {
    refresh();
});

funcIssuanceGenMonitCI();

function refresh()
{

    // console.log('refresh tirggeer!');
    // // console.log(accountID);
    var id = 0;
    var getfiles = '';
    $('#spanhere').html("");

    // // console.log(status);
    $('#ProgBar').html('');
    $.ajax({
        url: '/ci-endorse-viewitems',
        type: 'GET',
        data:
            {
                'id': id,
                'AcctIDid': accountID,
                'status': status
            },
        dataType: 'json',
        success: function (data) {
            // console.log(data);

            var ctr = 0;

            if (data.length === 0) {
                table.ajax.reload(null, false);
                tableFinishAccount.ajax.reload(null, false);
            }

            for (ctr; ctr <= data[0].length - 1; ctr++) {
                if (data[1].cert === 'NC') {
                    getfiles += '<tr>' +

                        '<td style="width: 30%">' +
                        '<img src= "storage\\account\\' + data[2] + '\\' + data[0][ctr] + '" style="width: 30%; margin-top: 10px; margin-bottom: 10px">' +
                        '</td>' +
                        '<td>'
                        + data[0][ctr] +
                        '</td>' +
                        '<td> ' +
                        '<button id="btnDelete-' + ctr + '" name="' + data[0][ctr] + '" type="button" class="btn btn-danger" style="margin-bottom: 5px; margin-top: 5px; margin-left: 10px; margin-right: 10px">Delete</button>' +
                        ' </td>' +
                        '</tr>';
                }
                else {
                    getfiles += '<tr>' +

                        '<td style="width: 30%">' +
                        '<img src="storage\\account_client\\' + data[2] + '\\' + data[0][ctr] + '" style="width: 30%; margin-top: 10px; margin-bottom: 10px">' +
                        '</td>' +
                        '<td>'
                        + data[0][ctr] +
                        '</td>' +
                        '<td> ' +
                        '<button id="btnDelete-' + ctr + '" name="' + data[0][ctr] + '" type="button" class="btn btn-danger" style="margin-bottom: 5px; margin-top: 5px; margin-left: 10px; margin-right: 10px">Delete</button>' +
                        ' </td>' +
                        '</tr>';
                }

            }

            // console.log('span tirggeer!');

            $('#spanhere').html('<center><button id="btnviewuploadedfilehide" type="button" class="btn btn-info" style="margin-bottom: 5px; margin-top: 5px; margin-left: 10px; margin-right: 10px">Hide</button></center>'
                + "\n" +
                "<table style=\"text-align: center; border-color: black;\" border='1' width=\"100%\">" +
                "<tr>\n" +
                "<th style='text-align: center;'>Image/s</th>" +
                "<th style='text-align: center;'>File List</th>" +
                "<th style='text-align: center;'>Action</th>" +
                "</tr>" + getfiles + "</table>"
            );

            $('#btnviewuploadedfilehide').click(function () {
                $('#spanhere').html('<center><button id="btnviewuploadedfile" type="button" class="btn btn-info" style="margin-bottom: 5px; margin-top: 5px; margin-left: 10px; margin-right: 10px">View Uploaded File</button></center>');
                $('#btnviewuploadedfile').click(function () {
                    refresh();
                });
            });


            var i = 0;
            for (i; i <= ctr - 1; i++) {
                $('#btnDelete-' + i + '').click(function (event) {
                    var getname = event.target;
                    gettrimname = getname.name;
                    $.ajax
                    ({
                        type: 'get',
                        url: '/ci-endorse-deleteitemqwqwqwqwqwqwqcHV0YQ==/' + gettrimname,
                        data:
                            {
                                'AcctID': accountID
                            },
                        success: function (data) {

                            id = 0;
                            getfiles = '';
                            $('#spanhere').html("");
                            refresh();

                        },
                        error: function (data) {
                            // console.log("fail");
                        }

                    });
                });
            }
        },
        error : function () {
            // console.log('error');
        }
    });
}

get_table_endorse();
checkLogIn();

function checkLogIn()
{
    $.ajax
    ({
        type : 'get',
        url : 'ci-check-login',
        success : function(data)
        {
            console.log(data);

            if(data == 0)
            {
                $('#modal-upload-selfie-daily').modal('show');
            }
            else
            {

            }
        }
    })
}

function get_table_endorse ()
{
    table = $('#ci-table').DataTable(
        {
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "ajax": "/new-ci-endorsement",
            "columns":
                [
                    {data: 'id', name: 'endorsements.id'},
                    {data: 'account_name', name: 'endorsements.account_name'},
                    {data: 'tat', name: 'endorsements.time_due'},
                    {data: 'client_name', name: 'endorsements.client_name'},
                    {data: 'type_of_request', name: 'endorsements.type_of_request'},
                    // {data: 'type_of_loan', name: 'endorsements.type_of_loan'},
                    {
                        data: function actions(data) {
                            var todisp = '';

                            if (data.subjnames == 'NONE') {
                                todisp = data.subjcoob;
                            }
                            else {
                                todisp = data.subjcoob + '\n<b>(' + data.subjnames + ')</b>';
                            }

                            return todisp;
                        },
                        "orderable": false,
                        "searchable": false,
                        "name": 'type_of_subjects.type_of_subject_name',
                        "autoWidth": false
                    },
                    {data: 'verify_through', name: 'endorsements.verify_through'},
                    {data: 'client_remarks', name: 'endorsements.client_remarks'},
                    {data: 're_ci', name: 'endorsements.re_ci'},
                    {
                        data: function actions(data) {

                            return ' <a name="' + data.id + '" class="btn btn-xs btn-block btn-primary" id="btnOtherInfo" data-toggle="modal" data-target="#otherInfo"><i class="glyphicon glyphicon-search"></i> View Information</a>';

                        },
                        "orderable": false,
                        "searchable": false,
                        "name": 'type_of_subjects.type_of_subject_name',
                        "autoWidth": false
                    },
                    {
                        data: function actions(data) {
                            if (data.acct_status === '1') {
                                return '<a name="' + data.id + '" name ="' + data.acct_status + '" class="btn btn-xs btn-block btn-warning" id="btnAttachFile" data-toggle="modal" data-target="#acctReport"><i class="glyphicon glyphicon-edit"></i> Attach Photos/Files</a>';
                            }
                            else if (data.acct_status === '3') {

                                return '<a name="' + data.id + '" name ="' + data.acct_status + '"class="btn btn-xs btn-block btn-success" id="btnAttachFile" data-toggle="modal" data-target="#acctReport"><i class="glyphicon glyphicon-check"></i> Attach Photos/Files</a>';
                            }
                            else {
                                return '<a name="' + data.id + '" name ="' + '2' + '" class="btn btn-xs btn-block btn-info" id="btnAttachFile" data-toggle="modal" data-target="#acctReport"><i class="glyphicon glyphicon-edit"></i> Update Photos/Files</a>';
                            }

                        },
                        "orderable": false,
                        "searchable": false,
                        "name": 'endorsements.acct_status',
                        "autoWidth": true
                    },
                    {
                        data: function report(data) {
                            if (data.endorsement_report === null) {
                                return '<a name="' + data.id + '" name ="' + data.acct_status + '" class="btn btn-xs btn-block btn-warning" id="btnViewAttachReport" data-toggle="modal" data-target="#modal-ci-report"><i class="glyphicon glyphicon-edit"></i> Add Reports/Notes</a>';
                            }
                            else {

                                return '<a name="' + data.id + '" name ="' + data.acct_status + '" class="btn btn-xs btn-block btn-info" id="btnViewUpdateReport" data-toggle="modal" data-target="#modal-ci-report"><i class="glyphicon glyphicon-edit"></i> Update Reports/Notes</a>';
                            }
                        },
                        "orderable": false,
                        "searchable": false,
                        "name": 'endorsements.acct_status',
                        "width": '9%'
                    },
                    {data : 'tim_disp', name : 'endorsements.time_dispatched', visible: false}

                ],
            "order": [[12, 'desc']],
            "pageLength": 10,
            "bSortClasses": false,
            "autoWidth": false,
            "columnDefs" : [
                { className : "id_checkerrr", 'targets': [ 0 ]}
            ]
            // "drawCallback": function()
            // {
            //     var acc_to_ack = [];
            //
            //     $('#ci-table tbody .id_checkerrr').each(function()
            //     {
            //         acc_to_ack.push($(this).text());
            //     });
            //
            //     // console.log(acc_to_ack);
            //
            //     $.ajax({
            //         type: 'get',
            //         url: '/endorsement-seen-check',
            //         data: {
            //             'acc_id' : acc_to_ack
            //         },
            //         success: function(data)
            //         {
            //             console.log(data);
            //         }
            //     });
            // }
        });
}

function get_table_finish_endorse() {
    tableFinishAccount = $('#ci-table-finish').DataTable(
        {
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "ajax": "/ci-get-finish-endorsement",
            "columns":
                [
                    {data: 'id', name: 'endorsements.id'},
                    {data: 'account_name', name: 'endorsements.account_name'},
                    {
                        data: function (data) {

                            var status = '';

                            if(data.endorsement_status_internal == 'TAT')
                            {
                                status = '<small class="label bg-green">ON TAT</small>';
                            }
                            else if (data.endorsement_status_internal == 'OVERDUE')
                            {
                                status = '<small class="label bg-black">OVERDUE</small>';
                            }
                            else
                            {
                                status = '<small class="label bg-black">UNDECLARED</small>';
                            }

                            return data.ci_internal_status+' '+status;

                        },
                        'name': 'endorsements.endorsement_status_internal'
                    },
                    {data: 'client_name', name: 'endorsements.client_name'},
                    {data: 'type_of_request', name: 'endorsements.type_of_request'},
                    // {data: 'type_of_loan', name: 'endorsements.type_of_loan'},
                    {
                        data: function actions(data) {
                            var todisp = '';

                            if (data.subjnames == 'NONE') {
                                todisp = data.subjcoob;
                            }
                            else {
                                todisp = data.subjcoob + '\n<b>(' + data.subjnames + ')</b>';
                            }

                            return todisp;
                        },
                        "orderable": false,
                        "searchable": false,
                        "name": 'type_of_subjects.type_of_subject_name',
                        "autoWidth": false
                    },
                    {data: 'verify_through', name: 'endorsements.verify_through'},
                    {data: 'client_remarks', name: 'endorsements.client_remarks'},
                    {data: 're_ci', name: 'endorsements.re_ci'},
                    {
                        data: function actions(data) {
                            return ' <a name="' + data.id + '" class="btn btn-xs btn-block btn-primary" id="btnOtherInfo" data-toggle="modal" data-target="#otherInfo"><i class="glyphicon glyphicon-search"></i> View Information</a>';

                        },
                        "orderable": false,
                        "searchable": false,
                        "name": 'Coborrower/Addresses',
                        "autoWidth": false
                    },
                    {
                        data: function actions(data) {
                            if (data.acct_status === '1') {
                                return '<a name="' + data.id + '" name ="' + data.acct_status + '" class="btn btn-xs btn-block btn-warning" id="btnAttachFile" data-toggle="modal" data-target="#acctReport"><i class="glyphicon glyphicon-edit"></i> Attach Photos/Files</a>';
                            }
                            else if (data.acct_status === '3') {

                                return '<a name="' + data.id + '" name ="' + data.acct_status + '"class="btn btn-xs btn-block btn-success" id="btnAttachFile" data-toggle="modal" data-target="#acctReport"><i class="glyphicon glyphicon-check"></i> Attach Photos/Files</a>';
                            }
                            else {
                                return '<a name="' + data.id + '" name ="' + '2' + '" class="btn btn-xs btn-block btn-info" id="btnAttachFile" data-toggle="modal" data-target="#acctReport"><i class="glyphicon glyphicon-edit"></i> Update Photos/Files</a>';
                            }

                        },
                        "orderable": false,
                        "searchable": false,
                        "name": 'action',
                        "autoWidth": true
                    },
                    {
                        data: function report(data) {
                            if (data.endorsement_report === null) {
                                return '<a name="' + data.id + '" name ="' + data.acct_status + '" class="btn btn-xs btn-block btn-warning" id="btnViewAttachReport" data-toggle="modal" data-target="#modal-ci-report"><i class="glyphicon glyphicon-edit"></i> Add Reports/Notes</a>';
                            }
                            else {
                                return '<a name="' + data.id + '" name ="' + data.acct_status + '" class="btn btn-xs btn-block btn-info" id="btnViewUpdateReport" data-toggle="modal" data-target="#modal-ci-report"><i class="glyphicon glyphicon-edit"></i> Update Reports/Notes</a>';
                            }
                        },
                        "orderable": false,
                        "searchable": false,
                        "name": 'action',
                        "width": '9%'
                    },
                    // {
                    //     data: function report(data) {
                    //
                    //         // if(data.fund_request == 'fund_uploaded')
                    //         // {
                    //             return '<a name="' + data.id + '" value="'+data.account_name+'" class="btn btn-xs btn-block btn-warning" id="btnAddExpensesFromTable" data-toggle="modal" data-target="#modal_expenses"><i class="fa fa-book"></i> Add Expenses</a>';
                    //         // }
                    //         // else
                    //         // {
                    //         //     return 'NO FUND FOR THIS ACCOUNT';
                    //         // }
                    //     },
                    //     "orderable": false,
                    //     "searchable": false,
                    //     "name": 'action',
                    //     "width": '9%'
                    // }
                    {data : 'time_fwd', name : 'endorsements.time_ci_forwarded', visible: false}
                ],
            "order": [[12, 'desc']],
            "pageLength": 10,
            "bSortClasses": false,
            "autoWidth": false
        });
}

function get_table_pending_fund() {
    tableFundReceive = $('#table-fund-receive').DataTable
    ({
        "responsive": true,
        "processing": true,
        "serverSide": true,
        "ajax": "/ci-fund-receive-table",
        "columns":
            [
                {data: 'id', name: 'ci_fund_remittances.id'},
                {
                    data: function type(data)
                    {
                        var remittance_check = data.remittance_id;
                        var atm_check = data.ci_atm_fund_id;
                        var shell_check = data.ci_shell_card_id;

                        var type = '';

                        if(remittance_check != 0)
                        {
                            type = 'Remittance';

                            if(shell_check !=0)
                            {
                                type = 'Remittance with Shell Card';
                            }
                        }
                        else if(atm_check != 0)
                        {
                            type = 'ATM';

                            if(shell_check !=0)
                            {
                                type = 'ATM with Shell Card';
                            }
                        }
                        else if(shell_check != 0 && remittance_check == 0 && atm_check == 0)
                        {
                            type = 'Shell Card';
                        }

                        return type;
                    },
                    "orderable": false,
                    "searchable": false,
                    "name": 'type',
                    "autoWidth": false
                },
                {
                    data: function type(data) {

                        var remittance_check = data.remittance_id;
                        var atm_check = data.ci_atm_fund_id;
                        var shell_check = data.ci_shell_card_id;

                        var date_time_of_send = '';

                        if(remittance_check != 0)
                        {
                            date_time_of_send = data.remit_date_of_send;
                        }
                        else if(atm_check != 0)
                        {
                            date_time_of_send = data.atm_date_of_send;

                        }
                        else if(shell_check != 0 && remittance_check == 0 && atm_check == 0)
                        {
                            date_time_of_send = data.shell_date_of_send;

                        }
                        return date_time_of_send;
                    },
                    "orderable": false,
                    "searchable": false,
                    "name": 'type',
                    "autoWidth": false
                },
                {
                    data: function type(data) {

                        var remittance_check = data.remittance_id;
                        var atm_check = data.ci_atm_fund_id;
                        var shell_check = data.ci_shell_card_id;
                        var fund_amount = atob(data.fund_amount);

                        var amount = '';

                        if(remittance_check != 0)
                        {
                            amount = atob(data.remit_amount);
                        }
                        else if(atm_check != 0)
                        {
                            amount = data.atm_amount;

                        }
                        else if(shell_check != 0 && remittance_check == 0 && atm_check == 0)
                        {
                            amount = fund_amount;

                        }
                        return amount;
                    },
                    "orderable": false,
                    "searchable": false,
                    "name": 'type',
                    "autoWidth": false
                },
                {
                    data: function type(data) {

                        var remittance_check = data.remittance_id;
                        var atm_check = data.ci_atm_fund_id;
                        var shell_check = data.ci_shell_card_id;

                        var bank_account = '';

                        if(remittance_check != 0)
                        {
                            bank_account = '-';
                        }
                        else if(atm_check != 0)
                        {
                            bank_account = data.atm_bank_name+': '+data.atm_account_number;

                        }
                        else if(shell_check != 0 && remittance_check == 0 && atm_check == 0)
                        {
                            bank_account = '-';

                        }
                        return bank_account;
                    },
                    "orderable": false,
                    "searchable": false,
                    "name": 'type',
                    "autoWidth": false
                },
                {data: 'remit_info', name: 'remit_info.id', orderable: false, searchable: false, autoWidth: false},
                {data: 'stats', name: 'remit_info.id', orderable: false, searchable: false, autoWidth: false},
                {data: 'fund_id', name: 'fund_requests.id'},
                {
                    data: function action(data) {

                        return '<a name="' + data.id + '" class="btn btn-xs btn-block btn-info" id="btn_trigger_modal" data-toggle="modal" data-target="#modal_ci_endorsements_fund_pending"><i class="fa fa-list"></i> Show Accounts</a>';

                    },
                    "orderable": false,
                    "searchable": false,
                    "name": 'type',
                    "autoWidth": false
                }
            ],
        "order": [[0, 'desc']],
        "pageLength": 10,
        "bSortClasses": false,
        "autoWidth": false
    });
}

function get_table_receive_fund()
{
    tableFundReceiveAccept = $('#table-fund-receive-accept').DataTable(
        {
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "ajax": "/ci-fund-receive-accept-table",
            "columns":
                [
                    {data: 'fund_id', name: 'fund_requests.id'},
                    {
                        data: function type(data)
                        {
                            var remittance_check = data.remittance_id;
                            var atm_check = data.ci_atm_fund_id;
                            var shell_check = data.ci_shell_card_id;

                            var type = '';

                            if(remittance_check == 0 && atm_check == 0)
                            {
                                type = 'Assigned by SAO';
                            }
                            else if(remittance_check != 0)
                            {
                                type = 'Remittance';

                                if(shell_check !=0)
                                {
                                    type = 'Remittance with Shell Card';
                                }
                            }
                            else if(atm_check != 0)
                            {
                                type = 'ATM';

                                if(shell_check !=0)
                                {
                                    type = 'ATM with Shell Card';
                                }
                            }
                            else if(shell_check != 0 && remittance_check == 0 && atm_check == 0)
                            {
                                type = 'Shell Card Only';
                            }

                            return type;
                        },
                        "orderable": false,
                        "searchable": true,
                        "name": 'ci_fund_remittances.remittance_id',
                        "autoWidth": false
                    },
                    {
                        data: function type(data)
                        {

                            var remittance_check = data.remittance_id;
                            var atm_check = data.ci_atm_fund_id;
                            var shell_check = data.ci_shell_card_id;

                            var date_time_of_send = '';

                            if(remittance_check == 0 && atm_check == 0 && shell_check == 0)
                            {
                                date_time_of_send = data.confirm_fund;
                            }
                            else if(remittance_check != 0)
                            {
                                date_time_of_send = data.remit_date_of_send;
                            }
                            else if(atm_check != 0)
                            {
                                date_time_of_send = data.atm_date_of_send;

                            }
                            else if(shell_check != 0 && remittance_check == 0 && atm_check == 0)
                            {
                                date_time_of_send = data.shell_date_of_send;
                            }
                            return date_time_of_send;
                        },
                        "orderable": false,
                        "searchable": true,
                        "name": 'ci_fund_remittances.remittance_id',
                        "autoWidth": false
                    },
                    {
                        data: function type(data) {

                            var remittance_check = data.remittance_id;
                            var atm_check = data.ci_atm_fund_id;
                            var shell_check = data.ci_shell_card_id;

                            var bank_account = '';

                            if(remittance_check == 0 && atm_check == 0 && shell_check == 0)
                            {
                                bank_account = '-'
                            }
                            else if(remittance_check != 0)
                            {
                                bank_account = '-';
                            }
                            else if(atm_check != 0)
                            {
                                bank_account = data.atm_bank_name+': '+data.atm_account_number;

                            }
                            else if(shell_check != 0 && remittance_check == 0 && atm_check == 0)
                            {
                                bank_account = '-';
                            }
                            return bank_account;
                        },
                        "orderable": false,
                        "searchable": true,
                        "name": 'ci_fund_remittances.remittance_id',
                        "autoWidth": false
                    },
                    {data: 'remit_info', name: 'remit_info.id', orderable: false, searchable: false, autoWidth: false},
                    {
                        data: function type(data) {

                            var remittance_check = data.remittance_id;
                            var atm_check = data.ci_atm_fund_id;
                            var shell_check = data.ci_shell_card_id;

                            var date_time_receive = '';

                            if(remittance_check == 0 && atm_check == 0 && shell_check == 0)
                            {
                                date_time_receive = data.confirm_fund;
                            }
                            else if(remittance_check != 0)
                            {
                                date_time_receive = data.remit_status_date_time;
                            }
                            else if(atm_check != 0)
                            {
                                date_time_receive = data.atm_status_date_time;

                            }
                            else if(shell_check != 0 && remittance_check == 0 && atm_check == 0)
                            {
                                date_time_receive = data.shell_status_date_time;

                            }
                            return date_time_receive;
                        },
                        "orderable": false,
                        "searchable": true,
                        "name": 'ci_fund_remittances.remittance_id',
                        "autoWidth": false
                    },
                    {
                        data: function type(data) {

                            var remittance_check = data.remittance_id;
                            var atm_check = data.ci_atm_fund_id;
                            var shell_check = data.ci_shell_card_id;

                            var amount = '';

                            if(remittance_check == 0 && atm_check == 0 && shell_check == 0)
                            {
                                amount = atob(data.fund_amount);
                            }
                            else if(remittance_check != 0)
                            {
                                amount = atob(data.remit_amount);
                            }
                            else if(atm_check != 0)
                            {
                                amount = data.atm_amount;

                            }
                            else if(shell_check != 0 && remittance_check == 0 && atm_check == 0)
                            {
                                var decodeAmount = atob(data.fund_amount);
                                amount = decodeAmount;

                            }
                            return amount;
                        },
                        "orderable": false,
                        "searchable": true,
                        "name": 'ci_fund_remittances.remittance_id',
                        "autoWidth": false
                    },
                    {data : 'liq', name : 'fund_requests.liquidated_amount'},
                    {data : 'unliq', name : 'fund_requests.unliquidated_amount'},
                    {data: 'stats', name: 'stats', orderable: false, searchable: false, autoWidth: false},
                    {
                        data: function action(data)
                        {

                            var reqrem = '';
                            var req = '';

                            console.log(data.tor)

                            if(data.tor == 'NORMAL REQUEST')
                            {
                                reqrem = data.dispatcher_remarks+'||==||'+data.name_disp;
                            }
                            else if(data.tor == 'EMERGENCY FUND')
                            {
                                reqrem = data.sao_remarks+'||==||'+data.name_sao;
                            }

                            if(data.tor == 'NORMAL REQUEST')
                            {
                                req = '';
                            }
                            else if(data.tor == 'EMERGENCY FUND')
                            {
                                req = '<button class="btnViewManagementRem btn btn-block btn-xs btn-danger" style="width : 100%" name = "'+data.rem_manage+'||==||'+data.manage_name+'">VIEW MANAGEMENT REMARKS</button>';
                            }

                            return '<a name="' + data.id + '" class="btn btn-xs btn-block btn-info" id="btn_trigger_modal" data-toggle="modal" data-target="#modal_ci_endorsements_fund"><i class="fa fa-list"></i> Liquidate</a>' +
                                '<button class = "btnShowRemarksRequestor btn-xs btn-primary btn-block"  style="width: 100%" name = "'+reqrem+'" >VIEW REQUESTOR REMARKS</button>' + req;
                        },
                        "orderable": false,
                        "searchable": false,
                        "name": 'ci_fund_remittances.remittance_id',
                        "autoWidth": false
                    },

                ],
            "order": [[0, 'desc']],
            "pageLength": 10,
            "bSortClasses": false,
            "autoWidth": false
        });

    $('#table-fund-receive-accept_filter input').unbind();
    $('#table-fund-receive-accept_filter input').bind('keyup change',function (e) {

        if($(this).is(':focus'))
        {
            if (e.keyCode == 13) {
                tableFundReceiveAccept.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '') {
                    tableFundReceiveAccept.search($(this).val()).draw();
                }
            }
        }
    });
}

$('#table-fund-receive-accept').on('click', '.btnViewManagementRem', function()
{
    $('#req_rem_remarks_manage').val('');
    $('#dispatcher_req_name').val('');
    $('#modal-req-rem-manage').modal('show');

    var get_rem_name = $(this).attr('name').split('||==||');

    $('#manage_req_name').text(get_rem_name[1]);
    $('#req_rem_remarks_manage').val(get_rem_name[0]);
});

$('#table-fund-receive-accept').on('click', '.btnShowRemarksRequestor', function()
{
    $('#req_rem_remarks').val('');
    $('#dispatcher_req_name').val('');
    $('#modal-req-rem').modal('show');

    var get_rem_name = $(this).attr('name').split('||==||');

    $('#dispatcher_req_name').text(get_rem_name[1]);
    $('#req_rem_remarks').val(get_rem_name[0]);
});




$(document).ready(function ()
{

    $('#tab1_pending').html('Pending Accounts');

    // get_messages_info();
    // setTimeout(function ()
    // {
    //     $('#tab1').click();
        $('#tab1_pending').click();
    // },1000);

    tableExpensesReport = $('#table-expenses-report').DataTable(
        {
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "ajax": "/ci_get_expenses_report_table",
            "columns":
                [
                    {data: 'id', name: 'ci_daily_expenses_date.id'},
                    {data: 'date', name: 'ci_daily_expenses_date.date'},
                    {data: 'label_edit', name: 'ci_daily_expenses.label'},
                    {data: 'amount_edit', name: 'ci_daily_expenses.amount'},
                    {data: 'from_edit', name: 'ci_daily_expenses.from'},
                    {data: 'amount_total_edit', name: 'ci_daily_expenses.amount'},
                    {data: 'or_edit', name: 'ci_daily_expenses.or_attachment'},
                    {data: 'remarks_edit', name: 'ci_daily_expenses.remarks'},
                    {data: 'account_edit', name: 'endorsements.type_of_request'}
                ],
            "order": [[0, 'desc']],
            "pageLength": 10,
            "bSortClasses": false,
            "autoWidth": false
        });

    $(document).on('click', '#btnAttachFile', function (event) {
        //  var tr = $(this).closest('tr');

        $('#otherInfoSpan').html('');
        $('#otherEmployerSpan').html('');
        $('#otherBusinessSpan').html('');
        $('#otherPersonalSpan').html('');


        acctID = $(this).attr("name");

        var acctName = '';
        var dateDue = '';
        var timeDue = '';
        var address = '';
        var typeOfRequest = '';

        $.ajax({
            url: '/ci-get-attach-info',
            type: 'GET',
            data:
                {
                    'acctID': acctID
                },
            success: function (data) {

                acctName = data[0].account_name;
                dateDue = data[0].date_due;
                timeDue = data[0].time_due;
                address = data[0].address + ", " + data[0].city_muni + ", " + data[0].provinces;
                typeOfRequest = data[0].type_of_request;


                $(".acctID").html('ID: ' + acctID);
                $('#acctID').val(acctID);
                $(".acctName").html('Account Name: ' + acctName);
                $("#acctName").val(acctName);
                $(".dateDue").html('Date Time Due: ' + dateDue + ' ' + timeDue);
                $(".coborName").html('Address: ' + address);
                $(".typeOfRequest").html('Type of Request: ' + typeOfRequest);

                if(data[1].cert != 'NC')
                {
                    $('#box_body_update_date_time_visit').parent().show();
                    $('#box_body_encode').parent().show();
                    $('#box_body_attachement').parent().show();
                    $('.to_be_clear').remove();
                }
                else
                {
                    if(data[0][0].acct_status == 3)
                    {
                        $('#box_body_update_date_time_visit').parent().hide();
                        $('#box_body_encode').parent().hide();
                        $('#box_body_attachement').parent().hide();
                        $('.to_be_clear').remove();
                        $('#modal_body_enoding').after('' +
                            '<div class="row to_be_clear" style="border: 1px solid black;margin:2px 4px;">' +
                            '<div class="col-md-12">' +
                            '<div class="form-group">' +
                            '<center>' +
                            '<h4>ACCOUNT ALREADY SUBMITTED TO THE CLIENT</h4>' +
                            '</center>' +
                            '</div>' +
                            '</div>' +
                            '</div>')
                    }
                    else
                    {
                        $('#box_body_update_date_time_visit').parent().show();
                        $('#box_body_encode').parent().show();
                        $('#box_body_attachement').parent().show();
                        $('.to_be_clear').remove();
                    }
                }


            }
        });

        $.ajax({
            url: '/dispatcher-get-other-info',
            type: 'GET',
            data:
                {
                    'acctID': acctID
                },
            success: function (data) {
                // // console.log(data);

                if (data.length === 0) {
                    // console.log('data empty');
                }
                else {

                    $('#otherInfoSpan').html
                    (
                        '<tr style="background-color: brown; color: white">' +
                        '   <th style=\'text-align: center;\'>COBORROWER NAME</th>' +
                        '   <th style=\'text-align: center;\'>ADDRESS</th>' +
                        '   <th style=\'text-align: center;\'>CITY/MUNICIPALITY</th>' +
                        '   <th style=\'text-align: center;\'>PROVINCE</th>' +
                        '</tr>'
                    );

                    for (ctrr = 0; ctrr <= (data[0].length) - 1; ctrr++) {
                        $('#otherInfoSpan').append
                        (
                            '<tr>' +
                            '   <td style="padding: 3px;">' + data[0][ctrr].coborrower_name + '</td>' +
                            '   <td style="padding: 3px;">' + data[0][ctrr].coborrower_address + '</td>' +
                            '   <td style="padding: 3px;">' + data[0][ctrr].coborrower_municipality + '</td>' +
                            '   <td style="padding: 3px;">' + data[0][ctrr].coborrower_province + '</td>' +
                            '</tr>'
                        );
                    }

                    $('#otherEmployerSpan').html
                    (
                        '<tr style="background-color: brown; color: white">' +
                        '   <th style=\'text-align: center;\'>EMPLOYER NAME</th>' +
                        '   <th style=\'text-align: center;\'>ADDRESS</th>' +
                        '   <th style=\'text-align: center;\'>CITY/MUNICIPALITY</th>' +
                        '   <th style=\'text-align: center;\'>PROVINCE</th>' +
                        '</tr>'
                    );

                    for (ctrr = 0; ctrr <= (data[1].length) - 1; ctrr++) {
                        $('#otherEmployerSpan').append
                        (
                            '<tr>' +
                            '   <td style="padding: 3px;">' + data[1][ctrr].employer_name + '</td>' +
                            '   <td style="padding: 3px;">' + data[3][ctrr].address + '</td>' +
                            '   <td style="padding: 3px; text-transform: uppercase">' + data[3][ctrr].muni_name + '</td>' +
                            '   <td style="padding: 3px;">' + data[3][ctrr].provinces + '</td>' +
                            '</tr>'
                        );
                    }

                    $('#otherBusinessSpan').html
                    (
                        '<tr style="background-color: brown; color: white">' +
                        '   <th style=\'text-align: center;\'>BUSINESS NAME</th>' +
                        '   <th style=\'text-align: center;\'>ADDRESS</th>' +
                        '   <th style=\'text-align: center;\'>CITY/MUNICIPALITY</th>' +
                        '   <th style=\'text-align: center;\'>PROVINCE</th>' +
                        '</tr>'
                    );

                    for (ctrr = 0; ctrr <= (data[2].length) - 1; ctrr++) {
                        $('#otherBusinessSpan').append
                        (
                            '<tr>' +
                            '   <td style="padding: 3px;">' + data[2][ctrr].business_name + '</td>' +
                            '   <td style="padding: 3px;">' + data[3][ctrr].address + '</td>' +
                            '   <td style="padding: 3px; text-transform: uppercase">' + data[3][ctrr].muni_name + '</td>' +
                            '   <td style="padding: 3px;">' + data[3][ctrr].provinces + '</td>' +
                            '</tr>'
                        );
                    }

                    $('#otherPersonalSpan').html
                    (
                        '<tr style="background-color: brown; color: white">' +
                        '   <th style=\'text-align: center;\'>ACCOUNT NAME</th>' +
                        '   <th style=\'text-align: center;\'>ADDRESS</th>' +
                        '   <th style=\'text-align: center;\'>CITY/MUNICIPALITY</th>' +
                        '   <th style=\'text-align: center;\'>PROVINCE</th>' +
                        '</tr>'
                    );

                    for (ctrr = 0; ctrr <= (data[3].length) - 1; ctrr++) {
                        $('#otherPersonalSpan').append
                        (
                            '<tr>' +
                            '   <td style="padding: 3px;">' + data[3][ctrr].account_name + '</td>' +
                            '   <td style="padding: 3px;">' + data[3][ctrr].address + '</td>' +
                            '   <td style="padding: 3px; text-transform: uppercase">' + data[3][ctrr].muni_name + '</td>' +
                            '   <td style="padding: 3px;">' + data[3][ctrr].provinces + '</td>' +
                            '</tr>'
                        );
                    }

                    // // console.log(data[3][0].type_of_request);

                    if (data[3][0].type_of_request === 'PDRN') {
                        $('#otherPersonalSpan').show();

                        $('#otherInfoSpan').show();
                        $('#otherBusinessSpan').hide();
                        $('#otherEmployerSpan').hide();
                    }
                    else if (data[3][0].type_of_request === 'BVR') {
                        $('#otherPersonalSpan').show();


                        $('#otherInfoSpan').hide();
                        $('#otherBusinessSpan').show();
                        $('#otherEmployerSpan').hide();
                    }
                    else if (data[3][0].type_of_request === 'EVR') {
                        $('#otherPersonalSpan').show();

                        $('#otherInfoSpan').hide();
                        $('#otherBusinessSpan').hide();
                        $('#otherEmployerSpan').show();
                    }


                }
            }
        });

        check_validation_encode_attach_visit(acctID,'no_refresh');

        $('.btn_en_hide_upper').each(function () {
            if($(this).attr('val') == 'show')
            {
                $(this).click();
            }
            // console.log('check - '+ $(this).attr('name') )
        })


    });

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

                var link = btoa('DownloadableForms');
                // var file = btoa();
                toshow += '<a href="download_storage/'+link+'/' +data[ctr]+ '" style="color: white" ><button class="btn btn-info btn-md btn-block">' + data[ctr] + '</button></a> ';

            }

            $('#getfiles').html(toshow);


        }
    });

    // $('#tab1').click();

    function tofunc(ctr) {

        $('#BtnReceipt-' + ctr + '').click(function () {

            if ($('#BtnReceipt-' + ctr + '').css("background-color") === "rgb(144, 238, 144)") {
                // console.log('true');
                var url = 'ci_expenses/' + $(this).attr('name');
                var link = document.createElement('a');
                link.href = url;
                link.download = $(this).html();
                document.body.appendChild(link);
                link.click();
            }
            else {

                // console.log('false');
                $('#imageReceipt-' + ctr + '').click();
                $('#imageReceipt-' + ctr + '').change(function (e) {
                    if ($(this).val().length >= 1) {

                        $('#BtnReceipt-' + ctr + '').css('background-color', 'lightblue');
                        $('#BtnReceipt-' + ctr + '').html($(this)[0].files[0].name);
                        $('#labelExp-' + ctr + '').removeAttr('disabled');
                        $('#amountExp-' + ctr + '').removeAttr('disabled');
                        $('#type-' + ctr + '').removeAttr('disabled');
                        checkifupdate[ctr] = 'to update'
                    }
                    else {

                        $('#labelExp-' + ctr + '').attr('disabled', 'disabled');
                        $('#amountExp-' + ctr + '').attr('disabled', 'disabled');
                        $('#BtnReceipt-' + ctr + '').css('background-color', 'lightgrey');
                        $('#BtnReceipt-' + ctr + '').html('Attach Receipt');
                    }
                });
            }
        });
    }

    $('#BtnAddExpenses').click(function (e) {

        var form_data = [];
        var check = true;
        var countgreen = [];
        e.preventDefault();
        //checkeronly
        for (var ctr = 0; ctr < expcount; ctr++) {

            if ($('#labelExp-' + ctr + '').val() == '' || $('#amountExp-' + ctr + '').val() == '') {

                check = false;
            }
            if ($('#BtnReceipt-' + ctr + '').css("background-color") === "rgb(144, 238, 144)") {

                // console.log('true');
                countgreen[ctr] = 'not this';
            }
            else {

                // console.log('false');
                countgreen[ctr] = 'this';
            }
        }


        for (var i = 0; i < expcount; i++) {

            if (check == false) {

                // console.log('make sure all field (except attach) should have information');
            }
            else {

                if (countgreen[i] == 'this') {

                    var file;
                    if ($('#imageReceipt-' + i + '').val().length >= 1) {
                        file = $('#imageReceipt-' + i + '').prop('files')[0];
                    }
                    else {

                        file = 'no attachment'
                    }
                    // // console.log('label: ' + $('#labelExp-' + i + '').val() + ' amount: ' + $('#amountExp-' + i + '').val() + ' File: ' + file);
                    var checkid = $('#labelExp-' + i + '').attr('name');
                    var exp_type = '';
                    if ($('#type-' + i + '').is(":checked")) {

                        exp_type = 'Personal'
                    } else {

                        exp_type = 'Fund'
                    }
                    var label = $('#labelExp-' + i + '').val();
                    var amount = $('#amountExp-' + i + '').val();
                    var ci_note = $('#CiExpNote').val();
                    var shell_include;
                    if(document.getElementById('cb_include_shell_exp').checked){
                        shell_include = 'true';
                    }
                    else
                    {
                        shell_include = 'false';
                    }
                    // // console.log('qwe: ' + ci_note);
                    form_data[i] = new FormData();
                    form_data[i].append('endorsement_id', getExpID);
                    form_data[i].append('label', label);
                    form_data[i].append('amount', amount);
                    form_data[i].append('file', file);
                    form_data[i].append('loopid', i);
                    form_data[i].append('CInote', ci_note);
                    form_data[i].append('checkid', checkid);
                    form_data[i].append('type', exp_type);
                    form_data[i].append('shell_include', shell_include);
                    form_data[i].append('checkifupdate', checkifupdate[i]);
                }
            }
        }


//auto Personal codes
        var getpera = 0;
        var getindexes = [];
        var indexes = 0;
        for(op = 0; op<countgreen.length; op++)
        {
            if($('#labelExp-' + op + '').attr('name') == 'none')
            {
                getindexes[indexes] = op;
                getpera = (getpera+parseInt(form_data[op].get('amount')));
                indexes++;
            }
        }
        // // console.log('Real time fund: '+$("#realtimefund").attr('name'));
        // // console.log('To expense: '+ getpera);

        if($("#realtimefund").attr('name') < getpera)
        {

            if (confirm('You have insufficient fund, Do you want to mark this as "Personal Expense?"')) {

                for(ctr = 0; ctr < getindexes.length; ctr++)
                {
                    form_data[getindexes[ctr]].append('type', 'Personal');
                }
                goodtogo();

            } else {
                // Do nothing!
            }
        }
        else
        {
            goodtogo();
        }

        function goodtogo() {

            var index = 0;
            var go = false;
            if (countgreen[index] == 'this') {

                ajaxCall(index);
            }
            else {
                while (countgreen[index] == 'not this') {

                    index++;
                    if (countgreen[index] == 'this') {

                        go = true;
                        if (go) {

                            ajaxCall(index);
                        }
                        return false;
                    }
                }
            }

            function ajaxCall(count) {

                $.ajax
                ({

                    xhr: function () {

                        var xhr = new window.XMLHttpRequest();
                        //Upload progress
                        xhr.upload.addEventListener("progress", function (evt) {

                            if (evt.lengthComputable) {
                                var percentComplete = evt.loaded / evt.total;
                                $('#ulPercentage-' + 0 + '').html('');
                                // $('#ulPercentage').append(percentComplete*100);
                                $('#ulPercentage-' + 0 + '').html((Math.floor(percentComplete * 100)) + ' Uploading..');
                                $('#progressbar-' + 0 + '').show();
                                $('#progressbar-' + 0 + '').progressbar
                                (
                                    {
                                        value: percentComplete * 100
                                    }
                                )
                            }
                        }, false);
                        //Download progress
                        xhr.addEventListener("progress", function (evt) {

                            if (evt.lengthComputable) {
                                var percentComplete = evt.loaded / evt.total;
                                //Do something with download progress
                                // console.log(percentComplete);
                            }
                        }, false);
                        return xhr;
                    },
                    method: 'post',
                    url: 'uploadReceiptExpenses',
                    processData: false,
                    contentType: false,
                    async: true,
                    data: form_data[count],
                    success: function (data) {

                        // console.log(data);

                        if (data[0] === 'success') {

                            $('#progressbar-' + 0 + '').progressbar('option', 'value', 100);
                            $('#ulPercentage-' + 0 + '').html('Upload complete.');
                            $('#BtnReceipt-' + data[1] + '').css('background-color', 'lightgreen');
                        }
                        else if (data[0] === 'success-no-attach') {

                            $('#progressbar-' + 0 + '').progressbar('option', 'value', 100);
                            $('#ulPercentage-' + 0 + '').html('Upload complete.');
                            $('#BtnReceipt-' + data[1] + '').css('background-color', 'lightgrey');
                        }
                        else {

                            $('#progressbar-' + 0 + '').progressbar('option', 'value', 0);
                            $('#ulPercentage-' + 0 + '').html('Something went wrong. :(');
                            $('#BtnReceipt-' + data[1] + '').css('background-color', 'red');
                        }
                    },
                    complete: function (data) {

                        index++;
                        if (countgreen[index] == 'this') {

                            ajaxCall(index);
                            // console.log('ajaxcall triggerded');
                        }
                        while (countgreen[index] == 'not this') {

                            index++;
                            if (countgreen[index] == 'this') {

                                ajaxCall(index);
                                // console.log('ajaxcall triggerded');
                                return false;
                            }
                            // console.log('while');
                        }
                        if (index == expcount) {

                            togo(getExpID);
                        }
                    }
                });

            }
        }

        setTimeout(function (){
            var eeek = '';
            if(document.getElementById('cb_include_shell_exp').checked){

                eeek = 'true';
                alert('Shell card included');
            }
            else
            {
                eeek = 'false';
            }
            $.ajax({
                url : 'ci_logs_for_shell',
                type : 'post',
                data :{
                    'endorse_id' : getExpID,
                    'shell_include' : eeek,
                    'note' : $('#CiExpNote').val()
                },
                success : function (data) {
                    if(data == 'true')
                    {
                        $('#cb_include_shell_exp').prop("checked", true);

                    }
                    else if(data == 'false')
                    {
                        $('#cb_include_shell_exp').prop("checked", false);

                    }
                }

            });

        },1000);
    });
});

function togo(getExpID) {
    expcount = 0;
    // // console.log('asdasdasdasdasd');

    $('#tableExpensesSpan').html(
        '<center>ENDORSEMENT ID: ' + getExpID + '<br>'+
        'ACCOUNT NAME: ' + name_of_ci + '<br>'
        +kung_may_shell+
        '<br>'+
        '                     <table id="exp_table" width="100%">\n' +
        '                        <thead>\n' +
        '                        <tr>\n' +
        '                            <th>Label:</th>\n' +
        '                            <th>Amount:</th>\n' +
        '                            <th>Type:</th>\n' +
        '                            <th>Action:</th>\n' +
        '                        </tr>\n' +
        '                        <tr>\n' +
        '                        </tr>\n' +
        '                        </thead>\n' +
        '                         <tfoot>\n' +
        '                            <tr>\n' +
        '                            <th><button type="button" id="BtnExpAdd" class="btn btn-block btn-default">Add</button></th>\n' +
        '                            <th><button type="button" id="BtnExpMinus" class="btn btn-block btn-default">Remove</button></th>' +
        '                            </tr>\n' +
        '                            </tfoot>' +
        '                    </table></center>\n' +
        '<span style="height: 10px;" id="ulPercentage-0"></span><div style="height: 10px;" id="progressbar-0"></div>');

    $('#BtnExpAdd').click(function () {
        $('#exp_table thead').append('<tr>\n' +
            '<th>' + (expcount + 1) + '.<input id="labelExp-' + expcount + '" name="none" style="width: 80%" type="text"></th>\n' +
            '<th>₱<input id="amountExp-' + expcount + '" style="width: 80%" type="number"></th>\n' +
            '<th><input id="type-' + expcount + '" style="width: 80%;font-size: 15px" type="checkbox" value="Personal">Personal</th>\n' +
            '<th><button style="white-space: normal" type="button" id="BtnReceipt-' + expcount + '" class="btn btn-block btn-default">Attach Receipt</button>' +
            '<span id="span_for_btn_del_row-'+expcount+'"></span>'+
            '<input type="file" name="imageReceipt-' + expcount + '" id="imageReceipt-' + expcount + '" style="display: none;">' +
            '</th>' +
            '</tr>');
        tofunc(expcount);
        expcount++;
    });

    $('#BtnExpMinus').click(function () {
        function todelete(tach) {
            var r = confirm("Are you sure you want to remove the recent row??");
            if (r == true) {
                var labelid = $('#exp_table thead tr th input#labelExp-' + (expcount - 1) + '').attr('name');
                if (labelid == 'none') {
                    $('#exp_table thead tr:last').remove();
                    expcount--;
                }
                else {
                    $.ajax({

                        url: 'ci-expense-delete-last-row',
                        type: 'get',
                        data: {
                            'id': labelid,
                            'endorsement_id': getExpID,
                            'attach': tach
                        },
                        success: function (data) {

                            $('#exp_table thead tr:last').remove();
                            expcount--;

                        },
                        error: function (data) {

                        },
                        complete: function (data) {

                        }

                    });

                }

            }

        }

        var attachmentname = $('#exp_table thead tr th button:last').html();

        if (expcount != 0) {

            if ($('#exp_table thead tr th input#labelExp-' + (expcount - 1) + '').attr('disabled') == 'disabled') {

                if ($('#exp_table thead tr th button:last').css("background-color") === "rgb(144, 238, 144)") {

                    todelete(attachmentname);
                }
                else {

                    todelete('no attach');
                }
            }
            else {

                $('#exp_table thead tr:last').remove();
                expcount--;
            }
        }
    });

    $('#CiExpNote').val('');
    //checker
    $.ajax({

        url: 'ci-check-expenses',
        type: 'get',
        data: {
            'endorsement_id': getExpID
        },
        success: function (data) {

            // console.log(data);
            if (data[0] == 'result') {

                $('#CiExpNote').val(data[3]);
                $('#CiExpNote').html(data[3]);
                // console.log("note:"+(data[3]));
                if(data[4]=='true')
                {
                    $('#cb_include_shell_exp').prop("checked", true);

                }
                else
                {
                    $('#cb_include_shell_exp').prop("checked", false);
                }

                for (var ctr = 0; ctr < data[1].length; ctr++) {

                    $('#BtnExpAdd').click();
                    $('#labelExp-' + ctr + '').val(data[1][ctr].label);
                    $('#labelExp-' + ctr + '').attr('disabled', 'disabled');
                    $('#labelExp-' + ctr + '').attr('name', data[1][ctr].id);
                    $('#amountExp-' + ctr + '').val(data[1][ctr].amount);
                    $('#amountExp-' + ctr + '').attr('disabled', 'disabled');
                    $('#type-' + ctr + '').attr('disabled', 'disabled');

                    $('#span_for_btn_del_row-'+ctr+'').html('<button style="white-space: normal" type="button" id="BtnExpMinus_row" name="'+data[1][ctr].id+'" class="btn BtnExpMinus_row btn-block btn-sm btn-danger">Remove</button>');

                    checkifupdate[ctr] = 'not update';
                    if (data[1][ctr].type == 'Personal') {
                        $('#type-' + ctr + '').prop("checked", true)
                    }
                    if (data[1][ctr].attachment == 'none') {

                        $('#BtnReceipt-' + ctr + '').css('background-color', 'lightgrey');
                        $('#BtnReceipt-' + ctr + '').html('Attach Receipt');
                    } else {

                        $('#BtnReceipt-' + ctr + '').css('background-color', 'lightgreen');
                        $('#BtnReceipt-' + ctr + '').attr('name', data[2] + '/' + data[1][ctr].attachment);
                        $('#BtnReceipt-' + ctr + '').html(data[1][ctr].attachment);
                    }
                }
            }
        },
        error: function () {

        },
        complete: function () {
            $('#exp_table').on('click','#BtnExpMinus_row',function () {
                // confirm!
                if (confirm('Are you sure you want to delete this row?'))
                {
                    // console.log($(this).attr('name'));
                    var exp_id = $(this).attr('name');
                    $.ajax({

                        url: 'ci-expense-delete-row',
                        type: 'get',
                        data: {
                            'id': exp_id
                        },
                        success: function (data) {
                            togo(data);
                        },
                        error: function (data) {

                        },
                        complete: function (data) {

                        }
                    });
                } else {
                    // Do nothing!
                }
            });
        }
    });
}

$('#ci-table-finish').on('click', '#btnAddExpensesFromTable', function () {

    getExpID = $(this).attr('name');
    name_of_ci = $(this).attr('value');
    // // console.log('val:'+$(this).attr('value'));
    $('#span_for_asso').attr('hidden','hidden');
    $('#btn_asso').html('Associate With:(SHOW)');
    $.ajax({

        url : 'ci_check_if_has_shell_include_and_if_asso',
        type : 'get',
        data : {
            'id' : getExpID
        },
        success : function(data) {

            if(data[0] == 'meron')
            {
                kung_may_shell = '<input type="checkbox" id="cb_include_shell_exp" value="Include Shell Expense">Include Shell Expense';
            }
            else if(data[0] == 'wala')
            {
                kung_may_shell = '<input type="checkbox" hidden id="cb_include_shell_exp" value="">Shell Card is not included to this account.';
            }

            if(data[2] == 'false')
            {
                $('#btn_asso').css('display','');
                $('#BtnAddExpenses').css('display','');
                $('#div_for_note_exp').removeAttr('hidden');
                togo(data[1]);
                recall_asso();
            }
            else
            {
                $('#btn_asso').css('display','none');
                $('#BtnAddExpenses').css('display','none');
                $('#div_for_note_exp').attr('hidden','hidden');
                $('#tableExpensesSpan').html('Expenses on this account is associated to : '+data[1]+' (Account name: '+data[3]+')');
            }
        }
    });


    // togo(getExpID);

});

$('#Btn_asso_confirm').click(function () {

    var get_asso_ids = $('#list_of_accounts_asso').val();

    var getlength = 0;
    try {
        getlength = (get_asso_ids.length) > 0;
    }
    catch(e)
    {

    }

    if(getlength > 0)
    {
        // // console.log('pumasok '+get_asso_ids);
        $.ajax({

            url: 'ci_asso_saves_expenses',
            type : 'get',
            data :
                {
                    'ids': get_asso_ids,
                    'main_id' : getExpID
                },
            success : function(data)
            {
                // console.log('saved');

                if(data[1] == 'true')
                {
                    alert('This account/s '+data[0]+'is already associated with another subject');
                }

                recall_asso();

            },
            error : function () {
                // console.log('error');
            }

        });
    }


});

$('#list_of_accounts_asso').on('select2:unselecting', function (e) {

    var id = e.params.args.data.id;

    $.ajax
    ({
        method: 'get',
        url: 'ci_account_remove_select_asso',
        data:
            {
                'asso_id': id,
                'endorse_id': getExpID
            },
        success: function (data) {
            // console.log('success deleting');
        },
        error: function () {
            // console.log('error');
        }
    });

    // // console.log(id4);

});

function recall_asso() {
    $.ajax({

        url: 'ci_get_coob_for_asso',
        get: 'get',
        data:{
            'id' : getExpID
        },
        success: function (data) {
            var getaos = '';
            var active = [];

            for (var ctr = 0; ctr < data[0].length; ctr++) {

                getaos += '<option value="' + data[0][ctr].id + '">' + data[0][ctr].account_name + ' -- '+data[0][ctr].address+'</option><br>';

            }

            $('#list_of_accounts_asso').html(getaos);

            for(var i = 0; i < data[1].length; i++)
            {
                active[i] = data[1][i].id;
            }


            // console.log(data);


            var list = $('#list_of_accounts_asso').select();
            list.val(active).trigger('change')
        },
        error: function () {
            // console.log('error');
        }

    });
}

$('#list_of_accounts_asso').change(function () {
    // console.log($(this).val());
});

$('#btnRefreshTable').click(function ()
{
    table.ajax.reload(null, false);
});

$('#btnRefreshTable2').click(function ()
{
    tableFinishAccount.ajax.reload(null, false);
});

$('#btnRefreshFundRcvTable').click(function ()
{
    tableFundReceive.ajax.reload(null, false);
});

$('#btnRefreshFundAcceptTable').click(function ()
{
    tableFundReceiveAccept.ajax.reload(null, false);
});

$('#tab1').click(function () {

    // get_table_endorse();
    // table.ajax.reload(null, false);
    // tableFinishAccount.ajax.reload(null, false);

    $('#tab1_pending').html('Pending Accounts');
    $('#tab2_finish').html('');
    $('#tab3_download').html('');
});

$('#tab2').click(function () {
    get_table_finish_endorse();
    // table.ajax.reload(null, false);
    // tableFinishAccount.ajax.reload(null, false);
    $('#tab1_pending').html('');
    $('#tab2_finish').html('Finish Accounts');
    $('#tab3_download').html('');
});

$('#tab3').click(function () {
    // table.ajax.reload(null, false);
    // tableFinishAccount.ajax.reload(null, false);
    $('#tab1_pending').html('');
    $('#tab2_finish').html('');
    $('#tab3_download').html('Download Forms');
});

$('#tab1_pending').click(function ()
{

    get_table_pending_fund();

    // tableFundReceive.ajax.reload(null, false);
    // tableFundReceiveAccept.ajax.reload(null, false);
});

$('#tab2_receives').click(function ()
{

    get_table_receive_fund();
    // tableFundReceiveAccept.ajax.reload(null, false);

    $.ajax({

        url     :       'ci_fund_checker_receiving',
        type    :       'get',
        success :       function (data) {
            $('#ci_fund_notif_receive').hide();
        },
        error   :       function () {
            // console.log('error');
        }
    });

    // tableFundReceive.ajax.reload(null, false);
});

$('#tab2_done').click(function()
{
    get_table_liq_done_fund();
    
})


$('#ci-table-finish , #ci-table').on('click', '#btnAttachFile', function (e) {
    $('#successUpdateVisit').html('');
    $('#btnAttachReport').removeAttr('disabled');
    $('#attachFile').removeAttr('disabled');
    $('#ButtonExitModal').attr('data-dismiss', 'modal');
    $('#ProgBar').html('');


    accountID = $(this).attr("name");
    var getname = e.target;
    status = getname.name;
    attachclick = true;

    var successfile = '';
    var errorfile = '';
    var countsuccess = 0;
    var counterror = 0;
    var item_status;
    
    var tableName = $(this).closest('table').attr('id');

    if(tableName == 'ci-table')
    {
        checkAcctPendingFinish = true;
    }
    else if(tableName == 'ci-table-finish')
    {
        checkAcctPendingFinish = false;
    }

    checkUpdateTimeAcct();

    $('#spanhere').html('<center><button id="btnviewuploadedfile" type="button" class="btn btn-info" style="margin-bottom: 5px; margin-top: 5px; margin-left: 10px; margin-right: 10px">View Uploaded File</button></center>');
    $('#btnviewuploadedfile').click(function () {
        refresh();
    });


    $('#fine-uploader-manual-trigger').html('');

    $('#fine-uploader-manual-trigger').fineUploader
    ({
        template: 'qq-template-manual-trigger',
        request:
            {
                endpoint: '/ci-upload-fine/' + accountID,
                customHeaders:
                    {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
            },
        thumbnails:
            {
                placeholders:
                    {
                        waitingPath: '/fine-uploader/placeholders/waiting-generic.png',
                        notAvailablePath: '/fine-uploader/placeholders/not_available-generic.png'
                    }
            },
        retry:
            {
                enableAuto: true,
                maxAutoAttempts: 5
            },
        scaling:
            {
                sendOriginal: false,
                sizes:
                    [
                        {maxSize: 800}
                    ]
            },
        validation:
            {
                itemLimit: 50,
                // acceptFiles: 'image/*',
                allowedExtensions: ['jpe', 'jpg', 'jpeg', 'png', 'bmp', 'pdf', 'xls', 'xlt', 'xlm', 'xlsx', 'xlsm', 'xltx', 'xltm', 'xlsb', 'xla', 'xlam', 'xll', 'xlw', 'mp3']
            },
        callbacks:
            {
                onUpload: function(id, name, errorReason, xhrOrXdr)
                {

                },
                onStatusChange: function (id,status_old,status_new) {

                    item_status = status_new;
                },
                onComplete: function (id) {

                    if(item_status == qq.status.UPLOAD_FAILED)
                    {
                        // console.log('error: '+this.getName(id));
                        errorfile += this.getName(id)+', ';
                        counterror++;
                    }
                    else if(item_status == qq.status.UPLOAD_SUCCESSFUL)
                    {
                        // console.log('success: '+this.getName(id));
                        successfile += this.getName(id)+', ';
                        countsuccess++;
                    }

                },
                onAllComplete: function (id) {

                    // console.log('allcomplete');

                    $.ajax
                    ({
                        type: 'post',
                        url: '/attach-report',
                        data:
                            {
                                'acctID': accountID,
                                'successfile': successfile,
                                'errorfile' : errorfile,
                                'countsuccess' : countsuccess,
                                'counterror' : counterror
                            },
                        success: function (data) {
                            if(data == 'error'){
                                alert('Upload failed. Please try again.');
                            }
                            else if (data == 'already finished')
                            {
                                alert('Upload Failed. Account is already finished action denied');
                            }
                            else
                            {

                                $('#acctReport').modal('hide');
                                
                                check_validation_encode_attach_visit(accountID,'need_to_refresh');
                                if($('#tab1').parent().hasClass('active'))
                                {
                                    table.ajax.reload(null, false);
                                }
                                else if($('#tab2').parent().hasClass('active'))
                                {
                                    tableFinishAccount.ajax.reload(null, false);
                                }
                                //
                                initialise();
                            }

                        },
                        error: function (data) {
                            // console.log("fail");
                        }
                    });

                    // refresh()
                    $('#ProgBar').html('<h4 style="color: green">SUCCESSFULLY UPLOADED</h4>');
                    $('#spanhere').html('<center><button id="btnviewuploadedfile" type="button" class="btn btn-info" style="margin-bottom: 5px; margin-top: 5px; margin-left: 10px; margin-right: 10px">View Uploaded File</button></center>');
                    $('#btnviewuploadedfile').click(function () {
                        refresh();
                    });
                }
            },
        autoUpload: false,
        maxConnections: 1
    });

   $('#trigger-upload').click(function ()
    {
        if(checkAcctPendingFinish == true)
        {
            // if(permissionUpdateTime == true)
            // {
            //     $('#fine-uploader-manual-trigger').fineUploader('uploadStoredFiles');
            // }
            // else
            // {
            if(checkAccountUpdateTimeVisit == true)
            {
                alert('Please update the date and time of visit before uploading.');
            }
            else
            {
                $('#fine-uploader-manual-trigger').fineUploader('uploadStoredFiles');
            }
            // }
        }
        else
        {
            $('#fine-uploader-manual-trigger').fineUploader('uploadStoredFiles');
        }
        
        //   $('#fine-uploader-manual-trigger').fineUploader('uploadStoredFiles');
    });

    $('#endorse_encode_account').html('<tbody>' +
        '              <tr style="background-color: black; color: white;">\n' +
        '                                                            <th colspan="6"><center>LABEL</center></th>\n' +
        '                                                            <th colspan="6"><center>INPUT</center></th>\n' +
        '                                                        </tr>' +
        '</tbody>');

    $('#btn_save_encode_temp').hide();
    $('#btn_final_save_encode_temp').hide();
    $('#btn_download_instead').show();
    // $('#btn_load_auto_save_data').show();


    $.ajax({
        url: 'ci_get_select_encode_template',
        type: 'get',
        data: {
            'account_id' : accountID
        },
        'success' : function (data) {
            console.log(data);
            var ops = '<option value="-">-</option>';
            for(var ctr = 0; ctr<data[0].length; ctr++)
            {
                ops += '<option name="'+data[0][ctr].temp_name+ '||' + //0 name
                    data[0][ctr].temp_name_file+ '||' + //1 temp name
                    data[0][ctr].sheet_name_template+ '||' + //2 sheet name
                    data[0][ctr].temp_col_count+ '||' + //3 col count
                    data[0][ctr].sheet_name_validation+ '||' + //4 sheet name of validation
                    data[0][ctr].validation_col_start+ '||' + //5 col start of validation
                    data[0][ctr].validation_col_end+ '||' + //6 col end of validation
                    '" value="'+data[0][ctr].temp_id+'">'+data[0][ctr].temp_name+'</option>';
            }

            $('#select_encode_template').html(ops);

            if(data[1] == 'auto')
            {
                console.log('automatically select');

                setTimeout(function () {
                    $('#select_encode_template option[value='+data[2][0].temp_id+']').prop('selected', true);
                    $('#select_encode_template').trigger('change');
                },1000);
            }

        },
        'error' : function (e)
        {
            console.log('error: ' + e);
        },
    });

});

var label_and_blank_array = '';

$('#select_encode_template').on('change',function () {

    var val_id = $(this).find(":selected").val();

    if(val_id != '-')
    {
        console.log(val_id);
        var spllited = $(this).find(":selected").attr('name').split('||');
        var temp_name = spllited[0];
        var temp_name_file = spllited[1];
        var sheet_name_template = spllited[2];
        // var temp_col_count = spllited[3];
        // var sheet_name_validation = spllited[4];
        // var validation_col_start = spllited[5];
        // var validation_col_end = spllited[6];
        $.ajax({
            url: 'test-excel',
            type: 'get',
            data: {
                'val_id' : val_id,
                'temp_name' : temp_name,
                'temp_name_file' : temp_name_file,
                'sheet_name_template' : sheet_name_template,
                // 'temp_col_count' : temp_col_count,
                // 'sheet_name_validation' : sheet_name_validation,
                // 'validation_col_start' : validation_col_start,
                // 'validation_col_end' : validation_col_end
            },
            beforeSend: function () {
              $('#overlay_load').show();
                label_and_blank_array = '';
            },
            success: function (data) {
                $('#endorse_encode_account').html('<tbody>' +
                    '              <tr style="background-color: black; color: white;">\n' +
                    '                                                            <th colspan="6"><center>LABEL</center></th>\n' +
                    '                                                            <th colspan="6"><center>INPUT</center></th>\n' +
                    '                                                        </tr>' +
                    '</tbody>');

                console.log(data['TEMPLATE'][0]['ROW'][0]['LABEL']);
                console.log(data);


                var label_id = '';
                var gen_info = true;

                // data = jsonEscape(data);
                label_and_blank_array += ', "data_label" : [';

                for(var temp_ctr = 0; temp_ctr<data['TEMPLATE'].length; temp_ctr++)
                {
                    //if only 1 column on a row
                    if(data['TEMPLATE'][temp_ctr]['ROW'].length == 1)
                    {
                        //check label
                        var splitted_label = data['TEMPLATE'][temp_ctr]['ROW'][0]['LABEL'].split('||');

                        // console.log(splitted_label);
                        if(splitted_label.length > 1)
                        {
                            var splitted_label_val = splitted_label[2].split('=')[1];
                        }
                        else
                        {
                            var splitted_label_val = data['TEMPLATE'][temp_ctr]['ROW'][0]['LABEL'];
                        }

                        if(temp_ctr == 0) //head
                        {
                            label_id = data['TEMPLATE'][temp_ctr]['ROW'][0]['POINT'];

                            template_label =   '<tr>' +
                                '<td colspan="12">\n' +
                                '<table style="word-wrap: break-word; table-layout: fixed; width: 100%;" id="'+label_id+'_tr"></table>'+
                                '</td>' +
                                '</tr>';

                            $('#endorse_encode_account').append(template_label);

                            //label
                            $('#'+label_id+'_tr').append('<tr>' +
                                '<td colspan="12"><center>'+splitted_label_val+'' +
                                '</center>' +
                                '</td>' +
                                '</tr>');

                            //space only
                            template_label = '<tr>\n' +
                                '<td colspan="12"><center> - </center> </td>\n' +
                                '</tr>';

                            $('#endorse_encode_account').append(template_label);

                        }
                        else
                        {
                            if(splitted_label[0] == 'LABEL')//label
                            {

                                gen_info = false;

                                label_id = data['TEMPLATE'][temp_ctr]['ROW'][0]['POINT'];

                                template_label =   '<tr>' +
                                    '<td colspan="12">\n' +
                                    '<table style="word-wrap: break-word; table-layout: fixed; width: 100%;" id="'+label_id+'_tr"></table>'+
                                    '</td>' +
                                    '</tr>';

                                $('#endorse_encode_account').append(template_label);

                                //label
                                $('#'+label_id+'_tr').append('<tr style="background-color: pink;">' +
                                    '<td colspan="12"><center>'+splitted_label_val+'' +
                                    '<button type="button" name="'+label_id+'" val="hide" class="btn_en_hide btn btn-sm pull-right"><i class="fa fa-plus"></i></button></center>' +
                                    '</td>' +
                                    '</tr>');

                            }
                            else if(splitted_label[0] == 'INPUT') //remarks -> textarea
                            {
                                label_id_input = data['TEMPLATE'][temp_ctr]['ROW'][0]['POINT'];


                                $('#'+label_id+'_tr tbody').append('' +
                                    '<tr hidden class="hide_'+label_id+'">' +
                                    '<td colspan="12">' +
                                    '<textarea id="'+label_id_input+'" type="text" class="form-control data_to_save" >'+splitted_label_val+'</textarea>' +
                                    '</td>' +
                                    '</tr>')

                            }
                            else if(splitted_label[0] == 'SELECT') //blank.
                            {
                                label_id_input = data['TEMPLATE'][temp_ctr]['ROW'][0]['POINT'];

                                $('#'+label_id+'_tr tbody').append('' +
                                    '<tr hidden class="hide_'+label_id+'">' +
                                    '<td colspan="12">' +
                                    // '<textarea id="'+label_id_input+'" type="text" class="form-control data_to_save" >'+splitted_label_val+'</textarea>' +
                                    '<select id="'+label_id_input+'" type="text" class="form-control data_to_save">'+get_validation(data['VALIDATION'],label_id_input)+'</select>'+
                                    '</td>' +
                                    '</tr>')
                            }
                            else if(splitted_label[0] == 'BLANK') //blank.
                            {
                                label_id_input = data['TEMPLATE'][temp_ctr]['ROW'][0]['POINT'];


                                $('#'+label_id+'_tr tbody').append('' +
                                    '<tr hidden class="hide_'+label_id+'">' +
                                    '<td colspan="12">' +
                                    '<center>-</center>' +
                                    '</td>' +
                                    '</tr>')
                            }
                            else // others
                            {
                                label_id = data['TEMPLATE'][temp_ctr]['ROW'][0]['POINT'];

                                template_label =   '<tr>' +
                                    '<td colspan="12">\n' +
                                    '<table style="word-wrap: break-word; table-layout: fixed; width: 100%;" id="'+label_id+'_tr"></table>'+
                                    '</td>' +
                                    '</tr>';

                                $('#endorse_encode_account').append(template_label);

                                //other
                                $('#'+label_id+'_tr').append('<tr>' +
                                    '<td colspan="12"><center>' +splitted_label_val+'</center>' +
                                    '</td>' +
                                    '</tr>');
                            }
                        }

                    }
                    else
                    {
                        var array_get_labels = [];
                        var array_get_labels_val = [];
                        var array_get_labels_id = [];
                        var cell_counter = 0;

                        for(row_ctr = 0; row_ctr<data['TEMPLATE'][temp_ctr]['ROW'].length; row_ctr++)
                        {
                            var label_row = data['TEMPLATE'][temp_ctr]['ROW'][row_ctr]['LABEL'].split('||');
                            var point_id_cell = data['TEMPLATE'][temp_ctr]['ROW'][row_ctr]['POINT'];

                            // console.log(label_row);

                            if(label_row[0] == 'LABEL')
                            {
                                array_get_labels_val[cell_counter] = label_row[2].split('=')[1];
                                array_get_labels[cell_counter] = 'LABEL';
                                array_get_labels_id[cell_counter] = point_id_cell;
                                cell_counter++;
                            }
                            else if(label_row[0] == 'INPUT')
                            {
                                array_get_labels_val[cell_counter] = label_row[2].split('=')[1];
                                array_get_labels[cell_counter] = 'INPUT';
                                array_get_labels_id[cell_counter] = point_id_cell;
                                cell_counter++;
                            }
                            else if(label_row[0] == 'SELECT')
                            {
                                array_get_labels_val[cell_counter] = label_row[2].split('=')[1];
                                array_get_labels[cell_counter] = 'SELECT';
                                array_get_labels_id[cell_counter] = point_id_cell;
                                cell_counter++;
                            }
                            else if(label_row[0] == 'BLANK')
                            {

                            }
                        }

                        var l = '';
                        var i = '';
                        var s = '';


                        if(gen_info)
                        {
                            label_id = data['TEMPLATE'][temp_ctr]['ROW'][0]['POINT'];

                            template_label =   '<tr>' +
                                '<td colspan="12">\n' +
                                '<table style="word-wrap: break-word; table-layout: fixed; width: 100%;" id="'+label_id+'_tr"></table>'+
                                '</td>' +
                                '</tr>';

                            $('#endorse_encode_account').append(template_label);

                            //label
                            $('#'+label_id+'_tr').append('<tr style="background-color: pink;">' +
                                '<td colspan="12"><center>GENERAL INFO' +
                                '<button type="button" name="'+label_id+'" val="hide" class="btn_en_hide btn btn-sm pull-right"><i class="fa fa-plus"></i></button></center>' +
                                '</td>' +
                                '</tr>');

                            template_label_with_value = '<tr hidden class="hide_'+label_id+'">';
                            gen_info = false;
                        }
                        else
                        {
                            template_label_with_value = '<tr hidden class="hide_'+label_id+'">';
                        }


                        // console.log(cell_counter,array_get_labels,array_get_labels_val);

                        if(cell_counter == 2)
                        {
                            // colspan 6 - 6

                            for(var c = 0; c < cell_counter; c++)
                            {
                                if(array_get_labels[c] == 'LABEL')
                                {
                                    l = '<td colspan="6" style="background-color: lightblue;">'+array_get_labels_val[c]+':</td>';
                                    template_label_with_value += l;
                                }
                                else if(array_get_labels[c] == 'INPUT')
                                {
                                    i = '<td colspan="6"><textarea id="'+array_get_labels_id[c]+'" type="text" class="form-control data_to_save">'+array_get_labels_val[c]+'</textarea></td>';
                                    template_label_with_value += i;
                                }
                                else if(array_get_labels[c] == 'SELECT')
                                {
                                    s = '<td colspan="6"><select id="'+array_get_labels_id[c]+'" type="text" class="form-control data_to_save">'+get_validation(data['VALIDATION'],array_get_labels_id[c])+'</select></td>';
                                    template_label_with_value += s;
                                }
                            }

                        }
                        else if(cell_counter == 3)
                        {
                            // colspan 4 - 4 - 4
                            for(var c = 0; c <= cell_counter; c++)
                            {
                                if(array_get_labels[c] == 'LABEL')
                                {
                                    l = '<td colspan="4" style="background-color: lightblue;">'+array_get_labels_val[c]+':</td>';
                                    template_label_with_value += l;
                                }
                                else if(array_get_labels[c] == 'INPUT')
                                {
                                    i = '<td colspan="4"><textarea id="'+array_get_labels_id[c]+'" type="text" class="form-control data_to_save">'+array_get_labels_val[c]+'</textarea></td>';
                                    template_label_with_value += i;
                                }
                                else if(array_get_labels[c] == 'SELECT')
                                {
                                    s = '<td colspan="4"><select id="'+array_get_labels_id[c]+'" type="text" class="form-control data_to_save">'+get_validation(data['VALIDATION'],array_get_labels_id[c])+'</select></td>';
                                    template_label_with_value += s;
                                }
                            }
                        }
                        else if(cell_counter == 4)
                        {
                            // colspan 3 - 3 - 3 - 3
                            for(var c = 0; c <= cell_counter; c++)
                            {
                                if(array_get_labels[c] == 'LABEL')
                                {
                                    l = '<td colspan="3" style="background-color: lightblue;">'+array_get_labels_val[c]+':</td>';
                                    template_label_with_value += l;
                                }
                                else if(array_get_labels[c] == 'INPUT')
                                {
                                    i = '<td colspan="3"><textarea id="'+array_get_labels_id[c]+'" type="text" class="form-control data_to_save">'+array_get_labels_val[c]+'</textarea></td>';
                                    template_label_with_value += i;
                                }
                                else if(array_get_labels[c] == 'SELECT')
                                {
                                    s = '<td colspan="3"><select id="'+array_get_labels_id[c]+'" type="text" class="form-control data_to_save">'+get_validation(data['VALIDATION'],array_get_labels_id[c])+'</select></td>';
                                    template_label_with_value += s;
                                }
                            }

                        }
                        else if(cell_counter == 5)
                        {
                            // colspan 3 - 3 - 2 - 2 - 2
                            var cols = '';
                            for(var c = 0; c <= cell_counter; c++)
                            {

                                if(c == 1 || c == 3)
                                {
                                    cols = '3';
                                }
                                else
                                {
                                    cols = '2';
                                }

                                if(array_get_labels[c] == 'LABEL')
                                {
                                    l = '<td colspan="'+cols+'" style="background-color: lightblue;">'+array_get_labels_val[c]+':</td>';
                                    template_label_with_value += l;
                                }
                                else if(array_get_labels[c] == 'INPUT')
                                {
                                    i = '<td colspan="'+cols+'"><textarea id="'+array_get_labels_id[c]+'" type="text" class="form-control data_to_save">'+array_get_labels_val[c]+'</textarea></td>';
                                    template_label_with_value += i;
                                }
                                else if(array_get_labels[c] == 'SELECT')
                                {
                                    s = '<td colspan="'+cols+'"><select id="'+array_get_labels_id[c]+'" type="text" class="form-control data_to_save">'+get_validation(data['VALIDATION'],array_get_labels_id[c])+'</select></td>';
                                    template_label_with_value += s;
                                }
                            }

                        }
                        else if(cell_counter == 6)
                        {
                            // colspan 2 - 2 - 2 - 2 - 2 - 2
                            for(var c = 0; c <= cell_counter; c++)
                            {
                                if(array_get_labels[c] == 'LABEL')
                                {
                                    l = '<td colspan="2" style="background-color: lightblue;">'+array_get_labels_val[c]+':</td>';
                                    template_label_with_value += l;
                                }
                                else if(array_get_labels[c] == 'INPUT')
                                {
                                    i = '<td colspan="2"><textarea id="'+array_get_labels_id[c]+'" type="text" class="form-control data_to_save">'+array_get_labels_val[c]+'</textarea></td>';
                                    template_label_with_value += i;
                                }
                                else if(array_get_labels[c] == 'SELECT')
                                {
                                    s = '<td colspan="2"><select id="'+array_get_labels_id[c]+'" type="text" class="form-control data_to_save">'+get_validation(data['VALIDATION'],array_get_labels_id[c])+'</select></td>';
                                    template_label_with_value += s;
                                }
                            }

                        }


                        $('#'+label_id+'_tr tbody').append(template_label_with_value + '</tr>');
                    }


                    for(var pp = 0; pp < data['TEMPLATE'][temp_ctr]['ROW'].length; pp++)
                    {
                        var splitted_for_label_and_blank = data['TEMPLATE'][temp_ctr]['ROW'][pp]['LABEL'];
                        var split_get_label = splitted_for_label_and_blank.split('||');
                        var get_label = split_get_label[0];
                        if(split_get_label.length > 1)
                        {
                            console.log(split_get_label);
                            var get_val_label = split_get_label[2].split('=')[1];
                        }
                        else
                        {
                            var get_val_label = split_get_label;
                        }
                        var get_val_id = data['TEMPLATE'][temp_ctr]['ROW'][pp]['POINT'];

                        if(get_label == 'LABEL' || get_label == 'BLANK')
                        {
                            var val = get_val_label;
                            if(val != null)
                            {
                                val = val.replace(/"/g, '(dquote)');
                                val = val.replace(/'/g, '(squote)');
                            }
                            label_and_blank_array += '{ "id" : "' + get_val_id + '" , "value" : "' + val + '"},';

                        }
                    }
                }

                label_and_blank_array = label_and_blank_array.slice(0, -1);
                label_and_blank_array += ']}';

                $('#btn_save_encode_temp').show();
                $('#btn_final_save_encode_temp').show();
                $('#btn_download_instead').hide();
            },
            complete:function () {
                $('#overlay_load').hide();


                // $('#btn_load_auto_save_data').hide();

                $('.btn_en_hide').on('click',function () {

                    // console.log('click');

                    var what = $(this).attr('name');
                    var val = $(this).attr('val');

                    if(val == 'show')
                    {
                        $(this).attr('val','hide');
                        $('.hide_'+what+'').toggle('fast');
                        $(this).html('<i class="fa fa-plus"></i>');
                    }
                    else
                    {
                        $(this).attr('val','show');
                        $('.hide_'+what+'').toggle('fast');
                        $(this).html('<i class="fa fa-minus"></i>');
                    }
                });

                data_save_focusout(acctID,$('#select_encode_template').val());

                if(!auto_load_only)
                {
                    $.ajax({
                        url: 'get_save_data_encoded',
                        type: 'get',
                        data : {
                            'account_id' : acctID
                        },
                        success:function (data) {

                            if(data != 'none')
                            {
                                var encoded = JSON.parse(jsonEscape(data));

                                for(var ctr = 0; ctr<encoded['data'].length; ctr++)
                                {
                                    $('#'+encoded['data'][ctr].id+'').val(
                                        (encoded['data'][ctr].value).replace(/<br>/g, "\n").replace("(dquote)", '"').replace("(squote)", "'")
                                    );
                                }
                            }
                        }
                    })
                }
                else
                {
                    var auto_saved_data = JSON.parse(jsonEscape(sessionStorage.getItem(acctID)));

                    console.log(auto_saved_data);

                    for(var ctr = 0; ctr<auto_saved_data['data'].length; ctr++)
                    {
                        $('#'+auto_saved_data['data'][ctr].id+'').val(
                            (auto_saved_data['data'][ctr].value).replace(/<br>/g, "\n").replace("(dquote)", '"').replace("(squote)", "'")
                        );
                    }
                    auto_load_only = false;
                }
            },
            error: function ()
            {
                $('#endorse_encode_account').html('<tbody>' +
                    '              <tr style="background-color: black; color: white;">\n' +
                    '                                                            <th colspan="6"><center>LABEL</center></th>\n' +
                    '                                                            <th colspan="6"><center>INPUT</center></th>\n' +
                    '                                                        </tr>' +
                    '</tbody>');

                $('#btn_save_encode_temp').hide();
                $('#btn_final_save_encode_temp').hide();
                $('#btn_download_instead').show();

                alert('Template is not available. Download the template instead.');
            }
        })
    }
    else
    {
        $('#endorse_encode_account').html('<tbody>' +
            '              <tr style="background-color: black; color: white;">\n' +
            '                                                            <th colspan="6"><center>LABEL</center></th>\n' +
            '                                                            <th colspan="6"><center>INPUT</center></th>\n' +
            '                                                        </tr>' +
            '</tbody>');
        $('#btn_save_encode_temp').hide();
        $('#btn_final_save_encode_temp').hide();
        $('#btn_download_instead').show();
    }



    // console.log(val);
});

function get_validation(select_array, elem_id)
{
    var validation_array = select_array;
    var id = elem_id;
    var options = '<option value="-">-</option>';

    for(ctr = 0; ctr < validation_array.length; ctr++)
    {
        for(row = 0; row < validation_array[ctr]['COL_SELECT'].length; row++)
        {
            var split = validation_array[ctr]['COL_SELECT'][row]['SELECT'].split('||');
            var get_id = split[1].split('=')[1].split(':');
            var select_id = get_id[0]+''+get_id[1];
            if(select_id == id)
            {
                var get_val = split[2].split('=')[1];
                options += '<option value="'+get_val+'">'+get_val+'</option>';
            }
        }
    }

    return options;
}

function data_save_focusout(account_id,temp_id)
{
    $('.data_to_save').on('focusout',function (e) {

        var dancing = '{ "data" : [';

        $('.data_to_save').each(function(){

            var val = $(this).val();

            if(val != null)
            {
                val = val.replace(/"/g, '(dquote)');
                val = val.replace(/'/g, '(squote)');
            }


            dancing += '{ "id" : "' + $(this).attr('id') + '" , "value" : "' + val + '"},'

        });

        var data_encoded = dancing.slice(0, -1);

        data_encoded += ']}';

        // console.log(data_encoded);

        sessionStorage.setItem(account_id, jsonEscape(data_encoded));
        sessionStorage.setItem(account_id+'-temp_id', temp_id);
        //
        // console.log(JSON.parse(sessionStorage.getItem(account_id)));
    });
}

$('.btn_en_hide_upper').on('click',function () {

    // console.log('click');

    var what = $(this).attr('name');
    var val = $(this).attr('val');

    var to_show_hide = '';

    if(what == 'encode')
    {
        to_show_hide = '#box_body_encode';
    }
    else if (what == 'attach')
    {
        to_show_hide = '#box_body_attachement';
    }
    else if (what == 'update_d_t')
    {
        to_show_hide = '#box_body_update_date_time_visit';
    }

    if(val == 'show')
    {
        $(this).attr('val','hide');
        $(''+to_show_hide+'').toggle('fast');
        $(this).html('<i class="fa fa-plus"></i>');
    }
    else
    {
        $(this).attr('val','show');
        $(''+to_show_hide+'').toggle('fast');
        $(this).html('<i class="fa fa-minus"></i>');
    }

});
function jsonEscape(str)  {
    return str.replace(/\n/g, "<br>").replace(/\r/g, "<br>").replace(/\t/g, "<br>");
}
var auto_load_only = false;

$('#acctReport').on('click','.btn_encode_save',function () {

    var type = $(this).attr('name');

    // alert('na click gago');

    if(type == 'load_auto_save')
    {
        var saved_temp_id = sessionStorage.getItem(acctID+'-temp_id');

        if(saved_temp_id == null)
        {
            alert('No data saved in session.');
            console.log(saved_temp_id);

        }
        else
        {
            $('#select_encode_template option[value='+saved_temp_id+']').prop('selected', true);
            $('#select_encode_template').trigger('change');
            auto_load_only = true
        }
    }
    else
    {
        var dancing = '{ "data" : [';

        $('.data_to_save').each(function(){

            var val = $(this).val();

            if(val != null)
            {
                val = val.replace(/"/g, '(dquote)');
                val = val.replace(/'/g, '(squote)');
            }

            dancing += '{ "id" : "' + $(this).attr('id') + '" , "value" : "' + val + '"},'

        });

        var data_encoded = dancing.slice(0, -1);

        data_encoded += ']' + label_and_blank_array;

        console.log(data_encoded);


        var temp_id =$('#select_encode_template').val();

        $.ajax({
            url: 'ci_save_data_encode',
            type: 'post',
            data: {
                'account_id' : acctID,
                'data_encoded' : jsonEscape(data_encoded),
                'temp_id' : temp_id,
                'type' : type
            },
            beforeSend: function () {
                $('#overlay_load').show();
            },
            success: function (data) {

                if(data == 'success saving final')
                {
                    check_validation_encode_attach_visit(acctID,'need_to_refresh');
                    alert('Report Save and Attached Successfully.')
                }
                else if(data == 'success saving')
                {
                    alert('Report Save (only) Success.')
                }
                else if(data == 'download instead')
                {
                    check_validation_encode_attach_visit(acctID,'need_to_refresh');
                    alert('Report should be attach in attachment panel..')
                }
                else if(data == 'no template')
                {
                    alert('No template selected.')
                }

                console.log(data);
                console.log('Success');
            },
            complete: function () {
                $('#overlay_load').hide();
            },
            error: function (e) {
                console.log(e);
                alert('!! ERROR !!: '+e['responseJSON']['message']+'\nPlease screenshot and report this to IT. Thanks')
            }
        });
    }

});

$('#updateVisit').click(function () {
    var dateVisit = $('#DateVisit').val();
    var timeVisit = $('#TimeVisit').val();

    if (dateVisit == '' || timeVisit == '') {
        alert('Please insert valid date and time.');
    }
    else
    {
        $.ajax
        ({
            type: 'post',
            url: '/update-time-visit',
            data:
                {
                    'dateVisit': dateVisit,
                    'timeVisit': timeVisit,
                    'acctID': acctID
                },
            success: function (data) {
                $('#successUpdateVisit').html('');

                check_validation_encode_attach_visit(acctID,'no_refresh');

                var time = setInterval(function () {
                    $('#successUpdateVisit').append('<span class="btn btn-success btn-sm">Date Time Visit Successfully Updated</span>');
                    clearInterval(time);
                }, 1000);

                checkAccountUpdateTimeVisit = false;
            }
        });
    }
});

$('#ci-table').on('click', '#btnOtherInfo', function (e) {
    var acctID = $(this).attr("name");
    $('#otherInfoSpan1').html('');
    $('#otherEmployerSpan1').html('');
    $('#clientRemarks').html('');
    $('#clientNotes').html('');

    $.ajax({
        url: '/dispatcher-get-other-info',
        type: 'GET',
        data:
            {
                'acctID': acctID
            },
        success: function (data) {
            // // console.log(data);

            if (data.length === 0) {
                // console.log('data empty');
            }
            else {
                $('#otherInfoSpan1').html
                (
                    '<tr style="background-color: brown; color: white">' +
                    '   <th style=\'text-align: center;\'>COBORROWER NAME</th>' +
                    '   <th style=\'text-align: center;\'>ADDRESS</th>' +
                    '   <th style=\'text-align: center;\'>CITY/MUNICIPALITY</th>' +
                    '   <th style=\'text-align: center;\'>PROVINCE</th>' +
                    '</tr>'
                );

                for (ctrr = 0; ctrr <= (data[0].length) - 1; ctrr++) {
                    $('#otherInfoSpan1').append
                    (
                        '<tr>' +
                        '   <td style="padding: 3px;">' + data[0][ctrr].coborrower_name + '</td>' +
                        '   <td style="padding: 3px;">' + data[0][ctrr].coborrower_address + '</td>' +
                        '   <td style="padding: 3px;">' + data[0][ctrr].coborrower_municipality + '</td>' +
                        '   <td style="padding: 3px;">' + data[0][ctrr].coborrower_province + '</td>' +
                        '</tr>'
                    );
                }

                $('#otherEmployerSpan1').html
                (
                    '<tr style="background-color: brown; color: white">' +
                    '   <th style=\'text-align: center;\'>EMPLOYER NAME</th>' +
                    '   <th style=\'text-align: center;\'>ADDRESS</th>' +
                    '   <th style=\'text-align: center;\'>CITY/MUNICIPALITY</th>' +
                    '   <th style=\'text-align: center;\'>PROVINCE</th>' +
                    '</tr>'
                );

                for (ctrr = 0; ctrr <= (data[1].length) - 1; ctrr++) {
                    $('#otherEmployerSpan1').append
                    (
                        '<tr>' +
                        '   <td style="padding: 3px;">' + data[1][ctrr].employer_name + '</td>' +
                        '   <td style="padding: 3px;">' + data[3][ctrr].address + '</td>' +
                        '   <td style="padding: 3px; text-transform: uppercase">' + data[3][ctrr].muni_name + '</td>' +
                        '   <td style="padding: 3px;">' + data[3][ctrr].provinces + '</td>' +
                        '</tr>'
                    );
                }

                $('#otherBusinessSpan1').html
                (
                    '<tr style="background-color: brown; color: white">' +
                    '   <th style=\'text-align: center;\'>BUSINESS NAME</th>' +
                    '   <th style=\'text-align: center;\'>ADDRESS</th>' +
                    '   <th style=\'text-align: center;\'>CITY/MUNICIPALITY</th>' +
                    '   <th style=\'text-align: center;\'>PROVINCE</th>' +
                    '</tr>'
                );

                for (ctrr = 0; ctrr <= (data[2].length) - 1; ctrr++) {
                    $('#otherBusinessSpan1').append
                    (
                        '<tr>' +
                        '   <td style="padding: 3px;">' + data[2][ctrr].business_name + '</td>' +
                        '   <td style="padding: 3px;">' + data[3][ctrr].address + '</td>' +
                        '   <td style="padding: 3px; text-transform: uppercase">' + data[3][ctrr].muni_name + '</td>' +
                        '   <td style="padding: 3px;">' + data[3][ctrr].provinces + '</td>' +
                        '</tr>'
                    );
                }

                $('#otherPersonalSpan1').html
                (
                    '<tr style="background-color: brown; color: white">' +
                    '   <th style=\'text-align: center;\'>ACCOUNT NAME</th>' +
                    '   <th style=\'text-align: center;\'>ADDRESS</th>' +
                    '   <th style=\'text-align: center;\'>CITY/MUNICIPALITY</th>' +
                    '   <th style=\'text-align: center;\'>PROVINCE</th>' +
                    '</tr>'
                );

                for (ctrr = 0; ctrr <= (data[3].length) - 1; ctrr++) {
                    $('#otherPersonalSpan1').append
                    (
                        '<tr>' +
                        '   <td style="padding: 3px;">' + data[3][ctrr].account_name + '</td>' +
                        '   <td style="padding: 3px;">' + data[3][ctrr].address + '</td>' +
                        '   <td style="padding: 3px; text-transform: uppercase">' + data[3][ctrr].muni_name + '</td>' +
                        '   <td style="padding: 3px;">' + data[3][ctrr].provinces + '</td>' +
                        '</tr>'
                    );
                }

                if (data[3][0].type_of_request === 'PDRN') {
                    $('#otherPersonalSpan1').show();

                    $('#otherInfoSpan1').show();
                    $('#otherBusinessSpan1').hide();
                    $('#otherEmployerSpan1').hide();
                }
                else if (data[3][0].type_of_request === 'BVR') {
                    $('#otherPersonalSpan1').show();


                    $('#otherInfoSpan').hide();
                    $('#otherBusinessSpan1').show();
                    $('#otherEmployerSpan1').hide();
                }
                else if (data[3][0].type_of_request === 'EVR') {
                    $('#otherPersonalSpan1').show();

                    $('#otherInfoSpan1').hide();
                    $('#otherBusinessSpan1').hide();
                    $('#otherEmployerSpan1').show();
                }

                if (typeof(data[5][0]) === 'undefined') {
                    // console.log('hide');
                    $('#divNotes').hide();
                }
                else {
                    $('#divNotes').show();
                }

                $('#viewRemarks').val('');
                $('#viewNotes').val('');
                $('#viewRemarks').val(data[4][0].client_remarks);
                $('#viewNotes').val(data[5][0].endorsement_note);

            }
        }
    })
});

$('#ci-table-finish').on('click', '#btnOtherInfo', function (e) {
    var acctID = $(this).attr("name");
    $('#otherInfoSpan1').html('');
    $('#otherEmployerSpan1').html('');
    $('#clientRemarks').html('');
    $('#clientNotes').html('');

    $.ajax({
        url: '/dispatcher-get-other-info',
        type: 'GET',
        data:
            {
                'acctID': acctID
            },
        success: function (data) {
            // console.log(data);

            if (data.length === 0) {
                // console.log('data empty');
            }
            else {
                $('#otherInfoSpan1').html
                (
                    '<tr style="background-color: brown; color: white">' +
                    '   <th style=\'text-align: center;\'>COBORROWER NAME</th>' +
                    '   <th style=\'text-align: center;\'>ADDRESS</th>' +
                    '   <th style=\'text-align: center;\'>CITY/MUNICIPALITY</th>' +
                    '   <th style=\'text-align: center;\'>PROVINCE</th>' +
                    '</tr>'
                );

                for (ctrr = 0; ctrr <= (data[0].length) - 1; ctrr++) {
                    $('#otherInfoSpan1').append
                    (
                        '<tr>' +
                        '   <td style="padding: 3px;">' + data[0][ctrr].coborrower_name + '</td>' +
                        '   <td style="padding: 3px;">' + data[0][ctrr].coborrower_address + '</td>' +
                        '   <td style="padding: 3px;">' + data[0][ctrr].coborrower_municipality + '</td>' +
                        '   <td style="padding: 3px;">' + data[0][ctrr].coborrower_province + '</td>' +
                        '</tr>'
                    );
                }

                $('#otherEmployerSpan1').html
                (
                    '<tr style="background-color: brown; color: white">' +
                    '   <th style=\'text-align: center;\'>EMPLOYER NAME</th>' +
                    '   <th style=\'text-align: center;\'>ADDRESS</th>' +
                    '   <th style=\'text-align: center;\'>CITY/MUNICIPALITY</th>' +
                    '   <th style=\'text-align: center;\'>PROVINCE</th>' +
                    '</tr>'
                );

                for (ctrr = 0; ctrr <= (data[1].length) - 1; ctrr++) {
                    $('#otherEmployerSpan1').append
                    (
                        '<tr>' +
                        '   <td style="padding: 3px;">' + data[1][ctrr].employer_name + '</td>' +
                        '   <td style="padding: 3px;">' + data[3][ctrr].address + '</td>' +
                        '   <td style="padding: 3px; text-transform: uppercase">' + data[3][ctrr].muni_name + '</td>' +
                        '   <td style="padding: 3px;">' + data[3][ctrr].provinces + '</td>' +
                        '</tr>'
                    );
                }

                $('#otherBusinessSpan1').html
                (
                    '<tr style="background-color: brown; color: white">' +
                    '   <th style=\'text-align: center;\'>BUSINESS NAME</th>' +
                    '   <th style=\'text-align: center;\'>ADDRESS</th>' +
                    '   <th style=\'text-align: center;\'>CITY/MUNICIPALITY</th>' +
                    '   <th style=\'text-align: center;\'>PROVINCE</th>' +
                    '</tr>'
                );

                for (ctrr = 0; ctrr <= (data[2].length) - 1; ctrr++) {
                    $('#otherBusinessSpan1').append
                    (
                        '<tr>' +
                        '   <td style="padding: 3px;">' + data[2][ctrr].business_name + '</td>' +
                        '   <td style="padding: 3px;">' + data[3][ctrr].address + '</td>' +
                        '   <td style="padding: 3px; text-transform: uppercase">' + data[3][ctrr].muni_name + '</td>' +
                        '   <td style="padding: 3px;">' + data[3][ctrr].provinces + '</td>' +
                        '</tr>'
                    );
                }

                $('#otherPersonalSpan1').html
                (
                    '<tr style="background-color: brown; color: white">' +
                    '   <th style=\'text-align: center;\'>ACCOUNT NAME</th>' +
                    '   <th style=\'text-align: center;\'>ADDRESS</th>' +
                    '   <th style=\'text-align: center;\'>CITY/MUNICIPALITY</th>' +
                    '   <th style=\'text-align: center;\'>PROVINCE</th>' +
                    '</tr>'
                );

                for (ctrr = 0; ctrr <= (data[3].length) - 1; ctrr++) {
                    $('#otherPersonalSpan1').append
                    (
                        '<tr>' +
                        '   <td style="padding: 3px;">' + data[3][ctrr].account_name + '</td>' +
                        '   <td style="padding: 3px;">' + data[3][ctrr].address + '</td>' +
                        '   <td style="padding: 3px; text-transform: uppercase">' + data[3][ctrr].muni_name + '</td>' +
                        '   <td style="padding: 3px;">' + data[3][ctrr].provinces + '</td>' +
                        '</tr>'
                    );
                }

                if (data[3][0].type_of_request === 'PDRN') {
                    $('#otherPersonalSpan1').show();

                    $('#otherInfoSpan1').show();
                    $('#otherBusinessSpan1').hide();
                    $('#otherEmployerSpan1').hide();
                }
                else if (data[3][0].type_of_request === 'BVR') {
                    $('#otherPersonalSpan1').show();


                    $('#otherInfoSpan').hide();
                    $('#otherBusinessSpan1').show();
                    $('#otherEmployerSpan1').hide();
                }
                else if (data[3][0].type_of_request === 'EVR') {
                    $('#otherPersonalSpan1').show();

                    $('#otherInfoSpan1').hide();
                    $('#otherBusinessSpan1').hide();
                    $('#otherEmployerSpan1').show();
                }

                if (typeof(data[5][0]) === 'undefined') {
                    // console.log('hide');
                    $('#divNotes').hide();
                }
                else {
                    $('#divNotes').show();
                }

                $('#viewRemarks').val('');
                $('#viewNotes').val('');
                $('#viewRemarks').val(data[4][0].client_remarks);
                $('#viewNotes').val(data[5][0].endorsement_note);

            }
        }
    })
});

$('#ci-table').on('click', '#btnViewAttachReport', function () {
    $('#txtAreaNote').html('');
    $('#btnUpdateReport').hide();
    $('#btnSaveReport').show();
    accountID = '';
    accountID = $(this).attr("name");
    $('#txtAreaNote').append
    (
        '                                    <div class="form-group">\n' +
        '                                        <label>Add Note</label>\n' +
        '                                        <textarea class="form-control" rows="20" placeholder="Enter ..." id="txtReport"></textarea>\n' +
        '                                    </div>'
    )
});

$('#ci-table-finish').on('click', '#btnViewAttachReport', function () {
    $('#txtAreaNote').html('');
    $('#btnUpdateReport').hide();
    $('#btnSaveReport').show();
    accountID = '';
    accountID = $(this).attr("name");
    $('#txtAreaNote').append
    (
        '                                    <div class="form-group">\n' +
        '                                        <label>Add Note</label>\n' +
        '                                        <textarea class="form-control" rows="20" placeholder="Enter ..." id="txtReport"></textarea>\n' +
        '                                    </div>'
    )
});

$('#btnSaveReport').click(function () {
    $('#btnSaveReport').attr('disabled', true);
    var txtReport = $('#txtReport').val();

    $.ajax
    ({
        method: 'post',
        url: 'ci-save-report',
        data:
            {
                'acctID': accountID,
                'txtReport': txtReport
            },
        success: function (data) {
            $('#btnSaveReport').attr('disabled', false);
            $('#modal-ci-report').modal('hide');
            if (data === 'success') {
                table.ajax.reload(null, false);
                tableFinishAccount.ajax.reload(null, false);
                alert('Successfully Add Note');
            }
        }
    });
});

$('#ci-table').on('click', '#btnViewUpdateReport', function () {
    $('#txtAreaNote').html('');
    $('#btnSaveReport').hide();
    $('#btnUpdateReport').show();
    accountID = '';
    accountID = $(this).attr("name");

    $.ajax
    ({
        method: 'get',
        url: 'ci-get-report',
        data:
            {
                'acctID': accountID
            },
        success: function (data) {
            $('#txtNote').html('');
            // console.log(data);
            $('#txtAreaNote').append
            (
                '                                    <div class="form-group">\n' +
                '                                        <label>Update Note</label>\n' +
                '                                        <textarea class="form-control" rows="20" placeholder="Enter ..." id="txtReport">' + data[0].endorsement_report + '</textarea>\n' +
                '                                    </div>'
            )
        }
    });
});


$('#ci-table-finish').on('click', '#btnViewUpdateReport', function () {
    $('#txtAreaNote').html('');
    $('#btnSaveReport').hide();
    $('#btnUpdateReport').show();
    accountID = '';
    accountID = $(this).attr("name");

    $.ajax
    ({
        method: 'get',
        url: 'ci-get-report',
        data:
            {
                'acctID': accountID
            },
        success: function (data) {
            $('#txtNote').html('');
            // console.log(data);
            $('#txtAreaNote').append
            (
                '                                    <div class="form-group">\n' +
                '                                        <label>Update Note</label>\n' +
                '                                        <textarea class="form-control" rows="20" placeholder="Enter ..." id="txtReport">' + data[0].endorsement_report + '</textarea>\n' +
                '                                    </div>'
            )
        }
    });
});

$('#btnUpdateReport').click(function ()
{
    $('#btnUpdateReport').attr('disabled', true);
    var txtReport = $('#txtReport').val();

    $.ajax
    ({
        method: 'post',
        url: 'ci-update-report',
        data:
            {
                'acctID': accountID,
                'txtReport': txtReport
            },
        success: function (data) {
            $('#btnUpdateReport').attr('disabled', false);
            $('#modal-ci-report').modal('hide');
            if (data === 'success') {
                table.ajax.reload(null, false);
                tableFinishAccount.ajax.reload(null, false);
                alert('Report Successfully Updated!');
            }
        }
    });
});


var toclick = false;

$('#SideBarClick').click(function () {

    // // console.log($('#Fundy').attr('name'));

    if (toclick == false) {
        // $('#idnotifci').html('');
        $('#idnotifci').hide();
        toclick = true;
    } else {
        $('#idnotifci').show();


        toclick = false;
    }
});

$('#table-fund-receive-accept').on('click','#btn_trigger_modal', function ()
{
    var table_id = $(this).attr('name');
    table_accept_fund(table_id);
    // console.log(table_id);
});

$('#table-fund-receive').on('click','#btn_trigger_modal', function ()
{
    var table_id = $(this).attr('name');
    table_cover_fund(table_id);
    // console.log(table_id);
});

function table_accept_fund(table_id)
{
    $.ajax
    ({
        url: 'ci_get_table_fund_accept_accounts',
        type: 'get',
        data: {
            'id': table_id
        },
        success: function (data) {
            console.log(data);

            var getdata = '';
            var fund_requested = data[1];
            table_fund_id = data[2];
            var declareCount = 0;
            var amountCheck;
            var editCheck;
            dataLengthforFiles = data[0].length;
            var test = '';
            var checkCounterM;
            var t;
            var remVal = '';
            var fundRem = '';
            var beforetest = '';
            var newtest = '';

            for(t = 0; t < dataLengthforFiles; t++)
            {
                var countAcct = t + 1;


                if(data[5] != '')
                {
                    if(data[5][t].receipt_attachment != "")
                    {
                        // checkFiles = 'File Already Uploaded.';
                        var countFile = data[5][t].receipt_attachment;
                        var splitFiles = countFile.split('|');
                        var m;

                        for (m = 0; m < splitFiles.length - 1; m++)
                        {
                            beforetest += '<div id = "deleteNowAttach-'+ t + '-' +m+'"><div class = "row"><span style="padding-left: 20px; padding-right: 20px; padding-bottom: 20px;">' +
                                '<button type = "button" class = "btn btn-xs btn-primary" disabled>' +
                                '<i class = "glyphicon glyphicon-paperclip"></i></button>' +
                                '<span style = "color : green;" >File Already Uploaded.</span></span></div><br></div>';
                        }

                        newtest =  '<div class = "row">' +
                            '<button type = "button" class = "attachFileCiFund btn btn-xs btn-primary" id = "attachFileFundLiq-'+ t +'" name = "'+ t+'" href= "0">' +
                            '<i class = "glyphicon glyphicon-paperclip"></i></button>' +
                            '<input type="file" id = "attachNowFile-'+ t + '-0" name = "insertImgArrayFund-'+  data[2] + '-' + t +'[]"  title = "'+data[0][t].id+'" style = "display: none">' +
                            '<span id = "statusFileFundLiq-'+ t +'-0" style = "color : green;" >Please Upload Attachment.</span></div><br>';

                        test = beforetest + newtest;

                        checkCounterM = 1;

                    }
                    else if(data[5][t].receipt_attachment == "")
                    {
                        test = '<div class = "row" >' +
                            '<button type = "button" class = "attachFileCiFund btn btn-xs btn-primary" id = "attachFileFundLiq-'+ t +'" name = "'+ t+'" href= "0">' +
                            '<i class = "glyphicon glyphicon-paperclip"></i></button>' +
                            '<input type="file" id = "attachNowFile-'+ t + '-0" name = "insertImgArrayFund-'+  data[2] + '-' + t +'[]"  title = "'+data[0][t].id+'" style = "display: none">' +
                            '<span id = "statusFileFundLiq-'+ t +'-0" style = "color : green;">Please Upload Attachment</span></div><br>';

                        checkCounterM = 1;
                    }
                }
                else
                {
                    test ='<div class = "row" >' +
                        '<button type = "button" class = "attachFileCiFund btn btn-xs btn-primary" id = "attachFileFundLiq-'+ t +'" name = "'+ t+'" href= "0">' +
                        '<i class = "glyphicon glyphicon-paperclip"></i></button>' +
                        '<input type="file" id = "attachNowFile-'+ t + '-0" name = "insertImgArrayFund-'+  data[2] + '-' + t +'[]"  title = "'+data[0][t].id+'" style = "display: none">' +
                        '<span id = "statusFileFundLiq-'+ t +'-0" style = "color : green;" >Please Upload Attachment</span></div><br>';

                    checkCounterM = 1;
                }


                if (data[3] != "")
                {
                    amountCheck = '<input type="number" id = "atmInputVal-' + t + '"  class = "amtSpentCi-' + data[2] + '" href = "' + data[0][t].id + '" value = "' + data[3][t] + '" disabled>';
                    editCheck = '<button type = "button" class = "editLiqAmount btn btn-xs btn-warning" id = "amtEditBtn-' + t + '" name = "' + t + '"><i class = "fa fa-fw fa-pencil">';
                    $('#liquidateNowFund').html('Update Liquidated Amount');
                    statusLiq = 'done';
                }
                else
                {
                    amountCheck = '<input type="number" id = "atmInputVal-' + t + '"  class = "amtSpentCi-' + data[2] + '" href = "' + data[0][t].id + '" value = "">';
                    editCheck = '';
                    $('#liquidateNowFund').html('Liquidate Amount');
                    $('#liquidateNowFund').attr('disabled', false);
                    statusLiq = 'pending';
                }
                if(data[7] != '')
                {
                    if(data[7][t].indiv_remarks != '')
                    {
                        fundRem = '<div style = "width : 100%">' +
                            '<div style = "float : left; width : 80%">' +
                            '<textarea class = "fundIndivRemarks-'+ data[2] +' form-control" rows = "2" href= "' + data[0][t].id + '" id = "remIndiv-'+t+'" disabled style = "width : 100%">'+data[7][t].indiv_remarks+'</textarea>' +
                            '</div>' +
                            '<div style = "float : right" >' +
                            '<div id = "showIndivOk-'+t+'" hidden>' +
                            '<button type = "button" class = "genOkIndiv btn btn-xs btn-success" id = "btnOkIndivRem-'+t+'" name = "'+t+'">' +
                            '<i class = "fa fa-fw fa-check"></i></button>' +
                            '</div>' +
                            '<div>' +
                            '<button type = "button" class = "genEditIndivRem btn btn-xs btn-warning" id = "btnEditIndiveRem-'+t+'" name = "'+t+'" >' +
                            '<i class = "fa fa-fw fa-pencil"></i></button>' +
                            '</div>' +
                            '</div>' +
                            '</div>';
                    }
                    else
                    {
                        fundRem = '<textarea class = "fundIndivRemarks-' + data[2] + ' form-control" rows = "2" href= "' + data[0][t].id + '" id = "remIndiv-'+t+'" ></textarea>';
                    }
                }
                else
                {
                    fundRem = '<textarea class = "fundIndivRemarks-' + data[2] + ' form-control" rows = "2" href= "' + data[0][t].id + '" id = "remIndiv-'+t+'"></textarea>'
                }

                getdata += '<h5 style = "padding-bottom : 10px;">Account no. ' + countAcct + '</h5><div class = "row" style = "padding-bottom : 30px;">' +
                    '<div class = "col-md-12"><table class = "table_liquidation tableendorse display table-hover table-condensed"  width="100%">' +
                    '<tr style="white-space: normal ; text-align: center">' +
                    '<th style = "font-weight: bold; background-color: lightblue; text-align: center">ID</th>' +
                    '<th style = "text-align: center">' + data[0][t].id + '</th>' +
                    '<tr>' +
                    '<tr><th style = "font-weight: bold; background-color: lightblue; text-align: center">ACCOUNT NAME/S</th><th style = "text-align: center">' + data[0][t].name + '</th></tr>' +
                    '<tr><th style = "font-weight: bold; background-color: lightblue; text-align: center">TYPE OF REQUEST</th><th style = "text-align: center">' + data[0][t].tor + '</th></tr>' +
                    '<tr><th style = "font-weight: bold; background-color: lightblue; text-align: center">AMOUNT SPENT</th>' +
                    '<th style = "text-align: center ;">' + amountCheck + '<span id = "checkEditSpan-' + t + '" hidden><button type = "button" class = "checkNewAmt btn btn-xs btn-success" id = "checkEdit-' + t + '" name = "' + t + '"><i class = "glyphicon glyphicon-ok"></i></button></span>' + editCheck + '</th></tr>' +
                    '<tr><th style = "font-weight: bold; background-color: lightblue; text-align: center">UPLOAD ATTACHMENT</th>' +
                    '<th style = "text-align: center">' +
                    '<span id = "attachAppendstorage-' + t + '">'+test+'</span>' +
                    '<span style = "padding-left: 15px;"><button type = "button" class = "additionalAttachFund btn btn-xs btn-info" name = "' + t + '" href = "' + data[0][t].id + '" id = "'+checkCounterM+'"><i class = "glyphicon glyphicon-plus"></i></button></span></div></th>' +
                    '</tr>' +
                    '<tr><th style = "font-weight: bold; background-color: lightblue; text-align: center">REMARKS(no receipt)</th>' +
                    '<th>'+fundRem+'</th>' +
                    '</tr>' +
                    '</table></div></div>';
                beforetest = '';
                newtest = '';
            }


            var liqRemElem =
                '  <h5>General Liquidation Remarks : <span id = "insertEditRemBtn-'+ table_fund_id +'"></span> </h5>\n' +
                ' <div style = "padding-bottom : 20px;"><textarea class = "LiquidRemarksCi form-control" id = "liquidRem-' + table_fund_id + '"></textarea><br>' +
                '<span id="review_status"></span>';

            $('#liqRemSpan').html(liqRemElem);

            if(data[6] != '')
            {
                remVal = data[6];
                $('#liquidRem-' + table_fund_id + '').attr('disabled', true);
                $('#insertEditRemBtn-'+ table_fund_id +'').html('<span id = "checkEditRem-'+ table_fund_id +'" hidden><button type = "button" class = "checkNewRem btn btn-xs btn-success" id = "checkRem-'+ table_fund_id +'" name = "'+ table_fund_id +'">' +
                    '<i class = "glyphicon glyphicon-ok"></i></button></span>' +
                    '<button type = "button" class = "editLiqRem btn btn-xs btn-warning" id = "valRemLiq-'+ table_fund_id +'" name = "'+ table_fund_id +'">' +
                    '<i class = "fa fa-fw fa-pencil"></i></button></div>');
            }
            else
            {
                remVal = '';
                $('#liquidRem-' + table_fund_id + '').attr('disabled', false);
            }
            $('#liquidRem-' + table_fund_id + '').val(remVal);

            $('#liquidateNowFund').attr('name', data[2]);
            $('#liquidateNowFund').attr('title', fund_requested);


            if(data[4] != '')
            {
                declareCount = data[4];
                $('#declaredAmtShow').val(declareCount);
                // $('#liquidateNowFund').attr('disabled', true);
                $('#nameDecorLiq').html('Liquidated Amount: ')
            }
            else
            {
                declareCount = 0;
                $('#declaredAmtShow').val('');
                $('#nameDecorLiq').html('Declared Amount: ')
            }

            $('#noAccsFund').html(t);
            $('#FundAmtReq').html('Php '+ fund_requested);

            $('#ci_fund_covered').html
            (
                '<div class = "row">' +
                '<div class = "col-md-12">' +
                getdata +
                '</div> ' +
                '</div>'
            );

            $('.table_liquidation').on('click', '.editLiqAmount', function()
            {
                $(this).attr('disabled', true);
                var numId = $(this).attr('name');

                $('#atmInputVal-'+ numId +'').attr('disabled', false);

                $('#checkEditSpan-'+ numId +'').show();

            });

            $('.table_liquidation').on('click', '.checkNewAmt', function()
            {
                var numId = $(this).attr('name');

                $('#checkEditSpan-'+ numId +'').hide();
                $('#atmInputVal-'+ numId +'').attr('disabled', true);
                $('#amtEditBtn-'+ numId +'').attr('disabled', false);
                $('#liquidateNowFund').attr('disabled', false);
            });

            $('.table_liquidation').on('click', '.attachFileCiFund', function()
            {
                var numId = $(this).attr('name');
                var indexFile = $(this).attr('href')
                // console.log(numId + ',' + indexFile);

                $('#attachNowFile-'+ numId + '-' +indexFile+'').click();

                $('#attachNowFile-'+ numId + '-' +indexFile+'').change(function(e)
                {
                    if( e.target.files[0] != null)
                    {
                        // var fileName = e.target.files[0].name;
                        $('#statusFileFundLiq-'+ numId +'-' +indexFile+'').html(' File Ready for Upload ');
                        $('#liquidateNowFund').attr('disabled', false);
                    }
                    else
                    {
                        $('#statusFileFundLiq-'+ numId +'-' +indexFile+'').html(' Select Attachment ');
                    }
                });
            });

            $('#valRemLiq-'+ table_fund_id +'').click(function()
            {
                $('#checkEditRem-'+ table_fund_id +'').show();
                $('#liquidRem-' + table_fund_id + '').attr('disabled', false);
                $(this).attr('disabled', true);
            });

            $('#checkRem-'+ table_fund_id +'').click(function()
            {
                $('#checkEditRem-'+ table_fund_id +'').hide();
                $('#valRemLiq-'+ table_fund_id +'').attr('disabled', false);
                $('#liquidRem-' + table_fund_id + '').attr('disabled', true);
                $('#liquidateNowFund').attr('disabled', false);
            });

            $('.table_liquidation').on('click', '.additionalAttachFund', function()
            {
                var id = $(this).attr('name');
                var uniq = $(this).attr('href');
                var attachCounter = $(this).attr('id');
                var counter = parseInt(attachCounter);

                $('#attachAppendstorage-'+id+'').append
                (
                    '<div id = "deleteNowAttach-'+ id + '-' +counter+'"><div class = "row">' +
                    '<button type = "button" class = "attachFileCiFund btn btn-xs btn-primary" id = "attachFileFundLiq-'+ id +'" name = "'+ id +'" href= "'+attachCounter+'">' +
                    '<i class = "glyphicon glyphicon-paperclip"></i></button>' +
                    '<input type="file" id = "attachNowFile-'+ id + '-' +counter+'" name = "insertImgArrayFund-'+  data[2] + '-' + id +'[]"  title = "'+uniq+'" style = "display: none">' +
                    '<span id = "statusFileFundLiq-'+ id +'-' +attachCounter+'" style = "color : green;" >Please Upload Attachment </span>' +
                    '<button type = "button" class = "deleteFileCiFund btn btn-xs btn-danger" id = "deleteFileFundLiq-'+ id + '-' +counter+'" name = "'+ id +'" href= "'+attachCounter+'">' +
                    '<i class = "glyphicon glyphicon-minus"></i></button></div><br></div>'
                );
                counter++;
                $(this).attr('id', counter);
            });

            $('.table_liquidation').on('click', '.deleteFileCiFund', function()
            {
                var counter = $(this).attr('href');
                var id = $(this).attr('name');

                $('#deleteNowAttach-'+ id + '-' +counter+'').remove();
            });

            if(data[8] == 0)
            {
                $('#review_status').html('<b>Status: </b> Not yet reviewed');
            }
            else if(data[8] == 1)
            {
                $('#review_status').html('<b>Status: </b> Reviewed<br><b>Changes: </b>' + data[9] + '<br><b>Audit Remarks: </b>' + data[10] + '<br>' + '<b>Finance Remarks: </b>' + data[11]);
            }



            $('.table_liquidation').on('click', '.genEditIndivRem', function()
            {
                $('#showIndivOk-'+($(this).attr('name'))+'').show();
                $(this).attr('disabled', true);
                $('#remIndiv-'+($(this).attr('name'))+'').attr('disabled', false);
            });

            $('.table_liquidation').on('click', '.genOkIndiv', function()
            {
                $('#showIndivOk-'+($(this).attr('name'))+'').hide();
                $('#btnEditIndiveRem-'+($(this).attr('name'))+'').attr('disabled', false)
                $('#remIndiv-'+($(this).attr('name'))+'').attr('disabled', true);
            });

        },
        error : function () {
            // console.log('error');
        }
    });
}

$('#liquidateNowFund').click(function()
{
    var btn = $(this);
    // btn.attr('disabled', true);
    declareData = 0;
    var countAmt = 0;
    var declareArray = [];
    var countInside = 0;
    var countFile = 0;
    var remarksFundArray = [];
    var formData = new FormData();
    var fund_id_get = $(this).attr('name');
    var limitFund = $(this).attr('title');
    var countRem = 0;
    var countTabi = 0;

    var liqRem = $('#liquidRem-' + fund_id_get + '').val();

    $('.amtSpentCi-'+  fund_id_get +' ').each(function()
    {
        declareData += parseInt($(this).val());
        declareArray[countAmt] = [];

        declareArray[countAmt][countInside] = $(this).attr('href');
        declareArray[countAmt][countInside + 1] = $(this).val();

        countInside = 0;
        countAmt++;
    });

    $('.fundIndivRemarks-'+ fund_id_get+'').each(function()
    {
        remarksFundArray[countRem] = [];

        remarksFundArray[countRem][countTabi] = $(this).val();
        remarksFundArray[countRem][countTabi + 1] = $(this).attr('href');

        countInside = 0;
        countRem++;
    });

    if(Number.isNaN(declareData))
    {
        alert('Please indicate amount per account!');
    }
    else
    {
        if(declareData > limitFund)
        {
            alert('Amount exceeded the fund requested amount!');
        }
        else
        {
            if(confirm('Are sure the liquidate an amount of ₱ ' + declareData + '?'))
            {
                $('#declaredAmtShow').val('');
                imageContainerFund = [];
                imgContainerId = [];
                imgCountArray = [];
                var i;
                var testcount = 0;

                for(var u = 0; u < dataLengthforFiles; u++)
                {
                    var file_name = document.getElementsByName('insertImgArrayFund-'+  fund_id_get + '-' + u +'[]');

                    imageContainerFund[u] = [];
                    imgCountArray[u] = [];
                    testcount = 0;

                    for(i = 0; i < file_name.length; i++)
                    {
                        var fileUpload = file_name[i];

                        if (fileUpload.files.length != 0)
                        {
                            imageContainerFund[u][i] = fileUpload.files[0];
                            countFile++;

                            testcount++;

                            imgContainerId[u] = fileUpload.title;
                        }
                        else
                        {
                            imgContainerId[u] = null;
                        }
                        imgCountArray[u] = testcount;

                    }
                    imageContainerFund.forEach(function(newArray, u)
                    {
                        newArray.forEach(function(image, i)
                        {
                            formData.append('image_' + u + '-' + i , image);
                        });
                    });


                }
                var json_declareArray = JSON.stringify(declareArray);
                var json_imgContainerId = JSON.stringify(imgContainerId);
                var json_arrayCount = JSON.stringify(imgCountArray);
                var json_remCount = JSON.stringify(remarksFundArray);

                formData.append('declareArray' , json_declareArray);
                formData.append('liqamount', declareData);
                formData.append('id', table_fund_id);
                formData.append('status', statusLiq);
                formData.append('countImage', countFile);
                formData.append('idFiles', json_imgContainerId);
                formData.append('liqRem', liqRem);
                formData.append('countArrayofFiles', json_arrayCount);
                formData.append('fundRemarksIndiv', json_remCount);

                // // console.log(imageContainerFund);
                // // console.log(imgCountArray);
                // // console.log(imgContainerId);
                // // console.log(formData.get('image_0-1'));

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
                                $('#ulPercentage_fund').html('');
                                // $('#ulPercentage').append(percentComplete*100);
                                $('#ulPercentage_fund').append(Math.floor(percentComplete*100));
                                $('#progressbar_fund').show();
                                $('#progressbar_fund').progressbar
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
                                // console.log(percentComplete);
                            }
                        }, false);
                        return xhr;

                    },
                    type : 'post',
                    contentType: false,
                    processData: false,
                    async : true,
                    url : 'ci-liquidate-fund-amount',
                    data : formData,
                    success : function(data)
                    {
                        // console.log(data);
                        btn.attr('disabled', false);
                        alert('Successfully Liquidated!');
                        $('#modal_ci_endorsements_fund').modal('hide');
                        tableFundReceiveAccept.ajax.reload(null, false);
                        imageContainerFund = [];
                        countFile = 0;
                        $('#ci_fund_covered').html('');
                        $('#ulPercentage_fund').html('--');
                        $('#progressbar_fund').progressbar('option', 'value', 0);
                        $('#progressbar_fund').hide();
                        notifs();

                    }
                });
            }
            else
            {
                $('#declaredAmtShow').val('');
            }
        }
    }

});


function table_cover_fund(table_id) {

    $.ajax({

        url : 'ci_get_table_fund_pending_accounts',
        type : 'get',
        data : {
            'id' : table_id
        },
        success : function (data)
        {
            // console.log(data);
            var getdata = '';
            for(var t = 0; t < data.length; t++)
            {
                getdata += '<tr style="white-space: normal ; text-align: center"><th style = "text-align: center">'+data[t].id+'</th>' +
                    '<th style = "text-align: center">'+data[t].name+'</th>' +
                    '<th style = "text-align: center">'+data[t].tor+'</th><tr>';
            }
            $('#noAccsFund2').html(t);

            $('#ci_fund_covered_2').html(
                '                    <table class = "tableendorse display table-hover table-condensed"  width="100%" style = "">\n' +
                '                        <thead>' +
                '                        <tr>' +
                '                            <th style = "font-weight: bold; background-color: lightblue; text-align: center">ID</th>' +
                '                            <th style = "font-weight: bold; background-color: lightblue; text-align: center">ACCOUNT NAME/S</th>' +
                '                            <th style = "font-weight: bold; background-color: lightblue; text-align: center">TYPE OF REQUEST</th>' +
                '                        </tr>' +
                getdata +
                '                        </thead>' +
                '                    </table>' +
                '');


        },
        error : function () {
            // console.log('error');
        }

    });

}



function get_messages_info() {

    $.ajax({

        url     :   'get_message_info',
        type    :   'get',
        success : function (data) {

            // console.log(':'+data);

            var mes = '';
            var count = 0;
            var count_all = 0;
            for(var ctr = 0; ctr<data[0].length; ctr++)
            {
                if(data[0][ctr].from_view == 'false')
                {
                    count++;
                }
                count_all++;
                mes += '                              <li>' +
                    '                                    <a href="#" style="white-space: normal">' +
                    '                                        <div class="pull-left">' +
                    '                                            <img src="dist/img/ccsi-icon.ico" class="img-circle">' +
                    '                                        </div>' +
                    '                                        <h4>' +
                    '                                            Dispatch Team' +
                    '                                           <small><i class="fa fa-clock-o"></i>'+data[0][ctr].date_time+'</small>'+
                    '                                        </h4>' +
                    '                                        <p>'+data[0][ctr].message+'</p>' +
                    '                                    </a>' +
                    '                                </li>';
            }

            for(var ctr = 0; ctr<data[1].length; ctr++)
            {
                if(data[1][ctr].to_view == 'false')
                {
                    count++;
                }
                count_all++;
                mes += '                              <li>' +
                    '                                    <a href="#" style="white-space: normal">' +
                    '                                        <div class="pull-left">' +
                    '                                            <img src="dist/img/ccsi-icon.ico" class="img-circle">' +
                    '                                        </div>' +
                    '                                        <h4>' +
                    '                                            Dispatch Team' +
                    '                                           <small><i class="fa fa-clock-o"></i>'+data[1][ctr].date_time+'</small>'+
                    '                                        </h4>' +
                    '                                        <p>'+data[1][ctr].message+'</p>' +
                    '                                    </a>' +
                    '                                </li>';
            }

            $('#notif_message_count').html(count);
            $('#message_count_all').html('You have '+count_all+' messages.');
            $('#message_info_notif').html(mes);

        },
        error : function () {

        }

    });
}

$('#message_click').click(function () {
    // // console.log(($('#notif_message_count').html()));

    if($('#notif_message_count').html() != 0)
    {
        $.ajax({

            url: 'del_message_view_count',
            type: 'get',
            success : function () {
                $('#notif_message_count').html(0);
            }
        });

    }

});

$('#expense_select_receipt').change(function () {

    if($(this).val() == 'With')
    {
        // // console.log('with');
        $('#row_attachment_receipt_span').html('' +
            '                        <div class="row">\n' +
            '                            <div class="col-md-12 form-group">\n' +
            '                                <input type="file" id="exp_with_receipt_file">\n' +
            '                            </div>\n' +
            '                        </div>')
    }
    else if($(this).val() == 'Without')
    {
        // // console.log('without');
        $('#row_attachment_receipt_span').html('');
    }

});

var form_data_expenses = new FormData();

$('#left_daily_expenses').click(function () {

    $.ajax({

        url: 'ci_get_finish_accounts_for_expenses',
        type: 'get',
        success : function (data) {

            var datas = '';
            var ctr = 0;
            $('#daily_date_expenses').html(data[1]);
            for(ctr; ctr<data[0].length; ctr++)
            {
                datas += '<tr>' +
                    '<td>' + data[0][ctr].type_of_request + '</td>' +
                    '<td>' + data[0][ctr].account_name + '</td>' +
                    '<td>' + data[0][ctr].address +', '+data[0][ctr].city_muni +' '+data[0][ctr].provinces + '</td>' +
                    '</tr>';

                // endorsements_array_id[ctr] = data[0][ctr].id;
                form_data_expenses.append('endorsements_array_id[]',data[0][ctr].id);
            }
            form_data_expenses.append('endorsement_count',ctr);

            $('#table_exp_finish_body').html(datas);


        },
        error : function () {
            // console.log('error');
        }

    });

});

var expenses_declared_count = 0;
var get_total_fund = 0;
var get_total_personal = 0;
$('#btn_add_declare_exp').click(function () {

    var label = $('#expense_label').val();
    var amount = $('#expense_amount').val();
    var from = $('#expense_select_type').val();
    var or = '';
    var remarks = $('#ci_fund_exp_remarks').val();

    if($('#expense_select_receipt').val() == 'Without')
    {
        or = 'Without';

        form_data_expenses.append(''+expenses_declared_count+'-checker','inputted');
        form_data_expenses.append(''+expenses_declared_count+'-label',label);
        form_data_expenses.append(''+expenses_declared_count+'-amount',amount);
        form_data_expenses.append(''+expenses_declared_count+'-from',from);
        form_data_expenses.append(''+expenses_declared_count+'-or_label','Without');
        form_data_expenses.append(''+expenses_declared_count+'-file_to_upload','No uploaded file');
        form_data_expenses.append(''+expenses_declared_count+'-remarks',remarks);

        if(from == 'Fund')
        {
            get_total_fund = (get_total_fund + parseInt(amount));
        }
        else if(from == 'Personal')
        {
            get_total_personal = (get_total_personal + parseInt(amount));
        }
        else if(from == 'Revolving')
        {
            get_total_fund = (get_total_fund + parseInt(amount));
        }

    }
    else
    {
        var attachment = $('#exp_with_receipt_file').prop('files')[0];

        form_data_expenses.append(''+expenses_declared_count+'-checker','inputted');
        form_data_expenses.append(''+expenses_declared_count+'-label',label);
        form_data_expenses.append(''+expenses_declared_count+'-amount',amount);
        form_data_expenses.append(''+expenses_declared_count+'-from',from);
        form_data_expenses.append(''+expenses_declared_count+'-or_label','With');
        form_data_expenses.append(''+expenses_declared_count+'-file_to_upload',attachment);
        form_data_expenses.append(''+expenses_declared_count+'-remarks',remarks);

        if(from == 'Fund')
        {
            get_total_fund = (get_total_fund + parseInt(amount));
        }
        else if(from == 'Personal')
        {
            get_total_personal = (get_total_personal + parseInt(amount));
        }
        else if(from == 'Revolving')
        {
            get_total_fund = (get_total_fund + parseInt(amount));
        }

        if($('#exp_with_receipt_file').get(0).files.length == 0)
        {
            alert('No file is selected.');
            return;
        }
        else
        {
            or = attachment.name;
        }

    }


    if(label != '')
    {
        $('#table_exp_declared_body').append(
            '<tr id="expenses_row-'+expenses_declared_count+'">' +
            '<td class="class_exp_label">'+label+'</td>' +
            '<td class="class_exp_amount">'+amount+'</td>' +
            '<td class="class_exp_from">'+from+'</td>' +
            '<td class="class_exp_or">'+or+'</td>' +
            '<td class="class_exp_remarks">'+remarks+'</td>' +
            '<td><button type="button" class="btn_remove_declared_expenses btn btn-block btn-danger btn-xs" name="'+expenses_declared_count+'">-</button></td>' +
            '</tr>'
        );

        $('#total_expense_span').html(get_total_fund);
        $('#total_Reimbursement_span').html(get_total_personal);

        expenses_declared_count++;

        $('#expense_label').val('');
        $('#expense_amount').val('');
        $('#expense_select_type').val('Fund').change();
        $('#expense_select_receipt').val('Without').change();
        $('#ci_fund_exp_remarks').val('');
    }
    else
    {
        alert('Fill up required field. Please Try again.');
    }



});

$(document).on('click','.btn_remove_declared_expenses', function () {

    var count = $(this).attr('name');

    if(form_data_expenses.get(''+count+'-from') == 'Fund')
    {
        get_total_fund = get_total_fund + parseInt(form_data_expenses.get(''+count+'-amount'));
    }
    else if(form_data_expenses.get(''+count+'-from') == 'Peronal')
    {
        get_total_personal = get_total_personal + parseInt(form_data_expenses.get(''+count+'-amount'));
    }


    form_data_expenses.append(''+count+'-checker','deleted');

    $('#expenses_row-'+count+'').remove();

});

$('#btn_expenses_submit').click(function () {

    var count_row = $('#table_exp_declared_body').find('tr').length;

    form_data_expenses.append('total_count',expenses_declared_count);
    form_data_expenses.append('total_expenses',get_total_fund);
    form_data_expenses.append('total_reimbursement',get_total_personal);

    $(this).attr('disabled','disabled');

    if(count_row != 0)
    {
        if(get_total_fund < 0)
        {
            alert('Insufficient Fund.');
            $('#btn_expenses_submit').removeAttr('disabled');
        }
        else
        {
            $.ajax({

                xhr: function()
                {
                    var xhr = new window.XMLHttpRequest();
                    //Upload progress
                    xhr.upload.addEventListener("progress", function(evt)
                    {
                        if (evt.lengthComputable) {

                            var percentComplete = evt.loaded / evt.total;
                            //Do something with upload progress
                            $('#ulPercentage_bi_expenses').html('');
                            $('#ulPercentage_bi_expenses').show();
                            // $('#ulPercentage').append(percentComplete*100);
                            $('#ulPercentage_bi_expenses').append(Math.floor(percentComplete*100));
                            $('#progressbar_bi_expenses').show();

                            $('#progressbar_bi_expenses').progressbar
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
                            // console.log(percentComplete);
                        }
                    }, false);
                    return xhr;
                },
                url: 'ci_submit_daily_expenses',
                type: 'post',
                processData: false,
                contentType: false,
                data: form_data_expenses,
                success: function (data) {
                    // console.log('result: '+data);
                    if(data == 'success')
                    {
                        $('#ulPercentage_bi_expenses').hide();
                        $('#progressbar_bi_expenses').hide();
                        $('#btn_expenses_submit').removeAttr('disabled');
                        alert('Success! Thank you.');
                        notifs();
                        if(tableExpensesReport != '')
                        {
                            tableExpensesReport.ajax.reload();
                        }

                        $('.btn_remove_declared_expenses').each(function () {
                            $(this).click();
                        });

                        form_data_expenses = new FormData();
                        expenses_declared_count = 0;
                        get_total_fund = 0;
                        get_total_personal = 0;
                        $('#total_expense_span').html(get_total_fund);
                        $('#total_Reimbursement_span').html(get_total_personal);
                    }
                    else
                    {
                        $('#btn_expenses_submit').removeAttr('disabled');
                    }
                },
                error: function () {
                    // console.log('error');
                    $('#btn_expenses_submit').removeAttr('disabled');
                }

            });
        }


    }
    else
    {
        alert('Please add your expenses.');
        $('#btn_expenses_submit').removeAttr('disabled');
    }
    // console.log('pindot');
});
getReceivedLiquidation();
function getReceivedLiquidation()
{
    tableFundReceiveLiquidation = $('#table-fund-receive-liquidation').DataTable(
        {
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "ajax": "/ci-fund-receive-liquidation-table",
            "columns":
                [
                    {data: 'id', name: 'fund_requests.id'},
                    {
                        data: function type(data) {

                            var remittance_check = data.check_remittance;
                            var atm_check = data.check_atm;
                            var shell_check = data.check_shell_card;

                            var type = '';

                            if(remittance_check != 0)
                            {
                                type = 'Remittance';

                                if(shell_check !=0)
                                {
                                    type = 'Remittance with Shell Card';
                                }
                            }
                            else if(atm_check != 0)
                            {
                                type = 'ATM';

                                if(shell_check !=0)
                                {
                                    type = 'ATM with Shell Card';
                                }
                            }
                            else if(shell_check != 0 && remittance_check == 0 && atm_check == 0)
                            {
                                type = 'Shell Card Only';
                            }

                            return type;
                        },
                        "orderable": false,
                        "searchable": true,
                        "name": 'type',
                        "autoWidth": false
                    },
                    {
                        data: function datetime(data)
                        {
                            var remittance_check = data.check_remittance;
                            var atm_check = data.check_atm;
                            var shell_check = data.check_shell_card;

                            var date_time_of_send = '';

                            if(remittance_check != 0)
                            {
                                date_time_of_send = data.remit_date_of_send;
                            }
                            else if(atm_check != 0)
                            {
                                date_time_of_send = data.atm_date_of_send;

                            }
                            else if(shell_check != 0 && remittance_check == 0 && atm_check == 0)
                            {
                                date_time_of_send = data.shell_date_of_send;

                            }
                            return date_time_of_send;
                        },
                        "orderable": false,
                        "searchable": true,
                        "name": 'type',
                        "autoWidth": false
                    },
                    {data : 'atm_info', name : 'atm_info'},
                    {data : 'remittances_info', name : 'remittances_info'},
                    {
                        data: function received(data) {

                            var remittance_check = data.check_remittance;
                            var atm_check = data.check_atm;
                            var shell_check = data.check_shell_card;

                            var date_time_receive = '';

                            if(remittance_check != 0)
                            {
                                date_time_receive = data.remit_status_date_time;
                            }
                            else if(atm_check != 0)
                            {
                                date_time_receive = data.atm_status_date_time;

                            }
                            else if(shell_check != 0 && remittance_check == 0 && atm_check == 0)
                            {
                                date_time_receive = data.shell_status_date_time;

                            }
                            return date_time_receive;
                        },
                        "orderable": false,
                        "searchable": true,
                        "name": 'type',
                        "autoWidth": false
                    },
                    {
                        data: function type(data) {

                            var remittance_check = data.remittance_id;
                            var atm_check = data.ci_atm_fund_id;
                            var shell_check = data.ci_shell_card_id;

                            var amount = '';

                            if(remittance_check != 0)
                            {
                                amount = atob(data.amount);
                            }
                            else if(atm_check != 0)
                            {
                                amount = atob(data.amount);

                            }
                            else if(shell_check != 0 && remittance_check == 0 && atm_check == 0)
                            {
                                amount = '-';

                            }
                            return amount;
                        },
                        "orderable": false,
                        "searchable": true,
                        "name": 'type',
                        "autoWidth": false
                    },
                    { data : 'liq', name : 'fund_requests.liquidated_amount'},
                    { data : 'unliq', name : 'fund_requests.unliquidated_amount'},
                    { data : 'stats', name : 'stats'},
                    {
                        data : function action(data)
                        {
                            return '<button>test</button>';
                        }
                    }

                ],
            "order": [[0, 'desc']],
            "pageLength": 10,
            "bSortClasses": false,
            "autoWidth": false,

        }
    );
}

function get_table_liq_done_fund()
{
    tableFundDoneLiq = $('#table-fund-liq-done').DataTable(
        {
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "ajax": "/ci-fund-done-liq-table",
            "columns":
                [
                    {data: 'fund_id', name: 'fund_requests.id'},
                    {
                        data: function type(data)
                        {
                            var remittance_check = data.remittance_id;
                            var atm_check = data.ci_atm_fund_id;
                            var shell_check = data.ci_shell_card_id;

                            var type = '';

                            if(remittance_check == 0 && atm_check == 0)
                            {
                                type = 'Assigned by SAO';
                            }
                            else if(remittance_check != 0)
                            {
                                type = 'Remittance';

                                if(shell_check !=0)
                                {
                                    type = 'Remittance with Shell Card';
                                }
                            }
                            else if(atm_check != 0)
                            {
                                type = 'ATM';

                                if(shell_check !=0)
                                {
                                    type = 'ATM with Shell Card';
                                }
                            }
                            else if(shell_check != 0 && remittance_check == 0 && atm_check == 0)
                            {
                                type = 'Shell Card Only';
                            }

                            return type;
                        },
                        "orderable": false,
                        "searchable": true,
                        "name": 'ci_fund_remittances.remittance_id',
                        "autoWidth": false
                    },
                    {
                        data: function type(data)
                        {

                            var remittance_check = data.remittance_id;
                            var atm_check = data.ci_atm_fund_id;
                            var shell_check = data.ci_shell_card_id;

                            var date_time_of_send = '';

                            if(remittance_check == 0 && atm_check == 0 && shell_check == 0)
                            {
                                date_time_of_send = data.confirm_fund;
                            }
                            else if(remittance_check != 0)
                            {
                                date_time_of_send = data.remit_date_of_send;
                            }
                            else if(atm_check != 0)
                            {
                                date_time_of_send = data.atm_date_of_send;

                            }
                            else if(shell_check != 0 && remittance_check == 0 && atm_check == 0)
                            {
                                date_time_of_send = data.shell_date_of_send;
                            }
                            return date_time_of_send;
                        },
                        "orderable": false,
                        "searchable": true,
                        "name": 'ci_fund_remittances.remittance_id',
                        "autoWidth": false
                    },
                    {
                        data: function type(data) {

                            var remittance_check = data.remittance_id;
                            var atm_check = data.ci_atm_fund_id;
                            var shell_check = data.ci_shell_card_id;

                            var bank_account = '';

                            if(remittance_check == 0 && atm_check == 0 && shell_check == 0)
                            {
                                bank_account = '-'
                            }
                            else if(remittance_check != 0)
                            {
                                bank_account = '-';
                            }
                            else if(atm_check != 0)
                            {
                                bank_account = data.atm_bank_name+': '+data.atm_account_number;

                            }
                            else if(shell_check != 0 && remittance_check == 0 && atm_check == 0)
                            {
                                bank_account = '-';
                            }
                            return bank_account;
                        },
                        "orderable": false,
                        "searchable": true,
                        "name": 'ci_fund_remittances.remittance_id',
                        "autoWidth": false
                    },
                    {data: 'remit_info', name: 'remit_info.id', orderable: false, searchable: false, autoWidth: false},
                    {
                        data: function type(data) {

                            var remittance_check = data.remittance_id;
                            var atm_check = data.ci_atm_fund_id;
                            var shell_check = data.ci_shell_card_id;

                            var date_time_receive = '';

                            if(remittance_check == 0 && atm_check == 0 && shell_check == 0)
                            {
                                date_time_receive = data.confirm_fund;
                            }
                            else if(remittance_check != 0)
                            {
                                date_time_receive = data.remit_status_date_time;
                            }
                            else if(atm_check != 0)
                            {
                                date_time_receive = data.atm_status_date_time;

                            }
                            else if(shell_check != 0 && remittance_check == 0 && atm_check == 0)
                            {
                                date_time_receive = data.shell_status_date_time;

                            }
                            return date_time_receive;
                        },
                        "orderable": false,
                        "searchable": true,
                        "name": 'ci_fund_remittances.remittance_id',
                        "autoWidth": false
                    },
                    {
                        data: function type(data) {

                            var remittance_check = data.remittance_id;
                            var atm_check = data.ci_atm_fund_id;
                            var shell_check = data.ci_shell_card_id;

                            var amount = '';

                            if(remittance_check == 0 && atm_check == 0 && shell_check == 0)
                            {
                                amount = atob(data.fund_amount);
                            }
                            else if(remittance_check != 0)
                            {
                                amount = atob(data.remit_amount);
                            }
                            else if(atm_check != 0)
                            {
                                amount = data.atm_amount;

                            }
                            else if(shell_check != 0 && remittance_check == 0 && atm_check == 0)
                            {
                                var decodeAmount = atob(data.fund_amount);
                                amount = decodeAmount;

                            }
                            return amount;
                        },
                        "orderable": false,
                        "searchable": true,
                        "name": 'ci_fund_remittances.remittance_id',
                        "autoWidth": false
                    },
                    {data : 'liq', name : 'fund_requests.liquidated_amount'},
                    {data : 'unliq', name : 'fund_requests.unliquidated_amount'},
                    {data: 'stats', name: 'stats', orderable: false, searchable: false, autoWidth: false},
                    {
                        data: function action(data) {
                            return '<a name="' + data.id + '" class="btn btn-xs btn-block btn-info" id="btn_trigger_liquidate_done" data-toggle="modal" data-target="#modal_ci_endorsements_fund"><i class="fa fa-list"></i> Liquidate</a>';
                        },
                        "orderable": false,
                        "searchable": false,
                        "name": 'ci_fund_remittances.remittance_id',
                        "autoWidth": false
                    },

                ],
            "order": [[0, 'desc']],
            "pageLength": 10,
            "bSortClasses": false,
            "autoWidth": false
        });

    $('#table-fund-liq-done_filter input').unbind();
    $('#table-fund-liq-done_filter input').bind('keyup change',function (e) {

        if($(this).is(':focus'))
        {
            if (e.keyCode == 13) {
                tableFundDoneLiq.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '') {
                    tableFundDoneLiq.search($(this).val()).draw();
                }
            }
        }
    });
}

$('#table-fund-liq-done').on('click','#btn_trigger_liquidate_done', function ()
{
    var table_id = $(this).attr('name');
    table_accept_fund(table_id);
    // console.log(table_id);
});

function check_validation_encode_attach_visit(account_id,where) {
    // encode_icon
    // attachments_icon
    // update_date_time_icon

    $.ajax({

        url: 'ci_check_validation_en_attach_visit',
        type: 'get',
        data: {
            'acctID' : account_id,
            'where' : where
        },
        success: function (data) {

            console.log(data);

            if(where == 'need_to_refresh')
            {
                if(data['stat'] == 'good_to_go')
                {
                    if($('#tab1').parent().hasClass('active'))
                    {
                        table.ajax.reload(null, false);
                    }
                    else if($('#tab2').parent().hasClass('active'))
                    {
                        tableFinishAccount.ajax.reload(null, false);
                    }
                    initialise();
                }
                else if(data['stat'] == 'upload_not_avail')
                {
                    alert('Unable to upload File/s due to account is already finished');
                    initialise();
                }
            }

        // class="fa fa-exclamation-circle" style="color: orange" = pending
        // class="fa fa-check-circle" style="color: green" = pending

            if(data['encode'] == true)
            {
                $('#encode_icon').attr('class','fa fa-check-circle');
                $('#encode_icon').attr('style','color: green');
            }
            else
            {
                $('#encode_icon').attr('class','fa fa-exclamation-circle');
                $('#encode_icon').attr('style','color: orange');
            }

            if(data['attach'] == true)
            {
                $('#attachments_icon').attr('class','fa fa-check-circle');
                $('#attachments_icon').attr('style','color: green');
            }
            else
            {
                $('#attachments_icon').attr('class','fa fa-exclamation-circle');
                $('#attachments_icon').attr('style','color: orange');
            }

            if(data['visit'] == true)
            {
                $('#update_date_time_icon').attr('class','fa fa-check-circle');
                $('#update_date_time_icon').attr('style','color: green');
            }
            else
            {
                $('#update_date_time_icon').attr('class','fa fa-exclamation-circle');
                $('#update_date_time_icon').attr('style','color: orange');
            }

            console.log('succcess');
        },
        error: function () {
            console.log('error')
        }

    });
}


var tableBiReports;

getBiReports();

function getBiReports()
{
    tableBiReports = $('#bi-report-table').DataTable(
        {
            dom: 'Bfrtip',
            buttons: [
                {
                    text: 'REFRESH',
                    action: function ( e, dt, node, config ) {
                        tableBiReports.ajax.reload(null, false);
                    }
                }
            ],
            "responsive": true,
            "processing": true,
            "serverSi   de": true,
            "ajax": "/ci-bi-reports-table",
            "columns":
                [
                    {data: 'id', name: 'bi_ci_report.id'},
                    {data: 'client_name', name: 'bi_ci_report.client_name'},
                    {data: 'subj_name', name: 'bi_ci_report.subj_name'},
                    {data: 'created_at', name: 'bi_ci_report.created_at'},
                    {
                        data: function action (data)
                        {
                            return '<button class="btn btn-sm btn-success btn-block edit_bi_note" href="'+data.id+'"><i class="glyphicon glyphicon-pencil"></i> Edit B.I Report Note</button>';
                                // '<button class="btn btn-sm btn-info btn-block view_bi_rep_logs" href="'+data.id+'"><i class="glyphicon glyphicon-film"></i>Logs</button>';
                        },
                        'name' : 'bi_ci_report.id',
                        searchable : false,
                        orderable : false
                    }
                ],
            "order": [[0, 'desc']],
            "pageLength": 10,
            "bSortClasses": false,
            "autoWidth": false
        });
}

$('.bi_report_logs').each(function()
{
    var table_id = $(this).attr('id');
    $('#'+table_id+'').on('click', '.view_bi_rep_logs', function()
    {
        // console.log($(this).attr('href'));
        $('#for_bi_logs_table').html('');

        $('#modal_bi_note_logs').modal('show');
        $.ajax({
            type: 'get',
            url: 'ci_bi_note_view_logs',
            data: {
                'id' : $(this).attr('href')
            },
            success:function(data)
            {
                var head = '<table width="100%" class="table-condensed table-hover">\n' +
                    '    <tr style="background-color: brown; color: white">\n' +
                    '        <th>USER</th>\n' +
                    '        <th>POSITION</th>\n' +
                    '        <th>ACTIVITIES</th>\n' +
                    '        <th>DATE/TIME OCCURED</th>\n' +
                    '    </tr>';
                var to_append = '';

                if(data[0].length > 0)
                {
                    for(var i = 0;i < data[0].length; i++)
                    {
                        to_append += '<tr>\n' +
                            '    <td>'+data[0][i].name+'</td>\n' +
                            '    <td>'+data[0][i].position+'</td>\n' +
                            '    <td>'+data[0][i].activities+'</td>\n' +
                            '    <td>'+data[0][i].datetime+'</td>\n' +
                            '</tr>';
                    }
                }
                else
                {
                    to_append += '<tr>\n' +
                        '    <td colspan="4">NO RECORED FOUND</td>\n' +
                        '</tr>';
                }

                $('#for_bi_logs_table').html(head + to_append + '</table>');

            },
            error: function(e)
            {
                alert('Error occured contact the web admin for assistance. Thank you');
            }
        });
    });
});

$('#bi-report-table').on('click', '.edit_bi_note', function()
{
    var $this = $(this).attr('href');

    get_uploader_bi_rep_edit($this);

    $('#update_bi_note').val('');
    $.ajax({
        type: 'get',
        url: 'get_current_bi_note',
        data: {
            'id' : $(this).attr('href')
        },
        success: function(data)
        {
            console.log(data);

            $('#modal_ci_update_bi_note').modal('show');
            $('#update_bi_note_btn').attr('href', btoa($this));
            $('#update_bi_note').val(data[0].ci_note);
            $('#update_bi_subj_name').val(data[0].subj_name);
            $('#update_bi_name').val(data[0].client_name);
        },
        error: function(e)
        {
            alert('Error occured contact the web admin for assistance. Thank you');
        }
    });
});

$('#add_bi_note_btn').click(function()
{
    $(this).attr('disabled', true);
    var add_note = $('#insert_bi_note').val();

    if(add_note != '' && $('#insert_bi_subj_name').val() != '' && $('#insert_bi_name').val() != '' && bi_rep_array.length > 0)
    {
        $('#overlay_add_note_bi').show();
        // $('#add_bi_note_btn').attr('disabled', true);
        $('#bi-rep-fine').fineUploader('uploadStoredFiles');
    }
    else
    {
        $(this).attr('disabled', false);
        alert('Fill-up the textarea and upload an attachment to continue');
    }

});

$('#update_bi_note_btn').click(function()
{
    if(confirm('Are you sure to update the note?'))
    {
        if(bi_rep_array_edit.length > 0)
        {
            $('#bi-rep-fine-edit').fineUploader('uploadStoredFiles');
        }
        else
        {
            $.ajax({
                type: 'get',
                url: 'ci_edit_bi_note',
                data: {
                    'id' : $('#update_bi_note_btn').attr('href'),
                    'note' : $('#update_bi_note').val(),
                    'subj_name' : $('#update_bi_subj_name').val(),
                    'client_name' : $('#update_bi_name').val()
                },
                success: function(data)
                {
                    if(data == 'ok')
                    {
                        tableBiReports.draw();
                        $('#modal_ci_update_bi_note').modal('hide');
                        alert('Note Successfully Updated!');
                    }
                },
                error: function(e)
                {
                    alert('Error occured contact the web admin for assistance. Thank you');
                }
            });
        }
    }
});

get_uploader_bi_rep();

function get_uploader_bi_rep(verifyCode)
{
    $('#bi-rep-fine').html('');

    fineupload = new $('#bi-rep-fine').fineUploader
    ({
        template: 'qq-bi-rep-manual-trigger',
        request:
            {
                endpoint: 'ci_upload_bi_report_fineuploader/' + verifyCode,
                customHeaders:
                    {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
            },
        thumbnails:
            {
                placeholders:
                    {
                        waitingPath: '/fine-uploader/placeholders/waiting-generic.png',
                        notAvailablePath: '/fine-uploader/placeholders/not_available-generic.png'
                    }
            },
        retry:
            {
                enableAuto: true,
                maxAutoAttempts: 5
            },
        scaling:
            {
                sendOriginal: false,
                sizes:
                    [
                        {maxSize: 800}
                    ]
            },
        validation:
            {
                itemLimit: 50,
                allowedExtensions: ['jpe', 'jpg', 'jpeg', 'png', 'bmp']
                // allowedExtensions: ['jpe', 'jpg', 'jpeg', 'png', 'bmp', 'pdf', 'xls', 'xlt', 'xlm', 'xlsx', 'xlsm', 'xltx', 'xltm', 'xlsb', 'xla', 'xlam', 'xll', 'xlw']
            },
        callbacks:
            {
                onStatusChange: function (id,status_old,status_new)
                {
                    item_status = status_new;

                    if(status_new == 'submitted')
                    {
                        bi_rep_array.push(this.getName(id));
                    }
                    else if(status_new == 'canceled')
                    {
                        bi_rep_array.pop();
                    }
                },
                onComplete: function (id)
                {

                },
                onAllComplete: function (id)
                {
                    bi_rep_array = [];

                    $.ajax({
                        type: 'get',
                        url: 'ci_add_bi_note',
                        data: {
                            'note' : $('#insert_bi_note').val(),
                            'client_name' : $('#insert_bi_name').val(),
                            'subj_name' : $('#insert_bi_subj_name').val(),
                            'verifier' : verifyCode
                        },
                        success: function(data)
                        {
                            // console.log(data);
                            if(data[0] == 'ok')
                            {
                                $('#insert_bi_note').val('');
                                $('#insert_bi_subj_name').val('');
                                $('#insert_bi_name').val('');
                                tableBiReports.ajax.reload(null, false);
                                $('#modal_ci_add_bi_note').modal('hide');
                                $('#overlay_add_note_bi').hide();
                                $('#add_bi_note_btn').attr('disabled', false);
                                alert('Note Successfully Added!');
                            }
                        },
                        error: function(e)
                        {
                            alert('Error occured contact the web admin for assistance. Thank you');
                        }
                    });

                    // get_uploader_bi_rep();
                }
            },
        autoUpload: false,
        maxConnections: 1
    });
}

$('#ci_bi_rep_init').click(function()
{
    var datenow = new Date();
    var month = (parseInt(datenow.getMonth()) + 1);
    var day = datenow.getDate();
    if(month < 10)
    {
        month = '0' + month;
    }

    if(day < 10)
    {
        day = '0' + day;
    }

    var dateNow = datenow.getFullYear() + '' + month + '' + day + '' + datenow.getHours() + '' + datenow.getMinutes() + '' + datenow.getSeconds() + '' + datenow.getMilliseconds();
    // var dateNowToSend = datenow.getFullYear() + '' + month + '' + day;
    get_uploader_bi_rep(dateNow);
});

function get_uploader_bi_rep_edit(rep_id)
{
    $('#bi-rep-fine-edit').html('');

    fineupload = new $('#bi-rep-fine-edit').fineUploader
    ({
        template: 'qq-bi-rep-manual-trigger',
        request:
            {
                endpoint: 'ci_upload_bi_report_fineuploader_edit/' + rep_id,
                customHeaders:
                    {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
            },
        thumbnails:
            {
                placeholders:
                    {
                        waitingPath: '/fine-uploader/placeholders/waiting-generic.png',
                        notAvailablePath: '/fine-uploader/placeholders/not_available-generic.png'
                    }
            },
        retry:
            {
                enableAuto: true,
                maxAutoAttempts: 5
            },
        scaling:
            {
                sendOriginal: false,
                sizes:
                    [
                        {maxSize: 800}
                    ]
            },
        validation:
            {
                itemLimit: 50,
                allowedExtensions: ['jpe', 'jpg', 'jpeg', 'png', 'bmp']
                // allowedExtensions: ['jpe', 'jpg', 'jpeg', 'png', 'bmp', 'pdf', 'xls', 'xlt', 'xlm', 'xlsx', 'xlsm', 'xltx', 'xltm', 'xlsb', 'xla', 'xlam', 'xll', 'xlw']
            },
        callbacks:
            {
                onStatusChange: function (id,status_old,status_new)
                {
                    item_status = status_new;

                    if(status_new == 'submitted')
                    {
                        bi_rep_array_edit.push(this.getName(id));
                    }
                    else if(status_new == 'canceled')
                    {
                        bi_rep_array_edit.pop();
                    }
                },
                onComplete: function (id)
                {

                },
                onAllComplete: function (id)
                {
                    bi_rep_array_edit = [];

                    $.ajax({
                        type: 'get',
                        url: 'ci_edit_bi_note',
                        data: {
                            'id' : $('#update_bi_note_btn').attr('href'),
                            'note' : $('#update_bi_note').val(),
                            'subj_name' : $('#update_bi_subj_name').val(),
                            'client_name' : $('#update_bi_name').val()
                        },
                        success: function(data)
                        {
                            if(data == 'ok')
                            {
                                tableBiReports.draw();
                                $('#modal_ci_update_bi_note').modal('hide');
                                alert('Note Successfully Updated!');
                            }
                        },
                        error: function(e)
                        {
                            alert('Error occured contact the web admin for assistance. Thank you');
                        }
                    });

                    // get_uploader_bi_rep();
                }
            },
        autoUpload: false,
        maxConnections: 1
    });
}

function checkUpdateTimeAcct()
{
    $.ajax
    ({
        type : 'get',
        url : 'ci_get_update_time_details',
        data :
            {
                'id' : accountID
            },
        success : function(data)
        {
            console.log(data);

            var date = data[0][0].date_ci_visit;
            var time = data[0][0].time_ci_visit;
            var today = new Date();
            var date2 = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
            var time2 = today.getHours() + ":" + today.getMinutes();


            if(date == '0000-00-00' && time == '00:00:00')
            {
                checkAccountUpdateTimeVisit = true;
            }
            else
            {
                checkAccountUpdateTimeVisit = false;
            }

            if(data[1][0].stat == 'Yes')
            {
                permissionUpdateTime = true;

                $('#DateVisit').val('');
                $('#TimeVisit').val('');
            }
            else if(data[1][0].stat != 'Yes')
            {
                permissionUpdateTime = false;


                $('#DateVisit').val(date2);
                $('#TimeVisit').val(time2);
            }
        }
    })
}


function funcIssuanceGenMonitCI()
{
    console.log('test floyd');

    tableGenIssuanceCI = $('#gen_sent_issuance_mail_ci').DataTable
    ({
        "responsive": true,
        "processing": true,
        "serverSide": true,
        "ajax": 'gen_monit_issuance_table',
        "columns":
            [
                {data: 'date', name: 'hr_issuance_main.created_at'},
                {data: 'name_sender', name: 'users.name'},
                {data: 'to', name: 'hr_issuance_main.issuance_to'},
                {
                    data : function sub(data)
                    {
                        return '<b>' + data.subj + '</b>';
                    },
                    name: 'hr_issuance_main.issuance_subject'

                },
                {
                    data : function action(data)
                    {
                        return '<button class="btn bg-navy btn-xs btn-block btnViewInfoIssuanceCiGen" name="'+btoa(data.id)+'"><i class="fa fa-eye"></i>View Issuance</button>'
                    },
                    name : 'hr_issuance_main.id',
                    'orderable' : false,
                    'searchable' : false
                }
            ],
        "fnRowCallback": function(nRow, aData)
        {
            $(nRow).attr('name', btoa(aData.id));
        },
        "order": [[0, 'desc']],
        "pageLength": 25,
        "lengthMenu": [[10, 25, 50, 100, -1], ['10 rows', '25 rows', '50 rows', '100 rows', 'Show all']],
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
                            if (that.search() !== this.value)
                            {
                                that
                                    .search(this.value)
                                    .draw();
                            }
                        }
                        else if (e.keyCode === 8)
                        {
                            if (this.value == '')
                            {
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

    $('#gen_sent_issuance_mail_ci_filter input').unbind();
    $('#gen_sent_issuance_mail_ci_filter input').bind('keyup change', function (e)
    {
        if ($(this).is(':focus'))
        {
            if (e.keyCode == 13)
            {
                tableGenIssuanceCI.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '')
                {
                    tableGenIssuanceCI.search($(this).val()).draw();
                }
            }
        }
    });


    $('#gen_sent_issuance_mail_ci').on('click', '.btnViewInfoIssuanceCiGen', function ()
    {
        var id = $(this).attr('name');


        $.ajax
        ({
            type : 'get',
            url : 'gen_fetch_issuance_indiv',
            data :
                {
                    'id' : id
                },
            success : function(data)
            {
                console.log(data)
                $('#placeSubGenIssuanceCI').html(data[0][0].issuance_subject);
                $('#placeMessageGenIssuanceCI').html(data[0][0].issuance_content);
                $('#placeSenderGenIssuanceCI').html(data[0][0].name);


                if(data[1].length > 0)
                {
                    for(var t = 0; t < data[1].length; t++)
                    {
                        $('#loopAllFilesPlaceIssuanceCI').append
                        (
                            '                                        <li>\n' +
                            '                                            <span class="mailbox-attachment-icon"><i class="fa fa-fw fa-file"></i></span>\n' +
                            '\n' +
                            '                                            <div class="mailbox-attachment-info" style="">\n' +
                            '                                                <a class="mailbox-attachment-name" href="/getHrIssuanceFilesGeneral/'+id+'/'+btoa(data[1][t].id)+'" target="_blank" > '+data[1][t].file_name+'</a>\n' +
                            '                                            </div>\n' +
                            '                                        </li>'
                        )
                    }
                }


                $('#showSentIssuanceGenCI').hide();
                $('#showMessageGenIssuanceCI').show();

            },
            error : function()
            {
                alert('An error has occured. Please contact the developers.')
            }
        })
    });

    $('#refreshGenIssuanceTabCI').click(function()
    {
        $('#placeSubGenIssuanceCI').html('');
        $('#placeMessageGenIssuanceCI').html('');
        $('#placeSenderGenIssuanceCI').html('');
        $('#loopAllFilesPlaceIssuanceCI').html('');

        $('#showSentIssuanceGenCI').show();
        $('#showMessageGenIssuanceCI').hide();
    });

    $('#btnRefreshTableIssuanceCI').click(function()
    {
        tableGenIssuanceCI.ajax.reload(null, false);
    });
}