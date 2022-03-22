var fund_id;
var ci_id;

$(document).ready(function () {


});

function fund_sao_init()
{
    var template = Handlebars.compile($("#details-template-pending-sao").html());
    table_ci_fund = $('#table_fund_req').DataTable
    ({

            "responsive": true,
            "processing": true,
            "serverSide": true,
            "ajax": "/srao-get-ci-fund-table",
            // 'ajax'       : {
            //     "type"   : "POST",
            //     "url"    : 'srao-get-ci-fund-table',
            //     "dataSrc": function (data)
            //     {
            //         console.log(data);
            //     }
            //     },
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
                    {data: 'name_disp', name: 'dispatcher_id.name'},
                    {data: 'name_ci', name: 'ci_id.name'},
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
                            return "Php "+atob(data.amount)
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
                    {data: 'remarks', name: 'fund_requests.dispatcher_remarks'},
                    // {
                    //     data: function actions(data)
                    //     {
                    //
                    //         return '<textarea id="textarea-'+data.id+'" placeholder="Enter SAO Remarks"></textarea>';
                    //     },
                    //     "orderable": false,
                    //     "searchable": false,
                    //     "name": 'action'
                    // },
                    {
                        data: function actions(data)
                        {

                            return '  <a href="' + data.id + '" class="btn btn-xs btn-info btn-block" data-toggle="modal" id="BtnApproved" style="width: 100%" name="'+data.amount+'">APPROVE REQUEST </a>' +
                                '<a href="' + data.id + '" class="btn btn-xs btn-warning btn-block" data-toggle="modal" id="BtnDeclined" style="width: 100%">DISAPPROVE REQUEST</a>';

                        },
                        "orderable": false,
                        "searchable": false,
                        "name": 'action'
                    }

                ],
            "fnRowCallback": function(nRow, aData)
            {
                var newAmt = parseInt(atob(aData.amount));
                if(newAmt > 2500)
                {
                    $('td', nRow).remove();
                }
                else if(newAmt <= 2500)
                {
                    $('td', nRow).show();
                }
            },
            "order": [[1, 'desc']],
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

    $('#table_fund_req_filter input').unbind();
    $('#table_fund_req_filter input').bind('keyup change',function (e) {

        if($(this).is(':focus'))
        {
            if (e.keyCode == 13) {
                table_ci_fund.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '') {
                    table_ci_fund.search($(this).val()).draw();
                }
            }
        }
    });
    $('#table_fund_req tbody').on('click', 'td.details-control', function () {
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

    // Add event listener for opening and closing details

function tbl_approved()
{
    var template_app = Handlebars.compile($("#details-template-app-sao").html());

    table_ci_fund_app = $('#table_fund_req_approved').DataTable(
        {

            "responsive": true,
            "processing": true,
            "serverSide": true,
            "ajax": "/srao-get-ci-fund-table-approved",
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
                    {data: 'name_disp', name: 'dispatcher_id.name'},
                    {data: 'name_ci', name: 'ci_id.name'},
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
                            return "Php "+atob(data.amount)
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
                    {data: 'remarks', name: 'fund_requests.dispatcher_remarks'},
                    // {
                    //     data: function actions(data)
                    //     {
                    //
                    //         return data.sao_remarks
                    //     },
                    //     "orderable": false,
                    //     "searchable": false,
                    //     "name": 'action'
                    // },
                    {
                        data: function actions(data)
                        {

                            var buttons = '<a href="' + data.id + '" class="btn btn-xs btn-success" data-toggle="modal" id="" style="width: 100%">APPROVED REQUEST</a>';

                            if(data.status != null || data.status_atm != null)
                            {
                                buttons += '<button class="btn btn-xs btn-success btn-block">UPLOADED</button>';
                            }
                            else
                            {
                                buttons += '<button class="btn btn-xs btn-warning btn-block">WAITING FOR UPLOAD</button>';
                            }

                            return buttons;



                        },
                        "orderable": false,
                        "searchable": false,
                        "name": 'action'
                    }

                ],
            // "fnRowCallback": function( nRow, aData)
            // {
            //     var newAmt = parseInt(atob(aData.amount));
            //     if(newAmt > 2500)
            //     {
            //         $('td', nRow).remove();
            //     }
            //     else if(newAmt <= 2500)
            //     {
            //         $('td', nRow).show();
            //     }
            // },
            "order": [[1, 'desc']],
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
    $('#table_fund_req_approved tbody').on('click', 'td.details-control', function () {
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

function tble_dcline()
{
    var template_dec = Handlebars.compile($("#details-template-dec-sao").html());
    table_ci_fund_dec = $('#table_fund_req_declined').DataTable(
        {

            "responsive": true,
            "processing": true,
            "serverSide": true,
            "ajax": "/srao-get-ci-fund-table-declined",
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
                    {data: 'name_disp', name: 'dispatcher_id.name'},
                    {data: 'name_ci', name: 'ci_id.name'},
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
                            return "Php "+atob(data.amount)
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
                    {data: 'remarks', name: 'fund_requests.dispatcher_remarks'},
                    {
                        data: function actions(data)
                        {

                            return data.dis_remarks
                        },
                        "orderable": false,
                        "searchable": false,
                        "name": 'action'
                    },
                    {
                        data: function actions(data)
                        {

                            return '<a href="' + data.id + '" class="btn btn-xs btn-warning" data-toggle="modal" id="" style="width: 100%">DISAPPROVED REQUEST</a>';

                        },
                        "orderable": false,
                        "searchable": false,
                        "name": 'action'
                    }

                ],
            // "fnRowCallback": function( nRow, aData)
            // {
            //     var newAmt = parseInt(atob(aData.amount));
            //     if(newAmt > 2500)
            //     {
            //         $('td', nRow).remove();
            //     }
            //     else if(newAmt <= 2500)
            //     {
            //         $('td', nRow).show();
            //     }
            // },
            "order": [[1, 'desc']],
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
    $('#table_fund_req_declined tbody').on('click', 'td.details-control', function () {
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

$('#btn_add_req').click(function()
{
    var formData = new FormData();

    // console.log('before send: '+$('#selFciName').val());

    formData.append('fund_id', fund_id);
    formData.append('selFciName', ci_id);
    formData.append('txtFundAmount',$('#txtFundAmount_add').val());
    formData.append('txtFundRemarks',$('#txtFundRemarks_add').val());

    $.ajax
    ({
        method: 'post',
        url: 'sao_send_request_add_fund',
        data: formData,
        processData: false,
        traditional: true,
        contentType: false,
        beforeSend: function ()
        {
            $('#btn_add_req').attr('disabled',true);
        },
        success: function (data)
        {
            // console.log(data);
            if(data=='success')
            {
                alert('Successfully Requested Additional Fund');
                $('#modal_additional_fund_request').modal('hide');
                // tableFundRequest.ajax.reload(null,false);
                // tableFundSuccess.ajax.reload(null,false);
                $('#txtFundAmount_add').val(0);
                $('#txtFundRemarks_add').val('');
                // getpending_and_onhand_fund(ci_id);
                tableFundRequest.draw();
                // refAllTbl();
                $('#btn_add_req').attr('disabled', false);
            }
        },
        error : function ()
        {
            $('#btn_add_req').attr('disabled', false);
            alert('Error on requesting! Please contact developers');
        }
    });
});

$('#table-advance-fund-success, #table-advance-fund-request').on('click', '#btn_open_modal_add_req', function()
{
    var splitCi = $(this).attr('name').split(':');
    ci_id = splitCi[1];
    fund_id = $(this).val();
});