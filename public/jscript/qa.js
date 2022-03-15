var activeTab1 = '';

var tele_ci_gen_table = '';
var tele_ci_gen_table_array = [];
var tele_ci_gen_table_title = 0;
var tele_ci_gen_table_bool = false;

var tele_ci_gen_table2 = '';
var tele_ci_gen_table_array2 = [];
var tele_ci_gen_table_title2 = 0;
var tele_ci_gen_table_bool2 = false;

$.ajaxSetup
({
    headers:
        {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
});

$(document).ready(function()
{
    $('.datepickerr').datepicker();
});

$('.qa_leftside_class').on('click', function ()
{
    var gethref = $(this).attr('href');
    if(gethref == '#qa_bi_accnt_tracker')
    {
        if($(''+gethref+'').hasClass('active'))
        {
            console.log('do nothing');
            activeTab1 = 'qa_bi_accnt_tracker';

        }
        else if(tele_ci_gen_table_bool)
        {
            console.log('already loaded');
            activeTab1 = 'qa_bi_accnt_tracker';
        }
        else if(tele_ci_gen_table_bool == false)
        {
            tele_ci_gen_table_bool = true;
            activeTab1 = 'qa_bi_accnt_tracker';
            get_general_mon_table();
            console.log('run this shit');
        }
    }
});

function get_general_mon_table()
{
    $('#management_tele_ci_gen_mon_table thead th').each(function()
    {
        tele_ci_gen_table_array[tele_ci_gen_table_title] = $(this).text();
        tele_ci_gen_table_title++;
        var title = $(this).text();
        $(this).html(title+'<br><input type="text" placeholder="Search" style="position: relative; width: 100%">');
    });

    tele_ci_gen_table = $('#management_tele_ci_gen_mon_table').DataTable
    ({
        "responsive": true,
        "processing": true,
        "serverSide": true,
        "ajax":
            {
                url: "management_get_general_mon_table_ccbank",
                data: function (d)
                {

                    d.min_date_endorsed = $('#gen_mon_min').val();
                    d.max_date_endorsed = $('#gen_mon_max').val();
                }
            },
        dom: 'Blfrtip',
        buttons:
            [

                {
                    extend: 'excel',
                    exportOptions:
                        {
                            columns: ':visible',
                            format:
                                {
                                    header:  function (dt, idx, title)
                                    {
                                        return tele_ci_gen_table_array[(idx)];
                                    }
                                }
                        },
                    customize: function ( xlsx ){
                        var sheet = xlsx.xl.worksheets['sheet1.xml'];

                        var loop = 0;
                        $('row', sheet).each(function () {

                            $(this).find("c").attr('s', '55');
                            $('row:first c', sheet).attr('s', '51');
                            loop++;
                        });
                    }
                }
            ],
        "columns":
            [
                {data: 'endorse_id', name: 'bi_endorsements.id'},
                {data: 'tor', name: 'bi_endorsements.type_of_endorsement_bank'},
                {
                    data : function d_e(data)
                    {
                        var date_time = data.date_time_endorsed;

                        var split = date_time.split(' ');

                        return split[0];
                    },
                    name : 'bi_endorsements.created_at'
                },
                {
                    data : function t_e(data)
                    {
                        var date_time = data.date_time_endorsed;

                        var split = date_time.split(' ');

                        var time = split[1].split(':');

                        var finall = time[0] + ':' + time[1];

                        return finall;
                    },
                    name : 'bi_endorsements.created_at'
                },
                {data: 'project', name: 'bi_endorsements.project'},
                {data: 'account_name', name: 'bi_endorsements.account_name'},
                {data: 'assigned_tele', name: 'bi_endorsements.id', orderable: 'false', searchable: 'false'},
                {data: 'poc', name: 'bi_endorsements.endorser_poc'},
                {data: 'attachments', name: 'bi_endorsements.attach_1'},
                {data: 'due', name: 'bi_endorsements.id', orderable: 'false', searchable: 'false'},
                {
                    data: function contact_details(data)
                    {
                        if(data.tele_stat == 'Contacted')
                        {
                            if(data.contact_details == 'Refused to be interviewed')
                            {
                                return '<p style="font-style: italic">'+data.contact_details+'</p>';
                            }
                            else if(data.contact_details == 'Verified applying')
                            {
                                return '<p style="font-style: italic">'+data.contact_details+'</p>';
                            }
                            else
                            {
                                return '<p style="font-style: italic">'+data.contact_details+'</p>';
                            }
                        }
                        else
                        {
                            return 'N/A';
                        }
                    },
                    'name': 'bi_endorsements.verify_tele_status_details',
                    'orderable' : false
                },
                {
                    data : function action(data) {
                        var buttons = '<a id="'+data.endorse_id+'" class="btn_view_information_bi btn btn-xs btn-info btn-block" data-toggle="modal" data-target="" ><i class="glyphicon glyphicon-film"></i> View Information</a>';

                        if(data.status == 10)
                        {
                            return '<a href="bi-client-dl-report-file?id='+btoa(data.endorse_id)+'" class="btn btn-success btn-block btn-xs" target="_blank"><i class="glyphicon glyphicon-download-alt"></i> Download Finished Report</a>' + buttons;
                        }
                        else if(data.status == 3 || data.status == 24)
                        {
                            return '<a href="cc-sao-tele-dl-report?id='+btoa(data.endorse_id)+'" class="btn btn-success btn-block btn-xs" target="_blank"><i class="glyphicon glyphicon-download-alt"></i> Download Televerifier Report</a>' + buttons;
                        }
                        else
                        {
                            return buttons;
                        }
                    },
                    'name' : 'action',
                    'searchable' : false,
                    'orderable' : false
                }
            ],

        "order": [[0, 'desc']],
        "pageLength": 10,
        "lengthMenu": [[2, 10, 25, 50, -1], ['2 rows', '10 rows', '25 rows', '50 rows', 'Show all']],
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

    $('#management_tele_ci_gen_mon_table_filter input').unbind();
    $('#management_tele_ci_gen_mon_table_filter input').bind('keyup change',function (e) {

        if($(this).is(':focus'))
        {
            if (e.keyCode == 13) {
                tele_ci_gen_table.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '') {
                    tele_ci_gen_table.search($(this).val()).draw();
                }
            }
        }
    });
}

$('.gen_mon_date_range_click').click(function()
{
    var date = new Date();
    var day = date.getDate();
    var month = (date.getMonth() + 1);
    if(day <= 9)
    {
        day = '0'+day;
    }

    if(month <= 9)
    {
        month = '0'+month;
    }

    var newdate = date.getFullYear() + '-' + month + '-' + day;

    if($(this).val() === 'all')
    {
        $('#gen_mon_date_pick_holder').hide();
        $('#gen_mon_max').val('6000-01-01');
        $('#gen_mon_min').val('2015-01-01');
    }
    else
    {
        $('#gen_mon_date_pick_holder').show();
        $('#gen_mon_min').val(newdate);
        $('#gen_mon_max').val(newdate);
    }

    tele_ci_gen_table.draw();
});

$('.gen_mon_date_range_dates').change(function()
{
    tele_ci_gen_table.draw();
});

$('.cc_accnt_tracker').click(function ()
{
    var gethref = $(this).attr('href');
    if (gethref == '#cc_gen_tab1') {

        if ($('' + gethref + '').hasClass('active')) {
            console.log('do nothing');
            activeSide = 'cc_gen_tab1';
        }
        else if (tele_ci_gen_table_bool) {
            console.log('already loaded');
            activeSide = 'cc_gen_tab1';
        }
        else if (!tele_ci_gen_table_bool) {
            tele_ci_gen_table_bool = true;
            activeSide = 'cc_gen_tab1';
            get_general_mon_table();
        }
    }
    else if (gethref == '#cc_gen_tab2') {

        if ($('' + gethref + '').hasClass('active')) {
            console.log('do nothing');
            activeSide = 'tele_ci_gen_table_bool2';
        }
        else if (tele_ci_gen_table_bool2) {
            console.log('already loaded');
            activeSide = 'tele_ci_gen_table_bool2';
        }
        else if (!tele_ci_gen_table_bool2) {
            tele_ci_gen_table_bool2 = true;
            activeSide = 'tele_ci_gen_table_bool2';
            get_general_mon_table_2();
        }
    }
});

function get_general_mon_table_2()
{
    $('#management_tele_ci_gen_mon_table_cc thead th').each(function()
    {
        tele_ci_gen_table_array2[tele_ci_gen_table_title2] = $(this).text();
        tele_ci_gen_table_title2++;
        var title = $(this).text();
        $(this).html(title+'<br><input type="text" placeholder="Search" style="position: relative; width: 100%">');
    });

    tele_ci_gen_table2 = $('#management_tele_ci_gen_mon_table_cc').DataTable
    ({
        "responsive": true,
        "processing": true,
        "serverSide": true,
        "ajax":
            {
                url: "management_get_general_mon_table_cc",
                data: function (d)
                {

                    d.min_date_endorsed = $('#gen_mon_min_cc').val();
                    d.max_date_endorsed = $('#gen_mon_max_cc').val();
                }
            },
        dom: 'Blfrtip',
        buttons:
            [

                {
                    extend: 'excel',
                    exportOptions:
                        {
                            columns: ':visible',
                            format:
                                {
                                    header:  function (dt, idx, title)
                                    {
                                        return tele_ci_gen_table_array2[(idx)];
                                    }
                                }
                        },
                    customize: function ( xlsx ){
                        var sheet = xlsx.xl.worksheets['sheet1.xml'];

                        var loop = 0;
                        $('row', sheet).each(function () {

                            $(this).find("c").attr('s', '55');
                            $('row:first c', sheet).attr('s', '51');
                            loop++;
                        });
                    }
                }
            ],
        "columns":
            [
                {data: 'endorse_id', name: 'bi_endorsements.id'},
                {data: 'site', name: 'bi_endorsements.bi_account_name'},
                {
                    data : function d_e(data)
                    {
                        var date_time = data.date_time_endorsed;

                        var split = date_time.split(' ');

                        var time = split[1].split(':');

                        return split[0];
                    },
                    name : 'bi_endorsements.created_at'
                },
                {
                    data : function t_e(data)
                    {
                        var date_time = data.date_time_endorsed;

                        var split = date_time.split(' ');

                        var time = split[1].split(':');

                        var final = time[0] + ':' + time[1];

                        return final;
                    },
                    name : 'bi_endorsements.created_at'
                },
                {data: 'project', name: 'bi_endorsements.project'},
                {data: 'account_name', name: 'bi_endorsements.account_name'},
                {data: 'package', name: 'bi_endorsements.package'},
                {data: 'assigned_tele', name: 'bi_endorsements.id', orderable: 'false', searchable: 'false'},
                {data: 'poc', name: 'bi_endorsements.endorser_poc'},
                {data: 'attachments', name: 'bi_endorsements.attach_1'},
                {data: 'due', name: 'bi_endorsements.id', orderable: 'false', searchable: 'false'},
                {
                    data : function action(data) {
                        var buttons = '<a id="'+data.endorse_id+'" class="btn_view_information_bi btn btn-xs btn-info btn-block" data-toggle="modal" data-target="" ><i class="glyphicon glyphicon-film"></i> View Information</a>';

                        if(data.status == 10)
                        {
                            return '<a href="bi-client-dl-report-file?id='+btoa(data.endorse_id)+'" class="btn btn-success btn-block btn-xs" target="_blank"><i class="glyphicon glyphicon-download-alt"></i> Download Finished Report</a>' + buttons;
                        }
                        else if(data.status == 3 || data.status == 24)
                        {
                            return '<a href="cc-sao-tele-dl-report?id='+btoa(data.endorse_id)+'" class="btn btn-success btn-block btn-xs" target="_blank"><i class="glyphicon glyphicon-download-alt"></i> Download Televerifier Report</a>' + buttons;
                        }
                        else
                        {
                            return buttons;
                        }
                    },
                    'name' : 'action',
                    'searchable' : false,
                    'orderable' : false
                }
            ],

        "order": [[0, 'desc']],
        "pageLength": 10,
        "lengthMenu": [[2, 10, 25, 50, -1], ['2 rows', '10 rows', '25 rows', '50 rows', 'Show all']],
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

    $('#management_tele_ci_gen_mon_table_cc_filter input').unbind();
    $('#management_tele_ci_gen_mon_table_cc_filter input').bind('keyup change',function (e) {

        if($(this).is(':focus'))
        {
            if (e.keyCode == 13) {
                tele_ci_gen_table2.search($(this).val()).draw();
            }
            else if (e.keyCode === 8)
            {
                if ($(this).val() == '') {
                    tele_ci_gen_table2.search($(this).val()).draw();
                }
            }
        }
    });
}

$('.gen_mon_date_range_click_cc').click(function()
{
    var date = new Date();
    var day = date.getDate();
    var month = (date.getMonth() + 1);
    if(day <= 9)
    {
        day = '0'+day;
    }

    if(month <= 9)
    {
        month = '0'+month;
    }

    var newdate = date.getFullYear() + '-' + month + '-' + day;

    if($(this).val() === 'all')
    {
        $('#gen_mon_date_pick_holder_cc').hide();
        $('#gen_mon_max_cc').val('6000-01-01');
        $('#gen_mon_min_cc').val('2015-01-01');
    }
    else
    {
        $('#gen_mon_date_pick_holder_cc').show();
        $('#gen_mon_min_cc').val(newdate);
        $('#gen_mon_max_cc').val(newdate);
    }

    tele_ci_gen_table2.draw();
});

$('.gen_mon_date_range_dates_cc').change(function()
{
    tele_ci_gen_table2.draw();
});