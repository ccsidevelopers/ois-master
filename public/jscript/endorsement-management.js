/**
 * Created by aa on 9/21/2017.
 */
var table_end;
var times;
var acctID;
var titleee_endo=[];
var title_endo;
var i_endo = 0;
var activeArchipelago = 'All';

$(document).ready(function()
{
    // setInterval( function ()
    // {
    //     if(search_acct)
    //     {
    //         if(which_is_active == 'search_active')
    //         {
    //             if(interval)
    //             {
    //                 table_end.ajax.reload(null, false);
    //             }
    //         }
    //     }
    // }, 60000 );
    var today = new Date();
    var yearmonth;
    var date;

    // $('.viewable_report').css('display','none');

    $('.viewable_report#rad_daterange_report').prop('checked', true);
    $( "#datepicker_report" ).datepicker({ dateFormat: 'yy-mm-dd' ,        orientation: "bottom"});
    $( "#datepickermax_report" ).datepicker({ dateFormat: 'yy-mm-dd' ,        orientation: "bottom"});

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

    $( "#datepicker_report" ).datepicker({ dateFormat: 'yy-mm-dd' });
    $( "#datepickermax_report" ).datepicker({ dateFormat: 'yy-mm-dd' });

    $('#datepicker_report').val(month+dateyear);
    $('#datepickermax_report').val(month+dateyear);

    $('#min_report').val(yearmonth+date);
    $('#max_report').val(yearmonth+date);

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

                table_end.draw();
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

                table_end.draw();

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
        table_end.draw();
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
        table_end.draw();
    });


    // $('.viewable_report#rad_all_report').prop('checked',true);

    $('.viewable_report#rad_daterange_report').prop('checked',true);

    endo_init();

});

function endo_init() {
// console.log($('#min_report').val());

    console.log('test me')
    $('#list-new-endorsement thead th').each(function()
    {
        titleee_endo[i_endo] = $(this).text();
        i_endo++;
        title_endo = $(this).text();
        $(this).html(title_endo+'<br><input type="text" placeholder="Search" style="position: relative; width: 100%">');
    });
    table_end = $('#list-new-endorsement').DataTable(
        {
            dom: 'Blfrtip',
            buttons:
                [
                    {
                        extend: 'colvis',
                        columnText: function (dt, idx, title)
                        {
                            return titleee_endo[(idx)];
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
                                            return titleee_endo[(idx)];
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
                                            return titleee_endo[(idx)];
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
                                            return titleee_endo [(idx)];
                                        }
                                    }
                            }
                    }
                ],
            "rowReorder":
                {
                    selector: 'td:nth-child(7)'
                },
            // "responsive": true,
            "processing": true,
            "serverSide": true,
            // "ajax":
            //     {
            //         "url": "/list-endorsement"
            //     },
            "ajax":
                {
                    url: "/list-endorsement-management",
                    data: function (d)
                    {
                        d.min_date_endorsed = $('#min_report').val();
                        d.max_date_endorsed = $('#max_report').val();
                        d.arch = activeArchipelago
                        // d.search_option = search_where_option_fund;
                    }
                },
            "columns":
                [
                    {data: 'id', name: 'endorsements.id'},
                    {data: 'date_endorsed', name: 'endorsements.date_endorsed'},
                    {data: 'time_endorsed', name: 'endorsements.time_endorsed'},
                    {data: 'account_name', name: 'endorsements.account_name'},
                    {data: 'address', name: 'endorsements.address'},
                    {data: 'requestor_name', name: 'endorsements.requestor_name'},
                    {data: 'type_of_request', name: 'endorsements.type_of_request'},
                    {data: 'muni_name', name: 'municipalities.muni_name'},
                    {data: 'provinces', name: 'endorsements.provinces'},
                    {data: 'archipelago_name', name: 'archipelagos.archipelago_name'},
                    {data: 'client_name', name: 'endorsements.client_name'},
                    {data: 'handled_by_account_officer', name: 'endorsements.handled_by_account_officer'},
                    {data: 'handled_by_credit_investigator', name: 'endorsements.handled_by_credit_investigator'},
                    {data: 'handled_by_dispatcher', name: 'endorsements.handled_by_dispatcher'},
                    {data: 're_ci', name: 'endorsements.re_ci'},
                    {data: 'acct_status_view', name: 'endorsements.acct_status'},
                    {data: 'date_updated', name: 'endorsements.date_endorsed'},
                    {data: 'time_updated', name: 'endorsements.time_endorsed'},
                    {
                        data: function actions(data)
                        {
                            var note =' <a href="'+data.id+'" class="btn btn-xs btn-block btn-success" name="'+data.account_name+'" id="btnViewReport" data-toggle="modal" data-target="#modal-view-report-manage"><i class="glyphicon glyphicon-envelope"></i> C.I NOTE</a>';
                            var note_cliet = '';
                            var download = '';

                            // if(data.nononote==null)
                            // {
                            //     // return '<a href="'+ data.id + '" class="btn btn-xs btn-primary btn-block" id="btnFullViewInfo" data-toggle="modal" data-target="#modal-view-info">View Info</a>' +
                            //         note_cliet = '<a href="'+ data.id + '" class="btn btn-xs btn-default btn-block" id="btnView" data-toggle="modal">No Client Note</a>';
                            // }
                            // else
                            // {
                            //     // return '<a href="'+ data.id + '" class="btn btn-xs btn-primary btn-block" id="btnFullViewInfo" data-toggle="modal" data-target="#modal-view-info">View Info</a>' +
                            //         note_cliet = '<a href="'+ data.id + '" class="btn btn-xs btn-warning btn-block" id="btnNoteView" data-toggle="modal" data-target="#modal-dispatcher-view-notee">View Client Note</a>';
                            // }


                            if(data.acct_status==2)
                            {
                                //data forwarded
                                if(data.ci_cert=='NC')
                                {
                                    download = '<button value="'+data.id+'" class="btnAuditDownload_sao btn btn-xs btn-primary" name="dataforwarded"><i class="glyphicon glyphicon-cloud-download"></i> DOWNLOAD CI REPORT</button>';
                                }

                            }
                            else if(data.acct_status==3)
                            {
                                //finish
                                if(data.ci_cert=='NC')
                                {
                                    download = '<button value="'+data.id+'" class="btnAuditDownload_sao btn btn-xs btn-primary" name="dataforwarded"><i class="glyphicon glyphicon-cloud-download"></i> DOWNLOAD CI REPORT</button><br>'+
                                        '<button value="'+data.id+'" class="btnAuditDownload_sao btn btn-xs btn-primary" name="finish"><i class="glyphicon glyphicon-cloud-download"></i> DOWNLOAD AO REPORT</button>';
                                }
                                else if(data.ci_cert=='C')
                                {
                                    download = '<button value="'+data.id+'" class="btnAuditDownload_sao btn btn-xs btn-primary" name="finish_certified"><i class="glyphicon glyphicon-cloud-download"></i> DOWNLOAD CI REPORT</button>';
                                }

                            }

                            return '<a href="'+ data.id + '" class="btn btn-xs btn-primary btn-block" id="btnFullViewInfo" data-toggle="modal" data-target="#modal-view-info">View Info</a>' + note_cliet + note + download;


                        },

                        'orderable' : false,
                        'searchable' : false,
                        'name': 'nononote'
                    }
                ],
            "order": [ [0, 'desc'] ],
            "pageLength": 10,
            "lengthMenu" : [[10, 25, 50, 75, 100, -1], ['10 rows', '25 rows', '50 rows', '75 rows', '100 rows', 'Show all']],
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

    $('#list-new-endorsement_filter input').unbind();
    $('#list-new-endorsement_filter input').bind('keyup change',function (e) {

        if($(this).is(':focus'))
        {
            if (e.keyCode == 13) {
                table_end.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '') {
                    table_end.search($(this).val()).draw();
                }
            }
        }
    });

    $('#list-new-endorsement').on('click','#btnNoteView', function ()
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

    $('#list-new-endorsement').on('click', '#btnFullViewInfo', function (e)
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

    $('#list-new-endorsement').on('click','#btnViewReport', function ()
    {

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

    $('#modal-view-report-manage').on('click','#exportReport', function ()
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

    $('#list-new-endorsement').on('click','.btnAuditDownload_sao', function ()
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
}

$('#archipelagoSelectTracker').change(function()
{
    activeArchipelago = $(this).find(':selected').val();

    table_end.ajax.reload(null, false);
});
