$(document).ready(function () {

});

function fund_disp_init()
{
    var template = Handlebars.compile($("#details-template").html());
    tableFundRequest = $('#table-advance-fund-request').DataTable(
        {
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "ajax": "/dispatcher-get-fund-request-table",
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
                    {
                        data: function (data)
                        {
                            return data.fci
                        },
                        "name": 'CiName.name'
                    },
                    {
                        data: function (data)
                        {
                            return 'All';
                        },
                        "name": 'fund_requests.id'
                    },
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
                            // console.log(data);


                            if(data.sao_status=='APPROVED' || data.finance_status=='APPROVED')
                            {
                                return "Php "+atob(data.fund_amount)+' <small class="label bg-green">On Process</small>'
                            }
                            else
                            {
                                return "Php "+atob(data.fund_amount)+' <small class="label bg-orange">Pending</small>'
                            }
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
                    {
                        data: function (data)
                        {
                            return data.dispatcher_request_date;
                        },
                        "name": 'fund_requests.dispatcher_request_date'
                    },
                    {
                        data: function (data)
                        {
                            if(data.sao_status=='APPROVED' || data.finance_status=='APPROVED')
                            {
                                return '<button class="btn btn-xs btn-success btn-block">ON PROCESS</button>'+
                                    '<button class="btn btn-xs btn-info btn-block" name="'+data.fci+':'+data.fci_id+'" id="btn_open_modal_add_req" value="'+data.id+'" data-toggle="modal" data-target="#modal_additional_fund_request">ADDITIONAL REQUEST</button>';
                            }
                            else
                            {
                                return '<button class="btn btn-xs btn-danger btn-block" value="'+data.id+'" id="btnCancelFund">Cancel Request</button>'+
                                '<button class="btn btn-xs btn-info btn-block" name="'+data.fci+':'+data.fci_id+'" id="btn_open_modal_add_req" value="'+data.id+'" data-toggle="modal" data-target="#modal_additional_fund_request">ADDITIONAL REQUEST</button>';

                            }
                        },
                        name: 'fund_requests.id',
                        "searchable": false
                    }
                ],
            "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull)
            {
                var countDownDate = new Date(aData.dispatcher_request_date);
                var now = new Date();
                var distance = countDownDate.setMinutes(countDownDate.getMinutes()+20) - now;

                var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                if (minutes>=15)
                {
                    $('td', nRow).css('background-color', '#b3ffb3');
                }
                else if (minutes>=10)
                {
                    $('td', nRow).css('background-color', '#ffb84d');
                }
                else if (minutes>=5 || minutes<=5)
                {
                    $('td', nRow).css('background-color', '#ffb3b3');
                }
            },
            "order": [[1, 'desc']],
            "pageLength": 10,
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

    $('#table-advance-fund-request_filter input').unbind();
    $('#table-advance-fund-request_filter input').bind('keyup change',function (e) {

        if($(this).is(':focus'))
        {
            if (e.keyCode == 13) {
                tableFundRequest.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '') {
                    tableFundRequest.search($(this).val()).draw();
                }
            }
        }
    });


    // Add event listener for opening and closing details
    $('#table-advance-fund-request tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = tableFundRequest.row(tr);
        var tableId = 'posts-' + row.data().id;

        if (row.child.isShown()) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        } else {
            // Open this row
            row.child(template(row.data())).show();
            initTable(tableId, row.data());
            tr.addClass('shown');
            // tr.next().find('td').addClass('no-padding bg-white');
        }
    });

    function initTable(tableId, data) {
        $('#' + tableId).DataTable({
            processing: true,
            serverSide: true,
            order: [[0, 'desc']],
            // ajax: 'pending_fund_details_endorsements',
            ajax:
                {
                    url: "/pending_fund_details_endorsements",
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

        var template_success = Handlebars.compile($("#details-template-success").html());
    tableFundSuccess = $('#table-advance-fund-success').DataTable(
        {
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "ajax": "/dispatcher-table-fund-success",
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
                    {
                        data: function (data)
                        {
                            return data.fci
                        },
                        "name": 'CiName.name'
                    },
                    {
                        data: function (data)
                        {
                            return 'All';
                        },
                        "name": 'fund_requests.id'
                    },
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
                            return atob(data.fund_amount);
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
                    {
                        data: function (data)
                        {
                            return data.dispatcher_request_date;
                        },
                        "name": 'fund_requests.dispatcher_request_date'
                    },
                    {data: 'status_button', name: 'fund_requests.id'}

                    // {
                    //     data: function (data)
                    //     {
                    //         // console.log(data.status);
                    //
                    //         if(data.status == '' || data.status_atm == '')
                    //         {
                    //             return '<button class="btn btn-xs btn-warning btn-block">WAITING FOR RECEIVER</button>'+
                    //                 '<button class="btn btn-xs btn-info btn-block" name="'+data.fci+':'+data.fci_id+'" id="btn_open_modal_add_req" data-toggle="modal" data-target="#modal_additional_fund_request" value="'+data.id+'">ADDITIONAL REQUEST</button>';
                    //
                    //
                    //         }
                    //         else
                    //         {
                    //             return '<button class="btn btn-xs btn-success btn-block">UPLOADED</button>'+
                    //                 '<button class="btn btn-xs btn-info btn-block" name="'+data.fci+':'+data.fci_id+'" id="btn_open_modal_add_req" data-toggle="modal" data-target="#modal_additional_fund_request" value="'+data.id+'">ADDITIONAL REQUEST</button>';
                    //
                    //         }
                    //     },
                    //     name: 'fund_requests.id',
                    //     "searchable": false
                    // }
                ],
            "order": [[1, 'desc']],
            "pageLength": 10,
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

    $('#table-advance-fund-success_filter input').unbind();
    $('#table-advance-fund-success_filter input').bind('keyup change',function (e) {

        if($(this).is(':focus'))
        {
            if (e.keyCode == 13) {
                tableFundSuccess.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '') {
                    tableFundSuccess.search($(this).val()).draw();
                }
            }
        }
    });

    // Add event listener for opening and closing details
    $('#table-advance-fund-success tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = tableFundSuccess.row(tr);
        var tableId = 'success_posts-' + row.data().id;

        if (row.child.isShown()) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        } else {
            // Open this row
            row.child(template_success(row.data())).show();
            initTable_success(tableId, row.data());
            tr.addClass('shown');
            // tr.next().find('td').addClass('no-padding bg-white');
        }
    });

    function initTable_success(tableId, data) {
        $('#' + tableId).DataTable({
            processing: true,
            serverSide: true,
            order: [[0, 'desc']],
            // ajax: 'pending_fund_details_endorsements',
            ajax:
                {
                    url: "/pending_success_details_endorsements",
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


    var template_disapproved = Handlebars.compile($("#details-template-disapproved").html());
    tableFundDisapproved = $('#table-advance-fund-disapproved').DataTable(
        {
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "ajax": "/dispatcher-get-fund-disapproved-table",
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
                    {
                        data: function (data)
                        {
                            return data.fci
                        },
                        "name": 'CiName.name'
                    },
                    {
                        data: function (data)
                        {
                            return 'All';
                        },
                        "name": 'fund_requests.id'
                    },
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
                            return atob(data.fund_amount);
                        },
                        "name": 'fund_requests.fund_amount'
                    },
                    {data: 'count', name: 'fund_requests.id'},
                    // {
                    //     data: function (data)
                    //     {
                    //         return data.count;
                    //         // return 'qq';
                    //
                    //     },
                    //     "name": 'count.type'
                    // },
                    {
                        data: function (data)
                        {
                            return data.dispatcher_request_date;
                        },
                        "name": 'fund_requests.dispatcher_request_date'
                    },
                    {
                        data: function (data)
                        {
                            if(data.sao_status=='DISAPPROVED')
                            {
                                return '<button class="btn btn-xs btn-danger btn-block">DISAPPROVED BY SAO</button>';
                            }
                            else if(data.finance_status=='DISAPPROVED')
                            {
                                return '<button class="btn btn-xs btn-danger btn-block">DISAPPROVED BY FINANCE</button>';
                            }
                        },
                        name: 'fund_requests.id',
                        "searchable": false
                    }
                ],
            "order": [[1, 'desc']],
            "pageLength": 10,
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

    $('#table-advance-fund-disapproved_filter input').unbind();
    $('#table-advance-fund-disapproved_filter input').bind('keyup change',function (e) {

        if($(this).is(':focus'))
        {
            if (e.keyCode == 13) {
                tableFundDisapproved.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '') {
                    tableFundDisapproved.search($(this).val()).draw();
                }
            }
        }
    });



    // Add event listener for opening and closing details
    $('#table-advance-fund-disapproved tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = tableFundDisapproved.row(tr);
        var tableId = 'disapproved_posts-' + row.data().id;

        if (row.child.isShown()) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        } else {
            // Open this row
            row.child(template_disapproved(row.data())).show();
            initTable_disapproved(tableId, row.data());
            tr.addClass('shown');
            // tr.next().find('td').addClass('no-padding bg-white');
        }
    });

    function initTable_disapproved(tableId, data) {
        $('#' + tableId).DataTable({
            processing: true,
            serverSide: true,
            order: [[0, 'desc']],
            // ajax: 'pending_fund_details_endorsements',
            ajax:
                {
                    url: "/pending_disapproved_details_endorsements",
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


    var template_cancel = Handlebars.compile($("#details-template-cancel").html());
    tableFundCancelled = $('#table-advance-fund-cancelled').DataTable(
        {
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "ajax": "/dispatcher-get-fund-cancelled-table",
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
                    {
                        data: function (data)
                        {
                            return data.fci
                        },
                        "name": 'CiName.name'
                    },
                    {
                        data: function (data)
                        {
                            return 'All';
                        },
                        "name": 'fund_requests.id'
                    },
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
                            return atob(data.fund_amount);
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
                    {
                        data: function (data)
                        {
                            if(data.dispatcher_request_date != '')
                            {
                                return data.dispatcher_request_date;
                            }
                            else if(data.dispatcher_request_date != null)
                            {
                                return data.dispatcher_request_date;
                            }
                            else
                            {
                                return data.sao_logs_date_time;
                            }
                        },
                        "name": 'fund_requests.dispatcher_request_date'
                    },
                    {
                        data: function (data)
                        {
                            return '<button class="btn btn-xs btn-danger btn-block">Cancelled</button>';
                        },
                        "name": 'fund_requests.id',
                        "searchable": false
                    }
                ],
            "order": [[1, 'desc']],
            "pageLength": 10,
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

    $('#table-advance-fund-cancelled_filter input').unbind();
    $('#table-advance-fund-cancelled_filter input').bind('keyup change',function (e) {

        if($(this).is(':focus'))
        {
            if (e.keyCode == 13) {
                tableFundCancelled.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '') {
                    tableFundCancelled.search($(this).val()).draw();
                }
            }
        }
    });

    // Add event listener for opening and closing details
    $('#table-advance-fund-cancelled tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = tableFundCancelled.row(tr);
        var tableId = 'cancel_posts-' + row.data().id;

        if (row.child.isShown()) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        } else {
            // Open this row
            row.child(template_cancel(row.data())).show();
            initTable_cancel(tableId, row.data());
            tr.addClass('shown');
            // tr.next().find('td').addClass('no-padding bg-white');
        }
    });

    function initTable_cancel(tableId, data) {
        $('#' + tableId).DataTable({
            processing: true,
            serverSide: true,
            order: [[0, 'desc']],
            // ajax: 'pending_fund_details_endorsements',
            ajax:
                {
                    url: "/pending_cancel_details_endorsements",
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

    var template_history = Handlebars.compile($("#details-template-success").html());
    tableFundHistory = $('#table-disp-historical-archive').DataTable(
        {
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "ajax":
            {
                type: 'get',
                url: "/dispatcher-table-fund-history",
                data: function (d)
                {
                    d.muni_id = $('#historical_muni_id').val();
                }
            },
            // "ajax": "/dispatcher-table-fund-history",
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
                    {
                        data: function (data)
                        {
                            return data.fci
                        },
                        "name": 'CiName.name'
                    },
                    {
                        data : function address(data)
                        {
                            return data.address_edit.slice(0, -2);
                        },
                        "name": 'endorsements.address'
                    },
                    {
                        data: function (data)
                        {
                            return atob(data.fund_amount);
                        },
                        "name": 'fund_requests.fund_amount'
                    },
                    {
                        data: function (data)
                        {
                            return data.dispatcher_request_date;
                        },
                        "name": 'fund_requests.dispatcher_request_date'
                    }
                ],
            "order": [[1, 'desc']],
            "pageLength": 10,
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

    $('#table-disp-historical-archive_filter input').unbind();
    $('#table-disp-historical-archive_filter input').bind('keyup change',function (e) {

        if($(this).is(':focus'))
        {
            if (e.keyCode == 13) {
                tableFundHistory.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '') {
                    tableFundHistory.search($(this).val()).draw();
                }
            }
        }
    });

    $('#table-disp-historical-archive tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = tableFundHistory.row(tr);
        var tableId = 'success_posts-' + row.data().id;

        if (row.child.isShown()) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        } else {
            // Open this row
            row.child(template_history(row.data())).show();
            initTable_success(tableId, row.data());
            tr.addClass('shown');
            // tr.next().find('td').addClass('no-padding bg-white');
        }
    });
}


var fund_id;
var ci_id;

$('#table-advance-fund-request').on('click','#btn_open_modal_add_req',function () {

    fund_id = $(this).val();
    var split = $(this).attr('name').split(':');
    var getname = split[0];
    ci_id = split[1];
    $('#span_info_add_request').html('ID :<b> '+$(this).val()+'</b><br>' +
        'FCI NAME: <b>'+getname+'</b>');

});

$('#table-advance-fund-success').on('click','#btn_open_modal_add_req',function () {

    fund_id = $(this).val();
    var split = $(this).attr('name').split(':');
    var getname = split[0];
    ci_id = split[1];
    $('#span_info_add_request').html('ID :<b> '+$(this).val()+'</b><br>' +
        'FCI NAME :  <b>'+getname+'</b>');

});


$('#shell_req_add').click(function () {

    $('#txtFundAmount_add_label').removeAttr('hidden');

});

$('#normal_req_add').click(function () {

    $('#txtFundAmount_add_label').attr('hidden','hidden');

});


$('#btn_add_req').on('click',function (e)
{
    if($('#txtFundAmount_add').val()<=0)
    {
        alert('Fund Amount Request must be greater than 0');
    }
    else
    {
        send_req_add()
    }


    function send_req_add()
    {

        var formData = new FormData();

        // console.log('before send: '+$('#selFciName').val());

        formData.append('fund_id',fund_id);
        formData.append('selFciName',ci_id);
        formData.append('txtFundAmount',$('#txtFundAmount_add').val());
        formData.append('txtFundRemarks',$('#txtFundRemarks_add').val());

        $.ajax
        ({
            method: 'post',
            url: 'dispatcher-send-request-add-fund',
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

    }
});

$('#historical_muni_id').change(function()
{
    console.log($(this).val());
    tableFundHistory.draw();
});