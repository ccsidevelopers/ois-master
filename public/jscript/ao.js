/**
 * Created by aa on 9/25/2017.
 */
var table;
var tableAoFinishReport;
var toastr;
var times;
var accountID;
var acctID;
var verAdd;
var acctName;
var getcert;
var recip_table;

var dash_ao = false;
var account_ao = true;
var search_acct = false;
var which_is_active = 'process_account';

var ano_active_sa_account_process = 'pending'


var click_tab2 = false;

var genArchitoMail = false;

$.ajaxSetup
({
    headers:
        {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
});

$(document).ready(function()
{

    $( "#datepicker" ).datepicker({ dateFormat: 'yy-mm-dd' });
    $( "#datepickermax" ).datepicker({ dateFormat: 'yy-mm-dd' });

    $( "#datepickerminFinish" ).datepicker({ dateFormat: 'yy-mm-dd' });
    $( "#datepickermaxFinish" ).datepicker({ dateFormat: 'yy-mm-dd' });

    // fetchOtherInro('ao-new-endorsement');
    // function fetchOtherInro(table) {
    //     times = setTimeout(function (){
    //
    //         var countid = 0;
    //         var getitds = [];
    //         var gettors = [];
    //         var tab = document.getElementById(table);
    //         var n = tab.rows.length;
    //         var i, tr, tdid, tdtor;
    //
    //         for (i = 1; i < n; i++) {
    //             tr = tab.rows[i];
    //             if (tr.cells.length > 0)
    //             {
    //                 tdid = tr.cells[0];
    //                 tdtor = tr.cells[6];
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
    //                 $('#otherinfo' + getitds[ctr].toString() + '').html('<b>PDRN</b>');
    //
    //             }
    //         }
    //
    //     },2000);
    // }




    var today = new Date();
    var yearmonth;
    var date;

    $('.date_range_conts').css('display','none');

    $('#min').val('1111-01-01');
    $('#max').val('1111-01-01');

    $('#minFinish').val('1111-01-01');
    $('#maxFinish').val('1111-01-01');


    // table.draw();
    // tableAoFinishReport.draw();

    $('.viewable').click(function () {
        if($(this).is(":checked"))
        {
            if($(this).val() == 'All')
            {
                $('.viewable#rad_all_fin').prop('checked',true);
                $('.viewable#rad_all_pends').prop('checked',true);

                $('.date_range_conts').css('display','none');

                $('#min').val('1111-01-01');
                $('#max').val('1111-01-01');

                $('#minFinish').val('1111-01-01');
                $('#maxFinish').val('1111-01-01');


                if(ano_active_sa_account_process == 'pending')
                {
                    table.draw();
                }
                else if(ano_active_sa_account_process == 'finish')
                {
                    tableAoFinishReport.draw();
                }

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

                $( "#datepicker" ).datepicker({ dateFormat: 'yy-mm-dd' });
                $( "#datepickermax" ).datepicker({ dateFormat: 'yy-mm-dd' });

                $( "#datepickerminFinish" ).datepicker({ dateFormat: 'yy-mm-dd' });
                $( "#datepickermaxFinish" ).datepicker({ dateFormat: 'yy-mm-dd' });

                $('#datepicker').val(month+dateyear);
                $('#datepickermax').val(month+dateyear);

                $('#datepickerminFinish').val(month+dateyear);
                $('#datepickermaxFinish').val(month+dateyear);

                $('#min').val(yearmonth+date);
                $('#max').val(yearmonth+date);

                $('#minFinish').val(yearmonth+date);
                $('#maxFinish').val(yearmonth+date);

                // table.draw();
                // tableAoFinishReport.draw();


            }
        }
    });

    //pending
    $('#datepicker').change( function() {
        var min = $.datepicker.formatDate('yy-mm-dd', $('#datepicker').datepicker('getDate'));
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

        table.draw();
    });

    $('#datepickermax').change( function() {

        var min = $.datepicker.formatDate('yy-mm-dd', $('#datepicker').datepicker('getDate'));
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

        table.draw();
    });

    //finish
    $('#datepickerminFinish').change( function() {

        var minFin = $.datepicker.formatDate('yy-mm-dd', $('#datepickerminFinish').datepicker('getDate'));
        console.log(minFin);
        $('#minFinish').val(minFin);
        var mixFin = $.datepicker.formatDate('yy-mm-dd', $('#datepickermaxFinish').datepicker('getDate'));
        console.log(mixFin);

        if(mixFin === '')
        {
            $('#maxFinish').val(yearmonth+date);

        }
        else {
            $('#maxFinish').val(mixFin);
        }

        tableAoFinishReport.draw();
    });

    $('#datepickermaxFinish').change( function() {

        var minFin = $.datepicker.formatDate('yy-mm-dd', $('#datepickerminFinish').datepicker('getDate'));
        console.log(minFin);
        $('#minFinish').val(minFin);
        var mixFin = $.datepicker.formatDate('yy-mm-dd', $('#datepickermaxFinish').datepicker('getDate'));
        console.log(mixFin);
        if(mixFin === '')
        {
            $('#maxFinish').val(yearmonth+date);

        }
        else {
            $('#maxFinish').val(mixFin);
        }

        tableAoFinishReport.draw();
    });


    $('.viewable#rad_all_fin').prop('checked',true);
    $('.viewable#rad_all_pends').prop('checked',true);



    pending_accounts();
    finish_accounts();

    // var publicChannel = pusher.subscribe('publicNotifTransferChannel');
    // publicChannel.bind('App\\Events\\TransferPusherEvent', function (data)
    // {
    //     setTimeout(function ()
    //     {
    //         table.ajax.reload(null, false);
    //         // tableAoFinishReport.ajax.reload(null, false);
    //
    //     },1000);
    // });
    //
    // var privateChannel = pusher.subscribe('privateChannel-'+$('#user-id').val());
    // privateChannel.bind('App\\Events\\DispatchPusherEvent', function(data)
    // {
    //     if(data.message == 'assign')
    //     {
    //         toastr["success"]("You have received new endorsement account, please check your inbox!", "SUCCESS!");
    //         toastr.options =
    //             {
    //                 "closeButton": true,
    //                 "debug": true,
    //                 "newestOnTop": true,
    //                 "progressBar": false,
    //                 "positionClass": "toast-top-right",
    //                 "preventDuplicates": false,
    //                 "showDuration": "300",
    //                 "hideDuration": "1000",
    //                 "timeOut": "5000",
    //                 "extendedTimeOut": "1000",
    //                 "showEasing": "swing",
    //                 "hideEasing": "linear",
    //                 "showMethod": "fadeIn",
    //                 "hideMethod": "fadeOut"
    //             };
    //
    //         setTimeout(function ()
    //         {
    //             table.ajax.reload(null, false);
    //             // tableAoFinishReport.ajax.reload(null, false);
    //
    //         },1000);
    //     }
    //     else if(data.message == 'transfer')
    //     {
    //         toastr["success"]("1 Account has been transferred!");
    //         toastr.options =
    //             {
    //                 "closeButton": true,
    //                 "debug": true,
    //                 "newestOnTop": true,
    //                 "progressBar": false,
    //                 "positionClass": "toast-top-right",
    //                 "preventDuplicates": false,
    //                 "showDuration": "300",
    //                 "hideDuration": "1000",
    //                 "timeOut": "5000",
    //                 "extendedTimeOut": "1000",
    //                 "showEasing": "swing",
    //                 "hideEasing": "linear",
    //                 "showMethod": "fadeIn",
    //                 "hideMethod": "fadeOut"
    //             };
    //
    //         setTimeout(function ()
    //         {
    //             table.ajax.reload(null, false);
    //             // tableAoFinishReport.ajax.reload(null, false);
    //
    //         },1000);
    //     }
    //
    // });


    $('.ao_a_class').click(function () {

        var gethref = $(this).attr('href');

        console.log(gethref);
        if(gethref == '#ao_dashboard_tab')
        {
            ano_active_sa_account_process = '';

            if( $(''+gethref+'').hasClass('active'))
            {
                console.log('do nothing');
                which_is_active = 'dash_active';

            }
            else if(dash_ao)
            {
                console.log('already loaded');
                which_is_active = 'dash_active';

            }
            else if(dash_ao == false)
            {
                dash_ao = true;
                which_is_active = 'dash_active';
                dash_map_init();

            }
        }
        else if(gethref == '#ao_process_tab')
        {

        }
        else if(gethref == '#ao_search_tab')
        {
            ano_active_sa_account_process = '';
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

    });

    $("#clicktab1").click(function () {

        ano_active_sa_account_process = 'pending';
        which_is_active = '';

    });

    $("#clicktab2").click(function () {

        ano_active_sa_account_process = 'finish';
        which_is_active = '';
        if(!click_tab2)
        {
            click_tab2 = true;
        }

    });

    $(window).focus(function () {

        console.log('focus');
        interval = true;
    });

    setInterval(function ()
    {

        if(interval)
        {

            if(ano_active_sa_account_process == 'pending')
            {

                table.ajax.reload(null, false);

            }
            else if(ano_active_sa_account_process == 'finish')
            {

                tableAoFinishReport.ajax.reload(null, false);

            }
            console.log('table loading');
        }
        else {
            console.log('no reload of table');
        }

    },60000);


    // recip_table = $('#recip_table').DataTable(
    //     {
    //         "processing": true,
    //         "serverSide": true,
    //         "searching": false,
    //         "paging": false,
    //
    //         "ajax":"/ao_get_recip_list_table",
    //         "columns":
    //             [
    //                 {data: 'name', name: 'name'},
    //                 {
    //                     data : function (data) {
    //                         return  '<button class="btn btn-xs btn-block btn-info" id="btn_recip_view_table" name="'+data.id+'">View</button>' +
    //                             '<button class="btn btn-xs btn-block btn-danger" id="btn_recip_delete" name="'+data.id+'">Delete</button>'
    //                     },
    //                     "orderable" : false
    //                 }
    //             ],
    //         "order": [[0, 'desc']],
    //         "bSortClasses": false,
    //         "deferRender": true
    //     });

});



var pending_table = [];
var pending_table_ctr = 0;
function pending_accounts()
{
    $('#ao-new-endorsement thead th').each(function() {
        var title = $(this).text();
        pending_table[pending_table_ctr] = title;
        pending_table_ctr++;
        $(this).html(title+'<br><input type="text" placeholder="Search" style="position: relative; width: 100%">');
    });

    table = $('#ao-new-endorsement').DataTable(
        {
            dom: 'Blfrtip',
            buttons:
                [
                    {
                        extend: 'excel',
                        title : 'Pending Accounts',
                        exportOptions:
                            {
                                format:
                                    {
                                        header: function (dt, idx) {
                                            return pending_table[(idx)];
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
                    }
                ],
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "ajax":
                {
                    url: "/ao-fetch-endorsement",
                    data: function (a)
                    {

                        a.min_date_endorsed = $('#min').val();
                        a.max_date_endorsed = $('#max').val();
                    }
                },
            "columns":
                [
                    {data: 'id', name: 'endorsements.id'},
                    {data: 'date_endorsed', name: 'endorsements.date_endorsed'},
                    {data: 'time_endorsed', name: 'endorsements.time_endorsed'},
                    // {data: 'date_due', name: 'endorsements.date_due'},
                    // {data: 'time_due', name: 'endorsements.time_due'},
                    {data: 'tat', name: 'endorsements.time_endorsed'},
                    {data: 'account_name', name: 'endorsements.account_name'},
                    {data: 'address', name: 'endorsements.address'},
                    {data: 'muni_name', name: 'municipalities.muni_name'},
                    // {
                    //
                    //     data: function actions(data) {
                    //
                    //         clearTimeout(times);
                    //         fetchOtherInro('ao-new-endorsement');
                    //         return '<span id="otherinfo'+data.id+'">'+data.type_of_request+'</span>';
                    //
                    //     },
                    //     'name' : 'endorsements.type_of_request'
                    // },
                    {data: 'provinces', name: 'endorsements.provinces'},
                    {data: 'type_of_request', name: 'endorsements.type_of_request'},
                    {data: 'client_remarks', name: 'endorsements.client_remarks'},
                    {data: 'requestor_name', name: 'endorsements.requestor_name'},
                    {data: 're_ci', name: 'endorsements.re_ci'},
                    {
                        data: function actions(data)
                        {
                            var nonotes = '';

                            if(data.nononote==null)
                            {
                                nonotes +='<a href="'+ data.id + '" class="btn btn-xs btn-default btn-block" id="btnView" data-toggle="modal"><i class="glyphicon glyphicon-envelope"></i> No Client Note</a>';
                            }
                            else
                            {
                                nonotes += '<a href="'+ data.id + '" class="btn btn-xs btn-warning btn-block" id="btnNoteView" data-toggle="modal" data-target="#modal-dispatcher-view-notee"><i class="glyphicon glyphicon-envelope"></i> View Client Note</a>';
                            }

                            if(data.acct_status == 1)
                            {
                                return '<a class="btn btn-xs btn-block btn-danger" data-toggle="modal" data-target="#dispatch_modal"><i class="glyphicon glyphicon-warning-sign"></i> ON FIELD</a>' +
                                    ' <a class="btn btn-xs btn-block btn-info" disabled><i class="glyphicon glyphicon-time"></i> WAITING..</a>' +
                                    ' <a href="'+data.id+'"  class="btn btn-xs btn-block btn-warning" name="'+data.account_name+'" id="btnViewFullInfo" data-toggle="modal" data-target="#modal-view-info"><i class="glyphicon glyphicon-film"></i> VIEW ACCOUNT</a>' +
                                    ' <a href="'+data.id+'" class="btn btn-xs btn-block btn-success" name="'+data.account_name+'" id="btnViewReport" data-toggle="modal" data-target="#modal-view-report"><i class="glyphicon glyphicon-envelope"></i> C.I NOTE</a>'+
                                    nonotes;
                            }
                            else if(data.acct_status == 2)
                            {
                                if(data.type_of_sending_report=='' && data.ci_cert=='NC' || data.type_of_sending_report==null && data.ci_cert=='NC')
                                {
                                    return '<a class="btn btn-xs btn-block btn-primary" name = "'+data.id+':'+data.account_name+'" id="btnDownloadFile" data-toggle="modal" data-target="#dispatch_modal"><i class="glyphicon glyphicon-cloud-download"></i> DOWNLOAD FILES</a>' +
                                        ' <a href="'+data.id+'" class="btn btn-xs btn-block btn-info" name = "'+data.id+':'+data.account_name+'" id="btnShowInfo" data-toggle="modal" data-target="#modal-update-info"><i class="glyphicon glyphicon-pencil"></i> UPDATE INFO &<br><i class="glyphicon glyphicon-envelope"></i> ATTACH REPORT</a>'+
                                        ' <a href="'+data.id+'"  class="btn btn-xs btn-block btn-warning" name="'+data.account_name+'" id="btnViewFullInfo" data-toggle="modal" data-target="#modal-view-info"><i class="glyphicon glyphicon-film"></i> VIEW ACCOUNT</a>' +
                                        ' <a href="'+data.id+'" class="btn btn-xs btn-block btn-success" name="'+data.account_name+'" id="btnViewReport" data-toggle="modal" data-target="#modal-view-report"><i class="glyphicon glyphicon-envelope"></i> C.I NOTE</a>'+
                                        nonotes;
                                }
                            }
                            else if(data.acct_status == 3)
                            {
                                if(data.ci_cert=='C')
                                {
                                    return '<a class="btn btn-xs btn-block btn-primary" name = "'+data.id+':'+data.account_name+'" id="btnDownloadFile" data-toggle="modal" data-target="#dispatch_modal"><i class="glyphicon glyphicon-cloud-download"></i> DOWNLOAD FILES</a>' +
                                        ' <a href="'+data.id+'" class="btn btn-xs btn-block btn-info"  name = "'+data.id+':'+data.account_name+'" id="btnShowInfo" data-toggle="modal" data-target="#modal-update-info"><i class="glyphicon glyphicon-pencil"></i> UPDATE INFO</a>'+
                                        ' <a href="'+data.id+'"  class="btn btn-xs btn-block btn-warning" name="'+data.account_name+'" id="btnViewFullInfo" data-toggle="modal" data-target="#modal-view-info"><i class="glyphicon glyphicon-film"></i> VIEW ACCOUNT</a>' +
                                        ' <a href="'+data.id+'" class="btn btn-xs btn-block btn-success" name="'+data.account_name+' id="btnViewReport" data-toggle="modal" data-target="#modal-view-report"><i class="glyphicon glyphicon-envelope"></i> C.I NOTE</a>'+
                                        nonotes;
                                }
                            }
                            else
                            {
                                return '<a class="btn btn-xs btn-block btn-primary" data-toggle="modal" data-target="#dispatch_modal"><i class="glyphicon glyphicon-time"></i> DISPATCHING..</a>'+
                                    nonotes;
                            }
                        },
                        "name": 'endorsements.acct_status',
                        "width": '5%'
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

    $('#ao-new-endorsement_filter input').unbind();
    $('#ao-new-endorsement_filter input').bind('keyup change',function (e) {

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

var finish_account = [];
var finish_account_ctr = 0;
function finish_accounts()
{
    $('#ao-finish-endorsement thead th').each(function() {
        var title = $(this).text();
        finish_account[finish_account_ctr] = title;
        finish_account_ctr++;
        $(this).html(title+'<br><input type="text" placeholder="Search" style="position: relative; width: 100%">');
    });

    tableAoFinishReport = $('#ao-finish-endorsement').DataTable(
        {
            dom: 'Blfrtip',
            buttons:
                [
                    {
                        extend: 'excel',
                        title : 'Finish Accounts',
                        exportOptions:
                            {
                                format:
                                    {
                                        header: function (dt, idx) {
                                            return finish_account[(idx)];
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
                    }
                ],
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "ajax":
                {
                    url: "/ao-finish-report-table",
                    data: function (d)
                    {

                        d.min_date_endorsed = $('#minFinish').val();
                        d.max_date_endorsed = $('#maxFinish').val();
                    }
                },
            "columns":
                [
                    {data: 'id', name: 'endorsements.id'},
                    {data: 'date_endorsed', name: 'endorsements.date_endorsed'},
                    {data: 'time_endorsed', name: 'endorsements.time_endorsed'},
                    {
                        data: function (data) {

                            var status = '';

                            if(data.endorsement_status_internal_2 == 'TAT')
                            {
                                status = '<small class="label bg-green">ON TAT</small>';
                            }
                            else if (data.endorsement_status_internal_2 == 'OVERDUE')
                            {
                                status = '<small class="label bg-black">OVERDUE</small>';
                            }
                            else
                            {
                                status = '<small class="label bg-black">UNDECLARED</small>';
                            }

                            return data.ao_internal_status+' '+status;

                        },
                        'name': 'endorsements.endorsement_status_internal_2'
                    },
                    {data: 'account_name', name: 'endorsements.account_name'},
                    {data: 'type_of_request', name: 'endorsements.type_of_request'},
                    {data: 'muni_name', name: 'municipalities.muni_name'},
                    // {
                    //
                    //     data: function actions(data)
                    //     {
                    //
                    //         clearTimeout(times);
                    //         fetchOtherInro('ao-finish-endorsement');
                    //         return '<span id="otherinfo'+data.id+'">'+data.type_of_request+'</span>';
                    //
                    //     },
                    //     'name' : 'endorsements.type_of_request'
                    // },
                    {data: 'provinces', name: 'endorsements.provinces'},
                    {data: 'client_remarks', name: 'endorsements.client_remarks'},
                    {data: 'requestor_name', name: 'endorsements.requestor_name'},
                    {data: 're_ci', name: 'endorsements.re_ci'},
                    {
                        data: function action(data)
                        {
                            var nonotes = '';

                            if(data.nononote==null)
                            {
                                nonotes +='<a href="'+ data.id + '" class="btn btn-xs btn-default btn-block" id="btnView" data-toggle="modal"><i class="glyphicon glyphicon-envelope"></i> No Client Note</a>';
                            }
                            else
                            {
                                nonotes += '<a href="'+ data.id + '" class="btn btn-xs btn-warning btn-block" id="btnNoteView" data-toggle="modal" data-target="#modal-dispatcher-view-notee"><i class="glyphicon glyphicon-envelope"></i> View Client Note</a>';
                            }

                            if(data.acct_status==3 && data.ci_cert=='C')
                            {
                                return '<a class="btn btn-xs btn-block btn-primary" name = "'+data.id+':'+data.account_name+'" id="btnDownloadFile" data-toggle="modal" data-target="#dispatch_modal"><i class="glyphicon glyphicon-cloud-download"></i> DOWNLOAD FILES</a>' +
                                    ' <a href="'+data.id+'"  class="btn btn-xs btn-block btn-warning" id="btnViewFullInfo" name="'+data.account_name+'" data-toggle="modal" data-target="#modal-view-info"><i class="glyphicon glyphicon-film"></i> VIEW ACCOUNT</a>' +
                                    // ' <a href="'+data.id+'" hidden  class="btn btn-xs btn-block btn-info" id="btn_finish_resend_email" name="'+data.account_name+'" data-toggle="modal" data-target="#modal-update-info"><i class="fa fa-envelope-o"></i><i class="fa fa-long-arrow-up"></i> RESEND EMAIL</a>' +
                                    ' <a href="'+data.id+'" class="btn btn-xs btn-block btn-success" name="'+data.account_name+'" id="btnViewReport" data-toggle="modal" data-target="#modal-view-report"><i class="glyphicon glyphicon-envelope"></i> C.I NOTE</a>'+
                                    nonotes;
                            }
                            else if(data.acct_status==3 && data.ci_cert=='NC')
                            {
                                return '<a class="btn btn-xs btn-block btn-primary" name = "'+data.id+':'+data.account_name+'" id="btnDownloadFile" data-toggle="modal" data-target="#dispatch_modal"><i class="glyphicon glyphicon-cloud-download"></i> DOWNLOAD FILES</a>' +
                                    ' <a href="'+data.id+'"  class="btn btn-xs btn-block btn-warning" id="btnViewFullInfo" name="'+data.account_name+'" data-toggle="modal" data-target="#modal-view-info"><i class="glyphicon glyphicon-film"></i> VIEW ACCOUNT</a>' +
                                    // ' <a href="'+data.id+'" hidden  class="btn btn-xs btn-block btn-info" id="btn_finish_resend_email" name="'+data.link_path+'" data-toggle="modal" data-target="#modal-update-info"><i class="fa fa-envelope-o"></i><i class="fa fa-long-arrow-up"></i> RESEND EMAIL</a>' +
                                    ' <a href="'+data.id+'" class="btn btn-xs btn-block btn-success" name="'+data.account_name+'" id="btnViewReport" data-toggle="modal" data-target="#modal-view-report"><i class="glyphicon glyphicon-envelope"></i> C.I NOTE</a>'+
                                    nonotes;
                            }
                            // else if(data.ci_cert=='NC')
                            // {
                            //     return '<a class="btn btn-xs btn-block btn-primary" id="btnDownloadFile" data-toggle="modal" data-target="#dispatch_modal"><i class="glyphicon glyphicon-cloud-download"></i> DOWNLOAD PHOTO</a>' +
                            //         ' <a href="'+data.id+'" class="btn btn-xs btn-block btn-default" id="btnAttachReport" data-toggle="modal" data-target="#modal-attach-report"><i class="glyphicon
                            //
                            // glyphicon-envelope"></i> ATTACH REPORT</a>' +
                            //         ' <a class="btn btn-xs btn-block btn-warning" id="btnViewFullInfo" data-toggle="modal" data-target="#modal-view-info"><i class="glyphicon glyphicon-film"></i> VIEW ACCOUNT</a>' +
                            //         ' <a href="'+data.id+'" class="btn btn-xs btn-block btn-success" id="btnViewReport" data-toggle="modal" data-target="#modal-view-report"><i class="glyphicon glyphicon-envelope"></i> C.I NOTE</a>' ;
                            // }
                        },
                        "name": 'endorsements.acct_status',
                        "width": '5%'
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

    $('#ao-finish-endorsement_filter input').unbind();
    $('#ao-finish-endorsement_filter input').bind('keyup change',function (e) {
        if($(this).is(':focus'))
        {
            if (e.keyCode == 13) {
                tableAoFinishReport.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '') {
                    tableAoFinishReport.search($(this).val()).draw();
                }
            }
        }
    });
}

$('#ao-new-endorsement , #ao-finish-endorsement').on('click','#btnNoteView', function ()
{
    $('#txtAreaNote').html('');
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
            $('#btnSaveNote').hide();
            $('#btnUpdateNote').show();
            $('#txtNote').html('');
            $('#txtAreaNote').append
            (
                '                                    <div class="form-group">\n' +
                '                                        <label>Note</label>\n' +
                '                                        <textarea class="form-control" rows="20" placeholder="Enter ..." id="txtNote" disabled>'+data[0].endorsement_note+'</textarea>\n' +
                '                                    </div>'
            )
        }
    });
});
//BUTTON FOR DOWNLOAD
$('#ao-new-endorsement, #ao-finish-endorsement').on('click', '#btnDownloadFile', function (e)
{

    var id_name = $(this).attr('name');
    var get_id_name_array = id_name.split(':');
    var get_id = get_id_name_array[0];
    var get_name = get_id_name_array[1];
    acctID = get_id;
    DownloadAo(get_name,get_id,$('input[name=_tokens]').val());

});

function DownloadAo(acctName, id, token) {

        var acct_encode = btoa(acctName);
        var id_encode = btoa(id);
        var token_token = btoa(token);

       var q = '<form action="/ao-download-file" target="_blank" method="get">'+
        '<div class="input-group">'+
        '<input type="text" hidden value="'+acct_encode+'" name="acctName">'+
        '<input type="text" hidden value="'+id_encode+'" name="id">'+
        '<input type="text" hidden value="'+token_token+'" name="token">'+
        '<button type="submit" id="button_form_download">'+
        '</button>'+
        '</span>'+
        '</div>'+
        '</form>';

    $('#down_form').html(q);

    $('#button_form_download').click();

}

//END OF BUTTON FOR DOWNLOAD
var resen_or_not = false;
$('#ao-new-endorsement').on('click', '#btnShowInfo', function (e)
{
    $('#hideShowArchitoEmail').hide();
    resen_or_not = false;
    $('#btnUpdateInfo').html('Submit');
    $('#upsform').show();
    $('#auto_matic_attach_span').html('');
    $('#view_other_info_updating').show();
    var id_name = $(this).attr('name');
    var get_id_name_array = id_name.split(':');

    var get_id = get_id_name_array[0];
    var get_name = get_id_name_array[1];

    $('#progressbar').hide();
    $('#overlay_load').hide();

    if(acctID != get_id)
    {
        $('#ao_email_report_cc').tagsinput('removeAll');
        $('#ao_email_report_to').tagsinput('removeAll');
    }

    acctID = get_id;


    $('#accountName').val(get_name);

    $.ajax
    ({
        method: 'get',
        url: '/ao-get-address',
        data:
            {
                'acctID': get_id
            },
        success: function (data)
        {
            $('#archiClientTOEmail').html('');
            $('#ao_email_report_subj').val(data[2]);
            $('#ao_email_report_to').tagsinput('removeAll');

            $('#ao_email_report_to').tagsinput('add', data[5]);

            if(data[6] == 'false')
            {
                genArchitoMail = false;
                $('#hideShowArchitoEmail').hide();
                if(data[7][0] != '')
                {
                    for(var h = 0;h < data[7][0].length; h++)
                    {
                        $('#ao_email_report_to').tagsinput('add', data[7][0][h].user_email);
                    }
                }
            }
            else if(data[6] == 'true')
            {
                genArchitoMail = true;
                var option = '';


                for(var g = 0; g  < data[7][0].length; g++)
                {
                    var optionInside = '';
                    var checkArch;

                    if(g == 0)
                    {
                        checkArch = 'Luzon';
                    }
                    else if(g == 1)
                    {
                        checkArch = 'Visayas';
                    }
                    else if(g == 2)
                    {
                        checkArch = 'Mindanao';
                    }

                    for(var t = 0; t < data[7][0][g].length; t++)
                    {
                        optionInside += data[7][0][g][t].user_email + ', ';
                    }

                    option += '<option value = "'+g+'">'+checkArch+' ['+optionInside+'] </option>';
                }

                $('#archiClientTOEmail').html('<option value="-">-</option>'+option+'');

                $('#hideShowArchitoEmail').show();
            }

            $('#txtAddVer').val('');
            $('#txtAddVer').val(data[0][0].address+' '+data[0][0].city_muni+' '+data[0][0].provinces);

            $('#ao_email_report_cc').tagsinput('add', data[3]);
            $('#ao_email_report_cc').tagsinput('add', data[4]);

            console.log(data[5]);


            getcert = data[0][0].ci_cert;
            if(getcert == 'C')
            {
                // console.log(getcert);
                $('#div_email').hide();
                document.getElementById("upsform").style.display = "none";

            }else if(getcert == 'NC'){
                // console.log(getcert);
                $('#div_email').show();
                document.getElementById("upsform").style.display = "block";
            }

            var options ='';

            console.log(data);
            // for(var ctr = 0; ctr<data[1].length; ctr++)
            // {
            //     options += '<button type="button" style="margin-right: 5px;" class="btn btn-primary btn-xs Btn_Recip" name="'+data[1][ctr].id+'">'+data[1][ctr].name+'</button>'
            // }
            // $('#select_recipient_list').html(options);


            $('#archiClientTOEmail').change(function()
            {
                var sel = $(this).find(':selected').val();

                if(sel == '-')
                {
                    $('#ao_email_report_to').tagsinput('removeAll');
                    $('#ao_email_report_to').tagsinput('add', data[5]);
                }
                else if(sel != '-')
                {
                    $('#ao_email_report_to').tagsinput('removeAll');
                    $('#ao_email_report_to').tagsinput('add', data[5]);

                    var parse = parseInt(sel);

                    for(var q = 0; q < data[7][0][parse].length; q++)
                    {
                        $('#ao_email_report_to').tagsinput('add', data[7][0][parse][q].user_email);
                    }
                }

            })

        },
        complete : function () {
            // $('.Btn_Recip').click(function () {
            //
            //     console.log($(this).attr('name'));
            //
            //     var id_recip = $(this).attr('name');
            //
            //     var to_select =  $('#to_selects');
            //     var cc_select =  $('#cc_selects');
            //
            //     to_select.html('');
            //     cc_select.html('');
            //
            //     var to_strings = '';
            //     var cc_strings = '';
            //
            //     $.ajax({
            //
            //         url : 'ao_trigger_to_get_list_recipients',
            //         type : 'get',
            //         data : {
            //             'id' : id_recip
            //         },
            //         success : function (data) {
            //
            //             for(var ctr = 0; ctr < data.length; ctr++)
            //             {
            //                 if(data[ctr].type == 'to')
            //                 {
            //                     to_strings += data[ctr].html+', '
            //                 }
            //                 else if(data[ctr].type == 'cc')
            //                 {
            //                     cc_strings += data[ctr].html+', '
            //                 }
            //             }
            //             to_select.html(to_strings.slice(0,-2));
            //             cc_select.html(cc_strings.slice(0,-2));
            //
            //         },
            //         error : function () {
            //             alert('error fetching datas');
            //         }
            //
            //     });
            //
            //
            // });
        }
    });
});



$('#ao-finish-endorsement').on('click', '#btn_finish_resend_email', function (e)
{
    resen_or_not = true;
    acctID = $(this).attr('href');
    $('#btnUpdateInfo').html('Resend email');
    $('#view_other_info_updating').hide();
    $('#div_email').show();
    $('#auto_matic_attach_span').html('<p><b>Automatic attached file: '+$(this).attr('name')+'.zip</b></p>');
    $('#upsform').hide();

    var options = '';

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
            console.log(data);
            for(var ctr = 0; ctr<data[1].length; ctr++)
            {
                options += '<button type="button" style="margin-right: 5px;" class="btn btn-primary btn-xs Btn_Recip" name="'+data[1][ctr].id+'">'+data[1][ctr].name+'</button>'
            }
            $('#select_recipient_list').html(options);
        },
        complete : function () {
            $('.Btn_Recip').click(function () {

                console.log($(this).attr('name'));

                var id_recip = $(this).attr('name');

                var to_select =  $('#to_selects');
                var cc_select =  $('#cc_selects');

                to_select.html('');
                cc_select.html('');

                var to_strings = '';
                var cc_strings = '';

                $.ajax({

                    url : 'ao_trigger_to_get_list_recipients',
                    type : 'get',
                    data : {
                        'id' : id_recip
                    },
                    success : function (data) {

                        for(var ctr = 0; ctr < data.length; ctr++)
                        {
                            if(data[ctr].type == 'to')
                            {
                                to_strings += data[ctr].html+', '
                            }
                            else if(data[ctr].type == 'cc')
                            {
                                cc_strings += data[ctr].html+', '
                            }
                        }
                        to_select.html(to_strings.slice(0,-2));
                        cc_select.html(cc_strings.slice(0,-2));

                    },
                    error : function () {
                        alert('error fetching datas');
                    }

                });

            });
        }
    });
});


$('#modal-update-info').on('change','#selectAddVer', function ()
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
    }
});


$('#btnUpdateInfo').click(function (e)
{
    var checkAlerts = false;

    if(resen_or_not == false)
    {
        if(genArchitoMail == true)
        {
            var arch = $('#archiClientTOEmail').find(':selected').val();

            if(arch == '-')
            {
                alert('Please select archipelago for the bank.')
                checkAlerts = true;
            }
            else if(arch != '-')
            {
                checkAlerts = false;
            }

        }
        else
        {
            checkAlerts = false;
        }

        if(checkAlerts == false)
        {
            var tags_input = $(".tags_input").tagsinput('items');
            var valid_checker = true;

            $.each(tags_input, function (index, value) {
                $.each(value,function (i,v) {

                    if(!v.includes('@') || v.includes(' ') || v.includes('>') || v.includes('<'))
                    {
                        valid_checker = false;
                    }
                });
            });

            if(valid_checker)
            {
                var r = confirm("NOTE: Always review your account before sending it to client.\nAre you sure you want to send this report to client?");
                if (r == true) {

                    if(getcert == 'C')
                    {

                        failed_to_send = true;
                        update_only();

                    }else if(getcert == 'NC') {

                        failed_to_send = false;
                        update_and_attach(e)
                    }

                }
                else
                {
                    console.log('nothing to do');
                }
            }
            else
            {
                alert('Please check the emails. Make sure all emails are valid.');
            }
        }
        else
        {

        }
    }
    else
    {
        // send_email_trigger();
        // open_send();
    }

});

function update_only() {

    var txtInternalStatus = $('#txtInternalStatus').val();
    var txtExternalStatus = $('#txtExternalStatus').val();
    var txtPictureStatus = $('#txtPictureStatus').val();
    var txtTOSR = $('#txtTOSR').val();
    var acctName = $('#accountName').val();
    var txtRemarks = $('#txtRemarks').val();
    // var file = $("#upload_form")[0];

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
        method: 'post',
        url: '/ao-update-info',
        data:
            {
                'acctID': acctID,
                // 'txtDateDue': txtDateDue,
                // 'txtTimeDue': txtTimeDue,
                'txtInternalStatus': txtInternalStatus,
                'txtExternalStatus': txtExternalStatus,
                'txtPictureStatus': txtPictureStatus,
                'acctName': acctName,
                'txtTOSR': txtTOSR,
                'txtRemarks': txtRemarks,
                'txtVerAdd': verAdd
            },
        success: function (data)
        {
            if(data==='success')
            {
                $('#modal-update-info').modal('hide');
                setTimeout(function()
                {
                    $('#name').val('');
                    $('#email').val('');
                    $('#password').val('');
                    $('#position').val('');
                    $('#image').val('');
                    $('#attachFile').val('');
                    $('#txtRemarks').val('');
                    $('#modal-successUpdate').modal('show');
                    table.ajax.reload(null, false);
                    tableAoFinishReport.ajax.reload(null, false);


                    setTimeout(function () {
                        $('#modal-successUpdate').modal('hide');

                        // open_send();

                    },2000);

                }, 1000);
            }
            else
            {
                alert('Please attach report file');
            }
        }
    });

}

var failed_to_send = false;

function open_send() {

    if(failed_to_send)
    {

    }
    else
    {
        setTimeout(function () {
            $('#modal-sendnig-email-from-ao-to-client').modal('show');
        },1000);
    }
}

$("#fileFinisReport").change(function () {

    if($(this).val() != '')
    {
        var file_name = new $(this).prop('files');
        $('#attach_file_name_report').html(file_name[0].name);

    }
    else
    {
        $('#attach_file_name_report').html('Click Here to browse');

    }

});

function update_and_attach(e) {

    e.preventDefault();
    $('#attachReportFile').attr('disabled',true);
    var file = new $("#fileFinisReport").prop('files')[0];

    var form_data = new FormData();


    var subject = $("#ao_email_report_subj").val();
    var array_to = $("#ao_email_report_to").tagsinput('items');
    var array_cc = $("#ao_email_report_cc").tagsinput('items');
    var txtRemarks = $('#txtRemarks').val();

    form_data.append('acctID', acctID);
    form_data.append('remarks', txtRemarks);
    form_data.append('subject', subject);
    form_data.append('array_to', JSON.stringify(array_to));
    form_data.append('array_cc', JSON.stringify(array_cc));

    form_data.append('file', file);


    if( $("#fileFinisReport").val().length >= 1)
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
                        $('#overlay_load').show();
                        $('#ulPercentage').html('');
                        // $('#ulPercentage').append(percentComplete*100);
                        $('#ulPercentage').append(Math.floor(percentComplete*100));
                        $('#progressbar').show();
                        $('#progressbar').progressbar
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
            url: 'uploadReportFile',
            processData: false,
            contentType: false,
            data: form_data,
            success: function (data)
            {
                console.log(data);
                if(data==='success')
                {
                    update_only();
                }
                else if(data==='error')
                {
                    alert('INVALID FILE TYPE.');
                    $("#fileFinisReport").val('');
                    $('#attach_file_name_report').html('Click Here to browse');
                    $('#attachReportFile').attr('disabled',false);
                    $('#progressbar').progressbar('option', 'value', 0);
                    $('#progressbar').hide();
                    $('#ulPercentage').html('');
                    $('#overlay_load').hide();

                }
                else
                {
                    $('#ulPercentage').html('');
                    $('#progressbar').progressbar('option', 'value', 0);
                    $('#progressbar').hide();
                    $('#attachReportFile').attr('disabled',false);
                    $('#overlay_load').hide();
                    table.ajax.reload(null, false);
                    // tableAoFinishReport.ajax.reload(null, false);
                }
            },
            error : function () {
                alert('INVALID FILE TYPE, OR SOMETHING WENT WRONG. Please refresh this page.');
                $("#fileFinisReport").val('');
                $('#attach_file_name_report').html('Click Here to browse');
                $('#attachReportFile').attr('disabled',false);
                $('#progressbar').progressbar('option', 'value', 0);
                $('#progressbar').hide();
                $('#overlay_load').hide();
                $('#ulPercentage').html('');
            },
            complete : function () {

                console.log('come');
                // send_email_trigger();
                $("#fileFinisReport").val('');
                $('#attach_file_name_report').html('Click Here to browse');
                $('#attachReportFile').attr('disabled',false);
                $('#progressbar').progressbar('option', 'value', 0);
                $('#progressbar').hide();
                $('#overlay_load').hide();
                $('#ulPercentage').html('');
            }
        });
    }
    else
    {
        alert('No attachment detected.')
    }

}

function send_email_trigger() {

    $.ajax({
        url : 'ao_send_email_report_to_client',
        type : 'get',
        data : {
            'account_id' : acctID,
            'to' : $('#to_selects').html(),
            'cc' : $('#cc_selects').html(),
            'subject' : $('#send_subect_txt').val()
        },
        success : function () {
            failed_to_send = false;
            $('#modal-sendnig-email-from-ao-to-client').modal('hide');

            if(resen_or_not == false)
            {
                $('#ulPercentage').html('');
                $('#progressbar').progressbar('option', 'value', 0);
                $('#progressbar').hide();
                $("#fileFinisReport").val('');
                $('#attach_file_name_report').html('Click Here to browse');
            }
            else
            {
                // modal-update-info
                $('#modal-update-info').modal('hide');

            }

            // $('#modal-attach-report').modal('hide');
            $('#attachReportFile').attr('disabled',false);
            table.ajax.reload(null, false);
            tableAoFinishReport.ajax.reload(null, false);

            setTimeout(function () {

                $('#modal-success-email-sent').modal('show');

            },1000);

            setTimeout(function () {

                $('#modal-success-email-sent').modal('hide');

            },2000);

            // alert('Report Successfully sent to Client via email');
        },
        error : function () {
            failed_to_send = true;
            // alert('Sending Report Via email failed.');
            $('#modal-sendnig-email-from-ao-to-client').modal('hide');


            setTimeout(function () {

                $('#modal-failed-email-sent').modal('show');

            },1000);

            setTimeout(function () {

                $('#modal-failed-email-sent').modal('hide');

            },10000);


            // modal-failed-email-sent
        },
        complete : function () {

        }
    });


}

$('#ao-new-endorsement, #ao-finish-endorsement').on('click', '#btnViewFullInfo', function (e)
{

    var acctID = $(this).attr('href');
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


                    // '                <tr>\n' +
                    // '                  <td style="padding: 3px;"><span class="badge bg-red">DATE DUE</span></td>\n' +
                    // '                  <td style="padding: 3px;">'+data[0][0].date_due +'</td>\n' +
                    // '                  <td style="padding: 3px;"><span class="badge bg-red">TIME DUE</span></td>\n' +
                    // '                  <td style="padding: 3px;">'+data[0][0].time_due +'</td>\n' +
                    // '                </tr>\n' +

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

$('#ao-new-endorsement, #ao-finish-endorsement').on('click','#btnViewReport', function ()
{

    // $('#txtAreaNote').html();
    $('#acctReport').val('');
    accountID = $(this).attr("href");
    acctName =  $(this).attr("name");
    // console.log(acctName);

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

$('#ao-new-endorsement').on('click','#btnAttachReport', function ()
{
    acctID = '';
    acctID = $(this).attr("href");
    $('#attachReportFile').attr('disabled',false);
    $('#progressbar').hide();
    $('#overlay_load').hide();
});

$('#ao-finish-endorsement').on('click','#btnAttachReport', function ()
{
    acctID = '';
    acctID = $(this).attr("href");
    $('#attachReportFile').attr('disabled',false);
    $('#progressbar').hide();
    $('#overlay_load').hide();
});

function isEmail(email) {
    var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,6})+$/;
    return regex.test(email);
}

var to_option = [];
var cc_option = [];
var ops_to = '';
var ops_cc = '';
var ctr_to = 0;
var ctr_cc = 0;
var get_recip_id = '';

// $('#click_to').click(function () {
//
//     console.log('click to');
//
//     var get_to = $('#recip_emails').val();
//     if(isEmail(get_to))
//     {
//         console.log('email');
//         to_option[ctr_to] = ctr_to;
//         ops_to += '<option name="' + get_to + '" value="' + ctr_to + '">' + get_to + '</option><br>';
//         $('#ao_list_emails_to').html(ops_to);
//         ctr_to++;
//         console.log(to_option);
//         var shit = $('#ao_list_emails_to').select2();
//         shit.val(to_option).trigger("change");
//         $('.select2-selection__choice').css('color','black');
//         console.log('check to_option on add: '+to_option);
//     }
//     else
//     {
//         console.log('not email');
//         alert('Bad format');
//     }
//
// });
//
// $('#ao_list_emails_to').select2().change(function () {
//
//     setTimeout(function () {
//         $('.select2-selection__choice').css('color','black');
//     },500);
//
// });
//
// $('#ao_list_emails_to').on('select2:unselecting', function (e) {
//     var get_orig_array = to_option;
//     var id = e.params.args.data.id;
//     var list = $('#ao_list_emails_to');
//     to_option = [];
//     to_option.length = 0;
//     var ii = 0;
//     list.find('option[value='+id+']').remove();
//     for(var i = 0; i<get_orig_array.length; i++)
//     {
//         if(get_orig_array[i] != id){
//             to_option[ii] = get_orig_array[i];
//             ii++;
//         }
//     }
//     ops_to = list.html();
// });
//
// $('#click_cc').click(function () {
//
//     console.log('click cc');
//     console.log('ctr_cc :'+ctr_cc);
//     var get_cc = $('#recip_emails').val();
//
//     if(isEmail(get_cc))
//     {
//         cc_option[ctr_cc] = ctr_cc;
//         ops_cc += '<option name="' + get_cc + '" value="' + ctr_cc + '">' + get_cc + '</option><br>';
//         $('#ao_list_emails_cc').html(ops_cc);
//         ctr_cc++;
//         console.log(cc_option);
//         var shit = $('#ao_list_emails_cc').select2();
//         shit.val(cc_option).trigger("change");
//         $('.select2-selection__choice').css('color','black');
//     }
//     else
//     {
//         console.log('not email');
//         alert('Bad format');
//     }
//
//
// });
//
// $('#ao_list_emails_cc').select2().change(function () {
//
//     setTimeout(function () {
//         // console.log('triggerrr');
//         $('.select2-selection__choice').css('color','black');
//     },500);
//
// });
//
// $('#ao_list_emails_cc').on('select2:unselecting', function (e) {
//     var get_orig_array = cc_option;
//     var id = e.params.args.data.id;
//     var list = $('#ao_list_emails_cc');
//     cc_option = [];
//     cc_option.length = 0;
//     var ii = 0;
//     list.find('option[value='+id+']').remove();
//     for(var i = 0; i<get_orig_array.length; i++)
//     {
//         if(get_orig_array[i] != id){
//             cc_option[ii] = get_orig_array[i];
//             ii++;
//         }
//     }
//     ops_cc = list.html();
// });
//
// $('#btn_recip_save').click(function () {
//
//     var options_to = $('#ao_list_emails_to option');
//     var name_to = $.map(options_to ,function(option) {
//         return option.text;
//     });
//
//     var value_to = $.map(options_to ,function(option) {
//         return option.value;
//     });
//
//     var options_cc = $('#ao_list_emails_cc option');
//     var name_cc = $.map(options_cc ,function(option) {
//         return option.text;
//     });
//
//     var value_cc = $.map(options_cc ,function(option) {
//         return option.value;
//     });
//
//     var to_count = value_to.length;
//     var cc_count = value_cc.length;
//
//
//     if($('#name_list').val() == '')
//     {
//         alert('list name is empty.');
//     }
//     else
//     {
//         $.ajax({
//
//             url : 'ao_save_recipient_list',
//             get : 'get',
//             data : {
//                 'recipient_name' : $('#name_list').val(),
//                 'to_name' : name_to,
//                 'cc_name' : name_cc,
//                 'to_val' : value_to,
//                 'cc_val' : value_cc,
//                 'to_count' : to_count,
//                 'cc_count' : cc_count
//             },
//             success : function (data) {
//
//                 alert('Saving success');
//                 recip_table.ajax.reload(null,false);
//             },
//             error : function (e) {
//
//                 alert('Saving failed');
//                 console.log(e);
//             }
//
//         });
//
//     }
// });
//
// $('#btn_recip_clear').click(function () {
//
//     $('#name_list').val('');
//     $('#recip_emails').val('');
//     $('#ao_list_emails_to').val(null).trigger('change');
//     $('#ao_list_emails_cc').val(null).trigger('change');
//     $('#ao_list_emails_to option').remove();
//     $('#ao_list_emails_cc option').remove();
//     to_option = [];
//     cc_option = [];
//     ops_to = '';
//     ops_cc = '';
//     ctr_to = 0;
//     ctr_cc = 0;
// });
//
// $('#recip_table').on('click','#btn_recip_delete', function () {
//
//     var get_id = $(this).attr('name');
//
//     $.ajax({
//
//         url : 'ao_delete_recip_list',
//         type : 'get',
//         data : {
//             'id' : get_id
//         },
//         success : function (data) {
//             alert('Delete Successful.');
//             recip_table.ajax.reload(null,false);
//         },
//         error : function (e) {
//             console.log(e);
//             alert('Error deleting')
//         }
//
//     });
//
//
// });
//
// $('#recip_table').on('click','#btn_recip_view_table', function () {
//
//     var get_id = $(this).attr('name');
//     get_recip_id = get_id;
//     $('#btn_recip_update').removeAttr('disabled');
//     $.ajax({
//
//         url : 'ao_view_recip_list',
//         type : 'get',
//         data : {
//             'id' : get_id
//         },
//         success : function (data) {
//
//             $('#name_list').val('');
//             $('#recip_emails').val('');
//             $('#ao_list_emails_to').val(null).trigger('change');
//             $('#ao_list_emails_cc').val(null).trigger('change');
//             $('#ao_list_emails_to option').remove();
//             $('#ao_list_emails_cc option').remove();
//             to_option = [];
//             cc_option = [];
//             ops_to = '';
//             ops_cc = '';
//             ctr_to = 0;
//             ctr_cc = 0;
//
//             console.log(data);
//             $('#name_list').val(data[0].name);
//
//             var getlast_to = 0;
//             var getlast_cc = 0;
//             for(var ctr = 0; ctr<data.length; ctr++)
//             {
//                 if(data[ctr].type == 'to')
//                 {
//                     ops_to += '<option name="' + data[ctr].email + '" value="' +  data[ctr].val + '">' +  data[ctr].email + '</option><br>';
//                     to_option[data[ctr].val] =  data[ctr].val;
//                     getlast_to = data[ctr].val;
//
//                 }
//                 else if(data[ctr].type == 'cc')
//                 {
//                     ops_cc += '<option name="' + data[ctr].email + '" value="' +  data[ctr].val + '">' +  data[ctr].email + '</option><br>';
//                     cc_option[data[ctr].val] =  data[ctr].val;
//                     getlast_cc = data[ctr].val;
//                 }
//             }
//             ctr_to = getlast_to+1;
//             ctr_cc = getlast_cc+1;
//
//             setTimeout(function () {
//                 $('#ao_list_emails_to').html(ops_to);
//                 $('#ao_list_emails_to').select2().val(to_option).trigger("change");
//
//                 $('#ao_list_emails_cc').html(ops_cc);
//                 $('#ao_list_emails_cc').select2().val(cc_option).trigger("change");
//             },500);
//
//         },
//         error : function (e) {
//             console.log(e);
//             alert('Error deleting')
//         }
//
//     });
//
//
// });
//
// $('#btn_recip_update').click(function () {
//
//     var options_to = $('#ao_list_emails_to option');
//     var name_to = $.map(options_to ,function(option) {
//         return option.text;
//     });
//
//     var value_to = $.map(options_to ,function(option) {
//         return option.value;
//     });
//
//     var options_cc = $('#ao_list_emails_cc option');
//     var name_cc = $.map(options_cc ,function(option) {
//         return option.text;
//     });
//
//     var value_cc = $.map(options_cc ,function(option) {
//         return option.value;
//     });
//
//     var to_count = value_to.length;
//     var cc_count = value_cc.length;
//
//
//     $.ajax({
//
//         url : 'ao_update_recip_list',
//         type : 'get',
//         data : {
//             'id' : get_recip_id,
//             'recipient_name' : $('#name_list').val(),
//             'to_name' : name_to,
//             'cc_name' : name_cc,
//             'to_val' : value_to,
//             'cc_val' : value_cc,
//             'to_count' : to_count,
//             'cc_count' : cc_count
//         },
//         success : function () {
//             alert('Update Successful');
//             get_recip_id = 0;
//             $('#btn_recip_update').attr('disabled','disabled');
//             recip_table.ajax.reload(null,false);
//         },
//         error : function (e) {
//             console.log(e);
//             alert('Error update');
//         }
//
//     });
//
// });
