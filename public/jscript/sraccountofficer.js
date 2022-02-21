/**
 * Created by aa on 9/21/2017.
 */
var tableFundRequest;
var tableFundSuccess;
var tableFundDisapproved;
var tableFundCancelled;
var tablee;
var table;
var tableee;
var tableRevision;
var table_sao_audit;
var table_ci_fund;
var table_ci_fund_app;
var table_ci_fund_dec;
var table_ci_account_report;
var toastr;
var id;
var dateEndorsed;
var timeEndorsed;
var aoID;
var acctID;
var aoIDToTransfer;
var times;
var verAdd;

var revision_id;

var title_header_ci_report = [];
var audit_header = [];

var refreshertab1 = true;
var refreshertab2 = false;
var refreshertab3 = false;
var refreshertab4 = false;
var refreshertab5 = false;

var assign_click1 = true;
var assign_click2 = false;
var assign_click3 = false;
var assign_click4 = false;
var assign_click5 = false;

var dash_sao = false;
var accounts_sao = true;
var fund_sao = false;
var search_acct = false;
var audit_sao = false;
var unliq_em_sao = false;
var sao_fa_bool = false;
var which_is_active = 'account_process';

var search_where_option_fund = '';

var table_fund_endorsed_no_fund;

var titleee_no_fund_endorse = [];
var i_no_fund = 0;
var ciIdUnliqHold;

var table_fund_hold;
var titleee_hold_fund = [];
var i_hold_fund = 0;
var checkifOpenUnliqFundReq = false;
var checkFundIUnliqopen = false;
var unliqCiAmount;
var holdCiAmount;
var refreshApp = false;
var refreshDec = false;

var approvalId;

var table_logs_thead = [];
var logsCountFund = 0;
var table_fund_logs_sao;

var tableFundFa;
var coltittle3 = [];
var col_count3 = 0;
var expenseStart = '';
var expenseEnd = '';

var tableSraAssignAr = [];
var sra_count = 0;
var today = new Date();



$.ajaxSetup
({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

// function fetchOtherInro(whattable,array_tr) {
//     times = setTimeout(function (){
//
//         var countid = 0;
//         var getitds = [];
//         var gettors = [];
//         var tab = document.getElementById(whattable);
//         var n = tab.rows.length;
//         var i, tr, tdid, tdtor;
//
//         for (i = 1; i < n; i++) {
//             tr = tab.rows[i];
//             if (tr.cells.length > 0)
//             {
//                 tdid = tr.cells[0];
//                 tdtor = tr.cells[array_tr];
//
//                 if(tr.cells[0].innerText === "No data available in table")
//                 {
//                     n = -1;
//                 }
//                 else{
//                     getitds[countid] = tdid.innerText;
//                     gettors[countid] = tdtor.innerText;
//                     countid ++;
//                 }
//             }
//         }
//
//         for(var ctr = 0; ctr < getitds.length-1; ctr++)
//         {
//
//             if(gettors[ctr] === 'EVR')
//             {
//
//                 $.ajax({
//                     url: '/gen-get-tor-other-evr',
//                     type: 'GET',
//                     data:
//                         {
//                             'id': getitds[ctr]
//                         },
//                     success: function (data) {
//                         infoevr = data[0].employer_name;
//                         console.log('processing');
//
//                         $('#otherinfo' + data[0].endorsement_id + '').html('<b>EVR :</b> <br>' + infoevr);
//                     },
//                     error: function () {
//                         console.log('error');
//                     }
//                 });
//             }
//             else if(gettors[ctr] === 'BVR')
//             {
//
//
//                 $.ajax({
//                     url: '/gen-get-tor-other-bvr',
//                     type: 'GET',
//                     data:
//                         {
//                             'id': getitds[ctr].toString()
//                         },
//                     success: function (data) {
//                         infoevr = data[0].business_name;
//                         $('#otherinfo' + data[0].endorsement_id + '').html('<b>BVR :</b> <br>' + infoevr);
//                     },
//                     error: function () {
//                         console.log('error');
//                     }
//                 });
//             }
//             else if(gettors[ctr] === 'PDRN')
//             {
//
//
//                 $('#otherinfo' + getitds[ctr].toString() + '').html('<b>PDRN</b>');
//
//             }
//         }
//
//     },2000);
// }


$(document).ready(function()
{

    // fetchOtherInro('endorsement-tablee',4);


    $('#chat_for_sao_dispa').removeAttr('hidden');
    $('#showAmountAssignCi').hide();
    $('#showtableFundHold').hide();
    $('#btnEmergencyFundCi').hide();
    $('#submitAmtforCiUnliqHold').hide();
    $('#showSaoRemUnliq').hide();
    $('#closeInputFundAmt').hide();

    $.ajax({
        url: '/srao-get-ao-counts',
        type: 'GET',
        success: function (data)
        {

            // console.log('ao: '+data);

            var getaos = '';
            var img = 'avatar/.png';
            console.log(data);
            for(var ctr=0; ctr<parseInt(data[2]); ctr++){
                getaos += '<option value=" '+data[1][ctr]+'">'+data[0][ctr]+'</option>';
//<img src="avatar/.png">
            }
            $('#aoID').html(getaos);

        }
    });



    $('#table_fund_req thead th').each(function() {
        var title = $(this).text();

        if(title != '')
        {
            $(this).html(title+'<br><input type="text" placeholder="Search" style="position: relative; width: 100%">');

        }
        if(title == 'AMOUNT')
        {
            return false;
        }

    });

    $('#table_fund_req_approved thead th').each(function() {
        var title = $(this).text();

        if(title != '')
        {
            $(this).html(title+'<br><input type="text" placeholder="Search" style="position: relative; width: 100%">');

        }
        if(title == 'AMOUNT')
        {
            return false;
        }
    });

    $('#table_fund_req_declined thead th').each(function() {
        var title = $(this).text();

        if(title != '')
        {
            $(this).html(title+'<br><input type="text" placeholder="Search" style="position: relative; width: 100%">');

        }
        if(title == 'AMOUNT')
        {
            return false;
        }

    });

    $('#endorsement-tablee thead th').each(function()
    {
        tableSraAssignAr[sra_count] = $(this).text();
        sra_count++;
        var title = $(this).text();
        $(this).html(title+'<br><input type="text" placeholder="Search" style="position: relative; width: 100%">');
    });

    tablee = $('#endorsement-tablee').DataTable
    (
        {
            dom: 'Blfrtip',
            buttons:
                [
                    {
                        extend: 'excel',
                        title : 'Assigning of Accounts',
                        exportOptions:
                            {
                                columns: ':visible',
                                format:
                                    {
                                        header: function (dt, idx, title) {
                                            return tableSraAssignAr[(idx)];
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
                            return tableSraAssignAr[(idx)];
                        }
                    }
                ],
            "responsive": true,
            "processing": true,
            "serverSide": true,
            // "ajax": "/srao-fetch-endorsement",
            "ajax":
                {
                    url: "/srao-fetch-endorsement",
                    data: function (d)
                    {
                        d.min_date_endorsed = $('#sao_assign_min').val();
                        d.max_date_endorsed = $('#sao_assign_max').val();
                        d.search_methodd = $('input[name="sao_assign_rad"]:checked').val();
                    }
                },
            "columns":
                [
                    {data: 'id', name: 'endorsements.id'},
                    {data: 'date_endorsed', name: 'endorsements.date_endorsed'},
                    {data: 'time_endorsed', name: 'endorsements.time_endorsed'},
                    {data: 'date_due', name: 'endorsements.date_due'},
                    {data: 'time_due', name: 'endorsements.time_due'},
                    {data: 'account_name', name: 'endorsements.account_name'},
                    {data: 'type_of_request', name: 'endorsements.type_of_request'},
                    // {
                    //
                    //     data: function actions(data) {
                    //
                    //         clearTimeout(times);
                    //         fetchOtherInro('endorsement-tablee',4);
                    //         return '<span id="otherinfo'+data.id+'">'+data.type_of_request+'</span>';
                    //
                    //     },
                    //     'name' : 'endorsements.type_of_request'
                    // },
                    {data: 'type_of_loan', name: 'endorsements.type_of_loan'},
                    {data: 'client_name', name: 'endorsements.client_name'},
                    {data: 're_ci', name: 'endorsements.re_ci'},
                    {data: 'muni_name', name: 'municipalities.muni_name', "className": "text-center"},
                    {data: 'name', name: 'provinces.name',"className": "text-center"},
                    {data: 'region_name', name: 'regions.region_name',"className": "text-center"},
                    {data: 'archipelago_name', name: 'archipelagos.archipelago_name',"className": "text-center"},
                    {data: 'handled_by_account_officer', name: 'endorsements.handled_by_account_officer'},
                    {data: 'requestor_name', name: 'endorsements.requestor_name'},
                    {
                        data: function actions(data)
                        {

                            if(data.handled_by_account_officer == "" || data.handled_by_account_officer == null)
                            {
                                return '<a href="'+ data.id + '" class="btn btn-xs btn-primary btn-block" id="btnAssign" data-toggle="modal" data-target="#dispatch_modal"><i class="glyphicon glyphicon-edit"></i> Assign</a>' +
                                    '<a href="'+ data.id + '" class="btn btn-xs btn-primary btn-block" id="btnFullViewInfo" data-toggle="modal" data-target="#modal-view-info">View Info</a>';
                            }
                            else
                            {
                                return '<button class="btn btn-xs btn-success btn-block" id="">Already Assigned</button>' +
                                    '<a href="'+ data.id + '" class="btn btn-xs btn-primary btn-block" id="btnFullViewInfo" data-toggle="modal" data-target="#modal-view-info">View Info</a>';
                            }

                        },
                        "orderable": false,
                        "searchable": false,
                        "name": 'action',
                        "width": "6%"
                    }
                ],
            "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull)
            {
                var countDownDate = new Date(aData.date_endorsed+' '+aData.time_endorsed);
                var now = new Date();
                var distance = countDownDate.setMinutes(countDownDate.getMinutes()+20) - now;

                var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                if (minutes>=15)
                {
                    $('td', nRow).css('background-color', '#b3ffb3');
                    if(aData.handled_by_account_officer != "") {

                        $('td', nRow).css('background-color', '#fff');

                    }
                }
                else if (minutes>=10)
                {
                    $('td', nRow).css('background-color', '#ffb84d');
                    if(aData.handled_by_account_officer != "") {

                        $('td', nRow).css('background-color', '#fff');

                    }
                }
                else if (minutes>=5 || minutes<=5)
                {
                    $('td', nRow).css('background-color', '#ffb3b3');
                    if(aData.handled_by_account_officer != "") {

                        $('td', nRow).css('background-color', '#fff');

                    }
                }
            },
            "order": [[0, 'desc']],
            "pageLength": 10,
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

    $('#endorsement-tablee_filter input').unbind();
    $('#endorsement-tablee_filter input').bind('keyup change',function (e) {

        if($(this).is(':focus'))
        {
            if (e.keyCode == 13) {
                tablee.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '') {
                    tablee.search($(this).val()).draw();
                }
            }
        }
    });




    $('#tab1').click(function () {
        // console.log('tab1');
        if(!refreshertab1 || !assign_click1){
            // tablee.ajax.reload(null, false);
            assign_click1 = true;
        }
        else if(assign_click1)
        {
            console.log('already loaded');
        }
        else
        {
            console.log('do nothing');
        }
        refreshertab1 = true;
        refreshertab2 = false;
        refreshertab3 = false;
        refreshertab4 = false;
        refreshertab5 = false;

    });

    $('#tab2').click(function () {
        // console.log('tab2');
        if(!refreshertab2 || !assign_click2)
        {
            trans_table_init();
            assign_click2 = true;
        }
        else if(assign_click2)
        {
            console.log('already loaded');
        }
        else
        {
            console.log('do nothing');
        }
        refreshertab1 = false;
        refreshertab2 = true;
        refreshertab3 = false;
        refreshertab4 = false;
        refreshertab5 = false;
    });

    $('#tab3').click(function () {
        // console.log('tab3');

        if(!refreshertab3 || !assign_click3)
        {
            manage_table_init();
            assign_click3 = true;

        }
        else if(assign_click3 )
        {
            console.log('already loaded');
        }
        else
        {
            console.log('do nothing');
        }

        refreshertab1 = false;
        refreshertab2 = false;
        refreshertab3 = true;
        refreshertab4 = false;
        refreshertab5 = false;
    });

    $('#tab4').click(function () {
        // console.log('tab3');

        if(!refreshertab4 || assign_click4)
        {
            revision_table_init();
            assign_click4 = true;

        }
        else if(assign_click4)
        {
            console.log('already loaded');
        }
        else
        {
            console.log('do nothing');
        }
        refreshertab1 = false;
        refreshertab2 = false;
        refreshertab3 = false;
        refreshertab4 = true;
        refreshertab5 = false;
    });

    $('#tab5').click(function () {
        // console.log('tab3');

        if(!refreshertab5 || assign_click5)
        {
            ci_account_report_table();
            assign_click5 = true;

        }
        else if(assign_click5)
        {
            console.log('already loaded');
        }
        else
        {
            console.log('do nothing');
        }
        refreshertab1 = false;
        refreshertab2 = false;
        refreshertab3 = false;
        refreshertab4 = false;
        refreshertab5 = true;
    });

    $('.a_sao').click(function () {

        var gethref = $(this).attr('href');

        console.log(gethref);

        if(gethref == '#sao_dashboard_tab')
        {
            if( $(''+gethref+'').hasClass('active'))
            {
                console.log('do nothing');
                which_is_active = 'dash_active';

            }
            else if(dash_sao)
            {
                console.log('already loaded');
                which_is_active = 'dash_active';

            }
            else if(dash_sao == false)
            {
                dash_sao = true;
                which_is_active = 'dash_active';
                dash_map_init();

            }
        }
        else if(gethref == '#sao_process_tab')
        {
            if( $(''+gethref+'').hasClass('active'))
            {
                console.log('do nothing');
                which_is_active = 'sao_process_tab';

            }
            else if(accounts_sao)
            {
                console.log('already loaded');
                which_is_active = 'sao_process_tab';

            }
            else if(accounts_sao == false)
            {
                which_is_active = 'sao_process_tab';
                accounts_sao = true;
            }
        }
        else if(gethref == '#sao_fund_tab')
        {
            if( $(''+gethref+'').hasClass('active'))
            {
                console.log('do nothing');
                which_is_active = 'sao_fund_tab';

            }
            else if(fund_sao)
            {
                console.log('already loaded');
                which_is_active = 'sao_fund_tab';

            }
            else if(fund_sao == false)
            {
                fund_sao = true;
                which_is_active = 'sao_fund_tab';
                fund_sao_init();
            }
        }
        else if(gethref == '#sao_search_tab')
        {
            if( $(''+gethref+'').hasClass('active'))
            {
                console.log('do nothing');
                which_is_active = 'search_active';

            }
            else if(search_acct)
            {
                console.log('already loaded');
                which_is_active = 'search_active';

            }
            else if(search_acct == false)
            {
                search_acct = true;
                which_is_active = 'search_active';
                endo_init();
            }
        }
        else if(gethref == '#sao_audit_tab')
        {
            if( $(''+gethref+'').hasClass('active'))
            {
                console.log('do nothing');
                which_is_active = 'sao_audit_active';

            }
            else if(audit_sao)
            {
                console.log('already loaded');
                which_is_active = 'sao_audit_active';

            }
            else if(audit_sao == false)
            {
                audit_sao = true;
                which_is_active = 'sao_audit_active';

                $( "#datepicker_report" ).datepicker({ dateFormat: 'yy-mm-dd' ,        orientation: "bottom"});
                $( "#datepickermax_report" ).datepicker({ dateFormat: 'yy-mm-dd' ,        orientation: "bottom"});
                $('.date_range_conts_report').css('display','none');
                $('#min_report').val('2015-01-01');
                $('#max_report').val('6000-01-01');

                sao_audit_table();
            }
        }
        else if(gethref == '#sao_unliq_tab')
        {
            if( $(''+gethref+'').hasClass('active'))
            {
                console.log('do nothing');
                which_is_active = 'sao_unliq_tab';

            }
            else if(unliq_em_sao)
            {
                console.log('already loaded');
                which_is_active = 'sao_unliq_tab';

            }
            else if(unliq_em_sao == false)
            {
                which_is_active = 'sao_unliq_tab';
                unliq_em_sao = true;
                saoFundLogs();
                fund_disp_init();
            }
        }
        else if(gethref == '#sao_fa_monitoring_tab')
        {
            if( $(''+gethref+'').hasClass('active'))
            {
                console.log('do nothing');
                which_is_active = 'sao_fa_monitoring_tab';

            }
            else if(sao_fa_bool)
            {
                console.log('already loaded');
                which_is_active = 'sao_fa_monitoring_tab';

            }
            else if(sao_fa_bool == false)
            {
                var SetDate = new Date();
                var FullDate = (SetDate.getMonth() + 1) + '/' + SetDate.getDate() + '/' + SetDate.getFullYear();
                $('#ci_expense_range_start1').val(FullDate);
                // $('#ci_expense_range_start').val(SetDate.getFullYear() + '-' + SetDate.getMonth() + 1 + '-' + SetDate.getDate());
                // $('#ci_expense_range_end').val(SetDate.getFullYear() + '-' + SetDate.getMonth() + 1 + '-' + SetDate.getDate());
                $('#ci_expense_range_end1').val(FullDate);

                expenseStart = FullDate;
                expenseEnd= FullDate;

                // console.log(FullDate);

                which_is_active = 'sao_fa_monitoring_tab';
                sao_fa_bool = true;

                faTablesCi()
            }
        }

    });



    $('.viewable_report').click(function () {
        if($(this).is(":checked"))
        {
            if($(this).val() == 'All')
            {
                $('.viewable_report#rad_all_report').prop('checked',true);
                // $('.viewable_report#rad_all_pends').prop('checked',true);

                $('.date_range_conts_report').css('display','none');

                $('#min_report').val('2015-01-01');
                $('#max_report').val('6000-01-01');
                // search_where_option_fund = 'fund_requests.dispatcher_request_date';

                table_sao_audit.draw();
            }
            else if($(this).val() == 'Date Range')
            {

                $('.viewable_report#rad_daterange_report').prop('checked',true);
                // $('.viewable_report#rad_daterange_pends').prop('checked',true);

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

                $( "#datepicker_report" ).datepicker({ dateFormat: 'yy-mm-dd' });
                $( "#datepickermax_report" ).datepicker({ dateFormat: 'yy-mm-dd' });

                $('#datepicker_report').val(month+dateyear);
                $('#datepickermax_report').val(month+dateyear);

                $('#min_report').val(yearmonth+date);
                $('#max_report').val(yearmonth+date);

                table_sao_audit.draw();

                //pending

            }
        }
    });

    $('#datepicker_report').change( function() {


        var min = $.datepicker.formatDate('yy-mm-dd', $('#datepicker_report').datepicker('getDate'));
        console.log(min);

        $('#min_report').val(min);

        var max = $.datepicker.formatDate('yy-mm-dd', $('#datepickermax_report').datepicker('getDate'));
        console.log(max);

        if(max === '')
        {
            $('#max_report').val(yearmonth+date);

        }
        else {
            $('#max_report').val(max);
        }

        table_sao_audit.draw();
    });


    $('#datepickermax_report').change( function() {

        var min = $.datepicker.formatDate('yy-mm-dd', $('#datepicker_report').datepicker('getDate'));
        console.log(min);
        $('#min_report').val(min);

        var max = $.datepicker.formatDate('yy-mm-dd', $('#datepickermax_report').datepicker('getDate'));
        console.log(max);
        if(max === '')
        {
            $('#max_report').val(yearmonth+date);

        }
        else {
            $('#max_report').val(max);
        }
        table_sao_audit.draw();
    });


    $('.viewable_report#rad_all_report').prop('checked',true);


    $(window).focus(function () {

        console.log('focus');
        interval = true;
    });


    setInterval(function ()
    {

        if(interval)
        {
            if(which_is_active == 'sao_process_tab')
            {
                if(refreshertab1)
                {
                    tablee.ajax.reload(null, false);

                }
                else if(refreshertab2)
                {
                    tableee.ajax.reload(null, false);

                }
                else if(refreshertab3)
                {
                    table.ajax.reload(null, false);

                }
                else if(refreshertab4)
                {
                    tableRevision.ajax.reload(null, false);

                }
                else if(refreshertab5)
                {
                    table_ci_account_report.ajax.reload(null, false);

                }
            }
            else if(which_is_active == 'sao_fund_tab')
            {
                table_ci_fund.ajax.reload(null, false);
            }
        }
        // table_ci_fund.ajax.reload(null, false);
        // table_ci_fund_app.ajax.reload(null, false);
        // table_ci_fund_dec.ajax.reload(null, false);
    },60000);
});




function trans_table_init() {

    $('#aolist-table thead th').each(function() {
        var title = $(this).text();
        $(this).html(title+'<br><input type="text" placeholder="Search" style="position: relative; width: 100%">');

    });

    tableee = $('#aolist-table').DataTable(
        {
            "responsive": true,
            "processing": true,
            "serverSide": true,
            // ajax: "/sao-transfer-account",
            "ajax":
                {
                    url: "/sao-transfer-account",
                    data: function (d)
                    {
                        d.min_date_endorsed = $('#sao_assign_min').val();
                        d.max_date_endorsed = $('#sao_assign_max').val();
                        d.search_methodd = $('input[name="sao_assign_rad_transfer"]:checked').val();
                    }
                },
            columns:
                [
                    {data: 'id', name: 'endorsements.id'},
                    {data: 'date_endorsed', name: 'endorsements.date_endorsed'},
                    {data: 'time_endorsed', name: 'endorsements.time_endorsed'},
                    {data: 'date_due', name: 'endorsements.date_due'},
                    {data: 'time_due', name: 'endorsements.time_due'},
                    {data: 'account_name', name: 'endorsements.account_name'},
                    // {data: 'type_of_request', name: 'endorsements.type_of_request'},
                    {data: 'type_of_request', name: 'endorsements.type_of_request'},

                    // {
                    //
                    //     data: function actions(data) {
                    //
                    //         clearTimeout(times);
                    //         fetchOtherInro('aolist-table',4);
                    //         return '<span id="otherinfo'+data.id+'">'+data.type_of_request+'</span>';
                    //
                    //     },
                    //     'name' : 'endorsements.type_of_request'
                    // },
                    {data: 'type_of_loan', name: 'endorsements.type_of_loan'},
                    {data: 'user_id', name: 'user_id'},
                    {data: 'aoname', name: 'users.name'},
                    {data: 'client_name', name: 'endorsements.client_name'},
                    {data: 're_ci', name: 'endorsements.re_ci'},
                    {data: 'email', name: 'users.email'},
                    {data: 'muni_name', name: 'municipalities.muni_name', "className": "text-center"},
                    {data: 'name', name: 'provinces.name',"className": "text-center"},
                    {data: 'region_name', name: 'regions.region_name',"className": "text-center"},
                    {data: 'archipelago_name', name: 'archipelagos.archipelago_name',"className": "text-center"},
                    {
                        data: function(data)
                        {
                            if(data.type_of_sending_report==='')
                            {
                                return '<button class="btn-xs btn-block btn-info" value="'+data.id+'" id="btnTransfer" name="'+data.user_id+'"><i class="fa fa-exchange"></i> transfer</button>' +
                                    '<a href="' + data.id + '" class="btn btn-block btn-xs btn-warning" id="btnViewFullInfo" data-toggle="modal" data-target="#modal-sao-view-info"><i class="glyphicon glyphicon-search"></i> View</a>';
                            }
                            else
                            {
                                return '<button class="btn-xs btn-block btn-info" value="'+data.id+'" id="btnTransfer" name="'+data.user_id+'"><i class="fa fa-exchange"></i> transfer</button>' +
                                    '<a href="' + data.id + '" class="btn btn-block btn-xs btn-primary" id="btnUpdateInfo" data-toggle="modal" data-target="#modal-sao-update-info"><i class="glyphicon glyphicon-edit"></i> Update</a>' +
                                    '<a href="' + data.id + '" class="btn btn-block btn-xs btn-warning" id="btnViewFullInfo" data-toggle="modal" data-target="#modal-sao-view-info"><i class="glyphicon glyphicon-search"></i> View</a>';
                            }
                        },
                        "orderable": false, "searchable": false, name: 'action', "width": "5%"
                    }
                ],
            "order": [ [0, 'desc'] ],
            "pageLength": 10,
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

    $('#aolist-table_filter input').unbind();
    $('#aolist-table_filter input').bind('keyup change',function (e) {

        if($(this).is(':focus'))
        {
            if (e.keyCode == 13) {
                tableee.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '') {
                    tableee.search($(this).val()).draw();
                }
            }
        }
    });



}
function manage_table_init() {

    $('#tableholdcancel thead th').each(function() {
        var title = $(this).text();
        $(this).html(title+'<br><input type="text" placeholder="Search" style="position: relative; width: 100%">');

    });

    table = $('#tableholdcancel').DataTable(
        {

            "responsive": true,
            "processing": true,
            "serverSide": true,
            "ajax": "/srao-fetch-endorsementManage",
            "columns":
                [
                    {data: 'id', name: 'endorsements.id'},
                    {data: 'date_endorsed', name: 'endorsements.date_endorsed'},
                    {data: 'time_endorsed', name: 'endorsements.time_endorsed'},
                    {data: 'date_due', name: 'endorsements.date_due'},
                    {data: 'time_due', name: 'endorsements.time_due'},
                    {data: 're_ci', name: 'endorsements.re_ci'},
                    {data: 'account_name', name: 'endorsements.account_name'},
                    {data: 'address', name: 'endorsements.address'},
                    {data: 'type_of_request', name: 'endorsements.type_of_request'},
                    {data: 'client_name', name: 'endorsements.client_name'},
                    {data: 'type_of_loan', name: 'endorsements.type_of_loan'},
                    {data: 'provinces', name: 'endorsements.provinces'},
                    {data: 'requestor_name', name: 'endorsements.requestor_name'},
                    {
                        data: function actions(data)
                        {

                            if(data.acct_status == '')
                            {
                                return ' <a href="#edit-' + data.id + '" class="btn btn-xs btn-warning" name="'+data.id+':'+data.account_name+'" id="btnHoldEndorse" data-toggle="modal" data-target="#modal-hold" style="width: 100%">Hold</a><br/>' +
                                    ' <a href="#edit-' + data.id + '" class="btn btn-xs btn-info btn-return_test_01" name="'+data.id+':'+data.account_name+'" id="btnReturnEndorse" data-toggle="modal" data-target="#srao-modal-return" style="width: 100%">Return</a><br/>'+
                                    ' <a href="#edit-' + data.id + '" class="btn btn-xs btn-danger" name="'+data.id+':'+data.account_name+'" id="btnCancelEndorse" data-toggle="modal" data-target="#modal-cancel" style="width: 100%">Cancel</a>';
                            }
                            else if(data.acct_status == 5)
                            {
                                return ' <a href="#edit-' + data.id + '" class="btn btn-xs btn-danger" name="'+data.id+':'+data.account_name+'" id="btnUncancelEndorse" data-toggle="modal" data-target="#modal-uncancel" style="width: 100%">Uncancelled</a>';
                            }

                            else if(data.acct_status == 4)
                            {
                                return ' <a href="#edit-' + data.id + '" class="btn btn-xs btn-warning" name="'+data.id+':'+data.account_name+'" id="btnUnholdEndorse" data-toggle="modal" data-target="#modal-unhold" style="width: 100%">Unhold</a>';
                            }
                            else if(data.acct_status == 6)
                            {
                                return ' <a href="#edit-' + data.id + '" class="btn btn-xs btn-info" name="'+data.id+':'+data.account_name+'" id="btnCancelReturnEndorse" data-toggle="modal" data-target="#srao-modal-cancelreturn" style="width: 100%">Cancel Return</a>';
                            }
                        },
                        "orderable": false,
                        "searchable": false
                    }
                ],
            "order": [[0, 'desc']],
            "pageLength": 10,
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

    $('#tableholdcancel_filter input').unbind();
    $('#tableholdcancel_filter input').bind('keyup change',function (e) {
        if($(this).is(':focus'))
        {
            if (e.keyCode === 13) {
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
function revision_table_init() {
    $('#aolist-table-revision thead th').each(function() {
        var title = $(this).text();
        $(this).html(title+'<br><input type="text" placeholder="Search" style="position: relative; width: 100%">');

    });

    tableRevision = $('#aolist-table-revision').DataTable(
        {
            "responsive": true,
            "processing": true,
            "serverSide": true,
            ajax: "/sao-table-get-revision",
            columns:
                [
                    {data: 'id', name: 'endorsements.id'},
                    {data: 'date_endorsed', name: 'endorsements.date_endorsed'},
                    {data: 'time_endorsed', name: 'endorsements.time_endorsed'},
                    {data: 'date_due', name: 'endorsements.date_due'},
                    {data: 'time_due', name: 'endorsements.time_due'},
                    {data: 'account_name', name: 'endorsements.account_name'},
                    // {data: 'type_of_request', name: 'endorsements.type_of_request'},
                    {data: 'type_of_request', name: 'endorsements.type_of_request'},
                    // {
                    //
                    //     data: function actions(data) {
                    //
                    //         clearTimeout(times);
                    //         fetchOtherInro('aolist-table-revision',4);
                    //         return '<span id="otherinfo'+data.id+'">'+data.type_of_request+'</span>';
                    //
                    //     },
                    //     'name' : 'endorsements.type_of_request'
                    // },
                    {data: 'type_of_loan', name: 'endorsements.type_of_loan'},
                    {data: 'ao_name', name: 'users.name'},
                    {data: 'client_name', name: 'endorsements.client_name'},
                    {data: 're_ci', name: 'endorsements.re_ci'},
                    {data: 'email', name: 'users.email'},
                    {data: 'muni_name', name: 'municipalities.muni_name', "className": "text-center"},
                    {data: 'name', name: 'provinces.name',"className": "text-center"},
                    {data: 'region_name', name: 'regions.region_name',"className": "text-center"},
                    {data: 'archipelago_name', name: 'archipelagos.archipelago_name',"className": "text-center"},
                    {
                        data: function(data)
                        {
                            return '<button class="btn-xs btn-block btn-warning" value="'+data.id+'" id="btnDownloadRev">Download AO Report</button>' +
                                '<button class="btn-xs btn-block btn-info" value="'+data.id+'" id="btnUploadRev" data-toggle="modal" data-target="#modal-upload-revision">Upload Revision</button>';

                        },
                        "orderable": false,
                        "searchable": false,
                        "name": 'actions',
                        "autoWidth": true
                    }
                ],
            "order": [ [0, 'desc'] ],
            "pageLength": 10,
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

    $('#aolist-table-revision_filter input').unbind();
    $('#aolist-table-revision_filter input').bind('keyup change',function (e) {

        if($(this).is(':focus'))
        {
            if (e.keyCode == 13) {
                tableRevision.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '') {
                    tableRevision.search($(this).val()).draw();
                }
            }
        }
    });


}
function ci_account_report_table() {

    $( "#datepicker_sao" ).datepicker({ dateFormat: 'yy-mm-dd' });
    $( "#datepickermax_sao" ).datepicker({ dateFormat: 'yy-mm-dd' });


    var today = new Date();
    var yearmonth;
    var date;

    $('.date_range_conts').css('display','none');
    $('#min_sao').val('---');
    $('#max_sao').val('---');
    search_where_option_fund = 'endorsements.date_endorsed';

    var count = 0;
    $('#sao_table_ci_account_reports thead th').each(function() {
        var title = $(this).text();
        title_header_ci_report[count] = title;
        count++;
        $(this).html(title+'<br><input type="text" placeholder="Search" style="position: relative; width: 100%">');
    });

    table_ci_account_report = $('#sao_table_ci_account_reports').DataTable
    ({
        dom: 'Blfrtip',
        buttons:
            [
                {
                    extend: 'colvis',
                    columnText: function (dt, idx, title)
                    {
                        return title_header_ci_report[(idx)];
                    }
                },
                {
                    extend: 'pdf',
                    title: 'C.I Account Reports',
                    exportOptions:
                        {
                            columns: ':visible',
                            format:
                                {
                                    header:  function (dt, idx, title)
                                    {
                                        return title_header_ci_report[(idx)];
                                    }
                                }
                        }
                },
                {
                    extend: 'excel',
                    title: 'C.I Account Reports',
                    exportOptions:
                        {
                            columns: ':visible',
                            format:
                                {
                                    header:  function (dt, idx, title)
                                    {
                                        return title_header_ci_report[(idx)];
                                    }
                                }
                        }
                },
                {
                    extend: 'print',
                    title: 'C.I Account Reports',
                    exportOptions:
                        {
                            columns: ':visible',
                            format:
                                {
                                    header:  function (dt, idx, title)
                                    {
                                        return title_header_ci_report[(idx)];
                                    }
                                }
                        }
                }
            ],
        // "responsive": true,
        "processing": true,
        "serverSide": true,
        "ajax":
            {
                url: "/sao_table_ci_account_reports",
                data: function (d)
                {
                    d.min_date_endorsed = $('#min_sao').val();
                    d.max_date_endorsed = $('#max_sao').val();
                    d.search_option = search_where_option_fund;
                }
            },
        "columns":
            [
                {data: 'id', name: 'endorsements.id'},
                {data: 'account_name', name: 'endorsements.account_name'},
                {data: 'date_endorsed', name: 'endorsements.date_endorsed'},
                {data: 'time_endorsed', name: 'endorsements.time_endorsed'},
                {data: 'address', name: 'endorsements.address'},
                {data: 'city_muni', name: 'endorsements.city_muni'},
                {data: 'provinces', name: 'endorsements.provinces'},
                {data: 'date_due', name: 'endorsements.date_due'},
                {data: 'time_due', name: 'endorsements.time_due'},
                {data: 'client_name', name: 'endorsements.client_name'},
                {data: 'type_of_request', name: 'endorsements.type_of_request'},
                {data: 'handled_by_dispatcher', name: 'endorsements.handled_by_dispatcher'},
                {data: 'handled_by_credit_investigator', name: 'endorsements.handled_by_credit_investigator'},
                {
                    data: function dateTimeDispatched(data)
                    {
                        return data.date_dispatched+' '+data.time_dispatched;
                    },
                    "name": 'date_dispatched'
                },
                {
                    data: function dateTimeCiVisit(data)
                    {
                        return data.date_ci_visit+' '+data.time_ci_visit;
                    },
                    "name": 'date_ci_visit'
                },
                {
                    data: function dateTimeCiReported(data)
                    {
                        return data.date_ci_forwarded+' '+data.time_ci_forwarded;
                    },
                    "name": 'date_ci_forwarded'
                },
                {data: 'time_dispatcher', name: 'timestamps.time_dispatcher'},
                {data: 'time_ci', name: 'timestamps.time_ci'},
                {data: 'ci_cert', name: 'endorsements.ci_cert'},
                {
                    data: function actions(data)
                    {
                        var toreturn = '';
                        var note="";

                        if(data.acct_status==1)
                        {
                            toreturn = '<a class="btn btn-xs btn-warning btn-block"><i class="glyphicon glyphicon-refresh"></i> ON PROCESS</a><br>';
                        }
                        else if(data.acct_status==2)
                        {
                            //data forwarded
                            if(data.ci_cert=='NC')
                            {
                                toreturn = '<button value="'+data.id+'" class="btnAuditDownload btn btn-xs btn-primary btn-block" name="dataforwarded"><i class="glyphicon glyphicon-cloud-download"></i> DOWNLOAD CI REPORT</button><br>'+note;
                            }

                        }
                        else if(data.acct_status==3)
                        {
                            //finish
                            if(data.ci_cert=='NC')
                            {
                                toreturn = '<button value="'+data.id+'" class="btnAuditDownload btn btn-xs btn-primary btn-block" name="dataforwarded"><i class="glyphicon glyphicon-cloud-download"></i> DOWNLOAD CI REPORT</button><br>'+note;
                                // '<button value="'+data.id+'" class="btnAuditDownload btn btn-xs btn-primary" name="finish"><i class="glyphicon glyphicon-cloud-download"></i> DOWNLOAD AO REPORT</button>';
                            }
                            else if(data.ci_cert=='C')
                            {
                                toreturn = '<button value="'+data.id+'" class="btnAuditDownload btn btn-xs btn-primary btn-block" name="finish_certified"><i class="glyphicon glyphicon-cloud-download"></i> DOWNLOAD CI REPORT</button><br>'+note;
                            }

                        }
                        else if(data.acct_status==4)
                        {
                            toreturn = '<a href="'+data.id+'" class="btn btn-xs btn-primary btn-block" data-toggle="modal" data-target="#dispatch_mssodal"><i class="glyphicon glyphicon-cloud-download"></i> HOLD</a><br>';
                        }
                        else if(data.acct_status==5)
                        {
                            toreturn = '<a href="'+data.id+'" class="btn btn-xs btn-primary btn-block" data-toggle="modal" data-target="#dispatch_mssodal"><i class="glyphicon glyphicon-cloud-download"></i> CANCEL</a><br>';
                        }
                        else
                        {
                            toreturn = '<a href="'+data.id+'" class="btn btn-xs btn-danger btn-block" data-toggle="modal" data-target="#dispatch_mssodal"><i class="glyphicon glyphicon-cloud-download"></i> NEW ENDORSEMENT</a><br>';
                        }

                        return toreturn+'<a href="'+ data.id + '" class="btn btn-xs btn-primary btn-block" id="btnFullViewInfo" data-toggle="modal" data-target="#modal-view-info"><i class="fa fa-exclamation-circle"></i> VIEW INFO</a>';
                    },


                    "name": 'endorsements.acct_status'
                }
            ],
        "order": [[0, 'desc']],
        "pageLength": 10,
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

    $('#sao_table_ci_account_reports_filter input').unbind();
    $('#sao_table_ci_account_reports_filter input').bind('keyup change',function (e) {

        if($(this).is(':focus'))
        {
            if (e.keyCode == 13) {
                table_ci_account_report.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '') {
                    table_ci_account_report.search($(this).val()).draw();
                }
            }
        }
    });



    $('.viewable').click(function () {
        if($(this).is(":checked"))
        {
            if($(this).val() == 'All')
            {
                $('.viewable#rad_all_sao').prop('checked',true);

                $('.date_range_conts').css('display','none');

                $('#min_sao').val('---');
                $('#max_sao').val('---');
                search_where_option_fund = 'endorsements.date_endorsed';

                table_ci_account_report.draw();
            }
            else if($(this).val() == 'Date Range')
            {

                $('.viewable#rad_daterange_sao').prop('checked',true);


                $('.date_range_conts').css('display','');

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

                $( "#datepicker_sao" ).datepicker({ dateFormat: 'yy-mm-dd' });
                $( "#datepickermax_sao" ).datepicker({ dateFormat: 'yy-mm-dd' });

                $('#datepicker_sao').val(month+dateyear);
                $('#datepickermax_sao').val(month+dateyear);

                $('#min_sao').val(yearmonth+date);
                $('#max_sao').val(yearmonth+date);



                 //table_ci_account_report.draw();

                //pending

            }
        }
    });

    $('#select_search_option_sao').change(function () {

        console.log($(this).val());

        if($(this).val() == 'sao_sort_date_endorsed')
        {
            search_where_option_fund = 'endorsements.date_endorsed';
        }
        else if($(this).val() == 'sao_sort_date_dispatched')
        {
            search_where_option_fund = 'endorsements.date_dispatched';
        }
        else if($(this).val() == 'sao_sort_date_ci_visit')
        {
            search_where_option_fund = 'endorsements.date_ci_visit';
        }
        else if($(this).val() == 'sao_sort_date_report_submit')
        {
            search_where_option_fund = 'endorsements.date_forwarded_to_client';
        }

        table_ci_account_report.draw();
    });

    $('#datepicker_sao').change( function() {
        var min = $.datepicker.formatDate('yy-mm-dd', $('#datepicker_sao').datepicker('getDate'));
        console.log(min);
        $('#min_sao').val(min);

        var max = $.datepicker.formatDate('yy-mm-dd', $('#datepickermax_sao').datepicker('getDate'));
        console.log(max);

        if(max === '')
        {
            $('#max_sao').val(yearmonth+date);

        }
        else {
            $('#max_sao').val(max);
        }
        table_ci_account_report.draw();
    });

    $('#datepickermax_sao').change( function() {

        var min = $.datepicker.formatDate('yy-mm-dd', $('#datepicker_sao').datepicker('getDate'));
        console.log(min);
        $('#min_sao').val(min);

        var max = $.datepicker.formatDate('yy-mm-dd', $('#datepickermax_sao').datepicker('getDate'));
        console.log(max);
        if(max === '')
        {
            $('#max_sao').val(yearmonth+date);

        }
        else {
            $('#max_sao').val(max);
        }
        table_ci_account_report.draw();
    });

    $('.viewable#rad_all_sao').prop('checked',true);
}



function sao_audit_table() {

    var i1 = 0;
    var titleheader;

    $('#sao-audit-table-reports thead th').each(function()
    {
        audit_header[i1] = $(this).text();
        i1++;
        titleheader = $(this).text();
        $(this).html(titleheader+'<br><input type="text" placeholder="Search" style="position: relative; width: 100%">');

    });

    table_sao_audit = $('#sao-audit-table-reports').DataTable
    ({
        dom: 'Blfrtip',
        buttons:
            [
                {
                    extend: 'colvis',
                    columnText: function (dt, idx, title)
                    {
                        return audit_header[(idx)];
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
                                        return audit_header[(idx)];
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
                                        return audit_header[(idx)];
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
                                        return audit_header[(idx)];
                                    }
                                }
                        }
                }
            ],
        // "responsive": true,
        "processing": true,
        "serverSide": true,
        "ajax":
            {
                url: "/audit-table-report-sao",
                type:'post',
                data: function (d)
                {
                    d.min_date_endorsed = $('#min_report').val();
                    d.max_date_endorsed = $('#max_report').val();
                }
            },
        "columns":
            [
                {data: 'id', name: 'endorsements.id'},
                {data: 'client_name', name: 'endorsements.client_name'},
                {data: 'date_endorsed', name: 'endorsements.date_endorsed'},
                {data: 'time_endorsed', name: 'endorsements.time_endorsed'},
                {data: 'date_due', name: 'endorsements.date_due'},
                {data: 'time_due', name: 'endorsements.time_due'},
                {data: 'requestor_name', name: 'endorsements.requestor_name'},
                {data: 'account_name', name: 'endorsements.account_name'},
                {data: 'address', name: 'endorsements.address'},
                {data: 'city_muni', name: 'endorsements.city_muni'},
                {data: 'provinces', name: 'endorsements.provinces'},
                {data: 'archipelago_name', name: 'archipelagos.archipelago_name'},
                {data: 'type_of_request', name: 'endorsements.type_of_request'},
                {data: 'endorsement_status_internal', name: 'endorsements.endorsement_status_internal'},
                {data: 'endorsement_status_internal_2', name: 'endorsements.endorsement_status_internal_2'},
                {data: 'verify_through', name: 'endorsements.verify_through'},
                {data: 'handled_by_dispatcher', name: 'endorsements.handled_by_dispatcher'},
                {data: 'assigned_by_srao', name: 'endorsements.assigned_by_srao'},
                {data: 'handled_by_account_officer', name: 'endorsements.handled_by_account_officer'},
                {data: 'handled_by_credit_investigator', name: 'endorsements.handled_by_credit_investigator'},
                {
                    data: function dateTimeDispatched(data)
                    {
                        return data.date_dispatched+' '+data.time_dispatched;
                    },
                    "name": 'date_dispatched'
                },
                {
                    data: function dateTimeAssigned(data)
                    {
                        return data.date_srao_assigned+' '+data.time_srao_assigned;
                    },
                    "name": 'date_srao_assigned'
                },
                {
                    data: function dateTimeCiReported(data)
                    {
                        return data.date_ci_forwarded+' '+data.time_ci_forwarded;
                    },
                    "name": 'date_ci_forwarded'
                },
                {
                    data: function dateTimeAOReported(data)
                    {
                        return data.date_forwarded_to_client+' '+data.time_forwarded_to_client;
                    },
                    "name": 'date_forwarded_to_client'
                },
                {
                    data: function dateTimeCiVisit(data)
                    {
                        return data.date_ci_visit+' '+data.time_ci_visit;
                    },
                    "name": 'date_ci_visit'
                },
                {data: 'endorsement_status_external', name: 'endorsements.endorsement_status_external'},
                {data: 'time_dispatcher', name: 'timestamps.time_dispatcher'},
                {data: 'time_srao', name: 'timestamps.time_srao'},
                {data: 'time_ci', name: 'timestamps.time_ci'},
                {data: 'time_ao', name: 'timestamps.time_ao'},
                {data: 'ci_cert', name: 'endorsements.ci_cert'},
                {
                    data: function actions(data)
                    {



                        if(data.acct_status==1)
                        {
                            return '<a class="btn btn-xs btn-warning"><i class="glyphicon glyphicon-refresh"></i> ON PROCESS</a>';
                        }
                        else if(data.acct_status==2)
                        {
                            //data forwarded
                            if(data.ci_cert=='NC')
                            {
                                return '<button value="'+data.id+'" class="btnAuditDownload_sao btn btn-xs btn-primary" name="dataforwarded"><i class="glyphicon glyphicon-cloud-download"></i> DOWNLOAD CI REPORT</button><br>'+
                                    '<button value="'+data.id+'" class="btn btn-xs btn-block btn-success" name="'+data.account_name+'" id="btnViewReport" data-toggle="modal" data-target="#modal-ci-note"><i class="glyphicon glyphicon-envelope"></i> C.I NOTE</button>'
                                    ;
                            }

                        }
                        else if(data.acct_status==3)
                        {
                            //finish
                            if(data.ci_cert=='NC')
                            {
                                return '<button value="'+data.id+'" class="btnAuditDownload_sao btn btn-xs btn-primary" name="dataforwarded"><i class="glyphicon glyphicon-cloud-download"></i> DOWNLOAD CI REPORT</button><br>'+
                                    '<button value="'+data.id+'" class="btnAuditDownload_sao btn btn-xs btn-primary" name="finish"><i class="glyphicon glyphicon-cloud-download"></i> DOWNLOAD AO REPORT</button>';
                            }
                            else if(data.ci_cert=='C')
                            {
                                return '<button value="'+data.id+'" class="btnAuditDownload_sao btn btn-xs btn-primary" name="finish_certified"><i class="glyphicon glyphicon-cloud-download"></i> DOWNLOAD CI REPORT</button>';
                            }

                        }
                        else if(data.acct_status==4)
                        {
                            return '<a href="'+data.id+'" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#dispatch_mssodal"><i class="glyphicon glyphicon-cloud-download"></i> HOLD</a>';
                        }
                        else if(data.acct_status==5)
                        {
                            return '<a href="'+data.id+'" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#dispatch_mssodal"><i class="glyphicon glyphicon-cloud-download"></i> CANCEL</a>';
                        }
                        else if(data.acct_status==6)
                        {
                            return '<a href="'+data.id+'" class="btn btn-xs btn-info" data-toggle="modal" data-target="#dispatch_mssodal"><i class=" fa fa-rotate-left"></i> RETURN ACCOUNT</a>';
                        }
                        else
                        {
                            return '<a href="'+data.id+'" class="btn btn-xs btn-danger" data-toggle="modal" data-target="#dispatch_mssodal"><i class="glyphicon glyphicon-cloud-download"></i> NEW ENDORSEMENT</a>';
                        }

                        if(data.nononote==null)
                        {
                            return '<a href="'+ data.id + '" class="btn btn-xs btn-primary btn-block" id="btnFullViewInfo" data-toggle="modal" data-target="#modal-view-info">View Info</a>' +
                                '<a href="'+ data.id + '" class="btn btn-xs btn-default btn-block" id="btnView" data-toggle="modal">No Available Note</a>';
                        }
                        else
                        {
                            return '<a href="'+ data.id + '" class="btn btn-xs btn-primary btn-block" id="btnFullViewInfo" data-toggle="modal" data-target="#modal-view-info">View Info</a>' +
                                '<a href="'+ data.id + '" class="btn btn-xs btn-warning btn-block" id="btnNoteView" data-toggle="modal" data-target="#modal-dispatcher-view-notee">View Note</a>';
                        }




                    },
                    "name": 'endorsements.acct_status'
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

    $('#sao-audit-table-reports_filter input').unbind();
    $('#sao-audit-table-reports_filter input').bind('keyup change',function (e) {

        if($(this).is(':focus'))
        {
            if (e.keyCode == 13) {
                table_sao_audit.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '') {
                    table_sao_audit.search($(this).val()).draw();
                }
            }
        }
    });


    $('#sao-audit-table-reports').on('click','#btnViewReport', function ()
    {


        // $('#txtAreaNote').html();
        $('#ciReport').val('');
        var accountID = $(this).attr("value");
        var acctName =  $(this).attr("name");
        // console.log(acctName);

        $('#exportNote').attr('name', acctName);

        $.ajax
        ({
            method: 'get',
            url: 'ci-get-report',
            data:
                {
                    'acctID': accountID
                },
            success: function (data)
            {
                /*console.log(data[0].endorsement_report);*/
                $('#ciReport').val(data[0].endorsement_report);

            }

        });
    });






}

$('#modal-ci-note').on('click','#exportNote', function ()
{
    var a = document.body.appendChild
    (
        document.createElement("a")
    );
    var textToWrite = $('#ciReport').val();

    var acctName = $(this).attr('name');
    // console.log(textToWrite);
    a.download = acctName+".txt";
    textToWrite = textToWrite.replace(/\n/g, "%0D%0A");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    console.log(textToWrite);
    a.href = "data:text/plain," + textToWrite+'%0D%0A%0D%0A%0D%0A***NOTE: All HASHTAG SYMBOL ARE REPLACE WITH * (ASTERISK) SYMBOL***';

    setTimeout(function () {
        a.click();
    },1000);
});





$('#sao_table_ci_account_reports').on('click','#btnViewReport', function ()
{
    console.log('GG');

    // $('#txtAreaNote').html();
    $('#acctReport').val('');
    var accountID = $(this).attr("href");
    var acctName =  $(this).attr("name");
    // console.log(acctName);
    $('#exportReport').attr('name', acctName);
    $.ajax
    ({
        method: 'get',
        url: 'ci-get-report',
        data:
            {
                'acctID': accountID
            },
        success: function (data)
        {
            // console.log(data[0].endorsement_report);
            $('#acctReport').val(data[0].endorsement_report);

        }
    });
});



$('#modal-view-report').on('click','#exportReport', function ()
{
    var a = document.body.appendChild
    (
        document.createElement("a")
    );
    var textToWrite = $('#acctReport').val();

    var acctName = $(this).attr('name');
    // console.log(textToWrite);
    a.download = acctName+".txt";
    textToWrite = textToWrite.replace(/\n/g, "%0D%0A");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    textToWrite = textToWrite.replace('#', "*");
    console.log(textToWrite);
    a.href = "data:text/plain," + textToWrite+'%0D%0A%0D%0A%0D%0A***NOTE: All HASHTAG SYMBOL ARE REPLACE WITH * (ASTERISK) SYMBOL***';

    setTimeout(function () {
        a.click();
    },1000);
});


$('#sao_table_ci_account_reports , #endorsement-tablee').on('click', '#btnFullViewInfo', function (e)
{
    var acctID = $(this).attr("href");
    $('#spanhere').html('');
    $('#history').html('');
    $('#otherInfoSpan').html('');
    $('#otherEmployerSpan').html('');
    $('#otherBusinessSpan').html('');

    $.ajax({
        url: '/ao-view-info',
        type: 'get',
        data:
            {
                'acctID': acctID
            },
        dataType: 'json',
        success: function (data)
        {
            console.log(data);

            if(data.length === 0)
            {
                console.log('data empty');
                $('#spanhere').append('No Data Found' +'<br>') ;
            }
            else
            {
                $('#spanhere').append
                (
                    '               <table id="asdfsf" border="3" width="100%" margin="auto">' +
                    '                <tr>' +
                    '                  <td style="padding: 3px;"><span class="badge bg-red">DATE ENDORSED</span></td>' +
                    '                  <td style="padding: 3px;">'+data[0][0].date_endorsed +'</td>' +
                    '                  <td style="padding: 3px;"><span class="badge bg-red">TIME ENDORSED</span></td>\n' +
                    '                  <td style="padding: 3px;">'+data[0][0].time_endorsed +'</td>\n' +
                    '                </tr>\n' +


                    '                <tr>\n' +
                    '                  <td style="padding: 3px;"><span class="badge bg-red">DATE DUE</span></td>\n' +
                    '                  <td style="padding: 3px;">'+data[0][0].date_due +'</td>\n' +
                    '                  <td style="padding: 3px;"><span class="badge bg-red">TIME DUE</span></td>\n' +
                    '                  <td style="padding: 3px;">'+data[0][0].time_due +'</td>\n' +
                    '                </tr>\n' +

                    '                <tr>\n' +
                    '                  <td style="padding: 3px;"><span class="badge bg-red">ACCOUNT NAME</span></td>\n' +
                    '                  <td style="padding: 3px;">'+data[0][0].account_name+'</td>\n' +
                    '                  <td style="padding: 3px;"><span class="badge bg-red">PRIORITY</span></td>\n' +
                    '                  <td style="padding: 3px;">'+data[0][0].prioritize+'</td>\n' +
                    '                </tr>\n' +

                    '                <tr>\n' +
                    '                  <td style="padding: 3px;"><span class="badge bg-red">ADDRESS</span></td>\n' +
                    '                  <td style="padding: 3px;">'+data[0][0].address +'</td>\n' +
                    '                  <td style="padding: 3px;"><span class="badge bg-red">PROVINCE</span></td>\n' +
                    '                  <td style="padding: 3px;">'+data[0][0].provinces +'</td>\n' +
                    '                </tr>\n' +

                    '                <tr>\n' +
                    '                  <td style="padding: 3px;"><span class="badge bg-red">CLIENT NAME</span></td>\n' +
                    '                  <td style="padding: 3px;">'+data[0][0].client_name +'</td>\n' +
                    '                  <td style="padding: 3px;"><span class="badge bg-red">MUNICIPALITY</span></td>\n' +
                    '                  <td style="padding: 3px;">'+data[0][0].muni_name +'</td>\n' +
                    '                </tr>\n' +

                    '                <tr>\n' +
                    '                  <td style="padding: 3px;"><span class="badge bg-red">TYPE OF LOAN</span></td>\n' +
                    '                  <td style="padding: 3px;">'+data[0][0].type_of_loan+'</td>\n' +
                    '                  <td style="padding: 3px;"><span class="badge bg-red">TYPE OF REQUEST</span></td>\n' +
                    '                  <td style="padding: 3px;">'+data[0][0].type_of_request+'</td>\n' +
                    '                </tr>\n' +

                    '                <tr>\n' +
                    '                  <td style="padding: 3px;"><span class="badge bg-red">TYPE OF SENDING REPORT</span></td>\n' +
                    '                  <td style="padding: 3px;">'+data[0][0].type_of_sending_report +'</td>\n' +
                    '                  <td style="padding: 3px;"><span class="badge bg-red">REMARKS</span></td>\n' +
                    '                  <td style="padding: 3px;">'+data[0][0].remarks+'</td>\n' +
                    '                </tr>\n' +

                    '                <tr>\n' +
                    '                  <td style="padding: 3px;"><span class="badge bg-red">TIME FORWARDED TO CLIENT</span></td>\n' +
                    '                  <td style="padding: 3px;">'+data[0][0].time_forwarded_to_client+'</td>\n' +
                    '                  <td style="padding: 3px;"><span class="badge bg-red">DATE FORWARDED TO CLIENT</span></td>\n' +
                    '                  <td style="padding: 3px;">'+data[0][0].date_forwarded_to_client+'</td>\n' +
                    '                </tr>\n' +

                    '                <tr>\n' +
                    '                  <td style="padding: 3px;"><span class="badge bg-red">REQUESTOR</span></td>\n' +
                    '                  <td style="padding: 3px;">'+data[0][0].requestor_name +'</td>\n' +
                    '                  <td style="padding: 3px;"><span class="badge bg-red">SENIOR ACCOUNT OFFICER</span></td>\n' +
                    '                  <td style="padding: 3px;">'+data[0][0].assigned_by_srao+'</td>\n' +
                    '                </tr>\n' +

                    '                <tr>\n' +
                    '                  <td style="padding: 3px;"><span class="badge bg-red">VERIFY THROUGH</span></td>\n' +
                    '                  <td style="padding: 3px;">'+data[0][0].verify_through+'</td>\n' +
                    '                  <td style="padding: 3px;"><span class="badge bg-red">DISPATCHER</span></td>\n' +
                    '                  <td style="padding: 3px;">'+data[0][0].handled_by_dispatcher+'</td>\n' +
                    '                </tr>\n' +

                    '                <tr>\n' +
                    '                  <td style="padding: 3px;"><span class="badge bg-red">PICTURE STATUS</span></td>\n' +
                    '                  <td style="padding: 3px;">'+data[0][0].picture_status+'</td>\n' +
                    '                  <td style="padding: 3px;"><span class="badge bg-red">ACCOUNT OFFICER</span></td>\n' +
                    '                  <td style="padding: 3px;">'+data[0][0].handled_by_account_officer+'</td>\n' +

                    '                </tr>\n' +

                    '                <tr>\n' +
                    '                  <td style="padding: 3px;"><span class="badge bg-red">STATUS EXTERNAL</span></td>\n' +
                    '                  <td style="padding: 3px;">'+data[0][0].endorsement_status_external +'</td>\n' +
                    '                  <td style="padding: 3px;"><span class="badge bg-red">CREDIT INVESTIGATOR</span></td>\n' +
                    '                  <td style="padding: 3px;">'+data[0][0].handled_by_credit_investigator+'</td>\n' +
                    '                </tr>\n' +

                    '                <tr>\n' +
                    '                  <td style="padding: 3px;"><span class="badge bg-red">STATUS INTERNAL FIELD WORK</span></td>\n' +
                    '                  <td style="padding: 3px;">'+data[0][0].endorsement_status_external+'</td>\n' +
                    '                  <td style="padding: 3px;"><span class="badge bg-red">DATE VISIT</span></td>\n' +
                    '                  <td style="padding: 3px;">'+data[0][0].date_ci_visit+'</td>\n' +
                    '                </tr>\n' +

                    '                <tr>\n' +
                    '                  <td style="padding: 3px;"><span class="badge bg-red">STATUS INTERNAL OFFICE WORK</span></td>\n' +
                    '                  <td style="padding: 3px;">'+data[0][0].endorsement_status_internal_2+'</td>\n' +
                    '                  <td style="padding: 3px;"><span class="badge bg-red">TIME VISIT</span></td>\n' +
                    '                  <td style="padding: 3px;">'+data[0][0].time_ci_visit+'</td>\n' +

                    '                </tr>\n' +

                    '              </table>' +

                    '               <table style="margin-top: 15px" width="100%">' +
                    '               <tr style="background-color: brown; color: white">' +
                    '                   <td style="padding: 3px;"><h5>CLIENT REMARKS</h5></td>' +
                    '               <tr>' +

                    '               <tr>' +
                    '                   <td style="padding: 3px;">'+data[0][0].client_remarks+'</td>' +
                    '               <tr>' +
                    '               </table>'
                );


                $('#history').html
                (
                    '<tr style="background-color: brown; color: white">' +
                    '<th style=\'text-align: center;\'>NAME</th>' +
                    '<th style=\'text-align: center;\'>POSITION</th>' +
                    '<th style=\'text-align: center;\'>ACTIVITIES</th>' +
                    '<th style=\'text-align: center;\'>DATE OCCURED</th>' +
                    '<th style=\'text-align: center;\'>TIME OCCURED</th>' +
                    '</tr>'
                );

                $('#otherInfoSpan').html
                (
                    '<tr style="background-color: brown; color: white">' +
                    '   <th style=\'text-align: center;\'>COBORROWER NAME</th>' +
                    '   <th style=\'text-align: center;\'>ADDRESS</th>' +
                    '   <th style=\'text-align: center;\'>CITY/MUNICIPALITY</th>' +
                    '   <th style=\'text-align: center;\'>PROVINCE</th>' +
                    '</tr>'
                );
                $('#otherEmployerSpan').html
                (
                    '<tr style="background-color: brown; color: white">' +
                    '   <th style=\'text-align: center;\'>EMPLOYER NAME</th>' +
                    '   <th style=\'text-align: center;\'>ADDRESS</th>' +
                    '   <th style=\'text-align: center;\'>CITY/MUNICIPALITY</th>' +
                    '   <th style=\'text-align: center;\'>PROVINCE</th>' +
                    '</tr>'
                );
                $('#otherBusinessSpan').html
                (
                    '<tr style="background-color: brown; color: white">' +
                    '   <th style=\'text-align: center;\'>BUSINESS NAME</th>' +
                    '   <th style=\'text-align: center;\'>ADDRESS</th>' +
                    '   <th style=\'text-align: center;\'>CITY/MUNICIPALITY</th>' +
                    '   <th style=\'text-align: center;\'>PROVINCE</th>' +
                    '</tr>'
                );

                for(ctrr = 0;ctrr <= (data[1].length)-1;ctrr++)
                {
                    $('#history').append
                    (
                        '<tr>' +
                        '<td style="padding: 3px;">' +data[1][ctrr].name + '</td>' +
                        '<td style="padding: 3px;">' +data[1][ctrr].position + '</td>' +
                        '<td style="padding: 3px;">' +data[1][ctrr].activities + '</td>' +
                        '<td style="padding: 3px;">' +data[1][ctrr].date_occured + '</td>' +
                        '<td style="padding: 3px;">' +data[1][ctrr].time_occured + '</td>' +
                        '</tr>'
                    );
                }


                for (ctrr = 0; ctrr <= (data[2].length) - 1; ctrr++) {
                    $('#otherInfoSpan').append
                    (
                        '<tr>' +
                        '   <td style="padding: 3px;">' + data[2][ctrr].coborrower_name + '</td>' +
                        '   <td style="padding: 3px;">' + data[2][ctrr].coborrower_address + '</td>' +
                        '   <td style="padding: 3px;">' + data[2][ctrr].coborrower_municipality + '</td>' +
                        '   <td style="padding: 3px;">' + data[2][ctrr].coborrower_province + '</td>' +
                        '</tr>'
                    );
                }



                for(ctrr = 0;ctrr<=(data[3].length)-1;ctrr++)
                {
                    $('#otherEmployerSpan').append
                    (
                        '<tr>' +
                        '   <td style="padding: 3px;">' +data[3][ctrr].employer_name+ '</td>' +
                        '   <td style="padding: 3px;">' +data[0][ctrr].address+ '</td>' +
                        '   <td style="padding: 3px; text-transform: uppercase">' +data[0][ctrr].muni_name+ '</td>' +
                        '   <td style="padding: 3px;">' +data[0][ctrr].provinces+ '</td>' +
                        '</tr>'
                    );
                }



                for (ctrr = 0; ctrr <= (data[4].length) - 1; ctrr++) {
                    $('#otherBusinessSpan').append
                    (
                        '<tr>' +
                        '   <td style="padding: 3px;">' + data[4][ctrr].business_name + '</td>' +
                        '   <td style="padding: 3px;">' + data[0][ctrr].address + '</td>' +
                        '   <td style="padding: 3px; text-transform: uppercase">' +data[0][ctrr].muni_name+ '</td>' +
                        '   <td style="padding: 3px;">' + data[0][ctrr].provinces + '</td>' +
                        '</tr>'
                    );
                }

                if(data[2].length===0)
                {
                    $('#otherInfoSpan').hide();
                }
                else
                {
                    $('#otherInfoSpan').show();
                }

                if(data[3].length===0)
                {
                    $('#otherEmployerSpan').hide();
                }
                else
                {
                    $('#otherEmployerSpan').show();
                }

                if(data[4].length===0)
                {
                    $('#otherBusinessSpan').hide();
                }
                else
                {
                    $('#otherBusinessSpan').show();
                }
            }
        }
    })
});

$('#sao_table_ci_account_reports').on('click','.btnAuditDownload', function ()
{
    var acctID = $(this).attr('value');
    var type = $(this).attr('name');

    console.log(type);

    // $.ajax
    // ({
    //     method: 'get',
    //     url: 'sao-ci-account-download-report',
    //     data:
    //         {
    //             'acctID': acctID,
    //             'type': type
    //         },
    //     success: function (data)
    //     {
    //         if(data=='exist')
    //         {
    //             alert('Report Not Available!');
    //         }
    //         else
    //         {
    //         }
    //     }
    // });

    Download_ci_report(acctID,type);

});

function Download_ci_report(id,typ) {

    var q = '<form action="/sao-ci-account-download-report" target="_blank" method="get">'+
        '<div class="input-group">'+
        '<input type="text" hidden value="'+id+'" name="acctID">'+
        '<input type="text" hidden value="'+typ+'" name="type">'+
        '<button type="submit" id="button_form_download_ci_report">'+
        '</button>'+
        '</span>'+
        '</div>'+
        '</form>';

    $('#down_form_ci_report').html(q);
    $('#button_form_download_ci_report').click();
    // window.location = '/ao-panel';
}

$('#table_fund_req').on('click', '#BtnApproved', function (e)
{
    // console.log('approved : '+$(this).attr('href'))

    var id = $(this).attr('href');
    $('#appFundReqNow').attr('href', id);
    $('#modal-modify-fund').modal('show');
    $('#newFundReqAmount').attr('disabled', true).val(atob($(this).attr('name')));
    $('#openInputFundAmt').attr('disabled', false);
    $('#closeInputFundAmt').hide();

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

$('#appFundReqNow').click(function()
{
    var btn = $(this);
    btn.attr('disabled', true);
    var id = $(this).attr('href');
    var valAmount = $('#newFundReqAmount').val();
    if(valAmount > 0)
    {
        if(valAmount <= 2500)
        {
            $.ajax
            ({
                method: 'get',
                url: '/srao-apporoved-req',
                data:
                    {
                        'id' : id,
                        'amt' : valAmount
                    },
                success: function (data)
                {
                    if(data=='errorCancelled')
                    {
                        alert('Dispatcher Cancelled the request');
                    }
                    else if(data=='success')
                    {
                        alert('Fund Successfully Approved!')
                    }
                    $('#modal-modify-fund').modal('hide');
                    table_ci_fund.ajax.reload(null, false);
                    refreshApp = true;
                    btn.attr('disabled', false);

                },
                error : function (data) {
                    console.log('error')
                    btn.attr('disabled', false);
                }
            });
        }
        else if(valAmount > 2500)
        {
            alert('Amount submitted exceeded the limit of SAO approval');
            btn.attr('disabled', false);
        }

    }
    else if(valAmount <= 0)
    {
        alert('Please specify amount!');
        btn.attr('disabled', false);
    }



});

$('#table_fund_req').on('click', '#BtnDeclined', function ()
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
            url: '/srao-declined-req',
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
                refreshDec = true;
            },
            complete : function () {
                $('#BtnDeclined').removeAttr('disabled');
                $('#modal-remarks-disapprove').modal('hide');
                $('#remarksDis').val('');

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



$('#aolist-table').on('click', '#btnViewFullInfo', function (e)
{
    // var tr = $(this).('tr');
    var acctID = $(this).attr('href');
    $('#spanhereView').html('');
    $('#historyView').html('');
    $('#otherInfoSpanView').html('');
    $('#otherEmployerSpanView').html('');
    $('#otherBusinessSpanView').html('');

    $.ajax({
        url: '/ao-view-info',
        type: 'GET',
        data:
            {
                'acctID': acctID
            },
        dataType: 'json',
        success: function (data)
        {
            console.log(data);

            if(data.length === 0)
            {
                console.log('data empty');
                $('#spanherView').append('No Data Found' +'<br>') ;
            }
            else
            {
                $('#spanhereView').append
                (
                    '               <table id="asdfsf" border="3" width="100%" margin="auto">' +
                    '                <tr>' +
                    '                  <td style="padding: 3px;"><span class="badge bg-red">DATE ENDORSED</span></td>' +
                    '                  <td style="padding: 3px;">'+data[0][0].date_endorsed +'</td>' +
                    '                  <td style="padding: 3px;"><span class="badge bg-red">TIME ENDORSED</span></td>\n' +
                    '                  <td style="padding: 3px;">'+data[0][0].time_endorsed +'</td>\n' +
                    '                </tr>\n' +


                    '                <tr>\n' +
                    '                  <td style="padding: 3px;"><span class="badge bg-red">DATE DUE</span></td>\n' +
                    '                  <td style="padding: 3px;">'+data[0][0].date_due +'</td>\n' +
                    '                  <td style="padding: 3px;"><span class="badge bg-red">TIME DUE</span></td>\n' +
                    '                  <td style="padding: 3px;">'+data[0][0].time_due +'</td>\n' +
                    '                </tr>\n' +

                    '                <tr>\n' +
                    '                  <td style="padding: 3px;"><span class="badge bg-red">ACCOUNT NAME</span></td>\n' +
                    '                  <td style="padding: 3px;">'+data[0][0].account_name+'</td>\n' +
                    '                  <td style="padding: 3px;"><span class="badge bg-red">PRIORITY</span></td>\n' +
                    '                  <td style="padding: 3px;">'+data[0][0].prioritize+'</td>\n' +
                    '                </tr>\n' +

                    '                <tr>\n' +
                    '                  <td style="padding: 3px;"><span class="badge bg-red">ADDRESS</span></td>\n' +
                    '                  <td style="padding: 3px;">'+data[0][0].address +'</td>\n' +
                    '                  <td style="padding: 3px;"><span class="badge bg-red">PROVINCE</span></td>\n' +
                    '                  <td style="padding: 3px;">'+data[0][0].provinces +'</td>\n' +
                    '                </tr>\n' +

                    '                <tr>\n' +
                    '                  <td style="padding: 3px;"><span class="badge bg-red">CLIENT NAME</span></td>\n' +
                    '                  <td style="padding: 3px;">'+data[0][0].client_name +'</td>\n' +
                    '                  <td style="padding: 3px;"><span class="badge bg-red">MUNICIPALITY</span></td>\n' +
                    '                  <td style="padding: 3px;">'+data[0][0].muni_name +'</td>\n' +
                    '                </tr>\n' +

                    '                <tr>\n' +
                    '                  <td style="padding: 3px;"><span class="badge bg-red">TYPE OF LOAN</span></td>\n' +
                    '                  <td style="padding: 3px;">'+data[0][0].type_of_loan+'</td>\n' +
                    '                  <td style="padding: 3px;"><span class="badge bg-red">TYPE OF REQUEST</span></td>\n' +
                    '                  <td style="padding: 3px;">'+data[0][0].type_of_request+'</td>\n' +
                    '                </tr>\n' +

                    '                <tr>\n' +
                    '                  <td style="padding: 3px;"><span class="badge bg-red">TYPE OF SENDING REPORT</span></td>\n' +
                    '                  <td style="padding: 3px;">'+data[0][0].type_of_sending_report +'</td>\n' +
                    '                  <td style="padding: 3px;"><span class="badge bg-red">REMARKS</span></td>\n' +
                    '                  <td style="padding: 3px;">'+data[0][0].remarks+'</td>\n' +
                    '                </tr>\n' +

                    '                <tr>\n' +
                    '                  <td style="padding: 3px;"><span class="badge bg-red">TIME FORWARDED TO CLIENT</span></td>\n' +
                    '                  <td style="padding: 3px;">'+data[0][0].time_forwarded_to_client+'</td>\n' +
                    '                  <td style="padding: 3px;"><span class="badge bg-red">DATE FORWARDED TO CLIENT</span></td>\n' +
                    '                  <td style="padding: 3px;">'+data[0][0].date_forwarded_to_client+'</td>\n' +
                    '                </tr>\n' +

                    '                <tr>\n' +
                    '                  <td style="padding: 3px;"><span class="badge bg-red">REQUESTOR</span></td>\n' +
                    '                  <td style="padding: 3px;">'+data[0][0].requestor_name +'</td>\n' +
                    '                  <td style="padding: 3px;"><span class="badge bg-red">SENIOR ACCOUNT OFFICER</span></td>\n' +
                    '                  <td style="padding: 3px;">'+data[0][0].assigned_by_srao+'</td>\n' +
                    '                </tr>\n' +

                    '                <tr>\n' +
                    '                  <td style="padding: 3px;"><span class="badge bg-red">VERIFY THROUGH</span></td>\n' +
                    '                  <td style="padding: 3px;">'+data[0][0].verify_through+'</td>\n' +
                    '                  <td style="padding: 3px;"><span class="badge bg-red">DISPATCHER</span></td>\n' +
                    '                  <td style="padding: 3px;">'+data[0][0].handled_by_dispatcher+'</td>\n' +
                    '                </tr>\n' +

                    '                <tr>\n' +
                    '                  <td style="padding: 3px;"><span class="badge bg-red">PICTURE STATUS</span></td>\n' +
                    '                  <td style="padding: 3px;">'+data[0][0].picture_status+'</td>\n' +
                    '                  <td style="padding: 3px;"><span class="badge bg-red">ACCOUNT OFFICER</span></td>\n' +
                    '                  <td style="padding: 3px;">'+data[0][0].handled_by_account_officer+'</td>\n' +

                    '                </tr>\n' +

                    '                <tr>\n' +
                    '                  <td style="padding: 3px;"><span class="badge bg-red">STATUS EXTERNAL</span></td>\n' +
                    '                  <td style="padding: 3px;">'+data[0][0].endorsement_status_external +'</td>\n' +
                    '                  <td style="padding: 3px;"><span class="badge bg-red">CREDIT INVESTIGATOR</span></td>\n' +
                    '                  <td style="padding: 3px;">'+data[0][0].handled_by_credit_investigator+'</td>\n' +
                    '                </tr>\n' +

                    '                <tr>\n' +
                    '                  <td style="padding: 3px;"><span class="badge bg-red">STATUS INTERNAL FIELD WORK</span></td>\n' +
                    '                  <td style="padding: 3px;">'+data[0][0].endorsement_status_external+'</td>\n' +
                    '                  <td style="padding: 3px;"><span class="badge bg-red">DATE VISIT</span></td>\n' +
                    '                  <td style="padding: 3px;">'+data[0][0].date_ci_visit+'</td>\n' +
                    '                </tr>\n' +

                    '                <tr>\n' +
                    '                  <td style="padding: 3px;"><span class="badge bg-red">STATUS INTERNAL OFFICE WORK</span></td>\n' +
                    '                  <td style="padding: 3px;">'+data[0][0].endorsement_status_internal_2+'</td>\n' +
                    '                  <td style="padding: 3px;"><span class="badge bg-red">TIME VISIT</span></td>\n' +
                    '                  <td style="padding: 3px;">'+data[0][0].time_ci_visit+'</td>\n' +

                    '                </tr>\n' +

                    '              </table>'
                );


                $('#historyView').html
                (
                    '<tr style="background-color: brown; color: white">' +
                    '<th style=\'text-align: center;\'>NAME</th>' +
                    '<th style=\'text-align: center;\'>POSITION</th>' +
                    '<th style=\'text-align: center;\'>ACTIVITIES</th>' +
                    '<th style=\'text-align: center;\'>DATE OCCURED</th>' +
                    '<th style=\'text-align: center;\'>TIME OCCURED</th>' +
                    '</tr>'
                );

                $('#otherInfoSpanView').html
                (
                    '<tr style="background-color: brown; color: white">' +
                    '   <th style=\'text-align: center;\'>COBORROWER NAME</th>' +
                    '   <th style=\'text-align: center;\'>ADDRESS</th>' +
                    '   <th style=\'text-align: center;\'>CITY/MUNICIPALITY</th>' +
                    '   <th style=\'text-align: center;\'>PROVINCE</th>' +
                    '</tr>'
                );
                $('#otherEmployerSpanView').html
                (
                    '<tr style="background-color: brown; color: white">' +
                    '   <th style=\'text-align: center;\'>EMPLOYER NAME</th>' +
                    '   <th style=\'text-align: center;\'>ADDRESS</th>' +
                    '   <th style=\'text-align: center;\'>CITY/MUNICIPALITY</th>' +
                    '   <th style=\'text-align: center;\'>PROVINCE</th>' +
                    '</tr>'
                );
                $('#otherBusinessSpanView').html
                (
                    '<tr style="background-color: brown; color: white">' +
                    '   <th style=\'text-align: center;\'>BUSINESS NAME</th>' +
                    '   <th style=\'text-align: center;\'>ADDRESS</th>' +
                    '   <th style=\'text-align: center;\'>CITY/MUNICIPALITY</th>' +
                    '   <th style=\'text-align: center;\'>PROVINCE</th>' +
                    '</tr>'
                );

                for(ctrr = 0;ctrr <= (data[1].length)-1;ctrr++)
                {
                    $('#historyView').append
                    (
                        '<tr>' +
                        '<td style="padding: 3px;">' +data[1][ctrr].name + '</td>' +
                        '<td style="padding: 3px;">' +data[1][ctrr].position + '</td>' +
                        '<td style="padding: 3px;">' +data[1][ctrr].activities + '</td>' +
                        '<td style="padding: 3px;">' +data[1][ctrr].date_occured + '</td>' +
                        '<td style="padding: 3px;">' +data[1][ctrr].time_occured + '</td>' +
                        '</tr>'
                    );
                }


                for (ctrr = 0; ctrr <= (data[2].length) - 1; ctrr++) {
                    $('#otherInfoSpanView').append
                    (
                        '<tr>' +
                        '   <td style="padding: 3px;">' + data[2][ctrr].coborrower_name + '</td>' +
                        '   <td style="padding: 3px;">' + data[2][ctrr].coborrower_address + '</td>' +
                        '   <td style="padding: 3px;">' + data[2][ctrr].coborrower_municipality + '</td>' +
                        '   <td style="padding: 3px;">' + data[2][ctrr].coborrower_province + '</td>' +
                        '</tr>'
                    );
                }



                for(ctrr = 0;ctrr<=(data[3].length)-1;ctrr++)
                {
                    $('#otherEmployerSpanView').append
                    (
                        '<tr>' +
                        '   <td style="padding: 3px;">' +data[3][ctrr].employer_name+ '</td>' +
                        '   <td style="padding: 3px;">' +data[0][ctrr].address+ '</td>' +
                        '   <td style="padding: 3px; text-transform: uppercase">' +data[0][ctrr].muni_name+ '</td>' +
                        '   <td style="padding: 3px;">' +data[0][ctrr].provinces+ '</td>' +
                        '</tr>'
                    );
                }



                for (ctrr = 0; ctrr <= (data[4].length) - 1; ctrr++) {
                    $('#otherBusinessSpanView').append
                    (
                        '<tr>' +
                        '   <td style="padding: 3px;">' + data[4][ctrr].business_name + '</td>' +
                        '   <td style="padding: 3px;">' + data[0][ctrr].address + '</td>' +
                        '   <td style="padding: 3px; text-transform: uppercase">' +data[0][ctrr].muni_name+ '</td>' +
                        '   <td style="padding: 3px;">' + data[0][ctrr].provinces + '</td>' +
                        '</tr>'
                    );
                }


                if(data[2].length===0)
                {
                    $('#otherInfoSpanView').hide();
                }
                else
                {
                    $('#otherInfoSpanView').show();
                }


                if(data[3].length===0)
                {
                    $('#otherEmployerSpanView').hide();
                }
                else
                {
                    $('#otherEmployerSpanView').show();
                }

                if(data[4].length===0)
                {
                    $('#otherBusinessSpanView').hide();
                }
                else
                {
                    $('#otherBusinessSpanView').show();
                }


            }
        }
    })
});

$('#aolist-table').on('click','#btnUpdateInfo', function ()
{
    acctID = $(this).attr("href");
    $.ajax
    ({
        url: '/srao-get-updated-info',
        type: 'GET',
        data:
            {
                'acctID': acctID
            },
        success: function (data)
        {
            var temp =
                '                                                    <div class="row">\n' +
                '                                                        <div class="box box-danger">\n' +
                '                                                            <div class="box-header with-border">\n' +
                '                                                                <h3 class="box-title">Account Status</h3>\n' +
                '                                                            </div>\n' +
                '                                                            <div class="box-body">\n' +
                '                                                                <div class="row">\n' +
                '                                                                    <div class="form-group col-xs-4">\n' +
                '                                                                        <label>Date Forward to Client:</label>\n' +
                '                                                                        <div class="input-group">\n' +
                '                                                                            <div class="input-group-addon">\n' +
                '                                                                                <i class="fa fa-calendar"></i>\n' +
                '                                                                            </div>\n' +
                '                                                                            <input type="text" class="form-control" id="txtDateDue" data-inputmask="\'alias\': \'yyyy-mm-dd\'" data-mask>\n' +
                '                                                                        </div>\n' +
                '                                                                    </div>\n' +
                '                                                                    <div class="bootstrap-timepicker">\n' +
                '                                                                        <div class="form-group col-xs-4">\n' +
                '                                                                            <label>Time Forward to Client:</label>\n' +
                '                                                                            <div class="input-group">\n' +
                '                                                                                <input type="text" id="txtTimeDue" class="form-control timepicker">\n' +
                '                                                                                <div class="input-group-addon">\n' +
                '                                                                                    <i class="fa fa-clock-o"></i>\n' +
                '                                                                                </div>\n' +
                '                                                                            </div>\n' +
                '                                                                        </div>\n' +
                '                                                                    </div>\n' +
                '                                                                    <div class="form-group col-xs-4">\n' +
                '                                                                        <label>Account Status (Internal):</label>\n' +
                '                                                                        <select class="form-control select1" id="txtInternalStatus" style="width: 100%;">\n' +
                '                                                                            <option value="TAT">TAT</option>\n' +
                '                                                                            <option value="OVERDUE">Overdue</option>\n' +
                '                                                                        </select>\n' +
                '                                                                    </div>\n' +
                '                                                                </div>\n' +
                '                                                            </div>\n' +
                '                                                        </div>\n' +
                '                                                    </div>\n' +
                '\n' +
                '                                                    <div class="row">\n' +
                '                                                        <div class="box box-danger">\n' +
                '                                                            <div class="box-header with-border">\n' +
                '                                                                <h3 class="box-title">OTHER INFORMATION</h3>\n' +
                '                                                            </div>\n' +
                '                                                            <div class="box-body">\n' +
                '\n' +
                '                                                                <div class="row">\n' +
                '                                                                    <div class="form-group col-xs-6">\n' +
                '                                                                        <label>Picture Status:</label>\n' +
                '                                                                        <select class="form-control select1" id="txtPictureStatus" style="width: 100%;">\n' +
                '                                                                            <option value="WITH">With</option>\n' +
                '                                                                            <option value="WITHOUT">Without</option>\n' +
                '                                                                        </select>\n' +
                '                                                                    </div>\n' +
                '\n' +
                '                                                                    <div class="form-group col-xs-6">\n' +
                '                                                                        <label>Type of Sending Report:</label>\n' +
                '                                                                        <select class="form-control select1" id="txtTOSR" style="width: 100%;">\n' +
                '                                                                            <option value="TEMPLATE">Template</option>\n' +
                '                                                                            <option value="DICTATE">Dictate</option>\n' +
                '                                                                        </select>\n' +
                '                                                                    </div>\n' +
                '                                                                </div>\n' +
                '                                                                <div class="row">\n' +
                '                                                                   <div class="form-group col-xs-9">\n' +
                '                                                                   <label>Declared Address:</label>\n' +
                '                                                                   <input type="text" id="txtAddVer" class="form-control" disabled>\n' +
                '                                                                </div>\n' +
                '                                                                <div class="form-group col-xs-3">\n' +
                '                                                                   <label>Verification:</label>\n' +
                '                                                                   <select class="form-control select1" id="selectAddVer" style="width: 100%;">\n' +
                '                                                                       <option selected="selected" value="1">Verified Address</option>\n' +
                '                                                                       <option value="2">Address Not Verified</option>\n' +
                '                                                                   </select>\n' +
                '                                                                </div>\n' +
                '                                                           </div>' +
                '\n' +
                '                                                                <div class="row">\n' +
                '                                                                    <div class="form-group col-xs-12">\n' +
                '                                                                        <label>Remarks:</label>\n' +
                '                                                                        <textarea class="form-control" id="txtRemarks" rows="5" placeholder="Enter Remarks ..."></textarea>\n' +
                '                                                                    </div>\n' +
                '                                                                </div>\n' +
                '\n' +
                '                                                            </div>\n' +
                '                                                        </div>\n' +
                '                                                    </div>\n';

            $('#getUpdatedInfo').html('');
            $('#getUpdatedInfo').append(temp);
            $('#txtDateDue').val(data[0].date_forwarded_to_client);
            $('#txtTimeDue').val(data[0].time_forwarded_to_client);
            $('#txtInternalStatus').val(data[0].endorsement_status_internal);
            $('#txtPictureStatus').val(data[0].picture_status);
            $('#txtTOSR').val(data[0].type_of_sending_report);
            $('#txtRemarks').val(data[0].remarks);

            if(data[0].add_verification==='VERIFIED ADDRESS')
            {
                $('#txtAddVer').val(data[0].address+' '+data[0].city_muni+' '+data[0].provinces);
            }
            else
            {
                $('#txtAddVer').val('');
                $('#txtAddVer').attr('disabled',false);
                $('#selectAddVer').val(2);
                $('#txtAddVer').val(data[0].add_verification);
            }
        }
    });



});

$('#modal-sao-update-info').on('change','#selectAddVer', function ()
{
    if($('#selectAddVer').val()==1)
    {
        $.ajax
        ({
            method: 'get',
            url: '/ao-get-address',
            data:
                {
                    'acctID': acctID
                },
            success: function (data)
            {
                $('#txtAddVer').val('');
                $('#txtAddVer').attr('disabled',true);
                $('#txtAddVer').val(data[0].address+' '+data[0].city_muni+' '+data[0].provinces)
            }
        });
    }
    else
    {
        $('#txtAddVer').val('');
        $('#txtAddVer').attr('placeholder','Please input verified address');
        $('#txtAddVer').removeAttr('disabled');
        $.ajax
        ({
            method: 'get',
            url: '/ao-get-address',
            data:
                {
                    'acctID': acctID
                },
            success: function (data)
            {
                $('#txtAddVer').val('');
                $('#txtAddVer').attr('disabled',false);
                $('#txtAddVer').val(data[0].add_verification)
            }
        });
    }
});

$('#btnSaoUpdateSubmit').click(function ()
{
    var txtDateForward = $('#txtDateDue').val();
    var txtTimeForward = $('#txtTimeDue').val();
    var txtInternalStatus = $('#txtInternalStatus').val();
    var txtPictureStatus = $('#txtPictureStatus').val();
    var txtTOSR = $('#txtTOSR').val();
    var txtRemarks = $('#txtRemarks').val();


    if($('#selectAddVer').val()==1)
    {
        verAdd = 'VERIFIED ADDRESS';
    }
    else
    {
        verAdd = 'ADDRESS NOT VERIFIED - '+$('#txtAddVer').val();
    }

    $.ajax
    ({
        url: '/srao-update-ao-info',
        type: 'POST',
        data:
            {
                'acctID': acctID,
                'txtDateForward': txtDateForward,
                'txtTimeForward': txtTimeForward,
                'txtInternalStatus': txtInternalStatus,
                'txtPictureStatus': txtPictureStatus,
                'txtTOSR': txtTOSR,
                'txtRemarks': txtRemarks,
                'txtVerAdd': verAdd
            },
        success: function (data)
        {
            $('#modal-sao-update-info').modal('hide');
            alert("Successfully Updated");
        }
    });

});

$('#endorsement-tablee').on('click', '#btnAssign', function (e)
{
    $('#sao_additional_client_note').val('');
    $('#additional_note_from_client').hide();
    // var tr = $(this).closest('tr');
    id = $(this).attr("href");

    $.ajax({

        url: 'sao_get_info_for_assign',
        method: 'get',
        data:{
            'id': id
        },
        success : function (data) {

            console.log(data);

            dateEndorsed = data[0].date;
            timeEndorsed = data[0].time;
            var accountName = data[0].acct_name;
            var typeOfRequest = data[0].tor;
            var muni = data[0].muni_name;
            var province = data[0].provi_name;



            $(".id").html('ID: '+ id);
            $(".dateTime").html('Date Time Endorsed: '+ dateEndorsed + ' ' + timeEndorsed);
            $(".accountName").html('Account Name: '+ accountName);
            $(".type_of_loan").html('Type Of Loan: '+ data[0].loan);

            // console.log(typeOfRequest);

            var checktor = typeOfRequest.split(' :');


            if(checktor[0] === 'PDRN')
            {
                $(".coborName").html('Coborrowers and Addresses: ' + ' <a name="'+id+'" class="btn btn-xs btn-primary" id="btnOtherInfoFromDiss" data-toggle="modal" data-target="#otherInfo"><i class="glyphicon glyphicon-search"></i> View Information</a>');

                $(".province").html('Location: '+muni+', '+province);

                $(".typeOfRequest").html('Type of Request: <b>'+ checktor[0] +'</b>');

            }
            else if(checktor[0] === 'EVR')
            {

                $(".coborName").html('Coborrowers and Addresses: ' + ' <a name="'+id+'" class="btn btn-xs btn-primary" id="btnOtherInfoFromDiss" data-toggle="modal" data-target="#otherInfo"><i class="glyphicon glyphicon-search"></i> View Information</a>');


                $(".province").html('Location: '+muni+', '+province);

                $(".typeOfRequest").html('Type of Request: <b>'+ checktor[0]+'</b>');

            }
            else if(checktor[0] === 'BVR')
            {
                $(".coborName").html('Coborrowers and Addresses: ' + ' <a name="'+id+'" class="btn btn-xs btn-primary" id="btnOtherInfoFromDiss" data-toggle="modal" data-target="#otherInfo"><i class="glyphicon glyphicon-search"></i> View Information</a>');


                $(".province").html('Location: '+muni+', '+province);

                $(".typeOfRequest").html('Type of Request: <b>'+ checktor[0]+'</b>');
            }

            $('#accountID').val(id);
            $('#accountName').val(accountName);
            if(data[0].note != null)
            {
                $('#sao_additional_client_note').val(data[0].note);
                $('#additional_note_from_client').show();
            }
            else {
                $('#sao_additional_client_note').val('');

            }


        },
        error : function () {

        }

    });

    $('#btnOtherInfoFromDiss').click(function () {

        var acctID = $(this).attr("name");
        $('#otherInfoSpanV3').html('');
        $('#otherEmployerSpanV3').html('');
        $('#otherBusinessSpanV3').html('');

        console.log('yoyo');

        $.ajax({
            url: '/srao-get-other-info',
            type: 'GET',
            data:
                {
                    'acctID': acctID
                },
            success: function (data)
            {
                // console.log(data);

                if(data.length === 0)
                {
                    console.log('data empty');
                }
                else
                {


                    $('#otherInfoSpanV3').html
                    (
                        '<tr style="background-color: brown; color: white">' +
                        '   <th style=\'text-align: center;\'>COBORROWER NAME</th>' +
                        '   <th style=\'text-align: center;\'>ADDRESS</th>' +
                        '   <th style=\'text-align: center;\'>CITY/MUNICIPALITY</th>' +
                        '   <th style=\'text-align: center;\'>PROVINCE</th>' +
                        '</tr>'
                    );

                    for (ctrr = 0; ctrr <= (data[0].length) - 1; ctrr++)
                    {
                        $('#otherInfoSpanV3').append
                        (
                            '<tr>' +
                            '   <td style="padding: 3px;">' + data[0][ctrr].coborrower_name + '</td>' +
                            '   <td style="padding: 3px;">' + data[0][ctrr].coborrower_address + '</td>' +
                            '   <td style="padding: 3px;">' + data[0][ctrr].coborrower_municipality + '</td>' +
                            '   <td style="padding: 3px;">' + data[0][ctrr].coborrower_province + '</td>' +
                            '</tr>'
                        );

                    }

                    $('#otherEmployerSpanV3').html
                    (
                        '<tr style="background-color: brown; color: white">' +
                        '   <th style=\'text-align: center;\'>EMPLOYER NAME</th>' +
                        '   <th style=\'text-align: center;\'>ADDRESS</th>' +
                        '   <th style=\'text-align: center;\'>CITY/MUNICIPALITY</th>' +
                        '   <th style=\'text-align: center;\'>PROVINCE</th>' +
                        '</tr>'
                    );

                    for(ctrr = 0;ctrr<=(data[1].length)-1;ctrr++)
                    {
                        $('#otherEmployerSpanV3').append
                        (
                            '<tr>' +
                            '   <td style="padding: 3px;">' +data[1][ctrr].employer_name+ '</td>' +
                            '   <td style="padding: 3px;">' +data[1][ctrr].employer_address+ '</td>' +
                            '   <td style="padding: 3px;">' +data[1][ctrr].employer_municipality+ '</td>' +
                            '   <td style="padding: 3px;">' +data[1][ctrr].employer_province+ '</td>' +
                            '</tr>'
                        );
                    }

                    $('#otherBusinessSpanV3').html
                    (
                        '<tr style="background-color: brown; color: white">' +
                        '   <th style=\'text-align: center;\'>BUSINESS NAME</th>' +
                        '   <th style=\'text-align: center;\'>ADDRESS</th>' +
                        '   <th style=\'text-align: center;\'>CITY/MUNICIPALITY</th>' +
                        '   <th style=\'text-align: center;\'>PROVINCE</th>' +
                        '</tr>'
                    );

                    for (ctrr = 0; ctrr <= (data[2].length) - 1; ctrr++)
                    {
                        $('#otherBusinessSpanV3').append
                        (
                            '<tr>' +
                            '   <td style="padding: 3px;">' + data[2][ctrr].business_name + '</td>' +
                            '   <td style="padding: 3px;">' + data[2][ctrr].business_address + '</td>' +
                            '   <td style="padding: 3px;">' + data[2][ctrr].business_municipality + '</td>' +
                            '   <td style="padding: 3px;">' + data[2][ctrr].business_province + '</td>' +
                            '</tr>'
                        );
                    }

                    if(data[0].length===0)
                    {
                        $('#otherInfoSpanV3').hide();
                    }
                    else
                    {
                        $('#otherInfoSpanV3').show();
                    }


                    if(data[1].length===0)
                    {
                        $('#otherEmployerSpanV3').hide();
                    }
                    else
                    {
                        $('#otherEmployerSpanV3').show();
                    }

                    if(data[2].length===0)
                    {
                        $('#otherBusinessSpanV3').hide();
                    }
                    else
                    {
                        $('#otherBusinessSpanV3').show();
                    }
                }
            }
        })

    });

});

$('#btnAssigns').click(function (event)
{
    var accountID = id;
    // var accountName = $('#acctName').val();
    var accountName = $('#accountName').val();
    var aoID = parseInt($('#aoID').val());

    var aoName = $('#aoID').children('option:selected').text();
    var getaolist = aoName +'';
    var getao = getaolist.split(' --- ');


    var aim = 'assign';

    $.ajax
    ({
        method: 'post',
        url: '/sao-assign-to-ao',
        data: {
            'accountID': accountID,
            'accountName': accountName,
            'aoID': aoID,
            'aoName': getao[0],
            'aim': aim,
            '_token': $('input[name=_token]').val()
        },
        beforeSend : function()
        {
            $('#toOverlayDispSao').addClass('overlay').html('<i class="fa fa-refresh fa-spin"></i>');
        },
        success: function (data)
        {
            // console.log('assign?');

            if(data.errorDispatch===500)
            {
                // table.ajax.reload(null, false);
                tablee.ajax.reload(null, false);
                // tableee.ajax.reload(null, false);
                alert('This Account is Already Assigned to another AO');
            }
            else if (data.errorDispatch===600)
            {
                // table.ajax.reload(null, false);
                tablee.ajax.reload(null, false);
                // tableee.ajax.reload(null, false);
                alert('This Account were been Hold or Cancel');
            }
            else
            {
                $('#accountID').val('');
                $('#acctName').val('');
            }

            $.ajax
            ({
                url: '/srao-get-ao-counts',
                type: 'GET',
                success: function (data)
                {

                    // console.log('ao: '+data);

                    var getaos = '';
                    var img = 'avatar/.png';
                    console.log(data);
                    for(var ctr=0; ctr<parseInt(data[2]); ctr++){
                        getaos += '<option value=" '+data[1][ctr]+'">'+data[0][ctr]+'</option>';
//<img src="avatar/.png">
                    }
                    $('#aoID').html(getaos);

                }
            });

            $('#toOverlayDispSao').removeClass('overlay').html('');
            // table.ajax.reload(null, false);
            tablee.ajax.reload(null, false);
            // tableee.ajax.reload(null, false);
        },
        error: function () {

            alert('Failed to send Email notification or Something went wrong.');

            console.log('error?');
        }
    });
});

$('#tableholdcancel').on('click', '#btnCancelEndorse', function (e)
{
    var getching = $(this).attr('name').split(':');
    var id = getching[0];
    var accountName = getching[1];

    $('#accountID').val(id);
    $('#accountName').val(accountName);
});

$('#tableholdcancel').on('click', '#btnHoldEndorse', function (e)
{
    var getching = $(this).attr('name').split(':');
    var id = getching[0];
    var accountName = getching[1];

    $('#accountID').val(id);
    $('#accountName').val(accountName);
});

$('#tableholdcancel').on('click', '#btnUncancelEndorse', function (e)
{
    var getching = $(this).attr('name').split(':');
    var id = getching[0];
    var accountName = getching[1];

    $('#accountID').val(id);
    $('#accountName').val(accountName);
});

$('#tableholdcancel').on('click', '#btnUnholdEndorse', function (e)
{
    var getching = $(this).attr('name').split(':');
    var id = getching[0];
    var accountName = getching[1];

    $('#accountID').val(id);
    $('#accountName').val(accountName);
});


$('#tableholdcancel').on('click', '#btnReturnEndorse', function (e)
{
    var getching = $(this).attr('name').split(':');
    var id = getching[0];
    var accountName = getching[1];

    $('#accountID').val(id);
    $('#accountName').val(accountName);
});


$('#tableholdcancel').on('click', '#btnCancelReturnEndorse', function (e)
{
    var getching = $(this).attr('name').split(':');
    var id = getching[0];
    var accountName = getching[1];

    $('#accountID').val(id);
    $('#accountName').val(accountName);
});


// $('#tableholdcancel').on('click', '#btnView', function (e)
// {
//     var tr = $(this).closest('tr');
//     var id = tr.children('td:eq(0)').text();
//     dateEndorsed = tr.children('td:eq(1)').text();
//     timeEndorsed = tr.children('td:eq(2)').text();
//     var accountName = tr.children('td:eq(4)').text();
//     var coborName = tr.children('td:eq(5)').text();
//     var typeOfRequest = tr.children('td:eq(7)').text();
//     var province = tr.children('td:eq(8)').text();
//
//     $(".id").html('ID: '+ id);
//     $(".dateTime").html('Date Time Endorsed: '+ dateEndorsed + ' ' + timeEndorsed);
//     $(".accountName").html('Account Name: '+ accountName);
//     $(".coborName").html('Co-Borrower Name: '+ coborName);
//     $(".typeOfRequest").html('Type of Request: '+ typeOfRequest);
//     $(".province").html('Location: '+ province);
//
//     $('#accountID').val(id);
//     $('#accountName').val(accountName);
//
//     // console.log(id);
// });

$('#btnDispatch').click(function (event)
{

    var accountID = $('#accountID').val();
    var accountName = $('#accountName').val();
    var ciID = $('#ciID').val();
    var ciName = $('#ciID').children('option:selected').text();
    var prioritize = $('#txtPrioritize').val();
    var verifythrough = $('#txtVerifyThrough').val();
    var date = $('#DateDue').val();
    var time = $('#TimeDue').val();

    $.post('ci-dispatch',
        {
            'accountID': accountID,
            'accountName': accountName,
            'ciID': ciID,
            'ciName': ciName,
            'prioritize': prioritize,
            'verifythrough': verifythrough,
            'dateTime': date + ' ' + time,
            '_token':$('input[name=_token]').val()
        },

        function (data)
        {
            $('#accountID').val('');
            // table.ajax.reload(null, false);
            tablee.ajax.reload(null, false);
            // tableee.ajax.reload(null, false);
        });
});

$('#btnHold').click(function ()
{
    var accountID = $('#accountID').val();
    var accountName = $('#accountName').val();

    $.ajax
    ({
        type: 'post',
        url: 'srao-hold-account',
        data:
            {
                'accountID': accountID,
                'accountName': accountName
            },
        success: function (data)
        {
            console.log(data.errorDispatch);

            if(data.errorDispatch===600)
            {
                table.ajax.reload(null, false);
                // tablee.ajax.reload(null, false);
                //  tableee.ajax.reload(null, false);
                $('#modal-hold').modal('hide');
                alert('Endorsement is already on process, please contact your system administrator')
            }
            else
            {
                $('#modal-hold').modal('hide');
                var timerSuccess = setInterval(function()
                {
                    $('#modal-success-change-status').modal('show');
                    table.ajax.reload(null, false);
                    //  tablee.ajax.reload(null, false);
                    //  tableee.ajax.reload(null, false);
                    clearInterval(timerSuccess);

                    var timer2 = setInterval(function () {
                        $('#modal-success-change-status').modal('hide');
                        clearInterval(timer2);
                    },2000);
                }, 1000);
            }
        }
    });
});

$('#btnCancel').click(function ()
{
    var promptRemarks = prompt('Enter Cancellation Remarks:', '');
    var accountID = $('#accountID').val();
    var accountName = $('#accountName').val();

    if(promptRemarks.length > 0)
    {
        $.ajax
        ({
            type: 'post',
            url: 'srao-cancel-account',
            data:
                {
                    'accountID': accountID,
                    'accountName': accountName,
                    'remarks' : promptRemarks
                },
            success: function (data)
            {
                if(data.errorDispatch===600)
                {
                    table.ajax.reload(null, false);
                    //tablee.ajax.reload(null, false);
                    // tableee.ajax.reload(null, false);
                    $('#modal-cancel').modal('hide');
                    alert('Endorsement is already on process, please contact your system administrator')
                }
                else
                {
                    $('#modal-cancel').modal('hide');
                    var timerSuccess = setInterval(function()
                    {
                        $('#modal-success-change-status').modal('show');
                        table.ajax.reload(null, false);
                        // tablee.ajax.reload(null, false);
                        //tableee.ajax.reload(null, false);
                        clearInterval(timerSuccess);

                        var timer2 = setInterval(function () {
                            $('#modal-success-change-status').modal('hide');
                            clearInterval(timer2);
                        },2000);
                    }, 1000);
                }
            },
            error: function (data) {
                console.log('error cancel');
            }
        });
    }
    else if(promptRemarks.length == 0)
    {
        alert('Cancellation failed. Indicate the reason of cancellation.');
    }

});

$('#btnUnhold').click(function ()
{
    var accountID = $('#accountID').val();
    var accountName = $('#accountName').val();

    $.ajax
    ({
        type: 'post',
        url: 'srao-uncancelhold-account',
        data:
            {
                'accountID': accountID,
                'accountName': accountName
            },
        success: function (data)
        {
            table.ajax.reload(null, false);
            // tablee.ajax.reload(null, false);
            // tableee.ajax.reload(null, false);
            $('#modal-unhold').modal('hide');
            var timerSuccess = setInterval(function()
            {
                $('#modal-success-change-status').modal('show');
                table.ajax.reload(null, false);
                clearInterval(timerSuccess);

                var timer2 = setInterval(function () {
                    $('#modal-success-change-status').modal('hide');
                    clearInterval(timer2);
                },2000);
            }, 1000);
        }
    });
});

$('#btnUncancel').click(function ()
{
    var accountID = $('#accountID').val();
    var accountName = $('#accountName').val();

    $.ajax
    ({
        type: 'post',
        url: 'srao-uncancelhold-account',
        data:
            {
                'accountID': accountID,
                'accountName': accountName
            },
        success: function (data)
        {
            table.ajax.reload(null, false);
            // tablee.ajax.reload(null, false);
            // tableee.ajax.reload(null, false);
            $('#modal-uncancel').modal('hide');
            var timerSuccess = setInterval(function()
            {
                $('#modal-success-change-status').modal('show');
                table.ajax.reload(null, false);
                //  tablee.ajax.reload(null, false);
                //  tableee.ajax.reload(null, false);
                clearInterval(timerSuccess);

                var timer2 = setInterval(function () {
                    $('#modal-success-change-status').modal('hide');
                    clearInterval(timer2);
                },2000);
            }, 1000);
        }
    });
});

$('#aolist-table').on('click', '#btnTransfer', function (e)
{
    aoID = $(this).attr('name');
    acctID = $(this).attr("value");
    parseInt(aoID);
    $('#aoID').val(aoID);
    $('#acctID').val(acctID);
    $('#transfer-modal').modal('show');

    // console.log('transclick1');
    $.ajax({
        url: '/srao-get-ao-counts',
        type: 'GET',
        success: function (data)
        {

            // console.log('ao: '+data);

            var getaos = '';

            for(var ctr=0; ctr<parseInt(data[2]); ctr++){
                getaos += '<option value=" '+data[1][ctr]+'">'+data[0][ctr]+'</option>';

            }
            $('#aoIDTransfer').html(getaos);
        },
        error: function () {
            console.log('error');
        }
    });


});

$('#btnTransferr').click(function (e)
{
    aoIDToTransfer = parseInt($('#aoIDTransfer').val());
    var aim = 'transfer';


    $('#btnTransferr').attr('disabled', 'disabled');
    $.ajax
    ({
        method: 'post',
        url: 'srao-ao-transfer',
        data:
            {
                'aoID': aoID,
                'acctID': acctID,
                'aoIDToTransfer': aoIDToTransfer,
                'aim': aim
            },
        success: function (data) {
            if(data == 'success')
            {
                $('#transfer-modal').modal('hide');
                var timerSuccess = setInterval(function()
                {
                    $('#modal-successTransferr').modal('show');
                    clearInterval(timerSuccess);
                    $('#btnTransferr').removeAttr('disabled');
                    tableee.ajax.reload(null,false);
                    var timer2 = setInterval(function () {
                        $('#modal-successTransferr').modal('hide');
                        clearInterval(timer2);
                    },2000);

                }, 1000);
            }
            else
            {
                alert('Action denied due to account is already finished');
                $('#btnTransferr').removeAttr('disabled');
            }

        },
        error: function () {
            alert('Failed to send Email notification or Something went wrong.');
            $('#btnTransferr').removeAttr('disabled');

        }
    });

});



$('#btnReturn').click(function ()
{
    var promptRemarks = prompt('Enter Return Remarks:', '');
    var accountID = $('#accountID').val();
    var accountName = $('#accountName').val();

    if(promptRemarks.length > 0)
    {
        $.ajax
        ({
            type: 'post',
            url: 'srao-return-account',
            data:
                {
                    'accountID': accountID,
                    'accountName': accountName,
                    'remarks' : promptRemarks
                },
            success: function (data)
            {
                if(data.errorDispatch===600)
                {
                    table.ajax.reload(null, false);
                    //tablee.ajax.reload(null, false);
                    // tableee.ajax.reload(null, false);
                    $('#srao-modal-return').modal('hide');
                    alert('Endorsement is already on process, please contact your system administrator')
                }
                else
                {
                    $('#srao-modal-return').modal('hide');
                    var timerSuccess = setInterval(function()
                    {
                        $('#modal-success-change-status').modal('show');
                        table.ajax.reload(null, false);
                        // tablee.ajax.reload(null, false);
                        //tableee.ajax.reload(null, false);
                        clearInterval(timerSuccess);

                        var timer2 = setInterval(function () {
                            $('#modal-success-change-status').modal('hide');
                            clearInterval(timer2);
                        },2000);
                    }, 1000);
                }
            },
            error: function (data) {
                console.log('error cancel');
            }
        });
    }
    else if(promptRemarks.length == 0)
    {
        alert('Cancellation failed. Indicate the reason of cancellation.');
    }




});

$('#btnReturnCancel').click(function ()
{
    var accountID = $('#accountID').val();
    var accountName = $('#accountName').val();

    $.ajax
    ({
        type: 'post',
        url: 'srao-return-cancel-account',
        data:
            {
                'accountID': accountID,
                'accountName': accountName
            },
        success: function (data)
        {
            table.ajax.reload(null, false);
            // tablee.ajax.reload(null, false);
            // tableee.ajax.reload(null, false);
            $('#srao-modal-cancelreturn').modal('hide');
            var timerSuccess = setInterval(function()
            {
                $('#modal-success-change-status').modal('show');
                table.ajax.reload(null, false);
                //  tablee.ajax.reload(null, false);
                //  tableee.ajax.reload(null, false);
                clearInterval(timerSuccess);

                var timer2 = setInterval(function () {
                    $('#modal-success-change-status').modal('hide');
                    clearInterval(timer2);
                },2000);
            }, 1000);
        }
    });
});


//other info
// btnFullViewInfo
// $('#endorsement-tablee').on('click', '#btnFullViewInfo', function (e)
// {
//     acctID = '';
//     acctID = $(this).attr("href");
//     $('#spanhere').html('');
//     $('#history').html('');
//     $('#otherInfoSpan').html('');
//     $('#otherEmployerSpan').html('');
//     $('#otherBusinessSpan').html('');
//
//     $.ajax({
//         url: '/ao-view-info',
//         type: 'GET',
//         data:
//             {
//                 'acctID': acctID
//             },
//         dataType: 'json',
//         success: function (data)
//         {
//             console.log(data);
//
//             if(data.length === 0)
//             {
//                 console.log('data empty');
//                 $('#spanhere').append('No Data Found' +'<br>') ;
//             }
//             else
//             {
//                 $('#spanhere').append
//                 (
//                     '               <table id="asdfsf" border="3" width="100%" margin="auto">' +
//                     '                <tr>' +
//                     '                  <td style="padding: 3px;"><span class="badge bg-red">DATE ENDORSED</span></td>' +
//                     '                  <td style="padding: 3px;">'+data[0][0].date_endorsed +'</td>' +
//                     '                  <td style="padding: 3px;"><span class="badge bg-red">TIME ENDORSED</span></td>\n' +
//                     '                  <td style="padding: 3px;">'+data[0][0].time_endorsed +'</td>\n' +
//                     '                </tr>\n' +
//
//
//                     '                <tr>\n' +
//                     '                  <td style="padding: 3px;"><span class="badge bg-red">DATE DUE</span></td>\n' +
//                     '                  <td style="padding: 3px;">'+data[0][0].date_due +'</td>\n' +
//                     '                  <td style="padding: 3px;"><span class="badge bg-red">TIME DUE</span></td>\n' +
//                     '                  <td style="padding: 3px;">'+data[0][0].time_due +'</td>\n' +
//                     '                </tr>\n' +
//
//                     '                <tr>\n' +
//                     '                  <td style="padding: 3px;"><span class="badge bg-red">ACCOUNT NAME</span></td>\n' +
//                     '                  <td style="padding: 3px;">'+data[0][0].account_name+'</td>\n' +
//                     '                  <td style="padding: 3px;"><span class="badge bg-red">PRIORITY</span></td>\n' +
//                     '                  <td style="padding: 3px;">'+data[0][0].prioritize+'</td>\n' +
//                     '                </tr>\n' +
//
//                     '                <tr>\n' +
//                     '                  <td style="padding: 3px;"><span class="badge bg-red">ADDRESS</span></td>\n' +
//                     '                  <td style="padding: 3px;">'+data[0][0].address +'</td>\n' +
//                     '                  <td style="padding: 3px;"><span class="badge bg-red">PROVINCE</span></td>\n' +
//                     '                  <td style="padding: 3px;">'+data[0][0].provinces +'</td>\n' +
//                     '                </tr>\n' +
//
//                     '                <tr>\n' +
//                     '                  <td style="padding: 3px;"><span class="badge bg-red">CLIENT NAME</span></td>\n' +
//                     '                  <td style="padding: 3px;">'+data[0][0].client_name +'</td>\n' +
//                     '                  <td style="padding: 3px;"><span class="badge bg-red">REQUESTOR</span></td>\n' +
//                     '                  <td style="padding: 3px;">'+data[0][0].requestor_name +'</td>\n' +
//                     '                </tr>\n' +
//
//                     '                <tr>\n' +
//                     '                  <td style="padding: 3px;"><span class="badge bg-red">TYPE OF LOAN</span></td>\n' +
//                     '                  <td style="padding: 3px;">'+data[0][0].type_of_loan+'</td>\n' +
//                     '                  <td style="padding: 3px;"><span class="badge bg-red">TYPE OF REQUEST</span></td>\n' +
//                     '                  <td style="padding: 3px;">'+data[0][0].type_of_request+'</td>\n' +
//                     '                </tr>\n' +
//
//                     '                <tr>\n' +
//                     '                  <td style="padding: 3px;"><span class="badge bg-red">TYPE OF SENDING REPORT</span></td>\n' +
//                     '                  <td style="padding: 3px;">'+data[0][0].type_of_sending_report +'</td>\n' +
//                     '                  <td style="padding: 3px;"><span class="badge bg-red">DATE FORWARDED TO CLIENT</span></td>\n' +
//                     '                  <td style="padding: 3px;">'+data[0][0].date_forwarded_to_client+'</td>\n' +
//                     '                </tr>\n' +
//
//                     '                <tr>\n' +
//                     '                  <td style="padding: 3px;"><span class="badge bg-red">TIME FORWARDED TO CLIENT</span></td>\n' +
//                     '                  <td style="padding: 3px;">'+data[0][0].time_forwarded_to_client+'</td>\n' +
//                     '                  <td style="padding: 3px;"><span class="badge bg-red">STATUS INTERNAL</span></td>\n' +
//                     '                  <td style="padding: 3px;">'+data[0][0].endorsement_status_internal+'</td>\n' +
//                     '                </tr>\n' +
//
//                     '                <tr>\n' +
//                     '                  <td style="padding: 3px;"><span class="badge bg-red">STATUS EXTERNAL</span></td>\n' +
//                     '                  <td style="padding: 3px;">'+data[0][0].endorsement_status_external +'</td>\n' +
//                     '                  <td style="padding: 3px;"><span class="badge bg-red">PICTURE STATUS</span></td>\n' +
//                     '                  <td style="padding: 3px;">'+data[0][0].picture_status+'</td>\n' +
//                     '                </tr>\n' +
//
//                     '                <tr>\n' +
//                     '                  <td style="padding: 3px;"><span class="badge bg-red">VERIFY THROUGH</span></td>\n' +
//                     '                  <td style="padding: 3px;">'+data[0][0].verify_through+'</td>\n' +
//                     '                  <td style="padding: 3px;"><span class="badge bg-red">DISPATCHER</span></td>\n' +
//                     '                  <td style="padding: 3px;">'+data[0][0].handled_by_dispatcher+'</td>\n' +
//                     '                </tr>\n' +
//
//                     '                <tr>\n' +
//                     '                  <td style="padding: 3px;"><span class="badge bg-red">SENIOR ACCOUNT OFFICER</span></td>\n' +
//                     '                  <td style="padding: 3px;">'+data[0][0].assigned_by_srao+'</td>\n' +
//                     '                  <td style="padding: 3px;"><span class="badge bg-red">ACCOUNT OFFICER</span></td>\n' +
//                     '                  <td style="padding: 3px;">'+data[0][0].handled_by_account_officer+'</td>\n' +
//                     '                </tr>\n' +
//
//                     '                <tr>\n' +
//                     '                  <td style="padding: 3px;"><span class="badge bg-red">CREDIT INVESTIGATOR</span></td>\n' +
//                     '                  <td style="padding: 3px;">'+data[0][0].handled_by_credit_investigator+'</td>\n' +
//                     '                  <td style="padding: 3px;"><span class="badge bg-red">REMARKS</span></td>\n' +
//                     '                  <td style="padding: 3px;">'+data[0][0].remarks+'</td>\n' +
//                     '                </tr>\n' +
//
//                     '                <tr>\n' +
//                     '                  <td style="padding: 3px;"><span class="badge bg-red">DATE VISIT</span></td>\n' +
//                     '                  <td style="padding: 3px;">'+data[0][0].date_ci_visit+'</td>\n' +
//                     '                  <td style="padding: 3px;"><span class="badge bg-red">TIME VISIT</span></td>\n' +
//                     '                  <td style="padding: 3px;">'+data[0][0].time_ci_visit+'</td>\n' +
//                     '                </tr>\n' +
//
//                     '              </table>'
//                 );
//
//
//                 $('#history').html
//                 (
//                     '<tr style="background-color: brown; color: white">' +
//                     '<th style=\'text-align: center;\'>NAME</th>' +
//                     '<th style=\'text-align: center;\'>POSITION</th>' +
//                     '<th style=\'text-align: center;\'>ACTIVITIES</th>' +
//                     '<th style=\'text-align: center;\'>DATE OCCURED</th>' +
//                     '<th style=\'text-align: center;\'>TIME OCCURED</th>' +
//                     '</tr>'
//                 );
//
//                 $('#otherInfoSpan').html
//                 (
//                     '<tr style="background-color: brown; color: white">' +
//                     '   <th style=\'text-align: center;\'>COBORROWER NAME</th>' +
//                     '   <th style=\'text-align: center;\'>ADDRESS</th>' +
//                     '   <th style=\'text-align: center;\'>CITY/MUNICIPALITY</th>' +
//                     '   <th style=\'text-align: center;\'>PROVINCE</th>' +
//                     '</tr>'
//                 );
//                 $('#otherEmployerSpan').html
//                 (
//                     '<tr style="background-color: brown; color: white">' +
//                     '   <th style=\'text-align: center;\'>EMPLOYER NAME</th>' +
//                     '   <th style=\'text-align: center;\'>ADDRESS</th>' +
//                     '   <th style=\'text-align: center;\'>CITY/MUNICIPALITY</th>' +
//                     '   <th style=\'text-align: center;\'>PROVINCE</th>' +
//                     '</tr>'
//                 );
//                 $('#otherBusinessSpan').html
//                 (
//                     '<tr style="background-color: brown; color: white">' +
//                     '   <th style=\'text-align: center;\'>BUSINESS NAME</th>' +
//                     '   <th style=\'text-align: center;\'>ADDRESS</th>' +
//                     '   <th style=\'text-align: center;\'>CITY/MUNICIPALITY</th>' +
//                     '   <th style=\'text-align: center;\'>PROVINCE</th>' +
//                     '</tr>'
//                 );
//
//                 for(ctrr = 0;ctrr <= (data[1].length)-1;ctrr++)
//                 {
//                     $('#history').append
//                     (
//                         '<tr>' +
//                         '<td style="padding: 3px;">' +data[1][ctrr].name + '</td>' +
//                         '<td style="padding: 3px;">' +data[1][ctrr].position + '</td>' +
//                         '<td style="padding: 3px;">' +data[1][ctrr].activities + '</td>' +
//                         '<td style="padding: 3px;">' +data[1][ctrr].date_occured + '</td>' +
//                         '<td style="padding: 3px;">' +data[1][ctrr].time_occured + '</td>' +
//                         '</tr>'
//                     );
//                 }
//
//
//                 for (ctrr = 0; ctrr <= (data[2].length) - 1; ctrr++) {
//                     $('#otherInfoSpan').append
//                     (
//                         '<tr>' +
//                         '   <td style="padding: 3px;">' + data[2][ctrr].coborrower_name + '</td>' +
//                         '   <td style="padding: 3px;">' + data[2][ctrr].coborrower_address + '</td>' +
//                         '   <td style="padding: 3px;">' + data[2][ctrr].coborrower_municipality + '</td>' +
//                         '   <td style="padding: 3px;">' + data[2][ctrr].coborrower_province + '</td>' +
//                         '</tr>'
//                     );
//                 }
//
//
//
//                 for(ctrr = 0;ctrr<=(data[3].length)-1;ctrr++)
//                 {
//                     $('#otherEmployerSpan').append
//                     (
//                         '<tr>' +
//                         '   <td style="padding: 3px;">' +data[3][ctrr].employer_name+ '</td>' +
//                         '   <td style="padding: 3px;">' +data[0][ctrr].address+ '</td>' +
//                         '   <td style="padding: 3px; text-transform: uppercase">' +data[0][ctrr].muni_name+ '</td>' +
//                         '   <td style="padding: 3px;">' +data[0][ctrr].provinces+ '</td>' +
//                         '</tr>'
//                     );
//                 }
//
//
//
//                 for (ctrr = 0; ctrr <= (data[4].length) - 1; ctrr++) {
//                     $('#otherBusinessSpan').append
//                     (
//                         '<tr>' +
//                         '   <td style="padding: 3px;">' + data[4][ctrr].business_name + '</td>' +
//                         '   <td style="padding: 3px;">' + data[0][ctrr].address + '</td>' +
//                         '   <td style="padding: 3px; text-transform: uppercase">' +data[0][ctrr].muni_name+ '</td>' +
//                         '   <td style="padding: 3px;">' + data[0][ctrr].provinces + '</td>' +
//                         '</tr>'
//                     );
//                 }
//
//                 if(data[2].length===0)
//                 {
//                     $('#otherInfoSpan').hide();
//                 }
//                 else
//                 {
//                     $('#otherInfoSpan').show();
//                 }
//
//                 if(data[3].length===0)
//                 {
//                     $('#otherEmployerSpan').hide();
//                 }
//                 else
//                 {
//                     $('#otherEmployerSpan').show();
//                 }
//
//                 if(data[4].length===0)
//                 {
//                     $('#otherBusinessSpan').hide();
//                 }
//                 else
//                 {
//                     $('#otherBusinessSpan').show();
//                 }
//             }
//         }
//     })
// });

$('#aolist-table').on('click', '#btnOtherInfo', function (e)
{
    var acctID = $(this).attr("href");
    $('#otherInfoSpan').html('');
    $('#otherEmployerSpan').html('');
    $('#otherBusinessSpan').html('');

    $.ajax({
        url: '/srao-get-other-info',
        type: 'GET',
        data:
            {
                'acctID': acctID
            },
        success: function (data)
        {
            // console.log(data);

            if(data.length === 0)
            {
                console.log('data empty');
            }
            else
            {

                $('#otherInfoSpan').html
                (
                    '<tr style="background-color: brown; color: white">' +
                    '   <th style=\'text-align: center;\'>COBORROWER NAME</th>' +
                    '   <th style=\'text-align: center;\'>ADDRESS</th>' +
                    '   <th style=\'text-align: center;\'>CITY/MUNICIPALITY</th>' +
                    '   <th style=\'text-align: center;\'>PROVINCE</th>' +
                    '</tr>'
                );

                for (ctrr = 0; ctrr <= (data[0].length) - 1; ctrr++)
                {
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

                for(ctrr = 0;ctrr<=(data[1].length)-1;ctrr++)
                {
                    $('#otherEmployerSpan').append
                    (
                        '<tr>' +
                        '   <td style="padding: 3px;">' +data[1][ctrr].employer_name+ '</td>' +
                        '   <td style="padding: 3px;">' +data[1][ctrr].employer_address+ '</td>' +
                        '   <td style="padding: 3px;">' +data[1][ctrr].employer_municipality+ '</td>' +
                        '   <td style="padding: 3px;">' +data[1][ctrr].employer_province+ '</td>' +
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

                for (ctrr = 0; ctrr <= (data[2].length) - 1; ctrr++)
                {
                    $('#otherBusinessSpan').append
                    (
                        '<tr>' +
                        '   <td style="padding: 3px;">' + data[2][ctrr].business_name + '</td>' +
                        '   <td style="padding: 3px;">' + data[2][ctrr].business_address + '</td>' +
                        '   <td style="padding: 3px;">' + data[2][ctrr].business_municipality + '</td>' +
                        '   <td style="padding: 3px;">' + data[2][ctrr].business_province + '</td>' +
                        '</tr>'
                    );
                }

                if(data[0].length===0)
                {
                    $('#otherInfoSpan').hide();
                }
                else
                {
                    $('#otherInfoSpan').show();
                }


                if(data[1].length===0)
                {
                    $('#otherEmployerSpan').hide();
                }
                else
                {
                    $('#otherEmployerSpan').show();
                }

                if(data[2].length===0)
                {
                    $('#otherBusinessSpan').hide();
                }
                else
                {
                    $('#otherBusinessSpan').show();
                }
            }
        }
    })
});

$('#tableholdcancel').on('click', '#btnOtherInfo', function (e)
{
    var acctID = $(this).attr("href");
    $('#otherInfoSpan').html('');
    $('#otherEmployerSpan').html('');
    $('#otherBusinessSpan').html('');

    $.ajax({
        url: '/srao-get-other-info',
        type: 'GET',
        data:
            {
                'acctID': acctID
            },
        success: function (data)
        {
            // console.log(data);

            if(data.length === 0)
            {
                console.log('data empty');
            }
            else
            {

                $('#otherInfoSpan').html
                (
                    '<tr style="background-color: brown; color: white">' +
                    '   <th style=\'text-align: center;\'>COBORROWER NAME</th>' +
                    '   <th style=\'text-align: center;\'>ADDRESS</th>' +
                    '   <th style=\'text-align: center;\'>CITY/MUNICIPALITY</th>' +
                    '   <th style=\'text-align: center;\'>PROVINCE</th>' +
                    '</tr>'
                );

                for (ctrr = 0; ctrr <= (data[0].length) - 1; ctrr++)
                {
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

                for(ctrr = 0;ctrr<=(data[1].length)-1;ctrr++)
                {
                    $('#otherEmployerSpan').append
                    (
                        '<tr>' +
                        '   <td style="padding: 3px;">' +data[1][ctrr].employer_name+ '</td>' +
                        '   <td style="padding: 3px;">' +data[1][ctrr].employer_address+ '</td>' +
                        '   <td style="padding: 3px;">' +data[1][ctrr].employer_municipality+ '</td>' +
                        '   <td style="padding: 3px;">' +data[1][ctrr].employer_province+ '</td>' +
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

                for (ctrr = 0; ctrr <= (data[2].length) - 1; ctrr++)
                {
                    $('#otherBusinessSpan').append
                    (
                        '<tr>' +
                        '   <td style="padding: 3px;">' + data[2][ctrr].business_name + '</td>' +
                        '   <td style="padding: 3px;">' + data[2][ctrr].business_address + '</td>' +
                        '   <td style="padding: 3px;">' + data[2][ctrr].business_municipality + '</td>' +
                        '   <td style="padding: 3px;">' + data[2][ctrr].business_province + '</td>' +
                        '</tr>'
                    );
                }

                if(data[0].length===0)
                {
                    $('#otherInfoSpan').hide();
                }
                else
                {
                    $('#otherInfoSpan').show();
                }


                if(data[1].length===0)
                {
                    $('#otherEmployerSpan').hide();
                }
                else
                {
                    $('#otherEmployerSpan').show();
                }

                if(data[2].length===0)
                {
                    $('#otherBusinessSpan').hide();
                }
                else
                {
                    $('#otherBusinessSpan').show();
                }
            }
        }
    });
});

$('#aolist-table-revision').on('click','#btnDownloadRev',function ()
{
    var downRevID = $(this).attr('value');

    // $.ajax
    // ({
    //     url: '/srao-download-revision',
    //     type: 'GET',
    //     data:
    //         {
    //             'downRevID': btoa(downRevID),
    //             'todo' : 'download_ao'
    //         },
    //     success: function (data)
    //     {
    //         if(data == 'exists')
    //         {
    //             alert('No Available Report for this Account!')
    //         }
    //         else
    //         {
    //             // window.location = data;
    //             // tableRevision.ajax.reload(null, false);
    //         }
    //     },
    //     error: function ()
    //     {
    //         alert('error');
    //     }
    // });
    Download_revise(downRevID,'download_ao');


});

function Download_revise(downRevID,todo) {

    var downRevID_dec = btoa(downRevID);


    var q = '<form action="/srao-download-revision" target="_blank" method="get">'+
        '<div class="input-group">'+
        '<input type="text" hidden value="'+downRevID_dec+'" name="downRevID">'+
        '<input type="text" hidden value="'+todo+'" name="todo">'+
        '<button type="submit" id="button_form_download_revision">'+
        '</button>'+
        '</span>'+
        '</div>'+
        '</form>';

    $('#down_form_revision').html(q);
    $('#button_form_download_revision').click();
    // window.location = '/ao-panel';
}

$('#aolist-table-revision').on('click','#btnUploadRev',function () {
    $('#progressbarRevision').removeAttr('class');
    $('#ulPercentageRevision').html('');
    revision_id = $(this).val();
    $('#btn_download_revised').hide();

    // check if download is available
    $.ajax
    ({
        url: '/srao_check_revision_availability',
        type: 'GET',
        data:
            {
                'id': revision_id
            },
        success: function (data)
        {
            if(data[0] == 'ok')
            {
                $('#btn_download_revised').html('Download : '+data[1]+'.zip');
                $('#btn_download_revised').show();
            }
            else
            {
                $('#btn_download_revised').hide();
            }
        },
        error: function ()
        {
            alert('error');
        }
    });


});


$('#btn_download_revised').click(function () {

    // $.ajax
    // ({
    //     url: '/srao-download-revision',
    //     type: 'GET',
    //     data:
    //         {
    //             'downRevID': btoa(revision_id),
    //             'todo' : 'redownload'
    //         },
    //     success: function (data)
    //     {
    //         if(data == 'exists')
    //         {
    //             alert('No Available Report for this Account!');
    //         }
    //         else
    //         {
    //
    //         }
    //     },
    //     error: function ()
    //     {
    //         alert('error');
    //     }
    // });

    Download_revise(revision_id,'redownload');

});

$('#btn_send_revision').click(function (e) {

    upload_revision_func(e);

});

function upload_revision_func(e) {

    e.preventDefault();
    $('#fileRevision').attr('disabled',true);
    var file = new $("#fileRevision").prop('files')[0];

    var form_data = new FormData();
    form_data.append('acctID', revision_id);
    form_data.append('file', file);


    if( $("#fileRevision").val().length >= 1)
    {

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
                        $('#ulPercentageRevision').html('');

                        // $('#ulPercentage').append(percentComplete*100);
                        $('#ulPercentageRevision').append(Math.floor(percentComplete*100));
                        $('#progressbarRevision').show();
                        $('#progressbarRevision').progressbar
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
            method: 'post',
            url: 'uploadReportFile_revision',
            processData: false,
            contentType: false,
            data: form_data,
            success: function (data)
            {
                console.log(data);
                if(data==='success')
                {

                    $('#progressbarRevision').progressbar('option', 'value', 0);
                    $('#modal-upload-revision').modal('hide');
                    $("#fileRevision").val('');
                    $('#fileRevision').attr('disabled',false);
                    tableRevision.ajax.reload(null, false);
                    alert('Report Successfully sent to Client');

                }
                else if(data==='error')
                {
                    alert('INVALID FILE TYPE.');

                }
                else
                {
                    $('#progressbarRevision').progressbar('option', 'value', 0);
                    $('#fileRevision').attr('disabled',false);
                    tableRevision.ajax.reload(null, false);

                }
            }
        });
    }
    else
    {
        alert('No attachment detected.')
    }
}

$('#sao-audit-table-reports').on('click','.btnAuditDownload_sao', function ()
{
    var acctID = $(this).attr('value');
    var type = $(this).attr('name');

    // console.log(type);

    // $.ajax
    // ({
    //     method: 'get',
    //     url: 'audit-download-report',
    //     data:
    //         {
    //             'acctID': acctID,
    //             'type': type
    //         },
    //     success: function (data)
    //     {
    //         if(data=='errorDownload')
    //         {
    //             alert('Report Not Available!');
    //         }
    //         else
    //         {
    //             window.location = data;
    //             tableManage.ajax.reload(null, false);
    //             // tableAoFinishReport.ajax.reload(null, false);
    //         }
    //     }
    // });

    download_report(acctID,type);
});
function download_report(id,typ)
{
    var q = '<form action="/sao-download-report-audit" target="_blank" method="get">'+
        '<div class="input-group">'+
        '<input type="text" hidden value="'+id+'" name="acctID">'+
        '<input type="text" hidden value="'+typ+'" name="type">'+
        '<button type="submit" id="button_form_download_report">'+
        '</button>'+
        '</span>'+
        '</div>'+
        '</form>';

    $('#span_download_report').html(q);
    $('#button_form_download_report').click();
    // window.location = '/ao-panel';
}

ciList();
function ciList()
{
    $.ajax
    ({
        type : 'get',
        url : 'sao-get-ci-list',
        success : function(data)
        {
            console.log(data)
            var h;
            var optionCiData ='';
            var optionCiData2 = '';
            var optionAOData = '';

            for(h = 0; h < data[0].length; h++)
            {
                optionCiData += '<option value = "'+data[0][h].id+'" name = "'+data[0][h].name+'">'+data[0][h].name+'</option>';
                optionCiData2 += '<option value = "'+data[0][h].name+'" >'+data[0][h].name+'</option>';
            }

            for(var g = 0; g < data[1].length; g++)
            {
                optionAOData += '<option value = "'+data[1][g].name+'" >'+data[1][g].name+'</option>'
            }
            $('#ci_selected_fund').html('<option value = "--">--</option>' + optionCiData);
            $('#ciProductivityNames').html('<option value = "-">-</option>' + optionCiData2);
            $('#aoProductivityNames').html('<option value = "-">-</option>' + optionAOData)

        }
    })
}
var ciNameUnliqHold ;

$('#ci_selected_fund').change(function()
{
    ciIdUnliqHold = $(this).find(':selected').val();
    ciNameUnliqHold = $(this).find(':selected').attr('name');

    if(ciIdUnliqHold == '--')
    {
        $('#ciNameUnliqHold').html('');
        $('#unliqFundCi').html('');
        $('#holdFundCi').html('');
        $('#checkShellCI').html('');

        $('#showAmountAssignCi').fadeOut();
        table_fund_endorsed_no_fund.ajax.reload(null, false);
    }
    else
    {
        if($('#fundSourceHoldUnliq').val()== 'Emergency Fund')
        {
            $('#showtableFundHold').fadeOut();
            $('#showtableFundHold').fadeOut();

            $('#amtToAssignCi').val(0);
            $('#showAmountAssignCi').fadeIn();

            unliqHoldTotal();
        }
        else
        {
            $('#showtableFundHold').fadeOut();

            $('#amtToAssignCi').val(0);
            $('#showAmountAssignCi').fadeIn();

            unliqHoldTotal();

        }

    }
});

function showPendingAccountsFund()
{
    $('#table-sao-ci-hold-unliq thead th').each(function()
    {
        titleee_no_fund_endorse[i_no_fund] = $(this).text();
        i_no_fund++;
        title = $(this).text();
        $(this).html(title);
    });

    table_fund_endorsed_no_fund = $('#table-sao-ci-hold-unliq').DataTable
    ({

        "processing": true,
        "serverSide": true,
        "responsive": true,
        // "ajax": 'table_for_online_upload',

        "ajax":
            {
                type: 'get',
                url: "/sao-table-for-no-fund-accounts",
                data: function (e)
                {
                    e.id = ciIdUnliqHold
                }
            },
        "columns":
            [
                {
                    data: function select_button(data)
                    {
                        return '<button class="btn btn-normal btn_select_acc_to_fund" value="'+data.subjnames +'/' +data.address +'/'+ data.city_muni + '/'+ data.provinces+'/' +data.tor+'" name="'+data.id+'">Select</button>';
                    },
                    name: 'endorsements.id'
                },
                {data: 'id', name: 'endorsements.id'},
                {data: 'account_name', name: 'endorsements.account_name'},
                {data: 'address', name: 'endorsements.address'},
                {data: 'type_of_subjects', name: 'endorsements.id', "orderable": false, "searchable": false, "autoWidth": false},
                // {
                //     data: function actions(data)
                //     {
                //         var todisp = '';
                //
                //         if (data.subjnames == 'NONE') {
                //             todisp = data.subjcoob;
                //         }
                //         else {
                //             todisp = data.subjcoob + '\n<b>(' + data.subjnames + ')</b>';
                //         }
                //
                //         return todisp;
                //     },
                //     "orderable": false,
                //     "searchable": false,
                //     "name": 'type_of_subjects.type_of_subject_name',
                //     "autoWidth": false
                // },
                {data: 'tor', name: 'endorsements.type_of_request'},
                {data: 'city_muni', name: 'municipalities.muni_name'},
                {data: 'provinces', name: 'endorsements.provinces'},
                {data: 'date_endorsed', name: 'endorsements.date_endorsed'}
            ],
        "order": [[0, 'desc']],
        "pageLength": 10,
        "lengthMenu": [[2, 10, 25, 50, -1], ['2 rows', '10 rows', '25 rows', '50 rows', 'Show all']],
        "bSortClasses": false,
        "drawCallback": function () {

            $('.remove_account_for_fund').each(function () {

                var id_check_selected = $(this).attr('value');

                // console.log(id_check_selected);

                $('.btn_select_acc_to_fund').each(function () {

                    if($(this).attr('name') == id_check_selected)
                    {
                        $(this).html('Un-Select');
                    }
                });
            });

            naanona = true;
        },

        // "aoColumnDefs": [{ "bVisible": false, "aTargets": [6] }],
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
        }
    });

    // $('#table-sao-ci-hold-unliq tbody').on('click', 'tr', function ()
    // {
    //     $(this).toggleClass('selected');
    // });

    $('#table-sao-ci-hold-unliq_filter input').unbind();
    $('#table-sao-ci-hold-unliq_filter input').bind('keyup change', function (e)
    {
        if ($(this).is(':focus'))
        {
            if (e.keyCode == 13)
            {
                table_fund_endorsed_no_fund.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '')
                {
                    table_fund_endorsed_no_fund.search($(this).val()).draw();
                }
            }
        }
    });
}

$('#submitAmtforCiUnliqHold').click(function()
{
    // var checkids = $.map(table_fund_endorsed_no_fund.rows('.selected').data(),function (item) {
    //     return item.id
    // });

    var idsAssign = [];
    $('.remove_account_for_fund').each(function()
    {
        idsAssign.push($(this).attr('value'));
    });

    var amountToSend = $('#amtToAssignCi').val();
    var typeAssignCi = $('#fundSourceHoldUnliq').find(':selected').val();

    console.log(idsAssign);


    if(idsAssign.length <= 0)
    {
        alert('Please select account to be assigned!');
    }
    else
    {
        if(typeAssignCi == 'Unliquidated Fund')
        {
            if(unliqCiAmount == 0)
            {
                alert('There is no unliquidated fund!');
            }
            else
            {
                // var fund_chose = [];

                if(unliqCiAmount < amountToSend)
                {
                    alert('Amount requested exceeds selected CI unliquidated amount.')
                }
                else if(amountToSend == 0)
                {
                    alert('Please indicate the value.')
                }
                else
                {
                    console.log(amountToSend + ', ' + typeAssignCi);

                    sendAssignNewFund(amountToSend, idsAssign, typeAssignCi, []);
                }
            }

        }
        else if(typeAssignCi == 'On-Hold Fund')
        {
            if(holdCiAmount == 0)
            {
                alert('There is no on-hold fund!')
            }
            else
            {
                var fund_chose =  $.map(table_fund_hold.rows('.selected').data(),function (item) {
                    return item.id
                });

                if(fund_chose.length < 0)
                {
                    alert('Please select an on-hold request!');
                }
                else
                {
                    if(holdCiAmount < amountToSend)
                    {
                        alert('Amount requested exceeds selected CI on-hold amount.')
                    }
                    else if(amountToSend == 0)
                    {
                        alert('Please indicate the value.')
                    }
                    else
                    {
                        console.log(amountToSend + ', ' + typeAssignCi);

                        sendAssignNewFund(amountToSend, idsAssign, typeAssignCi, fund_chose);

                    }
                }
            }
        }

    }
});

function sendAssignNewFund(amt, ids, type, fund)
{
    $.ajax
    ({
        type : 'post',
        url : 'sao-submit-unliq-hold-amount',
        data :
            {
                ids : ids,
                'amount' : amt,
                'toa' : type,
                'id' : ciIdUnliqHold,
                fund : fund
            },
        success : function(data)
        {

            if(data == 'unliq')
            {
                table_fund_endorsed_no_fund.ajax.reload(null, false);

                alert('Successfully assigned the fund to account/s!')
            }
            else if(data == 'hold')
            {
                table_fund_hold.ajax.reload(null, false);
                table_fund_endorsed_no_fund.ajax.reload(null, false);

                alert('Successfully assigned the fund to account/s!')
            }
            unliqHoldTotal();
            $('#amtToAssignCi').val(0);
            $('#amtToAssignCi').attr('disabled', false);
            table_fund_logs_sao.ajax.reload(null, false);
            $('#sao_fund_selected_accnt').html('<tr>' +
                '                                                            <th>ID</th>' +
                '                                                            <th>ACCOUNT INFORMATION</th>' +
                '                                                            <th>ACTION</th>' +
                '                                                        </tr>')
        }
    });
}

$('#fundSourceHoldUnliq').change(function()
{
    if ($(this).find(':selected').val() == 'Unliquidated Fund')
    {
        $('#showtableFundHold').fadeOut();
        $('#amtToAssignCi').attr('disabled', false);
        $('#amtToAssignCi').val(0);
        $('#submitAmtforCiUnliqHold').show();
        $('#btnEmergencyFundCi').hide();
        $('#showSaoRemUnliq').hide();
    }
    else if ($(this).find(':selected').val() == 'On-Hold Fund')
    {
        $('#showtableFundHold').fadeIn();
        $('#submitAmtforCiUnliqHold').show();
        $('#btnEmergencyFundCi').hide();
        $('#showSaoRemUnliq').hide();

        if(checkifOpenUnliqFundReq == false)
        {
            tableFundOnHoldFunc();

            checkifOpenUnliqFundReq = true;
        }
        else if(checkifOpenUnliqFundReq == true)
        {
            table_fund_hold.ajax.reload(null, false);
        }
    }
    else if ($(this).find(':selected').val() == 'Emergency Fund')
    {
        $('#showtableFundHold').fadeOut();
        $('#amtToAssignCi').attr('disabled', false);
        $('#amtToAssignCi').val(0);
        $('#submitAmtforCiUnliqHold').hide();
        $('#btnEmergencyFundCi').show();
        $('#showSaoRemUnliq').show();
    }

});

function tableFundOnHoldFunc()
{
    $('#table_sao_unliq_fund_req thead th').each(function()
    {
        titleee_hold_fund[i_hold_fund] = $(this).text();
        i_hold_fund++;
        title = $(this).text();
        $(this).html(title);
    });

    table_fund_hold = $('#table_sao_unliq_fund_req').DataTable
    ({
        "processing": true,
        "serverSide": true,
        "responsive": true,
        // "ajax": 'table_for_online_upload',

        "ajax":
            {
                type: 'get',
                url: "/sao-table-unliq-fund-list-ci",
                data: function (e)
                {
                    e.id = ciIdUnliqHold
                }
            },
        "columns":
            [
                {data: 'dispatcher_request_date', name: 'dispatcher_request_date'},
                {
                    data : function amount(data)
                    {
                        var amt = atob(data.fund_amount);

                        return '₱ ' + amt;
                    }
                },
                {
                    data : function action(data)
                    {
                        return '<button class = "btn_view_fund_details btn btn-xs btn-primary" name = "'+data.id+'" ><i class = "fa fa-fw fa-info-circle"></i>View Full Details</button>'
                    },
                    "searchable" : false,
                    "orderable" : false
                }
            ],
        "order": [[0, 'desc']],
        "pageLength": 10,
        "lengthMenu": [[2, 10, 25, 50, -1], ['2 rows', '10 rows', '25 rows', '50 rows', 'Show all']],
        "bSortClasses": false,
        // "aoColumnDefs": [{ "bVisible": false, "aTargets": [6] }],
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
        }
    });

    $('#table_sao_unliq_fund_req tbody').on( 'click', 'tr', function ()
    {
        if($(this).hasClass('selected'))
        {
            var target1 = $(event.target);

            if (target1.is("button"))
            {

            }
            else
            {
                $(this).removeClass('selected');

                $('#amtToAssignCi').attr('disabled', false);
            }
        }
        else
        {
            var target2 = $(event.target);

            if (target2.is("button"))
            {

            }
            else
            {
                table_fund_hold.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');

                var amt = $.map(table_fund_hold.rows('.selected').data(),function (item) {
                    return atob(item.fund_amount)
                });

                $('#amtToAssignCi').val(amt);
                $('#amtToAssignCi').attr('disabled', true);
            }
        }
    });

    $('#table_sao_unliq_fund_req_filter input').unbind();
    $('#table_sao_unliq_fund_req_filter input').bind('keyup change', function (e)
    {
        if ($(this).is(':focus'))
        {
            if (e.keyCode == 13)
            {
                table_fund_hold.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '')
                {
                    table_fund_hold.search($(this).val()).draw();
                }
            }
        }
    });
}

$('#table_sao_unliq_fund_req').on('click', '.btn_view_fund_details', function()
{
    var id = $(this).attr('name');
    console.log(id);
    $('#modal-view-fund-req-hold').modal('show');

    showFundDetailsAll(id)
});

function showFundDetailsAll(id)
{
    $.ajax
    ({
        type : 'get',
        url : 'sao-get-all-info-fund-hold',
        data :
            {
                'id' : id
            },
        success : function(data)
        {
            console.log(data);

            $('#fund_id_hold').html(id);
            $('#fund_request_date_hold').html(data[0][0].dispatcher_request_date);
            $('#fund_delivery_date_hold').html(data[0][0].delivered_date);
            $('#fund_hold_date_hold').html(data[0][0].hold_date_time);
            $('#fund_amount_hold').html('₱ '+ atob(data[0][0].fund_amount));

            var accts = '';
            var i;

            for(i = 0 ; i < data[1].length ; i++)
            {
                var check;

                if(data[1][i].subjcoob == 'SUBJECT')
                {
                    check = 'SUBJECT - <b>'+ data[1][i].account_name+'</b>';
                }
                else
                {
                    check = 'COBORROWER - <b>' + data[1][i].account_name + '</b>';
                }

                accts +=  check + '<br>';
            }

            $('#fund_account_hold').html(accts);
        }
    });
}

function unliqHoldTotal()
{
    $.ajax
    ({
        type : 'get',
        url : 'sao-get-ci-endorse-no-fund',
        data :
            {
                'id' : ciIdUnliqHold
            },
        success : function(data)
        {
            console.log(data);
            var addOption;

                unliqCiAmount = data[1];
                holdCiAmount = data[2];

                $('#ciNameUnliqHold').html(data[0]);
                $('#unliqFundCi').html(unliqCiAmount);
                $('#holdFundCi').html(holdCiAmount);

                if(checkFundIUnliqopen == false)
                {
                    checkFundIUnliqopen = true;
                    showPendingAccountsFund();
                }
                else
                {
                    table_fund_endorsed_no_fund.ajax.reload(null, false);
                }

            if(data[3] > 0)
            {
                $('#submitAmtforCiUnliqHold').hide();
                $('#btnEmergencyFundCi').show();
                $('#checkShellCI').html('*with Shell Card')

                $('#fundSourceHoldUnliq').html('<option value="Emergency Fund">Emergency Fund</option>' +
                    '<option value="Unliquidated Fund">Unliquidated Fund</option><option value="On-Hold Fund">On-Hold Fund</option>');
                $('#showSaoRemUnliq').show();

            }
            else if(data[3] == 0)
            {
                $('#submitAmtforCiUnliqHold').show();
                $('#btnEmergencyFundCi').hide();
                $('#checkShellCI').html('')

                $('#fundSourceHoldUnliq').html('<option value="Unliquidated Fund">Unliquidated Fund</option>\n' +
                    '                                                        <option value="On-Hold Fund">On-Hold Fund</option>');
                $('#showSaoRemUnliq').hide();
            }

            if(checkifOpenUnliqFundReq == true)
            {
                table_fund_hold.ajax.reload(null, false);
            }
        }
    });
}

$('#btnEmergencyFundCi').click(function()
{
    var btn = $(this);
    var idsAssign = [];
    btn.attr('disabled', true);

    // var idsAssign = $.map(table_fund_endorsed_no_fund.rows('.selected').data(),function (item) {
    //     return item.id
    // });

    $('.remove_account_for_fund').each(function()
    {
        idsAssign.push($(this).attr('value'));
    });
    // console.log(idsAssign);

    var amountSend = $('#amtToAssignCi').val();

    var saoRemarks = $('#saoRemText').val();

    if(idsAssign != '')
    {
        if(amountSend <= 0)
        {
            alert('Please indicate valid amount!');
            btn.attr('disabled', false);
        }
        else
        {
            $.ajax
            ({
                type : 'post',
                url : 'sao-send-emergency-req',
                data :
                    {
                        'id' : ciIdUnliqHold,
                        'amount' : amountSend,
                        'saoRemarks' : saoRemarks,
                        idsAssign : idsAssign
                    },
                beforeSend : function()
                {
                    $('#modal-loading-to-manage').modal({backdrop : "static"});
                },
                success : function(data)
                {
                    $('#modal-loading-to-manage').modal('hide');
                    btn.attr('disabled', false);
                    table_fund_endorsed_no_fund.ajax.reload(null, false);
                    $('#amtToAssignCi').val(0);
                    $('#saoRemText').val('');
                    table_fund_logs_sao.ajax.reload(null, false);
                    // console.log(data)
                },
                complete: function()
                {
                    $('.remove_account_for_fund').each(function()
                    {
                        $(this).remove();
                    });
                }
            });
        }

    }
    else if(idsAssign == '')
    {
        alert('Please select account to assign to fund.');
        btn.attr('disabled', false);
    }
});
var req_active = 'fund_pen';
var tab_pen = true;
var tab_app = false;
var fund_dec = false;


$('.ci_req_status_class').click(function () {

    var gethref = $(this).attr('href');

    console.log(gethref);

    if (gethref == '#tab_1_fund')
    {
        if ($('' + gethref + '').hasClass('active'))
        {
            console.log('do nothing');
            req_active = 'fund_pen';
        }
        else if (tab_pen) {
            console.log('already loaded');
            req_active = 'fund_pen';
        }
        else if (tab_pen == false)
        {
            tab_pen = true;
            req_active = 'fund_pen';
        }
    }
    else if (gethref == '#tab_2_fund')
    {
        if ($('' + gethref + '').hasClass('active'))
        {
            console.log('do nothing');
            req_active = 'fund_appro';
        }
        else if (tab_app)
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
            req_active = 'fund_appro';

        }
        else if (tab_app == false)
        {
            req_active = 'fund_appro';
            tab_app = true;
            tbl_approved()
        }
    }
    else if (gethref == '#tab_3_fund')
    {
        if ($('' + gethref + '').hasClass('active')) {
            console.log('do nothing');
            req_active = 'fund_dec';

        }
        else if (fund_dec)
        {
            if(refreshDec == true)
            {
                table_ci_fund_dec.ajax.reload(null, false);
                refreshDec = false;
            }
            else
            {
                console.log('already loaded');
            }
            req_active = 'fund_dec';
        }
        else if (fund_dec == false)
        {
            fund_dec = true;
            req_active = 'fund_dec';
            tble_dcline();
        }
    }
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



function saoFundLogs()
{
    $('#fund-request-sao-override-table thead th').each(function()
    {
        table_logs_thead[logsCountFund] = $(this).text();
        logsCountFund++;
        title = $(this).text();
        $(this).html(title);
    });

    table_fund_logs_sao = $('#fund-request-sao-override-table').DataTable
    ({
        "processing": true,
        "serverSide": true,
        "responsive": true,
        "ajax": 'srao-fund-override-logs',
        "columns":
            [
                {data : 'sao_name' , name : 'user_2.name'},
                {data : 'date_time', name : 'fund_requests.sao_logs_date_time'},
                {data : 'sent', name : 'fund_requests.delivered_date'},
                {data : 'ci', name : 'users.name'},
                {
                    data : function tor(data)
                    {
                        var a ='';

                        if(data.tor == 'EMERGENCY FUND')
                        {
                            a = 'Emergency Fund';
                        }
                        else if(data.tor == 'NORMAL REQUEST')
                        {
                            if(data.apd == 'Done')
                            {
                                if(data.shc == 'Override')
                                {
                                    a = 'SAO Override of On-Hold Fund';
                                }
                            }
                            else if(data.apd == 'Assigned')
                            {
                                a = 'New Fund from Unliquidated Funds';
                            }
                            else if(data.apd == 'New')
                            {
                                if(data.shc == 'Override')
                                {
                                    a = 'SAO Override of On-Hold Fund';
                                }
                            }
                        }

                        return a;

                    },
                    'name' : 'users.name',
                    'searchable' : false
                },
                {
                    data : function amount(data)
                    {
                        if(data.sao_stat != 'DISAPPROVED')
                        {
                            if(data.tor == 'EMERGENCY FUND')
                            {
                                if(data.orig_amount == null)
                                {
                                    return '';
                                }
                                else
                                {
                                    return '₱ ' + atob(data.orig_amount);
                                }
                            }
                            else
                            {
                                if(data.orig_amount == null)
                                {
                                    return '';
                                }
                                else
                                {
                                    return '₱ ' + atob(data.orig_amount);
                                }
                            }
                        }
                        else
                        {
                            return '₱ ' + atob(data.orig_amount);
                        }


                    },
                    'name' : 'users.name',
                    'searchable' : false
                },
                {
                    data : function amount(data)
                    {
                        if(data.sao_stat == 'DISAPPROVED')
                        {
                            return '-';
                        }
                        else if(data.manage == null)
                        {
                            return ''
                        }
                        else
                        {
                            if(data.amount == null)
                            {
                                return '';
                            }
                            else
                            {
                                return '₱ ' + atob(data.amount);
                            }
                        }
                    },
                    'name' : 'users.name',
                    'searchable' : false
                },
                {
                    data : function status(data)
                    {
                        var b = '';

                        if(data.tor == 'EMERGENCY FUND')
                        {
                            if(data.apd == 'Done')
                            {
                                if(data.shc == 'Hold')
                                {
                                    b = 'Fund On-Hold by Finance';
                                }
                                else if(data.shc == 'Cancel')
                                {
                                    b = 'Fund Cancelled by Finance';
                                }
                                else if(data.shc == '' || data.shc == null)
                                {
                                    b = 'Fund Delivered to CI';
                                }
                            }
                            else if(data.apd == 'New')
                            {
                                if(data.shc == 'Hold')
                                {
                                    b = 'Fund on-hold and re-submitted as new fund';
                                }
                                else if(data.shc == 'Cancel')
                                {
                                    b = 'Fund Cancelled by Finance';
                                }
                            }
                            else if(data.apd == '')
                            {
                                if(data.manage == null)
                                {
                                    if(data.sao_stat == 'DISAPPROVED')
                                    {
                                        b = 'Fund Disapproved by Management';
                                    }
                                    else if(data.sao_stat == 'APPROVED')
                                    {
                                        b = 'Fund Sending on Process by Finance'
                                    }
                                    else
                                    {
                                        b = 'Fund Sending on Process by Management'
                                    }

                                }
                                else
                                {
                                    b = 'Fund Sending on Process by Finance'
                                }
                            }
                            else if(data.apd == 'Pending')
                            {
                                b = 'Fund Sending on Process by Management'
                            }
                        }
                        else
                        {
                            if(data.stat == 'liquidated')
                            {
                                b = 'Liquidated by CI';
                            }
                            else
                            {
                                b = 'Unliquidated Fund';
                            }
                        }

                        return b;
                    },
                    'name' : 'users.name',
                    'searchable' : false
                },
                {
                    data : function rem(data)
                    {
                        if(data.tor == 'EMERGENCY FUND')
                        {
                            if(data.sao_stat == 'APPROVED')
                            {
                                return '<button class="btnViewManagementRem btn btn-block btn-xs btn-info" style="width : 100%" name = "'+data.manage_rem+'">VIEW MANAGEMENT REMARKS</button>';
                            }
                            else
                            {
                                return '';
                            }

                        }
                        else if(data.tor == 'NORMAL REQUEST')
                        {
                            return '';
                        }
                    },
                    'name' : 'users.name',
                    'searchable' : false
                }
            ],
        // "order": [[0, 'desc']],
        "pageLength": 10,
        "lengthMenu": [[2, 10, 25, 50, -1], ['2 rows', '10 rows', '25 rows', '50 rows', 'Show all']],
        "bSortClasses": false,
        // "aoColumnDefs": [{ "bVisible": false, "aTargets": [6] }],
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
        }
    });

    $('#fund-request-sao-override-table_filter input').unbind();
    $('#fund-request-sao-override-table_filter input').bind('keyup change', function (e)
    {
        if ($(this).is(':focus'))
        {
            if (e.keyCode == 13)
            {
                table_fund_logs_sao.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '')
                {
                    table_fund_logs_sao.search($(this).val()).draw();
                }
            }
        }
    });
}

$('#fund-request-sao-override-table').on('click', '.btnViewManagementRem', function()
{
    $('#req_rem_remarks_manage-1').val('');
    $('#modal-req-rem-manage-1').modal('show');

    $('#req_rem_remarks_manage-1').val($(this).attr('name'));
});

function fund_disp_init()
{
    var template = Handlebars.compile($("#details-template").html());
    tableFundRequest = $('#table-advance-fund-request').DataTable(
        {
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "ajax": "/sao-get-fund-request-table",
            "columns":
                [
                    {
                        "className":      'details-control',
                        "orderable":      false,
                        "searchable":      false,
                        "data":           null,
                        "defaultContent": ''
                    },
                    {data: 'id', name: 'fund_requests.id'},
                    {
                        data: function (data)
                        {
                            return data.fci
                        },
                        "name": 'CiName.name'
                    },
                    {
                        data: function (data)
                        {
                            return 'All';
                        },
                        "name": 'CiName.name'
                    },
                    {
                        data: function (data)
                        {
                            return data.type_of_fund_request
                        },
                        "name": 'fund_requests.type_of_fund_request'
                    },
                    {
                        data: function (data)
                        {
                            // console.log(data);


                            if(data.sao_status=='APPROVED' || data.finance_status=='APPROVED')
                            {
                                return "Php "+atob(data.fund_amount)+' <small class="label bg-green">On Process</small>'
                            }
                            else
                            {
                                return "Php "+atob(data.fund_amount)+' <small class="label bg-orange">Pending</small>'
                            }
                        },
                        "name": 'fund_requests.fund_amount'
                    },
                    {
                        data: function (data)
                        {
                            return data.count;
                            // return 'qq';

                        },
                        "name": 'count.type'
                    },
                    {
                        data: function (data)
                        {
                            if(data.sao_logs_date_time != null)
                            {
                                return data.sao_logs_date_time;
                            }
                            else if(data.sao_logs_date_time != null)
                            {
                                return data.sao_logs_date_time;
                            }
                            else {
                                return data.dispatcher_request_date;
                            }

                        },
                        "name": 'fund_requests.dispatcher_request_date'
                    },
                    {
                        data: function (data)
                        {
                            if(data.sao_status=='APPROVED' || data.finance_status=='APPROVED')
                            {
                                return '<button class="btn btn-xs btn-success btn-block">ON PROCESS</button>'+
                                    '<button class="btn btn-xs btn-info btn-block" name="'+data.fci+':'+data.fci_id+'" id="btn_open_modal_add_req" value="'+data.id+'" data-toggle="modal" data-target="#modal_additional_fund_request">ADDITIONAL REQUEST</button>';
                            }
                            else
                            {
                                return '<button class="btn btn-xs btn-danger btn-block" value="'+data.id+'" id="btnCancelFund">Cancel Request</button>'+
                                    '<button class="btn btn-xs btn-info btn-block" name="'+data.fci+':'+data.fci_id+'" id="btn_open_modal_add_req" value="'+data.id+'" data-toggle="modal" data-target="#modal_additional_fund_request">ADDITIONAL REQUEST</button>';

                            }
                        },
                        "searchable": false,
                        "name": 'fund_requests.id'
                    }
                ],
            "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull)
            {
                var countDownDate = new Date(aData.dispatcher_request_date);
                var now = new Date();
                var distance = countDownDate.setMinutes(countDownDate.getMinutes()+20) - now;

                var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                if (minutes>=15)
                {
                    $('td', nRow).css('background-color', '#b3ffb3');
                }
                else if (minutes>=10)
                {
                    $('td', nRow).css('background-color', '#ffb84d');
                }
                else if (minutes>=5 || minutes<=5)
                {
                    $('td', nRow).css('background-color', '#ffb3b3');
                }
            },
            "order": [[1, 'desc']],
            "pageLength": 10,
            "bSortClasses": false,
            "deferRender": false,
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

    $('#table-advance-fund-request_filter input').unbind();
    $('#table-advance-fund-request_filter input').bind('keyup change',function (e) {

        if($(this).is(':focus'))
        {
            if (e.keyCode == 13) {
                tableFundRequest.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '') {
                    tableFundRequest.search($(this).val()).draw();
                }
            }
        }
    });


    // Add event listener for opening and closing details
    $('#table-advance-fund-request tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = tableFundRequest.row(tr);
        var tableId = 'posts-' + row.data().id;

        if (row.child.isShown()) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        } else {
            // Open this row
            row.child(template(row.data())).show();
            initTable(tableId, row.data());
            tr.addClass('shown');
            // tr.next().find('td').addClass('no-padding bg-white');
        }
    });

    function initTable(tableId, data) {
        $('#' + tableId).DataTable({
            processing: true,
            serverSide: true,
            order: [[0, 'desc']],
            // ajax: 'pending_fund_details_endorsements',
            ajax:
                {
                    url: "/pending_fund_details_endorsements",
                    data : function (e) {
                        e.id = data.id
                    }
                },
            columns: [
                { data: 'id', name: 'endorsements.id' },
                { data: 'name', name: 'endorsements.account_name' },
                { data: 'address', name: 'endorsements.address' },
                { data: 'city_muni', name: 'municipalities.muni_name'},
                { data: 'provinces', name: 'endorsements.provinces'},
                { data: 'tor', name: 'endorsements.type_of_request' },
                { data: 'date', name: 'endorsements.date_endorsed' }
            ]
        })
    }

    var template_success = Handlebars.compile($("#details-template-success").html());
    tableFundSuccess = $('#table-advance-fund-success').DataTable(
        {
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "ajax": "/sao-table-fund-success",
            "columns":
                [

                    {
                        "className":      'details-control',
                        "orderable":      false,
                        "searchable":      false,
                        "data":           null,
                        "defaultContent": ''
                    },
                    {data: 'id', name: 'fund_requests.id'},
                    {
                        data: function (data)
                        {
                            return data.fci
                        },
                        "name": 'CiName.name'
                    },
                    {
                        data: function (data)
                        {
                            return 'All';
                        },
                        "name": 'CiName.name'
                    },
                    {
                        data: function (data)
                        {
                            return data.type_of_fund_request
                        },
                        "name": 'fund_requests.type_of_fund_request'
                    },
                    {
                        data: function (data)
                        {
                            return atob(data.fund_amount);
                        },
                        "name": 'fund_requests.fund_amount'
                    },
                    {
                        data: function (data)
                        {
                            return data.count;
                            // return 'qq';

                        },
                        "name": 'count.type'
                    },
                    {
                        data: function (data)
                        {
                            if(data.sao_logs_date_time != null)
                            {
                                return data.sao_logs_date_time;
                            }
                            else if(data.sao_logs_date_time != null)
                            {
                                return data.sao_logs_date_time;
                            }
                            else {
                                return data.dispatcher_request_date;
                            }
                        },
                        "name": 'fund_requests.dispatcher_request_date'
                    },
                    {data: 'status_button', name: 'fund_requests.id'}

                    // {
                    //     data: function (data)
                    //     {
                    //         // console.log(data.status);
                    //
                    //         if(data.status == '' || data.status_atm == '')
                    //         {
                    //             return '<button class="btn btn-xs btn-warning btn-block">WAITING FOR RECEIVER</button>'+
                    //                 '<button class="btn btn-xs btn-info btn-block" name="'+data.fci+':'+data.fci_id+'" id="btn_open_modal_add_req" data-toggle="modal" data-target="#modal_additional_fund_request" value="'+data.id+'">ADDITIONAL REQUEST</button>';
                    //
                    //
                    //         }
                    //         else
                    //         {
                    //             return '<button class="btn btn-xs btn-success btn-block">UPLOADED</button>'+
                    //                 '<button class="btn btn-xs btn-info btn-block" name="'+data.fci+':'+data.fci_id+'" id="btn_open_modal_add_req" data-toggle="modal" data-target="#modal_additional_fund_request" value="'+data.id+'">ADDITIONAL REQUEST</button>';
                    //
                    //         }
                    //     },
                    //     "searchable": false
                    // }
                ],
            "order": [[1, 'desc']],
            "pageLength": 10,
            "bSortClasses": false,
            "deferRender": false,
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

    $('#table-advance-fund-success_filter input').unbind();
    $('#table-advance-fund-success_filter input').bind('keyup change',function (e) {

        if($(this).is(':focus'))
        {
            if (e.keyCode == 13) {
                tableFundSuccess.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '') {
                    tableFundSuccess.search($(this).val()).draw();
                }
            }
        }
    });

    // Add event listener for opening and closing details
    $('#table-advance-fund-success tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = tableFundSuccess.row(tr);
        var tableId = 'success_posts-' + row.data().id;

        if (row.child.isShown()) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        } else {
            // Open this row
            row.child(template_success(row.data())).show();
            initTable_success(tableId, row.data());
            tr.addClass('shown');
            // tr.next().find('td').addClass('no-padding bg-white');
        }
    });

    function initTable_success(tableId, data) {
        $('#' + tableId).DataTable({
            processing: true,
            serverSide: true,
            order: [[0, 'desc']],
            // ajax: 'pending_fund_details_endorsements',
            ajax:
                {
                    url: "/pending_success_details_endorsements",
                    data : function (e) {
                        e.id = data.id
                    }
                },
            columns: [
                { data: 'id', name: 'endorsements.id' },
                { data: 'name', name: 'endorsements.account_name' },
                { data: 'address', name: 'endorsements.address' },
                { data: 'city_muni', name: 'municipalities.muni_name'},
                { data: 'provinces', name: 'endorsements.provinces'},
                { data: 'tor', name: 'endorsements.type_of_request' },
                { data: 'date', name: 'endorsements.date_endorsed' }
            ],
            "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull)
            {
                // console.l
                if (aData.type == 'Transferred')
                {
                    $('td', nRow).css('background-color', '#ffb3b3');
                }
            }
        })
    }


    var template_disapproved = Handlebars.compile($("#details-template-disapproved").html());
    tableFundDisapproved = $('#table-advance-fund-disapproved').DataTable(
        {
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "ajax": "/sao-get-fund-disapproved-table",
            "columns":
                [
                    {
                        "className":      'details-control',
                        "orderable":      false,
                        "searchable":      false,
                        "data":           null,
                        "defaultContent": ''
                    },
                    {data: 'id', name: 'fund_requests.id'},
                    {
                        data: function (data)
                        {
                            return data.fci
                        },
                        "name": 'CiName.name'
                    },
                    {
                        data: function (data)
                        {
                            return 'All';
                        },
                        "name": 'CiName.name'
                    },
                    {
                        data: function (data)
                        {
                            return data.type_of_fund_request
                        },
                        "name": 'fund_requests.type_of_fund_request'
                    },
                    {
                        data: function (data)
                        {
                            return atob(data.fund_amount);
                        },
                        "name": 'fund_requests.fund_amount'
                    },
                    {data: 'count', name: 'fund_requests.id'},
                    // {
                    //     data: function (data)
                    //     {
                    //         return data.count;
                    //         // return 'qq';
                    //
                    //     },
                    //     "name": 'count.type'
                    // },
                    {
                        data: function (data)
                        {
                            if(data.sao_logs_date_time != null)
                            {
                                return data.sao_logs_date_time;
                            }
                            else if(data.sao_logs_date_time != null)
                            {
                                return data.sao_logs_date_time;
                            }
                            else {
                                return data.dispatcher_request_date;
                            }
                        },
                        "name": 'fund_requests.dispatcher_request_date'
                    },
                    {
                        data: function (data)
                        {
                            if(data.sao_status=='DISAPPROVED')
                            {
                                return '<button class="btn btn-xs btn-danger btn-block">DISAPPROVED BY SAO</button>';
                            }
                            else if(data.finance_status=='DISAPPROVED')
                            {
                                return '<button class="btn btn-xs btn-danger btn-block">DISAPPROVED BY FINANCE</button>';
                            }
                        },
                        "searchable": false
                    }
                ],
            "order": [[1, 'desc']],
            "pageLength": 10,
            "bSortClasses": false,
            "deferRender": false,
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

    $('#table-advance-fund-disapproved_filter input').unbind();
    $('#table-advance-fund-disapproved_filter input').bind('keyup change',function (e) {

        if($(this).is(':focus'))
        {
            if (e.keyCode == 13) {
                tableFundDisapproved.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '') {
                    tableFundDisapproved.search($(this).val()).draw();
                }
            }
        }
    });



    // Add event listener for opening and closing details
    $('#table-advance-fund-disapproved tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = tableFundDisapproved.row(tr);
        var tableId = 'disapproved_posts-' + row.data().id;

        if (row.child.isShown()) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        } else {
            // Open this row
            row.child(template_disapproved(row.data())).show();
            initTable_disapproved(tableId, row.data());
            tr.addClass('shown');
            // tr.next().find('td').addClass('no-padding bg-white');
        }
    });

    function initTable_disapproved(tableId, data) {
        $('#' + tableId).DataTable({
            processing: true,
            serverSide: true,
            order: [[0, 'desc']],
            // ajax: 'pending_fund_details_endorsements',
            ajax:
                {
                    url: "/pending_disapproved_details_endorsements",
                    data : function (e) {
                        e.id = data.id
                    }
                },
            columns: [
                { data: 'id', name: 'endorsements.id' },
                { data: 'name', name: 'endorsements.account_name' },
                { data: 'address', name: 'endorsements.address' },
                { data: 'city_muni', name: 'municipalities.muni_name'},
                { data: 'provinces', name: 'endorsements.provinces'},
                { data: 'tor', name: 'endorsements.type_of_request' },
                { data: 'date', name: 'endorsements.date_endorsed' }
            ],
            "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull)
            {
                // console.l
                if (aData.type == 'Transferred')
                {
                    $('td', nRow).css('background-color', '#ffb3b3');
                }
            }
        })
    }


    var template_cancel = Handlebars.compile($("#details-template-cancel").html());
    tableFundCancelled = $('#table-advance-fund-cancelled').DataTable(
        {
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "ajax": "/sao-get-fund-cancelled-table",
            "columns":
                [
                    {
                        "className":      'details-control',
                        "orderable":      false,
                        "searchable":      false,
                        "data":           null,
                        "defaultContent": ''
                    },
                    {data: 'id', name: 'fund_requests.id'},
                    {
                        data: function (data)
                        {
                            return data.fci
                        },
                        "name": 'CiName.name'
                    },
                    {
                        data: function (data)
                        {
                            return 'All';
                        },
                        "name": 'CiName.name'
                    },
                    {
                        data: function (data)
                        {
                            return data.type_of_fund_request
                        },
                        "name": 'fund_requests.type_of_fund_request'
                    },
                    {
                        data: function (data)
                        {
                            return atob(data.fund_amount);
                        },
                        "name": 'fund_requests.fund_amount'
                    },
                    {
                        data: function (data)
                        {
                            return data.count;
                            // return 'qq';

                        },
                        "name": 'count.type'
                    },
                    {
                        data: function (data)
                        {
                            if(data.dispatcher_request_date != null)
                            {
                                return data.dispatcher_request_date;
                            }
                            else if(data.sao_logs_date_time != null)
                            {
                                return data.sao_logs_date_time;
                            }
                        },
                        "name": 'fund_requests.dispatcher_request_date'
                    },
                    {
                        data: function (data)
                        {
                            return '<button class="btn btn-xs btn-danger btn-block">Cancelled</button>';
                        },
                        "name": 'fund_requests.id',
                        "searchable": false
                    }
                ],
            "order": [[1, 'desc']],
            "pageLength": 10,
            "bSortClasses": false,
            "deferRender": false,
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

    $('#table-advance-fund-cancelled_filter input').unbind();
    $('#table-advance-fund-cancelled_filter input').bind('keyup change',function (e) {

        if($(this).is(':focus'))
        {
            if (e.keyCode == 13) {
                tableFundCancelled.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '') {
                    tableFundCancelled.search($(this).val()).draw();
                }
            }
        }
    });

    // Add event listener for opening and closing details
    $('#table-advance-fund-cancelled tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = tableFundCancelled.row(tr);
        var tableId = 'cancel_posts-' + row.data().id;

        if (row.child.isShown()) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        } else {
            // Open this row
            row.child(template_cancel(row.data())).show();
            initTable_cancel(tableId, row.data());
            tr.addClass('shown');
            // tr.next().find('td').addClass('no-padding bg-white');
        }
    });

    function initTable_cancel(tableId, data) {
        $('#' + tableId).DataTable({
            processing: true,
            serverSide: true,
            order: [[0, 'desc']],
            // ajax: 'pending_fund_details_endorsements',
            ajax:
                {
                    url: "/pending_cancel_details_endorsements",
                    data : function (e) {
                        e.id = data.id
                    }
                },
            columns: [
                { data: 'id', name: 'endorsements.id' },
                { data: 'name', name: 'endorsements.account_name' },
                { data: 'address', name: 'endorsements.address' },
                { data: 'city_muni', name: 'municipalities.muni_name'},
                { data: 'provinces', name: 'endorsements.provinces'},
                { data: 'tor', name: 'endorsements.type_of_request' },
                { data: 'date', name: 'endorsements.date_endorsed' }
            ],
            "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull)
            {
                // console.l
                if (aData.type == 'Transferred')
                {
                    $('td', nRow).css('background-color', '#ffb3b3');
                }
            }
        })
    }
}

$('#table-sao-ci-hold-unliq').on('click', '.btn_select_acc_to_fund', function()
{
    var get_id = $(this).attr('name');
    var get_details = $(this).val();

    if($(this).html() == 'Select')
    {
        $('#sao_fund_selected_accnt').append(
            '<tr class="remove_account_for_fund" value="'+get_id+'">' +
            '<td>'+get_id+'</td>' +
            '<td>'+get_details+'</td>' +
            '<td><button class="btn btn-danger removeTofundAcc" name="'+get_id+'">Remove</button></td>' +
            '</tr>'
        );

        $(this).html('Un-Select');
    }
    else
    {
        $('.remove_account_for_fund').each(function () {

            if($(this).attr('value') == get_id)
            {
                $(this).remove();
            }

        });

        $(this).html('Select');
    }
});

$('#sao_fund_selected_accnt').on('click', '.removeTofundAcc', function()
{
    var id = $(this).attr('name');

    console.log(id);

    $('.remove_account_for_fund').each(function()
    {
        if($(this).attr('value') == id)
        {
            $(this).remove();
        }
    });

    $('.btn_select_acc_to_fund').each(function()
    {
        if($(this).attr('name') == id)
        {
            $(this).html('Select');
        }
    });
});

// function faTablesCi()
// {
//     $('#table-finance-expenses-report thead th').each(function()
//     {
//         coltittle3[col_count3] = $(this).text();
//         col_count3++;
//     });
//     tableFundFa = $('#table-finance-expenses-report').DataTable({
//
//         // "responsive": true,
//         dom: 'Blfrtip',
//         buttons:
//             [
//                 {
//                     extend: 'excel',
//                     title : 'CI Liquidation Monitoring',
//                     exportOptions:
//                         {
//                             columns: [0, 1, 2, 3, 4, 5, 6, 7],
//                             format:
//                                 {
//                                     header: function (dt, idx) {
//                                         return coltittle3[(idx)];
//                                     }
//                                 }
//                         },
//                     customize: function ( xlsx )
//                     {
//                         var sheet = xlsx.xl.worksheets['sheet1.xml'];
//
//                         var loop = 0;
//                         $('row', sheet).each(function () {
//
//                             $(this).find("c").attr('s', '25');
//                             $('row:first c', sheet).attr('s', '51');
//                             loop++;
//                         });
//                     }
//                 },
//                 {
//                     extend: 'colvis',
//                     text: 'Show/Hide Column',
//                     columnText: function (dt, idx, title)
//                     {
//                         return coltittle3[(idx)];
//                     }
//                 }
//             ],
//         "processing": true,
//         "serverSide": true,
//         // "responsive": true,
//         "ajax":
//             {
//                 "url": "/finance-ci-fund-request-table-fa",
//                 "data": function (d)
//                 {
//                     console.log('testing');
//                     d.start = $('#ci_expense_range_start').val();
//                     d.end = $('#ci_expense_range_end').val();
//                     // d.max_date_endorsed = $('#max_report').val();
//                 }
//             },
//         "columns":
//             [
//                 {data: 'id', name: 'fund_requests.id'},
//                 {data : 'archi', name : 'archipelagos.archipelago_name'},
//                 // {data: 'name_disp', name: 'dispatcher_id.name'},
//                 {data: 'name_ci', name: 'ci_id.name'},
//                 {
//                     data : function dates(data)
//                     {
//                         if(data.tor == 'NORMAL REQUEST')
//                         {
//                             if(parseInt(atob(data.amount)) >= 2500)
//                             {
//                                 return data.sao_date;
//                             }
//                             else if(parseInt(atob(data.amount)) < 2500)
//                             {
//                                 return data.dispatcher_request_date;
//                             }
//                         }
//                         else if(data.tor == 'EMERGENCY FUND')
//                         {
//                             return data.sao_date;
//                         }
//                     },
//                     name: 'fund_requests.id'
//                 },
//                 {
//                     data: function (data)
//                     {
//                         return "Php "+atob(data.amount)
//                     },
//                     "name": 'fund_requests.fund_amount'
//                 },
//                 {data: 'liq', name: 'fund_requests.liquidated_amount'},
//                 {data: 'unliq', name: 'fund_requests.unliquidated_amount'},
//                 {data : 'finance_remarks' , name : 'fund_requests.finance_remarks'},
//                 {data : 'audit_remarks' , name : 'fund_requests.audit_remarks'},
//                 {
//                     data : function actions(data)
//                     {
//                         var dateTime = '';
//
//
//                         return '<button type = "button" class = "btn_view_ci_liq btn btn-sm btn-primary btn-block" name = '+ data.id +'><i class = "fa fa-fw fa-file-image-o"></i>View C.I Liquidation Info</button>' +
//                             '<button class = "btn-xs btn-block btn-primary" name = "'+data.id+'" id = "check_remarks_requestor">View Remarks</button>';
//                     },
//                     "name": 'action', "orderable": false, "searchable": false
//                 },
//                 {data: 'dispatcher_request_date', name: 'fund_requests.dispatcher_request_date', visible : false},
//                 {data : 'sao_date' , name : 'fund_requests.sao_emergency_req_date_time', visible : false}
//
//             ],
//         "order": [[0, 'desc']],
//         "pageLength": 25,
//         "lengthMenu": [[2, 10, 25, 50, -1], ['2 rows', '10 rows', '25 rows', '50 rows', 'Show all']],
//         "bSortClasses": false,
//         initComplete: function()
//         {
//             var api = this.api();
//
//             // Apply the search
//             api.columns().every(function() {
//                 var that = this;
//
//                 $('input', this.header()).on('keyup change', function(e)
//                 {
//                     if($(this).is(':focus'))
//                     {
//                         if(e.keyCode === 13)
//                         {
//                             if (that.search() !== this.value) {
//                                 that
//                                     .search(this.value)
//                                     .draw();
//                             }
//                         }
//                         else if (e.keyCode === 8)
//                         {
//                             if (this.value == '') {
//                                 that
//                                     .search(this.value)
//                                     .draw();
//                             }
//                         }
//                     }
//                 });
//             });
//         }
//
//     });
//
//     $('#table-finance-expenses-report_filter input').unbind();
//     $('#table-finance-expenses-report_filter input').bind('keyup change',function (e) {
//
//         if($(this).is(':focus'))
//         {
//             if (e.keyCode == 13) {
//                 tableFundFa.search($(this).val()).draw();
//             }
//             else if (e.keyCode === 8)
//             {
//                 if ($(this).val() == '') {
//                     tableFundFa.search($(this).val()).draw();
//                 }
//             }
//         }
//     });
// }

// $('#datepicker_report').change( function() {
//     var min = $.datepicker.formatDate('yy-mm-dd', $('#datepicker_report').datepicker('getDate'));
//     console.log(min);
//     $('#min_report').val(min);
//
//     var max = $.datepicker.formatDate('yy-mm-dd', $('#datepickermax_report').datepicker('getDate'));
//     console.log(max);
//
//     if(max === '')
//     {
//         $('#max_report').val(yearmonth+date);
//
//     }
//     else {
//         $('#max_report').val(max);
//     }
//     tableFundFa.draw();
// });

$('#table-advance-fund-request').on('click','#btnCancelFund', function ()
{
    $('#modal-fund-request-cancelling').modal('show');
    var fundReqId = $(this).attr('value');
    var fundHash = btoa(fundReqId);

    $.ajax
    ({
        method: 'get',
        url: 'sao_cancel_fund',
        data:
            {
                'fundHash': fundHash
            },
        success: function (data)
        {
            if(data=='success')
            {
                // alert('Fund Successfuly Cancelled!');
                countpending = 0;
                // $('#span_count').html('Pending Accounts w/o Fund Request: '+countpending);
                // console.log('rigger');
                naanona = false;

                var id = $('#selFciName').val();
                getpending_and_onhand_fund(id);

                setTimeout(function () {
                    $('#modal-fund-request-cancelling').modal('hide');
                    setTimeout(function () {
                        $('#modal-fund-request-cancel-success').modal('show');
                        setTimeout(function () {
                            $('#modal-fund-request-cancel-success').modal('hide');
                        },3000);
                    },1000);
                },1000);

                // refAllTbl();
                tableFundRequest.draw();
                tableFundCancelled.draw();
            }
            else if(data=='error')
            {
                alert('Requested fund is on process, cannot be cancel!');
                $('#modal-fund-request-cancelling').modal('hide');
                // refAllTbl();
                tablecifundrequest.ajax.reload(null,false);

            }
            else if(data=='disapproved')
            {
                $('#modal-fund-request-cancelling').modal('hide');
                alert('Requested fund disapproved, cancellation terminated!');
                tablecifundrequest.ajax.reload(null,false);


                // refAllTbl();
            }
        },
        complete: function()
        {
            tableFundRequest.draw();
        }
    });
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

$('.sao_assign_rad_click').click(function()
{
    if($(this).attr('value') == 'all')
    {
        $('#sao_assign_rad_holder').hide();
        tablee.draw();
    }
    else
    {
        if($(this).val() != '')
        {
            tablee.draw();
        }
        $('#sao_assign_rad_holder').show();
    }
});

$('#sao_assign_rad_holder').change(function()
{
    tablee.draw();
});

$('.sao_assign_rad_click_transfer').click(function()
{
    if($(this).attr('value') == 'all')
    {
        $('#sao_assign_rad_holder_transfer').hide();
        tableee.draw();
    }
    else
    {
        if($(this).val() != '')
        {
            tableee.draw();
        }
        $('#sao_assign_rad_holder_transfer').show();
    }
});

$('#sao_assign_rad_holder_transfer').change(function()
{
    tableee.draw();
});
