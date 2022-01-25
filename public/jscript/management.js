var jan, feb, mar, apr, may, jun, jul, aug, sep, oct, nov, dec, year;
var titleee=[];
var title;
var i = 0;
var table;
var table_fund;
var table_expenses;
var activeTab1 = 'search_active';
var which_tab_active = 'tab_1_fund';

var man_dashboard_tab_bool = false;
var search_acct = true;
var man_audit_tab_bool = false;
var man_fund_tab_bool = false;
var man_report_tab_bool = false;
var man_ci_fund_req_tab_bool = false;
var man_fa_mon_bool = false;

var tab_1_fund_bool = true;
var tab_2_fund_bool = false;
var tab_3_fund_bool = false;

var fund_audit_req = true;
var fund_audit_exp = false;

var refreshApp = false;
var refreshDis = false;

var which_is_active = 'man_audit_tab';

var management_leave_tab = false;
var event_id;
var events = [];

var approvalId;

var tableFund1 = [];
var fund_1 = 0;
var tableFund2 = [];
var fund_2 = 0;
var tableFund3 = [];
var fund_3 = 0;

var tableFundFa;
var coltittle3 = [];
var col_count3 = 0;

var titleMonitApproval;
var titleforAppSup  = [];
var for_app_sup = 0;


var titleforAppSup2 = [];
var for_app_sup_2 = 0;
var titleMonitApproval2;

var checkmonitApp = false;

var tele_ci_gen_table = '';
var tele_ci_gen_table_array = [];
var tele_ci_gen_table_title = 0;
var tele_ci_gen_table_bool = false;

var tele_ci_gen_table2 = '';
var tele_ci_gen_table_array2 = [];
var tele_ci_gen_table_title2 = 0;
var tele_ci_gen_table_bool2 = false;
var attendance_sched = true;

var full_calendar_mon;

$.ajaxSetup
({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

// $(document).ready(function()
// {
//
// });

$('.ci_fund_tab').click(function()
{
    var gethref = $(this).attr('href');

    console.log(gethref);

    if(gethref == '#tab_1_fund')
    {
        if( $(''+gethref+'').hasClass('active'))
        {
            console.log('do nothing');
            which_tab_active = 'tab_1_fund';

        }
        else if(tab_1_fund_bool)
        {
            console.log('already loaded');
            which_tab_active = 'tab_1_fund';

        }
        else if(tab_1_fund_bool == false)
        {
            tab_1_fund_bool = true;
            which_tab_active = 'tab_1_fund';
        }
    }
    else if(gethref == '#tab_2_fund')
    {
        console
        if( $(''+gethref+'').hasClass('active'))
        {
            console.log('do nothing');
            which_tab_active = 'tab_2_fund';

        }
        else if(tab_2_fund_bool)
        {
            if(refreshApp == true)
            {
                table_ci_fund_app.ajax.reload(null, false);
                refreshApp = false;
            }
            else
            {
                console.log('already loaded');
            }
            which_tab_active = 'tab_2_fund';

        }
        else if(tab_2_fund_bool == false)
        {
            tab_2_fund_bool = true;
            which_tab_active = 'tab_2_fund';
            app_table();
        }
    }
    else if(gethref == '#tab_3_fund')
    {
        if( $(''+gethref+'').hasClass('active'))
        {
            console.log('do nothing');
            which_tab_active = 'tab_3_fund';

        }
        else if(tab_3_fund_bool)
        {
            if(refreshDis == true)
            {
                table_ci_fund_dec.ajax.reload(null, false);
                refreshDis = false;
            }
            else
            {
                console.log('already loaded');
            }
            which_tab_active = 'tab_3_fund';

        }
        else if(tab_3_fund_bool == false)
        {
            tab_3_fund_bool = true;
            which_tab_active = 'tab_3_fund';
            dec_table();
        }
        else if(gethref == '#management_leave_tab')
        {

            if ($('' + gethref + '').hasClass('active'))
            {
                console.log('do nothing');
                which_is_active = 'management_leave_tab';
            }
            else if(management_leave_tab)
            {
                console.log('already loaded');
                which_is_active = 'management_leave_tab';

            }
            else if(management_leave_tab == false)
            {
                // calendar_fetch_data();
                // calendar_trigger();
                management_leave_tab = true;
                which_is_active = 'management_leave_tab';
            }
        }
    }
});

// $('.management_a_class').click(function () {
//     var gethref = $(this).attr('href');
//
//     console.log(gethref);
//
//     if(gethref == '#management_leave_monit')
//     {
//         if($('' + gethref + '').hasClass('active'))
//         {
//             console.log('do nothing');
//             which_is_active = 'management_leave_monit';
//         }
//         else if(management_leave_tab_bool == false)
//         {
//             calendar_fetch_data();
//             calendar_trigger();
//             management_leave_monit = true;
//             which_is_active = 'management_leave_monit';
//         }
//     }
// });

function manage_audit_table() {

    $('#audit-table thead th').each(function() {
        titleee[i] = $(this).text();
        i++;
        title = $(this).text();
        $(this).html(title+'<br><input type="text" placeholder="Search" style="position: relative; width: 100%">');
    });

    table = $('#audit-table').DataTable(
        {
            dom: 'Blfrtip',
            buttons:
                [
                    {
                        extend: 'colvis',
                        columnText: function (dt, idx, title)
                        {
                            return titleee[(idx)];
                        }
                    },
                    {
                        extend: 'excelHtml5',
                        exportOptions:
                            {
                                columns: ':visible',
                                format:
                                    {
                                        header:  function (dt, idx, title)
                                        {
                                            return titleee[(idx)];
                                        }
                                    }
                            }
                    },
                    {
                        extend: 'print',
                        exportOptions:
                            {
                                columns: ':visible',
                                format:
                                    {
                                        header:  function (dt, idx, title)
                                        {
                                            return titleee[(idx)];
                                        }
                                    }
                            }
                    },
                    {
                        extend: 'copy',
                        exportOptions:
                            {
                                columns: ':visible',
                                format:
                                    {
                                        header:  function (dt, idx, title)
                                        {
                                            return titleee[(idx)];
                                        }
                                    }
                            }
                    }
                ],
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "ajax": "/management-fetch-audit",
            "columns":
                [
                    {data: 'id', name: 'id'},
                    {data: 'name', name: 'name'},
                    {data: 'position', name: 'position'},
                    {data: 'branch', name: 'branch'},
                    {data: 'activities', name: 'activities'},
                    {data: 'date_occured', name: 'date_occured'},
                    {data: 'time_occured', name: 'time_occured'}
                ],
            "order": [ [0, 'desc'] ],
            "columnDefs":[{"className": "dt-center", "targets": "_all"}],
            "pageLength": 10,
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

    $('#audit-table_filter input').unbind();
    $('#audit-table_filter input').bind('keyup change',function (e) {

        if($(this).is(':focus'))
        {
            if (e.keyCode == 13) {
                table.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '') {
                    table.search($(this).val()).draw();
                }
            }
        }
    });

}

function fund_audit_table() {

    $('#fund-audit-table thead th').each(function() {
        titleee[i] = $(this).text();
        i++;
        title = $(this).text();
        $(this).html(title+'<br><input type="text" placeholder="Search" style="position: relative; width: 100%">');
    });

    table_fund = $('#fund-audit-table').DataTable(
        {
            dom: 'Blfrtip',
            buttons:
                [
                    {
                        extend: 'colvis',
                        columnText: function (dt, idx, title)
                        {
                            return titleee[(idx)];
                        }
                    },
                    {
                        extend: 'excelHtml5',
                        exportOptions:
                            {
                                columns: ':visible',
                                format:
                                    {
                                        header:  function (dt, idx, title)
                                        {
                                            return titleee[(idx)];
                                        }
                                    }
                            }
                    },
                    {
                        extend: 'print',
                        exportOptions:
                            {
                                columns: ':visible',
                                format:
                                    {
                                        header:  function (dt, idx, title)
                                        {
                                            return titleee[(idx)];
                                        }
                                    }
                            }
                    },
                    {
                        extend: 'copy',
                        exportOptions:
                            {
                                columns: ':visible',
                                format:
                                    {
                                        header:  function (dt, idx, title)
                                        {
                                            return titleee[(idx)];
                                        }
                                    }
                            }
                    }
                ],
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "ajax": "/management-fetch-fund-audit",
            "columns":
                [
                    {data: 'id', name: 'id'},
                    {data: 'fund_id', name: 'fund_id'},
                    {data: 'name', name: 'name'},
                    {data: 'position', name: 'position'},
                    {data: 'branch', name: 'branch'},
                    {data: 'activities', name: 'activities'},
                    {data: 'date_occured', name: 'date_occured'},
                    {data: 'time_occured', name: 'time_occured'}
                ],
            "order": [ [0, 'desc'] ],
            "columnDefs":[{"className": "dt-center", "targets": "_all"}],
            "pageLength": 10,
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

    $('#fund-audit-table_filter input').unbind();
    $('#fund-audit-table_filter input').bind('keyup change',function (e) {

        if($(this).is(':focus'))
        {
            if (e.keyCode == 13) {
                table_fund.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '') {
                    table_fund.search($(this).val()).draw();
                }
            }
        }
    });

}

function fund_audit_trailing_table() {

    $('#ci-expense-table thead th').each(function() {
        titleee[i] = $(this).text();
        i++;
        title = $(this).text();
        $(this).html(title);
    });

    table_expenses = $('#ci-expense-table').DataTable
    ({
        dom: 'Blfrtip',
        buttons:
            [
                {
                    extend: 'colvis',
                    columnText: function (dt, idx, title)
                    {
                        return titleee[(idx)];
                    }
                },
                {
                    extend: 'pdf',
                    title: 'Audits',
                    exportOptions:
                        {
                            columns: ':visible',
                            format:
                                {
                                    header:  function (dt, idx, title)
                                    {
                                        return titleee[(idx)];
                                    }
                                }
                        }
                },
                {
                    extend: 'excel',
                    title: 'Audits',
                    exportOptions:
                        {
                            columns: ':visible',
                            format:
                                {
                                    header:  function (dt, idx, title)
                                    {
                                        return titleee[(idx)];
                                    }
                                }
                        }
                },
                {
                    extend: 'print',
                    title: 'Audits',
                    exportOptions:
                        {
                            columns: ':visible',
                            format:
                                {
                                    header:  function (dt, idx, title)
                                    {
                                        return titleee[(idx)];
                                    }
                                }
                        }
                }
            ],
        // "responsive": true,audit-fund-table-report
        "processing": true,
        "serverSide": true,
        "ajax": "/management-ci-expenses-table",
        // {
        //     url: "/audit-fund-table-report",
        //     data: function (d)
        //     {
        //         d.min_date_endorsed = $('#min').val();
        //         d.max_date_endorsed = $('#max').val();
        //         d.search_option = search_where_option_fund;
        //     }
        // },
        "columns":
            [
                {data: 'id', name: 'id'},
                {data: 'ci_name', name: 'ci_name'},
                {data: 'endo_id', name: 'endo_id'},
                {data: 'account_name', name: 'account_name'},
                {data: 'declared', name: 'id'},
                {data: 'amount', name: 'amount'},
                {data: 'shell', name: 'shell'},
                {data: 'date_time', name: 'date_time'},
                {data: 'note', name: 'note'},
                {
                    data : function deta(data) {
                        // <a style="margin-bottom: 5px" name="'+data.ci_id+':'+data.endo_id_main+'" class="btn btn-xs btn-primary" id="btn_down_receipt"><i class="glyphicon glyphicon-cloud-download"></i> DOWNLOAD RECEIPT/S</a>

                        return '<a name="'+data.ci_id+':'+data.endo_id_main+'" class="btn btn-xs btn-block btn-info" data-toggle="modal" data-target="#modal-view-expenses-logs" id="btn_view_expense_logs"><i class="fa fa-list-alt"></i> VIEW LOGS</a>';
                    }
                }
            ],
        "order": [[0, 'desc']],
        "pageLength": 10,
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

    $('#ci-expense-table_filter input').unbind();
    $('#ci-expense-table_filter input').bind('keyup change',function (e) {

        if($(this).is(':focus'))
        {
            if (e.keyCode == 13) {
                table_expenses.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '') {
                    table_expenses.search($(this).val()).draw();
                }
            }
        }
    });


}

$('#clicktab1').click(function () {
    console.log('cclick 1');
    fund_audit_req = true;
    fund_audit_exp = false;

    // table_fund.ajax.reload(null, false);

});

$('#clicktab2').click(function () {
    console.log('cclick 2');
    fund_audit_exp = true;
    fund_audit_req = false;

    // table_expenses.ajax.reload(null, false);

});

$('#ci-expense-table').on('click','#btn_view_expense_logs',function () {

    var get_name = $(this).attr('name').split(':');
    var get_id = get_name[0];
    var get_endo_id = get_name[1];

    // console.log(get_id);

    $('#history_expenses').html
    (
        '<tr style="background-color: brown; color: white">' +
        '<th style=\'text-align: center;\'>NAME</th>' +
        '<th style=\'text-align: center;\'>POSITION</th>' +
        '<th style=\'text-align: center;\'>ACTIVITIES</th>' +
        '<th style=\'text-align: center;\'>DATE/TIME OCCURED</th>' +
        '</tr>'
    );

    $.ajax({
        url : 'management_get_expenses_logs',
        type : 'get',
        data : {
            'ci_id' : get_id,
            'endo_id' : get_endo_id
        },
        success : function (data) {

            console.log(data);

            for(ctrr = 0;ctrr <= (data[0].length)-1;ctrr++)
            {
                $('#history_expenses').append
                (
                    '<tr>' +
                    '<td style="padding: 3px;">' +data[1] + '</td>' +
                    '<td style="padding: 3px;">' +data[2] + '</td>' +
                    '<td style="padding: 3px;">' +data[0][ctrr].activity + '</td>' +
                    '<td style="padding: 3px;">' +data[0][ctrr].datetime + '</td>' +
                    '</tr>'
                );
            }

        },
        error : function () {

        }
    });

    console.log($(this).attr('name'));

});
$('#id_chart').click(function () {


    var dt = new Date();

    // console.log(dt.getFullYear());

    graphs(dt.getFullYear())

});

var getall = '';
getpolls();

function getpolls() {
    var getall = '';
    $('#poll_span').html(' ');

    $.ajax({
        type: 'get',
        url: '/management-manage-poll',
        data:
            {
                'id': '1'
            },
        success: function (data) {

            // console.log(data);
            var ctr = 0;
            for (ctr; ctr < data[0].length; ctr++) {
                var getquestions = '';
                var fordivtop = '';
                var getpoll = '';
                var fordivdown = '';
                getquestions +=
                    '                                                               <label class="list-group-item">\n' +
                    '                                                                    <a style="color: black;" href="#item-' + data[0][ctr].id + '" data-toggle="collapse">\n' +
                    '                                                                        <i class="fa fa-indent"></i> <p  style="width:90%;" > &nbsp&nbsp&nbsp'+ data[0][ctr].question + ' (' + data[0][ctr].maxCheck + ')</p>' +
                    '                                                                    </a>\n' +
                    '                                                                    <label style="margin-top: -40px; margin-bottom: -2px" class="switch pull-right">\n' +
                    '                                                                        <input id="slidershits-' + data[0][ctr].id + '" type="checkbox">\n' +
                    '                                                                        <span class="slider round"></span>\n' +
                    '                                                                    </label>\n' +
                    '                                                                </label>\n';

                for (var i = 0; i < data[1].length; i++) {
                    if (data[0][ctr].id === data[1][i].poll_id) {
                        getpoll += '                   <span class="list-group-item" data-toggle="collapse">\n' +
                            '<button id="btnDeleteOpt-'+data[1][i].id+'" type="button" style="height: 20px; width: 20px" class="btn-danger pull-left"> <p style="margin: -7px">-</p></button>'+
                            '                                                                            <i class=" "></i>' + data[1][i].name + '\n' +
                            '                                                                        </span>';
                    }
                }

                fordivtop += '  <div class="list-group collapse" id="item-' + data[0][ctr].id + '">';

                fordivdown += '                                                               <div class="input-group input-group-sm">\n' +
                    '                                                                        <input id="addPollinput-'+data[0][ctr].id+'" type="text" class="form-control">\n' +
                    '                                                                            <span class="input-group-btn">\n' +
                    '                                                                              <button id="addPoll-'+data[0][ctr].id+'"  type="button" class="btn btn-info btn-flat">Add Poll</button>\n' +
                    '                                                                            </span>\n' +
                    '                                                                      </div>\n' +
                    '                                                                </div>';

                getall += getquestions + fordivtop + getpoll + fordivdown;

            }


            $('#poll_span').html(getall);


            toggs();


            for(var ctraa=0; ctraa < data[1].length;ctraa++)
            {
                $('#btnDeleteOpt-' + data[1][ctraa].id + '').click(function () {

                    var getids = this.id.substring(13,this.id.length);

                    if (confirm('Are you sure you want to delete this poll?')) {

                        console.log("voted");

                        //gen-addpolls
                        $.ajax({
                            url: '/management-manage-poll-delete',
                            type: 'get',
                            data:
                                {
                                    'id': getids
                                },
                            success: function (data) {

                                console.log('success');
                                getpolls();

                            },
                            error: function (data) {
                                console.log('error');
                            }
                        });

                    } else {
                        console.log("You pressed Cancel!");
                    }

                });
            }
            for (var ctra = 0; ctra < data[0].length; ctra++) {
                $('#slidershits-' + data[0][ctra].id + '').click(function () {
                    // if()
                    var getcounter = this.id.substring(12, this.id.length);
                    // console.log(getcounter);

                    if (this.checked) {
                        // console.log('checked');

                        $.ajax({
                            type: 'get',
                            url: '/management-manage-poll-toggle',
                            data:
                                {
                                    'ida': getcounter,
                                    'non': 'true'
                                },
                            success: function (data) {

                                toggs();
                            },
                            error: function (data) {

                            }
                        });
                    }
                    else {
                        // console.log('unchecked');
                        $.ajax({
                            type: 'get',
                            url: '/management-manage-poll-toggle',
                            data:
                                {
                                    'ida': getcounter,
                                    'non': 'false'
                                },
                            success: function (data) {

                                toggs();
                            },
                            error: function (data) {

                            }
                        });
                    }
                });


                $('#addPoll-'+data[0][ctra].id+'').click(function () {

                    var id = this.id.substring(8,this.id.length);
                    // console.log(this.id.substring(8,this.id.length))
                    $.ajax({
                        type: 'get',
                        url: '/management-manage-add-poll',
                        data:
                            {
                                'id': id,
                                'options': $('#addPollinput-'+id+'').val()
                            },
                        success: function (data) {
                            getpolls();

                        },
                        error: function (data) {

                        }
                    });

                });

            }


        },
        error: function (data) {
            // console.log('error');
        }
    });





}

$('#Addquest').click(function () {

    var str_newPoll = $('#txtAddQuest').val();
    if ((jQuery.trim(str_newPoll)).length === 0) {
        alert("No text is detected.");
        // console.log($('#txtAddQuest').val());

    }
    else {
        var retVal = prompt("Please Enter Max vote for the poll : ");
        var getnum = parseInt(retVal);
        var getquestion = $('#txtAddQuest').val();
        if (isNaN(getnum) === false) {
            // console.log('number');

            $.ajax({
                type: 'get',
                url: '/management-manage-poll-question',
                data:
                    {
                        'question': getquestion,
                        'maxcheck': getnum
                    },
                success: function (data) {
                    $('#txtAddQuest').val(' ');
                    getpolls();
                },
                error: function (data) {
                }
            });
        }
        else {
            alert('error please try again.');
        }

    }

});

function toggs() {
    $.ajax({
        type: 'get',
        url: '/management-manage-poll',
        data:
            {
                'id': '1'
            },
        success: function (data) {
            // console.log(data[0]);

            for (var kk = 0; kk < data[0].length; kk++) {
                if (data[0][kk].isClosed == 0) {
                    $('#slidershits-' + data[0][kk].id + '').attr("checked", true);

                }
                else {
                    $('#slidershits-' + data[0][kk].id + '').attr("checked", false);

                }
            }
        },
        error: function (data) {

        }
    });

}


for(var x=2018;x<=2050;x++)
{
    year += '<option value="'+x+'">'+x+'</option>';
}

$('#selectYear').append
(
    '<select class="form-control select2" style="width: 100%;" id="chooseYear">\n' +
    year+
    '</select>'
);


$('#chooseYear').change(function ()
{
    var yr = $('#chooseYear').val();

    graphs(yr)
});

function graphs(yr) {

    $.ajax
    ({
        method: 'get',
        url: '/management-line-chart',
        data:
            {
                'yr': yr
            },
        success: function (data) {
            $('#lineChart').html('');

            jan = data[0];
            feb = data[1];
            mar = data[2];
            apr = data[3];
            may = data[4];
            jun = data[5];
            jul = data[6];
            aug = data[7];
            sep = data[8];
            oct = data[9];
            nov = data[10];
            dec = data[11];

            var datas =
                {
                    // A labels array that can contain any sort of values
                    labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                    // Our series array that contains series objects or in this case series data arrays
                    series:
                        [
                            [jan, feb, mar, apr, may, jun, jul, aug, sep, oct, nov, dec]
                        ]
                };


            // As options we currently only set a static size of 300x200 px. We can also omit this and use aspect ratio containers
            // as you saw in the previous example
            var options =
                {
                    width: 910,
                    height: 600,
                    // Don't draw the line chart points
                    showPoint: true,
                    // Disable line smoothing
                    lineSmooth: true,
                    low: 0,
                    showArea: true
                };

            // Create a new line chart object where as first parameter we pass in a selector
            // that is resolving to our chart container element. The Second parameter
            // is the actual data object. As a third parameter we pass in our custom options.
            new Chartist.Line
            (
                '#lineChart',
                datas,
                options
            );





            var dataa = {
                labels: ['TAT: '+data[13], 'LATE: '+data[12],'PROCESSING: '+data[14],'CANCELLED: '+data[15],'HOLD: '+data[16]],
                series: [data[13], data[12],data[14],data[15],data[16]]
            };

            var sum = function(a, b) { return a + b };
            new Chartist.Pie('#pieChart', dataa, {
                labelInterpolationFnc: function(value, idx) {
                    var percentage = Math.round(value / dataa.series.reduce(sum) * 100) + '%';
                    return dataa.labels[idx] + ' ' + percentage;
                },
                showLabel: false,
                plugins: [
                    Chartist.plugins.legend()
                ]
            });
        }
    });

}

$('#table_fund_req').on('click', '#BtnApproved', function (e)
{
    // console.log('approved : '+$(this).attr('href'))

    // var id = $(this).attr('href');
    $('#newFundReqAmount').val(0);

    var id = $(this).attr('href');
    $('#appFundReqNow').attr('href', id);
    $('#modal-modify-fund').modal('show');
    $('#newFundReqAmount').attr('disabled', true).val(atob($(this).attr('name')));
    $('#openInputFundAmt').attr('disabled', false);
    $('#closeInputFundAmt').hide();
    // $('#remarks_to_approve_manage').val('');

    // $.ajax
    // ({
    //     type : 'get',
    //     url : 'srao-get-fund-amount-to-approve',
    //     data :
    //         {
    //             'id' :  id
    //         },
    //     success : function(data)
    //     {
    //         $('#newFundReqAmount').val(data);
    //     }
    // });
});

$('#openInputFundAmt').click(function()
{
    $('#newFundReqAmount').attr('disabled', false);
    $('#closeInputFundAmt').fadeIn();
    $(this).attr('disabled', true);
});

$('#closeInputFundAmt').click(function()
{
    $('#newFundReqAmount').attr('disabled', true);
    $(this).fadeOut();
    $('#openInputFundAmt').attr('disabled', false);
});

$('#appFundReqNow').click(function()
{
    var btn = $(this);
    btn.attr('disabled', true);
    var id = $(this).attr('href');
    var newAmount = $('#newFundReqAmount').val();
    var textareabtn = $('#textarea-'+$(this).attr('href')+'');
    var remarks = $('#remarks_to_approve_manage').val();

    if(newAmount > 0)
    {
        var r = confirm("Approve the request?");
        if (r == true)
        {
            $.ajax
            ({
                method: 'get',
                url: '/management-approved-req',
                data:
                    {
                        'id' : id,
                        'newAmount' : newAmount,
                        'remarks' : remarks
                    },
                beforeSend: function () {

                    textareabtn.attr('disabled, disabled');
                    $('#BtnApproved').attr('disabled', 'disabled');

                },
                success: function (data)
                {
                    alert('Fund Successfully Approved!')

                    table_ci_fund.ajax.reload(null, false);
                    refreshApp = true;
                    btn.attr('disabled', false);
                },
                complete : function (data) {
                    textareabtn.removeAttr('disabled');
                    $('#BtnApproved').removeAttr('disabled');
                    $('#modal-modify-fund').modal('hide');
                    btn.attr('disabled', false);
                    $('#remarks_to_approve_manage').val('');

                },
                error : function (data) {
                    console.log('error')
                    btn.attr('disabled', false);
                }
            });
        }
        else
        {
            alert('Approving request cancelled.');
            btn.attr('disabled', false);
        }
    }
    else if(newAmount <= 0)
    {
        alert('Please specify amount!');
        btn.attr('disabled', false);
    }




});


$('.management_a_class').click(function () {

    var gethref = $(this).attr('href');
    // alert('test');
    console.log(gethref);

    if(gethref == '#man_dashboard_tab')
    {
        if( $(''+gethref+'').hasClass('active'))
        {
            console.log('do nothing');
            activeTab1 = 'man_dashboard_tab';

        }
        else if(man_dashboard_tab_bool)
        {
            console.log('already loaded');
            activeTab1 = 'man_dashboard_tab';

        }
        else if(man_dashboard_tab_bool == false)
        {
            man_dashboard_tab_bool = true;
            activeTab1 = 'man_dashboard_tab';

        }
    }
    else if(gethref == '#man_track_tab')
    {
        if( $(''+gethref+'').hasClass('active'))
        {
            console.log('do nothing');
            activeTab1 = 'search_active';

        }
        else if(search_acct)
        {
            console.log('already loaded');
            activeTab1 = 'search_active';

        }
        else if(search_acct == false)
        {
            search_acct = true;
            activeTab1 = 'search_active';
        }
    }
    else if(gethref == '#man_audit_tab')
    {
        if( $(''+gethref+'').hasClass('active'))
        {
            console.log('do nothing');
            activeTab1 = 'man_audit_tab';

        }
        else if(man_audit_tab_bool)
        {
            console.log('already loaded');
            activeTab1 = 'man_audit_tab';

        }
        else if(man_audit_tab_bool == false)
        {
            man_audit_tab_bool = true;
            activeTab1 = 'man_audit_tab';
            manage_audit_table();
        }
    }
    else if(gethref == '#man_fund_tab')
    {
        if( $(''+gethref+'').hasClass('active'))
        {
            console.log('do nothing');
            activeTab1 = 'man_fund_tab';

        }
        else if(man_fund_tab_bool)
        {
            console.log('already loaded');
            which_is_active = 'man_fund_tab';

        }
        else if(man_fund_tab_bool == false)
        {
            man_fund_tab_bool = true;
            activeTab1 = 'man_fund_tab';
            fund_audit_table();
            fund_audit_trailing_table();
        }
    }
    else if(gethref == '#man_report_tab')
    {
        if( $(''+gethref+'').hasClass('active'))
        {
            console.log('do nothing');
            activeTab1 = 'man_report_tab';

        }
        else if(man_report_tab_bool)
        {
            console.log('already loaded');
            activeTab1 = 'man_report_tab';

        }
        else if(man_report_tab_bool == false)
        {
            man_report_tab_bool = true;
            activeTab1 = 'man_report_tab';
        }
    }
    else if(gethref == '#man_ci_fund_req_tab')
    {
        console.log(man_ci_fund_req_tab_bool);

        if( $(''+gethref+'').hasClass('active'))
        {
            console.log('do nothing');
            activeTab1 = 'man_ci_fund_req_tab_bool';

        }
        else if(man_ci_fund_req_tab_bool)
        {
            console.log('already loaded');
            activeTab1 = 'man_ci_fund_req_tab_bool';
        }
        else if(man_ci_fund_req_tab_bool == false)
        {
            man_ci_fund_req_tab_bool = true;
            activeTab1 = 'man_ci_fund_req_tab_bool';
            fund_manage_init();
        }
    }
    else if(gethref == '#man_fa_monitoring_tab')
    {
        console.log(man_ci_fund_req_tab_bool);

        if( $(''+gethref+'').hasClass('active'))
        {
            console.log('do nothing');
            activeTab1 = 'man_fa_monitoring_tab';

        }
        else if(man_fa_mon_bool)
        {
            console.log('already loaded');
            activeTab1 = 'man_fa_monitoring_tab';
        }
        else if(man_fa_mon_bool == false)
        {
            man_fa_mon_bool = true;
            activeTab1 = 'man_fa_monitoring_tab';
            faTablesCi();
        }
    }
    else if(gethref == '#man_tele_track_tab')
    {
        console.log(man_ci_fund_req_tab_bool);

        if( $(''+gethref+'').hasClass('active'))
        {
            console.log('do nothing');
            activeTab1 = 'man_tele_track_tab';

        }
        else if(tele_ci_gen_table_bool)
        {
            console.log('already loaded');
            activeTab1 = 'man_tele_track_tab';
        }
        else if(tele_ci_gen_table_bool == false)
        {
            tele_ci_gen_table_bool = true;
            activeTab1 = 'man_tele_track_tab';
            get_general_mon_table();
        }
    }
    else if(gethref == '#management_leave_tab')
    {

        // alert('test leave tab');

        if ($('' + gethref + '').hasClass('active'))
        {
            console.log('do nothing');
            which_is_active = 'management_leave_tab';
        }
        else if(management_leave_tab)
        {
            console.log('already loaded');
            which_is_active = 'management_leave_tab';

        }
        else if(management_leave_tab == false)
        {

            calendar_fetch_data();
            calendar_trigger();

            management_leave_tab = true;
            which_is_active = 'management_leave_tab';
        }
    }
});



$('#table_fund_req').on('click', '#BtnDeclined', function (e)
{

    approvalId = $(this).attr('href');

    $('#remarksDis').val('');
    $('#modal-remarks-disapprove').modal('show');

});

$('#btnSubmitDis').click(function()
{
    var reasonRem = $('#remarksDis').val();

    if(reasonRem != '')
    {
        $.ajax
        ({
            method: 'get',
            url: '/management-declined-req',
            data:
                {
                    'id' : approvalId,
                    'rem' : reasonRem
                },
            beforeSend: function ()
            {
                $('#BtnDeclined').attr('disabled', 'disabled');
            },
            success: function (data)
            {
                if(data=='errorCancelled')
                {
                    alert('Dispatcher Cancelled the request');
                }
                else if(data=='success')
                {
                    alert('Fund Successfully Disapproved!')
                }
                table_ci_fund.ajax.reload(null, false);
                refreshDis = true;
            },
            complete : function () {
                $('#BtnDeclined').removeAttr('disabled');
                $('#modal-remarks-disapprove').modal('hide');
            },
            error : function () {
                console.log('error')
            }
        });
    }
    else
    {
        alert('Please indicate remarks!');
    }

});

$('#table_fund_req').on('click', '.btnViewReqRem', function()
{
    $('#req_rem_remarks-1').val('');

    $('#modal-req-rem-1').modal('show');

    $('#req_rem_remarks-1').val($(this).attr('name'));
});

$('#table_fund_req_approved').on('click', '.btnViewReqRem', function()
{
    $('#req_rem_remarks-1').val('');

    $('#modal-req-rem-1').modal('show');

    $('#req_rem_remarks-1').val($(this).attr('name'));
});

$('#table_fund_req_declined').on('click', '.btnViewReqRem', function()
{
    $('#req_rem_remarks-1').val('');

    $('#modal-req-rem-1').modal('show');

    $('#req_rem_remarks-1').val($(this).attr('name'));
});


function faTablesCi()
{
    $('#table-finance-expenses-report thead th').each(function()
    {
        coltittle3[col_count3] = $(this).text();
        col_count3++;
    });
    tableFundFa = $('#table-finance-expenses-report').DataTable({

        // "responsive": true,
        dom: 'Blfrtip',
        buttons:
            [
                {
                    extend: 'excel',
                    title : 'CI Liquidation Monitoring',
                    exportOptions:
                        {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7],
                            format:
                                {
                                    header: function (dt, idx) {
                                        return coltittle3[(idx)];
                                    }
                                }
                        },
                    customize: function ( xlsx )
                    {
                        var sheet = xlsx.xl.worksheets['sheet1.xml'];

                        var loop = 0;
                        $('row', sheet).each(function () {

                            $(this).find("c").attr('s', '25');
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
                        return coltittle3[(idx)];
                    }
                }
            ],
        "processing": true,
        "serverSide": true,
        "responsive": true,
        "ajax": "/finance-ci-fund-request-table-fa",
        "columns":
            [
                {data: 'id', name: 'fund_requests.id'},
                {data : 'archi', name : 'archipelagos.archipelago_name'},
                // {data: 'name_disp', name: 'dispatcher_id.name'},
                {data: 'name_ci', name: 'ci_id.name'},
                {
                    data : function dates(data)
                    {
                        if(data.tor == 'NORMAL REQUEST')
                        {
                            if(parseInt(atob(data.amount)) >= 2500)
                            {
                                return data.sao_date;
                            }
                            else if(parseInt(atob(data.amount)) < 2500)
                            {
                                return data.dispatcher_request_date;
                            }
                        }
                        else if(data.tor == 'EMERGENCY FUND')
                        {
                            if(data.sao_date == '')
                            {
                                return data.dispatcher_request_date;
                            }
                            else
                            {
                                return data.sao_date;
                            }
                        }
                    },
                    name: 'fund_requests.id'
                },
                {
                    data: function (data)
                    {
                        return atob(data.amount)
                    },
                    "name": 'fund_requests.fund_amount'
                },
                {data: 'liq', name: 'fund_requests.liquidated_amount'},
                {data: 'unliq', name: 'fund_requests.unliquidated_amount'},
                {data : 'finance_remarks' , name : 'fund_requests.finance_remarks'},
                {data : 'audit_remarks' , name : 'fund_requests.audit_remarks'},
                {
                    data : function actions(data)
                    {
                        var dateTime = '';


                        return '<button type = "button" class = "btn_view_ci_liq btn btn-sm btn-primary btn-block" name = '+ data.id +'><i class = "fa fa-fw fa-file-image-o"></i>View C.I Liquidation Info</button>' +
                            '<button class = "btn-xs btn-block btn-primary" name = "'+data.id+'" id = "check_remarks_requestor">View Remarks</button>';
                    },
                    "name": 'action', "orderable": false, "searchable": false
                },
                {data: 'dispatcher_request_date', name: 'fund_requests.dispatcher_request_date', visible : false},
                {data : 'sao_date' , name : 'fund_requests.sao_emergency_req_date_time', visible : false}

            ],
        "order": [[0, 'desc']],
        "pageLength": 25,
        "lengthMenu": [[2, 10, 25, 50, -1], ['2 rows', '10 rows', '25 rows', '50 rows', 'Show all']],
        "bSortClasses": false,
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

    $('#table-finance-expenses-report_filter input').unbind();
    $('#table-finance-expenses-report_filter input').bind('keyup change',function (e) {

        if($(this).is(':focus'))
        {
            if (e.keyCode == 13) {
                tableFundFa.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '') {
                    tableFundFa.search($(this).val()).draw();
                }
            }
        }
    });
}

forReviewStatusManageApproval();

function forReviewStatusManageApproval()
{
    $('#manage-acc-sup-for-approval thead th').each(function()
    {
        titleforAppSup[for_app_sup] = $(this).text();
        for_app_sup++;
    });
    titleMonitApproval = $('#manage-acc-sup-for-approval').DataTable({

        // "responsive": true,
        dom: 'Blfrtip',
        buttons:
            [
                {
                    extend: 'colvis',
                    text: 'Show/Hide Column',
                    columnText: function (dt, idx, title)
                    {
                        return titleforAppSup[(idx)];
                    }
                }
            ],
        "processing": true,
        "serverSide": true,
        "responsive": true,
        "ajax": "/management_sup_approval",
        "columns":
            [
                {data: 'id', name: 'admin_accredited_supplier_management_app.id'},
                {data: 'dt', name: 'admin_accredited_supplier_management_app.created_at'},
                {data: 'pass_name', name: 'users.name'},
                {data: 'categ', name: 'admin_accredited_supplier_management_app.categ_sup'},
                {data: 'equi', name: 'admin_accredited_supplier_management_app.eq_desc_sup'},
                {data: 'rem', name: 'admin_accredited_supplier_management_app.sup_rem'},
                {
                    data : function act(data)
                    {
                        return '<button class = "btn btn-block btn-primary btnApprovalOfSupplier" name ="'+btoa(data.id)+'" stat = "app"><i class ="fa fa-fw fa-check-square-o"></i> Approval</button>'
                    },
                    name : 'admin_accredited_supplier_management_app.id',
                    "orderable" : false,
                    "searchable" : false
                }
            ],
        "order": [[0, 'desc']],
        "pageLength": 10,
        "lengthMenu": [[2, 10, 25, 50, -1], ['2 rows', '10 rows', '25 rows', '50 rows', 'Show all']],
        "bSortClasses": false,
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


    $('#manage-acc-sup-for-approval_filter input').unbind();
    $('#manage-acc-sup-for-approval_filter input').bind('keyup change',function (e) {

        if($(this).is(':focus'))
        {
            if (e.keyCode == 13) {
                titleMonitApproval.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '') {
                    titleMonitApproval.search($(this).val()).draw();
                }
            }
        }
    });
}

$('#manage-acc-sup-for-approval').on('click', '.btnApprovalOfSupplier', function()
{

    var id = atob($(this).attr('name'));
    var stat = $(this).attr('stat');

    $('#btnSendNowApprovalSup').attr('idToApprove', btoa(id));

    viewApprovalSupMod(id, stat)

});

$('.hoverSup').mouseover(function()
{
    var lookID = $(this).attr('value');

    $('.hoverSup').each(function()
    {
        if($(this).attr('value') == lookID)
        {
            $('#hoverSup'+lookID+'-1').css('text-decoration', 'underline');
            $('#hoverSup'+lookID+'-2').css('text-decoration', 'underline');
            $('#hoverSup'+lookID+'-3').css('text-decoration', 'underline');

            $(this).css("background-color", "yellow");
        }
    });
});

$('.hoverSup').mouseout(function()
{
    var lookID = $(this).attr('value');
    $('.hoverSup').each(function()
    {
        if($(this).attr('value') == lookID)
        {
            $('#hoverSup'+lookID+'-1').css('text-decoration', 'none');
            $('#hoverSup'+lookID+'-2').css('text-decoration', 'none');
            $('#hoverSup'+lookID+'-3').css('text-decoration', 'none');

            $(this).css("background-color", "white");
        }
    });
});

$('#selectSup1').click(function()
{
    if($(this).hasClass('btn-primary'))
    {
        $(this).removeClass('btn-primary');
        $(this).addClass('btn-success');
        $(this).html('Selected');

        if($('#selectSup2').hasClass('btn-success'))
        {
            $(this).removeClass('btn-success');
            $(this).addClass('btn-primary');
            $('#selectSup2').html('Select');
        }

        if($('#selectSup3').hasClass('btn-success'))
        {
            $(this).removeClass('btn-success');
            $(this).addClass('btn-primary');
            $('#selectSup3').html('Select');
        }

        $('#selectSup2').attr('disabled', true);
        $('#selectSup3').attr('disabled', true);

        $('#showBtnToApproveSupplier').show();
        $('#btnSendNowApprovalSup').attr('name', btoa($(this).attr('name')));

    }
    else if($(this).hasClass('btn-success'))
    {
        $(this).removeClass('btn-success');
        $(this).addClass('btn-primary');
        $(this).html('Select');
        $('#selectSup2').attr('disabled', false);
        $('#selectSup3').attr('disabled', false);

        $('#showBtnToApproveSupplier').hide();
        $('#btnSendNowApprovalSup').attr('name', '');

    }
});

$('#selectSup2').click(function()
{
    if($(this).hasClass('btn-primary'))
    {
        $(this).removeClass('btn-primary');
        $(this).addClass('btn-success');
        $(this).html('Selected');


        if($('#selectSup1').hasClass('btn-success'))
        {
            $(this).removeClass('btn-success');
            $(this).addClass('btn-primary');
            $('#selectSup1').html('Select');
        }

        if($('#selectSup3').hasClass('btn-success'))
        {
            $(this).removeClass('btn-success');
            $(this).addClass('btn-primary');
            $('#selectSup3').html('Select');
        }

        $('#selectSup1').attr('disabled', true);
        $('#selectSup3').attr('disabled', true);

        $('#showBtnToApproveSupplier').show();
        $('#btnSendNowApprovalSup').attr('name', btoa($(this).attr('name')));
    }
    else if($(this).hasClass('btn-success'))
    {
        $(this).removeClass('btn-success');
        $(this).addClass('btn-primary');
        $(this).html('Select');
        $('#selectSup1').attr('disabled', false);
        $('#selectSup3').attr('disabled', false);

        $('#showBtnToApproveSupplier').hide();
        $('#btnSendNowApprovalSup').attr('name', '');
    }
});

$('#selectSup3').click(function()
{
    if($(this).hasClass('btn-primary'))
    {
        $(this).removeClass('btn-primary');
        $(this).addClass('btn-success');
        $(this).html('Selected');


        if($('#selectSup1').hasClass('btn-success'))
        {
            $(this).removeClass('btn-success');
            $(this).addClass('btn-primary');
            $('#selectSup1').html('Select');
        }

        if($('#selectSup2').hasClass('btn-success'))
        {
            $(this).removeClass('btn-success');
            $(this).addClass('btn-primary');
            $('#selectSup2').html('Select');
        }

        $('#selectSup1').attr('disabled', true);
        $('#selectSup2').attr('disabled', true);

        $('#showBtnToApproveSupplier').show();
        $('#btnSendNowApprovalSup').attr('name', btoa($(this).attr('name')));
    }
    else if($(this).hasClass('btn-success'))
    {
        $(this).removeClass('btn-success');
        $(this).addClass('btn-primary');
        $(this).html('Select');
        $('#selectSup1').attr('disabled', false);
        $('#selectSup2').attr('disabled', false);

        $('#showBtnToApproveSupplier').hide();
        $('#btnSendNowApprovalSup').attr('name', '');
    }
});

$('#btnSendNowApprovalSup').click(function()
{
    var btn = $(this);
    var idReq = atob(btn.attr('idToApprove'));
    var idSelected = atob(btn.attr('name'));
    var rem = $('#genRemarksSuppApprover').val();

    if(rem != '')
    {
        if (confirm('Are you sure to approve the selected supplier?'))
        {
            btn.attr('disabled', true);
            $('#loadingSpanSendApprovalSup').show();

            $.ajax
            ({
                type: 'get',
                url: 'management-approve-selected-supplier',
                data:
                    {
                        'idReq': idReq,
                        'idSelected': idSelected,
                        'rem': rem
                    },
                success: function () {
                    $('#loadingSpanSendApprovalSup').hide();
                    btn.attr('disabled', false);
                    alert('Successfully Approved!');

                    $('#modal-show-supplier-to-approve').modal('hide');
                    titleMonitApproval.ajax.reload(null, false);
                    $('#genRemarksSuppApprover').val('');

                    if ($('.selectSups').hasClass('btn-success')) {
                        $(this).removeClass('btn-success');
                        $(this).addClass('btn-primary');
                        $(this).html('Select');
                        $(this).attr('disabled', false);

                        $('#showBtnToApproveSupplier').hide();
                        $('#btnSendNowApprovalSup').attr('name', '');
                        checkmonitApp = true;
                    }


                }
            });
        }
        else
        {

        }
    }
    else
    {
        alert('Please indicate remarks.');
        btn.attr('disabled', false);
    }
});


function forReviewStatusManageApproval2()
{
    $('#manage-monitoring-approved-req thead th').each(function()
    {
        titleforAppSup2[for_app_sup_2] = $(this).text();
        for_app_sup_2++;
    });
    titleMonitApproval2 = $('#manage-monitoring-approved-req').DataTable({

        // "responsive": true,
        dom: 'Blfrtip',
        buttons:
            [
                {
                    extend: 'colvis',
                    text: 'Show/Hide Column',
                    columnText: function (dt, idx, title)
                    {
                        return titleforAppSup2[(idx)];
                    }
                }
            ],
        "processing": true,
        "serverSide": true,
        "responsive": true,
        "ajax": "/management_sup_approval_monit",
        "columns":
            [
                {data: 'id', name: 'admin_accredited_supplier_management_app.id'},
                {data: 'dt', name: 'admin_accredited_supplier_management_app.created_at'},
                {data: 'pass_name', name: 'users.name'},
                {data: 'categ', name: 'admin_accredited_supplier_management_app.categ_sup'},
                {data: 'equi', name: 'admin_accredited_supplier_management_app.eq_desc_sup'},
                {data: 'rem', name: 'admin_accredited_supplier_management_app.sup_rem'},
                {
                    data : function act(data)
                    {
                        return '<button class = "btn btn-block btn-primary btnViewInfoApproval" name ="'+btoa(data.id)+'" stat = "view"><i class ="fa fa-fw fa-info"></i> View Info</button>'
                    },
                    name : 'admin_accredited_supplier_management_app.id',
                    "orderable" : false,
                    "searchable" : false
                }

            ],
        "order": [[0, 'desc']],
        "pageLength": 10,
        "lengthMenu": [[2, 10, 25, 50, -1], ['2 rows', '10 rows', '25 rows', '50 rows', 'Show all']],
        "bSortClasses": false,
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


    $('#manage-monitoring-approved-req_filter input').unbind();
    $('#manage-monitoring-approved-req_filter input').bind('keyup change',function (e) {

        if($(this).is(':focus'))
        {
            if (e.keyCode == 13) {
                titleMonitApproval2.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '') {
                    titleMonitApproval2.search($(this).val()).draw();
                }
            }
        }
    });
}

$('#manage-monitoring-approved-req').on('click', '.btnViewInfoApproval', function()
{
    var id = atob($(this).attr('name'));
    var stat = $(this).attr('stat');

    viewApprovalSupMod(id, stat)

});


function viewApprovalSupMod(id, type)
{
    $.ajax
    ({
        type : 'get',
        url : 'management_get_supplier_to_compare',
        data :
            {
                'id' : id
            },
        success : function(data)
        {
            console.log(data);

            $('#categoryToPassView').val(data[3][0].categ_sup);
            $('#equipmentToBuyView').val(data[3][0].eq_desc_sup);
            $('#remarksComparisonView').val(data[3][0].sup_rem)

            if(data[0].length > 0)
            {
                for(var i = 0; i < data[0].length; i++)
                {
                    var colorPanel;

                    if(data[0][i].approval_status == 'Management Denied')
                    {
                        colorPanel = 'background-color : #ffb3b3';
                    }
                    else if(data[0][i].approval_status == 'Management Approved')
                    {
                        colorPanel = 'background-color : #b3ffb3';
                    }

                    $('#colorMeSup'+i+'').attr('style', ''+colorPanel+'');

                    $('.supName-'+i+'-1').html(data[0][i].supp_name);
                    $('.conNum-'+i+'-2').html(data[0][i].con_num);
                    $('.supAddview-'+i+'-3').html(data[0][i].supp_address);
                    $('.conPer-'+i+'-4').html(data[0][i].contact_person);
                    $('.supEmail-'+i+'-5').html(data[0][i].sup_email);
                    $('.emaiSubj-'+i+'-6').html(data[0][i].email_subj);
                    $('.dateBi-'+i+'-7').html(data[0][i].date_bi);
                    $('.birRegistered-'+i+'-8').html(data[0][i].sup_bir);
                    $('.tinNum-'+i+'-9').html(data[0][i].sup_tin);
                    $('.torSup-'+i+'-10').html(data[0][i].sup_tor);
                    $('.categSup-'+i+'-11').html(data[0][i].sup_categorization);
                    $('.descSup-'+i+'-12').html(data[0][i].sup_descrip);
                    // $('#termsPayment-'+i+'-13').html();
                    $('.proposalVal-'+i+'-14').html(data[0][i].sup_proposal);
                    $('.resultsSup-'+i+'-15').html(data[0][i].sup_results);
                    $('.othersInfo-'+i+'-17').html(data[0][i].other_info_sup);
                    $('#selectSup'+(i+1)+'').attr('name', data[0][i].id);
                }
            }

            if(data[1].length > 0)
            {
                for(var j = 0; j < data[1].length; j++)
                {
                    var termsContent = '';

                    for(g = 0; g < data[1][j].length; g++)
                    {
                        termsContent += (g+1) + '. ' + data[1][j][g].supp_term + '<br>';
                    }

                    $('.termsPayment-'+j+'-13').html(termsContent)
                }
            }

            if(data[2].length > 0)
            {
                for(var t = 0; t < data[2].length; t++)
                {
                    var tableHead = '';

                    if(data[2][t].length > 0)
                    {
                        for(var y = 0; y < data[2][t].length; y++)
                        {
                            tableHead += (y+1) + '. ' + '<a target="_blank" href="view-accredited-sup-file?id='+btoa(data[2][t][y].supplier_id)+'&n='+btoa(data[2][t][y].file_name)+'" name="'+data[2][t][y].supplier_id+'" title="Click the file name to download">'+data[2][t][y].file_name+'</a><br>'
                        }
                    }
                    else
                    {
                        tableHead = 'No Uploaded File.'
                    }

                    $('.filesSup-'+t+'-16').html(tableHead);
                }
            }

            if(type == 'app')
            {
                $('.showIfApprover').show();
                $('.showIfViewer').hide();
            }
            else if(type == 'view')
            {
                $('.showIfApprover').hide();
                $('.showIfViewer').show();
                $('#showBtnToApproveSupplier').hide();

                $('#genRemarksSuppApprover').val('');

                if ($('.selectSups').hasClass('btn-success'))
                {
                    $(this).removeClass('btn-success');
                    $(this).addClass('btn-primary');
                    $(this).html('Select');
                    $(this).attr('disabled', false);
                }

                $('#btnSendNowApprovalSup').attr('name', '');

                $('#genRemarksSuppApproverView').val(data[3][0].approver_remarks);
            }


            $('#modal-show-supplier-to-approve').modal({backdrop : "static"});
        }
    });
}

var sup_monitManage_tabs_1_bool = true;
var sup_monitManage_tabs_2_bool = false;

$('.manage_sup_approval_class').click(function() {
    var gethref = $(this).attr('href');
    console.log(gethref);

    if (gethref == '#tabStatSup_1') {
        if ($('' + gethref + '').hasClass('active')) {
            console.log('do nothing');
        }
        else if (sup_monitManage_tabs_1_bool) {
            if(checkSupOpen1 == true)
            {
                titleAccSupForComp.ajax.reload(null, false);
                checkSupOpen1 = false;
            }
            else
            {
                console.log('already loaded');
            }
        }
        else if (sup_monitManage_tabs_1_bool == false) {
            sup_monitManage_tabs_1_bool = true;
        }
    }
    else  if (gethref == '#tabStatSup_2') {
        if ($('' + gethref + '').hasClass('active')) {
            console.log('do nothing');
        }
        else if (sup_monitManage_tabs_2_bool) {

            if(checkmonitApp == true)
            {
                titleMonitApproval2.ajax.reload(null, false);
                checkmonitApp = false;
            }
            else
            {
                console.log('already loaded');
            }
        }
        else if (sup_monitManage_tabs_2_bool == false) {
            sup_monitManage_tabs_2_bool = true;
            forReviewStatusManageApproval2();
        }
    }
});

$('#ci_expense_range_start1').datepicker({
    dateFormat: 'yy-mm-dd',
    orientation: "bottom"
});

$('#ci_expense_range_start1').change(function()
{
    // var $val = $(this).val();
    // var split = $val.split('/');
    // var goodVal = split[2] + '-' + split[0] + '-' + split[1];
    //
    // console.log(goodVal);
    // $('#ci_expense_range_start').val(goodVal);
    // expenseStart = goodVal;

    tableFundFa.draw();
});

$('#ci_expense_range_end1').datepicker({
    dateFormat: 'yy-mm-dd',
    orientation: "bottom"
});

$('#ci_expense_range_end1').change(function()
{
    // var $val = $(this).val();
    // var split = $val.split('/');
    // var goodVal = split[2] + '-' + split[0] + '-' + split[1];
    //
    // console.log(goodVal);
    // $('#ci_expense_range_end').val(goodVal);
    // expenseEnd = goodVal;

    tableFundFa.draw();
});

$('.ci_expense_range').click(function()
{
    if($(this).val() == 'All')
    {
        $('#ci_expense_range_start1').val('');
        $('#ci_expense_range_end1').val('');
        $('.date_range_ci_exp').hide();
    }
    else
    {
        var SetDate = new Date();
        var FullDate = (SetDate.getMonth() + 1) + '/' + SetDate.getDate() + '/' + SetDate.getFullYear();
        $('#ci_expense_range_start1').val(FullDate);
        // $('#ci_expense_range_start').val(SetDate.getFullYear() + '-' + SetDate.getMonth() + 1 + '-' + SetDate.getDate());
        // $('#ci_expense_range_end').val(SetDate.getFullYear() + '-' + SetDate.getMonth() + 1 + '-' + SetDate.getDate());
        $('#ci_expense_range_end1').val(FullDate);
        $('.date_range_ci_exp').show();
    }
    tableFundFa.draw();
});

$('#generate_attendance_click').click(function()
{
    if($('#date_to_generate').val() != '')
    {
        if(confirm('Are you sure to generate the employee\'s attendance?'))
        {
            window.open('human-resources-generate-employee-attendance?added_date=' + $('#date_to_generate').val());
        }
    }
    else
    {
        alert('Specify the date to generate');
    }

});

$('#date_to_generate').change(function()
{
    console.log($(this).val());
});


function get_general_mon_table()
{
    $('#management_tele_ci_gen_mon_table thead th').each(function()
    {
        tele_ci_gen_table_array[tele_ci_gen_table_title] = $(this).text();
        tele_ci_gen_table_title++;
        var title = $(this).text();
        $(this).html(title+'<br><input type="text" placeholder="Search" style="position: relative; width: 100%">');
    });

    tele_ci_gen_table = $('#management_tele_ci_gen_mon_table').DataTable
    ({
        "responsive": true,
        "processing": true,
        "serverSide": true,
        "ajax":
            {
                url: "management_get_general_mon_table_ccbank",
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
                                        return tele_ci_gen_table_array[(idx)];
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
            ],
        "columns":
            [
                {data: 'endorse_id', name: 'bi_endorsements.id'},
                {data: 'tor', name: 'bi_endorsements.type_of_endorsement_bank'},
                {
                    data : function d_e(data)
                    {
                        var date_time = data.date_time_endorsed;

                        var split = date_time.split(' ');

                        return split[0];
                    },
                    name : 'bi_endorsements.created_at'
                },
                {
                    data : function t_e(data)
                    {
                        var date_time = data.date_time_endorsed;

                        var split = date_time.split(' ');

                        var time = split[1].split(':');

                        var finall = time[0] + ':' + time[1];

                        return finall;
                    },
                    name : 'bi_endorsements.created_at'
                },
                {data: 'project', name: 'bi_endorsements.project'},
                {data: 'account_name', name: 'bi_endorsements.account_name'},
                {data: 'assigned_tele', name: 'bi_endorsements.id', orderable: 'false', searchable: 'false'},
                {data: 'poc', name: 'bi_endorsements.endorser_poc'},
                {data: 'attachments', name: 'bi_endorsements.attach_1'},
                {data: 'due', name: 'bi_endorsements.id', orderable: 'false', searchable: 'false'},
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
                    data : function action(data) {
                        var buttons = '<a id="'+data.endorse_id+'" class="btn_view_information_bi btn btn-xs btn-info btn-block" data-toggle="modal" data-target="" ><i class="glyphicon glyphicon-film"></i> View Information</a>';

                        if(data.status == 10)
                        {
                            return '<a href="bi-client-dl-report-file?id='+btoa(data.endorse_id)+'" class="btn btn-success btn-block btn-xs" target="_blank"><i class="glyphicon glyphicon-download-alt"></i> Download Finished Report</a>' + buttons;
                        }
                        else if(data.status == 3 || data.status == 24)
                        {
                            return '<a href="cc-sao-tele-dl-report?id='+btoa(data.endorse_id)+'" class="btn btn-success btn-block btn-xs" target="_blank"><i class="glyphicon glyphicon-download-alt"></i> Download Televerifier Report</a>' + buttons;
                        }
                        else
                        {
                            return buttons;
                        }
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

    $('#management_tele_ci_gen_mon_table_filter input').unbind();
    $('#management_tele_ci_gen_mon_table_filter input').bind('keyup change',function (e) {

        if($(this).is(':focus'))
        {
            if (e.keyCode == 13) {
                tele_ci_gen_table.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '') {
                    tele_ci_gen_table.search($(this).val()).draw();
                }
            }
        }
    });
}

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

    tele_ci_gen_table.draw();
});

$('.gen_mon_date_range_dates').change(function()
{
    tele_ci_gen_table.draw();
});

$('.cc_accnt_tracker').click(function ()
{
    var gethref = $(this).attr('href');
    if (gethref == '#cc_gen_tab1') {

        if ($('' + gethref + '').hasClass('active')) {
            console.log('do nothing');
            activeSide = 'cc_gen_tab1';
        }
        else if (tele_ci_gen_table_bool) {
            console.log('already loaded');
            activeSide = 'cc_gen_tab1';
        }
        else if (!tele_ci_gen_table_bool) {
            tele_ci_gen_table_bool = true;
            activeSide = 'cc_gen_tab1';
            get_general_mon_table();
        }
    }
    else if (gethref == '#cc_gen_tab2') {

        if ($('' + gethref + '').hasClass('active')) {
            console.log('do nothing');
            activeSide = 'tele_ci_gen_table_bool2';
        }
        else if (tele_ci_gen_table_bool2) {
            console.log('already loaded');
            activeSide = 'tele_ci_gen_table_bool2';
        }
        else if (!tele_ci_gen_table_bool2) {
            tele_ci_gen_table_bool2 = true;
            activeSide = 'tele_ci_gen_table_bool2';
            get_general_mon_table_2();
        }
    }
});

function get_general_mon_table_2()
{
    $('#management_tele_ci_gen_mon_table_cc thead th').each(function()
    {
        tele_ci_gen_table_array2[tele_ci_gen_table_title2] = $(this).text();
        tele_ci_gen_table_title2++;
        var title = $(this).text();
        $(this).html(title+'<br><input type="text" placeholder="Search" style="position: relative; width: 100%">');
    });

    tele_ci_gen_table2 = $('#management_tele_ci_gen_mon_table_cc').DataTable
    ({
        "responsive": true,
        "processing": true,
        "serverSide": true,
        "ajax":
            {
                url: "management_get_general_mon_table_cc",
                data: function (d)
                {

                    d.min_date_endorsed = $('#gen_mon_min_cc').val();
                    d.max_date_endorsed = $('#gen_mon_max_cc').val();
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
                                        return tele_ci_gen_table_array2[(idx)];
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
            ],
        "columns":
            [
                {data: 'endorse_id', name: 'bi_endorsements.id'},
                {data: 'site', name: 'bi_endorsements.bi_account_name'},
                {
                    data : function d_e(data)
                    {
                        var date_time = data.date_time_endorsed;

                        var split = date_time.split(' ');

                        var time = split[1].split(':');

                        return split[0];
                    },
                    name : 'bi_endorsements.created_at'
                },
                {
                    data : function t_e(data)
                    {
                        var date_time = data.date_time_endorsed;

                        var split = date_time.split(' ');

                        var time = split[1].split(':');

                        var final = time[0] + ':' + time[1];

                        return final;
                    },
                    name : 'bi_endorsements.created_at'
                },
                {data: 'project', name: 'bi_endorsements.project'},
                {data: 'account_name', name: 'bi_endorsements.account_name'},
                {data: 'package', name: 'bi_endorsements.package'},
                {data: 'assigned_tele', name: 'bi_endorsements.id', orderable: 'false', searchable: 'false'},
                {data: 'poc', name: 'bi_endorsements.endorser_poc'},
                {data: 'attachments', name: 'bi_endorsements.attach_1'},
                {data: 'due', name: 'bi_endorsements.id', orderable: 'false', searchable: 'false'},
                {
                    data : function action(data) {
                        var buttons = '<a id="'+data.endorse_id+'" class="btn_view_information_bi btn btn-xs btn-info btn-block" data-toggle="modal" data-target="" ><i class="glyphicon glyphicon-film"></i> View Information</a>';

                        if(data.status == 10)
                        {
                            return '<a href="bi-client-dl-report-file?id='+btoa(data.endorse_id)+'" class="btn btn-success btn-block btn-xs" target="_blank"><i class="glyphicon glyphicon-download-alt"></i> Download Finished Report</a>' + buttons;
                        }
                        else if(data.status == 3 || data.status == 24)
                        {
                            return '<a href="cc-sao-tele-dl-report?id='+btoa(data.endorse_id)+'" class="btn btn-success btn-block btn-xs" target="_blank"><i class="glyphicon glyphicon-download-alt"></i> Download Televerifier Report</a>' + buttons;
                        }
                        else
                        {
                            return buttons;
                        }
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

    $('#management_tele_ci_gen_mon_table_cc_filter input').unbind();
    $('#management_tele_ci_gen_mon_table_cc_filter input').bind('keyup change',function (e) {

        if($(this).is(':focus'))
        {
            if (e.keyCode == 13) {
                tele_ci_gen_table2.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '') {
                    tele_ci_gen_table2.search($(this).val()).draw();
                }
            }
        }
    });
}

$('.gen_mon_date_range_click_cc').click(function()
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
        $('#gen_mon_date_pick_holder_cc').hide();
        $('#gen_mon_max_cc').val('6000-01-01');
        $('#gen_mon_min_cc').val('2015-01-01');
    }
    else
    {
        $('#gen_mon_date_pick_holder_cc').show();
        $('#gen_mon_min_cc').val(newdate);
        $('#gen_mon_max_cc').val(newdate);
    }

    tele_ci_gen_table2.draw();
});

$('.gen_mon_date_range_dates_cc').change(function()
{
    tele_ci_gen_table2.draw();
});



get_user_archipelago();

function get_user_archipelago()
{
    $('#table_user_archipelago_table thead tr th').each(function()
    {
        $(this).css('background-color', 'black');
        $(this).css('color', 'white');
    });

    table_user_archipelogo = $('#table_user_archipelago').DataTable
    ({
        "responsive" : true,
        "processing" : true,
        "serverSide" : true,
        "ajax":
            {
                url: "get_user_archipelago",
                data: function (d)
                {
                    d.arch = $('#filter_archipelagos_id').find(':selected').val();
                }
            },
        "columns":
            [
                {data: 'emp_name', name: 'users.name'},
                {data: 'province_name', name: 'provinces.name'},
                {
                    data:function work_sched(data)
                    {

                        var workEnd = data.work_end;
                        var splitAmPm,getHour,FinalOutput;

                        if(workEnd != null || workEnd != '')
                        {
                            splitAmPm = workEnd.split(' ');
                            FinalOutput = splitAmPm;
                        }
                        else
                        {
                            FinalOutput = 'wala laman';
                        }

                        if(workEnd != null || workEnd != '' || workEnd != 'NaN:NaN PM')
                        {
                            splitAmPm = workEnd.split(' ');
                            FinalOutput = (parseInt(splitAmPm[0].split(':')[0]) + 12) + ':' + splitAmPm[0].split(':')[1];
                        }

                        return  '<div class="input-group"><input type="time" class="form-control  change_sched_input work_start_attend" value="'+data.work_start.split(' ')[0]+'" name="'+data.id+'" id="'+data.id+'" disabled="true" style="width:47%; margin-right: 5px; margin-top: 5px">'+
                            '<input type="time" class="form-control change_sched_input work_end_attend" value="'+FinalOutput+'" name="'+data.id+'" id="'+data.id+'"  disabled="true" style="max-width:47%; margin-right: 5px; margin-top: 5px"></div>'
                    },
                    'name' : 'name',
                    searchable : false,
                    orderable : false

                },

                {
                    data:function action(data)
                    {
                        return'' +
                            '<button class="btn btn-block btn-success btn-sm save_schedule_time" disabled="true" name="'+data.id+'" href="'+btoa(data.emp_name)+'">Save</button>'+
                            '<button class="btn btn-block btn-info btn-sm logs_schedule_time" id="'+btoa(data.id)+'" data-target="#modal_users_attendance_logs" name="'+data.id+'" data-toggle="modal" href="'+btoa(data.emp_name)+'"><i class="glyphicon glyphicon-film">Logs</button>'
                    },
                    'name' : 'name',
                    searchable : true,
                    orderable : false
                }
            ],
        "order" :[[0, 'desc']],
        "pageLength" : 5,
        "lengthMenu" : [[2, 10, 25, 50, -1], ['2 rows', '10 rows', '25 rows', '50 rows', 'Show all']],
        initComplete: function () {

            $('#table_user_archipelago').on('dblclick', '.change_sched_input', function () {
                var identifier = $(this).attr('name');

                if ($(this).is(":disabled"))
                {
                    $('.change_sched_input').each(function () {
                        if ($(this).attr('name') == identifier) {
                            $(this).attr("disabled", false);
                        }
                    });

                    $('.save_schedule_time').each(function()
                    {
                        if ($(this).attr('name') == identifier) {
                            $(this).attr("disabled", false);
                        }
                    });

                }
                else
                {
                    $('.save_schedule_time').each(function () {
                        if ($(this).attr('name') == identifier) {
                            $(this).attr("disabled", true);
                        }
                    });

                    $('.save_schedule_time').each(function()
                    {
                        if ($(this).attr('name') == identifier) {
                            $(this).attr("disabled", true);
                        }
                    });

                }
            });

            $('#table_user_archipelago').on('click', '.save_schedule_time', function ()
            {
                var inputted_start = '';
                var inputted_end = '';
                var user_id = $(this).attr('name');
                var validatorIfNull = false;

                $('.change_sched_input').each(function () {
                    if ($(this).attr('name') == user_id) {
                        if($(this).val() != '')
                        {
                            validatorIfNull = true;
                        }
                        else
                        {
                            alert('Fill-up required fields.');
                            validatorIfNull = false;
                            return false;
                        }
                    }
                });

                if(validatorIfNull)
                {
                    if(confirm('Are you sure to update ' + atob($(this).attr('href')) + ' schedule?'))
                    {

                        $('.change_sched_input ').each(function()
                        {
                            if(!$(this).is(":disabled"))
                            {
                                if($(this).hasClass('work_start_attend'))
                                {
                                    inputted_start = $(this).val();
                                    $('.save_schedule_time').prop('disabled', true);
                                    $('.change_sched_input').prop('disabled', true);

                                }
                                else
                                {
                                    inputted_end= $(this).val();
                                }
                            }
                        });
                    }
                    else
                    {
                        console.log('do nothing');
                    }
                    $.ajax({
                        url: 'get_management_saveTime',
                        type: 'get',
                        data:{
                            'id' : $(this).attr('name'),
                            'work_start' : $('.work_start_attend').val(),
                            'work_end' : $('.work_end_attend').val()
                        },
                        success: function (data) {
                            alert ('Employee Schedule Successfully Updated');

                        }
                    });

                }
            });
        }
    });

    $('#table_user_archipelago_filter input').unbind();
    $('#table_user_archipelago_filter input').bind('keyup change', function(e)
    {
        if($(this).is(':focus'))
        {
            if (e.keyCode === 13) {
                table_user_archipelogo.search($(this).val()).draw();

            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '') {
                    table_user_archipelogo.search($(this).val()).draw();
                }
            }
        }
    });
}

$('#filter_archipelagos_id').change(function()
{
    table_user_archipelogo.draw();
});


$('#table_user_archipelago').on('click', '.logs_schedule_time', function()
{
    $('#attendance_user_logs').html('');
    var id = $(this).attr('name');
    ViewAttendance_logs(id);
});

function ViewAttendance_logs(id)
{
    $.ajax({
        type: 'get',
        url: 'users_management_view_logs',
        data: {
            'id' : id
        },
        success: function(data)
        {
            console.log(data);

            if(data == '')
            {
                $('#attendance_user_logs').html('<table class="table-hover" width="100%">\n' +
                    '<tr style="background-color: brown; color:white; text-align: left">\n' +
                    '<th>Name</th>\n' +
                    '<th>Position</th>\n' +
                    '<th>Activity</th>\n' +
                    '<th>Date Time Ocurred</th>\n' +
                    '</tr>\n' +
                    '<tr>\n' +
                    '<td colspan="5">No Available Records</td>\n' +
                    '</tr>\n' +
                    '</table>');
            }
            else
            {
                var dataTable = '';
                var tableHead = '<table class="table-hover" width="100%">\n' +
                    '                                <tr style="background-color: brown; color:white; text-align: left">\n' +
                    '                                    <th>Name</th>\n' +
                    '                                    <th>Position</th>\n' +
                    '                                    <th>Activity</th>\n' +
                    '                                    <th>Date Time Occured</th>\n' +
                    '                                </tr>';

                for(var i = 0;i < data[0].length; i++)
                {
                    dataTable += '<tr>\n' +
                        '    <td>' + data[0][i].name + '</td>\n' +
                        '    <td>' + data[0][i].position + '</td>\n' +
                        '    <td>' + data[0][i].activity + '</td>\n' +
                        '    <td>' + data[0][i].created_at + '</td>\n' +
                        '</tr>';
                }

                $('#attendance_user_logs').html(tableHead + dataTable + '</table>');
            }

        }
    });
}

$('.gen_att_tabs1 ').click(function()
{
    var gethref = $(this).attr('href');

    if(gethref == '#gen_att_tab3')
    {
        if( $(''+gethref+'').hasClass('active'))
        {
            console.log('do nothing');

        }
        else if(attendance_sched)
        {
            console.log('already loaded');

        }
        else if(attendance_sched == false)
        {
            attendance_sched = true;
            get_user_archipelago();
        }
    }
});



// ROMMEL MANPOWER REQUEST MONITORING
$('#manpower_monit_trigger').click(function(){
    manpower_monitoring();
    $('.manpower_action_btns').hide();
});
function manpower_monitoring() {
    $('#manpower_request_monit_table_paginate').css({"width": "100%", "text-align":"center"});
    $('#manpower_request_monit_table_info').css({"width": "100%", "text-align":"center"});
    $('#manpower_request_monit_table_paginate .paginate_button').css({"padding": "5px", "text-align":"center"});
    $('#manpower_request_monit_table_paginate').css({"width": "100%", "text-align":"center"});
    manpower_request_monit_table = $('#manpower_request_monit_table').DataTable
    ({
        dom: 'Bfrtip',
        buttons:[
            {
                text: '<i class="fa fa-refresh"></i>',
                action: function ( e, dt, node, config ) {
                    manpower_request_monit_table.draw();
                    manpower_to_clear();
                }
            }
        ],
        "responsive": true,
        "processing": true,
        "serverSide": true,
        "ajax": 'manpower_request_monitoring',
        "columns":
            [
                {data: 'manpower_id', name: 'manpower_request.id'},
                {
                    data: function reason_vacancy_cb(data)
                    {

                        if(data.manpower_request_status =='Approved')
                        {
                            if(data.hold_status !='true')
                            {
                                return '<span class="pull-left">'+data.reason_vacancy_cb+'</span>' + '<span style="margin-top:2%; width:100%; font-weight:400; font-size:13px; padding:4%;" class="text-uppercase pull-right label bg-green color-palette">'+data.manpower_request_status+'</span>'
                            }
                            else{
                                return '<span class="pull-left">'+data.reason_vacancy_cb+'</span>'+ '<span style="margin-top:2%; width:100%; font-weight:600; font-size:13px; padding:4%;  "  class="pull-right  label bg-gray color-palette text-red">'+'<i class="fa fa-fw fa-lock"></i> HOLD'+'</span>'
                            }
                        }
                        if(data.manpower_request_status =='Approved_Senior')
                        {
                            if(data.hold_status !='true')
                            {
                                return '<span class="pull-left">'+data.reason_vacancy_cb+'</span>' + '<span style="margin-top:2%; width:100%; font-weight:400; font-size:13px; padding:4%;" class="text-uppercase pull-right label bg-green color-palette">Approved</span>'
                            }
                            else{
                                return '<span class="pull-left">'+data.reason_vacancy_cb+'</span>'+ '<span style="margin-top:2%; width:100%; font-weight:600; font-size:13px; padding:4%;  "  class="pull-right  label bg-gray color-palette text-red">'+'<i class="fa fa-fw fa-lock"></i> HOLD'+'</span>'
                            }
                        }
                        else if(data.manpower_request_status =='Disapproved')
                        {
                            if(data.hold_status !='true')
                            {
                                return '<span class="pull-left">'+data.reason_vacancy_cb+'</span>' + '<span style="margin-top:2%; width:100%; font-weight:400; font-size:13px; padding:4%;"  class="text-uppercase pull-right label bg-red color-palette">'+data.manpower_request_status+'</span>'
                            }
                            else{
                                return '<span class="pull-left">'+data.reason_vacancy_cb+'</span>'+ '<span style="margin-top:2%; width:100%; font-weight:600; font-size:13px; padding:4%;  "  class="pull-right  label bg-gray color-palette text-red">'+'<i class="fa fa-fw fa-lock"></i> HOLD'+'</span>'
                            }

                        }
                        else if(data.manpower_request_status =='Endorse')
                        {
                            if(data.hold_status !='true')
                            {
                                return '<span class="pull-left">'+data.reason_vacancy_cb+'</span>' + '<span style="margin-top:2%; width:100%; font-weight:400; font-size:13px; padding:4%;"  class="text-uppercase pull-right label bg-yellow color-palette">'+data.manpower_request_status+'</span>'
                            }
                            else{
                                return '<span class="pull-left">'+data.reason_vacancy_cb+'</span>'+ '<span style="margin-top:2%; width:100%; font-weight:600; font-size:13px; padding:4%;  "  class="pull-right  label bg-gray color-palette text-red">'+'<i class="fa fa-fw fa-lock"></i> HOLD'+'</span>'
                            }

                        }
                        else if(data.manpower_request_status =='Acknowledge')
                        {
                            if(data.hold_status !='true')
                            {
                                return '<span class="pull-left">'+data.reason_vacancy_cb+'</span>'+ '<span style="margin-top:2%; width:100%; font-weight:400; font-size:13px; padding:4%;"   class="text-uppercase pull-right label bg-aqua color-palette">'+data.manpower_request_status+'</span>'
                            }
                            else{
                                return '<span class="pull-left">'+data.reason_vacancy_cb+'</span>'+ '<span style="margin-top:2%; width:100%; font-weight:600; font-size:13px; padding:4%;  "  class="text-uppercase pull-right  label bg-gray color-palette text-red">'+'<i class="fa fa-fw fa-lock"></i> HOLD'+'</span>'
                            }

                        }

                        else if(data.manpower_request_status =='Reprocess')
                        {
                            if(data.hold_status !='true')
                            {
                                return '<span class="pull-left">'+data.reason_vacancy_cb+'</span>'+ '<span style="margin-top:2%; width:100%; font-weight:400; font-size:13px; padding:4%;"   class="text-uppercase pull-right label bg-orange color-palette">'+data.manpower_request_status+'</span>'
                            }
                            else{
                                return '<span class="pull-left">'+data.reason_vacancy_cb+'</span>'+ '<span style="margin-top:2%; width:100%; font-weight:600; font-size:13px; padding:4%;  "  class="pull-right  label bg-gray color-palette text-red">'+'<i class="fa fa-fw fa-lock"></i> HOLD'+'</span>'
                            }

                        }
                        else if(data.manpower_request_status == ''|| data.manpower_request_status !=null)
                        {
                            if(data.hold_status !='true')
                            {
                                return '<span class="pull-left">'+data.reason_vacancy_cb+'</span>'+ '<span style="margin-top:2%; width:100%; font-weight:400; font-size:13px; padding:4%;"  class="text-uppercase pull-right label bg-gray color-palette">'+'PENDING'+'</span>'
                            }
                            else{
                                return '<span class="pull-left">'+data.reason_vacancy_cb+'</span>'+ '<span style="margin-top:2%; width:100%; font-weight:600; font-size:13px; padding:4%;  "  class="pull-right  label bg-gray color-palette text-red">'+'<i class="fa fa-fw fa-lock"></i> HOLD'+'</span>'
                            }

                        }
                        else{}
                    },
                    name:'manpower_request.reason_vacancy_cb'
                },
                {
                    data:function actions(data)
                    {
                        return'<a value="'+data.hold_status+'" what="'+data.manpower_request_status+'" id="'+data.manpower_id+'" class="btn bg-purple btn-block btn-sm manpower_activities manpower_view_info"  name=""><i class = "fa fa-fw fa-eye"></i> View Info</a>'+
                            '<a id="manpower_view_logs" class="btn bg-navy btn-sm btn-block manpower_activities" data-toggle="modal" data-target="#manpower_logs" name="'+data.manpower_id+'"><i class = "fa fa-edit"></i> View Logs</a>'

                    }, name:'manpower_request.id',"orderable":false,"searchable":false,
                }
            ],
        "order": [[0, 'desc']],
        "pageLength": 10,
        "lengthMenu": [[2, 10, 25, 50, -1], ['2 rows', '10 rows', '25 rows', '50 rows', 'Show all']],
        "fnRowCallback":function(nRow, aData)
        {
            $('td', nRow).css({"cursor":"pointer","letter-spacing":"2px","border":"none"});
            $('.manpower_action_btns').hide();
        },

        initComplete: function () {
            $('#manpower_request_monit_table_length').hide();
            $('#manpower_request_monit_table_wrapper .dt-buttons').addClass('pull-right');
            $('#manpower_request_monit_table_filter').css({"margin-bottom":"5%", "width": "100%"});
            $('#manpower_request_monit_table_filter label').css({"text-align": "left", "width":"100%"});
            $('#manpower_request_monit_table_wrapper .col-sm-5').css({"width": "100%"});
            $('#manpower_request_monit_table_wrapper .col-sm-6').css({"width": "100%"});
            $('#manpower_request_monit_table_wrapper .col-sm-7').css({"width": "100%"});
            $('#manpower_request_monit_table_filter input').css({"width": "100%", "margin": "0","border-radius":"8px","padding":"17px"});
            $('#manpower_request_monit_table th').css({"border":"0"});
            $('.overlay').hide();

        }
    })

    $('#manpower_request_monit_table_filter input').unbind();
    $('#manpower_request_monit_table_filter input').bind('keyup change', function (e) {
        if ($(this).is(':focus')) {
            if (e.keyCode === 13) {
                manpower_request_monit_table.search($(this).val()).draw();
            }
            else if (e.keyCode === 8) {
                if ($(this).val() == '') {
                    manpower_request_monit_table.search($(this).val()).draw();
                }
            }
        }
    });
}

$('#manpower_request_monit_table').on('click', '.manpower_view_info',function () {
    var get_requested_id = $(this).attr('id');

    $('.manpower_action_btns').show();
    var selected_data =$(this).attr('what');
    var selected_hold_status =$(this).attr('value');

    if(selected_data == '')
    {
        $('#approve_manpower_monit').attr('disabled',false);
        $('#disapprove_manpower_monit').attr('disabled',false);
    }
    else if(selected_data=='Acknowledge')
    {
        $('.manpower_action_btns').hide();
    }
    else
        {
        $('#approve_manpower_monit').attr('disabled',true);
        $('#disapprove_manpower_monit').attr('disabled',true);
        }

    if(selected_hold_status == 'true')
    {
        $('#hold_manpower_monit').attr('disabled',true);
        $('#unhold_manpower_monit').attr('disabled',false);
        $('#approve_manpower_monit').attr('disabled',true);
        $('#disapprove_manpower_monit').attr('disabled',true);
    }
    else
        {
            $('#hold_manpower_monit').attr('disabled',false);
            $('#unhold_manpower_monit').attr('disabled',true);
        }

    $('#approve_manpower_monit').attr('name',get_requested_id);
    $('#disapprove_manpower_monit').attr('name',get_requested_id);
    $('#hold_manpower_monit').attr('name',get_requested_id);
    $('#hold_manpower_monit').attr('what2',selected_data);
    $('#unhold_manpower_monit').attr('name',get_requested_id);
    $('#unhold_manpower_monit').attr('what2',selected_data);

    if($(this).closest('tr').hasClass('selected'))
    {
        $('#approve_manpower_monit').attr('name','');
        $('#disapprove_manpower_monit').attr('name','');
        $('.manpower_action_btns').hide();
        manpower_request_monit_table.rows('.selected').deselect();
        manpower_to_clear();
    }
    else
    {
        manpower_request_monit_table.rows('.selected').deselect();
        $(this).closest('tr').addClass('selected');

        $.ajax({
            url: 'manpower_request_selected',
            type: 'get',
            data:
                {
                    'manpower_id': get_requested_id
                },
            success: function (data) {
                console.log(data)
                $('.manpower_management_toclear').val('');
                $('.manpower_management_toclear').prop('checked',false);

                var split_holder = data[0].cb_data;
                var split_holder_checkbox = split_holder.split('||-||');
                split_holder_checkbox.pop();

                var get_requested_date = data[0].created_at.split(" ");
                var get_requested_duedate = data[0].due_date.split(" ");
                $('#manpower_dateofrequest').val(get_requested_date[0]);
                $('#manpower_requestedby').val(data[0].manpower_requestor);
                $('#manpower_office_loc').val(data[0].off_loc_dept_pos);
                $('#reason_vacancy_text_area').val(data[0].reason_remarks);
                $('#manpower_location_dept_pos').val(data[0].job_details_loc_dept_pos);
                $('#manpower_no_candidate').val(data[0].no_of_candidates);
                $('#manpower_quali_required_desired').val(data[0].qualification);
                $('#job_offer_salary').val(data[0].job_offer_salary);
                $('#manpower_duedate').val(get_requested_duedate[0]);

                $('.manpower_checkbox_grp_1 ').each(function()
                {
                    var val = $(this).attr('name');
                    if(val === data[0].reason_vacancy_cb)
                    {
                        $(this).prop('checked', true);
                    }
                    else
                    {
                        $(this).prop('checked', false);
                    }
                });
                for (var a=0; a < split_holder_checkbox.length; a++){
                    if(split_holder_checkbox[a] == 'true')
                    {
                        $('.manpower_checkbox_grp_2[name="'+a+'"]').prop('checked', true);
                    }
                    else if(split_holder_checkbox[a] == 'false') {
                        $('.manpower_checkbox_grp_2[name="'+a+'"]').prop('checked', false);
                    }
                    else
                    {
                        $('.manpower_checkbox_grp_2[name="'+a+'"]').prop('checked', true);
                        $($('.manpower_checkbox_grp_2[name="'+a+'"]').attr('what')).val(split_holder_checkbox[a]);
                    }
                }
            }
        })
    }
});

$('#approve_manpower_monit').on('click',function () {
    var request_id = $(this).attr('name');
    var $this = $(this);
    if(confirm('Are you sure?'))
    {
        $this.attr('disabled',true);
        $.ajax({
            url: 'get_manpower_request_status',
            type: 'get',
            data:
                {
                    'manpower_id':request_id,
                    'manpower_request_status':"Approved_Senior",
                    'manpower_act_logs':"Approved"
                },
            success:function (data) {
                console.log(data)
            },
            beforeSend:function(){
                $('.overlay').show();
            },
            complete:function()
            {
                manpower_scrollToTop();
                manpower_request_monit_table.draw();
                manpower_to_clear();
                $this.attr('disabled',false);
                $('.overlay').hide();
                $('.manpower_action_btns').hide();
            }
        });
    }
    else
    {}
});

$('#disapprove_manpower_monit').on('click',function () {
    var request_id = $(this).attr('name');
    var $this = $(this);
    var promt_cancel = prompt('Enter your Reason:','');

    if(promt_cancel.length > 0)
    {
        $this.attr('disabled',true);
        $.ajax({
            url: 'get_manpower_request_status',
            type: 'get',
            data:
                {
                    'manpower_id':request_id,
                    'manpower_request_status':"Disapproved",
                    'manpower_act_logs':"Disapproved",
                    'remarks_reason':promt_cancel
                },
            beforeSend:function(){
                $('.overlay').show();
            },
            success:function (data) {
                console.log(data)
            },

            complete:function()
            {
                manpower_scrollToTop();
                manpower_request_monit_table.ajax.reload(null, false);
                manpower_to_clear();
                $this.attr('disabled',false);
                $('.overlay').hide();
                $('.manpower_action_btns').hide();
                alert('Manpower request Disapproved');
            }
        });
    }
    else{}
});

$('#hold_manpower_monit').on('click',function () {
    var request_id = $(this).attr('name');
    var $this = $(this);
    if(confirm('Are you sure?'))
    {
        $this.attr('disabled',true);
        $.ajax({
            url: 'hold_manpower_request_status',
            type: 'get',
            data: {
                'manpower_id':request_id,
                'hold_status':'true',
                'remark_status':'Hold',
                'table_status' : $this.attr('what2')
            },
            beforeSend:function(){
                $('.overlay').show();
            },
            success:function (data) {
                console.log(data);

                if(data == 'HOLD')
                {
                    manpower_scrollToTop();
                    manpower_request_monit_table.ajax.reload(null, false);
                    manpower_to_clear();
                    $this.attr('disabled',false);
                    $('.overlay').hide();
                    $('.manpower_action_btns').hide();
                    alert('Hold Success');
                }
                else if(data == 'REFRESH')
                {
                    alert('Failed to hold request. Please refresh the table to continue');
                    $('.overlay').hide();
                }
            }
        });
    }
    else{}
});

$('#unhold_manpower_monit').on('click',function () {
    var request_id = $(this).attr('name');
    var $this = $(this);
    if(confirm('Are you sure?'))
    {
        $this.attr('disabled',true);
        $.ajax({
            url: 'hold_manpower_request_status',
            type: 'get',
            data:
                {
                    'manpower_id':request_id,
                    'hold_status':'false',
                    'remark_status':'Unhold',
                    'table_status' : $this.attr('what2')
                },
            beforeSend:function(){
                $('.overlay').show();
            },
            success:function (data) {
                if(data == 'HOLD')
                {
                    manpower_scrollToTop();
                    manpower_request_monit_table.ajax.reload(null, false);
                    manpower_to_clear();
                    $this.attr('disabled',false);
                    $('.overlay').hide();
                    $('.manpower_action_btns').hide();
                    alert('Unhold Success');
                }
                else if(data == 'REFRESH')
                {
                    alert('Failed to Unhold request. Please refresh the table to continue');
                    $('.overlay').hide();
                }
            }
        });
    }
    else{}
});
function manpower_scrollToTop()
{
    $('html, body').animate({ scrollTop: 0 }, 300 ,"swing");
}

function manpower_to_clear() {
    $('.manpower_management_toclear').each(function()
    {
        if ($(this).val() != '')
        {
            $(this).val('');
            $('.manpower_management_toclear').prop('checked', false);
            $('#manpower_request_monit_table_filter input.form-control.input-sm').val('');
        }
    });
}
$('#manpower_request_monit_table').on('click','.manpower_activities',function () {
    var activity_log_id = $(this).attr('name');

    $('#manpower_activity_logs_table tbody tr').each(function()
    {
        $(this).remove();
    });

    $.ajax({
        url:'manpower_activity_logs',
        type:'get',
        data:{
            'manpower_id':activity_log_id
        },
        success:function(data){
            console.log(data);

            var act_logs_append ='';

            if(data.length > 0)
            {
                for(var i = 0;i < data.length; i++)
                {
                    act_logs_append +=  '<tr>' +
                        '<td>'+data[i].user_name+'</td>' +
                        '<td>'+data[i].manpower_request_status+'</td>' +
                        '<td>'+data[i].created_at+'</td>' +
                        +'</tr>'
                }
            }
            else
            {
                act_logs_append =  '<tr>' +
                    '<td colspan="3">No Records Found</td>' +
                    +'</tr>';
            }

            $('#manpower_activity_logs_table tbody').append(act_logs_append);
        }
    })
});

$(document).on('click', '.management_leave', function() {

    // $('#table_emp_leave_monitoring thead tr th').each(function()
    // {
    //     $(this).css('background-color', 'black');
    //     $(this).css('color', 'white');
    // });

    // $('#table_emp_leave_monitoring tfoot tr th').each(function()
    // {
    //     $(this).css('background-color', 'black');
    //     $(this).css('color', 'white');
    // });

    getLeaveMonitoring();

    function getLeaveMonitoring() {

        table_leave_monit = $('#table_emp_leave_monitoring').DataTable
        ({
            "responsive": true,
            // "scrollY": 600,
            // "scrollCollapse": true,
            // "paging": false,
            "processing": true,
            "serverSide": true,
            // "ajax": "get_emp_leave_monitoring",
            "ajax":
                {
                    url: "get_emp_leave_monitoring",
                    data: function (d)
                    {
                        d.min_date_endorsed = $('#sao_assign_min').val();
                        d.max_date_endorsed = $('#sao_assign_max').val();
                        d.search_methodd = $('input[name="sao_assign_rad"]:checked').val();
                    }
                },
            "columns":
                [
                    {data: 'name', name: 'users.name'},
                    {data: 'leave_start', name: 'leave_start'},
                    {data: 'leave_end', name: 'leave_end'},
                    {data: 'leave_type', name: 'leave_type'},
                    {data: 'leave_reason', name: 'leave_reason'},
                    // {data: 'leave_status', name: 'leave_status'},
                    {
                        data: function leavestatus(data) {
                            if (data.leave_status == 'Pending') {
                                return '<span class="btn-xs btn-block text-yellow text-uppercase" style="border:1px solid #db8b0b ;">pending</span>'
                            }
                            else if (data.leave_status == 'APPROVED') {
                                return '<span class="btn-xs btn-block text-green text-uppercase" style="border:1px solid #008d4c ;">approved</span>'
                            }
                            else if (data.leave_status == 'DISAPPROVED') {
                                return '<span class="btn-xs btn-block text-red text-uppercase" style="border:1px solid #d33724 ;">disapproved</span>'
                            }
                            else if (data.leave_status == 'CANCELLED') {
                                return '<span class="btn-xs btn-block text-uppercase" style="border:1px solid #b5bbc8 ;color:#9198a9;">cancelled</span>'
                            }
                        }
                    },
                    // {
                    //     data: function action(data)
                    //     {
                    //         if (data.leave_status != 'CANCELLED')
                    //         {
                    //             return'' +
                    //                 '<button class="btn btn-block btn-success btn-sm leave_approve_mam" name="'+data.leave_id+'" data-target="#modal_approve_ma" data-toggle="modal"><span class="fa fa-file"></span>  Review</button>'+
                    //                 '<button class="btn btn-block btn-warning btn-sm leave_disapprove_pap" data-target="#modal_disapprove_pa" data-toggle="modal" name="'+data.leave_id+'"><span class="fa fa-close"></span>  Disapprove</button>'+
                    //                 '<button class="btn btn-block btn-info btn-sm leave_view_uzi" data-toggle="modal" data-target="#modal_leave_view_logs" name="'+data.leave_id+'"><span class="fa fa-eye">  View Logs</button>'
                    //         }
                    //         else
                    //         {
                    //             return'' +
                    //                 '<button class="btn btn-block btn-danger btn-sm" style="pointer-events: none">Already Cancelled</button>'
                    //         }
                    //     },'name': 'name',
                    //     searchable: false,
                    //     orderable: false
                    // },
                    {
                        data: function action(data)
                        {
                            // if (data.leave_status != 'CANCELLED')
                            // {
                            //     return'' +
                            //         '<button class="btn btn-block btn-success btn-sm leave_approve_mam" name="'+data.leave_id+'" data-target="#modal_approve_ma" data-toggle="modal"><span class="fa fa-file"></span>  Review</button>'+
                            //         '<button class="btn btn-block btn-warning btn-sm leave_disapprove_pap" data-target="#modal_disapprove_pa" data-toggle="modal" name="'+data.leave_id+'"><span class="fa fa-close"></span>  Disapprove</button>'+
                            //         '<button class="btn btn-block btn-info btn-sm leave_view_uzi" data-toggle="modal" data-target="#modal_leave_view_logs" name="'+data.leave_id+'"><span class="fa fa-eye">  View Logs</button>'
                            // }
                            if (data.leave_status != 'CANCELLED'){
                                return'<span>'+
                                    '<a class="btn-block btn btn-sm bg-blue text-uppercase leave_approve_mam" name="'+data.leave_id+'" data-target="#modal_approve_ma" data-toggle="modal" style="box-shadow:-6px 7px 5px #ddd;"><i class="fa fa-fw fa-check-circle"></i> approve</a>'+
                                    '<a class="btn-block btn btn-sm bg-orange text-uppercase leave_disapprove_pap" name="'+data.leave_id+'" data-target="#modal_disapprove_pa" data-toggle="modal" style="box-shadow:-6px 7px 5px #ddd;"><i class="fa fa-fw fa-times-circle"></i> dissaprove</a>'+
                                    '<a class="btn-block btn btn-sm bg-navy text-uppercase leave_view_uzi" name="'+data.leave_id+'" data-toggle="modal" data-target="#modal_leave_view_logs" style="box-shadow:-6px 7px 5px #ddd;"><i class="fa fa-fw fa-eye"></i> view logs</a>'
                                    +'</span>'
                            }
                            else
                            {
                                return'<span>'+'<a class="btn-block btn btn-sm bg-gray" disabled><i class="fa fa-fw fa-trash"></i> Removed</a>'+'</span>'
                            }
                        },
                        'name': 'name',
                        searchable: false,
                        orderable: false
                    }
                ],
            "pageLength": 5,
            "pagingType": "simple",
            "deferRender": true,
            "bSortClasses": false,
            "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull)
            {
                // if(aData.status == 'Acknowledge')
                // {
                //     $('td', nRow).css('background-color', '#ffb84d');
                // }
                // else
                // {
                //     $('td', nRow).css('background-color', '#b3ffb3');
                // }
                //
                // $('td', nRow).css('cursor', 'pointer');
                // $('td', nRow).addClass('get_infos');
                // $('td', nRow).attr('id', btoa(aData.id));
            },
            initComplete: function () {
                var api = this.api();
                // Apply the search
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

                $('.overlay').hide();
                $('#table_emp_leave_monitoring_wrapper').css({"margin-top":"2%"});
                $('#table_emp_leave_monitoring tbody td').css({"vertical-align":"middle"});
                $('#table_emp_leave_monitoring_length').css({"margin-bottom":"5%"});
            }
        });

        $('#table_emp_leave_monitoring_filter input').unbind();
        $('#table_emp_leave_monitoring_filter input').bind('keyup change', function (e) {

            if ($(this).is(':focus')) {
                if (e.keyCode == 13) {
                    table_leave_monit.search($(this).val()).draw();
                }
                else if (e.keyCode === 8) {
                    if ($(this).val() == '') {
                        table_leave_monit.search($(this).val()).draw();
                    }
                }
            }
        });
    }
});


$('.sao_assign_rad_click').click(function()
{
    if($(this).attr('value') == 'all')
    {
        $('#sao_assign_rad_holder').hide();
        table_leave_monit.draw();
    }
    else
    {
        if($(this).val() != '')
        {
            table_leave_monit.draw();
        }
        $('#sao_assign_rad_holder').show();
    }
});

$('#sao_assign_rad_holder').change(function()
{
    table_leave_monit.draw();
});

$('.sao_assign_rad_click_transfer').click(function()
{
    if($(this).attr('value') == 'all')
    {
        $('#sao_assign_rad_holder_transfer').hide();
        table_leave_monit.draw();
    }
    else
    {
        if($(this).val() != '')
        {
            table_leave_monit.draw();
        }
        $('#sao_assign_rad_holder_transfer').show();
    }
});

$('#sao_assign_rad_holder_transfer').change(function()
{
    table_leave_monit.draw();
});

$('#table_emp_leave_monitoring').on('click', '.leave_approve_mam', function () {
    var $this = $(this).attr('name');
        $.ajax({
            url: 'get_leave_record_emp',
            type: 'get',
            data:
                {
                    'leave_id' : $(this).attr('name')
                },
            success: function (data) {

                $('#modal_approve_ma').modal('show');
                $('#leave_managers_approve').attr('name', btoa($this));
                $('#rec_leave_start_date').val(data[0].start_date);
                $('#rec_leave_end_date').val(data[0].end_date);
                $('#rec_leave_type').val(data[0].type);
                $('#rec_ot_type').val(data[0].others);
                $('#rec_number_days_payable').val(data[0].days);
                $('#rec_days_of_leave').val(data[0].days);
                $('#rec_leave_remarks').val(data[0].remarks);
                console.log(data)
            }
        });
});

$('#leave_managers_approve').on('click', function ()
{
    $('#overlay_confirm_request_leave').show();
    $('.alert_remarks').each(function ()
    {
        if ($(this).val() != '')
        {
            leave_rem = true;
        }
        else
        {
            console.log($(this));
            leave_rem = false;
            alert('Fill-up the required fields');
            return false;
        }
    });

    if(leave_rem) {
    if(confirm('Are you sure to update the days of leave?')) {
        $.ajax({
            type: 'get',
            url: 'get_leave_edit_record',
            data: {
                'id': $('#leave_managers_approve').attr('name'),
                'leave_status': "Approved",
                'pay_options': $('#rec_number_days_payable').val(),
                'remarks': $('#rec_leave_remarks').val(),
                'leave_type': $('#rec_leave_type').val(),
                'opt_others_leave': $('#rec_ot_type').val()
            },
            success: function (data) {
                    $('#modal_approve_ma').modal('hide');
                    table_leave_monit.ajax.reload(null, false);
                    // table_leave_request.ajax.reload(null, false);
                    $('#rec_leave_remarks').val('');
                    alert('Successfully Confirmed!');
                    calendar_fetch_data();
                    // calendar_trigger();
                    $('#overlay_confirm_request_leave').hide();
            },
            complete: function () {
              setTimeout(function () {
                  full_calendar_mon.fullCalendar('refetchEvents');
              },1000);
            },
            error: function (e) {
                alert('Error occured contact the web admin for assistance. Thank you');
            }
        });
      }
    }
});

$('#table_emp_leave_monitoring').on('click', '.leave_disapprove_pap', function () {
    var $this = $(this).attr('name');

        $.ajax({
            url: 'get_leave_record_emp',
            type: 'get',
            data:
                {

                    'id': $(this).attr('name')
                },
            success: function (data) {

                $('#modal_disapprove_pa').modal('show');
                $('#leave_manager_disapprove').attr('name', btoa($this));
                $('#rec_leave_remarks').val(data[0].remarks);
                console.log(data)
            }
        });
});

$('#leave_manager_disapprove').on('click', function ()
{
    $('#overlay_disapprove_request_leave').show();
    $('.leave_remarker').each(function () {
        if ($(this).val() != '')
        {
            disapp_rem = true;
        }
        else
        {
            console.log($(this));
            disapp_rem = false;
            alert('Fill-up the required fields');
            return false;
        }
    });

    if(disapp_rem) {
        if (confirm('Are you sure you want to disapprove the request?')) {
            $.ajax({
                type: 'get',
                url: 'get_leave_edit_record',
                data: {
                    'id': $('#leave_manager_disapprove').attr('name'),
                    'leave_status': "Disapproved",
                    'remarks': $('#rec_disapprove_remark').val()
                },
                success: function (data) {
                    $('#modal_disapprove_pa').modal('hide');
                    table_leave_monit.ajax.reload(null, false);
                    table_leave_request.ajax.reload(null, false);
                    alert('Request Disapproved!');
                    $('#overlay_disapprove_request_leave').hide();
                },
                error: function (e) {
                    alert('Error occured contact the web admin for assistance. Thank you');
                }
            });
        }
    }
});

$('#table_emp_leave_monitoring').on('click', '.leave_view_uzi', function () {
   $('#leave_view_logs').html('');
   var id = $(this).attr('name');
   ViewLeaveRequest_logs(id);
});

function ViewLeaveRequest_logs(leave_id)
{
    $.ajax({
        type: 'get',
        url: 'view_leave_req_logs',
        data: {
            'id' : leave_id
        },
        success: function(data)
        {
            console.log(data);

            if(data == '')
            {
                $('#leave_view_logs').html('<table class="table-hover" width="100%">\n' +
                    '<tr style="background-color: #001F3F; color:white; text-align: left">\n' +
                    '<th>Name</th>\n' +
                    '<th>Position</th>\n' +
                    '<th>Activity</th>\n' +
                    '<th>Date Time Ocurred</th>\n' +
                    '</tr>\n' +
                    '<td colspan="5">No Available Records</td>\n' +
                    '</tr>\n' +
                    '</table>');
            }
            else
            {
                var dataTable = '';
                var tableHead = '<table class="table-hover" width="100%">\n' +
                    '                                <tr style="background-color: #001F3F; color:white; text-align: left">\n' +
                    '                                    <th>Name</th>\n' +
                    '                                    <th>Position</th>\n' +
                    '                                    <th>Activity</th>\n' +
                    '                                    <th>Date Time Received</th>\n' +
                    '                                </tr>';

                for(var i = 0;i < data[0].length; i++)
                {
                    dataTable += '<tr>\n' +
                        '    <td>' + data[0][i].name + '</td>\n' +
                        '    <td>' + data[0][i].position + '</td>\n' +
                        '    <td>' + data[0][i].leave_request_activity + '</td>\n' +
                        '    <td>' + data[0][i].created_at + '</td>\n' +
                        '</tr>';
                }

                $('#leave_view_logs').html(tableHead + dataTable + '</table>');
            }

        },
        complete:function(){
            $('span#leave_view_logs td,span#leave_view_logs th').css({"font-size":"15px","padding":"2% 0"});

        }
    });
}

function calendar_trigger() {
    /* initialize the external events
     -----------------------------------------------------------------*/
    // function init_events(ele) {
    //     ele.each(function () {
    //
    //         // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
    //         // it doesn't need to have a start or end
    //         var eventObject = {
    //             title: $.trim($(this).text()) // use the element's text as the event title
    //         };
    //
    //         // store the Event Object in the DOM element so we can get to it later
    //         $(this).data('eventObject', eventObject);
    //
    //         // make the event draggable using jQuery UI
    //         $(this).draggable({
    //             zIndex        : 1070,
    //             revert        : true, // will cause the event to go back to its
    //             revertDuration: 0  //  original position after the drag
    //         })
    //
    //     })
    // }

    // init_events($('#external-events div.external-event'));

    /* initialize the calendar
     -----------------------------------------------------------------*/
    //Date for the calendar events (dummy data)
    // alert('test');
    var date = new Date();
    var d    = date.getDate(),
        m    = date.getMonth(),
        y    = date.getFullYear();

    full_calendar_mon = $('#calendar_mon').fullCalendar({
        header    : {
            left  : 'prev,next today',
            center: 'title',
            right : 'month,agendaWeek,agendaDay'
        },
        buttonText: {
            today: 'today',
            month: 'month',
            agendaWeek: 'Week',
            day: 'Day'
        },
        events: function(start, end, timezone, callback) {
            callback(events);
        },
        // eventColor: '#378006',
        eventLimit: 1, // for all non-TimeGrid views
        eventLimitText: 'more',
        eventLimitClick: 'popover',
        eventClick: function(event) {
            console.log(event);
            event_id = event.id;
            $('#cal_emp_leave').val(event.title);
            $('#cal_leave_type').val(event.desc);
            $('#cal_leave_reason').val(event.reason);
            $('#cal_date_start').html(event.start_text);
            $('#cal_date_end').html(event.end_text);
            // console.log(event.start_text);
            $('#modal_view_leave_calendar').modal('show');
            // alert(event.desc);
        },
        editable  : false,
        displayEventTime: false,
        droppable : false // this allows things to be dropped onto the calendar !!!
        // drop      : function (date, allDay) { // this function is called when something is dropped
        //
        //     // retrieve the dropped element's stored Event Object
        //     var originalEventObject = $(this).data('eventObject');
        //
        //     // we need to copy it, so that multiple events don't have a reference to the same object
        //     var copiedEventObject = $.extend({}, originalEventObject);
        //
        //     // assign it the date that was reportedF
        //     copiedEventObject.start           = date;
        //     copiedEventObject.allDay          = allDay;
        //     copiedEventObject.backgroundColor = $(this).css('background-color');
        //     copiedEventObject.borderColor     = $(this).css('border-color');
        //
        //     // render the event on the calendar
        //     // the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
        //     $('#calendar_mon').fullCalendar('renderEvent', copiedEventObject, true);
        //
        //     // is the "remove after drop" checkbox checked?
        //     if ($('#drop-remove').is(':checked')) {
        //         // if so, remove the element from the "Draggable Events" list
        //         $(this).remove()
        //     }
        //
        // }
    });
    setTimeout(function () {
        $('.fc-today-button').click();
    },2000);
}

function calendar_fetch_data() {

    events = [];
    jQuery.ajax({
        url: 'management_leave_calendar',
        type: 'POST',
        dataType: 'json',
        success: function(doc) {
            // console.log(doc);
            $.map( doc, function( r ) {
                console.log(r);
                // if(r.repeat == 'true')
                // {
                    var get_start = r.leave_start;
                    var splited_start_date = get_start.split('-');
                    var start_year = splited_start_date[0];
                    var start_month = splited_start_date[1];
                    var start_day = splited_start_date[2];

                    var get_end = r.leave_end;
                    var splited_end_date = get_end.split('-');
                    var end_year = splited_end_date[0];
                    var end_month = splited_end_date[1];
                    var end_day = splited_end_date[2];

                    for(var ctr = 0; ctr<10; ctr++)
                    {
                        // console.log('true: '+start_year+'-'+start_month+'-'+start_day);
                        events.push({
                            id: r.id,
                            title: r.name,
                            desc: r.leave_type,
                            reason: r.leave_reason,
                            start: start_year+'-'+start_month+'-'+start_day,
                            end: end_year+'-'+end_month+'-'+end_day,
                            start_text: start_year+'-'+start_month+'-'+start_day,
                            end_text : end_year+'-'+end_month+'-'+end_day
                        });

                        start_year++;
                        end_year++;
                    }
                // }
                // else if(r.repeat == 'false')
                // {
                //     // console.log('false: '+r.start_date);
                //
                //     events.push({
                //         id: r.id,
                //         title: r.title,
                //         desc: r.description,
                //         start: r.start_date,
                //         end: r.end_date,
                //         start_text:  r.start_date,
                //         end_text : r.end_date
                //     });
                // }
            });

        }
    });

}

$('#fund_util_mngmnt_trigger').click(function(){
$('#select2-fund_util_category-container, #select2-existing_cat_id_holder-container').css({"line-height":"20px"});
fund_util_pending_table =$('#fund_util_management_pending').DataTable ({
    dom: 'Blfrtip',
    buttons:[
        {
            text: '<span class="text-capitalize"><i class="fa fa-fw fa-refresh"></i> refresh</span>',
            action: function ( e, dt, node, config ) {
                fund_util_pending_table.draw();
            },className:'bg-orange btn',
            init: function(api, node, config){
                $(node).removeClass('dt-button')
            }
        }],
       "responsive": true,
       "processing": true,
       "serverSide": true,
       "ajax": {
           url:'admin_approved_fund_util_expenses',
           data:function(d)
           {
               d.category_select = $('#fund_util_category').find(':selected').val();
           }

           },
       "columns":
            [
               {data:'fund_utility_id',name:'fund_utility_expenses_table.id'},
                {
                    data: function cat_id(data)
                    {
                        return '<span id="cat_identifier-'+data.fund_utility_id+'">'+data.category_name+'</span>'
                    },
                    name:'fund_utility_category.category_name'
                },
                {
                    data: function accnt_number(data)
                    {
                        return '<span id="accnt_nmber_identifier-'+data.fund_utility_id+'">'+data.account_number+'</span>'
                    },
                    name:'fund_utility_expenses_table.account_number'
                },
                {
                    data: function amount(data)
                    {
                        return '<span id="amount_identifier-'+data.fund_utility_id+'">'+data.amount+'</span>'
                    },
                    name:'fund_utility_expenses_table.amount'
                },
                {
                    data: function statement_date(data)
                    {
                        return '<span class="btn-block" id="statement_date_identifier-'+data.fund_utility_id+'">'+'<i class="fa fa-fw fa-hourglass-start margin text-green"></i>'+data.statement_date+'</span>'+
                            '<span class="btn-block" id="due_date_identifier-'+data.fund_utility_id+'">'+'<i class="fa fa-fw fa-hourglass-end margin text-red"></i>'+data.due_date+'</span>'
                    },
                    name:'fund_utility_expenses_table.statement_date'
                },
                {
                    data: function branch(data)
                    {
                        return '<span id="branch_identifier-'+data.fund_utility_id+'">'+data.fund_utility_branch+'</span>'
                    },
                    name:'fund_utility_expenses_table.branch'
                },
                {
                    data: function status(data)
                    {
                        if(data.fund_status == 0)
                        {
                            return '<span class="btn-xs btn-block text-orange text-uppercase" style="border:1px solid #f39c12;">pending</span>'
                        }
                    },name:'fund_utility_expenses_table.fund_status'
                },
                {
                    data: function actions(data)
                    {
                        return'<span>'+'<a value="'+data.fund_status+'" id="'+data.fund_utility_id+'" class="btn-block btn btn-sm bg-purple text-capitalize fund_util_edit_class" data-toggle="modal" data-target="#fund_util_data_modal"><i class="fa fa-fw fa-pencil-square-o"></i> view info</a>'+
                            '<a id="fund_util_logs_id" class="btn-block btn btn-sm btn-default text-capitalize fund_util_logs_class" data-toggle="modal" data-target="#fund_util_activity_logs" name="'+data.fund_utility_id+'" style="border:1px solid #605ca8;"><i class="fa fa-fw fa-eye text-purple"></i> view logs</a>'
                            +'</span>'
                    },name:'fund_utility_expenses_table.id'
                }
               ],
       "order": [[0, 'desc']],
       "pageLength": 10,
       "lengthMenu": [[2, 10, 25, 50, -1], ['2 rows', '10 rows', '25 rows', '50 rows', 'Show all']],
       initComplete:function()
       {
           $('.overlay').hide();
           $('#fund_util_management_pending tbody td').css({"vertical-align":"middle"});
           $('#fund_util_management_pending th').css({"font-size":"12.5px"});
           $('#fund_util_management_pending_length, #fund_util_management_pending_filter').css({"margin-bottom":"5%","letter-spacing":"1px"});
           $('#fund_util_management_pending_wrapper .dt-buttons').css({"position":"absolute","right":"77%"});

       }
   });

    $('#fund_util_category').change(function()
    {
        fund_util_pending_table.draw();
    });
});
$('#fund_util_approved_tab').click(function(){

    $('#select2-fund_util_category-container, #select2-existing_cat_id_holder-container').css({"line-height":"20px"});
    fund_approved_table = $('#fund_util_approved_datatable').DataTable
    ({dom: 'Blfrtip',
        buttons:[
        {
            text: '<span class="text-capitalize"><i class="fa fa-fw fa-refresh"></i> refresh</span>',
            action: function ( e, dt, node, config ) {
                fund_approved_table.draw();
            },className:'bg-orange btn',
            init: function(api, node, config){
                $(node).removeClass('dt-button')
            }
        }],
        "responsive": true,
        "processing": true,
        "serverSide": true,
        "ajax": {
            url:'fund_utility_management_approved',
            data:function(d)
            {
                d.category_select = $('#fund_util_category').find(':selected').val();
            }
        },
        "columns":
            [
                {data: 'fund_utility_id',name:'fund_utility_expenses_table.id'},
                {
                    data: function cat_id(data)
                    {
                        return '<span id="cat_identifier-'+data.fund_utility_id+'">'+data.category_name+'</span>'
                    },
                    name:'fund_utility_category.category_name'
                },
                {
                    data: function accnt_number(data)
                    {
                        return '<span id="accnt_nmber_identifier-'+data.fund_utility_id+'">'+data.account_number+'</span>'
                    },
                    name:'fund_utility_expenses_table.account_number'
                },
                {
                    data: function amount(data)
                    {
                        return '<span id="amount_identifier-'+data.fund_utility_id+'">'+data.amount+'</span>'
                    },
                    name:'fund_utility_expenses_table.amount'
                },
                {
                    data: function statement_date(data)
                    {
                        return '<span class="btn-block" id="statement_date_identifier-'+data.fund_utility_id+'">'+'<i class="fa fa-fw fa-hourglass-start margin text-green"></i>'+data.statement_date+'</span>'+
                            '<span class="btn-block" id="due_date_identifier-'+data.fund_utility_id+'">'+'<i class="fa fa-fw fa-hourglass-end margin text-red"></i>'+data.due_date+'</span>'
                    },
                    name:'fund_utility_expenses_table.statement_date'
                },
                {
                    data: function branch(data)
                    {
                        return '<span id="branch_identifier-'+data.fund_utility_id+'">'+data.fund_utility_branch+'</span>'
                    },
                    name:'fund_utility_expenses_table.branch'
                },
                {
                    data: function status(data)
                    {
                        if(data.fund_status == 1)
                        {
                            return '<span class="btn-xs btn-block text-green text-uppercase" style="border:1px solid #00a65a;">approved</span>'
                        }
                    },name:'fund_utility_expenses_table.fund_status'
                },
                {
                    data: function actions(data)
                    {
                        return'<span>'+'<a value="'+data.fund_status+'" id="'+data.fund_utility_id+'" class="btn-block btn btn-sm bg-purple text-capitalize fund_util_edit_class" data-toggle="modal" data-target="#fund_util_data_modal"><i class="fa fa-fw fa-pencil-square-o"></i> view info</a>'+
                            '<a id="fund_util_logs_id" class="btn-block btn btn-sm btn-default text-capitalize fund_util_logs_class" data-toggle="modal" data-target="#fund_util_activity_logs" name="'+data.fund_utility_id+'" style="border:1px solid #605ca8;"><i class="fa fa-fw fa-eye text-purple"></i> view logs</a>'
                            +'</span>'
                    },name:'fund_utility_expenses_table.id'
                }
            ],
        "order": [[0, 'desc']],
        "pageLength": 10,
        "lengthMenu": [[2, 10, 25, 50, -1], ['2 rows', '10 rows', '25 rows', '50 rows', 'Show all']],
        initComplete:function()
        {
            $('.overlay').hide();
            $('#fund_util_approved_datatable tbody td').css({"vertical-align":"middle"});
            $('#fund_util_approved_datatable th').css({"font-size":"12.5px"});
            $('#fund_util_approved_datatable_length, #fund_util_approved_datatable_filter').css({"margin-bottom":"5%","letter-spacing":"1px"});
            $('#fund_util_approved_datatable_wrapper .dt-buttons').css({"position":"absolute","right":"77%"});
        },
    });

    $('#fund_util_category').change(function()
    {
        fund_approved_table.draw();
    });
});

$('#fund_util_management_pending, #fund_util_approved_datatable').on('click','.fund_util_edit_class',function(){
    var fund_approve_id = $(this).attr('id');
    $('#expenses_statement_date_edit').val($('#statement_date_identifier-'+fund_approve_id+'').text());
    $('#expenses_due_date_edit').val($('#statement_date_identifier-'+fund_approve_id+'').text());
    $('#expenses_branches_edit').val($('#branch_identifier-'+fund_approve_id+'').text());
    $('#expenses_account_number_edit').val($('#accnt_nmber_identifier-'+fund_approve_id+'').text());
    $('#expenses_amount_edit').val($('#amount_identifier-'+fund_approve_id+'').text());
    $('.fund_util_approved_btn').attr('name',fund_approve_id);

    //chano ref
    $.ajax
    ({
        type:'get',
        url:'admin_fund_util_get_file_uploads',
        data:{'fund_utility_id':fund_approve_id},

        success:function(data){

            var fund_status = data[4][0].fund_status;
            if(fund_status != 0)
            {
                $('#fund_util_approved').prop('disabled',true);
            }
            else
            {
                $('#fund_util_approved').prop('disabled',false);
            }
            var upload_files='';
            for (var i = 0; i < data[0].length; i++)
            {
                var data_array = data[0][i];
                var data_array_name = btoa(data_array.substring(1));
                var file_id = btoa(fund_approve_id);
                var file_extension = data_array.split('.');
                var file_checker = file_extension.pop();

                if(file_checker =='jpeg' || file_checker =='jpg' || file_checker =='png' || file_checker =='gif' || file_checker =='tiff')
                {
                    upload_files +=
                        '<div class="col-md-4" id="'+fund_approve_id+'">'
                        +'<div class="">'
                        +'<div class="form-group">'
                        +'<a href="getuploaded_files/'+file_id+'/'+data_array_name+'" target="_blank" title="'+data_array.substring(1)+'">'
                        +'<img src="getuploaded_files/'+file_id+'/'+data_array_name+'" title="Click to enlarge photo" alt="'+data_array.substring(1)+'" style="width:100%; max-height:25%;">'+
                        '</a>'
                        +'</div>'
                        +'</div>'
                        +'</div>'
                }
                else
                {
                    upload_files +=
                        '<div class="col-md-4" id="'+fund_approve_id+'">'
                        +'<div class="">'
                        +'<div class="form-group">'
                        +'<a href="getuploaded_files/'+file_id+'/'+data_array_name+'" target="_blank" title="'+data_array.substring(1)+'">'
                        +'<img src="dist/img/downloadIconnn (2).png" title="Click to download" alt="'+data_array.substring(1)+'" style="width:100%; max-height:25%;">'+
                        '</a>'
                        +'</div>'
                        +'</div>'
                        +'</div>'
                }
            }
            $('#upload_file_append').append(upload_files);
        },
        complete:function(){
        $('#upload_file_append img').css({"border-radius":"4px"});
        }
    });

    $('#fund_util_data_modal').on('hidden.bs.modal',function(){
        $('#upload_file_append').html('');
    });
});

$('.fund_util_approved_btn').click(function(){
    var approved_btn_id = $(this).attr('name')
    var $this = $(this);
    console.log(approved_btn_id);
    var statement_date_mngmnt = $('#expenses_statement_date_edit').val();
    var due_date_mngmnt = $('#expenses_due_date_edit').val();
    var branches_mngmnt = $('#expenses_branches_edit').val();
    var account_number_mngmnt = $('#expenses_account_number_edit').val();
    var amount_mngmnt = $('#expenses_amount_edit').val();

    if(confirm('Approved Fund request ?'))
    {
        $this.attr('disabled',true);

        $.ajax({
            url:'fund_util_approved_request',
            type:'get',
            data:{
                'fund_util_approved_id':approved_btn_id,
                'fund_approved_status':1,
                'fund_statement':statement_date_mngmnt,
                'fund_due':due_date_mngmnt,
                'fund_branches':branches_mngmnt,
                'fund_account_number':account_number_mngmnt,
                'fund_amount':amount_mngmnt,
            },
            beforeSend:function(){
                $('.overlay').show();
            },
            success:function(data) {
                if(data=='FUND_UTIL_APPROVED'){
                    console.log(data);
                    alert('Fund utilities request approved!');
                    $this.attr('disabled',false)
                    $('#fund_util_data_modal').modal('hide');
                    $('.overlay').hide();
                }
                else if(data=='FUND_UTIL_REFRESH'){
                    alert('Request has changes,( Please refresh the table )');
                    $('.overlay').hide();
                }
                fund_util_pending_table.draw();
            },
        });
    }
});
$('#fund_util_management_pending, #fund_util_approved_datatable').on('click','.fund_util_logs_class',function () {
    var view_logs_id = $(this).attr('name');

    $('#fund_utilities_logs tbody tr').each(function()
    {
        $(this).remove();
    });

    $.ajax({
        type:'get',
        url:'admin_view_fund_utilites_logs',
        data:{'fund_logs_id':view_logs_id},
        success:function(data){
            console.log(data);
            var fund_util_logs_append='';

            if(data.length > 0)
            {
                for(var i = 0;i < data.length; i++)
                {
                    fund_util_logs_append +=  '<tr>' +
                        '<td>'+data[i].user_name+'</td>' +
                        '<td>'+data[i].activity+'</td>' +
                        '<td>'+data[i].created_at+'</td>' +
                        +'</tr>'
                }
            }
            else
            {
                fund_util_logs_append =  '<tr>' +
                    '<td colspan="3">No Records Found</td>' +
                    +'</tr>';
            }

            $('#fund_utilities_logs tbody').append(fund_util_logs_append);
        }
    });
});




