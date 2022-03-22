var ci_supervisor_dash, ci_supervisor_accounts, ci_supervisor_fund_req, ci_supervisor_realtime_fund, search_acct, fa_mon, activeSide;
activeSide = '';
ci_supervisor_dash = false;
ci_supervisor_accounts = true;
ci_supervisor_fund_req = false;
ci_supervisor_realtime_fund = false;
search_acct = false;

var table_realtime_funds;
var title_realtime_funds = [];
var title_realtime_funds_counts = 0;

var ciTable4Pending, ciTable4Finished;

var pendingCI, finishedCI, realtimeFund, activeTabCi;
activeTabCi = 'pendingCI';

pendingCI = true;
finishedCI = false;
realtimeFund = false;

var ciID;


$(document).ready(function ()
{
    var today = new Date();
    var yearmonth;
    var date;

    // $('.viewable_report1').css('display','none');

    $( "#datepicker_report1" ).datepicker({ dateFormat: 'yy-mm-dd' ,        orientation: "bottom"});
    $( "#datepickermax_report1" ).datepicker({ dateFormat: 'yy-mm-dd' ,        orientation: "bottom"});

    // $('.date_range_conts_report').css('display','none');
    $('.date_range_conts_report').css('display','');

    if((today.getDate()).toString().length <= 1)
    {
        date = '-0'+today.getDate();
    }
    else
    {
        date = '-'+today.getDate()
    }

    if((today.getMonth()+1).toString().length <= 1)
    {
        yearmonth = today.getFullYear()+'-0'+(today.getMonth()+1);
    }
    else
    {
        yearmonth = today.getFullYear()+'-'+(today.getMonth()+1);
    }

    var month;
    var dateyear;

    if((today.getMonth()+1).toString().length <= 1)
    {

        month = '0'+(today.getMonth()+1);
    }
    else
    {
        month = (today.getMonth()+1)
    }

    if((today.getDate()).toString().length <= 1)
    {
        dateyear = '/0'+today.getDate()+'/'+today.getFullYear();

    }
    else
    {
        dateyear = '/'+today.getDate()+'/'+today.getFullYear();
    }

    $( "#datepicker_report1" ).datepicker({ dateFormat: 'yy-mm-dd' });
    $( "#datepickermax_report1" ).datepicker({ dateFormat: 'yy-mm-dd' });

    $('#datepicker_report1').val(month+dateyear);
    $('#datepickermax_report1').val(month+dateyear);

    $('#min_report1').val(yearmonth+date);
    $('#max_report1').val(yearmonth+date);

    $('.viewable_report1').click(function () {
        if($(this).is(":checked"))
        {
            if($(this).val() == 'All')
            {
                $('.viewable_report1#rad_all_report').prop('checked',true);
                // $('.viewable_report1#rad_all_pends').prop('checked',true);

                $('.date_range_conts_report').css('display','none');

                $('#min_report1').val('2015-01-01');
                $('#max_report1').val('6000-01-01');
                // search_where_option_fund = 'fund_requests.dispatcher_request_date';
            }
            else if($(this).val() == 'Date Range')
            {

                $('.viewable_report1#rad_daterange_report1').prop('checked',true);
                // $('.viewable_report1#rad_daterange_pends').prop('checked',true);

                $('.date_range_conts_report').css('display','');

                if((today.getDate()).toString().length <= 1)
                {
                    date = '-0'+today.getDate();
                }
                else
                {
                    date = '-'+today.getDate()
                }

                if((today.getMonth()+1).toString().length <= 1)
                {
                    yearmonth = today.getFullYear()+'-0'+(today.getMonth()+1);
                }
                else
                {
                    yearmonth = today.getFullYear()+'-'+(today.getMonth()+1);
                }

                var month;
                var dateyear;

                if((today.getMonth()+1).toString().length <= 1)
                {

                    month = '0'+(today.getMonth()+1);
                }
                else
                {
                    month = (today.getMonth()+1)
                }

                if((today.getDate()).toString().length <= 1)
                {
                    dateyear = '/0'+today.getDate()+'/'+today.getFullYear();

                }
                else
                {
                    dateyear = '/'+today.getDate()+'/'+today.getFullYear();
                }

                $( "#datepicker_report1" ).datepicker({ dateFormat: 'yy-mm-dd' });
                $( "#datepickermax_report1" ).datepicker({ dateFormat: 'yy-mm-dd' });

                $('#datepicker_report1').val(month+dateyear);
                $('#datepickermax_report1').val(month+dateyear);

                $('#min_report1').val(yearmonth+date);
                $('#max_report1').val(yearmonth+date);


                //pending

            }
        }

        if(activeTabCi == 'finishedCI')
        {
            if(finishedCI == true)
            {
                ciTable4Finished.draw();
            }
        }
        else if(activeTabCi == 'pendingCI')
        {
            if(pendingCI == true)
            {
                ciTable4Pending.draw();

            }
        }
    });

    $('#datepicker_report1').change( function() {
        var min = $.datepicker.formatDate('yy-mm-dd', $('#datepicker_report1').datepicker('getDate'));
        console.log(min);
        $('#min_report1').val(min);

        var max = $.datepicker.formatDate('yy-mm-dd', $('#datepickermax_report1').datepicker('getDate'));
        console.log(max);

        if(max === '')
        {
            $('#max_report1').val(yearmonth+date);

        }
        else {
            $('#max_report1').val(max);
        }
        ciTable4Finished.draw();
        ciTable4Pending.draw();
    });
    $('#datepickermax_report1').change( function() {

        var min = $.datepicker.formatDate('yy-mm-dd', $('#datepicker_report1').datepicker('getDate'));
        console.log(min);
        $('#min_report1').val(min);

        var max = $.datepicker.formatDate('yy-mm-dd', $('#datepickermax_report1').datepicker('getDate'));
        console.log(max);
        if(max === '')
        {
            $('#max_report1').val(yearmonth+date);

        }
        else {
            $('#max_report1').val(max);
        }

        if(activeTabCi == 'finishedCI')
        {
            if(finishedCI == true)
            {
                ciTable4Finished.draw();
            }
        }
        else if(activeTabCi == 'pendingCI')
        {
            if(pendingCI == true)
            {
                ciTable4Pending.draw();

            }
        }
    });


    // $('.viewable_report1#rad_all_report').prop('checked',true);

    $('.viewable_report1#rad_daterange_report1').prop('checked',true);

    pendingAcctsTable();

    $.ajax(
        {
            url: 'get-all-ci',
            type: 'get',
            success: function (data)
            {
                var i;
                var loopdata = '';
                var selectCIselect = '<select name="" id="selectedCIselect" class="form-control">';
                loopdata += '<option value="-">--</option>';

                for(i = 0; i <= (data.length - 1); i++)
                {
                    loopdata += '<option value="'+data[i].id+'">'+data[i].name+'</option>';
                }

                $('#selectedCI').html(selectCIselect +loopdata+'</select>');
            },
            complete:function ()
            {
                // selectCIMonTable();
            }
        }
    );

});

//================================================= LOADING OF TABS =============================================

$('.ci_supervisor_class').click(function ()
{
    var gethref = $(this).attr('href');
    console.log(gethref);

    if(gethref =='#ci_supervisor_dash')
    {
        if($(''+gethref+'').hasClass('active'))
        {
            console.log('do nothing');
            activeSide = 'ci_supervisor_dash';
        }
        else if(ci_supervisor_dash)
        {
            console.log('already loaded')
            activeSide = 'ci_supervisor_dash';
        }
        else if(ci_supervisor_dash == false)
        {
            ci_supervisor_dash = true;
            activeSide = 'ci_supervisor_dash';
            dash_map_init();
        }
    }
    else if(gethref == '#ci_supervisor_accounts')
    {
        if($(''+gethref+'').hasClass('active'))
        {
            console.log('do nothing');
            activeSide = 'ci_supervisor_accounts';
        }
        else if(ci_supervisor_accounts)
        {
            console.log('already loaded')
            activeSide = 'ci_supervisor_accounts';
        }
        else if(ci_supervisor_accounts == false)
        {
            ci_supervisor_accounts = true;
            activeSide = 'ci_supervisor_accounts';
        }
    }
    else if(gethref == '#ci_supervisor_realtime_fund')
    {
        if($(''+gethref+'').hasClass('active'))
        {
            console.log('do nothing');
            activeSide = 'ci_supervisor_realtime_fund';
        }
        else if(ci_supervisor_realtime_fund)
        {
            console.log('already loaded')
            activeSide = 'ci_supervisor_realtime_fund';
        }
        else if(ci_supervisor_realtime_fund == false)
        {
            ci_supervisor_realtime_fund = true;
            activeSide = 'ci_supervisor_realtime_fund';
            getAllRealtimeForCISup();
        }
    }
    else if(gethref == '#ci_supervisor_search_accounts')
    {
        if($(''+gethref+'').hasClass('active'))
        {
            console.log('do nothing');
            activeSide = 'search_acct';
        }
        else if(search_acct)
        {
            console.log('already loaded');
            activeSide = 'search_acct';
        }
        else if(search_acct == false)
        {
            search_acct = true;
            activeSide = 'search_acct';
            // endo_init();
        }
    }
    else if(gethref == '#ci_sup_fa_monitoring_tab')
    {
        var SetDate = new Date();
        var FullDate = (SetDate.getMonth() + 1) + '/' + SetDate.getDate() + '/' + SetDate.getFullYear();
        $('#ci_expense_range_start1').val(FullDate);
        // $('#ci_expense_range_start').val(SetDate.getFullYear() + '-' + SetDate.getMonth() + 1 + '-' + SetDate.getDate());
        // $('#ci_expense_range_end').val(SetDate.getFullYear() + '-' + SetDate.getMonth() + 1 + '-' + SetDate.getDate());
        $('#ci_expense_range_end1').val(FullDate);

        expenseStart = FullDate;
        expenseEnd= FullDate;
        faTablesCi();

        // console.log($(''+gethref+''));
        //
        // if($(''+gethref+'').hasClass('active'))
        // {
        //     console.log('do nothing');
        //     activeSide = 'ci_sup_fa_monitoring_tab';
        // }
        // else if(fa_mon)
        // {
        //     console.log('already loaded');
        //     activeSide = 'ci_sup_fa_monitoring_tab';
        // }
        // else if(fa_mon == false)
        // {
        //     console.log('done');
        //     fa_mon = true;
        //     activeSide = 'ci_sup_fa_monitoring_tab';
        //     faTablesCi();
        // }
    }
});

var coltittle3 = [];
var col_count3 = 0;

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
        // "ajax": "/finance-ci-fund-request-table-fa",
        "ajax":
            {
                // "type" : 'GET',
                "url": "/finance-ci-fund-request-table-fa",
                "data": function (d)
                {


                    var start = $('#ci_expense_range_start1').val();
                    var end =  $('#ci_expense_range_end1').val();


                    console.log([start, end]);


                    d.start_q = start;
                    d.end_q = end;
                    // d.max_date_endorsed = $('#max_report').val();
                }
            },
        "columns":
            [
                {data: 'id', name: 'fund_requests.id'},
                {data : 'archi', name : 'archipelagos.archipelago_name'},
                {data: 'address_edit', name: 'endorsements.address'},
                {data: 'name_ci', name: 'ci_id.name'},
                {
                    data : function dates(data)
                    {
                        if(data.tor == 'NORMAL REQUEST')
                        {
                            if(parseInt(atob(data.amount)) >= 2500)
                            {
                                return data.dispatcher_request_date;
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

                        var reqrem = '';
                        if(data.tor == 'NORMAL REQUEST')
                        {
                            reqrem = data.dispatcher_remarks+'||==||'+data.name_disp;
                            req= '';
                        }
                        else if(data.tor == 'EMERGENCY FUND')
                        {
                            reqrem = data.sao_remarks+'||==||'+data.name_sao;
                            req = '<button class="btnViewManagementRem btn btn-block btn-sm btn-danger" style="width : 100%" name = "'+data.rem_manage+'||==||'+data.manage_name+'"><i class = "fa fa-fw fa-info-circle"></i> View Management Remarks</button>';
                        }

                        return '<button type = "button" class = "btn_view_ci_liq btn btn-sm btn-primary btn-block" name = '+ data.id +'><i class = "fa fa-fw fa-file-image-o"></i>View C.I Liquidation Info</button>' +
                            '<button class = "btn-xs btn-block btn-primary" name = "'+data.id+'" id = "check_remarks_requestor">View Requestor Remarks</button>' +
                            req+
                            '<button class="audit_finance_logs btn btn-xs btn-block btn-info" id="'+data.id+'" data-toggle="modal" data-target="#modal-view-audit-review-rem">View Logs</button>';
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

// $('.ciAccountsMon').click(function ()
// {
//     var gethref = $(this).attr('href');
//
//     if(gethref == '#unangtab')
//     {
//         if($(''+gethref+'').hasClass('active'))
//         {
//             console.log('do nothing');
//             activeTabCi = 'pendingCI';
//         }
//         else if(pendingCI)
//         {
//             console.log('already loaded');
//             activeTabCi = 'pendingCI';
//         }
//         else if(pendingCI == false)
//         {
//             pendingCI = true;
//             activeTabCi = 'pendingCI';
//             pendingAcctsTable();
//         }
//     }
//     else if(gethref == '#pangalawangtab')
//     {
//         if($(''+gethref+'').hasClass('active'))
//         {
//             console.log('do nothing');
//             activeTabCi = 'finishedCI';
//         }
//         else if(finishedCI)
//         {
//             console.log('already loaded');
//             activeTabCi = 'finishedCI';
//         }
//         else if(finishedCI == false)
//         {
//             finishedCI = true;
//             activeTabCi = 'finishedCI';
//             finishedAcctsTable();
//         }
//     }
//     else if(gethref == '#pangatlongtab')
//     {
//         if($(''+gethref+'').hasClass('active'))
//         {
//             console.log('do nothing');
//             activeTabCi = 'realtimeFund';
//         }
//         else if(realtimeFund)
//         {
//             console.log('already loaded');
//             activeTabCi = 'realtimeFund';
//         }
//         else if(realtimeFund == false)
//         {
//             realtimeFund = true;
//             activeTabCi = 'realtimeFund';
//             realtimeTable();
//         }
//     }
// });

$('.ciAccountsMon').click(function ()
{
    var gethref = $(this).attr('href');

    if(gethref == '#unangtab')
    {
        $('#date_range_for_hided').show();
        if($(''+gethref+'').hasClass('active'))
        {
            console.log('do nothing');
            activeTabCi = 'pendingCI';
        }
        else if(pendingCI)
        {
            // ciTable4Finished.draw();
            console.log('already loaded');
            activeTabCi = 'pendingCI';
        }
        else if(pendingCI == false)
        {
            pendingCI = true;
            activeTabCi = 'pendingCI';
            pendingAcctsTable();
        }
    }
    else if(gethref == '#pangalawangtab')
    {
        $('#date_range_for_hided').show();

        if($(''+gethref+'').hasClass('active'))
        {
            console.log('do nothing');
            activeTabCi = 'finishedCI';
        }
        else if(finishedCI)
        {
            // ciTable4Pending.draw();
            console.log('already loaded');
            activeTabCi = 'finishedCI';
        }
        else if(finishedCI == false)
        {
            finishedCI = true;
            activeTabCi = 'finishedCI';
            finishedAcctsTable();
        }
    }
    else if(gethref == '#pangatlongtab')
    {
        $('#date_range_for_hided').hide();
    }
});

//================================================================================================================

// function selectCIMonTable(){
//
//     $('#selectedCIselect').change(function ()
//     {
//         console.log('test2');
//
//         $('#table-overlay').show();
//         ciID = $(this).children("option:selected").val();
//         realtimeTable();
//
//
//         if(ciID === '-')
//         {
//             $('#hide_when_no_ci').fadeOut();
//         }
//         else if(ciID !== '-' && $.isNumeric(ciID))
//         {
//             $('#hide_when_no_ci').fadeIn();
//
//             if(activeTabCi == 'finishedCI')
//             {
//                 if(finishedCI == true)
//                 {
//                     ciTable4Finished.draw();
//                 }
//             }
//             else if(activeTabCi == 'pendingCI')
//             {
//                 if(pendingCI == true)
//                 {
//                     ciTable4Pending.draw();
//
//                 }
//             }
//         }
//
//         setTimeout(function()
//         {
//             $('#table-overlay').hide();
//         }, 1000);
//     });
// }

function refresh_finish() {
    ciTable4Finished.draw();
}

function finishedAcctsTable()
{
    ciTable4Finished = $('#ciFinishedAccounts').DataTable(
        {
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "ajax":
                {
                    url: 'get-all-finished',
                    data: function(b)
                    {
                        b.id = ciID;
                        b.min_date_endorsed = $('#min_report1').val();
                        b.max_date_endorsed = $('#max_report1').val();
                    }
                },
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
                            return ' <a name="' + data.id + '" class="btn btn-xs btn-block btn-primary" id="btnOtherInfo" data-toggle="modal" data-target="#otherInfo"><i class="glyphicon glyphicon-search"></i> View Information</a>' +
                                '<a href="dl-rep?code='+btoa(data.id)+'&code2=bankv2" target="_blank" class="btn btn-xs btn-block btn-success">Download Report</a>';

                        },
                        "orderable": false,
                        "searchable": false,
                        "name": 'Coborrower/Addresses',
                        "autoWidth": false
                    }
                ],
            "order": [[0, 'desc']],
            "pageLength": 10,
            "bSortClasses": false,
            "autoWidth": false,
            dom: 'Blfrtip',
            buttons:
                [
                    {
                        extend: 'excelHtml5',
                        exportOptions:
                            {
                                columns: ':visible:not(:last-child)'
                            }
                    },
                    {
                        text: 'Refresh',
                        action: function ()
                        {
                            refresh_finish();
                        }
                    },
                    {
                        extend: 'colvis',
                        text: 'Show/Hide Column'
                    }
                ],
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

    $('#ciFinishedAccounts_filter input').unbind();
    $('#ciFinishedAccounts_filter input').bind('keyup change', function(e)
    {
        if($(this).is(':focus'))
        {
            if (e.keyCode == 13) {
                ciTable4Finished.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '') {
                    ciTable4Finished.search($(this).val()).draw();
                }
            }
        }
    });
}

function refresh_pending() {
    ciTable4Pending.draw();
}

function pendingAcctsTable()
{
    ciTable4Pending = $('#ciPendingAccounts').DataTable(
        {
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "ajax":
                {
                    url: 'get-all-pending',
                    data: function(a)
                    {
                        a.id = ciID;
                        a.min_date_endorsed = $('#min_report1').val();
                        a.max_date_endorsed = $('#max_report1').val();
                    }
                },

            "columns":
                [
                    {data: 'id', name: 'endorsements.id'},
                    {data: 'account_name', name: 'endorsements.account_name'},
                    {data: 'tat', name: 'endorsements.time_due'},
                    {data: 'client_name', name: 'endorsements.client_name'},
                    {data: 'type_of_request', name: 'endorsements.type_of_request'},
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
                    }
                ],
            "order": [[0, 'desc']],
            "pageLength": 10,
            "bSortClasses": false,
            "autoWidth": false,
            dom: 'Blfrtip',
            buttons:
                [
                    {
                        extend: 'excelHtml5',
                        exportOptions:
                            {
                                columns: ':visible:not(:last-child)'
                            }
                    },
                    {
                        text: 'Refresh',
                        action: function ()
                        {
                            refresh_pending();
                        }
                    },
                    {
                        extend: 'colvis',
                        text: 'Show/Hide Column'
                    }
                ],
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

    $('#ciPendingAccounts_filter input').unbind();
    $('#ciPendingAccounts_filter input').bind('keyup change', function(e)
    {
        if($(this).is(':focus'))
        {
            if (e.keyCode == 13) {
                ciTable4Pending.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '') {
                    ciTable4Pending.search($(this).val()).draw();
                }
            }
        }
    });
}

function realtimeTable()
{
    $.ajax(
        {
            type:'get',
            url: 'ci-sup-get-all-realtime',
            data: {
                'id' : ciID
            },
            success: function(data)
            {
                if(data[0][0] == null || data[1][0] == null)
                {
                    $('#realtimeFundtable').html('<tr>\n' +
                        '                                                                <th colspan="4">ID</th>\n' +
                        '                                                                <th colspan="4">NAME</th>\n' +
                        '                                                                <th colspan="4">REMAINING FUND</th>\n' +
                        '                                                            </tr>\n' +
                        '                                                            <tr>\n' +
                        '                                                                <td colspan="4">'+data[1][0].id+'</td>\n' +
                        '                                                                <td colspan="4">'+data[1][0].name+'</td>\n' +
                        '                                                                <td colspan="4">0</td>\n' +
                        '                                                            </tr>');
                }
                else
                {
                    $('#realtimeFundtable').html('<tr>\n' +
                        '                                                                <th colspan="4">ID</th>\n' +
                        '                                                                <th colspan="4">NAME</th>\n' +
                        '                                                                <th colspan="4">REMAINING FUND</th>\n' +
                        '                                                            </tr>\n' +
                        '                                                            <tr>\n' +
                        '                                                                <td colspan="4">'+data[1][0].id+'</td>\n' +
                        '                                                                <td colspan="4">'+data[1][0].name+'</td>\n' +
                        '                                                                <td colspan="4">'+data[0][0].fund_realtime+'</td>\n' +
                        '                                                            </tr>');
                }
            }
        }
    );
}

// function cipendingtable()
// {
//     ciTable4Pending = $('#ciPendingAccounts').DataTable(
//         {
//             "responsive": true,
//             "processing": true,
//             "serverSide": true,
//             "ajax":
//                 {
//                     url: 'get-all-pending',
//                     data: function(a)
//                     {
//                         a.id = ciID
//                     }
//                 },
//             "columns":
//                 [
//                     {data: 'id', name: 'endorsements.id'},
//                     {data: 'account_name', name: 'endorsements.account_name'},
//                     {data: 'tat', name: 'endorsements.time_due'},
//                     {data: 'client_name', name: 'endorsements.client_name'},
//                     {data: 'type_of_request', name: 'endorsements.type_of_request'},
//                     {
//                         data: function actions(data) {
//                             var todisp = '';
//
//                             if (data.subjnames == 'NONE') {
//                                 todisp = data.subjcoob;
//                             }
//                             else {
//                                 todisp = data.subjcoob + '\n<b>(' + data.subjnames + ')</b>';
//                             }
//
//                             return todisp;
//                         },
//                         "orderable": false,
//                         "searchable": false,
//                         "name": 'type_of_subjects.type_of_subject_name',
//                         "autoWidth": false
//                     },
//                     {data: 'verify_through', name: 'endorsements.verify_through'},
//                     {data: 'client_remarks', name: 'endorsements.client_remarks'},
//                     {data: 're_ci', name: 'endorsements.re_ci'},
//                     {
//                         data: function actions(data) {
//
//                             return ' <a name="' + data.id + '" class="btn btn-xs btn-block btn-primary" id="btnOtherInfo" data-toggle="modal" data-target="#otherInfo"><i class="glyphicon glyphicon-search"></i> View Information</a>';
//
//                         },
//                         "orderable": false,
//                         "searchable": false,
//                         "name": 'Coborrower/Addresses',
//                         "autoWidth": false
//                     }
//                 ],
//             "order": [[0, 'desc']],
//             "pageLength": 10,
//             "bSortClasses": false,
//             "autoWidth": false
//         });
// }
//
// function cifinishedtable()
// {
//     ciTable4Finished = $('#ciFinishedAccounts').DataTable(
//         {
//             "responsive": true,
//             "processing": true,
//             "serverSide": true,
//             "ajax":
//                 {
//                     url: 'get-all-finished',
//                     data: function(b)
//                     {
//                         b.id = ciID
//                     }
//                 },
//             "columns":
//                 [
//                     {data: 'id', name: 'endorsements.id'},
//                     {data: 'account_name', name: 'endorsements.account_name'},
//                     {
//                         data: function (data) {
//
//                             var status = '';
//
//                             if(data.endorsement_status_internal == 'TAT')
//                             {
//                                 status = '<small class="label bg-green">ON TAT</small>';
//                             }
//                             else if (data.endorsement_status_internal == 'OVERDUE')
//                             {
//                                 status = '<small class="label bg-black">OVERDUE</small>';
//                             }
//                             else
//                             {
//                                 status = '<small class="label bg-black">UNDECLARED</small>';
//                             }
//
//                             return data.ci_internal_status+' '+status;
//
//                         },
//                         'name': 'endorsements.endorsement_status_internal'
//                     },
//                     {data: 'client_name', name: 'endorsements.client_name'},
//                     {data: 'type_of_request', name: 'endorsements.type_of_request'},
//                     {
//                         data: function actions(data) {
//                             var todisp = '';
//
//                             if (data.subjnames == 'NONE') {
//                                 todisp = data.subjcoob;
//                             }
//                             else {
//                                 todisp = data.subjcoob + '\n<b>(' + data.subjnames + ')</b>';
//                             }
//
//                             return todisp;
//                         },
//                         "orderable": false,
//                         "searchable": false,
//                         "name": 'type_of_subjects.type_of_subject_name',
//                         "autoWidth": false
//                     },
//                     {data: 'verify_through', name: 'endorsements.verify_through'},
//                     {data: 'client_remarks', name: 'endorsements.client_remarks'},
//                     {data: 're_ci', name: 'endorsements.re_ci'},
//                     {
//                         data: function actions(data) {
//                             return ' <a name="' + data.id + '" class="btn btn-xs btn-block btn-primary" id="btnOtherInfo" data-toggle="modal" data-target="#otherInfo"><i class="glyphicon glyphicon-search"></i> View Information</a>';
//
//                         },
//                         "orderable": false,
//                         "searchable": false,
//                         "name": 'Coborrower/Addresses',
//                         "autoWidth": false
//                     }
//                 ],
//             "order": [[0, 'desc']],
//             "pageLength": 10,
//             "bSortClasses": false,
//             "autoWidth": false
//         });
// }
//
// function cirealtimetable()
// {
//     $.ajax(
//         {
//             type:'get',
//             url: 'ci-sup-get-all-realtime',
//             data: {
//                 'id' : ciID
//             },
//             success: function(data)
//             {
//                 if(data[0][0] == null || data[1][0] == null)
//                 {
//                     $('#realtimeFundtable').html('<tr>\n' +
//                         '                                                                <th colspan="4">ID</th>\n' +
//                         '                                                                <th colspan="4">NAME</th>\n' +
//                         '                                                                <th colspan="4">REMAINING FUND</th>\n' +
//                         '                                                            </tr>\n' +
//                         '                                                            <tr>\n' +
//                         '                                                                <td colspan="4">'+data[1][0].id+'</td>\n' +
//                         '                                                                <td colspan="4">'+data[1][0].name+'</td>\n' +
//                         '                                                                <td colspan="4">0</td>\n' +
//                         '                                                            </tr>');
//                 }
//                 else
//                 {
//                     $('#realtimeFundtable').html('<tr>\n' +
//                         '                                                                <th colspan="4">ID</th>\n' +
//                         '                                                                <th colspan="4">NAME</th>\n' +
//                         '                                                                <th colspan="4">REMAINING FUND</th>\n' +
//                         '                                                            </tr>\n' +
//                         '                                                            <tr>\n' +
//                         '                                                                <td colspan="4">'+data[1][0].id+'</td>\n' +
//                         '                                                                <td colspan="4">'+data[1][0].name+'</td>\n' +
//                         '                                                                <td colspan="4">'+data[0][0].fund_realtime+'</td>\n' +
//                         '                                                            </tr>');
//                 }
//             }
//         }
//     );
// }

$('#ciPendingAccounts').on('click', '#btnOtherInfo', function () {
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
                console.log('data empty');
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
                    console.log('hide');
                    $('#divNotes').hide();
                }
                else {
                    $('#divNotes').show();
                }

                $('#viewRemarks').val('');
                $('#viewNotes').val('');
                $('#viewRemarks').val(data[4][0].client_remarks);
                // $('#viewNotes').val(data[5][0].endorsement_note);

            }
        }
    })
});

$.ajax(
    {
        type: 'get',
        url: 'ci-sup-get-all-realtimeFund',
        success: function(data)
        {

        }
    }
);

function getAllRealtimeForCISup()
{
    $('#ciGetAllrealtime thead th').each(function () {
        table_realtime_funds[title_realtime_funds_counts] = $(this).text();
        title_realtime_funds_counts++;
        var title = $(this).text();
        $(this).html(title+'<br><input type="text" placeholder="Search" style="position: relative; width: 100%;"> ')
    });

    table_realtime_funds = $('#ciGetAllrealtime').DataTable
    ({
        "responsive" : true,
        "processing" : true,
        "serverSide" : true,
        "ajax" : 'ci-sup-get-all-realtimeFund',

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
                                        return title_realtime_funds[(idx)];
                                    },
                                    body: function (data, row, column)
                                    {
                                        if(column <= 7)
                                        {
                                            return data.replace(/<br\s*\/?>/ig, "\r\n")
                                        }
                                        else
                                        {

                                        }
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
                        return title_realtime_funds[(idx)];
                    }
                }
            ],
        "columns":
            [
                {data: 'id', name: 'users.id'},
                {data: 'name',name: 'users.name'},
                {
                    data: function action(data)
                    {
                        if(data.fund_realtime == null)
                        {
                            return 0;
                        }
                        else
                        {
                            return data.fund_realtime;
                        }
                    },
                    'name' : 'ci_fund_realtime_amount.fund_realtime',
                    'searchable' : false,
                    'orderable' : true
                }
                // {data: 'fund_realtime', name: 'ci_fund_realtime_amount.fund_realtime'}
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

    $('#ciGetAllrealtime_filter input').unbind();
    $('#ciGetAllrealtime_filter input').bind('keyup change', function(e)
    {
        if($(this).is(':focus'))
        {
            if (e.keyCode == 13) {
                table_realtime_funds.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '') {
                    table_realtime_funds.search($(this).val()).draw();
                }
            }
        }
    });
}

function ciList()
{
    $.ajax
    ({
        type : 'get',
        url : 'ci-supp-get-ci-list',
        success : function(data)
        {
            var h;
            var optionCiData ='';

            for(h = 0; h < data.length; h++)
            {
                optionCiData += '<option value = "'+data[h].id+'">'+data[h].name+'</option>'
            }
            $('#ci_selected_fund').html('<option value = "">--</option>' + optionCiData);


        }
    })
}

$('#selectedCIArchipelago').change(function()
{
    var value = $(this).val();


    if($(this).find(':selected').val() != '')
    {
        $('#selectedCIselect').html('');
          $.ajax
          (
            {
                url: 'get-all-ci',
                type: 'get',
                success: function (data)
                {
                    // console.log(data);
                    var i = 0;
                    var testarray = [];
                    var array_ctr = 0;
                    var loopdata = '';
                    // var selectCIselect = '<select name="" id="selectedCIselect" class="select2 form-control">';
                    loopdata += '<option value="-">--</option>';

                    for(i = 0; i < data.length; i++)
                    {

                        if(value == data[i].archipelago_name)
                        {
                            testarray[array_ctr] = value + ' / ' +  data[i].archipelago_name + ' / ' + data[i].name;
                            array_ctr++;
                            loopdata += '<option value="'+data[i].id+'" name="'+data[i].archipelago_name+'">'+data[i].name+'</option>';
                        }
                    }
                    console.log([i, testarray]);

                    $('#selectedCIselect').html(loopdata);
                },
                complete:function ()
                {
                    $('#ciListSelection').show();
                    $('#hide_when_no_ci').fadeOut();
                }
            }
        );
    }
    else
    {
        $('#selectedCIselect').html('');
        $('#ciListSelection').hide();
        $('#hide_when_no_ci').fadeIn();
    }
});

$('#selectedCIselect').change(function ()
{

    console.log('test1');
    $('#rad_daterange_report').prop('checked', true);
    pendingAcctsTable();

    ciID = $(this).children("option:selected").val();

    if(ciID === '-')
    {
        $('#hide_when_no_ci').fadeOut();
    }
    else if(ciID !== '-' && $.isNumeric(ciID))
    {
        realtimeTable();
        $('#table-overlay').show();
        $('#hide_when_no_ci').show();

        if(activeTabCi == 'finishedCI')
        {
            if(finishedCI == true)
            {
                ciTable4Finished.draw();
            }
        }
        else if(activeTabCi == 'pendingCI')
        {
            if(pendingCI == true)
            {
                ciTable4Pending.draw();

            }
        }
    }

    setTimeout(function()
    {
        $('#table-overlay').hide();
    }, 1000);
});

$('#table-finance-expenses-report').on('click','#check_remarks_requestor',function ()
{
    //for online upload success

    $('#req_rem_remarks').val('');
    $('#dispatcher_req_name').val('');
    $('#modal-req-rem').modal('show');

    var id = $(this).attr('name');

    // console.log(id);

    $.ajax({
        url : 'finance_fund_get_requestor_remarks',
        type : 'get',
        data : {
            'id' : id
        },
        success : function(data)
        {

            console.log(data);

            var get_remarks_text = '';
            var get_remarks_name = '';

            if(data[0].manage_id == 0 || data[0].manage_id == null) //normal request
            {
                get_remarks_text = data[0].disp_remarks;
                get_remarks_name = data[0].disp_name;
            }
            else
            {
                get_remarks_text = data[0].sao_remarks;
                get_remarks_name = data[0].sao_name;
            }

            $('#dispatcher_req_name').text(get_remarks_name);
            $('#req_rem_remarks').val(get_remarks_text);
        },
        error : function () {
            console.log('error');
        }
    });
});

$('#table-finance-expenses-report').on('click', '.btn_view_ci_liq', function()
{
    $('#insertCiImgLiq').html('');
    $('.clicked_modify').hide();
    $('.hidemuna').hide();
    $('#finance_ci_liq_remssss').val('');
    $('.show_modify').show();
    fundIDliq = $(this).attr('name');
    // console.log(fundIDliq);

    $('#modal-view-ci-liq-img').modal('show');

    $.ajax
    ({
        type : 'get',
        url : 'finance-get-img-liq-fund',
        data :
            {
                'id'  : fundIDliq
            },
        success : function(data)
        {
            console.log(data);
            var i;
            var imdDiv = '';
            var remIndicate = '';
            var u;
            var m;
            var outImgdiv = '';
            var indivRemarks = '';
            $('#ci_req_amount').val('₱ '+data[9]);
            $('#ci_req_amount_check').val(data[9]);

            for (u = 0; u < data[3].length; u++)
            {
                var pathToLoop = data[3][u].split('|');

                for(m = 0; m < (pathToLoop.length -1); m++)
                {
                    extensionCheck = pathToLoop[m].split('.');
                    var extHolder = extensionCheck.pop();
                    var pathtoLook = btoa(pathToLoop[m]);
                    if(extHolder == 'jpg' || extHolder == 'jpeg' || extHolder == 'png')
                    {
                        imdDiv +=
                            '                                                <div class = "col-md-3" style = "border: 1px solid; padding-left : 8px; padding-right : 5px; padding-bottom : 5px; padding-top : 5px;">\n' +
                            '                                                    <a href="getuploaded/' + data[0][m] + '/ '+pathtoLook+'" target="_blank">' +
                            '                                                    <img src = "getuploaded/' + data[0][m] + '/'+pathtoLook+'" style = "height: 200px; width : 200px; border : solid black 1px; ">' +
                            '                                                    </a>' +
                            '                                               </div>\n';
                    }
                    else
                    {
                        imdDiv +=
                            '                                                <div class = "col-md-3" style = "border: 1px solid; padding-left : 8px; padding-right : 5px; padding-bottom : 5px; padding-top : 5px;">\n' +
                            '                                                    <a href="getuploaded-2/' + data[0][m] + '/ '+pathtoLook+'" target="_blank">' +
                            '                                                    <img src = "dist/img/downloadIconnn (2).png" style = "height: 200px; width : 200px; border : solid black 1px; ">' +
                            '                                                    </a>' +
                            '                                               </div>\n';
                    }
                }

                indivRemarks = '<div class = "row" style = "padding-bottom : 20px;">' +
                    '<div class = "col-md-1"></div>' +
                    '<div class = "col-md-10">' +
                    '<label for="">Account Remarks</label>' +
                    '<textarea id="" class = "form-control" rows="2" placeholder= "No Remarks" disabled>' +
                    '' + data[1][u][1] + '</textarea>' +
                    '<label for="">Expenses</label>' +
                    '<input type="number" class="form-control clicked_modify_val" value="'+atob(data[8][u])+'" name="'+data[10][u]+'" disabled></div>' +
                    '<div class = "col-md-1"></div></div>';

                outImgdiv += '<div class = "row" style = "padding-bottom : 20px;">' +
                    '<div class = "col-md-12">' +
                    '<div class = "box box-warning">' +
                    '<h5 style = "text-align: center; color: midnightblue">ENDORSE ACCOUNT NAME: </h5>' +
                    '<h5 style = "text-align: center">' + data[1][u][2] + '</h5>' +
                    '<div class = "row" style = "padding-bottom : 20px;">' +
                    '<div class = "col-md-12">' +
                    ''+ imdDiv +' </div>' +
                    '</div>'+indivRemarks+'</div></div></div>';

                $('#insertCiImgLiq').append(outImgdiv);

                imdDiv = '';
                outImgdiv = '';


            }

            $('#liq_date_rev').html(data[7].datetime);
            // $('#insertCiImgLiq').

            if(data != '')
            {
                for (i = 0; i < data[0].length; i++)
                {

                }

            }
            if(data[2] != '')
            {
                $('#insertCILiqRemarks').val(data[2]);
                $('.hidemuna').show();
            }
            else
            {
                $('.hidemuna').hide();
                $('#insertCILiqRemarks').val('');
                $('#insertCILiqRemarks').attr('placeholder', 'NO INDICATED REMARKS.....');
            }
        }
    })
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

$('#table-finance-expenses-report').on('click', '.audit_finance_logs', function()
{
    $('#view_remarksSpan').html();
    viewAuditRemarks($(this).attr('id'));
});

function viewAuditRemarks(id)
{
    $.ajax({
        type: 'get',
        url: 'finance_get_audit_remarks',
        data: {
            'id' : id
        },
        success: function(data)
        {
            console.log(data);

            if(data == '')
            {
                $('#view_remarksSpan').html('<table class="table-hover" width="100%">\n' +
                    '<tr style="background-color: black; color:white; text-align: left">\n' +
                    '<th>Name</th>\n' +
                    '<th>Date / Time Occured</th>\n' +
                    '<th>Activity / Logs</th>\n' +
                    '</tr>\n' +
                    '<tr>\n' +
                    '<td colspan="3">No Available Records</td>\n' +
                    '</tr>\n' +
                    '</table>');
            }
            else
            {
                var dataTable = '';
                var tableHead = '<table class="table-hover" width="100%">\n' +
                    '                                <tr style="background-color: black; color:white; text-align: left">\n' +
                    '                                    <th>Name</th>\n' +
                    '                                    <th>Date / Time Occured</th>\n' +
                    '                                    <th>Activity / Logs</th>\n' +
                    '                                </tr>';

                for(var i = 0;i < data[0].length; i++)
                {
                    dataTable += '<tr>\n' +
                        '    <td>' + data[0][i].name + '</td>\n' +
                        '    <td>' + data[0][i].date_time + '</td>\n' +
                        '    <td>' + data[0][i].activity + '</td>\n' +
                        '</tr>';
                }

                $('#view_remarksSpan').html(tableHead + dataTable + '</table>');
            }

        }
    });
}