var listProvince = [];
var tol = [];
var dropdown;
var dropdownevrbvr;
var coborInfo = [];
var empInfo = [];
var busInfo = [];
var busInfos = [];
var acctAddTemp;
var multiCoborrowerTemp;
var otherInfoTemp;
var requestorInfoTemp;
var empInfoTemp;
var busInfoTemp;
var table;
var tableFinishAccount;
var tableHoldAccount;
var tableCancelAccount;
var tableRevisedAccount;
var countDownTime;
var muniID;
var originalMuniID;
var acctID;
var tos = "SUBJECT";
var titleee1=[];
var titleee2=[];
var titleee3=[];
var titleee4=[];
var titleee5=[];
var titleee=[];
var title;
var i1 = 0;
var i2 = 0;
var i3 = 0;
var i4 = 0;
var i5 = 0;
var splitter = '';
var splitterdata = '';
var checkercountcoob = 0;
var checkercountevr = 0;
var checkercountbvr = 0;
var times;
var corporatetrigger = false;
var cobromakertrigger = false;

var click_tab1 = false;
var click_tab2 = false;
var click_tab3 = false;
var click_tab4 = false;
var click_tab5 = false;
var tr_id_paypal = '';
var req_checker = '';
var check_if_direct = false;
// var it_is_direct = false;

var indi_rate = [];

var which = 'una';
var tableFinishAccountRead = '';
var tableFinishAccountReadTitle = [];
var tableFinishAccountReadTitleCount = 0;

var tableFinishAccountDownloaded = '';
var tableFinishAccountDownloadedTitle = [];
var tableFinishAccountDownloadedCount = 0;
var new_accounts_tab = true;
var read_accounts_tab = false;
var finish_accounts_tab = false;

var checkSave = false;

$.ajaxSetup
({
    headers:
        {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
});

$('#otherBranchHide').hide();
$('#otherAddressHide').show();
$('#adjustWidthBvr').addClass('col-md-4');
autocompleteCob();


function pending_accounts_table() {
    table = $('#client-history-table').DataTable
    ({
        "responsive": true,
        "processing": true,
        "serverSide": true,
        "ajax":
            {
                url: "/get-history-account",
                data: function (d)
                {
                    d.min_date_endorsed = $('#min').val();
                    d.max_date_endorsed = $('#max').val();
                }
            },
        dom: 'Blfrtip',
        buttons:
            [
                {
                    extend: 'pdf',
                    orientation: 'landscape',
                    pageSize: 'LEGAL',
                    exportOptions:
                        {
                            columns: ':visible',
                            format:
                                {
                                    header:  function (dt, idx, title)
                                    {
                                        return titleee1[(idx)];
                                    }
                                }
                        }
                },
                {
                    extend: 'excel',
                    exportOptions:
                        {
                            columns: ':visible',
                            format:
                                {
                                    header:  function (dt, idx, title)
                                    {
                                        return titleee1[(idx)];
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
                                        return titleee1[(idx)];
                                    }
                                }
                        }
                },
                {
                    extend: 'colvis',
                    text: 'Show/Hide Column',
                    columnText: function (dt, idx, title)
                    {
                        return titleee1[(idx)];
                    }
                }
            ],
        "columns":
            [
                {data: 'id', name: 'endorsements.id'},
                {data: 'account_name', name: 'endorsements.account_name',"className": "text-center"},
                {data: 'date_endorsed', name: 'endorsements.date_endorsed',"className": "text-center"},
                {data: 'time_endorsed', name: 'endorsements.time_endorsed',"className": "text-center"},
                {data: 'address', name: 'endorsements.address'},
                {data: 'muni_name', name: 'municipalities.muni_name', "className": "text-center"},
                {data: 'name', name: 'provinces.name',"className": "text-center"},
                {data: 'type_of_request', name: 'endorsements.type_of_request'},
                {data: 'type_of_loan', name: 'endorsements.type_of_loan'},
                {data: 'dealer_name', name: 'endorsements.dealer_name'},
                {data: 'contract_number', name: 'endorsements.contract_number'},
                // {
                //
                //     data: function actions(data) {
                //
                //         clearTimeout(times);
                //         fetchOtherInro('client-history-table');
                //         return '<span id="otherinfo'+data.id+'">'+data.type_of_request+'</span>';
                //
                //     },
                //     'name' : 'endorsements.type_of_request'
                // },
                {data: 'requestor_name', name: 'endorsements.requestor_name', "className": "text-center"},
                {data: 'client_remarks', name: 'endorsements.client_remarks', "className": "    text-center"},
                {data: 're_ci', name: 'endorsements.re_ci', "className": "text-center"},
                {
                    data: function acctStatus(data)
                    {
                        if(data.acct_status == '')
                        {
                            return '<a class="btn btn-xs btn-success btn-block" data-toggle="modal" data-target="#dispatch_modal" disabled><i class="glyphicon glyphicon-ok"></i> RECEIVED</a>';
                        }
                        else if(data.acct_status == 1)
                        {
                            return '<a class="btn btn-xs btn-warning btn-block" data-toggle="modal" data-target="#dispatch_modal" disabled><i class="glyphicon glyphicon-retweet"></i> ON FIELD</a>';
                        }
                        else if(data.acct_status == 2)
                        {
                            return '<a class="btn btn-xs btn-warning btn-block" data-toggle="modal" data-target="#dispatch_modal" disabled><i class="glyphicon glyphicon-retweet"></i> ON PROCESS</a>';
                        }
                        else if(data.acct_status == 3)
                        {
                            return '<a class="btn btn-xs btn-success btn-block" data-toggle="modal" data-target="#dispatch_modal" disabled><i class="glyphicon glyphicon-envelope"></i> SENT</a>';
                        }
                        else if(data.acct_status == 4)
                        {
                            return '<a class="btn btn-xs btn-primary btn-block" data-toggle="modal" data-target="#dispatch_modal" disabled><i class="glyphicon glyphicon-remove"></i> HOLD ACCT</a>';
                        }
                        else if(data.acct_status == 5)
                        {
                            return '<a class="btn btn-xs btn-primary btn-block" data-toggle="modal" data-target="#dispatch_modal" disabled><i class="glyphicon glyphicon-remove"></i> CANCEL ACCT</a>';
                        }
                    },
                    'orderable' : false,
                    'searchable' : false,
                    "name": 'acct_status',
                    "className": "text-center"
                },
                // {
                //     data: function externalStatus(data)
                //     {
                //         var countDownDate = new Date(data.date_due+' '+data.time_due);
                //         var now = new Date();
                //         var distance = countDownDate - now;
                //
                //         var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                //         var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                //         var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                //         var seconds = Math.floor((distance % (1000 * 60)) / 1000);
                //
                //         countDownTime = '<button class="btn btn-success btn-xs btn-block" disabled>'+ days + "D " + hours + "H " + minutes + "M "+'</button>';
                //
                //         if(data.acct_status == 4)
                //         {
                //             return '<a class="btn btn-xs btn-primary btn-block" data-toggle="modal" data-target="#dispatch_modal" disabled><i class="glyphicon glyphicon-remove"></i> HOLD ACCT</a>';
                //         }
                //         else if(data.acct_status == 5)
                //         {
                //             return '<a class="btn btn-xs btn-primary btn-block" data-toggle="modal" data-target="#dispatch_modal" disabled><i class="glyphicon glyphicon-remove"></i> CANCEL ACCT</a>';
                //         }
                //         else if(data.endorsement_status_external==="OVERDUE")
                //         {
                //             countDownTime = '<button class="btn btn-danger btn-xs btn-block" disabled>OVERDUE</button>';
                //             return countDownTime;
                //         }
                //         else if(data.endorsement_status_external==="TAT")
                //         {
                //             countDownTime = '<button class="btn btn-success btn-xs btn-block" disabled>ON TAT</button>';
                //             return countDownTime;
                //         }
                //         else if(isNaN(minutes))
                //         {
                //             countDownTime = '<button class="btn btn-success btn-xs btn-block" disabled>'+ 0 + "D " + 0 + "H " + 0 + "M "+'</button>';
                //             return countDownTime;
                //         }
                //         else if(minutes<0)
                //         {
                //             return '<button class="btn btn-danger btn-xs btn-block" disabled>TIME EXPIRED</button>';
                //         }
                //         else
                //         {
                //             return countDownTime;
                //         }
                //     },
                //     'orderable' : false,
                //     'searchable' : true,
                //     "name": 'endorsements.endorsement_status_external',
                //     "className": "text-center"
                // },
                {
                    data: function notes(data)
                    {
                        // return '<a class="btn btn-xs btn-warning btn-block edit_req11" href="'+data.id+'" data-toggle="modal">EDIT ENDORSEMENT</a>' +
                           return '<a href="'+ data.id + '" class="btn btn-xs btn-primary btn-block" id="btnFullViewInfo" data-toggle="modal" data-target="#modal-view-info-client">VIEW INFO</a>';
                    },
                    'orderable' : false,
                    'searchable' : false,
                    "name": 'nonotes',
                    "className": "text-center"
                }
            ],
        "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull)
        {
            if ( aData.endorsement_status_external == "TAT" )
            {
                $('td', nRow).css('background-color', '#66ff66');
            }
            else if(aData.endorsement_status_external == "OVERDUE")
            {
                $('td', nRow).css('background-color', '#ff9980');
            }
        },
        "order": [[0, 'desc']],
        "pageLength": 10,
        "lengthMenu": [[2, 10, 25, 50, -1], ['2 rows', '10 rows', '25 rows', '50 rows', 'Show all']],
        "bSortClasses": false,
        "deferRender": true,
        initComplete: function()
        {
            $('#client-history-table thead th').each(function() {
                titleee1[i1] = $(this).text();
                i1++;
                var title = $(this).text();
                $(this).unbind();
                if(title == 'Actions')
                {

                }
                else
                {
                    $(this).html(title+'<br><input type="text" placeholder="Search" style="position: relative; width: 100%">');
                }
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
                        // else if (e.keyCode === 8)
                        // {
                        //     if (this.value == '') {
                        //         that
                        //             .search(this.value)
                        //             .draw();
                        //     }
                        // }
                    }
                });
            });
        }
    });

    $('#client-history-table_filter input').unbind();
    $('#client-history-table_filter input').bind('keyup change',function (e) {

        if($(this).is(':focus'))
        {
            if (e.keyCode == 13) {
                table.search($(this).val()).draw();
            }
            // else if (e.keyCode === 8)
            // {
            //     if ($(this).val() == '') {
            //         table.search($(this).val()).draw();
            //     }
            // }
        }
    });


}

function finish_accounts_table_read() {
    tableFinishAccountRead = $('#client-finish-read').DataTable
    ({
        "responsive": true,
        "processing": true,
        "serverSide": true,
        "ajax":
            {
                url: "client-get-finish-account-read",
                data: function (d)
                {
                    d.min_date_endorsed = $('#minFinish-read').val();
                    d.max_date_endorsed = $('#maxFinish-read').val();
                }
            },
        dom: 'Blfrtip',
        buttons:
            [
                {
                    extend: 'pdf',
                    orientation: 'landscape',
                    pageSize: 'LEGAL',
                    exportOptions:
                        {
                            columns: ':visible',
                            format:
                                {
                                    header:  function (dt, idx, title)
                                    {
                                        return tableFinishAccountReadTitle[(idx)];
                                    }
                                }
                        }
                },
                {
                    extend: 'excel',
                    exportOptions:
                        {
                            columns: ':visible',
                            format:
                                {
                                    header:  function (dt, idx, title)
                                    {
                                        return tableFinishAccountReadTitle[(idx)];
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
                                        return tableFinishAccountReadTitle[(idx)];
                                    }
                                }
                        }
                },
                {
                    extend: 'colvis',
                    text: 'Show/Hide Column',
                    columnText: function (dt, idx, title)
                    {
                        return tableFinishAccountReadTitle[(idx)];
                    }
                }
            ],
        "columns":
            [
                {data: 'id', name: 'endorsements.id'},
                {data: 'account_name', name: 'endorsements.account_name',"className": "text-center"},
                {data: 'date_endorsed', name: 'endorsements.date_endorsed',"className": "text-center"},
                {data: 'time_endorsed', name: 'endorsements.time_endorsed',"className": "text-center"},
                {data: 'address', name: 'endorsements.address'},
                {data: 'muni_name', name: 'municipalities.muni_name',"className": "text-center"},
                {data: 'name', name: 'provinces.name',"className": "text-center"},
                {data: 'type_of_request', name: 'endorsements.type_of_request'},
                {data: 'type_of_loan', name: 'endorsements.type_of_loan'},
                // {
                //
                //     data: function actions(data) {
                //
                //         clearTimeout(times);
                //         fetchOtherInro('client-finish-account');
                //         return '<span id="otherinfo'+data.id+'">'+data.type_of_request+'</span>';
                //
                //     },
                //     'name' : 'endorsements.type_of_request'
                // },
                {data: 'requestor_name', name: 'endorsements.requestor_name', "className": "text-center"},
                {data: 'client_remarks', name: 'endorsements.client_remarks', "className": "text-center"},
                {data: 're_ci', name: 'endorsements.re_ci', "className": "text-center"},
                {
                    data: function acctStatus(data)
                    {
                        if(data.acct_status == '')
                        {
                            return '<a class="btn btn-xs btn-success btn-block" data-toggle="modal" data-target="#dispatch_modal" disabled><i class="glyphicon glyphicon-ok"></i> RECEIVED</a>';
                        }
                        else if(data.acct_status == 1)
                        {
                            return '<a class="btn btn-xs btn-warning btn-block" data-toggle="modal" data-target="#dispatch_modal" disabled><i class="glyphicon glyphicon-retweet"></i> ON FIELD</a>';
                        }
                        else if(data.acct_status == 2)
                        {
                            return '<a class="btn btn-xs btn-warning btn-block" data-toggle="modal" data-target="#dispatch_modal" disabled><i class="glyphicon glyphicon-retweet"></i> FOR SENDING</a>';
                        }
                        else if(data.acct_status == 3)
                        {
                            return '<a class="btn btn-xs btn-success btn-block" data-toggle="modal" data-target="#dispatch_modal" disabled><i class="glyphicon glyphicon-envelope"></i> SENT</a>';
                        }
                        else if(data.acct_status == 4)
                        {
                            return '<a class="btn btn-xs btn-primary btn-block" data-toggle="modal" data-target="#dispatch_modal" disabled><i class="glyphicon glyphicon-remove"></i> HOLD ACCT</a>';
                        }
                        else if(data.acct_status == 5)
                        {
                            return '<a class="btn btn-xs btn-primary btn-block" data-toggle="modal" data-target="#dispatch_modal" disabled><i class="glyphicon glyphicon-remove"></i> CANCEL ACCT</a>';
                        }
                    },
                    'orderable' : false,
                    'searchable' : false,
                    "name": 'acct_status',
                    "className": "text-center"
                },
                {
                    data: function externalStatus(data)
                    {
                        var countDownDate = new Date(data.date_due+' '+data.time_due);
                        var now = new Date();
                        var distance = countDownDate - now;

                        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                        countDownTime = '<button class="btn btn-success btn-xs btn-block" disabled>'+ days + "D " + hours + "H " + minutes + "M "+'</button>';

                        if(data.acct_status == 4)
                        {
                            return '<a class="btn btn-xs btn-primary btn-block" data-toggle="modal" data-target="#dispatch_modal" disabled><i class="glyphicon glyphicon-remove"></i> HOLD ACCT</a>';
                        }
                        else if(data.acct_status == 5)
                        {
                            return '<a class="btn btn-xs btn-primary btn-block" data-toggle="modal" data-target="#dispatch_modal" disabled><i class="glyphicon glyphicon-remove"></i> CANCEL ACCT</a>';
                        }
                        else if(data.endorsement_status_external==="OVERDUE")
                        {
                            countDownTime = '<button class="btn btn-danger btn-xs btn-block" disabled>OVERDUE</button>';
                            return countDownTime;
                        }
                        else if(data.endorsement_status_external==="TAT")
                        {
                            countDownTime = '<button class="btn btn-success btn-xs btn-block" disabled>ON TAT</button>';
                            return countDownTime;
                        }
                        else if(isNaN(minutes))
                        {
                            countDownTime = '<a class="btn btn-xs btn-success btn-block" data-toggle="modal" data-target="#dispatch_modal" disabled><i class="glyphicon glyphicon-ok"></i> RECEIVED</a>';
                            return countDownTime;
                        }
                        else if(minutes<0)
                        {
                            countDownTime = '<button class="btn btn-warning btn-xs btn-block" disabled>UPDATING INFO..</button>';
                            return countDownTime;
                        }
                        else
                        {
                            return countDownTime;
                        }
                    },
                    'orderable' : false,
                    'searchable' : true,
                    "name": 'endorsements.endorsement_status_external',
                    "className": "text-center"
                },
                {
                    data: function notes(data)
                    {
                        if(splitterdata.indexOf('(View)') >= 0)
                        {
                            return '<button href="'+ data.id + '" class="btn btn-xs btn-primary btn-block" id="btnFullViewInfo-success" data-toggle="modal" data-target="#modal-view-info-client">VIEW INFO</button>';

                        }
                        else
                        {
                            return '<a class="btn btn-xs btn-warning btn-block" href="client-view-file?id='+btoa(data.id)+'" target="_blank" onclick="setTimeout(function(){tableFinishAccountRead.draw()},3000);"><i class="glyphicon glyphicon-eye-open"></i> VIEW FILE</a>' +
                                '<button href="'+ data.id + '" class="btn btn-xs btn-primary btn-block" id="btnFullViewInfo-success" data-toggle="modal" data-target="#modal-view-info-client">VIEW INFO</button>' +
                                ' <a name="'+data.id+'" class="btn btn-xs btn-success btn-block" id="btnDownloadReport-read" onclick="setTimeout(function(){tableFinishAccountRead.draw()},3000);"><i class="glyphicon glyphicon-download-alt"></i> DOWNLOAD</a>';
                        }
                    },
                    'orderable' : false,
                    'searchable' : false,
                    "name": 'nonotes',
                    "className": "text-center"
                }
            ],
        "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull)
        {
            if ( aData.endorsement_status_external == "TAT" )
            {
                $('td', nRow).css('background-color', '#66ff66');
            }
            else if(aData.endorsement_status_external == "OVERDUE")
            {
                $('td', nRow).css('background-color', '#ff9980');
            }
        },
        "order": [[0, 'desc']],
        "pageLength": 10,
        "lengthMenu": [[2, 10, 25, 50, -1], ['2 rows', '10 rows', '25 rows', '50 rows', 'Show all']],
        "bSortClasses": false,
        "deferRender": true,
        initComplete: function()
        {
            $('#client-finish-read thead th').each(function() {
                tableFinishAccountReadTitle[tableFinishAccountReadTitleCount] = $(this).text();
                tableFinishAccountReadTitleCount++;
                var title = $(this).text();
                if(title == 'Actions')
                {

                }
                else {
                    $(this).html(title + '<br><input type="text" placeholder="Search" style="position: relative; width: 100%">');
                }
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

    $('#client-finish-read_filter input').unbind();
    $('#client-finish-read_filter input').bind('keyup change',function (e) {

        if($(this).is(':focus'))
        {
            if (e.keyCode == 13) {
                tableFinishAccountRead.search($(this).val()).draw();
            }
        }
    });
}

function finish_accounts_table_downloaded() {
    tableFinishAccountDownloaded = $('#client-finish-downlaoded').DataTable
    ({
        "responsive": true,
        "processing": true,
        "serverSide": true,
        "ajax":
            {
                url: "client-get-finish-account-downloaded",
                data: function (d)
                {
                    d.min_date_endorsed = $('#minFinish-download').val();
                    d.max_date_endorsed = $('#maxFinish-download').val();
                }
            },
        dom: 'Blfrtip',
        buttons:
            [
                {
                    extend: 'pdf',
                    orientation: 'landscape',
                    pageSize: 'LEGAL',
                    exportOptions:
                        {
                            columns: ':visible',
                            format:
                                {
                                    header:  function (dt, idx, title)
                                    {
                                        return tableFinishAccountDownloadedTitle[(idx)];
                                    }
                                }
                        }
                },
                {
                    extend: 'excel',
                    exportOptions:
                        {
                            columns: ':visible',
                            format:
                                {
                                    header:  function (dt, idx, title)
                                    {
                                        return tableFinishAccountDownloadedTitle[(idx)];
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
                                        return tableFinishAccountDownloadedTitle[(idx)];
                                    }
                                }
                        }
                },
                {
                    extend: 'colvis',
                    text: 'Show/Hide Column',
                    columnText: function (dt, idx, title)
                    {
                        return tableFinishAccountDownloadedTitle[(idx)];
                    }
                }
            ],
        "columns":
            [
                {data: 'id', name: 'endorsements.id'},
                {data: 'account_name', name: 'endorsements.account_name',"className": "text-center"},
                {data: 'date_endorsed', name: 'endorsements.date_endorsed',"className": "text-center"},
                {data: 'time_endorsed', name: 'endorsements.time_endorsed',"className": "text-center"},
                {data: 'address', name: 'endorsements.address'},
                {data: 'muni_name', name: 'municipalities.muni_name',"className": "text-center"},
                {data: 'name', name: 'provinces.name',"className": "text-center"},
                {data: 'type_of_request', name: 'endorsements.type_of_request'},
                {data: 'type_of_loan', name: 'endorsements.type_of_loan'},
                // {
                //
                //     data: function actions(data) {
                //
                //         clearTimeout(times);
                //         fetchOtherInro('client-finish-account');
                //         return '<span id="otherinfo'+data.id+'">'+data.type_of_request+'</span>';
                //
                //     },
                //     'name' : 'endorsements.type_of_request'
                // },
                {data: 'requestor_name', name: 'endorsements.requestor_name', "className": "text-center"},
                {data: 'client_remarks', name: 'endorsements.client_remarks', "className": "text-center"},
                {data: 're_ci', name: 'endorsements.re_ci', "className": "text-center"},
                {
                    data: function acctStatus(data)
                    {
                        var toShow = '';
                        if(data.acct_status == '')
                        {
                            toShow =  '<a class="btn btn-xs btn-success btn-block" data-toggle="modal" data-target="#dispatch_modal" disabled><i class="glyphicon glyphicon-ok"></i> RECEIVED</a>';
                        }
                        else if(data.acct_status == 1)
                        {
                            toShow =  '<a class="btn btn-xs btn-warning btn-block" data-toggle="modal" data-target="#dispatch_modal" disabled><i class="glyphicon glyphicon-retweet"></i> ON FIELD</a>';
                        }
                        else if(data.acct_status == 2)
                        {
                            toShow = '<a class="btn btn-xs btn-warning btn-block" data-toggle="modal" data-target="#dispatch_modal" disabled><i class="glyphicon glyphicon-retweet"></i> FOR SENDING</a>';
                        }
                        else if(data.acct_status == 3)
                        {
                            toShow = '<a class="btn btn-xs btn-success btn-block" data-toggle="modal" data-target="#dispatch_modal" disabled><i class="glyphicon glyphicon-envelope"></i> SENT</a>';
                        }
                        else if(data.acct_status == 4)
                        {
                            toShow = '<a class="btn btn-xs btn-primary btn-block" data-toggle="modal" data-target="#dispatch_modal" disabled><i class="glyphicon glyphicon-remove"></i> HOLD ACCT</a>';
                        }
                        else if(data.acct_status == 5)
                        {
                            toShow = '<a class="btn btn-xs btn-primary btn-block" data-toggle="modal" data-target="#dispatch_modal" disabled><i class="glyphicon glyphicon-remove"></i> CANCEL ACCT</a>';
                        }

                        return toShow + '<br><span>Date and Time Sent:</span><br><br><span><b>'+data.date_forward+' '+data.time_forward+'</b></span>';
                    },
                    'orderable' : false,
                    'searchable' : false,
                    "name": 'acct_status',
                    "className": "text-center"
                },
                {
                    data: function externalStatus(data)
                    {
                        var countDownDate = new Date(data.date_due+' '+data.time_due);
                        var now = new Date();
                        var distance = countDownDate - now;

                        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                        countDownTime = '<button class="btn btn-success btn-xs btn-block" disabled>'+ days + "D " + hours + "H " + minutes + "M "+'</button>';

                        if(data.acct_status == 4)
                        {
                            return '<a class="btn btn-xs btn-primary btn-block" data-toggle="modal" data-target="#dispatch_modal" disabled><i class="glyphicon glyphicon-remove"></i> HOLD ACCT</a>';
                        }
                        else if(data.acct_status == 5)
                        {
                            return '<a class="btn btn-xs btn-primary btn-block" data-toggle="modal" data-target="#dispatch_modal" disabled><i class="glyphicon glyphicon-remove"></i> CANCEL ACCT</a>';
                        }
                        else if(data.endorsement_status_external==="OVERDUE")
                        {
                            countDownTime = '<button class="btn btn-danger btn-xs btn-block" disabled>OVERDUE</button>';
                            return countDownTime;
                        }
                        else if(data.endorsement_status_external==="TAT")
                        {
                            countDownTime = '<button class="btn btn-success btn-xs btn-block" disabled>ON TAT</button>';
                            return countDownTime;
                        }
                        else if(isNaN(minutes))
                        {
                            countDownTime = '<a class="btn btn-xs btn-success btn-block" data-toggle="modal" data-target="#dispatch_modal" disabled><i class="glyphicon glyphicon-ok"></i> RECEIVED</a>';
                            return countDownTime;
                        }
                        else if(minutes<0)
                        {
                            countDownTime = '<button class="btn btn-warning btn-xs btn-block" disabled>UPDATING INFO..</button>';
                            return countDownTime;
                        }
                        else
                        {
                            return countDownTime;
                        }
                    },
                    'orderable' : false,
                    'searchable' : true,
                    "name": 'endorsements.endorsement_status_external',
                    "className": "text-center"
                },
                {
                    data: function notes(data)
                    {
                        if(splitterdata.indexOf('(View)') >= 0)
                        {
                            return '<button href="'+ data.id + '" class="btn btn-xs btn-primary btn-block" id="btnFullViewInfo-success" data-toggle="modal" data-target="#modal-view-info-client">VIEW INFO</button>';

                        }
                        else
                        {
                            return '<a class="btn btn-xs btn-warning btn-block" href="client-view-file?id='+btoa(data.id)+'" target="_blank" onclick="setTimeout(function(){tableFinishAccountDownloaded.draw()},3000);"><i class="glyphicon glyphicon-eye-open"></i> VIEW FILE</a>' +
                                '<button href="'+ data.id + '" class="btn btn-xs btn-primary btn-block" id="btnFullViewInfo-success" data-toggle="modal" data-target="#modal-view-info-client">VIEW INFO</button>' +
                                ' <a name="'+data.id+'" class="btn btn-xs btn-success btn-block" id="btnDownloadReport-download" onclick="setTimeout(function(){tableFinishAccountDownloaded.draw()}, 3000);"><i class="glyphicon glyphicon-download-alt"></i> DOWNLOAD</a>';
                        }
                    },
                    'orderable' : false,
                    'searchable' : false,
                    "name": 'nonotes',
                    "className": "text-center"
                },
                {data : 'date_forward', name : 'endorsements.date_forwarded_to_client', visible : false},
                {data : 'time_forward', name : 'endorsements.time_forwarded_to_client', visible : false}

            ],
        "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull)
        {
            if ( aData.endorsement_status_external == "TAT" )
            {
                $('td', nRow).css('background-color', '#66ff66');
            }
            else if(aData.endorsement_status_external == "OVERDUE")
            {
                $('td', nRow).css('background-color', '#ff9980');
            }
        },
        "order": [[0, 'desc']],
        "pageLength": 10,
        "lengthMenu": [[2, 10, 25, 50, -1], ['2 rows', '10 rows', '25 rows', '50 rows', 'Show all']],
        "bSortClasses": false,
        "deferRender": true,
        initComplete: function()
        {
            $('#client-finish-downlaoded thead th').each(function() {
                tableFinishAccountDownloadedTitle[tableFinishAccountDownloadedCount] = $(this).text();
                tableFinishAccountDownloadedCount++;
                var title = $(this).text();
                if(title == 'Actions')
                {

                }
                else {
                    $(this).html(title + '<br><input type="text" placeholder="Search" style="position: relative; width: 100%">');
                }
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

    $('#client-finish-downlaoded_filter input').unbind();
    $('#client-finish-downlaoded_filter input').bind('keyup change',function (e) {

        if($(this).is(':focus'))
        {
            if (e.keyCode == 13) {
                tableFinishAccountDownloaded.search($(this).val()).draw();
            }
        }
    });
}

function finish_accounts_table()
{


    tableFinishAccount = $('#client-finish-account').DataTable
    ({
        "responsive": true,
        "processing": true,
        "serverSide": true,
        "ajax":
            {
                url: "/client-get-finish-account",
                data: function (d)
                {

                    console.log($('#minFinish').val())
                    console.log($('#maxFinish').val())

                    d.min_date_endorsed = $('#minFinish').val();
                    d.max_date_endorsed = $('#maxFinish').val();
                }
            },
        dom: 'Blfrtip',
        buttons:
            [
                {
                    extend: 'pdf',
                    orientation: 'landscape',
                    pageSize: 'LEGAL',
                    exportOptions:
                        {
                            columns: ':visible',
                            format:
                                {
                                    header:  function (dt, idx, title)
                                    {
                                        return titleee2[(idx)];
                                    }
                                }
                        }
                },
                {
                    extend: 'excel',
                    exportOptions:
                        {
                            columns: ':visible',
                            format:
                                {
                                    header:  function (dt, idx, title)
                                    {
                                        return titleee2[(idx)];
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
                                        return titleee2[(idx)];
                                    }
                                }
                        }
                },
                {
                    extend: 'colvis',
                    text: 'Show/Hide Column',
                    columnText: function (dt, idx, title)
                    {
                        return titleee2[(idx)];
                    }
                }
            ],
        "columns":
            [
                {data: 'id', name: 'endorsements.id'},
                {data: 'account_name', name: 'endorsements.account_name',"className": "text-center"},
                {data: 'date_endorsed', name: 'endorsements.date_endorsed',"className": "text-center"},
                {data: 'time_endorsed', name: 'endorsements.time_endorsed',"className": "text-center"},
                {data: 'address', name: 'endorsements.address'},
                {data: 'muni_name', name: 'municipalities.muni_name',"className": "text-center"},
                {data: 'name', name: 'provinces.name',"className": "text-center"},
                {data: 'type_of_request', name: 'endorsements.type_of_request'},
                {data: 'type_of_loan', name: 'endorsements.type_of_loan'},
               
                // {
                //
                //     data: function actions(data) {
                //
                //         clearTimeout(times);
                //         fetchOtherInro('client-finish-account');
                //         return '<span id="otherinfo'+data.id+'">'+data.type_of_request+'</span>';
                //
                //     },
                //     'name' : 'endorsements.type_of_request'
                // },
                {data: 'requestor_name', name: 'endorsements.requestor_name', "className": "text-center"},
                {data: 'client_remarks', name: 'endorsements.client_remarks', "className": "text-center"},
                {data: 're_ci', name: 'endorsements.re_ci', "className": "text-center"},
                {
                    data: function acctStatus(data)
                    {
                        if(data.acct_status == '')
                        {
                            return '<a class="btn btn-xs btn-success btn-block" data-toggle="modal" data-target="#dispatch_modal" disabled><i class="glyphicon glyphicon-ok"></i> RECEIVED</a>';
                        }
                        else if(data.acct_status == 1)
                        {
                            return '<a class="btn btn-xs btn-warning btn-block" data-toggle="modal" data-target="#dispatch_modal" disabled><i class="glyphicon glyphicon-retweet"></i> ON FIELD</a>';
                        }
                        else if(data.acct_status == 2)
                        {
                            return '<a class="btn btn-xs btn-warning btn-block" data-toggle="modal" data-target="#dispatch_modal" disabled><i class="glyphicon glyphicon-retweet"></i> FOR SENDING</a>';
                        }
                        else if(data.acct_status == 3)
                        {
                            return '<a class="btn btn-xs btn-success btn-block" data-toggle="modal" data-target="#dispatch_modal" disabled><i class="glyphicon glyphicon-envelope"></i> SENT</a>';
                        }
                        else if(data.acct_status == 4)
                        {
                            return '<a class="btn btn-xs btn-primary btn-block" data-toggle="modal" data-target="#dispatch_modal" disabled><i class="glyphicon glyphicon-remove"></i> HOLD ACCT</a>';
                        }
                        else if(data.acct_status == 5)
                        {
                            return '<a class="btn btn-xs btn-primary btn-block" data-toggle="modal" data-target="#dispatch_modal" disabled><i class="glyphicon glyphicon-remove"></i> CANCEL ACCT</a>';
                        }

                    },
                    'orderable' : false,
                    'searchable' : false,
                    "name": 'acct_status',
                    "className": "text-center"
                },
                {
                    data: function externalStatus(data)
                    {
                        var countDownDate = new Date(data.date_due+' '+data.time_due);
                        var now = new Date();
                        var distance = countDownDate - now;

                        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                        countDownTime = '<button class="btn btn-success btn-xs btn-block" disabled>'+ days + "D " + hours + "H " + minutes + "M "+'</button>';

                        if(data.acct_status == 4)
                        {
                            return '<a class="btn btn-xs btn-primary btn-block" data-toggle="modal" data-target="#dispatch_modal" disabled><i class="glyphicon glyphicon-remove"></i> HOLD ACCT</a>';
                        }
                        else if(data.acct_status == 5)
                        {
                            return '<a class="btn btn-xs btn-primary btn-block" data-toggle="modal" data-target="#dispatch_modal" disabled><i class="glyphicon glyphicon-remove"></i> CANCEL ACCT</a>';
                        }
                        else if(data.endorsement_status_external==="OVERDUE")
                        {
                            countDownTime = '<button class="btn btn-danger btn-xs btn-block" disabled>OVERDUE</button>';
                            return countDownTime;
                        }
                        else if(data.endorsement_status_external==="TAT")
                        {
                            countDownTime = '<button class="btn btn-success btn-xs btn-block" disabled>ON TAT</button>';
                            return countDownTime;
                        }
                        else if(isNaN(minutes))
                        {
                            countDownTime = '<a class="btn btn-xs btn-success btn-block" data-toggle="modal" data-target="#dispatch_modal" disabled><i class="glyphicon glyphicon-ok"></i> RECEIVED</a>';
                            return countDownTime;
                        }
                        else if(minutes<0)
                        {
                            countDownTime = '<button class="btn btn-warning btn-xs btn-block" disabled>UPDATING INFO..</button>';
                            return countDownTime;
                        }
                        else
                        {
                            return countDownTime;
                        }
                    },
                    'orderable' : false,
                    'searchable' : true,
                    "name": 'endorsements.endorsement_status_external',
                    "className": "text-center"
                },
                {
                    data: function notes(data)
                    {
                        if(splitterdata.indexOf('(View)') >= 0)
                        {
                            return '<a href="'+ data.id + '" class="btn btn-xs btn-primary btn-block" id="btnFullViewInfo" data-toggle="modal" data-target="#modal-view-info-client">VIEW INFO</a>';

                        }
                        else
                        {
                            return '<a class="btn btn-xs btn-warning btn-block" href="client-view-file?id='+btoa(data.id)+'" target="_blank" onclick="setTimeout(function(){tableFinishAccount.draw()},3000);"><i class="glyphicon glyphicon-eye-open"></i> VIEW FILE</a>' +
                                '<a href="'+ data.id + '" class="btn btn-xs btn-primary btn-block" id="btnFullViewInfo" data-toggle="modal" data-target="#modal-view-info-client">VIEW INFO</a>' +
                                ' <a name="'+data.id+'" class="btn btn-xs btn-success btn-block" id="btnDownloadReport" onlick="setTimeout(function(){tableFinishAccount.draw()});"><i class="glyphicon glyphicon-download-alt"></i> DOWNLOAD</a>';
                        }
                    },
                    'orderable' : false,
                    'searchable' : false,
                    "name": 'nonotes',
                    "className": "text-center"
                }
            ],
        "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull)
        {
            if ( aData.endorsement_status_external == "TAT" )
            {
                $('td', nRow).css('background-color', '#66ff66');
            }
            else if(aData.endorsement_status_external == "OVERDUE")
            {
                $('td', nRow).css('background-color', '#ff9980');
            }
        },
        "order": [[0, 'desc']],
        "pageLength": 10,
        "lengthMenu": [[2, 10, 25, 50, -1], ['2 rows', '10 rows', '25 rows', '50 rows', 'Show all']],
        "bSortClasses": false,
        "deferRender": true,
        initComplete: function()
        {
            $('#client-finish-account thead th').each(function() {
                titleee2[i2] = $(this).text();
                i2++;
                var title = $(this).text();
                if(title == 'Actions')
                {

                }
                else {
                    $(this).html(title + '<br><input type="text" placeholder="Search" style="position: relative; width: 100%">');
                }
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

    $('#client-finish-account_filter input').unbind();
    $('#client-finish-account_filter input').bind('keyup change',function (e) {

        if($(this).is(':focus'))
        {
            if (e.keyCode == 13) {
                tableFinishAccount.search($(this).val()).draw();
            }
        }
    });
}

function hold_accounts_table() {
    tableHoldAccount = $('#client-hold-account').DataTable
    ({
        "responsive": true,
        "processing": true,
        "serverSide": true,
        "ajax":
            {
                url: "/client-get-hold-account",
                data: function (d)
                {
                    d.min_date_endorsed = $('#minHold').val();
                    d.max_date_endorsed = $('#maxHold').val();
                }
            },
        dom: 'Blfrtip',
        buttons:
            [
                {
                    extend: 'pdf',
                    orientation: 'landscape',
                    pageSize: 'LEGAL',
                    exportOptions:
                        {
                            columns: ':visible',
                            format:
                                {
                                    header:  function (dt, idx, title)
                                    {
                                        return titleee3[(idx)];
                                    }
                                }
                        }
                },
                {
                    extend: 'excel',
                    exportOptions:
                        {
                            columns: ':visible',
                            format:
                                {
                                    header:  function (dt, idx, title)
                                    {
                                        return titleee3[(idx)];
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
                                        return titleee3[(idx)];
                                    }
                                }
                        }
                },
                {
                    extend: 'colvis',
                    text: 'Show/Hide Column',
                    columnText: function (dt, idx, title)
                    {
                        return titleee3[(idx)];
                    }
                }
            ],
        "columns":
            [
                {data: 'id', name: 'endorsements.id'},
                {data: 'account_name', name: 'endorsements.account_name',"className": "text-center"},
                {data: 'date_endorsed', name: 'endorsements.date_endorsed',"className": "text-center"},
                {data: 'time_endorsed', name: 'endorsements.time_endorsed',"className": "text-center"},
                {data: 'address', name: 'endorsements.address'},
                {data: 'muni_name', name: 'municipalities.muni_name',"className": "text-center"},
                {data: 'name', name: 'provinces.name',"className": "text-center"},
                {data: 'type_of_request', name: 'endorsements.type_of_request'},
                {data: 'type_of_loan', name: 'endorsements.type_of_loan'},
                // {
                //
                //     data: function actions(data) {
                //
                //         clearTimeout(times);
                //         fetchOtherInro('client-hold-account');
                //         return '<span id="otherinfo'+data.id+'">'+data.type_of_request+'</span>';
                //
                //     },
                //     'name' : 'endorsements.type_of_request'
                // },
                {data: 'requestor_name', name: 'endorsements.requestor_name', "className": "text-center"},
                {data: 'client_remarks', name: 'endorsements.client_remarks', "className": "text-center"},
                {data: 're_ci', name: 'endorsements.re_ci', "className": "text-center"},
                {
                    data: function acctStatus(data)
                    {
                        if(data.acct_status == '')
                        {
                            return '<a class="btn btn-xs btn-success btn-block" data-toggle="modal" data-target="#dispatch_modal" disabled><i class="glyphicon glyphicon-ok"></i> RECEIVED</a>';
                        }
                        else if(data.acct_status == 1)
                        {
                            return '<a class="btn btn-xs btn-warning btn-block" data-toggle="modal" data-target="#dispatch_modal" disabled><i class="glyphicon glyphicon-retweet"></i> ON FIELD</a>';
                        }
                        else if(data.acct_status == 2)
                        {
                            return '<a class="btn btn-xs btn-warning btn-block" data-toggle="modal" data-target="#dispatch_modal" disabled><i class="glyphicon glyphicon-retweet"></i> FOR SENDING</a>';
                        }
                        else if(data.acct_status == 3)
                        {
                            return '<a class="btn btn-xs btn-success btn-block" data-toggle="modal" data-target="#dispatch_modal" disabled><i class="glyphicon glyphicon-envelope"></i> SENT</a>';
                        }
                        else if(data.acct_status == 4)
                        {
                            return '<a class="btn btn-xs btn-primary btn-block" data-toggle="modal" data-target="#dispatch_modal" disabled><i class="glyphicon glyphicon-remove"></i> HOLD ACCT</a>';
                        }
                        else if(data.acct_status == 5)
                        {
                            return '<a class="btn btn-xs btn-primary btn-block" data-toggle="modal" data-target="#dispatch_modal" disabled><i class="glyphicon glyphicon-remove"></i> CANCEL ACCT</a>';
                        }
                    },
                    'orderable' : false,
                    'searchable' : false,
                    "name": 'acct_status',
                    "className": "text-center"
                },
                {
                    data: function externalStatus(data)
                    {
                        var countDownDate = new Date(data.date_due+' '+data.time_due);
                        var now = new Date();
                        var distance = countDownDate - now;

                        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                        countDownTime = '<button class="btn btn-success btn-xs btn-block" disabled>'+ days + "D " + hours + "H " + minutes + "M "+'</button>';

                        if(data.acct_status == 4)
                        {
                            return '<a class="btn btn-xs btn-primary btn-block" data-toggle="modal" data-target="#dispatch_modal" disabled><i class="glyphicon glyphicon-remove"></i> HOLD ACCT</a>';
                        }
                        else if(data.acct_status == 5)
                        {
                            return '<a class="btn btn-xs btn-primary btn-block" data-toggle="modal" data-target="#dispatch_modal" disabled><i class="glyphicon glyphicon-remove"></i> CANCEL ACCT</a>';
                        }
                        else if(data.endorsement_status_external==="OVERDUE")
                        {
                            countDownTime = '<button class="btn btn-danger btn-xs btn-block" disabled>OVERDUE</button>';
                            return countDownTime;
                        }
                        else if(data.endorsement_status_external==="TAT")
                        {
                            countDownTime = '<button class="btn btn-success btn-xs btn-block" disabled>ON TAT</button>';
                            return countDownTime;
                        }
                        else if(isNaN(minutes))
                        {
                            countDownTime = '<a class="btn btn-xs btn-success btn-block" data-toggle="modal" data-target="#dispatch_modal" disabled><i class="glyphicon glyphicon-ok"></i> RECEIVED</a>';
                            return countDownTime;
                        }
                        else if(minutes<0)
                        {
                            countDownTime = '<button class="btn btn-warning btn-xs btn-block" disabled>UPDATING INFO..</button>';
                            return countDownTime;
                        }
                        else
                        {
                            return countDownTime;
                        }
                    },
                    'orderable' : false,
                    'searchable' : true,
                    "name": 'endorsements.endorsement_status_external',
                    "className": "text-center"
                },
                {
                    data: function notes(data)
                    {
                        return '<a href="'+ data.id + '" class="btn btn-xs btn-primary btn-block" id="btnFullViewInfo" data-toggle="modal" data-target="#modal-view-info-client">VIEW INFO</a>';
                    },
                    'orderable' : false,
                    'searchable' : false,
                    "name": 'nonotes',
                    "className": "text-center"
                }
            ],
        "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull)
        {
            if ( aData.endorsement_status_external == "TAT" )
            {
                $('td', nRow).css('background-color', '#66ff66');
            }
            else if(aData.endorsement_status_external == "OVERDUE")
            {
                $('td', nRow).css('background-color', '#ff9980');
            }
        },
        "order": [[0, 'desc']],
        "pageLength": 10,
        "lengthMenu": [[2, 10, 25, 50, -1], ['2 rows', '10 rows', '25 rows', '50 rows', 'Show all']],
        "bSortClasses": false,
        "deferRender": true,
        initComplete: function()
        {
            $('#client-hold-account thead th').each(function() {
                titleee3[i3] = $(this).text();
                $(this).unbind();
                i3++;
                var title = $(this).text();
                if(title == 'Actions')
                {

                }
                else
                {
                    $(this).html(title+'<br><input type="text" placeholder="Search" style="position: relative; width: 100%">');
                }
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
                        // else if (e.keyCode === 8)
                        // {
                        //     if (this.value == '') {
                        //         that
                        //             .search(this.value)
                        //             .draw();
                        //     }
                        // }
                    }
                });
            });
        }
    });

    $('#client-hold-account_filter input').unbind();
    $('#client-hold-account_filter input').bind('keyup change',function (e) {

        if($(this).is(':focus'))
        {
            if (e.keyCode == 13) {
                tableHoldAccount.search($(this).val()).draw();
            }
            // else if (e.keyCode === 8)
            // {
            //     if ($(this).val() == '') {
            //         tableHoldAccount.search($(this).val()).draw();
            //     }
            // }
        }
    });


}

function cancelled_accounts_table() {
    tableCancelAccount = $('#client-cancel-account').DataTable
    ({
        "responsive": true,
        "processing": true,
        "serverSide": true,
        "ajax":
            {
                url: "/client-get-cancel-account",
                data: function (d)
                {
                    d.min_date_endorsed = $('#minCancelled').val();
                    d.max_date_endorsed = $('#maxCancelled').val();
                }
            },
        dom: 'Blfrtip',
        buttons:
            [
                {
                    extend: 'pdf',
                    orientation: 'landscape',
                    pageSize: 'LEGAL',
                    exportOptions:
                        {
                            columns: ':visible',
                            format:
                                {
                                    header:  function (dt, idx, title)
                                    {
                                        return titleee4[(idx)];
                                    }
                                }
                        }
                },
                {
                    extend: 'excel',
                    exportOptions:
                        {
                            columns: ':visible',
                            format:
                                {
                                    header:  function (dt, idx, title)
                                    {
                                        return titleee4[(idx)];
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
                                        return titleee4[(idx)];
                                    }
                                }
                        }
                },
                {
                    extend: 'colvis',
                    text: 'Show/Hide Column',
                    columnText: function (dt, idx, title)
                    {
                        return titleee4[(idx)];
                    }
                }
            ],
        "columns":
            [
                {data: 'id', name: 'endorsements.id'},
                {data: 'account_name', name: 'endorsements.account_name',"className": "text-center"},
                {data: 'date_endorsed', name: 'endorsements.date_endorsed',"className": "text-center"},
                {data: 'time_endorsed', name: 'endorsements.time_endorsed',"className": "text-center"},
                {data: 'address', name: 'endorsements.address'},
                {data: 'muni_name', name: 'municipalities.muni_name',"className": "text-center"},
                {data: 'name', name: 'provinces.name',"className": "text-center"},
                {data: 'type_of_request', name: 'endorsements.type_of_request'},
                {data: 'type_of_loan', name: 'endorsements.type_of_loan'},
                // {
                //
                //     data: function actions(data) {
                //
                //         clearTimeout(times);
                //         fetchOtherInro('client-cancel-account');
                //         return '<span id="otherinfo'+data.id+'">'+data.type_of_request+'</span>';
                //
                //     },
                //     'name' : 'endorsements.type_of_request'
                // },
                {data: 'requestor_name', name: 'endorsements.requestor_name', "className": "text-center"},
                {data: 'client_remarks', name: 'endorsements.client_remarks', "className": "text-center"},
                {data: 're_ci', name: 'endorsements.re_ci', "className": "text-center"},
                {
                    data: function acctStatus(data)
                    {
                        if(data.acct_status == '')
                        {
                            return '<a class="btn btn-xs btn-success btn-block" data-toggle="modal" data-target="#dispatch_modal" disabled><i class="glyphicon glyphicon-ok"></i> RECEIVED</a>';
                        }
                        else if(data.acct_status == 1)
                        {
                            return '<a class="btn btn-xs btn-warning btn-block" data-toggle="modal" data-target="#dispatch_modal" disabled><i class="glyphicon glyphicon-retweet"></i> ON FIELD</a>';
                        }
                        else if(data.acct_status == 2)
                        {
                            return '<a class="btn btn-xs btn-warning btn-block" data-toggle="modal" data-target="#dispatch_modal" disabled><i class="glyphicon glyphicon-retweet"></i> FOR SENDING</a>';
                        }
                        else if(data.acct_status == 3)
                        {
                            return '<a class="btn btn-xs btn-success btn-block" data-toggle="modal" data-target="#dispatch_modal" disabled><i class="glyphicon glyphicon-envelope"></i> SENT</a>';
                        }
                        else if(data.acct_status == 4)
                        {
                            return '<a class="btn btn-xs btn-primary btn-block" data-toggle="modal" data-target="#dispatch_modal" disabled><i class="glyphicon glyphicon-remove"></i> HOLD ACCT</a>';
                        }
                        else if(data.acct_status == 5)
                        {
                            return '<a class="btn btn-xs btn-primary btn-block" data-toggle="modal" data-target="#dispatch_modal" disabled><i class="glyphicon glyphicon-remove"></i> CANCEL ACCT</a>';
                        }
                    },
                    'orderable' : false,
                    'searchable' : false,
                    "name": 'acct_status',
                    "className": "text-center"
                },
                {
                    data: function externalStatus(data)
                    {
                        var countDownDate = new Date(data.date_due+' '+data.time_due);
                        var now = new Date();
                        var distance = countDownDate - now;

                        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                        countDownTime = '<button class="btn btn-success btn-xs btn-block" disabled>'+ days + "D " + hours + "H " + minutes + "M "+'</button>';

                        if(data.acct_status == 4)
                        {
                            return '<a class="btn btn-xs btn-primary btn-block" data-toggle="modal" data-target="#dispatch_modal" disabled><i class="glyphicon glyphicon-remove"></i> HOLD ACCT</a>';
                        }
                        else if(data.acct_status == 5)
                        {
                            return '<a class="btn btn-xs btn-primary btn-block" data-toggle="modal" data-target="#dispatch_modal" disabled><i class="glyphicon glyphicon-remove"></i> CANCEL ACCT</a>';
                        }
                        else if(data.endorsement_status_external==="OVERDUE")
                        {
                            countDownTime = '<button class="btn btn-danger btn-xs btn-block" disabled>OVERDUE</button>';
                            return countDownTime;
                        }
                        else if(data.endorsement_status_external==="TAT")
                        {
                            countDownTime = '<button class="btn btn-success btn-xs btn-block" disabled>ON TAT</button>';
                            return countDownTime;
                        }
                        else if(isNaN(minutes))
                        {
                            countDownTime = '<a class="btn btn-xs btn-success btn-block" data-toggle="modal" data-target="#dispatch_modal" disabled><i class="glyphicon glyphicon-ok"></i> RECEIVED</a>';
                            return countDownTime;
                        }
                        else if(minutes<0)
                        {
                            countDownTime = '<button class="btn btn-warning btn-xs btn-block" disabled>UPDATING INFO..</button>';
                            return countDownTime;
                        }
                        else
                        {
                            return countDownTime;
                        }
                    },
                    'orderable' : false,
                    'searchable' : true,
                    "name": 'endorsements.endorsement_status_external',
                    "className": "text-center"
                },
                {
                    data: function notes(data)
                    {
                        return '<a href="'+ data.id + '" class="btn btn-xs btn-primary btn-block" id="btnFullViewInfo" data-toggle="modal" data-target="#modal-view-info-client">VIEW INFO</a>';
                    },
                    'orderable' : false,
                    'searchable' : false,
                    "name": 'nonotes',
                    "className": "text-center"
                }
            ],
        "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull)
        {
            if ( aData.endorsement_status_external == "TAT" )
            {
                $('td', nRow).css('background-color', '#66ff66');
            }
            else if(aData.endorsement_status_external == "OVERDUE")
            {
                $('td', nRow).css('background-color', '#ff9980');
            }
        },
        "order": [[0, 'desc']],
        "pageLength": 10,
        "lengthMenu": [[2, 10, 25, 50, -1], ['2 rows', '10 rows', '25 rows', '50 rows', 'Show all']],
        "bSortClasses": false,
        "deferRender": true,
        initComplete: function()
        {
            $('#client-cancel-account thead th').each(function() {
                titleee4[i4] = $(this).text();
                $(this).unbind();
                i4++;
                var title = $(this).text();
                if(title == 'Actions')
                {

                }
                else
                {
                    $(this).html(title+'<br><input type="text" placeholder="Search" style="position: relative; width: 100%">');
                }

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
                        // else if (e.keyCode === 8)
                        // {
                        //     if (this.value == '') {
                        //         that
                        //             .search(this.value)
                        //             .draw();
                        //     }
                        // }
                    }
                });
            });
        }

    });


    $('#client-cancel-account_filter input').unbind();
    $('#client-cancel-account_filter input').bind('keyup change',function (e) {

        if($(this).is(':focus'))
        {
            if (e.keyCode == 13) {
                tableCancelAccount.search($(this).val()).draw();
            }
            // else if (e.keyCode === 8)
            // {
            //     if ($(this).val() == '') {
            //         tableCancelAccount.search($(this).val()).draw();
            //     }
            // }
        }
    });


}

function revised_accounts_table() {
    tableRevisedAccount = $('#client-revised-account').DataTable
    ({
        "responsive": true,
        "processing": true,
        "serverSide": true,
        "ajax":
            {
                url: "/client-get-revised-account",
                data: function (d)
                {
                    d.min_date_endorsed = $('#minRevised').val();
                    d.max_date_endorsed = $('#maxRevised').val();
                }
            },
        dom: 'Blfrtip',
        buttons:
            [
                {
                    extend: 'pdf',
                    orientation: 'landscape',
                    pageSize: 'LEGAL',
                    exportOptions:
                        {
                            columns: ':visible',
                            format:
                                {
                                    header:  function (dt, idx, title)
                                    {
                                        return titleee5[(idx)];
                                    }
                                }
                        }
                },
                {
                    extend: 'excel',
                    exportOptions:
                        {
                            columns: ':visible',
                            format:
                                {
                                    header:  function (dt, idx, title)
                                    {
                                        return titleee5[(idx)];
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
                                        return titleee5[(idx)];
                                    }
                                }
                        }
                },
                {
                    extend: 'colvis',
                    text: 'Show/Hide Column',
                    columnText: function (dt, idx, title)
                    {
                        return titleee5[(idx)];
                    }
                }
            ],
        "columns":
            [
                {data: 'id', name: 'endorsements.id'},
                {data: 'account_name', name: 'endorsements.account_name',"className": "text-center"},
                {data: 'date_endorsed', name: 'endorsements.date_endorsed',"className": "text-center"},
                {data: 'time_endorsed', name: 'endorsements.time_endorsed',"className": "text-center"},
                {data: 'address', name: 'endorsements.address'},
                {data: 'muni_name', name: 'municipalities.muni_name',"className": "text-center"},
                {data: 'name', name: 'provinces.name',"className": "text-center"},
                {data: 'type_of_request', name: 'endorsements.type_of_request'},
                {data: 'type_of_loan', name: 'endorsements.type_of_loan'},
                // {
                //
                //     data: function actions(data) {
                //
                //         clearTimeout(times);
                //         fetchOtherInro('client-revised-account');
                //         return '<span id="otherinfo'+data.id+'">'+data.type_of_request+'</span>';
                //
                //     },
                //     'name' : 'endorsements.type_of_request'
                // },
                {data: 'requestor_name', name: 'endorsements.requestor_name', "className": "text-center"},
                {data: 'client_remarks', name: 'endorsements.client_remarks', "className": "text-center"},
                {data: 're_ci', name: 'endorsements.re_ci', "className": "text-center"},
                {
                    data: function acctStatus(data)
                    {

                        if(data.acct_status == 3)
                        {
                            return '<a class="btn btn-xs btn-warning btn-block" data-toggle="modal" data-target="#dispatch_modal" disabled><i class="glyphicon glyphicon-envelope"></i> REVISION</a>';
                        }
                        else
                        {
                            return '<a class="btn btn-xs btn-error btn-block" data-toggle="modal" data-target="#dispatch_modal" disabled><i class="glyphicon glyphicon-envelope"></i> ERROR</a>';

                        }

                    },
                    'orderable' : false,
                    'searchable' : false,
                    "name": 'acct_status',
                    "className": "text-center"
                },
                {
                    data: function externalStatus(data)
                    {
                        var countDownDate = new Date(data.date_due+' '+data.time_due);
                        var now = new Date();
                        var distance = countDownDate - now;

                        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                        countDownTime = '<button class="btn btn-success btn-xs btn-block" disabled>'+ days + "D " + hours + "H " + minutes + "M "+'</button>';

                        if(data.acct_status == 4)
                        {
                            return '<a class="btn btn-xs btn-primary btn-block" data-toggle="modal" data-target="#dispatch_modal" disabled><i class="glyphicon glyphicon-remove"></i> HOLD ACCT</a>';
                        }
                        else if(data.acct_status == 5)
                        {
                            return '<a class="btn btn-xs btn-primary btn-block" data-toggle="modal" data-target="#dispatch_modal" disabled><i class="glyphicon glyphicon-remove"></i> CANCEL ACCT</a>';
                        }
                        else if(data.endorsement_status_external==="OVERDUE")
                        {
                            countDownTime = '<button class="btn btn-danger btn-xs btn-block" disabled>OVERDUE</button>';
                            return countDownTime;
                        }
                        else if(data.endorsement_status_external==="TAT")
                        {
                            countDownTime = '<button class="btn btn-success btn-xs btn-block" disabled>ON TAT</button>';
                            return countDownTime;
                        }
                        else if(isNaN(minutes))
                        {
                            countDownTime = '<a class="btn btn-xs btn-success btn-block" data-toggle="modal" data-target="#dispatch_modal" disabled><i class="glyphicon glyphicon-ok"></i> RECEIVED</a>';
                            return countDownTime;
                        }
                        else if(minutes<0)
                        {
                            countDownTime = '<button class="btn btn-warning btn-xs btn-block" disabled>UPDATING INFO..</button>';
                            return countDownTime;
                        }
                        else
                        {
                            return countDownTime;
                        }
                    },
                    'orderable' : false,
                    'searchable' : true,
                    "name": 'endorsements.endorsement_status_external',
                    "className": "text-center"
                },
                {
                    data: function notes(data)
                    {
                        return '<a name="'+data.id+'" class="btn btn-xs btn-warning btn-block" id="btn_download_revision"> <i class="glyphicon glyphicon-download-alt"></i> DOWNLOAD REVISION</a><br>'+
                            '<a href="'+ data.id + '" class="btn btn-xs btn-primary btn-block" id="btnFullViewInfo" data-toggle="modal" data-target="#modal-view-info-client">VIEW INFO</a>';
                    },
                    'orderable' : false,
                    'searchable' : false,
                    "name": 'nonotes',
                    "className": "text-center"
                }
            ],
        "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull)
        {
            if ( aData.endorsement_status_external == "TAT" )
            {
                $('td', nRow).css('background-color', '#66ff66');
            }
            else if(aData.endorsement_status_external == "OVERDUE")
            {
                $('td', nRow).css('background-color', '#ff9980');
            }
        },
        "order": [[0, 'desc']],
        "pageLength": 10,
        "lengthMenu": [[2, 10, 25, 50, -1], ['2 rows', '10 rows', '25 rows', '50 rows', 'Show all']],
        "bSortClasses": false,
        "deferRender": true,
        initComplete: function()
        {
            $('#client-revised-account thead th').each(function() {
                titleee5[i5] = $(this).text();
                $(this).unbind();
                i5++;
                var title = $(this).text();
                if(title == 'Actions')
                {

                }
                else
                {
                    $(this).html(title+'<br><input type="text" placeholder="Search" style="position: relative; width: 100%">');
                }

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
                        // else if (e.keyCode === 8)
                        // {
                        //     if (this.value == '') {
                        //         that
                        //             .search(this.value)
                        //             .draw();
                        //     }
                        // }
                    }
                });
            });
        }

    });

    $('#client-revised-account_filter input').unbind();
    $('#client-revised-account_filter input').bind('keyup change',function (e) {

        if($(this).is(':focus'))
        {
            if (e.keyCode == 13) {
                tableRevisedAccount.search($(this).val()).draw();
            }
            // else if (e.keyCode === 8)
            // {
            //     if ($(this).val() == '') {
            //         tableRevisedAccount.search($(this).val()).draw();
            //     }
            // }
        }
    });

}


$(document).ready(function()
{

    $('#id_chat').remove();

    //if user is the requestor
    $.ajax
    ({
        method: 'get',
        url: 'client-check-requestor-user',
        data:
            {
                'id': '1'
            },
        success: function (data)
        {
            splitterdata = data;

            if(splitterdata.indexOf('(Client)') >= 1){
                // console.log('1');

                $('#sectionhide').attr('hidden','hidden');
                $('#dashroute').attr('hidden','hidden');
                $('#dashendorse').removeAttr('hidden');
            }
            else if(splitterdata.indexOf('(Supvr)') >= 1){
                // console.log('2');

                $('#sectionhide').removeAttr('hidden');
                $('#dashroute').removeAttr('hidden');
                $('#dashendorse').removeAttr('hidden');

            }
            else if(splitterdata.indexOf('(View)') >= 1){
                // console.log('3');

                // if(window.location.pathname === '/client-endorse-account')
                // {
                //     window.location = 'client-dashboard';
                // }
                $('#client_dasboard_tab').click();

                $('#sectionhide').removeAttr('hidden');
                $('#dashroute').removeAttr('hidden');
                $('#dashendorse').attr('hidden');
                $('#btnDownloadReport').remove();
                $('#txtNote').remove();
                $('#btnAddNote').remove();
            }
            else
            {

                $('#sectionhide').removeAttr('hidden');
                $('#dashroute').removeAttr('hidden');
                // $('#dashendorse').removeAttr('hidden');
                $('#dashendorse').removeAttr('hidden');

            }
        },
        complete : function () {
            fetchTemp();
        }
    });

    // fetchOtherInro('client-revised-account');
    // function fetchOtherInro(whattable) {
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
    //                 tdtor = tr.cells[7];
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



    var today = new Date();
    var yearmonth;
    var date;


    $('.date_range_container').css('display','none');

    $('#min').val('2015-01-01');
    $('#max').val('6000-01-01');

    $('#minFinish').val('2015-01-01');
    $('#maxFinish').val('6000-01-01');

    $('#minFinish-read').val('2015-01-01');
    $('#maxFinish-read').val('6000-01-01');

    $('#minFinish-download').val('2015-01-01');
    $('#maxFinish-download').val('6000-01-01');

    $('#minHold').val('2015-01-01');
    $('#maxHold').val('6000-01-01');


    $('#minCancelled').val('2015-01-01');
    $('#maxCancelled').val('6000-01-01');

    $('#minRevised').val('2015-01-01');
    $('#maxRevised').val('6000-01-01');




    // table.draw();
    // tableFinishAccount.draw();
    // tableHoldAccount.draw();
    // tableCancelAccount.draw();
    // tableRevisedAccount.draw();

    $('.viewable').click(function () {

        if($(this).is(":checked"))
        {
            if($(this).val() == 'All')
            {

                $('.viewable#rad_all1').prop('checked',true);
                $('.viewable#rad_all2').prop('checked',true);
                $('.viewable#rad_all3').prop('checked',true);
                $('.viewable#rad_all4').prop('checked',true);
                $('.viewable#rad_all5').prop('checked',true);
                $('.viewable#rad_allread').prop('checked',true);
                $('.viewable#rad_alldownload').prop('checked',true);

                $('.date_range_container').css('display','none');

                $('#min').val('2015-01-01');
                $('#max').val('6000-01-01');

                $('#minFinish').val('2015-01-01');
                $('#maxFinish').val('6000-01-01');

                $('#minFinish-read').val('2015-01-01');
                $('#maxFinish-read').val('6000-01-01');

                $('#minFinish-download').val('2015-01-01');
                $('#maxFinish-download').val('6000-01-01');


                $('#minHold').val('2015-01-01');
                $('#maxHold').val('6000-01-01');


                $('#minCancelled').val('2015-01-01');
                $('#maxCancelled').val('6000-01-01');

                $('#minRevised').val('2015-01-01');
                $('#maxRevised').val('6000-01-01');

                if(click_tab1)
                {
                    table.draw();
                }
                else if(click_tab2)
                {
                    // tableFinishAccount.draw();
                    if(new_accounts_tab)
                    {
                        tableFinishAccount.draw();
                    }

                    if(read_accounts_tab)
                    {
                        tableFinishAccountRead.draw();
                    }

                    if(finish_accounts_tab)
                    {
                        tableFinishAccountDownloaded.draw();
                    }
                }
                else if(click_tab3)
                {
                    tableHoldAccount.draw();
                }
                else if(click_tab4)
                {
                    tableCancelAccount.draw();
                }
                else if(click_tab5)
                {
                    tableRevisedAccount.draw();
                }
                // else if(new_accounts_tab)
                // {
                //     tableFinishAccount.draw();
                // }
                // else if(read_accounts_tab)
                // {
                //     tableFinishAccountRead.draw();
                // }
                // else if(finish_accounts_tab)
                // {
                //     tableFinishAccountDownloaded.draw();
                // }

            }
            else if($(this).val() == 'Date Range')
            {
                $('.viewable#rad_daterange1').prop('checked',true);
                $('.viewable#rad_daterange2').prop('checked',true);
                $('.viewable#rad_daterange3').prop('checked',true);
                $('.viewable#rad_daterange4').prop('checked',true);
                $('.viewable#rad_daterange5').prop('checked',true);
                $('.viewable#rad_daterangeread').prop('checked',true);
                $('.viewable#rad_daterangedownload').prop('checked',true);

                $('.date_range_container').css('display','');
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

                $( "#datepickerminFinish-read" ).datepicker({ dateFormat: 'yy-mm-dd' });
                $( "#datepickermaxFinish-read" ).datepicker({ dateFormat: 'yy-mm-dd' });

                $( "#datepickerminFinish-download" ).datepicker({ dateFormat: 'yy-mm-dd' });
                $( "#datepickermaxFinish-download" ).datepicker({ dateFormat: 'yy-mm-dd' });

                $( "#datepickerminHold" ).datepicker({ dateFormat: 'yy-mm-dd' });
                $( "#datepickermaxHold" ).datepicker({ dateFormat: 'yy-mm-dd' });

                $( "#datepickerminCancelled" ).datepicker({ dateFormat: 'yy-mm-dd' });
                $( "#datepickermaxCancelled" ).datepicker({ dateFormat: 'yy-mm-dd' });

                $( "#datepickerminRevised" ).datepicker({ dateFormat: 'yy-mm-dd' });
                $( "#datepickermaxRevised" ).datepicker({ dateFormat: 'yy-mm-dd' });

                $('#datepicker').val(month+dateyear);
                $('#datepickermax').val(month+dateyear);

                $('#datepickerminFinish').val(month+dateyear);
                $('#datepickermaxFinish').val(month+dateyear);

                $('#datepickerminFinish-read').val(month+dateyear);
                $('#datepickermaxFinish-read').val(month+dateyear);

                $('#datepickerminFinish-download').val(month+dateyear);
                $('#datepickermaxFinish-download').val(month+dateyear);

                $('#datepickerminHold').val(month+dateyear);
                $('#datepickermaxHold').val(month+dateyear);

                $('#datepickerminCancelled').val(month+dateyear);
                $('#datepickermaxCancelled').val(month+dateyear);

                $( "#datepickerminRevised" ).datepicker({ dateFormat: 'yy-mm-dd' });
                $( "#datepickermaxRevised" ).datepicker({ dateFormat: 'yy-mm-dd' });

                $('#min').val(yearmonth+date);
                $('#max').val(yearmonth+date);

                $('#minFinish').val(yearmonth+date);
                $('#maxFinish').val(yearmonth+date);

                $('#minFinish-read').val(yearmonth+date);
                $('#maxFinish-read').val(yearmonth+date);

                $('#minFinish-download').val(yearmonth+date);
                $('#maxFinish-download').val(yearmonth+date);


                $('#minHold').val(yearmonth+date);
                $('#maxHold').val(yearmonth+date);


                $('#minCancelled').val(yearmonth+date);
                $('#maxCancelled').val(yearmonth+date);

                $('#minRevised').val(yearmonth+date);
                $('#maxRevised').val(yearmonth+date);


                if(click_tab1)
                {
                    table.draw();
                }
                else if(click_tab2)
                {
                    // tableFinishAccount.draw();
                    if(new_accounts_tab)
                    {
                        tableFinishAccount.draw();
                    }

                    if(read_accounts_tab)
                    {
                        tableFinishAccountRead.draw();
                    }

                    if(finish_accounts_tab)
                    {
                        tableFinishAccountDownloaded.draw();
                    }
                }
                else if(click_tab3)
                {
                    tableHoldAccount.draw();
                }
                else if(click_tab4)
                {
                    tableCancelAccount.draw();
                }
                else if(click_tab5)
                {
                    tableRevisedAccount.draw();
                }
                // else if(new_accounts_tab)
                // {
                //     tableFinishAccount.draw();
                // }
                // else if(read_accounts_tab)
                // {
                //     tableFinishAccountRead.draw();
                // }
                // else if(finish_accounts_tab)
                // {
                //     tableFinishAccountDownloaded.draw();
                // }

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

    } );

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

        tableFinishAccount.draw();
    } );
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

        tableFinishAccount.draw();
    } );

    //hold datepickerminHold
    $('#datepickerminHold').change( function() {

        var minHol = $.datepicker.formatDate('yy-mm-dd', $('#datepickerminHold').datepicker('getDate'));
        console.log(minHol);
        $('#minHold').val(minHol);

        var maxHol = $.datepicker.formatDate('yy-mm-dd', $('#datepickermaxHold').datepicker('getDate'));
        console.log(maxHol);

        if(maxHol === '')
        {
            $('#maxHold').val(yearmonth+date);

        }
        else {
            $('#maxHold').val(maxHol);
        }

        tableHoldAccount.draw();

    } );
    $('#datepickermaxHold').change( function() {

        var minHol = $.datepicker.formatDate('yy-mm-dd', $('#datepickerminHold').datepicker('getDate'));
        console.log(minHol);
        $('#minHold').val(minHol);

        var maxHol = $.datepicker.formatDate('yy-mm-dd', $('#datepickermaxHold').datepicker('getDate'));
        console.log(maxHol);

        if(maxHol === '')
        {
            $('#maxHold').val(yearmonth+date);

        }
        else {
            $('#maxHold').val(maxHol);
        }


        tableHoldAccount.draw();

    } );

    //cancelled
    $('#datepickerminCancelled').change( function() {

        var minCan = $.datepicker.formatDate('yy-mm-dd', $('#datepickerminCancelled').datepicker('getDate'));
        console.log(minCan);
        $('#minCancelled').val(minCan);

        var maxCan = $.datepicker.formatDate('yy-mm-dd', $('#datepickermaxCancelled').datepicker('getDate'));
        console.log(maxCan);

        if(maxCan === '')
        {
            $('#maxCancelled').val(yearmonth+date);

        }
        else {
            $('#maxCancelled').val(maxCan);

        }

        tableCancelAccount.draw();

    } );
    $('#datepickermaxCancelled').change( function() {

        var minCan = $.datepicker.formatDate('yy-mm-dd', $('#datepickerminCancelled').datepicker('getDate'));
        console.log(minCan);
        $('#minCancelled').val(minCan);

        var maxCan = $.datepicker.formatDate('yy-mm-dd', $('#datepickermaxCancelled').datepicker('getDate'));
        console.log(maxCan);

        if(maxCan === '')
        {
            $('#maxCancelled').val(yearmonth+date);

        }
        else {
            $('#maxCancelled').val(maxCan);

        }

        tableCancelAccount.draw();

    } );

    //revised
    $('#datepickermaxRevised').change( function() {

        var minRev = $.datepicker.formatDate('yy-mm-dd', $('#datepickerminRevised').datepicker('getDate'));
        console.log(minRev);
        $('#minRevised').val(minRev);

        var maxRev = $.datepicker.formatDate('yy-mm-dd', $('#datepickermaxRevised').datepicker('getDate'));
        console.log(maxRev);

        if(maxRev === '')
        {
            $('#maxRevised').val(yearmonth+date);

        }
        else {
            $('#maxRevised').val(maxRev);

        }

        tableRevisedAccount.draw();

    } );
    $('#datepickermaxCancelled').change( function() {

        var minRev = $.datepicker.formatDate('yy-mm-dd', $('#datepickerminCancelled').datepicker('getDate'));
        console.log(minRev);
        $('#minCancelled').val(minRev);

        var maxRev = $.datepicker.formatDate('yy-mm-dd', $('#datepickermaxCancelled').datepicker('getDate'));
        console.log(maxRev);

        if(maxRev === '')
        {
            $('#maxCancelled').val(yearmonth+date);

        }
        else {
            $('#maxCancelled').val(maxRev);

        }

        tableRevisedAccount.draw();

    } );


    $('.viewable#rad_all1').prop('checked',true);
    $('.viewable#rad_all2').prop('checked',true);
    $('.viewable#rad_all3').prop('checked',true);
    $('.viewable#rad_all4').prop('checked',true);
    $('.viewable#rad_all5').prop('checked',true);
    $('.viewable#rad_allread').prop('checked',true);
    $('.viewable#rad_alldownload').prop('checked',true);




    setInterval(function ()
    {
        if(interval)
        {
            if(click_tab1)
            {
                table.ajax.reload(null, false);
            }
            else if(click_tab2)
            {
                tableFinishAccount.ajax.reload(null, false);
            }
            else if(click_tab3)
            {
                tableHoldAccount.ajax.reload(null, false);
            }
            else if(click_tab4)
            {
                tableCancelAccount.ajax.reload(null, false);
            }
            else if(click_tab5)
            {
                tableRevisedAccount.ajax.reload(null, false);
            }
        }
    },60000);

    $('#client_tab1').click(function () {
        if(click_tab1)
        {
            console.log('already loaded');
        }
        else
        {
            click_tab1 = true;
            click_tab2 = false;
            click_tab3 = false;
            click_tab4 = false;
            click_tab5 = false;
        }

    });
    $('#client_tab2').click(function () {
        if(click_tab2)
        {
            console.log('already loaded');
        }
        else
        {
            finish_accounts_table();
            // tableFinishAccount.ajax.reload(null, false);
            click_tab1 = false;
            click_tab2 = true;
            click_tab3 = false;
            click_tab4 = false;
            click_tab5 = false;
        }


    });
    $('#client_tab3').click(function () {
        if(click_tab3)
        {
            console.log('already loaded');
        }
        else
        {
            hold_accounts_table();
            // tableHoldAccount.ajax.reload(null, false);
            click_tab1 = false;
            click_tab2 = false;
            click_tab3 = true;
            click_tab4 = false;
            click_tab5 = false;
        }

    });
    $('#client_tab4').click(function () {
        if(click_tab4)
        {
            console.log('already loaded');
        }
        else
        {
            cancelled_accounts_table();
            // tableCancelAccount.ajax.reload(null, false);
            click_tab1 = false;
            click_tab2 = false;
            click_tab3 = false;
            click_tab4 = true;
            click_tab5 = false;
        }

    });
    $('#client_tab5').click(function () {
        if(click_tab5)
        {
            console.log('already loaded');
        }
        else
        {
            revised_accounts_table();
            // tableRevisedAccount.ajax.reload(null, false);
            click_tab1 = false;
            click_tab2 = false;
            click_tab3 = false;
            click_tab4 = false;
            click_tab5 = true;
        }
    });

    $('.client_a').click(function () {

        var gethref = $(this).attr('href');

        console.log(gethref);

        if(gethref == '#client_dash_tab_href')
        {
            if(which == 'una')
            {
                pending_accounts_table();
                click_tab1 = true;
                which = 'togo';
            }
            else if(which == 'dash')
            {
                table.ajax.reload(null, false);
                which = 'togo';
                click_tab1 = true;
            }
        }
        else if(gethref == '#client_endo_tab_href')
        {
            if(which == 'togo')
            {
                which = 'dash';
                click_tab1 = false;
            }
        }

    });
});

function fetchTemp()
{
    $.ajax
    ({
        type: 'get',
        url: '/get-list-province',
        success: function (data)
        {
            console.log(data)

            for (i = 0; i <= data[0].length - 1; i++)
            {
                listProvince += '<option value="' + data[0][i].name + '">' + data[0][i].name + '</option>';
            }

            for (i = 0; i <= data[1].length - 1; i++) {
                tol += '<option value="' + data[1][i].type_of_loans + '">' + data[1][i].type_of_loans + '</option>'

            }

            if(data[2] != '')
            {
                if(data[2][0].user_branch == '356' || data[2][0].user_branch == '9' || data[2][0].user_branch == '130' || data[2][0].user_branch == '289' || data[2][0].user_branch == '290')
                {
                    tol += '<option value= "KYC">KYC</option>';
                }
                else if(data[2][0].user_branch == '1006')
                {
                    tol = '<option value= "SME/Business">SME/Business</option>'+
                    '<option value= "Housing">Housing</option>'+
                    '<option value= "Jewelry">Jewelry</option>'+
                    '<option value= "Microfinance">Microfinance</option>'+
                    '<option value= "Auto">Auto</option>'+
                    '<option value= "Salary">Salary</option>';
                }
            }

            var ii = 1;
            for (i = 0; i <= 10; i++) {

                dropdown += '<option value="' + i + '">' + i + '</option>';
                dropdownevrbvr += '<option value="' + (ii+i) + '">' + (ii+i) + '</option>';

            }

            acctAddTemp =
                '                                            <input type="hidden" id="idMuni">'+
                '                                            <input type="hidden" id="idMuniOriginal">'+
                '                                            <input type="hidden" id="idEtar">'+
                '                                            <div class="box box-danger">\n' +
                '                                                <div class="box-header with-border">\n' +
                '                                                    <h3 class="box-title">Account Name and Address</h3>\n' +
                '                                                </div>\n' +
                '                                                <div class="box-body">\n' +
                '                                                    <div class="row">\n' +
                '                                                        <div class="form-group col-xs-4">\n' +
                '                                                            <label>Last Name</label><small style="color: red;"> (Required Field)</small>\n' +
                '                                                            <input id="acctLName" name="acctLName" type="text" class="form-control validateInputted" placeholder="">\n' +
                '                                                        </div>\n' +
                '                                                        <div class="form-group col-xs-4">\n' +
                '                                                            <label>First Name</label><small style="color: red;"> (Required Field)</small>\n' +
                '                                                            <input id="acctFName" name="acctFName" type="text" class="form-control validateInputted" placeholder="">\n' +
                '                                                        </div>\n' +
                '                                                        <div class="form-group col-xs-4">\n' +
                '                                                            <label>Middle Name</label><small style="color: red;"> (Required/Optional)</small>\n' +
                '                                                            <input id="acctMName" name="acctMName" type="text" class="form-control" placeholder="">\n' +
                '                                                        </div>\n' +
                '                                                    </div>\n' +
                '                                                    <div class="row">\n' +
                '                                                        <div class="form-group col-xs-4">\n' +
                '                                                            <label>Unit #, Bldg/Street, Subd/Brgy.</label><small style="color: red;"> (Required Field)</small>\n' +
                '                                                            <input type="text" class="form-control validateInputted" placeholder="" id="address" name="address">\n' +
                '                                                        </div>\n' +
                '                                                        <div class="form-group col-xs-4" data-toggle="tooltip" title="Please select city/municipality suggestion list appear below the textbox, this will be auto generate the province">\n' +
                '                                                            <label>City/Municipality</label><small style="color: red;"> (Required Field)</small>\n' +
                '                                                            <input type="text" class="form-control validateInputted" placeholder="" id="municipality" name="municipality">\n' +
                '                                                        </div>\n' +
                '                                                        <div class="form-group col-xs-4">\n' +
                '                                                            <label>Province</label><small style="color: red;"> (Auto Generated)</small><span id="loadingProv"></span>' +
                '                                                            <input type="text" class="form-control" placeholder="" id="province" name="province" disabled>\n' +
                '                                                        </div>\n' +
                '                                                    </div>\n' +
                '                                                </div>\n' +
                '                                            </div>\n';

            acctAddTempEvBv =
                '                                            <div class="box box-danger">' +
                '                                                <div class="box-header with-border">' +
                '                                                    <h3 class="box-title">Account Name</h3>' +
                '                                                    <div id="radioCorp" class="pull-right">\n' +
                '                                                       <div class="form-group">\n' +
                '                                                           <label class="radio-inline">\n' +
                '                                                               <input checked type="radio" class="flat-red" name="optradioCorp" id="personalRequest"><b>Personal Request</b>\n' +
                '                                                           </label>\n' +
                '                                                           <label class="radio-inline">\n' +
                '                                                               <input type="radio" class="flat-red" name="optradioCorp" id="corporateRequest"><b>Corporate Request</b>\n' +
                '                                                           </label>\n' +
                '                                                       </div>\n' +
                '                                                    </div>'+
                '                                                </div>\n' +
                '                                                <div class="box-body">' +
                '                                                    <div class="row">' +
                '                                                        <div class="form-group col-xs-4">' +
                '                                                            <label>Last Name</label><small style="color: red;"> (Required Field)</small>' +
                '                                                            <input id="acctLName" name="acctLName" type="text" class="form-control validatedvbrEvr" placeholder="">' +
                '                                                        </div>' +
                '                                                        <div class="form-group col-xs-4">' +
                '                                                            <label>First Name</label><small style="color: red;"> (Required Field)</small>' +
                '                                                            <input id="acctFName" name="acctFName" type="text" class="form-control validatedvbrEvr" placeholder="">' +
                '                                                        </div>\n' +
                '                                                        <div class="form-group col-xs-4">' +
                '                                                            <label>Middle Name</label><small style="color: red;"> (Required Field)</small>' +
                '                                                            <input id="acctMName" name="acctMName" type="text" class="form-control validatedvbrEvr" placeholder="">' +
                '                                                        </div>\n' +
                '                                                    </div>' +
                '                                                </div>' +
                '                                            </div>';

            multiCoborrowerTemp =
                '                                            <div class="box box-danger" id="comakerDom">\n' +
                '                                                <div class="box-header with-border">\n' +
                '                                                    <h3 class="box-title">Co-Borrower Name</h3><small style="color: red;">   *Note: Required for accounts with Co-Borrower/s</small>\n' +
                '                                                       <div class="form-group form-inline col-xs-3 pull-right">\n' +
                '                                                           <label class="control-label">Number of Coborrower</label>' +
                '                                                           <select class="form-control" id="ddCoborrower" name="ddCoborrower">' +
                dropdown+
                '                                                           </select>' +
                '                                                       </div>\n' +
                '                                                </div>\n' +
                '                                                <div class="box-body">\n' +
                '                                                    <span id="addCob"></span>'+
                '                                                </div>' +
                '                                            </div>\n';

            otherInfoTemp =
                '                                            <div class="box box-danger">' +
                '                                                <div class="box-header with-border">' +
                '                                                    <h3 class="box-title">Other Information</h3>' +
                '                                                </div>' +
                '                                                <div class="box-body">' +
                '                                                    <div class="row">' +
                '                                                        <div class="form-group col-xs-4">' +
                '                                                            <label>Type of Loan:</label>' +
                '                                                            <select class="form-control select1" style="width: 100%" id="loanType" name="loanType">' +
                tol+
                '                                                            </select>' +
                '                                                        </div>' +
                '                                                        <div class="form-group col-xs-4">' +
                '                                                           <label>Endorsement Type:</label>' +
                '                                                           <select class="form-control select1" id="txtPrioritize" style="width: 100%;">' +
                '                                                               <option selected="selected">Regular</option>' +
                '                                                               <option>Priority Discreet</option>' +
                '                                                           </select>' +
                '                                                        </div>' +
                '                                                        <div class="form-group col-xs-4">' +
                '                                                           <label>Type of Verification:</label>' +
                '                                                           <select class="form-control select1" id="txtVerifyThrough" style="width: 100%;">' +
                '                                                               <option selected="selected">Non Discreet</option>' +
                '                                                               <option>Discreet</option>' +
                '                                                           </select>' +
                '                                                        </div>'+
                '                                                    </div>' +
                '                                                    <div class="row">' +
                '                                                        <div class="form-group col-xs-12">' +
                '                                                            <label>Remarks:</label><small style="color: red;"> (Optional)</small>' +
                '                                                            <textarea id="txtClientRemarks" class="form-control" rows="3"></textarea>'+
                '                                                        </div>' +
                '                                                    </div>' +
                '                                                </div>' +
                '                                            </div>';

            if(splitterdata == 'Individual Client')
            {
                requestorInfoTemp =
                    '                                            <div style="display: none" class="box box-danger">' +
                    '                                                <div class="box-header with-border">' +
                    '                                                    <h3 class="box-title">Requestor Information</h3><small style="color: red;"> (Required Field)</small>' +
                    '                                                </div>' +
                    '                                                <div class="box-body">' +
                    '                                                    <div class="row">' +
                    '                                                        <div class="form-group col-xs-12">' +
                    '                                                            <label>Name of Requestor:</label>' +
                    '                                                            <input type="text" class="form-control" placeholder="" id="requestorName" name="requestorName">' +
                    '                                                        </div>' +
                    '                                                    </div>' +
                    '                                                </div>' +
                    '                                            </div>';
            }
            else
            {
                requestorInfoTemp =
                    '                                            <div class="box box-danger">' +
                    '                                                <div class="box-header with-border">' +
                    '                                                    <h3 class="box-title">Requestor Information</h3><small style="color: red;"> (Required Field)</small>' +
                    '                                                </div>' +
                    '                                                <div class="box-body">' +
                    '                                                    <div class="row">' +
                    '                                                        <div class="form-group col-xs-12">' +
                    '                                                            <label>Name of Requestor:</label>' +
                    '                                                            <input type="text" class="form-control" placeholder="" id="requestorName" name="requestorName">' +
                    '                                                        </div>' +
                    '                                                    </div>' +
                    '                                                </div>' +
                    '                                            </div>';
            }



            empInfoTemp =
                '                                            <div class="box box-danger">\n' +
                '                                                <div class="box-header with-border">\n' +
                '                                                    <h3 class="box-title">Employer Name and Address</h3>\n' +
                '                                                       <div class="form-group form-inline col-xs-3 pull-right">\n' +
                '                                                           <label class="control-label">Number of Employer</label>' +
                '                                                           <select class="form-control" id="ddEmployer" name="ddEmployer">' +
                dropdownevrbvr+
                '                                                           </select>' +
                '                                                       </div>\n' +
                '                                                </div>\n' +
                '                                                <div class="box-body">\n' +
                '                                                    <input type="hidden" id="idMuniEmp-0">'+
                '                                                    <input type="hidden" id="idMuniOriginalEmp-0">'+
                '                                                    <input type="hidden" id="idEtarEmp-0" class="paypal_evr_rate">'+
                '                                                    <span class="label label-danger">Employer 1</span>'+
                '                                                    <div class="row">\n' +
                '                                                        <div class="form-group col-xs-12">\n' +
                '                                                            <label>Employer Name</label><small style="color: red;"> (Required Field)</small>\n' +
                '                                                            <input type="text" class="form-control" placeholder="" id="evrEmpName-0" name="evrEmpName-0">\n' +
                '                                                        </div>\n' +
                '                                                    </div>\n' +
                '                                                    <div class="row">\n' +
                '                                                        <div class="form-group col-xs-4">\n' +
                '                                                            <label>Unit #, Bldg/Street, Subd/Brgy.</label><small style="color: red;"> (Required Field)</small>\n' +
                '                                                            <input type="text" class="form-control" placeholder="" id="addressEmp-0" name="addressEmp-0">\n' +
                '                                                        </div>\n' +
                '                                                        <div class="form-group col-xs-4">\n' +
                '                                                            <label>City/Municipality</label><small style="color: red;"> (Required Field)</small>\n' +
                '                                                            <input type="text" class="form-control" placeholder="" id="municipalityEmp-0" name="municipalityEmp-0">\n' +
                '                                                        </div>\n' +
                '                                                        <div class="form-group col-xs-4">\n' +
                '                                                            <label>Province</label><small style="color: red;"> (Required Field)</small>\n' +
                '                                                            <input type="text" class="form-control" placeholder="" id="provinceEmp-0" name="provinceEmp-0" disabled>\n' +
                '                                                        </div>\n' +
                '                                                    </div>\n' +
                '                                                    <span id="addEmp"></span>' +
                '                                                </div>\n' +
                '                                            </div>';

            busInfoTemp =
                '                                            <div class="box box-danger">\n' +
                '                                                <div class="box-header with-border">\n' +
                '                                                    <h3 class="box-title">Business Name and Address</h3>\n' +
                '                                                       <div class="form-group form-inline col-xs-3 pull-right">\n' +
                '                                                           <label class="control-label">Number of Business</label>' +
                '                                                           <select class="form-control" id="ddBusiness" name="ddBusiness">' +
                dropdownevrbvr+
                '                                                           </select>' +
                '                                                       </div>\n' +
                '                                                </div>\n' +
                '                                                <div class="box-body">\n' +
                '                                                    <input type="hidden" id="idMuniBus-0">'+
                '                                                    <input type="hidden" id="idMuniOriginalBus-0">'+
                '                                                    <input type="hidden" id="idEtarBus-0" class="business_rate_paypal">'+
                '                                                    <span class="label label-danger">Business 1</span>'+
                '                                                    <div class="row">\n' +
                '                                                        <div class="form-group col-xs-12">\n' +
                '                                                            <label>Business Name</label><small style="color: red;"> (Required Field)</small>\n' +
                '                                                            <input type="text" class="form-control" placeholder="" id="busName-0" name="busName-0">\n' +
                '                                                        </div>\n' +
                '                                                    </div>\n' +
                '                                                    <div class="row">\n' +
                '                                                        <div class="form-group col-xs-4">\n' +
                '                                                            <label>Unit #, Bldg/Street, Subd/Brgy.</label><small style="color: red;"> (Required Field)</small>\n' +
                '                                                            <input type="text" class="form-control" placeholder="" id="addressBus-0" name="addressBus-0">\n' +
                '                                                        </div>\n' +
                '                                                        <div class="form-group col-xs-4">\n' +
                '                                                            <label>City/Municipality</label><small style="color: red;"> (Required Field)</small>\n' +
                '                                                            <input type="text" class="form-control" placeholder="" id="municipalityBus-0" name="municipalityBus-0">\n' +
                '                                                        </div>\n' +
                '                                                        <div class="form-group col-xs-4">\n' +
                '                                                            <label>Province</label><small style="color: red;"> (Required Field)</small>\n' +
                '                                                            <input type="text" class="form-control" placeholder="" id="provinceBus-0" name="provinceBus-0" disabled>\n' +
                '                                                        </div>\n' +
                '                                                    </div>\n' +
                '                                                    <span id="addBus"></span>' +
                '                                                </div>\n' +
                '                                            </div>';
        }
    });
}


function clearInputsSuccess(data)
{
    document.getElementById("btnModalCloseSending").click();
    var stopTimer = setInterval(function ()
    {
        if(data.errors)
        {
            console.log(data.errors);
            $('#modal-filluperror').modal('show');
            var timerDanger = setInterval(function()
            {
                document.getElementById("btnModalCloseFillUpError").click();
                clearInterval(timerDanger);
            }, 2000);
            $("#endorseSend").attr("disabled", false);
        }
        else if (data.success === true)
        {
            $('#acctFName').val('');
            $('#acctMName').val('');
            $('#acctLName').val('');

            if($("#dealer_name").length > 0)
            {
                $('#dealer_name').val('');
            }
            if($("#contract_number").length > 0)
            {
                $('#contract_number').val('');
            }
            $('#address').val('');
            $('#municipality').val('');
            $('#txtClientRemarks').val('');
            // $('#txtSubjectName').val('');

            for(i=0;i<=$('#ddCoborrower').val()-1;i++)
            {
                $('#coborFName-'+i).val('');
                $('#coborMName-'+i).val('');
                $('#coborLName-'+i).val('');
                $('#address-'+i).val('');
                $('#municipality-'+i).val('');
                $('#province-'+i).val('');
            }

            for(i=0;i<=$('#ddEmployer').val()-1;i++)
            {
                $('#evrEmpName-'+i).val('');
                $('#addressEmp-'+i).val('');
                $('#municipalityEmp-'+i).val('');
                $('#province-Emp'+i).val('');
            }

            for(i=0;i<=$('#ddBusiness').val()-1;i++)
            {
                $('#busName-'+i).val('');
                $('#addressBus-'+i).val('');
                $('#municipalityBus-'+i).val('');
                $('#provinceBus'+i).val('');
            }

            $('#modal-sentsuccess').modal('show');

            var timerSuccess = setInterval(function()
            {
                $('#modal-sentsuccess').modal('hide');
                clearInterval(timerSuccess);

                var sessionModal = setInterval(function ()
                {
                    $('#modal-load-session').modal();
                    clearInterval(sessionModal);
                },1000)

            }, 2000);

            $("#endorseSend").attr("disabled", false);
        }
        clearInterval(stopTimer);
    },1000);
}

function clearInputsError()
{
    document.getElementById("btnModalCloseSending").click();
    var stopTimer = setInterval(function ()
    {
        $('#modal-errorsending').modal('show');

        var timerSuccess = setInterval(function()
        {
            $('#modal-errorsending').modal('hide');
            clearInterval(timerSuccess);
        }, 5000);
        clearInterval(stopTimer);
        $("#endorseSend").attr("disabled", false);
    },1000);
}

//check if double

$('#formContent').on('click', '#endorseSend' ,function ()
{
    // $("#endorseSend").attr("disabled", true);
    var checkacctFName = $('#acctFName').val();
    var checkacctMName = $('#acctMName').val();
    var checkacctLName = $('#acctLName').val();

    var accountNameCheck = checkacctFName + " "+ checkacctMName +" "+ checkacctLName;
    var typeOfLoanCheck = $('#loanType').val();
    var typeOfRequestCheck = '';
    if(check_if_direct)
    {
        typeOfRequestCheck = req_checker;
    }
    else
    {
        typeOfRequestCheck = $('#btnSelectForm').val();
    }
    if(document.getElementById('NewEndorsement').checked)
    {
        var cobromakerchecker = '';
        var subj = '';

        if(cobromakertrigger)
        {
            cobromakerchecker = 'cobromaker';
            subj = $('#txtSubjectName').val();

            if(subj == '')
            {
                alert('Please fill up \'Name of the Subject\'');
                $("#endorseSend").attr("disabled", false);
            }
            else
            {
                doubend();
            }
        }
        else if(corporatetrigger)
        {
            accountNameCheck = 'corporate';
            console.log('triggercorp');

            for (i = 0; i <= $('#ddBusiness').val() - 1; i++) {
                busInfos[i] =
                    [
                        // 0
                        $('#busName-' + i).val(),
                        // 1
                        $('#addressBus-' + i).val(),
                        // 2
                        $('#idMuniOriginalBus-' + i).val(),
                        // 3
                        $('#provinceBus-' + i).val(),
                        // 4
                        $('#idEtarBus-' + i).val()
                    ];
            }
            doubend()
        }
        else {
            accountNameCheck = checkacctFName + " "+ checkacctMName +" "+ checkacctLName;
            cobromakerchecker = '';
            doubend()
        }

        function doubend()
        {
            $.ajax({
                url: '/check-double-endorse',
                type: 'get',
                data:
                    {
                        'accountNameCheck': accountNameCheck,
                        'typeOfLoanCheck' : typeOfLoanCheck,
                        'typeOfRequestCheck' : typeOfRequestCheck,
                        'busInfo':busInfos,
                        'cobromakerchecker': cobromakerchecker,
                        'subj':subj

                    },
                dataType: 'json',
                success: function (data) {

                    if(data === "success")
                    {
                        endrose('New Endorsement');
                    }
                    else if(data === "holdacct")
                    {
                        alert('This account were been hold, please contact Account Officer personnel to address this issue.');
                    }
                    else if(data === "cancelacct")
                    {
                        alert('This account were been cancelled, please contact Account Officer personnel to address this issue.');
                    }
                    else if(data === "fail")
                    {
                        alert('Account is already endorsed, Please Choose Type of Endorsements in the upper corner.');
                    }
                    $("#endorseSend").attr("disabled", false);
                },
                error: function (data)
                {
                    alert('Something went wrong');
                    $("#endorseSend").attr("disabled", false);
                }
            });

        }
    }
    else if(document.getElementById('ReVisit').checked)
    {
        endrose('Re-Visit(RE C.I)');
        $("#endorseSend").attr("disabled", false);
    }
    else if(document.getElementById('otherBranch').checked)
    {
        endrose('Other Branch');
        $("#endorseSend").attr("disabled", false);
    }
    else if(document.getElementById('otherAddress').checked)
    {
        endrose('Other Address');
        $("#endorseSend").attr("disabled", false);
    }

});
//END

//ADD ENDORSEMENT

var acctFName = "";
var acctMName = "";
var acctLName = "";

var address= "";
var municipality = "";
var provinceName = "";

var txtClientRemarks = "";

var clientName = "";
var requestorName = "";
var loanType = "";
var requestType= "";
var prioritize = "";
var verifythrough = "";
var etar  = "";
var subjectName = "";
var ReCi = '';
var _token = $('#_token').val();

function endrose(a)
{
    ReCi = a;

    $("#endorseSend").attr("disabled", true);

    acctFName = $('#acctFName').val();
    acctMName = $('#acctMName').val();
    acctLName = $('#acctLName').val();

    address = $('#address').val();
    municipality = $('#idMuniOriginal').val();
    provinceName = $('#province').val();

    txtClientRemarks = $('#txtClientRemarks').val();

    clientName = $('#clientName').val();
    requestorName = $('#requestorName').val();
    loanType = $('#loanType').val();
    if(check_if_direct)
    {
        requestType = req_checker;
    }
    else
    {
        requestType = $('#btnSelectForm').val();
    }
    prioritize = $('#txtPrioritize').val();
    verifythrough = $('#txtVerifyThrough').val();
    etar = $('#idEtar').val();
    subjectName = "";



    checkercountcoob = 0;
    checkercountevr = 0;
    checkercountbvr = 0;

    // var checkpdrn = '';
    // var checkpdrnv2 = '';

    for (i = 0; i <= $('#ddCoborrower').val() - 1; i++)
    {
        // var pop = (i+1);
        if($('#coborFName-' + i).val() === '' || $('#coborLName-' + i).val() === '' || $('#address-' + i).val() === '' || $('#municipality-' + i).val() === '' || $('#province-' + i).val() === '')
        {
            checkercountcoob++;
        }

        for(counting = 0; counting < i ; counting ++)
        {
            if(counting === i)
            {

            }
            else if($('#coborFName-' + i).val()+'-'+$('#coborLName-' + i).val() === $('#coborFName-' +counting).val()+'-'+ $('#coborLName-' +counting).val())
            {
                checkercountcoob++;
            }
        }


        coborInfo[i] =
            [
                $('#coborFName-' + i).val() + ' ' + $('#coborMName-' + i).val() + ' ' + $('#coborLName-' + i).val(),
                $('#address-' + i).val(),
                $('#municipality-' + i).val(),
                $('#province-' + i).val(),
                $('#idEtar-' + i).val(),
                $('#idMuniOriginal-' + i).val()

            ];
    }

    for (i = 0; i <= $('#ddEmployer').val() - 1; i++)
    {

        if($('#evrEmpName-' + i).val() === '' || $('#addressEmp-' + i).val() === '' || $('#municipalityEmp-' + i).val() === '' || $('#provinceEmp-' + i).val() === '')
        {
            checkercountevr++;
        }

        for(counting = 0; counting < i ; counting ++)
        {
            if(counting === i)
            {

            }
            else if($('#evrEmpName-' + i).val() === $('#evrEmpName-' +counting).val())
            {
                checkercountevr++;
            }
        }


        empInfo[i] =
            [
                $('#evrEmpName-' + i).val(),
                $('#addressEmp-' + i).val(),
                $('#idMuniOriginalEmp-' + i).val(),
                $('#provinceEmp-' + i).val(),
                $('#idEtarEmp-' + i).val()
            ];
    }

    for (i = 0; i <= $('#ddBusiness').val() - 1; i++) {

        if($('#busName-' + i).val() === '' || $('#addressBus-' + i).val() === '' || $('#municipalityBus-' + i).val() === '' || $('#provinceBus-' + i).val() === '')
        {
            checkercountbvr++;
        }

        for(counting = 0; counting < i ; counting ++)
        {
            if(counting === i)
            {

            }
            else if($('#busName-' + i).val() === $('#busName-' +counting).val() && $('#addressBus-' + i).val() === $('#addressBus-' +counting).val())
            {
                checkercountbvr++;
            }
        }


        busInfo[i] =
            [
                $('#busName-' + i).val(),
                $('#addressBus-' + i).val(),
                $('#idMuniOriginalBus-' + i).val(),
                $('#provinceBus-' + i).val(),
                $('#idEtarBus-' + i).val()
            ];
    }


    if(document.getElementById('tosCob').checked)
    {
        checkercountcoob = 0;
        subjectName = $('#txtSubjectName').val();
    }




    if(splitterdata == 'Individual Client')
    {
        var paypalFinalAmount = 0;
        var paypalRate = 0;
        it_is_direct = true;
        $('#paypal-payment').html('');
        paypal.Buttons({
            style: {
                // color:  'blue',
                // shape:  'pill',
                label:  'pay',
                height: 40
            },
            // Set up the transaction
            createOrder: function(data, actions) {
                if($('#btnSelectForm').val() == 'PDRN' || req_checker == 'PDRN')
                {
                    $('.validateInputted').each(function()
                    {
                        var val = $(this).val();

                        if(val == '')
                        {
                            go_shoot = false;
                            return false;
                        }
                        go_shoot = true;
                    });

                    if($('#idEtar').val() == '')
                    {
                        paypalRate = 500
                    }
                    else
                    {
                        paypalRate = atob($('#idEtar').val())
                    }
                    var cobaddctr = 0;
                    var all_address_array = [];
                    var rates_array = [];
                    var first_address = $('#address').val() + '|-|-|' + $('#municipality').val() + '|-|-|' + paypalRate;
                    var rate_cob = 0;
                    var arraypdrn_sum = 0;
                    var same_address_array = [];
                    var full_address_cob = '';

                    $('.cob_rate_pdrn').each(function()
                    {
                        if($(this).val() != '')
                        {
                            rate_cob = atob($(this).val());
                        }
                        else
                        {
                            rate_cob = 500;
                        }
                        full_address_cob = $('#address-'+cobaddctr+'').val() + '|-|-|' + $('#municipality-'+cobaddctr+'').val() + '|-|-|' + rate_cob;
                        all_address_array[cobaddctr] = full_address_cob;
                        cobaddctr++;
                    });

                    all_address_array.unshift(first_address); // lalagay sa index 0
                    // rates_array.unshift(paypalRate); // lalagay sa index 0


                    $.each(all_address_array, function(i, data_chunks){
                        if($.inArray(data_chunks, same_address_array) === -1) same_address_array.push(data_chunks);
                    });

                    for(var r = 0; r < same_address_array.length; r++)
                    {
                        var splitPDRN = same_address_array[r].split('|-|-|');
                        arraypdrn_sum = parseInt(splitPDRN[2]) + arraypdrn_sum;
                    }

                    paypalFinalAmount = arraypdrn_sum
                }
                else if($('#btnSelectForm').val() == 'BVR' || req_checker == 'BVR')
                {
                    $('.validatedvbrEvr').each(function()
                    {
                        var val = $(this).val();

                        if(val == '')
                        {
                            go_shoot = false;
                            return false;
                        }
                        go_shoot = true;
                    });
                    var rate_bvr;
                    var all_bvr_add = [];
                    var all_bvr_add_ctr = 0;
                    var same_address_array_bvr = [];
                    var arraybvr_sum = 0;

                    $('.business_rate_paypal').each(function()
                    {
                        if($(this).val() != '')
                        {
                            rate_bvr = atob($(this).val());
                        }
                        else
                        {
                            rate_bvr = 500;
                        }

                        all_bvr_add[all_bvr_add_ctr] = $('#addressBus-'+all_bvr_add_ctr+'').val() + '|-|-|' + $('#municipalityBus-'+all_bvr_add_ctr+'').val() + '|-|-|' + rate_bvr;

                        all_bvr_add_ctr++;
                    });

                    $.each(all_bvr_add, function(i, data_chunks){
                        if($.inArray(data_chunks, same_address_array_bvr) === -1) same_address_array_bvr.push(data_chunks);
                    });

                    for(var t = 0; t < same_address_array_bvr.length; t++)
                    {
                        var splitPDRN = same_address_array_bvr[t].split('|-|-|');
                        arraybvr_sum = parseInt(splitPDRN[2]) + arraybvr_sum;
                    }
                    paypalFinalAmount = arraybvr_sum;
                }
                else if($('#btnSelectForm').val() == 'EVR' || req_checker == 'EVR')
                {
                    $('.validatedvbrEvr').each(function()
                    {
                        var val = $(this).val();

                        if(val == '')
                        {
                            go_shoot = false;
                            return false;
                        }
                        go_shoot = true;
                    });

                    var rate_evr = 0;
                    var all_evr_add_ctr = 0;
                    var all_evr_add = [];
                    var same_address_array_evr = [];
                    var arrayevr_sum = 0;

                    $('.paypal_evr_rate').each(function()
                    {
                        if($(this).val() != '')
                        {
                            rate_evr = atob($(this).val());
                        }
                        else
                        {
                            rate_evr = 500;
                        }

                        all_evr_add[all_evr_add_ctr] = $('#addressEmp-'+all_evr_add_ctr+'').val() + '|-|-|' + $('#municipalityEmp-'+all_evr_add_ctr+'').val() + '|-|-|' + rate_evr;

                        all_evr_add_ctr++;
                    });



                    $.each(all_evr_add, function(i, data_chunks){
                        if($.inArray(data_chunks, same_address_array_evr) === -1) same_address_array_evr.push(data_chunks);
                    });

                    for(var u = 0; u < same_address_array_evr.length; u++)
                    {
                        var splitEVR = same_address_array_evr[u].split('|-|-|');
                        arrayevr_sum = parseInt(splitEVR[2]) + arrayevr_sum;
                    }
                    paypalFinalAmount = arrayevr_sum;
                }

                if(!go_shoot)
                {
                    return alert('Please complete the required field!');
                }
                else
                {
                    return actions.order.create({
                        purchase_units: [{
                            amount: {
                                value: paypalFinalAmount
                                // value: '20'
                            }
                        }]
                    });
                }
            },
            // Finalize the transaction
            onApprove: function(data, actions) {
                return actions.order.capture().then(function (details) {

                    var testData = details;
                    var tr_id = testData.purchase_units[0].payments.captures[0].id;
                    var payer_id = testData.payer.payer_id;
                    var amount = testData.purchase_units[0].amount.value;
                    var email_address = testData.payer.email_address;
                    var country_code = testData.payer.address.country_code;

                    // console.log(details);

                    alert('Transaction completed by ' + details.payer.name.given_name);

                    // validateInputted

                    $.ajax({
                        type: 'post',
                        url : 'paypal_pay_confirm',
                        data: {
                            'tr_id' : tr_id,
                            'payer_id' : payer_id,
                            'amount' : amount,
                            'email_address' : email_address,
                            'country_code' :country_code,
                            'requestor_email' : $('#requestor_info_paypal').val(),
                            'requestor_info_country' : $('#requestor_info_country').val(),
                            'requestor_info_name' : $('#requestor_info_name').val()
                        },
                        success: function(data)
                        {

                            if(data[0] == 'paid')
                            {
                                requestorName = $('#requestor_info_name').val();
                                tr_id_paypal = data[1];
                                final_endorse(true);
                                $('#modal-pay-first').modal('hide');
                            }
                        }
                    });
                });
            }
        }).render('#paypal-payment');
        requestorName = '';
        $('#modal-pay-first').modal('show');
        // final_endorse();
    }
    else
    {
        final_endorse(false);
    }

}

function final_endorse(it_is_direct) {
    var contract_num_end = '';
    var dealer_num_end = '';
    if ($('#btnSelectForm').val() === 'PDRN' || req_checker == 'PDRN')
    {
        if(checkercountcoob > 0)
        {
            $("#endorseSend").attr("disabled", false);
            alert('Please fill up all information in \"CO-BORROWER\" but if there\'s none, Change the \"Number of Coborrower\" into \'0\' or maybe the input information is doubled.');
        }
        else
        {
            if($('#dealer_name').length > 0 && $('#contract_number').length > 0)
            {
                contract_num_end = $('#contract_number').val();
                dealer_num_end = $('#dealer_name').val();
            }
            else
            {
                contract_num_end = '';
                dealer_num_end = '';
            }

            //proceed to endorse
            $.ajax
            ({
                type: 'post',
                url: 'add-endorsement',
                data:
                    {
                        'acctFName': acctFName,
                        'acctMName': acctMName,
                        'acctLName': acctLName,
                        'address': address,
                        'municipality': municipality,
                        'provinceName': provinceName,
                        'txtClientRemarks': txtClientRemarks,
                        'clientName': clientName,
                        'requestorName': requestorName,
                        'loanType': loanType,
                        'requestType': requestType,
                        'coborInfo': coborInfo,
                        'countcoob' : $('#ddCoborrower').val(),
                        'prioritize': prioritize,
                        'verifythrough': verifythrough,
                        'ReCi' : ReCi,
                        'etar': etar,
                        'subjectName': subjectName,
                        'subjectID': $('#txtSubjectName').attr('name'),
                        'tos': tos,
                        '_token': _token,
                        'paypal_tr_id' : tr_id_paypal,
                        'it_is_direct' : it_is_direct,
                        'dealer_name' : dealer_num_end,
                        'contract_number' : contract_num_end
                    },
                beforeSend: function ()
                {
                    $('#modal-sendingrequest').modal('show');
                    console.log(it_is_direct);
                },
                success: function (data)
                {
                    console.log(data);
                    clearInputsSuccess(data);
                },
                error: function (data)
                {
                    clearInputsError(data);
                }
            });

        }
    }
    else if ($('#btnSelectForm').val() === 'EVR' || req_checker == 'EVR')
    {

        if(checkercountcoob > 0)
        {

            $("#endorseSend").attr("disabled", false);

            alert('Please fill up all information in \"CO-BORROWER\" but if there\'s none, Change the \"Number of Coborrower\" into \'0\' or maybe the input information is doubled.');


        }
        else if(checkercountevr > 0)
        {

            $("#endorseSend").attr("disabled", false);

            alert('Please fill up all information in \"Employer\" or the input information is doubled.\'');
        }
        else
        {
            //proceed to endorse
            $.ajax
            ({
                type: 'post',
                url: 'add-endorsement-evr',
                data:
                    {
                        'acctFName': acctFName,
                        'acctMName': acctMName,
                        'acctLName': acctLName,
                        'address': address,
                        'municipality': municipality,
                        'provinceName': provinceName,
                        'txtClientRemarks': txtClientRemarks,
                        'clientName': clientName,
                        'requestorName': requestorName,
                        'loanType': loanType,
                        'requestType': requestType,
                        'empInfo': empInfo,
                        'coborInfo': coborInfo,
                        'prioritize': prioritize,
                        'ReCi' : ReCi,
                        'verifythrough': verifythrough,
                        'subjectName': subjectName,
                        'subjectID': $('#txtSubjectName').attr('name'),
                        'tos': tos,
                        '_token': _token,
                        'paypal_tr_id' : tr_id_paypal,
                        'it_is_direct' : it_is_direct,
                        'dealer_name' : dealer_num_end,
                        'contract_number' : contract_num_end
                    },
                beforeSend: function () {
                    $('#modal-sendingrequest').modal('show');
                },
                success: function (data) {
                    clearInputsSuccess(data);
                },
                error: function () {
                    clearInputsError();
                }
            });
        }
    }
    else if ($('#btnSelectForm').val() === 'BVR' || req_checker == 'BVR')
    {
        if(checkercountcoob > 0)
        {

            $("#endorseSend").attr("disabled", false);

            alert('Please fill up all information in \"CO-BORROWER\" but if there\'s none, Change the \"Number of Coborrower\" into \'0\' or maybe the input information is doubled.');


        }
        else if(checkercountbvr > 0)
        {

            $("#endorseSend").attr("disabled", false);

            alert('Please fill up all information in \"Business\" or the input information is doubled.\'');
        }
        else
        {
            if ($("#personalRequest").is(":checked"))
            {
                //proceed to endorse
                $.ajax
                ({
                    type: 'post',
                    url: 'add-endorsement-bvr',
                    data:
                        {
                            'acctFName': acctFName,
                            'acctMName': acctMName,
                            'acctLName': acctLName,
                            'address': address,
                            'municipality': municipality,
                            'provinceName': provinceName,
                            'txtClientRemarks': txtClientRemarks,
                            'clientName': clientName,
                            'requestorName': requestorName,
                            'loanType': loanType,
                            'requestType': requestType,
                            'busInfo': busInfo,
                            'coborInfo': coborInfo,
                            'prioritize': prioritize,
                            'ReCi' : ReCi,
                            'verifythrough': verifythrough,
                            'subjectName': subjectName,
                            'subjectID': $('#txtSubjectName').attr('name'),
                            'tos': tos,
                            '_token': _token,
                            'paypal_tr_id' : tr_id_paypal,
                            'it_is_direct' : it_is_direct,
                            'dealer_name' : dealer_num_end,
                            'contract_number' : contract_num_end
                        },
                    beforeSend: function ()
                    {
                        $('#modal-sendingrequest').modal('show');
                    },
                    success: function (data) {
                        console.log(data);
                        clearInputsSuccess(data);
                    },
                    error: function () {
                        clearInputsError();
                    }
                });
            }
            else
            {
                //proceed to endorse
                $.ajax
                ({
                    type: 'post',
                    url: 'add-endorsement-bvr',
                    data:
                        {
                            'corp': 'corp',
                            'address': address,
                            'municipality': municipality,
                            'provinceName': provinceName,
                            'txtClientRemarks': txtClientRemarks,
                            'clientName': clientName,
                            'requestorName': requestorName,
                            'loanType': loanType,
                            'requestType': requestType,
                            'busInfo': busInfo,
                            'coborInfo': coborInfo,
                            'prioritize': prioritize,
                            'ReCi' : ReCi,
                            'verifythrough': verifythrough,
                            'subjectName': subjectName,
                            'tos': tos,
                            '_token': _token
                        },
                    beforeSend: function ()
                    {
                        $('#modal-sendingrequest').modal('show');
                    },
                    success: function (data) {
                        clearInputsSuccess(data);
                    },
                    error: function () {
                        clearInputsError();
                    }
                });
            }
        }
    }
}
//END

$('#formContent').on('change', '#ddCoborrower', function ()
{
    $('#addCob').html('');
    indi_rate[0] = parseInt(atob($('#idEtar').val()));

    for(i=0;i<=$('#ddCoborrower').val()-1;i++)
    {
        $('#addCob').append
        (
            '                                                    <input type="hidden" id="idMuni-'+i+'">'+
            '                                                    <input type="hidden" id="idMuniOriginal-'+i+'">'+
            '                                                    <input type="hidden" id="idEtar-'+i+'" class="cob_rate_pdrn">'+
            '                                                    <span class="label label-danger">Coborrower '+(i+1)+' </span> '+
            '                                                    <div class="row">\n' +
            '                                                        <div class="form-group col-xs-4">\n' +
            '                                                            <label>Last Name</label>\n' +
            '                                                            <input type="text" class="form-control" placeholder="" id="coborLName-'+i+'" name="coborLName-'+i+'">\n' +
            '                                                        </div>\n' +
            '                                                        <div class="form-group col-xs-4">\n' +
            '                                                            <label>First Name</label>\n' +
            '                                                            <input type="text" class="form-control" placeholder="" id="coborFName-'+i+'" name="coborFName-'+i+'">\n' +
            '                                                        </div>\n' +
            '                                                        <div class="form-group col-xs-4">\n' +
            '                                                            <label>Middle Name</label>\n' +
            '                                                            <input type="text" class="form-control" placeholder="" id="coborMName-'+i+'" name="coborMName-'+i+'">\n' +
            '                                                        </div>\n' +
            '                                                    </div>\n' +
            '                                                    <div class="row">' +
            '<div class="form-group col-xs-8">' +
            '                                                       <label>\n' +
            '                                                          <input id="coborCheckSameAdd-'+i+'" name="'+i+'" type="checkbox" class="checkbox_sameadd">\n' +
            '                                                          Same Address\n' +
            '                                                        </label><small style="color: red;"> (Check this if the co-borrower has the same address with main subject/borrower)</small>' +
            '</div>'+
            '                                                    </div>'+
            '                                                    <div class="row">\n' +
            '                                                        <div class="form-group col-xs-4">\n' +
            '                                                            <label>*Unit #/Building, Street Name/Number, Subd., Brgy.*</label><small style="color: red;"> (Required Field)</small>\n' +
            '                                                            <input type="text" class="form-control" placeholder="" id="address-'+i+'" name="address-'+i+'">\n' +
            '                                                        </div>\n' +

            '                                                        <div class="form-group col-xs-4">\n' +
            '                                                            <label>*District/City/Municipality*</label><small style="color: red;"> (Required Field)</small>\n' +
            '                                                            <input type="text" class="form-control" placeholder="" id="municipality-'+i+'" name="municipality-'+i+'">\n' +
            '                                                        </div>\n' +

            '                                                        <div class="form-group col-xs-4">\n' +
            '                                                            <div class="form-group">\n' +
            '                                                                <label>*Province*</label><small style="color: red;"> (Required Field)</small>\n' +
            '                                                                <select class="form-control select1" style="width: 100%;" disabled id="province-'+i+'" name="province-'+i+'">\n' +
            listProvince +
            '                                                                </select>\n' +
            '                                                            </div>\n' +
            '                                                        </div>\n' +
            '                                                    </div>\n'
        );
        clickcheckbox(i);
        autocompspdrn(i);
        pdrn(i);
    }

});

function clickcheckbox(i) {

    $('#coborCheckSameAdd-'+i+'').click(function() {

        if($(this).is(":checked"))
        {
            // console.log('check');
            $('#municipality-'+i+'').attr('disabled','disabled');
            $('#address-'+i+'').attr('disabled','disabled');

            // console.log($('#municipality').val());
            $('#municipality-'+i+'').val(  $('#municipality').val() );
            $('#address-'+i+'').val(  $('#address').val() );

            $.ajax
            ({
                method: 'get',
                url: '/fetch-city-muniv2',
                data:
                    {
                        'muniname' :  $('#municipality-'+i+'').val()
                    },
                success: function (data)
                {
                    $('#idMuni-'+i+'').val(data[0].province_id);
                    $('#idMuniOriginal-'+i+'').val(data[0].id);

                    fetchProvrPdn(i);

                    setTimeout(function () {
                        $('#municipality-'+i+'').val(data[0].muni_name)
                    },1000);
                }
            });


        }
        else
        {
            // console.log('uncheck');
            $('#municipality-'+i+'').removeAttr('disabled');
            $('#address-'+i+'').removeAttr('disabled');
        }
    });
}

$('.checkbox_sameadd').click(function () {
    // console.log('click class');
    $('#coborCheckSameAdd-'+$(this).attr('name')+'').click();
});

function autocompspdrn(i)
{
    $('#municipality-'+i+'').focusout(function () {
        if($('#municipality-'+i+'').val() === '')
        {
            $('#province-'+i+'').val('');
        }
        else{
            $.ajax
            ({
                method: 'get',
                url: '/fetch-city-muniv2',
                data:
                    {
                        'muniname' :  $('#municipality-'+i+'').val()
                    },
                success: function (data)
                {
                    $('#idMuni-'+i+'').val(data[0].province_id);
                    $('#idMuniOriginal-'+i+'').val(data[0].id);

                    fetchProvrPdn(i);

                    setTimeout(function () {
                        $('#municipality-'+i+'').val(data[0].muni_name)
                    },1000);
                }
            });
        }
    });

}

function pdrn(i)
{
    $('#municipality-'+i+'').autocomplete
    ({
        source: '/fetch-city-muni',
        minLength: 1,
        select: function (event, ui)
        {
            $('#idMuni-'+i+'').val(ui.item.muniID);
            $('#idMuniOriginal-'+i+'').val(ui.item.originalMuniID);
            var clearTimee = setInterval(function ()
            {
                fetchProvrPdn(i);
                clearInterval(clearTimee);
            },10)
        }
    });
}

function fetchProvrPdn(i)
{
    muniID = $('#idMuni-'+i+'').val();
    originalMuniID = $('#idMuniOriginal-'+i+'').val();
    $.ajax
    ({
        method: 'get',
        url: 'fetch-prov',
        data:
            {
                'muniID': muniID,
                'originalMuniID': originalMuniID
            },
        success: function (data)
        {
            // if(splitterdata == 'Individual Client')
            // {
            //     if(data[1][0] != '')
            //     {
            //         indi_rate.push(data[1][0].rate)
            //     }
            //     else
            //     {
            //         indi_rate.push(500);
            //     }
            // }
            $('#province-'+i+'').val('');
            $('#idEtar-'+i+'').val('');
            $('#province-'+i+'').val(data[0][0].name);
            $('#idEtar-'+i+'').val(btoa(data[1][0].rate));

            if(splitterdata == 'Individual Client')
            {
                try
                {
                    $('#idEtar-'+i+'').val(btoa(data[1][0].rate));
                    indi_rate.push(data[1][0].rate);
                }
                catch(e)
                {
                    indi_rate.push(500);
                }
            }
        }
    });
}

$('#formContent').on('change', '#ddEmployer', function ()
{
    $('#addEmp').html('');

    for(i=1;i<=$('#ddEmployer').val()-1;i++)
    {
        $('#addEmp').append
        (
            '                                                    <input type="hidden" id="idMuniEmp-'+i+'">'+
            '                                                    <input type="hidden" id="idMuniOriginalEmp-'+i+'">'+
            '                                                    <input type="hidden" id="idEtarEmp-'+i+'" class="paypal_evr_rate">'+
            '                                                    <span class="label label-danger">Employer '+(i+1)+'</span>'+
            '                                                    <div class="row">\n' +
            '                                                        <div class="form-group col-xs-12">\n' +
            '                                                            <label>Employer Name</label><small style="color: red;"> (Required Field)</small>\n' +
            '                                                            <input type="text" class="form-control" placeholder="" id="evrEmpName-'+i+'" name="evrEmpName-'+i+'">\n' +
            '                                                        </div>\n' +
            '                                                    </div>\n' +
            '                                                    <div class="row">\n' +
            '                                                        <div class="form-group col-xs-4">\n' +
            '                                                            <label>*Unit #/Building, Street Name/Number, Subd., Brgy.*</label><small style="color: red;"> (Required Field)</small>\n' +
            '                                                            <input type="text" class="form-control" placeholder="" id="addressEmp-'+i+'" name="addressEmp-'+i+'">\n' +
            '                                                        </div>\n' +
            '                                                        <div class="form-group col-xs-4">\n' +
            '                                                            <label>*District/City/Municipality*</label><small style="color: red;"> (Required Field)</small>\n' +
            '                                                            <input type="text" class="form-control" placeholder="" id="municipalityEmp-'+i+'" name="municipalityEmp-'+i+'">\n' +
            '                                                        </div>\n' +
            '                                                        <div class="form-group col-xs-4">\n' +
            '                                                            <label>*Province*</label><small style="color: red;"> (Required Field)</small>\n' +
            '                                                            <input type="text" class="form-control" placeholder="" id="provinceEmp-'+i+'" name="provinceEmp-'+i+'" disabled>\n' +
            '                                                        </div>\n' +
            '                                                    </div>\n' +
            '                                                    <span id="addEmp"></span>'
        );
        autocompsemp(i);
        emp(i);

    }
});

function autocompsemp(i)
{
    $('#municipalityEmp-'+i+'').focusout(function () {
        if($('#municipalityEmp-'+i+'').val() === '')
        {
            $('#provinceEmp-'+i+'').val('');
        }
        else{
            $.ajax
            ({
                method: 'get',
                url: '/fetch-city-muniv2',
                data:
                    {
                        'muniname' :  $('#municipalityEmp-'+i+'').val()
                    },
                success: function (data)
                {
                    $('#idMuniEmp-'+i+'').val(data[0].province_id);
                    $('#idMuniOriginalEmp-'+i+'').val(data[0].id);

                    fetchProvEvrr(i);

                    setTimeout(function () {
                        $('#municipalityEmp-'+i+'').val(data[0].muni_name)
                    },1000);
                }
            });
        }
    });

}

function emp(i)
{
    $('#municipalityEmp-'+i+'').autocomplete
    ({
        source: '/fetch-city-muni',
        minLength: 1,
        select: function (event, ui)
        {
            $('#idMuniEmp-'+i+'').val(ui.item.muniID);
            $('#idMuniOriginalEmp-'+i+'').val(ui.item.originalMuniID);
            var clearTimee = setInterval(function ()
            {
                fetchProvEvrr(i);
                clearInterval(clearTimee);
            },10)
        }
    });
}

function fetchProvEvrr(i)
{
    muniID = $('#idMuniEmp-'+i+'').val();
    originalMuniID = $('#idMuniOriginalEmp-'+i+'').val();
    $.ajax
    ({
        method: 'get',
        url: 'fetch-prov',
        data:
            {
                'muniID': muniID,
                'originalMuniID': originalMuniID
            },
        success: function (data)
        {
            $('#provinceEmp-'+i+'').val('');
            $('#idEtarEmp-'+i+'').val('');
            $('#provinceEmp-'+i+'').val(data[0][0].name);
            $('#idEtarEmp-'+i+'').val(btoa(data[1][0].rate));
        }
    });
}

$('#formContent').on('change', '#ddBusiness', function ()
{
    $('#addBus').html('');

    for(i=1;i<=$('#ddBusiness').val()-1;i++)
    {
        $('#addBus').append
        (
            '                                                    <input type="hidden" id="idMuniBus-'+i+'">'+
            '                                                    <input type="hidden" id="idMuniOriginalBus-'+i+'">'+
            '                                                    <input type="hidden" id="idEtarBus-'+i+'" class="business_rate_paypal">'+
            '                                                    <span class="label label-danger">Business '+(i+1)+'</span>'+
            '                                                    <div class="row">\n' +
            '                                                        <div class="form-group col-xs-12">\n' +
            '                                                            <label>Business Name</label><small style="color: red;"> (Required Field)</small>\n' +
            '                                                            <input type="text" class="form-control" placeholder="" id="busName-'+i+'" name="busName-'+i+'">\n' +
            '                                                        </div>\n' +
            '                                                    </div>\n' +
            '                                                    <div class="row">\n' +
            '                                                        <div class="form-group col-xs-4">\n' +
            '                                                            <label>*Unit #/Building, Street Name/Number, Subd., Brgy.*</label><small style="color: red;"> (Required Field)</small>\n' +
            '                                                            <input type="text" class="form-control" placeholder="" id="addressBus-'+i+'" name="addressBus-'+i+'">\n' +
            '                                                        </div>\n' +
            '                                                        <div class="form-group col-xs-4">\n' +
            '                                                            <label>*District/Municipality*</label><small style="color: red;"> (Required Field)</small>\n' +
            '                                                            <input type="text" class="form-control" placeholder="" id="municipalityBus-'+i+'" name="municipalityBus-'+i+'">\n' +
            '                                                        </div>\n' +
            '                                                        <div class="form-group col-xs-4">\n' +
            '                                                            <label>*City/Province*</label><small style="color: red;"> (Required Field)</small>\n' +
            '                                                            <input type="text" class="form-control" placeholder="" id="provinceBus-'+i+'" name="provinceBus-'+i+'" disabled>\n' +
            '                                                        </div>\n' +
            '                                                    </div>\n' +
            '                                                    <span id="addBus"></span>'
        );
        autocompsbus(i);
        bus(i);
    }
});

function autocompsbus(i)
{
    $('#municipalityBus-'+i+'').focusout(function () {
        if ($('#municipalityBus-'+i+'').val() === '')
        {
            $('#provinceBus-'+i+'').val('');
        }
        else
        {
            $.ajax
            ({
                method: 'get',
                url: '/fetch-city-muniv2',
                data:
                    {
                        'muniname' :  $('#municipalityBus-'+i+'').val()
                    },
                success: function (data)
                {
                    $('#idMuniBus-'+i+'').val(data[0].province_id);
                    $('#idMuniOriginalBus-'+i+'').val(data[0].id);

                    fetchProvBvrr(i);

                    setTimeout(function () {
                        $('#municipalityBus-'+i+'').val(data[0].muni_name)
                    },1000);
                }
            });
        }
    });
}

function bus(i)
{
    $('#municipalityBus-'+i+'').autocomplete
    ({
        source: '/fetch-city-muni',
        minLength: 1,
        select: function (event, ui)
        {
            $('#idMuniBus-'+i+'').val(ui.item.muniID);
            $('#idMuniOriginalBus-'+i+'').val(ui.item.originalMuniID);
            var clearTimee = setInterval(function ()
            {
                fetchProvBvrr(i);
                clearInterval(clearTimee);
            },10)
        }
    });
}

function fetchProvBvrr(i)
{
    muniID = $('#idMuniBus-'+i+'').val();
    originalMuniID = $('#idMuniOriginalBus-'+i+'').val();
    $.ajax
    ({
        method: 'get',
        url: 'fetch-prov',
        data:
            {
                'muniID': muniID,
                'originalMuniID': originalMuniID
            },
        success: function (data)
        {
            $('#provinceBus-'+i+'').val('');
            $('#idEtarBus-'+i+'').val('');
            $('#provinceBus-'+i+'').val(data[0][0].name);
            $('#idEtarBus-'+i+'').val(btoa(data[1][0].rate));
        }
    });
}

function isEmptyOrSpaces(str)
{
    return str === null || str.match(/^ *$/) !== null;
}

$('#btnSelectForm').on('change', function ()
{
    if($('#btnSelectForm').val()==='PDRN')
    {
        corporatetrigger = false;

        $('#formContent').html('');
        $('#otherBranchHide').hide();
        $('#otherAddressHide').show();
        $('#adjustWidthBvr').addClass('col-md-4');
        tol = '';

        if(document.getElementById('tosSubject').checked === true)
        {
            var pdrnTemplate =
                '<div class="row">' +
                '   <div class="col-md-12">' +
                '       <form action="#">' +
                acctAddTemp+
                multiCoborrowerTemp+
                otherInfoTemp+
                requestorInfoTemp+
                '           <button type="button" class="btn-lg btn-success pull-right" id="endorseSend">SEND</button>' +
                '       </form>' +
                '   </div>' +
                '</div>';
        }
        else if(document.getElementById('tosCob').checked === true)
        {
            if(checkercountcoob>0)
            {
                alert('test');
            }
            else
            {
                var pdrnTemplate =
                    '<div class="row">' +
                    '   <div class="col-md-12">' +
                    '       <form action="#">' +
                    acctAddTemp+
                    otherInfoTemp+
                    requestorInfoTemp+
                    '           <button type="button" class="btn-lg btn-success pull-right" id="endorseSend">SEND</button>' +
                    '       </form>' +
                    '   </div>' +
                    '</div>';
            }
        }

        $('#formContent').append(pdrnTemplate);

        if(document.getElementById('tosSubject').checked === true)
        {
            $('#loanType').attr('disabled',false);
        }
        else if(document.getElementById('tosCob').checked === true)
        {
            $('#loanType').attr('disabled',true);
        }

        fetchMuni();

        $('#municipality').on('change',function ()
        {
            setTimeout(function () {
                if(isEmptyOrSpaces($('#municipality').val())||$('#municipality').val()=='')
                {
                    $('#province').val('');
                }
                if(isEmptyOrSpaces($('#province').val())||$('#province').val()=='')
                {
                    alert("Please choose City/Municipality Under Suggestion List");
                    $('#municipality').focus();
                }
            },2000);

        });

        $('#municipality').focusout(function ()
        {
            if($('#municipality').val() === '')
            {
                $('#province').val('');
            }
            else
            {
                $.ajax
                ({
                    method: 'get',
                    url: '/fetch-city-muniv2',
                    data:
                        {
                            'muniname' : $('#municipality').val()
                        },
                    success: function (data)
                    {
                        $('#idMuni').val(data[0].province_id);
                        $('#idMuniOriginal').val(data[0].id);
                        fetchProv();

                        setTimeout(function () {
                            $('#municipality').val(data[0].muni_name)
                        },1000);
                    },
                });
            }
        });

        $.ajax
        ({
            method: 'get',
            url: 'gen-session-info',
            success: function (data)
            {
                if(data[0]!=null)
                {
                    $('#modal-load-session').modal();
                }
            },
            complete:function()
            {
                if($('#dealer_name').length > 0 && $('#contract_number').length > 0)
                {
                    $('#loanType').val('Auto Loan');
                }
            }
        });
    }
    else if($('#btnSelectForm').val()==='EVR')
    {
        corporatetrigger = false;

        $('#formContent').html('');
        $('#otherBranchHide').show();
        $('#otherAddressHide').hide();
        $('#adjustWidthBvr').addClass('col-md-4');

        tol = '';

        if(document.getElementById('tosSubject').checked === true)
        {
            var evrTemplate =
                '<div class="row">' +
                '   <div class="col-md-12">' +
                '       <form action="#">' +
                acctAddTempEvBv+
                empInfoTemp+
                // multiCoborrowerTemp+
                otherInfoTemp+
                requestorInfoTemp+
                '           <button type="button" class="btn-lg btn-success pull-right" id="endorseSend">SEND</button>' +
                '       </form>' +
                '   </div>' +
                '</div>';
        }
        else if(document.getElementById('tosCob').checked === true)
        {
            var evrTemplate =
                '<div class="row">' +
                '   <div class="col-md-12">' +
                '       <form action="#">' +
                acctAddTempEvBv+
                empInfoTemp+
                otherInfoTemp+
                requestorInfoTemp+
                '           <button type="button" class="btn-lg btn-success pull-right" id="endorseSend">SEND</button>' +
                '       </form>' +
                '   </div>' +
                '</div>';
        }

        $('#formContent').append(evrTemplate);

        if(document.getElementById('tosSubject').checked === true)
        {
            $('#loanType').attr('disabled',false);
        }
        else if(document.getElementById('tosCob').checked === true)
        {
            $('#loanType').attr('disabled',true);
        }

        fetchMuniEvr();

        $('#municipalityEmp-0').on('change',function ()
        {
            if(isEmptyOrSpaces($('#municipalityEmp-0').val())||$('#municipalityEmp-0').val()=='')
            {
                $('#provinceEmp-0').val('');
            }
        });
        $('#radioCorp').hide();
        autocompsemp(0);

        $.ajax
        ({
            method: 'get',
            url: 'gen-session-info',
            success: function (data)
            {
                if(data[0]!=null)
                {
                    $('#modal-load-session').modal();
                }
            },
            complete:function()
            {
                if($('#dealer_name').length > 0 && $('#contract_number').length > 0)
                {
                    $('#loanType').val('Auto Loan');
                }
            }
        });
    }
    else if($('#btnSelectForm').val()==='BVR')
    {
        $('#formContent').html('');
        $('#otherBranchHide').show();
        $('#otherAddressHide').hide();
        $('#adjustWidthBvr').addClass('col-md-4');
        tol = '';

        if(document.getElementById('tosSubject').checked === true)
        {
            var bvrTemplate =
                '<div class="row">' +
                '   <div class="col-md-12">' +
                '       <form action="#">' +
                acctAddTempEvBv+
                busInfoTemp+
                // multiCoborrowerTemp+
                otherInfoTemp+
                requestorInfoTemp+
                '           <button type="button" class="btn-lg btn-success pull-right" id="endorseSend">SEND</button>' +
                '       </form>' +
                '   </div>' +
                '</div>';
        }
        else if(document.getElementById('tosCob').checked === true)
        {
            var bvrTemplate =
                '<div class="row">' +
                '   <div class="col-md-12">' +
                '       <form action="#">' +
                acctAddTempEvBv+
                busInfoTemp+
                otherInfoTemp+
                requestorInfoTemp+
                '           <button type="button" class="btn-lg btn-success pull-right" id="endorseSend">SEND</button>' +
                '       </form>' +
                '   </div>' +
                '</div>';
        }

        $('#formContent').append(bvrTemplate);

        if(document.getElementById('tosSubject').checked === true)
        {
            $('#loanType').attr('disabled',false);
        }
        else if(document.getElementById('tosCob').checked === true)
        {
            $('#loanType').attr('disabled',true);
        }

        fetchMuniBvr();

        $('#municipalityEmp-0').on('change',function ()
        {
            if(isEmptyOrSpaces($('#municipalityBus-0').val())||$('#municipalityBus-0').val()=='')
            {
                $('#provinceBus-0').val('');
            }
        });
        autocompsbus(0);
        $("input[name=optradioCorp]:radio").change(function ()
        {
            if ($("#personalRequest").is(":checked"))
            {
                $('#acctFName').attr('disabled',false);
                $('#acctMName').attr('disabled',false);
                $('#acctLName').attr('disabled',false);
                $('#acctFName').val('');
                $('#acctMName').val('');
                $('#acctLName').val('');
                corporatetrigger = false;
            }
            else
            {
                corporatetrigger = true;
                $('#acctFName').attr('disabled',true);
                $('#acctMName').attr('disabled',true);
                $('#acctLName').attr('disabled',true);
                $('#acctFName').val('Corporate Request');
                $('#acctMName').val('Corporate Request');
                $('#acctLName').val('Corporate Request');
            }
        });
    }
    else
    {
        $('#formContent').html('');
    }

    //if user is the
    splitter = splitterdata.split(') ');
    if(splitterdata.indexOf('(Client)') >= 0)
    {

        $('#requestorName').val(splitter[1]);
        $('#requestorName').attr('disabled', 'disabled');

    }
    else if(splitterdata.indexOf('(Supvr)') >= 0)
    {

        $('#requestorName').val(splitter[1]);
        $('#requestorName').attr('disabled', 'disabled')
    }

    $.ajax
    ({
        method: 'get',
        url: 'gen-session-info',
        success: function (data)
        {
            console.log(data);
            if(data[0]!=null)
            {
                $('#modal-load-session').modal();
            }
        },
        complete:function()
        {
            if($('#dealer_name').length > 0 && $('#contract_number').length > 0)
            {
                $('#loanType').val('Auto Loan');
            }
        }
    });
});

function radioBtnCorp()
{
    $("input[name=optradioCorp]:radio").change(function ()
    {
        if ($("#personalRequest").is(":checked"))
        {
            $('#acctFName').attr('disabled',false);
            $('#acctMName').attr('disabled',false);
            $('#acctLName').attr('disabled',false);
            $('#acctFName').val('');
            $('#acctMName').val('');
            $('#acctLName').val('');
        }
        else
        {
            $('#acctFName').attr('disabled',true);
            $('#acctMName').attr('disabled',true);
            $('#acctLName').attr('disabled',true);
            $('#acctFName').val('Corporate Request');
            $('#acctMName').val('Corporate Request');
            $('#acctLName').val('Corporate Request');
        }
    });
}

function autocompleteCob() {

    $('#txtSubjectName').autocomplete(
        {
            source: '/fetch-subjcoob',
            minLength: 1,
            select: function (event, ui)
            {
                $('#txtSubjectName').attr('name',ui.item.id);
            }
        }
    )
}

function fetchMuni()
{
    $('#municipality').autocomplete
    ({
        source: '/fetch-city-muni',
        minLength: 1,
        select: function (event, ui)
        {
            console.log(ui.item.muniID);
            $('#idMuni').val(ui.item.muniID);
            $('#idMuniOriginal').val(ui.item.originalMuniID);
            var clearTime = setInterval(function ()
            {
                fetchProv();
                clearInterval(clearTime);
            },10)
        }
    })
}

function fetchProv()
{
    muniID = $('#idMuni').val();
    originalMuniID = $('#idMuniOriginal').val();
    $.ajax
    ({
        method: 'get',
        url: 'fetch-prov',
        data:
            {
                'muniID': muniID,
                'originalMuniID': originalMuniID
            },
        beforeSend: function ()
        {
            $('#loadingProv').append('<img src= "dist/img/loading.gif" width="3%">');
        },
        success: function (data)
        {
            $('#loadingProv').html('');
            $('#province').val('');
            $('#idEtar').val('');
            $('#province').val(data[0][0].name);
            $('#idEtar').val(btoa(data[1][0].rate));

            if(splitterdata == 'Individual Client')
            {
                if(data[1][0].rate != '')
                {
                    indi_rate.push(data[1][0].rate);
                }
                else
                {
                    indi_rate.push(500);
                }
            }
        }
    });
}

function fetchMuniEvr()
{
    $('#municipalityEmp-0').autocomplete
    ({
        source: '/fetch-city-muni',
        minLength: 1,
        select: function (event, ui)
        {
            $('#idMuniEmp-0').val(ui.item.muniID);
            $('#idMuniOriginalEmp-0').val(ui.item.originalMuniID);
            var clearTimee = setInterval(function ()
            {
                fetchProvEvr();
                clearInterval(clearTimee);
            },100)
        }
    })
}

function fetchProvEvr()
{
    muniID = $('#idMuniEmp-0').val();
    originalMuniID = $('#idMuniOriginalEmp-0').val();
    $.ajax
    ({
        method: 'get',
        url: 'fetch-prov',
        data:
            {
                'muniID': muniID,
                'originalMuniID': originalMuniID
            },
        success: function (data)
        {
            $('#provinceEmp-0').val('');
            $('#idEtarEmp-0').val('');
            $('#provinceEmp-0').val(data[0][0].name);
            $('#idEtarEmp-0').val(btoa(data[1][0].rate));
        }
    });
}

function fetchMuniBvr()
{
    $('#municipalityBus-0').autocomplete
    ({
        source: '/fetch-city-muni',
        minLength: 1,
        select: function (event, ui)
        {
            $('#idMuniBus-0').val(ui.item.muniID);
            $('#idMuniOriginalBus-0').val(ui.item.originalMuniID);
            var clearTimee = setInterval(function ()
            {
                fetchProvBvr();
                clearInterval(clearTimee);
            },100)
        }
    })
}

function fetchProvBvr()
{
    muniID = $('#idMuniBus-0').val();
    originalMuniID = $('#idMuniOriginalBus-0').val();
    $.ajax
    ({
        method: 'get',
        url: 'fetch-prov',
        data:
            {
                'muniID': muniID,
                'originalMuniID': originalMuniID
            },
        success: function (data)
        {
            $('#provinceBus-0').val('');
            $('#idEtarBus-0').val('');

            $('#provinceBus-0').val(data[0][0].name);
            $('#idEtarBus-0').val(btoa(data[1][0].rate));
        }
    });
}

$('#btnYesSession').click(function ()
{

    $.ajax
    ({
        method: 'get',
        url: 'gen-session-info',
        success: function (data)
        {

            if(document.getElementById('tosCob').checked === true)
            {
                var coobsubj =  (data[0]+' '+data[1]+' '+data[2]).toUpperCase();

                console.log(data[10]);


                if($('#txtSubjectName').val()!='')
                {
                    console.log('not null');

                }
                else if(data[10] == null || data[10] == '')
                {
                    console.log('null');
                    $('#txtSubjectName').val(coobsubj);

                }
                else
                {
                    $('#txtSubjectName').val(data[10]);

                }
                $('#loanType').val(data[3]);
                $('#txtVerifyThrough').val(data[5]);
                $('#address').val(data[6]);
                $('#municipality').val(data[7]);
                $('#idMuniOriginal').val(data[8]);
                $('#idMuni').val(data[9]);
                $('#dealer_name').val(data[11]);
                $('#contract_number').val(data[12]);
            }
            else
            {
                $('#acctFName').val(data[0]);
                $('#acctMName').val(data[1]);
                $('#acctLName').val(data[2]);
                $('#loanType').val(data[3]);
                $('#txtVerifyThrough').val(data[5]);
                $('#address').val(data[6]);
                $('#municipality').val(data[7]);
                $('#idMuniOriginal').val(data[8]);
                $('#idMuni').val(data[9]);
                $('#dealer_name').val(data[11]);
                $('#contract_number').val(data[12]);
                //FOR BVR LOAD SESSION
                $('#addressBus-0').val(data[6]);
                $('#municipalityBus-0').val(data[7]);
                $('#idMuniOriginalBus-0').val(data[8]);
                $('#idMuniBus-0').val(data[9]);
            }

        },
        complete: function ()
        {
            var clearProvBVR = setInterval(function ()
            {
                fetchProvBvr();
                fetchProv();
                clearInterval(clearProvBVR);
            },300);
            if($('#dealer_name').length > 0 && $('#contract_number').length > 0)
            {
                $('#loanType').val('Auto Loan');
            }
        }

    });

});

$('#btnNewSession').click(function ()
{
    $.ajax
    ({
        method: 'get',
        url: 'gen-destroy-session',
        complete: function()
        {
            if($('#dealer_name').length > 0 && $('#contract_number').length)
            {
                $('#dealer_name').val('');
                $('#contract_number').val('');
            }
        }
    });
});

$('#client-history-table , #client-revised-account , #client-finish-account , #client-hold-account , #client-cancel-account').on('click', '#btnFullViewInfo', function (e)
{
    acctID = '';
    acctID = $(this).attr("href");
    $('#spanhere-client').html('');
    $('#history-client').html('');
    $('#otherInfoSpan-client').html('');
    $('#otherEmployerSpan-client').html('');
    $('#otherBusinessSpan-client').html('');
    $('#titleEndorsement-client').show();
    $('#titleHistory-client').show();

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
                $('#spanhere-client').append('No Data Found' +'<br>') ;
            }
            else
            {
                $('#spanhere-client').append
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
                    '                  <td style="padding: 3px;"><span class="badge bg-red">REQUESTOR</span></td>\n' +
                    '                  <td style="padding: 3px;">'+data[0][0].requestor_name +'</td>\n' +
                    '                </tr>\n' +

                    '                <tr>\n' +
                    '                  <td style="padding: 3px;"><span class="badge bg-red">TIME FORWARDED TO CLIENT</span></td>\n' +
                    '                  <td style="padding: 3px;">'+data[0][0].time_forwarded_to_client+'</td>\n' +
                    '                  <td style="padding: 3px;"><span class="badge bg-red">DATE FORWARDED TO CLIENT</span></td>\n' +
                    '                  <td style="padding: 3px;">'+data[0][0].date_forwarded_to_client+'</td>\n' +
                    '                </tr>\n' +

                    '                <tr>\n' +
                    '                  <td style="padding: 3px;"><span class="badge bg-red">STATUS EXTERNAL</span></td>\n' +
                    '                  <td style="padding: 3px;">'+data[0][0].endorsement_status_external +'</td>\n' +
                    '                  <td style="padding: 3px;"><span class="badge bg-red">PICTURE STATUS</span></td>\n' +
                    '                  <td style="padding: 3px;">'+data[0][0].picture_status+'</td>\n' +
                    '                </tr>\n' +

                    '                <tr>\n' +
                    '                  <td style="padding: 3px;"><span class="badge bg-red">VERIFY THROUGH</span></td>\n' +
                    '                  <td style="padding: 3px;">'+data[0][0].verify_through+'</td>\n' +
                    '                  <td style="padding: 3px;"><span class="badge bg-red">DISPATCHER</span></td>\n' +
                    '                  <td style="padding: 3px;">'+data[0][0].handled_by_dispatcher+'</td>\n' +
                    '                </tr>\n' +

                    '                <tr>\n' +
                    '                  <td style="padding: 3px;"><span class="badge bg-red">SENIOR ACCOUNT OFFICER</span></td>\n' +
                    '                  <td style="padding: 3px;">'+data[0][0].assigned_by_srao+'</td>\n' +
                    '                  <td style="padding: 3px;"><span class="badge bg-red">ACCOUNT OFFICER</span></td>\n' +
                    '                  <td style="padding: 3px;">'+data[0][0].handled_by_account_officer+'</td>\n' +
                    '                </tr>\n' +

                    '                <tr>\n' +
                    '                  <td style="padding: 3px;"><span class="badge bg-red">CREDIT INVESTIGATOR</span></td>\n' +
                    '                  <td style="padding: 3px;">'+data[0][0].handled_by_credit_investigator+'</td>\n' +
                    '                  <td style="padding: 3px;"><span class="badge bg-red">REMARKS</span></td>\n' +
                    '                  <td style="padding: 3px;">'+data[0][0].remarks+'</td>\n' +
                    '                </tr>\n' +

                    '                <tr>\n' +
                    '                  <td style="padding: 3px;"><span class="badge bg-red">DATE VISIT</span></td>\n' +
                    '                  <td style="padding: 3px;">'+data[0][0].date_ci_visit+'</td>\n' +
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

                $('#history-client').html
                (
                    '<tr style="background-color: brown; color: white">' +
                    '<th style=\'text-align: center;\'>NAME</th>' +
                    '<th style=\'text-align: center;\'>POSITION</th>' +
                    '<th style=\'text-align: center;\'>ACTIVITIES</th>' +
                    '<th style=\'text-align: center;\'>DATE OCCURED</th>' +
                    '<th style=\'text-align: center;\'>TIME OCCURED</th>' +
                    '</tr>'
                );

                $('#otherInfoSpan-client').html
                (
                    '<tr style="background-color: brown; color: white">' +
                    '   <th style=\'text-align: center;\'>COBORROWER NAME</th>' +
                    '   <th style=\'text-align: center;\'>ADDRESS</th>' +
                    '   <th style=\'text-align: center;\'>CITY/MUNICIPALITY</th>' +
                    '   <th style=\'text-align: center;\'>PROVINCE</th>' +
                    '</tr>'
                );
                $('#otherEmployerSpan-client').html
                (
                    '<tr style="background-color: brown; color: white">' +
                    '   <th style=\'text-align: center;\'>EMPLOYER NAME</th>' +
                    '   <th style=\'text-align: center;\'>ADDRESS</th>' +
                    '   <th style=\'text-align: center;\'>CITY/MUNICIPALITY</th>' +
                    '   <th style=\'text-align: center;\'>PROVINCE</th>' +
                    '</tr>'
                );
                $('#otherBusinessSpan-client').html
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
                    $('#history-client').append
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
                    $('#otherInfoSpan-client').append
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
                    $('#otherEmployerSpan-client').append
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
                    $('#otherBusinessSpan-client').append
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
                    $('#otherInfoSpan-client').hide();
                }
                else
                {
                    $('#otherInfoSpan-client').show();
                }

                if(data[3].length===0)
                {
                    $('#otherEmployerSpan-client').hide();
                }
                else
                {
                    $('#otherEmployerSpan-client').show();
                }

                if(data[4].length===0)
                {
                    $('#otherBusinessSpan-client').hide();
                }
                else
                {
                    $('#otherBusinessSpan-client').show();
                }

                $('#txtNote').val('');

                if(typeof(data[5][0]) === 'undefined')
                {
                    console.log('add note');
                    $('#spanNotes').html('');
                    $('#spanNotes').append
                    (
                        '<button id="report_issue" name="'+acctID+'" type="button" class="btn btn-warning col-sm-2" data-dismiss="modal" data-toggle="modal" data-target="#modal-default">Report Issue</button>'+
                        '<a class="btn btn-primary" id="btnAddNote" ><i class="glyphicon glyphicon-pencil"></i> ADD NOTE</a>\n'
                    );
                }
                else if(data[5][0].nonotes!==null)
                {
                    console.log('update note');
                    $('#spanNotes').html('');
                    $('#txtNote').val(data[5][0].nonotes);
                    $('#spanNotes').append
                    (
                        '<button id="report_issue" name="'+acctID+'" type="button" class="btn btn-warning col-sm-2" data-dismiss="modal" data-toggle="modal" data-target="#modal-default">Report Issue</button>'+
                        '<a class="btn btn-warning" id="btnUpdateNote" ><i class="glyphicon glyphicon-pencil"></i> UPDATE NOTE</a>'
                    );
                }

                //report issue
                $('#report_issue').click(function () {


                    $('#TitleSuggestion').val('ID:'+$('#report_issue').attr('name')+'; ACCOUNT NAME: '+data[0][0].account_name);
                    $('#TitleSuggestion').attr('disabled','disabled')
                    // console.log('qqqq??');


                });
            }
        }
    });
});

$('#client-finish-downlaoded').on('click', '#btnFullViewInfo-success', function ()
{
    console.log('test');
    acctID = '';
    acctID = $(this).attr("href");
    $('#spanhere-client').html('');
    $('#history-client').html('');
    $('#otherInfoSpan-client').html('');
    $('#otherEmployerSpan-client').html('');
    $('#otherBusinessSpan-client').html('');
    $('#titleEndorsement-client').show();
    $('#titleHistory-client').show();

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
                $('#spanhere-client').append('No Data Found' +'<br>') ;
            }
            else
            {
                $('#spanhere-client').append
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
                    '                  <td style="padding: 3px;"><span class="badge bg-red">REQUESTOR</span></td>\n' +
                    '                  <td style="padding: 3px;">'+data[0][0].requestor_name +'</td>\n' +
                    '                </tr>\n' +

                    '                <tr>\n' +
                    '                  <td style="padding: 3px;"><span class="badge bg-red">TIME FORWARDED TO CLIENT</span></td>\n' +
                    '                  <td style="padding: 3px;">'+data[0][0].time_forwarded_to_client+'</td>\n' +
                    '                  <td style="padding: 3px;"><span class="badge bg-red">DATE FORWARDED TO CLIENT</span></td>\n' +
                    '                  <td style="padding: 3px;">'+data[0][0].date_forwarded_to_client+'</td>\n' +
                    '                </tr>\n' +

                    '                <tr>\n' +
                    '                  <td style="padding: 3px;"><span class="badge bg-red">STATUS EXTERNAL</span></td>\n' +
                    '                  <td style="padding: 3px;">'+data[0][0].endorsement_status_external +'</td>\n' +
                    '                  <td style="padding: 3px;"><span class="badge bg-red">PICTURE STATUS</span></td>\n' +
                    '                  <td style="padding: 3px;">'+data[0][0].picture_status+'</td>\n' +
                    '                </tr>\n' +

                    '                <tr>\n' +
                    '                  <td style="padding: 3px;"><span class="badge bg-red">VERIFY THROUGH</span></td>\n' +
                    '                  <td style="padding: 3px;">'+data[0][0].verify_through+'</td>\n' +
                    '                  <td style="padding: 3px;"><span class="badge bg-red">DISPATCHER</span></td>\n' +
                    '                  <td style="padding: 3px;">'+data[0][0].handled_by_dispatcher+'</td>\n' +
                    '                </tr>\n' +

                    '                <tr>\n' +
                    '                  <td style="padding: 3px;"><span class="badge bg-red">SENIOR ACCOUNT OFFICER</span></td>\n' +
                    '                  <td style="padding: 3px;">'+data[0][0].assigned_by_srao+'</td>\n' +
                    '                  <td style="padding: 3px;"><span class="badge bg-red">ACCOUNT OFFICER</span></td>\n' +
                    '                  <td style="padding: 3px;">'+data[0][0].handled_by_account_officer+'</td>\n' +
                    '                </tr>\n' +

                    '                <tr>\n' +
                    '                  <td style="padding: 3px;"><span class="badge bg-red">CREDIT INVESTIGATOR</span></td>\n' +
                    '                  <td style="padding: 3px;">'+data[0][0].handled_by_credit_investigator+'</td>\n' +
                    '                  <td style="padding: 3px;"><span class="badge bg-red">REMARKS</span></td>\n' +
                    '                  <td style="padding: 3px;">'+data[0][0].remarks+'</td>\n' +
                    '                </tr>\n' +

                    '                <tr>\n' +
                    '                  <td style="padding: 3px;"><span class="badge bg-red">DATE VISIT</span></td>\n' +
                    '                  <td style="padding: 3px;">'+data[0][0].date_ci_visit+'</td>\n' +
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

                $('#history-client').html
                (
                    '<tr style="background-color: brown; color: white">' +
                    '<th style=\'text-align: center;\'>NAME</th>' +
                    '<th style=\'text-align: center;\'>POSITION</th>' +
                    '<th style=\'text-align: center;\'>ACTIVITIES</th>' +
                    '<th style=\'text-align: center;\'>DATE OCCURED</th>' +
                    '<th style=\'text-align: center;\'>TIME OCCURED</th>' +
                    '</tr>'
                );

                $('#otherInfoSpan-client').html
                (
                    '<tr style="background-color: brown; color: white">' +
                    '   <th style=\'text-align: center;\'>COBORROWER NAME</th>' +
                    '   <th style=\'text-align: center;\'>ADDRESS</th>' +
                    '   <th style=\'text-align: center;\'>CITY/MUNICIPALITY</th>' +
                    '   <th style=\'text-align: center;\'>PROVINCE</th>' +
                    '</tr>'
                );
                $('#otherEmployerSpan-client').html
                (
                    '<tr style="background-color: brown; color: white">' +
                    '   <th style=\'text-align: center;\'>EMPLOYER NAME</th>' +
                    '   <th style=\'text-align: center;\'>ADDRESS</th>' +
                    '   <th style=\'text-align: center;\'>CITY/MUNICIPALITY</th>' +
                    '   <th style=\'text-align: center;\'>PROVINCE</th>' +
                    '</tr>'
                );
                $('#otherBusinessSpan-client').html
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
                    $('#history-client').append
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
                    $('#otherInfoSpan-client').append
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
                    $('#otherEmployerSpan-client').append
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
                    $('#otherBusinessSpan-client').append
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
                    $('#otherInfoSpan-client').hide();
                }
                else
                {
                    $('#otherInfoSpan-client').show();
                }

                if(data[3].length===0)
                {
                    $('#otherEmployerSpan-client').hide();
                }
                else
                {
                    $('#otherEmployerSpan-client').show();
                }

                if(data[4].length===0)
                {
                    $('#otherBusinessSpan-client').hide();
                }
                else
                {
                    $('#otherBusinessSpan-client').show();
                }

                $('#txtNote').val('');

                if(typeof(data[5][0]) === 'undefined')
                {
                    console.log('add note');
                    $('#spanNotes').html('');
                    $('#spanNotes').append
                    (
                        '<button id="report_issue" name="'+acctID+'" type="button" class="btn btn-warning col-sm-2" data-dismiss="modal" data-toggle="modal" data-target="#modal-default">Report Issue</button>'+
                        '<a class="btn btn-primary" id="btnAddNote" ><i class="glyphicon glyphicon-pencil"></i> ADD NOTE</a>\n'
                    );
                }
                else if(data[5][0].nonotes!==null)
                {
                    console.log('update note');
                    $('#spanNotes').html('');
                    $('#txtNote').val(data[5][0].nonotes);
                    $('#spanNotes').append
                    (
                        '<button id="report_issue" name="'+acctID+'" type="button" class="btn btn-warning col-sm-2" data-dismiss="modal" data-toggle="modal" data-target="#modal-default">Report Issue</button>'+
                        '<a class="btn btn-warning" id="btnUpdateNote" ><i class="glyphicon glyphicon-pencil"></i> UPDATE NOTE</a>'
                    );
                }

                //report issue
                $('#report_issue').click(function () {


                    $('#TitleSuggestion').val('ID:'+$('#report_issue').attr('name')+'; ACCOUNT NAME: '+data[0][0].account_name);
                    $('#TitleSuggestion').attr('disabled','disabled')
                    // console.log('qqqq??');


                });
            }
        }
    });
});

$('#client-finish-read').on('click', '#btnFullViewInfo-success', function ()
{
    console.log('test');
    acctID = '';
    acctID = $(this).attr("href");
    $('#spanhere-client').html('');
    $('#history-client').html('');
    $('#otherInfoSpan-client').html('');
    $('#otherEmployerSpan-client').html('');
    $('#otherBusinessSpan-client').html('');
    $('#titleEndorsement-client').show();
    $('#titleHistory-client').show();

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
                $('#spanhere-client').append('No Data Found' +'<br>') ;
            }
            else
            {
                $('#spanhere-client').append
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
                    '                  <td style="padding: 3px;"><span class="badge bg-red">REQUESTOR</span></td>\n' +
                    '                  <td style="padding: 3px;">'+data[0][0].requestor_name +'</td>\n' +
                    '                </tr>\n' +

                    '                <tr>\n' +
                    '                  <td style="padding: 3px;"><span class="badge bg-red">TIME FORWARDED TO CLIENT</span></td>\n' +
                    '                  <td style="padding: 3px;">'+data[0][0].time_forwarded_to_client+'</td>\n' +
                    '                  <td style="padding: 3px;"><span class="badge bg-red">DATE FORWARDED TO CLIENT</span></td>\n' +
                    '                  <td style="padding: 3px;">'+data[0][0].date_forwarded_to_client+'</td>\n' +
                    '                </tr>\n' +

                    '                <tr>\n' +
                    '                  <td style="padding: 3px;"><span class="badge bg-red">STATUS EXTERNAL</span></td>\n' +
                    '                  <td style="padding: 3px;">'+data[0][0].endorsement_status_external +'</td>\n' +
                    '                  <td style="padding: 3px;"><span class="badge bg-red">PICTURE STATUS</span></td>\n' +
                    '                  <td style="padding: 3px;">'+data[0][0].picture_status+'</td>\n' +
                    '                </tr>\n' +

                    '                <tr>\n' +
                    '                  <td style="padding: 3px;"><span class="badge bg-red">VERIFY THROUGH</span></td>\n' +
                    '                  <td style="padding: 3px;">'+data[0][0].verify_through+'</td>\n' +
                    '                  <td style="padding: 3px;"><span class="badge bg-red">DISPATCHER</span></td>\n' +
                    '                  <td style="padding: 3px;">'+data[0][0].handled_by_dispatcher+'</td>\n' +
                    '                </tr>\n' +

                    '                <tr>\n' +
                    '                  <td style="padding: 3px;"><span class="badge bg-red">SENIOR ACCOUNT OFFICER</span></td>\n' +
                    '                  <td style="padding: 3px;">'+data[0][0].assigned_by_srao+'</td>\n' +
                    '                  <td style="padding: 3px;"><span class="badge bg-red">ACCOUNT OFFICER</span></td>\n' +
                    '                  <td style="padding: 3px;">'+data[0][0].handled_by_account_officer+'</td>\n' +
                    '                </tr>\n' +

                    '                <tr>\n' +
                    '                  <td style="padding: 3px;"><span class="badge bg-red">CREDIT INVESTIGATOR</span></td>\n' +
                    '                  <td style="padding: 3px;">'+data[0][0].handled_by_credit_investigator+'</td>\n' +
                    '                  <td style="padding: 3px;"><span class="badge bg-red">REMARKS</span></td>\n' +
                    '                  <td style="padding: 3px;">'+data[0][0].remarks+'</td>\n' +
                    '                </tr>\n' +

                    '                <tr>\n' +
                    '                  <td style="padding: 3px;"><span class="badge bg-red">DATE VISIT</span></td>\n' +
                    '                  <td style="padding: 3px;">'+data[0][0].date_ci_visit+'</td>\n' +
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

                $('#history-client').html
                (
                    '<tr style="background-color: brown; color: white">' +
                    '<th style=\'text-align: center;\'>NAME</th>' +
                    '<th style=\'text-align: center;\'>POSITION</th>' +
                    '<th style=\'text-align: center;\'>ACTIVITIES</th>' +
                    '<th style=\'text-align: center;\'>DATE OCCURED</th>' +
                    '<th style=\'text-align: center;\'>TIME OCCURED</th>' +
                    '</tr>'
                );

                $('#otherInfoSpan-client').html
                (
                    '<tr style="background-color: brown; color: white">' +
                    '   <th style=\'text-align: center;\'>COBORROWER NAME</th>' +
                    '   <th style=\'text-align: center;\'>ADDRESS</th>' +
                    '   <th style=\'text-align: center;\'>CITY/MUNICIPALITY</th>' +
                    '   <th style=\'text-align: center;\'>PROVINCE</th>' +
                    '</tr>'
                );
                $('#otherEmployerSpan-client').html
                (
                    '<tr style="background-color: brown; color: white">' +
                    '   <th style=\'text-align: center;\'>EMPLOYER NAME</th>' +
                    '   <th style=\'text-align: center;\'>ADDRESS</th>' +
                    '   <th style=\'text-align: center;\'>CITY/MUNICIPALITY</th>' +
                    '   <th style=\'text-align: center;\'>PROVINCE</th>' +
                    '</tr>'
                );
                $('#otherBusinessSpan-client').html
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
                    $('#history-client').append
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
                    $('#otherInfoSpan-client').append
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
                    $('#otherEmployerSpan-client').append
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
                    $('#otherBusinessSpan-client').append
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
                    $('#otherInfoSpan-client').hide();
                }
                else
                {
                    $('#otherInfoSpan-client').show();
                }

                if(data[3].length===0)
                {
                    $('#otherEmployerSpan-client').hide();
                }
                else
                {
                    $('#otherEmployerSpan-client').show();
                }

                if(data[4].length===0)
                {
                    $('#otherBusinessSpan-client').hide();
                }
                else
                {
                    $('#otherBusinessSpan-client').show();
                }

                $('#txtNote').val('');

                if(typeof(data[5][0]) === 'undefined')
                {
                    console.log('add note');
                    $('#spanNotes').html('');
                    $('#spanNotes').append
                    (
                        '<button id="report_issue" name="'+acctID+'" type="button" class="btn btn-warning col-sm-2" data-dismiss="modal" data-toggle="modal" data-target="#modal-default">Report Issue</button>'+
                        '<a class="btn btn-primary" id="btnAddNote" ><i class="glyphicon glyphicon-pencil"></i> ADD NOTE</a>\n'
                    );
                }
                else if(data[5][0].nonotes!==null)
                {
                    console.log('update note');
                    $('#spanNotes').html('');
                    $('#txtNote').val(data[5][0].nonotes);
                    $('#spanNotes').append
                    (
                        '<button id="report_issue" name="'+acctID+'" type="button" class="btn btn-warning col-sm-2" data-dismiss="modal" data-toggle="modal" data-target="#modal-default">Report Issue</button>'+
                        '<a class="btn btn-warning" id="btnUpdateNote" ><i class="glyphicon glyphicon-pencil"></i> UPDATE NOTE</a>'
                    );
                }

                //report issue
                $('#report_issue').click(function () {


                    $('#TitleSuggestion').val('ID:'+$('#report_issue').attr('name')+'; ACCOUNT NAME: '+data[0][0].account_name);
                    $('#TitleSuggestion').attr('disabled','disabled')
                    // console.log('qqqq??');


                });
            }
        }
    });
});


$('#modal-view-info-client').on('click','#btnAddNote',function ()
{
    console.log('click add note');

    var txtNote = $('#txtNote').val();

    $.ajax
    ({
        method: 'post',
        url: 'client-save-note',
        data:
            {
                'acctID': acctID,
                'txtNote': txtNote
            },
        success: function (data)
        {
            $('#modal-view-info-client').modal('hide');
            if(data==='success')
            {
                table.ajax.reload(null, false);
                alert('Successfully Add Note');
            }
        }
    });
});

$('#modal-view-info-client').on('click', '#btnUpdateNote', function ()
{
    console.log('click update note');
    var txtNote = $('#txtNote').val();
    $.ajax
    ({
        method: 'post',
        url: 'client-update-note',
        data:
            {
                'acctID': acctID,
                'txtNote': txtNote
            },
        success: function (data)
        {
            $('#modal-view-info-client').modal('hide');
            if(data==='success')
            {
                table.ajax.reload(null, false);
                alert('Note Successfully Updated!');
            }
        }
    });
});

//BUTTON FOR DOWNLOAD
$('#client-finish-account').on('click', '#btnDownloadReport', function (e)
{
    var account_id_report = $(this).attr("name");
    Download_report(account_id_report);

    // $.post('/client-audit-download-report',
    //     {
    //         'id': id
    //     },
    //
    //     function (data)
    //     {
    //         if(data==='errorDownload')
    //         {
    //             alert('Report Not Available at this time');
    //         }
    //         else
    //         {
    //             window.location = data;
    //             table.ajax.reload(null, false);
    //         }
    //     });

});

$('#client-finish-read').on('click', '#btnDownloadReport-read', function (e)
{
    var account_id_report = $(this).attr("name");
    Download_report(account_id_report);

    // $.post('/client-audit-download-report',
    //     {
    //         'id': id
    //     },
    //
    //     function (data)
    //     {
    //         if(data==='errorDownload')
    //         {
    //             alert('Report Not Available at this time');
    //         }
    //         else
    //         {
    //             window.location = data;
    //             table.ajax.reload(null, false);
    //         }
    //     });

});

$('#client-finish-downlaoded').on('click', '#btnDownloadReport-download', function (e)
{
    var account_id_report = $(this).attr("name");
    Download_report(account_id_report);

    // $.post('/client-audit-download-report',
    //     {
    //         'id': id
    //     },
    //
    //     function (data)
    //     {
    //         if(data==='errorDownload')
    //         {
    //             alert('Report Not Available at this time');
    //         }
    //         else
    //         {
    //             window.location = data;
    //             table.ajax.reload(null, false);
    //         }
    //     });

});
//END OF BUTTON FOR DOWNLOAD
function Download_report(id) {

    var acct_encode = btoa(id);


    var q = '<form action="/client-audit-download-report" target="_blank" method="get">'+
        '<div class="input-group">'+
        '<input type="text" hidden value="'+acct_encode+'" name="id">'+
        '<button type="submit" id="button_form_download_report">'+
        '</button>'+
        '</span>'+
        '</div>'+
        '</form>';

    $('#download_report').html(q);
    // $('#button_form_download').click(function (e) {
    //     e.preventDefault();
    // });
    $('#button_form_download_report').click();
    tableFinishAccount.draw();
    // window.open('/ao-download-file', '_blank');
    // window.location = '/ao-panel';
}

//BUTTON FOR DOWNLOAD REVISION
$('#client-revised-account').on('click', '#btn_download_revision', function (e)
{
    var id = $(this).attr("name");

    // console.log('click '+id);
    // $.post('/client_audit_download_report_revision',
    //     {
    //         'id': id
    //     },
    //
    //     function (data)
    //     {
    //         if(data==='errorDownload')
    //         {
    //             alert('Report Not Available at this time');
    //         }
    //         else
    //         {
    //             window.location = data;
    //             tableRevisedAccount.ajax.reload(null, false);
    //         }
    //     });
    Download_report_revised(id);    Download_report_revised(id);(id);
    // e.preventDefault();

});
//END OF BUTTON FOR DOWNLOAD REVISION
function Download_report_revised(id) {

    var acct_encode = btoa(id);


    var q = '<form action="/client_audit_download_report_revision" target="_blank" method="get">'+
        '<div class="input-group">'+
        '<input type="text" hidden value="'+acct_encode+'" name="id">'+
        '<button type="submit" id="button_form_download_report_revised">'+
        '</button>'+
        '</span>'+
        '</div>'+
        '</form>';

    $('#download_report_revised').html(q);
    // $('#button_form_download').click(function (e) {
    //     e.preventDefault();
    // });
    $('#button_form_download_report_revised').click();
    // window.open('/ao-download-file', '_blank');
    // window.location = '/ao-panel';
}

//TYPE OF SUBJECT AND SUBJECT NAME
var go_shoot = false;

$(document).ready(function ()
{

    $('#NewEndorsement').on('ifChecked',function()
    {
        validationTOR()
    });

    $('#ReVisit').on('ifChecked',function()
    {
        validationTOR()
    });

    $('#otherBranch').on('ifChecked',function()
    {
        validationTOR()
    });

    $('#tosSubject').on('ifChecked',function()
    {
        validationTOS()
    });

    $('#tosCob').on('ifChecked',function()
    {
        validationTOS()
    });

    $('#PDRNrad').on('ifChecked', function()
    {
        $('.type_req_rad_but').each(function()
        {
            if($(this).is(':checked'))
            {
                // console.log($(this).val());
                req_checker = $(this).val();

                check_if_direct = true;
                corporatetrigger = false;

                $('#formContent').html('');
                $('#otherBranchHide').hide();
                $('#otherAddressHide').show();
                $('#adjustWidthBvr').addClass('col-md-4');
                tol = '';

                if(document.getElementById('tosSubject').checked === true)
                {
                    var pdrnTemplate =
                        '<div class="row">' +
                        '   <div class="col-md-12">' +
                        '       <form action="#">' +
                        acctAddTemp+
                        multiCoborrowerTemp+
                        otherInfoTemp+
                        requestorInfoTemp+
                        '           <button type="button" class="btn-lg btn-success pull-right" id="endorseSend">SEND</button>' +
                        '       </form>' +
                        '   </div>' +
                        '</div>';
                }
                else if(document.getElementById('tosCob').checked === true)
                {
                    if(checkercountcoob>0)
                    {
                        alert('test');
                    }
                    else
                    {
                        var pdrnTemplate =
                            '<div class="row">' +
                            '   <div class="col-md-12">' +
                            '       <form action="#">' +
                            acctAddTemp+
                            otherInfoTemp+
                            requestorInfoTemp+
                            '           <button type="button" class="btn-lg btn-success pull-right" id="endorseSend">SEND</button>' +
                            '       </form>' +
                            '   </div>' +
                            '</div>';
                    }
                }

                $('#formContent').append(pdrnTemplate);

                if(document.getElementById('tosSubject').checked === true)
                {
                    $('#loanType').attr('disabled',false);
                }
                else if(document.getElementById('tosCob').checked === true)
                {
                    $('#loanType').attr('disabled',true);
                }

                fetchMuni();

                $('#municipality').on('change',function ()
                {
                    setTimeout(function () {
                        if(isEmptyOrSpaces($('#municipality').val())||$('#municipality').val()=='')
                        {
                            $('#province').val('');
                        }
                        if(isEmptyOrSpaces($('#province').val())||$('#province').val()=='')
                        {
                            alert("Please choose City/Municipality Under Suggestion List");
                            $('#municipality').focus();
                        }
                    },2000);

                });

                $('#municipality').focusout(function ()
                {
                    if($('#municipality').val() === '')
                    {
                        $('#province').val('');
                    }
                    else
                    {
                        $.ajax
                        ({
                            method: 'get',
                            url: '/fetch-city-muniv2',
                            data:
                                {
                                    'muniname' : $('#municipality').val()
                                },
                            success: function (data)
                            {
                                $('#idMuni').val(data[0].province_id);
                                $('#idMuniOriginal').val(data[0].id);
                                fetchProv();

                                setTimeout(function () {
                                    $('#municipality').val(data[0].muni_name)
                                },1000);
                            }
                        });
                    }
                });

                $.ajax
                ({
                    method: 'get',
                    url: 'gen-session-info',
                    success: function (data)
                    {
                        if(data[0]!=null)
                        {
                            $('#modal-load-session').modal();
                        }
                    },
                    complete:function()
                    {
                        if($('#dealer_name').length > 0 && $('#contract_number').length > 0)
                        {
                            $('#loanType').val('Auto Loan');
                        }
                    }
                });
            }
        });

    });

    $('#BVRrad').on('ifChecked', function()
    {
        $('.type_req_rad_but').each(function()
        {
            if($(this).is(':checked'))
            {
                // console.log($(this).val());
                req_checker = $(this).val();

                check_if_direct = true;

                $('#formContent').html('');
                $('#otherBranchHide').show();
                $('#otherAddressHide').hide();
                $('#adjustWidthBvr').addClass('col-md-4');
                tol = '';

                if(document.getElementById('tosSubject').checked === true)
                {
                    var bvrTemplate =
                        '<div class="row">' +
                        '   <div class="col-md-12">' +
                        '       <form action="#">' +
                        acctAddTempEvBv+
                        busInfoTemp+
                        // multiCoborrowerTemp+
                        otherInfoTemp+
                        requestorInfoTemp+
                        '           <button type="button" class="btn-lg btn-success pull-right" id="endorseSend">SEND</button>' +
                        '       </form>' +
                        '   </div>' +
                        '</div>';
                }
                else if(document.getElementById('tosCob').checked === true)
                {
                    var bvrTemplate =
                        '<div class="row">' +
                        '   <div class="col-md-12">' +
                        '       <form action="#">' +
                        acctAddTempEvBv+
                        busInfoTemp+
                        otherInfoTemp+
                        requestorInfoTemp+
                        '           <button type="button" class="btn-lg btn-success pull-right" id="endorseSend">SEND</button>' +
                        '       </form>' +
                        '   </div>' +
                        '</div>';
                }

                $('#formContent').append(bvrTemplate);

                if(document.getElementById('tosSubject').checked === true)
                {
                    $('#loanType').attr('disabled',false);
                }
                else if(document.getElementById('tosCob').checked === true)
                {
                    $('#loanType').attr('disabled',true);
                }

                fetchMuniBvr();

                $('#municipalityEmp-0').on('change',function ()
                {
                    if(isEmptyOrSpaces($('#municipalityBus-0').val())||$('#municipalityBus-0').val()=='')
                    {
                        $('#provinceBus-0').val('');
                    }
                });
                autocompsbus(0);
                $("input[name=optradioCorp]:radio").change(function ()
                {
                    if ($("#personalRequest").is(":checked"))
                    {
                        $('#acctFName').attr('disabled',false);
                        $('#acctMName').attr('disabled',false);
                        $('#acctLName').attr('disabled',false);
                        $('#acctFName').val('');
                        $('#acctMName').val('');
                        $('#acctLName').val('');
                        corporatetrigger = false;
                    }
                    else
                    {
                        corporatetrigger = true;
                        $('#acctFName').attr('disabled',true);
                        $('#acctMName').attr('disabled',true);
                        $('#acctLName').attr('disabled',true);
                        $('#acctFName').val('Corporate Request');
                        $('#acctMName').val('Corporate Request');
                        $('#acctLName').val('Corporate Request');
                    }
                });
            }
        });
    });

    $('#EVRrad').on('ifChecked', function()
    {
        $('.type_req_rad_but').each(function()
        {
            if($(this).is(':checked'))
            {
                // console.log($(this).val());
                req_checker = $(this).val();

                check_if_direct = true;
                corporatetrigger = false;

                $('#formContent').html('');
                $('#otherBranchHide').show();
                $('#otherAddressHide').hide();
                $('#adjustWidthBvr').addClass('col-md-4');

                tol = '';

                if(document.getElementById('tosSubject').checked === true)
                {
                    var evrTemplate =
                        '<div class="row">' +
                        '   <div class="col-md-12">' +
                        '       <form action="#">' +
                        acctAddTempEvBv+
                        empInfoTemp+
                        // multiCoborrowerTemp+
                        otherInfoTemp+
                        requestorInfoTemp+
                        '           <button type="button" class="btn-lg btn-success pull-right" id="endorseSend">SEND</button>' +
                        '       </form>' +
                        '   </div>' +
                        '</div>';
                }
                else if(document.getElementById('tosCob').checked === true)
                {
                    var evrTemplate =
                        '<div class="row">' +
                        '   <div class="col-md-12">' +
                        '       <form action="#">' +
                        acctAddTempEvBv+
                        empInfoTemp+
                        otherInfoTemp+
                        requestorInfoTemp+
                        '           <button type="button" class="btn-lg btn-success pull-right" id="endorseSend">SEND</button>' +
                        '       </form>' +
                        '   </div>' +
                        '</div>';
                }

                $('#formContent').append(evrTemplate);

                if(document.getElementById('tosSubject').checked === true)
                {
                    $('#loanType').attr('disabled',false);
                }
                else if(document.getElementById('tosCob').checked === true)
                {
                    $('#loanType').attr('disabled',true);
                }

                fetchMuniEvr();

                $('#municipalityEmp-0').on('change',function ()
                {
                    if(isEmptyOrSpaces($('#municipalityEmp-0').val())||$('#municipalityEmp-0').val()=='')
                    {
                        $('#provinceEmp-0').val('');
                    }
                });
                $('#radioCorp').hide();
                autocompsemp(0);

                $.ajax
                ({
                    method: 'get',
                    url: 'gen-session-info',
                    success: function (data)
                    {
                        if(data[0]!=null)
                        {
                            $('#modal-load-session').modal();
                        }
                    },
                    complete:function()
                    {
                        if($('#dealer_name').length > 0 && $('#contract_number').length > 0)
                        {
                            $('#loanType').val('Auto Loan');
                        }
                    }
                });
            }
        });
    });

    function validationTOR()
    {
        if(document.getElementById('NewEndorsement').checked === true)
        {
            alert('You set type of endorsement to New Endorsement');
        }
        else if(document.getElementById('ReVisit').checked === true)
        {
            alert('You set type of endorsement to Re-Visit');
        }
        else if(document.getElementById('otherBranch').checked === true)
        {
            alert('You set type of endorsement to add another branch/es');
        }
    }

    function validationTOS()
    {
        if(document.getElementById('tosSubject').checked === true)
        {

            cobromakertrigger = false;
            tos = '';
            tos = $('#tosSubject').val();
            $('#nameOfCob').hide();
            $('#comakerDom').show();

            if($('#btnSelectForm').val()==='PDRN' || req_checker == 'PDRN')
            {
                corporatetrigger = false;
                var pdrnTemplate =
                    '<div class="row">' +
                    '   <div class="col-md-12">' +
                    '       <form action="#">' +
                    acctAddTemp+
                    multiCoborrowerTemp+
                    otherInfoTemp+
                    requestorInfoTemp+
                    '           <button type="button" class="btn-lg btn-success pull-right" id="endorseSend">SEND</button>' +
                    '       </form>' +
                    '   </div>' +
                    '</div>';
                $('#formContent').html('');
                $('#formContent').append(pdrnTemplate);
                fetchMuni();
                $('#municipality').focusout(function ()
                {
                    if($('#municipality').val() === '')
                    {
                        $('#province').val('');
                    }
                    else{
                        $.ajax
                        ({
                            method: 'get',
                            url: '/fetch-city-muniv2',
                            data:
                                {
                                    'muniname' : $('#municipality').val()
                                },
                            success: function (data)
                            {
                                $('#idMuni').val(data[0].province_id);
                                $('#idMuniOriginal').val(data[0].id);
                                fetchProv();

                                setTimeout(function () {
                                    $('#municipality').val(data[0].muni_name)
                                },1000);
                            }
                        });
                    }
                });
            }
            else if($('#btnSelectForm').val()==='EVR' || req_checker == 'EVR')
            {
                corporatetrigger = false;

                var evrTemplate =
                    '<div class="row">' +
                    '   <div class="col-md-12">' +
                    '       <form action="#">' +
                    acctAddTempEvBv+
                    empInfoTemp+
                    // multiCoborrowerTemp+
                    otherInfoTemp+
                    requestorInfoTemp+
                    '           <button type="button" class="btn-lg btn-success pull-right" id="endorseSend">SEND</button>' +
                    '       </form>' +
                    '   </div>' +
                    '</div>';
                $('#formContent').html('');
                $('#formContent').append(evrTemplate);
                $('#radioCorp').hide();
                fetchMuniEvr();
            }
            else if($('#btnSelectForm').val()==='BVR' || req_checker == 'BVR')
            {
                var bvrTemplate =
                    '<div class="row">' +
                    '   <div class="col-md-12">' +
                    '       <form action="#">' +
                    acctAddTempEvBv+
                    busInfoTemp+
                    // multiCoborrowerTemp+
                    otherInfoTemp+
                    requestorInfoTemp+
                    '           <button type="button" class="btn-lg btn-success pull-right" id="endorseSend">SEND</button>' +
                    '       </form>' +
                    '   </div>' +
                    '</div>';
                $('#formContent').html('');
                $('#formContent').append(bvrTemplate);
                radioBtnCorp();
                fetchMuniBvr();
            }
            $.ajax
            ({
                method: 'get',
                url: 'gen-session-info',
                success: function (data)
                {
                    if(data[0]!=null)
                    {
                        $('#modal-load-session').modal();
                    }
                },
                complete:function()
                {
                    if($('#dealer_name').length > 0 && $('#contract_number').length > 0)
                    {
                        $('#loanType').val('Auto Loan');
                    }
                }
            });
            alert('You set type of subject to Subject');
        }
        else if(document.getElementById('tosCob').checked === true)
        {

            cobromakertrigger = true;
            tos = '';
            tos = $('#tosCob').val();

            $('#acctFName').val('');
            $('#acctMName').val('');
            $('#acctLName').val('');
            $('#address').val('');
            $('#municipality').val('');
            $('#province').val('');

            $('#nameOfCob').show();
            $('#comakerDom').hide();
            $('#loanType').attr('disabled',true);
            $('#loanType').val('Auto Loan');
            alert('You set type of subject to Co-Borrower/Maker');
            $.ajax
            ({
                method: 'get',
                url: 'gen-session-info',
                success: function (data)
                {
                    if(data[0]!=null)
                    {
                        $('#modal-load-session').modal();
                    }
                },
                complete:function()
                {
                    if($('#dealer_name').length > 0 && $('#contract_number').length > 0)
                    {
                        $('#loanType').val('Auto Loan');
                    }
                }
            });

        }
    }
});
//END OF TYPE OF SUBJECT AND SUBJECT NAME



//EXCEL BULK ENDORSEMENT


$('#btnTestClientBulk').hide();
$('#btnSaveEditBulk').hide();

$('#btnTestClientUpload').click(function()
{
    var uploadExcel = $('#bulk_endorsement_excel_client').prop('files')[0];

    var formData = new FormData();
    formData.append('excel', uploadExcel);
    var dataToCheck = [];

    if(uploadExcel != null)
    {
        $.ajax
        ({
            type: 'post',
            url: 'client-upload-bulk-excel',
            contentType: false,
            processData: false,
            async : true,
            data: formData,
            success : function(data)
            {
                dataToCheck = data;

                $('#excelInfoHide').show();
                $('#alert_show').hide();
                // $('#alert_show').html('');
                $('#testExcelTable').html('');

                var i;
                var table1 = '';
                var table2 = '';
                var j;
                var test2;
                var countI = 0;
                var principalBorArray = [];

                console.log(data);

                var detailsBulk = data[0];

                for(var t = 0; t < data[2]; t++)
                {
                    if(t == 0)
                    {
                        detailsBulk[t].splice(6, 0, null, null, null)
                        detailsBulk[t].splice(0, 0, null);
                    }
                    else if(t == 1)
                    {
                        detailsBulk[t].splice(6, 0, 'FIRST NAME', 'MIDDLE NAME', 'LAST NAME');
                        detailsBulk[t].splice(0, 0, '');
                    }
                    else
                    {
                        if(detailsBulk[t][3].toUpperCase().includes('PRINCIPAL') || detailsBulk[t][3].toUpperCase() == 'PRINCIPAL BORROWER')
                        {
                            principalBorArray.push(detailsBulk[t][5]);
                        }

                        var namesRes = nameCheckComp(detailsBulk[t][5]);

                        detailsBulk[t].splice(6, 0, namesRes[1], namesRes[2], namesRes[0]);

                        detailsBulk[t].splice(0, 0, '');
                    }
                }

                var uniqueNames = [];
                $.each(principalBorArray, function(i, el){
                    if($.inArray(el, uniqueNames) === -1) uniqueNames.push(el);
                });

                for(i = data[1]; i < data[1] +1; i++)
                {
                    for(j = 0; j < data[0][i].length; j++)
                    {
                        test2 = detailsBulk[i][j];

                        if(data[0][i][j] == null)
                        {
                            test2 = '';
                        }
                        else
                        {
                            test2 = data[0][i][j];

                        }

                        table1 += '<th class = "excelLoopHeader" href="'+i+'" style="font-weight:bold; ">'+test2+'</th>'
                    }
                    table2 += '<tr>'+ table1 +'</tr>';
                    $('#testExcelTable').append(table2);
                    table1 = '';
                    table2 = '';
                }

                var checkIn = false;

                for(i = data[1]+ 1; i < data[2]; i++)
                {
                    if(data[0][i][4].toUpperCase().includes('CO'))
                    {
                        checkIn = true;
                    }

                    for(j = 0; j < detailsBulk[i].length; j++)
                    {

                        if(j == 5)
                        {
                            if(checkIn == true)
                            {
                                // test2 = selectPrin;

                                var selectPrin = '';
                                var optionsPrin = '';

                                for(var u = 0; u < uniqueNames.length; u++)
                                {
                                    var namesRes2 = nameCheckComp(uniqueNames[u]);

                                    optionsPrin += '<option name = "'+ countI +'" value = "'+namesRes2[1] +' '+namesRes2[2]+' '+namesRes2[0]+'">'+namesRes2[1] +' '+namesRes2[2]+' '+namesRes2[0]+'</option>';
                                }

                                    test2 = '<select class = "excelLoop checkCobSel" id = "excelData-'+ countI + '_' + j +'"  style = "font-size: 1.3em; width: 95%" href = "'+ countI + '_' + j +'"><option name = "'+ countI +'" value = "N/A">Please select the principal borrower</option>'+optionsPrin+'</select>';
                            }
                            else
                            {
                                test2 = '<textarea href = "'+ countI + '_' + j +'" id = "excelData-'+ countI + '_' + j +'" class = " excelLoop"  name = "'+ countI +'" style = "background-color: white; font-weight: bold; word-wrap:break-word; font-size: 14px" rows ="4" disabled>N/A</textarea>';
                            }
                        }
                        else if(data[0][i][j] == null)
                        {
                            var checkDoub = '';

                            if(j == 18)
                            {
                                checkDoub = 'DoubCheck'
                            }

                            test2 = '<textarea href = "'+ countI + '_' + j +'" id = "excelData-'+ countI + '_' + j +'" class = "excelLoop '+checkDoub+'"  name = "'+ countI +'" style = "background-color: white; font-weight: bold; word-wrap:break-word; font-size: 14px" rows ="4" disabled></textarea>';
                        }
                        else if(j == 0)
                        {
                            test2 = '<button class = "btn btn-lg clickToDelRow" style = "border : none; background: none" name = "'+countI+'"><i class ="fa fa-fw fa-minus-circle" style = "color : red"></i></button>'
                        }
                        else if(j != 5)
                        {
                            var test3 = '';
                            var test4 = '';
                            var test5 = '';
                            var test6 = '';
                            var test7 = '';
                            var test8 = '';
                            var test9 = '';

                            if(j == 1)
                            {
                                test3 = '';
                                test4 = '';
                                test5 = '';
                                test6 = 'torToRed';
                                test7 = '';
                                test8 = '';
                                test9 = '';
                            }
                            else if(j == 3)
                            {
                                test3 = '';
                                test4 = '';
                                test5 = '';
                                test6 = '';
                                test7 = '';
                                test8 = 'DoubCheck';
                                test9 = '';
                            }
                            else if (j == 6)
                            {
                                test3 = 'acctNames';
                                test4 = '';
                                test5 = '';
                                test6 = '';
                                test7 = '';
                                test8 = 'DoubCheck';
                                test9 = '';
                            }
                            else if(j == 7)
                            {
                                test3 = '';
                                test4 = 'FirstNameCheck';
                                test5 = '';
                                test6 = '';
                                test7 = '';
                                test8 = '';
                                test9 = '';
                            }
                            else if(j == 9)
                            {
                                test3 = '';
                                test4 = '';
                                test5 = 'LastNameCheck';
                                test6 = '';
                                test7 = '';
                                test8 = '';
                                test9 = '';
                            }
                            else if(j == 10)
                            {
                                test3 = '';
                                test4 = '';
                                test5 = '';
                                test6 = '';
                                test7 = 'busiEmpCheck';
                                test8 = '';
                                test9 = '';
                            }
                            else if(j == 11)
                            {
                                test3 = '';
                                test4 = '';
                                test5 = '';
                                test6 = '';
                                test7 = '';
                                test8 = 'DoubCheck';
                                test9 = '';
                            }
                            else if(j == 12)
                            {
                                test3 = '';
                                test4 = '';
                                test5 = '';
                                test6 = '';
                                test7 = '';
                                test8 = '';
                                test9 = 'muniCheck';
                            }
                            else
                            {
                                test3 = '';
                                test4 = '';
                                test5 = '';
                                test6 = '';
                                test7 = '';
                                test8 = '';
                                test9 = '';
                            }

                            test2 = '<textarea href = "'+ countI + '_' + j +'" id = "excelData-'+ countI + '_' + j +'" class = "excelLoop '+test3+''+test4+''+test5+''+test6+''+test7+' '+test8+' '+test9+'"  name = "'+ countI +'" style = "background-color: white; font-weight: bold; word-wrap:break-word; font-size: 14px" rows ="4" disabled>'+ data[0][i][j] +'</textarea>';
                        }

                        table1 += '<td class = "excelCol" name = "excelData-'+ countI + '_' + j +'">' +
                            test2 +
                            '</td>';

                    }

                    checkIn = false;

                    table2 += '<tr class = "BulkGenExcel" >'+ table1 +'</tr>';
                    $('#testExcelTable').append(table2);
                    table1 = '';
                    table2 = '';
                    countI++
                }
                $('#btnSaveEditBulk').attr('href', data[1]+1);
                $('#btnSaveEditBulk').attr('name', data[2]);

                $('#btnSaveEditBulk').show();
            },
            complete : function()
            {
                bulkExcelRed();
            }

        });
    }
    else
    {
        alert('Please select an excel file!');
    }
});

$('#testExcelTable').on('click', '.clickToDelRow', function()
{
   var id = $(this).closest('tr').attr('name');

   if(confirm('Are you sure to remove this row?'))
   {
       $('#removeMe-'+id+'').remove();

       bulkExcelRed()
   }
});

function bulkExcelRed()
{
    var checkDoubNow = [];
    var o = 0;
    var trToSkip = 0;
    var remID = 0;

    // $('.BulkGenExcel').css('background-color', 'white');
    // $('.BulkGenExcel').attr('red', '');
    $('.BulkGenExcel').attr('id', '');
    $('.BulkGenExcel').attr('name', '');


    $('.BulkGenExcel').each(function()
    {
        $(this).attr('id', 'removeMe-'+remID+'');
        $(this).attr('name', ''+remID+'');

        remID++;
    });

    $('#testExcelTable tbody tr').each(function()
    {
        if(trToSkip > 0)
        {
            checkDoubNow[o] = [];
            $(this).children('td').children().each(function ()
            {
                if($(this).hasClass('DoubCheck'))
                {
                    checkDoubNow[o].push($(this).html());
                }
            });
            o++;
        }
        trToSkip++;
    });


    var toRed = [];

    for(var t = 0; t < checkDoubNow.length; t++)
    {
        toRed[t] = [];
        for(var r = 0; r < checkDoubNow.length; r++)
        {
            if(JSON.stringify(checkDoubNow[t]) == JSON.stringify(checkDoubNow[r]))
            {
                toRed[t].push(r)
            }
        }
    }

    console.log(toRed)

    for(var g = 0; g < toRed.length; g++)
    {
        if(toRed[g].length > 1)
        {
            for(var y = 0; y < toRed[g].length ; y++)
            {
                $('#removeMe-'+toRed[g][y]+'').attr('style', 'background-color : #ffb3b3').attr('red', 'yes')
            }
        }
    }

    $('.acctNames').each(function ()
    {
        var main = $(this).attr('name');

        if ($(this).val() != '')
        {
            if ($(this).val().includes(', '))
            {
                var namesRes = nameCheckComp($(this).val());

                $('#excelData-' + main + '_7').val(namesRes[1]);
                $('#excelData-' + main + '_8').val(namesRes[2]);
                $('#excelData-' + main + '_9').val(namesRes[0]);

                if ($(this).attr('style').includes('background-color: #ffb3b3')) //red
                {
                    var color = $(this).attr('style');

                    var newColor = color.replace('background-color: #ffb3b3', 'background-color: white'); //white

                    $(this).attr('style', newColor);
                }
                else if ($(this).attr('style').includes('background-color: white')) {

                }
            }
            else {
                $('#excelData-' + main + '_7').val('');
                $('#excelData-' + main + '_8').val('');
                $('#excelData-' + main + '_9').val('');

                if ($(this).attr('style').includes('background-color: white'))
                {
                    var color2 = $(this).attr('style');

                    var newColor2 = color2.replace('background-color: white', 'background-color: #ffb3b3');

                    $(this).attr('style', newColor2);
                }
                else if ($(this).attr('style').includes('background-color: #ffb3b3')) {

                }
            }
        }
        else {
            $('#excelData-' + main + '_7').val('');
            $('#excelData-' + main + '_8').val('');
            $('#excelData-' + main + '_9').val('');

            if ($(this).attr('style').includes('background-color: white'))
            {
                var color3 = $(this).attr('style');

                var newColor3 = color3.replace('background-color: white', 'background-color: #ffb3b3');

                $(this).attr('style', newColor3);
            }
            else if ($(this).attr('style').includes('background-color: #ffb3b3')) {

            }
        }
    });

    $('.torToRed').each(function()
    {
        var main = $(this).attr('name');

        if ($(this).val() != '')
        {
            if($(this).val() == 'PDRN')
            {
                if($('#excelData-' + main + '_10').val() != '')
                {
                    if($('#excelData-' + main + '_10').attr('style').includes('background-color: #ffb3b3'))
                    {
                        var color2 = $('#excelData-' + main + '_10').attr('style');

                        var newColor2 = color2.replace('background-color: #ffb3b3', 'background-color: white');

                        $('#excelData-' + main + '_10').attr('style', newColor2);

                    }

                    $('#excelData-' + main + '_10').val('');
                }
                // else if($('#excelData-' + main + '_9').val() == '')
                // {
                //     if($('#excelData-' + main + '_9').attr('style').includes('background-color: #ffb3b3'))
                //     {
                //         var color2 = $('#excelData-' + main + '_9').attr('style');
                //
                //         var newColor2 = color2.replace('background-color: #ffb3b3', 'background-color: white');
                //
                //         $('#excelData-' + main + '_9').attr('style', newColor2);
                //     }
                // }
            }
            else if($(this).val() == 'EVR' || $(this).val() == 'BVR')
            {
                if($('#excelData-' + main + '_10').val() == '')
                {
                    if($('#excelData-' + main + '_10').attr('style').includes('background-color: white'))
                    {
                        var color3 = $('#excelData-' + main + '_10').attr('style');

                        var newColor3 = color3.replace('background-color: white', 'background-color: #ffb3b3');

                        $('#excelData-' + main + '_10').attr('style', newColor3);
                    }
                }
                else if($('#excelData-' + main + '_10').val() != '')
                {
                    if($('#excelData-' + main + '_10').attr('style').includes('background-color: #ffb3b3'))
                    {
                        var color4 = $('#excelData-' + main + '_10').attr('style');

                        var newColor4 = color4.replace('background-color: #ffb3b3', 'background-color: white');

                        $('#excelData-' + main + '_10').attr('style', newColor4);
                    }
                }
            }
        }
    });

    $('.muniCheck').each(function()
    {
        if($(this).val() == '')
        {
            $(this).css('background-color', '#ffb3b3');
            $(this).attr('red', 'yes');
        }
        else
        {
            $(this).css('background-color', 'white')
            $(this).attr('red', '');
        }
    });
}

function nameCheckComp(nameVal)
{
    var getName2 = nameVal.split(', ');
    var getName = nameVal.split(' ');

    var lastName = getName2[0];
    var searchName = getName2[1];

    var midName = '';
    var firstName = '';

    if(getName.length > 2)
    {
        midName = (getName[getName.length - 1]).trim();
        firstName = searchName.replace(midName, "");
    }
    else if(getName.length <= 2)
    {
        midName = '';
        firstName = searchName;
    }

    var lname = lastName.trim();
    var fname = firstName.trim();

    return [lname, fname, midName];
}


$('#testExcelTable').on('dblclick', '.excelCol', function()
{
    var target1 = $(event.target);

    if (target1.is("textarea"))
    {
        var id = $(this).attr('name');
        $('#'+ id +'').attr('disabled', false);
        $('#btnTestClientBulk').show();
        checkSave = true;
    }
    else
    {

    }

});

$('#btnSaveEditBulk').click(function()
{
    var btn = $(this);
    btn.attr('disabled', true);
    var forLoopCountEnd = $(this).attr('name');
    var forLoopCountStart = $(this).attr('href');
    var test_loop;
    var split1;
    var split2;
    var excel_data = {};
    var indexObj = [];
    var countObj = 0;
    var j;
    var loopData;

    var countAll = 0;
    var check_loop;
    var to_alert = '';
    var removeNowRows = false;


    $('.excelLoopHeader').each(function()
    {
        indexObj.push($(this).html());
    });

    $('.excelLoop').each(function()
    {
        test_loop = $(this).attr('href').split('_');

        split1 = test_loop[0];
        split2 = test_loop[1];

        var loopData = $('#excelData-'+ split1 + '_' + split2 +'').val();

        if(check_loop != split1)
        {
            excel_data[split1] = {};
            check_loop = split1;
        }
        excel_data[split1][indexObj[split2]] = loopData;
    });

    console.log(excel_data);

    var s = JSON.stringify(excel_data);
    var bulkData = JSON.parse(s);


    var firstname_row_count = ' ';
    var firstname_alert = false;

    $('.FirstNameCheck').each(function()
    {
        if($(this).val() == '')
        {
            firstname_alert = true;
            firstname_row_count += (parseInt($(this).closest('tr').attr('name'))+1)+', ';
        }
    });

    if(firstname_alert)
    {
        to_alert += '*Please specify account first name on endorsement row: '+firstname_row_count+'<br>';
    }

    var lastname_row_count = ' ';
    var lastname_alert = false;
    $('.LastNameCheck').each(function()
    {
        if($(this).val() == '')
        {
            lastname_alert = true;
            lastname_row_count += (parseInt($(this).closest('tr').attr('name'))+1)+', ';
        }
    });

    if(lastname_alert)
    {
        to_alert += '*Please specify account last name on endorsement row: '+lastname_row_count+'<br>';
    }


    var selectCheck_count = ' ';
    var selectCheck_alert = false;
    $('.checkCobSel').each(function()
    {
        if($(this).find(':selected').val() == 'N/A')
        {
            selectCheck_alert = true;
            selectCheck_count += (parseInt($(this).closest('tr').attr('name'))+1)+', ';
        }
    });

    if(selectCheck_alert)
    {
        to_alert += '*Please specify the principal borrower on endorsement row: '+selectCheck_count+'<br>';
    }

    var checkRedmpBus_count = ' ';
    var checkRedmpBus_alert = false;

    $('.busiEmpCheck').each(function()
    {
        if($(this).attr('style').includes('background-color: #ffb3b3'))
        {
            checkRedmpBus_alert = true;
            checkRedmpBus_count += (parseInt($(this).closest('tr').attr('name'))+1)+', ';
        }
    });

    if(checkRedmpBus_alert)
    {
        to_alert += '*Please check the corresponding business name/employer name on endorsement row: '+checkRedmpBus_count+'<br>';
    }

    var checkRedRow_count = ' ';
    var checkRedRow_alert = false;

    $('.BulkGenExcel').each(function()
    {
        if($(this).attr('red') == 'yes')
        {
            checkRedRow_alert = true;
            checkRedRow_count += (parseInt($(this).closest('tr').attr('name'))+1)+', ';
        }
    });

    if(checkRedRow_alert)
    {
        to_alert += '*Please check the double encoded data on endorsement row: '+checkRedRow_count+'<br>';
    }


    var muniCheckBlank_count = ' ';
    var muniCheckBlnk_alert = false;

    $('.muniCheck').each(function()
    {
        if($(this).attr('red') == 'yes')
        {
            muniCheckBlnk_alert = true;
            muniCheckBlank_count += (parseInt($(this).closest('tr').attr('name'))+1)+', ';
        }
    });

    if(muniCheckBlnk_alert)
    {
        to_alert += '*Please check the data of the municipality on endorsement row: '+muniCheckBlank_count+'<br>';
    }




    // $('.muniCheck').each


    if(checkSave == false)
    {
        if(to_alert == '')
        {
            var muniCheckArray = [];

            $('.muniCheck').each(function()
            {
                muniCheckArray.push($(this).val());
            });

            $.ajax
            ({
                type : 'post',
                url : 'client-bulk-check-double-endorse',
                data :
                    {
                        bulkData : bulkData,
                        'muniChecking' : muniCheckArray
                    },
                beforeSend : function()
                {
                    $('#modal-loading-double-bulk').modal({backdrop: "static"});
                },
                success : function(data)
                {
                    // console.log(data)
                    if(data == 'ok')
                    {
                        setTimeout(function ()
                        {
                            $('#modal-loading-double-bulk').modal('hide');
                            sendBulkToDB(bulkData, btn);
                        },3000);
                    }
                    else
                    {
                        setTimeout(function ()
                        {
                            $('#modal-loading-double-bulk').modal('hide');

                            var checkDoubNow = [];

                            console.log(data)

                            $('#testExcelTable tbody tr').each(function()
                            {
                                $(this).children('td').children().each(function()
                                {
                                    if($(this).hasClass('DoubCheck'))
                                    {
                                        checkDoubNow.push($(this).html());
                                    }
                                });

                                for(var q = 0; q < data[0].length; q++)
                                {
                                    if((JSON.stringify(data[0][q])) == (JSON.stringify(checkDoubNow)))
                                    {
                                        $(this).closest('tr').css('background-color','#ffb3b3');
                                        $(this).closest('tr').attr('red','yes');
                                    }
                                }

                                if(checkDoubNow != '')
                                {
                                    checkDoubNow = [];
                                }

                            });

                            for(var q = 0; q < data[0].length; q++)
                            {
                                to_alert +=  '*Double endorsement on account : ' + data[0][q][1] + '<br>';
                            }

                            var muniErr = [];

                            for(var d = 0; d < data[1].length; d++)
                            {
                                $('.muniCheck').each(function()
                                {
                                    if($(this).val().toUpperCase() == data[1][d].toUpperCase())
                                    {
                                        $(this).css('background-color','#ffb3b3');
                                        $(this).attr('red','yes');

                                        muniErr.push(parseInt($(this).closest('tr').attr('name'))+1);
                                        // checkBoolMuni = parseInt($(this).closest('tr').attr('name'));
                                    }
                                });
                                // if(checkBoolMuni != '')
                                // {
                                //     to_alert +=  '*Please check the spelling of encoded Municipality on endorsement row : ' + checkBoolMuni + '<br>';
                                // }
                                //
                                // checkBoolMuni = '';
                            }

                            var uniqueMuni = [];
                            $.each(muniErr, function(i, el){
                                if($.inArray(el, uniqueMuni) === -1) uniqueMuni.push(el);
                            });

                            var muniCheckSpell_count = ' ';
                            var muniCheckSpell_alert = false;


                            for(var w = 0; w < uniqueMuni.length; w++)
                            {
                                muniCheckSpell_alert = true;
                                muniCheckSpell_count += uniqueMuni[w] +', ';
                            }

                            if(muniCheckSpell_alert)
                            {
                                to_alert += '*No record of municipality on endorsement row: '+muniCheckSpell_count+'<br>';
                            }


                            btn.attr('disabled', false);
                            $('#alert_show').show();
                            $('#alert_text').html(to_alert);


                        },2000);
                    }
                }
            })
        }
        else
        {
            btn.attr('disabled', false);
            $('#alert_show').show();
            $('#alert_text').html(to_alert);
        }
    }
    else
    {
        btn.attr('disabled', false)
        alert('Please save updated details');
    }

});

function sendBulkToDB(dataSend, btn)
{
    $.ajax
    ({
        type : 'post',
        url : 'client-bulk-endorsement-submit',
        data :
            {
                bulkData : dataSend,
                'clientName' : $('#clientName').val()
            },
        beforeSend : function()
        {
            $('#modal-loading-send-bulk').modal({backdrop: "static"});
        },
        success : function(data)
        {
            console.log(data)
        },
        complete : function()
        {
            $('#modal-loading-send-bulk').modal('hide');

            var timerSuccess = setInterval(function ()
            {
                $('#modal-success-send-bulk').modal('show');
                var timerSuccessHide = setInterval(function ()
                {
                    $('#modal-success-send-bulk').modal('hide');
                    clearInterval(timerSuccessHide);
                },5000);
                clearInterval(timerSuccess);
            },1000);

            $('#testExcelTable').html('');
            btn.attr('disabled', false);
            btn.hide();
            $('#bulk_endorsement_excel_client').val('');
            clearTableExcel();
        }
    });
}

$('#btnTestClientBulk').click(function()
{
    bulkExcelRed();
    checkSave = false;
    $('.excelLoop').each(function()
    {
        if($(this).is('textarea'))
        {
            $(this).attr('disabled', true);
        }
    });

    $(this).hide();
});

$(window).focus(function ()
{

    console.log('focus');
    // logout_cliet_stop();
    interval = true;
});

$('#downloadBiBulk').click(function()
{
    // var id_encode = 0;
    // var q = '<form action="/client-dl-bulk-template" target="_blank" method="get">'+
    //     '<div class="input-group">'+
    //     '<input type="text" hidden value="'+id_encode+'" name="id">'+
    //     '<button type="submit" hidden id="button_form_download">'+
    //     '</button>'+
    //     '</span>'+
    //     '</div>'+
    //     '</form>';
    //
    // $('#downTemp').html(q);
    // $('#button_form_download').click();

    window.open('client-dl-bulk-template','_blank');


});


$('.success_tabs').click(function()
{
    var gethref = $(this).attr('href');

    if (gethref == '#new_accounts_tab')
    {
        if ($('' + gethref + '').hasClass('active'))
        {
            console.log('do nothing');
        }
        else if (new_accounts_tab)
        {
            console.log('already loaded');
        }
        else if (new_accounts_tab == false)
        {
            new_accounts_tab = true;
        }
    }
    else if(gethref == '#read_accounts_tab')
    {
        if ($('' + gethref + '').hasClass('active'))
        {
            console.log('do nothing');
        }
        else if (read_accounts_tab)
        {
            console.log('already loaded');
        }
        else if (read_accounts_tab == false)
        {
            read_accounts_tab = true;
            finish_accounts_table_read();
        }
    }
    else if(gethref == '#finish_accounts_tab')
    {
        if ($('' + gethref + '').hasClass('active'))
        {
            console.log('do nothing');
        }
        else if (finish_accounts_tab)
        {
            console.log('already loaded');
        }
        else if (finish_accounts_tab == false)
        {
            finish_accounts_tab = true;
            finish_accounts_table_downloaded();
        }
    }
});

function clearTableExcel()
{
    $('#alert_show').hide();
    // $('#alert_show').html('');
    $('#testExcelTable').html('');
    $('#bulk_endorsement_excel_client').val('');
    $('#btnTestClientBulk').hide();
    $('#excelInfoHide').hide();
    checkSave = false;
}

$('#clearFieldsBulkd').click(function()
{
    if(confirm('Are you sure to clear fields?'))
    {
        clearTableExcel()
    }
    else
    {

    }
});

$('#client-history-table').on('click', '.edit_req11', function()
{
    var endo_id = $(this).attr('href');
    $.ajax({
        method: 'post',
        url: 'client_endorsement_edit_route_test',
        data: {
            'id' : endo_id
        },
        success: function(data)
        {
            $('#EditEndorsementClient').attr('href', btoa(endo_id));
            $('.edit_endo_roll').each(function()
            {
                var what = $(this).attr('identifier');
                if($(this).attr('name') != null)
                {
                    if(data[1][0][what].split(" ").length > 2)
                    {
                        if($(this).attr('name') <= 2)
                        {
                            $(this).val(data[1][0][what].split(" ")[$(this).attr('name')]);
                        }
                    }
                    else
                    {
                        $(this).val(data[1][0][what].split(" ")[$(this).attr('name')]);
                    }
                }
                else
                {
                    $(this).val(data[1][0][what]);
                }
            });
        },
        complete: function()
        {
            $('#modal-edit-endorsement-details').modal('show');
        },
        error: function(e)
        {
            alert('Error occured contact the web developer for assistance. Thank you');
        }
    });
});

$('#EditEndorsementClient').click(function()
{
    var endorsement_id = $(this).attr('href');
    var data_to_send = {};
    var data_to_send_index = [];
    $('.edit_endo_roll').each(function()
    {
        var identifier = $(this).attr('identifier');
        if($(this).attr('name') != null)
        {

        }
        else
        {
            data_to_send[identifier] = $(this).val();
            data_to_send_index.push(identifier);
        }
    });

    // console.log(data_to_send);

    if(confirm('Are you sure to edit the endorsement?'))
    {
        $.ajax({
            type: 'post',
            url: 'client_submit_endorsement_edit_details',
            data:{
                'id' : endorsement_id,
                'data' : JSON.stringify(data_to_send),
                'data_index' : data_to_send_index
            },
            success: function(data)
            {
                console.log(data);
                if(data == 'ok')
                {
                    $('#modal-edit-endorsement-details').modal('hide');
                    alert('Account details succesully edited');
                }
            },
            error: function(e)
            {
                alert('Error occurred please contact web developer for assistance. Thank you');
            }
        });
    }

});

$('#edit_lname, #edit_fname, #edit_mname').on('keyup change', function()
{
    $('#account_name_edit_client').val($('#edit_lname').val() + ' ' + $('#edit_fname').val() + ' ' + $('#edit_mname').val());
    console.log($('#account_name_edit_client').val());
});