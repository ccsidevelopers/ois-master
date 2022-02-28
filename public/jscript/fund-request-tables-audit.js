$(document).ready(function () {
//AUDIT

});
var tableCiFundSuccess;

var coltittle3 = [];
var col_count3 = 0;
var tableFundFa;


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
                            columns: ':visible',
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
        "ajax": "audit-ci-fund-request-table-fa",
        "columns":
            [
                {data: 'id', name: 'fund_requests.id'},
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
                        var tryOnly = data.name_ci;

                        var reqrem = '';
                        var req = '';

                        console.log(data.tor)

                        if(data.tor == 'NORMAL REQUEST')
                        {
                            reqrem = data.dispatcher_remarks+'||==||'+data.name_disp;
                        }
                        else if(data.tor == 'EMERGENCY FUND')
                        {
                            reqrem = data.sao_remarks+'||==||'+data.name_sao;
                        }

                        if(data.tor == 'NORMAL REQUEST')
                        {
                            req = '';
                        }
                        else if(data.tor == 'EMERGENCY FUND')
                        {
                            req = '<button class="btnViewManagementRem btn btn-block btn-sm btn-danger" style="width : 100%" name = "'+data.rem_manage+'||==||'+data.manage_name+'"><i class = "fa fa-fw fa-info-circle"></i> View Management Remarks</button>';
                        }

                        return '<button type = "button" class = "btn_view_ci_liq btn btn-sm btn-primary btn-block" name = '+ data.id +' value="'+tryOnly+'"><i class = "fa fa-fw fa-file-image-o"></i>View C.I Liquidation Info</button>' +
                            '<button class = "btnShowRemarksRequestor btn-sm btn-primary btn-block"  style="width: 100%" name = "'+reqrem+'" ><i class = "fa fa-fw fa-info-circle"></i> View Requestor Remarks</button>' +
                            req +
                        '<button type = "button" class = "btn_ci_liq_view_remarks btn btn-sm btn-info btn-block" name = "'+ data.id +'" data-toggle="modal" data-target="#modal-view-audit-review-rem"><i class = "glyphicon glyphicon-film"></i> View Logs</button>';
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

$('#table-finance-expenses-report').on('click', '.btnShowRemarksRequestor', function()
{
    $('#req_rem_remarks').val('');
    $('#dispatcher_req_name').val('');
    $('#modal-req-rem').modal('show');

    var get_rem_name = $(this).attr('name').split('||==||');

    $('#dispatcher_req_name').text(get_rem_name[1]);
    $('#req_rem_remarks').val(get_rem_name[0]);
});