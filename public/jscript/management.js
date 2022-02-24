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
    }
});

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
        alert('Please indicate remarks.')
        btn.attr('disabled', false);
    }
})


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

$('#ci_expense_archi').change(function()
{
    tableFundFa.draw();
});