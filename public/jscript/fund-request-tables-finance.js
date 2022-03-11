$(document).ready(function () {
//FINANCE

});
var coltittle = [];
var col_count = 0;
var template_app_finance;
var tableCiFundApproved;

var tableCiFundSuccess;
var template_app_finance2;
var col_count2 = 0;
var coltittle2 = [];

var coltittle3 = [];
var col_count3 = 0;
var tableFundFa;

function fund_request_approved_table()
{
    $('#table_fund_req_approved_finance thead th').each(function()
    {
        coltittle[col_count] = $(this).text();
        col_count++;
    });
    template_app_finance= Handlebars.compile($("#details-template-app-finance").html());
    tableCiFundApproved = $('#table_fund_req_approved_finance').DataTable(
        {

            // "responsive": true,
            dom: 'Blfrtip',
            buttons:
                [
                    {
                        extend: 'excel',
                        title : 'Approved Fund Request',
                        exportOptions:
                            {
                                columns: [0, 1, 2, 3, 4, 7],
                                format:
                                    {
                                        header: function (dt, idx) {
                                            return coltittle[(idx)];
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
                        columnText: function (dt, idx)
                        {
                            return coltittle[(idx)];
                        }
                    }
                ],
            "processing": true,
            "serverSide": true,
            "responsive": true,
            "ajax": "/finance-ci-fund-request-table-approved",
            "columns":
                [
                    {data: 'id', name: 'fund_requests.id'},
                    {data: 'name_ci', name: 'ci_id.name'},
                    {
                        data: function (data)
                        {
                            if(data.type_of_fund_request == 'NORMAL REQUEST')
                            {
                                return data.name_disp
                            }
                            else
                            {
                                return '-';
                            }


                        },
                        "name": 'dispatcher_id.name'
                    },
                    {
                        data: function (data)
                        {
                            if(data.type_of_fund_request != 'NORMAL REQUEST')
                            {
                                return data.name_sao
                            }
                            else
                            {
                                return '-';
                            }
                        },
                        "name": 'sao_id.name'
                    },
                    {data: 'sao_approved_date', name: 'fund_requests.sao_approved_date'},
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
                        "className":      'details-control',
                        "orderable":      false,
                        "searchable":      false,
                        "data":           null,
                        "defaultContent": ''
                    },
                    {data: 'remit_info', name: 'remit_info', "orderable": false, "searchable": false},
                    {data: 'stats', name: 'stats', "orderable": false, "searchable": false},
                    {
                        data: function actions(data)
                        {
                            var span = '<span id="update_fund_remarks_span-'+data.id+'"></span>' +
                                '<br><br><button class="btn_edit_remarks_qq btn btn-info btn-xs btn-block" name="'+data.id+'" style="margin-top: 5px" value="edit" id="update_fund_remarks">Edit Remarks</button>' +
                                '<button class="cancel_fund_remarks btn btn-danger btn-xs btn-block" hidden name="'+data.id+'" style="margin-top: 5px; display: none;" id="cancel_fund_remarks">Cancel</button>' +
                                '</span>' +
                                '<br>' +
                                'Last Update: <span id="date_time_remarks_update_span-'+data.id+'">'+data.date_time_remarks+'</span>';

                            return '<span id="updated_fund_remarks_span-'+data.id+'">'+data.finance_remarks+'</span>'+span;
                        },
                        "orderable": false,
                        "searchable": false,
                        "name": 'action'
                    },
                    {data: 'action', name: 'action', "orderable": false, "searchable": false}

                ],
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

    $('#table_fund_req_approved_finance_filter input').unbind();
    $('#table_fund_req_approved_finance_filter input').bind('keyup change',function (e) {

        if($(this).is(':focus'))
        {
            if (e.keyCode == 13) {
                tableCiFundApproved.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '') {
                    tableCiFundApproved.search($(this).val()).draw();
                }
            }
        }
    });

    $('#table_fund_req_approved_finance tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = tableCiFundApproved.row(tr);
        var tableId = 'finance_app_posts-' + row.data().id;

        if (row.child.isShown()) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        } else {
            // Open this row
            row.child(template_app_finance(row.data())).show();
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
                    url: "/finance_app_fund_details_endorsements",
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

function getSuccessTable()
{
    $('#table_success_req_finance thead th').each(function()
    {
        coltittle2[col_count2] = $(this).text();
        col_count2++;
    });
    template_app_finance2= Handlebars.compile($("#details-template-app-finance-success").html());
    tableCiFundSuccess = $('#table_success_req_finance').DataTable({

        // "responsive": true,
        dom: 'Blfrtip',
        buttons:
            [
                {
                    extend: 'excel',
                    title : 'Successful Fund Request',
                    exportOptions:
                        {
                            columns: [ 0, 1, 2, 3, 4, 6, 7],
                            trim : false,
                            format:
                                {
                                    header: function (dt, idx) {
                                        return coltittle2[(idx)];
                                    },
                                    body: function (data,row,column)
                                    {
                                        if(column == 5)
                                        {
                                            var dataDetails = data.split('<br>');
                                            var loopData = '';
                                            var i;

                                            for(i = 0 ; i < dataDetails.length; i++)
                                            {
                                                if(dataDetails[i] != '')
                                                {
                                                    if(i < dataDetails.length-1)
                                                    {
                                                        loopData += dataDetails[i] + '/';
                                                    }
                                                    else if(i == dataDetails.length-1)
                                                    {
                                                        loopData += dataDetails[i];
                                                    }

                                                }
                                            }

                                            return loopData;

                                        }
                                        else
                                        {
                                            return data;
                                        }

                                    }
                                },

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
                        return coltittle2[(idx)];
                    }
                }
            ],
        "processing": true,
        "serverSide": true,
        "responsive": true,
        "ajax":
            {
                // "type" : 'GET',
                "url": "/finance-ci-fund-request-table-success",
                "data": function (d)
                {
                    var type =  '';

                    $('.fundSucRange').each(function()
                    {
                        if($(this).is(':checked'))
                        {
                            type = $(this).val();
                        }
                    });

                    var start = $('#sucFundReq_min').val();
                    var end =  $('#sucFundReq_max').val();


                    d.start_q = start;
                    d.end_q = end;
                    d.type_q = type;
                }
            },
        "columns":
            [
                {data: 'id', name: 'fund_requests.id'},
                // {data: 'name_disp', name: 'dispatcher_id.name'},
                {data: 'name_ci', name: 'ci_id.name'},
                {data: 'sao_approved_date', name: 'fund_requests.sao_approved_date'},
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
                    "className":      'details-control',
                    "orderable":      false,
                    "searchable":      false,
                    "data":           null,
                    "defaultContent": ''
                },
                {data: 'remit_info', name: 'action', "orderable": false, "searchable": false},
                {data: 'stats', name: 'action', "orderable": false, "searchable": false},
                {
                    data : function actions(data)
                    {
                        var incident = '';
                        var editCheck = '';
                        var holdcancelCheck = '';
                        var checkSome = '';

                        // if(data.incident == null || data.incident == '')
                        // {
                        //     incident = '<button class = "btn_incident_rem btn btn-primary btn-xs btn-block" name="'+data.id+'"  style="margin-bottom: 5px"><i class = "glyphicon glyphicon-pencil"></i> Incident Remarks</button></span>';
                        // }
                        // else if(data.incident != null || data.incident != '')
                        // {
                        //     incident = '<button class = "btn_incident_view btn btn-primary btn-xs btn-block" name="'+data.id+'"  style="margin-bottom: 5px"><i class = "glyphicon glyphicon-info-sign"></i> View Incident Remarks</button></span>';
                        // }


                        if(data.done == 'New')
                        {
                            // editCheck = '<button class = "btn btn-success btn-xs btn-block" style= " margin-bottom : 5px"><i class = "glyphicon glyphicon-ok"></i> Already Re-sent</button>';

                            if(data.incident != null || data.incident != '')
                            {
                                incident = '<button class = "btn_incident_view btn btn-primary btn-xs btn-block" name="'+data.id+'"  style="margin-bottom: 5px"><i class = "glyphicon glyphicon-info-sign"></i> View Remarks</button></span>';
                            }
                        }
                        else
                        {

                        }

                        if(data.liq != '')
                        {
                            holdcancelCheck = '<button class = "btn btn-info btn-xs btn-block" disabled><i class = "glyphicon glyphicon-ok"></i> Fund Already Liquidated</button>';

                            if(data.done == 'New')
                            {
                                // editCheck = '<button class = "btn btn-success btn-xs btn-block" style= " margin-bottom : 5px"><i class = "glyphicon glyphicon-ok"></i> Already Re-sent</button>';

                                if(data.incident != null || data.incident != '')
                                {
                                    incident = '<button class = "btn_incident_view btn btn-primary btn-xs btn-block" name="'+data.id+'"  style="margin-bottom: 5px"><i class = "glyphicon glyphicon-info-sign"></i>  View Remarks</button></span>';
                                }
                            }
                        }
                        else if(data.hold_cancel != '')
                        {
                            if(data.hold_cancel == 'Hold')
                            {
                                holdcancelCheck = '<button class = "btn_unhold_fund btn btn-warning btn-xs btn-block" name = "'+data.id+'" title = "Click to un-hold"><i class = "fa fa-fw fa-hand-stop-o"></i> Fund On-Hold <span class = "loadingIkot" id = "loadingSendUnHold-'+data.id+'" style = "position: absolute; padding-right : 5px;" hidden><img src= "dist/img/loading.gif" style = "width: 20%"></span></button>';

                                if(data.done == 'Done')
                                {
                                    editCheck = '<button class = "btn_edit_approve btn btn-primary btn-xs btn-block" name="'+data.id+'" href = "'+ data.amount +'"  style= " margin-bottom : 5px" ><i class = "fa fa-fw fa-edit"></i> Re-send Request</button>';

                                    // if(data.incident != null || data.incident != '')
                                    // {
                                    incident = '';
                                    // }
                                }
                            }
                            else if(data.hold_cancel == 'Cancel')
                            {
                                holdcancelCheck = '<button class = "btn btn-danger btn-xs btn-block" disabled><i class = "glyphicon glyphicon-remove"></i> Fund Cancelled</button>';

                                // if(data.done == 'Done')
                                // {
                                //     editCheck = '<button class = "btn_edit_approve btn btn-primary btn-xs btn-block" name="'+data.id+'" href = "'+ data.amount +'"  style= " margin-bottom : 5px"><i class = "fa fa-fw fa-edit"></i> Re-send Request</button>';
                                //
                                //     // if(data.incident != null || data.incident != '')
                                //     // {
                                //     incident = '';
                                //     // }
                                // }
                            }
                            else if(data.hold_cancel == 'Override')
                            {
                                holdcancelCheck = '<button class = "btn bg-black-gradient btn-xs btn-block" disabled><i class =  "glyphicon glyphicon-import"></i> SAO Override</button>';
                            }
                        }
                        else if(data.hold_cancel == '')
                        {
                            holdcancelCheck = '<button class = "btn_hold_fund_ci btn btn-warning btn-xs btn-block" name="'+data.id+'">' +
                                '<i class = "fa fa-fw fa-hand-stop-o"></i> Hold Fund <span class = "loadingIkot" id = "loadingSendHold-'+data.id+'" style = "position: absolute; padding-right : 5px;" hidden><img src= "dist/img/loading.gif" style = "width: 20%"></span></button>' +
                                '<button class = "btn_cancel_fund_ci btn btn-danger btn-xs btn-block" name="'+data.id+'">' +
                                '<i class = "glyphicon glyphicon-remove"></i> Cancel Fund <span class = "loadingIkot" id = "loadingSendCancel-'+data.id+'" style = "position: absolute; padding-right : 5px;" hidden><img src= "dist/img/loading.gif" style = "width: 20%"></span></button>' +
                                '<button class = "btn-xs btn-block btn-primary" name = "'+data.id+'" id = "check_remarks_requestor">View Remarks</button>';
                        }

                        if(data.type_of_fund_request != 'REIMBURSEMENT')
                        {
                            return editCheck + incident + holdcancelCheck + checkSome;
                        }
                        else
                        {
                            return '<button class = "btn btn-primary btn-xs btn-block" disabled><i class = "glyphicon glyphicon-ok"></i> Reimbursement Request</button>';
                        }

                    },
                    "name": 'action', "orderable": false, "searchable": false}
            ],
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

    $('#table_success_req_finance_filter input').unbind();
    $('#table_success_req_finance_filter input').bind('keyup change',function (e) {

        if($(this).is(':focus'))
        {
            if (e.keyCode == 13) {
                tableCiFundSuccess.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '') {
                    tableCiFundSuccess.search($(this).val()).draw();
                }
            }
        }
    });
    $('#table_success_req_finance tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = tableCiFundSuccess.row(tr);
        var tableId = 'finance_app_posts-success-' + row.data().id;

        if (row.child.isShown()) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        } else {
            // Open this row
            row.child(template_app_finance2(row.data())).show();
            initTable_app2(tableId, row.data());
            tr.addClass('shown');
            // tr.next().find('td').addClass('no-padding bg-white');
        }
    });

    function initTable_app2(tableId, data) {
        $('#' + tableId).DataTable({
            processing: true,
            serverSide: true,
            order: [[0, 'desc']],
            // ajax: 'pending_fund_details_endorsements',
            ajax:
                {
                    url: "/finance_app_fund_details_endorsements",
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
        // "responsive": true,
        // "ajax": "/finance-ci-fund-request-table-fa",
        "ajax":
            {
                // "type" : 'GET',
                "url": "/finance-ci-fund-request-table-fa",
                "data": function (d)
                {


                    var start = $('#ci_expense_range_start1').val();
                    var end =  $('#ci_expense_range_end1').val();
                    var archipelago_id_holder_q = '';
                    if($('#ci_expense_archi').length > 0)
                    {
                        archipelago_id_holder_q = $('#ci_expense_archi').find(':selected').val();

                        d.archipelago_id_holder = archipelago_id_holder_q;
                    }
                    console.log([start, end, archipelago_id_holder_q]);


                    d.start_q = start;
                    d.end_q = end;
                    // d.max_date_endorsed = $('#max_report').val();
                }
            },
        "columns":
            [
                {data: 'id', name: 'fund_requests.id'},
                {data : 'archi', name : 'archipelagos.archipelago_name'},
                {data: 'address_edit', name: 'endorsements.address'},
                {data: 'name_ci', name: 'ci_id.name'},
                {
                    data : function dates(data)
                    {
                        if(data.tor == 'NORMAL REQUEST')
                        {
                            if(parseInt(atob(data.amount)) >= 2500)
                            {
                                return data.dispatcher_request_date;
                            }
                            else if(parseInt(atob(data.amount)) < 2500)
                            {
                                return data.dispatcher_request_date;
                            }
                        }
                        else if(data.tor == 'EMERGENCY FUND')
                        {
                            if(data.sao_date == '')
                            {
                                return data.dispatcher_request_date;
                            }
                            else
                            {
                                return data.sao_date;
                            }
                        }
                    },
                    name: 'fund_requests.id'
                },
                {
                    data: function (data)
                    {
                        return atob(data.amount)
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

                        var reqrem = '';
                        if(data.tor == 'NORMAL REQUEST')
                        {
                            reqrem = data.dispatcher_remarks+'||==||'+data.name_disp;
                            req= '';
                        }
                        else if(data.tor == 'EMERGENCY FUND')
                        {
                            reqrem = data.sao_remarks+'||==||'+data.name_sao;
                            req = '<button class="btnViewManagementRem btn btn-block btn-sm btn-danger" style="width : 100%" name = "'+data.rem_manage+'||==||'+data.manage_name+'"><i class = "fa fa-fw fa-info-circle"></i> View Management Remarks</button>';
                        }

                        return '<button type = "button" class = "btn_view_ci_liq btn btn-sm btn-primary btn-block" name = '+ data.id +'><i class = "fa fa-fw fa-file-image-o"></i>View C.I Liquidation Info</button>' +
                            '<button class = "btn-xs btn-block btn-primary" name = "'+data.id+'" id = "check_remarks_requestor">View Requestor Remarks</button>' +
                            req+
                            '<button class="audit_finance_logs btn btn-xs btn-block btn-info" id="'+data.id+'" data-toggle="modal" data-target="#modal-view-audit-review-rem">View Logs</button>';
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

$('#table-finance-expenses-report').on('click', '.btnViewManagementRem', function()
{
    $('#req_rem_remarks_manage').val('');
    $('#dispatcher_req_name').val('');
    $('#modal-req-rem-manage').modal('show');

    var get_rem_name = $(this).attr('name').split('||==||');

    $('#manage_req_name').text(get_rem_name[1]);
    $('#req_rem_remarks_manage').val(get_rem_name[0]);
});

$('#table-finance-expenses-report').on('click', '.audit_finance_logs', function()
{
    $('#view_remarksSpan').html();
    viewAuditRemarks($(this).attr('id'));
});

function viewAuditRemarks(id)
{
    $.ajax({
        type: 'get',
        url: 'finance_get_audit_remarks',
        data: {
            'id' : id
        },
        success: function(data)
        {
            console.log(data);

            if(data == '')
            {
                $('#view_remarksSpan').html('<table class="table-hover" width="100%">\n' +
                    '<tr style="background-color: black; color:white; text-align: left">\n' +
                    '<th>Name</th>\n' +
                    '<th>Date / Time Occured</th>\n' +
                    '<th>Activity / Logs</th>\n' +
                    '</tr>\n' +
                    '<tr>\n' +
                    '<td colspan="3">No Available Records</td>\n' +
                    '</tr>\n' +
                    '</table>');
            }
            else
            {
                var dataTable = '';
                var tableHead = '<table class="table-hover" width="100%">\n' +
                    '                                <tr style="background-color: black; color:white; text-align: left">\n' +
                    '                                    <th>Name</th>\n' +
                    '                                    <th>Date / Time Occured</th>\n' +
                    '                                    <th>Activity / Logs</th>\n' +
                    '                                </tr>';

                for(var i = 0;i < data[0].length; i++)
                {
                    dataTable += '<tr>\n' +
                        '    <td>' + data[0][i].name + '</td>\n' +
                        '    <td>' + data[0][i].date_time + '</td>\n' +
                        '    <td>' + data[0][i].activity + '</td>\n' +
                        '</tr>';
                }

                $('#view_remarksSpan').html(tableHead + dataTable + '</table>');
            }

        }
    });
}

$('.fundSucRange').change(function()
{
    tableCiFundSuccess.draw();

    if($(this).val() != 'date_range')
    {
        $('#fundSucRangeDaterange').hide();
    }
    else
    {
        $('#fundSucRangeDaterange').show();
    }
});

$('#sucFundReq_min, #sucFundReq_max').change(function()
{
    tableCiFundSuccess.draw();
});