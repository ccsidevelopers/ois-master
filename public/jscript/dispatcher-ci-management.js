/**
 * Created by aa on 9/27/2017.
 */
var table_transfer;
var ciID;
var ciName;
var acctID;
var acctName;
var ciIDToTransfer;
var tableResultData;
var dn;
var times;

var dateRange1;
var dateRange2;
var checkifAllBool = 'all';
var tableTransAr = [];
var table_trans_count = 0;

$.ajaxSetup(
    {
        headers:
            {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
    });

$(document).ready(function()
{
    $('#chat_for_sao_dispa').removeAttr('hidden');

    $( "#DateDue_update" ).datepicker({
        dateFormat: "yy-mm-dd",
        language: "en-GB",
        // orientation: "top auto"
    });

    // fetchOtherInro();
    // function fetchOtherInro() {
    //     times = setTimeout(function (){
    //
    //         var countid = 0;
    //         var getitds = [];
    //         var gettors = [];
    //         var tab = document.getElementById('endorsement-table-transfer');
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

    $(window).focus(function () {

        console.log('focus');
        interval = true;
    });

    setInterval( function ()
    {
        if(interval)
        {
            if(disp_hist)
            {
                if(which_is_active == 'trans_active')
                {
                    table_transfer.ajax.reload(null, false);
                }
            }
        }
    }, 60000 );

});

defaultNowDate();

function defaultNowDate()
{
    var today = new Date();
    var dd = today.getDate();

    var mm = today.getMonth()+1;
    var yyyy = today.getFullYear();

    if(dd<10)
    {
        dd='0'+dd;
    }

    if(mm<10)
    {
        mm='0'+mm;
    }
    dateRange1 = yyyy+'-'+mm+'-'+dd;
    dateRange2 = yyyy+'-'+mm+'-'+dd;
}



function disp_trans_init()
{
    $('#endorsement-table-transfer thead th').each(function() {
        tableTransAr[table_trans_count] = $(this).text();
        table_trans_count++;
        var title = $(this).text();
        $(this).html(title+'<br><input type="text" placeholder="Search" style="position: relative; width: 100%">');
    });

    table_transfer = $('#endorsement-table-transfer').DataTable(
        {
            dom: 'Blfrtip',
            buttons:
                [
                    {
                        extend: 'excel',
                        title : 'Dispatch History',
                        exportOptions:
                            {
                                columns: ':visible',
                                format:
                                    {
                                        header: function (dt, idx, title) {
                                            return tableTransAr[(idx)];
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
                            return tableTransAr[(idx)];
                        }
                    },
                ],
            // responsive: true,
            processing: true,
            serverSide: true,
            // ajax: "/dispatcher-ci-list-account",
            "ajax":
                {
                    type: 'get',
                    url: "/dispatcher-ci-list-account",
                    data: function (d)
                    {
                        d.date_start_qq = $('#date1Disp').val();
                        d.date_end_qq = $('#date2Disp').val();
                        d.disp_if = $('#showWhoDisp').find(':selected').val();
                        d.searchall = checkifAllBool;
                    }
                },
            columns:
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
                    {data: 'handled_by_credit_investigator', name: 'endorsements.handled_by_credit_investigator'},
                    {data: 'muni_name', name: 'municipalities.muni_name'},
                    {data: 'name', name: 'provinces.name'},
                    {data: 'region_name', name: 'regions.region_name'},
                    {data: 'archipelago_name', name: 'archipelagos.archipelago_name'},
                    {
                        data: function(data)
                        {
                            return '<button class="btn-xs btn-info btn-block" value="'+data.id+'" id="btnTransfer" name="'+data.ci_id+'"><i class="fa fa-exchange"></i> Transfer</button>'+
                                ' <a href="' + data.id + '" class="btn btn-block btn-xs btn-primary" id="btnUpdateInfoTime" name="'+data.date_endorsed+'" data-toggle="modal" data-target="#dispatch_modal_trans"><i class="glyphicon glyphicon-edit"></i> Update</a>' +
                                '<a href="'+ data.id + '" class="btn btn-xs btn-primary btn-block" id="btnFullViewInfo" data-toggle="modal" data-target="#modal-view-info">View Info</a>';
                        },
                        "orderable": false,
                        "searchable": false,
                        "name": 'action',
                        "width": "8%"
                    }
                ],
            // "order": [[0, 'desc']],
            "pageLength": 10,
            "lengthMenu": [[10, 25, 50, -1], ['10 rows', '25 rows', '50 rows', 'Show all']],
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

    $('#endorsement-table-transfer_filter input').unbind();
    $('#endorsement-table-transfer_filter input').bind('keyup change',function (e) {

        if($(this).is(':focus'))
        {
            if (e.keyCode == 13) {
                table_transfer.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '') {
                    table_transfer.search($(this).val()).draw();
                }
            }
        }
    });


    tableResultData = $('#resultData').DataTable(
        {
            processing: true,
            serverSide: true,
            ajax: "/dispatcher-generate-report",
            columns:
                [
                    {data: 'account_name', name: 'account_name'},
                    {data: 'address', name: 'address'}
                ],
            initComplete: function ()
            {
                this.api().columns().every(function () {
                    var column = this;
                    var input = document.createElement("input");
                    $(input).appendTo($(column.footer()).empty())
                        .on('change', function () {
                            var val = $.fn.dataTable.util.escapeRegex($(this).val());

                            column.search(val ? val : '', true, false).draw();
                        });
                });
            },
            order: [ [0, 'desc'] ],
            pageLength: 25
        });
}

$('#generate').click(function ()
{
    var acctID = 9;
    var date = $('#datepickers').val();
    console.log(date);

    $.ajax
    ({
        method: 'get',
        url: '/dispatcher-ci-list-account',
        data:
            {
                'acctID': acctID,
                'date': date
            },
        success: function (data)
        {
            console.log(data);
            table_transfer.ajax.reload(null, false);
        }
    })
});

$('#endorsement-table-transfer').on('click', '#btnTransfer', function (e)
{
    // var tr = $(this).closest('tr');
    ciID = $(this).attr("name");
    acctID = $(this).attr("value");

    $('#ciID').val(ciID);
    $('#acctID').val(acctID);

    $('#transfer-modal').modal('show');
});

var trans = $('#btnTransfer');

$('#btnTransfer').click(function (e)
{
    ciIDToTransfer = $('#ciIDTransfer').val();

    if(ciIDToTransfer == '0')
    {
        alert('Please Select C.I.');
    }
    else
    {
        $.ajax
        ({
            method: 'get',
            url: 'dispatcher-ci-transfer',
            data:
                {
                    'ciID': ciID,
                    'acctID': acctID,
                    'ciIDToTransfer': ciIDToTransfer
                },
            beforeSend : function () {
                trans.attr('disabled','disabled');
            },
            success: function (data)
            {

                if(data=='failed')
                {
                    alert('This account is in the process of fund request. Please cancel the process or wait for the process to finish before the transferring of this account become available.\n\nOR\n\nContact the SAO or Finance to Disapproved the Fund Request for this account.');
                    trans.removeAttr('disabled');

                }
                else if(data == 'finish')
                {
                    alert('Account already finished failed to transfer.');
                    trans.removeAttr('disabled');
                }
                else if(data == 'uploaded')
                {
                    alert('This account is already modified/uploaded by C.I.');
                    trans.removeAttr('disabled');
                }
                else if(data=='success')
                {
                    $('#transfer-modal').modal('hide');
                    var timerSuccess = setInterval(function()
                    {
                        $('#modal-successTransfer').modal('show');
                        table_transfer.ajax.reload(null, false);
                        clearInterval(timerSuccess);
                        trans.removeAttr('disabled');
                        var timer2 = setInterval(function () {
                            $('#modal-successTransfer').modal('hide');
                            clearInterval(timer2);
                        },2000);
                    }, 1000);

                }
            }
        })
    }
});


$('#endorsement-table-transfer').on('click', '#btnUpdateInfoTime', function (e)
{

    id = $(this).attr("href");
    dateEndorsed = $(this).attr('name');

    $.ajax({
        url: '/dispatcher-get-time-due',
        type: 'GET',
        data:
            {
                'acctID': id
            },
        success: function (data)
        {
            var gettimsplit = data[0].time_due.split(":");
            var getimeint = parseInt(gettimsplit[0]);
            $('#DateDue_update').val(data[0].date_due);
            if(getimeint >= 10)
            {
                if(getimeint > 12)
                {
                    getimeint -= 12;
                    $('#TimeDue_update').val(getimeint+':'+gettimsplit[1]+' PM');
                }
                else
                {
                    $('#TimeDue_update').val(getimeint+':'+gettimsplit[1]+' AM');
                }
            }
            else {
                $('#TimeDue_update').val(getimeint+':'+gettimsplit[1]+' AM');
            }
        }
    });

});


$('#btnDispatch_update').click(function () {

    console.log(id);
    var date = $('#DateDue_update').val();
    var time = $('#TimeDue_update').val();

    if(date == '')
    {
        alert('Please fill up Date Due.');

    }
    else
    {
        $.ajax({
            url: '/dispatcher-update-get-time-due',
            type: 'GET',
            data:
                {
                    'acctID': id,
                    'dateTime': date + ' ' + time
                },
            beforeSend: function () {
                $('#btnDispatch_update').attr('disabled',true);
            },
            success: function (data)
            {
                alert('Due Date/Time successfully updated');
                $('#dispatch_modal_trans').modal('hide');
                table_transfer.ajax.reload(null, false);
            },
            complete: function () {
                $('#btnDispatch_update').attr('disabled',false);
            }
        });
    }

});



$('#btnDisplayAccount').click(function ()
{
    var ciID = $('#ciCountAccount').val();
    $('#ciResultCount').html('');

    $.ajax({
        type: 'get',
        url: 'fetch-cilistaccount',
        data:
            {
                'ciID': ciID
            },
        success: function (data)
        {
            var percentageResult = ((data.ciOverdue/data.ciTAT)*100);

            var template =

                '<div class="col-md-4">' +
                '<div class="box box-widget widget-user-2">' +
                '<div class="widget-user-header bg-yellow">' +
                '<div class="widget-user-image">' +
                '<img class="img-circle" src="'+data.ciPixPath+'">' +
                '</div>' +
                '<h3 class="widget-user-username">'+data.ciName+'</h3>' +
                '<h5 class="widget-user-desc">'+data.ciPositionName+'</h5>' +
                '</div>' +
                '<div class="box-footer no-padding">' +
                '<ul class="nav nav-stacked">' +
                '<li><a href="#">Due Account/s Today ('+data.dateToday+') <span class="pull-right badge bg-blue">'+data.ciCountAccount+'</span></a></li>' +
                '<li><a href="#">Total Accounts Received <span class="pull-right badge bg-red">'+data.ciTotalAccounts+'</span></a></li>' +
                '</ul>' +
                '</div>' +
                '</div>' +

                '</div>' +

                // 1ST OTHER REPORT

                '<div class="col-md-4">'+
                '<div class="info-box bg-yellow">'+
                '<span class="info-box-icon"><i class="ion ion-stats-bars"></i></span>'+
                '<div class="info-box-content">'+
                '<span class="info-box-text">Overall Performance Grade</span>'+
                '<span class="info-box-number">'+percentageResult+'%</span>'+
                '<div class="progress">'+
                '<div class="progress-bar" style="width: '+percentageResult+'%"></div>'+
                '</div>'+
                '<span class="progress-description">'+
                ''+
                '</span>'+
                '</div>'+
                '</div>'+
                '</div>' +

                // 2ND OTHER REPORT

                '<div class="col-md-4">'+
                '<div class="info-box bg-green">'+
                '<span class="info-box-icon"><i class="ion ion-ios-time-outline"></i></span>'+
                '<div class="info-box-content">'+
                '<span class="info-box-text">Total TAT Report</span>'+
                '<span class="info-box-number">'+data.ciTAT+'</span>'+
                '<div class="progress">'+
                '<div class="progress-bar" style="width: 20%"></div>'+
                '</div>'+
                '<span class="progress-description">'+
                ''+
                '</span>'+
                '</div>'+
                '</div>'+
                '</div>' +

                // 3RD OTHER REPORT

                '<div class="col-md-4">'+
                '<div class="info-box bg-aqua">'+
                '<span class="info-box-icon"><i class="ion-ios-pie-outline"></i></span>'+
                '<div class="info-box-content">'+
                '<span class="info-box-text">Total Hour Lost</span>'+
                '<span class="info-box-number">163,921</span>'+
                '<div class="progress">'+
                '<div class="progress-bar" style="width: 40%"></div>'+
                '</div>'+
                '<span class="progress-description">'+
                ''+
                '</span>'+
                '</div>'+
                '</div>'+
                '</div>' +

                // 4TH OTHER REPORT

                '<div class="col-md-4">'+
                '<div class="info-box bg-red">'+
                '<span class="info-box-icon"><i class="ion ion-ios-alarm-outline"></i></span>'+
                '<div class="info-box-content">'+
                '<span class="info-box-text">Total Overdue Report</span>'+
                '<span class="info-box-number">'+data.ciOverdue+'</span>'+
                '<div class="progress">'+
                '<div class="progress-bar" style="width: 70%"></div>'+
                '</div>'+
                '<span class="progress-description">'+
                ''+
                '</span>'+
                '</div>'+
                '</div>'+
                '</div>';

            $('#ciResultCount').append(template);

        }
    });
});

$('#btnGenerateReport').click(function ()
{
    // dn = $('#datepickers').val();
    dn = '2017-12-29';

    $.ajax
    ({
        type: 'get',
        url: '/dispatcher-generate-report',
        data:
            {
                'dn': dn
            },
        success: function (data)
        {
            var timer2 = setInterval(function ()
            {
                tableResultData.ajax.reload(null, false);
                clearInterval(timer2);
            },3000);
        }
    })
});

$('#endorsement-table-transfer').on('click', '#btnFullViewInfo', function (e)
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

$('#optionAllShow').click(function()
{

    checkifAllBool = 'all';




    table_transfer.ajax.reload(null, false);

    $('#showhideDateRangeDispHis').hide();
});

$('#optionDateRange').click(function()
{
    defaultNowDate();
    checkifAllBool = 'date_range';

    $('#date1Disp').val(dateRange1);
    $('#date2Disp').val(dateRange2);

    table_transfer.draw();

    $('#showhideDateRangeDispHis').show();
});

$('.dateDisHistoryClass').change(function ()
{
    table_transfer.ajax.reload(null, false);
});

$('#showWhoDisp').change(function()
{
    table_transfer.ajax.reload(null, false);
});


