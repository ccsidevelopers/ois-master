

$(document).ready(function () {


});

function fund_manage_init()
{
    var template = Handlebars.compile($("#details-template-pending-sao").html());

    $('#table_fund_req thead th').each(function ()
    {
        tableFund1[fund_1] = $(this).text();
        fund_1++;
        title = $(this).text();
        $(this).html(title + '<br><input type="text" placeholder="Search" style="position: relative; width: 100%">');
    });

    table_ci_fund = $('#table_fund_req').DataTable(
        {

            "responsive": true,
            "processing": true,
            "serverSide": true,
            "ajax": "/management-get-ci-fund-table",
            "columns":
                [
                    {data: 'id', name: 'fund_requests.id'}, //req id
                    {
                        "className":      'details-control-accounts',
                        "orderable":      false,
                        "searchable":      false,
                        "data":           null,
                        "defaultContent": ''
                    }, // show req
                    {
                        data : function req_date(data)
                        {
                            if(data.tor == 'NORMAL REQUEST')
                            {
                                return data.disp_date;
                            }
                            else if(data.tor == 'EMERGENCY FUND')
                            {
                                if(data.sao_req == null)
                                {
                                    return data.sao_date;

                                }
                                else
                                {
                                    return data.sao_req
                                }
                            }
                            else
                            {
                                return data.sao_date;
                            }
                        },
                        "searchable" : false,
                        "orderable" : false
                    }, //req date time
                    {
                        data : function name(data)
                        {
                            if(data.tor == 'NORMAL REQUEST')
                            {
                                return data.name_disp;
                            }
                            else if(data.tor == 'EMERGENCY FUND')
                            {
                                if(data.sao_req == null)
                                {
                                    return data.name_disp;

                                }
                                else
                                {
                                    return data.name_sao
                                }
                            }
                            else
                            {
                                return '';
                            }
                        },
                        "searchable" : false,
                        "orderable" : false

                    }, // requestor
                    {data: 'name_ci', name: 'ci_id.name'},
                    {
                        data: function tor (data) {
                            return data.tor;
                        },
                        "name": 'fund_requests.type_of_fund_request'
                    },
                    {
                        data: function test(data) {
                            return "Php " + atob(data.amount)
                        },
                        "name": 'fund_requests.fund_amount',
                        "searchable" : false
                    },
                    {data: 'count', name: 'fund_requests.id'}, //req id
                    {
                        data: function actions(data)
                        {
                            var nameRem = '';

                            if(data.tor == 'NORMAL REQUEST')
                            {
                                nameRem = data.disp_rem;
                            }
                            else if(data.tor == 'EMERGENCY FUND')
                            {
                                nameRem = data.remarks;
                            }

                            return '  <button href="' + data.id + '" class="btn btn-xs btn-info btn-block" data-toggle="modal" id="BtnApproved" style="width: 100%" name = "'+data.amount+'">APPROVE REQUEST</button>' +
                                '<button href="' + data.id + '" class="btn btn-xs btn-warning btn-block" data-toggle="modal" id="BtnDeclined" style="width: 100%">DISAPPROVE REQUEST</button>' +
                                '<button class = "btnViewReqRem btn btn-xs btn-primary btn-block" style = "width : 100%" name = "'+nameRem+'">VIEW REQUESTOR REMARKS</button>';

                        },
                        "orderable": false,
                        "searchable": false,
                        "name": 'action'
                    }
                ],
            "fnRowCallback": function (nRow, aData)
            {
                var newAmt = parseInt(atob(aData.amount));

                if(aData.tor == 'EMERGENCY FUND')
                {
                    $('td', nRow).show();
                }
                else if(aData.tor == 'NORMAL REQUEST')
                {
                    if (newAmt <= 2500 ) {
                        $('td', nRow).remove();
                    }
                    else if (newAmt > 2500) {
                        $('td', nRow).show();
                    }
                }
            },
            "order": [[0, 'desc']],
            "pageLength": -1,
            "lengthMenu": [[2, 10, 25, 50, -1], ['2 rows', '10 rows', '25 rows', '50 rows', 'Show all']],
            "bSortClasses": false,
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

    $('#table_fund_req_filter input').unbind();
    $('#table_fund_req_filter input').bind('keyup change', function (e) {

        if ($(this).is(':focus')) {
            if (e.keyCode == 13) {
                table_ci_fund.search($(this).val()).draw();
            }
            else if (e.keyCode === 8) {
                if ($(this).val() == '') {
                    table_ci_fund.search($(this).val()).draw();
                }
            }
        }
    });


    // Add event listener for opening and closing details
    $('#table_fund_req tbody').on('click', 'td.details-control-accounts', function () {
        var tr = $(this).closest('tr');
        var row = table_ci_fund.row(tr);
        var tableId = 'sao_pending_posts-' + row.data().id;

        if (row.child.isShown()) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        } else {
            // Open this row
            row.child(template(row.data())).show();
            initTable_pending(tableId, row.data());
            tr.addClass('shown');
            // tr.next().find('td').addClass('no-padding bg-white');
        }
    });

    function initTable_pending(tableId, data) {
        $('#' + tableId).DataTable({
            processing: true,
            serverSide: true,
            order: [[0, 'desc']],
            // ajax: 'pending_fund_details_endorsements',
            ajax:
                {
                    url: "/sao_pending_fund_details_endorsements",
                    data: function (e) {
                        e.id = data.id
                    }
                },
            columns: [

                {data: 'id', name: 'endorsements.id'},
                {data: 'name', name: 'endorsements.account_name'},
                {data: 'address', name: 'endorsements.address'},
                {data: 'city_muni', name: 'municipalities.muni_name'},
                {data: 'provinces', name: 'endorsements.provinces'},
                {data: 'tor', name: 'endorsements.type_of_request'},
                {data: 'date', name: 'endorsements.date_endorsed'}
            ]
        })
    }
}

function app_table()
{
    var template_app = Handlebars.compile($("#details-template-app-sao").html());

    $('#table_fund_req_approved thead th').each(function ()
    {
        tableFund2[fund_2] = $(this).text();
        fund_2++;
        title = $(this).text();
        $(this).html(title + '<br><input type="text" placeholder="Search" style="position: relative; width: 100%">');
    });

    table_ci_fund_app = $('#table_fund_req_approved').DataTable
    (
        {

            "responsive": true,
            "processing": true,
            "serverSide": true,
            "ajax": "/management-get-ci-fund-table-approved",
            "columns":
                [
                    {data: 'id', name: 'fund_requests.id'}, //req id
                    {
                        "className":      'details-control-accounts',
                        "orderable":      false,
                        "searchable":      false,
                        "data":           null,
                        "defaultContent": ''
                    }, // show req
                    {
                        data : function req_date(data)
                        {
                            if(data.tor == 'NORMAL REQUEST')
                            {
                                return data.disp_date;
                            }
                            else if(data.tor == 'EMERGENCY FUND')
                            {
                                if(data.sao_req == null)
                                {
                                    return data.sao_date;

                                }
                                else
                                {
                                    return data.sao_req
                                }
                            }
                            else
                            {
                                return data.sao_date;
                            }
                        },
                        "searchable" : false,
                        "orderable" : false
                    }, //req date time
                    {
                        data : function req_date(data)
                        {
                            if(data.tor == 'NORMAL REQUEST')
                            {
                                return data.name_disp;
                            }
                            else if(data.tor == 'EMERGENCY FUND')
                            {
                                if(data.sao_req == null)
                                {
                                    return data.sao_name;

                                }
                                else
                                {
                                    return data.sao_name
                                }
                            }
                            else
                            {
                                return data.name_disp;
                            }
                        },
                        "searchable" : false,
                        "orderable" : false
                    },
                    // {data : 'sao_name', name: 'users.name'}, // requestor
                    {data: 'name_ci', name: 'ci_id.name'},
                    {
                        data: function (data) {
                            return data.tor;
                        },
                        "name": 'fund_requests.type_of_fund_request'
                    },
                    {
                        data: function (data) {
                            return "Php " + atob(data.amount)
                        },
                        "name": 'fund_requests.fund_amount'
                    },
                    {data: 'count', name: 'fund_requests.id',"searchable" : false,"orderable" : false}, //req id
                    {
                        data: function actions(data)
                        {
                            var nameRem = '';

                            if(data.tor == 'NORMAL REQUEST')
                            {
                                nameRem = data.disp_rem;
                            }
                            else if(data.tor == 'EMERGENCY FUND')
                            {
                                nameRem = data.remarks;
                            }
                            return '<a href="' + data.id + '" class="btn btn-xs btn-success btn-block" data-toggle="modal" id="" style="width: 100%; cursor: default;">APPROVED REQUEST</a>' +
                                '<button class = "btnViewReqRem btn btn-xs btn-primary btn-block" style = "width : 100%" name = "'+nameRem+'">VIEW REQUESTOR REMARKS</button>';

                        },
                        "orderable": false,
                        "searchable": false,
                        "name": 'action'
                    }

                ],
            // "fnRowCallback": function( nRow, aData)
            // {
            //     var newAmt = parseInt(atob(aData.amount));
            //     if(aData.tor == 'EMERGENCY FUND')
            //     {
            //         $('td', nRow).show();
            //     }
            //     else if(aData.tor == 'NORMAL REQUEST')
            //     {
            //         if (newAmt <= 2500 ) {
            //             $('td', nRow).remove();
            //         }
            //         else if (newAmt > 2500) {
            //             $('td', nRow).show();
            //         }
            //     }
            // },
            "order": [[0, 'desc']],
            "pageLength": 10,
            "lengthMenu": [[10, 25, 50, -1], ['10 rows', '25 rows', '50 rows', 'Show all']],
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

    $('#table_fund_req_approved_filter input').unbind();
    $('#table_fund_req_approved_filter input').bind('keyup change',function (e) {

        if($(this).is(':focus'))
        {
            if (e.keyCode == 13) {
                table_ci_fund_app.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '') {
                    table_ci_fund_app.search($(this).val()).draw();
                }
            }
        }
    });


    // Add event listener for opening and closing details
    $('#table_fund_req_approved tbody').on('click', 'td.details-control-accounts', function () {
        var tr = $(this).closest('tr');
        var row = table_ci_fund_app.row(tr);
        var tableId = 'sao_app_posts-' + row.data().id;

        if (row.child.isShown()) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        } else {
            // Open this row
            row.child(template_app(row.data())).show();
            initTable_app(tableId, row.data());
            tr.addClass('shown');
            // tr.next().find('td').addClass('no-padding bg-white');
        }
    });

    function initTable_app(tableId, data) {
        $('#' + tableId).DataTable({
            processing: true,
            serverSide: true,
            order: [[0, 'desc']],
            // ajax: 'pending_fund_details_endorsements',
            ajax:
                {
                    url: "/sao_app_fund_details_endorsements",
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
}

function dec_table()
{
    var template_dec = Handlebars.compile($("#details-template-dec-sao").html());

    $('#table_fund_req_declined thead th').each(function ()
    {
        tableFund3[fund_3] = $(this).text();
        fund_3++;
        title = $(this).text();
        $(this).html(title + '<br><input type="text" placeholder="Search" style="position: relative; width: 100%">');
    });

    table_ci_fund_dec = $('#table_fund_req_declined').DataTable
    (
        {
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "ajax": "/management-get-ci-fund-table-declined",
            "columns":
                [
                    {data: 'id', name: 'fund_requests.id'}, //req id
                    {
                        "className":      'details-control-accounts',
                        "orderable":      false,
                        "searchable":      false,
                        "data":           null,
                        "defaultContent": ''
                    }, // show req
                    {
                        data : function req_date(data)
                        {
                            if(data.tor == 'NORMAL REQUEST')
                            {
                                return data.disp_date;
                            }
                            else if(data.tor == 'EMERGENCY FUND')
                            {
                                if(data.sao_req == null)
                                {
                                    return data.sao_date;

                                }
                                else
                                {
                                    return data.sao_req
                                }
                            }
                            else
                            {
                                return data.sao_date;
                            }
                        },
                        "searchable" : false,
                        "orderable" : false
                    }, //req date time
                    {
                        data : function name(data)
                        {
                            if(data.tor == 'NORMAL REQUEST')
                            {
                                return data.name_disp;
                            }
                            else if(data.tor == 'EMERGENCY FUND')
                            {
                                return data.name_sao;
                            }
                            else
                            {
                                return data.name_disp + data.name_sao;;
                            }
                        },
                        "searchable" : false,
                        "orderable" : false

                    }, // requestor
                    {data: 'name_ci', name: 'ci_id.name'},
                    {
                        data: function (data) {
                            return data.tor;
                        },
                        "name": 'fund_requests.type_of_fund_request'
                    },
                    {
                        data: function (data) {
                            return "Php " + atob(data.amount)
                        },
                        "name": 'fund_requests.fund_amount'
                    },
                    {data: 'count', name: 'fund_requests.id'},
                    {
                        data: function actions(data)
                        {
                            var nameRem = '';

                            if(data.tor == 'NORMAL REQUEST')
                            {
                                nameRem = data.disp_rem;
                            }
                            else if(data.tor == 'EMERGENCY FUND')
                            {
                                nameRem = data.remarks;
                            }

                            return '<a href="' + data.id + '" class="btn btn-xs btn-warning btn-block" data-toggle="modal" id="" style="width: 100%">DISAPPROVED REQUEST</a>' +
                                '<button class = "btnViewReqRem btn btn-xs btn-primary btn-block" style = "width : 100%" name = "'+nameRem+'">VIEW REQUESTOR REMARKS</button>';

                        },
                        "orderable": false,
                        "searchable": false,
                        "name": 'action'
                    }

                ],
            "fnRowCallback": function( nRow, aData)
            {
                var newAmt = parseInt(atob(aData.amount));
                if(aData.tor == 'EMERGENCY FUND')
                {
                    $('td', nRow).show();
                }
                else if(aData.tor == 'NORMAL REQUEST')
                {
                    if (newAmt <= 2500 ) {
                        $('td', nRow).remove();
                    }
                    else if (newAmt > 2500) {
                        $('td', nRow).show();
                    }
                }
            },
            "order": [[0, 'desc']],
            "pageLength": -1,
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

    $('#table_fund_req_declined_filter input').unbind();
    $('#table_fund_req_declined_filter input').bind('keyup change',function (e) {

        if($(this).is(':focus'))
        {
            if (e.keyCode == 13) {
                table_ci_fund_dec.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '') {
                    table_ci_fund_dec.search($(this).val()).draw();
                }
            }
        }
    });


    // Add event listener for opening and closing details
    $('#table_fund_req_declined tbody').on('click', 'td.details-control-accounts', function () {
        var tr = $(this).closest('tr');
        var row = table_ci_fund_dec.row(tr);
        var tableId = 'sao_dec_posts-' + row.data().id;

        if (row.child.isShown()) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        } else {
            // Open this row
            row.child(template_dec(row.data())).show();
            initTable_dec(tableId, row.data());
            tr.addClass('shown');
            // tr.next().find('td').addClass('no-padding bg-white');
        }
    });

    function initTable_dec(tableId, data) {
        $('#' + tableId).DataTable({
            processing: true,
            serverSide: true,
            order: [[0, 'desc']],
            // ajax: 'pending_fund_details_endorsements',
            ajax:
                {
                    url: "/sao_dec_fund_details_endorsements",
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




