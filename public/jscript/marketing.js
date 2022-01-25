var tableManage, tblContracts, title, tblClientBday, clientBdayID, tblProsClient, clientProsID, clientDownloadProsID, tableToDoList, tableDoneToDoList, tableStandardRate, tableTat;
var muniID;
var originalMuniID;
var convertedRate;
var waiting = false;
var acctID;
var contracID;
var titleee=[];
var i = 0;
var todolistID;
var which_is_active = 'marketing_dashboard_tab';
var marketing_dashboard_tab_bool = true;
var marketing_management_tab_bool = false;
var marketing_contract_tab_bool = false;
var marketing_client_bday_tab_bool = false;
var marketing_new_client_tab_bool = false;
var marketing_tat_management = false;
var marketing_management_tab_bi = false;
var tat_id;
var headTitle=[];
var i = 0;
var c = 0;
var acctID2;
var acctID3;
var convertedTat;
var convertedtotalRate;
var full_calendar_tat;
var event_id;
var events = [];
var activeTabRate = 'tab_z';
var manage_add_rate = true;
var manage_standard_rate = false;
var bi_rates_table;
var bi_rate_id;
var bi_rate_per_area;
var bi_rates_tab1 = false;
var bi_rates_tab2 = false;
var bi_rate_tabs = '';
var what_type = '';
var bi_ocular_table;
var bi_id_ocular;
var marketing_logs_table;
var modal_logs_table = false;
var bank_id_rate;
var bi_rate_id_alacarte;



$.ajaxSetup
({
    headers:
        {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
});

$(document).ready(function ()
{
    marketing_dashboard_table();

    setInterval(function()
    {
        if(modal_logs_table == true)
        {
            marketing_logs_table.draw();
            modal_logs_table = false;
            console.log('loaded');
        }
    }, 60000);

    $('.marketing_a_class').click(function () {

        var gethref = $(this).attr('href');

        console.log(gethref);

        if(gethref == '#marketing_dashboard_tab')
        {
            if ($('' + gethref + '').hasClass('active'))
            {
                console.log('do nothing');
                which_is_active = 'marketing_dashboard_tab';
            }
            else if(marketing_dashboard_tab_bool)
            {
                console.log('already loaded');
                which_is_active = 'marketing_dashboard_tab';

            }
            else if(marketing_dashboard_tab_bool == false)
            {
                marketing_dashboard_tab_bool = true;
                which_is_active = 'marketing_dashboard_tab';
                // marketing_dashboard_table();
            }
        }
        else if(gethref == '#marketing_management_tab')
        {
            if ($('' + gethref + '').hasClass('active'))
            {
                console.log('do nothing');
                which_is_active = 'marketing_management_tab';
            }
            else if(marketing_management_tab_bool)
            {
                console.log('already loaded');
                which_is_active = 'marketing_management_tab';

            }
            else if(marketing_management_tab_bool == false)
            {
                marketing_management_tab_bool = true;
                which_is_active = 'marketing_management_tab';
                marketing_manage_add_rate_table();
            }
        }
        else if(gethref == '#marketing_contract_tab')
        {
            if ($('' + gethref + '').hasClass('active'))
            {
                console.log('do nothing');
                which_is_active = 'marketing_contract_tab';
            }
            else if(marketing_contract_tab_bool)
            {
                console.log('already loaded');
                which_is_active = 'marketing_contract_tab';

            }
            else if(marketing_contract_tab_bool == false)
            {
                marketing_contract_tab_bool = true;
                which_is_active = 'marketing_contract_tab';
                marketing_contract_table();
            }
        }
        else if(gethref == '#marketing_client_bday_tab')
        {
            if ($('' + gethref + '').hasClass('active'))
            {
                console.log('do nothing');
                which_is_active = 'marketing_client_bday_tab';
            }
            else if(marketing_client_bday_tab_bool)
            {
                console.log('already loaded');
                which_is_active = 'marketing_client_bday_tab';

            }
            else if(marketing_client_bday_tab_bool == false)
            {
                marketing_client_bday_tab_bool = true;
                which_is_active = 'marketing_client_bday_tab';
                marketing_client_table();
            }
        }
        else if(gethref == '#marketing_new_client_tab')
        {
            if ($('' + gethref + '').hasClass('active'))
            {
                console.log('do nothing');
                which_is_active = 'marketing_new_client_tab';
            }
            else if(marketing_new_client_tab_bool)
            {
                console.log('already loaded');
                which_is_active = 'marketing_new_client_tab';

            }
            else if(marketing_new_client_tab_bool == false)
            {
                marketing_new_client_tab_bool = true;
                which_is_active = 'marketing_new_client_tab';
                marketing_newclient_table();
            }
        }
        else if(gethref == '#marketing_tat_management')
        {
            if ($('' + gethref + '').hasClass('active'))
            {
                console.log('do nothing');
                which_is_active = 'marketing_tat_management';
            }
            else if(marketing_tat_management)
            {
                console.log('already loaded');
                which_is_active = 'marketing_tat_management';

            }
            else if(marketing_tat_management == false)
            {
                calendar_fetch_data();
                calendar_trigger();
                marketing_tat_management = true;
                which_is_active = 'marketing_tat_management';
                marketing_tat_manage_table();

            }
        }
        else if(gethref == '#marketing_management_tab_bi')
        {
            if ($('' + gethref + '').hasClass('active'))
            {
                console.log('do nothing');
                which_is_active = 'marketing_management_tab_bi';
            }
            else if(marketing_management_tab_bi)
            {
                console.log('already loaded');
                which_is_active = 'marketing_management_tab_bi';

            }
            else if(marketing_management_tab_bi == false)
            {
                marketing_management_tab_bi = true;
                which_is_active = 'marketing_management_tab_bi';
                bi_rate_table();

            }
        }
        else if(gethref == '#modal-all-marketing-logs')
        {
            if(modal_logs_table)
            {
                console.log('already loaded');
            }
            else if(!modal_logs_table)
            {
                which_is_active = 'modal-all-marketing-logs';
                modal_logs_table = true;
                marketing_all_logs_table();
            }
        }
    });


    // $('#marketing-manage').on('click', '#updaterate', function (e)
    // {
    //     if(waiting)
    //     {
    //         alert('Please wait..');
    //     }
    //     else
    //     {
    //         acctID = $(this).val();
    //         toupdate(acctID);
    //     }
    //
    // });
    //
    // function toupdate(acctID)
    // {
    //     $('#cancelupdate-'+acctID+'').click();
    //
    //     console.log('id:'+acctID);
    //
    //     var getvalfirst =  ($('#textupdate'+acctID+'').html()).split('Php ');
    //
    //     $('#textupdate'+acctID+'').html('<input type="number" id="updaterate'+acctID+'">');
    //
    //     $('#spann'+acctID+'').html('<button class="btn btn-xs btn-success" id="donerate-'+acctID+'" value="'+acctID+'" style="width: 100%">Done</button><button class="btn btn-xs btn-warning" id="cancelupdate-'+acctID+'" value="'+acctID+'" style="width: 100%">Cancel</button>');
    //
    //     var getsplitted = getvalfirst[1].replace(',','');
    //
    //     $('#updaterate'+acctID+'').val(getsplitted);
    //
    //     $('#marketing-manage').on('click', '#donerate-'+acctID+'', function ()
    //     {
    //         var btn = $(this);
    //         btn.attr('disabled', true);
    //         $.ajax
    //         ({
    //             type: 'get',
    //             url: 'marketing-table-rate-update',
    //             data:
    //                 {
    //                     'id' :acctID,
    //                     'newrate': $('#updaterate'+acctID+'').val(),
    //                     'before': getsplitted
    //                 },
    //             beforeSend: function (getdata)
    //             {
    //                 $('#textupdate'+acctID+'').html('Please wait..');
    //                 waiting = true;
    //             },
    //             success: function (getdata)
    //             {
    //                 var n = getdata[0].rate;
    //
    //                 var convertedRate = n.toLocaleString
    //                 (
    //                     undefined, // leave undefined to use the browser's locale,
    //                     // or use a string like 'en-US' to override it.
    //                     { minimumFractionDigits: 2 }
    //                 );
    //                 $('#textupdate'+acctID+'').html('Php '+convertedRate);
    //                 $('#spann'+acctID+'').html('<button class="btn btn-xs btn-info" id="updaterate" value="'+acctID+'" style="width: 100%">Update Rate</button>');
    //             },
    //             complete: function (getdata) {
    //
    //                 waiting = false;
    //                 btn.attr('disabled', false);
    //             }
    //         });
    //     });
    //
    //     $('#marketing-manage').on('click', '#cancelupdate-'+acctID+'', function (){
    //         $('#donerate-'+acctID+'').attr('disabled', false);
    //
    //         $('#spann'+acctID+'').html('<button class="btn btn-xs btn-info" id="updaterate" value="'+acctID+'" style="width: 100%">Update Rate</button>');
    //
    //         var convertedRate = getsplitted.toLocaleString
    //         (
    //             undefined, // leave undefined to use the browser's locale,
    //             // or use a string like 'en-US' to override it.
    //             { minimumFractionDigits: 2 }
    //         );
    //
    //         $('#textupdate'+acctID+'').html('Php '+convertedRate);
    //
    //     });
    // }

    $.ajax(
        {
            type: 'get',
            url: 'marketing_get_bi_clients',
            success: function(data)
            {
                var options = '';

                for(var i = 0; i < data.length; i++)
                {
                    options += '<option value="'+data[i].id+'">'+data[i].bi_account_name+'  '+data[i].account_location+'</option>'
                }

                $('#bi_rates_client_name').append(options);
                $('#bi_rates_client_name_alacarte').append(options);
                $('#bi_rates_client_name_tab2').append(options);
                $('#bi_rates_client_name_tab2_alacarte').append(options);
            }
        }
    );

    $.ajax(
        {
            type: 'get',
            url: 'marketing_get_all_provinces',
            success: function(data)
            {
                var options = '';

                for(var i = 9; i < data[0].length; i++)
                {
                    options += '<option value="'+data[0][i].id+'">'+data[0][i].name+'</option>'
                }

                $('#bi_rates_prov').append(options);
            }
        }
    );
});


function marketing_dashboard_table() {

    tableToDoList =  $('#marketing-table-todolist').DataTable
    ({
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
                                        return titleee[(idx)];
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
                    extend: 'colvis',
                    text: 'Show/Hide Column',
                    columnText: function (dt, idx, title)
                    {
                        return titleee[(idx)];
                    }
                }
            ],
        "responsive": true,
        "processing": true,
        "serverSide": true,
        "ajax": "/marketing-table-todolist",
        "columns":
            [
                {data: 'id', name: 'id'},
                {data: 'title', name: 'title'},
                {data: 'event_description', name: 'event_description'},
                {data: 'start_date', name: 'start_date'},
                {data: 'end_date', name: 'end_date'},
                {
                    data: function actions(data)
                    {
                        return '<button class="btn btn-block btn-xs btn-info" value="'+data.id+'" id="btnUpdateTodolist"><i class="fa fa-fw fa-download"></i> Update</button>' +
                            '<button class="btn btn-block btn-xs btn-success" value="'+data.id+'" id="btnDoneTodolist"><i class="fa fa-fw fa-check-square-o"></i> D o n e</button>' +
                            '<button class="btn btn-block btn-xs btn-danger" value="'+data.id+'" id="btnDeleteTodolist"><i class="fa fa-fw fa-trash"></i> Delete</button>' ;
                    },
                    "name": 'id',
                    "width": '9%'
                }
            ],
        "order": [[0, 'desc']],
        "pageLength": 6,
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

    $('#marketing-table-todolist_filter input').unbind();
    $('#marketing-table-todolist_filter input').bind('keyup change',function (e) {

        if($(this).is(':focus'))
        {
            if (e.keyCode == 13) {
                tableToDoList.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '') {
                    tableToDoList.search($(this).val()).draw();
                }
            }
        }
    });


    tableDoneToDoList = $('#marketing-table-done-todolist').DataTable
    ({
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
                                        return titleee[(idx)];
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
                    extend: 'colvis',
                    text: 'Show/Hide Column',
                    columnText: function (dt, idx, title)
                    {
                        return titleee[(idx)];
                    }
                }
            ],
        "responsive": true,
        "processing": true,
        "serverSide": true,
        "ajax": "/marketing-table-done-todolist",
        "columns":
            [
                {data: 'id', name: 'id'},
                {data: 'title', name: 'title'},
                {data: 'event_description', name: 'event_description'},
                {data: 'start_date', name: 'start_date'},
                {data: 'end_date', name: 'end_date'},
                {
                    data: function actions(data)
                    {
                        return '<button class="btn btn-block btn-xs btn-info"><i class="fa fa-fw fa-check"></i> Finish</button>';
                    },
                    "name": 'id',
                    "width": '9%'
                }
            ],
        "order": [[0, 'desc']],
        "pageLength": 6,
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

    $('#marketing-table-done-todolist_filter input').unbind();
    $('#marketing-table-done-todolist_filter input').bind('keyup change',function (e) {

        if($(this).is(':focus'))
        {
            if (e.keyCode == 13) {
                tableDoneToDoList.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '') {
                    tableDoneToDoList.search($(this).val()).draw();
                }
            }
        }
    });


}

function marketing_manage_add_rate_table() {
    tableManage = $('#marketing-manage').DataTable
    ({
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
                                    header: function (dt, idx, title) {
                                        return titleee[(idx)];
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
                                    header: function (dt, idx, title) {
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
                                    header: function (dt, idx, title) {
                                        return titleee[(idx)];
                                    }
                                }
                        }
                },
                {
                    extend: 'colvis',
                    text: 'Show/Hide Column',
                    columnText: function (dt, idx, title) {
                        return titleee[(idx)];
                    }
                }
            ],
        "responsive": true,
        "processing": true,
        "serverSide": false,
        "ajax": "/marketing-table-manage",
        "columns":
            [
                {data: 'id', name: 'id'},
                {data: 'muni_name', name: 'municipalities.muni_name'},
                {data: 'prov_name', name: 'provinces.name'},
                {data: 'name', name: 'users.name'},
                // {data: 'rate', name: 'rates.rate'},
                {
                    data: function rate(data) {
                        var n = data.rate;
                        convertedRate = n.toLocaleString
                        (
                            undefined, // leave undefined to use the browser's locale,
                            // or use a string like 'en-US' to override it.
                            {minimumFractionDigits: 2}
                        );
                        return '<span id="textupdate' + data.id + '"> Php ' + convertedRate + '</span>';
                    },
                    "name": 'rate'
                },
                {
                    data: function actions(data)
                    {
                        return '<button class="btn btn-xs btn-info btn-block update_rate_bank_edit" id="" value="' + data.id + '" style="margin-bottom: 5px;" rate="'+data.rate+'" what="bank_rate">Update Rate</button>' +
                            '<button class="btn-block btn btn-xs btn-primary update_rate_bank" id="'+data.id+'">View Logs</button>';
                    },
                    "name": 'actions',
                    "width": '10%'
                }
            ],
        "order": [[0, 'desc']],
        "pageLength": 10,
        "bSortClasses": false,
        "deferRender": true,
        initComplete: function () {

            $('#marketing-manage thead th').each(function () {
                titleee[i] = $(this).text();
                $(this).unbind();
                i++;
                title = $(this).text();
                if(title != 'Action')
                {
                    $(this).html(title + '<br><input type="text" placeholder="Search" style="position: relative; width: 100%">');
                }
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

//table2
}

function marketing_manage_standard_rate_table() {

    tableStandardRate = $('#marketing-table-manage-rate').DataTable
    ({
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
                                    header:  function (dt, idx)
                                    {
                                        return headTitle[(idx)];
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
                                    header:  function (dt, idx)
                                    {
                                        return headTitle[(idx)];
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
                                    header:  function (dt, idx)
                                    {
                                        return headTitle[(idx)];
                                    }
                                }
                        }
                },
                {
                    extend: 'colvis',
                    text: 'Show/Hide Column',
                    columnText: function (dt, idx)
                    {
                        return headTitle[(idx)];
                    }
                }
            ],
        "responsive": true,
        "processing": true,
        "serverSide": false,
        "ajax": "/marketing-table-standard-rate",
        "columns":
            [
                {data: 'id', name: 'id'},
                {data: 'muni_name', name: 'Municipalities'},
                {data: 'prov_name', name: 'Provinces'},
                // {data: 'rate', name: 'rate'},

                {
                    data: function rate(data) {
                        var n = data.rate;
                        convertedRate = n.toLocaleString
                        (
                            undefined, // leave undefined to use the browser's locale,
                            // or use a string like 'en-US' to override it.
                            {minimumFractionDigits: 2}
                        );
                        return '<span id="rateShow' + data.id + '"> Php ' + convertedRate + '</span>';
                    },
                    "name": 'rate'
                },
                {
                    data: function vat(data) {
                        var n = data.vat;
                        convertedRate = n.toLocaleString
                        (
                            undefined, // leave undefined to use the browser's locale,
                            // or use a string like 'en-US' to override it.
                            {minimumFractionDigits: 2}
                        );
                        return '<span id="vatShow' + data.id + '"> Php ' + convertedRate + '</span>';

                        name: 'vat'}
                },
                {
                    data: function tat(data) {
                        var n = data.tat;
                        convertedTat = n.toLocaleString
                        (
                            undefined, // leave undefined to use the browser's locale,
                            // or use a string like 'en-US' to override it.
                            {minimumFractionDigits: 2}
                        );
                        return '<span id="tatShow' + data.id + '">  ' + convertedTat + ' hour/s </span>';
                    },

                    name: 'tat'},
                {
                    data:  function total_rate(data) {
                        var n = data.total_rate;
                        convertedtotalRate = n.toLocaleString
                        (
                            undefined, // leave undefined to use the browser's locale,
                            // or use a string like 'en-US' to override it.
                            {minimumFractionDigits: 2}
                        );
                        return '<span id="TotalrateShow' + data.id + '"> Php ' + convertedtotalRate + '</span>';
                    },
                    name: 'total_rate'},
                {
                    data: function actions(data)
                    {
                        return '<span id="spann'+data.id+'"><button class="btn btn-xs btn-info" id="updaterate" name = "'+data.muni_name+'" value="'+data.id+'" style="width: 100%">Update Rste</button></span>' +
                            '<span id="spann'+data.id+'"><button class="btn btn-block btn-danger btn-xs" id="deleterate" value="'+data.id+'" style="width: 100%">Delete Rate</button></span>';

                    },
                    "name": 'actions',
                    "width": '5%'
                }
            ],
        "order": [[0, 'desc']],
        "pageLength": 10,
        "bSortClasses": false,
        "deferRender": true,
        initComplete: function()
        {
            $('#marketing-table-manage-rate thead th').each(function () {
                headTitle[c] = $(this).text();
                $(this).unbind();
                c++;
                title = $(this).text();
                if(title != 'Action')
                {
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

    $('#marketing-manage_filter input').unbind();
    $('#marketing-manage_filter input').bind('keyup change',function (e) {

        if($(this).is(':focus'))
        {
            if (e.keyCode == 13) {
                tableManage.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '') {
                    tableManage.search($(this).val()).draw();
                }
            }
        }
    });


}

function marketing_contract_table() {

    tblContracts = $('#marketing-table-contracts').DataTable
    ({
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
                                        return titleee[(idx)];
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
                    extend: 'colvis',
                    text: 'Show/Hide Column',
                    columnText: function (dt, idx, title)
                    {
                        return titleee[(idx)];
                    }
                }
            ],
        "responsive": true,
        "processing": true,
        "serverSide": true,
        "ajax": "/marketing-contract-table",
        "columns":
            [
                {data: 'id', name: 'id'},
                {data: 'client_name', name: 'client_name'},
                {data: 'start_date', name: 'start_date'},
                {data: 'end_date', name: 'end_date'},
                {data: 'contract_desc', name: 'contract_desc'},
                {data: 'contract_remarks', name: 'contract_remarks'},
                {
                    data: function actions(data)
                    {
                        return '<button class="btn btn-block btn-xs btn-success" value="'+data.id+'" id="contDL"><i class="fa fa-fw fa-download"></i> Download</button>' +
                            '<button class="btn btn-block btn-xs btn-info" value="'+data.id+'" id="btnUpdateCont" data-toggle="modal" data-target="#modal-marketing-update-info"><i class="fa fa-fw fa-download"></i> Update</button>'+
                            '<button class="btn btn-block btn-xs btn-danger" value="'+data.id+'" id="btnDeleteCont"><i class="fa fa-fw fa-trash-o"></i> Delete</button>';
                    },
                    "name": 'id',
                    "width": '9%'
                }
            ],
        "order": [[0, 'desc']],
        "pageLength": 10,
        "bSortClasses": false,
        "deferRender": true,
        "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull)
        {
            var countDownDate = new Date(aData.end_date);
            var now = new Date();
            var distance = countDownDate.setMinutes(countDownDate.getMinutes()+20) - now;

            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

            if ((days+1)>60)
            {
                $('td', nRow).css('background-color', '#b3ffb3');
            }
            else if ((days+1)>=30 && (days+1)<=60)
            {
                $('td', nRow).css('background-color', '#f4d742');
            }
            else if ((days+1)<=30)
            {
                $('td', nRow).css('background-color', '#ffb3b3');
            }
        },
        initComplete: function()
        {
            $('#marketing-table-contracts thead th').each(function() {
                $(this).unbind();
                titleee[i] = $(this).text();
                i++;
                title = $(this).text();
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

    $('#marketing-table-contracts_filter input').unbind();
    $('#marketing-table-contracts_filter input').bind('keyup change',function (e) {

        if($(this).is(':focus'))
        {
            if (e.keyCode == 13) {
                tblContracts.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '') {
                    tblContracts.search($(this).val()).draw();
                }
            }
        }
    });


}

function marketing_client_table() {




    tblClientBday = $('#marketing-table-clientbday').DataTable
    ({
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
                                        return titleee[(idx)];
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
                    extend: 'colvis',
                    text: 'Show/Hide Column',
                    columnText: function (dt, idx, title)
                    {
                        return titleee[(idx)];
                    }
                }
            ],
        "responsive": true,
        "processing": true,
        "serverSide": true,
        "ajax": "/marketing-table-clientbday",
        "columns":
            [
                {data: 'id', name: 'id'},
                {data: 'client_name', name: 'client_name'},
                {data: 'birthdate', name: 'birthdate'},
                {data: 'contact_num', name: 'contact_num'},
                {data: 'email_add', name: 'email_add'},
                {data: 'client_position', name: 'client_position'},
                {data: 'gift_type', name: 'gift_type'},
                {data: 'bank_name', name: 'bank_name'},
                {
                    data: function actions(data)
                    {
                        return '<button class="btn btn-block btn-xs btn-info" value="'+data.id+'" id="btnUpdateBday" data-toggle="modal" data-target="#modal-marketing-update-client-bday"><i class="fa fa-fw fa-download"></i> Update</button>'+
                            '<button class="btn btn-block btn-xs btn-danger" value="'+data.id+'" id="btnDeleteBday"><i class="fa fa-fw fa-trash-o"></i> Delete</button>';
                    },
                    "name": 'id',
                    "width": '9%'
                }
            ],
        "order": [[0, 'desc']],
        "pageLength": 10,
        "bSortClasses": false,
        "deferRender": true,
        "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull)
        {
            var countDownDate = new Date(aData.birthdate);
            var monthNames = ["Jan", "Feb", "Mar", "Apr", "May","Jun","Jul", "Aug", "Sep", "Oct", "Nov","Dec"];
            const second = 1000,
                minute = second * 60,
                hour = minute * 60,
                day = hour * 24;
            var countDown = new Date(monthNames[countDownDate.getMonth()]+' '+countDownDate.getDate()+', '+new Date().getFullYear());
            var now = new Date();
            distance = countDown - now;
            var diffDays1 = Math.floor(distance / (day));

            if ((diffDays1+1)>60)
            {
                $('td', nRow).css('background-color', '#b3ffb3');
            }
            else if ((diffDays1+1)>=30 && (diffDays1+1)<=60)
            {
                $('td', nRow).css('background-color', '#ffb84d');
            }
            else if ((diffDays1+1)>=0 &&(diffDays1+1)<=30)
            {
                $('td', nRow).css('background-color', '#ffb3b3');
            }
            else
            {
                $('td', nRow).css('background-color', '#b3ffb3');
            }
        },
        initComplete: function()
        {
            $('#marketing-table-clientbday thead th').each(function() {
                $(this).unbind();
                titleee[i] = $(this).text();
                i++;
                title = $(this).text();
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
    $('#marketing-table-clientbday_filter input').unbind();
    $('#marketing-table-clientbday_filter input').bind('keyup change',function (e) {

        if($(this).is(':focus'))
        {
            if (e.keyCode == 13) {
                tblClientBday.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '') {
                    tblClientBday.search($(this).val()).draw();
                }
            }
        }
    });


}

function marketing_newclient_table() {



    tblProsClient = $('#marketing-table-prospect-client').DataTable
    ({
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
                                        return titleee[(idx)];
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
                    extend: 'colvis',
                    text: 'Show/Hide Column',
                    columnText: function (dt, idx, title)
                    {
                        return titleee[(idx)];
                    }
                }
            ],
        "responsive": true,
        "processing": true,
        "serverSide": true,
        "ajax": "/marketing-table-pros-client",
        "columns":
            [
                {data: 'id', name: 'id'},
                {data: 'client_name', name: 'client_name'},
                {data: 'date_inquiry', name: 'date_inquiry'},
                {data: 'address', name: 'address'},
                {data: 'contact_person', name: 'contact_person'},
                {data: 'contact_position', name: 'contact_position'},
                {data: 'contact_number', name: 'contact_number'},
                {data: 'contact_email', name: 'contact_email'},
                {data: 'require_check', name: 'require_check'},
                {
                    data: function actions(data)
                    {
                        return '<button class="btn btn-block btn-xs btn-success" value="'+data.id+'" id="prosBiDL"><i class="fa fa-fw fa-download"></i> Download</button>' +
                            '<button class="btn btn-block btn-xs btn-info" value="'+data.id+'" id="btnUpdateProsClient" data-toggle="modal" data-target="#modal-marketing-update-pros-client"><i class="fa fa-edit"></i> Update</button>'+
                            '<button class="btn btn-block btn-xs btn-danger" value="'+data.id+'" id="btnDeleteProsClient"><i class="fa fa-fw fa-trash-o"></i> Delete</button>';
                    },
                    "name": 'id',
                    "width": '9%'
                }
            ],
        "order": [[0, 'desc']],
        "pageLength": 10,
        "bSortClasses": false,
        "deferRender": true,
        initComplete: function()
        {
            $('#marketing-table-prospect-client thead th').each(function() {
                $(this).unbimd();
                titleee[i] = $(this).text();
                i++;
                title = $(this).text();
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
    $('#marketing-table-prospect-client_filter input').unbind();
    $('#marketing-table-prospect-client_filter input').bind('keyup change',function (e) {

        if($(this).is(':focus'))
        {
            if (e.keyCode == 13) {
                tblProsClient.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '') {
                    tblProsClient.search($(this).val()).draw();
                }
            }
        }
    });


}

function marketing_tat_manage_table() {

    // $('#updateAccountsfrom').datepicker({ dateFormat: 'yy-mm-dd' });




    tableTat = $('#marketing-table-tat-manage').DataTable
    ({
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
                                        return titleee[(idx)];
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
                    extend: 'colvis',
                    text: 'Show/Hide Column',
                    columnText: function (dt, idx, title)
                    {
                        return titleee[(idx)];
                    }
                }
            ],
        "responsive": true,
        "processing": true,
        "serverSide": true,
        "ajax": "/marketing-table-tat-manage-get",
        "columns":
            [
                {data: 'id', name: 'tat_management.id'},
                {data: 'muni_name', name: 'municipalities.muni_name'},
                {data: 'prov_name', name: 'provinces.prov_name'},
                {data: 'client_name', name: 'users.name'},
                // {data: 'fw', name: 'tat_management.fw_tat'},
                {
                    data : function (data) {
                        return data.fw+" HOURS";
                    },
                    'name' : 'tat_management.fw_tat'
                },
                // {data: 'obw', name: 'tat_management.obw_tat'},
                {
                    data : function (data) {
                        return data.obw+" HOURS";
                    },
                    'name' : 'tat_management.obw_tat'
                },
                // {data: 'agreed', name: 'tat_management.agreed_tat'},
                {
                    data : function (data) {
                        return data.agreed+" HOURS";
                    },
                    'name' : 'tat_management.agreed_tat'
                },
                {data: 'date', name: 'tat_management.date'},
                {data: 'time', name: 'tat_management.time'},
                // {data: 'time', name: 'tat_management.time'}
                {
                    data : function (data) {

                        return '<button class="btn btn-block btn-xs btn-warning" name="'+data.id+'" value="'+data.fw+':'+data.obw+':'+data.agreed+'" data-toggle="modal" data-target="#modal_edit_tat_management" id="tat_edit_modal"> Edit</button>' +
                            '<button class="btn btn-block btn-xs btn-danger" name="'+data.id+'"  id="tat_delete" > Delete</button>';

                    },
                    'name' : 'tat_management.agreed_tat',
                    'searchable' : false,
                    'orderable' : false
                }
            ],
        "order": [[0, 'desc']],
        "pageLength": 10,
        "lengthMenu": [[10, 25, 50, 100, -1], ['10 rows', '25 rows', '50 rows', '100 rows', 'Show all']],
        "bSortClasses": false,
        "deferRender": true,
        initComplete: function()
        {
            $('#marketing-table-tat-manage thead th').each(function() {
                $(this).unbind();
                titleee[i] = $(this).text();
                i++;
                title = $(this).text();
                if(title == 'Action')
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
    $('#marketing-table-tat-manage_filter input').unbind();
    $('#marketing-table-tat-manage_filter input').bind('keyup change',function (e) {

        if($(this).is(':focus'))
        {
            if (e.keyCode == 13) {
                tableTat.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '') {
                    tableTat.search($(this).val()).draw();
                }
            }
        }
    });

}

$('#marketing-table-tat-manage').on('click','#tat_edit_modal', function () {

    tat_id = $(this).attr('name');
    console.log($(this).attr('value'));
    var getgetaw = $(this).attr('value');
    var trimmed = getgetaw.split(':');

    $('#fw_tat_edit').val(trimmed[0]);
    $('#obw_tat_edit').val(trimmed[1]);
    $('#agreed_tat_edit').val(trimmed[2]);
    // console.log(tat_id);
});

$('#tat_update_btn').click(function () {

    var fw = $('#fw_tat_edit').val();
    var obw = $('#obw_tat_edit').val();
    var agree = $('#agreed_tat_edit').val();

    // console.log(fw);
    // console.log(obe);
    // console.log(agree);

    $.ajax({
        type: 'get',
        url : 'marketing_tat_update_row',
        data: {
            "tat_id": tat_id,
            "fw_tat": fw,
            "obw_tat": obw,
            "agree_tat": agree,
        },
        success: function (data) {

            tableTat.ajax.reload(null, false);
            $('#tat_click_to_close').click();
        },
        error: function () {

        }
    });

});



$('#spanMuni').hide();
$('#spanProv').hide();

$('#spanMuni_tat').hide();
$('#spanProv_tat').hide();

$('#spanMuni2').hide();
$('#spanProv2').hide();
$('#btnNone').show();

$('#rateMuniProv').change(function ()
{
    if($('#rateMuniProv').val()=='muni')
    {
        $('#spanProv').hide();
        $('#spanMuni').show();
    }
    else
    {
        $('#spanMuni').hide();
        $('#spanProv').show();
    }
});

$('#rateMuniProv_tat').change(function ()
{
    if($('#rateMuniProv_tat').val()=='muni_tat')
    {
        $('#spanProv_tat').hide();
        $('#spanMuni_tat').show();
    }
    else
    {
        $('#spanMuni_tat').hide();
        $('#spanProv_tat').show();
    }
});

$('#rateMuniProv2').change(function ()
{
    if($('#rateMuniProv2').val()=='muni2')
    {
        $('#spanProv2').hide();
        $('#spanMuni2').show();
        $('#btnNone').hide();
    }
    else if($('#rateMuniProv2').val()=='---')
    {
        $('#spanProv2').hide();
        $('#spanMuni2').hide();
        $('#btnNone').show();
    }
    else
    {
        $('#spanMuni2').hide();
        $('#spanProv2').show();
        $('#btnNone').hide();
    }
});

$('#marketingMuni').focusout(function () {
    if($('#marketingMuni').val() === '')
    {
        $('#marketingProv').val('');
    }
    else{
        $.ajax
        ({
            method: 'get',
            url: '/fetch-city-muniv2',
            data:
                {
                    'muniname' : $('#marketingMuni').val()
                },
            success: function (data)
            {
                console.log(data[0].id);
                $('#idProvince').val(data[0].province_id);
                $('#idMunicipality').val(data[0].id);
                fetchProv();

                setTimeout(function ()
                {
                    $('#marketingMuni').val(data[0].muni_name);
                },1000);
            }
        });
    }
});

$('#marketingMuni_tat').focusout(function () {
    if($('#marketingMuni_tat').val() === '')
    {
        $('#marketingProv_tat').val('');
    }
    else{
        $.ajax
        ({
            method: 'get',
            url: '/fetch-city-muniv2',
            data:
                {
                    'muniname' : $('#marketingMuni_tat').val()
                },
            success: function (data)
            {
                console.log(data[0].id);
                $('#idProvince_tat').val(data[0].province_id);
                $('#idMunicipality_tat').val(data[0].id);
                fetchProv_tat();

                setTimeout(function ()
                {
                    $('#marketingMuni_tat').val(data[0].muni_name);
                },1000);
            }
        });
    }
});

$('#marketingMuni2').focusout(function ()
{
    if($('#marketingMuni2').val() === '')
    {
        $('#marketingProv2').val('');
    }
    else
    {
        $.ajax
        ({
            method: 'get',
            url: '/fetch-city-muniv2',
            data:
                {
                    'muniname' : $('#marketingMuni2').val()
                },
            success: function (data)
            {
                console.log(data[0].id);
                $('#idProvince2').val(data[0].province_id);
                $('#idMunicipality2').val(data[0].id);
                fetchProv2();

                setTimeout(function ()
                {
                    $('#marketingMuni2').val(data[0].muni_name);
                },1000);
            }
        });
    }
});

fetchMuni();
fetchMuni_tat();
fetchMuni2();

function fetchMuni()
{
    $('#marketingMuni').autocomplete
    ({
        //     $('#test').on('autocomplete', '.testcalss', function()
        // {
        //     var pasval = $(this).attr('name');
        //
        //     var getVal = $("#thisid- "   + pasval+ '").val();
        //         console.log(getVal);
        // })
        source: '/fetch-city-muni',
        minLength: 1,
        select: function (event, ui)
        {
            $('idProvince').val('');
            $('idMunicipality').val('');
            $('#idProvince').val(ui.item.muniID);
            $('#idMunicipality').val(ui.item.originalMuniID);
            var clearTime = setInterval(function ()
            {
                fetchProv();
                clearInterval(clearTime);
            },10)
        }
    });
}

function fetchMuni_tat()
{

    $('#marketingMuni_tat').autocomplete
    ({
        source: '/fetch-city-muni',
        minLength: 1,
        select: function (event, ui)
        {
            $('idProvince_tat').val('');
            $('idMunicipality_tat').val('');
            $('#idProvince_tat').val(ui.item.muniID);
            $('#idMunicipality_tat').val(ui.item.originalMuniID);
            var clearTime = setInterval(function ()
            {
                fetchProv_tat();
                clearInterval(clearTime);
            },10)
        }
    });
}

function fetchProv()
{
    muniID = $('#idProvince').val();
    originalMuniID = $('#idMunicipality').val();
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
            console.log(data);
            $('#loadingProv').html('');
            $('#marketingProv').val('');
            $('#marketingProv').val(data[0][0].name);
        }
    });
}

function fetchMuni2()
{
    $('#marketingMuni2').autocomplete
    ({
        source: '/fetch-city-muni',
        minLength: 1,
        select: function (event, ui)
        {
            $('#idProvince2').val('');
            $('#idMunicipality2').val('');
            $('#idProvince2').val(ui.item.muniID);
            $('#idMunicipality2').val(ui.item.originalMuniID);
            var clearTime = setInterval(function ()
            {
                fetchProv2();
                clearInterval(clearTime);
            },10)
        }
    });
}

function fetchProv2()
{
    muniID = $('#idProvince2').val();
    originalMuniID = $('#idMunicipality2').val();
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
            console.log(data);
            $('#loadingProv').html('');
            $('#marketingProv2').val('');
            $('#marketingProv2').val(data[0][0].name);
        }
    });
}

$('#txtBankRate2').on('input',function ()
{
    if($('#txtBankRate2').val()<0)
    {
        alert('Rate must be greater than negative value');
        $('#txtBankRate2').val('');
    }
    else
    {
        $('#txtVATmuni2').val('');

        var vat = $('#txtBankRate2').val() * .12;
        $('#txtVATmuni2').val(Math.round(vat));

        $('#txtMuniTotalRate2').val(parseInt($('#txtBankRate2').val()) + parseInt($('#txtVATmuni2').val()))

        if($('#txtBankRate2').val()=='')
        {
            $('#txtMuniTotalRate2').val('');
            $('#txtVATmuni2').val('');
        }
    }
});

$('#txtBulkRate2').on('input',function ()
{
    if($('#txtBulkRate2').val()<0)
    {
        alert('Rate must be greater than negative value');
        $('#txtBulkRate2').val('');
    }
    else
    {
        $('#txtVATprov2').val('');

        var vat = $('#txtBulkRate2').val() * .12;
        $('#txtVATprov2').val(Math.round(vat));

        $('#txtProvTotalRate2').val(parseInt($('#txtBulkRate2').val()) + parseInt($('#txtVATprov2').val()))

        if($('#txtBulkRate2').val()=='')
        {
            $('#txtProvTotalRate2').val('');
            $('#txtVATprov2').val('');
        }
    }
});

function fetchProv_tat()
{
    muniID = $('#idProvince_tat').val();
    originalMuniID = $('#idMunicipality_tat').val();
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
            $('#loadingProv_tat').append('<img src= "dist/img/loading.gif" width="3%">');
        },
        success: function (data)
        {
            console.log(data);
            $('#loadingProv_tat').html('');
            $('#marketingProv_tat').val('');
            $('#marketingProv_tat').val(data[0][0].name);
        }
    });
}

$('#btnSubmitRate').on('click',function ()
{
    $("#btnSubmitRate").attr("disabled", true);
    var rateMuni = $('#idMunicipality').val();
    var rateProv = $('#idProvince').val();
    var bankID = $('#bankID').val();
    var rateBank = $('#txtBankRate').val();

    if($('#rateMuniProv').val()=='muni')
    {
        $.ajax
        ({
            type: 'post',
            url: 'marketing-insert-rate',
            data:
                {
                    'rateMuni': rateMuni,
                    'rateProv': rateProv,
                    'bankID': bankID,
                    'rateBank': rateBank
                },
            beforeSend: function ()
            {
                $('#modal-sendingrequest').modal('show');
            },
            success: function (data)
            {
                console.log(data.error);
                if(data.error=='required')
                {
                    $('#modal-sendingrequest').modal('hide');
                    $("#btnSubmitRate").attr("disabled", false);
                    var timerError = setInterval(function ()
                    {
                        $('#modal-filluperror').modal('show');
                        $('.form-group').addClass('has-error');
                        clearInterval(timerError);
                    },1000);
                }
                else if(data.exist=='exist')
                {
                    $('#modal-sendingrequest').modal('hide');
                    $("#btnSubmitRate").attr("disabled", false);

                    $('#marketingMuni').val('');
                    $('#marketingProv').val('');
                    $('#idMunicipality').val('');
                    $('#idProvince').val('');
                    $('#txtBankRate').val('');
                    $('#txtBulkRate').val('');

                    var timerExisting = setInterval(function ()
                    {
                        $('#modal-existing').modal('show');
                        $('.form-group').addClass('has-error');
                        clearInterval(timerExisting);
                    },1000);
                }
                else
                {
                    $('#modal-sendingrequest').modal('hide');
                    $("#btnSubmitRate").attr("disabled", false);

                    $('#marketingMuni').val('');
                    $('#marketingProv').val('');
                    $('#idMunicipality').val('');
                    $('#idProvince').val('');
                    $('#txtBankRate').val('');
                    $('#txtBulkRate').val('');

                    var timerSuccess = setInterval(function ()
                    {
                        $('#modal-sentsuccess').modal('show');
                        tableManage.ajax.reload(null, false);

                        var timerSuccessHide = setInterval(function ()
                        {
                            $('#modal-sentsuccess').modal('hide');
                            clearInterval(timerSuccessHide);
                        },5000);

                        clearInterval(timerSuccess);
                    },1000);
                }
            }
        })
    }
    else
    {
        var provID = $('#provID').val();
        var bulkRate = $('#txtBulkRate').val();
        var bankBulkID = $('#bankBulkID').val();

        $.ajax
        ({
            type: 'post',
            url: 'marketing-bulk-rate',
            data:
                {
                    'provID': provID,
                    'bankID': bankBulkID,
                    'bulkRate': bulkRate
                },
            beforeSend: function ()
            {
                $('#modal-sendingrequest').modal('show');
            },
            success: function (data)
            {
                console.log(data.error);
                if(data.error=='required')
                {
                    $('#modal-sendingrequest').modal('hide');
                    $("#btnSubmitRate").attr("disabled", false);
                    var timerError = setInterval(function ()
                    {
                        $('#modal-filluperror').modal('show');
                        $('.form-group').addClass('has-error');
                        clearInterval(timerError);
                    },1000);
                }
                else if(data.exist=='exist')
                {
                    $('#modal-sendingrequest').modal('hide');
                    $("#btnSubmitRate").attr("disabled", false);

                    $('#marketingMuni').val('');
                    $('#marketingProv').val('');
                    $('#idMunicipality').val('');
                    $('#idProvince').val('');
                    $('#txtBankRate').val('');
                    $('#txtBulkRate').val('');

                    var timerExisting = setInterval(function ()
                    {
                        $('#modal-existing').modal('show');
                        $('.form-group').addClass('has-error');
                        clearInterval(timerExisting);
                    },1000);
                }
                else
                {
                    $('#modal-sendingrequest').modal('hide');
                    $("#btnSubmitRate").attr("disabled", false);

                    $('#marketingMuni').val('');
                    $('#marketingProv').val('');
                    $('#idMunicipality').val('');
                    $('#idProvince').val('');
                    $('#txtBankRate').val('');
                    $('#txtBulkRate').val('');

                    var timerSuccess = setInterval(function ()
                    {
                        $('#modal-sentsuccess').modal('show');
                        tableManage.ajax.reload(null, false);

                        var timerSuccessHide = setInterval(function ()
                        {
                            $('#modal-sentsuccess').modal('hide');
                            clearInterval(timerSuccessHide);
                        },5000);

                        clearInterval(timerSuccess);
                    },1000);
                }
            }
        })
    }
});

$('#btnSaveCont').click(function (e)
{
    $('#btnSaveCont').attr('disabled',true);
    e.preventDefault();

    var clientName = $('#txtClientName').val();
    var startDate = $('#dateStartCont').val();
    var endDate = $('#dateEndCont').val();
    var fileContract = new $("#fileContract").prop('files')[0];
    var txtContDesc = $('#txtContDesc').val();
    var txtContRemarks = $('#txtContRemarks').val();

    var form_data = new FormData();
    form_data.append('clientName', clientName);
    form_data.append('startDate', startDate);
    form_data.append('endDate', endDate);
    form_data.append('fileContract', fileContract);
    form_data.append('txtContDesc', txtContDesc);
    form_data.append('txtContRemarks', txtContRemarks);

    if (fileContract == null)
    {
        alert('Please fill up all empty field/s');
        $('#btnSaveCont').attr('disabled',false);
    }
    else if(startDate>endDate)
    {
        alert('End date must be ahead to start date or equal');
        $('#btnSaveCont').attr('disabled',false);
    }
    else
    {
        $.ajax
        ({
            method: 'post',
            url: 'marketing-contract-add',
            data: form_data,
            processData: false,
            contentType: false,
            success: function (data)
            {
                if(data=='success')
                {
                    alert('Contract Successfully Save');
                    $('#txtClientName').val('');
                    $('#txtContDesc').val('');
                    $('#txtContRemarks').val('');
                    $("#fileContract").val('');
                    tblContracts.ajax.reload(null, false);
                    $('#btnSaveCont').attr('disabled',false);
                }
                else
                {
                    alert('Please fill up all empty fields or please select valid zip file');
                    $('#btnSaveCont').attr('disabled',false);
                }
            }
        });
    }
});

$('#marketing-table-contracts').on('click','#contDL', function ()
{
    $("#marketing-table-contracts").find("button").attr("disabled", true);
    contracID = $(this).attr('value');

    $.ajax
    ({
        method: 'get',
        url: 'marketing-contract-download',
        data:
            {
                'contracID': contracID
            },
        success: function (data)
        {
            if(data=='error')
            {
                alert('no available file contract');
                $("#marketing-table-contracts").find("button").attr("disabled", false);
            }
            else
            {
                window.location = data;
                $("#marketing-table-contracts").find("button").attr("disabled", false);
            }
        }
    })
});

$('#marketing-table-contracts').on('click','#btnDeleteCont', function (){

    var id = $(this).val();

    if(confirm('Are you sure you want to delete the contract?'))
    {
        $.ajax({

            url : 'marketing_delete_contract',
            type : 'post',
            data : {
                'cont_id' : id
            },
            success : function (data)
            {
                alert('Delete success');
                tblContracts.ajax.reload(null, false);
            },
            error : function () {
                console.log('error');
            }

        });
    }
});

$('#marketing-table-contracts').on('click','#btnUpdateCont', function ()
{
    $('#txtClientName').val('');
    $('#txtContDesc').val('');
    $('#txtContRemarks').val('');
    $("#fileContract").val('');
    $('#dateStartCont').val('');
    $('#dateEndCont').val('');

    contracID = $(this).attr('value');
    $.ajax
    ({
        method: 'get',
        url: 'marketing-contract-fetch-info',
        data:
            {
                'contracID': contracID
            },
        success: function (data)
        {
            $('#txtClientNameUpdate').val(data[0].client_name);
            $('#dateStartContUpdate').val(data[0].start_date);
            $('#dateEndContUpdate').val(data[0].end_date);
            $('#txtContDescUpdate').val(data[0].contract_desc);
            $('#txtContRemarksUpdate').val(data[0].contract_remarks);
        }
    })
});

$('#marketing-table-clientbday').on('click','#btnDeleteBday', function (){

    var id = $(this).val();

    if(confirm('Are you sure you want to delete the Client Birthday?'))
    {
        $.ajax({

            url : 'marketing_delete_client_bday',
            type : 'post',
            data : {
                'bday_id' : id
            },
            success : function (data)
            {
                alert('Delete success');
                tblClientBday.ajax.reload(null, false);
            },
            error : function () {
                console.log('error');
            }

        });
    }

});


$('#marketing-table-clientbday').on('click','#btnUpdateBday', function ()
{

    $('#txtClientNameUpd').val('');
    $('#clientBdayUpd').val('');
    $('#txtClientContactNoUpd').val('');
    $("#clientEmailUpd").val('');
    $('#clientPosUpd').val('');
    $('#clientGiftTypeUpd').val('');
    $('#txtEmployerNameUpd').val('');

    clientBdayID = $(this).attr('value');

    $.ajax
    ({
        method: 'get',
        url: 'marketing-fetch-client-bday',
        data:
            {
                'clientBdayID': clientBdayID
            },
        success: function (data)
        {
            $('#txtClientNameUpd').val(data[0].client_name);
            $('#clientBdayUpd').val(data[0].birthdate);
            $('#txtClientContactNoUpd').val(data[0].contact_num);
            $('#clientEmailUpd').val(data[0].email_add);
            $('#clientPosUpd').val(data[0].client_position);
            $('#clientGiftTypeUpd').val(data[0].gift_type);
            $('#txtEmployerNameUpd').val(data[0].bank_name);
        }
    })
});

$('#marketing-table-prospect-client').on('click','#btnDeleteProsClient', function (){

    var id = $(this).val();

    if(confirm('Are you sure you want to delete the Client?'))
    {
        $.ajax({

            url : 'marketing_delete_pros_client',
            type : 'post',
            data : {
                'client_id' : id
            },
            success : function (data)
            {
                alert('Delete success');
                tblProsClient.ajax.reload(null, false);
            },
            error : function () {
                console.log('error');
            }

        });
    }

});

$('#marketing-table-prospect-client').on('click','#btnUpdateProsClient', function ()
{

    $('#txtClientNameProsUpd').val('');
    $('#clientDateInquiryUpd').val('');
    $('#txtContactPersonUpd').val('');
    $('#txtContactPositionUpd').val('');
    $('#txtContactNumberUpd').val('');
    $('#txtContactEmailUpd').val('');
    $('#txtReqCheckUpd').val('');
    $('#txtComAddUpd').val('');

    clientProsID = $(this).attr('value');

    $.ajax
    ({
        method: 'get',
        url: 'marketing-fetchinfo-pros-client',
        data:
            {
                'clientProsID': clientProsID
            },
        success: function (data)
        {
            $('#txtClientNameProsUpd').val(data[0].client_name);
            $('#clientDateInquiryUpd').val(data[0].date_inquiry);
            $('#txtContactPersonUpd').val(data[0].contact_person);
            $('#txtContactPositionUpd').val(data[0].contact_position);
            $('#txtContactNumberUpd').val(data[0].contact_number);
            $('#txtContactEmailUpd').val(data[0].contact_email);
            $('#txtReqCheckUpd').val(data[0].require_check);
            $('#txtComAddUpd').val(data[0].address);
        }
    })
});

$('#marketing-table-prospect-client').on('click','#prosBiDL', function ()
{
    $("#marketing-table-prospect-client").find("button").attr("disabled", true);
    clientDownloadProsID = $(this).attr('value');

    $.ajax
    ({
        method: 'get',
        url: 'marketing-download-pros-client',
        data:
            {
                'clientDownloadProsID': clientDownloadProsID
            },
        success: function (data)
        {
            if(data.length!=13)
            {
                window.location = data;
                $("#marketing-table-prospect-client").find("button").attr("disabled", false);
            }
            else
            {
                alert('no available file B.I report for this client');
                $("#marketing-table-prospect-client").find("button").attr("disabled", false);
            }
        }
    })
});

$('#btnContractUpdate').click(function ()
{
    $('#btnContractUpdate').attr('disabled',true);

    var clientName = $('#txtClientNameUpdate').val();
    var startDate = $('#dateStartContUpdate').val();
    var endDate = $('#dateEndContUpdate').val();
    var fileContract = new $("#fileContractUpdate").prop('files')[0];
    var txtContDesc = $('#txtContDescUpdate').val();
    var txtContRemarks = $('#txtContRemarksUpdate').val();

    var form_data = new FormData();
    form_data.append('contracID', contracID);
    form_data.append('clientName', clientName);
    form_data.append('startDate', startDate);
    form_data.append('endDate', endDate);
    form_data.append('fileContractUpdate', fileContract);
    form_data.append('txtContDesc', txtContDesc);
    form_data.append('txtContRemarks', txtContRemarks);

    if(startDate>endDate)
    {
        alert('End date must be ahead to start date or equal');
        $('#btnContractUpdate').attr('disabled',false);
    }
    else
    {
        $.ajax
        ({
            method: 'post',
            url: 'marketing-contract-update',
            data: form_data,
            processData: false,
            contentType: false,
            success: function (data)
            {
                if(data=='success')
                {
                    alert('Contract Successfully Update');
                    $('#txtClientNameUpdate').val('');
                    $('#txtContDescUpdate').val('');
                    $('#txtContRemarksUpdate').val('');
                    $("#fileContractUpdate").val('');
                    tblContracts.ajax.reload(null, false);
                    $('#btnContractUpdate').attr('disabled',false);
                    $('#modal-marketing-update-info').modal('hide');
                }
                else
                {
                    alert('Please fill up all empty fields');
                    $('#btnContractUpdate').attr('disabled',false);
                }
            }
        });
    }
});

$('#btnUpdateClientBdayInfo').click(function ()
{
    $('#btnUpdateClientBdayInfo').attr('disabled',true);

    var clientName = $('#txtClientNameUpd').val();
    var birthdate = $('#clientBdayUpd').val();
    var contactno = $('#txtClientContactNoUpd').val();
    var email = $('#clientEmailUpd').val();
    var position = $('#clientPosUpd').val();
    var gifttype = $('#clientGiftTypeUpd').val();
    var employerName = $('#txtEmployerNameUpd').val();

    var form_data = new FormData();
    form_data.append('clientBdayID', clientBdayID);
    form_data.append('clientName', clientName);
    form_data.append('birthdate', birthdate);
    form_data.append('contactno', contactno);
    form_data.append('email', email);
    form_data.append('position', position);
    form_data.append('gifttype', gifttype);
    form_data.append('employerName', employerName);

    if(clientName=='' || birthdate=='' || contactno=='' || email=='' || position=='' || gifttype=='' || employerName=='')
    {
        alert('Please Fill Up All Field/s');
        $('#btnSaveClientBday').attr('disabled',false);
    }
    else
    {
        $.ajax
        ({
            method: 'post',
            url: 'marketing-update-clients-bday',
            data: form_data,
            processData: false,
            contentType: false,
            success: function (data)
            {
                if(data=='success')
                {
                    alert('Clients Info Successfully Update');
                    $('#txtClientNameUpd').val('');
                    $('#clientBdayUpd').val('');
                    $('#txtClientContactNoUpd').val('');
                    $("#clientEmailUpd").val('');
                    $("#clientPosUpd").val('');
                    $("#clientGiftTypeUpd").val('A');
                    $('#txtEmployerNameUpd').val('');

                    tblClientBday.ajax.reload(null, false);
                    $('#btnUpdateClientBdayInfo').attr('disabled',false);
                    $('#modal-marketing-update-client-bday').modal('hide');
                }
                else
                {
                    alert('Please fill up all empty fields');
                    $('#btnUpdateClientBdayInfo').attr('disabled',false);
                }
            }
        });
    }
});

$('#btnSaveClientBday').click(function (e)
{
    e.preventDefault();

    $('#btnSaveClientBday').attr('disabled',true);

    var clientName = $('#txtClientName_bday').val();
    var birthdate = $('#clientBday').val();
    var contactno = $('#txtClientContactNo').val();
    var email = $('#clientEmail').val();
    var position = $('#clientPos').val();
    var gifttype = $('#clientGiftType').val();
    var employerNamee = $('#txtEmployerName').val();

    var form_data = new FormData();
    form_data.append('clientName', clientName);
    form_data.append('birthdate', birthdate);
    form_data.append('contactno', contactno);
    form_data.append('email', email);
    form_data.append('position', position);
    form_data.append('gifttype', gifttype);
    form_data.append('employerNamee', employerNamee);

    if(clientName=='' || birthdate=='' || contactno=='' || email=='' || position=='' || gifttype=='' || employerNamee=='')
    {
        alert('Please Fill Up All Field/s');
        $('#btnSaveClientBday').attr('disabled',false);
    }
    else
    {
        $.ajax
        ({
            method: 'post',
            url: 'marketing-insert-bday',
            data: form_data,
            processData: false,
            contentType: false,
            success: function (data)
            {
                if(data=='success')
                {
                    alert('Client\'s Birthdate Successfully Added');
                    $('#txtClientName_bday').val('');
                    $('#clientBday').val('');
                    $('#txtClientContactNo').val('');
                    $("#clientEmail").val('');
                    $("#clientPos").val('');
                    $("#clientGiftType").val('A');
                    $('#txtEmployerName').val('');

                    tblClientBday.ajax.reload(null, false);
                    $('#btnSaveClientBday').attr('disabled',false);
                }
                else if(data=='error')
                {
                    alert('Please fill up all empty fields');
                    $('#btnSaveClientBday').attr('disabled',false);
                }
            }
        });
    }
});

$('#btnSaveProsClient').click(function (e)
{
    e.preventDefault();

    $('#btnSaveProsClient').attr('disabled',true);

    var txtClientNamePros = $('#txtClientNamePros').val();
    var clientDateInquiry = $('#clientDateInquiry').val();
    var clientFile = new $("#clientFile").prop('files')[0];
    var txtContactPerson = $('#txtContactPerson').val();
    var txtContactPosition = $('#txtContactPosition').val();
    var txtContactNumber = $('#txtContactNumber').val();
    var txtContactEmail = $('#txtContactEmail').val();
    var txtReqCheck = $('#txtReqCheck').val();
    var txtComAdd = $('#txtComAdd').val();

    var form_data = new FormData();
    form_data.append('txtClientNamePros', txtClientNamePros);
    form_data.append('clientDateInquiry', clientDateInquiry);
    form_data.append('clientFile', clientFile);
    form_data.append('txtContactPerson', txtContactPerson);
    form_data.append('txtContactPosition', txtContactPosition);
    form_data.append('txtContactNumber', txtContactNumber);
    form_data.append('txtContactEmail', txtContactEmail);
    form_data.append('txtReqCheck', txtReqCheck);
    form_data.append('txtComAdd', txtComAdd);

    if(txtClientNamePros=='' || clientDateInquiry=='' || clientFile=='' || txtContactPerson=='' || txtContactPosition=='' || txtContactNumber=='' || txtContactEmail=='' || txtComAdd=='')
    {
        alert('Please Fill Up All Field/s');
        $('#btnSaveProsClient').attr('disabled',false);
    }
    else
    {
        $.ajax
        ({
            method: 'post',
            url: 'marketing-insert-pros-client',
            data: form_data,
            processData: false,
            contentType: false,
            success: function (data)
            {
                if(data=='success')
                {
                    alert('Prospect Client Successfully Added');

                    $('#txtClientNamePros').val('');
                    $('#clientDateInquiry').val('');
                    $("#clientFile").val('');
                    $('#txtContactPerson').val('');
                    $('#txtContactPosition').val('');
                    $('#txtContactNumber').val('');
                    $('#txtContactEmail').val('');
                    $('#txtReqCheck').val('');
                    $('#txtComAdd').val('');

                    tblProsClient.ajax.reload(null, false);
                    $('#btnSaveClientBday').attr('disabled',false);
                }
                else if(data=='error')
                {
                    tblProsClient.ajax.reload(null, false);
                    alert('Please fill up all empty fields or attached valid zip file');
                    $('#btnSaveProsClient').attr('disabled',false);
                }
            }
        });
    }
});

$('#btnUpdateProspectClient').click(function ()
{
    $('#btnUpdateProspectClient').attr('disabled',true);

    var txtClientNameProsUpd = $('#txtClientNameProsUpd').val();
    var clientDateInquiryUpd = $('#clientDateInquiryUpd').val();
    var clientFileUpd = new $("#clientFileUpd").prop('files')[0];
    var txtContactPersonUpd = $('#txtContactPersonUpd').val();
    var txtContactPositionUpd = $('#txtContactPositionUpd').val();
    var txtContactNumberUpd = $('#txtContactNumberUpd').val();
    var txtContactEmailUpd = $('#txtContactEmailUpd').val();
    var txtReqCheckUpd = $('#txtReqCheckUpd').val();
    var txtComAddUpd = $('#txtComAddUpd').val();

    var form_data = new FormData();
    form_data.append('txtClientNamePros', txtClientNameProsUpd);
    form_data.append('clientDateInquiry', clientDateInquiryUpd);
    form_data.append('clientFile', clientFileUpd);
    form_data.append('txtContactPerson', txtContactPersonUpd);
    form_data.append('txtContactPosition', txtContactPositionUpd);
    form_data.append('txtContactNumber', txtContactNumberUpd);
    form_data.append('txtContactEmail', txtContactEmailUpd);
    form_data.append('txtReqCheck', txtReqCheckUpd);
    form_data.append('txtComAdd', txtComAddUpd);
    form_data.append('clientProsID', clientProsID);

    if(txtClientNameProsUpd=='' || clientDateInquiryUpd=='' || txtReqCheckUpd=='' || txtContactPersonUpd=='' || txtContactPositionUpd=='' || txtContactNumberUpd=='' || txtContactEmailUpd=='' || txtComAddUpd=='')
    {
        alert('Please Fill Up All Field/s');
        $('#btnUpdateProspectClient').attr('disabled',false);
    }
    else
    {
        $.ajax
        ({
            method: 'post',
            url: 'marketing-update-pros-client',
            data: form_data,
            processData: false,
            contentType: false,
            success: function (data)
            {
                if(data=='success')
                {
                    alert('Clients Info Successfully Update');
                    $('#txtClientNameProsUpd').val('');
                    $('#clientDateInquiryUpd').val('');
                    $("#clientFileUpd").val('');
                    $('#txtContactPersonUpd').val('');
                    $('#txtContactPositionUpd').val('');
                    $('#txtContactNumberUpd').val('');
                    $('#txtContactEmailUpd').val('');
                    $('#txtReqCheckUpd').val('');
                    $('#txtComAddUpd').val('');

                    tblProsClient.ajax.reload(null, false);
                    $('#btnUpdateProspectClient').attr('disabled',false);
                    $('#modal-marketing-update-pros-client').modal('hide');
                }
                else if(data=='error')
                {
                    alert('Please fill up all empty field/s or attached valid zip file');
                    $('#btnUpdateProspectClient').attr('disabled',false);
                }
            }
        });
    }
});

$('#btnSaveEvent').click(function ()
{
    $('#btnSaveEvent').attr('disabled',true);

    var event_title = $('#event_title').val();
    var event_description = $('#event_description').val();
    var event_startdate = $('#event_startdate').val();
    var event_enddate = $('#event_enddate').val();

    var form_data = new FormData();
    form_data.append('event_title',event_title);
    form_data.append('event_description',event_description);
    form_data.append('event_startdate',event_startdate);
    form_data.append('event_enddate',event_enddate);

    if($('#event_title').val()=='' || $('#event_description').val()=='' || $('#event_startdate').val()=='' || $('#event_enddate').val()=='')
    {
        alert('Please Fill Up All Necessary Fields');
        $('#btnSaveEvent').attr('disabled',false);
    }
    else if(event_startdate>event_enddate)
    {
        $('#btnSaveEvent').attr('disabled',false);
        alert('Start date must be less than or equal to end date');
    }
    else
    {
        $.ajax
        ({
            method: 'post',
            url: 'marketing-insert-todolist',
            data: form_data,
            processData: false,
            contentType: false,
            success: function (data)
            {
                if(data=='success')
                {
                    alert('To Do List Successfully Save!');
                    $('#event_title').val('');
                    $('#event_description').val('');
                    $("#event_startdate").val('');
                    $('#event_enddate').val('');

                    tableToDoList.ajax.reload(null, false);
                    $('#btnSaveEvent').attr('disabled',false);
                }
                else if(data=='error')
                {
                    alert('Please fill up all empty field/s');
                    $('#btnSaveEvent').attr('disabled',false);
                }
            }
        });
    }
});

$('#marketing-table-todolist').on('click','#btnUpdateTodolist',function ()
{
    $('#modal-todolist-update').modal('show');

    todolistID = $(this).attr('value');

    $.ajax
    ({
        type: 'get',
        url: 'marketing-update-todolist-fetch-info',
        data:
            {
                'todolistID': todolistID
            },
        success: function (data)
        {
            $('#event_title_update').val('');
            $('#event_description_update').val('');
            $('#event_startdate_update').val('');
            $('#event_enddate_update').val('');

            $('#event_title_update').val(data.title);
            $('#event_description_update').val(data.event_description);
            $('#event_startdate_update').val(data.start_date);
            $('#event_enddate_update').val(data.end_date);
        }
    });
});

$('#btnUpdateEvent').click(function ()
{
    $('#btnUpdateEvent').attr('disabled',true);

    var event_title_update = $('#event_title_update').val();
    var event_description_update = $('#event_description_update').val();
    var event_startdate_update = $('#event_startdate_update').val();
    var event_enddate_update = $('#event_enddate_update').val();

    var formData = new FormData();
    formData.append('todolistID',todolistID);
    formData.append('event_title_update',event_title_update);
    formData.append('event_description_update',event_description_update);
    formData.append('event_startdate_update',event_startdate_update);
    formData.append('event_enddate_update',event_enddate_update);

    $.ajax
    ({
        type: 'post',
        url: 'marketing-update-todolist-info',
        data: formData,
        processData: false,
        contentType: false,
        success: function (data)
        {
            if(data=='success')
            {

                $('#btnUpdateEvent').attr('disabled',false);
                alert('Event Successfully Updated');
                $('#modal-todolist-update').modal('hide');
                tableToDoList.ajax.reload(null, false);
            }
            else
            {
                $('#modal-todolist-update').modal('hide');
                $('#btnUpdateEvent').attr('disabled',false);
                alert('Error Updating Event! Please refresh or try it again.');
                tableToDoList.ajax.reload(null, false);
            }
        }
    });
});

$('#marketing-table-todolist').on('click','#btnDoneTodolist',function ()
{
    todolistID = $(this).attr('value');

    if(confirm('Do you want to tag this event as finish?'))
    {
        $.ajax
        ({
            type: 'get',
            url: 'marketing-done-todolist-info',
            data:
                {
                    'todolistID': todolistID
                },
            success: function (data)
            {
                if(data=='success')
                {
                    tableToDoList.ajax.reload(null, false);
                    tableDoneToDoList.ajax.reload(null, false);
                    alert('Successfully Finish Event!');
                }
                else
                {
                    tableToDoList.ajax.reload(null, false);
                    tableDoneToDoList.ajax.reload(null, false);
                    alert('Error! Please refresh or try it again.');
                }
            }
        });
    }
});

$('#marketing-table-todolist').on('click','#btnDeleteTodolist',function ()
{
    todolistID = $(this).attr('value');

    if(confirm('Do you want to delete this event?'))
    {
        $.ajax
        ({
            type: 'get',
            url: 'marketing-delete-todolist',
            data:
                {
                    'todolistID': todolistID
                },
            success: function (data)
            {
                if(data=='success')
                {
                    tableToDoList.ajax.reload(null, false);
                    tableDoneToDoList.ajax.reload(null, false);
                    alert('Successfully Deleted Event!');
                }
                else
                {
                    tableToDoList.ajax.reload(null, false);
                    tableDoneToDoList.ajax.reload(null, false);
                    alert('Error! Please refresh or try it again.');
                }
            }
        });
    }
});

$('#btn_save_tat_info').click(function ()
{

    // console.log($('#fw_tat'));
    // $(this).attr('disabled','disabled');
    var fw = $('#fw_tat').val();
    var obs = $('#obw_tat').val();
    var agt = $('#agreed_tat').val();

    var fw_muni = $('#fw_tat_muni').val();
    var obs_muni = $('#obw_tat_muni').val();
    var agt_muni = $('#agreed_tat_muni').val();



    if($('#rateMuniProv_tat').val() == 'prov_tat')
    {

        if(fw == '' || obs == '' || agt == '')
        {
            alert('Please fill up all information.');
        }
        else
        {
            $.ajax({
                type: 'get',
                url: 'marketing_check_tat_prov',
                data:
                    {
                        'prov_id' : $('#provID_tat').val(),
                        'client_id' : $('#bankBulkID_tat').val()
                    },
                beforeSend : function () {
                    console.log("please wait");

                },
                success : function (data) {

                    if(data >= 1)
                    {
                        var con = confirm("WARNING! : One or more data ("+data+") will be alter. Click Ok to save.");
                        if(con)
                        {
                            saveit('update');
                        }
                        else
                        {

                        }
                    }
                    else
                    {
                        saveit('not');
                    }

                }
            });
            function saveit(if_update) {

                $.ajax
                ({
                    type: 'get',
                    url: 'marketing_save_tat_prov',
                    data:{
                        'prov_id' : $('#provID_tat').val(),
                        'client_id' : $('#bankBulkID_tat').val(),
                        'fw_tat' : fw,
                        'obw_tat' : obs,
                        'agreed_tat' : agt,
                        'if_update' : if_update
                    },
                    beforeSend : function () {
                        console.log("please wait");
                    },
                    success : function () {
                        console.log("success");

                        alert('Success');
                        $('#fw_tat').val('');
                        $('#obw_tat').val('');
                        $('#agreed_tat').val('');

                        tableTat.ajax.reload(null, false);

                    },
                    error : function () {
                        console.log('error');
                    },
                    complete : function () {

                        console.log('complete');
                    }
                })
            }
        }
    }
    else if($('#rateMuniProv_tat').val() == 'muni_tat')
    {
        if(fw_muni == '' || obs_muni == '' || agt_muni == '')
        {
            alert('Please fill up all information.');
        }
        else
        {

            $.ajax({
                type: 'get',
                url: 'marketing_check_tat_muni',
                data:
                    {
                        'muni_id' : $('#idMunicipality_tat').val(),
                        'prov_id' : $('#idProvince_tat').val(),
                        'client_id' : $('#bankID_tat').val()
                    },
                beforeSend : function () {
                    console.log("please wait");

                },
                success : function (data) {


                    if(data >= 1)
                    {
                        alert("This information is already inputted, If you want to alter this information please click \"EDIT\" on the table.");
                    }
                    else
                    {
                        $.ajax({
                            type: 'get',
                            url: 'marketing_save_tat_muni',
                            data:
                                {
                                    'muni_id' : $('#idMunicipality_tat').val(),
                                    'prov_id' : $('#idProvince_tat').val(),
                                    'client_id' : $('#bankID_tat').val(),
                                    'fw_tat' : fw_muni,
                                    'obw_tat' : obs_muni,
                                    'agreed_tat' : agt_muni,
                                },
                            beforeSend : function () {
                                console.log("please wait");

                            },
                            success : function(data)
                            {

                                alert('Success');
                                $('#fw_tat_muni').val('');
                                $('#obw_tat_muni').val('');
                                $('#agreed_tat_muni').val('');
                                tableTat.ajax.reload(null, false);

                            },
                            error : function () {
                                console.log('error');
                            }
                        });
                    }
                },
                error : function () {
                    console.log('error');
                }
            });

        }
    }
});

$('#marketing-table-tat-manage').on('click','#tat_delete',function () {

    var id = $(this).attr('name');
    console.log(id);


    $.ajax({

        type : 'get',
        url : 'tat_management_delete',
        data :
            {
                'id' : id
            },
        success : function (data) {
            tableTat.ajax.reload(null, false);
        },
        error : function () {
            console.log('error');
        }

    });

});


$('#btnSubmitStandardRate').click(function() {

    $("#btnSubmitStandardRate").attr("disabled", true);

    var rateMuni = $('#idMunicipality2').val();
    var rateProv = $('#idProvince2').val();
    var rateBank = $('#txtBankRate2').val();
    var vatRate = $('#txtVATmuni2').val();
    var totRate = $('#txtMuniTotalRate2').val();
    var muniTat = $('#txtAgreedTATmuni2').val();
    $.ajax
    ({
        type: 'post',
        url: 'marketing-insert-standard',
        data:
            {
                'rateMuni': rateMuni,
                'rateProv': rateProv,
                'rateBank': rateBank,
                'vatRate': vatRate,
                'totRate': totRate,
                'muniTat': muniTat
            },
        beforeSend: function ()
        {
            $('#modal-sendingrequest').modal('show');
        },
        success: function (data)
        {

            console.log(data.error);

            if (data.error == 'required')
            {
                $('#modal-sendingrequest').modal('hide');
                $("#btnSubmitStandardRate").attr("disabled", false);

                var timerError = setInterval(function ()
                {
                    $('#modal-filluperror').modal('show');
                    clearInterval(timerError);
                }, 1000);
            }
            else if (data.exist == 'exist') {

                $('#modal-sendingrequest').modal('hide');
                $("#btnSubmitStandardRate").attr("disabled", false);

                var timerError = setInterval(function ()
                {

                    if (confirm("The selected province already has a record that exists. Do you want to update the record?"))
                    {
                        rateMuni = $('#idMunicipality2').val();
                        var rateNew = $('#txtBankRate2').val();
                        var vatNew = $('#txtVATmuni2').val();
                        var totalNew = $('#txtMuniTotalRate2').val();
                        var tatNew = $('#txtAgreedTATmuni2').val();

                        $.ajax
                        ({
                            type: 'get',
                            url: 'marketing-update-muni-form-standard',
                            data:
                                {
                                    'rateMuni' : rateMuni,
                                    'rateNew' : rateNew,
                                    'vatNew' : vatNew,
                                    'totalNew' : totalNew,
                                    'tatNew' : tatNew
                                },
                            success: function () {



                                $('#modal-sendingrequest').modal('hide');
                                $("#btnSubmitStandardRate").attr("disabled", false);

                                $('#marketingMuni2').val('');
                                $('#marketingProv2').val('');
                                $('#idMunicipality2').val('');
                                $('#idProvince2').val('');
                                $('#txtBankRate2').val('');
                                $('#txtVATmuni2').val('');
                                $('#txtMuniTotalRate2').val('');
                                $('#txtAgreedTATmuni2').val('');

                                var timerSuccess = setInterval(function ()
                                {
                                    $('#modal-update').modal('show');
                                    tableStandardRate.ajax.reload(null, false);

                                    var timerSuccessHide = setInterval(function ()
                                    {
                                        $('#modal-update').modal('hide');
                                        clearInterval(timerSuccessHide);
                                    },5000);


                                    clearInterval(timerSuccess);
                                },1000);
                            }

                        });
                    }
                    clearInterval(timerError);
                },500);
            }
            else
            {

                $('#modal-sendingrequest').modal('hide');
                $("#btnSubmitStandardRate").attr("disabled", false);

                $('#marketingMuni2').val('');
                $('#marketingProv2').val('');
                $('#idMunicipality2').val('');
                $('#idProvince2').val('');
                $('#txtBankRate2').val('');
                $('#txtVATmuni2').val('');
                $('#txtMuniTotalRate2').val('');
                $('#txtAgreedTATmuni2').val('');

                var timerSuccess = setInterval(function ()
                {
                    $('#modal-sentsuccess').modal('show');
                    tableStandardRate.ajax.reload(null, false);
                    var timerSuccessHide = setInterval(function ()
                    {
                        $('#modal-sentsuccess').modal('hide');
                        clearInterval(timerSuccessHide);
                    },5000);
                    clearInterval(timerSuccess);
                },1000);
            }
        }
    })
});
//submit province
$('#btnStandardBulkRate').click(function() {

    $("#btnStandardBulkRate").attr("disabled", true);

    var provID2 = $('#provID2').val();
    var bulkRate2 = $('#txtBulkRate2').val();
    var vatProvRate2 = $('#txtVATprov2').val();
    var totProvRate2 = $('#txtProvTotalRate2').val();
    var provTat2 = $('#txtAgreedTATprov2').val();

    $.ajax
    ({
        type: 'get',
        url: 'marketing-insert-bulk-standard',
        data:
            {
                'provID2': provID2,
                'bulkRate2': bulkRate2,
                'vatProvRate2': vatProvRate2,
                'totProvRate2' : totProvRate2,
                'provTat2' : provTat2
            },
        beforeSend: function ()
        {
            $('#modal-sendingrequest').modal('show');
        },
        success: function (data)
        {
            console.log(data.error);

            if(data.error=='required')
            {
                console.log(data);
                $('#modal-sendingrequest').modal('hide');
                $("#btnStandardBulkRate").attr("disabled", false);


                var timerError = setInterval(function ()
                {
                    $('#modal-filluperror').modal('show');
                    clearInterval(timerError);
                },1000);
            }

            else if(data.exist=='exist')
            {
                $('#modal-sendingrequest').modal('hide');
                $("#btnStandardBulkRate").attr("disabled", false);

                var timerError = setInterval(function ()
                {

                    if (confirm("The selected province already has a record that exists. Do you want to update the record?"))
                    {
                        provID2 = $('#provID2').val();
                        var rateNew = $('#txtBulkRate2').val();
                        var vatNew = $('#txtVATprov2').val();
                        var totalNew = $('#txtProvTotalRate2').val();
                        var tatNew = $('#txtAgreedTATprov2').val();

                        $.ajax
                        ({
                            type: 'get',
                            url: 'marketing-update-prov-standard',
                            data:
                                {
                                    'provID2' : provID2,
                                    'rateNew' : rateNew,
                                    'vatNew' : vatNew,
                                    'totalNew' : totalNew,
                                    'tatNew' : tatNew
                                },
                            success: function () {

                                $('#modal-sendingrequest').modal('hide');
                                $("#btnStandardBulkRate").attr("disabled", false);

                                var timerSuccess = setInterval(function ()
                                {
                                    $('#modal-update').modal('show');
                                    tableStandardRate.ajax.reload(null, false);
                                    var timerSuccessHide = setInterval(function ()
                                    {
                                        $('#modal-update').modal('hide');
                                        clearInterval(timerSuccessHide);
                                    },5000);
                                    clearInterval(timerSuccess);
                                },1000);
                                $('#txtBulkRate2').val('');
                                $('#txtVATprov2').val('');
                                $('#txtProvTotalRate2').val('');
                                $('#txtAgreedTATprov2').val('');
                            }

                        });
                    }
                    else
                    {

                    }
                    clearInterval(timerError);
                },500);

            }
            else
            {
                $('#modal-sendingrequest').modal('hide');
                $("#btnStandardBulkRate").attr("disabled", false);

                $('#txtBulkRate2').val('');
                $('#txtVATprov2').val('');
                $('#txtProvTotalRate2').val('');
                $('#txtAgreedTATprov2').val('');

                var timerSuccess = setInterval(function ()
                {
                    $('#modal-sentsuccess').modal('show');
                    tableStandardRate.ajax.reload(null, false);

                    var timerSuccessHide = setInterval(function ()
                    {
                        $('#modal-sentsuccess').modal('hide');
                        clearInterval(timerSuccessHide);
                    },5000);
                    clearInterval(timerSuccess);
                },1000);

            }
        }
    })
});
//update table click
$('#marketing-table-manage-rate').on('click', '#updaterate', function () {

    acctID2 = $(this).val();
    console.log(acctID2);
    var muni = $(this).attr('name');
    $.ajax
    ({
        type: 'get',
        url: 'marketing-get-info-update',
        data:
            {
                'acctID2': acctID2
            },
        success: function (data) {
            console.log(data);

            if (data.error == 'required') {
                alert('No data retrieved');
            }
            else {
                $('#modal-rateedit').modal('show');

                $('#editBankRate').val(data[0].rate);
                $('#editVAT').val(data[0].vat);
                $('#editTotalRate').val(data[0].total_rate);
                $('#editTAT').val(data[0].tat);
                $('#NameRecord').html(muni);



            }
        }
    })
});
$('#btnUpdateStandard').click(function() {


    var Rate = $('#editBankRate').val();
    var Vat = $('#editVAT').val();
    var totalRate = $('#editTotalRate').val();
    var Tat = $('#editTAT').val();

    $("#btnUpdateStandard").attr("disabled", true);
    $.ajax
    ({
        type: 'get',
        url: 'marketing-update-muni-standard',
        data:
            {
                'acctID2' : acctID2,
                'Rate' : Rate,
                'Vat' : Vat,
                'totalRate' : totalRate,
                'Tat' : Tat
            },
        beforeSend: function ()
        {
            confirm('Are you sure to update?');
        },
        success: function (data)
        {
            console.log(data.error);

            if (data.error == 'required')
            {

                $("#btnUpdateStandard").attr("disabled", false);

                alert('Fill up all fields!');

                $('#editBankRate').val();
                $('#editVAT').val();
                $('#editTotalRate').val();
                $('#editTAT').val();

                $('#modal-rateedit').modal('show');
            }
            else
            {
                $("#btnUpdateStandard").attr("disabled", false);
                $('#modal-sendingrequest').modal('hide');
                $('#modal-update').modal('show');
                tableStandardRate.ajax.reload(null, false);
                $('#modal-rateedit').modal('hide');
            }
        }
    });
});



$('#editBankRate').on('input', function () {

    if ($('#editBankRate').val() < 0) {
        alert('Rate must be greater than negative value');
        $('#editBankRate').val('');
    }
    else {
        $('#editVAT').val('');

        var vat = $('#editBankRate').val() * .12;
        $('#editVAT').val(Math.round(vat));

        $('#editTotalRate').val(parseInt($('#editBankRate').val()) + parseInt($('#editVAT').val()))

        if ($('#editBankRate').val() == '') {
            $('#editTotalRate').val('');
            $('#editVAT').val('');
        }
    }
});

//delete standard record
$('#marketing-table-manage-rate').on('click', '#deleterate', function () {

    acctID3 = $(this).val();

    if (confirm('Are you sure to delete?'))
        $.ajax
        ({
            type: 'get',
            url: 'marketing-delete-standard',
            data:
                {
                    'acctID3': acctID3
                },
            beforeSend: function () {
                $('#modal-requestDelete').modal('show');
            },
            success: function (data) {
                $('#modal-requestDelete').modal('hide');

                var timerSuccess = setInterval(function ()
                {
                    $('#modal-delete').modal('show');
                    tableStandardRate.ajax.reload(null, false);

                    var timerSuccessHide = setInterval(function ()
                    {
                        $('#modal-delete').modal('hide');
                        clearInterval(timerSuccessHide);
                    },5000);

                    clearInterval(timerSuccess);
                },1000);

            }
        })
});

$('#btnSubmitNone').click(function(){

    $('#modal-filluperror').modal('show');
});

function calendar_fetch_data() {
    events = [];
    jQuery.ajax({
        url: 'marketing_get_holidays',
        type: 'POST',
        dataType: 'json',
        success: function(doc) {
            // console.log(doc);
            $.map( doc, function( r ) {
                // console.log(r);
                if(r.repeat == 'true')
                {
                    var get_start = r.start_date;
                    var splited_start_date = get_start.split('-');
                    var start_year = splited_start_date[0];
                    var start_month = splited_start_date[1];
                    var start_day = splited_start_date[2];

                    var get_end = r.end_date;
                    var splited_end_date = get_end.split('-');
                    var end_year = splited_end_date[0];
                    var end_month = splited_end_date[1];
                    var end_day = splited_end_date[2];

                    for(var ctr = 0; ctr<10; ctr++)
                    {
                        // console.log('true: '+start_year+'-'+start_month+'-'+start_day);

                        events.push({
                            id: r.id,
                            title: r.title,
                            desc: r.description,
                            start: start_year+'-'+start_month+'-'+start_day,
                            end: end_year+'-'+end_month+'-'+end_day,
                            start_text: start_year+'-'+start_month+'-'+start_day,
                            end_text : end_year+'-'+end_month+'-'+end_day
                        });

                        start_year++;
                        end_year++;

                    }
                }
                else if(r.repeat == 'false')
                {
                    // console.log('false: '+r.start_date);

                    events.push({
                        id: r.id,
                        title: r.title,
                        desc: r.description,
                        start: r.start_date,
                        end: r.end_date,
                        start_text:  r.start_date,
                        end_text : r.end_date
                    });
                }
            });

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
    var date = new Date();
    var d    = date.getDate(),
        m    = date.getMonth(),
        y    = date.getFullYear();

    full_calendar_tat = $('#calendar_tat').fullCalendar({
        header    : {
            left  : 'prev,next today',
            center: 'title',
            right : 'month'
        },
        buttonText: {
            today: 'today',
            month: 'month'
        },
        events: function(start, end, timezone, callback) {

            callback(events);

        },
        eventClick: function(event) {
            console.log(event);
            event_id = event.id;
            $('#cal_title').val(event.title);
            $('#cal_description').val(event.desc);
            $('#cal_date_start').html(event.start_text);
            $('#cal_date_end').html(event.end_text);
            // console.log(event.start_text);
            $('#modal_view_info_calendar').modal('show');
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
        //     // assign it the date that was reported
        //     copiedEventObject.start           = date;
        //     copiedEventObject.allDay          = allDay;
        //     copiedEventObject.backgroundColor = $(this).css('background-color');
        //     copiedEventObject.borderColor     = $(this).css('border-color');
        //
        //     // render the event on the calendar
        //     // the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
        //     $('#calendar_tat').fullCalendar('renderEvent', copiedEventObject, true);
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

$('#btn_save_holiday').click(function () {

    var title = $('#holiday_title').val();
    var descript = $('#holiday_description').val();
    var repeat = $('.holiday_type_repeat_class:checked').val();
    var start_date = $('#holiday_startdate').val();
    var end_date = $('#holiday_enddate').val();

    // console.log(end_date);

    $.ajax({

        type    :   'post',
        url     :   'marketing_save_holiday_event_tat',
        data    :   {
            'title'         :   title,
            'descript'      :   descript,
            'repeat'        :   repeat,
            'start_date'    :   start_date,
            'end_date'      :   end_date
        },
        success : function () {

            alert('Holiday Added');
            calendar_fetch_data();
        },
        error : function () {

            console.log('error');

        },
        complete : function () {
            setTimeout(function () {
                full_calendar_tat.fullCalendar('refetchEvents');
            },1000);
        }

    });

    // console.log(repeat);

});

$('#cal_btn_delete').click(function () {

    $.ajax({

        url : 'marketing_deletes_holiday_cal',
        type : 'post',
        data :
            {
                'event_id': event_id
            },
        success : function (data) {
            console.log('success');
            alert('Delete success.');
            calendar_fetch_data();
            $('#modal_view_info_calendar').modal('hide');
        },
        error : function () {
            console.log('error');
        },
        complete : function () {
            setTimeout(function () {
                full_calendar_tat.fullCalendar('refetchEvents');
            },1000);
        }

    });

});

$('.marketing-manage_a_class').click(function(){

    var gethref = $(this).attr('href');
    console.log(gethref);

    if(gethref == '#tab_z')
    {
        if ($('' + gethref + '').hasClass('active')) {
            console.log('do nothing');
            activeTabRate = 'tab_z';
        }
        else if (manage_add_rate) {
            console.log('already loaded');
            activeTabRate = 'tab_z';

        }
        else if (manage_add_rate == false) {
            manage_add_rate = true;
            activeTabRate = 'tab_z';
        }

    }
    else if (gethref == '#tab_x')
    {
        if ($('' + gethref + '').hasClass('active')) {
            console.log('do nothing');
            activeTabRate = 'tab_x';
        }
        else if (manage_standard_rate) {

            console.log('already loaded');
            activeTabRate = 'tab_x';
        }
        else if (manage_standard_rate == false) {
            manage_standard_rate = true;
            activeTabRate = 'tab_x';
            marketing_manage_standard_rate_table()

        }
    }
});

$("#updateAccounts").click(function () {

    if(confirm('Updating accounts might take several minutes. Continue?'))
    {
        $.ajax({
            url     : 'marketing_tat_update_accounts',
            type    : 'post',
            data    :
                {
                    'date_from' : $("#updateAccountsfrom").val()
                },
            beforeSend: function () {
                $('#modal-updating-accounts').modal('show');
            },
            success : function (data) {

                $('#modal-updating-accounts').modal('hide');

                setTimeout(function () {

                    $('#modal-success-accounts').modal('show');

                },1000);
                // alert('Accounts successfully updated.');
            },
            error : function () {

                $('#modal-updating-accounts').modal('hide');

                setTimeout(function () {
                    $('#modal-fail-accounts').modal('show');
                },1000);

                console.log('error');
            }
        });
    }
});

$('#bi_rates_client_name').change(function()
{
    var bi_client_id = $(this).children("option:selected").val();

    if(bi_client_id == '-')
    {
        // $('#bi_rates_packagename_span').fadeOut();
        $('#bi_rates_packagename').attr('disabled', true);
    }
    else
    {
        $.ajax(
            {
                type: 'get',
                url: 'marketing_get_client_package',
                data: {
                    'id' : bi_client_id
                },
                success: function(data)
                {
                    // console.log(data);

                    var options = '<option value="-">-</option>';

                    for(var i = 0; i < data.length; i++)
                    {
                        options += '<option value="'+data[i].id+'">'+data[i].package+'</option>';
                    }

                    $('#bi_rates_packagename').html(options);
                },
                complete: function()
                {
                    $('#bi_rates_packagename').attr('disabled', false);
                }
            }
        );
    }
});

$('#bi_rates_client_name_alacarte').change(function()
{
    var bi_client_id = $(this).children("option:selected").val();

    if(bi_client_id == '-')
    {
        // $('#bi_rates_packagename_span').fadeOut();
        $('#bi_rates_packagename_alacarte').val('-').trigger('change').attr('disabled', true);
        $('#bi_rates_ocular_alacarte').val('-').trigger('change').attr('disabled', true);
    }
    else
    {
        $.ajax(
            {
                type: 'get',
                url: 'marketing_get_client_alacarte',
                data: {
                    'id' : bi_client_id
                },
                success: function(data)
                {
                    console.log(data);

                    var options = '<option value="-">-</option>';

                    for(var i = 0; i < data.length; i++)
                    {
                        options += '<option value="'+data[i].id+'" name="'+data.ocular+'">'+data[i].checking_name+'</option>';
                    }

                    $('#bi_rates_packagename_alacarte').html(options);
                },
                complete: function()
                {
                    $('#bi_rates_packagename_alacarte').attr('disabled', false);
                    $('#bi_rates_ocular_alacarte').attr('disabled', false);
                }
            }
        );
    }
});

$('#bi_rates_packagename').change(function()
{
    if($(this).children("option:selected").val() == '-')
    {
        // $('#bi_addrate_amount_span').fadeOut();
        // $('#bi_addrate_amount').fadeOut();
        $('#bi_addrate_amount').attr('disabled', true);
    }
    else
    {
        // $('#bi_addrate_amount_span').fadeIn();
        $('#bi_addrate_amount').attr('disabled', false);

    }
});

$('#bi_rates_packagename_alacarte').change(function()
{
    if($(this).children("option:selected").val() == '-' && $('#bi_rates_ocular_alacarte').children("option:selected").val() == '-')
    {
        $('#bi_addrate_amount_alacarte').attr('disabled', true);
    }
    else
    {
        $('#bi_addrate_amount_alacarte').attr('disabled', false);
    }
});

function bi_rate_table()
{
    bi_rates_table = $('#bi_rate_table').DataTable
    ({
        "responsive" : true,
        "processing" : true,
        "serverSide" : true,
        "ajax" : 'marketing_bi_rate_table',
        "columns":
            [
                {data: 'id', name: 'bi_rates.id'},
                {data: 'package', name: 'bi_rates.package'},
                {data: 'client_name', name: 'bi_rates.client_name'},
                {data : 'rates', name : 'rate'},
                {data : 'date_time', name : 'bi_rates.id'},
                {
                    data: function(data)
                    {
                        return '<button class="btn btn-xs btn-info btn-block bi_rates_update" id="'+data.id+'" rate="'+data.rate+'" what="rate">Updpate</button>' +
                            '<button class="btn btn-xs btn-primary btn-block bi_rates_log" id="'+data.id+'">View Logs</button>';
                    },
                    'name' : 'bi_rates.id',
                    'searchable' : false,
                    'orderable' : false,
                    "width": '10%'
                }
            ],
        "order" :[[0, 'desc']],
        "pageLength" : 10,
        "lengthMenu" : [[2, 10, 25, 50, -1], ['2 rows', '10 rows', '25 rows', '50 rows', 'Show all']]
    });

    $('#bi_rate_table_filter input').unbind();
    $('#bi_rate_table_filter input').bind('keyup change', function(e)
    {
        if($(this).is(':focus'))
        {
            if (e.keyCode === 13) {
                bi_rates_table.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '') {
                    bi_rates_table.search($(this).val()).draw();
                }
            }
        }
    });
}

$('#add_bi_rate').click(function()
{
    var btn = $(this);
    btn.attr('disabled', true);
    var bi_client_id = $('#bi_rates_client_name').children("option:selected").val();
    var package_id = $('#bi_rates_packagename').children("option:selected").val();
    var rate_inputted = $('#bi_addrate_amount').val();

    if(rate_inputted == '')
    {
        alert('Fill the amout to proceed');
        $('#bi_addrate_amount').css('border-style', 'solid');
        $('#bi_addrate_amount').css('border-color', 'red');

        setTimeout(function()
        {
            $('#bi_addrate_amount').css('border-color', 'rgb(152, 146, 146)');
        }, 2000);

        btn.attr('disabled', false);
    }
    else
    {
        $.ajax(
            {
                type: 'get',
                url : 'marketing_add_rate_to_bi',
                data: {
                    'bi_id' : bi_client_id,
                    'package_id' : package_id,
                    'rate_inputted' : rate_inputted
                },
                success: function(data)
                {
                    alert(data);
                },
                complete: function()
                {
                    btn.attr('disabled', false);
                    // $('#bi_rates_client_name').children("option:selected").val('-');
                    $('#bi_rates_client_name').val('-').trigger('change');
                    $('#bi_rates_packagename').val('-').trigger('change');
                    $('#bi_addrate_amount').val('');
                    bi_rates_table.ajax.reload(null,false);
                }
            }
        );
    }
});

$('#bi_rate_table').on('click', '.bi_rates_update', function()
{
    bi_rate_id = $(this).attr('id');
    $('#btn_rate_edit').hide();
    $('#edit_rate_bi').show();
    $('#cancel_bi_rate_edit').hide();
    $('#modal-update-bi-rate').modal('show');
    $('#editted_amount').val($(this).attr('rate')).attr('disabled', true);
    $('#btn_rate_edit').attr('typee', $(this).attr('what'));
});

$('#bi_rate_table').on('click', '.bi_rates_log', function()
{
    var id = $(this).attr('id');
    $('#modal-update-bi-logs').modal('show');
    console.log(id);
    $('#marketing_logs_table').html('');

    $.ajax({
        type: 'get',
        url: 'marketing_get_logs',
        data: {
            'id' : id,
            'type' : 'bi_rates'
        },
        success: function(data)
        {
            var table = '<table class="table-condensed table-hover" id="marketing_logs_table" width="100%">';
            var tableheader = '<tr class="stylethis"><td colspan="3"><b>LOGS</b></td></tr>' +
                '<tr>\n' +
                '<th>NAME</th>\n' +
                '<th>DATE/TIME OCCURED</th>\n' +
                '<th>ACTIVITY/LOGS</th>\n' +
                '</tr>';
            var dataa = '';


            if(data == '')
            {
                dataa += '<tr><td colspan="3">NO AVAILABLE RECORDS</td></tr>';
            }
            else
            {
                for(var i = 0; i < data[0].length; i++)
                {
                    dataa += '<tr>\n' +
                        '<td>'+data[0][i].name+'</td>\n' +
                        '<td>'+data[0][i].created_at+'</td>\n' +
                        '<td>'+data[0][i].act+'</td>\n' +
                        '</tr>';
                }
            }

            $('#marketing_logs_table_span').html(table+tableheader+dataa+ '</table>');
            // console.log(data);
        },
        complete: function()
        {
            $('.stylethis').css('background-color', 'black');
            $('.stylethis').css('color', 'white');
        }
    });
});


$('#edit_rate_bi').click(function()
{
    $(this).hide();
    $('#cancel_bi_rate_edit').fadeIn();
    $('#btn_rate_edit').fadeIn();
    $('#editted_amount').attr('disabled', false);
});

$('#cancel_bi_rate_edit').click(function()
{
    $(this).hide();
    $('#edit_rate_bi').fadeIn();
    $('#btn_rate_edit').fadeOut();
    $('#editted_amount').attr('disabled', true);
});

$('#btn_rate_edit').click(function()
{
    var btn = $(this);
    var amount_to_edit = $('#editted_amount').val();
    var typee = $(this).attr('typee');

    if(amount_to_edit == '')
    {
        alert('Enter editted amount');
    }
    else
    {
        btn.attr('disabled', true);
        if(typee == 'rate')
        {
            if(confirm('Are you sure to submit?'))
            {
                $('#modal-update-bi-rate').modal('hide');
                // console.log(amount_to_edit);
                $.ajax(
                    {
                        type : 'get',
                        url : 'marketing_update_bi_rates',
                        data : {
                            'id' : bi_rate_id,
                            'amount' : amount_to_edit,
                            'type' : typee
                        },
                        beforeSend: function()
                        {
                            $('#modal-loading').modal('show');
                        },
                        success : function(data)
                        {
                            console.log(data);
                        },
                        complete: function()
                        {
                            bi_rates_table.ajax.reload(null, false);
                            $('#modal-loading').modal('hide');
                            $('#modal-success-loading').modal('show');
                            btn.attr('disabled', false);

                            setTimeout(function()
                            {
                                $('#modal-success-loading').modal('hide');
                            }, 2000);
                        }
                    }
                );
            }
            else
            {
                btn.attr('disabled', false);
            }
        }
        else if(typee == 'ocular')
        {
            if(confirm('Are you sure to submit?'))
            {
                $('#modal-update-bi-rate').modal('hide');
                // console.log(amount_to_edit);
                $.ajax(
                    {
                        type : 'get',
                        url : 'marketing_update_bi_rates',
                        data : {
                            'id' : bi_id_ocular,
                            'amount' : amount_to_edit,
                            'type' : typee
                        },
                        beforeSend: function()
                        {
                            $('#modal-loading').modal('show');
                        },
                        success : function(data)
                        {
                            console.log(data);
                        },
                        complete: function()
                        {
                            bi_ocular_table.ajax.reload(null, false);
                            $('#modal-loading').modal('hide');
                            $('#modal-success-loading').modal('show');
                            btn.attr('disabled', false);

                            setTimeout(function()
                            {
                                $('#modal-success-loading').modal('hide');
                            }, 2000);
                        }
                    }
                );
            }
            else
            {
                btn.attr('disabled', false);
            }
        }
        else if(typee == 'bank_rate')
        {
            if(confirm('Are you sure to submit?'))
            {
                $('#modal-update-bi-rate').modal('hide');
                // console.log(amount_to_edit);
                $.ajax(
                    {
                        type : 'get',
                        url : 'marketing_update_bi_rates',
                        data : {
                            'id' : bank_id_rate,
                            'amount' : amount_to_edit,
                            'type' : typee
                        },
                        beforeSend: function()
                        {
                            $('#modal-loading').modal('show');
                        },
                        success : function(data)
                        {
                            console.log(data);
                        },
                        complete: function()
                        {
                            tableManage.ajax.reload(null, false);
                            $('#modal-loading').modal('hide');
                            $('#modal-success-loading').modal('show');
                            btn.attr('disabled', false);

                            setTimeout(function()
                            {
                                $('#modal-success-loading').modal('hide');
                            }, 2000);
                        }
                    }
                );
            }
            else
            {
                btn.attr('disabled', false);
            }
        }
        else if(typee == 'rate_alacarte')
        {
            if(confirm('Are you sure to submit?'))
            {
                $('#modal-update-bi-rate').modal('hide');
                // console.log(amount_to_edit);
                $.ajax(
                    {
                        type : 'get',
                        url : 'marketing_update_bi_rates',
                        data : {
                            'id' : bi_rate_id_alacarte,
                            'amount' : amount_to_edit,
                            'type' : typee
                        },
                        beforeSend: function()
                        {
                            $('#modal-loading').modal('show');
                        },
                        success : function(data)
                        {
                            console.log(data);
                        },
                        complete: function()
                        {
                            bi_rate_alacarte.draw();
                            $('#modal-loading').modal('hide');
                            $('#modal-success-loading').modal('show');
                            btn.attr('disabled', false);

                            setTimeout(function()
                            {
                                $('#modal-success-loading').modal('hide');
                            }, 2000);
                        }
                    }
                );
            }
            else
            {
                btn.attr('disabled', false);
            }
        }
    }
});

$('#bi_rates_muni').autocomplete
({
    source: '/fetch-city-muni',
    minLength: 1,
    select: function(event, ui)
    {
        $('#bi_rates_muni_id').val(ui.item.muniID);
        $('#bi_rates_origMun_id').val(ui.item.muniID);
    }
});

$('#bi_rates_muni').focusout(function () {
    if($('#bi_rates_muni').val() === '')
    {
        $('#bi_rates_origMun').val('');
        $('#bi_rates_muni_id').val('');
        $('#bi_rates_origMun_id').val('');
    }
    else{
        $.ajax
        ({
            method: 'get',
            url: '/fetch-city-muniv2',
            data:
                {
                    'muniname' : $('#bi_rates_muni').val()
                },
            success: function (data)
            {
                console.log(data[0].id);
                $('#bi_rates_muni_id').val(data[0].province_id);
                $('#bi_rates_origMun_id').val(data[0].id);
                fetchProv3();
                setTimeout(function ()
                {
                    $('#bi_rates_muni').val(data[0].muni_name);
                },1000);
            }
        });
    }
});

function fetchProv3()
{
    muniID = $('#bi_rates_muni_id').val();
    originalMuniID = $('#bi_rates_origMun_id').val();
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
            $('#bi_rates_origMun').val(data[0][0].name);
        }
    });
}

$('#bi_rates_mun_prov').change(function()
{
    var type = $(this).val();
    $('#bi_rates_muni').val('');
    $('#bi_rates_origMun').val('');
    $('#bi_rates_prov').val('-').trigger('change');

    if(type == 'Municipality')
    {
        $('#show_bi_tab2_muni').fadeIn();
        $('#bi_addrate_amount_tab2_span').fadeIn();
        $('#show_bi_tab2_prov').fadeOut();
        what_type = 'municipality';

    }
    else if(type == 'Province')
    {
        $('#show_bi_tab2_prov').fadeIn();
        $('#bi_addrate_amount_tab2_span').fadeIn();
        $('#show_bi_tab2_muni').fadeOut();
        what_type = 'province';
    }
    else if(type == '-')
    {
        $('#show_bi_tab2_prov').fadeOut();
        $('#show_bi_tab2_muni').fadeOut();
        $('#bi_addrate_amount_tab2_span').fadeOut();
        what_type = '';
    }
});

$('.bi_rates_tabs').click(function()
{
    var gethref = $(this).attr('href');

    // console.log(gethref);

    if(gethref == '#bi_rates_tab1')
    {
        if ($('' + gethref + '').hasClass('active'))
        {
            console.log('do nothing');
            bi_rate_tabs = 'bi_rates_tab1';
        }
        else if (bi_rates_tab1)
        {
            console.log('already loaded');
            bi_rate_tabs = 'bi_rates_tab1';

        }
        else if (bi_rates_tab1 == false)
        {
            bi_rates_tab1 = true;
            bi_rate_tabs = 'bi_rates_tab1';
            bi_rate_table();
        }
    }
    else if(gethref == '#bi_rates_tab2')
    {
        if ($('' + gethref + '').hasClass('active'))
        {
            console.log('do nothing');
            bi_rate_tabs = 'bi_rates_tab2';
        }
        else if (bi_rates_tab1)
        {
            console.log('already loaded');
            bi_rate_tabs = 'bi_rates_tab2';

        }
        else if (bi_rates_tab1 == false)
        {
            bi_rates_tab2 = true;
            bi_rate_tabs = 'bi_rates_tab2';
            bi_ocular_rate_table();
        }
    }
});

$('#add_bi_rate_tab_2').click(function()
{
    var btn = $(this);
    var bi_id = $('#bi_rates_client_name_tab2').val();
    var mun_orig_municipal_id = $('#bi_rates_origMun_id').val();
    var mun_prov_id = $('#bi_rates_muni_id').val();
    var prov_prov_id = $('#bi_rates_prov').val();
    var inserted_amount = $('#bi_addrate_amount_tab2').val();


    if(bi_id != '-')
    {
        btn.attr('disabled', true);
        if(what_type == 'municipality')
        {
            if(inserted_amount != '')
            {
                $.ajax(
                    {
                        type: 'get',
                        url: 'marketing_add_rate_to_bi_tab2',
                        data: {
                            'type': what_type,
                            'id' : bi_id,
                            'mun_id' : mun_orig_municipal_id,
                            'prov_id' : mun_prov_id,
                            'entered_amount' : inserted_amount
                        },
                        beforeSend: function()
                        {
                            $('#modal-loading').modal('show');
                        },
                        success : function(data)
                        {
                            // console.log(data);
                            if(data == 'already')
                            {
                                $('#modal-loading').modal('hide');

                                alert('Rate is already added check table to update the rate');
                            }
                            else
                            {
                                $('#modal-loading').modal('hide');
                                bi_ocular_table.ajax.reload(null, false);
                                $('#modal-success-loading').modal('show');

                                setTimeout(function()
                                {
                                    $('#modal-success-loading').modal('hide');
                                }, 1000);
                            }
                        },
                        complete: function ()
                        {
                            btn.attr('disabled', false);
                        }
                    }
                );
            }
            else
            {
                $('#bi_addrate_amount_tab2').css('border-style', 'solid');
                $('#bi_addrate_amount_tab2').css('border-color', 'red');

                if($('#bi_rates_muni').val() == '')
                {
                    $('#bi_rates_muni').css('border-style', 'solid');
                    $('#bi_rates_muni').css('border-color', 'red');
                }

                setTimeout(function()
                {
                    $('#bi_addrate_amount_tab2').css('border-color', '#989292');
                    $('#bi_rates_muni').css('border-color', '#989292');
                }, 2000);

                alert('Fill-out the required fields');
                btn.attr('disabled', false);
            }

        }
        else if(what_type == 'province')
        {

            if(inserted_amount != '')
            {
                $.ajax(
                    {
                        type: 'get',
                        url: 'marketing_add_rate_to_bi_tab2',
                        data: {
                            'type': what_type,
                            'id' : bi_id,
                            'prov_id' : prov_prov_id,
                            'entered_amount' : inserted_amount
                        },
                        beforeSend: function()
                        {
                            $('#modal-loading').modal('show');
                        },
                        success : function(data)
                        {
                            // console.log(data);
                            if(data == 'already')
                            {
                                $('#modal-loading').modal('hide');

                                alert('Rate is already added check table to update the rate');
                            }
                            else
                            {
                                $('#modal-loading').modal('hide');
                                bi_ocular_table.ajax.reload(null, false);
                                $('#modal-success-loading').modal('show');

                                setTimeout(function()
                                {
                                    $('#modal-success-loading').modal('hide');
                                }, 1000);
                            }
                        },
                        complete: function ()
                        {
                            btn.attr('disabled', false);
                        }
                    }
                );
            }
            else
            {
                $('#bi_addrate_amount_tab2').css('border-style', 'solid');
                $('#bi_addrate_amount_tab2').css('border-color', 'red');

                setTimeout(function()
                {
                    $('#bi_addrate_amount_tab2').css('border-color', '#989292');
                }, 2000);

                alert('Fill-out the required fields');
                alert('Fill-out the required fields');
                btn.attr('disabled', false);
            }

        }
    }
    else
    {
        alert('Select B.I. Client');
        btn.attr('disabled', false);
    }
});

function bi_ocular_rate_table()
{
    bi_ocular_table = $('#bi_rate_per_area_table').DataTable
    ({
        "responsive" : true,
        "processing" : true,
        "serverSide" : true,
        "ajax" : 'marketing_bi_rate_table_ocular',
        "columns":
            [
                {data: 'id', name: 'bi_rates_ocular.id'},
                {data: 'muni', name: 'municipalities.muni_name'},
                {data: 'prov', name: 'provinces.name'},
                {data: 'client_name', name: 'bi_account_list.bi_account_name'},
                {
                    data: function(data)
                    {
                        return 'PHP '+ data.rate;
                    },
                    name : 'bi_rates_ocular.rate'
                },
                {data : 'created_at', name : 'bi_rates_ocular.created_at', 'searchable' : false, 'orderable' : false},
                {
                    data: function(data)
                    {
                        return '<button class="btn btn-xs btn-info btn-block bi_rates_update_ocular" id="'+data.id+'" rate="'+data.rate+'" what="ocular">Update</button>' +
                            '<button class="btn btn-xs btn-primary btn-block bi_rates_log_ocular" id="'+data.id+'">View Logs</button>';
                    },
                    'name' : 'bi_rates_ocular.id',
                    'searchable' : false,
                    'orderable' : false,
                    "width": '10%'
                }
            ],
        "order" :[[0, 'desc']],
        "pageLength" : 10,
        "lengthMenu" : [[2, 10, 25, 50, -1], ['2 rows', '10 rows', '25 rows', '50 rows', 'Show all']]
    });

    $('#bi_rate_per_area_table_filter input').unbind();
    $('#bi_rate_per_area_table_filter input').bind('keyup change', function(e)
    {
        if($(this).is(':focus'))
        {
            if (e.keyCode === 13) {
                bi_ocular_table.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '') {
                    bi_ocular_table.search($(this).val()).draw();
                }
            }
        }
    });
}

$('#bi_rate_per_area_table').on('click', '.bi_rates_log_ocular', function()
{
    var id = $(this).attr('id');
    $('#modal-update-bi-logs').modal('show');
    // console.log(id);
    $('#marketing_logs_table').html('');

    $.ajax({
        type: 'get',
        url: 'marketing_get_logs',
        data: {
            'id' : id,
            'type' : 'bi_rates_ocular'
        },
        success: function(data)
        {
            var table = '<table class="table-condensed table-hover" id="marketing_logs_table" width="100%">';
            var tableheader = '<tr class="stylethis"><td colspan="3"><b>LOGS</b></td></tr>' +
                '<tr>\n' +
                '<th>NAME</th>\n' +
                '<th>DATE/TIME OCCURED</th>\n' +
                '<th>ACTIVITY/LOGS</th>\n' +
                '</tr>';
            var dataa = '';


            if(data == '')
            {
                dataa += '<tr><td colspan="3">NO AVAILABLE RECORDS</td></tr>';
            }
            else
            {
                for(var i = 0; i < data[0].length; i++)
                {
                    dataa += '<tr>\n' +
                        '<td>'+data[0][i].name+'</td>\n' +
                        '<td>'+data[0][i].created_at+'</td>\n' +
                        '<td>'+data[0][i].act+'</td>\n' +
                        '</tr>';
                }
            }

            $('#marketing_logs_table_span').html(table+tableheader+dataa+ '</table>');
            console.log(data);
        },
        complete: function()
        {
            $('.stylethis').css('background-color', 'black');
            $('.stylethis').css('color', 'white');
        }
    });
});

$('#bi_rate_per_area_table').on('click', '.bi_rates_update_ocular', function()
{
    bi_id_ocular = $(this).attr('id');
    $('#edit_rate_bi').show();
    $('#cancel_bi_rate_edit').hide();
    $('#btn_rate_edit').hide();
    $('#modal-update-bi-rate').modal('show');
    $('#editted_amount').val($(this).attr('rate')).attr('disabled', true);
    $('#btn_rate_edit').attr('typee', $(this).attr('what'));
});

$('#marketing-manage').on('click', '.update_rate_bank', function()
{
    var id = $(this).attr('id');
    $('#modal-update-bi-logs').modal('show');
    // console.log(id);
    $('#marketing_logs_table').html('');

    $.ajax({
        type: 'get',
        url: 'marketing_get_logs',
        data: {
            'id' : id,
            'type' : 'bank_rate'
        },
        success: function(data)
        {
            var table = '<table class="table-condensed table-hover" id="marketing_logs_table" width="100%">';
            var tableheader = '<tr>\n' +
                '<th>NAME</th>\n' +
                '<th>DATE/TIME OCCURED</th>\n' +
                '<th>ACTIVITY/LOGS</th>\n' +
                '</tr>';
            var dataa = '';


            if(data == '')
            {
                dataa += '<tr><td colspan="3">NO AVAILABLE RECORDS</td></tr>';
            }
            else
            {
                for(var i = 0; i < data[0].length; i++)
                {
                    dataa += '<tr>\n' +
                        '<td>'+data[0][i].name+'</td>\n' +
                        '<td>'+data[0][i].created_at+'</td>\n' +
                        '<td>'+data[0][i].act+'</td>\n' +
                        '</tr>';
                }
            }

            $('#marketing_logs_table_span').html(table+tableheader+dataa+ '</table>');
            // console.log(data);
        }
    });
});

function marketing_all_logs_table()
{
    $('#marketing_logsTable thead tr th').each(function()
    {
        $(this).css('background-color', 'black');
        $(this).css('color', 'white');
    });

    marketing_logs_table = $('#marketing_logsTable').DataTable
    ({
        "responsive" : true,
        "processing" : true,
        "serverSide" : true,
        "ajax" : 'marketing_all_logs_table',
        "columns":
            [
                {data: 'id', name: 'marketing_logs.id'},
                {data: 'name', name: 'users.name'},
                {data: 'act', name: 'marketing_logs.activity'},
                {data: 'date_time', name: 'marketing_logs.created_at'},
                {data: 'type', name: 'marketing_logs.type'}
            ],
        "order" :[[0, 'desc']],
        "pageLength" : 10,
        "lengthMenu" : [[2, 10, 25, 50, -1], ['2 rows', '10 rows', '25 rows', '50 rows', 'Show all']]
    });

    $('#marketing_logsTable_filter input').unbind();
    $('#marketing_logsTable_filter input').bind('keyup change', function(e)
    {
        if($(this).is(':focus'))
        {
            if (e.keyCode === 13) {
                marketing_logs_table.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '') {
                    marketing_logs_table.search($(this).val()).draw();
                }
            }
        }
    });
}

$('#marketing-manage').on('click', '.update_rate_bank_edit', function()
{
    bank_id_rate = $(this).val();
    $('#modal-update-bi-rate').modal('show');
    $('#editted_amount').val($(this).attr('rate')).attr('disabled', true);
    $('#btn_rate_edit').attr('typee', $(this).attr('what'));
    $('#edit_rate_bi').show();
    $('#cancel_bi_rate_edit').hide();
    $('#btn_rate_edit').hide();
});

$('#bi_rates_client_name_tab2').change(function()
{
    var thisVal = $(this).val();

    if(thisVal == '-')
    {
        $('#bi_rates_mun_prov').val('-').trigger('change');
    }
});

var bi_rate_alacarte;


function bi_rate_table_alacarte()
{
    bi_rate_alacarte = $('#bi_rate_table_alacarte').DataTable
    ({
        "responsive" : true,
        "processing" : true,
        "serverSide" : true,
        "ajax" : 'marketing_bi_rate_table_alacarte',
        "columns":
            [
                {data: 'id', name: 'bi_rates_alacarte.id'},
                {data: 'checking', name: 'checking_list.checking'},
                {data: 'client_name', name: 'bi_account_list.bi_account_name'},
                {data : 'ocular', name : 'bi_rates_alacarte.ocular'},
                {
                    data:function rates(data)
                    {
                        return 'PHP ' + data.rates;
                    },
                    name : 'bi_rates_alacarte.rate'
                },
                {data : 'date_time', name : 'bi_rates_alacarte.id'},
                {
                    data: function action(data)
                    {

                        return '<button class="btn btn-xs btn-info btn-block btn_update_alacarte" id="'+data.id+'" rate="'+data.rates+'" what="rate_alacarte" data-toggle="modal" data-target="#modal-update-bi-rate">Updpate</button>' +
                            '<button class="btn btn-xs btn-primary btn-block bi_rates_log" id="'+btoa(btoa(data.id))+'">View Logs</button>';
                    },
                    'name' : 'bi_rates_alacarte.id',
                    'searchable' : false,
                    'orderable' : false,
                    "width": '10%'
                }
            ],
        "order" :[[0, 'desc']],
        "pageLength" : 10,
        "lengthMenu" : [[2, 10, 25, 50, -1], ['2 rows', '10 rows', '25 rows', '50 rows', 'Show all']]
    });

    $('#bi_rate_table_alacarte_filter input').unbind();
    $('#bi_rate_table_alacarte_filter input').bind('keyup change', function(e)
    {
        if($(this).is(':focus'))
        {
            if (e.keyCode === 13) {
                bi_rate_alacarte.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '') {
                    bi_rate_alacarte.search($(this).val()).draw();
                }
            }
        }
    });
}

var bi_rates_active_tab ='add_to_package';
var add_to_package = true;
var add_to_alacarte = false;


$('.bi_rates_tab').click(function()
{
    var gethref = $(this).attr('href');

    if(gethref == '#add_to_package')
    {
        if($(''+gethref+'').hasClass('active'))
        {
            console.log('do nothing');
        }
        else if(add_to_package)
        {
            console.log('already loaded');
            bi_rates_active_tab = 'add_to_package';
        }
        else if(!add_to_package)
        {
            bi_rates_active_tab = 'add_to_package';
            add_to_package = true;
        }
    }

    if(gethref == '#add_to_alacarte')
    {
        if($(''+gethref+'').hasClass('active'))
        {
            console.log('do nothing');
        }
        else if(add_to_alacarte)
        {
            console.log('already loaded');
            bi_rates_active_tab = 'add_to_alacarte';
        }
        else if(!add_to_alacarte)
        {
            bi_rates_active_tab = 'add_to_alacarte';
            add_to_alacarte = true;
            bi_rate_table_alacarte();
        }
    }
});

$('#add_bi_rate_alacarte').click(function()
{
    var client_id = $('#bi_rates_client_name_alacarte').children("option:selected").val();
    var checking_id = $('#bi_rates_packagename_alacarte').children("option:selected").val();
    var ocular_bool = $('#bi_rates_ocular_alacarte').children("option:selected").val();
    var inserted_alacarte_value = $("#bi_addrate_amount_alacarte").val();
    var ready_to_add = false;

    $('.validateSelectInput').each(function()
    {
        if($(this).val() == '-')
        {
            alert('required field');
            ready_to_add = false;
            return false;
        }
        ready_to_add = true;
    });

    if(ready_to_add)
    {
        if(inserted_alacarte_value == '')
        {
            alert('Add amount');
        }
        else
        {
            $.ajax({
                type: 'get',
                url: 'bi_rate_add_alacarte',
                data: {
                    'client_id' : client_id,
                    'checking_id' : checking_id,
                    'ocular_bool' : ocular_bool,
                    'rate' : inserted_alacarte_value
                },
                success: function(data)
                {
                    console.log(data);
                    if(data == 'double')
                    {
                        alert('Rates is already added check the table to update');
                    }
                    else if(data == 'ok')
                    {
                        alert('Rate Successfully added');
                        bi_rate_alacarte.draw();
                    }
                },
                error: function()
                {
                    alert('error');
                }
            });
        }
    }
});

$('#bi_rate_table_alacarte').on('click', '.bi_rates_log', function()
{
    var id = atob(atob($(this).attr('id')));
    $('#modal-update-bi-logs').modal('show');
    console.log(id);
    $('#marketing_logs_table').html('');

    $.ajax({
        type: 'get',
        url: 'marketing_get_logs',
        data: {
            'id' : id,
            'type' : 'bi_rates_alacarte'
        },
        success: function(data)
        {
            var table = '<table class="table-condensed table-hover" id="marketing_logs_table" width="100%">';
            var tableheader = '<tr class="stylethis"><td colspan="3"><b>LOGS</b></td></tr>' +
                '<tr>\n' +
                '<th>NAME</th>\n' +
                '<th>DATE/TIME OCCURED</th>\n' +
                '<th>ACTIVITY/LOGS</th>\n' +
                '</tr>';
            var dataa = '';


            if(data == '')
            {
                dataa += '<tr><td colspan="3">NO AVAILABLE RECORDS</td></tr>';
            }
            else
            {
                for(var i = 0; i < data[0].length; i++)
                {
                    dataa += '<tr>\n' +
                        '<td>'+data[0][i].name+'</td>\n' +
                        '<td>'+data[0][i].created_at+'</td>\n' +
                        '<td>'+data[0][i].act+'</td>\n' +
                        '</tr>';
                }
            }

            $('#marketing_logs_table_span').html(table+tableheader+dataa+ '</table>');
            // console.log(data);
        },
        complete: function()
        {
            $('.stylethis').css('background-color', 'black');
            $('.stylethis').css('color', 'white');
        }
    });
});

$('#bi_rate_table_alacarte').on('click', '.btn_update_alacarte', function()
{
    bi_rate_id_alacarte = $(this).attr('id');
    $('#btn_rate_edit').hide();
    $('#edit_rate_bi').show();
    $('#cancel_bi_rate_edit').hide();
    $('#editted_amount').val($(this).attr('rate')).attr('disabled', true);
    $('#btn_rate_edit').attr('typee', $(this).attr('what'));
});