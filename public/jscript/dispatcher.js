/**
 * Created by aa on 9/7/2017.
 */
var table;
var tableFundRequest;
var tableFundSuccess;
var tableFundDisapproved;
var tableFundCancelled;
var tableFundChecker;
var toastr;
var dateEndorsed;
var timeEndorsed;
var id;
var times;
var acctID;
var tablecifundrequest;
var countpending = 0;
var naanona = false;
var dash_board = false;
var disp_hist = false;
var fund_req = false;
var search_acct = false;
var dash_fa_bool = false;
var which_is_active = 'process_active';

var table_logs_thead = [];
var logsCountFund = 0;
var table_fund_logs_disp;
var tableFundFa;
var coltittle3 = [];
var col_count3 = 0;
var archie = '';




$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).ready(function()
{

    // $('#TimeDue').datetimepicker({
    //     use24hours: true
    // });

    $( "#DateDue" ).datepicker({
        dateFormat: "yy-mm-dd",
        language: "en-GB",
        orientation: "top auto"
    });
    // $( "#datepickermax" ).datepicker({
    //     dateFormat: "yy-mm-dd",
    //     language: "en-GB",
    //     orientation: "bottom auto"
    // });

    $('#chat_for_sao_dispa').removeAttr('hidden');

    // fetchOtherInro();
    // function fetchOtherInro() {
    //     times = setTimeout(function (){
    //
    //         var countid = 0;
    //         var getitds = [];
    //         var gettors = [];
    //         var tab = document.getElementById('endorsement-table');
    //         var n = tab.rows.length;
    //         var i, tr, tdid, tdtor;
    //
    //         for (i = 1; i < n; i++) {
    //             tr = tab.rows[i];
    //             if (tr.cells.length > 0)
    //             {
    //                 tdid = tr.cells[0];
    //                 tdtor = tr.cells[5];
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
    $('#btnReqFund').hide();
    $('#btnCantShell').hide();
    // $('#checkifShellCi').hide();



    table = $('#endorsement-table').DataTable
    (
        {
            // dom: 'Bfrtip',
            // buttons: [
            //     'copyHtml5',
            //     'excelHtml5',
            //     'csvHtml5',
            //     'pdfHtml5'
            // ],
            "responsive": true,
            "processing": true,
            "serverSide": true,
            // "ajax": "/fetch-endorsement",
            "ajax":
                {
                    url: "/fetch-endorsement",
                    data: function (d)
                    {
                        d.search_option = archie;
                    }
                },
            "columns":
                [

                    {data: 'id', name: 'endorsements.id'},
                    {data: 'date_endorsed', name: 'endorsements.date_endorsed'},
                    {data: 'time_endorsed', name: 'endorsements.time_endorsed'},
                    {data: 'date_due', name: 'endorsements.date_due'},
                    {data: 'time_due', name: 'endorsements.time_due'},
                    {data: 're_ci', name: 'endorsements.re_ci'},
                    {data: 'account_name', name: 'endorsements.account_name'},
                    {data: 'type_of_request', name: 'endorsements.type_of_request'},
                    // {
                    //
                    //     data: function actions(data) {
                    //
                    //         clearTimeout(times);
                    //         fetchOtherInro();
                    //         return '<span id="otherinfo'+data.id+'">'+data.type_of_request+'</span>';
                    //
                    //     },
                    //     'name' : 'endorsements.type_of_request'
                    // },
                    {data: 'type_of_loan', name: 'endorsements.type_of_loan'},
                    {data: 'client_name', name: 'endorsements.client_name'},
                    {data: 'client_remarks', name: 'endorsements.client_remarks'},
                    {data: 'requestor_name', name: 'endorsements.requestor_name'},
                    {data: 'muni_name', name: 'municipalities.muni_name', "className": "text-center"},
                    {data: 'name', name: 'provinces.name',"className": "text-center"},
                    {data: 'region_name', name: 'regions.region_name',"className": "text-center"},
                    {data: 'archipelago_name', name: 'archipelagos.archipelago_name',"className": "text-center"},
                    {
                        data: function actions(data)
                        {
                            if(data.status == 1 || data.status == 2 || data.status == 3)
                            {
                                var auto = '';
                                var add = '';

                                if(data.auto == 'Auto-Dispatched')
                                {
                                    auto = '<button class="btn btn-xs btn-info btn-block" id="btnUpdateNowDispatchAuto"  href="'+ data.id + '" value = "'+data.date_due+'" name = "'+data.time_due+'">UPDATE</button>';
                                    add = '(auto)'
                                }
                                return '<button class="btn btn-xs btn-success btn-block" id="">Already Dispatched'+add+'</button>' +auto+
                                    '<a href="'+ data.id + '" class="btn btn-xs btn-primary btn-block" id="btnFullViewInfo" data-toggle="modal" data-target="#modal-view-info">View Info</a>';

                            }
                            else
                            {
                                if(data.endorsement_note==null)
                                {
                                    return '<a href="'+ data.id + '" class="btn btn-xs btn-primary btn-block" id="btnView" data-toggle="modal" value = "'+data.date_endorsed+'" name = "'+data.time_endorsed+'" data-target="#dispatch_modal">Dispatch</a><br>' +
                                        '<a href="'+ data.id + '" class="btn btn-xs btn-primary btn-block" id="btnFullViewInfo" data-toggle="modal" data-target="#modal-view-info">View Info</a>';
                                }
                                else
                                {
                                    return '<a href="'+ data.id + '" class="btn btn-xs btn-primary btn-block" id="btnView" data-toggle="modal" value = "'+data.date_endorsed+'" name = "'+data.time_endorsed+'" data-target="#dispatch_modal">Dispatch</a>' +
                                        '<a href="'+ data.id + '" class="btn btn-xs btn-warning btn-block" id="btnNoteView" data-toggle="modal" data-target="#modal-dispatcher-view-notee">View Note</a>'+
                                        '<a href="'+ data.id + '" class="btn btn-xs btn-primary btn-block" id="btnFullViewInfo" data-toggle="modal" data-target="#modal-view-info">View Info</a>';
                                }
                            }
                        },
                        "orderable": false,
                        "searchable": false,
                        "name": 'action'
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
                    $(nRow).attr('class', '1');
                    if(aData.status == 1 || aData.status == 2 || aData.status == 3)
                    {
                        $('td', nRow).css('background-color', '#fff');
                        $(nRow).attr('class', '0');
                    }

                }
                else if (minutes>=10)
                {

                    $('td', nRow).css('background-color', '#ffb84d');
                    $(nRow).attr('class', '2');

                    if(aData.status == 1 || aData.status == 2 || aData.status == 3)
                    {
                        $('td', nRow).css('background-color', '#fff');
                        $(nRow).attr('class', '0');
                    }

                }
                else if (minutes>=5 || minutes<=5)
                {
                    $('td', nRow).css('background-color', '#ffb3b3');
                    $(nRow).attr('class', '3');

                    if(aData.status == 1 || aData.status == 2 || aData.status == 3)
                    {
                        $('td', nRow).css('background-color', '#fff');
                        $(nRow).attr('class', '0');
                    }
                }

            },
            "order": [[0, 'desc']],
            "pageLength": 10,
            "bSortClasses": false,
            "deferRender": true,
            initComplete: function()
            {
                $('#endorsement-table thead th').each(function() {
                    var title = $(this).text();
                    $(this).unbind();
                    $(this).html(title+'<br><input type="text" placeholder="Search" style="position: relative; width: 100%">');
                });

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

    $('#endorsement-table_filter input').unbind();
    $('#endorsement-table_filter input').bind('keyup change',function (e) {

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
    
    $('#select_dispt_arch').change(function()
    {
        archie = $(this).val();
        table.draw();
    });

    $('.datepicks').datepicker({
        dateFormat: "yy-mm-dd",
        // language: "en-GB",
        orientation: "bottom"
    });

    var today = new Date();
    var yearmonth;
    var date;
    $('.date_range_conts').css('display','none');
    $('#min').val('2015-01-01');
    $('#max').val('6000-01-01');

    // var dispNotifChannel = pusher.subscribe('dispNotifChannel');
    // dispNotifChannel.bind('App\\Events\\DispatcherPusherEvent', function (data)
    // {
    //     var timeRef = setInterval( function ()
    //     {
    //         table.ajax.reload(null, false);
    //         clearInterval(timeRef);
    //     }, 2000 );
    // });

    $(window).focus(function () {

        console.log('focus');
        interval = true;
    });

    setInterval(function ()
    {

        if(interval)
        {
            if(which_is_active == 'process_active')
            {
                table.ajax.reload(null, false);
            }
        }

        // tableFundRequest.ajax.reload(null, false);
        // tableFundSuccess.ajax.reload(null, false);
        // tableFundDisapproved.ajax.reload(null, false);
        // tableFundCancelled.ajax.reload(null, false);
        // tableFundChecker.ajax.reload(null, false);
    },60000);


    // $( "#datepicker" ).datepicker({
    //     dateFormat: "yy-mm-dd",
    //     language: "en-GB",
    //     orientation: "bottom auto"
    // });


    $('.viewable').click(function () {
        if($(this).is(":checked"))
        {
            if($(this).val() == 'All')
            {
                $('.viewable#rad_all_fin').prop('checked',true);
                $('.viewable#rad_all_pends').prop('checked',true);

                $('.date_range_conts').css('display','none');

                $('#min').val('2015-01-01');
                $('#max').val('6000-01-01');

                tablecifundrequest.draw();
            }
            else if($(this).val() == 'Date Range')
            {

                $('.viewable#rad_daterange_fin').prop('checked',true);
                $('.viewable#rad_daterange_pends').prop('checked',true);

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



                $('#datepickermin').val(month+dateyear);
                $('#datepickermax').val(month+dateyear);

                $('#min').val(yearmonth+date);
                $('#max').val(yearmonth+date);

                tablecifundrequest.draw();

                //pending


            }
        }
    });

    $('#datepickermin').change( function() {
        var min = $.datepicker.formatDate('yy-mm-dd', $('#datepickermin').datepicker('getDate'));
        console.log(min);
        $('#min').val(min);

        var max = $.datepicker.formatDate('yy-mm-dd', $('#datepickermax').datepicker('getDate'));
        console.log(max);

        if(max === '')
        {
            $('#max').val(yearmonth+date);

        }
        else {
            $('#max').val(max);
        }
        tablecifundrequest.draw();
    });
    $('#datepickermax').change( function() {

        var min = $.datepicker.formatDate('yy-mm-dd', $('#datepickermin').datepicker('getDate'));
        console.log(min);
        $('#min').val(min);

        var max = $.datepicker.formatDate('yy-mm-dd', $('#datepickermax').datepicker('getDate'));
        console.log(max);
        if(max === '')
        {
            $('#max').val(yearmonth+date);

        }
        else {
            $('#max').val(max);
        }
        tablecifundrequest.draw();
    });


    $('.viewable#rad_all_fin').prop('checked',true);
    $('.viewable#rad_all_pends').prop('checked',true);

    //leftsidebar
    $('.disp_a_class').click(function () {

        var gethref = $(this).attr('href');

        console.log(gethref);

        if(gethref == '#disp_fund_tab')
        {
            if( $(''+gethref+'').hasClass('active'))
            {
                console.log('do nothing');
                which_is_active = 'fund_active';

            }
            else if(fund_req)
            {
                console.log('already loaded');
                which_is_active = 'fund_active';

            }
            else if(fund_req == false)
            {
                fund_req = true;
                which_is_active = 'fund_active';
                fundLogTrack();

                // tableFundChecker = $('#table-advance-fund-checker').DataTable(
                //     {
                //         "responsive": true,
                //         "processing": true,
                //         "serverSide": true,
                //         "ajax": "/dispatcher-get-fund-checker-table",
                //         "columns":
                //             [
                //                 {data: 'name', name: 'users.name'},
                //                 {
                //                     data: function fundshhi(data)
                //                     {
                //                         // console.log(data);
                //
                //                         return 'Total Delivered Fund: <b>'+data.fund+'</b> / Realtime Fund: <b>'+data.fund_realtime+'</b>';
                //                     },
                //                     'name' : 'ci_fund_realtime_amount.fund'
                //                 }
                //             ],
                //         "order": [[0, 'desc']],
                //         "pageLength": 10,
                //         "bSortClasses": false,
                //         "deferRender": false,
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
                //     });
                //
                // $('#table-advance-fund-checker_filter input').unbind();
                // $('#table-advance-fund-checker_filter input').bind('keyup change',function (e) {
                //
                //     if($(this).is(':focus'))
                //     {
                //         if (e.keyCode == 13) {
                //             tableFundChecker.search($(this).val()).draw();
                //         }
                //         else if (e.keyCode === 8)
                //         {
                //             if ($(this).val() == '') {
                //                 tableFundChecker.search($(this).val()).draw();
                //             }
                //         }
                //     }
                // });


                getpending_and_onhand_fund($('#selFciName').val());
                tablecifundrequest = $('#table-ci-process-accounts').DataTable(
                    {
                        // "responsive": false,
                        "processing": true,
                        "serverSide": true,
                        "searching": true,
                        "paging": true,
                        "ajax":
                            {
                                url: "/dispatcher-ci-check-endorsement-process-fund-request",
                                data : function (e) {
                                    e.ci_id = $('#selFciName').val();
                                    e.min_date_endorsed = $('#min').val();
                                    e.max_date_endorsed = $('#max').val();
                                }
                            },
                        "columns":
                            [
                                // {data: 'id', name: 'endorsements.id'},
                                {
                                    data: function(data){
                                        return '<button class="btn_select_new_class btn btn-block btn-normal" name="'+data.id+'" value="'+data.account_name+'/'+data.address+'/'+data.city_muni+'/'+data.provinces+'/'+data.tor+'" id="btn_select_account_new">Select</button>'
                                    },
                                    name: 'endorsements.date_endorsed',
                                    orderable: false
                                },
                                {
                                    data: function id(data) {


                                        return '<p id="id_table">'+data.id+'</p>';

                                    },
                                    'orderable': false,
                                    'name' :'endorsements.id'
                                },
                                {data: 'account_name', name: 'endorsements.account_name', orderable: false},
                                {data: 'address', name: 'endorsements.address', orderable: false},
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
                                {data: 'city_muni', name: 'municipalities.muni_name', orderable: false},
                                {data: 'provinces', name: 'endorsements.provinces', orderable: false},
                                {data: 'tor', name: 'endorsements.type_of_request', orderable: false},
                                {data: 'date_endorsed', name: 'endorsements.date_endorsed', orderable: false}
                            ],
                        "order": [[1, 'desc']],
                        "lengthMenu": [[10, 25, 50, -1], ['10 rows', '25 rows', '50 rows', 'Show all']],
                        "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull)
                        {

                            // console.log(aData)
                            if (aData.type == 'Processing' || aData.type == 'Success')
                            {
                                $('td', nRow).css('display', 'none');
                            }
                            else if (aData.fund_request == 'Transferred')
                            {
                                $('td', nRow).css('border-color', '#ffb3b3');
                                countpending++;
                            }
                            else
                            {
                                if(naanona == false)
                                {
                                    countpending++;
                                }
                            }
                            // $('#span_count').html('Pending Accounts w/o Fund Request: '+countpending);
                            $('#span_count').html('');
                        },
                        // "pageLength": 10,
                        "bSortClasses": false,
                        "deferRender": true,
                        "initComplete": function (settings,json) {
                            naanona = true;
                            // alert('qwe');
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

                        },
                        "drawCallback": function () {

                            $('.where_remove_tr').each(function () {

                                var id_check_selected = $(this).attr('value');

                                // console.log(id_check_selected);

                                $('.btn_select_new_class').each(function () {

                                    if($(this).attr('name') == id_check_selected)
                                    {
                                        $(this).html('Un-select');
                                    }
                                });
                            });

                            naanona = true;
                        }
                    });

                $('#table-ci-process-accounts tbody').on('click', 'tr', function () {
                    // $(this).toggleClass('selected');
                    // console.log(this);
                });


                $('#table-ci-process-accounts_filter input').unbind();
                $('#table-ci-process-accounts_filter input').bind('keyup change',function (e) {

                    if($(this).is(':focus'))
                    {
                        if (e.keyCode == 13) {
                            tablecifundrequest.search($(this).val()).draw();
                        }
                        else if (e.keyCode === 8)
                        {
                            if ($(this).val() == '') {
                                tablecifundrequest.search($(this).val()).draw();
                            }
                        }
                    }
                });

                fund_disp_init();

            }
        }
        else if(gethref == '#disp_search_tab')
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
        else if(gethref == '#disp_history_tab')
        {
            if( $(''+gethref+'').hasClass('active'))
            {
                console.log('do nothing');
                which_is_active = 'trans_active';

            }
            else if(disp_hist)
            {
                console.log('already loaded');
                which_is_active = 'trans_active';
            }
            else if(disp_hist == false)
            {
                disp_hist = true;
                which_is_active = 'trans_active';
                disp_trans_init();
            }
        }
        else if(gethref == '#disp_dashboard_tab')
        {
            if( $(''+gethref+'').hasClass('active'))
            {
                console.log('do nothing');
                which_is_active = 'dash_active';

            }
            else if(dash_board)
            {
                console.log('already loaded');
                which_is_active = 'dash_active';
            }
            else if(dash_board == false)
            {
                dash_board = true;
                which_is_active = 'dash_active';
                dash_map_init();
            }
        }
        else if(gethref == '#disp_fa_monitoring_tab')
        {
            if( $(''+gethref+'').hasClass('active'))
            {
                console.log('do nothing');
                which_is_active = 'dash_fa';

            }
            else if(dash_fa_bool)
            {
                console.log('already loaded');
                which_is_active = 'dash_fa';
            }
            else if(dash_fa_bool == false)
            {
                dash_fa_bool = true;
                which_is_active = 'dash_fa';
                faTablesCi();
            }
        }
    });



});

$('#table-ci-process-accounts').on('click','#btn_select_account_new',function() {

    if($(this).html() == 'Select')
    {
        var get_id = $(this).attr('name');
        var get_details = $(this).attr('value');

        $('#table_selected_account_new_list tbody').append(
            '<tr class = "where_remove_tr" value = "'+get_id+'">'+
            '<td class = "id_to_fund_request" value = "'+get_id+'">'+get_id+'</td>' +
            '<td>'+get_details+'</td>' +
            '<td> <a class="btn_remove_new_class btn btn-block btn-danger" name="'+get_id+'" id="btn_remove_account_new">Remove</a></td>' +
            '</tr>');

        $(this).html('Un-select');

    }
    else
    {
        var get_id = $(this).attr('name');

        $('.where_remove_tr').each(function () {

            if($(this).attr('value') == get_id)
            {
                $(this).remove();
            }

        });

        $(this).html('Select');
    }
});

$('#table_selected_account_new_list').on('click','#btn_remove_account_new',function () {

    var remove_id = $(this).attr('name');

    $('.btn_select_new_class').each(function () {

        if($(this).attr('name') == remove_id)
        {
            $(this).html('Select');
        }
    });

    $(this).parents("tr").remove();

});

var click_select_all = false;

$('#btn_select_all').click(function () {

    if(click_select_all == false)
    {
        select_all();
        click_select_all = true;
    }
    else
    {
        deselect_all();
        // countpending = 0;
        click_select_all = false;
    }

});

function select_all() {
    tablecifundrequest.rows().select();
    var select_ids = $.map(tablecifundrequest.rows('.selected').data(), function (item) {
        return item
    });
}

function deselect_all() {
    tablecifundrequest.rows().deselect();

    // tableReport.rows().deselect();
    // tablecifundrequest.ajax.reload(null, false);
}

$('#btnDispatch').click(function (event)
{
    var accountID = acctID;
    var accountName = $('#accountName').val();
    var ciID = parseInt($('#ciID_dispatch').val());
    var ciName = $('#ciID_dispatch').children('option:selected').text();
    var date = $('#DateDue').val();
    var time = $('#TimeDue').val();
    var aim = 'citransfer';

    if(date == '')
    {
        alert('Please fill up Date Due.');
    }
    else if(ciID == 0)
    {
        alert('Please Select C.I.');
    }
    else
    {
        $('#toOverlayDisp').addClass('overlay').html('<i class="fa fa-refresh fa-spin"></i>');
        $.ajax
        ({
            url : 'ci-dispatch',
            type : 'post',
            data : {
                'accountID': accountID,
                'accountName': accountName,
                'ciID': ciID,
                'ciName': ciName,
                'date_due': date,
                'time_due': time,
                'aim': aim
                // '_token':$('input[name=_token]').val()
            },
            beforeSend: function () {
                $("#btnDispatch").attr("disabled", true);
            },
            success : function (data)
            {
                if(data.errorDispatch==500)
                {
                    alert('This Account is Already Dispatched to another FCI');
                    $('#toOverlayDisp').removeClass('overlay').html('');
                    table.ajax.reload(null, false);
                }
                else if(data.errorDispatch==600)
                {
                    alert('This Account were been Hold or Cancel');
                    $('#toOverlayDisp').removeClass('overlay').html('');
                    table.ajax.reload(null, false);
                }
                else
                {
                    $('#toOverlayDisp').removeClass('overlay').html('');
                    $('#accountID').val('');
                    $('#dispatch_modal').modal('hide');
                    alert('Account Successfully Dispatched to C.I');
                    table.ajax.reload(null, false);
                }
                // table.ajax.reload(null, false);



            },
            error : function (e) {
                console.log(e);
                table.ajax.reload(null, false);
            },
            complete: function () {
                $("#btnDispatch").attr("disabled", false);

            }
        });
    }



});

$('#endorsement-table').on('click', '#btnOtherInfo', function (e)
{
    var acctID = $(this).attr("href");
    $('#otherInfoSpan').html('');
    $('#otherEmployerSpan').html('');
    $('#otherBusinessSpan').html('');
    $('#otherPersonalSpan').html('');

    $.ajax({
        url: '/dispatcher-get-other-info',
        type: 'GET',
        data:
            {
                'acctID': acctID
            },
        success: function (data)
        {
            console.log(data);

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


                if(data[0].length===0)
                {
                    $('#otherInfoSpan').hide();
                }
                else
                {
                    $('#otherInfoSpan').show();
                }

            }
        }
    })
});

$('#endorsement-table').on('click','#btnNoteView', function ()
{
    $('#txtAreaNote').html('');
    $('#btnSaveNote').hide();
    $('#btnUpdateNote').show();
    acctID = '';
    acctID = $(this).attr("href");

    $.ajax
    ({
        method: 'get',
        url: 'client-get-note',
        data:
            {
                'acctID': acctID
            },
        success: function (data)
        {
            $('#txtNote').html('');
            $('#txtAreaNote').append
            (
                '                                    <div class="form-group">\n' +
                '                                        <label>Note</label>\n' +
                '                                        <textarea class="form-control" rows="3" placeholder="Enter ..." id="txtNote" disabled>'+data[0].endorsement_note+'</textarea>\n' +
                '                                    </div>'
            )
        }
    });
});

function refAllTbl()
{
    table.ajax.reload(null, false);
    tableFundRequest.ajax.reload(null, false);
    tableFundSuccess.ajax.reload(null, false);
    tableFundDisapproved.ajax.reload(null, false);
    tableFundCancelled.ajax.reload(null, false);
    // tableFundChecker.ajax.reload(null, false);
}


$('#shell_req').click(function () {

    $('#txtFundAmount_label').removeAttr('hidden');

});

$('#normal_req').click(function () {

    $('#txtFundAmount_label').attr('hidden','hidden');

});

$('#btnReqFund').on('click',function (e)
{
    naanona = false;
    var checkids = [];

    // var checkids = $.map(tablecifundrequest.rows('.selected').data(),function (item) {
    //     return item.id
    // });

    $('.id_to_fund_request').each(function () {
        checkids.push($(this).attr('value'));
    });

    if(checkids.length == 0)
    {
        alert('Please select Accounts for fund request.')
    }
    else
    {
        // console.log(checkids);
        // var type_fund = 'normal request';

        // if($('#normal_req').is(':checked'))
        // {
        //     type_fund = 'normal request';

        if($('#txtFundAmount').val()<=0)
        {
            alert('Fund Amount Request must be greater than 0');
        }
        else if(countpending <= 0)
        {
            alert('No accounts to request for fund.');
        }
        else
        {
            console.log(checkids);
            send_req(checkids);
        }
        // }
        // else if($('#shell_req').is(':checked'))
        // {
        //     type_fund = 'Shell Card Request';

        // if(countpending <= 0)
        // {
        //     alert('No accounts to request for fund.');
        // }
        // else
        // {
        //     send_req(checkids,type_fund);
        // }
        // }

    }
});
// function send_req(checkids,type_fund)
function send_req(checkids)
{
    $('#modal-fund-request-sending').modal('show');
    var formData = new FormData();
    console.log('before send: '+$('#selFciName').val());
    formData.append('selFciName',$('#selFciName').val());
    formData.append('selSaoName',$('#selSaoName').val());
    formData.append('txtFundAmount',$('#txtFundAmount').val());
    formData.append('txtFundRemarks',$('#txtFundRemarks').val());
    formData.append('id_array',checkids);
    // formData.append('type_of_fund_req',type_fund);

    $.ajax
    ({
        method: 'post',
        url: 'dispatcher-send-request-fund',
        data: formData,
        processData: false,
        traditional: true,
        contentType: false,
        success: function (data)
        {
            console.log(data);
            if(data=='success')
            {
                // alert('successfully requested fund');
                tableFundRequest.ajax.reload(null,false);
                // tableFundSuccess.ajax.reload(null,false);
                // tableFundDisapproved.ajax.reload(null,false);
                // tableFundCancelled.ajax.reload(null,false);
                // tableFundChecker.ajax.reload(null,false);
                tablecifundrequest.ajax.reload(null,false);
                $('#txtFundAmount').val(0);
                $('#txtFundRemarks').val('');
                getpending_and_onhand_fund($('#selFciName').val());
                countpending = 0;
                // $('#span_count').html('Pending Accounts w/o Fund Request: '+countpending);
                // refAllTbl();
                setTimeout(function () {
                    $('#modal-fund-request-sending').modal('hide');
                    setTimeout(function () {
                        $('#modal-fund-request-success').modal('show');
                        setTimeout(function () {
                            $('#modal-fund-request-success').modal('hide');
                        },2000);
                    },1000);
                },2000);

                table_fund_logs_disp.ajax.reload(null, false);
                $('#table_selected_account_new_list tbody tr').remove();
            }
            else if(data=='error')
            {
                setTimeout(function () {
                    $('#modal-fund-request-sending').modal('hide');
                    setTimeout(function () {
                        $('#modal-fund-request-limit').modal('show');
                        setTimeout(function () {
                            $('#modal-fund-request-limit').modal('hide');
                        },3000);
                    },1000);
                },2000);
            }
            else if(data == 'limit')
            {
                setTimeout(function () {
                    $('#modal-fund-request-sending').modal('hide');
                    setTimeout(function () {
                        $('#modal-fund-request-limit-2').modal('show');
                        setTimeout(function () {
                            $('#modal-fund-request-limit-2').modal('hide');
                        },3000);
                    },1000);
                },2000);
            }
            else if(data == 'exc')
            {
                setTimeout(function () {
                    $('#modal-fund-request-sending').modal('hide');
                    setTimeout(function () {
                        $('#modal-fund-request-limit-3').modal('show');
                        setTimeout(function () {
                            $('#modal-fund-request-limit-3').modal('hide');
                        },3000);
                    },1000);
                },2000);
            }
        },
        error: function () {
            $('#modal-fund-request-sending').modal('hide');
            setTimeout(function () {
                $('#modal-fund-request-fail').modal('show');
                setTimeout(function () {
                    $('#modal-fund-request-fail').modal('hide');
                },5000);
            },1000);
        }
    });
}


$('#table-advance-fund-request').on('click','#btnCancelFund', function ()
{
    $('#modal-fund-request-cancelling').modal('show');
    var fundReqId = $(this).attr('value');
    var fundHash = btoa(fundReqId);

    $.ajax
    ({
        method: 'post',
        url: 'dispatcher-cancel-fund',
        data:
            {
                'fundHash': fundHash
            },
        success: function (data)
        {
            if(data=='success')
            {
                // alert('Fund Successfuly Cancelled!');
                tablecifundrequest.ajax.reload(null,false);
                tableFundRequest.ajax.reload(null,false);
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
        }
    });
});


function getpending_and_onhand_fund(id) {

    if (id != '---')
    {
        $.ajax(
            {
                url : 'dispatcher_get_real_time_and_pending',
                type : 'get',
                data : {
                    'id' : id
                },
                success: function (data)
                {
                    console.log(data);

                    var getpending = 0;
                    var checkpending = 0;
                    var shellcheck = '';
                    var showBanks = '';
                    var ctrBank;
                    var checkArray = [];


                    for(var ctr = 0; ctr<data[0].length; ctr++)
                    {
                        getpending = (getpending + parseInt(atob(data[0][ctr].fund_amount)));

                    }
                    for(var i = 0; i<data[2].length; i++)
                    {
                        // console.log('check: '+data[2][i].amount+data[2][i].amount_atm);
                        if(data[2][i].amount_atm == null)
                        {
                            checkpending = (checkpending + parseInt(atob(data[2][i].amount)));

                        }
                        else if(data[2][i].amount == null)
                        {
                            checkpending = (checkpending + parseInt(data[2][i].amount_atm));
                        }
                    }

                    if(data[0].length < 1 && data[2].length <1)
                    {
                        getpending = 'No Pending Fund.';
                    }
                    else
                    {
                        getpending = getpending+checkpending;
                    }
                    var onhand = '';
                    if(data[1].length < 1)
                    {
                        onhand = 'No On hand Fund.';
                    }
                    else
                    {
                        onhand = data[1][0].fund_realtime;
                    }

                    if(data[4] >= 1)
                    {
                        shellcheck = '*Shell card/ Gas Limit : '+data[5][0].limit;
                        // $('#checkifShellCi').show();
                        $('#btnReqFund').hide();
                        $('#btnCantShell').show();
                        $('#selSaoName').attr('disabled', true);
                        $('#txtFundAmount').attr('disabled', true);
                        $('#txtFundRemarks').attr('disabled', true);
                    }
                    else
                    {
                        shellcheck = '*No Shell Card';
                        // $('#checkifShellCi').hide();
                        $('#btnReqFund').show();
                        $('#btnCantShell').hide();
                        $('#selSaoName').attr('disabled', false);
                        $('#txtFundAmount').attr('disabled', false);
                        $('#txtFundRemarks').attr('disabled', false);

                    }
                    var uniqueNames = [];
                    var k;

                    if(data[6] != '')
                    {
                        for(ctrBank = 0; ctrBank < data[6].length; ctrBank++)
                        {

                            checkArray.push(data[6][ctrBank].bank_name)
                        }

                        $.each(checkArray, function(i, el){
                            if($.inArray(el, uniqueNames) === -1) uniqueNames.push(el);
                        });

                        for(k = 0; k < uniqueNames.length; k++)
                        {
                            showBanks += '<br>-' + uniqueNames[k];
                        }
                    }
                    else
                    {
                        showBanks = 'No Bank Assigned';
                    }
                    $('#ci-endorsements-table-span').html('<b>FCI name :</b> <h2>'+data[3]+'</h2><br> <b>'+ shellcheck + '</b><br><br><b>*List of Bank/s </b><br> '+showBanks+' <br><br> <b>Total Pending Fund : '+getpending+'<br>On Hand Fund : '+onhand+'</b>');
                    // $('#btn_select_all').show();
                }
            }
        );
    }
    else
    {
        $('#ci-endorsements-table-span').html('PLEASE SELECT C.I');
        $('#span_count').html('');
        $('#btn_select_all').hide();
    }
}

$('#selFciName').change(function ()
{
    naanona = false;
    countpending = 0;
    // $('#span_count').html('Pending Accounts w/o Fund Request: '+countpending + '<br>');
    // console.log('rigger');
    tablecifundrequest.draw();
    var id = $(this).val();
    console.log('ID----------:'+id);
    getpending_and_onhand_fund(id);
    $('#table_selected_account_new_list tbody tr').remove();
});

// EXTRACTING ID FOR DISPATCHING

$('#endorsement-table').on('click', '#btnView', function (e)
{
    var tr = $(this).closest('tr');
    acctID = $(this).attr("href");
    dateEndorsed = $(this).attr('value');
    timeEndorsed = $(this).attr("name");

    console.log(dateEndorsed);

    $('#DateDue').val(dateEndorsed);
    var gettimsplit = timeEndorsed.split(":");
    var getimeint = parseInt(gettimsplit[0])+3;

    if(getimeint >= 10)
    {
        if(getimeint > 12)
        {
            getimeint -= 12;
            $('#TimeDue').val(getimeint+':'+gettimsplit[1]+' PM');
        }
        else
        {
            $('#TimeDue').val(getimeint+':'+gettimsplit[1]+' AM');
        }
    }
    else {
        $('#TimeDue').val(getimeint+':'+gettimsplit[1]+' AM');
    }

    var accountName = tr.children('td:eq(6)').text();

    $('#accountName').val(accountName);

    $('#accountInformation').html('');
    $('#subjComaker').html('');
    $('#evrInfo').html('');
    $('#bvrInfo').html('');

    $.ajax({
        url: '/dispatcher-get-other-info',
        type: 'GET',
        data:
            {
                'acctID': acctID
            },
        success: function (data)
        {
            console.log(data);

            if(data[3][0].note != null)
            {
                $('#dispatch_additional_client_note').val(data[3][0].note);
                $('#additional_note_from_client').show();
            }
            else {
                $('#dispatch_additional_client_note').val('');
                $('#additional_note_from_client').hide();

            }

            if(data.length === 0)
            {
                console.log('data empty');
            }
            else
            {

                // $('#DateDue').val(data[4][0].date_due);
                // $('#TimeDue').val(data[4][0].time_due);

                $('#accountInformation').append
                (
                    '<dl>\n' +
                    '            <dt>Account Name:</dt>\n' +
                    '            <dd>'+data[3][0].account_name+'</dd>\n' +
                    '\n' +
                    '            <dt>Address:</dt>\n' +
                    '            <dd>'+data[3][0].address+' '+data[3][0].muni_name.toUpperCase()+' '+data[3][0].provinces+'</dd>\n' +
                    '\n' +
                    '            <dt>Type of Request:</dt>\n' +
                    '            <dd>'+data[3][0].type_of_request+'</dd>\n' +
                    '</dl>'
                );

                if(data[0].length===0)
                {
                    // $('#subjComaker').append
                    // (
                    //     '            <center><h4>No Co-Maker Declared</h4></center>'
                    // )
                }
                else
                {
                    for (ctrr = 0; ctrr <= (data[0].length) - 1; ctrr++)
                    {
                        $('#subjComaker').append
                        (
                            '            <dl>' +
                            '            <dt>Co-Maker:</dt>' +
                            '            <dd>' + data[0][ctrr].coborrower_name + '</dd>'+
                            '            <dt>Address:</dt>' +
                            '            <dd>'+data[0][ctrr].coborrower_address+' '+data[0][ctrr].coborrower_municipality+' '+data[0][ctrr].coborrower_province+'</dd>'+
                            '            </dl>'
                        )
                    }
                }

                if(data[2].length===0)
                {
                    for (ctrr = 0; ctrr <= (data[1].length) - 1; ctrr++)
                    {
                        $('#evrInfo').append
                        (
                            '            <dl>' +
                            '            <dt>Employer Name:</dt>' +
                            '            <dd>' + data[1][ctrr].employer_name + '</dd>'+
                            '            <dt>Address:</dt>' +
                            '            <dd>'+data[3][0].address+' '+data[3][0].muni_name.toUpperCase()+' '+data[3][0].provinces+'</dd>\n' +
                            '            </dl>'
                        )
                    }
                }
                else if(data[1].length===0)
                {
                    for (ctrr = 0; ctrr <= (data[2].length) - 1; ctrr++)
                    {
                        $('#bvrInfo').append
                        (
                            '            <dl>' +
                            '            <dt>Business Name:</dt>' +
                            '            <dd>' + data[2][ctrr].business_name + '</dd>'+
                            '            <dt>Address:</dt>' +
                            '            <dd>'+data[3][0].address+' '+data[3][0].muni_name.toUpperCase()+' '+data[3][0].provinces+'</dd>\n' +
                            '            </dl>'
                        )
                    }
                }
                else
                {
                    $('#evrInfo').append
                    (
                        '            <center><h4>No Employer/Business Info Available</h4></center>'
                    )
                }
            }
        }
    })

});
//End
$('#endorsement-table').on('click', '#btnFullViewInfo', function (e)
{
    acctID = '';
    acctID = $(this).attr("href");
    $('#spanhere').html('');
    $('#history').html('');
    $('#otherInfoSpan').html('');
    $('#otherEmployerSpan').html('');
    $('#otherBusinessSpan').html('');

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

function fundLogTrack()
{

    table_fund_logs_disp = $('#fund-request-general-dispatcher-table').DataTable
    ({
        "processing": true,
        "serverSide": true,
        "responsive": true,
        "ajax": 'dispatcher-fund-general-logs',
        "columns":
            [
                {data : 'id' , name : 'fund_requests.id'},
                {data : 'date_time', name : 'fund_requests.dispatcher_request_date'},
                // {
                //     data : function app(data)
                //     {
                //         if(data.sao_app == '0000-00-00 00:00:00')
                //         {
                //             return '';
                //         }
                //         else
                //         {
                //             return data.sao_app;
                //         }
                //     },
                //     name : 'fund_requests.sao_approved_date'
                // },
                // {data : 'sent', name : 'fund_requests.delivered_date'},
                {data : 'ci', name : 'users.name'},
                {
                    data : function amount(data)
                    {
                        if(data.orig == null)
                        {
                            return '';
                        }
                        else
                        {
                            return '₱ ' + atob(data.orig);
                        }
                    },
                    'name' : 'users.name',
                    'searchable' : false
                },
                {
                    data : function amount(data)
                    {
                        if(data.disp == 'CANCELLED')
                        {
                            return '';
                        }
                        if(data.sao_stat == 'APPROVED')
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
                        else if(data.sao_stat == '')
                        {
                            return '';
                        }
                        else
                        {
                            return '';
                        }

                    },
                    'name' : 'users.name',
                    'searchable' : false
                },
                {
                    data : function status(data)
                    {
                        var b = '';

                        if(data.finance == 'CANCELLED')
                        {
                            b = 'Fund Cancelled by Finance';
                        }
                        else
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
                                else if(data.shc == 'Override')
                                {
                                    b = 'Fund Override by SAO';
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
                                else if(data.shc == 'Override')
                                {
                                    b = 'Fund Override by SAO';
                                }
                            }
                            else if(data.apd == 'Pending')
                            {
                                if(data.disp == 'CANCELLED')
                                {
                                    b = 'Fund Request Cancelled by Dispatcher';
                                }
                                else
                                {
                                    b = 'Fund Sending on Process by Finance'
                                }
                            }
                            else if(data.apd == '')
                            {
                                if(data.disp == 'CANCELLED')
                                {
                                    b = 'Fund Request Cancelled by Dispatcher';
                                }
                                else if(data.disp == 'DISAPPROVED')
                                {
                                    b = 'Fund Disapproved by SAO';
                                }
                                else if(data.disp == 'ON-PROCESS')
                                {
                                    if(data.sao == 0)
                                    {
                                        if(parseInt(atob(data.orig)) >= 2500)
                                        {
                                            b = 'Fund for Approval from Management';
                                        }
                                        else if(parseInt(atob(data.orig)) < 2500)
                                        {
                                            b = 'Fund for Approval from SAO';
                                        }
                                    }
                                    else if(data.sao != 0)
                                    {
                                        b = 'Fund Sending on Process by Finance';
                                    }
                                }
                            }
                        }


                        return b;


                    },
                    'name' : 'users.name',
                    'searchable' : false
                },
                {
                    data : function(data)
                    {
                        var name = '';
                        var approved = '';
                        var upload = '';

                        // console.log()

                        if(data.tor == 'EMERGENCY FUND')
                        {

                            if(data.manage_name != null)
                            {
                                name = data.manage_name;
                            }
                            else
                            {
                                name = 'NO APPROVER YET'
                            }

                            if(data.manage_date != '0000-00-00 00:00:00')
                            {
                                approved = data.manage_date;
                            }
                            else if(data.manage_date == '0000-00-00 00:00:00')
                            {
                                approved = 'NOT YET APPROVED';
                            }
                        }
                        else if(data.tor == 'NORMAL REQUEST')
                        {
                            if(data.sao_name != null)
                            {
                                name = data.sao_name;
                            }
                            else
                            {
                                name = 'NO APPROVER YET'
                            }

                            if(data.sao_app != '0000-00-00 00:00:00')
                            {
                                approved = data.sao_app;
                            }
                            else if(data.sao_app == '0000-00-00 00:00:00')
                            {
                                approved = 'NOT YET APPROVED';
                            }
                        }

                        if(data.sent != '0000-00-00 00:00:00')
                        {
                            upload = data.sent;
                        }
                        else if(data.sent == '0000-00-00 00:00:00')
                        {
                            upload = 'NOT YET UPLOADED';
                        }

                        return '<button class = "btnShowSaoApprover btn btn-block btn-xs btn-primary" style = "width : 100%" name = "'+name+'|'+approved+'|'+upload+'">Show Approval Details</button>'
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

            $('#fund-request-general-dispatcher-table thead th').each(function()
            {
                $(this).unbind();
                table_logs_thead[logsCountFund] = $(this).text();
                logsCountFund++;
                title = $(this).text();
                $(this).html(title);
            });


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

    $('#fund-request-general-dispatcher-table_filter input').unbind();
    $('#fund-request-general-dispatcher-table_filter input').bind('keyup change', function (e)
    {
        if ($(this).is(':focus'))
        {
            if (e.keyCode == 13)
            {
                table_fund_logs_disp.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '')
                {
                    table_fund_logs_disp.search($(this).val()).draw();
                }
            }
        }
    });
}

$('#ci_to_text').change(function()
{
    var ci_to_text_id = $(this).children('option:selected').val();
    $('#ci_num_to_text').val('');

    $.ajax({
        type : 'get',
        url : 'dispatcher_get_ci_contact_number_to_text',
        data : {
            'ci_id' : ci_to_text_id
        },
        success : function(data)
        {

            if(data != '')
            {
                $('#ci_num_to_text').val(data[0][0].contact_number);
            }
            else
            {
                alert('No Contact Number Record Found');
                $('#ci_num_to_text').attr('disabled', false);
            }
        },
        error : function(error)
        {
            console.log(error);
        }
    });
});

$('#edit_ci_num_val').click(function()
{
    $(this).hide();
    $('#ci_num_to_text').attr('disabled', false);
    $('#edit_ci_num_save').show();
    $('#edit_ci_num_cancel').show();
});

$('#edit_ci_num_cancel').click(function ()
{
    var $this = $(this);

    $this.hide();
    $('#ci_num_to_text').attr('disabled', true);
    $('#edit_ci_num_save').hide();
    $('#edit_ci_num_val').show();
});

$('#dispatcher_mess_to_ci').on('keypress change keyup focus', function(e)
{
    var val = $(this).val();
    var message = val.length;
    var creditCount = 0;
    // console.log(val.length)
    $('#charCount').text(val.length);

    if(e.keyCode === 8)
    {
        if(val.length === 0)
        {

        }
        else
        {
            $('#charCount').text(val.length - 1);
        }
    }

    creditCount = val.length/150;

    var check_deci = creditCount.toString().split('.');

    if(check_deci.length > 0)
    {
        creditCount = creditCount + 1
    }

    if(val.length == 0)
    {
        $('#creditCount').text(0);
    }
    else
    {
        $('#creditCount').text(creditCount.toString()[0]);
    }
});

$('#send_message_to_ci').click(function()
{
    var btn = $(this);
    var itextna = false;
    var ci_to_text_id = $('#ci_to_text').children('option:selected').val();
    var ci_to_text_name = $('#ci_to_text').children('option:selected').text();
    var to_text = $('#ci_num_to_text').val();
    var message = $('#dispatcher_mess_to_ci').val();
    var char_count = $('#charCount').text();
    var credits_count = $('#creditCount').text();

    $('.inputValidataionText').each(function()
    {
        if($(this).val() == '')
        {
            alert('Fill all the required fields');
            itextna = false;
            return false;
        }
        itextna = true;
    });

    if(itextna)
    {
        if(confirm('Are you sure to send message to ' + ci_to_text_name+ ' ('+to_text+')?'))
        {
            btn.attr('disabled', true);
            $.ajax({
                type : 'get',
                url : 'dispatcher_send_message_to_ci',
                data : {
                    'ci_to_text_id' : ci_to_text_id,
                    'contact_number' : to_text,
                    'message' : message,
                    'char_count' : char_count,
                    'credits_count' : credits_count
                },
                beforeSend : function(){
                    $('#modal-sending-message-loading').modal({backdrop: 'static'});
                },
                success : function(data) {
                    console.log(data);
                    if(data[1][0] == '0')
                    {
                        alert('Message Successfully Sent');
                        $('#dispatcher_mess_to_ci').val('');
                        if(dispatcher_sms_logs_table_bool)
                        {
                            dispatcher_sms_logs_table.draw();
                        }
                    }
                    else if(data == 'role_error')
                    {
                        alert('Error Time-out Please refresh the page and login again.');
                        $('#modal-sending-message-loading').modal('hide');
                    }
                    else
                    {
                        alert('Message Failed to Send');
                    }
                    btn.attr('disabled', false);
                },
                error : function(e) {
                    console.log(e);
                    $('#modal-sending-message-loading').modal('hide');
                },
                complete: function()
                {
                    $('#modal-sending-message-loading').modal('hide');
                }
            });
        }
    }
});

var dispatcher_sms_logs_table;
var dispatcher_sms_logs_table_bool = false;
function getMessagesLogs()
{
    dispatcher_sms_logs_table = $('#dispatcher_sms_logs').DataTable
    ({
        "responsive" : true,
        "processing" : true,
        "serverSide" : true,
        "ajax" : 'dispatcher_get_messages_logs',
        "columns":
            [
                {data: 'id', name: 'dispatcher_text_logs.id', orderable : false, width : '5%'},
                {data: 'credit', name: 'dispatcher_text_logs.credit_count', orderable : false, width : '5%', visible : false},
                {data: 'sender', name: 'sender.name', orderable : false },
                {
                    data:function ci_name(data)
                    {
                        var ci_name = data.ci_name;

                        if(ci_name == null)
                        {
                            ci_name = 'Unknown';
                        }

                        return ci_name + ' / ' + data.contact_number + '/ Credit Used: '+ data.credit;
                    },
                    'name' : 'ci_name.name',
                    searchable : true,
                    orderable : false
                },
                {data: 'message', name: 'dispatcher_text_logs.message_sent', orderable : false },
                {data: 'date_time', name: 'dispatcher_text_logs.created_at', orderable : false },
                {
                    data: function action(data)
                    {
                        if(data.status == 'Failed')
                        {
                            return '<button class="btn btn-success btn_resend_mess" id="'+btoa(data.id)+'">RE-SEND <i class="glyphicon glyphicon-send"></i></button>';
                        }
                        else
                        {
                            return '<button class="btn btn-success" disabled>RE-SEND <i class="glyphicon glyphicon-send"></i></button>';
                        }
                    },
                    name: 'dispatcher_text_logs.id',
                    searchable : false,
                    orderable : false
                }
            ],
        "pageLength" : 10,
        "lengthMenu" : [[2, 10, 25, 50, -1], ['2 rows', '10 rows', '25 rows', '50 rows', 'Show all']],
        "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull)
        {
            if(aData.status == 'Failed')
            {
                $('td', nRow).css('background-color', '#ffb3b3');
            }
            else if(aData.status == 'Success')
            {
                $('td', nRow).css('background-color', '#b3ffb3');
            }

        },
        initComplete: function()
        {
            $('#dispatcher_sms_logs thead th').each(function() {
                $(this).unbind();
                var title = $(this).text();
                $(this).html(title+'<br><input type="text" placeholder="Search" style="position: relative; width: 100%">');
            });
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
                    }
                });
            });
        }
    });

    $('#dispatcher_sms_logs_filter input').unbind();
    $('#dispatcher_sms_logs_filter input').bind('keyup change', function(e)
    {
        if($(this).is(':focus'))
        {
            if (e.keyCode === 13) {
                dispatcher_sms_logs_table.search($(this).val()).draw();
            }
        }
    });
}

$('.send_message_tabs').click(function()
{
    var gethref = $(this).attr('href');

    if(gethref == '#send_messageTab2')
    {
        if( $(''+gethref+'').hasClass('active'))
        {
            console.log('do nothing');

        }
        else if(dispatcher_sms_logs_table_bool)
        {
            console.log('already loaded');
        }
        else if(dispatcher_sms_logs_table_bool == false)
        {
            dispatcher_sms_logs_table_bool = true;
            getMessagesLogs();
        }
    }
});

$('#dispatcher_sms_logs').on('click', '.btn_resend_mess', function()
{
    var id = atob($(this).attr('id'));

    if(confirm('Are you sure to re-send this message?'))
    {
        $.ajax({
            type: 'get',
            url: 'dispatcher_resend_failed_message',
            data: {
                'id' : id
            },
            success : function(data)
            {
                $('.send_message_tabs').each(function()
                {
                    if($(this).attr('href') == '#send_messageTab1')
                    {
                        $(this).click();
                    }
                });
                $('#ci_num_to_text').val(data[0].number);
                $('#dispatcher_mess_to_ci').val(data[0].message);
                $('#charCount').html(data[0].char);
                $('#creditCount').html(data[0].cred);
                // console.log(data);
            }
        })
    }
});

$('#triggreDirectText').click(function ()
{
    $('#ci_num_to_text').attr('disabled', true);
    $('#edit_ci_num_save').hide();
    $('#edit_ci_num_cancel').hide();
    $('#edit_ci_num_val').show();
});

$('#edit_ci_num_save').click(function()
{
    var ci_id = $('#ci_to_text').children('option:selected').val();
    var number_to_save = $('#ci_num_to_text').val();
    var checkerBool = false;

    $('.saving_class').each(function()
    {
        if($(this).val() != '')
        {
            checkerBool = true;
        }
        else
        {
            checkerBool = false;
            alert('Fill-up the required fields');
            return false;
        }
    });

    if(checkerBool)
    {
        if(confirm('Are you sure to update the number of the current selected C.I ?'))
        {
            $.ajax({
                type : 'get',
                url : 'dispatcher_update_ci_contact_number',
                data : {
                    'ci_id' : ci_id,
                    'number_to_save' : number_to_save
                },
                success : function (data)
                {
                    if(data == 'already')
                    {
                        alert('Number is already registered');
                    }
                    else
                    {
                        alert('Number successfully saved');
                        $('#edit_ci_num_save').hide();
                        $('#edit_ci_num_cancel').hide();
                        $('#edit_ci_num_val').show();
                        $('#ci_num_to_text').attr('disabled', true);
                    }
                }
            })
        }
    }
});

$('#fund-request-general-dispatcher-table').on('click', '.btnShowSaoApprover', function()
{
    $('#approver_name_fr').html('');
    $('#approver_date_fr').html('');
    $('#approver_date_fr').html('');

    var info = $(this).attr('name');

    var gen = info.split('|');

    $('#modal-show-approved-info').modal('show');

    $('#approver_name_fr').html(gen[0]);
    $('#approver_date_fr').html(gen[1]);
    $('#upload_date_fr').html(gen[2]);
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
                            return data.sao_date;
                        }
                    },
                    name: 'fund_requests.id'
                },
                {
                    data: function (data)
                    {
                        return "Php "+atob(data.amount)
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

$('#ci_expense_archi').change(function()
{
    tableFundFa.draw();
});