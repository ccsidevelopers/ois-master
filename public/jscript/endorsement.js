/**
 * Created by aa on 9/21/2017.
 */
var table_end;
var times;
var acctID;
var titleee_endo=[];
var title_endo;
var i_endo = 0;

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



});

function endo_init() {

    console.log('payt me')
    $('#list-new-endorsement thead th').each(function()
    {
        titleee_endo[i_endo] = $(this).text();
        $(this).unbind();
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
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "ajax":
                {
                    "url": "/list-endorsement"
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
                    // {data: 'muni_name', name: 'municipalities.muni_name'},
                    {data: 'provinces', name: 'endorsements.provinces'},
                    {data: 'client_name', name: 'endorsements.client_name'},
                    {data: 'handled_by_account_officer', name: 'endorsements.handled_by_account_officer'},
                    {data: 'handled_by_credit_investigator', name: 'endorsements.handled_by_credit_investigator'},
                    {data: 'handled_by_dispatcher', name: 'endorsements.handled_by_dispatcher'},
                    {data: 're_ci', name: 'endorsements.re_ci'},
                    {data: 'acct_status_view', name: 'endorsements.acct_status'},
                    {
                        data: function actions(data)
                        {


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

                        'orderable' : false,
                        'searchable' : false,
                        'name': 'nononote'
                    }
                ],
            "order": [ [0, 'desc'] ],
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
}
