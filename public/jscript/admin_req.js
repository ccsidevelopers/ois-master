var tableMonitRequi_app;
var requi_table_app = [];
var r_1_app = 0;
var activeMain_app = 'tabRequi_1';
var requi_monit_bool_1_app = true;
var requi_monit_bool_2_app = false;
var requi_monit_bool_3_app = false;
var requi_table_2_app = [];
var r_2_app = 0;
var tableMonitRequi2_app;
var requi_table_3_app = [];
var r_3_app = 0;
var tableMonitRequi3_app;
var tabApp2Moniq = false;
var tabApp3Moniq = false;

eqMonitReqTableApp();
function eqMonitReqTableApp()
{
    $('#gen_req_mon_pending_app thead th').each(function()
    {
        requi_table_app[r_1_app] = $(this).text();
        r_1_app++;
    });
    tableMonitRequi_app = $('#gen_req_mon_pending_app').DataTable
    ({

        // "responsive": true,
        dom: 'Blfrtip',
        buttons:
            [
                {
                    extend: 'excel',
                    title : 'Requisition Monitoring(Pending)',
                    exportOptions:
                        {
                            columns: [0, 1, 2, 3, 4, 5, 6],
                            format:
                                {
                                    header: function (dt, idx) {
                                        return requi_table_app[(idx)];
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
                        return requi_table_app[(idx)];
                    }
                }
            ],
        "processing": true,
        "serverSide": true,
        "responsive": true,
        "ajax": "/gen-requi-table",
        "columns":
            [
                {data: 'id', name: 'admin_requisition.id'},
                {data: 'send_name', name: 'users.name'},
                {data: 'dor', name: 'admin_requisition.date_request'},
                {data: 'req_name', name: 'admin_requisition.requestor_name'},
                {data: 'office_loc', name: 'admin_requisition.office_loc_dep_pos'},
                {data: 'app_by', name: 'admin_requisition.approved_by'},
                {data: 'app_date', name: 'admin_requisition.approval_date'},
                {
                    data: function btn(data)
                    {
                        return '<button class = "btn btn-xs btn-primary btn-block btnApprovalRequisition" name = "'+data.id+'"><i class="fa fa-fw fa-info"></i> View Form</button>';
                    },
                    name : 'admin_requisition.id'
                }
            ],
        "order": [[0, 'desc']],
        "pageLength": 10,
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

    $('#gen_req_mon_pending_app_filter input').unbind();
    $('#gen_req_mon_pending_app_filter input').bind('keyup change',function (e) {

        if($(this).is(':focus'))
        {
            if (e.keyCode == 13) {
                tableMonitRequi_app.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '') {
                    tableMonitRequi_app.search($(this).val()).draw();
                }
            }
        }
    });
}

function eqMonitReqTable2App()
{
    $('#gen_req_mon_approved_app thead th').each(function()
    {
        requi_table_2_app[r_2_app] = $(this).text();
        r_2_app++;
    });
    tableMonitRequi2_app = $('#gen_req_mon_approved_app').DataTable({

        // "responsive": true,
        dom: 'Blfrtip',
        buttons:
            [
                {
                    extend: 'excel',
                    title : 'Requisition Monitoring(Approved by Management)',
                    exportOptions:
                        {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7],
                            format:
                                {
                                    header: function (dt, idx) {
                                        return requi_table_2_app[(idx)];
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
                        return requi_table_2_app[(idx)];
                    }
                }
            ],
        "processing": true,
        "serverSide": true,
        "responsive": true,
        "ajax": "/gen_requi_table_approved",
        "columns":
            [
                {data: 'id', name: 'admin_requisition.id'},
                {data: 'send_name', name: 'users.name'},
                {data: 'dor', name: 'admin_requisition.date_request'},
                {data: 'req_name', name: 'admin_requisition.requestor_name'},
                {data: 'office_loc', name: 'admin_requisition.office_loc_dep_pos'},
                {data: 'app_by', name: 'admin_requisition.approved_by'},
                {data: 'app_date', name: 'admin_requisition.approval_date'},
                {data: 'app_name', name: 'app_id.name'},
                {
                    data: function btn(data)
                    {
                        return '<button class = "btn btn-xs btn-primary btn-block btnApprovalRequisition" name = "'+data.id+'"><i class="fa fa-fw fa-info"></i> View Form</button>';
                    },
                    name : 'admin_requisition.id'
                }
            ],
        "order": [[0, 'desc']],
        "pageLength": 10,
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

    $('#gen_req_mon_approved_app_filter input').unbind();
    $('#gen_req_mon_approved_app_filter input').bind('keyup change',function (e) {

        if($(this).is(':focus'))
        {
            if (e.keyCode == 13) {
                tableMonitRequi2_app.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '') {
                    tableMonitRequi2_app.search($(this).val()).draw();
                }
            }
        }
    });
}

$('#gen_req_mon_denied').on('click', '.btnViewRemarksRequi', function()
{

    var id = $(this).attr('name');
    console.log(id)
    $('.togs-'+id+'').toggle();
});

function eqMonitReqTable3App()
{
    $('#gen_req_mon_denied thead th').each(function()
    {
        requi_table_3_app[r_3_app] = $(this).text();
        r_3_app++;
    });
    tableMonitRequi3_app = $('#gen_req_mon_denied').DataTable({

        // "responsive": true,
        dom: 'Blfrtip',
        buttons:
            [
                {
                    extend: 'excel',
                    title : 'Requisition Monitoring',
                    exportOptions:
                        {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7],
                            format:
                                {
                                    header: function (dt, idx) {
                                        return requi_table_3_app[(idx)];
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
                        return requi_table_3_app[(idx)];
                    }
                }
            ],
        "processing": true,
        "serverSide": true,
        "responsive": true,
        "ajax": "/gen_requi_table_denied",
        "columns":
            [
                {data: 'id', name: 'admin_requisition.id'},
                {data: 'send_name', name: 'users.name'},
                {data: 'dor', name: 'admin_requisition.date_request'},
                {data: 'req_name', name: 'admin_requisition.requestor_name'},
                {data: 'office_loc', name: 'admin_requisition.office_loc_dep_pos'},
                {data: 'app_by', name: 'admin_requisition.approved_by'},
                {data: 'app_date', name: 'admin_requisition.approval_date'},
                {data: 'app_name', name: 'app_id.name'},
                {
                    data: function btn(data)
                    {
                        return '<button class = "btn btn-xs btn-primary btn-block btnApprovalRequisition" name = "'+data.id+'"><i class="fa fa-fw fa-info"></i> View Form</button> ' +
                            '<button class = "btn btn-xs btn-warning btn-block btnViewRemarksRequi" name = "'+data.id+'"><i class="fa fa-fw fa-info"></i> Denial Remarks</button>' +
                            '<p class="pull-left togs-'+data.id+'" hidden><b>Date and Time: </b>'+data.dtDenied+'</p><br>' +
                            '<p class="pull-left togs-'+data.id+'" hidden><b>Remarks:</b> '+data.rem+'</p></div>'
                    },
                    name : 'admin_requisition.id',
                    "searchable" : false,
                    "orderable" : false
                }
            ],
        "order": [[0, 'desc']],
        "pageLength": 10,
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

    $('#gen_req_mon_denied_filter input').unbind();
    $('#gen_req_mon_denied_filter input').bind('keyup change',function (e) {

        if($(this).is(':focus'))
        {
            if (e.keyCode == 13) {
                tableMonitRequi3_app.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '') {
                    tableMonitRequi3_app.search($(this).val()).draw();
                }
            }
        }
    });
}



$('.admin_staff_requi_monit_class_app').click(function()
{
    var gethref = $(this).attr('href');
    console.log(gethref);
    if (gethref == '#tabRequi_1_app') {
        if ($('' + gethref + '').hasClass('active'))
        {
            console.log('do nothing');
            activeMain_app = '#tabRequi_1_app';
        }
        else if (requi_monit_bool_1_app)
        {
            console.log('already loaded');
            activeMain_app = '#tabRequi_1_app';
        }
        else if (requi_monit_bool_1_app == false)
        {
            requi_monit_bool_1_app = true;
            activeMain_app = '#tabRequi_1_app';
        }
    }
    else if (gethref == '#tabRequi_2_app')
    {
        if ($('' + gethref + '').hasClass('active'))
        {
            console.log('do nothing');
            activeMain_app = '#tabRequi_2_app';
        }
        else if (requi_monit_bool_2_app)
        {
            if(tabApp2Moniq == false)
            {
                tableMonitRequi2_app.ajax.reload(null, false);
                tabApp2Moniq = true;
            }
            else
            {
                console.log('already loaded');
            }

            activeMain_app = '#tabRequi_2_app';
        }
        else if (requi_monit_bool_2_app == false)
        {
            requi_monit_bool_2_app = true;
            activeMain_app = '#tabRequi_2_app';
            eqMonitReqTable2App()
        }
    }
    else if (gethref == '#tabRequi_3_app')
    {
        if ($('' + gethref + '').hasClass('active'))
        {
            console.log('do nothing');
            activeMain_app = '#tabRequi_3_app';
        }
        else if (requi_monit_bool_3_app)
        {
            if(tabApp3Moniq == false)
            {
                tableMonitRequi3_app.ajax.reload(null, false);
                tabApp3Moniq = true;
            }
            else
            {
                console.log('already loaded');
            }
            activeMain_app = '#tabRequi_3_app';
        }
        else if (requi_monit_bool_3_app == false)
        {
            requi_monit_bool_3_app = true;
            activeMain_app = '#tabRequi_3_app';
            eqMonitReqTable3App();
        }
    }
});

$('#gen_req_mon_pending_app').on('click', '.btnApprovalRequisition', function()
{
    var id = $(this).attr('name');


    $('.toClear_app').val('');
    $('.requiListview_app').removeAttr('checked');

    viewReqModal2(id, 'yes')
});

$('#gen_req_mon_approved_app').on('click', '.btnApprovalRequisition', function()
{
    var id = $(this).attr('name');


    $('.toClear_app').val('');
    $('.requiListview_app').removeAttr('checked');

    viewReqModal2(id, 'no')
});

$('#gen_req_mon_denied').on('click', '.btnApprovalRequisition', function()
{
    var id = $(this).attr('name');


    $('.toClear_app').val('');
    $('.requiListview_app').removeAttr('checked');

    viewReqModal2(id, 'no')
});


function viewReqModal2(id, stat)
{
    var check;
    $.ajax
    ({
        type : 'get',
        url : 'admin-staff-get-details-requisition',
        data :
            {
                'id' : id
            },
        success : function(data)
        {

            console.log(data);

            $('#dateOfRequestAdmin_app').val(data[0][0].date_request);
            $('#requestedRequi_app').val(data[0][0].requestor_name);
            $('#officeLocRequi_app').val(data[0][0].office_loc_dep_pos);
            $('#dateNeededRequi_app').val(data[0][0].date_needed);
            $('#approvedByRequi_app').val(data[0][0].approved_by);
            $('#approvalDateRequi_app').val(data[0][0].approval_date);
            $('#totalAmountRequi_app').val(data[0][0].items_grand_total);
            $('#req_reason_remarks_app').val(data[0][0].req_reason_remarks);
            $('#otherCheck-0_view_app').val(data[0][0].other_check_0);
            $('#otherCheck-1_view_app').val(data[0][0].other_check_1);
            $('#otherCheck-2_view_app').val(data[0][0].other_check_2);
            $('#approveRequestReq_app').attr('name', data[0][0].id);
            $('#rejectRequestReq_app').attr('name', data[0][0].id);
            $('#requestedRequiFor_app').val(data[0][0].requested_for);
            $('#requestedRequiForID_app').val(data[0][0].requested_for_id);

            if(data[0][0].req_reason == 'New Request')
            {
                $('#clickNew_app').attr('checked', true)
            }
            else
            {
                $('#clickReplacement_app').attr('checked', true)
            }

            $('.requiListview_app').each(function()
            {
                check = $(this).val();
                for(i = 0; i < data[1].length; i++)
                {
                    if(data[1][i].check_name == check)
                    {
                        $(this).prop('checked', true);
                    }
                }
            });

            $('#appBrandview_app').html(' <tr>\n' +
                '                                <th colspan="1" style = "background-color: darkgrey; color : black; font-weight:bold;">Brand - Item - Description</th>\n' +
                '                                <th colspan="1" style = "background-color: darkgrey; color : black; font-weight:bold;">Quantity</th>\n' +
                '                                <th colspan="1" style = "background-color: darkgrey; color : black; font-weight:bold;">Unit Price</th>\n' +
                '                                <th colspan="1" style = "background-color: darkgrey; color : black; font-weight:bold;">Total Amount\n' +
                '                                            </th>\n' +
                '                            </tr>');

            for(var t = 0; t < data[2].length ; t++)
            {
                $('#appBrandview_app').append('<tr">\n' +
                    '                                <td colspan="1"> <textarea class = "form-control" rows ="2" disabled>'+data[2][t].brand_item_desc+'</textarea></td>\n' +
                    '                                <td colspan="1"><input type="number" class="form-control" value = "'+data[2][t].item_quantity+'" disabled></td>\n' +
                    '                                <td colspan="1"><input type="number" class="form-control" value = "'+data[2][t].item_unit_price+'" disabled></td>\n' +
                    '                                <td colspan="1">   <input type="number" class="form-control" value = "'+data[2][t].total_amount+'" disabled>\n' +
                    '                                </td>\n' +
                    '                            </tr>');
            }

            if(stat == 'yes')
            {
                $('#showApprovedReject_app').show();
            }
            else if(stat == 'no')
            {
                $('#showApprovedReject_app').hide();
            }
        }
    })
}

$('#approveRequestReq_app').click(function()
{
    var btn = $(this);
    var id = btn.attr('name');

    btn.attr('disabled', true);


    if(confirm('Are you sure to approve the request?'))
    {
        $('#loadingSpanSendReqAppr1').show();

        $.ajax
        ({
            'type' : 'get',
            'url' : 'gen_approve_requi_approver',
            data :
                {
                    'id' : id
                },
            success : function()
            {
                alert('Successfully Approved Request!');
                $('#loadingSpanSendReqAppr1').hide();
                $('.toClear_app').val('');
                $('.requiListview_app').removeAttr('checked');
                $('#showApprovedReject_app').hide();
                tableMonitRequi_app.ajax.reload(null, false);


                $('#appBrandview_app').html(' <tr>\n' +
                    '                                <th colspan="1" style = "background-color: darkgrey; color : black; font-weight:bold; padding-bottom: 15px;">Brand - Item - Description</th>\n' +
                    '                                <th colspan="1" style = "background-color: darkgrey; color : black; font-weight:bold; padding-bottom: 15px;">Quantity</th>\n' +
                    '                                <th colspan="1" style = "background-color: darkgrey; color : black; font-weight:bold; padding-bottom: 15px;">Unit Price</th>\n' +
                    '                                <th colspan="1" style = "background-color: darkgrey; color : black; font-weight:bold;"><span>Total Amount</span>\n' +
                    '                                            </th>\n' +
                    '                            </tr>');

                btn.attr('disabled', false);

                tabApp2Moniq = true;


            }
        })
    }
    else
    {
        btn.attr('disabled', false);
    }
});

$('#rejectRequestReq_app').click(function()
{
    var btn = $(this);
    var id = btn.attr('name');

    btn.attr('disabled', true);

    var remarks = prompt("Are you sure to deny the request? Please indicate remarks.",'-');
    if (remarks == null || remarks == "" || remarks == "-")
    {
        btn.attr('disabled', false);
    }
    else
    {
        $('#loadingSpanSendReqAppr2').show();

        $.ajax
        ({
            'type' : 'get',
            'url' : 'gen-deny-requi',
            data :
                {
                    'id' : id,
                    'remarks' : remarks
                },
            success : function()
            {
                alert('Successfully Denied Request!');
                $('#loadingSpanSendReqAppr2').hide();
                $('.toClear_app').val('');
                $('.requiListview_app').removeAttr('checked');
                $('#showApprovedReject_app').hide();
                tableMonitRequi_app.ajax.reload(null, false);

                $('#appBrandview_app').html(' <tr>\n' +
                    '                                <th colspan="1" style = "background-color: darkgrey; color : black; font-weight:bold; padding-bottom: 15px;">Brand - Item - Description</th>\n' +
                    '                                <th colspan="1" style = "background-color: darkgrey; color : black; font-weight:bold; padding-bottom: 15px;">Quantity</th>\n' +
                    '                                <th colspan="1" style = "background-color: darkgrey; color : black; font-weight:bold; padding-bottom: 15px;">Unit Price</th>\n' +
                    '                                <th colspan="1" style = "background-color: darkgrey; color : black; font-weight:bold;"><span>Total Amount</span>\n' +
                    '                                            </th>\n' +
                    '                            </tr>');

                btn.attr('disabled', false);

                tabApp3Moniq = true;


            }
        });
    }
});

$('#clearFieldsRequiApp').click(function()
{
    if(confirm('Are you sure to clear fields?'))
    {
        $('.toClear_app').val('');
        $('.requiListview_app').removeAttr('checked');
        $('#showApprovedReject_app').hide();

        $('#appBrandview_app').html(' <tr>\n' +
            '                                <th colspan="1" style = "background-color: darkgrey; color : black; font-weight:bold;">Brand - Item - Description</th>\n' +
            '                                <th colspan="1" style = "background-color: darkgrey; color : black; font-weight:bold;">Quantity</th>\n' +
            '                                <th colspan="1" style = "background-color: darkgrey; color : black; font-weight:bold;">Unit Price</th>\n' +
            '                                <th colspan="1" style = "background-color: darkgrey; color : black; font-weight:bold;"><span>Total Amount</span>\n' +
            '                                            </th>\n' +
            '                            </tr>');

        $('#approveRequestReq_app').removeAttr('name');
        $('#rejectRequestReq_app').removeAttr('name');
    }
    else
    {

    }
});