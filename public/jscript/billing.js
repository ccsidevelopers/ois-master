var tableReport;
var tableManage;
var titleee=[];
var title;
var i = 0;
var which_is_active = 'billing_dashboard_tab';
var billing_dashboard_tab_bool = false;
var billing_manage_tab_bool = true;
var billing_rate_tab_bool = false;


// zoom();
// function zoom() {
//     document.body.style.zoom = "80%"
// }


$(document).ready(function () {

    billing_report_table();

    $('.billing_a_class').click(function () {

        var gethref = $(this).attr('href');

        console.log(gethref);

        if(gethref == '#billing_dashboard_tab')
        {
            if( $(''+gethref+'').hasClass('active'))
            {
                console.log('do nothing');
                which_is_active = 'billing_dashboard_tab';

            }
            else if(billing_dashboard_tab_bool)
            {
                console.log('already loaded');
                which_is_active = 'billing_dashboard_tab';

            }
            else if(billing_dashboard_tab_bool == false)
            {
                billing_dashboard_tab_bool = true;
                which_is_active = 'billing_dashboard_tab';
                // dash_map_init();

            }
        }
        else if(gethref == '#billing_manage_tab')
        {
            if( $(''+gethref+'').hasClass('active'))
            {
                console.log('do nothing');
                which_is_active = 'billing_manage_tab';

            }
            else if(billing_manage_tab_bool)
            {
                console.log('already loaded');
                which_is_active = 'billing_manage_tab';

            }
            else if(billing_manage_tab_bool == false)
            {
                billing_manage_tab_bool = true;
                which_is_active = 'billing_manage_tab';
                // billing_report_table();

            }
        }
        else if(gethref == '#billing_rate_tab')
        {
            if( $(''+gethref+'').hasClass('active'))
            {
                console.log('do nothing');
                which_is_active = 'billing_rate_tab';

            }
            else if(billing_rate_tab_bool)
            {
                console.log('already loaded');
                which_is_active = 'billing_rate_tab';

            }
            else if(billing_rate_tab_bool == false)
            {
                billing_rate_tab_bool = true;
                which_is_active = 'billing_rate_tab';
                billing_information_table();

            }
        }
    });


    $(document).contextmenu({
        delegate: "#billing-table-rate td",
        menu: [
            {
                title: "<b>Billing</b>",
                children: [
                    {
                        title: 'BILLED',
                        cmd: 'Billed'
                    },
                    {
                        title: '//////////////////////////////////////',
                        disabled: true
                    },
                    {
                        title: 'UNBILLED',
                        cmd: 'Unbill'
                    }
                ]
            },
            {
                title: '------------',
                disabled: true
            },
            {
                title: "<b>Apply Rule</b>",
                children: [
                    {
                        title: '<b>TFS<b>',
                        children:[
                            {
                                title: '1. Same City/Municipality not exceeding two location, (One Charge)',
                                cmd: 'Rule: #1'
                            },
                            {
                                title: '//////////////////////////////////////',
                                disabled: true
                            },
                            {
                                title: '2. Same address & Date endorsed per subject. (One Charge)',
                                cmd: 'Rule: #2'
                            },
                            {
                                title: '//////////////////////////////////////',
                                disabled: true
                            },
                            {
                                title: '3. LATE PENALTY (-100php)',
                                cmd: 'Rule: #3'
                            },
                            {
                                title: '//////////////////////////////////////',
                                disabled: true
                            },
                            {
                                title: '4. Accounts exceeding two locations addition',
                                children: [
                                    {
                                        title: 'For Metro Manila (+65php)',
                                        cmd: '65php'
                                    },
                                    {
                                        title: '//////////////////////////////////////',
                                        disabled: true
                                    },
                                    {
                                        title: 'For Province (+100php)',
                                        cmd: '100php'
                                    }
                                ]
                            },
                            {
                                title: '//////////////////////////////////////',
                                disabled: true
                            },
                            {
                                title: '5. Accounts with same address/date endorsed under a same subject with penalty and additional',
                                cmd: 'Rule: #5'
                            }
                        ]
                    },
                    {
                        title: '<b>CTBC<b>'
                    },
                    {
                        title: '<b>Sterling<b>'
                    },
                    {
                        title: '<b>USB<b>'
                    },
                    {
                        title: '<b>UCPB<b>'
                    },
                    {
                        title: '<b>PNB<b>'
                    },
                    {
                        title: '<b>BDO<b>'
                    },
                    {
                        title: '<b>Maybank<b>'
                    },
                    {
                        title: '<b>CBS<b>'
                    },
                    {
                        title: '<b>Eastwest<b>'
                    },
                    {
                        title: '<b>PBCOM<b>'
                    },
                    {
                        title: '<b>Mitsubishi<b>'
                    },
                    {
                        title: '<b>Insular<b>'
                    }
                ]
                // [{}]
            },
            {
                title: '////////////////////',
                disabled: true
            },
            {
                title:'<b>Undo Rule<b>',
                cmd: 'Undo'
            }
        ],
        select: function (event, ui) {
            if (ui.cmd === 'Billed') {
                console.log('billed');

                var ids = $.map(tableReport.rows('.selected').data(), function (item) {
                    return item.id
                });

                console.log(ids);

                $.ajax
                ({
                    type: 'get',
                    url: 'billing-management-billed-unbill',
                    data:
                        {
                            'arrayid': ids,
                            'type': 'BILLED'
                        },
                    success: function (data) {
                        tableReport.ajax.reload(null, false);
                        console.log(data);

                    },
                    error: function (data) {
                        console.log('error');
                    }
                });

            }
            else if (ui.cmd === 'Unbill') {
                console.log('unbill');

                var ids = $.map(tableReport.rows('.selected').data(), function (item) {
                    return item.id
                });

                $.ajax
                ({
                    type: 'get',
                    url: 'billing-management-billed-unbill',
                    data:
                        {
                            'arrayid': ids,
                            'type': 'UNBILLED'
                        },
                    success: function (data) {
                        tableReport.ajax.reload(null, false);
                        console.log(data);

                    },
                    error: function (data) {
                        console.log('error');
                    }
                });
                // console.log(ids);
                tableReport.ajax.reload(null, false);
            }
            else if(ui.cmd === 'Rule: #1')
            {
                var idrule = $.map(tableReport.rows('.selected').data(), function (item) {
                    return item.id
                });

                var stats = $.map(tableReport.rows('.selected').data(), function (item) {
                    return item.endorsement_status_external
                });

                var rates = $.map(tableReport.rows('.selected').data(), function (item) {
                    return item.rate
                });


                var appliedrule = $.map(tableReport.rows('.selected').data(), function (item) {
                    return item.appliedrule
                });

                var already = false;

                for(var ctr = 0; ctr < appliedrule.length; ctr++)
                {
                    if (appliedrule[ctr] !== '') {
                        already = true;
                    }
                }


                if(idrule.length >=3 || idrule.length <= 1 || stats[0] === '' || stats[1] === '' || rates[0] === '' || rates[1] === '')
                {
                    alert('This rule is only for two endorsements.')
                }
                else {

                    if (already) {
                        alert('Some rules are already applied in this account. Please try again.')

                    }
                    else {
                        $.ajax
                        ({
                            type: 'get',
                            url: 'billing-management-rule-one-tfs',
                            data:
                                {
                                    'arrayid': idrule
                                },
                            success: function (data) {
                                tableReport.ajax.reload(null, false);
                                console.log(data);

                            },
                            error: function (data) {
                                console.log('error');
                            }
                        });

                    }
                }

            }
            else if(ui.cmd === 'Rule: #2')
            {

                var idrule = $.map(tableReport.rows('.selected').data(), function (item) {
                    return item.id
                });

                var stats = $.map(tableReport.rows('.selected').data(), function (item) {
                    return item.endorsement_status_external
                });

                var rates = $.map(tableReport.rows('.selected').data(), function (item) {
                    return item.rate
                });

                var appliedrule = $.map(tableReport.rows('.selected').data(), function (item) {
                    return item.appliedrule
                });

                var already = false;

                for(var ctr = 0; ctr < appliedrule.length; ctr++)
                {
                    if(appliedrule[ctr] !== '')
                    {
                        already = true;
                    }
                }

                if(idrule.length <= 1 || idrule.length === 2 || stats[0] === '' || stats[1] === '' || rates[0] === '' || rates[1] === '')
                {
                    alert('This rule is only for more than two endorsements.')
                }
                else
                {

                    if(already)
                    {
                        alert('Some rules are already applied in this account. Please try again.')

                    }
                    else
                    {
                        $.ajax
                        ({
                            type: 'get',
                            url: 'billing-management-rule-two-tfs',
                            data:
                                {
                                    'arrayid': idrule
                                },
                            success: function (data) {
                                tableReport.ajax.reload(null, false);
                                console.log(data);

                            },
                            error: function (data) {
                                console.log('error');
                            }
                        });
                    }
                }

            }
            else if (ui.cmd === 'Rule: #3')
            {
                var ids = $.map(tableReport.rows('.selected').data(), function (item) {
                    return item.id
                });
                var rate = $.map(tableReport.rows('.selected').data(), function (item) {
                    return item.rate - 100
                });

                var status = $.map(tableReport.rows('.selected').data(), function (item) {
                    return item.appliedrule
                });

                var statusstatus = $.map(tableReport.rows('.selected').data(), function (item) {
                    return item.endorsement_status_external
                });

                var appliedrule = $.map(tableReport.rows('.selected').data(), function (item) {
                    return item.appliedrule
                });

                var already = false;

                for(var ctr = 0; ctr < appliedrule.length; ctr++)
                {
                    if (appliedrule[ctr] !== '') {
                        already = true;
                    }
                }



                var check = true;
                // console.log(statusstatus);
                for(ctr=0; ctr<status.length; ctr++)
                {
                    if(status[ctr].length <=0)
                    {
                        check = false;
                    }

                    if(statusstatus[ctr] === 'TAT')
                    {
                        check = true;

                    }
                }

                if(check)
                {
                    alert('One or more than one endorsements are not OVERDUE or already deducted.');
                }
                else {

                    if (already) {
                        alert('Some rules are already applied in this account. Please try again.')

                    }
                    else {
                        $.ajax
                        ({
                            type: 'get',
                            url: 'billing-management-rule-three-tfs',
                            data:
                                {
                                    'arrayid': ids,
                                    'ratededuc': rate
                                },
                            success: function (data) {
                                tableReport.ajax.reload(null, false);
                                console.log(data);

                            },
                            error: function (data) {
                                console.log('error');
                            }
                        });
                    }
                }
            }
            else if(ui.cmd === '65php')
            {
                var ids = $.map(tableReport.rows('.selected').data(), function (item) {
                    return item.id
                });
                var rate = $.map(tableReport.rows('.selected').data(), function (item) {
                    return item.rate
                });

                var status = $.map(tableReport.rows('.selected').data(), function (item) {
                    return item.appliedrule
                });

                var statusstatus = $.map(tableReport.rows('.selected').data(), function (item) {
                    return item.endorsement_status_external
                });



                var already = true;
                var check = true;
                // console.log(statusstatus);
                var ratetoadd = [];

                for(ctr=0; ctr<status.length; ctr++)
                {

                    ratetoadd[ctr] = parseInt(rate[ctr]) + 65;

                    if(status[ctr].length <=0)
                    {
                        check = false;

                    }
                    else
                    {
                        already = false;
                    }

                    if(statusstatus[ctr] === 'OVERDUE' || ids.length <= 2)
                    {
                        check = true;

                    }
                }

                if(check)
                {
                    alert('To apply this rule, select atleast more than two (2) endorsements. Accounts must be TAT');
                }
                else
                {
                    if(already === false)
                    {
                        alert('Some rules are already applied in this account. Please try again.')

                    }
                    else
                    {
                        $.ajax
                        ({
                            type: 'get',
                            url: 'billing-management-rule-four-tfs-manila',
                            data:
                                {
                                    'arrayid': ids,
                                    'ratededuc':ratetoadd
                                },
                            success: function (data) {
                                tableReport.ajax.reload(null, false);
                                console.log(data);

                            },
                            error: function (data) {
                                console.log('error');
                            }
                        });
                    }

                }
            }
            else if (ui.cmd === '100php')
            {
                var ids = $.map(tableReport.rows('.selected').data(), function (item) {
                    return item.id
                });
                var rate = $.map(tableReport.rows('.selected').data(), function (item) {
                    return item.rate
                });

                var status = $.map(tableReport.rows('.selected').data(), function (item) {
                    return item.appliedrule
                });

                var statusstatus = $.map(tableReport.rows('.selected').data(), function (item) {
                    return item.endorsement_status_external
                });

                var check = true;
                var already = true;

                // console.log(statusstatus);
                var ratetoadd = [];

                for(ctr=0; ctr<status.length; ctr++)
                {

                    ratetoadd[ctr] = parseInt(rate[ctr]) + 100;

                    if(status[ctr].length <=0)
                    {
                        check = false;
                        // already = false;

                    }
                    else
                    {
                        already = false;
                    }

                    if(statusstatus[ctr] === 'OVERDUE' || ids.length <= 2)
                    {
                        check = true;

                    }
                }

                if(check)
                {
                    alert('To apply this rule, select atleast more than two (2) endorsements. Accounts must be TAT');
                }
                else {

                    if (already === false) {
                        alert('Some rules are already applied in this account. Please try again.')

                    }
                    else {
                        $.ajax
                        ({
                            type: 'get',
                            url: 'billing-management-rule-four-tfs-province',
                            data:
                                {
                                    'arrayid': ids,
                                    'ratededuc': ratetoadd
                                },
                            success: function (data) {
                                tableReport.ajax.reload(null, false);
                                console.log(data);

                            },
                            error: function (data) {
                                console.log('error');
                            }
                        });
                    }
                }
            }
            else if(ui.cmd === 'Undo')
            {
                var ids = $.map(tableReport.rows('.selected').data(), function (item) {
                    return item.id
                });

                var rate = $.map(tableReport.rows('.selected').data(), function (item) {
                    return item.rate
                });

                var rule = $.map(tableReport.rows('.selected').data(), function (item) {
                    return item.appliedrule
                });

                var toundo = [];
                var stop = false;
                var getindexrate = 0;
                for(var ctr=0; ctr<rule.length; ctr++)
                {
                    // toundo[ctr] = rule[ctr]-rate[ctr];

                    var sp;
                    var indexer;

                    if(rule[ctr].indexOf('-') >= 0)
                    {
                        //undo penalties
                        sp = rule[ctr].split('-');
                        indexer = sp[1].substring(0,sp[1].indexOf("PHP")-1);
                        toundo[ctr] = (parseInt(rate[ctr]) + parseInt(indexer));
                        // console.log('rate='+rate[ctr]+'+'+'indexer='+indexer);

                    }
                    else if (rule[ctr].indexOf('+') >= 0)
                    {
                        //undo addition
                        sp = rule[ctr].split('+');
                        indexer = sp[1].substring(0,sp[1].indexOf("PHP")-1);
                        toundo[ctr] = (rate[ctr] - indexer);

                        // console.log(indexer);
                    }
                    else
                    {
                        if(stop === false)
                        {
                            if(rule[ctr]==='Same City/Municipalities')
                            {
                                toundo[ctr] = rate[ctr];
                                getindexrate = ctr;
                                stop = true;
                            }
                        }

                        toundo[ctr] = rate[getindexrate];
                    }


                }

                // console.log('toundo='+toundo);

                $.ajax
                ({
                    type: 'get',
                    url: 'billing-management-rule-undo',
                    data:
                        {
                            'arrayid': ids,
                            'ratededuc':toundo
                        },
                    success: function (data) {
                        tableReport.ajax.reload(null, false);
                        console.log(data);

                    },
                    error: function (data) {
                        console.log('error');
                    }
                });
            }

        }

    });

});


function billing_report_table() {

    $('#billing-table-rate thead th').each(function () {
        titleee[i] = $(this).text();
        i++;
        title = $(this).text();
        $(this).html(title+'<input type="text" placeholder="Search" style="position: relative; width: 100%">');
    });

    tableReport = $('#billing-table-rate').DataTable
    ({

        // "responsive": true,
        "processing": true,
        // "autoWidth": true,
        "serverSide": true,
        "ajax": "/billing-table-report",
        "columns":
            [
                {data: 'id', name: 'endorsements.id'},
                {data: 'date_endorsed', name: 'endorsements.date_endorsed'},
                {data: 'time_endorsed', name: 'endorsements.time_endorsed'},
                {data: 'date_due', name: 'endorsements.date_due'},
                {data: 'time_due', name: 'endorsements.time_due'},
                {data: 'account_name', name: 'endorsements.account_name'},
                {data: 'address', name: 'endorsements.address'},
                {data: 'muni_name', name: 'municipalities.muni_name'},
                {data: 'provinces', name: 'endorsements.provinces'},
                {data: 'type_of_request', name: 'endorsements.type_of_request'},
                // {
                //
                //     data: function actions(data) {
                //
                //         // clearTimeout(times);
                //         // fetchOtherInro();
                //         if(data.type_of_request == 'EVR')
                //         {
                //             return '<b>EVR: </b><br>'+data.evr_name
                //         }
                //         else if(data.type_of_request == 'BVR')
                //         {
                //             return '<b>BVR: </b><br>'+data.bvr_name
                //         }
                //         else {
                //
                //             return '<b>'+data.type_of_request+'</b>';
                //         }
                //
                //
                //     },
                //     'name' : 'endorsements.type_of_request'
                //
                // },
                {data: 'client_name', name: 'endorsements.client_name'},
                {
                    data: function qq(data) {
                        if (data.endorsement_status_external === '') {
                            return '<p style="color: orange">Account still on Proccess</p>';

                        }
                        else {
                            return data.endorsement_status_external;
                        }
                    },
                    "name": 'endorsements.endorsement_status_external'
                },
                {data: 'picture_status', name: 'picture_status'},
                // {data: 'rate', name: 'rate'},
                {
                    data: function asd(data) {
                        if (data.rate === "") {
                            return '<p style="color: red">No rate at this address.</p>';
                        }

                        else
                        {

                            var n = data.rate;
                            convertedRate = n.toLocaleString
                            (
                                undefined, // leave undefined to use the browser's locale,
                                // or use a string like 'en-US' to override it.
                                {minimumFractionDigits: 2}
                            );
                            return convertedRate + ' Php';

                        }
                    },
                    "name": 'endorsements.rate'
                },
                {data: 're_ci', name: 're_ci'},
                {data: 'date_forwarded_to_client', name: 'endorsements.date_forwarded_to_client'},
                {data: 'time_forwarded_to_client', name: 'endorsements.time_forwarded_to_client'},
                {data: 'bill', name: 'endorsements.bill'},
                {data: 'appliedrule', name: 'endorsements.appliedrule'}
            ],
        "order": [[0, 'desc'],[1, 'desc']],
        "pageLength": 100,
        "bSortClasses": false,
        "jQueryUI": false,
        "deferRender": true,
        "fnRowCallback": function(nRow, aData)
        {
            if (aData.appliedrule === 'Same City/Municipalities')
            {
                $('td', nRow).css('border-color', '#b3ffb3');
            }
            else if (aData.appliedrule === 'Penalty (-100 PHP)')
            {
                $('td', nRow).css('border-color', '#ff6060');
            }
            else if (aData.appliedrule === 'Accounts with same address & same date endorsed.')
            {
                $('td', nRow).css('border-color', '#4af9cb');
            }
            else if(aData.appliedrule === 'Additional for Metro Manila (+65 PHP)')
            {
                $('td', nRow).css('border-color', '#425cf4');

            }
            else if(aData.appliedrule === 'Additional for Province (+100 PHP)')
            {
                $('td', nRow).css('border-color', '#8f41f4');

            }
        },
        "lengthMenu": [[2, 25, 50, -1], ['2 rows', '25 rows', '50 rows', 'Show all']],
        dom: 'Blfrtip',
        buttons:
            [
                {
                    text: 'Select All (Visible on page)',
                    action: function ()
                    {
                        selall();
                    }
                },
                {
                    text: 'Deselect All (Visible on page)',
                    action: function ()
                    {
                        desall();

                    }

                },
                'copy', 'excel', 'print',
                {
                    extend: 'colvis',
                    columnText: function (dt, idx, title)
                    {
                        return titleee[(idx)];
                    }
                }
            ],
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

    $('#billing-table-rate_filter input').unbind();
    $('#billing-table-rate_filter input').bind('keyup change',function (e) {

        if($(this).is(':focus'))
        {
            if (e.keyCode == 13) {
                tableReport.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '') {
                    tableReport.search($(this).val()).draw();
                }
            }
        }
    });
    $('#billing-table-rate tbody').on('click', 'tr', function ()
    {
        $(this).toggleClass('selected');
    });

}

function billing_information_table() {

    $('#billing-manage tfoot th').each(function () {
        var title = $(this).text();
        $(this).html(title+'<input type="text" placeholder="Search" style="position: relative; width: 100%">');

    });

    tableManage = $('#billing-manage').DataTable
    ({
        "responsive": true,
        "processing": true,
        "serverSide": true,
        "ajax": "/billing-management",
        "columns":
            [
                // {data: 'muni_name', name: 'municipalities.muni_name'},
                {
                    data: function acti(data) {
                        return '<p style="margin-top: 5px; margin-bottom: 5px; font-size: 15px"><b>' + data.muni_name + '</b></p>';
                    },
                    "name": 'municipalities.muni_name'
                },
                {data: 'prov_name', name: 'provinces.name'},
                {data: 'name', name: 'users.name'},
                // {data: 'rate', name: 'rate'}
                {
                    data: function asd(data) {
                        if (data.rate === "") {
                            return '<p style="color: red">No rate at this address.</p>';
                        }
                        else {

                            var n = data.rate;
                            convertedRate = n.toLocaleString(undefined, {minimumFractionDigits: 2});
                            return convertedRate + ' Php';
                        }
                    },
                    "name": 'rate'
                }
            ],
        "order": [[0, 'desc']],
        "pageLength": 25,
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

    $('#billing-manage_filter input').unbind();
    $('#billing-manage_filter input').bind('keyup change',function (e) {

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

function selall() {
    tableReport.rows().select();
    var ids = $.map(tableReport.rows('.selected').data(), function (item) {
        return item
    });

}

function desall() {
    // tableReport.rows().deselect();
    tableReport.ajax.reload(null, false);

}